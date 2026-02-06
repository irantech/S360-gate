<?php


class trainRouteModel extends ModelBase
{
    protected $table = 'train_route_tb';
    protected $pk = 'id';

    public function getTrainRoutes()
    {
        $sql ="SELECT Code,Name,EnglishName,TelCode FROM {$this->table} GROUP BY Code ORDER BY Code ASC ";
        return parent::select($sql);
    }

}