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
            // Get international airports that have corresponding country/city data
            $internationalAirports = $this->getModel('flightPortalModel')->get()->all();
            $filteredAirports = [];

            foreach ($internationalAirports as $airport) {
                // Check if country exists
                $cityInfo = $this->getModel('reservationCityModel')
                    ->get(['id', 'name','id_country'])
                    ->where('abbreviation', $airport['DepartureCode'])
                    ->find();

                if ($cityInfo) {
                    // Check if city exists for this country
                    $countryInfo = $this->getModel('reservationCountryModel')
                        ->get(['id', 'name'])
                        ->where('id', $cityInfo['id_country'])
                        ->find();
                    
                    // Only include airports that have both valid country and city data
                    if ($countryInfo) {
                        $airport['country_name']=$countryInfo['name'];
                        $filteredAirports[] = $airport;
                    }
                }
            }
            
            return $filteredAirports;
        }

        // Get internal airports that have corresponding city/country data
        $internalAirports = $this->getModel('flightRouteModel')->get()
            ->groupBy('Departure_Code')
            ->orderBy('id')
            ->all();
        $filteredAirports = [];
        
        foreach ($internalAirports as $airport) {
            // Check if city exists by abbreviation
            $cityInfo = $this->getModel('reservationCityModel')
                ->get(['id', 'name', 'id_country'])
                ->where('abbreviation', $airport['Departure_Code'])
                ->find();
            
            if ($cityInfo) {
                // Check if country exists for this city
                $countryInfo = $this->getModel('reservationCountryModel')
                    ->get(['id', 'name'])
                    ->where('id', $cityInfo['id_country'])
                    ->find();
                
                // Only include airports that have both valid city and country data
                if ($countryInfo) {
                    $airport['country_name']=$countryInfo['name'];
                    $filteredAirports[] = $airport;
                }
            }
        }
        
        return $filteredAirports;
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

    ////// دریافت اطلاعات فرودگاه و تعیین نوع پرواز/////
    public function getAirportInfo($params) {
        if (empty($params['airport_code'])) {
            return functions::withError('کد فرودگاه الزامی است', 400);
        }

        $airportCode = $params['airport_code'];
        
        // First check if it's an internal airport (flight_route_tb)
        $internalAirport = $this->getModel('flightRouteModel')
            ->get(['Departure_Code', 'Departure_City', 'Departure_CityEn'])
            ->where('Departure_Code', $airportCode)
            ->where('local_portal', '0')
            ->find();

        if ($internalAirport) {
            // Get city and country info for internal airport
            $cityInfo = $this->getModel('reservationCityModel')
                ->get(['id', 'name', 'id_country'])
                ->where('abbreviation', $airportCode)
                ->find();

            if ($cityInfo) {
                $countryInfo = $this->getModel('reservationCountryModel')
                    ->get(['id', 'name'])
                    ->where('id', $cityInfo['id_country'])
                    ->find();

                if ($countryInfo) {
                    return [
                        'airport_code' => $airportCode,
                        'airport_name' => $internalAirport['Departure_City'],
                        'airport_name_en' => $internalAirport['Departure_CityEn'],
                        'city_id' => $cityInfo['id'],
                        'city_name' => $cityInfo['name'],
                        'country_id' => $countryInfo['id'],
                        'country_name' => $countryInfo['name'],
                        'region_id' => null, // Will be set if needed
                        'flight_type' => 'internal'
                    ];
                }
            }
        }

        // Check if it's an international airport (flight_portal_tb)
        $internationalAirport = $this->getModel('flightPortalModel')
            ->get(['DepartureCode', 'DepartureCityFa', 'DepartureCityEn', 'CountryFa', 'CountryEn'])
            ->where('DepartureCode', $airportCode)
            ->find();

        if ($internationalAirport) {
            // For international airports, we need to find the country and city
            $cityInfo = $this->getModel('reservationCityModel')
                ->get(['id', 'name','id_country'])
                ->where('abbreviation', $internationalAirport['DepartureCode'])
                ->find();

            if ($cityInfo) {
                $countryInfo = $this->getModel('reservationCountryModel')
                    ->get(['id', 'name'])
                    ->where('id', $cityInfo['id_country'])
                    ->find();

                if ($countryInfo) {
                    return [
                        'airport_code' => $airportCode,
                        'airport_name' => $internationalAirport['DepartureCityFa'],
                        'airport_name_en' => $internationalAirport['DepartureCityEn'],
                        'city_id' => $cityInfo['id'],
                        'city_name' => $internationalAirport['DepartureCityFa'],
                        'country_id' => $countryInfo['id'],
                        'country_name' => $internationalAirport['CountryFa'],
                        'region_id' => null, // Will be set if needed
                        'flight_type' => 'international'
                    ];
                }
            }
        }

        return functions::withError('فرودگاه یافت نشد', 404);
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

        $option = '<option value="">انتخاب شرکت حمل و نقل ... </option>';
        if ($resultVehicle['name']=='هواپیما'){

            $result = $this->ListAirline();
            $variableName=functions::ChangeIndexNameByLanguage(SOFTWARE_LANG,'name','_fa');
            foreach ($result as $val){
                $option .= "<option value=". $val['id'] .">". $val[$variableName] .' ('.$val['abbreviation'].")</option>";
            }

        }else {

            $result = $this->ListOtherAirline($param['type_of_vehicle']);
            $variableName=functions::ChangeIndexNameByLanguage(SOFTWARE_LANG,'name');

            foreach ($result as $val){
                $option .= "<option value=". $val['id'] .">". $val[$variableName] .' ('.$val['abbreviation'].")</option>";
            }

        }

        return $option;
    }

    public function listTypeOfPlane($param)
    {
        $result = $this->getModel('reservationVehicleModel')
            ->get(['id', 'name', 'abbreviation'])
            ->where('id_type_of_vehicle', $param['type_of_vehicle'])
            ->where('is_del', 'no')
            ->all();
        $option='<option value="">مدل وسیله نقلیه</option>';
        foreach ($result as $val) {
            $selected = (isset($param['selected_id']) && $param['selected_id'] == $val['id']) ? ' selected' : '';
            $option .= "<option value='{$val['id']}'{$selected}>{$val['name']} ({$val['abbreviation']})</option>";
        }
        return $option;
    }
    public function listTypeOfPlane2($type_of_vehicle)
    {
        $result = $this->getModel('reservationVehicleModel')
            ->get(['id', 'name', 'abbreviation'])
            ->where('id_type_of_vehicle', $type_of_vehicle)
            ->where('is_del', 'no')
            ->all();
        return $result;
    }
    public function listAllTypeOfPlane()
    {
        return $result = $this->getModel('reservationVehicleModel')
            ->get(['id', 'id_type_of_vehicle','name', 'abbreviation'])
            ->where('is_del', 'no')
            ->all();
    }
    public function nameAirline($id)
    {
        $Model = Load::library('Model');
        $sqlVehicle = " SELECT name FROM reservation_type_of_vehicle_tb 
              WHERE id='{$id}' AND is_del='no' ORDER BY id ASC";
        $resultVehicle = $Model->load($sqlVehicle);

        return $resultVehicle['name'];
    }
    public function ListAllFlyCode() {
        $result = $this->getModel('reservationFlyModel')
            ->get()
            ->where('is_del', 'no')
            ->orderBy('fly_code', 'ASC')
            ->all();
        return $result;
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
    public function getCharterSeatAgencies() {
        return $this->getController('agency')->getCharterAgencies();
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

    /**
     * Get filtered fly records based on filter parameters
     * @param array $params
     * @return array
     */
    public function getFilteredFlyRecords($params)
    {
        try {
            // Get table names
            $flyTable = $this->getModel('reservationFlyModel')->getTable();
            $ticketTable = $this->getModel('reservationTicketModel')->getTable();
            $vehicleTable = $this->getModel('reservationVehicleModel')->getTable() ;

            $query = $this->getModel('reservationFlyModel')
                ->get([
                    $flyTable . '.*',
                    $ticketTable . '.exit_hour',
                    $ticketTable . '.date as ticket_date',
                    $vehicleTable . '.name as vehicle_model',
                ], true)

                ->joinSimple(
                    [$ticketTable, $ticketTable],
                    $flyTable . '.id',
                    $ticketTable.'.fly_code',
                    'INNER'
                )
                ->joinSimple(
                    [$vehicleTable, $vehicleTable],
                    $ticketTable . '.type_of_vehicle',
                    $vehicleTable.'.id',
                    'LEFT'
                );

            // Extract filters from params
            $filters = isset($params['filters']) ? $params['filters'] : $params;
            
            // Date from filter - from ticket table
            if (!empty($filters['date_from'])) {
                $dateFrom = str_replace(['-','/'], '', $filters['date_from']);
                $query->where($ticketTable . '.date', $dateFrom, '>=');
            }
            
            // Date to filter - from ticket table
            if (!empty($filters['date_to'])) {
                $dateTo = str_replace(['-','/'], '', $filters['date_to']);
                $query->where($ticketTable . '.date', $dateTo, '<=');
            }
            
            // Origin filter - expect city ID
            if (!empty($filters['origin'])) {
                $query->where($flyTable . '.origin_city', $filters['origin']);
            }
            
            // Destination filter - expect city ID
            if (!empty($filters['destination'])) {
                $query->where($flyTable . '.destination_city', $filters['destination']);
            }
            
            // Fly code filter
            if (!empty($filters['fly_code'])) {
                $query->where($flyTable . '.fly_code', '%' . $filters['fly_code'] . '%', 'LIKE');
            }
            
            // Airline filter - expect airline ID
            if (!empty($filters['airline'])) {
                $query->where($flyTable . '.airline', $filters['airline']);
            }
            
            // Vehicle type filter - expect vehicle type ID
            if (!empty($filters['vehicle_type'])) {
                $query->where($flyTable . '.type_of_vehicle_id', $filters['vehicle_type']);
            }
            
            // Exit hour filter
            if (!empty($filters['exit_hour'])) {
                $query->where($ticketTable . '.exit_hour', $filters['exit_hour']);
            }
            
            $result = $query
            ->groupBy($flyTable . '.id')
            ->orderBy($flyTable . '.id', 'DESC')
            ->all();

            // Format the results to include readable names
            $formattedResult = [];
            foreach ($result as $item) {
                $formattedItem = $item;
                
                // Add formatted names for display
                $formattedItem['origin_country_name'] = $this->ShowName('reservation_country_tb', $item['origin_country']);
                $formattedItem['origin_city_name'] = $this->ShowName('reservation_city_tb', $item['origin_city']);
                $formattedItem['destination_country_name'] = $this->ShowName('reservation_country_tb', $item['destination_country']);
                $formattedItem['destination_city_name'] = $this->ShowName('reservation_city_tb', $item['destination_city']);
                
                // Add vehicle type name
                if (!empty($item['type_of_vehicle_id'])) {
                    $formattedItem['vehicle_type_name'] = $this->ShowName('reservation_type_of_vehicle_tb', $item['type_of_vehicle_id']);
                } else {
                    $formattedItem['vehicle_type_name'] = '-';
                }
                
                // Add airline name
                if (!empty($item['airline'])) {
                    $formattedItem['airline_name'] = $this->ShowNameBase('airline_tb', 'name_fa', $item['airline']);
                } else {
                    $formattedItem['airline_name'] = '-';
                }
                
                // Add formatted ticket date
                if (!empty($item['ticket_date'])) {
                    $formattedItem['ticket_date_formatted'] = $this->formatDateForDisplay($item['ticket_date']);
                } else {
                    $formattedItem['ticket_date_formatted'] = '-';
                }
                
                $formattedResult[] = $formattedItem;
            }

            return [
                'status' => true,
                'data' => $formattedResult
            ];
            
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'خطا در دریافت اطلاعات: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get filter options for fly records
     * @return array
     */
    public function getFlyFilterOptions()
    {
        try {
            // Get table names
            $flyTable = $this->getModel('reservationFlyModel')->getTable();
            $ticketTable = $this->getModel('reservationTicketModel')->getTable();
            
            // Get current date in shamsi format
            $currentDate = functions::ConvertToJalali(date('Y-m-d'), '');            $currentDate = str_replace('-', '', $currentDate);
            $currentDate = implode('/', $currentDate);
            
            // Get unique origins using ORM - return both ID and name
            $origins = $this->getModel('reservationFlyModel')
                ->get(['origin_city'])
                ->where('origin_city', null, 'IS NOT')
                ->groupBy('origin_city')
                ->orderBy('origin_city', 'ASC')
                ->all();
            
            $originOptions = [];
            foreach ($origins as $origin) {
                $cityName = $this->ShowName('reservation_city_tb', $origin['origin_city']);
                $originOptions[] = [
                    'id' => $origin['origin_city'],
                    'name' => $cityName
                ];
            }
            
            // Get unique destinations using ORM - return both ID and name
            $destinations = $this->getModel('reservationFlyModel')
                ->get(['destination_city'])
                ->where('destination_city', null, 'IS NOT')
                ->groupBy('destination_city')
                ->orderBy('destination_city', 'ASC')
                ->all();
            
            $destinationOptions = [];
            foreach ($destinations as $destination) {
                $cityName = $this->ShowName('reservation_city_tb', $destination['destination_city']);
                $destinationOptions[] = [
                    'id' => $destination['destination_city'],
                    'name' => $cityName
                ];
            }
            
            // Get unique airlines using ORM - return both ID and name
            $airlines = $this->getModel('reservationFlyModel')
                ->get(['airline'])
                ->where('airline', null, 'IS NOT')
                ->groupBy('airline')
                ->orderBy('airline', 'ASC')
                ->all();
            
            $airlineOptions = [];
            foreach ($airlines as $airline) {
                $airlineName = $this->ShowNameBase('airline_tb', 'name_fa', $airline['airline']);
                $airlineOptions[] = [
                    'id' => $airline['airline'],
                    'name' => $airlineName
                ];
            }
            
            // Get vehicle types using ORM - return both ID and name
            $vehicleTypes = $this->getModel('reservationTypeOfVehicleModel')
                ->get(['id', 'name'])
                ->orderBy('name', 'ASC')
                ->all();
            
            $vehicleTypeOptions = [];
            foreach ($vehicleTypes as $type) {
                $vehicleTypeOptions[] = [
                    'id' => $type['id'],
                    'name' => $type['name']
                ];
            }
            
            // Get unique flight codes using ORM
            $flightCodes = $this->getModel('reservationFlyModel')
                ->get(['fly_code'])
                ->where('fly_code', null, 'IS NOT')
                ->where('fly_code', '', '!=')
                ->groupBy('fly_code')
                ->orderBy('fly_code', 'ASC')
                ->all();
            
            $flightCodeOptions = [];
            foreach ($flightCodes as $flightCode) {
                $flightCodeOptions[] = [
                    'id' => $flightCode['fly_code'],
                    'name' => $flightCode['fly_code']
                ];
            }
            
            // Get unique exit hours using ORM with join
            $exitHours = $this->getModel('reservationFlyModel')
                ->get([$ticketTable . '.exit_hour'], true)
                ->joinSimple(
                    [$ticketTable, $ticketTable],
                    $flyTable . '.id',
                    $ticketTable.'.fly_code',
                    'LEFT'
                )
                ->where($ticketTable . '.exit_hour', null, 'IS NOT')
                ->where($ticketTable . '.exit_hour', '', '!=')
                ->groupBy($ticketTable . '.exit_hour')
                ->orderBy($ticketTable . '.exit_hour', 'ASC')
                ->all();
            
            $exitHourOptions = [];
            foreach ($exitHours as $exitHour) {
                if (!empty($exitHour['exit_hour'])) {
                    $exitHourOptions[] = [
                        'id' => $exitHour['exit_hour'],
                        'name' => $exitHour['exit_hour']
                    ];
                }
            }
            
            return [
                'currentDate' => $currentDate,
                'origins' => $originOptions,
                'destinations' => $destinationOptions,
                'airlines' => $airlineOptions,
                'vehicle_types' => $vehicleTypeOptions,
                'flight_codes' => $flightCodeOptions,
                'exit_hours' => $exitHourOptions
            ];
            
        } catch (Exception $e) {
            return [
                'currentDate' => $currentDate,
                'origins' => [],
                'destinations' => [],
                'airlines' => [],
                'vehicle_types' => [],
                'flight_codes' => [],
                'exit_hours' => []
            ];
        }
    }

    /**
     * Handle AJAX call for ShowName function
     * @param array $params
     * @return array
     */
    public function handleShowNameAjax($params)
    {
        try {
            $table = isset($params['table']) ? $params['table'] : '';
            $id = isset($params['id']) ? $params['id'] : '';
            $field = isset($params['field']) ? $params['field'] : '';
            
            if (empty($table) || empty($id)) {
                return [
                    'status' => false,
                    'message' => 'پارامترهای نامعتبر'
                ];
            }
            
            $name = $this->ShowName($table, $id, $field);
            
            return [
                'status' => true,
                'data' => $name
            ];
            
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'خطا در دریافت نام: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Format date for display (convert from YYYYMMDD to readable format)
     * @param string $date
     * @return string
     */
    private function formatDateForDisplay($date)
    {
        if (strlen($date) === 8) {
            $year = substr($date, 0, 4);
            $month = substr($date, 4, 2);
            $day = substr($date, 6, 2);

            // Format as YYYY/MM/DD for display
            return "$year/$month/$day";
        }

        return $date;
    }

    /**
     * Format time input for display and validation
     * @param string $time - Time string (can be HH:MM, HHMM, or just digits)
     * @param string $format - Output format ('display', 'database', 'validation')
     * @return string|array
     */
    public function formatTimeInput($time, $format = 'display')
    {
        // Remove all non-digits
        $digits = preg_replace('/\D/', '', $time);
        
        // Limit to 4 digits
        if (strlen($digits) > 4) {
            $digits = substr($digits, 0, 4);
        }
        
        // Extract hours and minutes
        $hours = substr($digits, 0, 2);
        $minutes = substr($digits, 2, 2);
        
        // Validate hours and minutes
        $hours = intval($hours);
        $minutes = intval($minutes);
        
        if ($hours > 23) $hours = 23;
        if ($minutes > 59) $minutes = 59;
        
        // Format based on requested format
        switch ($format) {
            case 'display':
                // Return formatted time for display (HH:MM)
                return sprintf('%02d:%02d', $hours, $minutes);
                
            case 'database':
                // Return time for database storage (HHMM)
                return sprintf('%02d%02d', $hours, $minutes);
                
            case 'validation':
                // Return validation result
                return [
                    'valid' => ($hours >= 0 && $hours <= 23 && $minutes >= 0 && $minutes <= 59),
                    'hours' => $hours,
                    'minutes' => $minutes,
                    'formatted' => sprintf('%02d:%02d', $hours, $minutes),
                    'database' => sprintf('%02d%02d', $hours, $minutes)
                ];
                
            default:
                return sprintf('%02d:%02d', $hours, $minutes);
        }
    }

    /**
     * Validate time input
     * @param string $time - Time string to validate
     * @return bool
     */
    public function isValidTime($time)
    {
        $validation = $this->formatTimeInput($time, 'validation');
        return $validation['valid'];
    }

    /**
     * Convert time from database format to display format
     * @param string $dbTime - Time in database format (HHMM)
     * @return string - Time in display format (HH:MM)
     */
    public function formatTimeFromDatabase($dbTime)
    {
        if (empty($dbTime)) return '';
        
        // If already in HH:MM format, return as is
        if (strpos($dbTime, ':') !== false) {
            return $dbTime;
        }
        
        // Convert from HHMM to HH:MM
        $digits = preg_replace('/\D/', '', $dbTime);
        if (strlen($digits) >= 4) {
            $hours = substr($digits, 0, 2);
            $minutes = substr($digits, 2, 2);
            return sprintf('%02d:%02d', intval($hours), intval($minutes));
        }
        
        return $dbTime;
    }

    /**
     * Convert time from display format to database format
     * @param string $displayTime - Time in display format (HH:MM)
     * @return string - Time in database format (HHMM)
     */
    public function formatTimeToDatabase($displayTime)
    {
        if (empty($displayTime)) return '';
        
        // If already in HHMM format, return as is
        if (strpos($displayTime, ':') === false) {
            return $displayTime;
        }
        
        // Convert from HH:MM to HHMM
        $parts = explode(':', $displayTime);
        if (count($parts) >= 2) {
            $hours = intval($parts[0]);
            $minutes = intval($parts[1]);
            return sprintf('%02d%02d', $hours, $minutes);
        }
        
        return $displayTime;
    }
}

?>
