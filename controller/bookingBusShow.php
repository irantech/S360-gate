<?php

class bookingBusShow extends clientAuth
{

    #region createExcelFile
    public function createExcelFile($param)
    {
        $_POST = $param;
        $resultBook = $this->listBookBusTicket('yes');

        if (!empty($resultBook)) {

            // برای نام گذاری سطر اول فایل اکسل //
            $firstRowColumnsHeading = ['ردیف', 'تاریخ پرداخت', 'ساعت پرداخت', 'نام خریدار','شماره موبایل خریدار',
                'مبدا', 'مقصد', 'تاریخ حرکت', 'ساعت حرکت', 'شرکت مسافربری', 'اتوبوس', 'شماره فاکتور',
                'شماره بلیط', 'شماره صندلی', 'نام مسافر', 'شماره موبایل', 'سهم آژانس', 'مبلغ', 'وضعیت' , 'مبلغ کل', 'مبلغ پروایدر'];
            $firstRowWidth = [10, 15, 15, 15, 15, 10,10, 10, 10, 15,15, 15,
                15,10,15,15,15,15,10];

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
    #endrigion

    #region listBookBusTicket
    public function listBookBusTicket($reportForExcel=null, $intendedUser=null)
    {

        $date=dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode=explode('-', $date);
        $date_now_int_start=dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date_now_int_end=dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $tableName=(TYPE_ADMIN=='1') ? 'report_bus_tb' : 'book_bus_tb';

        $whereQuery='';
        if(!empty($intendedUser['member_id'])){
            $whereQuery.=' AND member_id='.$intendedUser['member_id'].' ';
        }

        if(!empty($intendedUser['agency_id'])){
            $whereQuery.=' AND agency_id='.$intendedUser['agency_id'].' ';
        }

	    if(!empty($_POST['member_id'])){
		    $whereQuery.=' AND member_id='.$_POST['member_id'].' ';
	    }

	    if(!empty($_POST['agency_id'])){
		    $whereQuery.=' AND agency_id='.$_POST['agency_id'].' ';
	    }

        $sql="
            SELECT
                *  , GROUP_CONCAT(passenger_chairs SEPARATOR ', ') AS chairs , GROUP_CONCAT(passenger_national_code SEPARATOR ', ') AS nationalCodes , GROUP_CONCAT(passenger_gender SEPARATOR ', ') AS genders 
            FROM
                {$tableName}
            WHERE
                1 = 1 
                {$whereQuery}
            ";


        if(!empty($_POST['date_of']) && !empty($_POST['to_date'])){
            $date_of=explode('-', $_POST['date_of']);
            $date_to=explode('-', $_POST['to_date']);
            $date_of_int=dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
            $date_to_int=dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            $sql.=" AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";
        }else{
            $sql.="AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";
        }

        if(!empty($_POST['status'])){
            if($_POST['status']=='book'){
                $sql.=" AND status = 'book' ";
            }else if($_POST['status']=='nothing'){
                $sql.=" AND status != 'book' ";
            }else if($_POST['status']=='temporaryReservation'){
                $sql.=" AND status = 'temporaryReservation' ";
            }
        }

        if(!empty($_POST['factor_number'])){
            $sql.=" AND passenger_factor_num = '{$_POST['factor_number']}'";
        }

        if(!empty($_POST['client_id']) && TYPE_ADMIN=='1'){
            if($_POST['client_id']!="all"){
                $sql.=" AND agency_id = '{$_POST['client_id']}'";
            }
        }

        if(!empty($_POST['passenger_name'])){
            $sql.=" AND (passenger_name LIKE '%{$_POST['passenger_name']}%' OR passenger_family LIKE '%{$_POST['passenger_name']}%')";
        }

        if(!empty($_POST['passenger_mobile'])){
            $sql.=" AND (passenger_mobile = '{$_POST['passenger_mobile']}')";
        }

        if(!empty($_POST['member_name'])){
            $sql.=" AND member_name LIKE '%{$_POST['member_name']}%'";
        }

        if(!empty($_POST['payment_type'])){
            if($_POST['payment_type']=='cash'){
                $sql.=" AND payment_type = 'cash' ";
            }elseif($_POST['payment_type']=='credit'){
                $sql.=" AND (payment_type = 'credit' OR payment_type = 'member_credit')";
            }
        }

        $get_session_sub_manage = Session::getAgencyPartnerLoginToAdmin();

        if(Session::CheckAgencyPartnerLoginToAdmin() && $get_session_sub_manage=='AgencyHasLogin'){

            $check_access = $this->getController('manageMenuAdmin')->getAccessServiceCounter(Session::getInfoCounterAdmin());
            
            $sql .= " AND serviceTitle IN ({$check_access})";
        }

        $sql.=" GROUP BY passenger_factor_num ORDER BY creation_date_int DESC ";

        if(TYPE_ADMIN=='1'){

            $ModelBase=Load::library('ModelBase');
            $bookList=$ModelBase->select($sql);

        }else{
            $Model=Load::library('Model');
            $bookList=$Model->select($sql);
        }


        $dataRows=[];
        $this->totalPrice=0;
        $this->priceForMa=0;
        $this->agencyCommissionCost=0;
        $this->agencyCommissionPercent=0;
        $this->irantechCommission=0;
        foreach($bookList as $k=>$book){

            $numberColumn=$k+2;
            $this->totalPrice+=$book['total_price'];
            $this->priceForMa+=0;
            $this->irantechCommission+=$book['irantech_commission'];

            $agencyCommission='';
            if($book['agency_commission_price_type']=='cost'){
                $agencyCommission=$book['agency_commission'];
                $this->agencyCommissionCost+=$book['agency_commission'];
            }elseif($book['agency_commission_price_type']=='percent'){
                $agencyCommission=$book['agency_commission'].' % ';
                $this->agencyCommissionPercent+=$book['agency_commission'];
            }

            $creation_date_int=dateTimeSetting::jdate('Y-m-d (H:i:s)', $book['creation_date_int']);
            $expPaymentDate=[];
            if(!empty($book['payment_date'])){
                $paymentDate=functions::set_date_payment($book['payment_date']);
                $expPaymentDate=explode(" ", $paymentDate);
            }
            if(!empty($book['member_name'])){
                $memberName=$book['member_name'];
            }else{
                $memberName='مسافرآنلاین';
            }
            switch($book['status']){
                case 'book':
                    $status='رزرو قطعی';
                    break;
                case 'temporaryReservation':
                    $status='رزرو موقت';
                    break;
                case 'prereserve':
                    $status='پیش رزرو';
                    break;
                case 'bank':
                    $status='هدایت به درگاه';
                    break;
                case 'cancel':
                    $status='کنسل';
                    break;
                case 'error':
                    $status='خطا';
                    break;
                case 'nothing':
                    $status='نامشخص';
                    break;
                default:
                    $status='نامشخص';
                    break;
            }

            if (strpos($book['WebServiceType'], 'private') === 0) {
                $service_type = 'اختصاصی';
            } elseif (strpos($book['WebServiceType'], 'public') === 0) {
                $service_type = 'اشتراکی';
            } else {
                $service_type = '<del> اشتراکی - اختصاصی</del>';
            }

            $dataRows[$k]['NumberColumn']=$numberColumn-1;
            $dataRows[$k]['PaymentDate']=$expPaymentDate[0];
            $dataRows[$k]['PaymentTime']=$expPaymentDate[1];
            $dataRows[$k]['MemberName']=$memberName;
            $dataRows[$k]['MemberMobile']=$book['member_mobile'];
            $dataRows[$k]['OriginName']=$book['OriginCity'];
            $dataRows[$k]['DestinationCity']=$book['DestinationCity'];
            $dataRows[$k]['DateMove']=$book['DateMove'];
            $dataRows[$k]['TimeMove']=$book['TimeMove'];
            $dataRows[$k]['BaseCompany']=$book['BaseCompany'];
            $dataRows[$k]['CarType']=$book['CarType'];
            $dataRows[$k]['FactorNumber']=$book['passenger_factor_num'];
            $dataRows[$k]['pnr']=$book['pnr'];
            $dataRows[$k]['PassengerChairs']=$book['passenger_chairs'];
            $dataRows[$k]['PassengerName']=$book['passenger_name'].' '.$book['passenger_family'];
            $dataRows[$k]['PassengerMobile']=$book['passenger_mobile'];
            $dataRows[$k]['AgencyCommission']=$agencyCommission;
            $dataRows[$k]['totalPrice']=$book['total_price'];
            $dataRows[$k]['StatusFa']=$status;
            $dataRows[$k]['total_price']=$book['total_price'];
            $dataRows[$k]['price_api']=$book['price_api'];
            if(!empty($book['passenger_number'])) {
                $dataRows[$k]['passenger_number'] = $book['passenger_number'];
            }else{
                $dataRows[$k]['passenger_number']= '--';
            }
            $dataRows[$k]['service_type']=$service_type;
            if(!isset($reportForExcel) || (isset($reportForExcel) && $reportForExcel=='no')){
                $dataRows[$k]['Id']=$book['id'];
                $dataRows[$k]['seen_at']=$book['seen_at'];
                $dataRows[$k]['OrderCode']=$book['order_code'];
                $dataRows[$k]['Status']=$book['status'];
                $dataRows[$k]['client_id']=$book['client_id'];
                $dataRows[$k]['ClientId']=isset($book['client_id']) ? $book['client_id'] : '';
                $dataRows[$k]['MemberId']=$book['member_id'];
                $dataRows[$k]['payment_type']=$book['payment_type'];
                $dataRows[$k]['numberPortBank']=$book['numberPortBank'];
                $dataRows[$k]['SourceName']=$book['SourceName'];
                $dataRows[$k]['AgencyName']=(TYPE_ADMIN=='1') ? functions::ClientName($book['client_id']) : null;
                $dataRows[$k]['ServicesDiscount']=$book['services_discount'];
                $dataRows[$k]['CreationDateInt']=$creation_date_int;
                $dataRows[$k]['IrantechCommission']=$book['irantech_commission'];
                $dataRows[$k]['priceForMa']='';
            }

        }

        return $dataRows;
    }
    #endrigion

    #region list_hamkar
    public function list_hamkar()
    {
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();
        $sql = " SELECT * FROM clients_tb ORDER BY id DESC";
        $result = $ModelBase->select($sql);

        return $result;
    }
    #endrigion

    #region numberPortBnak
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
    #endrigion

    #region ShowAddressClient
    public function ShowAddressClient($param)
    {
        $ModelBase = Load::library('ModelBase');
        $sql = "SELECT * FROM clients_tb WHERE id='{$param}'";
        $result = $ModelBase->load($sql);
        return $result['Domain'];
    }
    #endrigion

    #region getBookReportBusTicket
    public function getBookReportBusTicket($factorNumber)
    {
        if (TYPE_ADMIN == '1') {
            $ModelBase = Load::library('ModelBase');
//            $sql = "select * , GROUP_CONCAT(passenger_chairs SEPARATOR ', ') AS chairs , GROUP_CONCAT(passenger_national_code SEPARATOR ', ') AS nationalCodes , GROUP_CONCAT(passenger_gender SEPARATOR ', ') AS genders from report_bus_tb where passenger_factor_num = '{$factorNumber}' ";
            $sql = "select * from report_bus_tb where passenger_factor_num = '{$factorNumber}' ";
//            $resultBook = $ModelBase->load($sql);
            $resultBook = $ModelBase->select($sql);

        } else {
            $Model = Load::library('Model');
            $sql = "select *  from book_bus_tb where passenger_factor_num = '{$factorNumber}' ";
            $resultBook = $Model->select($sql);
        }

        /*$chairs = '';
        foreach ($resultBook as $val) {
            $chairs .= $val['passenger_chairs'] . ', ';
        }

        $return = $resultBook[0];
        $return['chairs'] = substr($chairs, 0, -2);*/

        return $resultBook;
    }
    #endrigion


    #region createPdfContent
    public function createPdfContent($factorNumber, $cash, $cancelStatus)
    {

        $function = Load::library('functions');
        $data = $this->getBookReportBusTicket($factorNumber);

        $pdfContent = '';
        if ($data[0]['status'] == 'book') {
            /** @var agency $agencyController */
            $agencyController = Load::controller('agency');
            $agencyInfo = $agencyController->infoAgency($data[0]['agency_id'],CLIENT_ID);
            if($agencyInfo['hasSite'])
            {
                $logo = ROOT_ADDRESS_WITHOUT_LANG . '/pic/agencyPartner/' .CLIENT_ID.'/logo/'. CLIENT_LOGO;

            }else{
                $logo = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . CLIENT_LOGO;
            }


            $pdfContent .= '
<!DOCTYPE html>
<html>
    <head>
        <title>بلیط اتوبوس با شماره فاکتور ' . $data[0]['passenger_factor_num'] . '</title>
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
//            $passenger_gender_list = $data[0]['genders'] ;
//            $passenger_gender_list = explode(',' , $passenger_gender_list  );

            $passenger_gender = [] ;
            $passenger_name = [] ;
            $passenger_family = [] ;
            $passenger_national_code = [] ;
            $passenger_chair = [] ;

            foreach ($data as $key => $passenger) {

                $passenger_gender[$key] = ($passenger['passenger_gender'] == 'Female' ? 'خانم ' : ' آقا') ;
                $passenger_name[$key] = $passenger['passenger_name'];

                $passenger_family[$key] = $passenger['passenger_family'];
                $passenger_national_code[$key] = $passenger['passenger_national_code'];
                $passenger_chair[$key] = $passenger['passenger_chairs'];


            }
            $passenger_gender = implode('-' ,$passenger_gender );
            $passenger_name = implode('-' ,$passenger_name );
            $passenger_family = implode('-' ,$passenger_family );
            $passenger_national_code = implode('-' ,$passenger_national_code );
            $passenger_chair = implode('-' ,$passenger_chair );

            $pdfContent .= '
            <p style="height: 20px;"></p>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="ltr">
                <tr>
                    <td width="50%" align="left">Date of Issue: ' . substr($data[0]['payment_date'], 0, 10) . '</td>
                    <td width="50%" align="right">' . functions::ConvertToJalali(substr($data[0]['payment_date'], 0, 10)) . ' تاریخ رزرو:</td>
                </tr>  <tr>
                    <td width="50%" align="left">Factor Number: ' . $data[0]['passenger_factor_num'] . '</td>
                    <td width="50%" align="right">شماره فاکتور:' . $data[0]['passenger_factor_num'] . ' </td>
                </tr>
            </table>
            
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="rtl">
                <tr>
                    <td width="33%"><img src="' . $logo . '" height="100" /></td>
                    <td width="34%" align="center" class="title">بلیط اتوبوس از ' . $data[0]['OriginCity'] . ' به ' . $data[0]['DestinationCity'] . '</td>
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
                            <li>نام: ' . $passenger_name . '</li>
                            <li>نام خانوادگی: ' . $passenger_family. '</li>
                            <li>کد ملی مسافران: ' . $passenger_national_code. '</li>
                            <li>جنسیت: ' . $passenger_gender . '</li>
                        </ul>
                    </td>
                     <td width="50%" align="right">
                        <ul>
                            <li>شماره موبایل: ' . $data[0]['passenger_mobile'] . '</li>
                            <li>ایمیل: ' . $data[0]['passenger_email'] . '</li>
                            <li>تعداد نفرات: ' . count($data) . '</li>
                            <li>شماره های صندلی: ' . $passenger_chair . '</li>
                        </ul>
                    </td>
                </tr>
            </table>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page rtl">
                <tr>
                    <th colspan="2">اطلاعات بلیط</th>
                </tr>
                <tr>
                    <td width="50%" align="right">
                        <ul>
                            <li>مبدا: ' . $data[0]['OriginCity'] . '</li>
                            <li>ترمینال مبدا: ' . $data[0]['OriginTerminal'] . '</li>
                            <li>تاریخ حرکت: ' . $data[0]['DateMove'] . '</li>
                            <li>کد رهگیری: ' . $data[0]['order_code'] . '</li>
                        </ul>
                    </td>
                     <td width="50%" align="right">
                        <ul>
                            <li> مقصد انتخابی: ' . $data[0]['DestinationCity'] . '</li>
                            <li> مقصد نهایی: ' . $data[0]['DestinationName'] . '</li>
                            <li>ساعت حرکت: ' . $data[0]['TimeMove'] . '</li>
                            <li>شماره بلیط: ' . $data[0]['ClientTraceNumber'] . '</li>
                            <li>شماره رفرنس : ' . $data[0]['pnr'] . '</li>
                       
                        </ul>
                    </td>
                </tr>
            </table>
            
           <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page rtl">
                <tr>
                    <th colspan="2">اطلاعات شرکت مسافربری</th>
                </tr>
                <tr>
                    <td width="50%" align="right">
                        <ul>
                            <li>' . $data[0]['CompanyName'] . '</li>
                        </ul>
                    </td>
                     <td width="50%" align="right">
                        <ul>
                            <li> ' . $data[0]['CarType'] . '</li>
                            
                        </ul>
                    </td>
                </tr>
            </table>
            
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page rtl">
                <tr>
                    <th colspan="2">اطلاعات '.CLIENT_NAME.'</th>
                </tr>
                <tr>
                    <td width="50%" align="right">
                        <span>آدرس وبسایت</span>
                    </td>
                     <td width="50%" align="right">
                        <span>' . CLIENT_MAIN_DOMAIN . '</span>
                    </td>
                </tr>
                  <tr>
                    <td width="50%" align="right">
                        <span>شماره تماس </span>
                    </td>
                     <td width="50%" align="right">
                        <span>' . CLIENT_PHONE . '</span>
                    </td>
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
                    <td class="borderBottomTd">' . $data[0]['passenger_number'] . '</td>';
            if($cash == 'no') {
                $pdfContent .= '<td class="borderBottomTd bold">cache</td>';
            }else {
                $pdfContent .= '<td class="borderBottomTd">' . number_format($data[0]['total_price']) . '</td>';
            }
            $pdfContent .= '</tr> ';

        if (!empty($discountCodeInfo) && $cash == 'no') {

            $pdfContent .= '
            <tr>
                <td class="borderBottomTd">قیمت کد تخفیف</td>
                <td class="borderBottomTd">1</td><td class="borderBottomTd">'.number_format($discountCodeInfo['amount']).'</td>
            </tr>

        ';
            $data[0]['total_price']=$data[0]['total_price'] - $discountCodeInfo['amount'];
        }

        $pdfContent .= '
                 <tr>
                    <td class="borderBottomTd bold">جمع کل</td>
                    <td class="borderBottomTd bold"></td>';
        if($cash == 'no') {
            $pdfContent .= '<td class="borderBottomTd bold">cache</td>';
        }else {
            $pdfContent .= '<td class="borderBottomTd bold">' . number_format($data[0]['total_price']) . '</td>';
        }
$pdfContent .= '</tr>
            </table>';

            if ($data[0]['request_cancel'] == 'confirm') {
                $cancelTicketDetailsModel=$this->getModel('cancelTicketDetailsModel')->get()
                    ->where('FactorNumber',$data[0]['passenger_factor_num'])
                    ->find();
                $cancel_date=dateTimeSetting::jdate('Y-m-d (H:i:s)',$cancelTicketDetailsModel['DateConfirmCancelInt'],'','','en');
                $pdfContent .= '
                <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page rtl">
                <tr>
                    <th colspan="1">اطلاعات استرداد</th>
                </tr>
                <tr>
                    <td width="100%" align="right">
                        <span>اتوبوس فوق در تاریخ '.$cancel_date.' با درصد '.number_format($cancelTicketDetailsModel['PercentIndemnity']).' و مبلغ '.number_format($cancelTicketDetailsModel['PriceIndemnity']).' ریال استرداد شده است</span>
                    </td>
                    
                </tr>
                 
            </table>
                
                ';
        }



            $pdfContent .= '
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

        } else {
            return 'خطا: رزرو با شماره فاکتور مذکور قطعی نشده است';
        }


    }



    #region busInfoTracking
    public function busInfoTracking($factorNumber)
    {
        $book = $this->getBookReportBusTicket($factorNumber);

        $result = '';
        if (!empty($book)) {

            switch ($book['status']) {
                case 'book':
                    $status = functions::Xmlinformation("Definitivereservation");
                    break;
                case 'temporaryReservation':
                    $status = functions::Xmlinformation("Temporaryreservation");
                    break;
                case 'prereserve':
                    $status = functions::Xmlinformation("Prereservation");
                    break;
                case 'bank':
                    $status = functions::Xmlinformation("NavigateToPort");
                    break;
                case 'cancel':
                    $status = functions::Xmlinformation("Cancel");
                    break;
                case 'nothing':
                    $status = functions::Xmlinformation("Unknown");
                    break;
                default:
                    $status = functions::Xmlinformation("Unknown");
                    break;
            }

            $href = ROOT_ADDRESS . "/eBusTicket&num={$book['passenger_factor_num']}";
            $href2 = ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=bookingBusShow&id={$book['passenger_factor_num']}";
            $onClick = 'onclick="ModalCancelUser('."'bus'".','.$book['order_code'].')"';
            //$op = '<a  id="myBtn" onclick="modalListForTour('."'".$book['passenger_factor_num']."'".')" class="btn btn-primary fa fa-eye margin-10" title="مشاهده رزرو"></a>';
            $op = '';
            if ($book['status'] == 'book') {
                $op .= "<a href='{$href}' class='btn btn-dropbox fa fa-print margin-10 ' target='_blank' title='".functions::Xmlinformation('See')."'></a>";
                $op .= "<a href='{$href2}' class='btn btn-info fa fa-file-pdf-o margin-10' target='_blank' title='".functions::Xmlinformation('ViewPDFReservation')."'></a>";
                if (Session::IsLogin() ) {
                $op .= "<a {$onClick} class='btn btn-danger fa fa-remove margin-10' target='_blank' title='".functions::Xmlinformation('RefundTicket')."'></a>";
                }
            }

            $result .= '
            <table class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>'.functions::Xmlinformation("Origin").'<br/>'.functions::Xmlinformation("Destination").'</th>
                    <th>'.functions::Xmlinformation("Passengercompany").'<br/>'.functions::Xmlinformation("busType").'</th>
                    <th>'.functions::Xmlinformation("Invoicenumber").'<br/>'.functions::Xmlinformation("Ticketnumber").'</th>
                    <th>'.functions::Xmlinformation("SeatNumber").'</th>
                    <th>'.functions::Xmlinformation("dateMove").'<br/>'.functions::Xmlinformation("timeMove").'</th>
                    <th>'.functions::Xmlinformation("Totalamount").'</th>
                    <th>'.functions::Xmlinformation("Status").'</th>
                    <th>'.functions::Xmlinformation("See").'</th>
                </tr>
                </thead>
                <tbody>
            ';

            $result .= '<tr>';
            $result .= '<td>' . $book['OriginCity']  . '<hr style="color: #f8f8f8;">' . $book['DestinationCity'] . '</td>';
            $result .= '<td>' . $book['CompanyName']  . '<hr style="color: #f8f8f8;">' . $book['CarType'] . '</td>';
            $result .= '<td>' . $book['passenger_factor_num']  . '<hr style="color: #f8f8f8;">' . $book['pnr'] . '</td>';
            $result .= '<td>' . $book['passenger_chairs'] . '</td>';
            $result .= '<td>' . $book['DateMove'] . '<hr style="color: #f8f8f8;">' . $book['TimeMove'] . '</td>';
            $result .= '<td>' . number_format($book['total_price']) . '</td>';
            $result .= '<td>' . $status . '</td>';
            $result .= '<td>' . $op . '</td>';
            $result .= '</tr>';
            $result .= '</table>';

            return $result;

        }

    }
    #endregion
    
    #region getCountBusBookingInStatusTemporaryReservation
    public function getCountBusBookingInStatusTemporaryReservation()
    {
        $date = dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode = explode('-', $date);
        $date_now_int_start = dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date_now_int_end = dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);

        if (TYPE_ADMIN == '1') {
            $nameTable = 'report_bus_tb';
        } else {
            $nameTable = 'book_bus_tb';
        }

        $sql = "SELECT id FROM {$nameTable} WHERE status = 'book' ";
        $sql .= " AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}' 
                    AND seen_at IS NULL ";
        $sql .= " GROUP BY passenger_factor_num ";

        if (TYPE_ADMIN == '1') {
            $ModelBase = Load::library('ModelBase');
            $resultBook = $ModelBase->select($sql);
        } else {
            $Model = Load::library('Model');
            $resultBook = $Model->select($sql);
        }
        
        return count($resultBook);

    }
    #endregion

    #region listBookBusTicket
    public function listBookBusTicketWebService($reportForExcel=null, $intendedUser=null)
    {

        $date=dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode=explode('-', $date);
        $date_now_int_start=dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date_now_int_end=dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $tableName=(TYPE_ADMIN=='1') ? 'report_bus_tb' : 'book_bus_tb';

        $whereQuery='';
        if(!empty($intendedUser['member_id'])){
            $whereQuery.=' AND member_id='.$intendedUser['member_id'].' ';
        }

        if(!empty($intendedUser['agency_id'])){
            $whereQuery.=' AND agency_id='.$intendedUser['agency_id'].' ';
        }

        if(!empty($_POST['member_id'])){
            $whereQuery.=' AND member_id='.$_POST['member_id'].' ';
        }

        if(!empty($_POST['agency_id'])){
            $whereQuery.=' AND agency_id='.$_POST['agency_id'].' ';
        }

        $sql="
            SELECT
                *  , GROUP_CONCAT(passenger_chairs SEPARATOR ', ') AS chairs , GROUP_CONCAT(passenger_national_code SEPARATOR ', ') AS nationalCodes , GROUP_CONCAT(passenger_gender SEPARATOR ', ') AS genders 
            FROM
                {$tableName}
            WHERE
                1 = 1 
                {$whereQuery}
            ";


        if(!empty($_POST['date_of']) && !empty($_POST['to_date'])){
            $date_of=explode('-', $_POST['date_of']);
            $date_to=explode('-', $_POST['to_date']);
            $date_of_int=dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
            $date_to_int=dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            $sql.=" AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";
        }else{
            $sql.="AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";
        }

        if(!empty($_POST['status'])){
            if($_POST['status']=='book'){
                $sql.=" AND status = 'book' ";
            }else if($_POST['status']=='nothing'){
                $sql.=" AND status != 'book' ";
            }else if($_POST['status']=='temporaryReservation'){
                $sql.=" AND status = 'temporaryReservation' ";
            }
        }

        if(!empty($_POST['factor_number'])){
            $sql.=" AND passenger_factor_num = '{$_POST['factor_number']}'";
        }

        $sql.=" AND client_id = '299'";

        if(!empty($_POST['passenger_name'])){
            $sql.=" AND (passenger_name LIKE '%{$_POST['passenger_name']}%' OR passenger_family LIKE '%{$_POST['passenger_name']}%')";
        }

        if(!empty($_POST['passenger_mobile'])){
            $sql.=" AND (passenger_mobile = '{$_POST['passenger_mobile']}')";
        }

        if(!empty($_POST['member_name'])){
            $sql.=" AND member_name LIKE '%{$_POST['member_name']}%'";
        }

        if(!empty($_POST['payment_type'])){
            if($_POST['payment_type']=='cash'){
                $sql.=" AND payment_type = 'cash' ";
            }elseif($_POST['payment_type']=='credit'){
                $sql.=" AND (payment_type = 'credit' OR payment_type = 'member_credit')";
            }
        }

        $get_session_sub_manage = Session::getAgencyPartnerLoginToAdmin();

        if(Session::CheckAgencyPartnerLoginToAdmin() && $get_session_sub_manage=='AgencyHasLogin'){

            $check_access = $this->getController('manageMenuAdmin')->getAccessServiceCounter(Session::getInfoCounterAdmin());

            $sql .= " AND serviceTitle IN ({$check_access})";
        }

        $sql.=" GROUP BY passenger_factor_num ORDER BY creation_date_int DESC ";

        if(TYPE_ADMIN=='1'){

            $ModelBase=Load::library('ModelBase');
            $bookList=$ModelBase->select($sql);

        }else{
            $Model=Load::library('Model');
            $bookList=$Model->select($sql);
        }


        $dataRows=[];
        $this->totalPrice=0;
        $this->priceForMa=0;
        $this->agencyCommissionCost=0;
        $this->agencyCommissionPercent=0;
        $this->irantechCommission=0;
        foreach($bookList as $k=>$book){

            $numberColumn=$k+2;
            $this->totalPrice+=$book['total_price'];
            $this->priceForMa+=0;
            $this->irantechCommission+=$book['irantech_commission'];

            $agencyCommission='';
            if($book['agency_commission_price_type']=='cost'){
                $agencyCommission=$book['agency_commission'];
                $this->agencyCommissionCost+=$book['agency_commission'];
            }elseif($book['agency_commission_price_type']=='percent'){
                $agencyCommission=$book['agency_commission'].' % ';
                $this->agencyCommissionPercent+=$book['agency_commission'];
            }

            $creation_date_int=dateTimeSetting::jdate('Y-m-d (H:i:s)', $book['creation_date_int']);
            $expPaymentDate=[];
            if(!empty($book['payment_date'])){
                $paymentDate=functions::set_date_payment($book['payment_date']);
                $expPaymentDate=explode(" ", $paymentDate);
            }
            if(!empty($book['member_name'])){
                $memberName=$book['member_name'];
            }else{
                $memberName='مسافرآنلاین';
            }
            switch($book['status']){
                case 'book':
                    $status='رزرو قطعی';
                    break;
                case 'temporaryReservation':
                    $status='رزرو موقت';
                    break;
                case 'prereserve':
                    $status='پیش رزرو';
                    break;
                case 'bank':
                    $status='هدایت به درگاه';
                    break;
                case 'cancel':
                    $status='کنسل';
                    break;
                case 'error':
                    $status='خطا';
                    break;
                case 'nothing':
                    $status='نامشخص';
                    break;
                default:
                    $status='نامشخص';
                    break;
            }


            $dataRows[$k]['NumberColumn']=$numberColumn-1;
            $dataRows[$k]['PaymentDate']=$expPaymentDate[0];
            $dataRows[$k]['PaymentTime']=$expPaymentDate[1];
            $dataRows[$k]['MemberName']=$memberName;
            $dataRows[$k]['MemberMobile']=$book['member_mobile'];
            $dataRows[$k]['OriginName']=$book['OriginCity'];
            $dataRows[$k]['DestinationCity']=$book['DestinationCity'];
            $dataRows[$k]['DateMove']=$book['DateMove'];
            $dataRows[$k]['TimeMove']=$book['TimeMove'];
            $dataRows[$k]['BaseCompany']=$book['BaseCompany'];
            $dataRows[$k]['CarType']=$book['CarType'];
            $dataRows[$k]['FactorNumber']=$book['passenger_factor_num'];
            $dataRows[$k]['pnr']=$book['pnr'];
            $dataRows[$k]['PassengerChairs']=$book['passenger_chairs'];
            $dataRows[$k]['PassengerName']=$book['passenger_name'].' '.$book['passenger_family'];
            $dataRows[$k]['PassengerMobile']=$book['passenger_mobile'];
            $dataRows[$k]['AgencyCommission']=$agencyCommission;
            $dataRows[$k]['totalPrice']=$book['total_price'];
            $dataRows[$k]['StatusFa']=$status;
            $dataRows[$k]['total_price']=$book['total_price'];
            $dataRows[$k]['price_api']=$book['price_api'];

            if(!isset($reportForExcel) || (isset($reportForExcel) && $reportForExcel=='no')){
                $dataRows[$k]['Id']=$book['id'];
                $dataRows[$k]['seen_at']=$book['seen_at'];
                $dataRows[$k]['OrderCode']=$book['order_code'];
                $dataRows[$k]['Status']=$book['status'];
                $dataRows[$k]['client_id']=$book['client_id'];
                $dataRows[$k]['ClientId']=isset($book['client_id']) ? $book['client_id'] : '';
                $dataRows[$k]['MemberId']=$book['member_id'];
                $dataRows[$k]['payment_type']=$book['payment_type'];
                $dataRows[$k]['numberPortBank']=$book['numberPortBank'];
                $dataRows[$k]['SourceName']=$book['SourceName'];
                $dataRows[$k]['AgencyName']=(TYPE_ADMIN=='1') ? functions::ClientName($book['client_id']) : null;
                $dataRows[$k]['ServicesDiscount']=$book['services_discount'];
                $dataRows[$k]['CreationDateInt']=$creation_date_int;
                $dataRows[$k]['IrantechCommission']=$book['irantech_commission'];
                $dataRows[$k]['priceForMa']='';
            }

        }

        return $dataRows;
    }
    #endrigion


}