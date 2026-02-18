
        <?php
    //todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************

//        error_reporting(1);
//        error_reporting(E_ALL | E_STRICT);
//        @ini_set('display_errors', 1);
//        @ini_set('display_errors', 'on');


    class demoJami extends mainPage {

        public function __construct() {

            parent::__construct();
            $this->icons_json =  json_decode($this->icons_json, true);
        }

        public $icons_json = '{"Flight": {"icon": "<i>\n<svg viewbox=\"0 0 512 512\" xmlns=\"http://www.w3.org/2000/svg\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M256 0C304 0 336 74.04 336 112.1V154.1L496 254.1C504.1 260.1 512 270.1 512 282.1V347.2C512 357.2 507 367.2 499 373.2C491 379.2 480 381.2 471 378.2L336 335.2V376.2L387 416.2C395 422.2 400 431.2 400 441.2V480.2C400 490.2 395 500.2 387 505.2C379 511.3 368.1 513.3 360 511.3L256 480.2L152 510.2C142 513.3 132 511.3 124 505.2C116 499.2 112 490.2 112 480.2V440.2C112 430.2 116 421.2 124 415.2L176 376.2V335.2L41 378.2C31 381.2 20 379.2 12 373.2C4 367.2 0 357.2 0 347.2V282.1C0 271.1 6 259.1 16 254.1L176 153.1V112.1C176 74.04 207 0 256 0V0zM256 33.02C233 33.02 208 81.04 208 113.1V172.1L32 282.1V347.2L208 292.1V392.2L144 440.2V480.2L256 448.2L368 480.2V440.2L304 392.2V292.1L480 347.2V282.1L304 171.1V112.1C304 81.04 278 33.02 256 33.02V33.02z\"></path></svg>\n</i>", "name": "هواپیما"}, "Hotel": {"icon": "<i>\n<svg viewbox=\"0 0 640 512\" xmlns=\"http://www.w3.org/2000/svg\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M16 32C24.84 32 32 39.16 32 48V192H528C589.9 192 640 242.1 640 304V464C640 472.8 632.8 480 624 480C615.2 480 608 472.8 608 464V416H32V464C32 472.8 24.84 480 16 480C7.164 480 0 472.8 0 464V48C0 39.16 7.164 32 16 32zM32 384H608V352H32V384zM32 320H608V304C608 259.8 572.2 224 528 224H32V320z\"></path></svg>\n</i>", "name": "هتل"}, "Bus": {"icon": "<i><svg viewbox=\"0 0 576 512\" xmlns=\"http://www.w3.org/2000/svg\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M336 64C344.8 64 352 71.16 352 80C352 88.84 344.8 96 336 96H240C231.2 96 224 88.84 224 80C224 71.16 231.2 64 240 64H336zM184 352C184 365.3 173.3 376 160 376C146.7 376 136 365.3 136 352C136 338.7 146.7 328 160 328C173.3 328 184 338.7 184 352zM392 352C392 338.7 402.7 328 416 328C429.3 328 440 338.7 440 352C440 365.3 429.3 376 416 376C402.7 376 392 365.3 392 352zM72.3 69.88C96.5 40.06 164.2 0 288 0C420.6 0 481.2 39.95 504.2 70.2C510.2 78.14 512 87.36 512 95.15V384C512 407.7 499.1 428.4 480 439.4V496C480 504.8 472.8 512 464 512C455.2 512 448 504.8 448 496V448H128V496C128 504.8 120.8 512 112 512C103.2 512 96 504.8 96 496V439.4C76.87 428.4 64 407.7 64 384V95.15C64 87.42 65.79 77.91 72.3 69.88V69.88zM288 32C170.1 32 113.2 70.22 97.15 90.05C96.77 90.51 96 91.94 96 95.15V128H480V95.15C480 92 479.2 90.3 478.7 89.53C463.9 70.12 414.8 32 288 32zM272 256V160H96V256H272zM304 256H480V160H304V256zM128 416H448C465.7 416 480 401.7 480 384V288H96V384C96 401.7 110.3 416 128 416zM32 240C32 248.8 24.84 256 16 256C7.164 256 0 248.8 0 240V144C0 135.2 7.164 128 16 128C24.84 128 32 135.2 32 144V240zM576 240C576 248.8 568.8 256 560 256C551.2 256 544 248.8 544 240V144C544 135.2 551.2 128 560 128C568.8 128 576 135.2 576 144V240z\"></path></svg></i>", "name": "اتوبوس"}, "Insurance": {"icon": "<i>\n<svg viewbox=\"0 0 576 512\" xmlns=\"http://www.w3.org/2000/svg\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M480 32H320C302.3 32 288 46.33 288 64V65.6C282.8 64.55 277.5 64 272 64H256C256 28.65 284.7 0 320 0H480C515.3 0 544 28.65 544 64V448C544 483.3 515.3 512 480 512H336C342.1 502.7 348 491.8 350.4 480H480C497.7 480 512 465.7 512 448V64C512 46.33 497.7 32 480 32zM384 96C384 87.16 391.2 80 400 80C408.8 80 416 87.16 416 96V128H448C456.8 128 464 135.2 464 144C464 152.8 456.8 160 448 160H416V192C416 200.8 408.8 208 400 208C391.2 208 384 200.8 384 192V160H352C343.2 160 336 152.8 336 144C336 135.2 343.2 128 352 128H384V96zM352 288H512V320H352V288zM352 384H512V416H352V384zM160 192C160 183.2 167.2 176 176 176C184.8 176 192 183.2 192 192V224H224C232.8 224 240 231.2 240 240C240 248.8 232.8 256 224 256H192V288C192 296.8 184.8 304 176 304C167.2 304 160 296.8 160 288V256H128C119.2 256 112 248.8 112 240C112 231.2 119.2 224 128 224H160V192zM256 96C291.3 96 320 124.7 320 160V448C320 483.3 291.3 512 256 512H96C60.65 512 32 483.3 32 448V160C32 124.7 60.65 96 96 96H256zM96 128C78.33 128 64 142.3 64 160V352H288V160C288 142.3 273.7 128 256 128H96zM96 480H256C273.7 480 288 465.7 288 448V384H64V448C64 465.7 78.33 480 96 480z\"></path></svg>\n</i>", "name": "بیمه"}, "Tour": {"icon": "<i><svg viewbox=\"0 0 448 512\" xmlns=\"http://www.w3.org/2000/svg\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M352.1 128h-32.07l.0123-80c0-26.47-21.53-48-48-48h-96c-26.47 0-48 21.53-48 48L128 128H96.12c-35.35 0-64 28.65-64 64v224c0 35.35 28.58 64 63.93 64L96 496C96 504.8 103.2 512 112 512S128 504.8 128 496V480h192v16c0 8.836 7.164 16 16 16s16-7.164 16-16l.0492-16c35.35 0 64.07-28.65 64.07-64V192C416.1 156.7 387.5 128 352.1 128zM160 48C160 39.17 167.2 32 176 32h96C280.8 32 288 39.17 288 48V128H160V48zM384 416c0 17.64-14.36 32-32 32H96c-17.64 0-32-14.36-32-32V192c0-17.64 14.36-32 32-32h256c17.64 0 32 14.36 32 32V416zM304 336h-160C135.2 336 128 343.2 128 352c0 8.836 7.164 16 16 16h160c8.836 0 16-7.164 16-16C320 343.2 312.8 336 304 336zM304 240h-160C135.2 240 128 247.2 128 256c0 8.836 7.164 16 16 16h160C312.8 272 320 264.8 320 256C320 247.2 312.8 240 304 240z\"></path></svg></i>", "name": "تور"}, "Visa": {"icon": "<i><svg viewbox=\"0 0 448 512\" xmlns=\"http://www.w3.org/2000/svg\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M224 80c-70.75 0-128 57.25-128 128s57.25 128 128 128s128-57.25 128-128S294.8 80 224 80zM129.6 224h39.13c1.5 27 6.5 51.38 14.12 70.38C155.3 281.1 134.9 255.3 129.6 224zM168.8 192H129.6c5.25-31.25 25.62-57.13 53.25-70.38C175.3 140.6 170.3 165 168.8 192zM224 302.8C216.3 295.3 203.3 268.3 200.6 224h46.75C244.8 268.3 231.8 295.3 224 302.8zM200.5 192C203.3 147.8 216.3 120.8 224 113.3C231.8 120.8 244.8 147.8 247.4 192H200.5zM265.1 294.4C272.8 275.4 277.8 251 279.3 224h39.13C313.1 255.3 292.8 281.1 265.1 294.4zM279.3 192c-1.5-27-6.5-51.38-14.12-70.38c27.62 13.25 48 39.13 53.25 70.38H279.3zM448 368v-320C448 21.49 426.5 0 400 0h-320C35.82 0 0 35.82 0 80V448c0 35.35 28.65 64 64 64h368c8.844 0 16-7.156 16-16S440.8 480 432 480H416v-66.95C434.6 406.4 448 388.8 448 368zM384 480H64c-17.64 0-32-14.36-32-32s14.36-32 32-32h320V480zM400 384H64c-11.71 0-22.55 3.389-32 8.9V80C32 53.49 53.49 32 80 32h320C408.8 32 416 39.16 416 48v320C416 376.8 408.8 384 400 384z\"></path></svg></i>", "name": "ویزا"}, "Entertainment": {"icon": "<i>\n<svg viewbox=\"0 0 576 512\" xmlns=\"http://www.w3.org/2000/svg\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M471.6 99.4c46.8 45.1 72.2 109 68.3 174.7l-86.3-31.4c15.2-43.2 21.6-89 18.9-134.8c-.2-2.9-.5-5.7-.9-8.5zM402.8 54.3c21.7 10.1 36.3 31.4 37.7 55.6c2.5 41.4-3.3 82.8-17 121.9l-167.6-61c14.6-38.8 36.9-74.2 65.3-104.3c17.5-18.5 44.1-25.2 68.2-17.3c1.1 .4 2.2 .8 3.3 1.2c3.4 1.2 6.7 2.5 10 3.9zm-3.1-35.4c-109.8-38-228.4 3.2-292.6 94c-11.1 15.7-2.8 36.8 15.3 43.4l92.4 33.6 0 0L245 200.9l167.6 61 30.1 10.9 0 0 89.1 32.4c18.1 6.6 38-4.2 39.6-23.4c9-108.1-52-213.2-155.6-256.9c-2.4-1.1-4.9-2.1-7.4-3l-5.9-2.1c-.9-.3-1.8-.6-2.7-.9zM305.9 37c-2.7 2.3-5.4 4.8-7.9 7.5c-31.5 33.3-56 72.5-72.2 115.4l-89.6-32.6C176.5 73 239.2 40.1 305.9 37zM16 480c-8.8 0-16 7.2-16 16s7.2 16 16 16H560c8.8 0 16-7.2 16-16s-7.2-16-16-16H253.4l77.8-213.7-30.1-10.9L219.4 480H16z\"></path></svg>\n</i>", "name": "تفریحات"}, "Europcar": {"icon": "<i>\n<svg viewbox=\"0 0 512 512\" xmlns=\"http://www.w3.org/2000/svg\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M80 296C80 282.7 90.75 272 104 272C117.3 272 128 282.7 128 296C128 309.3 117.3 320 104 320C90.75 320 80 309.3 80 296zM432 296C432 309.3 421.3 320 408 320C394.7 320 384 309.3 384 296C384 282.7 394.7 272 408 272C421.3 272 432 282.7 432 296zM48.29 204.7L82.99 89.01C93.14 55.17 124.3 32 159.6 32H352.4C387.7 32 418.9 55.17 429 89.01L463.7 204.7C492.6 221.2 512 252.3 512 288V464C512 472.8 504.8 480 496 480C487.2 480 480 472.8 480 464V416H32V464C32 472.8 24.84 480 16 480C7.164 480 0 472.8 0 464V288C0 252.3 19.44 221.2 48.29 204.7zM85.33 192.6C88.83 192.2 92.39 192 96 192H416C419.6 192 423.2 192.2 426.7 192.6L398.4 98.21C392.3 77.9 373.6 64 352.4 64H159.6C138.4 64 119.7 77.9 113.6 98.21L85.33 192.6zM32 288V384H480V288C480 260.3 462.4 236.7 437.7 227.8L437.3 227.9L437.2 227.6C430.5 225.3 423.4 224 416 224H96C88.58 224 81.46 225.3 74.83 227.6L74.73 227.9L74.27 227.8C49.62 236.7 32 260.3 32 288V288z\"></path></svg>\n</i>", "name": "اجاره خودرو"}}';



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