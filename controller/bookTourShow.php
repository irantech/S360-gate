<?php

/**
 * Class bookTourShow
 * @property bookTourShow $bookTourShow
 */
class bookTourShow extends clientAuth
{
    public $countTour;
    public $isLogin;
    public $FactorNumber;

    public $transactions;

    public function __construct()
    {
        $this->isLogin = Session::IsLogin();
        $this->transactions = $this->getModel('transactionsModel');
    }



    public function createExcelFile($param)
    {

        $_POST = $param;
        $resultBook = $this->listBookTourLocal('yes');
        
        if (!empty($resultBook)) {

            // برای نام گذاری سطر اول فایل اکسل //
            $firstRowColumnsHeading = ['ردیف', 'تاریخ خرید', 'ساعت خرید', 'نام خریدار', 'شماره موبایل خریدار','نام تور', 'کد تور', 'تاریخ رفت', 'تاریخ برگشت'
                , 'مدت اقامت', 'شماره فاکتور', 'قیمت بدون تخفیف', 'قیمت کل', 'قیمت پرداختی', 'جریمه کنسلی', 'قیمت کل ارزی',  'وضعیت'];
            $firstRowWidth = [10, 10, 10, 15, 15, 10, 10,10, 15, 15,15, 20,
                15,15,15,15,15,15,10 , 10 , 10 , 10];
            $objCreateExcelFile = Load::controller('createExcelFile');
            $dataRows = [];
            foreach ($resultBook as $k => $book) {
                $numberColumn = $k + 2;
                $dataRows[$k]['number_column'] = $numberColumn - 1;
                $dataRows[$k]['payment_date'] = $book['payment_date'];
                $dataRows[$k]['payment_time'] = $book['payment_time'];
                $dataRows[$k]['member_name'] = $book['member_name'];
                $dataRows[$k]['member_mobile'] = $book['member_mobile'];
                $dataRows[$k]['tour_name'] = $book['tour_name'];
                $dataRows[$k]['tour_code'] = $book['tour_code'];
                $dataRows[$k]['tour_start_date'] = $book['tour_start_date'];
                $dataRows[$k]['tour_end_date'] = $book['tour_end_date'];
                $dataRows[$k]['tour_night'] = $book['tour_night'];
                $dataRows[$k]['factor_number'] = $book['factor_number'].' ';
                $dataRows[$k]['price'] = $book['price'];
                $dataRows[$k]['tour_total_price'] = $book['tour_total_price'];
                $dataRows[$k]['tour_payments_price'] = $book['tour_payments_price'];
                $dataRows[$k]['cancellation_price'] = $book['cancellation_price'];
                $dataRows[$k]['tour_payments_price_a'] = $book['tour_payments_price_a'];
                $dataRows[$k]['status_fa'] = $book['status_fa'];
            }
            $resultExcel = $objCreateExcelFile->create($dataRows, $firstRowColumnsHeading , $firstRowWidth);
            if ($resultExcel['message'] == 'success'){
                return 'success|' . $resultExcel['fileName'];
            } else {
                return 'error|متاسفانه در ساخت فایل اکسل مشکلی پیش آمده. لطفا مجددا تلاش کنید';
            }


        } else {
            return 'error|اطلاعاتی برای ساخت فایل اکسسل وجود ندارد.';
        }


    }


    public function listBookTourLocal($reportForExcel = null, $intendedUser=null)
    {
        $reservationTourController=$this->getController('reservationTour');
  
        $date = dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode = explode('-', $date);
        $date_now_int_start = dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date_now_int_end = dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);

        if (TYPE_ADMIN == '1') {
            $sql = "SELECT * FROM report_tour_tb  WHERE 1=1 ";

        } else {
            $sql = "SELECT * FROM book_tour_local_tb WHERE 1=1 ";

        }

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

        $get_session_sub_manage = Session::getAgencyPartnerLoginToAdmin();

        if(Session::CheckAgencyPartnerLoginToAdmin() && $get_session_sub_manage=='AgencyHasLogin'){

            $check_access = $this->getController('manageMenuAdmin')->getAccessServiceCounter(Session::getInfoCounterAdmin());
       
            if($check_access){
                $sql .= " AND serviceTitle IN ({$check_access})";
            }

        }

        $sql .= " GROUP BY factor_number ORDER BY creation_date_int DESC ";


        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $BookShow = $ModelBase->select($sql);

        } else {
            Load::autoload('Model');
            $Model = new Model();

            $BookShow = $Model->select($sql);
        }

        $this->countTour = count($BookShow);


        $dataRows = [];
        $this->totalPrice = 0;
        $this->payment_price = 0;
        foreach ($BookShow as $k => $book) {

            $changePrice=$reservationTourController->getRequestPriceChanged($book['factor_number']);

            $numberColumn = $k + 2;

            $expPayment_date = [];
            if (!empty($book['payment_date'])){
                $payment_date = functions::set_date_payment($book['payment_date']);
                $expPayment_date = explode(" ", $payment_date);
            }
            $user_type = functions::TypeUser($book['member_id']);
            $user_type = $user_type == 'Counter' ? 'کانتر' : 'مسافر انلاین';

            if (!empty($book['member_id']) && !empty($book['tour_agency_id'])){
                $member_name = $book['member_name'] . '( ' . $user_type . ' ) ';
            } else {
                $member_name = 'مسافر انلاین';
            }


            if ($book['tour_total_price_a'] == 0 && $book['status'] == 'BookedSuccessfully') {
                $status = 'رزرو قطعی';
            } elseif ($book['tour_total_price_a'] > 0 && $book['tour_total_price_a'] == $book['tour_payments_price_a'] && $book['status'] == 'BookedSuccessfully'){
                $status = 'رزرو قطعی';
            } elseif ($book['tour_total_price_a'] > 0 && $book['tour_total_price_a'] > $book['tour_payments_price_a'] && $book['status'] == 'BookedSuccessfully'){
                $status = 'رزرو قطعی  ( بدون پرداخت مبلغ ارزی)';
            } elseif ($book['status'] == 'PreReserve'){
                $status = 'پیش رزرو (تایید شده توسط کانتر)';
            } elseif ($book['status'] == 'TemporaryReservation'){
                $status = 'رزرو موقت (پرداخت مبلغ پیش رزرو)';
            } elseif ($book['status'] == 'TemporaryPreReserve'){
                $status = 'پیش رزرو موقت';
            } elseif ($book['status'] == 'bank' && $book['tracking_code_bank'] == ''){
                $status = 'پرداخت اینترنتی نا موفق';
            } elseif ($book['status'] == 'Cancellation'){
                $status = 'کنسلی';
            } else {
                $status = 'نامشخص';
            }


            if ($book['cancel_status'] == 'CancellationRequest'){
                $status .= ' (درخواست کنسلی از طرف مسافر) ';
            } elseif ($book['cancel_status'] == 'ConfirmCancellationRequest'){
                $status .= ' (تایید درخواست کنسلی از طرف کارگزار) ';
            }

            $dataRows[$k]['number_column'] = $numberColumn - 1;
            $dataRows[$k]['payment_date'] = $expPayment_date[0];
            $dataRows[$k]['payment_time'] = $expPayment_date[1];
            $dataRows[$k]['member_name'] = $member_name;
            $dataRows[$k]['member_mobile'] = $book['member_mobile'];
            $dataRows[$k]['tour_id'] = $book['tour_id'];
            $dataRows[$k]['tour_name'] = $book['tour_name'];
            $dataRows[$k]['tour_code'] = $book['tour_code'];
            $dataRows[$k]['tour_start_date'] = $book['tour_start_date'];
            $dataRows[$k]['tour_end_date'] = $book['tour_end_date'];
            if ($book['tour_night'] > 0){
                $dataRows[$k]['tour_night'] = $book['tour_night'] . ' شب ';
            } else {
                $dataRows[$k]['tour_night'] = '';
            }
            if ($book['tour_day'] > 0){
                $dataRows[$k]['tour_night'] .= $book['tour_day'] . ' روز ';
            }
            $dataRows[$k]['factor_number'] = $book['factor_number'];
            if ($book['price'] != '' && $book['price'] != $book['total_price']){
                $dataRows[$k]['price'] = $book['price'] . ' ';
            } else {
                $dataRows[$k]['price'] = '';
            }
            $dataRows[$k]['tour_total_price'] = $book['tour_total_price']. ' ';
            $dataRows[$k]['changed_tour_total_price'] = $book['total_price']. ' ';
            $dataRows[$k]['tour_origin_price'] = $book['tour_origin_price']. ' ';
            $dataRows[$k]['changed_tour_origin_price'] = $book['tour_origin_price']. ' ';
            $dataRows[$k]['tour_payments_price'] = $book['tour_payments_price'] > 0 ? $book['tour_payments_price'] :  $book['total_price']. ' ';
            $dataRows[$k]['cancellation_price'] = $book['cancellation_price']. ' ';
            $dataRows[$k]['tour_total_price_a'] = $book['tour_total_price_a'] . ' ' . $book['currency_title_fa']. ' ';
            $dataRows[$k]['tour_payments_price_a'] = $book['tour_payments_price_a'] . ' ' . $book['currency_title_fa']. ' ';
            $dataRows[$k]['status_fa'] = $status. ' ';

            if (!isset($reportForExcel) || (isset($reportForExcel) && $reportForExcel == 'no')){

                $dataRows[$k]['agency_name'] = $book['agency_name'];
                $dataRows[$k]['status'] = $book['status'];
                $dataRows[$k]['cancel_status'] = $book['cancel_status'];
                $dataRows[$k]['tour_discount'] = $book['tour_discount'];
                $dataRows[$k]['tour_sdiscount_type'] = $book['tour_discount_type'];
                $dataRows[$k]['total_price'] = $book['total_price'];

                $dataRows[$k]['changed_total_price']= $book['total_price'] + $changePrice;

            }
         
            $this->totalPrice += $book['total_price'];
            $this->payment_price += $book['status'] == 'BookedSuccessfully' ? $book['total_price'] :  $book['tour_payments_price'];

        }

        //echo Load::plog($dataRows);
        return $dataRows;


    }
	
	public function info_tour_client( $factor_number ) {
		$Model = Load::library('Model');
		
		$sql = " SELECT * FROM book_tour_local_tb WHERE factor_number='{$factor_number}' ";
		$book = $Model->load($sql);
    
    }

    public function tourInfoTracking($factor_number)
    {
         

        $Model = Load::library('Model');
        /** @var resultTourLocal $resultTourLocalController */
        $resultTourLocalController=Load::controller('resultTourLocal');
        if(SOFTWARE_LANG === 'fa'){
            $index_name='name';
            $index_name_tag='name_fa';
            $index_city='city_name';
        }else{
            $index_name=$index_name_tag='name_en';
            $index_city='city_name_en';


        }
          $sql = " SELECT * FROM book_tour_local_tb WHERE factor_number='{$factor_number}' ";
        $book = $Model->load($sql);

        $resultTourLocalController->getInfoTourByIdTour($book['tour_id']);
        $tourDetail=$resultTourLocalController->arrayTour['infoTour'];
     
        $isRequest=false;
        if($tourDetail['is_request'] =='1')
            $isRequest=true;

        $result = '';

        if (!empty($book)) {

            $result .= '
            <table class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>'.functions::Xmlinformation("Tour").'</th>
                    <th>'.functions::Xmlinformation("Origin").'<br/>'.functions::Xmlinformation("Destination").'</th>
                    <th>'.functions::Xmlinformation("Enterdate").'<br/>'.functions::Xmlinformation("Stayigtime").'</th>
                    <th>'.functions::Xmlinformation("Invoicenumber").'<br/>'.functions::Xmlinformation("Buydate").'</th>
                    <th>'.functions::Xmlinformation("Totalamount").'<br/>'.functions::Xmlinformation("Paymentamount").'</th>
                    <th>'.functions::Xmlinformation("Status").'</th>
                    <th>'.functions::Xmlinformation("action").'</th>
                    <th>'.functions::Xmlinformation("See").'</th>
                </tr>
                </thead>
                <tbody>
            ';

            $this->FactorNumber = $book['factor_number'];



            if ($book['status'] == 'BookedSuccessfully') {
                $status = functions::Xmlinformation("Definitivereservation")->__toString();
            } elseif ($book['status'] == 'PreReserve') {
                $status = functions::Xmlinformation("Prereservation")->__toString().' ('.functions::Xmlinformation("ConfirmedCounter")->__toString().')';
            } elseif ($book['status'] == 'TemporaryReservation') {
                $status = functions::Xmlinformation("Temporaryreservation")->__toString().' ('.functions::Xmlinformation("Paymentprebookingamount")->__toString().') ';
            } elseif ($book['status'] == 'TemporaryPreReserve') {
                $status = functions::Xmlinformation("TemporaryPreReserve")->__toString();
            } elseif ($book['status'] == 'bank') {
                $status = functions::Xmlinformation("NavigateToPort")->__toString();
            }elseif ($book['status'] == 'Cancellation') {
                $status = functions::Xmlinformation("Cancel")->__toString();
            }elseif ($book['status'] == 'Requested') {
                $status = functions::Xmlinformation("Requested")->__toString().' <span class="badge badge-warning">'.functions::Xmlinformation("WaitForAcceptation")->__toString().'</span>';
            }
            elseif ($book['status'] == 'RequestAccepted') {
                $status = functions::Xmlinformation("RequestAccepted")->__toString().' <span class="badge badge-success">'.functions::Xmlinformation("PleaseFillPassengersData")->__toString().'</span>';
            }
            elseif ($book['status'] == 'RequestRejected') {
                $status = functions::Xmlinformation("RequestRejected")->__toString();
            }else {
                $status = functions::Xmlinformation("Unknown")->__toString();
            }


            $reservationTourController=$this->getController('reservationTour');
            $priceChanged=$reservationTourController->getRequestPriceChanged($this->FactorNumber);


            $href = ROOT_ADDRESS . "/eTourReservation&num={$book['factor_number']}";
            $href2 = ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=BookingTourLocal&id={$book['factor_number']}";
            $op = '<a  id="myBtn" onclick="modalListForTour('."'".$book['factor_number']."'".')" class="btn btn-primary fa fa-eye margin-10" title="مشاهده رزرو"></a>';
            if ($book['status'] == 'BookedSuccessfully'
                || $book['status'] == 'PreReserve') {
                $op .= "<a href='{$href}' class='btn btn-dropbox fa fa-print margin-10 ' target='_blank' title='".functions::Xmlinformation('See')."'></a>";
                $op .= "<a href='{$href2}' class='btn btn-info fa fa-file-pdf-o margin-10' target='_blank' title='".functions::Xmlinformation('ViewPDFReservation')."'></a>";

            }
            if ( $isRequest && $book['status'] == 'RequestAccepted') {


                $serviceName = "tour";
                $isRequest = ($tourDetail['is_request'] == 1) ? 1 : 0;
                $tourCode = $tourDetail['tour_code'];
                $tourId = $book['tour_id'];
                $cities = $resultTourLocalController->arrayTour['destination_cities'];
                $serviceTitle = $resultTourLocalController->arrayTour['serviceTitle'];
                $prepaymentPercentage = $tourDetail['prepayment_percentage'];

                $tourTypeIdArray = json_decode($tourDetail['tour_type_id'], true);
                if (in_array(1, $tourTypeIdArray)) {
                    $typeTourReserve = "oneDayTour";
                } else {
                    $typeTourReserve = "noOneDayTour";
                }



                $tour_package_data = json_decode($book['tour_package'], true);

                $coefficients = [
                    'single_room' => 1,
                    'double_room' => 2,
                    'three_room' => 3,
                    'child_with_bed' => 1,
                    'infant_without_bed' => 1,
                    'infant_without_chair' => 1,
                ];
                $adult_count = 0;
                $child_count = 0;
                $infant_count = 0;

                if($typeTourReserve == "noOneDayTour")
                {
                    foreach ($tour_package_data['infoRooms'] as $room_name => $room_info) {
                        switch ($room_name) {
                            case 'double_room':
                            case 'single_room':
                            case 'three_room':
                                // These rooms have adult occupants
                                $adult_count += $room_info['count'] * $coefficients[$room_name];
                                break;
                            case 'child_with_bed':
                                // These rooms have children with beds
                                $child_count += $room_info['count'] * $coefficients[$room_name];
                                break;
                            case 'infant_without_bed':
                                // These rooms have infants without beds
                                $infant_count += $room_info['count'] * $coefficients[$room_name];
                                break;
                            case 'infant_without_chair':
                                // These rooms have infants without chairs
                                $infant_count += $room_info['count'] * $coefficients[$room_name];
                                break;
                            default:
                                // Unknown room type
                                break;
                        }
                    }
                }else{
                    $detail_count = json_decode($book['tour_package'],true);
                    $adult_count = $detail_count['adult_count_oneDayTour'];
                    $child_count = $detail_count['child_count_oneDayTour'];
                    $infant_count = $detail_count['infant_count_oneDayTour'];
                }


                // Define the mapping between the room types and their indices
                $roomTypes = [
                    'single_room' => 'oneBed',
                    'double_room' => 'twoBed',
                    'three_room' => 'threeBed',
                    'child_with_bed' => 'childwithbed',
                    'infant_without_bed' => 'babywithoutbed',
                    'infant_without_chair' => 'babywithoutchair',
                ];

                // Initialize an array to store the count of each room type
                $roomCounts = array_fill_keys(array_values($roomTypes), 0);

                // Extract the count of each room type from the JSON data
                 if (isset($tour_package_data['infoRooms'])) {
                    foreach ($tour_package_data['infoRooms'] as $roomType => $roomData) {
                        if (isset($roomTypes[$roomType])) {
                            $roomIndex = $roomTypes[$roomType];
                            $roomCounts[$roomIndex] = (int)$roomData['count'];
                        }
                    }
                }

                // Convert the room counts to the desired string format
                $roomCountStr = '';
                foreach ($roomCounts as $roomIndex => $roomCount) {
                    if ($roomCount > 0) {
                        $roomCountStr .= $roomIndex . ':' . $roomCount . '|';
                    }
                }



                $prepayment=$book['total_price']+$priceChanged;

                $op .= '<form action="'.ROOT_ADDRESS.'/passengerDetailReservationTour" method="post" id="formReservationTour">
                            <input name="serviceName" type="hidden" value="' . $serviceName . '">
                            <input name="idMember" type="hidden" value="' . $book['member_id'] . '">
                            <input name="memberMobile" type="hidden" value="' . $book['member_mobile'] . '">
                            <input name="factor_number" type="hidden" value="' . $this->FactorNumber . '">
                            <input id="is_request" type="hidden" value="' . $isRequest . '">
                            <input name="selectDate" type="hidden" value="' . $book['tour_start_date'].'|'.$book['tour_end_date'] . '">
                            <input id="tourCode" name="tourCode" type="hidden" value="' . $tourCode . '">
                            <input id="tour_id" name="tour_id" type="hidden" value="' . $tourId . '">
                            <input type="hidden" id="cities" name="cities" value="' . $cities . '">
                            <input type="hidden" id="serviceTitle" name="serviceTitle" value="' . $serviceTitle . '">
                            <input type="hidden" id="prepaymentPercentage" name="prepaymentPercentage" value="' . $prepaymentPercentage . '">
                            <input type="hidden" name="totalOriginPrice" value="'.$book['tour_total_price'].'">
                            <input type="hidden" name="totalPrice" value="'.$book['tour_total_price'].'">
                            <input type="hidden" name="totalPriceA" value="0">
                            <input type="hidden" name="paymentPrice" value="'.$book['tour_payments_price'].'">
                            <input type="hidden" name="passengerCount" value="'.($adult_count+$child_count+$infant_count).'">
                            <input type="hidden" name="passengerCountADT" value="'.$adult_count.'">
                            <input type="hidden" name="passengerCountCHD" value="'.$child_count.'">
                            <input type="hidden" name="passengerCountINF" value="'.$infant_count.'">
                            <input type="hidden" name="countRoom" value="'.$roomCountStr.'">
                            <input type="hidden" value="' . $typeTourReserve . '" name="typeTourReserve">
                            <input type="hidden" data-name="has-package-index" value="'.$tour_package_data['id'].'" id="packageId" name="packageId">
                             <button class="btn site-bg-main-color" type="submit"> '.functions::Xmlinformation('ResumeReservation').'</button>
                        </form>';

            }

            if ($book['passengers_file_tour'] != ''){
                $arrayFile = json_decode($book['passengers_file_tour']);
                $n = 0;
                foreach ($arrayFile as $file){
                    $n++;
                    $op .= '<hr style="border: 1px dashed #d1d1d1;">
                        <span>
                            <a id="downloadLink" href="'.ROOT_ADDRESS_WITHOUT_LANG.'/pic/reservationTour/passengersImages/'.$file.'" target="_blank"
                               type="application/octet-stream"><i class="fa fa-download"></i> '.functions::Xmlinformation('file') . ' ' . $n . '
                            </a>
                        </span>';
                }

            }

            $operation = '';
            if ($book['status'] == 'PreReserve'){
                $price = $book['tour_total_price'] - $book['tour_payments_price'];
                $operation .= '
                        <a href="#" class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-main-button-color" style="font-size: 12px !important;"
                        onclick="showTypePaymentForTour(\''.$book['factor_number'].'\',\'tourLocal\',\''.$price.'\',\''.$book['serviceTitle'].'\',\''.$book['currency_code'].'\',\''.$book['currency_equivalent'].'\');return false">انتخاب نوع پرداخت</a>
                        <br/>';
            }

            if ($book['cancel_status'] == '' && ($book['status'] == 'PreReserve'
                || $book['status'] == 'TemporaryReservation' || $book['status'] == 'BookedSuccessfully')){

                $result_isReserveByStopTime = functions::isReserveByStopTime($book['tour_exit_hour'], $book['tour_stop_time_cancel'], $book['tour_start_date']);
                if ($result_isReserveByStopTime){
                    $operation .= '
                        <a href="#" class="btn btn-cancel fa margin-10" onclick="tourCancellationRequest(\''.$book['factor_number'].'\');return false">'.functions::Xmlinformation('ReservationCancellationRequest').'</a>
                        ';
                }

            } elseif ($book['cancel_status'] == 'ConfirmCancellationRequest'){
                $operation .= '
                        <b>'.functions::Xmlinformation('ConsoleFines').' ' . number_format($book['cancellation_price']) .' '.functions::Xmlinformation('Rial').'</b>
                        <br/>
                        <a href="#" class="btn btn-cancel fa margin-10" onclick="successfullyCancel(\''.$book['factor_number'].'\');return false">'.functions::Xmlinformation('FinalRegistrationCancellationTour').'</a>
                        ';
            }

            //$paymentPrice = functions::CurrencyCalculate($book['total_price'], $book['currency_code'], $book['currency_equivalent']);

            $result .= '<tr>';
            $result .= '<td>' . $book['tour_name'] . '</td>';


            if(SOFTWARE_LANG === 'fa'){
                $result .= '<td>' . $resultTourLocalController->arrayTour['infoTour']['country_name'] . ' - ' . $resultTourLocalController->arrayTour['infoTour']['name'] . ' - ' . $book['tour_origin_region_name'] . '<hr style="color: #f8f8f8;">';
            }else{
                $result .= '<td>' . $resultTourLocalController->arrayTour['infoTour']['country_name_en'] . ' - ' . $resultTourLocalController->arrayTour['infoTour']['name_en'] . ' - ' . $book['tour_origin_region_name'] . '<hr style="color: #f8f8f8;">';
            }
            $cities=[];
            foreach($resultTourLocalController->arrayTour['infoTourRout'] as $route)
            {
                $cities[] = $route[$index_name];

            }


            $result .= join(', ',$cities) . '</td>';
            $result .= '<td>' . $book['tour_start_date'] . '<hr style="color: #f8f8f8;">';
            if ($book['tour_night'] > 0) {
                $result .= $book['tour_night'] . ' '.functions::Xmlinformation('Night').' ';
            } else {
                $result .= $book['tour_day'] . ' '.functions::Xmlinformation('Day').' ';
            }
            $result .= '</td>';
            $result .= '</td>';
            $result .= '<td>' . $book['factor_number'] . '<hr style="color: #f8f8f8;">';
            $result .= $book['payment_date'] . '</td>';
            $result .= '<td>' . number_format($book['tour_total_price']) . '<hr style="color: #f8f8f8;">';

            if($priceChanged > 0){
                $result .= 'افزایش قیمت ' . number_format($priceChanged).'<hr style="color: #f8f8f8;">' ;
            }
            $result.=number_format($book['tour_payments_price']) ;

            $result.='</td>';
            $result .= '<td>' . $status . '</td>';
            $result .= '<td>' . $operation . '</td>';
            $result .= '<td>' . $op . '</td>';
            $result .= '</tr>';
            $result .= '</table>';

            return $result;

        }

    }

    public function userBuyTour($id, $status = null)
    {
        $today = dateTimeSetting::jtoday('');
        $Model = Load::library('Model');
        $sql = "SELECT * "
            . " FROM book_tour_local_tb "
            . " WHERE tour_agency_user_id='{$id}' ";
        if (isset($status) && $status == 'TemporaryReservation') {
            $sql .= " AND status='TemporaryReservation' ";
        }elseif (isset($status) && $status == 'CancellationRequest'){
            $sql .= " AND cancel_status='CancellationRequest' ";
        }
        $sql .= " GROUP BY factor_number ORDER BY creation_date_int DESC ";
        $buy = $Model->select($sql);

        return $buy;

    }





    #region tourCancellationRequest
    public function tourCancellationRequest($factorNumber)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $smsController = Load::controller('smsServices');

        $data['cancel_status'] = 'CancellationRequest';

        $condition = "factor_number='{$factorNumber}'";
        $Model->setTable('book_tour_local_tb');
        $res = $Model->update($data, $condition);

        $ModelBase->setTable('report_tour_tb');
        $resBase = $ModelBase->update($data, $condition);

        if ($res && $resBase) {

            $infoBook = functions::GetInfoTour($factorNumber);
            //sms to member
            $smsMember = " ".functions::Xmlinformation('DearCounter')." " . PHP_EOL . "{$infoBook['tour_agency_user_name']}" ." ".functions::Xmlinformation('RequestCancellationTourBooking')." " . $infoBook['tour_name'] . " ". functions::Xmlinformation('LookingForwardExaminingFixingConstellationFine')." " ;
            $smsMember .= PHP_EOL . functions::Xmlinformation('Invoicenumber')." : " . $factorNumber;
            $objSms = $smsController->initService('0');
            if ($objSms) {
                $smsArray = array(
                    'smsMessage' => $smsMember,
                    'cellNumber' => $infoBook['tour_agency_user_mobile']
                );
                $smsController->sendSMS($smsArray);
            }


            //sms to site manager
            $smsManager = " ".functions::Xmlinformation('DearChief')." " . CLIENT_NAME ." ".functions::Xmlinformation('RequestCancellationTourBooking')." " . $infoBook['tour_name'] . " ".functions::Xmlinformation('RegisteredByBuyer')." " ;
            $smsManager .= PHP_EOL . functions::Xmlinformation('Invoicenumber')." : " . $factorNumber;
            $objSms = $smsController->initService('1');
            if ($objSms) {
                $smsArray = array(
                    'smsMessage' => $smsManager,
                    'cellNumber' => CLIENT_MOBILE
                );
                $smsController->sendSMS($smsArray);
            }


            return 'success : '.functions::Xmlinformation('CancelTourReservationWasSucceeded');
        } else {
            return 'error : '.functions::Xmlinformation('ErrorRemovingChanges');
        }
    }
    #endregion



    #region tourConfirmCancellationRequest
    public function tourConfirmCancellationRequest($factorNumber, $cancelPrice)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $infoBook = functions::GetInfoTour($factorNumber);
        $cancelPrice = str_replace(",", "", $cancelPrice);
        if ($cancelPrice > $infoBook['tour_total_price']){

            return 'error : '.functions::Xmlinformation("CancellationCanNotGreaterAmountBooking");

        } elseif ($cancelPrice > 0) {

            $data['cancel_status'] = 'ConfirmCancellationRequest';
            $data['cancellation_price'] = $cancelPrice;

            $condition = "factor_number='{$factorNumber}'";
            $Model->setTable('book_tour_local_tb');
            $res = $Model->update($data, $condition);

            $ModelBase->setTable('report_tour_tb');
            $resBase = $ModelBase->update($data, $condition);

            if ($res && $resBase) {

                $smsController = Load::controller('smsServices');
                //sms to buyer
                $objSms = $smsController->initService('0');
                if ($objSms) {
                    $mobile = $infoBook['member_mobile'];
                    $name = $infoBook['passenger_name'] . ' ' . $infoBook['passenger_family'];

                    $messageVariables = array(
                        'sms_name' => $name,
                        'sms_service' => 'تور',
                        'sms_factor_number' => $factorNumber,
                        'sms_cost' => $infoBook['total_price'],
                        'sms_tour_name' => $infoBook['tour_name'],
                        'sms_tour_night' => $infoBook['tour_night'],
                        'sms_tour_day' => $infoBook['tour_day'],
                        'sms_tour_cities' => $infoBook['tour_cities'],
                        'sms_tour_dept_date' => $infoBook['tour_start_date'],
                        'sms_tour_return_date' => $infoBook['tour_end_date'],
                        'sms_pdf' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=BookingTourLocal&id=" . $factorNumber,
                        'sms_agency' => CLIENT_NAME,
                        'sms_agency_mobile' => CLIENT_MOBILE,
                        'sms_agency_phone' => CLIENT_PHONE,
                        'sms_agency_email' => CLIENT_EMAIL,
                        'sms_agency_address' => CLIENT_ADDRESS,
                    );
                    $smsArray = array(
                        'smsMessage' => $smsController->getUsableMessage('confirmCancelTourReserve', $messageVariables),
                        'cellNumber' => $mobile,
                        'smsMessageTitle' => 'confirmCancelTourReserve',
                        'memberID' => (!empty($infoBook['member_id']) ? $infoBook['member_id'] : ''),
                        'receiverName' => $messageVariables['sms_name'],
                    );

                    $smsController->sendSMS($smsArray);

                }


                return 'success : '.functions::Xmlinformation("ConfirmationCancellationRequestSuccessfully");
            } else {
                return 'error : '.functions::Xmlinformation("ErrorRemovingChanges");
            }

        } else {
            return 'error : '.functions::Xmlinformation("PleaseEnterCancellationAmount");
        }

    }
    #endregion




    #region successfullyCancel
    public function successfullyCancel($factorNumber)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $this->delete_transaction_current($factorNumber);

        $infoBook = functions::GetInfoTour($factorNumber);
        $cancelPrice = $infoBook['cancellation_price'];
        $sms = " ".functions::Xmlinformation('DearTraveler')." " . "{$infoBook['passenger_name']}" . " " . "{$infoBook['passenger_family']}" . " ".functions::Xmlinformation('CannesTourReservation')." " . $infoBook['tour_name'] . " ".functions::Xmlinformation('SuccessfullyRecorded')." " ;

        $price = $infoBook['tour_payments_price'] - $cancelPrice;
        //$tour_payments_price = $infoBook['tour_payments_price'];

        $typeMember = functions::TypeUser($infoBook['member_id']);
        if ($typeMember == 'Counter' && $price > 0){

            // به خریدار باید برگردانده شود.
            $detail['fk_agency_id'] = $infoBook['agency_id'];
            $detail['credit'] = $price;
            $detail['type'] = 'increase';
            $detail['comment'] = " ".functions::Xmlinformation('CancellationReservationBookingCreditEnhancementNumber')." " . $factorNumber;
            $detail['credit_date'] = dateTimeSetting::jdate("Y-m-d", time());
            $detail['reason'] = 'deposit';
            $detail['creation_date_int'] = time();
            $detail['member_id'] = $infoBook['member_id'];
            $detail['requestNumber'] = $factorNumber;

            $Model->setTable('credit_detail_tb');
            $Model->insertLocal($detail);

            $comment = functions::Xmlinformation("IncreasingCreditBuyer");
            //$tour_payments_price = $infoBook['tour_payments_price'] - $price;


            $sms .= PHP_EOL . " ".functions::Xmlinformation('YourCredit')." " . $price . " ".functions::Xmlinformation('XRialIncrease')." ";

        } else if ($typeMember == 'Counter' && $price < 0) {

            // مبلغ باقی مانده را خریدار باید پرداخت کند.
            $p = $cancelPrice - $infoBook['tour_payments_price'];

            $detail['fk_agency_id'] = $infoBook['agency_id'];
            $detail['credit'] = $p;
            $detail['type'] = "decrease";
            $detail['comment'] = " ".functions::Xmlinformation('CancellationBookingReservationPenaltyNumber')." " . $factorNumber;
            $detail['credit_date'] = dateTimeSetting::jdate("Y-m-d", time());
            $detail['reason'] = 'deposit';
            $detail['creation_date_int'] = time();
            $detail['member_id'] = $infoBook['member_id'];
            $detail['requestNumber'] = $factorNumber;

            $Model->setTable('credit_detail_tb');
            $Model->insertLocal($detail);



            $objMember = Load::controller('members');
            // Caution: اعتبار همکار(آژانس همکار با صاحب پنل ) که ممکنه  خود صاحب سیستم باشد یا همکار دیگری که کانتری که خرید میکند شامل این همکار است
            $counterCredit = $objMember->getCredit();
            // Caution: اعتبارسنجی اعتبار کانتر
            if ($counterCredit > $p) {
                $comment = functions::Xmlinformation("ReducingAmountBuyer");
                //$tour_payments_price = $infoBook['tour_payments_price'] + $p;

                $sms .= PHP_EOL . " ".functions::Xmlinformation('OfYourCredit')." " . $p . " ".functions::Xmlinformation('RialsPickedUp')." ";
            } else {
                $comment = functions::Xmlinformation("CreditorBuyerAmount"). number_format($p) . functions::Xmlinformation("Rial");

                $sms .= PHP_EOL . functions::Xmlinformation("LackSufficientCreditYouPaid") . $p . functions::Xmlinformation("RialDebtorAgent");
            }

        } else if ($typeMember != 'Counter' && $price > 0){

            $comment = functions::Xmlinformation("DebtorBuyerAmount").': ' . number_format($price) . functions::Xmlinformation("Rial");
            $sms .= PHP_EOL . functions::Xmlinformation("BrokerageAmount") . $price . functions::Xmlinformation("RialOwedYou");

        } else if ($typeMember != 'Counter' && $price < 0){

            $p = $cancelPrice - $infoBook['tour_payments_price'];
            $comment = functions::Xmlinformation("CreditorBuyerAmount").': ' . number_format($p) . functions::Xmlinformation("Rial");
            $sms .= PHP_EOL . functions::Xmlinformation("YouMustAmount") . $p . functions::Xmlinformation("RialDebtor");


        } else if ($price == 0) {
            $comment = functions::Xmlinformation("AmountCancellationPenaltyEqualAmount");
        }


        $data['cancellation_comment'] = $comment;
        $data['cancel_status'] = 'successfullyCancel';
        $data['status'] = 'Cancellation';
        //s$data['tour_payments_price'] = $tour_payments_price;

        $condition = "factor_number='{$factorNumber}'";
        $Model->setTable('book_tour_local_tb');
        $res = $Model->update($data, $condition);

        $ModelBase->setTable('report_tour_tb');
        $resBase = $ModelBase->update($data, $condition);

        if ($res && $resBase) {

            $smsController = Load::controller('smsServices');

            //sms to buyer
            $sms .= PHP_EOL . functions::Xmlinformation("Invoicenumber")." : " . $factorNumber;
            $sms .= PHP_EOL . functions::Xmlinformation("ThanksPublicRelationsSite")." (" . CLIENT_NAME . ")" ;
            $sms .= PHP_EOL . functions::Xmlinformation("SupportNumber")." : " . PHP_EOL . "021" . CLIENT_PHONE ;
            $objSms = $smsController->initService('0');
            if ($objSms) {
                $smsArray = array(
                    'smsMessage' => $sms,
                    'cellNumber' => $infoBook['member_mobile']
                );
                $smsController->sendSMS($smsArray);
            }


            //sms to site manager
            $smsManager = functions::Xmlinformation("DearChief") . CLIENT_NAME ." ".functions::Xmlinformation("RequestTourReservation")." " . $infoBook['tour_name'] . functions::Xmlinformation("Canceled") ;
            $smsManager .= $comment;
            $smsManager .= PHP_EOL . functions::Xmlinformation("DebtorBuyerAmount")." : " . $factorNumber;
            $objSms = $smsController->initService('1');
            if ($objSms) {
                $smsArray = array(
                    'smsMessage' => $smsManager,
                    'cellNumber' => CLIENT_MOBILE
                );
                $smsController->sendSMS($smsArray);
            }

            return 'success : '.functions::Xmlinformation("CancelTourReservationWasSucceeded");
        } else {
            return 'error : '.functions::Xmlinformation("ErrorRemovingChanges");
        }

    }
    #endregion




    public function delete_transaction_current($factorNumber)
    {
        $Model = Load::library('Model');
        $data['PaymentStatus'] = 'pending';
        $condition = "FactorNumber = '{$factorNumber}' AND FactorNumber !=''";
        $Model->setTable('transaction_tb');
        $Model->update($data, $condition);
        $this->transactions->updateTransaction($data,$condition);
    }




    #region setTourPaymentsPriceA
    public function setTourPaymentsPriceA($factorNumber, $paymentsPriceA)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $data['tour_payments_price_a'] = $paymentsPriceA;

        $condition = "factor_number='{$factorNumber}'";
        $Model->setTable('book_tour_local_tb');
        $res = $Model->update($data, $condition);

        $ModelBase->setTable('report_tour_tb');
        $resBase = $ModelBase->update($data, $condition);

        if ($res && $resBase) {

            $smsController = Load::controller('smsServices');
            $infoBook = functions::GetInfoTour($factorNumber);
            //sms to member
            $smsMember = " کانتر گرامی " . PHP_EOL . "{$infoBook['tour_agency_user_name']}" ." پرداخت نقدی مبلغ ارزی رزرو تور " . $infoBook['tour_name'] . " انجام شده و رزرو تور نهایی شده است. " ;
            $smsMember .= PHP_EOL . " شماره فاکتور: " . $factorNumber;
            $objSms = $smsController->initService('0');
            if ($objSms) {
                $smsArray = array(
                    'smsMessage' => $smsMember,
                    'cellNumber' => $infoBook['tour_agency_user_mobile']
                );
                $smsController->sendSMS($smsArray);
            }

            return 'success';
        } else {
            return 'error';
        }
    }
    #endregion



}

?>
