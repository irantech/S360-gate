<?php

class trainCore extends clientAuth
{

    protected $serverUrl;
    protected $userName;
    protected $Model;
    protected $ModelBase;

    public function __construct()
    {



     
        parent::__construct();
//        $this->serverUrl = "http://192.168.1.100/CoreTestDeveloper/V-1/Train/";
//        $this->serverUrl = "http://safar360.com/CoreTestDeveloper/V-1/Train/";
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
//        die();
        $url = $this->serverUrl . "search";
        $dataSend = array(
            'FromStation' => ($data['Type'] == 'dept') ? $data['FromStation'] : $data['ToStation'],
            'ToStation' => ($data['Type'] == 'dept') ? $data['ToStation'] : $data['FromStation'],
            'MoveDate' => $data['MoveDate'],
            'TypePassenger' => $data['TypePassenger'],
            'AdultCount' => isset($data['AdultCount']) ? $data['AdultCount'] : 1,
            'ChildCount' => isset($data['ChildCount']) ? $data['ChildCount'] : 0,
            'InfantCount' => isset($data['InfantCount']) ? $data['InfantCount'] : 0,
        );

        $dataSendJson = json_encode($dataSend, 256 | 64);
        $options = array('auth_user' => $this->userName, 'auth_pass' => $this->userName);

        functions::insertLog(__METHOD__ . 'URL : ' . $url . ' PARAMS - ' . $dataSendJson, 'log_train_search');
       
        $curl_result = functions::curlExecution($url, $dataSendJson, $options);
       
        functions::insertLog(__METHOD__ . ' - ' . json_encode($curl_result, 256 | 64), 'log_train_search');

        return $curl_result;
    }

    public function LockSeat($params)
    {
        $url = $this->serverUrl . "lockSeat";

        $dataSendJson = json_encode($params, 256 | 64);
        functions::insertLog(__METHOD__ . ' PARAMS - ' . $dataSendJson, 'log_train_LockSeat');
        $result = functions::curlExecution($url, $dataSendJson, array('auth_user' => $this->userName, 'auth_pass' => $this->userName));
        functions::insertLog(__METHOD__ . ' - ' . json_encode($result, 256 | 64), 'log_train_LockSeat');
        if (!isset($result['statusError'])) {
            return $result;
        }

        return array(
            'result_status' => 'Error',
            'result_message' => 'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
        );
    }

    public function GetOptionalService($params)
    {
        $url = $this->serverUrl . "getOptionalService";
        $dataSendJson = json_encode($params, 256 | 64);
        functions::insertLog(__METHOD__ . ' PARAMS - ' . $dataSendJson, 'log_train_GetOptionalService');
        $return = functions::curlExecution($url, $dataSendJson, array('auth_user' => $this->userName, 'auth_pass' => $this->userName));
        functions::insertLog(__METHOD__ . ' - ' . json_encode($return, 256 | 64), 'log_train_GetOptionalService');

        return $return;
    }
    public function GetFreePassengerServices($params)
    {
        $url = $this->serverUrl . "getFreePassengerServices";
        $dataSendJson = json_encode($params, 256 | 64);
        functions::insertLog(__METHOD__ . ' PARAMS - ' . $dataSendJson, 'log_train_GetOptionalService');

        $return = functions::curlExecution($url, $dataSendJson, array('auth_user' => $this->userName, 'auth_pass' => $this->userName));
        functions::insertLog(__METHOD__ . ' - ' . json_encode($return, 256 | 64), 'log_train_GetOptionalService');

        return $return;
    }

    public function ViewPriceTicket($params)
    {
        $url = $this->serverUrl . "viewPriceTicket";
        $dataSendJson = json_encode($params, 256 | 64);
        functions::insertLog(__METHOD__ . ' PARAMS - ' . $dataSendJson, 'log_train_ViewPriceTicket');
        $result = functions::curlExecution($url, $dataSendJson, array('auth_user' => $this->userName, 'auth_pass' => $this->userName));
        functions::insertLog(__METHOD__ . ' - ' . json_encode($result, 256 | 64), 'log_train_ViewPriceTicket');
        if (isset($result['Success']) || $result['Success']) {
            return $result;
        }

        return array(
            'result_status' => 'Error',
            'result_message' => 'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
        );
    }

    public function RegisterTicket($params)
    {
        functions::insertLog('RegisterTicket params ---- ' . json_encode($params, 256 | 64), 'train_log');
        $cellArray = array(
            'afraze'   => '09916211232',
            'fanipor'  => '09129409530',
            'araste' => '09211559872',
            'abasi2' => '09057078341',
            'ms_bahrami' => '09351252904',
        );
        $ServerName = 'قطار';
        /** @var smsServices $smsController */
//        $smsController = Load::controller('smsServices');
//        $objSms = $smsController->initService('1');
//        if ($objSms) {
//            $smsController->smsByPattern('b4pma2p4tz', $cellArray, array('serverId' => $ServerName));
//        }

        $url = $this->serverUrl . "registerTicket";
        /** @var bookTrainModel $bookTrainModel */
        $bookTrainModel = Load::getModel('bookTrainModel');

        $InfoTickets = $bookTrainModel
            ->get()
            ->where('TicketNumber', $params['TicketNumber'])
            ->where('requestNumber', $params['code'])
            ->where('TicketNumber', '', '<>')
            ->where('TicketNumber', '0', '<>')->all();


        if (!empty($InfoTickets) && is_array($InfoTickets)) {
            $charter = 0;
            $names = $families = $nationalcodes = $birthdates = $ticketNumbers = $Food = $tariff = $tcktType = $Srvcs = array();
            $passenger_array = array();
            foreach ($InfoTickets as $data) {
				unset($data['id']);

                $passenger_item = array(
                    'FirstName' => $data['passenger_name'] ? $data['passenger_name'] : $data['passenger_name_en'],
                    'LastName' => $data['passenger_family'] ? $data['passenger_family'] : $data['passenger_family_en'],
                    'NationalCode' => $data['passenger_national_code'] &&  $data['passenger_national_code'] != '0000000000' ? $data['passenger_national_code'] : $data['passportNumber'] ,
                    'Birthday' => functions::ConvertToMiladi($data['passenger_birthday']),
                    'OptionalService' => ($data['ServiceTypeCode'] != '') ? $data['ServiceTypeCode'] : 0,
                    'FreeOptionalService' => ($data['free_service_code'] != '') ? $data['free_service_code'] : 0,
                    'Nationality' => $data['passportCountry'] !=  'IRN' ? $data['passportCountry'] :  'IRN'
                );

                if ($data['extra_chair']) {
                    $passenger_item['TariffCode'] = 5;
                    $charter = 1;
                } elseif ($data['passportCountry'] !=  '' && $data['passportCountry'] !=  'IRN' && !empty($data['passportNumber'])){
                    $passenger_item['TariffCode'] = 9;
                }elseif ($data['Adult'] == 1) {
                    $passenger_item['TariffCode'] = 1;
                } elseif ($data['Child'] == 1) {
                    $passenger_item['TariffCode'] = 2;
                } else {
                    $passenger_item['TariffCode'] = 6;
                }
                $passenger_item['tcktType']   = 1;
                $passenger_array[] = $passenger_item;
              
//                $names[] = $data['passenger_name'];
//                $families[] = $data['passenger_family'];
//                $nationalcodes[] = ($data['passenger_national_code'] == '' ? $data['passportNumber'] : $data['passenger_national_code']);
//                $birthdates[] = str_replace('-', '', $data['passenger_birthday']);
//                $ticketNumbers[] = $data['TicketNumber'];
//                if ($data['extra_chair'] == 1) {
//                    $tariff[] = 5;
//                    $charter = 1;
//                } elseif ($data['Adult'] == 1) {
//                    $tariff[] = 1;
//                } elseif ($data['Child'] == 1) {
//                    $tariff[] = 2;
//                } else {
//                    $tariff[] = 6;
//                }
//                if ($data['ServiceTypeCode'] != '') {
//                    $Food[] = $data['ServiceTypeCode'];
//                } else {
//                    $Food[] = 0;
//                }
//                $OrderNumber[] = '';
//                $tcktType[] = 1;
            }
//            $Srvcs[][] = 0;
//
//            $paramsRegisterTicket = array(
//                //				'userName'      => $this->userName,
//                'TicketNumber' => $params['TicketNumber'],
//                'names' => $names,
//                'families' => $families,
//                'nationalcodes' => $nationalcodes,
//                'mobile_buyer' => !empty($InfoTickets[0]['mobile_buyer']) ? $InfoTickets[0]['mobile_buyer'] : $InfoTickets[0]['member_mobile'],
//                'tcktType' => $tcktType,
//                'tariff' => $tariff,
//                'Srvcs' => $Srvcs,
//                'ticketNumbers' => $ticketNumbers,
//                'Food' => $Food,
//                'birthdates' => $birthdates,
//                'charter' => $charter,
//                'trainNumber' => $InfoTickets[0]['TrainNumber']
//            );

            $paramsRegisterTicket = array(
                'IsExclusiveCompartment' => $charter,
                "UniqueId" => $InfoTickets[0]['UniqueId'],
                'RequestNumber' => $InfoTickets[0]['requestNumber'],
                'Passengers' => $passenger_array,
                'Buyer' => [
                    'Mobile' => !empty($InfoTickets[0]['mobile_buyer']) ? $InfoTickets[0]['mobile_buyer'] : $InfoTickets[0]['member_mobile'],
                    'Email' => !empty($InfoTickets[0]['email_buyer']) ? $InfoTickets[0]['email_buyer'] : $InfoTickets[0]['member_email'],
                ],
            );

            $dataSendJson = json_encode($paramsRegisterTicket, 256 | 64);
            functions::insertLog(__METHOD__ . ' PARAMS - ' . $dataSendJson, 'log_train_RegisterTicket');
            $registerTicket = functions::curlExecution($url, $dataSendJson, array('auth_user' => $this->userName, 'auth_pass' => $this->userName));
            functions::insertLog(__METHOD__ . ' - ' . json_encode($registerTicket, 256 | 64), 'log_train_RegisterTicket');

            if (isset($registerTicket['Success']) && $registerTicket['Success'] == true && $registerTicket['StatusCode'] == 200) {
                /** @var ModelBase $ModelBase */
                $ModelBase = Load::library('ModelBase');
                $data_update['is_registered'] = '1';
                $condition = "requestNumber='{$InfoTickets[0]['requestNumber']}'";
                $update_1 = $bookTrainModel->updateWithBind($data_update, $condition);
                $update_2 = $ModelBase->updateWithBind($data_update, $condition, 'report_train_tb');

                return $registerTicket['Result'];
            }

            return array(
                'result_status' => 'Error',
                'result_message' => 'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
            );

        }

        return array(
            'result_status' => 'Error',
            'result_message' => 'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
        );

    }

    public function GetTicketAmount($params)
    {
        $url = $this->serverUrl . "getTicketAmount";
        $getTicketAmountParams = array(
            'UniqueId' => $params['UniqueId'],
            'RequestNumber' => $params['RequestNumber'],
            'RequestNumberReturn' => $params['RequestNumberReturn'],
        );
        $dataSendJson = json_encode($getTicketAmountParams, 256 | 64);
        functions::insertLog(__METHOD__ . ' dataSendJson - ' . $dataSendJson, 'log_train_GetTicketAmount');
        functions::insertLog(__METHOD__ . ' PARAMS - ' . json_encode($params), 'log_train_GetTicketAmount');
//        return json_encode($params,256|64);
//		functions::insertLog( 'request==>' . $params['code'] . '==>' . $dataSendJson, 'log_train_GetTicketAmount' );
        $getAmountTicket = functions::curlExecution($url, $dataSendJson, array('auth_user' => $this->userName, 'auth_pass' => $this->userName));
        functions::insertLog(__METHOD__ . ' - ' . json_encode($getAmountTicket, 256 | 64), 'log_train_GetTicketAmount');
        if (!isset($getAmountTicket['Success']) && $getAmountTicket['Success'] == true && $getAmountTicket['StatusCode'] == 200) {
            return $getAmountTicket;
        }

        return array(
            'result_status' => 'Error',
            'result_message' => 'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
        );
    }

    public function cancelTicket($params)
    {
        $url = $this->serverUrl . "cancelTicket";
        $getCancelTicketParams = array(
            'RequestNumber' => $params['requestNumber'],
            'pTkSr' => $params['TicketNumber'],
            'TrainNumber' => $params['TrainNumber'],
            'MoveDate' => $params['MoveDate'],
        );
        $dataSendJson = json_encode($getCancelTicketParams, 256 | 64);
        functions::insertLog(__METHOD__ . ' - ' . json_encode($getCancelTicketParams, 256 | 64), 'log_train_cancelTicket');
        $result = functions::curlExecution($url, $dataSendJson, array('auth_user' => $this->userName, 'auth_pass' => $this->userName));
        $dataSendJson = json_encode($result, 256 | 64);
		functions::insertLog( 'response==>' . $params['requestNumber'] . '==>' . json_encode( $result ), 'log_train_cancelTicket' );
//		functions::insertLog( '***************************************************', 'log_train_CancelTicket' );
        if (isset($result['Success']) && $result['Success'] == true && $result['StatusCode'] == 200) {
            return $result;
        }

        return array(
            'result_status' => 'Error',
            'result_message' => 'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
        );
    }

    public function DeleteTicket($params)
    {
        $url = $this->serverUrl . "deleteTicket";
        $getDeleteTicketParams = array(
            'RequestNumber' => $params['requestNumber'],
            'SaleId' => $params['TicketNumber'],
            'TrainNumber' => $params['TrainNumber'],
            'MoveDate' => $params['MoveDate'],
        );
        $dataSendJson = json_encode($getDeleteTicketParams, 256 | 64);
        functions::insertLog(__METHOD__ . ' PARAMS - ' . $dataSendJson, 'log_train_DeleteTicket');
        $result = functions::curlExecution($url, $dataSendJson, array('auth_user' => $this->userName, 'auth_pass' => $this->userName));
        functions::insertLog(__METHOD__ . ' - ' . json_encode($result, 256 | 64), 'log_train_DeleteTicket');
        if (isset($result['Success']) && $result['Success'] == true && $result['StatusCode'] == 200) {
            return $result;
        }
        return array(
            'result_status' => 'Error',
            'result_message' => 'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
        );
    }

    public function TicketReportA($params)
    {
        functions::insertLog(__METHOD__ . ' PARAMS - ' . json_encode($params), 'log_train_TicketReportA');
        $url = $this->serverUrl . "ticketReportA";
//        unset($params['code']);
        $getTicketReportAParams = array(
            'RequestNumber' => $params['requestNumber'],
            'UniqueId' => $params['UniqueId']
        );
        $dataSendJson = json_encode($getTicketReportAParams, 256 | 64);
        functions::insertLog(__METHOD__ . ' dataSendJson - ' . $dataSendJson, 'log_train_TicketReportA');
        $result = functions::curlExecution($url, $dataSendJson, array('auth_user' => $this->userName, 'auth_pass' => $this->userName));
        functions::insertLog(__METHOD__ . ' - ' . json_encode($result, 256 | 64), 'log_train_TicketReportA');
        if (isset($result['Success']) && $result['Success'] == true && $result['StatusCode'] == 200) {
            return $result;
        }

        return array(
            'result_status' => 'Error',
            'result_message' => 'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
        );
    }

    public function getCodePrintTicket($params) {

        functions::insertLog(__METHOD__ . ' PARAMS - ' . json_encode($params), 'print_code_ticket');
        $url = $this->serverUrl . "getPrintCodeTicket";
//        unset($params['code']);
        $getTicketReportAParams = array(
            'RequestNumber' => $params['requestNumber'],
            'UniqueId' => $params['UniqueId'],
            'TicketNumber'=> $params['TicketNumber']
        );

        $dataSendJson = json_encode($getTicketReportAParams, 256 | 64);
        functions::insertLog(__METHOD__ . ' dataSendJson - ' . $dataSendJson, 'log_train_print_code_ticket');
        $result = functions::curlExecution($url, $dataSendJson, array('auth_user' => $this->userName, 'auth_pass' => $this->userName));
        functions::insertLog(__METHOD__ . ' - ' . json_encode($result, 256 | 64), 'log_train_print_code_ticket');
        if (isset($result['Success']) && $result['Success'] == true && $result['StatusCode'] == 200) {
            return $result;
        }

        return array(
            'result_status' => 'Error',
            'result_message' => 'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
        );
    }


    public function getSpecialPrices($param) {

        functions::insertLog(__METHOD__ . ' PARAMS - ' . json_encode($param), 'log_train_get_special_price');
        $url = $this->serverUrl . "getPriceSpecialTrain/".$param;
        functions::insertLog(__METHOD__ . ' url - ' . json_encode($url), 'log_train_get_special_price');
        $dataSendJson = json_encode([]);
        $result = functions::curlExecution($url, $dataSendJson, array('auth_user' => $this->userName, 'auth_pass' => $this->userName));
        functions::insertLog(__METHOD__ . ' - ' . json_encode($result, 256 | 64), 'log_train_get_special_price');
        if ($result['Success'] && $result['StatusCode'] == 200) {
            return $result['Result'];
        }

        return array(
            'result_status' => 'Error',
            'result_message' => 'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
        );
    }

    public function GetTicketData($params)
    {
        functions::insertLog(__METHOD__ . ' PARAMS - ' . json_encode($params), 'log_train_TicketReportA');
        $url = $this->serverUrl . "GetTicketData";
//        unset($params['code']);
        $getTicketReportAParams = array(
            'RequestNumber' => $params['requestNumber'],
            'TicketNumber' => $params['TicketNumber'],
            'UniqueId' => $params['UniqueId']
        );
        $dataSendJson = json_encode($getTicketReportAParams, 256 | 64);
        functions::insertLog(__METHOD__ . ' dataSendJson - ' . $dataSendJson, 'log_train_TicketReportA');
       
        $result = functions::curlExecution($url, $dataSendJson, array('auth_user' => $this->userName, 'auth_pass' => $this->userName));
        functions::insertLog(__METHOD__ . ' - ' . json_encode($result, 256 | 64), 'log_train_TicketReportA');

        if (isset($result['Success']) && $result['Success'] == true && $result['StatusCode'] == 200) {
            return $result;
        }

        return array(
            'result_status' => 'Error',
            'result_message' => 'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
        );
    }
}