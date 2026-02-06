<?php

//if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}

/**
 * Class busPanel
 * @property busPanel $busPanel
 */
class busPanel extends clientAuth
{
    public function __construct() {
        parent::__construct();
    }

    public function updateBusCities($param) {

        $ModelBase = Load::library('ModelBase');

        if ($param['dataName'] === 'iataCode') {
            if (!$this->CheckIataExistence($param['dataValue'], $ModelBase)) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'کد تکراری !'
                ], true);
            }

        }
        $data[$param['dataName']] = $param['dataValue'];
        $condition = " id = '{$param['dataId']}' ";
        $ModelBase->setTable("bus_route_tb");
        $resUpdate = $ModelBase->update($data, $condition);
        if ($resUpdate) {
            return json_encode([
                'status' => 'success',
                'message' => 'انجام شد'
            ], true);
        }

        return json_encode([
            'status' => 'error',
            'message' => 'خطا خورد!'
        ], true);
    }

    /**
     * @param $param
     * @param $ModelBase
     * @return bool|string[]
     */
    public function CheckIataExistence($param, $ModelBase) {
        $sqlCheck = "SELECT * FROM bus_route_tb WHERE iataCode = '" . $param . "'";
        $result = $ModelBase->select($sqlCheck);
        if ($result) {
            return false;
        }

        return true;
    }

    public function insertBaseCompanyBus($param) {
        $ModelBase = Load::library('ModelBase');

        $sql = "SELECT id FROM base_company_bus_tb WHERE type_vehicle = '{$param['type_vehicle']}' AND name_fa = '{$param['name_fa']}' AND is_del = 'no'";
        $result = $ModelBase->load($sql);
        if (empty($result)) {
            $data['type_vehicle'] = 'bus';
            $data['client_id'] = CLIENT_ID;
            if (isset($param['type_vehicle'])) {
                $data['type_vehicle'] = $param['type_vehicle'];
            }
            if (isset($param['iata_code'])) {
                $data['iata_code'] = $param['iata_code'];
            }
            if (TYPE_ADMIN == '1') {
                $data['client_id'] = 0;
            }
            $data['name_fa'] = $param['name_fa'];
            $data['name_en'] = $param['name_en'];
            $data['is_del'] = 'no';

            if (isset($_FILES['pic']) && $_FILES['pic'] != "") {

                $config = Load::Config('application');
                $config->pathFile('companyBusImages/');
                $result = $config->UploadFile("pic", "pic", "");
                $explodeResult = explode(':', $result);

                if ($explodeResult[0] == "done") {
                    $data['logo'] = $explodeResult[1];
                } else {
                    $data['logo'] = '';
                }

            } else {
                $data['logo'] = '';
            }

            $ModelBase->setTable("base_company_bus_tb");
            $res = $ModelBase->insertLocal($data);

            if ($res) {
                return 'success :  تغییرات با موفقیت انجام شد';
            } else {
                return 'error : خطا در  تغییرات';
            }

        } else {
            return 'error : شرکت مسافربری ' . $param['name_fa'] . ' قبلا ثبت شده است.';
        }
    }

    public function array_reindex($array, $start_index)
    {
        $re_indexed=[];
        foreach ($array as $key=>$item){
            $re_indexed[]=$item;
        }

        return $re_indexed;
    }

    public function updateBaseCompanyBus($param)
    {

        $ModelBase = Load::library('ModelBase');

        $data['name_fa'] = $param['name_fa'];
        $data['name_en'] = $param['name_en'];
        if (isset($param['type_vehicle'])) {
            $data['type_vehicle'] = $param['type_vehicle'];
        }
        if (isset($param['iata_code'])) {
            $data['iata_code'] = $param['iata_code'];
        }

        if (isset($_FILES['pic']) && $_FILES['pic'] != "") {

            $config = Load::Config('application');
            $config->pathFile('companyBusImages/');
            $result = $config->UploadFile("pic", "pic", "");
            $explodeResult = explode(':', $result);

            if ($explodeResult[0] == "done") {
                $data['logo'] = $explodeResult[1];
            }

        }

        $condition = "id='{$param['id']}' ";
        $ModelBase->setTable("base_company_bus_tb");
        $res = $ModelBase->update($data, $condition);

        if ($res) {
            return 'success :  تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در  تغییرات';
        }

    }

    public function insertBusCompany($param) {
        $ModelBase = Load::library('ModelBase');

        $sql = "SELECT id FROM company_bus_tb WHERE name_fa = '{$param['name_fa']}' AND is_del = 'no'";
        $result = $ModelBase->load($sql);
        if (empty($result)) {

            $data['name_fa'] = $param['name_fa'];
            $data['id_base_company'] = $param['id_base_company'];
            $data['is_del'] = 'no';

            $ModelBase->setTable("company_bus_tb");
            $res = $ModelBase->insertLocal($data);

            if ($res) {
                return 'success :  تغییرات با موفقیت انجام شد';
            } else {
                return 'error : خطا در  تغییرات';
            }

        } else {
            return 'error : شرکت مسافربری ' . $param['name_fa'] . ' قبلا ثبت شده است.';
        }
    }

    public function updateBusCompany($param) {

        $ModelBase = Load::library('ModelBase');

        $data['name_fa'] = $param['name_fa'];

        $condition = "id='{$param['id']}' ";
        $ModelBase->setTable("company_bus_tb");
        $res = $ModelBase->update($data, $condition);

        if ($res) {
            return 'success :  تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در  تغییرات';
        }

    }

    public function logicalDeletion($info) {

        $ModelBase = Load::library('ModelBase');

        $data['is_del'] = 'yes';

        $condition = "id='{$info['id']}'";
        $ModelBase->setTable($info['tableName']);
        $res = $ModelBase->update($data, $condition);

        if ($res) {
            return 'success : حذف تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در حذف تغییرات';
        }
    }

    public function select2BusRouteSearch($param) {
        $result = functions::searchBusCities($param);
        foreach ($result as $item) {
            $finalResult['results'][] = [
                'id' => $item['iataCode'],
                'text' => $item['name_fa'],
            ];
        }
        $finalResult['pagination'] = [
            'more' => false
        ];
        return json_encode($finalResult, true);
    }

    public function getBaseCompanyBus() {
        return $this->getController('baseCompanyBus')->getData();
    }

    public function getStations($params = null) {
        $city_id = null;
        if (isset($params['city_id']) && $params['city_id'] !== '') {
            $city_id = $params['city_id'];
        }
        $stations = $this->getController('stationReservationBus')->getData();
        $cities = $this->getCities(['id', 'name_fa'], $city_id);

        $founded_stations = [];
        foreach ($stations as $key => $station) {
            foreach ($cities as $city) {
                if ($city['id'] == $station['city_id']) {
                    $station['city_name'] = $city['name_fa'];
                    $founded_stations[$key] = $station;
                }
            }
        }

        return $this->array_reindex($founded_stations, 0);
    }

    public function getCities($get, $city = null) {
        $cities = $this->getModel('busRouteModel')->get($get);
        if ($city) {
            $cities = $cities->where('id', $city);
        }
        return $cities->all();
    }


    public function getChairsArray() {
        return [
            '13',
            '14',
            '15',
            '16',
            '25',
            '26',
            '29',
            '30',
            '44',
            '60',
        ];
    }

    public function newReservationBus($params) {


        return $this->getController('reservationBus')->store($params['params']);
    }

    public function updateReservationBus($params) {
        return $this->getController('reservationBus')->update($params['params']);
    }

    public function deleteReservationBus($param) {

        return $this->getController('reservationBus')->delete($param['id']);
    }

    public function createNewStation($params) {
        return $this->getController('stationReservationBus')->store($params);
    }

    public function updateStation($params) {
        return $this->getController('stationReservationBus')->update($params);
    }

    public function removeStation($params) {
        return $this->getController('stationReservationBus')->remove($params);
    }

    public function hasAccessToBusReservation() {
        return $this->getController('reservationBus')->hasAccessToBusReservation();
    }

    public function getBusReservationData($params) {

        if ($params['cityOrigin'] && $params['cityDestination']) {
            $params['cityOrigin'] = $this->getCityByIataCode('id', $params['cityOrigin'])['id'];
            $params['cityDestination'] = $this->getCityByIataCode('id', $params['cityDestination'])['id'];
        }
        return $this->getController('reservationBus')->getData($params);
    }

    public function getCityByIataCode($get, $iata) {
        $cities = $this->getModel('busRouteModel')->get($get);

        $cities = $cities->where('iataCode', $iata);

        return $cities->find();
    }

    public function getBusCompanies() {
        return $this->getModel('baseCompanyBusModel')->get()
            ->where('is_del', 'no')
            ->where('type_vehicle', 'bus')
            ->where('client_id', CLIENT_ID)
            ->all();
    }
}