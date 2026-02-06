<?php

error_reporting(0);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

class BookingHotelNew extends clientAuth
{
    public $payment_date = '';
    public $okHotel = false;
    public $hotel_status = '';
    public $isRequest = '';
    public $type_application = '';
    public $hotel_id = '';
    public $room_id = '';
    public $start_date = '';
    public $end_date = '';
    public $hotelId = '';
    public $room_count = array();
    public $errorMessage = '';
    public $hotelInfo = '';

    public $transactions;

    public function __construct()
    {
        parent::__construct();
        $this->transactions = $this->getModel('transactionsModel');

    }

    public function setPortBankForHotel($bankDir, $factorNumber)
    {
        $initialValues = array(
            'bank_dir' => $bankDir,
            'serviceTitle' => $_POST['serviceType']
        );

        $bankModel = Load::model('bankList');
        $bankInfo = $bankModel->getByBankDir($initialValues);

        $data['name_bank_port'] = $bankDir;
	    $data['number_bank_port'] = $bankInfo['param1'];

        $Model = Load::library('Model');
        $Model->setTable('book_hotel_local_tb');

        $condition = " factor_number='{$factorNumber}'";
	    $res = $Model->update($data, $condition);
        if ($res) {
            $ModelBase = Load::library('ModelBase');
            $ModelBase->setTable('report_hotel_tb');
            $ModelBase->update($data, $condition);
        }
    }

    public function sendUserToBankForHotel($factorNumber)
    {
        $data = array(
            'status' => "bank"
        );

        $condition = " factor_number ='{$factorNumber}' ";
        $Model = Load::library('Model');

        $Model->setTable('book_hotel_local_tb');
        $Model->update($data, $condition);

        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $ModelBase->setTable('report_hotel_tb');
        $ModelBase->update($data, $condition);
    }

    public function updateBank($codRahgiri, $factorNumber)
    {

//        if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//            var_dump('updateBank33333');
//            die;
//        }
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $sql = " SELECT status FROM book_hotel_local_tb 
            WHERE factor_number='{$factorNumber}' ";
        $hotel = $Model->load($sql);
        if ($hotel['status'] == 'bank') {

            $data = array(
                'tracking_code_bank' => "" . $codRahgiri . "",
                'payment_date' => Date('Y-m-d H:i:s')
            );

            $condition = " factor_number='" . $factorNumber . "' AND status = 'bank' ";
            $Model->setTable('book_hotel_local_tb');
            $Model->update($data, $condition);

            $ModelBase->setTable('report_hotel_tb');
            $ModelBase->update($data, $condition);


            $d['PaymentStatus'] = 'success';
            $d['BankTrackingCode'] = $codRahgiri;
            $condition = " FactorNumber='" . $factorNumber . "' ";
            $Model->setTable('transaction_tb');
            $Model->update($d, $condition);

            //for admin panel , transaction table

            $this->transactions->updateTransaction($d,$condition);

        }


    }

    public function HotelBookCredit($factorNumber)
    {


//        if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//            var_dump('HotelBookCredit33333');
//            die;
//         }


        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        /** @var detailHotel $detailHotel */
        /** @var smsServices $smsController */
        /** @var transaction $objTransaction */
        $detailHotel = Load::controller('detailHotel');
        $smsController = Load::controller('smsServices');
        $objTransaction = Load::controller('transaction');
        $this->factor_number = trim($factorNumber);

        /** @var reportHotelModel $report_model */
        $report_model = Load::getModel('reportHotelModel');
	    /** @var bookHotelLocalModel $book_model */
	    $book_model = load::getModel('bookHotelLocalModel');
	    $Hotel = $book_model
		    ->get()
		    ->where('factor_number',$this->factor_number)
		    ->where('status','PreReserve')
		    ->orWhere('status','RequestAccepted')
		    ->groupBy('factor_number')
		    ->find();

//	            $sql        = " SELECT * FROM book_hotel_local_tb WHERE factor_number='{$this->factor_number}' AND status='PreReserve' GROUP BY factor_number ";
//
//	            $Hotel = $Model->load($sql);

	    error_log('try show result method Hotel in : ' . date('Y/m/d H:i:s') . ' HotelDetail => : ' . json_encode($Hotel). " \n", 3, LOGS_DIR . 'log_method_ReserveHotel.txt');
//        error_log('SQL=>'.$sql,3,LOGS_DIR.'log_method_ReserveHotel.txt');
//        error_log('Hotel=>'.$Hotel,3,LOGS_DIR.'log_method_ReserveHotel.txt');

        $this->hotelId = $Hotel['hotel_id'];
        $this->type_application = $Hotel['type_application'];
        $this->hotelInfo = $Hotel;
//	    error_log('tttttttt =>' . $Hotel. " \n", 3, LOGS_DIR . 'log_method_ReserveHotel.txt');


        if ($Hotel['type_application'] == 'api' || $Hotel['type_application'] == 'externalApi' || $Hotel['type_application'] == 'api_app') {

	        /** @var detailHotel $detailHotel */
	        $apiReserveHotel = $detailHotel->Reserve( $Hotel);

            error_log('try show result method Hotel in : ' . date('Y/m/d H:i:s') . ' HotelDetail => : ' . json_encode($Hotel). " \n", 3, LOGS_DIR . 'log_method_ReserveHotel.txt');

            error_log('try show result method Hotel in : ' . date('Y/m/d H:i:s') . ' buy Credit array equal in => : ' . $apiReserveHotel. " \n", 3, LOGS_DIR . 'log_method_ReserveHotel.txt');

            $ReserveHotel = json_decode($apiReserveHotel,true);

            $request_number = $ReserveHotel['RequestNumber'];

	        error_log(' ' . date('Y/m/d H:i:s') . ' RN : ' . $Hotel['request_number']. " \n", 3, LOGS_DIR . 'log_method_ReserveHotel.txt');
            error_log(PHP_EOL . date('Y/m/d H:i:s') ."reserve_hotel_result" .  json_encode($ReserveHotel), 3, LOGS_DIR . 'log_method_ReserveHotel.txt');

//	        echo Load::plog($ReserveHotel);

//	        var_dump($ReserveHotel['Success']);
            if ($ReserveHotel['Success']) {

                error_log(PHP_EOL . date('Y/m/d H:i:s') . "isSuccess ", 3, LOGS_DIR . 'log_method_ReserveHotel.txt');

                $data['payment_date'] = date('Y-m-d H:i:s');
	            if(isset($ReserveHotel['Result']['ManualBook']) && $ReserveHotel['Result']['ManualBook'] == true){
		            $data['manual_book'] = '1';
                    $data['status'] = 'pending';
	            }else{

                    $data['status'] = 'BookedSuccessfully';
                }
	            $data['payment_type'] = 'credit';
	            $data['creation_date_int'] = time();

                $this->hotel_status = $data['status']  ;

                if(Session::IsLogin()){
                    $data_point = [
                        'service'=>'Hotel',
                        'service_title'=>$Hotel['serviceTitle'],
                        'factor_number'=>$this->factor_number,
                        'base_company'=>'all',
                        'company'=>'all',
                        'counter_id'=> Session::getCounterTypeId(),
                        'price'=> $Hotel['total_price'],
                    ];

                    $this->getController('historyPointClub')->setPointMemberIntoTable($data_point);

                }
	            //                $data['voucher_url'] = $ReserveHotel['VoucherUrl'];

	            //	            echo Load::plog($ReserveHotel['Result']['VouchersDetails']);


//	            $sql = "SELECT * FROM book_hotel_local_tb WHERE request_number = '{$request_number}'" ;
//	            /** @var Model $Model */
//	            $books = $Model->select($sql);
//                /** @var bookHotelLocalModel $book_model */
//                $book_model = load::getModel('bookHotelLocalModel');
                $books = $book_model->get()->where('request_number',$request_number)->all();
	            //	            echo Load::plog($books[0]['passenger_national_code']);
                error_log(PHP_EOL . date('Y/m/d H:i:s') . " before foreach VoucherDetails ", 3, LOGS_DIR . 'log_method_ReserveHotel.txt');
	            foreach ($ReserveHotel['Result']['VouchersDetails'] as $key => $VouchersDetail) {
		            $data['voucher_number'] = isset($VouchersDetail['VoucherNumber']) ? $VouchersDetail['VoucherNumber'] : '';
		            $data['pnr'] = isset($ReserveHotel['Result']['PNR']) ? $ReserveHotel['Result']['PNR'] : '';
                    error_log(PHP_EOL . date('Y/m/d H:i:s') . " before books ", 3, LOGS_DIR . 'log_method_ReserveHotel.txt');
                    error_log(PHP_EOL . date('Y/m/d H:i:s') . " books ".json_encode($books,256|64), 3, LOGS_DIR . 'log_method_ReserveHotel.txt');
		            foreach ( $books as $index => $book ) {
			            $condition = "request_number = '{$request_number}' AND factor_number = '{$this->factor_number}' AND  (passenger_national_code = '{$book['passenger_national_code']}' OR passportNumber = '{$book['passportNumber']}')";

//			            $Model->setTable('book_hotel_local_tb');
                        $res = $book_model->update($data,$condition);
                        error_log(PHP_EOL . date('Y/m/d H:i:s') . " UpdateWithBind ".json_encode($res)." ".json_encode($data,256|64), 3, LOGS_DIR . 'log_method_ReserveHotel.txt');
//		                $res = $Model->update($data, $condition);
		                if ($res) {
                            error_log(PHP_EOL . date('Y/m/d H:i:s') . " res is true ", 3, LOGS_DIR . 'log_method_ReserveHotel.txt');
                            $res2 = $report_model->update($data,$condition);
                            error_log(PHP_EOL . date('Y/m/d H:i:s') . " res2 is ".json_encode($res2), 3, LOGS_DIR . 'log_method_ReserveHotel.txt');
			                $this->okHotel = true;
			                $this->payment_date = $data['payment_date'];
                            error_log(PHP_EOL . date('Y/m/d H:i:s') . " okHotel is true ", 3, LOGS_DIR . 'log_method_ReserveHotel.txt');
		                }else{
                            error_log(PHP_EOL . date('Y/m/d H:i:s') . " okHotel is false ", 3, LOGS_DIR . 'log_method_ReserveHotel.txt');
                            $this->okHotel = false;
                        }
	                }
                }
                error_log(PHP_EOL . date('Y/m/d H:i:s') . " before CalculateProfitClient ", 3, LOGS_DIR . 'log_method_ReserveHotel.txt');
                $objTransaction->calculateProfitClient($books[0],'Hotel');
                //todo: we have commented above function, we should work on it to be fixed
                error_log(PHP_EOL . date('Y/m/d H:i:s') . " before objSms->initService ", 3, LOGS_DIR . 'log_method_ReserveHotel.txt');
                $objSms = $smsController->initService('1');
                //sms to our supports
                if ($objSms) {
                    if (functions::CalculateChargeAdminAgency(CLIENT_ID) < 10000000) {
                        //sms to site manager

                        if ($objSms) {
                            $sms = "مدیریت محترم آژانس" . " " . CLIENT_NAME . PHP_EOL . " شارژحساب کاربری شما در نرم افزار سفر 360 به کمتر از 10,000,000 ریال رسیده است";
                            $smsArray = array(
                                'smsMessage' => $sms,
                                'cellNumber' => CLIENT_MOBILE
                            );
                            $smsController->sendSMS($smsArray);
                        }
                    }
                    $sms = " رزرو هتل، شماره رزرو: {$factorNumber} - " . CLIENT_NAME;
                    $cellArray = array(
                        'fanipor' => '09129409530',
                        'afraze' => '09916211232',
                        'abasi2' => '09057078341',
                        'amirabbas' => '09057078341'

                    );
                    foreach ($cellArray as $cellNumber) {
                        $smsArray = array(
                            'smsMessage' => $sms,
                            'cellNumber' => $cellNumber
                        );
                        $smsController->sendSMS($smsArray);
                    }
                }
                error_log(PHP_EOL . date('Y/m/d H:i:s') . " before emailHotelSelf ", 3, LOGS_DIR . 'log_method_ReserveHotel.txt');
                //email to buyer
                $this->emailHotelSelf($factorNumber);

                error_log(PHP_EOL . date('Y/m/d H:i:s') . " before smsController->initService ", 3, LOGS_DIR . 'log_method_ReserveHotel.txt');
                //sms to buyer
                $objSms = $smsController->initService('0');
                if($this->hotel_status == 'BookedSuccessfully') {
                    if ($objSms) {
                        if (!empty($Hotel['member_mobile'])) {
                            $mobile = $Hotel['member_mobile'];
                            $name = $Hotel['member_name'];
                        } else {
                            $mobile = $Hotel['passenger_leader_room'];
                            $name = $Hotel['passenger_leader_room_fullName'];
                        }
                        $messageVariables = array(
                            'sms_name' => $name,
                            'sms_service' => 'هتل',
                            'sms_factor_number' => $Hotel['factor_number'],
                            'sms_cost' => $Hotel['total_price'],
                            'sms_destination' => $Hotel['city_name'],
                            'sms_hotel_name' => $Hotel['hotel_name'],
                            'sms_hotel_in' => $Hotel['start_date'],
                            'sms_hotel_out' => $Hotel['end_date'],
                            'sms_hotel_night' => $Hotel['number_night'],
                            'sms_pdf' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=BookingHotelLocal&id=" . $Hotel['factor_number'],
                            'sms_pdf_en' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=bookhotelshow&id=" . $Hotel['factor_number'],
                            'sms_agency' => CLIENT_NAME,
                            'sms_agency_mobile' => CLIENT_MOBILE,
                            'sms_agency_phone' => CLIENT_PHONE,
                            'sms_agency_email' => CLIENT_EMAIL,
                            'sms_agency_address' => CLIENT_ADDRESS,
                        );
                        error_log(PHP_EOL . date('Y/m/d H:i:s') . " before smsArray ", 3, LOGS_DIR . 'log_method_ReserveHotel.txt');
                        $confirm_on_request_hotel_pattern =   $smsController->getPattern('confirm_on_request_hotel');
                        if($confirm_on_request_hotel_pattern) {
                            $smsController->smsByPattern($confirm_on_request_hotel_pattern['pattern'], array($mobile), array('customer_name' => CLIENT_NAME , 'factor_number' => $res['factor_number']));
                        }else {
                            $smsArray = array(
                                'smsMessage' => $smsController->getUsableMessage('afterHotelReserve', $messageVariables),
                                'cellNumber' => $mobile,
                                'smsMessageTitle' => 'afterHotelReserve',
                                'memberID' => (!empty($Hotel['member_id']) ? $Hotel['member_id'] : ''),
                                'receiverName' => $messageVariables['sms_name'],
                            );
                            error_log(PHP_EOL . date('Y/m/d H:i:s') . "smsArray " . json_encode($smsArray, 256 | 64), 3, LOGS_DIR . 'log_method_ReserveHotel.txt');
                            $sms_result = $smsController->sendSMS($smsArray);
                        }
                        error_log(PHP_EOL . date('Y/m/d H:i:s') . "smsArray ".json_encode($sms_result,256|64), 3, LOGS_DIR . 'log_method_ReserveHotel.txt');

                    }
                }

            }
            else {

//	            error_log(' ' . date('Y/m/d H:i:s') . ' RN : ' . $Hotel['request_number']. " Success : {$ReserveHotel['Success']} RES : {$ReserveHotel['Result']} \n", 3, LOGS_DIR . 'log_method_ReserveHotel.txt');
                functions::insertLog(' RN : ' . $Hotel['request_number']. ' Success : '.$ReserveHotel['Success'].' RES : '.json_encode($ReserveHotel).' - ','log_method_ReserveHotel');

                if(isset($ReserveHotel['Result']['Error']) && $ReserveHotel['Result']['Error']['Code'] == 'BK-417') {
                    $this->errorMessage = 'درخواست شما در حال پردازش است.';
                    $data['status'] = 'OnRequest';
                    $this->isRequest = 'OnRequest';
                }else {
                    $this->errorMessage = 'اشکالی در فرآیند رزرو هتل پیش آمده است، لطفا برای پیگیری رزرو هتل و یا برگرداندن اعتبار  خود با پشتیبانی تماس حاصل نمائید';
                    $data['status'] = 'credit';
                    $data['payment_type'] = 'credit';

                    $transaction =  Load::controller('transaction');
                    $transaction->pendingTransactionCurrent($this->factor_number);
                    $transaction->deleteCreditAgencyCurrent($this->factor_number);
                }

                $data['creation_date_int'] = time();

                $condition = " factor_number='{$factorNumber}' AND request_number = '{$Hotel['request_number']}' ";
//                $Model->setTable('book_hotel_local_tb');
                $res = $book_model->updateWithBind($data,$condition);
//                $res = $Model->update($data, $condition);

                if ($res) {
//                    $ModelBase->setTable('report_hotel_tb');
//                    $ModelBase->update($data, $condition);
                    $res2 = $report_model->updateWithBind($data,$condition);
                }

            }

        }
        else if ($Hotel['type_application'] == 'reservation' || $Hotel['type_application'] == 'reservation_app') {

            if ($Hotel['member_id']) {
                $user_type = functions::getCounterTypeId($Hotel['member_id']);
            } else {
                $user_type = '5';
            }
            $result = $this->ReduceCapacity($user_type, $this->factor_number, 'Increase'); /// reduce capacity
            if ($result == 'success') {
                do {
                    $code = $this->generateRandomPnr();
                    $code_params = [
                        'type'          => 'tracking_code',
                        'code'          => $code
                    ];

                } while ($this->isCodeUnique($code_params)); // Repeat until a unique code is found
                $data['status'] = 'BookedSuccessfully';
                $data['pnr'] = $code;
                $data['payment_date'] = Date('Y-m-d H:i:s');
                $data['payment_type'] = 'credit';
                $data['creation_date_int'] = time();

                $condition = " factor_number='{$factorNumber}' ";
//                $Model->setTable('book_hotel_local_tb');
//                $res = $Model->update($data, $condition);
                $res = $book_model->updateWithBind($data,$condition);

                if ($res) {

                    $res2 = $report_model->updateWithBind($data,$condition);

                    $this->okHotel = true;
                    $this->payment_date = $data['payment_date'];

                    //email to buyer
                    $this->emailHotelSelf($factorNumber);

                    //sms to buyer
                    $objSms = $smsController->initService('0');
                    if ($objSms) {
                        if (!empty($Hotel['member_mobile'])) {
                            $mobile = $Hotel['member_mobile'];
                            $name = $Hotel['member_name'];
                        } else {
                            $mobile = $Hotel['passenger_leader_room'];
                            $name = $Hotel['passenger_leader_room_fullName'];
                        }
                        //to member
                        $messageVariables = array(
                            'sms_name' => $name,
                            'sms_service' => 'هتل',
                            'sms_factor_number' => $Hotel['factor_number'],
                            'sms_cost' => $Hotel['total_price'],
                            'sms_destination' => $Hotel['city_name'],
                            'sms_hotel_name' => $Hotel['hotel_name'],
                            'sms_hotel_in' => $Hotel['start_date'],
                            'sms_hotel_out' => $Hotel['end_date'],
                            'sms_hotel_night' => $Hotel['number_night'],
                            'sms_pdf' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=BookingHotelLocal&id=" . $Hotel['factor_number'],
                            'sms_pdf_en' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=bookhotelshow&id=" . $Hotel['factor_number'],
                            'sms_agency' => CLIENT_NAME,
                            'sms_agency_mobile' => CLIENT_MOBILE,
                            'sms_agency_phone' => CLIENT_PHONE,
                            'sms_agency_email' => CLIENT_EMAIL,
                            'sms_agency_address' => CLIENT_ADDRESS,
                        );
                        $hotel_reserve_pattern  =   $smsController->getPattern('hotel_reserve_payment_pattern_sms');
                        if($hotel_reserve_pattern) {
                            $smsController->smsByPattern($hotel_reserve_pattern['pattern'], array($mobile),$messageVariables);
                        }else {
                            $smsArray = array(
                                'smsMessage' => $smsController->getUsableMessage('afterHotelReserve', $messageVariables),
                                'cellNumber' => $mobile,
                                'smsMessageTitle' => 'afterHotelReserve',
                                'memberID' => (!empty($Hotel['member_id']) ? $Hotel['member_id'] : ''),
                                'receiverName' => $messageVariables['sms_name'],
                            );
                            $smsController->sendSMS($smsArray);
                        }
                        $hotel_reserve_pattern  =   $smsController->getPattern('hotel_reserve_payment_manager_pattern_sms');
                        if($hotel_reserve_pattern) {
                            $smsController->smsByPattern($hotel_reserve_pattern['pattern'], array(CLIENT_MOBILE),$messageVariables);
                        }else {
                            //to site manager
                            $smsArray = array(
                                'smsMessage' => $smsController->getUsableMessage('afterHotelReserveToManager', $messageVariables),
                                'cellNumber' => CLIENT_MOBILE,
                                'smsMessageTitle' => 'afterHotelReserve',
                                'memberID' => (!empty($Hotel['member_id']) ? $Hotel['member_id'] : ''),
                                'receiverName' => $messageVariables['sms_name'],
                            );
                            $smsController->sendSMS($smsArray);
                        }
                    }
                }

            }

        } else {
            $this->errorMessage = 'نرم افزاری برای بررسی اطلاعات رزرو وجود ندارد. لطفا با پشتیبانی تماس بگیرید.';
        }


    }

    public function HotelBook($factorNumber)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        /** @var reportHotelModel $report_model */
        $report_model = Load::getModel('reportHotelModel');
        /** @var bookHotelLocalModel $book_model */
        $book_model = load::getModel('bookHotelLocalModel');

        $objTransaction = Load::controller('transaction');
        $apiHotelLocal = Load::library('apiHotelLocal');
        $smsController = Load::controller('smsServices');

        $detailHotel = Load::controller('detailHotel');

        $this->factor_number = trim($factorNumber);
//
//         $sql = "SELECT * FROM book_hotel_local_tb
//            WHERE factor_number='{$this->factor_number}' AND status = 'bank' AND tracking_code_bank !=''
//            GROUP BY factor_number";
//
//
//	    /** @var Model $Model */
//	    $Hotel = $Model->load($sql,'assoc');
        $Hotel = $book_model->get()->where('factor_number',$this->factor_number)->where('status','bank')->where('tracking_code_bank','','!=')->groupBy('factor_number')->find();
        $this->hotelId = $Hotel['hotel_id'];
        $this->type_application = $Hotel['type_application'];
        $this->payment_status = $Hotel['payment_status'];
        $this->hotelInfo = $Hotel;
        functions::insertLog(json_encode($Hotel,256|64).PHP_EOL.' RN : '.$Hotel['request_number'],'log_method_ReserveHotel');

        #region [api or reservation]
        if ($Hotel['type_application'] == 'api' || $Hotel['type_application'] == 'externalApi' || $Hotel['type_application'] == 'api_app') {
	        /** @var detailHotel $detailHotel */
	        $ReserveHotel = json_decode( $detailHotel->Reserve( $Hotel ),true);

	        functions::insertLog(json_encode($Hotel,256|64).PHP_EOL.' RN : '.$Hotel['request_number'],'log_method_ReserveHotel');
	        functions::insertLog(json_encode($ReserveHotel,256|64).PHP_EOL.' RN : '.$Hotel['request_number'],'log_method_ReserveHotel');

//            error_log('try show result method Hotel in : ' . date('Y/m/d H:i:s') . ' buy Cash array eqaul in => : ' . json_encode($ReserveHotel, true) . " \n", 3, LOGS_DIR . 'log_method_ReserveHotel.txt');

            if ($ReserveHotel['Success'] == true && $ReserveHotel['StatusCode'] == '200') {

                $request_number = $Hotel['request_number'];
//                $sql = "SELECT * FROM book_hotel_local_tb WHERE request_number = '{$request_number}'" ;
//                /** @var Model $Model */
//                $books = $Model->select($sql);
                $books = $book_model->get()->where('request_number',$request_number)->all();
                // Caution: آپدیت تراکنش به موفق
                $objTransaction->setCreditToSuccess($this->factor_number, $Hotel['tracking_code_bank']);
	            if(isset($ReserveHotel['Result']['ManualBook']) && $ReserveHotel['Result']['ManualBook'] == true){
		            $data['manual_book'] = '1';
	            }


                $data['status'] = 'BookedSuccessfully';
                $data['payment_date'] = date('Y-m-d H:i:s');
                if ($Hotel['tracking_code_bank'] == 'member_credit') {
                    $data['payment_type'] = 'member_credit';
                    $data['tracking_code_bank'] = '';
                } else {
                    $data['payment_type'] = 'cash';
                }
                $data['creation_date_int'] = time();
                $data['voucher_url'] = $ReserveHotel['Result']['VoucherUrl'];


                if(Session::IsLogin()){
                    $data_point = [
                        'service'=>'Hotel',
                        'service_title'=>$Hotel['serviceTitle'],
                        'factor_number'=>$this->factor_number,
                        'base_company'=>'all',
                        'company'=>'all',
                        'counter_id'=> Session::getCounterTypeId(),
                        'price'=> $Hotel['total_price'],
                    ];

                    $this->getController('historyPointClub')->setPointMemberIntoTable($data_point);

                }
	            foreach ($ReserveHotel['Result']['VouchersDetails'] as $key => $VouchersDetail) {
		            $data['voucher_number'] = $VouchersDetail['VoucherNumber'];
		            $data['pnr'] = $ReserveHotel['Result']['PNR'];

		            foreach ( $books as $index => $book ) {
			            $condition = "request_number = '{$request_number}' AND factor_number = '{$factorNumber}' AND  (passenger_national_code = '{$book['passenger_national_code']}' OR passportNumber = '{$book['passportNumber']}')";

//			            $Model->setTable('book_hotel_local_tb');
//			            $res = $Model->update($data, $condition);
                        $res = $book_model->updateWithBind($data,$condition);
			            if ($res) {
                            $res2 = $report_model->updateWithBind($data,$condition);
//				            $ModelBase->setTable('report_hotel_tb');
//				            $ModelBase->update($data, $condition);
				            $this->okHotel = true;
				            $this->payment_date = $data['payment_date'];

			            }
		            }

	            }

                if(functions::checkClientConfigurationAccess('call_back')) {
                    $call_back_api =$this->getController('callBackUrl');
                    $call_back_api->sendBookedData($books , 'hotel') ;
                }

                $objTransaction->calculateProfitClient($books[0],'Hotel');
                if (functions::CalculateChargeAdminAgency(CLIENT_ID) < 10000000) {
                    //sms to site manager
                    $objSms = $smsController->initService('1');
                    if ($objSms) {
                        $sms = "مدیریت محترم آژانس" . " " . CLIENT_NAME . PHP_EOL . " شارژ حساب کاربری شما در نرم افزار سفر 360 به کمتر از 10,000,000 ریال رسیده است";
                        $smsArray = array(
                            'smsMessage' => $sms,
                            'cellNumber' => CLIENT_MOBILE
                        );
                        $smsController->sendSMS($smsArray);
                    }
                }

                //sms to our supports
                $objSms = $smsController->initService('1');
                if ($objSms) {
                    $sms = " رزرو هتل، شماره رزرو: {$factorNumber} - " . CLIENT_NAME;
                    $cellArray = array(
                        'amirabbas' => '09057078341'
                    );
                    foreach ($cellArray as $cellNumber) {
                        $smsArray = array(
                            'smsMessage' => $sms,
                            'cellNumber' => $cellNumber
                        );
                        $smsController->sendSMS($smsArray);
                    }
                }

                //email to buyer
                $this->emailHotelSelf($factorNumber);

                //sms to buyer
                $objSms = $smsController->initService('0');
                if ($objSms) {
                    if (!empty($Hotel['member_mobile'])) {
                        $mobile = $Hotel['member_mobile'];
                        $name = $Hotel['member_name'];
                    } else {
                        $mobile = $Hotel['passenger_leader_room'];
                        $name = $Hotel['passenger_leader_room_fullName'];
                    }
                    $messageVariables = array(
                        'sms_name' => $name,
                        'sms_service' => 'هتل',
                        'sms_factor_number' => $Hotel['factor_number'],
                        'sms_cost' => $Hotel['total_price'],
                        'sms_destination' => $Hotel['city_name'],
                        'sms_hotel_name' => $Hotel['hotel_name'],
                        'sms_hotel_in' => $Hotel['start_date'],
                        'sms_hotel_out' => $Hotel['end_date'],
                        'sms_hotel_night' => $Hotel['number_night'],
                        'sms_pdf' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=BookingHotelLocal&id=" . $Hotel['factor_number'],
                        'sms_pdf_en' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=bookhotelshow&id=" . $Hotel['factor_number'],
                        'sms_agency' => CLIENT_NAME,
                        'sms_agency_mobile' => CLIENT_MOBILE,
                        'sms_agency_phone' => CLIENT_PHONE,
                        'sms_agency_email' => CLIENT_EMAIL,
                        'sms_agency_address' => CLIENT_ADDRESS,
                    );
                    $smsArray = array(
                        'smsMessage' => $smsController->getUsableMessage('afterHotelReserve', $messageVariables),
                        'cellNumber' => $mobile,
                        'smsMessageTitle' => 'afterHotelReserve',
                        'memberID' => (!empty($Hotel['member_id']) ? $Hotel['member_id'] : ''),
                        'receiverName' => $messageVariables['sms_name'],
                    );
                    $smsController->sendSMS($smsArray);
                }

            } else if ($ReserveHotel['StatusCode'] == '406') {
                $this->errorMessage = 'این هتل قبلا توسط شما رزرو شده است، لطفا برای پیگیری رزرو هتل خود با پشتیبانی تماس حاصل نمائید';


            } else if ($ReserveHotel['StatusCode'] == '422' || $ReserveHotel['Success'] == false) {
                if(isset($ReserveHotel['Result']['Error']) && $ReserveHotel['Result']['Error']['Code'] == 'BK-417') {
                    $this->errorMessage = 'درخواست شما در حال پردازش است.';
                    $data['status'] = 'OnRequest';
                    $this->isRequest = 'OnRequest';
                }else {
                    $this->errorMessage = 'اشکالی در فرآیند رزرو هتل پیش آمده است، لطفا برای پیگیری رزرو هتل و یا برگرداندن اعتبار  خود با پشتیبانی تماس حاصل نمائید';
                    $data['status'] = 'credit';
                    $data['payment_type'] = 'cash';
                }

                $data['creation_date_int'] = time();

                $condition = " factor_number='{$factorNumber}' ";
//                $Model->setTable('book_hotel_local_tb');
//                $res = $Model->update($data, $condition);
                $res = $book_model->updateWithBind($data,$condition);
                if ($res) {
                    $res2 = $report_model->updateWithBind($data,$condition);
//                    $ModelBase->setTable('report_hotel_tb');
//                    $ModelBase->update($data, $condition);
                }

            }

        }
        else if ($Hotel['type_application'] == 'reservation' || $Hotel['type_application'] == 'reservation_app') {


//            $sql = " SELECT status FROM book_hotel_local_tb WHERE factor_number='{$factorNumber}' ";
//            $hotel = $Model->load($sql);
            $hotel = $book_model->get('status')->where('factor_number',$factorNumber)->find();

            if ($hotel['status'] == 'BookedSuccessfully') {
                $this->okHotel = true;

            } else {


                if ($Hotel['member_id']) {
                    $user_type = functions::getCounterTypeId($Hotel['member_id']);
                } else {
                    $user_type = '5';
                }
                $result = $this->ReduceCapacity($user_type, $this->factor_number, 'Increase'); /// reduce capacity
                if ($result == 'success') {
                    do {
                        $code = $this->generateRandomPnr();
                        $code_params = [
                            'type'          => 'tracking_code',
                            'code'          => $code
                        ];

                    } while ($this->isCodeUnique($code_params)); // Repeat until a unique code is found
//                    if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//
//                        $infoBook = functions::GetInfoHotel($factorNumber);
//                        var_dump($infoBook);
//                        echo"<br>";
//                        echo"<br>";
//                        echo"<br>";
//                        var_dump('4454554524');
//                        die;
//                    }

                    $data['pnr'] = $code;

//                    $data['status'] = 'BookedSuccessfully';

                    $infoBook = functions::GetInfoHotel($factorNumber);
                    if (empty($infoBook['payment_status'])) {

                        $data['status'] = 'BookedSuccessfully';
                    }elseif ($infoBook['payment_status'] == 'prePayment') {


                        $prePaymentStatus= 'Requested';


                        $data['status'] = $prePaymentStatus;

                    }
                    elseif ($infoBook['payment_status'] == 'fullPayment') {
                        $this->status = 'BookedSuccessfully';
                        $data['status'] = 'BookedSuccessfully';

                    }



                    $data['payment_date'] = Date('Y-m-d H:i:s');
                    $data['payment_type'] = 'Cash';
                    $data['creation_date_int'] = time();

                    $condition = " factor_number='{$factorNumber}' ";
//                    $Model->setTable('book_hotel_local_tb');
                    $res = $book_model->updateWithBind($data, $condition);

                    if ($res) {

//                        $ModelBase->setTable('report_hotel_tb');
                        $res2 = $report_model->updateWithBind($data, $condition);
                        $this->okHotel = true;
                        $this->payment_date = $data['payment_date'];

                        //email to buyer
                        $this->emailHotelSelf($factorNumber);

                        //sms to buyer
                        $objSms = $smsController->initService('0');
                        if ($objSms) {
                            if (!empty($Hotel['member_mobile'])) {
                                $mobile = $Hotel['member_mobile'];
                                $name = $Hotel['member_name'];
                            } else {
                                $mobile = $Hotel['passenger_leader_room'];
                                $name = $Hotel['passenger_leader_room_fullName'];
                            }
                            //to member
                            $messageVariables = array(
                                'sms_name' => $name,
                                'sms_service' => 'هتل',
                                'sms_factor_number' => $Hotel['factor_number'],
                                'sms_cost' => $Hotel['total_price'],
                                'sms_destination' => $Hotel['city_name'],
                                'sms_hotel_name' => $Hotel['hotel_name'],
                                'sms_hotel_in' => $Hotel['start_date'],
                                'sms_hotel_out' => $Hotel['end_date'],
                                'sms_hotel_night' => $Hotel['number_night'],
                                'sms_pdf' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=BookingHotelLocal&id=" . $Hotel['factor_number'],
                                'sms_pdf_en' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=bookhotelshow&id=" . $Hotel['factor_number'],
                                'sms_agency' => CLIENT_NAME,
                                'sms_agency_mobile' => CLIENT_MOBILE,
                                'sms_agency_phone' => CLIENT_PHONE,
                                'sms_agency_email' => CLIENT_EMAIL,
                                'sms_agency_address' => CLIENT_ADDRESS,
                            );

                            if ($infoBook['payment_status'] == 'prePayment') {
                            $smsArray = array(
                                'smsMessage' => $smsController->getUsableMessage('afterHotelPreReservePayment', $messageVariables),
                                'cellNumber' => $mobile,
                                'smsMessageTitle' => 'afterHotelPreReservePayment',
                                'memberID' => (!empty($Hotel['member_id']) ? $Hotel['member_id'] : ''),
                                'receiverName' => $messageVariables['sms_name'],
                            );

                             }else{
                                $smsArray = array(
                                    'smsMessage' => $smsController->getUsableMessage('afterHotelReserve', $messageVariables),
                                    'cellNumber' => $mobile,
                                    'smsMessageTitle' => 'afterHotelReserve',
                                    'memberID' => (!empty($Hotel['member_id']) ? $Hotel['member_id'] : ''),
                                    'receiverName' => $messageVariables['sms_name'],
                                );
                            }
                            $smsController->sendSMS($smsArray);

                            //to site manager
                            $smsArray = array(
                                'smsMessage' => $smsController->getUsableMessage('afterHotelReserveToManager', $messageVariables),
                                'cellNumber' => CLIENT_MOBILE,
                                'smsMessageTitle' => 'afterHotelReserve',
                                'memberID' => (!empty($Hotel['member_id']) ? $Hotel['member_id'] : ''),
                                'receiverName' => $messageVariables['sms_name'],
                            );
                            $smsController->sendSMS($smsArray);
                        }
                    }

                }

            }


        } else {
            $this->errorMessage = 'نرم افزاری برای بررسی اطلاعات رزرو وجود ندارد. لطفا با پشتیبانی تماس بگیرید.';
        }
        #endregion

    }

    public function externalApiReserve($param, $paymentType)
    {

        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $apiExternalHotel = Load::controller('resultExternalHotel');
        $objTransaction = Load::controller('transaction');
        $smsController = Load::controller('smsServices');

        $resultHotel = $apiExternalHotel->hotelReserve($this->factor_number);
        functions::insertLog($this->factor_number . ' => : ' . json_encode($resultHotel, true), 'reserveExternalHotel');
        if (!empty($resultHotel) && $resultHotel['Status'] == 'error') {

            $this->errorMessage = 'اشکالی در فرآیند رزرو هتل پیش آمده است، لطفا برای پیگیری رزرو هتل و یا برگرداندن اعتبار  خود با پشتیبانی تماس حاصل نمائید';

            $data['status'] = 'credit';
            $data['payment_type'] = $paymentType;
            $data['creation_date_int'] = time();

            $condition = " factor_number='{$this->factor_number}' ";
            $Model->setTable('book_hotel_local_tb');
            $res = $Model->update($data, $condition);

            if ($res) {
                $ModelBase->setTable('report_hotel_tb');
                $ModelBase->update($data, $condition);
            }

        } elseif (!empty($resultHotel) && $resultHotel['Status'] == 'success') {


            // Caution: آپدیت تراکنش به موفق
            $objTransaction->setCreditToSuccess($this->factor_number, $param['tracking_code_bank']);

            $bookArray = json_decode($resultHotel['MemberSellList'][0]['BookingArray'], true);
            $data['status'] = 'BookedSuccessfully';
            $data['payment_date'] = Date('Y-m-d H:i:s');
            $data['creation_date_int'] = time();
            $data['booking_array'] = json_encode($resultHotel['MemberSellList']);
            $data['request_number'] = $bookArray['FNPPNRCode'];
            $data['pnr'] = $bookArray['FNPOrderID'];

            if ($paymentType == 'cash') {
                if ($param['tracking_code_bank'] == 'member_credit') {
                    $data['payment_type'] = 'member_credit';
                    $data['tracking_code_bank'] = '';
                } else {
                    $data['payment_type'] = 'cash';
                }
            } else if ($paymentType == 'credit') {
                $data['payment_type'] = 'credit';
            }

            $condition = " factor_number='{$this->factor_number}' ";
            $Model->setTable('book_hotel_local_tb');
            $res = $Model->update($data, $condition);

            if ($res) {

                $ModelBase->setTable('report_hotel_tb');
                $ModelBase->update($data, $condition);
                $this->okHotel = true;
                $this->payment_date = $data['payment_date'];


                if (functions::CalculateChargeAdminAgency(CLIENT_ID) < 10000000) {
                    //sms to site manager
                    $objSms = $smsController->initService('1');
                    if ($objSms) {
                        $sms = "مدیریت محترم آژانس" . " " . CLIENT_NAME . PHP_EOL . " شارژ حساب کاربری شما در نرم افزار سفر 360 به کمتر از 10,000,000 ریال رسیده است";
                        $smsArray = array(
                            'smsMessage' => $sms,
                            'cellNumber' => CLIENT_MOBILE
                        );
                        $smsController->sendSMS($smsArray);
                    }
                }

                //sms to our supports
                $objSms = $smsController->initService('1');
                if ($objSms) {
                    $sms = " رزرو هتل، شماره رزرو: {$this->factor_number} - " . CLIENT_NAME;
                    $cellArray = array(
                        'afshar' => '09057078341'
                    );
                    foreach ($cellArray as $cellNumber) {
                        $smsArray = array(
                            'smsMessage' => $sms,
                            'cellNumber' => $cellNumber
                        );
                        $smsController->sendSMS($smsArray);
                    }
                }

                //email to buyer
                $this->emailHotelSelf($this->factor_number);


                $sql = " SELECT * FROM book_hotel_local_tb WHERE factor_number='{$this->factor_number}' ";
                $hotelReserves = $Model->load($sql, 'assoc');

                //sms to buyer
                $objSms = $smsController->initService('0');
                if ($objSms) {
                    if (!empty($hotelReserves['member_mobile'])) {
                        $mobile = $hotelReserves['member_mobile'];
                        $name = $hotelReserves['member_name'];
                    } else {
                        $mobile = $hotelReserves['passenger_leader_room'];
                        $name = $hotelReserves['passenger_leader_room_fullName'];
                    }
                    $messageVariables = array(
                        'sms_name' => $name,
                        'sms_service' => 'هتل',
                        'sms_factor_number' => $hotelReserves['factor_number'],
                        'sms_cost' => $hotelReserves['total_price'],
                        'sms_destination' => $hotelReserves['city_name'],
                        'sms_hotel_name' => $hotelReserves['hotel_name'],
                        'sms_hotel_in' => $hotelReserves['start_date'],
                        'sms_hotel_out' => $hotelReserves['end_date'],
                        'sms_hotel_night' => $hotelReserves['number_night'],
                        'sms_pdf' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=BookingHotelLocal&id=" . $hotelReserves['factor_number'],
                        'sms_pdf_en' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=bookhotelshow&id=" . $hotelReserves['factor_number'],
                        'sms_agency' => CLIENT_NAME,
                        'sms_agency_mobile' => CLIENT_MOBILE,
                        'sms_agency_phone' => CLIENT_PHONE,
                        'sms_agency_email' => CLIENT_EMAIL,
                        'sms_agency_address' => CLIENT_ADDRESS,
                    );
                    $smsArray = array(
                        'smsMessage' => $smsController->getUsableMessage('afterHotelReserve', $messageVariables),
                        'cellNumber' => $mobile,
                        'smsMessageTitle' => 'afterHotelReserve',
                        'memberID' => (!empty($hotelReserves['member_id']) ? $hotelReserves['member_id'] : ''),
                        'receiverName' => $messageVariables['sms_name'],
                    );
                    $smsController->sendSMS($smsArray);
                }

            }

        }

    }

    public function delete_transaction_current($factorNumber)
    {
        if (!$this->checkBookStatus($factorNumber)) {
            $Model = Load::library('Model');
            $data['PaymentStatus'] = 'pending';
            $condition = "FactorNumber = '{$factorNumber}' AND FactorNumber !=''";
            $Model->setTable('transaction_tb');
            $Model->update($data, $condition);

            //for admin panel , transaction table

            $this->transactions->updateTransaction($data, $condition);

        }
    }

    public function checkBookStatus($factorNumber)
    {
        $result = $this->getModel('bookHotelLocalModel')->get('status')->where('factor_number',$factorNumber)->find();
        return $result['status'] == 'BookedSuccessfully';
    }

    public function emailHotelSelf($factor_number)
    {
//        $Model = Load::library('Model');
//        $sql = " SELECT * FROM book_hotel_local_tb WHERE factor_number='{$factor_number}'";
//        $res_model = $Model->load($sql);
        $res_model = $this->getModel('bookHotelLocalModel')->get()->where('factor_number',$factor_number)->find();
        if (!empty($res_model) && !empty($res_model['member_email'])) {

            $emailBody = 'با سلام' . '<br>';
            $emailBody .= 'دوست عزیز؛ از اینکه خدمات ما را انتخاب نموده اید سپاسگزاریم' . '<br>';
            $emailBody .= 'لطفا جهت مشاهده و چاپ واچر هتل بر روی دکمه چاپ واچر هتل که در قسمت پایین قرار دارد کلیک نمایید' . '<br>';

            $param['title'] = 'رزرو هتل ' . $res_model['hotel_name'] . ' - ' . $res_model['city_name'];
            $param['body'] = $emailBody;
            $param['pdf'][0]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=BookingHotelLocal&id=' . $factor_number;
            $param['pdf'][0]['button_title'] = 'چاپ واچر رزرو هتل';


            $to = $res_model['member_email'];
            $subject = "رزرو هتل";
            $message = functions::emailTemplate($param);

            $headers = "From: noreply@" . CLIENT_DOMAIN . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8";
            ini_set('SMTP', 'smtphost');
            ini_set('smtp_port', 25);
            //todo: uncomment email function
            functions::insertLog(json_encode([$to,$subject,$message,$headers]),'HOTELLOG');
//            mail($to, $subject, $message, $headers);
        }
    }

    public function set_time_payment($date)
    {

        $date_orginal_exploded = explode(' ', $date);
        return $date_orginal_exploded[1];
    }

    public function set_date_reserve($date)
    {
        $date_orginal_exploded = explode(' ', $date);
        $date_miladi_exp = explode('-', $date_orginal_exploded[0]);
        return dateTimeSetting::gregorian_to_jalali($date_miladi_exp[0], $date_miladi_exp[1], $date_miladi_exp[2], '/');
    }

    public function formatTime($time)
    {
        $time1 = substr($time, '0', '2');
        $time2 = substr($time, '2', '4');
        $subject = array('H', 'M');
        $time2 = str_replace($subject, ':', $time2);
        return $time1 . $time2;
    }

    public function format_hour($num)
    {
        $time = date("H:i", strtotime($num));
        return $time;
    }

    public function createPdfContent($factorNumber, $cash, $cancelStatus)
    {
        $Model = Load::library('Model');
        $tableName = 'book_hotel_local_tb';
        $info_hotel = $this->getModel('bookHotelLocalModel')->get()->where('factor_number',$factorNumber);
        if (TYPE_ADMIN == '1') {
            $Model = Load::library('ModelBase');
            $tableName = 'report_hotel_tb';
            $info_hotel = $this->getModel('reportHotelModel')->get()->where('factor_number',$factorNumber);
        }

        if (isset($cancelStatus) && $cancelStatus != '') {
            $info_hotel = $info_hotel->where('status','canceled');
        }
        $info_hotel = $info_hotel->all();

        if (empty($info_hotel)) {
            return '<div style="text-align:center; font-size:20px; font-family: yekanbakh;">اطلاعات مورد نظر موجود نمی باشد</div>';
        }

        // شروع HTML
        $html = '<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>واچر هتل</title>
    <style>
      
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "yekanbakh" !important;
        }

        body {
            font-family: "yekanbakh" !important;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            margin-bottom: 40mm;
        }
        
        .container {
//            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            padding-bottom: 60px;
        }

        /* Header */
        .header {
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #ccc;
            padding-bottom: 15px;
        }

        .header table {
            width: 100%;
            border: none;
            margin: 0;
        }

        .header table td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }

        .header-logo {
            width: 50%;
            text-align: right;
        }

        .header-logo img {
            max-width: 80px;
            min-height: 50px;
        }

        .header-barcode {
            width: 50%;
            text-align: left;
        }
        
        .header-voucher {
            display: table-cell;
            width: 150px;
            vertical-align: middle;
            text-align: left;
        }
        
        .voucher-badge {
            background: #f44336;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
        }
        
        /* Hotel Info Section */
        .hotel-info-section {
            background: #fff;
            border: 2px solid #ccc;
            border-radius: 8px;
            padding: 2px;
            margin: 20px !important;
        }
        
        .hotel-header {
            display: table;
            width: 100%;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ccc;
        }

        .hotel-icon {
            display: table-cell;
            width: 35px;
            text-align: center;
            vertical-align: middle;
            padding-left: 5px;
        }

        .hotel-name {
            display: table-cell;
            font-size: 16px;
            font-weight: bold;
            color: #333;
            vertical-align: middle;
            padding: 0 10px;
        }
        
        .hotel-stars {
            display: table-cell;
            color: #ffa726 !important;
            font-size: 18px;
            vertical-align: middle;
            text-align: right;
        }
        
        .info-grid {
            display: table;
            width: 100%;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-cell {
            display: table-cell;
            padding: 8px 10px;
            vertical-align: top;
            width: 50%;
        }
        
        .info-label {
            color: #666;
            font-size: 11px;
            margin-bottom: 3px;
        }
        
        .info-value {
            font-weight: bold;
            color: #333;
            font-size: 13px;
        }
        
        /* Booking Details */
        .booking-details {
            background: #fff;
            border: 2px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1976d2;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #ccc;
        }

        .detail-row {
            display: table;
            width: 100%;
            padding: 8px 0;
            border-bottom: 1px dashed #ccc;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            display: table-cell;
            width: 120px;
            color: #666;
            font-size: 11px;
            vertical-align: top;
        }

        .detail-value {
            display: table-cell;
            font-weight: bold;
            color: #333;
            font-size: 12px;
            vertical-align: top;
        }
        
        /* Guest Info */
        .guest-info {
            background: #fff;
            border: 2px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .guest-info .section-title {
            color: #7b1fa2;
            border-bottom-color: #ccc;
        }

        .guest-card {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 12px;
            margin-bottom: 10px;
        }
        
        .guest-card:last-child {
            margin-bottom: 0;
        }
        
        .guest-number {
            background: #9c27b0;
            color: white;
            display: inline-block;
            padding: 3px 10px;
            border-radius: 3px;
            font-size: 11px;
            margin-bottom: 8px;
        }
        
        /* Important Notes */
        .important-notes {
            background: #fff;
            border: 2px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin:20px !important;
            margin-bottom: 20px;
        }

        .important-notes .section-title {
            color: #c62828;
            border-bottom-color: #ccc;
        }
        
        .note-item {
            padding: 8px 0 8px 20px;
            position: relative;
            color: #555;
            font-size: 11px;
            line-height: 1.8;
        }
        
        .note-item:before {
            content: "•";
            position: absolute;
            right: 0;
            color: #f44336;
            font-weight: bold;
            font-size: 14px;
        }
        
        /* Cancellation Rules */
        .cancellation-rules {
            background: #fff;
            border: 2px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .cancellation-rules .section-title {
            color: #f57f17;
            border-bottom-color: #ccc;
        }
        
        /* Map Section */
        .map-section {
            background: #fff;
            border: 2px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin: 20px;
            page-break-inside: avoid;
        }

        .map-section .section-title {
            color: #000;
            border-bottom-color: #ccc;
        }

        .map-container {
            width: 100%;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 10px;
        }

        .map-container img {
            width: 100%;
            height: auto;
        }
        
        /* Footer */
        .footer {
            width: 100%;
            padding: 10px 0;
            text-align: center;
            border-top: 2px solid #ccc;
            position: fixed;
            bottom: -20mm;
            left: 0;
            right: 0;
            background: white;
        }

        .footer-info {
            width: 100%;
            border: none;
        }

        .footer-item {
            padding: 5px 15px;
            font-size: 16px;
            color: #666;
            text-align: center;
            border: none;
        }

        .footer-label {
            font-weight: bold;
            color: #333;
        }
     @page {
            footer: myFooter;
            margin-bottom: 25mm;
        }

        .footer-table {
            width: 100%;
            font-size: 10pt;
            padding-top: 5px;
            font-family: yekanbakh;
        }
        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        
        th, td {
            padding: 10px;
            text-align: right;
            border: 1px solid #ccc;
        }

        th {
            background: #fff;
            font-weight: bold;
            color: #333;
        }
        
        /* Utilities */
        .text-center {
            text-align: center;
        }
        
        .text-bold {
            font-weight: bold;
        }
        
        .text-red {
            color: #f44336;
        }
        
        .text-green {
            color: #4caf50;
        }
        
        .mb-10 {
            margin-bottom: 10px;
        }
        
        .mb-20 {
            margin-bottom: 20px;
        }
        
        @media print {
            body {
                background: #fff;
            }

            .container {
                margin: 0;
                box-shadow: none;
            }
        }
        .barcode {
            max-width: 80px;
            min-height: 50px;
            display: inline-block;
        }
    </style>
</head>
<body style=" font-family: yekanbakh;">
    <div class="container">';

        // Header با لوگو و بارکد
        $html .= '
        <div class="header">
            <table>
                <tr>
                    <td class="header-logo">
                        <img src="' . ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . CLIENT_LOGO . '" alt="Logo" style="max-width: 80px; min-height: 50px">
                    </td>
                    <td class="header-barcode">
                        <img class="barcode" src="https://safar360.com/gds/library/barcode/barcode_creator.php?barcode=' . trim($info_hotel[0]["pnr"]) . '" alt="Barcode"  >
                    </td>
                </tr>
            </table>
        </div>';

        // اطلاعات اصلی برای استفاده در بخش‌های مختلف
        $firstInfo = $info_hotel[0];

        if (!empty($firstInfo['payment_date'])) {
            $pd = functions::set_date_payment($firstInfo['payment_date']);
            $pd = explode(' ', $pd)[0]; // فقط تاریخ
            $p = explode('-', $pd);
            $pay_date = "{$p[0]}/{$p[1]}/{$p[2]}";
        } else {
            $pay_date = '-';
        }

        // بخش اطلاعات هتل
        $html .= '
        <div class="hotel-info-section">
            <table cellpadding="0" cellspacing="0" style="width: 100%;  border-collapse: collapse; font-family: yekanbakh;">
                <tr>
                    <td style="width: 35px; text-align: center; vertical-align: middle; border: none; padding: 0 5px 0 0; font-family: yekanbakh;">
                                               <svg height="24px" width="24px" fill="#ff9800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M24 0C10.7 0 0 10.7 0 24S10.7 48 24 48h8V464H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H488c13.3 0 24-10.7 24-24s-10.7-24-24-24h-8V48h8c13.3 0 24-10.7 24-24s-10.7-24-24-24H24zM432 48V464H304V384h32c8.8 0 16.1-7.2 14.7-15.9C343.1 322.6 303.6 288 256 288s-87.1 34.6-94.7 80.1c-1.5 8.7 5.8 15.9 14.7 15.9h32v80H80V48H432zM144 96c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V112c0-8.8-7.2-16-16-16H144zm80 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V112c0-8.8-7.2-16-16-16H240c-8.8 0-16 7.2-16 16zM336 96c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V112c0-8.8-7.2-16-16-16H336zM128 208v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V208c0-8.8-7.2-16-16-16H144c-8.8 0-16 7.2-16 16zm112-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V208c0-8.8-7.2-16-16-16H240zm80 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V208c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z"/></svg>

                    </td>
                    <td style="font-size: 20px; font-weight: bold; color: #333; vertical-align: middle; border: none; padding: 0 10px; font-family: yekanbakh;">
                        ' . $firstInfo['hotel_name'] . '
                        <span style="margin-right: 10px;">';

        // نمایش ستاره‌ها با SVG طلایی
        $stars = intval($firstInfo['hotel_starCode']);
        for ($i = 0; $i < $stars; $i++) {
            $html .= '<svg width="16" height="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="display: inline-block; vertical-align: middle; margin: 0 1px;">
                <path fill="#F0B417" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
            </svg>';
        }

        $html .= '</span>
                    </td>
                </tr>';

        // اضافه کردن آدرس و تلفن در row جدید (زیر آیکون هتل)
        if (!empty($firstInfo['hotel_address'])) {
            $html .= '<tr>
                    <td colspan="3" style="padding: 5px 5px 5px 0; font-size: 11px; color: #666; border: none; vertical-align: top; text-align: right; font-family: yekanbakh;">';

            if (!empty($firstInfo['hotel_address'])) {
                $html .= '<div style="margin-bottom: 8px; padding-bottom: 8px;font-family: yekanbakh;">

                    <span style="vertical-align: middle; font-family: yekanbakh;">آدرس: ' . $firstInfo['hotel_address'] . '</span>
                </div>';
            }

            $html .= '</td>
                </tr>
                <tr>
                    <td colspan="3" style="border: none; padding: 0; height: 12px;"></td>
                </tr>';
        }


        // محاسبه شماره واچر


            $voucherNumber = $firstInfo['pnr'];

        if (!empty($firstInfo['payment_date'])) {

            $pd = $firstInfo['payment_date']; // مقدار: 2025-10-21 08:20:23

            // جدا کردن تاریخ و ساعت
            list($datePart, $timePart) = explode(' ', $pd);

            // تبدیل تاریخ از - به /
            $p = explode('-', $datePart);
            $pay_date = "{$p[0]}/{$p[1]}/{$p[2]}";

            $pay_time = $timePart;

        } else {
            $pay_date = '-';
            $pay_time = '-';
        }

        $html .= '
                <tr>
                    <td colspan="3" style="border-top: 2px solid #ccc; border-left: none; border-right: none; border-bottom: none;  padding: -10px 5px -24px 0px; font-family: yekanbakh;">
                        <table cellpadding="0" cellspacing="0" style="width: 100%; border: none; border-collapse: collapse; font-family: yekanbakh;">
                            <tr>
                                <td style="width: 48%; border: none;  vertical-align: top; font-family: yekanbakh;">
                                    <table cellpadding="0" cellspacing="0" style="width: 100%; border: none; border-collapse: collapse; font-family: yekanbakh; margin-top:-6px;margin-bottom:-20px !important">
                                        <tr>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #333; font-weight: bold; width: 120px; line-height: 1.4; font-family: yekanbakh;">زمان تحویل اتاق:</td>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #666; line-height: 1.4; font-family: yekanbakh;">'. (!empty($firstInfo['start_date']) ? $firstInfo['start_date'] : '-') .  '   ساعت :   ' .   (!empty($firstInfo['hotel_entryHour']) ? $firstInfo['hotel_entryHour'] : '-')    . '</td>
                                        </tr>
                                        <tr>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #333; font-weight: bold; line-height: 1.4; font-family: yekanbakh;">زمان تخلیه اتاق:</td>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #666; line-height: 1.4; font-family: yekanbakh;">'. (!empty($firstInfo['end_date']) ? $firstInfo['end_date'] : '-') . '  ساعت :   ' .    (!empty($firstInfo['hotel_leaveHour']) ? $firstInfo['hotel_leaveHour'] : '-')     . '</td>
                                        </tr>
                                        <tr>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #333; font-weight: bold; line-height: 1.4; font-family: yekanbakh;">مدت اقامت:</td>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #666; line-height: 1.4; font-family: yekanbakh;">' . (!empty($firstInfo['number_night']) ? $firstInfo['number_night'] : '-') . ' شب</td>
                                        </tr>
                                        <tr>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #333; font-weight: bold; line-height: 1.4; font-family: yekanbakh;">تعداد اتاق:</td>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #666; line-height: 1.4; font-family: yekanbakh;">' . count($info_hotel) . ' اتاق </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="width: 1px; border-left: 2px solid #ccc; border-top: none; border-bottom: none; border-right: none; padding: 0; font-family: yekanbakh;"></td>
                                <td style="width: 10px; border: none; padding: 0; font-family: yekanbakh;">&nbsp;</td>
                                <td style="border: none; vertical-align: top; font-family: yekanbakh;">
                                    <table cellpadding="0" cellspacing="0" style="width: 100%; border: none; border-collapse: collapse; font-family: yekanbakh;margin-top:-6px;margin-bottom:-20px !important;">
                                        <tr>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #333; font-weight: bold; width: 100px; line-height: 1.4; font-family: yekanbakh;">شماره واچر:</td>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #666; line-height: 1.4; font-family: yekanbakh;">' . $voucherNumber . '</td>
                                        </tr>
                                        <tr>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #333; font-weight: bold; line-height: 1.4; font-family: yekanbakh;">شماره فاکتور:</td>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #666; line-height: 1.4; font-family: yekanbakh;">' . $firstInfo['factor_number'] . '</td>
                                        </tr>
                                        <tr>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #333; font-weight: bold; line-height: 1.4; font-family: yekanbakh;">تاریخ رزرو:</td>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #666; line-height: 1.4; font-family: yekanbakh;">' . ($pay_date !== '-' ? $pay_date : '-'). '</td>
                                        </tr>
                                        <tr>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #333; font-weight: bold; line-height: 1.4; font-family: yekanbakh;">ساعت رزرو:</td>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #666; line-height: 1.4; font-family: yekanbakh;">' . ($pay_time !== '-' ? $pay_time : '-') . '</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            
            ';



        $html .= '
                      
                        </div>
                   ';

        // اگر کنسل شده
        if ($firstInfo['request_cancel'] == 'confirm') {
            $html .= '<div style="background: #fff; border: 2px solid #ccc; padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: center; font-family: yekanbakh;">
                <span style="font-weight: bold; color: #c62828; font-size: 16px; font-family: yekanbakh;"> این هتل کنسل شده است</span>
            </div>';
        }



        // باکس اطلاعات اتاق‌ها
        $html .= '
        <div style="background: #fff; border-radius: 8px; overflow: hidden; margin: 20px; border: 2px solid #ddd; font-family: yekanbakh;">
            <div style="background: #d5dddd; color: #333; padding: 12px; font-weight: bold; font-size: 14px; font-family: yekanbakh;">
                اتاق‌ها
            </div>
            <div style="padding: 15px; font-family: yekanbakh; overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-family: yekanbakh;">
                    <thead>
                        <tr style="background: #d5dddd; border-bottom: 2px solid #ddd;">
                            <th style="padding: 12px; text-align: right; font-weight: bold; color: #333; border: 1px solid #ddd; font-family: yekanbakh;">ردیف</th>
                            <th style="padding: 12px; text-align: right; font-weight: bold; color: #333; border: 1px solid #ddd; font-family: yekanbakh;">نوع اتاق</th>
                            <th style="padding: 12px; text-align: right; font-weight: bold; color: #333; border: 1px solid #ddd; font-family: yekanbakh;">اطلاعات تخت</th>
                        </tr>
                    </thead>
                    <tbody>';

        $roomCounter = 1;
        foreach ($info_hotel as $info) {
            // تعداد تخت اضافه یا نوع تخت
            $bedInfo = '';
            if ($info['type_application'] == 'reservation') {
                $flatType = '';
                if ($info['flat_type'] == 'DBL') {
                    $flatType = 'تخت اصلی';
                } elseif ($info['flat_type'] == 'EXT') {
                    $flatType = 'تخت اضافه بزرگسال';
                } elseif ($info['flat_type'] == 'ECHD') {
                    $flatType = 'تخت اضافه کودک';
                }
                $bedInfo = $flatType != '' ? $flatType : '-';
            } else {
                $bedInfo = 'تعداد تخت اضافه: ' . (!empty($info['extra_bed_count']) ? $info['extra_bed_count'] : '0');
            }

            $html .= '
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td style="padding: 12px; text-align: right; border: 1px solid #ddd; font-family: yekanbakh; color: #333;">' . $roomCounter . '</td>
                            <td style="padding: 12px; text-align: right; border: 1px solid #ddd; font-family: yekanbakh; color: #333; font-weight: bold;">' . (!empty($info['room_name']) ? $info['room_name'] : '-') . '</td>
                            <td style="padding: 12px; text-align: right; border: 1px solid #ddd; font-family: yekanbakh; color: #333;">' . $bedInfo . '</td>
                        </tr>';

            $roomCounter++;
        }

        $html .= '
                    </tbody>
                </table>
            </div>
        </div>';

        // باکس اطلاعات مسافرین
        $html .= '
        <div style="background: #fff; border-radius: 8px; overflow: hidden; margin: 20px; border: 2px solid #ddd; font-family: yekanbakh;">
            <div style="background: #d5dddd; color: #333; padding: 12px; font-weight: bold; font-size: 14px; font-family: yekanbakh;">
                اطلاعات مسافرین
            </div>
            <div style="padding: 15px; font-family: yekanbakh; overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-family: yekanbakh;">
                    <thead>
                        <tr style="background: #f5f5f5; border-bottom: 2px solid #ddd;">
                            <th style="padding: 12px; text-align: right; font-weight: bold; color: #333; border: 1px solid #ddd; font-family: yekanbakh;">ردیف</th>
                            <th style="padding: 12px; text-align: right; font-weight: bold; color: #333; border: 1px solid #ddd; font-family: yekanbakh;">نام و نام خانوادگی</th>
                            <th style="padding: 12px; text-align: right; font-weight: bold; color: #333; border: 1px solid #ddd; font-family: yekanbakh;">تاریخ تولد</th>
                            <th style="padding: 12px; text-align: right; font-weight: bold; color: #333; border: 1px solid #ddd; font-family: yekanbakh;">شماره ملی/پاسپورت</th>
                        </tr>
                    </thead>
                    <tbody>';

        $passengerNum = 1;
        foreach ($info_hotel as $passenger) {
            // نام و نام خانوادگی
            $fullName = '';
            if (!empty($passenger['passenger_name'])) {
                $fullName = $passenger['passenger_name'] . ' ' . $passenger['passenger_family'];
            } elseif (!empty($passenger['passenger_name_en'])) {
                $fullName = $passenger['passenger_name_en'] . ' ' . $passenger['passenger_family_en'];
            } else {
                $fullName = '-';
            }

            // تاریخ تولد
            $birthday = '';
            if (!empty($passenger['passenger_birthday'])) {
                $birthday = $passenger['passenger_birthday'];
            } elseif (!empty($passenger['passenger_birthday_en'])) {
                $birthday = $passenger['passenger_birthday_en'];
            } else {
                $birthday = '-';
            }

            // شماره ملی/پاسپورت
            $nationalCode = '';
            if ($passenger['passenger_national_code'] != '') {
                $nationalCode = $passenger['passenger_national_code'];
            } elseif (!empty($passenger['passportNumber'])) {
                $nationalCode = $passenger['passportNumber'];
            } else {
                $nationalCode = '-';
            }

            $html .= '
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td style="padding: 12px; text-align: right; border: 1px solid #ddd; font-family: yekanbakh; color: #333;">' . $passengerNum . '</td>
                            <td style="padding: 12px; text-align: right; border: 1px solid #ddd; font-family: yekanbakh; color: #333; font-weight: bold;">' . $fullName . '</td>
                            <td style="padding: 12px; text-align: right; border: 1px solid #ddd; font-family: yekanbakh; color: #333;">' . $birthday . '</td>
                            <td style="padding: 12px; text-align: right; border: 1px solid #ddd; font-family: yekanbakh; color: #333;">' . $nationalCode . '</td>
                        </tr>';

            $passengerNum++;
        }

        $html .= '
                    </tbody>
                </table>
            </div>
        </div>';
        

        if ($firstInfo['type_application'] == 'api') {
            // قوانین کنسلی
            $html .= '
             <div class="important-notes" style="font-family: yekanbakh;">
                <div class="section-title" style="font-family: yekanbakh;"> قوانین کنسلی</div>

                <div class="note-item" style="font-family: yekanbakh;">
                   کنسلی رزرو در ایام پیک و غیر پیک: با توجه به اینکه نرخ کنسلی در ایام مختلف و هتل های مختلف متفاوت می باشد، مبلغ دقیق کنسلی بعد از استعلام از هتل مشخص می گردد.
                </div>

            </div>';

        }else{
            $html .= '
             <div class="important-notes" style="font-family: yekanbakh;">
                <div class="section-title" style="font-family: yekanbakh;"> قوانین کنسلی</div>

                <div class="note-item" style="font-family: yekanbakh;">
            '
               .
                $firstInfo['hotel_rules'] . '
                </div> .

            </div>';
        }
        // نکات مهم
            $html .= '
            <div class="important-notes" style="font-family: yekanbakh;">
                <div class="section-title" style="font-family: yekanbakh;"> نکات مهم برای پذیرش در هتل</div>

                <div class="note-item" style="font-family: yekanbakh;">
                    همراه داشتن شناسنامه عکسدار جهت پذیرش و اقامت در هتل و همچنین نام ثبت شده همسر در شناسنامه الزامی است.
                </div>

                <div class="note-item" style="font-family: yekanbakh;">
                    ساعت تحویل و تخلیه اتاق طبق واچر می‌باشد و ساعت ورود و خروج پرواز ملاک نمی‌باشد و هتل هیچ تعهدی در قبال تحویل اتاق قبل از ساعت اعلام شده و در اختیار داشتن اتاق بعد از ساعت اعلام شده را ندارد.
                </div>


                <div class="note-item" style="font-family: yekanbakh;">
                    ترانسفر ورود یا خروج بر اساس درخواست مسافر انجام و مشمول هزینه می‌باشد.
                </div>

                <div class="note-item" style="font-family: yekanbakh;">
                    کنسل نمودن رزرو اتاق مشمول جریمه طبق مقررات و یا در صورت گارانتی هتل، مبلغ غیر قابل استرداد می‌باشد.
                </div>
            </div>';

        if (!empty($firstInfo['hotel_location'])) {
            $location = json_decode($firstInfo['hotel_location'], true);
            if (!empty($location['latitude']) && !empty($location['longitude'])) {
                $lat = $location['latitude'];
                $lng = $location['longitude'];
                $html .= '
            <div class="map-section" style="font-family: yekanbakh; page-break-inside: avoid;">
                <div class="section-title" style="font-family: yekanbakh;">موقعیت هتل روی نقشه</div>
                <div class="map-container">
                    <img src="https://static-maps.yandex.ru/1.x/?lang=fa_IR&ll=' . $lng . ',' . $lat . '&z=14&l=map&size=600,150&pt=' . $lng . ',' . $lat . ',pm2rdm" alt="نقشه هتل" style="width: 100%; height: auto; border-radius: 5px;">
                </div>
            </div>';
            }
        }



        // Footer
        $html .= '
<htmlpagefooter name="myFooter">
    <div style="">
        <table style="border-top:2px solid #ccc;width:100%; border-collapse:collapse;margin:10px 25px 10px 25px; font-family:yekanbakh;font-size:16px;">
            <tr>
                <td style="border:none;">
                    <span>وب سایت:</span>
                    <span dir="ltr">'.CLIENT_MAIN_DOMAIN.'</span>
                </td>
                <td style="border:none;">
                    <span>تلفن:</span>
                    <span dir="ltr">'.CLIENT_PHONE.'</span>
                </td>
                <td style="border:none;">
                    <span>آدرس:</span>
                    <span>'.CLIENT_ADDRESS.'</span>
                </td>
            </tr>
        </table>
    </div>
</htmlpagefooter>

</body>
</html>';

        return $html;
    }

    public function ReduceCapacity($user_type, $factorNumber, $type)
    {
//        $Model = Load::library('Model');
//
//        $sqlBook = "SELECT
//                        room_id, flat_type, roommate, hotel_id, start_date, end_date
//                    FROM book_hotel_local_tb WHERE factor_number='{$factorNumber}'";
        $HotelRoom = $this->getModel('bookHotelLocalModel')->get(['room_id','flat_type','roommate','hotel_id','start_date','end_date'])->where('factor_number',$factorNumber)->all();
//        $HotelRoom = $Model->select($sqlBook);
        functions::insertLog('ReduceCapacity: '.json_encode($HotelRoom,256|64).PHP_EOL,'log_method_ReserveHotel');

        $start_date = str_replace("-", "", $HotelRoom[0]['start_date']);
        $end_date = str_replace("-", "", $HotelRoom[0]['end_date']);

        foreach ($HotelRoom as $book) {

            $expRoommate = explode("_", $book['roommate']);
            $exp = explode(":", $expRoommate[2]);
            if ($exp[0] != 'DBL' || ($exp[0] == 'DBL' && $exp[1] == '1')) {

                $sql = " SELECT
                    id, remaining_capacity, id_room, full_capacity
                 FROM 
                    reservation_hotel_room_prices_tb
                 WHERE 
                    id_hotel='{$book['hotel_id']}' AND
                    id_room='{$book['room_id']}' AND
                    date>='{$start_date}' AND date<'{$end_date}' AND
                    user_type='{$user_type}' AND
                    flat_type='{$book['flat_type']}'
                    ";
                $HotelRoom_sub = $this->getModel('reservationHotelRoomPricesModel')->select($sql);

                functions::insertLog('$HotelRoom_sub: '.json_encode($HotelRoom_sub,256|64).PHP_EOL,'log_method_ReserveHotel');


                foreach ($HotelRoom_sub as $room) {
                    if ($type == 'Increase') {
                        $remaining_capacity = $room['remaining_capacity'] - 1;
                        $full_capacity = (empty($room['full_capacity'])|| $room['full_capacity'] <= 0 ) ? 1 : ($room['full_capacity'] + 1);
                    } else if ($type == 'Decrease') {
                        $remaining_capacity = $room['remaining_capacity'] + 1;
                        $full_capacity = (empty($room['full_capacity'])|| $room['full_capacity'] <= 0 ) ? 1 : ($room['full_capacity'] - 1);
                    }

                    $data['remaining_capacity'] = $remaining_capacity;
                    $data['full_capacity'] = $full_capacity;
                    functions::insertLog('$data HotelRoom_sub: '.json_encode($data,256|64).PHP_EOL,'log_method_ReserveHotel');

                    $condition = " id='{$room['id']}' ";
                    $res[] =  $this->getModel('reservationHotelRoomPricesModel')->update($data, $condition);

                }
            }


        }

        functions::insertLog('ReduceCapacity: '.json_encode($res,256|64).PHP_EOL,'log_method_ReserveHotel');


        if (in_array('0', $res)) {
            return 'error';
        } else {
            return 'success';
        }
    }

    public function getReportHotelAgency($agencyId)
    {
        /** @var bookHotelLocalModel $hotelBookLocalModel */
        $hotelBookLocalModel = Load::getModel('bookHotelLocalModel');
        return $hotelBookLocalModel->getReportHotelAgency($agencyId);
    }

    public function getPriceWithChange($factor_number){
        $info_hotel = $this->getModel('reportHotelModel')->get()->where('factor_number',$factor_number)->find();
            if($info_hotel['agency_commission_price_type']=='percent'){
                return $info_hotel['total_price_api'] + ($info_hotel['total_price_api'] * ($info_hotel['agency_commission']/100));
            }
            return $info_hotel['total_price_api'] + $info_hotel['agency_commission'] ;
    }

    public function updateStatusPreReserve($params = []) {
        $factor_number = $params['factor_number'];$as_json = $params['as_json'];
        /** @var reportHotelModel $report */
        $report = $this->getModel('reportHotelModel');
        $find_report = $report->get()->where('factor_number',$factor_number)->find();
        if(!$find_report){
            return ($as_json) ? functions::withError($find_report,404,'Not found') : false;
        }
        $update_report = $report->updateWithBind(['status'=>'PreReserve'],['factor_number'=>$factor_number]);
        if($update_report){
            /** @var admin $admin */
            $admin        = $this->getController('admin');
            $update_book = $admin->ConectDbClient('',$find_report['client_id'],'Update',['status'=>'PreReserve'],'book_hotel_local_tb'," `factor_number` = '$factor_number'");
            $update_credit = false;
            if($find_report['payment_type'] == 'credit'){
                $update_credit = $admin->ConectDbClient('',$find_report['client_id'],'Delete',[],'credit_detail_tb'," `requestNumber` = '$factor_number'");
            }
            $update_transaction = $admin->ConectDbClient('',$find_report['client_id'],'Update',['PaymentStatus'=>'pending'],'transaction_tb'," `FactorNumber` = '$factor_number'");

            //for admin panel , transaction table
            $condition = " `FactorNumber` = '$factor_number'";
            $data = ['PaymentStatus'=>'pending','clientID' => $find_report['client_id']];
            $this->transactions->updateTransaction($data, $condition);


            if($update_book && $update_transaction){
                return ($as_json) ? functions::withSuccess([$update_book,$update_transaction,$update_credit],200,'updated successfully') : true;
            }
            return ($as_json) ? functions::withError(false,500,'error update book or transaction') : false;
        }
        return ($as_json) ? functions::withError(false,500,'error update report') : false;
    }

    public function generateRandomPnr() {
        $part1 = rand(1000, 9999);   // Random 4-digit number
        $part2 = rand(10000, 99999); // Random 5-digit number
        return $part1 . '-' . $part2; // Combine with hyphen
    }
    public function isCodeUnique($params) {
        $book_model = load::getModel('bookHotelLocalModel');
        return $book_model->get(['*'])->where('pnr' , $params['code'] )->find() ;
    }
}
