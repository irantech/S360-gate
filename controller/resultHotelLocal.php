<?php

//error_reporting(0);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');


class resultHotelLocal extends apiHotelLocal
{

    public $InfoSourcesReservationHotel = '';
    public $typeApplication = '';
    public $all_city = '';
    public $all_country = '';
    public $all_region = '';
    public $Hotel_byCity = "";
    public $All_HotelType = "";
    public $Hotel_Type = array();
    public $hotelRoom_MinPrice = array();
    public $RoomRemainingCapacity = array();
    public $PicHotel = array();
    public $pic_hotel = "";
    public $maxPrice = 0;
    public $minPrice = 0;
    public $Price_AllRoom = array();
    public $HotelFacilityList = array();
    public $RoomFacilitiesList = array();
    public $RemainingCapacity = "";
    public $RemainingCapacity_AllHotel = "";
    public $SearchCity = "";
    public $end_date = "";
    public $Capacity = "";
    public $SearchHotel = "";
    public $SearchHotelRoom = "";
    public $Room_byHotel = array();
    public $RoomPrice_startDate = "";
    public $result_HotelReserveRoom = "";
    public $errorSearchHotel = "false";
    public $numberBasket = "";
    public $agency_commission = array();
    public $stayingTime = array();
    public $RoomPrices = array();
    public $typeRoom = array();
    public $typeTitle = array();
    public $typeQuality = array();
    public $infoReservationHotel = array();
    public $temproryHotelRoom = array();
    public $errorUserType = '';
    public $transfer_went = '';
    public $transfer_back = '';
    public $oneDayTour = '';
    public $counterTypeId = '';
    public $counterName = '';
    public $counterId = '';
    public $IsLogin = '';
    public $countHotel = '';
    public $serviceDiscount = array();



    public function __construct()
    {



        parent::__construct();
        if (isset($_SESSION['StatusRefresh']) && $_SESSION['StatusRefresh'] != '') {
            unset($_SESSION['StatusRefresh']);
        }

        if (isset($_POST['typeApplication'])) {
            $this->typeApplication = $_POST['typeApplication'];
        }


        $this->IsLogin = Session::IsLogin();
        if ($this->IsLogin) {
            $this->counterId = functions::getCounterTypeId($_SESSION['userId']);
            $this->serviceDiscount['api'] = functions::ServiceDiscount($this->counterId, 'PublicLocalHotel');
        } else {
            $this->counterId = '5';
        }

    }

    // محاسبه تاریخ خروج
    function endDate($startDateMiladi, $nightCount)
    {
        $result = date('Ymd', strtotime("" . $startDateMiladi . ",+ $nightCount day"));
        $this->end_date = $result;
    }

    function computingEndDate($startDate, $nightCount)
    {

        $isMiladi = false;
        if (SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' || substr($startDate, "0", "4") > 2000){
            $isMiladi = true;
            $sDate_miladi = $startDate;
        }else{
            $sDate_miladi = functions::ConvertToMiladi($startDate);

        }

        $sDate_miladi = str_replace("-", "", $sDate_miladi);



        $result = date('Y-m-d', strtotime( $sDate_miladi . ",+$nightCount day"));
        if (SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' || $isMiladi){

            $y = substr($result, 0, 4);
            $m = substr($result, 4, 2);
            $d = substr($result, 6, 2);
            $dateFa = $y . '-' . $m . '-' . $d;
        } else {

            $dateFa = functions::ConvertToJalali($result);

        }

        $this->end_date = $dateFa;
        return $dateFa;
    }

    function convertDateWithoutDash($param)
    {
        $dateYear = substr($param, 0, 4);
        $dateMonth = substr($param, 5, 2);
        $dateDay = substr($param, 8, 2);

        return $dateYear . $dateMonth . $dateDay;
    }

    function convertDateWithDash($param)
    {
        $dateYear = substr($param, 0, 4);
        $dateMonth = substr($param, 4, 2);
        $dateDay = substr($param, 6, 2);

        return $dateYear . '-' . $dateMonth . '-' . $dateDay;
    }

    // بازگرداندن لیست تمامی کشور های ثبت شده درون سیستم
    function getAllCountry()
    {
        $Model = Load::library('Model');
        $sql = "SELECT * FROM reservation_country_tb ";
        $result = $Model->select($sql);

        $this->all_country = $result;
    }

    // بازگرداندن لیست تمامی شهر های ثبت شده درون سیستم
    function getAllCity($country = null)
    {
        //$result = parent::All_City();
        $Model = Load::library('Model');
        $sql = " SELECT * FROM reservation_city_tb WHERE 1=1 ";
        if (isset($country) && $country != '') {
            $sql .= " AND id_country = '{$country}' ";
        }
        $result = $Model->select($sql);

        $this->all_city = $result;
    }

    // بازگرداندن لیست تمامی منطقه های ثبت شده درون سیستم
    function getAllRegion($city = null)
    {
        $Model = Load::library('Model');
        $sql = "SELECT * FROM reservation_region_tb WHERE 1=1 ";
        if (isset($city) && $city != '') {
            $sql .= " AND id_city = '{$city}' ";
        }
        $result = $Model->select($sql);

        $this->all_region = $result;
    }


    // پیدا کردن و بازگرداندم یک شی که معرف اطلاعات یک کشور می باشد توسط کد آن کشور
    function getCountry($idCountry)
    {

        $Model = Load::library('Model');
        $sql = "SELECT * FROM reservation_country_tb WHERE id='{$idCountry}' ";
        $result = $Model->Load($sql);

        $city_name = $result['name'];

        return $city_name;

    }

    public function ReadHotelImageSourceFrom360($idHotel)
    {

        $Model = Load::library('Model');
        $sql = "SELECT RSHotel.* ,RC.name_en AS CityNameEn
                FROM reservation_hotel_tb AS RSHotel
                INNER JOIN reservation_city_tb AS RC ON RC.id=RSHotel.city
                WHERE RSHotel.id='{$idHotel}' ";
        $result = $Model->Load($sql);

        if($result['country'] == 1){
            $Countery='internal';
        }else{
            $Countery='external';

        }



        return "http://safar360.com/HotelImages/$Countery/".strtolower($result['CityNameEn'])."/".strtolower( preg_replace( "![^a-z0-9]+!i", "-", $result['name_en'] ) )."/medium/".$idHotel."-0.jpg";

    }

    // پیدا کردن و بازگرداندم یک شی که معرف اطلاعات یک شهر می باشد توسط کد آن شهر
    function getCity($idCity)
    {
        /*$result = parent::City($IdCity);
        $this->SearchCity = $result;*/

        $ModelBase = Load::library('ModelBase');

        $sql = "SELECT * FROM hotel_cities_tb WHERE city_code='{$idCity}' ";
        $result = $ModelBase->Load($sql);

        if (!empty($result)) {
            $city_name = $result['city_name'];

        } else {

            $Model = Load::library('Model');
            $sql = "SELECT * FROM reservation_city_tb WHERE id='{$idCity}' ";
            $result = $Model->Load($sql);

            $city_name = $result['name'];
        }

        return $city_name;

    }


    // پیدا کردن و بازگرداندم یک شی که معرف اطلاعات یک منطقه می باشد توسط کد آن منطقه
    function getRegion($idRegion)
    {

        $Model = Load::library('Model');
        $sql = "SELECT * FROM reservation_region_tb WHERE id='{$idRegion}' ";
        $result = $Model->Load($sql);

        $city_name = $result['name'];

        return $city_name;

    }

    // بازگرداندن لیست تمامی نوع هتل های ثبت شده درون سیستم
    public function AllHotelType()
    {

        $result_All_HotelType = parent::All_HotelType();
        $this->All_HotelType = $result_All_HotelType;


    }

    function sortHotel()
    {

        $Model = Load::library('Model');
        $sql = " SELECT title_en FROM reservation_order_hotel_tb WHERE enable='1' AND is_del='no'";
        $result = $Model->load($sql);
        if (!empty($result)) {
            return $result['title_en'];
        } else {
            return 'max_star_code';
        }

    }

    function getMinPriceHotelRoom($idCity, $idHotel, $startDate, $endDate)
    {
        $date = dateTimeSetting::jtoday('');

        $Model = Load::library('Model');
        $sql = "
        SELECT
            HR.online_price,
            HR.date,
            (
        SELECT
            MIN( HHR.online_price ) 
        FROM
            reservation_hotel_tb HH
            INNER JOIN reservation_hotel_room_prices_tb HHR ON HH.id = HHR.id_hotel 
        WHERE
            HHR.user_type = '{$this->counterId}' 
            AND HH.city = '{$idCity}' 
            AND HH.id = '{$idHotel}' 
            AND HHR.date = HR.date 
            AND HHR.flat_type = 'DBL' 
            AND HHR.is_del = 'no' 
            ) AS minPrice 
        FROM
            reservation_hotel_tb H
            INNER JOIN reservation_hotel_room_prices_tb HR ON H.id = HR.id_hotel 
        WHERE
            HR.user_type = '{$this->counterId}' 
            AND H.city = '{$idCity}' 
            AND H.id = '{$idHotel}' 
            AND ( HR.date >= '{$startDate}' AND HR.date < '{$endDate}' ) 
            AND HR.flat_type = 'DBL' 
            AND HR.is_del = 'no' 
        GROUP BY
            HR.date;
        ";

        $prices = $Model->select($sql);
        $minPrice = 0;
        foreach ($prices as $price){
            $minPrice += $price['minPrice'];
        }

        return $minPrice;
    }


    function getMinMaxPriceHotelByCityId($cityId, $startDate)
    {
        $ModelBase = Load::library('ModelBase');
        $Model = Load::library('Model');
        $date = dateTimeSetting::jtoday('');
        $SDate = str_replace("-", "", $startDate);
        $arrayPrice = array();

        $sql = " SELECT MIN(HR.online_price) as minPrice, MAX(HR.online_price) as maxPrice
                 FROM 
                     reservation_hotel_tb H
                     INNER JOIN reservation_hotel_room_prices_tb HR ON H.id=HR.id_hotel 
                 WHERE 
                     H.city='{$cityId}' AND 
                     HR.flat_type='DBL' AND 
                     HR.date='{$date}' AND
                     HR.is_del='no'
                    ";
        $resultHotelReservation = $Model->load($sql);
        $arrayPrice[] = $resultHotelReservation['minPrice'];
        $arrayPrice[] = $resultHotelReservation['maxPrice'];


        $sql = " SELECT * FROM hotel_room_prices_tb WHERE city_id='{$cityId}'";
        $resultHotel = $ModelBase->select($sql);
        if (!empty($resultHotel)) {
            // جستوجو برای لیست اتاق های موجود در یک هتل در یک بازه تاریخی و بازگرداندن کمترین قیمت اتاق دو تخته در آن هتل
            foreach ($resultHotel as $Hotel) {

                $price = 0;
                $arrayRoomPrice = json_decode($Hotel['info_rooms'], true);
                if (!empty($arrayRoomPrice)) {
                    if (isset($arrayRoomPrice[$SDate]) && $arrayRoomPrice[$SDate] != '') {
                        $arrayPrice[] = min($arrayRoomPrice[$SDate]);
                    } else {
                        $price = end($arrayRoomPrice);
                        $arrayPrice[] = min($price);
                    }
                }
            }
        }

        $result['minPrice'] = min($arrayPrice);
        $result['maxPrice'] = max($arrayPrice);

        return $result;


    }

    // واکشی اطلاعات کامل هتل ها
    function getHotelByCity($idCity, $startDate, $endDate, $hotelType = null, $star = null, $price = null, $hotelName = null)
    {
        $ModelBase = Load::library('ModelBase');
        $Model = Load::library('Model');

        $arrayPrice = array();
        $index = 0;

        if (SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' || substr($startDate, "0", "4") > 2000){
            $startDate = functions::ConvertToJalali($startDate);
            $endDate = functions::ConvertToJalali($endDate);
        }


        $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        $startDate = str_replace("-", "", $startDate);
        $startDate = str_replace("/", "", $startDate);
        $endDate = str_replace("-", "", $endDate);
        $endDate = str_replace("/", "", $endDate);
        if (trim($startDate) >= trim($dateNow)) {
            $this->errorSearchHotel = "false";
        } else {
            $this->errorSearchHotel = "true";
        }


        if (isset($hotelType) && (is_numeric($hotelType))) {
            $conditionHotelTypeForReservation = $conditionHotelTypeForApi = "AND type_code='" . $hotelType . "'";
        } else {
            $conditionHotelTypeForReservation = $conditionHotelTypeForApi = '';
        }

        if ($star != '' && is_numeric($star)) {
            $conditionsStarForReservation = $conditionsStarForApi = "AND star_code='{$star}'";
        } else {
            $conditionsStarForReservation = $conditionsStarForApi = '';
        }

        if ($hotelName != '') {
            $conditionsHotelNameForReservation = "AND name LIKE '%{$hotelName}%' ";
            $conditionsHotelNameForApi = "AND hotel_name LIKE '%{$hotelName}%' ";
        } else {
            $conditionsHotelNameForReservation = $conditionsHotelNameForApi = '';
        }

        switch ($price) {
            case '200':
                $conditionPriceForReservation = 'AND HR.online_price>2000000 ';
                break;
            case '200,300':
                $conditionPriceForReservation = 'AND (HR.online_price BETWEEN 2000000 AND 3000000)';
                break;
            case '300,400':
                $conditionPriceForReservation = 'AND (HR.online_price BETWEEN 3000000 AND 4000000)';
                break;
            case '400,500':
                $conditionPriceForReservation = 'AND (HR.online_price BETWEEN 4000000 AND 5000000)';
                break;
            case '500':
                $conditionPriceForReservation = 'AND HR.online_price<5000000 ';
                break;
            default :
                $conditionPriceForReservation = '';
                break;
        }

        // Access Reservation Hotel
        $resultInfoSources = parent::AccessReservationHotel();
        if ($resultInfoSources == 'True' && (is_numeric($hotelType) || $hotelType == 'all' || $hotelType == 'reservation' || $hotelType == 'app')) {

            // واکشی اطلاعات کامل هتل های رزرواسیون //
            $sql_reservation = "SELECT
                                    id as hotel_id,
                                    name as hotel_name,
                                    name_en as hotel_name_en,
                                    city as city_id,
                                    priority as hotel_priority,
                                    discount,
                                    comment as cancel_conditions,
                                    type_code,
                                    star_code,
                                    address,
                                    logo as pic
                                FROM
                                    reservation_hotel_tb
                                WHERE
                                    city='{$idCity}' AND
                                    is_del='no'
                                    {$conditionsStarForReservation}
                                    {$conditionsHotelNameForReservation}
                                    {$conditionHotelTypeForReservation}
                                ORDER BY priority";
            $result_Hotel_reservation = $Model->select($sql_reservation);
            if (!empty($result_Hotel_reservation)) {
                foreach ($result_Hotel_reservation as $Hotel) {

                    $index++;
                    if (isset($Hotel['pic']) && $Hotel['pic'] != '') {
                        $urlPic = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . $Hotel['pic'];
                    } else {
                        $urlPic = ROOT_ADDRESS_WITHOUT_LANG . '/pic/hotel-nophoto.jpg';
                    }

                    $minPrice = $this->getMinPriceHotelRoom($idCity, $Hotel['hotel_id'], $startDate, $endDate);

                    $cancel_conditions = '';
                    $pos = strpos($Hotel['cancel_conditions'], ' ', 230);
                    if ($pos !== false) {
                        $cancel_conditions = substr($Hotel['cancel_conditions'], 0, $pos) . ' ...';
                    }

                    if ($Hotel['star_code'] > 5) {
                        $star_code = 0;
                    } else {
                        $star_code = $Hotel['star_code'];
                    }

                    $this->Hotel[$Hotel['hotel_id'] . $index]['min_room_price'] = $minPrice;

                    $this->Hotel[$Hotel['hotel_id'] . $index]['city_id'] = $Hotel['city_id'];
                    $this->Hotel[$Hotel['hotel_id'] . $index]['priority'] = $Hotel['hotel_priority'];
                    $this->Hotel[$Hotel['hotel_id'] . $index]['hotel_id'] = $Hotel['hotel_id'];
                    $this->Hotel[$Hotel['hotel_id'] . $index]['hotel_name'] = $Hotel['hotel_name'];
                    $this->Hotel[$Hotel['hotel_id'] . $index]['hotel_name_en'] = str_replace(' ', '-', $Hotel['hotel_name_en']);
                    $this->Hotel[$Hotel['hotel_id'] . $index]['address'] = $Hotel['address'];
                    $this->Hotel[$Hotel['hotel_id'] . $index]['discount'] = $Hotel['discount'];
                    $this->Hotel[$Hotel['hotel_id'] . $index]['cancel_conditions'] = $cancel_conditions;
                    $this->Hotel[$Hotel['hotel_id'] . $index]['pic'] = $urlPic;
                    $this->Hotel[$Hotel['hotel_id'] . $index]['type_code'] = $Hotel['type_code'];
                    $this->Hotel[$Hotel['hotel_id'] . $index]['star_code'] = $star_code;
                    $this->Hotel[$Hotel['hotel_id'] . $index]['type_application'] = 'reservation';

                    $ResultFacilities = parent::hotelFacilities($Hotel['hotel_id']);
                    foreach ($ResultFacilities as $key => $facilities) {

                        $this->Hotel[$Hotel['hotel_id'] . $index]['facilities'][$key]['title'] = $facilities['title'];
                        $this->Hotel[$Hotel['hotel_id'] . $index]['facilities'][$key]['iconClass'] = $facilities['icon_class'];

                    }

                    //$this->RemainingCapacity_AllHotel += $Hotel['remaining_capacity'];

                    if ($minPrice > 0) {
                        $arrayPrice[] = $minPrice;
                    }

                }


            }

        }


        // Access api Hotel
        $resultInfoSources_api = parent::AccessApiHotel();
        if ($resultInfoSources_api == 'True' && (is_numeric($hotelType) || $hotelType == 'all' || $hotelType == 'api' || $hotelType == 'app')) {

            // واکشی اطلاعات کامل هتل های وب سرویس //
            if (isset($hotelType) && (is_numeric($hotelType))) {
                $conditionHotelTypeForReservation = $conditionHotelTypeForApi = "AND HotelRoomPrice.type_code='" . $hotelType . "'";
            } else {
                $conditionHotelTypeForReservation = $conditionHotelTypeForApi = '';
            }

            if ($star != '' && is_numeric($star)) {
                $conditionsStarForReservation = $conditionsStarForApi = "AND HotelRoomPrice.star_code='{$star}'";
            } else {
                $conditionsStarForReservation = $conditionsStarForApi = '';
            }

            if ($hotelName != '') {
                $conditionsHotelNameForReservation = "AND HotelRoomPrice.name LIKE '%{$hotelName}%' ";
                $conditionsHotelNameForApi = "AND HotelRoomPrice.hotel_name LIKE '%{$hotelName}%' ";
            } else {
                $conditionsHotelNameForReservation = $conditionsHotelNameForApi = '';
            }


            $sql = " SELECT HotelRoomPrice.*,HotelCities.city_name_en AS CityNameEn FROM hotel_room_prices_tb AS HotelRoomPrice
                    INNER JOIN hotel_cities_tb AS HotelCities ON HotelCities.city_code=HotelRoomPrice.city_id
                    WHERE HotelRoomPrice.city_id='{$idCity}'
                 {$conditionsStarForApi} {$conditionsHotelNameForApi} {$conditionHotelTypeForApi} ";
            $resultHotel = $ModelBase->select($sql);
            if (!empty($resultHotel)) {

                // جستوجو برای لیست اتاق های موجود در یک هتل در یک بازه تاریخی و بازگرداندن کمترین قیمت اتاق دو تخته در آن هتل
                foreach ($resultHotel as $Hotel) {
                    $index++;

                    $price = 0;
                    $minPrice = 0;
                    $arrayRoomPrice = json_decode($Hotel['info_rooms'], true);
                    if (!empty($arrayRoomPrice)) {
                        $objController = Load::controller('reservationPublicFunctions');
                        $sDate = $startDate;
                        $eDate = $endDate;
                        while ($sDate < $eDate) {
                            if (isset($arrayRoomPrice[$sDate]) && $arrayRoomPrice[$sDate] != '') {
                                $minPrice += min($arrayRoomPrice[$sDate]);
                            }else {
                                $price = end($arrayRoomPrice);
                                $minPrice += min($price);
                            }
                            $sDate = $objController->dateNextFewDays($sDate, ' + 1');
                        }
                    }


                    // اضافه کردن کمسیون آژانس به قیمت اتاق
                    $res = functions::getHotelPriceChange($Hotel['city_id'], $Hotel['star_code'], $this->counterId, $startDate, 'api');
                    if ($res != false && $minPrice != 0 && $res['change_type'] == 'increase' && $res['price_type'] == 'cost') {
                        $priceWithoutDiscount = $minPrice + $res['price'];
                    } elseif ($res != false && $minPrice != 0 && $res['change_type'] == 'decrease' && $res['price_type'] == 'cost') {
                        $priceWithoutDiscount = $minPrice - $res['price'];
                    } elseif ($res != false && $minPrice != 0 && $res['change_type'] == 'increase' && $res['price_type'] == 'percent') {
                        $priceWithoutDiscount = ($minPrice * $res['price'] / 100) + $minPrice;
                    } elseif ($res != false && $minPrice != 0 && $res['change_type'] == 'decrease' && $res['price_type'] == 'percent') {
                        $priceWithoutDiscount = ($minPrice * $res['price'] / 100) - $minPrice;
                    } else {
                        $priceWithoutDiscount = $minPrice;
                    }


                    if (!empty($this->serviceDiscount['api']) && $this->serviceDiscount['api']['off_percent'] > 0) {
                        $price = $priceWithoutDiscount - (($priceWithoutDiscount * $this->serviceDiscount['api']['off_percent']) / 100);
                    } else {
                        $price = $priceWithoutDiscount;
                        $priceWithoutDiscount = 0;
                    }

                    if ($Hotel['cancel_conditions'] != '' && strlen($Hotel['cancel_conditions']) > 460) {
                        $pos = strpos($Hotel['cancel_conditions'], ' ', '460');
                        if ($pos !== false) {
                            $cancel_conditions = substr($Hotel['cancel_conditions'], 0, $pos) . ' ...';
                        }
                    } else {
                        $cancel_conditions = $Hotel['cancel_conditions'];
                    }


                    if (isset($Hotel['pic']) && $Hotel['pic'] != '') {
                        $urlPic = $Hotel['pic'];
                        if($Hotel['country'] == 1){
                            $HotelCountery='internal';
                        }else{
                            $HotelCountery='external';

                        }
                        $urlPic = SERVER_HTTP.$_SERVER['HTTP_HOST']."/imageExternalHotel/hotelImages/iran/".strtolower($Hotel['CityNameEn'])."/".strtolower( preg_replace( "![^a-z0-9]+!i", "-", $Hotel['hotel_name_en'] ) )."/medium/".$Hotel['hotel_id']."-0.jpg";

                    } else {
                        $urlPic = ROOT_ADDRESS_WITHOUT_LANG . '/pic/hotel-nophoto.jpg';
                    }

                    if ($Hotel['star_code'] > 5) {
                        $star_code = 0;
                    } else {
                        $star_code = $Hotel['star_code'];
                    }


                    $this->Hotel[$Hotel['hotel_id'] . $index]['min_room_price'] = $price;
                    $this->Hotel[$Hotel['hotel_id'] . $index]['min_room_price_without_discount'] = $priceWithoutDiscount;
                    $this->Hotel[$Hotel['hotel_id'] . $index]['city_id'] = $Hotel['city_id'];
                    $this->Hotel[$Hotel['hotel_id'] . $index]['priority'] = $Hotel['hotel_priority'];
                    $this->Hotel[$Hotel['hotel_id'] . $index]['hotel_id'] = $Hotel['hotel_id'];
                    //$this->Hotel[$Hotel['hotel_id'].$index]['remaining_capacity'] = $Hotel['remaining_capacity'];
                    $this->Hotel[$Hotel['hotel_id'] . $index]['hotel_name'] = $Hotel['hotel_name'];
                    $this->Hotel[$Hotel['hotel_id'] . $index]['hotel_name_en'] = str_replace(' ', '-', $Hotel['hotel_name_en']);
                    $this->Hotel[$Hotel['hotel_id'] . $index]['address'] = $Hotel['address'];
                    $this->Hotel[$Hotel['hotel_id'] . $index]['discount'] = $Hotel['discount'];
                    $this->Hotel[$Hotel['hotel_id'] . $index]['cancel_conditions'] = $cancel_conditions;
                    $this->Hotel[$Hotel['hotel_id'] . $index]['pic'] = $urlPic;
                    $this->Hotel[$Hotel['hotel_id'] . $index]['pic360'] = $urlPic;
                    $this->Hotel[$Hotel['hotel_id'] . $index]['type_code'] = $Hotel['type_code'];
                    $this->Hotel[$Hotel['hotel_id'] . $index]['star_code'] = $star_code;
                    $this->Hotel[$Hotel['hotel_id'] . $index]['type_application'] = 'api';

                    //$this->RemainingCapacity_AllHotel += $Hotel['remaining_capacity'];

                    if ($price != 0) {
                        $arrayPrice[] = $price;
                    }

                }


            }
        }

        if (!empty($arrayPrice)) {
            $this->minPrice = min($arrayPrice);
            $this->maxPrice = max($arrayPrice);
        }
        $this->countHotel = $index;


    }


    function getNumberTripAdvisor($str)
    {
        if ($str <= 5 && strrchr($str, ".")) {
            $this->whole = floor($str);      // 1
            $this->fraction = $str - $this->whole; // .25
        } else if ($str <= 5) {
            $this->whole = $str;
            $this->fraction = 0;
        } else {
            $this->whole = 0;
            $this->fraction = 0;
        }
    }

    function countLine($text)
    {

        $myArray = preg_split('/<br[^>]*>/i', $text);
        $result['count'] = count($myArray);
        $result['more'] = count($myArray) - 4;

        return $result;
    }

    // واکشی اطلاعات کامل یک هتل، توسط کد آن هتل
    function getHotel($idHotel, $typeApplication)
    {

        $ModelBase = Load::library('ModelBase');

        $resultHotel = parent::ReservationHotel($idHotel);

        if ($typeApplication == 'reservation') {


            if (!empty($resultHotel)) {
                $this->SearchHotel = $resultHotel;
                $this->typeApplication = $typeApplication;
                foreach ($resultHotel['HotelFacility'] as $val) {
                    $this->HotelFacilityList[$val['Title']] = $val['IconClass'];
                }
            }

        }
        elseif ($typeApplication == 'api') {

            $resultHotel = parent::Hotel($idHotel);


            if (!empty($resultHotel)) {
                $this->SearchHotel = $resultHotel;
                $this->typeApplication = $typeApplication;
                foreach ($resultHotel['HotelFacilityList'] as $val) {

                    $sql = "SELECT * FROM hotel_facilities_tb WHERE title='{$val}' AND services='Hotel' ";
                    $HotelFacility = $ModelBase->load($sql);
                    if (!empty($HotelFacility)) {
                        $this->HotelFacilityList[$HotelFacility['title']] = $HotelFacility['icon_class'];
                    }
                }
                foreach ($resultHotel['RoomFacilitiesList'] as $val) {

                    $sql = "SELECT * FROM hotel_facilities_tb WHERE title='{$val}' AND services='Room' ";
                    $HotelFacility = $ModelBase->load($sql);
                    if (!empty($HotelFacility)) {
                        $this->RoomFacilitiesList[$HotelFacility['title']] = $HotelFacility['icon_class'];
                    }
                }

            }
        }
    }


    // واکشی اطلاعات کامل اتاق های یک هتل، توسط کد آن هتل
    function getHotelRoomForAjax($param)
    {
        // دریافت تمام اطلاعات اتاق ها، فیلتر شده توسط کد هتل
        functions::insertLog("Before Room_byHotel Api", "000-RoomHotelApi");
        $result = parent::Room_byHotel($param['idHotel']);
        functions::insertLog("After Room_byHotel Api " . json_encode($result), "000-RoomHotelApi");

        if (!empty($result) && !isset($result['Message'])) {
            return $result;
        } else {
            return false;
        }
    }

    // واکشی اطلاعات کامل قیمت اتاق های یک هتل، توسط کد آن هتل و تاریخ شروع و مدت اقامت
    function getHotelRoomPricesForAjax($param)
    {
        $start_date = str_replace("-", "", $param['startDate']);

        // جستوجو برای لیست اتاق های موجود از هر نوع در یک بازه تاریخی و بازگرداندن لیست قیمت و ظرفیت
        functions::insertLog("Before Hotel_AllRoomPrice Api --> " . $param['idHotel'] . ' start_date --> ' . $start_date . ' nights --> ' . $param['nights'], "000-RoomHotelApi");
        $result = parent::Hotel_AllRoomPrice($param['idHotel'], $start_date, $param['nights']);
        functions::insertLog("After Hotel_AllRoomPrice Api " . json_encode($result), "000-RoomHotelApi");

        if (!empty($result)) {

            foreach ($result as $room) {

                $this->getAgencyCommission($param['city'], $param['hotelStar'], $param['startDate'], $param['nights']);
                if ($this->agency_commission[$param['startDate']]['result']) {

                    if ($this->agency_commission[$param['startDate']]['change_type'] == 'increase' && $this->agency_commission[$param['startDate']]['price_type'] == 'cost') {
                        $price = $room['Price'] + $this->agency_commission[$param['startDate']]['price'];
                    } elseif ($this->agency_commission[$param['startDate']]['change_type'] == 'decrease' && $this->agency_commission[$param['startDate']]['price_type'] == 'cost') {
                        $price = $room['Price'] - $this->agency_commission[$param['startDate']]['price'];
                    } elseif ($this->agency_commission[$param['startDate']]['change_type'] == 'increase' && $this->agency_commission[$param['startDate']]['price_type'] == 'percent') {
                        $price = ($room['Price'] * $this->agency_commission[$param['startDate']]['price'] / 100) + $room['Price'];
                    } elseif ($this->agency_commission[$param['startDate']]['change_type'] == 'decrease' && $this->agency_commission[$param['startDate']]['price_type'] == 'percent') {
                        $price = ($room['Price'] * $this->agency_commission[$param['startDate']]['price'] / 100) - $room['Price'];
                    } else {
                        $price = $room['Price'];
                    }

                } else {
                    $price = $room['Price'];

                }

                $t = ($room['PriceBoard']) - ($price);
                $discount = ($t * 100) / $room['PriceBoard'];

                if (!empty($this->serviceDiscount['api']) && $this->serviceDiscount['api']['off_percent'] > 0) {
                    $discount = $discount + $this->serviceDiscount['api']['off_percent'];
                    $Price = $price - (($price * $this->serviceDiscount['api']['off_percent']) / 100);
                    $PriceOnlineWithoutDiscount = $price;
                } else {
                    $Price = $price;
                    $PriceOnlineWithoutDiscount = 0;
                }

                $this->Room_byHotel[$room['RoomCode']][$room['Date']]['Discount'] = round($discount);
                $this->Room_byHotel[$room['RoomCode']][$room['Date']]['Date'] = $room['Date'];
                $this->Room_byHotel[$room['RoomCode']][$room['Date']]['RemainingCapacity'] = $room['RemainingCapacity'];
                $this->Room_byHotel[$room['RoomCode']][$room['Date']]['PriceOnlineWithoutDiscount'] = $PriceOnlineWithoutDiscount;
                $this->Room_byHotel[$room['RoomCode']][$room['Date']]['Price'] = $Price;
                $this->Room_byHotel[$room['RoomCode']][$room['Date']]['PriceOnline'] = $room['PriceOnline'];
                $this->Room_byHotel[$room['RoomCode']][$room['Date']]['PriceForeign'] = $room['PriceForeign'];
                $this->Room_byHotel[$room['RoomCode']][$room['Date']]['PriceBoard'] = $room['PriceBoard'];

            }

            return $this->Room_byHotel;

        } else {

            return false;
        }


    }


    // markup (کمسیون آزانس)
    function getAgencyCommission($city, $hotelStar, $startDate, $nights)
    {
        $sDate_miladi = functions::ConvertToMiladi($startDate);
        $sDate_miladi = str_replace("-", "", $sDate_miladi);
        $this->agency_commission = '';
        for ($i = 0; $i < $nights; $i++) {

            $result_date = date('Ymd', strtotime("" . $sDate_miladi . ",+ $i day"));
            $Date_shamsi = functions::ConvertToJalali($result_date);

            $date = str_replace('-', '/', $Date_shamsi);

            $res = functions::getHotelPriceChange($city, $hotelStar, $this->counterId, $date, 'api');
            if ($res != false) {

                $this->agency_commission[$Date_shamsi]['result'] = true;
                $this->agency_commission[$Date_shamsi]['price'] = $res['price'];
                $this->agency_commission[$Date_shamsi]['price_type'] = $res['price_type'];
                $this->agency_commission[$Date_shamsi]['change_type'] = $res['change_type'];

            } else {

                $this->agency_commission[$Date_shamsi]['result'] = false;

            }

        }

    }


    // واکشی اطلاعات کامل یک هتل، توسط کد آن هتل
    function getInfoHotelRoom($idHotel)
    {
        functions::insertLog("Before Room_byHotel Api", "log_Api_hotel");
        $result_HotelRoom = parent::Room_byHotel($idHotel);
        functions::insertLog("After Room_byHotel Api", "log_Api_hotel");
        $this->SearchHotelRoom = $result_HotelRoom;
    }


    // جستوجو برای لیست اتاق های موجود از یک نوع اتاق خاص در یک بازه تاریخی و بازگرداندن لیست قیمت و ظرفیت
    function getRoomPriceStartDate($idHotel, $roomCode, $startDate, $nightCount)
    {
        $date = explode('-', $startDate);
        $start_date = $date[0] . $date[1] . $date[2];

        $result_RoomPrice = parent::RoomPriceStartDate($idHotel, $roomCode, $start_date, $nightCount);
        $this->RoomPrice_startDate = $result_RoomPrice;

        $this->RemainingCapacity = "yes";
        foreach ($result_RoomPrice as $room) {
            if ($room['RemainingCapacity'] == 0) {
                $this->RemainingCapacity = "No";
            }
        }

    }


    public function CounterRoomReserve($idRoom)
    {
        if ($_POST['RoomCount' . $idRoom] > 0) {
            return $_POST['RoomCount' . $idRoom];
        } else {
            return $_POST['RoomCount_Reserve' . $idRoom];
        }
    }


    // رزرو یک اتاق یا بیشتر به صورت موقت، و بازگرداندن یک شماره درخواست و شماره ( پی ان آر ) برای اعمال دستورات بر روی این رزرو
    function HotelReserveRoom($hotelCode, $roomTypeCodes, $numberOfRooms, $startDate, $nightCount)
    {

        $date = explode('-', $startDate);
        $start_date = $date[0] . $date[1] . $date[2];

        $result_HotelReserveRoom = parent::Hotel_Reserve_Room($hotelCode, $roomTypeCodes, $numberOfRooms, $start_date, $nightCount);
        $this->result_HotelReserveRoom = $result_HotelReserveRoom;

    }

    public function getPassengersDetailHotel($factorNumber, $startDate, $nights, $TotalNumberRoom_Reserve)
    {

        $Model = Load::library('Model');

        $TotalNumberRoom = explode(",", $TotalNumberRoom_Reserve);
        for ($c = 0; $c < count($TotalNumberRoom); $c++) {

            $RoomType = explode("-", $TotalNumberRoom[$c]);
            $price_current = 0;
            $price_foreign_current = 0;
            $price_online_current = 0;
            $price_board_current = 0;
            $agency_commission = 0;
            $price = 0;

            for ($n = 0; $n < $nights; $n++) {

                $sDate_miladi = functions::ConvertToMiladi($startDate);
                $sDate_miladi = str_replace("-", "", $sDate_miladi);
                $Sdate_onreq = date('Ymd', strtotime("" . $sDate_miladi . ",+" . $n . " day"));
                $SDate = functions::ConvertToJalali($Sdate_onreq);

                $sql_check_temprory = " SELECT * FROM temprory_hotel_local_tb WHERE factor_number ='{$factorNumber}'
                        AND room_id='{$RoomType[0]}' AND date_current='{$SDate}' ";
                $temproryHotel = $Model->load($sql_check_temprory);


                if ($temproryHotel['type_of_price_change'] == 'increase' && $temproryHotel['agency_commission_price_type'] == 'cost') {
                    $price = $temproryHotel['price_current'] + $temproryHotel['agency_commission'];

                } elseif ($temproryHotel['type_of_price_change'] == 'decrease' && $temproryHotel['agency_commission_price_type'] == 'cost') {
                    $price = $temproryHotel['price_current'] - $temproryHotel['agency_commission'];

                } elseif ($temproryHotel['type_of_price_change'] == 'increase' && $temproryHotel['agency_commission_price_type'] == 'percent') {
                    $price = ($temproryHotel['price_current'] * $temproryHotel['agency_commission'] / 100) + $temproryHotel['price_current'];

                } elseif ($temproryHotel['type_of_price_change'] == 'decrease' && $temproryHotel['agency_commission_price_type'] == 'percent') {
                    $price = ($temproryHotel['price_current'] * $temproryHotel['agency_commission'] / 100) - $temproryHotel['price_current'];

                } else {
                    $price = $temproryHotel['price_current'] * $temproryHotel['room_count'];
                }


                if (!empty($this->serviceDiscount['api']) && $this->serviceDiscount['api']['off_percent'] > 0) {
                    $price = $price - (($price * $this->serviceDiscount['api']['off_percent']) / 100);
                }

                /*$price_current += $price * $temproryHotel['room_count'];
                $price_online_current += $temproryHotel['price_online_current'] * $temproryHotel['room_count'];
                $price_board_current += $temproryHotel['price_board_current'] * $temproryHotel['room_count'];
                $price_foreign_current += $temproryHotel['price_foreign_current'] * $temproryHotel['room_count'];
                $agency_commission += $temproryHotel['agency_commission'] * $temproryHotel['room_count'];*/

                $price_current += $price;
                $price_online_current += $temproryHotel['price_online_current'];
                $price_board_current += $temproryHotel['price_board_current'];
                $price_foreign_current += $temproryHotel['price_foreign_current'];
                $agency_commission += $temproryHotel['agency_commission'];


                if ($n == 0) {
                    $this->temproryHotel[$c] = $temproryHotel;
                    if (SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' || substr($startDate, "0", "4") > 2000){
                        $this->temproryHotel[$c]['start_date'] = functions::ConvertToMiladi($temproryHotel['start_date']);
                        $this->temproryHotel[$c]['end_date'] = functions::ConvertToMiladi($temproryHotel['end_date']);
                    }
                }

            }

            $this->temproryHotel[$c]['price'] = $price;
            $this->temproryHotel[$c]['room_price_current'] = $price_current;
            $this->temproryHotel[$c]['room_price_online_current'] = $price_online_current;
            $this->temproryHotel[$c]['room_price_board_current'] = $price_board_current;
            $this->temproryHotel[$c]['room_price_foreign_current'] = $price_foreign_current;
            $this->temproryHotel[$c]['room_agency_commission'] = $agency_commission;

        }

    }


    public function format_hour($num)
    {
        $time = date("H:i", strtotime($num));
        return $time;
    }

    public function getHotelDataNew($factorNumber)
    {
        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $sql = "select * from report_hotel_tb where factor_number='{$factorNumber}' ";
            $info_hotel = $ModelBase->select($sql);

        } else {

            $Model = Load::library('Model');
            $sql = "select * from book_hotel_local_tb where factor_number='{$factorNumber}' ";
            $info_hotel = $Model->select($sql);
        }

        if ($info_hotel[0]['member_id']) {
            $counterTypeId = functions::getCounterTypeId($info_hotel[0]['member_id']);
        } else {
            $counterTypeId = '5';
        }
        $this->counterTypeId = $counterTypeId;
        $this->counterName = functions::getCounterName($counterTypeId);
        $this->countHotel = count($info_hotel);

        return $info_hotel;
    }

    public function getInfoRoomHotelForPrint($factorNumber)
    {
        $Model = Load::library('Model');

        $sql = " SELECT * FROM book_hotel_local_tb WHERE factor_number ='{$factorNumber}' ORDER BY room_id, flat_type ";
        $result = $Model->select($sql);

        $AuxiliaryVariableRoom = $result[0]['room_id']; // Group by room
        $index = 0;
        $indexRoom = 0;
        $room_price = 0;
        $totalPrice = 0;
        $count_EXT = 0;
        $price_EXT = 0;
        $count_ECHD = 0;
        $price_ECHD = 0;
        foreach ($result as $hotel) {


            // Group by room
            if ($AuxiliaryVariableRoom != $hotel['room_id']) {
                $AuxiliaryVariableRoom = $hotel['room_id'];
                $indexRoom = 0;
                $room_price = 0;
            }

            switch ($hotel['flat_type']) {
                case 'DBL':
                    $room_price += $hotel['room_price'] * $hotel['room_count'];
                    break;
                case 'EXT':
                    $count_EXT++;
                    $price_EXT += $hotel['room_price'];
                    $totalPrice += $hotel['room_price'];

                    $infoRooms['room'][$hotel['room_id']]['bed'][$index]['room_name'] = $hotel['room_name'];
                    $infoRooms['room'][$hotel['room_id']]['bed'][$index]['number_night'] = $hotel['number_night'];
                    $infoRooms['room'][$hotel['room_id']]['bed'][$index]['flat_type'] = 'تخت اضافه بزرگسال';
                    $infoRooms['room'][$hotel['room_id']]['bed'][$index]['room_count'] = '1';
                    $infoRooms['room'][$hotel['room_id']]['bed'][$index]['price_current'] = $hotel['price_current'];
                    $infoRooms['room'][$hotel['room_id']]['bed'][$index]['room_price'] = $hotel['room_price'];
                    break;
                case 'ECHD':
                    $count_ECHD++;
                    $price_ECHD += $hotel['room_price'];
                    $totalPrice += $hotel['room_price'];

                    $infoRooms['room'][$hotel['room_id']]['bed'][$index]['room_name'] = $hotel['room_name'];
                    $infoRooms['room'][$hotel['room_id']]['bed'][$index]['number_night'] = $hotel['number_night'];
                    $infoRooms['room'][$hotel['room_id']]['bed'][$index]['flat_type'] = 'تخت اضافه کودک';
                    $infoRooms['room'][$hotel['room_id']]['bed'][$index]['room_count'] = '1';
                    $infoRooms['room'][$hotel['room_id']]['bed'][$index]['price_current'] = $hotel['price_current'];
                    $infoRooms['room'][$hotel['room_id']]['bed'][$index]['room_price'] = $hotel['room_price'];
                    break;
                default:
            }

            #region[info room]
            if ($indexRoom == 0) {

                $infoRooms['room'][$hotel['room_id']]['room_name'] = $hotel['room_name'];
                $infoRooms['room'][$hotel['room_id']]['number_night'] = $hotel['number_night'];
                $infoRooms['room'][$hotel['room_id']]['flat_type'] = 'تخت اصلی';
                $infoRooms['room'][$hotel['room_id']]['room_count'] = $hotel['room_count'];
                $infoRooms['room'][$hotel['room_id']]['price_current'] = $hotel['price_current'];
                $infoRooms['room'][$hotel['room_id']]['room_price'] = $room_price;

                $totalPrice += $room_price;

            }
            #endregion


            $index++;
            $indexRoom++;
        }

        $infoRooms['count_EXT'] = $count_EXT;
        $infoRooms['price_EXT'] = $price_EXT;
        $infoRooms['count_ECHD'] = $count_ECHD;
        $infoRooms['price_ECHD'] = $price_ECHD;
        $infoRooms['total_price'] = $totalPrice;


        return $infoRooms;
    }

    public function set_date_reserve($date)
    {
        $date_orginal_exploded = explode(' ', $date);
        $date_miladi_exp = explode('-', $date_orginal_exploded[0]);
        return dateTimeSetting::gregorian_to_jalali($date_miladi_exp[0], $date_miladi_exp[1], $date_miladi_exp[2], '/');
    }

    public function set_time_payment($date)
    {
        $date_orginal_exploded = explode(' ', $date);
        return $date_orginal_exploded[1];
    }

    // Calculate age from a specified date
    public function getAgeFa($birthday)
    {
        if (!empty($birthday) && $birthday != '0000-00-00') {
            $birthday = functions::ConvertToMiladi($birthday);
            $birthday = str_replace("-", "", $birthday);
            $year = substr($birthday, 0, 4);
            $month = substr($birthday, 4, 2);
            $day = substr($birthday, 6, 2);

            $b = $year . '-' . $month . '-' . $day;
            $age = date_create($b)->diff(date_create('today'))->y;

            return $age;
        } else {
            return '0';
        }

    }

    public function getAgeEn($birthday)
    {
        if (!empty($birthday) && $birthday != '0000-00-00') {
            $birthday = explode("-", $birthday);
            $b = $birthday[0] . '-' . $birthday[1] . '-' . $birthday[2];
            $age = date_create($b)->diff(date_create('today'))->y;

            return $age;
        } else {
            return '0';
        }


    }








////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////Reservation///////////////////////////////////////////////////


    public function getStartDateToday()
    {

        $dateMiladi = date('Ymd');
        $sDateMiladi = str_replace("-", "", $dateMiladi);
        $result = date('Ymd', strtotime("" . $sDateMiladi . ",+ 1 day"));

        if (SOFTWARE_LANG == 'fa'){

            return functions::ConvertToJalali($result);
        }else{

            $y = substr($result, 0, 4);
            $m = substr($result, 4, 2);
            $d = substr($result, 6, 2);
            $dateFa = $y . '-' . $m . '-' . $d;

            return $dateFa;
        }
    }

    public function getEndDateToday()
    {
        $dateMiladi = date('Ymd');
        $sDateMiladi = str_replace("-", "", $dateMiladi);
        $result = date('Ymd', strtotime("" . $sDateMiladi . ",+ 2 day"));
        return functions::ConvertToJalali($result);
    }

    public function checkSellForNight($idHotel, $nights, $typeApplication)
    {

        $Model = Load::library('Model');

        if ($typeApplication == 'reservation') {

            $sql = " SELECT sell_for_night FROM reservation_hotel_room_prices_tb WHERE id_hotel='{$idHotel}' AND is_del='no' GROUP BY id_room";
            $ResultHotelRoom = $Model->select($sql);

            if (!empty($ResultHotelRoom)) {


                //list sell for night
                $arr_sell_for_night = explode("/", $ResultHotelRoom[0]['sell_for_night']);

                $count_arr = count($arr_sell_for_night);

                $ErrorSellForNight = "Yes";
                for ($countNight = 0; $countNight < $count_arr; $countNight++) {

                    if ($nights == $arr_sell_for_night[$countNight]) {
                        $ErrorSellForNight = "No";
                        break;
                    }

                }

                if ($ErrorSellForNight == "Yes") {


                    for ($countNight = 0; $countNight < $count_arr; $countNight++) {

                        if ($arr_sell_for_night[$countNight] > $nights) {
                            $stayingTime = $arr_sell_for_night[$countNight];
                            break;
                        }

                    }


                    if ($stayingTime) {
                        $this->stayingTime = $stayingTime;
                    } else if ($arr_sell_for_night[$count_arr] > 0) {
                        $this->stayingTime = $arr_sell_for_night[$count_arr];
                    } else {
                        $this->stayingTime = $arr_sell_for_night[$count_arr - 1];
                    }

                } else {

                    $this->stayingTime = $nights;

                }


            } else {

                $this->stayingTime = $nights;
            }


        } else {

            $this->stayingTime = $nights;
        }


    }


    // واکشی اطلاعات کامل هتل رزرواسیون، توسط کد آن هتل
    function getReservationHotel($idHotel)
    {
        $Model = Load::library('Model');

        $sql = " SELECT name, address, star_code, rules, logo, transfer_went, transfer_back, country, city
                 FROM 
                  reservation_hotel_tb
                 WHERE id='{$idHotel}' AND is_del='no' ";
        $ResultHotel = $Model->Load($sql);

        $this->infoReservationHotel = $ResultHotel;
        if ($ResultHotel['country'] == '1') {
            $this->infoReservationHotel['ZoneFlight'] = 'Local';
        } else {
            $this->infoReservationHotel['ZoneFlight'] = 'International';
        }
        $this->transfer_went = $ResultHotel['transfer_went'];
        $this->transfer_back = $ResultHotel['transfer_back'];
    }
    // واکشی اطلاعات کامل اتاق های یک هتل رزرواسیون، توسط کد آن هتل
    function getHotelRoom($idHotel)
    {


        $Model = Load::library('Model');
        $sql = " SELECT * FROM reservation_hotel_room_tb WHERE id_hotel='{$idHotel}' AND is_del='no' ";

        $ResultHotelRoom = $Model->select($sql);

        $this->reservationHotelRoom = $ResultHotelRoom;
    }

    public function explodeRoom($expression)
    {
        $result = explode("-", $expression);
        $this->typeRoom = $result[0];
        $this->typeTitle = $result[1];
        $this->typeQuality = $result[2];
    }

    function checkForReserve($param)
    {
        $Model = Load::library('Model');

        if (SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' || substr($param['startDate'], "0", "4") > 2000){
            $param['startDate'] = functions::ConvertToJalali($param['startDate']);
            $param['endDate'] = functions::ConvertToJalali($param['endDate']);
        }

        $StartDate = str_replace("-", "", $param['startDate']);
        $EndDate = str_replace("-", "", $param['endDate']);

        $checkReserve = 0;
        while ($StartDate < $EndDate) {

            $sql = "SELECT
                    id_room, date, flat_type, total_capacity, maximum_capacity, remaining_capacity
                 FROM 
                    reservation_hotel_room_prices_tb
                 WHERE 
                    id_hotel='{$param['idHotel']}' AND
                    id_room='{$param['idRoom']}' AND
                    flat_type='DBL' AND
                    user_type='{$this->counterId}' AND
                    date='{$StartDate}' AND 
                    remaining_capacity > 0  AND 
                    is_del='no' ";

            $result_Hotel_AllRoomPrice = $Model->select($sql);


            if (empty($result_Hotel_AllRoomPrice)) {
                $checkReserve++;
            }


            //روز بعدی//
            $date_miladi = dateTimeSetting::jalali_to_gregorian(substr($StartDate, 0, 4), substr($StartDate, 4, 2), substr($StartDate, 6, 2));
            $DMiladi = implode('', $date_miladi);
            $date_onreq = date('Ymd', strtotime($DMiladi . " + 1 day"));
            $date_shamsi = dateTimeSetting::gregorian_to_jalali(substr($date_onreq, 0, 4), substr($date_onreq, 4, 2), substr($date_onreq, 6, 2));
            $StartDate = implode('', $date_shamsi);

        }//end while $StartDate<=$EndDate

        if ($checkReserve == 0) {
            return 'success';
        } else {
            return 'error';
        }


    }


    // واکشی اطلاعات کامل قیمت اتاق های یک هتل رزرواسیون، توسط کد آن هتل و تاریخ شروع و مدت اقامت
    function getHotelRoomPrices($idHotel, $StartDate, $EndDate)
    {

        $isMiladi = false;
        if (SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' || substr($StartDate, "0", "4") > 2000){
            $StartDate = functions::ConvertToJalali($StartDate);
            $EndDate = functions::ConvertToJalali($EndDate);
            $isMiladi = true;
        }

        $StartDate = str_replace("-", "", $StartDate);
        $EndDate = str_replace("-", "", $EndDate);
        $Model = Load::library('Model');

        $sql = " SELECT
                    id, id_room, date, discount, board_price, online_price, flat_type,
                    currency_price, currency_type, total_capacity, guest_user_status,
                    maximum_capacity, remaining_capacity, breakfast,
                    lunch, dinner, sell_for_night, id_city, other_services, specific_description , fromAge , toAge
                 FROM 
                    reservation_hotel_room_prices_tb
                 WHERE 
                    id_hotel='{$idHotel}' AND
                
                    user_type='{$this->counterId}' AND
                    date>='{$StartDate}' AND date<'{$EndDate}' AND 
                    is_del='no' ";



        $result_Hotel_AllRoomPrice = $Model->select($sql);


        $sql_hotel = " SELECT * 
                 FROM 
                    reservation_hotel_tb
                 WHERE 
                    id='{$idHotel}' AND is_del='no' ";

        $Hotel  = $Model->load($sql_hotel);

        if($Hotel['user_id']) {
            $priceChanges = functions::getMarketHotelPriceChange($idHotel , $this->counterId, $StartDate, 'marketplaceHotel' );
            $discount_hotel = functions::marketServiceDiscount($this->counterId,'marketplaceHotel' , $idHotel);
        }


        foreach ($result_Hotel_AllRoomPrice as $room) {

            $date = substr($room['date'], "0", "4") . '-' . substr($room['date'], "4", "2") . '-' . substr($room['date'], "6", "2");
            if (SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' || $isMiladi){
                $date = functions::ConvertToMiladi($date);
            }
            if($Hotel['user_id'] && ($priceChanges || $discount_hotel)) {

                $calculated = self::calculateRoomPrice($room, $priceChanges, $discount_hotel);

            }
            $currencyPriceWithDiscount = $room['currency_price'];
            $currency_amount_with_discount = null;
            if($room['currency_price'] > 0 && isset($room['discount']) && $room['discount'] > 0){
                $currencyPriceWithDiscount = $currencyPriceWithDiscount * (100 - $room['discount']) / 100;
                $currency_amount_with_discount = functions::CalculateCurrencyPrice([
                    'price' => $currencyPriceWithDiscount,
                    'currency_type' => $room['currency_type']
                ]);
            }

            $currency_amount_with_out_discount = functions::CalculateCurrencyPrice([
                'price' => $room['currency_price'],
                'currency_type' => $room['currency_type']
            ]);
            if ($room['flat_type'] == 'DBL') {


                $specific_description = str_replace(array("\r\n", "\n"), array("<br />", "<br />"), $room['specific_description']);
                $other_services = str_replace(array("\r\n", "\n"), array("<br />", "<br />"), $room['other_services']);

                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['id'] = $room['id'];
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['Date'] = $date;
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['TotalCapacity'] = $room['total_capacity'];
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['MaximumCapacity'] = $room['maximum_capacity'];
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['RemainingCapacity'] = $room['remaining_capacity'];
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['Breakfast'] = $room['breakfast'];
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['Lunch'] = $room['lunch'];
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['Dinner'] = $room['dinner'];
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['SellForNight'] = $room['sell_for_night'];
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['SpecificDescription'] = $specific_description;
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['OtherServices'] = $other_services;

                if(isset($calculated)) {

                    $online_price = $calculated['Online'];
                    $board_price = $calculated['afterChange'];


                }else{

                    $online_price = $room['online_price'];
                    $board_price = $room['board_price'];
                }

                if($room['currency_price'] > 0) {

                    if($currency_amount_with_discount){
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoardForView'] = /*$board_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnlineForView'] = /*$online_price +*/ $currency_amount_with_discount['AmountCurrency'];
                    }else{
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoardForView'] = /*$board_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnlineForView'] = /*$online_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                    }

                }
                else {
                    $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnlineForView'] = $online_price;
                    $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoardForView'] = $board_price;

                }


                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceCurrencyForView'] = $currency_amount_with_out_discount['AmountCurrency'];
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['CurrencyTypeForView'] = $room['currency_type'];
                if(isset($calculated)) {
                    $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['Discount'] = $calculated['Discount']['off_percent'] +  $room['discount'];
                }else {
                    $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['Discount'] = $room['discount'];
                }


                if ($this->IsLogin || $room['guest_user_status'] == 'yes') {
                    if(isset($calculated)) {
                        $online_price = $calculated['Online'];
                        $board_price = $calculated['Board'];
                    }else{
                        $online_price = $room['online_price'];
                        $board_price = $room['board_price'];
                    }
                    if($room['currency_price'] > 0 ) {
                        /*$currency_amount = functions::CalculateCurrencyPrice( [
                            'price' => $currencyPriceWithDiscount ,
                            'currency_type' => $room['currency_type']
                        ]);*/

                        if($currency_amount_with_discount){
                            $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoard'] = /*$board_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                            $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnline']  = /*$online_price +*/ $currency_amount_with_discount['AmountCurrency'];
                        }else{
                            $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoard'] = /*$board_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                            $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnline'] = /*$online_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                        }
                    }else {
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnline'] = $online_price;
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoard'] = $board_price;
                    }

                    $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['statusDiscount'] = 'yes';

                } else {
                    if(isset($calculated)) {
                        $online_price = $calculated['Online'];
                        $board_price = $calculated['Board'];
                    }else{
                        $online_price = $room['online_price'];
                        $board_price =  $room['board_price'];
                    }
                    if($room['currency_price'] > 0 ) {
/*                        $currency_amount = functions::CalculateCurrencyPrice( [
                            'price' => $currencyPriceWithDiscount ,
                            'currency_type' => $room['currency_type']
                        ] );*/
                        if($currency_amount_with_discount){
                            $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoard'] = /*$board_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                            $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnline']  = /*$online_price +*/ $currency_amount_with_discount['AmountCurrency'];
                        }else{
                            $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoard'] = /*$board_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                            $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnline'] = /*$online_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                        }


                    }else {
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnline'] = $board_price;
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoard'] = $board_price;
                    }
                    $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['statusDiscount'] = 'no';

                }
            }elseif (($room['flat_type'] == 'ECHD'))
            {
                if(isset($calculated)) {
                    $online_price = $calculated['Online'];
                    $board_price = $calculated['Board'];
                }else{
                    $online_price = $room['online_price'];
                    $board_price =  $room['board_price'];
                }

                // اضافه کردن شرط برای کاربران لاگین شده/مهمان
                if ($this->IsLogin || $room['guest_user_status'] == 'yes') {
                    $final_online_price = $online_price;
                    $final_board_price = $board_price;
                } else {
                    $final_online_price = $board_price;
                    $final_board_price = $board_price;
                }

                if($room['currency_price'] > 0 ) {
/*                    $currency_amount = functions::CalculateCurrencyPrice( [
                        'price' => $currencyPriceWithDiscount ,
                        'currency_type' => $room['currency_type']
                    ] );*/
                    if($currency_amount_with_discount){
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoard'] = /*$board_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnline']  = /*$online_price +*/ $currency_amount_with_discount['AmountCurrency'];
                    }else{
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoard'] = /*$board_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnline'] = /*$online_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                    }
                    if($currency_amount_with_discount){
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoardForView'] = /*$board_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnlineForView'] = /*$online_price +*/ $currency_amount_with_discount['AmountCurrency'];
                    }else{
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoardForView'] = /*$board_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnlineForView'] = /*$online_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                    }


                }else {
                    $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnline'] = $final_online_price;
                    $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoard'] = $final_board_price;

                    // اضافه کردن مقادیر ForView برای ECHD
                    $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnlineForView'] = $online_price;
                    $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoardForView'] = $board_price;
                }

                // اضافه کردن سایر فیلدهای لازم برای ECHD
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['id'] = $room['id'];
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['Date'] = $date;
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['fromAge'] = $room['fromAge'];
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['toAge'] = $room['toAge'];
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['Discount'] = $room['discount'];
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceCurrencyForView'] = $room['currency_price'];
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['CurrencyTypeForView'] = $room['currency_type'];
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['statusDiscount'] = ($this->IsLogin || $room['guest_user_status'] == 'yes') ? 'yes' : 'no';
            }elseif (($room['flat_type'] == 'EXT'))
            {
                if(isset($calculated)) {
                    $online_price = $calculated['Online'];
                    $board_price = $calculated['Board'];
                }else{
                    $online_price = $room['online_price'];
                    $board_price =  $room['board_price'];
                }

                // اضافه کردن شرط برای کاربران لاگین شده/مهمان
                if ($this->IsLogin || $room['guest_user_status'] == 'yes') {
                    $final_online_price = $online_price;
                    $final_board_price = $board_price;
                } else {
                    $final_online_price = $board_price;
                    $final_board_price = $board_price;
                }

                if($room['currency_price'] > 0 ) {
/*                    $currency_amount = functions::CalculateCurrencyPrice( [
                        'price' => $currencyPriceWithDiscount ,
                        'currency_type' => $room['currency_type']
                    ] );*/
                    if($currency_amount_with_discount){
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoard'] = /*$board_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnline']  = /*$online_price +*/ $currency_amount_with_discount['AmountCurrency'];
                    }else{
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoard'] = /*$board_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnline'] = /*$online_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                    }
                    if($currency_amount_with_discount){
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoardForView'] = /*$board_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnlineForView'] = /*$online_price +*/ $currency_amount_with_discount['AmountCurrency'];
                    }else{
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoardForView'] = /*$board_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnlineForView'] = /*$online_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                    }

                }else {
                    $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnline'] = $final_online_price;
                    $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoard'] = $final_board_price;

                    // اضافه کردن مقادیر ForView برای EXT
                    $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnlineForView'] = $online_price;
                    $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoardForView'] = $board_price;
                }

                // اضافه کردن سایر فیلدهای لازم برای EXT
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['id'] = $room['id'];
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['Date'] = $date;
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['Discount'] = $room['discount'];
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceCurrencyForView'] = $currency_amount_with_out_discount['AmountCurrency'];
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['CurrencyTypeForView'] = $room['currency_type'];
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['statusDiscount'] = ($this->IsLogin || $room['guest_user_status'] == 'yes') ? 'yes' : 'no';


            }
            else {
                if(isset($calculated)) {
                    $online_price = $calculated['Online'];
                    $board_price = $calculated['Board'];
                }else{
                    $online_price = $room['online_price'];
                    $board_price =  $room['board_price'];
                }
                if($room['currency_price'] > 0 ) {
/*                    $currency_amount = functions::CalculateCurrencyPrice( [
                        'price' => $currencyPriceWithDiscount ,
                        'currency_type' => $room['currency_type']
                    ] );*/
                    if($currency_amount_with_discount){
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoard'] = /*$board_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnline']  = /*$online_price +*/ $currency_amount_with_discount['AmountCurrency'];
                    }else{
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoard'] = /*$board_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                        $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnline'] = /*$online_price +*/ $currency_amount_with_out_discount['AmountCurrency'];
                    }

                }else {
                    $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnline'] = $online_price;
                    $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoard'] = $board_price;
                }
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['id'] = $room['id'];
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['Date'] = $date;
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['fromAge'] = $room['fromAge'];
                $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['toAge'] = $room['toAge'];


                /*if ($this->IsLogin){
                    $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnline'] = $room['online_price'];
                    $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoard'] = $room['board_price'];
                }else {
                    $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceOnline'] = $room['board_price'];
                    $this->RoomPrices[$room['id_room']][$room['flat_type']][$date]['PriceBoard'] = $room['board_price'];
                }*/


            }


        }


    }

    function getInfoRoom($idHotel)
    {

        $Model = Load::library('Model');

        #region [عکس اتاق]
        $sql_gallery = " SELECT
                    HR.room_comment, G.pic, G.name, G.comment, G.id_room
                 FROM
                    reservation_hotel_room_tb HR INNER JOIN reservation_room_gallery_tb G ON HR.id=G.id_hotel
                 WHERE 
                    G.id_hotel='{$idHotel}' AND
                    G.is_del='no'
                 ORDER BY HR.id_room ";
        $result_room_gallery = $Model->select($sql_gallery);
        foreach ($result_room_gallery as $key => $gallery) {

            if (isset($gallery['pic']) && $gallery['pic'] != '') {

                $this->infoRoomGallery[$gallery['id_room']] = "true";

                $exp = explode(".", $gallery['pic']);

                $this->roomGallery[$gallery['id_room']][$key]['room_comment'] = $gallery['room_comment'];
                $this->roomGallery[$gallery['id_room']][$key]['pic_url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . $gallery['pic'];
                $this->roomGallery[$gallery['id_room']][$key]['pic_name'] = $gallery['name'];
                $this->roomGallery[$gallery['id_room']][$key]['pic_comment'] = $gallery['comment'];
                $this->roomGallery[$gallery['id_room']][$key]['pic_format'] = $exp[1];
            }

        }
        #endregion


        #region [امکانات اتاق]
        $sql_facilities = " SELECT
                    F.title, F.icon_class, RF.id_room
                 FROM
                    reservation_room_facilities_tb RF INNER JOIN reservation_facilities_tb F ON RF.id_facilities=F.id
                 WHERE 
                    RF.id_hotel='{$idHotel}' AND
                    RF.is_del='no'
                 ORDER BY RF.id_room ";
        $result_room_facilities = $Model->select($sql_facilities);
        foreach ($result_room_facilities as $key => $facilities) {

            if (isset($facilities['title']) && $facilities['title'] != '') {

                $this->infoRoomFacilities[$facilities['id_room']] = "true";

                $this->roomFacilities[$facilities['id_room']][$key]['title'] = $facilities['title'];
                $this->roomFacilities[$facilities['id_room']][$key]['icon_class'] = $facilities['icon_class'];
            }

        }
        #endregion

    }

    public function getPassengersDetailHotelForReservation($param)
    {


        $Model = Load::library('Model');

        if (SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' || substr($param['startDate_reserve'], "0", "4") > 2000){
            $param['startDate_reserve'] = functions::ConvertToJalali($param['startDate_reserve']);
            $param['endDate_reserve'] = functions::ConvertToJalali($param['endDate_reserve']);
        }

        $startDate = str_replace("-", "", $param['startDate_reserve']);
        $endDate = str_replace("-", "", $param['endDate_reserve']);
        $TotalNumberRoom = explode("/", $param['TypeRoomHotel']);

        $hotelId = $param['idHotel_reserve'];

        $TotalRoomId = '';
        for ($c = 0; $c < count($TotalNumberRoom); $c++) {

            $roomId = $TotalNumberRoom[$c];
            // اگر اتاق انتخخاب شده بود
            if (isset($param['RoomCount' . $roomId]) && $param['RoomCount' . $roomId] > 0) {

                $TotalRoomId .= $roomId . "/";

                $sql = "
                SELECT
                        RP.id_room, RP.date, RP.discount, RP.board_price, RP.online_price, RP.flat_type,
                        RP.fromAge,RP.toAge,RP.discount_status,
                        RP.currency_price, RP.currency_type, HR.room_name, HR.room_capacity,
                        HR.room_name_en, HR.maximum_extra_beds, HR.maximum_extra_chd_beds, RP.id_country,
                        RP.breakfast, RP.lunch, RP.dinner, RP.id as IdHotelRoomPrice, RP.guest_user_status,
                     (
                        select CRP.online_price
                            from 
                                     reservation_hotel_room_prices_tb CRP LEFT JOIN reservation_hotel_room_tb CHR ON CRP.id_room=CHR.id_room
                            where  
                                     CRP.id_hotel='{$hotelId}' AND 
                                     CRP.id_room='{$roomId}' AND 
                                     CRP.is_del='no' AND 
                                     CRP.user_type='{$this->counterId}' AND 
                                     CRP.flat_type='ECHD' AND 
                                     CRP.date=RP.date
                            group by
                                        CRP.flat_type
                        ) as cost_chd
                        ,
                     (
                        select ERP.online_price
                            from 
                                     reservation_hotel_room_prices_tb ERP LEFT JOIN reservation_hotel_room_tb EHR ON ERP.id_room=EHR.id_room
                            where  
                                     ERP.id_hotel='{$hotelId}' AND 
                                     ERP.id_room='{$roomId}' AND 
                                     ERP.is_del='no' AND 
                                     ERP.user_type='{$this->counterId}' AND 
                                     ERP.flat_type='EXT' AND 
                                     ERP.date=RP.date
                            group by
                                        ERP.flat_type
                        ) as cost_ext
                     FROM 
                        reservation_hotel_room_prices_tb RP 
                        LEFT JOIN reservation_hotel_room_tb HR ON RP.id_room=HR.id_room AND HR.id_hotel=RP.id_hotel
                     WHERE 
                        RP.id_hotel='{$hotelId}' AND
                        RP.id_room='{$roomId}' AND
                        RP.is_del='no' AND
                        RP.user_type='{$this->counterId}' AND
                        RP.date>='{$startDate}' AND RP.date<'{$endDate}'
                     GROUP BY RP.date";



                $ResultHotelRoom = $Model->select($sql);


                $sql_hotel = "
                    SELECT * from reservation_hotel_tb
                    where id = '{$hotelId}'
                ";
                $hotel = $Model->load($sql_hotel);
                if($hotel['user_id']) {
                    $priceChanges = functions::getMarketHotelPriceChange($hotelId , $this->counterId, $startDate, 'marketplaceHotel' );
                    $discount_hotel = functions::marketServiceDiscount($this->counterId,'marketplaceHotel' , $hotelId);
                }


                $this->guestUserStatus = $ResultHotelRoom[0]['guest_user_status'];

                $this->errorUserType = "false";
                // اگر برای اتاق قیمت گذاری شده بود
                if (!empty($ResultHotelRoom)) {

                    $totalPriceBedDBL = 0;
                    $totalPriceBedEXT = 0;
                    $totalPriceBedCHD = 0;
                    $RoomPrice1night = 0;
                    // بدست آوردن اطلاعات و قیمت اتاق و تخت اضافه
                    foreach ($ResultHotelRoom as $k => $val) {


                        if ($this->IsLogin || $val['guest_user_status'] == 'yes') {
                            $selectField = 'online_price';
                        } else {

                            if ($val['discount_status'] == 1) {
                                $selectField = 'board_price';
                            } elseif ($val['discount_status'] == 2) {
                                $selectField = 'online_price';
                            }
                        }

                        if ($k == 0) {

                            $this->temproryHotelRoom[$roomId]['IdRoom'] = $roomId;
                            $this->temproryHotelRoom[$roomId]['IdHotelRoomPrice'] = $val['IdHotelRoomPrice'];
                            $this->temproryHotelRoom[$roomId]['RoomName'] = $val['room_name'];
                            $this->temproryHotelRoom[$roomId]['RoomCapacity'] = $val['room_capacity'];
                            $this->temproryHotelRoom[$roomId]['room_name_en'] = $val['room_name_en'];
                            $this->temproryHotelRoom[$roomId]['maximum_extra_beds'] = $val['maximum_extra_beds'];
                            $this->temproryHotelRoom[$roomId]['maximum_extra_chd_beds'] = $val['maximum_extra_chd_beds'];
                            $this->temproryHotelRoom[$roomId]['RoomCount'] = $param['RoomCount' . $roomId];
                            $this->temproryHotelRoom[$roomId]['ExtraChildBedCount'] = (isset($param['RoomCountECHD' . $roomId]) && $param['RoomCountECHD' . $roomId] > 0) ? $param['RoomCountECHD' . $roomId] : 0;
                            $this->temproryHotelRoom[$roomId]['ExtraChildBedPrice'] = (isset($param['priceRoomECHD' . $roomId]) && $param['priceRoomECHD' . $roomId] > 0) ? $param['priceRoomECHD' . $roomId] : 0;
                            $this->temproryHotelRoom[$roomId]['ExtBedCount'] = (isset($param['RoomCountEXT' . $roomId]) && $param['RoomCountEXT' . $roomId] > 0) ? $param['RoomCountEXT' . $roomId] : 0;
                            $this->temproryHotelRoom[$roomId]['ExtBedPrice'] = (isset($param['priceRoomEXT' . $roomId]) && $param['priceRoomEXT' . $roomId] > 0) ? $param['priceRoomEXT' . $roomId] : 0;

                            $this->temproryHotelRoom[$roomId]['fromAge'] = isset($param['extra_child_from_age' . $roomId]) ? $param['extra_child_from_age' . $roomId] : 0;
                            $this->temproryHotelRoom[$roomId]['toAge'] = isset($param['extra_child_to_age' . $roomId]) ? $param['extra_child_to_age' . $roomId] : 0;
                            $this->temproryHotelRoom[$roomId]['Breakfast'] = $val['breakfast'];
                            $this->temproryHotelRoom[$roomId]['Lunch'] = $val['lunch'];
                            $this->temproryHotelRoom[$roomId]['Dinner'] = $val['dinner'];

                            $selected_price = $val[$selectField]  ;
                            $ext_price = $val['cost_ext']  ;
                            $child_price = $val['cost_chd']  ;
                            if($hotel['user_id']) {
                                $selected_price = functions::calculateHotelPrice($priceChanges,$discount_hotel,$val[$selectField] , true);
                                $ext_price = functions::calculateHotelPrice($priceChanges,$discount_hotel,$val['cost_ext'] , true);
                                $child_price = functions::calculateHotelPrice($priceChanges,$discount_hotel,$val['cost_chd'] , true);
                            }

                            if($val['currency_price'] > 0 ) {
                                $currency_amount = functions::CalculateCurrencyPrice([
                                    'price' => $val['currency_price'],
                                    'currency_type' => $val['currency_type']
                                ]);

                                $this->temproryHotelRoom[$roomId]['OnlinePriceDBL'] = $selected_price + $currency_amount['AmountCurrency'];
                                $this->temproryHotelRoom[$roomId]['OnlinePriceEXT'] = $ext_price + $currency_amount['AmountCurrency'];
                                $this->temproryHotelRoom[$roomId]['OnlinePriceECHD'] = $child_price + $currency_amount['AmountCurrency'];
                                $RoomPrice1night = $val[$selectField] + $currency_amount['AmountCurrency'];
                                $this->temproryHotelRoom[$roomId]['fromAge'] = $val['fromAge'];
                                $this->temproryHotelRoom[$roomId]['toAge'] = $val['toAge'];
                            }else {
                                $this->temproryHotelRoom[$roomId]['OnlinePriceDBL'] = $selected_price;
                                $this->temproryHotelRoom[$roomId]['OnlinePriceEXT'] = $ext_price;
                                $this->temproryHotelRoom[$roomId]['OnlinePriceECHD'] = $child_price;
                                $this->temproryHotelRoom[$roomId]['fromAge'] = $val['fromAge'];
                                $this->temproryHotelRoom[$roomId]['toAge'] = $val['toAge'];
                                $RoomPrice1night = $selected_price;
                            }

                            // اگر تخت اضافه بزرگسال انتخاب شده بود
                            if (isset($param['ExtraBed' . $roomId]) && $param['ExtraBed' . $roomId] > 0) {
                                if($val['currency_price'] > 0 ) {
                                    $currency_amount = functions::CalculateCurrencyPrice([
                                        'price' => $val['currency_price'],
                                        'currency_type' => $val['currency_type']
                                    ]);
                                    $RoomPrice1night += $ext_price + $currency_amount['AmountCurrency'];
                                }else {
                                    $RoomPrice1night += $ext_price;
                                }

                            }
                            // اگر تخت اضافه کودک انتخاب شده بود
                            if (isset($param['ExtraChildBed' . $roomId]) && $param['ExtraChildBed' . $roomId] > 0) {

                                if($val['currency_price'] > 0 ) {
                                    $currency_amount = functions::CalculateCurrencyPrice([
                                        'price' => $val['currency_price'],
                                        'currency_type' => $val['currency_type']
                                    ]);
                                    $RoomPrice1night += $child_price + $currency_amount['AmountCurrency'];
                                }else {
                                    $RoomPrice1night += $child_price;
                                }

                            }

                        }

                        if($val['currency_price'] > 0 ) {
                            $currency_amount = functions::CalculateCurrencyPrice([
                                'price' => $val['currency_price'],
                                'currency_type' => $val['currency_type']
                            ]);
                            $totalPriceBedDBL += $selected_price+ $currency_amount['AmountCurrency'];
                        }else {
                            $totalPriceBedDBL += $selected_price;
                        }



                        // اگر تخت اضافه بزرگسال انتخاب شده بود
                        if (isset($param['ExtraBed' . $roomId]) && $param['ExtraBed' . $roomId] > 0) {
                            if($val['currency_price'] > 0 ) {
                                $currency_amount = functions::CalculateCurrencyPrice([
                                    'price' => $val['currency_price'],
                                    'currency_type' => $val['currency_type']
                                ]);
                                $totalPriceBedEXT +=$ext_price+ $currency_amount['AmountCurrency'];
                            }else {
                                $totalPriceBedEXT += $ext_price;
                            }

                        }
                        // اگر تخت اضافه کودک انتخاب شده بود
                        if (isset($param['ExtraChildBed' . $roomId]) && $param['ExtraChildBed' . $roomId] > 0) {

                            if($val['currency_price'] > 0 ) {
                                $currency_amount = functions::CalculateCurrencyPrice([
                                    'price' => $val['currency_price'],
                                    'currency_type' => $val['currency_type']
                                ]);
                                $totalPriceBedCHD += $child_price+ $currency_amount['AmountCurrency'];
                            }else {
                                $totalPriceBedCHD += $child_price;
                            }


                        }


                    }

                    $totalPriceBedDBL = $param['RoomCount' . $roomId] * $totalPriceBedDBL;
                    if (isset($param['ExtraBed' . $roomId]) && $param['ExtraBed' . $roomId] > 0) {
                        $totalPriceBedEXT = $param['ExtraBed' . $roomId] * $totalPriceBedEXT;
                    } else {
                        $totalPriceBedEXT = 0;
                    }


                    if (isset($param['priceRoomEXT' . $roomId]) && $param['priceRoomEXT' . $roomId] > 0) {
                        $totalPriceBedRoomECHD= $param['priceRoomECHD' . $roomId] * $param['RoomCountECHD' . $roomId];
                    } else {
                        $totalPriceBedEXT = 0;
                    }
                    if (isset($param['priceRoomEXT' . $roomId]) && $param['priceRoomEXT' . $roomId] > 0) {
                        $totalPriceBedRoomEXT = $param['priceRoomEXT' . $roomId] * $param['RoomCountEXT' . $roomId];
                    } else {
                        $totalPriceBedEXT = 0;
                    }
                    if (isset($param['ExtraChildBed' . $roomId]) && $param['ExtraChildBed' . $roomId] > 0) {
                        $totalPriceBedCHD = $param['ExtraChildBed' . $roomId] * $totalPriceBedCHD;
                    } else {
                        $totalPriceBedCHD = 0;
                    }
                    $this->temproryHotelRoom[$roomId]['TotalPriceBedDBL'] = $totalPriceBedDBL;
                    $this->temproryHotelRoom[$roomId]['TotalPriceBedEXT'] = $totalPriceBedEXT;
                    $this->temproryHotelRoom[$roomId]['TotalPriceBedCHD'] = $totalPriceBedCHD;
                    $this->temproryHotelRoom[$roomId]['TotalPriceRoom'] = $totalPriceBedDBL + $totalPriceBedRoomEXT + $totalPriceBedRoomECHD + $totalPriceBedEXT + $totalPriceBedCHD;
                    $this->temproryHotelRoom[$roomId]['RoomPrice1night'] = $RoomPrice1night;
                    $this->temproryHotelRoom[$roomId]['DBL'] = $param['fkDBL' . $roomId];
                    $this->temproryHotelRoom[$roomId]['EXT'] = $param['fkEXT' . $roomId];
                    $this->temproryHotelRoom[$roomId]['ECHD'] = $param['fkECHD' . $roomId];


                } else {

                    $this->errorUserType = "true";
                }

            }

        }

        $this->TotalRoomId = $TotalRoomId;
    }

    public function oneDayTour($hotelId = null, $cityId = null)
    {

        $Model = Load::library('Model');
        $sql = " SELECT
                    *
                 FROM 
                    reservatin_one_day_tour_tb
                 WHERE 
                    id_hotel='{$hotelId}' AND
                    id_city='{$cityId}' AND
                    is_del='no'
                 ";
        $Result = $Model->select($sql);
        if (!empty($Result)) {
            $this->showOneDayTour = "True";
            $this->listOneDayTour = $Result;
        } else {
            $this->showOneDayTour = "False";
        }

    }


    public function getInfoReserveOneDayTour($factorNumber)
    {

        $Model = Load::library('Model');
        $sql_check = " SELECT  *, BT.id as idBook FROM 
                              reservation_book_one_day_tour_tb BT 
                              LEFT JOIN reservatin_one_day_tour_tb T ON BT.fk_id_one_day_tour=T.id
                        WHERE BT.fk_factor_number ='{$factorNumber}' ";
        $book = $Model->select($sql_check);

        $listOneDayTour = '';
        if (!empty($book)) {
            foreach ($book as $k => $val) {

                $amountR = ($val['num_adt_r'] * $val['adt_price_rial']) + ($val['num_chd_r'] * $val['chd_price_rial']) + ($val['num_inf_r'] * $val['inf_price_rial']);
                //$amountA = ($val['num_adt_a']*$val['adt_price_foreign'])+($val['num_chd_a']*$val['chd_price_foreign'])+($val['num_inf_a']*$val['inf_price_foreign']);

                //$listOneDayTour[$k]['info'] = $val;
                $listOneDayTour[$k]['idBook'] = $val['idBook'];
                $listOneDayTour[$k]['title'] = $val['title'];
                $listOneDayTour[$k]['price'] = $amountR;
            }
        }

        return $listOneDayTour;

    }


    public function getRoomFacilities($data)
    {
        $exp = explode(",", $data);

        $Model = Load::library('Model');
        $sql = " SELECT breakfast, lunch, dinner
                    FROM 
                        reservation_hotel_room_prices_tb
                    WHERE id ='{$exp[0]}' ";
        $result = $Model->load($sql);

        return $result;
    }


    public function getListSpecialHotel($limit = null)
    {
        $ModelBase = Load::library('ModelBase');
        $sql = "
            SELECT
                * 
            FROM
                hotel_room_prices_tb a
                INNER JOIN ( SELECT city_id, star_code, min( id ) AS min_id, max( id ) AS max_id FROM hotel_room_prices_tb GROUP BY city_id, star_code ) b ON a.id = b.min_id 
                OR a.id = b.max_id 
            WHERE
                ( a.star_code = 5 ) 
                AND (
                a.city_id = 1 
                OR a.city_id = 2 
                OR a.city_id = 6 
                OR a.city_id = 8 
                OR a.city_id = 56 
                OR a.city_id = 10 
                OR a.city_id = 66 
                OR a.city_id = 7 
                OR a.city_id = 3 
                OR a.city_id = 41 
                )
                AND a.hotel_name NOT LIKE '%در حال ساخت%'
                {$limit}
        ";
        $result = $ModelBase->select($sql);

        return $result;
    }




    #region SetPriorityParentDeparture

    public function SetPriorityParentDeparture($Param)
    {
        $Model = Load::library('Model');
        $Model->setTable('reservation_hotel_tb');
        $p1 = $Param['PriorityOld'];
        $p2 = $Param['PriorityNew'];
        $Code = $Param['CodeDeparture'];

        $RoutesSql = "SELECT * FROM reservation_hotel_tb WHERE id <> '{$Code}'  GROUP BY  id";
        $ResultRoutesSql = $Model->select($RoutesSql);


        $RoutesSql = "SELECT max(priority) AS MAXPriority FROM reservation_hotel_tb
                      WHERE EXISTS (SELECT * FROM reservation_hotel_tb WHERE priority ='{$p2}' )";
        $PriorityMax = $Model->load($RoutesSql);

        $flag = false;

        if ($p1 == 0) {
            //مقدار کد مور نظر آپدیت میشود

            $Condition = "id='{$Code}'";
            $dataCodeUp['priority'] = !empty($PriorityMax['MAXPriority']) ? ($PriorityMax['MAXPriority'] + 1) : $p2;
            $updatePriorityCode = $Model->update($dataCodeUp, $Condition);
            if ($updatePriorityCode) {
                $flag = true;
            }
        } elseif ($p1 < $p2) {// الویت را بیشتر میکنیم
            for ($j = 0; $j < count($ResultRoutesSql); $j++) {
                if ($ResultRoutesSql[$j]['priority'] != 0) {
                    $dataUp['priority'] = $ResultRoutesSql[$j]['priority'] - 1;
                } else {
                    $dataUp['priority'] = 0;
                }
                $Condition = "priority>='{$p1}' AND priority<='{$p2}' AND id = '{$ResultRoutesSql[$j]['id']}' AND priority <> '0'";
                $updatePriorityOtherCode = $Model->update($dataUp, $Condition);
            }
            //مقدار کد مور نظر آپدیت میشود
            $Condition = "id='{$Code}'";
            $dataCodeUp['priority'] = $p2;
            $updatePriorityCode = $Model->update($dataCodeUp, $Condition);

            if ($updatePriorityCode && $updatePriorityOtherCode) {
                $flag = true;
            }
        } elseif ($p1 > $p2) {// الویت را کمتر میکنیم
            for ($j = 0; $j < count($ResultRoutesSql); $j++) { // upd maghadir beyne p1 & p2
                if ($ResultRoutesSql[$j]['priority'] != 0) {
                    $dataDown['priority'] = $ResultRoutesSql[$j]['priority'] + 1;
                } else {
                    $dataDown['priority'] = 0;
                }
                $Condition = "priority<='{$p1}' AND priority>='{$p2}' AND id = '{$ResultRoutesSql[$j]['id']}' AND priority <> '0'";
                $updatePriorityOtherCode = $Model->update($dataDown, $Condition);
            }
            //مقدار کد مور نظر آپدیت میشود
            $dataDownCode['priority'] = $p2;
            $Condition = "id='{$Code}'";
            $updatePriorityCode = $Model->update($dataDownCode, $Condition);


            if ($updatePriorityCode && $updatePriorityOtherCode) {
                $flag = true;
            }
        }

        if ($flag) {
            return 'SuccessChangePriority:تغییر الویت با موفیقت انجام شد';
        } else {
            return 'ErrorChangePriority:خطا در تغییر الویت';
        }

    }

    #endregion


    public function RandomHotelList($params = array())
    {
        Load::library( 'ApiHotelCore' );
        $ApiHotelCore = new ApiHotelCore();

        $result = $ApiHotelCore->RandomHotelList( $params );
        $result = json_decode($result,true);
        if($result['Result'] && $result['Success'] && $params['chunked_value']){
            $result = array_chunk($result['Result'],$params['chunked_value']);
            return $result;
        }

        return $result['Result'];
    }

    public function getFullDetail($params) {
        return parent::ReservationHotel($params['idHotel_reserve']);
    }

    function getHotelInfoById($idHotel)
    {
        return parent::ReservationHotel($idHotel);
    }

    #region getFactorNumber
    public function getFactorNumber() {
        $factorNumber = dateTimeSetting::jdate( "Ymd", '', '', '', 'en' ) . mt_rand( 00, 99 ) . substr( time(), 7, 10 );

        return $factorNumber;
    }
    #endregion

    public function registerBookRecord($params) {
        /** @var factorTourLocal $factorController */
        $factorController = $this->getController('factorHotelLocal');

        $_POST = $params;

        $factorController->registerPassengersReservationHotel();
        return $params['factorNumber'];
    }

    public function apiGetHotelWebservice($params) {

        $result = [] ;
        if($params['type'] == 'internal') {
            $hotel_ids = array(
                "934",
                "1028",
                "1655",
                "1276",
                "999",
                "1426",
                "1118",
                "1507",
                "1234",
                "793",
                "76",
                "215",
                "588",
                "721",
                "832",
                "140",
            );
            $params['HotelIds'] = $hotel_ids ;
            $params['IsInternal'] = true ;
            if(isset($params['star_code'])) {
                $params['star_code'] = $params['star_code'];
            }
        }else {
            $city_ids = array(
                "23595",
                "23607",
                "325",
                "320",
                "5293",
                "7204",
                "8336",
                "6442",
                "23077",
                "23107",
                "45240",
                "26582",
                "75286"
            );
            $params['CityIds'] = $city_ids ;
            $params['IsInternal'] = false ;
        }


        Load::library( 'ApiHotelCore' );
        $ApiHotelCore = new ApiHotelCore();
        $response = $ApiHotelCore->RandomHotelList($params)  ;

        $response = json_decode($response , true) ;

        if(isset($response['StatusCode']) && $response['StatusCode'] == '200'){
            $result = $response['Result'] ;
            return functions::withSuccess($result);
        }else{
            return functions::withError($response, 404);
        }

    }

    public static function prePaymentCalculate( $price, $pre_payment_percentage )  {
        //        if ($pre_payment_percentage == 0) return '0';
        return (( $price * $pre_payment_percentage ) / 100);
    }

    private function calculateRoomPrice($price = [], $priceChanges = [] , $discount)
    {


        $priceBoardChange1 = functions::calculateHotelPrice($priceChanges, $discount, $price['board_price'], true);
        $priceOnlineAfterChange = functions::calculateHotelPrice($priceChanges, $discount, $price['online_price']);
        $priceOnlineChange = functions::calculateHotelPrice($priceChanges, $discount, $price['online_price'], true);

        return [
            'Discount' => $priceOnlineAfterChange['discount'],
            'discount_amount' => $priceOnlineAfterChange['discount_amount'],
            'afterChange' => round($priceOnlineAfterChange['price_with_increase_change']),
            'Board' => $priceBoardChange1,
            'Online' => round($priceOnlineChange),
        ];
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////End Reservation///////////////////////////////////////////////


    /*public function IrantechWebSiteRegion()
    {
        $result = parent::IrantechWebSiteRegion();
        echo Load::plog($result);
        return $result;
    }*/



    public function SetHotelSepehrGlobalId($Param)
    {
        $Model = Load::library('Model');
        $Model->setTable('reservation_hotel_tb');
        $p1 = $Param['sepehr_hotel_code_old'];
        $p2 = $Param['sepehr_hotel_code_new'];
        $Code = $Param['CodeDeparture'];

        $RoutesSql = "SELECT * FROM reservation_hotel_tb WHERE id <> '{$Code}'  GROUP BY  id";
        $ResultRoutesSql = $Model->select($RoutesSql);


        $RoutesSql = "SELECT max(sepehr_hotel_code) AS MAXSpecialId FROM reservation_hotel_tb
                      WHERE EXISTS (SELECT * FROM reservation_hotel_tb WHERE sepehr_hotel_code ='{$p2}' )";
        $SpecialIdMax = $Model->load($RoutesSql);

        $flag = false;

        if ($p1 == 0) {
            //مقدار شناسه سپهر مور نظر آپدیت میشود

            $Condition = "id='{$Code}'";
            $dataCodeUp['sepehr_hotel_code'] = !empty($SpecialIdMax['MAXSpecialId']) ? ($SpecialIdMax['MAXSpecialId'] + 1) : $p2;
            $updateSpecialIdSepehr = $Model->update($dataCodeUp, $Condition);
            if ($updateSpecialIdSepehr) {
                $flag = true;
            }
        } elseif ($p1 < $p2) {// الویت را بیشتر میکنیم
            for ($j = 0; $j < count($ResultRoutesSql); $j++) {
                if ($ResultRoutesSql[$j]['sepehr_hotel_code'] != 0) {
                    $dataUp['sepehr_hotel_code'] = $ResultRoutesSql[$j]['sepehr_hotel_code'] - 1;
                } else {
                    $dataUp['sepehr_hotel_code'] = 0;
                }
                $Condition = "sepehr_hotel_code>='{$p1}' AND sepehr_hotel_code<='{$p2}' AND id = '{$ResultRoutesSql[$j]['id']}' AND sepehr_hotel_code <> '0'";
                $updateSpecialIdOtherCode = $Model->update($dataUp, $Condition);
            }
            //مقدار کد مور نظر آپدیت میشود
            $Condition = "id='{$Code}'";
            $dataCodeUp['sepehr_hotel_code'] = $p2;
            $updateSpecialIdSepehr = $Model->update($dataCodeUp, $Condition);

            if ($updateSpecialIdSepehr && $updateSpecialIdOtherCode) {
                $flag = true;
            }
        } elseif ($p1 > $p2) {// الویت را کمتر میکنیم
            for ($j = 0; $j < count($ResultRoutesSql); $j++) { // upd maghadir beyne p1 & p2
                if ($ResultRoutesSql[$j]['sepehr_hotel_code'] != 0) {
                    $dataDown['sepehr_hotel_code'] = $ResultRoutesSql[$j]['sepehr_hotel_code'] + 1;
                } else {
                    $dataDown['sepehr_hotel_code'] = 0;
                }
                $Condition = "sepehr_hotel_code<='{$p1}' AND sepehr_hotel_code>='{$p2}' AND id = '{$ResultRoutesSql[$j]['id']}' AND sepehr_hotel_code <> '0'";
                $updateSpecialIdOtherCode = $Model->update($dataDown, $Condition);
            }
            //مقدار کد مور نظر آپدیت میشود
            $dataDownCode['sepehr_hotel_code'] = $p2;
            $Condition = "id='{$Code}'";
            $updateSpecialIdSepehr = $Model->update($dataDownCode, $Condition);


            if ($updateSpecialIdSepehr && $updateSpecialIdOtherCode) {
                $flag = true;
            }
        }

        if ($flag) {
            return 'SuccessChangeSpecialSepehr:شناسه سپهر با موفیقت انجام شد';
        } else {
            return 'ErrorChangeSpecialSepehr:خطا در تغییر شناسه سپهر';
        }

    }
    function getSepehrHotelInfo($sepehrCode)
    {
        $Model = Load::library('Model');

        $sql = "
    SELECT 
        h.`id`, h.`name`, h.`title`, h.`name_en`, h.`tel_number`, 
        h.`country`, h.`city`, h.`region`, h.`address`, h.`logo`, 
        h.`star_code`, h.`sepehr_hotel_code`,
        GROUP_CONCAT(f.`title` SEPARATOR '||') AS facilities_titles,
        GROUP_CONCAT(f.`icon_class` SEPARATOR '||') AS facilities_icons
    FROM 
        `reservation_hotel_tb` h
    LEFT JOIN `reservation_hotel_facilities_tb` hf ON h.id = hf.id_hotel AND hf.is_del = 'no'
    LEFT JOIN `reservation_facilities_tb` f ON hf.id_facilities = f.id AND f.is_del = 'no'
    WHERE h.sepehr_hotel_code = $sepehrCode
    ";


        return $Model->select($sql);
    }



    function getSepehrHotelDetailInfo($sepehrCode)
    {
        $Model = Load::library('Model');

        // کوئری اصلی برای دریافت اطلاعات هتل
        $sql = "
    SELECT 
        h.`id`, h.`name`, h.`title`, h.`name_en`, h.`tel_number`, h.`longitude`, h.`latitude`,h.`comment`,h.`rules`,h.`cancellation_conditions`,h.`child_conditions`,
        h.`country`, h.`city`, h.`region`, h.`address`, h.`logo`, 
        h.`star_code`, h.`sepehr_hotel_code`,
        GROUP_CONCAT(f.`title` SEPARATOR '||') AS facilities_titles,
        GROUP_CONCAT(f.`icon_class` SEPARATOR '||') AS facilities_icons
    FROM 
        `reservation_hotel_tb` h
    LEFT JOIN `reservation_hotel_facilities_tb` hf ON h.id = hf.id_hotel AND hf.is_del = 'no'
    LEFT JOIN `reservation_facilities_tb` f ON hf.id_facilities = f.id AND f.is_del = 'no'
    WHERE h.sepehr_hotel_code = $sepehrCode
    GROUP BY h.id
    ";

        $hotelInfo = $Model->select($sql);

        if (empty($hotelInfo)) {
            return [];
        }

        // دریافت عکس‌های هتل از جدول گالری
        $gallerySql = "
    SELECT `pic`, `name`, `comment`
    FROM `reservation_hotel_gallery_tb`
    WHERE `id_hotel` = {$hotelInfo[0]['id']} AND `is_del` = 'no'
    ORDER BY `id` ASC
    ";

        $gallery = $Model->select($gallerySql);

        // اضافه کردن گالری به اطلاعات هتل
        $hotelInfo[0]['gallery'] = $gallery;

        return $hotelInfo;
    }

}


