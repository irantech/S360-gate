<?php


ini_set('soap.wsdl_cache_enabled',0);
ini_set('soap.wsdl_cache_ttl',0);
class testtrainapi
{
    private $urlSoap;
    private $userName;
    private $password;
    private $params;


    public function __construct()
    {
        $this->urlSoap = "https://webservices.raja.ir/online2services.asmx?wsdl";
        $this->userName = '11';
        $this->password = '97111';
        $this->params = array('location' => $this->urlSoap);

    }


    public function wbsLogin()
    {
        echo 'frist wbslogin '. date("d-m-Y h:i:s");
        try {
            $client = new SoapClient($this->urlSoap, $this->params);

            $checkVatParameters = array(
                'username' => $this->userName,
                'password' => $this->password,
            );

            $result = $client->wbsLogin($checkVatParameters);
            $result = json_decode(json_encode($result), True);
            echo 'end frist wbslogin '. date("d-m-Y h:i:s");
            return $result['wbsLoginResult'];
        } catch (Exception $e) {
            echo '<pre>' . print_r($e, true) . '</pre>';
        }

    }

    public function Login($serviceSessionId)
    {
        echo 'second login '. date("d-m-Y h:i:s");
        try {

            $client = new SoapClient($this->urlSoap,$this->params);

            $checkVatParameters = array(
                'Username' => '11',
                'Password' => '2002',
                'uptodate'=>TRUE,
                'serviceSessionId' => $serviceSessionId
            );
            $result = $client->Login($checkVatParameters);
            $result = json_decode(json_encode($result),True);
            foreach ($result AS $res) {
                $x = simplexml_load_string($res['any']);
                $x = json_decode(json_encode($x), True);
                echo 'end second login '. date("d-m-Y h:i:s");
                return $x;
            }
        } catch (Exception $e) {
            // echo '<pre>' . print_r($e->getMessage(), true) . '</pre>';
            echo '<pre>' . print_r($e, true) . '</pre>';
        }
    }

}
$rajaApi = new testtrainapi();
$wbsLoginString = $rajaApi->wbsLogin() ;
echo '**********'.$wbsLoginString.'**********<br/><br/>';
$data  = $rajaApi->Login($wbsLoginString);
print_r($data);
?>