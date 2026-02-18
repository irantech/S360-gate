<?php

class cacheAveragePriceFlightModel extends ModelBase
{

    protected $table = 'cache_average_price_flight_tb';

    public function getLastDataCacheAveragePriceFlight($params) {

        return $this->get()->where('origin',$params['origin'])->where('destination',$params['destination'])->orderBy('id','DESC')->limit(0,1)->find();
    }

    public function insertCacheDataAverage($params) {

        $this->insertLocal($params);
    }
}