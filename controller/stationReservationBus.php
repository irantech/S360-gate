<?php


class stationReservationBus extends clientAuth
{
    public function __construct(){
        parent::__construct();
    }

    public function getData($city_id=null)
    {
        $data=$this->getModel('stationReservationBusModel')->get();
        if($city_id){
            return $data->where('city_id',$city_id)->all();
        }
        return $data->all();
    }

    public function store($params){
        $dataInsert = [
            'city_id' => $params['city_id'],
            'station_name' => $params['name'],
            'created_at' => date('Y-m-d H:i:s')
        ];
        return $this->getModel('stationReservationBusModel')
            ->insertWithBind($dataInsert);
    }
    public function update($params){
        $dataInsert = [
            'station_name' => $params['name'],
        ];
        return $this->getModel('stationReservationBusModel')
            ->updateWithBind($dataInsert,'id = "'.$params['id'].'"');
    }
    public function remove($params){
        return $this->getModel('stationReservationBusModel')
            ->delete('id = "'.$params['id'].'"');
    }
}