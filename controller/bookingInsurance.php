<?php


class bookingInsurance extends insurance
{
    public $okInsurance = '';
    public $payment_date = '';
    public $factorNumber = '';
    public $CountBook = 0;
    public $insuranceInfo;

    public $transactions;
    public function __construct()
    {
        $this->transactions = $this->getModel('transactionsModel');
    }

    public function updateBank($codRahgiri, $factorNum)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $data = array(
            'tracking_code_bank' => $codRahgiri ,
            'payment_date' => date('Y-m-d H:i:s')
        );

        $condition = " factor_number='" . $factorNum . "' AND status = 'bank' ";
        $Model->setTable('book_insurance_tb');
        $res = $Model->update($data, $condition);

        if($res){
            $ModelBase->setTable('report_insurance_tb');
            $ModelBase->update($data, $condition);
        }
    }

    public function insuranceBook($factorNumber, $payType = null)
    {


        $model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $objTransaction = Load::controller('transaction');
        $passengersDetail = Load::controller('passengersDetailInsurance');
        $smsController = Load::controller('smsServices');

        $factorNumber = trim($factorNumber);
        $this->factorNumber = $factorNumber;

        $book_info = $passengersDetail->getInsuranceInfoByFactorNumber($factorNumber);

        $this->insuranceInfo = $book_info[0];

        foreach($book_info as $item) {
            functions::insertLog('insurance book factor number' . json_encode($item) .PHP_EOL , 'insurance/repeated_pnr');

            //prevent book agian in refresh of page
            if($item['status'] != 'book') {

                $confirm_result = parent::confirmReservePlan($item);
                try {
                    if ($confirm_result['status']) {

                        if($payType != 'credit') {
                            // Caution: آپدیت تراکنش به موفق
                            $objTransaction->setCreditToSuccess($factorNumber, $item['tracking_code_bank']);
                        }

                        $data['pnr'] = $confirm_result['insuranceCode'];
                        $data['status'] = 'book';
                        $data['payment_date'] = date('Y-m-d H:i:s');
                        if($payType == 'credit'){
                            $data['payment_type'] = 'credit';
                        } elseif($item['tracking_code_bank'] == 'member_credit'){
                            $data['payment_type'] = 'member_credit';
                            $data['tracking_code_bank'] = '';
                        } else{
                            $data['payment_type'] = 'cash';
                        }

                        $condition = " factor_number='{$factorNumber}' AND passport_number='{$item['passport_number']}' ";
                        $model->setTable('book_insurance_tb');
                        $res = $model->update($data, $condition);

                        if ($res) {
                            $ModelBase->setTable('report_insurance_tb');
                            $ModelBase->update($data, $condition);
                            $this->okInsurance = true;
                            $this->payment_date = $data['payment_date'];

                            if(functions::checkClientConfigurationAccess('call_back')) {
                                $call_back_api =$this->getController('callBackUrl');
                                $call_back_api->sendBookedData($book_info , 'insurance') ;

                            }
                        }
                    }
                } catch (Exception $e) {

                    $d['message'] = $e->getMessage();
                    $d['creation_date_int'] = time();
                    $d['json_result'] = $confirm_result;
                    $d['request_number'] = $factorNumber;

                    $ModelBase->setTable('log_res_action_tb');
                    $ModelBase->insertLocal($d);
                }

            }

        }

        if($this->okInsurance == true)
        {
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

            //check insurance credit and send sms if needed
            parent::checkApiCredit($this->insuranceInfo['source_name']);

            //email to buyer
            $this->emailInsuranceSelf($factorNumber);

            //sms to buyer
            $objSms = $smsController->initService('0');
            if($objSms) {
                $messageVariables = array(
                    'sms_name' => $book_info[0]['member_name'],
                    'sms_service' => 'بیمه مسافرتی',
                    'sms_factor_number' => $book_info[0]['factor_number'],
                    'sms_destination' => $book_info[0]['destination'],
                    'sms_insure_type' => $book_info[0]['source_name_fa'],
                    'sms_insure_caption' => $book_info[0]['caption'],
                    'sms_insure_duration' => $book_info[0]['duration'],
                    'sms_agency' => CLIENT_NAME,
                    'sms_agency_mobile' => CLIENT_MOBILE,
                    'sms_agency_phone' => CLIENT_PHONE,
                    'sms_agency_email' => CLIENT_EMAIL,
                    'sms_agency_address' => CLIENT_ADDRESS,
                    'sms_site_url' => CLIENT_MAIN_DOMAIN
                );
                $smsArray = array(
                    'smsMessage' => $smsController->getUsableMessage('afterInsuranceReserve', $messageVariables),
                    'cellNumber' => $book_info[0]['mobile_buyer'],
                    'smsMessageTitle' => 'afterInsuranceReserve',
                    'memberID' => (!empty($book_info[0]['member_id']) ? $book_info[0]['member_id'] : ''),
                    'receiverName' => $messageVariables['sms_name'],
                );
                $smsController->sendSMS($smsArray);
            }

            $objSms = $smsController->initService('1');
            if($objSms) {
                $sms = "رزرو جدید بیمه"." ".CLIENT_NAME."بیمه"." ".$book_info[0]['source_name_fa'];
                $cellArray = array(
                    'afshar' => '09057078341',
                );
                foreach ($cellArray as $cellNumber){
                    $smsArray = array(
                        'smsMessage' => $sms,
                        'cellNumber' => $cellNumber
                    );
                    $smsController->sendSMS($smsArray);
                }
            }

        } elseif($this->okInsurance != true && $payType == 'credit'){

            $this->delete_transaction_current($factorNumber);

        }

    }

    public function samanInsuranceBook($bimehNo , $payType = null)
    {


        $model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $objTransaction = Load::controller('transaction');
        $passengersDetail = Load::controller('passengersDetailInsurance');
        $smsController = Load::controller('smsServices');

        if(isset($bimehNo)) {
            $bimehNo = trim($bimehNo);

        }

        $book_info = $passengersDetail->getInsuranceInfoByPnr($bimehNo);


        $factorNumber = $book_info[0]['factor_number'];
        $this->factorNumber = $factorNumber;
        functions::insertLog('insurance book factor number' . $factorNumber, 'insurance/saman_bank_log');
        functions::insertLog('insurance book info ' . json_encode($book_info), 'insurance/saman_bank_log');

        $this->insuranceInfo = $book_info[0];

        foreach($book_info as $item) {

            //prevent book agian in refresh of page
            if($item['status'] != 'book') {

//                $confirm_result = parent::confirmReservePlan($item);
                try {
//                    if ($confirm_result['status']) {
//
                        if($payType != 'credit') {
                            // Caution: آپدیت تراکنش به موفق
                            $objTransaction->setCreditToSuccess($factorNumber, $item['tracking_code_bank']);
                        }

                        $data['pnr'] = $bimehNo;
                        $data['status'] = 'book';
                        $data['payment_date'] = date('Y-m-d H:i:s');
                        if($item['tracking_code_bank'] == 'member_credit'){
                            $data['payment_type'] = 'member_credit';
                            $data['tracking_code_bank'] = '';
                        } else{
                            $data['payment_type'] = 'cash';
                        }
                        $condition = " factor_number='{$factorNumber}' AND passport_number='{$item['passport_number']}' ";

                        $model->setTable('book_insurance_tb');
                        $res = $model->update($data, $condition);
                        functions::insertLog('insurance set to book ' . $condition, 'insurance/saman_bank_log');
                        functions::insertLog('insurance book result ' . $res, 'insurance/saman_bank_log');
                        $this->okInsurance = true;
                        if ($res) {
                            $ModelBase->setTable('report_insurance_tb');
                            $ModelBase->update($data, $condition);
                            $this->okInsurance = true;
                            $this->payment_date = $data['payment_date'];
                        }
//                    }
                } catch (Exception $e) {
                    functions::insertLog('insurance set error in book ' , 'insurance/saman_bank_log');
                    $d['message'] = $e->getMessage();
                    $d['creation_date_int'] = time();
                    $d['json_result'] = [];
                    $d['request_number'] = $factorNumber;
                    $ModelBase->setTable('log_res_action_tb');
                    $ModelBase->insertLocal($d);
                }
            }
            else{
                functions::insertLog('insurance was status no need to set you did refresh ' , 'insurance/saman_bank_log');
            }
        }

        if($this->okInsurance == true)
        {
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
            //check insurance credit and send sms if needed
            parent::checkApiCredit($this->insuranceInfo['source_name']);
            //email to buyer
            $this->emailInsuranceSelf($factorNumber);
            //sms to buyer
            $objSms = $smsController->initService('0');
            if($objSms) {
                $messageVariables = array(
                    'sms_name' => $book_info[0]['member_name'],
                    'sms_service' => 'بیمه مسافرتی',
                    'sms_factor_number' => $book_info[0]['factor_number'],
                    'sms_destination' => $book_info[0]['destination'],
                    'sms_insure_type' => $book_info[0]['source_name_fa'],
                    'sms_insure_caption' => $book_info[0]['caption'],
                    'sms_insure_duration' => $book_info[0]['duration'],
                    'sms_agency' => CLIENT_NAME,
                    'sms_agency_mobile' => CLIENT_MOBILE,
                    'sms_agency_phone' => CLIENT_PHONE,
                    'sms_agency_email' => CLIENT_EMAIL,
                    'sms_agency_address' => CLIENT_ADDRESS,
                    'sms_site_url' => CLIENT_MAIN_DOMAIN
                );
                $smsArray = array(
                    'smsMessage' => $smsController->getUsableMessage('afterInsuranceReserve', $messageVariables),
                    'cellNumber' => $book_info[0]['mobile_buyer'],
                    'smsMessageTitle' => 'afterInsuranceReserve',
                    'memberID' => (!empty($book_info[0]['member_id']) ? $book_info[0]['member_id'] : ''),
                    'receiverName' => $messageVariables['sms_name'],
                );
                $smsController->sendSMS($smsArray);
            }
            $objSms = $smsController->initService('1');
            if($objSms) {
                $sms = "رزرو جدید بیمه"." ".CLIENT_NAME."بیمه"." ".$book_info[0]['source_name_fa'];
                $cellArray = array(
                    'afshar' => '09057078341',

                );
                foreach ($cellArray as $cellNumber){
                    $smsArray = array(
                        'smsMessage' => $sms,
                        'cellNumber' => $cellNumber
                    );
                    $smsController->sendSMS($smsArray);
                }
            }
        } elseif($this->okInsurance != true ){
            $this->delete_transaction_current($factorNumber);

        }

    }

    public function login_members_online($email)
    {
        $Model = Load::library('Model');
        $sql = "SELECT * FROM members_tb WHERE email='{$email}'";
        return $Model->load($sql);
    }

    public function registerPassengerOnline(){



        $login_user = Session::IsLogin();
        $members_model = Load::model('members');

        if ($login_user) {
            $IdMember = $_SESSION["userId"];
            return 'success:' . $IdMember;
        } else {
            $data['mobile'] = $_POST['mobile'];
            $data['telephone'] = $_POST['telephone'];
            $data['email'] = $_POST['Email'];
            $data['password'] = $members_model->encryptPassword($_POST['mobile']);
            $data['is_member'] = '0';
            $members = $this->login_members_online($data['email']);

            if (empty($members)) {
                Load::autoload('Model');
                $insert = new Model();
                $insert->setTable("members_tb");
                $insert->insertLocal($data);
                $IdMember = $insert->getLastId();
                return 'success:' . $IdMember;
            } else {
                if ($members['is_member'] == '0'):
                    $IdMember = $members['id'];
                    return  'success:' . $IdMember;
                else:
                    return 'error:کاربر با مشخصات وارد شده در سیستم وجود دارد لطفا لاگین کرده<br />  و یا از ایمیل دیگری برای خرید بدون ثبت نام استفاده نمائید';
                endif;
            }
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
            $this->transactions->updateTransaction($data, $condition);

        }
    }

    public function checkBookStatus($factorNumber)
    {
        $Model = Load::library('Model');

        $query = "SELECT status FROM book_insurance_tb WHERE factor_number = '{$factorNumber}'";
        $result = $Model->load($query);

        return $result['status'] == 'book' ? true : false;
    }

    public function emailInsuranceSelf($factor_number)
    {
        $Model = Load::library('Model');
        $sql = "SELECT * FROM book_insurance_tb WHERE factor_number='{$factor_number}'";
        $res_model = $Model->load($sql);

        if (!empty($res_model)) {

            $sql_pdf = "SELECT pnr, source_name, passenger_name, passenger_family FROM book_insurance_tb WHERE factor_number='{$factor_number}'";
            $res_pdf = $Model->select($sql_pdf);
            $count_reserve = count($res_pdf);

            /*$emailContent = '
            <tr>
                <td valign="top" class="mcnTextContent" style="padding: 18px;color: #000000;font-size: 14px;font-weight: normal;text-align: center;">
                    <h3 class="m_-2679729263370124627null" style="text-align:center;display:block;margin:0;padding:0;color:#000000;font-family:tahoma,verdana,segoe,sans-serif;font-size:22px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal">
 رزرو '.$count_reserve.' عدد بیمه 
                        <span style="color:#FFFFFF"><strong>' . $res_model['caption'] . '</strong></span>
به مقصد 
                        <span style="color:#FFFFFF"><strong>' . $res_model['destination'] . '</strong></span>
                    </h3>
                    <div style="margin-top: 20px;text-align:right;color:#FFFFFF; font-family:tahoma,verdana,segoe,sans-serif">
                    با سلام <br>
دوست عزیز؛ از اینکه خدمات ما را انتخاب نموده اید سپاسگزاریم <br>
                    لطفا جهت مشاهده و چاپ بیمه نامه ها روی دکمه چاپ بیمه نامه مربوطه که در قسمت پایین قرار دارد کلیک نمایید 
                    </div>
                </td>
            </tr>
            ';*/

            //$pdfButton = '';
            foreach ($res_pdf as $k=>$each){

                $param['pdf'][$k]['url'] = parent::getReservePdf($each['source_name'], $each['pnr']);
                $param['pdf'][$k]['button_title'] = 'چاپ بیمه نامه';

                /*$pdfButton .= '
                <tr>
                    <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 14px;">
                        <a class="mcnButton " title="چاپ بیمه نامه" href="' . parent::getReservePdf($each['source_name'], $each['pnr']) . '" target="_blank" style="background-color: #284861;padding: 15px;margin:5px 0;border-radius: 10px;font-weight: bold;letter-spacing: 0px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">چاپ بیمه نامه '.$each['passenger_name'].' '.$each['passenger_family'].'</a>
                    </td>
                </tr>
                ';*/
            }

            $emailBody = 'با سلام' . '<br>';
            $emailBody .= 'دوست عزیز؛ از اینکه خدمات ما را انتخاب نموده اید سپاسگزاریم' . '<br>';
            $emailBody .= 'لطفا جهت مشاهده و چاپ بیمه نامه ها روی دکمه چاپ بیمه نامه مربوطه که در قسمت پایین قرار دارد کلیک نمایید' . '<br>';

            $param['title'] = 'رزرو ' . $count_reserve . ' عدد بیمه ' . $res_model['caption'] . ' به مقصد ' . $res_model['destination'] ;
            $param['body'] = $emailBody;


            $to = $res_model['email_buyer'];
            $subject = "خرید بیمه مسافرتی";
            $message = functions::emailTemplate($param);
            $headers = "From: noreply@" . CLIENT_DOMAIN . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8";
            ini_set('SMTP', 'smtphost');
            ini_set('smtp_port', 25);

            mail($to, $subject, $message, $headers);
        }
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

    public function setPortBankInsurance($bankDir, $factor_number)
    {
        if($bankDir != 'samanBankInsurance') {
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
        $Model->setTable('book_insurance_tb');

        $condition = " factor_number='{$factor_number}'";
        $res = $Model->update($data, $condition);
        if ($res) {
            $ModelBase = Load::library('ModelBase');
            $ModelBase->setTable('report_insurance_tb');
            $ModelBase->update($data, $condition);
        }
    }

    public function sendUserToBankForInsurance($FactorNumber)
    {
        $data = array(
            'status' => "bank",
            'payment_type' => "cash"
        );

        $condition = " factor_number = '{$FactorNumber}' ";
        Load::autoload('Model');
        $Model = new Model();

        $Model->setTable('book_insurance_tb');
        $Model->update($data, $condition);

        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $ModelBase->setTable('report_insurance_tb');
        $ModelBase->update($data, $condition);
    }

    public function list_hamkar()
    {
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $sql = " SELECT * FROM clients_tb ORDER BY id DESC";
        $clinet = $ModelBase->select($sql);

        return $clinet;
    }





    public function createExcelFile($param)
    {

        $_POST = $param;
        $resultBook = $this->bookList('yes');

        if (!empty($resultBook)) {

            // برای نام گذاری سطر اول فایل اکسل //
            $firstRowColumnsHeading = ['ردیف', 'تاریخ خرید', 'نام خریدار', 'شماره موبایل خریدار', 'شماره بیمه', 'مقصد', 'نوع بیمه', 'شماره فاکتور'
                , 'عنوان بیمه', 'تعداد بیمه', 'سهم آژانس', 'مبلغ', 'نام مسافر', 'خرید از', 'وضعیت' , 'نوع بیمه'];

            $firstRowWidth = [10, 20, 15, 15, 15,15, 10, 20, 50, 30,15, 15,
                20,10,15];
            $objCreateExcelFile = Load::controller('createExcelFile');
            $resultExcel = $objCreateExcelFile->create($resultBook, $firstRowColumnsHeading ,$firstRowWidth);
            if ($resultExcel['message'] == 'success'){
                return 'success|' . $resultExcel['fileName'];
            } else {
                return 'error|متاسفانه در ساخت فایل اکسل مشکلی پیش آمده. لطفا مجددا تلاش کنید';
            }


        } else {
            return 'error|اطلاعاتی برای ساخت فایل اکسسل وجود ندارد.';
        }


    }


    public function bookList($reportForExcel = null, $intendedUser=null)
    {
        $conditions = "";

        $date = dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode = explode('-', $date);
        $date_now_int_start = dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date_now_int_end = dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);

        if(!empty($intendedUser['member_id'])){
            $conditions.=' AND member_id='.$intendedUser['member_id'].' ';
        }

        if(!empty($intendedUser['agency_id'])){
            $conditions.=' AND agency_id='.$intendedUser['agency_id'].' ';
        }
	    if(!empty($_POST['member_id'])){
		    $conditions.=' AND member_id='.$_POST['member_id'].' ';
	    }

	    if(!empty($_POST['agency_id'])){
		    $conditions.=' AND agency_id='.$_POST['agency_id'].' ';
	    }
        if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {
            $date_of = explode('-', $_POST['date_of']);
            $date_to = explode('-', $_POST['to_date']);
            $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
            $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            $conditions .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";
        } else {
            $conditions .= "AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";
        }

        if (!empty($_POST['status'])) {
            if ($_POST['status'] == 'all') {
                $conditions .= " AND (status = 'nothing' OR status = 'prereserve' OR status = 'bank' OR status = 'book') ";
            } else if ($_POST['status'] == 'book') {
                $conditions .= " AND (status = 'book')";
            } else {
                $conditions .= " AND (status != 'book') ";
            }
        }

        if (!empty($_POST['factor_number'])) {
            $conditions .= " AND factor_number = '{$_POST['factor_number']}'";
        }

        if (!empty($_POST['client_id']) && TYPE_ADMIN == '1') {
            if ($_POST['client_id'] != "all") {
                $conditions .= " AND client_id = '{$_POST['client_id']}'";
            }
        }

        if (!empty($_POST['passenger_name'])) {
            $conditions .= " AND (passenger_name LIKE '%{$_POST['passenger_name']}%' OR passenger_family LIKE '%{$_POST['passenger_name']}%')";
        }

        if (!empty($_POST['passenger_passport_number'])) {
            $conditions .= " AND (passport_number = '{$_POST['passenger_passport_number']}')";
        }

        if (!empty($_POST['member_name'])) {
            $conditions .= " AND member_name LIKE '%{$_POST['member_name']}%'";
        }

        if (!empty($_POST['payment_type'])) {
            if ($_POST['payment_type'] == 'all') {
                $conditions .= " AND (payment_type != '' OR payment_type != 'none')";
            } elseif ($_POST['payment_type'] == 'credit') {
                $conditions .= " AND (payment_type = 'credit' OR payment_type = 'member_credit')";
            } else {
                $conditions .= " AND payment_type = '{$_POST['payment_type']}'";
            }
        }

        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $sql = "SELECT  rep.*, cli.AgencyName AS NameAgency, " .
                " SUM(rep.base_price + rep.tax) AS totalPrice, " .
                " SUM(rep.api_commission) AS api_commission, " .
                " SUM(rep.agency_commission) AS agency_commission, " .
                " SUM(rep.irantech_commission) AS irantech_commission, " .
                " SUM(paid_price) AS totalPriceIncreased " .
                " FROM report_insurance_tb AS rep LEFT JOIN clients_tb AS cli ON cli.id = rep.client_id " .
                " WHERE 1 = 1 " . $conditions .
                " GROUP BY rep.factor_number " .
                " ORDER BY rep.creation_date_int DESC ";
          
            $bookList = $ModelBase->select($sql);
        

        } else{

            $Model = Load::library('Model');
            $sql = "SELECT  *, " .
                " SUM(base_price + tax) AS totalPrice, " .
                " SUM(api_commission) AS api_commission, " .
                " SUM(agency_commission) AS agency_commission, " .
                " SUM(irantech_commission) AS irantech_commission, " .
                " SUM(paid_price) AS totalPriceIncreased " .
                " FROM book_insurance_tb " .
                " WHERE 1 = 1 {$conditions} ";
                        $get_session_sub_manage = Session::getAgencyPartnerLoginToAdmin();

                        if(Session::CheckAgencyPartnerLoginToAdmin() && $get_session_sub_manage=='AgencyHasLogin'){
                            $check_access = $this->getController('manageMenuAdmin')->getAccessServiceCounter(Session::getInfoCounterAdmin());

                            $sql .= " AND serviceTitle IN ({$check_access})";
                        }
                $sql .= " GROUP BY factor_number " .
                " ORDER BY creation_date_int DESC ";
           
            $bookList = $Model->select($sql);

        }

        $this->CountBook = count($bookList);

        $dataRows = [];
        $this->adt_qty = 0;
        $this->chd_qty = 0;
        $this->inf_qty = 0;
        $this->totalAgencyCommission = 0;
        $this->totalApiCommission = 0;
        $this->totalOurCommission = 0;
        $this->totalCost = 0;
        foreach ($bookList as $k => $book) {
            $numberColumn = $k + 2;


            $InfoMember = functions::infoMember($book['member_id'], $book['client_id']);
            //$InfoCounter = functions::infoCounterType($InfoMember['fk_counter_type_id'], $book['client_id']);
            $creation_date_int = dateTimeSetting::jdate('Y-m-d (H:i:s)', $book['creation_date_int']);
            $bookCounts = $this->bookInfo($book['factor_number']);


            switch ($book['status']){
                case 'book':
                    $status = 'رزرو قطعی';
                    break;
                case 'prereserve':
                    $status = 'پیش رزرو';
                    break;
                case 'bank':
                    $status = 'هدایت به درگاه';
                    break;
                case 'nothing':
                    $status = 'نامشخص';
                    break;
                default:
                    $status = 'نامشخص';
                    break;
            }

            switch ($book['reference_application']){
                case 'gds':
                    $reference_application = 'gds';
                    break;
                case 'at':
                    $reference_application = 'اتوماسیون';
                    break;
                case 'safar360':
                    $reference_application = 'سفر360';
                    break;
                default:
                    $reference_application = '';
                    break;
            }


            $dataRows[$k]['number_column'] = $numberColumn - 1;

            $dataRows[$k]['creation_date_int'] = $creation_date_int;
            $dataRows[$k]['member_name'] = $book['member_name'];
            $dataRows[$k]['member_mobile'] = $book['member_mobile'];
            $dataRows[$k]['pnr'] = $book['pnr'];
            $dataRows[$k]['destination'] = $book['destination'];
            $dataRows[$k]['source_name_fa'] = $book['source_name_fa'];
            $dataRows[$k]['factor_number'] = $book['factor_number'] . ' ';
            $dataRows[$k]['caption'] = $book['caption'];
            $dataRows[$k]['count'] = $bookCounts['adt_count'].' بزرگسال + '.$bookCounts['chd_count'].' کودک + '.$bookCounts['inf_count'].' خردسال';
            $dataRows[$k]['agency_commission'] = $book['agency_commission'];
            $dataRows[$k]['totalPriceIncreased'] = $book['totalPriceIncreased'];
            $dataRows[$k]['passenger'] = $book['passenger_name'] . ' ' . $book['passenger_family'];
            $dataRows[$k]['reference_application_fa'] = $reference_application;
            $dataRows[$k]['status_fa'] = $status;
            $dataRows[$k]['serviceTitle'] = $book['serviceTitle'];

            if (!isset($reportForExcel) || (isset($reportForExcel) && $reportForExcel == 'no')){


                $dataRows[$k]['is_member'] = $InfoMember['is_member'];
                $dataRows[$k]['fk_counter_type_id'] = $InfoMember['fk_counter_type_id'];
                $dataRows[$k]['member_email'] = $book['member_email'];
                $dataRows[$k]['adt_count'] = $bookCounts['adt_count'];
                $dataRows[$k]['chd_count'] = $bookCounts['chd_count'];
                $dataRows[$k]['inf_count'] = $bookCounts['inf_count'];
                if ($book['status'] == 'book'){
                    $this->adt_qty += $bookCounts['adt_count'];
                    $this->chd_qty += $bookCounts['chd_count'];
                    $this->inf_qty += $bookCounts['inf_count'];

                    $this->totalAgencyCommission += $book['agency_commission'];
                    $this->totalApiCommission += $book['api_commission'];
                    $this->totalOurCommission += $book['irantech_commission'];
                    $this->totalCost += $book['totalPriceIncreased'];
                }
                $dataRows[$k]['api_commission'] = $book['api_commission'];
                $dataRows[$k]['irantech_commission'] = $book['irantech_commission'];
                $dataRows[$k]['status'] = $book['status'];
                $dataRows[$k]['NameAgency'] = $book['NameAgency'];
                $dataRows[$k]['payment_type'] = $book['payment_type'];
                $dataRows[$k]['name_bank_port'] = $book['name_bank_port'];
                $dataRows[$k]['client_id'] = $book['client_id'];
                if ($this->numberPortBnak($book['name_bank_port'], $book['client_id']) == '379918'){
                    $dataRows[$k]['numberPortBank'] = 'درگاه ما';
                } else {
                    $dataRows[$k]['numberPortBank'] = 'درگاه خودش';
                }
                $dataRows[$k]['remote_addr'] = $book['remote_addr'];
                $dataRows[$k]['reference_application'] = $book['reference_application'];
                $dataRows[$k]['passenger_name'] = $book['passenger_name'];
                $dataRows[$k]['passenger_family'] = $book['passenger_family'];


            }




        }

        return $dataRows;

    }

    public function bookInfo($factorNumber){

        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $sql = "SELECT  *, " .
                " (SELECT COUNT(id) FROM report_insurance_tb WHERE factor_number = '{$factorNumber}' AND passenger_age='Adt') AS adt_count, " .
                " (SELECT COUNT(id) FROM report_insurance_tb WHERE factor_number = '{$factorNumber}' AND passenger_age='Chd') AS chd_count, " .
                " (SELECT COUNT(id) FROM report_insurance_tb WHERE factor_number = '{$factorNumber}' AND passenger_age='Inf') AS inf_count " .
                " FROM report_insurance_tb WHERE factor_number = '{$factorNumber}' ";
            $bookInfo = $ModelBase->load($sql);

        } else{

            $Model = Load::library('Model');
            $sql = "SELECT  *, " .
                " (SELECT COUNT(id) FROM book_insurance_tb WHERE factor_number = '{$factorNumber}' AND passenger_age='Adt') AS adt_count, " .
                " (SELECT COUNT(id) FROM book_insurance_tb WHERE factor_number = '{$factorNumber}' AND passenger_age='Chd') AS chd_count, " .
                " (SELECT COUNT(id) FROM book_insurance_tb WHERE factor_number = '{$factorNumber}' AND passenger_age='Inf') AS inf_count " .
                " FROM book_insurance_tb WHERE factor_number = '{$factorNumber}' ";
            $bookInfo = $Model->load($sql);

        }

        return $bookInfo;
    }

    public function bookRecordsByFactorNumber($factorNumber) {

        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $sql = "SELECT  *, " .
                " (SELECT COUNT(id) FROM report_insurance_tb WHERE factor_number='{$factorNumber}') AS CountId, " .
                " (SELECT SUM(base_price + tax) FROM report_insurance_tb WHERE factor_number='{$factorNumber}') AS totalPrice, " .
                " paid_price AS totalPriceIncreased " .
                " FROM report_insurance_tb WHERE factor_number='{$factorNumber}' ";
            $bookRecords = $ModelBase->select($sql);

        } else{

            $Model = Load::library('Model');
            $sql = "SELECT  *, " .
                " (SELECT COUNT(id) FROM book_insurance_tb WHERE factor_number='{$factorNumber}') AS CountId, " .
                " (SELECT SUM(base_price + tax) FROM book_insurance_tb WHERE factor_number='{$factorNumber}') AS totalPrice, " .
                " paid_price AS totalPriceIncreased " .
                " FROM book_insurance_tb WHERE factor_number='{$factorNumber}' ";
            $bookRecords = $Model->select($sql);

        }

        return $bookRecords;
    }

    public function namebank($bank_dir = null, $client_id)
    {

        if ($bank_dir != null && !empty($bank_dir)) {
            if (!empty($client_id)) {
                $admin = Load::controller('admin');

                $sql = " SELECT * FROM bank_tb WHERE bank_dir='{$bank_dir}'";

                $Bank = $admin->ConectDbClient($sql, $client_id, "Select", "", "", "");

                return $Bank['title'];
            }
        } else {
            return 'ندارد';
        }
    }

    public function numberPortBnak($bank_dir = null, $client_id)
    {

        if ($bank_dir != null && !empty($bank_dir)) {
            if (!empty($client_id)) {
                $admin = Load::controller('admin');

                $sql = " SELECT * FROM bank_tb WHERE bank_dir='{$bank_dir}'";
                $Bank = $admin->ConectDbClient($sql, $client_id, "Select", "", "", "");

                return $Bank['param1'];
            }
        } else {
            return 'ندارد';
        }
    }

    public function nameAgency($client_id)
    {


        if (!empty($client_id)) {

            $ModelBase = Load::library('ModelBase');
            $sql = " SELECT * FROM clients_tb WHERE id='{$client_id}'";
            $res = $ModelBase->load($sql);

            return $res['AgencyName'];
        } else {
            return 'ندارد';
        }
    }



    #region total_price_insurance
    public function total_price_insurance($factor_number)
    {
        $insurance = Load::controller('insurance');
        $amount = $insurance->getTotalPriceByFactorNumber($factor_number);
        return $amount['totalPrice'];
    }
    #endregion


    #region insuranceInfoTracking
    public function insuranceInfoTracking($factor_number)
    {

        $Model = Load::library('Model');

        $sql = " SELECT * FROM book_insurance_tb WHERE factor_number = '{$factor_number}' OR pnr = '{$factor_number}' ";
        $book = $Model->load($sql);

        $result = '';
        if (!empty($book)) {

            $result .= '
            <table class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>نوع بیمه/مقصد<br/>(عنوان بیمه)
                    </th>
                    <th>شماره واچر</th>
                    <th>شماره بیمه</th>
                    <th>تاریخ خرید</th>
                    <th>نام مسافر</th>
                    <th>مبلغ</th>
                    <th>وضعیت</th>
                    <th>مشاهده</th>
                </tr>
                </thead>
                <tbody>
            ';

            $this->FactorNumber = $book['factor_number'];
            $creation_date_int = dateTimeSetting::jdate('Y-m-d', $book['creation_date_int']);
            $price = functions::calcDiscountCodeByFactor($this->total_price_insurance($book['factor_number']), $book['factor_number']);

            if ($book['status'] == 'book') {
                $status = 'رزرو قطعی';
            } else if ($book['status'] == 'prereserve') {
                $status = 'پیش رزرو';
            } else if ($book['status'] == 'bank') {
                $status = 'هدایت به درگاه';
            }else if ($book['status'] == 'nothing') {
                $status = 'نامشخص';
            }

            $op = '<a  id="myBtn" onclick="modalListInsurance('."'".$book['factor_number']."'".')" class="btn btn-primary fa fa-eye margin-10" title="مشاهده رزرو"></a>';
            if($book['status'] == 'book'){
                $op .= '<a id="cancelbyuser"  title="' . functions::Xmlinformation("RefundTicket") . '" onclick="ModalCancelUser(' . "'insurance'" . ',' . "'" . $book['factor_number'] . "'" . '); return false;"  class="btn btn-danger fa fa-times"></a>';
            }

            $result .= '<tr>';
            $result .= '<td>' . $book['source_name_fa'] . '/' . $book['destination'];
                if ($book['caption'] != ''){$result .= '<br>' . $book['caption'];}
            $result .='</td>';
            $result .= '<td>' . $book['factor_number'] . '</td>';
            $result .= '<td>' . $book['pnr'] . '</td>';
            $result .= '<td>' . $creation_date_int . '</td>';
            $result .= '<td>' . $book['passenger_name'] . ' ' . $book['passenger_family'] . '</td>';
            $result .= '<td>' . number_format($price) . '</td>';
            $result .= '<td>' . $status . '</td>';
            $result .= '<td>' . $op . '</td>';
            $result .= '</tr>';
            $result .= '</table>';

            return $result;

        }

    }
    #endregion



}