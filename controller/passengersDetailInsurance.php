<?php

class passengersDetailInsurance extends insurance
{
    public $passengers = array();

    public function SetTimeLimit($PassengerCount) {
        //به ازای هر نفر یک دقیقه و 30 ثانیه اضافه می شود
        $time = strtotime('05:00');
        return $new_time = date("H:i", strtotime('+' . (($PassengerCount - 1) * 90) . ' minutes', $time));
    }

    public function getInsuranceInfo($uniqId){

        $Model = Load::library('Model');
		$data="select * from temporary_insurance_tb  WHERE  uniq_id='{$uniqId}'";
        $result = $Model->load($data);

        return $result;

    }

    public function getInsuranceInfoByFactorNumber($factorNumber){

        $Model = Load::library('Model');
        $sql = "select * from book_insurance_tb  WHERE  factor_number = '{$factorNumber}'";
        return $Model->select($sql);

    }

    public function getInsuranceInfoByPnr($pnr){
     
        $Model = Load::library('Model');
        $sql = "select * from book_insurance_tb  WHERE  pnr = '{$pnr}'";
        return $Model->select($sql);
    }
    public function getCustomers() {

        $userId = Session::getUserId();
        $passengers = Load::model('passengers');
        $this->passengers = $passengers->getAll($userId);

    }

}