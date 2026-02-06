<?php

class weatherService implements weatherInterface {

   private $url ;
   public function __construct() {
        $this->url = tunnel_url ;
   }

    public function getWeatherData($city) {
        $data['safar360_url'] = 'https://api.codebazan.ir/weather/?city='.$city.'';
        $data = json_encode($data) ;
        return functions::curlExecution($this->url,$data);

    }
}