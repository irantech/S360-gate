<?php

class resultLocal extends apiLocal
{
#region variables that recive for search
    public $adult;     // Number of adult
    public $child;    // Number of child
    public $infant;    // Number of infant
    public $classf;    // Tyop of class(Economy or Business)
    public $origin;    // Deparchure city
    public $destination;  // Destination city
    public $dept_date;   // Deparchure date
    public $return_date;   // Return date
    public $activeAirlines = array();
#endregion

#region variables Search results
    public $tickets = array(); // Search Results -> tickets
    public $flightCount = "";  // The number of results
    public $originCityFa = "";  // Deparchure city
    public $originCityEn = "";  // Deparchure city
    public $destinationCityFa = ""; // Destination city
    public $destinationCityEn = ""; // Destination city
    public $responsetime = ""; // Time request for search
    public $date = "";   // Date request for search
    public $classPersian = ""; //value of $class for show
    public $classFull = "";  //full class name
    public $maxPrice = "";  //The most expensive ticket prices
    public $minPrice = "";  //The cheapest ticket prices
    public $maxPriceReturn = "";  //The most expensive ticket prices
    public $minPriceReturn = "";  //The cheapest ticket prices
    public $flightRules = array(); // search result -> rules
    public $dep_airport = '';
    public $dep_airport_arival = '';
    public $adult_qty = "";
    public $child_qty = "";
    public $infant_qty = "";
    public $dep_city = "";
    public $arival_city = "";
    public $date_now = "";
    public $day = "";
    public $airplane_name = "";
    public $countTicket = "";
    public $countTicketReturn = "";
    public $TicketWarranty = "";
    public $countTicketPrivate = "";
    public $USER_ID_API = "";
    public $USER_NAME_API = "";
    public $DateJalaliRequest = "";
    public $DateJalaliRequestReturn = "";
    public $ToDay = "";
    public $DayOfWeek = "";
    public $ToDaySearch = "";
    public $PminPrice = "";
    public $PmaxPrice = "";
    public $MultiWay = 'OneWay';
    public $ticketsClose;
#endregion

#region __construct

    public function __construct()
    {
        $parent = new apiLocal();
        $this->USER_ID_API = $parent->ApiId;
        $this->USER_NAME_API = $parent->userPishro;

        ($this->classf == 'C') ? ($this->classPersian = functions::Xmlinformation("BusinessType")) : ($this->classPersian = functions::Xmlinformation("EconomicsType"));
        ($this->classf == 'C') ? ($this->classFull = "Business") : ($this->classFull = "Economy");

        $this->ToDay = dateTimeSetting::jdate(" j F Y", time());
        $this->DayOfWeek = dateTimeSetting::jdate("l", time());
        $this->ToDaySearch = dateTimeSetting::jdate("Y-m-d", time(), '', '', 'en');
    }
#endregion

#region FlightOfTwoWeek

    public static function FlightOfTwoWeek($param)
    {
        $Arrname = functions::NameCityDep();
        ?>

        <h4><span class="txtCenter"><?php echo $Arrname[$param['code']]; ?>
                <?php echo functions::Xmlinformation('On') . ' ' . $Arrname[$param['arrivalCode']]; ?></span>
        </h4>


        <?php
        $startDate = (isset($param['startDate']) && !empty($param['startDate']) ? $param['startDate'] : dateTimeSetting::jdate("Y-m-d", time(), "", "", "en"));
        $dateNow = $startDate;
        $ex = explode('-', $startDate);
        $MkTimeJdate = dateTimeSetting::jmktime('0', '0', '0', $ex[1], $ex[2], $ex[0]);
        $dateEnd = dateTimeSetting::jdate("Y-m-d", $MkTimeJdate + (12 * 24 * 60 * 60), "", "", "en");

        $ResultApi = functions::MinimumPriceInDate($param['code'], $param['arrivalCode'], $dateNow, $dateEnd);

        $ResultApiNew = array();

        foreach ($ResultApi['CalendarRoute'] as $Api) :

            $keyDate = str_replace('/', '-', $Api['PersianDepartureDate']);
            $ResultApiNew[$keyDate] = $Api;

        endforeach;


        $i = 1;
        while ($dateNow < $dateEnd) {
            $ex = explode('-', $dateNow);
            $ex[2] = ($ex[2] > 9) ? $ex[2] : str_replace('0', '', $ex[2]);
            $ex[1] = str_replace('0', '', $ex[1]);

            $dateNow = $ex[0] . '-' . $ex[1] . '-' . $ex[2];

            if (!empty($ResultApiNew[$dateNow])):
                echo '<div class="arzan-flight-item">
                    <a href="http://' . str_replace('www.', '', $_SERVER["HTTP_HOST"]) . '/gds/local/1/' . $param['code'] . '-' . $param['arrivalCode'] . '/' . str_replace('/', '-', $ResultApiNew[$dateNow]['PersianDepartureDate']) . '/Y/1-0-0">
                        <span class="img-rounded main-flight-date">' . $ResultApiNew[$dateNow]['PersianDepartureDate'] . '
                            <span class="main-flight-price ">
                                <i class="text-left font14"> ' . functions::Xmlinformation("From") . ' ' . number_format($ResultApiNew[$dateNow]['MinPrice'] * 10) . '</i>
                                 &nbsp;&nbsp;' . functions::Xmlinformation("Rial") . '
                            </span>
                        </span>
                    </a>
                </div>';
            else:
                echo '<div class="arzan-flight-item">
                    <a href="#" onclick="return false;">
                        <span class="img-rounded main-flight-date">' . $dateNow . '
                            <span class="main-flight-price ">
                            <i class="fa fa-ban" style="font-size: 16px ; color: #FF0000"></i>
                            </span>
                        </span>
                    </a>
                </div>';

            endif;

            $dateNow = dateTimeSetting::jdate("Y-m-d", $MkTimeJdate + ($i++ * 24 * 60 * 60), "", "", "en");
        }


        //Previous 12 Days Button
        $dateStartPrev = dateTimeSetting::jdate("Y-m-d", $MkTimeJdate + (-12 * 24 * 60 * 60), "", "", "en");
        $dateEndPrev = dateTimeSetting::jdate("Y-m-d", $MkTimeJdate + (-2 * 24 * 60 * 60), "", "", "en");
        $ResultApiPrev = functions::MinimumPriceInDate($param['code'], $param['arrivalCode'], $dateStartPrev, $dateEndPrev);

        if (!isset($ResultApiPrev['message'])) {
            ?>
            <span class="flight-Day-Prev" id="flight_Day_Prev"><a
                    onclick="showModal('<?php echo $param['code'] ?>', '<?php echo $param['arrivalCode'] ?>', '<?php echo $dateStartPrev ?>');"><i
                        class="fa fa-angle-double-right"
                        style="margin: 0px 5px"></i>'.<?php echo functions::Xmlinformation("twelvedaysago") ?>
                    .'</a></span>

            <?php
        }

        //Next 12 Days Button
        $dateEndNext = dateTimeSetting::jdate("Y-m-d", $MkTimeJdate + (12 * 24 * 60 * 60), "", "", "en");


        $ResultApiNext = functions::MinimumPriceInDate($param['code'], $param['arrivalCode'], $dateNow, $dateEndNext);

        if (!isset($ResultApiNext['message'])) {
            ?>
            <span class="flight-Day-Next" id="flight_Day_Next"><a
                    onclick="showModal('<?php echo $param['code'] ?>', '<?php echo $param['arrivalCode'] ?>', '<?php echo $dateNow ?>');">'.<?php echo functions::Xmlinformation("twelvedayslater") ?>
                    .'<i
                        class="fa fa-angle-double-left" style="margin: 0px 5px"></i></a></span>

            <?php
        }
    }
#endregion

#region getTicketList

    public function getTicketList($param)
    {
        error_log('first  getTicketInternal  : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');
        $DateCheckExplode = explode('-', $param['dept_date']);
        if ($DateCheckExplode[0] > 1450) {
            $param['dept_date_convert'] = dateTimeSetting::gregorian_to_jalali($DateCheckExplode[0], $DateCheckExplode['1'], $DateCheckExplode['2'], '-');
            if ($param['return_date_convert'] != '') {
                $DateReturnExplode = explode('-', $param['return_date']);
                $param['return_date_convert'] = dateTimeSetting::gregorian_to_jalali($DateReturnExplode[0], $DateReturnExplode['1'], $DateReturnExplode['2'], '-');
            }
        } else {
            $param['dept_date_convert'] = $param['dept_date'];
            $param['return_date_convert'] = $param['return_date'];
        }

        parent::__construct();

        //departure flights
        $tickets_output['dept'] = parent::getTicket($param['adult'], $param['child'], $param['infant'], $param['classf'], $param['origin'], $param['destination'], $param['dept_date_convert'], $param['foreign'], '', '', '');
        error_log('next go to apiLocal of  getTicketInternal  : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');
        //sort
        $sort = array();
        if (empty($tickets_output['dept'])) {
            $tickets_output['dept'] = array();
        }


        //return flights in twoway
        if ($param['return_date'] != '' && !empty($tickets_output['dept'])) {
            $this->MultiWay = 'TwoWay';
            $tickets_output['return'] = parent::getTicket($param['adult'], $param['child'], $param['infant'], $param['classf'], $param['destination'], $param['origin'], $param['return_date_convert'], $param['foreign'], '', '', '');

            //در صورتیکه جستجو دوطرفه بود و پرواز برگشت نداشت، پروازهای رفت هم خالی میکنیم تا نمایش ندهد
            if (empty($tickets_output['return'])) {
                $tickets_output['dept'] = array();
            }

            //sort
            $sort = array();
            if (empty($tickets_output['return'])) {
                $tickets_output['return'] = array();
            }
            foreach ($tickets_output['return'] as $k => $ticket) {

                $sort['FlightNo'][$k] = $ticket['OutputRoutes'][0]['FlightNo'];
                $sort['Airline'][$k] = $ticket['OutputRoutes'][0]['Airline']['Code'];
                $sort['FlightType'][$k] = $ticket['FlightType'];
                $sort['SeatClass'][$k] = $ticket['SeatClass'];
                $sort['DepartureTime'][$k] = $ticket['OutputRoutes'][0]['DepartureTime'];
                $sort['AdtPrice'][$k] = $ticket['AdtPrice'];
            }

            if (!empty($sort)) {
                array_multisort($sort['FlightNo'], SORT_ASC, $sort['Airline'], SORT_ASC, $sort['DepartureTime'], SORT_DESC, $sort['FlightType'], SORT_ASC, $sort['AdtPrice'], SORT_ASC, $tickets_output['return']);
            }
        }
        //origin & destination name
        $oringinCity = $this->NameCity($param['origin'],$param['lang']);
        $destinationCity= $this->NameCity($param['destination'],$param['lang']);

        $LongTime = $this->LongTimeFlightHours($param['origin'], $param['destination'], 'Yes');


        foreach ($tickets_output as $direction => $newarray) {
            error_log('next go to DataAjaxSearch  : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search_foreach.txt');
            $i = 0;
            $count = count($newarray);
            for ($key = 0; $key < $count; $key++) {
                if ($newarray[$key]['Capacity'] > 0) {
                    $this->tickets[$direction][$i]['FlightNo'] = $newarray[$key]['OutputRoutes'][0]['FlightNo'];
                    $this->tickets[$direction][$i]['Airline'] = $newarray[$key]['OutputRoutes'][0]['Airline']['Code'];
                    $this->tickets[$direction][$i]['DepartureDate'] = $newarray[$key]['OutputRoutes'][0]['DepartureDate'];
                    if (isset($newarray[$key]['SourceId']) && !empty($newarray[$key]['SourceId'])) {

                        $this->tickets[$direction][$i]['SourceId'] = $newarray[$key]['SourceId'];
                    }

                    $dateArrival = explode('T', $newarray[$key]['OutputRoutes'][0]['DepartureDate']);
                    $this->tickets[$direction][$i]['ArrivalDate'] = functions::Date_arrival($param['origin'], $param['destination'], $newarray[$key]['OutputRoutes'][0]['DepartureTime'], $dateArrival[0]);

                    $miladidate = explode('-', $dateArrival[0]);
                    $datePersian = dateTimeSetting::gregorian_to_jalali($miladidate[0], $miladidate[1], $miladidate[2], '/');

                    $this->tickets[$direction][$i]['DepartureParentRegionName'] = $newarray[$key]['OutputRoutes'][0]['Departure']['ParentRegionName'];
                    $this->tickets[$direction][$i]['DepartureCode'] = $newarray[$key]['OutputRoutes'][0]['Departure']['Code'];
                    $this->tickets[$direction][$i]['DepartureCity'] = ($direction == 'dept' ? $oringinCity : $destinationCity);
                    $this->tickets[$direction][$i]['ArrivalParentRegionName'] = $newarray[$key]['OutputRoutes'][0]['Arrival']['ParentRegionName'];
                    $this->tickets[$direction][$i]['ArrivalCode'] = $newarray[$key]['OutputRoutes'][0]['Arrival']['Code'];
                    $this->tickets[$direction][$i]['ArrivalCity'] = ($direction == 'dept' ? $destinationCity : $oringinCity);
                    $this->tickets[$direction][$i]['Aircraft'] = $newarray[$key]['OutputRoutes'][0]['Aircraft']['Manufacturer'];
                    $this->tickets[$direction][$i]['FlightType'] = (strtolower($newarray[$key]['FlightType']) == 'system') ? '<lable class="iranB " >' . functions::Xmlinformation("SystemType") . '</lable>' : functions::Xmlinformation("CharterType");
                    $this->tickets[$direction][$i]['FlightType_li'] = (strtolower($newarray[$key]['FlightType']) == 'system') ? 'system' : 'charter';
                    $this->tickets[$direction][$i]['PersianDepartureDate'] = $datePersian;
                    $this->tickets[$direction][$i]['DepartureTime'] = $newarray[$key]['OutputRoutes'][0]['DepartureTime'];
                    $this->tickets[$direction][$i]['SeatClass'] = (($newarray[$key]['SeatClass'] == 'C' || $newarray[$key]['SeatClass'] == 'B') ? functions::Xmlinformation("BusinessType") : functions::Xmlinformation("EconomicsType"));
                    $this->tickets[$direction][$i]['SeatClassEn'] = (($newarray[$key]['SeatClass'] == 'C' || $newarray[$key]['SeatClass'] == 'B') ? 'business' : 'economy');
                    $this->tickets[$direction][$i]['CabinType'] = $newarray[$key]['OutputRoutes'][0]['CabinType'];
                    $this->tickets[$direction][$i]['AdtPrice'] = $newarray[$key]['AdtPrice'];
                    $this->tickets[$direction][$i]['ChdPrice'] = $newarray[$key]['ChdPrice'];
                    $this->tickets[$direction][$i]['InfPrice'] = $newarray[$key]['InfPrice'];
                    $this->tickets[$direction][$i]['BasPriceOriginAdt'] = $newarray[$key]['BasPriceOriginAdt'];
                    $this->tickets[$direction][$i]['TaxPriceOriginAdt'] = $newarray[$key]['TaxPriceOriginAdt'];
                    $this->tickets[$direction][$i]['CommissionPriceAdt'] = $newarray[$key]['CommissionPriceAdt'];
                    $this->tickets[$direction][$i]['Capacity'] = $newarray[$key]['Capacity'];
                    $this->tickets[$direction][$i]['Supplier'] = $newarray[$key]['Supplier']['Name'];
                    $this->tickets[$direction][$i]['UserId'] = !empty($newarray[$key]['UserId']) ? $newarray[$key]['UserId'] : '';
                    $this->tickets[$direction][$i]['UserName'] = !empty($newarray[$key]['UserName']) ? $newarray[$key]['UserName'] : '';
                    $this->tickets[$direction][$i]['SourceId'] = !empty($newarray[$key]['SourceId']) ? $newarray[$key]['SourceId'] : '';
                    $this->tickets[$direction][$i]['SourceName'] = !empty($newarray[$key]['SourceName']) ? $newarray[$key]['SourceName'] : '';
                    $this->tickets[$direction][$i]['UniqueCode'] = $newarray[$key]['UniqueCode'];
                    $this->tickets[$direction][$i]['IsInternal'] = $newarray[$key]['IsInternal'];
                    $this->tickets[$direction][$i]['Reservable'] = $newarray[$key]['Reservable'];
                    $this->tickets[$direction][$i]['FlightID'] = $newarray[$key]['FlightID'];
                    $this->tickets[$direction][$i]['ReturnFlightID'] = $newarray[$key]['ReturnFlightID'];
                    $this->tickets[$direction][$i]['LongTime'] = $LongTime;
                } else {
                    $this->ticketsClose[$direction][$i]['FlightNo'] = $newarray[$key]['OutputRoutes'][0]['FlightNo'];
                    $this->ticketsClose[$direction][$i]['Airline'] = $newarray[$key]['OutputRoutes'][0]['Airline']['Code'];
                    $this->ticketsClose[$direction][$i]['DepartureDate'] = $newarray[$key]['OutputRoutes'][0]['DepartureDate'];
                    if (isset($newarray[$key]['SourceId']) && !empty($newarray[$key]['SourceId'])) {

                        $this->ticketsClose[$direction][$i]['SourceId'] = $newarray[$key]['SourceId'];
                    }

                    $dateArrival = explode('T', $newarray[$key]['OutputRoutes'][0]['DepartureDate']);
                    $this->ticketsClose[$direction][$i]['ArrivalDate'] = functions::Date_arrival($param['origin'], $param['destination'], $newarray[$key]['OutputRoutes'][0]['DepartureTime'], $dateArrival[0]);

                    $miladidate = explode('-', $dateArrival[0]);
                    $datePersian = dateTimeSetting::gregorian_to_jalali($miladidate[0], $miladidate[1], $miladidate[2], '/');

                    $this->ticketsClose[$direction][$i]['DepartureParentRegionName'] = $newarray[$key]['OutputRoutes'][0]['Departure']['ParentRegionName'];
                    $this->ticketsClose[$direction][$i]['DepartureCode'] = $newarray[$key]['OutputRoutes'][0]['Departure']['Code'];
                    $this->ticketsClose[$direction][$i]['DepartureCity'] = ($direction == 'dept' ? $oringinCity : $destinationCity);
                    $this->ticketsClose[$direction][$i]['ArrivalParentRegionName'] = $newarray[$key]['OutputRoutes'][0]['Arrival']['ParentRegionName'];
                    $this->ticketsClose[$direction][$i]['ArrivalCode'] = $newarray[$key]['OutputRoutes'][0]['Arrival']['Code'];
                    $this->ticketsClose[$direction][$i]['ArrivalCity'] = ($direction == 'dept' ? $destinationCity : $oringinCity);
                    $this->ticketsClose[$direction][$i]['Aircraft'] = $newarray[$key]['OutputRoutes'][0]['Aircraft']['Manufacturer'];
                    $this->ticketsClose[$direction][$i]['FlightType'] = (strtolower($newarray[$key]['FlightType']) == 'system') ? '<lable class="iranB site-main-text-color" >' . functions::Xmlinformation("SystemType") . '</lable>' : '';
                    $this->ticketsClose[$direction][$i]['FlightType_li'] = (strtolower($newarray[$key]['FlightType']) == 'system') ? 'system' : 'charter';
                    $this->ticketsClose[$direction][$i]['PersianDepartureDate'] = $datePersian;
                    $this->ticketsClose[$direction][$i]['DepartureTime'] = $newarray[$key]['OutputRoutes'][0]['DepartureTime'];
                    $this->ticketsClose[$direction][$i]['SeatClass'] = (($newarray[$key]['SeatClass'] == 'C' || $newarray[$key]['SeatClass'] == 'B') ? functions::Xmlinformation("BusinessType") : functions::Xmlinformation("EconomicsType"));
                    $this->ticketsClose[$direction][$i]['SeatClassEn'] = (($newarray[$key]['SeatClass'] == 'C' || $newarray[$key]['SeatClass'] == 'B') ? 'business' : 'economy');
                    $this->ticketsClose[$direction][$i]['CabinType'] = $newarray[$key]['OutputRoutes'][0]['CabinType'];
                    $this->ticketsClose[$direction][$i]['AdtPrice'] = $newarray[$key]['AdtPrice'];;
                    $this->ticketsClose[$direction][$i]['ChdPrice'] = $newarray[$key]['ChdPrice'];
                    $this->ticketsClose[$direction][$i]['InfPrice'] = $newarray[$key]['InfPrice'];
                    $this->ticketsClose[$direction][$i]['BasPriceOriginAdt'] = $newarray[$key]['BasPriceOriginAdt'];
                    $this->ticketsClose[$direction][$i]['TaxPriceOriginAdt'] = $newarray[$key]['TaxPriceOriginAdt'];
                    $this->ticketsClose[$direction][$i]['CommissionPriceAdt'] = $newarray[$key]['CommissionPriceAdt'];
                    $this->ticketsClose[$direction][$i]['Capacity'] = $newarray[$key]['Capacity'];
                    $this->ticketsClose[$direction][$i]['Supplier'] = $newarray[$key]['Supplier']['Name'];
                    $this->ticketsClose[$direction][$i]['UserId'] = !empty($newarray[$key]['UserId']) ? $newarray[$key]['UserId'] : '';
                    $this->ticketsClose[$direction][$i]['UserName'] = !empty($newarray[$key]['UserName']) ? $newarray[$key]['UserName'] : '';
                    $this->ticketsClose[$direction][$i]['SourceId'] = !empty($newarray[$key]['SourceId']) ? $newarray[$key]['SourceId'] : '';
                    $this->ticketsClose[$direction][$i]['SourceName'] = !empty($newarray[$key]['SourceName']) ? $newarray[$key]['SourceName'] : '';
                    $this->ticketsClose[$direction][$i]['UniqueCode'] = $newarray[$key]['UniqueCode'];
                    $this->ticketsClose[$direction][$i]['IsInternal'] = $newarray[$key]['IsInternal'];
                    $this->ticketsClose[$direction][$i]['Reservable'] = $newarray[$key]['Reservable'];
                    $this->ticketsClose[$direction][$i]['FlightID'] = $newarray[$key]['FlightID'];
                    $this->ticketsClose[$direction][$i]['ReturnFlightID'] = $newarray[$key]['ReturnFlightID'];
                    $this->ticketsClose[$direction][$i]['LongTime'] = $LongTime;
                }
                $i++;
                error_log('next go to DataAjaxSearch  : ' . date('Y/m/d H:i:s') . '<hr/>' . " \n", 3, LOGS_DIR . 'log_Request_send_search_foreach.txt');
            }
        }


        foreach ($this->tickets as $direction => $every_turn) {

            $this->tickets[$direction] = $this->deleteInactiveAirline($every_turn, 'isInternal');
            foreach ($this->tickets[$direction] as $k => $Ticket) {

                if (!(in_array($Ticket['Airline'], $this->activeAirlines))) {
                    array_push($this->activeAirlines, $Ticket['Airline']);
                }
                $price[$direction][] = $Ticket['AdtPrice'];
            }

            if ($direction == 'dept') {
                $this->countTicket = count($this->tickets[$direction]);
                $this->minPrice = !empty($price[$direction]) ? min($price[$direction]) : '0';
                $this->maxPrice = !empty($price[$direction]) ? max($price[$direction]) : '0';
            } else {
                $this->countTicketReturn = count($this->tickets[$direction]);
                $this->minPriceReturn = !empty($price[$direction]) ? min($price[$direction]) : '0';
                $this->maxPriceReturn = !empty($price[$direction]) ? max($price[$direction]) : '0';
            }
        }

//        echo Load::plog($this->tickets);
        $this->adult_qty = $param['adult'];
        $this->child_qty = $param['child'];
        $this->infant_qty = $param['infant'];

        $ClientAuth = new clientAuth();
        $ClientAuthAccess = $ClientAuth->ticketReservationFlightAuth();
        if ($ClientAuthAccess['Service'] == 'TicketFlightReserveLocal' && $ClientAuthAccess['SourceName'] == 'reservation') {
            $reservationTicket = $this->getTicketPrivate($param['adult'], $param['child'], $param['infant'], $param['dept_date'], $param['origin'], $param['destination'], $param['return_date'], $this->MultiWay);

        } else {
            $reservationTicket = $this->getTicketPrivateOld($param['adult'], $param['child'], $param['infant'], $param['dept_date'], $param['origin'], $param['destination']);

        }

        error_log('next go to DataAjaxSearch  : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');
        $FlightInternal = Load::controller('flightInternal');
        $TicketResult = $FlightInternal->DataAjaxSearch($param['origin'], $param['destination'], $param['dept_date'], $param['return_date'], $param['adult'], $param['child'], $param['infant'], $this->activeAirlines, $this->tickets, $reservationTicket, $this->maxPrice, $this->minPrice, $this->ticketsClose, $this->MultiWay, $param['lang'], $param['searchFlightNumber']);
        error_log('next recive data of DataAjaxSearch  : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');

        return $TicketResult;

    }
#endregion
    #region NameCity

    public function NameCity($param,$lang=null)
    {

        $select_airport = new ModelBase();

        $sql = " SELECT DISTINCT  Departure_City,Departure_CityEn FROM flight_route_tb WHERE Departure_Code='{$param}'  ";

        $arrival_city = $select_airport->load($sql);


        return ($lang == 'en') ? $arrival_city['Departure_CityEn'] : $arrival_city['Departure_City'];
    }

#endregion

    #region LongTimeFlightHours

    public function LongTimeFlightHours($param1, $param2, $param3 = null)
    {
        $flight_route = new ModelBase();

        $sql = " SELECT   TimeLongFlight  FROM flight_route_tb  WHERE Departure_Code='{$param1}' AND Arrival_Code='{$param2}'  ";

        $flight_route = $flight_route->load($sql);

        if (!empty($flight_route['TimeLongFlight'])) {
            $explode_date = explode(':', $flight_route['TimeLongFlight']);

            $jmktime = dateTimeSetting::jmktime($explode_date[0], $explode_date[1], $explode_date[2]);

            $hour_long = dateTimeSetting::jdate("H", $jmktime);

            return !empty($param3) ? $flight_route['TimeLongFlight'] : $hour_long;
        } else {
            return functions::Xmlinformation("Unknow");
        }
    }
    #endregion

    #region deleteInactiveAirline

    public function deleteInactiveAirline($flights, $type,$data_extra ,$typeRoutForeign=null)
    {

        /** @var airline $airline */
        $airline = Load::controller('airline');
        $arrReturn = array();
        $array_public_flights = array();
        $array_private_flights = array();
        $array_total = array();

        if ($type == 'isInternal') {
            $airline_config_list = $data_extra['list_config_airline'];

            $data_check_limit['origin'] = isset($flights[0]['DepartureCode']) ? $flights[0]['DepartureCode'] : $flights[0]['departure_code']   ;
            $data_check_limit['destination'] = isset($flights[0]['ArrivalCode']) ? $flights[0]['ArrivalCode'] :$flights[0]['arrival_code'] ;
            //این فانکشن برای جلوگیری از نمایش پرواز هایی است که بالاتر از نرخ مصوب هستند
            // این بخش که مربوط به عدم نمایش پرواز های بالاتر از نرخ مصوب بود ، کامنت شد چون دیگر یک همچین چیزی وجود ندارد ، اگر مجددا تصمیم بر برگرداندن این ویژگی شد میبایست خط پایین از کامنتی در آید و همچنین متغییر $check_price_limit همیشه true ندهید و شرط هایی که به صورت کامنت شده قبلا بود در آن برگردانده شود
//            $price_check = $this->getController('checkLimitPrice')->getChecKLimits($data_check_limit);

            foreach ($flights as $rec) {
                $flight_type = isset($rec['FlightType_li']) ? $rec['FlightType_li'] : $rec['flight_type_li'];

                $price_check_each_flight = isset($rec['price'])? $rec['price']['adult']['price'] : $rec['AdtPrice'] ;
                // در صورتی که لاگین باشد و کانتر باشد یاااا جدول چک لیمیت قیمت خالی باشد یااااا پرواز سیستمی باشد یااااا قیمت پرواز از قیمت لیمیت کمتر باشد یاااااا قیمت پرواز صفر باشد(تکمیل ظرفیت باشد) یااااااا بر اساس خواسته مدیریت یا پشتیبانی استثنا شده باشد،اجازه نمایش دارد
                $check_price_limit = true
// (
//                    (Session::IsLogin() && Session::getCounterTypeId() !='5')
//                    || empty($price_check)
//                    || (!$price_check)
//                    || ($flight_type == 'system')
//                    || ((intval($price_check['price']) >= intval($price_check_each_flight)) && ((Session::IsLogin() && Session::getCounterTypeId() =='5') || !Session::IsLogin()))
//                    || $price_check_each_flight==0
//                    ||(in_array(CLIENT_ID,functions::expectCheckLimitPrice())))
 ;



                if($check_price_limit)
                {

                    $airline_iata = isset($rec['Airline']) ? $rec['Airline'] : $rec['airline'];

                    $source_id_flight= isset($rec['SourceId']) ? $rec['SourceId'] : $rec['source_id'];

                    $data_check_status_airline = array(
                        'selected_config'=>$data_extra['list_config_airline'][$flight_type][$airline_iata],
                        'source_id'=> $source_id_flight
                    );

                    $statusConfigAirline = $this->getController('configFlight')->checkStatusConfigAirline($data_check_status_airline);

                    if ($airline->checkTypeAirline($flight_type, $airline_iata)){

                      //  در صورتی که ایرلاین اشتراکی باشد و مروبط به سرور 5(پیشرو)  ویا سرور 14 (پرتو) و sourceId پرواز با یکی از sourceId های چدول کانفیگ پرواز که اشتراکی هستند برابر باشد در غیر این صورت اختصاصی هستند

                       // در تاریخ 24 دی 1404 کامنت شد

//                        if($statusConfigAirline=='public'){

                            if(($source_id_flight !='1' || $source_id_flight!='14')
                                && ($source_id_flight == $airline_config_list[$flight_type][$airline_iata]['sourceId']
                                    ||  $source_id_flight == $airline_config_list[$flight_type][$airline_iata]['sourceReplaceId']))
                            {
                                $array_public_flights[] = $rec;
                                $array_total[] = $rec ;
                            }
//                        }
//                        elseif($statusConfigAirline=='private'){
//
//                            $array_private_flights[] = $rec;
//                            $array_total[] = $rec;
//                        }
                    }


                }


                }

            
            /*if(!empty($array_public_flights) && !empty($array_private_flights)){
              if(!empty($typeRoutForeign) && $typeRoutForeign=='new')
               {
                   $resultsTotalCharter724 = $this->array_filter_by_value($flights, 'source_id', '8');
                   $resultsSource1 = $this->array_filter_by_value($flights, 'source_id', '1');
                   $resultsSystemReplacedSource11 = $this->array_filter_by_value($flights, 'source_id', '11');


                   foreach ($resultsSource1 as $item) {
                       $exist[] = $item['airline'];
                   }
                   foreach ($resultsSystemReplacedSource11 as $source11) {
                       $SystemPublicExist[] = $source11['airline'];
                       $SystemPublicExistFlightNumber[] = $source11['flight_number'];
                   }
                   foreach ($resultsTotalCharter724 as $Source7) {
                       $Source7Exist[] = $Source7['airline'];
                       $Source7FlightNumber[] = $Source7['flight_number'];
                   }
               }else{
                   $resultsTotalCharter724 = $this->array_filter_by_value($flights, 'SourceId', '8');
                   $resultsSource1 = $this->array_filter_by_value($flights, 'SourceId', '1');
                   $resultsSystemReplacedSource11 = $this->array_filter_by_value($flights, 'SourceId', '11');

                   foreach ($resultsSource1 as $item) {
                       $exist[] = $item['Airline'];
                   }
                   foreach ($resultsSystemReplacedSource11 as $source11) {
                       $SystemPublicExist[] = $source11['Airline'];
                       $SystemPublicExistFlightNumber[] = $source11['FlightNo'];
                   }
                   foreach ($resultsTotalCharter724 as $Source7) {
                       $Source7Exist[] = $Source7['Airline'];
                       $Source7FlightNumber[] = $Source7['FlightNo'];
                   }
               }

               foreach ($flights as  $flight){
                   $flight_type = isset($flight['FlightType_li']) ? $flight['FlightType_li'] : $flight['flight_type_li'];
                   $airline_iata= isset($flight['Airline']) ? $flight['Airline'] : $flight['airline'];
                   $source_id_flight= isset($flight['SourceId']) ? $flight['SourceId'] : $flight['source_id'];
                   $departure_time_flight= isset($flight['FlightNo']) ? $flight['FlightNo'] : $flight['flight_number'];
                   $flight_number_flight= isset($flight['DepartureTime']) ? $flight['DepartureTime'] : $flight['departure_time'];
                   $departure_date_flight= isset($flight['DepartureDate']) ? $flight['DepartureDate'] : $flight['departure_date'];
                   $statusConfigAirline = $this->checkTypeFlightAirline($flight, $type, $airline);
                   if (strtolower($flight_type) == 'system' && $airline->checkTypeAirline($flight_type, $airline_iata)) {
                       if ($statusConfigAirline['isPublic'] == '0') {
                           if (functions::compareDate($departure_date_flight, (($statusConfigAirline['isPublic'] == '0') ? $departure_time_flight : ''), '') == 'true') {
                               if ($source_id_flight == $statusConfigAirline['sourceId']) {
                                   $arrReturn[] = $flight;
                               } else if (!in_array($airline_iata, $exist) && ($source_id_flight== $statusConfigAirline['sourceReplaceId'])) {
                                   $arrReturn[] = $flight;
                               }
                           }
                       } else if ($statusConfigAirline['isPublic'] == '1') {
                           if ($source_id_flight== $statusConfigAirline['sourceId'] ) {
                               $arrReturn[] = $flight;
                           } else if ((!in_array($airline_iata, $SystemPublicExist) && ($source_id_flight== $statusConfigAirline['sourceReplaceId']))) {
                               $arrReturn[] = $flight;
                           }
                       }
                   } else if ((strtolower($flight_type) == "charter") && $airline->checkTypeAirline($flight_type, $airline_iata)) {
                       if ($source_id_flight== $statusConfigAirline['sourceId']) {
                           $arrReturn[] = $flight;
                       } else if ((!in_array($airline_iata, $Source7Exist) && $source_id_flight== $statusConfigAirline['sourceReplaceId']) || (!in_array($flight_number_flight, $Source7FlightNumber)) && $source_id_flight== $statusConfigAirline['sourceReplaceId']) {
                           $arrReturn[] = $flight;
                       }
                   }
               }
           }
           else*/


            // در صورتی که پرواز اشتراکی در نتایج بعد فیلتر بالا وجود نداشت از پرواز های مشابه که ایرلاین و شماره پرواز و شناسه نرخی یکسان داشته باشند کمترین قیمت نمایش داده میشوند
            if(!empty($array_private_flights) && empty($array_public_flights)){
                $array_same_flights = $this->checkPriceSort($array_private_flights,$typeRoutForeign);
                foreach ($array_same_flights as $key => $flight) {
                    foreach ($flight as $key_level_1 => $item_flight_level_2) {
                        foreach ($item_flight_level_2 as $key_level_2 => $item_flight_level_3) {
                            foreach ($item_flight_level_3 as $key_level_3=>$item_level_4) {
                                if (count($item_level_4) == 1) {
                                    $selected_flight[$key_level_3.$key.$key_level_1] = $item_level_4;
                                } elseif (count($item_level_4) > 1) {
                                    foreach ($item_level_4 as $flight_level_5){
                                        $source_id_level_5 = isset($flight_level_5['SourceId']) ? $flight_level_5['SourceId'] : $flight_level_5['source_id'];
                                        $statusConfigAirline = $this->checkTypeFlightAirline($flight_level_5, $type, $airline);
                                        if($source_id_level_5 == $statusConfigAirline['sourceId']){
                                            $selected_flight[$key_level_3.$key.$key_level_1] = array($flight_level_5);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                foreach ($selected_flight as $key=>$final_flight){
                    $arrReturn[] = $final_flight[0] ;
                }
//                $arrReturn = $array_same_flights ;
            }else{/*if (empty($array_private_flights) && !empty($array_public_flights))*/

                $arrReturn = $array_total ;

            }

        }
        else{
            $sourceEightOrSixteen = ($typeRoutForeign !='Return') ? '8' : '16';

            functions::insertLog('source detect is=>'. $sourceEightOrSixteen,'detectSource');


            $Source5 = $this->array_filter_by_value($flights, 'SourceId', '1');
            $Source8 = $this->array_filter_by_value($flights, 'SourceId', $sourceEightOrSixteen);

            $existSource5Airline=array();
            foreach ($Source5 as $item) {
                $existSource5Airline[] = $item['Airline'];
            }
            $existSource8Airline=array();
            $existSource8FlightNo=array();
            foreach ($Source8 as $itemSource8) {
                $existSource8Airline[] = $itemSource8['Airline'];
                $existSource8FlightNo[] = $itemSource8['FlightNo'];
            }

            foreach ($flights as $rec) {
                $statusConfigAirline = $this->checkTypeFlightAirline($rec, $type, $airline);
                $showFlight = true;

                if($rec['SourceId'] !='5' || $rec['SourceId'] !='14')
                {
                    $check_detect = $this->checkSourceRoute($typeRoutForeign, $rec, $existSource8Airline) ;
                    if( $check_detect && ($rec['SourceId'] == '15' && in_array($rec['Airline'], $existSource8Airline))){
                        $showFlight = false ;
                    }
                }

                if($showFlight)
                {
                    if ($typeRoutForeign == 'Return' && isset($rec['return']) && !empty($rec['return'])) {
                        if ($rec['SourceId'] == $statusConfigAirline['sourceId'] || $rec['SourceId'] =='8' ) {
                            $arrReturn[] = $rec;
                        } else if (!in_array($rec['Airline'], $existSource5Airline) && !in_array($rec['Airline'], $existSource8Airline) && ($rec['SourceId'] == $statusConfigAirline['sourceReplaceId'])) {
                            $arrReturn[] = $rec;
                        }
                    } elseif ($typeRoutForeign == 'Dept') {
                        if ($rec['SourceId'] == $statusConfigAirline['sourceId']) {
                            $arrReturn[] = $rec;
                        }else if ($rec['SourceId'] == $statusConfigAirline['sourceReplaceId']) {
                            $arrReturn[] = $rec;
                        }
                    }
                }

            }
        }

        return $arrReturn;
    }
    #endregion

    public function checkPriceSort($flights,$type_new) {
        $final_flights = array();
        foreach ($flights as $flight) {
            if($type_new=='new')
            {
                $final_flights[$flight['airline']][$flight['flight_number']][$flight['cabin_type']][$flight['price']['adult']['price']][] = $flight ;

            }else{
                $final_flights[$flight['Airline']][$flight['FlightNumberFilter']][$flight['CabinType']][$flight['AdtPrice']][] = $flight ;

            }
        }

        return $final_flights ;
    }
    public function checkFlightNumber($flight_number,$search_flight_number) {

    }

    #region array_filter_by_value

    public function array_filter_by_value($my_array, $index, $value)
    {
        $new_array = array();
        if (is_array($my_array) && count($my_array) > 0) {
            foreach (array_keys($my_array) as $key) {
                $temp[$key] = $my_array[$key][$index];

                if ($temp[$key] == $value) {
                    $new_array[$key] = $my_array[$key];
                }
            }
        }
        return $new_array;
    }
    #endregion

    #region getTicketPrivate

    public function getTicketPrivate($adult, $child, $infant, $dep_date, $origin, $destination, $return_date, $multiWay)
    {

        $dep_date = str_replace('-', '', $dep_date);

        $resultReservationTicket = Load::controller('resultReservationTicket');
        $tickets['dept'] = $resultReservationTicket->searchReservationTickets($origin, $destination, $dep_date, $multiWay);

        if (empty($tickets['dept'])) {
            $tickets['dept'] = array();
        }

        $sort = array();
        foreach ($tickets['dept'] as $k => $ticket) {
            $sort['FlightNo'][$k] = $ticket['FlightNumber'];
            $sort['Airline'][$k] = $ticket['Airline'];
            $sort['FlightType'][$k] = $ticket['FlightType'];
            $sort['SeatClass'][$k] = $ticket['SeatClass'];
            $sort['DepartureTime'][$k] = $ticket['DepartureTime'];
            $sort['AdtPrice'][$k] = $ticket['AdtPrice'];
        }

        if (!empty($sort)) {
            array_multisort($sort['FlightNo'], SORT_ASC, $sort['Airline'], SORT_ASC, $sort['DepartureTime'], SORT_DESC, $sort['AdtPrice'], SORT_ASC, $tickets);
        }


        if ($return_date != '') {
            $return_date = str_replace('-', '', $return_date);
            $tickets['return'] = $resultReservationTicket->searchReservationTickets($destination, $origin, $return_date, $multiWay);


            if (empty($tickets['return'])) {
                $tickets['return'] = array();
            }

            $sort = array();
            foreach ($tickets['return'] as $k => $ticket) {
                $sort['FlightNo'][$k] = $ticket['FlightNumber'];
                $sort['Airline'][$k] = $ticket['Airline'];
                $sort['FlightType'][$k] = $ticket['FlightType'];
                $sort['SeatClass'][$k] = $ticket['SeatClass'];
                $sort['DepartureTime'][$k] = $ticket['DepartureTime'];
                $sort['AdtPrice'][$k] = $ticket['AdtPrice'];
            }

            if (!empty($sort)) {
                array_multisort($sort['FlightNo'], SORT_ASC, $sort['Airline'], SORT_ASC, $sort['DepartureTime'], SORT_DESC, $sort['AdtPrice'], SORT_ASC, $tickets);
            }

        }

        foreach ($tickets as $direction => $newarray) {

            $i = 0;
            $count = count($newarray);
            for ($key = 0; $key < $count; $key++) {

                $this->TicketWarranty[$direction][$i]['PFlightNo'] = $newarray[$key]['FlightNumber'];
                $this->TicketWarranty[$direction][$i]['PAirline'] = $newarray[$key]['Airline'];
                $this->TicketWarranty[$direction][$i]['TypeVehicle'] = $newarray[$key]['TypeVehicle'];
                $this->TicketWarranty[$direction][$i]['VehicleName'] = $newarray[$key]['VehicleName'];
                $dateArrival = $newarray[$key]['FlightDate'];
                $DateMiladi = functions::ConvertToMiladi(str_replace('/', '-', $dateArrival));

                $this->TicketWarranty[$direction][$i]['id'] = $newarray[$key]['id'];
                $this->TicketWarranty[$direction][$i]['DescriptionTicket'] = $newarray[$key]['DescriptionTicket'];
                $this->TicketWarranty[$direction][$i]['PDepartureParentRegionName'] = $newarray[$key]['OriginAirport'];
                $this->TicketWarranty[$direction][$i]['PArrivalParentRegionName'] = $newarray[$key]['DestinationAirport'];
                $this->TicketWarranty[$direction][$i]['PAircraft'] = $newarray[$key]['TypeVehicle'];
                $this->TicketWarranty[$direction][$i]['PFlightType'] = $newarray[$key]['FlightType'] == "charter" ? '' : '<lable class="iranB txtColor" >' . functions::Xmlinformation("SystemType") . '</lable>';
                $this->TicketWarranty[$direction][$i]['PFlightType_li'] = strtolower($newarray[$key]['FlightType']) == "system" ? 'system' : 'charter';
                $this->TicketWarranty[$direction][$i]['PPersianDepartureDate'] = $dateArrival;
                $this->TicketWarranty[$direction][$i]['PDepartureTime'] = $newarray[$key]['DepartureTime'];
                $this->TicketWarranty[$direction][$i]['Minutes'] = $newarray[$key]['Minutes'];
                $this->TicketWarranty[$direction][$i]['Hour'] = $newarray[$key]['Hour'];
                $this->TicketWarranty[$direction][$i]['PSeatClass'] = ($newarray[$key]['SeatClass'] == 'Y' ? functions::Xmlinformation("EconomicsType") : functions::Xmlinformation("BusinessType"));
                $this->TicketWarranty[$direction][$i]['PCabinType'] = $newarray[$key]['CabinType'];
                $this->TicketWarranty[$direction][$i]['PAdtPrice'] = $newarray[$key]['AdtPrice'];
                $this->TicketWarranty[$direction][$i]['PriceWithDiscount'] = $newarray[$key]['PriceWithDiscount'];
                $this->TicketWarranty[$direction][$i]['PChdPrice'] = $newarray[$key]['ChdPrice'];
                $this->TicketWarranty[$direction][$i]['PChdPriceWithDiscount'] = $newarray[$key]['ChdPriceWithDiscount'];
                $this->TicketWarranty[$direction][$i]['PInfPrice'] = $newarray[$key]['InfPrice'];
                $this->TicketWarranty[$direction][$i]['PInfPriceWithDiscount'] = $newarray[$key]['InfPriceWithDiscount'];
                $this->TicketWarranty[$direction][$i]['PCapacity'] = $newarray[$key]['Capacity'];
                $this->TicketWarranty[$direction][$i]['Weight'] = $newarray[$key]['Weight'];
                $this->TicketWarranty[$direction][$i]['ID'] = $newarray[$key]['ID'];
                $this->TicketWarranty[$direction][$i]['PArrivalDate'] = $this->Date_arrival_private($newarray[$key]['Hour'], $newarray[$key]['Minutes'], $newarray[$key]['DepartureTime'], $DateMiladi);


                $i++;
            }
        }

        $filter_sort = array();
        if (empty($this->TicketWarranty)) {
            $this->TicketWarranty = array();
        }

        foreach ($this->TicketWarranty as $direction => $every_turn) {

            foreach ($this->TicketWarranty[$direction] as $kelid => $Ticket) {
                $filter_sort['AdtPrice'][$kelid] = $Ticket['PAdtPrice'];
                $time = $this->format_hour($Ticket['PDepartureTime']);
                $filter_sort['DepartureTime'][$kelid] = str_replace(':', '', $time);
                $price[$direction][] = $Ticket['AdtPrice'];
            }
            if ($direction == 'dept') {
                $this->countReservationTicket = count($this->TicketWarranty[$direction]);
                $this->minPriceReservation = !empty($price[$direction]) ? min($price[$direction]) : '0';
                $this->maxPriceReservation = !empty($price[$direction]) ? max($price[$direction]) : '0';
            } else {
                $this->countReservationTicketReturn = count($this->TicketWarranty[$direction]);
                $this->minPriceReturnReservation = !empty($price[$direction]) ? min($price[$direction]) : '0';
                $this->maxPriceReturnReservation = !empty($price[$direction]) ? max($price[$direction]) : '0';
            }
        }

        if (!empty($filter_sort)) {
            array_multisort($filter_sort['AdtPrice'], SORT_ASC, $filter_sort['DepartureTime'], SORT_ASC, $this->TicketWarranty);
        }

        $this->adult_qty = $adult;
        $this->child_qty = $child;
        $this->infant_qty = $infant;

        return $this->TicketWarranty;


    }
    #endregion

    #region Date_arrival_private

    public function Date_arrival_private($HourLongFlight, $MinutesLongFlight, $TimeFlight, $DateFlight)
    {
        if ($HourLongFlight > 00) {
            $cal1 = $HourLongFlight * 60;
        } else {
            $cal1 = 0;
        }

        if ($MinutesLongFlight > 00) {
            $cal2 = $MinutesLongFlight;
        } else {
            $cal2 = 0;
        }


        $calTotal = $cal1 + $cal2;
        $time = $this->format_hour($TimeFlight) . ':00';

        $ArrivalDate = date("Y/m/d ", strtotime("+" . $calTotal . " minutes " . $DateFlight . "" . $time)) . '<br/>';

        $gr_explode = explode('/', $ArrivalDate);

        return dateTimeSetting::gregorian_to_jalali($gr_explode[0], $gr_explode[1], $gr_explode[2], '/');
    }

#endregion

#region format_hour

    public function format_hour($num)
    {

        $time = date("H:i", strtotime($num));

        return $time;
    }

#endregion

#region getTicketPrivateOld

    public function getTicketPrivateOld($adult, $child, $infant, $dep_date, $origin, $destination)
    {
        if (IS_ENABLE_TICKET_HTC == '1') {
            $d['origin'] = $origin;
            $d['destination'] = $destination;
            $d['dept_date'] = str_replace('-', '', $dep_date);

            $url = "http://parvaz.co/rest/json_htc_ticket.php";

            $data = $d;

            $tickets = parent::curlExecution($url, $data);


            $FinalTicket = array();

            if (empty($tickets)) {
                $tickets = array();
            }
            foreach ($tickets as $ticket) {
                if (strpos($ticket['Site'], CLIENT_MAIN_DOMAIN) !== false) {
                    $FinalTicket[] = $ticket;
                }
            }

            $sort = array();
            foreach ($FinalTicket as $k => $ticket) {

                $sort['FlightNo'][$k] = $ticket['FlightNo'];
                $sort['Airline'][$k] = $ticket['Airline'];
                $sort['FlightType'][$k] = $ticket['FlightType'];
                $sort['SeatClass'][$k] = $ticket['SeatClass'];
                $sort['DepartureTime'][$k] = $ticket['DepartureTime'];
                $sort['AdtPrice'][$k] = $ticket['AdtPrice'];
            }

            if (!empty($sort)) {
                array_multisort($sort['FlightNo'], SORT_ASC, $sort['Airline'], SORT_ASC, $sort['DepartureTime'], SORT_DESC, $sort['AdtPrice'], SORT_ASC, $FinalTicket);
            }
            $this->countTicketPrivate = count($FinalTicket);

            $i = 0;
            for ($key = 0; $key < $this->countTicketPrivate; $key++) {

                $FlightDateCalculate = substr($FinalTicket[$key]['FlightDate'], 0, 4) . '/' . substr($FinalTicket[$key]['FlightDate'], 4, 2) . '/' . substr($FinalTicket[$key]['FlightDate'], 6, 2);

                $FlightDateArrival = functions::ConvertToMiladi(str_replace('/', '-', $FlightDateCalculate));
                $this->TicketWarranty[$i]['PFlightNo'] = $FinalTicket[$key]['FlightNo'];
                $this->TicketWarranty[$i]['PAirline'] = $FinalTicket[$key]['Airline'];
                $this->TicketWarranty[$i]['PArrivalDate'] = functions::Date_arrival($origin, $destination, $FinalTicket[$key]['DepartureTime'], $FlightDateArrival);

                $this->TicketWarranty[$i]['id'] = $FinalTicket[$key]['id'];
                $this->TicketWarranty[$i]['PDepartureParentRegionName'] = $FinalTicket[$key]['CityR'];
                $this->TicketWarranty[$i]['PArrivalParentRegionName'] = $FinalTicket[$key]['CityB'];
                $this->TicketWarranty[$i]['PAircraft'] = $FinalTicket[$key]['Aircraft'];
                $this->TicketWarranty[$i]['PFlightType'] = $FinalTicket[$key]['FlightType'] == "charter" ? '' : '<lable class="iranB txtColor" >' . functions::Xmlinformation("SystemType") . '</lable>';
                $this->TicketWarranty[$i]['PFlightType_li'] = $FinalTicket[$key]['FlightType'] == "System" ? 'system' : 'charter';
                $this->TicketWarranty[$i]['PPersianDepartureDate'] = $FlightDateCalculate;
                $this->TicketWarranty[$i]['PDepartureTime'] = $FinalTicket[$key]['DepartureTime'];
                $this->TicketWarranty[$i]['PSeatClass'] = ($FinalTicket[$key]['SeatClass'] == 'Y' ? functions::Xmlinformation("EconomicsType") : functions::Xmlinformation("BusinessType"));
                $this->TicketWarranty[$i]['PCabinType'] = $FinalTicket[$key]['CabinType'];
                $this->TicketWarranty[$i]['PUrl'] = $FinalTicket[$key]['Site'];
                $this->TicketWarranty[$i]['PAdtPrice'] = $FinalTicket[$key]['AdtPrice'];
                $this->TicketWarranty[$i]['PChdPrice'] = $FinalTicket[$key]['ChdPrice'];
                $this->TicketWarranty[$i]['PInfPrice'] = $FinalTicket[$key]['InfPrice'];
                $this->TicketWarranty[$i]['PCapacity'] = $FinalTicket[$key]['Capacity'];

                $i++;
            }

            $filter_sort = array();

            if (empty($this->TicketWarranty)) {
                $this->TicketWarranty = array();
            }


            foreach ($this->TicketWarranty as $kelid => $filter) {
                $filter_sort['AdtPrice'][$kelid] = $filter['PAdtPrice'];
                $time = $this->format_hour($filter['PDepartureTime']);
                $filter_sort['DepartureTime'][$kelid] = str_replace(':', '', $time);
            }

            if (!empty($filter_sort)) {
                array_multisort($filter_sort['AdtPrice'], SORT_ASC, $filter_sort['DepartureTime'], SORT_ASC, $this->TicketWarranty);
            }
            foreach ($FinalTicket as $key => $ticket) {

                $price[] = $ticket['AdtPrice'];
            }

            $this->TicketWarranty = self::deleteInactivePrivateAilrline($this->TicketWarranty);


            $this->adult_qty = $adult;
            $this->child_qty = $child;
            $this->infant_qty = $infant;

            $this->PminPrice = !empty($price) ? min($price) : '0';
            $this->PmaxPrice = !empty($price) ? max($price) : '0';

            return $this->TicketWarranty;
        } else {
            $this->TicketWarranty = array();
        }
    }

#endregion

#region deleteInactivePrivateAilrline
//لیست ایرلاین های فعال بلیط های گارانتی شده

    function deleteInactivePrivateAilrline($arr)
    {

//      echo '<pre>' .print_r($arr,true).'</pre>';
//        die();
        $airline = Load::model('airline');

        $arrReturn = array();

        foreach ($arr as $rec) {

            if ($rec['PFlightType_li'] == "system") {
                if (in_array($rec['PAirline'], $airline->getActiveAirline('system'))) {

                    $arrReturn[] = $rec;
                }
            } else {
                if (in_array($rec['PAirline'], $airline->getActiveAirline('charter'))) {

                    $arrReturn[] = $rec;
                }
            }
        }

        return $arrReturn;
    }

#endregion

#region getTicketForeign

    public function getTicketForeign($param, $infoPage = null)
    {

        functions::insertLog('first  getTicketForeign ', 'log_Request_send_search_Foreign');

        $airlineModel = Load::model('airline');
        $airlineList = $airlineModel->getAll();
        foreach ($airlineList as $keyAirline => $airlineInfo) {
            $airlineArrayList[$airlineInfo['abbreviation']] = $airlineInfo;
        }

        $ModelBase = Load::library('ModelBase');
        $queryCity = "SELECT DepartureCode,DepartureCityFa,DepartureCityEn,AirportFa,AirportEn,CountryFa FROM flight_portal_tb";
        $airPortList = $ModelBase->select($queryCity);
        foreach ($airPortList as $keyAirPort => $airPort) {
            $airPortArrayList[$airPort['DepartureCode']] = $airPort;
        }


        $InfoMember = functions::infoMember(Session::getUserId());
        $InfoCounter = functions::infoCounterType($InfoMember['fk_counter_type_id']);

        $DateCheckExplode = explode('-', $param['dept_date']);
        if ($DateCheckExplode[0] > 1450) {
            $param['dept_date'] = dateTimeSetting::gregorian_to_jalali($DateCheckExplode[0], $DateCheckExplode['1'], $DateCheckExplode['2'], '-');

            if ($param['return_date'] != '') {
                $DateReturnExplode = explode('-', $param['return_date']);
                $param['return_date'] = dateTimeSetting::gregorian_to_jalali($DateReturnExplode[0], $DateReturnExplode['1'], $DateReturnExplode['2'], '-');
            }
        }

        if (!empty($infoPage)) {
            if (!isset($infoPage['FlagFilter']) || $infoPage['FlagFilter'] != 'filterForeign') {
                $uniqueCodePage = $param;
                $LogTime = LOGS_DIR . 'cashFlight/' . $uniqueCodePage . 'Time';
                if (!file_exists($LogTime)) {
                    mkdir($LogTime, 0777, true);
                }
                functions::insertLog('1=>', $uniqueCodePage . '_Time_' . $infoPage['numberPage']);

                $fileDirect = LOGS_DIR . 'cashFlight/' . $uniqueCodePage . '.txt';
                $strJsonFileContents = file_get_contents($fileDirect);
                $strJsonFileContents = json_decode($strJsonFileContents, true);

                $newarray = $strJsonFileContents;
                $count = $infoPage['countTicket'];
                $countTicketInPage = count($strJsonFileContents);
                functions::insertLog('2=>', $uniqueCodePage . '_Time_' . $infoPage['numberPage']);
                $uniqueCode = explode('/', $uniqueCodePage);

                $fileDirectTotalTicket = LOGS_DIR . 'cashFlight/' . $uniqueCode[0] . '.txt';
                $totalTicketFileContents = file_get_contents($fileDirectTotalTicket);
                $totalTicketFileContents = json_decode($totalTicketFileContents, true);

                foreach ($totalTicketFileContents as $k => $Ticket) {
                    if (!(in_array($Ticket['Airline'], $this->activeAirlines))) {
                        array_push($this->activeAirlines, $Ticket['Airline']);
                    }
                    $price[] = $Ticket['AdtPrice'];
                }

            } else {
                $hasFiltered = 'filter';
                $dataFilter = $param;


                $param['page'] = '1';
                $param['countTicket'] = '1';
                $filterTicket = Load::controller('filterTicket');

                $interrupt = functions::interrupt();
                $flightType = functions::flightType();
                $seatClass = functions::seatClass();
                $airlinesCode = functions::airlinesCode();
                $time = functions::time();

                foreach ($dataFilter as $filter) {
                    if (in_array($filter, $interrupt)) {
                        $optionFilter['interrupt'][] = $filter;
                    } else if (in_array($filter, $flightType)) {
                        $optionFilter['flightType'][] = $filter;
                    } else if (in_array($filter, $seatClass)) {
                        $optionFilter['seatClass'][] = $filter;
                    } else if (in_array($filter, $airlinesCode)) {
                        $optionFilter['airlinesCode'][] = $filter;
                    } else if (in_array($filter, $time)) {
                        $optionFilter['time'][] = $filter;
                    }
                }


                $fileDirectTotalTicket = LOGS_DIR . 'cashFlight/' . $infoPage['uniqueCodeTicket'] . '.txt';
                $totalTicketFileContents = file_get_contents($fileDirectTotalTicket);
                $totalTicketFileContents = json_decode($totalTicketFileContents, true);

                foreach ($totalTicketFileContents as $k => $Ticket) {
                    if (!(in_array($Ticket['Airline'], $this->activeAirlines))) {
                        array_push($this->activeAirlines, $Ticket['Airline']);
                    }
                    $price[] = $Ticket['AdtPrice'];

                    $statusTickets = $filterTicket->filterTicket($Ticket, $optionFilter);
                    if ($statusTickets) {
                        $finalTickets[] = $Ticket;
                    }
                }


                $newarray = $finalTickets;
                $countTicketInPage = count($finalTickets);
            }

            $param = array();
            $param['dept_date'] = $infoPage['dept_date'];
            $param['return_date'] = $infoPage['return_date'];
            $param['adult'] = $infoPage['adult'];
            $param['child'] = $infoPage['child'];
            $param['infant'] = $infoPage['infant'];
            $param['countTicket'] = $infoPage['countTicket'];
            $param['page'] = isset($infoPage['numberPage']) ? $infoPage['numberPage'] : '';
            $param['lang'] = $infoPage['lang'];
            $param['origin'] = $infoPage['origin'];
            $param['destination'] = $infoPage['destination'];

        } else {
            parent::__construct();
            $infoFile = parent::getTicket($param['adult'], $param['child'], $param['infant'], $param['classf'], $param['origin'], $param['destination'], $param['dept_date'], $param['foreign'], $param['page'], $param['count'], $param['return_date']);

            $infoFile = json_decode($infoFile, true);
            $fileDirect = LOGS_DIR . 'cashFlight/' . $infoFile['UniqueCode'] . '/0' . '.txt';
            $strJsonFileContents = file_get_contents($fileDirect);
            $strJsonFileContents = json_decode($strJsonFileContents, true);

            $newarray = $strJsonFileContents;

            $countTicketInPage = count($newarray);
            $param['page'] = '0';
            $count = $infoFile['countTicket'];


            $fileDirectTotalTicket = LOGS_DIR . 'cashFlight/' . $infoFile['UniqueCode'] . '.txt';
            $totalTicketFileContents = file_get_contents($fileDirectTotalTicket);
            $totalTicketFileContents = json_decode($totalTicketFileContents, true);

            foreach ($totalTicketFileContents as $k => $TicketFlight) {
                if (!(in_array($TicketFlight['OutputRoutes'][0]['Airline']['Code'], $this->activeAirlines))) {
                    array_push($this->activeAirlines, $TicketFlight['OutputRoutes'][0]['Airline']['Code']);
                }

                $PriceAirline[$TicketFlight['OutputRoutes'][0]['Airline']['Code']][] = $TicketFlight['AdtPrice'];
                $price[] = $TicketFlight['AdtPrice'];
            }
        }


        functions::insertLog('Next Of getTicket   : ', 'log_Request_send_search_Foreign');


        $sort = array();
        if (empty($newarray)) {
            $newarray = array();
        }

        $i = 0;

        for ($key = 0; $key < $countTicketInPage; $key++) {

            $KeyRoute = (count($newarray[$key]['OutputRoutes']) - 1);
            $KeyRouteReturn = (count($newarray[$key]['ReturnRoutes']) - 1);

            $this->tickets[$i]['FlightNo'] = $newarray[$key]['OutputRoutes'][0]['FlightNo'];
            $this->tickets[$i]['FlightNoReturn'] = $newarray[$KeyRouteReturn]['ReturnRoutes'][0]['FlightNo'];

            $this->tickets[$i]['Airline'] = $newarray[$key]['OutputRoutes'][0]['Airline']['Code'];
            $this->tickets[$i]['DepartureDate'] = $newarray[$key]['OutputRoutes'][0]['DepartureDate'];
            if (isset($newarray[$key]['SourceId']) && !empty($newarray[$key]['SourceId'])) {

                $this->tickets[$i]['SourceId'] = $newarray[$key]['SourceId'];
            }

            $this->tickets[$i]['ArrivalDate'] = $newarray[$key]['OutputRoutes'][$KeyRoute]['ArrivalDate'];
            $this->tickets[$i]['ArrivalTime'] = $newarray[$key]['OutputRoutes'][$KeyRoute]['ArrivalTime'];


            $DepartureDatePersian = explode('T', $newarray[$key]['OutputRoutes'][0]['DepartureDate']);
            $miladidate = explode('-', $DepartureDatePersian[0]);
            $datePersian = dateTimeSetting::gregorian_to_jalali($miladidate[0], $miladidate[1], $miladidate[2], '/');

            $this->tickets[$i]['DepartureParentRegionName'] = $newarray[$key]['OutputRoutes'][0]['Departure']['ParentRegionName'];
            $this->tickets[$i]['DepartureCode'] = functions::mapIataCode($newarray[$key]['OutputRoutes'][0]['Departure']['Code']);
            $this->tickets[$i]['ArrivalParentRegionName'] = $newarray[$key]['OutputRoutes'][0]['Arrival']['ParentRegionName'];
            $this->tickets[$i]['ArrivalCode'] =  functions::mapIataCode($newarray[$key]['OutputRoutes'][$KeyRoute]['Arrival']['Code']);
            $this->tickets[$i]['Aircraft'] = $newarray[$key]['OutputRoutes'][0]['Aircraft']['Manufacturer'];
            $this->tickets[$i]['FlightType'] = (strtolower($newarray[$key]['FlightType']) == "system") ? '<lable class="iranB site-main-text-color" >' . functions::Xmlinformation("SystemType") . '</lable>' : functions::Xmlinformation("CharterType");
            $this->tickets[$i]['FlightType_li'] = (strtolower($newarray[$key]['FlightType']) == "system") ? 'system' : 'charter';
            $this->tickets[$i]['PersianDepartureDate'] = $datePersian;
            $this->tickets[$i]['Description'] = $newarray[$key]['Description'];
            $this->tickets[$i]['DepartureTime'] = $newarray[$key]['OutputRoutes'][0]['DepartureTime'];
            $this->tickets[$i]['SeatClass'] = (($newarray[$key]['SeatClass'] == 'C' || $newarray[$key]['SeatClass'] == 'B') ? functions::Xmlinformation("BusinessType") : functions::Xmlinformation("EconomicsType"));
            $this->tickets[$i]['SeatClassEn'] = (($newarray[$key]['SeatClass'] == 'C' || $newarray[$key]['SeatClass'] == 'B') ? 'business' : 'economy');
            $this->tickets[$i]['CabinType'] = $newarray[$key]['OutputRoutes'][0]['CabinType'];
            $this->tickets[$i]['AdtPrice'] = $newarray[$key]['AdtPrice'];
            $this->tickets[$i]['ChdPrice'] = $newarray[$key]['ChdPrice'];
            $this->tickets[$i]['InfPrice'] = $newarray[$key]['InfPrice'];
            $this->tickets[$i]['BasPriceOriginAdt'] = $newarray[$key]['BasPriceOriginAdt'];
            $this->tickets[$i]['TaxPriceOriginAdt'] = $newarray[$key]['TaxPriceOriginAdt'];
            $this->tickets[$i]['CommissionPriceAdt'] = $newarray[$key]['CommissionPriceAdt'];
            $this->tickets[$i]['TotalSource'] = $newarray[$key][0]['TotalPrice'];
            $this->tickets[$i]['OriginalSource'] = $newarray[$key][0]['TotalFare'];
            $this->tickets[$i]['CommissionPriceAdt'] = $newarray[$key]['CommissionPriceAdt'];
            $this->tickets[$i]['Capacity'] = $newarray[$key]['Capacity'];
            $this->tickets[$i]['Supplier'] = $newarray[$key]['Supplier']['Name'];
            $this->tickets[$i]['UserId'] = !empty($newarray[$key]['UserId']) ? $newarray[$key]['UserId'] : '';
            $this->tickets[$i]['UserName'] = !empty($newarray[$key]['UserName']) ? $newarray[$key]['UserName'] : '';
            $this->tickets[$i]['SourceId'] = !empty($newarray[$key]['SourceId']) ? $newarray[$key]['SourceId'] : '';
            $this->tickets[$i]['SourceName'] = !empty($newarray[$key]['SourceName']) ? $newarray[$key]['SourceName'] : '';
            $this->tickets[$i]['UniqueCode'] = $newarray[$key]['UniqueCode'];
            $this->tickets[$i]['OutputRoutes'] = $newarray[$key]['OutputRoutes'];
            $this->tickets[$i]['FlightID'] = $newarray[$key]['FlightID'];
            $this->tickets[$i]['ReturnFlightID'] = $newarray[$key]['ReturnFlightID'];
            $this->tickets[$i]['TotalOutputFlightDuration'] = $newarray[$key]['TotalOutputFlightDuration'];
            $this->tickets[$i]['TotalOutputStopDuration'] = $newarray[$key]['TotalOutputStopDuration'];
//
            $DepartureDatePersianReturn = explode('T', $newarray[$key]['ReturnRoutes'][0]['DepartureDate']);
            $miladiDateReturn = explode('-', $DepartureDatePersianReturn[0]);
            $datePersianReturn = dateTimeSetting::gregorian_to_jalali($miladiDateReturn[0], $miladiDateReturn[1], $miladiDateReturn[2], '/');

            if (isset($newarray[$key]['ReturnRoutes']) && !empty($newarray[$key]['ReturnRoutes'])) {
                $this->tickets[$i]['return']['ArrivalDate'] = $newarray[$key]['ReturnRoutes'][$KeyRouteReturn]['ArrivalDate'];
                $this->tickets[$i]['return']['ArrivalTime'] = $newarray[$key]['ReturnRoutes'][$KeyRouteReturn]['ArrivalTime'];
                $this->tickets[$i]['return']['DepartureParentRegionName'] = $newarray[$key]['ReturnRoutes'][0]['Departure']['ParentRegionName'];
                $this->tickets[$i]['return']['DepartureCode'] = $newarray[$key]['ReturnRoutes'][0]['Departure']['Code'];
                $this->tickets[$i]['return']['ArrivalParentRegionName'] = $newarray[$key]['ReturnRoutes'][0]['Arrival']['ParentRegionName'];
                $this->tickets[$i]['return']['ArrivalCode'] = $newarray[$key]['ReturnRoutes'][$KeyRouteReturn]['Arrival']['Code'];
                $this->tickets[$i]['return']['Aircraft'] = $newarray[$key]['ReturnRoutes'][0]['Aircraft']['Manufacturer'];
                $this->tickets[$i]['return']['DepartureTime'] = $newarray[$key]['ReturnRoutes'][0]['DepartureTime'];
                $this->tickets[$i]['return']['PersianDepartureDate'] = $datePersianReturn;
                $this->tickets[$i]['return']['CabinType'] = $newarray[$key]['ReturnRoutes'][0]['CabinType'];
                $this->tickets[$i]['return']['ReturnRoutes'] = $newarray[$key]['ReturnRoutes'];
                $this->tickets[$i]['return']['FlightID'] = $newarray[$key]['FlightID'];
                $this->tickets[$i]['TotalReturnFlightDuration'] = $newarray[$key]['TotalReturnFlightDuration'];
                $this->tickets[$i]['TotalReturnStopDuration'] = $newarray[$key]['TotalReturnStopDuration'];
            }
            $i++;

        }

        $typeRoute = (empty($param['return_date'])) ? 'Dept' : 'Return';

        $this->tickets = $this->deleteInactiveAirline($this->tickets, 'isExternal', $typeRoute);


        if (isset($infoPage['typeSort']) && !empty($infoPage['typeSort'])) {
            if ($infoPage['typeSort'] == 'time') {
                foreach ($this->tickets as $keyTickets => $valueTickets) {
                    $time = functions::format_hour($valueTickets['DepartureTime']);
                    $filter_sort['DepartureTime'][$keyTickets] = str_replace(':', '', $time);
                    if (!empty($filter_sort)) {
//                        array_multisort($filter_sort['DepartureTime'], SORT_DESC, $this->tickets);
                        switch ($infoPage['orderSort']) {
                            case 'asc';
                                array_multisort($filter_sort['DepartureTime'], SORT_ASC, $this->tickets);
                                break;
                            case 'desc':
                                array_multisort($filter_sort['DepartureTime'], SORT_DESC, $this->tickets);
                                break;
                            default:
                                array_multisort($filter_sort['DepartureTime'], SORT_ASC, $this->tickets);
                                break;
                        }
                    }
                }
            } elseif ($infoPage['typeSort'] == 'price') {
                foreach ($this->tickets as $keyTickets => $valueTickets) {
                    $filter_sort['AdtPrice'][$keyTickets] = $valueTickets['AdtPrice'];
                    if (!empty($filter_sort)) {
                        switch ($infoPage['orderSort']) {
                            case 'asc';
                                array_multisort($filter_sort['AdtPrice'], SORT_ASC, $this->tickets);
                                break;
                            case 'desc':
                                array_multisort($filter_sort['AdtPrice'], SORT_DESC, $this->tickets);
                                break;
                            default:
                                array_multisort($filter_sort['AdtPrice'], SORT_ASC, $this->tickets);
                                break;
                        }

                    }
                }
            }

        }


        $this->countTicket = count($this->tickets);
        $this->adult_qty = $param['adult'];
        $this->child_qty = $param['child'];
        $this->infant_qty = $param['infant'];


//        echo Load::plog($this->tickets);
//        Load::autoload('clientAuth');
//        $ClientAuth = new clientAuth();
//        $ClientAuthAccess = $ClientAuth->ticketReservationFlightAuth();
//        if ($ClientAuthAccess['Service'] == 'TicketFlightReserveLocal' && $ClientAuthAccess['SourceName'] == 'reservation') {
//            $reservationTicket = $this->getTicketPrivate($param['adult'], $param['child'], $param['infant'], $param['dept_date'], $param['origin'], $param['destination']);

//        } else {
//            $reservationTicket = $this->getTicketPrivateOld($param['adult'], $param['child'], $param['infant'], $param['dept_date'], $param['origin'], $param['destination']);
//
//        }

        $reservationTicket = '';
        $FlightForeign = Load::controller('flightForeign');
        functions::insertLog('before  Of DataAjaxSearchForeign   : ', 'log_Request_send_search_Foreign');

        $dataSearchAjax['airlineList'] = $airlineArrayList;
        $dataSearchAjax['airPortList'] = $airPortArrayList;
        $dataSearchAjax['airlines'] = $this->activeAirlines;
        $dataSearchAjax['origin'] = $param['origin'];
        $dataSearchAjax['destination'] = $param['destination'];
        $dataSearchAjax['dept_date'] = $param['dept_date'];
        $dataSearchAjax['adult'] = $param['adult'];
        $dataSearchAjax['child'] = $param['child'];
        $dataSearchAjax['infant'] = $param['infant'];
        $dataSearchAjax['return_date'] = $param['return_date'];
        $dataSearchAjax['tickets'] = $this->tickets;
        $dataSearchAjax['reservationTicket'] = $reservationTicket;
        $dataSearchAjax['countTicket'] = $count;
        $dataSearchAjax['page'] = $param['page'];
        $dataSearchAjax['lang'] = $param['lang'];
        $dataSearchAjax['origin'] = $param['origin'];
        $dataSearchAjax['destination'] = $param['destination'];
        $dataSearchAjax['InfoCounter'] = $InfoCounter;
        $dataSearchAjax['minPrice'] = !empty($price) ? min($price) : '0';
        $dataSearchAjax['maxPrice'] = !empty($price) ? max($price) : '0';
        $dataSearchAjax['priceAirline'] = $PriceAirline;
        $dataSearchAjax['MultiWay'] = $this->MultiWay;
        $dataSearchAjax['filterSearch'] = (isset($hasFiltered) && $hasFiltered == 'filter') ? $hasFiltered : '';
        $ClientAuth = new clientAuth();
        $ClientAuthAccess = $ClientAuth->ticketReservationFlightAuth();
        if ($ClientAuthAccess['Service'] == 'TicketFlightReserveLocal' && $ClientAuthAccess['SourceName'] == 'reservation') {
            $reservationTicket = $this->getTicketPrivate($param['adult'], $param['child'], $param['infant'], $param['dept_date'], $param['origin'], $param['destination'], $param['return_date'], $this->MultiWay);

        } else {
            $reservationTicket = $this->getTicketPrivateOld($param['adult'], $param['child'], $param['infant'], $param['dept_date'], $param['origin'], $param['destination']);

        }



        $dataSearchAjax['privateFlightReservation'] = $reservationTicket ;
        $TicketResultForeign = $FlightForeign->DataAjaxSearchForeign($dataSearchAjax);

        functions::insertLog('after Of  DataAjaxSearchForeign   : ', 'log_Request_send_search_Foreign');
        return $TicketResultForeign;
    }

#endregion



#region getFlightType

    public function getFlightType($type = null)
    {

        if ($type != null && $type == "system") {
            return functions::Xmlinformation("SystemType");
        } else {
            return ' ';
        }
    }

#endregion

#region multiKeyExists

    function multiKeyExists(array $array, $key)
    {
        if (array_key_exists($key, $array))
            return true;
        foreach ($array as $k => $v) {
            if (!is_array($v))
                continue;
            if (array_key_exists($key, $v))
                return true;
        }
        return false;
    }

#endregion

#region getAirportDeparture

//TODO: remove after use getAirport ion function class
    public function getAirportDeparture($param = null)
    {


        $select_airport = new Model();

//        $Condition = (($param == "international" && $param != null) ? "local_portal= '1'" : "local_portal= '0'");

        $sql = " SELECT DISTINCTROW Departure_Code , Departure_City, Departure_City as Departure_CityFa,Departure_CityEn  FROM flight_route_tb WHERE local_portal='0' ORDER BY  priorityDeparture=0,priorityDeparture";/*WHERE $Condition*/


        $airport = $select_airport->select($sql);
        $this->dep_airport = $airport;
    }

#endregion

#region getAirportArrival

    //TODO: remove after use getAirport ion function class
    public function getAirportArrival($param)
    {

        $select_airport = new Model();

        $sql = " SELECT DISTINCT  Arrival_Code , Arrival_City, Arrival_City as Arrival_CityFa,Arrival_CityEn  FROM flight_route_tb WHERE Departure_Code='{$param}' AND local_portal='0' ORDER BY  priorityArrival=0,priorityArrival ASC ";

        $airport = $select_airport->select($sql);
        $this->dep_airport_arival = $airport;
//        return $airport;
    }

#endregion

#region GetNameDeparture
// TODO: after use
    public function GetNameDeparture($param)
    {

        $select_airport = new ModelBase();
        $param = (strtoupper($param) == 'ISL' || strtoupper($param) == 'IST' || strtoupper($param) == 'ISTALL') ? 'ISTALL' : $param;

        $sql = " SELECT DISTINCT Departure_City,Departure_CityEn  FROM flight_route_tb WHERE Departure_Code='{$param}' ";

        $departure = $select_airport->load($sql);


        $this->dep_city = $departure;
    }

#endregion

#region GetNameTicketForeign

    public function GetNameTicketForeign($param)
    {

        $select_airport = new ModelBase();
        $param = (strtoupper($param) == 'ISL' || strtoupper($param) == 'IST' || strtoupper($param) == 'ISTALL') ? 'ISTALL' : $param;


        $sql = " SELECT  *  FROM flight_portal_tb WHERE DepartureCode='{$param}' ";

        $departure = $select_airport->load($sql);

        if(SOFTWARE_LANG=='fa'){
            $departure['NameByLanguage']=(empty($departure['DepartureCityFa']) ? $departure['DepartureCityEn'] : $departure['DepartureCityFa']);
            $departure['AirportByLanguage']=$departure['AirportFa'];
            $departure['CountryByLanguage']=$departure['CountryFa'];
        }else{
            $departure['NameByLanguage']=$departure['DepartureCityEn'];
            $departure['AirportByLanguage']=$departure['AirportEn'];
            $departure['CountryByLanguage']=$departure['CountryEn'];
        }

        return $departure;
    }

#endregion

#region GetNameArrival

    public function GetNameArrival($param)
    {

        $select_airport = new ModelBase();

        $sql = " SELECT DISTINCT  Departure_City,Departure_CityEn FROM flight_route_tb WHERE Departure_Code='{$param}'  ";


        $arival_city = $select_airport->load($sql);
        $this->arival_city = $arival_city;
    }

#endregion

#region NameCityForeign

    public function NameCityForeign($param)
    {

        $select_airport = new ModelBase();

        $sql = " SELECT DISTINCT  * FROM flight_portal_tb   ";


        $arrival_city = $select_airport->load($sql);

        return $arrival_city;
    }

#endregion

#region GetDate

    public function GetDate($param)
    {

        $select_airport = new ModelBase();

        $sql = " SELECT DISTINCT  Departure_City,Departure_CityEn FROM flight_route_tb WHERE Departure_Code='{$param}'  ";


        $arival_city = $select_airport->load($sql);
        $this->arival_city = $arival_city;
    }

#endregion

#region DateJalali

//TODO: remove after use DateWithName in functions class
    public function DateJalali($param, $type = null)
    {
        $explode_date = explode('-', $param);

        if ($explode_date[0] > 1450) {

            $jmktime = mktime('0', '0', '0', $explode_date[1], $explode_date['2'], $explode_date[0]);
            $this->date_now = date(" j F Y", $jmktime);
            if (empty($type)) {
                $this->DateJalaliRequest = date("Y-m-d", $jmktime);
            } else if ($type == 'TwoWay') {
                $this->DateJalaliRequestReturn = date("Y-m-d", $jmktime);
            }
            $this->day = date("l", $jmktime);
        } else {

            if (SOFTWARE_LANG != 'fa') {
                $jmktime = mktime('0', '0', '0', $explode_date[1], $explode_date['2'], $explode_date[0]);
                $this->date_now = date(" j F Y", $jmktime);
                if (empty($type)) {
                    $this->DateJalaliRequest = date("Y-m-d", $jmktime);
                } else if ($type == 'TwoWay') {
                    $this->DateJalaliRequestReturn = date("Y-m-d", $jmktime);
                }
                $this->day = date("l", $jmktime);
            } else {
                $jmktime = dateTimeSetting::jmktime(0, 0, 0, $explode_date[1], $explode_date[2], $explode_date[0]);
                $this->date_now = dateTimeSetting::jdate(" j F Y", $jmktime);
                if (empty($type)) {
                    $this->DateJalaliRequest = dateTimeSetting::jdate("Y-m-d", $jmktime, '', '', 'en');
                } else if ($type == 'TwoWay') {
                    $this->DateJalaliRequestReturn = dateTimeSetting::jdate("Y-m-d", $jmktime, '', '', 'en');
                }
                $this->day = dateTimeSetting::jdate("l", $jmktime);
            }
        }
    }

#endregion

#region AirPlaneType

    public function AirPlaneType($param)
    {
        Load::autoload('ModelBase');

        $ModelBase = new ModelBase();

        $sql = " SELECT   *  FROM airplan_type  WHERE name_en='{$param}'  ";


        $AirplanName = $ModelBase->load($sql);

        return empty($AirplanName) ? $param : $AirplanName['name_fa'];
    }

#endregion

#region LongTimeFlightMinutes

    public
    function LongTimeFlightMinutes($param1, $param2)
    {
        $flight_route = new ModelBase();

        $sql = " SELECT   *  FROM flight_route_tb  WHERE Departure_Code='{$param1}' AND Arrival_Code='{$param2}'  ";

        $flight_route = $flight_route->load($sql);

        if (!empty($flight_route['TimeLongFlight'])) {
            $explode_date = explode(':', $flight_route['TimeLongFlight']);

            $jmktime = dateTimeSetting::jmktime($explode_date[0], $explode_date[1], $explode_date[2]);

            $Minutes_time = dateTimeSetting::jdate("i", $jmktime);

            return $Minutes_time;
        }
    }

#endregion

#region format_hour_arrival

    public function format_hour_arrival($param1, $param2, $param3)
    {
        $flight_route = new ModelBase();

        $sql = " SELECT   TimeLongFlight  FROM flight_route_tb  WHERE Departure_Code='{$param1}' AND Arrival_Code='{$param2}'";

        $flight_route = $flight_route->load($sql);

        if (!empty($flight_route['TimeLongFlight'])) {

            $explode_date = explode(':', $flight_route['TimeLongFlight']);

            $jmktime = dateTimeSetting::jmktime($explode_date[0], $explode_date[1], 0);

            $ArrivalTime = $this->getTimeArrival($explode_date[0], $explode_date[1], $param3);

        }

        return $ArrivalTime;
    }

#endregion

#region getTimeArrival

    public function getTimeArrival($HourLongFlight, $MinutesLongFlight, $TimeFlight)
    {

        if ($HourLongFlight > 00) {
            $cal1 = $HourLongFlight * 60;
        } else {
            $cal1 = 0;
        }

        if ($MinutesLongFlight > 00) {
            $cal2 = $MinutesLongFlight;
        } else {
            $cal2 = 0;
        }

        $calTotal = $cal1 + $cal2;
        $time = strtotime($this->format_hour($TimeFlight));
        $ArrivalTime = date("H:i", strtotime('+' . $calTotal . ' minutes', $time));

        return $ArrivalTime;
    }

#endregion

#region search

    public function search($array, $key, $value)
    {
        $results = array();

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, $this->search($subarray, $key, $value));
            }
        }

//        if ($results) {
//
//            return 'اکونومی/بیزینس';
//        } else {
//            return 'اکونومی';
//        }
    }

#endregion

#region set_session_passenger

    public function set_session_passenger()
    {

        $_SESSION['PostPassenger'] = md5(uniqid(rand(), true));

        return $_SESSION['PostPassenger'];
    }

#endregion

#region DateNext

    public
    function DateNext($param)
    {
        $explode = explode('-', $param);

        if ($explode[0] > 1450) {
            $jmktime = mktime('0', '0', '0', $explode[1], $explode['2'], $explode[0]);
        } else {
            $jmktime = dateTimeSetting::jmktime(0, 0, 0, $explode[1], $explode[2], $explode[0]);
        }

        if (SOFTWARE_LANG == 'fa') {
            return dateTimeSetting::jstrftime("%Y-%m-%d", $jmktime + (24 * 60 * 60), '', '', 'en');
        } else {
            return strftime("%Y-%m-%d", $jmktime + (24 * 60 * 60));
        }
    }

#endregion

#region DatePrev

    public function DatePrev($param)
    {
        $explode = explode('-', $param);
        if ($explode[0] > 1450) {
            $jmktime = mktime('0', '0', '0', $explode[1], $explode['2'], $explode[0]);
        } else {
            $jmktime = dateTimeSetting::jmktime(0, 0, 0, $explode[1], $explode[2], $explode[0]);
        }
        if (SOFTWARE_LANG == 'fa') {
            return dateTimeSetting::jstrftime("%Y-%m-%d", $jmktime - (24 * 60 * 60), '', '', 'en');
        } else {
            return strftime("%Y-%m-%d", $jmktime - (24 * 60 * 60));
        }
    }

#endregion

#region indate

    public function indate($param)
    {
        $timenow = time();
        $explode = explode('-', $param);
        if ($explode[0] > 1450) {
            $jmktime = mktime(0, 0, 0, $explode[1], $explode[2], $explode[0]);
        } else {
            $jmktime = dateTimeSetting::jmktime(0, 0, 0, $explode[1], $explode[2], $explode[0]);
        }

        if ($jmktime > $timenow) {
            return true;
        } else {
            return false;
        }
    }

#endregion

#region liveSearchDestination

    public function liveSearchDestination($param)
    {

        Load::autoload('ModelBase');

        $ModelBase = new ModelBase();

        $Code = trim(strtoupper($param['Code']));

        $ParentCode = $Code . 'ALL';
        $Sql = "SELECT *  FROM flight_portal_tb WHERE DepartureCode='{$Code}' OR CountryEn LIKE '%{$Code}%' OR DepartureCityEn LIKE '%{$Code}%' OR CountryFa Like '%{$Code}%'  OR DepartureCityFa LIKE '%{$Code}%' ORDER BY FIELD(DepartureCode,'{$Code}') DESC ";

        $Departures = $ModelBase->select($Sql);

//        echo Load::plog($Departures);
        $DataDeparture = '';
        foreach ($Departures as $Departure) {



            if($param['lang']=='fa'){
                $Departure['NameByLanguage']=$Departure['DepartureCityFa'];
                $Departure['AirportByLanguage']=$Departure['AirportFa'];
                $Departure['CountryByLanguage']=$Departure['CountryFa'];
            }else{
                $Departure['NameByLanguage']=$Departure['DepartureCityEn'];
                $Departure['AirportByLanguage']=$Departure['AirportEn'];
                $Departure['CountryByLanguage']=$Departure['CountryEn'];
            }


            if ($_POST['Type'] == 'origin') {
                if ($Departure['DepartureCode'] == $ParentCode) {
                    $DataDeparture .= '<li onclick="selectDeparture(' . "'" . $Departure['AirportByLanguage'] . "'" . ',' . "'" . $Departure['NameByLanguage'] . "'" . ',' . "'" . $Departure['CountryByLanguage'] . "'" . ',' . "'" . $Departure['DepartureCode'] . "'" . ',' . ')" class="textSearchFlightForeign"><i class="zmdi zmdi-city  zmdi-network-outline site-main-text-color margin-left-5 margin-right-5"></i>' . $Departure['AirportByLanguage'] . '-' . $Departure['NameByLanguage'] . '-' . $Departure['CountryByLanguage'] . '-' . $Departure['DepartureCode'] . '</li>';
                } else {
                    $DataDeparture .= '<li onclick="selectDeparture(' . "'" . $Departure['AirportByLanguage'] . "'" . ',' . "'" . $Departure['NameByLanguage'] . "'" . ',' . "'" . $Departure['CountryByLanguage'] . "'" . ',' . "'" . $Departure['DepartureCode'] . "'" . ',' . ')" class="textSearchFlightForeign"><i class="zmdi zmdi-flight-takeoff site-main-text-color margin-left-5 margin-right-5"></i>' . $Departure['AirportByLanguage'] . '-' . $Departure['NameByLanguage'] . '-' . $Departure['CountryByLanguage'] . '-' . $Departure['DepartureCode'] . '</li>';
                }
            } else if ($_POST['Type'] == 'destination') {
                if ($Departure['DepartureCode'] == $ParentCode) {
                    $DataDeparture .= '<li onclick="selectDestination(' . "'" . $Departure['AirportByLanguage'] . "'" . ',' . "'" . $Departure['NameByLanguage'] . "'" . ',' . "'" . $Departure['CountryByLanguage'] . "'" . ',' . "'" . $Departure['DepartureCode'] . "'" . ',' . ')" class="textSearchFlightForeign"><i class="zmdi zmdi-city zmdi zmdi-network-outline site-main-text-color margin-left-5 margin-right-5"></i>' . $Departure['AirportByLanguage'] . '-' . $Departure['NameByLanguage'] . '-' . $Departure['CountryByLanguage'] . '-' . $Departure['DepartureCode'] . '</li>';
                } else {
                    $DataDeparture .= '<li onclick="selectDestination(' . "'" . $Departure['AirportByLanguage'] . "'" . ',' . "'" . $Departure['NameByLanguage'] . "'" . ',' . "'" . $Departure['CountryByLanguage'] . "'" . ',' . "'" . $Departure['DepartureCode'] . "'" . ',' . ')" class="textSearchFlightForeign"><i class="zmdi zmdi-flight-land site-main-text-color margin-left-5 margin-right-5"></i>' . $Departure['AirportByLanguage'] . '-' . $Departure['NameByLanguage'] . '-' . $Departure['CountryByLanguage'] . '-' . $Departure['DepartureCode'] . '</li>';
                }
            }
        }

        return $DataDeparture;
    }

#endregion


#region ResultFakeFlight
    public function ResultFakeFlight($param)
    {
        $ModelBase = Load::library('ModelBase');
        $SqlCash = "SELECT Content.ContentSearch FROM log_search_cash_tb AS LogSearch 
              LEFT JOIN log_content_cash_tb AS  Content ON Content.SearchId = LogSearch.id WHERE 1=1 AND";

        if ($param['Type'] == 'local') {
            $SqlCash .= " LogSearch.Origin='{$param['origin']}' AND LogSearch.Destination='{$param['destination']}'";
        } else {
            $SqlCash .= " LogSearch.Origin='IKA' AND LogSearch.Destination='DXB'";
        }

        $SqlCash .= "ORDER BY LogSearch.id DESC LIMIT 1";

        $ResultSqlCash = $ModelBase->load($SqlCash);

        $FinalListSearchTicket = json_decode($ResultSqlCash['ContentSearch'], true);


        //origin & destination name
        $OriginCity = $this->NameCity($param['origin']);
        $destinationCity = $this->NameCity($param['destination']);

        foreach ($FinalListSearchTicket as $key => $newarray) {
            $dateArrival = explode('T', $newarray['OutputRoutes'][0]['DepartureDate']);
            $this->tickets['FlightNo'] = $newarray['OutputRoutes'][0]['FlightNo'];
            $this->tickets['Airline'] = $newarray['OutputRoutes'][0]['Airline']['Code'];
            $this->tickets['DepartureDate'] = $newarray['OutputRoutes'][0]['DepartureDate'];
            $this->tickets['ArrivalDate'] = functions::Date_arrival($param['origin'], $param['destination'], $newarray['OutputRoutes'][0]['DepartureTime'], $dateArrival[0]);
            $this->tickets['DepartureCity'] = $OriginCity;
            $this->tickets['ArrivalCity'] = $destinationCity;
            $this->tickets['FlightType'] = ($newarray['FlightType'] == "" || strtolower($newarray['FlightType']) == "charter") ? '' : '<lable class="iranB site-main-text-color" >' . functions::Xmlinformation("SystemType") . '</lable>';
            $this->tickets['FlightType_li'] = ($newarray['FlightType'] == "" || strtolower($newarray[$key]['FlightType']) == 'charter') ? 'charter' : 'system';
            $this->tickets['DepartureTime'] = $newarray['OutputRoutes'][0]['DepartureTime'];
            $this->tickets['AdtPrice'] = parent::ShowPriceTicket((($newarray['IsInternal']) ? 'Local' : 'Portal'), $this->tickets['FlightType_li'], $newarray['PassengerDatas'][0]['BasePrice'], $newarray['SourceId'], $newarray['PassengerDatas'][0]['TaxPrice'], $newarray['PassengerDatas'][0]['CommisionPrice']);
            $this->tickets['Capacity'] = $newarray['Capacity'];
            $this->tickets['SeatClass'] = $newarray['SeatClass'];
            $this->tickets['Origin'] = $param['origin'];
            $this->tickets['Destination'] = $param['destination'];
            $this->tickets['SeatClass'] = (($newarray['SeatClass'] == 'C' || $newarray['SeatClass'] == 'B') ? functions::Xmlinformation("BusinessType") : functions::Xmlinformation("EconomicsType"));
            $this->tickets['Type'] = $param['Type'];


            $Tickets[] = $this->tickets;
        }

        $FlightInternalFake = Load::controller('flightInternalFake');
        $TicketResult = $FlightInternalFake->DataAjaxSearchFake($Tickets, $param['flightNumber']);

        return $TicketResult;
    }
#endregion

    /**
     * @param $rec
     * @param $type
     * @param $airline
     * @return mixed
     */
    private function checkTypeFlightAirline($rec, $type, $airline)
    {
        $dataCheckConfigAirline['flightType'] = isset($rec['FlightType_li']) ? $rec['FlightType_li'] : $rec['flight_type_li'];
        $dataCheckConfigAirline['airline'] = isset($rec['Airline']) ? $rec['Airline'] : $rec['airline'];
        $dataCheckConfigAirline['isInternal'] = $type;
        $dataCheckConfigAirline['sourceId'] = isset($rec['sourceId']) ? $rec['sourceId'] : $rec['source_id'] ;
        /** @var airline $airline */
        return $airline->checkSourceAirline($dataCheckConfigAirline);
    }


    private function airPortForSourceSeven()
    {
        return array(
            'IKA','MHD','KIH','AWZ','IFN','SYZ','BND','TBZ','GSM','ABD','AZD','SDG','KSH',
            'SRY','IIL','OMH','ZAH','PGU','RAS','IST','NJF','DXB','BGW','MCT','TBS','SHJ',
            'ESB','EVN','AYT','SAW','MOW','DME','VKO','SVO','BUS','GYD','ALA','KBL','ADB',
            'DNZ','CAN','ISU','EBL','LHR','BKK','PVG','KZN','DLM','BEY','FRA','DEL','PEK',
            'MIL','ROM','HKT','DAM','BOM','MZR','CGN','GZP','TAS','HAM','LHE','DYU','KIK',
            'KWI','DOH','KDH','OHS','KER','LRR',
        );


    }

    private function airlineNoShow()
    {
        return array(
            'Varesh'
        );
    }

    /**
     * @param $typeRoutForeign
     * @param $rec
     * @param array $existSource8Airline
     * @return bool
     */
    private function checkSourceRoute($typeRoutForeign, $rec, $existSource8Airline) {
        $check_source = (($typeRoutForeign != 'Return' && $rec['SourceId'] =='8') || ($typeRoutForeign == 'Return' && $rec['SourceId'] =='16')) ;
        return
            $check_source && (
            (
                in_array(strtoupper($rec['DepartureCode']), $this->airPortForSourceSeven())
                &&
                in_array(strtoupper($rec['ArrivalCode']), $this->airPortForSourceSeven())
            )
            );
    }
}

