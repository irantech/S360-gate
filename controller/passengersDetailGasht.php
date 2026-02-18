<?php
/**
 * Class passengersDetailGasht
 * @property passengersDetailGasht $passengersDetailGasht
 */
class passengersDetailGasht
{
    public $gashtId ;
    public $reSearchAddress='' ;
    public function getGasht(){

        if(isset($_POST['serviceIdBib'])){
            $this->gashtId = filter_var($_POST['serviceIdBib'],FILTER_SANITIZE_NUMBER_INT);
            $Model = Load::library('Model');
            $data="select * from temporary_gasht_tb  WHERE  serviceuniqueid='{$this->gashtId}'";
            return $Model->load($data);
//           print_r($Model->load($data));
        }
    }
    public function getGashtTime()
    {
        $option = '';
        for ($hours = 0; $hours < 24; $hours++)
        {
            for ($mins = 0; $mins < 60; $mins += 30)
            {
                $value = str_pad($hours, 2, '0', STR_PAD_LEFT) . ':' . str_pad($mins, 2, '0', STR_PAD_LEFT) . ':00';
                $option .= '<option value="' . $value . '">' . $value . '</option>';
            }
        }
        return $option;
    }
    public function getCustomers() {

        $userId = Session::getUserId();
        $passengers = Load::model('passengers');
        $this->passengers = $passengers->getAll($userId);

    }
    public function SetTimeLimit() {

        $time = strtotime('10:00');
        return $new_time = date("H:i", strtotime('+' . ((1 - 1) * 90) . ' minutes', $time));

    }
    public function getGashtInfoByFactorNumber($factorNumber){

        $Model = Load::library('Model');
        $sql = "select * from book_gasht_local_tb  WHERE  passenger_factor_num = '{$factorNumber}'";
        return $Model->select($sql);

    }
}
