<?php
//todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************




class daryaGasht extends mainPage {

    public function __construct() {

        parent::__construct();
    }


    public function classTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'Flight':
                return '<i class="icon-tab icon-airplane">&#xe800;</i>';
                break;
            case 'Hotel':
                return '<i class="icon-tab icon-bed">&#xe808;</i>';
                break;
            case 'Bus':
                return '<i class="icon-tab icon-bus">&#xe80c;</i>';
                break;
            case 'Tour':
                return '<i class="icon-tab icon-suitcases">&#xe809;</i>';
                break;
            case 'Insurance':
                return '<i class="icon-tab icon-travel-insurance">&#xe80d;</i>';
                break;
            case 'GashtTransfer':
                return '<i class="icon-tab icon-patrol">&#xe80e;</i>';
                break;
            case 'Europcar':
                return '<i class="icon-tab icon-car-rental"></i>';
                break;
            case 'Visa':
                return '<i class="icon-tab icon-passport">&#xe80b;</i>';
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