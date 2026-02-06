<?php


require 'config/bootstrap.php';
error_log('start send sms : ' . date('Y/m/d H:i:s') . '  => :********** '. " \n"  . " \n", 3, LOGS_DIR . 'log_smsCronJob.txt');
require CONFIG_DIR . 'configBase.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));


$ModelBase = Load::library('ModelBase');
$smsController = Load::controller('smsServices');

$Year =  dateTimeSetting::jdate("Y",time(),'','','en');
$Mounth = dateTimeSetting::jdate("m",time(),'','','en');
$Day = dateTimeSetting::jdate("d",time(),'','','en');
$Today = dateTimeSetting::jdate("Y-m-d",time(),'','','en');

$TimeStart = dateTimeSetting::jmktime('0','0','0',$Mounth,$Day,$Year);//
$TimeEnd = dateTimeSetting::jmktime('23','59','59',$Mounth,$Day,$Year);


$CountTicketQuery = "SELECT COUNT(request_number) AS CountTicket,
                      (SELECT COUNT(request_number) FROM report_tb WHERE flight_type='charter' AND (successfull='book' OR successfull='private_reserve') AND (creation_date_int>='{$TimeStart}' AND creation_date_int<='{$TimeEnd}'))AS CountTicketCharter,
                      (SELECT COUNT(request_number) FROM report_tb WHERE flight_type='system' AND pid_private='0' AND (successfull='book' OR successfull='private_reserve') AND (creation_date_int>='{$TimeStart}' AND creation_date_int<='{$TimeEnd}'))AS CountTicketPublicSystem,
                      (SELECT COUNT(request_number) FROM report_tb WHERE flight_type='system' AND pid_private='1' AND (successfull='book' OR successfull='private_reserve') AND (creation_date_int>='{$TimeStart}' AND creation_date_int<='{$TimeEnd}'))AS CountTicketPrivateSystem
 FROM report_tb WHERE (successfull='book' OR successfull='private_reserve') AND (creation_date_int>='{$TimeStart}' AND creation_date_int<='{$TimeEnd}')";


$ResultCountTicket = $ModelBase->load($CountTicketQuery);


//sms to Mr Afshar
$objSms = $smsController->initService('1');
if($objSms) {
  echo  $sms = "جناب آقای افشار".PHP_EOL."تعداد کل خرید های امروز در تاریخ: ". $Today." به شرح زیراست، تعداد کل: ".$ResultCountTicket['CountTicket']." عدد".PHP_EOL."چارتری: ".$ResultCountTicket['CountTicketCharter']." عدد".PHP_EOL."سیستمی اشتراکی: ".$ResultCountTicket['CountTicketPublicSystem']." عدد".PHP_EOL."سیستمی اختصاصی: ".$ResultCountTicket['CountTicketPrivateSystem']." عدد";
    $smsArray = array(
        'smsMessage' => $sms,
        'cellNumber' => '09353834714'//'09123493154'
    );
    $smsController->sendSMS($smsArray);

//    sleep(1);

}

//sms to Mr Afshar
$objSms_f = $smsController->initService('1');
if($objSms) {
    echo '<hr/>' ;
    echo  $sms_f = "جناب آقای فنی پور".PHP_EOL."تعداد کل خرید های امروز در تاریخ: ". $Today." به شرح زیراست، تعداد کل: ".$ResultCountTicket['CountTicket']." عدد".PHP_EOL."چارتری: ".$ResultCountTicket['CountTicketCharter']." عدد".PHP_EOL."سیستمی اشتراکی: ".$ResultCountTicket['CountTicketPublicSystem']." عدد".PHP_EOL."سیستمی اختصاصی: ".$ResultCountTicket['CountTicketPrivateSystem']." عدد";
    $smsArrayF = array(
        'smsMessage' => $sms_f,
        'cellNumber' =>'09353834714'//'09123409530'
    );
    $smsController->sendSMS($smsArrayF);

//    sleep(1);

}



error_log('send sms : ' . date('Y/m/d H:i:s') . '  array equal in => : 09123493154' . " \n" . $sms . " \n", 3, LOGS_DIR . 'log_smsCronJob.txt');
//$SqlClient ="SELECT Mobile,AgencyName,id FROM clients_tb WHERE (id<>'1' AND id<>'4')";
//$Clients  = $ModelBase->select($SqlClient);
//$admin = Load::controller('admin');
//
//if(!empty($Clients))
//{
//    foreach ($Clients as $client)
//    {
//         $CountTicketQuery = "SELECT COUNT(request_number) AS CountTicket,
//                      (SELECT COUNT(request_number) FROM book_local_tb WHERE flight_type='charter' AND (successfull='book') AND (creation_date_int>='{$TimeStart}' AND creation_date_int<='{$TimeEnd}'))AS CountTicketCharter,
//                      (SELECT COUNT(request_number) FROM book_local_tb WHERE flight_type='system' AND pid_private='0' AND (successfull='book') AND (creation_date_int>='{$TimeStart}' AND creation_date_int<='{$TimeEnd}'))AS CountTicketPublicSystem,
//                      (SELECT COUNT(request_number) FROM book_local_tb WHERE flight_type='system' AND pid_private='1' AND (successfull='book') AND (creation_date_int>='{$TimeStart}' AND creation_date_int<='{$TimeEnd}'))AS CountTicketPrivateSystem
//                      FROM book_local_tb WHERE (successfull='book') AND (creation_date_int>='{$TimeStart}' AND creation_date_int<='{$TimeEnd}')";
//
//        $ResultCountTicketClient = $admin->ConectDbClient($CountTicketQuery, $client['id'], "Select", "", "", "");
//
//        if($ResultCountTicketClient['CountTicket'] > 0) {
//
//            //sms to site manager
//            $objSms = $smsController->initService('1');
////            if ($objSms) {
////                $sms = "مدیریت محترم آژانس" . "(" . $client['AgencyName'] . ")" . PHP_EOL . "تعداد کل خرید های امروز در تاریخ: " . $Today . " به شرح زیراست، تعداد کل: " . $ResultCountTicketClient['CountTicket'] . " عدد" . PHP_EOL . "چارتری: " . $ResultCountTicketClient['CountTicketCharter'] . " عدد" . PHP_EOL . "سیستمی اشتراکی: " . $ResultCountTicketClient['CountTicketPublicSystem'] . " عدد" . PHP_EOL . "سیستمی اختصاصی: " . $ResultCountTicketClient['CountTicketPrivateSystem'] . " عدد";
////                $smsArray = array(
////                    'smsMessage' => $sms,
////                    'cellNumber' => $client['Mobile']
////                );
////                $smsController->sendSMS($smsArray);
////            }
//
//            error_log('send sms : ' . date('Y/m/d H:i:s') . '  array equal in => : ' . $client['Mobile'] . " \n" . $sms . " \n", 3, LOGS_DIR . 'log_smsCronJob.txt');
//        }
//    }
// }


