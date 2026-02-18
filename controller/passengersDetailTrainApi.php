<?php

class passengersDetailTrainApi extends resultTrainApi
{
    public $trainId ;
    public $reSearchAddress;
    public $passengers;
    public $services = array();
    public $servicesReturn = array();
    public $requestNumber ;
    public $requestNumberReturn ;


    public function __construct()
    {
//        echo Load::plog($_POST); die();
    }

    public function getTrain(){
        if(isset($_POST['serviceIdBib'])) {
            $this->trainId = $_POST['serviceIdBib'];
            $Model = Load::library('Model');
             $sql = "select * from temporary_train_tb  WHERE  ServiceCode = '{$this->trainId}'";
            $temprory = $Model->select($sql);

//            if ((isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], 'indobare.com') !== false)) {//local
//                echo Load::plog($temprory);
//            }

            $this->services['SCP'] = $temprory[0]['CircularPeriod'];
            $this->services['TrainNo'] = $temprory[0]['TrainNumber'];
            $this->services['Scps'] = $temprory[0]['CircularNumberSerial'];
            $this->services['WagonTypeCode'] = $temprory[0]['WagonType'];
            $this->services['MovDateTimeTrain'] = $temprory[0]['MoveDate'];
//            $this->services[5] = $temprory[0]['ServiceSessionId'];
             $this->requestNumber = $temprory[0]['code'] ;
            if (!empty($temprory[1])) {
                $this->servicesReturn['SCP'] = $temprory[1]['CircularPeriod'];
                $this->servicesReturn['TrainNo'] = $temprory[1]['TrainNumber'];
                $this->servicesReturn['Scps'] = $temprory[1]['CircularNumberSerial'];
                $this->servicesReturn['WagonTypeCode'] = $temprory[1]['WagonType'];
                $this->servicesReturn['MovDateTimeTrain'] = $temprory[1]['MoveDate'];
//                $this->servicesReturn[5] = $temprory[1]['ServiceSessionId'];
                $this->requestNumberReturn =  $temprory[1]['code'];
            }

            return $temprory;
        }
        return false;
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





}
