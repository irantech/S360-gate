<?php


class continentCodes extends clientAuth {

    public function __construct() {
        parent::__construct();
    }

    public function getListContinents() {
        return $this->getModel('continentCodesModel')->get()->all();
    }

    public function getContinent($id) {
            return $this->getModel('continentCodesModel')->get()->where('id',$id)->find();
    }

    public function getListContinentsWithVisa() {
        $Model = Load::library('Model');

        $sql = "
        SELECT country.id_continent
        FROM reservation_country_tb AS country
        WHERE country.is_del = 'no'
          AND EXISTS (
              SELECT 1
              FROM visa_tb AS visa
              WHERE visa.countryCode = country.abbreviation
                AND visa.isActive = 'yes'
                AND visa.isDell = 'no'
                AND visa.validate = 'granted'
          )
        GROUP BY country.id_continent
    ";

        $continents_with_visa = $Model->select($sql);

        $ids = array_column($continents_with_visa, 'id_continent');

        return $this->getModel('continentCodesModel')->get()->whereIn('id', $ids)->all();
    }



}