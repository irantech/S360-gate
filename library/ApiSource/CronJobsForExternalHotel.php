<?php




defined('LOGS_DIR') or define('LOGS_DIR', dirname(dirname(dirname(__FILE__))) . '/logs/');
error_log('cronJob start first pages : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_cronJob_external_hotel.txt');

require '../../config/bootstrap.php';
require CONFIG_DIR . 'configBase.php';
//require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));

/**
 * Class getHotelCityList
 * @property getHotelCityList $getHotelCityList
 */
class getHotelCityList
{
//    private $requestUrl = 'http://safar360.com/Core/ExternalHotel/';
    private $requestUrl = 'http://safar360.com/Core/ExternalHotel/';
    //private $requestUrl = 'http://safar360.com/CoreTestDeveloper/ExternalHotel/';
    //private $requestUrl = 'http://185.204.101.23/Core/ExternalHotel/';

    public function __construct()
    {
        error_log('cronJob start : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_cronJob_external_hotel.txt');

        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        Load::autoload('apiExternalHotel');
        $api = new apiHotelLocal();

        $Date_emrouz = dateTimeSetting::jdate("Y-m-d", time());

        $date_time_update = dateTimeSetting::jdate("Y-m-d h:i:sa", time(), '', '', 'en');

        $explode = explode('-', $Date_emrouz);
        $jmktime = dateTimeSetting::jmktime(0, 0, 0, $explode[1], $explode[2], $explode[0]);

        $Date = dateTimeSetting::jstrftime("%Y%m%d", $jmktime + (24 * 60 * 60), '', '', 'en');

        $cronMin = date('i');
        if ($cronMin >= '01' && $cronMin <= '15') {
            $limit1 = 0;
            $limit2 = 15;
        } elseif ($cronMin >= '16' && $cronMin <= '30') {
            $limit1 = 16;
            $limit2 = 30;
        } elseif ($cronMin >= '31' && $cronMin <= '45') {
            $limit1 = 31;
            $limit2 = 100;
        } elseif ($cronMin >= '46' && $cronMin <= '59') {
            $limit1 = 101;
            $limit2 = 166;
        }


        $url = $this->requestUrl . "Login";
        $data['UserName'] = 'irantechTest';
        $jsonData = json_encode($data);
        $result = $api->curlExecutionPost($url, $jsonData);


        $url = $this->requestUrl . "HotelCityList";
        $data['IataCode'] = '';
        $data['MemberSessionID'] = $result['LoginID'];
        $jsonData = json_decode($data);
        $result_hotelCityList = $api->curlExecutionPost($url, $jsonData);
        echo 'count city: ' . count($result_hotelCityList) . '<hr>';

        $countInsert = 0;
        $sql = " INSERT INTO external_hotel_city_tb VALUES";
        if (!empty($result_hotelCityList)) {

            foreach ($result_hotelCityList as $count => $val) {
                $countInsert++;

                $jsonData = json_encode($val);
                error_log('in foreach : ' . date('Y/m/d H:i:s') . ' result: ' . $jsonData . ' countInsert: ' . $countInsert . " \n", 3, LOGS_DIR . 'log_cronJob_external_hotel.txt');

                if ($countInsert % 100 == 0) {

                    $sql = substr($sql, 0, -1);
                    $res = $ModelBase->execQuery($sql);

                    error_log('insert external_hotel_city_tb : ' . date('Y/m/d H:i:s') . ' result: ' . $res . ' countInsert: ' . $countInsert . " \n", 3, LOGS_DIR . 'log_cronJob_external_hotel.txt');

                    $sql = " INSERT INTO external_hotel_city_tb VALUES";
                }


                $CountryName = str_replace("'", "", $val['CountryName']);
                $PlaceName = str_replace("'", "", $val['PlaceName']);
                $sql .= "('',
                            '" . $val['PlaceID'] . "',
                            '" . $val['IataCode'] . "',
                            '" . $CountryName . "',
                            '" . $val['CountryNamePersian'] . "',
                            '" . $PlaceName . "',
                            '" . $val['PlaceNamePersian'] . "'
                            ),";
            }
            error_log('end foreach : ' . date('Y/m/d H:i:s') . ' countInsert: ' . $countInsert . ' sql: ' . $sql . " \n", 3, LOGS_DIR . 'log_cronJob_external_hotel.txt');


            //ثبت تعداد رکورد کمتر از 100 تا اینجا اتفاق میفتد
            if ($sql != '') {

                $sql = substr($sql, 0, -1);
                $res = $ModelBase->execQuery($sql);

                error_log('insert external_hotel_city_tb (-100) : ' . date('Y/m/d H:i:s') . ' result: ' . $res . ' countInsert: ' . $countInsert . " \n", 3, LOGS_DIR . 'log_cronJob_external_hotel.txt');

            }


        }


        error_log('cronJob end : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_cronJob_external_hotel.txt');
        mail('tech@iran-tech.com', 'gds ecternal hotel cronJob', 'cronJob is working!');
    }


}
//new getHotelCityList();


class downloadImagesHotel
{
//    private $requestUrl = 'http://safar360.com/Core/ExternalHotel/';
    private $requestUrl = 'http://safar360.com/Core/ExternalHotel/';
    //private $requestUrl = 'http://safar360.com/CoreTestDeveloper/ExternalHotel/';
    //private $requestUrl = 'http://185.204.101.23/Core/ExternalHotel/';

    public function __construct()
    {
        error_log('downloadImagesHotel start : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_cronJob_external_hotel.txt');

        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        echo Load::plog($_GET);
        if (isset($_GET['country']) && isset($_GET['city'])) {
            $country = str_replace("-", " ", $_GET['country']);
            $city = str_replace("-", " ", $_GET['city']);
            $query = " SELECT place_id, city_name_fa FROM external_hotel_city_tb WHERE country_name_en = '{$country}' AND city_name_en = '{$city}' ";
        } else {
            $arrayNameFaCity = [
                'زوریخ', 'ایروان', 'مسقط', 'نیویورک', 'رم', 'بانکوک', 'پاریس', 'پکن', 'میلان', 'استانبول', 'دبی'
                , 'ونکور', 'کوالالامپور', 'مسکو', 'آنکارا', 'آنتالیا', 'گوانجو', 'شانگهای', 'آمستردام', 'کولومبو', 'آتن', 'کیو', 'جنوا'
                , 'سن پترزبورگ', 'بارسلونا', 'سایگون', 'ماله', 'روتردام', 'دوسلدورف', 'ونیز', 'پوکت', 'ازمیر', 'بدروم', 'آدنا', 'وان'
                , 'بلگراد', 'تفلیس', 'استکهلم', 'باکو', 'فلورانس', 'شنزن', 'تورنتو', 'مونترال'
            ];
            /*$query = " SELECT place_id, city_name_fa FROM external_hotel_city_tb WHERE city_name_fa IN ('زوریخ', 'ایروان', 'مسقط', 'نیویورک', 'رم', 'بانکوک', 'پاریس', 'پکن', 'میلان', 'استانبول', 'دبی'
            , 'ونکور', 'کوالالامپور', 'مسکو', 'آنکارا', 'آنتالیا', 'گوانجو', 'شانگهای', 'آمستردام', 'کولومبو', 'آتن', 'کیو', 'جنوا'
            , 'سن پترزبورگ', 'بارسلونا', 'سایگون', 'ماله', 'روتردام', 'دوسلدورف', 'ونیز', 'پوکت', 'ازمیر', 'بدروم', 'آدنا', 'وان'
            , 'بلگراد', 'تفلیس', 'استکهلم', 'باکو', 'فلورانس', 'شنزن' , 'تورنتو', 'مونترال') 
            ";*/


            // 30 شهری که مهمتر و تعداد هتل های بالاتری دارند.//
            // در هر روز یک شهر انتخاب شده و اطلاعاتش در دیتابیس ذخیره شود.//
            $day = date('d');
            if ($day < 9) {
                $day = substr($day, 1, -1);
            }
            $query = " SELECT place_id, city_name_fa FROM external_hotel_city_tb WHERE city_name_fa IN ('نیویورک', 'رم', 'بانکوک', 'پاریس', 'پکن', 'میلان', 'استانبول', 'دبی'
            , 'کوالالامپور', 'مسکو', 'آنکارا', 'آنتالیا', 'گوانجو', 'شانگهای', 'آمستردام', 'آتن'
            , 'سن پترزبورگ', 'بارسلونا', 'سایگون', 'ونیز', 'پوکت', 'وان'
            , 'بلگراد', 'تفلیس', 'استکهلم', 'باکو', 'فلورانس', 'شنزن' , 'تورنتو', 'مونترال')
            LIMIT {$day},1 
            ";

            // برای اجرا و ذخیره؛ هم اطلاعات هتل و هم عکس های هتل//
            $cash = 'imagesAndHotelInfo';
        }

        echo $query . '<br>';
        $result = $ModelBase->select($query);
        //echo Load::plog($result);


        $url = $this->requestUrl . "Login";
        $data['UserName'] = 'hijimbo';
        $jsonData = json_encode($data);
        $resultLogin = $this->curlExecutionPost($url, $jsonData);
        error_log('result login : ' . date('Y/m/d H:i:s') . "    " . json_encode($resultLogin) . " \n", 3, LOGS_DIR . 'log_cronJob_external_hotel.txt');


        foreach ($result as $countResult => $val) {

            $dateMiladi = date('Ymd');
            $date = date('Y-m-d', strtotime($dateMiladi . "+ 5 day"));

            $dataRequest['PlaceID'] = (int)$val['place_id'];
            $dataRequest['Nationality'] = 'IR';
            $dataRequest['FromDate'] = $date;
            $dataRequest['ReserveLength'] = 1;
            $dataRequest['TestMode'] = true;
            $dataRequest['MemberSessionID'] = $resultLogin['LoginID'];
            $dataRequest['Rooms'] = [
                0 => [
                    0 => [
                        'PassengerAge' => 30,
                        'Gender' => true
                    ]
                ]
            ];
            $dataRequest['UserName'] = 'hijimbo';
            //echo Load::plog($dataRequest);
            $jsonData = json_encode($dataRequest, true);
            error_log('request data : ' . date('Y/m/d H:i:s') . "    " . $jsonData . " \n", 3, LOGS_DIR . 'log_cronJob_external_hotel.txt');
            $url = $this->requestUrl . "HotelSearch";
            $resultSearch = $this->curlExecutionPost($url, $jsonData);
            //echo Load::plog($resultSearch);
            error_log('response data ' . $val['city_name_fa'] . ' : ' . date('Y/m/d H:i:s') . "    " . json_encode($resultSearch) . " \n", 3, LOGS_DIR . 'log_cronJob_external_hotel.txt');
            if (!empty($resultSearch)) {
                $dataRequestHotel['UserName'] = 'hijimbo';
                $dataRequestHotel['Password'] = '123456';
                $dataRequestHotel['SearchID'] = $resultSearch['SearchID'];
                $dataRequestHotel['MemberSessionID'] = $resultLogin['LoginID'];


                $countAllHotels = count($resultSearch['Hotels']);
                if ($countAllHotels > 20) {
                    $division4CountAllHotels = $countAllHotels / 4 ;
                    $cronMin = date('i');
                    if ($cronMin >= '01' && $cronMin <= '15') {
                        $limit1 = 0;
                        $limit2 = round($division4CountAllHotels) + 1;
                    } elseif ($cronMin >= '16' && $cronMin <= '30') {
                        $limit1 = round($division4CountAllHotels) + 1;
                        $limit2 = round($division4CountAllHotels) * 2 + 1;
                    } elseif ($cronMin >= '31' && $cronMin <= '45') {
                        $limit1 = round($division4CountAllHotels) * 2 + 1;
                        $limit2 = round($division4CountAllHotels) * 3 + 1;
                    } elseif ($cronMin >= '46' && $cronMin <= '59') {
                        $limit1 = round($division4CountAllHotels) * 3 + 1;
                        $limit2 = round($division4CountAllHotels) * 4 + 1;
                    }
                } else {
                    $limit1 = 0;
                    $limit2 = $countAllHotels;
                }





                echo 'countAllHotels-> ' . $countAllHotels .'<br>';
                echo 'limit1-> ' . $limit1 . '    limit2-> ' . $limit2 .'<hr><hr>';
                foreach ($resultSearch['Hotels'] as $countHotel => $dataSearch) {


                    //if (isset($cash) && $cash == 'imagesAndHotelInfo' && $countHotel >= $limit1 && $countHotel <= $limit2) {}

                    if (
                        (isset($_GET['cash']) && $_GET['cash'] == 'images')
                        || (isset($cash) && $cash == 'imagesAndHotelInfo' && $countHotel >= $limit1 && $countHotel <= $limit2)
                    ) {

                        echo '<br>';
                        echo $dataSearch['HotelPersianName'] . ' ===> ' . $dataSearch['ImageURLJuniper'];

//                        $urlSaveImages = "http://safar360.com/imageExternalHotel/Hotel/SaveImage";
                        $urlSaveImages = "http://safar360.com/imageExternalHotel/Hotel/SaveImage";
                        $dataSaveImages['ImageURL'] = $dataSearch['ImageURLJuniper'];
                        $dataSaveImages['HotelName'] = $dataSearch['HotelName'];
                        $dataSaveImages['CityName'] = $dataSearch['CityName'];
                        $dataSaveImages['CountryName'] = $dataSearch['CountryName'];
                        $jsonDataSaveImages = json_encode($dataSaveImages);
                        $resultSaveImages = $this->curlExecutionSaveImages($urlSaveImages, $jsonDataSaveImages);
                        echo '<br> resultSaveImages <br>';
                        echo Load::plog($resultSaveImages);
                        echo '<hr>';

                        error_log('result SaveImages hotel id : ' . $dataSearch['HotelIndex'] . ' hotel name: ' . $dataSearch['HotelName'] . '   ' . json_encode($resultSaveImages) . " \n", 3, LOGS_DIR . 'log_cronJob_external_hotel.txt');


                    }
                    if (!isset($_GET['cash'])
                        || (isset($_GET['cash']) && $_GET['cash'] == 'hotelInfo')
                        || (isset($cash) && $cash == 'imagesAndHotelInfo' && $countHotel >= $limit1 && $countHotel <= $limit2)
                    ) {
                        $dataInsertHotel = [];
                        $dataInsertHotelRoom = [];
                        $dataInsertHotelAttribute = [];
                        if (isset($dataSearch['HotelIndex']) && $dataSearch['HotelIndex'] != '') {

                            $dataRequestHotel['HotelIndex'] = $dataSearch['HotelIndex'];

                            // insert hotel detail
                            $jsonDataHotel = json_encode($dataRequestHotel, true);
                            error_log('request data hotel id : ' . $dataSearch['HotelIndex'] . ' hotel name: ' . $dataSearch['HotelName'] . '  : ' . date('Y/m/d H:i:s') . "    " . $jsonDataHotel . " \n", 3, LOGS_DIR . 'log_cronJob_external_hotel.txt');
                            $urlHotel = $this->requestUrl . "HotelDetail";
                            $resultHotel = $this->curlExecutionPost($urlHotel, $jsonDataHotel);
                            error_log('response data hotel id : ' . $dataSearch['HotelIndex'] . ' hotel name: ' . $dataSearch['HotelName'] . ' : ' . date('Y/m/d H:i:s') . "    " . json_encode($resultHotel) . " \n", 3, LOGS_DIR . 'log_cronJob_external_hotel.txt');
                            if (!empty($resultHotel)) {

                                $dataInsertHotel['place_id'] = $val['place_id'];
                                $dataInsertHotel['country_name'] = $resultHotel['CountryName'];
                                $dataInsertHotel['country_persian_name'] = $resultHotel['CountryName'];
                                $dataInsertHotel['city_name'] = $resultHotel['CityName'];
                                $dataInsertHotel['city_persian_name'] = $resultHotel['CityName'];
                                $dataInsertHotel['hotel_index'] = $resultHotel['HotelIndex'];
                                $dataInsertHotel['hotel_name'] = str_replace("'", "", $resultHotel['HotelName']);
                                $dataInsertHotel['hotel_persian_name'] = $resultHotel['HotelPersianName'];
                                $dataInsertHotel['hotel_type'] = $resultHotel['HotelType'];
                                $dataInsertHotel['image_url'] = $resultHotel['ImageURL'];
                                $dataInsertHotel['breifing_description'] = $resultHotel['BreifingDescription'];
                                $dataInsertHotel['hotel_stars'] = $resultHotel['HotelStars'];
                                $dataInsertHotel['hotel_address'] = $resultHotel['HotelAddress'];

                                $sql = "SELECT * FROM external_hotel_tb 
                                        WHERE place_id = '{$val['place_id']}' AND hotel_index = '{$resultHotel['HotelIndex']}' ";
                                $resultCheckHotel = $ModelBase->load($sql);
                                if (empty($resultCheckHotel) && !empty($dataInsertHotel)) {
                                    $ModelBase->setTable('external_hotel_tb');
                                    $res = $ModelBase->insertLocal($dataInsertHotel);
                                    error_log('insert hotel name: ' . $resultHotel['HotelName'] . ' : ' . date('Y/m/d H:i:s') . ' result: ' . $res . " \n", 3, LOGS_DIR . 'log_cronJob_external_hotel.txt');
                                } else {
                                    $condition = " place_id = '{$val['place_id']}' AND hotel_index = '{$resultHotel['HotelIndex']}' ";
                                    $ModelBase->setTable("external_hotel_tb");
                                    $res = $ModelBase->update($dataInsertHotel, $condition);
                                    error_log('update hotel name: ' . $resultHotel['HotelName'] . ' : ' . date('Y/m/d H:i:s') . ' result: ' . $res . " \n", 3, LOGS_DIR . 'log_cronJob_external_hotel.txt');
                                }


                                // insert hotel rooms
                                if (!empty($resultHotel['RoomsDetail'])) {
                                    foreach ($resultHotel['RoomsDetail'] as $dataHotelRoomList) {

                                        echo 'RoomsDetail';
                                        echo Load::plog($dataHotelRoomList);

                                        foreach ($dataHotelRoomList['RoomList'] as $dataHotelRoom) {

                                            $dataInsertHotelRoom['place_id'] = $val['place_id'];
                                            $dataInsertHotelRoom['hotel_index'] = $resultHotel['HotelIndex'];
                                            $dataInsertHotelRoom['room_package_id'] = $dataHotelRoomList['ReservePackageID'];
                                            $dataInsertHotelRoom['room_name'] = str_replace("'", "", $dataHotelRoom['RoomName']);
                                            $dataInsertHotelRoom['free_breakfast'] = ($dataHotelRoom['FreeBreakfast'] == '1') ? 'yes' : 'no';
                                            $dataInsertHotelRoom['breakfast_type'] = $dataHotelRoom['BreakfastType'];

                                            $sql = "SELECT * FROM external_hotel_room_tb 
                                                WHERE 
                                                    place_id = '{$val['place_id']}' 
                                                    AND hotel_index = '{$resultHotel['HotelIndex']}' 
                                                    AND room_package_id = '{$dataHotelRoomList['ReservePackageID']}' 
                                                    AND room_name = '{$dataInsertHotelRoom['room_name']}' ";
                                            $resultCheckHotel = $ModelBase->load($sql);
                                            if (empty($resultCheckHotel) && !empty($dataHotelRoomList['RoomList'])) {
                                                $ModelBase->setTable('external_hotel_room_tb');
                                                $res = $ModelBase->insertLocal($dataInsertHotelRoom);
                                                error_log('insert hotel room: ' . $dataHotelRoom['RoomName'] . ' : ' . date('Y/m/d H:i:s') . ' result: ' . $res . " \n", 3, LOGS_DIR . 'log_cronJob_external_hotel.txt');
                                            } else {
                                                $condition = " place_id = '{$val['place_id']}' AND hotel_index = '{$resultHotel['HotelIndex']}' AND room_package_id = '{$dataHotelRoomList['ReservePackageID']}' AND room_name = '{$dataInsertHotelRoom['room_name']}' ";
                                                $ModelBase->setTable("external_hotel_room_tb");
                                                $res = $ModelBase->update($dataInsertHotelRoom, $condition);
                                                error_log('update hotel room: ' . $dataHotelRoom['RoomName'] . ' : ' . date('Y/m/d H:i:s') . ' result: ' . $res . " \n", 3, LOGS_DIR . 'log_cronJob_external_hotel.txt');
                                            }
                                        }
                                        /*$sql = "SELECT * FROM external_hotel_room_tb
                                                WHERE 
                                                    place_id = '{$val['place_id']}' 
                                                    AND hotel_index = '{$resultHotel['HotelIndex']}' 
                                                    AND room_package_id = '{$dataHotelRoomList['ReservePackageID']}' ";
                                        $resultCheckHotel = $ModelBase->load($sql);
                                        if (empty($resultCheckHotel) && !empty($dataHotelRoomList['RoomList'])) {
                                            foreach ($dataHotelRoomList['RoomList'] as $dataHotelRoom) {

                                                $dataInsertHotelRoom['place_id'] = $val['place_id'];
                                                $dataInsertHotelRoom['hotel_index'] = $resultHotel['HotelIndex'];
                                                $dataInsertHotelRoom['room_package_id'] = $dataHotelRoomList['ReservePackageID'];
                                                $dataInsertHotelRoom['room_name'] = str_replace("'", "", $dataHotelRoom['RoomName']);
                                                $dataInsertHotelRoom['free_breakfast'] = ($dataHotelRoom['FreeBreakfast'] == '1') ? 'yes' : 'no';
                                                $dataInsertHotelRoom['breakfast_type'] = $dataHotelRoom['BreakfastType'];

                                                $ModelBase->setTable('external_hotel_room_tb');
                                                $res = $ModelBase->insertLocal($dataInsertHotelRoom);
                                                error_log('insert hotel room: ' . $dataHotelRoom['RoomName'] . ' : ' . date('Y/m/d H:i:s') . ' result: ' . $res . " \n", 3, LOGS_DIR . 'log_cronJob_external_hotel.txt');

                                            }
                                        }*/
                                    }// each RoomsDetail
                                }


                                // insert hotel facilities
                                if (!empty($resultHotel['AttributeList'])) {
                                    foreach ($resultHotel['AttributeList'] as $attribute) {

                                        $dataInsertHotelAttribute['place_id'] = $val['place_id'];
                                        $dataInsertHotelAttribute['hotel_index'] = $resultHotel['HotelIndex'];
                                        $dataInsertHotelAttribute['title'] = $attribute['Title'];
                                        $dataInsertHotelAttribute['value'] = $attribute['Value'];

                                        $sql = "SELECT * FROM external_hotel_facilities_tb 
                                                WHERE 
                                                    place_id = '{$val['place_id']}' 
                                                    AND hotel_index = '{$resultHotel['HotelIndex']}' 
                                                    AND value = '{$attribute['Value']}' ";
                                        $resultCheckHotel = $ModelBase->load($sql);
                                        if (empty($resultCheckHotel) && !empty($dataInsertHotelAttribute)) {
                                            $ModelBase->setTable('external_hotel_facilities_tb');
                                            $res = $ModelBase->insertLocal($dataInsertHotelAttribute);
                                            error_log('insert hotel facilities: ' . $attribute['Value'] . ' : ' . date('Y/m/d H:i:s') . ' result: ' . $res . " \n", 3, LOGS_DIR . 'log_cronJob_external_hotel.txt');
                                        } else {
                                            $condition = " place_id = '{$val['place_id']}' AND hotel_index = '{$resultHotel['HotelIndex']}' AND value = '{$attribute['Value']}' ";
                                            $ModelBase->setTable("external_hotel_facilities_tb");
                                            $res = $ModelBase->update($dataInsertHotelAttribute, $condition);
                                            error_log('update hotel facilities: ' . $attribute['Value'] . ' : ' . date('Y/m/d H:i:s') . ' result: ' . $res . " \n", 3, LOGS_DIR . 'log_cronJob_external_hotel.txt');
                                        }
                                    }// each AttributeList
                                }


                            }// if resultHotel

                        }// if isset(HotelIndex)
                    }

                }// each hotel list
            }


        }

        error_log('cronJob end : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_cronJob_external_hotel.txt');
    }


    public function curlExecutionPost($url, $data)
    {

        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($handle);

        return json_decode($result, true);
    }

    #region curlExecutionSaveImages
    private function curlExecutionSaveImages($url, $data)
    {
        $url = str_replace(" ", '', $url);
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($handle, CURLOPT_ENCODING, 'gzip');
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($handle);
        return json_decode($result, true);
    }
    #endregion

}

new downloadImagesHotel();


?>
