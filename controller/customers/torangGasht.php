<?php
//todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************


//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');


class torangGasht extends mainPage {

    public function __construct() {
        parent::__construct();
    }


    public function classTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'Flight':
                return '                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                            <path d="M562.7 221.2C570.3 230.8 576 242.6 576 256C576 282.9 554.4 303.1 534.2 315.2C513.1 327.9 486.9 336 466.3 336H365.9L279.1 487.8C270.6 502.8 254.7 512 237.4 512H181.2C159.1 512 144.6 491.7 150.4 471.2L189.1 336H136L97.6 387.2C91.56 395.3 82.07 400 72 400H30.03C13.45 400 0 386.6 0 369.1C0 367.2 .3891 364.4 1.156 361.7L31.36 256L1.156 150.3C.3888 147.6 0 144.8 0 142C0 125.4 13.45 112 30.03 112H72C82.07 112 91.56 116.7 97.6 124.8L136 176H189.1L150.4 40.79C144.6 20.35 159.1 0 181.2 0H237.4C254.7 0 270.6 9.23 279.1 24.19L365.9 176H466.3C486.1 176 513.3 184.4 534.3 197.2C544.9 203.7 555 211.7 562.7 221.2L562.7 221.2zM517.7 224.6C500.4 214.1 479.8 208 466.3 208H356.6C350.8 208 345.5 204.9 342.7 199.9L251.3 40.06C248.5 35.08 243.2 32 237.4 32H181.2L225.7 187.6C227 192.4 226.1 197.6 223.1 201.6C220 205.6 215.3 208 210.3 208H128C122.1 208 118.2 205.6 115.2 201.6L72 144H32.64L63.38 251.6C64.21 254.5 64.21 257.5 63.38 260.4L32.64 368H72L115.2 310.4C118.2 306.4 122.1 304 128 304H210.3C215.3 304 220 306.4 223.1 310.4C226.1 314.4 227 319.6 225.7 324.4L181.2 480H237.4C243.2 480 248.5 476.9 251.3 471.9L342.7 312.1C345.5 307.1 350.8 304 356.6 304H466.3C479.9 304 500.5 298.1 517.7 287.8C535.8 276.9 544 265.1 544 256C544 251.9 542.3 246.1 537.7 241.2C533.1 235.5 526.2 229.7 517.7 224.6L517.7 224.6zM265.2 32.12L251.3 40.06z"/>
                                        </svg>';
                break;
            case 'Hotel':
                return '
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path d="M48 384C56.84 384 64 376.8 64 368c0-105.9 86.13-192 192-192s192 86.13 192 192c0 8.844 7.156 16 16 16s16-7.156 16-16c0-118.1-91.97-214.9-208-223.2V96h32C312.8 96 320 88.84 320 80S312.8 64 304 64h-96C199.2 64 192 71.16 192 80S199.2 96 208 96h32v48.81C123.1 153.1 32 249.9 32 368C32 376.8 39.16 384 48 384zM496 416h-480C7.156 416 0 423.2 0 432S7.156 448 16 448h480c8.844 0 16-7.156 16-16S504.8 416 496 416z"/>
                                        </svg>
                ';
                break;
            case 'Visa':
                return '
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com/ License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M336 384h-224C103.3 384 96 391.3 96 400S103.3 416 112 416h224c8.75 0 16-7.25 16-16S344.8 384 336 384zM224 64C153.3 64 96 121.3 96 192s57.25 128 128 128s128-57.25 128-128S294.8 64 224 64zM129.6 208h39.13c1.5 27 6.5 51.38 14.12 70.38C155.3 265.1 134.9 239.3 129.6 208zM168.8 176H129.6c5.25-31.25 25.62-57.13 53.25-70.38C175.3 124.6 170.3 149 168.8 176zM224 286.8C216.3 279.3 203.2 252.3 200.5 208h46.84C244.8 252.3 231.8 279.3 224 286.8zM200.6 176C203.3 131.8 216.3 104.8 224 97.25C231.8 104.8 244.8 131.8 247.5 176H200.6zM265.1 278.4C272.8 259.4 277.8 235 279.3 208h39.13C313.1 239.3 292.8 265.1 265.1 278.4zM279.3 176c-1.5-27-6.5-51.38-14.12-70.38c27.62 13.25 48 39.13 53.25 70.38H279.3zM384 0H64C28.65 0 0 28.65 0 64v384c0 35.34 28.65 64 64 64h320c35.2 0 64-28.8 64-64V64C448 28.8 419.2 0 384 0zM416 448c0 17.67-14.33 32-32 32H64c-17.6 0-32-14.4-32-32V64c0-17.6 14.4-32 32-32h320c17.67 0 32 14.33 32 32V448z"/></svg>                ';
                break;
            case 'Insurance':
                return '
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path d="M255.1 320C247.2 320 240 327.2 240 336V448c0 17.66-14.34 32-32 32s-32-14.34-32-32v-16C176 423.2 168.8 416 160 416s-16 7.156-16 16V448c0 35.28 28.72 64 63.1 64S272 483.3 272 448v-112C272 327.2 264.8 320 255.1 320zM271.8 32.78C271.9 32.5 272 32.28 272 32V16c0-8.844-7.157-16-16-16S240 7.156 240 16V32c0 .2754 .1426 .5039 .1562 .7773C106.4 40.77 0 148.4 0 280C0 284.4 3.594 288 8 288h496C508.4 288 512 284.4 512 280C512 148.4 405.6 40.77 271.8 32.78zM33.37 256C45.79 148.2 140.9 64 256 64s210.2 84.15 222.6 192H33.37z"/>
                                        </svg>
                ';
                break;
            default:
                return '';


        }
    }

    public function getInfoAuthClient() {
        if(functions::isTestServer()) {
            $accessList = ['Flight' , 'Hotel'  , 'Insurance' , 'Visa'] ;

            $accessService =  $this->getAccessServiceClient();

            $accessResult = [];
            foreach ($accessList as $key => $access) {
                $key  = array_search($access, array_column($accessService, "MainService"));
                $accessResult[] = $accessService[$key] ;
            }

            $accessService_new = [];
            foreach ($accessResult as $key => $access) {
                if($access['MainService'] ==  'Visa') {

                    $access['tab_id'] = 'visa-tab';
                    $access['tab'] = 'Visa';
                    $access['Title'] = ' ویزا ';
                    $accessService_new[3] = $access;
                }

                if($access['MainService'] ==  'Insurance') {

                    $access['tab_id'] = 'insurance-tab';
                    $access['tab'] = 'Insurance';
                    $access['Title'] = ' بیمه';
                    $accessService_new[2] = $access;
                }
                if($access['MainService'] ==  'Hotel') {

                    $access['tab_id'] = 'hotel-tab';
                    $access['tab'] = 'Hotel';
                    $access['Title'] = ' هتل';
                    $accessService_new[1] = $access;
                }
                if($access['MainService'] ==  'Flight') {

                    $access['tab_id'] = 'flight-tab';
                    $access['tab'] = 'Flight';
                    $access['Title'] = ' هواپیما';
                    $accessService_new[0] = $access;
                }
            }
            return $accessService_new;
        }else {
            $accessList = ['Flight' , 'Hotel'  , 'Insurance' , 'Visa'] ;

            $accessService =  $this->getAccessServiceClient();

            $accessResult = [];
            foreach ($accessList as $key => $access) {
                $key  = array_search($access, array_column($accessService, "MainService"));
                $accessResult[] = $accessService[$key] ;
            }

            $accessService_new = [];
            foreach ($accessResult as $key => $access) {

                if($access['MainService'] ==  'Visa') {

                    $access['tab_id'] = 'visa-tab';
                    $access['tab'] = 'Visa';
                    $access['Title'] = ' ویزا ';
                    $accessService_new[3] = $access;
                }
                if($access['MainService'] ==  'Insurance') {

                    $access['tab_id'] = 'insurance-tab';
                    $access['tab'] = 'Insurance';
                    $access['Title'] = ' بیمه';
                    $accessService_new[2] = $access;
                }
                if($access['MainService'] ==  'Hotel') {

                    $access['tab_id'] = 'hotel-tab';
                    $access['tab'] = 'Hotel';
                    $access['Title'] = ' هتل';
                    $accessService_new[1] = $access;
                }
                if($access['MainService'] ==  'Flight') {

                    $access['tab_id'] = 'flight-tab';
                    $access['tab'] = 'Flight';
                    $access['Title'] = ' هواپیما';
                    $accessService_new[0] = $access;
                }
            }
            return $accessService_new;

        }
    }

}