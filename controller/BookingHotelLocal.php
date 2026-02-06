<?php

class BookingHotelLocal extends clientAuth
{
    public $payment_date = '';
    public $okHotel = '';
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
    

        $this->transactions = $this->getModel('transactionsModel');
    }

    public function setPortBankForHotel($bankDir, $factorNumber , $paymentStatus)
    {
    
 
        $initialValues = array(
            'bank_dir' => $bankDir,
            'serviceTitle' => $_POST['serviceType']
        );

        $bankModel = Load::model('bankList');
        $bankInfo = $bankModel->getByBankDir($initialValues);

        $data['name_bank_port'] = $bankDir;
        $data['number_bank_port'] = $bankInfo['param1'];
        $data['payment_status'] = $paymentStatus;

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
//            var_dump('updateBank22222');
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
//            var_dump('HotelBookCredit2222');
//            die;
//        }

        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $apiHotelLocal = Load::library('apiHotelLocal');
        $smsController = Load::controller('smsServices');
        $reservationHotelController = Load::controller('reservationHotel');
        $userRoleController = Load::controller('userRole');
        $factorNumber = trim($factorNumber);
        $this->factor_number = $factorNumber;

        $sql = " SELECT * FROM book_hotel_local_tb 
            WHERE factor_number='{$factorNumber}' AND status='PreReserve' GROUP BY factor_number ";
        $Hotel = $Model->load($sql);

        $this->hotelId = $Hotel['hotel_id'];
        $this->type_application = $Hotel['type_application'];
        $this->hotelInfo = $Hotel;


        #region [api or reservation or externalApi]
        if ($Hotel['type_application'] == 'api' || $Hotel['type_application'] == 'api_app') {

            $ReserveHotel = $apiHotelLocal->Hotel_Reserve_Book($Hotel['request_number'], $Hotel['pnr'], $factorNumber);
            error_log('try show result method Hotel in : ' . date('Y/m/d H:i:s') . ' buy Credit array eqaul in => : ' . json_encode($ReserveHotel, true) . " \n", 3, LOGS_DIR . 'log_method_ReserveHotel.txt');

            $request_number = $ReserveHotel['RequestNumber'];

            if ($ReserveHotel['Status'] == '1') {

                $data['status'] = 'BookedSuccessfully';
                $data['payment_date'] = Date('Y-m-d H:i:s');
                $data['payment_type'] = 'credit';
                $data['creation_date_int'] = time();
                $data['voucher_url'] = $ReserveHotel['VoucherUrl'];

                foreach ($ReserveHotel['VouchersDetails'] as $VouchersDetails) {

                    $data['voucher_number'] = $VouchersDetails['VoucherNumber'];
                    $data['price_current'] = $VouchersDetails['Price'];

                    $condition = " factor_number='{$factorNumber}' AND request_number = '{$request_number}' AND room_id='{$VouchersDetails['RoomCode']}' ";
                    $Model->setTable('book_hotel_local_tb');
                    $res = $Model->update($data, $condition);

                    if ($res) {

                        $ModelBase->setTable('report_hotel_tb');
                        $ModelBase->update($data, $condition);
                        $this->okHotel = true;
                        $this->payment_date = $data['payment_date'];

                    }
                }

                if (functions::CalculateChargeAdminAgency(CLIENT_ID) < 10000000) {
                    //sms to site manager
                    $objSms = $smsController->initService('1');
                    if ($objSms) {
                        $sms = "مدیریت محترم آژانس" . " " . CLIENT_NAME . PHP_EOL . " شارژحساب کاربری شما در نرم افزار سفر 360 به کمتر از 10,000,000 ریال رسیده است";
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
                        'fanipor' => '09129409530',
                        'afraze' => '09916211232',
                        'abasi2' => '09057078341',
                        'bahrami' => '09351252904',

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
                    $hotel_reserve_pattern  =   $smsController->getPattern('hotel_book_pattern_sms');
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
                }

            } else if ($ReserveHotel['Status'] == '2') {
                $this->errorMessage = 'این هتل قبلا توسط شما رزرو شده است، لطفا برای پیگیری رزرو هتل خود با پشتیبانی تماس حاصل نمائید';


            } else if ($ReserveHotel['Status'] == '0') {


                $this->errorMessage = 'اشکالی در فرآیند رزرو هتل پیش آمده است، لطفا برای پیگیری رزرو هتل و یا برگرداندن اعتبار  خود با پشتیبانی تماس حاصل نمائید';

                $data['status'] = 'credit';
                $data['payment_type'] = 'credit';
                $data['creation_date_int'] = time();

                $condition = " factor_number='{$factorNumber}' AND request_number = '{$request_number}' ";
                $Model->setTable('book_hotel_local_tb');
                $res = $Model->update($data, $condition);

                if ($res) {
                    $ModelBase->setTable('report_hotel_tb');
                    $ModelBase->update($data, $condition);
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
//                var_dump('solommmm');
//        var_dump($Hotel['hotel_payments_price']);
//                die;


//                if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//                    var_dump($Hotel['hotel_payments_price']);
//                    var_dump('5565');
//                    die;
//                }
                if ($Hotel['hotel_payments_price']>0 && $Hotel['payment_status']=='') {
                    $data['status'] = 'Requested';
                    $data['payment_status'] = 'prePayment';
                }else{
                    $data['status'] = 'BookedSuccessfully';
//                    $data['payment_status'] = 'fullPayment';
                }
                $data['pnr'] = $code;
                $data['payment_date'] = Date('Y-m-d H:i:s');
                $data['payment_type'] = 'credit';
                $data['creation_date_int'] = time();

                $condition = " factor_number='{$factorNumber}' ";
                $Model->setTable('book_hotel_local_tb');
                $res = $Model->update($data, $condition);

                if ($res) {

                    $ModelBase->setTable('report_hotel_tb');
                    $ModelBase->update($data, $condition);

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
                        if ($Hotel['hotel_payments_price']>0 && $Hotel['payment_status']=='') {
                            $hotel_reserve_pattern  =   $smsController->getPattern('hotel_preReserve_payment_pattern_sms');
                            if($hotel_reserve_pattern) {
                                $smsController->smsByPattern($hotel_reserve_pattern['pattern'], array($mobile),$messageVariables);
                            }else {
                                $smsArray = array(
                                    'smsMessage' => $smsController->getUsableMessage('afterHotelPreReservePayment', $messageVariables),
                                    'cellNumber' => $mobile,
                                    'smsMessageTitle' => 'afterHotelPreReservePayment',
                                    'memberID' => (!empty($Hotel['member_id']) ? $Hotel['member_id'] : ''),
                                    'receiverName' => $messageVariables['sms_name'],
                                );
                                $smsController->sendSMS($smsArray);
                            }
                        }else{
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
                        }

                        $reservation_hotel = $reservationHotelController->getHotelById(['id'=>$Hotel['hotel_id']]);

                        if($reservation_hotel['user_id']) {
                            $sms = $smsController->getUsableMessage('afterHotelReserveToManager', $messageVariables);
                            $hotel_admin_mobile = $userRoleController->getUserById($reservation_hotel['user_id']);
                            $users  = $userRoleController->getUserRoleReservationMobile('hotel' , $this->hotelId);
                            if(!in_array($hotel_admin_mobile['mobile'] , $users)){
                                $users[] = $hotel_admin_mobile['mobile'] ;
                            }

                            foreach ($users as $cellNumber) {
                                $smsArray = array(
                                    'smsMessage' => $sms,
                                    'cellNumber' => $cellNumber,
                                    'smsMessageTitle' => 'afterHotelReserve',
                                    'memberID' => (!empty($Hotel['member_id']) ? $Hotel['member_id'] : ''),
                                    'receiverName' => $messageVariables['sms_name'],
                                );
                                $smsController->sendSMS($smsArray);
                            }
                        }
                        else{
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

        }
        else if ($Hotel['type_application'] == 'externalApi') {

            $this->externalApiReserve($Hotel, 'credit');

        }
        else {
            $this->errorMessage = 'نرم افزاری برای بررسی اطلاعات رزرو وجود ندارد. لطفا با پشتیبانی تماس بگیرید.';
        }
        #endregion

    }

    public function HotelBook($factorNumber)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $objTransaction = Load::controller('transaction');
        $apiHotelLocal = Load::library('apiHotelLocal');
        $smsController = Load::controller('smsServices');
	$reservationHotelController = Load::controller('reservationHotel');
        $userRoleController = Load::controller('userRole');

        $factorNumber = trim($factorNumber);
        $this->factor_number = $factorNumber;
	    /** @var bookHotelLocalModel $bookHotelLocalModel */
	    $bookHotelLocalModel = Load::getModel('bookHotelLocalModel');

	    $Hotel = $bookHotelLocalModel->get()
	                                 ->where('factor_number',$factorNumber)
	                                 ->where('status','bank')
	                                 ->where('tracking_code_bank','','!=')
	                                 ->groupBy('factor_number')->find();
	    //         $sql = "SELECT * FROM book_hotel_local_tb
	    //            WHERE factor_number='{$factorNumber}' AND status = 'bank' AND tracking_code_bank !=''
	    //            GROUP BY factor_number";
	    //
	    //        $Hotel = $Model->load($sql);

        $this->hotelId = $Hotel['hotel_id'];
        $this->type_application = $Hotel['type_application'];
        $this->hotelInfo = $Hotel;

        #region [api or reservation]
        if ($Hotel['type_application'] == 'api' || $Hotel['type_application'] == 'api_app') {

            $ReserveHotel = $apiHotelLocal->Hotel_Reserve_Book($Hotel['request_number'], $Hotel['pnr'], $factorNumber);
            error_log('try show result method Hotel in : ' . date('Y/m/d H:i:s') . ' buy Cash array eqaul in => : ' . json_encode($ReserveHotel, true) . " \n", 3, LOGS_DIR . 'log_method_ReserveHotel.txt');

            if ($ReserveHotel['Status'] == '1') {

                $request_number = $ReserveHotel['RequestNumber'];

                // Caution: آپدیت تراکنش به موفق
                $objTransaction->setCreditToSuccess($factorNumber, $Hotel['tracking_code_bank']);

                $data['status'] = 'BookedSuccessfully';
                $data['payment_date'] = Date('Y-m-d H:i:s');
                if ($Hotel['tracking_code_bank'] == 'member_credit') {
                    $data['payment_type'] = 'member_credit';
                    $data['tracking_code_bank'] = '';
                } else {
                    $data['payment_type'] = 'cash';
                }
                $data['creation_date_int'] = time();
                $data['voucher_url'] = $ReserveHotel['VoucherUrl'];

                foreach ($ReserveHotel['VouchersDetails'] as $VouchersDetails) {

                    $data['voucher_number'] = $VouchersDetails['VoucherNumber'];
                    $data['price_current'] = $VouchersDetails['Price'];

                    $condition = " factor_number='{$factorNumber}' AND request_number = '{$request_number}' AND room_id='{$VouchersDetails['RoomCode']}' ";
                    $Model->setTable('book_hotel_local_tb');
                    $res = $Model->update($data, $condition);

                    if ($res) {

                        $ModelBase->setTable('report_hotel_tb');
                        $ModelBase->update($data, $condition);
                        $this->okHotel = true;
                        $this->payment_date = $data['payment_date'];

                    }
                }

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
                    $hotel_reserve_pattern  =   $smsController->getPattern('hotel_book_pattern_sms');
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
                }

            } else if ($ReserveHotel['Status'] == '2') {
                $this->errorMessage = 'این هتل قبلا توسط شما رزرو شده است، لطفا برای پیگیری رزرو هتل خود با پشتیبانی تماس حاصل نمائید';


            } else if ($ReserveHotel['Status'] == '0') {
                $this->errorMessage = 'اشکالی در فرآیند رزرو هتل پیش آمده است، لطفا برای پیگیری رزرو هتل و یا برگرداندن اعتبار  خود با پشتیبانی تماس حاصل نمائید';

                $data['status'] = 'credit';
                $data['payment_type'] = 'cash';
                $data['creation_date_int'] = time();

                $condition = " factor_number='{$factorNumber}' ";
                $Model->setTable('book_hotel_local_tb');
                $res = $Model->update($data, $condition);

                if ($res) {

                    $ModelBase->setTable('report_hotel_tb');
                    $ModelBase->update($data, $condition);
                }

            }

        }
        else if ($Hotel['type_application'] == 'reservation' || $Hotel['type_application'] == 'reservation_app') {


            $sql = " SELECT status FROM book_hotel_local_tb WHERE factor_number='{$factorNumber}' ";
            $hotel = $Model->load($sql);
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


                    $data['pnr'] = $code;
                    $data['status'] = 'BookedSuccessfully';
                    $data['payment_date'] = Date('Y-m-d H:i:s');
                    $data['payment_type'] = 'Cash';
                    $data['creation_date_int'] = time();

                    $condition = " factor_number='{$factorNumber}' ";
                    $Model->setTable('book_hotel_local_tb');
                    $res = $Model->update($data, $condition);

                    if ($res) {

                        $ModelBase->setTable('report_hotel_tb');
                        $ModelBase->update($data, $condition);

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
                            $hotel_reserve_pattern  =   $smsController->getPattern('hotel_book_pattern_sms');
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
                            $reservation_hotel = $reservationHotelController->getHotelById(['id'=>$Hotel['hotel_id']]);

                            if($reservation_hotel['user_id']) {
                                $sms = $smsController->getUsableMessage('afterHotelReserveToManager', $messageVariables);
                                $hotel_admin_mobile = $userRoleController->getUserById($reservation_hotel['user_id']);
                                $users  = $userRoleController->getUserRoleReservationMobile('hotel' , $this->hotelId);
                                if(!in_array($hotel_admin_mobile['mobile'] , $users)){
                                    $users[] = $hotel_admin_mobile['mobile'] ;
                                }
                                foreach ($users as $cellNumber) {
                                    $smsArray = array(
                                        'smsMessage' => $sms,
                                        'cellNumber' => $cellNumber,
                                        'smsMessageTitle' => 'afterHotelReserve',
                                        'memberID' => (!empty($Hotel['member_id']) ? $Hotel['member_id'] : ''),
                                        'receiverName' => $messageVariables['sms_name'],
                                    );
                                    $smsController->sendSMS($smsArray);
                                }
                            }
                            else {
                                //to site manager
                                $hotel_reserve_pattern  =   $smsController->getPattern('hotel_reserve_payment_pattern_sms');
                                if($hotel_reserve_pattern) {
                                    $smsController->smsByPattern($hotel_reserve_pattern['pattern'], array($mobile),$messageVariables);
                                }else {
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

                }

            }

        }
        else if ($Hotel['type_application'] == 'externalApi') {

            $this->externalApiReserve($Hotel, 'cash');

        }
        else {
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
        $Model = Load::library('Model');

        $query = "SELECT status FROM book_hotel_local_tb WHERE factor_number = '{$factorNumber}'";
        $result = $Model->load($query);

        return $result['status'] == 'BookedSuccessfully' ? true : false;
    }

    public function emailHotelSelf($factor_number)
    {
        $Model = Load::library('Model');
        $sql = " SELECT * FROM book_hotel_local_tb WHERE factor_number='{$factor_number}'";
        $res_model = $Model->load($sql);

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

            mail($to, $subject, $message, $headers);
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
    	
    	$left = (SOFTWARE_LANG == 'en') ? 'right' : 'left';
    	$right = (SOFTWARE_LANG == 'en') ? 'left' : 'right';
	    $dir = (SOFTWARE_LANG == 'en') ? 'ltr' : 'rtl';
    	$styles = '';
    	if(SOFTWARE_LANG == 'en'){
    		$styles.= '
    		body{
    		direction: ltr;
    		text-align: left;
    		}
    		';
	    }
        $StampAgency = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . CLIENT_STAMP;
        $printBoxCheck = '';
        $printBoxCheck .= ' <!DOCTYPE html>
                <html dir="'.$dir.'" lang="'.SOFTWARE_LANG.'">
                    <head>
                        <meta charset="UTF-8">
                        <title>'.functions::Xmlinformation('ViewHotelPDF').'</title>
                    </head>
                    <style>'.$styles.'</style>
                    <body>';

        if (TYPE_ADMIN == '1') {
            $Model = Load::library('ModelBase');
            $tableName = 'report_hotel_tb';

        } else {
            $Model = Load::library('Model');
            $tableName = 'book_hotel_local_tb';
        }
        
        $sql = "SELECT * FROM $tableName  WHERE factor_number='{$factorNumber}' ";
        if (isset($cancelStatus) && $cancelStatus != '') {
            $sql .= " AND status = 'cancelled' ";
        }
        
        $info_hotel = $Model->select($sql);

        if (!empty($info_hotel)) {
            $printBoxCheck .= '<div style="margin:30px auto 0;background-color: #fff;line-height: 24px;">
        
                                <div style="margin:30px auto 0;background-color: #fff;">
                
                    <div style="margin: 10px auto 0;">
                        <div style="font-size: 14px;font-weight: bold;vertical-align: text-bottom;margin: 20px 0 0 0;width: 45%;display: inline-block;text-align: center;height: 67px;font: inherit;float: '.$right.';">
                            ';
            if (isset($cancelStatus) && $cancelStatus != '') {
                $printBoxCheck .= functions::Xmlinformation('Cancellationprint');
            } else {
                $printBoxCheck = $info_hotel['hotel_name'];
            }
	        $LogoAgency = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . CLIENT_LOGO;
	
	        $printBoxCheck .= '
                        </div>
                        <div style="margin: 20px 0 0 0;width: 45%;display: inline-block;text-align: center;height: 67px;float: '.$left.';">
                            <img src="' . $LogoAgency. '" style="max-height: 80px;">
                        </div>
                    </div>
                
                    <div style="position: relative;font-size: 18px;margin: 8px auto;color: #171717;text-align: center;padding: 0 10px;background: #fff;width: 91%;">
                        <span style="background: #fff;position: relative;z-index: 1;padding: 0 15px;">'.functions::Xmlinformation('HotelWatcher').'</span>
                    </div>
                    ';

            foreach ($info_hotel as $k => $info) {

                if ($k == 0) {


                    $printBoxCheck .= '
                            <div style="border: 1px solid #2E3231;margin: 5px 40px 5px 40px;">';
	                
                    $printBoxCheck .= '
                            <div class="row" style="padding: 8px;font-weight: bold;background-color: #2E3231;margin: 0;color: #fff;">
        
                                <div style="width: 30%;position: relative;float: '.$right.';min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;">
                                    <span style="font-weight: bold;">'.functions::Xmlinformation('WachterNumber').' : </span><span>';
                    $printBoxCheck .= $info['factor_number'];
                    $payDate = functions::set_date_payment($info['payment_date']);
                    $payDate = explode(' ', $payDate);
                    $printBoxCheck .= '</span>
                                </div>
        
                                <div style="width: 30%;position: relative;float: '.$right.';min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;">
                                    <span style="font-weight: bold;">'.functions::Xmlinformation('Buydate').' : </span><span>';
                    $printBoxCheck .= $payDate[0];
                    $printBoxCheck .= '</span>
                                </div>
        
                                <div style="width: 30%;position: relative;float: '.$right.';min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;">
                                    <span style="font-weight: bold;">'.functions::Xmlinformation('Buytime').' : </span><span>';
                    $printBoxCheck .= $payDate[1];
                    $printBoxCheck .= '</span>
                                </div>
        
                            </div>';


                    $printBoxCheck .= '
                            <div class="row" style="padding: 8px;margin: 0;">
                                <div style="width: 45%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;der-box;">
                                    <span style="font-weight: bold;">'.functions::Xmlinformation('Namehotel').' : </span><span>';
                    $printBoxCheck .= $info['hotel_name'];
                    $printBoxCheck .= '</span>
                                </div>
        
                                <div style="width: 45%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;">
                                    <span style="font-weight: bold;">'.functions::Xmlinformation('Hotelgrade').' : </span><span>';
                    $printBoxCheck .= $info['hotel_starCode'];
                    $printBoxCheck .= '</span>
                                </div>
                            </div>';

                    $startDate = (SOFTWARE_LANG == 'fa') ? $info['start_date'] : functions::ConvertToMiladi($info['start_date']);
                    $endDate = (SOFTWARE_LANG == 'fa') ? $info['end_date'] : functions::ConvertToMiladi($info['end_date']);
                    
                    $printBoxCheck .= '
                    <div class="row" style="padding: 8px;margin: 0;">
                        <div style="width: 30%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;der-box;">
                            <span style="font-weight: bold;">'.functions::Xmlinformation('Enterdate').' : </span><span style="direction: rtl;text-align: '.$right.';display: inline-block;">' . $startDate . '</span>
                        </div>
                        <div style="width: 30%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;der-box;">
                            <span style="font-weight: bold;">'.functions::Xmlinformation('Exitdate').' : </span><span style="direction: rtl;text-align: '.$right.';display: inline-block;">' . $endDate . '</span>
                        </div>
                        <div style="width: 30%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;der-box;">
                            <span style="font-weight: bold;">'.functions::Xmlinformation('Night').' : </span><span style="direction: rtl;text-align: '.$right.';display: inline-block;">' . $info['number_night'] . '</span>
                        </div>
                    </div>';

                    $printBoxCheck .= '
                            <div class="row" style="padding: 8px;margin: 0;">
                                <div style="width: 45%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;">
                                    <span style="font-weight: bold;">'.functions::Xmlinformation('TimeCheckIn').' : </span><span>';
                    $printBoxCheck .= $info['hotel_entryHour'];
                    $printBoxCheck .= '</span><span style="font-weight: bold;"> '.functions::Xmlinformation('TimeCheckOut').' </span><span style="font: normal 12px/28px Yekan,Tahoma, Geneva, sans-serif;">';
                    $printBoxCheck .= $info['hotel_leaveHour'];
                    $printBoxCheck .= '</span>
                                </div>
        
                                <div style="width: 45%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;">
                                    <span style="font-weight: bold;">'.functions::Xmlinformation('Hotelwork').' : </span><span>';
                    $printBoxCheck .= $info['hotel_telNumber'];
                    $printBoxCheck .= '</span>
                                </div>
                                
                                 <div style="width: 45%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;">
                                    <span style="font-weight: bold;">'.functions::Xmlinformation('ConfirmationHotel').' : </span><span>';
                    $printBoxCheck .= $info['pnr'];
                    $printBoxCheck .= '</span>
                                </div>
                            </div>';

                    if ($info['time_entering_room'] != '') {
                        $printBoxCheck .= '
                            <div class="row" style="padding: 8px;margin: 0;">
                                <div style="width: 45%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;">
                                    <span style="font-weight: bold;">'.functions::Xmlinformation('Addresshotel').' : </span><span>';
                        $printBoxCheck .= $info['hotel_address'];
                        $printBoxCheck .= '</span>
                                </div>
                                <div style="width: 45%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;">
                                    <span style="font-weight: bold;">'.functions::Xmlinformation('timeEnteringRoom').' : </span><span>';
                        $printBoxCheck .= $info['time_entering_room'];
                        $printBoxCheck .= '</span>
                                </div>
                            </div>';
                    } else {
                        $printBoxCheck .= '
                            <div class="row" style="padding: 8px;margin: 0;">
                                <div style="width: 90%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;">
                                    <span style="font-weight: bold;">'.functions::Xmlinformation('Addresshotel').' : </span><span>';
                        $printBoxCheck .= $info['hotel_address'];
                        $printBoxCheck .= '</span>
                                </div>
                            </div>';
                    }


                    $printBoxCheck .= '
                            </div>';
	                
                    $title = functions::Xmlinformation('Informationguest');
                    if($info['type_application'] == 'api'){
                    	$title .= '('.functions::Xmlinformation('FirstRoomPassenger').')';
                    }
                    $printBoxCheck .= '
                            <div style="border: 1px solid #2E3231;margin: 5px 40px 5px 40px;">
                              <div class="row" style="padding: 8px;margin: 0;ont: inherit;vertical-align: baseline;">
                                  <div class="col-md-12 modal-text-center modal-h"
                                      style="text-align: center;font-size: 18px !important;width: 100%;font-weight: bold;">
                                                <span>'.$title.'</span>
                                  </div>
                              </div> ';

                }
	            
                if ($info['type_application'] == 'reservation') {

                    if ($info['flat_type'] == 'DBL') {
                        $flatType = functions::Xmlinformation('Themainbed');

                    } elseif ($info['flat_type'] == 'EXT') {
                        $flatType = functions::Xmlinformation('ExtrabedAdult');

                    } elseif ($info['flat_type'] == 'ECHD') {
                        $flatType = functions::Xmlinformation('Extrabedchild');
                    }

                    $printBoxCheck .= '
                       <div class="row" style="padding: 8px;margin: 0;">
                            <div style="width: 16.666667%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">'.functions::Xmlinformation('Room').' : </span><span>';
                    $printBoxCheck .= $info['room_name'];
                    $printBoxCheck .= '</span>
                            </div>
                            <div style="width: 16.666667%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">'.functions::Xmlinformation('ّFlat').' : </span><span>';
                    $printBoxCheck .= $flatType;
                    $printBoxCheck .= '</span>
                        </div>
                            <div style="width: 16.666667%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">'.functions::Xmlinformation('Name').' :</span><span>';
                    if (!empty($info['passenger_name'])) {
                        $printBoxCheck .= $info['passenger_name'] . ' ' . $info['passenger_family'];
                    } elseif (!empty($info['passenger_name_en'])) {
                        $printBoxCheck .= $info['passenger_name_en'] . ' ' . $info['passenger_family_en'];
                    }
                    
                    $printBoxCheck .= '</span>
                            </div>
                            <div style="width: 16.666667%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;">';

//                    if ($info['passenger_national_code'] != "") {
//                        $printBoxCheck .= '<span style="font-weight: bold;">'.functions::Xmlinformation('NationalCode').':</span><span>';
//                        $printBoxCheck .= $info['passenger_national_code'];
//                        $printBoxCheck .= '</span>';
//                    } else {
//                        $printBoxCheck .= '<span style="font-weight: bold;">'.functions::Xmlinformation('Numpassport').':</span><span>';
//                        $printBoxCheck .= $info['passportNumber'];
//                        $printBoxCheck .= '</span>';
//                    }

                    $printBoxCheck .= '</div>
                            <div style="width: 16.666667%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">'.functions::Xmlinformation('DateOfBirth').': </span><span>';

                    if ($info['passenger_birthday'] != "") {
                        $printBoxCheck .= $info['passenger_birthday'];
                    } else {
                        $printBoxCheck .= $info['passenger_birthday_en'];
                    }

                    $printBoxCheck .= '</span>
                            </div>
                        </div>';

                } elseif($info['type_application'] == 'externalApi'){
	
	
	                $printBoxCheck .= '
                       <div class="row" style="padding: 8px;margin: 0;">
                            <div style="width: 40%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">';
	                $printBoxCheck .= functions::StrReplaceInXml(['@@index@@'=>($info['room_index']+1)],'IndexOfRoom');
	                $printBoxCheck .= ' : </span><span>';
	                $printBoxCheck .= $info['room_name'];
	               
	                $printBoxCheck .= '</span>
                            </div>
                            <div style="width: 40%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">'.functions::Xmlinformation('Namefamily').' :</span><span>';
	                $printBoxCheck .= $info['passenger_name_en'] . ' ' . $info['passenger_family_en'];
	                
	                $printBoxCheck .= '</span>
                            </div>';
//	                $printBoxCheck .= '<div style="width: 22%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;">';
//	                if ($info['passenger_national_code'] != "") {
//		                $printBoxCheck .= '<span style="font-weight: bold;">'.functions::Xmlinformation('NationalCode').':</span><span>';
//		                $printBoxCheck .= $info['passenger_national_code'];
//		                $printBoxCheck .= '</span>';
//	                } else {
//		                $printBoxCheck .= '<span style="font-weight: bold;">'.functions::Xmlinformation('Numpassport').':</span><span>';
//		                $printBoxCheck .= $info['passportNumber'];
//		                $printBoxCheck .= '</span>';
//	                }
	                $printBoxCheck .= '<!--</div>-->
                           <!--<div style="width: 22%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;">
                           <span style="font-weight: bold;">'.functions::Xmlinformation('DateOfBirth').': </span>
                           <span>-->';
//
//	                if ($info['passenger_birthday'] != "") {
//		                $printBoxCheck .= $info['passenger_birthday'];
//	                } else {
//		                $printBoxCheck .= $info['passenger_birthday_en'];
//	                }
//
	                $printBoxCheck .= '<!--</span>
                           </div>-->
                        </div>';
                }else{
	                $printBoxCheck .= '
                       <div class="row" style="padding: 8px;margin: 0;">
                            <div style="width: 22%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">'.functions::Xmlinformation('Room').': </span><span>';
	                $printBoxCheck .= $info['room_name'];
	                $printBoxCheck .= '</span>
                            </div>
                            <div style="width: 22%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">'.functions::Xmlinformation('Namefamily').': :</span><span>';
	                $printBoxCheck .= $info['passenger_name'] . ' ' . $info['passenger_family'];
	                $printBoxCheck .= '</span>
                            </div>';
	                $printBoxCheck .= '<div style="width: 22%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;">';
	                if ($info['passenger_national_code'] != "") {
		                $printBoxCheck .= '<span style="font-weight: bold;">'.functions::Xmlinformation('NationalCode').':</span><span>';
		                $printBoxCheck .= $info['passenger_national_code'];
		                $printBoxCheck .= '</span>';
	                } else {
		                $printBoxCheck .= '<span style="font-weight: bold;">'.functions::Xmlinformation('Numpassport').':</span><span>';
		                $printBoxCheck .= $info['passportNumber'];
		                $printBoxCheck .= '</span>';
	                }
	                $printBoxCheck .= '</div>
                            <div style="width: 22%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">'.functions::Xmlinformation('DateOfBirth').': </span><span>';
	
	                if ($info['passenger_birthday'] != "") {
		                $printBoxCheck .= $info['passenger_birthday'];
	                } else {
		                $printBoxCheck .= $info['passenger_birthday_en'];
	                }
	
	                $printBoxCheck .= '</span>
                            </div>
                        </div>';
                }
            }

            $printBoxCheck .= '</div>';


            if ($info_hotel[0]['type_application'] == 'reservation' && $info_hotel[0]['origin'] != '') {

                $printBoxCheck .= '
                    <div style="border: 1px solid #2E3231;margin: 5px 40px 5px 40px;">
                              <div class="row" style="padding: 8px;margin: 0;ont: inherit;vertical-align: baseline;">
                                  <div class="col-md-12 modal-text-center modal-h"
                                      style="text-align: center;font-size: 18px !important;width: 100%;font-weight: bold;">
                                                <span>'.functions::Xmlinformation('Informationtravel').'</span>
                                  </div>
                              </div> ';

                $printBoxCheck .= '
                       <div class="row" style="padding: 8px;margin: 0;">
                            <div style="width: 22%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">'.functions::Xmlinformation('Destination').': </span><span>';
                $printBoxCheck .= '</span>
                            </div>
                            <div style="width: 22%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">'.functions::Xmlinformation('Origin').': </span><span>';
                $printBoxCheck .= $info_hotel[0]['origin'];
                $printBoxCheck .= '</span>
                            </div>';
                $printBoxCheck .= '</div>';

                $printBoxCheck .= '
                       <div class="row" style="padding: 8px;margin: 0;">
                            <div style="width: 22%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">'.functions::Xmlinformation('NameTransport').': </span><span>';
                $printBoxCheck .= $info_hotel[0]['airline_went'];
                $printBoxCheck .= '</span>
                            </div>
                            <div style="width: 22%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">'.functions::Xmlinformation('Nameflight').' : </span><span>';
                $printBoxCheck .= $info_hotel[0]['flight_number_went'];
                $printBoxCheck .= '</span>
                            </div>
                            <div style="width: 22%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">'.functions::Xmlinformation('Starttime').': </span><span>';
                $printBoxCheck .= $info_hotel[0]['hour_went'];
                $printBoxCheck .= '</span>
                            </div>
                            <div style="width: 22%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">'.functions::Xmlinformation('Datetravelwent').': </span><span>';
                $printBoxCheck .= $info_hotel[0]['flight_date_went'];
                $printBoxCheck .= '</span>
                            </div>
                        </div>';

                $printBoxCheck .= '
                       <div class="row" style="padding: 8px;margin: 0;">
                            <div style="width: 22%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">'.functions::Xmlinformation('NameTransport').': </span><span>';
                $printBoxCheck .= $info_hotel[0]['airline_back'];
                $printBoxCheck .= '</span>
                            </div>
                            <div style="width: 22%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">'.functions::Xmlinformation('Nameflight').' : </span><span>';
                $printBoxCheck .= $info_hotel[0]['flight_number_back'];
                $printBoxCheck .= '</span>
                            </div>
                            <div style="width: 22%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">'.functions::Xmlinformation('Returntime').' : </span><span>';
                $printBoxCheck .= $info_hotel[0]['hour_back'];
                $printBoxCheck .= '</span>
                            </div>
                            <div style="width: 22%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">'.functions::Xmlinformation('Returndate').' : </span><span>';
                $printBoxCheck .= $info_hotel[0]['flight_date_back'];
                $printBoxCheck .= '</span>
                            </div>
                        </div>';


                $printBoxCheck .= '</div>';
            }

            $resultHotelLocal = Load::controller('resultHotelLocal');
            $listOneDayTour = $resultHotelLocal->getInfoReserveOneDayTour($factorNumber);
            if ($info_hotel[0]['type_application'] == 'reservation' && $listOneDayTour != '') {
                foreach ($listOneDayTour as $val) {

                    $printBoxCheck .= '
                    <div style="border: 1px solid #2E3231;margin: 5px 40px 5px 40px;">
                              <div class="row" style="padding: 8px;margin: 0;ont: inherit;vertical-align: baseline;">
                                  <div class="col-md-12 modal-text-center modal-h"
                                      style="text-align: center;font-size: 18px !important;width: 100%;font-weight: bold;">
                                                <span>'.functions::Xmlinformation('OneDayTourDetail').'</span>
                                  </div>
                              </div> ';

                    $printBoxCheck .= '
                       <div class="row" style="padding: 8px;margin: 0;">
                            <div style="width: 60%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">'.functions::Xmlinformation('Title').' : </span><span>';
                    $printBoxCheck .= $val['title'];
                    $printBoxCheck .= '</span>
                            </div>
                            <div style="width: 30%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">'.functions::Xmlinformation('Price').' : </span><span>';
                    $printBoxCheck .= $val['price'];
                    $printBoxCheck .= '</span>
                            </div>';
                    $printBoxCheck .= '</div>';

                    $printBoxCheck .= '</div>';

                }
            }

            if (isset($cancelStatus) && $cancelStatus != '') {

                $objCancel = Load::controller('cancelBuy');
                $resultCancel = $objCancel->cancelReportBuyByFactorNumber('hotel', $factorNumber);

                /*$printBoxCheck .='
                <div class="divborder" style="margin: 10px 100px;">
                    <div style="font-size: 19px ; color: #006cb5; margin-top: -20px;text-align: center;" class="divborderPoint"> توضیحات</div>
                    <table width="100%" align="center" cellpadding="5" cellspacing="0" style="margin: 10px;">
                        <tr>
                            <td class="cancellationPolicy-title" colspan="6" style="font-size: 20px; font-weight: 700;">رزرو هتل فوق در تاریخ ' . $resultCancel['cancelled_date'] . ' ' . $resultCancel['cancelled_time'] . ' با درصد ' . $resultCancel['cancel_percent'] . ' و مبلغ ' . $resultCancel['cancel_price'] . ' ریال کنسل شده است.</td>
                        </tr>
                    </table>
                </div>';*/


                $printBoxCheck .= '
                            <br>
                            <br>
                            <div style="border: 1px solid #2E3231;margin: 5px 40px 5px 40px;">';
                $printBoxCheck .= '
                            <div class="row" style="padding: 8px;font-weight: bold;background-color: #2E3231;margin: 0;color: #fff;">
        
                                <div style="width: 90%;position: relative;float: '.$right.';min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;box-sizing: border-box;">
                                    <span style="font-weight: bold;">'.functions::Xmlinformation('Description').'</span><span>';
                $printBoxCheck .= '</span>
                                </div>
       
                            </div>';

                $printBoxCheck .= '
                            <div class="row" style="padding: 8px;margin: 0;">
                                <div style="width: 90%;float: '.$right.';position: relative;min-height: 1px;padding-'.$right.': .9375rem;padding-'.$left.': .9375rem;der-box;">
                                    <span>';
                $printBoxCheck .= 'رزرو هتل فوق در تاریخ ' . $resultCancel['cancelled_date'] . ' ' . $resultCancel['cancelled_time'] . ' با درصد ' . $resultCancel['cancel_percent'] . ' و مبلغ ' . $resultCancel['cancel_price'] . ' ریال کنسل شده است.';
                $printBoxCheck .= '</span>
                                </div>
                            </div>';


                $printBoxCheck .= '</div>';

                $printBoxCheck .= '
                     </div>
                 <br/>';

            } else {
            	if($info_hotel[0]['type_application'] == 'externalApi' && SOFTWARE_LANG == 'en'){
		            $hotelLocation = json_decode($info_hotel[0]['hotel_location'],true);
		            $location = '';
		            $location = implode(',',$hotelLocation);
		            
		            $printBoxCheck .= "<div style=\"width: 93%;margin: 5px 40px 5px 40px;\">";
		            $printBoxCheck .= "<strong style='float:{$right}; width: 25%'>Location</strong>";
		            $printBoxCheck .= "<div style='float:{$right}; width: 73%'><a style='text-decoration: none' target='_blank' href='http://maps.google.com/maps?q={$location}&ll={$location}z=19'>{$location}</a></div>";
		            $printBoxCheck .= "</div>";
		            
		            $printBoxCheck .= "<div style=\"width: 93%;margin: 5px 40px 5px 40px;\">";
		            $printBoxCheck .= "<strong style='float:{$right}; width: 25%'>Min Age</strong>";
		            $printBoxCheck .= "<div style='float:{$right}; width: 73%'>18</div>";
		            $printBoxCheck .= "</div>";
            		$extraHotelDetails = json_decode($info_hotel[0]['extra_hotel_details'],true);
            		
//            		$printBoxCheck .= $extraHotelDetails;
		            foreach ($extraHotelDetails as $key=>$detail) {
		            	$detailTitle = functions::Xmlinformation($key);
	                    $printBoxCheck .= "<h2 style=\"font-size: 14px;display: block;text-align: '.$right.';margin: 10px 40px 0px 40px;font-weight:bold\">
	                        <span>{$key}</span>
	                    </h2>";
	                    $printBoxCheck .= "<div style=\"width: 93%;margin: 5px 40px 5px 40px;\">{$detail}</div>";
	                    
	                }
	            }

                $printBoxCheck .= '
                     </div>
                 <br/>';
//	            $printBoxCheck .= '
//                    <h2 style="font-size: 14px;display: block;text-align: '.$right.';margin: 10px 40px 0px 40px;font-weight:bold">
//                        <span>'.functions::Xmlinformation('RespectableTravelerIsRequest').'</span>
//                    </h2>
//
//                    <div style="width: 93%;margin: 5px 40px 5px 40px;">
//                        <p style="padding-'.$right.': 8px;">'.functions::Xmlinformation('NeedBirthCertificateHotel').'</p>
//                        <p style="padding-'.$right.': 8px;">'.functions::Xmlinformation('HoursOfDeliveryAndEvacuationOfTheRoom').'</p>
//                        <p style="padding-'.$right.': 8px;">'.functions::Xmlinformation('VarietyHotelNoObligationProvide').'</p>
//                        <p style="padding-'.$right.': 8px;">'.functions::Xmlinformation('DepartureBasedPassengerRequest').'</p>
//                        <p style="padding-'.$right.': 8px;">'.functions::Xmlinformation('CancellationHotelReservationAmountNoRefundable').'</p>
//                    </div>';
            
                      $printBoxCheck .= '<div class="clear-both">';


            }

            $printBoxCheck .= '</div>';

            $printBoxCheck.='
                <div style="margin: 550px 950px 0px 100px ; width: 90%">';
            if($StampAgency != ROOT_ADDRESS_WITHOUT_LANG.'/pic/'){
                $printBoxCheck.='<img src="'.$StampAgency.'" height="100" style="max-width: 230px;">';}
            $printBoxCheck.='</div>';

            $printBoxCheck .= '
            
                    <hr/>
            
                    <div style="width:100%; text-align : center ; ">
                        <div style="width: 45%; float:'.$right.' ;margin: 0px 30px;text-align:'.$right.'">'.functions::Xmlinformation('Website').': <div style="direction: ltr; display: inline-block;text-align:'.$right.'">';
            $printBoxCheck .= CLIENT_MAIN_DOMAIN;
//            $printBoxCheck .= 'flymurshid.com';
            $printBoxCheck .= '</div>
                    </div>
                    <div style="width: 45%; float:'.$right.' ; margin: 0px 30px;text-align:'.$right.'">
                        '.functions::Xmlinformation('Telephone').' : <div style="direction: ltr; display: inline-block;text-align:'.$right.'">';
            $printBoxCheck .= CLIENT_PHONE;
            $printBoxCheck .= '</div>
                    </div>
                    
        
                    </div>
            
                    <div class="clear-both"></div>
            
                    </div>';


        } else {
            $printBoxCheck = '<div style="text-align:center ; fon-size:20px ;font-family: Yekan;">'.functions::Xmlinformation('DetailNotFound').'</div>';
        }

        $printBoxCheck .= ' </div>
                                </body>
                </html> ';


        return $printBoxCheck;
    }

    public function ReduceCapacity($user_type, $factorNumber, $type)
    {
        $Model = Load::library('Model');

        $sqlBook = "SELECT 
                        room_id, flat_type, roommate, hotel_id, start_date, end_date 
                    FROM book_hotel_local_tb WHERE factor_number='{$factorNumber}'";
        $HotelRoom = $Model->select($sqlBook);

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
                $HotelRoom = $Model->select($sql);
                foreach ($HotelRoom as $room) {
                    if ($type == 'Increase') {
                        $remaining_capacity = $room['remaining_capacity'] - 1;
                        $full_capacity = $room['full_capacity'] + 1;
                    } else if ($type == 'Decrease') {
                        $remaining_capacity = $room['remaining_capacity'] + 1;
                        $full_capacity = $room['full_capacity'] - 1;
                    }

                    $data['remaining_capacity'] = $remaining_capacity;
                    $data['full_capacity'] = $full_capacity;

                    $condition = " id='{$room['id']}' ";
                    $Model->setTable('reservation_hotel_room_prices_tb');
                    $res[] = $Model->update($data, $condition);

                }
            }


        }

        if (in_array('0', $res)) {
            return 'error';
        } else {
            return 'success';
        }


    }

    public  function getBookHotelByFactorNumber($factorList) {
        $bookHotelLocalModel = Load::getModel('bookHotelLocalModel');

        return $bookHotelLocalModel->get('*')->whereIn('factor_number',$factorList)
            ->groupBy('factor_number')->all();
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