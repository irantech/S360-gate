<?php



class searchService extends clientAuth
{

    public function __construct() {
        parent::__construct();
    }


    /**
     * @throws Exception
     */
    public function getDepartures($params)
    {
        $configurations = new configurations();
        $priority_flight_routes = $configurations->checkClientConfigurationByTitle('priority_flight_routes', CLIENT_ID);

        if ($params['strategy'] === 'local') {

            if ($priority_flight_routes && !$params['value']) {
                return $this->getModel('flightRouteCustomerModel')->getLocalStations($params);
            }
            return $this->getModel('flightRouteModel')->getLocalStations($params);

        }
        if ($params['strategy'] === 'external') {
            if ($priority_flight_routes && !$params['value']) {
                return $this->getController('newApiFlight')->getCustomPortalStation($params);
            }
            return $this->getController('newApiFlight')->getPortalStation($params);
        }
        return false;
    }


    /**
     * @return array
     */
    public function getAllHotelCities()
    {
        /** @var hotelCitiesModel $hotelCitiesModel */
        $hotelCitiesModel = Load::getModel('hotelCitiesModel');

        return $hotelCitiesModel->get()->all();

    }

    /**
     * @return array
     */
    public function getTrainRoutes()
    {
        /** @var trainRouteModel $trainRouteModel */
        $trainRouteModel = Load::getModel('trainRouteModel');
        return $trainRouteModel->getTrainRoutes();
    }

    /**
     * @return array
     */
    public function getBusRoutes()
    {
        /** @var busRouteModel $busRouteModel */
        $busRouteModel = Load::getModel('busRouteModel');

        return $busRouteModel->getAllRoutes();

    }

    /**
     * @return array
     */
    public function getInsuranceCountries()
    {
        return $this->getController('insuranceCountry')->AllCountryInsurance();
    }


    public function getCategoryParent()
    {
        /** @var entertainmentCategoryModel $categoryEntertainment */
        $categoryEntertainment = Load::getModel('entertainmentCategoryModel');
        return $categoryEntertainment->getCategoryParent();
    }

    public function getListContinent()
    {
        return $this->getController('continentCodes')->getListContinents();
    }

    public function getVisaTypeList()
    {
        $date = date('Y-m-d H:i:s');
        /** @var visaTypeModel $visaTypeModel */
        $visaTypeModel = Load::getModel('visaTypeModel');
        return $visaTypeModel->getVisaTypeList($date);
    }

    public function getCitiesGasht()
    {
        /** @var gashtotransferCitiesModel $gashtotransferCitiesModel */
        $gashtotransferCitiesModel = Load::getModel('gashtotransferCitiesModel');
        return $gashtotransferCitiesModel->getCitiesGasht();

    }

    public function getFlightRoutInternal($limit = null)
    {
        /** @var flightRouteCustomerModel $flightRouteCustomerModel */
        $flightRouteCustomerModel = Load::getModel('flightRouteCustomerModel');
        $query_response = $flightRouteCustomerModel->getFlightRoutInternal($limit);

        $result = [];
        $index_lang = functions::changeFieldNameByLanguage('Departure_City');
        foreach ($query_response as $key => $item) {
            $result[$key] = $item;
            $result[$key]['translated_departure_city'] = $item[$index_lang];
        }
        return $result;
    }

    public function getAllTourCountries($tour_type = 'all', $route = 'dept')
    {
        /** @var \reservationCountryModel $reservationCountryModel */
        $reservationCountryModel = Load::getModel('reservationCountryModel');

        return $reservationCountryModel->getAllTourCountries($tour_type, $route);

    }

    public function getAllTourCities($idCountry = null, $tourType = null, $route = null)
    {
        /** @var \reservationCityModel $reservationCityModel */
        $reservationCityModel = Load::getModel('reservationCityModel');
        return $reservationCityModel->getAllTourCities($idCountry, $tourType, $route);
    }

    public function getAllTourRegions($idCity = null, $tourType = null, $route = null)
    {
        /** @var reservationRegionModel $reservationRegionModel */
        $reservationRegionModel = Load::getModel('reservationRegionModel');
        return $reservationRegionModel->getAllTourRegions($idCity, $tourType, $route);
    }

    public function getTour($origin_country, $limit, $language = 'fa', $type = null)
    {


        /** @var tourModel $tourModel */
        $tourModel = Load::getModel('tourModel');
        $query_response = $tourModel->getTours($origin_country, $limit, $language, $type);
        $result = [];
        $index_lang = functions::ChangeIndexNameByLanguage($language, 'tour_name');
        foreach ($query_response as $key => $item) {
            $result[$key] = $item;
            $result[$key]['translated_tour_name'] = $item[$index_lang];
        }
        return $result;
    }

    public function getHotel($limit = 6, $cityIds = [], $hotelIds = [], $isInternal = true)
    {
        /** @var ApiHotelCore $ApiHotelCore */
        $ApiHotelCore = Load::library('ApiHotelCore');
        $data = [];
        $data['Count'] = $limit;
        $data['CityIds'] = $cityIds;
        $data['HotelIds'] = $hotelIds;
        $data['IsInternal'] = $hotelIds;
        $return = $ApiHotelCore->RandomHotelList($data);

        return json_decode($return, true);
    }

    public function checkAccessService($with_detail = false,$client_id=CLIENT_ID)
    {
        
        $definedSubAgency = defined(SUB_AGENCY_ID);
        $agencyId = $definedSubAgency ? SUB_AGENCY_ID : Session::getAgencyId();

        /** @var clientAuthModel $clientAuthModel */
        $clientAuthModel = Load::getModel('clientAuthModel');
        $accessesClient = $clientAuthModel->getAccessServiceClient($client_id);

        $dataAccess = array();

        if ($definedSubAgency) {
            /** @var accessAgencyServiceModel $accessAgencyServiceModel */
            $accessAgencyServiceModel = Load::getModel('accessAgencyServiceModel');
            $accessSubAgency = $accessAgencyServiceModel->get()->where('agencyId', $agencyId)->all();

            if (!empty($accessSubAgency)) {
                foreach ($accessSubAgency as $key => $subAccess) {
                    foreach ($accessesClient as $keyClient => $accessItemClient) {
                        if ($subAccess['servicesGroupId'] == $accessItemClient['id']) {
                            if ($with_detail) {
                                $dataAccess[] = $accessItemClient;
                            } else {
                                $dataAccess[] = $accessItemClient['MainService'];
                            }
                        }
                    }
                }
                return $dataAccess;
            }

        }
        else {
            foreach ($accessesClient as $keyClient => $accessItemClient) {
                if ($with_detail) {
                    $dataAccess[] = $accessItemClient;


                } else {
                    $dataAccess[] = $accessItemClient['MainService'];
                }
            }

            if ($with_detail) {
                $dataAccess = $this->accessServiceClient($dataAccess , $client_id);

            }


            return $dataAccess;
        }

        return array();
    }

    public function update_service_order($params)
    {

        $client_id=CLIENT_ID;
        if(isset($params['client_id']) && $params['client_id'] !=='' && TYPE_ADMIN == '1'){
            $client_id=$params['client_id'];
        }

        $search_service_order = $this->getModel('searchServiceOrderModel');
        $check_existence = $search_service_order->get()
            ->where('client_id', $client_id)
            ->where('service_group_id', $params['service_group_id'])
            ->all();

        if ($check_existence) {

            $result = $search_service_order->get()
                ->update(['order_number' => $params['order_number']], 'client_id = ' . $client_id . ' AND service_group_id = ' . $params['service_group_id']);
        } else {

            $result = $search_service_order
                ->insertWithBind([
                    'client_id' => $client_id,
                    'service_group_id' => $params['service_group_id'],
                    'order_number' => $params['order_number']
                ]);
        }

        if ($result) {
            return 'success :  تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در تغییرات';
        }

    }

    public function prepareTourLocalStations($params)
    {

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

        $custom_conditions = [];
        if (isset($params['conditions'])) {
            if (isset($params['conditions']['origin_city'])) {
                $custom_conditions = [
                    [
                        'index' => 'origin_city_id',
                        'table' => 'reservation_tour_tb',
                        'operator' => '=',
                        'value' => $params['conditions']['origin_city']['city']['value'],
                    ],
                    [
                        'index' => 'tour_title',
                        'table' => 'reservation_tour_rout_tb',
                        'operator' => '=',
                        'value' => 'dept',
                    ],
                ];
            }
        } else {
            $custom_conditions = [
                [
                    'index' => 'tour_title',
                    'table' => 'reservation_tour_rout_tb',
                    'operator' => '=',
                    'value' => 'return',
                ],
            ];
        }


        $params['conditions'] = array_merge($conditions, $custom_conditions);

        $params['getters'] = [
            'reservation_city_tb.name as city_title',
            'reservation_city_tb.id as city_value',
            " '' as country_title",
            'reservation_city_tb.id_country as country_value',
        ];

        if (empty($params['limit'])) {
            $params['limit'] = 10;
        }

        if (!empty($params['value'])) {
            $params['searchLike'] = $params['value'];
        }


        return $params;
    }

    public function prepareTourExternalStations($params)
    {


        $dateNow = dateTimeSetting::jdate("Ymd", "", "", "", "en");
        $conditions = [

            [
                "index" => "is_del",
                "table" => "reservation_country_tb",
                "value" => "no"
            ],
            [
                "index" => "is_del",
                "table" => "reservation_city_tb",
                "value" => "no"
            ],

            [
                "index" => "destination_country_id",
                "table" => "reservation_tour_rout_tb",
                "operator" => "!=",
                "value" => "1"
            ],
            [
                "index" => "tour_title",
                "table" => "reservation_tour_rout_tb",
                "operator" => "=",
                "value" => "dept"
            ],

        ];
        /*   if($params['country_id']){
               $country_condition=[
                   "index" => "origin_country_id",
                   "table" => "reservation_tour_tb",
                   "operator" => "=",
                   "value" => $params['country_id']
               ];
               $conditions=array_merge($conditions,$country_condition);
           }*/


        $reservation_tour_tb_condition = [
            [
                "index" => "is_show",
                "table" => "reservation_tour_tb",
                "value" => "yes"
            ],
            [
                "index" => "is_del",
                "table" => "reservation_tour_tb",
                "value" => "no"
            ],
            [
                "index" => "start_date",
                "table" => "reservation_tour_tb",
                "operator" => ">",
                "value" => $dateNow
            ],
            [
                "index" => "origin_country_id",
                "table" => "reservation_tour_tb",
                "operator" => "=",
                "value" => "1"
            ],
        ];
        $params['methode'] = 'getCountry';
        $params['group_by'] = 'reservation_country_tb.id';
       
        if (isset($params['conditions'])) {
            if (isset($params['conditions']['destination_country'])) {
                $custom_conditions = [
                    [
                        'index' => 'id_country',
                        'table' => 'reservation_city_tb',
                        'operator' => '=',
                        'value' => $params['conditions']['destination_country']['country']['value'],
                    ]
                ];
                $reservation_tour_tb_condition = [];
                $params['methode'] = 'getCityListByCountry';
            }else if (isset($params['conditions']['origin_country'])) {
               
                $custom_conditions = [
                    [
                        'index' => 'id_country',
                        'table' => 'reservation_city_tb',
                        'operator' => '=',
                        'value' => $params['conditions']['origin_country']['country']['value'],
                    ]
                ];
                $reservation_tour_tb_condition = [];
                $params['to_json'] = false ;
                $params['methode'] = 'getTourCities';
            } else {

                    $params['group_by'] = 'reservation_city_tb.id';
                if(isset($params['conditions']['origin_country'])){
                    $custom_conditions = [[
                        'index' => 'id_country',
                        'table' => 'reservation_city_tb',
                        'operator' => '=',
                        'value' => $params['conditions']['origin_country']['country']['value'],
                    ]];
                }else{
                    $params['group_by'] = 'reservation_country_tb.id';
                    $custom_conditions = [[
                        'index' => 'id',
                        'table' => 'reservation_city_tb',
                        'operator' => '=',
                        'value' => $params['conditions']['origin_city']['city']['value'],
                    ]];
                }

            }
        } else {
            $custom_conditions = [[

                "index" => "id",
                "table" => "reservation_country_tb",
                "operator" => "!=",
                "value" => "1"

            ],
            ];

        }
        $params['conditions'] = array_merge($conditions, $custom_conditions, $reservation_tour_tb_condition);

        $params['getters'] = [
            'reservation_city_tb.name as city_title',
            'reservation_city_tb.name_en as city_title_en',
            'reservation_city_tb.id as city_value',
            'reservation_country_tb.name as country_title',
            'reservation_country_tb.id as country_value',
        ];

        if (empty($params['limit'])) {
            $params['limit'] = 10;
        }

        if (!empty($params['value'])) {
            $params['searchLike'] = $params['value'];
        }


        return $params;
    }

    /**
     * @throws Exception
     */
    public function getTourStations($params)
    {
        if ($params['strategy'] === 'local') {
            $params = $this->prepareTourLocalStations($params);
            return $this->getController('mainTour')->getCityList($params);
        }
        if ($params['strategy'] === 'external') {

            $params = $this->prepareTourExternalStations($params);

            $method = $params['methode'] ;
            if($method == 'getTourCities') {
                $params['to_json']  = false;
                $params['type']  = 'pwa';
                $params['get_origin'] = 'yes';
            }


            $result = $this->getController('mainTour')->$method($params);
            return $result;
        }

        return false;
    }


    /**
     * @throws Exception
     */
    public function trainRoutes($params)
    {
        $train_routes = $this->getController('routeTrain')->getTrainRoutes($params, false);
        $result = [];
        foreach ($train_routes as $train_route) {
            $result[] = [
                "value" => $train_route['Code'],
                "title" => $train_route['Name'],
            ];
        }
        return $result;
    }

    /**
     * @throws Exception
     */
    public function busRoutes($params)
    {
        $train_routes = $this->getController('resultBus')->getBusRoutes($params);
        $result = [];
        foreach ($train_routes as $train_route) {
            $result[] = [
                "value" => $train_route['iataCode'],
                "title" => $train_route['name_fa'],
            ];
        }
        return $result;
    }

    /**
     * @throws Exception
     */
    public function insuranceRoutes($params)
    {
        $train_routes = $this->getController('insurance')->getInsuranceRoutes($params);
        $result = [];
        foreach ($train_routes as $train_route) {
            $result[] = [
                "value" => $train_route['abbr'],
                "title" => $train_route['persian_name'],
            ];
        }
        return $result;
    }
    /**
     * @throws Exception
     */
    public function visaRoutes($params)
    {
        $result = [];
        if($params['conditions'] ){
           if($params['conditions']['country_id']){
               if(isset($params['value'])){
                   $params['conditions']['value']=$params['value'];
               }

            $visa_routes = $this->getController('visa')->visaTypesByCountryId($params['conditions']);
               foreach ($visa_routes as $visa_route) {
                   $result[] = [
                       "value" => $visa_route['id'],
                       "title" => $visa_route['title'],
                       "title_en" => $visa_route['title'],
                   ];
               }
           }elseif($continent_id=$params['conditions']['continent_id']){

            $visa_routes = $this->getController('visa')->countriesHaveVisaByContinentId($continent_id);
               foreach ($visa_routes as $visa_route) {
                   $result[] = [
                       "value" => $visa_route['code'],
                       "title" => $visa_route['title'],
                       "title_en" => $visa_route['title_en'],
                   ];
               }
           }

        }else{
            $visa_routes = $this->getController('visa')->continentsHaveVisa(['value' =>$params['value']]);
            foreach ($visa_routes as $visa_route) {
                $result[] = [
                    "value" => $visa_route['id'],
                    "title" => $visa_route['titleFa'],
                    "title_en" => $visa_route['titleEn'],
                ];
            }
        }
     


        return $result;
    }

    /**
     * @throws Exception
     */
    public function entertainmentRoutes($params)
    {
        $result = [];
        /** @var entertainment $entertainment */
        $entertainment = $this->getController('entertainment');
        if($params['strategy'] ==='destination'){
        if($params['conditions'] ){
            $country_id=$params['conditions']['country_id'];
                $entertainment_routes=$entertainment->getCities(['country_id'=>$country_id,'value'=>$params['value']]);
                foreach ($entertainment_routes as $route) {

                    $result[] = [
                        "value" => $route['id'],
                        "title" => $route['name'],
                        "title_en" => $route['name_en'],
                    ];
                }


        }else{

            $entertainment_routes=$entertainment->getCountries(true,$params['value']);
            foreach ($entertainment_routes as $route) {
                $result[] = [
                    "value" => $route['id'],
                    "title" => $route['name'],
                    "title_en" => $route['name_en'],
                ];
            }
        }
        }else{
                if($category_id=$params['conditions']['category_id']){
                    $params['conditions']['category_id']=$category_id;
                    if (!empty($params['value'])) {
                        $params['conditions']['value']=$params['value'];
                    }



                    $visa_routes = $entertainment->getSubCategories($params['conditions']);
                    foreach ($visa_routes as $visa_route) {
                        $result[] = [
                            "value" => $visa_route['id'],
                            "title" => $visa_route['title'],
                            "title_en" => $visa_route['title'],
                        ];
                    }
                }else{

                    if (!empty($params['value'])) {
                        $params['conditions']['value']=$params['value'];
                    }



                    $visa_routes = $entertainment->getCategories($params['conditions']);
                    foreach ($visa_routes as $visa_route) {
                        $result[] = [
                            "value" => $visa_route['id'],
                            "title" => $visa_route['title'],
                            "title_en" => $visa_route['title'],
                        ];
                    }
                }


        }



        return $result;
    }

    /**
     * @throws Exception
     */
    public function hotelRoutes($params)
    {

        if ($params['strategy'] === 'local') {
            if (!isset($params['value']) || $params['value'] == '') {

                $default_cities = [
                    'Cities' => [
                        [
                            'CityId' => '1',
                            'CityName' => 'تهران',
                            'CityNameEn' => 'Tehran',
                            'index_name' => 'Cities'
                        ],
                        [
                            'CityId' => '2',
                            'CityName' => 'اصفهان',
                            'CityNameEn' => 'Isfahan',
                            'index_name' => 'Cities'
                        ],
                        [
                            'CityId' => '3',
                            'CityName' => 'یزد',
                            'CityNameEn' => 'Yazd',
                            'index_name' => 'Cities'
                        ],
                        [
                            'CityId' => '4',
                            'CityName' => 'کاشان',
                            'CityNameEn' => 'Kashan',
                            'index_name' => 'Cities'
                        ],
                    ]
                ];
                return $default_cities;
            }
            $hotel_routes = $this->getController('reservationHotel')->getHotelRoutes($params);
            return $hotel_routes;
        }
        if ($params['strategy'] === 'external') {
            if (!isset($params['value']) || $params['value'] == '') {

                $hotel_routes = $this->getController('reservationHotel')->flightExternalRoutesDefault($params);
                return $hotel_routes;
            }
            $hotel_routes = $this->getController('reservationHotel')->getHotelRoutes($params);
            return $hotel_routes;
        }

        return false;

    }


    /**
     * @throws Exception
     */
    public function pwaGetDefaultCities($params)
    {

        if ($params['index_key'] === 'flight') {
            $result = $this->getDepartures($params);
        }
        if ($params['index_key'] === 'tour') {

            $result = $this->getTourStations($params);
        }
        if ($params['index_key'] === 'train') {
            $result = $this->trainRoutes($params);
        }
        if ($params['index_key'] === 'bus') {
            $result = $this->busRoutes($params);
        }
        if ($params['index_key'] === 'insurance') {
            $result = $this->insuranceRoutes($params);
        }
        if ($params['index_key'] === 'visa') {
            $result = $this->visaRoutes($params);
        }
        if ($params['index_key'] === 'entertainment') {
            $result = $this->entertainmentRoutes($params);
        }
        if ($params['index_key'] === 'hotel') {
            $result = $this->hotelRoutes($params);
        }
        return $result;
    }

    public function translate($data) {
        return functions::Xmlinformation($data);
    }

    public function accessServiceClient($dataAccess , $CLIENT_ID) {

        $client_list = ['302'] ;
        if(in_array($CLIENT_ID , $client_list)) {

            foreach ($dataAccess as $key => $access) {
                if($access['MainService'] == 'Flight' ||  $access['MainService'] == 'Hotel') {
                    $dataAccess[$key]['which']  = 'Foreign' ;
                }
            }
        }else{
            foreach ($dataAccess as $key => $access) {
                if($access['MainService'] == 'Flight' ||  $access['MainService'] == 'Hotel') {
                    $dataAccess[$key]['which']  = 'both' ;
                }
            }
        }
        return $dataAccess;
    }

}