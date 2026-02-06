<?php

class checkCreditCharter724Model extends ModelBase
{
    protected $table= "check_credit_charter724_tb";

    public function getLastRecordeCreditCharter724() {
        return $this->get()->orderBy('id')->limit(0,1)->find();
    }

    public function insertRecordeCreditCharter724($params) {
        $this->insertLocal($params);
    }

}