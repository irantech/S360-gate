<?php

require '../../config/bootstrap.php';
require CONFIG_DIR . 'configBase.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));

class carBookingStatus
{
    public $model;
    public $modelBase;
    public $arrayBookingStatus;
    public $infoBook;
    public $infoMember;
    public $infoClient;

    public function __construct()
    {
        $inputMethod = file_get_contents('php://input');

        $message = 'europcar bookings status : ' . $inputMethod . " \n";
        functions::insertLog($message, "log_europcarBookingStatus");

        $this->arrayBookingStatus = json_decode($inputMethod, true);
        if ($this->arrayBookingStatus['ServiceTypeId'] != '' && $this->arrayBookingStatus['TempReserveId'] != ''){

            $this->infoBook = functions::GetInfoEuropcarByTempReserveNumber($this->arrayBookingStatus['TempReserveId']);
            $this->infoMember = functions::infoMember($this->infoBook['member_id'], $this->infoBook['client_id']);
            $this->infoClient = functions::infoClient($this->infoBook['client_id']);

            Load::autoload('Model');
            $this->model = new Model();
            Load::autoload('ModelBase');
            $this->modelBase = new ModelBase();

            switch ($this->arrayBookingStatus['ServiceTypeId'])
            {
                case '1':
                    $this->bookedSuccessfully();
                    break;
                case '2':
                    $this->cancellation();
                    break;
                case '3':
                    $this->cancelFromEuropcar();
                    break;
                case '4':
                    $this->noShow();
                    break;
                default :
                    $this->sendMessage('Service type id is undefined');
                    break;
            }

        } else {
            $this->sendMessage('Empty sent information');
        }




    }

    #region درصورت تائید رزرو
    public function bookedSuccessfully()
    {

        $data['status'] = 'BookedSuccessfully';
        $data['main_reserve_number'] = $this->arrayBookingStatus['MainReserveNumber'];
        $data['message'] = $this->arrayBookingStatus['Message'];

        $result = $this->updateTable($data, $this->arrayBookingStatus['TempReserveId'], 'TemporaryReservation');
        if ($result){
            $this->sendSMS('TemporaryReservation');
            $this->sendMessage('Successfully completed.');
        } else {
            $this->sendMessage('There is a problem registering information. Please try again.');
        }

    }
    #endregion

    #region در صورت لغو رزرو
    public function cancellation()
    {

        $data['status'] = 'Cancellation';
        $data['main_reserve_number'] = $this->arrayBookingStatus['MainReserveNumber'];
        $data['message'] = $this->arrayBookingStatus['Message'];

        $result = $this->updateTable($data, $this->arrayBookingStatus['TempReserveId'], 'TemporaryReservation');
        if ($result){
            $this->sendSMS('Cancellation');
            $this->increaseCredit($this->arrayBookingStatus);
            $this->sendSMS('increaseCredit');
            $this->sendMessage('Successfully completed.');
        } else {
            $this->sendMessage('There is a problem registering information. Please try again.');
        }


    }
    #endregion


    #region لغو رزرو اجاره خودرو از طرف یوروپ کار
    public function cancelFromEuropcar()
    {

        $data['status'] = 'CancelFromEuropcar';
        $data['main_reserve_number'] = $this->arrayBookingStatus['MainReserveNumber'];
        $data['message'] = $this->arrayBookingStatus['Message'];
        $data['damage_percent'] = $this->arrayBookingStatus['DamagePercent'];
        $data['price'] = $this->arrayBookingStatus['Price'];

        $result = $this->updateTable($data, $this->arrayBookingStatus['TempReserveId'], 'BookedSuccessfully');
        if ($result){
            $this->sendSMS('CancelFromEuropcar');
            $this->increaseCredit($this->arrayBookingStatus);
            $this->sendSMS('increaseCredit');
            $this->sendMessage('Successfully completed.');
        } else {
            $this->sendMessage('There is a problem registering information. Please try again.');
        }


    }
    #endregion


    #region [noShow شدن رزرو اجاره خودرو از طرف یوروپ کار]
    public function noShow()
    {

        $data['status'] = 'NoShow';
        $data['main_reserve_number'] = $this->arrayBookingStatus['MainReserveNumber'];
        $data['message'] = $this->arrayBookingStatus['Message'];
        $data['damage_percent'] = $this->arrayBookingStatus['DamagePercent'];
        $data['price'] = $this->arrayBookingStatus['Price'];

        $result = $this->updateTable($data, $this->arrayBookingStatus['TempReserveId'], 'BookedSuccessfully');
        if ($result){
            $this->sendSMS('NoShow');
            $this->increaseCredit($this->arrayBookingStatus);
            $this->sendSMS('increaseCredit');
            $this->sendMessage('Successfully completed.');
        } else {
            $this->sendMessage('There is a problem registering information. Please try again.');
        }


    }
    #endregion


    #region updateTable
    public function updateTable($data, $tempReserveId, $status)
    {

        $condition = "temp_reserve_number='{$tempReserveId}' AND status='{$status}'";

        $this->model->setTable("book_europcar_local_tb");
        $resModel = $this->model->update($data, $condition);

        $this->modelBase->setTable("report_europcar_tb");
        $resModelBase = $this->modelBase->update($data, $condition);

        if ($resModel && $resModelBase){
            return true;
        } else {
            return false;
        }

    }
    #endregion


    #region sendSMS
    public function sendSMS($status)
    {
        $smsController = Load::controller('smsServices');

        switch ($status){
            case 'TemporaryReservation':
                /*$sms = " مسافر گرامی" . PHP_EOL . "{$this->infoBook['passenger_name']}" . " " . "{$this->infoBook['passenger_family']}";
                $sms .= PHP_EOL . " رزرو خودرو " . $this->infoBook['car_name'] . " به شماره فاکتور: " . $this->infoBook['factor_number'] . " شما تایید نهایی شد. " ;
                $sms .= PHP_EOL . " با تشکر روابط عمومی سایت(" . $this->infoClient['AgencyName'] . ")" ;
                $sms .= PHP_EOL . " شماره پشتیبانی: " . PHP_EOL . "021" . $this->infoClient['Phone'] ;*/

                $smsMessageTitle = 'bookedSuccessfullyEuropcar';

                $msg_sms = " رزرو اجاره خودرو داخلی به شماره فاکتور: {$this->infoBook['factor_number']} تایید نهایی شد. " . $this->infoClient['AgencyName'];

                $smsAgency = "";
                break;
            case 'Cancellation':
                /*$sms = " مسافر گرامی" . PHP_EOL . "{$this->infoBook['passenger_name']}" . " " . "{$this->infoBook['passenger_family']}";
                $sms .= PHP_EOL . " رزرو خودرو " . $this->infoBook['car_name'] . " به شماره فاکتور: " . $this->infoBook['factor_number'] . " شما لغو شد. " ;
                $sms .= PHP_EOL . $this->arrayBookingStatus['Message'] ;
                $sms .= PHP_EOL . " با تشکر روابط عمومی سایت(" . $this->infoClient['AgencyName'] . ")" ;
                $sms .= PHP_EOL . " شماره پشتیبانی: " . PHP_EOL . "021" . $this->infoClient['Phone'] ;*/

                $smsMessageTitle = 'cancellationEuropcar';

                $msg_sms = " رزرو اجاره خودرو داخلی به شماره فاکتور: {$this->infoBook['factor_number']} لغو شد. ";
                $msg_sms .= PHP_EOL . $this->arrayBookingStatus['Message'] ;
                $msg_sms .= $this->infoClient['AgencyName'];

                $smsAgency = "";
                break;
            case 'CancelFromEuropcar':
                /*$sms = " مسافر گرامی" . PHP_EOL . "{$this->infoBook['passenger_name']}" . " " . "{$this->infoBook['passenger_family']}";
                $sms .= PHP_EOL . " رزرو خودرو " . $this->infoBook['car_name'] . " به شماره فاکتور: " . $this->infoBook['factor_number'] . " شما لغو شد. " ;
                $sms .= PHP_EOL . " با تشکر روابط عمومی سایت(" . $this->infoClient['AgencyName'] . ")" ;
                $sms .= PHP_EOL . " شماره پشتیبانی: " . PHP_EOL . "021" . $this->infoClient['Phone'];*/

                $smsMessageTitle = 'cancellationEuropcar';

                $msg_sms = " رزرو اجاره خودرو داخلی به شماره فاکتور: {$this->infoBook['factor_number']} لغو شد. ";
                $msg_sms .= PHP_EOL . $this->arrayBookingStatus['Message'] ;
                $msg_sms .= PHP_EOL . "هزینه پرداختی به عنوان خسارت از طرف یوروپ کار " . $this->arrayBookingStatus['Price'] . " ریال می باشد." ;
                $msg_sms .= $this->infoClient['AgencyName'];

                $smsAgency = "";
                break;
            case 'NoShow':
                /*$sms = "";*/

                $msg_sms = " رزرو اجاره خودرو داخلی به شماره فاکتور: {$this->infoBook['factor_number']} noShow شد. ";
                $msg_sms .= PHP_EOL . $this->arrayBookingStatus['Message'] ;
                $msg_sms .= PHP_EOL . "هزینه پرداختی از طرف مشترک به عنوان جریمه به طرف یوروپ کار  " . $this->arrayBookingStatus['Price'] . " ریال می باشد." ;
                $msg_sms .= $this->infoClient['AgencyName'];

                $smsMessageTitle = 'noShowEuropcar';

                $smsAgency = "";
                break;
            case 'increaseCredit':
                $smsAgency = "مدیریت محترم آژانس " . $this->infoClient['AgencyName'] . " مبلغ " . $this->infoBook['total_price']
                    . " ریال بابت لغو رزرو خودرو به شماره فاکتور: "
                    . $this->infoBook['factor_number'] . " به اعتبار شما اضافه شد. " ;
                /*$sms = "";*/
                $smsMessageTitle = "";
                $msg_sms = "";
                break;
            default :
               /* $sms = "";*/
                $smsMessageTitle = "";
                $msg_sms = "";
                $smsAgency = "";
                break;
        }

        if ($smsMessageTitle != ''){
            //sms to buyer
            $objSms = $smsController->initService('0');
            if($objSms) {
                $mobile = $this->infoBook['passenger_mobile'];
                $name = $this->infoBook['passenger_name'] . ' ' . $this->infoBook['passenger_family'];
                $expGetDateTime = explode("T", $this->infoBook['get_car_date_time']);
                $expReturnDateTime = explode("T", $this->infoBook['return_car_date_time']);

                $messageVariables = array(
                    'sms_name' => $name,
                    'sms_service' => 'اجاره خودرو',
                    'sms_factor_number' => $this->infoBook['factor_number'],
                    'sms_cost' => $this->infoBook['total_price'],
                    'sms_europcar_car_name' => $this->infoBook['car_name'],
                    'sms_europcar_source_station_name' => $this->infoBook['source_station_name'],
                    'sms_europcar_dest_station_name' => $this->infoBook['dest_station_name'],
                    'sms_europcar_source_date' => $expGetDateTime[0],
                    'sms_europcar_source_time' => $expGetDateTime[1],
                    'sms_europcar_dest_date' => $expReturnDateTime[0],
                    'sms_europcar_dest_time' => $expReturnDateTime[1],
                    'sms_pdf' => ROOT_ADDRESS . "/pdf&target=BookingEuropcarLocal&id=" . $this->infoBook['factor_number'],
                    'sms_agency' => CLIENT_NAME,
                    'sms_agency_mobile' => CLIENT_MOBILE,
                    'sms_agency_phone' => CLIENT_PHONE,
                    'sms_agency_email' => CLIENT_EMAIL,
                    'sms_agency_address' => CLIENT_ADDRESS,
                );

                $smsArray = array(
                    'smsMessage' => $smsController->getUsableMessage($smsMessageTitle, $messageVariables),
                    'cellNumber' => $mobile,
                    'smsMessageTitle' => $smsMessageTitle,
                    'memberID' => (!empty($infoBook['member_id']) ? $infoBook['member_id'] : ''),
                    'receiverName' => $messageVariables['sms_name'],
                );
                $smsController->sendSMS($smsArray);
            }
        }

        if ($smsAgency != ''){
            //sms to site manager
            $objSms = $smsController->initService('1');
            if($objSms) {
                $smsArray = array(
                    'smsMessage' => $smsAgency,
                    'cellNumber' => $this->infoClient['Mobile']
                );
                $smsController->sendSMS($smsArray);
            }

        }

        if ($msg_sms != ''){
            //sms to our supports
            $objSms = $smsController->initService('1');
            if($objSms) {
                $cellArray = array(
                    'afshar' => '09123493154',
                   
                );
                foreach ($cellArray as $cellNumber){
                    $smsArray = array(
                        'smsMessage' => $msg_sms,
                        'cellNumber' => $cellNumber
                    );
                    $smsController->sendSMS($smsArray);
                }
            }
        }





        //$this->emailEuropcarSelf($this->infoBook['factor_number']);

    }
    #endregion


    #region increaseCredit
    public function increaseCredit()
    {
        $bookingController = Load::controller('BookingEuropcarLocal');
        $bookingController->delete_transaction_current($this->infoBook['factor_number']); //افزایش اعتبار سیستم

        if ($this->infoBook['payment_type'] == 'credit'){

            $controller = Load::controller('members');
            $controller->increaseAgencyCreditForEuropcar($this->infoBook['factor_number'], $this->infoMember['fk_agency_id']); //افزایش اعتبار کانتر
        }

    }
    #endregion


    #region sendMessage
    public function sendMessage($message)
    {
        $result['Message'] = $message;
        if ($this->arrayBookingStatus['TempReserveId'] != ''){
            $result['TempReserveId'] = $this->arrayBookingStatus['TempReserveId'];
        }
        functions::insertLog(json_encode($result), "log_europcarBookingStatus");
        echo json_encode($result);

    }
    #endregion


}

new carBookingStatus();