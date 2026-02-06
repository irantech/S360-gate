
        <?php
    //todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************
    //if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//        error_reporting(1);
//        error_reporting(E_ALL | E_STRICT);
//        @ini_set('display_errors', 1);
//        @ini_set('display_errors', 'on');
    //}

    class kishOnTime extends mainPage {

        public function __construct() {

            parent::__construct();
            $this->icons_json =  json_decode($this->icons_json, true);
        }

//        public $icons_json = '{"Flight-internal": {"icon": "<i aria-hidden=\"true\" class=\"fa fa-plane\"></i>", "name": "پرواز داخلی"}, "Flight-international": {"icon": "<i aria-hidden=\"true\" class=\"fa fa-plane\"></i>", "name": "پرواز خارجی"}, "Entertainment": {"icon": "<i class=\"fas fa-umbrella-beach\"></i>", "name": "تفریحات"}, "Hotel": {"icon": "<i aria-hidden=\"true\" class=\"fa fa-bed\"></i>", "name": "هتل داخلی"}, "Visa": {"icon": "<i class=\"fas fa-passport\"></i>", "name": "ویزا"}, "Insurance": {"icon": "<i class=\"flaticon fas fa-umbrella\"></i>", "name": "بیمه"}}';

            public $icons_json = '{"Flight_internal": {"name": "پرواز داخلی" , "icon": "<i aria-hidden=\"true\" class=\"fa fa-plane\"></i>"},
                                "Flight_external": {"name": "پرواز خارجی", "icon": "<i aria-hidden=\"true\" class=\"fa fa-plane\"></i>"},
                                "Entertainment": {"name": "تفریحات", "icon": "<i class=\"fas fa-umbrella-beach\"></i>"},
                                "Hotel": {"name": "هتل داخلی", "icon": "<i class=\"fal fa-hotel\"></i>"},
                                "Visa": {"name": "ویزا", "icon": "<i class=\"fal fa-hotel\"></i>"},
                                "Insurance": {"name": "بیمه", "icon": "<i class=\"fal fa-umbrella-beach\"></i>"}

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