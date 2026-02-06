<?php

//require '/home/safar360/public_html/vendor/autoload.php';
//
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;

class exclusiveTour extends clientAuth {

    protected $uniqueCode;
    protected $InfoSearch;
    protected $isInternal;

    private $username;
    private $apiAddress;
    private $model;
    private $modelBase;
    private $logDir = 'exclusiveTour/';

    public function __construct($url = null) {

        parent::__construct();
        $this->init($url);
        $this->model     = Load::library( 'Model' );
        $this->modelBase     = Load::library( 'Model' );
    }

    public function init($url = null) {

        $InfoSources = $this->exclusiveTourAuth();



        if (!empty($InfoSources)):
            $this->username = $InfoSources['Username'];
        endif;
        $this->apiAddress = functions::UrlSource();
        $this->InfoSearch = functions::configDataRoute(!empty($url) ? $url : $_SERVER['REQUEST_URI']);
        $this->isInternal = $this->InfoSearch['isInternal'];

    }

    public function UniqueCode($userName) {

        $url = $this->apiAddress . "Tour/GetCode/" . $userName;
        $JsonArray = array();

        $tickets = functions::curlExecution($url, $JsonArray, 'yes');


        return $tickets['Result']['Value'];

    }

    public function GetPackage($data) {

        $dataSearch = $data['dataSearch'];



        $this->UniqueCode = $this->UniqueCode($this->username);
        $url = $this->apiAddress . "Tour/GetPackage/" . $this->UniqueCode;


        $d['Origin'] = $dataSearch['origin'];
        $d['Destination'] = $dataSearch['destination'];
        $d['DepartureDate'] = $dataSearch['dept_date'];
        $d['ArrivalDate'] = $dataSearch['return_date'];
        $d['UserName'] = $this->username;
        $d['IsInternal'] = $dataSearch['is_internal'];
        $d['Rooms'] = $dataSearch['Rooms'];

        $d['subAgencyId'] = '';
        $agencyInfo = $this->getController('agency')->subAgencyInfo();
        if ($agencyInfo != null && !empty($agencyInfo['sepehr_username']) && !empty($agencyInfo['sepehr_password'])) {
            $d['subAgencyId'] = $agencyInfo['id'];
        }


        $JsonArray = json_encode($d);

        functions::insertLog('url is=> ' . $url . '   give time send request With Code =>' . $this->UniqueCode . ' && Origin:' . $d['Origin'] . ' &&destination:' . $d['Destination'] . 'with data request' . $JsonArray . '\n', 'exclusiveTour');

        $result = functions::curlExecution($url, $JsonArray, 'yes');


        $result['Packages'] = $this->assignAirlineLogos($result['Packages']);
        foreach ($result['Packages'] as $key => $package) {
            $modifiedId = '42' . $package['Hotel']['Id'];
            $localData = $this->getLocalHotelData($modifiedId);
            if($localData){
                $localPic = $localData[0]['logo'] ?: '';
                $localName = $localData[0]['name'] ?: '';
            }

            if ($localPic) {
                $feature_pic = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . $localPic;
                $result['Packages'][$key]['Hotel']['pic'] = $feature_pic;
            }
            if($localName){
                $result['Packages'][$key]['Hotel']['Name'] = $localName;
            }
            unset($localData,$localPic,$localName);
        }


        return json_encode($result);
    }

    public function GetHotelDetail($params)
    {

        $hotelIndex = $params['data']['hotel_id'] ?: null;
        $hotelIndex = '42' . $hotelIndex;
        if (!$hotelIndex) {
            return [];
        }


        /* -------------------------------------------------
         * 1) اطلاعات اصلی هتل
         * ------------------------------------------------- */
        $sqlHotel = "
        SELECT 
            id,
            comment,
            address,
            longitude,
            latitude,
            entry_hour,
            leave_hour,
            rules,
            cancellation_conditions,
            child_conditions
        FROM reservation_hotel_tb
        WHERE sepehr_hotel_code = '{$hotelIndex}'
        LIMIT 1
    ";


        $hotelRow = $this->model->select($sqlHotel);

        if (empty($hotelRow)) {
            return [];
        }

        $hotel = $hotelRow[0];
        $hotelId = $hotel['id'];

        /* -------------------------------------------------
         * 2) Facilities
         * ------------------------------------------------- */
        $sqlFacilities = "
        SELECT 
            F.title,
            F.icon_class
        FROM reservation_hotel_facilities_tb RF
        INNER JOIN reservation_facilities_tb F 
            ON RF.id_facilities = F.id
        WHERE 
            RF.id_hotel = '{$hotelId}'
            AND RF.is_del = 'no'
            AND F.is_del = 'no'
        ORDER BY F.id ASC
    ";

        $facilitiesRes = $this->model->select($sqlFacilities);
        $facilities = [];

        foreach ($facilitiesRes as $row) {
            $facilities[] = [
                $row['title'],
                $row['icon_class']
            ];
        }

        /* -------------------------------------------------
         * 3) Gallery
         * ------------------------------------------------- */
        $sqlGallery = "
        SELECT pic 
        FROM reservation_hotel_gallery_tb
        WHERE id_hotel = '{$hotelId}'
          AND is_del = 'no'
    ";

        $galleryRes = $this->model->select($sqlGallery);
        $gallery = [];

        foreach ($galleryRes as $row) {
            if (!empty($row['pic'])) {
                $fullPath = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . $row['pic'];
                $gallery[] = [
                    'full'      => $fullPath,
                    'medium'    => $fullPath,
                    'thumbnail' => $fullPath
                ];
            }
        }

        /* -------------------------------------------------
         * 4) Rules
         * ------------------------------------------------- */
        $rules = [];

        $checkIn  = !empty($hotel['entry_hour']) ? $hotel['entry_hour'] : '15:00';
        $checkOut = !empty($hotel['leave_hour']) ? $hotel['leave_hour'] : '12:00';

        $rules[] = [
            'Name'        => 'ورود و خروج',
            'Description' => "⏰ تحویل اتاق: {$checkIn}  •  🕒 تخلیه اتاق: {$checkOut}"
        ];

        if (!empty($hotel['rules'])) {
            $rules[] = [
                'Name'        => 'قوانین عمومی',
                'Description' => $hotel['rules']
            ];
        }

        if (!empty($hotel['cancellation_conditions'])) {
            $rules[] = [
                'Name'        => 'کنسلی',
                'Description' => $hotel['cancellation_conditions']
            ];
        }

        if (!empty($hotel['child_conditions'])) {
            $rules[] = [
                'Name'        => 'شرایط کودک',
                'Description' => $hotel['child_conditions']
            ];
        }
        $description = $hotel['comment'] ?: '';
// فقط <br> مجاز باشد
        $description = strip_tags($description, '<br>');
// نرمال‌سازی br ها (اختیاری ولی خوب)
        $description = $hotel['comment'] ?: '';

// فقط <br> مجاز باشد
        $description = strip_tags($description, '<br>');

// نرمال‌سازی <br>
        $description = preg_replace('#<br\s*/?>#i', '<br>', $description);

        $result = [
            'gallery'     => $gallery,
            'facilities'  => $facilities,
            'description' => $description,
            'address'     => $hotel['address'] ?: '',
            'map'         => [
                'latitude'  => $hotel['latitude'] ?: '',
                'longitude' => $hotel['longitude'] ?: '',
            ],
            'rules'       => $rules
        ];
        return json_encode($result);

        /* -------------------------------------------------
         * 5) خروجی نهایی برای Vue
         * ------------------------------------------------- */
    }



    private function getLocalHotelData($hotelIndex)
    {
        $sql = "SELECT logo,name FROM reservation_hotel_tb WHERE sepehr_hotel_code='$hotelIndex' LIMIT 1";
        $row = $this->model->select($sql);
        return $row;
    }

    private function assignAirlineLogos($packages)
    {
        $airlineController = $this->getController('airline');
        foreach ($packages as &$package) {

            if (isset($package['OutputRoutes']['Airline']['Code']) && $package['OutputRoutes']['Airline']['Code'] != '') {
                $code = $package['OutputRoutes']['Airline']['Code'];
                $airline = $airlineController->getAirlineDetailByCode($code);
                $package['OutputRoutes']['Airline']['Logo'] = $airline['photo'];
                $package['OutputRoutes']['Airline']['Name'] = $airline['name_fa'];
            }

            if (isset($package['ReturnRoutes']['Airline']['Code']) && $package['ReturnRoutes']['Airline']['Code'] != '') {
                $code = $package['ReturnRoutes']['Airline']['Code'];
                $airline = $airlineController->getAirlineDetailByCode($code);
                $package['ReturnRoutes']['Airline']['Logo'] = $airline['photo'];
                $package['ReturnRoutes']['Airline']['Name'] = $airline['name_fa'];
            }
        }

        return $packages;
    }

    public function GetPackageDetail($data) {

        $url = $this->apiAddress . "Tour/GetPackageDetail/" . $data['requestNumber'];

        $d['UserName'] = $this->username;
        $d['SourceId'] = $data['sourceId'];
        $d['HotelID'] = $data['hotelId'];

        $d['subAgencyId'] = '';
        $agencyInfo = $this->getController('agency')->subAgencyInfo();
        if ($agencyInfo != null && !empty($agencyInfo['sepehr_username']) && !empty($agencyInfo['sepehr_password'])) {
            $d['subAgencyId'] = $agencyInfo['id'];
        }

        $JsonArray = json_encode($d);

        $result = functions::curlExecution($url, $JsonArray, 'yes');
        $Departure_code = '';

        $airlines_name = $this->airlineList();
        foreach ($result['Packages'] as &$packages) {
            $Arrival_city_code = $packages['OutputRoutes']['Arrival']['Code'];

            $airline_iata = $packages['OutputRoutes']['Airline']['Code'];
            $packages['OutputRoutes']['Airline']['Name'] =
                $airlines_name[$airline_iata][functions::ChangeIndexNameByLanguage(SOFTWARE_LANG, 'name', '_fa')];

            if (!empty($packages['OutputRoutes']['ArrivalDate'])) {
                $ad = explode('-', $packages['OutputRoutes']['ArrivalDate']);
                if (count($ad) === 3) {
                    $packages['OutputRoutes']['PersianArrivalDate'] =
                        dateTimeSetting::gregorian_to_jalali($ad[0], $ad[1], $ad[2], '-');
                } else {
                    $packages['OutputRoutes']['PersianArrivalDate'] = null;
                }
            } else {
                $packages['OutputRoutes']['PersianArrivalDate'] = null;
            }
            $airline_iata_ret = $packages['ReturnRoutes']['Airline']['Code'];
            $packages['ReturnRoutes']['Airline']['Name'] =
                $airlines_name[$airline_iata_ret][functions::ChangeIndexNameByLanguage(SOFTWARE_LANG, 'name', '_fa')];
        }

        // 🔥 اضافه کردن Departure_code به خروجی اصلی
        $output = [
            "Arrival_city_code" => $Arrival_city_code,
            "Packages" => $result['Packages']
        ];

        return json_encode($output);
    }

    public function findNearEntertainment($params)
    {
        $city_code = $params['city_code'];

        $sql = "
        SELECT 
            e.tour_price,
            e.tour_discount_price,
            e.tour_currency_type,
            e.tour_currency_price,
            e.title,
            e.title_en,
            e.factorNumber,
            e.id,
            e.pic
        FROM entertainment_tb AS e
        INNER JOIN reservation_city_tb rcb
            ON rcb.id = e.city_id AND rcb.abbreviation = '{$city_code}'
        WHERE e.validate = 1
          AND e.tour_price IS NOT NULL
          AND e.tour_price > 0
    ";

        $result = $this->model->select($sql);

        $currenciesRaw = (new currencyEquivalent())->ListCurrencyEquivalent();

        // تبدیل به lookup key=CurrencyCode
        $currencies = [];
        foreach ($currenciesRaw as $c) {
            $currencies[$c['CurrencyCode']] = $c;
        }

        // جایگزینی عنوان ارز در خروجی
        foreach ($result as &$row) {
            $code = $row['tour_currency_type'];

            if (isset($currencies[$code])) {
                $row['tour_currency_title'] = $currencies[$code]['CurrencyTitle'];
                $row['tour_currency_title_en'] = $currencies[$code]['CurrencyTitleEn'];
                $row['tour_currency_eq_amount'] = $currencies[$code]['EqAmount'];
            } else {
                $row['tour_currency_title'] = null;
                $row['tour_currency_title_en'] = null;
                $row['tour_currency_eq_amount'] = null;
            }

            $originalPrice = (int) $row['tour_price'];
            $discountPercent = (int) $row['tour_discount_price']; // این درصد است

            if ($discountPercent > 0 && $discountPercent < 100) {

                $discountAmount = ($originalPrice * $discountPercent) / 100;
                $finalPrice = $originalPrice - $discountAmount;
                $row['final_price'] = (int) $finalPrice;
                $row['discount_amount'] = (int) $discountAmount;
                $row['discount_percent'] = $discountPercent;

            } else {
                $row['final_price'] = $originalPrice;
                $row['discount_amount'] = 0;
                $row['discount_percent'] = 0;
            }
        }

        return json_encode($result);
    }




    private function airlineList() {
        $airlines = $this->getController('airline')->airLineList();
        $array_airlines = array();
        foreach ($airlines as $airline) {
            $array_airlines[$airline['abbreviation']] = $airline;
        }
        return $array_airlines;
    }

    public function Lock($data) {


        $d = $data['lockData'];
        $addData = $data['additionalData'];
        $ent = isset($data['entertainments']) ? $data['entertainments'] : [];
        $ent_json = null;
        $ent_ids  = null;
        if (!empty($ent)) {
            $ent_json = json_encode($ent);
            $ent_ids = implode(',', array_column($ent, 'id'));
        }
        $url = $this->apiAddress . "Tour/Lock/" . $data['requestNumber'];
        $d['UserName'] = $this->username;
        $d['subAgencyId'] = '';
        $agencyInfo = $this->getController('agency')->subAgencyInfo();
        if ($agencyInfo != null && !empty($agencyInfo['sepehr_username']) && !empty($agencyInfo['sepehr_password'])) {
            $d['subAgencyId'] = $agencyInfo['id'];
        }
        foreach ($d['Passengers'] as &$Passengers) {
            if (!$Passengers['isIranian']) {
                $Passengers['DateOfBirth'] = functions::ConvertToJalali($Passengers['DateOfBirth']);
            }
            unset($Passengers['isIranian']);
        }
        unset($Passengers);




        $JsonArray = json_encode($d);



        $result = functions::curlExecution($url, $JsonArray, 'yes');
        $result['entertainments'] = $ent;
        $adtCount = count(array_filter($result['Passengers'], function($p) {
            return strtolower($p['PassengerType']) === 'adt';
        }));

        $chdCount = count(array_filter($result['Passengers'], function($p) {
            return strtolower($p['PassengerType']) === 'chd';
        }));

        if (Session::IsLogin()) {
            $userId = Session::getUserId();
        }

        $user =    $this->getModel('membersModel')->getMemberById($userId);

        $model = Load::library('Model');
        $checkSubAgency =  functions::checkExistSubAgency() ;
        if ($user['fk_agency_id'] > 0 || $checkSubAgency) {
            $agencyId = ($checkSubAgency) ? SUB_AGENCY_ID : $user['fk_agency_id'] ;
            $sql_agency = " SELECT * FROM agency_tb WHERE id='{$agencyId}'";
            $agency = $model->load($sql_agency);
        }


        $tourData = [
            'member_id' => $user['id'],
            'member_name' => $user['name'] . ' ' . $user['family'],
            'member_mobile' => $user['mobile'],
            'member_phone' => $user['telephone'],
            'member_email' => $user['email'],
            'agency_id' => $agency['id'],
            'agency_name' => $agency['name_fa'],
            'agency_accountant' => $agency['accountant'],
            'agency_manager' => $agency['manager'],
            'agency_mobile' => $agency['mobile'],
            'origin_city' => $result['Routes']['Output'][0]['DepartureCode'],
            'desti_city' => $result['Routes']['Output'][0]['ArrivalCode'],
            'date_flight' => $result['Routes']['Output'][0]['DepartureDate'],
            'time_flight' => $result['Routes']['Output'][0]['DepartureTime'],
            'ret_date_flight' => $result['Routes']['Return'][0]['DepartureDate'],
            'ret_time_flight' => $result['Routes']['Return'][0]['DepartureTime'],
            'total_price' => $result['FlightTotalPrice'] + $result['HotelTotalPrice'],
            'total_flight_price' => $result['FlightTotalPrice'],
            'total_hotel_price' => $result['HotelTotalPrice'],
            'adt_qty' => $adtCount,
            'chd_qty' => $chdCount,
            'request_number' => $data['requestNumber'],
            'factor_number' => substr( time(), 0, 5 ) . mt_rand( 000, 999 ) . substr( time(), 5, 10 ),
            'api_id' => $result['SourceId'],
            'successfull' => 'lock',
            'del' => 'no',
            'creation_date' => date('Y-m-d'),
            'creation_date_int' => time(),
            'request_cancel' => 'none',
            'type_app' => 'Web',
            'currency_code' => 0,
            'currency_equivalent' => 0,
            'flight_number' => $result['Routes']['Output'][0]['FlightNo'],
            'ret_flight_number' => $result['Routes']['Return'][0]['FlightNo'],
            'seat_class' => $addData['Routes']['Output'][0]['seatClass'],
            'ret_seat_class' => $addData['Routes']['Return'][0]['seatClass'],
            'airline_iata' => $addData['Routes']['Output'][0]['airlineIata'],
            'ret_airline_iata' => $addData['Routes']['Return'][0]['airlineIata'],
            'airline_name' => $addData['Routes']['Output'][0]['airlineName'],
            'ret_airline_name' => $addData['Routes']['Return'][0]['airlineName'],
            'hotel_name' => $addData['HotelName'],
            'hotel_id' => $result['HotelID'],
            'room_info' => json_encode($addData['Rooms']),
            'check_in' => $result['CheckinDate'],
            'check_out' => $result['CheckoutDate'],
            'entertainment_data_json' => $ent_json,
            'entertainment_ids' => $ent_ids,

        ];

        $book_exclusive_tour_tb = $this->getModel('exclusiveTourModel');
        $report_exclusive_tour_tb = $this->getModel('exclusiveTourBaseModel');

        foreach ($result['Passengers'] as $p) {
            $passengerData = array(
                'passenger_name' => $p['FirstName'],
                'passenger_family' => $p['LastName'],
                'passenger_birthday' => $p['DateOfBirth'],
                'passenger_national_code' => $p['NationalCode'],
                'passportCountry' => $p['Nationality'],
                'passportNumber' => $p['PassportNumber'],
                'passenger_age' => $p['PassengerType']
            );

            $insert_book = $book_exclusive_tour_tb->insertWithBind(array_merge($tourData, $passengerData));

            if ($insert_book) {
                $tourData['client_id'] = CLIENT_ID;
                $insert_report = $report_exclusive_tour_tb->insertWithBind(array_merge($tourData, $passengerData));
                unset($tourData['client_id']);
            }
        }




        return json_encode($result);
    }

    public function Book($data) {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $url = $this->apiAddress . "Tour/Book/" . $data['request_number'];

        $d['UserName'] = $this->username;
        $d['SourceId'] = $data['api_id'];

        $d['subAgencyId'] = '';
        $agencyInfo = $this->getController('agency')->subAgencyInfo();
        if ($agencyInfo != null && !empty($agencyInfo['sepehr_username']) && !empty($agencyInfo['sepehr_password'])) {
            $d['subAgencyId'] = $agencyInfo['id'];
        }


        $JsonArray = json_encode($d);

        $result = functions::curlExecution($url, $JsonArray, 'yes');



            if (!empty($result) && $result['curl_error'] == false && !empty($result['Pnr'])) {

//                $email_buyer      = $data['member_email'];
//                if (isset($email_buyer) && !empty($email_buyer)) {
//
//
//                    $agency = $this->getModel('clientsModel')->get()->where('id', CLIENT_ID)->find();
//
//
//                    $subject = $agency['AgencyName'] . " - ";
//                    $subject .= "بلیط تور ";
//                    $subject .= $data['origin_city'];
//                    $subject .= " به ";
//                    $subject .= $data['desti_city'];
//
//                    $message = "رزرو شما با موفقیت صادر شد، شماره رزرو: ";
//                    $message .= $data['request_number'];
//
//
//                    $headers = "From:generaltravel2000@gmail.com\r\n" .
//                        "Reply-To:generaltravel2000@gmail.com\r\n" .
//                        "X-Mailer: PHP/" . phpversion();
//
//                    $sendMail = mail($email_buyer, $subject, $message, $headers);
//
//                }
//
//                $members = Load::controller( 'members' );
//                $members->SendEmailForOther($email_buyer, $data['request_number']);

                $BookFlight['successfull'] = 'book';
                $BookFlight['provider_ref'] = $result['Pnr'];
                $condition = "request_number='{$data['request_number']}'";
                $Model->setTable("book_exclusive_tour_tb");
                $res = $Model->update($BookFlight, $condition);
                if ($res) {
                    $ModelBase->setTable("report_exclusive_tour_tb");
                    $ModelBase->update($BookFlight, $condition);
                }

                return $result;
            }
            else {

                $MessageError = functions::ShowError($result['Messages']['errorCode']);

                $data_error['message'] = str_replace('\'','',$result['Messages']['errorMessage']);
                $data_error['message_fa'] = $MessageError;
                $data_error['client_id'] = CLIENT_ID;
                $data_error['messageCode'] = $result['Messages']['errorCode'];
                $data_error['request_number'] = $data['request_number'];
                $data_error['origin'] = $data['origin_city'];
                $data_error['destination'] = $data['desti_city'];
                $data_error['action'] = 'Book';
                $data_error['creation_date_int'] = time();
                $this->getController('logErrorExclusiveTour')->insertLogErrorExclusiveTour($data_error);

                $BookFlight['successfull'] = 'error';
                $condition = "request_number='{$data['request_number']}'";
                $Model->setTable("book_exclusive_tour_tb");
                $res = $Model->update($BookFlight, $condition);
                if ($res) {
                    $ModelBase->setTable("report_exclusive_tour_tb");
                    $ModelBase->update($BookFlight, $condition);
                }

                return false;
            }

    }


}