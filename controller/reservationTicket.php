<?php

/**
 * Class reservationTicket
 * @property reservationTicket $reservationTicket
 */
class reservationTicket extends clientAuth
{

    public $id = '';
    public $countInsert = 0;
    public $sqlInsert = '';
    public $listCountry = '';
    public $listFly = '';
    public $minutes = '';
    public $hours = '';
    public $listCounter = array();
    public $listOtherCounter = array();
    public $arr_ticket = array();
    public $id_same = '';
    public $type_user = '';
    public $comition_ticket = '';
    public $record_tekrar_forTicket = '';
    public $maximum_buy = '';
    public $infoTicket = '';
    public $flyDataForTicket = array(); // New property to store fly data
    public $hasFlyData = false; // New property to indicate if fly data is loaded

    public function __construct(){
        parent::__construct();
        
        // Check if fly_id is provided in URL and load the data
        if (isset($_GET['fly_id']) && !empty($_GET['fly_id'])) {
            $this->loadFlyDataForTicket($_GET['fly_id']);
        }
    }

    /**
     * Load fly number data for ticket creation
     * This method fetches data from both reservation_fly_tb and temporary_data_tb
     */
    public function loadFlyDataForTicket($flyId)
    {
        // Get fly number data from main table using ORM
        $flyData = $this->getModel('reservationFlyModel')
            ->get()
            ->where('id', $flyId)
            ->where('is_del', 'no')
            ->find();
        
        if (!empty($flyData)) {
            // Get additional data from temporary storage
            $temporaryController = $this->getController('temporaryData');
            $additionalData = $temporaryController->getByReference($flyId, 'fly_number');
            
            // Merge the data
            $this->flyDataForTicket = $flyData;
            if ($additionalData && !empty($additionalData['data'])) {
                $additionalFields = json_decode($additionalData['data'], true);
                if ($additionalFields) {
                    $this->flyDataForTicket = array_merge($this->flyDataForTicket, $additionalFields);
                }
            }
            
            // Get proper names for cities and regions
            $this->flyDataForTicket['origin_city_name'] = $this->getCityName($this->flyDataForTicket['origin_city']);
            $this->flyDataForTicket['origin_region_name'] = $this->getRegionName($this->flyDataForTicket['origin_region']);
            $this->flyDataForTicket['destination_city_name'] = $this->getCityName($this->flyDataForTicket['destination_city']);
            $this->flyDataForTicket['destination_region_name'] = $this->getRegionName($this->flyDataForTicket['destination_region']);
            
            // Set flag to indicate we have fly data
            $this->hasFlyData = true;
        } else {
            $this->hasFlyData = false;
        }

        //departure_hours
        $result_hours = $this->getModel('temporaryDataModel')
            ->get(['data'])
            ->where('reference_id', $this->flyDataForTicket['id'])
            ->where('reference_type', 'fly_number')
            ->find();
        $this->flyDataForTicket['departure_hours'] =$result_hours['data'];
    }
    
    /**
     * Get city name by ID
     */
    private function getCityName($cityId)
    {
        if (empty($cityId)) {
            return '';
        }
        
        $city = $this->getModel('reservationCityModel')
            ->get()
            ->where('id', $cityId)
            ->find();
            
        return $city ? $city['name'] : '';
    }
    
    /**
     * Get region name by ID
     */
    private function getRegionName($regionId)
    {
        if (empty($regionId)) {
            return '';
        }
        
        $region = $this->getModel('reservationRegionModel')
            ->get()
            ->where('id', $regionId)
            ->find();
            
        return $region ? $region['name'] : '';
    }


    //////اضافه کردن شماره پرواز/////
    public function InsertFlyNumber($info)
    {
       $Model = Load::library('Model');
       $sql = " SELECT * FROM  reservation_fly_tb WHERE 
                   origin_region='{$info['origin_region']}'  AND 
                   destination_city='{$info['destination_city']}' AND 
                   fly_code='{$info['fly_code']}' AND
                   vehicle_grade_id='{$info['vehicle_grade_id']}' AND 
                   airline='{$info['airline']}' AND 
                   is_del='no' ";
        $fly = $Model->load($sql);
        if (empty($fly)) {
            $data['origin_country'] = $info['origin_country'];
            $data['origin_city'] = $info['origin_city'];
            $data['origin_region'] = $info['origin_region'];
            $data['destination_country'] = $info['destination_country'];
            $data['destination_city'] = $info['destination_city'];
            $data['destination_region'] = $info['destination_region'];
            $data['origin_airport'] = $info['origin_airport_name'];
            $data['destination_airport'] = $info['destination_airport_name'];
            $data['fly_code'] = $info['fly_code'];
            $data['type_of_plane'] = $info['type_of_plane'];
            $data['free'] = $info['free'];
            $data['type_of_vehicle_id'] = $info['type_of_vehicle'];
            $data['airline'] = $info['airline'];
            $data['vehicle_grade_id'] = $info['vehicle_grade_id'];
            $data['time'] = $info['hours'] . ":" . $info['minutes'];
            $data['is_del'] = 'no';

            $Model->setTable('reservation_fly_tb');
            $res = $Model->insertWithBind($data);

            if ($res) {
                // Save additional fields to temporary data
                $additionalFields = array(
                    'total_capacity' => isset($info['total_capacity']) && $info['total_capacity'] !== '' ? $info['total_capacity'] : '0',
                    'day_onrequest' => isset($info['day_onrequest']) && $info['day_onrequest'] !== '' ? $info['day_onrequest'] : '0',
                    'departure_minutes' => isset($info['departure_minutes']) && $info['departure_minutes'] !== '' ? $info['departure_minutes'] : '0',
                    'departure_hours' => isset($info['departure_hours']) && $info['departure_hours'] !== '' ? $info['departure_hours'] : '0'
                );

                /** @var temporaryData $temporaryController */
                $temporaryController = $this->getController('temporaryData');
                $temporaryController->saveTemporaryData($res, 'fly_number', $additionalFields);

                return 'success :  تغییرات با موفقیت انجام شد :' . $res;
            } else {
                return 'error : خطا در  تغییرات';
            }

        } else {
            return 'error : شماره پرواز تکراری میباشد.';
        }
    }


    //////نمایش اطلاعات شماره پرواز انتخاب شده/////
    public function showFly($id)
    {

        $Model = Load::library('Model');
        if (isset($id) && !empty($id)) {
            $edit_query = " SELECT * FROM  reservation_fly_tb  WHERE id='{$id}' AND is_del='no'";
            $res_edit = $Model->load($edit_query);
            if (!empty($res_edit)) {
                // Get additional fields from temporary data
                $res_edit = $this->mergeAdditionalFields($res_edit, $id);
                $this->listFly = $res_edit;
            } else {
                header("Location: " . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . "/404.tpl");
            }
        } else {
            header("Location: " . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . "/404.tpl");
        }
    }

    /**
     * Helper method to merge additional fields from temporary data
     */
    private function mergeAdditionalFields($flyData, $flyId)
    {
        $temporaryController = Load::controller('temporaryData');
        $additionalData = $temporaryController->getByReference($flyId, 'fly_number');
        
        if ($additionalData && !empty($additionalData['data'])) {
            $additionalFields = json_decode($additionalData['data'], true);
            if ($additionalFields) {
                // Merge additional fields into fly data
                $flyData = array_merge($flyData, $additionalFields);
            }
        }
        
        return $flyData;
    }


    public function getInfoTicket($id)
    {

        $Model = Load::library('Model');
        $edit_query = " SELECT * FROM  reservation_ticket_tb WHERE id='{$id}' AND is_del='no'";
        $res_edit = $Model->load($edit_query);

        if (!empty($res_edit)) {

            $this->infoTicket = $res_edit;

            $sqlFly = "select 
                    F.vehicle_grade_id,
                    F.time,
                    F.free,
                    D.name  
            from 
                    reservation_fly_tb F LEFT JOIN  reservation_vehicle_grade_tb D ON F.vehicle_grade_id=D.id
            where
                    F.id='{$res_edit['fly_code']}' and F.is_del='no'
            order by 
                    F.fly_code";
            $fly = $Model->load($sqlFly);
            $this->infoTicket['time'] = $fly['time'];

            $sql = " SELECT * FROM  reservation_ticket_tb
                      WHERE
                            date='{$res_edit['date']}' AND type_user='{$res_edit['type_user']}'
                            AND origin_city='{$res_edit['origin_city']}' AND destination_city='{$res_edit['destination_city']}'
                            AND airline='{$res_edit['airline']}' AND fly_code='{$res_edit['fly_code']}'
                          ";
            $res = $Model->Select($sql);

            foreach ($res as $val) {

                $this->infoTicket['id' . $val['age']] = $val['id'];
                $this->infoTicket['cost_two_way' . $val['age']] = $val['cost_two_way'];
                $this->infoTicket['cost_two_way_print' . $val['age']] = $val['cost_two_way_print'];
                $this->infoTicket['cost_one_way' . $val['age']] = $val['cost_one_way'];
                $this->infoTicket['cost_one_way_print' . $val['age']] = $val['cost_one_way_print'];
                $this->infoTicket['cost_Ndays' . $val['age']] = $val['cost_Ndays'];
            }

            // Load seller data if exists
            $sellerData = $this->getSellerData($res_edit['fly_code']);
            if ($sellerData) {
                $this->infoTicket['seller_title'] = $sellerData['title'];
                $this->infoTicket['seller_price'] = $sellerData['price'];
            }


        } else {
            header("Location: " . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . "/404.tpl");
        }

    }

    public function getAllGrades()
    {
        $grades=$this->getModel('reservationVehicleGradeModel')->get()
            ->where('is_del','no')
            ->all();
        return $grades;
    }


    //////ویرایش شماره پرواز/////
    public function updateFlyNumber($info)
    {
        $Model = Load::library('Model');
        $info = $info['params']; // کوتاه‌سازی

        $data['origin_country'] = $info['origin_country'];
        $data['origin_city'] = $info['origin_city'];
        $data['origin_region'] = $info['origin_region'];
        $data['destination_country'] = $info['destination_country'];
        $data['destination_city'] = $info['destination_city'];
        $data['destination_region'] = $info['destination_region'];
        $data['origin_airport'] = $info['origin_airport_name'];
        $data['destination_airport'] = $info['destination_airport_name'];
        $data['fly_code'] = $info['fly_code'];
        $data['type_of_plane'] = $info['type_of_plane'];
        $data['free'] = $info['free'];
        $data['type_of_vehicle_id'] = $info['type_of_vehicle'];
        $data['airline'] = $info['airline'];
        $data['vehicle_grade_id'] = $info['vehicle_grade_id'];
        $data['time'] = $info['hours'] . ":" . $info['minutes'];

        $Condition = "id='{$info['type_id']}' ";
        $Model->setTable("reservation_fly_tb");
        $res = $Model->update($data, $Condition);

        if ($res) {
            // Update additional fields in temporary data
           $additionalFields = array(
                'total_capacity' => isset($info['total_capacity']) && $info['total_capacity'] !== '' ? $info['total_capacity'] : '0',
                'day_onrequest' => isset($info['day_onrequest']) && $info['day_onrequest'] !== '' ? $info['day_onrequest'] : '0',
                'departure_minutes' => isset($info['departure_minutes']) && $info['departure_minutes'] !== '' ? $info['departure_minutes'] : '0',
                'departure_hours' => isset($info['departure_hours']) && $info['departure_hours'] !== '' ? $info['departure_hours'] : '0'
            );
           $updateData =[
                'data' => json_encode($additionalFields),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $res = $this->getModel('temporaryDataModel')
                ->get()
                ->updateWithBind(
                    $updateData,
                    ['reference_id' => $info['type_id'],
                     'reference_type' => 'fly_number'
                    ]
                );


            //$temporaryController = Load::controller('temporaryData');
            //$return=$temporaryController->saveOrUpdateTemporaryData($info['type_id'], 'fly_number', $additionalFields);

            return 'success :  تغییرات با موفقیت انجام شد' . ':' . $info['type_id'];
        } else {
            return 'error : خطا در  تغییرات' . ':' . $info['type_id'];
        }

    }


/////نمایش شماره پرواز براساس انتخاب ایرلاین(شرکت حمل و نقل)//////
    public function flyCodeTicket($param)
    {

        $Model = Load::library('Model');

        $sql = "select 
                      F.id,
                      F.fly_code,
                      D.name
                from 
                      reservation_fly_tb F LEFT JOIN  reservation_vehicle_grade_tb D ON F.vehicle_grade_id=D.id
                where
                      F.airline='{$param['airline']}' and
                      F.origin_country='{$param['origin_country']}' and
                      F.origin_city='{$param['origin_city']}' and
                      F.destination_country='{$param['destination_country']}' and
                      F.destination_city='{$param['destination_city']}' AND
                      F.is_del='no'
                order by 
                      F.fly_code	
                ";
        $fly = $Model->select($sql);

        $ressult = " /*/ ,";
        foreach ($fly as $val) {
            $ressult .= $val['id'] . '/*/' . $val['fly_code'] . '(' . $val['name'] . '),';
        }

        return $ressult;

    }

    ///////نمایش اطلاعات مربوط به شماره پرواز انتخاب شده//
    public function informationFlyNumber($fly_code)
    {

        $Model = Load::library('Model');

        $sql = "select 
                    F.vehicle_grade_id,
                    F.time,
                    F.free,
                    D.name  
            from 
                    reservation_fly_tb F LEFT JOIN  reservation_vehicle_grade_tb D ON F.vehicle_grade_id=D.id
            where
                    F.id='{$fly_code}' and F.is_del='no'
            order by 
                    F.fly_code";
        $fly = $Model->select($sql);

        if ($fly) {

            $ressult = " /*/ ,";
            foreach ($fly as $val) {

                $ressult = $val['name'] . ',' . $val['time'] . ',' . $val['free'];
            }

            return $ressult;

        } else {
            return 'error';
        }


    }

    ///// لیست مدل وسیله نقلیه/////
    public function showTypeOfVehicle()
    {
        $table_name = $this->getModel('reservationTypeOfVehicleModel')->getTable() ;
        $table_name_join = $this->getModel('reservationVehicleModel')->getTable() ;
        return $this->getModel('reservationTypeOfVehicleModel')
            ->get(["{$table_name_join}.id", "{$table_name}.name AS name","{$table_name_join}.name AS name_type_model"],true)
            ->join($table_name_join,"id_type_Of_vehicle")
            ->where("{$table_name}.is_del","no")
            ->orderBy("{$table_name}.name")
            ->all();
    }

    public function getTypeOfVehicle($id)
    {

        $Model = Load::library('Model');

        $sql = "SELECT
                    M.id,
                    M.name,
                    TA.name
             FROM
                    reservation_type_of_vehicle_tb TA
                     INNER JOIN  reservation_vehicle_model_tb M ON  TA.id=M.id_type_Of_vehicle
            WHERE M.id='{$id}' AND M.is_del='no'
             ORDER BY
                    TA.name,M.name";
        $res = $Model->load($sql);
        return $res[2] . ' - ' . $res[1];


    }


    ///////////////////////////////// افزودن بلیط/////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////


    public function InsertTicket($info, $type)
    {
        $data_seat_lock = [];
        $reservationModel = $this->getModel('reservationTicketModel');
        if(!empty($info['agency_selected'])){
          
            foreach ($info['agency_selected'] as $key_agency=>$agency_days) {
                // $agency_days is now an array with day indices as keys, and each day contains grade allocations
                foreach ($agency_days as $day_index => $grade_allocations) {
                    if (is_array($grade_allocations)) {
                        // New grade-based structure
                        $total_count = 0;
                        $grade_counts = [];
                        
                        foreach ($grade_allocations as $grade_id => $count) {
                                $total_count += intval($count);
                                $grade_counts[$grade_id] = intval($count);
                        }

                            $data_seat_lock[$key_agency][$day_index] = [
                                'total_count' => $total_count,
                                'grade_counts' => $grade_counts
                            ];
                    } else {
                        // Legacy structure (backward compatibility)
                        if (!empty($grade_allocations)) {
                            $data_seat_lock[$key_agency][$day_index]['total_count'] = $grade_allocations;
                        }
                    }
                }
            }

            // Handle counters if they exist (keeping backward compatibility)
            if (!empty($info['counters'])) {
            foreach ($info['counters'] as $key_counter=>$counter) {
                foreach ($counter as $key_item=>$item) {
                    if(!empty($item)){
                            // For counters, we'll assign to the first day if not specified
                            if (!isset($data_seat_lock[$key_counter][0])) {
                                $data_seat_lock[$key_counter][0] = array();
                            }
                            $data_seat_lock[$key_counter][0]['counter_count'][$key_item] = $item;
                        }
                    }
                }
            }
        }
        
        $Model = Load::library('Model');

        $info['start_date'] = str_replace("-", "", $info['start_date']);
        $info['end_date'] = str_replace("-", "", $info['end_date']);

        //////////تشکیل آرایه برای آرشیو بلیط ها (برای جلوگیری از درج بلیط تکراری)//////////
        $result_ticket_archive = $this->TicketArchive();
        if ($result_ticket_archive) {
            foreach ($result_ticket_archive as $val) {
                $exit_hourDb=str_replace(':','',$val['exit_hour']);
                $this->arr_ticket['with_flyCode'][$val['fly_code'] . $val['vehicle_grade'] . $val['date'] . $exit_hourDb . $val['type_user']] = $val['id'];
                $this->arr_ticket['whiteout_flyCode'][$val['vehicle_grade'] . $val['date'] . $val['type_user']] = $val['id'];
                $this->arr_ticket_user[$val['type_user'] . $val['id_same']] = $val['id'];
                $this->arr_ticket_date[$val['date'] . $val['id_same']] = $val['id'];
            }
        }

        ///////////////////////////////////////////////////////
        if ($type == 'insert'){
            $this->id_same = $this->GetIdSame();
        } elseif ($type == 'update'){
            $this->id_same = $info['id_same'];
        }
        $url = 'ticketEdit&id=' . $this->id_same . '&sDate=' . $info['start_date'] . '&eDate=' . $info['end_date'];
        $this->countInsert = 0;
        $this->sqlInsert = "INSERT INTO reservation_ticket_tb (
    id, id_same, origin_country, origin_city, origin_region,
    destination_country, destination_city, destination_region,
    fly_code, no_active, fly_tour_capacity, fly_total_capacity,
    remaining_capacity, fly_full_capacity, total_gofli, full_gofli,
    airline, vehicle_grade, date, age, description_ticket, services_ticket,
    sales_type, maximum_buy, num_order, exit_hour, reservation_time_canceled,
    request_time_canceled, chk_open, cost_open, type_of_vehicle, flag_adl,
    day_onrequest, type_user, free, cost_two_way, cost_two_way_print,
    cost_one_way, cost_one_way_print, cost_Ndays, comition_ticket,
    comision_agency_two_way, comision_counter_two_way, comision_agency_one_way,
    comision_counter_one_way, flag_special,is_del,status,status_manifest,seller_id,seller_price
)  VALUES";

        $resultDateTicket = '';
        for ($for_user = 1; $for_user <= $info['count_other_user']; $for_user++) {

            $this->type_user = $info['type_user' . $for_user];
            if (isset($info['chk_user' . $for_user]) && $info['chk_user' . $for_user] != '') {
                $this->maximum_buy = $info['maximum_buy' . $for_user];
                if (isset($info['comition_ticket' . $for_user]) && $info['comition_ticket' . $for_user] != '') {
                    $this->comition_ticket = $info['comition_ticket' . $for_user];
                } else {
                    $this->comition_ticket = $this->GetComition($info['type_user' . $for_user]);
                }


                // Check if using day-specific capacities
                $usingDaySpecificCapacities = false;
                if (isset($info['vehicle_grades']) && !empty($info['vehicle_grades'])) {
                    for ($day = 0; $day <= 6; $day++) {
                        if (isset($info['sh' . $day]) && $info['sh' . $day] != '') {
                            foreach ($info['vehicle_grades'] as $vehicleGradeId) {
                                $capacityFieldName = 'day_capacity_' . $day . '_' . $vehicleGradeId;
                                if (isset($info[$capacityFieldName]) && !empty($info[$capacityFieldName])) {
                                    $usingDaySpecificCapacities = true;
                                    break 2; // Break out of both loops
                                }
                            }
                        }
                    }
                }



                // Handle day-specific data if available
                if ($usingDaySpecificCapacities) {
                    // New day-specific approach with individual capacities per grade per day
                    $resultDateTicket = $this->processDaySpecificTickets($info, $type);
                } else {
                    // Handle multiple vehicle grades (legacy approach)
                    if (isset($info['vehicle_grades']) && !empty($info['vehicle_grades'])) {
                        // Multiple vehicle grades selected
                        foreach ($info['vehicle_grades'] as $vehicle_grade) {
                            $info['current_vehicle_grade'] = $vehicle_grade;
                            // Debug: Show the new data structure
                            $resultDateTicket = $this->DateTicket($info, $type, $info['start_date'], $info['end_date']);
                            if ($resultDateTicket != 'success') {
                                break; // Stop if there's an error
                            }
                        }
                    } else {
                        // Single vehicle grade (backward compatibility)
                        $info['current_vehicle_grade'] = isset($info['vehicle_grade']) ? $info['vehicle_grade'] : '';
                        $resultDateTicket = $this->DateTicket($info, $type, $info['start_date'], $info['end_date']);
                    }
                }
            }
            elseif ($type == 'update' && !empty($this->arr_ticket_user[$this->type_user . $this->id_same])) {
                $dataDelete['is_del'] = 'yes';
                $Condition = "
                        id_same='{$this->id_same}'
                        AND origin_city='{$info['origin_city']}' 
                        AND destination_city='{$info['destination_city']}'
                        AND airline='{$info['airline']}' 
                        AND fly_code='{$info['fly_code']}'
                        AND type_user='{$this->type_user}'
                        ";
                $Model->setTable("reservation_ticket_tb");
                $res = $Model->update($dataDelete, $Condition);
                if ($res){
                    $resultDateTicket = 'success';
                } else {
                    $resultDateTicket = 'error';
                }

            }

        }
        //ثبت تعداد رکورد کمتر از 100 تا اینجا اتفاق میفتد
        if ($this->sqlInsert != '' && $this->countInsert > 0) {
            $Model = Load::library('Model');
            $this->sqlInsert = substr($this->sqlInsert, 0, -1);
            $res = $Model->execQuery($this->sqlInsert);
        }

        if ($resultDateTicket == 'success') {
            if (!empty($data_seat_lock)) {
                // Get all adult tickets that were just inserted
                $adultTickets = $reservationModel->get()
                    ->where('id_same', $this->id_same)
                    ->where('age', 'ADL')
                    ->where('is_del', 'no')
                    ->all();
                // Create a mapping of date to ticket ID for adult tickets
                $dateToTicketId = [];
                foreach ($adultTickets as $ticket) {
                    $dateToTicketId[$ticket['date']] = $ticket['id'];
                }
                if($type == 'update') {
                    $resDelete = $this->getModel('agencyLockSeatModel')->delete("id_same='{$this->id_same}'");
                }

                // Store agency lock seats per day and grade
                foreach ($data_seat_lock as $key_lock => $agency_days) {
                    // Process each day for this agency
                    foreach ($agency_days as $day => $lock_data) {
                        if (isset($info['sh' . $day]) && $info['sh' . $day] != '') {
                            // Check if we have grade-specific allocations
                            if (isset($lock_data['grade_counts']) && !empty($lock_data['grade_counts'])) {
                                // New grade-based structure
                                foreach ($lock_data['grade_counts'] as $grade_id => $grade_count) {
                                    // Validate against grade-specific capacity
                                    $gradeCapacityField = 'day_capacity_' . $day . '_' . $grade_id;
                                    $gradeCapacity = isset($info[$gradeCapacityField]) ? intval($info[$gradeCapacityField]) : 0;
                                    
                                    if ($grade_count <= $gradeCapacity) {
                                        // Find the corresponding ticket ID for this day and grade
                                        $ticketId = null;
                                        
                                        // Convert day number to actual dates in the date range
                                        $startDate = $info['start_date'];
                                        $endDate = $info['end_date'];
                                        $currentDate = $startDate;
                                        $objController = Load::controller('reservationPublicFunctions');

                                        while ($currentDate <= $endDate) {
                                            $nameDay = $objController->nameDay($currentDate);
                                            if ($nameDay['numberDay'] == $day) {
                                                // This date corresponds to the selected day
                                                // Find ticket with matching vehicle grade
                                                foreach ($adultTickets as $ticket) {
                                                    if ($ticket['date'] == $currentDate && $ticket['vehicle_grade'] == $grade_id) {
                                                        $ticketId = $ticket['id'];
                                                        break;
                                                    }
                                                }
                                                
                                                if ($ticketId) {
                                                    $data_insert = [
                                                        'agency_id' => $key_lock,
                                                        'count_agency' => $grade_count,
                                                        'counters' => isset($lock_data['counter_count']) ? json_encode($lock_data['counter_count'], 256|64) : '{}',
                                                        'ticket_id' => $ticketId,
                                                        'id_same' => $this->id_same
                                                    ];

                                                    $this->getModel('agencyLockSeatModel')->insertLocal($data_insert);
                                                }
                                            }
                                            $currentDate = $objController->dateNextFewDays($currentDate, ' + 1');
                                        }
                                    }
                                }
                            } else {
                                // Legacy structure - use total count
                                $dayCapacityField = 'day_capacity_' . $day;
                                $dayCapacity = isset($info[$dayCapacityField]) ? $info[$dayCapacityField] : 0;
                                
                                if ($lock_data['total_count'] <= $dayCapacity) {
                                    // Find the corresponding ticket ID for this day
                                    $ticketId = null;
                                    
                                    // Convert day number to actual dates in the date range
                                    $startDate = $info['start_date'];
                                    $endDate = $info['end_date'];
                                    $currentDate = $startDate;
                                    $objController = Load::controller('reservationPublicFunctions');

                                    while ($currentDate <= $endDate) {
                                        $nameDay = $objController->nameDay($currentDate);
                                        if ($nameDay['numberDay'] == $day) {
                                            // This date corresponds to the selected day

                                            if (isset($dateToTicketId[$currentDate])) {
                                                $ticketId = $dateToTicketId[$currentDate];
                                                if ($ticketId) {
                                                    $data_insert = [
                                                        'agency_id' => $key_lock,
                                                        'count_agency' => $lock_data['total_count'],
                                                        'counters' => isset($lock_data['counter_count']) ? json_encode($lock_data['counter_count'], 256|64) : '{}',
                                                        'ticket_id' => $ticketId,
                                                        'id_same' => $this->id_same
                                                    ];

                                                    $this->getModel('agencyLockSeatModel')->insertLocal($data_insert);
                                                }
                                            }
                                        }
                                        $currentDate = $objController->dateNextFewDays($currentDate, ' + 1');
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if ($type == 'update'){
                $resUpdate = array();
                if ($info['eDate']>$info['end_date']){
                    $dataDelete['is_del'] = 'yes';
                    $Condition = "
                        id_same='{$this->id_same}' 
                        AND date>='{$info['end_date']}' AND date<='{$info['eDate']}' 
                        AND origin_city='{$info['origin_city']}' 
                        AND destination_city='{$info['destination_city']}'
                        AND airline='{$info['airline']}' 
                        AND fly_code='{$info['fly_code']}' 
                        AND vehicle_grade='{$info['vehicle_grade']}'
                        ";
                    $Model->setTable("reservation_ticket_tb");
                    $resUpdate[] = $Model->update($dataDelete, $Condition);

                } elseif ($info['sDate']<$info['start_date']){

                    $dataDelete['is_del'] = 'yes';
                    $Condition = "
                        id_same='{$this->id_same}' 
                        AND date>='{$info['sDate']}' AND date<='{$info['start_date']}' 
                        AND origin_city='{$info['origin_city']}' 
                        AND destination_city='{$info['destination_city']}'
                        AND airline='{$info['airline']}' 
                        AND fly_code='{$info['fly_code']}' 
                        AND vehicle_grade='{$info['vehicle_grade']}'
                        ";
                    $Model->setTable("reservation_ticket_tb");
                    $resUpdate[] = $Model->update($dataDelete, $Condition);

                }

                // اگر ظرفیت اصلی کمتر از ظرفیت پر شده بود؛ مقدار ظرفیت اصلی را ظرفیت پرشده قرار دهد. //
                $sql = "SELECT id, fly_total_capacity, fly_full_capacity, remaining_capacity, maximum_buy
                          FROM reservation_ticket_tb 
                          WHERE 
                                id_same='{$this->id_same}' 
                                AND origin_city='{$info['origin_city']}' 
                                AND destination_city='{$info['destination_city']}'
                                AND airline='{$info['airline']}' 
                                AND fly_code='{$info['fly_code']}' 
                                AND vehicle_grade='{$info['vehicle_grade']}'
                                AND (fly_total_capacity<fly_full_capacity OR maximum_buy<fly_full_capacity)";
                $resultCapacity = $Model->select($sql);
                if (!empty($resultCapacity)) {
                    foreach ($resultCapacity as $capacity) {

                        $dataCapacity['fly_total_capacity'] = $capacity['fly_full_capacity'];
                        $dataCapacity['maximum_buy'] = $capacity['fly_full_capacity'];
                        $dataCapacity['remaining_capacity'] = '0';

                        $Condition = "id='{$capacity['id']}'";
                        $Model->setTable("reservation_ticket_tb");
                        $resUpdate[] = $Model->update($dataCapacity, $Condition);

                    }

                }

                // ظرفیت باقی مانده را برحسب ظرفیت اصلی تغییر کرده بدست آورد. //
                $sql2 = "SELECT id, fly_total_capacity, fly_full_capacity, remaining_capacity
                          FROM reservation_ticket_tb WHERE 
                                id_same='{$this->id_same}' 
                                AND origin_city='{$info['origin_city']}' 
                                AND destination_city='{$info['destination_city']}'
                                AND airline='{$info['airline']}' 
                                AND fly_code='{$info['fly_code']}' 
                                AND vehicle_grade='{$info['vehicle_grade']}'
                          ";
                $resultCapacity2 = $Model->select($sql2);
                if (!empty($resultCapacity2)) {
                    foreach ($resultCapacity2 as $capacity2) {

                        $dataCapacity2['remaining_capacity'] = $capacity2['fly_total_capacity'] - $capacity2['fly_full_capacity'];

                        $Condition = "id='{$capacity2['id']}'";
                        $Model->setTable("reservation_ticket_tb");
                        $resUpdate[] = $Model->update($dataCapacity2, $Condition);

                    }
                }

                if (in_array('0', $resUpdate)) {
                    return 'error : خطا در  تغییرات' . ':' . $url ;
                } else {
                    return 'success :  ثبت اطلاعات  با موفقیت انجام شد' . ':' . $url;
                }

            } else {



                return 'success :  ثبت اطلاعات  با موفقیت انجام شد' . ':' . $url;
            }


            //حذف بلیط های اضافه درج شده بخاطر تبدیل تاریخ شمسی به میلادی که در شمسی یک بازه یک ماه بود ولی در میلادی در بازه دو ماه بود//
            $sqlCheck = "select 
                                id,fly_code,type_user,date,age 
                          from 
                                reservation_ticket_tb 
                          where  
                                fly_code='{$info['fly_code']}'  and is_del='no'
                          group by  
                                date,type_user,age
                                ";

            $resultCheck = $Model->select($sqlCheck);
            foreach ($resultCheck as $item) {

                $Condition = "id!='{$item['id']}' and 
                               fly_code='{$item['fly_code']}' and			   			   
                               date='{$item['date']}' and
                               type_user='{$item['type_user']}' and
                               vehicle_grade='{$item['vehicle_grade']}' and
                               age='{$item['age']}' ";
                $Model->setTable("reservation_ticket_tb");
                $res = $Model->delete($Condition);

            }

            //حذف کن بلیط هایی که نوع کاربر ندارن//
            $Condition = "type_user='' ";
            $Model->setTable("reservation_ticket_tb");
            $res = $Model->delete($Condition);



        } else {
            return 'error : خطا در  تغییرات' . ':' . $url;
        }


    }

    /**
     * Save seller data to fly_seller_tb table
     * @param array $info
     * @param int $id_same
     * @return bool
     */
    public function saveSellerData($info, $id_same)
    {
        $Model = Load::library('Model');
        
        // Clean price data (remove commas and convert to integer)
        $seller_price = str_ireplace(",", "", $info['seller_price']);
        
        // Prepare seller data
        $sellerData = array(
            'fly_id' => $info['fly_code'],
            'title' => $info['seller_id'],
            'price' => (int)$seller_price
        );
        // Check if seller data already exists for this fly_id
        $existingSeller = $Model->load("SELECT id FROM fly_seller_tb WHERE fly_id = '{$info['fly_code']}'");
        
        if ($existingSeller) {
            // Update existing record
            $Model->setTable('fly_seller_tb');
            $result = $Model->update($sellerData, "fly_id = '{$info['fly_code']}'");
        } else {
            // Insert new record
            $Model->setTable('fly_seller_tb');
            $result = $Model->insertWithBind($sellerData);
        }
        
        return $result;
    }

    /**
     * Get seller data for a specific fly_id
     * @param int $fly_id
     * @return array|null
     */
    public function getSellerData($fly_id)
    {
        $Model = Load::library('Model');
        
        $sql = "SELECT * FROM fly_seller_tb WHERE fly_id = '{$fly_id}'";
        $sellerData = $Model->load($sql);
        
        return $sellerData;
    }

    /**
     * Process day-specific tickets with individual capacities and departure times
     * @param array $info
     * @param string $type
     * @return string
     */
    public function processDaySpecificTickets($info, $type)
    {
        $Model = Load::library('Model');
        $objController = Load::controller('reservationPublicFunctions');
        
        $resultInsertTicket = 'success';
        
        // Get day-specific capacities from form
        $dayCapacities = [];
        for ($day = 0; $day <= 6; $day++) {
            if (isset($info['sh' . $day]) && $info['sh' . $day] != '') {
                // This day is selected, get its capacities for each vehicle grade
                if (isset($info['vehicle_grades']) && !empty($info['vehicle_grades'])) {
                    foreach ($info['vehicle_grades'] as $vehicleGradeId) {
                        $capacityFieldName = 'day_capacity_' . $day . '_' . $vehicleGradeId;
                        if (isset($info[$capacityFieldName]) && !empty($info[$capacityFieldName])) {
                            $dayCapacities[$day][$vehicleGradeId] = $info[$capacityFieldName];
                        }
                    }
                }
                
                // Also store departure time for this day
                if (isset($info['day_departure_time_' . $day]) && !empty($info['day_departure_time_' . $day])) {
                    $dayCapacities[$day]['departure_time'] = $info['day_departure_time_' . $day];
                }
            }
        }

        // Process the date range and create tickets for selected days
            $startDate = $info['start_date'];
            $endDate = $info['end_date'];
            $currentDate = $startDate;


            
            while ($currentDate <= $endDate) {
                $nameDay = $objController->nameDay($currentDate);
                $dayNumber = $nameDay['numberDay'];
                
                 // Check if this day is selected and has capacity data
                if (isset($dayCapacities[$dayNumber])) {
                    $date = $currentDate;

                    // Set day-specific departure time if available
                    if (isset($dayCapacities[$dayNumber]['departure_time'])) {
                        $timeParts = explode(':', $dayCapacities[$dayNumber]['departure_time']);
                                    if (count($timeParts) == 2) {
                                        $info['hours'] = $timeParts[0];
                                        $info['minutes'] = $timeParts[1];
                                    }
                                }

                    // Process each vehicle grade for this date

                    if (isset($info['vehicle_grades']) && !empty($info['vehicle_grades'])) {
                        foreach ($info['vehicle_grades'] as $vehicle_grade) {
                            $info['current_vehicle_grade'] = $vehicle_grade;

                            // Set day-specific capacity for this grade
                            if (isset($dayCapacities[$dayNumber][$vehicle_grade])) {
                                $info['day_capacity'] = $dayCapacities[$dayNumber][$vehicle_grade];
                            }
                            else {
                                // Use default capacity if no day-specific capacity is set
                                $info['day_capacity'] = isset($info['total_capacity']) ? $info['total_capacity'] : 0;
                            }

                            // Set day-specific vehicle type if available
                            $dayVehicleType = isset($info['day_type_of_vehicle_' . $dayNumber]) ? $info['day_type_of_vehicle_' . $dayNumber] : null;

                                if (!empty($dayVehicleType)) {
                                    $info['type_of_vehicle'] = $dayVehicleType;
                                }
                                $resultInsertTicket = $this->SqlInsertTicket($info, $date, $type);
                                if ($resultInsertTicket != 'success') {
                                    return $resultInsertTicket;
                                }
                            }
                        } else {
                            // Single vehicle grade (backward compatibility)
                            $info['current_vehicle_grade'] = isset($info['vehicle_grade']) ? $info['vehicle_grade'] : '';

                        // Use first available capacity or default
                        $firstGradeId = isset($info['vehicle_grades']) && !empty($info['vehicle_grades']) ? $info['vehicle_grades'][0] : null;
                        if ($firstGradeId && isset($dayCapacities[$dayNumber][$firstGradeId])) {
                            $info['day_capacity'] = $dayCapacities[$dayNumber][$firstGradeId];
                        } else {
                            $info['day_capacity'] = isset($info['total_capacity']) ? $info['total_capacity'] : 0;
                        }

                        // Set day-specific vehicle type if available
                        $dayVehicleType = isset($info['day_type_of_vehicle_' . $dayNumber]) ? $info['day_type_of_vehicle_' . $dayNumber] : null;
                            if (!empty($dayVehicleType)) {
                                $info['type_of_vehicle'] = $dayVehicleType;
                            }

                            $resultInsertTicket = $this->SqlInsertTicket($info, $date, $type);
                            if ($resultInsertTicket != 'success') {
                                return $resultInsertTicket;
                            }
                        }
                    }

                // Next day
                $currentDate = $objController->dateNextFewDays($currentDate, ' + 1');
        }
        return $resultInsertTicket;
    }


    //بررسی تاریخ ها (از تاریخ n تا تاریخ m)//
    public function DateTicket($info, $type, $startDate, $endDate)
    {
        $objController = Load::controller('reservationPublicFunctions');

        //////////لیست نام هفته، انتخاب شده///////////
        $daysWeek = 'NaN,';
        for ($sh = 0; $sh <= 6; $sh++) {
            if (isset($info['sh' . $sh]) && $info['sh' . $sh] != '') {
                $daysWeek .= $info['sh' . $sh] . ',';
            }
        }
        $resultInsertTicket = '';
        while ($startDate <= $endDate) {
            $nameDay = $objController->nameDay($startDate);

            $date = $startDate;
            if (strpos($daysWeek, ',' . $nameDay['numberDay'] . ',') !== false) {
                $grades = explode(',', $info['current_vehicle_grade']); // یا vehicle_grade اگر current_vehicle_grade خالی است
                foreach ($grades as $grade) {
                    $info['current_vehicle_grade'] = $grade;

                    // Check for day-specific vehicle type
                    $dayVehicleType = isset($info['day_type_of_vehicle_' . $nameDay['numberDay']]) ? $info['day_type_of_vehicle_' . $nameDay['numberDay']] : null;
                    if (!empty($dayVehicleType)) {
                        $info['type_of_vehicle'] = $dayVehicleType;
                    }

                    // Check for day-specific departure time
                    $dayDepartureTime = isset($info['day_departure_time_' . $nameDay['numberDay']]) ? $info['day_departure_time_' . $nameDay['numberDay']] : null;
                    if (!empty($dayDepartureTime)) {
                        $timeParts = explode(':', $dayDepartureTime);
                        $info['hours'] = $timeParts[0];
                        $info['minutes'] = $timeParts[1];
                    }

                    // Check day capacity
                    $dayCapacityField = 'day_capacity_' . $nameDay['numberDay'] . '_' . $grade;
                    if (isset($info[$dayCapacityField]) && !empty($info[$dayCapacityField])) {
                        $info['day_capacity'] = $info[$dayCapacityField];
                    }
                    $resultInsertTicket = $this->SqlInsertTicket($info,$startDate, $type);
                }
            }
            elseif ($type == 'update' && !empty($this->arr_ticket_date[$date . $this->id_same])) {
                $Model = Load::library('Model');
                $dataDelete['is_del'] = 'yes';
                $Condition = "
                        id_same='{$this->id_same}' 
                        AND date='{$date}' 
                        AND origin_city='{$info['origin_city']}' 
                        AND destination_city='{$info['destination_city']}'
                        AND airline='{$info['airline']}' 
                        AND fly_code='{$info['fly_code']}' 
                        AND vehicle_grade='{$info['current_vehicle_grade']}'
                        ";
                $Model->setTable("reservation_ticket_tb");
                $res = $Model->update($dataDelete, $Condition);
                if ($res){
                    $resultInsertTicket = 'success';
                } else {
                    $resultInsertTicket = 'error';
                }

            }

            //روز بعدی//
            $startDate = $objController->dateNextFewDays($startDate, ' + 1');


        }//end while startDate<=endDate

        if ($resultInsertTicket == 'success') {
            return 'success';
        } else {
            return 'error';
        }


    }

    //درج قیمت اتاق ها در دیتابیس//
    public function SqlInsertTicket($info, $date, $type)
    {
       $Model = Load::library('Model');
        $res = array();

        for ($i = 1; $i <= 3; $i++) {

            if ($info['age' . $i] == "ADL") {
                $flag_adl = 1;
            } else {
                $flag_adl = 0;
            }
            if (isset($info['chk_flag_special']) && $info['chk_flag_special']=1){
                $flag_special = 'yes';
            }else{
                $flag_special = 'no';
            }

            $date = str_ireplace("/", "", $date);
            $cost_two_way = str_ireplace(",", "", $info['cost_two_way' . $i]);
            $commission_agency_two_way = ($cost_two_way * $this->comition_ticket) / 100;
            $commission_counter_two_way = 0;
            $cost_two_way_print = str_ireplace(",", "", $info['cost_two_way_print' . $i]);;
            $cost_one_way = str_ireplace(",", "", $info['cost_one_way' . $i]);
            $commission_agency_one_way = ($cost_one_way * $this->comition_ticket) / 100;
            $commission_counter_one_way = 0;
            $cost_one_way_print = str_ireplace(",", "", $info['cost_one_way_print' . $i]);
            $cost_Ndays = str_ireplace(",", "", $info['cost_Ndays' . $i]);
            //تکرار وجود دارد؟//
            $current_vehicle_grade = isset($info['current_vehicle_grade']) ? $info['current_vehicle_grade'] : $info['vehicle_grade'];
            $exit_hourNow=$info['hours'] . $info['minutes'];

            if (empty($this->arr_ticket['with_flyCode'][$info['fly_code'] . $current_vehicle_grade . $date . $exit_hourNow . $this->type_user])) {
                            $this->countInsert++;
                            if ($this->countInsert % 100 == 0) {
                                $this->sqlInsert = substr($this->sqlInsert, 0, -1);
                                $res[] = $Model->execQuery($this->sqlInsert);
                                $this->sqlInsert = " INSERT INTO reservation_ticket_tb VALUES";
                            }
                            // Use day-specific capacity if available, otherwise fall back to total_capacity
                            $capacity = isset($info['day_capacity']) ? $info['day_capacity'] : $info['total_capacity'];

                            $this->sqlInsert .= "(
                                        '',
                                        '" . $this->id_same . "',
                                        '" . $info['origin_country'] . "',
                                        '" . $info['origin_city'] . "',
                                        '" . $info['origin_region'] . "',
                                        '" . $info['destination_country'] . "',
                                        '" . $info['destination_city'] . "',
                                        '" . $info['destination_region'] . "',
                                        '" . $info['fly_code'] . "',
                                        '',
                                        '',
                                        '" . $capacity . "',
                                        '" . $capacity . "',
                                        '',
                                        '',
                                        '',
                                        '" . $info['airline'] . "',
                                        '" . $current_vehicle_grade . "',
                                        '" . $date . "',
                                        '" . $info['age' . $i] . "',
                                        '" . $info['description_ticket'] . "',
                                        '" . $info['services_ticket'] . "',
                                        '',
                                        '" . $this->maximum_buy . "',
                                        '',
                                        '" . $info['hours'] . ":" . $info['minutes'] . "',
                                        '',
                                        '',
                                        '',
                                        '',
                                        '" . $info['type_of_vehicle'] . "',
                                        '" . $flag_adl . "',
                                        '" . $info['day_onrequest'] . "',
                                        '" . $this->type_user . "',
                                        '" . $info['free'] . "',
                                        '" . $cost_two_way . "',
                                        '" . $cost_two_way_print . "',
                                        '" . $cost_one_way . "',
                                        '" . $cost_one_way_print . "',
                                        '" . $cost_Ndays . "',
                                        '" . $this->comition_ticket . "',
                                        '" . $commission_agency_two_way . "',
                                        '" . $commission_counter_two_way . "',
                                        '" . $commission_agency_one_way . "',
                                        '" . $commission_counter_one_way . "',
                                        '" . $flag_special . "',
                                        'no',
                                        '',
                                        '',
                                        '".$info['seller_id']."',
                                        '".str_ireplace(",", "", $info['seller_price'])."'
                                        ),";


            }
            elseif ($type == 'update'){
                $data['id_same'] = $this->id_same;
                $data['origin_country'] = $info['origin_country'];
                $data['origin_city'] = $info['origin_city'];
                $data['origin_region'] = $info['origin_region'];
                $data['destination_country'] = $info['destination_country'];
                $data['destination_city'] = $info['destination_city'];
                $data['destination_region'] = $info['destination_region'];
                $data['fly_code'] = $info['fly_code'];

                // Use day-specific capacity if available, otherwise fall back to total_capacity
                $data['fly_total_capacity'] = $info['day_capacity'];
                $data['total_gofli'] = '';
                $data['full_gofli'] = '';
                $data['airline'] = $info['airline'];
                $data['vehicle_grade'] = $current_vehicle_grade;
                $data['date'] = $date;
                $data['age'] = $info['age' . $i];
                $data['description_ticket'] = $info['description_ticket'];
                $data['services_ticket'] = $info['services_ticket'];
                $data['exit_hour'] = $info['hours'] . ":" . $info['minutes'];
                $data['type_of_vehicle'] = $info['type_of_vehicle'];
                $data['flag_adl'] = $flag_adl;
                $data['day_onrequest'] = $info['day_onrequest'];
                $data['type_user'] = $this->type_user;
                $data['free'] = $info['free'];
                $data['maximum_buy'] = $this->maximum_buy;
                $data['comition_ticket'] = $this->comition_ticket;
                $data['cost_two_way'] = $cost_two_way;
                $data['cost_two_way_print'] = $cost_two_way_print;
                $data['cost_one_way'] = $cost_one_way;
                $data['cost_one_way_print'] = $cost_one_way_print;
                $data['cost_Ndays'] = $cost_Ndays;
                $data['comision_agency_two_way'] = $commission_agency_two_way;
                $data['comision_counter_two_way'] = $commission_counter_two_way;
                $data['comision_agency_one_way'] = $commission_agency_one_way;
                $data['comision_counter_one_way'] = $commission_counter_one_way;
                $data['flag_special'] = $flag_special;
                $data['is_del'] = 'no';
                $data['seller_id'] = $info['seller_id'];
                $data['seller_price'] = str_ireplace(",", "", $info['seller_price']);

                $Condition = "
                    id_same='{$this->id_same}' 
                    AND date='{$date}'
                    AND origin_city='{$info['origin_city']}' 
                    AND destination_city='{$info['destination_city']}'
                    AND airline='{$info['airline']}' 
                    AND fly_code='{$info['fly_code']}' 
                    AND vehicle_grade='{$current_vehicle_grade}'
                    AND type_user='{$this->type_user}' 
                    AND age='{$info['age' . $i]}'
                    ";
                $Model->setTable("reservation_ticket_tb");
                $res[] = $Model->update($data, $Condition);
            } else {
                $res[] = "0";
            }
        }

        if (in_array('0', $res)) {
            return 'error';
        } else {
            return 'success';
        }
    }
    #region getTypeVehicle
    public function getTypeVehicle($id) {
        $Model = Load::library('Model');

        $sqlVehicle = " select
                                V.name
                          from 
                                reservation_fly_tb F
	                            LEFT JOIN reservation_type_of_vehicle_tb V ON F.type_of_vehicle_id = V.id 
                          where F.id='{$id}'";
        $result = $Model->load($sqlVehicle);

        return $result['name'];
    }
    #endregion

    //تخصیص کد یکسان برای درج بلیط ها//
    public function GetIdSame()
    {
        $Model = Load::library('Model');
        $sql = "select max(id_same) from reservation_ticket_tb ";
        $result = $Model->load($sql);
        if (empty($result)) {
            $id_same = 1;
        } else {
            $id_same = $result['max(id_same)'] + 1;
        }

        return $id_same;
    }

    //////////کمسیون کاربر انتخاب شده//////////
    public function GetComition($type_user)
    {
        $Model = Load::library('Model');

        $sql = "SELECT * FROM counter_type_tb WHERE id='{$type_user}'";
        $counter = $Model->load($sql);

        return $counter['discount_hotel'];
    }

    //////////آرشیو بلیط ها//////////
    public function TicketArchive()
    {

        $Model = Load::library('Model');

        $sql = "select 
                    id,
                    id_same,
                    fly_code,
                    date,
                    type_user,
                    vehicle_grade,
                    exit_hour
               from 
                    reservation_ticket_tb
               where is_del='no'
               group by
                    id_same,
                    fly_code,
                    date,
                    exit_hour,
                    type_user,
                    vehicle_grade
              ";
        $result = $Model->select($sql);
        return $result;

    }
    /////////////////////////////////افزودن بلیط/////////////////////////////////
    ////////////////////////////////////End//////////////////////////////////////


    /////////////////////////////////مشاهده بلیط/////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    //////////گزارش چارتر//////////
    public function charterReport()
    {
        $date = dateTimeSetting::jtoday('');

        $Model = Load::library('Model');

        // گزارش پروازها
        $sql = " SELECT T.*, 
                 SUM(T.fly_total_capacity) as total_capacity,
                 SUM(T.maximum_buy) as total_maximum_buy,
                 SUM(T.fly_full_capacity) as total_full_capacity,
                 MIN(T.date) as minData,
                 MAX(T.date) as maxDate,
                 F.type_of_vehicle_id,
                 F.time
             FROM reservation_ticket_tb T 
             LEFT JOIN reservation_fly_tb F ON T.fly_code=F.id
             WHERE T.age='ADL' AND T.is_del='no' AND T.date >= {$date}
             GROUP BY T.id_same, T.fly_code, T.airline ";
        $ticket = $Model->select($sql);


        // list model haye class har daste az barname parvazi
        $sqlGroup = "SELECT 
                    T.id_same,
                    GROUP_CONCAT(DISTINCT VG.abbreviation ORDER BY VG.abbreviation SEPARATOR ' ، ') AS classes_list
                 FROM reservation_ticket_tb T
                 LEFT JOIN reservation_vehicle_grade_tb VG ON VG.id = T.vehicle_grade
                 WHERE VG.is_del = 'no'
                 GROUP BY T.id_same";
        $classes = $Model->select($sqlGroup);

        // map کردن خروجی بر اساس id_same
        $classMap = array();
        foreach ($classes as $c) {
            $classMap[$c['id_same']] = $c['classes_list'];
        }

        // افزودن کلاس‌ها به هر رکورد خروجی اصلی
        foreach ($ticket as $k => $t) {
            $ticket[$k]['classes_list'] = isset($classMap[$t['id_same']]) ? $classMap[$t['id_same']] : '';
        }

        return $ticket;
    }

    //////////آرشیو پرواز روزانه//////////
    public function charterArchiveFilterDay($flyCode, $airline, $idSame)
    {

        $date = dateTimeSetting::jtoday('');

        $Model = Load::library('Model');
        $sql = " SELECT *
                 FROM reservation_ticket_tb 
                 WHERE 
                     id_same='{$idSame}' AND fly_code='{$flyCode}' 
                     AND airline='{$airline}' AND date < {$date} 
                     AND age = 'ADL' AND is_del='no'
                 ORDER BY id ASC";
        $ticket = $Model->select($sql);
        return $ticket;

    }


    //////////گزارش پرواز روزانه//////////
    public function charterReportFilterDay($flyCode, $airline, $idSame)
    {

        $date = dateTimeSetting::jtoday('');

        $Model = Load::library('Model');
        $sql = " SELECT *
                 FROM reservation_ticket_tb
                 WHERE 
                     id_same='{$idSame}' AND fly_code='{$flyCode}' 
                     AND airline='{$airline}' AND date >= {$date} 
                     AND is_del='no'
                 GROUP BY date
                 ORDER BY id ASC";
        $ticket = $Model->select($sql);
        return $ticket;

    }


    //////////گزارش پرواز (کاربران - کلاس نرخی)//////////
    public function charterReportFilterCounter($flyCode, $airline, $date)
    {

        $Model = Load::library('Model');
        $sql = " SELECT *
                 FROM reservation_ticket_tb 
                 WHERE fly_code='{$flyCode}' AND airline='{$airline}' AND date='{$date}' AND is_del='no'
                 GROUP BY type_user,vehicle_grade
                 ORDER BY type_user,id ASC";
        $ticket = $Model->select($sql);
        return $ticket;
    }


    //////////لیست مسافران بلیط//////////
    public function manifest($airline, $flyCode, $date)
    {

        $Model = Load::library('Model');

        $sql = " SELECT id, date FROM  reservation_ticket_tb
                      WHERE
                          airline='{$airline}' AND fly_code='{$flyCode}' AND date='{$date}' AND fly_full_capacity>0 AND is_del='no'";
        $ticket = $Model->Select($sql);

        $this->date_flight = $ticket[0]['date'];

        $sql = " SELECT *
                 FROM book_local_tb
                 WHERE successfull='book' ";
        $count = 0;
        foreach ($ticket as $key => $val) {

            if ($count == 0) {
                $sql .= "  AND ( fk_id_ticket='{$val['id']}'  ";
            } else {
                $sql .= " OR fk_id_ticket='{$val['id']}' ";
            }


            $count++;
        }

        $sql .= " ) ";
        $book = $Model->select($sql);

        return $book;

    }
    /////////////////////////////////مشاهده بلیط/////////////////////////////////
    ////////////////////////////////////End//////////////////////////////////////


    public function logicalDeletionAllTicket($param)
    {
        $Model = Load::library('Model');
        $dateToday = dateTimeSetting::jtoday('');

        $data['is_del'] = 'yes';

        $condition = "id_same='{$param['id_same']}' 
                    AND origin_city='{$param['origin_city']}' 
                    AND destination_city='{$param['destination_city']}'
                    AND airline='{$param['airline']}'
                    AND fly_code='{$param['fly_code']}'
                    AND date>='{$dateToday}' ";
        $Model->setTable('reservation_ticket_tb');
        $res = $Model->update($data, $condition);
        if ($res) {
            return 'success : حذف تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در  تغییرات';
        }


    }

    public function logicalDeletionTicket($param)
    {
        $Model = Load::library('Model');

        $data['is_del'] = 'yes';

        $condition = " id='{$param['id']}' AND fly_full_capacity='0' ";
        $Model->setTable('reservation_ticket_tb');
        $res[] = $Model->update($data, $condition);

        // for CHD & INF
        $sql = "SELECT id_same, origin_city, destination_city, airline, fly_code, date FROM reservation_ticket_tb WHERE id='{$param['id']}'";
        $resultTicket = $Model->load($sql);

        $condition = " (id_same='{$resultTicket['id_same']}' AND fly_full_capacity='0'
                    AND origin_city='{$resultTicket['origin_city']}' 
                    AND destination_city='{$resultTicket['destination_city']}'
                    AND airline='{$resultTicket['airline']}'
                    AND fly_code='{$resultTicket['fly_code']}'
                    AND date='{$resultTicket['date']}') AND (age='CHD' OR age='INF') ";
        $Model->setTable('reservation_ticket_tb');
        $res[] = $Model->update($data, $condition);

        if (in_array('0', $res)) {
            return 'error : خطا در  تغییرات';
        } else {
            return 'success : حذف تغییرات با موفقیت انجام شد';
        }


    }


    //////////گزارش پرواز بر اساس کد یکسان//////////
    public function charterReportByIdSame($id_same, $start_date, $end_date)
    {
        $resultTicket = $this->getModel('reservationTicketModel')
            ->get()
            ->where('id_same',$id_same)
            ->where('date',$start_date ,'>=')
            ->where('date',$end_date,'<=')
            ->all();
        $this->ticket = $resultTicket[0];
        $expTime = explode(":", $resultTicket[0]['exit_hour']);
        $this->ticket['hours'] = $expTime[0];
        $this->ticket['minutes'] = $expTime[1];
        foreach ($resultTicket as $user) {
            $this->users[$user['type_user']]['type_user'] = $user['type_user'];
            $this->users[$user['type_user']]['comition_ticket'] = $user['comition_ticket'];
            $this->users[$user['type_user']]['maximum_buy'] = $user['maximum_buy'];
            $this->priceTicket[$user['age']] = $user;
        }

        $ticketTable = $this->getModel('reservationTicketModel')->getTable();
        $agencyLockSeatTable = $this->getModel('agencyLockSeatModel')->getTable();
        $vehicleGradeTable = $this->getModel('reservationVehicleGradeModel')->getTable();

        $data_lock_seats  = $this->getModel('agencyLockSeatModel')
            ->get([
                'agency_id',
                $agencyLockSeatTable.'.ticket_id',
                $agencyLockSeatTable.'.count_agency',
                't.date',
                'VG.abbreviation',
                't.vehicle_grade'
            ])
            ->joinSimple(
                [$ticketTable, 't'],
                't.id',
                $agencyLockSeatTable.'.ticket_id',
                'LEFT'
            )->joinSimple(
                [$vehicleGradeTable, 'VG'],
                'VG.id',
                't.vehicle_grade',
                'LEFT'
            )
            ->where( $agencyLockSeatTable.'.id_same', $id_same)
            ->all();
        foreach ($data_lock_seats as $key=>$lock_seat) {
            // محاسبه روز هفته
            $jy = substr($lock_seat['date'], 0, 4);
            $jm = substr($lock_seat['date'], 4, 2);
            $jd = substr($lock_seat['date'], 6, 2);
            $DateMiladi = dateTimeSetting::jalali_to_gregorian($jy, $jm, $jd, '-');
            $dayName =dateTimeSetting::jdate('l', strtotime($DateMiladi));
            switch ($dayName) {
                case 'شنبه':
                    $weekNumber = 0;
                    break;

                case 'یکشنبه':
                    $weekNumber = 1;
                    break;

                case 'دوشنبه':
                    $weekNumber = 2;
                    break;

                case 'سه‌شنبه':
                case 'سه شنبه': // اگر جای ــ استفاده نشده بود
                    $weekNumber = 3;
                    break;

                case 'چهارشنبه':
                    $weekNumber = 4;
                    break;

                case 'پنجشنبه':
                    $weekNumber = 5;
                    break;

                case 'جمعه':
                    $weekNumber = 6;
                    break;

                default:
                    $weekNumber = -1; // حالت خطا یا ناشناخته
            }


            $agencyId   = $lock_seat['agency_id'];
            $ticketId   = $lock_seat['ticket_id'];
            $seatCount  = $lock_seat['count_agency'];

            if (!isset($this->ticket['agencies'][$agencyId])) {
                $this->ticket['agencies'][$agencyId] = [
                    'agency_id'   => $agencyId,
                    'agency_name' => $this->getController('agency')->getAgency($agencyId)['name_fa'],
                    'tickets'     => []
                ];
            }
            $this->ticket['agencies'][$agencyId]['tickets'][] = [
                'ticket_id'  => $ticketId,
                'dayName'    => $dayName,
                'dayNumber'  => $weekNumber,
                'idClass'    => $lock_seat['vehicle_grade'],
                'nameClass'  => $lock_seat['abbreviation'],
                'count'      => $seatCount
            ];

            /*
            $this->ticket['data_lock'][$lock_seat['agency_id']]['agency_count']  = $lock_seat['count_agency'];
            $members = json_decode($lock_seat['counters'],true);
            foreach ($members as $key_member=>$member){
                $info_member = $this->getController('members')->getMember($key_member) ;
                $this->ticket['data_lock'][$lock_seat['agency_id']]['counters'][$key_member]['member_name'] = $info_member['name'].' '.$info_member['family'] ;
                $this->ticket['data_lock'][$lock_seat['agency_id']]['counters'][$key_member]['count'] = $member ;
                $this->ticket['data_lock'][$lock_seat['agency_id']]['counters'][$key_member]['id'] = $key_member ;

            }
            $this->ticket['data_lock'][$lock_seat['agency_id']]['agency_name']= $this->getController('agency')->getAgency($lock_seat['agency_id'])['name_fa'];
            */
        }


    }


    public function editOneTicket($param)
    {
        $Model = Load::library('Model');
        $id_same = $this->GetIdSame();

        for ($i = 1; $i <= 3; $i++) {

            $data['id_same'] = $id_same;
            $data['type_of_vehicle'] = $param['type_of_vehicle'];
            $data['day_onrequest'] = $param['day_onrequest'];
            $data['fly_total_capacity'] = $param['total_capacity'];
            $data['remaining_capacity'] = $param['total_capacity'];
            $data['exit_hour'] = $param['hours'] . ":" . $param['minutes'];
            $data['description_ticket'] = $param['description_ticket'];
            $data['services_ticket'] = $param['services_ticket'];

            $comition_ticket = $param['comition_ticket'];
            $maximum_buy = $param['maximum_buy'];

            $cost_two_way = str_ireplace(",", "", $param['cost_two_way' . $i]);
            $commission_agency_two_way = ($cost_two_way * $comition_ticket) / 100;
            $commission_counter_two_way = 0;
            $cost_two_way_print = str_ireplace(",", "", $param['cost_two_way_print' . $i]);;
            $cost_one_way = str_ireplace(",", "", $param['cost_one_way' . $i]);
            $commission_agency_one_way = ($cost_one_way * $comition_ticket) / 100;
            $commission_counter_one_way = 0;
            $cost_one_way_print = str_ireplace(",", "", $param['cost_one_way_print' . $i]);
            $cost_Ndays = str_ireplace(",", "", $param['cost_Ndays' . $i]);


            $data['maximum_buy'] = $maximum_buy;
            $data['comition_ticket'] = $comition_ticket;
            $data['cost_two_way'] = $cost_two_way;
            $data['cost_two_way_print'] = $cost_two_way_print;
            $data['cost_one_way'] = $cost_one_way;
            $data['cost_one_way_print'] = $cost_one_way_print;
            $data['cost_Ndays'] = $cost_Ndays;
            $data['comision_agency_two_way'] = $commission_agency_two_way;
            $data['comision_counter_two_way'] = $commission_counter_two_way;
            $data['comision_agency_one_way'] = $commission_agency_one_way;
            $data['comision_counter_one_way'] = $commission_counter_one_way;

            if (isset($param['chk_flag_special']) && $param['chk_flag_special']=1){
                $data['flag_special'] = 'yes';
            }else{
                $data['flag_special'] = 'no';
            }

            $ConditionFirst = " id='{$param['id'.$i]}' ";
            $Model->setTable("reservation_ticket_tb");
            $res[] = $Model->update($data, $ConditionFirst);

        }


        if (in_array('0', $res)) {
            return 'error : خطا در  تغییرات';
        } else {
            return 'success : تغییرات با موفقیت انجام شد';
        }


    }


    #region getDaysWeekAnyTicket
    public function getDaysWeekAnyTicket($idSame, $sDate, $eDate)
    {

        $Model = Load::library('Model');
        $sql = " SELECT date
                 FROM reservation_ticket_tb 
                 WHERE 
                     id_same='{$idSame}' AND 
                     date>= {$sDate} AND 
                     date<= {$eDate} AND 
                     age='ADL' AND 
                     is_del='no'
                 ";
        $resultTicket = $Model->select($sql);
        $result = array();
        foreach ($resultTicket as $val) {
            $y = substr($val['date'], 0, 4);
            $m = substr($val['date'], 4, 2);
            $d = substr($val['date'], 6, 2);
            $jmktime = dateTimeSetting::jmktime(0, 0, 0, $m, $d, $y);
            $nameDay = dateTimeSetting::jdate("w", $jmktime, "", "", "en");
            $result[$nameDay] = $nameDay;
        }
        sort($result);
        return $result;
    }
    #endregion



    #region setCancellationsPercentageTickets
    public function setCancellationsPercentageTickets($param)
    {
        $Model = Load::library('Model');
        $dateNow = date('Y-m-d');
        $expDate = explode("-", $dateNow);
        $date =  dateTimeSetting::gregorian_to_jalali($expDate[0], $expDate[1], $expDate[2], '-');
        date_default_timezone_set("Asia/Tehran");
        $time = date('H:i:s');

        $res = [];
        $data['fk_ticket_id_same'] = $param['idSame'];
        $data['create_date_in'] = $date;
        $data['create_time_in'] = $time;
        $data['is_del'] = 'no';

        $resultCheck = $this->getCancellationsPercentageTickets($param['idSame']);
        $arrayCheck = [];
        foreach ($resultCheck as $val){
            $arrayCheck[$val['time_cancel'].$val['percent_cancel']] = $val['id'];
        }

        for ($i = 1; $i <= $param['rowCount']; $i++) {

            $data['time_cancel'] = $param['time_cancel_' . $i];
            $data['percent_cancel'] = $param['percent_cancel_' . $i];

            if (empty($arrayCheck) || empty($arrayCheck[$data['time_cancel'].$data['percent_cancel']])){
                $Model->setTable("reservation_cancellations_tickets_tb");
                $res[] = $Model->insertLocal($data);
            } else {
                $res[] = false;
            }


        }


        if (in_array('0', $res)) {
            return 'error : در اطلاعات درصد کنسلی تکراری وجود داشت';
        } else {
            return 'success : تغییرات با موفقیت انجام شد';
        }


    }
    #endregion




    #region updateCancellationsTickets
    public function updateCancellationsTickets($param)
    {
        $Model = Load::library('Model');
        $dateNow = date('Y-m-d');
        $expDate = explode("-", $dateNow);
        $date =  dateTimeSetting::gregorian_to_jalali($expDate[0], $expDate[1], $expDate[2], '-');
        date_default_timezone_set("Asia/Tehran");
        $time = date('H:i:s');

        $res = [];
        $data['create_date_in'] = $date;
        $data['create_time_in'] = $time;

        $resultCheck = $this->getCancellationsPercentageTickets($param['ticket_id_same']);
        $arrayCheck = [];
        foreach ($resultCheck as $val){
            $arrayCheck[$val['time_cancel'].$val['percent_cancel']] = $val['id'];
        }

        $data['time_cancel'] = $param['time_cancel'];
        $data['percent_cancel'] = $param['percent_cancel'];

        if (empty($arrayCheck) || empty($arrayCheck[$data['time_cancel'].$data['percent_cancel']])){

            $conditionFirst = " id='{$param['id']}' ";
            $Model->setTable("reservation_cancellations_tickets_tb");
            $res = $Model->update($data, $conditionFirst);

        } else {
            $res = false;
        }


        if ($res) {
            return 'success : تغییرات با موفقیت انجام شد';
        } else {
            return 'error : در اطلاعات درصد کنسلی تکراری وجود داشت';
        }


    }
    #endregion



    #region getCancellationsPercentageTickets
    public function getCancellationsPercentageTickets($idSameTicket)
    {
        $Model = Load::library('Model');
        $sql = " SELECT * FROM reservation_cancellations_tickets_tb  WHERE  fk_ticket_id_same='{$idSameTicket}' AND is_del='no' ";
        $resultTicket = $Model->select($sql);

        return $resultTicket;
    }
    #endregion



    #region getCancellationsTicket
    public function getCancellationsTicket($id, $dateFlight, $timeFlight)
    {
        $Model = Load::library('Model');

        $dateNow = date("Ymd");
        /*$timeHour = date("H");
        $timeMinutes = date("i");
        $timeNow = ($timeHour * 60) + $timeMinutes;*/

        $expHour = explode(":", $timeFlight);
        $time = $expHour[0];

        $dateFlight = str_replace("-", "", $dateFlight);
        $dateFlight = str_replace("/", "", $dateFlight);

        // چند ساعت مانده به پرواز //
        $hours = (($dateFlight - $dateNow) * 24) + $time;

        if ($hours > 73 ){ $hours = 73; }
        $sql = "
            SELECT
                cancellations_tickets.percent_cancel AS percentCancel 
            FROM
                reservation_cancellations_tickets_tb AS cancellations_tickets
                INNER JOIN reservation_ticket_tb AS ticket ON ticket.id_same = cancellations_tickets.fk_ticket_id_same
            WHERE
                ticket.id = '{$id}' 
                AND cancellations_tickets.is_del = 'no' 
                AND cancellations_tickets.time_cancel >= '{$hours}' 
            ORDER BY
                cancellations_tickets.time_cancel 
                LIMIT 1
        ";
        $result = $Model->load($sql);
        if (!empty($result)){
            return $result['percentCancel'];
        } else {
            $sql = "
            SELECT
                max( cancellations_tickets.percent_cancel ) AS percentCancel 
            FROM
                reservation_cancellations_tickets_tb AS cancellations_tickets
                INNER JOIN reservation_ticket_tb AS ticket ON ticket.id_same = cancellations_tickets.fk_ticket_id_same
            WHERE
                ticket.id = '{$id}' 
                AND cancellations_tickets.is_del = 'no' 
            ORDER BY
                cancellations_tickets.time_cancel 
                LIMIT 1
        ";
            $result = $Model->load($sql);
            if (!empty($result)){
                return $result['percentCancel'];
            } else {
                return 0;
            }
        }




    }
    #endregion


    #region setRequestCancelReservationTicket
    public function setRequestCancelReservationTicket($param)
    {

        $Model = Load::library('Model');

        $sql = " SELECT *,  "
            . " (Select COUNT(passenger_age) FROM book_local_tb WHERE passenger_age='Adt' AND request_number='{$param['requestNumber']}' AND request_cancel <> 'confirm') AS Adt_passenger ,"
            . " (Select COUNT(passenger_age) FROM book_local_tb WHERE passenger_age='Chd' AND request_number='{$param['requestNumber']}' AND request_cancel <> 'confirm') AS Chd_passenger ,"
            . " (Select COUNT(passenger_age) FROM book_local_tb WHERE passenger_age='Inf' AND request_number='{$param['requestNumber']}' AND request_cancel <> 'confirm') AS Inf_passenger "
            . " FROM book_local_tb WHERE request_number='{$param['requestNumber']}' AND request_cancel <> 'confirm' ";
        $ticket = $Model->load($sql);
        $nationalCodes = [];
        $ages = [];
        $prices = 0;
        foreach ($param['nationalCodes'] as $i => $rec) {
            $exp[] = explode('-', $rec);
            $nationalCodes[] = $exp[$i][0];
            $ages[] = $exp[$i][1];
            $prices += $exp[$i][2];
        }

        $adt = 0;
        $chd = 0;
        $inf = 0;
        foreach ($ages as $age) {
            switch ($age) {
                case 'Adt':
                    $adt++;
                    break;
                case 'Chd':
                    $chd++;
                    break;
                case 'Inf':
                    $inf++;
                    break;
            }
        }

        if (($ticket['Adt_passenger'] - $adt) >= 1 || (($inf + $chd + $adt) == ($ticket['Adt_passenger'] + $ticket['Chd_passenger'] + $ticket['Inf_passenger']))) {

            $ListNationalCode = implode(', ', $nationalCodes);
            $sqlCheck  = "
                SELECT cancel_ticket.NationalCode
                FROM
                  cancel_ticket_details_tb AS cancel_ticket_details
                  INNER JOIN cancel_ticket_tb AS cancel_ticket ON cancel_ticket_details.id = cancel_ticket.IdDetail
                WHERE
                  cancel_ticket_details.RequestNumber = '{$param['requestNumber']}'
                  AND cancel_ticket.NationalCode IN ({$ListNationalCode})
            ";
            $resultCheck = $Model->select($sqlCheck);
            if (empty($resultCheck)){

                $discountPrice = ($param['percentCancel'] * $prices) / 100;
                $data['PriceIndemnity'] = $prices - $discountPrice;
                $data['PercentIndemnity'] = $param['percentCancel'];
                $data['RequestNumber'] = $param['requestNumber'];
                $data['MemberId'] = $ticket['member_id'];
                $data['FactorNumber'] = $ticket['factor_number'];
                $data['ReasonMember'] = $_POST['reasons'];
                $data['AccountOwner'] = $_POST['accountOwner'];
                $data['CardNumber'] = $_POST['cardNumber'];
                $data['NameBank'] = $_POST['nameBank'];
                $data['PercentNoMatter'] = $_POST['percentNoMatter'];
                $data['status'] = 'RequestMember';
                $data['DateRequestMemberInt'] = time();
                $Model->setTable('cancel_ticket_details_tb');
                $result = $Model->insertLocal($data);
                $id = $Model->getLastId();

                if ($result) {

                    foreach ($nationalCodes as $code) {

                        $d['IdDetail'] = $id;
                        $d['NationalCode'] = $code;
                        $Model->setTable('cancel_ticket_tb');
                        $Model->insertLocal($d);
                    }

                    //sms to site manager
                    $smsController = Load::controller('smsServices');
                    $objSms = $smsController->initService('1');
                    if ($objSms) {
                        $messageVariables = array(
                            'sms_name' => $ticket['member_name'],
                            'sms_service' => 'بلیط',
                            'sms_factor_number' => $ticket['request_number'],
                            'sms_airline' => $ticket['airline_name'],
                            'sms_origin' => $ticket['origin_city'],
                            'sms_destination' => $ticket['desti_city'],
                            'sms_flight_number' => $ticket['flight_number'],
                            'sms_flight_date' => functions::DateJalali($ticket['date_flight']),
                            'sms_flight_time' => $ticket['time_flight'],
                            'sms_agency' => CLIENT_NAME,
                            'sms_agency_mobile' => CLIENT_MOBILE,
                            'sms_agency_phone' => CLIENT_PHONE,
                            'sms_agency_email' => CLIENT_EMAIL,
                            'sms_agency_address' => CLIENT_ADDRESS,
                        );
                        $smsArray = array(
                            'smsMessage' => $smsController->getUsableMessage('cancelRequestTicketToManager', $messageVariables),
                            'cellNumber' => CLIENT_MOBILE,
                            'smsMessageTitle' => 'cancelRequestTicketToManager',
                            'memberID' => (!empty($ticket['member_id']) ? $ticket['member_id'] : ''),
                            'receiverName' => $messageVariables['sms_name'],
                        );
                        $smsController->sendSMS($smsArray);
                    }

                    if (Session::IsLogin()) {
                        echo 'success : در خواست کنسلی خرید شما با موفقیت ثبت شد،برای پیگیری نتیجه لطفا از منوی کاربری->کنسلی استفاده کنید';
                    } else {
                        echo 'success : در خواست کنسلی خرید شما با موفقیت ثبت شد';
                    }

                } else {
                    echo 'error : خطای غیر منتظره لطفا با پشتیبانی تماس بگیرید';
                }

            } else {
                echo 'error : امکان ثبت کنسلی برای هر نفر فقط یک بار است. لطفا افراد تکراری را انتخاب نکنید.';
            }


        } else {
            echo 'error : تعدادباقی مانده بزرگسال نمیتواند کمتر از تعداد کودک و نوزاد باشد';
        }

    }
    #endregion


    #region setConfirmCancelReservationTicket
    public function setConfirmCancelReservationTicket($requestNumber, $id)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $sql  = "
                SELECT 
                  *,
                  cancel_ticket_details.id AS cancel_ticket_details_id,
                  cancel_ticket.id AS cancel_ticket_id
                FROM
                  cancel_ticket_details_tb AS cancel_ticket_details
                  INNER JOIN cancel_ticket_tb AS cancel_ticket ON cancel_ticket_details.id = cancel_ticket.IdDetail
                WHERE
                  cancel_ticket_details.RequestNumber = '{$requestNumber}'
            ";
        $resultCancel = $Model->select($sql);
        if (!empty($resultCancel)){

            $data['Status'] = "ConfirmCancel";
            $data['DateRequestCancelClientInt'] = time();
            $data['DateSetIndemnityInt'] = time();
            $data['DateConfirmClientInt'] = time();

            $Model->setTable('cancel_ticket_details_tb');
            $Condition = "id={$id} AND RequestNumber='{$requestNumber}'";
            $UpdateResult = $Model->update($data, $Condition);
            if ($UpdateResult) {

                $sqlBook = "SELECT  * FROM  book_local_tb  WHERE request_number='{$requestNumber}'";
                $resultBook = $Model->load($sqlBook);

                $typeMember = functions::TypeUser($resultBook['member_id']);
                if ($typeMember == 'Counter'){
                    // به خریدار باید برگردانده شود.
                    $detail['fk_agency_id'] = $resultBook['agency_id'];
                    $detail['credit'] = $resultCancel[0]['PriceIndemnity'];
                    $detail['type'] = 'increase';
                    $detail['comment'] = 'تایید کنسلی بلیط رزرواسیون و برگرداندن اعتبار (از مبلغ کل درصد کنسلی کم شده)';
                    $detail['credit_date'] = dateTimeSetting::jdate("Y-m-d", time());
                    $detail['reason'] = 'deposit';
                    $detail['creation_date_int'] = time();
                    $detail['member_id'] = $resultBook['member_id'];
                    $detail['requestNumber'] = $resultBook['factor_number'];

                    $Model->setTable('credit_detail_tb');
                    $Model->insertLocal($detail);
                }


                // کنسل شدن بلیط
                $Condition = "request_number='{$requestNumber}'";

                $nationalCode = [];
                foreach ($resultCancel as $info){
                    $nationalCode[] =  $info['NationalCode'];
                }
                $ListNationalCode = implode(', ', $nationalCode);
                $Condition .= " AND (passenger_national_code IN ({$ListNationalCode}) OR passportNumber IN ({$ListNationalCode})) ";

                $dataBook['request_cancel'] = 'confirm';

                $Model->setTable('book_local_tb');
                $UpdateBook = $Model->update($dataBook, $Condition);

                $ModelBase->setTable('report_tb');
                $UpdateBookBase = $ModelBase->update($dataBook, $Condition);

                if ($UpdateBook && $UpdateBookBase){

                    //sms to buyer
                    $smsController = Load::controller('smsServices');
                    $objSms = $smsController->initService('1');
                    if ($objSms) {

                        //to member
                        $messageVariables = array(
                            'sms_name' => $resultBook['member_name'],
                            'sms_service' => 'بلیط',
                            'sms_factor_number' => $resultBook['request_number'],
                            'sms_airline' => $resultBook['airline_name'],
                            'sms_origin' => $resultBook['origin_city'],
                            'sms_destination' => $resultBook['desti_city'],
                            'sms_flight_number' => $resultBook['flight_number'],
                            'sms_flight_date' => dateTimeSetting::jdate("Y-F-d", functions::ConvertToDateJalaliInt($resultBook['date_flight'])),
                            'sms_flight_time' => $resultBook['time_flight'],
                            'sms_flight_indemnity' => $resultCancel[0]['PercentIndemnity'],
                            'sms_agency' => CLIENT_NAME,
                            'sms_agency_mobile' => CLIENT_MOBILE,
                            'sms_agency_phone' => CLIENT_PHONE,
                            'sms_agency_email' => CLIENT_EMAIL,
                            'sms_agency_address' => CLIENT_ADDRESS,
                        );
                        $smsArray = array(
                            'smsMessage' => $smsController->getUsableMessage('cancelConfirmTicket', $messageVariables),
                            'cellNumber' => $resultBook['member_mobile'],
                            'smsMessageTitle' => 'cancelConfirmTicket',
                            'memberID' => (!empty($resultBook['member_id']) ? $resultBook['member_id'] : ''),
                            'receiverName' => $messageVariables['sms_name'],
                        );
                        $smsController->sendSMS($smsArray);

                        //to first passenger
                        $messageVariables['sms_name'] = $resultBook['passenger_name'] . ' ' . $resultBook['passenger_family'];
                        $smsArray = array(
                            'smsMessage' => $smsController->getUsableMessage('cancelConfirmTicket', $messageVariables),
                            'cellNumber' => $resultBook['mobile_buyer'],
                            'smsMessageTitle' => 'cancelConfirmTicket',
                            'memberID' => (!empty($resultBook['member_id']) ? $resultBook['member_id'] : ''),
                            'receiverName' => $messageVariables['sms_name'],
                        );
                        $smsController->sendSMS($smsArray);
                    }

                    return "success : در خواست شما با موفقیت انجام شد";
                } else {
                    return "error : خطا در ثبت در خواست، لطفا مجددا تلاش نمائید";
                }



            } else {
                return "error : خطا در ثبت در خواست، لطفا مجددا تلاش نمائید";
            }

        } else {
            return "error : خطا در ثبت در خواست، لطفا مجددا تلاش نمائید";
        }



    }
    #endregion
/* Get flight status for modal display */
    public function getFlightStatusByIdSame($params)
    {
        try {
            $ticket_id = isset($params['ticket_id']) ? $params['ticket_id'] : '';
            // Get tickets for this specific flight
            $ticket = $this->getModel('reservationTicketModel')
                ->get([
                    'id_same',
                    'status'
                ], true)
                ->where('id',$ticket_id)
                ->all();
            return [
                'status' => true,
                'data' => $ticket[0]['status'],
                'idSame' => $ticket[0]['id_same']
            ];

        } catch (Exception $e) {
            functions::insertLog("Error in getFlightStatusByIdSame: " . $e->getMessage(), 'reportTicketError');
            return [
                'status' => false,
                'message' => 'خطا در دریافت وضعیت پرواز'
            ];
        }
    }

    public function setFlightStatusByIdSame($params)
    {
        try {
            $idSame = isset($params['idSame']) ? $params['idSame'] : '';
            $status = isset($params['status']) ? $params['status'] : '';

            if (!$idSame || !$status) {
                return [
                    'status' => false,
                    'message' => 'شناسه یا وضعیت نامعتبر است'
                ];
            }

           $res= $this->getModel('reservationTicketModel')
                ->updateWithBind(['status' => $status], ['id_same' => $idSame]);
            return [
                'status' => true,
                'message' => 'وضعیت پرواز با موفقیت ذخیره شد'
            ];
        } catch (Exception $e) {
            functions::insertLog("Error in setFlightStatusByIdSame: " . $e->getMessage(), 'reportTicketError');
            return [
                'status' => false,
                'message' => 'خطا در ذخیره وضعیت پرواز'
            ];
        }
    }

    public function classesListByIdSame($IdSame){
        $ticketTable = $this->getModel('reservationTicketModel')->getTable();
        $gradeTable  = $this->getModel('reservationVehicleGradeModel')->getTable();
        // گرفتن دیتا از مدل با ساختار استاندارد پروژه شما
        $classRows = $this->getModel('reservationTicketModel')
            ->get([
                'id',
                $ticketTable.'.fly_total_capacity',
                $ticketTable.'.exit_hour',
                $ticketTable.'.type_of_vehicle',
                'G.id AS grade_id',
                'G.abbreviation'
            ])
            ->joinSimple(
                [$gradeTable, 'G'],
                $ticketTable.'.vehicle_grade',
                'G.id',
                'LEFT'
            )
            ->where('G.is_del', 'no')
            ->where($ticketTable.'.id_same', $IdSame)
            ->groupBy($ticketTable.'.vehicle_grade')
            ->all();

        // تبدیل خروجی
        $classMap = array();
        foreach ($classRows as $row) {
            // جلوگیری از تکرار آیتم‌ها
            $exists = false;
            foreach ($classMap as $item) {
                if ($item['id'] == $row['grade_id']) {
                    $exists = true;
                    break;
                }
            }

            if (!$exists && !empty($row['grade_id'])) {
                $classMap[] = [
                    'id' => $row['grade_id'],
                    'abbreviation' => $row['abbreviation']
                ];
            }
        }
        return $classMap;
    }
    public function classesDetailByIdSame($IdSame){
        $classRows = $this->getModel('reservationTicketModel')
            ->get([
                'id',
                'vehicle_grade',
                'date',
                'fly_total_capacity',
                'exit_hour',
                'type_of_vehicle',
            ])
            ->where('id_same', $IdSame)
            ->groupBy([
               'vehicle_grade',
                'date'
                ])
            ->all();

        // تبدیل خروجی
        $classMap = array();
        foreach ($classRows as $row) {
            // محاسبه روز هفته
            $jy = substr($row['date'], 0, 4);
            $jm = substr($row['date'], 4, 2);
            $jd = substr($row['date'], 6, 2);
            $DateMiladi = dateTimeSetting::jalali_to_gregorian($jy, $jm, $jd, '-');
            $dayName =dateTimeSetting::jdate('l', strtotime($DateMiladi));
            switch ($dayName) {
                case 'شنبه':
                    $weekNumber = 0;
                    break;

                case 'یکشنبه':
                    $weekNumber = 1;
                    break;

                case 'دوشنبه':
                    $weekNumber = 2;
                    break;

                case 'سه‌شنبه':
                case 'سه شنبه': // اگر جای ــ استفاده نشده بود
                    $weekNumber = 3;
                    break;

                case 'چهارشنبه':
                    $weekNumber = 4;
                    break;

                case 'پنجشنبه':
                    $weekNumber = 5;
                    break;

                case 'جمعه':
                    $weekNumber = 6;
                    break;

                default:
                    $weekNumber = -1; // حالت خطا یا ناشناخته
            }

            $classMap[$weekNumber.'_'.$row['vehicle_grade']] = [
                'id'=>$row['id'],
                'vehicle_grade' => $row['vehicle_grade'],
                'flyTotalCapacity' => $row['fly_total_capacity'],
                'exitHour' => $row['exit_hour'],
                'typeOfVehicle' => $row['type_of_vehicle'],
                'dayDate' => $weekNumber
            ];
        }
        return $classMap;
    }

}

?>
