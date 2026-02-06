
        <?php
    //todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************
    //if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
    //    error_reporting(1);
    //    error_reporting(E_ALL | E_STRICT);
    //    @ini_set('display_errors', 1);
    //    @ini_set('display_errors', 'on');
    //}

    class bilitiom extends mainPage {

        public function __construct() {

            parent::__construct();
            $this->icons_json =  json_decode($this->icons_json, true);
        }

//        public $icons_json = '{
//        "Flight_internal": {"name": "پرواز داخلی","icon": "<i class=\"fa-light fa-bell-concierge\"></i>"},
//         "Flight_external": {"name": "پرواز خارجی"},
//         "Tour_internal": {"name": "تور داخلی"},
//         "Tour_external": {"name": "تور خارجی"},
//         "Hotel": {"name": "هتل"},
//         "Visa": {"name": "ویزا"},
//          "Insurance": {"name": "بیمه"}
//          }';

  public $icons_json = '{
"Flight_internal": {"icon": "<svg height=\"1em\" viewBox=\"0 0 32 32\" width=\"1em\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M25.6 28.8c.4-.4.533-1.067.533-1.6l-3.467-14.4 6.4-6.4c.933-.933.933-2.533 0-3.467s-2.533-.933-3.467 0l-6.4 6.4L4.799 6c-.533-.133-1.2 0-1.6.533-.8.8-.533 2.133.4 2.667l10.267 5.333-6.4 6.4-3.733-.533c-.267 0-.533 0-.667.267l-.667.667c-.4.4-.267 1.067.133 1.333l4.267 2.4 2.4 4.267c.267.533.933.533 1.333.133l.667-.667c.133-.133.267-.4.267-.667l-.533-3.733 6.4-6.4 5.333 10.267c.667 1.067 2 1.333 2.933.533z\"></path></svg>", "name": "پرواز داخلی"},
"Flight_external": {"icon": "<svg height=\"\" viewBox=\"0 0 32 32\" width=\"1em\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"m22.667 14.667-.347.008c-4.251.181-7.653 3.697-7.653 7.992 0 4.411 3.589 8 8 8l.347-.008c4.251-.181 7.653-3.697 7.653-7.992 0-4.411-3.589-8-8-8zm0 14.4A6.379 6.379 0 0 1 18 27.04v-.707l.016-.177c.041-.223.159-.391.289-.58l.085-.125c.143-.213.276-.459.276-.784 0-.52-.384-.657-.693-.709l-.32-.04c-.171-.023-.323-.056-.419-.152-.091-.091-.181-.255-.277-.429l-.099-.176a2.562 2.562 0 0 0-.589-.731c.128-3.419 2.949-6.163 6.397-6.163.113 0 .227.003.339.008a.33.33 0 0 0 .107.307c.048.043.08.077.103.103l.045.057c-.008.016-.069.12-.409.293l-.191.105c-.511.309-1.035.832-1.12 1.372a.812.812 0 0 0 .225.721.331.331 0 0 0 .236.097c.463 0 .82-.171 1.167-.336l.212-.1c.281-.125.572-.228.953-.228 1.308 0 2.333.293 2.333.667 0 .137-.043.179-.059.195-.123.121-.467.145-.839.147l-.945-.012a1.396 1.396 0 0 1-.437-.077l-.316-.139c-.161-.061-.375-.113-.737-.113-.549 0-1.571.099-2.236.764-.544.544-.487 1.195-.448 1.624l.012.144.005.135c0 .656.671 1 1.333 1 1.019 0 1.9.191 2 .333 0 .373.111.628.2.832l.052.123a.957.957 0 0 1 .081.379c0 .151-.025.183-.092.269l-.063.085c-.099.145-.179.324-.179.645 0 .573.452 1.193.659 1.447l.093.109a.335.335 0 0 0 .331.1c.196-.051 1.917-.524 1.917-1.656 0-.355.111-.451.277-.596l.073-.065c.151-.137.316-.329.316-.673 0-.267.475-.957.913-1.443a.33.33 0 0 0 .085-.253.34.34 0 0 0-.128-.235c-.259-.201-.975-.855-1.215-1.489.136.071.305.187.441.321.111.112.26.165.429.159.205-.012.44-.137.673-.315a6.409 6.409 0 0 1-6.2 7.989zm-8.184-10.868-1.885-3.605-4.691 4.692.384 2.687a.578.578 0 0 1-.171.512l-.504.503a.607.607 0 0 1-.955-.136l-1.74-3.139-3.139-1.74a.608.608 0 0 1-.136-.956l.504-.503a.58.58 0 0 1 .512-.171l2.687.384 4.692-4.692-7.44-3.889a1.266 1.266 0 0 1 .87-2.354l10.407 2.405 4.692-4.692c.708-.708 1.851-.708 2.559 0s.708 1.851 0 2.559l-4.692 4.692.979 4.235a10.396 10.396 0 0 0-2.933 3.209z\"></path></svg>", "name": "پرواز خارجی"},
"Tour_internal": {"icon": "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-suitcase-fill\" viewBox=\"0 0 16 16\"><path d=\"M6 .5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V3h1.5A1.5 1.5 0 0 1 13 4.5v9a1.5 1.5 0 0 1-1.004 1.416A1 1 0 1 1 10 15H6a1 1 0 1 1-1.997-.084A1.5 1.5 0 0 1 3 13.5v-9A1.5 1.5 0 0 1 4.5 3H6zM9 1H7v2h2zM6 5.5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0zm2.5 0a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0zm2.5 0a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0z\"/></svg>", "name": "تور داخلی"},
"Tour_external": {"icon": "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-suitcase-fill\" viewBox=\"0 0 16 16\"><path d=\"M6 .5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V3h1.5A1.5 1.5 0 0 1 13 4.5v9a1.5 1.5 0 0 1-1.004 1.416A1 1 0 1 1 10 15H6a1 1 0 1 1-1.997-.084A1.5 1.5 0 0 1 3 13.5v-9A1.5 1.5 0 0 1 4.5 3H6zM9 1H7v2h2zM6 5.5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0zm2.5 0a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0zm2.5 0a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0z\"/></svg>", "name": "تور خارجی"},
"Insurance": {"icon": "<svg height=\"\" viewBox=\"0 0 24 24\" width=\"1em\" xml:space=\"preserve\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M0 0h24v24H0z\" style=\"fill:none\"></path><path d=\"M19.611 9.42V4.201c0-.3-.243-.544-.544-.544h-2.175c-.3 0-.544.243-.544.544v2.283l-3.622-3.26a1.088 1.088 0 0 0-1.455 0L2.18 11.408a.544.544 0 0 0 .364.948h1.845v8.155c0 .3.243.544.544.544h4.349c.3 0 .544-.243.544-.544v-4.893c0-.601.487-1.087 1.087-1.087h2.175c.601 0 1.087.487 1.087 1.087v4.893c0 .3.243.544.544.544h4.349c.3 0 .544-.243.544-.544v-8.155h1.845a.544.544 0 0 0 .364-.948l-2.21-1.988zm-9.786.761c0-1.196.979-2.175 2.175-2.175s2.175.979 2.175 2.175h-4.35z\"></path></svg>", "name": "بیمه"},
"Visa": {"icon": "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 448 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M0 64C0 28.7 28.7 0 64 0H384c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zM183 278.8c-27.9-13.2-48.4-39.4-53.7-70.8h39.1c1.6 30.4 7.7 53.8 14.6 70.8zm41.3 9.2l-.3 0-.3 0c-2.4-3.5-5.7-8.9-9.1-16.5c-6-13.6-12.4-34.3-14.2-63.5h47.1c-1.8 29.2-8.1 49.9-14.2 63.5c-3.4 7.6-6.7 13-9.1 16.5zm40.7-9.2c6.8-17.1 12.9-40.4 14.6-70.8h39.1c-5.3 31.4-25.8 57.6-53.7 70.8zM279.6 176c-1.6-30.4-7.7-53.8-14.6-70.8c27.9 13.2 48.4 39.4 53.7 70.8H279.6zM223.7 96l.3 0 .3 0c2.4 3.5 5.7 8.9 9.1 16.5c6 13.6 12.4 34.3 14.2 63.5H200.5c1.8-29.2 8.1-49.9 14.2-63.5c3.4-7.6 6.7-13 9.1-16.5zM183 105.2c-6.8 17.1-12.9 40.4-14.6 70.8H129.3c5.3-31.4 25.8-57.6 53.7-70.8zM352 192A128 128 0 1 0 96 192a128 128 0 1 0 256 0zM112 384c-8.8 0-16 7.2-16 16s7.2 16 16 16H336c8.8 0 16-7.2 16-16s-7.2-16-16-16H112z\"/></svg>", "name": "ویزا"},
"Hotel": {"icon": "<svg height=\"\" viewBox=\"0 0 32 32\" width=\"1em\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M14.667 2.667a2.666 2.666 0 0 1 2.667 2.667v4h8a2.666 2.666 0 0 1 2.667 2.667v13.333l.156.009c.663.076 1.177.64 1.177 1.324V28H2.667v-1.333c0-.736.597-1.333 1.333-1.333v-20a2.666 2.666 0 0 1 2.667-2.667h8zm-1.334 16c-.736 0-1.333.597-1.333 1.333v5.333h2.667V20c0-.736-.597-1.333-1.333-1.333zm5.334 0c-.736 0-1.333.597-1.333 1.333v5.333h2.667V20c0-.736-.597-1.333-1.333-1.333zM8 18.667c-.736 0-1.333.597-1.333 1.333v1.333a1.333 1.333 0 0 0 2.666 0V20c0-.736-.597-1.333-1.333-1.333zm16 0c-.736 0-1.333.597-1.333 1.333v1.333a1.333 1.333 0 0 0 2.666 0V20c0-.736-.597-1.333-1.333-1.333zM8 12c-.736 0-1.333.597-1.333 1.333v1.333a1.333 1.333 0 0 0 2.666 0v-1.333C9.333 12.597 8.736 12 8 12zm5.333 0c-.736 0-1.333.597-1.333 1.333v1.333a1.333 1.333 0 0 0 2.666 0v-1.333c0-.736-.597-1.333-1.333-1.333zm5.334 0c-.736 0-1.333.597-1.333 1.333v1.333a1.333 1.333 0 0 0 2.666 0v-1.333c0-.736-.597-1.333-1.333-1.333zM24 12c-.736 0-1.333.597-1.333 1.333v1.333a1.333 1.333 0 0 0 2.666 0v-1.333c0-.736-.597-1.333-1.333-1.333zM8 5.333c-.736 0-1.333.597-1.333 1.333v1.333a1.333 1.333 0 0 0 2.666 0V6.666c0-.736-.597-1.333-1.333-1.333zm5.333 0c-.736 0-1.333.597-1.333 1.333v1.333a1.333 1.333 0 0 0 2.666 0V6.666c0-.736-.597-1.333-1.333-1.333z\"></path></svg>", "name": "هتل"}
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