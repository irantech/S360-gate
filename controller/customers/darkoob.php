
        <?php
    //todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************
    //if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//        error_reporting(1);
//        error_reporting(E_ALL | E_STRICT);
//        @ini_set('display_errors', 1);
//        @ini_set('display_errors', 'on');
    //}

    class darkoob extends mainPage {

        public function __construct() {

            parent::__construct();
            $this->icons_json =  json_decode($this->icons_json, true);
        }

        public $icons_json = '{"Hotel": {"icon": "<i><svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 640 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><defs><style>.fa-secondary{opacity:.4}</style></defs><path class=\"fa-primary\" d=\"M32 32C49.67 32 64 46.33 64 64V320H640V448C640 465.7 625.7 480 608 480C590.3 480 576 465.7 576 448V416H64V448C64 465.7 49.67 480 32 480C14.33 480 0 465.7 0 448V64C0 46.33 14.33 32 32 32z\"/><path class=\"fa-secondary\" d=\"M96 208C96 163.8 131.8 128 176 128C220.2 128 256 163.8 256 208C256 252.2 220.2 288 176 288C131.8 288 96 252.2 96 208zM288 160C288 142.3 302.3 128 320 128H544C597 128 640 170.1 640 224V320H288V160z\"/></svg></i>", "name": "هتل"},
          "Tour": {"icon": "<i><svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 448 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><defs><style>.fa-secondary{opacity:.4}</style></defs><path class=\"fa-primary\" d=\"M368 128h-288C53.5 128 32 149.5 32 176v256C32 458.5 53.5 480 80 480h288c26.5 0 48-21.5 48-48v-256C416 149.5 394.5 128 368 128zM336 384h-224C103.2 384 96 376.8 96 368C96 359.2 103.2 352 112 352h224c8.801 0 16 7.199 16 16C352 376.8 344.8 384 336 384zM336 256h-224C103.2 256 96 248.8 96 240C96 231.2 103.2 224 112 224h224C344.8 224 352 231.2 352 240C352 248.8 344.8 256 336 256z\"/><path class=\"fa-secondary\" d=\"M176.1 48h96V128h47.97l.0123-80c0-26.5-21.5-48-48-48h-96c-26.5 0-48 21.5-48 48L128 128h48.03V48zM96 496C96 504.9 103.1 512 112 512h32C152.9 512 160 504.9 160 496L160.1 480H96.05L96 496zM288 496c0 8.875 7.125 16 16 16h32c8.875 0 16-7.125 16-16l.0492-16h-63.99L288 496zM336 352h-224C103.2 352 96 359.2 96 368C96 376.8 103.2 384 112 384h224c8.801 0 16-7.201 16-16C352 359.2 344.8 352 336 352zM112 256h224C344.8 256 352 248.8 352 240C352 231.2 344.8 224 336 224h-224C103.2 224 96 231.2 96 240C96 248.8 103.2 256 112 256z\"/></svg></i>", "name": "تور"}}';




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