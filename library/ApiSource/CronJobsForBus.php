<?php
defined('LOGS_DIR') or define('LOGS_DIR', dirname(dirname(dirname(__FILE__))) . '/logs/');
error_log('cronJob start first pages : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_cronJob_bus.txt');

require '../../config/bootstrap.php';
require CONFIG_DIR . 'configBase.php';
//require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));


class getCityList
{

    public function __construct()
    {
        error_log('cronJob start : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_cronJob_bus.txt');

        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();


        $arrayRoute = [];
        $sql = " SELECT * FROM flight_route_tb ";
        $flightRoute = $ModelBase->select($sql);
        foreach ($flightRoute as $val) {
            $arrayRoute[$val['Departure_City']]['yata'] = $val['Departure_Code'];
            $arrayRoute[$val['Departure_City']]['cityNameEn'] = $val['Departure_CityEn'];

            $arrayRoute[$val['Arrival_City']]['yata'] = $val['Arrival_Code'];
            $arrayRoute[$val['Arrival_City']]['cityNameEn'] = $val['Arrival_CityEn'];
        }
        //echo Load::plog($arrayRoute);

        $requestUrl = 'http://safar360.com/Core/Bus/';
        //$requestUrl = 'http://192.168.1.100/CoreTestDeveloper/Bus/';


        // wecan
        $data = [];
        $url = $requestUrl . "CitiesOrigin";
        $data['UserName'] = 'hijimbo';
        $data['Password'] = '123456';
        $dataJson = json_encode($data);
        $dataCitiesOrigin = functions::curlExecution($url, $dataJson, 'yes');
        //error_log(date('Y/m/d H:i:s') . ' dataCitiesOrigin  : ' . json_encode($dataCitiesOrigin) . " \n", 3, LOGS_DIR . 'log_cronJob_bus_wecan.txt');
        //echo Load::plog($dataCitiesOrigin);
        foreach ($dataCitiesOrigin as $cityOrigin) {
            $data = [];
            $url = $requestUrl . "CitiesDestinations";
            $data['UserName'] = 'hijimbo';
            $data['Password'] = '123456';
            $data['OriginName'] = $cityOrigin;
            $dataJson = json_encode($data);
            $dataCitiesDestinations = functions::curlExecution($url, $dataJson, 'yes');
            //error_log(date('Y/m/d H:i:s') . ' dataCitiesDestinations for origin: ' .$cityOrigin . ' : ' . json_encode($dataCitiesDestinations) . " \n", 3, LOGS_DIR . 'log_cronJob_bus_wecan.txt');
            //echo $cityOrigin . '<br>';
            //echo Load::plog($dataCitiesDestinations);
            if (!empty($dataCitiesDestinations)) {
                foreach ($dataCitiesDestinations as $cityDestinations) {
                    $dataInsert = [];

                    $sql = " SELECT id FROM bus_route_tb
                     WHERE 
                         Departure_City = '{$cityOrigin}' 
                         AND Arrival_City = '{$cityDestinations}' ";
                    //echo $sql . '<br>';
                    $checkRouteBus = $ModelBase->load($sql);
                    if (empty($checkRouteBus)) {

                        $dataInsert['Departure_City'] = $cityOrigin;
                        $dataInsert['Arrival_City'] = $cityDestinations;
                        if (isset($arrayRoute[$cityOrigin])) {
                            $dataInsert['Departure_City_En'] = $arrayRoute[$cityOrigin]['cityNameEn'];
                            $dataInsert['Departure_City_IataCode'] = $arrayRoute[$cityOrigin]['yata'];
                        }
                        if (isset($arrayRoute[$cityDestinations])) {
                            $dataInsert['Arrival_City_En'] = $arrayRoute[$cityDestinations]['cityNameEn'];
                            $dataInsert['Arrival_City_IataCode'] = $arrayRoute[$cityDestinations]['yata'];
                        }
                        echo 'insert:<br>';
                        echo Load::plog($dataInsert);

                        $ModelBase->setTable('bus_route_tb');
                        $res = $ModelBase->insertLocal($dataInsert);
                        echo 'result inert: ' . $res . '<br>';
                        error_log(date('Y/m/d H:i:s') . 'insert : ' . json_encode($dataInsert) . ' : ' . ' result: ' . $res . " \n", 3, LOGS_DIR . 'log_cronJob_bus.txt');
                    }
                }
                echo '<hr><hr>';
            }
        }



        // safar724
        $data = [];
        $url = $requestUrl . "Cities";
        $data['UserName'] = 'hijimbo';
        $data['Password'] = '123456';
        $dataJson = json_encode($data);
        $dataCities = functions::curlExecution($url, $dataJson, 'yes');
        //error_log(date('Y/m/d H:i:s') . ' dataCities  : ' . json_encode($dataCities) . " \n", 3, LOGS_DIR . 'log_cronJob_bus_safar724.txt');
        //echo Load::plog($dataCities);
        foreach ($dataCities as $val) {
            $arrayCities[$val['ID']] = $val;
        }


        $data = [];
        $url = $requestUrl . "Routes";
        $data['UserName'] = 'hijimbo';
        $data['Password'] = '123456';
        $dataJson = json_encode($data);
        $dataRoutes = functions::curlExecution($url, $dataJson, 'yes');
        //error_log(date('Y/m/d H:i:s') . ' dataRoutes  : ' . json_encode($dataRoutes) . " \n", 3, LOGS_DIR . 'log_cronJob_bus_safar724.txt');
        //echo Load::plog($dataRoutes);
        foreach ($dataRoutes as $val) {

            $dataUpdate = [];
            $dataInsert = [];
            if (isset($arrayCities[$val['From']]['Name']) && isset($arrayCities[$val['To']]['Name'])) {
                $sql = " SELECT id FROM bus_route_tb 
                     WHERE 
                         Departure_City = '{$arrayCities[$val['From']]['Name']}' 
                         AND Arrival_City = '{$arrayCities[$val['To']]['Name']}' ";
                $checkRouteBus = $ModelBase->load($sql);
                if (!empty($checkRouteBus)) {
                    $dataUpdate['Departure_City_Safar724_Id'] = $val['From'];
                    $dataUpdate['Arrival_City_Safar724_Id'] = $val['To'];
                    if (isset($arrayCities[$val['From']]['EnglishName']) && $arrayCities[$val['From']]['EnglishName'] != '') {
                        $dataUpdate['Departure_City_En'] = $arrayCities[$val['From']]['EnglishName'];
                    }
                    if (isset($arrayCities[$val['To']]['EnglishName']) && $arrayCities[$val['To']]['EnglishName'] != '') {
                        $dataUpdate['Arrival_City_En'] = $arrayCities[$val['To']]['EnglishName'];
                    }
                    echo 'update:<br>';
                    echo Load::plog($dataUpdate);

                    $Condition = " id = '{$checkRouteBus['id']}' ";
                    $ModelBase->setTable("bus_route_tb");
                    $res = $ModelBase->update($dataUpdate, $Condition);
                    error_log(date('Y/m/d H:i:s') . 'update : ' . json_encode($dataUpdate) . ' : ' . ' result: ' . $res . " \n", 3, LOGS_DIR . 'log_cronJob_bus.txt');


                } else {
                    $dataInsert['Departure_City'] = $arrayCities[$val['From']]['Name'];
                    $dataInsert['Arrival_City'] = $arrayCities[$val['To']]['Name'];
                    $dataInsert['Departure_City_Safar724_Id'] = $val['From'];
                    $dataInsert['Arrival_City_Safar724_Id'] = $val['To'];

                    if (isset($arrayRoute[$arrayCities[$val['From']]['Name']])) {
                        $dataInsert['Departure_City_En'] = $arrayRoute[$arrayCities[$val['From']]['Name']]['cityNameEn'];
                        $dataInsert['Departure_City_IataCode'] = $arrayRoute[$arrayCities[$val['From']]['Name']]['yata'];
                    }
                    if (isset($arrayRoute[$arrayCities[$val['To']]['Name']])) {
                        $dataInsert['Arrival_City_En'] = $arrayRoute[$arrayCities[$val['To']]['Name']]['cityNameEn'];
                        $dataInsert['Arrival_City_IataCode'] = $arrayRoute[$arrayCities[$val['To']]['Name']]['yata'];
                    }

                    if (isset($arrayCities[$val['From']]['EnglishName']) && $arrayCities[$val['From']]['EnglishName'] != '') {
                        $dataInsert['Departure_City_En'] = $arrayCities[$val['From']]['EnglishName'];
                    }
                    if (isset($arrayCities[$val['To']]['EnglishName']) && $arrayCities[$val['To']]['EnglishName'] != '') {
                        $dataInsert['Arrival_City_En'] = $arrayCities[$val['To']]['EnglishName'];
                    }

                    echo 'insert:<br>';
                    echo Load::plog($dataInsert);

                    $ModelBase->setTable('bus_route_tb');
                    $res = $ModelBase->insertLocal($dataInsert);
                    error_log(date('Y/m/d H:i:s') . 'insert : ' . json_encode($dataInsert) . ' : ' . ' result: ' . $res . " \n", 3, LOGS_DIR . 'log_cronJob_bus.txt');

                }
            } else {
                error_log(date('Y/m/d H:i:s') . ' Undefined  : ' . $val['From'] . ' - ' . $arrayCities[$val['From']]['Name'] . ' OR ' . $val['To'] . ' - ' . $arrayCities[$val['To']]['Name'] . " \n", 3, LOGS_DIR . 'log_cronJob_bus.txt');
            }
        }




        error_log('cronJob end : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_cronJob_bus.txt');
        //mail('tech@iran-tech.com', 'gds ecternal hotel cronJob', 'cronJob is working!');

    }


}

new getCityList();



?>
