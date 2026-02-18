<?php
/**
 * Class smsServices
 * @property smsServices $smsServices
 * @property smsFaraz $objSmsService
 */
class smsServices extends clientAuth {

    #region variables
    public $clientID = null;
    public $sendFromIrantech;
    public $objSmsService = null;
    #endregion

    function __construct() {
        parent::__construct();
    }

    #region initService: initial the active sms service
    public function initService($sendFromIrantech, $clientID = null)
    {

        $this->clientID = $clientID;
        $this->sendFromIrantech = $sendFromIrantech;

        if($this->sendFromIrantech == '1'){


            //$objService = Load::library('smsMehrafraz');
            /** @var smsFaraz $objService */
            $objService = Load::library('smsFaraz');
            $objService->initIrantechParam();
            functions::insertLog('initService: using Irantech', '0000log_sms_debug');

        } else {

            $result = $this->getActiveService();
            functions::insertLog('initService: getActiveService result='.json_encode($result), 'log_sms_debug');

            if (!empty($result)) {
                functions::insertLog('initService failed: no active service found', 'log_sms_debug');
                $objService = Load::library($result['smsService']);
                $objService->init($result);

            } else{
                return false;
            }
        }


        if($objService){
            $this->objSmsService = $objService;
            return true;
        }
        functions::insertLog('initService failed: objService is null', 'log_sms_debug');
        return false;
    }
    #endregion

    #region getActiveService: get active sms service if exist
    public function getActiveService()
    {

        if($this->clientID != null) {

            $admin = Load::controller('admin');
            $query = "SELECT * FROM sms_service_info_tb WHERE isActive = '1' LIMIT 0,1";
            return $admin->ConectDbClient($query, $this->clientID, 'Select', '', '', '');

        } else{
            $Model = Load::library('Model');

            $query = "SELECT * FROM sms_service_info_tb WHERE isActive = '1' LIMIT 0,1";
            return $Model->load($query);
        }
    }
    #endregion


    #region get pattern
    public function getPattern($patternType)
    {


        $result = null;
        $sms_service_info = $this->getModel('smsServiceInfoModel');
        $sms_info  = $sms_service_info->get()
            ->where('isActive', 1)
            ->find(false);

        if($sms_info['patternCode']) {

            $patterns  = json_decode($sms_info['patternCode']  , true);

            foreach ($patterns as $key => $value) {
                if($value['title'] == $patternType) {
                    $result =  $value;
                }
            }
        }

        return $result ;
    }
    #endregion

    #region
    public function getUsableMessage($usage, $variables)
    {


        if($this->clientID != null) {

            $admin = Load::controller('admin');
            $query = "SELECT body FROM sms_message_tb WHERE isActive = 'yes' AND smsUsage = '{$usage}' LIMIT 0,1";
            $message = $admin->ConectDbClient($query, $this->clientID, 'Select', '', '', '');

        } else{
            $Model = Load::library('Model');

            $query = "SELECT body FROM sms_message_tb WHERE isActive = 'yes' AND smsUsage = '{$usage}' LIMIT 0,1";
            $message = $Model->load($query);
        }
        return $this->provideMessageToSend($message['body'], $variables);

    }
    #endregion

    #region privideMessageToSend: replace all dynamic elements and provide a real message
    public function provideMessageToSend($message, $variables)
    {


        //remove textarea defult enters
        $providedMessage = preg_replace("/(\r|\n)/", "", $message);

        $replaceableVariables = array(
            '|sms_name|' => isset($variables['sms_name']) ? $variables['sms_name'] : '',
            '|sms_username|' => isset($variables['sms_username']) ? $variables['sms_username'] : '',
            '|sms_reagent_code|' => isset($variables['sms_reagent_code']) ? $variables['sms_reagent_code'] : '',
            '|sms_service|' => isset($variables['sms_service']) ? $variables['sms_service'] : '',
            '|sms_factor_number|' => isset($variables['sms_factor_number']) ? $variables['sms_factor_number'] : '',
            '|sms_cost|' => isset($variables['sms_cost']) ? $variables['sms_cost'] : '',
            '|sms_pdf|' => isset($variables['sms_pdf']) ? $variables['sms_pdf'] : '',
            '|sms_pdf_en|' => isset($variables['sms_pdf_en']) ? $variables['sms_pdf_en'] : '',
            '|sms_airline|' => isset($variables['sms_airline']) ? $variables['sms_airline'] : '',
            '|sms_origin|' => isset($variables['sms_origin']) ? $variables['sms_origin'] : '',
            '|sms_destination|' => isset($variables['sms_destination']) ? $variables['sms_destination'] : '',
            '|sms_flight_number|' => isset($variables['sms_flight_number']) ? $variables['sms_flight_number'] : '',
            '|sms_flight_date|' => isset($variables['sms_flight_date']) ? $variables['sms_flight_date'] : '',
            '|sms_flight_time|' => isset($variables['sms_flight_time']) ? $variables['sms_flight_time'] : '',
            '|sms_flight_indemnity|' => isset($variables['sms_flight_indemnity']) ? $variables['sms_flight_indemnity'] : '',
            '|sms_hotel_name|' => isset($variables['sms_hotel_name']) ? $variables['sms_hotel_name'] : '',
            '|sms_hotel_in|' => isset($variables['sms_hotel_in']) ? $variables['sms_hotel_in'] : '',
            '|sms_hotel_out|' => isset($variables['sms_hotel_out']) ? $variables['sms_hotel_out'] : '',
            '|sms_hotel_night|' => isset($variables['sms_hotel_night']) ? $variables['sms_hotel_night'] : '',
            '|sms_order_link|' => isset($variables['sms_order_link']) ? $variables['sms_order_link'] : '',
            '|sms_insure_type|' => isset($variables['sms_insure_type']) ? $variables['sms_insure_type'] : '',
            '|sms_insure_caption|' => isset($variables['sms_insure_caption']) ? $variables['sms_insure_caption'] : '',
            '|sms_insure_duration|' => isset($variables['sms_insure_duration']) ? $variables['sms_insure_duration'] : '',
            '|sms_visa_title|' => isset($variables['sms_visa_title']) ? $variables['sms_visa_title'] : '',
            '|sms_visa_type|' => isset($variables['sms_visa_type']) ? $variables['sms_visa_type'] : '',
            '|sms_visa_duration|' => isset($variables['sms_visa_duration']) ? $variables['sms_visa_duration'] : '',
            '|sms_interactive_title|' => isset($variables['sms_interactive_title']) ? $variables['sms_interactive_title'] : '',
            '|sms_interactive_code|' => isset($variables['sms_interactive_code']) ? $variables['sms_interactive_code'] : '',
            '|sms_europcar_car_name|' => isset($variables['sms_europcar_car_name']) ? $variables['sms_europcar_car_name'] : '',
            '|sms_europcar_source_station_name|' => isset($variables['sms_europcar_source_station_name']) ? $variables['sms_europcar_source_station_name'] : '',
            '|sms_europcar_dest_station_name|' => isset($variables['sms_europcar_dest_station_name']) ? $variables['sms_europcar_dest_station_name'] : '',
            '|sms_europcar_source_date|' => isset($variables['sms_europcar_source_date']) ? $variables['sms_europcar_source_date'] : '',
            '|sms_europcar_source_time|' => isset($variables['sms_europcar_source_time']) ? $variables['sms_europcar_source_time'] : '',
            '|sms_europcar_dest_date|' => isset($variables['sms_europcar_dest_date']) ? $variables['sms_europcar_dest_date'] : '',
            '|sms_europcar_dest_time|' => isset($variables['sms_europcar_dest_time']) ? $variables['sms_europcar_dest_time'] : '',
            '|sms_tour_name|' => isset($variables['sms_tour_name']) ? $variables['sms_tour_name'] : '',
            '|sms_tour_night|' => isset($variables['sms_tour_night']) ? $variables['sms_tour_night'] : '',
            '|sms_tour_day|' => isset($variables['sms_tour_day']) ? $variables['sms_tour_day'] : '',
            '|sms_tour_cities|' => isset($variables['sms_tour_cities']) ? $variables['sms_tour_cities'] : '',
            '|sms_tour_dept_date|' => isset($variables['sms_tour_dept_date']) ? $variables['sms_tour_dept_date'] : '',
            '|sms_tour_return_date|' => isset($variables['sms_tour_return_date']) ? $variables['sms_tour_return_date'] : '',
            '|sms_gasht_service_name|' => isset($variables['sms_gasht_service_name']) ? $variables['sms_gasht_service_name'] : '',
            '|sms_gasht_city_name|' => isset($variables['sms_gasht_city_name']) ? $variables['sms_gasht_city_name'] : '',
            '|sms_gasht_date|' => isset($variables['sms_gasht_date']) ? $variables['sms_gasht_date'] : '',
            '|sms_gasht_start_time|' => isset($variables['sms_gasht_start_time']) ? $variables['sms_gasht_start_time'] : '',
            '|sms_gasht_end_time|' => isset($variables['sms_gasht_end_time']) ? $variables['sms_gasht_end_time'] : '',
            '|sms_bus_origin_name|' => isset($variables['sms_bus_origin_name']) ? $variables['sms_bus_origin_name'] : '',
            '|sms_bus_dest_name|' => isset($variables['sms_bus_dest_name']) ? $variables['sms_bus_dest_name'] : '',
            '|sms_ticket_number|' => isset($variables['sms_ticket_number']) ? $variables['sms_ticket_number'] : '',
            '|sms_bus_company_name|' => isset($variables['sms_bus_company_name']) ? $variables['sms_bus_company_name'] : '',
            '|sms_bus_origin_terminal|' => isset($variables['sms_bus_origin_terminal']) ? $variables['sms_bus_origin_terminal'] : '',
            '|sms_bus_date_move|' => isset($variables['sms_bus_date_move']) ? $variables['sms_bus_date_move'] : '',
            '|sms_bus_time_move|' => isset($variables['sms_bus_time_move']) ? $variables['sms_bus_time_move'] : '',
            '|sms_bus_chairs_number|' => isset($variables['sms_bus_chairs_number']) ? $variables['sms_bus_chairs_number'] : '',
            '|sms_agency|' => isset($variables['sms_agency']) ? $variables['sms_agency'] : '',
            '|sms_agency_mobile|' => isset($variables['sms_agency_mobile']) ? $variables['sms_agency_mobile'] : '',
            '|sms_agency_phone|' => isset($variables['sms_agency_phone']) ? $variables['sms_agency_phone'] : '',
            '|sms_agency_email|' => isset($variables['sms_agency_email']) ? $variables['sms_agency_email'] : '',
            '|sms_agency_address|' => isset($variables['sms_agency_address']) ? $variables['sms_agency_address'] : '',
            '|sms_entertainment_name|' => isset($variables['sms_entertainment_name']) ? $variables['sms_entertainment_name'] : '',
            '|sms_site_url|' => isset($variables['sms_site_url']) ? $variables['sms_site_url'] : '',
        );

        //replace variables
        foreach ($replaceableVariables as $key => $value){
            $providedMessage = str_replace($key, $value, $providedMessage);
        }

        //add sms enters
        $messageParts = explode('|sms_eol|',$providedMessage);
        foreach ($messageParts as $key => $value){
            if($key == 0){
                $providedMessage = $value;
            } else{
                $providedMessage .= PHP_EOL . $value;
            }
        }

        return $providedMessage;
    }
    #endregion

    #region sendSMS
    public function sendSMS($smsArray) {

//        functions::insertLog('after sms'.json_encode($smsArray,256),'log_sms_request');

        if($this->objSmsService && !empty($smsArray['smsMessage']) && !empty($smsArray['cellNumber'])){

            //send
            $result = $this->objSmsService->smsSend($smsArray);

            $reportArray = array(
                'memberID' => (!empty($smsArray['memberID']) ? $smsArray['memberID'] : ''),
                'request_number' => (!empty($smsArray['request_number']) ? $smsArray['request_number'] : ''),
                'receiverName' => (!empty($smsArray['receiverName']) ? $smsArray['receiverName'] : ''),
                'receiverMobile' => $smsArray['cellNumber'],
                'smsMessageTitle' => (!empty($smsArray['smsMessageTitle']) ? $smsArray['smsMessageTitle'] : ''),
                'smsMessage' => $smsArray['smsMessage'],
                'sendType' => (!empty($smsArray['sendType']) ? $smsArray['sendType'] : 'auto'),
                'sendTo' => (!empty($smsArray['sendTo']) ? $smsArray['sendTo'] : ''),
                'sameID' => (!empty($smsArray['sameID']) ? $smsArray['sameID'] : '')
            );


            if ($result['result_status'] == 'success') {

                $reportArray['sendStatus'] = '1';
                $reportArray['sendErrorMessage'] = $result['result_message'];
                $reportArray['sendSuccessCode'] = $result['result_code'];

            } else{

                $reportArray['sendStatus'] = '0';
                $reportArray['sendErrorMessage'] = $result['result_message'];
                $reportArray['sendSuccessCode'] = $result['result_code'];

            }

//                report
            $this->addSendReport($reportArray);

            //delivery
            if($result['result_status'] == 'success') {

                $this->checkDelivery($result['result_code']);
            }
            return $result;
        }
    }
    #endregion

    #region sendSmsWithApi
    public function sendSmsWithApi($data)
    {

        $this->objSmsService->sendSmsWithApi($data);
    }
    #endregion


    #origin smsSendPattern
    public function smsSendPattern($smsArray)
    {


        if($this->objSmsService && !empty($smsArray['cellNumber'])) {
            $result = $this->objSmsService->smsSendPattern($smsArray);
            return $result;
        }
        return false;
    }

    #endorigin

    #region addSendReport
    public function addSendReport($param)
    {

        $smsPanel = Load::controller('smsPanel');

        $arg = array(
            'memberID'=>FILTER_VALIDATE_INT,
            'receiverName'=>FILTER_SANITIZE_STRING,
            'request_number'=>FILTER_SANITIZE_STRING,
            'receiverMobile'=>FILTER_SANITIZE_NUMBER_INT,
            'smsMessageTitle'=>FILTER_SANITIZE_STRING,
            'smsMessage'=>FILTER_SANITIZE_STRING,
            'sendType'=>FILTER_SANITIZE_STRING,
            'sendTo'=>FILTER_SANITIZE_STRING,
            'sendStatus'=>FILTER_VALIDATE_INT,
            'sendErrorMessage'=>FILTER_SANITIZE_STRING,
            'sendSuccessCode'=>FILTER_SANITIZE_NUMBER_INT,
        );
        $data = filter_var_array($param, $arg);

        if($param['sendType'] == 'auto'){
            $usages = $smsPanel->messageUsages();
            $data['smsMessageTitle'] = (!empty($usages[$data['smsMessageTitle']]) ? $usages[$data['smsMessageTitle']] : '');
        }

        if(!empty($param['sameID'])){
            $data['sameID'] = filter_var($param['sameID'], FILTER_VALIDATE_INT);
        }

        $data['creationDateInt'] = time();
        

        if($this->clientID != null) {

            $admin = Load::controller('admin');
            if(empty($data['sameID'])){
                $query = "SELECT COALESCE((SELECT MAX(sameID) + 1 FROM sms_reports_tb), 1) AS sameID";
                $result = $admin->ConectDbClient($query, $this->clientID, 'Select', '', '', '');
                $data['sameID'] = $result['sameID'];
            }
            $admin->ConectDbClient('', $this->clientID, 'Insert', $data, 'sms_reports_tb');

        } else{
            if(empty($data['sameID'])){
                $data['sameID'] = $smsPanel->getReportNewSameID();
            }

            $Model = Load::library('Model');
            $Model->setTable('sms_reports_tb');
            $Model->insertLocal($data);
        }
    }
    #endregion

    #region checkDelivery
    public function checkDelivery($successCode)
    {

        if($this->objSmsService){

            $data['sendErrorMessage'] = $this->objSmsService->smsDeliveryCheck($successCode);
            $data['lastEditInt'] = time();

            if(!empty($data['sendErrorMessage'])) {
                if ($this->clientID != null) {

                    $admin = Load::controller('admin');
                    $admin->ConectDbClient('', $this->clientID, 'Update', $data, 'sms_reports_tb', "sendSuccessCode = '{$successCode}'");

                } else {

                    $condition = "sendSuccessCode = '{$successCode}'";
                    $Model = Load::library('Model');
                    $Model->setTable('sms_reports_tb');
                    $Model->update($data, $condition);
                }
            }
        }
    }
    #endregion

    public function smsByPattern( $patternCode, $mobiles = [], $patternVariables = [] ) {

        if($this->objSmsService){
            $this->objSmsService->smsByPattern($patternCode,$mobiles,$patternVariables);

        }
    }
}