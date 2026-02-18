<?php

require '../../config/bootstrap.php';
require CONFIG_DIR . 'configBase.php';
//require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));

class getAllHotel
{
    private $url = '';
    
    public function __construct()
    {
        $this->getSuccessRecords();
    }

    public function getSuccessRecords()
    {
        error_log('cronjob start : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_cronjob_hotel.txt');

        $Hotel_room = array();

        Load::autoload('apiHotelLocal');
        $api = new apiHotelLocal();

        $dateNow = dateTimeSetting::jdate("Y-m-d",time());
        
        $date_time_update = dateTimeSetting::jdate("Y-m-d h:i:sa",time(),'' ,'', 'en');
        
        $explode = explode('-', $dateNow);
        $jmktime = dateTimeSetting::jmktime(0, 0, 0, $explode[1], $explode[2], $explode[0]);
        
        $Date = dateTimeSetting::jstrftime("%Y%m%d", $jmktime + (24 * 60 * 60), '', '', 'en');

        $urlCity = 'http://newapi.alaedin.travel/City/12E8E48A-ECB7-4EE9-A68D-E42E78E65B35';
        $AllCity = $api->curlExecutionGet($urlCity);

        $cronMin = date('i');

        if($cronMin >= '01' && $cronMin <= '15') {
            $limit1 = 0;
            $limit2 = 15;
        } elseif($cronMin >= '16' && $cronMin <= '30'){
            $limit1 = 16;
            $limit2 = 30;
        }  elseif($cronMin >= '31' && $cronMin <= '45'){
            $limit1 = 31;
            $limit2 = 100;
        } elseif($cronMin >= '46' && $cronMin <= '59'){
            $limit1 = 101;
            $limit2 = 166;
        }

        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();


        foreach ($AllCity as $countCity => $city) {
            if (($countCity >= $limit1 && $countCity <= $limit2)) {

                error_log('city loop : ' . date('Y/m/d H:i:s') . ' city code: ' . $city['Code'] . '-'.  $city['Name'] . " \n", 3, LOGS_DIR . 'log_cronjob_hotel.txt');

                $Hotel_room[$city['Code']]['city'] = $city['Code'];

                $urlHotelByCity = 'http://newapi.alaedin.travel/Hotel/byCity/' . $city['Code'] . '/12E8E48A-ECB7-4EE9-A68D-E42E78E65B35';
                $result_Hotel = $api->curlExecutionGet($urlHotelByCity);


                foreach ($result_Hotel as $Hotel) {

                    error_log('hotel loop : ' . date('Y/m/d H:i:s') . ' hotel code: ' . $Hotel['Code']. '-'. $Hotel['Name'] . " \n", 3, LOGS_DIR . 'log_cronjob_hotel.txt');

                    if($Hotel['Code'] != '1359') {

                        $Hotel_room[$city['Code']][$Hotel['Code']]['Hotel'] = $Hotel['Code'];

                        $urlRoomPrice = 'http://newapi.alaedin.travel/RoomPrice/' . $Hotel['Code'] . '/' . $Date . '/20/12E8E48A-ECB7-4EE9-A68D-E42E78E65B35';
                        $resultAllRoom = $api->curlExecutionGet($urlRoomPrice);

                        $arrayRoom = array();$discount = array();
                        foreach ($resultAllRoom as $room){
                            if ($room['Price'] != 0) {
                                $arrayRoom[$room['Date']][] = $room['Price'];

                                $t = ($room['PriceBoard']) - ($room['Price']);
                                $discount[] = round(($t * 100) / $room['PriceBoard']);

                            }
                        }
                        $jsonData = json_encode($arrayRoom);

                        /*$urlRoomByHotel = 'http://newapi.alaedin.travel/Room/byHotel/' . $Hotel['Code'] . '/12E8E48A-ECB7-4EE9-A68D-E42E78E65B35';
                        $result_roomCode = $api->curlExecutionGet($urlRoomByHotel);
                        $RemainingCapacity = 0;
                        $MinPrice = array();
                        foreach ($result_roomCode as $i => $room) {

                            $url = 'http://newapi.alaedin.travel/RoomPrice/' . $Hotel['Code'] . '/' . $room['Code'] . '/' . $Date . '/12E8E48A-ECB7-4EE9-A68D-E42E78E65B35';
                            $resultRoom = $api->curlExecutionGet($url);

                            if ($resultRoom['Price'] != 0) { $MinPrice[] = $resultRoom['Price']; }
                            $RemainingCapacity = $RemainingCapacity + $resultRoom['RemainingCapacity'];

                        }*/

                        $d['city_id'] = $city['Code'];
                        $d['hotel_id'] = $Hotel['Code'];
                        $d['min_room_price'] = '';
                        $d['remaining_capacity'] = '';
                        $d['hotel_name'] = $Hotel['Name'];
                        $d['hotel_name_en'] = $Hotel['NameEn'];
                        $d['address'] = $Hotel['AddressInfo']['Address'];
                        $d['discount'] = max($discount);
                        $d['cancel_conditions'] = $Hotel['CancellationConditions'];
                        $d['pic'] = $Hotel['HotelPictures'][0]['Url'];
                        $d['type_code'] = $Hotel['HotelTypeCode'];
                        $d['star_code'] = $Hotel['StarCode'];
                        $d['info_rooms'] = $jsonData;
                        $d['date_time_update'] = $date_time_update;

                        $sql = "SELECT * FROM hotel_room_prices_tb WHERE city_id='{$city['Code']}' AND hotel_id='{$Hotel['Code']}' ";
                        $result = $ModelBase->load($sql);

                        if (empty($result)) {

                            $ModelBase->setTable('hotel_room_prices_tb');
                            $res = $ModelBase->insertLocal($d);

                            error_log('insert hotel : ' . date('Y/m/d H:i:s') . ' result: ' . $res . " \n", 3, LOGS_DIR . 'log_cronjob_hotel.txt');

                        } else {

                            $Condition = "city_id='{$city['Code']}' AND hotel_id='{$Hotel['Code']}'";
                            $ModelBase->setTable("hotel_room_prices_tb");
                            $res = $ModelBase->update($d, $Condition);

                            error_log('update hotel : ' . date('Y/m/d H:i:s') . ' result: ' . $res . " \n", 3, LOGS_DIR . 'log_cronjob_hotel.txt');
                        }
                    }

                }


            }
        }

        $star_code['star_code'] = 0;
        $Condition = " star_code = '6' ";
        $ModelBase->setTable("hotel_room_prices_tb");
        $res_star_code = $ModelBase->update($star_code, $Condition);
        error_log('update hotel star code : ' . date('Y/m/d H:i:s') . ' result: ' . $res_star_code . " \n", 3, LOGS_DIR . 'log_cronjob_hotel.txt');


        $ConditionDelete = " hotel_name LIKE '%در حال%' OR hotel_name LIKE '%درحال%' ";
        $ModelBase->setTable("hotel_room_prices_tb");
        $resDelete = $ModelBase->delete($ConditionDelete);
        error_log('delete hotel : ' . date('Y/m/d H:i:s') . ' result: ' . $resDelete . " \n", 3, LOGS_DIR . 'log_cronjob_hotel.txt');

        error_log('cronjob end : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_cronjob_hotel.txt');
        mail('tech@iran-tech.com','gds hotel cronjob','cronjob is working!');

    }
    

}

new getAllHotel();

?>
