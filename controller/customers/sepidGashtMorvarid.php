
        <?php
    //todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************
    //if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
    //    error_reporting(1);
    //    error_reporting(E_ALL | E_STRICT);
    //    @ini_set('display_errors', 1);
    //    @ini_set('display_errors', 'on');
    //}

    class sepidGashtMorvarid extends mainPage {

        public function __construct() {

            parent::__construct();
            $this->icons_json =  json_decode($this->icons_json, true);
            $this->icons_json['Package'] = [
                "icon" => '<i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.5.0 by @fontawesome - https://fontawesome.com/ License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M115.7 128c.7-.7 1.4-1.5 2.2-2.2c20.7-20.7 42.4-35.1 64.1-44.5c8.1-3.5 17.5 .2 21 8.3s-.2 17.5-8.3 21c-17.7 7.7-36.1 19.7-54.1 37.8c-3.6 3.6-6.9 7.1-10 10.7l-1.3 1.5c-51.1 60.1-42 123.1-21.3 156.1L244 180.7c3.2-3.2 7.5-4.9 12-4.7l0 0H432V144c0-8.8 7.2-16 16-16s16 7.2 16 16v32h78.1C532.8 135.5 490 80 400 80c-31.6 0-57.2 6.8-77.4 17.2c-7.2 3.7-16 1.4-20.6-5.3C281.2 60.9 241 32 176 32C86 32 43.2 87.5 33.9 128h81.7zM544 208H448 341.1c8 23.6 15.1 49.1 21 75.4c14.3 64.4 21.4 135.3 15.4 200.1C375.9 500 361.9 512 345.9 512H245.8c-21.7 0-36.7-21-30.8-41.3c27.4-94.3 34-166.1 30.8-216.1c-.6-10-1.7-19.1-3-27.4L129.1 340.8c-11.8 11.8-34.2 13.9-46-3.3C56.3 297.9 44.6 227.5 89.6 160H32c-16.7 0-34-14.3-30.1-34.9C12.3 70.1 67.6 0 176 0c68.6 0 116.2 28.1 144.4 63c22.6-9.4 49.1-15 79.6-15c108.4 0 163.7 70.1 174.1 125.1C578 193.7 560.7 208 544 208zm-272.3 0c2.8 13 4.9 27.8 5.9 44.5c3.5 54.5-3.8 130-32 227.1c0 .1 0 .1 0 .1l0 .1c0 0 0 .1 .1 .2l0 0h99.9c5.5-60.6-1.1-127.9-14.8-189.7c-6.5-29.4-14.6-57.2-23.7-82.3H271.7z"/></svg></i>'
                ,"name" => "پرواز + هتل"
            ];
        }

        public $icons_json = '{"Flight": {"icon": "<i>\n<svg viewbox=\"0 0 640 512\" xmlns=\"http://www.w3.org/2000/svg\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M176 153.1V112.1C176 74.04 207 0 256 0C304 0 336 74.04 336 112.1V154.1L422.4 208.1C411.5 213.1 401.1 219.3 391.6 226.3L304 171.1V112.1C304 81.04 278 33.02 256 33.02C233 33.02 208 81.04 208 113.1V172.1L32 282.1V347.2L208 292.1V392.2L144 440.2V480.2L256 448.2L358.1 477.4C366.4 487.9 375.9 497.4 386.4 505.7C378.5 511.4 368.8 513.2 360 511.2L256 480.2L152 510.2C142 513.3 132 511.2 124 505.2C116 499.2 112 490.2 112 480.2V440.2C112 430.2 116 421.2 124 415.2L176 376.2V335.2L41 378.2C31 381.2 20 379.2 12 373.2C4 367.2 0 357.2 0 347.2V282.1C0 271.1 6 259.1 16 254.1L176 153.1zM563.3 324.7C569.6 330.9 569.6 341.1 563.3 347.3L491.3 419.3C485.1 425.6 474.9 425.6 468.7 419.3L428.7 379.3C422.4 373.1 422.4 362.9 428.7 356.7C434.9 350.4 445.1 350.4 451.3 356.7L480 385.4L540.7 324.7C546.9 318.4 557.1 318.4 563.3 324.7H563.3zM352 368C352 288.5 416.5 224 496 224C575.5 224 640 288.5 640 368C640 447.5 575.5 512 496 512C416.5 512 352 447.5 352 368zM496 480C557.9 480 608 429.9 608 368C608 306.1 557.9 256 496 256C434.1 256 384 306.1 384 368C384 429.9 434.1 480 496 480z\"></path></svg>\n</i>",
                             "name": "هواپیما"},
                              "Hotel": {"icon": "<i>\n<svg viewbox=\"0 0 512 512\" xmlns=\"http://www.w3.org/2000/svg\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M16 0C7.2 0 0 7.2 0 16s7.2 16 16 16H32V480H16c-8.8 0-16 7.2-16 16s7.2 16 16 16H240h32H496c8.8 0 16-7.2 16-16s-7.2-16-16-16H480V32h16c8.8 0 16-7.2 16-16s-7.2-16-16-16H16zM272 432v48H240V432c0-8.8 7.2-16 16-16s16 7.2 16 16zm32 0c0-26.5-21.5-48-48-48s-48 21.5-48 48v48H64V32H448V480H304V432zM320 96v32c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32V96c0-17.7-14.3-32-32-32H352c-17.7 0-32 14.3-32 32zm64 0v32H352V96h32zM240 64c-17.7 0-32 14.3-32 32v32c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32V96c0-17.7-14.3-32-32-32H240zm0 32h32v32H240V96zM208 224v32c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H240c-17.7 0-32 14.3-32 32zm64 0v32H240V224h32zm80-32c-17.7 0-32 14.3-32 32v32c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H352zm0 32h32v32H352V224zM96 96v32c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32V96c0-17.7-14.3-32-32-32H128c-17.7 0-32 14.3-32 32zm64 0v32H128V96h32zm-32 96c-17.7 0-32 14.3-32 32v32c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H128zm0 32h32v32H128V224zm68.4 154.7C211 362.3 232.3 352 256 352s45 10.3 59.6 26.7c5.9 6.6 16 7.1 22.6 1.3s7.1-16 1.3-22.6C319 334.4 289.2 320 256 320s-63 14.4-83.5 37.3c-5.9 6.6-5.3 16.7 1.3 22.6s16.7 5.3 22.6-1.3z\"></path></svg>\n</i>", "name": "هتل"},
                               "Bus": {"icon": "<i>\n<svg viewbox=\"0 0 576 512\" xmlns=\"http://www.w3.org/2000/svg\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M336 64C344.8 64 352 71.16 352 80C352 88.84 344.8 96 336 96H240C231.2 96 224 88.84 224 80C224 71.16 231.2 64 240 64H336zM184 352C184 365.3 173.3 376 160 376C146.7 376 136 365.3 136 352C136 338.7 146.7 328 160 328C173.3 328 184 338.7 184 352zM392 352C392 338.7 402.7 328 416 328C429.3 328 440 338.7 440 352C440 365.3 429.3 376 416 376C402.7 376 392 365.3 392 352zM72.3 69.88C96.5 40.06 164.2 0 288 0C420.6 0 481.2 39.95 504.2 70.2C510.2 78.14 512 87.36 512 95.15V384C512 407.7 499.1 428.4 480 439.4V496C480 504.8 472.8 512 464 512C455.2 512 448 504.8 448 496V448H128V496C128 504.8 120.8 512 112 512C103.2 512 96 504.8 96 496V439.4C76.87 428.4 64 407.7 64 384V95.15C64 87.42 65.79 77.91 72.3 69.88V69.88zM288 32C170.1 32 113.2 70.22 97.15 90.05C96.77 90.51 96 91.94 96 95.15V128H480V95.15C480 92 479.2 90.3 478.7 89.53C463.9 70.12 414.8 32 288 32zM272 256V160H96V256H272zM304 256H480V160H304V256zM128 416H448C465.7 416 480 401.7 480 384V288H96V384C96 401.7 110.3 416 128 416zM32 240C32 248.8 24.84 256 16 256C7.164 256 0 248.8 0 240V144C0 135.2 7.164 128 16 128C24.84 128 32 135.2 32 144V240zM576 240C576 248.8 568.8 256 560 256C551.2 256 544 248.8 544 240V144C544 135.2 551.2 128 560 128C568.8 128 576 135.2 576 144V240z\"></path></svg>\n</i>", "name": "اتوبوس"},
                                "Insurance": {"icon": "<i>\n<svg viewbox=\"0 0 576 512\" xmlns=\"http://www.w3.org/2000/svg\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M471.6 99.4c46.8 45.1 72.2 109 68.3 174.7l-86.3-31.4c15.2-43.2 21.6-89 18.9-134.8c-.2-2.9-.5-5.7-.9-8.5zM402.8 54.3c21.7 10.1 36.3 31.4 37.7 55.6c2.5 41.4-3.3 82.8-17 121.9l-167.6-61c14.6-38.8 36.9-74.2 65.3-104.3c17.5-18.5 44.1-25.2 68.2-17.3c1.1 .4 2.2 .8 3.3 1.2c3.4 1.2 6.7 2.5 10 3.9zm-3.1-35.4c-109.8-38-228.4 3.2-292.6 94c-11.1 15.7-2.8 36.8 15.3 43.4l92.4 33.6 0 0L245 200.9l167.6 61 30.1 10.9 0 0 89.1 32.4c18.1 6.6 38-4.2 39.6-23.4c9-108.1-52-213.2-155.6-256.9c-2.4-1.1-4.9-2.1-7.4-3l-5.9-2.1c-.9-.3-1.8-.6-2.7-.9zM305.9 37c-2.7 2.3-5.4 4.8-7.9 7.5c-31.5 33.3-56 72.5-72.2 115.4l-89.6-32.6C176.5 73 239.2 40.1 305.9 37zM16 480c-8.8 0-16 7.2-16 16s7.2 16 16 16H560c8.8 0 16-7.2 16-16s-7.2-16-16-16H253.4l77.8-213.7-30.1-10.9L219.4 480H16z\"></path></svg>\n</i>", "name": "بیمه"}, "Tour": {"icon": "<i>\n<svg viewbox=\"0 0 448 512\" xmlns=\"http://www.w3.org/2000/svg\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M352.1 128h-32.07l.0123-80c0-26.47-21.53-48-48-48h-96c-26.47 0-48 21.53-48 48L128 128H96.12c-35.35 0-64 28.65-64 64v224c0 35.35 28.58 64 63.93 64L96 496C96 504.8 103.2 512 112 512S128 504.8 128 496V480h192v16c0 8.836 7.164 16 16 16s16-7.164 16-16l.0492-16c35.35 0 64.07-28.65 64.07-64V192C416.1 156.7 387.5 128 352.1 128zM160 48C160 39.17 167.2 32 176 32h96C280.8 32 288 39.17 288 48V128H160V48zM384 416c0 17.64-14.36 32-32 32H96c-17.64 0-32-14.36-32-32V192c0-17.64 14.36-32 32-32h256c17.64 0 32 14.36 32 32V416zM304 336h-160C135.2 336 128 343.2 128 352c0 8.836 7.164 16 16 16h160c8.836 0 16-7.164 16-16C320 343.2 312.8 336 304 336zM304 240h-160C135.2 240 128 247.2 128 256c0 8.836 7.164 16 16 16h160C312.8 272 320 264.8 320 256C320 247.2 312.8 240 304 240z\"></path></svg>\n</i>", "name": "تور"}, "Entertainment": {"icon": "<i>\n<svg viewbox=\"0 0 640 512\" xmlns=\"http://www.w3.org/2000/svg\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M336 32c-8.8 0-16 7.2-16 16V496c0 8.8-7.2 16-16 16s-16-7.2-16-16V48c0-26.5 21.5-48 48-48H464c26.5 0 48 21.5 48 48V192h32V112c0-8.8 7.2-16 16-16s16 7.2 16 16v80h16c26.5 0 48 21.5 48 48V496c0 8.8-7.2 16-16 16s-16-7.2-16-16V240c0-8.8-7.2-16-16-16H560 496c-8.8 0-16-7.2-16-16V48c0-8.8-7.2-16-16-16H336zm48 32h32c17.7 0 32 14.3 32 32v32c0 17.7-14.3 32-32 32H384c-17.7 0-32-14.3-32-32V96c0-17.7 14.3-32 32-32zm0 32v32h32V96H384zm96 192c0-17.7 14.3-32 32-32h32c17.7 0 32 14.3 32 32v32c0 17.7-14.3 32-32 32H512c-17.7 0-32-14.3-32-32V288zm64 0H512v32h32V288zm-32 96h32c17.7 0 32 14.3 32 32v32c0 17.7-14.3 32-32 32H512c-17.7 0-32-14.3-32-32V416c0-17.7 14.3-32 32-32zm0 32v32h32V416H512zM352 224c0-17.7 14.3-32 32-32h32c17.7 0 32 14.3 32 32v32c0 17.7-14.3 32-32 32H384c-17.7 0-32-14.3-32-32V224zm64 0H384v32h32V224zm-32 96h32c17.7 0 32 14.3 32 32v32c0 17.7-14.3 32-32 32H384c-17.7 0-32-14.3-32-32V352c0-17.7 14.3-32 32-32zm0 32v32h32V352H384zM128 224c8.8 0 16 7.2 16 16v48h32c26.5 0 48-21.5 48-48c0-16-7.8-30.2-19.9-38.9l-8-5.8c-4.9-3.5-7.4-9.5-6.4-15.5l.4-2.6c1.1-6.7 1.9-11.9 1.9-17.2c0-35.3-28.7-64-64-64s-64 28.7-64 64c0 5.3 .8 10.5 1.9 17.2l.4 2.6c.9 6-1.5 11.9-6.4 15.5l-8 5.8C39.8 209.8 32 224 32 240c0 26.5 21.5 48 48 48h32V240c0-8.8 7.2-16 16-16zm-16 96H80c-44.2 0-80-35.8-80-80c0-26.7 13.1-50.3 33.2-64.9l0 0c-.7-4.7-1.2-9.9-1.2-15.1c0-53 43-96 96-96s96 43 96 96c0 5.2-.5 10.4-1.2 15.1l0 0C242.9 189.7 256 213.3 256 240c0 44.2-35.8 80-80 80H144V496c0 8.8-7.2 16-16 16s-16-7.2-16-16V320z\"></path></svg>\n</i>", "name": "تفریحات"}, "Visa": {"icon": "<i>\n<svg viewbox=\"0 0 448 512\" xmlns=\"http://www.w3.org/2000/svg\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M224 80c-70.75 0-128 57.25-128 128s57.25 128 128 128s128-57.25 128-128S294.8 80 224 80zM129.6 224h39.13c1.5 27 6.5 51.38 14.12 70.38C155.3 281.1 134.9 255.3 129.6 224zM168.8 192H129.6c5.25-31.25 25.62-57.13 53.25-70.38C175.3 140.6 170.3 165 168.8 192zM224 302.8C216.3 295.3 203.3 268.3 200.6 224h46.75C244.8 268.3 231.8 295.3 224 302.8zM200.5 192C203.3 147.8 216.3 120.8 224 113.3C231.8 120.8 244.8 147.8 247.4 192H200.5zM265.1 294.4C272.8 275.4 277.8 251 279.3 224h39.13C313.1 255.3 292.8 281.1 265.1 294.4zM279.3 192c-1.5-27-6.5-51.38-14.12-70.38c27.62 13.25 48 39.13 53.25 70.38H279.3zM448 368v-320C448 21.49 426.5 0 400 0h-320C35.82 0 0 35.82 0 80V448c0 35.35 28.65 64 64 64h368c8.844 0 16-7.156 16-16S440.8 480 432 480H416v-66.95C434.6 406.4 448 388.8 448 368zM384 480H64c-17.64 0-32-14.36-32-32s14.36-32 32-32h320V480zM400 384H64c-11.71 0-22.55 3.389-32 8.9V80C32 53.49 53.49 32 80 32h320C408.8 32 416 39.16 416 48v320C416 376.8 408.8 384 400 384z\"></path></svg>\n</i>", "name": "ویزا"}}';



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