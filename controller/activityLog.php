<?php

class activityLog extends clientAuth {

    public $model;
    public function __construct() {
        parent::__construct();
        $this->model = $this->getModel('activityLogModel');
    }

    public function addLogIndexes(array $logs) {

        $result = [];

        foreach ($logs as $key => $log) {

            $result[$key]           = $log;
            $result[$key]['detail']       = $this->getLogMoreData($log['log_name'] , $log);

            $time_date = functions::ConvertToDateJalaliInt($log['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("Y/m/d h:m:s", $time_date);
        }

        return $result;
    }


    public function log($params) {
        if(isset($params['type'])) {

            $log_data = $this->setLogData($params) ;

            $data_insert = [
                'user_id'          =>  Session::getUserId() ,
                'log_name'         =>  $log_data['log_name'],
                'description'      =>  $log_data['description'],
                'subject_type'     =>  $log_data['table'],
                'subject_id'       =>  $log_data['id'],
                'properties'       =>  json_encode($log_data['properties']),
            ];

            $result = $this->model->insertWithBind($data_insert);
            if($result) { 
                return true ;
            }else{
                return false ;
            }
        }
        return false ;

    }

    public function setLogData($params) {
        $result = $this->findLogs($params);
        if (  isset($result['log_name']) && $result['log_name']  ) {
            $result['description'] = $this->setLogDescription($result);
        }

        return $result;
    }

    public function findLogs($params) {
        $switch = $params['type'] ;
        switch ($switch) {
            case 'market_place_reservation_hotel':
                $result['table'] = 'reservation_hotel_tb';
                $result['id']    = $params['id'];
                $result['log_name']  = 'market_place_reservation_hotel';
                $result['properties'] = [
                    'param1'  => $params['change_type'],
                    'param2'  => $params['room'],
                    'param3'  => $params['dates'],
                    'param4'  => $params['old'],
                    'param5'  => $params['new'],
                    'change_type'  => $params['change_type_en'],
                    'old'     => $params['old'],
                    'new'     => $params['new'],
                ];
                $result['description'] = '__param1__ __param2__ را برای تاریخ __param3__ از __param4__ به __param5__ تغییر داد.' ;
                break;
        }
        return $result;
    }

    public function setLogDescription(array $result) {
        foreach ($result['properties'] as $key => $property){

            $result['description'] = str_replace('__'.$key.'__', $property , $result['description']);

        }
        return $result['description'] ;
    }

    public function getLogData($params) {


        $subject =  $this->findSubject($params['type']);
        $result = $this->model->get(['*' , 'members_tb.user_name'])
            ->join('members_tb' ,'id' , 'user_id');

        $result = $result->where('log_name' , $params['type'])
            ->where('subject_type' , $subject)
            ->where('subject_id' , $params['id']);
        if(isset($params['log_id']) && $params['log_id']){
            $result = $result->where('activity_log_tb.id' , $params['log_id']);
        }
        if(isset($params['status']) && $params['status']){
            $result = $result->openParentheses()->like('properties', $params['status'])->closeParentheses();
        }
        if(isset($params['startDate']) && $params['startDate']){
            $start_date = functions::convertToMiladi($params['startDate']) ;

            $result = $result->where('created_at' , $start_date, '>=');
        }
        if(isset($params['endDate']) && $params['endDate']){
            $end_date = functions::convertToMiladi($params['endDate']) ;
            $result = $result->where('created_at' , $end_date, '<=');
        }
        $result = $result->all();
        $result = $this->addLogIndexes($result);
        return functions::toJson($result);
    }


    public function getLogMoreData($type , $data) {

        switch ($type) {
            case 'market_place_reservation_hotel':

                $property = json_decode($data['properties'] , true) ;

                $result['tiny_text'] = $data['user_name'] . ' ' . $property['param1'] .' '. $property['param2'] . 'را تغییر داد.' ;

                $result['type']      = $property['change_type'] ;

                break;
        }
        return $result;
    }
    public function findSubject($type ) {

        switch ($type) {
            case 'market_place_reservation_hotel':
                return 'reservation_hotel_tb';
        }
    }
}