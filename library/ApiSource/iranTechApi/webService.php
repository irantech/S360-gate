<?php


class webService extends baseController {

    public function __construct() {
        header( "Content-type: application/json;" );

//        if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){
//
//            $params = array(
//                'userName' => $_SERVER['PHP_AUTH_USER'] ,
//                'password' => $_SERVER['PHP_AUTH_PW'] ,
//                'ipAddress' => $_SERVER['SERVER_ADDR']
//            );
//            $jacket_customer = Load::controller('jacketCustomer') ;
//            $check_jacket = $jacket_customer->checkJacketCustomer($params);
//
//            if(!$check_jacket) {
//                $resultJsonArray = array(
//                    'Result' => array(
//                        'RequestStatus' => 'Error',
//                        'Message' => 'NotValidCustomer',
//                        'MessageCode' => 'Error200',
//                    ),
//                );
//                echo json_encode($resultJsonArray);
//                die();
//            }
//
//        }else {
//            $resultJsonArray = array(
//                'Result' => array(
//                    'RequestStatus' => 'Error',
//                    'Message' => 'NotValidCustomer',
//                    'MessageCode' => 'Error200',
//                ),
//            );
//            echo json_encode($resultJsonArray);
//            die();
//        }

       
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' && ( strpos( $_SERVER['CONTENT_TYPE'], 'application/json' ) ) !== false ) {
            $this->content         = json_decode( file_get_contents( 'php://input' ), true );
            $this->adminController = Load::controller( 'admin' );
            $method = $this->content['method'];
            $params = $this->content;
            echo  $this->$method( $params ); die();

        } else if($_SERVER['REQUEST_METHOD'] == 'POST' && ( strpos( $_SERVER['CONTENT_TYPE'], 'multipart/form-data' ) ) !== false) {

            $this->adminController = Load::controller( 'admin' );
            $method = $_POST['method'];
            $params = $_POST;
            echo  $this->$method( $params ); die();

        } else {
            $resultJsonArray = array(
                'Result' => array(
                    'RequestStatus' => 'Error',
                    'Message'       => 'NotValidTypeRequest',
                    'MessageCode'   => 'Error100',
                ),
            );
            echo  json_encode( $resultJsonArray );die();
        }
    }

    public function flightExternalRoutesDefault( $params  ) {
    
        /** @var ModelBase $ModelBase */

        $request = [];
        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }

        if ( isset( $request['self_Db'] ) && $request['self_Db'] != true ) {
            $ModelBase = Load::library( 'ModelBase' );
            $clientSql = "SELECT DepartureCode,DepartureCityEn,DepartureCityFa,AirportFa,AirportEn,CountryFa,CountryEn  FROM flight_portal_tb";

            return json_encode( $ModelBase->select( $clientSql ) );
        } else {

            $Model = Load::library( 'Model' );
            $clientSql = "SELECT DepartureCode,DepartureCityEn,DepartureCityFa,AirportFa,AirportEn,CountryFa,CountryEn  FROM flight_portal_tb";

            return json_encode( $Model->select( $clientSql ) );
        }


    }

    public function flightExternalRoutes( $params ) {

        /** @var ModelBase $ModelBase */

        $request = [];
        $filter  = $params['filter'];
        foreach ( $params as $key => $param ) {

            $request[ $key ] = functions::checkParamsInput( $param );
        }

        if ( isset( $request['self_Db'] ) && $request['self_Db'] != true ) {

            $ModelBase = Load::library( 'ModelBase' );
            $clientSql = "SELECT *  FROM flight_portal_tb WHERE DepartureCode='{$filter}'
                                   OR CountryEn Like '%{$filter}%'
                                   OR DepartureCityEn Like '%{$filter}%'
                                   OR AirportFa Like '%{$filter}%'
                                   OR AirportEn Like '%{$filter}%'
                                   OR CountryFa Like '%{$filter}%'
                                   OR DepartureCityFa Like '%{$filter}%'
                                    ORDER BY FIELD(DepartureCode,'{$filter}') DESC ";

            return json_encode( $ModelBase->select( $clientSql ) );
        } else {

            $ModelBase = Load::library( 'Model' );
            $clientSql = "SELECT *  FROM flight_portal_tb WHERE DepartureCode='{$filter}'
                                   OR CountryEn Like '%{$filter}%'
                                   OR DepartureCityEn Like '%{$filter}%'
                                   OR AirportFa Like '%{$filter}%'
                                   OR AirportEn Like '%{$filter}%'
                                   OR CountryFa Like '%{$filter}%'
                                   OR DepartureCityFa Like '%{$filter}%'
                                    ORDER BY FIELD(DepartureCode,'{$filter}') DESC ";

            return json_encode( $ModelBase->select( $clientSql ) );
        }


    }

    public function flightInternalRoutesDep( $params ) {

        /** @var ModelBase $ModelBase */


        $request = [];
        foreach ( $params as $key => $param ) {

            $request[ $key ] = functions::checkParamsInput( $param );
        }
        $filter_condition='';
        if ( isset( $request['filter'] ) && $request['filter'] != '' ) {
            $filter_condition="AND Departure_Code= '".$request['filter']."' ";
        }

        if ( isset( $request['self_Db'] ) && $request['self_Db'] == true ) {

            $ModelBase = Load::library( 'ModelBase' );
            $clientSql = " SELECT DISTINCTROW Departure_Code, Departure_City, Departure_CityEn FROM flight_route_tb WHERE local_portal ='0' ".$filter_condition."
                        GROUP BY Departure_Code";

            return json_encode( $ModelBase->select( $clientSql ) );
        } else {

            $ModelBase = Load::library( 'Model' );
            $clientSql = "SELECT DISTINCTROW Departure_Code, Departure_City, Departure_CityEn FROM flight_route_tb WHERE Local_portal ='0' ".$filter_condition." GROUP BY  Departure_Code ORDER BY priorityDeparture=0, priorityDeparture ASC";

            return json_encode( $ModelBase->select( $clientSql ) );
        }


    }

    public function searchboxHotels( $params ) {

        $name      = urldecode( $params['inputValue'] );
        $result    = [];
        $hotelHtml = '';
        $i         = 0;

        //		echo CLIENT_DOMAIN ;
        //		$sqlReservationCities = "
        //		SELECT id AS city_id,city_name AS city_name, city_name_en AS city_name_en FROM hotel_cities_tb WHERE city_name LIKE '{$name}%' OR city_name_en LIKE '{$name}%' OR city_iata LIKE '{$name}%'
        //		";

        /** @var hotelCitiesModel $hotel_cities */
        $hotel_cities = Load::getModel('hotelCitiesModel');
        if(!$name){
            $result['Cities'] = [];
            $result['ApiHotels'] = [];
            $result['ReservationHotels'] = [];

            echo functions::clearJsonHiddenCharacters( json_encode( $result ) );
            exit();
        }
        $cities = $hotel_cities->get(['id AS city_id','city_name','city_name_en'])
            ->like('city_name',"{$name}%","LEFT")
            ->like('city_name_en',"{$name}%","LEFT")
            ->like('city_iata',"{$name}%","LEFT")
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
            foreach ( $apiResult as $hotel ) {
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

        echo functions::clearJsonHiddenCharacters( json_encode( $result ) );
        exit();
    }

    public function searchboxExternalHotels( $params ) {

        /** @var ModelBase $ModelBase */
        $city = trim( urldecode( $params['city'] ) );

        $request = [];
        foreach ( $params as $key => $param ) {

            $request[ $key ] = functions::checkParamsInput( $param );
        }

        $ModelBase = Load::library( 'ModelBase' );
        $city = functions::arabicToPersian($city);
        $city2 = $city;
        $pos = strpos($city, 'ا');
        if ($pos === 0) {
            $city2 = 'آ'. mb_substr($city,1);
        }

        $clientSql = "SELECT * FROM external_hotel_city_tb
                  WHERE
                    country_name_en != 'iran'
                    AND (
                    country_name_en LIKE '{$city}%'
                    OR country_name_fa LIKE '{$city}%'
                    OR country_name_fa LIKE '{$city2}%'
                    OR city_name_en LIKE '{$city}%'
                    OR city_name_fa LIKE '{$city}%'
                    OR city_name_fa LIKE '{$city2}%'
                    )
                    GROUP BY country_name_en,city_name_en
                    ";
        //		return json_encode($clientSql);

        return json_encode( $ModelBase->select( $clientSql ) );

    }

    public function insuranceCountry( $params ) {
        /** @var ModelBase $ModelBase */


        $request = [];
        foreach ( $params as $key => $param ) {

            $request[ $key ] = functions::checkParamsInput( $param );
        }


        $clientSql = "SELECT `abbr`, `persian_name` FROM `insurance_country_tb`
    WHERE `abbr` != '' GROUP BY `abbr` ORDER BY `persian_name`";
        $ModelBase = Load::library( 'ModelBase' );

        return json_encode( $ModelBase->select( $clientSql ) );

    }

    public function flightInternalRoutesArrival( $params ) {


        /** @var ModelBase $ModelBase */

        $request = [];
        foreach ( $params as $key => $param ) {

            $request[ $key ] = functions::checkParamsInput( $param );
        }
        if ( isset( $request['self_Db'] ) && $request['self_Db'] == true ) {

            $ModelBase = Load::library( 'ModelBase' );
            $clientSql = "SELECT Arrival_Code,Arrival_City,Arrival_CityEn FROM flight_route_tb WHERE Departure_Code='{$request['filter']}'
                                AND Local_Portal='0'
                                ORDER BY priorityArrival=0,priorityArrival ASC";

            return json_encode( $ModelBase->select( $clientSql ) );
        } else {

            $ModelBase = Load::library( 'Model' );
            $clientSql = "SELECT Arrival_Code,Arrival_City,Arrival_CityEn FROM flight_route_tb WHERE Departure_Code='{$request['filter']}'
                                AND Local_Portal='0'
                                ORDER BY priorityArrival=0,priorityArrival ASC";

            return json_encode( $ModelBase->select( $clientSql ) );
        }


    }

    public function flightInternalRoutesRandom( $params ) {

        /** @var ModelBase $ModelBase */


        $request = [];
        foreach ( $params as $key => $param ) {

            $request[ $key ] = functions::checkParamsInput( $param );
        }

        if ( isset( $request['self_Db'] ) && $request['self_Db'] != true ) {

            $ModelBase = Load::library( 'ModelBase' );
            $clientSql = "SELECT DISTINCTROW Departure_Code, Departure_City, Departure_CityEn FROM flight_route_tb WHERE Local_portal ='0'  GROUP BY  Departure_Code ORDER BY priorityDeparture=0, priorityDeparture ASC";

            return json_encode( $ModelBase->select( $clientSql ) );
        } else {

            $ModelBase = Load::library( 'Model' );
            $clientSql = "SELECT DISTINCTROW Departure_Code, Departure_City, Departure_CityEn FROM flight_route_tb WHERE Local_portal ='0'  GROUP BY  Departure_Code ORDER BY priorityDeparture=0, priorityDeparture ASC";

            return json_encode( $ModelBase->select( $clientSql ) );
        }


    }

    public function RandomHotelList( $params ) {
        Load::library( 'ApiHotelCore' );
        $ApiHotelCore = new ApiHotelCore();

        $result = $ApiHotelCore->RandomHotelList( $params );

        return $result;
    }


    public function checkDefaultDb(){
        return json_encode(['status' => DEFAULT_DB]);
    }

    public function getMagList( $params ){

        $data_search = [
            'service' => 'Public',
            'section' => 'mag',
            'limit'   => $params['limit']
        ];

        $result =  $this->getController('articles')->getArticlesPosition($data_search);


        return json_encode($result , true);

    }

    public function getUserContactInfo(){
        $contact_data =  [
            'name'      => CLIENT_NAME,
            'address'   => CLIENT_ADDRESS ,
            'email'     => CLIENT_EMAIL ,
            'mobile'    => CLIENT_MOBILE ,
            'phone'     => CLIENT_PHONE ,
            'additional_data'   => ADDITIONAL_DATA
        ];
        return json_encode($contact_data);
    }
    public function getUserSocialMedia() {
        $aboutUs = Load::controller('aboutUs');
        $data = $aboutUs->getData();
        return $data['social_links'];
    }

    public function getBusRouteCities( $params ) {
        return json_encode( functions::searchBusCities( $params ), true );
    }

    public function createJacketCustomer($params) {
        $partner = Load::model('partner');
        $data = [
            'domain' => $params['domainAddress']
        ];
        $check_domain = $partner->getClient($data);

        if(empty($check_domain)) {
            $data['AgencyName']  = $params['agencyName'] ;
            $data['Domain']  = 'online.'.$params['domainAddress'] ;
            $data['MainDomain']  = $params['domainAddress'] ;
            $domain_parts = explode('.', $params['domainAddress']);
//            $data['DbName']  = 'safar360_' .$domain_parts[0];
            $data['DbName']  = 'safar360_zhaket';
            $data['ThemeDir']  = 'zhaket';
            $data['Email']  = 'info@'. $params['domainAddress'];
            $data['Manager'] = $params['managerName'];
            $data['Mobile'] = $params['mobile'];
            $data['Phone'] = $params['phoneNumber'];
            $data['Address'] = $params['address'];
            $data['Title'] = $params['agencyName'];
            $data['password'] = functions::generateRandomCode(13) ;
            $data['UrlRuls'] = 'https://' . $params['domainAddress'] .'/gds/rules';
            $data['default_language'] = 'fa';
            $partner = Load::model('partner');
            $result =  $partner->InsertClientModel($data);

            $exploded_name_pic = explode(':', $result);
            if ($exploded_name_pic[0] == "success ") {
                $partner = Load::model('partner');
                $client_info = $partner->getClient(['domain' => $params['domainAddress']]);
                $zhaketController = Load::controller('jacketCustomer') ;
                $zhaket = $zhaketController->insertCustomer(
                    [
                        'ClientId' => $client_info[0]['id'] ,
                        'password' => $data['password'] ,
                        'userName' => $client_info[0]['Email'],
                    ]
                );
                $accessUserClient = Load::controller( 'settingAccessUserClientList' );
                $result = $accessUserClient->setJacketCustomerAccess($client_info[0]);
                if($result) {
                    $smsController = Load::controller('smsServices');
                    $objSms = $smsController->initService('1');
                    if ($objSms) {
                        $sms = "از ژاکت مشتری جدید ساخته شده، لطفا سربعا فعال شود.";
                        $cellArray = array(
                            'araste' => '09211559872',
                        );
                        foreach ($cellArray as $cellNumber) {
                            $smsArray = array(
                                'smsMessage' => $sms,
                                'cellNumber' => $cellNumber
                            );
                            $smsController->sendSMS($smsArray);
                        }
                    }
                    if ($objSms) {
                        $sms = "حساب شما با موفقیت ساخته شد. سایت شما طی 24 ساعت آینده قعال میشود.";
                        $cellArray = array(
                            'customer' => $client_info[0]['Mobile'],
                        );
                        foreach ($cellArray as $cellNumber) {
                            $smsArray = array(
                                'smsMessage' => $sms,
                                'cellNumber' => $cellNumber
                            );
                            $smsController->sendSMS($smsArray);
                        }
                    }
                    $result = [
                        'status' => 200 ,
                        'success' => true ,
                        'message' => 'ساخت مشتری موفقیت امیز بود',
                        'result' => $client_info
                    ];
                    return  json_encode($result , 256);
                }
            }else {
                $result = [
                    'status' => 500 ,
                    'success' => false ,
                    'message' => 'خطا در ساخت مشتری.'
                ];
                return  json_encode($result , 256);
            }
        }else {
            $result = [
                'status' => 500 ,
                'success' => false ,
                'message' => 'این دامنه قبلا استفاده شده، از دامنه دیگری استفاده کنید.'
            ];
            return  json_encode($result , 256);
        }
    }
    public function getCustomerByDomain($params) {
        $partner = Load::model('partner');
        $client_info = $partner->getClient(['domain' => $params['domain']]);
        if($client_info) {
            $result = [
                'status' => 200 ,
                'success' => true
            ];
            return  json_encode($result , 256);
        }else{
            $result = [
                'status' => 200 ,
                'success' => false
            ];
            return  json_encode($result , 256);
        }
    }

    public function checkActiveCustomer($params) {
        $partner = Load::model('partner');
        $client_info = $partner->getClient(['domain' => $params['domain']]);
        var_dump($client_info);
        die();
        $jacket = Load::controller('jacketCustomer') ;
        $jacket_customer_info = $jacket->checkActivate(['clientId' => $client_info[0]['id']]);
        $data = array(
            'userName' => $client_info[0]['Email'] ,
            'password' => $jacket_customer_info['password'] ,
            'link' => $client_info[0]['Domain'].'/gds/itadmin/login' ,
        );

        if($jacket_customer_info['isActive'] == 'yes') {
            $result = [
                'status' => 200 ,
                'data'  => $data,
                'success' => true
            ];
            return  json_encode($result , 256);
        }else{
            $result = [
                'status' => 200 ,
                'data'  => [] ,
                'success' => false
            ];
            return  json_encode($result , 256);
        }
    }
}

new webService();