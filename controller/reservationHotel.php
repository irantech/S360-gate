<?php
//if(  $_SERVER['REMOTE_ADDR']=='178.131.144.189'  ) {
//        error_reporting(1);
//        error_reporting(E_ALL | E_STRICT);
//        @ini_set('display_errors', 1);
//        @ini_set('display_errors', 'on');
//}
/**
 * Class reservationHotel
 *
 * @property reservationHotel $reservationHotel
 */
class reservationHotel extends clientAuth
{

    public $id = '';
    public $is_same = '';
    public $countInsert = 0;
    public $sql = '';
    public $countSecondInsert = 0;
    public $secondSql = '';
    public $user_type = '';
    public $maximum_capacity = '';
    public $maximum_buy = '';
    public $comition_hotel = '';
    public $arr_date_duplicate = '';
    public $sell_for_night = '';
    public $p = '';
    public $file_hotel = '';
    public $listRoomPrices_DBL = '';
    public $listRoomPrices_EXT = '';
    public $listRoomPrices_ECHD = '';
    public $reservation_hotel_model = '';
    public $reservation_hotel_table = '';
    public $reservation_hotel_room_prices_model = '';
    public $reservation_hotel_room_prices_table = '';
    public $reservation_city_model = '';
    public $reservation_city_table = '';
    public $activity_log_controller = '';

    public $transactions;

    public function __construct()
    {
        ini_set('memory_limit', '-1');

        parent::__construct();
        $this->reservation_hotel_model = $this->getModel('reservationHotelModel');
        $this->reservation_hotel_table = $this->reservation_hotel_model->getTable();
        $this->reservation_hotel_room_prices_model = $this->getModel('reservationHotelRoomPricesModel');
        $this->reservation_hotel_room_prices_table = $this->reservation_hotel_room_prices_model->getTable();
        $this->reservation_city_model = $this->getModel('reservationCityModel');
        $this->reservation_city_table = $this->reservation_city_model->getTable();
        $this->activity_log_controller  =   $this->getController('activityLog');
        $this->transactions = $this->getModel('transactionsModel');

    }
    public function getHotelIndexes($hotels) {


        $hotels_result = [];
        foreach ($hotels as $hotel_key => $hotel) {

            $hotels_result[$hotel_key] = $hotel;

            $meta_tags = json_decode($hotel['meta_tags'], true);
            $meta_tags_array = [];
            $all_meta_tags_array = [];
            if ($meta_tags) {

                foreach ($meta_tags as $meta_tag) {
                    if (isset($meta_tag['name']) && $meta_tag['name'] == 'description') {
                        $hotels_result[$hotel_key]['description'] = $meta_tag['content'];
                    } else {
                        $meta_tags_array[] = $meta_tag;
                    }
                    $all_meta_tags_array[] = $meta_tag;
                }
            }
            $hotels_result[$hotel_key]['meta_tags'] = $meta_tags_array;
            $hotels_result[$hotel_key]['all_meta_tags'] = $all_meta_tags_array;

            $hotels_result[$hotel_key]['heading'] = !empty($hotel['heading'])? $hotel['heading']: $hotel['name'];
            $hotels_result[$hotel_key]['title'] = !empty($hotel['title'])? $hotel['title']: $hotel['name'];


        }
//        var_dump($hotel['name']);

        return $hotels_result;
    }

    public function getInfoMetaTag($params) {

        return $this->unSlugPage($params);
    }

    public function unSlugPage($params) {

        $Model = Load::library('Model');
        $Model->setTable("reservation_hotel_tb");
        $nameTable = "reservation_hotel_tb";

//        $result = $this->SelectAllWithCondition( $nameTable, $params['hotelId'], $params['hotelId']);
        $sql = " SELECT * FROM {$nameTable} WHERE id={$params['hotelId']} AND is_del='no' ";
        $res = $Model->load($sql);

//        return $this->getPageIndexes($res)[0];
        return $this->getHotelIndexes([$res])[0];
//        return $res;
    }


    public function infoSiteMap($table) {
        $model = $this->getModel('reservationHotelModel');
        $table = $model->getTable();
        $result = $model
            ->get([
                $table . '.*',
            ], true);

        $result = $result
            ->where($table . '.is_accept', 'yes');
        $result = $result->orderBy($table . '.id');
        $result = $result->all(false);


        $result_list = $model
            ->get([
                $table . '.*',
            ], true);

        $result_list = $result_list
            ->where($table . '.is_accept', 'yes');
        $result_list = $result_list->groupBy($table . '.city')->orderBy($table . '.id');
        $result_list = $result_list->all(false);
        foreach ($result_list as $key => $itemList) {
            if ($itemList['city'] > 0) {
                $url_search = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/searchHotel&type=new&city=' . $itemList['city'] . '&nights=1';
                $data_search['loc'] = $url_search;
                $data_search['priority'] = '0.5';
                if ($itemList['updated_at'] != '') {
                    $result_sitemap['lastmodJalali'] =  functions::ConvertToJalali($itemList['updated_at'], '/');
                    $result_sitemap['lastmod'] = functions::ConvertToMiladi($result_sitemap['lastmodJalali'], '-');

                }else{
                    $result_sitemap['lastmodJalali'] =  date('Y-m-d H:i:s', time());
                    $result_sitemap['lastmod'] = functions::ConvertToMiladi($result_sitemap['lastmodJalali'], '-');

                }
                $result_all[] = $data_search;
            }
        }
        foreach ($result as $key => $item) {
            $url = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/roomHotelLocal/reservation/' . $item['id'] .'/'.str_replace(" ", "-",$item['name_en']);
            $result_sitemap['loc'] = $url;
            $result_sitemap['priority'] = '0.5';
            if ($item['updated_at'] != '') {
                $result_sitemap['lastmodJalali'] =  functions::ConvertToJalali($item['updated_at'], '/');
                $result_sitemap['lastmod'] = functions::ConvertToMiladi($result_sitemap['lastmodJalali'], '-');

            }else{
                $result_sitemap['lastmodJalali'] = dateTimeSetting::jdate("Y-m-d",time(),'','','en');
                $result_sitemap['lastmod'] = functions::ConvertToMiladi($result_sitemap['lastmodJalali'], '-');

            }
            $result_sitemap_final[] = $result_sitemap;
        }
//        return [$result_all , $result_sitemap_final];
        return [$result_sitemap_final];
    }


    public function hotelReservationFullyData($params)
    {
        /** @var ModelBase $ModelBase */
        $limit = "";
        $conditionSpecial = "";
        $conditionDiscount = "";
        $conditionCountry = "";
        foreach ($params as $key => $param) {
            $request[$key] = functions::checkParamsInput($param);
        }
        $special = $request['special'];
        $discount = $request['discount'];
        $date = $request['dateNow'];
        $limit = $request['limit'];
        $country = $request['country'];
        if (isset($limit) && $limit != "") {
            $LIMIT = " LIMIT " . $limit . " ";
        }
        if (isset($special) && $special != "") {
            $conditionSpecial = " and H.flag_special='yes' ";
        }
        if (isset($discount) && $discount != "") {
            $conditionDiscount = " and H.flag_discount='yes' ";
        }
        if (!empty($country)) {
            if ($country == 'internal') {
                $country = '=1';
            } elseif ($country == 'external') {
                $country = '!=1';
            }
            $conditionCountry = " AND H.country " . $country . " ";
        }
        $mod = '';
        $format = 'Y' . $mod . 'm' . $mod . 'd';
        $price_date_today = dateTimeSetting::jdate($format, time(), '', '', 'en');
        $Model = Load::library('Model');
        $clientSql
            = "SELECT
                    H.name,
                    H.name_en,
                    H.discount,
                    H.star_code,
                    H.id,
                    H.logo,
                    H.address,
                    H.city,
                    RC.name AS name_city
            FROM
                    reservation_hotel_room_prices_tb AS RP
                    INNER JOIN reservation_hotel_tb AS H ON RP.id_hotel=H.id
                    LEFT JOIN
                reservation_city_tb AS RC
                ON
               H.city=RC.id
            WHERE
                    RP.user_type='5' AND
                    H.is_del = 'no' AND
                    RP.flat_type='DBL' AND
                    RP.date >= '{$price_date_today}' AND
                    RP.is_del='no'
                    {$conditionSpecial}
                    {$conditionDiscount}
                    {$conditionCountry}
            GROUP BY
                    H.id
            ORDER BY
                    H.star_code  DESC, H.name ASC, H.discount  DESC
            {$LIMIT}
			   ";

        return ($Model->select($clientSql));

    }


    // نمایش نام هتل براساس انتخاب شهر//
    public function showAllHotel($param)
    {
        $Model = Load::library('Model');

        $sql
            = "select
                      id,name
                from 
                      reservation_hotel_tb
                where
                      city='{$param['origin_city']}' AND is_del='no'
                order by id	
                ";
        $hotel = $Model->select($sql);
        $result = 'null' ;
        if($hotel) {
            $result = " /*/ ,";
            foreach ($hotel as $val) {
                $result .= $val['id'] . '/*/' . $val['name'] . ',';
            }
        }


        return $result;

    }

    // نمایش نام اتاق ها براساس انتخاب هتل//
    public function showAllHotelRoom($param)
    {
        $Model = Load::library('Model');

        $sql
            = "select
                      RT.id,
                      RT.comment
                from 
                      reservation_hotel_room_tb HR LEFT JOIN  reservation_room_type_tb RT ON HR.id_room=RT.id
                where
                      HR.id_hotel='{$param['hotel_name']}' AND HR.is_del='no'
                order by 
                      RT.id	
                ";
        $room = $Model->select($sql);

        $result = " /*/ ,";
        foreach ($room as $val) {
            $result .= $val['id'] . '/*/' . $val['comment'] . ',';
        }

        return $result;
    }


    //تخصیص کد یکسان برای درج بلیط ها//
    public function GetIdSame()
    {

        $Model = Load::library('Model');

        $sql = "SELECT max(id_same) AS maxIdSame FROM reservation_hotel_room_prices_tb ";
        $result = $Model->load($sql);
        if (empty($result)) {
            $id_same = 1;
        } else {
            $id_same = $result['maxIdSame'] + 1;
        }

        return $id_same;

    }

    //////////کمسیون کاربر انتخاب شده//////////
    public function GetComition($user_type)
    {
        $Model = Load::library('Model');
        $sql = "SELECT * FROM counter_type_tb WHERE id='{$user_type}'";
        $counter = $Model->load($sql);

        return $counter['discount_hotel'];
    }


    ///////////////////////////////// افزودن قیمت اتاق/////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////
    public function InsertRoomPrice($info)
    {
        if(CLIENT_ID == '317') {
            if(isset($info['start_date_en']) && !empty($info['start_date_en'])) {
                $info['start_date'] = functions::ConvertToJalali($info['start_date_en']);
            }
            if(isset($info['start_date_en']) && !empty($info['start_date_en'])) {
                $info['end_date'] = functions::ConvertToJalali($info['end_date_en']);
            }
        }
        //پر کردن فیلد فروش برای چند شب
        if ($info['sell_for_night'] != '') {
            $this->sell_for_night = $info['sell_for_night'];
        } else {
            $this->sell_for_night = '1/2/3/4/5/6/7/8/9/10/11/12/13/14/15';
        }

        //آپلود فایل هتل
        if ($info['pic'] != "") {

            $config = Load::Config('application');
            $success = $config->UploadFile("", "pic", "");
            $explode_name_pic = explode(':', $success);
            if ($explode_name_pic[0] == "done") {
                $this->file_hotel = $explode_name_pic[1];
            }

        }

        //////کد یکسان برای اتاق//////
        $isSame = $this->GetIdSame();

        $this->countInsert = 0;
        $this->sql = " INSERT INTO reservation_hotel_room_prices_tb VALUES";


        // حلقه به تعداد کاربران انتخاب شده //
        for ($for_user = 1; $for_user <= $info['count_other_user']; $for_user++) {
            // اگر کاربر انتخاب شده بود //
            if (isset($info['chk_user' . $for_user]) && $info['chk_user' . $for_user] != '') {

                $this->user_type = $info['user_type' . $for_user];
                $this->maximum_capacity = $info['maximum_capacity' . $for_user];

                // مشخص کردن درصد تخفیف تعیین شده برای هر کاربر، اگر تعیین نکرده از جدول کاربران خوانده شود //
                if (isset($info['comition_hotel' . $for_user]) && $info['comition_hotel' . $for_user] != '') {
                    $this->comition_hotel = $info['comition_hotel' . $for_user];
                } else {
                    $this->comition_hotel = $this->GetComition($info['user_type' . $for_user]);
                }


                // برای بررسی تکراری نبودن //
                $this->DuplicateRecords($info['hotel_name'], $info['user_type' . $for_user]);

                // ارسال اطلاعات برای درج در دیتابیس //
                $resultDateRoomPrice = $this->DateForRoomPrice($info, 'firstInsert', $isSame);
            }

        }


        //ثبت تعداد رکورد کمتر از 100 تا اینجا اتفاق میفتد
        if ($this->sql != '' && $this->countInsert > 0) {
            $Model = Load::library('Model');
            $this->sql = substr($this->sql, 0, -1);
            $res = $Model->execQuery($this->sql);
        }


        // اگر درج اطلاعات در دیتابیس انجام شده یا نشده پیغام دهد //
        if ($resultDateRoomPrice == 'success') {
            return 'success :  تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در  تغییرات';
        }


    }


    // تابع بررسی تکراری نبودن]
    public function DuplicateRecords($id_hotel, $user_type)
    {

        $Model = Load::library('Model');

        $this->arr_date_duplicate = '';
        $sql
            = "select
                  id,
                  date,
                  id_hotel,
                  user_type,
                  id_room,
                  flat_type
              from
                  reservation_hotel_room_prices_tb		  
              where  
                  user_type='{$user_type}' and
                  id_hotel='{$id_hotel}' and is_del='no'
                  ";

        $resultCheck = $Model->select($sql);

        $array = [];
        foreach ($resultCheck as $val) {
            $hotel_index = strval($val['id_hotel']) . strval($val['id_room']) . strval($val['user_type']) . strval($val['date']) . strval($val['flat_type']) ;
            $array[$hotel_index][] = $val['id'];
        }
        $this->arr_date_duplicate = $array ;

    }


    //بررسی تاریخ ها (از تاریخ n تا تاریخ m)//
    public function DateForRoomPrice($info, $status, $is_same)
    {

        $objController = Load::controller('reservationPublicFunctions');

        $startDate = str_replace("-", "", $info['start_date']);
        $endDate = str_replace("-", "", $info['end_date']);


        while ($startDate <= $endDate) {

            $date = $startDate;
            if ($status == 'firstInsert') {
                $resultInsertRoomPrice = $this->firstInsertRoomPrice($info, $date, $is_same);

            } else if ($status == 'secondInsert') {
                $resultInsertRoomPrice = $this->secondInsertRoomPrice($info, $date, $is_same);
            }

            //روز بعدی//
            $startDate = $objController->dateNextFewDays($startDate, ' + 1');

        }//end while startDate<=endDate

        if ($resultInsertRoomPrice == 'success') {
            return 'success';
        } else {
            return 'error';
        }


    }


    //درج قیمت اتاق ها در دیتابیس//
    public function firstInsertRoomPrice($info, $date, $is_same)
    {
        $resInsert = array();
        $Model = Load::library('Model');

        $count_package = $info['count_package'];
        // حلقه به تعداد اتاق های انتخاب شده ی هتل //
        for ($p = 1; $p <= $count_package; $p++) {
            if (isset($info['room_type' . $p]) && $info['room_type' . $p] != '') {

                $hotel_index = strval($info['hotel_name']) . strval($info['room_type' . $p]) . strval($this->user_type) . strval($date) . 'DBL' ;
                // اگر تکرار وجود نداشت درج کند //
                if (empty($this->arr_date_duplicate[$hotel_index])) {

                    // حلقه برای قیمت تخت اصلی و تخت اضافه بزرگسال و کودک //
                    for ($i = 1; $i <= 4; $i++) {

                        // اگر تخت اصلی بود //
                        if ($info['age' . $p . $i] == "DBL" || $info['age' . $p . $i] == "ECHD") {

                            $flag_adl = 1;
                            // شرط برای نحوه محاسبه قیمت ها //
                            if ($info['discount_status'] == 1) {

                                $info_board_price = str_replace(",", "", $info['board_price' . $p . $i]);
                                $info_online_price = str_replace(",", "", $info['online_price' . $p . $i]);

                                $discount = $this->comition_hotel;
                                $board_price = $info_online_price;

                                $discount_price = ($discount * $info_online_price) / 100;
                                $online_price = $board_price - $discount_price;
//                                echo "<h3>Debug Price Calculation:</h3>";
//                                echo "discount_status: " . $info['discount_status'] . "<br>";
//                                echo "board_price: " . $info['board_price' . $p . $i] . "<br>";
//                                echo "online_price: " . $info['online_price' . $p . $i] . "<br>";
//                                echo "info_board_price: " . $info_board_price . "<br>";
//                                echo "info_online_price: " . $info_online_price . "<br>";
//                                echo "comition_hotel: " . $this->comition_hotel . "<br>";
//                                echo "discount_price2: " . $discount_price . "<br>";
//

                            } else if ($info['discount_status'] == 2) {

                                $info_board_price = str_replace(",", "", $info['board_price' . $p . $i]);
                                $info_online_price = str_replace(",", "", $info['online_price' . $p . $i]);

                                $t = ($info_board_price) - ($info_online_price);
                                $d = ($t * 100) / $info_board_price;
                                $discount = round($d);

                                $board_price = $info_board_price;
                                $online_price = $info_online_price;

                            }

                        } else {

                            $flag_adl = 0;
                            $discount = '0';
                            $board_price = '0';
                            if($info['age' . $p . $i] == 'CHD'){
                                $online_price = '0';

                            }else{
                                $online_price = str_replace(",", "", $info['online_price' . $p . $i]);
                            }

                        }
                        if($info['age' . $p . $i] == 'CHD') {
                            $currency_price =  '0';
                        }else{
                            $currency_price =  str_replace( ',', '', $info['currency_price' . $p . $i] );
                        }


                        $user_type = $this->user_type;
                        $maximum_capacity = $this->maximum_capacity;
                        $sell_for_night = $this->sell_for_night;
                        $file_hotel = $this->file_hotel;

                        if (isset($info['breakfast']) && $info['breakfast'] != '') {
                            $data['breakfast'] = $info['breakfast'];
                        } else {
                            $data['breakfast'] = 'no';
                        }
                        if (isset($info['lunch']) && $info['lunch'] != '') {
                            $data['lunch'] = $info['lunch'];
                        } else {
                            $data['lunch'] = 'no';
                        }
                        if (isset($info['dinner']) && $info['dinner'] != '') {
                            $data['dinner'] = $info['dinner'];
                        } else {
                            $data['dinner'] = 'no';
                        }
                        if (isset($info['guest_user_status']) && $info['guest_user_status'] != '') {
                            $data['guest_user_status'] = $info['guest_user_status'];
                        } else {
                            $data['guest_user_status'] = 'no';
                        }

                        if($info['age' . $p . $i] == 'CHD' || $info['age' . $p . $i] == 'ECHD') {
                            $data['childFromAge'] = $info['childFromAge'. $p . $i] ? $info['childFromAge'. $p . $i] : 0 ;
                            $data['childToAge'] = $info['childToAge'. $p . $i];
                        }else{
                            $data['childFromAge']  = '' ;
                            $data['childToAge']  = '' ;
                        }


                        /*$data['id_same'] = $is_same;
                        $data['id_country'] = $info['origin_country'];
                        $data['id_city'] = $info['origin_city'];
                        $data['id_region'] = $info['origin_region'];
                        $data['id_hotel'] = $info['hotel_name'];
                        $data['id_room'] = $info['room_type' . $p];
                        $data['date'] = $date;
                        $data['total_capacity'] = $info['total_capacity' . $p];
                        $data['maximum_capacity'] = $maximum_capacity;
                        $data['remaining_capacity'] = $maximum_capacity;
                        $data['user_type'] = $user_type;
                        $data['discount_status'] = $info['discount_status'];
                        $data['discount'] = $discount;
                        $data['board_price'] = $board_price;
                        $data['online_price'] = $online_price;
                        $data['currency_price'] = $info['currency_price' . $p . $i];
                        $data['currency_type'] = $info['currency_type' . $p];
                        $data['flat_type'] = $info['age' . $p . $i];
                        $data['other_services'] = $info['other_services'];
                        $data['specific_description'] = $info['specific_description'];
                        $data['com_gharardad_coWorker'] = '';
                        $data['com_gharardad_passenger'] = '';
                        $data['onrequest_time'] = $info['onrequest_time'];
                        $data['reserve_time_canceled'] = $info['reserve_time_canceled'];
                        $data['sell_for_night'] = $sell_for_night;
                        $data['flag_dbl'] = $flag_adl;
                        $data['file_hotel'] = $this->file_hotel;
                        $data['is_del'] = 'no';

                        $Model->setTable('reservation_hotel_room_prices_tb');
                        $res = $Model->insertLocal($data);

                        if ($res) {
                            $result = "success";
                        } else {
                            $result = "error";
                        }*/

                        $this->countInsert++;
                        if ($this->countInsert % 100 == 0) {
                            $this->sql = substr($this->sql, 0, -1);


                            $resInsert[] = $Model->execQuery($this->sql);

                            $this->sql = " INSERT INTO reservation_hotel_room_prices_tb VALUES";
                        }

                        $this->sql
                            .= "(
                            '',
                            '" . $is_same . "',
                            '" . $info['origin_country'] . "',
                            '" . $info['origin_city'] . "',
                            '" . $info['origin_region'] . "',
                            '" . $info['hotel_name'] . "',
                            '" . $info['room_type' . $p] . "',
                            '" . $user_type . "',
                            '" . $date . "',
                            '" . $info['age' . $p . $i] . "',
                            '" . $info['discount_status'] . "',
                            '" . $discount . "',
                            '" . $board_price . "',
                            '" . $online_price . "',
                            '" . $currency_price . "',
                            '" . $info['currency_type' . $p] . "',
                            '" . $info['total_capacity' . $p] . "',
                            '" . $maximum_capacity . "',
                            '" . $maximum_capacity . "',
                            '',
                            '" . $data['breakfast'] . "',
                            '" . $data['lunch'] . "',
                            '" . $data['dinner'] . "',
                            '" . $info['other_services'] . "',
                            '" . $info['specific_description'] . "',
                            '" . $data['guest_user_status'] . "',
                            '" . $file_hotel . "',
                            '',
                            '',
                            '" . $info['onrequest_time'] . "',
                            '" . $info['reserve_time_canceled'] . "',
                            '" . $sell_for_night . "',
                            '" . $flag_adl . "',
                            '" . $data['childFromAge'] . "',
                            '" . $data['childToAge'] . "',
                            'no'
                            ),";


                    }


                } else {
                    $resInsert[] = "0";
                }


            }


        }


        if (in_array('0', $resInsert)) {
            return 'error';
        } else {
            return 'success';
        }


    }


    //درج قیمت اتاق ها در دیتابیس//
    public function secondInsertRoomPrice($info, $date, $is_same)
    {

        $Model = Load::library('Model');
        $resInsert = array();

        // اگر تکرار وجود نداشت درج کند  //
        if (empty($this->arr_date_duplicate[$info['id_hotel'] . $info['id_room'] . $info['user_type'] . $date . $info['flat_type']])) {


            /*$data['id_same'] = $is_same;
            $data['id_country'] = $info['id_country'];
            $data['id_city'] = $info['id_city'];
            $data['id_region'] = $info['id_region'];
            $data['id_hotel'] = $info['id_hotel'];
            $data['id_room'] = $info['id_room'];
            $data['date'] = $date;
            $data['total_capacity'] = $info['total_capacity'];
            $data['maximum_capacity'] = $info['maximum_capacity'];
            $data['remaining_capacity'] = $info['maximum_capacity'];
            $data['user_type'] = $info['user_type'];
            $data['discount_status'] = $info['discount_status'];
            $data['discount'] = $info['discount'];
            $data['board_price'] = $info['board_price'];
            $data['online_price'] = $info['online_price'];
            $data['currency_price'] = $info['currency_price'];
            $data['currency_type'] = $info['currency_type'];
            $data['flat_type'] = $info['flat_type'];
            $data['other_services'] = $info['other_services'];
            $data['specific_description'] = $info['specific_description'];
            $data['com_gharardad_coWorker'] = $info['com_gharardad_coWorker'];
            $data['com_gharardad_passenger'] = $info['com_gharardad_passenger'];
            $data['onrequest_time'] = $info['onrequest_time'];
            $data['reserve_time_canceled'] = $info['reserve_time_canceled'];
            $data['sell_for_night'] = $info['sell_for_night'];
            $data['flag_dbl'] = $info['flag_dbl'];
            $data['file_hotel'] = $info['file_hotel'];
            $data['is_del'] = 'no';
            $data['breakfast'] = $info['breakfast'];
            $data['lunch'] = $info['lunch'];
            $data['dinner'] = $info['dinner'];


            $Model->setTable('reservation_hotel_room_prices_tb');
            $res = $Model->insertLocal($data);

            if ($res) {
                $result = "success";
            } else {
                $result = "error";
            }*/

            $this->countSecondInsert++;
            if ($this->countSecondInsert % 100 == 0) {
                $this->secondSql = substr($this->secondSql, 0, -1);
                $resInsert[] = $Model->execQuery($this->secondSql);
                $this->secondSql = " INSERT INTO reservation_hotel_room_prices_tb VALUES";
            }

            $this->secondSql
                .= "(
                            '',
                            '" . $is_same . "',
                            '" . $info['id_country'] . "',
                            '" . $info['id_city'] . "',
                            '" . $info['id_region'] . "',
                            '" . $info['id_hotel'] . "',
                            '" . $info['id_room'] . "',
                            '" . $info['user_type'] . "',
                            '" . $date . "',
                            '" . $info['flat_type'] . "',
                            '" . $info['discount_status'] . "',
                            '" . $info['discount'] . "',
                            '" . $info['board_price'] . "',
                            '" . $info['online_price'] . "',
                            '" . $info['currency_price'] . "',
                            '" . $info['currency_type'] . "',
                            '" . $info['total_capacity'] . "',
                            '" . $info['maximum_capacity'] . "',
                            '" . $info['maximum_capacity'] . "',
                            '',
                            '" . $info['breakfast'] . "',
                            '" . $info['lunch'] . "',
                            '" . $info['dinner'] . "',
                            '" . $info['other_services'] . "',
                            '" . $info['specific_description'] . "',
                            '" . $info['guest_user_status'] . "',
                            '" . $info['file_hotel'] . "',
                            '',
                            '',
                            '" . $info['onrequest_time'] . "',
                            '" . $info['reserve_time_canceled'] . "',
                            '" . $info['sell_for_night'] . "',
                            '" . $info['flag_dbl'] . "',
                            '" . $info['fromAge'] . "',
                            '" . $info['toAge'] . "',
                        
                            'no'
                         
                            ),";


        } else {

            $resInsert[] = "0";
        }


        if (in_array('0', $resInsert)) {
            return 'error';
        } else {
            return 'success';
        }


    }



    ///////////////////اضافه کردن قیمت اتاق برای هتل در بازه زمانی مشخص///////////////
    //////////////////////////////////////////////////////////////////////////////////
    public function InsertHotelRoomPrice($info, $status = '')
    {

        $Model = Load::library('Model');
        //////کد یکسان برای اتاق//////
        $is_same = $this->GetIdSame();

        if (isset($status) && $status == 'allRoom') {

            $link = "reportHotelRoom&city=" . $info['id_city'] . "&hotel=" . $info['id_hotel'];
            $sql
                = " SELECT *
                 FROM reservation_hotel_room_prices_tb
                 WHERE id_hotel='{$info['id_hotel']}' AND date='{$info['max_date']}' AND is_del='no'
                 GROUP BY id_room, user_type, flat_type
                 ORDER BY id_room, user_type, flat_type, id ASC";

        } elseif (isset($status) && $status == 'room') {

            $link = "reportHotelRoomForUser&city=" . $info['id_city'] . "&hotel=" . $info['id_hotel'] . "&room=" . $info['id_room'];

            $sql
                = " SELECT *
                 FROM reservation_hotel_room_prices_tb 
                 WHERE id_hotel='{$info['id_hotel']}' AND id_room='{$info['id_room']}' 
                    AND user_type='{$info['user_type']}' AND date='{$info['max_date']}' AND is_del='no'
                 GROUP BY flat_type
                 ORDER BY id_room, user_type, flat_type, id ASC";

        }
      
        $result_hotel = $Model->select($sql);


        $this->countSecondInsert = 0;
        $this->secondSql = " INSERT INTO reservation_hotel_room_prices_tb VALUES";

        //حلقه به تعداد اتاق های هتل
        foreach ($result_hotel as $hotel) {

            $hotel['start_date'] = $info['start_date'];
            $hotel['end_date'] = $info['end_date'];

            //بررسی تکراری نبودن//
            $this->DuplicateRecords($info['id_hotel'], $hotel['user_type']);

            //ارسال اطلاعات برای درج در دیتابیس//
            $resultDateRoomPrice = $this->DateForRoomPrice($hotel, 'secondInsert', $is_same);

        }

        //ثبت تعداد رکورد کمتر از 100 تا اینجا اتفاق میفتد
        if ($this->secondSql != '' && $this->countSecondInsert > 0) {
            $Model = Load::library('Model');
            $this->secondSql = substr($this->secondSql, 0, -1);
            $res = $Model->execQuery($this->secondSql);
        }


        //اگر درج اطلاعات در دیتابیس انجام شده یا نشده پیغام دهد
        if ($resultDateRoomPrice == 'success') {
            return 'success :  تغییرات با موفقیت انجام شد' . ':' . $link;
        } else {
            return 'error : خطا در  تغییرات' . ':' . $link;
        }


    }




    ///////////////////////////// افزودن تور یک روزه/////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////
    public function InsertOneDayTour($info)
    {

        $Model = Load::library('Model');

        $sql
            = " SELECT * FROM reservatin_one_day_tour_tb
                    WHERE id_city='{$info['origin_city']}' AND id_hotel='{$info['hotel_name']}' AND title='{$info['title']}' AND is_del='no' ";
        $res = $Model->load($sql);

        if (empty($res)) {

            $data['id_country'] = $info['origin_country'];
            $data['id_city'] = $info['origin_city'];
            $data['id_hotel'] = $info['hotel_name'];
            $data['title'] = $info['title'];
            $data['adt_price_rial'] = str_replace(",", "", $info['adt_price_rial']);
            $data['chd_price_rial'] = str_replace(",", "", $info['chd_price_rial']);
            $data['inf_price_rial'] = str_replace(",", "", $info['inf_price_rial']);
            /*$data['adt_price_foreign'] = str_replace(",", "", $info['adt_price_foreign']);
            $data['chd_price_foreign'] = str_replace(",", "", $info['chd_price_foreign']);
            $data['inf_price_foreign'] = str_replace(",", "", $info['inf_price_foreign']);*/
            $data['is_del'] = 'no';

            $Model->setTable('reservatin_one_day_tour_tb');
            $res = $Model->insertLocal($data);

            if ($res) {
                return 'success :  تغییرات با موفقیت انجام شد';
            } else {
                return 'error : خطا در  تغییرات';
            }

        } else {
            return 'error : تور تکراری می باشد.';
        }


    }

    public function UpdateOneDayTour($info)
    {

        $Model = Load::library('Model');

        $data['id_country'] = $info['origin_country'];
        $data['id_city'] = $info['origin_city'];
        $data['id_hotel'] = $info['hotel_name'];
        $data['title'] = $info['title'];
        $data['adt_price_rial'] = str_replace(",", "", $info['adt_price_rial']);
        $data['chd_price_rial'] = str_replace(",", "", $info['chd_price_rial']);
        $data['inf_price_rial'] = str_replace(",", "", $info['inf_price_rial']);
        /*$data['adt_price_foreign'] = str_replace(",", "", $info['adt_price_foreign']);
        $data['chd_price_foreign'] = str_replace(",", "", $info['chd_price_foreign']);
        $data['inf_price_foreign'] = str_replace(",", "", $info['inf_price_foreign']);*/

        $Condition = "id='{$info['type_id']}' ";
        $Model->setTable("reservatin_one_day_tour_tb");
        $res = $Model->update($data, $Condition);

        if ($res) {
            return 'success :  تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در  تغییرات';
        }

    }


    /////////////////////////////////مشاهده قیمت اتاق ها/////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    //////////گزارش هتل//////////
    public function reportHotel()
    {

        $mod = '';
        $format = 'Y' . $mod . 'm' . $mod . 'd';
        $dateToday = dateTimeSetting::jdate($format, time(), '', '', 'en');


        $nextMonthDate = dateTimeSetting::jdate($format, strtotime('+1 week'), '', '', 'en');

        $Model = Load::library('Model');

        $sql
            = " SELECT HRP.*,
                     SUM(HRP.total_capacity) AS all_capacity,
                     SUM(HRP.maximum_capacity) AS all_maximum_capacity,
                     SUM(HRP.remaining_capacity) AS all_remaining_capacity,
                     MAX(HRP.date) AS max_date
                 FROM reservation_hotel_room_prices_tb HRP
                 RIGHT JOIN  reservation_hotel_room_tb HR ON HR.id_room = HRP.id_room
                 WHERE HRP.flat_type='DBL' AND HRP.is_del='no' AND HRP.date >= '{$dateToday}'
                 AND HRP.date <= '{$nextMonthDate}'
                 GROUP BY HRP.id_hotel
                 ORDER BY HRP.id_country, HRP.id_city ASC";



        $hotel = $Model->select($sql);

        return $hotel;


    }

    //////////گزارش اتاق های هتل//////////
    public function  reportHotelRoom($city, $hotel)
    {
        $mod = '';
        $format = 'Y' . $mod . 'm' . $mod . 'd';
        $dateToday = dateTimeSetting::jdate($format, time(), '', '', 'en');


        $Model = Load::library('Model');
        $sql
            = " SELECT *,
                     SUM(total_capacity) as all_capacity, 
                     SUM(maximum_capacity) as all_maximum_capacity, 
                     SUM(remaining_capacity) as all_remaining_capacity,
                     MIN(date) as min_date,
                     MAX(date) as max_date
                 FROM reservation_hotel_room_prices_tb 
                 WHERE id_city='{$city}' AND id_hotel='{$hotel}' AND date>='{$dateToday}' AND flat_type='DBL' AND is_del='no'
                 GROUP BY id_room
                 ORDER BY id_room,id ASC";
        return  $Model->select($sql);



    }

    public function getArchiveHotelRoomPrice($hotel)
    {

        $Model = Load::library('Model');
        $sql
            = " SELECT *,
                     MIN(date) as min_date,
                     MAX(date) as max_date
                 FROM reservation_hotel_room_prices_tb 
                 WHERE id_hotel='{$hotel}' AND flat_type='DBL' AND is_del='no'
                 GROUP BY id_room
                 ORDER BY id_room,id ASC";
        $hotel = $Model->select($sql);

        return $hotel;

    }

    //////////گزارش کاربران//////////
    public function reportHotelRoomForUser($city, $hotel, $id_room)
    {

        $mod = '';
        $format = 'Y' . $mod . 'm' . $mod . 'd';
        $dateToday = dateTimeSetting::jdate($format, time(), '', '', 'en');

        $Model = Load::library('Model');
        $sql
            = " SELECT *,
                     SUM(total_capacity) as all_capacity, 
                     SUM(maximum_capacity) as all_maximum_capacity, 
                     SUM(remaining_capacity) as all_remaining_capacity,
                     MIN(date) as min_date,
                     MAX(date) as max_date
                 FROM reservation_hotel_room_prices_tb 
                 WHERE id_city='{$city}' AND id_hotel='{$hotel}' AND id_room='{$id_room}' AND date>='{$dateToday}' AND flat_type='DBL' AND is_del='no'
                 GROUP BY user_type, id_same
                 ORDER BY user_type,id ASC";
        $hotel = $Model->select($sql);

        return $hotel;
    }

    //////////گزارش روزانه اتاق ها//////////
    public function reportHotelRoomForDate($city, $hotel, $status = '')
    {

        $mod = '';
        $format = 'Y' . $mod . 'm' . $mod . 'd';
        $dateToday = dateTimeSetting::jdate($format, time(), '', '', 'en');
        if (isset($status) && $status == 'archive') {

            $condition = " AND date<'{$dateToday}' ";
        } else {
            $condition = " AND date>='{$dateToday}' ";
        }

        $Model = Load::library('Model');
        $sql
            = " SELECT *
                 FROM reservation_hotel_room_prices_tb 
                 WHERE id_city='{$city}' AND id_hotel='{$hotel}' AND flat_type='DBL' AND is_del='no' {$condition}
                 ORDER BY id_room,user_type,date ASC";
        $hotel = $Model->select($sql);

        return $hotel;
    }

    ///////////////////حذف قیمت اتاق/////////////////
    public function deleteRoomPricesForUser($param)
    {

        $mod = '';
        $format = 'Y' . $mod . 'm' . $mod . 'd';
        $dateToday = dateTimeSetting::jdate($format, time(), '', '', 'en');
        $Model = Load::library('Model');

        $data['is_del'] = 'yes';
        $condition
            = "id_city='{$param['id_city']}' AND id_hotel='{$param['id_hotel']}'
                    AND id_room='{$param['id_room']}' AND user_type='{$param['user_type']}'
                    AND date>='{$param['startDate']}' AND date<='{$param['endDate']}'";
        $Model->setTable('reservation_hotel_room_prices_tb');
        $res = $Model->update($data, $condition);
        if ($res) {
            return 'success : حذف تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در  تغییرات';
        }


    }

    ///////////////////حذف قیمت اتاق/////////////////
    public function deleteRoomPrice($idHotel, $id, $type)
    {

        $Model = Load::library('Model');

        $data['is_del'] = 'yes';
        $condition = "id_hotel='{$idHotel}' AND {$type}='{$id}'";
        $Model->setTable('reservation_hotel_room_prices_tb');
        $res = $Model->update($data, $condition);

        if ($res) {
            return 'success : حذف تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در  تغییرات';
        }


    }


    public function SelectRoomPrices($city, $hotel, $room, $user, $id_same, $date = '')
    {

        $mod = '';
        $format = 'Y' . $mod . 'm' . $mod . 'd';
        $dateToday = dateTimeSetting::jdate($format, time(), '', '', 'en');

        $Model = Load::library('Model');

        if (isset($date) && $date != '') {

            $sql
                = " SELECT * FROM reservation_hotel_room_prices_tb
                    WHERE id_city='{$city}' AND id_hotel='{$hotel}' AND id_room='{$room}' 
                    AND user_type='{$user}' AND id_same='{$id_same}' AND is_del='no'
                    AND date='{$date}' 
                    GROUP BY flat_type
                    ORDER BY id ASC ";

        } else {

            $sql
                = " SELECT * FROM reservation_hotel_room_prices_tb
                    WHERE id_city='{$city}' AND id_hotel='{$hotel}' AND id_room='{$room}' 
                    AND user_type='{$user}' AND id_same='{$id_same}' AND is_del='no'
                    AND date>='{$dateToday}' 
                    GROUP BY flat_type
                    ORDER BY id ASC ";

        }

        $res = $Model->select($sql);

        if (!empty($res)) {

            foreach ($res as $val) {

                switch ($val['flat_type']) {
                    case 'DBL':
                        $this->listRoomPrices_DBL = $val;
                        break;
                    case 'EXT':
                        $this->listRoomPrices_EXT = $val;
                        break;
                    case 'ECHD':
                        $this->listRoomPrices_ECHD = $val;
                        break;
                    case 'CHD':
                        $this->listRoomPrices_CHD = $val;

                        break;
                }

            }

        } else {
            header("Location: " . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . "/404.tpl");
        }

    }

    private function cleanPrice($price)
    {
        // پاک کردن کاما، فاصله و هر کاراکتر غیرعددی
        $price = preg_replace('/[^\d]/', '', $price);
        return (int)$price; // تبدیل به عدد صحیح
    }


    ///////////////////////////////// ویرایش قیمت اتاق/////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////
    public function updateRoomPricesForUser($info)
    {


        $Model = Load::library('Model');
        $idSame = $this->GetIdSame();

        // حلقه برای قیمت تخت اصلی و تخت اضافه بزرگسال و کودک //
        for ($i = 1; $i <= 4; $i++) {

            // اگر تخت اصلی بود //
            if ($info['age' . $i] == "DBL") {

                $flag_adl = 1;
                // شرط برای نحوه محاسبه قیمت ها //s
                if ($info['discount_status'] == 1) {

                    $info_online_price = str_replace(",", "", $info['online_price' . $i]);
                    $discount = $info['discount'];
                    $board_price = $info_online_price;

                    $discount_price = ($discount * $info_online_price) / 100;
                    $online_price = $board_price - $discount_price;

                } else if ($info['discount_status'] == 2) {

                    $info_board_price = str_replace(",", "", $info['board_price' . $i]);
                    $info_online_price = str_replace(",", "", $info['online_price' . $i]);

                    $t = ($info_board_price) - ($info_online_price);
                    $d = ($t * 100) / $info_board_price;
                    $discount = round($d);

                    $board_price = $info_board_price;
                    $online_price = $info_online_price;

                }


            } else {

                $flag_adl = 0;
                $discount = '0';
                $board_price = '0';
                if($info['age'.$i] == 'CHD') {
                    $online_price = '0';
                }else{
                    $online_price = str_replace(",", "", $info['online_price' . $i]);
                }


            }


            $data['total_capacity'] = $info['total_capacity'];
            $data['maximum_capacity'] = $info['maximum_capacity'];
            $data['remaining_capacity'] = $info['maximum_capacity'];
            $data['discount_status'] = $info['discount_status'];
            $data['discount'] = $discount;
            $data['board_price'] = $board_price;
            $data['online_price'] = $online_price;
            $data['currency_price'] = $info['currency_price' . $i];
            $data['currency_type'] = $info['currency_type'. $i];

            $data['other_services'] = $info['other_services'];
            $data['specific_description'] = $info['specific_description'];
            $data['com_gharardad_coWorker'] = '';
            $data['com_gharardad_passenger'] = '';
            $data['onrequest_time'] = $info['onrequest_time'];
            $data['reserve_time_canceled'] = $info['reserve_time_canceled'];
            $data['sell_for_night'] = $info['sell_for_night'];
            $data['flag_dbl'] = $flag_adl;

            if (isset($info['breakfast']) && $info['breakfast'] != '') {
                $data['breakfast'] = $info['breakfast'];
            } else {
                $data['breakfast'] = 'no';
            }
            if (isset($info['lunch']) && $info['lunch'] != '') {
                $data['lunch'] = $info['lunch'];
            } else {
                $data['lunch'] = 'no';
            }
            if (isset($info['dinner']) && $info['dinner'] != '') {
                $data['dinner'] = $info['dinner'];
            } else {
                $data['dinner'] = 'no';
            }
            if (isset($info['guest_user_status']) && $info['guest_user_status'] != '') {
                $data['guest_user_status'] = $info['guest_user_status'];
            } else {
                $data['guest_user_status'] = 'no';
            }

            if($info['age'.$i] == 'CHD' || $info['age'.$i] == 'ECHD'){
                $data['fromAge'] = $info['childFromAge'.$i] ? $info['childFromAge'.$i] : "0";
                $data['toAge'] = $info['childToAge'.$i];
            }else{
                $data['fromAge'] = '';
                $data['toAge'] = '';
            }

            $data['id_same'] = $idSame;


            // شرط برای تشخیص اینکه ویرایش برای یک روز است یا در بازه زمانی //
            if (isset($info['edit']) && $info['edit'] == 'editRoomPricesForUser') {

                $link = "editRoomPricesForUser&id=" . $info['id'] . "&sDate=" . $info['sDate'] . '&eDate=' . $info['eDate'];

                $Condition
                    = " id_city='{$info['id_city']}' AND id_hotel='{$info['id_hotel']}'
                    AND id_room='{$info['id_room']}' AND user_type='{$info['user_type']}'
                    AND is_del='no' AND flat_type='{$info['age'.$i]}'
                    AND date>='{$info['start_date']}' AND date<='{$info['end_date']}'
                    ";

            } else if (isset($info['edit']) && $info['edit'] == 'editRoomPrices') {

                $link = "editRoomPrices&id=" . $info['id'] . "&date=" . $info['date'];

                $Condition
                    = " id_city='{$info['id_city']}' AND id_hotel='{$info['id_hotel']}'
                    AND id_room='{$info['id_room']}' AND user_type='{$info['user_type']}'
                    AND is_del='no' AND flat_type='{$info['age'.$i]}'
                    AND date='{$info['start_date']}'";

            }
            $board_price = $this->cleanPrice($board_price);
            $online_price = $this->cleanPrice($online_price);
            $data['currency_price'] = $this->cleanPrice($info['currency_price' . $i]);
            $data['board_price'] = $board_price;
            $data['online_price'] = $online_price;


            $Model->setTable("reservation_hotel_room_prices_tb");
            $res = $Model->update($data, $Condition);


        }


        if ($res) {
            return 'success :  تغییرات با موفقیت انجام شد' . ':' . $link;
        } else {
            return 'error : خطا در  تغییرات' . ':' . $link;
        }

    }


    ///کنسل درخواست رزرو هتل توسط مدیر
    public function cancelHotelReservation($factorNumber, $typeApplication)
    {
        $ModelBase = Load::library('ModelBase');
        $reportHotelModel = Load::getModel('reportHotelModel');

        $data['status'] = 'Cancelled';
        $data['creation_date_int'] = time();


        $book = $reportHotelModel->get()->where('factor_number',$factorNumber)->groupBy('room_id')->find();

        if (!$book) {
            return 'error | خطا شماره فاکتور';
        }

        $Condition = " factor_number='{$factorNumber}' ";
        $ModelBase->setTable("report_hotel_tb");
        $res1 = $ModelBase->update($data, $Condition);

        if ($typeApplication == 'reservation' || $typeApplication == 'reservation_app') {

            $Model = Load::library('Model');
            $Model->setTable("book_hotel_local_tb");
            $res2 = $Model->update($data, $Condition);

            if ($res1 && $res2) {
                $smsController = Load::controller('smsServices');
                $objSms = $smsController->initService('0');
                if ($objSms) {
                    if (!empty(  $book['member_mobile'])) {
                        $mobile = $book['member_mobile'];
                        $name = $book['member_name'];
                    } else {
                        $mobile = $book['passenger_leader_room'];
                        $name = $book['passenger_leader_room_fullName'];
                    }
                    $cancel_on_request_hotel_pattern =   $smsController->getPattern('cancel_on_request_hotel');
                    if($cancel_on_request_hotel_pattern) {
                        $smsController->smsByPattern($cancel_on_request_hotel_pattern['pattern'], array($mobile), array('customer_name' => CLIENT_NAME , 'factor_number' => $book['factor_number']));
                    }else {
                        $messageVariables = array(
                            'sms_name' => $name,
                            'sms_service' => 'هتل',
                            'sms_factor_number' => $book['factor_number'],
                            'sms_cost' => $book['total_price'],
                            'sms_destination' => $book['city_name'],
                            'sms_hotel_name' => $book['hotel_name'],
                            'sms_hotel_in' => $book['start_date'],
                            'sms_hotel_out' => $book['end_date'],
                            'sms_hotel_night' => $book['number_night'],
                            'sms_agency' => CLIENT_NAME,
                            'sms_agency_mobile' => CLIENT_MOBILE,
                            'sms_agency_phone' => CLIENT_PHONE,
                            'sms_agency_email' => CLIENT_EMAIL,
                            'sms_agency_address' => CLIENT_ADDRESS,
                        );

                         $hotel_reserve_pattern  =   $smsController->getPattern('hotel_request_no_confirm_pattern_sms');
                        if($hotel_reserve_pattern) {
                            $smsController->smsByPattern($hotel_reserve_pattern['pattern'], array($mobile),$messageVariables);
                        }else {
                            $smsArray = array(
                                'smsMessage' => $smsController->getUsableMessage('onRequestNoConfirm', $messageVariables),
                                'cellNumber' => $mobile,
                                'smsMessageTitle' => 'onRequestNoConfirm',
                                'memberID' => (!empty($book['member_id']) ? $book['member_id'] : ''),
                                'receiverName' => $messageVariables['sms_name'],
                            );
                            $smsController->sendSMS($smsArray);
                        }
                    }
                }
            }

        } elseif ($typeApplication == 'api' || $typeApplication == 'api_app') {

            $sql = " SELECT * FROM report_hotel_tb WHERE factor_number='{$factorNumber}' GROUP BY factor_number";
            $book = $ModelBase->load($sql);
            $admin = Load::controller('admin');
            $res2 = $admin->ConectDbClient('', $book['client_id'], 'Update', $data, 'book_hotel_local_tb', $Condition);

        }

        if ($res1 && $res2) {
            return 'success :  تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در  تغییرات';
        }


    }

    ////تایید درخواست رزرو هتل توسط مدیر
    public function confirmationHotelReservation($factorNumber, $typeApplication)
    {
        /** @var bookHotelLocalModel $bookHotelLocalModel */
        /** @var reportHotelModel $reportHotelModel */
        $bookHotelLocalModel = Load::getModel('bookHotelLocalModel');
        $reportHotelModel = Load::getModel('reportHotelModel');

        if ($typeApplication == 'reservation' || $typeApplication == 'reservation_app') {

            $data['status'] = 'PreReserve';
            $data['creation_date_int'] = time();
            $Condition = " factor_number='{$factorNumber}' ";

            $res2 = $bookHotelLocalModel->updateWithBind($data, $Condition);
            $res1 = $reportHotelModel->updateWithBind($data, $Condition);

            if ($res1 && $res2) {
                return 'success |  تغییرات با موفقیت انجام شد';
            } else {
                return 'error | خطا در  تغییرات';
            }
        } elseif ($typeApplication == 'api' || $typeApplication == 'api_app') {
            $objApiHotel = Load::library('apiHotelLocal');

            return $objApiHotel->hotelReserveRoomForApi($factorNumber);

        } else {
            return 'Error | نوع درخواست اشتباه است';
        }

    }


    public function ConfirmHotel($param)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $d['code_confirm_hotel'] = $param['codeConfirmHotel'];
        $d['comment_confirm_hotel'] = $param['commentConfirmHotel'];
        $d['status_confirm_hotel'] = $param['status'];

        $Condition = " factor_number='{$param['factorNumber']}' ";

        $Model->setTable("book_hotel_local_tb");
        $res2 = $Model->update($d, $Condition);

        $ModelBase->setTable("report_hotel_tb");
        $res1 = $ModelBase->update($d, $Condition);


        if ($res1 && $res2) {
            return 'success :  تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در  تغییرات';
        }

    }


    public function checkForConfirmHotel($factorNumber)
    {
        $Model = Load::library('Model');
        $smsController = Load::controller('smsServices');

        $sql = "SELECT * FROM book_hotel_local_tb WHERE factor_number='{$factorNumber}'";
        $res = $Model->load($sql);

        if (!empty($res['member_mobile'])) {
            $mobile = $res['member_mobile'];
            $name = $res['member_name'];
        } else {
            $mobile = $res['passenger_leader_room'];
            $name = $res['passenger_leader_room_fullName'];
        }

        if ($res['status'] == 'PreReserve') {

            //sms to buyer
            $objSms = $smsController->initService('0');
            if ($objSms) {
              $confirm_on_request_hotel_pattern =   $smsController->getPattern('confirm_on_request_hotel');
                if($confirm_on_request_hotel_pattern) {
                    $smsController->smsByPattern($confirm_on_request_hotel_pattern['pattern'], array($mobile), array('customer_name' => CLIENT_NAME , 'factor_number' => $res['factor_number']));
                }else {
                    $messageVariables = array(
                        'sms_name' => $name,
                        'sms_service' => 'هتل',
                        'sms_factor_number' => $res['factor_number'],
                        'sms_cost' => $res['total_price'],
                        'sms_destination' => $res['city_name'],
                        'sms_hotel_name' => $res['hotel_name'],
                        'sms_hotel_in' => $res['start_date'],
                        'sms_hotel_out' => $res['end_date'],
                        'sms_hotel_night' => $res['number_night'],
                        'sms_agency' => CLIENT_NAME,
                        'sms_agency_mobile' => CLIENT_MOBILE,
                        'sms_agency_phone' => CLIENT_PHONE,
                        'sms_agency_email' => CLIENT_EMAIL,
                        'sms_agency_address' => CLIENT_ADDRESS,
                    );
                    $hotel_reserve_pattern  =   $smsController->getPattern('hotel_request_confirm_pattern_sms');
                    if($hotel_reserve_pattern) {
                        $smsController->smsByPattern($hotel_reserve_pattern['pattern'], array($mobile),$messageVariables);
                    }else {
                        $smsArray = array(
                            'smsMessage' => $smsController->getUsableMessage('onRequestConfirm', $messageVariables),
                            'cellNumber' => $mobile,
                            'smsMessageTitle' => 'onRequestConfirm',
                            'memberID' => (!empty($res['member_id']) ? $res['member_id'] : ''),
                            'receiverName' => $messageVariables['sms_name'],
                        );
                        $smsController->sendSMS($smsArray);
                    }
                }
            }

            return 'PreReserve';

        } else if ($res['status'] == 'Cancelled') {
            return 'Cancelled';
        } else if ($res['status'] == 'OnRequest' && $res['admin_checked'] == 0) {
            return 'OnRequest';
        } else if ($res['status'] == 'OnRequest' && $res['admin_checked'] == 1) {
            return 'AdminChecking';
        } else {
            return 'error';
        }

    }


    public function cancelReserveHotel($factorNumber)
    {
        $ModelBase = Load::library('ModelBase');
        $Model = Load::library('Model');
        $smsController = Load::controller('smsServices');

        $data['status'] = 'Cancelled';
        $data['creation_date_int'] = time();

        $Condition = " factor_number='{$factorNumber}' AND admin_checked = 0";
        $Model->setTable("book_hotel_local_tb");
        $res1 = $Model->update($data, $Condition);
        $ModelBase->setTable("report_hotel_tb");
        $res2 = $ModelBase->update($data, $Condition);

        if ($res1 && $res2) {

            $sql = "SELECT * FROM book_hotel_local_tb WHERE factor_number='{$factorNumber}'";
            $res = $Model->load($sql);
            if (!$res['status'] == 'Cancelled') {
                return 'error';
            }
            if (!empty($res['member_mobile'])) {
                $mobile = $res['member_mobile'];
                $name = $res['member_name'];
            } else {
                $mobile = $res['passenger_leader_room'];
                $name = $res['passenger_leader_room_fullName'];
            }

            //sms to buyer
            $objSms = $smsController->initService('0');
            if ($objSms) {
                $cancel_on_request_hotel_pattern =   $smsController->getPattern('cancel_on_request_hotel');
                    if($cancel_on_request_hotel_pattern) {
                        $smsController->smsByPattern($cancel_on_request_hotel_pattern['pattern'], array($mobile), array('customer_name' => CLIENT_NAME , 'factor_number' => $res['factor_number']));
                    }else {
                        $messageVariables = array(
                            'sms_name' => $name,
                            'sms_service' => 'هتل',
                            'sms_factor_number' => $res['factor_number'],
                            'sms_cost' => $res['total_price'],
                            'sms_destination' => $res['city_name'],
                            'sms_hotel_name' => $res['hotel_name'],
                            'sms_hotel_in' => $res['start_date'],
                            'sms_hotel_out' => $res['end_date'],
                            'sms_hotel_night' => $res['number_night'],
                            'sms_agency' => CLIENT_NAME,
                            'sms_agency_mobile' => CLIENT_MOBILE,
                            'sms_agency_phone' => CLIENT_PHONE,
                            'sms_agency_email' => CLIENT_EMAIL,
                            'sms_agency_address' => CLIENT_ADDRESS,
                        );
                     $hotel_reserve_pattern  =   $smsController->getPattern('hotel_request_confirm_pattern_sms');
                    if($hotel_reserve_pattern) {
                        $smsController->smsByPattern($hotel_reserve_pattern['pattern'], array($mobile),$messageVariables);
                    }else {
                        $smsArray = array(
                            'smsMessage' => $smsController->getUsableMessage('onRequestNoConfirm', $messageVariables),
                            'cellNumber' => $mobile,
                            'smsMessageTitle' => 'onRequestNoConfirm',
                            'memberID' => (!empty($res['member_id']) ? $res['member_id'] : ''),
                            'receiverName' => $messageVariables['sms_name'],
                        );
                        $smsController->sendSMS($smsArray);
                    }
                    }
            }

            return 'success';

        } else {
            $sql = "SELECT * FROM book_hotel_local_tb WHERE factor_number='{$factorNumber}'";
            $res = $Model->load($sql);
            if ($res['status'] == 'OnRequest' && $res['admin_checked'] == 0) {
                return 'withoutAdminCheck';
            }

            return 'error';
        }

    }


    public function sendEmailForHotelBroker($factorNumber, $hotelId)
    {
        $ModelBase = Load::library('ModelBase');
        $Model = Load::library('Model');

        //$pdfUrl = ROOT_ADDRESS_WITHOUT_LANG . '/ehotelReservation&num=' . $factorNumber;

        $sql = "SELECT hotel_name, city_name, start_date, end_date, number_night FROM book_hotel_local_tb WHERE factor_number='{$factorNumber}'";
        $hotel = $Model->load($sql);

        $sqlBroker = "SELECT email, broker FROM reservation_hotel_broker_tb WHERE id_hotel='{$hotelId}' AND choose='yes' AND is_del='no' ";
        $hotelBroker = $Model->select($sqlBroker);
        if (!empty($hotelBroker)) {

            foreach ($hotelBroker as $value) {

                /*$emailContent = '
                <tr>
                    <td valign="top" class="mcnTextContent" style="padding: 18px;color: #000000;font-size: 14px;font-weight: normal;text-align: center;">
                        <h3 class="m_-2679729263370124627null" style="text-align:center;display:block;margin:0;padding:0;color:#000000;font-family:tahoma,verdana,segoe,sans-serif;font-size:22px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal">
    رزرو هتل
                            <span style="color:#FFFFFF"><strong>' . $hotel['hotel_name'] . '</strong></span>
                            <span style="color:#FFFFFF"><strong>' . $hotel['city_name'] . '</strong></span>
                        </h3>
                        <div style="margin-top: 20px;text-align:right;color:#FFFFFF; font-family:tahoma,verdana,segoe,sans-serif">
                        با سلام <br>
 دوست عزیز؛ درخواست رزرو هتل ' . $hotel['city_name'] . ' در شهر ' . $hotel['hotel_name'] . ' در تاریخ ' . $hotel['start_date'] . ' تا ' . $hotel['end_date'] . ' به مدت ' . $hotel['number_night'] . ' به شماره رزرو ' . $factorNumber . ' منتظر تأیید کارگزار محترم ' . $value['broker'] . ' می باشد.<br>
                        لطفا جهت مشاهده و چاپ واچر هتل بر روی دکمه چاپ واچر هتل که در قسمت پایین قرار دارد کلیک نمایید
                        </div>
                    </td>
                </tr>
                ';

                $pdfButton = '
                <tr>
                    <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 14px;">
                        <a class="mcnButton " title="چاپ واچر هتل" href="' . $pdfUrl . '" target="_blank" style="background-color: #284861;padding: 15px;margin:5px 0;border-radius: 10px;font-weight: bold;letter-spacing: 0px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">چاپ واچر هتل</a>
                    </td>
                </tr>
                ';*/

                $emailBody = 'با سلام' . '<br>';
                $emailBody .= 'دوست عزیز؛ درخواست رزرو هتل '
                    . $hotel['city_name']
                    . ' در شهر '
                    . $hotel['hotel_name']
                    . ' در تاریخ '
                    . $hotel['start_date']
                    . ' تا '
                    . $hotel['end_date']
                    . ' به مدت '
                    . $hotel['number_night']
                    . ' به شماره رزرو '
                    . $factorNumber
                    . ' منتظر تأیید کارگزار محترم '
                    . $value['broker']
                    . ' می باشد.'
                    . '<br>';
                $emailBody .= 'لطفا جهت مشاهده و چاپ واچر هتل بر روی دکمه چاپ واچر هتل که در قسمت پایین قرار دارد کلیک نمایید' . '<br>';

                $param['title'] = 'رزرو هتل ' . $hotel['hotel_name'] . ' - ' . $hotel['city_name'];
                $param['body'] = $emailBody;
                $param['pdf'][0]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/ehotelReservation&num=' . $factorNumber;
                $param['pdf'][0]['button_title'] = 'چاپ واچر هتل';

                $to = $value['email'];
                $subject = "رزرو هتل";
                $message = functions::emailTemplate($param);
                $headers = "From: noreply@" . CLIENT_DOMAIN . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=UTF-8";
                ini_set('SMTP', 'smtphost');
                ini_set('smtp_port', 25);
                mail($to, $subject, $message, $headers);
            }


            $data['status_confirm_hotel'] = 'sendMail';

            $Condition = " factor_number='{$factorNumber}' ";
            $Model->setTable("book_hotel_local_tb");
            $res1 = $Model->update($data, $Condition);
            $ModelBase->setTable("report_hotel_tb");
            $res2 = $ModelBase->update($data, $Condition);

            if ($res1 && $res2) {
                echo 'success : ارسال ایمیل به کارگزار هتل با موفقیت انجام شد';
            } else {
                echo 'error : خطا در  تغییرات';
            }
        } else {
            echo 'error : برای هتل کارگزاری تعریف نشده است';
        }


    }


    public function orderHotelActive($id)
    {

        $Model = Load::library('Model');

        $sql = " SELECT enable FROM reservation_order_hotel_tb WHERE id='{$id}' AND is_del='no' ";
        $orderHotel = $Model->load($sql);

        if ($orderHotel['enable'] == '1') {
            $d['enable'] = '0';
            $data['enable'] = '1';
        } else {
            $d['enable'] = '1';
            $data['enable'] = '0';
        }
        $Condition = "id='{$id}' ";
        $Model->setTable("reservation_order_hotel_tb");
        $res1 = $Model->update($d, $Condition);

        $Condition = "id!='{$id}' ";
        $Model->setTable("reservation_order_hotel_tb");
        $res2 = $Model->update($data, $Condition);

        if ($res1 && $res2) {
            return 'success :  تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در  تغییرات';
        }

    }

    public function insertOrderHotel($title)
    {

        $Model = Load::library('Model');

        $sql = " SELECT id FROM reservation_order_hotel_tb WHERE title='{$title}' AND is_del='no' ";
        $orderHotel = $Model->load($sql);

        if (empty($orderHotel)) {
            $d['title'] = $title;
            $d['enable'] = '0';
            $d['is_del'] = 'no';

            $Model->setTable('reservation_order_hotel_tb');
            $res = $Model->insertLocal($d);

            if ($res) {
                return 'success :  تغییرات با موفقیت انجام شد';
            } else {
                return 'error : خطا در  تغییرات';
            }
        } else {
            return 'error : اطلاعات تکراری میباشد.';
        }


    }

    public function orderHotel()
    {

        $Model = Load::library('Model');
        $sql = " SELECT * FROM reservation_order_hotel_tb WHERE is_del='no' ORDER BY id ASC ";
        $res = $Model->select($sql);

        return $res;

    }
    public function activeOrderHotel()
    {

        $Model = Load::library('Model');
        $sql = " SELECT * FROM reservation_order_hotel_tb WHERE is_del='no' and enable = 1 ORDER BY id ASC ";
        $res = $Model->select($sql);

        return $res;

    }

    //////////گزارش اتاق های هتل بر اساس کد یکسان//////////
    public function reportAllHotelRooms($city, $hotel)
    {

        $mod = '';
        $format = 'Y' . $mod . 'm' . $mod . 'd';
        $dateToday = dateTimeSetting::jdate($format, time(), '', '', 'en');

        $Model = Load::library('Model');
        $sql = "SELECT HRP.id_hotel, MIN( HRP.date ) AS minDate, MAX( HRP.date ) AS maxDate, HRP.id_same, HR.room_name, H.name as hotel_name
FROM reservation_hotel_room_prices_tb HRP
LEFT JOIN reservation_hotel_room_tb HR ON HR.id_room = HRP.id_room 
LEFT JOIN reservation_hotel_tb H ON H.id = HRP.id_hotel
WHERE HRP.id_city = '$city' AND HRP.id_hotel = '$hotel' AND HRP.date >= '$dateToday' AND HRP.flat_type = 'DBL' AND HRP.is_del = 'no' 
GROUP BY HRP.id_same 
ORDER BY HRP.id_same;
";

        $hotel = $Model->select($sql);
        $this->reportAllHotelRooms = $hotel;

    }


    //////////گزارش اتاق های هتل بر اساس کد یکسان//////////
    public function infoAllHotelRooms($idHotel, $idSame)
    {

        $mod = '';
        $format = 'Y' . $mod . 'm' . $mod . 'd';
        $dateToday = dateTimeSetting::jdate($format, time(), '', '', 'en');

        $Model = Load::library('Model');
        $sqlRoom
            = " SELECT *, MIN(date) as minDate, MAX(date) as maxDate
                 FROM reservation_hotel_room_prices_tb 
                 WHERE id_hotel='{$idHotel}' AND id_same='{$idSame}' AND date>='{$dateToday}' AND is_del='no'
                 GROUP BY id_room, flat_type
                 ORDER BY id";
        $rooms = $Model->select($sqlRoom);

        $i = -1;
        foreach ($rooms as $k => $room) {
            if ($k == 0) {
                $this->infoRoomPrice = $room;
            }
            if ($room['flat_type'] == 'DBL') {
                $i++;
                $infoRooms[$i]['DBL'] = $room;
            } elseif ($room['flat_type'] == 'EXT') {
                $infoRooms[$i]['EXT']['online_price'] = $room['online_price'];
                $infoRooms[$i]['EXT']['board_price'] = $room['board_price'];
                $infoRooms[$i]['EXT']['currency_price'] = $room['currency_price'];
            } elseif ($room['flat_type'] == 'ECHD') {
                $infoRooms[$i]['ECHD']['online_price'] = $room['online_price'];
                $infoRooms[$i]['ECHD']['board_price'] = $room['board_price'];
                $infoRooms[$i]['ECHD']['currency_price'] = $room['currency_price'];
                $infoRooms[$i]['ECHD']['childFromAge'] = $room['fromAge'];
                $infoRooms[$i]['ECHD']['childToAge'] = $room['toAge'];
            }
            elseif ($room['flat_type'] == 'CHD') {
                $infoRooms[$i]['CHD']['online_price'] = $room['online_price'];
                $infoRooms[$i]['CHD']['board_price'] = $room['board_price'];
                $infoRooms[$i]['CHD']['currency_price'] = $room['currency_price'];
                $infoRooms[$i]['CHD']['childFromAge'] = $room['fromAge'];
                $infoRooms[$i]['CHD']['childToAge'] = $room['toAge'];
            }
        }
        $this->hotelRooms = $infoRooms;

        $sqlUser
            = " SELECT discount, maximum_capacity, user_type
                 FROM reservation_hotel_room_prices_tb 
                 WHERE id_same='{$idSame}' AND date>='{$dateToday}' AND is_del='no'
                 GROUP BY user_type
                 ORDER BY id";
        $users = $Model->select($sqlUser);
        foreach ($users as $user) {
            $this->users[$user['user_type']]['user_type'] = $user['user_type'];
            $this->users[$user['user_type']]['comition_hotel'] = $user['discount'];
            $this->users[$user['user_type']]['maximum_capacity'] = $user['maximum_capacity'];
        }

    }

    public function updateAllHotelRooms($param)
    {


        $mod = '';
        $format = 'Y' . $mod . 'm' . $mod . 'd';
        $dateToday = dateTimeSetting::jdate($format, time(), '', '', 'en');
        $Model = Load::library('Model');
        $objController = Load::controller('reservationPublicFunctions');

        if (isset($param['breakfast']) && $param['breakfast'] == 'yes') {
            $breakfast = 'yes';
        } else {
            $breakfast = 'no';
        }
        if (isset($param['lunch']) && $param['lunch'] == 'yes') {
            $lunch = 'yes';
        } else {
            $lunch = 'no';
        }
        if (isset($param['dinner']) && $param['dinner'] == 'yes') {
            $dinner = 'yes';
        } else {
            $dinner = 'no';
        }
        if (isset($param['guest_user_status']) && $param['guest_user_status'] = 'yes') {
            $guest_user_status = 'yes';
        } else {
            $guest_user_status = 'no';
        }

        $d['onrequest_time'] = $param['onrequest_time'];
        $d['reserve_time_canceled'] = $param['reserve_time_canceled'];
        $d['sell_for_night'] = $param['sell_for_night'];
        $d['breakfast'] = $breakfast;
        $d['lunch'] = $lunch;
        $d['dinner'] = $dinner;
        $d['guest_user_status'] = $guest_user_status;
        $d['other_services'] = $param['other_services'];
        $d['specific_description'] = $param['specific_description'];
        $d['discount_status'] = $param['discount_status'];

        $Condition = "id_hotel='{$param['idHotel']}' AND id_same='{$param['idSame']}' AND date>='{$dateToday}'";
        $Model->setTable("reservation_hotel_room_prices_tb");
        $res = $Model->update($d, $Condition);

        if ($res) {

            $this->countSecondInsert = 0;

            for ($i = 0; $i <= $param['countRoom']; $i++) {
                for ($j = 0; $j <= $param['countUser']; $j++) {

                    // برای بررسی تکراری نبودن //
                    $this->DuplicateRecords($param['idHotel'], $param['user_type' . $j]);


                    $sqlUser
                        = "SELECT * FROM reservation_hotel_room_prices_tb
                                      WHERE id_hotel='{$param['idHotel']}' AND id_same='{$param['idSame']}' AND 
                            id_room='{$param['id_room'.$i]}' AND user_type='{$param['user_type'.$j]}' ";
                    $resultUser = $Model->select($sqlUser);

                    // اگر انتخاب شده بود و قبلا وجود داشته: ویرایش شود //
                    if (isset($param['chk_user' . $j]) && $param['chk_user' . $j] != '' && !empty($resultUser)) {

                        // DBL
                        if ($param['discount_status'] == 1) {


                            $info_online_price = str_replace(",", "", $param['online_price_DBL' . $i]);
                            $discount = $param['discount' . $j];
                            $board_price = $info_online_price;
                            $discount_price = ($discount * $info_online_price) / 100;
                            $online_price = $board_price - $discount_price;

                        } else if ($param['discount_status'] == 2) {

                            $info_board_price = str_replace(",", "", $param['board_price_DBL' . $i]);
                            $info_online_price = str_replace(",", "", $param['online_price_DBL' . $i]);
                            $t = ($info_board_price) - ($info_online_price);
                            $d = ($t * 100) / $info_board_price;
                            if (!is_numeric($d) || is_nan($d)) {
                                 $discount = $param['discount' . $j];  // مقدار پیش‌فرض
                            } else {
                                $discount = round($d);
                            }
                            $board_price = $info_board_price;
                            $online_price = $info_online_price;

                        }

                        $room['discount'] = $discount;
                        $room['maximum_capacity'] = $param['maximum_capacity' . $j];
                        $room['remaining_capacity'] = $param['maximum_capacity' . $j];
                        $room['online_price'] = $online_price;
                        $room['board_price'] = $board_price;
                        $room['currency_price'] =  str_replace( ',', '', $param['currency_price_DBL' . $i] );


                        $room['currency_type'] = $param['currency_type' . $i];
                        $room['total_capacity'] = $param['total_capacity' . $i];
                        $Condition
                            = "id_hotel='{$param['idHotel']}' AND id_same='{$param['idSame']}' AND
                            id_room='{$param['id_room'.$i]}' AND user_type='{$param['user_type'.$j]}' AND
                            flat_type='DBL' AND date>='{$dateToday}' ";

                        $Model->setTable("reservation_hotel_room_prices_tb");
                        $res2[] = $resTest = $Model->update($room, $Condition);

                        // EXT
                        $online_price_EXT = str_replace(",", "", $param['online_price_EXT' . $i]);
                        $roomEXT['discount'] = 0;
                        $roomEXT['online_price'] = $online_price_EXT;
                        $roomEXT['board_price'] = 0;
                        $roomEXT['currency_price'] = $param['currency_price_EXT' . $i];
                        $roomEXT['total_capacity'] = $param['total_capacity' . $i];
                        $Condition
                            = "id_hotel='{$param['idHotel']}' AND id_same='{$param['idSame']}' AND
                            id_room='{$param['id_room'.$i]}' AND user_type='{$param['user_type'.$j]}' AND 
                            flat_type='EXT' AND date>='{$dateToday}' ";
                        $Model->setTable("reservation_hotel_room_prices_tb");
                        $res2[] = $resTest = $Model->update($roomEXT, $Condition);


                        // ECHD
                        $online_price_ECHD = str_replace(",", "", $param['online_price_ECHD' . $i]);
                        $roomECHD['discount'] = $discount;

                        $roomECHD['online_price'] = $online_price_ECHD;
                        $roomECHD['board_price'] = 0;
                        $roomECHD['currency_price'] = $param['currency_price_ECHD' . $i];
                        $roomECHD['total_capacity'] = $param['total_capacity' . $i];
                        $roomECHD['fromAge'] = $param['childFromAgeECHD' . $i];
                        $roomECHD['toAge'] = $param['childToAgeECHD' . $i];
                        $Condition
                            = "id_hotel='{$param['idHotel']}' AND id_same='{$param['idSame']}' AND
                            id_room='{$param['id_room'.$i]}' AND user_type='{$param['user_type'.$j]}' AND 
                            flat_type='ECHD' AND date>='{$dateToday}' ";
                        $Model->setTable("reservation_hotel_room_prices_tb");
                        $res2[] = $resTest = $Model->update($roomECHD, $Condition);


                        // CHD
                        $online_price_CHD = str_replace(",", "", $param['online_price_CHD' . $i]);
                        $roomECHD['discount'] = 0;
                        $roomECHD['online_price'] = $online_price_CHD;
                        $roomECHD['board_price'] = 0;
                        $roomECHD['currency_price'] = $param['currency_price_CHD' . $i];
                        $roomECHD['total_capacity'] = $param['total_capacity' . $i];
                        $roomECHD['fromAge'] = $param['childFromAgeCHD' . $i];
                        $roomECHD['toAge'] = $param['childToAgeCHD' . $i];

                        $Condition
                            = "id_hotel='{$param['idHotel']}' AND id_same='{$param['idSame']}' AND
                            id_room='{$param['id_room'.$i]}' AND user_type='{$param['user_type'.$j]}' AND 
                            flat_type='CHD' AND date>='{$dateToday}' ";
                        $Model->setTable("reservation_hotel_room_prices_tb");
                        $res2[] = $resTest = $Model->update($roomECHD, $Condition);

                        // اگر انتخاب شده بود و قبلا وجود نداشته: درج شود //
                    } elseif (isset($param['chk_user' . $j]) && $param['chk_user' . $j] != '' && empty($resultUser)) {

                        /*$dataInsert['id_same'] = $param['idSame'];
                        $dataInsert['onrequest_time'] = $param['onrequest_time'];
                        $dataInsert['reserve_time_canceled'] = $param['reserve_time_canceled'];
                        $dataInsert['sell_for_night'] = $param['sell_for_night'];
                        $dataInsert['breakfast'] = $breakfast;
                        $dataInsert['lunch'] = $lunch;
                        $dataInsert['dinner'] = $dinner;
                        $dataInsert['guest_user_status'] = $guest_user_status;
                        $dataInsert['other_services'] = $param['other_services'];
                        $dataInsert['specific_description'] = $param['specific_description'];
                        $dataInsert['discount_status'] = $param['discount_status'];
                        $dataInsert['id_country'] = $param['id_country'];
                        $dataInsert['id_city'] = $param['id_city'];
                        $dataInsert['id_region'] = $param['id_region'];
                        $dataInsert['id_hotel'] = $param['idHotel'];
                        $dataInsert['com_gharardad_coWorker'] = '';
                        $dataInsert['com_gharardad_passenger'] = '';
                        $dataInsert['is_del'] = 'no';

                        $dataInsert['id_room'] = $param['id_room' . $i];
                        $dataInsert['currency_type'] = $param['currency_type' . $i];
                        $dataInsert['total_capacity'] = $param['total_capacity' . $i];
                        $dataInsert['user_type'] = $param['user_type' . $j];
                        $dataInsert['maximum_capacity'] = $param['maximum_capacity' . $j];
                        $dataInsert['remaining_capacity'] = $param['maximum_capacity' . $j];*/

                        for ($bed = 1; $bed <= 4; $bed++) {
                            if ($bed == 1) {
                                $dataInsert['flat_type'] = 'DBL';
                                $dataInsert['flag_dbl'] = '1';
                                if ($param['discount_status'] == 1) {

                                    $info_online_price = str_replace(",", "", $param['online_price_DBL' . $i]);
                                    $discount = $param['discount' . $j];
                                    $board_price = $info_online_price;
                                    $discount_price = ($discount * $info_online_price) / 100;
                                    $online_price = $board_price - $discount_price;

                                } else if ($param['discount_status'] == 2) {

                                    $info_board_price = str_replace(",", "", $param['board_price_DBL' . $i]);
                                    $info_online_price = str_replace(",", "", $param['online_price_DBL' . $i]);
                                    $t = ($info_board_price) - ($info_online_price);
                                    $d = ($t * 100) / $info_board_price;
                                    $discount = round($d);
                                    $board_price = $info_board_price;
                                    $online_price = $info_online_price;

                                }

                                $dataInsert['discount'] = $discount;
                                $dataInsert['online_price'] = $online_price;
                                $dataInsert['board_price'] = $board_price;
                                $dataInsert['currency_price'] = $param['currency_price_DBL' . $i];



                            } elseif ($bed == 2) {
                                $dataInsert['flat_type'] = 'EXT';
                                $dataInsert['flag_dbl'] = '0';
                                $online_price_EXT = str_replace(",", "", $param['online_price_EXT' . $i]);
                                $dataInsert['discount'] = 0;
                                $dataInsert['online_price'] = $online_price_EXT;
                                $dataInsert['board_price'] = 0;
                                $dataInsert['currency_price'] = $param['currency_price_EXT' . $i];
                                $dataInsert['fromAge'] = '';
                                $dataInsert['toAge'] = '';

                            } elseif ($bed == 3) {
                                $dataInsert['flat_type'] = 'ECHD';
                                $dataInsert['flag_dbl'] = '0';
                                $online_price_ECHD = str_replace(",", "", $param['online_price_ECHD' . $i]);
                                $dataInsert['discount'] = 0;
                                $dataInsert['online_price'] = $online_price_ECHD;
                                $dataInsert['board_price'] = 0;
                                $dataInsert['currency_price'] = $param['currency_price_ECHD' . $i];
                                $dataInsert['fromAge'] = $param['childFromAgeECHD' . $i];
                                $dataInsert['toAge'] = $param['childToAgeECHD' . $i];
                            }
                            elseif ($bed == 4) {
                                $dataInsert['flat_type'] = 'CHD';
                                $dataInsert['flag_dbl'] = '0';
                                $online_price_CHD = str_replace(",", "", $param['online_price_CHD' . $i]);
                                $dataInsert['discount'] = 0;
                                $dataInsert['online_price'] = $online_price_CHD;
                                $dataInsert['board_price'] = 0;
                                $dataInsert['currency_price'] = $param['currency_price_CHD' . $i];
                                $dataInsert['fromAge'] = $param['childFromAgeCHD' . $i];
                                $dataInsert['toAge'] = $param['childToAgeCHD' . $i];
                            }

                            $startDate = str_replace("-", "", $param['start_date']);
                            $endDate = str_replace("-", "", $param['end_date']);
                            while ($startDate <= $endDate) {
                                //$dataInsert['date'] = $startDate;

                                // اگر تکرار وجود نداشت درج کند //
                                if (empty($this->arr_date_duplicate[$param['idHotel'] . $param['id_room' . $i] . $param['user_type' . $j] . $startDate . 'DBL'])) {
                                    $this->countSecondInsert++;
                                    if ($this->countSecondInsert == 1) {
                                        $this->secondSql = " INSERT INTO reservation_hotel_room_prices_tb VALUES";
                                    }
                                    if ($this->countSecondInsert % 100 == 0) {
                                        $this->secondSql = substr($this->secondSql, 0, -1);
                                        $res2[] = $resTest = $Model->execQuery($this->secondSql);
                                        $this->secondSql = " INSERT INTO reservation_hotel_room_prices_tb VALUES";
                                    }

                                    $this->secondSql
                                        .= "(
                                    '',
                                    '" . $param['idSame'] . "',
                                    '" . $param['id_country'] . "',
                                    '" . $param['id_city'] . "',
                                    '" . $param['id_region'] . "',
                                    '" . $param['idHotel'] . "',
                                    '" . $param['id_room' . $i] . "',
                                    '" . $param['user_type' . $j] . "',
                                    '" . $startDate . "',
                                    '" . $dataInsert['flat_type'] . "',
                                    '" . $param['discount_status'] . "',
                                    '" . $dataInsert['discount'] . "',
                                    '" . $dataInsert['board_price'] . "',
                                    '" . $dataInsert['online_price'] . "',
                                    '" . $dataInsert['currency_price'] . "',
                                    '" . $param['currency_type' . $i] . "',
                                    '" . $param['total_capacity' . $i] . "',
                                    '" . $param['maximum_capacity' . $j] . "',
                                    '" . $param['maximum_capacity' . $j] . "',
                                    '',
                                    '" . $breakfast . "',
                                    '" . $lunch . "',
                                    '" . $dinner . "',
                                    '" . $param['other_services'] . "',
                                    '" . $param['specific_description'] . "',
                                    '" . $guest_user_status . "',
                                    '',
                                    '',
                                    '',
                                    '" . $param['onrequest_time'] . "',
                                    '" . $param['reserve_time_canceled'] . "',
                                    '" . $param['sell_for_night'] . "',
                                    '" . $dataInsert['flag_dbl'] . "',
                                    '" . $dataInsert['fromAge'] . "',
                                    '" . $dataInsert['toAge'] . "',
                                    'no'
                                  
                                    ),";

                                    /*$Model->setTable('reservation_hotel_room_prices_tb');
                                    $res2[] = $Model->insertLocal($dataInsert);*/
                                }


                                //روز بعدی//
                                $startDate = $objController->dateNextFewDays($startDate, ' + 1');

                            }//end while StartDate<=EndDate
                        }


                        // اگر انتخاب نشده بود و قبلا وجود داشته: حذف شود //
                    } elseif (!empty($resultUser)) {
                        $dataDelete['is_del'] = 'yes';
                        $Condition
                            = "id_hotel='{$param['idHotel']}' AND id_same='{$param['idSame']}' AND
                            id_room='{$param['id_room'.$i]}' AND user_type='{$param['user_type'.$j]}' AND date>='{$dateToday}' ";
                        $Model->setTable("reservation_hotel_room_prices_tb");
                        $res2[] = $resTest = $Model->update($dataDelete, $Condition);

                    }

                }
            }


            //ثبت تعداد رکورد کمتر از 100 تا اینجا اتفاق میفتد
            if ($this->secondSql != '' && $this->countSecondInsert > 0) {
                $Model = Load::library('Model');
                $this->secondSql = substr($this->secondSql, 0, -1);
                $res2[] = $Model->execQuery($this->secondSql);
            }


            if (in_array('0', $res2)) {
                return 'error : خطا در  تغییرات';
            } else {
                return 'success :  تغییرات با موفقیت انجام شد';
            }

        } else {
            return 'error : خطا در  تغییرات';
        }

    }


    public function delete_transaction_current($factorNumber)
    {
        $Model = Load::library('Model');
        $data['PaymentStatus'] = 'pending';
        $condition = "FactorNumber = '{$factorNumber}' AND FactorNumber !=''";
        $Model->setTable('transaction_tb');
        $Model->update($data, $condition);
        //for admin panel , transaction table
        $this->transactions->updateTransaction($data, $condition);
    }


    public function allowEditingHotel($factorNumber, $memberId)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $user_type = functions::getCounterTypeId($memberId);
        $BookingHotelLocal = Load::controller('BookingHotelLocal');
        $result = $BookingHotelLocal->ReduceCapacity($user_type, $factorNumber, 'Decrease');

        if ($result == 'success') {

            $this->delete_transaction_current($factorNumber);

            $InfoBook = functions::GetInfoHotel($factorNumber);
            $detail['fk_agency_id'] = $InfoBook['agency_id'];
            $detail['credit'] = $InfoBook['total_price'];
            $detail['type'] = "increase";
            $detail['credit_date'] = dateTimeSetting::jdate("Y-m-d", time());
            $detail['reason'] = 'deposit';
            $detail['creation_date_int'] = time();
            $detail['member_id'] = $memberId;
            $detail['requestNumber'] = $factorNumber;
            $detail['comment'] = " ویرایش رزرو هتل رزرواسیون و برگشت اعتبار به شماره فاکتور " . $factorNumber;

            $Model->setTable('credit_detail_tb');
            $res = $Model->insertLocal($detail);

            if ($res) {

                $book['status'] = 'PreReserve';

                $condition = " factor_number='{$factorNumber}' ";
                $Model->setTable('book_hotel_local_tb');
                $resBookModel = $Model->update($book, $condition);
                $ModelBase->setTable('report_hotel_tb');
                $resBookModelBase = $ModelBase->update($book, $condition);
                if ($resBookModel && $resBookModelBase) {
                    return 'success :  تغییرات با موفقیت انجام شد';
                } else {
                    return 'error : خطا در  تغییرات پیش رزرو هتل';
                }


            } else {
                return 'error : خطا در  تغییرات برگشت اعتبار';
            }

        } else {

            return 'error : خطا در  تغییرات ظرفیت هتل';

        }


    }

    public function searchboxHotels($params)
    {


        $name = urldecode($params['inputValue']);
        $result = [];
        $hotelHtml = '';
        $i = 0;

        //		echo CLIENT_DOMAIN ;
        //		$sqlReservationCities = "
        //		SELECT id AS city_id,city_name AS city_name, city_name_en AS city_name_en FROM hotel_cities_tb WHERE city_name LIKE '{$name}%' OR city_name_en LIKE '{$name}%' OR city_iata LIKE '{$name}%'
        //		";

        /** @var hotelCitiesModel $hotel_cities */
        $hotel_cities = Load::getModel('hotelCitiesModel');
        if (!$name) {
            $result['Cities'] = [];
            $result['ApiHotels'] = [];
            $result['ReservationHotels'] = [];

            echo functions::clearJsonHiddenCharacters(json_encode($result));
            exit();
        }
        $cities = $hotel_cities->get(['id AS city_id', 'city_name', 'city_name_en'])
            ->like('city_name', "{$name}%", "LEFT")
            ->like('city_name_en', "{$name}%", "LEFT")
            ->like('city_iata', "{$name}%", "LEFT")
            ->all();

        $Model = Load::library('Model');
        if (count($cities) > 0) {
            $result['Cities'] = [];
            foreach ($cities as $city) {
                $cityItem = [
                    'CityId' => $city['city_id'],
                    'CityName' => $city['city_name'],
                    'CityNameEn' => $city['city_name_en'],
                    'index_name' => 'Cities',
                ];

                $result['Cities'][] = $cityItem;
            }
        }

        $sqlReservationHotel = "
		SELECT
	reservation_hotel_tb.`id` AS hotel_id,
	reservation_hotel_tb.`name` AS hotel_name,
	reservation_hotel_tb.`name_en` AS hotel_name_en,
	reservation_hotel_tb.`city` AS city_id,
	reservation_hotel_tb.`priority` AS hotel_priority,
	reservation_hotel_tb.`discount`,
	'roomHotelLocal' AS page,
	'reservation' AS typeApp,
	reservation_city_tb.`name` AS city_name
FROM
	reservation_hotel_tb
	INNER JOIN reservation_city_tb ON reservation_hotel_tb.city = reservation_city_tb.id
WHERE
	reservation_hotel_tb.`name` LIKE '%{$name}%'
	OR reservation_hotel_tb.`name_en` LIKE '%{$name}%'
	AND reservation_hotel_tb.`is_del` = 'no'";
        $reservationHotels = $Model->select($sqlReservationHotel);

        $labelReservation = "no";

        if (count($reservationHotels) > 0) {
            foreach ($reservationHotels as $hotel) {
                $i++;
                //				$ReservationHotel = [];
                $hotelNameEn = trim(strtolower($hotel['hotel_name_en']));
                $hotelNameEn = str_replace("  ", " ", $hotelNameEn);
                $hotelNameEn = str_replace(" ", "-", $hotelNameEn);

                $ReservationHotel = [
                    'HotelId' => trim($hotel['hotel_id']),
                    'HotelName' => join(' ', [trim($hotel['hotel_name']), trim($hotel['city_name'])]),
                    'HotelNameEn' => $hotelNameEn,
                    'CityName' => trim($hotel['city_name']),
                    'CityId' => $hotel['city_id'],
                    'index_name' => 'ReservationHotels',
                ];

                $result['ReservationHotels'][] = $ReservationHotel;
            }
        }
        /*get data from api */
        Load::library('ApiHotelCore');
        $ApiHotelCore = new ApiHotelCore();
        $apiResult = $ApiHotelCore->GetHotelsByName($name);
        if (is_array($apiResult) && count($apiResult) > 0) {
            foreach ($apiResult as $hotel) {
                $i++;
                $hotelNameEn = strtolower(trim(urldecode($hotel['NameEn'])));
                $hotelNameEn = str_replace("  ", " ", $hotelNameEn);
                $hotelNameEn = str_replace(" ", "-", $hotelNameEn);
                $ApiHotel = [
                    'HotelId' => $hotel['Id'],
                    'HotelName' => $hotel['Name'] . ' ' . $hotel['CityName'],
                    'HotelNameEn' => $hotelNameEn,
                    'CityName' => $hotel['CityName'],
                    'CityId' => $hotel['CityId'],
                    'index_name' => 'ApiHotels',
                ];

                $result['ApiHotels'][] = $ApiHotel;

            }
        }

        return $result;
    }


    public function searchboxExternalHotels( $params ) {

        /** @var ModelBase $ModelBase */
        $city = trim( urldecode( $params['inputValue'] ) );

        $request = [];
        foreach ( $params as $key => $param ) {

            $request[ $key ] = functions::checkParamsInput( $param );
        }

        $ModelBase = Load::library( 'ModelBase' );
        $city = functions::arabicToPersian($city);
        $city2 = $city;
        $pos = strpos($city, 'ا');
        if ($pos === 0) {
            $city2 = 'آ'. mb_substr($city,1);
        }

        $clientSql = "SELECT * FROM external_hotel_city_tb
                  WHERE
                    country_name_en != 'iran'
                    AND (
                    country_name_en LIKE '{$city}%'
                    OR country_name_fa LIKE '{$city}%'
                    OR country_name_fa LIKE '{$city2}%'
                    OR city_name_en LIKE '{$city}%'
                    OR city_name_fa LIKE '{$city}%'
                    OR city_name_fa LIKE '{$city2}%'
                    )
                    GROUP BY country_name_en,city_name_en
                    ";
        $result = $ModelBase->select( $clientSql ) ;
        $country_list = [];
        foreach ($result as $key => $country) {

            $country_list[$key]['CountryEn'] = $country['country_name_en'];
            $country_list[$key]['CountryFa'] = $country['country_name_fa'];
            $country_list[$key]['DepartureCode'] = $country['country_code'];
            $country_list[$key]['DepartureCityFa'] = $country['city_name_fa'] ? $country['city_name_fa'] : $country['city_name_en']  ;
            $country_list[$key]['DepartureCityEn'] = $country['city_name_en'] ;
        }

        return  $country_list;

    }

    public function flightExternalRoutesDefault($params)
    {

        /** @var ModelBase $ModelBase */

        $request = [];
        foreach ($params as $key => $param) {
            $request[$key] = functions::checkParamsInput($param);
        }


        if (isset($request['self_Db']) && $request['self_Db'] != true) {

            $ModelBase = Load::library('ModelBase');
            $clientSql = "SELECT  *  FROM flight_portal_tb";
            if($params['inputValue']){
                $clientSql.=" Where DepartureCityFa LIKE '%{$params['inputValue']}%' ";
                $clientSql.="OR DepartureCode LIKE '%{$params['inputValue']}%' ";
                $clientSql.="OR AirportFa LIKE '%{$params['inputValue']}%' ";
            }

            return $ModelBase->select($clientSql);
        } else {

            $ModelBase = Load::library('Model');
            $clientSql = "SELECT  *  FROM flight_portal_tb";
            if($params['inputValue']){
                $clientSql.=" Where DepartureCityFa LIKE '%{$params['inputValue']}%' ";
                $clientSql.="OR DepartureCode LIKE '%{$params['inputValue']}%' ";
                $clientSql.="OR AirportFa LIKE '%{$params['inputValue']}%' ";
            }

            return $ModelBase->select($clientSql);
        }


    }

    /**
     * @throws Exception
     */
    public function getHotelRoutes($params)
    {

        if ($params['strategy'] === 'local') {
            $params['inputValue'] = $params['value'];
            return $this->searchboxHotels($params);
        }
        if ($params['strategy'] === 'external') {
            $params['inputValue'] = $params['value'];

            return $this->searchboxExternalHotels($params);
        }

    }


    public function hotelReservationData($params){

        /** @var ModelBase $ModelBase */
        $limit             = "";
        $conditionSpecial  = "";
        $conditionDiscount = "";
        $conditionCountry  = "";
        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }
        $special  = $request['special'];
        $discount = $request['discount'];
        $date     = $request['dateNow'];
        $limit    = $request['limit'];
        $country  = $request['country'];
        $mod = '';
        $format = 'Y' . $mod . 'm' . $mod . 'd';
        $price_date_today = dateTimeSetting::jdate($format, time(), '', '', 'en');

        $reservation_hotel_list = $this->reservation_hotel_room_prices_model
            ->get([
                $this->reservation_hotel_table . '.name',
                $this->reservation_hotel_table . '.name_en',
                $this->reservation_hotel_table . '.comment',
                $this->reservation_hotel_table . '.discount',
                $this->reservation_hotel_table . '.star_code',
                $this->reservation_hotel_table . '.type_code',
                $this->reservation_hotel_table . '.id',
                $this->reservation_hotel_table . '.logo',
                $this->reservation_hotel_table . '.address',
                $this->reservation_hotel_table . '.city',
                $this->reservation_city_table . '.name as city_name' ,
                $this->reservation_hotel_room_prices_table . '.online_price as price',

            ], true)
            ->join($this->reservation_hotel_table, 'id', 'id_hotel' , 'INNER')
            ->join($this->reservation_hotel_table , 'id', 'city' , 'LEFT' ,$this->reservation_city_table )
//            ->where($this->reservation_hotel_room_prices_table . '.user_type' , '5' , '=')
            ->where($this->reservation_hotel_table . '.is_del' , 'no' , '=')
            ->where($this->reservation_hotel_room_prices_table . '.flat_type' , 'DBL' , '=')
            ->where($this->reservation_hotel_room_prices_table . '.is_del' , 'no' , '=')
            ->where($this->reservation_hotel_room_prices_table . '.date' , $price_date_today , '>=');


        if ( isset( $special ) && $special != "" ) {
            $reservation_hotel_list = $reservation_hotel_list->where($this->reservation_hotel_table . '.flag_special' , 'yes' , '=');
        }
        if ( isset( $special ) && $special == false ) {
            $reservation_hotel_list = $reservation_hotel_list->where($this->reservation_hotel_table . '.flag_special' , 'yes' , '!=');
        }
        if ( isset( $discount ) && $discount != "" ) {
            $reservation_hotel_list = $reservation_hotel_list->where($this->reservation_hotel_table . '.flag_discount' , 'yes' , '=');
        }
        if ( ! empty( $country ) ) {
            if ( $country == 'internal' ) {
                $reservation_hotel_list = $reservation_hotel_list->where($this->reservation_hotel_table . '.country' , '1' , '=');
            } elseif ( $country == 'external' ) {
                $reservation_hotel_list = $reservation_hotel_list->where($this->reservation_hotel_table . '.country' , '1' , '!=');
            }else {
                $reservation_hotel_list = $reservation_hotel_list->where($this->reservation_hotel_table . '.country' , $country , '=');
            }
        }

        if ( ! empty( $request['city'] ) ) {
            $reservation_hotel_list = $reservation_hotel_list->where($this->reservation_hotel_table . '.city' , $request['city'] , '=');
        }

        $reservation_hotel_list= $reservation_hotel_list->groupBy($this->reservation_hotel_table . '.id')
         ->orderBy($this->reservation_hotel_table . '.star_code' , 'DESC')
         ->orderBy($this->reservation_hotel_table . '.name' , 'ASC')
         ->orderBy($this->reservation_hotel_table . '.name' , 'DESC');

        if ( isset( $limit ) && $limit != "" ) {
            $reservation_hotel_list = $reservation_hotel_list->limit(0 , $limit);
        }


        return $reservation_hotel_list->all();
    }

    public function getHotelById($params){
        return $this->reservation_hotel_model->get(['*'])->where('id' , $params['id'])->find() ;
    }

    public function getUserReservationHotels() {
        $reservation_city_tb = $this->getModel('reservationCityModel')->getTable();
        $reservation_hotel_tb = $this->getModel('reservationHotelModel')->getTable();
        return $this->getModel('reservationHotelModel')
            ->get(['*' , $reservation_city_tb .'.name as city_name' , $reservation_city_tb .'.name_en as city_name_en'])
            ->join($reservation_city_tb , 'id'  , 'city')
            ->where($reservation_hotel_tb.'.user_id' , Session::getUserId() )
            ->where($reservation_hotel_tb.'.city' , 0 , '!=')
            ->where($reservation_hotel_tb.'.country' , 0 , '!=')
            ->orderBy('id' , 'DESC')->all();
    }
    public function getUserReservationHotelInfo($params) {

        $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        $tomorrow = dateTimeSetting::tomorrow();
        $tomorrow = str_replace('-' , '' , $tomorrow);
        $date = new DateTime(date("Y-m-d"));
        $date->modify('+7 day');
        $tomorrowDATE = $date->format('Y-m-d');
        $sevenDaysAfter = functions::DateJalali($tomorrowDATE);
        $sevenDaysAfter = str_replace('-' , '' , $sevenDaysAfter);
        $reservation_hotel_room_price_tb = $this->getModel('reservationHotelRoomPricesModel')->getTable();
        $reservation_hotel_room_tb = $this->getModel('reservationHotelRoomModel')->getTable();

        $room_list =  $this->getModel('reservationHotelRoomModel')
            ->get('*')
            ->where($reservation_hotel_room_tb.'.id_hotel' , $params['hotel_id'])
            ->where($reservation_hotel_room_tb.'.is_del' , 'no')
            ->all();
        $result = [] ;
        foreach ($room_list as $key => $room) {

            if($params['type'] == 'week') {
                $get_data_week = 'sum(remaining_capacity) ';
            }
            $room_price_list  = $this->getModel('reservationHotelRoomPricesModel')
                ->get([
                    '*' ,
                    'sum('.$reservation_hotel_room_price_tb.'.remaining_capacity) as sum_remaining_capacity',
                    'sum('.$reservation_hotel_room_price_tb.'.maximum_capacity) as sum_maximum_capacity'
                ])
                ->join($reservation_hotel_room_tb , 'id_room'  , 'id_room')
                ->where($reservation_hotel_room_price_tb.'.flat_type' , 'DBL')
                ->where($reservation_hotel_room_price_tb.'.id_hotel' , $params['hotel_id'])
                ->where($reservation_hotel_room_tb.'.id_hotel' , $params['hotel_id'])
                ->where($reservation_hotel_room_price_tb.'.id_room' , $room['id_room'])
                ->where($reservation_hotel_room_price_tb.'.user_type' , '5')
                ->where($reservation_hotel_room_tb.'.is_del' , 'no');
            if($params['type'] == 'today'){
                $room_price_list = $room_price_list->where($reservation_hotel_room_price_tb.'.date' , $dateNow);
            }else if($params['type'] == 'tomorrow') {
                $room_price_list = $room_price_list->where($reservation_hotel_room_price_tb.'.date' , $tomorrow);
            }else if($params['type'] == 'week') {
                $room_price_list = $room_price_list->where($reservation_hotel_room_price_tb.'.date' , $dateNow , '>=')
                    ->where($reservation_hotel_room_price_tb.'.date' , $sevenDaysAfter , '<=');
            }
            $room_price_list = $room_price_list->where($reservation_hotel_room_price_tb.'.is_del' , 'no');

            $room_price_list = $room_price_list->find();


            if($room_price_list['id']) {

                $data = [
                    'title'     => $room['room_name'],
                    'available'     => (int)$room_price_list['sum_remaining_capacity'],
                    'total'     => (int)$room_price_list['sum_maximum_capacity'],
                    'booked'     => (int)$room_price_list['sum_maximum_capacity'] - (int)$room_price_list['sum_remaining_capacity'],
                ];
                $result[$key] = $data;

            }else{
                $data = [
                    'title'     => $room['room_name'],
                    'available'     => 0,
                    'total'     => 0,
                    'booked'     => 0,
                ];
                $result[$key] = $data;
            }

        }
        $side_result = [];
        $available = 0 ;
        $booked = 0 ;
        $total = 0 ;
        foreach($result as $key => $room_price){
            $available += (int)$room_price['available'];
            $booked += (int)$room_price['booked'];
            $total += (int)$room_price['total'];
        }
        $side_result['total'] = $total;
        $side_result['booked'] = $booked;
        $side_result['available'] = $available;
        $final_result['chart'] =  $result;
        $final_result['sidebar'] =  $side_result;

        return functions::toJson($final_result);
    }

    public function getUserReservationHotelBook($params){

        $reservation_hotel_tb = $this->getModel('reservationHotelModel')->getTable();
        $book_hotel_tb = $this->getModel('bookHotelLocalModel')->getTable();
        $reservation_hotel_room_tb = $this->getModel('reservationHotelRoomModel')->getTable();
        
        $reserve_list =  $this->getModel('bookHotelLocalModel')
            ->get('*')
            ->join($reservation_hotel_tb, 'id' , 'hotel_id')
            ->join($reservation_hotel_room_tb, 'id_room' , 'room_id')
            ->where($book_hotel_tb.'.hotel_id' , $params['hotel_id'])
            ->where($book_hotel_tb . '.status', 'PreReserve' , '!=');
            if(!empty($params['date_type']) && (!empty($params['startDate']) || !empty($params['endDate']))){
                if($params['startDate']){
                    $date_of     = explode( '-', $params['startDate'] );
                    $date_of_int = dateTimeSetting::jmktime( 0, 0, 0, $date_of[1], $date_of[2], $date_of[0] );
                }

                if($params['endDate']){
                    $date_to     = explode( '-', $params['endDate'] );
                    $date_to_int = dateTimeSetting::jmktime( 23, 59, 59, $date_to[1], $date_to[2], $date_to[0] );
                }

                if($params['date_type'] == 'start'){
                    if($params['startDate']) {
                        $reserve_list = $reserve_list->where($book_hotel_tb.'.start_date' , $params['startDate'] , '>=');
                    }
                    if($params['endDate']){
                        $reserve_list = $reserve_list->where($book_hotel_tb.'.start_date' , $params['startDate'] , '<=');
                    }
                }else if($params['date_type'] == 'end') {
                    if($params['startDate']) {
                        $reserve_list = $reserve_list->where($book_hotel_tb.'.end_date' , $params['endDate'] , '>=');
                    }
                    if($params['endDate']){
                        $reserve_list = $reserve_list->where($book_hotel_tb.'.end_date' , $params['endDate'] , '<=');
                    }
                }else if($params['date_type'] == 'reserve') {
                    if($params['startDate']) {
                        $reserve_list = $reserve_list->where($book_hotel_tb.'.creation_date_int' , $date_of_int , '>=');
                    }
                    if($params['endDate']){
                        $reserve_list = $reserve_list->where($book_hotel_tb.'.creation_date_int' , $date_to_int , '<=');
                    }

                }
            }
            if(!empty($params['factorNumber'])) {
                $reserve_list = $reserve_list->where($book_hotel_tb.'.factor_number' , $params['factorNumber']);
            }
            if(!empty($params['statusGroup'])) {
                $reserve_list = $reserve_list->where($book_hotel_tb . '.status', $params['statusGroup']);
            }else{
                $reserve_list = $reserve_list->where($book_hotel_tb . '.status', 'BookedSuccessfully');
            }
            if(!empty($params['passengerName'])) {
                $requested_passenger =$params['passengerName'];
                $reserve_list = $reserve_list->openParentheses();
                $reserve_list = $reserve_list->like($book_hotel_tb . '.passenger_name', $params['passengerName']);
                $reserve_list = $reserve_list->like($book_hotel_tb . '.passenger_name_en', $params['passengerName']);
                $reserve_list = $reserve_list->like($book_hotel_tb . '.passenger_family', $params['passengerName']);
                $reserve_list = $reserve_list->like($book_hotel_tb . '.passenger_leader_room_fullName', $params['passengerName']);
                $reserve_list = $reserve_list->like($book_hotel_tb . '.passenger_family_en', $params['passengerName']);
                $reserve_list = $reserve_list->closeParentheses();

            }
        $reserve_list = $reserve_list->where($reservation_hotel_tb.'.is_del' , 'no')
            ->where($reservation_hotel_room_tb.'.is_del' , 'no')
            ->groupBy($book_hotel_tb.'.factor_number')
            ->orderBy($book_hotel_tb.'.creation_date_int' , 'desc')
            ->all();
        $result = [] ; 
        foreach ($reserve_list as $hotel) {
            $result[] = [
                'book_id'     => $hotel['id'],
                'factor_number'     => $hotel['factor_number'],
                'passenger_name'     => $hotel['passenger_leader_room_fullName'],
                'passenger_name_en'     => $hotel['passenger_name_en'] .' '.$hotel['passenger_family_en'],
                'room'     => $hotel['room_name'],
                'start_date'     => $hotel['start_date'],
                'end_date'     => $hotel['end_date'],
                'updated_at'     => dateTimeSetting::jdate( 'Y-m-d', $hotel['creation_date_int'] ),
                'status_main'     => $hotel['status'],
                'status'     => $this->getStatus($hotel['status']),
                'status_color'  => $this->getStatusColor($hotel['status']),
                'serviceTitle'     => $hotel['serviceTitle']== 'PrivateLocalHotel' ?'رزرو داخلی': 'رزرو خارجی',
            ];
        }
        return functions::toJson($result);
    }

    public function getUserReservationHotelBookDetail($params) {
        $reservation_hotel_tb = $this->getModel('reservationHotelModel')->getTable();
        $book_hotel_tb = $this->getModel('bookHotelLocalModel')->getTable();
        $reservation_hotel_room_tb = $this->getModel('reservationHotelRoomModel')->getTable();

        $reserve_info =  $this->getModel('bookHotelLocalModel')
            ->get('*')
            ->join($reservation_hotel_tb, 'id' , 'hotel_id')
            ->join($reservation_hotel_room_tb, 'id_room' , 'room_id')
            ->where($book_hotel_tb.'.hotel_id' , $params['hotel_id'])
            ->where($book_hotel_tb.'.factor_number' , $params['factor_number'])
            ->where($reservation_hotel_tb.'.is_del' , 'no')
            ->where($reservation_hotel_room_tb.'.is_del' , 'no')
            ->all();
        $first_book = $reserve_info[0] ;

        $start_date = explode('-' , $first_book['start_date']);
        $time_date = dateTimeSetting::jmktime( 0, 0, 0, $start_date[1], $start_date[2], $start_date[0] );
        $start_date = dateTimeSetting::jdate( "l, j F Y", $time_date );
        $end_date = explode('-' , $first_book['end_date']);
        $time_date = dateTimeSetting::jmktime( 0, 0, 0, $end_date[1], $end_date[2], $end_date[0] );
        $end_date = dateTimeSetting::jdate( "l, j F Y", $time_date );
        $result = [
            'reservationDate'  => dateTimeSetting::jdate( 'Y-m-d (H:i:s)', $first_book['creation_date_int'] ),
            'startDate'  => $start_date,
            'endDate'    => $end_date,
            'night_count'    => $first_book['number_night'],
            'status_main'     => $first_book['status'],
            'status'     => $this->getStatus($first_book['status']),
            'leader'     => $first_book['passenger_leader_room_fullName'],
            'factor_number'     => $first_book['factor_number'],
            'leader_name'     => $first_book['passenger_leader_room_fullName'],
            'pnr'      => $first_book['pnr'],
            'voucher_link'     => ROOT_ADDRESS . "/pdf&target=BookingHotelLocal&id=" . $first_book['factor_number'],
        ];
        $book_list = [] ;
        foreach ($reserve_info as $hotel) {
            $book_list[] = [
                'roomId'         => $hotel['room_id'],
                'promotionInfo'  => '',
                'basePrice'      => number_format($hotel['room_price']),
                'roomTitle'      => $hotel['room_name'],

                'ratePlanId'     => '',
                'childCount'     => $hotel['child_count'],
                'extra_bed_count'  => $hotel['extra_bed_count'],
                'first_name'    => $hotel['passenger_name'],
                'last_name'    => $hotel['passenger_family'],
                'national_code'    => $hotel['passenger_national_code'],
            ];

        }
        $result['book_list']  = $book_list;
        return functions::toJson($result);
    }

    private function getStatus($status) {
        switch ($status){
            case 'Cancelled' :
                return functions::Xmlinformation( 'Canceled' )->__toString() ;
            case 'PreReserve' :
                return functions::Xmlinformation( 'TemporaryPreReserve' )->__toString() ;
            case 'bank' :
                return functions::Xmlinformation( 'NavigateToPort' )->__toString() ;
            case 'credit' :
                return functions::Xmlinformation( 'Paycredit' )->__toString() ;
            case 'BookedSuccessfully' :
                return functions::Xmlinformation( 'Definitivereservation' )->__toString() ;
            case 'OnRequest' :
                return functions::Xmlinformation( 'OnRequestedHotel' )->__toString() ;
            case 'pending' :
                return functions::Xmlinformation( 'pendingPrintFlight' )->__toString() ;
            case 'NoReserve' :
                return functions::Xmlinformation( 'reserveError' )->__toString() ;
            default :
                return functions::Xmlinformation( 'Unknown' )->__toString() ;

        }
    }
    private function getInvoiceStatus($status) {
        switch ($status){
            case 'canNotBeRequested' :
                return 'غیر قابل درخواست' ;
            case 'waiting' :
                return 'در انتظار پرداخت' ;
            case 'payed' :
                return 'پرداخت شده' ;
            case 'receivable' :
                return 'قابل دریافت' ;
        }
    }
    private function getInvoiceColor($status) {
        switch ($status){
            case 'canNotBeRequested' :
                return 'black' ;
            case 'waiting' :
                return 'black' ;
            case 'payed' :
                return 'green' ;
            case 'receivable' :
                return 'red' ;
        }
    }
    private function getStatusColor($status) {
        switch ($status){
            case 'Cancelled' :
            case 'NoReserve' :
                return '#cb170f' ;
            case 'PreReserve' :
                return '#ff7800' ;
            case 'bank' :
            case 'credit' :
                return 'blue' ;
            case 'BookedSuccessfully' :
                return 'green' ;
            case 'OnRequest' :
                return 'orange' ;
            case 'pending' :
                return 'book' ;

        }
    }

    public function getWeekData($params) {
        $is_date_saturday = true ;
        if(!empty($params['start_date']) && isset($params['selected_calender']) && $params['selected_calender'] ){
            $params['start_date'] = functions::convertToMiladi($params['start_date']) ;

            $dateToCheck = new DateTime($params['start_date']);

            if ($dateToCheck->format('N') != 6) {
                $saturday = clone $dateToCheck;
                $dayOfWeek = $saturday->format('N');

                if ($dayOfWeek >= 6) {

                    // If today is after Saturday, find the previous Saturday
                    $daysUntilSaturday = $dayOfWeek - 6;
                } else {
                    // If today is before Saturday, move to the previous week's Saturday
                    $daysUntilSaturday = 6 - $dayOfWeek - 7;
                }
                if($daysUntilSaturday == 1) {
                    $daysUntilSaturday = -1;
                }
                $saturday->modify("$daysUntilSaturday days");
                $params['start_date'] = $saturday->format('Y-m-d') ;

            }
        }

        if( date('l') != 'Saturday') {
            $is_date_saturday  = false ;
        }
        if(empty($params['start_date']) && $is_date_saturday){
            $today = new DateTime();
            $params['start_date'] = $today->format('Y-m-d');
        }

        if(empty($params['start_date']) ){
        
            $today = new DateTime();
            $today->modify('last Saturday');

//            $currentDayOfWeek = $today->format('w');
//
//            $daysUntilSaturday = (6 - $currentDayOfWeek + 7) % 7;
//
//            $saturday = clone $today;
//            $saturday =  $saturday->modify("+$daysUntilSaturday days")->format('Y-m-d');
            $params['start_date'] = $today->format('Y-m-d');
        }

        $date_list = $this->getEachWeekDate($params);
        $room_list_each_Week = $this->getEachWeekRooms($params) ;

        return functions::returnJsonResult(true, 'دریافت اطلاعات موفقیت آمیز بود.',
            ['date_list' => $date_list , 'room_list' =>  $room_list_each_Week]
            , 200);
    }
    
    private function getEachWeekDate($params) {
        $daysOfWeek = ['شنبه', 'یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'];
        $toady = new DateTime() ;
        $date_list = [] ;
        $month_list = [] ;
        $year_list = [] ;
        $day_list = [] ;

        $has_active = false ;


        for ($i = 0; $i < 7; $i++) {
            $active = false ;
            $gregorianDate = new DateTime($params['start_date']);

            $currentDate = $gregorianDate->modify('+'.$i.' day')->format('Y-m-d');
            if($toady->format('Y-m-d') ==  $currentDate) {
                $active = true ;
                $has_active = true ;
            }

            $day_date = functions::convertToJalali($currentDate) ;
            $day_date_separate = explode('-' , $day_date);
            $time_date = functions::ConvertToDateJalaliInt($currentDate);
            $month_date = dateTimeSetting::jdate("F Y", $time_date);
            $weekday = $daysOfWeek[$i];
            if(!in_array($month_date , $month_list)) {
                $month_list[]  = $month_date ;
            }
            if(!in_array($day_date_separate[0] , $year_list)) {
                $year_list[]  = $day_date_separate[0] ;
            }
            $day_list[] = [
                'day'         => $day_date_separate[2],
                'weekday'     => $weekday,
                'date'        => $day_date,
                'active'      => $active
            ];

        }
        $date_list['month_list'] = $month_list ;
        $date_list['year_list'] = $year_list ;
        $date_list['day_list'] = $day_list ;
        $date_list['next_start_date'] = $gregorianDate->modify('+1 day')->format('Y-m-d');
        $date_list['previous_start_date_enable'] = true;
        if($has_active){
            $date_list['previous_start_date_enable'] = false;
        }


        $date_list['previous_start_date'] = $gregorianDate->modify('-14 day')->format('Y-m-d');
        return $date_list ;
    }

    private function getEachWeekRooms($params) {

        $reservation_hotel_room_price_tb = $this->getModel('reservationHotelRoomPricesModel')->getTable();
        $reservation_hotel_room_tb = $this->getModel('reservationHotelRoomModel')->getTable();

        if(!empty($params['start_date']) && isset($params['selected_calender']) && $params['selected_calender'] ) {
            $params['start_date'] = functions::convertToMiladi($params['start_date']);
        }

        $gregorianDate = new DateTime($params['start_date']);
        $today = new DateTime();
        $friday_date = $gregorianDate->modify('+6 day')->format('Y-m-d');

        $start_date = str_replace('-' , '' , functions::convertToJalali($params['start_date']));
        $end_date = str_replace('-' , '' ,functions::convertToJalali($friday_date)) ;
        $today = str_replace('-' , '' ,functions::convertToJalali($today->format('Y-m-d'))) ;

        $weekly_date[] = $start_date;
        for ($i = 1 ; $i <= 6 ; $i++){
            $gregorianDate = new DateTime($params['start_date']);
            $next_date = $gregorianDate->modify('+'.$i.' day')->format('Y-m-d');
            $weekly_date[$i] = str_replace('-' , '' ,functions::convertToJalali($next_date));
        }
        $room_list =  $this->getModel('reservationHotelRoomModel')
            ->get('*')
            ->where($reservation_hotel_room_tb.'.id_hotel' , $params['hotel_id'])
            ->where($reservation_hotel_room_tb.'.is_del' , 'no')
            ->all();

        $result = [] ;
        foreach ($room_list as $key => $room) {
            $result[$key] = $room;
            $room_price_list  = $this->getModel('reservationHotelRoomPricesModel')
                ->get([
                    '*'
                ])
                ->join($reservation_hotel_room_tb , 'id_room'  , 'id_room')
                ->where($reservation_hotel_room_price_tb.'.id_hotel' , $params['hotel_id'])
                ->where($reservation_hotel_room_price_tb.'.id_room' , $room['id_room'])
                ->where($reservation_hotel_room_price_tb.'.user_type' , '2')
                ->where($reservation_hotel_room_tb.'.is_del' , 'no')
                ->where($reservation_hotel_room_price_tb.'.date' , $start_date , '>=')
                ->where($reservation_hotel_room_price_tb.'.date' , $end_date , '<=');

            $room_price_list = $room_price_list->where($reservation_hotel_room_price_tb.'.is_del' , 'no');

            $room_price_list = $room_price_list->all();

            foreach($weekly_date as $week_date) {

                $is_past = false  ;
                if($week_date < $today){
                    $is_past = true;
                }
                $maxCompetitivePrice = 0 ;
                $sellPrice = 0 ;
                $childPrice = 0 ;
                $extraBedPrice = 0 ;
                $boardPrice = 0;
                $total_rooms = 0;
                $availableRooms = 0;
                $discount = 0 ;

                foreach($room_price_list as $room) {

                    if($week_date == $room['date']) {
                        if($room['flat_type'] == 'DBL'){
                            $sellPrice = $room['online_price'] ;
                            $boardPrice = $room['board_price'];
                            $total_rooms = $room['maximum_capacity'] ;
                            $availableRooms = $room['remaining_capacity'];
                            if($room['discount_status'] == '1') {
                                $discount = $room['discount'];
                            }
                        }else if($room['flat_type'] == 'CHD'){
                            $childPrice = $room['online_price'];
                        }else if($room['flat_type'] == 'EXT'){
                            $extraBedPrice = $room['online_price'] ;
                        }
                    }
                }

                $result[$key]['weekly_info'][] =[
                    'is_past'           =>$is_past ,
                    'date'           =>$week_date ,
                    'maxCompetitivePrice' => $maxCompetitivePrice ,
                    "sellPrice"  =>  $sellPrice,
                    "childPrice" =>  $childPrice,
                    "extraBedPrice" =>$extraBedPrice,
                    "boardPrice" =>  $boardPrice,
                    "bookedRooms" =>  $total_rooms - $availableRooms,
                    "availableRooms"=> $availableRooms,
                    "discount"=> $discount
                ];
            }
        }
        return $result ;
    }

    public function updateRoomPriceData($params) {


        $reservationHotelPriceModel = $this->getModel('reservationHotelRoomPricesModel');
        $reservationHotelRoomModel = $this->getModel('reservationHotelRoomModel');
        $objController = Load::controller('reservationPublicFunctions');

        $user_types = [
            1, 2, 3, 4, 5
        ];
        $flat_type = [
            'DBL' , 'EXT' , 'CHD'
        ];

        //find the dates should be updated
        $start_date =  $params['from_date'];
        $end_date   =  $params['end_date'];
        $hotel  = $this->getHotelById($params['hotel_id']);
        if(!empty($params['weekDays']) && count($params['weekDays']) > 0 ) {
            $requested_weekdays = $params['weekDays'] ;
            $start_date = functions::convertToMiladi($start_date) ;
            $start_date = new DateTime($start_date) ;
            $end_date   = functions::convertToMiladi($end_date) ;
            $end_date = new DateTime($end_date) ;
            $interval = new DateInterval('P1D');
            $period = new DatePeriod($start_date, $interval, $end_date);
            $selected_date = [] ;
            foreach ($period as $date) {
                foreach ($requested_weekdays as $week) {
                    if($week == 'Saturday' && $date->format('N') == 6
                    || $week == 'Sunday' && $date->format('N') == 7
                    || $week == 'Monday' && $date->format('N') == 1
                    || $week == 'Tuesday' && $date->format('N') == 2
                    || $week == 'Wednesday' && $date->format('N') == 3
                    || $week == 'Thursday' && $date->format('N') == 4
                    || $week == 'Friday' && $date->format('N') == 5) {
                        $selected = $date->format('Y-m-d');
                        $selected_date_array[] = str_replace('-' , '' , functions::ConvertToJalali($selected));

                    }
                }
            }

            $selected_date = array_map(function($item) {
                return "'" . $item . "'";
            }, $selected_date_array);

            $selected_date = implode(',', $selected_date);
        }
        else if(!empty($params['days']) && count($params['days']) > 0){
            $selected_date_array = [];
            foreach ($params['days'] as $day) {
                $selected_date_array[] = str_replace('-' , '' , $day);
            }

            $selected_date = array_map(function($item) {
                return "'" . $item . "'";
            }, $selected_date_array);

            $selected_date = implode(',', $selected_date);

        }
        else{
            $start_date = str_replace('-' , '' , $start_date);
            $end_date = str_replace('-' , '' , $end_date);
        }




        //which data is going to update
        $is_same = $this->GetIdSame();
        $rooms = $reservationHotelRoomModel->get(['*'])
            ->where('id_hotel' , $params['hotel_id'])
            ->whereIn('id' , $params['rooms_selected'])
            ->all();
        $room_selected_array = [] ;
        foreach($rooms as $room) {
            $room_selected_array[] = $room['id_room'] ;
        }
        $room_selected = array_map(function($item) {
            return "'" . $item . "'";
        }, $room_selected_array);

        $room_selected = implode(',', $room_selected);


        if(count($params['weekDays']) == 0  && count($params['days']) == 0 ) {
            $change_dates = $this->setLogDate([
                'type'          => 'period' ,
                'start_date'    =>  $start_date ,
                'end_date'      =>  $end_date
            ]) ;

            $conditions = "id_hotel={$params['hotel_id']} and date >= {$start_date} and date <={$end_date} and id_room In({$room_selected})";
            $reset_start_date = $start_date;
            foreach ($room_selected_array as $room) {

                    while ($start_date <= $end_date) {
                        foreach( $user_types as $user) {
                            foreach( $flat_type as $flat) {
                                $if_exist = $reservationHotelPriceModel->get(['*'])
                                    ->where('id_hotel' , $params['hotel_id'])
                                    ->where('flat_type' , $flat)
                                    ->where('date' , $start_date )
                                    ->where('user_type' , $user )
                                    ->where('id_room' , $room)->find() ;
                                if(!$if_exist) {
                                    $data_insert = [
                                        'id_same'       => $is_same,
                                        'id_country'    => $hotel['country'] ,
                                        'id_city'       => $hotel['city']  ,
                                        'id_region'     => $hotel['region']  ,
                                        'id_hotel'      => $params['hotel_id']  ,
                                        'id_room'       => $room  ,
                                        'user_type'     => $user  ,
                                        'date'          => $start_date  ,
                                        'flat_type'     => $flat  ,
                                        'breakfast'     => "no",
                                        'lunch'         => "no",
                                        'dinner'        => "no",
                                        'is_del'        => "no",
                                        'guest_user_status'   => "no",
                                        'discount_status'     => 1,
                                        'discount'      => 0,
                                        'board_price'      => 0,
                                        'online_price'      => 0,
                                        'currency_price'      => 0,
                                        'total_capacity'      => 0,
                                        'maximum_capacity'      => 0,
                                        'remaining_capacity'      => 0,
                                        'com_gharardad_coWorker'      => 0,
                                        'com_gharardad_passenger'      => 0,
                                        'sell_for_night'      => '1/2/3/4/5/6/7/8/9/10/11/12/13/14/15',
                                        'flag_dbl'      => 0,
                                        'fromAge'      => 0,
                                        'toAge'      => 0,
                                    ];

                                    $result = $reservationHotelPriceModel->insertLocal($data_insert);

                                }
                            }
                        }
                        $start_date = $objController->dateNextFewDays($start_date, ' + 1');
                    }
                $start_date = $reset_start_date ;
            }
            $old_data = $reservationHotelPriceModel->get(['*']);
            $old_data = $old_data->where('id_hotel' , $params['hotel_id'])
                ->where('date' , $start_date , '>=')
                ->where('date' , $start_date , '<=')
                ->whereIn('id_room' ,$room_selected_array);
        }
        else{
            $change_dates = $this->setLogDate([
                'type'          => 'multiple' ,
                'date_list'    =>  $selected_date_array
            ]) ;

            $conditions = "id_hotel={$params['hotel_id']}  and date In({$selected_date})";
            foreach ($room_selected_array as $room) {
                foreach ($selected_date_array as $date) {
                    foreach( $user_types as $user) {
                        foreach( $flat_type as $flat) {
                            $if_exist = $reservationHotelPriceModel->get(['*'])
                                ->where('id_hotel' , $params['hotel_id'])
                                ->where('flat_type' , $flat)
                                ->where('date' , $date )
                                ->where('user_type' , $user )
                                ->where('id_room' , $room)->find() ;
                            if(!$if_exist) {
                                $data_insert = [
                                    'id_same'       => $is_same,
                                    'id_country'    => $hotel['country'] ,
                                    'id_city'       => $hotel['city']  ,
                                    'id_region'     => $hotel['region']  ,
                                    'id_hotel'      => $params['hotel_id']  ,
                                    'id_room'       => $room  ,
                                    'user_type'     => $user  ,
                                    'date'          => $date  ,
                                    'flat_type'     => $flat  ,
                                    'breakfast'     => "no",
                                    'lunch'         => "no",
                                    'dinner'        => "no",
                                    'is_del'        => "no",
                                    'guest_user_status'   => "no",
                                    'discount_status'     => 1,
                                    'discount'      => 0,
                                    'board_price'      => 0,
                                    'online_price'      => 0,
                                    'currency_price'      => 0,
                                    'total_capacity'      => 0,
                                    'maximum_capacity'      => 0,
                                    'remaining_capacity'      => 0,
                                    'com_gharardad_coWorker'      => 0,
                                    'com_gharardad_passenger'      => 0,
                                    'sell_for_night'      => '1/2/3/4/5/6/7/8/9/10/11/12/13/14/15',
                                    'flag_dbl'      => 0,
                                    'fromAge'      => 0,
                                    'toAge'      => 0,
                                ];

                                $result = $reservationHotelPriceModel->insertLocal($data_insert);

                            }
                        }
                    }

                }

            }
            $old_data = $reservationHotelPriceModel->get(['*']);
            $old_data = $old_data->where('id_hotel' , $params['hotel_id'])
                ->whereIn('date' ,$selected_date_array)
                ->whereIn('id_room' ,$room_selected_array);
        }
        $result_old_data = [];
        if($params['change_type'] == 'available') {
            $data_update = [
                "total_capacity"  =>  $params['change_data'],
                "maximum_capacity"  =>  $params['change_data'],
                "remaining_capacity"  =>  $params['change_data'],
            ];

            $result_old = $old_data->where('flat_type' ,'DBL')->groupBy('id_room')->all();

             foreach ($result_old as $old_datum) {
                 $result_old_data[$old_datum['id_room']] = $old_datum['maximum_capacity'];
             }
            $result = $reservationHotelPriceModel->update($data_update, $conditions." and id_room In({$room_selected}) and flat_type = 'DBL'");
        }else if($params['change_type'] == 'child_price'){
            $data_update = [
                "online_price"  =>  $params['change_data']
            ];
            $old_data = $old_data->where('flat_type' ,'CHD' )->groupBy('id_room')->all();

            foreach ($old_data as $old_datum) {
                $result_old_data[$old_datum['id_room']] = $old_datum['online_price'];
            }
            $result = $reservationHotelPriceModel->update($data_update, $conditions." and id_room In({$room_selected}) and flat_type = 'CHD'");
        }else if($params['change_type'] == 'extra_bed_price'){
            $data_update = [
                "online_price"  =>  $params['change_data']
            ];
            $old_data = $old_data->where('flat_type' ,'EXT' )->groupBy('id_room')->all();


            foreach ($old_data as $old_datum) {
                $result_old_data[$old_datum['id_room']] = $old_datum['online_price'];
            }
            $result = $reservationHotelPriceModel->update($data_update, $conditions." and id_room In({$room_selected}) and flat_type = 'EXT'");
        }else if($params['change_type'] == 'adult_price'){
            $old_data = $old_data->where('flat_type' ,'DBL' )->groupBy('id_room')->all();

            foreach ($old_data as $old_datum) {
                if($old_datum['discount'] != 0 ){
                    $discount = $old_datum['discount'];
                    $board_price = $params['change_data'];
                    $discount_price = ($discount * $params['change_data']) / 100;
                    $online_price = $board_price - $discount_price;
                    $data_update = [
                        "online_price"  =>  $online_price,
                        "board_price"  =>   $board_price
                    ];
                }else{
                    $data_update = [
                        "online_price"  =>  $params['change_data'],
                        "board_price"  =>  $params['change_data']
                    ];
                }

                $result = $reservationHotelPriceModel->update($data_update, $conditions."and id_room = {$old_datum['id_room']} and flat_type = 'DBL'");
            }



            foreach ($old_data as $old_datum) {
                $result_old_data[$old_datum['id_room']] = $old_datum['online_price'];
            }

        }else if($params['change_type'] == 'discount'){
            $old_data = $old_data->where('flat_type' ,'DBL' )->groupBy('id_room')->all();

            foreach ($old_data as $old_datum) {

                if($old_datum['online_price']) {

                    $discount_price = ($params['change_data'] * $old_datum['board_price']) / 100;
                    $online_price = $old_datum['board_price'] - $discount_price;
                    $data_update = [
                        "online_price"      =>  $online_price,
                        "discount"          =>  $params['change_data'],
                        "discount_status"   =>  1
                    ];
                }else{
                    $data_update = [
                        "discount"          =>  $params['change_data'],
                        "discount_status"   =>  1
                    ];
                }

                $result = $reservationHotelPriceModel->update($data_update, $conditions."and id_room = {$old_datum['id_room']} and flat_type = 'DBL'");
            }


            foreach ($old_data as $old_datum) {
                $result_old_data[$old_datum['id_room']] = $old_datum['discount'];
            }
        }


        if ($result) {

            foreach($rooms as $key => $room) {

              if($result_old_data[$room['id_room']]) {
                  $log_params = [
                      'type'           => 'market_place_reservation_hotel' ,
                      'id'             => $params['hotel_id'] ,
                      'change_type'    => $this->setChangeType($params['change_type'])  ,
                      'change_type_en' => $params['change_type']  ,
                      'room'           => $room['room_name']  ,
                      'dates'          => $change_dates ,
                      'new'            => $params['change_data'] ,
                      'old'            => $result_old_data[$room['id_room']] ,
                  ];
                  $this->activity_log_controller->log($log_params);
              }

            }


            return functions::JsonSuccess([], 'درخواست با موفقیت انجام شد');
        }
        return functions::JsonError([], 'خطا در ثبت درخواست', 200);
    }

    private function setChangeType($type) {
        switch ($type) {
            case 'available'  :
                return 'موجودی نرمال' ;
            case 'child_price'  :
                return 'قیمت تخت کودک' ;
            case 'extra_bed_price'  :
                return 'قیمت تخت اضافه' ;
            case 'adult_price'  :
                return 'قیمت نرمال' ;
            case 'discount'  :
                return 'تخفیف' ;
        }
    }
    private function setLogDate($params) {
        if($params['type'] == 'period') {

            if($params['start_date'] == $params['end_date']) {
                return  $this->changeDateFormat($params['start_date']);
            }else{

                return $this->changeDateFormat($params['start_date']). ' تا ' . $this->changeDateFormat($params['end_date']) ;
            }
        }else {
            $date_result = [] ;

            foreach ($params['date_list'] as $date) {
                $date_result[] = $this->changeDateFormat($date);

            }
            if(count($date_result) == 1) {
                return $date_result[0] ;
            }else{
                return  implode(',' ,$date_result );
            }

        }
    }
    private function changeDateFormat($date) {

        $year = substr($date, 0, 4);
        $month = substr($date, 4, 2);
        $day = substr($date, 6, 2);
        return  $year.'/'.$month.'/'.$day ;

    }

    public function getHotelFinancialList($params) {
        $reservation_hotel_tb = $this->getModel('reservationHotelModel')->getTable();
        $book_hotel_tb = $this->getModel('bookHotelLocalModel')->getTable();
        $reservation_hotel_room_tb = $this->getModel('reservationHotelRoomModel')->getTable();

        $reserve_list =  $this->getModel('bookHotelLocalModel')
            ->get('*')
            ->join($reservation_hotel_tb, 'id' , 'hotel_id')
            ->join($reservation_hotel_room_tb, 'id_room' , 'room_id')
            ->where($book_hotel_tb.'.hotel_id' , $params['hotel_id']);
        if(!empty($params['date_type']) && (!empty($params['startDate']) || !empty($params['endDate']))){
            if($params['startDate']){
                $date_of     = explode( '-', $params['startDate'] );
                $date_of_int = dateTimeSetting::jmktime( 0, 0, 0, $date_of[1], $date_of[2], $date_of[0] );
            }

            if($params['endDate']){
                $date_to     = explode( '-', $params['endDate'] );
                $date_to_int = dateTimeSetting::jmktime( 23, 59, 59, $date_to[1], $date_to[2], $date_to[0] );
            }

            if($params['date_type'] == 'start'){
                if($params['startDate']) {
                    $reserve_list = $reserve_list->where($book_hotel_tb.'.start_date' , $params['startDate'] , '>=');
                }
                if($params['endDate']){
                    $reserve_list = $reserve_list->where($book_hotel_tb.'.start_date' , $params['startDate'] , '<=');
                }
            }else if($params['date_type'] == 'end') {
                if($params['startDate']) {
                    $reserve_list = $reserve_list->where($book_hotel_tb.'.end_date' , $params['endDate'] , '>=');
                }
                if($params['endDate']){
                    $reserve_list = $reserve_list->where($book_hotel_tb.'.end_date' , $params['endDate'] , '<=');
                }
            }else if($params['date_type'] == 'reserve') {
                if($params['startDate']) {
                    $reserve_list = $reserve_list->where($book_hotel_tb.'.creation_date_int' , $date_of_int , '>=');
                }
                if($params['endDate']){
                    $reserve_list = $reserve_list->where($book_hotel_tb.'.creation_date_int' , $date_to_int , '<=');
                }

            }
        }
        if(!empty($params['factorNumber'])) {
            $reserve_list = $reserve_list->where($book_hotel_tb.'.factor_number' , $params['factorNumber']);
        }
        if(!empty($params['statusGroup'])) {
            $reserve_list = $reserve_list->where($book_hotel_tb . '.status', $params['statusGroup']);
        }
        if(!empty($params['passengerName'])) {
            $requested_passenger =$params['passengerName'];
            $reserve_list = $reserve_list->openParentheses();
            $reserve_list = $reserve_list->like($book_hotel_tb . '.passenger_name', $params['passengerName']);
            $reserve_list = $reserve_list->like($book_hotel_tb . '.passenger_name_en', $params['passengerName']);
            $reserve_list = $reserve_list->like($book_hotel_tb . '.passenger_family', $params['passengerName']);
            $reserve_list = $reserve_list->like($book_hotel_tb . '.passenger_leader_room_fullName', $params['passengerName']);
            $reserve_list = $reserve_list->like($book_hotel_tb . '.passenger_family_en', $params['passengerName']);
            $reserve_list = $reserve_list->closeParentheses();

        }
        $reserve_list = $reserve_list->where($reservation_hotel_tb.'.is_del' , 'no')
            ->where($reservation_hotel_room_tb.'.is_del' , 'no')
            ->groupBy($book_hotel_tb.'.factor_number')
            ->orderBy($book_hotel_tb.'.creation_date_int')
            ->all();
        $result = [] ;
        foreach ($reserve_list as $hotel) {
            $result[] = [
                'book_id'     => $hotel['id'],
                'factor_number'     => $hotel['factor_number'],
                'passenger_name'     => $hotel['passenger_leader_room_fullName'],
                'passenger_name_en'     => $hotel['passenger_name_en'] .' '.$hotel['passenger_family_en'],
                'room'     => $hotel['room_name'],
                'start_date'     => $hotel['start_date'],
                'end_date'     => $hotel['end_date'],
                'updated_at'     => $hotel['creation_date_int'],
                'status'     => $this->getStatus($hotel['status']),
                'status_color'  => $this->getStatusColor($hotel['status']),
                'serviceTitle'     => $hotel['serviceTitle']== 'PrivateLocalHotel' ?'رزرو داخلی': 'رزرو خارجی',
            ];
        }
        return functions::toJson($result);
    }


    public function getAllUserReservationHotels() {
        $reservation_city_tb = $this->getModel('reservationCityModel')->getTable();
        $reservation_hotel_tb = $this->getModel('reservationHotelModel')->getTable();
        return $this->getModel('reservationHotelModel')
            ->get(['*' , $reservation_city_tb .'.name as city_name' , $reservation_city_tb .'.name_en as city_name_en'])
            ->join($reservation_city_tb , 'id'  , 'city')
            ->where($reservation_hotel_tb.'.city' , 0 , '!=')
            ->where($reservation_hotel_tb.'.country' , 0 , '!=')
            ->WhereNotNull($reservation_hotel_tb.'.user_id')
            ->where('is_show' , 'yes' )
            ->orderBy('id' , 'DESC')->all();
    }

    public function getHotelFinancialReport($params){
        $invoice_controller  = $this->getController('invoice');
        $reservation_hotel_tb = $this->getModel('reservationHotelModel')->getTable();
        $book_hotel_tb = $this->getModel('bookHotelLocalModel')->getTable();
        $reservation_hotel_room_tb = $this->getModel('reservationHotelRoomModel')->getTable();


        $reserve_list =  $this->getModel('bookHotelLocalModel')
            ->get('*')
            ->join($reservation_hotel_tb, 'id' , 'hotel_id')
            ->join($reservation_hotel_room_tb, 'id_room' , 'room_id')
            ->where($book_hotel_tb.'.hotel_id' , $params['hotel_id'])
            ->where($book_hotel_tb.'.status' , 'BookedSuccessfully');
        if(!empty($params['date_type']) && (!empty($params['startDate']) || !empty($params['endDate']))){
            if($params['startDate']){
                $date_of     = explode( '-', $params['startDate'] );
                $date_of_int = dateTimeSetting::jmktime( 0, 0, 0, $date_of[1], $date_of[2], $date_of[0] );
            }

            if($params['endDate']){
                $date_to     = explode( '-', $params['endDate'] );
                $date_to_int = dateTimeSetting::jmktime( 23, 59, 59, $date_to[1], $date_to[2], $date_to[0] );
            }

            if($params['date_type'] == 'start'){
                if($params['startDate']) {
                    $reserve_list = $reserve_list->where($book_hotel_tb.'.start_date' , $params['startDate'] , '>=');
                }
                if($params['endDate']){
                    $reserve_list = $reserve_list->where($book_hotel_tb.'.start_date' , $params['startDate'] , '<=');
                }
            }else if($params['date_type'] == 'end') {
                if($params['startDate']) {
                    $reserve_list = $reserve_list->where($book_hotel_tb.'.end_date' , $params['endDate'] , '>=');
                }
                if($params['endDate']){
                    $reserve_list = $reserve_list->where($book_hotel_tb.'.end_date' , $params['endDate'] , '<=');
                }
            }else if($params['date_type'] == 'reserve') {
                if($params['startDate']) {
                    $reserve_list = $reserve_list->where($book_hotel_tb.'.creation_date_int' , $date_of_int , '>=');
                }
                if($params['endDate']){
                    $reserve_list = $reserve_list->where($book_hotel_tb.'.creation_date_int' , $date_to_int , '<=');
                }

            }
        }
        if(!empty($params['factorNumber'])) {
            $reserve_list = $reserve_list->where($book_hotel_tb.'.factor_number' , $params['factorNumber']);
        }

        if(!empty($params['passengerName'])) {
            $requested_passenger =$params['passengerName'];
            $reserve_list = $reserve_list->openParentheses();
            $reserve_list = $reserve_list->like($book_hotel_tb . '.passenger_name', $params['passengerName']);
            $reserve_list = $reserve_list->like($book_hotel_tb . '.passenger_name_en', $params['passengerName']);
            $reserve_list = $reserve_list->like($book_hotel_tb . '.passenger_family', $params['passengerName']);
            $reserve_list = $reserve_list->like($book_hotel_tb . '.passenger_leader_room_fullName', $params['passengerName']);
            $reserve_list = $reserve_list->like($book_hotel_tb . '.passenger_family_en', $params['passengerName']);
            $reserve_list = $reserve_list->closeParentheses();

        }
        $reserve_list = $reserve_list->where($reservation_hotel_tb.'.is_del' , 'no')
            ->where($reservation_hotel_room_tb.'.is_del' , 'no')
            ->groupBy($book_hotel_tb.'.factor_number')
            ->orderBy($book_hotel_tb.'.creation_date_int')
            ->all();
        $result = [] ;
        foreach ($reserve_list as $hotel) {
            $invoice = $this->getHotelInvoice($hotel);
            $reserve_list_info =  $this->getModel('bookHotelLocalModel')
                ->get('*')->where('factor_number' , $hotel['factor_number'])->all() ;
            $market_hotel_price = 0 ;
            foreach ($reserve_list_info as $info) {
                $market_hotel_price = $market_hotel_price + $info['room_bord_price'] ;
            }

            $amount_paid = $this->calculateAmountPaidWithCommission($hotel['hotel_id'] ,$market_hotel_price) ;
            $result[] = [
                'book_id'     => $hotel['id'],
                'factor_number'     => $hotel['factor_number'],
                'passenger_name'     => $hotel['passenger_name'] . ' ' . $hotel['passenger_family'],
                'passenger_name_en'     => $hotel['passenger_name_en'] .' '.$hotel['passenger_family_en'],
                'room'     => $hotel['room_name'],
                'start_date'     => $hotel['start_date'],
                'end_date'     => $hotel['end_date'],
                'status'        => $invoice['status'] ,
                'invoice_number'       => $invoice['factor_number'],
                'tracking_code'       => $invoice['tracking_code'],
                'amount_total'        => number_format($hotel['total_price']),
                'amount'       => number_format($amount_paid),
                'amount_base'       => number_format($market_hotel_price),
                'pnr'       => $hotel['pnr'],
                'status_main'    => $this->getInvoiceStatus($invoice['status']),
                'status_color'    => $this->getInvoiceColor($invoice['status'])

            ];
        }

        if($params['statusGroup']) {

            $dynamicStatus = $params['statusGroup'] ;

            $filtered = array_filter($result, function($item) use ($dynamicStatus) {
                return $item['status'] === $dynamicStatus;
            });
            $result = [];

            foreach ($filtered as $hotel) {
                $result[] = $hotel;
            }

        }
        return functions::toJson($result);
    }

    public function  getHotelInvoice($hotel) {
        $invoic_controller = $this->getController('invoice')  ;
        $dateToday = new DateTime();
        $today = str_replace('-' , '' ,functions::convertToJalali($dateToday->format('Y-m-d'))) ;
        $end_date = str_replace('-' , '' ,$hotel['end_date'])  ;
        if($end_date >=  $today){
            return [
                'status' => 'canNotBeRequested' ,
                'invoice_id' => '',
                'tracking_code' => ''
            ] ;
        }

        $invoice = $invoic_controller->getBookInvoice($hotel['factor_number']) ;
        if($invoice) {
            if($invoice['status'] == 'waiting') {
                return [
                    'status' => 'waiting' ,
                    'factor_number' => '',
                    'tracking_code' => $invoice['tracking_code'] ,
                ] ;
            }else{
                return [
                    'status' => 'payed' ,
                    'factor_number' => $invoice['factor_number'] ,
                    'tracking_code' => $invoice['tracking_code'] ,
                ] ;
            }
        }
        else{
            return [
                'status' => 'receivable' ,
                'factor_number' => '',
                'tracking_code' => ''
            ] ;
        }
        
    }

    public function getUserReservationRoleUser(){
        $user_role_controller = $this->getController('userRole') ;
        $hotel_list  = $this->getUserReservationHotels() ;

        $params = [
            'item_id' => array_keys(array_filter(array_column($hotel_list,  "name" , "id"))),
            'item_table' => 'hotel'
        ] ;
        return $user_role_controller->getUserList($params) ;
    }

    public function accessReservationHotel() {
        return parent::reservationHotelAuth();
    }

    public function hasAccessHotelList() {
        $user_role_controller = $this->getController('userRole') ;
        $hotel_list  = $this->getUserReservationHotels() ;
        if(Session::getCounterTypeId() == 1) {
            return [
                'type'       => 'admin' ,
                'hotel_list' => $hotel_list
            ];
        }
        if(!$hotel_list) {
            $has_user_role = $user_role_controller->getUserRoleAccess('hotel');

            if($has_user_role){
                $hotel_id_list  = array_keys(array_filter(array_column($has_user_role,  "role" , "item_id")));

                $hotel_list = $this->getUserReservationHotelsById($hotel_id_list);

                if($hotel_list){
                    return [
                        'type'       => 'counter' ,
                        'hotel_list' => $hotel_list
                    ];

                }else{
                    return  [] ;
                }
            }else{
                return  [] ;
            }
        }else{
            return [
                'type'       => 'admin' ,
                'hotel_list' => $hotel_list
            ];
        }

    }

    public function getUserReservationHotelsById($hotel_list) {
        $reservation_city_tb = $this->getModel('reservationCityModel')->getTable();
        $reservation_hotel_tb = $this->getModel('reservationHotelModel')->getTable();
        return $this->getModel('reservationHotelModel')
            ->get(['*' , $reservation_city_tb .'.name as city_name' , $reservation_city_tb .'.name_en as city_name_en'])
            ->join($reservation_city_tb , 'id'  , 'city')
            ->where($reservation_hotel_tb.'.city' , 0 , '!=')
            ->where($reservation_hotel_tb.'.country' , 0 , '!=')
            ->whereIn($reservation_hotel_tb.'.id' , $hotel_list)
            ->orderBy('id' , 'DESC')->all();
    }
    
    public function isHotelAdmin($params) {
        return $this->getModel('reservationHotelModel')
            ->get(['*'])
            ->where('user_id' , Session::getUserId() )
            ->whereIn('id' , $params['hotel_id'])
            ->where('is_show' , 'yes' )->find();
    }
    
    public function updateRoomRequested($params) {
        $reservation_hotel_room_model = $this->getModel('reservationHotelRoomModel');
        $room_data = $reservation_hotel_room_model->get('*')->where('id' , $params['room_id'])->find() ;
        if($room_data['show_request'] == 'yes') {
            $data_update['show_request'] = 'no' ;
        }else{
            $data_update['show_request'] = 'yes' ;
        }
        $result = $reservation_hotel_room_model->update($data_update , 'id = '.$params['room_id']) ;

        return functions::JsonSuccess($result, 'درخواست با موفقیت انجام شد');
    }

    public function isSpecialHotel($id) {

        $Model = Load::library('Model');

        $sql = " SELECT flag_special FROM reservation_hotel_tb WHERE id='{$id}'";
        $result = $Model->load($sql);
        if ($result['flag_special'] == 'yes') {
            $data['flag_special'] = 'no';
        } else {
            $data['flag_special'] = 'yes';
        }
        $condition = "id='{$id}' ";

        $Model->setTable("reservation_hotel_tb");
        $res = $Model->update($data, $condition);

        if ($res) {
            return 'success : ' . functions::Xmlinformation('ChangesSuccessfullyCompleted');
        } else {
            return 'error ' . functions::Xmlinformation('ErrorChanges');
        }

    }
    public function isAcceptHotel($id) {

        $Model = Load::library('Model');

        $sql = " SELECT is_accept FROM reservation_hotel_tb WHERE id='{$id}'";
        $result = $Model->load($sql);
        if ($result['is_accept'] == 'yes') {
            $data['is_accept'] = 'no';
        } else {
            $data['is_accept'] = 'yes';
        }
        $condition = "id='{$id}' ";

        $Model->setTable("reservation_hotel_tb");
        $res = $Model->update($data, $condition);

        if ($res) {
            return 'success : ' . functions::Xmlinformation('ChangesSuccessfullyCompleted');
        } else {
            return 'error ' . functions::Xmlinformation('ErrorChanges');
        }

    }

    public function calculateAmountPaidWithCommission($hotel_id , $price) {
        $market_place_commission = $this->getController('marketplaceCommission');
        $params = [
            'service_id'  => $hotel_id ,
            'type'        => 'hotel'
        ];
        $market_place_commission_data  = $market_place_commission->getCommissionMarketplace($params);

        if($market_place_commission_data) {
            $amount = $market_place_commission_data['amount_commission'];
            $price_type = $market_place_commission_data['type_commission'];
            $addOnPrice = 0  ;
            if ($price_type == 'cost') {
                $addOnPrice = $amount;
            }
            if ($price_type == 'percent') {
                 $addOnPrice = (($price * ($amount / 100)));

            }
           
            return ( $price - $addOnPrice ) ;
        }else{
            return $price;
        }
    }

    public function getHotelList($params) {

        $result =  $this->reservation_hotel_model->get()
            ->where('user_id' , '' , '!=' )
            ->where('is_del' , 'no' );
        if($params['search_star']) {
            $result = $result->where('star_code' , $params['search_star']);
        }
        if($params['search_city']){
            $result = $result->where('city' , $params['search_city']);
        }
        if($params['search_hotel']){
            $result = $result->openParentheses();
            $result = $result->like('name', "%{$params['search_hotel']}%", "LEFT");
            $result = $result->like('name_en', "%{$params['search_hotel']}%", "LEFT");
            $result = $result->closeParentheses();
        }


        return $result->all();
    }
    public function showAtHome($id) {

        $Model = Load::library('Model');

        $sql = " SELECT show_in_home FROM reservation_hotel_tb WHERE id='{$id}'";
        $result = $Model->load($sql);
        if ($result['show_in_home'] == 0) {
            $data['show_in_home'] = 1;
        } else {
            $data['show_in_home'] = 0;
        }
        $condition = "id='{$id}' ";

        $Model->setTable("reservation_hotel_tb");
        $res = $Model->update($data, $condition);

        if ($res) {
            return 'success : ' . functions::Xmlinformation('ChangesSuccessfullyCompleted');
        } else {
            return 'error ' . functions::Xmlinformation('ErrorChanges');
        }

    }




    public function hotelReservationMarketPlaceData($params){

        /** @var ModelBase $ModelBase */
        $limit             = "";
        $conditionSpecial  = "";
        $conditionDiscount = "";
        $conditionCountry  = "";
        foreach ( $params as $key => $param ) {
            $request[ $key ] = functions::checkParamsInput( $param );
        }
        $special  = $request['special'];
        $discount = $request['discount'];
        $date     = $request['dateNow'];
        $limit    = $request['limit'];
        $country  = $request['country'];
        $mod = '';
        $format = 'Y' . $mod . 'm' . $mod . 'd';
        $price_date_today = dateTimeSetting::jdate($format, time(), '', '', 'en');

        $reservation_hotel_list = $this->reservation_hotel_room_prices_model
            ->get([
                $this->reservation_hotel_table . '.name',
                $this->reservation_hotel_table . '.name_en',
                $this->reservation_hotel_table . '.comment',
                $this->reservation_hotel_table . '.discount',
                $this->reservation_hotel_table . '.star_code',
                $this->reservation_hotel_table . '.type_code',
                $this->reservation_hotel_table . '.id',
                $this->reservation_hotel_table . '.user_id',
                $this->reservation_hotel_table . '.logo',
                $this->reservation_hotel_table . '.address',
                $this->reservation_hotel_table . '.city',
                $this->reservation_city_table . '.name as city_name' ,
                $this->reservation_hotel_room_prices_table . '.online_price as price',

            ], true)
            ->join($this->reservation_hotel_table, 'id', 'id_hotel' , 'INNER')
            ->join($this->reservation_hotel_table , 'id', 'city' , 'LEFT' ,$this->reservation_city_table )
            ->where($this->reservation_hotel_room_prices_table . '.user_type' , '5' , '=')
            ->where($this->reservation_hotel_table . '.is_del' , 'no' , '=')
            ->where($this->reservation_hotel_table . '.user_id' , '' , '!=')
            ->where($this->reservation_hotel_table . '.show_in_home' , '1' , '=')
            ->where($this->reservation_hotel_room_prices_table . '.flat_type' , 'DBL' , '=')
            ->where($this->reservation_hotel_room_prices_table . '.is_del' , 'no' , '=')
            ->where($this->reservation_hotel_room_prices_table . '.date' , $price_date_today , '>=');


        if ( isset( $special ) && $special != "" ) {
            $reservation_hotel_list = $reservation_hotel_list->where($this->reservation_hotel_table . '.flag_special' , 'yes' , '=');
        }
        if ( isset( $special ) && $special == false ) {
            $reservation_hotel_list = $reservation_hotel_list->where($this->reservation_hotel_table . '.flag_special' , 'yes' , '!=');
        }
        if ( isset( $discount ) && $discount != "" ) {
            $reservation_hotel_list = $reservation_hotel_list->where($this->reservation_hotel_table . '.flag_discount' , 'yes' , '=');
        }
        if ( ! empty( $country ) ) {
            if ( $country == 'internal' ) {
                $reservation_hotel_list = $reservation_hotel_list->where($this->reservation_hotel_table . '.country' , '1' , '=');
            } elseif ( $country == 'external' ) {
                $reservation_hotel_list = $reservation_hotel_list->where($this->reservation_hotel_table . '.country' , '1' , '!=');
            }else {
                $reservation_hotel_list = $reservation_hotel_list->where($this->reservation_hotel_table . '.country' , $country , '=');
            }
        }

        if ( ! empty( $request['city'] ) ) {
            $reservation_hotel_list = $reservation_hotel_list->where($this->reservation_hotel_table . '.city' , $request['city'] , '=');
        }

        $reservation_hotel_list= $reservation_hotel_list->groupBy($this->reservation_hotel_table . '.id')
            ->orderBy($this->reservation_hotel_table . '.star_code' , 'DESC')
            ->orderBy($this->reservation_hotel_table . '.name' , 'ASC')
            ->orderBy($this->reservation_hotel_table . '.name' , 'DESC');

        if ( isset( $limit ) && $limit != "" ) {
            $reservation_hotel_list = $reservation_hotel_list->limit(0 , $limit);
        }


        return $reservation_hotel_list->all();
    }


    public function ListCityAll(){

        $city_model = $this->getModel('hotelCitiesModel')->get()->orderBy('city_name' , 'ASC') ;
        return  $city_model->all();
    }
    public function updateSelectCity($params) {
        $select_city_model = $this->getModel('selectServiceModel');
        $get_service = $this->getModel("selectServiceModel")->orderBy('id' , 'desc')->get()->where('service' , 'Hotel')->find();

        if ($get_service['id']) {
            $dataUpdate = [
                'city_id' => $params['origin_city'],
                'service' => $params['service_name'],
                'updated_at' => date('Y-m-d H:i:s', time()),
            ];
            $update = $select_city_model->updateWithBind($dataUpdate, ['id' => $get_service['id']]);
            if ($update) {
                return functions::withSuccess('', 200, 'ویرایش شهر منتخب  با موفقیت انجام شد');

            }
        } else {
            $dataInsert = [
                'city_id' => $params['origin_city'],
                'service' => $params['service_name'],
                'created_at' => date('Y-m-d H:i:s', time()),
            ];
            $result = array_merge($dataInsert);
            $insert = $this->getModel('selectServiceModel')->insertWithBind($result);
            if ($insert) {
                return functions::withSuccess('', 200, 'افزودن شهر منتخب  با موفقیت انجام شد');
            }
        }
//        die;
    }
    public function getSelectSrvice($service) {
        $select_service_model = $this->getModel('selectServiceModel');
        $select_service_table = $select_service_model->getTable();
        $service = $select_service_model
            ->get(
                [
                    $select_service_table . '.*',
                ], true
            )
            ->where($select_service_table . '.service', $service)
            ->find(false);
//        return $this->addBrandIndexes([$service])[0];
        return $service;
    }
    public function findCityNameById($id) {
        return $this->getModel('hotelCitiesModel')->get()->where('id' , $id)->find();
    }



    public function cityHotelMain() {
        $result =  $this->getModel('hotelCitiesModel')->get([
            '*' , "'city' as type_app"
        ])
            ->where('position'  , 'null' , '!=')->orderBy('position','DESC')->all();
        return $result;
    }

    public function getCitiesExternalByName($name)
    {
        $ModelBase = Load::library('ModelBase');
        $sql = " SELECT * FROM external_hotel_city_tb where city_name_en = '$name'";
        $result = $ModelBase->select($sql);
        return $result;
    }

    public function confirmHotelRequested_old($params) {
        $Model = Load::library('Model');
        $factorNumber = $params['FactorNumber'];
        $sql = "SELECT * FROM book_hotel_local_tb WHERE factor_number='{$factorNumber}'";
        $res = $Model->load($sql);

         if ($res['status'] == 'Requested' && $res['payment_status'] == 'prePayment') {
             $data['payment_status'] = 'fullPayment';
             $data['status'] = 'RequestAccepted';
         }
        $condition = "factor_number='{$factorNumber}' ";
        $Model->setTable("book_hotel_local_tb");
        $res = $Model->update($data, $condition);
        if ($res) {
            return 'success : ' . functions::Xmlinformation('ChangesSuccessfullyCompleted');
        } else {
            return 'error ' . functions::Xmlinformation('ErrorChanges');
        }


    }
    public function RejectHotelRequested_old($params) {
        $Model = Load::library('Model');
        $factorNumber = $params['FactorNumber'];
        $sql = "SELECT * FROM book_hotel_local_tb WHERE factor_number='{$factorNumber}'";
        $res = $Model->load($sql);

        if ($res['status'] == 'Requested' && $res['payment_status'] == 'prePayment') {
            $data['payment_status'] = 'prePayment';
            $data['status'] = 'RequestRejected';
        }
        $condition = "factor_number='{$factorNumber}' ";
        $Model->setTable("book_hotel_local_tb");
        $res = $Model->update($data, $condition);
        if ($res) {
            return 'success : ' . functions::Xmlinformation('ChangesSuccessfullyCompleted');
        } else {
            return 'error ' . functions::Xmlinformation('ErrorChanges');
        }
    }


    public function confirmHotelRequested($params) {
        
        /** @var bookHotelLocalModel $bookHotelLocalModel */
        /** @var reportHotelModel $reportHotelModel */
        $bookHotelLocalModel = Load::getModel('bookHotelLocalModel');
        $reportHotelModel = Load::getModel('reportHotelModel');

//      $Model = Load::library('Model');
        $factorNumber = $params['FactorNumber'];
        $ConfirmAdminRequestedPrereserveHotelUserCode = $params['ConfirmAdminRequestedPrereserveHotelUserCode'];
        $sql = "SELECT * FROM book_hotel_local_tb WHERE factor_number='{$factorNumber}'";

        $res = $bookHotelLocalModel->load($sql);


        if ($res['status'] == 'Requested' && $res['payment_status'] == 'prePayment') {
            $data['payment_status'] = 'fullPayment';
            $data['status'] = 'RequestAccepted';
            $data['hotel_confirm_code'] = $ConfirmAdminRequestedPrereserveHotelUserCode;
        }

        $condition = "factor_number='".$factorNumber."'";
//        $Model->setTable("book_hotel_local_tb");
//        $res = $Model->update($data, $condition);

//        var_dump($condition);


        $res2 = $bookHotelLocalModel->updateWithBind($data, $condition);
        $res1 = $reportHotelModel->updateWithBind($data, $condition);

        var_dump($res1);
        

        if ($res2) {
            //sms to buyer
            if (!empty($res['member_mobile'])) {
                $mobile = $res['member_mobile'];
                $name = $res['member_name'];
            } else {
                $mobile = $res['passenger_leader_room'];
                $name = $res['passenger_leader_room_fullName'];
            }


            $smsController = Load::controller('smsServices');

                //sms to buyer
                $objSms = $smsController->initService('0');
                if ($objSms) {


                        $messageVariables = array(
                            'sms_name' => $name,
                            'sms_service' => 'هتل',
                            'sms_factor_number' => $res['factor_number'],
                            'sms_cost' => $res['total_price'],
                            'sms_destination' => $res['city_name'],
                            'sms_hotel_name' => $res['hotel_name'],
                            'sms_hotel_in' => $res['start_date'],
                            'sms_hotel_out' => $res['end_date'],
                            'sms_hotel_night' => $res['number_night'],
                            'sms_agency' => CLIENT_NAME,
                            'sms_agency_mobile' => CLIENT_MOBILE,
                            'sms_agency_phone' => CLIENT_PHONE,
                            'sms_agency_email' => CLIENT_EMAIL,
                            'sms_agency_address' => CLIENT_ADDRESS,
                            'sms_order_link' =>   ROOT_ADDRESS . '/UserTracking&type=hotel&id=' . $res['factor_number'] ,
                        );
                     $hotel_reserve_pattern  =   $smsController->getPattern('hotel_request_confirm_pattern_sms');
                    if($hotel_reserve_pattern) {
                        $smsController->smsByPattern($hotel_reserve_pattern['pattern'], array($mobile),$messageVariables);
                    }else {
                        $smsArray = array(
                            'smsMessage' => $smsController->getUsableMessage('onRequestConfirm', $messageVariables),
                            'cellNumber' => $mobile,
                            'smsMessageTitle' => 'onRequestConfirm',
                            'memberID' => (!empty($res['member_id']) ? $res['member_id'] : ''),
                            'receiverName' => $messageVariables['sms_name'],
                        );
                        $smsController->sendSMS($smsArray);
                    }

                }





            return 'success : ' . functions::Xmlinformation('ChangesSuccessfullyCompleted');
        } else {
            return 'error ' . functions::Xmlinformation('ErrorChanges');
        }


    }
    public function RejectHotelRequested($params) {
        /** @var bookHotelLocalModel $bookHotelLocalModel */
        /** @var reportHotelModel $reportHotelModel */
        $bookHotelLocalModel = Load::getModel('bookHotelLocalModel');
        $reportHotelModel = Load::getModel('reportHotelModel');
//        $Model = Load::library('Model');
        $factorNumber = $params['FactorNumber'];
        $sql = "SELECT * FROM book_hotel_local_tb WHERE factor_number='{$factorNumber}'";
        $res = $bookHotelLocalModel->load($sql);

        if ($res['status'] == 'Requested' && $res['payment_status'] == 'prePayment') {
            $data['payment_status'] = 'prePayment';
            $data['status'] = 'RequestRejected';
        }
        $condition = "factor_number='{$factorNumber}' ";
//        $Model->setTable("book_hotel_local_tb");
//        $res = $Model->update($data, $condition);

        $res2 = $bookHotelLocalModel->updateWithBind($data, $condition);
        $res1 = $reportHotelModel->updateWithBind($data, $condition);
        if ($res2) {
            return 'success : ' . functions::Xmlinformation('ChangesSuccessfullyCompleted');
        } else {
            return 'error ' . functions::Xmlinformation('ErrorChanges');
        }
    }

}
?>
