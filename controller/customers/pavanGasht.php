
        <?php
    //todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************
    //if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//        error_reporting(1);
//        error_reporting(E_ALL | E_STRICT);
//        @ini_set('display_errors', 1);
//        @ini_set('display_errors', 'on');
    //}

    class pavanGasht extends mainPage {

        public function __construct() {

            parent::__construct();
            $this->icons_json =  json_decode($this->icons_json, true);
        }

        public $icons_json = '{
        "Flight_internal": {"icon":"<svg viewbox=\"0 0 640 512\" xmlns=\"http://www.w3.org/2000/svg\"  width=\"16\" fill=\"currentColor\" class=\"bi bi-suitcase-fill\" height=\"16\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M176 153.1V112.1C176 74.04 207 0 256 0C304 0 336 74.04 336 112.1V154.1L422.4 208.1C411.5 213.1 401.1 219.3 391.6 226.3L304 171.1V112.1C304 81.04 278 33.02 256 33.02C233 33.02 208 81.04 208 113.1V172.1L32 282.1V347.2L208 292.1V392.2L144 440.2V480.2L256 448.2L358.1 477.4C366.4 487.9 375.9 497.4 386.4 505.7C378.5 511.4 368.8 513.2 360 511.2L256 480.2L152 510.2C142 513.3 132 511.2 124 505.2C116 499.2 112 490.2 112 480.2V440.2C112 430.2 116 421.2 124 415.2L176 376.2V335.2L41 378.2C31 381.2 20 379.2 12 373.2C4 367.2 0 357.2 0 347.2V282.1C0 271.1 6 259.1 16 254.1L176 153.1zM563.3 324.7C569.6 330.9 569.6 341.1 563.3 347.3L491.3 419.3C485.1 425.6 474.9 425.6 468.7 419.3L428.7 379.3C422.4 373.1 422.4 362.9 428.7 356.7C434.9 350.4 445.1 350.4 451.3 356.7L480 385.4L540.7 324.7C546.9 318.4 557.1 318.4 563.3 324.7H563.3zM352 368C352 288.5 416.5 224 496 224C575.5 224 640 288.5 640 368C640 447.5 575.5 512 496 512C416.5 512 352 447.5 352 368zM496 480C557.9 480 608 429.9 608 368C608 306.1 557.9 256 496 256C434.1 256 384 306.1 384 368C384 429.9 434.1 480 496 480z\"></path></svg>","name": "پرواز داخلی"},
         "Flight_external": {"icon":"<svg xmlns=\"http://www.w3.org/2000/svg\"  width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-suitcase-fill\" viewBox=\"0 0 640 512\"><!--! Font Awesome Pro 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2024 Fonticons, Inc. --><path d=\"M158.7 105.4c11.5-5.2 24.5-5.7 36.4-1.4L375 170c4.2 1.5 8.8 1.3 12.8-.8l88-45c15.8-8.1 33.3-12.3 51-12.3h61c12.7 0 21.1 13.1 15.8 24.6c-15.4 33.4-41.7 60.5-74.6 77L255.6 350.3c-2.2 1.1-4.7 1.7-7.2 1.7H109.3c-4.2 0-8.3-1.7-11.3-4.7L34.1 283.5l23.7-13.6c4.4-2.5 9.8-2.8 14.4-.7l57.2 25.4c4.4 2 9.5 1.8 13.8-.4l115-58.8c5.1-2.6 8.5-7.8 8.7-13.6s-2.6-11.2-7.5-14.3L121.9 122.2l-6.6-14.6 6.6 14.6 36.9-16.8zM206.1 74c-19.7-7.2-41.5-6.4-60.6 2.3L108.6 93.1c-23.3 10.6-25.4 42.8-3.6 56.3l113.5 70.5-83 42.4L85.3 240l-6.1 13.7L85.3 240c-14-6.2-30-5.4-43.3 2.2L18.2 255.7c-18.3 10.5-21.7 35.5-6.8 50.4l63.8 63.8c9 9 21.2 14.1 33.9 14.1H248.4c7.5 0 14.8-1.7 21.5-5.1L543.3 242.2c39.4-19.7 70.9-52.2 89.3-92.2c15.1-32.7-8.8-70-44.8-70h-61c-22.8 0-45.2 5.4-65.5 15.8l-81.8 41.8L206.1 74zM16 480c-8.8 0-16 7.2-16 16s7.2 16 16 16H624c8.8 0 16-7.2 16-16s-7.2-16-16-16H16z\"></path></svg>","name": "پرواز خارجی"},
         "Tour_internal": {"icon": "<svg xmlns=\\"http://www.w3.org/2000/svg\\" viewBox=\"0 0 448 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M352.1 128h-32.07l.0123-80c0-26.47-21.53-48-48-48h-96c-26.47 0-48 21.53-48 48L128 128H96.12c-35.35 0-64 28.65-64 64v224c0 35.35 28.58 64 63.93 64L96 496C96 504.8 103.2 512 112 512S128 504.8 128 496V480h192v16c0 8.836 7.164 16 16 16s16-7.164 16-16l.0492-16c35.35 0 64.07-28.65 64.07-64V192C416.1 156.7 387.5 128 352.1 128zM160 48C160 39.17 167.2 32 176 32h96C280.8 32 288 39.17 288 48V128H160V48zM384 416c0 17.64-14.36 32-32 32H96c-17.64 0-32-14.36-32-32V192c0-17.64 14.36-32 32-32h256c17.64 0 32 14.36 32 32V416zM304 336h-160C135.2 336 128 343.2 128 352c0 8.836 7.164 16 16 16h160c8.836 0 16-7.164 16-16C320 343.2 312.8 336 304 336zM304 240h-160C135.2 240 128 247.2 128 256c0 8.836 7.164 16 16 16h160C312.8 272 320 264.8 320 256C320 247.2 312.8 240 304 240z\"/></svg>","name": "تور داخلی"},
         "Tour_external": {"icon": "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 576 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M471.6 99.4c46.8 45.1 72.2 109 68.3 174.7l-86.3-31.4c15.2-43.2 21.6-89 18.9-134.8c-.2-2.9-.5-5.7-.9-8.5zM402.8 54.3c21.7 10.1 36.3 31.4 37.7 55.6c2.5 41.4-3.3 82.8-17 121.9l-167.6-61c14.6-38.8 36.9-74.2 65.3-104.3c17.5-18.5 44.1-25.2 68.2-17.3c1.1 .4 2.2 .8 3.3 1.2c3.4 1.2 6.7 2.5 10 3.9zm-3.1-35.4c-109.8-38-228.4 3.2-292.6 94c-11.1 15.7-2.8 36.8 15.3 43.4l92.4 33.6 0 0L245 200.9l167.6 61 30.1 10.9 0 0 89.1 32.4c18.1 6.6 38-4.2 39.6-23.4c9-108.1-52-213.2-155.6-256.9c-2.4-1.1-4.9-2.1-7.4-3l-5.9-2.1c-.9-.3-1.8-.6-2.7-.9zM305.9 37c-2.7 2.3-5.4 4.8-7.9 7.5c-31.5 33.3-56 72.5-72.2 115.4l-89.6-32.6C176.5 73 239.2 40.1 305.9 37zM16 480c-8.8 0-16 7.2-16 16s7.2 16 16 16H560c8.8 0 16-7.2 16-16s-7.2-16-16-16H253.4l77.8-213.7-30.1-10.9L219.4 480H16z\"></path></svg>", "name": "تور خارجی","name": "تور خارجی"},
         "Hotel": {"icon":"<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\" fill=\"currentColor\" class=\"bi bi-suitcase-fill\"  width=\"16\" height=\"16\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M16 0C7.2 0 0 7.2 0 16s7.2 16 16 16H32V480H16c-8.8 0-16 7.2-16 16s7.2 16 16 16H240h32H496c8.8 0 16-7.2 16-16s-7.2-16-16-16H480V32h16c8.8 0 16-7.2 16-16s-7.2-16-16-16H16zM272 432v48H240V432c0-8.8 7.2-16 16-16s16 7.2 16 16zm32 0c0-26.5-21.5-48-48-48s-48 21.5-48 48v48H64V32H448V480H304V432zM320 96v32c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32V96c0-17.7-14.3-32-32-32H352c-17.7 0-32 14.3-32 32zm64 0v32H352V96h32zM240 64c-17.7 0-32 14.3-32 32v32c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32V96c0-17.7-14.3-32-32-32H240zm0 32h32v32H240V96zM208 224v32c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H240c-17.7 0-32 14.3-32 32zm64 0v32H240V224h32zm80-32c-17.7 0-32 14.3-32 32v32c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H352zm0 32h32v32H352V224zM96 96v32c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32V96c0-17.7-14.3-32-32-32H128c-17.7 0-32 14.3-32 32zm64 0v32H128V96h32zm-32 96c-17.7 0-32 14.3-32 32v32c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H128zm0 32h32v32H128V224zm68.4 154.7C211 362.3 232.3 352 256 352s45 10.3 59.6 26.7c5.9 6.6 16 7.1 22.6 1.3s7.1-16 1.3-22.6C319 334.4 289.2 320 256 320s-63 14.4-83.5 37.3c-5.9 6.6-5.3 16.7 1.3 22.6s16.7 5.3 22.6-1.3z\"></path></svg>","name": "هتل"}
          
          }';



//  public $icons_json = '{
//
//"Tour_internal": {"icon": "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-suitcase-fill\" viewBox=\"0 0 16 16\"><path d=\"M6 .5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V3h1.5A1.5 1.5 0 0 1 13 4.5v9a1.5 1.5 0 0 1-1.004 1.416A1 1 0 1 1 10 15H6a1 1 0 1 1-1.997-.084A1.5 1.5 0 0 1 3 13.5v-9A1.5 1.5 0 0 1 4.5 3H6zM9 1H7v2h2zM6 5.5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0zm2.5 0a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0zm2.5 0a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0z\"/></svg>", "name": "تور داخلی"},
//"Tour_external": {"icon": "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-suitcase-fill\" viewBox=\"0 0 16 16\"><path d=\"M6 .5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V3h1.5A1.5 1.5 0 0 1 13 4.5v9a1.5 1.5 0 0 1-1.004 1.416A1 1 0 1 1 10 15H6a1 1 0 1 1-1.997-.084A1.5 1.5 0 0 1 3 13.5v-9A1.5 1.5 0 0 1 4.5 3H6zM9 1H7v2h2zM6 5.5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0zm2.5 0a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0zm2.5 0a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0z\"/></svg>", "name": "تور خارجی"},
//               }';



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