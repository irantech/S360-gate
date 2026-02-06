<?php

class reportAgenciesSearch extends clientAuth
{
    public static $admin;
    public $agencyLimits;
    public $apiAddress;
    public $internal_search_limit = 0 ;
    public $international_search_limit = 0;


    public function __construct() {
        self::$admin =  Load::controller('admin');
        $this->apiAddress = functions::UrlSource();

    }

    public function limitExceedAgencies()
    {
        $dataSend['Method'] = 'limitExceedAgencies' ;
        $data = json_encode($dataSend);
        $url = $this->apiAddress."baseFile/searchReport/";
        $resultArray = functions::curlExecution($url,$data,'yes');
        $this->agencyLimits = $resultArray;

    }
    public function limitExceedAgency()
    {
        $this->limitExceedAgencies();
        $result = $this->agencyLimits;

        if (!$result) {
            return false;
        }
        $agency_username = $this->getClientUniqeUserName(CLIENT_ID);
        $final_status = null;
        foreach ($result as $r) {
            if (isset($r['agency_name']) && $r['agency_name'] == $agency_username) {
                $final_status = $r;
                break;
            }
        }
        return $final_status;
    }


    public function fillExistLimitations($client_id){

        $agency_username = $this->getClientUniqeUserName($client_id);
        $dataSend['agency_username'] = $agency_username ;
        $dataSend['Method'] = 'ifLimitationExist' ;
        $data = json_encode($dataSend);
        $url = $this->apiAddress."baseFile/searchReport/";

        $resultArray = functions::curlExecution($url,$data,'yes');

        if($resultArray){
            $this->internal_search_limit = $resultArray['internal_search_limit'];
            $this->international_search_limit = $resultArray['international_search_limit'];
        }

    }

    public function getAllAgenciesSearch(){
        $params = $_POST;
        if(!empty($params)){
            $dataSend['date_of'] = $params['date_of'];
            $dataSend['to_date'] = $params['to_date'];
            $dataSend['agency_name'] = $params['agency_name'];
        }

        $dataSend['Method'] = 'listAgenciesSearch' ;
        $data = json_encode($dataSend);
        $url = $this->apiAddress."baseFile/searchReport/";
        $listAgenciesSearchArray = functions::curlExecution($url,$data,'yes');


        return array_reverse($listAgenciesSearchArray);
    }

    public function getAllAgencyTimeSearch($agency_id){
        $params = $_POST;
        if(!empty($params)){
            $dataSend['date_of'] = $params['date_of'];
            $dataSend['to_date'] = $params['to_date'];
        }
        if($agency_id){
            $dataSend['agency_id'] = $agency_id;
        }else{
            return false;
        }

        $dataSend['Method'] = 'listAgencyTimeSearch' ;
        $data = json_encode($dataSend);
        $url = $this->apiAddress."baseFile/searchReport/";
        $resultArray = functions::curlExecution($url,$data,'yes');
        $finallArray = [];
        foreach ($resultArray as $index => $result){
            $resultArray[$index]['search_date'] = functions::ConvertToJalali($result['search_date']);
            $finallArray[$index] = $resultArray[$index];
        }


        return array_reverse($finallArray);
    }
    public function airportsTb(){

        $Model = $this->getModel('airportModel');

        $cityArray = $Model->get(['id','DepartureCode','DepartureCityFa'])->whereNotIn('DepartureCode','')->all();


        return array_reverse($cityArray);
    }

    public function getAllAgencyDetailSearch($agency_id){

        $params = $_POST;
        if(!empty($params)){
            $dataSend['date_of'] = $params['date_of'];
            $dataSend['to_date'] = $params['to_date'];
            $dataSend['origin'] = $params['origin'];
            $dataSend['destination'] = $params['destination'];
            $dataSend['is_internal'] = $params['is_internal'];
        }

        if($agency_id){
            $dataSend['agency_id'] = $agency_id;
        }else{
            return false;
        }

        $dataSend['Method'] = 'listAgencyDetailSearch' ;
        $data = json_encode($dataSend);
        $url = $this->apiAddress."baseFile/searchReport/";
        $resultArray = functions::curlExecution($url,$data,'yes');
        $Model = $this->getModel('airportModel');


        $finallArray = [];
        foreach ($resultArray as $index => $result){
            $resultArray[$index]['origin'] = $Model->getAirport($resultArray[$index]['origin'])['DepartureCityFa'];
            $resultArray[$index]['destination'] = $Model->getAirport($resultArray[$index]['destination'])['DepartureCityFa'];
            $finallArray[$index] = $resultArray[$index];
        }


        return array_reverse($finallArray);
    }

    public function addFlightLimitation($params)
    {

        $agency_username = $this->getClientUniqeUserName($params['client_id']);
        if(!empty($params)){
            $dataSend['agency_username'] = $agency_username;
            $dataSend['internal_search_limit'] = $params['internal_search_limit'];
            $dataSend['international_search_limit'] = $params['international_search_limit'];
            $dataSend['id'] = $params['id'];
        }
        $dataSend['Method'] = 'addAgencyLimitationSearch' ;
        $data = json_encode($dataSend);
        $url = $this->apiAddress."baseFile/searchReport/";
        return functions::curlExecution($url,$data,'yes');

    }
    public function removeFlightLimitation($params)
    {
        if(!empty($params)){
            $dataSend['agency_id'] = $params['agency_id'];
        }else{
            return false;
        }
        $dataSend['Method'] = 'removeAgencyLimitationSearch' ;
        $data = json_encode($dataSend);
        $url = $this->apiAddress."baseFile/searchReport/";
        return functions::curlExecution($url,$data,'yes');

    }

    private function getClientUniqeUserName($client_id){
        $Model = $this->getModel('clientAuthModel');
        return $Model->get(['Username'])->where('ClientId',$client_id)->where('ServiceId',1)->all()[0]['Username'];

    }

}