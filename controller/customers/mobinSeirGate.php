
<?php
//todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************
//if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}

class mobinSeirGate extends mainPage {

    public function __construct() {

        parent::__construct();
        $this->icons_json =  json_decode($this->icons_json, true);
    }

    public $icons_json = '{"Flight": {"name": "پرواز" , "icon": "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 640 512\"><path d=\"M176 153.1V112.1C176 74.04 207 0 256 0C304 0 336 74.04 336 112.1V154.1L422.4 208.1C411.5 213.1 401.1 219.3 391.6 226.3L304 171.1V112.1C304 81.04 278 33.02 256 33.02C233 33.02 208 81.04 208 113.1V172.1L32 282.1V347.2L208 292.1V392.2L144 440.2V480.2L256 448.2L358.1 477.4C366.4 487.9 375.9 497.4 386.4 505.7C378.5 511.4 368.8 513.2 360 511.2L256 480.2L152 510.2C142 513.3 132 511.2 124 505.2C116 499.2 112 490.2 112 480.2V440.2C112 430.2 116 421.2 124 415.2L176 376.2V335.2L41 378.2C31 381.2 20 379.2 12 373.2C4 367.2 0 357.2 0 347.2V282.1C0 271.1 6 259.1 16 254.1L176 153.1zM563.3 324.7C569.6 330.9 569.6 341.1 563.3 347.3L491.3 419.3C485.1 425.6 474.9 425.6 468.7 419.3L428.7 379.3C422.4 373.1 422.4 362.9 428.7 356.7C434.9 350.4 445.1 350.4 451.3 356.7L480 385.4L540.7 324.7C546.9 318.4 557.1 318.4 563.3 324.7H563.3zM352 368C352 288.5 416.5 224 496 224C575.5 224 640 288.5 640 368C640 447.5 575.5 512 496 512C416.5 512 352 447.5 352 368zM496 480C557.9 480 608 429.9 608 368C608 306.1 557.9 256 496 256C434.1 256 384 306.1 384 368C384 429.9 434.1 480 496 480z\"/></svg>"},
                                "Hotel": {"name": "هتل", "icon": "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><path d=\"M48 384C56.84 384 64 376.8 64 368c0-105.9 86.13-192 192-192s192 86.13 192 192c0 8.844 7.156 16 16 16s16-7.156 16-16c0-118.1-91.97-214.9-208-223.2V96h32C312.8 96 320 88.84 320 80S312.8 64 304 64h-96C199.2 64 192 71.16 192 80S199.2 96 208 96h32v48.81C123.1 153.1 32 249.9 32 368C32 376.8 39.16 384 48 384zM496 416h-480C7.156 416 0 423.2 0 432S7.156 448 16 448h480c8.844 0 16-7.156 16-16S504.8 416 496 416z\"/></svg>"},
                                "Train": {"name": "قطار", "icon": "<svg xmlns=\"http://www.w3.org/2000/svg\" viewbox=\"0 0 448 512\" ><path d=\"M192 336C192 318.3 206.3 304 224 304C241.7 304 256 318.3 256 336C256 353.7 241.7 368 224 368C206.3 368 192 353.7 192 336zM352 0C405 0 448 42.98 448 96V352C448 398 415.6 436.4 372.4 445.8L411.3 484.7C417.6 490.9 417.6 501.1 411.3 507.3C405.1 513.6 394.9 513.6 388.7 507.3L329.4 448H118.6L59.31 507.3C53.07 513.6 42.94 513.6 36.69 507.3C30.44 501.1 30.44 490.9 36.69 484.7L75.55 445.8C32.36 436.4 0 398 0 352V96C0 42.98 42.98 0 96 0H352zM352 32H96C60.65 32 32 60.65 32 96V224H416V96C416 60.65 387.3 32 352 32zM96 416H352C387.3 416 416 387.3 416 352V256H32V352C32 387.3 60.65 416 96 416z\"></path></svg>"}, 
                                "Bus": {"name": "اتوبوس", "icon": "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 576 512\"><path d=\"M336 64C344.8 64 352 71.16 352 80C352 88.84 344.8 96 336 96H240C231.2 96 224 88.84 224 80C224 71.16 231.2 64 240 64H336zM184 352C184 365.3 173.3 376 160 376C146.7 376 136 365.3 136 352C136 338.7 146.7 328 160 328C173.3 328 184 338.7 184 352zM392 352C392 338.7 402.7 328 416 328C429.3 328 440 338.7 440 352C440 365.3 429.3 376 416 376C402.7 376 392 365.3 392 352zM72.3 69.88C96.5 40.06 164.2 0 288 0C420.6 0 481.2 39.95 504.2 70.2C510.2 78.14 512 87.36 512 95.15V384C512 407.7 499.1 428.4 480 439.4V496C480 504.8 472.8 512 464 512C455.2 512 448 504.8 448 496V448H128V496C128 504.8 120.8 512 112 512C103.2 512 96 504.8 96 496V439.4C76.87 428.4 64 407.7 64 384V95.15C64 87.42 65.79 77.91 72.3 69.88V69.88zM288 32C170.1 32 113.2 70.22 97.15 90.05C96.77 90.51 96 91.94 96 95.15V128H480V95.15C480 92 479.2 90.3 478.7 89.53C463.9 70.12 414.8 32 288 32zM272 256V160H96V256H272zM304 256H480V160H304V256zM128 416H448C465.7 416 480 401.7 480 384V288H96V384C96 401.7 110.3 416 128 416zM32 240C32 248.8 24.84 256 16 256C7.164 256 0 248.8 0 240V144C0 135.2 7.164 128 16 128C24.84 128 32 135.2 32 144V240zM576 240C576 248.8 568.8 256 560 256C551.2 256 544 248.8 544 240V144C544 135.2 551.2 128 560 128C568.8 128 576 135.2 576 144V240z\"/></svg>"},
                                "Insurance": {"name": "بیمه", "icon": "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 576 512\"><path d=\"M471.6 99.4c46.8 45.1 72.2 109 68.3 174.7l-86.3-31.4c15.2-43.2 21.6-89 18.9-134.8c-.2-2.9-.5-5.7-.9-8.5zM402.8 54.3c21.7 10.1 36.3 31.4 37.7 55.6c2.5 41.4-3.3 82.8-17 121.9l-167.6-61c14.6-38.8 36.9-74.2 65.3-104.3c17.5-18.5 44.1-25.2 68.2-17.3c1.1 .4 2.2 .8 3.3 1.2c3.4 1.2 6.7 2.5 10 3.9zm-3.1-35.4c-109.8-38-228.4 3.2-292.6 94c-11.1 15.7-2.8 36.8 15.3 43.4l92.4 33.6 0 0L245 200.9l167.6 61 30.1 10.9 0 0 89.1 32.4c18.1 6.6 38-4.2 39.6-23.4c9-108.1-52-213.2-155.6-256.9c-2.4-1.1-4.9-2.1-7.4-3l-5.9-2.1c-.9-.3-1.8-.6-2.7-.9zM305.9 37c-2.7 2.3-5.4 4.8-7.9 7.5c-31.5 33.3-56 72.5-72.2 115.4l-89.6-32.6C176.5 73 239.2 40.1 305.9 37zM16 480c-8.8 0-16 7.2-16 16s7.2 16 16 16H560c8.8 0 16-7.2 16-16s-7.2-16-16-16H253.4l77.8-213.7-30.1-10.9L219.4 480H16z\"/></svg>"}

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