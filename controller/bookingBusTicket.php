<?php

/**
 * Class bookingBusTicket
 * @property bookingBusTicket $bookingBusTicket
 */

class bookingBusTicket extends clientAuth
{
    public $error=false;
    public $errorMessage='';
    public $factorNumber;
    public $statusBook=false;
    public $paymentDate;

    public $transactions;

    public function __construct() {
        $this->transactions = $this->getModel('transactionsModel');
    }


    #region setBook
    public function setBook($paymentType=null, $factorNumber=null)
    {


        //echo Load::plog($_POST);
        //echo Load::plog($_GET);

        $Model=Load::library('Model');
        $ModelBase=Load::library('ModelBase');
        $objApiBus=Load::library('apiBus');
        $objTransaction=Load::controller('transaction');
        $smsController=Load::controller('smsServices');
        // پرداخت از درگاه//
        if(isset($factorNumber) && $factorNumber==''){
            $this->factorNumber=trim($factorNumber);
        }
        functions::insertLog('before check busReserve '.$factorNumber, 'reserveBusTicket');
//
        $sql=" SELECT * FROM book_bus_tb WHERE passenger_factor_num = '{$factorNumber}' AND ( status = 'bank' OR status = 'prereserve' )";
        $resultBook=$Model->load($sql);

        if (!empty($resultBook)) {

            $sourceCode = $resultBook['SourceCode'];

            functions::insertLog('before busReserve ' . $factorNumber . ' => : ' . json_encode($resultBook), 'reserveBusTicket');
            //echo 'busReserve ::: <br>' . Load::plog($resultBusReserve);


            // اگر خرید ما از وب سرویس به صورت اعتباری است؛ چک کند بلیط اتوبوس قطعی شده یا نه //
            if ($resultBook['AvailablePaymentMethods'] == 'Credit') {
                //echo 'inquireBusTicket ::: <br>' . Load::plog($resultInquireBusTicket);

                if ($sourceCode == 'reservation_bus') {
                    $objTransaction->setCreditToSuccess($factorNumber, $resultBook['tracking_code_bank']);

                    $dataUpdateBook['status'] = 'book';
                    $this->statusBook = true;
                    $dataUpdateBook['pnr'] = '';
                    $dataUpdateBook['ClientTraceNumber'] = '';
                } else {
                    $resultBusReserve = $objApiBus->busReserve($factorNumber);
                    $dataUpdateBook['order_code'] = $orderCode = $resultBusReserve['response']['requestNumber'];

                    functions::insertLog('inquireBusTicket ' . $factorNumber . ' => : ' . json_encode($resultBusReserve, true), 'reserveBusTicket');

                    if ($this->checkApiSuccessfulStatus($resultBusReserve, $factorNumber)) {

                        // Caution: آپدیت تراکنش به موفق
                        $objTransaction->setCreditToSuccess($factorNumber, $resultBook['tracking_code_bank']);

                        $dataUpdateBook['status'] = 'book';
                        $this->statusBook = true;
                        $dataUpdateBook['pnr'] = $resultBusReserve['response']['data']['pnr'];
                        $dataUpdateBook['ClientTraceNumber'] = $resultBusReserve['response']['data']['ticketNumber'];

                    } else {

                        //supportsNotification


                        $dataUpdateBook['status'] = 'error';
                        $this->statusBook = false;
                        $this->error = true;
                        $this->errorMessage = 'اشکالی در فرآیند رزرو پیش آمده است، لطفا برای پیگیری رزرو و یا برگرداندن اعتبار خود با پشتیبانی تماس حاصل نمائید';
                    }
                }

            } // اگر خرید ما از وب سرویس به صورت نقدی است؛ موقتا خرید را قطعی کرده و در پنل ادمین برای نهایی شدن رزرو، پرداخت انجام میگیرد //
            else {
                $dataUpdateBook['status'] = 'temporaryReservation';

            }


            $dataUpdateBook['payment_date'] = Date('Y-m-d H:i:s');
            $dataUpdateBook['creation_date_int'] = time();
            if ($paymentType == 'cash') {
                if ($resultBook['tracking_code_bank'] == 'member_credit') {
                    $dataUpdateBook['payment_type'] = 'member_credit';
                    $dataUpdateBook['tracking_code_bank'] = '';
                } else {
                    $dataUpdateBook['payment_type'] = 'cash';
                }
            }
            else if ($paymentType == 'credit') {

                $dataUpdateBook['payment_type'] = 'credit';

                if (!$this->statusBook) {
                    $transactionCondition = " FactorNumber='{$factorNumber}' ";
                    $transactionData['PaymentStatus'] = 'pending';
                    $Model->setTable('transaction_tb');
                    $transactionRes = $Model->update($transactionData, $transactionCondition);

                    //for admin panel , transaction table

                    $this->transactions->updateTransaction($transactionData, $transactionCondition);

                    $creditCondition = " requestNumber='{$factorNumber}' ";
                    $creditData['PaymentStatus'] = 'pending';
                    $Model->setTable('credit_detail_tb');
                    $creditRes = $Model->update($creditData, $creditCondition);
                }

            }

            $condition = " passenger_factor_num='{$factorNumber}' ";
            $Model->setTable('book_bus_tb');
            $res = $Model->update($dataUpdateBook, $condition);

            if ($res) {

                $ModelBase->setTable('report_bus_tb');
                $ModelBase->update($dataUpdateBook, $condition);

                $this->paymentDate = $dataUpdateBook['payment_date'];


                if ($this->statusBook) {

                    if(functions::checkClientConfigurationAccess('call_back')) {
                        $sql=" SELECT * FROM book_bus_tb WHERE passenger_factor_num = '{$factorNumber}' AND ( status = 'temporaryReservation' OR status = 'book' )";
                        $info = $Model->select($sql);
                        $call_back_api =$this->getController('callBackUrl');
                        $call_back_api->sendBookedData($info , 'bus') ;

                    }

                    // sms


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
                    if ($resultBook['AvailablePaymentMethods'] == 'Credit') {
                        if ($resultBook['SourceCode'] == 'reservation_bus') {
//                            $sms = " رزرو جدید بلیط اتوبوس رزرواسیون به شماره فاکتور: {$factorNumber} - " . CLIENT_NAME;
                            $sms = "رزرو جدید اتوبوس" ;
                        } else {
//                            $sms = " رزرو جدید بلیط اتوبوس اشتراکی به شماره فاکتور: {$factorNumber} - " . CLIENT_NAME;
                            $sms = "رزرو جدید اتوبوس" ;
                        }
                    } else {
                        $sms = "رزور اتوبوس" . PHP_EOL;
                        $sms .= " شماره فاکتور: {$factorNumber} - " . CLIENT_NAME . PHP_EOL;
                    }

                    $this->supportsNotification($sms);


//                    ----------------------------------------------------------------


                    $objSms = $smsController->initService('0');
                    if ($objSms) {
                        $mobile = $resultBook['passenger_mobile'];
                        $name = $resultBook['passenger_name'] . ' ' . $resultBook['passenger_family'];
                        $messageVariables = array(
                            'sms_name' => $name,
                            'sms_service' => 'اتوبوس',
                            'sms_factor_number' => $factorNumber,
                            'sms_ticket_number' => @$resultBusReserve['response']['data']['ticketNumber'],
                            'sms_bus_origin_name' => $resultBook['OriginName'],
                            'sms_bus_dest_name' => $resultBook['DestinationCity'],
                            'sms_bus_company_name' => $resultBook['CompanyName'],
                            'sms_bus_origin_terminal' => $resultBook['OriginTerminal'],
                            'sms_bus_date_move' => $resultBook['DateMove'],
                            'sms_bus_time_move' => $resultBook['TimeMove'],
                            'sms_bus_chairs_number' => $resultBook['passenger_chairs'],
                            'sms_pdf' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=bookingBusApi&id=" . $factorNumber,
                            'sms_agency' => CLIENT_NAME,
                            'sms_agency_mobile' => CLIENT_MOBILE,
                            'sms_agency_phone' => CLIENT_PHONE,
                            'sms_agency_email' => CLIENT_EMAIL,
                            'sms_agency_address' => CLIENT_ADDRESS,
                            'sms_site_url' => CLIENT_MAIN_DOMAIN
                        );
                        $smsArray = array(
                            'smsMessage' => $smsController->getUsableMessage('bookedSuccessfullyBus', $messageVariables),
                            'cellNumber' => $mobile,
                            'smsMessageTitle' => 'bookedSuccessfullyBus',
                            'memberID' => (!empty($resultBook['member_id']) ? $resultBook['member_id'] : ''),
                            'receiverName' => $messageVariables['sms_name'],
                        );

                        $smsController->sendSMS($smsArray);
                    }

                    //email to buyer
                    $this->emailHotelSelf($factorNumber);


                }


            }
        }
        else{


            $sms = "رزور اتوبوس خطای" . PHP_EOL;
            $this->supportsNotification($sms);


            $this->error=true;
            $this->errorMessage='اشکالی در فرآیند رزرو پیش آمده است، لطفا برای پیگیری رزرو و یا برگرداندن اعتبار خود با پشتیبانی تماس حاصل نمائید';
        }


    }
    #endregion

    #region callFailed
    public function callFailed($payment_type, $factorNumber, $reason = '')
    {
        $smsController = Load::controller('smsServices');
        $objSms = $smsController->initService('1');


        if (!$reason)
            $reason = 'ارتباط';

        if ($objSms) {

            $sms = 'خطا در رزرو اتوبوس' . PHP_EOL;

            $cellArray = array(
                'bahrami' => '09155909722',
                'abasi2' => '09057078341',

            );
            foreach ($cellArray as $cellNumber) {
                $smsArray = array(
                    'smsMessage' => $sms,
                    'cellNumber' => $cellNumber
                );
                $smsController->sendSMS($smsArray);
            }


//            $sms = 'خطا در رزرو اتوبوس رخ داده است' . PHP_EOL;
//
//
//            $smsArray = array(
//                'smsMessage' => $sms,
//                'cellNumber' => '09211559872'
//            );
//            $smsController->sendSMS($smsArray);

        }

    }
    #endregion

    #region setBookForPaymentFromPayaneha
    public function setBookForPaymentFromPayaneha()
    {
        //echo Load::plog($_GET);

        $Model=Load::library('Model');
        $ModelBase=Load::library('ModelBase');
        $objTransaction=Load::controller('transaction');

        // پرداخت از لینک درگاه پایانه//
        if(isset($_GET['PayanehaOrderCode'])){

            $orderCode=$_GET['PayanehaOrderCode'];
            $pnr=$_GET['TicketCode'];

            $sql=" SELECT * FROM book_bus_tb WHERE order_code = '{$orderCode}' AND status = 'temporaryReservation' ";
            $resultBook=$Model->load($sql);
            $this->factorNumber=$factorNumber=$resultBook['passenger_factor_num'];
            if(!empty($resultBook)){

                // Caution: آپدیت تراکنش به موفق
                $objTransaction->setCreditToSuccess($factorNumber, $resultBook['tracking_code_bank']);

                $dataUpdateBook['status']='book';
                $dataUpdateBook['pnr']=$pnr;
                $condition=" passenger_factor_num = '{$factorNumber}' ";
                $Model->setTable('book_bus_tb');
                $res[]=$Model->update($dataUpdateBook, $condition);

                $ModelBase->setTable('report_bus_tb');
                $res[]=$ModelBase->update($dataUpdateBook, $condition);

                if(!in_array('0', $res)){

                    $this->statusBook=true;
                    $this->paymentDate=$resultBook['payment_date'];

                }

            }else{
                $this->error=true;
                $this->errorMessage='اشکالی در فرآیند رزرو پیش آمده است، لطفا برای پیگیری رزرو و یا برگرداندن اعتبار خود با پشتیبانی تماس حاصل نمائید';
            }

        }else{
            $this->error=true;
            $this->errorMessage='اشکالی در فرآیند رزرو پیش آمده است، لطفا برای پیگیری رزرو و یا برگرداندن اعتبار خود با پشتیبانی تماس حاصل نمائید';
        }

    }
    #endregion

    #region updateBank
    public function updateBank($trackingCode, $factorNumber)
    {
        $Model=Load::library('Model');
        $ModelBase=Load::library('ModelBase');

        $sql=" SELECT status FROM book_bus_tb WHERE passenger_factor_num = '{$factorNumber}' ";
        $hotel=$Model->load($sql);
        if($hotel['status']=='bank'){

            $data=array(
                'tracking_code_bank'=>"".$trackingCode."",
                'payment_date'=>Date('Y-m-d H:i:s')
            );
            $condition=" passenger_factor_num = '".$factorNumber."' AND status = 'bank' ";
            $Model->setTable('book_bus_tb');
            $Model->update($data, $condition);
            $ModelBase->setTable('report_bus_tb');
            $ModelBase->update($data, $condition);
        }
    }
    #endregion

    #region delete_transaction_current
    public function delete_transaction_current($factorNumber)
    {
        if(!$this->checkBookStatus($factorNumber)){
            $Model=Load::library('Model');
            $data['PaymentStatus']='pending';
            $condition="FactorNumber = '{$factorNumber}' AND FactorNumber !=''";
            $Model->setTable('transaction_tb');
            $Model->update($data, $condition);

            //for admin panel , transaction table
            $this->transactions->updateTransaction($data, $condition);
        }
    }
    #endregion

    #region checkBookStatus
    public function checkBookStatus($factorNumber)
    {
        $Model=Load::library('Model');
        $query="SELECT status FROM book_bus_tb WHERE passenger_factor_num = '{$factorNumber}'";
        $result=$Model->load($query);
        return $result['status']=='book' ? true : false;
    }
    #endregion

    #region setPortBank
    public function setPortBank($bankDir, $factorNumber)
    {
        $initialValues=array(
            'bank_dir'=>$bankDir,
            'serviceTitle'=>$_POST['serviceType']
        );
        $bankModel=Load::model('bankList');
        $bankInfo=$bankModel->getByBankDir($initialValues);

        $data['name_bank_port']=$bankDir;
        $data['number_bank_port']=$bankInfo['param1'];

        $Model=Load::library('Model');
        $Model->setTable('book_bus_tb');

        $condition=" passenger_factor_num = '{$factorNumber}' ";
        $res=$Model->update($data, $condition);
        if($res){
            $ModelBase=Load::library('ModelBase');
            $ModelBase->setTable('report_bus_tb');
            $ModelBase->update($data, $condition);
        }
    }
    #endregion

    #region sendUserToBank
    public function sendUserToBank($factorNumber)
    {
        $data=array(
            'status'=>"bank"
        );

        $condition=" passenger_factor_num = '{$factorNumber}' ";
        $Model=Load::library('Model');

        $Model->setTable('book_bus_tb');
        $Model->update($data, $condition);

        Load::autoload('ModelBase');
        $ModelBase=new ModelBase();

        $ModelBase->setTable('report_bus_tb');
        $ModelBase->update($data, $condition);
    }
    #endregion

    #region emailHotelSelf
    public function emailHotelSelf($factorNumber)
    {
        $infoBook=functions::GetInfoBus($factorNumber);
        if(!empty($infoBook)){

            $emailBody='با سلام'.'<br>';
            $emailBody.='دوست عزیز؛ از اینکه خدمات ما را انتخاب نموده اید سپاسگزاریم'.'<br>';
            $emailBody.='لطفا جهت مشاهده و چاپ بلیط روی دکمه چاپ بلیط اتوبوس مربوطه که در قسمت پایین قرار دارد کلیک نمایید'.'<br>';

            $param['title']='رزرو بلیط اتوبوس از '.$infoBook['OriginCity'].'به مقصد '.$infoBook['DestinationCity'];
            $param['body']=$emailBody;
            $param['pdf'][0]['url']=ROOT_ADDRESS_WITHOUT_LANG.'/pdf&target=bookingBusShow&id='.$factorNumber;
            $param['pdf'][0]['button_title']='چاپ بلیط اتوبوس';

            $to=$infoBook['passenger_email'];
            $subject="خرید بلیط اتوبوس";
            $message=functions::emailTemplate($param);
            $headers="From: noreply@".CLIENT_MAIN_DOMAIN."\r\n";
//            $headers.="Bcc: ghorbani2006@gmail.com\r\n";
//            $headers.="Bcc: developer@iran-tech.com\r\n";
            $headers.="MIME-Version: 1.0\r\n";
            $headers.="Content-type: text/html; charset=UTF-8";
            ini_set('SMTP', 'smtphost');
            ini_set('smtp_port', 25);

            mail($to, $subject, $message, $headers);
        }
    }
    #endrigion

    /**
     * @param $resultBuses
     * @param $factorNumber
     * @return bool
     */
    public function checkApiSuccessfulStatus($resultBuses,$factorNumber='')
    {

        if(!empty($resultBuses) && ($resultBuses['response']['SuccessfulStatus']['client'] && $resultBuses['response']['SuccessfulStatus']['provider']) ){
            if((!empty($resultBuses['response']['data']['pnr']) && $resultBuses['response']['data']['pnr'] !== '') || (!empty($resultBuses['response']['data']['ticketNumber']) && $resultBuses['response']['data']['ticketNumber'] !== '')){
                return true;
            }else{
                $this->callFailed('',$factorNumber,'ارسال خطا توسط پروایدر');
            }
        }
        return false;
    }


    #region getReportBusAgency
    public function getReportBusAgency($agencyId)
    {
        /** @var bookBusModel $bookBusModel */
        $bookBusModel = Load::getModel('bookBusModel');
        return $bookBusModel->getReportBusAgency($agencyId);
    }
    #endregion
    public function getReportBusByFactorNumber($factor_number)
    {
        $cancel_ticket = $this->getModel('cancelTicketModel');
        $cancel_ticket_table = $cancel_ticket->getTable();
        $cancel_ticket_details = $this->getModel('cancelTicketDetailsModel');
        $cancel_ticket_details_table = $cancel_ticket_details->getTable();
        $book_bus = $this->getModel('bookBusModel');
        $book_bus_table = $book_bus->getTable();
        $getters = [
            $book_bus_table . '.id',
            $book_bus_table . '.passenger_name',
            $book_bus_table . '.passenger_family',
            $book_bus_table . '.passenger_factor_num',
            $book_bus_table . '.passenger_national_code',
            $book_bus_table . '.passportNumber',
            $book_bus_table . '.passenger_birthday',
            $book_bus_table . '.member_id',
            $book_bus_table . '.order_code',
            $book_bus_table . '.total_price',
            $book_bus_table . '.order_code AS RequestNumber',
            'cancelDetail.*',
            'cancelTicket.NationalCode as NationalCode'
        ];

        return $book_bus->get($getters,true)
            ->joinSimple(
                [$cancel_ticket_table, 'cancelTicket'],
                $book_bus_table . '.passenger_national_code',
                'cancelTicket.NationalCode',
                'LEFT')
            ->joinSimple(
                [$cancel_ticket_details_table, 'cancelDetail'],
                'cancelDetail.id',
                'cancelTicket.IdDetail AND cancelDetail.RequestNumber='.$book_bus_table.'.order_code',
                'LEFT')
            ->where($book_bus_table . '.passenger_factor_num', $factor_number)
            ->groupBy($book_bus_table . '.id')
            ->all();
    }

    /**
     * @param $smsController
     * @param $sourceCode1
     * @param $factorNumber
     * @return array
     */
    private function supportsNotification($sms) {
        //sms to our supports
        $smsController = Load::controller('smsServices');
        $objSms = $smsController->initService('1');
        if ($objSms) {



            $cellArray = array(
                'afraze' => '09155909722',
                'abasi2' => '09057078341'
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


}