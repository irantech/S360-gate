<?php
//todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************


//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');


class ababil extends mainPage {

    public function __construct() {
        parent::__construct();
    }

    public function getInfoAuthClient() {
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
                        'id'            => 1,
                        'MainService'   =>  'flight-internal' ,
                        'Title' => 'پرواز داخلی',
                        'order_number'  => 1
                    ];
                    $external_flight = [
                        'id'            => 1,
                        'MainService'   =>  'flight-internation' ,
                        'Title' => 'پرواز خارجی',
                        'order_number'  => 2
                    ];
                }
                if($access['id'] ==  2) {

                    $internal_hotel = [
                        'id'            => 2,
                        'MainService'   =>  'hotel-internal' ,
                        'Title' => 'هتل داخلی',
                        'order_number'  => 3
                    ];
                    $external_hotel = [
                        'id'            => 2,
                        'MainService'   =>  'hotel-internation' ,
                        'Title' => 'هتل خارجی',
                        'order_number'  => 4
                    ];
                }
            }
            array_unshift($accessResult,$internal_flight, $external_flight,$internal_hotel, $external_hotel);
//            var_dump($accessResult);
//            die();

            return $accessResult;
    }


    public function classTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'flight-internal':
                return 'fa-light fa-paper-plane';
                break;
            case 'flight-internation':
                return 'fa-light fa-bed-empty';
                break;
            case 'hotel-internal':
                return 'fa-light fa-bed-empty';
                break;
            case 'hotel-internation':
                return 'fa-light fa-bed-empty';
                break;
            default:
                return '';


        }
    }



}