<?php

//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

class webserviceHotel extends clientAuth
{
    public $model ;
    public function __construct() {
        parent::__construct();
        $this->model = $this->getModel('webserviceHotelModel');
    }

    public function setHotel($params) {
        $data_insert = [
            'hotel_id'         => $params['hotel_id'] ,
            'source_code'      => $params['source_code'] ,
        ];
        $check_if_exist = $this->model->get()->where('hotel_id' , $params['hotel_id'])
            ->where('source_code' , $params['source_code'])->find() ;

        if($check_if_exist) {
            $select_status = 1;
            $final_massage = 'از این پس در سایت نمایش داده خواهد شد';
            $result =  $this->model->delete(['hotel_id'=> $params['hotel_id'] , 'source_code' =>  $params['source_code']]) ;
        }else{
            $select_status = 0;
            $final_massage = 'در سایت نمایش داده نخواهد شد';
            $result =  $this->model->insert($data_insert) ;
        }

        if ($result) {
            return functions::JsonSuccess($select_status, [
                'message' => $final_massage,
                'data' => $select_status
            ], 200);
        }
        return functions::JsonError([], [
            'message' => 'خطا در تغییر وضعیت نمایش در سایت',
            'data' => $select_status
        ], 200);
    }

    public function getNotIncludeWebservice($source) {
        $result  = $this->model->get()->where('source_code' , $source)->all() ;
        $hotel_list = [] ;
        foreach ($result as $hotel) {
            $hotel_list[]  = $hotel['hotel_id'] ;
        }
        return $hotel_list ;
    }
}