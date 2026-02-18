<?php


class logErrorFlights extends clientAuth{

    public function __construct(){
        parent::__construct();
    }


    public function insertLogErrorFlights($data_log) {

        return $this->getModel('logErrorFlightsModel')->insertLocal($data_log);
    }

    public function getErrorMessage($request_number,$client_id) {
        $result_error =  $this->getModel('logErrorFlightsModel')->get()->where('request_number',$request_number)->where('client_id',$client_id)->find();
//        $result_error['text_message'] = (TYPE_ADMIN=='1') ? functions::persianMessageFlightError($result_error['messageCode']).'---'.$result_error['message'] : $result_error['message_fa'];
        if (TYPE_ADMIN == '1') {
            $result_error['text_message'] = (!empty($result_error['message_admin']))
                ? $result_error['message_admin']
                : 'به این خطای تامین کننده در سفر360 کدی تخصیص داده نشده ، لطفا در بخش لیست ارور های ادمین به تمامی ارور ها پیغام اختصاص دهید';
        } else {
            $result_error['text_message'] = $result_error['message_agency'];
        }


        return $result_error ;
    }

}