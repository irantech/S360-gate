<?php
//todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************

//
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');


class marzporgohar extends mainPage {

    public function __construct() {
        parent::__construct();

//        functions::displayErrorLog('ss');
    }


    public function classTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'Tour':
                return '<i class="icon-tab icon-suitcases">&#xe809;</i>';
                break;
            default:
                return '';


        }
    }



}