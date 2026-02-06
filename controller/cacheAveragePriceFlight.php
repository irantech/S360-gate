<?php

class cacheAveragePriceFlight extends clientAuth
{
    public function __construct() {
        parent::__construct();
    }

    public function getLastDataCacheAveragePriceFlight($params) {
        return $this->getModel('cacheAveragePriceFlightModel')->getLastDataCacheAveragePriceFlight($params);
    }

    public function insertDataCacheAveragePrice($params) {
        $data_insert=[
            'origin'=>$params['origin'],
            'destination'=>$params['destination'],
            'data_price'=> json_encode($params['results'],256|64),
            'creation_date_int'=> time()
        ];

        return $this->getModel('cacheAveragePriceFlightModel')->insertCacheDataAverage($data_insert);
    }


}