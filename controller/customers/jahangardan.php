<?php

//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

class jahangardan extends mainPage
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

    public function linkTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'internalFlight':
            case 'internationalFlight':
                return '#'.$service_name;
                break;
            case 'Insurance':
                return ROOT_ADDRESS.'/page/insurance';
                break;
            default:
                return '';


        }
    }

    public function getInfoAuthClient() {

        if(functions::isTestServer()) {
            $accessList = ['Flight'] ;

            $accessService =  $this->getAccessServiceClient();

            $accessResult = [];
            foreach ($accessList as $key => $access) {
                $key  = array_search($access, array_column($accessService, "MainService"));
                $accessResult[] = $accessService[$key] ;
            }


            foreach ($accessResult as $key => $access) {

                if($access['id'] ==  1) {

                    $internal_flight = [
                        'id'            => 0,
                        'MainService'   =>  'flight-Internal' ,
                        'Title' => ' داخلی',
                        'order_number'  => 1
                    ];
                    $external_flight = [
                        'id'            => 0,
                        'MainService'   =>  'flight-Foreign' ,
                        'Title' => ' خارجی',
                        'order_number'  => 2
                    ];

                    array_unshift($accessResult,$internal_flight,$external_flight);
                }
            }
            return $accessResult;
        }else {
            $accessList = ['Flight'] ;
            $accessService =  $this->getAccessServiceClient();

            $accessResult = [];
            foreach ($accessList as $key => $access) {
                foreach ($accessService as $key => $service) {

                    if($service['MainService'] == $access) {
                        $accessResult[] = $service ;
                    }

                }
            }



            foreach ($accessResult as $key => $access) {

                if($access['id'] ==  1) {

                    $internal_flight = [
                        'id'            => 0,
                        'MainService'   =>  'flight-Internal' ,
                        'Title' => ' داخلی',
                        'order_number'  => 1
                    ];
                    $external_flight = [
                        'id'            => 0,
                        'MainService'   =>  'flight-Foreign' ,
                        'Title' => ' خارجی',
                        'order_number'  => 2
                    ];

                    array_unshift($accessResult,$internal_flight,$external_flight);
                }
            }
       
            return $accessResult;
        }
    }

}