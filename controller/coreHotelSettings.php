<?php

class coreHotelSettings extends ApiHotelCore
{
    public $inputs;

    public function __construct()
    {
        parent::__construct();
        $inputs = file_get_contents('php://input');
        if (!$this->_checkJson($inputs)) {
            return functions::withError(['Invalid Request Type', $_SERVER['REQUEST_METHOD'], 'Invalid Request'], 400, 'jsonParseError');
        }

        //just used key to be used in connection between GDS and Core
        $this->header[] =  'X-GDS-Key:'.file_get_contents(CONFIG_DIR.'uuid.txt');
        $this->inputs = $inputs;
//            json_decode($inputs, true);
    }

    protected function _checkJson($inputData)
    {
        if (in_array($_SERVER['REQUEST_METHOD'], ['POST', 'PATCH', 'PUT'])) {
            return json_decode($inputData) != null;
        }
        return true;
    }

    public function getAllHotelLocal()
    {
        $url = "{$this->urlApi}getAllHotelLocal";
//        return functions::toJson([$url,$this->inputs,$this->header]);
        $result = functions::curlExecution($url,$this->inputs,$this->header);
        if($result['Result']['data']){
            return functions::toJson($result['Result']);
        }
        return functions::withError($result['Result'],400);
    }

    public function getDomesticCities()
    {
        $url = "{$this->urlApi}getDomesticCities";
        $result = functions::curlExecution_Get($url, []);
        return $result['Result'];
    }

    public function getHotelTypes()
    {
        $url = "{$this->urlApi}HotelTypes";
        $result = functions::curlExecution_Get($url, []);
        return $result['Result'];
    }

    public function updateSingleHotelLocal()
    {
        $url = "{$this->urlApi}updateSingleHotelLocal";
        $result = functions::curlExecution($url, $this->inputs, $this->header);
        return functions::toJson($result);
    }
}