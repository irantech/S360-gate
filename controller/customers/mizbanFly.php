<?php

//error_reporting(0);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
class mizbanFly extends mainPage
{

    public function classTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'internalFlight':
            case 'internationalFlight':
                return 'icon-tab icon-airplane';
                break;
            case 'Insurance':
                return 'icon-tab icon-travel-insurance';
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
            case 'Insurance':
                return '&#xe80d;';
                break;
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
        $accessService =  $this->getAccessServiceClient();
        foreach ($accessService as $key => $access) {
            if($access['id'] ==  1) {
                $internal_flight = [
                    'id'            => 0,
                    'MainService'   =>  'internalFlight' ,
                    'Title'         =>  'داخلی',
                    'order_number'  => 1
                ];
                $external_flight = [
                    'id'            => 0,
                    'MainService'   =>  'internationalFlight' ,
                    'Title'         =>  'خارجی' ,
                    'order_number'  => 2
                ];
                array_unshift($accessService,$internal_flight,$external_flight);
            }
        }
        return $accessService;
    }

    public function dataFastSearchInternalFlight($params){

        $array_cities = array();
        $params_search['limit'] = $params['limit'];
        $params_search['iata'] = 'THR';
        $params_search['is_group'] = true;

        $cities = $this->getController('routeFlight')->listRouteArrival($params_search);

        $array_cities['start_date'] = date('Y-m-d');

        foreach ($cities as $key=>$city){
            $array_cities['cities_flight'][$key]= $city ;
        }
        return $array_cities ;
    }

}