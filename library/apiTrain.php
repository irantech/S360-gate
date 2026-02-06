<?php
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

ini_set('soap.wsdl_cache_enabled',0);
ini_set('soap.wsdl_cache_ttl',0);
class apiTrain extends clientAuth
{
    private $urlSoap;
    private $userName;
    private $password;
    private $params;
    public $p1;
    public $p2;
    public $token;
    public  $status;
    public  $client;
    public $infoAgency = array();


    public function __construct()
    {
        $this->urlSoap = "https://webservices.raja.ir/online2services.asmx?wsdl";


        $this->userName = 'RailTour';    // test : 11  real : RailTour
        $this->password = 'R@ilTour98'; //test : 97111 real : R@ilTour98


        $this->params = array('location' => $this->urlSoap);

        try{
            $this->client = new SoapClient($this->urlSoap, $this->params);
        }catch (exception $e)
        {
            if(FOLDER_ADMIN!='itadmin')
            {
                echo 'متاسفانه سرور های قطار رجا قطع می باشد';
            }

        }



    }


    public function wbsLogin()
    {
        functions::insertLog('first login to apiTrain: ', 'log_time_for_train');
            try {
                $ModelBase = Load::library('ModelBase');
                $Model = Load::library('Model');
                $query =  "SELECT token FROM token_train_tb";
                $resultquery = $ModelBase->load($query);
                $checkVatParameters = array(
                    'username' => $this->userName,
                    'password' => $this->password,
                );

                $result = $this->client->wbsLogin($checkVatParameters);

                $result = json_decode(json_encode($result), True);



                functions::insertLog('end frist login to apitrin: ', 'log_time_for_train');
                 $this->token =  $result['wbsLoginResult'];
                $data['token'] = $result['wbsLoginResult'];
                $ModelBase->setTable('token_train_tb');
                if($resultquery['token'] !=''){
                    $condition = "token = '{$resultquery['token']}'";
                    $result = $ModelBase->update($data,$condition);
                }else {
                    $result = $ModelBase->insertLocal($data);
                }
              if($result['wbsLoginResult'] == 'Sequence contains no elements'){
                  $this->status = false;
                  return false;
              }else{
                  $this->status = true;
                  return $result['wbsLoginResult'];
              }
            } catch (Exception $e) {
                //echo '<pre>' . print_r($e, true) . '</pre>';
                preg_match_all('!\d+!', $e->getMessage(), $matches);
                $MessageError = functions::ShowErrorTrain($matches[0][0]);
                if($matches[0][0]==401){
                    $token = self::wbsLogin();
                }

                $data['message'] = $e->getMessage();
                $data['messageFa'] = $MessageError;
                $data['clientId'] = CLIENT_ID;
                $data['messageCode'] = $matches[0][0];
                $data['request_number'] = '';
                $data['desti'] = '';
                $data['origin'] = '';
                $data['train_number'] = '';
                $data['action'] = 'wbsLogin';
                $data['creation_date_int'] = time();
                $Model->setTable('log_train_tb');
                $Model->insertLocal($data);
                $return['result_status'] = 'Error';
                $return['result_message'] = 'در روند رزرو اشکالی پیش آمده است لطفا کمی بعد  جستجو کنید یا با سرویس دهنده  تماس حاصل نمایید';
                return $return;
            }

    }

    public function ListStation()
    {

            try {


                $checkVatParameters = array(
                    'serviceSessionId' => $this->token
                );

                $result = $this->client->ListStation($checkVatParameters);

                $result = json_decode(json_encode($result), True);
                $ModelBase = Load::library('ModelBase');
                $Model = Load::library('Model');
                $ModelBase->setTable('train_route_tb');
                $Model->setTable('train_route_tb');
                foreach ($result AS $res) {
                    $x = simplexml_load_string($res['any']);
                    $x = json_decode(json_encode($x), True);
                    foreach ($x['NewDataSet']['Table'] As $data) {
                        if (empty($data['TelCode'])) {
                            $data['TelCode'] = '';
                        }
                        $resa = $ModelBase->insertLocal($data);
                        $res = $Model->insertLocal($data);
                    }
                }
            } catch (Exception $e) {
                // echo '<pre>' . print_r($e->getMessage(), true) . '</pre>';
                //echo '<pre>' . print_r($e, true) . '</pre>';

            }

    }

    public function Login()
    {
        functions::insertLog('second login to apitrin: ', 'log_time_for_train');
//        if($this->status) {
            $ModelBase = Load::library('ModelBase');
            $Model = Load::library('Model');
            try {
                
                $url =  str_replace('online.','',$_SERVER['HTTP_HOST']);
                $this->infoAgency = functions::infoClientByDomain($url);
                $querytoken = "SELECT * FROM token_train_tb";
                $resulttoken = $ModelBase->load($querytoken);

                $userName = 'railtour';  // test : 11  real : railtour
                $password = '80868086'; //test : 97111 real : 80868086

                $checkVatParameters = array(
                    'Username' => $userName, // test : 11 real : railtour
                    'Password' => $password, // test : 2002 real : 80868086
                    'uptodate' => TRUE,
                    'serviceSessionId' => $resulttoken['token']
                );
                $ModelBase->setTable('user_info_train_tb');
                $result = $this->client->Login($checkVatParameters);
                if ((isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], 'indobare.com') !== false)) {

//                    echo Load::plog($result);
                    echo '<pre>' . print_r($checkVatParameters, true) . '</pre>';
                    echo '<pre>' . print_r($result, true) . '</pre>';
                }
                $result = json_decode(json_encode($result), True);

                $query = "SELECT id FROM user_info_train_tb WHERE id_user='{$this->infoAgency['id']}'";
                $resultquery = $ModelBase->load($query);
                foreach ($result AS $res) {
                    $x = simplexml_load_string($res['any']);
                    $x = json_decode(json_encode($x), True);
                    $data = $x['NewDataSet']['Table1'];
                    $data['id_user'] = $this->infoAgency['id'];
                    if($resultquery['id'] !=''){
                        $condition = " id_user='" . $this->infoAgency['id'] . "'";
                        $resa = $ModelBase->update($data,$condition);
                    }else {
                        $resa = $ModelBase->insertLocal($data);
                    }
                    functions::insertLog('end second login to apitrin: ', 'log_time_for_train');
                    return true;
                }
            } catch (Exception $e) {
                // echo '<pre>' . print_r($e->getMessage(), true) . '</pre>';
                // echo '<pre>' . print_r($e, true) . '</pre>';
                preg_match_all('!\d+!', $e->getMessage(), $matches);
                $MessageError = functions::ShowErrorTrain($matches[0][0]);

                if($matches[0][0]==401){
                    self::wbsLogin();
                    self::Login();
                }


                $data['message'] = $e->getMessage();
                $data['messageFa'] = $MessageError;
                $data['clientId'] = CLIENT_ID;
                $data['messageCode'] = $matches[0][0];
                $data['request_number'] = '';
                $data['desti'] = '';
                $data['origin'] = '';
                $data['train_number'] = '';
                $data['action'] = 'Login';
                $data['creation_date_int'] = time();
                $Model->setTable('log_train_tb');
                $Model->insertLocal($data);
                $return['result_status'] = 'Error';
                $return['result_message'] = 'در روند رزرو اشکالی پیش آمده است لطفا کمی بعد  جستجو کنید یا با سرویس دهنده  تماس حاصل نمایید';
                return $return;
            }
    }

    public function GetWagonAvaliableSeatCount($Dep,$Arr,$Date,$passenger,$serviceSessionId)
    {
        functions::insertLog('get wagon from apitrin: ', 'log_time_for_train');

        if(functions::isTestServer('online.railtour.ir') && $Dep=='1' && $Arr=='162')
        {
            die();
        }

        if (parent::TrainAuth()) {

            try {


                $Model = Load::library('Model');
                $ModelBase = Load::library('ModelBase');
                $url =  str_replace('online.','',$_SERVER['HTTP_HOST']);
                $this->infoAgency = functions::infoClientByDomain($url);
                $sql = " SELECT UserCode,SessionID,IP,SaleCenterCode FROM user_info_train_tb WHERE id_user='{$this->infoAgency['id']}'";/*WHERE $Condition*/
                $sumcheck = $ModelBase->load($sql);
                $checksum = $sumcheck['UserCode'] . ',' . $sumcheck['SessionID'] . ',' . $sumcheck['IP'] . ',' . $sumcheck['SaleCenterCode'];
                $querytoken = "SELECT * FROM token_train_tb";
                $resulttoken = $ModelBase->load($querytoken);

                $test = functions::isTestServer('indobare.com');

                $checkVatParameters = array(
                    'FromStation' => $Dep,
                    'ToStation' => $Arr,
                    'MD' => $Date,
                    'RationCode' => 2,//58 for special train
                    'SexCode' => $passenger,
                    'duration' => 1,
                    'TarifCode' => 1,
                    'TicketType' => 1,
                    'Checksum' => $checksum,
                    'serviceSessionId' => $resulttoken['token']
                );



                $result = $this->client->GetWagonAvaliableSeatCount($checkVatParameters);

                $result = json_decode(json_encode($result), True);
                foreach ($result AS $res) {
                    $x = simplexml_load_string($res['any']);
                    $x = json_decode(functions::clearJsonHiddenCharacters(json_encode($x)), True);
                }
                functions::insertLog('end get wagon from apitrin: ', 'log_time_for_train');
                return $x;
            } catch (Exception $e) {
//                echo '<pre>' . print_r($e->getMessage(), true) . '</pre>';
                if ((isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], 'indobare.com') !== false)) {

//                    echo Load::plog($result);
                    echo '<pre>' . print_r($e->getMessage(), true) . '</pre>';
                }
                preg_match_all('!\d+!', $e->getMessage(), $matches);
                $MessageError = functions::ShowErrorTrain($matches[0][0]);

                if($matches[0][0]==401){
                    self::wbsLogin();
                    self::GetWagonAvaliableSeatCount($Dep,$Arr,$Date,$passenger,$serviceSessionId);
                }

                $data['message'] = $e->getMessage();
                $data['messageFa'] = $MessageError;
                $data['clientId'] = CLIENT_ID;
                $data['messageCode'] = $matches[0][0];
                $data['request_number'] = '';
                $data['desti'] = '';
                $data['origin'] = '';
                $data['train_number'] = '';
                $data['action'] = 'GetWagonAvaliableSeatCount';
                $data['creation_date_int'] = time();
                $Model->setTable('log_train_tb');
                $Model->insertLocal($data);


                $return['result_status'] = 'Error';
                $return['result_message'] = 'در روند رزرو اشکالی پیش آمده است لطفا کمی بعد  جستجو کنید یا با سرویس دهنده  تماس حاصل نمایید';
                return $return;
            }
        }
    }

    public function GetWagonAvailableSeatCountSpecific($Dep,$Arr,$Date,$passenger,$serviceSessionId)
    {
        functions::insertLog('get wagon from apitrin: ', 'log_time_for_train');


        if (parent::TrainAuth()) {
            try {


                $Model = Load::library('Model');
                $ModelBase = Load::library('ModelBase');
                $url =  str_replace('online.','',$_SERVER['HTTP_HOST']);
                $this->infoAgency = functions::infoClientByDomain($url);
                $sql = " SELECT UserCode,SessionID,IP,SaleCenterCode FROM user_info_train_tb WHERE id_user='{$this->infoAgency['id']}'";/*WHERE $Condition*/
                $sumcheck = $ModelBase->load($sql);
                $checksum = $sumcheck['UserCode'] . ',' . $sumcheck['SessionID'] . ',' . $sumcheck['IP'] . ',' . $sumcheck['SaleCenterCode'];
                $querytoken = "SELECT * FROM token_train_tb";
                $resulttoken = $ModelBase->load($querytoken);
                $checkVatParameters = array(
                    'FromStation' => $Dep,
                    'ToStation' => $Arr,
                    'MD' => $Date,
                    'RationCode' => 58,//58 for special train
                    'SexCode' => $passenger,
                    'duration' => 1,
                    'TarifCode' => 1,
                    'TicketType' => 1,
                    'Checksum' => $checksum,
                    'serviceSessionId' => $resulttoken['token']
                );

                $result = $this->client->GetWagonAvaliableSeatCount($checkVatParameters);

                $result = json_decode(json_encode($result), True);


                foreach ($result AS $res) {
                    $x = simplexml_load_string($res['any']);
                    $x = json_decode(functions::clearJsonHiddenCharacters(json_encode($x)), True);
                }
                functions::insertLog('end get wagon from apitrin: ', 'log_time_for_train');
             /*   if ((isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], 'indobare.com') !== false)) {

                    echo '<pre>' . print_r($x, true) . '</pre>';

                }*/

                return $x;
            } catch (Exception $e) {
//                echo '<pre>' . print_r($e->getMessage(), true) . '</pre>';

                preg_match_all('!\d+!', $e->getMessage(), $matches);
                $MessageError = functions::ShowErrorTrain($matches[0][0]);

                if($matches[0][0]==401){
                    self::wbsLogin();
                    self::GetWagonAvaliableSeatCount($Dep,$Arr,$Date,$passenger,$serviceSessionId);
                }

                $data['message'] = $e->getMessage();
                $data['messageFa'] = $MessageError;
                $data['clientId'] = CLIENT_ID;
                $data['messageCode'] = $matches[0][0];
                $data['request_number'] = '';
                $data['desti'] = '';
                $data['origin'] = '';
                $data['train_number'] = '';
                $data['action'] = 'GetWagonAvaliableSeatCount';
                $data['creation_date_int'] = time();
                $Model->setTable('log_train_tb');
                $Model->insertLocal($data);


                $return['result_status'] = 'Error';
                $return['result_message'] = 'در روند رزرو اشکالی پیش آمده است لطفا کمی بعد  جستجو کنید یا با سرویس دهنده  تماس حاصل نمایید';
                return $return;
            }
        }


    }
    public function GetOptionalService($SCP,$TrainNO,$Scps,$WagonTypeCode,$MovDateTimeTrain,$serviceSessionId)
    {
        functions::insertLog('get optional service from apitrin: ', 'log_time_for_train');
        try {
            $Model = Load::library('Model');
            $ModelBase = load::library('ModelBase');
            $querytoken = "SELECT * FROM token_train_tb";
            $resulttoken = $ModelBase->load($querytoken);
            $checkVatParameters = array(
                'SCP' => $SCP,
                'TrainNo' => $TrainNO,
                'Scps'=>$Scps,
                'WagonTypeCode'=>$WagonTypeCode,
                'MoveDateTimeTrain'=>$MovDateTimeTrain,
                'serviceSessionId' => $resulttoken['token']
            );
            functions::insertLog('in get optionalService: =>'.json_encode($checkVatParameters), 'log_train_request_GetOptionalService');
            $result = $this->client->GetOptionalServices($checkVatParameters);
          functions::insertLog('in get optionalService: =>'.json_encode($result), 'log_train_request_GetOptionalService');
            $result = json_decode(json_encode($result),True);
            foreach ($result AS $res) {
                $x = simplexml_load_string($res['any']);
                $x = json_decode(json_encode($x), True);
            }
            functions::insertLog('*************************** ', 'log_train_request_GetOptionalService');
            return $x;
        } catch (Exception $e) {
//             echo '<pre>' . print_r($e->getMessage(), true) . '</pre>';
//            echo '<pre>' . print_r($e, true) . '</pre>';
            preg_match_all('!\d+!', $e->getMessage(), $matches);
            $MessageError = functions::ShowErrorTrain($matches[0][0]);

            if($matches[0][0]==401){
                $token = self::wbsLogin();
                self::GetOptionalService($SCP,$TrainNO,$Scps,$WagonTypeCode,$MovDateTimeTrain,$token);
                }

            $data['message'] = $e->getMessage();
            $data['messageFa'] = $MessageError;
            $data['clientId'] = CLIENT_ID;
            $data['messageCode'] = $matches[0][0];
            $data['request_number'] = '';
            $data['desti'] = '';
            $data['origin'] = '';
            $data['train_number'] = '';
            $data['action'] = 'GetOptionalServices';
            $data['creation_date_int'] = time();
            $Model->setTable('log_train_tb');
            $Model->insertLocal($data);
            $return['result_status'] = 'Error';
            $return['result_message'] = 'در روند رزرو اشکالی پیش آمده است لطفا کمی بعد  جستجو کنید یا با سرویس دهنده  تماس حاصل نمایید';
            return $return;

        }
    }

    public function ViewPriceTicket($rateCode,$tariffCode,$TcktTypeCD,$pathCode,$fromStation,$totStation,$wagonType,$pDate,$trainNumber,$pScps,$discountClub,$soldcount,$pRation,$serviceSessionId,$passengerCount)
    {
        try {
            $Model = Load::library('Model');
            $ModelBase = load::library('ModelBase');
            $querytoken = "SELECT * FROM token_train_tb";
            $resulttoken = $ModelBase->load($querytoken);
            $checkVatParameters = array(
                'rateCode' => $rateCode,
                'tariffCode' => $tariffCode,
                'TcktTypeCD'=>$TcktTypeCD,
                'pathCode'=>$pathCode,
                'fromStation'=>$fromStation,
                'totStation' => $totStation,
                'wagonType' => $wagonType,
                'pDate' => $pDate,
                'trainNumber' => $trainNumber,
                'pScps' => $pScps,
                'discountClub' => $discountClub,
                'soldcount' => $soldcount,
                'pRation' => $pRation,
                'passengerCount' => $passengerCount,
                'serviceSessionId' => $resulttoken['token']
            );
        	functions::insertLog('param book train=>'.json_encode($checkVatParameters),'log_train_request_ViewPriceTicket');
            $result = $this->client->ViewPriceTicket2($checkVatParameters);
        	functions::insertLog('result train=>'.json_encode($result),'log_train_request_ViewPriceTicket');
           functions::insertLog('******************************************','log_train_request_ViewPriceTicket');
            $result = json_decode(json_encode($result),True);
            foreach ($result AS $res) {
                $x = simplexml_load_string($res['any']);
                $x = json_decode(json_encode($x), True);
                $fullprice = explode('.',$x['NewDataSet']['Table']['Formula10']);
                $fullprice = $fullprice[0];
                $x['NewDataSet']['Table']['Formula10'] = $fullprice;
            }
            return $x;
        } catch (Exception $e) {
            // echo '<pre>' . print_r($e->getMessage(), true) . '</pre>';
//            echo '<pre>' . print_r($e, true) . '</pre>';



            preg_match_all('!\d+!', $e->getMessage(), $matches);
            $MessageError = functions::ShowErrorTrain($matches[0][0]);
            if($matches[0][0]==401){
                $token = self::wbsLogin();
                $data1 = array('ServiceSessionId' => $token);
                $condition = "ServiceSessionId='".$serviceSessionId."'";
                $Model->setTable('temporary_train_tb');
                $res = $Model->update($data1, $condition);
                self::ViewPriceTicket($rateCode,$tariffCode,$TcktTypeCD,$pathCode,$fromStation,$totStation,$wagonType,$pDate,$trainNumber,$pScps,$discountClub,$soldcount,$pRation,$token);
            }

            $data['message'] = $e->getMessage();
            $data['messageFa'] = $MessageError;
            $data['clientId'] = CLIENT_ID;
            $data['messageCode'] = $matches[0][0];
            $data['request_number'] = '';
            $data['desti'] = '';
            $data['origin'] = '';
            $data['train_number'] = '';
            $data['action'] = 'ViewPriceTicket';
            $data['creation_date_int'] = time();
            $Model->setTable('log_train_tb');
            $Model->insertLocal($data);
            $return['result_status'] = 'Error';
            $return['result_message'] = 'در روند رزرو اشکالی پیش آمده است لطفا کمی بعد  جستجو کنید یا با سرویس دهنده  تماس حاصل نمایید';
            return $return;
        }
    }

    public function LockSeat_v3($TrainNo,$MoveDate,$StartStation,$ToStation,$RationCode,$WagonType,$SexCode,$SeatCount,$Degree,$SellMaster,$AppCode,$CapacityCompartment,$pIsExclusive,$SoldCount,$CircularNumberSerial,$serviceSessionId,$ServiceCode='')
    {
        try {
            $Model = Load::library('Model');
            $ModelBase = Load::library('ModelBase');
            $url =  str_replace('online.','',$_SERVER['HTTP_HOST']);
            $querytoken = "SELECT * FROM token_train_tb";
            $resulttoken = $ModelBase->load($querytoken);
            $this->infoAgency = functions::infoClientByDomain($url);
            $sql = " SELECT UserCode,SessionID,IP,SaleCenterCode FROM user_info_train_tb WHERE id_user='{$this->infoAgency['id']}'";/*WHERE $Condition*/
            $sumcheck = $ModelBase->load($sql);
            $checksum = $sumcheck['UserCode'].','.$sumcheck['SessionID'].','.$sumcheck['IP'].','.$sumcheck['SaleCenterCode'].','.$CircularNumberSerial.','.$SoldCount;
//            $client = new SoapClient($this->urlSoap,$this->params);
            if($ServiceCode !=''){
                $query = " SELECT ServiceSessionId FROM temporary_train_tb WHERE ServiceCode='{$ServiceCode}'";/*WHERE $Condition*/
                $SessionId = $Model->load($query);
                $serviceSessionId = $SessionId['ServiceSessionId'];
            }
            if($SellMaster ==''){
                $SellMaster = 0;
            }
            $checkVatParameters = array(
                'TrainNo' => $TrainNo,
                'MoveDate' => $MoveDate,
                'StartStation'=>$StartStation,
                'ToStation'=>$ToStation,
                'RationCode'=>$RationCode,
                'WagonType' => $WagonType,
                'SexCode' => $SexCode,
                'SeatCount' => $SeatCount,
                'Degree' => $Degree,
                'SellMaster' => $SellMaster,
                'AppCode' => $AppCode,
                'CapacityCompartment' => $CapacityCompartment,
                'pIsExclusive' => $pIsExclusive,
                'Checksum' => $checksum,
                'serviceSessionId' => $resulttoken['token']
            );

            functions::insertLog('param V3=>'.json_encode($checkVatParameters),'logSendDataTrain');
            $result = $this->client->LockSeat_v3($checkVatParameters);
       		functions::insertLog('result V3=>'.json_encode($result),'logSendDataTrain');
            functions::insertLog('*********************************************************','logSendDataTrain');
            $result = json_decode(json_encode($result),True);
            foreach ($result AS $res) {
                $x = simplexml_load_string($res['any']);
                $x = json_decode(json_encode($x), True);
            }

            if($x['NewDataSet']['Table']['SellSerial'] > 0)
            {
                return $x;
            }else{
                $data['message'] = 'Error In TicketNumber';
                $data['messageFa'] = json_encode($x);
                $data['clientId'] = CLIENT_ID;
                $data['messageCode'] = 'KH112';
                $data['request_number'] = $ServiceCode;
                $data['desti'] = '';
                $data['origin'] = '';
                $data['train_number'] = '';
                $data['action'] = 'LockSeat_v3';
                $data['creation_date_int'] = time();
                $Model->setTable('log_train_tb');
                $Model->insertLocal($data);
                $return['result_status'] = 'Error';
                $return['result_message'] = 'در روند رزرو اشکالی پیش آمده است لطفا کمی بعد  جستجو کنید یا با سرویس دهنده  تماس حاصل نمایید';
                return $return;
            }

        } catch (Exception $e) {
            // echo '<pre>' . print_r($e->getMessage(), true) . '</pre>';
//            echo '<pre>' . print_r($e, true) . '</pre>';
            preg_match_all('!\d+!', $e->getMessage(), $matches);
            $MessageError = functions::ShowErrorTrain($matches[0][0]);

            if($matches[0][0]==401){
                $token = self::wbsLogin();
                $data1 = array('ServiceSessionId' => $token);
                $condition = " ServiceSessionId='".$serviceSessionId."'";
                $Model->setTable('temporary_train_tb');
                $res = $Model->update($data1, $condition);
                self::LockSeat_v3($TrainNo,$MoveDate,$StartStation,$ToStation,$RationCode,$WagonType,$SexCode,$SeatCount,$Degree,$SellMaster,$AppCode,$CapacityCompartment,$pIsExclusive,$SoldCount,$CircularNumberSerial,$token);
            }

            $data['message'] = $e->getMessage();
            $data['messageFa'] = $MessageError;
            $data['clientId'] = CLIENT_ID;
            $data['messageCode'] = $matches[0][0];
            $data['request_number'] = '';
            $data['desti'] = '';
            $data['origin'] = '';
            $data['train_number'] = '';
            $data['action'] = 'LockSeat_v3';
            $data['creation_date_int'] = time();
            $Model->setTable('log_train_tb');
            $Model->insertLocal($data);
            $return['result_status'] = 'Error';
            $return['result_message'] = 'در روند رزرو اشکالی پیش آمده است لطفا کمی بعد  جستجو کنید یا با سرویس دهنده  تماس حاصل نمایید';
            return $return;
        }
    }


    public function RegisterTickect($ticket_number,$type)
    {
        try {
            $ModelBase = Load::library('ModelBase');
            $Model = Load::library('Model');
            $querytoken = "SELECT * FROM token_train_tb";
            $resulttoken = $ModelBase->load($querytoken);
            $url =  str_replace('online.','',$_SERVER['HTTP_HOST']);
            $this->infoAgency = functions::infoClientByDomain($url);
            $sql = " SELECT UserCode,SessionID,IP,SaleCenterCode FROM user_info_train_tb WHERE id_user='{$this->infoAgency['id']}'";/*WHERE $Condition*/
            $sumcheck = $ModelBase->load($sql);

            $sql = " SELECT * FROM book_train_tb WHERE TicketNumber='{$ticket_number}' AND TicketNumber <> '' AND TicketNumber <> '0' ";/*WHERE $Condition*/
            $datas = $Model->select($sql);

            if($datas !="")
            {
                $charter = 0;
                foreach ($datas AS $data){
                    $names[] = $data['passenger_name'];
                    $familyes[] = $data['passenger_family'];
                    $nationalcods[] = ($data['passenger_national_code'] == '' ? $data['passportNumber'] :$data['passenger_national_code']);
                    $birthdates[] = str_replace('-','',$data['passenger_birthday']);
                    $ticketNumbers[] = $data['TicketNumber'];
                    if($data['extra_chair']==1) {
                        $tariff[] = 5;
                        $charter = 1;
                    }elseif($data['Adult']==1){
                        $tariff[] = 1;
                    }elseif($data['Child']==1){
                        $tariff[] = 2;
                    }else{
                        $tariff[] = 6;
                    }
                    $Food[] = ($data['ServiceTypeCode'] !='' ? $data['ServiceTypeCode'] : 0);
                    $OrderNumber[] = '';
                    $tcktType[] = 1;
                }
                $Srvcs[][]=0;
                $checksum = $sumcheck['UserCode'].','.$sumcheck['SessionID'].','.$sumcheck['IP'].','.$sumcheck['SaleCenterCode'].','.$datas[0]['TrainNumber'];
//            $client = new SoapClient($this->urlSoap,$this->params);

                $checkVatParameters = array(
                    'SellId' => $datas[0]['TicketNumber'],
                    'cName' => $names,
                    'CFamily'=>$familyes,
                    'NationalCD'=>$nationalcods,
                    'Tel'=>$datas[0]['mobile_buyer'],
                    'tcktType' => $tcktType,
                    'tariff' => $tariff,
                    'Srvcs' => $Srvcs,
                    'personel' => array(),
                    'OrderNumber' => '',
                    'TicketNumber' => $ticketNumbers,
                    'Food' => $Food,
                    'birthDate' => $birthdates,
                    'promotionCode' => '',
                    'charter' => $charter,
                    'appcode' => 4,
                    'Checksum' => $checksum,
                    'serviceSessionId' => $resulttoken['token']
                );

                functions::insertLog('param book train=>'.json_encode($checkVatParameters),'log_train_request_book');

                if($type == 'ONEWAY') {
                    $this->p1 = $datas[0]['TicketNumber'];
                }else{
                    $this->p2 = $datas[0]['TicketNumber'];
                }
            }


            try{
                $result = $this->client->RegisterTiket($checkVatParameters);
                functions::insertLog('result book train=>'.json_encode($result),'log_train_request_book');
                $result = json_decode(json_encode($result),True);
                functions::insertLog('*******************************************','log_train_request_book');
                return $result['RegisterTiketResult'];
            }catch(Exception $e){
//                echo '<pre>' . print_r($e->getMessage(), true) . '</pre>';
                preg_match_all('!\d+!', $e->getMessage(), $matches);
                $MessageError = functions::ShowErrorTrain($matches[0][0]);
                $data['message'] = $e->getMessage();
                $data['messageFa'] = $MessageError;
                $data['clientId'] = CLIENT_ID;
                $data['messageCode'] = $matches[0][0];
                $data['request_number'] = '';
                $data['desti'] = '';
                $data['origin'] = '';
                $data['train_number'] = '';
                $data['action'] = 'RegisterTickect';
                $data['creation_date_int'] = time();
                $Model->setTable('log_train_tb');
                $Model->insertLocal($data);
            }


        } catch (Exception $e) {
            // echo '<pre>' . print_r($e->getMessage(), true) . '</pre>';
//            echo '<pre>' . print_r($e, true) . '</pre>';

            preg_match_all('!\d+!', $e->getMessage(), $matches);
            $MessageError = functions::ShowErrorTrain($matches[0][0]);

            if($matches[0][0]==401){
                self::wbsLogin();
                self::RegisterTickect($ticket_number,$type);
            }

            $data['message'] = $e->getMessage();
            $data['messageFa'] = $MessageError;
            $data['clientId'] = CLIENT_ID;
            $data['messageCode'] = $matches[0][0];
            $data['request_number'] = $ticket_number;
            $data['desti'] = '';
            $data['origin'] = '';
            $data['train_number'] = '';
            $data['action'] = 'RegisterTickect';
            $data['creation_date_int'] = time();
            $Model->setTable('log_train_tb');
            $Model->insertLocal($data);
            $return['result_status'] = 'Error';
            $return['result_message'] = 'در روند رزرو اشکالی پیش آمده است لطفا کمی بعد  جستجو کنید یا با سرویس دهنده  تماس حاصل نمایید';
            return $return;
        }
    }


    public function GetTicketAmount($serviceSessionId)
    {
        try {
            $Model = Load::library('Model');
            $ModelBase = load::library('ModelBase');
            $querytoken = "SELECT * FROM token_train_tb";
            $resulttoken = $ModelBase->load($querytoken);
//            $client = new SoapClient($this->urlSoap,$this->params);
            if($this->p2 !=''){
                $param  =  $this->p2;
            }else{
                $param  =  -1;
            }
            $checkVatParameters = array(
                'p1' => $this->p1,
                'p2' => $param,
                'serviceSessionId' => $resulttoken['token']
            );
         functions::insertLog('result GetTicketAmount train=>'.json_encode($checkVatParameters),'log_train_request_GetTicketAmount_train');
            $result = $this->client->GetTicketAmount($checkVatParameters);
           functions::insertLog('result GetTicketAmount train=>'.json_encode($result),'log_train_request_GetTicketAmount_train');
                functions::insertLog('*******************************************','log_train_request_GetTicketAmount_train');
            $result = json_decode(json_encode($result),True);

            return $result['GetTicketAmountResult'];
        } catch (Exception $e) {
            // echo '<pre>' . print_r($e->getMessage(), true) . '</pre>';
//            echo '<pre>' . print_r($e, true) . '</pre>';

            preg_match_all('!\d+!', $e->getMessage(), $matches);
            $MessageError = functions::ShowErrorTrain($matches[0][0]);

            if($matches[0][0]==401){
                $token = self::wbsLogin();
                $data1 = array(
                    'ServiceSessionId' => $token
                );
                $condition = " ServiceSessionId='" . $serviceSessionId . "'";
                $Model->setTable('temporary_train_tb');
                $res = $Model->update($data1, $condition);
                self::GetTicketAmount($token);
            }

            $data['message'] = $e->getMessage();
            $data['messageFa'] = $MessageError;
            $data['clientId'] = CLIENT_ID;
            $data['messageCode'] = $matches[0][0];
            $data['request_number'] = '';
            $data['desti'] = '';
            $data['origin'] = '';
            $data['train_number'] = '';
            $data['action'] = 'GetTicketAmount';
            $data['creation_date_int'] = time();
            $Model->setTable('log_train_tb');
            $Model->insertLocal($data);
            $return['result_status'] = 'Error';
            $return['result_message'] = 'در روند رزرو اشکالی پیش آمده است لطفا کمی بعد  جستجو کنید یا با سرویس دهنده  تماس حاصل نمایید';
            return $return;

        }
    }


    public function DeleteTicket2($ticketNumber,$serviceSessionId)
    {
        try {
            $ModelBase = Load::library('ModelBase');
            $querytoken = "SELECT * FROM token_train_tb";
            $resulttoken = $ModelBase->load($querytoken);
            $url =  str_replace('online.','',$_SERVER['HTTP_HOST']);
            $this->infoAgency = functions::infoClientByDomain($url);
            $sql = " SELECT `SaleCenterCode` FROM user_info_train_tb WHERE id_user='{$this->infoAgency['id']}'";/*WHERE $Condition*/
            $data = $ModelBase->load($sql);
            $Model = Load::library('Model');
            $sql_query ="SELECT *  FROM book_train_tb WHERE TicketNumber = '{$ticketNumber}'";
            $data2 =  $Model->load($sql_query);

//            $client = new SoapClient($this->urlSoap,$this->params);
            $checkVatParameters = array(
                'sellId' => $data2['TicketNumber'],
                'SaleCenterCD' => $data['SaleCenterCode'],
                'TrainNumber' => $data2['TrainNumber'],
                'movedate' => $data2['MoveDate'],
                'serviceSessionId' => $resulttoken['token']
            );

            functions::insertLog('param delete ticket train before send data with data=>'.json_encode($checkVatParameters),'log_train_delete_ticket');
            try{
            $result = $this->client->DeleteTicket2($checkVatParameters);
                $result = json_decode(json_encode($result),True);
                functions::insertLog('param delete ticket train After send data with data And Result=>'.json_encode($result),'log_train_delete_ticket');
                functions::insertLog('*****************************************************************************','log_train_delete_ticket');
                return $result['GetTicketAmountResult'];
            }catch(Exception $e){
        }

        } catch (Exception $e) {
            // echo '<pre>' . print_r($e->getMessage(), true) . '</pre>';
//            echo '<pre>' . print_r($e, true) . '</pre>';

            preg_match_all('!\d+!', $e->getMessage(), $matches);
            $MessageError = functions::ShowErrorTrain($matches[0][0]);

            if($matches[0][0]==401){
                $token = self::wbsLogin();
                $data1 = array(
                    'ServiceSessionId' => $token
                );
                $condition = " ServiceSessionId='" . $serviceSessionId . "'";
                $Model->setTable('temporary_train_tb');
                $res = $Model->update($data1, $condition);
                self::DeleteTicket2($ticketNumber,$token);
            }

            $data['message'] = $e->getMessage();
            $data['messageFa'] = $MessageError;
            $data['clientId'] = CLIENT_ID;
            $data['messageCode'] = $matches[0][0];
            $data['request_number'] = '';
            $data['desti'] = '';
            $data['origin'] = '';
            $data['train_number'] = '';
            $data['action'] = 'DeleteTicket2';
            $data['creation_date_int'] = time();
            $Model->setTable('log_train_tb');
            $Model->insertLocal($data);
            $return['result_status'] = 'Error';
            $return['result_message'] = 'در روند رزرو اشکالی پیش آمده است لطفا کمی بعد  جستجو کنید یا با سرویس دهنده  تماس حاصل نمایید';
            return $return;
        }
    }

    public function TicketReportA($ticket_number,$tokens='')
    {
        functions::insertLog('frist TicketReportA with factorNumber=>'.$ticket_number.'', 'log_train_TicketReportA');
        try {
            functions::insertLog('first object TicketReportA with factorNumber=>'.$ticket_number, 'log_train_TicketReportA');
         $ModelBase = load::library('ModelBase');
            $querytoken = "SELECT * FROM token_train_tb";
            $resulttoken = $ModelBase->load($querytoken);
            $checkVatParameters = array(
                'appcode'=> 4,
                'SaleId' => $ticket_number,
                'TicketNember' => -1,
                'TicketSeries'=>'-1',
                'serviceSessionId' => $resulttoken['token']
            );
            $result = $this->client->TicketReportA($checkVatParameters);
            functions::insertLog('end object TicketReportA with factorNumber=>'.$ticket_number, 'log_train_TicketReportA');

            $result = json_decode(json_encode($result),True);

                foreach ($result AS $res) {
                    $data= simplexml_load_string($res['any']);
                    $datas = json_decode(json_encode($data), True);
                }
                return $datas;

        } catch (Exception $e) {
            $Model = Load::library('Model');
            preg_match_all('!\d+!', $e->getMessage(), $matches);
            $MessageError = functions::ShowErrorTrain($matches[0][0]);
            if($matches[0][0]==401){
                 $token=self::wbsLogin();
                $data1 = array(
                    'ServiceSessionId' => $token
                );
                $condition = " ServiceSessionId='" . $resulttoken['token'] . "'";
                $Model->setTable('temporary_train_tb');
                $res = $Model->update($data1, $condition);
                self::TicketReportA($ticket_number,$token);
            }

            $data['message'] = $e->getMessage();
            $data['messageFa'] = $MessageError;
            $data['clientId'] = CLIENT_ID;
            $data['messageCode'] = $matches[0][0];
            $data['request_number'] = $ticket_number;
            $data['desti'] = '';
            $data['origin'] = '';
            $data['train_number'] = '';
            $data['action'] = 'TicketReportA';
            $data['creation_date_int'] = time();
            $Model->setTable('log_train_tb');
            $Model->insertLocal($data);
            $return['result_status'] = 'Error';
            $return['result_message'] = 'در روند رزرو اشکالی پیش آمده است لطفا کمی بعد  جستجو کنید یا با سرویس دهنده  تماس حاصل نمایید';
            return $return;
        }
    }

}


//$rajaApi = new apiTrain();
//$wbsLoginString = $rajaApi->wbsLogin() ;
//$rajaApi->Login($wbsLoginString);
//$rajaApi->GetWagonAvaliableSeatCount($wbsLoginString);

