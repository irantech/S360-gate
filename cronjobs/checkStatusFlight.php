<?php


class checkStatusFlight extends clientAuth
{

    private $address_api;
    public $transactions;

    public function __construct() {
        parent::__construct();

        $this->transactions = $this->getModel('transactionsModel');
        $this->address_api = 'http://safar360.com/Core/V-1/Flight/getFinallyResponse/';
        $this->updateStatusFlight();


    }


    public function updateStatusFlight() {

        $date = dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode = explode('-', $date);
        $date_now_int_start = dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date_now_int_end = dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);

        $list_pending_flights = $this->getModel('reportModel')->get()->where('creation_date_int',$date_now_int_start,'>=')->where('creation_date_int',$date_now_int_end,'<=')->openParentheses()->where('successfull', 'pending')->orwhere('successfull', 'processing')->
        closeParentheses()->groupBy('request_number')->all();


        foreach ($list_pending_flights as $flight) {

            if (strpos($flight['request_number'], 'TE') !== false) {
                $this->checkTestConfirm($flight['request_number']);
                $this->address_api = 'http://safar360.com/CoreTestDeveloper/V-1/Flight/getFinallyResponse/';
            }
            if ($flight['api_id'] != '10') {
                if ($flight['direction'] == 'return') {
                    $check_dept_reserve = $this->getModel('reportModel')->get()->where('direction', 'dept')->where('factor_number', $flight['factor_number'])->find();
                    if ($check_dept_reserve['successfull'] != 'book' && $check_dept_reserve['successfull'] != 'private_reserve') {
                        if ($check_dept_reserve['successfull'] == 'error') {
                            $data['successfull'] = 'error';
                            $condition = " request_number = '{$flight['request_number']}' ";
                            $this->getController('admin')->ConectDbClient('', $flight['client_id'], "Update", $data, "book_local_tb", $condition);
                            $this->getModel('reportModel')->update($data, $condition);

                            $this->setErrorIntoDb($flight);

                        }
                        return false;
                    }
                }
                $info_status_flight = functions::curlExecution($this->address_api . $flight['request_number'], array(), 'json');
                functions::insertLog('data fetch core with req ==>' . $flight['request_number'] . '==>' . json_encode($info_status_flight, 256), 'checkStatusFlightCore');

                if ($info_status_flight['status'] == 'Ticketed') {
                    foreach ($info_status_flight['info_passengers'] as $info_passenger) {

                        $data['successfull'] = 'book';
                        $data['pnr'] = $info_status_flight['pnr'];
                        $data['eticket_number'] = $info_passenger['TicketNumber'];

                        $uniqCondition = (($info_passenger['PassportNumber'] == '') ? (" AND passenger_national_code = '{$info_passenger['NationalCode']}' ") : (" AND passportNumber = '{$info_passenger['PassportNumber']}'"));
                        $condition = " request_number = '{$info_status_flight['request_number']}' " . $uniqCondition;
                        $this->getController('admin')->ConectDbClient('', $flight['client_id'], "Update", $data, "book_local_tb", $condition);
                        $data['successfull'] = ($flight['pid_private'] == '1') ? 'private_reserve' : 'book';
                        $data['private_m4'] = ($flight['pid_private'] == '1') ? '3' : '0';
                        $this->getModel('reportModel')->update($data, $condition);
                    }
                    $this->updateTransactionStatusSuccess($flight['factor_number'], $flight['client_id']);

                    if ($flight['payment_type'] == 'credit') {
                        $this->updateCreditAgencyCurrent($info_status_flight['request_number'], $flight['client_id']);
                    }

                    // for send data to accounting after success
                    $this->getController('apiAccounting')->sendDataFlight($flight);
                    $this->sendSmsToClient($flight);
                    $this->emailTicketSelf($info_status_flight['request_number']);
                }
                elseif ($info_status_flight['status'] == 'error') {
                    $data['successfull'] = 'error';
                    $condition = " request_number = '{$flight['request_number']}' ";
                    $this->getModel('bookLocalModel')->update($data, $condition);
                    $this->getModel('reportModel')->update($data, $condition);
                }
            }


        }

    }


    /**
     * @param $request_number
     */
    private function emailTicketSelf($request_number) {


        $data = $this->getModel('reportModel')->get()->where('request_number', $request_number)->find();
        if (!empty($data)) {

            if ($data['type_app'] == 'reservationBus') {
                $title = "چاپ رزرو";
                $subjectEmail = "رزرو تور";
            } else {
                $title = "چاپ بلیط";
                $subjectEmail = "خرید بلیط هواپیما";
            }

            $emailBody = 'با سلام' . '<br>';
            $emailBody .= 'دوست عزیز؛ از اینکه خدمات ما را انتخاب نموده اید سپاسگزاریم' . '<br>';
            $emailBody .= 'لطفا جهت مشاهده و ' . $title . ' بر روی دکمه ' . $title . ' که در قسمت پایین قرار دارد کلیک نمایید ' . '<br>';

            if ($data['type_app'] == 'reservationBus') {
                $param['title'] = ' تور ' . $data['flight_number'] . ' - ' . $data['desti_city'];
            } else {
                $param['title'] = 'بلیط هواپیما از  ' . $data['origin_city'] . ' به ' . $data['desti_city'];
            }
            $param['body'] = $emailBody;
            if ($data['type_app'] == 'reservation' || $data['type_app'] == 'reservationBus') {
                $param['pdf'][0]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=BookingReservationTicket&id=' . $data['request_number'];
            } else {
                if ($data['IsInternal'] == '1') {
                    $param['pdf'][0]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=parvazBookingLocal&id=' . $data['request_number'];
                } else {
                    $param['pdf'][0]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=ticketForeign&id=' . $data['request_number'];
                }

            }
            $param['pdf'][0]['button_title'] = $title;

            $to = $data['email_buyer'];
            $subject = $subjectEmail;
            $message = functions::emailTemplate($param);
            $headers = "From: noreply@" . CLIENT_MAIN_DOMAIN . "\r\n";
//	        $headers .="Bcc: ghorbani2006@gmail.com\r\n";
//	        $headers .="Bcc: developer@iran-tech.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8";
            ini_set('SMTP', 'smtphost');
            ini_set('smtp_port', 25);

            mail($to, $subject, $message, $headers);
        }
    }

    private function sendSmsToClient($eachDirection) {

        $client = $this->getModel('clientsModel')->get()->where('id', $eachDirection['client_id'])->find();

//sms to buyer
        $sms_service = $this->getcontroller('smsServices');
        $objSms = $sms_service->initService('0', $eachDirection['client_id']);
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
                'sms_agency' => $client['AgencyName'],
                'sms_agency_mobile' => CLIENT_MOBILE,
                'sms_agency_phone' => CLIENT_PHONE,
                'sms_agency_email' => CLIENT_EMAIL,
                'sms_agency_address' => CLIENT_ADDRESS
            );
            $smsArray = array(
                'smsMessage' => $sms_service->getUsableMessage('afterTicketReserve', $messageVariables),
                'cellNumber' => $eachDirection['member_mobile'],
                'smsMessageTitle' => 'afterTicketReserve',
                'memberID' => (!empty($eachDirection['member_id']) ? $eachDirection['member_id'] : ''),
                'receiverName' => $messageVariables['sms_name'],
            );

            $sms_service->sendSMS($smsArray);

            //to manager
            $smsArray = array(
                'smsMessage' => $sms_service->getUsableMessage('afterReserveToManager', $messageVariables),
                'cellNumber' => CLIENT_MOBILE,
                'smsMessageTitle' => 'afterReserveToManager',
                'memberID' => (!empty($eachDirection['member_id']) ? $eachDirection['member_id'] : ''),
                'receiverName' => 'مدیر سایت',
            );
            $sms_service->sendSMS($smsArray);

            //to first passenger
            $messageVariables['sms_name'] = $eachDirection['passenger_name'] . ' ' . $eachDirection['passenger_family'];
            $smsArray = array(
                'smsMessage' => $sms_service->getUsableMessage('afterTicketReserve', $messageVariables),
                'cellNumber' => $eachDirection['mobile_buyer'],
                'smsMessageTitle' => 'afterTicketReserve',
                'memberID' => (!empty($eachDirection['member_id']) ? $eachDirection['member_id'] : ''),
                'receiverName' => $messageVariables['sms_name'],
            );
            $sms_service->sendSMS($smsArray);
        }
    }

    public function setErrorIntoDb($params) {

        $data['message_admin'] = 'Non-issuance due to non-issuance of departure flight';
        $data['message_passenger'] = 'عدم صدور به خاطر صادر نشدن پرواز رفت';
        $data['client_id'] = $params['client_id'];
        $data['request_number'] = $params['request_number'];
        $data['action'] = 'cronjobs';
        $data['creation_date_int'] = time();

        $this->getModel('logErrorFlightsModel')->insertWithBind($data);
    }

    public function updateCreditAgencyCurrent($request_number, $client_id) {
        $condition = "requestNumber = '{$request_number}' AND requestNumber !='' AND type='decrease'";
        $data['PaymentStatus'] = 'success';

        $this->getController('admin')->ConectDbClient('', $client_id, "Update", $data, "credit_detail_tb", $condition);
    }

    public function updateTransactionStatusSuccess($factor_number, $client_id) {
        $condition = "FactorNumber = '{$factor_number}' AND PaymentStatus ='pending'";
        $data['PaymentStatus'] = 'success';
        $this->getController('admin')->ConectDbClient('', $client_id, "Update", $data, "transaction_tb", $condition);
        $data['clientID'] = $client_id;

        $condition = " FactorNumber = '{$factor_number}' AND PaymentStatus ='pending' ";

        $this->transactions->updateTransaction($data,$condition);


//        $sms_service = $this->getcontroller('smsServices');
//        $cellArray = array(
//            'araste' => '09211559872',
//            'fanipor' => '09129409530'
//        );
//        $objSms = $sms_service->initService('1');
//        if ($objSms) {
//            $sms_service->smsByPattern('i3dn9y90p0xwwsj', $cellArray, array('factor_number' => $factor_number));
//
//        }
    }

    public function checkTestConfirm($request_number) {
        $sms_service = $this->getcontroller('smsServices');
        $objSms = $sms_service->initService('1');
        if ($objSms) {
            $sms = "پرواز تست با شماره رکوئست==> {$request_number}";
            $smsArray = array(
                'smsMessage' => $sms,
                'cellNumber' => '09211559872'
            );
        }
    }

}


new checkStatusFlight();