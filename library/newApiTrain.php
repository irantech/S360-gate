<?php


class newApiTrain extends clientAuth
{
    protected $serverUrl;
    protected $userName;
    protected $Model;
    protected $ModelBase;

    public function __construct()
    {
        parent::__construct();
//        $this->serverUrl = "http://safar360.com/Core/V-1/Train/";
        $this->serverUrl = "http://safar360.com/Core/V-1/Train/";
        $InfoSources = parent::TrainAuth();
        $this->Model = Load::library('Model');
        $this->ModelBase = Load::library('ModelBase');

        if (!empty($InfoSources)) {
            $this->userName = $InfoSources['Username'];
        }


    }


    public function search($data)
    {
         $url = $this->serverUrl."search/". $this->userName ;

        $dataSend = array(
            'fromStation'=> ($data['type']== 'dept') ? $data['fromStation'] : $data['toStation'],
            'toStation'=>($data['type']== 'dept') ? $data['toStation'] : $data['fromStation'],
            'dateMove'=> $data['dateMove'],
            'typePassenger'=> $data['typePassenger'],
        );

         $dataSendJson = json_encode($dataSend);
        return functions::curlExecution($url,$dataSendJson,'yes');

    }


    public function GetOptionalService($params,$code)
    {
        $url = $this->serverUrl."getOptionalService/". $code ;
        $params['userName'] = $this->userName;
        $dataSendJson = json_encode($params);
        return functions::curlExecution($url,$dataSendJson,'yes');
    }

    public function ViewPriceTicket($params)
    {

        $url = $this->serverUrl."viewPriceTicket/". $params['code'] ;
        unset($params['code']);
        $params['userName'] = $this->userName;
        functions::insertLog('Request=>'.$params['code'].'==>'.json_encode($params),'log_train_ViewPriceTicket');
        $dataSendJson = json_encode($params);
        $result = functions::curlExecution($url,$dataSendJson,'yes');

        functions::insertLog('response=>'.$params['code'].'==>'.json_encode($result),'log_train_ViewPriceTicket');
        functions::insertLog('***************************************************','log_train_ViewPriceTicket');

        if(!isset($result['statusError']))
        {
            return $result;
        }

        return array(
            'result_status'=>'Error',
            'result_message'=>'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
        );
    }

    public function LockSeat($params){
         $url = $this->serverUrl."lockSeat/". $params['code'] ;
        $code = $params['code'] ;
        unset($params['code']);
        $params['userName'] = $this->userName;
        $dataSendJson = json_encode($params);
        functions::insertLog('Request==>'.$code.'==>'.$dataSendJson,'log_train_LockSeat');
        $result =  functions::curlExecution($url,$dataSendJson,'yes');
        functions::insertLog('response==>'.$code.'==>'.json_encode($result),'log_train_LockSeat');
        functions::insertLog('***************************************************','log_train_LockSeat');

        if(!isset($result['statusError']))
        {
            return $result;
        }

        return array(
            'result_status'=>'Error',
            'result_message'=>'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
        );
    }

    public function RegisterTicket($params){
         $url = $this->serverUrl."registerTicket/". $params['code'] ;
          $sql = " SELECT * FROM book_train_tb WHERE TicketNumber='{$params['TicketNumber']}' AND TicketNumber <> '' AND TicketNumber <> '0' ";/*WHERE $Condition*/
        $InfoTickets = $this->Model->select($sql);
        functions::insertLog('request==>'.$params['TicketNumber'].'==> comes here','log_train_fateme');

        if(!empty($InfoTickets))
        {
            $charter = 0;
            foreach ($InfoTickets AS $data){
                $names[] = $data['passenger_name'];
                $families[] = $data['passenger_family'];
                $nationalcodes[] = ($data['passenger_national_code'] == '' ? $data['passportNumber'] :$data['passenger_national_code']);
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
                if($data['ServiceTypeCode'] !='')
                {
                    $Food[]= $data['ServiceTypeCode'];
                }else{
                    $Food[] = 0 ;
                }
                $OrderNumber[] = '';
                $tcktType[] = 1;
            }
            $Srvcs[][]=0;

            $paramsRegisterTicket = array(
                'userName' => $this->userName,
                'TicketNumber' => $params['TicketNumber'],
                'names' => $names,
                'families' => $families,
                'nationalcodes' => $nationalcodes,
                'mobile_buyer' => !empty($InfoTickets[0]['mobile_buyer']) ? $InfoTickets[0]['mobile_buyer'] : $InfoTickets[0]['member_mobile'],
                'tcktType' => $tcktType,
                'tariff' => $tariff,
                'Srvcs' => $Srvcs,
                'ticketNumbers' => $ticketNumbers,
                'Food' => $Food,
                'birthdates' => $birthdates,
                'charter' => $charter,
                'trainNumber'=>$InfoTickets[0]['TrainNumber']
            );
              $dataSendJson = json_encode($paramsRegisterTicket);
            functions::insertLog('request==>'.$params['code'].'==>'.$dataSendJson,'log_train_registerTicket');
            $registerTicket = functions::curlExecution($url,$dataSendJson,'yes');
            functions::insertLog('response==>'.$params['code'].'==>'.json_encode($registerTicket),'log_train_registerTicket');
            functions::insertLog('***************************************************','log_train_registerTicket');

            if(!isset($registerTicket['statusError']))
            {
                return $registerTicket['RegisterTiketResult'];
            }

            return array(
                'result_status'=>'Error',
                'result_message'=>'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
            );

        }

    }

    public function GetTicketAmount($params)
    {

        $url = $this->serverUrl."getTicketAmount/". $params['code'] ;

        $getTicketAmountParams = array(
            'userName'=> $this->userName,
            'p1' => $params['TicketNumberDept'],
            'p2' => (!empty($params['TicketNumberReturn']) && $params['TicketNumberReturn'] > 0) ? $params['TicketNumberReturn'] : '-1' ,
        );
         $dataSendJson = json_encode($getTicketAmountParams);
        functions::insertLog('request==>'.$params['code'].'==>'.$dataSendJson,'log_train_GetTicketAmount');
        $getAmountTicket =  functions::curlExecution($url,$dataSendJson,'yes');
        functions::insertLog('response==>'.$params['code'].'==>'. json_encode($getAmountTicket),'log_train_GetTicketAmount');
        functions::insertLog('***************************************************','log_train_GetTicketAmount');
        if(!isset($getAmountTicket['statusError']))
        {
            return $getAmountTicket;
        }

        return array(
            'result_status'=>'Error',
            'result_message'=>'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
        );
    }


    public function cancelTicket($params)
    {
        $url = $this->serverUrl."cancelTicket/". $params['requestNumber'] ;
        $getCancelTicketParams = array(
            'userName'=> $this->userName,
            'pTkSr' => $params['TicketNumber'],
            'TrainNumber' => $params['TrainNumber']  ,
            'MoveDate' => $params['MoveDate'],
        );
        $dataSendJson = json_encode($getCancelTicketParams);
        functions::insertLog('request==>'.$params['requestNumber'].'==>'.$dataSendJson,'log_train_DeleteTicket2');
        $result = functions::curlExecution($url,$dataSendJson,'yes');
        functions::insertLog('response==>'.$params['requestNumber'].'==>'.json_encode($result),'log_train_DeleteTicket2');
        functions::insertLog('***************************************************','log_train_DeleteTicket2');
        if(!isset($result['statusError']))
        {
            return $result;
        }

        return array(
            'result_status'=>'Error',
            'result_message'=>'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
        );
    }

    public function DeleteTicket2($params)
    {
        $url = $this->serverUrl."deleteTicket/". $params['requestNumber'] ;
        $getDeleteTicketParams = array(
            'userName'=> $this->userName,
            'sellId' => $params['TicketNumber'],
            'TrainNumber' => $params['TrainNumber']  ,
            'MoveDate' => $params['MoveDate'],
        );
        $dataSendJson = json_encode($getDeleteTicketParams);
        functions::insertLog('request==>'.$params['requestNumber'].'==>'.$dataSendJson,'log_train_DeleteTicket2');
        $result = functions::curlExecution($url,$dataSendJson,'yes');
        functions::insertLog('response==>'.$params['requestNumber'].'==>'.json_encode($result),'log_train_DeleteTicket2');
        functions::insertLog('***************************************************','log_train_DeleteTicket2');
        if(!isset($result['statusError']))
        {
            return $result;
        }

        return array(
            'result_status'=>'Error',
            'result_message'=>'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
        );
    }


    public function TicketReportA($params)
    {

         $url = $this->serverUrl."ticketReportA/". $params['requestNumber'] ;
        unset($params['code']);
        $getTicketReportAParams = array(
            'userName'=> (!empty($this->userName) && CLIENT_ID !='4')? $this->userName : $params['userName'],
            'SaleId' => $params['TicketNumber']
        );
        $dataSendJson = json_encode($getTicketReportAParams);
        functions::insertLog('request==>'.$params['requestNumber'].'==>'.$dataSendJson,'log_train_TicketReportA');
        $result =  functions::curlExecution($url,$dataSendJson,'yes');
        functions::insertLog('response==>'.$params['requestNumber'].'==>'.json_encode($result),'log_train_TicketReportA');
        functions::insertLog('***************************************************','log_train_TicketReportA');
        if(!isset($result['statusError']))
        {
            return $result;
        }

        return array(
            'result_status'=>'Error',
            'result_message'=>'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
        );
    }


}