<?php


class reportFlight extends clientAuth {

    public function __construct(){
        parent::__construct();
    }

    public function countBuySpecificClient($client_id){
        return $this->getModel('reportModel')->get(['count(DISTINCT request_number) AS count_buy_client'],true)->where('client_id',$client_id)->openParentheses()->where('successfull','book')->orWhere('successfull','private_reserve')->closeParentheses()->find();
    }
}