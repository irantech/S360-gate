<?php


class gashToTransferCities extends clientAuth{

    public function __construct() {
        parent::__construct();
    }


    public function gashtTransferCities( $params = null ) {
        $result = $this->getModel('gashToTransferCitiesModel')->get()->all();
        if($params['is_json']){
            return functions::withSuccess($result,200,'data fetched successfully');
        }
        return $result ;
    }


}