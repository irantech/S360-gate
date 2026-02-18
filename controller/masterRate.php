<?php

class masterRate extends clientAuth
{
    public function __construct() {
        parent::__construct();
    }

    public function getRateAverage($section,$item_id) {

        $rate=  $this->getModel('masterRateModel');
        $rates=$rate->get()
            ->where('section',$section)
            ->where('item_id',$item_id)
            ->all();

        $rate_sum=0;
        foreach ($rates as $rate) {
            $rate_sum+=$rate['value'];
        }
        $count=count($rates);
        $average=$rate_sum?round($rate_sum/$count):0;
        return [
            'count'=>$count,
            'average'=>$average,
        ];
    }
    public function newRate($params) {
        $rate=  $this->getModel('masterRateModel');


        $cookies=json_decode($_COOKIE['rate_data'],true);
        if(!$cookies){
            $cookies=[];
        }
 

        foreach ($cookies as $cookie){
            if($cookie['section'] == $params['section'] && $cookie['item_id']==$params['item_id']){
                return
                    functions::JsonError(false, [
                        'title' => functions::Xmlinformation('ThanksForRate')->__toString(),
                        'message' => functions::Xmlinformation('DuplicateRate')->__toString(),
                        'data' => false
                    ], 200);
            }
        }

        $new_cookie=[
            'section'=>$params['section'],
            'item_id'=>$params['item_id'],
        ];
        $cookies[] = $new_cookie;

        setcookie('rate_data',json_encode($cookies,256));

        $create=$rate->insertWithBind([
            'section'=>$params['section'],
            'item_id'=>$params['item_id'],
            'value'=>$params['value'],
        ]);
        if($create){
            return functions::JsonSuccess($create, [
                'title' => functions::Xmlinformation('ThanksForRate')->__toString(),
                'message' => functions::Xmlinformation('RateSubmited')->__toString(),
                'data' => $create
            ], 200);
        }
        return functions::JsonError($create, [
            'title' => functions::Xmlinformation('ThanksForRate')->__toString(),
            'message' => functions::Xmlinformation('ProblemInSubmitRate')->__toString(),
            'data' => $create
        ], 200);
    }

}