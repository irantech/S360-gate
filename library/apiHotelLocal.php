<?php
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
class apiHotelLocal extends clientAuth
{

    private $url = '';
    private $guid = '';
    private $urlApi = '';

    function __construct()
    {
        /*$this->guid = '5648525FG48A-ECB7-4EE9-ABBVD-E42E78E23423BXS';
        $this->urlApi = 'http://inparvaz.com/Hotel/';*/
        $this->guid = '12E8E48A-ECB7-4EE9-A68D-E42E78E65B35';
        $this->urlApi = 'http://newapi.alaedin.travel/';

        $checkLogin = Session::IsLogin();
        if ($checkLogin) {
            $this->counterId = functions::getCounterTypeId($_SESSION['userId']);
            $this->serviceDiscount['api'] = functions::ServiceDiscount($this->counterId, 'PubliceLocalHotel');
        } else {
            $this->counterId = '5';
        }
    }

    public function AccessReservationHotel()
    {
        $result = parent::reservationHotelAuth();
        return $result;
    }

    public function AccessApiHotel()
    {
        $result = parent::apiHotelAuth();
        return $result;
    }

    public function curlExecutionPost($url, $data = null, $flag = NULL)
    {

        /**
         * This function execute curl with a url & datas
         * @param $url string
         * @param $data an associative array of elements
         * @return jason decoded output
         * @author Naime Barati
         */
        $handle = curl_init($url);

        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        if ($flag == 'yes') {
            curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        }
        $result = curl_exec($handle);

        /*echo 'url: ' . $url . '<br>';
        echo 'result before json_decode: <br>';
        echo $result;
        echo '<br>';
        echo 'result after json_decode: <br>';
        echo Load::plog(json_decode($result, true));
        echo '<hr>';*/
        /*$log = "url: " . $url . "\n";
        $log .= "result before json_decode: \n";
        $log .= $result;
        $log .= "\n";
        $log .= "esult after json_decode: \n";
        $log .= Load::plog(json_decode($result, true));
        $log .="\n";
        $log .=$data;
        $log .="\n";
        $n = "testApiMAfshar/Hotel_AllRoomPrice";
        functions::insertLog($log, $n);*/

        return json_decode($result, true);
    }

    public function curlExecutionGet($url, $data = null)
    {

        /**
         * This function execute curl with a url & datas
         * @param $url string
         * @param $data an associative array of elements
         * @return jason decoded output
         * @author Naime Barati
         */
        $handle = curl_init($url);

        curl_setopt($handle, CURLOPT_HTTPGET, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($handle);
        /*echo 'url: ' . $url . '<br>';
        echo 'result before json_decode: <br>';
        echo $result;
        echo '<br>';
        echo 'result after json_decode: <br>';
        echo Load::plog(json_decode($result, true));
        echo '<hr>';*/

        return json_decode($result, true);
    }


    /**************************Province************************/

    // بازگرداندن لیست تمامی استان های ثبت شده درون سیستم
    public function All_Province()
    {
        $url = $this->urlApi . 'Province/' . $this->guid;
        $AllProvince = $this->curlExecutionGet($url);

        return $AllProvince;
    }


    // پیدا کردن و بازگرداندم یک شی که معرف اطلاعات یک استان می باشد توسط کد آن استان
    public function Province($provinceCode)
    {
        $url = $this->urlApi . 'Province/' . $provinceCode . '/' . $this->guid;
        $Province = $this->curlExecutionGet($url);

        return $Province;
    }


    /**************************City************************/

    // بازگرداندن لیست تمامی شهر های ثبت شده درون سیستم
    public function All_City()
    {

        $url = $this->urlApi . 'City/' . $this->guid;
        $AllCity = $this->curlExecutionGet($url);

        return $AllCity;
    }


    // پیدا کردن و بازگرداندم یک شی که معرف اطلاعات یک شهر می باشد توسط کد آن شهر
    public function City($cityCode)
    {

        $url = $this->urlApi . 'City/' . $cityCode . '/' . $this->guid;
        $city = $this->curlExecutionGet($url);

        return $city;
    }


    // بازگرداندن لیست تمامی شهر های ثبت شده درون سیستم که در داخل یک استان خاص می باشند
    public function City_byProvince($provinceCode)
    {

        $url = $this->urlApi . 'City/byProvince/' . $provinceCode . '/' . $this->guid;
        $CitybyProvince = $this->curlExecutionGet($url);

        return $CitybyProvince;
    }


    /**************************Region************************/

    //بازگرداندن لیست تمامی منطقه های ثبت شده درون سیستم 
    public function Region()
    {

        $url = $this->urlApi . 'Region/' . $this->guid;
        $Region = $this->curlExecutionGet($url);

        return $Region;
    }


    //پیدا کردن و بازگرداندم یک شی که معرف اطلاعات یک منطقه می باشد توسط کد آن منطقه 
    public function RegionCode($regionCode)
    {

        $url = $this->urlApi . 'Region/' . $regionCode . '/' . $this->guid;
        $RegionCode = $this->curlExecutionGet($url);

        return $RegionCode;
    }

    //بازگرداندن لیست تمامی شهر های ثبت شده درون سیستم
    public function Region_byCity($cityCode)
    {

        $url = $this->urlApi . 'Region/byCity/' . $cityCode . '/' . $this->guid;
        $RegionbyCity = $this->curlExecutionGet($url);

        return $RegionbyCity;
    }


    /**************************Hotel************************/

    // واکشی اطلاعات کامل هتل ها
    public function All_Hotel()
    {

        $url = $this->urlApi . 'Hotel/' . $this->guid;
        $AllHotel = $this->curlExecutionGet($url);

        return $AllHotel;
    }


    // واکشی اطلاعات کامل هتل ها، فیلتر شده بر حسب کد شهر
    public function Hotel_byCity($cityCode)
    {

        $url = $this->urlApi . 'Hotel/byCity/' . $cityCode . '/' . $this->guid;
        $HotelByCity = $this->curlExecutionGet($url);

        return $HotelByCity;
    }


    // واکشی اطلاعات کامل یک هتل، توسط کد آن هتل
    public function Hotel($hotelCode)
    {
        $url = $this->urlApi . 'Hotel/' . $hotelCode . '/' . $this->guid;

        functions::insertLog('request with hotel id ' . $hotelCode . ' => ' . $url, 'log_info_hotel_api');
        $hotel = $this->curlExecutionGet($url);
        $City=self::City($hotel['AddressInfo']['CityCode']);
        foreach($hotel['HotelPictures'] as $key => $picture){
            $hotel['HotelPictures'][$key]['Url']= SERVER_HTTP.$_SERVER['HTTP_HOST']."/imageExternalHotel/hotelImages/iran/".strtolower($City['NameEn'])."/".strtolower( preg_replace( "![^a-z0-9]+!i", "-", $hotel['NameEn'] ) )."/".$hotel['Code']."-".$key.".jpg";

        }
        functions::insertLog('response with hotel id ' . $hotelCode . ' => ' . json_encode($hotel, true), 'log_info_hotel_api');


        return $hotel;
    }

    /**************************Room************************/

    // دریافت تمام اطلاعات در مورد نوع اتاق های تعریف شده
    public function All_Room()
    {

        $url = $this->urlApi . 'Room/' . $this->guid;
        $AllRoom = $this->curlExecutionGet($url);

        return $AllRoom;
    }


    // دریافت تمام اطلاعات اتاق ها، فیلتر شده توسط کد هتل
    public function Room_byHotel($hotelCode)
    {
        $url = $this->urlApi . 'Room/byHotel/' . $hotelCode . '/' . $this->guid;
        $result = $this->curlExecutionGet($url);

        return $result;
    }


    //  دریافت تمام جزییات از اتاق انتخابی
    public function Room($roomCode)
    {

        $url = $this->urlApi . 'Room/' . $roomCode . '/' . $this->guid;
        $Room = $this->curlExecutionGet($url);

        return $Room;
    }


    /**************************HotelType************************/

    // بازگرداندن لیست تمامی نوع هتل هلای ثبت شده درون سیستم
    public function All_HotelType()
    {

        $url = $this->urlApi . 'HotelType/' . $this->guid;
        $AllHotelType = $this->curlExecutionGet($url);

        return $AllHotelType;
    }


    //  پیدا کردن و بازگرداندم یک شی که معرف اطلاعات یک نوع هتل می باشد توسط کد آن نوع هتل
    public function HotelType($hotelTypeCode)
    {

        $url = $this->urlApi . 'HotelType/' . $hotelTypeCode . '/' . $this->guid;
        $HotelType = $this->curlExecutionGet($url);

        return $HotelType;
    }


    /**************************HotelRoom************************/

    //دریافت کلیه رابطه ها میان نوع اتاق ها و هتل ها
    public function All_HotelRoom()
    {

        $url = $this->urlApi . 'HotelRoom/' . $this->guid;
        $AllHotelRoom = $this->curlExecutionGet($url);

        return $AllHotelRoom;
    }

    //یک مدل رابطه ای بین اتاق و هتل را بر می گرداند
    public function HotelRoom($hotelCode, $roomCode)
    {

        $url = $this->urlApi . 'HotelRoom/' . $hotelCode . '/' . $roomCode . '/' . $this->guid;
        $HotelRoom = $this->curlExecutionGet($url);

        return $HotelRoom;
    }


    /**************************HotelReserve************************/


    // رزرو یک اتاق یا بیشتر به صورت موقت، و بازگرداندن یک شماره درخواست و شماره ( پی ان آر ) برای اعمال دستورات بر روی این رزرو
    public function hotelReserveRoomForApi($factorNumber)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $sql = " SELECT * FROM report_hotel_tb WHERE factor_number='{$factorNumber}' GROUP BY room_id";
        $book = $ModelBase->select($sql);
        if (!empty($book)) {

            $client_id = $book[0]['client_id'];
            $hotel_id = $book[0]['hotel_id'];
            $nights = $book[0]['number_night'];
            $start_date = $book[0]['start_date'];

            $roomTypeCodes = '';
            $numberOfRooms = '';
            foreach ($book as $i => $room) {
                if (isset($room) && $i == '0') {
                    $roomTypeCodes = $room['room_id'];
                    $numberOfRooms = $room['room_count'];
                } else if (isset($room) && !empty($room)) {
                    $roomTypeCodes .= ',' . $room['room_id'];
                    $numberOfRooms .= ',' . $room['room_count'];
                }
            }
            $startDate = str_replace("-", "", $start_date);
            $url = $this->urlApi . 'Hotel/Reserve/Room/' . $hotel_id . '/' . $roomTypeCodes . '/' . $numberOfRooms . '/' . $startDate . '/' . $nights . '/' . $this->guid;
            functions::insertLog('request with factor number ' . $factorNumber . ' => ' . $url, 'log_hotel_preReserve');
            $hotelReserveRoom = $this->curlExecutionPost($url);
            functions::insertLog('response with factor number ' . $factorNumber . ' => ' . json_encode($hotelReserveRoom, true), 'log_hotel_preReserve');

            if (!empty($hotelReserveRoom['RequestNumber'])) {

                $d['request_number'] = $hotelReserveRoom['RequestNumber'];
                $d['pnr'] = $hotelReserveRoom['RequestPNR'];
                $d['status'] = "PreReserve";
                $d['creation_date_int'] = time();
                $d['payment_date'] = Date('Y-m-d H:i:s');

                $Condition = "factor_number='{$factorNumber}' ";
                $ModelBase->setTable("report_hotel_tb");
                $resReport = $ModelBase->update($d, $Condition);

                $admin = Load::controller('admin');
                $res = $admin->ConectDbClient('', $client_id, 'Update', $d, 'book_hotel_local_tb', $Condition);

                if ($res && $resReport) {
                    return 'success |  تغییرات با موفقیت انجام شد';
                } else {
                    return 'error | خطا در  تغییرات';
                }

            } else {
                return 'error | پیش رزرو از سمت علاالدین انجام نشد | ' .  json_encode($hotelReserveRoom, true) ;
            }
        }
	    return 'error | خطا شماره فاکتور';
    }

    public function Hotel_Reserve_Room($factorNumber, $typeApplication)
    {

        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $smsController = Load::controller('smsServices');


        $checkLogin = Session::IsLogin();

        if ($checkLogin) {
            $counter_type_id = functions::getCounterTypeId($_SESSION['userId']);
        } else {
            $counter_type_id = '5';
        }


        // api or reservation
        if ($typeApplication == 'api' || $typeApplication == 'api_app') {
            $sql = " SELECT * FROM book_hotel_local_tb WHERE factor_number='{$factorNumber}' GROUP BY room_id";
            $book_hotel = $Model->select($sql);

            if (!empty($book_hotel)) {
                $book_hotel[0]['total_price'] = $book_hotel[0]['hotel_payments_price'];

                $hotel_id = $book_hotel[0]['hotel_id'];
                $nights = $book_hotel[0]['number_night'];
                $start_date = $book_hotel[0]['start_date'];
                $total_price = $book_hotel[0]['total_price'];
                $total_price_api = $book_hotel[0]['total_price_api'];

                $roomTypeCodes = '';
                $numberOfRooms = '';
                foreach ($book_hotel as $room) {
                    $roomTypeCodes .= $room['room_id'] . ',';
                    $numberOfRooms .= $room['room_count'] . ',';
                }
                $roomTypeCodes = substr($roomTypeCodes, 0, -1);
                $numberOfRooms = substr($numberOfRooms, 0, -1);
                $startDate = str_replace("-", "", $start_date);
                $url = $this->urlApi . 'Hotel/Reserve/Room/' . $hotel_id . '/' . $roomTypeCodes . '/' . $numberOfRooms . '/' . $startDate . '/' . $nights . '/' . $this->guid;
                functions::insertLog('request with factor number ' . $factorNumber . ' => ' . $url, 'log_hotel_preReserve');
                $HotelReserveRoom = $this->curlExecutionPost($url);
                functions::insertLog('response with factor number ' . $factorNumber . ' => ' . json_encode($HotelReserveRoom, true), 'log_hotel_preReserve');

                if (!empty($HotelReserveRoom['RequestNumber'])) {

                    if ($total_price_api == $HotelReserveRoom['TotalPrice']){

                        $d['request_number'] = $HotelReserveRoom['RequestNumber'];
                        $d['pnr'] = $HotelReserveRoom['RequestPNR'];
                        $d['status'] = "PreReserve";
                        $d['creation_date_int'] = time();
                        $d['payment_date'] = Date('Y-m-d H:i:s');

                        $Condition = "factor_number='{$factorNumber}' ";
                        $Model->setTable("book_hotel_local_tb");
                        $res = $Model->update($d, $Condition);

                        $ModelBase->setTable("report_hotel_tb");
                        $res_report = $ModelBase->update($d, $Condition);

                        if ($res && $res_report) {

                            $statusRequestWebService['type_application'] = $typeApplication;
                            $statusRequestWebService['book'] = "yes";
                            $statusRequestWebService['factor_number'] = $factorNumber;
                            $statusRequestWebService['total_price'] = $total_price;
                            $statusRequestWebService['RequestNumber'] = $HotelReserveRoom['RequestNumber'];
                            $statusRequestWebService['RequestPNR'] = $HotelReserveRoom['RequestPNR'];
                        }

                    } else {

                        $statusRequestWebService['book'] = "no";
                        $statusRequestWebService['factor_number'] = $factorNumber;
                    }



                } else {

                    /*$d['request_number'] = '';
                    $d['pnr'] = '';
                    $d['status'] = 'NoReserve';
                    $d['creation_date_int'] = time();

                    $Condition = "factor_number='{$factorNumber}' ";
                    $Model->setTable("book_hotel_local_tb");
                    $res = $Model->update($d, $Condition);

                    $ModelBase->setTable("report_hotel_tb");
                    $res_report = $ModelBase->update($d, $Condition);

                    $statusRequestWebService['book'] = "no";
                    $statusRequestWebService['factor_number'] = $factorNumber;*/


                    $d['status'] = 'OnRequest';
                    $d['creation_date_int'] = time();

                    $Condition = "factor_number='{$factorNumber}' ";
                    $Model->setTable("book_hotel_local_tb");
                    $res = $Model->update($d, $Condition);

                    $ModelBase->setTable("report_hotel_tb");
                    $res_report = $ModelBase->update($d, $Condition);

                    $statusRequestWebService['book'] = "OnRequest";
                    $statusRequestWebService['factor_number'] = $factorNumber;
                    $statusRequestWebService['total_price'] = $book_hotel[0]['total_price'];
                    $statusRequestWebService['user_type'] = $counter_type_id;

                    //sms to buyer
                    $objSms = $smsController->initService('0');
                    if ($objSms) {
                        if (!empty($book_hotel[0]['member_mobile'])) {
                            $mobile = $book_hotel[0]['member_mobile'];
                            $name = $book_hotel[0]['member_name'];
                        } else {
                            $mobile = $book_hotel[0]['passenger_leader_room'];
                            $name = $book_hotel[0]['passenger_leader_room_fullName'];
                        }
                        $on_request_hotel_pattern =   $smsController->getPattern('on_request_hotel');
                        if($on_request_hotel_pattern) {
                            $smsController->smsByPattern($on_request_hotel_pattern['pattern'], array($mobile), array('customer_name' => CLIENT_NAME , 'hotel_name' => $book_hotel[0]['hotel_name']));
                        }
                        else {
                            $messageVariables = array(
                                'sms_name' => $name,
                                'sms_service' => 'هتل',
                                'sms_factor_number' => $factorNumber,
                                'sms_cost' => $book_hotel[0]['total_price'],
                                'sms_destination' => $book_hotel[0]['city_name'],
                                'sms_hotel_name' => $book_hotel[0]['hotel_name'],
                                'sms_hotel_in' => $book_hotel[0]['start_date'],
                                'sms_hotel_out' => $book_hotel[0]['end_date'],
                                'sms_hotel_night' => $book_hotel[0]['number_night'],
                                'sms_agency' => CLIENT_NAME,
                                'sms_agency_mobile' => CLIENT_MOBILE,
                                'sms_agency_phone' => CLIENT_PHONE,
                                'sms_agency_email' => CLIENT_EMAIL,
                                'sms_agency_address' => CLIENT_ADDRESS,
                            );
                            $smsArray = array(
                                'smsMessage' => $smsController->getUsableMessage('onRequestHotel', $messageVariables),
                                'cellNumber' => $mobile,
                                'smsMessageTitle' => 'onRequestHotel',
                                'memberID' => $book_hotel[0]['member_id'],
                                'receiverName' => $messageVariables['sms_name'],
                            );
                            $smsController->sendSMS($smsArray);
                        }
                    }

                    //sms to our supports
                    $objSms = $smsController->initService('1');
                    if ($objSms) {
                        $sms = " درخواست رزرو هتل اشتراکی داخلی به شماره فاکتور: {$factorNumber} منتظر بررسی و تایید میباشد. " . PHP_EOL . CLIENT_NAME;
                        $cellArray = array(
                            'afshar' => '09123493154'
                        );
                        foreach ($cellArray as $cellNumber) {
                            $smsArray = array(
                                'smsMessage' => $sms,
                                'cellNumber' => $cellNumber
                            );
                            $smsController->sendSMS($smsArray);
                        }
                    }


                }


            } else {

                $statusRequestWebService['book'] = "no";
                $statusRequestWebService['factor_number'] = $factorNumber;

            }


        }
        else {

            $sql = " SELECT * FROM book_hotel_local_tb WHERE factor_number='{$factorNumber}' AND flat_type='DBL' GROUP BY room_id";
            $book_hotel = $Model->select($sql);
            $sql = " SELECT * FROM reservation_hotel_tb WHERE id='{$book_hotel[0]['hotel_id']}' ";
            $hotel_info = $Model->load($sql);
            if($hotel_info['user_id']) {
                $reservation_controller = Load::controller('reservationPublicFunctions');
                $agency  = $reservation_controller->getAgency($hotel_info['user_id']) ;
                $agency_mobile = $agency['mobile'];
            }
            $book_hotel[0]['total_price'] = $book_hotel[0]['hotel_payments_price'];

            $onRequest = '';
            $total_price = $book_hotel[0]['total_price'];
            $member_id = $book_hotel[0]['member_id'];
            $hotel_name = $book_hotel[0]['hotel_name'];
            $city_name = $book_hotel[0]['city_name'];
            $start_date = $book_hotel[0]['start_date'];
            $end_date = $book_hotel[0]['end_date'];
            $number_night = $book_hotel[0]['number_night'];
            if (!empty($book_hotel[0]['member_mobile'])) {
                $mobile = $book_hotel[0]['member_mobile'];
                $name =  $book_hotel[0]['member_name'];
            } else {
                $mobile = $book_hotel[0]['passenger_leader_room'];
                $name = $book_hotel[0]['passenger_leader_room_fullName'];
            }
//var_dump($book_hotel);
//            die;
            foreach ($book_hotel as $i => $room) {

                // info hotel room
                $resultInfoHotelRoom = $this->infoHotelRoom($room["hotel_id"], $room["room_id"], $room["start_date"], $room["end_date"], $room['flat_type']);

                $room_count = $room['room_count'] * $room['number_night'];
                // for remaining capacity hotel

                if ($resultInfoHotelRoom['total_capacity'] == '0' || $resultInfoHotelRoom['maximum_capacity'] == '0') {
                    $onRequest = "onRequest";
                } else if ($room_count > $resultInfoHotelRoom['remaining_capacity']) {
                    $onRequest = "onRequest";
                }

            }
           
            // book successfully or onRequest
//            var_dump($book_hotel);
//            var_dump($onRequest);
//            die();
            if (empty($onRequest)) {

                $d['status'] = "PreReserve";
                $d['creation_date_int'] = time();
                $d['payment_date'] = Date('Y-m-d H:i:s');

                $Condition = "factor_number='{$factorNumber}' ";
                $Model->setTable("book_hotel_local_tb");
                $res = $Model->update($d, $Condition);

                $ModelBase->setTable("report_hotel_tb");
                $res_report = $ModelBase->update($d, $Condition);

                $statusRequestWebService['type_application'] = $typeApplication;
                $statusRequestWebService['book'] = "yes";
                $statusRequestWebService['factor_number'] = $factorNumber;
                $statusRequestWebService['total_price'] = $total_price;
                $statusRequestWebService['user_type'] = $counter_type_id;

            }
            else {

                $d['status'] = 'OnRequest';
                $d['creation_date_int'] = time();

                $Condition = "factor_number='{$factorNumber}' ";
                $Model->setTable("book_hotel_local_tb");
                $res = $Model->update($d, $Condition);

                $ModelBase->setTable("report_hotel_tb");
                $res_report = $ModelBase->update($d, $Condition);

                $statusRequestWebService['book'] = "OnRequest";
                $statusRequestWebService['factor_number'] = $factorNumber;
                $statusRequestWebService['total_price'] = $total_price;
                $statusRequestWebService['user_type'] = $counter_type_id;

                //sms to buyer
                $objSms = $smsController->initService('0');
                if ($objSms) {
                    $on_request_hotel_pattern =   $smsController->getPattern('on_request_hotel');
                    if($on_request_hotel_pattern) {
                        $smsController->smsByPattern($on_request_hotel_pattern['pattern'], array($mobile), array('customer_name' => CLIENT_NAME , 'hotel_name' => $hotel_name));
                    }else {
                        //to member
                        $messageVariables = array(
                            'sms_name' => $name,
                            'sms_service' => 'هتل',
                            'sms_factor_number' => $factorNumber,
                            'sms_cost' => $total_price,
                            'sms_destination' => $city_name,
                            'sms_hotel_name' => $hotel_name,
                            'sms_hotel_in' => $start_date,
                            'sms_hotel_out' => $end_date,
                            'sms_hotel_night' => $number_night,
                            'sms_agency' => CLIENT_NAME,
                            'sms_agency_mobile' => CLIENT_MOBILE,
                            'sms_agency_phone' => CLIENT_PHONE,
                            'sms_agency_email' => CLIENT_EMAIL,
                            'sms_agency_address' => CLIENT_ADDRESS,
                        );
                        $smsArray = array(
                            'smsMessage' => $smsController->getUsableMessage('onRequestHotel', $messageVariables),
                            'cellNumber' => $mobile,
                            'smsMessageTitle' => 'onRequestHotel',
                            'memberID' => $member_id,
                            'receiverName' => $messageVariables['sms_name'],
                        );

                        $smsController->sendSMS($smsArray);
                    }
                    if($hotel_info['user_id']){
                        $mobile = $agency_mobile ;
                    }else{
                        $mobile = CLIENT_MOBILE ;
                    }

                    //to site manager
                    $smsArray = array(
                        'smsMessage' => $smsController->getUsableMessage('onRequestHotelToManager', $messageVariables),
                        'cellNumber' => $mobile,
                        'smsMessageTitle' => 'onRequestHotel',
                        'memberID' => $member_id,
                        'receiverName' => $messageVariables['sms_name'],
                    );

                    $smsController->sendSMS($smsArray);
                }

            }

        }

        echo json_encode($statusRequestWebService);


    }


    // مرحله ورود اسامی سرگروه های هر اتاق و فروش نهایی 
    public function Hotel_Reserve_Book($requestNumber, $requestPNR, $factorNumber)
    {

        $url = $this->urlApi . 'Hotel/Reserve/Book/' . $requestNumber . '/' . $requestPNR . '/' . $this->guid;
        $data = array();

        $Model = Load::library('Model');
        $sql = " SELECT * FROM book_hotel_local_tb WHERE factor_number='{$factorNumber}' ";
        $Hotel = $Model->select($sql);

        if (isset($_SERVER["HTTP_HOST"])
            && (strpos($_SERVER["HTTP_HOST"], '192.168.1.100') !== false
                || strpos($_SERVER["HTTP_HOST"], 'online.1011.ir') !== false
                || strpos($_SERVER["HTTP_HOST"], 'agency.1011.ir') !== false
                || strpos($_SERVER["HTTP_HOST"], 'indobare.com') !== false
                || strpos($_SERVER["HTTP_HOST"], 'iran-tech.com') !== false
                || strpos($_SERVER["HTTP_HOST"], 'test.1011.ir') !== false)) {//local && test

            foreach ($Hotel as $i => $book) {
                $data['GuestDataList'][$i]['FirstName'] = "تست ایران تکنولوژی";
                $data['GuestDataList'][$i]['LastName'] = "تست ایران تکنولوژی";
                $data['GuestDataList'][$i]['NationalCode'] = $book['passenger_national_code'];
                $data['GuestDataList'][$i]['BedType'] = ($book['BedType'] == "double") ? "1" : "2";
                $data['SalesExpertFullName'] = "تست ایران تکنولوژی";
                $data['SalesExpertMobile'] = $book['member_mobile'];
                $data['LeaderPhoneNumber'] = $book['passenger_leader_room'];

            }

        } else {

            foreach ($Hotel as $i => $book) {
                $data['GuestDataList'][$i]['FirstName'] = " " . $book['passenger_name'] . " ";
                $data['GuestDataList'][$i]['LastName'] = " " . $book['passenger_family'] . " ";
                $data['GuestDataList'][$i]['NationalCode'] = $book['passenger_national_code'];
                $data['GuestDataList'][$i]['BedType'] = ($book['BedType'] == "double") ? "1" : "2";
                $data['SalesExpertFullName'] = " " . $book['passenger_leader_room_fullName'] . " ";
                $data['SalesExpertMobile'] = $book['member_mobile'];
                $data['LeaderPhoneNumber'] = $book['passenger_leader_room'];

            }
        }

        $jsonData = json_encode($data);

        functions::insertLog('url request with factor number ' . $factorNumber . ' => ' . $url, 'log_hotel_reserve');
        functions::insertLog('json data request with factor number ' . $factorNumber . ' => ' . $jsonData, 'log_hotel_reserve');
        $HotelReserveBook = $this->curlExecutionPost($url, $jsonData, 'yes');
        functions::insertLog('response with factor number ' . $factorNumber . ' => ' . json_encode($HotelReserveBook, true), 'log_hotel_reserve');



        return $HotelReserveBook;
    }


    /**************************RoomPrice************************/

    // دریافت قیمت گذاری اتاق ها از تمام هتل ها در کلیه تاریخ ها از حال تا آینده 
    public function All_RoomPrice($startDate, $endDate)
    {

        $url = $this->urlApi . 'RoomPrice/' . $startDate . '/' . $endDate . '/' . $this->guid;
        $AllRoomPrice = $this->curlExecutionGet($url);

        return $AllRoomPrice;
    }


    // دریافت قیمت گذاری های یک اتاق مشخص برای یک هتل در تمام روز ها از حال تا آینده 
    public function HotelRoomPrice($hotelCode, $roomCode)
    {

        $url = $this->urlApi . 'RoomPrice/' . $hotelCode . '/' . $roomCode . '/' . $this->guid;
        $HotelRoomPrice = $this->curlExecutionGet($url);

        return $HotelRoomPrice;
    }


    // دریافت قیمت یک اتاق مشخص برای یک هتل در روز مشخص شده 
    public function RoomPrice_forDate($hotelCode, $roomCode, $date)
    {

        $url = $this->urlApi . 'RoomPrice/' . $hotelCode . '/' . $roomCode . '/' . $date . '/' . $this->guid;
        $RoomPrice = $this->curlExecutionGet($url);

        return $RoomPrice;
    }


    // جستوجو برای لیست اتاق های موجود از یک نوع اتاق خاص در یک بازه تاریخی و بازگرداندن لیست قیمت و ظرفیت 
    public function RoomPriceStartDate($hotelCode, $roomCode, $startDate, $nightCount, $factorNumber = null)
    {
        $url = $this->urlApi . 'RoomPrice/' . $hotelCode . '/' . $roomCode . '/' . $startDate . '/' . $nightCount . '/' . $this->guid;
        functions::insertLog('request with factor number ' . $factorNumber . ' => ' . $url, 'log_hotel_roomPrice');
        $RoomPrice = $this->curlExecutionGet($url);
        functions::insertLog('response with factor number ' . $factorNumber . ' => ' . json_encode($RoomPrice, true), 'log_hotel_roomPrice');

        return $RoomPrice;
    }

    public function NextStepReserveHotel($param)
    {
        $Model = Load::library('Model');


        if (empty($param['factorNumber'])) {
            //$factorNumber = dateTimeSetting::jdate("Ymd",'','','','en') . mt_rand(000, 999) . substr(time(), 8, 10);
            $factorNumber = substr(time(), 0, 3) . mt_rand(00, 99) . substr(time(), 7, 10);
        } else {
            $factorNumber = $param['factorNumber'];
        }

        #region [hotel reservation or api]
        if ($param['TypeApplication'] == "api") {

            $City = $this->City($param['IdCity']);
            $Hotel = $this->Hotel($param['IdHotel']);
            $RoombyHotel = $this->Room_byHotel($param['IdHotel']);
            $exp = explode(',', $param['TotalNumberRoom_Reserve']);
            $roomSelected = array();

            foreach ($exp as $key => $item) {
                if (!empty($item)) {

                    $exple = explode('-', $item);
                    $array_bg = $this->array_filter_by_value($RoombyHotel, 'Code', $exple[0]);

                    $roomSelected = array_merge($roomSelected, $array_bg);
                    $roomSelected[$key]['count'] = $exple[1];

                }
            }


            for ($room = 0; $room < count($roomSelected); $room++) {

                $RoomPrice = $this->RoomPriceStartDate($param['IdHotel'], $roomSelected[$room]['Code'], str_replace('-', '', $param['SDate']), $param['Nights']);
                if (!empty($RoomPrice)){

                    foreach ($RoomPrice as $item) {

                        if (!empty($this->serviceDiscount['api']) && $this->serviceDiscount['api']['off_percent'] > 0) {
                            $d['services_discount'] = $this->serviceDiscount['api']['off_percent'];
                        }

                        $d['factor_number'] = $factorNumber;
                        $d['city_id'] = $City['Code'];
                        $d['city_name'] = $City['Name'];
                        $d['hotel_id'] = $param['IdHotel'];
                        $d['hotel_name'] = $Hotel['Name'];
                        $d['hotel_name_en'] = $Hotel['NameEn'];
                        $d['hotel_address'] = $Hotel['AddressInfo']['Address'];
                        $d['hotel_address_en'] = $Hotel['AddressInfo']['AddressEn'];
                        $d['hotel_telNumber'] = $Hotel['TelNumber'];
                        $d['hotel_starCode'] = $Hotel['StarCode'];
                        $d['hotel_entryHour'] = $Hotel['EntryHour'];
                        $d['hotel_leaveHour'] = $Hotel['LeaveHour'];
                        $d['hotel_pictures'] = $Hotel['HotelPictures'][0]['Url'];
                        $d['bed_type'] = "main_bed";
                        $d['room_id'] = $roomSelected[$room]['Code'];
                        $d['room_name'] = $roomSelected[$room]['Name'];
                        $d['room_name_en'] = $roomSelected[$room]['NameEn'];
                        $d['max_capacity_count_room'] = $roomSelected[$room]['MaxCapacity'];
                        $d['remaining_capacity'] = $item['RemainingCapacity'];
                        $d['start_date'] = $param['SDate'];
                        $d['end_date'] = $param['EDate'];
                        $d['number_night'] = $param['Nights'];
                        $d['date_current'] = functions::convertDate($item['Date']);
                        $d['price_current'] = $item['Price'];
                        $d['price_Board_current'] = $item['PriceBoard'];
                        $d['price_online_current'] = $item['PriceOnline'];
                        $d['price_foreign_current'] = $item['PriceForeign'];
                        $d['rules'] = $Hotel['CancellationConditions'];
                        $d['room_count'] = $roomSelected[$room]['count'];


                        $res_agency_commission = functions::getHotelPriceChange($City['Code'], $Hotel['StarCode'], $this->counterId, $item['Date'], 'api');
                        if ($res_agency_commission != false) {
                            $d['agency_commission'] = $res_agency_commission['price'];
                            $d['agency_commission_price_type'] = $res_agency_commission['price_type'];
                            $d['type_of_price_change'] = $res_agency_commission['change_type'];
                        } else {
                            $d['agency_commission'] = 0;
                            $d['agency_commission_price_type'] = '';
                            $d['type_of_price_change'] = '';
                        }
//        if(  $_SERVER['REMOTE_ADDR']=='5.201.144.255'  ) {
//            var_dump('aaaaaa');
//            echo json_encode($d);
//            var_dump('bbbbb');
//            die;
//        }
                        $Model->setTable('temprory_hotel_local_tb');
                        $res[] = $Model->insertLocal($d);

                    }

                } else {
                    $res[] = 0;
                }



            }

            if (in_array('0', $res)){
                return 'error_NextStepReserveHotel';
            } else {
                return 'success_NextStepReserveHotel:' . $factorNumber;
            }

        } else {
            return 'success_NextStepReserveHotel:' . $factorNumber;
        }
        #endregion


    }


    public function InsertPassengerHotel($data)
    {
        unset($data['Mobile_buyer']);
        unset($data['Email_buyer']);
        $Model = Load::library('Model');

        $sql = " SELECT * FROM passengers_tb WHERE (NationalCode='{$data['NationalCode']}' OR passportNumber='{$data['passportNumber']}') AND name='{$data['name']}' AND family='{$data['family']}'AND fk_members_tb_id='{$data['fk_members_tb_id']}'";
        $passenger = $Model->load($sql);

        if (empty($passenger)) {
            $Model->setTable("passengers_tb");
            $Model->insertLocal($data);
        }

    }


    public function array_filter_by_value($my_array, $index, $value)
    {
        $new_array = array();
        if (is_array($my_array) && count($my_array) > 0) {
            foreach (array_keys($my_array) as $key) {
                $temp[$key] = $my_array[$key][$index];

                if ($temp[$key] == $value) {
                    $new_array[$key] = $my_array[$key];
                }
            }
        }
        return $new_array;
    }

    //  جستوجو برای لیست اتاق های موجود از هر نوع در یک بازه تاریخی و بازگرداندن لیست قیمت و ظرفیت
    public function Hotel_AllRoomPrice($hotelCode, $startDate, $nightCount)
    {

        $url = $this->urlApi . 'RoomPrice/' . $hotelCode . '/' . $startDate . '/' . $nightCount . '/' . $this->guid;
        $HotelAllRoomPrice = $this->curlExecutionGet($url);

        return $HotelAllRoomPrice;
    }

    public function checkLogin()
    {

        $result = Session::IsLogin();
        $result2 = Session::getTypeUser();
        if ($result && $result2 == 'counter') {
            return 'successLoginHotel';
        } else {
            return 'errorLoginHotel';
        }

    }

    public function registerPassengerOnline()
    {


        $login_user = Session::IsLogin();
        $members_model = Load::model('members');

        if ($login_user) {
            $IdMember = $_SESSION["userId"];
        } else {

            $data['mobile'] = isset($_POST['mobile']) ? $_POST['mobile'] : null;
            $data['telephone'] =isset($_POST['telephone']) ? $_POST['telephone'] : null ;
            $data['email'] = $_POST['Email'];
            $data['password'] = $members_model->encryptPassword($_POST['mobile']);
            $data['is_member'] = '0';
            $sms = 'یک درخواست تور آفلاین ثبت شد' ;
            $members = $this->login_members_online($data['email']);
            if (!$members) {
                $Model = Load::library('Model');
                $Model->setTable("members_tb");
                $Model->insertLocal($data);
                $IdMember = $Model->getLastId();
            } else {
                $IdMember = $members['id'];
            }
        }

        if (!empty($IdMember)) {
            return trim($IdMember);
        }
        return null;
    }

    public function login_members_online($email)
    {
        $Model = Load::library('Model');
        $sql = "SELECT * FROM members_tb WHERE email='{$email}'";
        return $Model->load($sql);
    }


    public function FirstBookHotel($param, $IdMember, $factorNumber, $typeApplication, $it_commission)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $WHERE = !empty($param['NationalCode']) ? "passenger_national_code='{$param['NationalCode']}' " : "passportNumber='{$param['passportNumber']}'";

        $sql_check_book = " SELECT * FROM book_hotel_local_tb WHERE factor_number ='{$factorNumber}' AND member_id='{$IdMember}' AND $WHERE"
            . " AND passenger_gender='{$param['gender']}' AND type_application='{$typeApplication}' ";
        $book_check = $Model->load($sql_check_book);

        $sql = " SELECT * FROM members_tb WHERE id='{$IdMember}'";
        $user = $Model->load($sql);
        if (!empty($user)) {
            $sql = " SELECT * FROM agency_tb WHERE id='{$user['fk_agency_id']}'";
            $agency = $Model->load($sql);
        }

        if (empty($book_check)) {

            if (!empty($param['birthday_fa'])) {
                $explode_br_fa = explode('-', $param['birthday_fa']);
                $date_miladi = dateTimeSetting::jalali_to_gregorian($explode_br_fa[0], $explode_br_fa[1], $explode_br_fa[2], '-');
            }
        }


        $sql = " SELECT * FROM temprory_hotel_local_tb WHERE factor_number='{$factorNumber}' AND room_id='{$param['Id_Select_Room']}' GROUP BY room_id";
        $temprory_hotel = $Model->Load($sql);

        $d['passenger_national_code'] = !empty($param['NationalCode']) ? $param['NationalCode'] : '0000000000';
        $d['passenger_age'] = $this->type_passengers(isset($param['birthday']) ? $param['birthday'] : $date_miladi);

        $d['passenger_gender'] = $param['gender'];
        $d['passenger_name'] = $param['name'];
        $d['passenger_name_en'] = $param['name_en'];
        $d['passenger_family'] = $param['family'];
        $d['passenger_family_en'] = $param['family_en'];
        $d['passenger_birthday'] = (isset($param['birthday_fa']) && $param['birthday_fa'] != '') ? $param['birthday_fa'] : '';
        $d['passenger_birthday_en'] = (isset($param['birthday']) && $param['birthday'] != '') ? $param['birthday'] : '';
        $d['passenger_national_code'] = $param['NationalCode'];
        $d['passportCountry'] = $param['passportCountry'];
        $d['passportNumber'] = $param['passportNumber'];
        $d['passportExpire'] = $param['passportExpire'];
        $d['member_id'] = $user['id'];
        $d['member_name'] = $user['name'] . ' ' . $user['family'];
        $d['member_mobile'] = $user['mobile'];
        $d['member_phone'] = $user['telephone'];
        $d['member_email'] = $user['email'];
        if (!empty($agency)) {
            $d['agency_id'] = $agency['id'];
            $d['agency_name'] = $agency['name_fa'];
            $d['agency_accountant'] = $agency['accountant'];
            $d['agency_manager'] = $agency['manager'];
            $d['agency_mobile'] = $agency['mobile'];
        }
        $d['factor_number'] = $factorNumber;
        $d['room_id'] = $param['Id_Select_Room'];
        if (isset($param['time_entering_room'])) {
            $d['time_entering_room'] = $param['time_entering_room'];
        }
        $d['bed_type'] = $param['BedType'];
        $d['passenger_leader_room'] = $param['passenger_leader_room'];
        $d['passenger_leader_room_fullName'] = $param['passenger_leader_room_fullName'];
        $d['passenger_leader_room_email'] = $param['passenger_leader_room_email'];
        $d['passenger_leader_room_postalcode'] = $param['passenger_leader_room_postalcode'];
        $d['passenger_leader_room_address'] = $param['passenger_leader_room_address'];
        $d['agency_commission'] = $temprory_hotel['agency_commission'];
        $d['agency_commission_price_type'] = $temprory_hotel['agency_commission_price_type'];
        $d['type_of_price_change'] = $temprory_hotel['type_of_price_change'];
        $d['room_price'] = $param['room_price'];
        $d['room_bord_price'] = $param['room_bord_price'];
        $d['room_online_price'] = $param['room_online_price'];

        $d['city_id'] = $temprory_hotel['city_id'];
        $d['city_name'] = $temprory_hotel['city_name'];
        $d['hotel_id'] = $temprory_hotel['hotel_id'];
        $d['hotel_name'] = $temprory_hotel['hotel_name'];
        $d['hotel_name_en'] = $temprory_hotel['hotel_name_en'];
        $d['hotel_address'] = $temprory_hotel['hotel_address'];
        $d['hotel_address_en'] = $temprory_hotel['hotel_address_en'];
        $d['hotel_telNumber'] = $temprory_hotel['hotel_telNumber'];
        $d['hotel_starCode'] = $temprory_hotel['hotel_starCode'];
        $d['hotel_entryHour'] = $temprory_hotel['hotel_entryHour'];
        $d['hotel_leaveHour'] = $temprory_hotel['hotel_leaveHour'];
        $d['hotel_pictures'] = $temprory_hotel['hotel_pictures'];
        $d['hotel_rules'] = $temprory_hotel['rules'];
        $d['room_id'] = $temprory_hotel['room_id'];
        $d['room_name'] = $temprory_hotel['room_name'];
        $d['room_name_en'] = $temprory_hotel['room_name_en'];
        $d['room_count'] = $temprory_hotel['room_count'];
        $d['max_capacity_count_room'] = $temprory_hotel['max_capacity_count_room'];
        $d['remaining_capacity'] = $temprory_hotel['remaining_capacity'];
        $d['start_date'] = $temprory_hotel['start_date'];
        $d['end_date'] = $temprory_hotel['end_date'];
        $d['number_night'] = $temprory_hotel['number_night'];
        $d['date_current'] = $temprory_hotel['date_current'];


        if ($temprory_hotel['type_of_price_change'] == 'increase' && $temprory_hotel['agency_commission_price_type'] == 'cost') {
            $price_current = $temprory_hotel['price_current'] + $temprory_hotel['agency_commission'];

        } elseif ($temprory_hotel['type_of_price_change'] == 'decrease' && $temprory_hotel['agency_commission_price_type'] == 'cost') {
            $price_current = $temprory_hotel['price_current'] - $temprory_hotel['agency_commission'];

        } elseif ($temprory_hotel['type_of_price_change'] == 'increase' && $temprory_hotel['agency_commission_price_type'] == 'percent') {
            $price_current = ($temprory_hotel['price_current'] * $temprory_hotel['agency_commission'] / 100) + $temprory_hotel['price_current'];

        } elseif ($temprory_hotel['type_of_price_change'] == 'decrease' && $temprory_hotel['agency_commission_price_type'] == 'percent') {
            $price_current = ($temprory_hotel['price_current'] * $temprory_hotel['agency_commission'] / 100) - $temprory_hotel['price_current'];

        } else {
            $price_current = $temprory_hotel['price_current'];
        }
        $d['price_current'] = $price_current;

        $d['currency_code'] = $param['currency_code'];
        $d['currency_equivalent'] = $param['currency_equivalent'];

        $d['type_application'] = $typeApplication;
        $d['serviceTitle'] = functions::TypeServiceHotel($typeApplication);

        $d['irantech_commission'] = $it_commission;

        if (!empty($this->serviceDiscount['api']) && $this->serviceDiscount['api']['off_percent'] > 0) {
            $d['services_discount'] = $this->serviceDiscount['api']['off_percent'];
        }

        if (empty($book_check)) {
            $Model->setTable('book_hotel_local_tb');
            $Model->insertLocal($d);

            $ModelBase->setTable('report_hotel_tb');
            $d['client_id'] = CLIENT_ID;
            $ModelBase->insertLocal($d);

        }

    }

    public function type_passengers($birthday)
    {

        $date_two = date("Y-m-d", strtotime("-2 year"));
        $date_twelve = date("Y-m-d", strtotime("-12 year"));

        if (strcmp($birthday, $date_two) > 0) {
            return "Inf";
        } elseif (strcmp($birthday, $date_two) <= 0 && strcmp($birthday, $date_twelve) > 0) {
            return "Chd";
        } else {
            return "Adt";
        }
    }


    /*public function check_credit($amount)
    {
        $Credit = $this->get_credit();

        if ($Credit > 0) {
            if ($amount > $Credit) {
                return 'FALSE';
            } else {
                return 'TRUE';
            }
        } else {
            return 'FALSE';
        }
    }*/

    /*public function get_credit()
    {
        $time = time() - (600);
        $sql = "SELECT"
            . " COALESCE((SELECT SUM(Price) FROM transaction_tb WHERE Status='1'), 0) as `credit`, "
            . " COALESCE((SELECT SUM(Price) FROM transaction_tb WHERE Status='2' AND"
            . "  ((PaymentStatus = 'success') OR (PaymentStatus = 'pending' AND CreationDateInt > '{$time}')) ), 0) as `debit` ";

        $Model = Load::library('Model');
        $result = $Model->load($sql);

        return ($result['credit'] - $result['debit']);
    }*/

    /*public function insertLog($operation){

        error_log($operation . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Api_hotel.txt');
    }*/






////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////Reservation///////////////////////////////////////////////////

    // واکشی اطلاعات کامل یک هتل رزرواسیون، توسط کد آن هتل
    public function ReservationHotel($hotelCode)
    {

     
        $Model = Load::library('Model');

        $hotel = array();
        $sql = " SELECT * FROM reservation_hotel_tb WHERE id='{$hotelCode}' AND is_del='no' ";
        $resultHotel = $Model->Load($sql);
        if (!empty($resultHotel)) {
            $distance_to_important_places = str_replace(array("\r\n", "\n"), array("<br />", "<br />"), $resultHotel['distance_to_important_places']);
            $distance_to_important_places_en = str_replace(array("\r\n", "\n"), array("<br />", "<br />"), $resultHotel['distance_to_important_places_en']);
            $comment = str_replace(array("\r\n", "\n"), array("", ""), $resultHotel['comment']);
            $comment_en = str_replace(array("\r\n", "\n"), array("", ""), $resultHotel['comment_en']);

            $hotel['Code'] = $resultHotel['id'];
            $hotel['Name'] = $resultHotel['name'];
            $hotel['NameEn'] = $resultHotel['name_en'];
            if (isset($resultHotel['logo']) && $resultHotel['logo'] != '') {
                $hotel['Logo'] = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . $resultHotel['logo'];
            } else {
                $hotel['Logo'] = ROOT_ADDRESS_WITHOUT_LANG . '/pic/noPhoto.jpg';
            }
            $hotel['HotelTypeCode'] = $resultHotel['type_code'];
            $hotel['Discount'] = $resultHotel['discount'];
            $hotel['AddressInfo']['CountryCode'] = $resultHotel['country'];
            $hotel['AddressInfo']['CityCode'] = $resultHotel['city'];
            $hotel['AddressInfo']['RegionCode'] = $resultHotel['region'];
            $hotel['AddressInfo']['Address'] = $resultHotel['address'];
            $hotel['AddressInfo']['Address_en'] = $resultHotel['address_en'];
            $hotel['MapCoordination']['Longitude'] = $resultHotel['longitude'];
            $hotel['MapCoordination']['Latitude'] = $resultHotel['latitude'];
            $hotel['NumberOfRooms'] = $resultHotel['number_of_rooms'];
            $hotel['EntryHour'] = $resultHotel['entry_hour'];
            $hotel['LeaveHour'] = $resultHotel['leave_hour'];
            $hotel['TelNumber'] = $resultHotel['tel_number'];
            $hotel['tripAdvisor'] = $resultHotel['trip_advisor'];
            $hotel['StarCode'] = $resultHotel['star_code'];
            $hotel['Rules'] = $resultHotel['rules'];
            $hotel['Rules_en'] = $resultHotel['rules_en'];
            $hotel['CancellationConditions'] = $resultHotel['cancellation_conditions'];
            $hotel['CancellationConditions_en'] = $resultHotel['cancellation_conditions_en'];
            $hotel['ChildDescription'] = $resultHotel['child_conditions'];
            $hotel['ChildDescription_en'] = $resultHotel['child_conditions_en'];
            $hotel['Comment'] = $comment;
            $hotel['Comment_en'] = $comment_en;
            $hotel['DistanceToImportantPlaces'] = $distance_to_important_places;
            $hotel['DistanceToImportantPlaces_en'] = $distance_to_important_places_en;
            $hotel['FlagSpecial'] = $resultHotel['flag_special'];
            $hotel['FlagDiscount'] = $resultHotel['flag_discount'];
            $hotel['transfer'] = $resultHotel['transfer_went'] == 'yes' || $resultHotel['transfer_back'] == 'yes';
            $hotel['is_request'] = $resultHotel['is_request'] ;
            $hotel['iframe_code'] = $resultHotel['iframe_code'] ;
            $hotel['prepayment_percentage'] = $resultHotel['prepayment_percentage'] ;
            $hotel['user_id'] = $resultHotel['user_id'] ;

            $ResultFacilities = $this->hotelFacilities($hotelCode);
            foreach ($ResultFacilities as $key => $facilities) {

                $hotel['HotelFacilityList'][$key] = $facilities['title'];

                $hotel['HotelFacility'][$key]['IdFacilities'] = $facilities['id_facilities'];
                $hotel['HotelFacility'][$key]['Title'] = $facilities['title'];
                $hotel['HotelFacility'][$key]['IconClass'] = $facilities['icon_class'];
            }


            $sql = " SELECT * FROM reservation_hotel_gallery_tb WHERE id_hotel='{$hotelCode}' AND is_del='no' ";
            $ResultPic = $Model->select($sql);
            foreach ($ResultPic as $key => $pic) {

                $exp = explode(".", $pic['pic']);

                $hotel['HotelPictures'][$key]['Code'] = $pic['id'];
                $hotel['HotelPictures'][$key]['Name'] = $pic['name'];
                $hotel['HotelPictures'][$key]['Comment'] = $pic['comment'];
                $hotel['HotelPictures'][$key]['Url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . $pic['pic'];
                $hotel['HotelPictures'][$key]['Format'] = $exp[1];
                $hotel['HotelPictures'][$key]['picName'] = $exp[0];
            }
        }

        return $hotel;
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


    public function firstBookReservationHotel($param, $IdMember, $factorNumber, $infoHotel, $typeApplication, $it_commission, $serviceTitle)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $sql_check_book = " SELECT id FROM book_hotel_local_tb WHERE 
              factor_number ='{$factorNumber}' AND member_id='{$IdMember}' AND 
              roommate='{$param['roommate']}' AND passenger_gender='{$param['gender']}' AND 
              type_application='{$typeApplication}' ";
        $book_check = $Model->load($sql_check_book);

        if (empty($book_check)) {

            if (!empty($param['birthday_fa'])) {
                $explode_br_fa = explode('-', $param['birthday_fa']);
                $date_miladi = dateTimeSetting::jalali_to_gregorian($explode_br_fa[0], $explode_br_fa[1], $explode_br_fa[2], '-');
            }
        }

        $d['factor_number'] = $factorNumber;
        $d['type_application'] = $typeApplication;
        $d['hotel_room_prices_id'] = $param['hotel_room_prices_id'];
        $d['roommate'] = $param['roommate'];
        $d['flat_type'] = $param['flat_type'];

        $d['passenger_national_code'] = !empty($param['NationalCode']) ? $param['NationalCode'] : '0000000000';
        $d['passenger_age'] = $this->type_passengers(isset($param['birthday']) ? $param['birthday'] : $date_miladi);
        $d['passenger_gender'] = $param['gender'];
        $d['passenger_name'] = $param['name'];
        $d['passenger_name_en'] = $param['name_en'];
        $d['passenger_family'] = $param['family'];
        $d['passenger_family_en'] = $param['family_en'];
        $d['passenger_birthday'] = $param['birthday_fa'];
        $d['passenger_birthday_en'] = (isset($param['birthday']) && $param['birthday'] != '') ? $param['birthday'] : '';
        $d['passenger_national_code'] = $param['NationalCode'];
        $d['passportCountry'] = $param['passportCountry'];
        $d['passportNumber'] = $param['passportNumber'];
        $d['passportExpire'] = $param['passportExpire'];
        $d['passenger_leader_room'] = $param['passenger_leader_room'];
        $d['passenger_leader_room_fullName'] = $param['passenger_leader_room_fullName'];
        $d['passenger_leader_room_email'] = $param['passenger_leader_room_email'];
        $d['passenger_leader_room_postalcode'] = $param['passenger_leader_room_postalcode'];
        $d['passenger_leader_room_address'] = $param['passenger_leader_room_address'];


        $sql = " SELECT * FROM members_tb WHERE id='{$IdMember}'";
        $user = $Model->load($sql);
        if (!empty($user)) {

            $d['member_id'] = $user['id'];
            $d['member_name'] = $user['name'] . ' ' . $user['family'];
            $d['member_mobile'] = $user['mobile'];
            $d['member_phone'] = $user['telephone'];
            $d['member_email'] = $user['email'];

            $sql = " SELECT * FROM agency_tb WHERE id='{$user['fk_agency_id']}'";
            $agency = $Model->load($sql);
            if (!empty($agency)) {
                $d['agency_id'] = $agency['id'];
                $d['agency_name'] = $agency['name_fa'];
                $d['agency_accountant'] = $agency['accountant'];
                $d['agency_manager'] = $agency['manager'];
                $d['agency_mobile'] = $agency['mobile'];
            }
        }

        $d['start_date'] = $infoHotel['start_date'];
        $d['end_date'] = $infoHotel['end_date'];
        $d['number_night'] = $infoHotel['number_night'];
        $d['city_id'] = $infoHotel['city_id'];
        $d['hotel_id'] = $infoHotel['hotel_id'];

        $d['city_id'] = $infoHotel['city_id'];
        $d['city_name'] = $infoHotel['city_name'];
        $d['hotel_id'] = $infoHotel['hotel_id'];
        $d['hotel_name'] = $infoHotel['hotel_name'];
        $d['hotel_name_en'] = $infoHotel['hotel_name_en'];
        $d['hotel_address'] = $infoHotel['hotel_address'];
        $d['hotel_address_en'] = '';
        $d['hotel_telNumber'] = $infoHotel['hotel_telNumber'];
        $d['hotel_starCode'] = $infoHotel['hotel_starCode'];
        $d['hotel_entryHour'] = $infoHotel['hotel_entryHour'];
        $d['hotel_leaveHour'] = $infoHotel['hotel_leaveHour'];
        $d['hotel_pictures'] = $infoHotel['hotel_pictures'];
        $d['hotel_rules'] = $infoHotel['hotel_rules'];

        $d['room_id'] = $infoHotel['room_id'];
        $d['room_id'] = $infoHotel['room_id'];
        $d['room_name'] = $infoHotel['room_name'];
        $d['room_name_en'] = $infoHotel['room_name_en'];
        $d['room_count'] = $infoHotel['room_count'];
        $d['services_discount'] = $infoHotel['services_discount'];
        $d['total_price_api'] = $infoHotel['total_price_api'];
        $d['child_count'] = $infoHotel['child_count'];
        $d['child_price'] = $infoHotel['child_price'];
        $d['extra_bed_count'] = $infoHotel['extra_bed_count'];
        $d['extra_bed_price'] = $infoHotel['extra_bed_price'];
        $d['max_capacity_count_room'] = $infoHotel['room_capacity'];
        $d['remaining_capacity'] = $infoHotel['remaining_capacity'];

        $d['date_current'] = $infoHotel['date_current'];
        $d['price_current'] = $infoHotel['price_current'];
        $d['agency_commission'] = '';
        $d['agency_commission_price_type'] = '';
        $d['type_of_price_change'] = '';
        $d['room_price'] = $infoHotel['room_price'];
        $d['hotel_payments_price'] = $infoHotel['hotel_payments_price'];

        $d['room_online_price'] = $infoHotel['room_online_price'];
        $d['room_bord_price'] = $infoHotel['room_bord_price'];

        if (isset($infoHotel['isTransfer']) && $infoHotel['isTransfer'] == true) {
            $d['origin'] = $infoHotel['origin'];
            $d['flight_date_went'] = $infoHotel['flight_date_went'];
            $d['airline_went'] = $infoHotel['airline_went'];
            $d['flight_number_went'] = $infoHotel['flight_number_went'];
            $d['hour_went'] = $infoHotel['hour_went'];
            $d['flight_date_back'] = $infoHotel['flight_date_back'];
            $d['airline_back'] = $infoHotel['airline_back'];
            $d['flight_number_back'] = $infoHotel['flight_number_back'];
            $d['hour_back'] = $infoHotel['hour_back'];
        }

        $d['serviceTitle'] = $serviceTitle;
        $d['currency_code'] = $param['currency_code'];
        $d['currency_equivalent'] = $param['currency_equivalent'];

        $d['irantech_commission'] = $it_commission;

        $d['creation_date_int'] = time();
        if (empty($book_check)) {
            $Model->setTable('book_hotel_local_tb');
            $Model->insertLocal($d);

            $ModelBase->setTable('report_hotel_tb');
            $d['client_id'] = CLIENT_ID;
            $ModelBase->insertLocal($d);

        }


    }

    public function updateReservationHotelOnRequest($param, $IdMember, $factorNumber, $typeApplication , $book_id)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $sql_check_book = " SELECT id FROM book_hotel_local_tb WHERE 
              factor_number ='{$factorNumber}' AND member_id='{$IdMember}' AND 
              roommate='{$param['roommate']}' AND passenger_gender='{$param['gender']}' AND 
              type_application='{$typeApplication}' ";
        $book_check = $Model->load($sql_check_book);
        if (empty($book_check)) {
            if (!empty($param['birthday_fa'])) {
                $explode_br_fa = explode('-', $param['birthday_fa']);
                $date_miladi = dateTimeSetting::jalali_to_gregorian($explode_br_fa[0], $explode_br_fa[1], $explode_br_fa[2], '-');
            }
        }
        $d['passenger_national_code'] = !empty($param['NationalCode']) ? $param['NationalCode'] : '0000000000';
        $d['passenger_age'] = $this->type_passengers(isset($param['birthday']) ? $param['birthday'] : $date_miladi);
        $d['passenger_gender'] = $param['gender'];
        $d['passenger_name'] = $param['name'];
        $d['passenger_name_en'] = $param['name_en'];
        $d['passenger_family'] = $param['family'];
        $d['passenger_family_en'] = $param['family_en'];
        $d['passenger_birthday'] = $param['birthday_fa'];
        $d['passenger_birthday_en'] = (isset($param['birthday']) && $param['birthday'] != '') ? $param['birthday'] : '';
        $d['passenger_national_code'] = $param['NationalCode'];
        $d['passportCountry'] = $param['passportCountry'];
        $d['passportNumber'] = $param['passportNumber'];
        $d['passportExpire'] = $param['passportExpire'];
        $d['passenger_leader_room'] = $param['passenger_leader_room'];
        $d['passenger_leader_room_fullName'] = $param['passenger_leader_room_fullName'];
        $d['passenger_leader_room_email'] = $param['passenger_leader_room_email'];
        $d['passenger_leader_room_postalcode'] = $param['passenger_leader_room_postalcode'];
        $d['passenger_leader_room_address'] = $param['passenger_leader_room_address'];


        $sql = " SELECT * FROM members_tb WHERE id='{$IdMember}'";
        $user = $Model->load($sql);
        if (!empty($user)) {
            $d['member_id'] = $user['id'];
            $d['member_name'] = $user['name'] . ' ' . $user['family'];
            $d['member_mobile'] = $user['mobile'];
            $d['member_phone'] = $user['telephone'];
            $d['member_email'] = $user['email'];
            $sql = " SELECT * FROM agency_tb WHERE id='{$user['fk_agency_id']}'";
            $agency = $Model->load($sql);
            if (!empty($agency)) {
                $d['agency_id'] = $agency['id'];
                $d['agency_name'] = $agency['name_fa'];
                $d['agency_accountant'] = $agency['accountant'];
                $d['agency_manager'] = $agency['manager'];
                $d['agency_mobile'] = $agency['mobile'];
            }
        }
        $Condition = "factor_number='{$factorNumber}' and id ='{$book_id}' ";
//        var_dump($Condition);

        $Model->setTable('book_hotel_local_tb');
        $Model->update($d, $Condition);
        $ModelBase->setTable('report_hotel_tb');
        $d['client_id'] = CLIENT_ID;
        $ModelBase->update($d, $Condition);
    }
    public function infoHotel($idHotel)
    {

        $Model = Load::library('Model');

        $sql = " SELECT
                        H.id as hotel_id, H.name as hotel_name, H.name_en, H.tel_number, H.address, H.logo, H.prepayment_percentage,
                        H.star_code, H.entry_hour, H.leave_hour, H.rules, H.cancellation_conditions,
                        H.city, C.name as city_name, C.id as city_id, H.country as countryId , H.is_request as is_request ,H.user_id
                     FROM 
                        reservation_hotel_tb H LEFT JOIN reservation_city_tb C ON H.city=C.id
                     WHERE 
                        H.id='{$idHotel}' AND H.is_del='no'
                        ";
        $resultHotel = $Model->Load($sql);

        return $resultHotel;
    }

    public function infoHotelRoom($idHotel, $idRoom, $startDate, $endDate, $flatType, $counterTypeId = null)
    {

        $Model = Load::library('Model');

        if (isset($counterTypeId) && $counterTypeId != '') {
            $counter_type_id = $counterTypeId;
        } else {
            $checkLogin = Session::IsLogin();
            if ($checkLogin) {
                $counter_type_id = functions::getCounterTypeId($_SESSION['userId']);
            } else {
                $counter_type_id = '5';
            }
        }


        if (SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar'){
            $startDate = functions::ConvertToJalali($startDate);
            $endDate = functions::ConvertToJalali($endDate);
        }

        $startDate = str_replace("-", "", $startDate);
        $endDate = str_replace("-", "", $endDate);

        $sql = " SELECT
                        RP.id_room, RP.date, RP.online_price, RP.flat_type, RP.remaining_capacity,
                        RP.currency_price, RP.currency_type, HR.room_name, HR.room_capacity,
                        HR.room_name_en, HR.maximum_extra_beds, HR.maximum_extra_chd_beds,
                        RP.breakfast, RP.lunch, RP.dinner, RP.id as IdHotelRoomPrice,
                        maximum_capacity, total_capacity, RP.board_price
                     FROM 
                        reservation_hotel_room_prices_tb RP LEFT JOIN reservation_hotel_room_tb HR ON RP.id_room=HR.id_room
                     WHERE 
                        RP.id_hotel='{$idHotel}' AND
                        RP.id_room='{$idRoom}' AND
                        RP.is_del='no' AND
                        RP.user_type='{$counter_type_id}' AND
                        RP.flat_type='{$flatType}' AND
                        RP.date>='{$startDate}' AND RP.date<'{$endDate}'
                     GROUP BY  RP.date
                        ";

        $resultHotelRoom = $Model->select($sql);

        $online_price = 0;
        $remaining_capacity = 0;
        $total_capacity = 0;
        $maximum_capacity = 0;
        $board_price = 0;
        $IdHotelRoomPrice = '';
        foreach ($resultHotelRoom as $key => $val) {
           
            if ($key == 0) {

                $infoHotelRoom['room_id'] = $idRoom;
                $infoHotelRoom['room_name'] = $val['room_name'];
                $infoHotelRoom['room_name_en'] = $val['room_name_en'];
                $infoHotelRoom['room_capacity'] = $val['room_capacity'];
                $infoHotelRoom['maximum_extra_beds'] = $val['maximum_extra_beds'];
                $infoHotelRoom['maximum_extra_chd_beds'] = $val['maximum_extra_chd_beds'];
                $infoHotelRoom['date_current'] = $startDate;

                if($val['currency_price'] > 0 ) {
                    $currency_amount = functions::CalculateCurrencyPrice([
                        'price' => $val['currency_price'],
                        'currency_type' => $val['currency_type']
                    ]);
                    $infoHotelRoom['online_price_1night'] = $val['online_price']+ $currency_amount['AmountCurrency'];
                }else {
                    $infoHotelRoom['online_price_1night'] = $val['online_price'];
                }

            }

            if($val['currency_price'] > 0 ) {
                $currency_amount = functions::CalculateCurrencyPrice([
                    'price' => $val['currency_price'],
                    'currency_type' => $val['currency_type']
                ]);

                $board_price += $val['board_price']+ $currency_amount['AmountCurrency'];
                $online_price += $val['online_price']+ $currency_amount['AmountCurrency'];
            }else {
                $board_price += $val['board_price'];
                $online_price += $val['online_price'];
            }


            $total_capacity += $val['total_capacity'];
            $maximum_capacity += $val['maximum_capacity'];
            $remaining_capacity += $val['remaining_capacity'];
            $IdHotelRoomPrice .= $val['IdHotelRoomPrice'] . '/';

        }
        $infoHotelRoom['total_capacity'] = $total_capacity;
        $infoHotelRoom['maximum_capacity'] = $maximum_capacity;
        $infoHotelRoom['remaining_capacity'] = $remaining_capacity;
        $infoHotelRoom['online_price'] = $online_price;
        $infoHotelRoom['board_price'] = $board_price;
        $infoHotelRoom['hotel_room_prices_id'] = $IdHotelRoomPrice;

        return $infoHotelRoom;


    }




////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////End Reservation///////////////////////////////////////////////

    /*public function insertLogUrlApi($operation){

        error_log($operation  . " \n", 3, LOGS_DIR . 'url_api.txt');

    }*/


}


?>