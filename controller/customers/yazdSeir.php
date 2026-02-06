<?php
//todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************


//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');


class yazdSeir extends mainPage {

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
                    'MainService'   =>  'pills-home' ,
                    'Title' => 'پرواز داخلی',
                    'order_number'  => 1
                ];
                $external_flight = [
                    'id'            => 1,
                    'MainService'   =>  'pills-profile' ,
                    'Title' => 'پرواز خارجی',
                    'order_number'  => 2
                ];
            }
        }
        array_unshift($accessResult,$internal_flight, $external_flight);
//            var_dump($accessResult);
//            die();

        return $accessResult;
    }


    public function classTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'pills-home':
                return 'fa-light fa-angle-left';
                break;
            case 'pills-profile':
                return 'fa-light fa-angle-left';
                break;
            default:
                return '';


        }
    }



}