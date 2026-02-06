<?php

class mainCountry extends baseController
{

    public function getCountryRecords($country_id)
    {
        $country=$this->getModel('reservationCountryModel')->get();
        $country->where('id',$country_id);
        return $country->all();
    }

    public function findCountryRecord($select=null)
    {

        $country=$this->getModel('reservationCountryModel')->get($select);
        return $country->all();
    }


}