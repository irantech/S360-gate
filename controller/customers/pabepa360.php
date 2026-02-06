<?php
//todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************




class pabepa360 extends mainPage {

    public function __construct() {
        parent::__construct();
    }


    public function classTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'Flight':
                return 'fa-light fa-plane-circle-check';
                break;
            case 'Hotel':
                return 'fa-light fa-bell-concierge';
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
                return 'fa-light fa-suitcase-rolling';
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

    public function getInfoAuthClient() {
//        if(functions::isTestServer()) {
            $access_list = ['Tour' , 'Flight'] ;

            $access_service =  $this->getAccessServiceClient();

            $access_result = [];
            foreach ($access_list as $key => $access) {
                $key  = array_search($access, array_column($access_service, "MainService"));
                $access_result[] = $access_service[$key] ;
            }

            return $access_result;
//        }
//
//        return  $this->getAccessServiceClient();
    }

}