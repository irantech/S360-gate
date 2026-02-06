<?php
/**
 * Created by PhpStorm.
 * User: AbbasPC
 * Date: 8/29/2019
 * Time: 5:21 PM
 */

class issueTicket
{

    public function __construct()
    {

    }


    public function issueServerPishroInternal($dataTicket,$payType)
    {
        $model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $objTransaction = Load::controller('transaction');
        $smsController = Load::controller('smsServices');


        $ReserveTicket = parent::Reserve($dataTicket['request_number'], $dataTicket['api_id']);
        error_log('try show result private method ticketed in : ' . date('Y/m/d H:i:s') . ' buy ' . ($payType == 'credit' ? 'credit' : 'cash') . '  With RequestNumber : =>' . $eachDirection['request_number'] . ' AND array Equal  => : ' . json_encode($ReserveTicket, true) . " \n", 3, LOGS_DIR . 'log_method_ticketed.txt');

        $sourceName = ($eachDirection['api_id'] == '11') ? '10' : '5';
        if ($payType != 'credit') {
            // Caution: آپدیت تراکنش به موفق
            $objTransaction->setCreditToSuccess($eachDirection['factor_number'], $eachDirection['tracking_code_bank']);
        }

        $query = "SELECT * FROM book_local_tb WHERE request_number = '{$eachDirection['request_number']}'";
        $ticketsCurrent = $model->select($query);
        foreach ($ticketsCurrent as $i => $Tickets) {

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

            $data['pnr'] = '';
            $data['eticket_number'] = '';

            if ($ticketsCurrent[$i]['passenger_national_code'] != '0000000000') {
                $uniqCondition = " AND passenger_national_code = '{$ticketsCurrent[$i]['passenger_national_code']}' ";
            } else {
                $uniqCondition = " AND passportNumber = '{$ticketsCurrent[$i]['passportNumber']}' ";
            }

            $condition = " request_number='{$eachDirection['request_number']}' " . $uniqCondition;
            $res = $model->update($data, $condition);

            if ($res) {
                if ($eachDirection['api_id'] == '1') {
                    $data['successfull'] = 'private_reserve';
                } else if ($eachDirection['api_id'] == '11') {
                    $data['successfull'] = 'book';
                }

                $data['private_m4'] = '0';
                $ModelBase->setTable('report_tb');
                $conditionBase = " request_number = '{$eachDirection['request_number']}' " . $uniqCondition;
                $ModelBase->update($data, $conditionBase);
            }
            $this->ok_flight[$eachDirection['direction']] = true;
            $this->payment_date = $data['payment_date'];

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
            $date = dateTimeSetting::jdate("Y-F-d", functions::ConvertToDateJalaliInt($eachDirection['date_flight']));
            $sms = "سرور{$sourceName} -" . CLIENT_NAME . "-{$eachDirection['airline_name']}-{$date}";
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