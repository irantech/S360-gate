<?php


class baseCompanyBusModel extends ModelBase {
    protected $table = 'base_company_bus_tb' ;
    protected $pk = 'id';

    public function getSpecialCompanyBus($params) {
        return $this->get(['*'])
            ->whereIn('code_company_raja' , $params['list'])
            ->where('type_vehicle' , $params['type'])
            ->where('is_del' , 'no')
            ->groupBy('name_fa')
            ->all();
    }
}