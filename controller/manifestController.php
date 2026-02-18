<?php
class manifestController extends ClientAuth
{
    protected static $model = manifestModel::class;
    private  $OutForExcelManifest='No';
    private  $OutForPrintManifest='No';

    private  $AgencyIdManifest='';
    private  $DataExcelManifest = [];
    private  $AllagenciesMap = [];
    public static function getModelClass()
    {
        return static::$model;
    }

    public function getData()
    {
        return $this->getFlightSources();
    }

    public function getFlightSources()
    {
        // This will be handled by settingCore->ListServer() in the template
        return [];
    }

    public function checkManifestSources($sources)
    {

        // Get sources that have manifest feature enabled
        $manifestSources = $this->getModel(manifestModel::class)
            ->get()
            ->where('deleted_at', null, ' IS ')
            ->all();


        // Create a lookup array of sources with manifest
        $manifestSourceIds = array_column($manifestSources, 'source_id');

        // Add has_manifest flag to each source
        foreach ($sources as &$source) {
            $source['has_manifest'] = in_array($source['sourceCode'], $manifestSourceIds);
        }
        return $sources;
    }

    /**
     * Get flight booking data from trusted manifest sources
     * Organized by date -> route -> flight details -> passengers
     */
    public function getManifestResults($filters = [])
    {
        // Call the new method that fetches from flight and ticket tables with filters
        $result = $this->getFlightTicketResults($filters);

        // If pagination is requested, return the full structure
        if (isset($filters['page']) || isset($filters['per_page'])) {
            return $result;
        }

        // For backward compatibility, return just the data if no pagination
        return isset($result['data']) ? $result['data'] : $result;
    }

    /**
     * Get flight and ticket data from reservation_fly_tb and reservation_ticket_tb
     * Organized by date -> route -> flight -> passengers
     */
    public function getFlightTicketResults($filters = [])
    {
        // Get table names
        $flyTable = $this->getModel('reservationFlyModel')->getTable();
        $manifestUploadTable = $this->getModel('manifestUploadsModel')->getTable();
        $bookRecords = $this->getModel('bookLocalModel')->getTable();
        $ticketTable = $this->getModel('reservationTicketModel')->getTable();
        $originCityTable = $this->getModel('reservationCityModel')->getTable();
        $destinationCityTable = $this->getModel('reservationCityModel')->getTable();
        $agencyLockSeatTable = $this->getModel('agencyLockSeatModel')->getTable();

        //agar samte Panel user Bod
        if(isset($filters['FlagPanelUser']) && $filters['FlagPanelUser']=='Yes'){
            $agencyId = Session::getAgencyId();
            $manifestSources = $this->getModel('agencyLockSeatModel')
                ->get('ticket_id')
                ->where('agency_id', $agencyId)
                ->all();
            foreach ($manifestSources as $row) {
                $allowedTicketIds[] = $row['ticket_id'];
            }
        }

        // Get current date in Shamsi format
        $currentDate = functions::ConvertToJalali(date('Y-m-d'), '');
        $currentDate = str_replace('-', '', $currentDate);
        $currentDate = implode('/', $currentDate);

        $tomorrowDate = functions::ConvertToJalali(date('Y-m-d', strtotime('+7 day')), '');
        $tomorrowDate = str_replace('-', '', $tomorrowDate);
        $tomorrowDate = implode('/', $tomorrowDate);

        // Apply filters
        $dateFrom = '';
        if(isset($filters['date_from'])) {//form search
            $dateFrom = $filters['date_from'];
        }
        else if(!isset($filters['ListArchive'])){//list Archive Same User
            $dateFrom = $currentDate;
        }
        $dateTo = isset($filters['date_to']) ? $filters['date_to'] : '';
        $airline = isset($filters['airline']) ? $filters['airline'] : '';
        $origin = isset($filters['origin']) ? $filters['origin'] : '';
        $destination = isset($filters['destination']) ? $filters['destination'] : '';
        $flightClass = isset($filters['flight_class']) ? $filters['flight_class'] : '';
        $departureTimeFrom = isset($filters['departure_time_from']) ? $filters['departure_time_from'] : '';
        $departureTimeTo = isset($filters['departure_time_to']) ? $filters['departure_time_to'] : '';
        $durationFilter = isset($filters['duration']) ? $filters['duration'] : '';
        $seller = isset($filters['seller']) ? $filters['seller'] : '';
        $flyCode = isset($filters['fly_code']) ? $filters['fly_code'] : '';
        $status = isset($filters['status']) ? $filters['status'] : '';

        // Step 1: Get all tickets with flight and route information
        $ticketsQuery = $this->getModel('reservationTicketModel')
            ->get([
                $ticketTable . '.id as ticket_id',
                $ticketTable . '.date',
                $ticketTable . '.exit_hour',
                $ticketTable . '.fly_total_capacity',
                $ticketTable . '.fly_full_capacity',
                $ticketTable . '.remaining_capacity',
                $ticketTable . '.age',
                $ticketTable . '.type_user',
                $ticketTable . '.fly_code',
                $ticketTable . '.status',
                $ticketTable . '.status_manifest',
                $ticketTable . '.seller_id',
                $ticketTable . '.seller_price',
                $ticketTable . '.vehicle_grade as ticket_vehicle_grade',
                'f' . '.airline',
                'f' . '.origin_city',
                'f' . '.destination_city',
                'f' . '.time',
                'f' . '.vehicle_grade_id',
                'f' . '.fly_code as fly_fly_code',
                "CONCAT(oc.name, ' - ', dc.name) as route_name",
                "CONCAT(oc.name, '-', dc.name) as route_code",
                'oc.name as origin_city_name',
                'dc.name as destination_city_name',
                'vg.name as vehicle_grade_name',
                'COUNT(DISTINCT man.id) as manifest_records_count',
                "
                COUNT(DISTINCT
                    CASE 
                        WHEN book.successfull IN ('book', 'private_reserve') AND book.del = 'no' THEN 1 
                    END
                ) AS book_records_count
                ",
                'tvg.name as ticket_vehicle_grade_name'
            ], true)
            ->joinSimple(
                [$flyTable, 'f'],
                $ticketTable . '.fly_code',
                'f.id'
            )
            ->joinSimple(
                [$agencyLockSeatTable, 'seat'],
                $ticketTable . '.id',
                'seat.ticket_id'
            )
            ->joinSimple(
                [$manifestUploadTable, 'man'],
                $ticketTable . '.id',
                'man.flight_ticket_id'
            )
            ->joinSimple(
                [$bookRecords, 'book'],
                $ticketTable . '.id',
                'book.fk_id_ticket'
            )
            ->joinSimple(
                [$originCityTable, 'oc'],
                'f.origin_city',
                'oc.id',
                'LEFT'
            )
            ->joinSimple(
                [$destinationCityTable, 'dc'],
                'f.destination_city',
                'dc.id',
                'LEFT'
            )
            ->joinSimple(
                ['reservation_vehicle_grade_tb', 'vg'],
                'f.vehicle_grade_id',
                'vg.id',
                'LEFT'
            )
            ->joinSimple(
                ['reservation_vehicle_grade_tb', 'tvg'],
                $ticketTable . '.vehicle_grade',
                'tvg.id',
                'LEFT'
            )
            ->where($ticketTable . '.is_del', 'no')
            ->where('f.is_del', 'no')
            ->where($ticketTable . '.age', 'ADL');



        // Apply date filters
        if ($dateFrom) {
            $ticketsQuery->where($ticketTable . '.date', str_replace(['-','/'],'',$dateFrom), '>=');
        }

        if ($dateTo) {
            $ticketsQuery->where($ticketTable . '.date', str_replace(['-','/'],'',$dateTo), '<=');
        }
        else{
            $ticketsQuery->where($ticketTable . '.date', str_replace(['-','/'],'',$tomorrowDate), '<=');
        }

        // Apply airline filter
        if ($airline) {
            $ticketsQuery->where('f.airline', $airline);
        }

        // Apply origin filter
        if ($origin) {
            $ticketsQuery->where('oc.name', $origin);
        }

        // Apply destination filter
        if ($destination) {
            $ticketsQuery->where('dc.name', $destination);
        }

        // Apply flight class filter
        if ($flightClass) {
            $ticketsQuery->where('tvg.NAME', $flightClass);
        }

        // Apply seller filter
        if ($seller) {
            $ticketsQuery->where($ticketTable .'.seller_id', $seller);
        }

        // Apply fly code filter
        if ($flyCode) {
            $ticketsQuery->where('f.fly_code', $flyCode);
        }

        // Apply departure time filters
        if ($departureTimeFrom) {
            $ticketsQuery->where($ticketTable . '.exit_hour', $departureTimeFrom, '>=');
        }
        if ($departureTimeTo) {
            $ticketsQuery->where($ticketTable . '.exit_hour', $departureTimeTo, '<=');
        }

        // Apply status time filters
        if ($status) {
            $ticketsQuery->where($ticketTable . '.status', $status);
        }

        // Get total count for pagination
        $totalCountQuery = clone $ticketsQuery;
        $totalCount = $totalCountQuery->count();


        // Apply pagination
        $ticketsData = $ticketsQuery->groupBy([
                $ticketTable . '.fly_code',
                $ticketTable . '.date',
                $ticketTable . '.exit_hour',
                $ticketTable . '.vehicle_grade'
            ])
            ->orderBy($ticketTable . '.date', 'ASC')
            ->orderBy($ticketTable . '.exit_hour', 'ASC')
            ->all();
        // Step 2: Organize data by date -> route -> flight -> passengers
        $organized = [];

        $seller_display = '-';
        $seller_name = '-';
        $seller_code = '-';
        $seller_type = '';

        foreach ($ticketsData as $ticket) {
            $ticketId = $ticket['ticket_id'];
            if(!isset($filters['FlagPanelUser']) ||
                  ( isset($filters['FlagPanelUser']) &&
                    $filters['FlagPanelUser']=='Yes' &&
                    in_array($ticketId, $allowedTicketIds)
                  )
              ){
                  $dateTimeArr=$ticket['date'].'_'.str_replace(':','',$ticket['exit_hour']);
                  $date = $ticket['date'];//$this->convertDateForTxt($ticket['date']);
                  // تبدیل شمسی به میلادی
                  $jy = substr($date, 0, 4);
                  $jm = substr($date, 4, 2);
                  $jd = substr($date, 6, 2);
                  $DateMiladi = dateTimeSetting::jalali_to_gregorian($jy, $jm, $jd, '-');
                  // محاسبه روز هفته
                  $stringWeek =dateTimeSetting::jdate('l', strtotime($DateMiladi));
                  // فیلتر روزهای هفته
                    if (isset($filters['week_days']) && is_array($filters['week_days']) && count($filters['week_days']) > 0) {
                        if (!in_array($stringWeek, $filters['week_days'])) {
                            // روز هفته انتخابی کاربر نیست، ردش کن
                            continue;
                        }
                    }

                  //count seaat Agency
                  $agencyLockSeat = $this->getModel('agencyLockSeatModel')
                    ->get([
                        'id',
                        'SUM(count_agency) as sum_count_agency'
                    ])
                    ->where('ticket_id', $ticketId)
                    ->find();
                  $ticket['total_manifest_capacity']=$agencyLockSeat['sum_count_agency'];

                  $routeCode = $ticket['route_code'];
                  $routeName = $ticket['route_name'];
                  $flightCode = $ticket['fly_fly_code'];
                  $flightId = $ticket['fly_code'];
                  $airline = $ticket['airline'];

                  // Use vehicle grade from ticket table first, fallback to fly table
                  $vehicleGrade = !empty($ticket['ticket_vehicle_grade']) ? $ticket['ticket_vehicle_grade'] : $ticket['vehicle_grade_name'];
                  $vehicleGrade = !empty($vehicleGrade) ? $vehicleGrade : 'unknown';

                  // Get display name for vehicle grade
                  $vehicleGradeDisplay = !empty($ticket['ticket_vehicle_grade_name']) ? $ticket['ticket_vehicle_grade_name'] : $ticket['vehicle_grade_name'];
                  $vehicleGradeDisplay = !empty($vehicleGradeDisplay) ? $vehicleGradeDisplay : 'نامشخص';

                  // Calculate flight times
                  $startTime = substr($ticket['exit_hour'],0,5); // Departure time
                  $duration = $this->calculateDuration(substr($ticket['exit_hour'],0,5),$ticket['time']);//modat zaman parvaz
                  $finishTime = $ticket['time']; // forod

                  // Create a unique key for each combination of route, airline, and vehicle grade
                  $uniqueKey = $routeCode . '_' . $airline . '_' . $vehicleGrade;

                  // Initialize date if not exists
                  if (!isset($organized[$dateTimeArr])) {
                      $organized[$dateTimeArr] = [
                          'date' => $date,
                          'stringWeek' => $stringWeek,
                          'routes' => []
                      ];
                  }

                  // Get airline data for abbreviation
                  $airlineData = $this->getAirlineData($airline);
                  $airlineAbbreviation = is_array($airlineData) ? $airlineData['abbreviation'] : $airline;

                  // Initialize route if not exists
                  if (!isset($organized[$dateTimeArr]['routes'][$uniqueKey])) {
                      $organized[$dateTimeArr]['routes'][$uniqueKey] = [
                          'route_code' => $routeCode,
                          'route_name' => $routeName,
                          'airline' => $airline,
                          'airline_abbreviation' => $airlineAbbreviation,
                          'vehicle_grade' => $vehicleGradeDisplay,
                          'flights' => []
                      ];
                  }

                  // Initialize flight if not exists
                  if (!isset($organized[$dateTimeArr]['routes'][$uniqueKey]['flights'][$flightCode])) {
                      $organized[$dateTimeArr]['routes'][$uniqueKey]['flights'][$flightCode] = [
                          'flight' => [
                              'fly_code' => $flightCode,
                              'airline' => $airline,
                              'route_name' => $routeName,
                              'origin_city_name' => $ticket['origin_city_name'],
                              'destination_city_name' => $ticket['destination_city_name'],
                              'vehicle_grade_name' => $vehicleGradeDisplay
                          ],
                          'tickets' => []
                      ];
                  }
                  $arlineData = $this->getAirlineData($airline);
                  // Get manifest records for this ticket
                  $manifestRecords = $this->getModel('manifestUploadsModel')
                      ->get([
                          'id',
                          'passenger_name',
                          'passenger_family',
                          'national_id as passenger_national_code',
                          'passport_number as passportNumber',
                          'passenger_type',
                          'agency_id',
                          'gender as passenger_gender',
                          'phone_number as member_phone',
                          'ticket_number',
                          'upload_timestamp as creation_date',
                          "'manifest' as source_type"
                      ])
                      ->where('flight_ticket_id', $ticket['ticket_id'])
                      ->orderBy('upload_timestamp', 'DESC')
                      ->all(false);

                  // Get form book records for this ticket
                  $bookRecords = $this->getModel('bookLocalModel')
                      ->get([
                          'id',
                          'passenger_name_en as passenger_name',
                          'passenger_family_en as passenger_family',
                          'passenger_national_code',
                          'passportNumber',
                          'passenger_birthday',
                          'passenger_birthday_en',
                          'passenger_gender',
                          'member_phone',
                          'member_email',
                          'successfull',
                          'creation_date',
                          "'form_book' as source_type"
                      ])
                      ->where('fk_id_ticket', $ticket['ticket_id'])
                      ->where('del', 'no')
                      ->whereIn('successfull', ['book', 'private_reserve'])
                      ->orderBy('creation_date', 'DESC')
                      ->all(false);

                  // Get airline name
                  $airlineName = $this->getAirlineName($airline);
                  $airlineData = $this->getAirlineData($airline);

                if(!isset($filters['FlagPanelUser'])){
                    // Add ticket with passengers
                    // --- SELLER LOGIC START ---
                    // If there are manifest records, use agency_code from the first manifest record
                    if (!empty($manifestRecords)) {

                        $seller_type = 'manifest';
                        $agency_code = isset($manifestRecords[0]['agency_code']) ? $manifestRecords[0]['agency_code'] : '';

                        if ($agency_code) {
                            // Find agency by seat_charter_code
                            $agency = $this->getModel('agencyModel')
                                ->get(['name_fa', 'seat_charter_code'])
                                ->where('seat_charter_code', $agency_code)
                                ->where('del', 'no')
                                ->find(false);
                            if ($agency) {
                                $seller_display = $agency['name_fa'] . ' (' . $agency['seat_charter_code'] . ')';
                                $seller_name = $agency['name_fa'];
                                $seller_code = $agency['seat_charter_code'];
                            } else {

                                $seller_display = $agency_code;
                                $seller_code = $agency_code;
                            }
                        }

                    } // If there are book records, try to get agency by domain
                    elseif (!empty($bookRecords)) {
                        $seller_type = 'book';
                        // Try to get domain from book record (if available)
                        $domain = isset($bookRecords[0]['member_email']) ? $bookRecords[0]['member_email'] : '';
                        // Try to find agency by domain or mainDomain
                        $agency = null;
                        if ($domain) {
                            $agency = $this->getModel('agencyModel')
                                ->get(['name_fa', 'seat_charter_code', 'domain', 'mainDomain'])
                                ->where('domain', $domain)
                                ->orWhere('mainDomain', $domain)
                                ->where('del', 'no')
                                ->find(false);
                        }
                        if ($agency) {
                            $short = '-';
                            if (!empty($agency['domain'])) {
                                $host = parse_url($agency['domain'], PHP_URL_HOST);
                                if (!$host) $host = $agency['domain'];
                                $short = substr(str_replace('www.', '', $host), 0, 3);
                            } elseif (!empty($agency['mainDomain'])) {
                                $host = parse_url($agency['mainDomain'], PHP_URL_HOST);
                                if (!$host) $host = $agency['mainDomain'];
                                $short = substr(str_replace('www.', '', $host), 0, 3);
                            }
                            $seller_display = $short;
                            $seller_name = $agency['name_fa'];
                            $seller_code = $agency['seat_charter_code'];
                        }
                    }
                    // --- SELLER LOGIC END ---
                }//end if Panel User For Agency

                 $organized[$dateTimeArr]['routes'][$uniqueKey]['flights'][$flightCode]['tickets'][] = [
                      'ticket' => [
                          'ticket_id' => $ticket['ticket_id'],
                          'date' => $ticket['date'],
                          'exit_hour' => substr($ticket['exit_hour'],0,5),
                          'time' => $ticket['time'],
                          'start_time' => $startTime,
                          'duration' => $duration,
                          'finish_time' => $finishTime,
                          'manifest_records_count' => $ticket['manifest_records_count'],
                          'total_manifest_capacity' => $ticket['total_manifest_capacity'],
                          'book_records_count' => $ticket['book_records_count'],
                          'fly_total_capacity' => $ticket['fly_total_capacity'],
                          'fly_full_capacity' => $ticket['fly_full_capacity'],
                          'remaining_capacity' => $ticket['remaining_capacity'],
                          'age' => $ticket['age'],
                          'type_user' => $ticket['type_user'],
                          'status' => $ticket['status'],
                          'status_manifest' => $ticket['status_manifest'],
                          'seller_idNow' => $ticket['seller_id'],
                          'seller_priceNow' => $ticket['seller_price'],
                          // Add seller info
                          'seller_display' => $seller_display,
                          'seller_name' => $seller_name,
                          'seller_code' => $seller_code,
                          'seller_type' => $seller_type
                      ],
                      'manifest_records' => $manifestRecords,
                      'book_records' => $bookRecords,
                      'airline_name' => $airlineName,
                      'airline_abbreviation' => $airlineData['abbreviation'],
                  ];

            }//end foreach
        }

        // Convert to indexed array and sort
        $result = [];
        foreach ($organized as $date => $dateData) {
            $dateRoutes = [];
            foreach ($dateData['routes'] as $uniqueKey => $routeData) {
                $routeFlights = [];
                foreach ($routeData['flights'] as $flightCode => $flightData) {
                    $routeFlights[] = $flightData;
                }
                $routeData['flights'] = $routeFlights;
                $dateRoutes[] = $routeData;
            }
            $dateData['routes'] = $dateRoutes;
            $result[] = $dateData;
        }
        return [
            'data' => $result
        ];
    }

    /**
     * Calculate finish time (arrival time) based on start time and duration
     * @param string $startTime Departure time in format "HH:MM"
     * @param string $duration Flight duration in format "HH:MM:SS"
     * @return string Arrival time in format "HH:MM"
     */
    private function calculateDuration($startTime, $finishTime)
    {
        if (empty($startTime) || empty($finishTime)) {
            return '-';
        }

        // Parse start time (HH:MM)
        $startParts = explode(':', $startTime);
        if (count($startParts) < 2) {
            return '-';
        }

        $startHours = intval($startParts[0]);
        $startMinutes = intval($startParts[1]);

        // Parse finish time (HH:MM)
        $finishParts = explode(':', $finishTime);
        if (count($finishParts) < 2) {
            return '-';
        }

        $finishHours = intval($finishParts[0]);
        $finishMinutes = intval($finishParts[1]);

        // تبدیل هر دو به دقیقه
        $startTotal = $startHours * 60 + $startMinutes;
        $finishTotal = $finishHours * 60 + $finishMinutes;

        // اگر پرواز به روز بعد می‌رسد
        if ($finishTotal < $startTotal) {
            $finishTotal += 24 * 60;
        }

        $durationMinutes = $finishTotal - $startTotal;

        $hours = intval($durationMinutes / 60);
        $minutes = $durationMinutes % 60;

        // خروجی در قالب HH:MM
        return sprintf('%02d:%02d', $hours, $minutes);
    }

    /**
     * Get flight details for modal display
     * @param array $params
     * @return array
     */
    public function getFlightDetails($params)
    {

        try {
            $ticket_id = isset($params['ticket_id']) ? $params['ticket_id'] : '';

            // Get table names
            $flyTable = $this->getModel('reservationFlyModel')->getTable();
            $ticketTable = $this->getModel('reservationTicketModel')->getTable();
            $manifestTable = $this->getModel('manifestUploadsModel')->getTable();
            $originCityTable = $this->getModel('reservationCityModel')->getTable();
            $destinationCityTable = $this->getModel('reservationCityModel')->getTable();
            $vehicleTable = $this->getModel('reservationVehicleGradeModel')->getTable();
            $bookLocalTable = $this->getModel('bookLocalModel')->getTable();
            $bookLocalExteraTable = $this->getModel('bookLocalExteraModel')->getTable();


            // Get tickets for this specific flight
            $ticket = $this->getModel('reservationTicketModel')
                ->get([
                    $ticketTable . '.id as ticket_id',
                    $ticketTable . '.date',
                    $ticketTable . '.airline',
                    $ticketTable . '.exit_hour',
                    $ticketTable . '.fly_total_capacity',
                    $ticketTable . '.fly_full_capacity',
                    $ticketTable . '.remaining_capacity',
                    $ticketTable . '.age',
                    $ticketTable . '.type_user',
                    'f' . '.airline',
                    'f' . '.origin_city',
                    'f' . '.destination_city',
                    'f' . '.time',
                    'f' . '.vehicle_grade_id',
                    'vh' . '.name as vehicle_grade',
                    'f' . '.fly_code as flight_number',
                    "CONCAT(oc.name, '-', dc.name) as route_name",
                    "CONCAT(oc.name, '-', dc.name) as route_code",
                    'oc.abbreviation as FromCity',
                    'dc.abbreviation as ToCity'
                ], true)
                ->joinSimple(
                    [$flyTable, 'f'],
                    $ticketTable . '.fly_code',
                    'f.id'
                )
                ->joinSimple(
                    [$originCityTable, 'oc'],
                    'f.origin_city',
                    'oc.id',
                    'LEFT'
                )
                ->joinSimple(
                    [$destinationCityTable, 'dc'],
                    'f.destination_city',
                    'dc.id',
                    'LEFT'
                )
                ->joinSimple(
                    [$vehicleTable, 'vh'],
                    $ticketTable.'.vehicle_grade',
                    'vh.id',
                    'LEFT'
                );
            if ($ticket_id) {
                $ticket = $ticket->where($ticketTable . '.id', $ticket_id);
            }
            $ticket = $ticket->where($ticketTable . '.is_del', 'no')
                ->where($ticketTable . '.age', 'ADL')
                ->where('f.is_del', 'no')
                ->orderBy($ticketTable . '.exit_hour', 'ASC')
                ->find();

            $tickets = [];
            $ticketId = $ticket['ticket_id'];

            // Get manifest records with agency information
            $manifestRecords = $this->getModel('manifestUploadsModel')
                ->get([
                    $manifestTable . '.id',
                    'passenger_name',
                    'passenger_family',
                    'national_id as passenger_national_code',
                    'passport_number as passportNumber',
                    'passenger_type as passenger_age',
                    'gender as passenger_gender',
                    'phone_number as member_phone',
                    'ticket_number',
                    'upload_timestamp as creation_date',
                    'agency_id',
                    'agency_tb.name_fa as agency_name',
                    'agency_tb.seat_charter_code',
                    'nira_pnr',
                    'passenger_birthday'
                ], true)
                ->joinSimple(
                    ['agency_tb', 'agency_tb'],
                    $manifestTable . '.agency_id',
                    'agency_tb.id',
                    'inner'
                )
                ->where('flight_ticket_id', $ticketId);
                // ✅ فقط در صورت وجود مقدار برای AgencyIdManifest شرط agency_id هم اضافه می‌شود
                if (!empty($this->AgencyIdManifest)) {
                    $manifestRecords = $manifestRecords->where($manifestTable . '.agency_id', $this->AgencyIdManifest);
                }
                $manifestRecords = $manifestRecords
                    ->orderBy($manifestTable . '.upload_timestamp', 'DESC')
                    ->all(false);

            // Get book records
            $bookRecords = $this->getModel('bookLocalModel')
                ->get([
                    'id',
                    $bookLocalTable . '.passenger_name_en as passenger_name',
                    $bookLocalTable . '.passenger_family_en as passenger_family',
                    $bookLocalTable . '.passenger_national_code',
                    $bookLocalTable . '.passportNumber',
                    $bookLocalTable . '.passenger_birthday',
                    $bookLocalTable . '.passenger_gender',
                    $bookLocalTable . '.member_mobile as member_phone',
                    $bookLocalTable . '.member_email',
                    $bookLocalTable . '.successfull',
                    $bookLocalTable . '.creation_date',
                    $bookLocalTable . '.request_number',
                    $bookLocalTable . '.passenger_age',
                    'BLE.nira_pnr'
                ])
                ->joinSimple(
                    ['book_local_extera_tb', 'BLE'],
                    $bookLocalTable . '.id',
                    'BLE.id_book_local',
                    'LEFT'
                )
                ->where($bookLocalTable.'.fk_id_ticket', $ticketId)
                ->where($bookLocalTable.'.del', 'no')
                ->whereIn($bookLocalTable.'.successfull', ['book', 'private_reserve']);
                // ✅ فقط در صورت وجود مقدار برای AgencyIdManifest شرط agency_id هم اضافه می‌شود
                if (!empty($this->AgencyIdManifest)) {
                    $bookRecords = $bookRecords->where($bookLocalTable.'.agency_id', $this->AgencyIdManifest);
                }
            $bookRecords=$bookRecords
                ->groupBy($bookLocalTable.'.id')
                ->orderBy($bookLocalTable.'.creation_date', 'DESC')
                ->all(false);

            $airlineName = $this->getAirlineData($ticket['airline']);

            $ticket = array_merge($ticket, [
                'airline' => $airlineName,
                'manifest_records' => $manifestRecords,
                'book_records' => $bookRecords,
                'tickets' => count($manifestRecords) + count($bookRecords)

            ]);
            $tickets = $ticket;

            if(isset($params['ChkExcelNira']) && $params['ChkExcelNira']=='Yes'){//excel Nira
                $this->CreateExcelNira($tickets,$params['count_type']);
            }
            else {
                return [
                    'status' => true,
                    'data' => $tickets
                ];
            }

        } catch (Exception $e) {
            functions::insertLog("Error in getFlightDetails: " . $e->getMessage(), 'manifestError');
            return [
                'status' => false,
                'message' => 'خطا در دریافت اطلاعات پرواز'
            ];
        }
    }

    public function updateAgencyCapacity($params)
    {
        try {
            $agency_lock_seat_id = isset($params['agency_lock_seat_id']) ? $params['agency_lock_seat_id'] : 0;
            $newCapacity = isset($params['capacity']) ? $params['capacity'] : 0;

            if ($agency_lock_seat_id <= 0) {
                return [
                    'status' => 'error',
                    'success' => false,
                    'message' => "شناسه آژانس نامعتبر است",
                    'code'    => 400
                ];
            }

            // ظرفیت فعلی آژانس
            $currentDataLockSeat = $this->getModel('agencyLockSeatModel')
                ->get(['agency_id','count_agency','ticket_id'])
                ->where('id', $agency_lock_seat_id)
                ->find();

            if (!$currentDataLockSeat) {
                return [
                    'status' => 'error',
                    'success' => false,
                    'message' => "ظرفیت برای این آژانس تعریف نشده است",
                    'code'    => 400
                ];
            }

            // اطلاعات پرواز
            $infoTicket = $this->getModel('reservationTicketModel')
                ->get(['fly_total_capacity'])
                ->where('id', $currentDataLockSeat['ticket_id'])
                ->find();

            if (!$infoTicket) {
                return [
                    'status' => 'error',
                    'success' => false,
                    'message' => "اطلاعات پرواز یافت نشد",
                    'code'    => 400
                ];
            }

            $flyTotalCapacity = intval($infoTicket['fly_total_capacity']);
            $remainingCapacityNow = $flyTotalCapacity-($this->FunRemainingCapacity($currentDataLockSeat['ticket_id']));

            // اعتبارسنجی ظرفیت
            if ($newCapacity > $flyTotalCapacity) {
                return [
                    'status' => 'error',
                    'success' => false,
                    'message' => "ظرفیت نمی‌تواند بیشتر از ظرفیت اصلی پرواز باشد",
                    'code'    => 400
                ];
            }

            if ($newCapacity > $remainingCapacityNow) {
                return [
                    'status' => 'error',
                    'success' => false,
                    'message' => $newCapacity.' >' .$remainingCapacityNow."ظرفیت نمی‌تواند بیشتر از ظرفیت مانده پرواز باشد",
                    'code'    => 400
                ];
            }

            // ظرفیت بقیه آژانس‌ها
            $totalOtherCapacity=0;
            $otherAgencyCapacity = $this->getModel('agencyLockSeatModel')
                ->get(['count_agency'])
                ->where('agency_id', $currentDataLockSeat['agency_id'], '!=')
                ->where('ticket_id', $currentDataLockSeat['ticket_id'])
                ->all();
            foreach ($otherAgencyCapacity as $row) {
                $totalOtherCapacity += $row['count_agency'];
            }
            if (($totalOtherCapacity + $newCapacity) > $flyTotalCapacity) {
                return [
                    'status' => 'error',
                    'success' => false,
                    'message' => "مجموع ظرفیت تخصیص داده‌شده به آژانس‌ها نمی‌تواند بیشتر از ظرفیت کل پرواز باشد",
                    'code'    => 400
                ];
            }

            // بروزرسانی ظرفیت
            $updateResult = $this->getModel('agencyLockSeatModel')
                ->updateWithBind(
                    ['count_agency' => $newCapacity],
                    ['id' => $agency_lock_seat_id]
                );

            if ($updateResult) {
                return [
                    'status' => 'success',
                    'success' => true,
                    'message' => "ظرفیت با موفقیت تغییر کرد",
                    'code'    => 200
                ];
            } else {
                return [
                    'status' => 'error',
                    'success' => false,
                    'message' => "خطا در بروزرسانی ظرفیت",
                    'code'    => 400
                ];
            }

        } catch (Exception $e) {
            functions::insertLog("Error in updateAgencyCapacity: " . $e->getMessage(), 'capacityError');
            return [
                'status' => 'error',
                'success' => false,
                'message' => "خطای داخلی در تغییر ظرفیت",
                'code'    => 400
            ];
        }
    }


    /**
     * Get flight status for modal display */
    public function getFlightStatus($params)
    {
        try {
            $ticket_id = isset($params['ticket_id']) ? $params['ticket_id'] : '';
            // Get tickets for this specific flight
            $ticket = $this->getModel('reservationTicketModel')
                ->get([
                    'status'
                ], true)
                ->where('id',$ticket_id)
                ->all();
            return [
                'status' => true,
                'data' => $ticket[0]['status']
            ];

        } catch (Exception $e) {
            functions::insertLog("Error in getFlightStatus: " . $e->getMessage(), 'manifestError');
            return [
                'status' => false,
                'message' => 'خطا در دریافت وضعیت پرواز'
            ];
        }
    }

    public function setFlightStatus($params)
    {
        try {
            $ticket_id = isset($params['ticket_id']) ? $params['ticket_id'] : '';
            $status = isset($params['status']) ? $params['status'] : '';

            if (!$ticket_id || !$status) {
                return [
                    'status' => false,
                    'message' => 'شناسه یا وضعیت نامعتبر است'
                ];
            }

            $this->getModel('reservationTicketModel')
                ->updateWithBind(['status' => $status], ['id' => $ticket_id]);

            return [
                'status' => true,
                'message' => 'وضعیت پرواز با موفقیت ذخیره شد'
            ];
        } catch (Exception $e) {
            functions::insertLog("Error in setFlightStatus: " . $e->getMessage(), 'manifestError');
            return [
                'status' => false,
                'message' => 'خطا در ذخیره وضعیت پرواز'
            ];
        }
    }

    /**
     * Get Manifest status for modal display */
    public function getFlightManifestStatus($params)
    {
        try {
            $ticket_id = isset($params['ticket_id']) ? $params['ticket_id'] : '';
            // Get tickets for this specific flight
            $ticket = $this->getModel('reservationTicketModel')
                ->get([
                    'status_manifest'
                ], true)
                ->where('id',$ticket_id)
                ->all();
            return [
                'status' => true,
                'data' => $ticket[0]['status_manifest']
            ];

        } catch (Exception $e) {
            functions::insertLog("Error in getFlightManifestStatus: " . $e->getMessage(), 'manifestError');
            return [
                'status' => false,
                'message' => 'خطا در دریافت وضعیت مانیفست'
            ];
        }
    }
    public function setFlightManifestStatus($params)
    {
        try {
            $ticket_id = isset($params['ticket_id']) ? $params['ticket_id'] : '';
            $status_manifest = isset($params['status_manifest']) ? $params['status_manifest'] : '';

            if (!$ticket_id || !$status_manifest) {
                return [
                    'status' => false,
                    'message' => 'شناسه یا وضعیت نامعتبر است'
                ];
            }
            $this->getModel('reservationTicketModel')
                ->updateWithBind(['status_manifest' => $status_manifest], ['id' => $ticket_id]);

            return [
                'status' => true,
                'message' => 'وضعیت مانیفست با موفقیت ذخیره شد'
            ];
        } catch (Exception $e) {
            functions::insertLog("Error in setFlightManifestStatus: " . $e->getMessage(), 'manifestError');
            return [
                'status' => false,
                'message' => 'خطا در ذخیره وضعیت مانیفست'
            ];
        }
    }

    /**
     * Get Info parvaz for modal display */
    public function getFlightSchedule($params)
    {
        try {

            $ticket_id = isset($params['ticket_id']) ? $params['ticket_id'] : '';
            $ticketTable = $this->getModel('reservationTicketModel')->getTable();
            $agencyTable = $this->getModel('agencyModel')->getTable();
            $flySellerTable = $this->getModel('flySellerModel')->getTable();
            $flyTable = $this->getModel('reservationFlyModel')->getTable();

            // Get tickets for this specific flight
            $ticket = $this->getModel('reservationTicketModel')
                ->get([
                    'id',
                    $ticketTable.'.fly_code as IdFlyCode',
                    $ticketTable.'.type_of_vehicle',
                    $ticketTable.'.exit_hour',
                    $ticketTable.'.free',
                    $ticketTable.'.seller_id',
                    $ticketTable.'.seller_price',
                    'F.fly_code as NumberFlyCode',
                    'F.type_of_vehicle_id',
                    'A.name_fa as NameSeller'
                    ])
                ->joinSimple(
                    [$flyTable, 'F'],
                    $ticketTable.'.fly_code',
                    'F.id',
                    'INNER'
                )
                ->joinSimple(
                    [$agencyTable, 'A'],
                     $ticketTable . '.seller_id',
                     'A.id'
                )
                ->where($ticketTable.'.id',$ticket_id)
                ->all();

            //
            $SellerId=$ticket[0]['seller_id'];
            $SellerPrice=$ticket[0]['seller_price'];
            $NameSeller=$ticket[0]['NameSeller'];
            $IdFlyCode=$ticket[0]['IdFlyCode'];
            $NumberFlyCode=$ticket[0]['NumberFlyCode'];
            $ExitHours=substr($ticket[0]['exit_hour'],0,5);
            $TypeOfVehicleId=$ticket[0]['type_of_vehicle_id'];
            $TypeOfPlane=$ticket[0]['type_of_vehicle'];
            $Free=$ticket[0]['free'];
            return [
                'status' => true,
                'data' => [
                    'SellerId'      => $SellerId,
                    'SellerPrice'   => $SellerPrice,
                    'NameSeller'    => $NameSeller,
                    'IdFlyCode'     => $IdFlyCode,
                    'NumberFlyCode' => $NumberFlyCode,
                    'ExitHours'     => $ExitHours,
                    'TypeOfVehicleId' => $TypeOfVehicleId,
                    'TypeOfPlane'   => $TypeOfPlane,
                    'Free'          => $Free
                ]
            ];

        } catch (Exception $e) {
            functions::insertLog("Error in getFlightSchedule: " . $e->getMessage(), 'manifestError');
            return [
                'status' => false,
                'message' => 'خطا در دریافت اطلاعات پایه برنامه پرواز'
            ];
        }
    }

    public function setFlightSchedule($params)
    {
        try {
            $ticket_id = isset($params['ticket_id']) ? $params['ticket_id'] : '';
            $SellerId = isset($params['SellerId']) ? $params['SellerId'] : '';
            $SellerPrice = isset($params['SellerPrice']) ? str_ireplace(",", "", $params['SellerPrice']) : '';
            $exitHour = isset($params['exitHour']) ? $params['exitHour'] : '';
            $typeOfPlane = isset($params['typeOfPlane']) ? $params['typeOfPlane'] : '';
            $free = isset($params['free']) ? $params['free'] : '';
            $flyCode_id = isset($params['flyCode_id']) ? $params['flyCode_id'] : '0';
            $flyCode_text = isset($params['flyCode_text']) ? $params['flyCode_text'] : '';

            if (!$ticket_id) {
                return [
                    'status' => false,
                    'message' => 'شناسه نامعتبر است'
                ];
            }

            $ticketTable = $this->getModel('reservationTicketModel')->getTable();
            // Get tickets for this specific flight
            $ticket = $this->getModel('reservationTicketModel')
                ->get([
                    'id',
                    $ticketTable.'.fly_code',
                    $ticketTable.'.airline',
                    $ticketTable.'.vehicle_grade',
                    $ticketTable.'.date'
                ])
                ->where($ticketTable.'.id',$ticket_id)
                ->all();

            if($flyCode_id>0){
                $flyCode_idEnd=$flyCode_id;
            }
            else{//insert Kon Flycode Jadidi
                $infoFlyCodeNow = $this->getModel('reservationFlyModel')
                    ->get()
                    ->where('id', $ticket[0]['fly_code'])
                    ->find();

                $insert_fly = $this->getModel('reservationFlyModel')->insertWithBind([
                    'origin_country' => $infoFlyCodeNow['origin_country'],
                    'origin_city' => $infoFlyCodeNow['origin_city'],
                    'origin_region'=> $infoFlyCodeNow['origin_region'],
                    'destination_country'=> $infoFlyCodeNow['destination_country'],
                    'destination_city'=> $infoFlyCodeNow['destination_city'],
                    'destination_region'=> $infoFlyCodeNow['destination_region'],
                    'origin_airport'=> $infoFlyCodeNow['origin_airport'],
                    'destination_airport'=> $infoFlyCodeNow['destination_airport'],
                    'fly_code' => $flyCode_text,
                    'type_of_plane'=> $infoFlyCodeNow['type_of_plane'],
                    'free'=> $infoFlyCodeNow['free'],
                    'type_of_vehicle_id'=> $infoFlyCodeNow['type_of_vehicle_id'],
                    'airline'=> $infoFlyCodeNow['airline'],
                    'vehicle_grade_id'=> $infoFlyCodeNow['vehicle_grade_id'],
                    'time'=> $infoFlyCodeNow['time'],
                    'is_del'=>'no'
                ]);

                if ($insert_fly) {
                    $fly_new = $this->getModel('reservationFlyModel')
                        ->get(['id'])
                        ->where('fly_code', $flyCode_text)
                        ->orderBy('id', 'DESC')
                        ->limit(0, 1)
                        ->find();
                    $flyCode_idEnd=$fly_new['id'];
                }
            }

            $this->getModel('reservationTicketModel')
                ->updateWithBind(
                    [
                        'exit_hour' => $exitHour,
                        'free' => $free,
                        'type_of_vehicle' => $typeOfPlane,
                        'seller_id' => $SellerId,
                        'seller_price' => $SellerPrice,
                        'fly_code' => $flyCode_idEnd
                    ],
                    [
                        'fly_code' => $ticket[0]['fly_code'],
                        'airline'  => $ticket[0]['airline'],
                        'vehicle_grade' => $ticket[0]['vehicle_grade'],
                        'date' => $ticket[0]['date']
                    ]);

            return [
                'status' => true,
                'message' => 'اطلاعات پایه برنامه پرواز با موفقیت ذخیره شد'
            ];
        } catch (Exception $e) {
            functions::insertLog("Error in setFlightSchedule: " . $e->getMessage(), 'manifestError');
            return [
                'status' => false,
                'message' => 'خطا در ذخیره اطلاعات پایه برنامه پرواز'
            ];
        }
    }

    public function setBulkEdit($params)
    {
        try {
            if (empty($params['ticket_ids']) || !is_array($params['ticket_ids'])) {
                return [
                    'status' => false,
                    'message' => 'هیچ رکوردی انتخاب نشده است.'
                ];
            }

            $SellerId     = isset($params['SellerId']) ? $params['SellerId'] : '';
            $SellerPrice  = isset($params['SellerPrice']) ? str_ireplace(",", "", $params['SellerPrice']) : '';
            $exitHour     = isset($params['exitHour']) ? $params['exitHour'] : '';
            $typeOfPlane  = isset($params['typeOfPlane']) ? $params['typeOfPlane'] : '';
            $free         = isset($params['free']) ? $params['free'] : '';
            $flyCode_id   = isset($params['flyCode_id']) ? $params['flyCode_id'] : '0';
            $flyCode_text = isset($params['flyCode_text']) ? $params['flyCode_text'] : 'NOText';
            $flyCode_idEnd='';

            $ticketTable = $this->getModel('reservationTicketModel')->getTable();
            // Get tickets for this specific flight
            foreach ($params['ticket_ids'] as $ticket_id) {
                $ticket = $this->getModel('reservationTicketModel')
                    ->get([
                        'id',
                        $ticketTable . '.fly_code',
                        $ticketTable . '.airline',
                        $ticketTable . '.vehicle_grade',
                        $ticketTable . '.date'
                    ])
                    ->where($ticketTable . '.id', $ticket_id)
                    ->find();

                if ($flyCode_idEnd == '') {//yek bar check shavad
                    if ($flyCode_id > 0) {
                        $flyCode_idEnd = $flyCode_id;
                    }
                    else if($flyCode_text!='NOText') {//insert Kon Flycode Jadidi
                        $infoFlyCodeNow = $this->getModel('reservationFlyModel')
                            ->get()
                            ->where('id', $ticket['fly_code'])
                            ->find();

                        $insert_fly = $this->getModel('reservationFlyModel')->insertWithBind([
                            'origin_country' => $infoFlyCodeNow['origin_country'],
                            'origin_city' => $infoFlyCodeNow['origin_city'],
                            'origin_region' => $infoFlyCodeNow['origin_region'],
                            'destination_country' => $infoFlyCodeNow['destination_country'],
                            'destination_city' => $infoFlyCodeNow['destination_city'],
                            'destination_region' => $infoFlyCodeNow['destination_region'],
                            'origin_airport' => $infoFlyCodeNow['origin_airport'],
                            'destination_airport' => $infoFlyCodeNow['destination_airport'],
                            'fly_code' => $flyCode_text,
                            'type_of_plane' => $infoFlyCodeNow['type_of_plane'],
                            'free' => $infoFlyCodeNow['free'],
                            'type_of_vehicle_id' => $infoFlyCodeNow['type_of_vehicle_id'],
                            'airline' => $infoFlyCodeNow['airline'],
                            'vehicle_grade_id' => $infoFlyCodeNow['vehicle_grade_id'],
                            'time' => $infoFlyCodeNow['time'],
                            'is_del' => 'no'
                        ]);

                        if ($insert_fly) {
                            $fly_new = $this->getModel('reservationFlyModel')
                                ->get(['id'])
                                ->where('fly_code', $flyCode_text)
                                ->orderBy('id', 'DESC')
                                ->limit(0, 1)
                                ->find();
                            $flyCode_idEnd = $fly_new['id'];
                        }
                    }
                    else{
                        $flyCode_idEnd = 'NoChecked';
                    }
                }//end if flyCode_idEnd

                // 🔹 آماده‌سازی داده‌های جدید (فقط فیلدهای پرشده)
                $updateData = [];
                if ($exitHour !== '')    $updateData['exit_hour'] = $exitHour;
                if ($free !== '')        $updateData['free'] = $free;
                if ($typeOfPlane !== '') $updateData['type_of_vehicle'] = $typeOfPlane;
                if ($SellerId !== '')    $updateData['seller_id'] = $SellerId;
                if ($SellerPrice !== '') $updateData['seller_price'] = $SellerPrice;
                if (!empty($flyCode_idEnd) && $flyCode_idEnd !='NoChecked') $updateData['fly_code'] = $flyCode_idEnd;

                $this->getModel('reservationTicketModel')
                    ->updateWithBind(
                        $updateData,
                        [
                            'fly_code' => $ticket['fly_code'],
                            'airline'  => $ticket['airline'],
                            'vehicle_grade' => $ticket['vehicle_grade'],
                            'date' => $ticket['date']
                        ]);
            }//end foreach


            return [
                'status' => true,
                'message' => 'اطلاعات پایه برنامه پرواز با موفقیت بصورت گروهی ذخیره شد'
            ];
        } catch (Exception $e) {
            functions::insertLog("Error in setBulkEdit: " . $e->getMessage(), 'manifestError');
            return [
                'status' => false,
                'message' => 'خطا در ذخیره اطلاعات پایه برنامه پرواز به صورت گروهی '
            ];
        }
    }

    /**
     * Get flight Capacity for modal display */
    public function getTotalFlightCapacity($params)
    {
        try {
            $ticket_id = isset($params['ticket_id']) ? $params['ticket_id'] : '';

            $ticket = $this->getModel('reservationTicketModel')
                ->get(['fly_total_capacity'], true)
                ->where('id', $ticket_id)
                ->all();
            $reservedCapacity=$this->FunRemainingCapacity($ticket_id);
            return [
                'status' => true,
                'data' => [
                    'capacity' => $ticket[0]['fly_total_capacity'],
                    'reserved_count' => $reservedCapacity
                ]
            ];
        } catch (Exception $e) {
            functions::insertLog("Error in getTotalFlightCapacity: " . $e->getMessage(), 'manifestError');
            return [
                'status' => false,
                'message' => 'خطا در دریافت ظرفیت کل پرواز'
            ];
        }
    }
    public function updateTotalFlightCapacity($params)
    {
        try {
            $ticket_id = isset($params['ticket_id']) ? $params['ticket_id'] : '';
            $delta = isset($params['delta']) ? (int)$params['delta'] : 0;

            if (!$ticket_id) {
                return [
                    'status' => false,
                    'message' => 'شناسه نامعتبر است'
                ];
            }

            $ticket = $this->getModel('reservationTicketModel')
                ->get(['fly_total_capacity','remaining_capacity','fly_code','airline','vehicle_grade','date'])
                ->where('id', $ticket_id)
                ->find();

            if (!$ticket) {
                return [
                    'status' => false,
                    'message' => 'پرواز مورد نظر یافت نشد'
                ];
            }

            $currentCapacity = (int)$ticket['fly_total_capacity'];
            $currentRemaining = (int)$ticket['remaining_capacity'];

            // محاسبه ظرفیت جدید
            $new_capacity = $currentCapacity + $delta;
            $new_remaining = $currentRemaining + $delta;
            $reservedCapacity=$this->FunRemainingCapacity($ticket_id);

            if ($new_capacity < $reservedCapacity) {
                return [
                    'status' => false,
                    'message' => "ظرفیت نمی‌تواند کمتر از تعداد رزروهای انجام شده ({$reservedCapacity}) باشد"
                ];
            }

            // ذخیره ظرفیت جدید ::: صبر کن تغییرش بدیم
            $result = $this->getModel('reservationTicketModel')
               ->updateWithBind(
                   ['fly_total_capacity' => $new_capacity,
                    'remaining_capacity' => $new_remaining
                   ],
                   [   'fly_code'=> $ticket['fly_code'],
                       'airline'=>$ticket['airline'],
                       'vehicle_grade'=>$ticket['vehicle_grade'],
                       'date'=>$ticket['date']
                   ]
               );

            return [
                'status' => true,
                'message' => 'ظرفیت کل پرواز با موفقیت ذخیره شد'
            ];

        } catch (Exception $e) {
            functions::insertLog("Error in updateTotalFlightCapacity: " . $e->getMessage(), 'manifestError');
            return [
                'status' => false,
                'message' => 'خطا در ذخیره ظرفیت کل پرواز'
            ];
        }
    }

    /**
     * Export flight details to TXT file in manifest format
     * @param array $params
     * @return array
     */
    public function exportFlightDetailsToTxt($params)
    {
        try {
            $airlineIata = isset($params['airline_iata']) ? $params['airline_iata'] : '';
            $flightNumber = isset($params['flight_number']) ? $params['flight_number'] : '';
            $flightDate = isset($params['flight_date']) ? $params['flight_date'] : '';

            // Get flight details
            $flightDetails = $this->getFlightDetails($params);

            if (!$flightDetails['status']) {
                return [
                    'status' => false,
                    'message' => 'جزئیات پرواز یافت نشد.'
                ];
            }


            $txtContent = "";
            $dateFormatted = $this->convertDateForTxt($flightDate);


                foreach ($flightDetails['data']['manifest_records'] as $passenger) {
                    $txtContent .= $this->formatPassengerLineForTxt($passenger, $airlineIata, $flightNumber, $dateFormatted, 'manifest') . ",\n";
                }
                foreach ($flightDetails['data']['book_records'] as $passenger) {
                    $txtContent .= $this->formatPassengerLineForTxt($passenger, $airlineIata, $flightNumber, $dateFormatted, 'book') . ",\n";
                }


            // Create filename
            $filename = "manifest_{$airlineIata}_{$flightNumber}_{$flightDate}.txt";

            // Use config system for proper file path
            $config = Load::Config('application');
            $config->pathFile('manifest_exports/');
            $exportDir = rtrim($config->path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

            if (!file_exists($exportDir)) {
                mkdir($exportDir, 0755, true);
            }

            $filePath = $exportDir . $filename;

            // Write file with UTF-8 BOM for proper Persian text display
            file_put_contents($filePath, "\xEF\xBB\xBF" . $txtContent);

            return [
                'status' => true,
                'data' => [
                    'file_url' => ROOT_ADDRESS_WITHOUT_LANG . '/pic/manifest_exports/' . $filename,
                    'file_name' => $filename
                ]
            ];

        } catch (Exception $e) {
            functions::insertLog("Error in exportFlightDetailsToTxt: " . $e->getMessage(), 'manifestError');
            return [
                'status' => false,
                'message' => 'خطا در ایجاد فایل TXT: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Format passenger data for TXT export in manifest format
     * @param array $passenger
     * @param string $airlineIata
     * @param string $flightNumber
     * @param string $dateFormatted
     * @param string $source
     * @return string
     */
    private function formatPassengerLineForTxt($passenger, $airlineIata, $flightNumber, $dateFormatted, $source)
    {
        // Format: ticket_number,agency_code,passenger_family/passenger_name,type,airline,flight_number,date,national_id,passport,gender,phone

        // Ticket number
        $ticketNumber = '';
        if ($source === 'manifest' && !empty($passenger['ticket_number'])) {
            $ticketNumber = $passenger['ticket_number'];
        } elseif ($source === 'book' && !empty($passenger['request_number'])) {
            $ticketNumber = $passenger['request_number']; // Use request number for book records
        }

        // Agency code (default to MYSEAT for now)
        $agencyCode = 'MYSEAT';

        // Passenger name
        $passengerName = '';
        if (!empty($passenger['passenger_family']) && !empty($passenger['passenger_name'])) {
            $passengerName = trim($passenger['passenger_family']) . '/' . trim($passenger['passenger_name']);
        } elseif (!empty($passenger['passenger_name'])) {
            $passengerName = trim($passenger['passenger_name']);
        }

        // Passenger type (default to ADL for adult)
        $passengerType = 'ADL';
        if ($source === 'manifest' && !empty($passenger['passenger_type'])) {
            $passengerType = $this->convertPassengerType($passenger['passenger_type']);
        } elseif ($source === 'book' && !empty($passenger['passenger_birthday'])) {
            // Calculate age from birthday for book records
            $birthday = new DateTime($passenger['passenger_birthday']);
            $today = new DateTime();
            $age = $today->diff($birthday)->y;

            if ($age < 2) {
                $passengerType = 'INF'; // Infant
            } elseif ($age < 12) {
                $passengerType = 'CHD'; // Child
            } else {
                $passengerType = 'ADL'; // Adult
            }
        }

        // National ID
        $nationalId = '';
        if ($source === 'manifest' && !empty($passenger['passenger_national_code'])) {
            $nationalId = $passenger['passenger_national_code'];
        } elseif ($source === 'book' && !empty($passenger['passenger_national_code'])) {
            $nationalId = $passenger['passenger_national_code'];
        }

        // Passport number
        $passportNumber = '';
        if ($source === 'manifest' && !empty($passenger['passportNumber'])) {
            $passportNumber = $passenger['passportNumber'];
        } elseif ($source === 'book' && !empty($passenger['passportNumber'])) {
            $passportNumber = $passenger['passportNumber'];
        }

        // Gender
        $gender = '';
        if (!empty($passenger['passenger_gender'])) {
            $gender = $this->minimalGender($passenger['passenger_gender']);
        }

        // Phone number
        $phoneNumber = '';
        if ($source === 'manifest' && !empty($passenger['member_phone'])) {
            $phoneNumber = $passenger['member_phone'];
        } elseif ($source === 'book' && !empty($passenger['member_mobile'])) {
            $phoneNumber = $passenger['member_mobile'];
        }

        // Create the line in the required format
        return implode(',', [
            $ticketNumber,
            $agencyCode,
            $passengerName,
            $passengerType,
            $airlineIata,
            $flightNumber,
            $dateFormatted,
            $nationalId,
            $passportNumber,
            $gender,
            $phoneNumber
        ]);
    }

    /**
     * Get airline code from IATA code
     * @param string $airlineIata
     * @return string
     */
    private function getAirlineCode($airlineIata)
    {
        // This is a simple mapping - you might need to implement proper lookup
        // For now, return the IATA code as is
        return $airlineIata;
    }

    /**
     * Get airline name from airline model
     * @param string $airlineCode
     * @return string
     */
    private function getAirlineName($airlineCode)
    {
        try {
            // Use the airline model to get airline name
            $airline = $this->getModel('airlineModel')
                ->get(['name_fa', 'name_en'])
                ->where('id', $airlineCode)
                ->all(false);

            if (!empty($airline) && isset($airline[0])) {
                // Return Persian name if available, otherwise English name
                return !empty($airline[0]['name_fa']) ? $airline[0]['name_fa'] : $airline[0]['name_en'];
            }

            return $airlineCode; // Return code if not found

        } catch (Exception $e) {
            functions::insertLog("Error getting airline name: " . $e->getMessage(), 'manifestError');
            return $airlineCode; // Return code if any error
        }
    }

    /**
     * Get summary statistics for flight and ticket results
     */
    /**
     * Get all vehicle grades for filter dropdown
     * @return array
     */
    public function getVehicleGrades()
    {
        return $this->getModel('reservationVehicleGradeModel')
            ->get(['id', 'name', 'abbreviation'])
            ->where('is_del', 'no')
            ->orderBy('name', 'ASC')
            ->all();
    }

    /**
     * Get filter options for the manifest results page
     */
    public function getFilterOptions()
    {
        $flyTable = $this->getModel('reservationFlyModel')->getTable();
        $ticketTable = $this->getModel('reservationTicketModel')->getTable();
        $originCityTable = $this->getModel('reservationCityModel')->getTable();
        $destinationCityTable = $this->getModel('reservationCityModel')->getTable();
        $gradeTable = $this->getModel('reservationVehicleGradeModel')->getTable();
        $sellerTable = $this->getModel('flySellerModel')->getTable();

        // Get airlines
        $airlines = $this->getModel('reservationTicketModel')
            ->get(['f.airline'], true)
            ->joinSimple([$flyTable, 'f'], $ticketTable . '.fly_code', 'f.id')
            ->where($ticketTable . '.is_del', 'no')
            ->where('f.is_del', 'no')
            ->groupBy('f.airline')
            ->all();

        $airlineOptions = [];
        foreach ($airlines as $airline) {
            $airlineData = $this->getAirlineData($airline['airline']);
            if ($airlineData && is_array($airlineData)) {
                $airlineOptions[] = [
                    'value' => $airline['airline'],
                    'label' => $airlineData['name_fa'] ?: $airlineData['name_en']
                ];
            }
        }

        // Get origin cities
        $origins = $this->getModel('reservationTicketModel')
            ->get(['oc.name'], true)
            ->joinSimple([$flyTable, 'f'], $ticketTable . '.fly_code', 'f.id')
            ->joinSimple([$originCityTable, 'oc'], 'f.origin_city', 'oc.id', 'LEFT')
            ->where($ticketTable . '.is_del', 'no')
            ->where('f.is_del', 'no')
            ->where('oc.name', '', '!=')
            ->groupBy('oc.name')
            ->orderBy('oc.name', 'ASC')
            ->all();

        // Get destination cities
        $destinations = $this->getModel('reservationTicketModel')
            ->get(['dc.name'], true)
            ->joinSimple([$flyTable, 'f'], $ticketTable . '.fly_code', 'f.id')
            ->joinSimple([$destinationCityTable, 'dc'], 'f.destination_city', 'dc.id', 'LEFT')
            ->where($ticketTable . '.is_del', 'no')
            ->where('f.is_del', 'no')
            ->where('dc.name', '', '!=')
            ->groupBy('dc.name')
            ->orderBy('dc.name', 'ASC')
            ->all();

        // Get vehicle grades
        $vehicleGrades = $this->getModel('reservationVehicleGradeModel')
            ->get([$gradeTable.'.name'], true)
            ->joinSimple([$ticketTable, 'r'], $gradeTable . '.id', 'r.vehicle_grade','RIGHT')
            ->where($gradeTable.'.name', '', '!=')
            ->groupBy($gradeTable.'.name')
            ->orderBy($gradeTable.'.name', 'ASC')
            ->all();

        // Get sellers
        $sellers = $this->getModel('reservationTicketModel')
            ->get(['fs.title'], true)
            ->joinSimple([$flyTable, 'f'], $ticketTable . '.fly_code', 'f.id')
            ->joinSimple([$sellerTable, 'fs'], 'f.id', 'fs.fly_id', 'LEFT')
            ->where($ticketTable . '.is_del', 'no')
            ->where('f.is_del', 'no')
            ->where('fs.title', '', '!=')
            ->groupBy('fs.title')
            ->orderBy('fs.title', 'ASC')
            ->all();

        // Get fly codes
        $flyCodes = $this->getModel('reservationTicketModel')
            ->get(['f.fly_code'], true)
            ->joinSimple([$flyTable, 'f'], $ticketTable . '.fly_code', 'f.id')
            ->where($ticketTable . '.is_del', 'no')
            ->where('f.is_del', 'no')
            ->where('f.fly_code', '', '!=')
            ->groupBy('f.fly_code')
            ->orderBy('f.fly_code', 'ASC')
            ->all();

        // Extract simple arrays from the results
        $originNames = [];
        foreach ($origins as $origin) {
            if (isset($origin['name']) && !empty($origin['name'])) {
                $originNames[] = $origin['name'];
            }
        }

        $destinationNames = [];
        foreach ($destinations as $destination) {
            if (isset($destination['name']) && !empty($destination['name'])) {
                $destinationNames[] = $destination['name'];
            }
        }

        $vehicleGradeNames = [];
        foreach ($vehicleGrades as $grade) {
            if (isset($grade['name']) && !empty($grade['name'])) {
                $vehicleGradeNames[] = $grade['name'];
            }
        }

        $sellerNames = [];
        foreach ($sellers as $seller) {
            if (isset($seller['title']) && !empty($seller['title'])) {
                $sellerNames[] = $seller['title'];
            }
        }

        $flyCodeNames = [];
        foreach ($flyCodes as $flyCode) {
            if (isset($flyCode['fly_code']) && !empty($flyCode['fly_code'])) {
                $flyCodeNames[] = $flyCode['fly_code'];
            }
        }

        // Get current date in Shamsi format
        $currentDate = functions::ConvertToJalali(date('Y-m-d'), '');
        $currentDate = str_replace('-', '', $currentDate);
        $currentDate = implode('/', $currentDate);

        $tomorrowDate = functions::ConvertToJalali(date('Y-m-d', strtotime('+7 day')), '');
        $tomorrowDate = str_replace('-', '', $tomorrowDate);
        $tomorrowDate = implode('/', $tomorrowDate);

        return [
            'currentDate' => $currentDate,
            'tomorrowDate' => $tomorrowDate,
            'airlines' => $airlineOptions,
            'origins' => $originNames,
            'destinations' => $destinationNames,
            'vehicle_grades' => $vehicleGradeNames,
            'sellers' => $sellerNames,
            'fly_codes' => $flyCodeNames
        ];
    }

    /**
     * AJAX method to get filtered manifest results
     */
    public function getFilteredManifestResults($params)
    {
        try {
            $filters = isset($params['filters']) ? $params['filters'] : [];
            $results = $this->getManifestResults($filters);

            return [
                'status' => true,
                'data' => $results
            ];
        } catch (Exception $e) {
            functions::insertLog("Error in getFilteredManifestResults: " . $e->getMessage(), 'manifestError');
            return [
                'status' => false,
                'message' => 'خطا در دریافت نتایج فیلتر شده'
            ];
        }
    }

    /**
     * AJAX method to get filtered manifest table HTML
     */
    public function getFilteredManifestTable($params)
    {
        try {
            $filters = isset($params['filters']) ? $params['filters'] : [];
            $manifestData = $this->getManifestResults($filters);


            // Generate table HTML
            $tableHtml = $this->generateManifestTableHtml($manifestData);

            return [
                'status' => true,
                'data' => $tableHtml
            ];
        } catch (Exception $e) {
            functions::insertLog("Error in getFilteredManifestTable: " . $e->getMessage(), 'manifestError');
            return [
                'status' => false,
                'message' => 'خطا در دریافت جدول فیلتر شده'
            ];
        }
    }

    /**
     * AJAX method to get paginated manifest table HTML
     */
    public function getPaginatedManifestTable($params)
    {
        try {
            $filters = isset($params['filters']) ? $params['filters'] : [];
            // Get paginated data
            $manifestResult = $this->getFlightTicketResults($filters);
            $manifestData = $manifestResult['data'];
            $pagination = $manifestResult['pagination'];
            if(isset($filters['OutForExcelManifest']) && $filters['OutForExcelManifest']=='Yes'){
                $this->OutForExcelManifest='Yes';
            }
            else if(isset($filters['OutForPrintManifest']) && $filters['OutForPrintManifest']=='Yes'){
                $this->OutForPrintManifest='Yes';
            }

            // Generate table HTML
            $tableHtml = $this->generateManifestTableHtml($manifestData);


            if($this->OutForExcelManifest=='Yes') {//khorojo baraye report bashad
                $result = $this->CreateExcelManifest();
                // بررسی اینکه آیا ساخت اکسل موفق بوده یا نه
                if (strpos($result, 'success') !== false) {
                    return [
                        'status' => 'success',
                        'data' => $result
                    ];
                } else {
                    return [
                        'status' => 'error',
                        'message' => $result
                    ];
                }
            }
            else if ($this->OutForPrintManifest== 'Yes') {
                return [
                    'status' => true,
                    'data' => [
                        'table_html' => $tableHtml,
                    ]
                ];
            }
            else{
                return [
                    'status' => true,
                    'data' => [
                        'table_html' => $tableHtml,
                        'pagination_html' => $paginationHtml
                    ]
                ];

            }
        } catch (Exception $e) {
            functions::insertLog("Error in getPaginatedManifestTable: " . $e->getMessage(), 'manifestError');
            return [
                'status' => false,
                'message' => 'خطا در دریافت جدول صفحه‌بندی شده'
            ];
        }
    }


    /**
     * Generate manifest table HTML
     */
    private function generateManifestTableHtml($manifestData)
    {
        if (!$manifestData) {
            return '<div class="empty-state">
                        <div class="empty-content">
                            <i class="fa fa-plane-slash"></i>
                            <h3>هیچ پروازی یافت نشد</h3>
                            <p>هیچ پرواز یا بلیطی در سیستم رزرواسیون یافت نشد.</p>
                            <button class="btn-primary" onclick="refreshData()">
                                <i class="fa fa-refresh"></i>
                                بروز رسانی
                            </button>
                        </div>
                    </div>';
        }

        /*
         * <th style="text-align: center !important;">
                                <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                            </th>
        */
        $html = '<div class="table-wrapper">
                   <table id="flightsTable" class="display">
                        <thead>
                        <tr>
                            <th style="text-align: right !important;">ردیف</th>
                            <th style="text-align: right !important;">فروشنده</th>
                            <th style="text-align: right !important;">ایرلاین</th>
                            <th style="text-align: right !important;">پرواز</th>
                            <th style="text-align: right !important;">کلاس</th>
                            <th style="text-align: right !important;">روز</th>
                            <th style="text-align: right !important;">تاریخ</th>
                            <th style="text-align: right !important;">مبدا</th>
                            <th style="text-align: right !important;">مقصد</th>
                            <th style="text-align: right !important;">حرکت</th>
                            <th style="text-align: right !important;">فرود</th>
                            <th style="text-align: right !important;">وضعیت</th>
                            <th style="text-align: right !important;">مانیفست</th>
                            <th style="text-align: right !important;">خرید</th>
                            <th style="text-align: right !important;">واگذار</th>
                            <th style="text-align: right !important;">مانده</th>
                            <th style="text-align: right !important;">رزرو</th>
                            <th style="text-align: right !important;">مانده کل</th>
                            <th style="text-align: right !important;">  عملیات</th>
                        </tr>
                        </thead>
                        <tbody>';
       //list code moghim agancy
        $agencies = $this->getController('agency')->getAgencies();
        foreach ($agencies as $agency) {
            $this->AllagenciesMap[$agency['id']] = $agency['name_fa'];
        }

        $rowIndex = 0;
        $rows = []; // جمع‌آوری همه ردیف‌ها در آرایه
        foreach ($manifestData as $dateData) {
            if (isset($dateData) && $dateData['routes']) {
                foreach ($dateData['routes'] as $routeData) {
                    foreach ($routeData['flights'] as $flightData) {
                        $rowIndex++;
                        $rows[] = $this->generateFlightRowHtml($flightData, $routeData, $dateData['date'], $rowIndex,$agencies);
                    }
                }
            }
        }
        $html .= implode('', $rows);
        $html .= '</tbody></table></div>';
        return $html;
    }

    /**
     * Generate pagination HTML
     */
    private function generatePaginationHtml($pagination)
    {
        if (!$pagination || $pagination['total_pages'] <= 1) {
            return '';
        }

        $html = '<div class="pagination-container">
                    <div class="pagination-info">
                        <span class="pagination-text">
                            نمایش ' . $pagination['per_page'] . ' رکورد از ' . $pagination['total_count'] . ' رکورد
                        </span>
                    </div>
                    <div class="pagination-controls">
                        <div class="pagination-buttons">';

        // Previous button
        if ($pagination['has_prev']) {
            $html .= '<button class="btn-pagination" onclick="changePage(' . ($pagination['current_page'] - 1) . ')" title="صفحه قبلی">
                        <i class="fa fa-chevron-right"></i>
                        قبلی
                    </button>';
        }

        // Page numbers
        $startPage = 1;
        $endPage = $pagination['total_pages'];

        if ($pagination['total_pages'] > 10) {
            if ($pagination['current_page'] <= 5) {
                $startPage = 1;
                $endPage = 10;
            } elseif ($pagination['current_page'] >= $pagination['total_pages'] - 4) {
                $startPage = $pagination['total_pages'] - 9;
                $endPage = $pagination['total_pages'];
            } else {
                $startPage = $pagination['current_page'] - 4;
                $endPage = $pagination['current_page'] + 5;
            }
        }

        // First page and ellipsis
        if ($startPage > 1) {
            $html .= '<button class="btn-pagination" onclick="changePage(1)">1</button>';
            if ($startPage > 2) {
                $html .= '<span class="pagination-ellipsis">...</span>';
            }
        }

        // Page numbers
        for ($page = $startPage; $page <= $endPage; $page++) {
            $activeClass = ($page == $pagination['current_page']) ? 'active' : '';
            $html .= '<button class="btn-pagination ' . $activeClass . '" onclick="changePage(' . $page . ')">' . $page . '</button>';
        }

        // Last page and ellipsis
        if ($endPage < $pagination['total_pages']) {
            if ($endPage < $pagination['total_pages'] - 1) {
                $html .= '<span class="pagination-ellipsis">...</span>';
            }
            $html .= '<button class="btn-pagination" onclick="changePage(' . $pagination['total_pages'] . ')">' . $pagination['total_pages'] . '</button>';
        }

        // Next button
        if ($pagination['has_next']) {
            $html .= '<button class="btn-pagination" onclick="changePage(' . ($pagination['current_page'] + 1) . ')" title="صفحه بعدی">
                        بعدی
                        <i class="fa fa-chevron-left"></i>
                    </button>';
        }

        $html .= '</div>
                    <div class="pagination-per-page">
                        <label for="perPageSelect">نمایش:</label>
                        <select id="perPageSelect" onchange="changePerPage(this.value)">';

        $perPageOptions = [10, 20, 50, 100];
        foreach ($perPageOptions as $option) {
            $selected = ($option == $pagination['per_page']) ? 'selected' : '';
            $html .= '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
        }

        $html .= '</select>
                        <span>رکورد در هر صفحه</span>
                    </div>
                </div>
            </div>';

        return $html;
    }

    /**
     * Generate flight row HTML
     */
    private function generateFlightRowHtml($flightData, $routeData, $date, $rowIndex,$agencies)
    {
        // تبدیل شمسی به میلادی
        $jy = substr($date, 0, 4);
        $jm = substr($date, 4, 2);
        $jd = substr($date, 6, 2);
        $DateMiladi = dateTimeSetting::jalali_to_gregorian($jy, $jm, $jd, '-');
        // محاسبه روز هفته
        $stringWeek =dateTimeSetting::jdate('l', strtotime($DateMiladi));

        $routeParts = explode('-', $routeData['route_name']);
        $origin = isset($routeParts[0]) ? trim($routeParts[0]) : '';
        $destination = isset($routeParts[1]) ? trim($routeParts[1]) : '';

        $ticketArr = isset($flightData['tickets'][0]['ticket']) ? $flightData['tickets'][0]['ticket'] : [];
        // Seller data
        $sellerHtml = '<span class="no-data">-</span>';
        if (isset($ticketArr['seller_idNow']) && isset($this->AllagenciesMap[$ticketArr['seller_idNow']])) {
           $sellerHtml = '<span>' . $this->AllagenciesMap[$ticketArr['seller_idNow']] . '</span>';
        }

        // Aircraft type (airline abbreviation)
        $aircraftType = '';
        if (isset($routeData['airline_abbreviation']) && $routeData['airline_abbreviation']) {
            $aircraftType = $routeData['airline_abbreviation'];
        } elseif (isset($flightData['tickets'][0]['airline_abbreviation']) && $flightData['tickets'][0]['airline_abbreviation']) {
            $aircraftType = $flightData['tickets'][0]['airline_abbreviation'];
        } else {
            $aircraftType = '<span class="no-data">-</span>';
        }

        // Flight number
        $flightNumber = '<strong>' . (isset($flightData['flight']['fly_code']) ?$flightData['flight']['fly_code']: '') . '</strong>';

        // Flight class
        $flightClass = '';
        if (isset($routeData['vehicle_grade']) && $routeData['vehicle_grade']) {
            $flightClass = '<span class="flight-class-badge">' . $routeData['vehicle_grade'] . '</span>';
        } elseif (isset($flightData['flight']['vehicle_grade_name']) && $flightData['flight']['vehicle_grade_name']) {
            $flightClass = '<span class="flight-class-badge">' . $flightData['flight']['vehicle_grade_name'] . '</span>';
        } else {
            $flightClass = '<span class="no-data">-</span>';
        }

        // Origin and destination
        $originHtml = $origin ?: '<span class="no-data">-</span>';
        $destinationHtml = $destination ?: '<span class="no-data">-</span>';

        // Departure time
        $departureTime = '';
        if (isset($ticketArr['start_time']) && $ticketArr['start_time']) {
            $departureTime = '<span class="time-badge departure">' . $ticketArr['start_time'] . '</span>';
        } else {
            $departureTime = '<span class="no-data">-</span>';
        }

        // Arrival time
        $arrivalTime = '';
        if (isset($ticketArr['finish_time']) && $ticketArr['finish_time']) {
            $arrivalTime = '<span class="time-badge arrival">' . $ticketArr['finish_time'] . '</span>';
        } else {
            $arrivalTime = '<span class="no-data">-</span>';
        }

        // Capacity calculations
        $totalCapacity = isset($ticketArr['fly_total_capacity']) ? $ticketArr['fly_total_capacity'] : 0;
        $allocatedCapacity = isset($ticketArr['total_manifest_capacity']) ? $ticketArr['total_manifest_capacity'] : 0;
        
        $manifestCount = isset($ticketArr['manifest_records_count']) ? $ticketArr['manifest_records_count'] : 0;
        $bookCount = isset($ticketArr['book_records_count']) ? $ticketArr['book_records_count'] : 0;
        $reservedCapacity = $manifestCount + $bookCount;
        $remainingCapacity = $totalCapacity - $reservedCapacity;

        // Capacity HTML
        $totalCapacityHtml = $totalCapacity ? '<span class="capacity-number">' . $totalCapacity . '</span>' : '<span class="no-data">-</span>';
        $allocatedCapacityHtml = $allocatedCapacity ? '<span class="capacity-number allocated">' . $allocatedCapacity . '</span>' : '<span class="no-data">-</span>';
        $reservedCapacityHtml = $totalCapacity ? '<span class="capacity-number reserved">' . $reservedCapacity . '</span>' : '<span class="no-data">-</span>';
        $remainingCapacityHtml = $totalCapacity ? '<span class="capacity-number remaining' . ($remainingCapacity == 0 ? ' warning' : '') . '">' . $remainingCapacity . '</span>' : '<span class="no-data">-</span>';
        $capacity_remaining=$totalCapacity - $allocatedCapacity;

        // Actions
        $ticketId = isset($ticketArr['ticket_id']) ? $ticketArr['ticket_id'] : '';
        $sellerPrice = isset($ticketArr['seller_priceNow']) ? number_format($ticketArr['seller_priceNow'], 0, ',', ',') : '0';
        
        $actionsHtml = '<div class="btn-group m-r-10">
                            <button aria-expanded="true" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light btn-xs" type="button"> عملیات <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu dropdown-menu-left animated flipInY py-1 px-0">';
        
            $actionsHtml .= '<li class="li-list-operator">
                                <a onclick="showSellerDetails(\'' . $flightData['flight']['fly_code'] . '\', \'' . $sellerTitle . '\', \'' . $sellerPrice . '\',\'' . $ticketId . '\',\'' . $capacity_remaining. '\')">
                                    <i class="fcbtn btn btn-outline btn-success btn-1e fa fa-money tooltip-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="سیت چارترها"></i>
                                </a>
                            </li>';

        $actionsHtml .= '<li class="li-list-operator">
                            <a onclick="showFlightDetails(\'' . $ticketId . '\')">
                                <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="جزئیات مانیفست"></i>
                            </a>
                        </li>
                        <li class="li-list-operator">
                            <a onclick="ShowStatusManifest(\'' . $ticketId . '\')">
                                <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-list-alt"
                                   data-toggle="tooltip" data-placement="top"
                                   data-original-title="وضعیت مانیفست"></i>
                            </a>
                        </li>
                    </ul>
                </div>';

        /*
         <li class="li-list-operator">
                            <a onclick="showFlightStatus(\'' . $ticketId . '\')">
                                <i class="fcbtn btn btn-outline btn-warning btn-1c tooltip-warning fa fa-plane"
                                   data-toggle="tooltip" data-placement="top"
                                   data-original-title="وضعیت پرواز"></i>
                            </a>
                        </li>
                        <li class="li-list-operator">
                            <a onclick="ShowTotalFlightCapacity(\'' . $ticketId . '\')">
                                <i class="fcbtn btn btn-outline btn-danger btn-1c tooltip-danger fa fa-users"
                                   data-toggle="tooltip" data-placement="top"
                                   data-original-title="سهمیه کل پرواز"></i>
                            </a>
                        </li>
                        <li class="li-list-operator">
                            <a onclick="EditFlightSchedule(\'' . $ticketId . '\')">
                                <i class="fcbtn btn btn-outline btn-success btn-1e tooltip-success fa fa-edit"
                                   data-toggle="tooltip" data-placement="top"
                                   data-original-title="ویرایش برنامه پروازی"></i>
                            </a>
                        </li>
         */
        $statusHtml = '<span class="no-data">-</span>';
        if (isset($ticketArr['status'])) {
            $status = $ticketArr['status'];
            if ($status === "Cancelled") {
                $statusHtml = '<span class="status-cancelled" title="کنسلی">C</span>';
            } elseif ($status === "Blocked") {
                $statusHtml = '<span class="status-blocked" title="مسدودی">&#10006;</span>';
            } elseif ($status === "Actived") {
                $statusHtml = '<span class="status-actived" title="فعال">&#10004;</span>';
            } else {
                $statusHtml = '<span class="status-none" title="بدون وضعیت">-</span>';
            }
        }

        $statusManifestHtml = '<span class="no-data">-</span>';
        if (isset($ticketArr['status_manifest']) && $ticketArr['status_manifest']==='1') {
            $statusManifestHtml = '<span class="status-actived" title="ارسال مانیفست">&#10004;</span>';
        }


        if($this->OutForExcelManifest=='Yes') {
            // جمع‌آوری داده‌های نهایی برای اکسل
            $ticket = $ticketArr;

            $totalCapacity = isset($ticket['fly_total_capacity']) ? $ticket['fly_total_capacity'] : 0;
            $allocatedCapacity = isset($ticket['total_manifest_capacity']) ? $ticket['total_manifest_capacity'] : 0;
            $manifestCount = isset($ticket['manifest_records_count']) ? $ticket['manifest_records_count'] : 0;
            $bookCount = isset($ticket['book_records_count']) ? $ticket['book_records_count'] : 0;
            $reservedCapacity = $manifestCount + $bookCount;
            $remainingCapacity = $totalCapacity - $reservedCapacity;
            $capacity_remaining = $totalCapacity - $allocatedCapacity;

            // اطلاعات برای اکسل
            $excelRow = [
                'number_column'         => $rowIndex,
                'seller_display'        => isset($sellerTitle) ? $sellerTitle : (isset($ticket['seller_idNow']) ? $ticket['seller_idNow'] : '-'),
                'airline'               => isset($aircraftType) ? strip_tags($aircraftType) : '-',
                'fly_code'              => isset($flightData['flight']['fly_code']) ? $flightData['flight']['fly_code'] : '-',
                'class'                 => isset($flightClass) ? strip_tags($flightClass) : '-',
                'stringWeek'            => $stringWeek,
                'date'                  => $date,
                'origin_city_name'      => $origin,
                'destination_city_name' => $destination,
                'exit_hour'             => (isset($ticket['start_time']) ? $ticket['start_time'] : '-') . ' / ' . (isset($ticket['finish_time']) ? $ticket['finish_time'] : '-'),
                'status'                => isset($ticket['status']) ? $ticket['status'] : '-',
                'manifest_count'        => $manifestCount,
                'book_count'            => $bookCount,
                'assign_capacity'       => $allocatedCapacity,
                'remain_capacity'       => $remainingCapacity,
                'reserve_capacity'      => $reservedCapacity,
                'total_capacity'        => $totalCapacity,
            ];
            // اضافه کردن به آرایه اکسل
            $this->DataExcelManifest[] = $excelRow;

        }
        else{
            /*
             <td style="text-align: right !important;">
                            <input type="checkbox"
                                    class="row-checkbox"
                                    name="flight_checkbox[]"
                                    id="flight_checkbox_' . $ticketId . '"
                                    value="' . $ticketId . '">
                        </td>
             */

            $html = '<tr class="flight-row" data-flight-id="' . $flightData['flight']['fly_code'] . '" data-date="' . $date . '">
                        <td class="rowIndex" style="text-align: right !important;">' . $rowIndex . '</td>
                        <td class="seller" style="text-align: right !important;">' . $sellerHtml . '</td>
                        <td class="aircraft-type" style="text-align: right !important;">' . $aircraftType . '</td>
                        <td class="flight-number" style="text-align: right !important;">' . $flightNumber . '</td>
                        <td class="flight-class" style="text-align: right !important;">' . $flightClass . '</td>
                        <td class="day-of-week" style="text-align: right !important;">' . $stringWeek . '</td>
                        <td class="flight-date" style="text-align: right !important;">' . substr($date, 0, 4) . '/' . substr($date, 4, 2) . '/' . substr($date, 6, 2) . '</td>
                        <td class="origin" style="text-align: right !important;">' . $originHtml . '</td>
                        <td class="destination" style="text-align: right !important;">' . $destinationHtml . '</td>
                        <td class="departure-time" style="text-align: right !important;">' . $departureTime . '</td>
                        <td class="arrival-time" style="text-align: right !important;">' . $arrivalTime . '</td>
                        <td class="ticket-status" style="text-align: right !important;">' . $statusHtml . '</td>
                        <td class="ticket-manifest" style="text-align: right !important;">' . $statusManifestHtml . '</td>
                        <td class="capacity-total" style="text-align: right !important;">' . $totalCapacityHtml . '</td>
                        <td class="capacity-allocated" style="text-align: right !important;">' . $allocatedCapacityHtml . '</td>
                        <td class="capacity-remaining" style="text-align: right !important;">' . $capacity_remaining . '</td>
                        <td class="capacity-reserved" style="text-align: right !important;">' . $reservedCapacityHtml . '</td>
                        <td class="capacity-remaining-total" style="text-align: right !important;">' . $remainingCapacityHtml . '</td>
                        <td class="actions" style="text-align: right !important;">' . $actionsHtml . '</td>
                    </tr>';
            return $html;
        }


    }

    public function getPaginatedManifestResults($filters = [])
    {
        return $this->getFlightTicketResults($filters);
    }

    public function getManifestStatistics()
    {
        try {
            // Get table names
            $flyTable = $this->getModel('reservationFlyModel')->getTable();
            $ticketTable = $this->getModel('reservationTicketModel')->getTable();
            $bookLocalTable = $this->getModel('bookLocalModel')->getTable();

            // Get current date in Shamsi format
            $currentDate = functions::ConvertToJalali(date('Y-m-d'), '');
            $currentDate = str_replace('-', '', $currentDate);
            $currentDate = implode('/', $currentDate);

            // Get flight statistics
            $flightStats = $this->getModel('reservationFlyModel')
                ->get([
                    'COUNT(DISTINCT ' . $flyTable . '.id) as total_flights'
                ], true)
                ->joinSimple(
                    [$ticketTable, 't'],
                    $flyTable . '.id',
                    't.fly_code'
                )
                ->where($flyTable . '.is_del', 'no')
                ->where('t.is_del', 'no')
                ->where('t.date', $currentDate, '>=')
                ->all(false);

            // Get ticket statistics
            $ticketStats = $this->getModel('reservationTicketModel')
                ->get([
                    'COUNT(DISTINCT t.id) as total_tickets',
                    'SUM(t.fly_total_capacity) as total_capacity',
                    'SUM(t.fly_full_capacity) as total_booked',
                    'SUM(t.remaining_capacity) as total_remaining'
                ], true)
                ->joinSimple(
                    [$ticketTable, 't'],
                    't.fly_code',
                    $flyTable . '.id'
                )
                ->joinSimple(
                    [$flyTable, 'f'],
                    'f.id',
                    't.fly_code'
                )
                ->where('f.is_del', 'no')
                ->where('t.is_del', 'no')
                ->where('t.date', $currentDate, '>=')
                ->all(false);

            // Get passenger statistics from both sources
            $bookPassengerStats = $this->getModel('bookLocalModel')
                ->get([
                    'COUNT(DISTINCT id) as total_book_passengers'
                ])
                ->where('del', 'no')
                ->whereIn('successfull', ['book', 'private_reserve'])
                ->all(false);

            $manifestPassengerStats = $this->getModel('manifestUploadsModel')
                ->get([
                    'COUNT(DISTINCT id) as total_manifest_passengers'
                ])
                ->all(false);


            return [
                'total_flights' => isset($flightStats[0]['total_flights']) ? (int)$flightStats[0]['total_flights'] : 0,
                'total_tickets' => isset($ticketStats[0]['total_tickets']) ? (int)$ticketStats[0]['total_tickets'] : 0,
                'total_capacity' => isset($ticketStats[0]['total_capacity']) ? (int)$ticketStats[0]['total_capacity'] : 0,
                'total_booked' => isset($ticketStats[0]['total_booked']) ? (int)$ticketStats[0]['total_booked'] : 0,
                'total_remaining' => isset($ticketStats[0]['total_remaining']) ? (int)$ticketStats[0]['total_remaining'] : 0,
                'total_passengers' => (isset($bookPassengerStats[0]['total_book_passengers']) ? (int)$bookPassengerStats[0]['total_book_passengers'] : 0) +
                    (isset($manifestPassengerStats[0]['total_manifest_passengers']) ? (int)$manifestPassengerStats[0]['total_manifest_passengers'] : 0),
                'total_manifest_passengers' => isset($manifestPassengerStats[0]['total_manifest_passengers']) ? (int)$manifestPassengerStats[0]['total_manifest_passengers'] : 0,
                'total_book_passengers' => isset($bookPassengerStats[0]['total_book_passengers']) ? (int)$bookPassengerStats[0]['total_book_passengers'] : 0
            ];

        } catch (Exception $e) {
            functions::insertLog("Error in getManifestStatistics: " . $e->getMessage(), 'manifestError');
            return [
                'total_flights' => 0,
                'total_tickets' => 0,
                'total_capacity' => 0,
                'total_booked' => 0,
                'total_remaining' => 0,
                'total_passengers' => 0,
                'total_manifest_passengers' => 0,
                'total_book_passengers' => 0
            ];
        }
    }

    public function uploadManifest()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
            return;
        }


        // Get form inputs
        $manifestDate = trim($_POST['manifest_date']);
        $expectedRoute = strtoupper(trim($_POST['route']));
        $flightTicketId = trim($_POST['airline_iata']); // This now contains the flight ticket ID
        $file = $_FILES['manifest_file'];

        // Get flight information from the ticket ID
        $flightInfo = $this->getModel('reservationTicketModel')
            ->get([
                'id',
                'airline',
                'vehicle_grade',
                'fly_code',
                'date',
                'exit_hour',
                'destination_country'
            ])
            ->where('id', $flightTicketId)
            ->where('is_del', 'no')
            ->find(false);

        if (!$flightInfo) {
            echo json_encode([
                'success' => false,
                'message' => 'اطلاعات پرواز یافت نشد. لطفاً مجدداً تلاش کنید.'
            ]);
            return;
        }


        // Get airline information from airline_tb table (separate database)
        $airlineInfo = $this->getModel('airlineModel')
            ->get(['name_fa', 'name_en', 'abbreviation'])
            ->where('id', $flightInfo['airline'])
            ->where('del', 'no')
            ->find();

        $expectedAirlineIata = '';
        if ($airlineInfo) {
            $expectedAirlineIata = !empty($airlineInfo['abbreviation']) ? $airlineInfo['abbreviation'] : $flightInfo['airline'];
        } else {
            $expectedAirlineIata = $flightInfo['airline'];
        }

        $expectedVehicleGrade = $flightInfo['vehicle_grade'];
        $expectedFlightNumber = $flightInfo['fly_code'];

        // Validate inputs
        if (empty($manifestDate) || empty($expectedRoute) || empty($flightTicketId)) {
            echo json_encode([
                'success' => false,
                'message' => 'تمام فیلدهای فرم الزامی است. لطفاً تاریخ، مسیر و ایرلاین را وارد کنید.'
            ]);
            return;
        }

        // **NEW**: Time limitation validation for manifest upload
        $timeValidationResult = $this->validateUploadTime($flightInfo);
        if (!$timeValidationResult['allowed']) {
            echo json_encode([
                'success' => false,
                'message' => $timeValidationResult['message']
            ]);
            return;
        }

        // Get current agency information for validation
        $currentAgencyInfo = null;
        if (isset($_SESSION['AgencyId']) && !empty($_SESSION['AgencyId'])) {
            $agencyController = $this->getController('agency');
            $currentAgencyInfo = $agencyController->getAgency($_SESSION['AgencyId']);

            if (empty($currentAgencyInfo)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'خطا در شناسایی اطلاعات آژانس. لطفاً مجدداً وارد شوید.'
                ]);
                return;
            }
        }

        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            echo json_encode([
                'success' => false,
                'message' => 'آپلود فایل با خطا مواجه شد. لطفاً مجدداً تلاش کنید.'
            ]);
            return;
        }

        // Check file size (max 10MB)
        if ($file['size'] > 10 * 1024 * 1024) {
            echo json_encode([
                'success' => false,
                'message' => 'حجم فایل نباید از 10 مگابایت بیشتر باشد.'
            ]);
            return;
        }

        // Read and validate file content
        $fileContent = file_get_contents($file['tmp_name']);
        if (empty($fileContent)) {
            echo json_encode([
                'success' => false,
                'message' => 'فایل خالی است یا قابل خواندن نیست.'
            ]);
            return;
        }

        $lines = explode("\n", trim($fileContent));
        // ---- Validate manifest header ----
        $firstLine = trim($lines[0]);
        $secondLine = isset($lines[1]) ? trim($lines[1]) : '';

        $firstParts = explode(',', $firstLine);
        $secondParts = explode(',', $secondLine);

// Check that both lines have at least 2 columns
        if (count($firstParts) < 2 || count($secondParts) < 2) {
            echo json_encode([
                'success' => false,
                'message' => "ساختار فایل مانیفست معتبر نیست. حداقل دو ستون در خطوط اول و دوم مورد نیاز است."
            ]);
            return;
        }

        // Extract codes
        $code1 = trim($firstParts[0]);
        $code2 = trim($firstParts[1]);
        $codeFromPassengers = trim($secondParts[1]); // passenger airline code (column 2 in line 2)

        // Validate repetition and match
        if (strcasecmp($code1, $code2) !== 0) {
            echo json_encode([
                'success' => false,
                'message' => "خط اول فایل نامعتبر است؛ دو کد اول باید تکراری باشند (مثلاً GAP7,GAP7,)."
            ]);
            return;
        }

        if (strcasecmp($code1, $codeFromPassengers) !== 0) {
            echo json_encode([
                'success' => false,
                'message' => "کد اختصار خط اول با کد ستون دوم مسافران مطابقت ندارد."
            ]);
            return;
        }
        // Remove first line from passenger data
        array_shift($lines);

        if (empty($lines)) {
            echo json_encode([
                'success' => false,
                'message' => 'فایل هیچ داده‌ای ندارد.'
            ]);
            return;
        }


        // Initialize validation tracking
        $validationErrors = [];
        $validationWarnings = [];
        $manifestData = [];
        $lineNumber = 0;
        $foundRoutes = [];
        $foundAirlines = [];
        $foundDates = [];

        functions::insertLog(json_encode($lines, true), 'manifestUploadDebugLins2');

        // Process each line
        foreach ($lines as $line) {
            $lineNumber++;
            $line = trim($line);
            functions::insertLog("Lineeeeeee  '{$line}'", 'manifestUploadDebug');

            if (empty($line)) continue;

            try {
                // Parse TXT file using tab delimiter (adjust delimiter as needed)
                $data = explode(",", $line);

                // Debug: Log the raw line and parsed data
                functions::insertLog("Line {$lineNumber}: Raw line: '{$line}'", 'manifestUploadDebug');
                functions::insertLog("Line {$lineNumber}: Parsed TXT count: " . count($data) . ", Data: " . json_encode($data), 'manifestUploadDebug');


                // Extract and validate data
                $ticketNumber = trim($data[0]);
                $agencyCode = trim($data[1]);
                $passengerInfo = trim($data[2]);
                $passengerType = trim($data[3]);
                $fileAirlineIata = strtoupper(trim($data[4]));
                $flightNumber = trim($data[5]);
                $flightDate = trim($data[6]);
                $nationalId = trim($data[7]);
                $passportNumber = trim($data[8]);
                $gender = trim($data[9]);
                $phoneNumber = trim($data[10]);

                // Validate agency code against current agency's seat_charter_code
                if (!empty($currentAgencyInfo) && !empty($currentAgencyInfo['seat_charter_code'])) {
                    if ($agencyCode !== $currentAgencyInfo['seat_charter_code']) {
                        $validationErrors[] = "خط {$lineNumber}: کد آژانس در فایل ({$agencyCode}) با کد سیت چارتر آژانس شما ({$currentAgencyInfo['seat_charter_code']}) مطابقت ندارد";
                        continue;
                    }
                } elseif (!empty($currentAgencyInfo) && empty($currentAgencyInfo['seat_charter_code'])) {
                    $validationWarnings[] = "خط {$lineNumber}: کد سیت چارتر برای آژانس شما تعریف نشده است. لطفاً با مدیر سیستم تماس بگیرید";
                }

                // Debug: Log extracted flight date
                functions::insertLog("Line {$lineNumber}: Extracted flight date: '{$flightDate}'", 'manifestUploadDebug');

                // Date validation and conversion
                $dateParts = explode('/', $flightDate);

                // Debug: Show what the explode produced
                functions::insertLog("Line {$lineNumber}: Date parts count: " . count($dateParts) . ", Parts: " . print_r($dateParts, true), 'manifestUploadDebug');

                if (count($dateParts) !== 3) {
                    $validationErrors[] = "خط {$lineNumber}: فرمت تاریخ نادرست در فایل ({$flightDate}). فرمت مورد انتظار: YY/MM/DD";
                    continue;
                }

                $year = intval($dateParts[0]);
                $month = intval($dateParts[1]);
                $day = intval($dateParts[2]);

                // Debug: Show conversion to integers
                functions::insertLog("Line {$lineNumber}: String parts: '{$dateParts[0]}', '{$dateParts[1]}', '{$dateParts[2]}'", 'manifestUploadDebug');
                functions::insertLog("Line {$lineNumber}: Integer conversion: year={$year}, month={$month}, day={$day}", 'manifestUploadDebug');

                // Convert 2-digit year to 4-digit year
                if ($year < 100) {
                    $year += 1400;
                }

                // Debug: Log the parsed values
                functions::insertLog("Line {$lineNumber}: Original date: '{$flightDate}', Parsed: year={$year}, month={$month}, day={$day}", 'manifestUploadDebug');

                // Validate date parts
                if ($month < 1 || $month > 12 || $day < 1 || $day > 31) {
                    $validationErrors[] = "خط {$lineNumber}: مقادیر تاریخ نادرست ({$flightDate}) - سال: {$year}, ماه: {$month}, روز: {$day}";
                    continue;
                }

                $formattedFlightDate = sprintf('%04d/%02d/%02d', $year, $month, $day);
                $normalizedManifestDate = str_replace('-', '/', $manifestDate);

                // Debug: Log date comparison
                functions::insertLog("Line {$lineNumber}: Formatted flight date: '{$formattedFlightDate}', Expected manifest date: '{$normalizedManifestDate}'", 'manifestUploadDebug');

                // Track found values for validation
                $foundDates[$formattedFlightDate] = ($foundDates[$formattedFlightDate] ? $foundDates[$formattedFlightDate] : 0) + 1;
                $foundAirlines[$fileAirlineIata] = ($foundAirlines[$fileAirlineIata] ? $foundAirlines[$fileAirlineIata] : 0) + 1;

                // Date validation
                if ($formattedFlightDate !== $normalizedManifestDate) {
                    $validationErrors[] = "خط {$lineNumber}: تاریخ پرواز در فایل ({$formattedFlightDate}) با تاریخ انتخاب شده ({$normalizedManifestDate}) مطابقت ندارد";
                    continue;
                }

                // Airline IATA validation
                if ($fileAirlineIata !== $expectedAirlineIata) {
                    $validationErrors[] = "خط {$lineNumber}: کد ایرلاین در فایل ({$fileAirlineIata}) با کد انتخاب شده ({$expectedAirlineIata}) مطابقت ندارد";
                    continue;
                }

                // Extract passenger name parts
                $passengerNameParts = explode('/', $passengerInfo);
                if (count($passengerNameParts) < 1) {
                    $validationErrors[] = "خط {$lineNumber}: فرمت نام مسافر نادرست ({$passengerInfo})";
                    continue;
                }

                // Route validation - construct route from flight data
                // Note: We can't validate route directly from the file as it's not included
                // So we'll just use the expected route for now and add a warning
                if ($lineNumber === 1) {
                    $validationWarnings[] = "توجه: اطلاعات مسیر در فایل موجود نیست، مسیر انتخاب شده ({$expectedRoute}) برای تمام رکوردها اعمال می‌شود";
                }

                // Additional validations
                if (empty($ticketNumber)) {
                    $validationWarnings[] = "خط {$lineNumber}: شماره بلیت خالی است";
                }

                if (empty($nationalId) && empty($passportNumber)) {
                    $validationWarnings[] = "خط {$lineNumber}: کد ملی و شماره پاسپورت هر دو خالی است";
                }

                if (!in_array($passengerType, ['ADL', 'CHD', 'INF'])) {
                    $validationWarnings[] = "خط {$lineNumber}: نوع مسافر نامعتبر ({$passengerType})، مقادیر مجاز: ADL, CHD, INF";
                }

                // Add valid record to manifest data
                $manifestData[] = [
                    'ticket_number' => $ticketNumber,
                    'agency_id' => $currentAgencyInfo['id'],
                    'passenger_family' => $passengerNameParts[0],
                    'passenger_name' => isset($passengerNameParts[1]) ? $passengerNameParts[1] : '',
                    'passenger_type' => $passengerType,
//                        'airline_iata' => $fileAirlineIata,
//                        'flight_number' => $flightNumber,
//                        'flight_date' => $formattedFlightDate,
                    'national_id' => $nationalId,
                    'passport_number' => $passportNumber,
                    'gender' => $gender,
                    'phone_number' => $phoneNumber,
                    'flight_ticket_id' => $flightTicketId
                ];


            } catch (Exception $e) {
                $validationErrors[] = "خط {$lineNumber}: خطا در پردازش - " . $e->getMessage();
            }
        }

        // Check if we have any validation errors
        if (!empty($validationErrors)) {
            $errorMessage = "❌ خطا در پردازش فایل\n\n";

            // Show first few errors
            $errorMessage .= "🔍 مشکلات یافت شده:\n";
            $errorCount = min(count($validationErrors), 3);

            for ($i = 0; $i < $errorCount; $i++) {
                $errorMessage .= "• " . $validationErrors[$i] . "\n";
            }

            // If there are more errors, show count
            if (count($validationErrors) > 3) {
                $remaining = count($validationErrors) - 3;
                $errorMessage .= "• و {$remaining} خطای دیگر\n";
            }

            $errorMessage .= "\n💡 راهنمایی: لطفاً فایل را بررسی کرده و مجدداً آپلود کنید.";

            // Log detailed errors
            $this->logValidationErrors($file['name'], $validationErrors, $validationWarnings);

            echo json_encode([
                'success' => false,
                'message' => $errorMessage,
                'errors' => $validationErrors,
                'warnings' => $validationWarnings
            ]);
            return;
        }

        // Check if we have any data to process
        if (empty($manifestData)) {
            echo json_encode([
                'success' => false,
                'message' => 'هیچ رکورد معتبری در فایل یافت نشد.'
            ]);
            return;
        }

        // Check agency passenger limit and filter data accordingly
        $filteredManifestData = $manifestData;
        $agencyLimitMessage = '';

        if (!empty($currentAgencyInfo) && !empty($currentAgencyInfo['id'])) {
            $agencyLimitValidation = $this->validateAgencyPassengerLimit(
                $currentAgencyInfo['id'],
                $flightTicketId,
                $manifestDate,
                count($manifestData)
            );


            if (!$agencyLimitValidation['allowed']) {
                // Check if we can insert some records
                if ($agencyLimitValidation['can_insert_partial']) {
                    $filteredManifestData = array_slice($manifestData, 0, $agencyLimitValidation['can_insert_count']);
                    $agencyLimitMessage = $agencyLimitValidation['partial_message'];
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => $agencyLimitValidation['message']
                    ]);
                    return;
                }
            }
        }

        // Check for duplicates before insertion
        $duplicateValidation = $this->validateDuplicatePassengers($filteredManifestData, $expectedRoute, $flightTicketId, $manifestDate);

        // Configuration: Set to true to treat duplicates as warnings instead of errors
        $duplicatesAsWarnings = false; // Set to true if you want to allow duplicates with warnings

        // Filter out duplicate records from manifestData
        $duplicateLineNumbers = [];

        if (!empty($duplicateValidation['errors'])) {
            // Get the original duplicate detection results for accurate filtering
            $normalizedManifestDate = str_replace('-', '/', $manifestDate);
            $fileDuplicates = $this->checkFileDuplicates($manifestData);
            $ticketDuplicates = $this->checkTicketDuplicates($manifestData);

            $databaseDuplicates = $this->checkDatabaseDuplicates($manifestData, $flightTicketId);


            // Collect all line numbers that should be skipped
            $duplicateLineNumbers = [];

            // Add file duplicate line numbers
            foreach ($fileDuplicates as $duplicate) {
                $lineNumbers = explode(',', $duplicate['line_numbers']);
                foreach ($lineNumbers as $lineNum) {
                    $lineNum = trim($lineNum);
                    if (is_numeric($lineNum)) {
                        $duplicateLineNumbers[] = (int)$lineNum;
                    }
                }
            }

            // Add ticket duplicate line numbers
            foreach ($ticketDuplicates as $duplicate) {
                $lineNumbers = explode(',', $duplicate['line_numbers']);
                foreach ($lineNumbers as $lineNum) {
                    $lineNum = trim($lineNum);
                    if (is_numeric($lineNum)) {
                        $duplicateLineNumbers[] = (int)$lineNum;
                    }
                }
            }

            // Add database duplicate line numbers (all records that exist in database)
            foreach ($databaseDuplicates as $duplicate) {

                // Find the line number for this passenger in the manifest data
                foreach ($manifestData as $index => $record) {
                    $recordNationalId = trim($record['national_id']);
                    $recordName = trim($record['passenger_name']);
                    $recordFamily = trim($record['passenger_family']);
                    $recordTicket = trim($record['ticket_number']);

                    $isDuplicate = false;

                    // Check if this record matches the database duplicate
                    if (in_array('national_id', $duplicate['duplicate_types']) &&
                        !empty($duplicate['national_id']) &&
                        $recordNationalId === $duplicate['national_id']) {
                        $isDuplicate = true;
                    }

                    if (in_array('ticket', $duplicate['duplicate_types']) &&
                        !empty($duplicate['ticket_number']) &&
                        $recordTicket === $duplicate['ticket_number']) {
                        $isDuplicate = true;
                    }

                    if (in_array('name', $duplicate['duplicate_types']) &&
                        $recordName === $duplicate['passenger_name'] &&
                        $recordFamily === $duplicate['passenger_family']) {
                        $isDuplicate = true;
                    }

                    if ($isDuplicate) {
                        $duplicateLineNumbers[] = $index + 1; // Convert to 1-based line number
                    }
                }
            }

            // Remove duplicate records from manifestData
            if (!empty($duplicateLineNumbers)) {
                $duplicateLineNumbers = array_unique($duplicateLineNumbers); // Remove duplicates
                sort($duplicateLineNumbers); // Sort for easier debugging

                $filteredManifestData = [];
                foreach ($manifestData as $index => $record) {
                    $lineNumber = $index + 1; // Convert to 1-based line number
                    if (!in_array($lineNumber, $duplicateLineNumbers)) {
                        $filteredManifestData[] = $record;
                    }
                }
            }

            // Add duplicate errors as warnings for user information
            $validationWarnings = array_merge($validationWarnings, $duplicateValidation['errors']);

            // Log filtering information for debugging
            functions::insertLog("Duplicate filtering - Total records: " . count($manifestData) . ", Duplicate lines: " . implode(',', $duplicateLineNumbers) . ", Filtered records: " . count($filteredManifestData), 'manifestFiltering');
        }

        // Add duplicate warnings to validation warnings
        if (!empty($duplicateValidation['warnings'])) {
            $validationWarnings = array_merge($validationWarnings, $duplicateValidation['warnings']);
        }

        // Get duplicate statistics for logging
        $duplicateStats = $this->getDuplicateStatistics($manifestData, $duplicateValidation);

        // Log successful validation with duplicate statistics
        $this->logValidationSuccess($file['name'], count($filteredManifestData), count($validationWarnings), $duplicateStats);

        // Insert valid data into database (filtered data without duplicates)
        $model = $this->getModel('manifestUploadsModel');
        $insertedCount = 0;

        foreach ($filteredManifestData as $row) {
            try {
                $model->get()->insertWithBind($row);
                $insertedCount++;
            } catch (Exception $e) {
                $validationWarnings[] = "خطا در ذخیره رکورد: " . $e->getMessage();
            }
        }

        // Prepare user-friendly success response
        $successMessage = "✅ مانیفست با موفقیت آپلود شد\n\n";

        // Main summary
        $successMessage .= "📊 خلاصه:\n";
        $successMessage .= "• پردازش شده: " . $insertedCount . " مسافر\n";
        $successMessage .= "• کل فایل: " . count($manifestData) . " مسافر\n";

        // Agency limit info
        if (!empty($agencyLimitMessage)) {
            $successMessage .= "• محدودیت آژانس: " . (count($manifestData) - count($filteredManifestData)) . " مسافر رد شد\n";
        }

        // Duplicate info
        if (!empty($duplicateValidation['errors'])) {
            $skippedCount = count($manifestData) - count($filteredManifestData);
            $successMessage .= "• تکراری: " . $skippedCount . " مسافر\n";
        }

        $successMessage .= "\n";

        // Important notes (only show if there are issues)
        $hasImportantNotes = false;
        if (!empty($agencyLimitMessage) || !empty($duplicateValidation['errors'])) {
            $successMessage .= "📝 نکات مهم:\n";
            $hasImportantNotes = true;

            if (!empty($agencyLimitMessage)) {
                $successMessage .= "• " . str_replace("توجه: ", "", $agencyLimitMessage) . "\n";
            }

            if (!empty($duplicateValidation['errors'])) {
                $successMessage .= "• برخی مسافران قبلاً در سیستم ثبت شده‌اند\n";
            }
        }

        // Only show warnings if they're important
        $importantWarnings = [];
        foreach ($validationWarnings as $warning) {
            // Skip route warning as it's not critical
            if (strpos($warning, 'اطلاعات مسیر') === false) {
                $importantWarnings[] = $warning;
            }
        }

        if (!empty($importantWarnings)) {
            if (!$hasImportantNotes) {
                $successMessage .= "📝 نکات مهم:\n";
            }
            foreach ($importantWarnings as $warning) {
                $successMessage .= "• " . str_replace("توجه: ", "", $warning) . "\n";
            }
        }

        echo json_encode([
            'success' => true,
            'message' => $successMessage,
            'stats' => [
                'total_processed' => $insertedCount,
                'total_original' => count($manifestData),
                'skipped_duplicates' => count($manifestData) - count($filteredManifestData),
                'skipped_limit' => count($manifestData) - count($filteredManifestData),
                'warnings_count' => count($validationWarnings),
                'duplicate_errors' => count(isset($duplicateValidation['errors']) ? $duplicateValidation['errors'] : []),
                'duplicate_warnings' => count(isset($duplicateValidation['warnings']) ? $duplicateValidation['warnings'] : []),
                'file_name' => $file['name'],
                'file_size' => round($file['size'] / 1024, 1) . ' KB',
                'agency_limit_message' => $agencyLimitMessage
            ]
        ]);

    }

    /**
     * Log validation errors for debugging and audit purposes
     */
    private function logValidationErrors($fileName, $errors, $warnings)
    {
        $logMessage = "=== MANIFEST VALIDATION ERRORS ===\n";
        $logMessage .= "File: " . $fileName . "\n";
        $logMessage .= "Timestamp: " . date('Y-m-d H:i:s') . "\n";
        $logMessage .= "User: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'Unknown') . "\n\n";

        $logMessage .= "ERRORS (" . count($errors) . "):\n";
        foreach ($errors as $error) {
            $logMessage .= "• " . $error . "\n";
        }

        if (!empty($warnings)) {
            $logMessage .= "\nWARNINGS (" . count($warnings) . "):\n";
            foreach ($warnings as $warning) {
                $logMessage .= "• " . $warning . "\n";
            }
        }

        $logMessage .= "\n" . str_repeat("=", 50) . "\n\n";

        // Write to error log
        error_log($logMessage);

        // Also try to write to a specific manifest log file
        try {
            $logFile = __DIR__ . '/../logs/manifest_validation.log';
            file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
        } catch (Exception $e) {
            // If we can't write to the log file, just continue
        }
    }

    /**
     * Log successful validation for audit purposes
     */
    private function logValidationSuccess($fileName, $recordCount, $warningCount, $duplicateStats = null)
    {
        $logMessage = "=== MANIFEST UPLOAD SUCCESS ===\n";
        $logMessage .= "File: " . $fileName . "\n";
        $logMessage .= "Records processed: " . $recordCount . "\n";
        $logMessage .= "Warnings: " . $warningCount . "\n";

        if ($duplicateStats) {
            $logMessage .= "Duplicate Statistics:\n";
            $logMessage .= "  - Total passengers: " . $duplicateStats['total_passengers'] . "\n";
            $logMessage .= "  - Unique national IDs: " . $duplicateStats['unique_national_ids'] . "\n";
            $logMessage .= "  - Unique ticket numbers: " . $duplicateStats['unique_ticket_numbers'] . "\n";
            $logMessage .= "  - Unique names: " . $duplicateStats['unique_names'] . "\n";
            $logMessage .= "  - Duplicate errors: " . $duplicateStats['duplicate_errors'] . "\n";
            $logMessage .= "  - Duplicate warnings: " . $duplicateStats['duplicate_warnings'] . "\n";
        }

        $logMessage .= "Timestamp: " . date('Y-m-d H:i:s') . "\n";
        $logMessage .= "User: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'Unknown') . "\n";
        $logMessage .= str_repeat("=", 40) . "\n\n";

        try {
            $logFile = __DIR__ . '/../logs/manifest_success.log';
            file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
        } catch (Exception $e) {
            // If we can't write to the log file, just continue
        }
    }

    /**
     * Validate for duplicate passengers in manifest data
     * Checks both within the uploaded file and against existing database records
     *
     * @param array $manifestData Array of passenger data from uploaded file
     * @param string $expectedRoute Expected route for the flight
     * @param int $flightTicketId Flight ticket ID
     * @param string $manifestDate Expected flight date
     * @return array Array with 'errors' and 'warnings' keys
     */
    private function validateDuplicatePassengers($manifestData, $expectedRoute, $flightTicketId, $manifestDate)
    {
        $errors = [];
        $warnings = [];

        // Normalize the manifest date for comparison
        $normalizedManifestDate = str_replace('-', '/', $manifestDate);

        // Get all types of duplicates
        $fileDuplicates = $this->checkFileDuplicates($manifestData);
        $ticketDuplicates = $this->checkTicketDuplicates($manifestData);
        $databaseDuplicates = $this->checkDatabaseDuplicates($manifestData, $flightTicketId);
        // Create a consolidated duplicate map
        $consolidatedDuplicates = [];

        // Process file duplicates
        foreach ($fileDuplicates as $duplicate) {
            $key = strtolower($duplicate['passenger_name'] . '|' . $duplicate['passenger_family'] . '|' . $duplicate['national_id']);
            if (!isset($consolidatedDuplicates[$key])) {
                $consolidatedDuplicates[$key] = [
                    'passenger_name' => $duplicate['passenger_name'],
                    'passenger_family' => $duplicate['passenger_family'],
                    'national_id' => $duplicate['national_id'],
                    'ticket_number' => '',
                    'duplicate_types' => [],
                    'file_line_numbers' => $duplicate['line_numbers'],
                    'database_timestamp' => null,
                    'is_file_duplicate' => true,
                    'is_database_duplicate' => false
                ];
            } else {
                // Merge line numbers if same passenger appears multiple times
                $consolidatedDuplicates[$key]['file_line_numbers'] .= ', ' . $duplicate['line_numbers'];
            }
        }

        // Process ticket duplicates
        foreach ($ticketDuplicates as $duplicate) {
            $key = strtolower($duplicate['passenger_name'] . '|' . $duplicate['passenger_family'] . '|' . $duplicate['national_id']);
            if (!isset($consolidatedDuplicates[$key])) {
                $consolidatedDuplicates[$key] = [
                    'passenger_name' => $duplicate['passenger_name'],
                    'passenger_family' => $duplicate['passenger_family'],
                    'national_id' => $duplicate['national_id'],
                    'ticket_number' => $duplicate['ticket_number'],
                    'duplicate_types' => ['ticket'],
                    'file_line_numbers' => $duplicate['line_numbers'],
                    'database_timestamp' => null,
                    'is_file_duplicate' => true,
                    'is_database_duplicate' => false
                ];
            } else {
                $consolidatedDuplicates[$key]['ticket_number'] = $duplicate['ticket_number'];
                $consolidatedDuplicates[$key]['duplicate_types'][] = 'ticket';
                $consolidatedDuplicates[$key]['file_line_numbers'] .= ', ' . $duplicate['line_numbers'];
            }
        }

        // Process database duplicates
        foreach ($databaseDuplicates as $duplicate) {
            $key = strtolower($duplicate['passenger_name'] . '|' . $duplicate['passenger_family'] . '|' . $duplicate['national_id']);
            if (!isset($consolidatedDuplicates[$key])) {
                $consolidatedDuplicates[$key] = [
                    'passenger_name' => $duplicate['passenger_name'],
                    'passenger_family' => $duplicate['passenger_family'],
                    'national_id' => $duplicate['national_id'],
                    'ticket_number' => isset($duplicate['ticket_number']) ? $duplicate['ticket_number'] : '',
                    'duplicate_types' => $duplicate['duplicate_types'],
                    'file_line_numbers' => '',
                    'database_timestamp' => $duplicate['upload_timestamp'],
                    'is_file_duplicate' => false,
                    'is_database_duplicate' => true
                ];
            } else {
                // Merge database duplicate types
                $consolidatedDuplicates[$key]['duplicate_types'] = array_merge(
                    $consolidatedDuplicates[$key]['duplicate_types'],
                    $duplicate['duplicate_types']
                );
                $consolidatedDuplicates[$key]['is_database_duplicate'] = true;
                if (!$consolidatedDuplicates[$key]['database_timestamp']) {
                    $consolidatedDuplicates[$key]['database_timestamp'] = $duplicate['upload_timestamp'];
                }
            }
        }

        // Generate consolidated error messages
        foreach ($consolidatedDuplicates as $duplicate) {
            $errorParts = [];

            // Add file duplicate information
            if ($duplicate['is_file_duplicate'] && !empty($duplicate['file_line_numbers'])) {
                $errorParts[] = "تکراری در فایل (خطوط: {$duplicate['file_line_numbers']})";
            }

            // Add database duplicate information
            if ($duplicate['is_database_duplicate']) {
                $duplicateTypes = [];
                foreach ($duplicate['duplicate_types'] as $type) {
                    switch ($type) {
                        case 'national_id':
                            $duplicateTypes[] = "کد ملی ({$duplicate['national_id']})";
                            break;
                        case 'ticket':
                            $duplicateTypes[] = "شماره بلیت ({$duplicate['ticket_number']})";
                            break;
                        // Note: Removed 'name' case as name-based duplicate checking is disabled
                    }
                }
                if (!empty($duplicateTypes)) {
                    $duplicateTypesText = implode('، ', $duplicateTypes);
                    $errorParts[] = "قبلاً در سیستم ثبت شده ({$duplicateTypesText}) - تاریخ آپلود: {$duplicate['database_timestamp']}";
                }
            }

            // Create consolidated error message
            $errorMessage = "مسافر {$duplicate['passenger_name']} {$duplicate['passenger_family']}: " . implode('، ', $errorParts);
            $errors[] = $errorMessage;
        }

        // Note: Removed potential duplicate check for names as multiple passengers can have the same name
        // Only checking for actual duplicates (national ID and ticket number)

        return [
            'errors' => $errors,
            'warnings' => $warnings
        ];
    }

    /**
     * Check for duplicate passengers within the uploaded file
     *
     * @param array $manifestData Array of passenger data
     * @return array Array of duplicate records
     */
    private function checkFileDuplicates($manifestData)
    {
        $duplicates = [];
        $passengerMap = [];

        foreach ($manifestData as $index => $passenger) {
            // Create unique key based on national ID and name
            $nationalId = trim($passenger['national_id']);
            $passengerName = trim($passenger['passenger_name']);
            $passengerFamily = trim($passenger['passenger_family']);

            // Skip if no national ID (will be checked separately)
            if (empty($nationalId)) {
                continue;
            }

            $key = strtolower($nationalId . '|' . $passengerName . '|' . $passengerFamily);

            if (isset($passengerMap[$key])) {
                // Found duplicate
                $existingIndex = $passengerMap[$key]['index'];
                $lineNumber = $index + 1;
                $existingLineNumber = $existingIndex + 1;

                $duplicates[] = [
                    'passenger_name' => $passengerName,
                    'passenger_family' => $passengerFamily,
                    'national_id' => $nationalId,
                    'line_numbers' => "{$existingLineNumber}, {$lineNumber}"
                ];
            } else {
                $passengerMap[$key] = [
                    'index' => $index,
                    'passenger' => $passenger
                ];
            }
        }

        return $duplicates;
    }

    /**
     * Check for duplicate passengers against existing database records
     *
     * @param array $manifestData Array of passenger data
     * @param int $flightTicketId Flight ticket ID
     * @return array Array of duplicate records
     */
    private function checkDatabaseDuplicates($manifestData, $flightTicketId)
    {
        $duplicates = [];
        $model = $this->getModel('manifestUploadsModel');

        // Get flight information from the ticket ID
        $flightInfo = $this->getModel('reservationTicketModel')
            ->get(['airline', 'fly_code'])
            ->where('id', $flightTicketId)
            ->where('is_del', 'no')
            ->find(false);
        if (!$flightInfo) {
            return $duplicates;
        }

        foreach ($manifestData as $passenger) {
            $nationalId = trim($passenger['national_id']);
            $passengerName = trim($passenger['passenger_name']);
            $passengerFamily = trim($passenger['passenger_family']);
            $ticketNumber = trim($passenger['ticket_number']);

            $duplicateInfo = [
                'passenger_name' => $passengerName,
                'passenger_family' => $passengerFamily,
                'duplicate_types' => [],
                'upload_timestamp' => null,
                'note' => ''
            ];

            $hasDuplicates = false;

            // Check for existing record with same national ID and flight details
            if (!empty($nationalId)) {
                $existingRecord = $model->get()
                    ->where('national_id', $nationalId)
                    ->where('flight_ticket_id', $flightTicketId)
                    ->find(false);

                if ($existingRecord) {
                    $duplicateInfo['duplicate_types'][] = 'national_id';
                    $duplicateInfo['national_id'] = $nationalId;
                    $duplicateInfo['upload_timestamp'] = $existingRecord['upload_timestamp'];
                    $hasDuplicates = true;
                }
            }

            // Check for existing record with same ticket number and flight details
            if (!empty($ticketNumber)) {
                $existingByTicket = $model->get()
                    ->where('ticket_number', $ticketNumber)
                    ->where('flight_ticket_id', $flightTicketId)
                    ->find(false);

                if ($existingByTicket) {
                    $duplicateInfo['duplicate_types'][] = 'ticket';
                    $duplicateInfo['ticket_number'] = $ticketNumber;
                    if (!$duplicateInfo['upload_timestamp']) {
                        $duplicateInfo['upload_timestamp'] = $existingByTicket['upload_timestamp'];
                    }
                    $hasDuplicates = true;
                }
            }

            // Note: Removed name validation as multiple passengers can have the same name on the same flight
            // Only checking national ID and ticket number duplicates

            // Only add to duplicates if this passenger has any duplicates
            if ($hasDuplicates) {
                $duplicates[] = $duplicateInfo;

            }
        }

        return $duplicates;
    }

    /**
     * Check for potential duplicates (same name but different national ID)
     *
     * @param array $manifestData Array of passenger data
     * @return array Array of potential duplicate records
     *
     * Note: This method is deprecated as multiple passengers can have the same name on the same flight
     * Only checking for actual duplicates (national ID and ticket number)
     */
    private function checkPotentialDuplicates($manifestData)
    {
        // Return empty array as name-based duplicate checking is disabled
        return [];
    }

    /**
     * Check for duplicate ticket numbers within the uploaded file
     *
     * @param array $manifestData Array of passenger data
     * @return array Array of duplicate ticket records
     */
    private function checkTicketDuplicates($manifestData)
    {
        $duplicates = [];
        $ticketMap = [];

        foreach ($manifestData as $index => $passenger) {
            $ticketNumber = trim($passenger['ticket_number']);

            // Skip if no ticket number
            if (empty($ticketNumber)) {
                continue;
            }

            $ticketKey = strtolower($ticketNumber);

            if (isset($ticketMap[$ticketKey])) {
                // Found duplicate ticket number
                $existingIndex = $ticketMap[$ticketKey]['index'];
                $lineNumber = $index + 1;
                $existingLineNumber = $existingIndex + 1;

                $duplicates[] = [
                    'ticket_number' => $ticketNumber,
                    'passenger_name' => $passenger['passenger_name'],
                    'passenger_family' => $passenger['passenger_family'],
                    'line_numbers' => "{$existingLineNumber}, {$lineNumber}",
                    'note' => 'شماره بلیت تکراری'
                ];
            } else {
                $ticketMap[$ticketKey] = [
                    'index' => $index,
                    'passenger' => $passenger
                ];
            }
        }

        return $duplicates;
    }

    /**
     * Get detailed duplicate statistics for logging and debugging
     *
     * @param array $manifestData Array of passenger data
     * @param array $duplicateValidation Result from validateDuplicatePassengers
     * @return array Detailed statistics
     */
    private function getDuplicateStatistics($manifestData, $duplicateValidation)
    {
        $stats = [
            'total_passengers' => count($manifestData),
            'unique_national_ids' => 0,
            'unique_ticket_numbers' => 0,
            'unique_names' => 0,
            'duplicate_errors' => count(isset($duplicateValidation['errors']) ? $duplicateValidation['errors'] : []),
            'duplicate_warnings' => count(isset($duplicateValidation['warnings']) ? $duplicateValidation['warnings'] : [])
        ];

        // Count unique identifiers
        $nationalIds = [];
        $ticketNumbers = [];
        $names = [];

        foreach ($manifestData as $passenger) {
            $nationalId = trim($passenger['national_id']);
            $ticketNumber = trim($passenger['ticket_number']);
            $name = strtolower(trim($passenger['passenger_name']) . '|' . trim($passenger['passenger_family']));

            if (!empty($nationalId)) {
                $nationalIds[$nationalId] = true;
            }
            if (!empty($ticketNumber)) {
                $ticketNumbers[$ticketNumber] = true;
            }
            if (!empty($name) && $name !== '|') {
                $names[$name] = true;
            }
        }

        $stats['unique_national_ids'] = count($nationalIds);
        $stats['unique_ticket_numbers'] = count($ticketNumbers);
        $stats['unique_names'] = count($names);

        return $stats;
    }

    public function findById($id)
    {
        return $this->getModel(manifestModel::class)
            ->get()
            ->where('source_id', $id)
            ->where('deleted_at', null, ' IS ')
            ->find(false);
    }

    /**
     * Toggle manifest status for a source
     * This method is called via ajax.php
     *
     * @param array $params Contains source_id
     * @return array Response with success status
     */
    public function toggleStatus($params)
    {
        if (isset($params['source_id'])) {
            $sourceId = $params['source_id'];

            // Check current status
            $current = $this->getModel(manifestModel::class)
                ->get()
                ->where('source_id', $sourceId)
                ->where('deleted_at', null, ' IS ')
                ->find(false);

            $status = empty($current) ? 1 : 0;

            $result = $this->toggleManifestStatus($sourceId, $status);

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Status updated successfully'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to update status'
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'Missing source_id parameter'
            ];
        }
    }

    /**
     * Handle AJAX request for saving manifest settings
     */
    public function saveSettings()
    {
        if (isset($_POST['data'])) {
            parse_str($_POST['data'], $data);

            $result = $this->getModel(manifestModel::class)->saveSettings($data);

            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Settings saved successfully'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to save settings'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Missing parameters'
            ]);
        }
    }

    public function toggleManifestStatus($sourceId, $status)
    {
        try {
            if ($status) {
                // Check if record exists but is soft deleted
                $existing = $this->getModel(manifestModel::class)
                    ->get()
                    ->where('source_id', $sourceId)
                    ->find(false);

                if ($existing) {
                    // Update existing record
                    return $this->getModel(manifestModel::class)
                        ->get()
                        ->updateWithBind([
                            'deleted_at' => null,
                            'updated_at' => date('Y-m-d H:i:s')
                        ], [
                            'source_id' => $sourceId
                        ]);
                }

                // Create new record
                return $this->getModel(manifestModel::class)
                    ->get()
                    ->insertWithBind([
                        'source_id' => $sourceId,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
            } else {
                // Soft delete the record
                return $this->getModel(manifestModel::class)
                    ->get()
                    ->updateWithBind([
                        'deleted_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ], [
                        'source_id' => $sourceId
                    ]);
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function getServices()
    {
        $services = $this->getAccessServiceClient();
        $list = [];
        foreach ($services as $service) {
            if ($service['MainService'] === 'Flight') {
                $list[$service['MainService']] = $service;
            }
        }
        return $list;
    }

    public function store($sourceId)
    {
        return $this->getModel(manifestModel::class)
            ->get()
            ->insertWithBind([
                'source_id' => $sourceId,
                'created_at' => date('Y-m-d H:i:s')
            ]);
    }

    /**
     * Get accessible flights for agency based on agency_lock_seat_tb
     * @param int $agencyId
     * @return array
     */
    public function getAgencyAccessibleFlights($agencyId)
    {
        try {
            // Get current date in Shamsi format (YYYYMMDD)
            $currentDate = functions::ConvertToJalali(date('Y-m-d'), '-');
            $currentDate = str_replace('-', '', $currentDate);

            // Get table names
            $agencyLockSeatTable = $this->getModel('agencyLockSeatModel')->getTable();
            $reservationTicketTable = $this->getModel('reservationTicketModel')->getTable();
            $originCityTable = $this->getModel('reservationCityModel')->getTable();
            $destinationCityTable = $this->getModel('reservationCityModel')->getTable();
            $reservationVehicleGradeTable = $this->getModel('reservationVehicleGradeModel')->getTable();

            // Define getters with table aliases
            $getters = [
                $reservationTicketTable . '.date',
                $reservationTicketTable . '.airline',
                $reservationTicketTable . '.vehicle_grade',
                $reservationTicketTable . '.origin_city',
                $reservationTicketTable . '.destination_city',
                $reservationVehicleGradeTable . '.name as vehicle_grade_name',
                $reservationVehicleGradeTable . '.abbreviation as vehicle_grade_abbr',
                "CONCAT(oc.name, '-', dc.name) as route_name",
                "CONCAT(oc.name, '-', dc.name) as route_code"
            ];

            $result = $this->getModel('reservationTicketModel')
                ->get($getters, true)
                ->joinSimple(
                    [$agencyLockSeatTable, 'a'],
                    $reservationTicketTable . '.id',
                    'a.ticket_id'
                )
                ->joinSimple(
                    [$originCityTable, 'oc'],
                    $reservationTicketTable . '.origin_city',
                    'oc.id',
                    'LEFT'
                )
                ->joinSimple(
                    [$destinationCityTable, 'dc'],
                    $reservationTicketTable . '.destination_city',
                    'dc.id',
                    'LEFT'
                )
                ->joinSimple(
                    [$reservationVehicleGradeTable, 'vg'],
                    $reservationTicketTable . '.vehicle_grade',
                    'vg.id',
                    'LEFT'
                )
                ->where('a.agency_id', $agencyId)
                ->where($reservationTicketTable . '.date', $currentDate, '>=')
                ->where('a.count_agency', '>', 0)
                ->groupBy($reservationTicketTable . '.date, ' . $reservationTicketTable . '.airline, ' . $reservationTicketTable . '.vehicle_grade, ' . $reservationTicketTable . '.origin_city, ' . $reservationTicketTable . '.destination_city')
                ->orderBy($reservationTicketTable . '.date', 'ASC')
                ->orderBy($reservationTicketTable . '.airline', 'ASC')
                ->orderBy($reservationVehicleGradeTable . '.name', 'ASC')
                ->all();

            $flights = [];
            foreach ($result as $row) {
                $flights[] = [
                    'date' => $row['date'],
                    'airline' => $row['airline'],
                    'vehicle_grade' => $row['vehicle_grade'],
                    'vehicle_grade_name' => $row['vehicle_grade_name'],
                    'vehicle_grade_abbr' => $row['vehicle_grade_abbr'],
                    'route' => $row['route_code'],
                    'route_name' => $row['route_name'],
                    'origin_city' => $row['origin_city'],
                    'destination_city' => $row['destination_city']
                ];
            }

            return $flights;

        } catch (Exception $e) {
            functions::insertLog("Error getting agency accessible flights: " . $e->getMessage(), 'manifestError');
            return [];
        }
    }

    /**
     * Get unique dates for agency accessible flights
     * @param int $agencyId
     * @return array
     */
    public function getAgencyAccessibleDates($agencyId)
    {
        try {
            // Get table names
            $agencyLockSeatTable = $this->getModel('agencyLockSeatModel')->getTable();
            $reservationTicketTable = $this->getModel('reservationTicketModel')->getTable();

            // Get current date in Shamsi format (YYYYMMDD)
            $currentDate = functions::ConvertToJalali(date('Y-m-d'), '-');
            $currentDate = str_replace('-', '', $currentDate);

            // Get unique dates for this agency
            $result = $this->getModel('reservationTicketModel')
                ->get([
                    $reservationTicketTable . '.date',
                    $reservationTicketTable . '.status'
                ], true)
                ->joinSimple(
                    [$agencyLockSeatTable, 'a'],
                    $reservationTicketTable . '.id',
                    'a.ticket_id'
                )
                ->where('a.agency_id', $agencyId)
                ->where($reservationTicketTable . '.date', $currentDate, '>=')
                ->where($reservationTicketTable . '.is_del', 'no')
                ->where($reservationTicketTable . '.status', 'Blocked','!=')
                ->groupBy($reservationTicketTable . '.date')
                ->orderBy($reservationTicketTable . '.date', 'ASC')
                ->all();

            $statusLabels = [
                ''          => '',
                'Cancelled' => '(کنسلی)',
                'Actived'  => '(فعال)'
            ];
            $dates = [];
            foreach ($result as $row) {
                $dateKey = $row['date'];
                $status = isset($row['status']) ? $row['status'] : '';
                $statusFa = isset($statusLabels[$status]) ? $statusLabels[$status] : '';
                $dates[$dateKey] = [
                    'value'  => $this->formatDateForDisplay($dateKey),
                    'label'  => $this->formatDateForDisplay($dateKey),
                    'status' => $statusFa
                ];
            }

            return array_values($dates);

        } catch (Exception $e) {
            functions::insertLog("Error in getAgencyAccessibleDates: " . $e->getMessage(), 'manifestError');
            return [];
        }
    }

    /**
     * Get unique routes for agency accessible flights
     * @param int $agencyId
     * @return array
     */
    public function getAgencyAccessibleRoutes($agencyId)
    {
        $flights = $this->getAgencyAccessibleFlights($agencyId);
        $routes = [];

        foreach ($flights as $flight) {
            $routeKey = $flight['route'];
            if (!isset($routes[$routeKey])) {
                $routes[$routeKey] = [
                    'value' => $flight['route'],
                    'label' => $flight['route_name']
                ];
            }
        }

        return array_values($routes);
    }

    /**
     * Get unique airlines for agency accessible flights
     * @param int $agencyId
     * @return array
     */
    public function getAgencyAccessibleAirlines($agencyId)
    {
        try {
            // Get table names
            $agencyLockSeatTable = $this->getModel('agencyLockSeatModel')->getTable();
            $reservationTicketTable = $this->getModel('reservationTicketModel')->getTable();
            $reservationVehicleGradeTable = $this->getModel('reservationVehicleGradeModel')->getTable();
            $reservationFlyTable = $this->getModel('reservationFlyModel')->getTable();

            // Get all flights with vehicle grades for this agency
            $flights = $this->getModel('reservationTicketModel')
                ->get([
                    $reservationTicketTable . '.airline',
                    $reservationTicketTable . '.vehicle_grade',
                    $reservationTicketTable . '.fly_code',
                    'vg.name as vehicle_grade_name',
                    'vg.abbreviation as vehicle_grade_abbr',
                    'f.fly_code as flight_number'
                ], true)
                ->joinSimple(
                    [$agencyLockSeatTable, 'a'],
                    $reservationTicketTable . '.id',
                    'a.ticket_id'
                )
                ->joinSimple(
                    [$reservationVehicleGradeTable, 'vg'],
                    $reservationTicketTable . '.vehicle_grade',
                    'vg.id',
                    'LEFT'
                )
                ->joinSimple(
                    [$reservationFlyTable, 'f'],
                    $reservationTicketTable . '.fly_code',
                    'f.id',
                    'LEFT'
                )
                ->where('a.agency_id', $agencyId)
                ->where($reservationTicketTable . '.is_del', 'no')
//                ->where('a.count_agency', '>', 0)
                ->groupBy($reservationTicketTable . '.airline, ' . $reservationTicketTable . '.vehicle_grade, ' . $reservationTicketTable . '.fly_code')
                ->orderBy($reservationTicketTable . '.airline', 'ASC')
                ->orderBy($reservationVehicleGradeTable . '.name', 'ASC')
                ->all();

            $airlines = [];

            foreach ($flights as $flight) {
                $airlineId = $flight['airline'];
                $vehicleGradeAbbr = $flight['vehicle_grade_abbr'] ?: $flight['vehicle_grade_name'] ?: 'unknown';
                $flightNumber = $flight['flight_number'] ?: $flight['fly_code'] ?: '';

                // Get airline information from airline_tb table (separate database)
                $airlineInfo = $this->getModel('airlineModel')
                    ->get(['name_fa', 'name_en', 'abbreviation'])
                    ->where('id', $airlineId)
                    ->where('del', 'no')
                    ->find();

                $airlineCode = '';
                $airlineLabel = '';

                if ($airlineInfo) {
                    $airlineCode = !empty($airlineInfo['abbreviation']) ? $airlineInfo['abbreviation'] : $airlineId;
                    $airlineLabel = !empty($airlineInfo['name_fa']) ? $airlineInfo['name_fa'] :
                        (!empty($airlineInfo['name_en']) ? $airlineInfo['name_en'] : $airlineCode);
                } else {
                    $airlineCode = $airlineId;
                    $airlineLabel = $airlineId;
                }

                // Create unique key for airline + vehicle grade + flight number combination
                $airlineGradeFlightKey = $airlineCode . '_' . $vehicleGradeAbbr . '_' . $flightNumber;

                if (!isset($airlines[$airlineGradeFlightKey])) {
                    $airlines[$airlineGradeFlightKey] = [
                        'value' => $airlineCode . '_' . $vehicleGradeAbbr . '_' . $flightNumber,
                        'label' => $airlineCode . ' (' . $vehicleGradeAbbr . ') - ' . $flightNumber,
                        'airline_code' => $airlineCode,
                        'vehicle_grade' => $vehicleGradeAbbr,
                        'flight_number' => $flightNumber,
                        'airline_name' => $airlineLabel,
                        'vehicle_grade_name' => $flight['vehicle_grade_name'] ?: $vehicleGradeAbbr
                    ];
                }
            }

            return array_values($airlines);

        } catch (Exception $e) {
            functions::insertLog("Error in getAgencyAccessibleAirlines: " . $e->getMessage(), 'manifestError');
            return [];
        }
    }

    /**
     * Get routes filtered by selected date for agency
     * @param int $agencyId
     * @param string $selectedDate
     * @return array
     */
    public function getAgencyRoutesByDate($agencyId, $selectedDate)
    {
        try {
            // Get table names
            $agencyLockSeatTable = $this->getModel('agencyLockSeatModel')->getTable();
            $reservationTicketTable = $this->getModel('reservationTicketModel')->getTable();
            $originCityTable = $this->getModel('reservationCityModel')->getTable();
            $destinationCityTable = $this->getModel('reservationCityModel')->getTable();

            // Get routes for this agency and date
            $result = $this->getModel('reservationTicketModel')
                ->get([
                    "CONCAT(oc.name, '-', dc.name) as route_code",
                    "CONCAT(oc.name, ' - ', dc.name) as route_name"
                ], true)
                ->joinSimple(
                    [$agencyLockSeatTable, 'a'],
                    $reservationTicketTable . '.id',
                    'a.ticket_id',
                    'INNER'
                )
                ->joinSimple(
                    [$originCityTable, 'oc'],
                    $reservationTicketTable . '.origin_city',
                    'oc.id',
                    'INNER'
                )
                ->joinSimple(
                    [$destinationCityTable, 'dc'],
                    $reservationTicketTable . '.destination_city',
                    'dc.id',
                    'INNER'
                )
                ->where('a.agency_id', $agencyId)
                ->where($reservationTicketTable . '.date', $selectedDate)
                ->where($reservationTicketTable . '.is_del', 'no')
//                ->where('a.count_agency', '>', 0)
                ->groupBy('route_code')
                ->orderBy('route_code', 'ASC')
                ->all();

            $routes = [];
            foreach ($result as $row) {
                $routes[] = [
                    'value' => $row['route_code'],
                    'label' => $row['route_name']
                ];
            }

            return $routes;

        } catch (Exception $e) {
            functions::insertLog("Error in getAgencyRoutesByDate: " . $e->getMessage(), 'manifestError');
            return [];
        }
    }

    /**
     * Get airlines filtered by selected date and route for agency
     * @param int $agencyId
     * @param string $selectedDate
     * @param string $selectedRoute
     * @return array
     */
    public function getAgencyAirlinesByDateAndRoute($agencyId, $selectedDate, $selectedRoute)
    {
        try {
            // Get table names
            $agencyLockSeatTable = $this->getModel('agencyLockSeatModel')->getTable();
            $reservationTicketTable = $this->getModel('reservationTicketModel')->getTable();
            $reservationVehicleGradeTable = $this->getModel('reservationVehicleGradeModel')->getTable();
            $reservationFlyTable = $this->getModel('reservationFlyModel')->getTable();

            // Get flights with vehicle grades for this agency, date, and route
            $flights = $this->getModel('reservationTicketModel')
                ->get([
                    $reservationTicketTable . '.id',
                    $reservationTicketTable . '.airline',
                    $reservationTicketTable . '.vehicle_grade',
                    $reservationTicketTable . '.fly_code',
                    $reservationTicketTable . '.exit_hour',
                    'vg.name as vehicle_grade_name',
                    'a.count_agency',
                    'vg.abbreviation as vehicle_grade_abbr',
                    'f.fly_code as flight_number'
                ], true)
                ->joinSimple(
                    [$agencyLockSeatTable, 'a'],
                    $reservationTicketTable . '.id',
                    'a.ticket_id'
                )
                ->joinSimple(
                    [$reservationVehicleGradeTable, 'vg'],
                    $reservationTicketTable . '.vehicle_grade',
                    'vg.id',
                    'LEFT'
                )
                ->joinSimple(
                    [$reservationFlyTable, 'f'],
                    $reservationTicketTable . '.fly_code',
                    'f.id',
                    'LEFT'
                )
                ->where('a.agency_id', $agencyId)
                ->where($reservationTicketTable . '.date', $selectedDate)
                ->where($reservationTicketTable . '.is_del', 'no')
//                ->where('a.count_agency', '>', 0)
                ->groupBy($reservationTicketTable . '.airline, ' . $reservationTicketTable . '.vehicle_grade, ' . $reservationTicketTable . '.fly_code')
                ->orderBy($reservationTicketTable . '.airline', 'ASC')
                ->orderBy('vg.name', 'ASC')
                ->all();

            $airlines = [];

            foreach ($flights as $flight) {
                $airlineId = $flight['airline'];
                $vehicleGradeAbbr = $flight['vehicle_grade_abbr'] ?: $flight['vehicle_grade_name'] ?: 'unknown';
                $flightNumber = $flight['flight_number'] ?: $flight['fly_code'] ?: '';
                $flightTicketId = $flight['id'];

                // Get airline information from airline_tb table (separate database)
                $airlineInfo = $this->getModel('airlineModel')
                    ->get(['name_fa', 'name_en', 'abbreviation'])
                    ->where('id', $airlineId)
                    ->where('del', 'no')
                    ->find();

                $airlineCode = '';
                $airlineLabel = '';

                if ($airlineInfo) {
                    $airlineCode = !empty($airlineInfo['abbreviation']) ? $airlineInfo['abbreviation'] : $airlineId;
                    $airlineLabel = !empty($airlineInfo['name_fa']) ? $airlineInfo['name_fa'] :
                        (!empty($airlineInfo['name_en']) ? $airlineInfo['name_en'] : $airlineCode);
                } else {
                    $airlineCode = $airlineId;
                    $airlineLabel = $airlineId;
                }

                // Create unique key for airline + vehicle grade + flight number combination
                $airlineGradeFlightKey = $airlineCode . '_' . $vehicleGradeAbbr . '_' . $flightNumber;

                if (!isset($airlines[$airlineGradeFlightKey])) {
                    $airlines[$airlineGradeFlightKey] = [
                        'value' => $flightTicketId, // Combined value for form submission
                        'label' => $airlineLabel . ' (' . $flightNumber . ') - ' . $vehicleGradeAbbr . '[' . $flight['count_agency'] . ']',
                        'airline_code' => $airlineCode,
                        'capacity' => $flight['count_agency'],
                        'vehicle_grade' => $vehicleGradeAbbr,
                        'exit_hour' => substr($flight['exit_hour'],0,5),
                        'flight_number' => $flightNumber,
                        'airline_name' => $airlineLabel,
                        'vehicle_grade_name' => $flight['vehicle_grade_name'] ?: $vehicleGradeAbbr
                    ];
                }
            }

            return array_values($airlines);

        } catch (Exception $e) {
            functions::insertLog("Error in getAgencyAirlinesByDateAndRoute: " . $e->getMessage(), 'manifestError');
            return [];
        }
    }

    /**
     * AJAX endpoint to get filtered routes by date
     * @return array JSON response
     */
    public function ajaxGetRoutesByDate($params)
    {
        try {
            $agencyId = Session::getAgencyId();
            $date = str_replace('/', '', $params['date']);
            $selectedDate = isset($date) ? $date : '';

            if (empty($selectedDate)) {
                return ['success' => false, 'message' => 'Date parameter is required'];
            }

            $routes = $this->getAgencyRoutesByDate($agencyId, $selectedDate);

            return [
                'success' => true,
                'routes' => $routes
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * AJAX endpoint to get filtered airlines by date and route
     * @return array JSON response
     */
    public function ajaxGetAirlinesByDateAndRoute($params)
    {
        try {
            $agencyId = Session::getAgencyId();
            $date = str_replace('/', '', $params['date']);
            $selectedDate = isset($date) ? $date : '';

            $selectedRoute = isset($params['route']) ? $params['route'] : '';

            if (empty($selectedDate) || empty($selectedRoute)) {
                return ['success' => false, 'message' => 'Date and route parameters are required'];
            }

            $airlines = $this->getAgencyAirlinesByDateAndRoute($agencyId, $selectedDate, $selectedRoute);

            return [
                'success' => true,
                'airlines' => $airlines
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * AJAX endpoint to get agency's uploaded passengers for a specific flight
     * @return array JSON response
     */
    public function ajaxGetAgencyPassengers($params)
    {
        try {
            $agencyId = Session::getAgencyId();
            $selectedDate=$selectedRoute='';
            if(!isset($params['ticket_id'])){//2 Model Vorodi Parametr Darim
                $date = $params['date'];
                $selectedDate = isset($date) ? $date : '';
                $selectedRoute = isset($params['route']) ? $params['route'] : '';
                $flightTicketId = isset($params['airline']) ? $params['airline'] : ''; // This now contains the flight ticket ID

                if (empty($selectedDate) || empty($selectedRoute) || empty($flightTicketId)){
                    return ['success' => false, 'message' => 'Date, route, and airline parameters are required'];
                }
            }
            else{
                $flightTicketId=$params['ticket_id'];
            }
            $passengers = $this->getAgencyPassengersForFlight($agencyId, $selectedDate, $selectedRoute, $flightTicketId);

            return [
                'success' => true,
                'passengers' => $passengers
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Get agency's uploaded passengers for a specific flight
     * @param int $agencyId
     * @param string $flightDate
     * @param string $route
     * @param int $flightTicketId
     * @return array
     */
    public function getAgencyPassengersForFlight($agencyId, $flightDate, $route, $flightTicketId)
    {
        try {
            // Get current agency info to check seat_charter_code
            $agencyController = $this->getController('agency');
            $agencyInfo = $agencyController->getAgency($agencyId);

            if (!$agencyInfo || empty($agencyInfo['seat_charter_code'])) {
                return [];
            }

            // Get passengers from manifest uploads using flight_ticket_id
            $manifestModel = $this->getModel('manifestUploadsModel');
            $passengers = $manifestModel->get()
                ->where('agency_id', $agencyInfo['id'])
                ->where('flight_ticket_id', $flightTicketId)
                ->orderBy('upload_timestamp', 'DESC')
                ->all(false);

            // Format passengers for display
            $formattedPassengers = [];
            foreach ($passengers as $passenger) {
                $formattedPassengers[] = [
                    'id' => $passenger['id'],
                    'passenger_name' => $passenger['passenger_name'],
                    'passenger_family' => $passenger['passenger_family'],
                    'national_id' => $passenger['national_id'],
                    'ticket_number' => $passenger['ticket_number'],
                    'passenger_type' => $passenger['passenger_type'],
                    'gender' => $passenger['gender'],
                    'phone_number' => $passenger['phone_number'],
                    'upload_timestamp' => $passenger['upload_timestamp'],
                    'formatted_date' => date('Y/m/d H:i', strtotime($passenger['upload_timestamp']))
                ];
            }

            return $formattedPassengers;

        } catch (Exception $e) {
            functions::insertLog("Error getting agency passengers: " . $e->getMessage(), 'manifestError');
            return [];
        }
    }

    /**
     * Format date for display (convert from YYYYMMDD Shamsi to readable format)
     * @param string $date
     * @return string
     */
    private function formatDateForDisplay($date)
    {
        if (strlen($date) === 8) {
            $year = substr($date, 0, 4);
            $month = substr($date, 4, 2);
            $day = substr($date, 6, 2);

            // Format as YYYY/MM/DD for display (Shamsi dates are already in Jalali format)
            return "$year/$month/$day";
        }

        return $date;
    }


    /**
     * Export passengers data to TXT file in manifest format
     *
     * @param array $params Contains passengers_data, airline_iata, flight_number, flight_date
     * @return array Response with file URL or error
     */
    public function exportPassengersToTxt($params)
    {
        try {
            // Parameter validation
            if (!isset($params['passengers_data']) || !isset($params['airline_iata']) ||
                !isset($params['flight_number']) || !isset($params['flight_date'])) {
                return [
                    'success' => false,
                    'message' => 'Missing required parameters'
                ];
            }

            $passengersData = $params['passengers_data'];
            $airlineIata = $params['airline_iata'];
            $flightNumber = $params['flight_number'];
            $flightDate = $params['flight_date'];

            // Convert date format and create content
            $dateFormatted = $this->convertDateForTxt($flightDate);
            $txtContent = "";

            foreach ($passengersData as $passenger) {
                // Format: ticket_number,agency_code,passenger_family/passenger_name,type,airline,flight_number,date,national_id,passport,gender,phone

                $ticketNumber = !empty($passenger['pnr']) ? $passenger['pnr'] :
                    (!empty($passenger['eticket_number']) ? $passenger['eticket_number'] :
                        (!empty($passenger['request_number']) ? $passenger['request_number'] : ''));

                $agencyCode = !empty($passenger['agency_name']) ? $passenger['agency_name'] : '';

                $passengerName = trim($passenger['passenger_family']) . '/' . trim($passenger['passenger_name']);

                // Convert passenger type
                $passengerType = $this->convertPassengerType($passenger['passenger_age']);

                $nationalId = !empty($passenger['passenger_national_code']) ? $passenger['passenger_national_code'] : '';

                $passportNumber = ''; // Not available in current data

                // Try to determine gender from name (basic approach)
                $gender = $passenger['passenger_gender'];

                $phoneNumber = !empty($passenger['member_mobile']) ? $passenger['member_mobile'] : '';

                // Create the line in the required format
                $line = implode(',', [
                    $ticketNumber,
                    $agencyCode,
                    $passengerName,
                    $passengerType,
                    $airlineIata,
                    $flightNumber,
                    $dateFormatted,
                    $nationalId,
                    $passportNumber,
                    $gender,
                    $phoneNumber
                ]);

                $txtContent .= $line . ",\n";
            }

            // Create better filename using actual parameters
            $safeDate = str_replace(['/', ':'], '-', $flightDate); // Sanitize date
            $filename = "manifest_{$airlineIata}_{$flightNumber}_{$safeDate}.txt";

            // Use config system
            $config = Load::Config('application');
            $config->pathFile('manifest_exports/');
            $exportDir = $config->path;

            // Ensure directory ends with separator
            $exportDir = rtrim($exportDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

            // Create directory if needed
            if (!file_exists($exportDir)) {
                if (!mkdir($exportDir, 0755, true)) {
                    return [
                        'success' => false,
                        'message' => 'Failed to create directory: ' . error_get_last()['message']
                    ];
                }
            }

            $filePath = $exportDir . $filename;

            // FIX: Write content with proper UTF-8 encoding
            // Method 1: Add UTF-8 BOM and use proper encoding
            $utf8Bom = "\xEF\xBB\xBF";
            $result = file_put_contents($filePath, $utf8Bom . $txtContent, LOCK_EX);

            // Alternative Method 2: Use fopen with explicit UTF-8 context
            /*
            $context = stream_context_create([
                'file' => [
                    'encoding' => 'UTF-8'
                ]
            ]);
            $result = file_put_contents($filePath, $txtContent, LOCK_EX, $context);
            */

            if ($result !== false) {
                $fileUrl = ROOT_ADDRESS_WITHOUT_LANG . '/pic/manifest_exports/' . $filename;
                return [
                    'success' => true,
                    'file_url' => $fileUrl,
                    'message' => 'TXT file created successfully',
                    'bytes_written' => $result
                ];
            } else {
                $error = error_get_last();
                return [
                    'success' => false,
                    'message' => 'Failed to create TXT file: ' . ($error ? $error['message'] : 'Unknown error'),
                    'file_path' => $filePath,
                    'directory_writable' => is_writable($exportDir),
                    'content_length' => strlen($txtContent)
                ];
            }

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error creating TXT file: ' . $e->getMessage()
            ];
        }
    }


    /**
     * Convert date to Jalali YY/MM/DD format for TXT export
     *
     * @param string $date Date in any format
     * @return string Date in YY/MM/DD Jalali format
     */
    private function convertDateForTxt($date)
    {
        // First, ensure we have a Jalali date
        $jalaliDate = $date;

        // Check if date needs conversion to Jalali (basic check for Gregorian patterns)
        if (strpos($date, '-') !== false) {
            // Likely Gregorian format (YYYY-MM-DD), convert to Jalali
            $jalaliDate = functions::ConvertToJalali($date, '/');
        } elseif (preg_match('/^(19|20)\d{2}/', $date)) {
            // Year starts with 19xx or 20xx, likely Gregorian
            $jalaliDate = functions::ConvertToJalali($date, '/');
        }

        // Now convert Jalali YYYY/MM/DD to YY/MM/DD format
        $dateParts = explode('/', $jalaliDate);
        if (count($dateParts) === 3) {
            $year = intval($dateParts[0]);

            // Convert Shamsi year to 2-digit format
            if ($year >= 1400) {
                $year = $year - 1400;
            } elseif ($year >= 1300) {
                $year = $year - 1300;
            } elseif ($year >= 2000) {
                // If somehow we still have Gregorian, convert it
                $year = $year - 2000;
            }

            return sprintf('%02d/%02d/%02d', $year, intval($dateParts[1]), intval($dateParts[2]));
        }

        // If the date doesn't have slashes, try to format it
        if (strpos($date, '/') === false) {
            // If it's a numeric date like 14040430, convert it to 04/04/30
            if (preg_match('/^(\d{4})(\d{2})(\d{2})$/', $date, $matches)) {
                $year = intval($matches[1]);
                $month = intval($matches[2]);
                $day = intval($matches[3]);

                // Convert Shamsi year to 2-digit format
                if ($year >= 1400) {
                    $year = $year - 1400;
                } elseif ($year >= 1300) {
                    $year = $year - 1300;
                }

                return sprintf('%02d/%02d/%02d', $year, $month, $day);
            }
        }

        // Fallback: return original date if conversion fails
        return $date;
    }

    /**
     * Convert passenger age type to manifest format
     *
     * @param string $passengerAge
     * @return string
     */
    private function convertPassengerType($passengerAge)
    {
        switch ($passengerAge) {
            case 'Adt':
                return 'ADL';
            case 'Chd':
                return 'CHD';
            case 'Inf':
                return 'INF';
            default:
                return 'ADL'; // Default to adult
        }
    }

    private function minimalGender($name)
    {
        if ($name == 'Male') {
            return 'MR'; // Default to male
        } else {
            return 'MRS'; // Default to female
        }
    }


    /**
     * Validate agency passenger limit for a specific flight
     *
     * @param int $agencyId Agency ID
     * @param int $flightTicketId Flight ticket ID
     * @param string $flightDate Flight date
     * @param int $newPassengerCount Number of new passengers to be added
     * @return array Validation result with 'allowed', 'message', 'can_insert_partial', 'can_insert_count', and 'partial_message' keys
     */
    private function validateAgencyPassengerLimit($agencyId, $flightTicketId, $flightDate, $newPassengerCount)
    {
        try {
            // Get agency's passenger limit for this specific flight ticket
            $agencyLimitModel = $this->getModel('agencyLockSeatModel');

            $agencyLimit = $agencyLimitModel->get([
                $agencyLimitModel->getTable() . '.count_agency',
                $agencyLimitModel->getTable() . '.counters',
                $agencyLimitModel->getTable() . '.ticket_id'
            ], true)
                ->where($agencyLimitModel->getTable() . '.agency_id', $agencyId)
                ->where($agencyLimitModel->getTable() . '.ticket_id', $flightTicketId)
                ->find(false);


            if (!$agencyLimit) {
                // No limit set for this agency/flight combination
                return [
                    'allowed' => true,
                    'message' => 'No passenger limit set for this flight',
                    'can_insert_partial' => false,
                    'can_insert_count' => $newPassengerCount,
                    'partial_message' => ''
                ];
            }

            $maxPassengers = (int)$agencyLimit['count_agency'];

            if ($maxPassengers <= 0) {
                return [
                    'allowed' => false,
                    'message' => "آژانس شما مجاز به آپلود مسافر برای این پرواز نیست. لطفاً با مدیر سیستم تماس بگیرید.",
                    'can_insert_partial' => false,
                    'can_insert_count' => 0,
                    'partial_message' => ''
                ];
            }

            // Get flight information from the ticket ID to get airline
            $flightInfo = $this->getModel('reservationTicketModel')
                ->get(['airline'])
                ->where('id', $flightTicketId)
                ->where('is_del', 'no')
                ->find(false);

            if (!$flightInfo) {
                return [
                    'allowed' => true,
                    'message' => 'Flight not found, proceeding with upload',
                    'can_insert_partial' => false,
                    'can_insert_count' => $newPassengerCount,
                    'partial_message' => ''
                ];
            }

            // Get airline abbreviation from airline_tb table
            $airlineInfo = $this->getModel('airlineModel')
                ->get(['abbreviation'])
                ->where('id', $flightInfo['airline'])
                ->where('del', 'no')
                ->find();

            $airlineIata = '';

            if ($airlineInfo) {
                $airlineIata = !empty($airlineInfo['abbreviation']) ? $airlineInfo['abbreviation'] : $flightInfo['airline'];
            } else {
                $airlineIata = $flightInfo['airline'];
            }

            // Count existing passengers for this agency on this flight
            $manifestModel = $this->getModel('manifestUploadsModel');
            $existingPassengers = $manifestModel->get()
                ->where('flight_ticket_id', $flightTicketId)
                ->count(false);

            $totalPassengersAfterUpload = $existingPassengers + $newPassengerCount;

            if ($totalPassengersAfterUpload > $maxPassengers) {
                $remainingSlots = $maxPassengers - $existingPassengers;
                $excessPassengers = $totalPassengersAfterUpload - $maxPassengers;

                // Check if we can insert at least some passengers
                if ($remainingSlots > 0) {
                    return [
                        'allowed' => false,
                        'message' => "تعداد مسافران شما از حد مجاز تجاوز می‌کند. محدودیت: {$maxPassengers} مسافر، موجود: {$existingPassengers} مسافر، قابل اضافه: {$remainingSlots} مسافر، اضافی: {$excessPassengers} مسافر",
                        'can_insert_partial' => true,
                        'can_insert_count' => $remainingSlots,
                        'partial_message' => "فقط {$remainingSlots} مسافر از {$newPassengerCount} مسافر قابل اضافه شدن بود"
                    ];
                } else {
                    return [
                        'allowed' => false,
                        'message' => "محدودیت آژانس: شما مجاز به اضافه کردن {$remainingSlots} مسافر دیگر هستید",
                        'can_insert_partial' => false,
                        'can_insert_count' => 0,
                        'partial_message' => ''
                    ];
                }
            }

            return [
                'allowed' => true,
                'message' => "محدودیت آژانس رعایت شده",
                'can_insert_partial' => false,
                'can_insert_count' => $newPassengerCount,
                'partial_message' => ''
            ];

        } catch (Exception $e) {
            // Log the error but allow the upload to continue
            functions::insertLog("Agency passenger limit validation error: " . $e->getMessage(), 'agencyLimitError');

            return [
                'allowed' => true,
                'message' => 'خطا در بررسی محدودیت مسافر، آپلود ادامه می‌یابد',
                'can_insert_partial' => false,
                'can_insert_count' => $newPassengerCount,
                'partial_message' => ''
            ];
        }
    }


    /**
     * Get airline IATA code from airline model
     * @param string $airlineCode
     * @return string
     */
    private function getAirlineData($airlineCode)
    {
        try {
            // Use the airline model to get airline IATA code
            $airline = $this->getModel('airlineModel')
                ->get()
                ->where('id', $airlineCode)
                ->find(false);

            if (!empty($airline) && isset($airline['abbreviation'])) {
                return $airline;
            }

            return $airlineCode; // Return code if not found

        } catch (Exception $e) {
            functions::insertLog("Error getting airline IATA code: " . $e->getMessage(), 'manifestError');
            return $airlineCode; // Return code if any error
        }
    }

    /**
     * Get passenger details for editing
     * @param array $params
     * @return array
     */
    public function getPassengerForEdit($params)
    {
        try {
            $recordId = isset($params['record_id']) ? $params['record_id'] : '';
            $recordType = isset($params['record_type']) ? $params['record_type'] : ''; // 'manifest' or 'book'

            if (empty($recordId) || empty($recordType)) {
                return [
                    'status' => false,
                    'message' => 'شناسه رکورد و نوع رکورد الزامی است'
                ];
            }

            if ($recordType === 'manifest') {
                // Get manifest record
                $record = $this->getModel('manifestUploadsModel')
                    ->get([
                        'id',
                        'passenger_name',
                        'passenger_family',
                        'national_id as passenger_national_code',
                        'passport_number as passportNumber',
                        'passenger_type',
                        'gender as passenger_gender',
                        'phone_number as member_phone',
                        'ticket_number',
                        'flight_number',
                        'airline_iata',
                        'flight_date'
                    ])
                    ->where('id', $recordId)
                    ->find(false);

                if (!$record) {
                    return [
                        'status' => false,
                        'message' => 'رکورد مانیفست یافت نشد'
                    ];
                }

            } elseif ($recordType === 'book') {
                // Get book record
                $record = $this->getModel('bookLocalModel')
                    ->get([
                        'id',
                        'passenger_name_en as passenger_name',
                        'passenger_family_en as passenger_family',
                        'passenger_national_code',
                        'passportNumber',
                        'passenger_birthday',
                        'passenger_gender',
                        'member_mobile as member_phone',
                        'member_email',
                        'successfull',
                        'request_number'
                    ])
                    ->where('id', $recordId)
                    ->where('del', 'no')
                    ->find(false);

                if (!$record) {
                    return [
                        'status' => false,
                        'message' => 'رکورد رزرو یافت نشد'
                    ];
                }

            } else {
                return [
                    'status' => false,
                    'message' => 'نوع رکورد نامعتبر است'
                ];
            }

            return [
                'status' => true,
                'data' => [
                    'record' => $record,
                    'record_type' => $recordType
                ]
            ];

        } catch (Exception $e) {
            functions::insertLog("Error in getPassengerForEdit: " . $e->getMessage(), 'manifestError');
            return [
                'status' => false,
                'message' => 'خطا در دریافت اطلاعات مسافر'
            ];
        }
    }

    /**
     * Update passenger record
     * @param array $params
     * @return array
     */
    public function updatePassenger($params)
    {
        try {
            $recordId = isset($params['record_id']) ? $params['record_id'] : '';
            $recordType = isset($params['record_type']) ? $params['record_type'] : '';
            $passengerData = isset($params['passenger_data']) ? $params['passenger_data'] : [];

            if (empty($recordId) || empty($recordType) || empty($passengerData)) {
                return [
                    'status' => false,
                    'message' => 'اطلاعات ناقص است'
                ];
            }


            if ($recordType === 'manifest') {
                $record = $this->getModel('manifestUploadsModel')->get()
                    ->where('id', $recordId)
                    ->find(false);


                // Update manifest record
                $updateData = [
                    'passenger_name' => isset($passengerData['passenger_name']) ? $passengerData['passenger_name'] : $record['passenger_name'],
                    'passenger_family' => isset($passengerData['passenger_family']) ? $passengerData['passenger_family'] : $record['passenger_family'],
                    'national_id' => isset($passengerData['passenger_national_code']) ? $passengerData['passenger_national_code'] : $record['national_id'],
                    'passport_number' => isset($passengerData['passportNumber']) ? $passengerData['passportNumber'] : $record['passport_number'],
                    'passenger_type' => isset($passengerData['passenger_type']) ? $passengerData['passenger_type'] : $record['passenger_type'],
                    'gender' => isset($passengerData['passenger_gender']) ? $passengerData['passenger_gender'] : $record['gender'],
                    'phone_number' => isset($passengerData['member_phone']) ? $passengerData['member_phone'] : $record['phone_number'],
                    'ticket_number' => isset($passengerData['ticket_number']) ? $passengerData['ticket_number'] : $record['ticket_number']
                ];
                $result = $this->getModel('manifestUploadsModel')
                    ->updateWithBind($updateData, [
                        'id' => $recordId
                    ]);

            } elseif ($recordType === 'book') {

                $record = $this->getModel('bookLocalModel')
                    ->get()
                    ->where('id', $recordId)
                    ->where('del', 'no')
                    ->find(false);

                // Update book record
                $updateData = [
                    'passenger_name_en' => isset($passengerData['passenger_name']) ? $passengerData['passenger_name'] : $record['passenger_name_en'],
                    'passenger_family_en' => isset($passengerData['passenger_family']) ? $passengerData['passenger_family'] : $record['passenger_family_en'],
                    'passenger_national_code' => isset($passengerData['passenger_national_code']) ? $passengerData['passenger_national_code'] : $record['passenger_national_code'],
                    'passportNumber' => isset($passengerData['passportNumber']) ? $passengerData['passportNumber'] : $record['passportNumber'],
                    'passenger_birthday' => isset($passengerData['passenger_birthday']) ? $passengerData['passenger_birthday'] : $record['passenger_birthday'],
                    'passenger_gender' => isset($passengerData['passenger_gender']) ? $passengerData['passenger_gender'] : $record['passenger_gender'],
                    'member_mobile' => isset($passengerData['member_phone']) ? $passengerData['member_phone'] : $record['member_mobile'],
                    'member_email' => isset($passengerData['member_email']) ? $passengerData['member_email'] : $record['member_email']
                ];

                $result = $this->getModel('bookLocalModel')
                    ->updateWithBind($updateData, [
                        'del' => 'no',
                        'id' => $recordId,
                    ]);

                // Also update the corresponding record in reportModel

                try {
                    // Get the request_number from the book record to sync with reportModel
                    $bookRecord = $this->getModel('reportModel')
                        ->get(['request_number', 'passenger_national_code', 'passportNumber'])
                        ->where('id', $recordId)
                        ->where('del', 'no')
                        ->find(false);

                    if ($bookRecord && !empty($bookRecord['request_number'])) {
                        // Prepare update data for reportModel (only passenger-related fields)
                        $reportUpdateData = [
                            'passenger_name_en' => isset($passengerData['passenger_name']) ? $passengerData['passenger_name'] : $record['passenger_name_en'],
                            'passenger_family_en' => isset($passengerData['passenger_family']) ? $passengerData['passenger_family'] : $record['passenger_family_en'],
                            'passenger_national_code' => isset($passengerData['passenger_national_code']) ? $passengerData['passenger_national_code'] : $record['passenger_national_code'],
                            'passportNumber' => isset($passengerData['passportNumber']) ? $passengerData['passportNumber'] : $record['passportNumber'],
                            'passenger_birthday' => isset($passengerData['passenger_birthday']) ? $passengerData['passenger_birthday'] : $record['passenger_birthday'],
                            'passenger_gender' => isset($passengerData['passenger_gender']) ? $passengerData['passenger_gender'] : $record['passenger_gender'],
                            'member_mobile' => isset($passengerData['member_phone']) ? $passengerData['member_phone'] : $record['member_mobile'],
                            'member_email' => isset($passengerData['member_email']) ? $passengerData['member_email'] : $record['member_email']
                        ];

                        // Build condition array to match the specific passenger in reportModel
                        $condition = [
                            'request_number' => $bookRecord['request_number']
                        ];

                        // Add unique identifier condition
                        if ($bookRecord['passenger_national_code'] != '0000000000' && !empty($bookRecord['passenger_national_code'])) {
                            $condition['passenger_national_code'] = $bookRecord['passenger_national_code'];
                        } else {
                            $condition['passportNumber'] = $bookRecord['passportNumber'];
                        }

                        // Update reportModel using array condition
                        $reportResult = $this->getModel('reportModel')->updateWithBind($reportUpdateData, $condition);

                        // Log the sync operation
                        functions::insertLog("Synced passenger update to reportModel: request_number={$bookRecord['request_number']}, condition=" . json_encode($condition) . ", result=" . ($reportResult ? 'success' : 'failed'), 'manifestPassengerEdit');
                    } else {
                        functions::insertLog("Could not sync to reportModel: missing request_number or book record not found for ID={$recordId}", 'manifestPassengerEdit');
                    }
                } catch (Exception $e) {
                    functions::insertLog("Error syncing to reportModel: " . $e->getMessage(), 'manifestPassengerEdit');
                }


            } else {
                return [
                    'status' => false,
                    'message' => 'نوع رکورد نامعتبر است'
                ];
            }

            return [
                'status' => true,
                'message' => 'اطلاعات مسافر با موفقیت بروزرسانی شد'
            ];


        } catch (Exception $e) {
            functions::insertLog("Error in updatePassenger: " . $e->getMessage(), 'manifestError');
            return [
                'status' => false,
                'message' => 'خطا در بروزرسانی اطلاعات مسافر'
            ];
        }
    }


    /**
     * Get agency lock seat data for a specific flight
     * @param string $params
     * @return array
     */
    public function getAgencyLockSeatData($params)
    {
        try {
            // Get tickets for this flight code
            $tickets = $this->getModel('reservationTicketModel')
                ->get()
                ->where('id', $params['ticket_id'])
                ->where('is_del', 'no')
                ->all();

            if (empty($tickets)) {
                return [
                    'status' => true,
                    'data' => [
                        'total_agencies' => 0,
                        'total_seats' => 0,
                        'agencies' => []
                    ]
                ];
            }

            // Get ticket IDs
            $ticketIds = array_column($tickets, 'id');

            // Get agency lock seat data
            $agencyLockSeats = $this->getModel('agencyLockSeatModel')
                ->get()
                ->whereIn('ticket_id', $ticketIds)
                ->all();

            if (empty($agencyLockSeats)) {
                return [
                    'status' => true,
                    'data' => [
                        'total_agencies' => 0,
                        'total_seats' => 0,
                        'agencies' => []
                    ]
                ];
            }

            // Get agency names
            $agencyIds = array_unique(array_column($agencyLockSeats, 'agency_id'));
            $agencies = $this->getModel('agencyModel')
                ->get()
                ->whereIn('id', $agencyIds)
                ->all();

            $agencyNames = [];
            foreach ($agencies as $agency) {
                $agencyNames[$agency['id']] = $agency['name_fa'];
            }

            // Get vehicle grades for capacity breakdown
            $vehicleGrades = $this->getModel('reservationVehicleGradeModel')
                ->get(['id', 'name', 'abbreviation'])
                ->where('is_del', 'no')
                ->orderBy('name', 'ASC')
                ->all();

            $vehicleGradeNames = [];
            foreach ($vehicleGrades as $grade) {
                $vehicleGradeNames[$grade['id']] = $grade['name'];
            }

            // Process agency lock seat data with vehicle grade capacities
            $processedAgencies = [];
            $totalSeats = 0;

            foreach ($agencyLockSeats as $lockSeat) {
                $ticket = null;
                foreach ($tickets as $t) {
                    if ($t['id'] == $lockSeat['ticket_id']) {
                        $ticket = $t;
                        break;
                    }
                }

                if ($ticket) {
                    //get total passenger in agency
                    $this->AgencyIdManifest=$lockSeat['agency_id'];
                    $returnPassengerTotal=$this->getFlightDetails(['ticket_id' => $lockSeat['ticket_id']]);
                    if ($returnPassengerTotal['status']) {
                        $ticketData = $returnPassengerTotal['data'];
                        $totalPassengersInAgency = $ticketData['tickets']; // 👈 تعداد کل مسافرها برای اون آژانس
                    }

                    // Get agency close time settings
                    $agencyCloseTime = $this->getAgencyCloseTime($lockSeat['id']);

                    // Parse counters to get vehicle grade capacities
                    $counters = json_decode($lockSeat['counters'], true) ?: [];
                    $vehicleGradeCapacities = [];

                    // Extract capacities for each vehicle grade
                    foreach ($vehicleGrades as $grade) {
                        $gradeId = $grade['id'];
                        $capacity = 0;

                        // Check if this grade has capacity in counters
                        if (isset($counters[$gradeId])) {
                            $capacity = (int)$counters[$gradeId];
                        }

                        $vehicleGradeCapacities[] = [
                            'grade_id' => $gradeId,
                            'grade_name' => $grade['name'],
                            'grade_abbreviation' => $grade['abbreviation'],
                            'capacity' => $capacity
                        ];
                    }

                    $processedAgencies[] = [
                        'agency_id' => $lockSeat['agency_id'],
                        'agency_name' => isset($agencyNames[$lockSeat['agency_id']]) ? $agencyNames[$lockSeat['agency_id']] : 'نامشخص',
                        'count_agency' => $lockSeat['count_agency'],
                        'count_passenger_total'=>$totalPassengersInAgency,
                        'flight_date' => $ticket['date'],
                        'status' => 'active', // You can add logic to determine status
                        'counters' => $counters,
                        'vehicle_grade_capacities' => $vehicleGradeCapacities,
                        'agency_lock_seat_id' => $lockSeat['id'],
                        'close_time' => $agencyCloseTime ? [
                            'internal' => $agencyCloseTime['internal'],
                            'external' => $agencyCloseTime['external']
                        ] : null
                    ];

                    $totalSeats += $lockSeat['count_agency'];
                }
            }

            return [
                'status' => true,
                'data' => [
                    'total_agencies' => count(array_unique(array_column($processedAgencies, 'agency_id'))),
                    'total_seats' => $totalSeats,
                    'agencies' => $processedAgencies,
                    'vehicle_grades' => $vehicleGrades
                ]
            ];

        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'خطا در دریافت اطلاعات آژانس‌ها: ' . $e->getMessage()
            ];
        }
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
    public function validateUploadTime($flightInfo)
    {
        try {
            date_default_timezone_set('Asia/Tehran');
            // Get current date and time in Tehran timezone
            $dateNow = date('Y-m-d');
            $expDate = explode("-", $dateNow);
            $currentShamsiDate = dateTimeSetting::gregorian_to_jalali($expDate[0], $expDate[1], $expDate[2], '/');
            $currentTime = date('H:i');

            // Get flight date and time
            $flightDate = $flightInfo['date']; // Shamsi date from database
            $flightTime = substr($flightInfo['exit_hour'],0,5); // Flight time (format: HHMM or HH:MM)
            $destinationCountry = $flightInfo['destination_country']; // 1 = internal, other = external
            $agencyId = isset($_SESSION['AgencyId']) ? $_SESSION['AgencyId'] : null;

            // Normalize flight date format (remove separators for comparison)
            $normalizedFlightDate = str_replace(['-','/'], '', $flightDate);
            $currentShamsiDate = str_replace(['-','/'], '', $currentShamsiDate);

            // Check if flight is in the past - don't allow uploads for past flights
            if ($normalizedFlightDate < $currentShamsiDate) {
                return [
                    'allowed' => false,
                    'message' => 'امکان آپلود مانیفست برای پروازهای گذشته وجود ندارد.'
                ];
            }

            // Check if flight is in the future - allow upload without time restrictions
            if ($normalizedFlightDate > $currentShamsiDate) {
                return [
                    'allowed' => true,
                    'message' => ''
                ];
            }

            // Flight is today, check time limitations

            // First check agency-specific close time if agency is logged in
            $agencyCloseTime = null;
            if ($agencyId) {
                // Get agency lock seat record for this flight and agency
                $agencyLockSeat = $this->getModel('agencyLockSeatModel')
                    ->get('id')
                    ->where('agency_id', $agencyId)
                    ->where('ticket_id', $flightInfo['id'])
                    ->all();

                if ($agencyLockSeat) {
                    $agencyCloseTime = $this->getAgencyCloseTime($agencyLockSeat[0]['id']);
                }
            }

            // Get airline close time settings (fallback)
            $airlineCloseTime = $this->getAirlineCloseTime($flightInfo['airline']);

            // Use agency-specific close time if available, otherwise use airline close time
            $closeTimeToUse = $agencyCloseTime ?: $airlineCloseTime;
           if (!$closeTimeToUse) {
                // No close time set, allow upload
                return [
                    'allowed' => true,
                    'message' => ''
                ];
            }

            // Determine if it's internal or external flight and get appropriate close time
            $isInternalFlight = ($destinationCountry == 1);
            $closeTimeHours = 0;

            if ($isInternalFlight) {
                $closeTimeString = isset($closeTimeToUse['internal']) ? $closeTimeToUse['internal'] : 0;
                //1==2 $closeTimeHours = $this->parseTimeStringToDecimalHours($closeTimeString);
                $closeTimeHours=$closeTimeString;
            } else {
                $closeTimeString = isset($closeTimeToUse['external']) ? $closeTimeToUse['external'] : 0;
                //1==2 $closeTimeHours = $this->parseTimeStringToDecimalHours($closeTimeString);
                $closeTimeHours = $closeTimeString;
            }

            if ($closeTimeHours <= 0) {
                // No restriction set, allow upload
                return [
                    'allowed' => true,
                    'message' => ''
                ];
            }

            // Parse and normalize flight time
            $normalizedFlightTime = $this->normalizeTimeFormat($flightTime);
            if (!$normalizedFlightTime) {
                // Invalid flight time format, allow upload (don't block due to format issues)
                return [
                    'allowed' => true,
                    'message' => ''
                ];
            }

            // Create DateTime objects for comparison
            $flightTimeObj = DateTime::createFromFormat('H:i', $normalizedFlightTime, new DateTimeZone('Asia/Tehran'));
            $currentTimeObj = DateTime::createFromFormat('H:i', $currentTime, new DateTimeZone('Asia/Tehran'));

            if (!$flightTimeObj || !$currentTimeObj) {
                // Invalid time objects, allow upload
                return [
                    'allowed' => true,
                    'message' => ''
                ];
            }

            // Calculate the deadline time (when uploads close)
            // Convert close time hours to total minutes
            //1==2 $closeTimeHours_int = intval($closeTimeHours);
            //1==2 $closeTimeMinutes = intval(($closeTimeHours - $closeTimeHours_int) * 60);
            //1==2 $totalCloseMinutes = ($closeTimeHours_int * 60) + $closeTimeMinutes;
            $totalCloseMinutes = intval($closeTimeHours);

            // Add agency additional minutes if available
            $additionalMinutes = 0;
            if ($agencyCloseTime) {
                if ($isInternalFlight && isset($agencyCloseTime['internal_additional']) && $agencyCloseTime['internal_additional']) {
                    $additionalMinutes = intval($agencyCloseTime['internal_additional']);
                } elseif (!$isInternalFlight && isset($agencyCloseTime['external_additional']) && $agencyCloseTime['external_additional']) {
                    $additionalMinutes = intval($agencyCloseTime['external_additional']);
                }
            }

            $totalCloseMinutes += $additionalMinutes;

            // Calculate deadline time by subtracting close time from flight time
            $deadlineTimeObj = clone $flightTimeObj;
            $deadlineTimeObj->sub(new DateInterval('PT' . $totalCloseMinutes . 'M'));
            $deadlineTime = $deadlineTimeObj->format('H:i');

            // Compare current time with deadline time
            // Convert times to minutes for easier comparison
            $currentTimeMinutes = ($currentTimeObj->format('H') * 60) + $currentTimeObj->format('i');
            $deadlineTimeMinutes = ($deadlineTimeObj->format('H') * 60) + $deadlineTimeObj->format('i');

            if ($currentTimeMinutes > $deadlineTimeMinutes) {
                // Upload deadline passed
                $airlineInfo = $this->getAirlineData($flightInfo['airline']);
                $airlineName = is_array($airlineInfo) ? (isset($airlineInfo['name_fa']) ? $airlineInfo['name_fa'] : (isset($airlineInfo['name_en']) ? $airlineInfo['name_en'] : 'نامشخص')) : 'نامشخص';
                $flightType = $isInternalFlight ? 'داخلی' : 'خارجی';

                // Format close time display properly
                $closeTimeDisplay = $this->formatCloseTimeForDisplay($closeTimeHours);

                // Determine close time type for message
                $closeTimeType = $agencyCloseTime ? 'آژانس' : 'هواپیمایی';

                // Add agency additional minutes info to message
                $additionalInfo = '';
                if ($additionalMinutes > 0) {
                    $additionalInfo = sprintf(' (+%s دقیقه اضافی)', $additionalMinutes);
                }

                return [
                    'allowed' => false,
                    'message' => sprintf(
                        'مهلت آپلود مانیفست برای این پرواز به پایان رسیده است.' . "\n\n" .
                        '📅 پرواز: %s' . "\n" .
                        '✈️ نوع پرواز: %s' . "\n" .
                        '🕐 ساعت پرواز: %s' . "\n" .
                        '⏰ مهلت آپلود تا: %s' . "\n" .
                        '🕘 زمان فعلی: %s' . "\n" .
                        '🔒 نوع محدودیت: %s%s' . "\n\n" .
                        '💡 مانیفست برای پروازهای %s باید %s قبل از پرواز آپلود شود.',
                        $airlineName . ' - ' . $flightInfo['fly_code'],
                        $flightType,
                        $normalizedFlightTime,
                        $deadlineTime,
                        $currentTime,
                        $closeTimeType,
                        $additionalInfo,
                        $flightType,
                        $closeTimeDisplay
                    )
                ];
            }

            // Upload is allowed
            return [
                'allowed' => true,
                'message' => ''
            ];

        } catch (Exception $e) {
            // Log error but don't block upload due to validation errors
            functions::insertLog("Time validation error: " . $e->getMessage(), 'manifestUploadTimeValidation');

            return [
                'allowed' => true,
                'message' => ''
            ];
        }
    }

    /**
     * Normalize time format to HH:MM
     * Handles HHMM, HH:MM, H:MM formats
     *
     * @param string $timeString Input time string
     * @return string|false Normalized time in HH:MM format or false if invalid
     */
    private function normalizeTimeFormat($timeString)
    {
        if (empty($timeString)) {
            return false;
        }

        $timeString = trim($timeString);

        // If already in HH:MM or H:MM format, validate and return
        if (preg_match('/^(\d{1,2}):(\d{2})$/', $timeString, $matches)) {
            $hours = intval($matches[1]);
            $minutes = intval($matches[2]);

            if ($hours >= 0 && $hours <= 23 && $minutes >= 0 && $minutes <= 59) {
                return sprintf('%02d:%02d', $hours, $minutes);
            }
            return false;
        }

        // If it's in HHMM format (4 digits)
        if (preg_match('/^(\d{4})$/', $timeString)) {
            $hours = intval(substr($timeString, 0, 2));
            $minutes = intval(substr($timeString, 2, 2));

            if ($hours >= 0 && $hours <= 23 && $minutes >= 0 && $minutes <= 59) {
                return sprintf('%02d:%02d', $hours, $minutes);
            }
            return false;
        }

        // If it's in HMM format (3 digits)
        if (preg_match('/^(\d{3})$/', $timeString)) {
            $hours = intval(substr($timeString, 0, 1));
            $minutes = intval(substr($timeString, 1, 2));

            if ($hours >= 0 && $hours <= 23 && $minutes >= 0 && $minutes <= 59) {
                return sprintf('%02d:%02d', $hours, $minutes);
            }
            return false;
        }

        return false;
    }

    /**
     * Parse time string to decimal hours
     * Handles formats like "04:30", "4.5", "4:30", etc.
     *
     * @param string|int|float $timeString Time in various formats
     * @return float Decimal hours (e.g., 4.5 for 4:30)
     */
    private function parseTimeStringToDecimalHours($timeString)
    {
        if (empty($timeString)) {
            return 0;
        }

        $timeString = trim($timeString);

        // If it's already a numeric value, return as float
        if (is_numeric($timeString)) {
            return floatval($timeString);
        }

        // If it's in HH:MM or H:MM format
        if (preg_match('/^(\d{1,2}):(\d{2})$/', $timeString, $matches)) {
            $hours = intval($matches[1]);
            $minutes = intval($matches[2]);
            return $hours + ($minutes / 60);
        }

        // If it's in HHMM format (4 digits)
        if (preg_match('/^(\d{4})$/', $timeString)) {
            $hours = intval(substr($timeString, 0, 2));
            $minutes = intval(substr($timeString, 2, 2));
            return $hours + ($minutes / 60);
        }

        // If it's in HMM format (3 digits)
        if (preg_match('/^(\d{3})$/', $timeString)) {
            $hours = intval(substr($timeString, 0, 1));
            $minutes = intval(substr($timeString, 1, 2));
            return $hours + ($minutes / 60);
        }

        // Fallback: try to parse as float
        return floatval($timeString);
    }

    /**
     * Format close time for display in Persian
     *
     * @param float $closeTimeHours Close time in hours (e.g., 4.5)
     * @return string Formatted time string
     */
    private function formatCloseTimeForDisplay($closeTimeHours)
    {
        $hours = intval($closeTimeHours);
        $minutes = intval(($closeTimeHours - $hours) * 60);

        if ($minutes == 0) {
            return $hours . ' ساعت';
        } else {
            return $hours . ' ساعت و ' . $minutes . ' دقیقه';
        }
    }
    /**
     * Get airline close time settings
     *
     * @param string $airlineId Airline ID
     * @return array|null Close time settings or null if not found
     */
    private function getAirlineCloseTime($airlineId)
    {
        try {
            $airlineCloseTimeModel = $this->getModel('airlineCloseTimeModel');

            // First try to get specific airline close time
            $airlineCloseTime = $airlineCloseTimeModel
                ->get()
                ->where('type', 'airline')
                ->where('type_id', $airlineId)
                ->find();

            if ($airlineCloseTime) {
                return $airlineCloseTime;
            }

            // If no specific airline setting, get global setting (type_id = 0)
            $globalCloseTime = $airlineCloseTimeModel
                ->get()
                ->where('type', 'airline')
                ->where('type_id', '0')
                ->find();

            return $globalCloseTime;

        } catch (Exception $e) {
            functions::insertLog("Error getting airline close time: " . $e->getMessage(), 'manifestUploadTimeValidation');
            return null;
        }
    }




    /**
     * Get agency close time settings for a specific agency lock seat record
     * @param int $agencyLockSeatId
     * @return array|null
     */
    public function getAgencyCloseTime($agencyLockSeatId)
    {
        try {
            $airlineCloseTimeModel = $this->getModel('airlineCloseTimeModel');

            // Get agency-specific close time (type = 'lock_seat')
            $agencyCloseTime = $airlineCloseTimeModel
                ->get()
                ->where('type', 'lock_seat')
                ->where('type_id', $agencyLockSeatId)
                ->find();
            return $agencyCloseTime;
        } catch (Exception $e) {
            functions::insertLog("Error getting agency close time: " . $e->getMessage(), 'manifestUploadTimeValidation');
            return null;
        }
    }

    /**
     * Save or update agency close time settings
     * @param array $params
     * @return array
     */
    public function saveAgencyCloseTime($params)
    {
        try {
            $agencyLockSeatId = $params['agency_lock_seat_id'];
            $internalTime = $params['internal_time'];
            $externalTime = $params['external_time'];

            if (empty($agencyLockSeatId)) {
                return [
                    'status' => false,
                    'message' => 'شناسه آژانس الزامی است'
                ];
            }

            $airlineCloseTimeModel = $this->getModel('airlineCloseTimeModel');

            // Check if record already exists
            $existingRecord = $airlineCloseTimeModel
                ->get()
                ->where('type', 'lock_seat')
                ->where('type_id', $agencyLockSeatId)
                ->find();

            if ($existingRecord) {
                // Update existing record
                $updateData = [
                    'internal' => $internalTime,
                    'external' => $externalTime
                ];

                $result = $airlineCloseTimeModel
                    ->get()
                    ->updateWithBind($updateData, [
                        'type' => 'lock_seat',
                        'type_id' => $agencyLockSeatId
                    ]);

                if ($result) {
                    return [
                        'status' => true,
                        'message' => 'زمان اضافی آژانس با موفقیت بروزرسانی شد'
                    ];
                } else {
                    return [
                        'status' => false,
                        'message' => 'خطا در بروزرسانی تنظیمات'
                    ];
                }
            } else {
                // Create new record
                $insertData = [
                    'type' => 'lock_seat',
                    'type_id' => $agencyLockSeatId,
                    'internal' => $internalTime,
                    'external' => $externalTime
                ];

                $result = $airlineCloseTimeModel->insertWithBind($insertData);

                if ($result) {
                    return [
                        'status' => true,
                        'message' => 'زمان اضافی آژانس با موفقیت تنظیم شد'
                    ];
                } else {
                    return [
                        'status' => false,
                        'message' => 'خطا در ایجاد تنظیمات'
                    ];
                }
            }

        } catch (Exception $e) {
            functions::insertLog("Error saving agency close time: " . $e->getMessage(), 'manifestUploadTimeValidation');
            return [
                'status' => false,
                'message' => 'خطا در ذخیره تنظیمات'
            ];
        }
    }

    /**
     * Get agency close time data for modal
     * @param array $params
     * @return array
     */
    public function getAgencyCloseTimeData($params)
    {
        try {
            $agencyLockSeatId = $params['agency_lock_seat_id'];
            $agencyName = $params['agency_name'];

            if (empty($agencyLockSeatId)) {
                return [
                    'status' => false,
                    'message' => 'شناسه آژانس الزامی است'
                ];
            }

            // Get current close time settings
            $currentSettings = $this->getAgencyCloseTime($agencyLockSeatId);

            return [
                'status' => true,
                'data' => [
                    'agency_lock_seat_id' => $agencyLockSeatId,
                    'agency_name' => $agencyName,
                    'current_settings' => $currentSettings,
                    'default_options' => [
                        'internal' => ['5', '10', '15', '30', '60', '120'],
                        'external' => ['10', '15', '30', '60', '120', '240']
                    ]
                ]
            ];

        } catch (Exception $e) {
            functions::insertLog("Error getting agency close time data: " . $e->getMessage(), 'manifestUploadTimeValidation');
            return [
                'status' => false,
                'message' => 'خطا در دریافت اطلاعات'
            ];
        }
    }

    /**
     * Delete agency close time settings
     * @param array $params
     * @return array
     */
    public function deleteAgencyCloseTime($params)
    {
        try {
            $agencyLockSeatId = $params['agency_lock_seat_id'];

            if (empty($agencyLockSeatId)) {
                return [
                    'status' => false,
                    'message' => 'شناسه آژانس الزامی است'
                ];
            }

            $airlineCloseTimeModel = $this->getModel('airlineCloseTimeModel');

            $result = $airlineCloseTimeModel->delete([
                'type' => 'lock_seat',
                'type_id' => $agencyLockSeatId
            ]);

            if ($result) {
                return [
                    'status' => true,
                    'message' => 'تنظیمات زمان بسته شدن آژانس با موفقیت حذف شد'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'خطا در حذف تنظیمات'
                ];
            }

        } catch (Exception $e) {
            functions::insertLog("Error deleting agency close time: " . $e->getMessage(), 'manifestUploadTimeValidation');
            return [
                'status' => false,
                'message' => 'خطا در حذف تنظیمات'
            ];
        }
    }

    //محاسبه ظرفیت مانده
    public function  FunRemainingCapacity($ticket_id){
        // ظرفیت رزرو شده
        $reservedManifestCount = $this->getModel('manifestUploadsModel')
            ->get(['id'])
            ->where('flight_ticket_id', $ticket_id)
            ->count();

        $reservedBookCount = $this->getModel('bookLocalModel')
            ->get(['id'])
            ->where('fk_id_ticket', $ticket_id)
            ->whereIn('successfull', ['book', 'private_reserve'])
            ->where('del', 'no')
            ->count();

        $reservedCapacity = $reservedManifestCount + $reservedBookCount;
        return $reservedCapacity;
    }

    public function DateChangeManiFest(){
        // تاریخ امروز میلادی
        $todayGregorian = date('Y-m-d'); // مثلا "2025-10-05"

        // تبدیل میلادی به شمسی
        $todayJalali = dateTimeSetting::gregorian_to_jalali(
            substr($todayGregorian, 0, 4),
            substr($todayGregorian, 5, 2),
            substr($todayGregorian, 8, 2),
            '-'
        ); // خروجی مثلاً "1404-07-13"

        // حالا یک روز ازش کم کنیم
        list($jy, $jm, $jd) = explode('-', $todayJalali);

        // تبدیل شمسی به timestamp برای کم کردن روز
        $todayTimestamp = strtotime(dateTimeSetting::jalali_to_gregorian($jy, $jm, $jd, '-') . ' 00:00:00');

        // کم کردن یک روز
        $yesterdayTimestamp = strtotime('-1 day', $todayTimestamp);

        // دوباره تبدیل به شمسی برای آرشیو
        $yesterdayGregorian = date('Y-m-d', $yesterdayTimestamp);
        $yesterdayJalali = dateTimeSetting::gregorian_to_jalali(
            substr($yesterdayGregorian, 0, 4),
            substr($yesterdayGregorian, 5, 2),
            substr($yesterdayGregorian, 8, 2),
            '-'
        );
        return [
            'todayJalali'     => str_replace('-', '', $todayJalali),     // مثلا 14040713
            'yesterdayJalali' => str_replace('-', '', $yesterdayJalali)  // مثلا 14040712
        ];
    }

    public function CreateExcelManifest() {

        if (empty($this->DataExcelManifest)) {
            return 'error|اطلاعاتی برای ساخت فایل اکسل وجود ندارد.';
        }

        foreach ($this->DataExcelManifest as &$row) {
            foreach ($row as $k => &$v) {
                if ($v === null || $v === '') {
                    $v = '-';
                } else {
                    $v = (string)$v . ' ';
                }
            }
        }
        unset($row);
        $data_excel_fixed = array_values($this->DataExcelManifest);

        $firstRowColumnsHeading = [
            'ردیف', 'فروشنده', 'ایرلاین', 'پرواز', 'کلاس', 'روز',
            'تاریخ', 'مبدا', 'مقصد', 'ساعت حرکت', 'ساعت فرود','وضعیت', 'مانیفست', 'خرید',
            'واگذار', 'مانده', 'رزرو', 'مانده کل'
        ];
        $firstRowWidth = [10, 20, 20, 15, 15, 15, 15, 20, 20, 15,15, 15, 15, 15, 15, 15, 15, 15];

        /** @var createExcelFile $objCreateExcelFile */
        $objCreateExcelFile = Load::controller('createExcelFile');
        $resultExcel = $objCreateExcelFile->create($data_excel_fixed, $firstRowColumnsHeading, $firstRowWidth);

        // بررسی صحیح‌تر نتیجه
        if ($resultExcel['message'] === 'success' && !empty($resultExcel['fileName'])) {

            return 'success|' . $resultExcel['fileName'];
        } else {
            return 'error|ساخت فایل اکسل انجام نشد یا فایل برنگشت.';
        }
    }

    public function CreateExcelNira($tickets, $pnr_group_size = 5) {
        // --- بررسی اینکه حداقل یکی از آرایه‌ها خالی نباشد ---
        if (empty($tickets['manifest_records']) && empty($tickets['book_records'])) {
            return 'error|اطلاعاتی برای ساخت فایل اکسل وجود ندارد.';
        }

        // --- ترکیب رکوردها و ست کردن record_type ---
        $records = [];

        foreach ($tickets['manifest_records'] as $r) {
            $r['record_type'] = 'manifest';
            $records[] = $r;
        }

        foreach ($tickets['book_records'] as $r) {
            $r['record_type'] = 'book';
            $records[] = $r;
        }

        // --- مرحله 1: جدا کردن بزرگسالان و کودکان ---
        $adults = [];
        $children = [];
        foreach ($records as $r) {
            $r['passenger_age_first'] = substr($r['passenger_age'], 0, 1); // A/C/I
            if ($r['passenger_age_first'] === 'A') {
                $adults[] = $r;
            } else {
                $children[] = $r;
            }
        }


        // --- مرحله 2: مرتب کردن لیست نهایی (هیچ دو کودک پشت سر هم نباشند) ---
        $final_list = [];
        while (!empty($adults) || !empty($children)) {
            if (!empty($adults)) {
                $final_list[] = array_shift($adults);
            }
            if (!empty($children)) {
                $next_child = array_shift($children);
                if (!empty($final_list) && in_array($final_list[count($final_list)-1]['passenger_age_first'], ['C','I'])
                    && in_array($next_child['passenger_age_first'], ['C','I'])) {
                    if (!empty($adults)) {
                        $final_list[] = array_shift($adults);
                    }
                }
                $final_list[] = $next_child;
            }
        }

        // --- مرحله 3: تولید PNR گروهی و جلوگیری از تکرار ---
        $grouped_list = [];
        $counter = 0;
        $pnr_current = '';
        // تاریخ حرکت شمسی → میلادی
        $travel_greg = dateTimeSetting::jalali_to_gregorian(
            substr($tickets['date'],0,4),
            substr($tickets['date'],4,2),
            substr($tickets['date'],6,2),
            '-'
        );
        $travel_ts = strtotime($travel_greg);

        foreach ($final_list as $r) {
            $is_new_pnr = false;
            $is_new_birthday = false;
            $birth_current='';
            $type_birth_current='';

            //creat Pnr
            if (!empty($r['nira_pnr'])) {
                $pnr_final = $r['nira_pnr'];
            } elseif ($counter % $pnr_group_size == 0) {
                // ترکیبی از حروف و اعداد، 6 کاراکتر به شکل AA1-BB2
                $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $numbers = '0123456789';

                $part1 = $letters[rand(0,25)] . $letters[rand(0,25)] . $numbers[rand(0,9)];
                $part2 = $letters[rand(0,25)] . $letters[rand(0,25)] . $numbers[rand(0,9)];

                $pnr_final=$pnr_current = $part1 . '-' . $part2;
                $is_new_pnr = true;//avali bar ke misazad
            }else{
                $is_new_pnr = true;//record haye badi ke bayad barash copy konim
                $pnr_final=$pnr_current;
            }

            //Create birthday
            if (!empty($r['passenger_birthday'])) {
                $birth_current = str_replace('-','/',$r['passenger_birthday']);
                $type_birth_current='Shamsi';
            }
            else if ($r['record_type'] === 'book'  && !empty($r['passenger_birthday_en'])) {
                $birth_current = str_replace('-','/',$r['passenger_birthday_en']);
                $type_birth_current='Miladi';
            }
            else {
                $type_birth_current='Shamsi';
                $is_new_birthday = true;

                // تعیین رنج سن‌ها
                if ($r['passenger_age_first'] === 'A') {
                    $min_year = 20;
                    $max_year = 60;
                    $random_years = rand($min_year, $max_year);
                }
                elseif ($r['passenger_age_first'] === 'C') {
                    $min_year = 3;
                    $max_year = 10;
                    $random_years = rand($min_year, $max_year);
                }
                elseif ($r['passenger_age_first'] === 'I') {
                    $min_month = 1;
                    $max_month = 18;
                    $random_months = rand($min_month, $max_month);
                }
                else {
                    $random_years = 30;
                }

                // ایجاد تاریخ میلادی حدودی (فقط سال)
                if ($r['passenger_age_first'] === 'I') {
                    // نوزاد → کم‌کردن ماه
                    $approx_ts = strtotime("-$random_months month", $travel_ts);
                } else {
                    // بزرگسال/کودک → کم‌کردن سال
                    $approx_ts = strtotime("-$random_years year", $travel_ts);
                }

                // ⭐ انتخاب روز و ماه کاملاً تصادفی (۱ تا ۱۲ ، ۱ تا ۲۸ یا ۳۰ یا ۳۱)
                $rand_month = rand(1, 12);
                // برای جلوگیری از تاریخ اشتباه مثل 31/02
                $rand_day = rand(1, cal_days_in_month(CAL_GREGORIAN, $rand_month, date("Y", $approx_ts)));

                // ساخت تاریخ میلادی نهایی
                $gy = date('Y', $approx_ts);
                $gm = str_pad($rand_month, 2, '0', STR_PAD_LEFT);
                $gd = str_pad($rand_day, 2, '0', STR_PAD_LEFT);

                // تبدیل به شمسی
                $birth_shamsi = dateTimeSetting::gregorian_to_jalali($gy, $gm, $gd, '-');

                // خروجی
                $birth_current = $birth_shamsi;
            }

            $r['nira_pnr'] = $pnr_final;
            if($type_birth_current=='Shamsi'){
                $r['passenger_birthday']= dateTimeSetting::jalali_to_gregorian(substr($birth_current,0,4), substr($birth_current,5,2), substr($birth_current,7,2), '-');
            }
            else{
                $r['passenger_birthday'] = $birth_current;
            }

            //create expire passsport
            $expire_ts = strtotime("+8 month", $travel_ts);
            $passportExpire = date("Y/m/d", $expire_ts);
            $r['passportExpire'] = $passportExpire;

            $grouped_list[] = $r;

            // --- آپدیت PNR در دیتابیس ---
            if($is_new_pnr===true) {
                if ($r['record_type'] === 'manifest') {
                    $this->getModel('manifestUploadsModel')
                        ->updateWithBind(
                            [
                                'nira_pnr' => $r['nira_pnr'],
                                'passenger_birthday' => $birth_current,
                            ],
                            ['id' => $r['id']]
                        );
                }
                elseif ($r['record_type'] === 'book') {
                    //agar nist insert vaela update
                    $findLocalExtera = $this->getModel('bookLocalExteraModel')
                        ->get(['id'])
                        ->where('id_book_local', $r['id'])
                        ->find();
                    if (is_array($findLocalExtera) && !empty($findLocalExtera['id'])) {
                        $this->getModel('bookLocalExteraModel')
                            ->updateWithBind(['nira_pnr' => $r['nira_pnr']], ['id' => $findLocalExtera['id']]);
                    } else {
                        $insert_fly = $this->getModel('bookLocalExteraModel')->insertWithBind([
                            'id_book_local' => $r['id'],
                            'nira_pnr' => $r['nira_pnr']
                        ]);
                    }
                    //update field birthday
                    if ($is_new_birthday === true) {
                        $this->getModel('bookLocalModel')
                            ->updateWithBind(['passenger_birthday' => $birth_current], ['id' => $r['id']]);
                    }
                }
            }
            $counter++;
        }

        // --- مرحله 4: آماده سازی داده‌ها برای اکسل ---
        $excel_data = [];
        $excel_dataRow1 = ['From','To', 'Flight No', 'Flight Date'];
        $excel_data[] = [
                          $tickets['FromCity'],
                          $tickets['ToCity'],
                          $tickets['flight_number'],
                          substr($tickets['date'],0,4).'/'.substr($tickets['date'],4,2).'/'.substr($tickets['date'],6,2)
        ];
        $excel_data[] = [
            'R', 'Action', 'Age Type (A,C,I)', 'Title (M/F)', 'English First Name', 'English Last Name',
            'Persian First Name', 'Persian Last Name', 'Birth date', 'With Adult', 'National Id','Passport Id',
            'Mobile', 'Email','SSR Code', 'Agency PNR', 'Agency Ticket No.'
        ];

        $row_number = 1;
        foreach ($grouped_list as $r) {

            $birth_date = '';
            if ($r['passenger_birthday']!='') {
                $bd = str_replace('/','',$r['passenger_birthday']);
                $bd = str_replace('-','',$bd);
                // روز
                $day = substr($bd, 6, 2);
                // ماه
                $month = substr($bd, 4, 2);
                // تبدیل ماه عدد به انگلیسی
                $months = array(
                    '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
                    '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug',
                    '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'
                );
                $month_txt = $months[$month];

                // سال دو رقمی
                $year2 = substr($bd, 2, 2);
                $year = substr($bd, 0, 4);

                // خروجی نهایی مثل 11/04/2007
                $birth_date =  $day. '/' . $month . '/' . $year;
            }

            $gender = '';
            if (isset($r['passenger_gender']) && $r['passenger_gender']!='') {
                $g = strtolower(trim($r['passenger_gender']));

                if ($g == 'mr' || $g == 'male') {
                    $gender = 'M';
                } elseif ($g == 'mrs' || $g == 'female') {
                    $gender = 'F';
                } else {
                    $gender = ''; // اگر مقدار قابل تشخیص نبود
                }
            }

            $passportNumber='';
            if (isset($r['passportNumber']) && $r['passportNumber']!='') {
                $passportExpire='------';
                if ($r['passportExpire']!='') {
                    $bd_Expire = str_replace('/','',$r['passportExpire']);
                    $bd_Expire = str_replace('-','',$bd_Expire);
                    // روز
                    $day_Expire = substr($bd_Expire, 6, 2);
                    // ماه
                    $month_Expire = substr($bd_Expire, 4, 2);
                    // تبدیل ماه عدد به انگلیسی
                    $months_Expire= array(
                        '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
                        '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug',
                        '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'
                    );
                    $month_txt_Expire = $months_Expire[$month_Expire];

                    // سال دو رقمی
                    $year2_Expire = substr($bd_Expire, 2, 2);
                    $passportExpire=$day_Expire.$month_txt_Expire.$year2_Expire;
                }

                $passportNumber='IRN/'.$r['passportNumber'].'/IRN/'.$day.$month_txt.$year2.'/'.$gender.'/'.$passportExpire.'/'.$r['passenger_family'].'/'.$r['passenger_name'];
            }
            $excel_data[] = [
                $row_number,
                'I', // Action ثابت
                $r['passenger_age_first'],
                $gender,
                $r['passenger_name'],
                $r['passenger_family'],
                $r['passenger_name'], // فارسی = انگلیسی
                $r['passenger_family'], // فارسی = انگلیسی
                $birth_date,
                '', // With Adult خالی
                isset($r['passenger_national_code']) ? $r['passenger_national_code'] : '',
                $passportNumber,
                isset($r['member_phone']) ? $r['member_phone'] : '',
                '', // Email خالی
                '',// SSR خالی
                $r['nira_pnr'], // PNR گروهی
                ''//Ticket No خالی
            ];
            $row_number++;
        }
        $firstRowWidth = [10, 10, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20];

        /** @var createExcelFile $objCreateExcelFile */
        $objCreateExcelFile = Load::controller('createExcelFile');
        $resultExcel = $objCreateExcelFile->create($excel_data, $excel_dataRow1, $firstRowWidth,'نیرا');

// بررسی صحیح‌تر نتیجه
        if ($resultExcel['message'] === 'success' && !empty($resultExcel['fileName'])) {
            echo json_encode([
                'status' => 'success',
                'fileName' => $resultExcel['fileName']
            ]);
            exit;
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'ساخت فایل اکسل انجام نشد'
            ]);
            exit;
        }

    }

}
