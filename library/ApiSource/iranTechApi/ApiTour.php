<?php
error_reporting(1);
error_reporting(E_ALL | E_STRICT);
@ini_set('display_errors', 1);
@ini_set('display_errors', 'on');




class ApiTour extends clientAuth
{
    public $client_id;
    public $admin_controller;
    public $providers;
    public $counter_types = array();

    public function __construct() {
        parent::__construct();

        header("Content-type: application/json");


        $this->processRequest();
    }

    private function getNameMethodApiTour(): array {

        return ['getAllTypeTour','countries', 'cities', 'typesTour', 'search', 'detail', 'prereserve', 'book', 'reserve','packages','hotelsPackages','informationsHotel','tourRoutes','infoTourByDate','packageOfTour','infoSpecialHotel','listTourTravelProgram','getInfoTour','getInfoTourRoutByIdTour','getTypeVehicleApi','getOriginCities','getOriginCitiesExternal','getCountryDestination','getCityDestinationExternal'];
    }
    public function executeRequest($content, $url) {
        $method = $this->traceUrl($url);
        if (!empty($method)) {
            if (!in_array($method, $this->getNameMethodApiTour())) {
                echo functions::withError([], 404, 'Method Not Found');
                exit();
            }
            $providers = $this->getClientProviders();
            if(!empty($providers)){
                $this->providers = $providers[0];
                return $this->$method($content);
            }
            echo functions::withError([], 400, 'Access Denied');
            exit();
        } else {
            echo functions::withError([], 400, 'Request Not Valid');
            exit();
        }
    }

    public function processRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $headers = getallheaders();

            if (isset($headers['Content-Type']) && strpos($headers['Content-Type'], 'application/json') !== false) {
                $content = json_decode(file_get_contents('php://input'), true);
                $auth_user = $headers['Username'] ?? '';
                $auth_pass = $headers['Password'] ?? '';

                if (!empty($auth_user) && !empty($auth_pass)) {

                    $user_name = filter_var($auth_user, FILTER_SANITIZE_STRING);
                    $password = filter_var($auth_pass, FILTER_SANITIZE_STRING);
                    $get_info_user = $this->getAccessApiTour($user_name, $password);
                    if (!empty($get_info_user)) {

                        $this->client_id = $get_info_user['ClientId'];
                        $this->admin_controller = $this->getController('admin');
                        echo $this->executeRequest($content, $_SERVER['REQUEST_URI']);
                        exit();
                    } else {
                        echo functions::withError([
                            'code' => 'ET003',
                            'error' => 'AuthFailed',
                            'status' => 'error'
                        ], 401, 'Authentication Failed');
                        exit();
                    }
                } else {
                    echo functions::withError([
                        'code' => 'ET002',
                        'error' => 'DataAuthNotValid'
                    ], 400, 'Data Auth Not Valid');
                    exit();
                }

            } else {
                echo functions::withError([
                    'code' => 'ET001',
                    'error' => 'HeadersNotValid',
                    'status' => 'error'
                ], 406, 'Headers Not Valid');
                exit();
            }
        } else {
            echo functions::withError([
                'code' => 'ET000',
                'error' => 'WrongMethod',
                'status' => 'error'
            ], 405, 'Method Not Allowed');
            exit();
        }
    }

    private function traceUrl($url) {

        $route_url = explode('/', $url);

        return $route_url[3];

    }



    public function search($content) {

        $countries = $this->getCountries();
        $cities = $this->getCities();
        $types_tour = $this->getTourType();

        if ($content['language'] == 'fa') {
            $dateNow = dateTimeSetting::jdate("Ymd", time(), '', '', 'en');
        } else {
            $dateNow = date("Ymd", time());
        }
        if ($content['start_date'] != 'all') {
            $SDate = str_replace("-", "", $content['start_date']);
        } else {
            $SDate = $dateNow;
        }

        $controllerPublic = $this->getController('reservationPublicFunctions');
        $date2Check = $controllerPublic->dateNextFewDays($SDate, ' + 120');


        if (trim($SDate) < trim($dateNow)) {
            return functions::withError([
                'code' => 'ET004',
                'error' => 'DateIsWrong',
                'status' => 'error'
            ], 400, 'Date Selected IS Wrong');
        }

        if ($content['language'] == 'fa') {
            if ($content['start_date'] != 'all') {
                $search_start_date = str_replace("-", "", $content ['start_date']);
                $start_date = explode('-', $content ['start_date']);
                $search_end_month = $controllerPublic->shamsiMonthToEndDay($start_date[0], $start_date[1]);
                $search_end_date = implode("-", [$start_date[0], $start_date[1], $search_end_month]);
                $search_end_date = str_replace("-", "", $search_end_date);
            } else {
                $search_start_date = $dateNow;
            }


        } else {
            if ($content ['start_date'] != 'all') {
                $search_start_date = str_replace("-", "", $content ['start_date']);
                $start_date = explode('-', $content ['start_date']);
                $search_end_month = $controllerPublic->miladiMonthToEndDay($start_date[0], $start_date[1]);
                $search_end_date = implode("-", [$start_date[0], $start_date[1], $search_end_month]);
                $search_end_date = str_replace("-", "", $search_end_date);
            } else {
                $search_start_date = $dateNow;
            }

        }

        $WHERE = " AND T.start_date >'{$dateNow}' ";
        if (isset($content ['destination_type']) && $content ['destination_type'] == 'internal') {
            $WHERE .= " AND T.origin_country_id = '1' ";
            $WHERE .= " AND TR.destination_country_id = '1' ";
            $WHERE .= " AND TR.tour_title = 'dept' ";;

        } elseif (isset($content ['tourTypeId']) && $content ['tourTypeId'] == 'external') {
            $WHERE .= " AND T.origin_country_id = '1' ";
            $WHERE .= " AND TR.destination_country_id != '1' ";
            $WHERE .= " AND TR.tour_title = 'dept' ";

        } elseif (isset($content ['tourTypeId']) && $content ['tourTypeId'] != 'all' && $content ['tourTypeId'] != 'lastMinuteTour') {
            $WHERE .= " AND T.tour_type_id LIKE '%" . '"' . $content['tourTypeId'] . '"' . "%' ";
        }
        $Join = '';
        if ($content['start_date'] != 'all') {
            $WHERE .= " AND (T.start_date >= '{$search_start_date}' AND T.start_date <= '{$search_end_date}') ";
        } else {
            $WHERE .= " AND (T.start_date >= '{$search_start_date}' ) ";
        }


        if (isset($content['origin_country_id']) && $content['origin_country_id'] != 'all') {
            $WHERE .= " AND T.origin_country_id = '{$content['origin_country_id']}' ";
            $Join .= " INNER JOIN reservation_tour_tourType_tb AS TTT ON T.id_same=TTT.fk_tour_id_same";
        }
        if (isset($content['destination_country_id']) && $content['destination_country_id'] != 'all') {
            $WHERE .= " AND TR.destination_country_id = '{$content['destination_country_id']}' ";
        }
        if (isset($content['origin_city_id']) && $content['origin_city_id'] != 'all') {
            $WHERE .= " AND T.origin_city_id = '{$content['origin_city_id']}' ";
        }
        if (isset($content['destination_city_id']) && $content['destination_city_id'] != 'all') {
            $WHERE .= " AND TR.destination_city_id = '{$content['destination_city_id']}' ";
        }

        if (isset($content['is_special']) && $content['is_special'] == '1') {
            $WHERE .= " AND T.is_special = 'yes' ";

        }


        $sql = " SELECT
                      	T.id , T.id_same,T.tour_name,T.tour_name_en,T.tour_type_id,
                        T.tour_code,T.start_date,T.end_date,T.night,T.`day`,T.tour_pic,
                        T.origin_continent_id,T.origin_country_id,T.is_show,T.is_special,T.is_del,
                        T.`language`,
                        T.origin_city_name,
                        T.change_price,
                        ReservationOriginCity.name_en AS origin_city_name_en,
                        T.origin_city_id,
                        T.origin_region_name,
                        T.origin_country_name,
                        ReservationOriginCountry.name_en AS origin_country_name_en,
                        TR.destination_country_name,
                        ReservationDestinationCountry.name_en AS destination_country_name_en,
                        TR.destination_city_name,
                        ReservationDestinationCity.name_en AS destination_city_name_en,
                        TR.destination_region_name,
                        TR.airline_name,
                        TR.type_vehicle_name,
                        TR.exit_hours,
                        TR.airline_id,
                        TR.type_vehicle_id,
                        TR.tour_title,
                        TR.destination_country_id,
                        TR.id AS idRout
                  FROM
                      reservation_tour_tb AS T
                      INNER JOIN reservation_tour_rout_tb AS TR ON T.id=TR.fk_tour_id
                      LEFT JOIN reservation_city_tb AS ReservationOriginCity ON ReservationOriginCity.id=T.origin_city_id
                      LEFT JOIN reservation_country_tb AS ReservationOriginCountry ON ReservationOriginCountry.id=T.origin_country_id
                      LEFT JOIN reservation_city_tb AS ReservationDestinationCity ON ReservationDestinationCity.id=TR.destination_city_id
                      LEFT JOIN reservation_country_tb AS ReservationDestinationCountry ON ReservationDestinationCountry.id=TR.destination_country_id
                      {$Join}
                  WHERE
                      T.is_del = 'no'
                      AND 
                      T.is_show = 'yes' 
                      AND TR.tour_title='dept'
                      AND (TR.is_route_fake = '1' OR TR.is_route_fake IS NULL) 
                      {$WHERE}
                  GROUP BY T.tour_code
                  ORDER BY T.priority=0,T.priority ASC
                  ";


        $tours = $this->admin_controller->ConectDbClient($sql, $this->providers, "SelectAll", "", "", "");


        $airlines = [];
        $final_tours = [];
        if (!empty($tours)) {
            foreach ($tours as $k => $tour) {
                $types = [];
                $type_ides = json_decode($tour['tour_type_id'], true);
                foreach ($type_ides as $item) {
                    $types [] = [
                        'id' => $item,
                        'name' => $types_tour[$item]['tour_type']
                    ];
                }


                $vehicles = $this->getTypeVehicle($tour['id']);
                $oneDayTour = in_array('1', $type_ides);

                $minPrice = $this->minPriceHotelByIdTourR($tour['id'], $oneDayTour);
                $routes = $this->infoTourRoutByIdTour($tour['id']);
                if ($minPrice['price'] > 0) {
                    $final_tours[] = [
                        'id' => $tour['id'],
                        'id_same' => $tour['id_same'],
                        'tour_name' => $tour['tour_name'],
                        'tour_name_en' => $tour['tour_name_en'],
                        'tour_type' => $types,
                        'tour_code' => $tour['tour_code'],
                        'start_date' => $this->formatDate($tour['start_date']),
                        'end_date' => $this->formatDate($tour['end_date']),
                        'night' => $tour['night'],
                        'day' => $tour['day'],
                        'tour_pic' => "https://safar360.com/gds/pic/reservationTour/" . $tour['tour_pic'],
                        'origin_country_id' => $tour['origin_country_id'],
                        'is_special' => $tour['is_special'],
                        'origin_city_name' => $tour['origin_city_name'],
                        'origin_city_name_en' => $tour['origin_city_name_en'],
                        'origin_city_id' => $tour['origin_city_id'],
                        'origin_region_name' => $tour['origin_region_name'],
                        'destination_country_id' => $tour['destination_country_id'],
                        'destination_country_name' => $tour['destination_country_name'],
                        'destination_city_name' => $tour['destination_city_name'],
                        'destination_city_name_en' => $tour['destination_city_name_en'],
                        'destination_region_name' => $tour['destination_region_name'],
                        'vehicle_name' => $tour['airline_name'],
                        'type_vehicle_name' => $tour['type_vehicle_name'],
                        'exit_hours' => $tour['exit_hours'],
                        'vehicle_id' => $tour['airline_id'],
                        'type_vehicle_id' => $tour['type_vehicle_id'],
                        'start_price' => $minPrice,
                        'vehicles' => $vehicles,
                        'info_tour_rout' => $routes

                    ];
                }

            }

            return functions::withSuccess($final_tours, 200, 'Data Fetched Successfully');
        }

        return functions::withError([
            'code' => 'D001',
            'error' => 'DataNotExist',
            'status' => 'error'
        ], 404, 'Data Not Exist');

    }

    public function detail($content) {
        $tour = $this->getTour($content['tour_id']);


        if (!empty($tour)) {
            $vehicle = $this->typeVehicles($content['tour_id']);

            $suggestion_tours = $this->infoTourSuggestedByTourId($tour['id_same'], $tour['origin_city_id']);


            $info_tour_route_by_id_tour = $this->infoTourRoutByIdTour($content['tour_id']);

            $one_day_tour = (strpos($tour['tour_type_id'], '"1"') !== false) ? true : false;



            $price = $this->minPriceHotelByIdTourR($content['tour_id'], $one_day_tour);

            $gallery_tour = $this->getTourGallery($content['tour_id']);

            $tour_days = $this->listTourDates($tour['tour_code'], $one_day_tour);

            $get_tour_route = $this->getTourRouteData($content['tour_id']);

            return functions::withSuccess([
                "tour" => $tour,
                "vehicle" => $vehicle,
                "suggestion_tours" => $suggestion_tours,
                "info_tour_route_by_id_tour" => $info_tour_route_by_id_tour,
                "price" => $price,
                "gallery_tour" => $gallery_tour,
                "tour_days" => $tour_days,
                "tour_route" => $get_tour_route
            ]);
        }

        return functions::withError([
            'code' => 'N001',
            'error' => 'TourIdIsInvalid',
            'status' => 'error'
        ], 404, 'Tour Not Found');

    }

    private function getClientProviders(): array {
        $providers = $this->getModel('providersTourModel')->get()->where('client_id', $this->client_id)->find();
        return !empty($providers) ? json_decode($providers['providers'], true) : [];
    }

    public function getCountries(): array {
        $sql = "SELECT * FROM reservation_country_tb WHERE is_del = 'no'";
        $results = $this->admin_controller->ConectDbClient($sql, $this->providers, "SelectAll", "", "", "");

        $countries = [];
        foreach ($results as $result) {
            $countries[$result['id']] = $result;
        }
        return $countries;
    }

    public function getCities(): array {
        $sql = "SELECT * FROM reservation_city_tb WHERE is_del = 'no'";
        $results = $this->admin_controller->ConectDbClient($sql, $this->providers, "SelectAll", "", "", "");

        $cities = [];
        foreach ($results as $result) {
            $cities[$result['id']] = $result;
        }
        return $cities;
    }

    public function getTourType(): array {
        $sql = " SELECT * FROM reservation_tour_type_tb WHERE is_del = 'no' ";
        $results = $this->admin_controller->ConectDbClient($sql, $this->providers, "SelectAll", "", "", "");

        $types = [];
        foreach ($results as $result) {
            $types[$result['id']] = $result;
        }
        return $types;
    }

    public function cities($data, $code = null) {

        $results = $this->getCities();

        if (!$results) {
            return functions::withError([
                'code' => 'ET004',
                'error' => 'DataNotExist',
                'status' => 'error'
            ], 404, 'Data Not Exist');
        }

        $cities = [];
        foreach ($results as $city) {
            $cities[] = [
                'id' => $city['id'],
                'name' => $city['name'] ?? '',
                'name_en' => $city['name_en'] ?? '',
                'name_ar' => $city['name_ar'] ?? '',
                'abbreviation' => $city['abbreviation'],
                'id_country' => $city['id_country'],
            ];
        }
        return functions::withSuccess(
            $cities, 200, 'data fetched successfully');
    }

    public function countries($data, $code = null) {

        $results = $this->getCountries();
        if (!$results) {
            return functions::withError([
                'code' => 'ET004',
                'error' => 'DataNotExist',
                'status' => 'error'
            ], 404, 'Data Not Exist');
        }

        $countries = [];
        foreach ($results as $country) {
            $countries[] = [
                'id' => $country['id'],
                'name' => $country['name'] ?? '',
                'name_en' => $country['name_en'] ?? '',
                'name_ar' => $country['name_ar'] ?? '',
                'abbreviation' => $country['abbreviation'],
                'id_continent' => $country['id_continent'],
            ];
        }
        return functions::withSuccess(
            $countries, 200, 'data fetched successfully');
    }

    public function typesTour($data, $code = null) {

        $results = $this->getTourType();

        if (!$results) {
            return functions::withError([
                'code' => 'ET004',
                'error' => 'DataNotExist',
                'status' => 'error'
            ], 404, 'Data Not Exist');
        }

        $types = [];
        foreach ($results as $type) {
            $types[] = [
                'id' => $type['id'],
                'tour_type' => $type['tour_type'] ?? '',
                'tour_type_en' => $type['tour_type_en'] ?? '',
            ];
        }
        return functions::withSuccess(
            $types, 200, 'data fetched successfully');
    }


    private function isLastMinuteTour($startDate, $startTimeLastMinuteTour): bool {
        if (strpos($startDate, "-") !== false) {
            $startDate = str_replace("-", "", $startDate);
        } elseif (strpos($startDate, "/") !== false) {
            $startDate = str_replace("/", "", $startDate);
        }
        $dateNow = date("Ymd");
        $day = intval($startDate) - intval($dateNow);
        if (!empty($startTimeLastMinuteTour) && $day <= $startTimeLastMinuteTour) {
            return true;
        }
        return false;

    }


    private function formatDate($date): string {
        $year = substr($date, 0, 4);
        $month = substr($date, 4, 2);
        $day = substr($date, 6, 2);

// Concatenate year, month, and day with hyphens
        return $year . '-' . $month . '-' . $day;

    }


    #region minPriceHotelByIdTourR
    private function minPriceHotelByIdTourR($id, $one_day_tour = false) {


        /** @var reservationTour $reservation_tour_controller */
        $reservation_tour_controller = Load::controller('reservationTour');


        if ($one_day_tour) {

            $sql = "
            SELECT
                id_same,change_price, adult_price_one_day_tour_r, adult_price_one_day_tour_a, currency_type_one_day_tour
            FROM
                reservation_tour_tb
            WHERE
                id = '{$id}'
            ";
            $result = $this->admin_controller->ConectDbClient($sql, $this->providers, "Select", "", "", "");


            $change_price = $reservation_tour_controller->doPriceChange($result['adult_price_one_day_tour_r'], $result['change_price']);


            $price = $this->calculateDiscount($result['id_same'], $change_price, 0);

            $min_price['price'] = round($price);

            $min_price['min_price_currency'] = $result['adult_price_one_day_tour_a'];

            $min_price['CurrencyTitleFa'] = $result['currency_type_one_day_tour'];


        } else {

            $sql = "
    SELECT
        T.change_price,
        P.id AS package_id,
      
        CASE
			
			WHEN P.double_room_price_r > 0 THEN
			P.double_room_price_r 
			WHEN P.single_room_price_r > 0 THEN
			P.single_room_price_r ELSE P.three_room_price_r 
		END 
		 AS min_price_r,
        CASE
            WHEN P.double_room_price_a > 0 THEN P.double_room_price_a
            WHEN P.single_room_price_r > 0 THEN P.single_room_price_a
            ELSE P.three_room_price_a
        END AS min_price_a,
        P.currency_type
    FROM
        reservation_tour_tb AS T
        LEFT JOIN reservation_tour_package_tb AS P ON T.id = P.fk_tour_id 
    WHERE 
        T.id = '{$id}'  AND P.is_del = 'no'
    ORDER BY min_price_r ASC
    
";


            $result = $this->admin_controller->ConectDbClient($sql, $this->providers, "Select", "", "", "");

            if ($result) {
                $change_price = $reservation_tour_controller->doPriceChange($result['min_price_r'], $result['change_price']);


                $price = $this->calculateDiscount($id, $change_price, $result['package_id']);


                $min_price['price'] = round($price);

                $min_price['price_currency'] = $result['min_price_a'];

                $min_price['Currency_title'] = $result['currency_type'];
            } else {
                $min_price['price'] = 0;

                $min_price['price_currency'] = 0;

                $min_price['Currency_title'] = '';

            }


        }

        return $min_price;
    }

    #endregion

    private function calculateDiscount($tour_id, $min_price, $package_id) {
        $sql = "SELECT adult_amount FROM reservation_tour_discount_tb WHERE tour_package_id='{$package_id}' AND tour_id='{$tour_id}' AND counter_type_id='5'";

        $discount = $this->admin_controller->ConectDbClient($sql, $this->providers, "Select", "", "", "");

        return $min_price - (!empty($discount['adult_amount']) ? $discount['adult_amount'] : 0);

    }

    /**
     * @param $tour_id
     * @author alizade
     * @date 4/29/2024
     * @time 4:33 PM
     */
    private function typeVehicles($tour_id): array {
        $sql_vehicle = "SELECT
                        reservation_tour_rout_tb.airline_id,
                        reservation_tour_rout_tb.type_vehicle_id,
                        reservation_tour_rout_tb.airline_name,
                        reservation_tour_rout_tb.type_vehicle_name,
                        reservation_tour_rout_tb.tour_title 
                    FROM
                        reservation_tour_tb
                        LEFT JOIN reservation_tour_rout_tb ON reservation_tour_rout_tb.fk_tour_id = reservation_tour_tb.id 
                    WHERE
                        reservation_tour_tb.id = '{$tour_id}' 
                    GROUP BY
                        reservation_tour_rout_tb.tour_title 
                    ORDER BY
                        reservation_tour_rout_tb.id,
                        reservation_tour_rout_tb.tour_title = 'dept' DESC";


        $result = $this->admin_controller->ConectDbClient($sql_vehicle, $this->providers, "SelectAll", "", "", "");

        $listTypeVehicle = [];
        foreach ($result as $val) {

            $listTypeVehicle[$val['tour_title']]['type_vehicle_name'] = $val['type_vehicle_name'];
            if ($val['type_vehicle_name'] !== 'هواپیما') {
                $sql = "SELECT id, name, name_en, pic, abbreviation, fk_id_type_of_vehicle FROM reservation_transport_companies_tb WHERE fk_id_type_of_vehicle='{$val['type_vehicle_id']}' AND is_del='no'";
                $vehicle = $this->admin_controller->ConectDbClient($sql, $this->providers, "Select", "", "", "");
            } else {
                $sql = "SELECT id, name, name_en, pic, abbreviation, fk_id_type_of_vehicle FROM airline_tb WHERE id='{$val['airline_id']}' AND is_del='no'";
                $vehicle = $this->admin_controller->ConectDbClient($sql, $this->providers, "Select", "", "", "");

            }
            $listTypeVehicle[$val['tour_title']]['vehicle'] = $vehicle;

            $listTypeVehicle[$val['tour_title']]['airline_name'] = $val['airline_name'];
            $listTypeVehicle[$val['tour_title']]['tour_title'] = ($val['tour_title'] == 'dept') ? 'رفت' : 'برگشت';
        }

        return $listTypeVehicle;
    }

    private function infoTourSuggestedByTourId($tourId, $cityId) {
        if (SOFTWARE_LANG === 'fa') {
            $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        } else {
            $dateNow = date("Ymd", time());
        }

        $WHERE = " AND T.start_date >= '{$dateNow}' ";

        if (is_array($tourId)) {

            $tourCount = count($tourId) - 1;
            $availableToursId = '(';
            foreach ($tourId as $k => $tourIdItem) {

                $availableToursId .= $tourIdItem . ($k === $tourCount ? ')' : ',');
            }
            $WHERE .= " AND T.id_same NOT IN {$availableToursId} ";
        } else {
            $WHERE .= " AND T.id_same != '{$tourId}' ";
        }

        $sql = " SELECT T.id , T.id_same,T.tour_name,T.tour_name_en,T.tour_type_id,
                        T.tour_code,T.start_date,T.end_date,T.night,T.`day`,T.tour_pic,
                        T.origin_continent_id,T.origin_country_id,T.is_show,T.is_special,T.is_del,
                        T.`language`,
                        T.origin_city_name,
                        T.origin_region_name,
                        T.origin_country_name,
                        TR.destination_country_name,
                        TR.destination_city_name,
                        TR.destination_region_name,
                        TR.airline_name,
                        TR.type_vehicle_name,
                        TR.exit_hours,
                        TR.airline_id,
                        TR.type_vehicle_id,
                        TR.tour_title,
                        TR.destination_country_id,
                        TR.id AS idRout
                        FROM reservation_tour_tb AS T
                        INNER JOIN reservation_tour_rout_tb AS TR ON T.id=TR.fk_tour_id
                        WHERE T.is_del = 'no'
                      AND T.is_show = 'yes' 
                      AND TR.tour_title='dept' 
                      AND T.suggested = '1' 
                      AND T.origin_city_id = '{$cityId}'
                    
                      {$WHERE}
                      GROUP BY T.tour_code
                      ORDER BY T.priority=0,T.priority ASC";

        return $this->admin_controller->ConectDbClient($sql, $this->providers, "SelectAll", "", "", "");
    }


    public function infoTourRoutByIdTour($id) {
        $sql = " SELECT TR.*,RC.name,RC.name_en,RCOUNTRY.name as country_name,RCOUNTRY.name_en as country_name_en FROM reservation_tour_rout_tb TR
                INNER JOIN reservation_city_tb RC ON TR.destination_city_id=RC.id
                INNER JOIN reservation_country_tb RCOUNTRY ON TR.destination_country_id=RCOUNTRY.id
                WHERE TR.fk_tour_id = '{$id}' AND TR.is_del = 'no'  ";
        $sql .= " ORDER BY TR.tour_title ";
        return $this->admin_controller->ConectDbClient($sql, $this->providers, "SelectAll", "", "", "");
    }

    /**
     * @param $tour_id
     * @return mixed
     * @author alizade
     * @date 4/30/2024
     * @time 11:19 AM
     */
    private function getTour($tour_id) {
        $sql = " SELECT T.*,RC.name,RC.name_en,RCOUNTRY.name as country_name,RCOUNTRY.name_en as country_name_en 
                 FROM reservation_tour_tb T
                INNER JOIN reservation_city_tb RC ON T.origin_city_id=RC.id
                INNER JOIN reservation_country_tb RCOUNTRY ON T.origin_country_id=RCOUNTRY.id
                                                                                 
                WHERE T.id = '{$tour_id}' AND T.is_del = 'no' ";

        return $this->admin_controller->ConectDbClient($sql, $this->providers, "Select", "", "", "");
    }

    private function listTourDates($tourCode, $one_day_tour = false) {
        $today = dateTimeSetting::jtoday('');
        $inner_join_Package = '';
        $has_package = '';
        $package_select='';
        if (!$one_day_tour) {
            $package_select = ",
                    TP.three_room_capacity,TP.double_room_capacity,TP.single_room_capacity,TP.child_with_bed_capacity,TP.infant_without_bed_capacity,TP.infant_without_chair_capacity,
                    TP.custom_room";
            $inner_join_Package = 'INNER JOIN reservation_tour_package_tb AS TP ON T.id =TP.fk_tour_id';
            $has_package = "AND TP.is_del='no' ";
        }
        $sql = " SELECT T.start_date,T.id, T.end_date, T.stop_time_reserve, TR.exit_hours {$package_select}
                 FROM 
                    reservation_tour_tb T
                    INNER JOIN reservation_tour_rout_tb AS TR ON T.id=TR.fk_tour_id
                 {$inner_join_Package}
                 WHERE 
                    T.start_date > '{$today}' 
                   AND T.tour_code = '{$tourCode}'
                   AND T.is_del='no'  
                     {$has_package}
                   AND T.is_show='yes'
                 GROUP BY T.start_date
                 LIMIT 0,10";

        $resultTours = $this->admin_controller->ConectDbClient($sql, $this->providers, "SelectAll", "", "", "");


        $result = [];
        foreach ($resultTours as $k => $val) {


            // اگر تاریخ و ساعت سرچ قبل از تاریخ ساعت حرکت بود نمایش بده //
            $result_isReserveByStopTime = functions::isReserveByStopTime($val['exit_hours'], $val['stop_time_reserve'], $val['start_date']);
            if ($result_isReserveByStopTime) {
                $result[$k]['id'] = $val['id'];
                $nameStartDate = $this->nameDay($val['start_date']);
                $nameEndDate = $this->nameDay($val['end_date']);

                $y = substr($val['start_date'], 0, 4);
                $m = substr($val['start_date'], 4, 2);
                $d = substr($val['start_date'], 6, 2);
                $result[$k]['startDate'] = $y . '/' . $m . '/' . $d;

                $result[$k]['startWeekdayName'] = $nameStartDate['name'];

                $y = substr($val['end_date'], 0, 4);
                $m = substr($val['end_date'], 4, 2);
                $d = substr($val['end_date'], 6, 2);
                $result[$k]['endDate'] = $y . '/' . $m . '/' . $d;
                $result[$k]['endWeekdayName'] = $nameEndDate['name'];
                if (!$one_day_tour) {
                    $result[$k]['capacity'] = $val['three_room_capacity'] + $val['double_room_capacity'] + $val['child_with_bed_capacity'] + $val['infant_without_bed_capacity'] + $val['infant_without_chair_capacity'];
                    if (isset($val['custom_room']) && !empty($val['custom_room'])) {
                        $room = json_decode($val['custom_room'], true);
                        if (count($room) > 0) {
                            foreach ($room as $single_room) {
                                $result[$k]['capacity'] += array_values($single_room)[0]['capacity'];
                            }
                        }
                    }
                    $result[$k]['pic'] = '';
                } else {
                    $result[$k]['capacity'] = 1;
                }

            }

        }

        return $result;
    }

    private function getTourGallery($tourId) {
        $sql = " SELECT * FROM reservation_tour_gallery_tb WHERE is_del = 'no' AND fk_tour_id_same='{$tourId}' ORDER BY id DESC";
        return $this->admin_controller->ConectDbClient($sql, $this->providers, "SelectAll", "", "", "");


    }


    private function nameDay($date) {
        if (strpos($date, '/')) {
            $date = str_replace("/", "", $date);
        } elseif (strpos($date, '-')) {
            $date = str_replace("-", "", $date);
        }

        $y = substr($date, 0, 4);
        $m = substr($date, 4, 2);
        $d = substr($date, 6, 2);


        if (SOFTWARE_LANG == 'fa') {

            $jmktime = dateTimeSetting::jmktime(0, 0, 0, $m, $d, $y);
            $nameDay = dateTimeSetting::jdate("w", $jmktime, "", "", "en");
            $name = dateTimeSetting::jdate("l", $jmktime, "", "", "en");
            switch ($nameDay) {
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
        } else {
            $jmktime = mktime(0, 0, 0, $m, $d, $y);
            $nameDay = date("w", $jmktime);
            $name = date("l", $jmktime);
        }

        $result['numberDay'] = $nameDay;
        $result['name'] = $name;

        return $result;

    }

    #region getTypeVehicle
    private function getTypeVehicle($tour_id) {

        $sql = "SELECT 
                  reservation_tour_rout_tb.airline_id, reservation_tour_rout_tb.type_vehicle_id, reservation_tour_rout_tb.airline_name, reservation_tour_rout_tb.type_vehicle_name, reservation_tour_rout_tb.tour_title 
                FROM 
                  reservation_tour_tb 
                LEFT JOIN 
                  reservation_tour_rout_tb ON reservation_tour_rout_tb.fk_tour_id =reservation_tour_tb.id  
                WHERE 
                  reservation_tour_tb.id = '{$tour_id}'  
                GROUP BY 
                  reservation_tour_rout_tb.tour_title  
                ORDER BY 
                  reservation_tour_rout_tb.id , reservation_tour_rout_tb.tour_title = 'dept' DESC ";
        $results = $this->admin_controller->ConectDbClient($sql, $this->providers, "SelectAll", "", "", "");

        $list_type_vehicle = [];
        foreach ($results as $val) {

            $listTypeVehicle[$val['tour_title']]['type_vehicle_name'] = $val['type_vehicle_name'];
            if ($val['type_vehicle_name'] !== 'هواپیما') {

                $sql = " SELECT 'id', 'name', 'name_en', 'pic', 'abbreviation','fk_id_type_of_vehicle' FROM reservation_transport_companies_tb WHERE fk_id_type_of_vehicle='{$val['type_vehicle_id']}' AND is_del='no'";
                $vehicle = $this->admin_controller->ConectDbClient($sql, $this->providers, "Select", "", "", "");

            } else {
                $sql = "SELECT FROM airline_tb WHERE id='{$val['airline_id']} AND del='no'";
                $vehicle = $this->admin_controller->ConectDbClient($sql, $this->providers, "Select", "", "", "");

            }


            $listTypeVehicle[$val['tour_title']]['airline_name'] = $val['airline_name'];
            $listTypeVehicle[$val['tour_title']]['tour_title'] = ($val['tour_title'] == 'dept') ? functions::Xmlinformation("Went")->__toString() : functions::Xmlinformation("Return")->__toString();
        }

        return $listTypeVehicle;
    }

    #endregion
    private function getTourRouteData($tour_id) {

        $sql_origin = "SELECT 
  reservation_city_tb.name as city_id, reservation_city_tb.name as city_name, reservation_city_tb.name_en as city_name_en, reservation_country_tb.id as country_id, reservation_country_tb.name as country_name, reservation_country_tb.name_en as country_name_en 
FROM 
  reservation_tour_tb 
INNER JOIN 
  reservation_city_tb ON reservation_city_tb.id =reservation_tour_tb.origin_city_id 
INNER JOIN 
  reservation_country_tb ON reservation_country_tb.id =reservation_tour_tb.origin_country_id  
WHERE 
  reservation_tour_tb.id = '{$tour_id}' ";

        $origin_route = $this->admin_controller->ConectDbClient($sql_origin, $this->providers, "Select", "", "", "");

        $sql_destination = "	
SELECT 
  reservation_tour_rout_tb.*, reservation_city_tb.name as city_id, reservation_city_tb.name as city_name, reservation_city_tb.name_en as city_name_en, reservation_country_tb.id as country_id, reservation_country_tb.name as country_name, reservation_country_tb.name_en as country_name_en 
FROM 
  reservation_tour_rout_tb 
INNER JOIN 
  reservation_city_tb ON reservation_city_tb.id =reservation_tour_rout_tb.destination_city_id 
INNER JOIN 
  reservation_country_tb ON reservation_country_tb.id =reservation_tour_rout_tb.destination_country_id  
WHERE 
  reservation_tour_rout_tb.fk_tour_id = '{$tour_id}'  
ORDER BY 
  reservation_tour_rout_tb.id asc ";

        $destination_route = $this->admin_controller->ConectDbClient($sql_destination, $this->providers, "SelectAll", "", "", "");


        $destinations = [];


        foreach ($destination_route as $route_key => $route) {

            $destinations[$route_key] = $route;
            if ($route['type_vehicle_name'] == 'هواپیما') {
                $airline_name = $this->getModel('airlineModel')->get()->where('id',$route['airline_id'])->find();
                $airline_name['icon'] = 'custom-plane-bg-svg';
                $airline_name['src'] = "http://safar360.com/gds/pic/airline/" . $airline_name['photo'];
            } else {
                $sql_airline_name = "SELECT 
  reservation_transport_companies_tb.id, reservation_transport_companies_tb.name, reservation_transport_companies_tb.name_en, reservation_transport_companies_tb.pic as logo, reservation_transport_companies_tb.pic as logo, reservation_type_of_vehicle_tb.name as vehicle_name, reservation_type_of_vehicle_tb.type as vehicle_type 
FROM 
  reservation_transport_companies_tb 
INNER JOIN 
  reservation_type_of_vehicle_tb ON reservation_type_of_vehicle_tb.id =reservation_transport_companies_tb.fk_id_type_of_vehicle  
WHERE 
  reservation_transport_companies_tb.id = '{$route['airline_id']}' ";

                $airline_name = $this->admin_controller->ConectDbClient($sql_airline_name, $this->providers, "Select", "", "", "");

                $airline_name['vehicle_name_en'] = functions::vehicleEnName($airline_name['vehicle_name']);
                $airline_name['vehicle_type_en'] = $airline_name['vehicle_type'];
                if ($airline_name['vehicle_type_en']) {
                    $airline_name['icon'] = 'custom-' . $airline_name['vehicle_type_en'] . '-bg-svg';
                } else {
                    $airline_name['icon'] = 'custom-' . $airline_name['vehicle_name_en'] . '-bg-svg';
                }

                $airline_name['src'] = ROOT_ADDRESS_WITHOUT_LANG . "/pic/" . $airline_name['logo'];

            }
            $destinations[$route_key]['vehicle'] = $airline_name;
        }


        return [
            'origin' => $origin_route,
            'destinations' => $destinations,
        ];
    }

    public function packages($content, $code=null) {

        if($content['one_day']){
            return $this->getOneDayPackage($content);
        }

        $start_date = $content['start_date'] ;
        $end_date = $content['end_date'] ;
        $string_start_date = str_replace(['/', '-', ' '], '', $content['start_date']);


        $sql = "SELECT 
  reservation_tour_tb.tour_code, reservation_tour_tb.start_date, reservation_tour_tb.change_price, reservation_tour_tb.discount_type, reservation_tour_tb.discount, reservation_tour_tb.prepayment_percentage, reservation_tour_tb.adult_price_one_day_tour_r, reservation_tour_tb.child_price_one_day_tour_r, reservation_tour_tb.infant_price_one_day_tour_r, reservation_tour_package_tb.* 
FROM 
  reservation_tour_package_tb 
INNER JOIN 
  reservation_tour_tb ON reservation_tour_tb.id =reservation_tour_package_tb.fk_tour_id 
INNER JOIN 
  reservation_tour_hotel_tb ON reservation_tour_hotel_tb.fk_tour_id =reservation_tour_tb.id  
WHERE 
  reservation_tour_tb.id = '{$content['tour_id']}'  
AND 
  reservation_tour_tb.start_date = '{$string_start_date}'  
AND 
  reservation_tour_tb.is_show = 'yes'  
AND 
  reservation_tour_tb.is_del = 'no'  
AND 
  reservation_tour_package_tb.is_del = 'no'  
GROUP BY 
  reservation_tour_package_tb.id 
ORDER BY 
  reservation_tour_package_tb.double_room_price_r DESC ";

        $packages = $this->admin_controller->ConectDbClient($sql, $this->providers, "SelectAll", "", "", "");

        $room_types = [
            "OneBed" => [
                'name' => (array)functions::Xmlinformation('OneBed')->__toString(),
                'packagePriceName' => 'single_room_price_r',
                'packageCurrencyPriceName' => 'single_room_price_a',
                'capacityValue' => 'single_room_capacity',
                'order'   => 1 ,
                'coefficient' => 1,
                'index' => 'oneBed',
                'type' => 'adult'],
            "TwoBed" => [
                'name' => (array)functions::Xmlinformation('TwoBed'),
                'packagePriceName' => 'double_room_price_r',
                'packageCurrencyPriceName' => 'double_room_price_a',
                'capacityValue' => 'double_room_capacity',
                'order'   => 2 ,
                'coefficient' => 2,
                'index' => 'twoBed',
                'type' => 'adult'],
            "ThreeBed" => [
                'name' => (array)functions::Xmlinformation('ThreeBed'),
                'packagePriceName' => 'three_room_price_r',
                'packageCurrencyPriceName' => 'three_room_price_a',
                'capacityValue' => 'three_room_capacity',
                'order'   => 3 ,
                'coefficient' => 3,
                'index' => 'threeBed',
                'type' => 'adult'],
            "Childwithbed" => [
                'name' => (array)functions::Xmlinformation('Childwithbed'),
                'packagePriceName' => 'child_with_bed_price_r',
                'packageCurrencyPriceName' => 'child_with_bed_price_a',
                'capacityValue' => 'child_with_bed_capacity',
                'order'   => 7 ,
                'coefficient' => 1,
                'index' => 'childwithbed',
                'type' => 'child'],
            "Babywithoutbed" => [
                'name' => (array)functions::Xmlinformation('Babywithoutbed'),
                'packagePriceName' => 'infant_without_bed_price_r',
                'packageCurrencyPriceName' => 'infant_without_bed_price_a',
                'capacityValue' => 'infant_without_bed_capacity',
                'order'   => 8 ,
                'coefficient' => 1,
                'index' => 'babywithoutbed',
                'type' => 'infant'],
            "Babywithoutchair" => [
                'name' => (array)functions::Xmlinformation('Babywithoutchair'),
                'packagePriceName' => 'infant_without_chair_price_r',
                'packageCurrencyPriceName' => 'infant_without_chair_price_a',
                'capacityValue' => 'infant_without_chair_capacity',
                'order'   => 9 ,
                'coefficient' => 1,
                'index' => 'babywithoutchair',
                'type' => 'infant']];


        foreach ($packages as $package_key => $package) {

            $hotels = $this->infoTourHotelByIdPackage($package['id']);

            foreach ($hotels as $hotel_key => $hotel) {
                $hotel_information = $this->getHotelInformation($hotel['fk_hotel_id']);
                $tour_route_information = $this->infoTourRoutByIdPackage($package['id'], $hotel['fk_city_id']);
                $packages[$package_key]['hotels'][$hotel_key] = $hotel_information;
                $packages[$package_key]['hotels'][$hotel_key]['night'] = $tour_route_information[0]['night'];
                $packages[$package_key]['hotels'][$hotel_key]['room_service'] = $tour_route_information[0]['room_service'];
            }

//            $packages[$package_key]['rooms']=$room_types;

            foreach ($room_types as $room_key => $room_type) {
                if (SOFTWARE_LANG == 'fa') {
                    $package_currency_name = $package['currency_type'];
                } else {
                    if ($package['currency_type']) {
                        $package_currency_name = functions::changeCurrencyName($package['currency_type']);
                    } else {
                        $package_currency_name = '';
                    }
                }
                $do_discount = $this->calculateDiscount($content['tour_id'], $package[$room_type['packagePriceName']], $package['id']);

                if (empty($do_discount['discountedMinPriceR'])) {
                    $price_change = $this->doPriceChange($package[$room_type['packagePriceName']], $package['change_price']);
                    if(functions::isEnableSetting('toman')) {
                        $final_price = round($price_change / 10) ;
                    }else{
                        $final_price = $price_change ;
                    }
                } else {
                    $price_change = $this->doPriceChange($do_discount['discountedMinPriceR'], $package['change_price']);
                    if(functions::isEnableSetting('toman')) {
                        $final_price = round($price_change / 10) ;
                    }else{
                        $final_price = $price_change ;
                    }

                }

                $prepaymentPercentageValue = $this->prePaymentCalculate($final_price, $package['prepayment_percentage']);


                if (number_format($package[$room_type['packageCurrencyPriceName']]) == 0) {
                    $package[$room_type['packageCurrencyPriceName']] = '';
                    $package_currency_name = '';
                } else {
                    $package[$room_type['packageCurrencyPriceName']] = intval($package[$room_type['packageCurrencyPriceName']]);
                }

                $show_price = intval($this->doPriceChange($package[$room_type['packagePriceName']], $package['change_price'])) ;
                if(functions::isEnableSetting('toman')) {
                    $price = round($show_price/10) ;
                }else{
                    $price = $show_price ;
                }
                $packages[$package_key]['rooms'][] = [
                    'name' => $room_type['name'][0],
                    'price' => $price,
                    'currency_price' => $package[$room_type['packageCurrencyPriceName']],
                    'currency_name' => $package_currency_name,
                    'coefficient' => $room_type['coefficient'],
                    'index' => $room_type['index'],
                    'order' => $room_type['order'],
                    'type' => $room_type['type'],
                    'final_price' => $final_price,
                    'capacity' => $package[$room_type['capacityValue']],
                ];


            }
            $custom_rooms = json_decode($packages[$package_key]['custom_room'], 256);

            if (isset($custom_rooms) && !empty($custom_rooms)) {

                if (SOFTWARE_LANG == 'fa') {
                    $package_currency_name = $package['currency_type'];
                } else {

                    if ($package['currency_type']) {
                        $package_currency_name = functions::changeCurrencyName($package['currency_type']);
                    } else {
                        $package_currency_name = '';
                    }
                }
                foreach ($custom_rooms as $room_key => $custom_room) {

                    $room_type = array_keys($custom_room)[0];

                    switch ($room_type) {
                        case 'fourRoom':
                            $number_bed = 4;
                            $index = 'fourBed';
                            $order = 4;
                            break;
                        case 'fiveRoom':
                            $number_bed = 5;
                            $index = 'fiveBed';
                            $order = 5;
                            break;
                        case 'sixRoom':
                            $number_bed = 6;
                            $index = 'sixBed';
                            $order = 6;
                            break;
                    }


                    $do_discount = ($this->calculateDiscount($content['tour_id'],  $custom_room[$room_type]['price_r'], $package['id'], $room_type));

                    if (empty($do_discount['discountedMinPriceR'])) {
                        $price_change = $this->doPriceChange($package[$room_type['packagePriceName']], $package['change_price']);
                        if(functions::isEnableSetting('toman')) {
                            $final_price = round($price_change/10) ;
                        }else{
                            $final_price = $price_change ;
                        }


                    } else {
                        $price_change = $this->doPriceChange($do_discount['discountedMinPriceR'], $package['change_price']);
                        if(functions::isEnableSetting('toman')) {
                            $final_price = round($price_change/10) ;
                        }else{
                            $final_price = $price_change ;
                        }
                    }

                    if ($custom_room[$room_type]['price_a'] == "") {
                        $package_currency_name = '';
                    }

                    $show_price =intval($this->doPriceChange($custom_room[$room_type]['price_r'], $package['change_price']));

                    if(functions::isEnableSetting('toman')) {
                        $price = round($show_price/10);
                    }else{
                        $price = $show_price;
                    }
                    $packages[$package_key]['rooms'][] = [

                        'name' => functions::Xmlinformation($room_type)->__toString(),
                        'price' => $price,
                        'currency_price' => $custom_room[$room_type]['price_a'],
                        'currency_name' => $package_currency_name,
                        'order' => $order,
                        'coefficient' => $number_bed,
                        'index' => $index,
                        'type' => 'adult',
                        'final_price' => $final_price,
                        'capacity' => $custom_room[$room_type]['capacity']
                    ];
                }


                usort($packages[$package_key]['rooms'], function($a, $b)
                {
                    if ($a["order"] == $b["order"])
                        return (0);
                    return (($a["order"] < $b["order"]) ? -1 : 1);
                });
            }



            $start_date = explode('/', functions::dateFormatSpecialJalali($content['start_date'], 'd/F/Y'));
            $start_date = ($start_date[0] > 9 ? $start_date[0] : str_replace('0', '', $start_date[0])) . '/' . $start_date[1] . '/' . $start_date[2];

            $end_date = explode('/', functions::dateFormatSpecialJalali($content['end_date'], 'd/F/Y'));
            $end_date = ($end_date[0] > 9 ? $end_date[0] : str_replace('0', '', $end_date[0])) . '/' . $end_date[1] . '/' . $end_date[2];

            $packages[$package_key]['start_date_human_string'] = $start_date;
            $packages[$package_key]['start_date_week'] = functions::dateFormatSpecialJalali($content['start_date'], 'l');
            $packages[$package_key]['end_date_human_string'] = $end_date;
            $packages[$package_key]['end_date_week'] = functions::dateFormatSpecialJalali($content['end_date'], 'l');
        }
//        array_values($packages);


        $sort_package = [];
        $array_have_value_package = [];
        $array_have_no_value_package = [];

        foreach ($packages as $key => $package) {

            if ($package['rooms'][1]['price'] > 0) {
                $sort_package['rooms'][1]['price'][$key] = $package['rooms'][1]['price'];
                $array_have_value_package[] = $package;
            } else {
                $array_have_no_value_package [] = $package;
            }
        }
        array_multisort($sort_package['rooms'][1]['price'], SORT_ASC, $array_have_value_package);

        if ($array_have_no_value_package) {
            $array_have_value_package = array_merge($array_have_value_package, $array_have_no_value_package);
        }
        return json_encode($array_have_value_package,256|64);
    }

    private function infoTourHotelByIdPackage($tour_package_id) {

        $sql="SELECT 
  reservation_tour_hotel_tb.*, reservation_city_tb.name, reservation_city_tb.name_en as city_name_en 
FROM 
  reservation_tour_hotel_tb 
INNER JOIN 
  reservation_city_tb ON reservation_city_tb.id =reservation_tour_hotel_tb.fk_city_id  
WHERE 
  reservation_tour_hotel_tb.fk_tour_package_id = '{$tour_package_id}'  
AND 
  reservation_tour_hotel_tb.is_del = 'no' ";

        return $this->admin_controller->ConectDbClient($sql, $this->providers, "SelectAll", "", "", "");
    }

    private function getHotelInformation($hotel_id) {
        $sql="SELECT 
  reservation_hotel_tb.id, reservation_hotel_tb.name, reservation_hotel_tb.name_en, reservation_hotel_tb.trip_advisor, reservation_hotel_tb.star_code, reservation_hotel_tb.logo, reservation_hotel_tb.region, reservation_hotel_tb.type_code, reservation_city_tb.name as city_name, reservation_city_tb.name_en as city_name_en 
FROM 
  reservation_hotel_tb 
INNER JOIN 
  reservation_city_tb ON reservation_city_tb.id =reservation_hotel_tb.city  
WHERE 
  reservation_hotel_tb.id = '{$hotel_id}' ";

        $hotel = $this->admin_controller->ConectDbClient($sql, $this->providers, "Select", "", "", "");

        $hotel['logo'] ='https://safar360.com/gds/pic/' . $hotel['logo'];


        $hotel['facilities'] = $this->getHotelFacilitiesById($hotel['id']);
        $hotel['gallery'] = $this->getHotelGalleryById($hotel['id']);
        if (empty($hotel['gallery']) && $hotel['logo']) {
            $hotel['gallery'] = [
                [
                    'pic_address' => $hotel['logo']
                ],
            ];
        }
        return $hotel;
    }


    private function getHotelFacilitiesById($hotel_id) {

        $sql="SELECT * FROM reservation_hotel_facilities_tb WHERE id_hotel='{$hotel_id}'";
        $hotel_facilities = $this->admin_controller->ConectDbClient($sql, $this->providers, "SelectAll", "", "", "");


        $facilities_id = [];
        foreach ($hotel_facilities as $facility) {
            $facilities_id[] = $facility['id_facilities'];
        }

        $implode_facilities = implode(',',$facilities_id);

        $sql="SELECT * FROM reservation_facilities_tb WHERE is_del='no' AND id IN ({$implode_facilities})";
        $hotel_facilities = $this->admin_controller->ConectDbClient($sql, $this->providers, "SelectAll", "", "", "");

        return $hotel_facilities ;

    }

    private function getHotelGalleryById($hotel_id) {
        $sql="SELECT * FROM reservation_facilities_tb WHERE is_del='no' AND id_hotel='{$hotel_id}'";
        $galleries = $this->admin_controller->ConectDbClient($sql, $this->providers, "SelectAll", "", "", "");

        $result = [];
        foreach ($galleries as $key => $item) {
            $result[$key] = $item;
            $result[$key]['pic_address'] = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . $item['pic'];
        }
        return $result;
    }

    private function doPriceChange($price, $price_change) {
        if ($price > 0) {
            return $price + $price_change;
        }
        return $price;
    }

    private function prePaymentCalculate( $price, $pre_payment_percentage )  {
        return (( $price * $pre_payment_percentage ) / 100);
    }

    private function infoTourRoutByIdPackage($PackageId, $CityId) {

        $sql = "SELECT
                    * 
                FROM
                    reservation_tour_hotel_tb AS TourHotel
                    LEFT JOIN reservation_tour_rout_tb AS Rout ON Rout.fk_tour_id = TourHotel.fk_tour_id
                WHERE
                    TourHotel.fk_tour_package_id = '{$PackageId}' 
                    AND Rout.destination_city_id = '{$CityId}'
                    AND TourHotel.fk_city_id = '{$CityId}'
                    AND TourHotel.is_del = 'no'
                    AND Rout.is_del = 'no'";
        return $this->admin_controller->ConectDbClient($sql, $this->providers, "SelectAll", "", "", "");
    }

    public function hotelsPackages($content) {

        $result_package = $this->infoTourHotelByIdPackage($content['package_id']);
        return json_encode($result_package,256);
    }

    public function informationsHotel($content) {
        $result_info = $this->getHotelInformation($content['hotel_id']);
        return json_encode($result_info,256);
    }

    public function tourRoutes($content) {
        $result_info = $this->infoTourRoutByIdPackage($content['package_id'],$content['city_id']);
        return json_encode($result_info,256);
    }


    public function infoTourByDate($content) {
        $start_date = str_replace('-', '', $content['start_date']);
        $start_date = str_replace('/', '', $content['start_date']);
        if ($content['type_tour'] == 'oneDayTour') {
            $sql = "SELECT reservation_tour_tb.* FROM reservation_tour_tb  WHERE start_date = '{$start_date}'  AND tour_code ='{$content['tour_code']}'   AND is_show = 'yes'  AND is_del = 'no' ";
            $tour_date =  $this->admin_controller->ConectDbClient($sql, $this->providers, "Select", "", "", "");

            return json_encode($tour_date,256);
        }

        $sql="SELECT reservation_tour_package_tb.* , reservation_tour_tb.*  FROM reservation_tour_tb 
                  LEFT JOIN reservation_tour_package_tb ON reservation_tour_package_tb.fk_tour_id =reservation_tour_tb.id 
                  LEFT JOIN reservation_tour_hotel_tb ON reservation_tour_hotel_tb.fk_tour_id =reservation_tour_tb.id  
                  WHERE reservation_tour_tb.start_date = '{$start_date}'  AND reservation_tour_tb.tour_code = '{$content['tour_code']}'  
                  AND reservation_tour_tb.is_show = 'yes'  AND reservation_tour_tb.is_del = 'no'  
                 AND reservation_tour_package_tb.is_del = 'no' ";
        $tour_date =  $this->admin_controller->ConectDbClient($sql, $this->providers, "Select", "", "", "");

        return json_encode($tour_date,256);
    }


    public function packageOfTour($content) {
        $sql   = "
            SELECT
                TP.*, H.*, T.change_price, T.discount_type, T.discount, discount.*,
                TP.id as packageId, H.id as packageHotelId 
            FROM
                reservation_tour_tb as T
                LEFT JOIN reservation_tour_package_tb as TP ON T.id=TP.fk_tour_id
                LEFT JOIN reservation_tour_hotel_tb as H ON TP.id=H.fk_tour_package_id
                LEFT JOIN reservation_tour_discount_tb as discount ON TP.id=discount.tour_package_id
            WHERE
                TP.id = '{$content['package_id']}' 
                AND TP.is_del = 'no'
            AND discount.counter_type_id = '5'
            GROUP BY H.id
            ";

        $tour_date =  $this->admin_controller->ConectDbClient($sql, $this->providers, "SelectAll", "", "", "");

        return json_encode($tour_date,256);
    }


    public function infoSpecialHotel( $content ) {
        $sql    = " SELECT
                    Hotel.name, Hotel.name_en, Hotel.trip_advisor, Hotel.star_code,
                    Hotel.logo, Hotel.region, Hotel.type_code,
                    Facilities.id_facilities As facilitiesId, Facilities.is_del AS is_del_facilities
                 FROM 
                    reservation_hotel_tb AS Hotel
                    LEFT JOIN reservation_hotel_facilities_tb AS Facilities ON Hotel.id = Facilities.id_hotel
                 WHERE Hotel.id={$content['hotel_id']} ";
        $result = $this->admin_controller->ConectDbClient($sql, $this->providers, "SelectAll", "", "", "");
        $hotel  = [];
        if ( ! empty( $result ) ) {
            $facilities = '';
            foreach ( $result as $k => $val ) {
                if ( $val['is_del_facilities'] == 'no' ) {
                    $facilities .= $val['facilitiesId'] . ',';
                }
            }
            $hotel['name']         = $result[0]['name'];
            $hotel['name_en']      = $result[0]['name_en'];
            $hotel['trip_advisor'] = $result[0]['trip_advisor'];
            $hotel['star_code']    = $result[0]['star_code'];
            $hotel['logo']         = $result[0]['logo'];
            $hotel['region']       = $result[0]['region'];
            $hotel['type_code']    = $result[0]['type_code'];
            $hotel['facilities']   = substr( $facilities, 0, - 1 );
        }
        return json_encode($hotel,256);
    }

    public function listTourTravelProgram( $content ) {

        $sql = " SELECT *  FROM  tourtravelprogram_tb  WHERE tour_id = '{$content['id_same']}'";
        $tourTravelProgram         = $this->admin_controller->ConectDbClient($sql, $this->providers, "Select", "", "", "");
        $data                      = $tourTravelProgram['data'];
        $tourTravelProgram['data'] = json_decode(preg_replace( "/\r\n|\r|\n/", '<br/>', $data ),true);
        foreach ($tourTravelProgram['data']['day'] as $key=>$days){
            foreach($days['gallery'] as $day_key => $gallery){
                if(!empty($gallery['file'])){
                    $tourTravelProgram['data']['day'][$key]['gallery'][$day_key]['file'] = str_replace($gallery['file'],'https://safar360.com/gds/pic/reservationTour/'.$gallery['file'],$gallery['file']) ;
                }
                if(!empty($gallery['file_hidden'])) {
                    $tourTravelProgram['data']['day'][$key]['gallery'][$day_key]['file_hidden'] =
                        str_replace($gallery['file_hidden'], 'https://safar360.com/gds/pic/reservationTour/' . $gallery['file_hidden'], $gallery['file_hidden']);
                }
            }

        }
        return json_encode($tourTravelProgram,256);
    }


    public function getInfoTour($content) {
        $sql = " SELECT T.*, TR.exit_hours
                 FROM 
                    reservation_tour_tb T
                    LEFT JOIN reservation_tour_rout_tb AS TR ON T.id=TR.fk_tour_id
                 WHERE 
                    T.id = '{$content['tour_id']}'
                 GROUP BY T.id";
        $getInfoTour         = $this->admin_controller->ConectDbClient($sql, $this->providers, "Select", "", "", "");
        $getInfoTour['client_id'] = $this->providers ;

        return json_encode($getInfoTour,256);
    }


    public function getInfoTourRoutByIdTour($content) {

        $result_tour = $this->infoTourRoutByIdTour($content['tour_id']);

        return json_encode($result_tour,256);
    }


    public function getTypeVehicleApi($content) {

        $vehicles = $this->typeVehicles($content['tour_id']);
        return json_encode($vehicles,256);
    }

    private function getOneDayPackage($content) {
        $sql = "SELECT reservation_tour_tb.* FROM reservation_tour_tb  WHERE id ='{$content['tour_id']}' ";
        $result_get_tour = $this->admin_controller->ConectDbClient($sql, $this->providers, "Select", "", "", "");

        $final_array = [];
        $room_types = [
            "OneBed" => [
                'name' => (array)functions::Xmlinformation('Adt'),
                'packagePriceName' => 'adult_price_one_day_tour_r',
                'packageCurrencyPriceName' => 'adult_price_one_day_tour_a',
                'coefficient' => 1,
                'type' => 'adult'
            ],
            "TwoBed" => [
                'name' => (array)functions::Xmlinformation('Chd'),
                'packagePriceName' => 'child_price_one_day_tour_r',
                'packageCurrencyPriceName' => 'child_price_one_day_tour_a',
                'coefficient' => 1,
                'type' => 'child'
            ],
            "ThreeBed" => [
                'name' => (array)functions::Xmlinformation('Inf'),
                'packagePriceName' => 'infant_price_one_day_tour_r',
                'packageCurrencyPriceName' => 'infant_price_one_day_tour_a',
                'coefficient' => 1,
                'type' => 'infant'
            ]
        ];


        $final_array[0]['hotels'] = [];

        foreach ($room_types as $room_key => $room_type) {

            $do_discount = ($this->calculateDiscount($result_get_tour['id'], $result_get_tour[$room_type['packagePriceName']], 0));

            if (empty($do_discount['discountedMinPriceR'])) {
                $final_price = $result_get_tour[$room_type['packagePriceName']] + $result_get_tour['change_price'];
            } else {
                $final_price = $do_discount['discountedMinPriceR'] + $result_get_tour['change_price'];
            }


            if ($result_get_tour[$room_type['packageCurrencyPriceName']] == 0) {
                $final_array[0][$room_type['packageCurrencyPriceName']] = '';
            } else {
                $final_array[0][$room_type['packageCurrencyPriceName']] = '+' . intval($result_get_tour[$room_type['packageCurrencyPriceName']]);

            }

            $final_array[0]['rooms'][] = [
                'name' => $room_type['name'][0],
                'price' => intval($result_get_tour[$room_type['packagePriceName']] + $result_get_tour['change_price']),
                'currency_price' => $final_array[0][$room_type['packageCurrencyPriceName']],
                'currency_name' => $result_get_tour['currency_type_one_day_tour'],
                'coefficient' => $room_type['coefficient'],
                'index' => isset($room_type['index']) ? $room_type['index'] : '',
                'type' => $room_type['type'],
                'final_price' => $final_price,
                'capacity' => 20,
            ];


            $final_array[0]['start_date_human_string'] = functions::dateFormatSpecialJalali($content['start_date'], 'd/F/Y');
            $final_array[0]['start_date_week'] = functions::dateFormatSpecialJalali($content['start_date'], 'l');
            $final_array[0]['end_date_human_string'] = functions::dateFormatSpecialJalali($content['end_date'], 'd/F/Y');
            $final_array[0]['end_date_week'] = functions::dateFormatSpecialJalali($content['end_date'], 'l');
        }

        return json_encode($final_array, 256);
    }

    public function getOriginCities($content) {

         $sql = "SELECT 
  reservation_tour_tb.id as tour_id, reservation_city_tb.id, reservation_city_tb.name, reservation_city_tb.name_en, reservation_city_tb.id_country, reservation_city_tb.abbreviation 
FROM 
  reservation_city_tb 
INNER JOIN 
  reservation_tour_rout_tb ON reservation_tour_rout_tb.destination_city_id =reservation_city_tb.id 
INNER JOIN 
  reservation_tour_tb ON reservation_tour_tb.id =reservation_tour_rout_tb.fk_tour_id  
WHERE 
  reservation_city_tb.id_country = '{$content['id_country']}'  
AND 
  reservation_tour_tb.origin_country_id = '{$content['origin_country_id']}'   
AND 
  reservation_tour_rout_tb.destination_country_id = '{$content['destination_country_id']}'  
AND 
  reservation_tour_tb.start_date > '{$content['start_date']}'  
AND 
  reservation_tour_rout_tb.tour_title = '{$content['tour_title']}'  
AND 
  reservation_tour_rout_tb.is_route_fake = '1'  
GROUP BY 
  reservation_city_tb.id 
ORDER BY  reservation_tour_tb.priority DESC " ;
            
        $cities = $this->admin_controller->ConectDbClient($sql, $this->providers, "SelectAll", "", "", "");

        return json_encode($cities,256|64);
    }


    public function getOriginCitiesExternal($content) {

        $origin_country = isset($content['id_country']) ? $content['id_country'] : '1';
         $sql = "SELECT 
  reservation_tour_tb.id as tour_id, reservation_city_tb.id, reservation_city_tb.name, reservation_city_tb.name_en, reservation_city_tb.id_country, reservation_city_tb.abbreviation, reservation_tour_rout_tb.destination_country_id 
FROM 
  reservation_city_tb 
INNER JOIN 
  reservation_tour_tb ON reservation_tour_tb.origin_city_id =reservation_city_tb.id 
INNER JOIN 
  reservation_tour_rout_tb ON reservation_tour_rout_tb.fk_tour_id =reservation_tour_tb.id  
WHERE 
  reservation_tour_tb.origin_country_id = '{$origin_country}'  
AND 
  reservation_tour_rout_tb.destination_country_id != '{$content['destination_country_id']}'  
AND 
  reservation_tour_tb.is_show = 'yes'  
AND 
  reservation_city_tb.is_del = 'no'  
AND 
  reservation_tour_tb.is_del = 'no'  
AND 
  reservation_tour_tb.start_date > '{$content['start_date']}'  
AND 
  reservation_tour_rout_tb.tour_title = '{$content['tour_title']}'  
GROUP BY 
  reservation_tour_tb.origin_city_id 
ORDER BY 
  reservation_tour_tb.priority DESC  
LIMIT 
  0,20 " ;

        $cities = $this->admin_controller->ConectDbClient($sql, $this->providers, "SelectAll", "", "", "");

        echo json_encode($cities,256|64); die();
    }

    public function getCountryDestination($content) {

        $origin_country = isset($content['origin_country_id']) ? $content['origin_country_id'] : '1';
        $sql = "
SELECT 
  reservation_country_tb.id, reservation_country_tb.name, reservation_country_tb.name_en, reservation_country_tb.abbreviation 
FROM 
  reservation_country_tb 
INNER JOIN 
  reservation_tour_rout_tb ON reservation_tour_rout_tb.destination_country_id =reservation_country_tb.id 
INNER JOIN 
  reservation_tour_tb ON reservation_tour_tb.id =reservation_tour_rout_tb.fk_tour_id 
INNER JOIN 
  reservation_city_tb ON reservation_city_tb.id =reservation_tour_tb.origin_city_id  
WHERE 
  reservation_tour_tb.origin_country_id = '{$origin_country}'  
AND 
  reservation_tour_rout_tb.destination_country_id != '{$content['destination_country_id']}'  
AND 
  reservation_tour_tb.is_show = 'yes'  
AND 
  reservation_city_tb.is_del = 'no'  
AND 
  reservation_tour_tb.is_del = 'no'  
AND 
  reservation_tour_tb.start_date > '{$content['start_date']}'  
AND 
  reservation_tour_tb.origin_city_id = '{$content['origin_city_id']}'  
GROUP BY 
  reservation_country_tb.id 
LIMIT 
  0,20 " ;

        $cities = $this->admin_controller->ConectDbClient($sql, $this->providers, "SelectAll", "", "", "");

        return json_encode($cities,256|64);
    }


    public function getCityDestinationExternal($content) {
        $sql="SELECT 
              reservation_city_tb.* 
            FROM 
              reservation_city_tb 
            INNER JOIN 
              reservation_tour_rout_tb ON reservation_tour_rout_tb.destination_city_id =reservation_city_tb.id 
            INNER JOIN 
              reservation_tour_tb ON reservation_tour_tb.id =reservation_tour_rout_tb.fk_tour_id  
            WHERE 
              reservation_city_tb.id_country = '{$content['id_country']}'  
            GROUP BY 
              reservation_city_tb.id 
            ORDER BY 
              reservation_tour_rout_tb.id DESC ";
        $cities = $this->admin_controller->ConectDbClient($sql, $this->providers, "SelectAll", "", "", "");

        return json_encode($cities,256|64);
    }


    public function getAllTypeTour($content) {
        $sql    = " SELECT * FROM reservation_tour_type_tb WHERE is_del = 'no' ";
        $cities = $this->admin_controller->ConectDbClient($sql, $this->providers, "SelectAll", "", "", "");

        return json_encode($cities,256|64);
    }
}

new ApiTour();