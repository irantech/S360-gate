<?php




class bookingTrain extends newApiTrain
{
    public $okBook = '';
    public $payment_date = '';
    public $factorNumber = '';
    public $bookCount = 0;
    public $trainInfo;
    public $totalPrice = 0;

    public $transactions;

    public function __construct()
    {
        parent:: __construct();
        $this->transactions = $this->getModel('transactionsModel');
    }

    //region [bookTrainModel]
    /**
     * @return bool|mixed|bookTrainModel
     */
    public function bookTrainModel() {
        return Load::getModel('bookTrainModel');
    }
    //endregion

    /**
     * @return bool|mixed|temporaryTrainModel
     */
    public function temporaryTrainModel() {
        return Load::getModel('temporaryTrainModel');
    }

    public function updateBank($codRahgiri, $factorNum,$type=null)
    {
        functions::insertLog('type is=>'. $type .'  for factor_number=>'.$factorNum .' AND codRahgiri=>'. $codRahgiri,'checkTypeUpdateBankTrain');

        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $data = array(
            'tracking_code_bank' => $codRahgiri,
            'payment_date' => date('Y-m-d H:i:s')
        );

        $condition = " factor_number='" . $factorNum . "' AND successfull = 'bank' ";
        $Model->setTable('book_train_tb');
        $res = $Model->update($data, $condition);

        if ($res) {
            $ModelBase->setTable('report_train_tb');
            $ModelBase->update($data, $condition);
        }
    }

    public function trainBook($factorNumber, $payType = null)
    {

        functions::insertLog($factorNumber .'==>first function','checkTrainBook');
        $model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $objTransaction = Load::controller('transaction');
        $smsController = Load::controller('smsServices');

        $this->factorNumber = trim($factorNumber);
        $sql = "SELECT * FROM book_train_tb WHERE factor_number = '{$factorNumber}' GROUP BY Route_Type";
        $resultDirection = $model->select($sql);
        functions::insertLog($factorNumber .'==>after first function','checkTrainBook');
//        echo Load::plog($resultDirection);
        //prevent book agian in refresh of page
        if ($resultDirection[0]['successfull'] != 'book') {

            foreach ($resultDirection as $direction => $eachDirection) {
                $resultEachTickets = $this->bookTrainModel()->get()->where('requestNumber',$eachDirection['requestNumber'])->all();
                functions::insertLog($factorNumber .'==>after query book eachTrain function','checkTrainBook');
                $reportTicket = $this->TicketReportA($eachDirection);
                functions::insertLog($factorNumber .'==>after TicketReportA','checkTrainBook');
                if (!array_key_exists('0', $reportTicket) && !empty($reportTicket)) {
                    $reportTicket = array($reportTicket);
                }

                foreach ($resultEachTickets as $i => $currentTicket) {

                    functions::insertLog(json_encode($reportTicket),'LogTrainLastSection');
                    functions::insertLog($factorNumber .'==>after log','checkTrainBook');

                    $imageData = $reportTicket[$i]['BarcodeImage'];
                    $name = $reportTicket[$i]['TicketNumber'];

                    functions::saveQrCodeTrain($imageData, $name);
                    functions::insertLog('after saveQrCodeTrain','checkTrainBook');
                    $data['WagonNumber'] = $reportTicket[$i]['WagonNumber'];
                    $data['SeatNumber'] = $reportTicket[$i]['SeatNumber'];
                    $data['SecurityNumber'] = $reportTicket[$i]['SecurityNumber'];
                    $data['Fk_SaleCenterCode'] = $reportTicket[$i]['Fk_SaleCenterCode'];
                    $data['TicketSeries'] = $reportTicket[$i]['TicketSeries'];
                    $data['priceTicketReportA'] = $reportTicket[$i]['Formula10'];
                    $data['discountTicketReportA'] = $reportTicket[$i]['Formula12'];
                    $data['tarrifStationTicketReportA'] = $reportTicket[$i]['Formula18'];
                    $data['TrainMessage'] = $reportTicket[$i]['TrainMessage'];
                    $data['saleCenterName'] = $reportTicket[$i]['saleCenterName'];

                    if ($payType != 'credit') {
                        // Caution: آپدیت تراکنش به موفق
                        $objTransaction->setCreditToSuccess($this->factorNumber, $currentTicket['tracking_code_bank']);
                    }

                    $data['successfull'] = 'book';
                    $data['is_registered'] = '1';
                    $data['payment_date'] = date('Y-m-d H:i:s');

                    if ($payType == 'credit') {
                        $data['payment_type'] = 'credit';
                    } elseif ($currentTicket['tracking_code_bank'] == 'member_credit') {
                        $data['payment_type'] = 'member_credit';
                        $data['tracking_code_bank'] = '';
                    } else {
                        $data['payment_type'] = 'cash';
                    }


                    if ($currentTicket['passportNumber'] != '') {
                        $uniqCondition = " AND passportNumber = '{$currentTicket['passportNumber']}' ";
                    } else {
                        $uniqCondition = " AND passenger_national_code = '{$currentTicket['passenger_national_code']}' ";
                    }
                    $condition = " requestNumber='{$currentTicket['requestNumber']}'  $uniqCondition";
                    $model->setTable('book_train_tb');
                    $res = $model->update($data, $condition);

                    if ($res) {
                        $ModelBase->setTable('report_train_tb');
                        $ModelBase->update($data, $condition);
                        $this->okBook = true;
                        $this->payment_date = $data['payment_date'];
                    } else {
                        $this->okBook = false;
                        $this->payment_date = $data['payment_date'];
                    }
                }
                functions::insertLog($factorNumber .'==>after insert to db','checkTrainBook');
                if ($this->okBook == true) {
                    $this->emailTrainSelf($this->factorNumber);

                    //sms to buyer
                    $objSms = $smsController->initService('0');
                    if ($objSms) {

//                        $sms = CLIENT_NAME . '---' . 'چاپ بلیط الزامی' . '----' . ' ' . 'سریال:' . $resultDirection[$direction]['TicketNumber'] . '----' . ' ' . 'تاریخ:' . functions::ConvertToJalali($resultDirection[$direction]['MoveDate']) . '---- ' . ' ' . 'ساعت:' . $resultDirection[$direction]['ExitTime'] . '----' . ' ' . 'قطار' . $resultDirection[$direction]['TrainNumber'] . ' ' . 'سالن'.$resultDirection[$direction]['WagonNumber'].' '.' صندلی'.$resultDirection[$direction]['SeatNumber'];

                        $sms = 'مسافر گرامی'.PHP_EOL.'همراه داشتن تصویر بلیط الزامی است'.PHP_EOL.'سریال بلیط '.$resultDirection[$direction]['TicketNumber'].PHP_EOL.'تاریخ و ساعت حرکت'.
                            functions::ConvertToJalali($resultDirection[$direction]['ExitDate']).PHP_EOL. $resultDirection[$direction]['ExitTime'] .PHP_EOL.
                            'قطار' . $resultDirection[$direction]['TrainNumber'] . ' ' . 'سالن'.$reportTicket[0]['WagonNumber'].' '.' صندلی'. $reportTicket[0]['SeatNumber']
                        .PHP_EOL.CLIENT_NAME;
                        $smsArrayCounter = array(
                            'smsMessage' => $sms,
                            'cellNumber' => $resultDirection[$direction]['mobile_buyer']
                        );
                        $smsController->sendSMS($smsArrayCounter);
                        $smsArray = array(
                            'smsMessage' => $sms,
                            'cellNumber' => $resultDirection[$direction]['member_mobile']
                        );
                        $smsController->sendSMS($smsArray);
                    }

                } else {
                    $this->okBook = false;
                    $this->payment_date = $data['payment_date'];
                }
            }

            functions::insertLog($factorNumber .'==>end function','checkTrainBook');
            functions::insertLog('*************************************************','checkTrainBook');

        }

        if ($this->okBook != true && $payType == 'credit') {

            //delete success transaction if book failed
            $this->delete_transaction_current($this->factorNumber);

            //delete success credit of agency if book failed
            $this->delete_credit_Agency_current($this->factorNumber);
        }

    }

    public function emailTrainSelf($factorNumber)
    {
        $infoBook = $this->bookInfo($factorNumber);
        if (!empty($infoBook)) {

            $emailBody = 'با سلام' . '<br>';
            $emailBody .= 'دوست عزیز؛ از اینکه خدمات ما را انتخاب نموده اید سپاسگزاریم' . '<br>';
            $emailBody .= 'لطفا جهت مشاهده و چاپ بلیط روی دکمه چاپ بلیط قطار مربوطه که در قسمت پایین قرار دارد کلیک نمایید' . '<br>';

            $param['title'] = CLIENT_NAME . '---' . 'همراه داشتن تصویر بلیط الزامی است' . '----' . ' ' . 'سریال:' . $infoBook['TicketNumber'] . '----' . ' ' . 'تاریخ:' . functions::ConvertToJalali($infoBook['MoveDate']) . '---- ' . ' ' . 'ساعت:' . $infoBook['ExitTime'] . '----' . ' ' . 'قطار' . $infoBook['TrainNumber'] . ' ' . 'سالن'.$infoBook['WagonNumber'].' '.' صندلی'.$infoBook['SeatNumber'];
            $param['body'] = $emailBody;
            $param['pdf'][0]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingBusShow&id=' . $infoBook['requestNumber'];
            $param['pdf'][0]['button_title'] = 'چاپ بلیط قطار';

            $to = $infoBook['passenger_email'];
            $subject = "خرید بلیط قطار";
            $message = functions::emailTemplate($param);
            $headers = "From: noreply@" . CLIENT_DOMAIN . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8";
            ini_set('SMTP', 'smtphost');
            ini_set('smtp_port', 25);

            mail($to, $subject, $message, $headers);
        }
    }

    public function bookInfo($factorNumber)
    {

        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $sql = "SELECT  *, " .
                " (SELECT COUNT(id) FROM report_train_tb WHERE factor_number = '{$factorNumber}' AND Adult='1') AS adt_count, " .
                " (SELECT COUNT(id) FROM report_train_tb WHERE factor_number = '{$factorNumber}' AND Child='1') AS chd_count, " .
                " (SELECT COUNT(id) FROM report_train_tb WHERE factor_number = '{$factorNumber}' AND Infant='1') AS inf_count " .
                " FROM report_train_tb WHERE factor_number = '{$factorNumber}' ";
            $result = $ModelBase->load($sql);

        } else {

            $Model = Load::library('Model');
            $sql = "SELECT  *, " .
                " (SELECT COUNT(id) FROM book_train_tb WHERE factor_number = '{$factorNumber}' AND Adult='1') AS adt_count, " .
                " (SELECT COUNT(id) FROM book_train_tb WHERE factor_number = '{$factorNumber}' AND Child='1') AS chd_count, " .
                " (SELECT COUNT(id) FROM book_train_tb WHERE factor_number = '{$factorNumber}' AND Infant='1') AS inf_count " .
                " FROM book_train_tb WHERE factor_number = '{$factorNumber}' ";
            $result = $Model->load($sql);

        }

        return $result;
    }

    #region delete_transaction_current

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

    #endregion

    public function checkBookStatus($factorNumber)
    {
        $Model = Load::library('Model');

        $query = "SELECT successfull FROM book_train_tb WHERE factor_number = '{$factorNumber}'";
        $result = $Model->load($query);

        return $result['successfull'] == 'book' ? true : false;
    }

    /*public function emailTrainSelf($factor_number)
    {
        $trainInfo = $this->bookInfo($factor_number);

        if (!empty($trainInfo)) {

            $res_pdf = $this->bookRecords($factor_number);
            $count_reserve = count($res_pdf);


            foreach ($res_pdf as $k=>$each){

                $param['pdf'][$k]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingTrain&id=' . $each['ServiceCode'];
                $param['pdf'][$k]['button_title'] = 'چاپ واچر' . $each['passenger_name'] . ' '. $each['passenger_family'];

                /*$pdfButton .= '
                <tr>
                    <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 14px;">
                        <a class="mcnButton " title="چاپ واچر" href="' . ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingVisa&id=' . $each['unique_code'] . '" target="_blank" style="background-color: #284861;padding: 15px;margin:5px 0;border-radius: 10px;font-weight: bold;letter-spacing: 0px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">چاپ واچر '.$each['passenger_name'].' '.$each['passenger_family'].'</a>
                    </td>
                </tr>
                ';
            }

            $emailBody = 'با سلام' . '<br>';
            $emailBody .= 'دوست عزیز؛ از اینکه خدمات ما را انتخاب نموده اید سپاسگزاریم' . '<br>';
            $emailBody .= 'لطفا جهت مشاهده و چاپ واچر(های) قطار روی دکمه چاپ واچر مربوطه که در قسمت پایین قرار دارد کلیک نمایید' . '<br>';

            $param['title'] = 'رزرو ' . $count_reserve . ' عدد' . $trainInfo['Departure_City'] . ' به مقصد' . $trainInfo['Arrival_City'];
            $param['body'] = $emailBody;


            $to = $trainInfo['email_buyer'];
            $subject = "رزرو قطار";
            $message = functions::emailTemplate($param);
            $headers = "From: noreply@" . CLIENT_DOMAIN . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8";
            ini_set('SMTP', 'smtphost');
            ini_set('smtp_port', 25);

            mail($to, $subject, $message, $headers);
        }
    }*/

    public function delete_credit_Agency_current($factorNumber)
    {
        if (!$this->checkBookStatus($factorNumber)) {
            $Model = Load::library('Model');
            $condition = "requestNumber = '{$factorNumber}' AND requestNumber !='' AND type='decrease'";
            $Model->setTable('credit_detail_tb');
            $Model->delete($condition);
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

    public function setPortBankTrain($bankDir, $factor_number)
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
        $Model->setTable('book_train_tb');

        $condition = " factor_number='{$factor_number}'";
        $res = $Model->update($data, $condition);
        if ($res) {
            $ModelBase = Load::library('ModelBase');
            $ModelBase->setTable('report_train_tb');
            $ModelBase->update($data, $condition);
        }
    }

    public function sendUserToBankForTrain($FactorNumber)
    {
        $data = array(
            'successfull' => "bank",
            'payment_type' => "cash"
        );

        $condition = " factor_number = '{$FactorNumber}' ";
        $Model = Load::library('Model');
        $Model->setTable('book_train_tb');
        $Model->update($data, $condition);

        $ModelBase = Load::library('ModelBase');
        $ModelBase->setTable('report_train_tb');
        $ModelBase->update($data, $condition);
    }

    public function createExcelFile($param)
    {

        $_POST = $param;
        $resultBook = $this->bookList('yes');
        
        if (!empty($resultBook)) {

            // برای نام گذاری سطر اول فایل اکسل //
            $firstRowColumnsHeading = ['ردیف','تاریخ خرید','خریدار','شماره فاکتور','مبدا','مقصد','تاریخ حرکت','تاریخ پرداخت','ساعت حرکت','ساعت رسیدن','نوع قطار','شماره بلیط','نوع مسیر','کد قطار',
                'تعداد','سهم آژانس','قیمت کل','وضعیت','کد درخواست'];

            $firstRowWidth = [10, 20, 15, 20, 10, 10, 15, 20, 10,10, 20,
                15,10, 10,30, 15, 15, 15, 30];
            $objCreateExcelFile = Load::controller('createExcelFile');
            $resultExcel = $objCreateExcelFile->create($resultBook, $firstRowColumnsHeading , $firstRowWidth);
            if ($resultExcel['message'] == 'success') {
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
                $conditions .= " AND (successfull = 'nothing' OR successfull = 'prereserve' OR successfull = 'bank' OR successfull = 'book') ";
            } else if ($_POST['status'] == 'book') {
                $conditions .= " AND (successfull = 'book')";
            } else {
                $conditions .= " AND (successfull != 'book') ";
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
            $Time = Load::controller('resultTrainApi');
             $sql = "SELECT  rep.*, cli.AgencyName AS NameAgency, cli.Domain AS DomainAgency, " .
                " SUM(rep.Cost) + SUM(rep.service_price) AS totalPrice, " .
                " SUM(rep.agency_commission) AS agency_commission, " .
                " SUM(rep.irantech_commission) AS irantech_commission ," .
                " SUM( Adult ) AS AdultCount, " .
                " SUM( Child ) AS ChildCount, " .
                " SUM( Infant ) AS InfantCount " .
                " FROM report_train_tb AS rep LEFT JOIN clients_tb AS cli ON cli.id = rep.client_id " .
                " WHERE 1 = 1 " . $conditions .
                " GROUP BY rep.requestNumber " .
                " ORDER BY rep.creation_date_int DESC ";



            $bookList = $ModelBase->select($sql);
        } else {

            $Model = Load::library('Model');
            $Time = Load::controller('resultTrainApi');
             $sql = "SELECT *, SUM(Cost) + SUM(service_price) AS totalPrice, 
                 SUM(agency_commission) AS agency_commission, 
                 SUM(irantech_commission) AS irantech_commission ,
                 SUM( Adult ) AS AdultCount, 
                 SUM( Child ) AS ChildCount, 
                 SUM( Infant ) AS InfantCount
                 FROM book_train_tb 
                 WHERE 1 = 1  {$conditions}
                 GROUP BY requestNumber
                 ORDER BY creation_date_int DESC ";
            $bookList = $Model->select($sql);

        }

        $this->bookCount = count($bookList);


        $dataRows = [];
        $this->adt_qty = 0;
        $this->chd_qty = 0;
        $this->inf_qty = 0;
        $this->totalAgencyCommission = 0;
        $this->totalOurCommission = 0;
        $this->totalCost = 0;


        if(empty($bookList)){
            $bookList = array();
        }
        foreach ($bookList as $k => $book) {
            $numberColumn = $k + 2;
            if ($book['MoveDate'] != '') {
                $Time->DateJalali($book['ExitDate']);
            }
            $InfoMember = functions::infoMember($book['member_id'], $book['client_id']);
            $creation_date_int = dateTimeSetting::jdate('Y-m-d (H:i:s)', $book['creation_date_int']);
            $bookCounts = $this->bookInfo($book['factor_number']);
            $dataRows[$k]['number_column'] = $numberColumn - 1;
            $dataRows[$k]['creation_date_int'] = $creation_date_int;
            $dataRows[$k]['member_name'] = $book['member_name'];
            $dataRows[$k]['factor_number'] = $book['factor_number']. ' ' ;
            $dataRows[$k]['Departure_City'] = $book['Departure_City'];
            $dataRows[$k]['Arrival_City'] = $book['Arrival_City'];
            $dataRows[$k]['MoveDate'] = $Time->DateJalaliRequest;
            $dataRows[$k]['payment_date'] = $book['payment_date'];
//            $dataRows[$k]['agency_name'] = $book['agency_name'];
            $dataRows[$k]['ExitTime'] = $book['ExitTime'];
            $dataRows[$k]['TimeOfArrival'] = $book['TimeOfArrival'];
            $dataRows[$k]['WagonName'] = $book['WagonName'];
            $dataRows[$k]['TicketNumber'] = $book['TicketNumber'];
            $dataRows[$k]['Route_Type'] = $book['Route_Type'];

            $dataRows[$k]['TrainNumber'] = $book['TrainNumber'];
            $dataRows[$k]['count'] = $bookCounts['adt_count'] . ' بزرگسال + ' . $bookCounts['chd_count'] . ' کودک + ' . $bookCounts['inf_count'] . ' خردسال';
            $dataRows[$k]['agency_commission'] = $book['agency_commission'];

            if($book['successfull'] == 'book' && $book['TicketNumber'] > 0){
                $dataRows[$k]['dataTotalPrice']=functions::numberformat($this->TotalPriceByTicketNumberAdmin($book['TicketNumber'],$book['successfull']));
            }else{
                $dataRows[$k]['dataTotalPrice']=functions::numberformat($this->TotalPriceByTicketNumberAdmin($book['requestNumber'],'no'));
            }

            $dataRows[$k]['successfullName'] = functions::Xmlinformation(ucfirst($book['successfull']));
            $dataRows[$k]['requestNumber'] = $book['requestNumber'];

            if (!isset($reportForExcel) || (isset($reportForExcel) && $reportForExcel == 'no')) {
                $dataRows[$k]['successfull'] = $book['successfull'];
                $dataRows[$k]['id'] = $book['id'];
                $dataRows[$k]['totalPrice'] = $book['totalPrice'];
                $dataRows[$k]['passenger_family'] = $book['passenger_family'];
                $dataRows[$k]['passenger_name'] = $book['passenger_name'];
                $this->totalPrice = $book['totalPrice'];
                $dataRows[$k]['is_specific'] = $book['is_specific'];
                $dataRows[$k]['is_member'] = $InfoMember['is_member'];
                $dataRows[$k]['fk_counter_type_id'] = $InfoMember['fk_counter_type_id'];
                $dataRows[$k]['member_email'] = $book['member_email'];
                $dataRows[$k]['adt_count'] = $bookCounts['adt_count'];
                $dataRows[$k]['chd_count'] = $bookCounts['chd_count'];
                $dataRows[$k]['inf_count'] = $bookCounts['inf_count'];

                $dataRows[$k]['AdultCount'] = $book['AdultCount'];
                $dataRows[$k]['ChildCount'] = $book['ChildCount'];
                $dataRows[$k]['InfantCount'] = $book['InfantCount'];
                if ($book['successfull'] == 'book') {
                    $this->adt_qty += $bookCounts['adt_count'];
                    $this->chd_qty += $bookCounts['chd_count'];
                    $this->inf_qty += $bookCounts['inf_count'];
                    $this->totalAgencyCommission += $book['agency_commission'];
                    $this->totalOurCommission += $book['irantech_commission'];
                    $this->totalCost += $book['totalPrice'];
                }
                $dataRows[$k]['irantech_commission'] = $book['irantech_commission'];
                $dataRows[$k]['status'] = $book['successfull'];
                $dataRows[$k]['NameAgency'] = $book['NameAgency'];
                $dataRows[$k]['payment_type'] = $book['payment_type'];
                $dataRows[$k]['name_bank_port'] = $book['name_bank_port'];
                $dataRows[$k]['client_id'] = $book['agency_id'];
//                if ($this->numberPortBnak($book['name_bank_port'], $book['agency_id']) == '379918'){
//                    $dataRows[$k]['numberPortBank'] = 'درگاه ما';
//                } else {
//                    $dataRows[$k]['numberPortBank'] = 'درگاه خودش';
//                }
            }
        }

//        echo '<span style="display:none">'.$sql.'</span>';
        return $dataRows;
    }

    public function bookRecords($factorNumber)
    {

        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $sql = "SELECT * FROM report_train_tb WHERE factor_number = '{$factorNumber}' ";
            $result = $ModelBase->select($sql);

        } else {

            $Model = Load::library('Model');
            $sql = "SELECT  * FROM book_train_tb WHERE factor_number = '{$factorNumber}' ";
            $result = $Model->select($sql);

        }

        return $result;
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

//    public function numberPortBnak($bank_dir = null, $client_id)
//    {
//
//        if ($bank_dir != null && !empty($bank_dir)) {
//            if (!empty($client_id)) {
//                $admin = Load::controller('admin');
//
//                $sql = " SELECT * FROM bank_tb WHERE bank_dir='{$bank_dir}'";
//                $Bank = $admin->ConectDbClient($sql, $client_id, "Select", "", "", "");
//
//                return $Bank['param1'];
//            }
//        } else {
//            return 'ندارد';
//        }
//    }

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

    public function list_hamkar()
    {
        $ModelBase = Load::library('ModelBase');

        $sql = " SELECT * FROM clients_tb ORDER BY id DESC";
        $result = $ModelBase->select($sql);

        return $result;
    }

    #region trainInfoTracking
    public function trainInfoTracking($factor_number)
    {
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
                </tr>
                </thead>
                <tbody>
            ';

            $creation_date_int = dateTimeSetting::jdate('Y-m-d', $book['creation_date_int']);
            $prePrice = $book['visa_prepayment_cost'] * ($book['adt_count'] + $book['chd_count'] + $book['inf_count']);
            $prePrice = functions::calcDiscountCodeByFactor($prePrice, $book['factor_number']);

            if ($book['status'] == 'book') {
                $status = functions::Xmlinformation("Definitivereservation");
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
            $result .= '</tr>';
            $result .= '</table>';

            return $result;

        }

    }
    #endregion

    #region getBookByUniqueCode
    public function getBookByUniqueCode($uniqueCode)
    {
        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $sql = "SELECT * FROM report_train_tb WHERE unique_code = '{$uniqueCode}' ";
            $result = $ModelBase->load($sql);

        } else {

            $Model = Load::library('Model');
            $sql = "SELECT * FROM book_train_tb WHERE unique_code = '{$uniqueCode}' ";
            $result = $Model->load($sql);

        }

        return $result;
    }
    #endregion

    #region createPdfContent
    public function createPdfContent($factor_number)
    {

        if(TYPE_ADMIN !='1')
        {
            $Model = Load::library('Model');
            $sql = "SELECT * FROM book_train_tb WHERE factor_number = '{$factor_number}' OR requestNumber='{$factor_number}' ";
        }else{
            $Model = Load::library('ModelBase');
            $sql = "SELECT * FROM report_train_tb WHERE factor_number = '{$factor_number}' OR requestNumber='{$factor_number}' ";
        }

        $resultTicketTrain = $Model->select($sql);
//        $datasaaa = self::TicketReportA($resultTicketTrain[0]['TicketNumber']);

        $pdfContent = '';
        $pdfContent .= '<!DOCTYPE html><html>
        <head>
        <title>واچر بلیط قطار با شماره سریال ' . $resultTicketTrain[0]['TicketNumber'] . '</title>
        <style type="text/css">
            @font-face {
                font-family: "Yekan";
                font-style: normal;
                font-weight: normal;
                src: url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.woff?#iefix") format("embedded-opentype"),
                url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.woff") format("woff"),
                url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.ttf") format("truetype");
            }
            
               @font-face {
                font-family: YekanNumbers;
                font-style: normal;
                font-weight: normal;
                src: url("../view/administrator/assets/css/font/web/persian/Yekan/number.woff?#iefix") format("embedded-opentype"),
                url("../view/administrator/assets/css/font/web/persian/Yekan/number.woff") format("woff"),
                url("../view/administrator/assets/css/font/web/persian/Yekan/number.ttf") format("truetype");
            }
            .textLayer{
                background-image: url("../pic/topbilit.png");
                background-size: cover;
                background-position: top;
            }
            .bold {
            font-weight:bod;
            }
            .page {
                border-collapse: collapse;
                border: 1px solid #000;
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
                font: bold 15px/25px YekanNumbers;
            }
            .title{
                height: 120px;
                font: bold 18px/30px YekanNumbers;
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
             .border{
                border: 1px solid #000;
            }
            
            .border-bottom{
                border-bottom: 1px solid #ccc;
            }
            
              .border-bottom-image{
                background-image: url("../view/client/assets/images/bgTicketTrain.png");
                background-position: center center;
                background-size: contain;
                background-repeat: no-repeat;
            }
            #textLayer span{ font-size: 18px !important;}
            table ,tr , td ,span , div{
            
            }
         
        </style>
    </head>
    <body>';
        $i = 1;
        $Total = 0;
        $TotalWithOutDiscount = 0;
//        $array = array();
//        $rv = array_filter($datas['NewDataSet']['Table1'], 'is_array');
//        if (count($rv) > 0) {
//            $array[] = $datas['NewDataSet']['Table1'];
//        }else{
//            $array[] = $datas['NewDataSet'];
//        }

        foreach ($resultTicketTrain AS $key => $data) {

            if($data['is_specific']=='yes' && $data['serviceTitle'] =='PrivateTrain')
            {
                $message = 'این بلیط غیر قابل استرداد است';
                $styleInlineMessage ='style="padding: 20px;color:#ff0000;font-size:16px"';
            }else{
                $message = $data['TrainMessage'] ;
                $styleInlineMessage = 'style="padding: 20px"';
            }

            if($data['sex_code']=='3')
            {
                $sexCode = 'عادی';
            }else if($data['sex_code']=='2'){
                $sexCode = 'خواهران';
            }else if($data['sex_code']=='1'){
                $sexCode = 'برادران';
            }

            $creationDate = dateTimeSetting::jdate('Y-m-d H:i:s',$data['creation_date_int'],'','','en');

            if(!empty($data['passportNumber']) && !empty($data['passportExpire']) && !empty($data['passportCountry'])){
                $name = $data['passenger_name_en'] . '  ' . $data['passenger_family_en'];
            }else{
                $name = $data['passenger_name'] . '  ' . $data['passenger_family'] ;
            }
            if(($i == '5' || $i == '9' || $i == '13')){
                $pdfContent .= '<div style="page-break-after: auto; color: #FFF; opacity: 0">
                            sdfsdfsdfasddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd
                            asdsaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                            asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                            asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                            asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                            asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                            asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                            asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                            asdsaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                            asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                            asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                            asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                         
</div>';
            }
//        $data['BarcodeImage']
//       $qr = QRcode::png($data['TicketNumber'],PIC_ROOT."qrcode/".$data['TicketNumber'].".png",'L',4,4);

            $Total += (($data['priceTicketReportA'])- $data['discount_inf_price']);

            $TotalWithOutDiscount += ($data['priceTicketReportA']);


//            $Total += ($data['priceTicketReportA'] + $data['discountTicketReportA'] + $data['tarrifStationTicketReportA']);
            $moveDate = functions::DateJalali($data['ExitDate']);
            $pdfContent .= '<div class="border" style="width: 95%; margin:2px auto !important;border-radius: 5px "> 
            <table class="border"  width="80%" align="center"   cellpadding="0" cellspacing="0" class="rtl" style="font-size: 12px">
                <tr>
                    <td width="20%" align="left">' . $data['CompanyName'] . '</td>
                    <td width="60%" align="center"> سریال بلیت ' . $data['TicketNumber'] . ' ردیف ' . $i . ' کد رهگیری ' . $data['SecurityNumber'] . ' </td>
                    <td width="20%" align="right"><img src="'.functions::getCompanyTrainPhoto($data['CompanyName']).'" style="width: 35px; height: 35px;"> </td>
                </tr>

            </table>

                <img width="100%" src="' . ROOT_ADDRESS_WITHOUT_LANG . '/pic/line-full-2.png" alt=""> 
       
            <table class="border" width="100%" align="center" cellpadding="0" cellspacing="0" class="rtl" style="font-size: 12px">
                <tr>
                    <td width="33%" style="font-weight: bold;">از ایستگاه: ' . $data['Departure_City'] . '</td>
                    <td style="margin-top:-15px;position:absolute;top:-10px;font-weight: bold" width="25%"> تاریخ حرکت: ' . $moveDate . '</td>
                    <td width="20%" style="font-weight: bold;"> روز حرکت: ' . functions::nameDay($moveDate) . '</td>
                    <td style="text-align:left;font-weight: bold;" width="22%"> شماره قطار:  ' . $data['TrainNumber'] . '</td>
                </tr>
            
                <tr>
                    <td width="33%" style="font-weight:bold"> به ایستگاه: ' . $data['Arrival_City'] . '</td>
                    <td width="25%" style="font-weight:bold" > نام مسافر: </td>
                    <td width="20%" style="font-weight:bold; font-size:14px;" >  ' . $name . '</td>
                    <td style="text-align:left;font-weight:bold" width="22%">سالن: ' . $data['WagonName'] . '</td>
                </tr>
          
                <tr>
                    <td style="font-weight:bold;" width="33%" class="border-bottom"><span><img style="width:10px;" src="' . ROOT_ADDRESS_WITHOUT_LANG . '/pic/icon-ticket-train/clock.png" alt=""> ساعت حرکت از مبدا  ' . $data['ExitTime'] . ' </span> </td>
                    <td style="font-weight:bold;" width="25%" class="border-bottom"><img style="width:10px;" src="' . ROOT_ADDRESS_WITHOUT_LANG . '/pic/icon-ticket-train/train.png" alt=""> شماره سالن ' . $data['WagonNumber'] . ' </td>
                    <td style="font-weight:bold;" width="20%" class="border-bottom"><img style="width:10px;" src="' . ROOT_ADDRESS_WITHOUT_LANG . '/pic/icon-ticket-train/chair.png" alt=""> شماره صندلی ' . $data['SeatNumber'] . ' </td>
                    <td style="text-align:left;font-weight:bold;" width="22%" class="border-bottom"><img style="width:10px;" src="' . ROOT_ADDRESS_WITHOUT_LANG . '/pic/icon-ticket-train/clock.png" alt=""> ساعت ورود به مقصد ' . $data['TimeOfArrival'] . '</td>
                </tr>
            </table>
            <table  width="100%" cellpadding="0" cellspacing="0" class="rtl" style="font-size: 10px">
                <tr>
                <td>
                    <table>
                        <tr>
                            <td align="center">
                                    '. $sexCode .'
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                               <img src="' . ROOT_ADDRESS_WITHOUT_LANG . '/pic/qrcode/' . $data['TicketNumber'] . '.png" style="width: 180px" >
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                             '. $creationDate .'
                            </td>
                        </tr>
                    </table>
             
               
                </td>                
                <td valign="top" >
                    <table style="padding:0px 10px;"  width="100%" cellpadding="0" cellspacing="0" class="rtl" style="font-size:10px">
                        <tr>
                            <td width="30%"><span style="font-weight:bold"> نوع پذیرایی:</span>&nbsp;<span style="text-align: left;"> ' . $data['servicetypename'] . '</span></td>
                            <td width="40%" style="text-align:center;"><span style="font-weight:bold">بهای بلیط:</span>&nbsp;
                            <span style="text-align: left;">
                            ' . ($data['priceTicketReportA'] + $data['discountTicketReportA'] ) . '  ریال 
                            </span></td>
                            <td  width="30%" style="text-align:left;"><span style="font-weight:bold">مبلغ تخفیف:</span>&nbsp;
                            <span style="text-align: left;">
                            ' . $data['discountTicketReportA'] . '  ریال
                            </span></td>
                        </tr>
                        
                        <tr>
                            <td width="30%"><span style="font-weight:bold; font-family: Tahoma"> صادر کننده: </span>' . $data['saleCenterName'] . '(' . $data['Fk_SaleCenterCode'] . ')</td>
                            <td width="40%" style="text-align:center;"><span style="font-weight:bold"> خدمات ایستگاهی: </span>&nbsp;
                             ' . $data['tarrifStationTicketReportA'] . ' ریال 
                             </td>
                            <td width="30%" style="text-align:left;"><span style="font-weight:bold"> دریافتی از مسافر:</span>&nbsp;
                            ' . $data['priceTicketReportA'] . ' ریال 
                            </td>
                        </tr>
                        
                        <tr>
                        <td colspan="3" class="border" '. $styleInlineMessage .'>    توضیحات:  ' . $message . ' </td>
                        </tr>
                        <tr>
                        <td colspan="3"> 
                        <div>
                            1. حضور در ایستگاه یک ساعت قبل از حرکت الزامی است. ده دقیقه قبل از حرکت قطار از ورود شما به قطار جاوگیری خواهد شد 
                        </div>
                        <div>
                            2. همراه داشتن بلیت یا کارت قطار و کارت شناسایی معتبر تا انتهای سفر الزامی است.درصورت غیرهمنام بودن بلیت،از سوار شدن مسافر به قطار جلوگیری می گردد 
                        </div>
                        <div>
                            3. خانواده معظم شهدا و جانبازان عزیز(با درصد جانبازی بیش از 25)در صورت ارائه کارت بنیاد شهید و امور ایثارگران و همراه جانباز در صورت داشتن مجوز همراهی و همچنین مسافران 2 الی 12 سال،مشول 50% تخفیف می شوند و کودکان زیر 2 سال نیز در صورت درخواست جا با ارائه شناسنامه،مشمول 50% تخفیف می شوند.درصورت همراه نداشتن کارت بنیاد شهید و امور ایثارگران و یا عدم حضور مسافر مشمول تخفیف در قطار،مبلغ مابه التفاوت در هنگام کنترل بلیت توسط رئیس قطار اخذ خواهد شد. 
                        </div>
                        <div>
                            4. طبق مقررات،تا یک ساعت پس از صدور بلیت به شرط عدم حرکت قطار و مراجعه به آژانس صادرکننده،بلیت با پرداخت 100% بهای آن قابل استرداد می باشد.درصورت استرداد تا ساعت 12:00 روز قبل از حرکت ،90% کل بهای بلیت و تا 3 ساعت مانده به حرکت قطار،70% کل بهای بلیت و تا لحظه حرکت قطار،50% کل بهای بلیت به مسافر پرداخت می شود.بعد از زمان حرکت درج شده و روی بلیت،بلیت قابل استرداد نمی باشد.همراه داشتن کارت شناسایی معتبر به هنگام استرداد بلیت الزامی است. 
                        </div>
                        <div>
                            5. سامانه اطلاع رسانی و پاسخگویی به شکایات معاونت مسافری راه آهن ج.ا.ا 5149- 021 برای کلیه قطارهای مسافری و همچنین سامانه 300004609 و نیز 12-44281610- 021 جهت شرکت جوپار آماده پاسخگویی می باشد. 
                        </div>      
                        <div>
                            6. استعمال دخانیات در قطار ممنوع می باشد.جهت اطلاع از شرایط سفر با قطار و سایر قوانین و مقررات به سایت www.rai.ir مراجعه نمایی  
                        </div>
           
                             </td>
                        </tr>
                    </table>
                </td>
                </tr>
                </table>


          
        </div>';

            if(($i % 4) == 0){
                $pdfContent .= '<div style="page-break-after: auto; color: #FFF; opacity: 0">
   sdfsdfsdfasddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd
  
                         
</div>';
            }
            $i++;
        }
        if($data['discount_inf_price'] > 0) {
            $pdfContent .= '<div class="border" style="width: 95%; margin:5px auto"><table  width="100%" align="center" cellpadding="0" cellspacing="0" class="rtl"> <tr>
                            <td >  جمع کل ' . (count($resultTicketTrain)) . ' بلیط :  <span  style=" text-decoration: line-through"> ' .  $TotalWithOutDiscount . '  </span>' .  $Total . ' ریال  </td>  
                             
                            <td> ' . functions::numalpha($Total) . ' ریال</td></tr></table></div>';
        }else{
            $pdfContent .= '<div class="border" style="width: 95%; margin:5px auto"><table  width="100%" align="center" cellpadding="0" cellspacing="0" class="rtl"> <tr><td > جمع کل ' . (count($resultTicketTrain)) . ' بلیط : ' . $Total . ' ریال  </td>  
                            <td> ' . functions::numalpha($Total) . ' ریال</td></tr></table></div>';
        }
        /*if($result[1]['TicketNumber'] !=''){
            $datas = $result[1];
            $array = array();
            $rv = array_filter($datas['NewDataSet']['Table1'], 'is_array');
            if (count($rv) > 0) {
                $array[] = $datas['NewDataSet']['Table1'];
            }else{
                $array[] = $datas['NewDataSet'];
            }
            foreach ($array AS $key=>$data) {
                $Total += ($data['Formula10']+ $data['Formula12'] + $data['Formula18']);
                $bookshow->DateJalali(substr($data['MoveDate'],0,10));
                $pdfContent .= '<div class="border" style="width: 95%; margin:2px auto !important;border-radius: 5px ">
                    <table class="border"  width="100%" align="center"   cellpadding="0" cellspacing="0" class="rtl" style="font-size: 12px">
                        <tr>
                            <td class="border-bottom" width="30%" align="center">' . $data['CompanyName'] . '</td>
                            <td class="border-bottom" width="70%" align="center"> سریال بلیت '.$data['fk_serial'].' ردیف '.$i.' کد رهگیری '.$data['SecurityNumber'].' </td>
                        </tr>
                    </table>
                    <table class="border" width="100%" align="center" cellpadding="0" cellspacing="0" class="rtl" style="font-size: 12px">
                        <tr>
                            <td> از ایستگاه '.$data['startstationName'].'</td>
                            <td> تاریخ حرکت '.$bookshow->DateJalaliRequest.'</td>
                            <td> روز حرکت '.$bookshow->day.'</td>
                            <td> شماره قطار  '.$data['TrainNumber'].'</td>
                        </tr>

                        <tr>
                            <td> به ایستگاه '.$data['EndStationName'].'</td>
                            <td > نام مسافر </td>
                            <td >  '.$data['Name'].'  '.$data['Family'].'</td>
                            <td> سالن '.$data['WagonTypeName'].'</td>
                        </tr>

                        <tr>
                            <td class="border-bottom"> ساعت حرکت از مبدا  '.$data['Movetime'].'</td>
                            <td class="border-bottom"> شماره سالن '.$data['WagonNumber'].' </td>
                            <td class="border-bottom"> شماره صندلی '.$data['SeatNumber'].' </td>
                            <td class="border-bottom"> ساعت ورود به مقصد '.$data['TimeOfArrival'].'</td>
                        </tr>
                    </table>
                    <table  width="100%" cellpadding="0" cellspacing="0" class="rtl" style="font-size: 10px">
                        <tr>
                            <td></td>
                            <td> نوع پذیرایی ' . $data['servicetypename'] . '</td>
                            <td> بهای بلیط </td>
                            <td> ' . $data['Formula10'] . '  ریال</td>
                            <td> مبلغ تخفیف </td>
                            <td> ' . $data['Formula12'] . '  ریال</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td> صادر کننده  ' . $data['saleCenterName'] . '</td>
                            <td> خدمات ایستگاهی </td>
                            <td> ' . $data['Formula18'] . ' ریال </td>
                            <td> دریافتی از مسافر </td>
                            <td> ' .($data['Formula10']+ $data['Formula12'] + $data['Formula18']). ' ریال </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="5" class="border" style="padding: 2px">    توضیحات  ' .$data['TrainMessage'].' </td>
                        </tr>
                         <tr>
                            <td></td>
                            <td colspan="5">
                                <span>1. حضور در ایستگاه یک ساعت قبل از حرکت الزامی است. ده دقیقه قبل از حرکت قطار از ورود شما به قطار جاوگیری خواهد شد </span>
                                <span>2. همراه داشتن بلیت یا کارت قطار و کارت شناسایی معتبر تا انتهای سفر الزامی است.درصورت غیرهمنام بودن بلیت،از سوار شدن مسافر به قطار جلوگیری می گردد </span>
                                <span>3. خانواده معظم شهدا و جانبازان عزیز(با درصد جانبازی بیش از 25)در صورت ارائه کارت بنیاد شهید و امور ایثارگران و همراه جانباز در صورت داشتن مجوز همراهی و همچنین مسافران 2 الی 12 سال،مشول 50% تخفیف می شوند و کودکان زیر 2 سال نیز در صورت درخواست جا با ارائه شناسنامه،مشمول 50% تخفیف می شوند.درصورت همراه نداشتن کارت بنیاد شهید و امور ایثارگران و یا عدم حضور مسافر مشمول تخفیف در قطار،مبلغ مابه التفاوت در هنگام کنترل بلیت توسط رئیس قطار اخذ خواهد شد. </span>
                                <span>4. طبق مقررات،تا یک ساعت پس از صدور بلیت به شرط عدم حرکت قطار و مراجعه به آژانس صادرکننده،بلیت با پرداخت 100% بهای آن قابل استرداد می باشد.درصورت استرداد تا ساعت 12:00 روز قبل از حرکت ،90% کل بهای بلیت و تا 3 ساعت مانده به حرکت قطار،70% کل بهای بلیت و تا لحظه حرکت قطار،50% کل بهای بلیت به مسافر پرداخت می شود.بعد از زمان حرکت درج شده و روی بلیت،بلیت قابل استرداد نمی باشد.همراه داشتن کارت شناسایی معتبر به هنگام استرداد بلیت الزامی است. </span>
                                <span>5. سامانه اطلاع رسانی و پاسخگویی به شکایات معاونت مسافری راه آهن ج.ا.ا 5149- 021 برای کلیه قطارهای مسافری و همچنین سامانه 300004609 و نیز 12-44281610- 021 جهت شرکت جوپار آماده پاسخگویی می باشد. </span>
                                <span>6. استعمال دخانیات در قطار ممنوع می باشد.جهت اطلاع از شرایط سفر با قطار و سایر قوانین و مقررات به سایت www.rai.ir مراجعه نمایید  </span>
                            </td>
                        </tr>
                   </table>

                </div>';
                $i++; }

        }
                $pdfContent .= '<div class="border" style="width: 95%; margin:5px auto"><table  width="100%" align="center" cellpadding="0" cellspacing="0" class="rtl"> <tr><td > جمع کل '.($i-1).' بلیط : '.$Total.' ریال  </td>
                                    <td> '.$function->numalpha($Total).' ریال</td></tr></table></div>
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
                    </div>';*/

        $pdfContent .= '
    </body>
</html>';
        return $pdfContent;

    }

    #endregion

    public function set_date_reserve($date)
    {
        $date_orginal_exploded = explode(' ', $date);

        $date_miladi_exp = explode('-', $date_orginal_exploded[0]);

        return dateTimeSetting::gregorian_to_jalali($date_miladi_exp[0], $date_miladi_exp[1], $date_miladi_exp[2], '-');
    }


    public function DateJalali($param)
    {
        $split = explode(' ', $param);
        $explode_date = explode('-', $split[0]);
        $date_now = dateTimeSetting::gregorian_to_jalali($explode_date[0], $explode_date[1], $explode_date[2], '/');

        return isset($split[1]) ? $split[1] . ' ' . $date_now : $date_now;
    }

    public function total_price($ticketnumber, $ServiceCode)
    {
        Load::autoload('factorTrainApi');
        $Model = new factorTrainApi();

        $amount = $Model->getPassengerList($ticketnumber, $ServiceCode);
        $amount = $Model->totalPrice;

        return $amount;
    }


    public function TotalPriceByTicketNumber($ticketnumber)
    {
        $Model = Load::library('Model');
        $sql_query = "SELECT SUM(Cost) AS BaseCost , SUM(service_price) AS service_price , SUM(discount_inf_price) AS discount FROM book_train_tb WHERE TicketNumber = '{$ticketnumber}'";
        $price = $Model->load($sql_query);
        $amount = ($price['BaseCost'] + $price['service_price']) - $price['discount'];

        return $amount;
    }

    public function TotalPriceByTicketNumberAdmin($ticketnumber,$type=null)
    {
        $ModelBase = Load::library('ModelBase');
        if($type=='book'){
            $sql_query = "SELECT SUM(priceTicketReportA) AS BaseCost , SUM(service_price) AS service_price , SUM(discount_inf_price) AS discount FROM report_train_tb WHERE (TicketNumber = '{$ticketnumber}' OR requestNumber = '{$ticketnumber}')";
            $price = $ModelBase->load($sql_query);
            $amount = ($price['BaseCost']) - $price['discount'];
        }else{
            $sql_query = "SELECT SUM(Cost) AS BaseCost , SUM(service_price) AS service_price , SUM(discount_inf_price) AS discount FROM report_train_tb WHERE requestNumber = '{$ticketnumber}'";
            $price = $ModelBase->load($sql_query);
            $amount = ($price['BaseCost'] + $price['service_price']) - $price['discount'];
        }


        return $amount;
    }


    public function TotalPriceByFactorNumber($factorNumber)
    {
        $Model = Load::library('Model');
        $sql_query = "SELECT SUM(Cost) AS BaseCost , SUM(service_price) AS service_price , SUM(discount_inf_price) AS discount FROM book_train_tb WHERE factor_number = '{$factorNumber}'";
        $price = $Model->load($sql_query);

        return ($price['BaseCost'] + $price['service_price']) - $price['discount'];
    }


    public function TotalPriceByFactorNumberWithOutDiscount($factorNumber)
    {
        $Model = Load::library('Model');
        $sql_query = "SELECT SUM(Cost) AS BaseCost , SUM(service_price) AS service_price  FROM book_train_tb WHERE factor_number = '{$factorNumber}'";
        $price = $Model->load($sql_query);
        return ($price['BaseCost'] + $price['service_price']);
    }


    public function TotalPriceByRequestNumber($requestNumber,$type)
    {
        $Model = Load::library('Model');
        if($type=='book'){
            $sql_query = "SELECT SUM(priceTicketReportA) AS BaseCost , SUM(service_price) AS service_price , SUM(discount_inf_price) AS discount FROM book_train_tb WHERE requestNumber = '{$requestNumber}'";
        }else{
            $sql_query = "SELECT SUM(Cost) AS BaseCost , SUM(service_price) AS service_price , SUM(discount_inf_price) AS discount FROM book_train_tb WHERE requestNumber = '{$requestNumber}'";
        }
        $price = $Model->load($sql_query);
        $amount = ($price['BaseCost'] + $price['service_price']) - $price['discount'];

        return $amount;
    }


    public function TotalPriceByServiceCode($ServiceCode)
    {
        $Model = Load::library('Model');
        $sql_query = "SELECT SUM(Cost) AS BaseCost , SUM(service_price) AS service_price , SUM(discount_inf_price) AS discount FROM book_train_tb WHERE ServiceCode = '{$ServiceCode}'";
        $price = $Model->load($sql_query);
        $amount = $price['BaseCost'] + $price['service_price'];

        return $amount;
    }

    public function GetInfoBookWithFactorNumber($factor_number)
    {
        $data = Array();
        $result_bok_train = $this->bookTrainModel()->get()->where('factor_number',$factor_number)->groupBy('TicketNumber')->all();
        $result_temporary = $this->temporaryTrainModel()->get()->where('ServiceCode',$result_bok_train[0]['ServiceCode'])->find();
        functions::insertLog('request==>'.$factor_number.'==> GetInfoBookWithFactorNumber comes here','log_train_fateme');

        foreach ($result_bok_train AS $key => $value) {
            $data[$key]['TicketNumber'] = $value['TicketNumber'];
            $data[$key]['ServiceSessionId'] = $result_temporary['ServiceSessionId'];
            $data[$key]['requestNumber'] = $value['requestNumber'];
            $data[$key]['TrainNumber'] = $value['TrainNumber'];
            $data[$key]['MoveDate'] = $value['MoveDate'];
            $data[$key]['is_registered'] = $value['is_registered'];

        }

        return $data;
    }


    public function repeatTicket($requestNumber)
    {

        $model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $objTransaction = Load::controller('transaction');
        $admin = Load::controller('admin');

        $sql = "SELECT * FROM report_train_tb WHERE requestNumber = '{$requestNumber}'";
        $resultDirection = $ModelBase->select($sql);

//        echo Load::plog($resultDirection);
        //prevent book agian in refresh of page
        if ($resultDirection[0]['successfull'] != 'book') {
            $query = "SELECT AUTH.id, AUTH.Username
                  FROM client_auth_tb AS AUTH 
                  INNER JOIN client_source_tb AS SOURCE ON AUTH.SourceId = SOURCE.id
                  INNER JOIN client_services_tb AS SERVICE ON SOURCE.ServiceId = SERVICE.id
                  WHERE AUTH.ClientId = '{$resultDirection[0]['client_id']}' AND SERVICE.Service = 'TicketTrain' AND AUTH.IsActive='Active' ";
            $authInfo =   $ModelBase->load($query);


            $dataReport['requestNumber'] = $resultDirection[0]['requestNumber'];
            $dataReport['TicketNumber'] = $resultDirection[0]['TicketNumber'];
            $dataReport['userName'] = $authInfo['Username'];

            $reportTicket = $this->TicketReportA($dataReport);

            if (!array_key_exists('0', $reportTicket) && !empty($reportTicket)) {
                $reportTicket = array($reportTicket);
            }
            if(!isset($reportTicket['result_status']))
            {
                foreach ($resultDirection as $i => $currentTicket) {


                    functions::insertLog(json_encode($reportTicket),'LogTrainLastSection');


                    $imageData = $reportTicket[$i]['BarcodeImage'];
                    $name = $reportTicket[$i]['TicketNumber'];

                    functions::saveQrCodeTrain($imageData, $name);

                    $data['WagonNumber'] = $reportTicket[$i]['WagonNumber'];
                    $data['SeatNumber'] = $reportTicket[$i]['SeatNumber'];
                    $data['SecurityNumber'] = $reportTicket[$i]['SecurityNumber'];
                    $data['Fk_SaleCenterCode'] = $reportTicket[$i]['Fk_SaleCenterCode'];
                    $data['TicketSeries'] = $reportTicket[$i]['TicketSeries'];
                    $data['priceTicketReportA'] = $reportTicket[$i]['Formula10'];
                    $data['discountTicketReportA'] = $reportTicket[$i]['Formula12'];
                    $data['tarrifStationTicketReportA'] = $reportTicket[$i]['Formula18'];
                    $data['TrainMessage'] = $reportTicket[$i]['TrainMessage'];
                    $data['saleCenterName'] = $reportTicket[$i]['saleCenterName'];



                    $data['successfull'] = 'book';
                    $data['payment_date'] = date('Y-m-d H:i:s');

                    if ($currentTicket['passportNumber'] != '') {
                        $uniqCondition = " AND passportNumber = '{$currentTicket['passportNumber']}' ";
                    } else {
                        $uniqCondition = " AND passenger_national_code = '{$currentTicket['passenger_national_code']}' ";
                    }
                    $condition = " requestNumber='{$currentTicket['requestNumber']}'  $uniqCondition";
                    $res = $admin->ConectDbClient("", $resultDirection[0]['client_id'], "Update", $data, "book_train_tb",$condition);

                    if ($res) {
                        $ModelBase->setTable('report_train_tb');
                        $ModelBase->update($data, $condition);
                        $this->okBook = true;
                        $this->payment_date = $data['payment_date'];
                    } else {
                        $this->okBook = false;
                        $this->payment_date = $data['payment_date'];
                    }
                }

                if ($this->okBook) {
                    $objTransaction->setCreditToSuccess($currentTicket['factor_number'], $currentTicket['tracking_code_bank']);

                    return 'success';


                } else {
                    return 'error1';
                }
            }else{
                return 'error2' ;
            }


        }
    }


    public function errorTrain($dataTrain)
    {
        $model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $objTransaction = Load::controller('transaction');

                foreach ($dataTrain as $direction => $currentTicket) {
                    $sql = "SELECT * FROM report_train_tb WHERE requestNumber = '{$currentTicket['requestNumber']}'";
                    $resultDirection = $ModelBase->load($sql);

                    $data['successfull'] = 'error';
                    if ($resultDirection['passportNumber'] != '') {
                        $uniqCondition = " AND passportNumber = '{$resultDirection['passportNumber']}' ";
                    } else {
                        $uniqCondition = " AND passenger_national_code = '{$resultDirection['passenger_national_code']}' ";
                    }
                    $condition = " requestNumber='{$currentTicket['requestNumber']}'  $uniqCondition";
                    $model->setTable('book_train_tb');
                    $res = $model->update($data, $condition);
                    if($res)
                    {
                        $ModelBase->setTable('report_train_tb');
                        $ModelBase->update($data, $condition);
                    }


                    $objTransaction->setCreditToPending($resultDirection['factor_number']);
                }
    }

    public function changeFlagTrain($dataSend)
    {
        $resBase='';
        $flag='';
        if($dataSend['type'] =='preReserve'){
            $flag = 'prereserve';
        }elseif($dataSend['type'] =='credit'){
            $flag = 'credit';
        }
        $data['successfull'] = $flag;
        $this->Model->setTable('book_train_tb');
        $res =$this->Model->update($data,"factor_number='{$dataSend['factor_number']}'");
        if($res){
            $this->ModelBase->setTable('report_train_tb');
            $resBase =  $this->ModelBase->update($data,"factor_number='{$dataSend['factor_number']}'");
        }

        if($dataSend['type'] !='credit')
        {
            if($res && $resBase){
                return 'success';
            }else{
                return 'error';
            }
        }

    }

    public function buTrackingTrain($numberBuy)
    {
        $Model = Load::library('Model');
        $sql = " SELECT * FROM book_train_tb WHERE requestNumber = '{$numberBuy}' OR TicketNumber='{$numberBuy}' ";
        $book = $Model->load($sql);
        $result = '';
        if (!empty($book)) {

            $result .= '
            <table class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>'.functions::Xmlinformation("Origin").'<br/>'.functions::Xmlinformation("Destination").'</th>
                    <th>'.functions::Xmlinformation("Numberreservation").'<br/>'.functions::Xmlinformation("TicketNumber").'</th>
                    <th>'.functions::Xmlinformation("dateMove").'<br/>'.functions::Xmlinformation("timeMove").'</th>
                    <th>'.functions::Xmlinformation("Customername").'</th>
                    <th>'.functions::Xmlinformation("Amount").'</th>
                    <th>'.functions::Xmlinformation("Status").'</th>
                    <th>'.functions::Xmlinformation("Action").'</th>
                </tr>
                </thead>
                <tbody>
            ';

            if ($book['successfull'] == 'nothing') {
                $status = functions::Xmlinformation("Unknow");
            } else if ($book['successfull'] == 'PreReserve') {
                $status = functions::Xmlinformation("Prereservation");
            } else if ($book['successfull'] == 'bank') {
                $status = functions::Xmlinformation("Bank");
            } else if ($book['successfull'] == 'credit') {
                $status = functions::Xmlinformation("error");
            }else if ($book['successfull'] == 'error') {
                $status = functions::Xmlinformation("error");
            }else if ($book['successfull'] == 'book') {
                $status = functions::Xmlinformation("Definitivereservation");
            }else {
                $status = functions::Xmlinformation("Unknown");
            }

            $href = ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=bookingTrain&id={$book['requestNumber']}";

            $op = '';
            if ($book['successfull'] == 'book') {

                $op .= "<a href='{$href}' class='btn btn-info fa fa-file-pdf-o margin-10' target='_blank' title='".functions::Xmlinformation("ViewPDFReservation")."'></a>";

            }


            $result .= '<tr>';
            $result .= '<td>' . $book['Departure_City'] . '<br/>' .$book['Arrival_City']. '</td>';
            $result .= '<td>' . $book['requestNumber'] . '<br/>' . $book['TicketNumber'] . '</td>';
            $result .= '<td>' . $book['ExitDate'] . '<br/>' . $book['ExitTime'] . '</td>';
            $result .= '<td>'.$book['member_name']. '</td>';
            $result .= '<td>' . $this->TotalPriceByFactorNumber($book['factor_number']) . '</td>';
            $result .= '<td>' . $status . '</td>';
            $result .= '<td>' . $op . '</td>';
            $result .= '</tr>';
            $result .= '</table>';

            return $result;

        }
    }

    //region [getReportTrainAgency]
    public function getReportTrainAgency($agencyId) {
        return $this->bookTrainModel()->get()->where('agency_id',$agencyId)->groupBy('factor_number')->all();
    }
    //endregion



}