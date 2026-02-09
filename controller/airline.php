<?php

class airline extends clientAuth
{

    public $nameFa = '';
    public $nameEn = '';
    public $abbreviation = '';
    public $tmpPhoto = '';
    public $namePhoto = '';
    public $deleteID;
    public $editID;
    public $ClientId;
    public $message = '';    //message that show after insert new airline or everything
    public $list = array();    //array that include list of airline
    public $listCientCharter = array();
    public $listCientSystem = array();
    public $clientActiveCharter = array();
    /**
     * @var array
     */
    public $ids;

    public function __construct()
    {
        parent::__construct();
        $this->ClientId = (isset($_GET['id'])) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : '';
    }


    #region [airlineList]
    public function airLineList()
    {
        return $this->getModel('airlineModel')->get(['id', 'name_fa', 'name_en', 'abbreviation', 'active' , 'foreignAirline'], true)->all();
    }
    public function airLineListJson()
    {
        $data = $this->getModel('airlineModel')
            ->get(['id', 'name_fa', 'name_en', 'abbreviation', 'active', 'foreignAirline'], true)
            ->all();

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
    #endregion

    public function geSpecificAirlineById($id)
    {
        return $this->getModel('airlineModel')->get()->where('id', $id)->find();
    }

    #region showEdit
    public function showEdit($id)
    {
        if (isset($id) && !empty($id)) {
            $result = $this->geSpecificAirlineById($id);
            if (!empty($result)) {
                $this->list = $result;
            } else {
                functions::redirectTo404InAdmin();
            }
        } else {
            functions::redirectTo404InAdmin();
        }
    }
    #endregion

    #region insert
    public function insert()
    {
        $airline = Load::model('airline');
        $result = $airline->insert($this->nameFa, $this->nameEn, $this->abbreviation, $this->namePhoto);
        if ($result) {
            $airlineID = $airline->getLastId();
            $counter = Load::model('counter_type');
            $discount = Load::model('discount');
            $listType = $counter->getAll('all');
            foreach ($listType as $val) {
                ($val['id'] == '0') ? ($discount->insert('50', $val['id'], $airlineID)) : ($discount->insert('0', $val['id'], $airlineID));
            }
            return true;
        } else {
            return false;
        }
    }
    #endregion


    #region getAll
    public function getAll()
    {
        $airline = Load::model('airline');
        $this->list = $airline->getAll();
    }

//    ================Airline iata codes ===========================
    public function getAllIataCodes()
    {
        $model = $this->getModel('airlineIataModel');
        $result = $model->get(['id','airline_name','airline_uniqe_iata'])->all();
        return $result;
    }
    public function add_airlineIata($params)
    {
        $data = array();
        $data['airline_name'] = $params['airline_name'];
        $data['airline_uniqe_iata'] = $params['airline_iata'];

        $model = $this->getModel('airlineIataModel');
        $result = $model->insertWithBind($data);
        return $result;
    }
    public function remove_airlineIata($params)
    {
        $id = $params['id'];
        $condition = " id = $id";

        $model = $this->getModel('airlineIataModel');
        $result = $model->delete($condition);
        return $result;
    }

    public function update_airlineIata($params)
    {
        $model = Load::model('airline');
        $data['airline_iata_id'] = $params['iata_id'];
        $airline_id = $params['airline_id'];
        $condition = "id = $airline_id";
        $result = $model->update($data,$condition);


        if( $result){
            return 'success:تنظیمات با موفقیت انجام شد';
        }else{
            return false;
        }
    }
//    ================Airline iata codes ===========================

//    ================Airline fare(کلاس نرخی) class ===========================
    public function getFareClasses()
    {
        $model =Load::library('ModelBase');
        $model->setTable('airline_fare_class_tb');
        $result = $model->get(['id','class_name'])->all();
        return $result;
    }
    public function add_airlineFareClass($param)
    {
        $data['class_name'] = $param['class_name'];
        $model =Load::library('ModelBase');
        $model->setTable('airline_fare_class_tb');
        $result = $model->insertWithBind($data);
        return $result;
    }
    public function remove_airlineFareClass($param)
    {
        $id = $param['id'];
        $model =Load::library('ModelBase');
        $condition = "id = $id";
        $model->setTable('airline_fare_class_tb');
        $result = $model->delete($condition);
        return $result;
    }


    //    ================Airline fare(کلاس نرخی) class ===========================
    //    ================Airline fine(جریمه) changes ============================
    public function add_airlineFine($params){
        $Model = load::library('ModelBase');
        $package_data['airline_iata_id'] = $params['airline_uniqe_iata'];
        $Model->setTable('airline_fine_package_tb');
        $last_package_id = $Model->insertWithBind($package_data);
        $fineData = $params['FineData'];
        $class_fare_ids = $params['class_fare_ids'];
        $result = $this->insert_fine_rate($last_package_id,$fineData,$class_fare_ids);
        if($result){
            return $this->returnJson(true, "پکیج نرخی با موفقیت اضافه گردید");
        }
        return  $this->returnJson(false, "عملیات با خطا مواجه شد",  null, 500);

    }
    public function edit_airlineFine($params){

        $package_id = $params['package_id'];
        $airline_uniqe_iata = $params['airline_uniqe_iata'];
        $data['airline_iata_id'] = $airline_uniqe_iata;
        $Model = load::library('ModelBase');
        $condition = "id = $package_id";
        $Model->setTable('airline_fine_package_tb');
        $Model->updateWithBind($data,$condition);
        $Model->setTable('airline_fine_percentage_tb');
        $condition = "fine_package_id = $package_id";
        $Model->delete($condition);
        $Model->setTable('airline_fine_class_fare_tb');
        $Model->delete($condition);
        $fineData = $params['FineData'];
        $class_fare_ids = $params['class_fare_ids'];
        $result = $this->insert_fine_rate($package_id,$fineData,$class_fare_ids);
        if($result){
            return $this->returnJson(true, "پکیج نرخی با موفقیت تغییر گردید");
        }
        return  $this->returnJson(false, "عملیات با خطا مواجه شد",  null, 500);
    }
    public function remove_airlineFine($param){
        $package_id = $param['id'];
        $data['status'] = 'disable';
        $Model = load::library('ModelBase');
        $condition = "id = $package_id";
        $Model->setTable('airline_fine_package_tb');
        $result =  $Model->updateWithBind($data,$condition);
        if($result){
            return $this->returnJson(true, "پکیج نرخی با موفقیت حذف گردید");
        }
        return  $this->returnJson(false, "عملیات با خطا مواجه شد",  null, 500);
    }
    private function insert_fine_rate($package_id,$fineData,$class_fare_ids){

        $Model = load::library('ModelBase');
        $result=[];
        foreach ($fineData as $fine){
            $Model->setTable('airline_fine_percentage_tb');

            $data = array();
            $data['fine_package_id'] = $package_id;
            if($fine['from_day_date'] != '')
            $data['from_day_date'] = $fine['from_day_date'] ;
            if($fine['from_hour_date'] != '')
            $data['from_hour_date'] = $fine['from_hour_date'] ;
            if($fine['until_day_date'] != '')
            $data['until_day_date'] = $fine['until_day_date'] ;
            if($fine['until_hour_date'] != '')
            $data['until_hour_date'] = $fine['until_hour_date'] ;
            if($fine['fine_percentage'] != '')
            $data['fine_percentage'] = $fine['fine_percentage'] ;

            $Model->insertWithBind($data);
        }
        foreach ($class_fare_ids as $class_fare_id){
            $Model->setTable('airline_fine_class_fare_tb');
            $nestedData = array();
            $nestedData['class_fare_id'] = $class_fare_id;
            $nestedData['fine_package_id'] = $package_id;
            $result = $Model->insertWithBind($nestedData);
        }
        return $result;
    }


    public function airlineFineList()
    {
        $Model = load::library('ModelBase');

        $sql = "
    SELECT
        afpt.id AS package_id,
        asi.id as airline_iata_id,
        asi.airline_name,
        asi.airline_uniqe_iata,
        afpt.status AS package_status,
        (
            SELECT CONCAT('[', GROUP_CONCAT(CONCAT(
                '{\"class_id\":', afct.id,
                ',\"class_name\":\"', REPLACE(afct.class_name, '\"', '\\\"'), '\"}'
            )), ']')
            FROM airline_fine_class_fare_tb afcft
            INNER JOIN airline_fare_class_tb afct 
                ON afct.id = afcft.class_fare_id
            WHERE afcft.fine_package_id = afpt.id
        ) AS fare_classes,
        (
            SELECT CONCAT('[', GROUP_CONCAT(CONCAT(
                '{\"from_day\":', IF(afpt2.from_day_date IS NULL, 'null', afpt2.from_day_date),
                ',\"from_hour\":', IF(afpt2.from_hour_date IS NULL, 'null', afpt2.from_hour_date),
                ',\"until_day\":', IF(afpt2.until_day_date IS NULL, 'null', afpt2.until_day_date),
                ',\"until_hour\":', IF(afpt2.until_hour_date IS NULL, 'null', afpt2.until_hour_date),
                ',\"fine_percentage\":', IF(afpt2.fine_percentage IS NULL, 'null', afpt2.fine_percentage),
                '}'
            )), ']')
            FROM airline_fine_percentage_tb afpt2
            WHERE afpt2.fine_package_id = afpt.id
        ) AS fine_percentages
    FROM airline_fine_package_tb afpt
    INNER JOIN airline_standard_iata asi 
        ON asi.id = afpt.airline_iata_id
    WHERE afpt.status = 'active'
    ORDER BY afpt.id DESC
    ";

        $result = $Model->select($sql);
        foreach ($result as &$row) {
            $row['fare_classes'] = json_decode($row['fare_classes'], true);
            $row['fine_percentages'] = json_decode($row['fine_percentages'], true);
        }

        return $result;
    }

    // توی کلاس airline یا یه متد جدید

    public function airlineFineListGroupedByTimeRanges() {
        $fineList = $this->airlineFineList();

        $grouped = [];

        foreach ($fineList as $item) {
            $timeRangeKeys = [];
            $seen = [];
            $uniquePercentages = [];

            foreach ($item['fine_percentages'] as $fp) {
                $rangeKey = sprintf(
                    "%d-%d-%d-%d",
                    (int)$fp['from_day'],
                    (int)$fp['from_hour'],
                    (int)$fp['until_day'],
                    (int)$fp['until_hour']
                );

                if (!isset($seen[$rangeKey])) {
                    $seen[$rangeKey] = true;
                    $uniquePercentages[] = $fp;
                    $timeRangeKeys[] = $rangeKey;
                }
            }

            // Merge consecutive same percentages
            $item['merged_percentages'] = $this->mergeConsecutivePercentages($uniquePercentages);
            $item['fine_percentages'] = $uniquePercentages;

            // حذف تکراری از fare_classes
            $seenClasses = [];
            $uniqueClasses = [];
            foreach ($item['fare_classes'] as $fc) {
                if (!isset($seenClasses[$fc['class_id']])) {
                    $seenClasses[$fc['class_id']] = true;
                    $uniqueClasses[] = $fc;
                }
            }
            $item['fare_classes'] = $uniqueClasses;

            sort($timeRangeKeys);
            $groupKey = implode('|', $timeRangeKeys);

            if (!isset($grouped[$groupKey])) {
                $grouped[$groupKey] = [
                    'time_ranges' => $uniquePercentages,
                    'items' => []
                ];
            }

            $grouped[$groupKey]['items'][] = $item;
        }


        return array_values($grouped);
    }

    /**
     * Merge consecutive percentages with same value
     */
    private function mergeConsecutivePercentages($percentages) {
        $merged = [];
        $i = 0;

        while ($i < count($percentages)) {
            $current = $percentages[$i];
            $colspan = 1;

            // Check consecutive items with same percentage
            while ($i + $colspan < count($percentages) &&
                (int)$percentages[$i + $colspan]['fine_percentage'] === (int)$current['fine_percentage']) {
                $colspan++;
            }

            $merged[] = [
                'fine_percentage' => $current['fine_percentage'],
                'is_tax_refund' => $current['is_tax_refund'],
                'colspan' => $colspan
            ];

            $i += $colspan;
        }

        return $merged;
    }
    public function getAirlineFineData($id)
    {
        if(!$id){
            return false;
        }
        $Model = load::library('ModelBase');
        $sql = "
    SELECT
        afpt.id AS package_id,
        asi.id as airline_iata_id,
        asi.airline_name,
        asi.airline_uniqe_iata,
        afpt.status AS package_status,
        (
            SELECT CONCAT('[', GROUP_CONCAT(CONCAT(
                '{\"class_id\":', afct.id,
                ',\"class_name\":\"', REPLACE(afct.class_name, '\"', '\\\"'), '\"}'
            )), ']')
            FROM airline_fine_class_fare_tb afcft
            INNER JOIN airline_fare_class_tb afct 
                ON afct.id = afcft.class_fare_id
            WHERE afcft.fine_package_id = afpt.id
        ) AS fare_classes,
        (
            SELECT CONCAT('[', GROUP_CONCAT(CONCAT(
                '{\"from_day\":', IF(afpt2.from_day_date IS NULL, 'null', afpt2.from_day_date),
                ',\"from_hour\":', IF(afpt2.from_hour_date IS NULL, 'null', afpt2.from_hour_date),
                ',\"until_day\":', IF(afpt2.until_day_date IS NULL, 'null', afpt2.until_day_date),
                ',\"until_hour\":', IF(afpt2.until_hour_date IS NULL, 'null', afpt2.until_hour_date),
                ',\"fine_percentage\":', IF(afpt2.fine_percentage IS NULL, 'null', afpt2.fine_percentage),
                '}'
            )), ']')
            FROM airline_fine_percentage_tb afpt2
            WHERE afpt2.fine_package_id = afpt.id
        ) AS fine_percentages
    FROM airline_fine_package_tb afpt
    INNER JOIN airline_standard_iata asi 
        ON asi.id = afpt.airline_iata_id
    WHERE afpt.status = 'active' And afpt.id = {$id}
    ORDER BY afpt.id DESC
    ";

        $result = $Model->select($sql);
        foreach ($result as &$row) {
            $row['fare_classes'] = json_decode($row['fare_classes'], true);
            $row['fine_percentages'] = json_decode($row['fine_percentages'], true);
        }
        return $result;
    }

    //    ================Airline fine(جریمه) changes ============================

    public function getAllDomestic($client_id)
    {
        $airline = Load::model('airline');
        $this->list = $airline->getAllDomestic($client_id); //6
        $this->ids = $this->arrayToSqlInClause($this->array_pluck($this->list, 'id'));
    }


    public function getAllForeign($client_id)
    {
        $airline = Load::model('airline');
        $this->list = $airline->getAllForeign($client_id);
        $this->ids = $this->arrayToSqlInClause($this->array_pluck($this->list, 'id'));
    }
    #endregion
//    function array_pluck(array $array, string $key): array
//    {
//        return array_map(function ($item) use ($key) {
//            return is_array($item) && array_key_exists($key, $item) ? $item[$key] : null;
//        }, $array);
//    }

// به خاطر این تابع بالا کامنت شد در لوکال فقط و پایینی به جاش نوشته شد که php لوکال ورژنش پایین تر از 7 هست و کد بالا خطا میده جایگزینش برای ورژن پایین تر کد پایینه این مشکل فقط در لوکال هست

    function array_pluck($array, $key)
    {
        return array_map(function ($item) use ($key) {
            return is_array($item) && array_key_exists($key, $item) ? $item[$key] : null;
        }, $array);
    }

    #region GetAirlineInfoCharter
    public function GetAirlineInfo($iata, $Type)
    {
        if (!empty($this->ClientId)) {
            $admin = Load::controller('admin');
            $sqlCharter = " SELECT id  FROM airline_client_tb WHERE $Type='active' AND airline_iata='{$iata}'";
            $airlineClientCharter = $this->getController('admin')->ConectDbClient($sqlCharter, $this->ClientId, "Select", "", "", "");

            if (!empty($airlineClientCharter)) {
                return 'ok';
            }
        }
    }
    #endregion

    #region GetConfigAirlineInfo

    //todo: Change it,Move it to its own class (configFlight)
    public function GetConfigAirlineInfo($clientID, $iataId, $typeFlight, $isInternal,$type)
    {
        $isInternal = ($isInternal == 'isInternal') ? '1' : '0';
        $type_pid = ($type == 'main') ? 'isPublic' : 'isPublicreplaced';


        if (!empty($clientID)) {
            $admin = Load::controller('admin');

            $sqlConfig = " SELECT {$type_pid}  FROM config_flight_tb WHERE airlineId='{$iataId}' AND typeFlight='{$typeFlight}' AND isInternal='{$isInternal}' ";
            $airlineClientConfig = $admin->ConectDbClient($sqlConfig, $clientID, "Select", "", "", "");

            if (!empty($airlineClientConfig)) {
                return ($airlineClientConfig[$type_pid] == '1') ? 'public' : 'private';
            }
            return null;
        }
    }
    #endregion


    #region GetStatusPid
    public function GetStatusPid($iata)
    {

        if (!empty($this->ClientId)) {
            $sqlCharter = " SELECT id  FROM airline_client_tb WHERE  airline_iata='{$iata}' AND pid_private='1'";
            $airlinClientCharter = $this->getController('admin')->ConectDbClient($sqlCharter, $this->ClientId, "Select", "", "", "");

            if (!empty($airlinClientCharter)) {
                return 'ok';
            }
        }
    }
    #endregion


    #region  [update]
    public function update()
    {
        $airline = Load::model('airline');
        return $airline->update($this->nameFa, $this->nameEn, $this->abbreviation, $this->namePhoto, $this->editID);
    }
    #endregion

    #region delete
    public function delete()
    {
        $airline = $this->getModel('airlineModel');
        $rec = $airline->get()->where('id', $this->deleteID)->find();
        $photo = $rec['photo'];
        if ($photo != '') {
            $destination_path = SITE_ROOT . '/pic/' . $photo;
            unlink($destination_path);
        }
        return $airline->delete($this->deleteID);
    }
    #endregion

    #region get
    /**
     * get one airline
     * @return information array
     */
    public function get($id = '')
    {
        $airline = Load::model('airline');
        if ($id == '') {
            $this->list = $airline->getById($this->editID);
        } else {
            return $airline->getById($id);
        }
    }
    #endregion

    #region active getActiveOption

    public function getActiveOption()
    {
        $airline = Load::model('airline');
        $result = $airline->getActiveOption();
        $str = "";
        foreach ($result as $rec) {
            $str .= "<option value='$rec[id]'>$rec[name_fa]</option>";
        }
        return $str;
    }
    #endregion

    #region active InsertAirline

    public function InsertAirline($data)
    {
        $airline = Load::model('airline');

        return $airline->InsertAirlineModel($data);
    }
    #endregion

    #region active UpdateAirline

    public function UpdateAirline($data)
    {
        $airline = Load::model('airline');

        return $airline->UpdateAirlineModel($data);
    }
    #endregion

    #region  ChangeStatus

    public function ChangeStatus($InfoAirline)
    {

//         print_r($InfoAirline);

        if (!empty($InfoAirline['ClientId'])) {

            $admin = Load::controller('admin');

            $sql = " SELECT * FROM airline_client_tb WHERE airline_iata='{$InfoAirline['iata']}'";
            $airlineClient = $admin->ConectDbClient($sql, $InfoAirline['ClientId'], "Select", "", "", "");
//            print_r($airlineClient);

            if (!empty($airlineClient)) {

                if ($InfoAirline['type'] == 'charter') {

                    if ($airlineClient['charter'] == 'active') {

                        $data['charter'] = 'inactive';
                        $data['last_edit_int'] = time();
                    } else {

                        $data['charter'] = 'active';
                        $data['last_edit_int'] = time();
                    }
                } else if ($InfoAirline['type'] == 'system') {

                    if ($airlineClient['system'] == 'active') {

                        $data['system'] = 'inactive';
                        $data['last_edit_int'] = time();
                    } else {

                        $data['system'] = 'active';
                        $data['last_edit_int'] = time();
                    }
                } else if ($InfoAirline['type'] == 'foreignAirline') {

                    if ($airlineClient['foreignAirline'] == 'active') {

                        $data['foreignAirline'] = 'inactive';
                        $data['last_edit_int'] = time();
                    } else {

                        $data['foreignAirline'] = 'active';
                        $data['last_edit_int'] = time();
                    }
                }

                $res = $admin->ConectDbClient("", $InfoAirline['ClientId'], "Update", $data, "airline_client_tb", "airline_iata='{$InfoAirline['iata']}'");
                if ($res) {
                    return 'success : وضعیت خطوط پروازی با موفقیت تغییر کرد';
                } else {
                    return 'error : خطا در تغییر وضعیت خطوط پروازی';
                }
            } else {

                if ($InfoAirline['type'] == 'charter') {
                    $data['charter'] = 'active';
                    $data['airline_iata'] = $InfoAirline['iata'];
                    $data['last_edit_int'] = time();
                } else if ($InfoAirline['type'] == 'system') {

                    $data['system'] = 'active';
                    $data['airline_iata'] = $InfoAirline['iata'];
                    $data['last_edit_int'] = time();
                } else if ($InfoAirline['type'] == 'foreignAirline') {

                    $data['foreignAirline'] = 'active';
                    $data['airline_iata'] = $InfoAirline['iata'];
                    $data['last_edit_int'] = time();

                }

                $res = $admin->ConectDbClient("", $InfoAirline['ClientId'], "Insert", $data, "airline_client_tb", "");
                if ($res) {
                    return 'success : وضعیت خطوط پروازی با موفقیت تغییر کرد';
                } else {
                    return 'error : خطا در تغییر وضعیت خطوط پروازی';
                }
            }
        } else {
            return 'error : خطا در شناسایی خطوط پروازی ';
        }
    }
    #endregion

    #region  changeStatusPid

    public function changeStatusPid($InfoAirline)
    {


        if (!empty($InfoAirline['ClientId'])) {

            $admin = Load::controller('admin');

            $sql = " SELECT * FROM airline_client_tb WHERE airline_iata='{$InfoAirline['iata']}'";
            $airlineClient = $admin->ConectDbClient($sql, $InfoAirline['ClientId'], "Select", "", "", "");
            if (!empty($airlineClient)) {

                if ($InfoAirline['type'] == 'private') {

                    if ($airlineClient['pid_private'] == '1') {

                        $data['pid_private'] = '0';
                        $data['last_edit_int'] = time();
                    } else {

                        $data['pid_private'] = '1';
                        $data['last_edit_int'] = time();
                    }
                }

                $res = $admin->ConectDbClient("", $InfoAirline['ClientId'], "Update", $data, "airline_client_tb", "airline_iata='{$InfoAirline['iata']}'");
                if ($res) {
                    return 'success : وضعیت خطوط پروازی با موفقیت تغییر کرد';
                } else {
                    return 'error : خطا در تغییر وضعیت خطوط پروازی';
                }
            } else {

                if ($InfoAirline['type'] == 'private') {
                    $data['pid_private'] = '1';
                    $data['airline_iata'] = $InfoAirline['iata'];
                    $data['last_edit_int'] = time();
                }

                $res = $admin->ConectDbClient("", $InfoAirline['ClientId'], "Insert", $data, "airline_client_tb", "");
                if ($res) {
                    return 'success : وضعیت خطوط پروازی با موفقیت تغییر کرد';
                } else {
                    return 'error : خطا در تغییر وضعیت خطوط پروازی';
                }
            }
        } else {
            return 'error : خطا در شناسایی خطوط پروازی ';
        }
    }
    #endregion

    #region  configPidAirline

    public function configPidAllAirlines($InfoAirline)
    {
//        $InfoAirline['ClientId'] = 6;
        if (!empty($InfoAirline['ClientId'])) {

            $isInternal = ($InfoAirline['isInternal'] == 'isInternal' ? '1' : '0');
            $type = ($InfoAirline['type'] == 'main') ? 'isPublic' : 'isPublicreplaced';
            $admin = Load::controller('admin');
            $ids = $this->sqlInClauseToArray($InfoAirline['iataIds']);
            $Condition = "typeFlight='{$InfoAirline['typeFlight']}' AND isInternal='{$isInternal}'";
            $sql = " SELECT * FROM config_flight_tb 
                     WHERE {$Condition}";

            $airlineClients = $admin->ConectDbClient($sql, $InfoAirline['ClientId'], "Select", "", "config_flight_tb", "");
//            if (!empty($airlineClients)) {
            if ($airlineClients[$type] == '1') {
                $dataAirline[$type] = '0';
            } elseif ($airlineClients[$type] == '0') {
                $dataAirline[$type] = '1';
            }
            $resultUpdate = $admin->ConectDbClient("", $InfoAirline['ClientId'], "Update", $dataAirline, "config_flight_tb", $Condition);
            if ($resultUpdate) {
                return 'success:تنظیمات با موفقیت ویرایش شد';
            }
            return 'error:خطا در ویرایش تنظیمات ';
//            } else {
//                foreach ($ids as $iataid) {
//
//                    $data['airlineId'] = $iataid;
//                    $data['isPublic'] = ($InfoAirline['isPublic'] == 'public' ? '1' : '0');
//                    $data['typeFlight'] = $InfoAirline['typeFlight'];
//                    $data['isInternal'] = $isInternal;
//
//                    $resultInsert = $admin->ConectDbClient('', $InfoAirline['ClientId'], "Insert", $data, "config_flight_tb", $Condition);
//
//                    if ($resultInsert) {
//                        $dataLog['airlineId'] = $iataid;
//                        $dataLog['action'] = "statusPid";
//                        $dataLog['valueAction'] = ($data['isPublic'] == '0') ? 'private' : 'public';
//                        $dataLog['typeFlight'] = $InfoAirline['typeFlight'];
//                        $dataLog['isInternal'] = $isInternal;
//                        $dataLog['creationDateInt'] = time();
//                        $admin->ConectDbClient('', $InfoAirline['ClientId'], "Insert", $dataLog, "log_config_airline_tb", "");
//                        return 'success:تنظیمات با موفقیت انجام شد';
//                    }
//                    return 'error:خطا در تنظیمات';
//                }
//            }
        }
    }

    public function configPidAirline($InfoAirline)
    {

        if (!empty($InfoAirline['ClientId'])) {

            $isInternal = ($InfoAirline['isInternal'] == 'isInternal' ? '1' : '0');
            $type = ($InfoAirline['type'] == 'main') ? 'isPublic' : 'isPublicreplaced';
            $admin = Load::controller('admin');

            $Condition = "airlineId='{$InfoAirline['iataId']}' 
                     AND typeFlight='{$InfoAirline['typeFlight']}' 
                     AND isInternal='{$isInternal}'";
            $sql = " SELECT * FROM config_flight_tb 
                     WHERE {$Condition}";
            $airlineClient = $admin->ConectDbClient($sql, $InfoAirline['ClientId'], "Select", "", "", "");

            if (!empty($airlineClient)) {
                if ($airlineClient[$type] == '1') {
                    $dataAirline[$type] = '0';
                } elseif ($airlineClient[$type] == '0') {
                    $dataAirline[$type] = '1';
                }
                $resultUpdate = $admin->ConectDbClient("", $InfoAirline['ClientId'], "Update", $dataAirline, "config_flight_tb", $Condition);

                if ($resultUpdate) {
                    $dataLog['airlineId'] = $InfoAirline['iataId'];
                    $dataLog['action'] = "statusPid";
                    $dataLog['valueAction'] = ($dataAirline[$type] == '0') ? 'private' : 'public';
                    $dataLog['typeFlight'] = $InfoAirline['typeFlight'];
                    $dataLog['isInternal'] = $isInternal;
                    $dataLog['creationDateInt'] = time();
                    $admin->ConectDbClient('', $InfoAirline['ClientId'], "Insert", $dataLog, "log_config_airline_tb", "");
                    return 'success:تنظیمات با موفقیت ویرایش شد';
                }
                return 'error:خطا در ویرایش تنظیمات ';
            } else {

                $data['airlineId'] = $InfoAirline['iataId'];
                $data['isPublic'] = ($InfoAirline['isPublic'] == 'public' ? '1' : '0');
                $data['typeFlight'] = $InfoAirline['typeFlight'];
                $data['isInternal'] = $isInternal;

                $resultInsert = $admin->ConectDbClient('', $InfoAirline['ClientId'], "Insert", $data, "config_flight_tb", "");

                if ($resultInsert) {
                    $dataLog['airlineId'] = $InfoAirline['iataId'];
                    $dataLog['action'] = "statusPid";
                    $dataLog['valueAction'] = ($data['isPublic'] == '0') ? 'private' : 'public';
                    $dataLog['typeFlight'] = $InfoAirline['typeFlight'];
                    $dataLog['isInternal'] = $isInternal;
                    $dataLog['creationDateInt'] = time();
                    $admin->ConectDbClient('', $InfoAirline['ClientId'], "Insert", $dataLog, "log_config_airline_tb", "");
                    return 'success:تنظیمات با موفقیت انجام شد';
                }
                return 'error:خطا در تنظیمات';
            }


        }
    }
    #endregion

    #region  getServerConfigFlight
    public function getServerConfigFlight($clientId, $airlineId, $typeFlight, $isInternal, $sourceId, $replace = null)
    {
        $isInternal = ($isInternal == 'isInternal' ? '1' : '0');
        $admin = Load::controller('admin');

        $Condition = "airlineId='{$airlineId}' 
                     AND typeFlight='{$typeFlight}' 
                     AND isInternal='{$isInternal}'
                   ";
        if (empty($replace)) {
            $Condition .= " AND  sourceId='{$sourceId}' ";

        } else if (!empty($replace) && $replace == 'replace') {
            $Condition .= " AND sourceReplaceId='{$sourceId}' ";
        }
        $sql = " SELECT * FROM config_flight_tb
                     WHERE {$Condition} ";
        $airlineClient = $admin->ConectDbClient($sql, $clientId, "Select", "", "", "");

        if (!empty($airlineClient)) {
            return true;
        }
        return false;

    }
    #endregion

    #region selectServer
    public function selectServer($InfoAirline)
    {
        if (!empty($InfoAirline['ClientId'])) {

            $isInternal = ($InfoAirline['isInternal'] == 'isInternal' ? '1' : '0');
            $admin = Load::controller('admin');

            $Condition = "airlineId='{$InfoAirline['iataId']}' 
                     AND typeFlight='{$InfoAirline['typeFlight']}' 
                     AND isInternal='{$isInternal}' ";
            $sql = " SELECT * FROM config_flight_tb 
                     WHERE {$Condition}";
            $airlineClient = $admin->ConectDbClient($sql, $InfoAirline['ClientId'], "Select", "", "", "");

            if (!empty($airlineClient)) {

                if (!empty($InfoAirline['replace']) && $InfoAirline['replace'] == 'replace') {
                    $dataAirline['sourceReplaceId'] = $InfoAirline['serverId'];
                } else {
                    $dataAirline['sourceId'] = $InfoAirline['serverId'];
                }
                $resultUpdate = $admin->ConectDbClient("", $InfoAirline['ClientId'], "Update", $dataAirline, "config_flight_tb", $Condition);

                if ($resultUpdate) {
                    $dataLog['airlineId'] = $InfoAirline['iataId'];
                    $dataLog['action'] = (isset($dataAirline['sourceReplaceId']) && !empty($dataAirline['sourceReplaceId'])) ? 'alternativeServer' : "chooseServer";
                    $dataLog['valueAction'] = $InfoAirline['serverId'];
                    $dataLog['typeFlight'] = $InfoAirline['typeFlight'];
                    $dataLog['isInternal'] = $isInternal;
                    $dataLog['creationDateInt'] = time();
                    $admin->ConectDbClient('', $InfoAirline['ClientId'], "Insert", $dataLog, "log_config_airline_tb", "");
                    return 'success:تنظیمات با موفقیت ویرایش شد';
                }
                return 'error:خطا در ویرایش تنظیمات ';
            }

            return 'error:خطا در تنظیمات';
        }
        return 'error:خطا در تنظیمات';
    }

    public function selectAllServers($InfoAirline)
    {
//        $InfoAirline['ClientId'] = 6;
        if (!empty($InfoAirline['ClientId'])) {
            $isInternal = ($InfoAirline['isInternal'] == 'isInternal' ? '1' : '0');
            $admin = Load::controller('admin');
            $ids = trim($InfoAirline['iataIds'], "'");
            $Condition = "typeFlight='{$InfoAirline['typeFlight']}' AND isInternal='{$isInternal}' AND airlineId IN ({$InfoAirline['iataIds']}) ";
            $sql = " SELECT * FROM config_flight_tb 
                     WHERE {$Condition}";
            $airlineClients = $admin->ConectDbClient($sql, $InfoAirline['ClientId'], "Select", "", "", "");

            if (!empty($airlineClients)) {

                if (!empty($InfoAirline['replace']) && $InfoAirline['replace'] == 'replace') {
                    $dataAirline['sourceReplaceId'] = $InfoAirline['serverId'];
                } else {
                    $dataAirline['sourceId'] = $InfoAirline['serverId'];
                }
                $resultUpdate = $admin->ConectDbClient("", $InfoAirline['ClientId'], "Update", $dataAirline, "config_flight_tb", $Condition);

                if ($resultUpdate) {
                    return 'success:تنظیمات با موفقیت ویرایش شد';
                }
                return 'error:خطا در ویرایش تنظیمات ';
            }

            return 'error:خطا در تنظیمات';
        }
        return 'error:خطا در تنظیمات';
    }
    #endregion
    #region logConfigAirline

    public function logConfigAirline($param)
    {
        $admin = Load::controller('admin');

        $sql = " SELECT * FROM log_config_airline_tb WHERE airlineId='{$param['airlineId']}' ";
        $airlineLogClient = $admin->ConectDbClient($sql, $param['ClientId'], "SelectAll", "", "", "");

        if (!empty($airlineLogClient)) {
            return $airlineLogClient;
        }

        return null;
    }
    #endregion

    #region checkTypeAirline

    public function checkTypeAirline($flightType, $airline)
    {

        $resultSql = $this->getModel('airlineClientModel')->get(['`charter`','`system`'],true)->where('airline_iata',$airline)->find();

        if (($flightType == 'charter' && ($resultSql['charter'] == 'active')) || ($flightType == 'system' && ($resultSql['system'] == 'active'))) {
            return true;
        }
        return false;
    }
    #endregion

    #region checkSourceAirline

    public function checkSourceAirline($param)
    {
        $ModelDb = Load::library('Model');
        $airline = $this->getByAbb($param['airline']);
        $isInternal = (($param['isInternal'] == 'isInternal') || ($param['IsInternal']=='1')) ? '1' : '0';
        $sql = "SELECT * FROM config_flight_tb where airlineId = '{$airline['id']}' AND typeFlight='{$param['flightType']}' AND isInternal='{$isInternal}'";
        $resultSql = $ModelDb->load($sql,'assoc');
        if (isset($param['info']) && $param['info'] == 'completed') {
            if ($resultSql['sourceId'] == '1') {
                return true;
            }
            return false;
        }
        if (isset($param['info']) && $param['info'] == 'charter724') {
            if ($resultSql['sourceId'] == '8' || $resultSql['sourceReplaceId'] == '8') {
                return true;
            }
            return false;
        }
        if (!empty($resultSql)) {
            return  $resultSql ;
        }
    }
    #endregion

    //region [listConfigAirline]
    /**
     * @param $type
     * @return array
     */
    public function listConfigAirline($type)
    {

		$type = ($type) ? '1' : '0' ;
		$configs_final = array();
		$configs_airline = array();
		$airlines = $this->airLineList();
        $configs =$this->getModel('configFlightModel')->get()->where('isInternal',$type)->all();

        foreach ($configs as $config) {
            $configs_airline[$config['airlineId']][] = $config;
        }

        foreach ($airlines as $key => $airline) {
            $configs = $configs_airline[$airline['id']];
            foreach ($configs as $key_config => $config) {
                $configs_final[$config['typeFlight']][$airline['abbreviation']] = $config;
            }
        }


        return $configs_final;
    }
    //endregion

    #region [getByAbb]

    /**
     * @param $abbreviation
     * @return mixed
     */
    public function getByAbb($abbreviation)
    {
        return $this->getModel('airlineModel')->get()->where('abbreviation', $abbreviation)->find();
    }

    public function getAllByIds($ids)
    {

        return $this->getModel('airlineModel')->get()->whereIn('id', $this->sqlInClauseToArray($ids))->all();
    }
    public function getAllAirlines()
    {

        return $this->getModel('airlineModel')->get()->all();
    }

    #endregion

//    function arrayToSqlInClause(array $numbers): string
//    {
//        $sanitized = array_filter($numbers, function ($n) {
//            return is_numeric($n);
//        });
//
//        $casted = array_map(function ($n) {
//            return (int)$n;
//        }, $sanitized);
//
//        $inClause = implode(',', $casted);
//
//        return "'(" . $inClause . ")'";
//    }

// به خاطر این تابع بالا کامنت شد در لوکال فقط و پایینی به جاش نوشته شد که php لوکال ورژنش پایین تر از 7 هست و کد بالا خطا میده جایگزینش برای ورژن پایین تر کد پایینه این مشکل فقط در لوکال هست


    function arrayToSqlInClause($numbers)
    {
        $sanitized = array_filter($numbers, function ($n) {
            return is_numeric($n);
        });

        $casted = array_map(function ($n) {
            return (int)$n;
        }, $sanitized);

        $inClause = implode(',', $casted);

        return "'(" . $inClause . ")'";
    }



//    function sqlInClauseToArray(string $inClause): array
//    {
//        $trimmed = trim($inClause, '()');
//
//        $items = array_map('trim', explode(',', $trimmed));
//
//        return array_map('intval', $items);
//    }

// به خاطر این تابع بالا کامنت شد در لوکال فقط و پایینی به جاش نوشته شد که php لوکال ورژنش پایین تر از 7 هست و کد بالا خطا میده جایگزینش برای ورژن پایین تر کد پایینه این مشکل فقط در لوکال هست


    function sqlInClauseToArray($inClause)
    {
        $trimmed = trim($inClause, '()');

        $items = array_map('trim', explode(',', $trimmed));

        return array_map('intval', $items);
    }

    function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        return json_encode([
            'success' => $success,
            'message' => $message,
            'code' => $statusCode,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    function UpdateCommissionAirline($airline)
    {
        $airlineModel = $this->getModel('airlineModel');

        if ($airline['route'] == 'Commission_internal') {
            $Commission = array(
                'Commission_internal' => $airline['Commission'] / 100
            );
        } elseif ($airline['route'] == 'Commission_external') {
            $Commission = array(
                'Commission_external' => $airline['Commission'] / 100
            );
        }
        $condition = " abbreviation='" . $airline['AirlineIata'] . "'";

        $listUpload = $airlineModel->update($Commission,$condition);

        if ($listUpload) {
            return $this->returnJson(true, "کمیسیون ایرلاین ".$airline['AirlineIata']." با موفقیت انجام شد");
        } else {
            return $this->returnJson(false, "عملیات با خطا مواجه شد",  null, 500);
        }
    }

    function UpdateTerminalAirline($airline)
    {
        $airlineModel = $this->getModel('airlineModel');

        if ($airline['route'] == 'enter_thr') {
            $terminal = array(
                'enter_thr' => $airline['Terminal']
            );
        } elseif ($airline['route'] == 'out_thr') {
            $terminal = array(
                'out_thr' => $airline['Terminal']
            );
        }elseif ($airline['route'] == 'enter_ika') {
            $terminal = array(
                'enter_ika' => $airline['Terminal']
            );
        }elseif ($airline['route'] == 'out_ika') {
            $terminal = array(
                'out_ika' => $airline['Terminal']
            );
        }
        $condition = " abbreviation='" . $airline['AirlineIata'] . "'";
        $listUpload = $airlineModel->update($terminal,$condition);

        if ($listUpload) {
            return $this->returnJson(true, "ترمینال ایرلاین ".$airline['AirlineIata']." با موفقیت انجام شد");
        } else {
            return $this->returnJson(false, "عملیات با خطا مواجه شد",  null, 500);
        }
    }

    function UpdateAmadeusStatusAirline($airline) {

        $airlineModel = $this->getModel('airlineModel');

        $amadeusStatus = $airline['amadeusStatus'];
        if (is_null($amadeusStatus) || $amadeusStatus === null || $amadeusStatus === '') {
            $data = array(
                'amadeusStatus' => null
            );
        } else {
            $data = array(
                'amadeusStatus' => $amadeusStatus
            );
        }

        $condition = " abbreviation='" . $airline['AirlineIata'] . "'";

        $updateAmadeusStatus = $airlineModel->update($data, $condition);

        if ($updateAmadeusStatus) {
            return self::returnJson(true, "وضعیت آمادئوس ایرلاین ". $airline['AirlineIata'] ." با موفقیت تغییر یافت", null , 200);
        } else {
            return self::returnJson(false, "عملیات با خطا مواجه شد", null, 400);
        }
    }

    function getAirlineDetailByCode($code) {
        $airlineModel = $this->getModel('airlineModel');
        $Logo = $airlineModel->get(['photo' , 'name_fa'], true)->where('abbreviation', $code)->find();
        return $Logo;
    }

    function isForeignAirline($iata)
    {
        $airlineModel = $this->getModel('airlineModel');
        $resultForeignAirline = $airlineModel
            ->get(array('foreignAirline'), true)
            ->where('abbreviation', $iata)
            ->find();
        return ($resultForeignAirline['foreignAirline'] == 'inactive') ? false : true;
    }

}

