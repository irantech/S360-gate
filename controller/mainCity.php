<?php

class mainCity extends clientAuth
{

    /**
     * @return bool|mixed|reservationCityModel
     */
    public function reservationCityModel()
    {
        return Load::getModel('reservationCityModel');
    }


    public function fetchCityRecord($city_id,$select=null)
    {
        $country=$this->reservationCityModel()->get($select);
        $country->where('id',$city_id);
        return $country->all();
    }
    public function getCountryCities($country_id,$select=null)
    {
        $country=$this->reservationCityModel()->get($select);
        $country->where('id_country',$country_id);
        return $country->all();
    }

    public function getCityAll(){

        $city_model = $this->getModel('reservationCityModel')->get() ;
        return  $city_model->all();
    }
}