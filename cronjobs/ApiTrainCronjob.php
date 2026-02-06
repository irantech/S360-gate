<?php
echo 'ss'; die();
ini_set('soap.wsdl_cache_enabled',0);
ini_set('soap.wsdl_cache_ttl',0);
class ApiTrainCronjob
{
    private $urlSoap;
    private $userName;
    private $password;
    private $params;

    public function __construct()
    {
        $this->urlSoap = "https://webservices.raja.ir/online2services.asmx?wsdl";
        $this->userName = '11';
        $this->password = '9711';
        $this->params = array('location' => $this->urlSoap);

    }


    public function wbsLogin()
    {
        try {

            $client = new SoapClient($this->urlSoap,$this->params);

            $checkVatParameters = array(
                'username' => $this->userName,
                'password' => $this->password,
            );

            $result = $client->wbsLogin($checkVatParameters);
            $result = json_decode(json_encode($result), True);
            return $result['wbsLoginResult'];
        } catch (Exception $e) {
            // echo '<pre>' . print_r($e->getMessage(), true) . '</pre>';
            echo '<pre>' . print_r($e, true) . '</pre>';
        }
    }

    public function ListStation($serviceSessionId)
    {
        try {

            $client = new SoapClient($this->urlSoap,$this->params);

            $checkVatParameters = array(
                'serviceSessionId' => $serviceSessionId
            );

            $result = $client->ListStation($checkVatParameters);

            $result = json_decode(json_encode($result), True);
            $ModelBase = Load::library('ModelBase');
            $ModelBase->setTable('train_route_tb');
            $sql = " SELECT Code FROM train_route_tb";/*WHERE $Condition*/
            $codes = $ModelBase->select($sql);
            $codez=array();
            foreach ($codes AS $code) {
                $codez[] =$code['Code'];
            }
            foreach ($result AS $res){
                $x =  simplexml_load_string($res['any']);
                $x = json_decode(json_encode($x), True);
                foreach ($x['NewDataSet']['Table'] As $data){
                    if(empty($data['TelCode'])){
                        $data['TelCode']='';
                    }
                        if (!in_array($data['Code'], $codez)) {
                            $resa = $ModelBase->insertLocal($data);
                        }
                }
            }
        } catch (Exception $e) {
            // echo '<pre>' . print_r($e->getMessage(), true) . '</pre>';
            echo '<pre>' . print_r($e, true) . '</pre>';
        }
    }
}

$rajaApi = new ApiTrainCronjob();
$rajaApi->ListStation($rajaApi->wbsLogin());

