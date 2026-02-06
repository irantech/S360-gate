<?php

class refreshFlightLimitRateCronjob extends clientAuth
{
    public static $admin;
    public $apiAddress;



    public function __construct() {
        self::$admin =  Load::controller('admin');
        $this->apiAddress = functions::UrlSource();
        $this->refreshFlightRate();
    }

    private function refreshFlightRate(){
        
        $dataSend['Method'] = 'refreshFlightRateSearch' ;
        $data = json_encode($dataSend);
        $url = $this->apiAddress."baseFile/searchReport/";
        functions::curlExecution($url,$data,'yes');
        functions::insertLog(json_encode('success'),'arashLoglatesttest1');

    }


}

new refreshFlightLimitRateCronjob();