<?php

class checkLimitPrice extends clientAuth
{
    public function __construct() {
        parent::__construct();
    }


    public function getClients() {
        return $this->getController('partner')->allClients();
    }

    public function flightRouteInternal() {
        return $this->getController('routeFlight')->flightRouteInternal();
    }

    public function addOrUpdateCheckLimitPrice($params) {
        
        if($params['client_id']=='all'){
            $condition =" origin ='{$params['origin']}' AND destination ='{$params['destination']}'";
            $condition_return =" origin ='{$params['destination']}' AND destination ='{$params['origin']}'";
             $this->getModel('checkLimitPriceModel')->delete($condition);
            $this->getModel('checkLimitPriceModel')->delete($condition_return);


            $clients = $this->getClients();
            $values = [] ;
            foreach ($clients as $client){

                $values [] = "('" . $client['id'] . "','" . $params['origin'] . "','" . $params['destination'] . "','" . $params['price'] . "' )";
            }


            $values_query = implode(', ', $values);

             $query = "INSERT INTO {$this->getModel('checkLimitPriceModel')->getTable()} (client_id,origin,destination,price) VALUES {$values_query}";

            $this->getModel('checkLimitPriceModel')->execQuery($query);

            $values_return=[] ;
            foreach ($clients as $client){

                $values_return [] = "('" . $client['id'] . "','" . $params['destination'] . "','" . $params['origin'] . "','" . $params['price'] . "' )";
            }


            $values_query_return = implode(', ', $values_return);

            $query_return = "INSERT INTO {$this->getModel('checkLimitPriceModel')->getTable()} (client_id,origin,destination,price) VALUES {$values_query_return}";

            $result_insert = $this->getModel('checkLimitPriceModel')->execQuery($query_return);
        }else{
            $condition = " client_id='{$params['client_id']}' AND origin ='{$params['origin']}' AND destination ='{$params['destination']}'";
            $condition_return = " client_id='{$params['client_id']}' AND origin ='{$params['destination']}' AND destination ='{$params['origin']}'";
            $this->getModel('checkLimitPriceModel')->delete($condition);
            $this->getModel('checkLimitPriceModel')->delete($condition_return);

             $this->getModel('checkLimitPriceModel')->insertLocal($params);
            $data_return_params ['client_id'] = $params['client_id'];
            $data_return_params ['origin'] = $params['destination'];
            $data_return_params ['destination'] = $params['origin'];
            $data_return_params ['price'] = $params['price'];
            $result_insert = $this->getModel('checkLimitPriceModel')->insertLocal($data_return_params);
        }

        if($result_insert){
            return functions::withSuccess($params,200,'محدودیت با موفقیت ثبت شد');
        }
        return functions::withSuccess([],400,'خطا در ثبت محدودیت');
    }


    public function getCheckLimits($params) {
        return  $this->getModel('checkLimitPriceModel')->get()->where('origin',$params['origin'])->where('destination',$params['destination'])->find();

    }

    public function listCheckLimitPrice() {

        $clients = $this->getClients();
        $cities = $this->flightRouteInternal();
        $array_clients = [];
        foreach ($clients as $client) {
            $array_clients[$client['id']] = $client ;
        }
        $array_cities = [];
        foreach ($cities as $city) {
            $array_cities[$city['Departure_Code']] = $city ;
        }
        


        $final_array_limits = [];
        $limits =  $this->getModel('checkLimitPriceModel')->get()->orderby('id')->limit(0,300)->all();
        foreach ($limits as $item) {
            $final_array_limits[]= [
                'client_name' => $array_clients[$item['client_id']]['AgencyName'],
                'origin' => $array_cities[$item['origin']]['Departure_City'],
                'destination' => $array_cities[$item['destination']]['Departure_City'],
                'price' => number_format($item['price']).' ریال',
            ];
        }


        return $final_array_limits;
    }




}