<?php
/**
 * Class apiGashtTransfer
 * @property apiGashtTransfer $apiGashtTransfer
 */
class apiGashtTransfer extends clientAuth
{

    #region variable
    protected $address = 'api.zamangasht.com/api/service/';
    protected $userName = 'abazar_afshar';
    protected $passwod = '28654000';
    private $publicKey = '<RSAKeyValue><Modulus>uAjEdG7E+85wvONZ9SvX3C+o6QOCdPJcjt3oMLaSGIGMb2484/Sm1rChtebtzuURbe/CveRY1mWgJiIqzcQAMuBqVBD/zwqSnpkpQPFPIGnNWb4e6P4JEGog+9QSbuo4Byv17P41SSyYkcRcpALQZUyXfsgqZb9gPvVUynVk3Uk=</Modulus><Exponent>AQAB</Exponent></RSAKeyValue>';
    protected $encryptedData;
    public $data;

    #endregion

    #region __construct()
    public function __construct()
    {
        parent::__construct();

    }
    #endregion

    #region curlExecutionPost
    /**
     * This function execute post curl with a url & array of data
     * @param $url string
     * @param $data an associative array of elements
     * @return jason decoded output
     * @author Naime Barati
     */
    public function curlExecutionPost($url, $data)
    {

        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array(
            'foaep: false',
            'Content-Type: application/json'
        ));
        $result = curl_exec($handle);
        return json_decode($result, true);

    }
    #endregion

    #region curlExecutionGet
    /**
     * This function execute get curl with a url
     * @param $url string
     * @return jason decoded output
     * @author Naime Barati
     */
    public function curlExecutionGet($url)
    {

        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('foaep: false'));
        $result = curl_exec($handle);
        return json_decode($result, true);

    }
    #endregion

    #region setRequestType
    /**
     * @param int $type : 0 => gasht OR 1 => transfer
     */

    #endregion
    #region access
    public function AccessApiGasht()
    {
        $result = parent::gashtAndTransferAuth();
        return $result;
    }
    #endregion
    #region encryptingData
    public function encryptingData()
    {
        require_once(LIBRARY_DIR . "bank/pasargad/parser.php");
        require_once(LIBRARY_DIR . "bank/pasargad/RSAProcessor.class.php");


        $processor = new RSAProcessor($this->publicKey, RSAKeyType::XMLString);
        $data = '#' . $this->userName . '#' . $this->passwod . '#' . gmdate("Y/m/d H:i:s");

        $result = $processor->encrypt($data);


//       echo  $result=base64_decode($result);


        $this->encryptedData = $result;

    }
    #endregion

    #region getApiCodeByIata
    public function getApiCodeByIata($cityCode)
    {
        $ModelBase = Load::library('ModelBase');
        $sql = "SELECT api_code, city_name FROM gashtotransfer_cities_tb WHERE city_code = '{$cityCode}' AND source_id = '8'";
        return $ModelBase->select($sql);
    }
    #endregion

    #region getCities
    public function getCities()
    {
        $this->data =
            'serviceType=' . REQUEST_TYPE .
            '&' .
            'encryptedData=' . urlencode($this->encryptedData) .
            '&' .
            'userName=' . $this->userName;
        $url = $this->address . 'GetCities' . '?' . $this->data;
        $result = $this->curlExecutionGet($url);
        if ($result['status'] == '-1') {
            return $result['message'];
        }

        return $result['data'];
    }
    #endregion

    #region getServiceList
    public function getServiceList($cityCode)
    {
        $output = array();
        $apiCityCode = $this->getApiCodeByIata($cityCode);
        foreach ($apiCityCode as $key => $eachCode) {
            $milady_date = functions::ConvertToMiladi(REQUEST_DATE, '/');
            $this->data =
                'serviceType=' . REQUEST_TYPE .
                '&' .
                'encryptedData=' . urlencode($this->encryptedData) .
                '&' .
                'userName=' . $this->userName .
                '&' .
                'cityId=' . $eachCode['api_code'] .
                '&' .
                'ServiceRequestDate=' . $milady_date;

            $result = $this->curlExecutionGet($this->address . 'GetServiceList' . '?' . $this->data);
            if ($result['status'] == '1') {

                $output[$key]['data'] = $result['data'];
                $output[$key]['city_name'] = $eachCode['city_name'];
                $output[$key]['city_code'] = $eachCode['api_code'];
            }
        }

        if (!empty($output)) {
            return $output;
        }

        return $result['message'];
    }
    #endregion

    #region getServiceListByFilter
    public function getServiceListByFilter($cityCode, $filters)
    {

        functions::insertLog('getServiceListByFilter :  city code => ' . $cityCode . ' filters => ' . json_encode($filters), 'apiGashtTransfer');

        $output = array();
        $apiCityCode = $this->getApiCodeByIata($cityCode);

        foreach ($apiCityCode as $key => $eachCode) {

            $milady_date = functions::ConvertToMiladi(REQUEST_DATE, '/');

            $this->data =
                'serviceType=' . REQUEST_TYPE .
                '&' .
                'encryptedData=' . urlencode($this->encryptedData) .
                '&' .
                'userName=' . $this->userName .
                '&' .
                'cityId=' . $eachCode['api_code'] .
                '&' .
                'ServiceRequestDate=' . $milady_date .
                '&' .
                'WelcomeType=' . (($filters['WelcomeType'] != '0') ? ($filters['WelcomeType']) : '') .
                '&' .
                'VehicleType=' . (($filters['VehicleType'] != '0') ? $filters['VehicleType'] : '') .
                '&' .
                'TransferPlace=' . (($filters['TransferPlace'] != '0') ? $filters['TransferPlace'] : '') .
                '&' .
                'GroupType=' . (!empty($filters['GroupType']) ? $filters['GroupType'] : '');

            $url = $this->address . 'GetServiceList_ByFilter' . '?' . $this->data;

            functions::insertLog("request url => " . $url, 'apiGashtTransfer');


            $result = $this->curlExecutionGet($url);

            functions::insertLog("response data => " . json_encode($result), 'apiGashtTransfer');


            if ($result['status'] == '1') {

                $output[$key]['data'] = $result['data'];
                $output[$key]['city_name'] = $eachCode['city_name'];
                $output[$key]['city_code'] = $eachCode['api_code'];
                $output[$key]['encrypt_code'] = $this->encryptedData;
            }
        }

//        $flat = call_user_func_array('array_merge', $output);
        if (!empty($output)) {
            return $output;
        }

        return $result['message'];
    }
    #endregion

    #region submitServiceOrder
    public function submitServiceOrder($serviceUserInfo, $encryptData)
    {
        $data = array(
            'serviceUserInfo' => $serviceUserInfo,
            'encryptedData' => $encryptData,
            'userName' => $this->userName);
        $this->data = json_encode($data);

        $url = $this->address . 'SubmitServiceOrder';
        $result = $this->curlExecutionPost($url, $this->data);

        if ($result['status'] == '-1') {
            return $result['message'];
        }

        return $result;
    }
    #endregion

    #region getServiceInfo
    public function getServiceInfo($serviceOrderCode)
    {
        $this->data =
            'encryptedData=' . $this->encryptedData .
            '&' .
            'userName=' . $this->userName .
            '&' .
            'serviceOrderCode=' . $serviceOrderCode;
        $result = $this->curlExecutionGet($this->address . 'GetServiceInfo' . '?' . $this->data);

        if ($result['status'] == '-1') {
            return $result['message'];
        }

        return $result['data'];
    }
    #endregion

    #region getServicePriceList
    public function getServicePriceList()
    {
        $serviceIdList = Load::library('ServiceIdList');
        $serviceIdList->setEncryptedData($this->encryptedData);
        $serviceIdList->setUserName($this->userName);
        $serviceIdList->setServiceRequestDate(date('Y/m/d'));

        $this->data =
            'encryptedData=' . $this->encryptedData .
            '&' .
            'userName=' . $this->userName .
            '&' .
            'serviceIdList=' . $serviceIdList;
        $result = $this->curlExecutionGet($this->address . 'GetServicePriceList' . '?' . $this->data);

        if ($result['status'] == '-1') {
            return $result['message'];
        }

        return $result['data'];
    }
    #endregion

    #region CheckedLogin
    public function CheckedLogin()
    {
        $result = Session::IsLogin();
        $result2 = Session::getTypeUser();
        if ($result && $result2 == 'counter') {
            return 'successLoginGasht';
        }

        return 'errorLoginGasht';
    }
    #endregion

}