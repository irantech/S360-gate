<?php
//todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************
//if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}

class shahikaParvaz extends mainPage {

    public function __construct() {

        parent::__construct();
        $this->icons_json =  json_decode($this->icons_json, true);

    }

    public $icons_json = '{
"Tour_internal": {"icon": "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-suitcase-fill\" viewBox=\"0 0 16 16\"><path d=\"M6 .5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V3h1.5A1.5 1.5 0 0 1 13 4.5v9a1.5 1.5 0 0 1-1.004 1.416A1 1 0 1 1 10 15H6a1 1 0 1 1-1.997-.084A1.5 1.5 0 0 1 3 13.5v-9A1.5 1.5 0 0 1 4.5 3H6zM9 1H7v2h2zM6 5.5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0zm2.5 0a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0zm2.5 0a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0z\"/></svg>", "name": "تور داخلی"},
"Tour_external": {"icon": "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-suitcase-fill\" viewBox=\"0 0 16 16\"><path d=\"M6 .5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V3h1.5A1.5 1.5 0 0 1 13 4.5v9a1.5 1.5 0 0 1-1.004 1.416A1 1 0 1 1 10 15H6a1 1 0 1 1-1.997-.084A1.5 1.5 0 0 1 3 13.5v-9A1.5 1.5 0 0 1 4.5 3H6zM9 1H7v2h2zM6 5.5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0zm2.5 0a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0zm2.5 0a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0z\"/></svg>", "name": "تور خارجی"},
               }';


    public function classTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'Flight_internal':
                return 'fa-light fa-plane-circle-check';
                break;
            case 'Flight_external':
                return 'fa-light fa-plane-circle-check';
                break;
            case 'Hotel_internal':
                return 'fa-light fa-bell-concierge';
                break;
            case 'Hotel_external':
                return 'fa-light fa-bell-concierge';
                break;
            case 'Bus':
                return 'fa-light fa-bus';
                break;
            case 'Tour_internal':
                return 'fa-light fa-suitcase-rolling';
                break;
            case 'Tour_external':
                return 'fa-light fa-suitcase-rolling';
                break;
            case 'Visa':
                return 'fa-light fa-book-atlas';
                break;
            default:
                return '';


        }
    }

    public function newClassTabsSearchBox($service_name) {
        return $this->getServicesFromIds($this->icons_json)[$service_name];
    }
    public function newClassTabsSearchBox11($service_name) {
        switch ($service_name) {
            case 'Flight_internal':
                return 'fa-light fa-plane-circle-check';
                break;
            case 'Flight_external':
                return 'fa-light fa-plane-circle-check';
                break;
            case 'Hotel_internal':
                return 'fa-light fa-bell-concierge';
                break;
            case 'Hotel_external':
                return 'fa-light fa-bell-concierge';
                break;
            case 'Tour_internal':
                return 'fa-light fa-suitcase-rolling';
                break;
            case 'Tour_external':
                return 'fa-light fa-suitcase-rolling';
                break;

            default:
                return '';


        }
    }

    public function getServicesFromIds($json_array) {
        $icon_array = $this->getItemsBykeyFromJsonServicesArray($json_array, 'icon');

        $new_array = [];
        foreach ($icon_array as $id => $icon) {
            $service = str_replace(['_internal', '_external'], '', $id);
            $new_array[$service][$id] = $icon;
        }
        return $new_array;
    }

    public function getItemsBykeyFromJsonServicesArray($json_array, $key) {
        $array = $json_array;
        $new_array = [];
        foreach ($array as $service => $val) {
            $new_array[$service] = $val[$key];
        }
        return $new_array;
    }


    public function nameTabsSearchBox($service_name) {
        $result_array = $this->getItemsBykeyFromJsonServicesArray($this->icons_json, 'name');
        return $result_array[$service_name];
    }


    public function nameBoxSearchBox($service_name) {
        $result_array = $this->getItemsBykeyFromJsonServicesArray($this->icons_json, 'name');
        return $result_array[$service_name];
    }
    public function getInfoAuthClient() {
        if(functions::isTestServer()) {
            $access_list = ['Tour'] ;

            $access_service =  $this->getAccessServiceClient();

            $access_result = [];
            foreach ($access_list as $key => $access) {
                $key  = array_search($access, array_column($access_service, "MainService"));
                $access_result[] = $access_service[$key] ;
            }
            foreach ($access_result as $key => $access) {

                if($access['id'] ==  6) {

                    $internal_tour = [
                        'id'            => 0,
                        'MainService'   =>  'Tour_internal' ,
                        'Title' => ' داخلی',
                        'order_number'  => 1
                    ];
                    $external_tour = [
                        'id'            => 0,
                        'MainService'   =>  'Tour_external' ,
                        'Title' => ' خارجی',
                        'order_number'  => 2
                    ];

                    array_unshift($access_result,$internal_tour,$external_tour);
                }

            }
            return $access_result;
        }
        return  $this->getAccessServiceClient();
    }
}