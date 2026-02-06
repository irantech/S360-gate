<?php


class package extends clientAuth
{
    protected $softWareLang;
    protected $model;
    protected $modelBase;

    public function __construct()
    {

        $this->softWareLang = SOFTWARE_LANG;
        $this->model = new Model();
        $this->modelBase = new ModelBase();
    }

    public function getPackage($params)
    {

        functions::insertLog('first package=>'.json_encode($params,256),'package_log');
        $configDataRoute = functions::configDataRoute($params['urlWeb']);

//        $params['privateSearch'] = true ;

        $today = dateTimeSetting::jdate("Y-m-d", time(), '', '', 'en');
        $statusCode = 200;

        if (($today <= $configDataRoute['departureDate']) &&
            ($configDataRoute['departureDate'] < $configDataRoute['arrivalDate']) &&
            $configDataRoute['arrivalDate'] != "") {
            $airportModel = $this->getModel('airportModel');
            $originCheck = $airportModel->get()->where('DepartureCode', $configDataRoute['origin'])->find();
            $destinationCheck = $airportModel->get()->where('DepartureCode', $configDataRoute['destination'])->find();
            if (isset($configDataRoute['isInternal']) ) {
                functions::insertLog('before flight package','package_log');

                if($originCheck['IsInternal'] != '1' || $destinationCheck['IsInternal'] != '1'){
                    $configDataRoute['isInternal'] = false ;
                }

                $flight = json_decode($this->searchPackageFlight($params , $configDataRoute['isInternal'] ), true);




                functions::insertLog('after decode flight package','package_log');

                $i = 0 ;
                foreach ($flight['resultFlight'] as  $resultFlight) {
//                    if ($resultFlight['Capacity'] > 0) {
//                        if ($i <= 50) {
                            $prices []= $resultFlight['AdtPrice'] ;
                            $flightFinal[] = $resultFlight;
                            $i++ ;
//                        }
//                    }
                }
                $flight['minPrice'] = round(min($prices));
                $flight['maxPrice'] = round(max($prices));
                $flight['resultFlight'] = $flightFinal;
//                functions::insertLog('after flight package=>'.json_encode($flight,256),'package_log');

                if (!empty($flight['resultFlight'])) {
                    functions::insertLog('before hotel package','package_log');

                    $hotel = json_decode($this->hotelListForPackage($configDataRoute), true);


//                    $hotel['Result'] = [];

                    functions::insertLog('after decode hotel package','package_log');

                    $j = 0;
                    $hotelFinal = [];
                    $counter = 200 ;
                    if($destinationCheck['IsInternal'] != '1') {
                        $counter = 50 ;
                    }
                    foreach ($hotel['Result'] as $key => $resultHotel) {
                        if ($resultHotel['MinPrice'] > 0 ) {
                            
                            if( $j < $counter)
                            {
                                $hotelFinal[] = $resultHotel;
                                $j++ ;

                            }
                        }
                    }
                    $hotel['Result'] = $hotelFinal;
//                    functions::insertLog('after decode hotel package=>'.json_encode($hotel,256),'package_log');

                    if (!empty($hotel['Result'])) {
                        $data['flight'] = $flight;
                        $data['hotel'] = $hotel;
                        $data['Status'] = true;


                        foreach ($data['flight']['resultFlight'] as $keyFlight => $valueFlight) {
                            if ($valueFlight['AdtPrice'] == $flight['minPrice']) {
                                $finalSpecificFlight = $valueFlight;
                            }

                        }
                        $data['specificFlight'] = $finalSpecificFlight;

                    } else {
                        list($data, $statusCode) = $this->getError('HotelError', 'متاسفانه جستجوی شما در بازه زمانی مورد نظر نتیجه ایی نداشت');
                    }
                } else {
                    list($data, $statusCode) = $this->getError('FlightError', 'متاسفانه جستجوی شما در بازه زمانی مورد نظر نتیجه ایی نداشت');
                }
            } else {
                list($data, $statusCode) = $this->getError('isInternalError', 'خطا در جستجوی نتایج،لطفا با پشتیبانی تماس بگیرید');
            }

        } else {
            list($data, $statusCode) = $this->getError('DateError', 'تاریخ انتخاب شده اشتباه است لطفا در انتخاب تاریخ و مسیر خود دقت فرمائید');
        }

        $data['softwareLang'] = $this->softWareLang;
        $data['isInternal'] = $configDataRoute['isInternal'];
        $data['totalPerson'] = $configDataRoute['totalPerson'];
        $data['totalNight'] = functions::dateDiff($configDataRoute['departureDate'], $configDataRoute['arrivalDate']);
        if ($configDataRoute['isInternal']) {
            $cityInternal = functions::CityInternal($configDataRoute['destination']);
            $cityArrival = $cityInternal['Departure_City'];
        } else {
            $cityForeign = functions::CityForeign($configDataRoute['departureDate']);
            $cityArrival = $cityForeign['DepartureCityFa'];
        }
        $data['nameArrival'] = $cityArrival;
//        functions::insertLog('after complex data package=>'.json_encode($data,256),'package_log');

        echo functions::returnJson($data, $statusCode);
        functions::insertLog('end package=>'.json_encode($params,256),'package_log');
    }

    private function hotelListForPackage($configDataRoute)
    {

        $coreHotel = Load::library('ApiHotelCore');

        $dataSearchHotelList['startDate'] = $configDataRoute['departureDate'];
        $dataSearchHotelList['endDate'] = $configDataRoute['arrivalDate'];
        $dataSearchHotelList['isInternal'] = (bool)$configDataRoute['isInternal'];
        if ($configDataRoute['isInternal']) {

            $city = functions::InfoRoute($configDataRoute['destination']);
            $dataSearchHotelList['city'] = $city['Departure_CityEn'];
            $dataSearchHotelList['Country'] = '';
            $roomsArray = '';

            foreach ($configDataRoute['Rooms'] as $room){
                $roomsArray .= 'R:'. $room['adult'].'-'.$room['child'].'-'.$room['ageChild'] ;
            }
            $dataSearchHotelList['Country'] = 'iran';
            $rooms = functions::numberOfRoomsExternalHotelSearch($roomsArray);
            $numberRooms = functions::numberOfRoomsExternalHotelRequested($rooms['rooms']);
            $roomsArray = functions::ExternalRomsHotelForSearch($numberRooms);
            $dataSearchHotelList['roomsArray'] = $roomsArray['roomsArray'];
            $dataSearchHotelList['getPackage'] = true;
        } else {
            $countryInfo = functions::NameCityForeign($configDataRoute['destination']);
            $dataSearchHotelList['city'] = $countryInfo['DepartureCityEn'];
            $dataSearchHotelList['Country'] = $countryInfo['CountryEn'];
            $roomsArray = '';

            foreach ($configDataRoute['Rooms'] as $room){
                $roomsArray .= 'R:'. $room['adult'].'-'.$room['child'].'-'.$room['ageChild'] ;
            }
            $rooms = functions::numberOfRoomsExternalHotelSearch($roomsArray);
            $numberRooms = functions::numberOfRoomsExternalHotelRequested($rooms['rooms']);
            $roomsArray = functions::ExternalRomsHotelForSearch($numberRooms);
            $dataSearchHotelList['roomsArray'] = $roomsArray['roomsArray'];
            $dataSearchHotelList['getPackage'] = true;
        }

        functions::insertLog('before list hotel package=>'.json_encode($dataSearchHotelList,256),'package_log');

                $result_hotel_list = $coreHotel->hotelList($dataSearchHotelList);

        functions::insertLog('after list hotel package=>'.json_encode($dataSearchHotelList,256),'package_log');

            return $result_hotel_list;


    }

    /**
     * @param $params
     */
    private function searchPackageFlight($params , $is_internal)
    {
        Load::controllerWithParams('newApiFlight');
        $newObjectController = new newApiFlight($params['urlWeb']);

        return $newObjectController->getDataPackage($is_internal);
    }

    public function getDetailAndPrice($params)
    {

        $getPriceController = Load::controller('detailHotel');
        $params['getPackage'] = true ;
        $dataHotel['detail'] = json_decode($getPriceController->Detail($params),true);
        $dataHotel['price'] =json_decode($getPriceController->getPrices($params),true);

        foreach (  $dataHotel['price']['Result'] as $key => $room ) {
            $sort['Rates'][$key] = $room['Rates'][0]['TotalPrices']['Online'];
        }

        if (!empty($sort)) {
            array_multisort($sort['Rates'], SORT_ASC, $dataHotel['price']['Result']);
        }

        if(empty($dataHotel['price']))
        {
            list($data,$statusCode) =  $this->getError('Error','در حال حاضر برای این هتل ، رزرو اتاق به صورت آنلاین امکان پزیر نمی باشد لظفا هتل دیگری را انتخاب نمائید');

            return functions::returnJson($data, $statusCode);
        }
        return json_encode($dataHotel) ;
    }

    public function revalidateFlight($param)
    {

        $apiLocal = Load::library('apiLocal');
        $dataRevalidate = array(
            'Flight' => $param['flightID'],
            'ReturnFlightID' => $param['returnFlightID'],
            'adt' => $param['adult'],
            'chd' => $param['child'],
            'inf' => $param['infant'],
            'SourceId' => $param['sourceID'],
            'UserName' => $param['UserName'],
            'type' => 'package',
            'UniqueCode' => $param['requestNumber'],
        );

        echo $apiLocal->Revalidate($dataRevalidate);


    }

    public function InsertHotelPackage($params)
    {

        $detail = $params['detail'];

        $SelectedRoom[] = $params['SelectedRoom'];
        $JsonChild = $params['JsonChild'];
        $arrayChild = array();
        $arrayChildFinal = array();
        $arrayDecodeChild = json_decode($JsonChild,true) ;

        foreach ( $arrayDecodeChild as $key=>$child){
            foreach ( $child as $keySubChild=>$SubChild) {
                $childArray[][]  = json_encode($SubChild['arr']);
                $arrayChild['arr'] = json_encode($childArray);
                $arrayChild['count'] = $SubChild['count'];
            }
            $arrayChildFinal[$key][] = $arrayChild;
        }

        $dataHotel['IsInternal'] = $detail['Result']['IsInternal'];
        $dataHotel['IdCity'] = $detail['Result']['CityId'];
        $dataHotel['IdHotel'] = $detail['Result']['HotelIndex'];
        $dataHotel['SDate'] = $detail['History']['StartDate'];
        $dataHotel['EDate'] = $detail['History']['EndDate'];
        $dataHotel['Nights'] = $detail['Result']['NightsCount'];
        $dataHotel['webServiceType'] = $detail['WebServiceType'];
        $dataHotel['Prices'] = json_encode($SelectedRoom);
        $dataHotel['HotelDetail'] = json_encode($detail);
        $dataHotel['TotalNumberRoom_Reserve'] = $SelectedRoom[0]['Rates'][0]['RoomToken'] . '-'.$params['countRoomsSelected'];
        $dataHotel['roomChildArr'] = $arrayChildFinal;
        $dataHotel['TotalNumberExtraBed_Reserve'] = '';
        $dataHotel['requestNumber'] = $detail['RequestNumber'];
        $dataHotel['type'] = 'package';
        $dataHotel['PriceSessionId'] = $params['PriceSessionId'];

        $objHotel = Load::controller('detailHotel');
        echo $objHotel->insertTemporaryHotel($dataHotel);

    }

    public function getDataTempPackage($params)
    {
        $dataPackage['hotel'] = $this->getDataHotelTemp($params);

        return $dataPackage;
    }

    /**
     * @param $type
     * @param $message
     * @return array
     */
    public function getError($type, $message)
    {
        $data['Status'] = false;
        $data['StatusType'] = $type;
        $data['Message'] = $message;
        $statusCode = 400;
        return array($data, $statusCode);
    }

    private function getDataFlightTemp($params)
    {
        $temporary_local = Load::model('temporary_local');
        $PassengersDetailLocalController = Load::controller('passengersDetailLocal');
        $data['mainFlight'] = $temporary_local->get($params['unique_id']);
        $data['detailRoute'] = $PassengersDetailLocalController->DetailRoutes($data['mainFlight']['TwoWay']['id']);

        return $data;
    }

    private function getDataHotelTemp($param)
    {

        $detailHotelController = Load::controller('detailHotel');
//        if ($param['isInternal'] == "true") {
//            return $detailHotelController->getPassengersDetailHotelLocal($param['factorNumberHotel'], $param['StartDate'], $param['nights'], $param['TotalNumberRoom_Reserve']);
//        } else {
            $temp_model = Load::getModel('temporaryHotelLocalModel');
            $temporaryHotel = $temp_model->get()->where('factor_number', $param['factorNumberHotel'])->limit(0,1)->find();
            $search_rooms = $temporaryHotel['search_rooms'];

            return $detailHotelController->getPassengersDetailHotelExternal($param['factorNumberHotel'], $param['StartDate'], $param['nights'], $param['TotalNumberRoom_Reserve'], $search_rooms);
//        }
    }

    public function PerReserveHotel($formData)
    {
        if (!empty($formData)) {
            parse_str($formData, $_POST);
            $_POST['passenger_leader_room'] = $_POST['Mobile'];
        }

        $this->IsLogin = Session::IsLogin();

        $factorNumber = $_POST['factorNumber'];
        $typeApplication = $_POST['typeApplication'];
        $IdMember = $_POST['IdMember'];

        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $passengerController = Load::controller('passengers');
        $detailHotelController = Load::controller('detailHotel');

        $objClientAuth = Load::library('clientAuth');
        $objClientAuth->apiHotelAuth();
        $sourceId = $objClientAuth->sourceId;
        //$sourceId = '6';
        $serviceTitle = functions::TypeServiceHotel($_POST['typeApplication']);
        $irantechCommission = Load::controller('irantechCommission');
        $it_commission = $irantechCommission->getCommission($serviceTitle, $sourceId);

        $errorResult = [];
        $i = 1;
        $hasError = true;


        while (isset($_POST["genderA" . $i])) {

            if ($_POST['typeApplication'] == 'externalApi') {
                $sql_check_temprory = "
                SELECT id,
                room_index,
                	is_internal,
                    type_of_price_change,
                    agency_commission_price_type,
                    agency_commission AS agency_commission_sum,
                    price_online_current  AS price_online_current_sum,
                    price_board_current AS price_board_current_sum,
                    price_current AS price_current_sum,
                    price_foreign_current AS price_foreign_current_sum
                FROM
                    temprory_hotel_local_tb
                WHERE
                    factor_number = '{$factorNumber}'
                    AND room_id = '{$_POST['Id_Select_Room' . $i]}'
                    GROUP BY room_index
                    ";
                //			error_log($sql_check_temprory,3,LOGS_DIR.'sqlTest.txt');
                $price_rooms = $Model->select($sql_check_temprory);


                $hasError = true;

                $this->adultArr[$i]['room_index'] = 0;
                if (isset($_POST['roomIndex' . $i])) {
                    $this->adultArr[$i]['room_index'] = $_POST['roomIndex' . $i];
                }

                foreach ($price_rooms as $price_room) {

                    if (!empty($price_room) && $price_room['price_current_sum'] > 0) {
                        $extraBed = $price_room['is_internal'] ? $_POST['extra_bed_count-' . $i] : 0;
                        $dataAdult[$i]['request_number'] = $_POST["requestNumber"];
                        $dataAdult[$i]['gender'] = $_POST["genderA" . $i];

                        $dataAdult[$i]['extra_bed_count'] = $extraBed;

                        $dataAdult[$i]['name_en'] = $_POST["nameEnA" . $i];
                        $dataAdult[$i]['family_en'] = $_POST["familyEnA" . $i];
                        $dataAdult[$i]['name'] = $_POST["nameFaA" . $i];
                        $dataAdult[$i]['family'] = $_POST["familyFaA" . $i];
                        $dataAdult[$i]['NationalCode'] = $_POST["NationalCodeA" . $i];
                        $dataAdult[$i]['fk_members_tb_id'] = $_POST["idMember"];
                        $dataAdult[$i]['passportCountry'] = $_POST["passportCountryA" . $i];
                        $dataAdult[$i]['passportNumber'] = $_POST["passportNumberA" . $i];
                        $dataAdult[$i]['passportExpire'] = $_POST["passportExpireA" . $i];
                        $dataAdult[$i]['passenger_leader_room'] = $_POST["passenger_leader_room"];
                        $dataAdult[$i]['passenger_leader_room_fullName'] = $_POST["passenger_leader_room_fullName"];
                        $dataAdult[$i]['BedType'] = $_POST["BedType" . $i];
                        $dataAdult[$i]['Id_Select_Room'] = $_POST["Id_Select_Room" . $i];

                        if (isset($_POST["timeEnteringRoom" . $i])) {
                            $dataAdult[$i]['time_entering_room'] = $_POST["timeEnteringRoom" . $i];
                        }

                        $dataAdult[$i]['room_price'] = $price_room['price_current_sum'];
                        $dataAdult[$i]['room_bord_price'] = $price_room['price_board_current_sum'];
                        $dataAdult[$i]['room_online_price'] = $price_room['price_online_current_sum'];

                        if ($_POST["passengerNationalityA" . $i] == '0') {

                            $dataAdult[$i]['birthday_fa'] = $_POST["birthdayA" . $i];
                            $dataAdult[$i]['birthday'] = '';

                        } else {
                            $dataAdult[$i]['birthday_fa'] = '';
                            $dataAdult[$i]['birthday'] = $_POST["birthdayEnA" . $i];
                        }

                        $dataAdult[$i]['agency_commission'] = $price_room['agency_commission_sum'];
                        $dataAdult[$i]['agency_commission_price_type'] = $price_room['agency_commission_price_type'];
                        $dataAdult[$i]['type_of_price_change'] = $price_room['type_of_price_change'];

                        if ($this->IsLogin) {
                            $passengerAddArray = array(
                                'passengerName' => $dataAdult[$i]['name'],
                                'passengerNameEn' => $dataAdult[$i]['name_en'],
                                'passengerFamily' => $dataAdult[$i]['family'],
                                'passengerFamilyEn' => $dataAdult[$i]['family_en'],
                                'passengerGender' => $dataAdult[$i]['gender'],
                                'passengerBirthday' => $dataAdult[$i]['birthday_fa'],
                                'passengerNationalCode' => $dataAdult[$i]['NationalCode'],
                                'passengerBirthdayEn' => $dataAdult[$i]['birthday'],
                                'passengerPassportCountry' => $dataAdult[$i]['passportCountry'],
                                'passengerPassportNumber' => $dataAdult[$i]['passportNumber'],
                                'passengerPassportExpire' => $dataAdult[$i]['passportExpire'],
                                'memberID' => $dataAdult[$i]['fk_members_tb_id'],
                                'passengerNationality' => $_POST["passengerNationalityA" . $i]
                            );

                            $passegerInsert = $passengerController->insert($passengerAddArray);
                        }

                        if (ISCURRENCY && $_POST['CurrencyCode'] > 0) {
                            $Currency = Load::controller('currencyEquivalent');
                            $InfoCurrency = $Currency->InfoCurrency($_POST['CurrencyCode']);
                        }

                        $dataAdult[$i]['currency_code'] = $_POST['CurrencyCode'];
                        $dataAdult[$i]['currency_equivalent'] = !empty($InfoCurrency) ? $InfoCurrency['EqAmount'] : '0';

                        $errorResult = $detailHotelController->FirstBookHotel($dataAdult[$i], $IdMember, $factorNumber, $typeApplication, $it_commission, $i);
                        $hasError = false;

                    } else {
                        $errorResult [] = 0;
                    }
                }
            } else {
                $sql_check_temprory = "
                SELECT id, room_index,
                	is_internal,
                    type_of_price_change,
                    agency_commission_price_type,
                    SUM( agency_commission ) AS agency_commission_sum,
                    SUM( price_online_current ) AS price_online_current_sum,
                    SUM( price_board_current ) AS price_board_current_sum,
                    SUM( price_current ) AS price_current_sum,
                    SUM( price_foreign_current ) AS price_foreign_current_sum
                FROM
                    temprory_hotel_local_tb
                WHERE
                    factor_number = '{$factorNumber}'
                    AND room_id = '{$_POST['Id_Select_Room']}';
                            ";
                $price_room = $Model->load($sql_check_temprory);

                $hasError = true;
                $extraBed = 0 /*$price_room['is_internal'] ? $_POST[ 'extra_bed_count-' . $i ] : */
                ;

                $dataAdult[$i]['room_index'] = 0;
                if (isset($_POST['roomIndex' . $i])) {
                    $dataAdult[$i]['room_index'] = $_POST['roomIndex' . $i];
                }
                if (!empty($price_room) && $price_room['price_current_sum'] > 0) {

                    $dataAdult[$i]['request_number'] = $_POST["requestNumber"];
                    $dataAdult[$i]['gender'] = $_POST["genderA" . $i];

                    $dataAdult[$i]['extra_bed_count'] = $extraBed;

                    $dataAdult[$i]['name_en'] = $_POST["nameEnA" . $i];
                    $dataAdult[$i]['family_en'] = $_POST["familyEnA" . $i];
                    $dataAdult[$i]['name'] = $_POST["nameFaA" . $i];
                    $dataAdult[$i]['family'] = $_POST["familyFaA" . $i];
                    $dataAdult[$i]['NationalCode'] = $_POST["NationalCodeA" . $i];
                    $dataAdult[$i]['fk_members_tb_id'] = $_POST["IdMember"];
                    $dataAdult[$i]['passportCountry'] = $_POST["passportCountryA" . $i];
                    $dataAdult[$i]['passportNumber'] = $_POST["passportNumberA" . $i];
                    $dataAdult[$i]['passportExpire'] = $_POST["passportExpireA" . $i];
                    $dataAdult[$i]['passenger_leader_room'] = $_POST["passenger_leader_room"];
                    $dataAdult[$i]['passenger_leader_room_fullName'] = $_POST["passenger_leader_room_fullName"];
                    $dataAdult[$i]['BedType'] = $_POST["BedType" . $i];
                    $dataAdult[$i]['Id_Select_Room'] = $_POST["Id_Select_Room"];

                    if (isset($_POST["timeEnteringRoom" . $i])) {
                        $dataAdult[$i]['time_entering_room'] = $_POST["timeEnteringRoom" . $i];
                    }

                    $dataAdult[$i]['room_price'] = $price_room['price_current_sum'];
                    $dataAdult[$i]['room_bord_price'] = $price_room['price_board_current_sum'];
                    $dataAdult[$i]['room_online_price'] = $price_room['price_online_current_sum'];

                    if ($_POST["passengerNationalityA" . $i] == '0') {

                        $dataAdult[$i]['birthday_fa'] = $_POST["birthdayA" . $i];
                        $dataAdult[$i]['birthday'] = '';

                    } else {
                        $dataAdult[$i]['birthday_fa'] = '';
                        $dataAdult[$i]['birthday'] = $_POST["birthdayEnA" . $i];
                    }

                    $dataAdult[$i]['agency_commission'] = $price_room['agency_commission_sum'];
                    $dataAdult[$i]['agency_commission_price_type'] = $price_room['agency_commission_price_type'];
                    $dataAdult[$i]['type_of_price_change'] = $price_room['type_of_price_change'];

                    if ($this->IsLogin) {
                        $passengerAddArray = array(
                            'passengerName' => $dataAdult[$i]['name'],
                            'passengerNameEn' => $dataAdult[$i]['name_en'],
                            'passengerFamily' => $dataAdult[$i]['family'],
                            'passengerFamilyEn' => $dataAdult[$i]['family_en'],
                            'passengerGender' => $dataAdult[$i]['gender'],
                            'passengerBirthday' => $dataAdult[$i]['birthday_fa'],
                            'passengerNationalCode' => $dataAdult[$i]['NationalCode'],
                            'passengerBirthdayEn' => $dataAdult[$i]['birthday'],
                            'passengerPassportCountry' => $dataAdult[$i]['passportCountry'],
                            'passengerPassportNumber' => $dataAdult[$i]['passportNumber'],
                            'passengerPassportExpire' => $dataAdult[$i]['passportExpire'],
                            'memberID' => $dataAdult[$i]['fk_members_tb_id'],
                            'passengerNationality' => $_POST["passengerNationalityA" . $i]
                        );

                        $passegerInsert = $passengerController->insert($passengerAddArray);
                    }

                    if (ISCURRENCY && $_POST['CurrencyCode'] > 0) {
                        $Currency = Load::controller('currencyEquivalent');
                        $InfoCurrency = $Currency->InfoCurrency($_POST['CurrencyCode']);
                    }

                    $dataAdult[$i]['currency_code'] = $_POST['CurrencyCode'];
                    $dataAdult[$i]['currency_equivalent'] = !empty($InfoCurrency) ? $InfoCurrency['EqAmount'] : '0';
                    $errorResult = $detailHotelController->FirstBookHotel($dataAdult[$i], $IdMember, $factorNumber, $typeApplication, $it_commission, $i);
                    $hasError = false;

                } else {

                    $errorResult [] = 0;
                }
            }
            $i++;
        }


        $c = 1;
        if ($_POST['typeApplication'] == 'externalApi') {
            while (isset($_POST['genderC' . $c])) {

                $sql_check_temprory = "
                SELECT id,
                room_index,
                	is_internal,
                    type_of_price_change,
                    agency_commission_price_type,
                    agency_commission AS agency_commission_sum,
                    price_online_current  AS price_online_current_sum,
                    price_board_current AS price_board_current_sum,
                    price_current AS price_current_sum,
                    price_foreign_current AS price_foreign_current_sum
                FROM
                    temprory_hotel_local_tb
                WHERE
                    factor_number = '{$factorNumber}'
                    AND room_id = '{$_POST['Id_Select_Room' . $c]}'
                    GROUP BY room_index
                    ";

                //			error_log($sql_check_temprory,3,LOGS_DIR.'sqlTest.txt');
                $price_rooms = $Model->select($sql_check_temprory);


                $hasError = true;

                $dataAdult[$c]['room_index'] = 0;
                if (isset($_POST['roomIndex' . $c])) {
                    $dataAdult[$c]['room_index'] = $_POST['roomIndex' . $c];
                }

                foreach ($price_rooms as $price_room) {

                    if (!empty($price_room) && $price_room['price_current_sum'] > 0) {
                        $extraBed = $price_room['is_internal'] ? $_POST['extra_bed_count-' . $c] : 0;
                        $dataAdult[$c]['request_number'] = $_POST["requestNumber"];
                        $dataAdult[$c]['gender'] = $_POST["genderC" . $c];

                        $dataAdult[$c]['extra_bed_count'] = $extraBed;

                        $dataAdult[$c]['name_en'] = $_POST["nameEnC" . $c];
                        $dataAdult[$c]['family_en'] = $_POST["familyEnC" . $c];
                        $dataAdult[$c]['name'] = $_POST["nameFaC" . $c];
                        $dataAdult[$c]['family'] = $_POST["familyFaC" . $c];
                        $dataAdult[$c]['NationalCode'] = $_POST["NationalCodeC" . $c];
                        $dataAdult[$c]['fk_members_tb_id'] = $_POST["idMember"];
                        $dataAdult[$c]['passportCountry'] = $_POST["passportCountryC" . $c];
                        $dataAdult[$c]['passportNumber'] = $_POST["passportNumberC" . $c];
                        $dataAdult[$c]['passportExpire'] = $_POST["passportExpireC" . $c];
                        $dataAdult[$c]['passenger_leader_room'] = $_POST["passenger_leader_room"];
                        $dataAdult[$c]['passenger_leader_room_fullName'] = $_POST["passenger_leader_room_fullName"];
                        $dataAdult[$c]['BedType'] = $_POST["BedType" . $c];
                        $dataAdult[$c]['Id_Select_Room'] = $_POST["Id_Select_Room" . $c];
                        $dataAdult[$c]['passenger_age'] = 'Chd';

                        if (isset($_POST["timeEnteringRoom" . $c])) {
                            $dataAdult[$c]['time_entering_room'] = $_POST["timeEnteringRoom" . $c];
                        }

                        $dataAdult[$c]['room_price'] = $price_room['price_current_sum'];
                        $dataAdult[$c]['room_bord_price'] = $price_room['price_board_current_sum'];
                        $dataAdult[$c]['room_online_price'] = $price_room['price_online_current_sum'];

                        if ($_POST["passengerNationalityC" . $c] == '0') {

                            $dataAdult[$c]['birthday_fa'] = $_POST["birthdayC" . $c];
                            $dataAdult[$c]['birthday'] = '';

                        } else {
                            $dataAdult[$c]['birthday_fa'] = '';
                            $dataAdult[$c]['birthday'] = $_POST["birthdayEnC" . $c];
                        }

                        $dataAdult[$c]['agency_commission'] = $price_room['agency_commission_sum'];
                        $dataAdult[$c]['agency_commission_price_type'] = $price_room['agency_commission_price_type'];
                        $dataAdult[$c]['type_of_price_change'] = $price_room['type_of_price_change'];

                        if ($this->IsLogin) {
                            $passengerAddArray = array(
                                'passengerName' => $dataAdult[$c]['name'],
                                'passengerNameEn' => $dataAdult[$c]['name_en'],
                                'passengerFamily' => $dataAdult[$c]['family'],
                                'passengerFamilyEn' => $dataAdult[$c]['family_en'],
                                'passengerGender' => $dataAdult[$c]['gender'],
                                'passengerBirthday' => $dataAdult[$c]['birthday_fa'],
                                'passengerNationalCode' => $dataAdult[$c]['NationalCode'],
                                'passengerBirthdayEn' => $dataAdult[$c]['birthday'],
                                'passengerPassportCountry' => $dataAdult[$c]['passportCountry'],
                                'passengerPassportNumber' => $dataAdult[$c]['passportNumber'],
                                'passengerPassportExpire' => $dataAdult[$c]['passportExpire'],
                                'memberID' => $dataAdult[$c]['fk_members_tb_id'],
                                'passengerNationality' => $_POST["passengerNationalityC" . $c]
                            );

                            $passegerInsert = $passengerController->insert($passengerAddArray);
                        }

                        if (ISCURRENCY && $_POST['CurrencyCode'] > 0) {
                            $Currency = Load::controller('currencyEquivalent');
                            $InfoCurrency = $Currency->InfoCurrency($_POST['CurrencyCode']);
                        }

                        $dataAdult[$i]['currency_code'] = $_POST['CurrencyCode'];
                        $dataAdult[$i]['currency_equivalent'] = !empty($InfoCurrency) ? $InfoCurrency['EqAmount'] : '0';
                        $errorResult = $detailHotelController->FirstBookHotel($dataAdult[$c], $IdMember, $factorNumber, $typeApplication, $it_commission, $c);
                        $hasError = false;

                    } else {
                        $errorResult [] = 0;
                    }
                }

                $c++;

            }
        }


        if (!$hasError) {
            $meesage['status'] = 'success';
            return json_encode($meesage);
        } else {
            $meesage['status'] = 'error';
            return json_encode($meesage);
        }

    }

    public function getDataFlight($requestNumber)
    {
        $Sql = "SELECT * FROM book_local_tb WHERE  request_number='{$requestNumber}'";

        return $this->model->select($Sql, 'assoc');

    }


    public function getDataBookHotel($factorNumber)
    {

        $sqlDataHotel = " SELECT * FROM book_hotel_local_tb WHERE factor_number ='{$factorNumber}'ORDER BY room_id, flat_type ";
        $resultDataHotel = $this->model->select($sqlDataHotel);

        $AuxiliaryVariableRoom = $resultDataHotel[0]['room_id']; // Group by room
        $indexRoom = 0;
        $room_price = 0;
        $room_price_api = 0;
        $totalPrice = 0;
        $totalPriceApi = 0;
        $bed_price = 0;
        $ext = 0;
        $roomExternalIndex = 0;
        foreach ($resultDataHotel as $k => $hotel) {
            if ($AuxiliaryVariableRoom != $hotel['room_id']) {
                $AuxiliaryVariableRoom = $hotel['room_id'];
                $indexRoom = 0;
                $room_price = 0;
                $bed_price = 0;
                $ext = 0;
            }

            //info hotel
            if ($k == 0) {
                $dataBookHotel['is_internal'] = $hotel['type_application'] == 'externalApi' ? 0 : 1;
                $dataBookHotel['factor_number'] = $hotel['factor_number'];
                $dataBookHotel['passenger_leader_tell'] = $hotel['passenger_leader_room'];
                $dataBookHotel['passenger_leader_fullName'] = $hotel['passenger_leader_room_fullName'];
                $dataBookHotel['city_name'] = $hotel['city_name'];
                $dataBookHotel['hotel_id'] = $hotel['hotel_id'];
                $dataBookHotel['hotel_name'] = $hotel['hotel_name'];
                $dataBookHotel['hotel_address'] = $hotel['hotel_address'];
                $dataBookHotel['hotel_starCode'] = $hotel['hotel_starCode'];
                if (SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar') {
                    $dataBookHotel['start_date'] = functions::ConvertToMiladi($hotel['start_date']);
                    $dataBookHotel['end_date'] = functions::ConvertToMiladi($hotel['end_date']);
                } else {
                    $dataBookHotel['start_date'] = $hotel['start_date'];
                    $dataBookHotel['end_date'] = $hotel['end_date'];
                }
                $dataBookHotel['number_night'] = $hotel['number_night'];
                $dataBookHotel['type_application'] = $hotel['type_application'];
                $dataBookHotel['hotel_rules'] = $hotel['hotel_rules'];
                $dataBookHotel['hotel_pictures'] = ($hotel['type_application'] == 'api' || $hotel['type_application'] == 'externalApi' || $hotel['type_application'] == 'api_app') ? "{$hotel['hotel_pictures']}" : ROOT_ADDRESS_WITHOUT_LANG . "/pic/{$hotel['hotel_pictures']}";

                $indexRoom = 0;
                $room_price = 0;
                $room_price_api = 0;
                $bed_price = 0;
                $ext = 0;

            }

            //info passenger

            $dataBookHotel['passenger'][$k]['passenger_name'] = $hotel['passenger_name'];
            $dataBookHotel['passenger'][$k]['passenger_family'] = $hotel['passenger_family'];
            $dataBookHotel['passenger'][$k]['passenger_ageCategory'] = $hotel['passenger_age'];
            $dataBookHotel['passenger'][$k]['passenger_name_en'] = $hotel['passenger_name_en'];
            $dataBookHotel['passenger'][$k]['passenger_family_en'] = $hotel['passenger_family_en'];
            $dataBookHotel['passenger'][$k]['passenger_birthday'] = $hotel['passenger_birthday'];
            $dataBookHotel['passenger'][$k]['passenger_birthday_en'] = $hotel['passenger_birthday_en'];
            $dataBookHotel['passenger'][$k]['passenger_national_code'] = $hotel['passenger_national_code'];
            $dataBookHotel['passenger'][$k]['passportNumber'] = $hotel['passportNumber'];
            $dataBookHotel['passenger'][$k]['room_price'] = $hotel['room_price'];
            $dataBookHotel['passenger'][$k]['room_name'] = $hotel['room_name'];
            $dataBookHotel['passenger'][$k]['room_id'] = $hotel['room_id'];
            $dataBookHotel['passenger'][$k]['room_index'] = $hotel['room_index'];

            //api or reservation
            if ($hotel['type_application'] == 'api' || $hotel['type_application'] == 'api_app' || $hotel['type_application'] == 'externalApi') {
                //				echo Load::plog($hotel['room_count']);
                $dataBookHotel['passenger'][$k]['title_flat_type'] = functions::Xmlinformation('HeadOfRoom');

                $room_price_api = $hotel['room_price'] * $hotel['room_count'];
                $room_price = $room_price_api;


                if ($hotel['type_of_price_change'] == 'increase' && $hotel['agency_commission_price_type'] == 'cost') {
                    $room_price = ($hotel['room_price'] + $hotel['agency_commission']) * $hotel['room_count'];

                } elseif ($hotel['type_of_price_change'] == 'decrease' && $hotel['agency_commission_price_type'] == 'cost') {
                    $room_price = ($hotel['room_price'] - $hotel['agency_commission']) * $hotel['room_count'];

                } elseif ($hotel['type_of_price_change'] == 'increase' && $hotel['agency_commission_price_type'] == 'percent') {
                    $room_price = (($hotel['room_price'] * $hotel['agency_commission'] / 100) + $hotel['room_price']) * $hotel['room_count'];

                } elseif ($hotel['type_of_price_change'] == 'decrease' && $hotel['agency_commission_price_type'] == 'percent') {
                    $room_price = (($hotel['room_price'] * $hotel['agency_commission'] / 100) - $hotel['room_price']) * $hotel['room_count'];

                } else {
                    $room_price = $hotel['room_price'] * $hotel['room_count'];
                }


                if (!empty($this->serviceDiscount['api']) && $this->serviceDiscount['api']['off_percent'] > 0) {
                    $room_price = $room_price - (($room_price * $this->serviceDiscount['api']['off_percent']) / 100);
                }
            } else {

                switch ($hotel['flat_type']) {
                    case 'DBL':
                        $room_price += $hotel['room_price'] * $hotel['room_count'];
                        $dataBookHotel['passenger'][$k]['title_flat_type'] = functions::Xmlinformation("BaseBedForRomm");
                        break;
                    case 'EXT':
                        $room_price += $hotel['room_price'];
                        $totalPrice += $bed_price += $hotel['room_price'];
                        $dataBookHotel['passenger'][$k]['title_flat_type'] = functions::Xmlinformation("ExtrabedAdult");
                        $ext++;
                        break;
                    case 'ECHD':
                        $room_price += $hotel['room_price'];
                        $totalPrice += $bed_price += $hotel['room_price'];
                        $dataBookHotel['passenger'][$k]['title_flat_type'] = functions::Xmlinformation("Extrabedchild");
                        $ext++;
                        break;
                    default:
                        $dataBookHotel['passenger'][$k]['title_flat_type'] = '';
                }


            }
            $search_rooms = json_decode($hotel['search_rooms'], true);

            if ($hotel['type_application'] == 'externalApi') {
                if ($hotel['room_index'] == $roomExternalIndex) {
                    $dataBookHotel['room'][$hotel['room_index']]['AdultsCount'] = $search_rooms[$hotel['room_index']]['Adults'];
                    $dataBookHotel['room'][$hotel['room_index']]['ChildrenCount'] = $search_rooms[$hotel['room_index']]['Children'];
                    $dataBookHotel['room'][$hotel['room_index']]['room_name'] = $hotel['room_name'];
                    $dataBookHotel['room'][$hotel['room_index']]['room_index'] = $hotel['room_index'];
                    $dataBookHotel['room'][$hotel['room_index']]['max_capacity_count_room'] = $hotel['max_capacity_count_room'];
                    $dataBookHotel['room'][$hotel['room_index']]['room_count'] = $hotel['room_count'];
                    $dataBookHotel['room'][$hotel['room_index']]['price_current'] = $hotel['price_current'];
                    $dataBookHotel['room'][$hotel['room_index']]['room_price'] = $room_price;
                    $roomExternalIndex++;
                }
            }

            //info room
            if ($indexRoom == 0) {

                if ($hotel['type_application'] == 'api' || $hotel['type_application'] == 'api_app') {
                    $price_current = $hotel['price_current'];
                    if (!empty($this->serviceDiscount['api']) && $this->serviceDiscount['api']['off_percent'] > 0) {
                        $price_current = $price_current - (($price_current * $this->serviceDiscount['api']['off_percent']) / 100);
                    }
                } else {
                    $price_current = $hotel['price_current'];
                }
                if ($hotel['type_application'] != 'externalApi') {
                    $dataBookHotel['room'][$hotel['room_id']]['room_name'] = $hotel['room_name'];
                    $dataBookHotel['room'][$hotel['room_id']]['max_capacity_count_room'] = $hotel['max_capacity_count_room'];
                    $dataBookHotel['room'][$hotel['room_id']]['room_count'] = $hotel['room_count'];
                    $dataBookHotel['room'][$hotel['room_id']]['price_current'] = $price_current;
                    $dataBookHotel['room'][$hotel['room_id']]['room_price'] = $room_price;
                }
                $totalPrice += $room_price;
                $totalPriceApi += $room_price_api;


            }

            if ($hotel['type_application'] == 'externalApi') {
                $dataBookHotel['room'][$hotel['room_index']]['remarks'] = $hotel['remarks'];
                $dataBookHotel['room'][$hotel['room_index']]['flat_ext_count'] = $ext;
                //				$dataBookHotel['room'][ $hotel['room_index'] ]['flat_ext_count'] = $ext;
            } else {
                $dataBookHotel['room'][$hotel['room_id']]['flat_ext_count'] = $ext;
            }

            $indexRoom++;
        }

        if ($hotel['type_application'] == 'api' || $hotel['type_application'] == 'api_app' || $hotel['type_application'] == 'externalApi') {
            $dataBookHotel['price'] = $totalPrice;

            // payment price hotel
            $d['total_price'] = $totalPrice;
            $d['total_price_api'] = $totalPriceApi;
            $Condition = "factor_number='{$factorNumber}' ";
            $this->model->setTable("book_hotel_local_tb");
            $this->model->update($d, $Condition);

            $this->modelBase->setTable("report_hotel_tb");
            $this->modelBase->update($d, $Condition);
            $sql_temprory_hotel = " SELECT * FROM book_hotel_local_tb WHERE factor_number ='{$factorNumber}' GROUP BY room_index";
            $result_temprory_hotel = $this->model->select($sql_temprory_hotel);
            foreach ($result_temprory_hotel as $r => $room) {
                if ($hotel['type_application'] == 'externalApi') {
                    $dataBookHotel['room'][$r]['remarks'] = $room['remarks'];
                }
            }
            //				}
        } else {
            $dataBookHotel['price'] = $dataBookHotel[0]['room_price'];
        }


        return $dataBookHotel;
    }


    public function CalculatePackagePrice($RequestNumberFlight, $factorNumberHotel)
    {

        $data['priceFlight'] = functions::CalculateDiscount($RequestNumberFlight, 'yes');
        $data['priceHotel'] = functions::PriceHotel($factorNumberHotel);
        $data['total'] = intval($data['priceFlight']) + intval($data['priceHotel']);

        return $data;
    }


    public function calculatePricePackage($requestNumberFlight, $factorNumber)
    {
        $TicketPriceFlightBank = functions::CalculateDiscount($requestNumberFlight, 'yes');
        $reserveHotelInfo = functions::GetInfoHotel($factorNumber);
        $TotalPriceHotelBank = $reserveHotelInfo['totalPriceTransaction'];

        return intval($TicketPriceFlightBank + $TotalPriceHotelBank);
    }
}