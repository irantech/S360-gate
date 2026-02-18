<?php

class infoPaymentCharter724Model extends ModelBase
{
    protected $table='info_payment_charter724_tb';

    public function insertData($params) {
        $this->insertLocal($params);
    }

    public function getDataByFactorNumber($factor_number) {
        return $this->get()->where('factor_number',$factor_number)->find();
    }

}