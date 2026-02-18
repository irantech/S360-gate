<?php
/**
 * Class apiBus
 * @property apiBus $apiBus
 */

class apiBus extends clientAuth
{

    /*'http://safar360.com/CoreTestDeveloper/Bus/';*/
        public $requestUrl =  'https://safar360.com/Core/V-1/Bus/';
//        public $requestUrl =  'http://192.168.1.100/CoreTestDeveloper/V-1/Bus/';
//    public $requestUrl='https://safar360.com/CoreTestDeveloper/V-1/Bus/';
    public $ClientName;
    public $accessData;
    public $log=true;
    public $accessBusReservation=false;

    public function __construct()
    {
    
        parent::__construct();
//        if(CLIENT_ID == '166'){
//            $this->requestUrl =  'https://safar360.com/CoreTestDeveloper/V-1/Bus/' ;
//        }
        $this->accessData=$this->accessApiBus();
	 
        $this->accessBusReservation=$this->accessBusReservation();

        $this->admin = Load::controller('admin');
		
    }

    private function curlExecutionPost($url, $data)
    {
        if($this->log){
            functions::insertLog("request url => ".$url, 'apiBuses');
            functions::insertLog("request data => ".$data, 'apiBuses');
        }

        $handle=curl_init($url);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result=curl_exec($handle);

        if($this->log){
            functions::insertLog("response => ".$result, 'apiBuses');
        }
        return json_decode($result, true);
    }

    #region access
    public function accessApiBus()
    {
        $result=parent::busAuth();
        if($result['isAccess']){
            defined('USERNAME_CLIENT') or define('USERNAME_CLIENT', $result['username']);
            return true;
        }

        return false;
    }


    public function accessBusReservation()
    {
        return parent::reservationBusAuth();
    }


    #endregion

    #region busSearch
    public function busSearch($jsonData)
    {
        try{
            $url=$this->requestUrl."BusSearch";

            return $this->curlExecutionPost($url, $jsonData);

        }catch(Exception $e){

            $textError=json_encode($e->getMessage());
            if($this->log){
                functions::insertLog($textError, 'apiCatchBusSearch');
            }


            return $textError;
        }
    }

    #endregion

    #region busSearch
    public function getCities()
    {
        try{
            $url=$this->requestUrl."Cities";
            return $this->curlExecutionPost($url);
        }catch(Exception $e){
            $textError=json_encode($e->getMessage());
            if($this->log){
                functions::insertLog($textError, 'apiCatchBusSearch');
            }
            return $textError;
        }
    }
    #endregion

    public function getBusRouteCities($params)
    {
        return json_encode(functions::searchBusCities($params), true);
    }


    #region busDetail
    public function busDetail($jsonData)
    {


        try{

            $url=$this->requestUrl."BusDetail";

            return $this->curlExecutionPost($url, $jsonData);

        }catch(Exception $e){

            $textError=json_encode($e->getMessage());
            if($this->log){
                functions::insertLog($textError, 'apiCatchBusDetail');
            }

            return $textError;
        }
    }
    #endregion

    #region busPreReserve
    public function busPreReserve($factorNumber, $preReserveRequired)
    {
        try{

            $Model=Load::library('Model');
            $sql=" SELECT * FROM book_bus_tb WHERE passenger_factor_num = '{$factorNumber}' ";
            $resultCheck=$Model->select($sql);

            if(!empty($resultCheck)){

                $preReserveRequired['UserName']=USERNAME_CLIENT;
                $preReserveRequired['factorNumber']=$factorNumber;

                $jsonData=json_encode($preReserveRequired);

                $url=$this->requestUrl."BusPreReserve";


                return $this->curlExecutionPost($url, $jsonData);

            }

            return false;

        }catch(Exception $e){

            $textError=json_encode($e->getMessage());
            if($this->log){
                functions::insertLog($textError, 'apiCatchBusPreReserve');
            }
            return $textError;
        }
    }
    #endregion

    #region busReserve
    public function busReserve($factorNumber)
    {
        try{

            $Model=Load::library('Model');
            $sql=" SELECT * FROM book_bus_tb WHERE passenger_factor_num = '{$factorNumber}' ";
            $resultCheck=$Model->load($sql);

            if(!empty($resultCheck)){
                $requestNumber=$resultCheck['order_code'];
                $sourceCode=$resultCheck['SourceCode'];
                $reserveRequestId=$resultCheck['ClientTraceNumber'];
                $preReserveRequired=[
                    "requestNumber"=>$requestNumber,
                    "sourceCode"=>$sourceCode,
                    "reserveRequestId"=>$reserveRequestId,
                    "UserName"=>USERNAME_CLIENT
                ];


                $jsonData=json_encode($preReserveRequired);
                if($this->log){
                    functions::insertLog('request busReserve =>'.$jsonData, 'apiBusReserve');
                }
                $url=$this->requestUrl."BusReserve";
                $result=$this->curlExecutionPost($url, $jsonData);
                if($this->log){
                    functions::insertLog('response busReserve =>'.json_encode($result), 'apiBusReserve');
                }
                return $result;

            }

            return false;

        }catch(Exception $e){

            $textError=json_encode($e->getMessage());
            if($this->log){
                functions::insertLog($textError, 'apiCatchBusReserve');
            }
            return $textError;
        }
    }
    #endregion

    #region busRefundCheck
    public function busRefundCheck($factorNumber,$ClientId)
    {
        try{

            $Model=Load::library('Model');
            $sql=" SELECT * FROM book_bus_tb WHERE passenger_factor_num = '{$factorNumber}' ";
            $resultCheck=$this->admin->ConectDbClient($sql, $ClientId, "Select", "", "", "");

            if(!empty($resultCheck)){

                $requestNumber=$resultCheck['order_code'];
                $sourceCode=$resultCheck['SourceCode'];
                $reserveRequestId=$resultCheck['ClientTraceNumber'];


                $clientAuth=Load::library('clientAuth');
                $clientUserName = $clientAuth->busAuth($ClientId);

                $preReserveRequired=[
                    "requestNumber"=>$requestNumber,
                    "sourceCode"=>$sourceCode,
                    //                    "reserveRequestId"=>$reserveRequestId,
                    "UserName"=>$clientUserName['username']
                ];



                $jsonData=json_encode($preReserveRequired);

                $url=$this->requestUrl."BusRefundCheck";
          
                return $this->curlExecutionPost($url, $jsonData);

            }

            return false;

        }catch(Exception $e){

            $textError=json_encode($e->getMessage());
            functions::insertLog($textError, 'apiExternalHotel');

            return $textError;
        }
    }
    #endregion

    #region busRefund
    public function busRefund($factorNumber,$ClientId)
    {
        try{

            $Model=Load::library('Model');
            $sql=" SELECT * FROM book_bus_tb WHERE passenger_factor_num = '{$factorNumber}' ";
            $resultCheck=$this->admin->ConectDbClient($sql, $ClientId, "Select", "", "", "");

            if(!empty($resultCheck)){

                $requestNumber=$resultCheck['order_code'];
                $sourceCode=$resultCheck['SourceCode'];
                $reserveRequestId=$resultCheck['ClientTraceNumber'];

                $clientAuth=Load::library('clientAuth');
                $clientUserName = $clientAuth->busAuth($ClientId);


                $preReserveRequired=[
                    "requestNumber"=>$requestNumber,
                    "sourceCode"=>$sourceCode,
                    //"reserveRequestId"=>$reserveRequestId,
                    "UserName"=>$clientUserName['username']
                ];


                $jsonData=json_encode($preReserveRequired);

                $url=$this->requestUrl."BusRefund";
               
                return $this->curlExecutionPost($url, $jsonData);

            }

            return false;

        }catch(Exception $e){

            $textError=json_encode($e->getMessage());
            if($this->log){
                functions::insertLog($textError, 'apiCatchBusRefund');
            }
            return $textError;
        }
    }
    #endregion

    #region inquireBusTicket
    public function inquireBusTicket($sourceCode, $orderCode)
    {
        try{

            $data['UserName']=USERNAME_CLIENT;
            $data['SourceCode']=$sourceCode;
            $data['ID']=$orderCode;
            $jsonData=json_encode($data);
            $url=$this->requestUrl."inquireBusTicket";
            $result=$this->curlExecutionPost($url, $jsonData);

            return $result;

        }catch(Exception $e){

            $textError=json_encode($e->getMessage());
            functions::insertLog($textError, 'apiExternalHotel');

            return $textError;
        }
    }
    #endregion


    #region cancellationBusTicket
    public function cancellationBusTicket($factorNumber)
    {
        try{

            $Model=Load::library('Model');
            $sql=" SELECT order_code, pnr, ClientTraceNumber, member_name, price_api, SourceCode 
                      FROM book_bus_tb 
                      WHERE passenger_factor_num = '{$factorNumber}' ";
            $resultReport=$Model->load($sql);
            if(!empty($resultReport)){

                $dataRequest['UserName']=USERNAME_CLIENT;
                $dataRequest['SourceCode']=$resultReport['SourceCode'];
                $dataRequest['ID']=$resultReport['order_code'];
                $dataRequest['PassengerName']=$resultReport['member_name'];
                $dataRequest['TicketPrice']=$resultReport['price_api'];
                $jsonData=json_encode($dataRequest);
                $url=$this->requestUrl."cancellationBusTicket";
                $result=$this->curlExecutionPost($url, $jsonData);

                return $result;

            }else{
                return false;
            }

        }catch(Exception $e){

            $textError=json_encode($e->getMessage());
            functions::insertLog($textError, 'apiExternalHotel');

            return $textError;
        }
    }
    #endregion

    public function clientBusData()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if($_POST['code']){
                $code = 'code='.$_POST['code'] ?? null;
            }
            if($_POST['date_start']){
                $date_start = 'date_start='.$_POST['date_start'] ?? null;
            }
            if($_POST['date_end']){
                $date_end = 'date_end='.$_POST['date_end'] ?? null;
            }
        }
        $query_param = implode('',[$code, $date_start, $date_end]);
        $url = "https://safar360.com/Core/V-1/Bus/getRequestedCode/$query_param" ; //TODO change this url accordingly
        header('Content-Type: application/json');
        $result = functions::curlExecution($url,[]);
        $final_response = [] ;
        foreach($result as $data){
            $final_response[] = [
                'id'     => $data['id'] ,
                'code'     => $data['requestNumber'] ,
                'businessMethodName'     => $data['businessMethodName'] ,
                'ApiMethodName'     => $data['source_id'] ,
                'response'     => htmlentities($data['response']) ,
                'request'     => htmlentities($data['request']) ,
            ];
        }
        echo json_encode($final_response);
    }

}