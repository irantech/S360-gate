<?php

//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
abstract class mainPage extends clientAuth
{
    public $pageInfo = [];
    /** @var breadcrumb $this ->breadcrumb_controller */
    public $breadcrumb_controller = null;
    public $info_page_controller = null;
    public $breadcrumb = [];

    public function __construct() {
        parent::__construct();

//        Session::init();
        if (GDS_SWITCH == 'mainPage') {
            Session::setSessionSelectLayout('web');
        }



        /** @var infoPages $info_page_controller */
        $this->info_page_controller = $this->getController('infoPages');
        $info_page = $this->info_page_controller->getInfoPagByGdsSwitch(GDS_SWITCH);

        $this->breadcrumb_controller = $this->getController('breadcrumb');
        $this->breadcrumb_controller->getPreviousPageInfo();

        if($info_page && ($info_page['switch']['gds_switch'] !=='mainPage' && $info_page['switch']['gds_switch'] !=='roomHotelLocal')){
          
            $this->pushBreadcrumb($info_page['heading'], ROOT_ADDRESS . '/' . GDS_SWITCH .'/');
        }


        $this->pageInfo = $this->getInfoPage();
    }

    public function pushBreadcrumb($heading, $link=null) {

        $this->breadcrumb_controller->push($heading, $link);
        $this->breadcrumb = $this->breadcrumb_controller->breadcrumb;

    }

    public function aboutIran($limit) {
        $aboutIran=$this->getController('aboutIran');
        $items=$aboutIran->GetCity();
        $result=[];
        foreach ($items as $key=>$item) {
            $result[$key] = $item;
            $result[$key]['subtitle'] = $aboutIran->my_substr(strip_tags($item['ci_tari']) , 0 , 800);
            if($key+1 == $limit)
                return $result;
        }
        return $result;
    }
    public function getInfoPage() {

        if (in_array(GDS_SWITCH, functions::excludeGdsSwitch()) && (defined('MAG_TITLE') ||
                defined('NEWS_TITLE') ||  defined('ROOM_HOTEL_TITLE')|| defined('PAGE_TITLE'))) {


            if ((GDS_SWITCH == 'mag' || GDS_SWITCH == 'news')) {


                $slug_name = null;
                if (GDS_SWITCH === 'mag') {
                    $slug_name = MAG_TITLE;
                } else {
                    $slug_name = NEWS_TITLE;
                }

                if ($slug_name) {

                    $array_search_slug = array('slug' => $slug_name, 'section' => GDS_SWITCH);

                    if($array_search_slug['slug'] == 'category'){

                        $category=$this->getController('articles')->getInfoMetaTag(MAG_CATEGORY, $array_search_slug);

                        $this->pushBreadcrumb($category['title'], ROOT_ADDRESS . '/' . GDS_SWITCH. '/' . $slug_name . '/' . MAG_CATEGORY);

                        return $category;
                    }


                    $item=$this->getController('articles')->getInfoMetaTag(GDS_SWITCH, $array_search_slug);
                    
                    $this->pushBreadcrumb($item['heading'], ROOT_ADDRESS . '/' . GDS_SWITCH . '/' . $slug_name);
//                    var_dump($hotel_info);
//                    die;
                    return $item;

                }


            }
            elseif (GDS_SWITCH == 'page') {
                $slug_name = PAGE_TITLE;
                $array_search_slug = array('slug' => $slug_name, 'section' => GDS_SWITCH);
                $page_info=$this->getController('specialPages')->getInfoMetaTag($array_search_slug);

                $this->pushBreadcrumb($page_info['heading'], ROOT_ADDRESS . '/' . GDS_SWITCH . '/' . $slug_name);

                return $page_info;
            }
            elseif (GDS_SWITCH == 'roomHotelLocal') {
                $slug_name = ROOM_HOTEL_TITLE;
                $hotel_id = HOTEL_ID;
                $array_search_slug = array('slug' => $slug_name, 'section' => GDS_SWITCH , 'hotelId' => $hotel_id);
                $hotel_info=$this->getController('reservationHotel')->getInfoMetaTag($array_search_slug);



                $this->pushBreadcrumb($hotel_info['heading'], ROOT_ADDRESS . '/' . GDS_SWITCH . '/' . $slug_name);

                return $hotel_info;
            }

        }


        return $this->info_page_controller->getInfoPagByGdsSwitch(GDS_SWITCH);
    }

    /**
     * @return mixed
     */
    public function getInfoAuthClient() {
        return $this->getAccessServiceClient();
    }

    abstract public function classTabsSearchBox($service_name);

    public function dataFastSearchInternalFlight($params) {

        $array_cities = array();
        $params_search['limit'] = isset($params['limit']) ? $params['limit'] : '';
        $params_search['is_group'] = isset($params['is_group']) ? $params['is_group'] : '';
        $params_search['use_customer_db'] = isset($params['use_customer_db']) ? $params['use_customer_db'] : '';
        $cities = $this->getController('routeFlight')->flightRouteInternal($params_search);
        
        $array_cities['start_date'] = date('Y-m-d');
        foreach ($cities as $key => $city) {
            $array_cities['cities_flight'][$key]['main'] = $city;
            foreach ($cities as $key_sub_city => $sub_city) {
                if ($sub_city['Departure_Code'] != $city['Departure_Code']) {
                    $array_cities['cities_flight'][$key]['sub_cities'][] = $sub_city;
                }

            }
        }

        return $array_cities;
    }

    public function hashPasswordUser() {

        if ($this->isLogin()) {
            $member_id = isset($_SESSION["userId"]) ? $_SESSION["userId"] : '';
            $user_info = $this->getController('members')->getMember($member_id);
            return (functions::HashKey($user_info['email'], 'encrypt'));
        }

        return false;
    }

    public function isLogin() {
        if (isset($_SESSION["Login"]) && $_SESSION['Login'] == 'success') {

            return true;
        } else {

            return false;
        }
    }

    public function checkIsCounter() {
        return $this->getController('members')->isCounter();
    }

    public function cityDepartureFlightInternal($use_customer_db) {
        $param['use_customer_db'] = false;
        return $this->getController('routeFlight')->flightRouteInternal($param);
    }


//    public function getListContinents() {
//        return $this->getController('continentCodes')->getListContinents();
//    }
    public function getListCountriesAll() {
        return $this->getController('country')->getCountriesWithVisa();
    }
    public function getListContinents() {
        return $this->getController('continentCodes')->getListContinentsWithVisa();
    }


    public function countriesHaveVisa($continent_id) {
        return $this->getController('visa')->countriesHaveVisaByContinentId($continent_id);
    }

    public function continentsHaveVisa() {
        return $this->getController('visa')->continentsHaveVisa();
    }

    public function countryInsurance() {
        return $this->getController('insuranceCountry')->AllCountryInsurance();
    }
    public function countryInsuranceExternal() {
        return $this->getController('insuranceCountry')->ExternalCountryInsurance();
    }

    public function trainListCity() {

        return $this->getController('routeTrain')->ListRoute();
    }

    public function getOriginTourCities($params = null) {
        $params['get_origin'] = 'yes';
        return json_decode($this->getController('mainTour')->getTourCities($params), true)['data'];

    }

    public function datesTour() {

        $all_dates['value'] = 'all' ;
        $all_dates['text']  = functions::Xmlinformation('All') ;

        $result = functions::datesTour();
        array_unshift($result, $all_dates) ;
        return $result;
    }

    public function getCountryEntertainment() {
        return $this->getController('entertainment')->getCountries();
    }

    public function getCitiesGashtTransfer() {
        return $this->getController('gashToTransferCities')->gashtTransferCities();
    }

    public function faqsPosition($section) {
        return $this->getController('faqs')->getByPosition($section);
    }
    public function faqsPositionMain($section) {
        $result =  $this->getController('faqs')->allFaqMainByPosition($section);

        return $result;
    }

    public function articlesPosition($section) {
        return $this->getController('articles')->getByPosition($section);
    }

    public function getCategoryArticles($params) {
        return $this->getController('articles')->getCategoryArticles($params);
    }


    public function articlesCategoriesMain($params) {
        return $this->getController('articles')->getCategoriesMain($params);
    }

    public function getArticleCategory($section) {
        return $this->getController('articles')->getCategoryArticles($section);
    }

    public function dataFastSearchInternationalFlight($params) {
        $array_cities = array();
        $cities = $this->getController('routeFlight')->defaultInternationalFlight($params);

        foreach ($cities as $key => $city) {
            if ($city['DepartureCode'] == $params['origin_city']) {
                $array_cities['main'] = $city;
            } else {
                $array_cities['sub_cities'][] = $city;
            }
        }

        return $array_cities;
    }


    public function getSpecialPageData($params) {
        return $this->getController('specialPages')->getPage($params);
    }

    public function internalTours($params) {
        $limit = 10;
        if (isset($params['limit']) && $params['limit']) {
            $limit = $params['limit'];
        }
        $conditional = array(
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
        );

        if (isset($params['is_external']) && $params['is_external']) {

            $conditional = array(
                array(
                    'index' => 'destination_country_id',
                    'table' => 'reservation_tour_rout_tb',
                    'operator' => '!=',
                    'value' => '1',
                ),

            );
        }

        $date = dateTimeSetting::jdate("Ymd", time(), '', '', 'en');


        $require_params = array(
            'method' => 'tourList',
            'limit' => 8,
            'conditions' => array(

                array(
                    'index' => 'tour_title',
                    'table' => 'reservation_tour_rout_tb',
                    'operator' => '=',
                    'value' => 'dept',
                ),
                array(
                    'index' => 'start_date',
                    'table' => 'reservation_tour_tb',
                    'operator' => '>',
                    'value' => $date,
                ),
                array(
                    'index' => 'start_date',
                    'table' => 'reservation_tour_tb',
                    'operator' => '<',
                    'value' => '20000101',
                ),
            )
        );

        $require_params['conditions'] = array_merge($require_params['conditions'], $conditional);


        return $this->getController('mainTour')->getTourList($require_params);
    }

    public function getRecommendationPosition($params) {
        return $this->getController('recommendation')->getRecommendationsPosition($params);
    }

    public function galleryBannerMain($type_data) {
        return $this->getController('galleryBanner')->listGalleryBanner($type_data);
    }

    public function getToursReservation($params) {
        return $this->getController('reservationTour')->getTourReservationData($params);
    }

    public function getHotelReservation($params) {

        return $this->getController('reservationHotel')->hotelReservationData($params);
    }
    public function getHotelReservationMarketPlace($params) {

        return $this->getController('reservationHotel')->hotelReservationMarketPlaceData($params);
    }
    public function getNewsArticles() {

        /** @var articles $article_controller */
        $article_controller=$this->getController('articles');
        $article_controller->page_limit=3;
        return $article_controller->getArticles('news');
    }


    public function getReservationTourCities($type = 'internal') {
        $reservation_basic_controller=$this->getController('reservationBasicInformation');
        if($type == 'internal') {
            $result = $reservation_basic_controller->ReservationTourCities('=1', 'return');
        }else{
            $result = $reservation_basic_controller->ReservationTourCities('!=1', 'return');
        }
        return $result;
    }

    public function getReservationTourCountries() {
        $reservation_basic_controller=$this->getController('reservationBasicInformation');
        return $reservation_basic_controller->ReservationTourCountries('yes');
    }


    public function getHotelWebservice($params) {

        $result = [] ;
        if($params['type'] == 'internal') {
            $hotel_ids = array(
                "934",
                "1028",
                "1655",
                "1276",
                "999",
                "1426",
                "1118",
                "1507",
                "1234",
                "793",
                "76",
                "215",
                "588",
                "721",
                "832",
                "140",
            );
            $params['HotelIds'] = $hotel_ids ;
            $params['IsInternal'] = true ;
            if(isset($params['star_code'])) {
                $params['star_code'] = $params['star_code'];
            }
        }else {
            $city_ids = array(
                "23595",
                "23607",
                "325",
                "320",
                "5293",
                "7204",
                "8336",
                "6442",
                "23077",
                "23107",
                "45240",
                "26582",
                "75286"
            );
            $params['CityIds'] = $city_ids ;
            $params['IsInternal'] = false ;
        }


        Load::library( 'ApiHotelCore' );
        $ApiHotelCore = new ApiHotelCore();
        $response = $ApiHotelCore->RandomHotelList($params)  ;

        $response = json_decode($response , true) ;

        if(isset($response['StatusCode']) && $response['StatusCode'] == '200'){
            $result = $response['Result'] ;
        }

        return $result;

    }

    public function getExternalHotelCity($params=[]) {
        /** @var ModelBase $ModelBase */
        $limit = 20;
        if (isset($params['Count']) && $params['Count']) {
            $limit = $params['Count'];
        }
        if ( isset( $_POST['self_Db'] ) && $_POST['self_Db'] != true ) {

            $ModelBase = Load::library( 'ModelBase' );
            $clientSql = "SELECT DepartureCode,DepartureCityEn,DepartureCityFa,AirportFa,AirportEn,CountryFa,CountryEn  FROM flight_portal_tb  Where DepartureCode != 'IKA' and DepartureCode != 'NJF' and DepartureCode != 'BGW'and DepartureCode != 'FRAALL' LIMIT $limit";

            $result = $ModelBase->select( $clientSql ) ;
        } else {

            $Model = Load::library( 'Model' );
            $clientSql = "SELECT DepartureCode,DepartureCityEn,DepartureCityFa,AirportFa,AirportEn,CountryFa,CountryEn  FROM flight_portal_tb Where DepartureCode != 'IKA' and DepartureCode != 'NJF' and DepartureCode != 'BGW'and DepartureCode != 'FRAALL'  LIMIT $limit";

            $result =  $Model->select( $clientSql ) ;
        }
        foreach ($result as $key => $flight) {

            $countryNameEn = strtolower(trim($flight['CountryEn']));
            $countryNameEn = str_replace("  ", " ", $countryNameEn);
            $countryNameEn = str_replace(" ", "-", $countryNameEn);
            $cityNameEn = strtolower(trim($flight['DepartureCityEn']));
            $cityNameEn = str_replace("  ", " ", $cityNameEn);
            $cityNameEn = str_replace(" ", "-", $cityNameEn);

            $result[$key]['DepartureCityEn'] = $cityNameEn;
            $result[$key]['CountryEn'] = $countryNameEn;

        }
        return $result ;
    }

    public function getDailyQuote($params){
        return $this->getController('dailyQuote')->listDailyQuote($params);
    }
    public function getVideo($params){
        return $this->getController('video')->listVideo($params);
    }

    public function getBusRoutes(){
        $result = $this->getController('busRoute')->routeBus();
        $result =  json_decode($result , true);
        return $result['results'];
    }

    public function getTypeVehicle($tour_id){
        $result = $this->getController('resultTourLocal')->getTypeVehicle($tour_id);
      
        return $result['dept']['vehicle']['photo'];
    }
    public function getVehicleType($tour_id){
        $result = $this->getController('resultTourLocal')->getTypeVehicle($tour_id);
        return $result;
    }

    public function aboutIranMain($get_data) {
        return $this->getController('introductIran')->listProvinceSite($get_data);
    }

    public function aboutCountryMain($get_data) {
        return $this->getController('aboutCountry')->listCoutries($get_data);
    }
    public function recommendationMain($get_data) {
        $result =  $this->getController('recommendation')->getRecommendations(null , null, null  , false , $get_data);
        return $result;
    }


    public function search_box_tabs_order($services, $order_array) {
        $ordred_services = [];
        foreach ($order_array as $item) {
            foreach ($services as $key => $val) {
                if ($val['MainService'] == $item) {
                    $ordred_services[] = $val;
                }
            }
        }
        return $ordred_services;
    }
    public function getTypeCar($type_data){
        $result = $this->getController('rentCar')->listCategory($type_data);
//        $result =  json_decode($result , true);
        return $result;
    }

    public function getExternalHotelCityList(){

        return $this->getController('resultExternalHotel')->externalHotelCityList();
    }

    public function reservationTourCount(){
        return $this->getController('reservationTour')->reservationTourCount();
    }
    public function citiesWithTour($params){
        return $this->getController('reservationTour')->getCitiesWithTour($params);
    }
    public function commentMainPage($section) {
        return $this->getController('comments')->getByCommentMainPage($section);
    }

}