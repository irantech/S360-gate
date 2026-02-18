<?php

/**
 * @property Model $model
 * @property ModelBase $modelBase
 */
class ApiHotelCore extends clientAuth {
    protected $urlApi = '';
    public $model;
    public $IsLogin;
    public $modelBase;
    public $auth;
    public $header;
    public $counterId;
    public $cityId;
    public $startDate;
    public $agency_commission = array();
    public $serviceDiscount;
    public $authExternal;

    public function __construct() {
        parent::__construct();


        $base_url =  functions::UrlSource();

        $this->urlApi    = $base_url.'Hotels/';
//        $this->urlApi    = 'http://192.168.1.100/Core/V-1/Hotels/';
          //   $this->urlApi    = 'http://192.168.1.100/CoreTestDeveloper/V-1/Hotels/';
//		$this->urlApi    = 'https://safar360.com/Core/V-1/Hotels/';

//        $this->urlApi    = 'https://safar360.com/CoreTestDeveloper/V-1/Hotels/';



        $this->model     = Load::library( 'Model' );
        $this->modelBase = Load::library( 'ModelBase' );
//		$checkLogin      = Session::IsLogin();
        $this->IsLogin = Session::IsLogin();
        $this->counterId = '5';
        if ( $this->IsLogin ) {
            $this->counterId              = functions::getCounterTypeId( Session::getUserId());
        }

        $this->auth = $this->apiHotelAuth();

        //local server
//            $this->urlApi    = $base_url . 'Hotels/';


        if(CLIENT_DOMAIN == 'safar360.com'){
            $this->urlApi    = 'https://safar360.com/Core/V-1/Hotels/';
        }
        //		var_dump($this->arrayAuth);

        $authStr = base64_encode( "{$this->arrayAuth['Username']}:{$this->arrayAuth['Username']}" );

        //		$authStr = base64_encode("hijimbo:hijimbo");
        $this->header = array(
            'Authorization: Basic ' . $authStr,
            'Content-Type: application/json',
        );


        functions::insertLog('header => '.json_encode($this->header,256).'auth==>'.json_encode($this->arrayAuth),'detail_request_hotel');
    }

    public function checkStartDate( $startDate,$calendarType = 'jalali' ) {
        if ( $calendarType == 'jalali' ) {
            functions::insertLog('checkStartDate => 1','times');
            $startDateInt = functions::convertJalaliDateToGregInt( $startDate );
        } else {
            functions::insertLog('checkStartDate => 2','times');
            $startDateInt = strtotime( $startDate );
        }

        $currentDate = strtotime( date( 'Y-m-d' ) );
        functions::insertLog('checkStartDate => '.json_encode([$startDate,$calendarType,$startDateInt,$currentDate]),'times');
        if ( $startDateInt < $currentDate ) {
            return false;
        }

        return true;

    }

    private function getAgencyCommission( $city, $hotelStar, $startDate, $nights ) {
        $sDate_miladi            = functions::ConvertToMiladi( $startDate );
        $sDate_miladi            = str_replace( "-", "", $sDate_miladi );
        $this->agency_commission = '';
        for ( $i = 0; $i < $nights; $i ++ ) {

            $result_date = date( 'Ymd', strtotime( "" . $sDate_miladi . ",+ $i day" ) );
            $Date_shamsi = functions::ConvertToJalali( $result_date );

            $date = str_replace( '-', '/', $Date_shamsi );

            $res = functions::getHotelPriceChange( $city, $hotelStar, $this->counterId, $date, 'api' );
            if ( $res != false ) {

                $this->agency_commission[ $Date_shamsi ]['result']      = true;
                $this->agency_commission[ $Date_shamsi ]['price']       = $res['price'];
                $this->agency_commission[ $Date_shamsi ]['price_type']  = $res['price_type'];
                $this->agency_commission[ $Date_shamsi ]['change_type'] = $res['change_type'];

            } else {

                $this->agency_commission[ $Date_shamsi ]['result'] = false;

            }

        }

    }

    public function showError( $message = '', $statusCode = 400, $result = null ) {
        if ( ! $message ) {
            $message = 'خطایی رخ داده است';
        }

        return self::returnJson( [ 'Message' => $message, 'Success' => false, 'Result' => $result ], $statusCode );
    }

    public function returnJson( $data, $statusCode = 200 ) {
        http_response_code( $statusCode );
        $data               = (array) $data;
        $data['StatusCode'] = $statusCode;

        return json_encode( $data, 256 | 64 );

    }

    public function GetHotelsByName( $name ) {
        if ( $this->auth == 'True' ) {
            $name = urlencode( $name );
            $url    = "{$this->urlApi}GetHotelsByName/{$name}";

            $result = functions::curlExecution( $url,[], $this->header );

            functions::insertLog(json_encode(['req'=>$url,'res'=>$result,'header'=>$this->header,'auth'=>$this->arrayAuth],256|64),'Hotels/GetHotelsByName');
            if (isset($result['StatusCode']) && $result['StatusCode'] == 200 ) {
                return $result['Result'];
            }

            return $result['Result'];
        }

        return $this->showError( 'شما دسترسی لازم به این صفحه را ندارید', 403 );
    }

    public function AccessReservationHotel() {
        return parent::reservationHotelAuth();
    }

    /**
     * @return false|string
     * this is for internal hotel
     */
    public function AllHotelTypes() {

        if ( $this->auth == 'True' ) {
            $url = $this->urlApi . 'HotelTypes/';

            $resultTypes = functions::curlExecution_Get( $url, [] );

            return $resultTypes['Result'];
        }
        return [];
    }

    /**
     * @param null $countryName
     * @return mixed
     * return list of cities of one country in core
     */
    public function cities($countryName = null ) {

        $url = $this->urlApi . 'cities/' . $countryName;

        return functions::curlExecution_Get( $url, array() );
    }

    /**
     * @param $param
     * @return false|string
     * this return result search hotel
     */
    public function hotelList($param ) {



        $start = microtime(true);
        functions::insertLog('HotelList '.$start,'times');
        if ( $this->auth != 'True' ) {
            return $this->showError( 'شما دسترسی لازم را به این صفحه ندارید', 403 );
        }
        //  just jalali for send to core
        $calendarType = isset($param['calendarType']) ? $param['calendarType'] : 'jalali';
        if ( ! $this->checkStartDate( $param['startDate'] ,$calendarType ) ) {
            return $this->showError( (string) functions::Xmlinformation( 'InvalidStartDate' ), 400,$param['startDate']);
        }

        setcookie('hotelCalendarType',$calendarType);

        if ( $calendarType == 'gregorian' ) {
            $param['startDate'] = functions::ConvertToJalali( $param['startDate'], '-' );
            $param['endDate']   = functions::ConvertToJalali( $param['endDate'], '-' );
        }

        $url                      = $this->urlApi . 'HotelList/';

        $dataSearch['CalendarType']       = strtolower( $calendarType );
        $dataSearch['City']       = strtolower( $param['city'] );
        $dataSearch['Country']    = strtolower( $param['Country'] );
        $dataSearch['StartDate']  = $param['startDate'];
        $dataSearch['EndDate']    = $param['endDate'];

        $dataSearch['IsInternal'] = isset( $param['isInternal'] ) ? $param['isInternal'] : false;
        $dataSearch['with_foreign'] = isset( $param['with_foreign'] ) ? $param['with_foreign'] : false;
        $dataSearch['get_package'] = isset( $param['getPackage'] ) ? $param['getPackage'] : false;
        if ( isset( $param['roomsArray'] ) ) {
            $dataSearch['Rooms'] = $param['roomsArray'];
        }
        if(isset($param['nationality'])){
            $dataSearch['Nationality'] = $param['nationality'];
        }

        $datajson = json_encode( $dataSearch );


        functions::insertLog('$datajson => '.$datajson,'times');
        functions::insertLog( '=====' . PHP_EOL . 'Url = ' . $url .PHP_EOL, 'Hotels/List' );
        functions::insertLog(
            'Request: ' . json_encode( $dataSearch, 256 | 64) .PHP_EOL.
            'user and pass: ' . json_encode( $this->arrayAuth, 256 | 64).PHP_EOL.
            'Headers: ' . json_encode( $this->header, 256 | 64 )
            , 'Hotels/List' );
        functions::insertLog('HotelList Before Curl '.microtime(true),'times');
        if($param['getPackage']) {
            functions::insertLog('before list hotel curl=>','package_log');
        }

        $resultHotel = functions::curlExecution( $url, $datajson, $this->header );

        if($param['getPackage']) {
            functions::insertLog('after list hotel curl=>', 'package_log');
        }
        functions::insertLog( 'Response before foreach: ' . json_encode( $resultHotel, 256 | 64 ), 'Hotels/List' );
        functions::insertLog('HotelList after Curl '.microtime(true),'times');

        $hotels = $resultHotel['Result'];
        if ( isset( $resultHotel['StatusCode'] ) ) {
            $this->cityId    = $param['city'];
            $this->startDate = $param['startDate'];
            $hotel_lists = [];
            foreach ($hotels as $hotel_key => $hotel_item) {
//                if(in_array($hotel_item,$hotel_list)){
//                    continue;
//                }
                $hotel_index = substr($hotel_item['HotelIndex'],2);
//                if(isset($hotel_list[$hotel_index]) && $hotel_item['MinPrice'] > $hotel_list[$hotel_index]['MinPrice']){
//                    unset($hotel_list[$hotel_index]);
//                }
                $hotel_item['index'] = $hotel_index;
                $hotel_lists[] = $hotel_item;
            }

            $sort=array();
            foreach ($hotel_lists as $keySort => $arraySort) {
                if ($arraySort['MinPrice'] > 0) {
                    $sort['MinPrice'][$keySort] = $arraySort['MinPrice'];
                }
            }
            if (!empty($sort)) {
                array_multisort($sort['MinPrice'], SORT_ASC, $hotel_lists);
            }

            $final_hotel = array();
            foreach ($hotel_lists as $key=>$hotel_list) {
                if(isset($final_hotel[$hotel_list['index']])){
                    continue;
                }
                $final_hotel[$hotel_list['index']] = $hotel_list;
            }

            $resultHotel['Result'] = array_values($final_hotel);
            functions::insertLog( 'Response: ' . json_encode( $resultHotel, 256 | 64 ), 'Hotels/List' );
            return $this->returnJson( $resultHotel, $resultHotel['StatusCode'] );
        }

        return $this->returnJson( $resultHotel );
    }

    private function filterHotelsByPrice($hotel)
    {

    }

    public function getSingleHotel( $hotelId ) {
        if ( $this->auth == 'True' ) {
            $url = $this->urlApi . "singleDetail/";
            functions::insertLog( 'Hotel getSingleHotel Method Request: hotelId' . $hotelId, '00135Hotel' );
            $resultHotel = functions::curlExecution( $url, [], $this->header );
            functions::insertLog( 'Hotel Detail Method Response: ' . json_encode( $resultHotel, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ), '00135Hotel' );

        }
    }

    public function Detail( $param ) {


        if ( $this->auth == 'True' ) {

            $url                         = $this->urlApi . "Detail/";
            $dataSearch['HotelIndex']    = $param['hotelIndex'];
//			$cronUpdatePrice = "{$this->urlCore}Cronjobs/CronUpdatePrices/E24/?hotel_id={$param['hotelIndex']}&echo=0";
//			$suggestResult = functions::curlExecution_Get($cronUpdatePrice,[]);
            $request_number = explode('&',$param['requestNumber'])[0];

            $dataSearch['RequestNumber'] = $request_number;
            if(isset( $param['getPackage'] ) ) {
                $dataSearch['get_package'] =  $param['getPackage'] ;
            }

            functions::insertLog( '=====' . PHP_EOL . 'Detail Request: ' . json_encode( $param, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ), 'Hotels/' . $dataSearch['RequestNumber'] );

            $resultHotel = functions::curlExecution( $url, json_encode( $dataSearch ), $this->header );

            functions::insertLog( 'Detail Response: ' . json_encode( $resultHotel, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ), 'Hotels/' . $dataSearch['RequestNumber'] );
            if ( isset( $resultHotel['History'] ) && is_array( $resultHotel['History'] ) ) {
                $this->startDate = $resultHotel['History']['StartDate'];
            }

            return $this->returnJson( $resultHotel );
        }
        return $this->showError( 'شما دسترسی لازم به این صفحه را ندارید', 403 );
    }

    public function RandomHotelList( $param ) {

        if ( $this->auth == 'True' ) {
            $url                      = $this->urlApi . "RandomHotelList/";
            $dataSearch['Ids']        = $param['HotelIds'] ?: [];
            $dataSearch['CityIds']    = $param['CityIds'] ?: [];
            $dataSearch['Count']      = $param['Count'] ?: 6;
            $dataSearch['IsInternal'] = $param['IsInternal'] ?: true;
            $dataSearch['star_code']  = $param['star_code'] ?: [];
            if($param['IsInternal'] === false) {
                $dataSearch['IsInternal'] = false;
            }
            //			functions::insertLog( 'Hotel RandomHotelList Method Request: ' . json_encode( $param, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ), '00135Hotel' );

            $resultHotel = functions::curlExecution( $url, json_encode( $dataSearch ), $this->header );
            //			return $this->returnJson($url);
            //			echo json_encode( $resultHotel );
            //			exit();
            //			functions::insertLog( 'Hotel Detail Method Response: ' . json_encode( $resultHotel, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ), '00135Hotel' );

            return json_encode( $resultHotel );

            if ( $resultHotel['StatusCode'] == 200 ) {
                return $this->returnJson( $resultHotel['Result'] );
            }

            return $this->returnJson( $resultHotel['Result'] );
        }

        return $this->showError( 'شما دسترسی لازم به این صفحه را ندارید', 403 );
    }

    public function DirectDetail( $param ) {


        if ( $this->auth == 'True' ) {
            if ( ! $param['hotelIndex'] ) {
                return $this->showError( 'hotelIndex is required' );
            }
            $url = "{$this->urlApi}DirectDetail/";
            functions::insertLog( 'Hotel DirectDetail Method URL : '.$url.PHP_EOL.' Request: ' . json_encode( $param, 256|64), 'DirectDetail' );
            $StartDate  = functions::ConvertToJalali( date( 'Y-m-d' ), '-' );
            $EndDate    = functions::ConvertToJalali( date( 'Y-m-d', strtotime( '+1 day' ) ), '-' );
            $reqData['IsInternal'] = true;
            $reqData['HotelIndex'] = $param['hotelIndex'];

            $reqData['StartDate'] = ($param['StartDate']) ? $param['StartDate'] : $StartDate;
            $reqData['EndDate'] = ($param['EndDate']) ? $param['EndDate'] : $EndDate;

            if(SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' && substr( $reqData['StartDate'], "0", "4" ) > 2000) {
                $reqData['StartDate'] = functions::ConvertToJalali($reqData['StartDate'],'-');
            }
            if(SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' && substr( $reqData['EndDate'], "0", "4" ) > 2000) {
                $reqData['EndDate'] = functions::ConvertToJalali($reqData['EndDate'],'-');
            }

            if (isset($param['searchRooms']) && !empty($param['searchRooms'])) {
                $rooms_explode = functions::numberOfRoomsExternalHotelSearch($param['searchRooms']);
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
                    $reqData['Rooms'][] = ['Adults' => $adultCount, 'Children' => $childCount, 'Ages' => $age];
                }
            }

            functions::insertLog( 'Hotel DirectDetail Method Request: ' . json_encode( $reqData, 256|64 ), 'DirectDetail' );

            $resultHotel = functions::curlExecution( $url, json_encode( $reqData ), $this->header );

            functions::insertLog( 'Hotel DirectDetail Method Response: ' . json_encode( $resultHotel, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ), 'DirectDetail' );


            return $this->returnJson( $resultHotel );
        }

        return $this->showError( 'شما دسترسی لازم به این صفحه را ندارید', 403 );
    }

    public function getPrices( $param ) {


        if ( $this->auth == 'True' ) {
            $url                         = $this->urlApi . 'Prices/';
            $dataSearch['RequestNumber'] = $param['requestNumber'];
            $dataSearch['HotelIndex']    = $param['hotelIndex'];
            functions::insertLog( '=====' . PHP_EOL . 'url : '.$url.PHP_EOL.'getPrices Request: ' . json_encode( $dataSearch, 256 | 64 ), 'Hotels/' . $dataSearch['RequestNumber'] );

            $resultPrice = functions::curlExecution( $url, json_encode( $dataSearch ), $this->header );

            functions::insertLog( 'getPrices Response: ' . json_encode( $resultPrice, 256 | 64), 'Hotels/' . $dataSearch['RequestNumber'] );
            if ( isset( $resultPrice['StatusCode'] ) ) {
                return $this->returnJson( $resultPrice, $resultPrice['StatusCode'] );
            }


            return $this->returnJson( $resultPrice );
        }

        return $this->showError( 'شما دسترسی لازم را به این صفحه ندارید', 403 );

    }

    public function getCancellationPolicy( $param ) {
        if ( $this->auth == 'True' ) {
            $url = $this->urlApi . 'GetCancellationPolicy';
            functions::insertLog($url, 'Hotels/' . $param['RequestNumber'] );
            functions::insertLog( '=====' . PHP_EOL . 'GetCancellationPolicy Request: ' . json_encode( $param, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ), 'Hotels/' . $param['RequestNumber'] );
            $resultHotel = functions::curlExecution( $url, json_encode( $param ), $this->header );
            functions::insertLog( 'GetCancellationPolicy Response: ' . json_encode( $resultHotel, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ), 'Hotels/' . $param['RequestNumber'] );

            return $this->returnJson( $resultHotel, $resultHotel['StatusCode'] );
        }

        return $this->showError( 'شما دسترسی لازم به این صفحه را ندارید', 403 );
    }

    public function Book( $param ) {



        unset( $param['FactorNumber'] );
        if ( $this->auth == 'True' ) {
            $url = $this->urlApi . "Book/";
            functions::insertLog( '=====' . PHP_EOL . 'Book Request: ' . json_encode( $param, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ), 'Hotels/' . $param['RequestNumber'] );

            $resultHotel = functions::curlExecution( $url, json_encode( $param ), $this->header );
            functions::insertLog( 'Book Response: ' . json_encode( $resultHotel, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ), 'Hotels/' . $param['RequestNumber'] );

            return $this->returnJson( $resultHotel, $resultHotel['StatusCode'] );
        }

        return $this->showError( 'شما دسترسی لازم به این صفحه را ندارید', 403 );
    }

    public function Reserve( $param ) {


//		die();//for local

        if ( $this->auth == 'True' ) {
            $url                         = $this->urlApi . "Reserve/";
            $dataSearch['RequestNumber'] = $param['RequestNumber'];
            functions::insertLog( '=====' . PHP_EOL . 'Reserve Request: ' . json_encode( $param, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ), "Hotels/{$dataSearch['RequestNumber']}"  );


            $resultHotel = functions::curlExecution( $url, json_encode( $param ), $this->header );

//			$resultHotel = ['StatusCode'=>200,'Result'=>['Test']];

            functions::insertLog( 'Reserve Response: ' . json_encode( $resultHotel, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ), "Hotels/{$dataSearch['RequestNumber']}" );

            return $this->returnJson( $resultHotel, $resultHotel['StatusCode'] );
        }

        return $this->showError( 'شما دسترسی لازم به این صفحه را ندارید', 403 );
    }

    public function updateOfflineReserve( $param ) {
        $url         = $this->urlApi . 'checkOfflineStatus';
        $resultCheck = functions::curlExecution( $url, json_encode( $param ), $this->header );
        if ( $resultCheck['Success'] ) {
            if ( $resultCheck['Result']['Status'] != 'pending' ) {
                return $this->returnJson( $resultCheck );
            }

            return $this->showError( 'Status is Pending', 400, $resultCheck );
        }

        return $this->showError( 'Error Receive Data from API', 400, $resultCheck );
    }

    public function checkOfflineStatus( $param ) {

        $url       = $this->urlApi . 'checkOfflineStatus';

        $resultApi = functions::curlExecution( $url, json_encode( $param ), $this->header );

        return $this->returnJson( $resultApi, $resultApi['StatusCode'] );
    }

    public function MostVisitedCities($param){
        $count = $param['count'] ? : 6;
        if ( $this->auth == 'True' ) {
            $url                         = $this->urlApi . "MostVisitedCities/$count";
            $resultHotel = functions::curlExecution( $url, json_encode( $param ), $this->header );
            return $this->returnJson( $resultHotel, $resultHotel['StatusCode'] );
        }

        return $this->showError( 'شما دسترسی لازم به این صفحه را ندارید', 403 );
    }

    public function getProfile( $param ) {
        if ( $this->auth == 'True' ) {
            $url                         = $this->urlApi . "getCredit/" . $param;
            $JsonArray = array();

            $resultCredit = functions::curlExecution( $url, $JsonArray ,  $this->header );

            return $this->returnJson( $resultCredit );
        }
        return $this->showError( 'شما دسترسی لازم به این صفحه را ندارید', 403 );
    }

    public function getHotelListByCity( $param ) {
        if ( $this->auth == 'True' ) {
            $url = $this->urlApi . "getHotelListByCity" ;
            $url = 'http://safar360.com/Core/V-1/Hotels/getHotelListByCity';
            $JsonArray = array(
                'city_name' => $param['city_name']
            );
            $JsonArray = json_encode( $JsonArray );
            $resultHotel = functions::curlExecution( $url, $JsonArray ,  $this->header );

            return $this->returnJson( $resultHotel );
        }
        return $this->showError( 'شما دسترسی لازم به این صفحه را ندارید', 403 );
    }

    public function clientHotelData()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if($_POST['code']){
                $code = 'code=' .( isset($_POST['code']) ? $_POST['code'] : '');
            }
            if($_POST['date_start']){
                $date_start = 'date_start=' . ($_POST['date_start'] ? $_POST['date_start'] : '');
            }
            if($_POST['date_end']){
                $date_end = 'date_end=' . ($_POST['date_end'] ? $_POST['date_end'] : '');
            }
        }
        $query_param = implode('',[$code, $date_start, $date_end]);
        $url = "https://safar360.com/Core/V-1/Hotels/getRequestedCode/$query_param" ; //TODO change this url accordingly

        header('Content-Type: application/json');
        $result = functions::curlExecution($url,[]);

        $final_response = [] ;
        foreach($result as $data){
            $final_response[] = [
                'id'     => $data['id'] ,
                'code'     => $data['tracking_code'] ,
                'businessMethodName'     => $data['method'] ,
                'ApiMethodName'     => $data['source'] ,
                'response'     => htmlentities($data['response_body']) ,
                'request'     => htmlentities($data['request_body']) ,
            ];
        }
        echo json_encode($final_response);
    }

}