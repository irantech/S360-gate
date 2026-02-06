
        <?php
    //todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************
    //if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//        error_reporting(1);
//        error_reporting(E_ALL | E_STRICT);
//        @ini_set('display_errors', 1);
//        @ini_set('display_errors', 'on');
    //}

    class doostMohammadi extends mainPage {

        public function __construct() {

            parent::__construct();
            $this->icons_json =  json_decode($this->icons_json, true);
        }

        public $icons_json = '{"Hotel": {"icon": "<i><svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 640 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><defs><style>.fa-secondary{opacity:.4}</style></defs><path class=\"fa-primary\" d=\"M32 32C49.67 32 64 46.33 64 64V320H640V448C640 465.7 625.7 480 608 480C590.3 480 576 465.7 576 448V416H64V448C64 465.7 49.67 480 32 480C14.33 480 0 465.7 0 448V64C0 46.33 14.33 32 32 32z\"/><path class=\"fa-secondary\" d=\"M96 208C96 163.8 131.8 128 176 128C220.2 128 256 163.8 256 208C256 252.2 220.2 288 176 288C131.8 288 96 252.2 96 208zM288 160C288 142.3 302.3 128 320 128H544C597 128 640 170.1 640 224V320H288V160z\"/></svg></i>", "name": "هتل داخلی"}}';


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