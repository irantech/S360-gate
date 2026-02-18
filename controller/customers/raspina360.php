<?php
//todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************
//if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}

class raspina360 extends mainPage {


    public function __construct() {
        parent::__construct();
    }


    public function classTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'Flight':
                return 'fa-light fa-plane-up';
                break;
            case 'Hotel':
                return 'fa-light fa-hotel';
                break;
            case 'Train':
                return 'fa-light fa-train';
                break;
            case 'Bus':
                return 'fa-light fa-bus';
                break;
            case 'Tour':
                return 'fa-light fa-person-walking-luggage';
                break;
            case 'Insurance':
                return 'fa-light fa-umbrella';
                break;
            case 'GashtTransfer':
                return 'fa-light fa-cars';
                break;
            default:
                return '';


        }
    }

    public function getInfoAuthClient() {
        if(functions::isTestServer()) {
            $access_list = ['Flight' , 'Hotel' ,   'Tour', 'Insurance' , 'GashtTransfer', 'Visa'] ;

            $access_service =  $this->getAccessServiceClient();

            $access_result = [];
            foreach ($access_list as $key => $access) {
                $key  = array_search($access, array_column($access_service, "MainService"));
                $access_result[] = $access_service[$key] ;
            }

            return $access_result;
        }
        return  $this->getAccessServiceClient();
    }




}