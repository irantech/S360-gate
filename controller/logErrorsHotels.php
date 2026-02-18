<?php


class logErrorsHotels extends clientAuth{

    public function __construct(){
        parent::__construct();
    }


    public function insertLogErrorHotels($data_log){

        return $this->getModel('logErrorHotelModel')->insertLocal($data_log);
    }

    public function getErrorMessage($request_number , $factor_number,$client_id){


        $result_error =  $this->getModel('logErrorHotelModel')->get()->where('request_number',$request_number)->where('factor_number' , $factor_number)->where('clientId',$client_id)->find();
        if($result_error) {
        $result_error['text_message'] = (TYPE_ADMIN=='1') ? $result_error['messageFa'].'---'.$result_error['message'] : $result_error['message'];
        }
        return $result_error ;
    }

}