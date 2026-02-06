<?php
//todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************

//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');


class hayatSeir extends mainPage {

    public function __construct() {

        parent::__construct();
    }


    public function classTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'Flight':
                return 'fa-light fa-plane-circle-check';
                break;
            case 'Hotel':
                return '<i><svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M48 384C56.84 384 64 376.8 64 368c0-105.9 86.13-192 192-192s192 86.13 192 192c0 8.844 7.156 16 16 16s16-7.156 16-16c0-118.1-91.97-214.9-208-223.2V96h32C312.8 96 320 88.84 320 80S312.8 64 304 64h-96C199.2 64 192 71.16 192 80S199.2 96 208 96h32v48.81C123.1 153.1 32 249.9 32 368C32 376.8 39.16 384 48 384zM496 416h-480C7.156 416 0 423.2 0 432S7.156 448 16 448h480c8.844 0 16-7.156 16-16S504.8 416 496 416z"></path></svg></i>';
                break;
            case 'Train':
                return 'fa-light fa-train';
                break;
            case 'Package':
                return 'fa-light fa-tree-palm';
                break;
            case 'Bus':
                return 'fa-light fa-bus';
                break;
            case 'Tour':
                return '<i><svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M352.1 128h-32.07l.0123-80c0-26.47-21.53-48-48-48h-96c-26.47 0-48 21.53-48 48L128 128H96.12c-35.35 0-64 28.65-64 64v224c0 35.35 28.58 64 63.93 64L96 496C96 504.8 103.2 512 112 512S128 504.8 128 496V480h192v16c0 8.836 7.164 16 16 16s16-7.164 16-16l.0492-16c35.35 0 64.07-28.65 64.07-64V192C416.1 156.7 387.5 128 352.1 128zM160 48C160 39.17 167.2 32 176 32h96C280.8 32 288 39.17 288 48V128H160V48zM384 416c0 17.64-14.36 32-32 32H96c-17.64 0-32-14.36-32-32V192c0-17.64 14.36-32 32-32h256c17.64 0 32 14.36 32 32V416zM304 336h-160C135.2 336 128 343.2 128 352c0 8.836 7.164 16 16 16h160c8.836 0 16-7.164 16-16C320 343.2 312.8 336 304 336zM304 240h-160C135.2 240 128 247.2 128 256c0 8.836 7.164 16 16 16h160C312.8 272 320 264.8 320 256C320 247.2 312.8 240 304 240z"></path></svg></i>';
                break;
            case 'Insurance':
                return 'fa-light fa-umbrella-beach';
                break;
            case 'GashtTransfer':
                return 'fa-light fa-cars';
                break;
            case 'Europcar':
                return 'fa-light fa-car';
                break;
            case 'Entertainment':
                return 'fa-light fa-tree-city';
                break;
            case 'Visa':
                return 'fa-light fa-book-atlas';
                break;
            default:
                return '';


        }
    }


    public function nameTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'Flight':
                return functions::Xmlinformation("Airplane") ;
                break;
            case 'Hotel':
                return functions::Xmlinformation("Hotel") ;
                break;
            case 'Train':
                return functions::Xmlinformation("Train") ;
                break;
            case 'Package':
                return functions::Xmlinformation("Flight") . '+' . functions::Xmlinformation("Hotel") ;
                break;
            case 'Bus':
                return functions::Xmlinformation("Bus") ;
                break;
            case 'Tour':
                return functions::Xmlinformation("Tour") ;
                break;
            case 'Insurance':
                return functions::Xmlinformation("Insurance") ;
                break;
            case 'GashtTransfer':
                return functions::Xmlinformation("GashtTransfer") ;
                break;
            case 'Europcar':
                return functions::Xmlinformation("Carrental") ;
                break;
            case 'Entertainment':
                return functions::Xmlinformation("Entertainment") ;
                break;
            case 'Visa':
                return functions::Xmlinformation("ImmigrationVisa") ;
                break;
            default:
                return '';


        }
    }


    public function nameBoxSearchBox($service_name) {
        switch ($service_name) {
            case 'Flight':
                return ' بلیط هواپیمای داخلی و خارجی ' ;
                break;
            case 'Hotel':
                return ' هتل های داخلی و خارجی' ;
                break;
            case 'Train':
                return ' بلیط قطار' ;
                break;
            case 'Package':
                return ' پکیج هواپیما و هتل';
                break;
            case 'Bus':
                return ' بلیط اتوبوس' ;
                break;
            case 'Tour':
                return ' تور های داخلی و خارجی' ;
                break;
            case 'Insurance':
                return ' بیمه مسافرتی' ;
                break;
            case 'GashtTransfer':
                return ' گشت و ترانسفر' ;
                break;
            case 'Europcar':
                return ' خودرو' ;
                break;
            case 'Entertainment':
                return ' تفریحات' ;
                break;
            case 'Visa':
                return ' ویزا' ;
                break;
            default:
                return '';


        }
    }

}