<?php

class BookingEuropcarLocal extends clientAuth
{
    public $payment_date = '';
    public $okBook = '';
    public $type_application = '';
    public $error = '';
    public $errorMessage = '';
    public $factorNumber = '';
    public $europcarInfo = '';

    public $transactions;

    public function __construct()
    {
        $this->transactions = $this->getModel('transactionsModel');
    }

    public function setPortBankForCar($bankDir, $factorNumber)
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
        $Model->setTable('book_europcar_local_tb');

        $condition = " factor_number='{$factorNumber}'";
        $res = $Model->update($data, $condition);
        if ($res) {
            $ModelBase = Load::library('ModelBase');
            $ModelBase->setTable('report_europcar_tb');
            $ModelBase->update($data, $condition);
        }
    }

    public function sendUserToBankForCar($factorNumber)
    {
        $data = array(
            'status' => "bank"
        );

        $condition = " factor_number ='{$factorNumber}' ";
        Load::autoload('Model');
        $Model = new Model();

        $Model->setTable('book_europcar_local_tb');
        $Model->update($data, $condition);

        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $ModelBase->setTable('report_europcar_tb');
        $ModelBase->update($data, $condition);
    }

    public function updateBank($codRahgiri, $categoryNum)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $data = array(
            'tracking_code_bank' => "" . $codRahgiri . "",
            'payment_date' => Date('Y-m-d H:i:s')
        );

        $condition = " factor_number='" . $categoryNum . "' AND status = 'bank' ";
        $Model->setTable('book_europcar_local_tb');
        $Model->update($data, $condition);

        $ModelBase->setTable('report_europcar_tb');
        $ModelBase->update($data, $condition);


        $d['PaymentStatus'] = 'success';
        $d['BankTrackingCode'] = $codRahgiri;
        $condition = " FactorNumber='" . $categoryNum . "' ";
        $Model->setTable('transaction_tb');
        $Model->update($d, $condition);

         //for admin panel , transaction table
        $this->transactions->updateTransaction($d,$condition);
    }

    public function carBook($factorNumber, $paymentType)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $objTransaction = Load::controller('transaction');
        $smsController = Load::controller('smsServices');

        $factorNumber = trim($factorNumber);
        $this->factorNumber = $factorNumber;

        $infoBook = functions::GetInfoEuropcar($factorNumber);
        $this->europcarInfo = $infoBook;

        $apiEuropcarLocal = Load::library('apiEuropcarLocal');
        $apiEuropcarLocal->curl_init();
        $result = $apiEuropcarLocal->getNewReserveCar($factorNumber);

        if (trim($result['NewReserveCarResult']['Message']) == 'ثبت رزرو با موفقیت انجام شد'){

            if ($infoBook['price'] == $result['NewReserveCarResult']['ReserveTotalPrice']){

                $data['temp_reserve_number'] = $result['NewReserveCarResult']['TempReserveNumber'];
                $data['status'] = 'TemporaryReservation';
                $data['payment_date'] = date('Y-m-d H:i:s');
                if($paymentType == 'cash' && $infoBook['tracking_code_bank'] == 'member_credit'){
                    $data['payment_type'] = 'member_credit';
                    $data['tracking_code_bank'] = '';

                    // Caution: آپدیت تراکنش به موفق
                    $objTransaction->setCreditToSuccess($factorNumber, $infoBook['tracking_code_bank']);

                } else{
                    $data['payment_type'] = $paymentType;
                }
                $data['creation_date_int'] = time();

                $condition = " factor_number='{$factorNumber}'";
                $Model->setTable('book_europcar_local_tb');
                $res = $Model->update($data, $condition);

                if ($res) {

                    $ModelBase->setTable('report_europcar_tb');
                    $ModelBase->update($data, $condition);
                    $this->okBook = true;
                    $this->payment_date = $data['payment_date'];


                    if (functions::CalculateChargeAdminAgency(CLIENT_ID) < 10000000) {
                        //sms to site manager
                        $objSms = $smsController->initService('1');
                        if($objSms) {
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
                    if($objSms) {
                        $sms = " رزرو موقت جدید اجاره خودرو به شماره فاکتور: {$factorNumber} - " . CLIENT_NAME;
                        $cellArray = array(
                            'afshar' => '09123493154',
                        );
                        foreach ($cellArray as $cellNumber){
                            $smsArray = array(
                                'smsMessage' => $sms,
                                'cellNumber' => $cellNumber
                            );
                            $smsController->sendSMS($smsArray);
                        }
                    }



                    //sms to buyer
                    $objSms = $smsController->initService('0');
                    if($objSms) {
                        $mobile = $infoBook['passenger_mobile'];
                        $name = $infoBook['passenger_name'] . ' ' . $infoBook['passenger_family'];
                        $expGetDateTime = explode("T", $infoBook['get_car_date_time']);
                        $expReturnDateTime = explode("T", $infoBook['return_car_date_time']);

                        $messageVariables = array(
                            'sms_name' => $name,
                            'sms_service' => 'اجاره خودرو',
                            'sms_factor_number' => $factorNumber,
                            'sms_cost' => $infoBook['total_price'],
                            'sms_europcar_car_name' => $infoBook['car_name'],
                            'sms_europcar_source_station_name' => $infoBook['source_station_name'],
                            'sms_europcar_dest_station_name' => $infoBook['dest_station_name'],
                            'sms_europcar_source_date' => $expGetDateTime[0],
                            'sms_europcar_source_time' => $expGetDateTime[1],
                            'sms_europcar_dest_date' => $expReturnDateTime[0],
                            'sms_europcar_dest_time' => $expReturnDateTime[1],
                            'sms_pdf' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=BookingEuropcarLocal&id=" . $factorNumber,
                            'sms_agency' => CLIENT_NAME,
                            'sms_agency_mobile' => CLIENT_MOBILE,
                            'sms_agency_phone' => CLIENT_PHONE,
                            'sms_agency_email' => CLIENT_EMAIL,
                            'sms_agency_address' => CLIENT_ADDRESS,
                        );
                        $smsArray = array(
                            'smsMessage' => $smsController->getUsableMessage('temporaryReservationEuropcare', $messageVariables),
                            'cellNumber' => $mobile,
                            'smsMessageTitle' => 'temporaryReservationEuropcare',
                            'memberID' => (!empty($infoBook['member_id']) ? $infoBook['member_id'] : ''),
                            'receiverName' => $messageVariables['sms_name'],
                        );

                        $smsController->sendSMS($smsArray);
                    }

                    // email
                    $this->emailEuropcarSelf($factorNumber);
                }

            } else {

                $this->delete_transaction_current($factorNumber);

                if ($paymentType == 'credit' && !$this->checkBookStatus($factorNumber)){
                    $infoMember = functions::infoMember($infoBook['member_id'], $infoBook['client_id']);
                    $controller = Load::controller('members');
                    $controller->increaseAgencyCreditForEuropcar($factorNumber, $infoMember['fk_agency_id']); //افزایش اعتبار کانتر
                }

                $this->okBook = false;
                $this->error = true;
                $this->errorMessage = 'مشکل در محاسبه قیمت از طرف یوروپ کار';
            }

        } else {

            $this->delete_transaction_current($factorNumber);

            if ($paymentType == 'credit' && !$this->checkBookStatus($factorNumber)){
                $infoMember = functions::infoMember($infoBook['member_id'], $infoBook['client_id']);
                $controller = Load::controller('members');
                $controller->increaseAgencyCreditForEuropcar($factorNumber, $infoMember['fk_agency_id']); //افزایش اعتبار کانتر
            }

            $this->okBook = false;
            $this->error = true;
            $this->errorMessage = $result['NewReserveCarResult']['Message'];
        }

    }

    public function delete_transaction_current($factorNumber)
    {
        if(!$this->checkBookStatus($factorNumber))
        {
            $Model = Load::library('Model');
            $data['PaymentStatus'] = 'pending';
            $condition = "FactorNumber = '{$factorNumber}' AND FactorNumber !=''";
            $Model->setTable('transaction_tb');
            $Model->update($data, $condition);

            //for admin panel , transaction table
            $this->transactions->updateTransaction($data,$condition);
        }
    }

    public function checkBookStatus($factorNumber)
    {
        $Model = Load::library('Model');

        $query = "SELECT status FROM book_europcar_local_tb WHERE factor_number = '{$factorNumber}'";
        $result = $Model->load($query);

        return $result['status'] == 'BookedSuccessfully' ? true : false;
    }

    public function emailEuropcarSelf($factorNumber)
    {
        $infoBook = functions::GetInfoEuropcar($factorNumber);

        if (!empty($infoBook) && !empty($infoBook['member_email'])) {

            /*$pdfUrl = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=BookingEuropcarLocal&id=' . $factorNumber;
            $emailContent = '
            <tr>
                <td valign="top" class="mcnTextContent" style="padding: 18px;color: #000000;font-size: 14px;font-weight: normal;text-align: center;">
                    <h3 class="m_-2679729263370124627null" style="text-align:center;display:block;margin:0;padding:0;color:#000000;font-family:tahoma,verdana,segoe,sans-serif;font-size:22px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal">
اجاره خودرو 
                        <span style="color:#FFFFFF"><strong>' . $infoBook['car_name'] . '</strong></span>
                    </h3>
                    <div style="margin-top: 20px;text-align:right;color:#FFFFFF; font-family:tahoma,verdana,segoe,sans-serif">
                    با سلام <br>
دوست عزیز؛ از اینکه خدمات ما را انتخاب نموده اید سپاسگزاریم <br>
                     لطفا جهت مشاهده و چاپ واچر اجاره خودرو بر روی دکمه چاپ واچر اجاره خودرو که در قسمت پایین قرار دارد کلیک نمایید 
                    </div>
                </td>
            </tr>
            ';

            $pdfButton = '
            <tr>
                <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 14px;">
                    <a class="mcnButton " title="چاپ واچر اجاره خودرو" href="' . $pdfUrl . '" target="_blank" style="background-color: #284861;padding: 15px;margin:5px 0;border-radius: 10px;font-weight: bold;letter-spacing: 0px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">چاپ واچر اجاره خودرو</a>
                </td>
            </tr>
            ';*/

            $emailBody = 'با سلام' . '<br>';
            $emailBody .= 'دوست عزیز؛ از اینکه خدمات ما را انتخاب نموده اید سپاسگزاریم' . '<br>';
            $emailBody .= 'لطفا جهت مشاهده و چاپ واچر اجاره خودرو بر روی دکمه چاپ واچر اجاره خودرو که در قسمت پایین قرار دارد کلیک نمایید' . '<br>';

            $param['title'] = 'اجاره خودرو ' . $infoBook['car_name'];
            $param['body'] = $emailBody;
            $param['pdf'][0]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=BookingEuropcarLocal&id=' . $factorNumber;
            $param['pdf'][0]['button_title'] = 'چاپ واچر اجاره خودرو';

            $to = $infoBook['member_email'];
            $subject = "اجاره خودرو";
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

    public function createPdfContent($factorNumber)
    {
        $objResultEuropcar = Load::controller('resultEuropcarLocal');

        $printBoxCheck = '';
        $printBoxCheck .= ' <!DOCTYPE html>
                <html>
                    <head>
                        <meta charset="UTF-8">
                        <title>مشاهده فایل pdf یوروپ کار</title>
                    </head>
                    <body>';

        $info = functions::GetInfoEuropcar($factorNumber);
        $objResultEuropcar->getDay($info['get_car_date_time'], $info['return_car_date_time']);
        if (!empty($info)) {
            $printBoxCheck .='<div style="margin:30px auto 0;background-color: #fff;line-height: 24px;">
        
                                <div style="margin:30px auto 0;background-color: #fff;">
                
                    <div style="margin: 10px auto 0;">
                        <div style="font-size: 14px;font-weight: bold;vertical-align: text-bottom;margin: 20px 0 0 0;width: 45%;display: inline-block;text-align: center;height: 67px;font: inherit;float: right;">';
            if ($info['status'] == 'BookedSuccessfully'){
                $printBoxCheck .='واچر اجاره خودرو';
            }else {
                $printBoxCheck .='واچر (موقت) اجاره خودرو';
            }
            $printBoxCheck .='</div>
                        <div style="margin: 20px 0 0 0;width: 45%;display: inline-block;text-align: center;height: 67px;float: left;">
                            <img src="' . FRONT_CURRENT_THEME . 'project_files/images/logo.png" style="max-height: 80px;">
                        </div>
                    </div>';
            /*$printBoxCheck .='
                    <div style="position: relative;font-size: 18px;margin: 8px auto;color: #171717;text-align: center;padding: 0 10px;background: #fff;width: 91%;">
                        <span style="background: #fff;position: relative;z-index: 1;padding: 0 15px;">واچر اجاره خودرو</span>
                    </div>
                    ';*/

            $printBoxCheck .='
                    <div style="border: 1px solid #2E3231;margin: 5px 40px 5px 40px;">

                    <div class="row" style="padding: 8px;font-weight: bold;background-color: #2E3231;margin: 0;color: #fff;">

                        <div style="width: 30%;position: relative;float: right;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                    <span style="font-weight: bold;">شماره واچر : </span><span>';
            $printBoxCheck .= $info['factor_number'];
            $payDate = functions::set_date_payment($info['payment_date']);
            $payDate = explode(' ', $payDate);
            $printBoxCheck .='</span>
                        </div>

                        <div style="width: 30%;position: relative;float: right;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">تاریخ خرید : </span><span>';
            $printBoxCheck .= $payDate[0];
            $printBoxCheck .='</span>
                        </div>

                        <div style="width: 30%;position: relative;float: right;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">ساعت خرید : </span><span>';
            $printBoxCheck .= $payDate[1];
            $printBoxCheck .='</span>
                        </div>

                    </div>';


            $printBoxCheck .='
                    <div class="row" style="padding: 8px;margin: 0;">
                        <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                            <span style="font-weight: bold;">نام خودرو : </span><span>';
            $printBoxCheck .= $info['car_name'];
            $printBoxCheck .='</span>
                        </div>

                        <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">مدل : </span><span>';
            $printBoxCheck .= $info['car_name_en'];
            $printBoxCheck .='</span>
                        </div>
                        
                        <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">قیمت پرداختی : </span><span>';
            $printBoxCheck .= number_format($info['total_price']);
            $printBoxCheck .='</span>
                        </div>
                        
                    </div>';

            $printBoxCheck .='
                    <div class="row" style="padding: 8px;margin: 0;">
                        <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                            <span style="font-weight: bold;">تحویل : </span><span>';
            $printBoxCheck .= $info['source_station_name'];
            $printBoxCheck .='</span>
                        </div>

                        <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">تاریخ تحویل : </span><span>';
            $printBoxCheck .= $objResultEuropcar->getCarDate;
            $printBoxCheck .='</span>
                        </div>
                        
                        <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">ساعت تحویل : </span><span>';
            $printBoxCheck .= $objResultEuropcar->getCarTime;
            $printBoxCheck .='</span>
                        </div>
                        
                    </div>';

            $printBoxCheck .='
                    <div class="row" style="padding: 8px;margin: 0;">
                        <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                            <span style="font-weight: bold;">بازگشت : </span><span>';
            $printBoxCheck .= $info['dest_station_name'];
            $printBoxCheck .='</span>
                        </div>

                        <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">تاریخ بازگشت : </span><span>';
            $printBoxCheck .= $objResultEuropcar->returnCarDate;
            $printBoxCheck .='</span>
                        </div>
                        
                        <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">ساعت بازگشت : </span><span>';
            $printBoxCheck .= $objResultEuropcar->returnCarTime;
            $printBoxCheck .='</span>
                        </div>
                        
                    </div>';


            $printBoxCheck .='
            <div class="row" style="padding: 8px;margin: 0;">
                <div style="width: 14%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                    <span style="font-weight: bold;">ظرفیت : </span><span style="direction: rtl;text-align: right;display: inline-block;">' . $info['car_passenger_count'] . '</span>
                    <span> نفر </span>
                </div>
                
                <div style="width: 16%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                    <span style="font-weight: bold;">حداکثر کیلومتر : </span><span style="direction: rtl;text-align: right;display: inline-block;">' . $info['car_allowed_km'] . '</span>
                    <span> Km </span>
                </div>
                
                <div style="width: 15%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                    <span style="font-weight: bold;">حداقل سن راننده : </span><span style="direction: rtl;text-align: right;display: inline-block;">' . $info['car_min_age_to_rent'] . '</span>
                </div>
                
                <div style="width: 21%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                    <span style="font-weight: bold;">قیمت هر کیلومتر اضافه : </span><span style="direction: rtl;text-align: right;display: inline-block;">' . number_format($info['car_add_km_cos_rial']) . '</span>
                    <span> ریال </span>
                </div>
                ';
                if ($info['car_insurance_cost_rial'] != 0){
                    $printBoxCheck .='
                    <div style="width: 15%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                        <span style="font-weight: bold;">قیمت بیمه : </span><span style="direction: rtl;text-align: right;display: inline-block;">' . number_format($info['car_insurance_cost_rial']) . '</span>
                    </div>
                    ';
                }
            $printBoxCheck .='
            </div>';






            $printBoxCheck .='
            <div class="row" style="padding: 8px;margin: 0;">
               
                <div style="width: 20%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                    <span style="font-weight: bold;">نوع ضمانت استرداد : </span><span style="direction: rtl;text-align: right;display: inline-block;">
                    ';
            if ($info['refund_type'] == '1'){
                $printBoxCheck .= 'چک';
            } else if ($info['refund_type'] == '2'){
                $printBoxCheck .= 'سفته';
            } else if ($info['refund_type'] == '3'){
                $printBoxCheck .= 'نقدی';
            }
            $printBoxCheck .='</span>
                </div>
               
                <div style="width: 20%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                    <span style="font-weight: bold;">نوع ضمانت جرایم رانندگی : </span><span style="direction: rtl;text-align: right;display: inline-block;">
                    ';
            if ($info['driving_crimes_type'] == '1'){
                $printBoxCheck .= 'چک';
            } else if ($info['driving_crimes_type'] == '2'){
                $printBoxCheck .= 'سفته';
            } else if ($info['driving_crimes_type'] == '3'){
                $printBoxCheck .= 'نقدی';
            }
            $printBoxCheck .='</span>
                </div>
               
                <div style="width: 20%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                    <span style="font-weight: bold;">تحویل خودرو در محل مشتری? </span><span style="direction: rtl;text-align: right;display: inline-block;">
                    ';
            if ($info['has_source_station_return_cost'] == '1'){
                $printBoxCheck .= 'دارد';
            } else if ($info['has_source_station_return_cost'] == '2'){
                $printBoxCheck .= 'ندارد';
            }
            $printBoxCheck .='</span>
                </div>
               
                <div style="width: 20%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                    <span style="font-weight: bold;">استرداد خودرو در محل مشتری? </span><span style="direction: rtl;text-align: right;display: inline-block;">
                    ';
            if ($info['has_dest_station_return_cost'] == '1'){
                $printBoxCheck .= 'دارد';
            } else if ($info['has_dest_station_return_cost'] == '2'){
                $printBoxCheck .= 'ندارد';
            }
            $printBoxCheck .='</span>
                </div>
                    
            </div>';




            $printBoxCheck .='
            </div>';


            $thingInfo = json_decode($info['reserve_car_thing_info'], true);
            if ($thingInfo != '') {

                $printBoxCheck .='
                    <div style="border: 1px solid #2E3231;margin: 5px 40px 5px 40px;">
                      <div class="row" style="padding: 8px;margin: 0;ont: inherit;vertical-align: baseline;">
                          <div class="col-md-12 modal-text-center modal-h"
                              style="text-align: center;font-size: 18px !important;width: 100%;font-weight: bold;">
                                        <span>لیست انتخابی لوازم جانبی خودرو</span>
                          </div>
                      </div> 
                      <div class="row" style="padding: 8px;margin: 0;">
                      ';

                foreach ($thingInfo as $thing){

                    $printBoxCheck .='
                   
                        <div style="width: 60%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                        <span style="font-weight: bold;">عنوان : </span><span>';
                    $printBoxCheck .= $thing['thingsName'];
                    $printBoxCheck .='</span>
                        </div>
                        ';

                    $printBoxCheck .='
                        <div style="width: 20%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                        <span style="font-weight: bold;">تعداد درخواستی : </span><span>';
                    $printBoxCheck .= $thing['countThings'];
                    $printBoxCheck .='</span>
                        </div>
                        ';

                }

                $printBoxCheck .='</div>';
                $printBoxCheck .='</div>';

            }


            $printBoxCheck .='
                    <div style="border: 1px solid #2E3231;margin: 5px 40px 5px 40px;">
                      <div class="row" style="padding: 8px;margin: 0;ont: inherit;vertical-align: baseline;">
                          <div class="col-md-12 modal-text-center modal-h"
                              style="text-align: center;font-size: 18px !important;width: 100%;font-weight: bold;">
                                        <span>مشخصات خریدار</span>
                          </div>
                      </div> ';

            $printBoxCheck .='
                   <div class="row" style="padding: 8px;margin: 0;">
                        <div style="width: 20%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">نام و نام خانوادگی : </span><span>';
            $printBoxCheck .= $info['passenger_name'].' '.$info['passenger_family'];
            $printBoxCheck .='</span>
                        </div>
                        ';
            $printBoxCheck .= '<div style="width: 18%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">';
                        if ($info['passenger_national_code']!=""){
                            $printBoxCheck .='<span style="font-weight: bold;">شماره ملی:</span><span>';
                            $printBoxCheck .= $info['passenger_national_code'];
                            $printBoxCheck .='</span>';
                        }else{
                            $printBoxCheck .='<span style="font-weight: bold;">شماره پاسپورت:</span><span>';
                            $printBoxCheck .= $info['passportNumber'];
                            $printBoxCheck .='</span>';
                        }
            $printBoxCheck .='</div>
                        <div style="width: 18%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">تاریخ تولد: </span><span>';

                            if ($info['passenger_birthday']!=""){
                                $printBoxCheck .= $info['passenger_birthday'];
                            }else{
                                $printBoxCheck .= $info['passenger_birthday_en'];
                            }

            $printBoxCheck .='</span>
                        </div>
                        
                        <div style="width: 24%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                        <span style="font-weight: bold;">ایمیل : </span><span>';
            $printBoxCheck .= $info['passenger_email'];
            $printBoxCheck .='</span>
                        </div>
                        
                    </div>';



            $printBoxCheck .='
                   <div class="row" style="padding: 8px;margin: 0;">
                        <div style="width: 14%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                        <span style="font-weight: bold;">تلفن : </span><span>';
            $printBoxCheck .= $info['passenger_telephone'];
            $printBoxCheck .='</span>
                        </div>
                        ';
            $printBoxCheck .= '<div style="width: 14%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                                <span style="font-weight: bold;">موبایل:</span><span>';
            $printBoxCheck .= $info['passenger_mobile'];
            $printBoxCheck .='</span>
                            </div>
                        <div style="width: 50%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                        <span style="font-weight: bold;">آدرس : </span><span>';
            $printBoxCheck .= $info['passenger_address'];
            $printBoxCheck .='</span>
                        </div>
                        
                    </div>';





            $printBoxCheck .='</div>';

            $printBoxCheck .='
                     </div>
                 <br/>
            
                    <h2 style="font-size: 14px;display: block;text-align: right;margin: 10px 40px 0px 40px;font-weight:bold">
                        <span> مسافر محترم رعایت موارد زیر در پذیرش یوروپ کار الزامی است:  </span>
                    </h2>
                    <div style="width: 93%;margin: 5px 40px 5px 40px;">
                        
                        <p style="padding-right: 8px;">حداقل مدت اجاره 24 ساعت یا یک روز کامل.</p>
                        <p style="padding-right: 8px;">قیمت بر اساس تعداد روز انتخابی بیشتر ، کاهش خواهد داشت.</p>
                        <p style="padding-right: 8px;">هزینه بنزین بر عهده مشتری می باشد.</p>
                        <p style="padding-right: 8px;">مسافت مجاز براساس روزانه 300 کیلومتر محاسبه می شود. مثال رزرو 5 روزه 1500 کیلومتر مسافت مجاز دارد و اضافه کیلومتر مطابق لیست قیمت مشمول هزینه مازاد می گردد.</p>
                        <p style="padding-right: 8px;">مشتری می تواند خودرو را در یک ایستگاه تحویل گرفته و در ایستگاه دیگر تحویل دهد که مشمول هزینه مسیر یکطرفه می گردد.</p>
                        <p style="padding-right: 8px;">تحویل و عودت خودرو در محل مشتری همراه با هزینه امکان پذیر می باشد.</p>
                        <p style="padding-right: 8px;">در بعضی ایستگاههای فرودگاههای شارژ فرودگاهی محاسبه می گردد.</p>
                        <p style="padding-right: 8px;">ودیعه جریمه پس از 75 روز از استرداد خودرو به مشتری مسترد می گردد.</p>
                        <p style="padding-right: 8px;">تمامی خودروهای شرکت دارای بیمه شخص ثالث و بیمه بدنه می باشند(Basic)، پوشش تکمیلی بیمه های Medium و Premium بصورت اختیاری قابل خریداری می باشد.</p>
                        <p style="padding-right: 8px;">رده سنی 18 تا 21 سال برای برخی گروه ها و بالای 21 سال برای تمامی گروه ها مجاز می باشد.</p>
                        <p style="padding-right: 8px;">تحویل و استرداد خارج از ساعات اداری ایستگاه شامل هزینه مازاد می باشد.</p>
                        <p style="padding-right: 8px;">در صورتی که آدرس اعلام شده از سوی مشتری جهت تحویل و عودت خودرو در محدوده طرح ترافیک و یا زوج و فرد باشد هزینه طرح خریداری شده معادل 400.000 ريال به مبلغ رزرو اضافه میگردد.</p>
                        <p style="padding-right: 8px;">خودرو تمیز و مرتب به مشتری تحویل داده می شود و مشتری نیز موظف می باشد خودرو را تمیزو مرتب مسترد نماید.</p>
                        <p style="padding-right: 8px;">ارائه مدارک مورد نیاز.</p>
                        <p style="padding-right: 8px;">پرداخت هزینه اجاره بصورت نقد.</p>
                
                    </div>
                    <div class="clear-both"></div>
                    <hr/>
            
                    <div style="width:100%; text-align : center ; ">
                        <div style="width: 45%; float:right ;margin: 0px 30px;text-align:right">
                            وب سایت : <div style="direction: ltr; display: inline-block;text-align:right">';
            $printBoxCheck .= CLIENT_MAIN_DOMAIN;
            $printBoxCheck .= '</div>
                    </div>
                    <div style="width: 45%; float:right ; margin: 0px 30px;text-align:right">
                        تلفن : <div style="direction: ltr; display: inline-block;text-align:right">';
            $printBoxCheck .= CLIENT_PHONE;
            $printBoxCheck .= '</div>
                    </div>
                    <div style="width: 80%; float:right; margin: 0px 20px ;text-align:right;direction: rtl"> آدرس : ';
            $printBoxCheck .= CLIENT_ADDRESS;
            $printBoxCheck .= '</div>
        
                    </div>
            
                    <div class="clear-both"></div>
            
                    </div>';


        } else {
            $printBoxCheck = '<div style="text-align:center ; fon-size:20px ;font-family: Yekan;">اطلاعات مورد نظر موجود نمی باشد</div>';
        }

        $printBoxCheck .= ' </div>
                                </body>
                </html> ';



        return $printBoxCheck;
    }



}