<?php
//todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************


//if(CLIENT_ID == '287') {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}

class setarehMirdamad extends mainPage {

    public function __construct() {
        parent::__construct();
    }


    public function classTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'Flight':
                return [
                    'icon' => 'icon-tab icon-airplane' ,
                    'inner' => '&#xe800;'
                ];
                break;
            case 'Hotel':
                return [
                    'icon' => 'icon-tab icon-bed' ,
                    'inner' => '&#xe808;'
                ];
                break;
            case 'Tour':
                return [
                    'icon' => 'icon-tab icon-suitcases' ,
                    'inner' => '&#xe809;'
                ];
                break;
            case 'Train':
                return [
                    'icon' => 'icon-tab icon-train' ,
                    'inner' => '&#xe803;'
                ];
                break;
            case 'Insurance':
                return [
                    'icon' => 'icon-tab icon-travel-insurance' ,
                    'inner' => '&#xe80d;'
                ];
                break;
            default:
                return '';
        }
    }

    public function getInfoAuthClient() {
        if(functions::isTestServer()) {
            $accessList = ['Flight' , 'Hotel'  , 'Tour', 'Train', 'Insurance'] ;

            $accessService =  $this->getAccessServiceClient();

            $accessResult = [];
            foreach ($accessList as $key => $access) {
                $key  = array_search($access, array_column($accessService, "MainService"));
                $accessResult[] = $accessService[$key] ;
            }

            return $accessResult;
        }else {
            return $this->getAccessServiceClient();

        }
    }

}