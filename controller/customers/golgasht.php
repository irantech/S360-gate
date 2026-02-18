<?php
//todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************


class golgasht extends mainPage {

    public function __construct() {

        parent::__construct();
        $this->icons_json =  json_decode($this->icons_json, true);

    }

    public $icons_json = '{"Tour": {"name": "تور" , "icon": "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 448 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M352.1 128h-32.07l.0123-80c0-26.47-21.53-48-48-48h-96c-26.47 0-48 21.53-48 48L128 128H96.12c-35.35 0-64 28.65-64 64v224c0 35.35 28.58 64 63.93 64L96 496C96 504.8 103.2 512 112 512S128 504.8 128 496V480h192v16c0 8.836 7.164 16 16 16s16-7.164 16-16l.0492-16c35.35 0 64.07-28.65 64.07-64V192C416.1 156.7 387.5 128 352.1 128zM160 48C160 39.17 167.2 32 176 32h96C280.8 32 288 39.17 288 48V128H160V48zM384 416c0 17.64-14.36 32-32 32H96c-17.64 0-32-14.36-32-32V192c0-17.64 14.36-32 32-32h256c17.64 0 32 14.36 32 32V416zM304 336h-160C135.2 336 128 343.2 128 352c0 8.836 7.164 16 16 16h160c8.836 0 16-7.164 16-16C320 343.2 312.8 336 304 336zM304 240h-160C135.2 240 128 247.2 128 256c0 8.836 7.164 16 16 16h160C312.8 272 320 264.8 320 256C320 247.2 312.8 240 304 240z\"/></svg>"},
                                "Hotel": {"name": "هتل", "icon": "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M48 384C56.84 384 64 376.8 64 368c0-105.9 86.13-192 192-192s192 86.13 192 192c0 8.844 7.156 16 16 16s16-7.156 16-16c0-118.1-91.97-214.9-208-223.2V96h32C312.8 96 320 88.84 320 80S312.8 64 304 64h-96C199.2 64 192 71.16 192 80S199.2 96 208 96h32v48.81C123.1 153.1 32 249.9 32 368C32 376.8 39.16 384 48 384zM496 416h-480C7.156 416 0 423.2 0 432S7.156 448 16 448h480c8.844 0 16-7.156 16-16S504.8 416 496 416z\"/></svg>"}
                             

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