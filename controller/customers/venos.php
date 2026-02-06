<?php
//todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************


//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');


class venos extends mainPage {

    public function __construct() {
        parent::__construct();
    }


    public function classTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'Flight':
                return '<i class="icon-tab icon-airplane">&#xe800;</i>';

            case 'Insurance':
                return '<i class="icon-tab icon-travel-insurance">&#xe80d;</i>';

            case 'Visa':
                return '<i class="fa-light fa-book-atlas"></i>';

            default:
                return '';


        }
    }

    public function classTabsSearchBoxDetail($service_name) {
        switch ($service_name) {
            case 'Flight':
                return $detail = [
                    'tab_name' => 'پرواز خارجی',
                    'tab_href' => 'Flight',
                    'tab_icon' => '<i class="icon-tab icon-airplane">&#xe800;</i>'
                ];

            case 'Insurance':
                return $detail = [
                    'tab_name' => 'بیمه',
                    'tab_href' => 'Insurance',
                    'tab_icon' => '<i class="icon-tab icon-travel-insurance">&#xe80d;</i>'
                ];

            case 'Visa':
                return $detail = [
                    'tab_name' => 'ویزا',
                    'tab_href' => 'Visa',
                    'tab_icon' => '<i class="fa-light fa-book-atlas"></i>'
                ];

            default:
                return  null;
        }

    }



}