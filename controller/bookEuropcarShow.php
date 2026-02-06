<?php
//error_reporting(0);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

class bookEuropcarShow
{
    public $countEuropcar;
    public $totalPrice;


    public function __construct()
    {
        $this->IsLogin = Session::IsLogin();
    }



    public function createExcelFile($param)
    {

        $_POST = $param;
        $resultBook = $this->listBookEuropcarLocal('yes');
        if (!empty($resultBook)) {

            // برای نام گذاری سطر اول فایل اکسل //
            $firstRowColumnsHeading = ['ردیف', 'تاریخ خرید', 'ساعت خرید', 'نام خریدار', 'تخفیف', 'ایستگاه تحویل', 'تاریخ تحویل', 'ساعت تحویل',
                'ایستگاه بازگشت', 'تاریخ بازگشت', 'ساعت بازگشت', 'شماره فاکتور', 'نام ماشین', 'قیمت بدون تخفیف', 'قیمت کل', 'وضعیت'];

            $objCreateExcelFile = Load::controller('createExcelFile');
            $resultExcel = $objCreateExcelFile->create($resultBook, $firstRowColumnsHeading);
            if ($resultExcel['message'] == 'success'){
                return 'success|' . $resultExcel['fileName'];
            } else {
                return 'error|متاسفانه در ساخت فایل اکسل مشکلی پیش آمده. لطفا مجددا تلاش کنید';
            }


        } else {
            return 'error|اطلاعاتی برای ساخت فایل اکسسل وجود ندارد.';
        }


    }



    public function listBookEuropcarLocal($reportForExcel = null)
    {

        $date = dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode = explode('-', $date);
        $date_now_int_start = dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date_now_int_end = dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);

        if (TYPE_ADMIN == '1') {
            $sql = "SELECT * FROM report_europcar_tb  WHERE 1=1 ";
        } else {
            $sql = "SELECT * FROM book_europcar_local_tb WHERE 1=1 ";
        }
        if(Session::CheckAgencyPartnerLoginToAdmin ())
        {
            $sql .=" AND agency_id='{$_SESSION['AgencyId']}' ";
            if (!empty($_POST['CounterId'])) {
                if ($_POST['CounterId'] != "all") {
                    $sql .= " AND member_id ='{$_POST['CounterId']}'";
                }
            }
        }

        if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {

            $date_of = explode('-', $_POST['date_of']);
            $date_to = explode('-', $_POST['to_date']);
            $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
            $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        }else {
            $sql .= "AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";
        }

        if (!empty($_POST['status'])) {

            if ($_POST['status'] == 'book') {
                $sql .= " AND status='BookedSuccessfully' ";
            } else if ($_POST['status'] == 'nothing') {
                $sql .= " AND status!='BookedSuccessfully' ";
            }
        }

        if (!empty($_POST['factor_number'])) {
            $sql .= " AND factor_number ='{$_POST['factor_number']}'";
        }

        if (!empty($_POST['client_id'])) {
            if ($_POST['client_id'] != "all") {
                $sql .= " AND client_id ='{$_POST['client_id']}'";
            }
        }

        if (!empty($_POST['passenger_name'])) {
            $sql .= " AND (passenger_name LIKE '%{$_POST['passenger_name']}%' OR passenger_family LIKE '%{$_POST['passenger_name']}%')";
        }

        if (!empty($_POST['passenger_national_code'])) {
            $sql .= " AND (passenger_national_code ='{$_POST['passenger_national_code']}') ";
        }

        if (!empty($_POST['member_name'])) {
            $sql .= " AND member_name LIKE '%{$_POST['member_name']}%' ";
        }

        if (!empty($_POST['payment_type'])) {
            if ($_POST['payment_type'] == 'all') {
                $sql .= " AND (payment_type ='cash' OR payment_type ='credit') ";
            } else {
                $sql .= " AND payment_type ='{$_POST['payment_type']}' ";
            }
        }

        $sql .= " ORDER BY creation_date_int DESC ";

        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $BookShow = $ModelBase->select($sql);

        } else {
            Load::autoload('Model');
            $Model = new Model();

            $BookShow = $Model->select($sql);
        }

        $this->countEuropcar = count($BookShow);

        $objResultEuropcar = Load::controller('resultEuropcarLocal');

        $dataRows = [];
        $this->totalPrice = 0;
        foreach ($BookShow as $k => $book) {
            $numberColumn = $k + 2;

            $expPayment_date = [];
            if (!empty($book['payment_date'])){
                $payment_date = functions::set_date_payment($book['payment_date']);
                $expPayment_date = explode(" ", $payment_date);
            }

            if (!empty($book['member_name'])){
                $member_name = $book['member_name'];
            } else {
                $member_name = $book['passenger_leader_room_fullName'];
            }

            switch ($book['status']){
                case 'BookedSuccessfully':
                    $status = 'رزرو قطعی';
                    break;
                case 'PreReserve':
                    $status = 'پیش رزرو';
                    break;
                case 'TemporaryReservation':
                    $status = 'پیش رزرو (منتظر تایید یا عدم تایید سیستم یوروپ کار)';
                    break;
                case 'Cancellation':
                    $status = 'لغو درخواست';
                    break;
                case 'CancelFromEuropcar':
                    $status = 'لغو درخواست (لغو درخواست از طرف سیستم یوروپ کار)';
                    break;
                case 'NoShow':
                    $status = 'NoShow';
                    break;
                default:
                    $status = 'نامشخص';
                    break;
            }

            $objResultEuropcar->getDay($book['get_car_date_time'], $book['return_car_date_time']);

            $this->totalPrice += $book['total_price'];

            $dataRows[$k]['number_column'] = $numberColumn - 1;
            $dataRows[$k]['payment_date'] = (!empty($expPayment_date[0])) ? $expPayment_date[0] : '';
            $dataRows[$k]['payment_time'] = (!empty($expPayment_date[1])) ? $expPayment_date[1] : '';
            $dataRows[$k]['member_name'] = $member_name;
            if ($book['off_percent'] > 0){
                $dataRows[$k]['member_discount'] = $book['off_percent'] . ' % ';
            } else {
                $dataRows[$k]['member_discount'] = '';
            }
            $dataRows[$k]['source_station_name'] = $book['source_station_name'];
            $dataRows[$k]['get_car_date'] = $objResultEuropcar->getCarDate;
            $dataRows[$k]['get_car_time'] = $objResultEuropcar->getCarTime;
            $dataRows[$k]['dest_station_name'] = $book['dest_station_name'];
            $dataRows[$k]['return_car_date'] = $objResultEuropcar->returnCarDate;
            $dataRows[$k]['return_car_time'] = $objResultEuropcar->returnCarTime;
            $dataRows[$k]['factor_number'] = $book['factor_number'];
            $dataRows[$k]['car_name'] = $book['car_name'];
            if ($book['price'] != '' && $book['total_price'] != $book['price']){
                $dataRows[$k]['price'] = $book['price'];
            } else {
                $dataRows[$k]['price'] = '';
            }
            $dataRows[$k]['total_price'] = number_format($book['total_price']);
            $dataRows[$k]['status_fa'] = $status;

            if (!isset($reportForExcel) || (isset($reportForExcel) && $reportForExcel == 'no')){
                $dataRows[$k]['status'] = $book['status'];
                $dataRows[$k]['agency_name'] = $book['agency_name'];
            }

        }



        return $dataRows;

    }


    public function bookInfoTracking($factorNumber)
    {
        $Model = Load::library('Model');
        $sql = " SELECT * FROM book_europcar_local_tb WHERE factor_number = '{$factorNumber}' ";
        $book = $Model->load($sql);
        $result = '';
        if (!empty($book)) {

            $objResultEuropcar = Load::controller('resultEuropcarLocal');
            $objResultEuropcar->getDay($book['get_car_date_time'], $book['return_car_date_time']);

            $result .= '
            <table class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>'.functions::Xmlinformation("Deliverystation").'</th>
                    <th>'.functions::Xmlinformation("Deliverydate").'<br/>'.functions::Xmlinformation("Timedelivery").'</th>
                    <th>'.functions::Xmlinformation("Stationreturned").'</th>
                    <th>'.functions::Xmlinformation("Returndate").'<br/>'.functions::Xmlinformation("ClockBack").'</th>
                    <th>'.functions::Xmlinformation("Buydate").'<br> '.functions::Xmlinformation("Buytime").'</th>
                    <th>'.functions::Xmlinformation("Customername").'</th>
                    <th>'.functions::Xmlinformation("Invoicenumber").'</th>
                    <th>'.functions::Xmlinformation("CarName").'</th>
                    <th>'.functions::Xmlinformation("TotalPrice").'</th>
                    <th>'.functions::Xmlinformation("Status").'</th>
                    <th>'.functions::Xmlinformation("Action").'</th>
                </tr>
                </thead>
                <tbody>
            ';

            if ($book['status'] == 'BookedSuccessfully') {
                $status = functions::Xmlinformation("Definitivereservation");
            } else if ($book['status'] == 'PreReserve') {
                $status = functions::Xmlinformation("Prereservation");
            } else if ($book['status'] == 'bank') {
                $status = functions::Xmlinformation("Action");
            } else if ($book['status'] == 'TemporaryReservation') {
                $status = functions::Xmlinformation("Prereservation"). ' ('.functions::Xmlinformation("WaitingConfirmationDisapprovalEuropcarSystem").')';
            }else if ($book['status'] == 'Cancellation') {
                $status = functions::Xmlinformation("Cancelrequest");
            }else if ($book['status'] == 'CancelFromEuropcar') {
                $status = functions::Xmlinformation("CancelRequestByEuropcar");
            }else if ($book['status'] == 'NoShow') {
                $status = 'NoShow';
            }else {
                $status = functions::Xmlinformation("Unknown");
            }

            $href = ROOT_ADDRESS . "/eEuropcarLocal&num={$book['factor_number']}";
            $href2 = ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=BookingEuropcarLocal&id={$book['factor_number']}";

            $op = '';
            if ($book['status'] == 'BookedSuccessfully' || $book['status'] == 'TemporaryReservation') {
                $op .= "<a href='{$href}' class='btn btn-dropbox fa fa-print margin-10 ' target='_blank' title='".functions::Xmlinformation("Printreservation")."'></a>";
                $op .= "<a href='{$href2}' class='btn btn-info fa fa-file-pdf-o margin-10' target='_blank' title='".functions::Xmlinformation("ViewPDFReservation")."'></a>";

            }


            $result .= '<tr>';
            $result .= '<td>' . $book['source_station_name'] . '</td>';
            $result .= '<td>' . $objResultEuropcar->getCarDate . '<br/>' . $objResultEuropcar->getCarTime . '</td>';
            $result .= '<td>' . $book['dest_station_name'] . '</td>';
            $result .= '<td>' . $objResultEuropcar->returnCarDate . '<br/>' . $objResultEuropcar->returnCarTime . '</td>';
            $result .= '<td>' . functions::set_date_payment($book['payment_date']) . '</td>';
            $result .= '<td>';
            if ($book['member_name'] != ''){
                $result .= $book['member_name'];
            } else {
                $result .= $book['passenger_leader_room_fullName'];
            }
            $result .= '</td>';
            $result .= '<td>' . $book['factor_number'] . '</td>';
            $result .= '<td>' . $book['car_name'] . '</td>';
            $result .= '<td>';
            if ($book['price'] != '' && $book['total_price'] != $book['price']){
                $result .= number_format($book['price']);
            }
            $result .= '<br/>' . number_format($book['total_price']);
            $result .= '</td>';

            $result .= '<td>' . $status . '</td>';
            $result .= '<td>' . $op . '</td>';
            $result .= '</tr>';
            $result .= '</table>';

            return $result;

        }

    }



}

?>
