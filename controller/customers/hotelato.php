<?php
//todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************
//if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}

class hotelato extends mainPage {

    public function __construct() {

        parent::__construct();
        $this->icons_json =  json_decode($this->icons_json, true);
        
    }




    public $icons_json = '{"Flight": {"name": "هواپیما" , "icon": "<i class=\"fa-light fa-plane-circle-check\"></i>"},
                                "Hotel": {"name": "هتل", "icon": "<i class=\"fa-light fa-bell-concierge\"></i>"},
                                "Bus": {"name": "اتوبوس", "icon": "<i class=\"fa-light fa-bus\"></i>"},
                                "Tour": {"name": "تور", "icon": "<i class=\"fa-light fa-bell-concierge\"></i>"},
                                "Residence": {"name": "اقامتگاه", "icon": "<i class=\"fa-light fa-bell-concierge\"></i>"},
                                "Insurance": {"name": "بیمه", "icon": "<i class=\"fa-light fa-umbrella-beach\"></i>"},
                                "Visa": {"name": "ویزا", "icon": "<i class=\"fa-light fa-bell-concierge\"></i>"}

}';
    
    
    public function getInfoAuthClient() {

//            $access_list = ['Flight' , 'Hotel' , 'Tour'  , 'Visa'] ;
            $access_service =  $this->getAccessServiceClient();
            $access_result = [];
//            foreach ($access_list as $key => $access) {
//                $key  = array_search($access, array_column($access_service, "MainService"));
//                $access_result[] = $access_service[$key] ;
//            }
            $access_result[] = [
                'id'            => 1,
                'MainService'   =>  'Flight' ,
                'Title' => ' هواپیما',
                'order_number'  => 1
                ];
            $access_result[] = [
                'id'            => 2,
                'MainService'   =>  'Hotel' ,
                'Title' => 'هتل',
                'order_number'  => 2
                ];
            $access_result[] = [
                'id'            => 3,
                'MainService'   =>  'Residence' ,
                'Title' => ' اقامتگاه',
                'order_number'  => 3
            ];
            $access_result[] = [
                'id'            => 4,
                'MainService'   =>  'Bus' ,
                'Title' => ' اتوبوس',
                'order_number'  => 4
            ];
            $access_result[] = [
                'id'            => 5,
                'MainService'   =>  'Insurance' ,
                'Title' => ' بیمه',
                'order_number'  => 5
            ];

//            if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
//                echo json_encode($access_result);
//                die;
//            }


//            $access_list[] =
            return $access_result;

//        return  $this->getAccessServiceClient();
    }

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
         case 'Residence':
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
}
