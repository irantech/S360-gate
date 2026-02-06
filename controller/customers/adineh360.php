<?php
//todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************




class adineh360 extends mainPage {

    public function __construct() {

        parent::__construct();
    }


    public function classTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'Flight':
                return 'fa-sharp fa-light fa-plane-departure';
                break;
            case 'Flight_internal':
                return 'fa-sharp fa-light fa-plane-departure';
                break;
            case 'Hotel_internal':
                return 'fa-light fa-hotel';
                break;
            case 'Flight_external':
                return 'fa-light fa-plane-circle-check';
                break;
            case 'Hotel_external':
                return 'fa-light fa-bell-concierge';
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


    public function nameTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'Flight':
                return functions::Xmlinformation("Airplane") ;
                break;
            case 'Flight_internal':
                return 'پرواز داخلی' ;
                break;
            case 'Hotel_internal':
                return 'هتل داخلی' ;
                break;
            case 'Flight_external':
                return 'پرواز خارجی' ;
                break;
            case 'Hotel_external':
                return 'هتل خارجی' ;
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
                return functions::Xmlinformation("Visa") ;
                break;
            default:
                return '';


        }
    }


    public function nameBoxSearchBox($service_name) {
        switch ($service_name) {
            case 'Flight':
                return functions::Xmlinformation("foreingIranFlightsTickets") ;
                break;
            case 'Hotel':
                return "هتل داخلی" ;
                break;
            case 'Flight_internal':
                return 'پرواز داخلی' ;
                break;
            case 'Hotel_internal':
                return 'هتل داخلی' ;
                break;
            case 'Flight_external':
                return 'پرواز خارجی' ;
                break;
            case 'Hotel_external':
                return 'هتل خارجی' ;
                break;
            case 'Train':
                return functions::Xmlinformation("trainTicket") ;
                break;
            case 'Package':
                return functions::Xmlinformation("flightHotelpackage") ;
                break;
            case 'Bus':
                return functions::Xmlinformation("Busticket") ;
                break;
            case 'Tour':
                return functions::Xmlinformation("foreigneIranTours") ;
                break;
            case 'Insurance':
                return functions::Xmlinformation("travelInsurance") ;
                break;
            case 'GashtTransfer':
                return functions::Xmlinformation("GashtTransfer") ;
                break;
            case 'Europcar':
                return functions::Xmlinformation("S360Car") ;
                break;
            case 'Entertainment':
                return functions::Xmlinformation("S360Entertainment") ;
                break;
            case 'Visa':
                return functions::Xmlinformation("Visa") ;
                break;
            default:
                return '';


        }
    }

    public function services($services) {
        $services_ids = ['Flight_internal' => 'Flight','Hotel_internal' =>'Hotel','Flight_external' => 'Flight','Hotel_external' =>'Hotel'
            ,'Tour' => 'Tour','Visa' => 'Visa','Insurance' => 'Insurance'];
        $active_services = [];
        $final_services = [];

        foreach ($services as $key => $val) {
            $active_services[] = $val['MainService'];
        }
        foreach ($services_ids as $k => $v) {
            if (!in_array($v, $active_services)) {
                foreach ($services_ids as $key => $value) {
                    if ($value == $v) {
                        unset($services_ids[$key]);
                    }
                }
            }
        }
        foreach ($services_ids as $id_key => $id_val) {
            foreach ($services as $key => $val) {
                if ($val['MainService'] == $id_val) {
                    $val['MainService'] = $id_key;
                    $final_services[] = $val;
                }
            }
        }


        return $final_services;

    }

}