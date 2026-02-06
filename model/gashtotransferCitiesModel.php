<?php


class gashtotransferCitiesModel extends  ModelBase
{
    protected $table='gashtotransfer_cities_tb';
    protected $pk = 'id';


    public function getCitiesGasht()
    {
        $sql = "SELECT * FROM {$this->table}  ORDER BY city_name";

        return parent::select($sql);
    }
}