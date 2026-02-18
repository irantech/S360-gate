<?php
//if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}
class searchHotel extends ApiHotelCore {

    public $isShowResult;
    public $countHotel;
    public $minPrice;
    public $requestNumber;
    public $maxPrice;
    public $Hotel;
    public $IsLogin;
    public $counterId;

    public function __construct() {
        parent::__construct();
        $this->IsLogin = Session::IsLogin();
        if ( $this->IsLogin ) {
            $this->counterId  = functions::getCounterTypeId( $_SESSION['userId'] );
        } else {
            $this->counterId = '5';
        }
    }

    public function searchHotel( $param ) {


        $param['startDate'] = isset($param['startDate']) ? $param['startDate'] : dateTimeSetting::jtoday();

//        $param['calendar_type'] = isset($param['calendar_type']) ? $param['calendar_type'] : 'jalali';
//        if(SOFTWARE_LANG != 'fa'){
//            $param['startDate'] = $param['startDate'] ? $param['startDate'] : date('Y-m-d');
//            $param['calendar_type'] = '';
//        }


        if (substr($param['startDate'], "0", "4") > 2000) {
            functions::insertLog(' must be gregorian => ' . json_encode($param), 'times', 'yes');
            $param['calendarType'] = 'gregorian';
            $endInt = strtotime("{$param['startDate']} +{$param['nights']}Day");
            $param['endDate'] = date('Y-m-d', $endInt);
            $start_date_reservation = str_replace(["/", "-"], "", functions::ConvertToJalali($param['startDate']));
            $end_date_reservation = str_replace(["/", "-"], "", functions::ConvertToJalali($param['endDate']));
        } else {
            $param['calendarType'] = 'jalali';
            $startInt = functions::ConvertToMiladi($param['startDate'], '-');
            $endInt = strtotime("{$startInt} +{$param['nights']}Day");
            $param['endDate'] = dateTimeSetting::jdate('Y-m-d', $endInt, '', '', 'en');
            $start_date_reservation = str_replace(["/", "-"], "", $param['startDate']);
            $end_date_reservation = str_replace(["/", "-"], "", $param['endDate']);
        }

        if (!$this->checkStartDate($param['startDate'], $param['calendarType'])) {

            return $this->showError(functions::Xmlinformation('InvalidStartDate'), 400);
        }

        $skipped = [];
        $sql_reservation = '';

        $arrayPrice = array();
        $index = 0;

//		$hotelType     = ! ( $param['hotelType'] ) ? $param['hotelType'] : 'all';
//		$param['star'] = ! ( $param['star'] ) ? $param['star'] : 'all';

//        if ( $param['lang'] == 'en' || $param['lang'] == 'ar' || substr( $param['startDate'], "0", "4" ) > 2000 ) {
//            $startDate = functions::ConvertToJalali( $param['startDate'] );
//            $endDate   = functions::ConvertToJalali( $param['endDate'] );
//        } else {
//            $startDate = str_replace( [ "/", "-" ], "", $param['startDate'] );
//            $endDate   = str_replace( [ "/", "-" ], "", $param['endDate'] );
//        }
//        $dateNow = dateTimeSetting::jdate( "Ymd", '', '', '', 'en' );
//        if ( trim( $startDate ) >= trim( $dateNow ) ) {
//            $this->errorSearchHotel = "false";
//        } else {
//            $this->errorSearchHotel = "true";
//        }

        $conditionHotelTypeForReservation = '';
        if (isset($param['hotelType']) && (is_numeric($param['hotelType']))) {
            $conditionHotelTypeForReservation = "AND type_code='" . $param['hotelType'] . "'";
        }
        $conditionHotelTypeResidence = '';
        if (isset($param['type_residence']) && (is_numeric($param['type_residence']))) {
            $conditionHotelTypeResidence = "AND type_code='" . $param['type_residence'] . "' AND user_id != '' ";
        }

        $conditionsStarForReservation = '';
        if (isset($param['star']) && $param['star'] != '' && is_numeric($param['star'])) {
            $conditionsStarForReservation = "AND star_code='{$param['star']}'";
        }

        $conditionsHotelNameForReservation = '';
        if (isset($param['hotelName']) && $param['hotelName'] != '' && $param['hotelName'] != 'all') {
            $conditionsHotelNameForReservation = "AND name LIKE '%{$param['hotelName']}%' " .
                "OR name_en LIKE '%{$param['hotelName']}%' ";
        }


        if (isset($param['rooms']) && !empty($param['rooms'])) {
            $rooms_explode = functions::numberOfRoomsExternalHotelSearch($param['rooms']);
            $final_rooms_array = functions::numberOfRoomsExternalHotelRequested($rooms_explode['rooms']);
            foreach ($final_rooms_array as $key => $room) {
                $childCount = $adultCount = 0;
                $age = [];
                foreach ($room as $passenger) {

                    if ($passenger['PassengerAge'] != 0) {
                        if ($passenger['PassengerAge'] <= 12) {
                            $age[] = $passenger['PassengerAge'];
                        }
                    }

                    if ($passenger['PassengerAge'] > 12) {
                        $adultCount++;
                    } else {
                        $childCount++;
                    }
                }
                $dataSearch['roomsArray'][] = ['Adults' => $adultCount, 'Children' => $childCount, 'Ages' => $age];
            }
        }



        // Access Reservation Hotel
        $resultInfoSources = parent::AccessReservationHotel();



//        functions::insertLog('param===>'.CLIENT_NAME.' => '.json_encode($param,256|64),'sql_reservation');

        if ( (empty($param['source']) || $param['source'] == 'all' || $param['source'] == 'reservation' || $param['source'] == 'app')) {

            http_response_code(200);
            // واکشی اطلاعات کامل هتل های رزرواسیون //
            $sql_reservation = "SELECT id as hotel_id, name as hotel_name, name_en as hotel_name_en, city as city_id, priority as hotel_priority, discount, comment as cancel_conditions, type_code, star_code, address, logo as pic , flag_special , user_id FROM reservation_hotel_tb WHERE city='{$param['city_id']}' AND is_del='no' AND is_show='yes' {$conditionsStarForReservation} {$conditionsHotelNameForReservation} {$conditionHotelTypeForReservation}{$conditionHotelTypeResidence} ORDER BY priority DESC";
//            if ($_SERVER['REMOTE_ADDR'] == '5.201.144.255') {
//                var_dump($sql_reservation);
//                die();
//            }
//            functions::insertLog('query==>'.CLIENT_NAME.' => '.$sql_reservation,'sql_reservation');
            $result_Hotel_reservation = $this->model->select($sql_reservation);
            if (!empty($result_Hotel_reservation)) {

                foreach ($result_Hotel_reservation as $Hotel) {

                    $index++;
                    if (isset($Hotel['pic']) && $Hotel['pic'] != '') {
                        $urlPic = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . $Hotel['pic'];
                    } else {
                        $urlPic = ROOT_ADDRESS_WITHOUT_LANG . '/pic/hotel-nophoto.jpg';
                    }
                    $gdata = str_replace(array('-', '/'), '', $param['startDate']);
                    $year = substr($gdata, 0, 4);
                    if ($year > '1500') {
                        $startDate = functions::ConvertToJalali($param['startDate']);
                    } else {
                        $startDate = $param['startDate'];
                    }


                    $minPrice = $this->getMinPriceHotelRoom($param['city_id'], $Hotel['hotel_id'], $start_date_reservation, $end_date_reservation);


                    if ($minPrice > 0) {

                        if ($Hotel['user_id']) {

                            $res = functions::getMarketHotelPriceChange($Hotel['hotel_id'], $this->counterId, $startDate, 'marketplaceHotel');
                            $discount_hotel = functions::marketServiceDiscount($this->counterId, 'marketplaceHotel', $Hotel['hotel_id']);

                            $this_hotel_calculate_price = functions::calculateHotelPrice($res, $discount_hotel, $minPrice);

                        }
                        $cancel_conditions = $Hotel['cancel_conditions'];
                        if (strlen($Hotel['cancel_conditions']) >= 230) {
                            $pos = strpos($Hotel['cancel_conditions'], ' ', 230);
                            if ($pos !== false) {
                                $cancel_conditions = substr($Hotel['cancel_conditions'], 0, $pos) . ' ...';
                            }
                        }

                        if ($Hotel['star_code'] > 5) {
                            $star_code = 0;
                        } else {
                            $star_code = $Hotel['star_code'];
                        }
                        $paramPointClub = array(
                            'service' => functions::TypeServiceHotel('reservation'),
                            'baseCompany' => 'all',
                            'company' => 'all',
                            'counterId' => $this->counterId,
                            'price' => $minPrice
                        );

                        $pointClub = functions::CalculatePoint($paramPointClub);

                        if (isset($this_hotel_calculate_price)) {
                            $price_currency = functions::CurrencyCalculate($this_hotel_calculate_price['calculated_price']);
                        } else {
                            $price_currency = functions::CurrencyCalculate($minPrice);
                        }

                        $this->Hotel[$Hotel['hotel_id'] . $index]['price_currency'] = $price_currency;
                        if (isset($param['nights']) && !empty($param['nights']) && $param['nights'] > 1) {
                            $this->Hotel[$Hotel['hotel_id'] . $index]['price_currency_total_night'] = $price_currency['AmountCurrency'] * $param['nights'];
                        }
                        if (isset($this_hotel_calculate_price)) {
                            $this->Hotel[$Hotel['hotel_id'] . $index]['min_room_price'] = $this_hotel_calculate_price['calculated_price'];
                            $this->Hotel[$Hotel['hotel_id'] . $index]['min_room_price_without_discount'] = $this_hotel_calculate_price['price_with_increase_change'];
                            if (isset($param['nights']) && !empty($param['nights']) && $param['nights'] > 1) {
                                $this->Hotel[$Hotel['hotel_id'] . $index]['min_room_price_without_discount'] = $this_hotel_calculate_price['price_with_increase_change'] * $param['nights'];
                            }
                        } else {
                            $this->Hotel[$Hotel['hotel_id'] . $index]['min_room_price'] = $minPrice;
                            $this->Hotel[$Hotel['hotel_id'] . $index]['min_room_price_without_discount'] = 0;
                        }



                        $this->Hotel[$Hotel['hotel_id'] . $index]['HotelIndex'] = $Hotel['hotel_id'];
                        $this->Hotel[$Hotel['hotel_id'] . $index]['city_id'] = $Hotel['city_id'];
                        $this->Hotel[$Hotel['hotel_id'] . $index]['priority'] = $Hotel['hotel_priority'];
                        $this->Hotel[$Hotel['hotel_id'] . $index]['hotel_id'] = $Hotel['hotel_id'];
                        $this->Hotel[$Hotel['hotel_id'] . $index]['SourceId'] = '';
                        $this->Hotel[$Hotel['hotel_id'] . $index]['hotel_name'] = $Hotel['hotel_name'];
                        $this->Hotel[$Hotel['hotel_id'] . $index]['hotel_name_en'] = str_replace(' ', '-', $Hotel['hotel_name_en']);
                        $this->Hotel[$Hotel['hotel_id'] . $index]['address'] = $Hotel['address'];
                        $this->Hotel[$Hotel['hotel_id'] . $index]['address_en'] = '';
                        if (isset($this_hotel_calculate_price)) {
                            $this->Hotel[$Hotel['hotel_id'] . $index]['discount'] = $this_hotel_calculate_price['discount']['off_percent'] > 1 ? intval($this_hotel_calculate_price['discount']['off_percent']) : $this_hotel_calculate_price['discount']['off_percent'];
                            $this->Hotel[$Hotel['hotel_id'] . $index]['discount_price'] = $this_hotel_calculate_price['discount']['off_percent'];
                        } else {
                            $this->Hotel[$Hotel['hotel_id'] . $index]['discount'] = $Hotel['discount'];
                            $this->Hotel[$Hotel['hotel_id'] . $index]['discount_price'] = 0;
                        }

                        $this->Hotel[$Hotel['hotel_id'] . $index]['cancel_conditions'] = $cancel_conditions;
                        $this->Hotel[$Hotel['hotel_id'] . $index]['pic'] = $urlPic;
                        $this->Hotel[$Hotel['hotel_id'] . $index]['type_code'] = $Hotel['type_code'];
                        $this->Hotel[$Hotel['hotel_id'] . $index]['star_code'] = $star_code;
                        $this->Hotel[$Hotel['hotel_id'] . $index]['type_application'] = 'reservation';
                        $this->Hotel[$Hotel['hotel_id'] . $index]['requestNumber'] = '';
                        $this->Hotel[$Hotel['hotel_id'] . $index]['pointClub'] = $pointClub;
                        $this->Hotel[$Hotel['hotel_id'] . $index]['is_special'] = $Hotel['flag_special'];

                        $ResultFacilities = $this->hotelFacilities($Hotel['hotel_id']);
                        foreach ($ResultFacilities as $key => $facilities) {

                            $this->Hotel[$Hotel['hotel_id'] . $index]['facilities'][$key]['title'] = $facilities['title'];
                            $this->Hotel[$Hotel['hotel_id'] . $index]['facilities'][$key]['iconClass'] = $facilities['icon_class'];

                        }

                        if ($minPrice > 0) {
                            $arrayPrice[] = $minPrice;
                        }
                    }


                }
            }
        }
        if ( !isset( $param['type_residence'] )   ) {
            if ($this->auth == 'True' && (is_numeric($param['hotelType']) || $param['hotelType'] == 'all' || $param['hotelType'] == 'api' || $param['hotelType'] == 'app')) {

                http_response_code(200);
                $sql = "SELECT * FROM hotel_cities_tb WHERE id='{$param['city_id']}'";
                $cityName = $this->modelBase->load($sql);
                $dataSearch['city'] = strtoupper($cityName['city_name_en']);
                $dataSearch['startDate'] = $param['startDate'];
                $dataSearch['calendarType'] = $param['calendarType'];

                $dataSearch['isInternal'] = true;
                $dataSearch['Country'] = 'IRAN';

//				$startInt              = functions::convertJalaliDateToGregInt( $param['startDate'] );
//				$endInt                = strtotime( "+{$param['nights']}Day", $startInt );
//				$dateStartEn           = date( 'Y-m-d', $startInt );
//				$dateEndEn             = date( 'Y-m-d', $endInt );
//				$dataSearch['endDate'] = dateTimeSetting::jdate( 'Y-m-d', $endInt, '', '', 'en' );
                $gdata = str_replace(array('-', '/'), '', $param['startDate']);
                $year = substr($gdata, 0, 4);
                if ($year > '1500') {
                    $startDate = functions::ConvertToJalali($param['startDate']);
                } else {
                    $startDate = $param['startDate'];
                }
                $dataSearch['endDate'] = $param['endDate'];

                if ($param['source'] != 'reservation') {
                    $allTypes = [];
                    $allTypes = self::HotelTypes();


                    $t1 = microtime(true);

                    $resultHotelApi = json_decode($this->hotelList($dataSearch), true);

                    if (!empty($resultHotelApi['Result'])) {
                        $t2 = microtime(true);
                        $final_result_search = $this->excludeWebserviceHotel($resultHotelApi['Result']);
                        foreach ($final_result_search as $Hotel) {

                            $index++;
                            // اضافه کردن کمسیون آژانس به قیمت اتاق
//                        $Hotel['']

                            $priceWithoutDiscount = $priceFieldWithoutDiscount = isset($Hotel['DailyMinPrice']) ? $Hotel['DailyMinPrice'] : $Hotel['MinPrice'];
                            $hotel_price = $price = $Hotel['MinPrice'] = isset($Hotel['MinPrice']) ? $Hotel['MinPrice'] : $Hotel['DailyMinPrice'];
                            $res = functions::getHotelPriceChange($param['city_id'], $Hotel['HotelStars'], $this->counterId, $startDate, 'api');

                            $hotel_service_title = functions::TypeServiceHotel('api', '', $Hotel['WebServiceType']);
                            $discount_hotel = functions::ServiceDiscount($this->counterId, $hotel_service_title);
                            $this_hotel_calculate_price = functions::calculateHotelPrice($res, $discount_hotel, $hotel_price);

                            if ($Hotel['CancelConditions'] != '' && strlen($Hotel['CancelConditions']) > 460) {
                                $pos = strpos($Hotel['cancel_conditions'], ' ', '460');
                                if ($pos !== false) {
                                    $cancel_conditions = substr($Hotel['CancelConditions'], 0, $pos) . ' ...';
                                }
                            } else {
                                $cancel_conditions = $Hotel['CancelConditions'];
                            }
                            if ($param['star'] > 5) {
                                $star_code = 0;
                            } else {
                                $star_code = $param['star'];
                            }
                            $typeCode = '';

                            foreach ($allTypes as $key => $type) {
                                if ($Hotel['HotelType'] == $type['Name'] || $Hotel['HotelType'] == $type['NameEn']) {
                                    $Hotel['HotelTypeCode'] = $typeCode = $type['Code'];
                                }
                            }


                            if (isset($param['hotelType']) && $param['hotelType'] != 'all' && is_numeric($param['hotelType']) && $Hotel['HotelTypeCode'] != $param['hotelType']) {
                                continue;
                            }
                            if (isset($param['star']) && $param['star'] != '' && $param['star'] != 'all' && is_numeric($param['star']) && $Hotel['HotelStars'] != $param['star']) {
                                continue;
                            }
                            if (isset($param['name']) && $param['name'] != '' && $param['name'] != 'all' && (strpos($Hotel['HotelName'], $param['name']) === false)) {
                                $skipped[] = [$Hotel['HotelName'] => [$Hotel['HotelIndex'], $param['name'], 'meta' => [(strpos($Hotel['HotelName'], $param['name']) === false)]]];
                                continue;
                            }

                            $paramPointClub = array(
                                'service' => functions::TypeServiceHotel('api'),
                                'baseCompany' => 'all',
                                'company' => 'all',
                                'counterId' => $this->counterId,
                                'price' => $price,
//								'price'       => $minPrice,
                            );
                            $pointClub      = functions::CalculatePoint( $paramPointClub );
                            $feature_pic = $Hotel['FeaturedPicture'];


                            $this->Hotel[$Hotel['HotelIndex'] . $index]['pic'] = $feature_pic;
//						$this->Hotel[ $Hotel['HotelIndex'] . $index ]['ind']                 = $Hotel['ind'];
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['MinPrice'] = $Hotel['MinPrice'];
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['calculated_price'] = $this_hotel_calculate_price;

                            $this->Hotel[$Hotel['HotelIndex'] . $index]['discount_price'] = $discount_hotel['off_percent'];
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['hotelType'] = $param['hotelType'];
//						$this->Hotel[ $Hotel['HotelIndex'] . $index ]['price_without_discount']          = $this_hotel_calculate_price['calculated_price'];
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['min_room_price_without_discount'] = $this_hotel_calculate_price['price_with_increase_change'];

                            $price_currency = functions::CurrencyCalculate($this_hotel_calculate_price['calculated_price']);

                            $this->Hotel[$Hotel['HotelIndex'] . $index]['price_currency'] = functions::CurrencyCalculate($this_hotel_calculate_price['calculated_price']);

                            if (isset($param['nights']) && !empty($param['nights']) && $param['nights'] > 1) {
                                $this->Hotel[$Hotel['HotelIndex'] . $index]['price_currency_total_night'] = $price_currency['AmountCurrency'] * $param['nights'];
                                $this->Hotel[$Hotel['HotelIndex'] . $index]['min_room_price_without_discount'] = $this_hotel_calculate_price['price_with_increase_change']* $param['nights'];
                            }
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['min_room_price'] = $this_hotel_calculate_price['calculated_price'];
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['HotelIndex'] = $Hotel['HotelIndex'];
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['city_id'] = $param['city_id'];
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['priority'] = '';
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['hotel_id'] = $Hotel['HotelIndex'];
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['SourceId'] = $Hotel['SourceId'];
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['hotel_name'] = $Hotel['HotelName'];
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['hotel_name_en'] = str_replace(' ', '-', $Hotel['HotelNameEn']);
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['address'] = $Hotel['ContactInformation']['Address'];
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['address_en'] = isset($Hotel['ContactInformation']['AddressEn']) ? $Hotel['ContactInformation']['AddressEn'] : '';
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['discount'] = intval($discount_hotel['off_percent']);
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['cancel_conditions'] = $cancel_conditions;
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['pic'] = $feature_pic;
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['type'] = $Hotel['HotelType'];
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['type_code'] = $typeCode;
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['star_code'] = $Hotel['HotelStars'];
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['type_application'] = 'api';
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['pointClub'] = $pointClub;
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['requestNumber'] = $resultHotelApi['RequestNumber'];
                            $this->Hotel[$Hotel['HotelIndex'] . $index]['is_special'] = 'no';


                            if ($Hotel['Facilities'] && is_array($Hotel['Facilities'])) {
                                foreach ($Hotel['Facilities'] as $key => $facility) {

                                    $this->Hotel[$Hotel['HotelIndex'] . $index]['facilities'][$key]['title'] = $facility;
                                    $this->Hotel[$Hotel['HotelIndex'] . $index]['facilities'][$key]['iconClass'] = '';

                                }
                            }

                            if ($price != 0) {
                                $arrayPrice[] = $price;
                            }
                            // -----------------------
                            // When api doesn't have enough data
                            // -----------------------
                            if ( $Hotel['SourceId'] == 42) {

                                $localData = $this->getLocalHotelData($Hotel['HotelIndex']);
                                if(!empty($localData['name']) || $localData['name'] != ''){
                                    $this->Hotel[$Hotel['HotelIndex'] . $index]['hotel_name'] = $localData['name'];
                                }
                                if(empty($this->Hotel[$Hotel['HotelIndex'] . $index]['pic']) || $this->Hotel[$Hotel['HotelIndex'] . $index]['pic'] == '') {
                                    $localPic = $this->getLocalHotelPic($Hotel['HotelIndex']);
                                    if ($localPic) {
                                        $feature_pic = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . $localPic;
                                        $this->Hotel[$Hotel['HotelIndex'] . $index]['pic'] = $feature_pic;
                                    }
                                }
                                if(empty($this->Hotel[$Hotel['HotelIndex'] . $index]['facilities']) || $this->Hotel[$Hotel['HotelIndex'] . $index]['Facilities'] == '') {
                                    $this->Hotel[$Hotel['HotelIndex'] . $index]['facilities'] = json_decode($localData['facilities'], true);
                                }
                                if(empty($this->Hotel[$Hotel['HotelIndex'] . $index]['address']) || $this->Hotel[$Hotel['HotelIndex'] . $index]['address'] == '') {
                                    $this->Hotel[$Hotel['HotelIndex'] . $index]['address'] = $localData['address'];
                                }
                                if(empty($this->Hotel[$Hotel['HotelIndex'] . $index]['star_code']) || $this->Hotel[$Hotel['HotelIndex'] . $index]['star_code'] == '') {
                                    $this->Hotel[$Hotel['HotelIndex'] . $index]['star_code'] = $localData['star_code'];
                                }
                            }


                        }
                    }
                }
            }
        }
        $this->countHotel = count($this->Hotel);
        if ( ! empty( $arrayPrice ) ) {
            $this->minPrice = min( $arrayPrice );
            $this->maxPrice = max( $arrayPrice );
        }
        if ( ! empty( $this->Hotel ) ) {
            http_response_code( 200 );
        }
        $final_result = [ 'Count'    => $this->countHotel,
            'Hotels'   => $this->Hotel,
            'minPrice' => $this->minPrice,
            'maxPrice' => $this->maxPrice,
            'prices'   => $arrayPrice,
            'requestNumber'   => $this->requestNumber,
        ];

        if(!empty($this->Hotel)){
            $final_result['Advertises'] = functions::getConfigContentByTitle('local_hotel_search_advertise');
        }
        return functions::toJson( $final_result );
    }
    private function getLocalHotelPic($hotelIndex)
    {
        $sql = "SELECT logo FROM reservation_hotel_tb WHERE sepehr_hotel_code='$hotelIndex' LIMIT 1";
        $row = $this->model->select($sql);

        if (!empty($row) && $row[0]['logo'] != '') {
            return $row[0]['logo'];
        }

        return false;
    }


    private function getLocalHotelData($hotelIndex)
    {
        $sqlHotel = "
    SELECT 
        RHB.*,
        CONCAT(
            '[',
            GROUP_CONCAT(
                CONCAT(
                    '{\"title\":\"', F.title, '\",',
                    '\"iconClass\":\"', F.icon_class, '\"}'
                )
                SEPARATOR ','
            ),
            ']'
        ) AS facilities
    FROM reservation_hotel_tb RHB
    LEFT JOIN reservation_hotel_facilities_tb RF
        ON RF.id_hotel = RHB.id
    LEFT JOIN reservation_facilities_tb F
        ON RF.id_facilities = F.id
    WHERE 
        RHB.sepehr_hotel_code = '{$hotelIndex}'
    GROUP BY 
        RHB.id
";

        $localHotelResult = $this->model->select($sqlHotel);



        $localHotel = $localHotelResult[0];

        return !empty($localHotel) ? $localHotel : false;
    }

    public function Allcity() {
        return $this->getModel('hotelCitiesModel')->get()->orderBy('position','DESC')->all();
//		$sql = "SELECT * FROM hotel_cities_tb ORDER BY `position` DESC";
//
//		return $this->modelBase->select( $sql );
    }

    public function popularInternalHotelCities() {
        $result =  $this->getModel('hotelCitiesModel')->get()
            ->where('position'  , 'null' , '!=')->orderBy('position','DESC')->all();
        return json_encode($result);
    }
    public function getCity( $cityId = null ) {
        if ( ! $cityId ) {
            return false;
        }
//        return $this->getModel('hotelCitiesModel')->get()->where('id',$cityId)->find();
        return $this->getModel('reservationCityModel')->get()->where('id',$cityId)->find();

    }
    public function getCityBYId( $param = null ) {
        if ( ! $param['city_id'] ) {
            return false;
        }
//        $result  = $this->getModel('hotelCitiesModel')->get()->where('id',$param['city_id'])->find();
        $result  = $this->getModel('reservationCityModel')->get()->where('id',$param['city_id'])->find();
        return json_encode($result);
    }

    private function hotelTypeCode( $title = '' ) {
        if ( ! $title ) {
            return false;
        }
        $allTypes = self::HotelTypes();
        foreach ( $allTypes as $type ) {
            if ( $title == $type['Name'] || $title == $type['NameEn'] ) {
                return $type['Code'];
            }
        }

        return false;
    }

    function getMinPriceHotelRoom($idCity, $idHotel, $startDate, $endDate)
    {
        $date = dateTimeSetting::jtoday('');

        $Model = Load::library('Model');
        $sql = "
        SELECT
            HR.online_price,
            HR.currency_price,
            HR.currency_type,
            HR.date,
            (
        SELECT
            MIN( HHR.online_price + HHR.currency_price )
        FROM
            reservation_hotel_tb HH
            INNER JOIN reservation_hotel_room_prices_tb HHR ON HH.id = HHR.id_hotel
        WHERE
            HHR.user_type = '{$this->counterId}'
            AND HH.city = '{$idCity}'
            AND HH.id = '{$idHotel}'
            AND HHR.date = HR.date
            AND HHR.flat_type = 'DBL'
            AND HHR.is_del = 'no'
            AND HHR.online_price > 0
            ) AS minPrice
        FROM
            reservation_hotel_tb H
            INNER JOIN reservation_hotel_room_prices_tb HR ON H.id = HR.id_hotel
        WHERE
            HR.user_type = '{$this->counterId}'
            AND H.city = '{$idCity}'
            AND H.id = '{$idHotel}'
            AND ( HR.date >= '{$startDate}' AND HR.date < '{$endDate}' )
            AND HR.flat_type = 'DBL'
            AND HR.is_del = 'no'
            AND HR.remaining_capacity > 0 
        GROUP BY
            HR.date;
        ";

        $minPrice = 0;
//        functions::insertLog('getMinPriceHotelRoom=>'.$sql,'sql_reservation');
        $prices = $Model->select($sql);

        $night = $endDate  - $startDate ;

        if($night != count($prices)) {
            return $minPrice;
        }

        if(isset($prices[0]['minPrice'])){
            if($prices[0]['currency_price'] > 0 ) {
                $currency_amount = functions::CalculateCurrencyPrice( [
                    'price' => $prices[0]['currency_price'] ,
                    'currency_type' => $prices[0]['currency_type']
                ] );

                $minPrice = $prices[0]['online_price'] + $currency_amount['AmountCurrency'];

            }else {
                $minPrice = $prices[0]['minPrice'];
            }

        }
//		foreach ($prices as $price){
//			$minPrice += $price['minPrice'];
//		}

        return $minPrice;
    }

    public function hotelFacilities($hotelId)
    {
        $Model = Load::library('Model');
        $sql = " SELECT * FROM
                      reservation_hotel_facilities_tb HF LEFT JOIN reservation_facilities_tb F ON HF.id_facilities=F.id
                  WHERE HF.id_hotel='{$hotelId}' AND HF.is_del='no' AND F.is_del='no' ";
        $ResultFacilities = $Model->select($sql);

        return $ResultFacilities;

    }

    public function HotelTypes() {
        return parent::AllHotelTypes();
    }

    public function computingEndDate( $startDate, $nightCount ) {
        if(!$startDate){
            $startDate = dateTimeSetting::jtoday();
        }
        $isMiladi = false;
        if ( SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' || substr( $startDate, "0", "4" ) > 2000 ) {
            $isMiladi     = true;
            $sDate_miladi = $startDate;
        } else {
            $sDate_miladi = functions::ConvertToMiladi( $startDate );
        }
        $sDate_miladi = str_replace( "-", "", $sDate_miladi );
        $result       = date( 'Ymd', strtotime( "" . $sDate_miladi . ",+ $nightCount day" ) );
        if ( SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' || $isMiladi ) {
            $y      = substr( $result, 0, 4 );
            $m      = substr( $result, 4, 2 );
            $d      = substr( $result, 6, 2 );
            $dateFa = $y . '-' . $m . '-' . $d;
        } else {
            $dateFa = functions::ConvertToJalali( $result );
        }
        $this->end_date = $dateFa;

        return $dateFa;
    }

    public function validateSearch($params = array()) {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

        $city = SEARCH_CITY;
        $startDate = SEARCH_START_DATE;
        $nights = SEARCH_NIGHT;
        $type = SOFTWARE_LANG == 'fa' ? 'jalali' : '';
        if ( ! $this->checkStartDate( $startDate ,$type) ) {
            $newDate = dateTimeSetting::jtoday();
            if ( SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' AND substr( $startDate, "0", "4" ) > 2000 ) {
                $newDate = date('Y-m-d');
            }
            $link = str_replace($startDate,$newDate,$actual_link);
//			header('Location: '.$link);
        }
    }
    public function searchCity( $inputSearchValue) {
        $cities =  $this->getModel('hotelCitiesModel')->get();
        if (isset($inputSearchValue) &&  $inputSearchValue) {
            $searched_converted_params =  functions::switchAlphabet($inputSearchValue);
            $searched_params = $inputSearchValue ;

            $cities = $cities->like('city_name', $searched_params);
            $cities = $cities->like('city_name', $searched_converted_params);
            $cities = $cities->like('city_name_en', $searched_params);
            $cities = $cities->like('city_name_en', $searched_converted_params);
            $cities = $cities->like('city_iata', $searched_params);

        }
        $cities = $cities->orderBy('position','DESC')->all();
        return json_encode($cities);
    }
    public function searchCityInternalHotel($params) {
      
        $name      = urldecode( $params['inputSearchValue'] );
        $result    = [];
        $hotelHtml = '';
        $i         = 0;
        //		echo CLIENT_DOMAIN ;
        //		$sqlReservationCities = "
        //		SELECT id AS city_id,city_name AS city_name, city_name_en AS city_name_en FROM hotel_cities_tb WHERE city_name LIKE '{$name}%' OR city_name_en LIKE '{$name}%' OR city_iata LIKE '{$name}%'
        //		";
        /** @var hotelCitiesModel $hotel_cities */
        $hotel_cities = Load::getModel('hotelCitiesModel');
        $searched_converted_params =  functions::switchAlphabet($name);
        $searched_params = $name ;

        if(!$name){
            $result['Cities'] = [];
            $result['ApiHotels'] = [];
            $result['ReservationHotels'] = [];
            echo functions::clearJsonHiddenCharacters( json_encode( $result ) );
            exit();
        }
        $cities = $hotel_cities->get(['id AS city_id','city_name','city_name_en'])
            ->like('city_name',"{$searched_params}%","LEFT")
            ->like('city_name',"{$searched_converted_params}%","LEFT")
            ->like('city_name_en',"{$searched_params}%","LEFT")
            ->like('city_name_en',"{$searched_converted_params}%","LEFT")
            ->like('city_iata',"{$searched_params}%","LEFT")
            ->all();
        $Model                = Load::library( 'Model' );
        if ( count( $cities ) > 0 ) {
            $result['Cities'] = [];
            foreach ( $cities as $city ) {
                $cityItem = [
                    'CityId'     => $city['city_id'],
                    'CityName'   => $city['city_name'],
                    'CityNameEn' => $city['city_name_en'],
                ];
                $result['Cities'][] = $cityItem;
            }
        }
        $sqlReservationHotel = "
		SELECT
	reservation_hotel_tb.`id` AS hotel_id,
	reservation_hotel_tb.`name` AS hotel_name,
	reservation_hotel_tb.`name_en` AS hotel_name_en,
	reservation_hotel_tb.`city` AS city_id,
	reservation_hotel_tb.`priority` AS hotel_priority,
	reservation_hotel_tb.`discount`,
	'roomHotelLocal' AS page,
	'reservation' AS typeApp,
	reservation_city_tb.`name` AS city_name
FROM
	reservation_hotel_tb
	INNER JOIN reservation_city_tb ON reservation_hotel_tb.city = reservation_city_tb.id
WHERE
    reservation_hotel_tb.`is_del` = 'no' AND
	reservation_hotel_tb.`name` LIKE '%{$name}%'
	OR reservation_hotel_tb.`name_en` LIKE '%{$name}%' ";
        $reservationHotels   = $Model->select( $sqlReservationHotel );
        $labelReservation = "no";
        if ( count( $reservationHotels ) > 0 ) {
            foreach ( $reservationHotels as $hotel ) {
                $i ++;
                //				$ReservationHotel = [];
                $hotelNameEn = trim( strtolower( $hotel['hotel_name_en'] ) );
                $hotelNameEn = str_replace( "  ", " ", $hotelNameEn );
                $hotelNameEn = str_replace( " ", "-", $hotelNameEn );
                $ReservationHotel = [
                    'HotelId'     => trim( $hotel['hotel_id'] ),
                    'HotelName'   => join(' ', [trim( $hotel['hotel_name'] ),trim( $hotel['city_name'] )]),
                    'HotelNameEn' => $hotelNameEn,
                    'CityName'    => trim( $hotel['city_name'] ),
                    'CityId'      => $hotel['city_id'],
                ];
                $result['ReservationHotels'][] = $ReservationHotel;
            }
        }
        /*get data from api */
        Load::library( 'ApiHotelCore' );
        $ApiHotelCore = new ApiHotelCore();
        $apiResult    = $ApiHotelCore->GetHotelsByName( $name );

        functions::insertLog(json_encode(['res'=>$apiResult]),'Hotels/GetHotelsByName');
        if ( is_array( $apiResult ) && count( $apiResult ) > 0 ) {
            $apiResult = $this->excludeWebserviceHotel($apiResult);
            foreach ( $apiResult as $hotel ) {
                if(isset($hotel['NameEn'] ) && !empty($hotel['NameEn'] )){
                    $i ++;
                    $hotelNameEn = strtolower( trim( urldecode( $hotel['NameEn'] ) ) );
                    $hotelNameEn = str_replace( "  ", " ", $hotelNameEn );
                    $hotelNameEn = str_replace( " ", "-", $hotelNameEn );
                    $ApiHotel    = [
                        'HotelId'     => $hotel['Id'],
                        'HotelName'   => $hotel['Name'],
                        'HotelNameEn' => $hotelNameEn,
                        'CityName'    => $hotel['CityName'],
                        'CityId'      => $hotel['CityId'],
                    ];

                    $result['ApiHotels'][] = $ApiHotel;
                }


            }
        }


        return functions::clearJsonHiddenCharacters( json_encode( $result ) );
    }
    public function getHotelListByCityId($params) {

        $result =   $this->getHotelListByCity( ['city_name' => $params['name']] );
        $result = json_decode($result , true);
        return $result['Result'];
    }
    public function excludeWebserviceHotel($hotel_list) {
        $webserviceHotelController = $this->getController('webserviceHotel') ;
        $webserviceHotel = $webserviceHotelController->getNotIncludeWebservice('13');

        $result = [] ; 
        foreach ($hotel_list as $hotel) {
            if(!in_array( $hotel['index'] , $webserviceHotel )){
                $result[] = $hotel;
            }
        }
       
        return $result;
    }
}