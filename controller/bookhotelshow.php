<?php
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
class bookhotelshow extends baseController
{

    public $CountHotel = '';
    public $count = '';
    public $FactorNumber = '';
    public $totalPriceWithoutDiscount;
    public $totalPrice;
    public $total_price_api;
    public $price;
    public $priceForMa;
    public $agencyCommissionCost;
    public $agencyCommissionPercent;
    public $IsLogin;


    public function __construct()
    {
        $this->IsLogin = Session::IsLogin();
    }

    public function set_date_reserve($date)
    {
        $date_orginal_exploded = explode(' ', $date);
        $date_miladi_exp = explode('-', $date_orginal_exploded[0]);
        return dateTimeSetting::gregorian_to_jalali($date_miladi_exp[0], $date_miladi_exp[1], $date_miladi_exp[2], '-');
    }

    public function set_time_payment($date)
    {
        $date_orginal_exploded = explode(' ', $date);
        return $date_orginal_exploded[1];
    }

    public function list_hamkar()
    {
        $ModelBase = Load::library('ModelBase');
        $sql = " SELECT * FROM clients_tb ORDER BY id DESC";
        $result = $ModelBase->select($sql);
        return $result;
    }
	
	/**
	 * @param $AgencyId
	 *
	 * @return array
	 */
	public function listCounter($AgencyId)
    {
        $Model =  Load::library('Model');
        $sql = " SELECT * FROM members_tb WHERE fk_agency_id='{$AgencyId}' ORDER BY id DESC";
        $counters = $Model->select($sql);
        return $counters;
    }
	
	/**
	 * @param $client_id
	 *
	 * @return string
	 */
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
	
	/**
	 * @param null $bank_dir
	 * @param $client_id
	 *
	 * @return string
	 */
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
	
	/**
	 * @param null $bank_dir
	 * @param $client_id
	 *
	 * @return string
	 */
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

    public function format_hour($num)
    {

        $time = date("H:i", strtotime($num));
        return $time;
    }
	
	public function checkForExpired() {
		$time = strtotime('-10 minutes');
		$time2 = strtotime('-1 day');
//		return $time2;
		$condition = "admin_checked = 0 AND status = 'OnRequest' AND creation_date_int >= '{$time2}' AND creation_date_int  <= '{$time}'";
		$data['status'] = 'Cancelled';
		$sqlSelect = "SELECT id,client_id FROM report_hotel_tb WHERE {$condition}";
//		return $time2;
		
		/** @var ModelBase $ModelBase */
		$ModelBase = Load::library('ModelBase');
		$ModelBase->setTable('report_hotel_tb');
		/** @var Model $Model */
		$Model = Load::library('Model');
		$expiredBook = $ModelBase->select($sqlSelect);
		if($expiredBook){
            /** @var admin $admin */
			$admin = Load::controller('admin');
			
			$updateAgency = $admin->ConectDbClient('', $expiredBook[0]['client_id'], 'Update', $data, 'book_hotel_local_tb', $condition);
			
			$updateAdmin = $ModelBase->update($data,$condition);
			if($updateAgency && $updateAdmin){
                return 'Success1|'.$sqlSelect;
            }
            return 'Success2|'.$sqlSelect;
		}
		return 'Error|'.$sqlSelect;
    }
    
    public function createExcelFile($param)
    {

        $_POST = $param;
        $resultBook = $this->listBookHotelLocal('yes');
        if (!empty($resultBook)) {

            // برای نام گذاری سطر اول فایل اکسل //
            $firstRowColumnsHeading = [
                'ردیف',
                'فرم درخواست',
                'شماره فاکتور',
                'شماره درخواست',
                'نام خریدار',
                'شماره موبایل خریدار',
                'تاریخ خرید',
                'ساعت خرید',
                'شهر',
                'هتل',
                'تاریخ ورود',
                'تاریخ خروج',
                'مدت اقامت',
                'تعداد اتاق',
                'نام اتاق (ها)',
                'قیمت کل وب سرویس',
                'قیمت کل',
                'سهم آژانس',
                'قیمت',
                'سهم کارگزار',
                'نوع هتل',
                'خرید از نرم افزار',
                'وضعیت'];


            $firstRowWidth = [10, 10, 20, 30, 15, 15, 15, 15,10, 15,15, 15,
                10,10, 40,15, 15, 15, 15, 15, 20, 15, 10];

	        /** @var createExcelFile $objCreateExcelFile */
	        $objCreateExcelFile = Load::controller('createExcelFile');
            $resultExcel        = $objCreateExcelFile->create($resultBook, $firstRowColumnsHeading , $firstRowWidth);
            if ($resultExcel['message'] == 'success'){
                return 'success|' . $resultExcel['fileName'];
            } else {
                return 'error|متاسفانه در ساخت فایل اکسل مشکلی پیش آمده. لطفا مجددا تلاش کنید';
            }


        } else {
            return 'error|اطلاعاتی برای ساخت فایل اکسسل وجود ندارد.';
        }


    }



    public function listBookHotelLocal($reportForExcel = null, $intendedUser=null)
    {

        $date = dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode = explode('-', $date);
        $date_now_int_start = dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date_now_int_end = dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);

        if(TYPE_ADMIN == '1'){
            $tableName ='report_hotel_tb';
            $FiledExtera='';
        }
        else{
            $tableName ='book_hotel_local_tb';
            $FiledExtera="agency_id,creation_date_int";
        }

        //$tableName = (TYPE_ADMIN == '1') ? 'report_hotel_tb' : 'book_hotel_local_tb';
        $sql = "
            SELECT
                   id,
                city_name,
                hotel_id,
                hotel_name,
                payment_date,
                agency_name,
                number_night,
                start_date,
                end_date,
                factor_number,
                type_application,
                passenger_leader_room_fullName,
                `status`,
                request_number,
                pnr,
                payment_type,
                tracking_code_bank,
                total_price,
                total_price_api,
                client_id,
                member_name,
                passenger_leader_room_fullName,
                member_mobile,
                member_id,
                agency_commission,
                type_of_price_change,
                agency_commission_price_type,
                irantech_commission,
                services_discount,
                serviceTitle,
                request_from,
                manual_book,
                hotel_payments_price
                {$FiledExtera}
            FROM
                {$tableName}
            WHERE
                1 = 1 
            ";


        /*if(Session::CheckAgencyPartnerLoginToAdmin())
        {
            $sql .=" AND agency_id='{$_SESSION['AgencyId']}' ";
            if (!empty($_POST['CounterId'])) {
                if ($_POST['CounterId'] != "all") {
                    $sql .= " AND member_id ='{$_POST['CounterId']}'";
                }
            }
        }*/

        if(!empty($intendedUser['member_id'])){
            $sql.=' AND member_id='.$intendedUser['member_id'].' ';
        }

        if(!empty($intendedUser['agency_id'])){
            $sql.=' AND agency_id='.$intendedUser['agency_id'].' ';
        }
        if(!empty($_POST['member_id'])){
            $sql.=' AND member_id='.$_POST['member_id'].' ';
        }
        if(!empty($_POST['hotel_id'])){
            $sql.=' AND hotel_id='.$_POST['hotel_id'].' ';
        }
        if(!empty($_POST['agency_id'])){
            $sql.=' AND agency_id='.$_POST['agency_id'].' ';
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
        if (!empty($_POST['reserve_date_of']) && !empty($_POST['reserve_to_date'])) {
                $sql .= " AND start_date >= '{$_POST['reserve_date_of']}'";
                $sql .= " AND end_date  <= '{$_POST['reserve_to_date']}'";
        }
        if (!empty($_POST['status'])) {

            if ($_POST['status'] == 'book') {
                $sql .= " AND status='BookedSuccessfully' ";
            } else if ($_POST['status'] == 'nothing') {
                $sql .= " AND status!='BookedSuccessfully' ";
            }
        }

        if (!empty($_POST['type_app'])) {

            if ($_POST['type_app'] == 'api') {
                $sql .= " AND type_application='api' ";
            } else if ($_POST['type_app'] == 'reservation') {
                $sql .= " AND type_application='reservation' ";
            }else if ($_POST['type_app'] == 'externalApi') {
                $sql .= " AND type_application='externalApi' ";
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
            $sql .= " AND (passenger_name LIKE '%{$_POST['passenger_name']}%' 
                    OR passenger_family LIKE '%{$_POST['passenger_name']}%')";
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

        if (!empty($_POST['StartDate'])) {
            $sql .= " AND Start_date ='{$_POST['StartDate']}'";

        }

        if (!empty($_POST['EndDate'])) {
            $sql .= " AND end_date ='{$_POST['EndDate']}'";

        }

        $get_session_sub_manage = Session::getAgencyPartnerLoginToAdmin();

        if(Session::CheckAgencyPartnerLoginToAdmin() && $get_session_sub_manage=='AgencyHasLogin'){

            $check_access = $this->getController('manageMenuAdmin')->getAccessServiceCounter(Session::getInfoCounterAdmin());

            $sql .= " AND serviceTitle IN ({$check_access})";
        }
        $sql .= " GROUP BY factor_number ORDER BY creation_date_int DESC ";

        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $BookShow = $ModelBase->select($sql);

        } else {

            $Model = Load::library('Model');
            $BookShow = $Model->select($sql);
        }

        $this->CountHotel = count($BookShow);


        $dataRows = [];
        $this->totalPriceWithoutDiscount = 0;
        $this->totalPrice = 0;
        $this->total_price_api = 0;
        $this->price = 0;
        $this->priceForMa = 0;
        $this->agencyCommissionCost = 0;
        $this->agencyCommissionPercent = 0;
        foreach ($BookShow as $k => $book) {
            $numberColumn = $k + 2;

            $expPaymentDate = [];
            if (!empty($book['payment_date'])){

                $paymentDate = functions::set_date_payment($book['payment_date']);

                $expPaymentDate = explode(" ", $paymentDate);
                
            }

            if (!empty(rtrim($book['member_name']))){
                $memberName = $book['member_name'];
            } else {
                $memberName = $book['passenger_leader_room_fullName'];
            }
            
            switch ($book['type_application']){
                case 'reservation':
                    $type_application = 'هتل رزرواسیون';
                    break;
                case 'api':
                    $type_application = ($book['serviceTitle'] == 'PrivateLocalHotel') ? 'هتل اختصاصی داخلی' : 'هتل اشتراکی داخلی';
	                break;
                case 'externalApi':
                    $type_application = ($book['serviceTitle'] == 'PrivatePortalHotel') ? 'هتل اختصاصی خارجی' : 'هتل اشتراکی خارجی';
                    break;
                case 'reservation_app':
                    $type_application = 'هتل رزرواسیون (خرید از اَپلیکیشن)';
                    break;
                case 'api_app':
                    $type_application = 'هتل اشتراکی داخلی (خرید از اَپلیکیشن)';
                    break;
                default:
                    $type_application = '';
                    break;
            }

            if (strpos($book['serviceTitle'], 'Private') === 0) {
                $service_type = 'اختصاصی';
            } elseif (strpos($book['serviceTitle'], 'Public') === 0) {
                $service_type = 'اشتراکی';
            } else {
                $service_type = '<del> اشتراکی - اختصاصی</del>';
            }
            

            switch ($book['status']){
                case 'BookedSuccessfully':
                    $status = 'رزرو قطعی';
                    break;
                case 'PreReserve':
                    $status = 'پیش رزرو';
                    break;
                case 'Cancelled':
                    $status = 'لغو درخواست';
                    break;
                default:
                    $status = 'نامشخص';
                    break;
            }

            $this->totalPrice = 0;
            $room = $this->InformationOfEachReservation($book['factor_number']);

            $this->totalPriceWithoutDiscount += $room['totalPriceWithoutDiscount'];
            $this->totalPrice += $room['totalPrice'];
            $this->price += $room['price'];

            if($book['type_application'] == 'externalApi' || ($book['type_application'] == 'api' && substr($book['hotel_id'], 0,2) == '17')){
                $this->totalPrice = $room['totalPrice'];
                $this->price = $room['price'];
            }
            $this->priceForMa += $room['priceForMa'];
            $agencyCommission = '';
            if ($book['agency_commission_price_type'] == 'cost') {
                $agencyCommission =  number_format($room['agencyCommission'] * $room['nights']);
                $this->agencyCommissionCost += $agencyCommission;
            }
            if ($book['agency_commission_price_type'] == 'percent'){
//                $agencyCommission = $room['agencyCommission'] . ' % ';
                $agencyCommission = number_format( $room['onlinePrice'] * $room['agencyCommission'] / 100);

                $this->agencyCommissionPercent += $room['agencyCommission'];
                $agencyCommission .= ' - <small class="badge badge-xs badge-inverse"> '.$room['agencyCommission'].'% </small>';
            }

//            $agencyCommission .= '<code style="display:none">'.json_encode(array('book'=>$book,'room'=>$room),256|64).'</code>';


            $dataRows[$k]['number_column'] = $numberColumn - 1;
            if (!isset($reportForExcel) || (isset($reportForExcel) && $reportForExcel == 'no')) {
                $dataRows[$k]['hotel_id'] = $book['hotel_id'];
            }
            $dataRows[$k]['request_from'] = $book['request_from'];
            $dataRows[$k]['factor_number'] = $book['factor_number'] . ' ';
            $dataRows[$k]['request_number'] = $book['request_number'];
            $dataRows[$k]['pnr'] = $book['pnr'];
            $dataRows[$k]['agency_id'] = $book['agency_id'] . ' ';
            $dataRows[$k]['creation_date_int'] = $book['creation_date_int'] . ' ';

            $dataRows[$k]['member_name'] = $memberName;
            $dataRows[$k]['member_mobile'] = $book['member_mobile'];
            $dataRows[$k]['payment_date'] = $expPaymentDate[0];
            $dataRows[$k]['payment_time'] = $expPaymentDate[1];
            $dataRows[$k]['city_name'] = $book['city_name'];
            $dataRows[$k]['hotel_name'] = $book['hotel_name'];
            $dataRows[$k]['start_date'] = $book['start_date'];
            $dataRows[$k]['end_date'] = $book['end_date'];
            $dataRows[$k]['number_night'] = $book['number_night'];
            $dataRows[$k]['room_count'] = $room['roomCount'];
            $dataRows[$k]['room_excel'] = str_replace("&nbsp;", "", $room['room']);


            $dataRows[$k]['total_price_api'] =$book['total_price_api'];
            $dataRows[$k]['service_type'] = $service_type;
            $dataRows[$k]['total_price'] = $this->totalPrice;

            $dataRows[$k]['agency_commission'] = 0;
            $dataRows[$k]['price'] = 0;
            $dataRows[$k]['onlinePrice'] = 0;
            if ($book['type_application'] == 'api' || $book['type_application'] == 'api_app' || $book['type_application'] == 'externalApi'){
                $dataRows[$k]['agency_commission'] = $agencyCommission;
                $dataRows[$k]['price'] = $room['price'];
                $dataRows[$k]['onlinePrice'] = $room['onlinePrice'];
            }

            $dataRows[$k]['type_application_fa'] = $type_application;
            $dataRows[$k]['manual_book'] = $book['manual_book'];
            $dataRows[$k]['status_fa'] = $status;




            if (!isset($reportForExcel) || (isset($reportForExcel) && $reportForExcel == 'no')){
                $dataRows[$k]['hotel_payments_price'] = $book['hotel_payments_price'];
                $dataRows[$k]['total_price_without_discount'] = $room['totalPriceWithoutDiscount'];
                $dataRows[$k]['priceForMa'] = $room['priceForMa'];
                $dataRows[$k]['id'] = $book['id'];
                $dataRows[$k]['client_id'] = $book['client_id'];
                $dataRows[$k]['member_id'] = $book['member_id'];
                $dataRows[$k]['agency_name'] = $book['agency_name'];
                $dataRows[$k]['type_application'] = $book['type_application'];
                $dataRows[$k]['status'] = $book['status'];
                $dataRows[$k]['room'] = $room['room'];
                $dataRows[$k]['irantech_commission'] = $book['irantech_commission'];
                $dataRows[$k]['services_discount'] = $book['services_discount'];

            }




        }


        return $dataRows;

    }

    public function InformationOfEachReservation($factorNumber)
    {
        if (TYPE_ADMIN == '1') {
            $ModelBase = Load::library('ModelBase');
            $sql = "SELECT *, SUM(room_price) as total_room_price,
                          SUM(room_bord_price) as total_room_bord_price,
                          SUM(room_online_price) as total_room_online_price,
                          SUM(agency_commission) as total_agency_commission
                    FROM report_hotel_tb WHERE factor_number='{$factorNumber}' GROUP BY room_id ";
            $book = $ModelBase->select($sql);
        } else{
            Load::autoload('Model');
            $Model = new Model();
            $sql = "SELECT *,
                          SUM(room_price) as total_room_price,
                          SUM(room_bord_price) as total_room_bord_price,
                          SUM(room_online_price) as total_room_online_price,
                          SUM(agency_commission) as total_agency_commission
                    FROM book_hotel_local_tb WHERE factor_number='{$factorNumber}' GROUP BY room_id ";
            $book = $Model->select($sql);
        }

        $room = ''; $price = 0; $bordPrice = 0; $markup = 0; $roomCount = 0; $onlinePrice = 0; $irantech_commission = 0;
        foreach ($book as $k => $val){

            $room .= '◄' . $val['room_count'] . ' باب  ' . $val['room_name'] . '&nbsp;&nbsp;&nbsp;&nbsp;';
            $roomCount += $val['room_count'];

            $price = $price + $val['total_room_price'];
            $bordPrice = $bordPrice + $val['total_room_bord_price'];
            $onlinePrice = $val['total_room_online_price'];
            $markup = $markup + $val['total_agency_commission'];
	        $irantech_commission = $val['irantech_commission'];
	        if($val['type_application'] == 'externalApi'){
		        $price = $val['room_price'];
		        $onlinePrice = $val['room_online_price'];
		        $totalPriceWithoutDiscount = $val['room_bord_price'];
		        $irantech_commission = $irantech_commission + $val['irantech_commission'];
		
		        //            $resultRoom['agencyCommission'] = $book[0]['total_agency_commission'];
	        }
        }

        $resultRoom['room'] = htmlspecialchars_decode($room);
        $resultRoom['roomCount'] = $roomCount;
        /*$resultRoom['priceForMa'] = $onlinePrice - $price;*/
        $resultRoom['priceForMa'] = 0;
        $resultRoom['totalPrice'] = $book[0]['total_price'];
        $resultRoom['total_price_api'] = $book[0]['total_price_api'];
        $resultRoom['agencyCommission'] = $markup;
        $resultRoom['price'] = $price;
        $resultRoom['nights'] = $book[0]['number_night'];
        $resultRoom['onlinePrice'] = $onlinePrice;
        $resultRoom['irantech_commission'] = $irantech_commission;
        $resultRoom['totalPriceWithoutDiscount'] = $totalPriceWithoutDiscount;
       
        return $resultRoom;
    }

    public function hotelWishList()
    {
        $date = dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode = explode('-', $date);
        $date_now_int_start = dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date_now_int_end = dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date = date("Y-m-d");

        if (TYPE_ADMIN == '1') {
            $nameTable = 'report_hotel_tb';
        } else {
            $nameTable = 'book_hotel_local_tb';
        }

        /*$sql = "SELECT
                          city_name, hotel_id , hotel_name, payment_date,
                          number_night, start_date, end_date, factor_number, client_id,
                          passenger_leader_room_fullName, `status`, request_number, pnr,
                          payment_date, payment_type, tracking_code_bank, total_price, member_id,
                          status_confirm_hotel, type_application
                    FROM {$nameTable} 
                    WHERE 1=1
                    ";*/
        $sql = "SELECT
                          *
                    FROM {$nameTable} 
                    WHERE 
                      (type_application = 'reservation' 
                      OR type_application = 'api'
                      OR type_application = 'reservation_app'
                      OR type_application = 'api_app')
                    ";

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

            if ($_POST['status'] == 'OnRequest') {
                $sql .= " AND status='OnRequest' ";
            } else if ($_POST['status'] == 'Cancelled') {
                $sql .= " AND status='Cancelled' ";
            }else if ($_POST['status'] == 'PreReserve') {
                $sql .= " AND status='PreReserve' ";
            }
        }else {
            $sql .=" AND (`status`='OnRequest' OR `status`='Cancelled' OR `status`='PreReserve') ";
        }

        if (!empty($_POST['factor_number'])) {
            $sql .= " AND factor_number ='{$_POST['factor_number']}'";
        }

        $sql .= " GROUP BY factor_number ORDER BY creation_date_int DESC ";

        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $BookShow = $ModelBase->select($sql);

        } else {
            $Model = Load::library('Model');
            $BookShow = $Model->select($sql);
        }
        

        $this->CountHotel = count($BookShow);
        return $BookShow;
    }

    public function getUserType($id)
    {
        $Model = Load::library('Model');
        $sql_members = "SELECT fk_counter_type_id, name, family FROM members_tb WHERE id='{$id}' ";
        $members = $Model->Load($sql_members);

        if (!empty($members['fk_counter_type_id'])){

            $ModelBase = Load::library('ModelBase');
            $sql_counter_type = "SELECT name FROM counter_type_tb WHERE id='{$members['fk_counter_type_id']}' ";
            $counter_type = $ModelBase->Load($sql_counter_type);

            return $counter_type['name'] . ' ( ' . $members['name'] . ' ' . $members['family'] . ')';

        }else {
            return 'مسافرآنلاین';
        }


    }

    public function ShowAddressClient($param)
    {

        $ModelBase = Load::library('ModelBase');

        $sql = "SELECT * FROM clients_tb WHERE id='{$param}'";
        $result = $ModelBase->load($sql);
        return $result['Domain'];
    }

    public function info_hotel_client($factorNumber)
    {
        if (TYPE_ADMIN == '1') {
            $ModelBase = Load::library('ModelBase');

            $sql = "select *,"
                . " (SELECT COUNT(id) FROM report_hotel_tb WHERE factor_number='$factorNumber') AS CountId "
                . " from report_hotel_tb  where factor_number='$factorNumber'  ";
            $result = $ModelBase->select($sql);
        } else {
            Load::autoload('Model');
            $Model = new Model();

            $sql = "select *,"
                . " (SELECT COUNT(id) FROM book_hotel_local_tb WHERE factor_number='$factorNumber') AS CountId "
                . " from book_hotel_local_tb  where factor_number='$factorNumber' ";
            $result = $Model->select($sql);
        }

        $this->count = count($result);
        return $result;
    }

    //مشاهده رزرو هتل انگلیسی
    public function createPdfContentOld($param)
    {
        if (TYPE_ADMIN == '1') {
            $ModelBase = Load::library('ModelBase');

            $sql = "SELECT * FROM report_hotel_tb WHERE factor_number='$param' AND status='BookedSuccessfully' ";
            $info_hotel = $ModelBase->select($sql);

        } else {

            $Model = Load::library('Model');

            $sql = "SELECT * FROM book_hotel_local_tb WHERE factor_number='$param' AND status='BookedSuccessfully' ";
            $info_hotel = $Model->select($sql);
        }

        $printBoxCheck = '';

        if (!empty($info_hotel)) {


            $printBoxCheck .='';

            $printBoxCheck .= ' <!DOCTYPE html>
            <html>
                <head>
                    <title>View hotel file pdf</title>
                </head>
                <body>';
            $printBoxCheck .='<div style="margin:30px auto 0;background-color: #fff;line-height: 24px; direction: ltr;font-family: sans-serif;">
                        <div style="margin:30px auto 0;background-color: #fff;">
            <div style="position: relative;font-size: 18px;margin: 10px auto;color: #171717;text-align: center;padding: 0 15px;background: #fff;width: 91%; ">
            	<span style="background: #fff;position: relative;z-index: 1;padding: 0 15px;font-weight: bold;">Hotel voucher</span>
            </div>
            ';
            $c = 0;
            $room_index = 0;
            $passenger_number = 1;
            foreach ($info_hotel as $info) {

                if ($c==0){
                    $c++;

                    $printBoxCheck .= '
        	        <div style="border: 1px solid #132f3b;margin: 5px 40px 5px 40px;">
                	<div class="row" style="padding: 10px;font-weight: bold;background-color: #132f3b;margin: 0;color: #fff;">';

                    $payDate = functions::set_date_payment($info['payment_date']);
                    $payDate = explode(' ', $payDate);
                    $printBoxCheck .= '
                        <div style="width: 50%;position: relative;float: left;min-height: 1px;padding-left: .9375rem;box-sizing: border-box;">
                            <span style="font-weight: bold;">Booking date : </span><span>';
                    $printBoxCheck .= functions::ConvertToMiladi($payDate[0]);
                    $printBoxCheck .='</span>
                        </div>
                    </div>

                    <div class="row" style="padding: 8px;margin: 0;">
                        <div style="width: 65%;float: left;position: relative;min-height: 1px;padding-left: .9375rem;der-box;">
                            <span style="font-weight: bold;">Hotel Name : </span><span>';
                    $printBoxCheck .= !empty($info['hotel_name_en']) ? $info['hotel_name_en']: $info['hotel_name'];
                    $printBoxCheck .= '</span>' .
                        '<span style="font-weight: bold;">Check-in : </span><span style="font: normal 12px/28px Yekan,Tahoma, Geneva, sans-serif;">';
                    $printBoxCheck .= functions::ConvertToMiladi($info['start_date']);
                    $printBoxCheck .='</span>';
//                    $printBoxCheck .= $info['hotel_entryHour'];

                    $printBoxCheck .='<br><span style="font-weight: bold;">Check-out : </span><span style="font: normal 12px/28px Yekan,Tahoma, Geneva, sans-serif;">';
                    $printBoxCheck .= functions::ConvertToMiladi($info['end_date']);
//                    $printBoxCheck .='</span><span style="">  until : </span><span>';
//                    $printBoxCheck .= $info['hotel_leaveHour'];

                    $printBoxCheck .='</span>';

                    $printBoxCheck .='<br><span style="font-weight: bold;">Hotel Star : </span><span>';
                    $printBoxCheck .= $info['hotel_starCode'];
                    $printBoxCheck .='</span>';
                    $printBoxCheck .='<br><span style="font-weight: bold;">Telephone : </span><span>';
                    $printBoxCheck .= $info['hotel_telNumber'];
                    $printBoxCheck .='</span>';
                    $printBoxCheck .='<br><span style="padding-left: 1rem;font-weight: bold; direction: ltr; text-align: right;">Address : </span><span>';
                    $printBoxCheck .= !empty($info['hotel_address_en']) ? $info['hotel_address_en']  : $info['hotel_address'];
                    if (!empty($info['hotel_location'])) {
//                        $t = '24.8583526611,67.0242004395';
                            $lat_lng = json_decode($info['hotel_location'],true);
                            $lat = $lat_lng['latitude'];
                            $lng = $lat_lng['longitude'];
                            $link = "https://www.google.com/maps/@$lat,$lng,16z";
                        $printBoxCheck .= '<br><span style="font-weight: bold">GPS Coordinate :</span> '.implode(array_values($lat_lng));
                        $printBoxCheck .= '<br><a target="_blank" href="'.$link.'">View on map</a>';
                    }
                    $printBoxCheck .='</span>';
                    $printBoxCheck .='</div>';
                    $printBoxCheck .='<div style="width: 30%;float: left;position: relative;min-height: 1px;padding-left: .9375rem;box-sizing: border-box;">' .
                    '<div style="padding: 4px;overflow: hidden;border: 1px solid #eee; border-radius: 2px;"><img alt="'.($info['hotel_pictures']).'" style="max-width: 100%" src="'.($info['hotel_pictures']).'" /></div>' .
                    '</div>';
                    $printBoxCheck .='</div>';
                    $printBoxCheck .='</div>';
                    $printBoxCheck .='<div style="border: 1px solid #132f3b;margin: 15px 40px 15px 40px;">
                      <div class="row" style="padding: 8px;margin: 0;font: inherit;vertical-align: baseline;">
                          <div class="col-md-12 modal-text-center modal-h"
                              style="text-align: right;font-size: 18px !important;width: 100%;font-weight: bold;">
                                        <h3>Room Details</h3>
                                        <hr>
                          </div>
                      </div> ';

                }

                if ($info['type_application']=='reservation'){

                    if ($info['flat_type']=='DBL'){
                        $flatType = 'تخت اصلی';

                    }elseif ($info['flat_type']=='EXT'){
                        $flatType = 'تخت اضافه بزرگسال';

                    }elseif ($info['flat_type']=='ECHD'){
                        $flatType = 'تخت اضافه کودک';
                    }


                    $printBoxCheck .='
                   <div class="row" style="padding: 8px;margin: 0;">
                        <div style="width: 16.666667%;float: left;position: relative;min-height: 1px;padding-left: .9375rem;padding-left: .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">Room : </span><span>';
                        $printBoxCheck .= $info['room_name_en'];
                        $printBoxCheck .='</span>
                        </div>
                        <div style="width: 16.666667%;float: left;position: relative;min-height: 1px;padding-left: .9375rem;padding-left: .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">Bed : </span><span>';
                        $printBoxCheck .= $flatType;
                        $printBoxCheck .='</span>
                        </div>
                        <div style="width: 16.666667%;float: left;position: relative;min-height: 1px;padding-left: .9375rem;padding-left: .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">Full name : </span><span>';
                        $printBoxCheck .= $info['passenger_name'].' '.$info['passenger_family'];
                        $printBoxCheck .='</span>
                        </div>
                        <div style="width: 16.666667%;float: left;position: relative;min-height: 1px;padding-left: .9375rem;padding-left: .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">National code / Passport: </span><span>';
                        if ($info['passenger_national_code']!=""){
                            $printBoxCheck .= $info['passenger_national_code'];
                        }else{
                            $printBoxCheck .= $info['passportNumber'];
                        }
                        $printBoxCheck .='</span>
                        </div>
                        <div style="width: 16.666667%;float: left;position: relative;min-height: 1px;padding-left: .9375rem;padding-left: .9375rem;box-sizing: border-box;"><span style="font-weight: bold;">Date of birth: </span><span>';

                        if ($info['passenger_birthday']!=""){
                            $printBoxCheck .= $info['passenger_birthday'];
                        }else{
                            $printBoxCheck .= $info['passenger_birthday_en'];
                        }

                        $printBoxCheck .='</span>
                        </div>
                    </div>';


                }else{

                    $printBoxCheck .='
                   <div class="row" style="padding: 8px;margin: 0;">';
                    if($room_index == $info['room_index'] && $info['room_index'] > 0 ){
                        $printBoxCheck .='<hr>';
                    }
                        $printBoxCheck .='<div style="width: 100%;position: relative;min-height: 1px;padding-left: 1rem;box-sizing: border-box; float: left;">';
                        if($room_index == $info['room_index'] ){
                            $printBoxCheck .='<div style="width: 100%;">';
                            $printBoxCheck .='<span style="font-weight: bold;">Room '.($info['room_index'] + 1).': </span>';
                            $printBoxCheck .='<span>';
                            $printBoxCheck .= !empty( $info['room_name_en']) ?  $info['room_name_en'] :  $info['room_name'];
                            $printBoxCheck .='</span>';
                            $printBoxCheck .=' </div>';

                            $printBoxCheck .='<div class="row-header" style="width: 100%;">';
                            $printBoxCheck .='<div style="width: 1%;float: left;position: relative;min-height: 1px;padding-left: 1rem;"><span style="font-weight: bold;">#</span></div>';
                            $printBoxCheck .='<div style="width: 30%;float: left;position: relative;min-height: 1px;padding-left: 1rem;"><span style="font-weight: bold;">Full Name</span></div>';
                            $printBoxCheck .='<div style="width: 15%;float: left;position: relative;min-height: 1px;padding-left: 1rem;"><span style="font-weight: bold;">Passenger Type</span></div>';

                            $passenger_number = 1;
                        }
                        $printBoxCheck.= '</div><div class="row-passenger" style="width: 100%">';
                        $printBoxCheck .='<div style="width: 1%;float: left;position: relative;min-height: 1px;padding-left: 1rem;box-sizing: border-box;"><span>';
                        $printBoxCheck .= $passenger_number.'</span></div>';
                        $printBoxCheck .='<div style="width: 30%;float: left;position: relative;min-height: 1px;padding-left: 1rem;box-sizing: border-box;">';
                        $printBoxCheck .='<span class="full-name-field">';
                        $passenger_name = !empty($info['passenger_name_en']) ? $info['passenger_name_en'] : $info['passenger_name'];
                        $passenger_family = !empty($info['passenger_family_en']) ? $info['passenger_family_en'] : $info['passenger_family'];
                        $printBoxCheck .= $passenger_name.' '.$passenger_family;
                        $printBoxCheck .='</span>';
                        $printBoxCheck .='</div>';

                        $printBoxCheck .='<div style="width: 15%;float: left;position: relative;min-height: 1px;padding-left: 1rem;box-sizing: border-box;"><span>';
                            if ($info['passenger_birthday_en']!=""){
                                $printBoxCheck .= functions::type_passengers($info['passenger_birthday_en']);
                            }else{
                                $printBoxCheck .= functions::type_passengers(functions::ConvertToMiladi($info['passenger_birthday']));
                            }
                            $printBoxCheck .='</span></div></div>';
                        if($room_index != $info['room_index']){
                            $printBoxCheck.= '</div>';
                        }
                    $printBoxCheck.= '</div>';
                    $passenger_number ++;
                    $room_index = $info['room_index'] + 1;

                }
            }

            $printBoxCheck .='
             </div>
         <br/>
    
            <h2 style="font-size: 14px;display: block;text-align: right;margin: 10px 40px 0px 40px;">
                <span>Pay attention to the following points:  </span>
            </h2>';
//
//            $printBoxCheck .='<div style="width: 93%;margin: 5px 40px 5px 40px;">';
//            $printBoxCheck .='<ul>
//<li>Early check out is full nights no show!</li>
//<li>test remark 1</li>
//</ul>';
//            $printBoxCheck .='<p style="padding-left: 8px;">همراه داشتن شناسنامه عکسدار جهت پذیرش و اقامت در هتل و همچنين نام ثبت شده همسر در شناسنامه الزامی است.</p>';
//                $printBoxCheck .='<p style="padding-left: 8px;">ساعت تحویل و تخليه اتاق طبق واچر می باشد و ساعت و خروج پرواز ملاک نمی باشد و هتل هيچ تعهدی در قبال تحویل اتاق
//    قبل از ساعت اعلام شده و در اختيار داشتن اتاق بعد از اعلام شده را ندارد.</p>';
//            $printBoxCheck .='<p style="padding-left: 8px;">با توجه به تنوع تخت های هتل، هتل هيچگونه تعهدی در قبال ارائه اتاق دو تخته چسبيده با جدا نداردو با توجه به شرایط هتل
//    پذیرش اتاق انجام می شود.</p>';
//            $printBoxCheck .='<p style="padding-left: 8px;">ترانسفر ورود یا خروج بر اساس درخواست مسافر انجام و مشمول هزینه می باشد.</p>';
//            $printBoxCheck .='<p style="padding-left: 8px;">کنسل نمودن رزرو اتاق مشمول جریمه طبق مقررات و یا در صورت گارانتی هتل، مبلغ غير قابل استرداد می باشد.</p>';
//            $printBoxCheck .='</div>';

            $extra_details = $info['extra_hotel_details'];
            $details = json_decode($extra_details,true);

            if(isset($details['SpecialInstructions']) && !empty($details['SpecialInstructions'])){
                $printBoxCheck .= '<div style="width: 93%;margin: 5px 40px 5px 40px;">';
                $printBoxCheck .= '<h3 style="font-size: 13px;display: block;text-align: left;margin: 10px 40px 0px 40px;">Special Instructions</h3>';
                $printBoxCheck .= '<p style="padding-left: 8px;">'.$details['SpecialInstructions'].'</p>';
                $printBoxCheck .= '</div>';
            }
            if(isset($details['Instructions']) && !empty($details['Instructions'])){
                $printBoxCheck .= '<div style="width: 93%;margin: 5px 40px 5px 40px;">';
                $printBoxCheck .= '<h3 style="font-size: 13px;display: block;text-align: left;margin: 10px 40px 0px 40px;">Instructions</h3>';
                $printBoxCheck .= '<p style="padding-left: 8px;">'.$details['Instructions'].'</p>';
                $printBoxCheck .= '</div>';
            }
            if(isset($details['Description']) && !empty($details['Description'])){
                $printBoxCheck .= '<div style="width: 93%;margin: 5px 40px 5px 40px;">';
                $printBoxCheck .= '<h3 style="font-size: 13px;display: block;text-align: left;margin: 10px 40px 0px 40px;">Description</h3>';
                $printBoxCheck .= '<p style="padding-left: 8px;">'.$details['Description'].'</p>';
                $printBoxCheck .= '</div>';
            }
            if(isset($details['MandatoryFee']) && !empty($details['MandatoryFee'])){
                $printBoxCheck .= '<div style="width: 93%;margin: 5px 40px 5px 40px;">';
                $printBoxCheck .= '<h3 style="font-size: 13px;display: block;text-align: left;margin: 10px 40px 0px 40px;">Mandatory Fee</h3>';
                $printBoxCheck .= '<p style="padding-left: 8px;">'.$details['MandatoryFee'].'</p>';
                $printBoxCheck .= '</div>';
            }
            $printBoxCheck .='<div class="clear-both"></div>';
            $printBoxCheck .= '</div></div>
    
            <div class="clear-both"></div>
    
            </div>';

            $printBoxCheck .= ' </div>
                            </body>
            </html> ';
        } else {
            $printBoxCheck = '<div style="text-align:center ; fon-size:20px ;font-family: Yekan;">اطلاعات مورد نظر موجود نمی باشد</div>';
        }

//        echo $printBoxCheck;die();
        return $printBoxCheck;
    }

//    public function createPdfContent($param)
//    {
//
//        $html = '
//<!doctype html>
//<html lang="en">
//  <head>
//    <title>Hotel Voucher</title>
//    <!-- Required meta tags -->
//    <meta charset="utf-8">
//
//
//    <!-- Bootstrap CSS -->
//
//    <link rel="stylesheet" href="'.ROOT_ADDRESS_WITHOUT_LANG.'/view/administrator/assets/css/bootstrap.css" media="all">
//    <link rel="stylesheet" href="'.ROOT_ADDRESS_WITHOUT_LANG.'/view/administrator/assets/css/pdf-voucher.css" media="all">
//  </head>
//  <body style="direction: ltr !important">
//    <div class="container page-content">';
//        if(TYPE_ADMIN){
//            $model = Load::getModel('reportHotelModel');
//        }else{
//            $model = Load::getModel('bookHotelLocal');
//        }
//        $all_passengers = $model->get()->where('factor_number',$param)->where('status','BookedSuccessfully')->all();
//        $rooms = $model->get()->where('factor_number',$param)->where('status','BookedSuccessfully')->groupBy('room_index')->all();
//        if(!is_array($all_passengers) || empty($all_passengers[0])){
//            $html .= '<div class="alert alert-danger">data requested not found please check and try again</div>';
////            return $html;
//        }else{
//            $first_passenger = $all_passengers[0];
//
//            $extra_detail = json_decode($first_passenger['extra_hotel_details'],true);
//           if($_GET['lang']== 'fa') {
//               $start_date_gregorian = $first_passenger['start_date'];
//               $end_date_gregorian = $first_passenger['end_date'];
//               $start_f = functions::dateFormatSpecialJalali($start_date_gregorian,'F');
//               $end_f = functions::dateFormatSpecialJalali($end_date_gregorian,'F');
//               $start_l = functions::dateFormatSpecialJalali($start_date_gregorian,'l');
//               $end_l = functions::dateFormatSpecialJalali($end_date_gregorian,'l');
//           }else{
//               $start_date_gregorian = functions::ConvertToMiladi($first_passenger['start_date']);
//               $end_date_gregorian = functions::ConvertToMiladi($first_passenger['end_date']);
//               $start_f = date('F',strtotime($start_date_gregorian)) ;
//               $end_f = date('F',strtotime($end_date_gregorian)) ;
//               $start_l = date('l',strtotime($start_date_gregorian));
//               $end_l = date('l',strtotime($end_date_gregorian));
//           }
//
//           if($first_passenger['type_application'] == 'reservation') {
//               $pic =  ROOT_ADDRESS_WITHOUT_LANG .'/pic/'. $first_passenger['hotel_pictures']  ;
//           }else{
//               $pic = $first_passenger['hotel_pictures'] ;
//           }
//            $hotel_details = [
//                'name'=>$first_passenger['hotel_name'],
//                'extra_bed_count'=>$first_passenger['extra_bed_count'],
//                'image'=> $pic ,
//                'address'=>$first_passenger['hotel_address'],
//                'tel'=>$first_passenger['hotel_telNumber'],
//                'stars'=>$first_passenger['hotel_starCode'],
//                'factor_number'=>$first_passenger['factor_number'],
//                'pnr'=>$first_passenger['pnr'],
//                'gps_coordinates'=>json_decode($first_passenger['hotel_location'],true),
//                'nights'=>$first_passenger['number_night'],
//                'hotel_star_code'=>$first_passenger['hotel_starCode'],
//                'check_in'=>[
//                    'time'=>$first_passenger['hotel_entryHour'],
//                    'date'=>$start_date_gregorian,
//                    'd'=>date('d',strtotime($start_date_gregorian)),
//                    'F'=>$start_f,
//                    'l'=>$start_l,
//                    'Y'=>date('Y',strtotime($start_date_gregorian)),
//
//                ],
//                'check_out'=>[
//                    'time'=>$first_passenger['hotel_leaveHour'],
//                    'date'=>$end_date_gregorian,
//                    'd'=>date('d',strtotime($end_date_gregorian)),
//                    'F'=>$end_f,
//                    'l'=>$end_l,
//                    'Y'=>date('Y',strtotime($end_date_gregorian)),
//                ],
//                'important_notices'=> htmlentities('test remark 1'),
//                'min_age'=>18,
//                'rooms_count'=>count($rooms),
//                'instructions'=>htmlentities($extra_detail['Instructions']),
//                'special_instructions'=>htmlentities($extra_detail['SpecialInstructions']),
//                'hotel_confirm_code'=>$first_passenger['hotel_confirm_code'],
//            ];
//
//            $room_details = [];
//            foreach ($rooms as $room) {
//                $detail = [
//                    'room_name'=>$room['room_name'],
//                    'bed_type'=>'FullBed',
//                ];
//                foreach ($all_passengers as $passenger) {
//                    if($passenger['room_index'] != $room['room_index']){
//                        continue;
//                    }
//                    if($passenger['passenger_birthday_en'] != ""){
//                        $passenger_type = functions::type_passengers($passenger['passenger_birthday_en']);
//                    }else{
//                        $passenger_type = functions::type_passengers(functions::ConvertToMiladi($passenger['passenger_birthday']));
//                    }
//                    $detail['passengers'][] = [
//                        'name'=>$passenger['passenger_name_en'] . ' '. $passenger['passenger_family_en'],
//                        'type'=> $passenger_type
//                    ];
//                }
//                $room_details[] = $detail;
//            }
//
//            if($_GET['lang']== 'fa') {
//                $Approvereservation = 'تاییدیه رزرو';
//                $Itinerary = 'شناسه رزرو';
//                $Traveler = 'مسافر';
//                $Confirmhotelcode = 'کد تایید هتل';
//                $HotelDetails = 'اطلاعات هتل' ;
//                $Address = 'آدرس' ;
//                $HotelPhone = 'ﺗﻠﻔﻦ ﻫﺘﻞ' ;
//                $CheckIn = 'تاریخ ورور' ;
//                $CheckOut = 'تاریخ خروج' ;
//                $Rooms = 'تعداد اتاق' ;
//                $Nights = 'تعداد شب' ;
//                $Extrabed = 'تخت اضافه' ;
//                $RoomDetails = 'جزییات اتاق' ;
//                $FullName = 'نام و نام خانوادگی' ;
//                $Passengertyle = 'نوع مسافر' ;
//                $ImportantInformation = 'اطلاعات مهم' ;
//                $HotelPolicies = 'قوانین هتل' ;
//                $MinAge = 'حداقل سن' ;
//                $Instructions = 'دستورالعمل ها' ;
//                $SpecialInstructions = 'دستورالعمل های ویژه' ;
//                $star = 'ستاره' ;
//                $importantRule = 'در زمان ورود برای اتباع غير ايرانی ممکن است مطابق با قوانين هتل هزينه پرداخت شود' ;
//            }else{
//                $Approvereservation = 'Booking Confirmation';
//                $Itinerary = 'Itinerary ID';
//                $Traveler = 'Traveler';
//                $Confirmhotelcode = 'Confirm hotel code';
//                $HotelDetails = 'Hotel Details' ;
//                $Address = 'Address' ;
//                $HotelPhone = 'Hotel phone' ;
//                $CheckIn = 'Check-In' ;
//                $CheckOut = 'Check-Out' ;
//                $Rooms = 'Rooms' ;
//                $Nights = 'Nights' ;
//                $Extrabed = 'Extra bed' ;
//                $RoomDetails = 'Room Details' ;
//                $FullName = 'Full Name' ;
//                $Passengertyle = 'Passenger tyle' ;
//                $ImportantInformation = 'Important Information' ;
//                $HotelPolicies = 'Hotel Policies' ;
//                $MinAge = 'Min Age' ;
//                $Instructions = 'Instructions' ;
//                $SpecialInstructions = 'Special Instructions' ;
//                $star = 'stars' ;
//                $importantRule = ' Important Information: Early check out is full nights no show!' ;
//            }
//
//            $pdf_details = [
//                'room'=>$room_details,
//                'hotel'=>$hotel_details
//            ];
////            echo json_encode($hotel_details);die();
////            echo json_encode($pdf_details,256);die();
//
//            if ($hotel_details['hotel_confirm_code'] == '') {
//                $html .= '
//                                        <div style="margin: 20px 0 0 0;width: 200px;display: inline-block;text-align: center;height: 67px;object-fit: contain">
//                            <img src="' .ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . CLIENT_LOGO . '" style="max-height: 80px;">
//                        </div>
//                ';
//                $html .= '<div class="card">
//<div class="card-header">'.$Approvereservation.'</div>
//  <div class="card-body p-2">
//    <table style="width:100%;line-height:20px !important;">
//      <tr>
//        <td style="width: 170px;">'.$Itinerary.'</td>
//        <td class="details_tbl_name">'.$hotel_details['factor_number'].'</td>
//      </tr>
//      <tr>
//        <td>'.$Traveler.'</td>
//        <td class="details_tbl_name">'.$first_passenger['passenger_name_en'].' '. $first_passenger['passenger_family_en'].'</td>
//      </tr>
//      <tr>
//        <td>'.$Confirmhotelcode.'</td>
//        <td class="details_tbl_name">'.$hotel_details['pnr'].'</td>
//      </tr>
//    </table>
//  </div>
//</div>';
//            } else {
//                $html .= '
//                                        <div style="margin: 20px 0 0 0;width: 200px;display: inline-block;text-align: center;height: 67px;object-fit: contain">
//                            <img src="' .ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . CLIENT_LOGO . '" style="max-height: 80px;">
//                        </div>
//                ';
//                $html .= '<div class="card">
//<div class="card-header">'.$Approvereservation.'</div>
//  <div class="card-body p-2">
//    <table style="width:100%;line-height:20px !important;">
//      <tr>
//        <td style="width: 170px;">'.$Itinerary.'</td>
//        <td class="details_tbl_name">'.$hotel_details['factor_number'].'</td>
//      </tr>
//      <tr>
//        <td>'.$Traveler.'</td>
//        <td class="details_tbl_name">'.$first_passenger['passenger_name_en'].' '. $first_passenger['passenger_family_en'].'</td>
//      </tr>
//      <tr>
//        <td>'.$Confirmhotelcode.'</td>
//        <td class="details_tbl_name">'.$hotel_details['hotel_confirm_code'].'</td>
//      </tr>
//    </table>
//  </div>
//</div>';
//            }
//$no_photo_src = ROOT_ADDRESS_WITHOUT_LANG.'/pic/hotel-nophoto.jpg';
//             $html .= '<div class="card">
//<div class="card-header">'.$HotelDetails.'</div>
//  <div class="card-body p-2">
//   <table style="width:100%;line-height:20px !important;">
//      <tr>
//        <td style="padding-right: 10px;width: 170px;">
//           <img src="'.($hotel_details['image']).'" onerror="this.src=\''.$no_photo_src.'\';" alt="'.$hotel_details['name'].'" class="hotel-image">
//        </td>
//        <td class="details_tbl_name">'.$hotel_details['name'] .' <br> '. $hotel_details['hotel_star_code'] . $star.'  </td>
//      </tr>
//    </table>
//    <table style="width:100%;line-height:20px !important;">
//      <tr>
//        <td style="padding-right: 10px;width: 170px;">
//           <span><b>'.$Address.' : </b> '.$hotel_details['address'].'</span>
//           <span><b>'.$HotelPhone.' : </b> '.$hotel_details['tel'].'</span>
//        </td>
//      </tr>
//
//    </table>
//   <table style="width:100%;line-height:20px !important;">
//   <tbody>
//   <tr>
//   <td style="width: 80%;vertical-align: top;">
//<table class="w-100">
//<tbody>
//
//<tr class="w-100 border-top" style="width: 100%" >
//<td colspan="7"></td>
//</tr>
//<tr class="hotel-details-row d-flex" style="width: 100%;">
//<td colspan="7" class="w-100" style="width: 100%;">
//<table class="w-100 table table-stripe text-center">
//<tr class="w-100">
//<td style="width: 150px"><div >
//<span class="hotel-details-title">'.$CheckIn.'</span><br>
//<span class="hotel-details-content"><strong>'.($hotel_details['check_in']['d']).'</strong></span>
//<span class="hotel-details-content"><strong>'.($hotel_details['check_in']['F']).'</strong></span>
//<span class="hotel-details-content"><b>'.($hotel_details['check_in']['Y']).'</b></span><br>
//<span class="hotel-details-content"><b>'.($hotel_details['check_in']['l']).'</b></span>
//</div></td>
//<td style="width: 150px">
//<div class="detail-item">
//<span class="hotel-details-title">'.$CheckOut.'</span><br>
//<span class="hotel-details-content"><strong>'.($hotel_details['check_out']['d']).'</strong></span>
//<span class="hotel-details-content"><strong>'.($hotel_details['check_out']['F']).'</strong></span>
//<span class="hotel-details-content"><b>'.($hotel_details['check_out']['Y']).'</b></span><br>
//<span class="hotel-details-content"><b>'.($hotel_details['check_out']['l']).'</b></span>
//</div>
//</td>
//<td style="width: 150px">
//<div class="detail-item">
//<span class="hotel-details-title">'.$Rooms.'</span><br>
//<span class="hotel-details-content"><strong>'.count($room_details).'</strong></span>
//</div>
//</td>
//<td style="width: 150px">
//<div class="detail-item">
//<span class="hotel-details-title">'.$Nights.'</span><br>
//<span class="hotel-details-content"><strong>'.($hotel_details['nights']).'</strong></span>
//</div>
//</td>
//<td style="width: 150px">
//<div class="detail-item">
//<span class="hotel-details-title">'.$Extrabed.'</span><br>
//<span class="hotel-details-content"><strong>'.($hotel_details['extra_bed_count']?$hotel_details['extra_bed_count']:'0').'</strong></span>
//</div>
//</td>
//</tr>
//</table>
//</td>
//</tr>
//</tbody>
//</table>
//</td>
//   <td>
//   <!--map image-->
//   <a class="view-map-link" href="https://www.google.com/maps/@'.$hotel_details['gps_coordinates']['latitude'].','.$hotel_details['gps_coordinates']['longitude'].',16z">View On Map</a>
//</td>
//</tr>
//</tbody>
//</table>
//  </div>
//</div>';
//
//$html .= '<div class="card">
//<div class="card-header">'.$RoomDetails.'</div>
//<div class="card-body p-2">
//<table class="w-100 table">
//<tr>
//';
//            foreach ($room_details as $rk => $room_detail) {
//                $html .= '<td>
//<table class="w-100">
//<tr><td class="room-name" colspan="7">
//<b>'.$room_detail['room_name'].'</b>
//<b class="room_boardname"></b>
//</td></tr>
//</table>
//<table class="border table w-100 table-bordered table-striped"><thead>
//<tr>
//<th style="width: 30px;">#</th>
//<th style="width: 400px;">'.$FullName.'</th>
//<th style="width: 100px;">'.$Passengertyle.'</th>
//</tr>
//</thead>
//<tbody>
//';
//                foreach ($room_detail['passengers'] as $pk => $passenger) {
//                    $row_num = $pk+1;
//                $html .='<tr>
//<td class="border">'.$row_num.'</td>
//<td>'.$passenger['name'].'</td>
//<td>'.$passenger['type'].'</td>
//</tr>
//';
//
//                }
//
//                $html .='</tbody></table></td>';
//                if(($rk % 2) == 1){
//                    $html .= '</tr><tr>';
//                }
//}
//$html .= '
//</tr>
//</table>
//</div>
//</div>';
//
//            $html .= '<div class="card">
//<div class="card-header">'.$ImportantInformation.' </div>
//<div class="card-body p-2">'.$importantRule.'
//</div>
//</div>
//';
//
//            $html .= '<div class="card">
//<div class="card-header">'.$HotelPolicies.'</div>
//<div class="card-body p-2">
//<table class=" table w-100"><tbody>';
//
//            $html.= '<tr style="border-bottom: 1px dotted;"><td style="width: 170px;">'.$CheckIn.'</td><td>'.$hotel_details['check_in']['time'].'</td></tr>';
//            $html.= '<tr style="border-bottom: 1px dotted;"><td style="width: 170px;">'.$CheckOut.'</td><td>'.$hotel_details['check_out']['time'].'</td></tr>';
//            $html.= '<tr style="border-bottom: 1px dotted;"><td style="width: 170px;">'.$MinAge.'</td><td>'.$hotel_details['min_age'].'</td></tr>';
//            $html.= '<tr style="border-bottom: 1px dotted;"><td style="width: 170px;">'.$Instructions.'</td><td>'.html_entity_decode($hotel_details['instructions']).'</td></tr>';
//            $html.= '<tr style="border-bottom: 1px dotted;"><td style="width: 170px;">'.$SpecialInstructions.'</td><td>'.html_entity_decode($hotel_details['special_instructions']).'</td></tr>';
//
//            $html .= '</tbody></table></div></div>';
//        }
//        $html .= '</div></body></html>';
////        echo $html;die();
//        return $html;
//    }
    public function createPdfContent($factorNumber, $cash, $cancelStatus)
    {
        $Model = Load::library('Model');
        $tableName = 'book_hotel_local_tb';
        $info_hotel = $this->getModel('bookHotelLocalModel')->get()->where('factor_number',$factorNumber);
        if (TYPE_ADMIN == '1') {
            $Model = Load::library('ModelBase');
            $tableName = 'report_hotel_tb';
            $info_hotel = $this->getModel('reportHotelModel')->get()->where('factor_number',$factorNumber);
        }

        if (isset($cancelStatus) && $cancelStatus != '') {
            $info_hotel = $info_hotel->where('status','canceled');
        }
        $info_hotel = $info_hotel->all();

        if (empty($info_hotel)) {
            return '<div style="text-align:center; font-size:20px; font-family: Arial;">The requested information is not available.</div>';
        }

        // شروع HTML
        $html = '<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel voucher</title>
    <style>
      
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Arial" !important;
            direction:ltr !important;
            text-align:left !important;
        }

        body {
            font-family: "Arial" !important;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            margin-bottom: 40mm;
              direction:ltr !important;
            text-align:left !important;
        }
        
        .container {
//            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            padding-bottom: 60px;
        }

        /* Header */
        .header {
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #ccc;
            padding-bottom: 15px;
        }

        .header table {
            width: 100%;
            border: none;
            margin: 0;
        }

        .header table td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }

        .header-logo {
            width: 50%;
            text-align: left;
        }

        .header-logo img {
            max-width: 80px;
            min-height: 50px;
        }

        .header-barcode {
            width: 50%;
            text-align: right;
        }
        
        .header-voucher {
            display: table-cell;
            width: 150px;
            vertical-align: middle;
            text-align: left;
        }
        
        .voucher-badge {
            background: #f44336;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
        }
        
        /* Hotel Info Section */
        .hotel-info-section {
            background: #fff;
            border: 2px solid #ccc;
            border-radius: 8px;
            padding: 2px;
            margin: 20px !important;
        }
        
        .hotel-header {
            display: table;
            width: 100%;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ccc;
        }

        .hotel-icon {
            display: table-cell;
            width: 35px;
            text-align: center;
            vertical-align: middle;
            padding-left: 5px;
        }

        .hotel-name {
            display: table-cell;
            font-size: 16px;
            font-weight: bold;
            color: #333;
            vertical-align: middle;
            padding: 0 10px;
        }
        
        .hotel-stars {
            display: table-cell;
            color: #ffa726 !important;
            font-size: 18px;
            vertical-align: middle;
            text-align: left;
        }
        
        .info-grid {
            display: table;
            width: 100%;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-cell {
            display: table-cell;
            padding: 8px 10px;
            vertical-align: top;
            width: 50%;
        }
        
        .info-label {
            color: #666;
            font-size: 11px;
            margin-bottom: 3px;
        }
        
        .info-value {
            font-weight: bold;
            color: #333;
            font-size: 13px;
        }
        
        /* Booking Details */
        .booking-details {
            background: #fff;
            border: 2px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1976d2;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #ccc;
        }

        .detail-row {
            display: table;
            width: 100%;
            padding: 8px 0;
            border-bottom: 1px dashed #ccc;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            display: table-cell;
            width: 120px;
            color: #666;
            font-size: 11px;
            vertical-align: top;
        }

        .detail-value {
            display: table-cell;
            font-weight: bold;
            color: #333;
            font-size: 12px;
            vertical-align: top;
        }
        
        /* Guest Info */
        .guest-info {
            background: #fff;
            border: 2px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .guest-info .section-title {
            color: #7b1fa2;
            border-bottom-color: #ccc;
        }

        .guest-card {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 12px;
            margin-bottom: 10px;
        }
        
        .guest-card:last-child {
            margin-bottom: 0;
        }
        
        .guest-number {
            background: #9c27b0;
            color: white;
            display: inline-block;
            padding: 3px 10px;
            border-radius: 3px;
            font-size: 11px;
            margin-bottom: 8px;
        }
        
        /* Important Notes */
        .important-notes {
            background: #fff;
            border: 2px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin:20px !important;
            margin-bottom: 20px;
        }

        .important-notes .section-title {
            color: #c62828;
            border-bottom-color: #ccc;
        }
        
        .note-item {
            padding: 8px 0 8px 20px;
            position: relative;
            color: #555;
            font-size: 11px;
            line-height: 1.8;
        }
        
        .note-item:before {
            content: "•";
            position: absolute;
            left: 0;
            color: #f44336;
            font-weight: bold;
            font-size: 14px;
        }
        
        /* Cancellation Rules */
        .cancellation-rules {
            background: #fff;
            border: 2px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            text-align:left !important;
        }
        
        .cancellation-rules .section-title {
            color: #f57f17;
            border-bottom-color: #ccc;
        }
        
        /* Map Section */
        .map-section {
            background: #fff;
            border: 2px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin: 20px;
            page-break-inside: avoid;
        }

        .map-section .section-title {
            color: #000;
            border-bottom-color: #ccc;
        }

        .map-container {
            width: 100%;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 10px;
        }

        .map-container img {
            width: 100%;
            height: auto;
        }
        
        /* Footer */
        .footer {
            width: 100%;
            padding: 10px 0;
            text-align: center;
            border-top: 2px solid #ccc;
            position: fixed;
            bottom: -20mm;
            left: 0;
            right: 0;
            background: white;
        }

        .footer-info {
            width: 100%;
            border: none;
        }

        .footer-item {
            padding: 5px 15px;
            font-size: 16px;
            color: #666;
            text-align: center;
            border: none;
        }

        .footer-label {
            font-weight: bold;
            color: #333;
        }
     @page {
            footer: myFooter;
            margin-bottom: 25mm;
        }

        .footer-table {
            width: 100%;
            font-size: 10pt;
            padding-top: 5px;
            font-family: Arial;
        }
        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }

        th {
            background: #fff;
            font-weight: bold;
            color: #333;
        }
        
        /* Utilities */
        .text-center {
            text-align: center;
        }
        
        .text-bold {
            font-weight: bold;
        }
        
        .text-red {
            color: #f44336;
        }
        
        .text-green {
            color: #4caf50;
        }
        
        .mb-10 {
            margin-bottom: 10px;
        }
        
        .mb-20 {
            margin-bottom: 20px;
        }
        
        @media print {
            body {
                background: #fff;
            }

            .container {
                margin: 0;
                box-shadow: none;
            }
        }
        .barcode {
            max-width: 80px;
            min-height: 50px;
            display: inline-block;
        }
    </style>
</head>
<body style="text-align:left; font-family: Arial;">
    <div class="container">';

        // Header با لوگو و بارکد
        $html .= '
        <div class="header" style="direction:rtl !impo">
            <table>
                <tr>
                    <td class="header-logo">
                        <img src="' . ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . CLIENT_LOGO . '" alt="Logo" style="max-width: 80px; min-height: 50px">
                    </td>
                    <td class="header-barcode">
                        <img class="barcode" src="https://safar360.com/gds/library/barcode/barcode_creator.php?barcode=' . trim($info_hotel[0]["pnr"]) . '" alt="Barcode"  >
                    </td>
                </tr>
            </table>
        </div>';

        // اطلاعات اصلی برای استفاده در بخش‌های مختلف
        $firstInfo = $info_hotel[0];

        if (!empty($firstInfo['payment_date'])) {
            $pd = functions::set_date_payment($firstInfo['payment_date']);
            $pd = explode(' ', $pd)[0]; // فقط تاریخ
            $p = explode('-', $pd);
            $pay_date = "{$p[0]}/{$p[1]}/{$p[2]}";
        } else {
            $pay_date = '-';
        }

        // بخش اطلاعات هتل
        $html .= '
        <div class="hotel-info-section">
            <table cellpadding="0" cellspacing="0" style="width: 100%;  border-collapse: collapse; font-family: Arial;">
                <tr>
                    <td style="width: 35px; text-align: center; vertical-align: middle; border: none; padding: 0 5px 0 0; font-family: Arial;">
                                               <svg height="24px" width="24px" fill="#ff9800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M24 0C10.7 0 0 10.7 0 24S10.7 48 24 48h8V464H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H488c13.3 0 24-10.7 24-24s-10.7-24-24-24h-8V48h8c13.3 0 24-10.7 24-24s-10.7-24-24-24H24zM432 48V464H304V384h32c8.8 0 16.1-7.2 14.7-15.9C343.1 322.6 303.6 288 256 288s-87.1 34.6-94.7 80.1c-1.5 8.7 5.8 15.9 14.7 15.9h32v80H80V48H432zM144 96c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V112c0-8.8-7.2-16-16-16H144zm80 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V112c0-8.8-7.2-16-16-16H240c-8.8 0-16 7.2-16 16zM336 96c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V112c0-8.8-7.2-16-16-16H336zM128 208v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V208c0-8.8-7.2-16-16-16H144c-8.8 0-16 7.2-16 16zm112-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V208c0-8.8-7.2-16-16-16H240zm80 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V208c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z"/></svg>

                    </td>
                    <td style="font-size: 20px; font-weight: bold; color: #333; vertical-align: middle; border: none; padding: 0 10px; font-family: Arial;">
                        ' . $firstInfo['hotel_name'] . '
                        <span style="margin-right: 10px;">';

        // نمایش ستاره‌ها با SVG طلایی
        $stars = intval($firstInfo['hotel_starCode']);
        for ($i = 0; $i < $stars; $i++) {
            $html .= '<svg width="16" height="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="display: inline-block; vertical-align: middle; margin: 0 1px;">
                <path fill="#F0B417" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
            </svg>';
        }

        $html .= '</span>
                    </td>
                </tr>';

        // اضافه کردن آدرس و تلفن در row جدید (زیر آیکون هتل)
        if (!empty($firstInfo['hotel_address'])) {
            $html .= '<tr>
                    <td colspan="3" style="padding: 5px 5px 5px 0; font-size: 11px; color: #666; border: none; vertical-align: top; text-align: left; font-family: Arial;">';

            if (!empty($firstInfo['hotel_address'])) {
                $html .= '<div style="margin-bottom: 8px; padding-bottom: 8px;font-family: Arial;">

                    <span style="vertical-align: middle; font-family: Arial;">Address: ' . $firstInfo['hotel_address'] . '</span>
                </div>';
            }

            $html .= '</td>
                </tr>
                <tr>
                    <td colspan="3" style="border: none; padding: 0; height: 12px;"></td>
                </tr>';
        }


        // محاسبه شماره واچر


        $voucherNumber = $firstInfo['pnr'];

        if (!empty($firstInfo['payment_date'])) {

            $pd = $firstInfo['payment_date']; // مقدار: 2025-10-21 08:20:23

            // جدا کردن تاریخ و ساعت
            list($datePart, $timePart) = explode(' ', $pd);

            // تبدیل تاریخ از - به /
            $p = explode('-', $datePart);
            $pay_date = "{$p[0]}/{$p[1]}/{$p[2]}";

            $pay_time = $timePart;

        } else {
            $pay_date = '-';
            $pay_time = '-';
        }

        $html .= '
                <tr>
                    <td colspan="3" style="border-top: 2px solid #ccc; border-left: none; border-right: none; border-bottom: none;  padding: -10px 5px -24px 0px; font-family: Arial;">
                        <table cellpadding="0" cellspacing="0" style="width: 100%; border: none; border-collapse: collapse; font-family: Arial;">
                            <tr>
                                <td style="width: 48%; border: none;  vertical-align: top; font-family: Arial;">
                                    <table cellpadding="0" cellspacing="0" style="width: 100%; border: none; border-collapse: collapse; font-family: Arial; margin-top:-6px;margin-bottom:-20px !important">
                                        <tr>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #333; font-weight: bold; width: 120px; line-height: 1.4; font-family: Arial;">Room delivery time:</td>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #666; line-height: 1.4; font-family: Arial;">'. (!empty($firstInfo['start_date']) ? $firstInfo['start_date'] : '-')  . '      ' .    (!empty($firstInfo['hotel_entryHour']) ? $firstInfo['hotel_entryHour'] : '-')   . '</td>
                                        </tr>
                                        <tr>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #333; font-weight: bold; line-height: 1.4; font-family: Arial;">Room vacating time:</td>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #666; line-height: 1.4; font-family: Arial;">'. (!empty($firstInfo['end_date']) ? $firstInfo['end_date'] : '-')  . '      ' .  (!empty($firstInfo['hotel_leaveHour']) ? $firstInfo['hotel_leaveHour'] : '-')     . '</td>
                                        </tr>
                                        <tr>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #333; font-weight: bold; line-height: 1.4; font-family: Arial;">Duration of stay:</td>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #666; line-height: 1.4; font-family: Arial;">' . (!empty($firstInfo['number_night']) ? $firstInfo['number_night'] : '-') . ' Night</td>
                                        </tr>
                                        <tr>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #333; font-weight: bold; line-height: 1.4; font-family: Arial;">Number of rooms:</td>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #666; line-height: 1.4; font-family: Arial;">' . count($info_hotel) . ' Room </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="width: 1px; border-left: 2px solid #ccc; border-top: none; border-bottom: none; border-right: none; padding: 0; font-family: Arial;"></td>
                                <td style="width: 10px; border: none; padding: 0; font-family: Arial;">&nbsp;</td>
                                <td style="border: none; vertical-align: top; font-family: Arial;">
                                    <table cellpadding="0" cellspacing="0" style="width: 100%; border: none; border-collapse: collapse; font-family: Arial;margin-top:-6px;margin-bottom:-20px !important;">
                                        <tr>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #333; font-weight: bold; width: 100px; line-height: 1.4; font-family: Arial;">Voucher number:</td>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #666; line-height: 1.4; font-family: Arial;">' . $voucherNumber . '</td>
                                        </tr>
                                        <tr>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #333; font-weight: bold; line-height: 1.4; font-family: Arial;">Factor number:</td>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #666; line-height: 1.4; font-family: Arial;">' . $firstInfo['factor_number'] . '</td>
                                        </tr>
                                        <tr>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #333; font-weight: bold; line-height: 1.4; font-family: Arial;">Reservation date: </td>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #666; line-height: 1.4; font-family: Arial;">' . ($pay_date !== '-' ? $pay_date : '-'). '</td>
                                        </tr>
                                        <tr>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #333; font-weight: bold; line-height: 1.4; font-family: Arial;">Reservation hours: </td>
                                            <td style="border: none; padding: 2px 0; font-size: 11px; color: #666; line-height: 1.4; font-family: Arial;">' . ($pay_time !== '-' ? $pay_time : '-') . '</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            
            ';



        $html .= '
                      
                        </div>
                   ';

        // اگر کنسل شده
        if ($firstInfo['request_cancel'] == 'confirm') {
            $html .= '<div style="background: #fff; border: 2px solid #ccc; padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: center; font-family: Arial;">
                <span style="font-weight: bold; color: #c62828; font-size: 16px; font-family: Arial;"> این هتل کنسل شده است</span>
            </div>';
        }



        // باکس اطلاعات اتاق‌ها
        $html .= '
        <div style="background: #fff; border-radius: 8px; overflow: hidden; margin: 20px; border: 2px solid #ddd; font-family: Arial;">
            <div style="text-align:left !important;background: #d5dddd; color: #333; padding: 12px; font-weight: bold; font-size: 14px; font-family: Arial;">
                Rooms
            </div>
            <div style="padding: 15px; font-family: Arial; overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-family: Arial;">
                    <thead>
                        <tr style="background: #d5dddd; border-bottom: 2px solid #ddd;">
                            <th style="padding: 12px; text-align: left; font-weight: bold; color: #333; border: 1px solid #ddd; font-family: Arial;">Row</th>
                            <th style="padding: 12px; text-align: left; font-weight: bold; color: #333; border: 1px solid #ddd; font-family: Arial;">Room type</th>
                            <th style="padding: 12px; text-align: left; font-weight: bold; color: #333; border: 1px solid #ddd; font-family: Arial;">Bed information</th>
                        </tr>
                    </thead>
                    <tbody>';

        $roomCounter = 1;
        foreach ($info_hotel as $info) {
            // تعداد تخت اضافه یا نوع تخت
            $bedInfo = '';
            if ($info['type_application'] == 'reservation') {
                $flatType = '';
                if ($info['flat_type'] == 'DBL') {
                    $flatType = 'تخت اصلی';
                } elseif ($info['flat_type'] == 'EXT') {
                    $flatType = 'تخت اضافه بزرگسال';
                } elseif ($info['flat_type'] == 'ECHD') {
                    $flatType = 'تخت اضافه کودک';
                }
                $bedInfo = $flatType != '' ? $flatType : '-';
            } else {
                $bedInfo = ' Number of extra beds: ' . (!empty($info['extra_bed_count']) ? $info['extra_bed_count'] : '0');
            }

            $html .= '
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td style="padding: 12px; text-align: left; border: 1px solid #ddd; font-family: Arial; color: #333;">' . $roomCounter . '</td>
                            <td style="padding: 12px; text-align: left; border: 1px solid #ddd; font-family: Arial; color: #333; font-weight: bold;">' . (!empty($info['room_name']) ? $info['room_name'] : '-') . '</td>
                            <td style="padding: 12px; text-align: left; border: 1px solid #ddd; font-family: Arial; color: #333;">' . $bedInfo . '</td>
                        </tr>';

            $roomCounter++;
        }

        $html .= '
                    </tbody>
                </table>
            </div>
        </div>';

        // باکس اطلاعات مسافرین
        $html .= '
        <div style="background: #fff; border-radius: 8px; overflow: hidden; margin: 20px; border: 2px solid #ddd; font-family: Arial;">
            <div style="background: #d5dddd; color: #333; padding: 12px; font-weight: bold; font-size: 14px; font-family: Arial;">
                Passenger information
            </div>
            <div style="padding: 15px; font-family: Arial; overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-family: Arial;">
                    <thead>
                        <tr style="background: #f5f5f5; border-bottom: 2px solid #ddd;">
                            <th style="padding: 12px; text-align: left; font-weight: bold; color: #333; border: 1px solid #ddd; font-family: Arial;">Row</th>
                            <th style="padding: 12px; text-align: left; font-weight: bold; color: #333; border: 1px solid #ddd; font-family: Arial;">First and last name</th>
                            <th style="padding: 12px; text-align: left; font-weight: bold; color: #333; border: 1px solid #ddd; font-family: Arial;">Date of birth</th>
                            <th style="padding: 12px; text-align: left; font-weight: bold; color: #333; border: 1px solid #ddd; font-family: Arial;">National Code/Passport Number</th>
                        </tr>
                    </thead>
                    <tbody>';

        $passengerNum = 1;
        foreach ($info_hotel as $passenger) {
            // نام و نام خانوادگی
            $fullName = '';
            if (!empty($passenger['passenger_name_en'])) {
                $fullName = $passenger['passenger_name_en'] . ' ' . $passenger['passenger_family_en'];
            }elseif(!empty($passenger['passenger_name_en'])) {
                $fullName = $passenger['passenger_name'] . ' ' . $passenger['passenger_family'];

            }else {
                $fullName = '-';
            }

            // تاریخ تولد
            $birthday = '';
            if (!empty($passenger['passenger_birthday'])) {
                $birthday = $passenger['passenger_birthday'];
            } elseif (!empty($passenger['passenger_birthday_en'])) {
                $birthday = $passenger['passenger_birthday_en'];
            } else {
                $birthday = '-';
            }

            // شماره ملی/پاسپورت
            $nationalCode = '';
            if ($passenger['passenger_national_code'] != '') {
                $nationalCode = $passenger['passenger_national_code'];
            } elseif (!empty($passenger['passportNumber'])) {
                $nationalCode = $passenger['passportNumber'];
            } else {
                $nationalCode = '-';
            }

            $html .= '
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td style="padding: 12px; text-align: left; border: 1px solid #ddd; font-family: Arial; color: #333;">' . $passengerNum . '</td>
                            <td style="padding: 12px; text-align: left; border: 1px solid #ddd; font-family: Arial; color: #333; font-weight: bold;">' . $fullName . '</td>
                            <td style="padding: 12px; text-align: left; border: 1px solid #ddd; font-family: Arial; color: #333;">' . $birthday . '</td>
                            <td style="padding: 12px; text-align: left; border: 1px solid #ddd; font-family: Arial; color: #333;">' . $nationalCode . '</td>
                        </tr>';

            $passengerNum++;
        }

        $html .= '
                    </tbody>
                </table>
            </div>
        </div>';



        if ($firstInfo['type_application'] == 'api') {
            // قوانین کنسلی
            $html .= '
             <div class="important-notes" style="font-family: Arial;">
                <div class="section-title" style="font-family: Arial;;Cancellation laws"> Cancellation laws</div>

                <div class="note-item" style="font-family: Arial;">
                Reservation cancellation during peak and off-peak times: Given that cancellation rates vary between different times and hotels, the exact cancellation fee will be determined after inquiring with the hotel.
                </div>

            </div>';

        }else{
            $html .= '
             <div class="important-notes" style="font-family: Arial;">
                <div class="section-title" style="font-family: Arial;">Cancellation laws</div>

                <div class="note-item" style="font-family: Arial;">
            '
                .
                $firstInfo['hotel_rules'] . '
                </div> .

            </div>';
        }
        // نکات مهم
        $html .= '
             <div class="important-notes" style="font-family: Arial;">
            <div class="section-title" style="font-family: Arial;">Important Notes for Hotel Check-in</div>

            <div class="note-item" style="font-family: Arial;">
                Having a photo ID for check-in and accommodation at the hotel is mandatory.
            </div>

            <div class="note-item" style="font-family: Arial;">
                Check-in and check-out times are according to the voucher. Flight arrival and departure times are not considered, and the hotel has no obligation to deliver the room before the stated time or keep the room after the stated time.
            </div>


            <div class="note-item" style="font-family: Arial;">
                Airport transfer (arrival or departure) is provided upon passenger request and is subject to charges.
            </div>

            <div class="note-item" style="font-family: Arial;">
                Canceling room reservations is subject to penalties according to regulations, or in case of hotel guarantee, the amount is non-refundable.
            </div>
            </div>';

        if (!empty($firstInfo['hotel_location'])) {
            $location = json_decode($firstInfo['hotel_location'], true);
            if (!empty($location['latitude']) && !empty($location['longitude'])) {
                $lat = $location['latitude'];
                $lng = $location['longitude'];
                $html .= '
            <div class="map-section" style="font-family: Arial; page-break-inside: avoid;">
                <div class="section-title" style="font-family: Arial;">Hotel Location on Map</div>
                <div class="map-container">
                    <img src="https://static-maps.yandex.ru/1.x/?lang=fa_IR&ll=' . $lng . ',' . $lat . '&z=14&l=map&size=600,150&pt=' . $lng . ',' . $lat . ',pm2rdm" alt="نقشه هتل" style="width: 100%; height: auto; border-radius: 5px;">
                </div>
            </div>';
            }
        }



        // Footer
        $html .= '
<htmlpagefooter name="myFooter">
    <div style="">
        <table style="border-top:2px solid #ccc;width:100%; border-collapse:collapse;margin:10px 25px 10px 25px; font-family:Arial;font-size:16px;">
            <tr>
                <td style="border:none;">
                    <span>Website:</span>
                    <span dir="ltr">'.CLIENT_MAIN_DOMAIN.'</span>
                </td>
                <td style="border:none;">
                    <span>Phone:</span>
                    <span dir="ltr">'.CLIENT_PHONE.'</span>
                </td>
                <td style="border:none;">
                    <span>Address:</span>
                    <span>'.CLIENT_ADDRESS.'</span>
                </td>
            </tr>
        </table>
    </div>
</htmlpagefooter>

</body>
</html>';

        return $html;
    }



    public function hotelInfoTracking($factor_number)
    {

        $Model = Load::library('Model');
        $resultHotelLocalController=Load::controller('resultHotelLocal');

        $sql = " SELECT * FROM book_hotel_local_tb WHERE factor_number = '{$factor_number}' OR pnr = '{$factor_number}' OR request_number = '$factor_number' ";

        $bookHotel = $Model->select($sql);
        

        $hotelDetail =  $resultHotelLocalController->getHotelInfoById($bookHotel[0]['hotel_id']);
        $isRequest=false;
        if($hotelDetail['is_request'] =='1')
            $isRequest=true;

        $result = ''; $counterId = '';
        if (!empty($bookHotel)) {

            $sDate_miladi = functions::ConvertToMiladi($bookHotel[0]['start_date']);
            $sDate_miladi = str_replace("-", "", $sDate_miladi);
            $resultDate = date('Ymd', strtotime("".$sDate_miladi.",- 1 day"));
            $SDate = functions::ConvertToJalali($resultDate);
            $SDate = str_replace("-", "", $SDate);

            $dateNow = dateTimeSetting::jdate("Ymd",'','','','en');

            $accessStatusEdit = array('Cancelled', 'NoReserve', 'PreReserve', 'OnRequest');

            $result .= '
            <table class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>'.functions::Xmlinformation("City").'</th>
                    <th>'.functions::Xmlinformation("Hotel").'</th>
                    <th>'.functions::Xmlinformation("Enterdate").'<br>'.functions::Xmlinformation("Exitdate").'<br>'.functions::Xmlinformation("Stayigtime").'</th>
                    <th>'.functions::Xmlinformation("WachterNumber").'</th>
                    <th>'.functions::Xmlinformation("NamePassengerRepresentative").'</th>
                    <th>'.functions::Xmlinformation("Buydate").'</th>
                    <th>'.functions::Xmlinformation("Amount").'</th>
                    <th>'.functions::Xmlinformation("Status").'</th>
                    <th>'.functions::Xmlinformation("See").'</th>';
//            if ($this->IsLogin && $bookHotel[0]['status'] != 'pending') {
//                $result .= '<th>'.functions::Xmlinformation("Editbookings").'</th>';
//            }
            $result .= '
                </tr>
                </thead>
                <tbody>
            ';

            $this->FactorNumber = $bookHotel[0]['factor_number'];
            if ($bookHotel[0]['status'] == 'Requested') {
                $status = functions::Xmlinformation("Requested").' ('. functions::Xmlinformation("WaitingForAccepted") .')';
            } elseif  ($bookHotel[0]['status'] == 'RequestRejected') {
                $status = functions::Xmlinformation("RequestRejected");
            }elseif  ($bookHotel[0]['status'] == 'RequestAccepted') {
                $status = functions::Xmlinformation("RequestAccepted");
            }elseif ($bookHotel[0]['status'] == 'BookedSuccessfully') {
                $status = functions::Xmlinformation("Definitivereservation");
            } elseif ($bookHotel[0]['status'] == 'PreReserve' && $isRequest  ) {
                $status = functions::Xmlinformation("RequestAccepted");
            } else if ($bookHotel[0]['status'] == 'PreReserve'   ) {
                $status = functions::Xmlinformation("Prereservation");
            }  else if ($bookHotel[0]['status'] == 'bank') {
                $status = functions::Xmlinformation("NavigateToPort");
            } else if ($bookHotel[0]['status'] == 'OnRequest') {
                $status = functions::Xmlinformation("OnRequestedHotel");
            }else if ($bookHotel[0]['status'] == 'pending') {
                $status = functions::Xmlinformation("pendingPrintFlight");
            }else if ($bookHotel[0]['status'] == 'Cancelled') {
                $status = functions::Xmlinformation("Yourrequesthascanceledtolackof");
            }else {
                $status = functions::Xmlinformation("Unknown");
            }


                if (!$isRequest && $bookHotel[0]['hotel_payments_price'] > 0 && $bookHotel[0]['status'] == 'RequestAccepted' && $bookHotel[0]['payment_status'] == 'fullPayment' ) {
                         $price_pay = $bookHotel[0]['total_price'] - $bookHotel[0]['hotel_payments_price'];

                    $status .= '<br>
                        <a class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-main-button-color" 
                        onclick="showTypePayment(\''.$bookHotel[0]['factor_number'].'\',\''.$bookHotel[0]['type_application'].'\',\'hotelLocal\',\''.round($price_pay).'\',\''.$bookHotel[0]['serviceTitle'].'\',\''.$bookHotel[0]['currency_code'].'\',\''.$bookHotel[0]['currency_equivalent'].'\')">ادامه پرداخت</a>
                        ';
                }
//                else {
//                    $price_pay = $bookHotel[0]['total_price'];
//                    $status .= '<br>
//                        <a class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-main-button-color"
//                        onclick="showTypePayment(\''.$bookHotel[0]['factor_number'].'\',\''.$bookHotel[0]['type_application'].'\',\'hotelLocal\',\''.round($price_pay).'\',\''.$bookHotel[0]['serviceTitle'].'\',\''.$bookHotel[0]['currency_code'].'\',\''.$bookHotel[0]['currency_equivalent'].'\')">'.functions::Xmlinformation("Payment").'</a>
//                        ';
//                }
            if (!$isRequest && $bookHotel[0]['status'] == 'PreReserve' ){
                if ($bookHotel[0]['hotel_payments_price'] > 0  ) {
                    $price_pay = $bookHotel[0]['hotel_payments_price'];
                    $status .= '<br>
                        <a class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-main-button-color" 
                        onclick="showTypePayment(\''.$bookHotel[0]['factor_number'].'\',\''.$bookHotel[0]['type_application'].'\',\'hotelLocal\',\''.round($price_pay).'\',\''.$bookHotel[0]['serviceTitle'].'\',\''.$bookHotel[0]['currency_code'].'\',\''.$bookHotel[0]['currency_equivalent'].'\')">ادامه پرداخت</a>
                        ';
                }else {
                    $price_pay = $bookHotel[0]['total_price'];
                    $status .= '<br>
                        <a class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-main-button-color" 
                        onclick="showTypePayment(\''.$bookHotel[0]['factor_number'].'\',\''.$bookHotel[0]['type_application'].'\',\'hotelLocal\',\''.round($price_pay).'\',\''.$bookHotel[0]['serviceTitle'].'\',\''.$bookHotel[0]['currency_code'].'\',\''.$bookHotel[0]['currency_equivalent'].'\')">'.functions::Xmlinformation("Payment").'</a>
                        ';
                }

            }


            if ( $isRequest && $bookHotel[0]['status'] == 'PreReserve') {


                $serviceName = "hotel";
                $isRequest = ($hotelDetail['is_request'] == 1) ? 1 : 0;



                $status .= '<form action="'.ROOT_ADDRESS.'/passengersDetailReservationHotel" method="post" id="formReservationTour">
                            <input name="serviceName" type="hidden" value="' . $serviceName . '">
                            <input name="idMember" type="hidden" value="' . $bookHotel[0]['member_id'] . '">
                            <input name="memberMobile" type="hidden" value="' . $bookHotel[0]['member_mobile'] . '">
                            <input name="resumeReserve" type="hidden" value="true">
                            <input name="is_request" type="hidden" value="' . $isRequest . '">
                            <input name="factorNumber" type="hidden" value="' . $bookHotel[0]['factor_number'] . '">
                            <input name="CurrencyCode" type="hidden" value=""/>
                            <input name="href" type="hidden" value="passengersDetailReservationHotel"/>
                            <input name="typeApplication" type="hidden" value="reservation">
                            <input name="idHotel_reserve" type="hidden" value="' . $bookHotel[0]['hotel_id'] . '">
                            <input type="hidden" name="startDate_reserve" value="' . $bookHotel[0]['start_date'] . '">
                            <input type="hidden"  name="endDate_reserve" value="' . $bookHotel[0]['end_date'] . '">
                            <input name="nights_reserve" type="hidden" value="' . $bookHotel[0]['number_night'] . '">
                            <input name="IdCity_Reserve" type="hidden" value="' . $bookHotel[0]['city_id'] . '">
                            <input name="statusDiscount" type="hidden" value="' . $bookHotel[0]['discount'] . '">';
                $TypeRoomHotel = '' ;
                foreach ($bookHotel as $key => $room) {
                    $TypeRoomHotel = $TypeRoomHotel . $room['room_id'] . '/';
                    $status .= '<input name="priceRoom'.$room['room_id'].'" type="hidden" value="' . $room['room_online_price'] . '">
                            <input name="RoomCount'.$room['room_id'].'" type="hidden" value="' . $room['room_count'] . '">  
                            <input name="ExtraBed'.$room['room_id'].'" type="hidden" value="' . $room['extra_bed_count'] . '">
                            <input name="ExtraChildBed'.$room['room_id'].'" type="hidden" value="' . $room['child_count'] . '">
                            <input name="CostkolHotelRoom_EXT'.$room['room_id'].'" type="hidden" value="' . $room['extra_bed_price'] . '">
                            <input name="CostkolHotelRoom_CHD'.$room['room_id'].'" type="hidden" value="' . $room['child_price'] . '">
                            <input name="CostkolHotelRoom_DBL'.$room['room_id'].'" type="hidden" value="' . $room['room_online_price'] . '">
                            <input name="fkDBL'.$room['room_id'].'" type="hidden" value="' . $room['hotel_room_prices_id'] . '">';
                }

                $status .= '
                        <input name="TypeRoomHotel" type="hidden" value="' . $TypeRoomHotel . '">  
                        <input name="TotalNumberRoom" type="hidden" value="' . count($bookHotel) . '">
                        <button class="btn site-bg-main-color" type="submit"> '.functions::Xmlinformation('ResumeReservation').'</button>
                        </form>';

            }

            $href = ROOT_ADDRESS . "/ehotelLocal&num={$bookHotel[0]['factor_number']}";

            $href2 = ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=BookingHotelNew&id={$bookHotel[0]['factor_number']}";
            $hrefEdit = ROOT_ADDRESS . "/editReserveHotel&id={$bookHotel[0]['factor_number']}";
            $op = '<a  id="myBtn" onclick="modalListForHotel('."'".$bookHotel[0]['factor_number']."'".')" class="btn btn-primary fa fa-eye margin-10" title="'.functions::Xmlinformation("SeeBooking").'"></a>';
            if ($bookHotel[0]['status'] == 'BookedSuccessfully' ) {
              if ($bookHotel[0]['payment_status'] != 'prePayment') {

                  $op .= "<a href='{$href}' class='btn btn-dropbox fa fa-print margin-10 ' target='_blank' title='" . functions::Xmlinformation('See') . "'></a>";
                  $op .= "<a href='{$href2}' class='btn btn-info fa fa-file-pdf-o margin-10' target='_blank' title='" . functions::Xmlinformation('See') . "'></a>";
                  $op .= '<a id="cancelbyuser"  title="' . functions::Xmlinformation("RefundTicket") . '" onclick="ModalCancelUser(' . "'hotel'" . ',' . "'" . $bookHotel[0]['factor_number'] . "'" . '); return false;"  class="btn btn-danger fa fa-times"></a>';
              }else {
                  $price_pay = $bookHotel[0]['total_price'];
                  $status .= '<br>
                        <a class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-main-button-color" 
                        onclick="showTypePayment(\''.$bookHotel[0]['factor_number'].'\',\''.$bookHotel[0]['type_application'].'\',\'hotelLocal\',\''.round($price_pay).'\',\''.$bookHotel[0]['serviceTitle'].'\',\''.$bookHotel[0]['currency_code'].'\',\''.$bookHotel[0]['currency_equivalent'].'\')">'.functions::Xmlinformation("Payment").'</a>
                        ';
              }
            }

            $titleTxt = functions::Xmlinformation('Editbookings');
            $edit = "<a href='{$hrefEdit}' class='btn btn-default btn-editReserve fa fa-pencil margin-10' target='_blank' title='{$titleTxt}'>{$titleTxt}</a>";
            
            $titleTxt = functions::Xmlinformation('NoBookingEditable');
            $noEdit = "<a href='#' class='btn btn-default btn-editReserve fa fa-pencil margin-10' target='_blank' title=\"تست \">{$titleTxt}</a>";

            $paymentPrice = functions::CurrencyCalculate($bookHotel[0]['total_price'], $bookHotel[0]['currency_code'], $bookHotel['currency_equivalent']);

            $result .= '<tr>';
            $result .= '<td>' . $bookHotel[0]['city_name'] . '</td>';
            $result .= '<td>' . $bookHotel[0]['hotel_name'] . '</td>';
            $result .= '<td>' . $bookHotel[0]['start_date'] . '<br/>' . $bookHotel[0]['end_date'] . '<br/>' . $bookHotel[0]['number_night'] . '</td>';
            $result .= '<td>' . $bookHotel[0]['request_number'] . '</td>';
            $result .= '<td>' . $bookHotel[0]['passenger_leader_room_fullName'] . '</td>';
            $result .= '<td>' . $bookHotel[0]['payment_date'] . '</td>';
            $result .= '<td>' . functions::numberFormat($paymentPrice['AmountCurrency']) . ' ' . $paymentPrice['TypeCurrency'] . '</td>';
            $result .= '<td>' . $status . '</td>';
            $result .= '<td>' . $op . '</td>';
//            if ($this->IsLogin  && $bookHotel[0]['status'] != 'pending') {
//                $result .= '<td>';
//                if (in_array($bookHotel[0]['status'], $accessStatusEdit) && trim($SDate) > trim($dateNow)) {
//                    $result .= $edit;
//                } else {
//                    $result .= $noEdit;
//                }
//                $result .= '</td>';
//            }
            $result .= '</tr>';
            $result .= '</table>';

            return $result;

        }

    }

    public function getEditHotelBookingReport($factorNumber)
    {
        $Model = Load::library('Model');
        $sql = "select * from reservation_edit_hotel_booking_tb where fk_factor_number='{$factorNumber}' ORDER BY id ";
        $info = $Model->select($sql);
        if (!empty($info)){
            $this->editHotelBooking = "True";
        }else {
            $this->editHotelBooking = "False";
        }

    }

    public function infoEditBookingHotel($factorNumber)
    {
        $Model = Load::library('Model');
        $sql = "select * from reservation_edit_hotel_booking_tb where fk_factor_number='{$factorNumber}' ORDER BY id ";
        $info = $Model->select($sql);

        return $info;
    }



    public function getHotelOnRequestForAdmin()
    {
        $date = dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode = explode('-', $date);
        $date_now_int_start = dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date_now_int_end = dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);

        if (TYPE_ADMIN == '1') {
            $nameTable = 'report_hotel_tb';
        } else {
            $nameTable = 'book_hotel_local_tb';
        }
        $sql = "SELECT
                      count(id) as countReserve
                FROM {$nameTable}
                WHERE status = 'OnRequest' AND (type_application = 'api' OR type_application = 'api_app')
                ";
        $sql .= "AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";
        $sql .= " GROUP BY factor_number ";
        if (TYPE_ADMIN == '1') {
            $resultBook = $this->getModel('reportHotelModel')->load($sql);
        } else {
            $Model = Load::library('Model');
            $resultBook = $Model->load($sql);
        }

        return $resultBook['countReserve'];
    }



    public function getHotelOnRequestForAdminSpecial()
    {


       $nameTable = 'report_hotel_tb';
        $sql = "SELECT
                      count(id) as countReserve
                FROM {$nameTable}
                WHERE status = 'OnRequest' AND (type_application = 'api' OR type_application = 'api_app')
                ";
        $sql .= " GROUP BY factor_number ";
//        echo $sql;
        if (TYPE_ADMIN == '1') {
            $resultBook = $this->getModel('reportHotelModel')->load($sql);
        } else {
            $Model = Load::library('Model');
            $resultBook = $Model->load($sql);
        }

        return $resultBook['countReserve'];
    }


    public function listBookHotelLocalWebService($reportForExcel = null, $intendedUser=null)
    {

        $date = dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode = explode('-', $date);
        $date_now_int_start = dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date_now_int_end = dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);

        $tableName = (TYPE_ADMIN == '1') ? 'report_hotel_tb' : 'book_hotel_local_tb';
        $sql = "
            SELECT
                   id,
                city_name,
                hotel_id,
                hotel_name,
                payment_date,
                agency_name,
                number_night,
                start_date,
                end_date,
                factor_number,
                type_application,
                passenger_leader_room_fullName,
                `status`,
                request_number,
                pnr,
                payment_type,
                tracking_code_bank,
                total_price,
                total_price_api,
                client_id,
                member_name,
                member_mobile,
                member_id,
                agency_commission,
                type_of_price_change,
                agency_commission_price_type,
                irantech_commission,
                services_discount,
                serviceTitle,
                request_from,
                manual_book
            FROM
                {$tableName}
            WHERE
                1 = 1 
            ";


        /*if(Session::CheckAgencyPartnerLoginToAdmin())
        {
            $sql .=" AND agency_id='{$_SESSION['AgencyId']}' ";
            if (!empty($_POST['CounterId'])) {
                if ($_POST['CounterId'] != "all") {
                    $sql .= " AND member_id ='{$_POST['CounterId']}'";
                }
            }
        }*/

        if(!empty($intendedUser['member_id'])){
            $sql.=' AND member_id='.$intendedUser['member_id'].' ';
        }

        if(!empty($intendedUser['agency_id'])){
            $sql.=' AND agency_id='.$intendedUser['agency_id'].' ';
        }
        if(!empty($_POST['member_id'])){
            $sql.=' AND member_id='.$_POST['member_id'].' ';
        }

        if(!empty($_POST['agency_id'])){
            $sql.=' AND agency_id='.$_POST['agency_id'].' ';
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

        if (!empty($_POST['type_app'])) {

            if ($_POST['type_app'] == 'api') {
                $sql .= " AND type_application='api' ";
            } else if ($_POST['type_app'] == 'reservation') {
                $sql .= " AND type_application='reservation' ";
            }else if ($_POST['type_app'] == 'externalApi') {
                $sql .= " AND type_application='externalApi' ";
            }
        }

        if (!empty($_POST['factor_number'])) {
            $sql .= " AND factor_number ='{$_POST['factor_number']}'";
        }

        $sql .= " AND client_id ='299'";

        if (!empty($_POST['passenger_name'])) {
            $sql .= " AND (passenger_name LIKE '%{$_POST['passenger_name']}%' 
                    OR passenger_family LIKE '%{$_POST['passenger_name']}%')";
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

        if (!empty($_POST['StartDate'])) {
            $sql .= " AND Start_date ='{$_POST['StartDate']}'";

        }

        if (!empty($_POST['EndDate'])) {
            $sql .= " AND end_date ='{$_POST['EndDate']}'";

        }

        $get_session_sub_manage = Session::getAgencyPartnerLoginToAdmin();

        if(Session::CheckAgencyPartnerLoginToAdmin() && $get_session_sub_manage=='AgencyHasLogin'){

            $check_access = $this->getController('manageMenuAdmin')->getAccessServiceCounter(Session::getInfoCounterAdmin());

            $sql .= " AND serviceTitle IN ({$check_access})";
        }
        $sql .= " GROUP BY factor_number ORDER BY creation_date_int DESC ";

        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $BookShow = $ModelBase->select($sql);

        } else {

            $Model = Load::library('Model');
            $BookShow = $Model->select($sql);
        }

        $this->CountHotel = count($BookShow);


        $dataRows = [];
        $this->totalPriceWithoutDiscount = 0;
        $this->totalPrice = 0;
        $this->total_price_api = 0;
        $this->price = 0;
        $this->priceForMa = 0;
        $this->agencyCommissionCost = 0;
        $this->agencyCommissionPercent = 0;
        foreach ($BookShow as $k => $book) {
            $numberColumn = $k + 2;

            $expPaymentDate = [];
            if (!empty($book['payment_date'])){

                $paymentDate = functions::set_date_payment($book['payment_date']);

                $expPaymentDate = explode(" ", $paymentDate);

            }

            if (!empty($book['member_name'])){
                $memberName = $book['member_name'];
            } else {
                $memberName = $book['passenger_leader_room_fullName'];
            }

            switch ($book['type_application']){
                case 'reservation':
                    $type_application = 'هتل رزرواسیون';
                    break;
                case 'api':
                    $type_application = ($book['serviceTitle'] == 'PrivateLocalHotel') ? 'هتل اختصاصی داخلی' : 'هتل اشتراکی داخلی';
                    break;
                case 'externalApi':
                    $type_application = ($book['serviceTitle'] == 'PrivatePortalHotel') ? 'هتل اختصاصی خارجی' : 'هتل اشتراکی خارجی';
                    break;
                case 'reservation_app':
                    $type_application = 'هتل رزرواسیون (خرید از اَپلیکیشن)';
                    break;
                case 'api_app':
                    $type_application = 'هتل اشتراکی داخلی (خرید از اَپلیکیشن)';
                    break;
                default:
                    $type_application = '';
                    break;
            }



            switch ($book['status']){
                case 'BookedSuccessfully':
                    $status = 'رزرو قطعی';
                    break;
                case 'PreReserve':
                    $status = 'پیش رزرو';
                    break;
                case 'Cancelled':
                    $status = 'لغو درخواست';
                    break;
                default:
                    $status = 'نامشخص';
                    break;
            }

            $this->totalPrice = 0;
            $room = $this->InformationOfEachReservation($book['factor_number']);

            $this->totalPriceWithoutDiscount += $room['totalPriceWithoutDiscount'];
            $this->totalPrice += $room['totalPrice'];
            $this->price += $room['price'];

            if($book['type_application'] == 'externalApi' || ($book['type_application'] == 'api' && substr($book['hotel_id'], 0,2) == '17')){
                $this->totalPrice = $room['totalPrice'];
                $this->price = $room['price'];
            }
            $this->priceForMa += $room['priceForMa'];
            $agencyCommission = '';
            if ($book['agency_commission_price_type'] == 'cost') {
                $agencyCommission =  number_format($room['agencyCommission'] * $room['nights']);
                $this->agencyCommissionCost += $agencyCommission;
            }
            if ($book['agency_commission_price_type'] == 'percent'){
//                $agencyCommission = $room['agencyCommission'] . ' % ';
                $agencyCommission = number_format( $room['onlinePrice'] * $room['agencyCommission'] / 100);

                $this->agencyCommissionPercent += $room['agencyCommission'];
                $agencyCommission .= ' - <small class="badge badge-xs badge-inverse"> '.$room['agencyCommission'].'% </small>';
            }

//            $agencyCommission .= '<code style="display:none">'.json_encode(array('book'=>$book,'room'=>$room),256|64).'</code>';


            $dataRows[$k]['number_column'] = $numberColumn - 1;
            $dataRows[$k]['request_from'] = $book['request_from'];
            $dataRows[$k]['factor_number'] = $book['factor_number'] . ' ';
            $dataRows[$k]['request_number'] = $book['request_number'];

            $dataRows[$k]['member_name'] = $memberName;
            $dataRows[$k]['member_mobile'] = $book['member_mobile'];
            $dataRows[$k]['payment_date'] = $expPaymentDate[0];
            $dataRows[$k]['payment_time'] = $expPaymentDate[1];
            $dataRows[$k]['city_name'] = $book['city_name'];
            $dataRows[$k]['hotel_name'] = $book['hotel_name'];
            $dataRows[$k]['start_date'] = $book['start_date'];
            $dataRows[$k]['end_date'] = $book['end_date'];
            $dataRows[$k]['number_night'] = $book['number_night'];
            $dataRows[$k]['room_count'] = $room['roomCount'];
            $dataRows[$k]['room_excel'] = str_replace("&nbsp;", "", $room['room']);


            $dataRows[$k]['total_price_api'] =$book['total_price_api'];
            $dataRows[$k]['total_price'] = $this->totalPrice;

            $dataRows[$k]['agency_commission'] = 0;
            $dataRows[$k]['price'] = 0;
            $dataRows[$k]['onlinePrice'] = 0;
            if ($book['type_application'] == 'api' || $book['type_application'] == 'api_app' || $book['type_application'] == 'externalApi'){
                $dataRows[$k]['agency_commission'] = $agencyCommission;
                $dataRows[$k]['price'] = $room['price'];
                $dataRows[$k]['onlinePrice'] = $room['onlinePrice'];
            }

            $dataRows[$k]['type_application_fa'] = $type_application;
            $dataRows[$k]['manual_book'] = $book['manual_book'];
            $dataRows[$k]['status_fa'] = $status;



            if (!isset($reportForExcel) || (isset($reportForExcel) && $reportForExcel == 'no')){

                $dataRows[$k]['total_price_without_discount'] = $room['totalPriceWithoutDiscount'];
                $dataRows[$k]['priceForMa'] = $room['priceForMa'];
                $dataRows[$k]['id'] = $book['id'];
                $dataRows[$k]['client_id'] = $book['client_id'];
                $dataRows[$k]['member_id'] = $book['member_id'];
                $dataRows[$k]['agency_name'] = $book['agency_name'];
                $dataRows[$k]['type_application'] = $book['type_application'];
                $dataRows[$k]['status'] = $book['status'];
                $dataRows[$k]['room'] = $room['room'];
                $dataRows[$k]['irantech_commission'] = $book['irantech_commission'];
                $dataRows[$k]['services_discount'] = $book['services_discount'];

            }




        }


        return $dataRows;

    }
}

?>
