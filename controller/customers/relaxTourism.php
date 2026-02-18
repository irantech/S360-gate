<?php
//todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************




class relaxTourism extends mainPage {

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