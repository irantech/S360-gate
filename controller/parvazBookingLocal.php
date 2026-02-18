<?php
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');


class parvazBookingLocal extends apiLocal
{

    public $categoryNum = '';
    public $print = '';              /* this variable includes HTML cod for print */
    public $ticketPassengerInfo;   /* information about passenger */
    public $ticketPrice;   /* information about ticket price */
    public $ticketDeptFlights;  /* information about departure flight */
    public $ticketReturnFlights; /* information about return flight */
    public $rules;     /* information about rules */
    public $farePrice = 0;
    public $totalPrice = 0;
    public $airlineName;   /* airline name */
    public $trackingCode;
    public $transactionStatus;
    public $ok_flight;
    public $factor_num;
    public $adt_price;
    public $chd_price;
    public $inf_price;
    public $payment_type;
    public $payment_date;
    public $request_number;
    public $factorNumberPrint;
    public $direction;
    public $ticketInfo;
    public $IsInternal;
    public $MessagSource10;

    public $transactions;

    /**
     * Initialization public variable amadeus token
     * @author Anari
     */
    public function __construct()
    {

        parent::__construct();
        $this->payment_type = isset($_POST['flag']) ? $_POST['flag'] : '';

        $this->transactions = $this->getModel('transactionsModel');
    }

    public function updateBank($codRahgiri, $categoryNum)
    {
        /** @var book_local_tb $model */
        $model = Load::model('book_local');
        $model->updateBank($codRahgiri, $categoryNum);
    }

    public function flightBook($FactorNumber, $payType = null)
    {
        /**
         * این کامنت ها برای جابجایی در بین فانکشن ها و کلاسها از طریق PHPstorm کاربرد دارد. لطفا حذف نفرمایید :-D
         *
         * @var Model $model
         * @var ModelBase $ModelBase
         * @var smsServices $smsController
         * @var transaction $objTransaction
         */
        $model = Load::library('Model');
        $model->setTable('book_local_tb');
        $ModelBase = Load::library('ModelBase');
        $objTransaction = Load::controller('transaction');
        $smsController = Load::controller('smsServices');
//    $accountcharge = Load::controller('accountcharge');

        $get_current_transaction = $this->getController('transaction')->findTransactionByFactorNumber($FactorNumber);
        $parent_id = PARENT_ID ;

        $sql = "SELECT * FROM book_local_tb WHERE factor_number = '{$FactorNumber}' GROUP BY direction";
        $resultDirection = $model->select($sql);

        foreach ($resultDirection as $eachDirection) {
            $this->direction[$eachDirection['direction']] = $eachDirection['direction'];
            $this->ticketInfo[$eachDirection['direction']] = $eachDirection;
            $this->factor_num = $eachDirection['factor_number'];
            $this->IsInternal = $eachDirection['IsInternal'];
            $this->request_number[$eachDirection['direction']] = $eachDirection['request_number'];
            if($eachDirection['successfull'] !='book'){
                $get_credit_current_agency = $this->getController('creditDetail')->findCreditRecode($eachDirection['request_number']);

                if (isset($eachDirection['direction']) && $eachDirection['direction'] == 'dept' || ($eachDirection['direction'] == 'return' && $this->ok_flight['dept'] == true)) {



                    $check_private = ($eachDirection['pid_private'] == '1') ? 'private' : 'public';
//            $checkPrivateForeign = functions::checkPrivateAirlineForeign($eachDirection['airline_iata']);

                    if ($eachDirection['IsInternal'] == '1') {
                        try {
                            $checkForSourceFive = false ;
                            if($eachDirection['flight_type'] == 'system'){
                                $checkForSourceFive = $this->checkForSourceFive($eachDirection);
                            }

                            if ($check_private == 'private'
                                && $eachDirection['flight_type'] == 'system'
                                && (($eachDirection['api_id'] == '8') || $eachDirection['api_id'] == '13') && $checkForSourceFive) {

                                if ($get_current_transaction['PaymentStatus']=='pending') {
                                    // Caution: آپدیت تراکنش به موفق
                                    $objTransaction->setCreditToSuccess($eachDirection['factor_number'], $eachDirection['tracking_code_bank']);
                                }

                                if(empty($get_credit_current_agency) && $payType == 'credit') {
                                    $this->decreaseCreditThatNotExist($eachDirection);
                                }


//                        if($parent_id > 1)
//                        {
//                            $objTransaction->calculateProfitClient($eachDirection,'Flight');
//                        }

                                $query = "SELECT * FROM book_local_tb WHERE request_number = '{$eachDirection['request_number']}'";
                                $ticketsCurrent = $model->select($query);
                                foreach ($ticketsCurrent as $i => $privateTicket) {
                                    $data['successfull'] = 'book';
                                    $data['payment_date'] = Date('Y-m-d H:i:s');

                                    if ($payType == 'credit') {
                                        $data['payment_type'] = 'credit';
                                    } elseif ($ticketsCurrent[$i]['tracking_code_bank'] == 'member_credit') {
                                        $data['payment_type'] = 'member_credit';
                                        $data['tracking_code_bank'] = '';
                                    } else {
                                        $data['payment_type'] = 'cash';
                                    }

                                    $data['pnr'] = 'PN57';
                                    $data['eticket_number'] = 'TE57';

                                    if ($ticketsCurrent[$i]['passenger_national_code'] != '0000000000') {
                                        $uniqCondition = " AND passenger_national_code = '{$ticketsCurrent[$i]['passenger_national_code']}' ";
                                    } else {
                                        $uniqCondition = " AND passportNumber = '{$ticketsCurrent[$i]['passportNumber']}' ";
                                    }

                                    $condition = " request_number = '{$eachDirection['request_number']}' " . $uniqCondition;
                                    if (empty($eachDirection['pnr']) && empty($eachDirection['eticket_number'])) {
                                        $res = $model->update($data, $condition);
                                    }
                                    if (isset($res) && $res) {
                                        $data['successfull'] = 'private_reserve';
                                        $data['private_m4'] = '1';
                                        $ModelBase->setTable('report_tb');
                                        $conditionBase = " request_number = '{$eachDirection['request_number']}' " . $uniqCondition;
                                        if (empty($eachDirection['pnr']) && empty($eachDirection['eticket_number'])) {
                                            $ModelBase->update($data, $conditionBase);
                                        }
                                        $this->ok_flight[$eachDirection['direction']] = true;
                                        $this->payment_date = $data['payment_date'];

//                                $this->getController('servicesDiscount')->updateSpecialDiscountUsed($eachDirection['factor_number']);

                                        /*todo : Accountant api will be added here*/
//                                functions::accountantRequestInsertData($eachDirection['request_number']);

                                    }
                                }
                                $ServerName = '';
                                switch ($eachDirection['api_id']) {
                                    case '8':
                                        $ServerName = 'سرور7';
                                        break;
                                    case '13':
                                        $ServerName = 'سرور13';
                                        break;
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
                                if (empty($eachDirection['pnr']) && empty($eachDirection['eticket_number'])) {

                                    //sms to our supports
                                    $objSms = $smsController->initService('1');
                                    if ($objSms) {
                                        $date = dateTimeSetting::jdate("Y-F-d", functions::ConvertToDateJalaliInt($eachDirection['date_flight']));
                                        $sms = "{$ServerName} -" . CLIENT_NAME . "-{$eachDirection['airline_name']}-{$date}";
                                        $cellArray = array(
                                            'afshar' => '09123493154',
                                            'fanipor' => '09129409530',
                                            'araste' => '09211559872',
                                            'afraze' => '09916211232',
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
                                    $this->emailTicketSelf($eachDirection['request_number']);

                                    //sms to buyer
                                    $objSms = $smsController->initService('0');
                                    if ($objSms) {
                                        //to member
                                        $messageVariables = array(
                                            'sms_name' => $eachDirection['member_name'],
                                            'sms_service' => 'بلیط',
                                            'sms_factor_number' => $eachDirection['request_number'],
                                            'sms_airline' => $eachDirection['airline_name'],
                                            'sms_origin' => $eachDirection['origin_city'],
                                            'sms_destination' => $eachDirection['desti_city'],
                                            'sms_flight_number' => $eachDirection['flight_number'],
                                            'sms_flight_date' => dateTimeSetting::jdate("Y-F-d", functions::ConvertToDateJalaliInt($eachDirection['date_flight'])),
                                            'sms_flight_time' => $eachDirection['time_flight'],
                                            'sms_pdf' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=parvazBookingLocal&id=" . $eachDirection['request_number'],
                                            'sms_agency' => CLIENT_NAME,
                                            'sms_agency_mobile' => CLIENT_MOBILE,
                                            'sms_agency_phone' => CLIENT_PHONE,
                                            'sms_agency_email' => CLIENT_EMAIL,
                                            'sms_agency_address' => CLIENT_ADDRESS,
                                            'sms_site_url' => CLIENT_MAIN_DOMAIN
                                        );
                                        $smsArray = array(
                                            'smsMessage' => $smsController->getUsableMessage('afterTicketReserve', $messageVariables),
                                            'cellNumber' => $eachDirection['member_mobile'],
                                            'smsMessageTitle' => 'afterTicketReserve',
                                            'memberID' => (!empty($eachDirection['member_id']) ? $eachDirection['member_id'] : ''),
                                            'receiverName' => $messageVariables['sms_name'],
                                        );
                                        $smsController->sendSMS($smsArray);

                                        //to manager
                                        $smsArray = array(
                                            'smsMessage' => $smsController->getUsableMessage('afterReserveToManager', $messageVariables),
                                            'cellNumber' => CLIENT_MOBILE,
                                            'smsMessageTitle' => 'afterReserveToManager',
                                            'memberID' => (!empty($eachDirection['member_id']) ? $eachDirection['member_id'] : ''),
                                            'receiverName' => 'مدیر سایت',
                                        );
                                        $smsController->sendSMS($smsArray);

                                        //to first passenger
                                        $messageVariables['sms_name'] = $eachDirection['passenger_name'] . ' ' . $eachDirection['passenger_family'];
                                        $smsArray = array(
                                            'smsMessage' => $smsController->getUsableMessage('afterTicketReserve', $messageVariables),
                                            'cellNumber' => $eachDirection['mobile_buyer'],
                                            'smsMessageTitle' => 'afterTicketReserve',
                                            'memberID' => (!empty($eachDirection['member_id']) ? $eachDirection['member_id'] : ''),
                                            'receiverName' => $messageVariables['sms_name'],
                                        );
                                        $smsController->sendSMS($smsArray);
                                    }
                                }
                            }

                            else {
                                $ReserveTicket = parent::Reserve($eachDirection['request_number'], $eachDirection['api_id']);
                                if ($ReserveTicket['Result']['Request']['Status'] == 'Ticketed' && !empty($ReserveTicket)) {
                                    if (!empty($ReserveTicket['Result']['Request']['RequestPassengers'])) {
                                        if ($get_current_transaction['PaymentStatus']=='pending') {
                                            // Caution: آپدیت تراکنش به موفق
                                            $objTransaction->setCreditToSuccess($eachDirection['factor_number'], $eachDirection['tracking_code_bank']);
                                        }

                                        if(empty($get_credit_current_agency) && $payType == 'credit') {
                                            $this->decreaseCreditThatNotExist($eachDirection);
                                        }

//                                if($parent_id > 1)
//                                {
//                                    $objTransaction->calculateProfitClient($eachDirection,'Flight');
//                                }

                                        $query = "SELECT * FROM book_local_tb WHERE request_number = '{$eachDirection['request_number']}'";
                                        $ticketsCurrent = $model->select($query);
                                        foreach ($ticketsCurrent as $i => $Ticket) {
                                            $data['successfull'] = 'book';
                                            $data['payment_date'] = Date('Y-m-d H:i:s');

                                            if ($payType == 'credit') {
                                                $data['payment_type'] = 'credit';
                                            } elseif ($ticketsCurrent[$i]['tracking_code_bank'] == 'member_credit') {
                                                $data['payment_type'] = 'member_credit';
                                                $data['tracking_code_bank'] = '';
                                            } else {
                                                $data['payment_type'] = 'cash';
                                            }

                                            $data['pnr'] = $ReserveTicket['Result']['Request']['OutputRoutes'][0]['AirlinePnr'];
                                            $data['eticket_number'] = $ReserveTicket['Result']['Request']['RequestPassengers'][$i]['TicketNumber'];

                                            if ($ticketsCurrent[$i]['passenger_national_code'] != '0000000000') {
                                                $uniqCondition = " AND passenger_national_code = '{$ticketsCurrent[$i]['passenger_national_code']}' ";
                                            } else {
                                                $uniqCondition = " AND passportNumber = '{$ticketsCurrent[$i]['passportNumber']}' ";
                                            }

                                            $condition = " request_number = '{$eachDirection['request_number']}' " . $uniqCondition;
                                            $res = $model->update($data, $condition);

                                            if ($res) {
                                                $statusTicket = ($eachDirection['pid_private'] == '1') ? 'private_reserve' : 'book';
                                                $data['successfull'] = $statusTicket;
                                                $ModelBase->setTable('report_tb');
                                                $conditionBase = " request_number = '{$eachDirection['request_number']}' " . $uniqCondition;
                                                $ModelBase->update($data, $conditionBase);
                                            }
                                            $this->ok_flight[$eachDirection['direction']] = true;
                                            $this->payment_date = $data['payment_date'];

                                        }
//                                $this->getController('servicesDiscount')->updateSpecialDiscountUsed($eachDirection['factor_number']);
                                        /*todo : insert data to the Accountant with API*/
//	                            functions::accountantRequestInsertData($eachDirection['request_number']);

//                                    if ($eachDirection['api_id'] == '1' || $eachDirection['api_id'] == '11') {
//
//                                        $SourceName = '';
//
//                                        switch ($eachDirection['api_id']) {
//                                            case '1':
//                                                $SourceName = 'سرور5';
//                                                break;
//                                            case '11':
//                                                $SourceName = 'سرور10';
//                                                break;
//                                        }
//
//                                        //sms to our supports
//                                        $objSms = $smsController->initService('1');
//                                        if ($objSms) {
//                                            $date = dateTimeSetting::jdate("Y-F-d", functions::ConvertToDateJalaliInt($eachDirection['date_flight']));
//                                            $sms = "{$SourceName} -" . CLIENT_NAME . "-{$eachDirection['airline_name']}-{$date}";
//                                            $cellArray = array(
//                                                'afshar' => '09123493154',
//                                                'moqadam' => '09355501074',
//                                                'fanipor' => '09129409530',
//                                                'afraze' => '09214985139',
//
//
//                                            );
//                                            foreach ($cellArray as $cellNumber) {
//                                                $smsArray = array(
//                                                    'smsMessage' => $sms,
//                                                    'cellNumber' => $cellNumber
//                                                );
//                                                $smsController->sendSMS($smsArray);
//                                            }
//                                        }
//                                    }

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

                                        //email to buyer
                                        $this->emailTicketSelf($eachDirection['request_number']);

                                        //sms to buyer
                                        $objSms = $smsController->initService('0');
                                        if ($objSms) {
                                            //to member
                                            $messageVariables = array(
                                                'sms_name' => $eachDirection['member_name'],
                                                'sms_service' => 'بلیط',
                                                'sms_factor_number' => $eachDirection['request_number'],
                                                'sms_airline' => $eachDirection['airline_name'],
                                                'sms_origin' => $eachDirection['origin_city'],
                                                'sms_destination' => $eachDirection['desti_city'],
                                                'sms_flight_number' => $eachDirection['flight_number'],
                                                'sms_flight_date' => dateTimeSetting::jdate("Y-F-d", functions::ConvertToDateJalaliInt($eachDirection['date_flight'])),
                                                'sms_flight_time' => $eachDirection['time_flight'],
                                                'sms_pdf' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=parvazBookingLocal&id=" . $eachDirection['request_number'],
                                                'sms_agency' => CLIENT_NAME,
                                                'sms_agency_mobile' => CLIENT_MOBILE,
                                                'sms_agency_phone' => CLIENT_PHONE,
                                                'sms_agency_email' => CLIENT_EMAIL,
                                                'sms_agency_address' => CLIENT_ADDRESS,
                                                'sms_site_url' => CLIENT_MAIN_DOMAIN
                                            );
                                            $smsArray = array(
                                                'smsMessage' => $smsController->getUsableMessage('afterTicketReserve', $messageVariables),
                                                'cellNumber' => $eachDirection['member_mobile'],
                                                'smsMessageTitle' => 'afterTicketReserve',
                                                'memberID' => (!empty($eachDirection['member_id']) ? $eachDirection['member_id'] : ''),
                                                'receiverName' => $messageVariables['sms_name'],
                                            );
                                            $smsController->sendSMS($smsArray);

                                            //to manager
                                            $smsArray = array(
                                                'smsMessage' => $smsController->getUsableMessage('afterReserveToManager', $messageVariables),
                                                'cellNumber' => CLIENT_MOBILE,
                                                'smsMessageTitle' => 'afterReserveToManager',
                                                'memberID' => (!empty($eachDirection['member_id']) ? $eachDirection['member_id'] : ''),
                                                'receiverName' => 'مدیر سایت',
                                            );
                                            $smsController->sendSMS($smsArray);

                                            //to first passenger
                                            $messageVariables['sms_name'] = $eachDirection['passenger_name'] . ' ' . $eachDirection['passenger_family'];
                                            $smsArray = array(
                                                'smsMessage' => $smsController->getUsableMessage('afterTicketReserve', $messageVariables),
                                                'cellNumber' => $eachDirection['mobile_buyer'],
                                                'smsMessageTitle' => 'afterTicketReserve',
                                                'memberID' => (!empty($eachDirection['member_id']) ? $eachDirection['member_id'] : ''),
                                                'receiverName' => $messageVariables['sms_name'],
                                            );
                                            $smsController->sendSMS($smsArray);
                                        }
                                    }

                                } else {
                                    if ($payType == 'credit') {

                                        $sql = " SELECT successfull,request_number,factor_number,flight_type FROM book_local_tb WHERE request_number='{$eachDirection['request_number']}'";
                                        $TicketsCreditCheck = $model->load($sql);

                                        if ($TicketsCreditCheck['successfull'] != 'book') {

                                            if ($eachDirection['direction'] == 'dept') {
                                                $this->delete_transaction_current($TicketsCreditCheck['factor_number']);
                                            }

                                            $this->delete_credit_Agency_current($TicketsCreditCheck['request_number']);
                                        }
                                    }

                                    if ($eachDirection['direction'] == 'return') {

                                        $this->changeTransactionInReturnFailure($this->factor_num);

                                    }
                                }
                            }
                        } catch (Exception $e) {

                            $d['message'] = $e->getMessage();
                            $d['creation_date_int'] = time();
                            $d['json_result'] = json_encode($ReserveTicket);
                            $d['request_number'] = $eachDirection['request_number'];

                            $ModelBase->setTable('log_res_action_tb');
                            $ModelBase->insertLocal($d);
                        }
                    }
                    else {
                        $ReserveTicket = parent::Reserve($eachDirection['request_number'], $eachDirection['api_id']);
                        try {
                            if ($ReserveTicket['Result']['Request']['Status'] == 'Ticketed') {
                                if (!empty($ReserveTicket['Result']['Request']['RequestPassengers']) || ($eachDirection['api_id'] == '10')) {
                                    if ($eachDirection['api_id'] == '10') {
                                        error_log('ticket Source 10 OneWay: ' . date('Y/m/d H:i:s') . ' buy ' . ($payType == 'credit' ? 'credit' : 'cash') . ' With RequestNumber : =>' . $eachDirection['request_number'] . ' AND array Equal  =>' . json_encode($ReserveTicket, true) . " \n", 3, LOGS_DIR . 'log_source_10.txt');
                                    }
                                    if ($get_current_transaction['PaymentStatus']=='pending') {
                                        // Caution: آپدیت تراکنش به موفق
                                        $objTransaction->setCreditToSuccess($eachDirection['factor_number'], $eachDirection['tracking_code_bank']);
                                    }

                                    if(empty($get_credit_current_agency) && $payType == 'credit') {
                                        $this->decreaseCreditThatNotExist($eachDirection);
                                    }
//                                   if($parent_id > 1)
//                                   {
//                                       $objTransaction->calculateProfitClient($eachDirection,'Flight');
//                                   }
                                    $query = "SELECT * FROM book_local_tb WHERE request_number = '{$eachDirection['request_number']}'";
                                    $ticketsCurrent = $model->select($query);
                                    foreach ($ticketsCurrent as $i => $Ticket) {
                                        $data['successfull'] = 'book';
                                        $data['payment_date'] = Date('Y-m-d H:i:s');
                                        if ($payType == 'credit') {
                                            $data['payment_type'] = 'credit';
                                        } elseif ($ticketsCurrent[$i]['tracking_code_bank'] == 'member_credit') {
                                            $data['payment_type'] = 'member_credit';
                                            $data['tracking_code_bank'] = '';
                                        } else {
                                            $data['payment_type'] = 'cash';
                                        }

                                        $data['pnr'] = $ReserveTicket['Result']['Request']['OutputRoutes'][0]['AirlinePnr'];
                                        $data['eticket_number'] = !empty($ReserveTicket['Result']['Request']['RequestPassengers']) ? $ReserveTicket['Result']['Request']['RequestPassengers'][$i]['TicketNumber'] : '';


                                        if ($ticketsCurrent[$i]['passenger_national_code'] != '0000000000') {
                                            $uniqCondition = " AND passenger_national_code = '{$ticketsCurrent[$i]['passenger_national_code']}' ";
                                        } else {
                                            $uniqCondition = " AND passportNumber = '{$ticketsCurrent[$i]['passportNumber']}' ";
                                        }

                                        $condition = " request_number = '{$eachDirection['request_number']}' " . $uniqCondition;
                                        $res = $model->update($data, $condition);

                                        if ($res) {
                                            $data['private_m4'] = '3';
                                            $ModelBase->setTable('report_tb');
                                            $conditionBase = " request_number = '{$eachDirection['request_number']}' " . $uniqCondition;
                                            $ModelBase->update($data, $conditionBase);



                                        }
                                        $this->ok_flight[$eachDirection['direction']] = true;
                                        $this->payment_date = $data['payment_date'];
                                    }
//                                   $this->getController('servicesDiscount')->updateSpecialDiscountUsed($eachDirection['factor_number']);
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

                                    //email to buyer
                                    $this->emailTicketSelf($eachDirection['request_number']);

                                    //sms to buyer
                                    $objSms = $smsController->initService('0');
                                    if ($objSms) {
                                        if (!empty($eachDirection['airline_name'])) {
                                            $airlineName = $eachDirection['airline_name'];
                                        } else {
                                            $airlineNameInfo = functions::InfoAirline($eachDirection['airline_iata']);
                                            $airlineName = $airlineNameInfo['name_fa'];
                                        }

                                        //to member
                                        $messageVariables = array(
                                            'sms_name' => $eachDirection['member_name'],
                                            'sms_service' => 'بلیط',
                                            'sms_factor_number' => $eachDirection['request_number'],
                                            'sms_airline' => $airlineName,
                                            'sms_origin' => $eachDirection['origin_city'],
                                            'sms_destination' => $eachDirection['desti_city'],
                                            'sms_flight_number' => $eachDirection['flight_number'],
                                            'sms_flight_date' => dateTimeSetting::jdate("Y-F-d", functions::ConvertToDateJalaliInt($eachDirection['date_flight'])),
                                            'sms_flight_time' => $eachDirection['time_flight'],
                                            'sms_pdf' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=ticketForeign&id=" . $eachDirection['request_number'],
                                            'sms_agency' => CLIENT_NAME,
                                            'sms_agency_mobile' => CLIENT_MOBILE,
                                            'sms_agency_phone' => CLIENT_PHONE,
                                            'sms_agency_email' => CLIENT_EMAIL,
                                            'sms_agency_address' => CLIENT_ADDRESS,
                                            'sms_site_url' => CLIENT_MAIN_DOMAIN
                                        );
                                        $smsArray = array(
                                            'smsMessage' => $smsController->getUsableMessage('afterTicketReserve', $messageVariables),
                                            'cellNumber' => $eachDirection['member_mobile'],
                                            'smsMessageTitle' => 'afterTicketReserve',
                                            'memberID' => (!empty($eachDirection['member_id']) ? $eachDirection['member_id'] : ''),
                                            'receiverName' => $messageVariables['sms_name'],
                                        );
                                        $smsController->sendSMS($smsArray);

                                        //to manager
                                        $smsArray = array(
                                            'smsMessage' => $smsController->getUsableMessage('afterReserveToManager', $messageVariables),
                                            'cellNumber' => CLIENT_MOBILE,
                                            'smsMessageTitle' => 'afterReserveToManager',
                                            'memberID' => (!empty($eachDirection['member_id']) ? $eachDirection['member_id'] : ''),
                                            'receiverName' => 'مدیر سایت',
                                        );
                                        $smsController->sendSMS($smsArray);

                                        //to first passenger
                                        $messageVariables['sms_name'] = $eachDirection['passenger_name'] . ' ' . $eachDirection['passenger_family'];
                                        $smsArray = array(
                                            'smsMessage' => $smsController->getUsableMessage('afterTicketReserve', $messageVariables),
                                            'cellNumber' => $eachDirection['mobile_buyer'],
                                            'smsMessageTitle' => 'afterTicketReserve',
                                            'memberID' => (!empty($eachDirection['member_id']) ? $eachDirection['member_id'] : ''),
                                            'receiverName' => $messageVariables['sms_name'],
                                        );
                                        $smsController->sendSMS($smsArray);
                                    }
                                }
                            } else {
                                if ($payType == 'credit') {

                                    $sql = " SELECT successfull,request_number,factor_number,flight_type FROM book_local_tb WHERE request_number='{$eachDirection['request_number']}'";
                                    $TicketsCreditCheck = $model->load($sql);

                                    if ($TicketsCreditCheck['successfull'] != 'book') {

                                        if ($eachDirection['direction'] == 'dept') {
                                            $this->delete_transaction_current($TicketsCreditCheck['factor_number']);
                                        }

                                        $this->delete_credit_Agency_current($TicketsCreditCheck['request_number']);
                                    }
                                }
                                if($eachDirection['api_id']=='10')
                                {
                                    $this->MessagSource10 = functions::Xmlinformation('MessageSource10');
                                }
                                if ($eachDirection['direction'] == 'return') {

                                    $this->changeTransactionInReturnFailure($this->factor_num);

                                }
                            }
                        } catch (Exception $e) {

                            $d['message'] = $e->getMessage();
                            $d['creation_date_int'] = time();
                            $d['json_result'] = json_encode($ReserveTicket);
                            $d['request_number'] = $eachDirection['request_number'];

                            $ModelBase->setTable('log_res_action_tb');
                            $ModelBase->insertLocal($d);
                        }

                    }
                }
                else if ($eachDirection['direction'] == 'TwoWay' || $eachDirection['direction'] == 'multi_destination' ) {

                    $this->factor_num = $eachDirection['factor_number'];
                    $this->request_number[$eachDirection['direction']] = $eachDirection['request_number'];
                    $ReserveTicket = parent::Reserve($eachDirection['request_number'], $eachDirection['api_id']);
                    error_log('try show result method ticketed in : ' . date('Y/m/d H:i:s') . ' buy ' . ($payType == 'credit' ? 'credit' : 'cash') . ' With RequestNumber : =>' . $eachDirection['request_number'] . ' AND array Equal  =>' . json_encode($ReserveTicket, true) . " \n", 3, LOGS_DIR . 'log_method_ticketed.txt');
                    try {
                        if ($ReserveTicket['Result']['Request']['Status'] == 'Ticketed') {

                            if (!empty($ReserveTicket['Result']['Request']['RequestPassengers']) || ($eachDirection['api_id'] == '10')) {
                                if ($eachDirection['api_id'] == '10') {
                                    error_log('ticket Source 10 OneWay: ' . date('Y/m/d H:i:s') . ' buy ' . ($payType == 'credit' ? 'credit' : 'cash') . ' With RequestNumber : =>' . $eachDirection['request_number'] . ' AND array Equal  =>' . json_encode($ReserveTicket, true) . " \n", 3, LOGS_DIR . 'log_source_10.txt');
                                }
                                if ($get_current_transaction['PaymentStatus']=='pending') {
                                    // Caution: آپدیت تراکنش به موفق
                                    $objTransaction->setCreditToSuccess($eachDirection['factor_number'], $eachDirection['tracking_code_bank']);
                                }

                                if(empty($get_credit_current_agency) && $payType == 'credit') {
                                    $this->decreaseCreditThatNotExist($eachDirection);
                                }

//                            if($parent_id > 1)
//                            {
//                                $objTransaction->calculateProfitClient($eachDirection,'Flight');
//                            }
                                $query = "SELECT * FROM book_local_tb WHERE request_number = '{$eachDirection['request_number']}'";
                                $ticketsCurrent = $model->select($query);
                                foreach ($ticketsCurrent as $i => $Ticket) {
                                    $data['successfull'] = 'book';
                                    $data['payment_date'] = Date('Y-m-d H:i:s');

                                    if ($payType == 'credit') {
                                        $data['payment_type'] = 'credit';
                                    } elseif ($ticketsCurrent[$i]['tracking_code_bank'] == 'member_credit') {
                                        $data['payment_type'] = 'member_credit';
                                        $data['tracking_code_bank'] = '';
                                    } else {
                                        $data['payment_type'] = 'cash';
                                    }

                                    $data['pnr'] = $ReserveTicket['Result']['Request']['OutputRoutes'][0]['AirlinePnr'];
                                    $data['eticket_number'] = !empty($ReserveTicket['Result']['Request']['RequestPassengers']) ? $ReserveTicket['Result']['Request']['RequestPassengers'][$i]['TicketNumber'] : '';
                                    if ($eachDirection['api_id'] == '16') {
                                        error_log('ticket Source 16 TwoWay: ' . date('Y/m/d H:i:s') . ' buy ' . ($payType == 'credit' ? 'credit' : 'cash') . ' With RequestNumber : =>' . $eachDirection['request_number'] . ' AND array Equal  =>' . json_encode($ReserveTicket, true) . " \n", 3, LOGS_DIR . 'log_source_16.txt');
                                    }
                                    if($eachDirection['api_id'] == '16'){
                                        $data['pnr_return'] = $ReserveTicket['Result']['Request']['ReturnRoutes'][0]['AirlinePnr'];
                                        $data['eticket_number_return'] = !empty($ReserveTicket['Result']['Request']['RequestPassengers']) ? $ReserveTicket['Result']['Request']['RequestPassengers'][$i]['TicketNumberReturn'] : '';

                                    }
                                    if ($ticketsCurrent[$i]['passenger_national_code'] != '0000000000') {
                                        $uniqCondition = " AND passenger_national_code = '{$ticketsCurrent[$i]['passenger_national_code']}' ";
                                    } else {
                                        $uniqCondition = " AND passportNumber = '{$ticketsCurrent[$i]['passportNumber']}' ";
                                    }

                                    $condition = " request_number = '{$eachDirection['request_number']}' " . $uniqCondition;
                                    $res = $model->update($data, $condition);

                                    if ($res) {
                                        $data['private_m4'] = '3';
                                        $ModelBase->setTable('report_tb');
                                        $conditionBase = " request_number = '{$eachDirection['request_number']}' " . $uniqCondition;
                                        $ModelBase->update($data, $conditionBase);
                                    }
                                    $this->ok_flight[$eachDirection['direction']] = true;
                                    $this->payment_date = $data['payment_date'];
                                }
//                            $this->getController('servicesDiscount')->updateSpecialDiscountUsed($eachDirection['factor_number']);
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

                                //email to buyer
                                $this->emailTicketSelf($eachDirection['request_number']);

                                //sms to buyer
                                $objSms = $smsController->initService('0');
                                if ($objSms) {
                                    if (!empty($eachDirection['airline_name'])) {
                                        $airlineName = $eachDirection['airline_name'];
                                    } else {
                                        $airlineNameInfo = functions::InfoAirline($eachDirection['airline_iata']);
                                        $airlineName = $airlineNameInfo['name_fa'];
                                    }

                                    //to member
                                    $messageVariables = array(
                                        'sms_name' => $eachDirection['member_name'],
                                        'sms_service' => 'بلیط',
                                        'sms_factor_number' => $eachDirection['request_number'],
                                        'sms_airline' => $airlineName,
                                        'sms_origin' => $eachDirection['origin_city'],
                                        'sms_destination' => $eachDirection['desti_city'],
                                        'sms_flight_number' => $eachDirection['flight_number'],
                                        'sms_flight_date' => dateTimeSetting::jdate("Y-F-d", functions::ConvertToDateJalaliInt($eachDirection['date_flight'])),
                                        'sms_flight_time' => $eachDirection['time_flight'],
                                        'sms_pdf' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=ticketForeign&id=" . $eachDirection['request_number'],
                                        'sms_agency' => CLIENT_NAME,
                                        'sms_agency_mobile' => CLIENT_MOBILE,
                                        'sms_agency_phone' => CLIENT_PHONE,
                                        'sms_agency_email' => CLIENT_EMAIL,
                                        'sms_agency_address' => CLIENT_ADDRESS,
                                        'sms_site_url' => CLIENT_MAIN_DOMAIN
                                    );
                                    $smsArray = array(
                                        'smsMessage' => $smsController->getUsableMessage('afterTicketReserve', $messageVariables),
                                        'cellNumber' => $eachDirection['member_mobile'],
                                        'smsMessageTitle' => 'afterTicketReserve',
                                        'memberID' => (!empty($eachDirection['member_id']) ? $eachDirection['member_id'] : ''),
                                        'receiverName' => $messageVariables['sms_name'],
                                    );
                                    $smsController->sendSMS($smsArray);

                                    //to manager
                                    $smsArray = array(
                                        'smsMessage' => $smsController->getUsableMessage('afterReserveToManager', $messageVariables),
                                        'cellNumber' => CLIENT_MOBILE,
                                        'smsMessageTitle' => 'afterReserveToManager',
                                        'memberID' => (!empty($eachDirection['member_id']) ? $eachDirection['member_id'] : ''),
                                        'receiverName' => 'مدیر سایت',
                                    );
                                    $smsController->sendSMS($smsArray);

                                    //to first passenger
                                    $messageVariables['sms_name'] = $eachDirection['passenger_name'] . ' ' . $eachDirection['passenger_family'];
                                    $smsArray = array(
                                        'smsMessage' => $smsController->getUsableMessage('afterTicketReserve', $messageVariables),
                                        'cellNumber' => $eachDirection['mobile_buyer'],
                                        'smsMessageTitle' => 'afterTicketReserve',
                                        'memberID' => (!empty($eachDirection['member_id']) ? $eachDirection['member_id'] : ''),
                                        'receiverName' => $messageVariables['sms_name'],
                                    );
                                    $smsController->sendSMS($smsArray);
                                }
                            }

                        } else {
                            if ($payType == 'credit') {

                                $sql = " SELECT successfull,request_number,factor_number,flight_type FROM book_local_tb WHERE request_number='{$eachDirection['request_number']}'";
                                $TicketsCreditCheck = $model->load($sql);

                                if ($TicketsCreditCheck['successfull'] != 'book') {

                                    if ($eachDirection['direction'] == 'dept') {
                                        $this->delete_transaction_current($TicketsCreditCheck['factor_number']);
                                    }

                                    $this->delete_credit_Agency_current($TicketsCreditCheck['request_number']);
                                }
                            }

                            if($eachDirection['api_id']=='10')
                            {
                                $this->MessagSource10 = functions::Xmlinformation('MessageSource10');
                            }
                            if ($eachDirection['direction'] == 'return') {

                                $this->changeTransactionInReturnFailure($this->factor_num);

                            }
                        }
                    } catch (Exception $e) {

                        $d['message'] = $e->getMessage();
                        $d['creation_date_int'] = time();
                        $d['json_result'] = json_encode($ReserveTicket);
                        $d['request_number'] = $eachDirection['request_number'];

                        $ModelBase->setTable('log_res_action_tb');
                        $ModelBase->insertLocal($d);
                    }
                }
            }
            else{
                $this->ok_flight[$eachDirection['direction']] = true;
                $this->payment_date = Date('Y-m-d H:i:s');
            }
        }
    }

    public function getBook($factor_number)
    {
        /** @var book_local_tb $model */
        $model = Load::model('book_local');
        return $model->getBook_model($factor_number);
    }

    public function getTicketDataNew($factor_number)
    {
        /** @var book_local_tb $model */
        $model = Load::model('book_local');
        $info_ticket = $model->getTicketInfo($factor_number);

        $this->factorNumberPrint = $info_ticket[0]['factor_number'];
        return $info_ticket;
    }

    public function getTicketDataByRequestNumber($request_number, $conditionCancelStatus = null)
    {
        $model = Load::library('Model');

        //$query = "SELECT * FROM book_local_tb WHERE  request_number='{$request_number}' AND (successfull='book' OR successfull='private_reserve')";
        $query = "
        SELECT
            report.*,
            (
        SELECT
            PercentIndemnity 
        FROM
            cancel_ticket_details_tb AS cancelTicketDetail
            LEFT JOIN cancel_ticket_tb AS cancelTicket ON cancelTicket.IdDetail = cancelTicketDetail.id 
        WHERE
            ( cancelTicket.NationalCode = report.passenger_national_code OR cancelTicket.NationalCode = report.passportNumber )
            AND report.request_number = cancelTicketDetail.RequestNumber
        GROUP BY
            cancelTicket.NationalCode 
            ) AS cancelTicketPercent,
            (
        SELECT
            DateRequestCancelClientInt 
        FROM
            cancel_ticket_details_tb AS cancelTicketDetail
            LEFT JOIN cancel_ticket_tb AS cancelTicket ON cancelTicket.IdDetail = cancelTicketDetail.id 
        WHERE
            ( cancelTicket.NationalCode = report.passenger_national_code OR cancelTicket.NationalCode = report.passportNumber )
            AND report.request_number = cancelTicketDetail.RequestNumber 
        GROUP BY
            cancelTicket.NationalCode 
            ) AS cancelTicketDate ,
(
		SELECT
			PriceIndemnity
		FROM
			cancel_ticket_details_tb AS cancelTicketDetail
		LEFT JOIN cancel_ticket_tb AS cancelTicket ON cancelTicket.IdDetail = cancelTicketDetail.id
		WHERE
			(
				cancelTicket.NationalCode = report.passenger_national_code
				OR cancelTicket.NationalCode = report.passportNumber
			)
		AND report.request_number = cancelTicketDetail.RequestNumber
		GROUP BY
			cancelTicket.NationalCode
	) AS cancelTicketPriceIndemnity
        FROM
            book_local_tb AS report 
        WHERE
            report.request_number = '{$request_number}' 
            AND ( report.successfull = 'book' OR report.successfull = 'private_reserve' )
            {$conditionCancelStatus}
        ";
        $info_ticket = $model->select($query);

        return $info_ticket;
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

    public function setCategoryNum($num)
    {
        $this->categoryNum = $num;
    }

    /**
     * Get name of city
     * @param $airportID int not null.it is ID of airport
     * @return Set $airportCity  without returning anything
     * @author Anari
     */
    public function getCityAirport($airportID)
    {
        $airport = parent::getAirport($airportID);
        //print_r($airport[0]);
        return $airport[0]['text'];
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

    public function createPdfContent($param, $cash, $cancelStatus)
    {


        $resultLocal = Load::controller('resultLocal');
        $airport_model = $this->getModel('airportModel') ;
        $airline_model = $this->getModel('airlineModel') ;

        $conditionCancelStatus = '';
        if (isset($cancelStatus) && $cancelStatus != ''){
            $conditionCancelStatus = " AND report.request_cancel = '{$cancelStatus}' ";
        }

        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $sql = "select client_id from report_tb where request_number='{$param}' AND (successfull = 'book' OR successfull = 'private_reserve') ";
            $ticketReport = $ModelBase->load($sql);

            $admin = Load::controller('admin');
            $queryClient = "
        SELECT
            report.*,
            (
        SELECT
            PercentIndemnity 
        FROM
            cancel_ticket_details_tb AS cancelTicketDetail
            LEFT JOIN cancel_ticket_tb AS cancelTicket ON cancelTicket.IdDetail = cancelTicketDetail.id
        WHERE
            ( cancelTicket.NationalCode = report.passenger_national_code OR cancelTicket.NationalCode = report.passportNumber )
             AND report.request_number = cancelTicketDetail.RequestNumber
        GROUP BY
            cancelTicket.NationalCode 
            ) AS cancelTicketPercent,
            (
        SELECT
            DateRequestCancelClientInt 
        FROM
            cancel_ticket_details_tb AS cancelTicketDetail
            LEFT JOIN cancel_ticket_tb AS cancelTicket ON cancelTicket.IdDetail = cancelTicketDetail.id
        WHERE
            ( cancelTicket.NationalCode = report.passenger_national_code OR cancelTicket.NationalCode = report.passportNumber )
            AND report.request_number = cancelTicketDetail.RequestNumber 
        GROUP BY
            cancelTicket.NationalCode 
            ) AS cancelTicketDate ,
(
		SELECT
			PriceIndemnity
		FROM
			cancel_ticket_details_tb AS cancelTicketDetail
		LEFT JOIN cancel_ticket_tb AS cancelTicket ON cancelTicket.IdDetail = cancelTicketDetail.id
		WHERE
			(
				cancelTicket.NationalCode = report.passenger_national_code
				OR cancelTicket.NationalCode = report.passportNumber
			)
		AND report.request_number = cancelTicketDetail.RequestNumber
		GROUP BY
			cancelTicket.NationalCode
	) AS cancelTicketPriceIndemnity
        FROM
            book_local_tb AS report 
        WHERE
            report.request_number = '{$param}' 
            AND ( report.successfull = 'book' OR report.successfull = 'private_reserve' )
            {$conditionCancelStatus}
        ";

            $info_ticket = $admin->ConectDbClient($queryClient, $ticketReport['client_id'], 'SelectAll', '', '', '');
            $clientid = $admin->getClient(CLIENT_ID);
        } else {
            $info_ticket = $this->getTicketDataByRequestNumber($param, $conditionCancelStatus);

        }
        $sqlAirline = "SELECT * FROM airline_tb WHERE abbreviation = '".$info_ticket[0]['airline_iata']."'";
        $infoAirline =  $airline_model->select($sqlAirline);
        $objOffCode = Load::controller('interactiveOffCodes');
        $resultOffCode = $objOffCode->getOffCodeByFactorNumber($info_ticket[0]['factor_number']);

        $ClientId =  CLIENT_ID;
        $agencyController = Load::controller('agency');
        $agencyInfo = $agencyController->infoAgency($info_ticket[0]['agency_id'], $ClientId);
        /*    if ($ClientId == '79') {
                $ClientMainDomain = (!empty($info_ticket[0]['agency_id']) && ($info_ticket[0]['agency_id'] > 0) && !empty($agencyInfo['domain'])) ? (!empty($agencyInfo['domain']) ? $agencyInfo['domain'] : '') : CLIENT_MAIN_DOMAIN;
                $phone = (!empty($info_ticket[0]['agency_id']) && ($info_ticket[0]['agency_id'] > 0) && !empty($agencyInfo['domain'])) ? (!empty($agencyInfo['phone']) ? $agencyInfo['phone'] : '') : CLIENT_PHONE;
                $ClientAddress = (!empty($info_ticket[0]['agency_id']) && ($info_ticket[0]['agency_id'] > 0) && !empty($agencyInfo['domain'])) ? (!empty($agencyInfo['address_fa']) ? $agencyInfo['address_fa'] : '') : CLIENT_ADDRESS;
                $LogoAgencyPic = (!empty($info_ticket[0]['agency_id']) && ($info_ticket[0]['agency_id'] > 0) && !empty($agencyInfo['domain'])) ? (!empty($agencyInfo['logo']) ? $agencyInfo['logo'] : '') : CLIENT_LOGO;
                $LogoAgency = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . $LogoAgencyPic;

            } else {*/


        if($agencyInfo['hasSite'])
        {
            $LogoAgency = ROOT_ADDRESS_WITHOUT_LANG . '/pic/agencyPartner/' .CLIENT_ID.'/logo/'. CLIENT_LOGO;

        }else{
            $LogoAgency = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . CLIENT_LOGO;
            $StampAgency = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . CLIENT_STAMP;
        }
        $ClientMainDomain = CLIENT_MAIN_DOMAIN;
        $phone = CLIENT_PHONE;
        $ClientAddress = CLIENT_ADDRESS;


        $PhoneManage = CLIENT_MOBILE;
        $AgencyName = CLIENT_NAME;
//    }

        $gender = '';
        $genderEn = '';
        $airplan = '';
        $PrintTicket = '';


        if (!empty($info_ticket)) {

            ob_start();

            ?>
           <!DOCTYPE html>
           <html>
           <head>
              <title>مشاهده فایل pdf بلیط</title>
              <style type="text/css">
                  .divborder {
                      border: 1px solid #CCC;
                  }

                  .divborderPoint {
                      border: 1px solid #CCC;
                      background-color: #FFF;
                      border-radius: 5px;
                      z-index: 100000000;
                      width: 200px;
                      padding: 5px;
                      margin-right: 20px;
                      text-align:center;
                  }

                  /*.page td {*/
                  /*    padding: 0;*/
                  /*    margin: 0;*/
                  /*}*/

                  /*.page {*/
                  /*    border-collapse: collapse;*/
                  /*}*/

                  /*@font-face {
                      font-family: "iranyekan";
                      font-style: normal;
                      font-weight: normal;
                      src: url("../view/administrator/assets/css/font/web/persian/iranyekanwebregular/iranyekanwebregular.eot") format("opentype"),
                      url("../view/administrator/assets/css/font/web/persian/iranyekanwebregular/iranyekanwebregular.ttf") format("truetype");
                  }*/
                  *{
                      font-family: 'yekanbakh'!important;
                  }
                  body   {
                      font-family: 'yekanbakh' !important;
                  }


                  table {
                      font-family: 'yekanbakh' !important;
                      border-collapse: collapse;
                  }

                  /*table.solidBorder, .solidBorder th, .solidBorder td {*/
                  /*    !*border: 1px solid #CCC;*!*/
                  /*}*/

                  /*.element:last-child {*/
                  /*    page-break-after: auto;*/
                  /*}*/
                  /*.head-logo-info{*/
                  /*    width:100% !important;*/
                  /*    display:flex !important;*/
                  /*    justify-content:space-between;*/
                  /*    align-items:center;*/
                  /*}*/
                  .head-p{
                      font-size:13px;
                      color: #a8a7a7;

                  }
                  .head-detail-p{
                      font-size:15px;
                  }

              </style>

           </head>
           <body style="font-family:'iranyekan'">
           <?php





           foreach ($info_ticket as $key=>$info) {
               $start_time = $info['time_flight'];
//              $end_time = $resultLocal->format_hour_arrival($info['origin_airport_iata'], $info['desti_airport_iata'], $info['time_flight']);
               $end_time = $info['time_flight_arrival'];

               if($this->isTomorrow($start_time, $end_time)) {
                   $date = new DateTime($info['date_flight']);
                   $date->modify('+1 day');
                   $end_date =  $date->format('Y-m-d\TH:i:s');
               }else {
                   $end_date = $info['date_flight'];
               }

               if ($info['passenger_age'] == "Adt") {
                   $infoAge = 'بزرگسال';
               } else if ($info['passenger_age'] == 'Chd') {
                   $infoAge = 'کودک';
               } else if ($info['passenger_age'] == 'Inf') {
                   $infoAge = 'نوزاد';
               }
               if ($info['passenger_gender'] == 'Male') {
                   $gender = ' آقای';
                   $genderEn = 'Mr';
               } else if ($info['passenger_gender'] == 'Female') {
                   $gender = ' خانم';
                   $genderEn = 'Ms';
               }

               if ($info['flight_type'] == '' || $info['flight_type'] == 'charter') {
                   $flight_type = 'چارتری';
               } else if ($info['flight_type'] == 'system') {
                   $flight_type = 'سیستمی';
               }

               if (($info['seat_class'] == 'C' || $info['seat_class'] == 'B')) {
                   $seat_class = 'بیزینس';
               } else {
                   $seat_class = 'اکونومی';
               }

               $CabinType = $info['cabin_type'];

//               $Fee = functions::FeeCancelFlight($info['airline_iata'], $CabinType);
                 $params = [
                     'airline_iata'=>$info['airline_iata'],
                     'cabin_type'=>$CabinType
                 ];
               $Fee = Load::controller( 'cancellationFeeSetting' )->feeByAirlineAndCabinTypeNew($params);
               $Price = '0';
               if (functions::TypeUser($info['member_id']) == 'Ponline') {
                   $Price = functions::CalculateDiscountOnePerson($info['request_number'], ($info['passenger_national_code'] == '0000000000' || $info['passenger_national_code'] == '' ? $info['passportNumber'] : $info['passenger_national_code']), 'yes');
                   $PriceWithOut = 0;
               } else if (functions::TypeUser($info['member_id']) == 'Counter') {
                   $Price = functions::CalculatePriceTicketOnePerson($info['request_number'], ($info['passenger_national_code'] == '0000000000' || $info['passenger_national_code'] == '' ? $info['passportNumber'] : $info['passenger_national_code']), 'yes');
                   $PriceWithOut = functions::CalculateDiscountOnePerson($info['request_number'], ($info['passenger_national_code'] == '0000000000' || $info['passenger_national_code'] == '' ? $info['passportNumber'] : $info['passenger_national_code']), 'yes');
               }

               $AddOnPrice = ((!empty($info['amount_added']) && $info['amount_added'] > 0) ? $info['amount_added'] : '0');
               $priceTotal = $Price + $AddOnPrice;
               $priceTotalWithOutDiscount = $PriceWithOut + $AddOnPrice;



               $cancelTicketPrice = 0;
               if ($info['request_cancel'] == 'confirm'){
//        $cancelTicketPrice = $priceTotal - (($priceTotal * $info['cancelTicketPercent']) / 100);

               }
               $picAirline = functions::getAirlinePhoto($info['airline_iata']);
               $airlineName = functions::InfoAirline($info['airline_iata']);
               // $price = functions::CalculateDiscountOnePerson($info['request_number'], $info['passenger_national_code'] == '0000000000' ? $info['passenger_national_code'] : $info['passportNumber'], 'yes');
               $airplan = 'https://versagasht.com/gds/view/client/assets/images/air.png';
//               $barcodeBase64 = barcode128_base64($info['pnr']);
               ?>
              <div  style='margin-top: 1000px;font-family: "yekanbakh"'>
                 <table width="100%" align="center" style="margin: 20px 100px;" class="page">
                    <tr>
                       <td style="padding-bottom:30px">
                          <img src="<?php echo $LogoAgency ?>" height="80" style="vertical-align: middle;">
                          <span style="display: inline-block; vertical-align: middle; padding-left: 10px;">
                <?php echo $AgencyName ?>
            </span>
                       </td>
                       <td style="<?= $_GET['lang'] == 'fa' ? 'text-align:left' : 'text-align:right'; ?>
                          ">
                          <img src="https://safar360.com/gds/library/barcode/barcode_creator.php?barcode=<?php echo trim($info['pnr']); ?>"
                               style="max-width: 80px; min-height: 50px">
                       </td>
                    </tr>
                 </table>

                 <div class="divborder" style="margin: 20px 100px;">
                    <table width="100%" align="center" class="page">
                        <?php if (isset($cancelStatus) && $cancelStatus == 'confirm') { ?>
                           <tr style="text-align: center;">
                              <td style="font-size: 30px; font-weight: 700; padding: 10px;">
                                 رسید کنسلی
                              </td>
                           </tr>
                        <?php } ?>
                       <tr>
                          <?php if($_GET['lang'] == 'fa'){ ?>
                          <td style="padding:15px;">
                             <p class="head-p">نام و نام خانوادگی</p>
                             <p class="head-detail-p">
                                 <?php echo !empty($info['passenger_name_en']) && !empty($info['passenger_family_en'])
                                     ? $info['passenger_name_en'] . ' ' . $info['passenger_family_en']
                                     : '-'; ?>
                             </p>
                             <p class="head-p">کد ملی</p>
                             <p class="head-detail-p">
                                 <?php echo !empty($info['passenger_national_code']) ? $info['passenger_national_code'] : $info['passportNumber']; ?>
                             </p>
                          </td>
                          <?php } ?>
                          <td style="padding:15px; text-align:left;">
                             <p class="head-p">Passenger Name</p>
                             <p class="head-detail-p">
                                 <?php echo !empty($info['passenger_name_en']) && !empty($info['passenger_family_en'])
                                     ? $info['passenger_name_en'] . ' ' . $info['passenger_family_en']
                                     : '-'; ?>
                             </p>
                             <p class="head-p">National Code</p>
                             <p class="head-detail-p">
                                 <?php echo !empty($info['passenger_national_code']) ? $info['passenger_national_code'] : $info['passportNumber']; ?>
                             </p>
                          </td>
                       </tr>
                    </table>
                 </div>

                 <table width="100%" align="center" style="margin: 10px 90px; border-collapse: separate; border-spacing: 10px 0;" class="page">
                    <tr>
                       <!-- سمت چپ اطلاعات پرواز -->
                       <td width="50%" class="divborder" style="overflow:hidden;">
                          <table width="100%" style="border-collapse: collapse;">
                             <tr>
                                <?php if($_GET['lang'] == 'fa'){ ?>
                                <td style="padding:10px; vertical-align:top;">
                                   <p class="head-p">شماره بلیط</p>
                                   <p class="head-detail-p"><?php echo $info['eticket_number']?></p>
                                   <p class="head-p">رفرنس</p>
                                   <p class="head-detail-p" ><?php echo $info['pnr']?></p>
                                </td>
                                <?php } ?>
                                <td style="padding:10px; text-align:left; vertical-align:top;">
                                   <p class="head-p">Ticket Number</p>
                                   <p class="head-detail-p"><?php echo $info['eticket_number']?></p>
                                   <p class="head-p">PNR</p>
                                   <p class="head-detail-p"><?php echo $info['pnr']?></p>
                                </td>
                             </tr>
                             <tr>
                                <?php if($_GET['lang'] == 'fa'){ ?>
                                <td style="padding:10px; vertical-align:top; border-top:1px solid #ccc;">
                                   <p class="head-p">مبدا</p>
                                   <p class="head-detail-p"><?php echo $info['origin_city']?></p>
                                   <p class="head-p">مقصد</p>
                                   <p class="head-detail-p"><?php echo $info['desti_city']?></p>
                                </td>
                                <?php  } ?>
                                <td style="padding:10px; text-align:left; vertical-align:top; border-top:1px solid #ccc;">
                                   <p class="head-p">Origin</p>
                                   <p class="head-detail-p"><?php echo $info['origin_airport_iata']?></p>
                                   <p class="head-p">Destination</p>
                                   <p class="head-detail-p"><?php echo $info['desti_airport_iata']?></p>
                                </td>
                             </tr>
                             <tr>
                                <?php if($_GET['lang'] == 'fa'){ ?>
                                <td style="padding:10px; vertical-align:top; border-top:1px solid #ccc;">
                                   <p class="head-p">تاریخ حرکت</p>
                                   <p class="head-detail-p"><?php $date = functions::OtherFormatDate($info['date_flight']); echo $date['DepartureDate']; ?></p>
                                   <p class="head-p">ساعت حرکت</p>
                                   <p class="head-detail-p"><?php echo $resultLocal->format_hour($info['time_flight']); ?></p>
                                </td>
                                <?php } ?>
                                <td style="padding:10px; text-align:left; vertical-align:top; border-top:1px solid #ccc;">
                                   <p class="head-p">Flight Date</p>
                                   <p class="head-detail-p"><?php echo $info['date_flight']?></p>
                                   <p class="head-p">Flight Time</p>
                                   <p class="head-detail-p"><?php echo $resultLocal->format_hour($info['time_flight']); ?></p>
                                </td>
                             </tr>
                             <tr>
                             <?php if($_GET['lang'] == 'fa'){ ?>
                                <td style="padding:10px; vertical-align:top; border-top:1px solid #ccc;">
                                   <p class="head-p">تاریخ رسیدن</p>
                                   <p class="head-detail-p"><?php $date = functions::OtherFormatDate($info['date_flight_arrival']); echo $date['DepartureDate'];?></p>
                                   <p class="head-p">ساعت رسیدن</p>
                                   <p class="head-detail-p"><?php echo $resultLocal->format_hour($info['time_flight_arrival']); ?></p>
                                </td>
                                <?php } ?>
                                <td style="padding:10px; text-align:left; vertical-align:top; border-top:1px solid #ccc;">
                                   <p class="head-p">Arrival Date</p>
                                   <p class="head-detail-p"><?php echo $info['date_flight_arrival']?></p>
                                   <p class="head-p">Arrival Time</p>
                                   <p class="head-detail-p"><?php echo $resultLocal->format_hour($info['time_flight_arrival']); ?></p>
                                </td>
                             </tr>
                          </table>
                       </td>

                       <!-- سمت راست اطلاعات ایرلاین و قیمت -->
                       <td width="50%" class="divborder">
                          <table width="100%" style="border-collapse: collapse;">
                             <tr>
                                <td style="<?= ($_GET['lang'] == 'en' ? 'text-align:left;' : '')  ?>"><img src="<?php echo $picAirline ?>" style="max-height:70px;"></td>
                             </tr>
                             <tr>
                                <?php  if($_GET['lang'] == 'fa'){  ?>
                                <td style="padding:10px; vertical-align:top;">
                                   <p class="head-p">ایرلاین</p>
                                   <p class="head-detail-p"><?php echo $info['airline_name'] . ' (' . $info['airline_iata'] . ')'?></p>
                                </td>
                                <?php } ?>
                                <td style="padding:10px; text-align:left; vertical-align:top;">
                                   <p class="head-p">Airline</p>
                                   <p class="head-detail-p" style="text-align:right"><?php echo $info['airline_name'] . ' (' . $info['airline_iata'] . ')'?></p>

                                </td>
                             </tr>
                             <tr>
                                <?php if($_GET['lang'] == 'fa'){ ?>
                                <td style="padding:10px; vertical-align:top; border-top:1px solid #ccc;">
                                   <p class="head-p">شماره پرواز</p>
                                   <p class="head-detail-p"><?php echo $info['flight_number']?></p>
                                </td>
                                  <?php } ?>
                                <td style="padding:10px; text-align:left; vertical-align:top; border-top:1px solid #ccc;">
                                   <p class="head-p">Flight Number</p>
                                   <p class="head-detail-p"><?php echo $info['flight_number']?></p>
                                </td>
                             </tr>
                             <tr>
                             <?php if($_GET['lang'] == 'fa'){ ?>
                                <td style="padding:10px; vertical-align:top; border-top:1px solid #ccc;">
                                   <p class="head-p">بار مجاز</p>
                                   <p class="head-detail-p">25 کیلوگرم</p>
                                </td>
                                  <?php } ?>
                                <td style="padding:10px; text-align:left; vertical-align:top; border-top:1px solid #ccc;">
                                   <p class="head-p">Permissible Load</p>
                                   <p class="head-detail-p">25 KG</p>
                                </td>
                             </tr>
                             <tr>
                             <?php if($_GET['lang'] == 'fa'){ ?>
                                <td style="padding:10px; vertical-align:top; border-top:1px solid #ccc;">
                                   <p class="head-p">کلاس پرواز</p>
                                   <p class="head-detail-p"><?php echo $info['cabin_type'] ? $info['cabin_type'] : '-'?></p>
                                </td>
                                  <?php } ?>
                                <td style="padding:10px; text-align:left; vertical-align:top; border-top:1px solid #ccc;">
                                   <p class="head-p">Flight Class</p>
                                   <p class="head-detail-p"><?php echo $info['cabin_type'] ? $info['cabin_type'] : '-'?></p>
                                </td>
                             </tr>
                             <tr>
                             <?php if($_GET['lang'] == 'fa'){ ?>
                                <td style="padding:10px; vertical-align:top; border-top:1px dashed #000;">
                                   <p class="head-p">بهای بلیط</p>
                                   <p class="head-detail-p" style="font-weight:bolder;">
                                       <?php
                                       if ($cash == 'no') {
                                           echo 'Cash';
                                       } else {
                                           $isCounter = functions::TypeUser($info['member_id']) === 'Counter';
                                           if ($isCounter && $info['percent_discount'] > 0) {
                                               echo number_format($priceTotalWithOutDiscount) . ' ریال';
                                           } else {
                                               echo number_format($priceTotal) . ' ریال';
                                           }
                                       }
                                       ?>
                                   </p>
                                </td>
                             <?php } ?>
                                <td style="padding:10px; text-align:left; vertical-align:top; border-top:1px dashed #000;">
                                   <p class="head-p">Price</p>
                                   <p class="head-detail-p" style="font-weight:bold">
                                       <?php
                                       if ($cash == 'no') {
                                           echo 'Cash';
                                       } else {
                                           $isCounter = functions::TypeUser($info['member_id']) === 'Counter';
                                           if ($isCounter && $info['percent_discount'] > 0) {
                                               echo number_format($priceTotalWithOutDiscount) . ' Rial';
                                           } else {
                                               echo number_format($priceTotal) . ' Rial';
                                           }
                                       }
                                       ?>
                                   </p>
                                </td>
                             </tr>
                          </table>
                       </td>
                    </tr>
                    <tr><td colspan="2" style="height:10px;"></td></tr>
                 </table>



                 <?php
               if ($info['request_cancel'] != 'confirm' && ($info['successfull'] == 'book' || $info['successfull'] == 'private_reserve')){
                   ?>
                  <div class="" style="margin: 10px 100px ;border:1px solid #ccc">
<!--                     <div style="font-size: 19px ; color: #006cb5; margin-top: -20px" class="divborderPoint"> به نکات زیر توجه-->
<!--                        نمایید:-->
<!--                     </div>-->
                     <table width="100%" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                           <td></td>
                        </tr>

                        <tr>
                           <td style="padding:20px">
                              <ul>
                                  <?php if($_GET['lang'] == 'fa'){ ?>
                                     <li> حداکثر بار مجاز برابر با 25کیلو گرم می باشد</li>
                                     <li>در هنگام سوار شدن حتما مدرک شناسایی (کارت ملی یا پاسپورت) همراه خود داشته باشید</li>
                                     <li>در پروازهای داخلی 2 ساعت و در پروازهای خارجی 3 ساعت زودتر در فرودگاه حاضر باشید</li>
                                     <li>در صورتیکه از پرواز به دلیل کنسلی، تاخیر یا تعجیل استفاده نکردید، نسبت به مهر نمودن بلیط اقدام نمایید </li>
                                     <!--                           <li>در صورتیکه به دلایل شخصی از پرواز استفاده نمیکنید، نسبت به مهر نمودن بلیط اقدام نمایید </li>-->
                                     <!--                          <li>ترمینال 1 : کیش ایر، وارش ، زاگرس ، چابهار ، اروان</li>-->
                                     <!--                          <li>ترمینال 2 : ایران ایر ، ایر تور ، آتا ، قشم ایر ، معراج ، نفت(کارون)</li>-->
                                     <!--                          <li>ترمینال 4 : ماهان ، کاسپین ، آسمان ، اترک ، تابان ، سپهران ، فلای پرشیا ، ساها ، پویا ، اترک ، پارس ، یزد ایر</li>-->
                                     <!--                          <li>درصورتی که بلیط شما به هر دلیلی با مشکل مواجه شد لطفا با شماره تلفن های آژانس که در انتهای-->
                                     <!--                            بلیط نمایش داده شده تماس حاصل فرمائید-->
                                     <!--                          </li>-->

                                  <?php } else { ?>

                                     <li>The maximum allowable load is 25 kg.</li>
                                     <li>Be sure to have your identification document (national card or passport) with you when boarding.</li>
                                     <li>Be at the airport 2 hours early for domestic flights and 3 hours early for international flights.</li>
                                  <?php }  ?>
                                 <?php
                                  if($info['api_id'] == 14)  {
                                      if($_GET['lang'] == 'fa'){
                                      echo '
                             <li>هزینه های کنسلی طبق قوانین ایرلاین محاسبه میگردد</li>
                            <li>مسافر گرامی، شما می بایستی 2 ساعت قبل از زمان پرواز در فرودگاه حضور داشته باشید</li>
                            <li>در صورت ایجاد هرگونه محدودیت در پذیرش مسافر، این شرکت هیچگونه مسئولیتی در این خصوص نخواهد داشت و کلیه خسارات متوجه خریدار می باشد.</li>
                        
                            ';}else {?>
                                         <li>Cancellation fees are calculated according to airline rules.</li>
                                         <li>Dear passenger, you must be at the airport 2 hours before your flight time.</li>
                                         <li>In the event of any restrictions on passenger acceptance, this company will not be responsible for this and all damages will be borne by the buyer.</li>
                        <?php

                                      }
                                      }
                                  ?>

                              </ul>

                           </td>

                        </tr>

                     </table>
                  </div>
                   <?php
               }
               ?>
     <?php
               if ($info['origin_airport_iata'] == 'THR' || $info['origin_airport_iata'] == 'IKA' || $info['desti_airport_iata'] == 'THR' || $info['desti_airport_iata'] == 'IKA'){
                   ?>
                 <div class="" style="margin: 10px 100px ;border:1px solid #ccc">
                    <!--                     <div style="font-size: 19px ; color: #006cb5; margin-top: -20px" class="divborderPoint"> به نکات زیر توجه-->
                    <!--                        نمایید:-->
                    <!--                     </div>-->
                    <table width="100%" align="center" cellpadding="0" cellspacing="0">
                       <tr>
                          <td></td>
                       </tr>

                       <tr>
                          <td style="padding:20px">
                             <ul>
                                 <?php
                               
                                 $thrAirport = (
                                     $info['origin_airport_iata'] === 'THR' ||
                                     $info['desti_airport_iata'] === 'THR'
                                 ) ? 'مهرآباد' : '';

                                 $thrAirportEn = (
                                     $info['origin_airport_iata'] === 'THR' ||
                                     $info['desti_airport_iata'] === 'THR'
                                 ) ? 'Mehrabad' : '';


                                 if($_GET['lang'] == 'fa'){
                                    if ($info['origin_airport_iata'] == 'THR'){ ?>
                                    <li>
                                       این پرواز از ترمینال خروجی  <?=  $infoAirline[0]['out_thr'] . ' ' . $thrAirport ?> صورت می‌گیرد
                                    </li>
                                    <?php }  if ($info['desti_airport_iata'] == 'THR'){ ?>
                                       <li>
                                          این پرواز از ترمینال ورودی  <?=  $infoAirline[0]['enter_thr'] . ' ' . $thrAirport ?> صورت می‌گیرد
                                       </li>
                                    <?php } ?>




                                 <?php  }  else {   if ($info['origin_airport_iata'] == 'THR'){ ?>
                                    <li>
                                       This flight departs from the terminal  <?=   $infoAirline[0]['out_thr'] . ' ' . $thrAirportEn ?> It takes place.
                                    </li>
                                 <?php }  if ($info['desti_airport_iata'] == 'THR'){ ?>
                                    <li>
                                       This flight departs from the arrivals terminal  <?=  $infoAirline[0]['enter_thr'] . ' ' . $thrAirportEn ?> It takes place.
                                    </li>
                                 <?php }?>






                                 <?php  }  ?>
                                 <?php
                                 if($info['api_id'] == 14)  {
                                     if($_GET['lang'] == 'fa'){
                                         echo '
                             <li>هزینه های کنسلی طبق قوانین ایرلاین محاسبه میگردد</li>
                            <li>مسافر گرامی، شما می بایستی 2 ساعت قبل از زمان پرواز در فرودگاه حضور داشته باشید</li>
                            <li>در صورت ایجاد هرگونه محدودیت در پذیرش مسافر، این شرکت هیچگونه مسئولیتی در این خصوص نخواهد داشت و کلیه خسارات متوجه خریدار می باشد.</li>
                        
                            ';}else {?>
                                        <li>Cancellation fees are calculated according to airline rules.</li>
                                        <li>Dear passenger, you must be at the airport 2 hours before your flight time.</li>
                                        <li>In the event of any restrictions on passenger acceptance, this company will not be responsible for this and all damages will be borne by the buyer.</li>
                                         <?php

                                     }
                                 }
                                 ?>

                             </ul>

                          </td>

                       </tr>

                    </table>
                 </div>
                   <?php
               }
     ?>
               <?php

               if (!empty($info['request_cancel']) && $info['request_cancel'] == 'confirm'){

                   $date = dateTimeSetting::jdate('Y-m-d (H:i:s)', $info['cancelTicketDate'],'','','en');
                   ?>
                  <div class="divborder" style="bottom: 0; margin: 10px 100px 100px 100px;">
                     <div style="font-size: 19px ; color: #006cb5; margin-top: -20px;text-align: center;" class="divborderPoint"> توضیحات</div>
                     <table width="100%" align="center" cellpadding="5" cellspacing="0" style="margin: 10px;">
                        <tr>
                            <?php if($_GET['lang'] == 'fa'){ ?>
                               <td class="cancellationPolicy-title" colspan="6" style="font-size: 20px; font-weight: 700;">پرواز فوق در تاریخ <?php echo $date ?> با درصد <?php echo  $info['cancelTicketPercent'] ?> و مبلغ <?php echo number_format($info['cancelTicketPriceIndemnity']) ?>  ریال استرداد شده است.</td>


                         <?php } else { ?>
                               <td class="cancellationPolicy-title" colspan="6" style="font-size: 20px; font-weight: 700;">The above flight in history <?php echo $date ?> By percentage <?php echo  $info['cancelTicketPercent'] ?> and the amount <?php echo number_format($info['cancelTicketPriceIndemnity']) ?> The rial has been refunded. </td>



                         <?php }  ?>
                        </tr>
                     </table>
                  </div>
                  <br/>
                  <!--                <br/>-->
                  <!--                <br/>-->
                  <!--                <br/>-->
                  <!--                <br/>-->
                  <!--                <br/>-->
                  <!--                <br/>-->


                   <?php
               }
               elseif (strtolower($info['flight_type']) == 'system' && $cash !='no') {

//                  if($info['amount_added'] ==0)
//                  {
//                      $type='';
//                      if($info['passenger_age']=='Adt'){
//                          $type = 'adt';
//                      }else if($info['passenger_age']=='Chd'){
//                          $type = 'chd';
//                      }else if($info['passenger_age']=='Inf'){
//                          $type = 'inf';
//                      }
//                      ?>
                  <!--                    <div class="divborder" style="margin: 20px 100px;">-->
                  <!--                      <div style="font-size: 19px ; color: #006cb5; margin-top: -20px" class="divborderPoint">جزئیات قیمت:-->
                  <!--                      </div>-->
                  <!--                      <table width="100%" align="center" cellpadding="5" cellspacing="0" style="margin:10px;" border="1"-->
                  <!--                             class="solidBorder">-->
                  <!--                        <tr class="cancellationPolicy-tableHead">-->
                  <!--                          <td class="cancellationPolicy-c1"> fare</td>-->
                  <!--                          <td class="cancellationPolicy-c2">tax</td>-->
                  <!--                          <td class="cancellationPolicy-c3">total</td>-->
                  <!--                        </tr>-->
                  <!--                        <tr>-->
                  <!--                          <td class="cancellationPolicy-title">--><?php //echo $info[$type.'_fare'] ?><!--</td>-->
                  <!--                          <td class="cancellationPolicy-title">--><?php //echo $info[$type.'_tax'] ?><!--</td>-->
                  <!--                          <td class="cancellationPolicy-title">--><?php //echo $info[$type.'_price'] ?><!--</td>-->
                  <!--                      </table>-->
                  <!--                    </div>-->
                  <!--                    <br/>-->
                  <!--                      --><?php
//                  }


                   if($info['api_id'] != 14) {
                       if (!empty($Fee) ) {
                           ?>
                                                  <div class="divborder" style="margin: 30px 98px 30px 98px;">
                                      <?php if($_GET['lang'] == 'fa'){ ?>
                                                    <div style="font-size: 19px ; color: #000; margin-top: -20px" class="divborderPoint">
                                                        جدول جرائم کنسلی
                                                    </div>
                                       <?php } ?>
                                                     <table width="100%" align="center" cellpadding="5" cellspacing="0" style="margin:10px;" border="1" class="solidBorder">
                                                       <?php if($_GET['lang'] == 'fa'){ ?>

                                                          <tr class="cancellationPolicy-tableHead">
                                                             <td class="cancellationPolicy-c1">کلاس پروازی</td>
                                                              <?php foreach($Fee['data'] as $item): ?>
                                                                 <td class="cancellationPolicy-title"><?php echo $item['title']; ?></td>
                                                              <?php endforeach; ?>
                                                          </tr>
                                                      <?php } else { ?>

                                                          <tr class="cancellationPolicy-tableHead">
                                                             <td class="cancellationPolicy-c1">کلاس پروازی</td>
                                                              <?php foreach($Fee['data'] as $item): ?>
                                                                 <td class="cancellationPolicy-title"><?php echo $item['title_en']; ?></td>
                                                              <?php endforeach; ?>
                                                          </tr>

                                                      <?php }  ?>
                                                        <tr>
                                                           <td class="cancellationPolicy-title"><?php echo $Fee['TypeClass']; ?></td>
                                                            <?php foreach($Fee['data'] as $item): ?>
                                                            <?php if($_GET['lang'] == 'fa'){ ?>
                                                               <td class="cancellationPolicy-title"><?php echo $item['fine_text']; ?></td>
                                                            <?php } else { ?>
                                                            <td class="cancellationPolicy-title"><?php echo $item['fine_text_en']; ?></td>
                                                                <?php } ?>
                                                            <?php endforeach; ?>

                                                        </tr>
                                                    </table>
                                                  </div>
                           <?php } else { ?>


                                                  <div class="divborder" style="margin: auto 100px">
                                                        <?php if($_GET['lang'] == 'fa'){ ?>

                                                           <div style="font-size: 19px ; color: #000; margin-top: -20px" class="divborderPoint">
                             جدول جرائم کنسلی
                          </div>
                       <?php } ?>
                                                    <table width="100%" align="center" cellpadding="5" cellspacing="0" style="margin:10px;" border="1"
                                                           class="solidBorder">
                                                <?php if($_GET['lang'] == 'fa'){ ?>

                                                      <tr class="cancellationPolicy-tableHead">
                                                        <td class="cancellationPolicy-c1">کلاس پروازی</td>
                                                        <td class="cancellationPolicy-c2">تا 12 ظهر 3 روز قبل از پرواز</td>
                                                        <td class="cancellationPolicy-c3">تا 12 ظهر 1 روز قبل از پرواز</td>
                                                        <td class="cancellationPolicy-c4">تا 3 ساعت قبل از پرواز</td>
                                                        <td class="cancellationPolicy-c5">تا 30 دقیقه قبل از پرواز</td>
                                                        <td class="cancellationPolicy-c6">از 30 دقیقه قبل پرواز به بعد</td>
                                                      </tr>


                                                        <tr>
                                                        <td class="cancellationPolicy-title" colspan="6">برای اطلاع از میزان جریمه کنسلی تماس بگیرید
                                                        </td>
                                                      </tr>
                                                      <?php } else { ?>

                                                       <tr class="cancellationPolicy-tableHead">
                                                        <td class="cancellationPolicy-c1">Flight class</td>
                                                        <td class="cancellationPolicy-c2">Until 12 noon 3 days before flight</td>
                                                        <td class="cancellationPolicy-c3">Until 12 noon 1 day before flight</td>
                                                        <td class="cancellationPolicy-c4">Up to 3 hours before flight</td>
                                                        <td class="cancellationPolicy-c5">Up to 30 minutes before flight</td>
                                                        <td class="cancellationPolicy-c6">From 30 minutes before the flight onwards</td>
                                                      </tr>
  <tr>
                                                        <td class="cancellationPolicy-title" colspan="6">
                                                        Call to find out the cancellation fee amount.
                                                        </td>
                                                      </tr>
                                                      <?php }  ?>

                                                    </table>
                                                  </div>
                           <?php }

                   }


               }
               ?>
               <table width="100%" align="center" style="margin: 15px 95px 15px 95px ;border-collapse: separate; border-spacing: <?php echo ((strtolower($info['flight_type']) == 'system' ? '0 0' : '10px 0')) ?>; "
                        class="page">

                    <tr style="padding-top:25px;">
                       <td style="padding:15px;" <?php $info['api_id'] != 14 ? "width='100%'" :" width='50%'"?> class="divborder">
                          <?php if($_GET['lang'] == 'fa'){ ?>
                          <h3>راهنمای ابطال و استرداد بلیط</h3>

                          <ul>
                             <li><span style="font-size:14px !important">در صورتی که به هر دلیلی بلیط شما کنسل شود مبلغ آن حداکثر در 72 ساعت از زمان درخواست به کیف پول شما واریز میشود</span></li>
                             <li><span style="font-size:14px !important;">شما به کیف پول خود میتوانید مجددا اقدام به خرید کنید و یا درخواست واریز به حساب خود را ثبت نمایید</span></li>
                          </ul>
                          <?php }else{ ?>
                             <h3>Ticket cancellation and refund guide</h3>

                             <ul>
                                <li><span style="font-size:14px !important">If your ticket is canceled for any reason, the amount will be credited to your wallet within 72 hours of the request.</span></li>
                                <li><span style="font-size:14px !important;">You can make purchases again with your wallet or request a deposit to your account.</span></li>
                             </ul>
                          <?php } ?>
                       </td>

              <?php
                if(strtolower($info['flight_type'])  != 'system' && $info['api_id'] != 14) {
                 ?>

                       <td style="padding:15px; text-align:right;" width="50%" class="divborder">
                          <?php if($_GET['lang'] == 'fa'){ ?>
                          <h3>قوانین کنسلی</h3>

                          <ul>
                             <li><span style="font-size:14px !important">ﻗﻮاﻧﻴﻦ کنسلی پروازهای چارتری ﺑﺮ اﺳﺎس ﺗﻔﺎﻫﻢ چارتر ﻛﻨﻨﺪه و ﺳﺎزﻣﺎن هواپیمایی ﻛﺸﻮری می ﺑﺎﺷﺪ</span></li>
                          </ul>
                           <?php }else{ ?>
                             <h3>Cancellation rules</h3>

                             <ul>
                                <li><span style="font-size:14px !important">Cancellation rules for charter flights are based on an agreement between the charterer and the national airline.</span></li>
                             </ul>
                          <?php } ?>
                       </td>
                   <?php

               }

               ?>


                    </tr>

                    <tr><td colspan="2" style="height:10px;"></td></tr>
                 </table>

              <div style="
              <?php
              if (CLIENT_ID == '166') {
                  echo 'display:none;';
              }
                  if(strtolower($info['flight_type']) != 'system'){
                      echo 'margin-top:35%';
                  }
              if(strtolower($info['flight_type']) == 'system'){
                  echo 'margin-top:30%';
              }
              ?>
                 ">
                  <?php if($StampAgency != ROOT_ADDRESS_WITHOUT_LANG.'/pic/'){ ?>
                     <div style='width: 90%' >
                        <img src="<?php echo $StampAgency ?>" height="100" style="max-width: 230px; float: left; margin: 0 -50px 0 0">
                     </div>
                  <?php } ?>
                 <hr style="margin: <?php echo ($StampAgency != ROOT_ADDRESS_WITHOUT_LANG.'/pic/') ? '10px' : '100px';?> 100px 5px 100px ; width: 90%"/>
                 <table width="100%" align="center" style="width:100%; margin: 10px 100px <?php echo ($info['request_cancel'] !='confirm' && $cash=='no') ? '20px' : '10px'?> 50px ;    font-size: 17px" scellpadding="0"
                        cellspacing="0">
                    <tr>
                       <td colspan="2">
                           <?= $_GET['lang'] == 'fa' ? 'آدرس :' : 'Address:'; ?>
                           <?php echo $ClientAddress; ?>

                       </td>
                    </tr>
                    <tr>
                       <td style="padding-top:15px">
                           <?= $_GET['lang'] == 'fa' ? 'وب سایت :' : 'Website:'; ?>
                           <?php echo $ClientMainDomain; ?>

                       </td>
                       <td style="padding-top:15px">
                           <?= $_GET['lang'] == 'fa' ? ' تلفن پشتیبانی :' : 'Support phone:'; ?>

                           <?php echo $phone; ?>
                       </td>
                        <?php if($info_ticket[0]['agency_id']) {?>
                           <td style="padding-top:15px">
                               <?= $_GET['lang'] == 'fa' ? 'تلفن کانتر فروش :' : 'Sales counter telephone:'; ?>

                               <?php echo $PhoneManage; ?>
                           </td>
                        <?php  } ?>
                    </tr>


                 </table>

              </div>





           <?php  } ?>
           </body>
           </html>
            <?php
        } else {
            echo '<div style = "text-align:center ; fon-size:20px ;font-family: iransans;" > اطلاعات مورد نظر موجود نمی باشد </div > ';
        }

        return $PrintTicket = ob_get_clean();
    }



    public function emailTicketSelf($request_number)
    {
        $Model = Load::library('Model');
        $sql = " SELECT * FROM book_local_tb WHERE request_number='{$request_number}'";
        $res_model = $Model->load($sql);

        if (!empty($res_model)) {

            if ($res_model['type_app'] == 'reservationBus') {
                $title = "چاپ رزرو";
                $subjectEmail = "رزرو تور";
            } else {
                $title = "چاپ بلیط";
                $subjectEmail = "خرید بلیط هواپیما";
            }

            $emailBody = 'با سلام' . '<br>';
            $emailBody .= 'دوست عزیز؛ از اینکه خدمات ما را انتخاب نموده اید سپاسگزاریم' . '<br>';
            $emailBody .= 'لطفا جهت مشاهده و ' . $title . ' بر روی دکمه ' . $title . ' که در قسمت پایین قرار دارد کلیک نمایید ' . '<br>';

            if ($res_model['type_app'] == 'reservationBus') {
                $param['title'] = ' تور ' . $res_model['flight_number'] . ' - ' . $res_model['desti_city'];
            } else {
                $param['title'] = 'بلیط هواپیما از  ' . $res_model['origin_city'] . ' به ' . $res_model['desti_city'];
            }
            $param['body'] = $emailBody;
            if ($res_model['type_app'] == 'reservation' || $res_model['type_app'] == 'reservationBus') {
                $param['pdf'][0]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=BookingReservationTicket&id=' . $request_number;
            } else {
                if($res_model['IsInternal']=='1')
                {
                    $param['pdf'][0]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=parvazBookingLocal&id=' . $request_number;
                }else{
                    $param['pdf'][0]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=ticketForeign&id=' . $request_number;
                }

            }
            $param['pdf'][0]['button_title'] = $title;

            $to = $res_model['email_buyer'];
            $subject = $subjectEmail;
            $message = functions::emailTemplate($param);
            $headers = "From: noreply@" . CLIENT_MAIN_DOMAIN . "\r\n";
//        $headers .= "Bcc: ghorbani2006@gmail.com\r\n";
//        $headers .="Bcc: developer@iran-tech.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8";
            ini_set('SMTP', 'smtphost');
            ini_set('smtp_port', 25);

            mail($to, $subject, $message, $headers);
        }
    }


    public function setPortBank($bankDir, $request_number)
    {


        if($bankDir !='privateGetWaySource7')
        {
            $initialValues = array(
                'bank_dir' => $bankDir,
                'serviceTitle' => $_POST['serviceType']
            );
            $bankModel = Load::model('bankList');
            $bankInfo = $bankModel->getByBankDir($initialValues);

            $data['name_bank_port'] = $bankDir;
            $data['number_bank_port'] = $bankInfo['param1'];
        }else{
            $data['name_bank_port'] = $bankDir;
            $data['number_bank_port'] = '0';
        }




        $Model = Load::library('Model');
        $Model->setTable('book_local_tb');

        foreach ($request_number as $direction => $request) {
            $condition = " request_number='{$request}'";
            $res = $Model->update($data, $condition);
            if ($res) {
                $ModelBase = Load::library('ModelBase');
                $ModelBase->setTable('report_tb');
                $ModelBase->update($data, $condition);
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

    public function delete_credit_Agency_current($requestNumber)
    {
        if (!$this->checkBookStatus($requestNumber)) {
            $Model = Load::library('Model');
            $condition = "requestNumber = '{$requestNumber}' AND requestNumber !='' AND type='decrease'";
            $Model->setTable('credit_detail_tb');
            $Model->delete($condition);
        }
    }

    public function checkBookStatus($factorNumber)
    {
        $Model = Load::library('Model');

        $query = "SELECT successfull FROM book_local_tb WHERE factor_number = '{$factorNumber}' OR request_number = '{$factorNumber}'";
        $result = $Model->load($query);

        return ($result['successfull'] == 'book') ? true : false;
    }

    public function setPortBankForReservationTicket($bankDir, $factorNumber)
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
        $Model->setTable('book_local_tb');

        $condition = " factor_number='{$factorNumber}'";
        $res = $Model->update($data, $condition);
        if ($res) {
            $ModelBase = Load::library('ModelBase');
            $ModelBase->setTable('report_tb');
            $ModelBase->update($data, $condition);
        }
    }

    public function sendUserToBank($factorNumber)
    {
        $data = array(
            'successfull' => "bank"
        );

        $condition = " (factor_number ='{$factorNumber}' OR request_number='{$factorNumber}') AND successfull = 'prereserve' ";
        Load::autoload('Model');
        $Model = new Model();

        $Model->setTable('book_local_tb');
        $Model->update($data, $condition);


        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $ModelBase->setTable('report_tb');
        $ModelBase->update($data, $condition);
    }

    public function sendUserToBankForReservationTicket($factorNumber)
    {
        $data = array(
            'successfull' => "bank"
        );

        $condition = " factor_number ='{$factorNumber}' ";

        $Model = Load::library('Model');
        $Model->setTable('book_local_tb');
        $Model->update($data, $condition);

        $ModelBase = Load::library('ModelBase');
        $ModelBase->setTable('report_tb');
        $ModelBase->update($data, $condition);
    }

    public function AmountAdded($Param)
    {

        $data['amount_added'] = $Param['AmountAdded'];

        $Condition = "factor_number='{$Param['factorNumber']}'";

        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $Model->setTable('book_local_tb');
        $ModelTicketUpdate = $Model->update($data, $Condition);

        if ($ModelTicketUpdate) {
            $ModelBase->setTable('report_tb');
            $ModelBaseTicketUpdate = $ModelBase->update($data, $Condition);
            if ($ModelBaseTicketUpdate) {
                return "SuccessToAmountAdded : افزایش قیمت  با موفقیت انجام شد";
            } else {
                return "Error : خطا در افزایش قیمت ";
            }
        } else {
            return "Error : خطا در افزایش قیمت ";
        }


    }

    public function changeTransactionInReturnFailure($factorNumber)
    {
        $Model = Load::library('Model');
        $objTransaction = Load::controller('transaction');

        $query = "SELECT  *, 
        (SELECT COUNT(id) FROM book_local_tb WHERE factor_number = '{$factorNumber}' AND direction = 'dept') AS count_id
        FROM book_local_tb WHERE factor_number = '{$factorNumber}' AND direction = 'dept'";
        $reserveInfo = $Model->load($query);

        $prices = parent::calculateTransactionPrice($reserveInfo['request_number']);
        $comment = "خرید" . ' ' . $reserveInfo['count_id'] . " عدد بلیط هواپیما از" . ' ' . $reserveInfo['origin_city'] . " به" . ' ' . $reserveInfo['desti_city'] . ' ' . "به شماره رزرو " . ' ' . $reserveInfo['request_number'] . $prices['pidTitle'];

        $data['Price'] = $prices['transactionPrice'];
        $data['Comment'] = $comment;
        $condition = " FactorNumber = '{$factorNumber}' ";
        $objTransaction->updateCredit($data, $condition);
    }

#region checkForeSourceFive
    public function checkForSourceFive($param)
    {
        /** @var airline $airlineController */
        $airlineController = Load::controller('airline');
        $dataCheckConfigAirline['flightType'] = $param['flight_type'] ;
        $dataCheckConfigAirline['airline'] = $param['airline_iata'] ;
        $dataCheckConfigAirline['isInternal'] = ($param['IsInternal']=='1') ? 'isInternal' : 'External';
        $dataCheckConfigAirline['sourceId'] = $param['sourceId'] ;
        $dataCheckConfigAirline['info'] = 'completed';

        return $airlineController->checkSourceAirline($dataCheckConfigAirline);
    }
#endregion


    public function returnBankSource7($requestNumber, $dataTicket) {
        $model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $objTransaction = Load::controller('transaction');
        $smsController = Load::controller('smsServices');
        $dataTicket = json_decode($dataTicket, true);
        $ReserveTicket = parent::getFinalDataSource7($requestNumber, $dataTicket);
        $sql = "SELECT * FROM book_local_tb WHERE request_number = '{$requestNumber}' GROUP BY direction";
        $resultDirection = $model->select($sql);
        $model->setTable('book_local_tb');
        foreach ($resultDirection as $eachDirection) {

            //            $this->direction[$eachDirection['direction']] = $eachDirection['direction'];
            $this->ticketInfo[$eachDirection['direction']] = $eachDirection;

            try {
                if ($ReserveTicket['Result']['Request']['Status'] == 'Ticketed') {

                    if (!empty($ReserveTicket['Result']['Request']['RequestPassengers'])) {
                        // Caution: آپدیت تراکنش به موفق
                        $objTransaction->setCreditToSuccess($eachDirection['factor_number'], $dataTicket['Data']['bank_Refnum']);
                        $this->transactionStatus = 'success';
                        $query = "SELECT * FROM book_local_tb WHERE request_number = '{$eachDirection['request_number']}'";
                        $ticketsCurrent = $model->select($query);
                        foreach ($ticketsCurrent as $i => $Ticket) {
                            $data['successfull'] = 'book';
                            $data['payment_date'] = Date('Y-m-d H:i:s');
                            $data['payment_type'] = 'cash';
                            $data['tracking_code_bank'] = $dataTicket['Data']['bank_Refnum'];

                            $data['pnr'] = $ReserveTicket['Result']['Request']['OutputRoutes'][0]['AirlinePnr'];
                            $data['eticket_number'] = !empty($ReserveTicket['Result']['Request']['RequestPassengers']) ? $ReserveTicket['Result']['Request']['RequestPassengers'][$i]['TicketNumber'] : '';

                            if ($ticketsCurrent[$i]['passenger_national_code'] != '0000000000') {
                                $uniqCondition = " AND passenger_national_code = '{$ticketsCurrent[$i]['passenger_national_code']}' ";
                            } else {
                                $uniqCondition = " AND passportNumber = '{$ticketsCurrent[$i]['passportNumber']}' ";
                            }

                            $condition = " request_number = '{$eachDirection['request_number']}' " . $uniqCondition;
                            $res = $model->update($data, $condition);

                            if ($res) {

                                $ModelBase->setTable('report_tb');
                                $conditionBase = " request_number = '{$eachDirection['request_number']}' " . $uniqCondition;
                                $ModelBase->update($data, $conditionBase);
                            }
                            $this->ok_flight[$eachDirection['direction']] = true;
                            $this->payment_date = $data['payment_date'];
                            $this->trackingCode = $dataTicket['Data']['bank_Refnum'];
                            $this->request_number[$eachDirection['direction']] = $eachDirection['request_number'];
                            $this->IsInternal = $eachDirection['IsInternal'];
                            functions::accountantRequestInsertData($eachDirection['request_number']);
                        }

                        if (functions::CalculateChargeAdminAgency(CLIENT_ID) < 10000000) {
                            //sms to site manager
                            $objSms = $smsController->initService('1');
                            if ($objSms) {
                                $sms = "مدیریت محترم آژانس" . " " . CLIENT_NAME . PHP_EOL . " شارژ حساب کاربری شما در نرم افزار سفر 360 به کمتر از 10,000,000 ریال رسیده است";
                                $smsArray = array('smsMessage' => $sms, 'cellNumber' => CLIENT_MOBILE);
                                $smsController->sendSMS($smsArray);
                            }
                        }

                        //email to buyer
                        $this->emailTicketSelf($eachDirection['request_number']);

                        //sms to buyer
                        $objSms = $smsController->initService('0');
                        if ($objSms) {
                            if (!empty($eachDirection['airline_name'])) {
                                $airlineName = $eachDirection['airline_name'];
                            } else {
                                $airlineNameInfo = functions::InfoAirline($eachDirection['airline_iata']);
                                $airlineName = $airlineNameInfo['name_fa'];
                            }

                            //to member
                            $messageVariables = array('sms_name' => $eachDirection['member_name'], 'sms_service' => 'بلیط', 'sms_factor_number' => $eachDirection['request_number'], 'sms_airline' => $airlineName, 'sms_origin' => $eachDirection['origin_city'], 'sms_destination' => $eachDirection['desti_city'], 'sms_flight_number' => $eachDirection['flight_number'], 'sms_flight_date' => dateTimeSetting::jdate("Y-F-d", functions::ConvertToDateJalaliInt($eachDirection['date_flight'])), 'sms_flight_time' => $eachDirection['time_flight'], 'sms_pdf' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=parvazBookingLocal&id=" . $eachDirection['request_number'], 'sms_agency' => CLIENT_NAME, 'sms_agency_mobile' => CLIENT_MOBILE, 'sms_agency_phone' => CLIENT_PHONE, 'sms_agency_email' => CLIENT_EMAIL, 'sms_agency_address' => CLIENT_ADDRESS,);
                            $smsArray = array('smsMessage' => $smsController->getUsableMessage('afterTicketReserve', $messageVariables), 'cellNumber' => $eachDirection['member_mobile'], 'smsMessageTitle' => 'afterTicketReserve', 'memberID' => (!empty($eachDirection['member_id']) ? $eachDirection['member_id'] : ''), 'receiverName' => $messageVariables['sms_name'],);
                            $smsController->sendSMS($smsArray);

                            //to manager
                            $smsArray = array('smsMessage' => $smsController->getUsableMessage('afterReserveToManager', $messageVariables), 'cellNumber' => CLIENT_MOBILE, 'smsMessageTitle' => 'afterReserveToManager', 'memberID' => (!empty($eachDirection['member_id']) ? $eachDirection['member_id'] : ''), 'receiverName' => 'مدیر سایت',);
                            $smsController->sendSMS($smsArray);

                            //to first passenger
                            $messageVariables['sms_name'] = $eachDirection['passenger_name'] . ' ' . $eachDirection['passenger_family'];
                            $smsArray = array('smsMessage' => $smsController->getUsableMessage('afterTicketReserve', $messageVariables), 'cellNumber' => $eachDirection['mobile_buyer'], 'smsMessageTitle' => 'afterTicketReserve', 'memberID' => (!empty($eachDirection['member_id']) ? $eachDirection['member_id'] : ''), 'receiverName' => $messageVariables['sms_name'],);
                            $smsController->sendSMS($smsArray);
                        }
                    }

                }
            } catch (Exception $e) {

                $d['message'] = $e->getMessage();
                $d['creation_date_int'] = time();
                $d['json_result'] = json_encode($ReserveTicket);
                $d['request_number'] = $eachDirection['request_number'];

                $ModelBase->setTable('log_res_action_tb');
                $ModelBase->insertLocal($d);
            }
        }
    }


//region decreaseCreditThatIsNotExist
    /**
     * @param $info_flight
     */
    public function decreaseCreditThatNotExist($info_flight) {
        $amount = functions::CalculateDiscount($info_flight['request_number']);
        $amount_currency = functions::CurrencyCalculate($amount);
        $this->getController('members')->decreaseCounterCredit($amount_currency['AmountCurrency'], $info_flight['request_number'], $info_flight, '', 'no');
    }
//endregion
    private function updateForCharterPlus($eachDirection, $ReserveTicket) {

        $data_routes = $this->getModel('bookRoutesModel')->where('RequestNumber', $eachDirection['request_number'])->all();

        //for dept
        $data_dept['pnr'] = $ReserveTicket['Result']['Request']['OutputRoutes'][0]['AirlinePnr'];
        $data_dept['ticketNumber'] = $ReserveTicket['Result']['Request']['OutputRoutes'][0]['AirlinePnr'];

        /* $res = $model->update($data, $condition);

         if ($res) {
             $data['private_m4'] = '3';
             $ModelBase->setTable('report_tb');
             $conditionBase = " request_number = '{$eachDirection['request_number']}' " . $uniqCondition;
             $ModelBase->update($data, $conditionBase);
         }*/
    }

    private function isTomorrow($start_time, $end_time) {
        // Current date
        $current_date = date('Y-m-d');

        // Parse start and end times into DateTime objects
        $start = new DateTime("$current_date $start_time");
        $end = new DateTime("$current_date $end_time");

        // If the end time is earlier than the start time, it's on the next day
        if ($end < $start) {
            return true; // End time is tomorrow
        }
        return false; // End time is the same day
    }

}

?>
