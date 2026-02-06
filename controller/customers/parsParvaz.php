<?php
//todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************
//if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}

class parsParvaz extends mainPage {

    public function __construct() {

        parent::__construct();
    }





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
        switch ($service_name) {
            case 'Flight':
                return ['Flight_internal' =>'<i class="icon-tab icon-airplane">&#xe800;</i>', 'Flight_external' => '<i class="icon-tab icon-airplane">&#xe800;</i>'];
                break;
            case 'Hotel':
                return ['Hotel_internal' =>'<i class="icon-tab icon-bed">&#xe808;</i>' ,'Hotel_external' =>'<i class="icon-tab icon-bed">&#xe808;</i>'];
                break;
            case 'Bus':
                return ['Bus' =>'<i class="icon-tab icon-bus"></i>'];
                break;
            case 'Tour':
                return ['Tour_internal' =>'<i class="icon-tab icon-suitcases">&#xe809;</i>' ,'Tour_external' =>'<i class="icon-tab icon-suitcases">&#xe809;</i>'];
                break;
            case 'Visa':
                return ['Visa' =>'<i class="icon-tab icon-passport"></i>'];
                break;
            default:
                return '';

        }
    }


    public function nameTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'Flight_internal':
                return 'پرواز داخلی' ;
                break;
            case 'Flight_external':
                return 'پرواز خارجی' ;
                break;
            case 'Hotel_internal':
                return 'هتل داخلی' ;
                break;
            case 'Hotel_external':
                return 'هتل خارجی'  ;
                break;
            case 'Bus':
                return 'اتوبوس' ;
                break;
            case 'Tour_internal':
                return 'تور داخلی' ;
                break;
            case 'Tour_external':
                return 'تور خارجی' ;
                break;
            case 'Visa':
                return 'ویزا' ;
                break;
            default:
                return '';


        }
    }


    public function nameBoxSearchBox($service_name) {
        switch ($service_name) {
            case 'Flight_internal':
                return 'هواپیمای داخلی ' ;
                break;
            case 'Flight_external':
                return 'هواپیمای خارجی ' ;
                break;
            case 'Hotel_internal':
                return 'هتل داخلی' ;
                break;
            case 'Hotel_external':
                return 'هتل خارجی'  ;
                break;
            case 'Bus':
                return 'اتوبوس' ;
                break;
            case 'Tour_internal':
                return 'تور داخلی' ;
                break;
            case 'Tour_external':
                return 'تور خارجی' ;
                break;
            case 'Visa':
                return 'ویزا' ;
                break;
            default:
                return '';

        }
    }

}