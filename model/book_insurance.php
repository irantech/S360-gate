<?php

class book_insurance_tb extends Model {

    protected $table = 'book_insurance_tb';
    protected $pk = 'id';

    public function get($id) {
        $result = parent::load("SELECT * FROM $this->table  WHERE $this->pk='$id'  OR factor_number='$id'");
        return $result;
    }

    public function BookInfo($num) {
        $result = parent::load("SELECT * FROM $this->table WHERE factor_number='$num'");
        return $result;
    }

    public function getAllWithFactorNumber($num) {

        if (TYPE_ADMIN == '1') {
            Load::autoload('ModelBase');
            $ModelBase = new ModelBase();
            $result = $ModelBase->select("SELECT * FROM report_insurance_tb WHERE factor_number='$num'");
        } else {
            $result = parent::select("SELECT * FROM $this->table WHERE factor_number='$num'");
        }

        return $result;
    }

}
