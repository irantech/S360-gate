<?php


class reservationCountry extends clientAuth {

    public function __construct() {
        parent::__construct();
    }

    public function countriesOfContinent($param) {
        $continent_id= $param ;
        if(is_array($param)){
            $continent_id = $param['continent_id'];
        }

        $result_countries = $this->getModel( 'reservationCountryModel' )->get()->where( 'id_continent',  $continent_id )
            ->where('is_del' , 'no')->all();
        if($param['is_json']){
            return functions::withSuccess($result_countries,200,'data fetched successfully');
        }
        return  $result_countries ;
    }
    public function countriesOfContinentWithVisa($param) {
        $continent_id = $param;
        if (is_array($param)) {
            $continent_id = $param['continent_id'];
        }

        $Model = Load::library('Model');

        $sql = "
        SELECT country.*
        FROM reservation_country_tb AS country
        WHERE country.id_continent = '{$continent_id}'
          AND country.is_del = 'no'
          AND EXISTS (
              SELECT 1
              FROM visa_tb AS visa
              WHERE visa.countryCode = country.abbreviation
                AND visa.isActive = 'yes'
                AND visa.isDell = 'no'
                AND visa.validate = 'granted'
          )
    ";

        $result_countries = $Model->select($sql);

        if (!empty($param['is_json'])) {
            return functions::withSuccess($result_countries, 200, 'data fetched successfully');
        }

        return $result_countries;
    }


}