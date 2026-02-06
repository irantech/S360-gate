<?php
require '../../config/bootstrap.php';
require CONFIG_DIR . 'configBase.php';
//require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));

class getAllStation
{

    public function __construct()
    {
        $this->getSuccessRecords();
    }

    public function getSuccessRecords()
    {
        error_log('cronjob start : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_cronjob_europcar.txt');

        $date_time_update = dateTimeSetting::jdate("Y-m-d h:i:sa",time(),'' ,'', 'en');

        $apiLink = 'http://webs.europcar.ir/desktopmodules/carrental/CarRental.asmx?wsdl';
        $apiSoap = new SoapClient($apiLink);

        $apiData = array(
            'username' => 'irantech',
            'password' => 'iran123'
        );

        $object = $apiSoap->GetStations($apiData);
        $stations = json_decode(json_encode($object), true);
        error_log('get stations : ' . date('Y/m/d H:i:s') . ' result: ' . $stations['message'] . " \n", 3, LOGS_DIR . 'log_cronjob_europcar.txt');

        if ($stations['message'] == 'Successful'){

            foreach ($stations['GetStationsResult']['Station'] as $station) {

                $d['stations_id'] = $station['Id'];
                $d['name'] = $station['Name'];
                $d['code'] = $station['Code'];
                $d['active'] = $station['Active'];
                $d['state'] = $station['State'];
                $d['city'] = $station['City'];
                $d['email'] = $station['Email'];
                $d['phone1'] = $station['Phone1'];
                $d['phone2'] = $station['Phone2'];
                $d['fax'] = $station['Fax'];
                $d['typeId'] = $station['TypeId'];
                $d['airportChargeCost'] = $station['AirportChargeCost'];
                $d['hasWelcoming'] = $station['HasWelcoming'];
                $d['hasDriverServices'] = $station['HasDriverServices'];
                $d['hasReturns'] = $station['HasReturns'];
                $d['returnsCost'] = $station['ReturnsCost'];
                $d['latitude'] = $station['Latitude'];
                $d['longitude'] = $station['Longitude'];
                $d['worktime'] = $station['Worktime'];
                $d['additionalWorktime'] = $station['AdditionalWorktime'];
                $d['isDeleted'] = $station['IsDeleted'];
                $d['engState'] = $station['EngState'];
                $d['engName'] = $station['EngName'];
                $d['engCity'] = $station['EngCity'];
                $d['orderNo'] = $station['OrderNo'];
                $d['serviceType'] = $station['ServiceType'];
                /*$d['type_id'] = $station['Type']['Id'];
                $d['type_Name'] = $station['Type']['Name'];
                $d['type_TypeId'] = $station['Type']['TypeId'];
                $d['type_ValueOrder'] = $station['Type']['ValueOrder'];
                $d['type_Active'] = $station['Type']['Active'];
                $d['type_IsDeleted'] = $station['Type']['IsDeleted'];
                $d['type_Description'] = $station['Type']['Description'];
                $d['type_EngName'] = $station['Type']['EngName'];*/
                $d['date_time_update'] = $date_time_update;

                Load::autoload('ModelBase');
                $ModelBase = new ModelBase();

                $sql = "SELECT * FROM europcar_stations_tb WHERE stations_id='{$station['Id']}' ";
                $result = $ModelBase->load($sql);

                if (empty($result)) {

                    $ModelBase->setTable('europcar_stations_tb');
                    $res = $ModelBase->insertLocal($d);

                    error_log('insert stations : ' . date('Y/m/d H:i:s') . ' result: ' . $res . " \n", 3, LOGS_DIR . 'log_cronjob_europcar.txt');

                } else {

                    $Condition = "stations_id='{$station['Id']}'";
                    $ModelBase->setTable("europcar_stations_tb");
                    $res = $ModelBase->update($d, $Condition);

                    error_log('update stations : ' . date('Y/m/d H:i:s') . ' result: ' . $res . " \n", 3, LOGS_DIR . 'log_cronjob_europcar.txt');
                }

            }

        }



        error_log('cronjob end : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_cronjob_europcar.txt');
        mail('tech@iran-tech.com','gds europcar cronjob','cronjob is working!');

    }
    

}

//new getAllStation();

?>
