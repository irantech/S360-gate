<?php
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

class parvazBookingLocalFara extends apiLocal
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

    /**
     * Initialization public variable amadeus token
     * @author Anari
     */
    public function __construct()
    {

        parent::__construct();
        $this->payment_type = isset($_POST['flag']) ? $_POST['flag'] : '';
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
                                            'moqadam' => '09355501074',
                                            'fanipor' => '09129409530',
                                            'abasi' => '09030391954',
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
                            } else {
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
//                                                'abasi' => '09030391954',
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
                    } else {
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
                } else if ($eachDirection['direction'] == 'TwoWay' || $eachDirection['direction'] == 'multi_destination' ) {

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
            }else{
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

} else {
    $info_ticket = $this->getTicketDataByRequestNumber($param, $conditionCancelStatus);

}


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

?><!DOCTYPE html>
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
      }

      .page td {
          padding: 0;
          margin: 0;
      }

      .page {
          border-collapse: collapse;
      }

      @font-face {
          font-family: "Yekan";
          font-style: normal;
          font-weight: normal;
          src: url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.woff?#iefix") format("embedded-opentype"),
          url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.woff") format("woff"),
          url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.ttf") format("truetype");

      }

      table {
          font-family: Yekan !important;
          border-collapse: collapse;
      }

      table.solidBorder, .solidBorder th, .solidBorder td {
          border: 1px solid #CCC;
      }

      .element:last-child {
          page-break-after: auto;
      }
  </style>

</head>
<body><?php

foreach ($info_ticket as $key=>$info) {

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

    $Fee = functions::FeeCancelFlight($info['airline_iata'], $CabinType);

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


    ?>
  <table width="100%" align="center" style="margin: 100px ; border: 1px solid #CCC;" cellpadding="0" cellspacing="0"
         class="page">

      <?php
      if (isset($cancelStatus) && $cancelStatus == 'confirm'){
          ?>
        <tr style="text-align: center !important;">
          <td style="font-size: 30px; font-weight: 700;padding: 10px ;text-align: center !important;">
            <div style="text-align: center !important;">رسید کنسلی</div>
          </td>
        </tr>
          <?php
      }
      ?>

    <tr>
      <td style="width: 30%; text-align: center; padding-bottom: 5px; " valign="bottom">

        <table>
          <tr>
            <td><img src="<?php echo $LogoAgency ?>" height="100" style="max-width: 230px;"></td>
          </tr>
        </table>

      </td>
      <td style="width: 70%;">
        <table style="" cellpadding="0" cellspacing="0" class="page">
          <tr>
            <td style="width: 100%; color: #FFF; height: 120px; " colspan="2">
              sdfsdfsdfasddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd
              asdsaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
              asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
              asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
              asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
              asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
            </td>
          </tr>
          <tr>
            <td style="border: 1px solid #CCC; font-size: 20px; font-weight: bolder; padding: 10px ; border-left: none;"
                width="50%">
              <span style="float:right;"><?php echo $gender . ' ' . $info['passenger_name'] . ' ' . $info['passenger_family'] ?> </span>
            </td>
            <td width="50%"
                style=" border: 1px solid #CCC; font-size: 20px;  font-weight: bolder; padding: 10px ; text-align: left; border-right: none; direction:ltr">
              <span style="float:left;text-align: left"><?php echo '(' . $genderEn . ')' . $info['passenger_name_en'] . ' ' . $info['passenger_family_en'] ?></span>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>

      <td style="width: 30%;  border: 1px solid #CCC;" align="center">
        <table style="width: 100%" cellpadding="0" cellspacing="0" class="page">
          <tr style="border-bottom: 1px solid #CCC">
            <td width="280px" align="center" style="border-bottom: 1px solid #CCC">
              <table cellpadding="0" cellspacing="0" class="page">
                <tr>
                  <td align="center">
                    <img src="<?php echo $picAirline ?>" style="float:right; width: 50px;margin-top: 0px; margin-right:10px">
                  </td>
                </tr>
                <tr>
                  <td align="center" style="float: right; font-size: 18px; margin-bottom: 10px;">
                      <?php echo "هواپیمایی {$airlineName['name_fa']}";?>
                  </td>
                </tr>
              </table>


            </td>
          </tr>
          <tr>
            <td>
              <table style="width: 100%" cellpadding="0" cellspacing="0" class="page">
                <tr style="">
                  <td width="140" height="35" align="right"
                      style="padding: 5px; border-bottom: 1px solid #CCC ">
                    <span style="float: right;font-size: 11px;  color:#006cb5; position: relative; right: 0;">پرواز</span>
                    <span style="float: left ; position: relative; left: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <span style="float: left ; position: relative; left: 0;"><?php echo $info['flight_number']; ?></span>
                  </td>

                  </td>
                  <td width="140" align="center"
                      style="padding: 5px; border-right: 1px solid #CCC;  border-bottom: 1px solid #CCC">
                    <span style="float: right;"><?php echo $seat_class ?></span>
                    <span style="float: left;"><?php echo '(' . $info['cabin_type'] . ' )' ?></span>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" height="35" align="right"
                      style="padding: 5px ; border-bottom: 1px solid #CCC" width="280">
                      <?php echo !empty($info['eticket_number']) ? '<span style="float: right; font-size: 11px;  color:#006cb5 ;text-align: right">شماره بلیط</span>' : ''; ?>
                    <span style="float: left ; position: relative; left: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <span style="float: left;"><?php echo !empty($info['eticket_number']) ? $info['eticket_number'] : '' ?> </span>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" align="center" style="padding: 10px" width="280">
                    <img src="https://versagasht.com/gds/library/barcode/barcode_creator.php?barcode=<?php echo trim($info['eticket_number']) ?>"
                         style="max-width: 100px; min-height: 50px">
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>

      <td style="width: 70%; border: 1px solid #CCC; border-right:none ; border-top:none; vertical-align: top">

        <table style="width: 100%;border:1px solid #CCC" cellpadding="0" cellspacing="0" class="page" border="0"
               valign="top">
          <tr>
            <td style="border-left: 1px solid #CCC;" width="450">
              <table style="width: 100%;" cellpadding="0" cellspacing="0" class="page" border="0">
                <tr>
                  <td width="" style="border-bottom:1px solid #CCC">
                    <table style="width: 100%; font-size: 20px" cellpadding="0" cellspacing="0"
                           class="page" border="0">
                      <tr>
                        <td width="200" height="70" align="center" valign="middle"
                            style="font-size: 25px">
                            <?php echo $info['origin_city']; ?>
                        </td>
                        <td width="50" align="center" valign="middle">
                          <img src="<?php echo $airplan ?>"
                               style="float:right; max-height:30px;"/>
                        </td>
                        <td width="200" align="center" valign="middle" style="font-size: 25px">
                            <?php echo $info['desti_city']; ?>
                        </td>
                      </tr>
                      <tr>
                        <td width="200" height="30" align="center" valign="middle"
                            style="font-size: 25px">
                            <?php echo $resultLocal->format_hour($info['time_flight']); ?>
                        </td>
                        <td width="50" align="center" valign="middle">
                          -
                        </td>
                        <td width="200" align="center" valign="middle" style="font-size: 25px">
                            <?php echo $resultLocal->format_hour_arrival($info['origin_airport_iata'], $info['desti_airport_iata'], $info['time_flight']); ?>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="3" height="70" align="center" valign="middle"
                            style="font-size: 25px; direction: rtl; text-align: right">
                            <?php $date = functions::OtherFormatDate($info['date_flight']);

                            echo  $date['DepartureDate'].'<br/> '. $date['LetterDay']   ;
                            ?>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td>
                    <table width="450" cellpadding="0" cellspacing="0" class="page" border="0">
                      <tr>
                        <td width="50%" height="40" align="center" valign="middle"
                            style="border-left: 1px solid #CCC;">
                            <?php echo $flight_type;   ?>
                        </td>
                        <td width="50%" align="center" valign="middle" style="font-size: 20px;">

                          تأیید شده
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>

            <td width="210" height="100%">
              <table style="width: 100%" cellpadding="0" cellspacing="0" class="page" border="0">
                <tr style="border-bottom: 1px solid #CCC">
                  <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                      height="50">
                    <span style="float: left;font-size: 11px;  color:#006cb5 ; text-align: left">ملیت</span>
                    <span style="float: left ; position: relative; left: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <span style="float: left ; position: relative; left: 0;"><?php echo functions::country_code(($info['passportCountry'] != 'IRN' && $info['passportCountry'] != '' ? $info['passportCountry'] : 'IRN'), 'fa') ?></span>
                  </td>
                </tr>
                <tr style="border-bottom: 1px solid #CCC">
                  <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                      height="50">
                    <span style="float: left;font-size: 11px;  color:#006cb5 ; text-align: left">رده سنی</span>
                    <span style="float: left ; position: relative; left: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <span style="float: left ; position: relative; left: 0;"><?php echo $infoAge ?></span>
                  </td>
                </tr>
                <tr style="border-bottom: 1px solid #CCC">
                  <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC;"
                      height="50">
                    <span><?php echo !empty($info['pnr']) ? $info['pnr'] : '' ?></span>
                    <span style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                      <?php echo !empty($info['pnr']) ? '<span style="font-size: 11px;  color:#006cb5;">PNR</span>' : ''; ?>
                  </td>
                </tr>
                <tr style="border-bottom: 1px solid #CCC">
                  <td width="160" align="right" height="50" style="padding-right: 5px">
                    <span style="float: right;font-size: 11px;  color:#006cb5; ">قیمت</span>
                    <span style="float: left ; position: relative; left: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                      <?php
                      if ($cash == 'no') {
                          echo '<span style="float: left ; position: relative; left: 0;">Cash</span> ';

                      } else {

                          if (functions::TypeUser($info['member_id']) == 'Counter') {
                              if ($info['percent_discount'] > 0) {
                                  echo '<span style="float: left ; position: relative; left: 0; text-decoration: line-through">' . number_format($priceTotal) . ' ریال</span> ';
                                  echo '<br/>';
                                  echo '<span style="float: left ; position: relative; left: 0;">' . number_format($priceTotalWithOutDiscount) . ' ریال</span> ';
                              } else {
                                  echo '<span style="float: left ; position: relative; left: 0;">' . number_format($priceTotal) . ' ریال</span> ';
                              }
                          }else{
                              echo '<span style="float: left ; position: relative; left: 0;">' . number_format($priceTotal) . ' ریال</span> ';
                          }

                      }
                      ?>
                  </td>
                </tr>

              </table>
            </td>
          </tr>
          <tr>
            <!--                        <td --><?php //if (empty($resultOffCode)) {
              //                            echo 'colspan="2"';
              //                        } ?><!-- style="padding: 10px; border-top: 1px solid #CCC ">-->
            <!--                            <span style="float: right; font-size: 11px; color:#006cb5;">شماره رزرو</span>-->
            <!--                            <span></span>-->
            <!--                            <span style="float: left; margin-right: 20px; font-size: 17px;">--><?php //echo $info['request_number'] ?><!-- </span>-->
            <!--                            <span style="float: right; font-size: 11px; color:#006cb5;"> رزرو شده در  </span>-->
            <!--                            <span>--><?php //echo $AgencyName ?><!--</span>-->
            <!--                        </td>-->
              <?php

              $check_client_configuration = functions::checkClientConfigurationAccess('show_flight_pdf_date',CLIENT_ID);

              ?>
            <td <?php if (!$check_client_configuration) {
                echo 'colspan="2"';
            } ?> style="padding: 10px; border-top: 1px solid #CCC ">
              <span style="float: right; font-size: 11px; color:#006cb5;">شماره رزرو</span>
              <span></span>
              <span style="float: left; margin-right: 20px; font-size: 17px;"><?php echo $info['request_number'] ?> </span>
              <span style="float: right; font-size: 11px; color:#006cb5;"> رزرو شده در  </span>
              <span><?php echo $AgencyName ?></span>
            </td>


              <?php

              $check_client_configuration= functions::checkClientConfigurationAccess('show_flight_pdf_date',CLIENT_ID);
              if($check_client_configuration){
                  ?>
                <td colspan="1" style="padding: 10px; border-top: 1px solid #CCC ">

                  <span style="float: right; font-size: 11px; color:#006cb5;"> در تاریخ </span>
                  <span style="direction:rtl !important;"><?php echo functions::printDateIntByLanguage('Y-m-d (H:i)',$info['creation_date_int'],SOFTWARE_LANG) ?></span>
                </td>
              <?php } ?>

            <!--                        --><?php //if (!empty($resultOffCode)) { ?>
            <!--                            <td style="padding: 10px; border-top: 1px solid #CCC; border-right: 1px solid #CCC; ">-->
            <!--                                <span style="float: right; font-size: 11px; color:#006cb5;">کد ترانسفر</span>-->
            <!--                                <span></span>-->
            <!--                                <span style="float: left; margin-right: 20px; font-size: 17px;">--><?php //echo $resultOffCode['offCode']; ?><!-- </span>-->
            <!--                            </td>-->
            <!--                        --><?php //} ?>
          </tr>
        </table>

      </td>
    </tr>

  </table>


    <?php
    if ($info['request_cancel'] != 'confirm' && ($info['successfull'] == 'book' || $info['successfull'] == 'private_reserve')){
        ?>
      <div class="divborder" style="margin: 100px 100px <?php echo ($info['request_cancel'] !='confirm' && $cash=='no') ? '500px':'100px'?>100px ;">
        <div style="font-size: 19px ; color: #006cb5; margin-top: -20px" class="divborderPoint"> به نکات زیر توجه
          نمایید:
        </div>
        <table width="100%" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td></td>
          </tr>

          <tr>
            <td style="padding-bottom: 20px">
              <ul>
                <li>حداکثر بار مجاز برابر با 20کیلو گرم می باشد</li>
                <li>مسافر گرامی، با توجه به شیوع ویروس کرونا استفاده از ماسک در بدو ورود به فرودگاه الزامی میباشد. در غیر این صورت حراست فرودگاه از ورود شما جلوگیری خواهد نمود</li>
                <li>در هنگام سوار شدن حتما مدرک شناسایی (کارت ملی) همراه خود داشته باشید</li>
                <li>حتما 2 ساعت قبل از پرواز در فرودگاه حاضر باشید</li>
                <li>در صورت کنسلی پرواز توسط ایرلاین، مسافر و یا تعجیل ؛ یا تاخیر بیش از 2 ساعت خواهشمند است
                  نسبت به مهر نمودن بلیط در فرودگاه و یا دریافت رسید اقدام نمایید
                </li>
                <li>ارائه کارت شناسایی عکس دار و معتبر جهت پذیرش بلیط و سوار شدن به هواپیما</li>
                <li>ترمینال 1 : کیش‌ایر، وارش،زاگرس</li>
                <li>ترمینال 2 : ایران ایر، ایر تور، آتا، قشم ایر، معراج، نفت(کارون)</li>
                <li>ترمینال 4 : ماهان، کاسپین، آسمان، اترک، تابان، سپهران،فلای پرشیا،ساها،پویا</li>
                <li>درصورتی که بلیط شما به هر دلیلی با مشکل مواجه شد لطفا با شماره تلفن های آژانس که در انتهای
                  بلیط نمایش داده شده تماس حاصل فرمائید
                </li>

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
      <div class="divborder" style="margin: 10px 100px 400px 100px;">
        <div style="font-size: 19px ; color: #006cb5; margin-top: -20px;text-align: center;" class="divborderPoint"> توضیحات</div>
        <table width="100%" align="center" cellpadding="5" cellspacing="0" style="margin: 10px;">
          <tr>
            <td class="cancellationPolicy-title" colspan="6" style="font-size: 20px; font-weight: 700;">پرواز فوق در تاریخ <?php echo $date ?> با درصد <?php echo  $info['cancelTicketPercent'] ?> و مبلغ <?php echo number_format($info['cancelTicketPriceIndemnity']) ?>  ریال استرداد شده است.</td>
          </tr>
        </table>
      </div>
      <br/>
      <br/>
      <br/>
      <br/>
      <br/>
      <br/>
      <br/>
      <br/>
      <br/>
      <br/>

        <?php
    } elseif (strtolower($info['flight_type']) == 'system' && $cash !='no') {

        if($info['amount_added'] ==0)
        {
            $type='';
            if($info['passenger_age']=='Adt'){
                $type = 'adt';
            }else if($info['passenger_age']=='Chd'){
                $type = 'chd';
            }else if($info['passenger_age']=='Inf'){
                $type = 'inf';
            }
            ?>
          <div class="divborder" style="margin: 10px 100px;">
            <div style="font-size: 19px ; color: #006cb5; margin-top: -20px" class="divborderPoint">جزئیات قیمت:
            </div>
            <table width="100%" align="center" cellpadding="5" cellspacing="0" style="margin:10px;" border="1"
                   class="solidBorder">
              <tr class="cancellationPolicy-tableHead">
                <td class="cancellationPolicy-c1"> fare</td>
                <td class="cancellationPolicy-c2">tax</td>
                <td class="cancellationPolicy-c3">total</td>
              </tr>
              <tr>
                <td class="cancellationPolicy-title"><?php echo $info[$type.'_fare'] ?></td>
                <td class="cancellationPolicy-title"><?php echo $info[$type.'_tax'] ?></td>
                <td class="cancellationPolicy-title"><?php echo $info[$type.'_price'] ?></td>
            </table>
          </div>
          <br/>
            <?php
        }



        if (!empty($Fee)) {
            ?>'
          <div class="divborder" style="margin: 10px 100px 350px 100px;">
            <div style="font-size: 19px ; color: #006cb5; margin-top: -20px" class="divborderPoint"> جدول جرائم
              کنسلی:
            </div>
            <table width="100%" align="center" cellpadding="5" cellspacing="0" style="margin:10px;" border="1"
                   class="solidBorder">
              <tr class="cancellationPolicy-tableHead">
                <td class="cancellationPolicy-c1">کلاس پروازی</td>
                <td class="cancellationPolicy-c2">تا 12 ظهر 3 روز قبل از پرواز</td>
                <td class="cancellationPolicy-c3">تا 12 ظهر 1 روز قبل از پرواز</td>
                <td class="cancellationPolicy-c4">تا 3 ساعت قبل از پرواز</td>
                <td class="cancellationPolicy-c5">تا 30 دقیقه قبل از پرواز</td>
                <td class="cancellationPolicy-c6">از 30 دقیقه قبل پرواز به بعد</td>
              </tr>
              <tr>
                <td class="cancellationPolicy-title"><?php echo $Fee['TypeClass'] ?></td>
                <td class="cancellationPolicy-title"><?php echo $Fee['ThreeDaysBefore'] ?>%</td>
                <td class="cancellationPolicy-title"><?php echo $Fee['OneDaysBefore'] ?>%</td>
                <td class="cancellationPolicy-title"><?php echo $Fee['ThreeHoursBefore'] ?>%</td>
                <td class="cancellationPolicy-title"><?php echo $Fee['ThirtyMinutesAgo'] ?>%</td>
                <td class="cancellationPolicy-title"><?php echo $Fee['OfThirtyMinutesAgoToNext'] ?>%</td>
              </tr>
            </table>
          </div>
            <?php
        } else { ?>
          <div class="divborder" style="margin: 10px 100px 350px 100px;">
            <div style="font-size: 19px ; color: #006cb5; margin-top: -20px" class="divborderPoint"> جدول جرائم
              کنسلی:
            </div>
            <table width="100%" align="center" cellpadding="5" cellspacing="0" style="margin:10px;" border="1"
                   class="solidBorder">

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
            </table>
          </div>
            <?php
        }
    } else if(strtolower($info['flight_type'])  != 'system') {
        ?>
      <div class="divborder" style="margin: 10px 100px 350px 100px;">
        <div style="font-size: 19px ; color: #006cb5; margin-top: -20px" class="divborderPoint"> جدول جرائم کنسلی:
        </div>
        <table width="100%" align="center" cellpadding="5" cellspacing="0" style="margin: 10px;">

          <tr>
            <td class="cancellationPolicy-title" colspan="6">قوانين كنسلی پروازهای چارتری بر اساس تفاهم چارتر
              كننده و سازمان هواپيمايی كشوری می باشد
            </td>
          </tr>
        </table>
      </div>
        <?php

    }

    ?>
    <?php if($StampAgency != ROOT_ADDRESS_WITHOUT_LANG.'/pic/'){ ?>
    <div style="margin: 200px <?php echo ($StampAgency != ROOT_ADDRESS_WITHOUT_LANG.'/pic/') ? '700px' : '100px'?>  <?php echo ($cash == 'no') ? '100px' : '0'?> 100px ; width: 90%">
      <img src="<?php echo $StampAgency ?>" height="100" style="max-width: 230px;">
    </div>
    <?php } ?>
  <hr style="margin: <?php echo ($StampAgency != ROOT_ADDRESS_WITHOUT_LANG.'/pic/') ? '70px' : '150px';?> 100px 0 100px ; width: 90%"/>
  <table width="100%" align="center" style="position:fixed ;width:100%; margin: 10px 100px <?php echo ($info['request_cancel'] !='confirm' && $cash=='no') ? '520px' : '0'?> 0px ; font-size: 17px" scellpadding="0"
         cellspacing="0">

    <tr>
      <td>
        وب سایت :
          <?php echo $ClientMainDomain; ?>

      </td>
      <td> تلفن پشتیبانی :
          <?php echo $phone; ?>
      </td>
        <?php if($info_ticket[0]['agency_id']) {?>
          <td> تلفن کانتر فروش :
              <?php echo $PhoneManage; ?>
          </td>
        <?php  } ?>
    </tr>
    <tr>
      <td colspan="2">
        آدرس :
          <?php echo $ClientAddress; ?>

      </td>
    </tr>

  </table>


<?php } ?>
</body>
</html>
<?php
} else {
    echo '<div style = "text-align:center ; fon-size:20px ;font-family: Yekan;" > اطلاعات مورد نظر موجود نمی باشد </div > ';
}

return $PrintTicket = ob_get_clean();
}
    public function createPdfContentFara($param, $cash, $cancelStatus)
    {

        $resultLocal = Load::controller('resultLocal');


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

        } else {
            $info_ticket = $this->getTicketDataByRequestNumber($param, $conditionCancelStatus);

        }


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
                }

                .page td {
                    padding: 0;
                    margin: 0;
                }

                .page {
                    border-collapse: collapse;
                }

                @font-face {
                    font-family: "Yekan";
                    font-style: normal;
                    font-weight: normal;
                    src: url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.woff?#iefix") format("embedded-opentype"),
                    url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.woff") format("woff"),
                    url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.ttf") format("truetype");

                }

                table {
                    font-family: Yekan !important;
                    border-collapse: collapse;
                }

                table.solidBorder, .solidBorder th, .solidBorder td {
                    border: 1px solid #CCC;
                }

                .element:last-child {
                    page-break-after: auto;
                }
            </style>

          </head>
          <body>
          <?php

          foreach ($info_ticket as $key=>$info) {

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

              $Fee = functions::FeeCancelFlight($info['airline_iata'], $CabinType);

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


              ?>
            <div  style='margin-top: 1000px'>
            <table width="100%" align="center" style="margin: 20px 100px 20px 100px ; border: 1px solid #CCC;   " cellpadding="0" cellspacing="0"
                   class="page">

                <?php
                if (isset($cancelStatus) && $cancelStatus == 'confirm'){
                    ?>
                  <tr style="text-align: center !important;">
                    <td style="font-size: 30px; font-weight: 700;padding: 10px ;text-align: center !important;">
                      <div style="text-align: center !important;">رسید کنسلی</div>
                    </td>
                  </tr>
                    <?php
                }
                ?>

              <tr>
                <td style="width: 30%; text-align: center; padding-bottom: 5px; " valign="bottom">

                  <table>
                    <tr>
                      <td><img src="<?php echo $LogoAgency ?>" height="100" style="max-width: 230px;"></td>
                    </tr>
                  </table>

                </td>
                <td style="width: 70%;">
                  <table style="" cellpadding="0" cellspacing="0" class="page">
                    <tr>
                      <td style="width: 100%; color: #FFF; height: 120px; " colspan="2">
                        sdfsdfsdfasddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd
                        asdsaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                        asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                        asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                        asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                        asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                      </td>
                    </tr>
                    <tr>
                      <td style="border: 1px solid #CCC; font-size: 20px; font-weight: bolder; padding: 10px ; border-left: none;"
                          width="50%">
                        <span style="float:right;"><?php echo $gender . ' ' . $info['passenger_name'] . ' ' . $info['passenger_family'] ?> </span>
                      </td>
                      <td width="50%"
                          style=" border: 1px solid #CCC; font-size: 20px;  font-weight: bolder; padding: 10px ; text-align: left; border-right: none; direction:ltr">
                        <span style="float:left;text-align: left"><?php echo '(' . $genderEn . ')' . $info['passenger_name_en'] . ' ' . $info['passenger_family_en'] ?></span>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>

                <td style="width: 30%;  border: 1px solid #CCC;" align="center">
                  <table style="width: 100%" cellpadding="0" cellspacing="0" class="page">
                    <tr style="border-bottom: 1px solid #CCC">
                      <td width="280px" align="center" style="border-bottom: 1px solid #CCC">
                        <table cellpadding="0" cellspacing="0" class="page">
                          <tr>
                            <td align="center">
                              <img src="<?php echo $picAirline ?>" style="float:right; width: 50px;margin-top: 0px; margin-right:10px">
                            </td>
                          </tr>
                          <tr>
                            <td align="center" style="float: right; font-size: 18px; margin-bottom: 10px;">
                                <?php echo "هواپیمایی {$airlineName['name_fa']}";?>
                            </td>
                          </tr>
                        </table>


                      </td>
                    </tr>
                    <tr>
                      <td>
                        <table style="width: 100%" cellpadding="0" cellspacing="0" class="page">
                          <tr style="">
                            <td width="140" height="35" align="right"
                                style="padding: 5px; border-bottom: 1px solid #CCC ">
                              <span style="float: right;font-size: 11px;  color:#006cb5; position: relative; right: 0;">پرواز</span>
                              <span style="float: left ; position: relative; left: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                              <span style="float: left ; position: relative; left: 0;"><?php echo $info['flight_number']; ?></span>
                            </td>

                            </td>
                            <td width="140" align="center"
                                style="padding: 5px; border-right: 1px solid #CCC;  border-bottom: 1px solid #CCC">
                              <span style="float: right;"><?php echo $seat_class ?></span>
                              <span style="float: left;"><?php echo '(' . $info['cabin_type'] . ' )' ?></span>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2" height="35" align="right"
                                style="padding: 5px ; border-bottom: 1px solid #CCC" width="280">
                                <?php echo !empty($info['eticket_number']) ? '<span style="float: right; font-size: 11px;  color:#006cb5 ;text-align: right">شماره بلیط</span>' : ''; ?>
                              <span style="float: left ; position: relative; left: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                              <span style="float: left;"><?php echo !empty($info['eticket_number']) ? $info['eticket_number'] : '' ?> </span>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2" align="center" style="padding: 10px" width="280">
                              <img src="https://versagasht.com/gds/library/barcode/barcode_creator.php?barcode=<?php echo trim($info['eticket_number']) ?>"
                                   style="max-width: 100px; min-height: 50px">
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>

                <td style="width: 70%; border: 1px solid #CCC; border-right:none ; border-top:none; vertical-align: top">

                  <table style="width: 100%;border:1px solid #CCC" cellpadding="0" cellspacing="0" class="page" border="0"
                         valign="top">
                    <tr>
                      <td style="border-left: 1px solid #CCC;" width="450">
                        <table style="width: 100%;" cellpadding="0" cellspacing="0" class="page" border="0">
                          <tr>
                            <td width="" style="border-bottom:1px solid #CCC">
                              <table style="width: 100%; font-size: 20px" cellpadding="0" cellspacing="0"
                                     class="page" border="0">
                                <tr>
                                  <td width="200" height="70" align="center" valign="middle"
                                      style="font-size: 25px">
                                      <?php echo $info['origin_city']; ?>
                                  </td>
                                  <td width="50" align="center" valign="middle">
                                    <img src="<?php echo $airplan ?>"
                                         style="float:right; max-height:30px;"/>
                                  </td>
                                  <td width="200" align="center" valign="middle" style="font-size: 25px">
                                      <?php echo $info['desti_city']; ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="200" height="30" align="center" valign="middle"
                                      style="font-size: 25px">
                                      <?php echo $resultLocal->format_hour($info['time_flight']); ?>
                                  </td>
                                  <td width="50" align="center" valign="middle">
                                    -
                                  </td>
                                  <td width="200" align="center" valign="middle" style="font-size: 25px">
                                      <?php echo $resultLocal->format_hour_arrival($info['origin_airport_iata'], $info['desti_airport_iata'], $info['time_flight']); ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="3" height="70" align="center" valign="middle"
                                      style="font-size: 25px; direction: rtl; text-align: right">
                                      <?php $date = functions::OtherFormatDate($info['date_flight']);

                                      echo  $date['DepartureDate'].'<br/> '. $date['LetterDay']   ;
                                      ?>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <table width="450" cellpadding="0" cellspacing="0" class="page" border="0">
                                <tr>
                                  <td width="50%" height="40" align="center" valign="middle"
                                      style="border-left: 1px solid #CCC;">
                                      <?php echo $flight_type;   ?>
                                  </td>
                                  <td width="50%" align="center" valign="middle" style="font-size: 20px;">

                                    تأیید شده
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>

                      <td width="210" height="100%">
                        <table style="width: 100%" cellpadding="0" cellspacing="0" class="page" border="0">
                          <tr style="border-bottom: 1px solid #CCC">
                            <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                                height="50">
                              <span style="float: left;font-size: 11px;  color:#006cb5 ; text-align: left">ملیت</span>
                              <span style="float: left ; position: relative; left: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                              <span style="float: left ; position: relative; left: 0;"><?php echo functions::country_code(($info['passportCountry'] != 'IRN' && $info['passportCountry'] != '' ? $info['passportCountry'] : 'IRN'), 'fa') ?></span>
                            </td>
                          </tr>
                          <tr style="border-bottom: 1px solid #CCC">
                            <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                                height="50">
                              <span style="float: left;font-size: 11px;  color:#006cb5 ; text-align: left">رده سنی</span>
                              <span style="float: left ; position: relative; left: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                              <span style="float: left ; position: relative; left: 0;"><?php echo $infoAge ?></span>
                            </td>
                          </tr>
                          <tr style="border-bottom: 1px solid #CCC">
                            <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC;"
                                height="50">
                              <span><?php echo !empty($info['pnr']) ? $info['pnr'] : '' ?></span>
                              <span style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <?php echo !empty($info['pnr']) ? '<span style="font-size: 11px;  color:#006cb5;">PNR</span>' : ''; ?>
                            </td>
                          </tr>
                          <tr style="border-bottom: 1px solid #CCC">
                            <td width="160" align="right" height="50" style="padding-right: 5px">
                              <span style="float: right;font-size: 11px;  color:#006cb5; ">قیمت</span>
                              <span style="float: left ; position: relative; left: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <?php
                                if ($cash == 'no') {
                                    echo '<span style="float: left ; position: relative; left: 0;">Cash</span> ';

                                } else {

                                    if (functions::TypeUser($info['member_id']) == 'Counter') {
                                        if ($info['percent_discount'] > 0) {
                                            echo '<span style="float: left ; position: relative; left: 0; text-decoration: line-through">' . number_format($priceTotal) . ' ریال</span> ';
                                            echo '<br/>';
                                            echo '<span style="float: left ; position: relative; left: 0;">' . number_format($priceTotalWithOutDiscount) . ' ریال</span> ';
                                        } else {
                                            echo '<span style="float: left ; position: relative; left: 0;">' . number_format($priceTotal) . ' ریال</span> ';
                                        }
                                    }else{
                                        echo '<span style="float: left ; position: relative; left: 0;">' . number_format($priceTotal) . ' ریال</span> ';
                                    }

                                }
                                ?>
                            </td>
                          </tr>

                        </table>
                      </td>
                    </tr>
                    <tr>
                      <!--                        <td --><?php //if (empty($resultOffCode)) {
                        //                            echo 'colspan="2"';
                        //                        } ?><!-- style="padding: 10px; border-top: 1px solid #CCC ">-->
                      <!--                            <span style="float: right; font-size: 11px; color:#006cb5;">شماره رزرو</span>-->
                      <!--                            <span></span>-->
                      <!--                            <span style="float: left; margin-right: 20px; font-size: 17px;">--><?php //echo $info['request_number'] ?><!-- </span>-->
                      <!--                            <span style="float: right; font-size: 11px; color:#006cb5;"> رزرو شده در  </span>-->
                      <!--                            <span>--><?php //echo $AgencyName ?><!--</span>-->
                      <!--                        </td>-->
                        <?php

                        $check_client_configuration = functions::checkClientConfigurationAccess('show_flight_pdf_date',CLIENT_ID);

                        ?>
                      <td <?php if (!$check_client_configuration) {
                          echo 'colspan="2"';
                      } ?> style="padding: 10px; border-top: 1px solid #CCC ">
                        <span style="float: right; font-size: 11px; color:#006cb5;">شماره رزرو</span>
                        <span></span>
                        <span style="float: left; margin-right: 20px; font-size: 17px;"><?php echo $info['request_number'] ?> </span>
                        <span style="float: right; font-size: 11px; color:#006cb5;"> رزرو شده در  </span>
                        <span><?php echo $AgencyName ?></span>
                      </td>


                        <?php

                        $check_client_configuration= functions::checkClientConfigurationAccess('show_flight_pdf_date',CLIENT_ID);
                        if($check_client_configuration){
                            ?>
                          <td colspan="1" style="padding: 10px; border-top: 1px solid #CCC ">

                            <span style="float: right; font-size: 11px; color:#006cb5;"> در تاریخ </span>
                            <span style="direction:rtl !important;"><?php echo functions::printDateIntByLanguage('Y-m-d (H:i)',$info['creation_date_int'],SOFTWARE_LANG) ?></span>
                          </td>
                        <?php } ?>

                      <!--                        --><?php //if (!empty($resultOffCode)) { ?>
                      <!--                            <td style="padding: 10px; border-top: 1px solid #CCC; border-right: 1px solid #CCC; ">-->
                      <!--                                <span style="float: right; font-size: 11px; color:#006cb5;">کد ترانسفر</span>-->
                      <!--                                <span></span>-->
                      <!--                                <span style="float: left; margin-right: 20px; font-size: 17px;">--><?php //echo $resultOffCode['offCode']; ?><!-- </span>-->
                      <!--                            </td>-->
                      <!--                        --><?php //} ?>
                    </tr>
                  </table>

                </td>
              </tr>

            </table>
            </div>

              <?php
              if ($info['request_cancel'] != 'confirm' && ($info['successfull'] == 'book' || $info['successfull'] == 'private_reserve')){
                  ?>
                <div class="divborder" style="margin: 50px 100px <?php echo ($info['request_cancel'] !='confirm' && $cash=='no') ? '150px':'100px'?> 100px ;">
                  <div style="font-size: 19px ; color: #006cb5; margin-top: -20px" class="divborderPoint"> به نکات زیر توجه
                    نمایید:
                  </div>
                  <table width="100%" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td></td>
                    </tr>

                    <tr>
                      <td style="padding-bottom: 20px">
                        <ul>
                          <li>حداکثر بار مجاز برابر با 20کیلو گرم می باشد</li>
                          <li>مسافر گرامی، با توجه به شیوع ویروس کرونا استفاده از ماسک در بدو ورود به فرودگاه الزامی میباشد. در غیر این صورت حراست فرودگاه از ورود شما جلوگیری خواهد نمود</li>
                          <li>در هنگام سوار شدن حتما مدرک شناسایی (کارت ملی) همراه خود داشته باشید</li>
                          <li>حتما 2 ساعت قبل از پرواز در فرودگاه حاضر باشید</li>
                          <li>در صورت کنسلی پرواز توسط ایرلاین، مسافر و یا تعجیل ؛ یا تاخیر بیش از 2 ساعت خواهشمند است
                            نسبت به مهر نمودن بلیط در فرودگاه و یا دریافت رسید اقدام نمایید
                          </li>
                          <li>ارائه کارت شناسایی عکس دار و معتبر جهت پذیرش بلیط و سوار شدن به هواپیما</li>
                          <li>ترمینال 1 : کیش‌ایر، وارش،زاگرس</li>
                          <li>ترمینال 2 : ایران ایر، ایر تور، آتا، قشم ایر، معراج، نفت(کارون)</li>
                          <li>ترمینال 4 : ماهان، کاسپین، آسمان، اترک، تابان، سپهران،فلای پرشیا،ساها،پویا</li>
                          <li>درصورتی که بلیط شما به هر دلیلی با مشکل مواجه شد لطفا با شماره تلفن های آژانس که در انتهای
                            بلیط نمایش داده شده تماس حاصل فرمائید
                          </li>

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
                      <td class="cancellationPolicy-title" colspan="6" style="font-size: 20px; font-weight: 700;">پرواز فوق در تاریخ <?php echo $date ?> با درصد <?php echo  $info['cancelTicketPercent'] ?> و مبلغ <?php echo number_format($info['cancelTicketPriceIndemnity']) ?>  ریال استرداد شده است.</td>
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
              } elseif (strtolower($info['flight_type']) == 'system' && $cash !='no') {

                  if($info['amount_added'] ==0)
                  {
                      $type='';
                      if($info['passenger_age']=='Adt'){
                          $type = 'adt';
                      }else if($info['passenger_age']=='Chd'){
                          $type = 'chd';
                      }else if($info['passenger_age']=='Inf'){
                          $type = 'inf';
                      }
                      ?>
                    <div class="divborder" style="margin: 20px 100px;">
                      <div style="font-size: 19px ; color: #006cb5; margin-top: -20px" class="divborderPoint">جزئیات قیمت:
                      </div>
                      <table width="100%" align="center" cellpadding="5" cellspacing="0" style="margin:10px;" border="1"
                             class="solidBorder">
                        <tr class="cancellationPolicy-tableHead">
                          <td class="cancellationPolicy-c1"> fare</td>
                          <td class="cancellationPolicy-c2">tax</td>
                          <td class="cancellationPolicy-c3">total</td>
                        </tr>
                        <tr>
                          <td class="cancellationPolicy-title"><?php echo $info[$type.'_fare'] ?></td>
                          <td class="cancellationPolicy-title"><?php echo $info[$type.'_tax'] ?></td>
                          <td class="cancellationPolicy-title"><?php echo $info[$type.'_price'] ?></td>
                      </table>
                    </div>
                    <br/>
                      <?php
                  }



                  if (!empty($Fee)) {
                      ?>'
                    <div class="divborder" style="margin: 10px 100px 100px 100px;">
                      <div style="font-size: 19px ; color: #006cb5; margin-top: -20px" class="divborderPoint"> جدول جرائم
                        کنسلی:
                      </div>
                      <table width="100%" align="center" cellpadding="5" cellspacing="0" style="margin:10px;" border="1"
                             class="solidBorder">
                        <tr class="cancellationPolicy-tableHead">
                          <td class="cancellationPolicy-c1">کلاس پروازی</td>
                          <td class="cancellationPolicy-c2">تا 12 ظهر 3 روز قبل از پرواز</td>
                          <td class="cancellationPolicy-c3">تا 12 ظهر 1 روز قبل از پرواز</td>
                          <td class="cancellationPolicy-c4">تا 3 ساعت قبل از پرواز</td>
                          <td class="cancellationPolicy-c5">تا 30 دقیقه قبل از پرواز</td>
                          <td class="cancellationPolicy-c6">از 30 دقیقه قبل پرواز به بعد</td>
                        </tr>
                        <tr>
                          <td class="cancellationPolicy-title"><?php echo $Fee['TypeClass'] ?></td>
                          <td class="cancellationPolicy-title"><?php echo $Fee['ThreeDaysBefore'] ?>%</td>
                          <td class="cancellationPolicy-title"><?php echo $Fee['OneDaysBefore'] ?>%</td>
                          <td class="cancellationPolicy-title"><?php echo $Fee['ThreeHoursBefore'] ?>%</td>
                          <td class="cancellationPolicy-title"><?php echo $Fee['ThirtyMinutesAgo'] ?>%</td>
                          <td class="cancellationPolicy-title"><?php echo $Fee['OfThirtyMinutesAgoToNext'] ?>%</td>
                        </tr>
                      </table>
                    </div>
                      <?php
                  } else { ?>
                    <div class="divborder" style="margin: auto 100px">
                      <div style="font-size: 19px ; color: #006cb5; margin-top: -20px" class="divborderPoint"> جدول جرائم
                        کنسلی:
                      </div>
                      <table width="100%" align="center" cellpadding="5" cellspacing="0" style="margin:10px;" border="1"
                             class="solidBorder">

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
                      </table>
                    </div>
                      <?php
                  }
              } else if(strtolower($info['flight_type'])  != 'system') {
                  ?>
                <div class="divborder" style="margin: 10px 100px 350px 100px;">
                  <div style="font-size: 19px ; color: #006cb5; margin-top: -20px" class="divborderPoint"> جدول جرائم کنسلی:
                  </div>
                  <table width="100%" align="center" cellpadding="5" cellspacing="0" style="margin: 10px;">

                    <tr>
                      <td class="cancellationPolicy-title" colspan="6">قوانين كنسلی پروازهای چارتری بر اساس تفاهم چارتر
                        كننده و سازمان هواپيمايی كشوری می باشد
                      </td>
                    </tr>
                  </table>
                </div>
                  <?php

              }

              ?>

              <div style="position:fixed;  bottom: 0 ; ">
                  <?php if($StampAgency != ROOT_ADDRESS_WITHOUT_LANG.'/pic/'){ ?>
              <div style='width: 90%' >
                <img src="<?php echo $StampAgency ?>" height="100" style="max-width: 230px; float: left; margin: 0 -50px 0 0">
              </div>
              <?php } ?>
            <hr style="margin: <?php echo ($StampAgency != ROOT_ADDRESS_WITHOUT_LANG.'/pic/') ? '10px' : '100px';?> 100px 5px 100px ; width: 90%"/>
            <table width="100%" align="center" style="width:100%; margin: 10px 100px <?php echo ($info['request_cancel'] !='confirm' && $cash=='no') ? '20px' : '10px'?> 50px ;    font-size: 17px" scellpadding="0"
                   cellspacing="0">

              <tr>
                <td>
                  وب سایت :
                    <?php echo $ClientMainDomain; ?>

                </td>
                <td> تلفن پشتیبانی :
                    <?php echo $phone; ?>
                </td>
                  <?php if($info_ticket[0]['agency_id']) {?>
                    <td> تلفن کانتر فروش :
                        <?php echo $PhoneManage; ?>
                    </td>
                  <?php  } ?>
              </tr>
              <tr>
                <td colspan="2">
                  آدرس :
                    <?php echo $ClientAddress; ?>

                </td>
              </tr>

            </table>

            </div>
          <?php  } ?>
          </body>
          </html>
            <?php
        } else {
            echo '<div style = "text-align:center ; fon-size:20px ;font-family: Yekan;" > اطلاعات مورد نظر موجود نمی باشد </div > ';
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
}

?>
