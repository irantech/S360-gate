<?php
//todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************



//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
class avaParvazAr extends mainPage {

    public function __construct() {
        parent::__construct();
    }

//    public function searchAirports($params)
//    {
//        $airports = $this->getController('airports');
//        if(isset($params['origin'])){
//            return $airports->findDestination($params);
//        }
//        return $airports->findOrigin($params);
//    }
//    public function allAirports()
//    {
//        $airports = $this->getController('airports');
//        return $airports->allAirports();
//    }


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



}