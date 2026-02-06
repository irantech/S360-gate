<?php

class mainTour extends clientAuth
{

    protected $tour_resource;
    protected $city_resource;
    protected $country_resource;
    public $counterId;
    public $IsLogin;


    public function __construct() {

        $this->IsLogin = Session::IsLogin();
        require_once('./resource/tourResource.php');
        $this->tour_resource = new tourResource();

        require_once('./resource/cityResource.php');
        $this->city_resource = new cityResource();

        require_once('./resource/cityCountryDataResource.php');
        $this->city_country_data_resource = new cityCountryDataResource();

        require_once('./resource/countryResource.php');
        $this->country_resource = new countryResource();

        if ( $this->IsLogin ) {
            $this->counterId  = functions::getCounterTypeId( $_SESSION['userId'] );
        } else {
            $this->counterId = '5';
        }
    }

    /**
     * @return bool|mixed|reservationVehicleModel
     */
    public function reservationTypeOfVehicleModel() {
        return Load::getModel(reservationTypeOfVehicleModel::class);
    }

    /**
     * @return bool|mixed|airlineClientModel
     */
    public function airlineClientModel() {
        return Load::getModel(airlineClientModel::class);
    }

    /**
     * @return bool|mixed|reservationTourRoutModel
     */
    public function reservationTourTypeModel() {
        return Load::getModel(reservationTourTypeModel::class);
    }

    /**
     * @param $data
     * {
     *  "className":"mainTour",
     *  "method":"getTourList",
     *  "special":"tes",
     *  "conditions":{
     *  "is_del":{
     *      "table":"reservation_tour_tb",
     *      "value":"no"
     *  },
     *  "language":{
     *      "table":"reservation_tour_tb",
     *      "value":"fa"
     *  }
     *  }
     * }
     * @return bool|mixed|string
     * @throws Exception
     */
    public function getTourList($data) {


        $tours = $this->getTour($data);


        if ($tours) {
            $tour_collection = $this->tour_resource->collection($tours);
            return functions::withSuccess($tour_collection, 200, 'successfully fetch');
        }

        return functions::withError(null, 200, 'not found');
    }

    public function getTour($data) {
        $reservation_tour_model = $this->reservationTourModel()->getTable();
        $reservation_tour_model = $this->reservationTourModel()->getTable();
        $reservation_tour_rout_model = $this->reservationTourRoutModel()->getTable();
        $reservation_city_model = $this->reservationCityModel()->getTable();
        $reservation_country_model = $this->reservationCountryModel()->getTable();
        $reservation_tour_package_model = $this->getModel('reservationTourPackageModel')->getTable();
        $getter = array(
            $reservation_tour_model . '.id',
            $reservation_tour_model . '.tour_name',
            $reservation_tour_model . '.tour_name_en',
            $reservation_tour_model . '.language',
            $reservation_tour_model . '.tour_pic',
            $reservation_tour_model . '.night',
            $reservation_tour_model . '.start_date',
            $reservation_tour_model . '.description',
            $reservation_city_model . '.name as origin_city_name',
            $reservation_city_model . '.name_en as origin_city_name_en',
            $reservation_country_model . '.name as origin_country_name',
            $reservation_country_model . '.name_en as origin_country_name_en',
            $reservation_tour_rout_model . '.destination_country_name',
            $reservation_tour_rout_model . '.destination_country_id',
            "min( $reservation_tour_package_model.double_room_price_r ) AS min_price_r",
        );

        $have_country_conditions['index'] = functions::array_filter_by_value($data['conditions'], 'index', 'id_country');
        $have_country_conditions['table'] = functions::array_filter_by_value($data['conditions'], 'table', $reservation_city_model);


        $have_city_conditions['index'] = functions::array_filter_by_value($data['conditions'], 'index', 'id');
        $have_city_conditions['table'] = functions::array_filter_by_value($data['conditions'], 'table', $reservation_city_model);


        if (($have_country_conditions['index'] && $have_country_conditions['table']) || ($have_city_conditions['index'] && $have_city_conditions['table'])) {

            $tours = $this->reservationCityModel()->get($getter, true);

            $tours->join($reservation_tour_model, 'origin_city_id', 'id', 'INNER');

        } else {

            $tours = $this->reservationTourModel()->get($getter, true);

        }
        $tours->join($reservation_tour_model, 'fk_tour_id', 'id', 'INNER', $reservation_tour_rout_model);
        $tours->join($reservation_tour_package_model, 'fk_tour_id', 'id', 'LEFT', $reservation_tour_package_model);
        $tours->joinSimple([$reservation_tour_model,$reservation_tour_model], 'ReservationCity.id', 'origin_city_id', 'INNER', [$reservation_city_model,'ReservationCity']);
        $tours->join($reservation_tour_model, 'id', 'origin_country_id', 'INNER', $reservation_country_model);


        $tour_condition = $this->conditions($data['conditions']);


        $tours->where($tour_condition);


        $tours->groupBy($reservation_tour_model . '.id_same');

        $tours->orderBy($reservation_tour_model . '.priority');


        $tours->limit(0, $data['limit']);
        $tours = $tours->all();


        // Fetch destinations for each tour
        foreach ($tours as &$tour) {
            $tour['destinations'] = $this->getTourDestinations($tour['id']);
            $tour['hotels'] = $this->getTourHotels($tour['id']);
        }

        return $tours;
    }

    /**
     * @return bool|mixed|reservationTourModel
     */
    public function reservationTourModel() {
        return Load::getModel('reservationTourModel');
    }

    /**
     * @return bool|mixed|reservationTourRoutModel
     */
    public function reservationTourRoutModel() {
        return Load::getModel('reservationTourRoutModel');
    }

    /**
     * @return bool|mixed|reservationCityModel
     */
    public function reservationCityModel() {
        return Load::getModel('reservationCityModel');
    }

    /**
     * @return bool|mixed|reservationCountryModel
     */
    public function reservationCountryModel() {
        return Load::getModel('reservationCountryModel');
    }

    /**
     * @param $conditions
     * @return array
     */
    public function conditions($conditions) {

        $new_condition = array();

        foreach ($conditions as $condition) {

            $table = '';
            if (empty($condition['operator'])) {
                $condition['operator'] = '=';
            }
            if (!empty($condition['table'])) {
                $table = $condition['table'] . '.';
            }
            $new_condition[] = array(
                'index' => $table . $condition['index'],
                'operator' => $condition['operator'],
                'value' => $condition['value'],
            );
        }

        return $new_condition;
    }

    public function getTourDestinations($tour_id) {
        $destinationModel = $this->reservationTourRoutModel()->getTable();
        $cityModel = $this->reservationCityModel()->getTable();
        $countryModel = $this->reservationCountryModel()->getTable();

        $getter = array(
            $countryModel . '.name as country_name',
            $cityModel . '.name as city_name',
            $destinationModel . '.night',
        );

        $TourDestinations = $this->reservationTourRoutModel()
            ->get($getter, true)
            ->join($destinationModel, 'id', 'destination_city_id', 'INNER', $cityModel)
            ->join($destinationModel, 'id', 'destination_country_id', 'INNER', $countryModel)
            ->where($destinationModel . '.fk_tour_id', $tour_id)
            ->all();

        return $TourDestinations;
    }

    public function getTourHotels($tour_id) {
        $hotelModel = $this->reservationHotelModel()->getTable();

        $tourHotelModel = $this->reservationTourHotelModel()->getTable();
        $destinationModel = $this->reservationTourRoutModel()->getTable();


        $getter = array(
            $hotelModel . '.star_code as star',
            $hotelModel . '.name',
            $hotelModel . '.name_en',
        );

        return $this->reservationHotelModel()
            ->get($getter, true)
            ->join($hotelModel, 'fk_hotel_id', 'id', 'INNER', $tourHotelModel)
//            ->join($hotelModel, 'id', 'fk_hotel_id', 'INNER', $destinationModel)
//            ->join($destinationModel, 'id', 'fk_hotel_id', 'INNER', $hotelModel)
//
//            ->join($hotelModel, 'id', 'fk_tour_id', 'INNER', $destinationModel)
//            ->join($destinationModel, 'id', 'fk_hotel_id', 'INNER', $hotelModel)
//
//            ->join($destinationModel, 'id', 'destination_country_id', 'INNER', $countryModel)
            ->where($tourHotelModel . '.fk_tour_id', $tour_id)
            ->all();
    }

    /**
     * @return bool|mixed|reservationHotelModel
     */
    public function reservationHotelModel() {
        return Load::getModel(reservationHotelModel::class);
    }

    /**
     * @return bool|mixed|reservationTourHotelModel
     */
    public function reservationTourHotelModel() {
        return Load::getModel(reservationTourHotelModel::class);
    }

    public function getTourList2($data)
    {
        $tours = $this->getTour2($data);

        if (empty($tours)) {
            return functions::withError(null, 200, 'not found');
        }

        $hotelStars   = array();
        $vehicleTypes = array();
        $vehicles     = array();
        $allPrices    = array();

        foreach ($tours as &$tour) {

            /* ===============================
               1. Internal / External
            =============================== */
            $isExternal = false;
            if (isset($tour['destination_country_id']) && (int)$tour['destination_country_id'] !== 1) {
                $isExternal = true;
            }

            /* ===============================
               2. Hotels (stars)
            =============================== */
            if (!empty($tour['hotels']) && is_array($tour['hotels'])) {
                foreach ($tour['hotels'] as $hotel) {
                    $star = isset($hotel['star']) ? (int)$hotel['star'] : 0;
                    if ($star > 0 && !in_array($star, $hotelStars, true)) {
                        $hotelStars[] = $star;
                    }
                }
            }

            /* ===============================
               3. Vehicles
            =============================== */
            if (!empty($tour['getTypeVehicle']) && is_array($tour['getTypeVehicle'])) {
                foreach ($tour['getTypeVehicle'] as $vehicle) {

                    if (!isset($vehicle['type_vehicle_name'])) {
                        continue;
                    }

                    $type = $vehicle['type_vehicle_name'];

                    if (!in_array($type, $vehicleTypes, true)) {
                        $vehicleTypes[] = $type;
                    }

                    $vehicleSelf = isset($vehicle['vehicle']) && is_array($vehicle['vehicle'])
                        ? $vehicle['vehicle']
                        : array();

                    $vehicleSelf['type'] = $type;

                    if (!in_array($vehicleSelf, $vehicles, true)) {
                        $vehicles[] = $vehicleSelf;
                    }
                }
            }

            /* ===============================
               4. Price calculation (per tour)
            =============================== */
            $tourPrices = array();

            if (!empty($tour['discount']) && is_array($tour['discount'])) {
                $discount = $tour['discount'];

                if (
                    isset($discount['discount']['adult_amount']) &&
                    (int)$discount['discount']['adult_amount'] > 0 &&
                    isset($discount['discount']['after_discount'])
                ) {
                    $tourPrices[] = (int)$discount['discount']['after_discount'];

                } elseif (isset($discount['minPriceR'])) {
                    $tourPrices[] = (int)$discount['minPriceR'];
                }
            }

            $lowestPrice  = !empty($tourPrices) ? min($tourPrices) : null;
            $highestPrice = !empty($tourPrices) ? max($tourPrices) : null;

            if ($lowestPrice !== null) {
                $allPrices[] = $lowestPrice;
            }

            /* ===============================
               5. PointClub
            =============================== */
            $serviceName = $isExternal
                ? 'PrivatePortalTour'
                : 'PrivateLocalTour';

            $tour['pointClub'] = functions::CalculatePoint(array(
                'service'     => $serviceName,
                'baseCompany' => 'all',
                'company'     => 'all',
                'counterId'   => $this->counterId,
                'price'       => $lowestPrice
            ));

        }

        unset($tour);


        /* ===============================
           6. Global filters
        =============================== */
        sort($hotelStars);
        sort($allPrices);

        $lowestPriceGlobal  = !empty($allPrices) ? min($allPrices) : null;
        $highestPriceGlobal = !empty($allPrices) ? max($allPrices) : null;

        $tourCollection = $this->tour_resource->collection($tours);

        return functions::withSuccess(array(
            'tours'   => $tourCollection,
            'filters' => array(
                'hotel_stars'   => $hotelStars,
                'vehicle_types' => $vehicleTypes,
                'vehicles'      => $vehicles,
                'prices'        => $allPrices,
                'lowest_price'  => $lowestPriceGlobal,
                'highest_price' => $highestPriceGlobal,
            )
        ), 200, 'successfully fetch');
    }



    public function getTour2($data) {


        $reservation_tour_model = $this->reservationTourModel()->getTable();
        $reservation_tour_model = $this->reservationTourModel()->getTable();
        $reservation_tour_rout_model = $this->reservationTourRoutModel()->getTable();
        $reservation_city_model = $this->reservationCityModel()->getTable();
        $reservation_country_model = $this->reservationCountryModel()->getTable();
        $reservation_tour_package_model = $this->getModel('reservationTourPackageModel')->getTable();

        $getter = array(
            $reservation_tour_model . '.id',
            $reservation_tour_model . '.id_same',
            $reservation_tour_model . '.tour_name',
            $reservation_tour_model . '.tour_name_en',
            $reservation_tour_model . '.language',
            $reservation_tour_model . '.tour_pic',
            $reservation_tour_model . '.night',
            $reservation_tour_model . '.start_date',
            $reservation_tour_model . '.description',
            $reservation_tour_model . '.tour_type_id',
            $reservation_city_model . '.name as origin_city_name',
            $reservation_city_model . '.name_en as origin_city_name_en',
            $reservation_country_model . '.name as origin_country_name',
            $reservation_country_model . '.name_en as origin_country_name_en',
            $reservation_tour_rout_model . '.destination_country_name',
            $reservation_tour_rout_model . '.destination_country_id',
            "min( $reservation_tour_package_model.double_room_price_r ) AS min_price_r",
        );


        $have_country_conditions['index'] = functions::array_filter_by_value($data['conditions'], 'index', 'id_country');
        $have_country_conditions['table'] = functions::array_filter_by_value($data['conditions'], 'table', $reservation_city_model);


        $have_city_conditions['index'] = functions::array_filter_by_value($data['conditions'], 'index', 'id');
        $have_city_conditions['table'] = functions::array_filter_by_value($data['conditions'], 'table', $reservation_city_model);


        if (($have_country_conditions['index'] && $have_country_conditions['table']) || ($have_city_conditions['index'] && $have_city_conditions['table'])) {

            $tours = $this->reservationCityModel()->get($getter, true);

            $tours->join($reservation_tour_model, 'origin_city_id', 'id', 'INNER');

        } else {

            $tours = $this->reservationTourModel()->get($getter, true);

        }
        $tours->join($reservation_tour_model, 'fk_tour_id', 'id', 'INNER', $reservation_tour_rout_model);
        $tours->join($reservation_tour_package_model, 'fk_tour_id', 'id', 'LEFT', $reservation_tour_package_model);
        $tours->join($reservation_tour_model, 'id', 'origin_city_id', 'INNER', $reservation_city_model);
        $tours->join($reservation_tour_model, 'id', 'origin_country_id', 'INNER', $reservation_country_model);

        $tour_condition = $this->conditions($data['conditions']);

        $tours->where($tour_condition);

        // Add complex condition for tour filtering
        $complexCondition = "
            (
                {$reservation_tour_model}.adult_price_one_day_tour_a = 0
                AND {$reservation_tour_rout_model}.is_route_fake = 1
            )
            OR
            (
                {$reservation_tour_model}.adult_price_one_day_tour_a != 0
                AND {$reservation_tour_rout_model}.is_route_fake = 1
                AND {$reservation_tour_rout_model}.night > 0
            )
        ";
        $tours->whereRaw($complexCondition);


        $tours->groupBy($reservation_tour_model . '.id_same');

        $tours->orderBy($reservation_tour_model . '.id');


        $tours->limit(0, $data['limit']);

        $tours = $tours->all(true , 'getTour2');

        // Fetch destinations for each tour
        /** @var resultTourLocal $resultTourLocal */
        $resultTourLocal = $this->getController(resultTourLocal::class);

        foreach ($tours as $key => $tour) {

            $tours[$key]['destinations'] = $this->getTourDestinations($tour['id']);
            $tours[$key]['hotels'] = $this->getTourHotels($tour['id']);
            $tours[$key]['getTypeVehicle'] = $resultTourLocal->getTypeVehicle($tour['id']);

            $arrayTourType = json_decode( $tour['tour_type_id'] );
            if ( in_array( '1', $arrayTourType ) ) {
                $oneDayTour = 'yes';
            } else {
                $oneDayTour = 'no';
            }
            $tours[$key]['discount'] = $resultTourLocal->minPriceHotelByIdTourR($tour['id'] , $oneDayTour);
        }


        return $tours;
    }

    public function callGetCountry($params) {
        $dateNow = dateTimeSetting::jdate("Ymd", "", "", "", "en");
        $origin_country_id = $params['origin_country_id'];
        $origin_city_id = $params['origin_city_id'];
        $destination_country_id = $params['destination_country_id'];
        $tour_title_type = $params['tour_title_type'];
        $tour_type = $params['type_id'];

        // means looking for destination cities
        $category_conditions = [];
        if ($origin_city_id && $origin_city_id !== 'all') {
            $category_conditions[] = [
                'index' => 'origin_city_id',
                'table' => 'reservation_tour_tb',
                'operator' => '=',
                'value' => $origin_city_id,
            ];
            $category_conditions[] = [
                'index' => 'tour_title',
                'table' => 'reservation_tour_rout_tb',
                'operator' => '=',
                'value' => 'dept'
            ];
        }

        $data['getters'] = [
            'reservation_city_tb.name as city_title',
            'reservation_city_tb.id as city_value',
            "'' as country_title",
            'reservation_city_tb.id_country as country_value',
        ];
        $data['group_by'] = 'reservation_country_tb.id';
        $data['conditions'] = [
            [
                'index' => 'id_country',
                'table' => 'reservation_city_tb',
                'operator' => '=',
                'value' => '1',
            ],
            [
                'index' => 'origin_country_id',
                'table' => 'reservation_tour_tb',
                'operator' => '=',
                'value' => '1',
            ],
            [
                'index' => 'language',
                'table' => 'reservation_tour_tb',
                'operator' => '=',
                'value' => SOFTWARE_LANG,
            ],
            [
                'index' => 'destination_country_id',
                'table' => 'reservation_tour_rout_tb',
                'operator' => '!=',
                'value' => '1',
            ],
            [
                'index' => 'tour_title',
                'table' => 'reservation_tour_rout_tb',
                'operator' => '=',
                'value' => 'dept',
            ],
            [
                'index' => 'is_show',
                'table' => 'reservation_tour_tb',
                'operator' => '=',
                'value' => 'yes',
            ],
            [
                'index' => 'is_del',
                'table' => 'reservation_city_tb',
                'operator' => '=',
                'value' => 'no',
            ],
            [
                'index' => 'start_date',
                'table' => 'reservation_tour_tb',
                'operator' => '>',
                'value' => $dateNow,
            ],


        ];
        if ($category_conditions) {
            $data['conditions'] = array_merge($data['conditions'], $category_conditions);
        }

        return $this->getCountry($data);

    }

    public function getCountry($data) {

        $reservation_tour_model = $this->reservationTourModel()->getTable();
        $reservation_tour_rout_model = $this->reservationTourRoutModel()->getTable();
        $reservation_city_model = $this->reservationCityModel()->getTable();
        $reservation_country_model = $this->reservationCountryModel()->getTable();


        $getter = array(
            $reservation_country_model . '.id',
            $reservation_country_model . '.name',
            $reservation_country_model . '.name_en',
            $reservation_country_model . '.abbreviation',
        );

        if (isset($data['getters']) && $data['getters']) {
            $getter = array_merge($getter, $data['getters']);
        }

        $group_by = $reservation_city_model . '.id';
        if (isset($data['group_by']) && $data['group_by']) {
            $group_by = $data['group_by'];
        }

        $order_by = $reservation_city_model . '.id';
        if (isset($data['order_by']) && $data['order_by']) {
            $order_by = $data['order_by'];
        }

        $limit = '20';
        if (isset($data['limit']) && $data['limit']) {
            $limit = $data['limit'];
        }


        $countries = $this->reservationCountryModel()->get($getter, true);

        $countries->join($reservation_tour_rout_model, 'destination_country_id', 'id', 'INNER');
        $countries->join($reservation_tour_rout_model, 'id', 'fk_tour_id', 'INNER', $reservation_tour_model);
        $countries->join($reservation_tour_model, 'id', 'origin_city_id', 'INNER', $reservation_city_model);

        $tour_condition = $this->conditions($data['conditions']);

        $countries->where($tour_condition);
        if (isset($data['searchLike']) && $data['searchLike']) {
            $countries->where($reservation_country_model . '.name', '%' . $data['searchLike'] . '%', 'like');
        }

        $countries->groupBy($group_by);
        $countries->limit(0, $limit);
//        if(CLIENT_ID == 166){
//            $countries = $countries->toSqlDie();
//        }


        $countries = $countries->all();


        $info_api = $this->getAccessTourWebService();

        if ($info_api) {


            $object_api = new tourApi($info_api);
            $conditions_tour = [];
            foreach ($tour_condition as $item) {
                switch ($item['index']) {
                    case 'reservation_city_tb.origin_country_id':
                        $conditions_tour['origin_country_id'] = $item['value'];
                        break;
                    case 'reservation_tour_rout_tb.destination_country_id' :
                        $conditions_tour['destination_country_id'] = $item['value'];
                        break;
                    case 'reservation_tour_tb.start_date' :
                        $conditions_tour['start_date'] = $item['value'];
                        break;
                    case 'reservation_tour_tb.origin_city_id' :
                        $conditions_tour['origin_city_id'] = $item['value'];
                        break;
                }

            }


            $api_countries = $object_api->getCountryDestination($conditions_tour);

        }


        if ($countries || (empty($countries) && !empty($api_countries))) {

            if (!isset($data['to_json'])) {

                if (isset($api_cities['status'])) {
                    if (empty($cities)) {
                        $countries = $api_countries;
                    } else {
                        $abbrevations = [];
                        foreach ($cities as $city) {
                            $abbrevations[] = $city['abbreviation'];
                        }
                        foreach ($api_countries as $item) {
                            if (!in_array($item['abbreviation'], $abbrevations)) {
                                $countries[] = $item;
                            }
                        }
                    }
                };
                $country_collection = $this->country_resource->collection($countries);
                return functions::withSuccess($country_collection, 200, 'successfully fetch');
            } else {

                $final_array = [];
                foreach ($countries as $country) {

                    $final_array[] = [
                        'city' => [
                            'title' => $country['city_title'],
                            'title_en' => $country['city_title_en'],
                            'value' => $country['city_value'],
                        ],
                        'country' => [
                            'title' => $country['country_title'],
                            'title_en' => $country['name_en'],
                            'value' => $country['country_value'],
                        ]
                    ];
                }

                return $final_array;
            }
        }

        return functions::withError(null, 200, 'not found');
    }

    public function getCityListByCountry($data) {

        $reservation_city_model = $this->reservationCityModel()->getTable();
        $reservation_tour_rout_model = $this->reservationTourRoutModel()->getTable();
        $reservation_country_model = $this->reservationCountryModel()->getTable();


        $getter = array(
            $reservation_city_model . '.id',
            $reservation_city_model . '.name',
            $reservation_city_model . '.name_en',
            $reservation_city_model . '.abbreviation',
        );


        if (isset($data['getters']) && $data['getters']) {
            $getter = array_merge($getter, $data['getters']);
        }

        $group_by = $reservation_city_model . '.id';
        if (isset($data['group_by']) && $data['group_by']) {
            $group_by = $data['group_by'];
        }

        $order_by = $reservation_city_model . '.id';
        if (isset($data['order_by']) && $data['order_by']) {
            $order_by = $data['order_by'];
        }

        $limit = '20';
        if (isset($data['limit']) && $data['limit']) {
            $limit = $data['limit'];
        }


        $cities = $this->reservationCityModel()->get($getter, true);

        $cities->join($reservation_tour_rout_model, 'destination_city_id', 'id', 'INNER');
        $cities->join($reservation_country_model, 'id', 'id_country', 'INNER');

        $tour_condition = $this->conditions($data['conditions']);

        $cities->where($tour_condition);
        if ($data['searchLike']) {
            $cities->where($reservation_city_model . '.name', '%' . $data['searchLike'] . '%', 'like');
        }
        $cities->groupBy($group_by);
        $cities->limit(0, $limit);
        $cities = $cities->all();


        if ($cities) {
            if (!$data['to_json']) {
                $city_collection = $this->city_resource->collection($cities);
                return functions::withSuccess($city_collection, 200, 'successfully fetch');
            } else {
                $final_array = [];
                foreach ($cities as $country) {
                    $final_array[] = [
                        'city' => [
                            'title' => $country['city_title'],
                            'title_en' => $country['city_title_en'],
                            'value' => $country['city_value'],
                        ],
                        'country' => [
                            'title' => $country['country_title'],
                            'title_en' => $country['name_en'],
                            'value' => $country['country_value'],
                        ]
                    ];
                }
                return $final_array;
            }
        }

        return functions::withError(null, 200, 'not found');
    }

    public function getInternalOriginCities() {
        $info_api = $this->getAccessTourWebService();

        $reservation_tour_model = $this->reservationTourModel()->getTable();
        $reservation_tour_rout_model = $this->reservationTourRoutModel()->getTable();
        $reservation_country_model = $this->reservationCountryModel()->getTable();
        $reservation_city_model = $this->reservationCityModel()->getTable();

        $getter = array(
            $reservation_tour_model . '.id as tour_id',
            $reservation_city_model . '.id',
            $reservation_city_model . '.name',
            $reservation_city_model . '.name_en',
            $reservation_city_model . '.id_country',
            $reservation_city_model . '.abbreviation',
        );

        if (isset($data['getters']) && $data['getters']) {
            $getter = array_merge($getter, $data['getters']);
        }

        $group_by = $reservation_city_model . '.id';
        if (isset($data['group_by']) && $data['group_by']) {
            $group_by = $data['group_by'];
        }

        $is_external = false;
        if (isset($data['is_external']) && $data['is_external']) {
            $is_external = true;
        }


        $have_country_conditions['index'] = functions::array_filter_by_value($data['conditions'], 'index', 'id_country');
        $have_country_conditions['table'] = functions::array_filter_by_value($data['conditions'], 'table', $reservation_city_model);
        $have_city_conditions['index'] = functions::array_filter_by_value($data['conditions'], 'index', 'id');
        $have_city_conditions['table'] = functions::array_filter_by_value($data['conditions'], 'table', $reservation_city_model);

        if (($have_country_conditions['index'] && $have_country_conditions['table']) || ($have_city_conditions['index'] && $have_city_conditions['table'])) {

            $cities = $this->reservationCityModel()->get($getter, true);
            $cities->join($reservation_tour_rout_model, 'destination_city_id', 'id', 'INNER');
            $cities->join($reservation_tour_rout_model, 'id', 'fk_tour_id', 'INNER', $reservation_tour_model);

        } else {

            $cities = $this->reservationTourModel()->get($getter, true);
            $cities->join($reservation_tour_model, 'fk_tour_id', 'id', 'INNER', $reservation_tour_rout_model);
            $cities->join($reservation_tour_rout_model, 'id', 'destination_city_id', 'INNER', $reservation_city_model);
        }

//        $cities->join($reservation_country_model, 'id', 'id_country', 'LEFT');
        $tour_condition = $this->conditions($data['conditions']);

        $cities->where($tour_condition);


        if (isset($data['searchLike']) && $data['searchLike']) {
            $cities->where($reservation_city_model . '.name', '%' . $data['searchLike'] . '%', 'like');
        }
        $cities->where($reservation_tour_rout_model . '.is_route_fake', '1', '=');

        $cities->groupBy($group_by);


        $cities->orderBy($reservation_tour_model . '.priority');


        if (isset($data['limit']) && $data['limit']) {
            $cities->limit(0, $data['limit']);
        }


        $cities = $cities->all();

        if ($info_api) {


            $object_api = new tourApi($info_api);
            $conditions_tour = [];
            foreach ($tour_condition as $item) {
                switch ($item['index']) {
                    case 'reservation_city_tb.id_country':
                        $conditions_tour['id_country'] = $item['value'];
                        break;
                    case 'reservation_tour_tb.origin_country_id' :
                        $conditions_tour['origin_country_id'] = $item['value'];
                        break;
                    case 'reservation_tour_rout_tb.destination_country_id' :
                        $conditions_tour['destination_country_id'] = $item['value'];
                        break;
                    case 'reservation_tour_tb.start_date' :
                        $conditions_tour['start_date'] = $item['value'];
                        break;
                    case 'reservation_tour_rout_tb.tour_title' :
                        $conditions_tour['tour_title'] = $item['value'];
                        break;
                }

            }
            $api_cities = $object_api->getOriginCity($conditions_tour);

        }


        if ($cities || (empty($cities) && !empty($api_cities))) {

            if (($have_country_conditions['index'] && $have_country_conditions['table']) ||
                ($have_city_conditions['index'] && $have_city_conditions['table'])) {

                $valid_cities = array();
                foreach ($cities as $city_key => $city) {


                    $tour_routs = $this->reservationTourRoutModel()->get(array(
                        $reservation_tour_rout_model . '.tour_title',
                        $reservation_tour_rout_model . '.destination_country_id',
                    ), true);
                    $tour_routs->where($reservation_tour_rout_model . '.fk_tour_id', $city['tour_id']);
                    if (reset($have_country_conditions['index'])['value']) {
                        $tour_routs->where($reservation_tour_rout_model . '.destination_country_id', reset($have_country_conditions['index'])['value']);
                    }

//                $tour_rout->where($reservation_tour_rout_model . '.destination_country_id',reset($have_country_conditions['index'])['value']);
                    $tour_routs = $tour_routs->all();


                    $result_tour_routs = false;
                    foreach ($tour_routs as $tour_rout) {

                        if ($tour_rout['destination_country_id'] == reset($have_country_conditions['index'])['value']) {
                            $result_tour_routs = $tour_rout;
                        } else {
                            $result_tour_routs = false;
                            break;
                        }
                    }

                    if (!$result_tour_routs) {
                        continue;
                    }

                    $valid_cities[$city_key] = $city;

                }

                $cities = $valid_cities;
            }


            if ($is_external) {
                $updated_cities = [];
                foreach ($cities as $key => $city) {
                    $updated_cities[$key] = $city;
                    $updated_cities[$key]['id'] = $city['origin_city_id'];
                    $updated_cities[$key]['name'] = $city['origin_name_fa'];
                    $updated_cities[$key]['name_en'] = $city['origin_name_en'];
                }
                $cities = $updated_cities;
            }

            if (isset($api_cities['status'])) {

                if (empty($cities)) {
                    $cities = $api_cities;
                } else {
                    $abbrevations = [];
                    foreach ($cities as $city) {
                        $abbrevations[] = $city['abbreviation'];
                    }
                    foreach ($api_cities as $item) {
                        if (!in_array($item['abbreviation'], $abbrevations)) {
                            $cities[] = $item;
                        }
                    }
                }
            };


            if (!isset($data['to_json'])) {


                $city_collection = $this->city_resource->collection($cities);

                return functions::withSuccess($city_collection, 200, 'successfully fetch');
            } else {

                $final_array = [];

                if ($data['type'] == 'pwa') {
                    foreach ($cities as $city) {

                        $final_array[] = [
                            'city' => [
                                'title' => $city['name'],
                                'title_en' => $city['name_en'],
                                'value' => $city['id'],
                            ]
                        ];
                    }
                } else {
                    foreach ($cities as $city) {

                        $final_array[] = [
                            'city' => [
                                'title' => $city['city_title'],
                                'title_en' => $city['name_en'],
                                'value' => $city['city_value'],
                            ],
                            'country' => [
                                'title' => $city['country_title'],
                                'value' => $city['country_value'],
                            ]
                        ];
                    }
                }


                return $final_array;
            }

        }

        return functions::withSuccess(null, 200, 'not found');
    }

    public function getCitiesByCategory($data, $origin_city_id = null) {
        $reservation_city = $this->getModel('reservationCityModel');
        $reservation_tour = $this->getModel('reservationTourModel');
        $reservation_tour_rout = $this->getModel('reservationTourRoutModel');
        $cities = $reservation_city->get($reservation_city->getTable() . '.*', true)
            ->join($reservation_tour->getTable(), 'origin_city_id', 'id', 'INNER')
            ->where($reservation_tour->getTable() . '.tour_type_id', '%' . '2' . '%', 'like')
            ->all();


    }

    public function getTourTypeList() {


        $reservationTourTypeModel = $this->getModel('reservationTourTypeModel');
        $getter = array(
            $reservationTourTypeModel->getTable() . '.id',
            $reservationTourTypeModel->getTable() . '.tour_type',
        );
        $tour_type_list = $reservationTourTypeModel->get($getter, true)->where('is_del', 'no')->all();

        if ($tour_type_list) {
            return functions::withSuccess($tour_type_list, 200, 'successfully fetch');
        }
        return functions::withError(null, 200, 'not found');
    }

    public function getInternalTourCities($params = null) {


        $dateNow = dateTimeSetting::jdate("Ymd", "", "", "", "en");

        $origin_country_id = $params['origin_country_id'];
        $origin_city_id = $params['origin_city_id'];
        $destination_country_id = $params['destination_country_id'];
        $tour_title_type = $params['tour_title_type'];
        $tour_type = $params['type_id'];

        // means looking for destination cities
        $category_conditions = [];
        if ($origin_city_id) {
            $category_conditions[] = [
                'index' => 'origin_city_id',
                'table' => 'reservation_tour_tb',
                'operator' => '=',
                'value' => $origin_city_id,
            ];
            $category_conditions[] = [
                'index' => 'tour_title',
                'table' => 'reservation_tour_rout_tb',
                'operator' => '=',
                'value' => 'dept'
            ];
        } else {

        }


        $conditions['conditions'] = [
            [
                'index' => 'id_country',
                'table' => 'reservation_city_tb',
                'operator' => '=',
                'value' => '1',
            ],
            [
                'index' => 'origin_country_id',
                'table' => 'reservation_tour_tb',
                'operator' => '=',
                'value' => '1',
            ],
            [
                'index' => 'destination_country_id',
                'table' => 'reservation_tour_rout_tb',
                'operator' => '=',
                'value' => '1',
            ],
            [
                'index' => 'tour_title',
                'table' => 'reservation_tour_rout_tb',
                'operator' => '=',
                'value' => 'dept',
            ],
            [
                'index' => 'is_show',
                'table' => 'reservation_tour_tb',
                'operator' => '=',
                'value' => 'yes',
            ],
            [
                'index' => 'is_del',
                'table' => 'reservation_city_tb',
                'operator' => '=',
                'value' => 'no',
            ],
            [
                'index' => 'start_date',
                'table' => 'reservation_tour_tb',
                'operator' => '>',
                'value' => $dateNow,
            ],


        ];


        if (isset($params['type_id']) && $params['type_id']) {
            $category_operator = 'like';
            if (isset($params['like_category']) && $params['like_category'] == 'no') {
                $category_operator = 'not like';
            }

            $category_conditions [] =
                [
                    'index' => 'tour_type_id',
                    'table' => 'reservation_tour_tb',
                    'operator' => $category_operator,
                    'value' => '%"' . $params['category_id'] . '"%'
                ];

        }

        if ($category_conditions) {
            $conditions['conditions'] = array_merge($conditions['conditions'], $category_conditions);
        }


        if (isset($params['to_json'])) {
            $conditions['to_json'] = false;
            $conditions['type'] = 'pwa';
        }
        if (isset($params['get_origin'])) {
            $conditions['get_origin'] = true;
        }
        if (isset($params['tour_type_title'])) {
            $conditions['tour_type_title'] = $params['tour_type_title'];
        }

        if (isset($params['get_init_data'])) {
            /** @var resultTourLocal $resultTourLocal */
            $resultTourLocal = $this->getController(resultTourLocal::class);
            $cities = $this->getCityList($conditions);
            $cities_array = [];
            foreach ($cities as $key => $city) {
                $cities_array[$key] = $city['city'];
            }
            return [
                'types' => $resultTourLocal->getTourTypes(),
                'cities' => $cities_array
            ];
        }
        return $this->getCityList($conditions);
    }

    public function getCityList($data) {

        $info_api = $this->getAccessTourWebService();


        $reservation_tour_model = $this->reservationTourModel()->getTable();
        $reservation_tour_rout_model = $this->reservationTourRoutModel()->getTable();
        $reservation_country_model = $this->reservationCountryModel()->getTable();
        $reservation_city_model = $this->reservationCityModel()->getTable();

        $getter = array(
            $reservation_tour_model . '.id as tour_id',
            $reservation_city_model . '.id',
            $reservation_city_model . '.name',
            $reservation_city_model . '.name_en',
            $reservation_city_model . '.id_country',
            $reservation_city_model . '.abbreviation',
        );

        if (isset($data['getters']) && $data['getters']) {
            $getter = array_merge($getter, $data['getters']);
        }

        $group_by = $reservation_city_model . '.id';
        if (isset($data['group_by']) && $data['group_by']) {
            $group_by = $data['group_by'];
        }

        $is_external = false;
        if (isset($data['is_external']) && $data['is_external']) {
            $is_external = true;
        }


//        if (isset($data['get_origin']) && $data['get_origin']) {

        $have_country_conditions['index'] = functions::array_filter_by_value($data['conditions'], 'index', 'id_country');
        $have_country_conditions['table'] = functions::array_filter_by_value($data['conditions'], 'table', $reservation_city_model);
        $have_city_conditions['index'] = functions::array_filter_by_value($data['conditions'], 'index', 'id');
        $have_city_conditions['table'] = functions::array_filter_by_value($data['conditions'], 'table', $reservation_city_model);

        if (isset($data['get_origin']) && $data['get_origin'] && (($have_country_conditions['index'] && $have_country_conditions['table']) || ($have_city_conditions['index'] && $have_city_conditions['table']) )) {
            $cities = $this->reservationCityModel()->get($getter, true);
            $cities->join($reservation_tour_model, 'origin_city_id', 'id', 'INNER');
            $cities->join($reservation_tour_model, 'fk_tour_id', 'id', 'INNER', $reservation_tour_rout_model);
        } else {
            $cities = $this->reservationTourModel()->get($getter, true);
            $cities->join($reservation_tour_model, 'fk_tour_id', 'id', 'INNER', $reservation_tour_rout_model);
            $cities->join($reservation_tour_rout_model, 'id', 'destination_city_id', 'INNER', $reservation_city_model);
        }
//        } else {
//
//            $have_country_conditions['index'] = functions::array_filter_by_value($data['conditions'], 'index', 'id_country');
//            $have_country_conditions['table'] = functions::array_filter_by_value($data['conditions'], 'table', $reservation_city_model);
//            $have_city_conditions['index'] = functions::array_filter_by_value($data['conditions'], 'index', 'id');
//            $have_city_conditions['table'] = functions::array_filter_by_value($data['conditions'], 'table', $reservation_city_model);
//
//            if (($have_country_conditions['index'] && $have_country_conditions['table']) || ($have_city_conditions['index'] && $have_city_conditions['table'])) {
//                $cities = $this->reservationCityModel()->get($getter, true);
//                $cities->join($reservation_tour_model, 'origin_city_id', 'id', 'INNER');
//                $cities->join($reservation_tour_model, 'fk_tour_id', 'id', 'INNER', $reservation_tour_rout_model);
//            } else {
//                $cities = $this->reservationTourModel()->get($getter, true);
//                $cities->join($reservation_tour_model, 'fk_tour_id', 'id', 'INNER', $reservation_tour_rout_model);
//                $cities->join($reservation_tour_rout_model, 'id', 'destination_city_id', 'INNER', $reservation_city_model);
//            }
//        }

//        $cities->join($reservation_country_model, 'id', 'id_country', 'LEFT');

        $tour_condition = $this->conditions($data['conditions']);

        $cities->where($tour_condition);


        if (isset($data['searchLike']) && $data['searchLike']) {
            $cities->where($reservation_city_model . '.name', '%' . $data['searchLike'] . '%', 'like');
        }
        $cities->where($reservation_tour_rout_model . '.is_route_fake', '1', '=');

        $cities->groupBy($group_by);


        $cities->orderBy($reservation_tour_model . '.priority');


        if (isset($data['limit']) && $data['limit']) {
            $cities->limit(0, $data['limit']);
        }


        if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
//            $cities = $cities->toSqlDie();

        }

        $cities = $cities->all();


        if ($info_api) {


            $object_api = new tourApi($info_api);
            $conditions_tour = [];
            foreach ($tour_condition as $item) {
                switch ($item['index']) {
                    case 'reservation_city_tb.id_country':
                        $conditions_tour['id_country'] = $item['value'];
                        break;
                    case 'reservation_tour_tb.origin_country_id' :
                        $conditions_tour['origin_country_id'] = $item['value'];
                        break;
                    case 'reservation_tour_rout_tb.destination_country_id' :
                        $conditions_tour['destination_country_id'] = $item['value'];
                        break;
                    case 'reservation_tour_tb.start_date' :
                        $conditions_tour['start_date'] = $item['value'];
                        break;
                    case 'reservation_tour_rout_tb.tour_title' :
                        $conditions_tour['tour_title'] = $item['value'];
                        break;
                }

            }
            $api_cities = $object_api->getOriginCity($conditions_tour);

        }



        if ($cities || (empty($cities) && !empty($api_cities))) {

            if (($have_country_conditions['index'] && $have_country_conditions['table']) ||
                ($have_city_conditions['index'] && $have_city_conditions['table'])) {

                $valid_cities = array();
                foreach ($cities as $city_key => $city) {


                    $tour_routs = $this->reservationTourRoutModel()->get(array(
                        $reservation_tour_rout_model . '.tour_title',
                        $reservation_tour_rout_model . '.destination_country_id',
                    ), true);
                    $tour_routs->where($reservation_tour_rout_model . '.fk_tour_id', $city['tour_id']);
                    if (reset($have_country_conditions['index'])['value']) {
                        $tour_routs->where($reservation_tour_rout_model . '.destination_country_id', reset($have_country_conditions['index'])['value']);
                    }

//                $tour_rout->where($reservation_tour_rout_model . '.destination_country_id',reset($have_country_conditions['index'])['value']);
                    $tour_routs = $tour_routs->all();


                    $result_tour_routs = false;
                    foreach ($tour_routs as $tour_rout) {

                        if ($tour_rout['destination_country_id'] == reset($have_country_conditions['index'])['value']) {
                            $result_tour_routs = $tour_rout;
                        } else {
                            $result_tour_routs = false;
                            break;
                        }
                    }

                    if (!$result_tour_routs) {
                        continue;
                    }

                    $valid_cities[$city_key] = $city;

                }

                $cities = $valid_cities;
            }


            if ($is_external) {
                $updated_cities = [];
                foreach ($cities as $key => $city) {
                    $updated_cities[$key] = $city;
                    $updated_cities[$key]['id'] = $city['origin_city_id'];
                    $updated_cities[$key]['name'] = $city['origin_name_fa'];
                    $updated_cities[$key]['name_en'] = $city['origin_name_en'];
                }
                $cities = $updated_cities;
            }

            if (isset($api_cities['status'])) {

                if (empty($cities)) {
                    $cities = $api_cities;
                } else {
                    $abbrevations = [];
                    foreach ($cities as $city) {
                        $abbrevations[] = $city['abbreviation'];
                    }
                    foreach ($api_cities as $item) {
                        if (!in_array($item['abbreviation'], $abbrevations)) {
                            $cities[] = $item;
                        }
                    }
                }
            };


            if (!isset($data['to_json'])) {


                $city_collection = $this->city_resource->collection($cities);

                return functions::withSuccess($city_collection, 200, 'successfully fetch');
            } else {

                $final_array = [];

                if ($data['type'] == 'pwa') {

                    $city_collection = $this->city_resource->collection($cities);

                    foreach ($city_collection as $city) {

                        $final_array[] = [
                            'city' => [
                                'title' => $city['name'],
                                'title_en' => $city['name_en'],
                                'value' => $city['id'],
                            ]
                        ];
                    }

                } else {

                    foreach ($cities as $city) {

                        $final_array[] = [
                            'city' => [
                                'title' => $city['city_title'],
                                'title_en' => $city['name_en'],
                                'value' => $city['city_value'],
                            ],
                            'country' => [
                                'title' => $city['country_title'],
                                'value' => $city['country_value'],
                            ]
                        ];
                    }
                }

                return $final_array;
            }

        }

        return functions::withSuccess(null, 200, 'not found');
    }

    public function getInternationalTourCities($params = null) {


        $dateNow = dateTimeSetting::jdate("Ymd", "", "", "", "en");
        $software_lang = SOFTWARE_LANG;
        $origin_country_id = $params['origin_country_id'];
        $origin_city_id = $params['origin_city_id'];
        $destination_country_id = $params['destination_country_id'];
        $tour_title_type = $params['tour_title_type'];
        $tour_type = $params['type_id'];
        $is_init = $params['get_init_data'];

        // means looking for destination cities
        $category_conditions = [];
        if ($origin_city_id) {
            if($origin_city_id != 'all') {
                $category_conditions[] = [
                    'index' => 'origin_city_id',
                    'table' => 'reservation_tour_tb',
                    'operator' => '=',
                    'value' => $origin_city_id,
                ];
            }

            $category_conditions[] = [
                'index' => 'tour_title',
                'table' => 'reservation_tour_rout_tb',
                'operator' => '=',
                'value' => 'dept'
            ];
        }
        if ($is_init) {
            $category_conditions[] = [
                'index' => 'destination_country_id',
                'table' => 'reservation_tour_rout_tb',
                'operator' => '!=',
                'value' => '1',
            ];

        }
        if ($destination_country_id) {
            if ($destination_country_id !== 'all') {

                $category_conditions[] = [
                    'index' => 'destination_country_id',
                    'table' => 'reservation_tour_rout_tb',
                    'operator' => '=',
                    'value' => $destination_country_id,
                ];
            }else {
                $category_conditions[] = [
                    'index' => 'destination_country_id',
                    'table' => 'reservation_tour_rout_tb',
                    'operator' => '!=',
                    'value' => '1',
                ];
            }
            $category_conditions[] = [
                'index' => 'tour_title',
                'table' => 'reservation_tour_rout_tb',
                'operator' => '=',
                'value' => 'dept'
            ];
        } else {
            $category_conditions[] = [
                'index' => 'id_country',
                'table' => 'reservation_city_tb',
                'operator' => '=',
                'value' => '1',
            ];
        }


        $conditions['conditions'] = [

            [
                'index' => 'origin_country_id',
                'table' => 'reservation_tour_tb',
                'operator' => '=',
                'value' => '1',
            ],

            [
                'index' => 'tour_title',
                'table' => 'reservation_tour_rout_tb',
                'operator' => '=',
                'value' => 'dept',
            ],
            [
                'index' => 'is_show',
                'table' => 'reservation_tour_tb',
                'operator' => '=',
                'value' => 'yes',
            ],
            [
                'index' => 'is_del',
                'table' => 'reservation_city_tb',
                'operator' => '=',
                'value' => 'no',
            ],
            [
                'index' => 'start_date',
                'table' => 'reservation_tour_tb',
                'operator' => '>',
                'value' => $dateNow,
            ],
            [
                'index' => 'language',
                'table' => 'reservation_tour_tb',
                'operator' => '=',
                'value' => $software_lang,
            ],

        ];


        if (isset($params['type_id']) && $params['type_id']) {
            $category_operator = 'like';
            if (isset($params['like_category']) && $params['like_category'] == 'no') {
                $category_operator = 'not like';
            }

            $category_conditions [] =
                [
                    'index' => 'tour_type_id',
                    'table' => 'reservation_tour_tb',
                    'operator' => $category_operator,
                    'value' => '%"' . $params['category_id'] . '"%'
                ];

        }

        if ($category_conditions) {
            $conditions['conditions'] = array_merge($conditions['conditions'], $category_conditions);
        }


        if (isset($params['to_json'])) {
            $conditions['to_json'] = false;
            $conditions['type'] = 'pwa';
        }
        if (isset($params['get_origin'])) {
            $conditions['get_origin'] = true;
        }
        if (isset($params['tour_type_title'])) {
            $conditions['tour_type_title'] = $params['tour_type_title'];
        }

        if (isset($params['get_init_data'])) {
            /** @var resultTourLocal $resultTourLocal */
            $resultTourLocal = $this->getController(resultTourLocal::class);
            $cities = $this->getCityList($conditions);
            $cities_array = [];
            foreach ($cities as $key => $city) {
                $cities_array[$key] = $city['city'];
            }
            return [
                'types' => $resultTourLocal->getTourTypes(),
                'cities' => $cities_array
            ];
        }

        return $this->getCityList($conditions);
    }

    public function getTourCities($params = null) {


        $dateNow = dateTimeSetting::jdate("Ymd", "", "", "", "en");
        $additional_case = [];
        if (isset($params['city_id']) && $params['city_id']) {

            $from_city_conditional = array(
                'index' => 'origin_city_id',
                'table' => 'reservation_tour_tb',
                'operator' => '=',
                'value' => $params['city_id'],
            );

            $additional_case = array(
                'index' => 'tour_title',
                'table' => 'reservation_tour_rout_tb',
                'operator' => '=',
                'value' => 'dept',
            );
            $from_city_conditional = array_merge($additional_case, $from_city_conditional);

        } else {
            $from_city_conditional = array(
                'index' => 'tour_title',
                'table' => 'reservation_tour_rout_tb',
                'operator' => '=',
                'value' => 'dept',

            );

            if (isset($params['type']) && $params['type'] == 'international') {
                $from_city_conditional = array(
                    'index' => 'tour_title',
                    'table' => 'reservation_tour_rout_tb',
                    'operator' => '=',
                    'value' => 'dept'
                );
            }
        }

        $conditions['conditions'] = array(
            array(
                'index' => 'id_country',
                'table' => 'reservation_city_tb',
                'operator' => '=',
                'value' => '1',
            ),
            array(
                'index' => 'origin_country_id',
                'table' => 'reservation_tour_tb',
                'operator' => '=',
                'value' => '1',
            ),
            array(
                'index' => 'destination_country_id',
                'table' => 'reservation_tour_rout_tb',
                'operator' => '=',
                'value' => '1',
            ),
            array(
                'index' => 'is_show',
                'table' => 'reservation_tour_tb',
                'operator' => '=',
                'value' => 'yes',
            ),
            array(
                'index' => 'is_del',
                'table' => 'reservation_city_tb',
                'operator' => '=',
                'value' => 'no',
            ),
            array(
                'index' => 'start_date',
                'table' => 'reservation_tour_tb',
                'operator' => '>',
                'value' => $dateNow,
            ),
            $from_city_conditional

        );
        if ($additional_case) {
            $conditions['conditions'][] = $additional_case;
        }


        $category_conditions = array();
        if (isset($params['category_id']) && $params['category_id']) {
            $category_operator = 'like';
            if (isset($params['like_category']) && $params['like_category'] == 'no') {
                $category_operator = 'not like';
            }

            $category_conditions = array(
                array(
                    'index' => 'tour_type_id',
                    'table' => 'reservation_tour_tb',
                    'operator' => $category_operator,
                    'value' => '%"' . $params['category_id'] . '"%'
                ));

        }

        if (isset($params['type']) && $params['type'] == 'international') {
            $conditions['conditions'] = array(
                array(
                    'index' => 'origin_country_id',
                    'table' => 'reservation_tour_tb',
                    'operator' => '=',
                    'value' => '1',
                ),

                array(
                    'index' => 'destination_country_id',
                    'table' => 'reservation_tour_rout_tb',
                    'operator' => '!=',
                    'value' => '1',
                ),
                array(
                    "index" => "is_show",
                    "table" => "reservation_tour_tb",
                    "value" => "yes"
                ),
                array(
                    "index" => "is_del",
                    "table" => "reservation_city_tb",
                    "value" => "no"
                ),
                array(
                    "index" => "is_del",
                    "table" => "reservation_tour_tb",
                    "value" => "no"
                ),
                array(
                    'index' => 'start_date',
                    'table' => 'reservation_tour_tb',
                    'operator' => '>',
                    'value' => $dateNow,
                ),
                $from_city_conditional

            );

        }

        if ($category_conditions) {
            $conditions['conditions'] = array_merge($conditions['conditions'], $category_conditions);
        }


        if (isset($params['type']) && $params['type'] == 'international' && !isset($params['city_id'])) {

            $conditions['group_by'] = 'reservation_tour_tb.origin_city_id';

            return $this->getExternalCities($conditions);
        }
        else if (isset($params['type']) && $params['type'] == 'international' && isset($params['city_id'])) {

            $conditions['group_by'] = 'reservation_country_tb.id';
            $conditions['is_external'] = true;

            return $this->getCountry($conditions);
        }

        if (isset($params['to_json'])) {
            $conditions['to_json'] = false;
            $conditions['type'] = 'pwa';
        }
        if (isset($params['get_origin'])) {
            $conditions['get_origin'] = true;
        }

        if (isset($params['tour_type_title']) && $params['tour_type_title']) {
            $tour_title = functions::array_filter_by_value($conditions['conditions'], 'index', 'tour_title');
            $item = key($tour_title);
            $conditions['conditions'][$item]['value'] = $params['tour_type_title'];

        }


        if (isset($params['get_init_data'])) {
            /** @var resultTourLocal $resultTourLocal */
            $resultTourLocal = $this->getController(resultTourLocal::class);
            $cities = $this->getCityList($conditions);


            $cities_array = [];
            foreach ($cities as $key => $city) {
                $cities_array[$key] = $city['city'];
            }
            return [
                'types' => $resultTourLocal->getTourTypes(),
                'cities' => $cities_array
            ];
        }

        return $this->getCityList($conditions);
    }

    public function getExternalCities($data) {
        $reservation_tour_model = $this->reservationTourModel()->getTable();
        $reservation_tour_rout_model = $this->reservationTourRoutModel()->getTable();
        $reservation_city_model = $this->reservationCityModel()->getTable();


        $getter = array(
            $reservation_tour_model . '.id as tour_id',
            $reservation_city_model . '.id',
            $reservation_city_model . '.name',
            $reservation_city_model . '.name_en',
            $reservation_city_model . '.id_country',
            $reservation_city_model . '.abbreviation',
            $reservation_tour_rout_model . '.destination_country_id',
        );

        if (isset($data['getters']) && $data['getters']) {
            $getter = array_merge($getter, $data['getters']);
        }

        $group_by = $reservation_city_model . '.id';
        if (isset($data['group_by']) && $data['group_by']) {
            $group_by = $data['group_by'];
        }

        $order_by = $reservation_tour_model . '.priority';
        if (isset($data['order_by']) && $data['order_by']) {
            $order_by = $data['order_by'];
        }

        $limit = '20';
        if (isset($data['limit']) && $data['limit']) {
            $limit = $data['limit'];
        }


        $cities = $this->reservationCityModel()->get($getter, true);

        $cities->join($reservation_tour_model, 'origin_city_id', 'id', 'INNER');
        $cities->join($reservation_tour_model, 'fk_tour_id', 'id', 'INNER', $reservation_tour_rout_model);

        $tour_condition = $this->conditions($data['conditions']);
        $cities->where($tour_condition);
        $cities->groupBy($group_by);
        $cities->orderBy($order_by);
        $cities->limit(0, $limit);
        $cities = $cities->all();
        $info_api = $this->getAccessTourWebService();

        if ($info_api) {


            $object_api = new tourApi($info_api);
            $conditions_tour = [];
            foreach ($tour_condition as $item) {
                switch ($item['index']) {
                    case 'reservation_city_tb.id_country':
                        $conditions_tour['id_country'] = $item['value'];
                        break;
                    case 'reservation_tour_tb.origin_country_id' :
                        $conditions_tour['origin_country_id'] = $item['value'];
                        break;
                    case 'reservation_tour_rout_tb.destination_country_id' :
                        $conditions_tour['destination_country_id'] = $item['value'];
                        break;
                    case 'reservation_tour_tb.start_date' :
                        $conditions_tour['start_date'] = $item['value'];
                        break;
                    case 'reservation_tour_rout_tb.tour_title' :
                        $conditions_tour['tour_title'] = $item['value'];
                        break;
                }

            }


            $api_cities = $object_api->getOriginCitiesExternal($conditions_tour);

        }


        if ($cities || (empty($cities) && !empty($api_cities))) {
            if (!isset($api_cities['status'])) {
                if (empty($cities)) {
                    $cities = $api_cities;
                } else {
                    $abbrevations = [];
                    foreach ($cities as $city) {
                        $abbrevations[] = $city['abbreviation'];
                    }
                    foreach ($api_cities as $item) {
                        if (!in_array($item['abbreviation'], $abbrevations)) {
                            $cities[] = $item;
                        }
                    }
                }
            };
            $city_collection = $this->city_resource->collection($cities);


            return functions::withSuccess($city_collection, 200, 'successfully fetch');
        }
        return functions::withError(null, 200, 'not found');
    }

    public function getZiaratyTourCity($params = null) {

        $dateNow = dateTimeSetting::jdate("Ymd", "", "", "", "en");

        if (isset($params['city_id']) && $params['city_id']) {

            $from_city_conditional = array(
                array(
                    'index' => 'origin_city_id',
                    'table' => 'reservation_tour_tb',
                    'operator' => '=',
                    'value' => $params['city_id'],
                ),
                array(
                    'index' => 'tour_title',
                    'table' => 'reservation_tour_rout_tb',
                    'operator' => '=',
                    'value' => 'dept',
                )
            );

        } else {
//            $from_city_conditional = array(
//                'index' => 'tour_title',
//                'table' => 'reservation_tour_rout_tb',
//                'operator' => '=',
//                'value' => 'return',
//
//            );
//
//            if(isset($params['type']) && $params['type'] =='international'){
            $from_city_conditional = array(
                'index' => 'tour_title',
                'table' => 'reservation_tour_rout_tb',
                'operator' => '=',
                'value' => 'dept'
            );
//            }
        }


        $category_conditions = array();
        if (isset($params['category_id']) && $params['category_id']) {
            $category_operator = 'like';
            if (isset($params['like_category']) && $params['like_category'] == 'no') {
                $category_operator = 'not like';
            }

            $category_conditions = array(
                array(
                    'index' => 'tour_type_id',
                    'table' => 'reservation_tour_tb',
                    'operator' => $category_operator,
                    'value' => '%"' . $params['category_id'] . '"%'
                ));

        }


        $conditions['conditions'] = array(
            array(
                'index' => 'origin_country_id',
                'table' => 'reservation_tour_tb',
                'operator' => '=',
                'value' => '1',
            ),
            array(
                "index" => "is_show",
                "table" => "reservation_tour_tb",
                "value" => "yes"
            ),
            array(
                "index" => "is_del",
                "table" => "reservation_city_tb",
                "value" => "no"
            ),
            array(
                "index" => "is_del",
                "table" => "reservation_tour_tb",
                "value" => "no"
            ),
            array(
                'index' => 'start_date',
                'table' => 'reservation_tour_tb',
                'operator' => '>',
                'value' => $dateNow,
            ),
        );
        if ($from_city_conditional) {
            $conditions['conditions'] = array_merge($conditions['conditions'], $from_city_conditional);
        }


        if ($category_conditions) {
            $conditions['conditions'] = array_merge($conditions['conditions'], $category_conditions);
        }

        if (isset($params['type']) && !isset($params['city_id'])) {
            $conditions['group_by'] = 'reservation_tour_tb.origin_city_id';
            return $this->getExternalCities($conditions);
        } else if (isset($params['type']) && isset($params['city_id'])) {
            $conditions['group_by'] = 'reservation_country_tb.id';
            $conditions['is_external'] = true;
            return $this->getCountry($conditions);
        }
        return $this->getCityList($conditions);
    }


    public function tourExternalCountryCity($params) {
        $dateNow = dateTimeSetting::jdate("Ymd", "", "", "", "en");
        $reservation_tour_rout_model = $this->getModel('reservationTourRoutModel')->getTable();
        $reservation_city_model = $this->getModel('reservationCityModel')->getTable();
        $reservation_tour_model = $this->getModel('reservationTourModel')->getTable();

        $result_city_external_tour = $this->getModel('reservationCityModel')->get()
            ->join($reservation_tour_rout_model, 'destination_city_id', 'id', 'INNER')
            ->join($reservation_tour_rout_model, 'id', 'fk_tour_id', 'INNER', $reservation_tour_model)
            ->where($reservation_city_model . '.id_country', $params['country_id'])
            ->where($reservation_tour_model . '.start_date', $dateNow , '>');


        if (isset($params['category_id']) && $params['category_id']) {
            $like = 'like';
            if (isset($params['like_category']) && $params['like_category'] == 'no') {
                $like = 'not like';
            }
            $result_city_external_tour = $result_city_external_tour->where($reservation_tour_model . '.tour_type_id', '%' . $params['category_id'] . '%', $like);

        }
        if (isset($params['origin_city']) && $params['origin_city']) {
            $result_city_external_tour = $result_city_external_tour->where($reservation_tour_model . '.origin_city_id', $params['origin_city']);

        }

        $result_city_external_tour = $result_city_external_tour->groupBy($reservation_city_model . '.id')
            ->orderBy($reservation_tour_rout_model . '.id')->all();


        $info_api = $this->getAccessTourWebService();

        if ($info_api) {
            $object_api = new tourApi($info_api);
            $data = [
                'id_country' => $params['country_id']
            ];

            $result_city_external_tour_api = $object_api->getCityDestinationExternal($data);

            if ($result_city_external_tour_api) {
                if (empty($cities)) {
                    $result_city_external_tour = $result_city_external_tour_api;
                } else {
                    $abbrevations = [];
                    foreach ($result_city_external_tour_api as $city) {
                        $abbrevations[] = $city['abbreviation'];
                    }
                    foreach ($api_cities as $item) {
                        if (!in_array($item['abbreviation'], $abbrevations)) {
                            $result_city_external_tour[] = $item;
                        }
                    }
                }
            }
        }


        return functions::withSuccess($result_city_external_tour, 200, 'data fetch successfully');
    }

    public function v2GetTours() {
        $reservation_tour_model = $this->reservationTourModel()->getTable();
        $reservation_tour_rout_model = $this->reservationTourRoutModel()->getTable();
        $reservation_city_model = $this->reservationCityModel()->getTable();
        $reservation_tour_package_model = $this->getModel(reservationTourPackageModel::class)->getTable();
        $getter = array(
            $reservation_tour_model . '.id',
            $reservation_tour_model . '.tour_name',
            $reservation_tour_model . '.tour_name_en',
            $reservation_tour_model . '.language',
            $reservation_tour_model . '.tour_pic',
            $reservation_tour_model . '.night',
            $reservation_tour_model . '.start_date',
            $reservation_tour_model . '.description',
            "min( $reservation_tour_package_model.double_room_price_r ) AS min_price_r",
        );


        $tours = $this->getModel('reservationTourModel')->get($getter);
        $tours = $tours->join($reservation_tour_model, 'origin_city_id', 'id', 'INNER');

        $tours = $tours->join($reservation_tour_model, 'fk_tour_id', 'id', 'INNER', $reservation_tour_rout_model);
        $tours = $tours->join($reservation_tour_rout_model, 'id', 'destination_city_id', 'INNER', $reservation_city_model);
        $tours = $tours->join($reservation_tour_package_model, 'fk_tour_id', 'id', 'LEFT', $reservation_tour_package_model);

        $dateNow = dateTimeSetting::jdate("Ymd", "", "", "", "en");
        $conditions = [
            [
                'index' => 'start_date',
                'table' => 'reservation_tour_tb',
                'operator' => '>',
                'value' => $dateNow,
            ],
            [
                'index' => 'id_country',
                'table' => 'reservation_city_tb',
                'operator' => '=',
                'value' => '1',
            ],
            [
                'index' => 'origin_country_id',
                'table' => 'reservation_tour_tb',
                'operator' => '=',
                'value' => '1',
            ],
            [
                'index' => 'destination_country_id',
                'table' => 'reservation_tour_rout_tb',
                'operator' => '=',
                'value' => '1',
            ],
            [
                "index" => "is_show",
                "table" => "reservation_tour_tb",
                "value" => "yes"
            ],
            [
                "index" => "is_del",
                "table" => "reservation_city_tb",
                "value" => "no"
            ],
            [
                "index" => "is_del",
                "table" => "reservation_tour_tb",
                "value" => "no"
            ]

        ];
        $tour_condition = $this->conditions($conditions);


        $tours->where($tour_condition);


        $tours->groupBy($reservation_tour_model . '.id_same');

        $tours->orderBy($reservation_tour_model . '.priority');


//        $tours->limit(0, $data['limit']);
        return $tours = $tours->all();
    }

    public function getInternationalDestinationCities($params = null) {


        $dateNow = dateTimeSetting::jdate("Ymd", "", "", "", "en");

        $origin_country_id = $params['origin_country_id'];
        $origin_city_id = $params['origin_city_id'];
        $destination_country_id = $params['destination_country_id'];
        $tour_title_type = $params['tour_title_type'];
        $tour_type = $params['type_id'];

        // means looking for destination cities
        $category_conditions = [];
        if ($origin_city_id) {
            $category_conditions[] = [
                'index' => 'origin_city_id',
                'table' => 'reservation_tour_tb',
                'operator' => '=',
                'value' => $origin_city_id,
            ];
            $category_conditions[] = [
                'index' => 'tour_title',
                'table' => 'reservation_tour_rout_tb',
                'operator' => '=',
                'value' => 'dept'
            ];
        } else {

        }


        $conditions['conditions'] = [
            [
                'index' => 'id_country',
                'table' => 'reservation_city_tb',
                'operator' => '=',
                'value' => '1',
            ],
            [
                'index' => 'origin_country_id',
                'table' => 'reservation_tour_tb',
                'operator' => '=',
                'value' => '1',
            ],
            [
                'index' => 'destination_country_id',
                'table' => 'reservation_tour_rout_tb',
                'operator' => '=',
                'value' => '1',
            ],
            [
                'index' => 'tour_title',
                'table' => 'reservation_tour_rout_tb',
                'operator' => '=',
                'value' => 'dept',
            ],
            [
                'index' => 'is_show',
                'table' => 'reservation_tour_tb',
                'operator' => '=',
                'value' => 'yes',
            ],
            [
                'index' => 'is_del',
                'table' => 'reservation_city_tb',
                'operator' => '=',
                'value' => 'no',
            ],
            [
                'index' => 'start_date',
                'table' => 'reservation_tour_tb',
                'operator' => '>',
                'value' => $dateNow,
            ],


        ];


        if (isset($params['type_id']) && $params['type_id']) {
            $category_operator = 'like';
            if (isset($params['like_category']) && $params['like_category'] == 'no') {
                $category_operator = 'not like';
            }

            $category_conditions [] =
                [
                    'index' => 'tour_type_id',
                    'table' => 'reservation_tour_tb',
                    'operator' => $category_operator,
                    'value' => '%"' . $params['category_id'] . '"%'
                ];

        }

        if ($category_conditions) {
            $conditions['conditions'] = array_merge($conditions['conditions'], $category_conditions);
        }


        if (isset($params['to_json'])) {
            $conditions['to_json'] = false;
            $conditions['type'] = 'pwa';
        }
        if (isset($params['get_origin'])) {
            $conditions['get_origin'] = true;
        }
        if (isset($params['tour_type_title'])) {
            $conditions['tour_type_title'] = $params['tour_type_title'];
        }

        if (isset($params['get_init_data'])) {
            /** @var resultTourLocal $resultTourLocal */
            $resultTourLocal = $this->getController(resultTourLocal::class);
            $cities = $this->getCityList($conditions);
            $cities_array = [];
            foreach ($cities as $key => $city) {
                $cities_array[$key] = $city['city'];
            }
            return [
                'types' => $resultTourLocal->getTourTypes(),
                'cities' => $cities_array
            ];
        }
        return $this->getCityList($conditions);
    }

    public function setTourData($id) {
        $reservation_tour_model = $this->reservationTourModel()->getTable();
        $reservation_tour_rout_model = $this->reservationTourRoutModel()->getTable();
        $reservation_country_model = $this->reservationCountryModel()->getTable();
        $reservation_city_model = $this->reservationCityModel()->getTable();

        $tour = $this->reservationTourModel()->get([
            $reservation_tour_model . '.*',
            $reservation_tour_rout_model . '.destination_country_id',
            $reservation_tour_rout_model . '.destination_city_id',
        ],true);
        $tour->join($reservation_tour_model, 'fk_tour_id', 'id', 'INNER', $reservation_tour_rout_model);
        $tour->join($reservation_tour_model, 'id', 'origin_city_id', 'INNER', $reservation_city_model);
        $tour->join($reservation_tour_model, 'id', 'origin_country_id', 'INNER', $reservation_country_model);

        $tour->where($reservation_tour_model . '.id_same', $id);

        $tour->groupBy($reservation_tour_model . '.id_same');

        $tour->orderBy($reservation_tour_model . '.id');



        $tour = $tour->find();
        defined('SEARCH_ORIGIN_COUNTRY') or define('SEARCH_ORIGIN_COUNTRY', $tour['origin_country_id']);
        defined('SEARCH_ORIGIN_CITY') or define('SEARCH_ORIGIN_CITY', $tour['origin_city_id']);
        defined('SEARCH_DESTINATION_COUNTRY') or define('SEARCH_DESTINATION_COUNTRY', $tour['destination_country_id']);
        defined('SEARCH_DESTINATION_CITY') or define('SEARCH_DESTINATION_CITY', $tour['destination_city_id']);
        defined('SEARCH_DATE') or define('SEARCH_DATE', 'all');
        defined('SEARCH_TOUR_TYPE') or define('SEARCH_TOUR_TYPE', 'all');
    }

    public function getTourById($id) {
        return $this->reservationTourModel()->get()->where('id', $id)->find();
    }
    public function getTourByIdSame($id) {
//        if (SOFTWARE_LANG == 'fa') {
        $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
//        } else {
//            $dateNow = date("Ymd");
//        }
        $tour = $this->reservationTourModel()->get()
            ->where('id_same', $id)
            ->where('start_date' , $dateNow , '>=')
            ->where('is_del' , 'no')
            ->orderBy('start_date', 'asc')
            ->limit(0 , 1)
            ->all();

        if (empty($tour)) {
            $tour = false;
        }

        return $tour;
    }
    public function getTourBySlug($name_en) {
        if (SOFTWARE_LANG == 'fa') {
            $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        } else {
            $dateNow = date("Ymd");
        }
        return $this->reservationTourModel()->get()
            ->where('tour_name_en', $name_en)
            ->where('start_date' , $dateNow , '>=')
            ->where('is_del' , 'no')
            ->orderBy('start_date', 'asc')
            ->limit(0 , 1)
            ->all();
    }
}