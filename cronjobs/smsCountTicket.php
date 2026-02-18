<?php


class smsCountTicket extends clientAuth
{

    public function __construct() {
        parent::__construct();

        return $this->getCountTicket();
    }

    public function getCountTicket() {
        $Year = dateTimeSetting::jdate("Y", time(), '', '', 'en');
        $Mounth = dateTimeSetting::jdate("m", time(), '', '', 'en');
        $Day = dateTimeSetting::jdate("d", time(), '', '', 'en');
        $Today = dateTimeSetting::jdate("Y-m-d", time(), '', '', 'en');

        $TimeStart = dateTimeSetting::jmktime('0', '0', '0', $Mounth, $Day, $Year);//
        $TimeEnd = dateTimeSetting::jmktime('23', '59', '59', $Mounth, $Day, $Year);


        $CountTicketQuery = "SELECT COUNT(request_number) AS CountTicket,
                      (SELECT COUNT(request_number) FROM report_tb WHERE flight_type='charter' AND (successfull='book' OR successfull='private_reserve') AND (creation_date_int>='{$TimeStart}' AND creation_date_int<='{$TimeEnd}'))AS CountTicketCharter,
                      (SELECT COUNT(request_number) FROM report_tb WHERE flight_type='system' AND pid_private='0' AND (successfull='book' OR successfull='private_reserve') AND (creation_date_int>='{$TimeStart}' AND creation_date_int<='{$TimeEnd}'))AS CountTicketPublicSystem,
                      (SELECT COUNT(request_number) FROM report_tb WHERE flight_type='system' AND pid_private='1' AND (successfull='book' OR successfull='private_reserve') AND (creation_date_int>='{$TimeStart}' AND creation_date_int<='{$TimeEnd}'))AS CountTicketPrivateSystem
 FROM report_tb WHERE (successfull='book' OR successfull='private_reserve') AND (creation_date_int>='{$TimeStart}' AND creation_date_int<='{$TimeEnd}')";


        $ResultCountTicket = $this->getModel('reportModel')->load($CountTicketQuery);

        $smsController = $this->getController('smsServices');

        $objSms = $smsController->initService('1');
        if ($objSms) {
            echo $sms = "جناب آقای افشار" . PHP_EOL . "تعداد کل خرید های امروز در تاریخ: " . $Today . " به شرح زیراست، تعداد کل: " . $ResultCountTicket['CountTicket'] . " عدد" . PHP_EOL . "چارتری: " . $ResultCountTicket['CountTicketCharter'] . " عدد" . PHP_EOL . "سیستمی اشتراکی: " . $ResultCountTicket['CountTicketPublicSystem'] . " عدد" . PHP_EOL . "سیستمی اختصاصی: " . $ResultCountTicket['CountTicketPrivateSystem'] . " عدد";
            $smsArray = array(
                'smsMessage' => $sms,
                'cellNumber' => '09123493154'
            );
            $smsController->sendSMS($smsArray);


        }

//sms to Mr Fanipoor
        $objSms_f = $smsController->initService('1');
        if ($objSms_f) {
             $sms_f = "جناب آقای فنی پور" . PHP_EOL . "تعداد کل خرید های امروز در تاریخ: " . $Today . " به شرح زیراست، تعداد کل: " . $ResultCountTicket['CountTicket'] . " عدد" . PHP_EOL . "چارتری: " . $ResultCountTicket['CountTicketCharter'] . " عدد" . PHP_EOL . "سیستمی اشتراکی: " . $ResultCountTicket['CountTicketPublicSystem'] . " عدد" . PHP_EOL . "سیستمی اختصاصی: " . $ResultCountTicket['CountTicketPrivateSystem'] . " عدد";
            $smsArrayF = array(
                'smsMessage' => $sms_f,
                'cellNumber' => '09129409530'
            );
            $smsController->sendSMS($smsArrayF);
        }

        error_log('send sms : ' . date('Y/m/d H:i:s') . '  array equal in => : 09123493154' . " \n" . $sms . " \n", 3, LOGS_DIR . 'log_smsCronJob.txt');

        $clients = $this->getModel('clientsModel')->get(['Mobile', 'AgencyName', 'id'], true)->where('id', '1', '<>')->where('id', '4', '<>')->all();


        if (!empty($clients)) {
            foreach ($clients as $client) {
                $count_ticket_query = "SELECT COUNT(request_number) AS CountTicket,
                      (SELECT COUNT(request_number) FROM book_local_tb WHERE flight_type='charter' AND (successfull='book') AND (creation_date_int>='{$TimeStart}' AND creation_date_int<='{$TimeEnd}'))AS CountTicketCharter,
                      (SELECT COUNT(request_number) FROM book_local_tb WHERE flight_type='system' AND pid_private='0' AND (successfull='book') AND (creation_date_int>='{$TimeStart}' AND creation_date_int<='{$TimeEnd}'))AS CountTicketPublicSystem,
                      (SELECT COUNT(request_number) FROM book_local_tb WHERE flight_type='system' AND pid_private='1' AND (successfull='book') AND (creation_date_int>='{$TimeStart}' AND creation_date_int<='{$TimeEnd}'))AS CountTicketPrivateSystem
                      FROM book_local_tb WHERE (successfull='book') AND (creation_date_int>='{$TimeStart}' AND creation_date_int<='{$TimeEnd}')";

                $result_count_ticket_client = $this->getController('admin')->ConectDbClient($count_ticket_query, $client['id'], "Select", "", "", "");


                if (!empty($result_count_ticket_client) && $result_count_ticket_client['CountTicket'] > 0) {


                    //sms to site manager
                    $objSms = $smsController->initService('1');
                    if ($objSms) {
                         $sms = "مدیریت محترم آژانس" . "(" . $client['AgencyName'] . ")" . PHP_EOL . "تعداد کل خرید های امروز در تاریخ: " . $Today . " به شرح زیراست، تعداد کل: " . $result_count_ticket_client['CountTicket'] . " عدد" . PHP_EOL . "چارتری: " . $result_count_ticket_client['CountTicketCharter'] . " عدد" . PHP_EOL . "سیستمی اشتراکی: " . $result_count_ticket_client['CountTicketPublicSystem'] . " عدد" . PHP_EOL . "سیستمی اختصاصی: " . $result_count_ticket_client['CountTicketPrivateSystem'] . " عدد";
                        $smsArray = array(
                            'smsMessage' => $sms,
                            'cellNumber' => $client['Mobile']
                        );

                        $smsController->sendSMS($smsArray);
                    }

                    error_log('send sms : ' . date('Y/m/d H:i:s') . '  array equal in => : ' . $client['Mobile'] . " \n" . $sms . " \n", 3, LOGS_DIR . 'log_smsCronJob.txt');
                }
            }

        }
    }
}

new smsCountTicket();