<?php

/**
 * Class bookingGasht
 * @property bookingGasht $bookingGasht
 */
class bookingGasht extends clientAuth
{
    public $okGasht = '';
    public $CountBook = 0;
    public $payment_date = '';
    public $factorNumber = '';
    public $gashtInfo;

    public $transactions;

    public function __construct()
    {
        $this->transactions = $this->getModel('transactionsModel');
    }


    public function createExcelFile($param)
    {

        $_POST = $param;
        $resultBook = $this->bookList('yes');

        if (!empty($resultBook)) {

            // برای نام گذاری سطر اول فایل اکسل //
            $firstRowColumnsHeading = ['ردیف', 'تاریخ خرید', 'نام خریدار', 'شماره گشت یا ترانسفر', 'شهر گشت یا ترانسفر', 'نوع سرویس', 'شماره فاکتور'
                , 'عنوان گشت یا ترانسفر', 'تعداد گشت یا ترانسفر', 'سهم آژانس', 'مبلغ', 'نام مسافر', 'وضعیت'];
            $firstRowWidth = [10, 20, 15, 10, 15, 10, 20, 30, 10,10, 15,
                15,10];

            $objCreateExcelFile = Load::controller('createExcelFile');
            $resultExcel = $objCreateExcelFile->create($resultBook, $firstRowColumnsHeading , $firstRowWidth);
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
            $conditions .= " AND passenger_factor_num = '{$_POST['factor_number']}'";
        }

        if (!empty($_POST['client_id']) && TYPE_ADMIN == '1') {
            if ($_POST['client_id'] != "all") {
                $conditions .= " AND agency_id = '{$_POST['client_id']}'";
            }
        }

        if (!empty($_POST['passenger_name'])) {
            $conditions .= " AND (passenger_name LIKE '%{$_POST['passenger_name']}%' OR passenger_family LIKE '%{$_POST['passenger_name']}%')";
        }

        if (!empty($_POST['passenger_mobile'])) {
            $conditions .= " AND (passenger_mobile = '{$_POST['passenger_mobile']}')";
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
            $sql = "SELECT  rep.*, cli.AgencyName AS NameAgency, " .
                " SUM(rep.passenger_servicePriceAfterOff + rep.tax) AS totalPrice, " .
                " SUM(rep.api_commission) AS api_commission, " .
                " SUM(rep.agency_commission) AS agency_commission, " .
                " SUM(rep.irantech_commission) AS irantech_commission, " .
                " FLOOR(
                    IF(rep.price_change_type = 'none',
                       SUM(rep.passenger_servicePriceAfterOff + rep.tax),
                       IF(
                            rep.price_change_type = 'cost',
                            SUM(rep.passenger_servicePriceAfterOff + rep.tax + rep.price_change),
                            SUM(rep.passenger_servicePriceAfterOff + rep.tax +((rep.passenger_servicePriceAfterOff + rep.tax) * rep.price_change / 100))
                       )
                    )
                  ) AS totalPriceIncreased " .
                " FROM report_gasht_tb AS rep LEFT JOIN clients_tb AS cli ON cli.id = rep.agency_id " .
                " WHERE 1 = 1 " . $conditions .
                " GROUP BY rep.passenger_factor_num " .
                " ORDER BY rep.creation_date_int DESC ";
            $bookList = $ModelBase->select($sql);

        } else {

            $Model = Load::library('Model');
            $sql = "SELECT  *, " .
                " SUM(passenger_servicePriceAfterOff  + tax) AS totalPrice, " .
                " SUM(api_commission) AS api_commission, " .
                " SUM(agency_commission) AS agency_commission, " .
                " SUM(irantech_commission) AS irantech_commission, " .
                " FLOOR(
                    IF(price_change_type = 'none',
                       SUM(passenger_servicePriceAfterOff  + tax), 
                       IF(
                            price_change_type = 'cost',
                            SUM(passenger_servicePriceAfterOff  + tax + price_change),
                            SUM(passenger_servicePriceAfterOff  + tax +((passenger_servicePriceAfterOff  + tax) * price_change / 100))
                       )
                    )
                  ) AS totalPriceIncreased " .
                " FROM book_gasht_local_tb " .
                " WHERE 1 = 1 " . $conditions .
                " GROUP BY passenger_factor_num" .
                " ORDER BY creation_date_int DESC ";
            $bookList = $Model->select($sql);

        }

        $this->CountBook = count($bookList);

        $dataRows = [];
        $this->totalAgencyCommission = 0;
        $this->totalApiCommission = 0;
        $this->totalOurCommission = 0;
        $this->totalCost = 0;
        foreach ($bookList as $k => $book) {
            $numberColumn = $k + 2;

            $InfoMember = functions::infoMember($book['member_id'], $book['client_id']);
            $creation_date_int = dateTimeSetting::jdate('Y-m-d (H:i:s)', $book['creation_date_int']);

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


            $dataRows[$k]['number_column'] = $numberColumn - 1;
            $dataRows[$k]['creation_date_int'] = $creation_date_int;
            $dataRows[$k]['member_name'] = $book['member_name'];
            $dataRows[$k]['passenger_serviceId'] = $book['passenger_serviceId'];
            $dataRows[$k]['passenger_serviceCityName'] = $book['passenger_serviceCityName'];
            $dataRows[$k]['passenger_serviceRequestType_fa'] = ($book['passenger_serviceRequestType'] == 0) ? 'گشت' : 'ترانسفر';
            $dataRows[$k]['passenger_factor_num'] = $book['passenger_factor_num'];
            $dataRows[$k]['passenger_serviceName'] = $book['passenger_serviceName'];
            $dataRows[$k]['passenger_number'] = $book['passenger_number'];
            $dataRows[$k]['agency_commission'] = $book['agency_commission'] * $book['passenger_number'];
            $dataRows[$k]['passenger_servicePriceAfterOff'] = $book['passenger_servicePriceAfterOff'] * $book['passenger_number'];
            $dataRows[$k]['passenger'] = $book['passenger_name'] . ' ' . $book['passenger_family'];
            $dataRows[$k]['status_fa'] = $status;


            if (!isset($reportForExcel) || (isset($reportForExcel) && $reportForExcel == 'no')){

                $dataRows[$k]['passenger_serviceRequestType'] = $book['passenger_serviceRequestType'];
                $dataRows[$k]['is_member'] = $InfoMember['is_member'];
                $dataRows[$k]['fk_counter_type_id'] = $InfoMember['fk_counter_type_id'];
                $dataRows[$k]['member_email'] = $book['member_email'];
                $dataRows[$k]['api_commission'] = $book['api_commission'];
                $dataRows[$k]['irantech_commission'] = $book['irantech_commission'] * $book['passenger_number'];
                $dataRows[$k]['status'] = $book['status'];
                $dataRows[$k]['agency_name'] = $book['agency_name'];
                $dataRows[$k]['payment_type'] = $book['payment_type'];
                $dataRows[$k]['name_bank_port'] = $book['name_bank_port'];
                $dataRows[$k]['client_id'] = $book['client_id'];
                if ($this->numberPortBnak($book['name_bank_port'], $book['client_id']) == '379918'){
                    $dataRows[$k]['numberPortBank'] = 'درگاه ما';
                } else {
                    $dataRows[$k]['numberPortBank'] = 'درگاه خودش';
                }
                $dataRows[$k]['passenger_name'] = $book['passenger_name'];
                $dataRows[$k]['passenger_family'] = $book['passenger_family'];
                $dataRows[$k]['remote_addr'] = $book['remote_addr'];

                $this->totalAgencyCommission += $book['agency_commission'];
                $this->totalApiCommission += $book['api_commission'];
                $this->totalOurCommission += $book['irantech_commission'];
                $this->totalCost += $book['totalPriceIncreased'];

            }




        }

        //echo Load::plog($dataRows);

        return $dataRows;
    }

    public function list_hamkar()
    {
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $sql = " SELECT * FROM clients_tb ORDER BY id DESC";
        $clinet = $ModelBase->select($sql);

        return $clinet;
    }

    public function setPortBankGasht($bankDir, $factor_number)
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
        $Model->setTable('book_gasht_local_tb');

        $condition = " passenger_factor_num='{$factor_number}'";
        $res = $Model->update($data, $condition);
        if ($res) {
            $ModelBase = Load::library('ModelBase');
            $ModelBase->setTable('report_gasht_tb');
            $ModelBase->update($data, $condition);
        }
    }

    public function sendUserToBankForGasht($FactorNumber)
    {
        $data = array(
            'status' => "bank",
            'payment_type' => "cash"
        );

        $condition = " passenger_factor_num = '{$FactorNumber}' ";
        Load::autoload('Model');
        $Model = new Model();

        $Model->setTable('book_gasht_local_tb');
        $Model->update($data, $condition);

        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $ModelBase->setTable('report_gasht_tb');
        $ModelBase->update($data, $condition);
    }

    public function updateBank($codRahgiri, $factorNum)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $data = array(
            'tracking_code_bank' => $codRahgiri,
            'payment_date' => date('Y-m-d H:i:s')
        );

        $condition = " passenger_factor_num='" . $factorNum . "' AND status = 'bank' ";
        $Model->setTable('book_gasht_local_tb');
        $res = $Model->update($data, $condition);

        if ($res) {
            $ModelBase->setTable('report_gasht_tb');
            $ModelBase->update($data, $condition);
        }
    }

    public function gashtBook($factorNumber, $payType = null)
    {
        $model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $objTransaction = Load::controller('transaction');
        $passengersDetail = Load::controller('passengersDetailGasht');
        $smsController = Load::controller('smsServices');

        $factorNumber = trim($factorNumber);
        $this->factorNumber = $factorNumber;
        $book_info = $passengersDetail->getGashtInfoByFactorNumber($factorNumber);
        $this->gashtInfo = $book_info[0];

        foreach ($book_info as $item) {

            //prevent book agian in refresh of page
            if ($item['status'] != 'book') {

                $confirm_result = $this->confirmReservePlan($item);

                if ($confirm_result['status']) {

                    if ($payType != 'credit') {
                        // Caution: آپدیت تراکنش به موفق
                        $objTransaction->setCreditToSuccess($factorNumber, $item['tracking_code_bank']);
                    }

                    $data['pnr'] = $confirm_result['data'];
                    $data['status'] = 'book';
                    $data['payment_date'] = date('Y-m-d H:i:s');

                    if ($payType == 'credit') {
                        $data['payment_type'] = 'credit';
                    } elseif ($item['tracking_code_bank'] == 'member_credit') {
                        $data['payment_type'] = 'member_credit';
                        $data['tracking_code_bank'] = '';
                    } else {
                        $data['payment_type'] = 'cash';
                    }

                    $condition = " passenger_factor_num='{$factorNumber}'";
                    $model->setTable('book_gasht_local_tb');
                    $res = $model->update($data, $condition);

                    if ($res) {
                        $ModelBase->setTable('report_gasht_tb');
                        $ModelBase->update($data, $condition);
                        $this->okGasht = true;
                        $this->payment_date = $data['payment_date'];
                    }
                }


            }

            if ($this->okGasht == true) {
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


                //email to buyer
                $this->emailGashtSelf($factorNumber);

                //sms to buyer
                $objSms = $smsController->initService('0');
                if ($objSms) {
                    $mobile = $book_info[0]['passenger_mobile'];
                    $name = $book_info[0]['passenger_name'] . ' ' . $book_info[0]['passenger_family'];
                    $messageVariables = array(
                        'sms_name' => $name,
                        'sms_service' => 'گشت',
                        'sms_factor_number' => $factorNumber,
                        'sms_gasht_service_name' => $book_info[0]['passenger_serviceName'],
                        'sms_gasht_city_name' => $book_info[0]['passenger_serviceCityName'],
                        'sms_gasht_date' => $book_info[0]['passenger_serviceRequestDate'],
                        'sms_gasht_start_time' => $book_info[0]['passenger_startTime'],
                        'sms_gasht_end_time' => $book_info[0]['passenger_endTime'],
                        'sms_pdf' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=bookingGasht&id=" . $factorNumber,
                        'sms_agency' => CLIENT_NAME,
                        'sms_agency_mobile' => CLIENT_MOBILE,
                        'sms_agency_phone' => CLIENT_PHONE,
                        'sms_agency_email' => CLIENT_EMAIL,
                        'sms_agency_address' => CLIENT_ADDRESS,
                    );
                    $smsArray = array(
                        'smsMessage' => $smsController->getUsableMessage('bookedSuccessfullyGasht', $messageVariables),
                        'cellNumber' => $mobile,
                        'smsMessageTitle' => 'bookedSuccessfullyGasht',
                        'memberID' => (!empty($book_info[0]['member_id']) ? $book_info[0]['member_id'] : ''),
                        'receiverName' => $messageVariables['sms_name'],
                    );

                    $smsController->sendSMS($smsArray);
                }


            } elseif ($this->okGasht != true && $payType == 'credit') {

                $this->delete_transaction_current($factorNumber);

            }

        }
    }

    #region confirmReservePlan
    public function confirmReservePlan($record)
    {


        $explode_en_fa = explode('-', $record['passenger_entryDate']);
        $date_miladi_en = dateTimeSetting::jalali_to_gregorian($explode_en_fa[0], $explode_en_fa[1], $explode_en_fa[2], '-');
        $explode_Req_fa = explode('-', $record['passenger_serviceRequestDate']);
        $date_miladi_Req = dateTimeSetting::jalali_to_gregorian($explode_Req_fa[0], $explode_Req_fa[1], $explode_Req_fa[2], '-');
        $explode_dep_fa = explode('-', $record['passenger_departureDate']);
        $date_miladi_dep = dateTimeSetting::jalali_to_gregorian($explode_dep_fa[0], $explode_dep_fa[1], $explode_dep_fa[2], '-');
        if ($record['passenger_travelVehicle'] == 'train') {
            $trainNumber = $record['passenger_Voucher'];
        } else {
            $trainNumber = '';
        }
        if ($record['passenger_travelVehicle'] == 'airplane') {
            $flightNumber = $record['passenger_Voucher'];
        } else {
            $flightNumber = '';
        }
        $encryptData = $record['encryptData'];
        $ServiceUserInfo = array(
            'passengerName' => $record['passenger_name'] . ' ' . $record['passenger_family'],
            'passengerMobile' => $record['passenger_mobile'],
            'clientMobile' => $record['buyer_mobile'],
            'peopleNumber' => $record['passenger_number'],
            'email' => $record['passenger_email'],
            'inhabitHotelName' => $record['passenger_HotelName'],
            'inhabitHotelAddress' => $record['passenger_HotelAddress'],
            'checkIn' => date("Y/m/d", strtotime($date_miladi_en)),
            'serviceRequestDate' => date("Y/m/d", strtotime($date_miladi_Req)),
            'checkOut' => date("Y/m/d", strtotime($date_miladi_dep)),
            'travelVehicle' => $record['passenger_travelVehicle'],
            'sourceCityName' => $record['passenger_orginCity'],
            'busStartTime' => $record['passenger_startTime'],
            'busEndTime' => $record['passenger_endTime'],
            'trainNumber' => $trainNumber,
            'flightNumber' => $flightNumber,
            'listServiceOrder' => array(array(
                'serviceId' => $record['passenger_serviceId'],
                'orderNum' => $record['passenger_number'],
                'serviceName' => $record['passenger_serviceName'])
            ),
            'payType' => '',
            'submitDate' => date("Y/m/d", time()),
            'totalPrice' => '',
            'totalPriceAfterOff' => '',
            'discount' => ''
        );
        Load::autoload('apiGashtTransfer');
        $apiGashtTransfer1 = new apiGashtTransfer;
        $result = $apiGashtTransfer1->submitServiceOrder($ServiceUserInfo, $encryptData);
        return $result;

    }
    #endregion

    public function emailGashtSelf($factor_number)
    {
        $infoBook = functions::GetInfoGasht($factor_number);

        if (!empty($infoBook)) {

            /*$emailContent = '
            <tr>
                <td valign="top" class="mcnTextContent" style="padding: 18px;color: #000000;font-size: 14px;font-weight: normal;text-align: center;">
                    <h3 class="m_-2679729263370124627null" style="text-align:center;display:block;margin:0;padding:0;color:#000000;font-family:tahoma,verdana,segoe,sans-serif;font-size:22px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal">
 رزرو 
                        <span style="color:#FFFFFF"><strong>' . $infoBook['passenger_serviceName'] . '</strong></span>
به مقصد 
                        <span style="color:#FFFFFF"><strong>' . $infoBook['passenger_serviceCityName'] . '</strong></span>
                    </h3>
                    <div style="margin-top: 20px;text-align:right;color:#FFFFFF; font-family:tahoma,verdana,segoe,sans-serif">
                    با سلام <br>
دوست عزیز؛ از اینکه خدمات ما را انتخاب نموده اید سپاسگزاریم <br>
                    لطفا جهت مشاهده و چاپ واچر روی دکمه چاپ واچر گشت و ترانسفر مربوطه که در قسمت پایین قرار دارد کلیک نمایید 
                    </div>
                </td>
            </tr>
            ';

            $pdfButton = '';

                $pdfButton .= '
                <tr>
                    <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 14px;">
                        <a class="mcnButton " title="چاپ واچر گشت و ترانسفر" href="'.ROOT_ADDRESS_WITHOUT_LANG.'/pdf&target=bookingGasht&id='. $infoBook['passenger_factor_num'] . '" target="_blank" style="background-color: #284861;padding: 15px;margin:5px 0;border-radius: 10px;font-weight: bold;letter-spacing: 0px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">چاپ واچر گشت و ترانسفر '. $infoBook['passenger_name'].' '. $infoBook['passenger_family'].'</a>
                    </td>
                </tr>
                ';*/

            $emailBody = 'با سلام' . '<br>';
            $emailBody .= 'دوست عزیز؛ از اینکه خدمات ما را انتخاب نموده اید سپاسگزاریم' . '<br>';
            $emailBody .= 'لطفا جهت مشاهده و چاپ واچر روی دکمه چاپ واچر گشت و ترانسفر مربوطه که در قسمت پایین قرار دارد کلیک نمایید' . '<br>';

            $param['title'] = $infoBook['passenger_serviceCityName'];
            $param['body'] = $emailBody;
            $param['pdf'][0]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingGasht&id=' . $infoBook['passenger_factor_num'];
            $param['pdf'][0]['button_title'] = 'چاپ واچر گشت و ترانسفر';

            $to = $infoBook['passenger_email'];
            $subject = "خرید گشت و ترانسفر";
            $message = functions::emailTemplate($param);
            $headers = "From: noreply@" . CLIENT_DOMAIN . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8";
            ini_set('SMTP', 'smtphost');
            ini_set('smtp_port', 25);

            mail($to, $subject, $message, $headers);
        }
    }

    #region createPdfContent
    public function createPdfContent($uniqueCode)
    {
        $function = Load::library('functions');
        $datas = $this->getGashtInfoByFactorNumber($uniqueCode);
        foreach ($datas as $key => $data) {
            $pdfContent = '';
            if ($data['status'] == 'book') {

                $logo = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . CLIENT_LOGO;

                $pdfContent .= '
<!DOCTYPE html>
<html>
    <head>
        <title>واچر با شماره فاکتور ' . $data['passenger_factor_num'] . '</title>
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
            .bold{
            font-weight:bold;
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
                </tr>  <tr>
                    <td width="50%" align="left">Factor Numbr: ' . $data['passenger_factor_num'] . '</td>
                    <td width="50%" align="right">شماره فاکتور:' . $data['passenger_factor_num'] . ' </td>
                </tr>
            </table>
            
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="rtl">
                <tr>
                    <td width="33%"><img src="' . $logo . '" height="100" /></td>
                    <td width="34%" align="center" class="title">' . $data['passenger_serviceName'] . '</td>
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
<li>تاریخ تولد: ' . $data['passenger_birthday'] . '</li>
                        </ul>
                    </td>
                     <td width="50%" align="right">
                        <ul>
                            <li>شماره موبایل: ' . $data['passenger_mobile'] . '</li>
                            <li>ایمیل: ' . $data['passenger_email'] . '</li>
                            <li>تعداد نفرات: ' . $data['passenger_number'] . '</li>
                        </ul>
                    </td>
                </tr>
            </table>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page rtl">
                <tr>
                    <th colspan="2">اطلاعات' . ($data['passenger_serviceRequestType'] == 0 ? "گشت" : "ترانسفر") . '</th>
                </tr>
                <tr>
                    <td width="50%" align="right">
                        <ul>
                            <li>مقصد: ' . $data['passenger_serviceCityName'] . '</li>
                            <li>از ساعت: ' . $data['passenger_startTime'] . '</li>
                        </ul>
                    </td>
                     <td width="50%" align="right">
                        <ul>
                            <li>تاریخ درخواست: ' . $data['passenger_serviceRequestDate'] . '</li>
                            <li>تا ساعت: ' . $data['passenger_endTime'] . '</li>
                       
                        </ul>
                    </td>
                </tr>
            </table>
            
           <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page rtl">
                <tr>
                    <th colspan="2">اطلاعات محل اقامت</th>
                </tr>
                <tr>
                    <td width="50%" align="right">
                        <ul>
                            <li>نام هتل محل اقامت: ' . $data['passenger_HotelName'] . '</li>
                            <li>تاریخ ورود: ' . $data['passenger_entryDate'] . '</li>
                        </ul>
                    </td>
                     <td width="50%" align="right">
                        <ul>
                            <li>آدرس هتل: ' . $data['passenger_HotelAddress'] . '</li>
                            <li>تاریخ خروج: ' . $data['passenger_departureDate'] . '</li>
                       
                        </ul>
                    </td>
                </tr>
            </table>
            
            
            <p class="topFrame">  توضیحات: </p>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page rtl">
                <tr>
                    <td align="right" style="padding: 25px 15px 15px;">' . $data['passenger_serviceComment'] . ' </td>
                </tr>
            </table>
            
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page rtl">
                <tr>
                    <th width="50%">هزینه ها</th>
                    <th width="20%">تعداد</th>
                    <th width="30%">مبلغ به ریال</th>
                </tr>
                <tr>
                    <td class="borderBottomTd">مبلغ سرویس</td>
                    <td class="borderBottomTd">' . $data['passenger_number'] . '</td>
                    <td class="borderBottomTd">' . number_format(functions::setGashtPriceChanges($data['passenger_servicePrice'])) . '</td>
                </tr>
                ' . ($data['passenger_serviceDiscount'] > 0 ? '
                <tr>
                    <td class="borderBottomTd">میزان تخفیف (' . $data['passenger_serviceDiscount'] . ' درصد)</td>
                    <td class="borderBottomTd">' . $data['passenger_number'] . '</td>
                    <td class="borderBottomTd">' . (($data['passenger_servicePrice'] * $data['passenger_serviceDiscount']) / 100) . '</td>
                </tr>
                  
                
                ' : '') . '
                 <tr>
                    <td class="borderBottomTd bold">جمع کل</td>
                    <td class="borderBottomTd bold"></td>
                    <td class="borderBottomTd bold">' . number_format($data['passenger_servicePriceAfterOff'] * $data['passenger_number']) . '</td>
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
    }

    #endregion
    public function getGashtInfoByFactorNumber($factorNumber)
    {

        $Model = Load::library('Model');
        $sql = "select * from book_gasht_local_tb  WHERE  passenger_factor_num = '{$factorNumber}'";
        return $Model->select($sql);

    }

    public function delete_transaction_current($factorNumber)
    {
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

    public function checkBookStatus($factorNumber)
    {
        $Model = Load::library('Model');

        $query = "SELECT status FROM book_gasht_local_tb WHERE passenger_factor_num = '{$factorNumber}'";
        $result = $Model->load($query);

        return $result['status'] == 'book' ? true : false;
    }

    public function bookRecordsByFactorNumber($factorNumber)
    {

        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $sql = "SELECT  *, " .
                " (SELECT COUNT(id) FROM report_gasht_tb WHERE passenger_factor_num='{$factorNumber}') AS CountId, " .
                " (SELECT SUM(passenger_servicePriceAfterOff + tax) FROM report_gasht_tb WHERE passenger_factor_num='{$factorNumber}') AS totalPrice, " .
                " (SELECT FLOOR(
                            IF(price_change_type = 'none',
                               SUM(passenger_servicePriceAfterOff + tax), 
                               IF(
                                    price_change_type = 'cost',
                                    SUM(passenger_servicePriceAfterOff + tax + price_change),
                                    SUM(passenger_servicePriceAfterOff + tax +((passenger_servicePriceAfterOff + tax) * price_change / 100))
                               )
                            )
                        ) FROM report_gasht_tb WHERE passenger_factor_num='{$factorNumber}'
                  ) AS totalPriceIncreased " .
                " FROM report_gasht_tb WHERE passenger_factor_num='{$factorNumber}' ";
            $bookRecords = $ModelBase->select($sql);

        } else {

            $Model = Load::library('Model');
            $sql = "SELECT  *, " .
                " (SELECT COUNT(id) FROM book_gasht_local_tb WHERE passenger_factor_num='{$factorNumber}') AS CountId, " .
                " (SELECT SUM(passenger_servicePriceAfterOff + tax) FROM book_gasht_local_tb WHERE passenger_factor_num='{$factorNumber}') AS totalPrice, " .
                " (SELECT FLOOR(
                            IF(price_change_type = 'none',
                               SUM(passenger_servicePriceAfterOff + tax), 
                               IF(
                                    price_change_type = 'cost',
                                    SUM(passenger_servicePriceAfterOff + tax + price_change),
                                    SUM(passenger_servicePriceAfterOff + tax +((passenger_servicePriceAfterOff + tax) * price_change / 100))
                               )
                            )
                        ) FROM book_gasht_local_tb WHERE passenger_factor_num='{$factorNumber}'
                  ) AS totalPriceIncreased " .
                " FROM book_gasht_local_tb WHERE passenger_factor_num='{$factorNumber}' ";
            $bookRecords = $Model->select($sql);

        }

        return $bookRecords;
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

    public function getReportGashtAgency($agencyId)
    {
	    /** @var bookGashtLocalModel $bookGashtLocalModel */
	    $bookGashtLocalModel = Load::getModel( 'bookGashtLocalModel' );
        return $bookGashtLocalModel->getReportGashtAgency($agencyId);
    }
}