<?php

class reservationPublicFunctions extends clientAuth {

    public $id = '';
    public $listCountry = '';
    public $listFly = '';
    public $minutes = '';
    public $hours = '';
    public $listCounter = array();
    public $listOtherCounter = array();
    public $arr_ticket = array();
    public $is_same = '';
    public $type_user = '';
    public $maximum_buy = '';


    public function __construct() {
        parent::__construct();
    }


    public function format_Date($date)
    {
        $y = substr($date,0,4);
        $m = substr($date,4,2);
        $d = substr($date,6,2);

        $date = $y.'/'.$m.'/'.$d;

        return $date;
    }


    /////////////////برای نمایش زمان حرکت بصورت مجزا/////////////////
    public function explodeTime($val) {
        $result = explode(":", $val);
        $this->hours = $result[0];
        $this->minutes = $result[1];

    }


    /////لیست کامل کانترها/////
    public function getAllCounter($type = '') {

        $counter = Load::model('counter_type');
        if ($type == '') {
            $this->listCounter = $counter->getAll();
        } else {
            $this->listCounter = $counter->getAll('all');
        }
    }


    /////////////////برای نمایش نام فیلد مورد نظر از جدول انتخابی براساس id/////////////////
    public function ShowName($table, $id, $field = '') {

        $Model = Load::library('Model');

        $sql = "SELECT * FROM {$table} WHERE id='{$id}'";
        $result = $Model->Load($sql);

        if ($field!=''){
            $name = $result[$field];
        }else{
            if (SOFTWARE_LANG == 'fa'){
                $name = $result['name'];
            }else {
                if ($result['name_en']){
                    $name = $result['name_en'];
                }else {
                    $name = $result['name'];
                }

            }

        }

        return $name;

    }

    /////////////////برای نمایش نام فیلد مورد نظر از جدول انتخابی براساس id/////////////////
    public function ShowNameBase($table, $name, $id) {

        $ModelBase = Load::library('ModelBase');

        $sql = "SELECT * FROM $table WHERE id='{$id}'";
        $result = $ModelBase->Load($sql);

        $name = $result[$name];

        return $name;

    }


/////////////////برای نمایش نام اختصار شهر از جدول انتخابی براساس Departure_Code/////////////////
    public function ShowNameRoute($table, $name, $condition) {

        $ModelBase = Load::library('ModelBase');

        $sql = "SELECT * FROM $table WHERE Departure_Code='{$condition}' ";
        $result = $ModelBase->Load($sql);
        
        return $result[$name];

    }

    ////// لیست کشورها/////
    public function ListCountry() {
        $Model = Load::library('Model');

        $sql = " SELECT * FROM reservation_country_tb WHERE is_del='no' ORDER BY id ASC";
        $country = $Model->select($sql);

        return $country;
    }

    public function getCountries($continent_id) {
        $countries_model=$this->getModel('reservationCountryModel');

        $countries=$countries_model->get()
            ->where('id_continent',$continent_id)
            ->where('is_del','no')
            ->orderBy('id','asc')
            ->all();

        $variableName=functions::ChangeIndexNameByLanguage(SOFTWARE_LANG,'name');
        $result=[];
        foreach ($countries as $country){
            $result[]= [
                'id'=>$country['id'],
                'title'=>$country[$variableName],
            ];
        }

        return $result;
    }

    public function getCities($country_id) {

        $cities_model=$this->getModel('reservationCityModel');

        $cities=$cities_model->get()
            ->where('id_country',$country_id)
            ->where('is_del','no')
            ->orderBy('id','asc')
            ->all();

        $variableName=functions::ChangeIndexNameByLanguage(SOFTWARE_LANG,'name');
        $result=[];
        foreach ($cities as $key=>$city){

            $result[$key]['id']= $city['id'];
            if(!empty($val[$variableName])){
                $result[$key]['title']= $city[$variableName];
            } else {
                if (SOFTWARE_LANG == 'fa'){
                    $result[$key]['title'] = $city['name'];
                }else{
                    if ($city['name_en']) {
                     $result[$key]['title'] = $city['name_en'];
                    }else{
                     $result[$key]['title'] = $city['name'];
                    }

                }
            }


        }

        return $result;
    }

    public function getRegions($city_id) {


        $regions_model = $this->getModel('reservationRegionModel');

        $regions = $regions_model->get()
            ->where('id_city', $city_id)
            ->where('is_del', 'no')
            ->orderBy('id', 'asc')
            ->all();

        $variableName = functions::ChangeIndexNameByLanguage(SOFTWARE_LANG, 'name');
        $result = [];
        foreach ($regions as $key=>$region) {

            $result[$key]['id'] = $region['id'];
            $result[$key]['title'] = $region[$variableName];


        }

        return $result;

    }

    ////// لیست کشورها/////
    public function ListCountryForAjax($continent) {
        $Model = Load::library('Model');

        $sql = " SELECT * FROM reservation_country_tb WHERE id_continent='{$continent}' AND is_del='no' ORDER BY id ASC";
        $country = $Model->select($sql);

        $list = '<option value="">'.functions::Xmlinformation('ChoseOption').'.</option>';
        $variableName=functions::ChangeIndexNameByLanguage(SOFTWARE_LANG,'name');
        foreach ($country as $val){
            $list .= '<option value="'.$val['id'].'">'.$val[$variableName].'</option>';
        }

        return $list;
    }

    ////// لیست شهرها/////
    public function ListCity($country) {
        $Model = Load::library('Model');

        $sql = " SELECT * FROM reservation_city_tb WHERE id_country='{$country}' AND is_del='no' ORDER BY id ASC";
        $city = $Model->select($sql);

        $list = '<option value="">'.functions::Xmlinformation('ChoseOption').'</option>';

        $variableName=functions::ChangeIndexNameByLanguage(SOFTWARE_LANG,'name');

        foreach ($city as $val){
            if(!empty($val[$variableName])){
                $list .= '<option value="'.$val['id'].'">'.$val[$variableName].'</option>';
            }else{
                $list .= '<option value="'.$val['id'].'">'.$val['name'].'</option>';
            }
        }

        return $list;
    }

    ////// لیست منطقه ها/////
    public function ListRegion($city) {
        $Model = Load::library('Model');

        $sql = " SELECT * FROM reservation_region_tb WHERE id_city='{$city}' AND is_del='no' ORDER BY id ASC";
        $region = $Model->select($sql);

        $list = '<option value="">'.functions::Xmlinformation('ChoseOption').'.</option>';
        $variableName=functions::ChangeIndexNameByLanguage(SOFTWARE_LANG,'name');
        foreach ($region as $val){
            $list .= '<option value="'.$val['id'].'">'.$val[$variableName].'</option>';
        }

        return $list;
    }


    ////// لیست ایرلاین هواپیما (شرکت حمل و نقل)/////
    public function ListAirline() {
        $ModelBase = Load::library('ModelBase');

        $sql = " SELECT * FROM airline_tb WHERE del='no' ORDER BY id ASC";
        $airline = $ModelBase->select($sql);

        return $airline;
    }


    ////// نام فرودگاه مبدا (محل حرکت)/////
    public function ListOriginAirport($type=null) {

        if($type=='international')
        {
            return $this->getModel('flightPortalModel')->get()->all();
        }

        return $this->getModel('flightRouteModel')->get()->groupBy('Departure_Code')->orderBy('id')->all();
    }



    ////// نام فرودگاه مقصد (محل حرکت)/////
    public function ListDestinationAirport($Code) {
        $ModelBase = Load::library('ModelBase');

        $sql = " SELECT * FROM flight_route_tb WHERE Departure_Code='{$Code}' ORDER BY id ASC";
        $route = $ModelBase->select($sql);

        $list = '<option value="">'.functions::Xmlinformation('ChoseOption').'.</option>';
        foreach ($route as $val){
            $list .= '<option value="'.$val['Arrival_Code'].'">'.$val['Arrival_City'].' ('.$val['Arrival_Code'].')'.'</option>';
        }
        return $list;
    }


    //////////نام هفته//////////
    public function nameDayWeek($date) {

        $y = substr($date,0,4);
        $m = substr($date,4,2);
        $d = substr($date,6,2);
        $jmktime = dateTimeSetting::jmktime(0, 0, 0, $m, $d, $y);
        $NameDay = dateTimeSetting::jdate( "l", $jmktime, "", "", "en");

        return $NameDay;
    }


    public function getFlyNumber($id){

        $Model = Load::library('Model');

        $sql = " SELECT fly_code FROM reservation_fly_tb WHERE id='{$id}' AND is_del='no' ";
        $fly = $Model->load($sql);

        return $fly['fly_code'];
    }

    ////// لیست ایرلاین (شرکت حمل و نقل)/////
    public function ListOtherAirline($id = null) {
        $Model = Load::library('Model');

        if (isset($id) && $id!=''){
            $WHERE = "fk_id_type_of_vehicle='{$id}' AND";
        }else {
            $WHERE = '';
        }
        $sql = " SELECT * FROM reservation_transport_companies_tb 
              WHERE {$WHERE} is_del='no' ORDER BY id ASC ";
        $result = $Model->select($sql);

        return $result;
    }


    public function listTransportCompanies($param)
    {

        $Model = Load::library('Model');

        $sqlVehicle = " SELECT name FROM reservation_type_of_vehicle_tb 
              WHERE id='{$param['type_of_vehicle']}' AND is_del='no' ORDER BY id ASC";
        $resultVehicle = $Model->load($sqlVehicle);

        $option = '<option value="">'.functions::Xmlinformation('ChoseOption').'</option>';
        if ($resultVehicle['name']=='هواپیما'){

            $result = $this->ListAirline();
            $variableName=functions::ChangeIndexNameByLanguage(SOFTWARE_LANG,'name','_fa');
            foreach ($result as $val){
                $option .= "<option value=". $val['id'] .">". $val[$variableName] ."</option>";
            }

        }else {

            $result = $this->ListOtherAirline($param['type_of_vehicle']);
            $variableName=functions::ChangeIndexNameByLanguage(SOFTWARE_LANG,'name');

            foreach ($result as $val){
                $option .= "<option value=". $val['id'] .">". $val[$variableName] ."</option>";
            }

        }

        return $option;
    }


    public function nameAirline($id)
    {
        $Model = Load::library('Model');
        $sqlVehicle = " SELECT name FROM reservation_type_of_vehicle_tb 
              WHERE id='{$id}' AND is_del='no' ORDER BY id ASC";
        $resultVehicle = $Model->load($sqlVehicle);

        return $resultVehicle['name'];
    }





    #region dateNextFewDays
    public function dateNextFewDays($date, $day, $type = null)
    {
        if(SOFTWARE_LANG == 'fa'){
            $dateMiladi = functions::ConvertToMiladi($date);
        }else{
            $dateMiladi=$date;
        }
        $dateMiladi = str_replace("-", "", $dateMiladi);
        $resultDate = date('Ymd', strtotime($dateMiladi . $day . " day"));

        if ($type != ''){
            $date = (SOFTWARE_LANG == 'fa'? functions::ConvertToJalali($resultDate) : $resultDate);
        } else {
            $date = str_replace("-", "", (SOFTWARE_LANG == 'fa' ? functions::ConvertToJalali($resultDate) : $resultDate ));

        }
        return $date;

    }
    #endregion


    #region nameDay
    public function nameDay($date)
    {
        if (strpos($date, '/')) {
            $date = str_replace("/", "", $date);
        } elseif (strpos($date, '-')) {
            $date = str_replace("-", "", $date);
        }

        $y = substr($date,0,4);
        $m = substr($date,4,2);
        $d = substr($date,6,2);


        if(SOFTWARE_LANG == 'fa'){

        $jmktime = dateTimeSetting::jmktime(0, 0, 0, $m, $d, $y);
        $nameDay = dateTimeSetting::jdate( "w", $jmktime, "", "", "en");
            $name = dateTimeSetting::jdate( "l", $jmktime, "", "", "en");
        switch ($nameDay){
            case '0':
                $name = 'شنبه';
                break;
            case '1':
                $name = 'یک شنبه';
                break;
            case '2':
                $name = 'دو شنبه';
                break;
            case '3':
                $name = 'سه شنبه';
                break;
            case '4':
                $name = 'چهار شنبه';
                break;
            case '5':
                $name = 'پنج شنبه';
                break;
            case '6':
                $name = 'جمعه';
                break;
            default:
                $name = '';
                break;
        }
        }else{
            $jmktime = mktime(0, 0, 0, $m, $d, $y);
            $nameDay = date( "w", $jmktime);
            $name = date( "l", $jmktime);
        }

        $result['numberDay'] = $nameDay;
        $result['name'] = $name;

        return $result;

    }
    #endregion




    public function getBaseCompany($param)
    {

        $result = '';
        if ($param['groupServices'] == 'Flight'){

            $list = $this->ListAirline();
            $result = '<option value="">'. functions::Xmlinformation('ChoseOption').'</option>';
            $result .= '<option value="all">'. functions::Xmlinformation('All').'</option>';
            foreach ($list as $val) {
                $result .= '<option value="' . $val['id'] . '">' . $val['name_fa'] . '</option>';
            }

        } elseif ($param['groupServices'] == 'Bus' || $param['groupServices'] == 'Train') {

            $ModelBase = Load::library('ModelBase');
            $groupServices = strtolower($param['groupServices']);
            $sql = "SELECT * FROM base_company_bus_tb WHERE  is_del = 'no' AND type_vehicle = '{$groupServices}' ";
            $list = $ModelBase->select($sql);
            $result = '<option value="">'. functions::Xmlinformation('ChoseOption').'</option>';
            $result .= '<option value="all">'. functions::Xmlinformation('All').'</option>';
            foreach ($list as $val) {
                $result .= '<option value="' . $val['id'] . '">' . $val['name_fa'] . '</option>';
            }

        }

        return $result;
    }

    public function getAgencyListClient() {
        return $this->getController('agency')->getAgencies();
    }

    function shamsiMonthToEndDay($year, $month) {
        // Array of the number of days in each month of a non-leap year
        $daysInMonth = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);

        // Check if it's a leap year (Shamsi)
        $isLeapYear = ($year % 33) == 1 || ($year % 33) == 5 || ($year % 33) == 9 || ($year % 33) == 13 || ($year % 33) == 17 || ($year % 33) == 22 || ($year % 33) == 26 || ($year % 33) == 30;

        // Adjust the number of days in the last month if it's a leap year
        if ($isLeapYear) {
            $daysInMonth[11] = 30;
        }

        // Check if the provided month is within the valid range
        if ($month >= 1 && $month <= 12) {
            return $daysInMonth[$month - 1];
        } else {
            return false; // Invalid month
        }
    }


    function miladiMonthToEndDay($year, $month) {
        // Check if the provided month is within the valid range
        if ($month >= 1 && $month <= 12) {
            // Calculate the end day of the month
            $endDay = date("t", strtotime("$year-$month-01"));
            return $endDay;
        } else {
            return false; // Invalid month
        }
    }

    public function getAgency($user_id) {

        $member_model =  $this->getModel('membersModel') ;
        return $member_model->get(['*' , 'agency_tb.name_fa as agency_name' , 'agency_tb.id as agency_id'])
            ->join('agency_tb' , 'id' , 'fk_agency_id')
            ->where('members_tb.id' , $user_id )
            ->find();


    }
}

?>
