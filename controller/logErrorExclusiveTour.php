<?php


class logErrorExclusiveTour extends clientAuth{

    public function __construct(){
        parent::__construct();
    }


    public function insertLogErrorExclusiveTour ($data_log) {

        return $this->getModel('logErrorExclusiveTourModel')->insertLocal($data_log);
    }

    public function getErrorMessage($request_number,$client_id){
        $result_error =  $this->getModel('logErrorExclusiveTourModel')->get()->where('request_number',$request_number)->where('client_id',$client_id)->where('message','','<>')->find();

        $result_error['text_message'] = (TYPE_ADMIN=='1') ? functions::persianMessageFlightError($result_error['messageCode']).'---'.$result_error['message'] : $result_error['message'];

        return $result_error ;
    }

}