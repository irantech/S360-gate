<?php
//todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************


//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');


class oshida extends mainPage {

    public function __construct() {
        parent::__construct();
    }


    public function classTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'internalFlight':
                return 'fas fa-plane-departure';
                break;
            case 'internationalFlight':
                return 'fas fa-plane-departure';
                break;
            case 'internalHotel':
                return 'fas fa-hotel';
                break;
            case 'Europcar':
                return 'fas fa-car';
                break;
            case 'Insurance':
                return 'fas fa-umbrella';
                break;
            case 'gasht':
                return 'fas fa-tree';
                break;
            case 'Tour':
                return 'fas fa-suitcase';
                break;
            default:
                return '';
        }
    }
    public function iconTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'internalFlight':
            case 'internationalFlight':
                return '&#xe800;';
                break;
            case 'internalHotel':
                return '&#xe80d;';
                break;
            default:
                return '';


        }
    }

    public function getInfoAuthClient() {
        if(functions::isTestServer()) {
            $accessList = ['Flight' , 'Hotel'] ;

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
                        'MainService'   =>  'internalFlight' ,
                        'Title' => ' داخلی',
                        'order_number'  => 1
                    ];
                    $external_flight = [
                        'id'            => 0,
                        'MainService'   =>  'internationalFlight' ,
                        'Title' => ' خارجی',
                        'order_number'  => 2
                    ];
                    $internal_hotel = [
                        'id' => 0,
                        'MainService' => 'internalHotel',
                        'Title' => 'هتل داخلی',
                        'order_number' => 3
                    ];

                    $gasht = [
                        'id' => 0,
                        'MainService' => 'gasht',
                        'Title' => 'گشت و ترانسفر',
                        'order_number' => 6
                    ];

                    array_unshift($accessService, $internal_flight, $external_flight,$internal_hotel,$gasht);
                }
            }

            return $accessResult;
        }else {
            $accessService = $this->getAccessServiceClient();
        
            foreach ($accessService as $key => $access) {
                if ($access['id'] == 1) {
                    $internal_flight = [
                        'id' => 0,
                        'MainService' => 'internalFlight',
                        'Title' => ' داخلی',
                        'order_number' => 1
                    ];
                    $external_flight = [
                        'id' => 0,
                        'MainService' => 'internationalFlight',
                        'Title' => ' خارجی',
                        'order_number' => 2
                    ];
                    $internal_hotel = [
                        'id' => 0,
                        'MainService' => 'internalHotel',
                        'Title' => 'هتل داخلی',
                        'order_number' => 3
                    ];
                    $gasht = [
                        'id' => 0,
                        'MainService' => 'gasht',
                        'Title' => 'گشت و ترانسفر',
                        'order_number' => 6
                    ];

                    array_unshift($accessService, $internal_flight, $external_flight,$internal_hotel,$gasht);
                }
            }

            return $accessService;
        }
    }

}