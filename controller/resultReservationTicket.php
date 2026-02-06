<?php


/**
 * Class resultReservationTicket
 * @property resultReservationTicket $resultReservationTicket
 */
class resultReservationTicket extends clientAuth
{

    public $ticket;
    public $totalQty;
    public $direction;
    public $errorSearch = false;
    public $errorPage = false;
    public $errorMessage;

    public function __construct() {


        if (isset($_SESSION['StatusRefresh']) && $_SESSION['StatusRefresh'] != '') {
            unset($_SESSION['StatusRefresh']);
        }
    }

    #region [getRegion]
    public function getRegion($id) {
        $Model = Load::library('Model');

        $sql = " SELECT * FROM reservation_region_tb WHERE id='{$id}' AND is_del='no'";
        $region = $Model->load($sql);

        return $region;
    }
    #endregion

    #region [getAirline]
    public function getAirline($id) {
        $ModelBase = Load::library('ModelBase');

        $sql = " SELECT abbreviation, name_fa,name_en FROM airline_tb WHERE id='{$id}' AND del='no'";
        $airline = $ModelBase->load($sql);

        return $airline;
    }
    #endregion

    #region [getCabinType]
    public function getCabinType($id) {
        $Model = Load::library('Model');

        $sql = " SELECT name, abbreviation FROM reservation_vehicle_grade_tb WHERE id='{$id}' AND is_del='no'";
        $result = $Model->load($sql);

        return $result['abbreviation'];
    }
    #endregion


    #region [getTypeVehicle]
    public function getTypeVehicle($id) {
        $Model = Load::library('Model');

        $sql = " SELECT name FROM reservation_type_of_vehicle_tb WHERE id='{$id}' AND is_del='no'";
        $result = $Model->load($sql);

        return $result['name'];
    }
    #endregion

    #region [getTypeVehicle]
    public function getTypeVehicleByTicketId($id) {
        $Model = Load::library('Model');

        $sql = " select
                        V.name
                  from 
                        reservation_ticket_tb T INNER JOIN reservation_fly_tb F ON T.fly_code=F.id
                        LEFT JOIN reservation_type_of_vehicle_tb V ON F.type_of_vehicle_id=V.id
                  where T.id='{$id}' AND T.is_del='no'";
        $result = $Model->load($sql);

        return $result['name'];
    }
    #endregion

    #region [getTypeVehicle]
    public function getInfoTransportCompanies($id) {
        $Model = Load::library('Model');

        $sql = " select
                        *
                  from 
                        reservation_transport_companies_tb
                  where fk_id_type_of_vehicle='{$id}' AND is_del='no'";
        $result = $Model->load($sql);

        return $result;
    }

    #endregion

    public function format_hour($num) {
        $time = date("H:i", strtotime($num));
        return $time;
    }

    #region [Search ticket]

    /**
     * @param $origin
     * @param $destination
     * @param $date
     * @param null $multiWay
     * @param null $timeInterval
     * @return array|string
     */
    public function searchReservationTickets($origin, $destination, $date, $multiWay = null, $timeInterval = null) {

        $Model = Load::library('Model');
        $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        $SDate = str_replace("-", "", $date);

        if (trim($SDate) < trim($dateNow)) {
            $SDate = $dateNow;
        }

        if (isset($timeInterval) && $timeInterval != '') {
            $date1 = str_replace("-", "", $this->getController('reservationPublicFunctions')->dateNextFewDays($SDate, " - $timeInterval"));
            $date2 = str_replace("-", "", $this->getController('reservationPublicFunctions')->dateNextFewDays($SDate, " + $timeInterval"));
            if (trim($date1) < trim($dateNow)) {
                $date1 = $dateNow;
                $timeInterval = $timeInterval * 2;
                $date2 = $this->getController('reservationPublicFunctions')->dateNextFewDays($dateNow, " + $timeInterval");
            }

            $whereDate = " T.date>='{$date1}' AND T.date<='{$date2}' AND ";
            $whereDate_chd = " TC.date>='{$date1}' AND TC.date<='{$date2}' AND ";
            $whereDate_inf = " TI.date>='{$date1}' AND TI.date<='{$date2}' AND";
            $group = "group by T.fly_code, T.date, T.flag_special";

        } else {
            $date = str_replace("-", "", $date);
            $whereDate = "date='{$date}' AND";
            $whereDate_chd = " TC.date='{$date}' AND";
            $whereDate_inf = " TI.date='{$date}' AND";
            $group = "group by T.id_same, T.fly_code, T.flag_special";
        }

        if (isset($multiWay) && $multiWay == 'TwoWay') {
            $typePrice = 'cost_two_way';
        } else {
            $typePrice = 'cost_one_way';
        }
        $checkLogin = Session::IsLogin();
        if ($checkLogin) {
            $counter_type_id = functions::getCounterTypeId(Session::getUserId());
        } else {
            $counter_type_id = '5';
        }
        $sqlCheck = "select 
                        T.id,T.id_same, T.type_user, T.date, T.age, T.exit_hour, T.flag_special,
                        T.origin_city, T.destination_city, origin_airport, destination_airport,
                        T.origin_region, T.destination_region,
                        T.fly_tour_capacity, T.fly_total_capacity, T.fly_full_capacity,
                        T.vehicle_grade, T.maximum_buy, T.type_of_vehicle,
                        T.free, T.cost_two_way, T.cost_two_way_print, T.cost_one_way, T.cost_one_way_print,
                        T.cost_Ndays, T.comition_ticket, T.remaining_capacity,
                        F.fly_code, F.time, F.airline, F.vehicle_grade_id, T.day_onrequest,
                        VM.name, T.description_ticket, T.origin_country, T.destination_country, T.services_ticket,
                        (
                        select TC.{$typePrice}
                          from 
                                reservation_ticket_tb TC INNER JOIN reservation_fly_tb FC ON TC.fly_code=FC.id
                                LEFT JOIN reservation_vehicle_model_tb VMC ON FC.type_of_vehicle_id=VMC.id_type_of_vehicle
                          where  
                               FC.origin_airport='{$origin}' AND
                               FC.destination_airport='{$destination}' AND
                               {$whereDate_chd}
                               TC.age='CHD' AND
                               TC.is_del='no' AND TC.fly_code=T.fly_code
                          group by 
                              TC.fly_code
                        ) as cost_chd,
                        (
                        select TI.{$typePrice}
                          from 
                                reservation_ticket_tb TI INNER JOIN reservation_fly_tb FI ON TI.fly_code=FI.id
                                LEFT JOIN reservation_vehicle_model_tb VMI ON FI.type_of_vehicle_id=VMI.id_type_of_vehicle
                          where  
                               FI.origin_airport='{$origin}' AND
                               FI.destination_airport='{$destination}' AND
                               {$whereDate_inf}
                               TI.age='INF' AND
                               TI.is_del='no' AND TI.fly_code=T.fly_code
                          group by 
                              TI.fly_code
                        ) as cost_inf
                        
                  from 
                        reservation_ticket_tb T INNER JOIN reservation_fly_tb F ON T.fly_code=F.id
                        LEFT JOIN reservation_vehicle_model_tb VM ON T.type_of_vehicle=VM.id
                  where  
                       F.origin_airport='{$origin}' AND
                       F.destination_airport='{$destination}' AND
                       {$whereDate}
                       T.age='ADL' AND
                       T.type_user = '{$counter_type_id}'
                       AND T.is_del='no'
                  {$group}
                  order by 
                      T.date ASC ";

//        if(isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"],'safar360.com') == true ) {
//            echo $sqlCheck;
//            die();
//        }

        functions::insertLog('query==>' . $sqlCheck, 'check_sql_reservation');

        $resultCheck = $Model->select($sqlCheck);


        if (empty($resultCheck)) {
            $resultCheck = array();
        }

        $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        $timeHour = date("H");
        $timeMinutes = date("i");
        $timeNow = ($timeHour * 60) + $timeMinutes;

        $infoSearchTicket = array();
        $is_login = Session::IsLogin();
        $member_id = Session::getUserId();
        $is_counter = false;
        $member_info = [];
        if ($is_login) {

            $member_info = $this->getController('members')->getMember($member_id);
            $is_counter = ($member_info['fk_counter_type_id'] >= 1 && $member_info['counter_type_id'] < 5);

        }
        foreach ($resultCheck as $key => $val) {
            $count_reserve = $this->getCountBookReservationByAgency($val['id_same']);
            $capacity = $val['remaining_capacity'];
            if ($is_counter) {
                $data_lock_seat = $this->getModel('agencyLockSeatModel')->get()->where('id_same', $val['id_same'])->where('agency_id', $member_info['fk_agency_id'])->find();

                if ($data_lock_seat['count_agency'] > 0) {
                    $capacity = intval($data_lock_seat['count_agency']) - intval($count_reserve['count_ticket']);

                    $capacity_counters = json_decode($data_lock_seat['counters'], true);

                    if ($capacity > 0 && $capacity_counters) {
                        $used_capacity_user = 0;
                        foreach ($count_reserve['data'] as $item) {
                            if ($item['member_id'] === $member_id) {
                                $used_capacity_user += 1;
                            }
                        }
                        $capacity = $capacity_counters[$member_id] - $used_capacity_user;
                    }

                } else {
                    $data_lock_seats = $this->getModel('agencyLockSeatModel')->get()->where('id_same', $val['id_same'])->all();
                    $allocated_capacity = 0;
                    foreach ($data_lock_seats as $data_lock_seat) {
                        $allocated_capacity += $data_lock_seat['count_agency'];
                    }
                    $capacity = intval($capacity) - intval($allocated_capacity);
                }
            } else {
                $data_lock_seats = $this->getModel('agencyLockSeatModel')->get()->where('id_same', $val['id_same'])->all();
                if (!empty($data_lock_seats)) {
                    $allocated_capacity = 0;
                    foreach ($data_lock_seats as $data_lock_seat) {
                        $allocated_capacity += $data_lock_seat['count_agency'];
                    }
                    $capacity = intval($capacity) - intval($allocated_capacity);
                    if ($capacity > 0) {
                        $used_capacity_user = 0;
                        foreach ($count_reserve['data'] as $item) {
                            if ($item['member_id'] == '0') {
                                $used_capacity_user += 1;
                            }
                        }
                    }

                    $capacity = $capacity - $used_capacity_user;
                }
            }


            $expExitHour = explode(":", $val['exit_hour']);
            $exitHour = ($expExitHour[0] * 60) + $expExitHour[1];

            $timeOnRequest = ($val['day_onrequest'] * 60) + $timeNow;

            // اگر تاریخ و ساعت سرچ قبل از تاریخ ساعت حرکت بود نمایش بده //
            if (($date == $dateNow && $exitHour > $timeOnRequest) || ($date != $dateNow)) {

                $time = explode(":", $val['time']);
                $airline = $this->getAirline($val['airline']);
                $cabinType = $this->getCabinType($val['vehicle_grade_id']);
                $infoTransportCompanies = $this->getInfoTransportCompanies($val['airline']);
                $image = $infoTransportCompanies['pic'];

                // calculate discount price
                if ($val['comition_ticket'] > 0) {
                    $OnlinePrice = $val[$typePrice] - (($val['comition_ticket'] * $val[$typePrice]) / 100);
                    $OnlinePriceChd = $val['cost_chd'] - (($val['comition_ticket'] * $val['cost_chd']) / 100);
                    $OnlinePriceInf = $val['cost_inf'] - (($val['comition_ticket'] * $val['cost_inf']) / 100);
                } else {
                    $OnlinePrice = '';
                    $OnlinePriceChd = '';
                    $OnlinePriceInf = '';
                }

                $getTypeVehicle = $this->getTypeVehicleByTicketId($val['id']);
                $OriginRegion = $this->getRegion($val['origin_region']);
                $DestinationRegion = $this->getRegion($val['destination_region']);

                $infoSearchTicket[$key]['ID'] = $val['id'];
                $infoSearchTicket[$key]['FlightDate'] = substr($val['date'], "0", "4") . '/' . substr($val['date'], "4", "2") . '/' . substr($val['date'], "6", "2");
                $infoSearchTicket[$key]['FlightNumber'] = $val['fly_code'];
                $infoSearchTicket[$key]['Weight'] = $val['free'];
                $infoSearchTicket[$key]['Hour'] = $time[0];
                $infoSearchTicket[$key]['Minutes'] = $time[1];
                $infoSearchTicket[$key]['DepartureTime'] = $val['exit_hour'];
                $infoSearchTicket[$key]['TypeVehicle'] = $val['name'];
                $infoSearchTicket[$key]['VehicleName'] = $getTypeVehicle;
                $infoSearchTicket[$key]['OriginAirport'] = $val['origin_airport'];
                $infoSearchTicket[$key]['DestinationAirport'] = $val['destination_airport'];
                $infoSearchTicket[$key]['OriginRegionId'] = $val['origin_region'];
                $infoSearchTicket[$key]['OriginRegionName'] = $OriginRegion['name'];
                $infoSearchTicket[$key]['DestinationRegionId'] = $val['destination_region'];
                $infoSearchTicket[$key]['DestinationRegionName'] = $DestinationRegion['name'];
                $infoSearchTicket[$key]['AdtPrice'] = $val[$typePrice];
                $infoSearchTicket[$key]['PriceWithDiscount'] = $OnlinePrice;
                $infoSearchTicket[$key]['Discount'] = $val['comition_ticket'];
                $infoSearchTicket[$key]['Airline'] = $airline['abbreviation'];
                $infoSearchTicket[$key]['FlightType'] = 'charter';
                $infoSearchTicket[$key]['SeatClass'] = 'Y';
                $infoSearchTicket[$key]['Capacity'] = ($capacity > 0) ? $capacity : 0;
                $infoSearchTicket[$key]['CabinType'] = $cabinType;
                $infoSearchTicket[$key]['ChdPrice'] = $val['cost_chd'];
                $infoSearchTicket[$key]['ChdPriceWithDiscount'] = $OnlinePriceChd;
                $infoSearchTicket[$key]['InfPrice'] = $val['cost_inf'];
                $infoSearchTicket[$key]['InfPriceWithDiscount'] = $OnlinePriceInf;
                $infoSearchTicket[$key]['DescriptionTicket'] = $val['description_ticket'];
                $infoSearchTicket[$key]['ServicesTicket'] = $val['services_ticket'];
                $infoSearchTicket[$key]['Special'] = $val['flag_special'];
                $infoSearchTicket[$key]['Image'] = $image;

                if ($val['origin_country'] != '1' || $val['destination_country'] != '1') {
                    $infoSearchTicket[$key]['ZoneFlight'] = 'International';
                } else {
                    $infoSearchTicket[$key]['ZoneFlight'] = 'Local';
                }
            }
        }

        /*  if(isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"],'parvaz.ir') == true ){
              echo $sqlCheck;
              echo json_encode($infoSearchTicket,256);
              die();
          }*/
        return (!empty($infoSearchTicket) ? $infoSearchTicket : '');
    }
    #endregion


    #region [Selected ticket information for passengers]
    public function infoTicket($param = null) {

        $infoTicket = array();

        $infoTicket['flightDirection'] = $flightDirection = $_POST['FlightDirection'];
        $infoTicket['multiWay'] = $multiWay = $_POST['MultiWay'];
        $infoTicket['flight_id'] = $_POST['IdFlight'];
        $infoTicket['flight_id_return'] = $_POST['flight_id_return'];
        $infoTicket['countAdult'] = $_POST['CountAdult'];
        $infoTicket['countChild'] = $_POST['CountChild'];
        $infoTicket['countInfo'] = $_POST['CountInfo'];
        $this->totalQty = $_POST['CountAdult'] + $_POST['CountChild'] + $_POST['CountInfo'];
        $infoTicket['CurrencyCode'] = Session::getCurrency();


        $cost = 'cost_one_way';
        $count_flight = 1;
        if (isset($infoTicket['flight_id_return']) && !empty($infoTicket['flight_id_return'])) {
            $cost = 'cost_two_way';
            $count_flight = 2;
        }


        $functions = Load::controller('reservationPublicFunctions');
        $objResultLocal = Load::controller('resultLocal');

        $checkLogin = Session::IsLogin();
        if ($checkLogin) {
            $counter_type_id = functions::getCounterTypeId(Session::getUserId());
        } else {
            $counter_type_id = '5';
        }

        for ($i = 0; $i < $count_flight; $i++) {

            if ($i == 0) {
                $direction = 'dept';
                $flight_id_search = $infoTicket['flight_id'];
            } else {
                $direction = 'return';
                $flight_id_search = $infoTicket['flight_id_return'];

            }



            $result = $this->getModel('reservationTicketModel')->get(array(
                'type_user', 'date', 'age', 'origin_country', 'destination_country',
                'origin_city', 'destination_city', 'fly_code', 'airline', 'type_of_vehicle'
            ))->where('id', $flight_id_search)->where('is_del', 'no')->find();

            $get_table_name_reservation_fly = $this->getModel('reservationFlyModel')->getTable();
            $get_table_name_reservation_vehicle = $this->getModel('reservationVehicleModel')->getTable();
            $get_table_name_reservation_Ticket = $this->getModel('reservationTicketModel')->getTable();

            $resultCheck[$i] = $this->getModel('reservationTicketModel')
                ->get(array(
                        $get_table_name_reservation_Ticket . '.id', $get_table_name_reservation_Ticket . '.type_user', $get_table_name_reservation_Ticket . '.id_same', $get_table_name_reservation_Ticket . '.date', $get_table_name_reservation_Ticket . '.age', $get_table_name_reservation_Ticket . '.exit_hour', $get_table_name_reservation_Ticket . '.origin_country', $get_table_name_reservation_Ticket . '.destination_country',
                        $get_table_name_reservation_Ticket . '.origin_city', $get_table_name_reservation_Ticket . '.destination_city', $get_table_name_reservation_Ticket . '.origin_region', $get_table_name_reservation_Ticket . '.destination_region', $get_table_name_reservation_fly . '.origin_airport', $get_table_name_reservation_fly . '.destination_airport',
                        $get_table_name_reservation_Ticket . '.fly_tour_capacity', $get_table_name_reservation_Ticket . '.fly_total_capacity', $get_table_name_reservation_Ticket . '.fly_full_capacity',
                        $get_table_name_reservation_Ticket . '.vehicle_grade', $get_table_name_reservation_Ticket . '.maximum_buy', $get_table_name_reservation_Ticket . '.type_of_vehicle',
                        $get_table_name_reservation_Ticket . '.free', $get_table_name_reservation_Ticket . '.cost_two_way', $get_table_name_reservation_Ticket . '.cost_two_way_print', $get_table_name_reservation_Ticket . '.cost_one_way', $get_table_name_reservation_Ticket . '.cost_one_way_print',
                        $get_table_name_reservation_Ticket . '.cost_Ndays', $get_table_name_reservation_Ticket . '.comition_ticket', $get_table_name_reservation_Ticket . '.remaining_capacity',
                        $get_table_name_reservation_fly . '.fly_code', $get_table_name_reservation_fly . '.time', $get_table_name_reservation_fly . '.airline', $get_table_name_reservation_fly . '.vehicle_grade_id',
                        $get_table_name_reservation_vehicle . '.name', $get_table_name_reservation_fly . '.type_of_vehicle_id')
                    , true)
                ->join($get_table_name_reservation_fly, 'id', 'fly_code', 'INNER')
                ->join($get_table_name_reservation_vehicle, 'id', 'type_of_vehicle')
                ->where($get_table_name_reservation_Ticket . '.date', $result['date'])
                ->where($get_table_name_reservation_Ticket . '.origin_city', $result['origin_city'])
                ->where($get_table_name_reservation_Ticket . '.destination_city', $result['destination_city'])
                ->where($get_table_name_reservation_Ticket . '.fly_code', $result['fly_code'])
                ->where($get_table_name_reservation_Ticket . '.airline', $result['airline'])
                ->where($get_table_name_reservation_Ticket . '.type_of_vehicle', $result['type_of_vehicle'])
                ->where($get_table_name_reservation_Ticket . '.type_user', $counter_type_id)
                ->where($get_table_name_reservation_Ticket . '.is_del', 'no')
                ->all();




            if (!empty($resultCheck[$i])) {
                $member_id = Session::getUserId();
                $is_counter = false;
                $member_info = [];
                if ($checkLogin) {

                    $member_info = $this->getController('members')->getMember($member_id);
                    $is_counter = ($member_info['fk_counter_type_id'] >= 1 && $member_info['fk_counter_type_id'] < 5);

                }
                foreach ($resultCheck[$i] as $val) {
                    $count_reserve = $this->getCountBookReservationByAgency($val['id_same']);
                     $capacity = $val['remaining_capacity'];
                    if ($is_counter) {
                        $data_lock_seat = $this->getModel('agencyLockSeatModel')->get()->where('id_same', $val['id_same'])->where('agency_id', $member_info['fk_agency_id'])->find();
                          if (!empty($data_lock_seats)) {

                        $capacity = intval($data_lock_seat['count_agency']) - intval($count_reserve['count_ticket']);

                        $capacity_counters = json_decode($data_lock_seat['counters'], true);

                        if ($capacity > 0 && $capacity_counters) {
                            $used_capacity_user = 0;
                            foreach ($count_reserve['data'] as $item) {
                                if ($item['member_id'] === $member_id) {
                                    $used_capacity_user += 1;
                                }
                            }
                            $capacity = $capacity_counters[$member_id] - $used_capacity_user;
                        }

                        }
                    } else {
                        $data_lock_seats = $this->getModel('agencyLockSeatModel')->get()->where('id_same', $val['id_same'])->all();

                        if (!empty($data_lock_seats)) {
                            $allocated_capacity = 0;
                            foreach ($data_lock_seats as $data_lock_seat) {
                                $allocated_capacity += $data_lock_seat['count_agency'];
                            }
                            $capacity = intval($capacity) - intval($allocated_capacity);
                            if ($capacity > 0) {
                                $used_capacity_user = 0;
                                foreach ($count_reserve['data'] as $item) {
                                    if ($item['agency_id'] == '0') {
                                        $used_capacity_user += 1;
                                    }
                                }
                                $capacity = $capacity - $used_capacity_user;

                            }

                        }
                    }



                     $val['remaining_capacity'] = $capacity;
                    if ($val['remaining_capacity'] > 0) {
                        $this->direction[$direction] = $direction;

                        // discount price
                        if ($checkLogin && $val['comition_ticket'] > 0) {
                            $PriceWithDiscount = $val[$cost] - (($val['comition_ticket'] * $val[$cost]) / 100);
                            $Discount = $val['comition_ticket'];

                        } else {
                            $PriceWithDiscount = 0;
                            $Discount = 0;
                        }

                        $namer_type = (SOFTWARE_LANG != 'fa') ? 'name_en' : 'name' ;
                        if ($val['age'] == 'ADL') {

                            $time = explode(":", $val['time']);
                            $airline = $this->getAirline($val['airline']);
                            $origin_city = $functions->ShowName('reservation_city_tb', $val['origin_city'],$namer_type);
                            $origin_region = $functions->ShowName('reservation_region_tb', $val['origin_region']);
                            $destination_city = $functions->ShowName('reservation_city_tb', $val['destination_city'],$namer_type);
                            $destination_region = $functions->ShowName('reservation_region_tb', $val['destination_region']);
                            $destination_time = $objResultLocal->getTimeArrival($time[0], $time[1], $val['exit_hour']);
                            $DateMiladi = functions::ConvertToMiladi($val['date']);
                            $destination_date = $objResultLocal->Date_arrival_private($time[0], $time[1], $val['exit_hour'], $DateMiladi);
                            $cabinType = $this->getCabinType($val['vehicle_grade_id']);
                            $date = substr($val['date'], 0, 4) . '/' . substr($val['date'], 4, 2) . '/' . substr($val['date'], 6, 2);
                            $infoTransportCompanies = $this->getInfoTransportCompanies($val['airline']);
                            $image = $infoTransportCompanies['pic'];

                            $getTypeVehicle = $this->getTypeVehicleByTicketId($val['id']);
                            if (trim($getTypeVehicle) == 'هواپیما') {
                                $infoTicket[$direction]['Airline'] = $airline['abbreviation'];
                                $infoTicket[$direction]['AirlineName'] = $airline['name_fa'];
                                $infoTicket[$direction]['TypeVehicleFa'] = $objResultLocal->AirPlaneType($val['name']);
                            } else {
                                $infoTicket[$direction]['Airline'] = $airline['abbreviation'];
                                $infoTicket[$direction]['AirlineName'] = $val['name'];
                                $infoTicket[$direction]['TypeVehicleFa'] = $val['name'];
                            }

                            $infoTicket[$direction]['RemainingCapacity'] = $val['remaining_capacity'];
                            $infoTicket[$direction]['OriginCountry'] = $val['origin_country'];
                            $infoTicket[$direction]['DestinationCountry'] = $val['destination_country'];
                            $infoTicket[$direction]['TypeUser'] = $counter_type_id;
                            $infoTicket[$direction]['RemainingCapacity'] = $val['remaining_capacity'];
                            $infoTicket[$direction]['FlightNumber'] = $val['fly_code'];
                            $infoTicket[$direction]['OriginAirport'] = $val['origin_airport'];
                            $infoTicket[$direction]['DestinationAirport'] = $val['destination_airport'];
                            $infoTicket[$direction]['FlightType'] = 'charter';
                            $infoTicket[$direction]['SeatClass'] = 'Y';
                            $infoTicket[$direction]['Capacity'] = $val['remaining_capacity'];
                            $infoTicket[$direction]['CabinType'] = $cabinType;
                            $infoTicket[$direction]['Date'] = $date;
                            $infoTicket[$direction]['OriginCity'] = $origin_city;
                            $infoTicket[$direction]['DestinationCity'] = $destination_city;
                            $infoTicket[$direction]['originRegion'] = $origin_region;
                            $infoTicket[$direction]['DestinationRegion'] = $destination_region;
                            $infoTicket[$direction]['Weight'] = $val['free'];
                            $infoTicket[$direction]['Time'] = $val['time'];
                            $infoTicket[$direction]['Hour'] = $time[0];
                            $infoTicket[$direction]['Minutes'] = $time[1];
                            $infoTicket[$direction]['OriginTime'] = $val['exit_hour'];
                            $infoTicket[$direction]['OriginDate'] = $date;
                            $infoTicket[$direction]['DestinationTime'] = $destination_time;
                            $infoTicket[$direction]['DestinationDate'] = $destination_date;
                            $infoTicket[$direction]['TypeVehicle'] = $val['type_of_vehicle_id'];
                            $infoTicket[$direction]['Image'] = $image;

                            $infoTicket[$direction]['fk_id_ticket_Adt'] = $val['id'];
                            $infoTicket[$direction]['AdtPrice'] = $val[$cost];
                            $infoTicket[$direction]['PriceWithDiscount'] = $PriceWithDiscount;
                            $infoTicket[$direction]['AdtDiscount'] = $Discount;

                            if ($val['origin_country'] != '1' || $val['destination_country'] != '1') {
                                $infoTicket[$direction]['ZoneFlight'] = 'International';
                            } else {
                                $infoTicket[$direction]['ZoneFlight'] = 'Local';
                            }


                        } else if ($val['age'] == 'CHD') {
                            $infoTicket[$direction]['fk_id_ticket_Chd'] = $val['id'];
                            $infoTicket[$direction]['ChdPrice'] = $val[$cost];
                            $infoTicket[$direction]['ChdPriceWithDiscount'] = $PriceWithDiscount;

                        } else if ($val['age'] == 'INF') {
                            $infoTicket[$direction]['fk_id_ticket_Inf'] = $val['id'];
                            $infoTicket[$direction]['InfPrice'] = $val[$cost];
                            $infoTicket[$direction]['InfPriceWithDiscount'] = $PriceWithDiscount;
                        }
                    } else {
                        $this->errorPage = true;
                        $this->errorMessage = functions::Xmlinformation("CapacityServiceIsOverChooseAnotherDate");
                    }


                }
            } else {


                $this->errorPage = true;
                $this->errorMessage = functions::Xmlinformation("ServiceCapacityDefinedYourAccess");
            }

        }

        return $infoTicket;
    }
    #endregion

    #region [infoTicketForPopup]
    public function infoTicketForPopup($Param) {

        ?>
        <div class="pop-up-h site-bg-main-color">
            <span> <?php echo functions::Xmlinformation("TicketDetailsBasedPriceID"); ?>:<?= $Param['CabinType'] ?></span>
        </div>
        <div class="price-Content site-border-main-color">
            <p id="AlertPanelHTC"></p>

            <div class="tblprice">

                <div class="tdpricelabel"><?php echo functions::Xmlinformation("Priceadult"); ?> :</div>
                <div class="tdprice">
                    <?php
                    if ($Param['PriceWithDiscount'] != 0) {
                        ?>
                        <i class="text-decoration-line"><?php echo number_format($Param['AdtPrice']); ?></i>
                        <i class="bg-price-box site-bg-main-color"><?php echo number_format($Param['PriceWithDiscount']); ?></i> <?php echo functions::Xmlinformation("Rial"); ?>
                        <?php
                    } else {
                        ?>
                        <i class="bg-price-box site-bg-main-color"><?php echo number_format($Param['AdtPrice']); ?></i><?php echo functions::Xmlinformation("Rial"); ?><?php
                    }
                    ?>
                </div>

                <div class="tdpricelabel"><?php echo functions::Xmlinformation("Pricechild"); ?> :</div>
                <div class="tdprice">
                    <?php
                    if ($Param['ChdPriceWithDiscount'] != 0) {
                        ?>
                        <i class="text-decoration-line"><?php echo number_format($Param['ChdPrice']); ?></i>
                        <i class="bg-price-box site-bg-main-color"><?php echo number_format($Param['ChdPriceWithDiscount']); ?></i><?php echo functions::Xmlinformation("Rial"); ?>
                        <?php
                    } else {
                        ?>
                        <i class="bg-price-box site-bg-main-color"><?php echo number_format($Param['ChdPrice']); ?></i><?php echo functions::Xmlinformation("Rial"); ?><?php
                    }
                    ?>
                </div>

                <div class="tdpricelabel"><?php echo functions::Xmlinformation("Pricebaby"); ?> :</div>
                <div class="tdprice">
                    <?php
                    if ($Param['InfPriceWithDiscount'] != 0) {
                        ?>
                        <i class="text-decoration-line"><?php echo number_format($Param['InfPrice']); ?></i>
                        <i class="bg-price-box site-bg-main-color"><?php echo number_format($Param['InfPriceWithDiscount']); ?></i><?php echo functions::Xmlinformation("Rial"); ?>
                        <?php
                    } else {
                        ?>
                        <i class="bg-price-box site-bg-main-color"><?php echo number_format($Param['InfPrice']); ?></i><?php echo functions::Xmlinformation("Rial"); ?><?php
                    }
                    ?>
                </div>

            </div>


        </div>
        <div class="cancellationPolicyBox mart15">
            <h4 class="tableOrderHeadTitle site-bg-main-color ">
                <span><?php echo functions::Xmlinformation('DetailMoneyCancel') ?> </span>
            </h4>
            <div class="rp-tableOrder site-border-main-color">
                <table class="cancellationPolicy-table">
                    <thead>
                    <tr class="cancellationPolicy-tableHead">
                        <th class="cancellationPolicy-c1"><?php echo functions::Xmlinformation('Classflight') ?></th>
                        <th class="cancellationPolicy-c2"><?php echo functions::Xmlinformation('Uptodavazdahnoonsedaysbeforeflight') ?></th>
                        <th class="cancellationPolicy-c3"><?php echo functions::Xmlinformation('Uptodavazdanoonyekdaybeforeflight') ?></th>
                        <th class="cancellationPolicy-c4"><?php echo functions::Xmlinformation('Uptosehoursbeforeflight') ?></th>
                        <th class="cancellationPolicy-c5"><?php echo functions::Xmlinformation('Upciminutesbeforeflight') ?></th>
                        <th class="cancellationPolicy-c6"><?php echo functions::Xmlinformation('Fromlastciminuteslater') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="cancellationPolicy-title"
                            colspan="6"><?php echo functions::Xmlinformation('Youreceivehappysendemailsendusemail') ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <?php
    }

    #endregion

    public function ticketReserve() {

        $Model = Load::library('Model');

        $sql = " SELECT fk_id_ticket, SUM(adt_qty) as ADL, SUM(chd_qty) as CHD, SUM(inf_qty) as INF, passenger_age
                  FROM book_local_tb 
                  WHERE factor_number ='{$_POST['FactorNumber']}' AND member_id='{$_POST['IdMember']}'
                  GROUP BY passenger_age ";
        $result = $Model->select($sql);


        $capacity = "";
        foreach ($result as $val) {

            $sqlTicket = "SELECT remaining_capacity, age FROM reservation_ticket_tb WHERE id='{$val['fk_id_ticket']}' ";
            $resultTicket = $Model->load($sqlTicket);
            if ($resultTicket['remaining_capacity'] > 0 && $resultTicket['remaining_capacity'] >= $val[$resultTicket['age']]) {
                $capacity .= 'true|';
            } else {
                $capacity .= 'false|';
            }

        }

        //echo "---->   capacity= ". $capacity;
        //die();
        $expCapacity = explode("|", $capacity);

        if (in_array("false", $expCapacity)) {
            functions::Xmlinformation("NoCapacityBook");
        } else {

            $data['successfull'] = 'prereserve';

            $Condition = "factor_number='{$_POST['FactorNumber']}' ";
            $Model->setTable("book_local_tb");
            $res1 = $Model->update($data, $Condition);

            Load::autoload('ModelBase');
            $ModelBase = new ModelBase();
            $ModelBase->setTable("report_tb");
            $res2 = $ModelBase->update($data, $Condition);

            if ($res1 && $res2) {
                echo "SuccessBookTicket";
            } else {
                echo functions::Xmlinformation('ErrorUnknownBuyHotel');
            }


        }


    }

    public function getTicketDataNew($factor_number) {
        $Model = Load::library('Model');

        $sql = "SELECT * FROM book_local_tb  WHERE  factor_number='{$factor_number}' AND successfull='book' ";
        $result = $Model->select($sql);

        $this->factorNumberPrint = $result[0]['factor_number'];
        return $result;
    }

    public function set_date_reserve($date) {
        $date_orginal_exploded = explode(' ', $date);
        $date_miladi_exp = explode('-', $date_orginal_exploded[0]);
        return dateTimeSetting::gregorian_to_jalali($date_miladi_exp[0], $date_miladi_exp[1], $date_miladi_exp[2], '/');
    }

    public function createFactorNumber() {
        $factor_number = substr(time(), 0, 5) . mt_rand(000, 999) . substr(time(), 5, 10);
        return $factor_number;
    }

    public function createRequestNumber() {
        $factor_number = 'RESERVATION' . substr(time(), 0, 2) . mt_rand(000, 999) . substr(time(), 5, 10);
        return $factor_number;
    }


    public function getInfoTicketReservation($requestNumber) {
        if (TYPE_ADMIN == '1') {

            Load::autoload('ModelBase');
            $ModelBase = new ModelBase();
            $sql = " SELECT *
                 FROM report_tb
                 WHERE request_number='{$requestNumber}'
                 ORDER BY passenger_age";
            $Book = $ModelBase->select($sql);

        } else {

            Load::autoload('Model');
            $Model = new Model();
            $sql = " SELECT *
                 FROM book_local_tb 
                 WHERE request_number='{$requestNumber}'
                 ORDER BY passenger_age";
            $Book = $Model->select($sql);

        }

        $totalPrice = 0;
        $totalPriceWithoutDiscount = 0;
        foreach ($Book as $val) {
            $namePrice = strtolower($val['passenger_age']) . '_price';
            $nameDiscountPrice = 'discount_' . strtolower($val['passenger_age']) . '_price';
            $totalPriceWithoutDiscount += $val[$namePrice];
            $totalPrice += $val[$nameDiscountPrice];
        }

        if ($Book[0]['percent_discount'] > 0) {
            $result['totalPriceWithoutDiscount'] = $totalPriceWithoutDiscount;
            $result['totalPrice'] = $totalPrice;
        } else {
            $result['totalPriceWithoutDiscount'] = 0;
            $result['totalPrice'] = $totalPriceWithoutDiscount;
        }

        $result['infoTicket'] = $Book;

        return $result;
    }


    public function getCountBookReservationByAgency($id_same) {

        $reservation_table_name = $this->getModel('reservationTicketModel')->getTable();
        $book_local_table_name = $this->getModel('bookLocalModel')->getTable();

        $result = $this->getModel('reservationTicketModel')->get([$book_local_table_name . '.*'], true)
            ->join($book_local_table_name, 'fk_id_ticket', 'id', 'INNER')
            ->where($reservation_table_name . '.id_same', $id_same)
            ->where($book_local_table_name . '.successfull', 'book')
            ->all();
        $result['data'] = $result;
        $result['count_ticket'] = count($result);

        return $result;

    }


}


?>
