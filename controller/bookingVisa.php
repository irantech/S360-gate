<?php

/**
 * Class bookingVisa
 * @property bookingVisa $bookingVisa
 */
class bookingVisa extends clientAuth {
    public $okBook = '';
    public $payment_date = '';
    public $factorNumber = '';
    public $bookCount = 0;
    public $visaInfo;

    public $transactions;

    public function __construct() {
//        functions::displayErrorLog();
        $this->transactions = $this->getModel('transactionsModel');
    }

    public function updateBank($codRahgiri, $factorNum) {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $data = array('tracking_code_bank' => $codRahgiri, 'payment_date' => date('Y-m-d H:i:s'));

        $condition = " factor_number='" . $factorNum . "' AND status = 'bank' ";
        $Model->setTable('book_visa_tb');
        $res = $Model->update($data, $condition);

        if ($res) {
            $ModelBase->setTable('report_visa_tb');
            $ModelBase->update($data, $condition);
        }
    }

    public function visaBook($factorNumber, $payType = null) {
        $model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $objTransaction = Load::controller('transaction');
        $smsController = Load::controller('smsServices');

        $this->factorNumber = trim($factorNumber);
        $this->visaInfo = $this->bookInfo($this->factorNumber);

        //prevent book agian in refresh of page
        if ($this->visaInfo['status'] != 'book') {

            if ($payType != 'credit') {
                // Caution: آپدیت تراکنش به موفق
                $objTransaction->setCreditToSuccess($this->factorNumber, $this->visaInfo['tracking_code_bank']);
            }

            $data['status'] = 'book';
            $data['payment_date'] = date('Y-m-d H:i:s');

            if ($payType == 'credit') {
                $data['payment_type'] = 'credit';
            } elseif ($this->visaInfo['tracking_code_bank'] == 'member_credit') {
                $data['payment_type'] = 'member_credit';
                $data['tracking_code_bank'] = '';
            } else {
                $data['payment_type'] = 'cash';
            }

            $condition = " factor_number='{$this->factorNumber}' ";
            $model->setTable('book_visa_tb');
            $res = $model->update($data, $condition);

            if ($res) {
                $ModelBase->setTable('report_visa_tb');
                $ModelBase->update($data, $condition);
                $this->okBook = true;
                $this->payment_date = $data['payment_date'];
            }

        }

        if ($this->okBook == true) {
            //email to buyer
            $this->emailVisaSelf($this->factorNumber);

            //sms to buyer
            $objSms = $smsController->initService('0');
            if($objSms) {
                $messageVariables = array(
                    'sms_name' => $this->visaInfo['member_name'],
                    'sms_service' => 'ویزا',
                    'sms_factor_number' => $this->visaInfo['factor_number'],
                    'sms_destination' => $this->visaInfo['visa_destination'],
                    'sms_visa_title' => $this->visaInfo['visa_title'],
                    'sms_visa_type' => $this->visaInfo['visa_type'],
                    'sms_visa_duration' => $this->visaInfo['visa_validity_duration'],
                    'sms_agency' => CLIENT_NAME,
                    'sms_agency_mobile' => CLIENT_MOBILE,
                    'sms_agency_phone' => CLIENT_PHONE,
                    'sms_agency_email' => CLIENT_EMAIL,
                    'sms_agency_address' => CLIENT_ADDRESS,
                );
                $smsArray = array(
                    'smsMessage' => $smsController->getUsableMessage('afterVisaReserve', $messageVariables),
                    'cellNumber' => !empty($this->visaInfo['mobile_buyer']) ? $this->visaInfo['mobile_buyer'] : $this->visaInfo['member_mobile'],
                    'smsMessageTitle' => 'afterVisaReserve',
                    'memberID' => (!empty($this->visaInfo['member_id']) ? $this->visaInfo['member_id'] : ''),
                    'receiverName' => $messageVariables['sms_name'],
                );
                $smsController->sendSMS($smsArray);



                $sms = "مدیریت محترم آژانس" . " " . CLIENT_NAME . PHP_EOL . "رزرو ویزای".PHP_EOL.$this->visaInfo['visa_title'].PHP_EOL.
                    'به شماره فاکتور'.PHP_EOL.
                    $this->visaInfo['factor_number'].PHP_EOL.'به ثبت رسید.';

                $smsArray = array(
                    'smsMessage' => $sms,
                    'cellNumber' => CLIENT_MOBILE
                );
                $smsController->sendSMS($smsArray);
            }




        } elseif ($this->okBook != true && $payType == 'credit') {

            //delete success transaction if book failed
            $this->delete_transaction_current($this->factorNumber);

            //delete success credit of agency if book failed
            $this->delete_credit_Agency_current($this->factorNumber);
        }

    }

    public function delete_transaction_current($factorNumber) {
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

    public function delete_credit_Agency_current($factorNumber) {
        if (!$this->checkBookStatus($factorNumber)) {
            $Model = Load::library('Model');
            $condition = "requestNumber = '{$factorNumber}' AND requestNumber !='' AND type='decrease'";
            $Model->setTable('credit_detail_tb');
            $Model->delete($condition);
        }
    }

    public function checkBookStatus($factorNumber) {
        $Model = Load::library('Model');

        $query = "SELECT status FROM book_visa_tb WHERE factor_number = '{$factorNumber}'";
        $result = $Model->load($query);

        return $result['status'] == 'book' ? true : false;
    }

    public function emailVisaSelf($factor_number) {
        $visaInfo = $this->bookInfo($factor_number);

        if (!empty($visaInfo)) {

            $res_pdf = $this->bookRecords($factor_number);
            $count_reserve = count($res_pdf);

            /*$emailContent = '
            <tr>
                <td valign="top" class="mcnTextContent" style="padding: 18px;color: #000000;font-size: 14px;font-weight: normal;text-align: center;">
                    <h3 class="m_-2679729263370124627null" style="text-align:center;display:block;margin:0;padding:0;color:#000000;font-family:tahoma,verdana,segoe,sans-serif;font-size:22px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal">
 رزرو '.$count_reserve.' عدد 
                        <span style="color:#FFFFFF"><strong>' . $visaInfo['visa_title'] . '</strong></span>
به مقصد 
                        <span style="color:#FFFFFF"><strong>' . $visaInfo['visa_destination'] . '</strong></span>
                    </h3>
                    <div style="margin-top: 20px;text-align:right;color:#FFFFFF; font-family:tahoma,verdana,segoe,sans-serif">
                    با سلام <br>
دوست عزیز؛ از اینکه خدمات ما را انتخاب نموده اید سپاسگزاریم <br>
                    لطفا جهت مشاهده و چاپ واچر(های) ویزا روی دکمه چاپ واچر مربوطه که در قسمت پایین قرار دارد کلیک نمایید 
                    </div>
                </td>
            </tr>
            ';*/

            foreach ($res_pdf as $k => $each) {

                $param['pdf'][$k]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingVisa&id=' . $each['unique_code'];
                $param['pdf'][$k]['button_title'] = 'چاپ واچر' . $each['passenger_name'] . ' ' . $each['passenger_family'];

                /*$pdfButton .= '
                <tr>
                    <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 14px;">
                        <a class="mcnButton " title="چاپ واچر" href="' . ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingVisa&id=' . $each['unique_code'] . '" target="_blank" style="background-color: #284861;padding: 15px;margin:5px 0;border-radius: 10px;font-weight: bold;letter-spacing: 0px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">چاپ واچر '.$each['passenger_name'].' '.$each['passenger_family'].'</a>
                    </td>
                </tr>
                ';*/
            }

            $emailBody = 'با سلام' . '<br>';
            $emailBody .= 'دوست عزیز؛ از اینکه خدمات ما را انتخاب نموده اید سپاسگزاریم' . '<br>';
            $emailBody .= 'لطفا جهت مشاهده و چاپ واچر(های) ویزا روی دکمه چاپ واچر مربوطه که در قسمت پایین قرار دارد کلیک نمایید' . '<br>';

            $param['title'] = 'رزرو ' . $count_reserve . ' عدد' . $visaInfo['visa_title'] . ' به مقصد' . $visaInfo['visa_destination'];
            $param['body'] = $emailBody;


            $to = $visaInfo['email_buyer'];
            $subject = "رزرو ویزا";
            $message = functions::emailTemplate($param);
            $headers = "From: noreply@" . CLIENT_DOMAIN . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8";
            ini_set('SMTP', 'smtphost');
            ini_set('smtp_port', 25);

            mail($to, $subject, $message, $headers);
        }
    }

    public function formatTime($time) {
        $time1 = substr($time, '0', '2');
        $time2 = substr($time, '2', '4');
        $subject = array('H', 'M');
        $time2 = str_replace($subject, ':', $time2);
        return $time1 . $time2;
    }

    public function format_hour($num) {

        $time = date("H:i", strtotime($num));

        return $time;
    }

    public function setPortBankVisa($bankDir, $factor_number) {
        $initialValues = array('bank_dir' => $bankDir, 'serviceTitle' => $_POST['serviceType']);

        $bankModel = Load::model('bankList');
        $bankInfo = $bankModel->getByBankDir($initialValues);

        $data['name_bank_port'] = $bankDir;
        $data['number_bank_port'] = $bankInfo['param1'];

        $Model = Load::library('Model');
        $Model->setTable('book_visa_tb');

        $condition = " factor_number='{$factor_number}'";
        $res = $Model->update($data, $condition);
        if ($res) {
            $ModelBase = Load::library('ModelBase');
            $ModelBase->setTable('report_visa_tb');
            $ModelBase->update($data, $condition);
        }
    }

    public function sendUserToBankForVisa($FactorNumber) {
        $data = array('status' => "bank", 'payment_type' => "cash");

        $condition = " factor_number = '{$FactorNumber}' ";
        $Model = Load::library('Model');
        $Model->setTable('book_visa_tb');
        $Model->update($data, $condition);

        $ModelBase = Load::library('ModelBase');
        $ModelBase->setTable('report_visa_tb');
        $ModelBase->update($data, $condition);
    }


    public function createExcelFile($param) {

        $_POST = $param;
        $resultBook = $this->bookList('yes');
        if (!empty($resultBook)) {

            // برای نام گذاری سطر اول فایل اکسل //
            $firstRowColumnsHeading = ['ردیف', 'تاریخ خرید', 'نام خریدار', 'شماره فاکتور', 'مقصد', 'نوع ویزا', 'عنوان ویزا', 'تعداد ویزا', 'سهم آژانس', 'مبلغ کل بدون تخفیف', 'مبلغ کل', 'مبلغ پرداختی', 'وضعیت'];
            $firstRowWidth = [10, 20, 15, 20, 10, 20, 20, 30, 15,15, 15, 15,10];

            $objCreateExcelFile = Load::controller('createExcelFile');
            $resultExcel = $objCreateExcelFile->create($resultBook, $firstRowColumnsHeading ,$firstRowWidth);
            if ($resultExcel['message'] == 'success') {
                return 'success|' . $resultExcel['fileName'];
            } else {
                return 'error|متاسفانه در ساخت فایل اکسل مشکلی پیش آمده. لطفا مجددا تلاش کنید';
            }


        } else {
            return 'error|اطلاعاتی برای ساخت فایل اکسسل وجود ندارد.';
        }


    }


    public function bookList($reportForExcel = null, $intendedUser = null) {
        $conditions = "";

        $date = dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode = explode('-', $date);
        $date_now_int_start = dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date_now_int_end = dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);

        if (!empty($intendedUser['member_id'])) {
            $conditions .= ' AND member_id=' . $intendedUser['member_id'] . ' ';
        }

        if (!empty($intendedUser['agency_id'])) {
            $conditions .= ' AND agency_id=' . $intendedUser['agency_id'] . ' ';
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

        $get_session_sub_manage = Session::getAgencyPartnerLoginToAdmin();

        if(Session::CheckAgencyPartnerLoginToAdmin() && $get_session_sub_manage=='AgencyHasLogin'){
            $check_access = $this->getController('manageMenuAdmin')->getAccessServiceCounter(Session::getInfoCounterAdmin());

            $conditions .= " AND serviceTitle IN ({$check_access})";
        }

        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $sql = "SELECT  rep.*, cli.AgencyName AS NameAgency, " . " SUM(rep.visa_main_cost) AS totalPrice, " . " rep.total_price AS totalPayment, " . " SUM(rep.visa_prepayment_cost) AS totalPrePayment, " . " SUM(rep.api_commission) AS api_commission, " . " SUM(rep.agency_commission) AS agency_commission, " . " SUM(rep.irantech_commission) AS irantech_commission " . " FROM report_visa_tb AS rep LEFT JOIN clients_tb AS cli ON cli.id = rep.client_id " . " WHERE 1 = 1 " . $conditions . " GROUP BY rep.factor_number " . " ORDER BY rep.creation_date_int DESC ";
            $bookList = $ModelBase->select($sql);

        } else {

            $Model = Load::library('Model');
            $sql = "SELECT  *, " . " SUM(visa_main_cost) AS totalPrice, " . " total_price AS totalPayment, " . " SUM(visa_prepayment_cost) AS totalPrePayment, " . " SUM(api_commission) AS api_commission, " . " SUM(agency_commission) AS agency_commission, " . " SUM(irantech_commission) AS irantech_commission " . " FROM book_visa_tb " . " WHERE 1 = 1 " . $conditions . " GROUP BY factor_number " . " ORDER BY creation_date_int DESC ";
            $bookList = $Model->select($sql);

        }

        $this->bookCount = count($bookList);


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
            $creation_date_int = dateTimeSetting::jdate('Y-m-d (H:i:s)', $book['creation_date_int']);
            $bookCounts = $this->bookInfo($book['factor_number']);


            switch ($book['status']) {
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

            $dataRows[$k]['number_column'] = $numberColumn - 1;
            $dataRows[$k]['creation_date_int'] = $creation_date_int;
            $dataRows[$k]['member_name'] = $book['member_name'];
            $dataRows[$k]['factor_number'] = $book['factor_number'] .' ';
            $dataRows[$k]['visa_destination'] = $book['visa_destination'];
            $dataRows[$k]['visa_type'] = $book['visa_type'];
            $dataRows[$k]['visa_title'] = $book['visa_title'];
            $dataRows[$k]['count'] = $bookCounts['adt_count'] . ' بزرگسال + ' . $bookCounts['chd_count'] . ' کودک + ' . $bookCounts['inf_count'] . ' خردسال';
            $dataRows[$k]['agency_commission'] = $book['agency_commission'];
            $dataRows[$k]['totalPrice'] = $book['totalPrice'];
            $dataRows[$k]['totalPayment'] = $book['totalPayment'];
            $dataRows[$k]['totalPrePayment'] = $book['totalPrePayment'];
            $dataRows[$k]['status_fa'] = $status;
            /** @var \visa $visa */
            $visa = Load::controller('visa');
            $dataRows[$k]['visa_statuses'] = $visa->getVisaStatuses($book['visa_id']);
            /** @var \visaRequestStatus $visa_request_status */
            $visa_request_status = Load::controller('visaRequestStatus');

            $dataRows[$k]['visa_request_status'] = $visa_request_status->getSingle($book['visa_request_status_id']);


            if (!isset($reportForExcel) || (isset($reportForExcel) && $reportForExcel == 'no')) {

                $dataRows[$k]['is_member'] = $InfoMember['is_member'];
                $dataRows[$k]['fk_counter_type_id'] = $InfoMember['fk_counter_type_id'];
                $dataRows[$k]['member_email'] = $book['member_email'];
                $dataRows[$k]['adt_count'] = $bookCounts['adt_count'];
                $dataRows[$k]['chd_count'] = $bookCounts['chd_count'];
                $dataRows[$k]['inf_count'] = $bookCounts['inf_count'];
                if ($book['status'] == 'book') {
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
                if ($this->numberPortBnak($book['name_bank_port'], $book['client_id']) == '379918') {
                    $dataRows[$k]['numberPortBank'] = 'درگاه ما';
                } else {
                    $dataRows[$k]['numberPortBank'] = 'درگاه خودش';
                }
                $dataRows[$k]['remote_addr'] = $book['remote_addr'];
                $dataRows[$k]['passengers_file'] = $book['passengers_file'];
                $dataRows[$k]['visa_request_status'] = $dataRows[$k]['visa_request_status'];
            } else {
                unset($dataRows[$k]['visa_statuses']);
                $dataRows[$k]['visa_request_status'] = $dataRows[$k]['visa_request_status']['title'];
            }


        }


        return $dataRows;

    }

    public function bookInfo($factorNumber) {

        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $sql = "SELECT  *, " .
                " (SELECT COUNT(id) FROM report_visa_tb WHERE factor_number = '{$factorNumber}' AND passenger_age='Adt') AS adt_count, " .
                " (SELECT COUNT(id) FROM report_visa_tb WHERE factor_number = '{$factorNumber}' AND passenger_age='Chd') AS chd_count, " .
                " (SELECT COUNT(id) FROM report_visa_tb WHERE factor_number = '{$factorNumber}' AND passenger_age='Inf') AS inf_count " .
                " FROM report_visa_tb WHERE factor_number = '{$factorNumber}' ";
            $result = $ModelBase->load($sql);

        } else {

            $Model = Load::library('Model');
            $sql = "SELECT  *, " .
                " (SELECT COUNT(id) FROM book_visa_tb WHERE factor_number = '{$factorNumber}' AND passenger_age='Adt') AS adt_count, " .
                " (SELECT COUNT(id) FROM book_visa_tb WHERE factor_number = '{$factorNumber}' AND passenger_age='Chd') AS chd_count, " .
                " (SELECT COUNT(id) FROM book_visa_tb WHERE factor_number = '{$factorNumber}' AND passenger_age='Inf') AS inf_count " .
                " FROM book_visa_tb WHERE factor_number = '{$factorNumber}' ";
            $result = $Model->load($sql);

        }

        return $result;
    }

    public function bookRecords($factorNumber) {

        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $sql = "SELECT * FROM report_visa_tb WHERE factor_number = '{$factorNumber}' ";
            $result = $ModelBase->select($sql);

        } else {

            $Model = Load::library('Model');
            $sql = "SELECT  * FROM book_visa_tb WHERE factor_number = '{$factorNumber}' ";
            $result = $Model->select($sql);

        }

        return $result;
    }

    public function namebank($bank_dir = null, $client_id) {

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

    public function numberPortBnak($bank_dir = null, $client_id) {

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

    public function nameAgency($client_id) {
        if (!empty($client_id)) {

            $ModelBase = Load::library('ModelBase');
            $sql = " SELECT * FROM clients_tb WHERE id='{$client_id}'";
            $res = $ModelBase->load($sql);

            return $res['AgencyName'];
        } else {
            return 'ندارد';
        }
    }

    public function list_hamkar() {
        $ModelBase = Load::library('ModelBase');

        $sql = " SELECT * FROM clients_tb ORDER BY id DESC";
        $result = $ModelBase->select($sql);

        return $result;
    }

    #region visaInfoTracking
    public function visaInfoTracking($factor_number) {
        $book = $this->bookInfo($factor_number);

        $result = '';
        if (!empty($book)) {

            $result .= '
            <table class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>' . functions::Xmlinformation("Typevisa") . '/' . functions::Xmlinformation("Destination") . '<br/>(' . functions::Xmlinformation("Titlevisa") . ')
                    </th>
                    <th>' . functions::Xmlinformation("WachterNumber") . '</th>
                    <th>' . functions::Xmlinformation("Buydate") . '</th>
                    <th>' . functions::Xmlinformation("Namepassenger") . '</th>
                    <th>' . functions::Xmlinformation("Amount") . '</th>
                    <th>' . functions::Xmlinformation("PrePrice") . '</th>
                    <th>' . functions::Xmlinformation("Status") . '</th>
                    <th>' . functions::Xmlinformation("See") . '</th>
                    <th>' . functions::Xmlinformation("Action") . '</th>
                </tr>
                </thead>
                <tbody>
            ';

            $creation_date_int = dateTimeSetting::jdate('Y-m-d', $book['creation_date_int']);
            $prePrice = $book['visa_prepayment_cost'] * ($book['adt_count'] + $book['chd_count'] + $book['inf_count']);
            $prePrice = functions::calcDiscountCodeByFactor($prePrice, $book['factor_number']);
            $action = "";

            if ($book['status'] == 'book') {
                $status = functions::Xmlinformation("Definitivereservation");

                $action = '
                <div id="btn-upload-file">
                    <a class="btn" onclick="isOpenModalVisa(' . "'" . $book['factor_number'] . "'" . ', ' . "'" . $book['documents_visa'] . "'" . ');">' . functions::Xmlinformation("uploadingVisaDocuments") . '</a>
                </div>
                ';

            } else if ($book['status'] == 'prereserve') {
                $status = functions::Xmlinformation("Prereservation");
            } else if ($book['status'] == 'bank') {
                $status = functions::Xmlinformation("NavigateToPort");
            } else if ($book['status'] == 'nothing') {
                $status = functions::Xmlinformation("Unknow");
            }

            $op = '<a  id="myBtn" onclick="modalListVisa(' . "'" . $book['factor_number'] . "'" . ')" class="btn btn-primary fa fa-eye margin-10" title="' . functions::Xmlinformation("SeeBooking") . '"></a>';

            $result .= '<tr>';
            $result .= '<td>' . $book['visa_type'] . '/' . $book['visa_destination'];
            $result .= '<br>' . $book['visa_title'];
            $result .= '</td>';
            $result .= '<td>' . $book['factor_number'] . '</td>';
            $result .= '<td>' . $creation_date_int . '</td>';
            $result .= '<td>' . $book['passenger_name'] . ' ' . $book['passenger_family'] . '</td>';
            $result .= '<td>' . number_format($book['total_price']) . '</td>';
            $result .= '<td>' . number_format($prePrice) . '</td>';
            $result .= '<td>' . $status . '</td>';
            $result .= '<td>' . $op . '</td>';
            $result .= '<td>' . $action . '</td>';
            $result .= '</tr>';
            $result .= '</table>';

            return $result;

        }

    }
    #endregion

    #region getBookByUniqueCode
    public function getBookByUniqueCode($uniqueCode) {
        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $sql = "SELECT * FROM report_visa_tb WHERE unique_code = '{$uniqueCode}' ";
            $result = $ModelBase->load($sql);

        } else {

            $Model = Load::library('Model');
            $sql = "SELECT * FROM book_visa_tb WHERE unique_code = '{$uniqueCode}' ";
            $result = $Model->load($sql);

        }

        return $result;
    }
    #endregion

    #region createPdfContent
    public function createPdfContent($uniqueCode) {

        $data = $this->getBookByUniqueCode($uniqueCode);

        $pdfContent = '';
        if ($data['status'] == 'book') {

            $logo = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . CLIENT_LOGO;
            $passengerAge = ($data['passenger_age'] == 'Adt' ? 'بزرگسال' : ($data['passenger_age'] == 'Chd' ? 'کودک' : 'نوزاد'));
            $offPrice = $data['visa_main_cost'] * ($data['percent_discount'] / 100);
            $paymentPrice = $data['visa_main_cost'] - ($data['visa_prepayment_cost'] + $offPrice);

            $pdfContent .= '
<!DOCTYPE html>
<html>
    <head>
        <title>واچر ویزا با شماره فاکتور ' . $data['factor_number'] . '</title>
        <style type="text/css">
            @font-face {
                font-family: "Yekan";
                font-style: normal;
                font-weight: normal;
                src: url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.woff?#iefix") format("embedded-opentype"),
                url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.woff") format("woff"),
                url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.ttf") format("truetype");
            }
            table{
                margin: 10px 100px;
                font: normal 16px/30px Yekan;
            }
            .page {
                border-collapse: collapse;
                border: 1px solid #000;
            }
            .page td, .page th{
               padding:5px;
               margin:0;
               border-left: 1px solid #000;
               text-align: center;
               vertical-align: top;
            }
            .page td:first-child, .page th:first-child{
                border-left: none;
            }
            .page th{
                border-bottom: 1px solid #000;
            }
            .borderBottomTd{
                border-bottom: 1px solid #000;
            }
            p{
                font: bold 15px/25px Yekan;
            }
            .title{
                height: 120px;
                font: bold 18px/30px Yekan;
            }
            .borderTop{
                border-top: 1px solid #000;
            }
            .padd li{
                padding-left: 30px;
                padding-right: 30px;
            }
            .rtl{
                direction: rtl;
            }
            .ltr{
                direction: ltr;
            }
            .pageBreak{page-break-before: always;}
            .topFrame{
                border: 1px solid #000;
                background-color: #FFF;
                border-radius: 5px;
                z-index: 1000;
                width: 100px;
                padding: 5px 10px;
                margin: 0px 110px -35px;
                text-align: center;
            }
            .footer{
                position: absolute; 
                bottom: 30px; 
                width: 100%;
                text-align: center; 
            }
            .footer p{
                margin: 10px 100px;
                border: 1px solid #000;
            }
        </style>
    </head>
    <body>';

            $pdfContent .= '
            <p style="height: 20px;"></p>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="ltr">
                <tr>
                    <td width="50%" align="left">Date of Issue: ' . substr($data['payment_date'], 0, 10) . '</td>
                    <td width="50%" align="right">' . functions::ConvertToJalali(substr($data['payment_date'], 0, 10)) . ' تاریخ رزرو:</td>
                </tr>
            </table>
            
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="rtl">
                <tr>
                    <td width="33%"><img src="' . $logo . '" height="100" /></td>
                    <td width="34%" align="center" class="title">' . $data['visa_title'] . '</td>
                    <td width="33%"></td>
                </tr>
            </table>
            
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page rtl">
                <tr>
                    <th colspan="2">اطلاعات مسافر</th>
                </tr>
                <tr>
                    <td width="50%" align="right">
                        <ul>
                            <li>نام: ' . $data['passenger_name'] . '</li>
                            <li>نام خانوادگی: ' . $data['passenger_family'] . '</li>
                            <li>تاریخ تولد: ' . (!empty($data['passenger_birthday']) ? $data['passenger_birthday'] : functions::ConvertToJalali($data['passenger_birthday_en'])) . '</li>
                            <li>شماره پاسپورت: ' . $data['passport_number'] . '</li>
                            <li>رده سنی: ' . $passengerAge . '</li>
                        </ul>
                    </td>
                    <td width="50%" align="left">
                        <ul>
                            <li>Name: ' . $data['passenger_name_en'] . '</li>
                            <li>Family Name: ' . $data['passenger_family_en'] . '</li>
                            <li>Date of Birth: ' . (!empty($data['passenger_birthday_en']) ? $data['passenger_birthday_en'] : functions::ConvertToMiladi($data['passenger_birthday'])) . '</li>
                            <li>Passport Number: ' . $data['passport_number'] . '</li>
                            <li>Age Range: ' . $data['passenger_age'] . '</li>
                        </ul>
                    </td>
                </tr>
            </table>
            
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page rtl">
                <tr>
                    <td width="50%">مقصد: ' . $data['visa_destination'] . '</td>
                    <td width="50%">نوع: ' . $data['visa_type'] . '</td>
                </tr>
            </table>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page ltr">
                <tr>
                    <td width="34%">زمان تحویل: ' . $data['visa_deadline'] . '</td>
                    <td width="33%">مدت اعتبار: ' . $data['visa_validity_duration'] . '</td>
                    <td width="33%">تعداد ورود: ' . $data['visa_allowed_use_no'] . '</td>
                </tr>
            </table>
            
            <p class="topFrame">  توضیحات: </p>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page rtl">
                <tr>
                    <td align="right" style="padding: 25px 15px 15px;">' . $data['visa_descriptions'] . ' </td>
                </tr>
            </table>
            
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page rtl">
                <tr>
                    <th width="70%">هزینه ها</th>
                    <th width="30%">مبلغ به ریال</th>
                </tr>
                <tr>
                    <td class="borderBottomTd">مبلغ ویزا</td>
                    <td class="borderBottomTd">' . number_format($data['visa_main_cost']) . '</td>
                </tr>
                ' . ($data['percent_discount'] > 0 ? '
                <tr>
                    <td class="borderBottomTd">میزان تخفیف (' . $data['percent_discount'] . ' درصد)</td>
                    <td class="borderBottomTd">' . number_format($offPrice) . '</td>
                </tr>
                ' : '') . '
                <tr>
                    <td class="borderBottomTd">پیش پرداخت</td>
                    <td class="borderBottomTd">' . number_format($data['visa_prepayment_cost']) . '</td>
                </tr>
                <tr>
                    <td>مبلغ قابل پرداخت</td>
                    <td><p>' . number_format($paymentPrice) . '</p></td>
                </tr>
            </table>
            
            <div class="footer">
                <table width="100%" align="center" cellpadding="0" cellspacing="0" class="rtl">
                    <tr>
                        <td align="center" colspan="2"><p>آدرس: ' . CLIENT_ADDRESS . '</p></td>
                    </tr>
                    <tr>
                        <td align="center"><p>تلفن پشتیبانی: ' . CLIENT_PHONE . '</p></td>
                        <td align="center"><p>وب سایت: ' . CLIENT_MAIN_DOMAIN . '</p></td>
                    </tr>
                </table>
            </div>
            ';

            $pdfContent .= '
    </body>
</html>
            ';

            return $pdfContent;
        }

        return 'خطا: رزرو با شماره فاکتور مذکور قطعی نشده است';
    }

    #endregion

    public function changeBookRequestStatus($data = array()) {
//        return functions::toJson($data);
        $status = $data['status'];
        /** @var visaRequestStatusModel $visaRequestStatusModel */
        $visaRequestStatusModel = Load::getModel('visaRequestStatusModel');
        $get_status = $visaRequestStatusModel->get()->where('id',$status)->find();
        $factor_number = $data['factor_number'];

        /** @var Model $Model */
        $Model = Load::library('Model');
        $mobile_buyer = $Model->load("SELECT mobile_buyer FROM book_visa_tb WHERE factor_number = '{$factor_number}'");
        $result_data = array(
            'mobile'=>$mobile_buyer['mobile_buyer'],
            'sms_content'=>$get_status['notification_content'],
        );
        $update = $Model->updateWithBind(['visa_request_status_id' => $status], "factor_number=$factor_number", 'book_visa_tb');
        if ($update) {
            /** @var ModelBase $ModelBase */
            $ModelBase = Load::library('ModelBase');
            $update_report = $ModelBase->updateWithBind(['visa_request_status_id' => $status], "factor_number=$factor_number", 'report_visa_tb');
            if ($update_report) {
                return functions::withSuccess($result_data, 200, 'وضعیت با موفقیت تغییر کرد');
            }
            return functions::withError($result_data, 400, 'خطا در بروزرسانی');
        }
        return functions::withError($result_data, 400, 'خطا در بروزرسانی');
    }

    public function sendSmsToUserByStatusChange($data) {
        /** @var smsServices $smsController */
        $smsController = Load::controller('smsServices');
        $smsController->initService(1);
        $sms_data = array(
            'cellNumber'=>$data['cellNumber'],
            'smsMessage'=>$data['smsMessage'],
        );
        $sms_result = $smsController->sendSMS($sms_data);
        return functions::withSuccess($sms_result,200,'پیامک با موفقیت ارسال شد');
    }
}