<?php

class positions extends clientAuth
{

    /**
     * @var string
     */
    private $positionModel;
    protected $returnableServices=[];

    public function __construct() {

        parent::__construct();

    $this->returnableServices=functions::returnableServices();
        $this->positionModel = $this->getModel('positionsModel');
    }

    public function listAllPositions($serviceGroup = null) {
        if (!$serviceGroup) {
            return false;
        }
        if (isset($serviceGroup['service']) && $serviceGroup['service'] != '') {
            $serviceGroup = $serviceGroup['service'];
        }
        $allServiceGroup = $this->getServices();
        if (!in_array($serviceGroup, array_keys($allServiceGroup))) {
            return false;
        }
        $method = 'ListPosition' . $serviceGroup;

        return $this->$method();

    }

    public function getServices() {

        $services = $this->getAccessServiceClient();
        $list = [];
        foreach ($services as $service) {
            if (in_array($service['MainService'], array('Entertainment', 'Europcar'))) {
                continue;
            }
            $list[$service['MainService']] = $service;
        }

        return $list;
    }

    public function serviceIndexes($switch = GDS_SWITCH) {
        //search for defines in bootstrap for all services

        $result = $this->findDefines($switch);

        if (  isset($result['title']) && $result['title']  ) {
            if(isset($result['origin_country'])
                && isset($result['destination_country'])
                && isset($result['destination'])
                && $result['origin_country']['index'] == 'all'
                && $result['destination_country']['index'] == 'all'
                && $result['origin']['index'] == 'all'
                && $result['destination']['index'] == 'all'
            ){
                $result['title'] = $result['replacement_title'] ;
            } elseif(!isset($result['origin_country']) && !isset($result['destination']) && $result['origin']['index'] == 'all' && isset($result['destination']) && $result['destination']['index'] == 'all'){

                $result['title'] = $result['replacement_title'] ;
            }else {
                if($result['origin']['index'] == 'all' && $result['origin_country'] && $result['origin_country']['index'] != 'all') {

                    $result['origin']['data'] = $this->getServiceCity([
                        'service' => 'Country'.$result['service'],
                        'param' => [
                            $result['search_index'] => $result['origin_country']['index'] ,
                            'type'                  => 'origin'
                        ]

                    ]);
                }else{

                    $result['origin']['data'] = $this->getServiceCity([
                        'service' => $result['service'],
                        'param' => [
                            $result['search_index'] => $result['origin']['index'] ,
                            'type'                  => 'origin'
                        ]

                    ]);

                }


                if (isset($result['destination']) && $result['destination']) {


                    if($result['destination']['index'] == 'all' && $result['destination_country'] && $result['destination_country']['index'] != 'all') {

                        $result['destination']['data'] = $this->getServiceCity([
                            'service' => 'Country'.$result['service'],
                            'param' => [
                                $result['search_index'] => $result['destination_country']['index'] ,
                                'type'                  => 'destination'
                            ]

                        ]);
                    }else {
                        $result['destination']['data'] = $this->getServiceCity([
                            'service' => $result['service'],
                            'param' => [
                                $result['search_index'] => $result['destination']['index'],
                                'type' => 'destination'
                            ]
                        ]);
                    }
                }
            }


            $result['title'] = $this->setServiceTitle($result);

        }
        return $result;
    }

    /**
     * @param $switch
     * @return array
     */
    public function findDefines($switch) {

        $result = [
            'switch' => $switch
        ];
        switch ($switch) {
            case 'search-flight':
            case 'international':
                $result['service'] = 'Flight';
                $result['result_index'] = SOFTWARE_LANG == 'fa' ? 'DepartureCityFa' : 'DepartureCityEn';
                $result['search_index'] = 'DepartureCode';
                $result['origin']['index'] = SEARCH_ORIGIN;
                $result['destination']['index'] = SEARCH_DESTINATION;
                $result['title'] = functions::Xmlinformation('FlightFrom') . ' ' . '__origin__' . ' ' .functions::Xmlinformation('To') .' ' . '__destination__';

                break;
            case 'resultHotelLocal':
            case 'searchHotel':

                $result['service'] = 'Hotel';
                $result['result_index'] = SOFTWARE_LANG == 'fa' ?  'name' : 'name_en';
                $result['search_index'] = 'id';
                $result['origin']['index'] = SEARCH_CITY;

                if (isset($_GET['city']) && $_GET['city']) {
                    $result['origin']['index'] = $_GET['city'];
                }

                $result['destination']['index'] = null;
                $result['title'] = functions::Xmlinformation('Hotels') .' ' . '__origin__';

                break;
            case 'resultExternalHotel':
                $result['service'] = 'ExternalHotel';
                $result['result_index'] = 'city_name';
                $result['search_index'] = 'id';
                $result['origin']['index'] = SEARCH_CITY;
                $result['destination']['index'] = null;
                $result['title'] = functions::Xmlinformation('Hotels') .' ' . '__origin__';
                break;
            case 'resultInsurance':
                $result['service'] = 'Insurance';
                $result['result_index'] = 'persian_name';
                $result['search_index'] = 'abbr';
                $result['origin']['index'] = INSURANCE_DESTINATION;
                $result['destination']['index'] = null;
                $result['title'] = 'بیمه ی کشور ' . '__origin__';

                break;
            case 'buses':
            case 'resultBus':
                $result['service'] = 'Bus';
                $result['result_index'] = 'name_fa';
                $result['search_index'] = 'iataCode';
                $result['origin']['index'] = SEARCH_ORIGIN_CITY;
                $result['destination']['index'] = SEARCH_DESTINATION_CITY;
                $result['title'] = 'اتوبوس های ' . '__origin__' . ' به ' . '__destination__';

                break;
            case 'resultTrainApi':
            case 'resultTrain':
            case 'trainResult':
                $result['service'] = 'Train';
                $result['result_index'] = 'Name';
                $result['search_index'] = 'Code';
                $result['origin']['index'] = DEP_CITY;
                $result['destination']['index'] = ARR_CITY;
                $result['title'] = 'قطار های ' . '__origin__';

                break;
            case 'resultGasht':
                $result['origin']['index'] = CITY_CODE;
                $result['destination']['index'] = null;
                break;
            case 'tours':
            case 'resultTourLocal':

                $type = SEARCH_TOUR_TYPE ;
                $result['service'] = 'Tour';
                $result['result_index'] = SOFTWARE_LANG == 'fa'  ?  'name' : 'name_en';
                $result['origin']['index'] = SEARCH_ORIGIN_CITY;
                $result['destination']['index'] = SEARCH_DESTINATION_CITY;
                $result['search_index'] = 'id';
                $result['origin_country']['index'] = SEARCH_ORIGIN_COUNTRY;
                $result['destination_country']['index'] = SEARCH_DESTINATION_COUNTRY;

                if(SEARCH_ORIGIN_CITY == 'all' && SEARCH_DESTINATION_CITY == 'all' &&
                    SEARCH_ORIGIN_COUNTRY == 'all' && SEARCH_DESTINATION_COUNTRY == 'all'
                && isset($type) &&  SEARCH_TOUR_TYPE != 'all') {
                    $result['service'] = 'TourType';
                    $result['result_index'] = SOFTWARE_LANG == 'fa'  ?  'tour_type' : 'tour_type_en';
                    $result['destination']['index'] = $type;
                }

                if(SEARCH_ORIGIN_CITY == 'all' ) {
                    $result['title'] = functions::Xmlinformation('Tours'). ' ' . '__destination__';
                }else{
                    $result['title'] = functions::Xmlinformation('Tours'). ' ' . '__origin__' . ' '. functions::Xmlinformation('to'). ' ' . '__destination__';
                }

                $result['replacement_title'] = functions::Xmlinformation('Alltours');

                break;
            case 'flatResultVisa':
            case 'resultVisa':
                $result['service'] = 'Visa';
                $result['result_index'] = SOFTWARE_LANG == 'fa' ? 'titleFa' : 'titleEn' ;
                $result['search_index'] = 'code';
                $result['origin']['index'] = DESTINATION_CODE;
                $result['destination']['index'] = null;
                $result['title'] = functions::Xmlinformation('Visas') . ' ' . '__origin__';

                break;
            case 'resultEntertainment':
                $result['service'] = 'Entertainment';
                $result['result_index'] = SOFTWARE_LANG == 'fa' ? 'name' : 'name_en';
                $result['search_index'] = 'id';
                $result['origin']['index'] = CITY_ID;
                $result['destination']['index'] = null;
                $result['title'] = functions::Xmlinformation('Entertainment') . ' ' . '__origin__';

                break;
            case 'roomHotelLocal':
                $result['service'] = 'DetailHotel';
                $result['result_index'] = SOFTWARE_LANG == 'fa'  ?  'name' : 'name_en';
                $result['search_index'] = 'id';
                $result['origin']['index'] = HOTEL_ID;
//                $result['title'] = functions::Xmlinformation('Hotel'). ' ' . '__origin__';
                $result['title'] =   '__origin__';
                break;
            case 'detailTour':
                $result['service'] = 'DetailTour';
                $result['result_index'] = SOFTWARE_LANG == 'fa'  ?  'tour_name' : 'tour_name_en';
                $result['search_index'] = 'id_same';
                $result['origin']['index'] = TOUR_ID_SAME;
                $result['title'] = '__origin__';
                break;
        }
        return $result;
    }

    public function getServiceCity($param) {

        $allServiceGroup = $this->getServices();

        /*if (!in_array($param['service'], array_keys($allServiceGroup))) {
            return false;
        }*/
        if($param['param']['id'] == 'all'){
            if($param['param']['type'] == 'origin') {
                return [
                    'name'=>'همه مبدا ها',
                ];
            }
            elseif($param['param']['type'] == 'destination') {
                return [
                    'name'=>'همه مقاصد',
                ];
            }else {
                return [
                    'name'=>'همه',
                ];
            }

        }
        $method = 'find' . $param['service'] . 'Position';

        return $this->$method($param['param']);

    }

    /**
     * @param array $result
     * @return array|string|string[]
     */
    public function setServiceTitle(array $result) {

        return str_replace(['__origin__', '__destination__'], [
            $result['origin']['data'][$result['result_index']],
            $result['destination']['data'][$result['result_index']],
        ], $result['title']);
    }

    public function findFlightPosition($search_param) {

        return $this->getModel('airportModel')->get()
            ->where(key($search_param), $search_param[key($search_param)])
            ->find();
    }

    public function findInsurancePosition($search_param) {
        return $this->getModel('insuranceCountryModel')->get()
            ->where(key($search_param), $search_param[key($search_param)])
            ->find();
    }

    public function findHotelPosition($search_param) {

//        return $this->getModel('hotelCitiesModel')->get()
//            ->where(key($search_param), $search_param[key($search_param)])
//            ->find();
        return $this->getModel('reservationCityModel')->get()
            ->where(key($search_param), $search_param[key($search_param)])
            ->find();
    }

    public function findTrainPosition($search_param) {
        return $this->getModel('trainRouteCustomerModel')->get()
            ->where(key($search_param), $search_param[key($search_param)])
            ->find();
    }

    public function findBusPosition($search_param) {
        return $this->getModel('busRouteModel')->get()
            ->where(key($search_param), $search_param[key($search_param)])
            ->find();
    }

    public function findTourPosition($search_param) {

        return $this->getModel('reservationCityModel')->get()
            ->where(key($search_param), $search_param[key($search_param)])
            ->find();
    }

    public function findCountryTourPosition($search_param) {

        return $this->getModel('reservationCountryModel')->get()
            ->where(key($search_param), $search_param[key($search_param)])
            ->find();
    }
    public function findTourTypePosition($search_param) {

        return $this->getModel('reservationTourTypeModel')->get()
            ->where(key($search_param), $search_param[key($search_param)])
            ->find();
    }
    public function findEntertainmentPosition($search_param) {
        return $this->getModel('reservationCityModel')->get()
            ->where(key($search_param), $search_param[key($search_param)])
            ->find();
    }

    public function findVisaPosition($search_param) {
        return $this->getModel('countryCodesModel')->get()
            ->where(key($search_param), $search_param[key($search_param)])
            ->find();
    }

    public function findExternalHotelPosition($search_param) {

        return ['city_name' => $search_param[key($search_param)]];

    }

    public function findDetailHotelPosition($search_param) {
        return  $this->getModel('reservationHotelModel')->get()
            ->where(key($search_param), $search_param[key($search_param)])
            ->find();
    }

    public function findDetailTourPosition($search_param) {
        return  $this->getModel('reservationTourModel')->get()
            ->where(key($search_param), $search_param[key($search_param)])
            ->find();
    }

    public function ListPositionPublic() {
        return false;
    }

    public function ListPositionInternalFlight() {
        return self::ListPositionFlight();
    }

    public function ListPositionInternationalFlight() {
        return self::ListPositionFlight();
//        return false;
    }

    public function ListPositionFlight($search_param = null) {


        $airports = $this->getModel('airportModel')->get()->all();
        $list = [];

        foreach ($airports as $airport) {
            /*     if($airport['DepartureCode']=='KER'){
                     var_dump($airport);
                     die();
                 }*/
            $list[$airport['DepartureCode']] = [
                'name' => "{$airport['DepartureCityFa']}-{$airport['DepartureCode']}",
                'name_en' => $airport['AirportEn']
            ];
        }

        return $list;

    }



    public function ListPositionPackage($search_param = null) {


        $airports = $this->getModel('airportModel')->get()->all();
        $list = [];

        foreach ($airports as $airport) {
            /*     if($airport['DepartureCode']=='KER'){
                     var_dump($airport);
                     die();
                 }*/
            $list[$airport['DepartureCode']] = [
                'name' => "{$airport['AirportFa']}-{$airport['DepartureCode']}",
                'name_en' => $airport['AirportEn']
            ];
        }
        return $list;

    }

    public function ListPositionBus() {

        $sql = "SELECT * FROM bus_route_tb WHERE iataCode != '' ";
        $ModelBase = Load::library('ModelBase');
        $destinations = $ModelBase->select($sql);
        $list = [];
        foreach ($destinations as $destination) {
            $list[$destination['iataCode']] = ['name' => $destination['name_fa'], 'name_en' => $destination['name_en']];
        }

        return $list;
    }

    public function ListPositionInsurance() {
        $sql = "SELECT * FROM insurance_country_tb";
        $ModelBase = Load::library('ModelBase');
        $destinations = $ModelBase->select($sql);
        $list = [];
        foreach ($destinations as $destination) {
            $list[$destination['abbr']] = ['name' => $destination['persian_name'], 'name_en' => $destination['english_name']];
        }

        return $list;
    }

    public function ListPositionTrain() {
        $sql = "SELECT * FROM train_route_tb WHERE Code != '' ";
        $ModelBase = Load::library('ModelBase');
        $destinations = $ModelBase->select($sql);
        $list = [];
        foreach ($destinations as $destination) {
            $list[$destination['Code']] = ['name' => $destination['Name'], 'name_en' => $destination['EnglishName']];
        }

        return $list;
    }

    public function ListPositionGashtTransfer() {
        $sql = "SELECT * FROM gashtotransfer_cities_tb WHERE city_code != '' ";
        $ModelBase = Load::library('ModelBase');
        $destinations = $ModelBase->select($sql);
        $list = [];
        foreach ($destinations as $destination) {
            $list[$destination['city_code']] = ['name' => $destination['city_name'], 'name_en' => $destination['city_code']];
        }

        return $list;
    }

    public function ListPositionTour() {
        $sql = "SELECT * FROM reservation_city_tb ";
        $Model = Load::library('Model');
        $destinations = $Model->select($sql);
        $list = [];
        foreach ($destinations as $destination) {
            $list[$destination['id']] = ['name' => $destination['name'], 'name_en' => $destination['name_en']];
        }

        return $list;
    }

    public function ListPositionVisa() {
        $destinations=$this->getModel( 'reservationCountryModel')
            ->get()
            ->where( 'abbreviation', '', '!=' )
            ->all();

        $list = [];
        foreach ($destinations as $destination) {
            $list[$destination['abbreviation']] = ['name' => functions::arabicToPersian($destination['name']), 'name_en' => $destination['name_en']];
        }

        $types=$this->getModel('visaTypeModel')->get()
            ->where('isDell','no')
            ->all();

        return [
            'countries'=>$list,
            'types'=>$types,
        ];
    }

    public function ListPositionHotel() {

        /** @var hotelCitiesModel $hotel_cities */
        $hotel_cities = Load::getModel('hotelCitiesModel');
        $destinations = $hotel_cities->get()->all();
        $list = [];
        foreach ($destinations as $destination) {
            $list[$destination['id']] = ['name' => $destination['city_name'], 'name_en' => $destination['city_name_en']];
        }

        return $list;
    }

    public function getHotelCity($city) {
        $hotel_cities = $this->getModel('hotelCitiesModel');
        $destination = $hotel_cities->get()
            ->where('city_code', $city)
            ->find();


        if (!$destination) {
            $destination = $this->getModel('externalHotelCityModel')->get()
                ->where('city_name_en', $city)
                ->find();


            return $destination['country_name_en'] . '(' . $destination['city_name_en'] . ')';

        }

        return $destination['city_name'] . '(' . $destination['city_name_en'] . ')';
    }

    public function getItemsById($module,$id) {
        return $this->positionModel->get()
            ->where('item_id', $id)
            ->where('module', $module)
            ->all();
    }

    public function getItemsByPosition($module, $params) {
//        ['public','bus','flight']


        $items = $this->positionModel->get('item_id')
            ->where('1', 1)
            ->openParentheses() ;

        if(is_array($params['service'])){
            $array_item=array();
            foreach(@$params['service'] as $k => $v){
                $array_item[]=$v['MainService'];

            }
            $items = $items->whereIn('service',$array_item);
        }else {
            $items = $items->where('service', $params['service']);
        }

//            ->orWhere('service', 'Public')
        $items = $items->closeParentheses();




        if ($params['service'] === 'Visa') {


            $items = $items->where('1', 1)->openParentheses()
                ->where('origin', $params['origin'] . ':' . $params['type'])
                ->orWhere('origin', $params['origin'] . ":all")
                ->orWhere('origin', "all" . ":all")
                ->closeParentheses();


        } else {
            $origin = isset($params['origin'])?$params['origin']:'';
            $items = $items->openParentheses()
                ->where('origin', $origin)
                ->orWhere('origin', 'all')
                ->closeParentheses();
        }

        $items =
            $items
                ->openParentheses()
                ->where('module', $module)
                ->orWhere('module', 'all')
                ->closeParentheses();

        if (!empty($params['destination'])) {

            $items = $items
                ->openParentheses()
                ->where('destination', $params['destination'])
                ->orWhere('destination', 'all')
                ->closeParentheses();
        }

        $items = $items->all();

        $ids = [];
        foreach ($items as $item) {
            $ids[] = $item['item_id'];
        }

        return $ids;
    }

    public function resetPositions($module, $item_id,$params) {
        $this->positionModel->delete(['item_id' => $item_id,'module' => $module]);
        $this->storePositions($module, $item_id,$params);
    }
    public function storePositions($module, $item_id, $params)
    {



        foreach ($params as $service=>$positions) {


            if (in_array($service, $this->returnableServices)) {
                $returnable_services = true;
            } else {
                $returnable_services = false;
            }
            if (isset($positions) && $positions != '') {


                $pre_data = [
                    'module' => $module,
                    'item_id' => $item_id,
                    'service' => $service
                ];

                $final_data = [];

                foreach ($positions['origin'] as $key => $origin) {

                    $data = $pre_data;
                    $data['origin'] = $origin;

                    if ($service==='Visa') {
                        $data['origin'] .= ':'.$positions['Type'][$key];
                    }else{
                        $data['destination'] = $positions['destination'][$key];
                    }
                    $final_data[] = $data;
                }

                foreach ($final_data as $item) {
                    $this->positionModel->insertWithBind($item);
                }
            }
        }

    }

    public function getPositions($module,$id) {


        $positions = $this->getItemsById($module,$id);

        $city = [];



        foreach ($positions as $key=>$position) {



            switch ($position['service']) {
                case 'Package' :
                case 'Flight' :

                    $city[$position['service']][$key]['origin']= [
                        'title' => isset($this->ListPositionFlight()[$position['origin']]['name']) ? $this->ListPositionFlight()[$position['origin']]['name'] : '',
                        'id' => $position['origin']
                    ];


                    if(!empty($position['destination'])){
                        $city[$position['service']][$key]['destination'] = [
                            'title' => isset(self::ListPositionFlight()[$position['destination']]['name']) ? self::ListPositionFlight()[$position['destination']]['name'] : '',
                            'id' => $position['destination']
                        ];
                    }

                    break;
                case 'internalFlight' :

                    $city[$position['service']][$key]['origin']= [
                        'title' => isset($this->ListPositionFlight()[$position['origin']]['name']) ? $this->ListPositionFlight()[$position['origin']]['name'] : '',
                        'id' => $position['origin']
                    ];


                    if(!empty($position['destination'])){
                        $city[$position['service']][$key]['destination'] = [
                            'title' => isset(self::ListPositionInternalFlight()[$position['destination']]['name']) ? self::ListPositionInternalFlight()[$position['destination']]['name'] : '',
                            'id' => $position['destination']
                        ];
                    }

                    break;
                case 'internationalFlight' :

                    $city[$position['service']][$key]['origin']= [
                        'title' => isset($this->ListPositionFlight()[$position['origin']]['name']) ? $this->ListPositionFlight()[$position['origin']]['name'] : '',
                        'id' => $position['origin']
                    ];


                    if(!empty($position['destination'])){
                        $city[$position['service']][$key]['destination'] = [
                            'title' => isset(self::ListPositionInternationalFlight()[$position['destination']]['name']) ? self::ListPositionFlight()[$position['destination']]['name'] : '',
                            'id' => $position['destination']
                        ];
                    }

                    break;
                case 'Hotel':
                    $city[$position['service']][$key]['origin'] = [
                        'title' => $this->getHotelCity($position['origin']),
                        'id' => $position['origin']
                    ];
                    break;

                case 'Insurance':
                case 'GashtTransfer':
                    $city[$position['service']][$key]['origin'] = [
                        'title' => isset($this->{"ListPosition" . $position['service']}()[$position['origin']]['name']) ? $this->{"ListPosition" . $position['service']}()[$position['origin']]['name'] : '',
                        'id' => $position['origin']
                    ];
                    break;

                case 'Bus' :
                    $city[$position['service']][$key]['origin'] = [
                        'title' => isset($this->ListPositionBus()[$position['origin']]['name']) ? $this->ListPositionBus()[$position['origin']]['name'] : '',
                        'id' => $position['origin']
                    ];

                    if (!empty($position['destination'])) {
                        $city[$position['service']][$key]['destination'] = [
                            'title' => isset(self::ListPositionBus()[$position['destination']]['name']) ? self::ListPositionBus()[$position['destination']]['name'] : '',
                            'id' => $position['destination']
                        ];
                    }

                    break;
                case 'Insurance' :

                    $city[$position['service']][$key]['origin'] = [
                        'title' => isset($this->ListPositionInsurance()[$position['origin']]['name']) ? $this->ListPositionInsurance()[$position['origin']]['name'] : '',
                        'id' => $position['origin']
                    ];
                    break;
                case 'Train' :
                    $city[$position['service']][$key]['origin'] = [
                        'title' => isset($this->ListPositionTrain()[$position['origin']]['name']) ? $this->ListPositionTrain()[$position['origin']]['name'] : '',
                        'id' => $position['origin']
                    ];


                    if (!empty($position['destination'])) {
                        $city[$position['service']][$key]['destination'] = [
                            'title' => isset(self::ListPositionTrain()[$position['destination']]['name']) ? self::ListPositionTrain()[$position['destination']]['name'] : '',
                            'id' => $position['destination']
                        ];
                    }


                    break;
                case 'GashtTransfer' :

                    $city[$position['service']][$key]['origin'] = [
                        'title' => isset($this->ListPositionGashtTransfer()[$position['origin']]['name']) ? $this->ListPositionGashtTransfer()[$position['origin']]['name'] : '',
                        'id' => $position['origin']
                    ];

                    break;
                case 'Tour' :


                    $city[$position['service']][$key]['origin'] = [
                        'title' => isset($this->ListPositionTour()[$position['origin']]['name']) ? $this->ListPositionTour()[$position['origin']]['name'] : '',
                        'id' => $position['origin']
                    ];


                    if (!empty($position['destination'])) {
                        $city[$position['service']][$key]['destination'] = [
                            'title' => isset(self::ListPositionTour()[$position['destination']]['name']) ? self::ListPositionTour()[$position['destination']]['name'] : '',
                            'id' => $position['destination']
                        ];
                    }

                    break;
                case 'Visa' :
                    $position_data=explode(':',$position['origin']);
                    $name=$position_data[0];
                    $type=$position_data[1];


                    $city[$position['service']][$key]['origin'] = [
                        'title' => isset(self::ListPositionVisa()['countries'][$name]['name']) ? self::ListPositionVisa()['countries'][$name]['name'] : '',
                        'id' => $name,
                        'type' => $type,
                    ];
                    break;

                case 'Public' :
                    $city[$position['service']][$key]['origin'] = [
                        'title' => 'عمومی',
                        'id' => 'all'
                    ];
                    break;
                case 'contactUs' :
                    $city[$position['service']][$key]['origin'] = [
                        'title' => 'تماس با ما',
                        'id' => 'all'
                    ];
                    break;

//                case 'internalFlight' :
//
//                    $city[$position['service']][$key]['origin'] = [
//                        'title' => 'پرواز داخلی',
//                        'id' => 'all'
//                    ];
//
//                    break;
//                case 'internationalFlight' :
//                    $city[$position['service']][$key]['origin'] = [
//                        'title' => 'پرواز خارجی',
//                        'id' => 'all'
//                    ];
//                    break;



            }

        }

        foreach ($city as $key=>$items) {


            foreach ($items as $key2=>$item) {

                if($item['origin']['id'] == 'all'){
                    $city[$key][$key2]['origin']['title'] ='همه مبدا ها';
                }
                if($item['destination']['id'] == 'all'){
                    $city[$key][$key2]['destination']['title'] ='همه مقصد ها';
                }

                if(!array_key_exists('destination', $item)){
                    $city[$key][$key2]['destination'] = null;
                }

            }
        }

        return $city;
    }




    public function getAllTextSearchResultsByPosition($data) {

        $module = $data['service'];
        $destination = $data['destination'];
        if ($data['service'] == 'Visa') {
            $origin = $data['origin'].':'.$data['type'];
        }else{
            $origin = $data['origin'];
        }
        $Model   = Load::library( 'Model' );
        $sql = " SELECT
                  S.id, S.title,S.content
              FROM
                  special_pages_tb AS S
                  INNER JOIN positions_tb AS P ON P.item_id = S.id
              WHERE
                  P.module = 'special_pages' AND S.deleted_at IS NULL AND P.service = '{$module}' 
              ";
        if ( isset( $origin ) ) {
            $sql .= " AND P.origin = '{$origin}' ";
        }
        if ( isset( $destination ) ) {
            $sql .= " AND P.destination = '{$destination}' ";
        }
        $sql    .= "
            GROUP BY S.id
            ORDER BY P.id DESC
          ";
        $result = $Model->select( $sql );
        $except_module = array('Visa' , 'Hotel' , 'Insurance');
        if (in_array($module, $except_module)){
            if (isset($origin)) {
                return $result;
            }
        }else{
            if ( isset( $origin ) && isset( $destination ) ) {
                return $result;
            }
        }
    }

}