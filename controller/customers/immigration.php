<?php

//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

class immigration extends mainPage
{

    public function classTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'flight-Internal':
            case 'flight-Foreign':
                return 'icon-tab icon-airplane';
            default:
                return '';
        }
    }

    public function iconTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'flight-Internal':
            case 'flight-Foreign':
                return '&#xe800;';

            default:
                return '';


        }
    }



}