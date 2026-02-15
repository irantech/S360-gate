<?php

class cipModel extends Model {
    protected $table = 'book_cip_tb';
    protected $pk = 'id';

    public function getOneByReq($req)
    {
        return parent::select("select * from $this->table where request_number='$req' LIMIT 1");
    }

    public function updateToCredit($factorNumber) {
        $data = array(
            'successfull' => 'credit'
        );
        $condition = " factor_number = '" . $factorNumber . "'  AND (successfull <> 'book') ";

        $ModelBase = Load::library('ModelBase');
        $ModelBase->setTable('report_cip_tb');
        $ModelBase->update($data,$condition);

        return parent::update($data, $condition);
    }
}