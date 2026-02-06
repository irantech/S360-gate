<?php

class editHotelBooking
{
    public $infoReservationHotel;
    public $errorMessage;
    public $errorPages;
    public $CurrencyCode;
    public $CurrencyEquivalent;

    public function __construct()
    {
        $this->IsLogin = Session::IsLogin();
    }

    public function getInfoHotel($factorNumber)
    {
        $Model = Load::library('Model');
        $sql = "select * from book_hotel_local_tb where factor_number='{$factorNumber}' ORDER BY room_id ";
        $infoHotel = $Model->select($sql);
        //echo Load::plog($infoHotel[0]);

        $sDate_miladi = functions::ConvertToMiladi($infoHotel[0]['start_date']);
        $sDate_miladi = str_replace("-", "", $sDate_miladi);
        $result = date('Ymd', strtotime("".$sDate_miladi.",- 1 day"));
        $SDate = functions::ConvertToJalali($result);
        $SDate = str_replace("-", "", $SDate);

        $dateNow = dateTimeSetting::jdate("Ymd",'','','','en');

        $accessStatusEdit = array('Cancelled', 'NoReserve', 'PreReserve', 'OnRequest');
        if ($this->IsLogin && in_array($infoHotel[0]['status'], $accessStatusEdit) && trim($SDate) > trim($dateNow)){

            foreach ($infoHotel as $k=>$hotel){

                $this->CurrencyCode = $hotel['currency_code'];
                $this->CurrencyEquivalent = $hotel['currency_equivalent'];

                if ($k==0){

                    $this->infoHotel['factor_number'] = $hotel['factor_number'];
                    $this->infoHotel['passenger_leader_tell'] = $hotel['passenger_leader_room'];
                    $this->infoHotel['passenger_leader_fullName'] = $hotel['passenger_leader_room_fullName'];
                    $this->infoHotel['city_name'] = $hotel['city_name'];
                    $this->infoHotel['hotel_id'] = $hotel['hotel_id'];
                    $this->infoHotel['city_id'] = $hotel['city_id'];
                    $this->infoHotel['hotel_name'] = $hotel['hotel_name'];
                    $this->infoHotel['hotel_address'] = $hotel['hotel_address'];
                    $this->infoHotel['hotel_starCode'] = $hotel['hotel_starCode'];
                    $this->infoHotel['start_date'] = $hotel['start_date'];
                    $this->infoHotel['end_date'] = $hotel['end_date'];
                    $this->infoHotel['number_night'] = $hotel['number_night'];
                    $this->infoHotel['type_application'] = $hotel['type_application'];
                    $this->infoHotel['hotel_rules'] = $hotel['hotel_rules'];
                    $this->infoHotel['hotel_pictures'] = $hotel['hotel_pictures'] ;
                    $this->infoHotel['total_price'] = $hotel['total_price'] ;
                    $this->infoHotel['member_id'] = $hotel['member_id'] ;


                    $expHourWent = explode(":", $hotel['hour_went']);
                    $expHourBack = explode(":", $hotel['hour_back']);
                    $this->infoTransfer['origin'] = $hotel['origin'] ;
                    $this->infoTransfer['flight_date_went'] = $hotel['flight_date_went'] ;
                    $this->infoTransfer['airline_went'] = $hotel['airline_went'] ;
                    $this->infoTransfer['flight_number_went'] = $hotel['flight_number_went'] ;
                    $this->infoTransfer['hour_went'] = $expHourWent[0] ;
                    $this->infoTransfer['minutes_went'] = $expHourWent[1] ;
                    $this->infoTransfer['flight_date_back'] = $hotel['flight_date_back'] ;
                    $this->infoTransfer['airline_back'] = $hotel['airline_back'] ;
                    $this->infoTransfer['flight_number_back'] = $hotel['flight_number_back'] ;
                    $this->infoTransfer['hour_back'] = $expHourBack[0] ;
                    $this->infoTransfer['minutes_back'] = $expHourBack[1] ;

                }

                $expRoommate = explode("_", $hotel['roommate']);
                $roomCount = explode(":", $expRoommate[1]);

                $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['id'] = $hotel['id'];
                $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['room_id'] = $hotel['room_id'];
                $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['room_name'] = $hotel['room_name'];
                $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['room_price'] = $hotel['room_price'];
                $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['roommate'] = $hotel['roommate'];
                $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['room_count'] = $roomCount[1];
                $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['flat_type'] = $hotel['flat_type'];
                $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['passenger_gender'] = $hotel['passenger_gender'];
                $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['passenger_name'] = $hotel['passenger_name'];
                $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['passenger_family'] = $hotel['passenger_family'];
                $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['passenger_name_en'] = $hotel['passenger_name_en'];
                $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['passenger_family_en'] = $hotel['passenger_family_en'];
                $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['passenger_birthday'] = $hotel['passenger_birthday'];
                $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['passenger_birthday_en'] = $hotel['passenger_birthday_en'];
                $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['passenger_national_code'] = $hotel['passenger_national_code'];
                $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['passportNumber'] = $hotel['passportNumber'];
                $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['passportExpire'] = $hotel['passportExpire'];

                switch ($hotel['flat_type']) {
                    case 'DBL':
                        $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['title_flat_type'] = 'تخت اصلی';
                        $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['title_flat_age'] = 'گروه سنی بزرگسال (+12)';
                        break;
                    case 'EXT':
                        $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['title_flat_type'] = 'تخت اضافه';
                        $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['title_flat_age'] = 'بزرگسال';
                        break;
                    case 'ECHD':
                        $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['title_flat_type'] = 'تخت اضافه';
                        $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['title_flat_age'] = 'کودک';
                        break;
                    default:
                        $this->infoRoom[$hotel['room_id']][$roomCount[1]][$k]['title_flat_type'] = '';
                }


                $this->room[$hotel['room_id']][$roomCount[1]]['room_id'] = $hotel['room_id'];
                $this->room[$hotel['room_id']][$roomCount[1]]['room_name'] = $hotel['room_name'];
                $this->room[$hotel['room_id']][$roomCount[1]]['room_price'] = $hotel['room_price'];

            }

            $this->countRoomReserve = COUNT($this->infoRoom);

        }else {

            $this->errorPages = 'true';
            $this->errorMessage = functions::Xmlinformation('AccessDeniedPage');
        }


    }

    public function getPriceOneDayTour($factorNumber)
    {

        $Model = Load::library('Model');
        $amountR = 0;
        $sqlBook = " SELECT * FROM reservation_book_one_day_tour_tb WHERE fk_factor_number ='{$factorNumber}' ";
        $book = $Model->select($sqlBook);

        if (!empty($book)){

            foreach ($book as $val){

                $sql = " SELECT * FROM reservatin_one_day_tour_tb WHERE id ='{$val['fk_id_one_day_tour']}' ";
                $result = $Model->load($sql);

                $amountR += ($val['num_adt_r']*$result['adt_price_rial']);
                if ($val['num_chd_r']!='0'){$amountR += ($val['num_chd_r']*$result['chd_price_rial']);}
                if ($val['num_inf_r']!='0'){$amountR += ($val['num_inf_r']*$result['inf_price_rial']);}

            }

        }

        return $amountR;
    }

    public function permissionToAddExtraBeds($idHotel, $idRoom, $countRoom)
    {

        $countEXT = 0; $countECHD = 0;
        foreach ($this->infoRoom[$idRoom][$countRoom] as $room){

            if ($room['flat_type']!='DBL' && $room['flat_type']=='EXT'){
                $countEXT += $room['room_count'];
            }elseif ($room['flat_type']!='DBL' && $room['flat_type']=='ECHD'){
                $countECHD += $room['room_count'];
            }
        }

        $Model = Load::library('Model');
        $sql = "select maximum_extra_beds, maximum_extra_chd_beds
                from reservation_hotel_room_tb 
                where id_hotel='{$idHotel}' AND id_room='{$idRoom}'
                ";
        $info = $Model->load($sql);

        $result['room_id'] =  $idRoom;
        $result['room_count'] =  $countRoom;
        if ($countEXT<$info['maximum_extra_beds']){
            $result['extraBed'] =  'True';
            $result['addNumberEXT'] =  $info['maximum_extra_beds'] - $countEXT;
        }else{
            $result['extraBed'] = 'False';
            $result['addNumberEXT'] = 0;
        }
        if ($countECHD<$info['maximum_extra_chd_beds']){
            $result['extraChildBed'] =  'True';
            $result['addNumberECHD'] =  $info['maximum_extra_chd_beds'] - $countECHD;
        }else{
            $result['extraChildBed'] = 'False';
            $result['addNumberECHD'] = 0;
        }

        return $result;

    }

    public function deleteRoomReservations($param)
    {

        if ($param['type']=='room'){
            $where = "room_id={$param['id']} AND factor_number='{$param['factorNumber']}'";
        }elseif ($param['type']=='extraBed'){
            $where = "id={$param['id']} AND factor_number='{$param['factorNumber']}'";
        }

        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $sql = "select 
                  room_price, total_price, room_name, flat_type,
                  hotel_name, passenger_name, roommate
                from book_hotel_local_tb where {$where} ORDER BY id ";
        $infoHotel = $Model->select($sql);

        $description = '';
        $total_price = $infoHotel[0]['total_price'];
        foreach ($infoHotel as $val){

            $expRoommate = explode("_", $val['roommate']);
            $expCountRoom = explode(":", $expRoommate[1]);
            $expTypeBed = explode(":", $expRoommate[2]);

            if (($param['type']=='room' && $expCountRoom[1]==$param['roomCount']) || $param['type']=='extraBed'){

                if ($expTypeBed[0]!='DBL' || ($expTypeBed[0]=='DBL' && $expTypeBed[1]=='1')){
                    $total_price -= $val['room_price'];
                }

                switch ($val['flat_type']){
                    case 'DBL':
                        $flat_type = 'تخت اصلی';
                        break;
                    case 'EXT':
                        $flat_type = 'تخت اضافه بزرگسال';
                        break;
                    case 'ECHD':
                        $flat_type = 'تخت اضافه کودک';
                        break;
                    default:
                        $flat_type = '';
                        break;
                }
                $description .= ' حذف ' . $flat_type . ' اتاق: ' . $val['room_name'] . '، مسافر ' . $val['passenger_name'] . ' ' . $val['passenger_family'];

                $d['status'] = 'Cancelled';
                $d['factor_number'] = $param['factorNumber'] . 'EDIT';


                $Condition =  "{$where} AND roommate='{$val['roommate']}'";
                $Model->setTable("book_hotel_local_tb");
                $res[] = $Model->update($d, $Condition);
                $ModelBase->setTable("report_hotel_tb");
                $res[] = $ModelBase->update($d, $Condition);

            }

        }

        $description .= ' در هتل: ' . $infoHotel[0]['hotel_name'];
        $price['total_price'] = $total_price;

        $Condition = "factor_number={$param['factorNumber']}";
        $Model->setTable("book_hotel_local_tb");
        $res[] = $Model->update($price, $Condition);
        $ModelBase->setTable("report_hotel_tb");
        $res[] = $ModelBase->update($price, $Condition);


        if (in_array('0', $res)){
            return 'error : خطا در  تغییرات';
        }else{
            $date['fk_factor_number'] = $param['factorNumber'];
            $date['description'] = $description;
            $date['creation_date'] =  Date('Y-m-d H:i:s');

            $Model->setTable("reservation_edit_hotel_booking_tb");
            $resEdit = $Model->insertLocal($date);
            if ($resEdit) {
                return 'success :  تغییرات با موفقیت انجام شد';
            } else {
                return 'error : خطا در  تغییرات';
            }
        }


    }


    public function editDateReserve($param)
    {

        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $apiHotelLocal = Load::library('apiHotelLocal');

        $sql = "select 
                  room_id, room_name, room_name_en, room_count, start_date, end_date,
                  number_night, date_current, price_current,
                  room_price, room_online_price, room_bord_price, total_price,
                  hotel_room_prices_id, roommate, flat_type, hotel_id, member_id, id
                from book_hotel_local_tb where factor_number='{$param['factorNumber']}' ORDER BY id ";
        $infoHotel = $Model->select($sql);
        $counterTypeId = functions::getCounterTypeId($infoHotel[0]['member_id']);
        $totalPrice = 0;
        foreach ($infoHotel as $val){

            $infoRoom = $apiHotelLocal->infoHotelRoom($val['hotel_id'], $val['room_id'], $param['startDate'], $param['endDate'], $val['flat_type'], $counterTypeId);

            $d['start_date'] = $param['startDate'];
            $d['end_date'] = $param['endDate'];
            $d['number_night'] = $param['night'];
            $d['date_current'] = $param['startDate'];
            $d['price_current'] = $infoRoom['online_price_1night'];
            $d['room_price'] = $infoRoom['online_price'];
            $d['room_online_price'] = $infoRoom['online_price'];
            $d['room_bord_price'] = $infoRoom['board_price'];
            $d['hotel_room_prices_id'] = $infoRoom['hotel_room_prices_id'];

            $Condition = "id={$val['id']}";
            $Model->setTable("book_hotel_local_tb");
            $res[] = $Model->update($d, $Condition);

            $ModelBase->setTable("report_hotel_tb");
            $res[] = $ModelBase->update($d, $Condition);

            $expRoommate = explode("_", $val['roommate']);
            $exp = explode(":", $expRoommate[2]);
            if ($exp[0]!='DBL' || ($exp[0]=='DBL' && $exp[1]=='1')){
                $totalPrice += $infoRoom['online_price'];
            }


        }

        $priceOneDayTour = $this->getPriceOneDayTour($param['factorNumber']);
        $price['total_price'] = $totalPrice + $priceOneDayTour;

        $Condition = "factor_number={$param['factorNumber']}";
        $Model->setTable("book_hotel_local_tb");
        $res[] = $Model->update($price, $Condition);
        $ModelBase->setTable("report_hotel_tb");
        $res[] = $ModelBase->update($price, $Condition);


        if (in_array('0', $res)){
            return 'error : خطا در  تغییرات';
        }else{
            $date['fk_factor_number'] = $param['factorNumber'];
            $date['description'] = 'تغییر تاریخ ورود و خروج';
            $date['creation_date'] =  Date('Y-m-d H:i:s');

            $Model->setTable("reservation_edit_hotel_booking_tb");
            $resEdit = $Model->insertLocal($date);
            if ($resEdit) {
                return 'success :  تغییرات با موفقیت انجام شد';
            } else {
                return 'error : خطا در  تغییرات';
            }
        }



    }

    public function editPassengerHotel($param)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $i = 1;
        while (isset($param["nameFa" . $i])) {

            $d['passenger_gender'] = $param["gender" . $i];
            $d['passenger_name_en'] = $param["nameEn" . $i];
            $d['passenger_family_en'] = $param["familyEn" . $i];
            $d['passenger_name'] = $param["nameFa" . $i];
            $d['passenger_family'] = $param["familyFa" . $i];
            $d['passportCountry'] = isset($param["passportCountry" . $i]) ? $param["passportCountry" . $i] : '';

            $d['passportExpire'] = isset($param["passportExpire" . $i]) ? $param["passportExpire" . $i] : '';

            if ($param["passengerNationality" . $i] == '0') {
                $d['passenger_national_code'] = $param["NationalCode" . $i];
                $d['passenger_birthday'] = $_POST["birthday" . $i];
                $d['passenger_birthday_en'] = '';
            } else{
                $d['passportNumber'] = $param["passportNumber" . $i];
                $d['passenger_birthday_en'] = $_POST["birthdayEn" . $i];
                $d['passenger_birthday'] = '';
            }

            $Condition = "factor_number='{$param['factorNumber']}' AND roommate='{$param['roommate'. $i]}' ";
            $Model->setTable("book_hotel_local_tb");
            $res[] = $Model->update($d, $Condition);

            $ModelBase->setTable("report_hotel_tb");
            $res[] = $ModelBase->update($d, $Condition);


            $i++;
        }


        if (in_array('0', $res)){
            return 'error : خطا در  تغییرات';
        }else{
            $date['fk_factor_number'] = $param['factorNumber'];
            $date['description'] = 'ویرایش اسامی مسافران';
            $date['creation_date'] =  date('Y-m-d H:i:s');

            $Model->setTable("reservation_edit_hotel_booking_tb");
            $resEdit = $Model->insertLocal($date);
            if ($resEdit) {
                return 'success :  تغییرات با موفقیت انجام شد';
            } else {
                return 'error : خطا در  تغییرات';
            }
        }

    }


    public function editTransferHotel($param)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        if ($param['type']=='edit'){

            $d['origin'] = $param['origin'];
            $d['flight_date_went'] = $param['flight_date_went'];
            $d['airline_went'] = $param['airline_went'];
            $d['flight_number_went'] = $param['flight_number_went'];
            $d['hour_went'] = $param['hour_went'] . ':' . $param['minutes_went'];
            $d['flight_date_back'] = $param['flight_date_back'];
            $d['airline_back'] = $param['airline_back'];
            $d['flight_number_back'] = $param['flight_number_back'];
            $d['hour_back'] = $param['hour_back'] . ':' . $param['minutes_back'];

        }elseif ($param['type']=='delete'){

            $d['origin'] = '';
            $d['flight_date_went'] = '';
            $d['airline_went'] = '';
            $d['flight_number_went'] = '';
            $d['hour_went'] = '';
            $d['flight_date_back'] = '';
            $d['airline_back'] = '';
            $d['flight_number_back'] = '';
            $d['hour_back'] = '';
        }


        $Condition = "factor_number='{$param['factorNumber']}'";
        $Model->setTable("book_hotel_local_tb");
        $res = $Model->update($d, $Condition);

        $ModelBase->setTable("report_hotel_tb");
        $res = $ModelBase->update($d, $Condition);


        if ($res){
            $date['fk_factor_number'] = $param['factorNumber'];
            $date['description'] = 'ویرایش ترانسفر رایگان هتل';
            $date['creation_date'] =  date('Y-m-d H:i:s');

            $Model->setTable("reservation_edit_hotel_booking_tb");
            $resEdit = $Model->insertLocal($date);
            if ($resEdit) {
                return 'success :  تغییرات با موفقیت انجام شد';
            } else {
                return 'error : خطا در  تغییرات';
            }

        }else{
            return 'error : خطا در  تغییرات';
        }

    }



    public function addRoomReservations($idRoom = null)
    {
        $Model = Load::library('Model');

        if ($_POST['typeBed']=='extraBed'){
            $where = "AND room_id={$_POST['roomId']}";
            $this->countAddRoom = $_POST['extraBed'] + $_POST['extraChildBed'];
        }elseif ($_POST['typeBed']=='room'){
            $where = "AND room_id={$idRoom}";
        }

        $sql = "select 
                      room_price, total_price, room_name, flat_type,
                      hotel_name, passenger_name, roommate, room_count
                    from book_hotel_local_tb 
                    where
                      factor_number='{$_POST['factorNumber']}' {$where}
                    ORDER BY id ";
        $infoHotel = $Model->select($sql);

        $EXT = 0; $ECHD = 0; $result = array();
        foreach ($infoHotel as $val){

            if ($_POST['typeBed']=='extraBed'){

                $expRoommate = explode("_", $val['roommate']);
                $exp = explode(":", $expRoommate[1]);

                if ($exp[1]==$_POST['roomCount']){

                    if ($val['flat_type']=='EXT'){
                        $EXT++;
                    }elseif ($val['flat_type']=='ECHD'){
                        $ECHD++;
                    }
                }

            }elseif ($_POST['typeBed']=='room'){

                $result['DBL'] = $val['room_count'];
            }

        }
        $result['EXT'] = $EXT;
        $result['ECHD'] = $ECHD;


        return $result;


    }



    public function addOneDayTour($param)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $amountR = 0;
        //$amountA = 0;
        for($ii=1;$ii<=$param['countOneDayTour'];$ii++){

            if (isset($param['adtNumR'.$ii]) && $param['adtNumR'.$ii] > 0){

                $sql_check = " SELECT id FROM reservation_book_one_day_tour_tb WHERE fk_factor_number ='{$param['factorNumber']}' AND fk_id_one_day_tour ='{$param['idOneDayTour'.$ii]}' ";
                $book_check = $Model->load($sql_check);

                if (empty($book_check)){

                    $OneDayTour['fk_factor_number'] = $param['factorNumber'];
                    $OneDayTour['fk_id_one_day_tour '] = $param['idOneDayTour'.$ii];
                    $OneDayTour['num_adt_r'] = $param['adtNumR'.$ii];
                    $OneDayTour['num_chd_r'] = isset($param['chdNumR'.$ii]) ? $param['chdNumR'.$ii] : '0';
                    $OneDayTour['num_inf_r'] = isset($param['infNumR'.$ii]) ? $param['infNumR'.$ii] : '0';
                    $OneDayTour['num_adt_a'] = '0';
                    $OneDayTour['num_chd_a'] = '0';
                    $OneDayTour['num_inf_a'] = '0';
                    /*$OneDayTour['num_adt_a'] = $param['adtNumA'.$ii];
                    $OneDayTour['num_chd_a'] = isset($param['chdNumA'.$ii]) ? $param['chdNumA'.$ii] : '0';
                    $OneDayTour['num_inf_a'] = isset($param['infNumA'.$ii]) ? $param['infNumA'.$ii] : '0';*/

                    $Model->setTable('reservation_book_one_day_tour_tb');
                    $res = $Model->insertLocal($OneDayTour);

                }else{
                    return 'error : امکان انتخاب یک تور برای دو بار وجود ندارد.';
                }

                $amountR += ($param['adtNumR'.$ii]*$param['adtPriceR'.$ii]);
                if (isset($param['chdNumR'.$ii])){$amountR += ($param['chdNumR'.$ii]*$param['chdPriceR'.$ii]);}
                if (isset($param['infNumRs'.$ii])){$amountR += ($param['infNumR'.$ii]*$param['infPriceR'.$ii]);}
                //$amountA = $amountA + ($param['adtNumA'.$ii]*$param['adtPriceA'.$ii])+($param['chdNumA'.$ii]*$param['chdPriceA'.$ii])+($param['infNumA'.$ii]*$param['infPriceA'.$ii]);

            }

        }


        if ($res){

            $totalPrice = $param['totalPrice'] + $amountR;
            $description = 'درخواست تور یک روزه به مبلغ: ' . $amountR . ' ریال ';

            $price['total_price'] = $totalPrice;

            $Condition = "factor_number={$param['factorNumber']}";
            $Model->setTable("book_hotel_local_tb");
            $resPrice1 = $Model->update($price, $Condition);
            $ModelBase->setTable("report_hotel_tb");
            $resPrice2 = $ModelBase->update($price, $Condition);

            if ($resPrice1 && $resPrice2){

                $date['fk_factor_number'] = $param['factorNumber'];
                $date['description'] = $description;
                $date['creation_date'] =  date('Y-m-d H:i:s');

                $Model->setTable("reservation_edit_hotel_booking_tb");
                $resEdit = $Model->insertLocal($date);
                if ($resEdit) {
                    return 'success :  تغییرات با موفقیت انجام شد';
                } else {
                    return 'error : خطا در  تغییرات';
                }

            }else{
                return 'error : خطا در  تغییرات';
            }


        }else{
            return 'error : خطا در  تغییرات';
        }


    }



    public function deleteOneDayTour($param)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $d['fk_factor_number'] = $param['factorNumber'] . 'EDIT';
        $Condition = "id={$param['idBook']}";
        $Model->setTable("reservation_book_one_day_tour_tb");
        $res = $Model->update($d, $Condition);


        if ($res){

            $totalPrice = $param['totalPrice'] - $param['price'];
            $description = 'حذف تور یک روزه '  . $param['title'] . ' به مبلغ: ' . $param['price'] . ' ریال ';

            $price['total_price'] = $totalPrice;
            $Condition = "factor_number={$param['factorNumber']}";
            $Model->setTable("book_hotel_local_tb");
            $resPrice1 = $Model->update($price, $Condition);
            $ModelBase->setTable("report_hotel_tb");
            $resPrice2 = $ModelBase->update($price, $Condition);

            if ($resPrice1 && $resPrice2){

                $date['fk_factor_number'] = $param['factorNumber'];
                $date['description'] = $description;
                $date['creation_date'] =  Date('Y-m-d H:i:s');

                $Model->setTable("reservation_edit_hotel_booking_tb");
                $resEdit = $Model->insertLocal($date);
                if ($resEdit) {
                    return 'success :  تغییرات با موفقیت انجام شد';
                } else {
                    return 'error : خطا در  تغییرات';
                }

            }else{
                return 'error : خطا در  تغییرات';
            }


        }else{
            return 'error : خطا در  تغییرات';
        }

    }




}

?>
