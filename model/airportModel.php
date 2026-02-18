<?php

class airportModel extends ModelBase {
	protected $table = 'airports_tb';
	protected $pk = 'id';

    public function getAirport($params) {
        return $this->get(['*'])->where('DepartureCode' , $params)->find();
    }
}