
        <?php

            error_reporting(1);
            error_reporting(E_ALL | E_STRICT);
            @ini_set('display_errors', 1);
            @ini_set('display_errors', 'on');

    class shabbadGashtGds extends mainPage {

        public function __construct() {

            parent::__construct();
            $this->icons_json =  json_decode($this->icons_json, true);
        }

        public $icons_json = '{
    "Flight": {
        "icon": "<i class=\"fal fa-plane-alt\"></i>",
        "name": "پرواز"
    },

    "Train": {
        "icon": "<i class=\"fal fa-train\"></i>",
        "name": "قطار"
    },
    "Bus": {
        "icon": "<i class=\"fal fa-bus\"></i>",
        "name": "اتوبوس"
    },
    "Hotel": {
        "icon": "<i class=\"fal fa-hotel\"></i>",
        "name": "هتل"
    },
    "Tour": {
        "icon": "<i class=\"fa-light fa-suitcase-rolling\"></i>",
        "name": "تور"
    },

    "Package": {
        "icon": "<i class=\"fal fa-plane-alt\"></i>",
        "name": "پرواز+هتل"
    },


    "Insurance": {
        "icon": "<i class=\"fal fa-umbrella-beach\"></i>",
        "name": "بیمه"
    },
    "Visa": {
        "icon": "<i class=\"fal fa-passport\"></i>",
        "name": "ویزا"
    }
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