<?php

//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');

/**
 * Class apiLocal
 * @property apiLocal $apiLocal
 */
class apiLocal extends clientAuth
{
    #region variable

    public $url = '';
    public $data = '';
    public $apiAddress = '';
    public $email = '';
    public $username = '';
    public $password = '';
    private $key_tabadol = "";
    public $factor_num = "";
    public $typeRequest = "";
    public $IsLogin = "";
    public $userPishro = "";
    public $ApiId = "";
    public $FlagTest = "";
    public $UniqueCode = ""; //give of Api
    public $CountTicketOfSource = "";
    public $CounterId = "";


    #endregion
    #region __construct()

    public function __construct()
    {
        parent::__construct();

        $InfoSources = parent::ticketFlightAuth();
        if (!empty($InfoSources)):
            $this->username = $InfoSources['Username'];
        endif;

        $this->apiAddress = functions::UrlSource();
//        $this->apiAddress = 'https://safar360.com/Core/V-1/';


        $this->IsLogin = Session::IsLogin();
        $this->CounterId = Session::getUserId();
    }

    #endregion
    #region curlExecution

    public function curlExecution($url, $data, $flag = NULL)
    {
        /**
         * This function execute curl with a url & datas
         * @param $url string
         * @param $data an associative array of elements
         * @return json decoded output
         */
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        if ($flag == 'yes') {
            curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        } else if ($flag == 'balance') {
            curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        }
        $result = curl_exec($handle);
        return json_decode($result, true);
    }

    #endregion
    #region curlExecution_Get

    public function curlExecution_Get($url, $data)
    {

        /**
         * This function execute curl with a url & datas
         * @param $url string
         * @param $data an associative array of elements
         * @return jason decoded output
         */
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_HTTPGET, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_HTTPGET, $data);
        $result = curl_exec($handle);
        return json_decode($result, true);
    }

    #endregion
    #region UniqueCode

    public function UniqueCodeOfSourceFive($userName)
    {

        error_log('first UniqueCodeOfSourceFive : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');
        $url = $this->apiAddress . "Flight/GetCode/" . $userName;
        $JsonArray = array();
        $tickets = $this->curlExecution($url, $JsonArray, 'yes');
        error_log('End UniqueCodeOfSourceFive : ' . date('Y/m/d H:i:s') . " \n", 3, LOGS_DIR . 'log_Request_send_search.txt');
        return $tickets['Result']['Value'];

    }

    #endregion

    #region getTicket

    /**
     * @param $adult int between 1 to 9
     * @param $child int between 0 to 9 and $child <= (9 - $adult)
     * @param $infant int between 0 to 9 and $infant <= $adult
     * @param $class char contains Y as economy or (C or B) as business
     * @param $origin array of airport code (iata)
     * @param $destination array of airport code (iata)
     * @param $date array of gregorian date format YYYY-MM-DD
     * @param $foreign detected locality
     * @param $page
     * @param $count
     * @param null $returnDate
     * @return false|string
     * @internal param array $apiID of which api to run
     */

    public function getTicket($adult, $child, $infant, $class, $origin, $destination, $date, $foreign, $page, $count, $returnDate = null)
    {

        $FileLog = ($foreign == 'international') ? 'log_Request_send_search_Foreign' : 'log_Request_send_search';
//        $CashResult = Load::controller('cashResultSearchFlight');

        functions::insertLog('first getTicket   : ', $FileLog);

        $this->data = $origin . '/' . $destination . '/' . $date;
        $this->UniqueCode = $this->UniqueCodeOfSourceFive($this->username);
        $url = $this->apiAddress . "Flight/Search/" . $this->UniqueCode;

//        echo '<br/><span style="opacity:0;"> '.$url.'</span><br/>';
        $d['Adult'] = (is_numeric($adult) && !empty($adult) && $adult > 0) ? $adult : '1';
        $d['Child'] = (is_numeric($child) && !empty($child) && $child > 0) ? $child : '0';
        $d['Infant'] = (is_numeric($infant) && !empty($infant) && $infant > 0) ? $infant : '0';
        $d['Origin'] =$origin;
        $d['Destination'] = $destination;
        $d['DepartureDate'] = $date;
        $d['ArrivalDate'] = ($foreign == 'international') ? $returnDate : '';
        $d['UserName'] = $this->username;
        $d['IsInternal'] = ($foreign == 'international') ? false : true;
        $d['Page'] = ($foreign == 'international') ? $page : "1";
        $d['Count'] = ($foreign == 'international') ? $count : "120";


        ($foreign == 'international') ? defined('ISFOREIGN') or define('ISFOREIGN', 'international') : '';
        $JsonArray = json_encode($d);
        functions::insertLog('give time send request With Code =>' . $this->UniqueCode . ' && Origin:' . $origin . ' &&destination:' . $destination . ' in time: ', $FileLog);

        $searchTicket = $this->curlExecution($url, $JsonArray, 'yes');
        $FinalListSearchTicket = (isset($searchTicket['Flights']) && !empty($searchTicket['Flights']) ? $searchTicket['Flights'] : array());

//        echo json_encode($FinalListSearchTicket);

        functions::insertLog('give time receive response   : ', $FileLog);

//        if (!empty($FinalListSearchTicket) && $d['IsInternal'] == true) {
//            $CashResult->ProgressCashFlight ($origin, $destination, $date, $this->UniqueCode, json_encode ($FinalListSearchTicket));
//        }

//        functions::insertLog('give time next of insert cash: ', $FileLog);

        foreach ($FinalListSearchTicket as $key => $List) {

            if ($foreign == 'international') {
                if ($List['Capacity'] > 0) {
                    $tickets[$key] = $List;
                }
            } else {
                $tickets[$key] = $List;
            }

        }

        $this->CountTicketOfSource = $searchTicket['ResultCount'];

        if (!empty($tickets)) {
            $tickets = $this->progressTicket($tickets, $foreign, $returnDate);
            if ($foreign == 'international') {
                return  $this->fileTicketForeign($tickets) ;
            } else {
                return $tickets;
            }
        }

        return false;
    }

    #endregion


    #region progressTicket

    private function progressTicket($tickets, $type, $returnDate = null)
    {
        if (empty($returnDate) || $type != 'international') {
            foreach ($tickets as $key => $ticket) {
                $dateArrival = explode('T', $ticket['OutputRoutes'][0]['DepartureDate']);
                $miladidate = explode('-', $dateArrival[0]);

                $datePersian = dateTimeSetting::gregorian_to_jalali($miladidate[0], $miladidate[1], $miladidate[2], '/');

                $FlightType = strtolower($ticket['FlightType']) == 'system' ? 'system' : 'charter';


                $tickets[$key]['AdtPrice'] = $this->ShowPriceTicket($FlightType, $ticket['PassengerDatas'][0]['TotalPrice'], $ticket['SourceId']);
                $tickets[$key]['ChdPrice'] = $this->ShowPriceTicket($FlightType, $ticket['PassengerDatas'][1]['TotalPrice'], $ticket['SourceId']);
                $tickets[$key]['InfPrice'] = $this->ShowPriceTicket($FlightType, $ticket['PassengerDatas'][2]['TotalPrice'], $ticket['SourceId']);
                $tickets[$key]['BasPriceOriginAdt'] =  functions::convert_toman_rial($ticket['PassengerDatas'][0]['BasePrice']);
                $tickets[$key]['TaxPriceOriginAdt'] =  functions::convert_toman_rial($ticket['PassengerDatas'][0]['TaxPrice']);
                $tickets[$key]['CommissionPriceAdt'] = functions::convert_toman_rial($ticket['PassengerDatas'][0]['CommisionPrice']);
                $tickets[$key]['TotalPriceAdt'] = $ticket['PassengerDatas'][0]['TotalPrice'];
                $tickets[$key]['TotalSource'] = $ticket['PassengerDatas'][0]['TotalFare'];
                $tickets[$key]['OriginalSource'] = $ticket['PassengerDatas'][0]['OriginalFare'];
                $tickets[$key]['UniqueCode'] = $this->UniqueCode;


                $filter_sort['AdtPrice'][$key] = $tickets[$key]['AdtPrice'];
                $time = functions::format_hour($tickets[$key]['OutputRoutes'][0]['DepartureTime']);
                $filter_sort['DepartureTime'][$key] = str_replace(':', '', $time);
                if (!empty($filter_sort)) {
                    array_multisort($filter_sort['AdtPrice'], SORT_ASC, $filter_sort['DepartureTime'], SORT_ASC, $tickets);
                }
            }
        } else if ($type == 'international' && !empty($returnDate)) {

            foreach ($tickets as $key => $ticket) {
                $dateArrival = explode('T', $ticket['OutputRoutes'][0]['DepartureDate']);
                $miladidate = explode('-', $dateArrival[0]);

                $datePersian = dateTimeSetting::gregorian_to_jalali($miladidate[0], $miladidate[1], $miladidate[2], '/');

                $FlightType = strtolower($ticket['FlightType']) == 'system' ? 'system' : 'charter';

                $tickets[$key]['AdtPrice'] = $this->ShowPriceTicket($FlightType, $ticket['PassengerDatas'][0]['TotalPrice'], $ticket['SourceId']);
                $tickets[$key]['ChdPrice'] = $this->ShowPriceTicket($FlightType, $ticket['PassengerDatas'][1]['TotalPrice'], $ticket['SourceId']);
                $tickets[$key]['InfPrice'] = $this->ShowPriceTicket($FlightType, $ticket['PassengerDatas'][2]['TotalPrice'], $ticket['SourceId']);
                $tickets[$key]['BasPriceOriginAdt'] = $ticket['PassengerDatas'][0]['BasePrice'];
                $tickets[$key]['TaxPriceOriginAdt'] = $ticket['PassengerDatas'][0]['TaxPrice'];
                $tickets[$key]['CommissionPriceAdt'] = $ticket['PassengerDatas'][0]['CommisionPrice'];
                $tickets[$key]['UniqueCode'] = $this->UniqueCode;


                $filter_sort['AdtPrice'][$key] = $tickets[$key]['AdtPrice'];
                $time = functions::format_hour($tickets[$key]['DepartureTime']);
                $filter_sort['DepartureTime'][$key] = str_replace(':', '', $time);
                if (!empty($filter_sort)) {
                    array_multisort($filter_sort['AdtPrice'], SORT_ASC, $filter_sort['DepartureTime'], SORT_ASC, $tickets);
                }
            }

            foreach ($tickets as $key => $ticket) {
                if (!empty($ticket['ReturnRoutes'])) {

                    $ticketsFinal[] = $ticket;
                }

            }

            $tickets = $ticketsFinal;

        }

        return $tickets;
    }

    #endregion



    //region fileTicketForeign

    private function fileTicketForeign($tickets)
    {
        if (!file_exists(LOGS_DIR . 'cashFlight/' . $this->UniqueCode)) {
            mkdir(LOGS_DIR . 'cashFlight/' . $this->UniqueCode, 0777, true);
        }


        $countTicket = count($tickets);
        $countInPage = functions::CountTicketInPage();

        if ($countTicket > $countInPage) {
            $counterTicket = round(intval($countTicket) / intval($countInPage));

        } else {
            $counterTicket = '1';
        }

        if ($counterTicket > 1) {
            for ($kk = 0; $kk < $counterTicket; $kk++) {

                $countCurrentPage = ($kk) * $countInPage;
                $countNextPage = ($kk + 1) * ($countInPage);
                $FileDivision = array();
                foreach ($tickets as $keyTicket => $ticket) {
                    if ($countCurrentPage <= $keyTicket && $countNextPage > $keyTicket) {
                        $FileDivision[] = $ticket;
                    }
                }
                error_log(json_encode($FileDivision) . " \n", 3, LOGS_DIR . 'cashFlight/' . $this->UniqueCode . '/' . $kk . '.txt');
            }
        } else {
            error_log(json_encode($tickets) . " \n", 3, LOGS_DIR . 'cashFlight/' . $this->UniqueCode . '/' . '0' . '.txt');
        }


        error_log(json_encode($tickets) . " \n", 3, LOGS_DIR . 'cashFlight/' . $this->UniqueCode . '.txt');


        $dataInfoPage['countTicket'] = $countTicket;
        $dataInfoPage['UniqueCode'] = $this->UniqueCode;


        return json_encode($dataInfoPage);
    }
    //endregion


    #region Revalidate

    public function Revalidate($Param = array()){

        if (!empty($Param)) {
            $_POST = $Param;
        }


        $Model = Load::library('Model');
        $username = $this->username;
        $url = $this->apiAddress . "Flight/Revalidate/" . $_POST['UniqueCode'];


//        echo Load::plog($_POST);
        $d['UserName'] = (isset($_POST['type']) && $_POST['type']=='package') ? $_POST['UserName'] : $username;
        $d['FlightID'] = $_POST['Flight'];
        $d['ReturnFlightID'] = !empty($_POST['ReturnFlightID']) ? $_POST['ReturnFlightID'] : '';
        $d['AdultCount'] = (is_numeric($_POST['adt']) && !empty($_POST['adt']) && $_POST['adt'] > 0) ? $_POST['adt'] : '1';
        $d['ChildCount'] = (is_numeric($_POST['chd']) && !empty($_POST['chd']) && $_POST['chd'] > 0) ? $_POST['chd'] : '0';
        $d['InfantCount'] = (is_numeric($_POST['inf']) && !empty($_POST['inf']) && $_POST['inf'] > 0) ? $_POST['inf'] : '0';
        $d['SourceId'] = $_POST['SourceId'];

        $data_json = json_encode($d);
        $Revalidate = $this->curlExecution($url, $data_json, 'yes');


        error_log('try show result Request Client AND Response in  method Revalidate in : ' . date('Y/m/d H:i:s') . 'url'. $url .' with request Number=>'.$_POST['UniqueCode'].'  array equal in => : ' . $data_json . " \n" . json_encode($Revalidate, true) . " \n", 3, LOGS_DIR . 'log_Request_Response_Revalidate.txt');

        if (!empty($Revalidate['Result']['Flight']['FlightID']) && $Revalidate['Result']['Flight']['PassengerDatas'][0]['BasePrice'] > 0) {

            if (isset($Revalidate['ProviderStatus']) && $Revalidate['ProviderStatus'] == 'errorProvider') {
                $MessageError = functions::ShowError($Revalidate['Messages']['errorCode']);

                $data['message'] = $Revalidate['Messages']['errorMessage'];
                $data['messageFa'] = $MessageError;
                $data['clientId'] = CLIENT_ID;
                $data['messageCode'] = $Revalidate['Messages']['errorCode'];
                $data['request_number'] = $Revalidate['Code'];
                $data['desti'] = '';
                $data['origin'] = '';
                $data['flight_number'] = '';
                $data['action'] = 'Revalidate';
                $data['creation_date_int'] = time();
                $Model->setTable('log_flight_tb');
                $Model->insertLocal($data);

                $return['result_status'] = 'Error';
                $return['result_message'] = $MessageError;
            } else {

                $is_login = Session::IsLogin();
                $is_counter = Session::getTypeUser();
                $is_counter_login = ($is_login && $is_counter == 'counter') ? true: false;
                $UserInfo = array();
//                if($is_counter_login){
                    $UserId = Session::getUserId();
                    $UserInfo = $this->getController('members')->findUser($UserId);
//                }

                if (!empty($Revalidate['Result']['SessionID']) && $Revalidate['Result']['Flight']['Reservable'] == "true") {

                    $data['FlightType'] = strtolower($Revalidate['Result']['Flight']['FlightType']) == "system" ? "system" : "charter";
                    $DepartureDate = functions::DateJalali($Revalidate['Result']['Flight']['OutputRoutes'][0]['DepartureDate']);
                    $data['Airline_IATA'] = $Revalidate['Result']['Flight']['OutputRoutes'][0]['Airline']['Code'];
                    $data['AirlineName'] = $Revalidate['Result']['Flight']['OutputRoutes'][0]['Airline']['Name'];
                    $data['CurrencyCode'] = Session::getCurrency();
                    $data['IsInternalFlight'] = ($Revalidate['Result']['IsInternal'] == true) ? '1' : '0';
                    $data['SourceID'] = $Revalidate['Result']['SourceId'];
                    $type_zone = functions::getTypeZone($data['IsInternalFlight']) ;

                    if($data['SourceID']=='14'){
                        $search_prices = $this->getModel('searchPricesModel')->get()->where('client_id',CLIENT_ID)->where('request_number',$_POST['UniqueCode'])->find();
                        if($search_prices){
                            $client_id = CLIENT_ID ;
                            $condition_update_search_prices = "client_id='{$client_id}' AND  request_number='{$_POST['UniqueCode']}'";
                            $data_search_prices_update['flight_id_selected'] =  $_POST['Flight'] ;
                            $this->getModel('searchPricesModel')->update($data_search_prices_update,$condition_update_search_prices);
                        }

                    }
                    /* This is to get information to check private or public pid */
                    $data_check_pid['airline_iata'] = $data['Airline_IATA'] ;
                    $data_check_pid['flight_type']  = $data['FlightType'] ;
                    $data_check_pid['is_internal']  = $data['IsInternalFlight'];
                    $data_check_pid['source_id']    = $data['SourceID'];
                    $check_status_pid = $this->getController('configFlight')->checkConfigStatusSpecificAirline($data_check_pid);

                    $data_info_discount_user['counter_id']= !empty($UserInfo) ? $UserInfo['fk_counter_type_id']: '5';
                    $data_info_discount_user['service_title']= functions::TypeService($data['FlightType'],$type_zone,$check_status_pid,$check_status_pid, $data['Airline_IATA']);

//                    if($is_counter_login){
                        $discount_this_user = $this->getController('servicesDiscount')->getSpecificDiscountUser($data_info_discount_user);
//                    }

                    $data['discount_amount'] = !empty($discount_this_user) ? $discount_this_user['off_percent'] : '';
                    $data['service_title'] =  $data_info_discount_user['service_title'];

                    $arraySourceIncreasePriceFlightSystem = functions::sourceIncreasePriceFlightSystem();

                    $data['Adt_qty'] = $d['AdultCount'];
                    $data['Chd_qty'] = $d['ChildCount'];
                    $data['Inf_qty'] = $d['InfantCount'];



                    if($_POST['MultiWay']=='multi_destination')
                    {
                        $data['Direction'] = 'multi_destination';
                    }else{
                        $isInternalFlight = $data['IsInternalFlight'] == '1';
                        $hasReturnRoutes = !empty($Revalidate['Result']['Flight']['ReturnRoutes']);
                        $isTestServer = functions::isTestServer();

                        $isPackageType = isset($_POST['type']) && $_POST['type'] == 'package';


                        if (!$isInternalFlight && $hasReturnRoutes && !$isPackageType) {
                            $data['Direction'] = 'TwoWay';
                        }else if($isPackageType){
                            $data['Direction'] = 'TwoWay';
                        } elseif ($isInternalFlight && $hasReturnRoutes && $isTestServer) {
                            $data['Direction'] = 'TwoWay';
                        } else {
                            $data['Direction'] = $_POST['FlightDirection'];
                        }
                    }

                    foreach ($Revalidate['Result']['Flight']['PassengerDatas'] as $PassengersPrice) {
                        if ($data['Adt_qty'] > 0 && $PassengersPrice['PassengerType'] == 'ADT') {
                            $data['AdtPrice'] = $this->ShowPriceTicket($data['FlightType'], $PassengersPrice['TotalPrice'], $Revalidate['Result']['SourceId']);
                            $data['AdtFare'] =  $this->ShowPriceTicket($data['FlightType'], $PassengersPrice['BasePrice'], $Revalidate['Result']['SourceId']);
                            $data['AdtTax'] =   $this->ShowPriceTicket($data['FlightType'], $PassengersPrice['TaxPrice'], $Revalidate['Result']['SourceId']);
                            $data['AdtCom'] =   $this->ShowPriceTicket($data['FlightType'], $PassengersPrice['CommisionPrice'], $Revalidate['Result']['SourceId']);
                        }
                        if ($data['Chd_qty'] > 0 && $PassengersPrice['PassengerType'] == 'CHD') {
                            $data['ChdPrice'] = ($PassengersPrice['TotalPrice'] > 0) ? $this->ShowPriceTicket($data['FlightType'], $PassengersPrice['TotalPrice'], $Revalidate['Result']['SourceId']) : 0;
                            $data['ChdFare'] =  ($PassengersPrice['BasePrice'] > 0) ? $this->ShowPriceTicket($data['FlightType'], $PassengersPrice['BasePrice'], $Revalidate['Result']['SourceId']) : 0;
                            $data['ChdTax'] =   ($PassengersPrice['TaxPrice'] > 0) ? $this->ShowPriceTicket($data['FlightType'], $PassengersPrice['TaxPrice'], $Revalidate['Result']['SourceId']) : 0;
                            $data['ChdCom'] =   ($PassengersPrice['CommisionPrice'] > 0) ? $this->ShowPriceTicket($data['FlightType'], $PassengersPrice['CommisionPrice'], $Revalidate['Result']['SourceId']) : 0;
                        }
                        if ($data['Inf_qty'] > 0 && $PassengersPrice['PassengerType'] == 'INF') {
                            $data['InfPrice'] =  ($PassengersPrice['TotalPrice'] > 0) ? $this->ShowPriceTicket($data['FlightType'], $PassengersPrice['TotalPrice'], $Revalidate['Result']['SourceId']) : 0;
                            $data['InfFare'] =   ($PassengersPrice['BasePrice'] > 0) ? $this->ShowPriceTicket($data['FlightType'], $PassengersPrice['BasePrice'], $Revalidate['Result']['SourceId']) : 0;
                            $data['InfTax'] =    ($PassengersPrice['TaxPrice'] > 0) ? $this->ShowPriceTicket($data['FlightType'], $PassengersPrice['TaxPrice'], $Revalidate['Result']['SourceId']) : 0;
                            $data['InfCom'] =    ($PassengersPrice['CommisionPrice'] > 0) ? $this->ShowPriceTicket($data['FlightType'], $PassengersPrice['CommisionPrice'], $Revalidate['Result']['SourceId']) : 0;
                        }
                    }

                    $data['SupplierName'] = $Revalidate['Result']['Flight']['Supplier']['Name'];
                    $data['Description'] = $Revalidate['Result']['Flight']['Description'];
                    $data['SeatClass'] = $Revalidate['Result']['Flight']['SeatClass'];
                    $data['CabinType'] = $Revalidate['Result']['Flight']['OutputRoutes'][0]['CabinType'];
                    $data['SubSystem'] = "";
                    $data['Capacity'] = !empty($Revalidate['Result']['Flight']['Capacity']) ? $Revalidate['Result']['Flight']['Capacity'] : 0;

                    $data['SourceName'] = isset($Revalidate['Result']['SourceName']) ? $Revalidate['Result']['SourceName']: '';


                    $data['LinkCaptcha'] = ($d['SourceId']=='16')? json_encode(['dept'=>urldecode($Revalidate['Result']['ImportantLink']),'return'=>urldecode($Revalidate['Result']['ImportantLinkRetuen'])]) : urldecode($Revalidate['Result']['ImportantLink']);


                    if ($_POST['FlightDirection'] == 'dept' || (isset($_POST['type']) && $_POST['type']=='package')) {
                        $uniqueID = microtime(TRUE);
                        $data['uniq_id'] = str_replace('.', '', $uniqueID);
                    } else {
                        $data['uniq_id'] = $_POST['uniq_id'];
                    }
                    $data['token_session'] = $Revalidate['Result']['SessionID'] . '-' . $data['uniq_id'];

                    // this is only for internal flight
                    if ($data['IsInternalFlight'] == '1') {
                        $data['Date'] = str_replace('-', '/', functions::DateJalali($Revalidate['Result']['Flight']['OutputRoutes'][0]['DepartureDate']));
                        $data['Time'] = $Revalidate['Result']['Flight']['OutputRoutes'][0]['DepartureTime'];
                        $data['OriginAirportIata'] = $Revalidate['Result']['Flight']['OutputRoutes'][0]['Departure']['Code'];
                        $data['OriginCity'] = functions::NameCity($Revalidate['Result']['Flight']['OutputRoutes'][0]['Departure']['Code']);
                        $data['DestiAirportIata'] = $Revalidate['Result']['Flight']['OutputRoutes'][0]['Arrival']['Code'];
                        $data['DestiCity'] = functions::NameCity($Revalidate['Result']['Flight']['OutputRoutes'][0]['Arrival']['Code']);
                        $data['AircraftCode'] = !empty($Revalidate['Result']['Flight']['OutputRoutes'][0]['Aircraft']['Manufacturer']) ? $Revalidate['Result']['Flight']['OutputRoutes'][0]['Aircraft']['Manufacturer'] : '';
                        $data['FlightNo'] = $Revalidate['Result']['Flight']['OutputRoutes'][0]['FlightNo'];
                    }

//                      this condition is for charter internal flight and parto internal system flight and all of the kind international flight
                    if ($data['FlightType'] == 'charter'|| ($data['IsInternalFlight'] == '0' &&  $data['SourceID'] !='8' &&  $data['SourceID'] !='16') || ($data['FlightType'] == 'system' && in_array($Revalidate['Result']['SourceId'],$arraySourceIncreasePriceFlightSystem))) {
                        $data_info_change_price['counter_id'] = !empty($UserInfo) ? $UserInfo['fk_counter_type_id']: '5';
                        $data_info_change_price['airline_iata'] = $data['Airline_IATA'];
                        $data_info_change_price['locality'] = ($data['IsInternalFlight'] == '1' ? 'local' : 'international');
                        $data_info_change_price['flight_type'] = $data['FlightType'] ;

                        $priceChanges = $this->getController('priceChanges')->getChangePriceByCounterAndAirline($data_info_change_price);

                        $data['PriceChange'] = $priceChanges['price'];
                        $data['PriceChangeType'] = $priceChanges['change_type'];
                    }

                    $data = $this->getController('commissionSources')->sourceCommissionCalculation($data , 'revalidate');
                    $data = $this->getController('commissionSources')->setAgencyBenefitSystemFlight($data , 'revalidate');



                    $Model->setTable('temporary_local_tb');
                    $res = $Model->insertLocal($data);

                    if ($res) {
                        if ($data['IsInternalFlight'] == '0' || (isset($_POST['type']) && $_POST['type']=='package') || ($data['IsInternalFlight'] == '1' &&  $data['Direction'] == 'TwoWay' && $isTestServer)) {
                            $temporaryId = $Model->getLastId();
                            foreach ($Revalidate['Result']['Flight']['OutputRoutes'] as $Route) {
                                $dataTemporary['Date'] = str_replace('-', '/', functions::DateJalali($Route['DepartureDate']));
                                $dataTemporary['Time'] = $Route['DepartureTime'];
                                $dataTemporary['OriginAirportIata'] = $Route['Departure']['Code'];
                                if ($isInternalFlight && $hasReturnRoutes && $isTestServer){
                                    $DepartureCity = functions::NameCity($Revalidate['Result']['Flight']['OutputRoutes'][0]['Departure']['Code']);
                                }else{
                                    $DepartureCity = functions::NameCityForeign($Route['Departure']['Code']);
                                }
                                $dataTemporary['OriginCity'] = $DepartureCity['DepartureCityFa'];
                                $dataTemporary['DestiAirportIata'] = $Route['Arrival']['Code'];


                                if ($isInternalFlight && $hasReturnRoutes && $isTestServer){
                                    $ArrivalCity = functions::NameCity($Revalidate['Result']['Flight']['OutputRoutes'][0]['Departure']['Code']);
                                }else{
                                    $ArrivalCity = functions::NameCityForeign($Route['Arrival']['Code']);
                                }

                                $dataTemporary['DestiCity'] = $ArrivalCity['DepartureCityFa'];
                                $dataTemporary['Airline_IATA'] = $Route['Airline']['Code'];
                                $dataTemporary['AirlineName'] = functions::AirlineName($Route['Airline']['Code']);
                                $dataTemporary['AircraftName'] = !empty($Route['Aircraft']['Manufacturer']) ? $Route['Aircraft']['Manufacturer'] : 'نامشخص';
                                $dataTemporary['FlightNumber'] = $Route['FlightNo'];
                                $dataTemporary['Transit'] = substr($Route['Transit'], 0, 7);
                                $dataTemporary['LongTime'] = substr($Route['FlightTime'], 0, 7);
                                $dataTemporary['ArrivalDate'] = $Route['ArrivalDate'];
                                $dataTemporary['ArrivalTime'] = $Route['ArrivalTime'];
                                $dataTemporary['Baggage'] = !empty($Route['Baggage']) ? $Route['Baggage'][0]['Charge'] : '0';
                                $dataTemporary['BaggageType'] = !empty($Route['Baggage']) ? $Route['Baggage'][0]['Code'] : '0';
                                $dataTemporary['AllowanceAmount'] = !empty($Route['Baggage']) ? $Route['Baggage'][0]['allowanceAmount'] : '0';
                                $dataTemporary['TemporaryId'] = $temporaryId;
                                $dataTemporary['TypeRoute'] = 'Dept';
                                $dataTemporary['TotalLongTime'] = substr($Revalidate['Result']['Flight']['TotalOutputFlightDuration'], 0, 7);
                                $dataTemporary['TotalTransitTime'] = substr($Revalidate['Result']['Flight']['TotalOutputStopDuration'], 0, 7);


                                $Model->setTable('temporary_routes_tb');
                                $Model->insertLocal($dataTemporary);
                            }


                            if (!empty($Revalidate['Result']['Flight']['ReturnRoutes'])) {
                                foreach ($Revalidate['Result']['Flight']['ReturnRoutes'] as $Route) {
                                    $dataTemporaryReturn['Date'] = str_replace('-', '/', functions::DateJalali($Route['DepartureDate']));
                                    $dataTemporaryReturn['Time'] = $Route['DepartureTime'];
                                    $dataTemporaryReturn['OriginAirportIata'] = $Route['Departure']['Code'];
                                    $DepartureCityReturn = functions::NameCityForeign($Route['Departure']['Code']);
                                    $dataTemporaryReturn['OriginCity'] = $DepartureCityReturn['DepartureCityFa'];
                                    $dataTemporaryReturn['DestiAirportIata'] = $Route['Arrival']['Code'];
                                    $ArrivalCityReturn = functions::NameCityForeign($Route['Arrival']['Code']);
                                    $dataTemporaryReturn['DestiCity'] = $ArrivalCityReturn['DepartureCityFa'];
                                    $dataTemporaryReturn['Airline_IATA'] = $Route['Airline']['Code'];
                                    $dataTemporaryReturn['AirlineName'] = functions::AirlineName($Route['Airline']['Code']);
                                    $dataTemporaryReturn['AircraftName'] = !empty($Route['Aircraft']['Manufacturer']) ? $Route['Aircraft']['Manufacturer'] : 'نامشخص';
                                    $dataTemporaryReturn['FlightNumber'] = $Route['FlightNo'];
                                    $dataTemporaryReturn['Transit'] = substr($Route['Transit'], 0, 7);
                                    $dataTemporaryReturn['LongTime'] = substr($Route['FlightTime'], 0, 7);
                                    $dataTemporaryReturn['ArrivalDate'] = $Route['ArrivalDate'];
                                    $dataTemporaryReturn['ArrivalTime'] = $Route['ArrivalTime'];
                                    $dataTemporaryReturn['Baggage'] = $Route['Baggage'][0]['Charge'];
                                    $dataTemporaryReturn['BaggageType'] = $Route['Baggage'][0]['Code'];
                                    $dataTemporaryReturn['AllowanceAmount'] = !empty($Route['Baggage']) ? $Route['Baggage'][0]['allowanceAmount'] : '0';
                                    $dataTemporaryReturn['TemporaryId'] = $temporaryId;
                                    $dataTemporaryReturn['TypeRoute'] = 'Return';
                                    $dataTemporaryReturn['TotalLongTime'] = substr($Revalidate['Result']['Flight']['TotalReturnFlightDuration'], 0, 7);
                                    $dataTemporaryReturn['TotalTransitTime'] = substr($Revalidate['Result']['Flight']['TotalReturnStopDuration'], 0, 7);

                                    $Model->setTable('temporary_routes_tb');
                                    $Model->insertLocal($dataTemporaryReturn);
                                }
                            }
                        }



                        $selectedTicket = '';
                        $arrivalDeptTime = '';


                        if ($is_counter_login) {

                            $return['result_status'] = 'SuccessLogged';
                            $return['result_uniq_id'] = $data['uniq_id'];
                            $return['result_source_id'] = ((isset($d['SourceId']) && $d['SourceId'] > 0) ? $d['SourceId'] : 'No');
                            $return['result_selected_ticket'] = $selectedTicket;
                            $return['result_selected_time'] = $arrivalDeptTime;

                        } else {

                            $return['result_status'] = 'SuccessNotLoggedIn';
                            $return['result_uniq_id'] = $data['uniq_id'];
                            $return['result_source_id'] = ((isset($d['SourceId']) && $d['SourceId'] > 0) ? $d['SourceId'] : 'No');
                            $return['result_selected_ticket'] = $selectedTicket;
                            $return['result_selected_time'] = $arrivalDeptTime;

                        }

                    } else {
                        $error = functions::Xmlinformation('NoReservable');
                        $error = $error->asXML();
                        $return['result_status'] = 'Error';
                        $return['result_message'] = $error;

                    }
                } else {
                    $error = functions::Xmlinformation('NoReservable');
                    $error = $error->asXML();
                    $return['result_status'] = 'Error';
                    $return['result_message'] = $error;
                }
            }
        } else {

            $MessageError = functions::ShowError($Revalidate['Messages']['errorCode']);

            $data['message'] = $Revalidate['Messages']['errorMessage'];
            $data['messageFa'] = $MessageError;
            $data['clientId'] = CLIENT_ID;
            $data['messageCode'] = $Revalidate['Messages']['errorCode'];
            $data['request_number'] = $Revalidate['Code'];
            $data['desti'] = '';
            $data['origin'] = '';
            $data['flight_number'] = '';
            $data['action'] = 'Revalidate';
            $data['creation_date_int'] = time();
            $Model->setTable('log_flight_tb');
            $Model->insertLocal($data);

//            $return['result_status']  = 'Error';
//            $return['result_message'] = $MessageError;
            $error = functions::Xmlinformation('NoReservable');
            $error = $error->asXML();
            $return['result_status'] = 'Error';
            $return['result_message'] = $error;
        }

        return json_encode($return);
    }

#endregion


#region selectReservationFlightDept
    public function selectReservationFlightDept($param)
    {
        $resultReservationTicket = Load::controller('resultReservationTicket');
        $data = $resultReservationTicket->infoTicket($param);
        if ($data) {

            $arrivalDeptTime = (substr($data['dept']['DestinationTime'], 0, 2) == '00' ? '24' : substr($data['dept']['DestinationTime'], 0, 2));
            $MainPriceCurrency = functions::CurrencyCalculate($data['dept']['AdtPrice'], $data['CurrencyCode']);
            if ($data['dept']['PriceWithDiscount'] != '0') {
                $PriceWithDiscount = functions::CurrencyCalculate($data['dept']['PriceWithDiscount'], $data['CurrencyCode']);
            }

            $selectedTicket = '
            <h5 class="raft-ticket"><a onclick="undoFlightSelect()"><i class="zmdi zmdi-close site-secondary-text-color"></i></a> ' . functions::Xmlinformation("TicketSelected") . ' </h5>
            <div class="international-available-box international-available-info site-main-text-color">
                
                <div class="international-available-item-right-Cell ">
                    <div class=" international-available-airlines  ">
                        <div class="international-available-airlines-logo">
                            <img height="50" width="50" src="' . functions::getAirlinePhoto($data['dept']['Airline']) . '" alt="' . $data['dept']['AirlineName'] . '" title="' . $data['dept']['AirlineName'] . '">
                        </div>

                        <div class="international-available-airlines-log-info">
                            <span class="iranB txt13">' . $data['dept']['FlightNumber'] . '</span>
                            <input type="hidden" name="selectedDeptTicketId" id="selectedDeptTicketId" value="' . $param['IdFlight'] . '" />
                        </div>
                    </div>

                    <div class="international-available-airlines-info ">
                        <div class="airlines-info txtLeft">
                            <span class="iranL txt14">' . $data['dept']['OriginCity'] . '</span>
                            <span class="iranB txt15 timeSortDep">' . functions::format_hour($data['dept']['OriginTime']) . '</span>
                            <span class="iranL txt12">' . $data['dept']['OriginDate'] . '</span>
                            <span class="iranB txt13">' . functions::Xmlinformation("Classrate") . ' ' . $data['dept']['CabinType'] . '</span>
                        </div>

                        <div class="airlines-info ">
                            <span>---------------------</span>
                            <span>---------------------</span>
                            <span>---------------------</span>
                            <span>---------------------</span>
                        </div>

                        <div class="airlines-info txtRight">
                            <span class="iranL txt14">' . $data['dept']['DestinationCity'] . '</span>
                            <span class="iranB txt15">' . $data['dept']['DestinationTime'] . '</span>
                            <span class="iranL txt12">' . $data['dept']['DestinationDate'] . '</span>
                            <span class="iranB txt13">' . functions::Xmlinformation("CharterType") . '</span>
                        </div>
                    </div>
                </div>
                
                <div class="international-available-item-left-Cell">
                    <div class="inner-avlbl-itm ' . ($data['dept']['PriceWithDiscount'] != '0' ? 'off-price' : '') . '">
                        <span class="iranL  priceSortAdt">
                        ' . ($data['dept']['PriceWithDiscount'] != '0' ? '
                            <span class="iranB old-price text-decoration-line CurrencyCal" data-amount="' . $data['dept']['AdtPrice'] . '">' . functions::numberFormat($MainPriceCurrency['AmountCurrency']) . '</span>
                            <i class="iranB site-main-text-color-drck CurrencyCal" data-amount="' . $data['dept']['PriceWithDiscount'] . '">' . functions::numberFormat($PriceWithDiscount['AmountCurrency']) . '</i> <span class="CurrencyText">' . $PriceWithDiscount['TypeCurrency'] . '</span>
                        ' : '
                            <i class="iranB site-main-text-color-drck CurrencyCal" data-amount="' . $data['dept']['AdtPrice'] . '">' . functions::numberFormat($MainPriceCurrency['AmountCurrency']) . '</i> <span class="CurrencyText">' . $MainPriceCurrency['TypeCurrency'] . '</span>
                        ') . '
                        </span>
                    </div>
                </div>
                
            </div>
            <h5 class="bargasht-ticket">' . functions::Xmlinformation("SelectReturnTicket") . '</h5>
            ';

            $return['result_status'] = 'SuccessTicket';
            $return['result_selected_ticket'] = $selectedTicket;
            $return['result_selected_time'] = $arrivalDeptTime;

        } else {
            $return['result_status'] = 'Error';
            $return['result_message'] = functions::Xmlinformation('NoReservable');
        }

        return json_encode($return);

    }
#endregion


#region registerPassengerOnline

    public function registerPassengerOnline()
    {
        $login_user = Session::IsLogin();
        $members_model = Load::model('members');


        if ($login_user) {
            $IdMember = $_SESSION["userId"];
            echo 'success:' . $IdMember;
        } else {
            $data['mobile'] = $_POST['mobile'];
            $data['telephone'] = $_POST['telephone'];
            $data['email'] = $_POST['Email'];
            $data['user_name'] = $_POST['mobile'];
            $data['password'] = $members_model->encryptPassword($_POST['mobile']);
            $data['is_member'] = '0';

            $members = $this->login_members_online($data['email']);


            if (empty($members)) {
                $insert = Load::library('Model');
                $insert->setTable("members_tb");
                $insert->insertLocal($data);
                $IdMember = $insert->getLastId();
                $_SESSION["userCostumer"] = $IdMember;
                echo 'success:' . $IdMember;
            } else {
                if ($members['is_member'] == '0'):
                    $IdMember = $members['id'];
                    $_SESSION["userCostumer"] = $IdMember;

                    echo 'success:' . $IdMember;
                else:
                    $ErrorPassengerGuest = functions::StrReplaceInXml(['@@br@@' => '<br />'], 'ErrorPassengerGuest');
                    echo 'error:' . $ErrorPassengerGuest;
                endif;
            }
        }
    }

#endregion


#region login_members_online

    public function login_members_online($email)
    {
        $Model = Load::library('Model');
        $sql = "SELECT * FROM members_tb WHERE email='{$email}'";
        return $Model->load($sql);
    }

#endregion

#region FirstBook

    /*    public function FirstBook($passenger, $id, $factor_number, $direction, $SourceId, $type = null)
        {
    //        echo Load::plog($passenger);
            $model = Load::library('Model');
            $ModelBase = Load::library('ModelBase');
    
    
            $Condition = "request_number='{$passenger['RequestNumber'][$direction]}'";
    
    
            $model->setTable("book_local_tb");
            unset($d['remote_addr']);
            unset($d['client_id']);
            $res = $model->update($d, $Condition);
            $d['remote_addr'] = $_SERVER['REMOTE_ADDR'];
            $d['client_id'] = CLIENT_ID;
            $ModelBase->setTable("report_tb");
            $ModelBase->update($d, $Condition);
    
    
        }*/

#endregion

#region PreReserveFlight

    public function PreReserveFlight($s_id, $direction, $factor_number){

        $params = array();


        if (isset($_POST['type']) && $_POST['type'] == 'App') {
            $params = json_decode($_POST['dataForm'], true);
        } else {
            parse_str($_POST['dataForm'], $params);
        }



        $currency_code = Session::getCurrency() ;
        $model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $passengerController = Load::controller('passengers');
        $s_id = functions::checkParamsInput($s_id);
        $ExplodeSessionID = explode('-', $s_id);

        $BookExist = functions::findTicket($ExplodeSessionID[0]);

        if (empty($BookExist)) {
//            $sourceIdPrivate = functions::SourceIdPrivate();
            $url = $this->apiAddress . "Flight/PreReserve/" . $ExplodeSessionID[0];

            $emptyArray = array();

            $PreReserve = $this->curlExecution($url, $emptyArray, 'yes');



            $classModel = Load::model('temporary_local');
            $records = $classModel->get($ExplodeSessionID[1]);

            error_log('try show result method PreReserve in : ' . date('Y/m/d H:i:s') . ' SessionId=>' . $s_id . ' AND array equal in => : ' . json_encode($PreReserve, true) . " \n", 3, LOGS_DIR . 'log_method_PreReserve.txt');

            if (!empty($PreReserve['Result']['Request'])) {
                $Count = count($PreReserve['Result']['Request']['OutputRoutes']);
                $index_arrival_city = ($direction=='muti_destination') ? 0 : ($Count-1);
//                $CountReturn = count($PreReserve['Result']['Request']['ReturnRoutes']);
                $isInternal = ($PreReserve['Result']['Request']['IsInternal'] == true) ? '1' : '0';
                $FlightType = ((strtolower($PreReserve['Result']['Request']['OutputRoutes'][$Count - 1]['FlightType']) == 'system') ? 'system' : 'charter');
                $AirlineIata = $PreReserve['Result']['Request']['OutputRoutes'][0]['Airline']['Code'];
                $isInternalFlight = ($isInternal == '1') ? 'internal' : 'external';
                $check_private = functions::checkConfigPid($AirlineIata, $isInternalFlight, $FlightType,$PreReserve['Result']['SourceId']);
                $TypeZone = ($isInternal == '1') ? 'Local' : 'Portal';
                if ($FlightType == 'system') {
                    $TypeTicket = '';
                } else {
                    if ($check_private == 'private') {
                        $TypeTicket = 'private';
                    } else {
                        $TypeTicket = 'public';
                    }
                }

                $service_title = functions::TypeService($FlightType, $TypeZone, $TypeTicket, $check_private, $PreReserve['Result']['Request']['OutputRoutes'][0]['Airline']['Code']);
                $d['serviceTitle'] = $service_title ;
                $d['IsInternal'] = $isInternal ;
                // get data special discount
                $data_special_discount['service_title'] = $service_title;
                $data_special_discount['pre_code'] = isset($params['Mobile_buyer']) ?  substr($params["Mobile_buyer"],0,4) :  substr($params["Mobile"],0,4);
                $data_special_discount['type_get_discount'] = 'phone';

                $special_discount_information = $this->getController('servicesDiscount')->getSpecialDiscount($data_special_discount);
                if (!empty($special_discount_information)) {
                    $data_check_usage['info_member_passenger'] = $data_special_discount['pre_code'] ;
                    $check_usage_member = $this->getController('servicesDiscount')->getSpecialDiscountUsed($data_check_usage);
                    if (empty($check_usage_member)) {
                        $d['special_discount_amount'] = !empty($special_discount_information) ? $special_discount_information['amount'] : 0;
                        $d['special_discount_type'] = !empty($special_discount_information) ? $special_discount_information['type_discount'] : null;

                        $data_usage_special_discount['info_member_passenger'] = $params["Mobile_buyer"];
                        $data_usage_special_discount['amount'] = $special_discount_information['amount'] ;
                        $data_usage_special_discount['type_amount'] =  $special_discount_information['type_discount'];
                        $data_usage_special_discount['factor_number'] =  $factor_number;
                        $data_usage_special_discount['type_buy'] =  'flight';
                        $data_usage_special_discount['status'] =  'pending';
                        $data_usage_special_discount['creation_date_int'] =  time();

                        $this->getController('servicesDiscount')->setSpecialDiscountUsed($data_usage_special_discount);
                    }

                }


                $date_flight = $PreReserve['Result']['Request']['OutputRoutes'][0]['DepartureDate'];
                $TimeFlight = $PreReserve['Result']['Request']['OutputRoutes'][0]['DepartureTime'];

                $lastIndexOutputRoutes = count($PreReserve['Result']['Request']['OutputRoutes']) - 1;
                $date_flight_arrival = $PreReserve['Result']['Request']['OutputRoutes'][$lastIndexOutputRoutes]['ArrivalDate'];
                $TimeFlightArrival = $PreReserve['Result']['Request']['OutputRoutes'][$lastIndexOutputRoutes]['ArrivalTime'];

                if (Session::IsLogin()) {
                    $userId = Session::getUserId();
                } else {
                    $userId = $params['IdMember'];
                }

                $user =    $this->getModel('membersModel')->getMemberById($userId);
                if(empty($user['email'])){
                    $data_update_user['email'] = $params['Email_buyer'] ;
                    $this->getModel('membersModel')->updateMember($data_update_user,$user['id']);
                }
                $checkSubAgency =  functions::checkExistSubAgency() ;
                if ($user['fk_agency_id'] > 0 || $checkSubAgency) {
                    $agencyId = ($checkSubAgency) ? SUB_AGENCY_ID : $user['fk_agency_id'] ;
                    $sql_agency = " SELECT * FROM agency_tb WHERE id='{$agencyId}'";
                    $agency = $model->load($sql_agency);
                    $d['agency_id'] = $agency['id'];
                    $d['agency_name'] = $agency['name_fa'];
                    $d['agency_accountant'] = $agency['accountant'];
                    $d['agency_manager'] = $agency['manager'];
                    $d['agency_mobile'] = $agency['mobile'];
                }

                if (ISCURRENCY && $currency_code > 0) {
                    /** @var currencyEquivalent $Currency */
                    $Currency = Load::controller('currencyEquivalent');
                    $InfoCurrency = $Currency->InfoCurrency($currency_code);
                }

                $d['supplier_address'] = isset($PreReserve['Result']['Supplier']) ? $PreReserve['Result']['Supplier']['Address'] : '';

                $i = 1;

                if(isset($params['genderA' . $i]))
                {
                    while ($params['genderA' . $i]) {

                        if (!empty($params['birthdayA' . $i])) {
                            $explode_br_fa = explode('-', $params['birthdayA' . $i]);
                            $date_miladi = dateTimeSetting::jalali_to_gregorian($explode_br_fa[0], $explode_br_fa[1], $explode_br_fa[2], '-');
                        }

                        $d['origin_city'] = functions::NameCity(strtoupper($PreReserve['Result']['Request']['OutputRoutes'][0]['Departure']['Code']));
                        $d['desti_city'] = functions::NameCity(strtoupper($PreReserve['Result']['Request']['OutputRoutes'][$index_arrival_city]['Arrival']['Code']));
                        $d['origin_airport_iata'] = strtoupper($PreReserve['Result']['Request']['OutputRoutes'][0]['Departure']['Code']);
                        $d['desti_airport_iata'] = strtoupper($PreReserve['Result']['Request']['OutputRoutes'][$index_arrival_city]['Arrival']['Code']);
                        $d['date_flight'] = $date_flight;
                        $d['time_flight'] = $TimeFlight;
                        $d['date_flight_arrival'] = $date_flight_arrival;
                        $d['time_flight_arrival'] = $TimeFlightArrival;
                        $d['flight_type'] = $FlightType;
                        $d['flight_number'] = $PreReserve['Result']['Request']['OutputRoutes'][0]['FlightNo'];
                        $d['airline_iata'] = $PreReserve['Result']['Request']['OutputRoutes'][0]['Airline']['Code'];
                        $d['airline_name'] = (!empty($PreReserve['Result']['Request']['OutputRoutes'][0]['Airline']['Name'])) ? $PreReserve['Result']['Request']['OutputRoutes'][0]['Airline']['Name'] : '';
                        $d['seat_class'] = !empty($PreReserve['Result']['Request']['OutputRoutes'][0]['SeatClass']) ? $PreReserve['Result']['Request']['OutputRoutes'][0]['SeatClass'] : "";
                        $d['cabin_type'] = $PreReserve['Result']['Request']['OutputRoutes'][0]['CabinType'];
                        $d['IsInternal'] = $isInternal;
                        $d['api_id'] = $PreReserve['Result']['SourceId'];
                        if ($check_private == 'private') {
                            $d['pid_private'] = '1';
                        } else {
                            $d['pid_private'] = '0';
                        }
                        $d['factor_number'] = $factor_number;
                        $d['member_id'] = $user['id'];
                        $d['member_name'] = $user['name'] . ' ' . $user['family'];
                        $d['member_email'] = $user['email'];
                        $d['member_mobile'] = $user['mobile'];
                        $d['member_phone'] = $user['telephone'];
                        $d['direction'] = $direction;
                        $d['creation_date'] = date('Y-m-d');
                        $d['creation_date_int'] = time();
                        $d['passenger_gender'] = $params['genderA' . $i];
                        $d['passenger_name'] = $params['nameFaA' . $i];
                        $d['passenger_family'] = $params['familyFaA' . $i];
                        $d['passenger_name_en'] = $params['nameEnA' . $i];
                        $d['passenger_family_en'] = $params['familyEnA' . $i];
                        $d['passenger_birthday'] = $params['birthdayA' . $i];
                        $d['passportCountry'] = !empty($params['passportCountryA' . $i]) ? $params['passportCountryA' . $i] : 'IRN';
                        $d['passportNumber'] = $params['passportNumberA' . $i];
                        $d['passportExpire'] = $params['passportExpireA' . $i];
                        $d['mobile_buyer'] = isset($params["Mobile_buyer"]) ? $params["Mobile_buyer"] : $params["Mobile"];
                        $d['email_buyer'] = isset($params["Email_buyer"]) ? $params["Email_buyer"] : $params["Email"];
                        if ($params["passengerNationalityA" . $i] == '1' || ($isInternal == '0' && $params["passengerNationalityA" . $i] == '1') || (SOFTWARE_LANG !='fa')) {
                            $d['passenger_birthday_en'] = $params['birthdayEnA' . $i];
                        }else{
                            $d['passenger_birthday_en'] = $date_miladi;
                        }
                        $d['passenger_national_code'] = !empty($params['NationalCodeA' . $i]) ? $params['NationalCodeA' . $i] : '0000000000';

                        if(empty($special_discount_information) && !empty($params['NationalCodeA' . $i])){
                            $data_special_discount['type_get_discount'] = 'national_code';
                            $data_special_discount['pre_code'] = substr($params['NationalCodeA' . $i],0,3);
                            $special_discount_information_with_national_code = $this->getController('servicesDiscount')->getSpecialDiscount($data_special_discount);

                            if(!empty($special_discount_information_with_national_code))
                            {
                                $data_check_usage['info_member_passenger'] =  $data_special_discount['pre_code'] ;
                                $check_usage_member = $this->getController('servicesDiscount')->getSpecialDiscountUsed($data_special_discount);
                                if(empty($check_usage_member))
                                {
                                    $d['special_discount_amount'] = !empty($special_discount_information_with_national_code) ? $special_discount_information_with_national_code['amount']: 0;
                                    $d['special_discount_type'] = !empty($special_discount_information_with_national_code) ? $special_discount_information_with_national_code['type_discount'] : null;

                                    $data_usage_special_discount['info_member_passenger'] =$params['NationalCodeA' . $i];
                                    $data_usage_special_discount['amount'] = $special_discount_information['amount'] ;
                                    $data_usage_special_discount['type_amount'] =  $special_discount_information['type_discount'];
                                    $data_usage_special_discount['factor_number'] =  $factor_number;
                                    $data_usage_special_discount['type_buy'] =  'flight';
                                    $data_usage_special_discount['status'] =  'pending';
                                    $data_usage_special_discount['creation_date_int'] =  time();

                                    $this->getController('servicesDiscount')->setSpecialDiscountUsed($data_usage_special_discount);
                                }
                            }
                        }

                        $d['passenger_age'] = $this->type_passengers($d['passenger_birthday_en'],$d['date_flight']);
                        $d['type_app'] = (isset($_POST['type']) && $_POST['type'] == 'App') ? "Application" : "Web";
                        $d['currency_code'] = $currency_code;
                        $d['currency_equivalent'] = !empty($InfoCurrency) ? $InfoCurrency['EqAmount'] : 0;
                        $d['request_number'] = $PreReserve['Result']['Request']['RequestNumber'];

                        $model->setTable("book_local_tb");
                        unset($d['remote_addr']);
                        unset($d['client_id']);
                        $res = $model->insertLocal($d);
                        $d['remote_addr'] = $_SERVER['REMOTE_ADDR'];
                        $d['client_id'] = CLIENT_ID;
                        $ModelBase->setTable("report_tb");
                        $ModelBase->insertLocal($d);

                        $passengerAddArray = array(
                            'passengerName' => $params['nameFaA' . $i],
                            'passengerNameEn' => $params['nameEnA' . $i],
                            'passengerFamily' => $params['familyFaA' . $i],
                            'passengerFamilyEn' => $params['familyEnA' . $i],
                            'passengerGender' => $params['genderA' . $i],
                            'passengerBirthday' => $params['birthdayA' . $i],
                            'passengerNationalCode' => $params['NationalCodeA' . $i],
                            'passengerBirthdayEn' => $params['birthdayEnA' . $i],
                            'passengerPassportCountry' => $params['passportCountryA' . $i],
                            'passengerPassportNumber' => $params['passportNumberA' . $i],
                            'passengerPassportExpire' => $params['passportExpireA' . $i],
                            'memberID' => $user['id'],
                            //passengerNationality 1 means foreign & 0 means iranian
                            'passengerNationality' => (SOFTWARE_LANG !='fa' &&  !isset( $params["passengerNationalityA" . $i])) ? 1 :  $params["passengerNationalityA" . $i]
                        );

                        functions::insertLog(json_encode($passengerAddArray,256),'checkPassenger');

                        $resultPassengers = $passengerController->insert($passengerAddArray);

                        Session::setSessionHistoryPassenger('A'.$i , $resultPassengers['lastId']) ;
                        $i++;
                    }
                }


                $i = 1;
                if(isset($params['genderC' . $i]))
                {
                    while ($params['genderC' . $i]) {
                        if (!empty($params['birthdayC' . $i])) {
                            $explode_br_fa = explode('-', $params['birthdayC' . $i]);
                            $date_miladi = dateTimeSetting::jalali_to_gregorian($explode_br_fa[0], $explode_br_fa[1], $explode_br_fa[2], '-');
                        }
                        $d['origin_city'] = functions::NameCity(strtoupper($PreReserve['Result']['Request']['OutputRoutes'][0]['Departure']['Code']));
                        $d['desti_city'] = functions::NameCity(strtoupper($PreReserve['Result']['Request']['OutputRoutes'][$index_arrival_city]['Arrival']['Code']));
                        $d['origin_airport_iata'] = strtoupper($PreReserve['Result']['Request']['OutputRoutes'][0]['Departure']['Code']);
                        $d['desti_airport_iata'] = strtoupper($PreReserve['Result']['Request']['OutputRoutes'][$index_arrival_city]['Arrival']['Code']);
                        $d['date_flight'] = $date_flight;
                        $d['time_flight'] = $TimeFlight;
                        $d['date_flight_arrival'] = $date_flight_arrival;
                        $d['time_flight_arrival'] = $TimeFlightArrival;
                        $d['flight_type'] = $FlightType;
                        $d['flight_number'] = $PreReserve['Result']['Request']['OutputRoutes'][0]['FlightNo'];
                        $d['airline_iata'] = $PreReserve['Result']['Request']['OutputRoutes'][0]['Airline']['Code'];
                        $d['airline_name'] = (!empty($PreReserve['Result']['Request']['OutputRoutes'][0]['Airline']['Name'])) ? $PreReserve['Result']['Request']['OutputRoutes'][0]['Airline']['Name'] : '';
                        $d['seat_class'] = !empty($PreReserve['Result']['Request']['OutputRoutes'][0]['SeatClass']) ? $PreReserve['Result']['Request']['OutputRoutes'][0]['SeatClass'] : "";
                        $d['cabin_type'] = $PreReserve['Result']['Request']['OutputRoutes'][0]['CabinType'];
                        $d['IsInternal'] = $isInternal;
                        $d['api_id'] = $PreReserve['Result']['SourceId'];
                        if ($check_private == 'private') {
                            $d['pid_private'] = '1';
                        } else {
                            $d['pid_private'] = '0';
                        }
                        $d['factor_number'] = $factor_number;
                        $d['member_id'] = $user['id'];
                        $d['member_name'] = $user['name'] . ' ' . $user['family'];
                        $d['member_email'] = $user['email'];
                        $d['member_mobile'] = $user['mobile'];
                        $d['member_phone'] = $user['telephone'];
                        $d['direction'] = $direction;
                        $d['creation_date'] = date('Y-m-d');
                        $d['creation_date_int'] = time();

                        $d['passenger_gender'] = $params['genderC' . $i];
                        $d['passenger_name'] = $params['nameFaC' . $i];
                        $d['passenger_family'] = $params['familyFaC' . $i];
                        $d['passenger_name_en'] = $params['nameEnC' . $i];
                        $d['passenger_family_en'] = $params['familyEnC' . $i];
                        $d['passenger_birthday'] = $params['birthdayC' . $i];
                        $d['passportCountry'] = !empty($params['passportCountryC' . $i]) ? $params['passportCountryC' . $i] : 'IRN';
                        $d['passportNumber'] = $params['passportNumberC' . $i];
                        $d['passportExpire'] = $params['passportExpireC' . $i];
                        $d['mobile_buyer'] = $params['Mobile_buyer'];
                        $d['email_buyer'] = $params['Email_buyer'];

                        if ($params["passengerNationalityC" . $i] == '1' || ($isInternal == '0' && $params["passengerNationalityC" . $i] == '1') || (SOFTWARE_LANG !='fa')) {
                            $d['passenger_birthday_en'] = $params['birthdayEnC' . $i];
                        }else{
                            $d['passenger_birthday_en'] = $date_miladi;
                        }
                        $d['passenger_national_code'] = !empty($params['NationalCodeC' . $i]) ? $params['NationalCodeC' . $i] : '0000000000';


                        $d['passenger_age'] = $this->type_passengers( $d['passenger_birthday_en'],$d['date_flight']);


                        $d['type_app'] = (isset($_POST['type']) && $_POST['type'] == 'App') ? "Application" : "Web";
                        $d['currency_code'] = $currency_code;
                        $d['currency_equivalent'] = !empty($InfoCurrency) ? $InfoCurrency['EqAmount'] : 0;
                        $d['request_number'] = $PreReserve['Result']['Request']['RequestNumber'];

                        if(empty($special_discount_information) && !empty($params['NationalCodeC' . $i])){
                            $data_special_discount['type_get_discount'] = 'national_code';
                            $data_special_discount['pre_code'] = substr($params['NationalCodeC' . $i],0,3);
                            $special_discount_information_with_national_code = $this->getController('servicesDiscount')->getSpecialDiscount($data_special_discount);

                            if(!empty($special_discount_information_with_national_code))
                            {
                                $data_check_usage['info_member_passenger'] = $params['NationalCodeC' . $i] ;
                                $check_usage_member = $this->getController('servicesDiscount')->getSpecialDiscountUsed($data_special_discount);
                                if(empty($check_usage_member))
                                {
                                    $d['special_discount_amount'] = !empty($special_discount_information_with_national_code) ? $special_discount_information_with_national_code['amount']: 0;
                                    $d['special_discount_type'] = !empty($special_discount_information_with_national_code) ? $special_discount_information_with_national_code['type_discount'] : null;

                                    $data_usage_special_discount['info_member_passenger'] =$params['NationalCodeC' . $i];
                                    $data_usage_special_discount['amount'] = $special_discount_information['amount'] ;
                                    $data_usage_special_discount['type_amount'] =  $special_discount_information['type_discount'];
                                    $data_usage_special_discount['factor_number'] =  $factor_number;
                                    $data_usage_special_discount['type_buy'] =  'flight';
                                    $data_usage_special_discount['status'] =  'pending';
                                    $data_usage_special_discount['creation_date_int'] =  time();

                                    $this->getController('servicesDiscount')->setSpecialDiscountUsed($data_usage_special_discount);
                                }
                            }
                        }

                        $model->setTable("book_local_tb");
                        unset($d['remote_addr']);
                        unset($d['client_id']);
                        $res = $model->insertLocal($d);
                        $d['remote_addr'] = $_SERVER['REMOTE_ADDR'];
                        $d['client_id'] = CLIENT_ID;
                        $ModelBase->setTable("report_tb");
                        $ModelBase->insertLocal($d);

                        $passengerAddArray = array(
                            'passengerName' => $params['nameFaC' . $i],
                            'passengerNameEn' => $params['nameEnC' . $i],
                            'passengerFamily' => $params['familyFaC' . $i],
                            'passengerFamilyEn' => $params['familyEnC' . $i],
                            'passengerGender' => $params['genderC' . $i],
                            'passengerBirthday' => $params['birthdayC' . $i],
                            'passengerNationalCode' => $params['NationalCodeC' . $i],
                            'passengerBirthdayEn' => $params['birthdayEnC' . $i],
                            'passengerPassportCountry' => $params['passportCountryC' . $i],
                            'passengerPassportNumber' => $params['passportNumberC' . $i],
                            'passengerPassportExpire' => $params['passportExpireC' . $i],
                            'memberID' => $user['id'],
                            'passengerNationality' => $params["passengerNationalityC" . $i]
                        );
                        $resultPassengers =$passengerController->insert($passengerAddArray);
                        Session::setSessionHistoryPassenger('C'.$i , $resultPassengers['lastId']) ;
                        $i++;
                    }
                }


                $i = 1;
                if(isset($params['genderI' . $i])) {
                    while ($params['genderI' . $i]) {

                        if (!empty($params['birthdayI' . $i])) {
                            $explode_br_fa = explode('-', $params['birthdayI' . $i]);
                            $date_miladi = dateTimeSetting::jalali_to_gregorian($explode_br_fa[0], $explode_br_fa[1], $explode_br_fa[2], '-');
                        }
                        $d['origin_city'] = functions::NameCity(strtoupper($PreReserve['Result']['Request']['OutputRoutes'][0]['Departure']['Code']));
                        $d['desti_city'] = functions::NameCity(strtoupper($PreReserve['Result']['Request']['OutputRoutes'][$index_arrival_city]['Arrival']['Code']));
                        $d['origin_airport_iata'] = strtoupper($PreReserve['Result']['Request']['OutputRoutes'][0]['Departure']['Code']);
                        $d['desti_airport_iata'] = strtoupper($PreReserve['Result']['Request']['OutputRoutes'][$index_arrival_city]['Arrival']['Code']);
                        $d['date_flight'] = $date_flight;
                        $d['time_flight'] = $TimeFlight;
                        $d['date_flight_arrival'] = $date_flight_arrival;
                        $d['time_flight_arrival'] = $TimeFlightArrival;
                        $d['flight_type'] = $FlightType;
                        $d['flight_number'] = $PreReserve['Result']['Request']['OutputRoutes'][0]['FlightNo'];
                        $d['airline_iata'] = $PreReserve['Result']['Request']['OutputRoutes'][0]['Airline']['Code'];
                        $d['airline_name'] = (!empty($PreReserve['Result']['Request']['OutputRoutes'][0]['Airline']['Name'])) ? $PreReserve['Result']['Request']['OutputRoutes'][$Count - 1]['Airline']['Name'] : '';
                        $d['seat_class'] = !empty($PreReserve['Result']['Request']['OutputRoutes'][0]['SeatClass']) ? $PreReserve['Result']['Request']['OutputRoutes'][0]['SeatClass'] : "";
                        $d['cabin_type'] = $PreReserve['Result']['Request']['OutputRoutes'][0]['CabinType'];
                        $d['IsInternal'] = $isInternal;
                        $d['api_id'] = $PreReserve['Result']['SourceId'];
                        if ($check_private == 'private') {
                            $d['pid_private'] = '1';
                        } else {
                            $d['pid_private'] = '0';
                        }
                        $d['factor_number'] = $factor_number;
                        $d['member_id'] = $user['id'];
                        $d['member_name'] = $user['name'] . ' ' . $user['family'];
                        $d['member_email'] = $user['email'];
                        $d['member_mobile'] = $user['mobile'];
                        $d['member_phone'] = $user['telephone'];
                        $d['direction'] = $direction;
                        $d['creation_date'] = date('Y-m-d');
                        $d['creation_date_int'] = time();

                        $d['passenger_gender'] = $params['genderI' . $i];
                        $d['passenger_name'] = $params['nameFaI' . $i];
                        $d['passenger_family'] = $params['familyFaI' . $i];
                        $d['passenger_name_en'] = $params['nameEnI' . $i];
                        $d['passenger_family_en'] = $params['familyEnI' . $i];
                        $d['passenger_birthday'] = $params['birthdayI' . $i];
                        $d['passportCountry'] = !empty($params['passportCountryI' . $i]) ? $params['passportCountryI' . $i] : 'IRN';
                        $d['passportNumber'] = $params['passportNumberI' . $i];
                        $d['passportExpire'] = $params['passportExpireI' . $i];
                        $d['mobile_buyer'] = $params['Mobile_buyer'];
                        $d['email_buyer'] = $params['Email_buyer'];

                        if ($params["passengerNationalityI" . $i] == '1' || ($isInternal == '0' && $params["passengerNationalityI" . $i] == '1') || (SOFTWARE_LANG !='fa')) {
                            $d['passenger_birthday_en'] = $params['birthdayEnI' . $i];
                        }else{
                            $d['passenger_birthday_en'] = $date_miladi;
                        }
                        $d['passenger_national_code'] = !empty($params['NationalCodeI' . $i]) ? $params['NationalCodeI' . $i] : '0000000000';

                        $d['passenger_age'] = $this->type_passengers( $d['passenger_birthday_en'],$d['date_flight']);


                        $d['type_app'] = (isset($_POST['type']) && $_POST['type'] == 'App') ? "Application" : "Web";
                        $d['currency_code'] = $currency_code;
                        $d['currency_equivalent'] = !empty($InfoCurrency) ? $InfoCurrency['EqAmount'] : 0;


                        $d['request_number'] = $PreReserve['Result']['Request']['RequestNumber'];

                        if (empty($special_discount_information) && !empty($params['NationalCodeI' . $i])) {
                            $data_special_discount['type_get_discount'] = 'national_code';
                            $data_special_discount['pre_code'] = substr($params['NationalCodeI' . $i], 0, 3);
                            $special_discount_information_with_national_code = $this->getController('servicesDiscount')->getSpecialDiscount($data_special_discount);

                            if (!empty($special_discount_information_with_national_code)) {

                                $data_check_usage['info_member_passenger'] = $params['NationalCodeC' . $i] ;
                                $check_usage_member = $this->getController('servicesDiscount')->getSpecialDiscountUsed($data_special_discount);

                                if(empty($check_usage_member))
                                {
                                    $d['special_discount_amount'] = !empty($special_discount_information_with_national_code) ? $special_discount_information_with_national_code['amount']: 0;
                                    $d['special_discount_type'] = !empty($special_discount_information_with_national_code) ? $special_discount_information_with_national_code['type_discount'] : null;

                                    $data_usage_special_discount['info_member_passenger'] = $params['NationalCodeI' . $i];
                                    $data_usage_special_discount['amount'] = $special_discount_information['amount'] ;
                                    $data_usage_special_discount['type_amount'] =  $special_discount_information['type_discount'];
                                    $data_usage_special_discount['factor_number'] =  $factor_number;
                                    $data_usage_special_discount['type_buy'] =  'flight';
                                    $data_usage_special_discount['status'] =  'pending';
                                    $data_usage_special_discount['creation_date_int'] =  time();

                                    $this->getController('servicesDiscount')->setSpecialDiscountUsed($data_usage_special_discount);
                                }
                            }
                        }
                        $model->setTable("book_local_tb");
                        unset($d['remote_addr']);
                        unset($d['client_id']);
                        $res = $model->insertLocal($d);
                        $d['remote_addr'] = $_SERVER['REMOTE_ADDR'];
                        $d['client_id'] = CLIENT_ID;
                        $ModelBase->setTable("report_tb");
                        $ModelBase->insertLocal($d);

                        $passengerAddArray = array(
                            'passengerName' => $params['nameFaI' . $i],
                            'passengerNameEn' => $params['nameEnI' . $i],
                            'passengerFamily' => $params['familyFaI' . $i],
                            'passengerFamilyEn' => $params['familyEnI' . $i],
                            'passengerGender' => $params['genderI' . $i],
                            'passengerBirthday' => $params['birthdayI' . $i],
                            'passengerNationalCode' => $params['NationalCodeI' . $i],
                            'passengerBirthdayEn' => $params['birthdayEnI' . $i],
                            'passengerPassportCountry' => $params['passportCountryI' . $i],
                            'passengerPassportNumber' => $params['passportNumberI' . $i],
                            'passengerPassportExpire' => $params['passportExpireI' . $i],
                            'memberID' => $user['id'],
                            'passengerNationality' => $params["passengerNationalityI" . $i]
                        );
                        $resultPassengers =$passengerController->insert($passengerAddArray);
                        Session::setSessionHistoryPassenger('I'.$i , $resultPassengers['lastId']) ;
                        $i++;
                    }
                }



                if ($d['IsInternal'] == '0' || (isset($params['typeReserve']) && $params['typeReserve']=='package') || ($d['IsInternal'] == '1' && $d['api_id'] == '14' && $direction=='TwoWay' )) {
                    foreach ($PreReserve['Result']['Request']['OutputRoutes'] as $Routes) {
                        $DepartureDateExplode = explode('T', $Routes['DepartureDate']);
                        $DepartureDate = count($DepartureDateExplode) > 1 ? $DepartureDateExplode[0] : $Routes['DepartureDate'];
                        $ArrivalDateExplode = explode('T', $Routes['ArrivalDate']);
                        $ArrivalDate = count($ArrivalDateExplode) > 1 ? $ArrivalDateExplode[0] : $Routes['ArrivalDate'];

                        $BookRoutes['RequestNumber'] = $PreReserve['Result']['Request']['RequestNumber'];
                        $DepartureCity = functions::NameCityForeign($Routes['Departure']['Code']);
                        $BookRoutes['OriginCity'] = $DepartureCity['DepartureCityFa'];
                        $BookRoutes['OriginAirportIata'] = $Routes['Departure']['Code'];
                        $ArrivalCity = functions::NameCityForeign($Routes['Arrival']['Code']);
                        $BookRoutes['DestinationCity'] = $ArrivalCity['DepartureCityFa'];
                        $BookRoutes['DestinationAirportIata'] = $Routes['Arrival']['Code'];
                        $BookRoutes['DepartureDate'] = $DepartureDate;//str_replace('-', '/', functions::DateJalali($DepartureDate));
                        $BookRoutes['DepartureTime'] = $Routes['DepartureTime'];
                        $BookRoutes['ArrivalTime'] = $Routes['ArrivalTime'];
                        $BookRoutes['ArrivalDate'] = $ArrivalDate;// str_replace('-', '/', functions::DateJalali($ArrivalDate));
                        $BookRoutes['Transit'] = $Routes['Transit'];
                        $BookRoutes['LongTime'] = $Routes['FlightTime'];
                        $BookRoutes['TotalLongTime'] = $PreReserve['Result']['Request']['TotalOutputFlightDuration'];
                        $BookRoutes['TotalTransitTime'] = $PreReserve['Result']['Request']['TotalOutputStopDuration'];
                        $BookRoutes['CabinType'] = $Routes['CabinType'];
                        $BookRoutes['AirlineName'] = $Routes['Airline']['AirlineName'];
                        $BookRoutes['Airline_IATA'] = $Routes['Airline']['Code'];
                        $BookRoutes['AircraftName'] = $Routes['Aircraft']['Manufacturer'];
                        $BookRoutes['FlightNumber'] = $Routes['FlightNo'];
                        $BookRoutes['Baggage'] = !empty($Routes['Baggage']) ? $Routes['Baggage'][0]['Charge'] : '0';
                        $BookRoutes['BaggageType'] = !empty($Routes['Baggage']) ? $Routes['Baggage'][0]['Code'] : '';
                        $BookRoutes['AllowanceAmount'] = !empty($Routes['Baggage']) ? $Routes['Baggage'][0]['allowanceAmount'] : '0';
                        $BookRoutes['TypeRoute'] = 'Dept';

                        $model->setTable("book_routes_tb");
                        $model->insertLocal($BookRoutes);
                        $ModelBase->setTable("report_routes_tb");
                        $ModelBase->insertLocal($BookRoutes);
                    }

                    if (!empty($PreReserve['Result']['Request']['ReturnRoutes'])) {
                        foreach ($PreReserve['Result']['Request']['ReturnRoutes'] as $RoutesReturn) {
                            $DepartureDateExplode = explode('T', $RoutesReturn['DepartureDate']);
                            $DepartureDate = count($DepartureDateExplode) > 1 ? $DepartureDateExplode[0] : $RoutesReturn['DepartureDate'];
                            $ArrivalDateExplode = explode('T', $RoutesReturn['ArrivalDate']);
                            $ArrivalDate = count($ArrivalDateExplode) > 1 ? $ArrivalDateExplode[0] : $RoutesReturn['ArrivalDate'];

                            $BookRoutesReturn['RequestNumber'] = $PreReserve['Result']['Request']['RequestNumber'];
                            $DepartureCity = functions::NameCityForeign($RoutesReturn['Departure']['Code']);
                            $BookRoutesReturn['OriginCity'] = $DepartureCity['DepartureCityFa'];
                            $BookRoutesReturn['OriginAirportIata'] = $RoutesReturn['Departure']['Code'];
                            $ArrivalCity = functions::NameCityForeign($RoutesReturn['Arrival']['Code']);
                            $BookRoutesReturn['DestinationCity'] = $ArrivalCity['DepartureCityFa'];
                            $BookRoutesReturn['DestinationAirportIata'] = $RoutesReturn['Arrival']['Code'];
                            $BookRoutesReturn['DepartureDate'] = $DepartureDate;// str_replace('-', '/', functions::DateJalali($DepartureDate));
                            $BookRoutesReturn['DepartureTime'] = $RoutesReturn['DepartureTime'];
                            $BookRoutesReturn['ArrivalTime'] = $RoutesReturn['ArrivalTime'];
                            $BookRoutesReturn['ArrivalDate'] = $ArrivalDate;//str_replace('-', '/', functions::DateJalali($ArrivalDate));
                            $BookRoutesReturn['Transit'] = $RoutesReturn['Transit'];
                            $BookRoutesReturn['LongTime'] = $RoutesReturn['FlightTime'];
                            $BookRoutesReturn['TotalLongTime'] = $PreReserve['Result']['Request']['TotalReturnFlightDuration'];
                            $BookRoutesReturn['TotalTransitTime'] = $PreReserve['Result']['Request']['TotalReturnStopDuration'];
                            $BookRoutesReturn['CabinType'] = $RoutesReturn['CabinType'];
                            $BookRoutesReturn['AirlineName'] = $RoutesReturn['Airline']['AirlineName'];
                            $BookRoutesReturn['Airline_IATA'] = $RoutesReturn['Airline']['Code'];
                            $BookRoutesReturn['AircraftName'] = $RoutesReturn['Aircraft']['Manufacturer'];
                            $BookRoutesReturn['FlightNumber'] = $RoutesReturn['FlightNo'];
                            $BookRoutesReturn['Baggage'] = !empty($RoutesReturn['Baggage']) ? $RoutesReturn['Baggage'][0]['Charge'] : '0';
                            $BookRoutesReturn['BaggageType'] = !empty($RoutesReturn['Baggage']) ? $RoutesReturn['Baggage'][0]['Code'] : '';
                            $BookRoutesReturn['AllowanceAmount'] = !empty($RoutesReturn['Baggage']) ? $RoutesReturn['Baggage'][0]['allowanceAmount'] : '0';
                            $BookRoutesReturn['TypeRoute'] = 'Return';

                            $model->setTable("book_routes_tb");
                            $model->insertLocal($BookRoutesReturn);

                            $ModelBase->setTable("report_routes_tb");
                            $ModelBase->insertLocal($BookRoutesReturn);
                        }
                    }
                }



                $result['result_status'] = $PreReserve['Result']['Request']['Status'];
                $result['result_request_number'] = $PreReserve['Result']['Request']['RequestNumber'];
                $result['result_factor_number'] = $factor_number;
                $result['extra_message'] = 'success prereserve';

            }
            else {
                $MessageError = functions::ShowError($PreReserve['Messages']['errorCode']);

                $data_error['client_id'] = CLIENT_ID;
                $data_error['request_number'] = $PreReserve['Code'];
                $data_error['action'] = 'PreReserve';
                $data_error['creation_date_int'] = time();
                $this->getController('logErrorFlights')->insertLogErrorFlights($data_error);

                $result['result_status'] = 'Error';
                $result['result_message'] = $MessageError->__toString();
                $result['result_request_number'] = $ExplodeSessionID[0];
                $result['extra_message'] = 'error in prereserve';
            }
        }
        else {
            $result['result_status'] = 'PreReserve';
            $result['result_request_number'] = $BookExist['request_number'];
            $result['result_factor_number'] = $BookExist['factor_number'];
            $result['extra_message'] = 'exist in prereserve';
        }


        return $result;
    }

#endregion
#region type_passengers

    public function type_passengers($birthday,$flight_date)
    {
        $different_date = functions::dateDiff(date("Y-m-d", time()),$flight_date) ;

        $date_two = date("Y-m-d", strtotime("-2 year +{$different_date} day"));
        $date_twelve = date("Y-m-d", strtotime("-12 year +{$different_date} day"));

        if (strcmp($birthday, $date_two) > 0) {
            return "Inf";
        } elseif (strcmp($birthday, $date_two) < 0 && strcmp($birthday, $date_twelve) > 0) {
            return "Chd";
        } else {
            return "Adt";
        }
    }


#endregion
#region bookFlightPassenger

    public function bookFlightPassenger($RequestNumber, $IdMember, $sourceId = null, $securityCode = null)
    {

        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $irantechCommission = Load::controller('irantechCommission');

        $IdMember = $_POST['IdMember'];
        $sql = "SELECT * FROM book_local_tb WHERE member_id='{$IdMember}' AND request_number='{$RequestNumber}'";
        $passengers = $Model->select($sql);

        $data['securityCode'] = $securityCode;
        foreach ($passengers as $key => $rec) {
            if (!empty($rec['passenger_birthday'])) {

                $date_miladi = functions::ConvertToMiladi($rec['passenger_birthday']);
            }
            $data['Books'][$key]['FirstName'] = $rec['passenger_name_en'];
            $data['Books'][$key]['LastName'] = $rec['passenger_family_en'];
            $data['Books'][$key]['PersianFirstName'] = $rec['passenger_name'];
            $data['Books'][$key]['PersianLastName'] = $rec['passenger_family'];
            $data['Books'][$key]['PassengerType'] = $this->type_passengers((!empty($rec['passenger_birthday_en']) && $rec['passenger_birthday_en'] != '0000-00-00') ? $rec['passenger_birthday_en'] : $date_miladi,$rec['date_flight']);
            $data['Books'][$key]['PassengerTitle'] = $this->type_title($rec['passenger_gender'], $data['Books'][$key]['PassengerType']);
            $data['Books'][$key]['DateOfBirth'] = (!empty($rec['passenger_birthday_en']) && $rec['passenger_birthday_en'] != '0000-00-00') ? $rec['passenger_birthday_en'] : $date_miladi;
            $data['Books'][$key]['NationalCode'] =($rec['passenger_national_code'] == '0000000000') ? '' :  functions::convertNumberOFPersianToLatin($rec['passenger_national_code']);
            $data['Books'][$key]['PassportNumber'] = ($rec['IsInternal'] == '1' && $rec['passportCountry'] == 'IRN') ? '' :  functions::convertNumberOFPersianToLatin(trim($rec['passportNumber']));
            $data['Books'][$key]['PassportExpireDate'] = ($rec['IsInternal'] == '1' && $rec['passportCountry'] == 'IRN') ? '' :  functions::convertNumberOFPersianToLatin(trim($rec['passportExpire']));


            if (!empty($rec['passportNumber'])) {
                $data['Books'][$key]['Documenttype'] = 'Psp';
            } else {
                $data['Books'][$key]['Documenttype'] = 'Nic';
            }

            if (!empty($sourceId) && ($sourceId == '1' || $sourceId == '11')) {
                $data['Books'][$key]['Nationality'] = !empty($rec['passportCountry']) && $rec['passportCountry'] != 'IRN' ? trim($rec['passportCountry']) : "IRN";
            } else if (!empty($sourceId) && $sourceId == '10') {
                $data['Books'][$key]['Nationality'] = !empty($rec['passportCountry']) && $rec['passportCountry'] != 'IRN' ? trim($rec['passportCountry']) : "IR";
            } else {
                $data['Books'][$key]['Nationality'] = !empty($rec['passportCountry']) && $rec['passportCountry'] != 'IRN' ? trim($rec['passportCountry']) : "IR";
            }
            $data['Books'][$key]['AreaCode'] = "21";
            $data['Books'][$key]['CountryCode'] = "98";
            $sourceIdPrivate = functions::SourceIdPrivate();


            $self_phone_customer = functions::selfPhoneCustomers();

            // be gofteye aghaye afshar dar tarikh 26 bahman 1401 shomare va email be sorate zir ersal mishavad

            if( $sourceId=='8' && $passengers[0]['airline_iata']=='IS'){
                //az tarikh 4 bahman1402 mogharar shod baraye airline sepehran va server 7 shomare kharidar ersal shavad
                $data['Books'][$key]['PhoneNumber'] =  $rec['mobile_buyer'];
                $data['Books'][$key]['Email'] =  $rec['email_buyer'];
            }elseif ($rec['pid_private'] =='1' && in_array(CLIENT_ID,$self_phone_customer)) {
                //dar tarikh 25 esfand tebghe nazar moshtari baraye bazi az moshtariani Ke mikhan shomare karbar va email karbar ersal mishe
                $data['Books'][$key]['PhoneNumber'] = !empty($rec['mobile_buyer']) ? $rec['mobile_buyer'] : $rec['member_mobile'];
                $data['Books'][$key]['Email'] = (!empty($rec['email_buyer'])) ? $rec['email_buyer'] : $rec['member_email'];
            }elseif ($rec['pid_private'] =='1') {
                //shomare telephone and email modir
                $data['Books'][$key]['PhoneNumber'] = CLIENT_MOBILE ;
                $data['Books'][$key]['Email'] = CLIENT_EMAIL;
            }elseif ($rec['pid_private'] =='0' && $sourceId=='14') {
                //pid_private =0 yani parvaz eshteraki hast
                //baraye parto eshteraki
                $data['Books'][$key]['PhoneNumber'] = '09020661033' ;
                $data['Books'][$key]['Email'] = 'flymurshid@gmail.com';

                $cellArray = array(
                    'afraze' => '09916211232',
                    'fanipor' => '09129409530',
                    'araste' => '09211559872',
                    'abbasi_' => '09057078341',
                    'alami' => '09155909722'

                );
                $ServerName = '14 اشتراکی';
                /** @var smsServices $smsController */
                $smsController = Load::controller('smsServices');
                $objSms = $smsController->initService('1');
                if ($objSms) {
                    $smsController->smsByPattern('ziw50u9vnh50dlf', $cellArray, array('serverId' => $ServerName,'requestNumber'=> $RequestNumber));

                }

            }
            else{
                if($sourceId=='17' || $sourceId=='21') {
                    // dar tarikh 4 azar 1403 bana be darkhast aghaye afshar shomare poshtibani bere be flightio chon baraye moshtari 3 ta sms miraft
                    $data['Books'][$key]['PhoneNumber'] = '09057078341';
                } else {
                    $data['Books'][$key]['PhoneNumber'] = CLIENT_MOBILE;
                }
                $data['Books'][$key]['Email'] = 'safar360@iran-tech.com';
            }

        }

        $data['subAgencyId'] = '';
        $agencyInfo = $this->getController('agency')->subAgencyInfo();
        if ($agencyInfo != null && !empty($agencyInfo['sepehr_username']) && !empty($agencyInfo['sepehr_password'])) {
            $data['subAgencyId'] = $agencyInfo['id'];
        }

        $url = $this->apiAddress . "Flight/Book/{$RequestNumber}";
        $info_json_passengers = json_encode($data);

        $book = $this->curlExecution($url, $info_json_passengers, 'yes');

        error_log('try show result Request Client In Book in : ' . date('Y/m/d H:i:s') . '   Request equal in With SourceId=>' . $sourceId . 'AND  RequestNumber : => ' . $RequestNumber . ': ' . $info_json_passengers . " \n" . "Response equal in With RequestNumber=>" . $RequestNumber . ":" . " " . json_encode($book, true) . " \n", 3, LOGS_DIR . 'log_Request_Response_Book.txt');

        $IsInternal = $passengers[0]['IsInternal'];
        $FlagUpdate = false;
        if (!empty($book)) {
            if (isset($book['Result']['ProviderStatus']) && $book['Result']['ProviderStatus'] != "errorProvider") {

                $UserInfo = functions::infoMember($IdMember);

                $AirlineIata = $passengers[0]['airline_iata'];
                $FlightType = (strtolower($passengers[0]['flight_type']) == 'system') ? 'system' : 'charter';

                if (empty($book['Result']['Request']['RequestFlights'])) {
                    $book['Result']['Request']['RequestFlights'] = array();
                }

                foreach ($book['Result']['Request']['RequestFlights'] as $RequestFlights) {

                    //تغییرات قیمت فقط برای چارتری داخلی و یا خارجی(هم سیستمی و هم چارتری)

                    if ((in_array($sourceId,functions::sourceIncreasePriceFlightSystem())) || ($FlightType == 'charter')  || ($FlightType == 'system' && $IsInternal == '0' && $sourceId !='8' && $sourceId !='16')) {
                        $data_price_change['counter_id']   =  $UserInfo['fk_counter_type_id'];
                        $data_price_change['airline_iata'] = $AirlineIata;
                        $data_price_change['locality']     = ($IsInternal == '1' ? 'local' : 'international');
                        $data_price_change['flight_type']  = $FlightType;
                        $priceChanges = $this->getController('priceChanges')->getChangePriceByCounterAndAirline($data_price_change);
                        $d['price_change'] = $priceChanges['price'];
                        $d['price_change_type'] = $priceChanges['change_type'];

                    } else {
                        $d['price_change'] = '0';
                        $d['price_change_type'] = 'none';
                    }
                }

                $check_private = ($passengers[0]['pid_private'] == '1') ? 'private' : 'public';


                $airlineModel = $this->getModel('airlineModel');
                $resultForeignAirline = $airlineModel
                    ->get(array('foreignAirline'), true)
                    ->where('abbreviation', $AirlineIata)
                    ->find();
                $foreignAirline = ($resultForeignAirline['foreignAirline'] == 'active') ? 1 : 0;


                $d['total_price'] = '0';
                $d['request_number'] = $RequestNumber;
                $d['supplier_name'] = isset($book['Result']['Supplier']) ? $book['Result']['Supplier']['Name'] : '';
                $d['supplier_manager'] = isset($book['Result']['Supplier']) ? $book['Result']['Supplier']['ManagerName'] : '';
                $d['supplier_website'] = isset($book['Result']['Supplier']) ? $book['Result']['Supplier']['Website'] : '';
                $d['supplier_phone1'] = isset($book['Result']['Supplier']) ? $book['Result']['Supplier']['Phone1'] : '';
                $d['supplier_phone2'] = isset($book['Result']['Supplier']) ? $book['Result']['Supplier']['Phone2'] : '';
                $d['supplier_city'] = isset($book['Result']['Supplier']) ? $book['Result']['Supplier']['CityName'] : '';
//                $d['supplier_address'] = isset($book['Result']['Supplier']) ? $book['Result']['Supplier']['Address'] : '';
                $d['successfull'] = "prereserve";
                $d['del'] = 'no';
                $d['api_id'] = $sourceId;
                $d['foreign_airline'] = $foreignAirline;

                $PriceFare =array();
                $PriceTax = array();
                $PriceCom = array();
                $source_rial = functions::calculateWithRial();

                /* به دلیل خروجی و هماهنگی تعداد مسافران و تعداد رکوردها مجبور به استفاده از دو حلقه زیر هستیم که در اولی مبلغ هر مسافر متانسب با نوعش به دست می آید و در دومی به تعداد مسافران رکورد میزنیم  */
                foreach ($book['Result']['Request']['RequestFares'] as $RequestFares) {
                    if ( (in_array($sourceId,$source_rial))) {
                        if (strtolower($RequestFares['PassengerType']) == "adt") {
                            $Price['Adt']     =   $RequestFares['TotalFare'] ;
                            $PriceFare['Adt'] =   $RequestFares['BaseFare'] ;
                            $PriceTax['Adt']  =   $RequestFares['Tax'];
                            $PriceCom['Adt']  =   $RequestFares['Commision'];
                        }
                        if (strtolower($RequestFares['PassengerType']) == "chd") {
                            $Price['Chd']     =   $RequestFares['TotalFare'] ;
                            $PriceFare['Chd'] =   $RequestFares['BaseFare'] ;
                            $PriceTax['Chd']  =   $RequestFares['Tax'];
                            $PriceCom['Chd']  =   $RequestFares['Commision'];

                        }
                        if (strtolower($RequestFares['PassengerType']) == "inf") {
                            $Price['Inf']     =  $RequestFares['TotalFare'] ;
                            $PriceFare['Inf'] =  $RequestFares['BaseFare'] ;
                            $PriceTax['Inf']  =  $RequestFares['Tax'];
                            $PriceCom['Inf']  =  $RequestFares['Commision'];

                        }
                    } else {
                        if (strtolower($RequestFares['PassengerType']) == "adt") {
                            $Price['Adt']     =   functions::convert_toman_rial($RequestFares['TotalFare']);
                            $PriceFare['Adt'] =   functions::convert_toman_rial($RequestFares['BaseFare']);
                            $PriceTax['Adt']  =   functions::convert_toman_rial($RequestFares['Tax']);
                            $PriceCom['Adt']  =   functions::convert_toman_rial($RequestFares['Commision']);
                        }
                        if (strtolower($RequestFares['PassengerType']) == "chd") {
                            $Price['Chd']     =   functions::convert_toman_rial($RequestFares['TotalFare']);
                            $PriceFare['Chd'] =   functions::convert_toman_rial($RequestFares['BaseFare']);
                            $PriceTax['Chd']  =   functions::convert_toman_rial($RequestFares['Tax']);
                            $PriceCom['Chd']  =   functions::convert_toman_rial($RequestFares['Commision']);
                        }
                        if (strtolower($RequestFares['PassengerType']) == "inf") {
                            $Price['Inf']     =   functions::convert_toman_rial($RequestFares['TotalFare']);
                            $PriceFare['Inf'] =   functions::convert_toman_rial($RequestFares['BaseFare']);
                            $PriceTax['Inf']  =   functions::convert_toman_rial($RequestFares['Tax']);
                            $PriceCom['Inf']  =   functions::convert_toman_rial($RequestFares['Commision']);
                        }
                    }

                }

                $user = functions::infoMember($this->CounterId);
                if ($user == false) {
                    $user['fk_counter_type_id'] = 5;
                }

                $TypeService = $passengers[0]['serviceTitle'];
//                if ($user['is_member'] == '1') {
                    $Discount = functions::ServiceDiscount($user['fk_counter_type_id'], $TypeService);
//                } else {
//                    $Discount = '0';
//                }

                $Price['discount_adt_price'] = $Price['Adt'] - (($Price['Adt'] * $Discount['off_percent']) / 100);
                $Price['discount_chd_price'] = isset($Price['chd']) ? $Price['Chd'] - (($Price['Chd'] * $Discount['off_percent']) / 100) : '0';
                $Price['percent_discount'] = $Discount['off_percent'];
                $it_commission = $irantechCommission->getFlightCommission($TypeService, $sourceId);



                foreach ($book['Result']['Request']['RequestPassengers'] as $ReqPassenger) {

                    if (strtolower($ReqPassenger['PassengerType']) == "adt") {

                        $addon = 0 ;

                        // این تیکه کد مربوط به سیاست قدیمی قیمت گذاری پرواز ها میباشد ، کامن شد به جاش سیست جدید که به صورت داینامیک هست نوشته شده است

//                        if($check_private=='public' && $sourceId =='14' && $IsInternal==0) {
//                            $addon = $Price['Adt'] * (IT_COMMISSION/100) ;
//                        }
//                        else if($FlightType == 'system' && $sourceId =='17' && $IsInternal == 1) {
//                            //                سیستمی های داخلی فلایتو 3 درصد FARE افزایش دارند
//                            $addon = ($PriceFare['Adt'] * 3) / 100 ;
//                        }



                        $d['adt_price'] = $Price['Adt'] + $addon;

                        $d['adt_fare']  = $PriceFare['Adt'];
                        $d['adt_tax']   = $PriceTax['Adt'];
                        $d['adt_com']   = $PriceCom['Adt'];
                        $d['discount_adt_price'] = $Price['discount_adt_price'];
                        $d['adt_qty'] = '1';
                        $d['chd_price'] = '0';
                        $d['chd_fare'] = '0';
                        $d['chd_tax']  = '0';
                        $d['chd_com']  = '0';
                        $d['discount_chd_price'] = '0';
                        $d['chd_qty'] = '0';
                        $d['inf_price'] = '0';
                        $d['inf_fare'] ='0';
                        $d['inf_tax']  = '0';
                        $d['inf_com']  = '0';
                        $d['inf_qty'] = '0';
                        $d['discount_inf_price'] = '0';
                        $d['percent_discount'] = $Price['percent_discount'];
                        list($api_commission, $agency_commission, $supplier_commission) = $this->commission($FlightType, $d['adt_price'], $check_private, $d['price_change'], $d['price_change_type'], $sourceId,$d['adt_fare'],$IsInternal);
                        $d['api_commission'] = $api_commission;
                        $d['agency_commission'] = $agency_commission;
                        $d['supplier_commission'] = $supplier_commission;
                        $d['irantech_commission'] = $it_commission;
                        $d['provider_adt_price'] = $Price['Adt'];
                        $d['provider_chd_price'] = '0';
                        $d['provider_inf_price'] = '0';
                    }
                    else if (strtolower($ReqPassenger['PassengerType']) == "chd") {

                        // این تیکه کد مربوط به سیاست قدیمی قیمت گذاری پرواز ها میباشد ، کامن شد به جاش سیست جدید که به صورت داینامیک هست نوشته شده است

                        $addon = 0 ;
//                        if($check_private=='public' && $sourceId =='14' && $IsInternal==0) {
//                            $addon = $Price['Chd'] * (IT_COMMISSION/100) ;
//                        }else if($FlightType == 'system' && $sourceId =='17' && $IsInternal == 1) {
//                            //                سیستمی های داخلی فلایتو 3 درصد FARE افزایش دارند
//                            $addon = ($PriceFare['Chd'] * 3) / 100 ;
//                        }

                        $d['chd_price'] = $Price['Chd'] + $addon ;
                        $d['chd_fare'] = $PriceFare['Chd'];
                        $d['chd_tax']  = $PriceTax['Chd'];
                        $d['chd_com']   = $PriceCom['Chd'];
                        $d['discount_chd_price'] = $Price['discount_chd_price'];
                        $d['chd_qty'] = '1';
                        $d['adt_price'] = '0';
                        $d['adt_fare'] = '0';
                        $d['adt_tax']  = '0';
                        $d['adt_com']  = '0';
                        $d['adt_qty'] = '0';
                        $d['discount_adt_price'] = '0';
                        $d['inf_qty'] = '0';
                        $d['inf_price'] = '0';
                        $d['inf_fare'] ='0';
                        $d['inf_tax']  = '0';
                        $d['inf_com']  = '0';
                        $d['discount_inf_price'] = '0';
                        $d['percent_discount'] = $Price['percent_discount'];
                        list($api_commission, $agency_commission, $supplier_commission) = $this->commission($FlightType, $d['chd_price'], $check_private, $d['price_change'], $d['price_change_type'], $sourceId,$d['chd_fare'],$IsInternal);
                        $d['api_commission'] = $api_commission;
                        $d['agency_commission'] = $agency_commission;
                        $d['supplier_commission'] = $supplier_commission;
                        $d['irantech_commission'] = $it_commission ;
                        $d['provider_chd_price'] = $Price['Chd'];
                        $d['provider_adt_price'] = '0';
                        $d['provider_inf_price'] = '0';
                    }
                    else if (strtolower($ReqPassenger['PassengerType']) == "inf") {

                        // این تیکه کد مربوط به سیاست قدیمی قیمت گذاری پرواز ها میباشد ، کامن شد به جاش سیست جدید که به صورت داینامیک هست نوشته شده است

                        $addon = 0 ;
//                        if($check_private=='public' && $sourceId =='14' && $IsInternal==0) {
//                            $addon = $Price['Inf'] * (IT_COMMISSION/100) ;
//                        }
//                        else if($FlightType == 'system' && $sourceId =='17' && $IsInternal == 1) {
//                            //                سیستمی های داخلی فلایتو 3 درصد FARE افزایش دارند
//                            $addon = ($PriceFare['Inf'] * 3) / 100 ;
//                        }

                        $d['inf_price'] = $Price['Inf'] +  $addon ;
                        $d['inf_fare'] = $PriceFare['Inf'];
                        $d['inf_tax']  = $PriceTax['Inf'];
                        $d['inf_com']  = $PriceCom['Inf'];
                        $d['inf_qty'] = '1';
                        $d['adt_qty'] = '0';
                        $d['adt_price'] = '0';
                        $d['adt_fare'] = '0';
                        $d['adt_tax']  = '0';
                        $d['adt_com']  = '0';
                        $d['discount_adt_price'] = '0';
                        $d['chd_price'] = '0';
                        $d['chd_fare'] = '0';
                        $d['chd_tax']  = '0';
                        $d['chd_com']  = '0';
                        $d['discount_chd_price'] = '0';
                        $d['chd_qty'] = '0';
                        $d['percent_discount'] = $Price['percent_discount'];
                        list($api_commission, $agency_commission, $supplier_commission) = $this->commission($FlightType, $d['inf_price'], $check_private, $d['price_change'], $d['price_change_type'], $sourceId,$d['inf_fare'],$IsInternal);
                        $d['api_commission'] = $api_commission;
                        $d['agency_commission'] = $agency_commission;
                        $d['supplier_commission'] = $supplier_commission;
                        $d['irantech_commission'] =  $it_commission;
                        $d['provider_inf_price'] = $Price['Inf'];
                        $d['provider_chd_price'] = '0';
                        $d['provider_adt_price'] = '0';
                    }

                    $d = $this->getController('commissionSources')->sourceCommissionCalculation($d , 'book');
                    $d = $this->getController('commissionSources')->setAgencyBenefitSystemFlight($d , 'book');
                    $condition = " member_id = '{$IdMember}' AND request_number='{$RequestNumber}' AND passenger_age='{$ReqPassenger['PassengerType'] }'";
                    $Model->setTable("book_local_tb");
                    $res = $Model->update($d, $condition);
                    if ($res) {

                        $ModelBase->setTable("report_tb");
                        $ModelBase->update($d, $condition);
                        $FlagUpdate = true;
                    }
                }
                if ($FlagUpdate) {
                    $result['result_status'] = 'SuccessMethodBook';

                }
                if (!empty($sourceId) && ($sourceId == '8')) {
                    functions::compareCreditInCharter724('irantechTest',$RequestNumber);
                }

            }
            else {
                $BookFlight['successfull'] = 'error';
                $condition = "request_number='{$RequestNumber}' ";
                $Model->setTable("book_local_tb");
                $res = $Model->update($BookFlight, $condition);
                if ($res) {
                    $ModelBase->setTable("report_tb");
                    $ModelBase->update($BookFlight, $condition);
                }


                $errorsController = $this->getController('errors');

                $errMsg = $errorsController->processError($book['Messages']['errorMessage'] , 'flight' , 'book' , $book['SourceId']);

                $MessageError = functions::ShowError($book['Messages']['errorCode']);
                $data_error['client_id'] = CLIENT_ID;
                $data_error['message_agency'] = $errMsg['displayAgency'];
                $data_error['message_passenger'] = $errMsg['displayPassenger'];
                $data_error['message_admin'] = $errMsg['displayAdmin'];
                $data_error['request_number'] = $RequestNumber;
                $data_error['action'] = 'Book';
                $data_error['creation_date_int'] = time();
                $this->getController('logErrorFlights')->insertLogErrorFlights($data_error);


                $result['result_status'] = 'error';
                $result['result_message'] = $MessageError;
                $result['result_code'] = $book['Messages']['errorCode'];


            }
        }
        else {
            $BookFlight['successfull'] = 'error';
            $condition = "request_number='{$RequestNumber}'";
            $Model->setTable("book_local_tb");
            $res = $Model->update($BookFlight, $condition);
            if ($res) {
                $ModelBase = Load::library('ModelBase');
                $ModelBase->setTable("report_tb");
                $ModelBase->update($BookFlight, $condition);
            }

            $MessageError = functions::ShowError($book['Messages']['errorCode']);


            $errorsController = $this->getController('errors');
            $errMsg = $errorsController->processError('null' , 'flight' , 'book' , $book['SourceId']);

            $data_error['message_agency'] = $errMsg['displayAgency'];
            $data_error['message_passenger'] = $errMsg['displayPassenger'];
            $data_error['message_admin'] = $errMsg['displayAdmin'];
            $data_error['client_id'] = CLIENT_ID;
            $data_error['request_number'] = $RequestNumber;
            $data_error['action'] = 'Book';
            $this->getController('logErrorFlights')->insertLogErrorFlights($data_error);
            $result['result_status'] = 'error';
            $result['result_message'] = $MessageError;
            $result['result_code'] = $book['Messages']['errorCode'];


        }


        return $result;
    }

#endregion
#region type_title

    public function type_title($title, $type)
    {

        if ($type == "Adt") {
            if ($title == 'Male') {
                return 'MR';
            } else if ($title == 'Female') {
                return 'MS';
            }
        } else if ($type == "Chd" || $type == "Inf") {
            if ($title == 'Male') {
                return 'MSTR';
            } else if ($title == 'Female') {
                return 'MISS';
            }
        }
    }

#endregion
#region commission

    public function commission($flight_type, $api_price, $private = NULL, $price_change = NULL, $price_change_type = NULL, $SourceId,$priceFare,$IsInternal)
    {
        /*
         * @param $flight_type string , value is charter OR system;
         * @param $api_price  int , value is basefare of api output
         * @param $private string , value is public OR private ;
         * @param $price_change int , value calculate in function getPriceChanges ;
         * @param $price_change_type string , value is cost or percent ;
         */

        $MarkupForSourceId = functions::MarkupForSourceId();

        if (($IsInternal =='1'  && $SourceId !='14') || ($SourceId != '10' && $SourceId !='14' && $SourceId !='15')) {
            if ($flight_type == "charter" || ($IsInternal =='0' && $flight_type == "system") ) {
//                $api_commission = (in_array($SourceId, $MarkupForSourceId)) ? "15000" : '0';
                $api_commission = '0';
                $agency_commission = (($price_change_type == 'percent') ? (($api_price + $api_commission) * ($price_change / 100)) : $price_change);
                $supplier_commission = ($api_price + $api_commission);
            } else if ($flight_type == "system" && $private == "public") {
//                $api_commission = "10000";
                $api_commission = "0";
                $agency_commission = round($priceFare * (4 / 100));
                $supplier_commission = $api_price - $agency_commission;
            } else if ($flight_type == "system" && $private == "private") {
//                $api_commission = "5000";
                                $api_commission = "0";
                $agency_commission = round($priceFare * (5 / 100));
                $supplier_commission = $api_price - $agency_commission;
            }

        }
        else {
            $api_commission = "0";
            $agency_commission = round(($price_change_type == 'percent' ? ($IsInternal =='1' ? $priceFare : $api_price) * ($price_change / 100) : $price_change));
            $supplier_commission = $api_price;
        }


        return array($api_commission, $agency_commission, $supplier_commission);
    }

#endregion


#region Reserve

    public function Reserve($RequestNumber, $SourceId) {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $sql = "SELECT * FROM book_local_tb WHERE request_number='{$RequestNumber}'";
        $book = $Model->load($sql);

        if($book['direction']== 'return')
        {
            $check_dept_reserve = $this->getModel('bookLocalModel')->get()->where('direction','dept')->where('factor_number',$book['factor_number'])->find();
            error_log('try show result of dept book' . $book['direction'] . ' And ticketed in : ' . date('Y/m/d H:i:s') . ' buy  With RequestNumber : =>' . $RequestNumber . ' AND array Equal  =>' . json_encode($check_dept_reserve, true) . " \n", 3, LOGS_DIR . 'log_method_reserve.txt');

            if($check_dept_reserve['successfull'] !='book'){
                return false ;
            }
        }

        error_log('try show result method ticketed in : ' . date('Y/m/d H:i:s') . ' buy  With RequestNumber : =>' . $RequestNumber . 'additional 1' . " \n", 3, LOGS_DIR . 'MethodInputCounter.txt');
        if (!empty($book) && ($book['successfull'] != "book")) {



            $url = $this->apiAddress . "Flight/Reserve/{$RequestNumber}";


            $dataReserve['subAgencyId'] = array();
            $agencyInfo = $this->getController('agency')->subAgencyInfo();
            if ($agencyInfo != null && !empty($agencyInfo['sepehr_username']) && !empty($agencyInfo['sepehr_password'])) {
                $dataReserve['subAgencyId'] = $agencyInfo['id'];
            }


            $Reserve = $this->curlExecution($url, json_encode($dataReserve), 'yes');


            error_log('try show result method of url' . $url . ' And ticketed in : ' . date('Y/m/d H:i:s') . ' buy  With RequestNumber : =>' . $RequestNumber . ' AND array Equal  =>' . json_encode($Reserve, true) . " \n", 3, LOGS_DIR . 'log_method_reserve.txt');
            if ($book['api_id'] == '10') {
                $cellArray = array(
                    'afraze' => '09916211232',
                    'fanipor' => '09129409530',
                    'abbasi' => '09211559872',
                    'abbasi_' => '09057078341',
                    'bahrami' => '09351252904',
                    'alami' => '09155909722',

                );
                $ServerName = '';
                switch ($book['api_id']) {
                    case '10':
                        $ServerName = '9';
                        break;
                }
                /** @var smsServices $smsController */
                $smsController = Load::controller('smsServices');
                $objSms = $smsController->initService('1');
//                if ($objSms) {
//                    $smsController->smsByPattern('sdjcrwt33joljg9', $cellArray, array('serverId' => $ServerName,'requestNumber'=> $RequestNumber));
//
//                }
            }

//            if ($book['api_id'] == '16' || $book['api_id'] == '18' || $book['api_id'] == '19') {
//                $cellArray = array(
//                    'araste' => '09211559872',
//                    'afraze' => '09916211232',
//                    'fanipor' => '09129409530',
//                    'abbasi_' => '09057078341',
//                    'alami' => '09155909722',
//                );
//                $ServerName = '';
//                switch ($book['api_id']) {
//                    case '16':
//                        $ServerName = ' 16';
//                        break;
//                    case '18':
//                        $ServerName = ' 18';
//                        break;
//                    case '19':
//                        $ServerName = ' 19';
//                        break;
//                }
//                /** @var smsServices $smsController */
//                $smsController = Load::controller('smsServices');
//                $objSms = $smsController->initService('1');
//                if ($objSms) {
//                    $smsController->smsByPattern('aktmfuzvx1j0oa0', $cellArray, array('source_id' => $ServerName ,'request_number'=> $RequestNumber));
//
//                }
//            }




            if (!empty($Reserve) && $Reserve['Result']['ProviderStatus'] == 'Success' && $Reserve['Result']['Request']['Status'] == 'Ticketed') {
                error_log('success Reserve===>' . date('Y/m/d H:i:s') . '=>' . $RequestNumber, 3, LOGS_DIR . 'log_method_reserve.txt');


                $email_buyer      = $book['email_buyer'];
//                if (isset($email_buyer) && !empty($email_buyer)) {
//
//
//                    $agency = $this->getModel('clientsModel')->get()->where('id', CLIENT_ID)->find();
//
//
//                    $subject = $agency['AgencyName'] . " - ";
//                    $subject .= "بلیط پرواز ";
//                    $subject .= $book['origin_city'];
//                    $subject .= " به ";
//                    $subject .= $book['desti_city'];
//
//                    $message = "رزرو شما با موفقیت صادر شد، جهت دریافت بلیط روی لینک زیر کلیک نمایید :\r\n";
//
//                    $target = (SOFTWARE_LANG == 'fa') ? 'parvazBookingLocal' : 'ticketForeign';
//                    $message .= $agency['MainDomain'] . "/gds/pdf&target=" . $target . "&id=" . $RequestNumber;
//
//                    $headers = "From:generaltravel2000@gmail.com\r\n" .
//                        "Reply-To:generaltravel2000@gmail.com\r\n" .
//                        "X-Mailer: PHP/" . phpversion();
//
//                    $sendMail = mail($email_buyer, $subject, $message, $headers);
//
//                }

                $members = Load::controller( 'members' );
                $members->SendEmailForOther($email_buyer, $RequestNumber);


                return $Reserve;
            }
            else if (!empty($Reserve) && $Reserve['Result']['ProviderStatus'] != 'Success') {

                if ($book['api_id'] == '14' || $book['api_id'] == '10'|| $book['api_id'] == '18'|| $book['api_id'] == '19') {
                    $cellArray = array(
                        'abbasi_' => '09057078341',
                        'bahrami' => '09351252904',
                        'alami' => '09155909722',
                    );
                    $ServerName = '';
                    switch ($book['api_id']) {
                        case '14':
                            $ServerName = '14';
                            break;
                        case '10':
                            $ServerName = '9';
                            break;
                        case '18':
                            $ServerName = '18';
                            break;
                        case '19':
                            $ServerName = '19';
                            break;
                    }
                    /** @var smsServices $smsController */
                    $smsController = Load::controller('smsServices');
                    $objSms = $smsController->initService('1');
//                    if ($objSms) {
//                        $smsController->smsByPattern('sdjcrwt33joljg9', $cellArray, array('serverId' => $ServerName,'requestNumber'=> $RequestNumber));
//
//                    }
                }

                $MessageError = functions::ShowError($Reserve['Messages']['errorCode']);


                $errorsController = $this->getController('errors');
                $errMsg = $errorsController->processError($Reserve['Messages']['errorMessage'] , 'flight' , 'reserve' , $book['api_id']);

                $data_error['client_id'] = CLIENT_ID;
                $data_error['message_agency'] = $errMsg['displayAgency'];
                $data_error['message_passenger'] = $errMsg['displayPassenger'];
                $data_error['message_admin'] = $errMsg['displayAdmin'];
                $data_error['request_number'] = $RequestNumber;
                $data_error['action'] = 'Reserve';
                $data_error['creation_date_int'] = time();
                $this->getController('logErrorFlights')->insertLogErrorFlights($data_error);

                $BookFlight['successfull'] = 'error';
                $condition = "request_number='{$RequestNumber}' ";
                $Model->setTable("book_local_tb");
                $res = $Model->update($BookFlight, $condition);
                if ($res) {
                    $ModelBase->setTable("report_tb");
                    $ModelBase->update($BookFlight, $condition);
                }
                error_log('error Reserve===>' . date('Y/m/d H:i:s') . '=>' . $RequestNumber . "************************************  \n ", 3, LOGS_DIR . 'log_method_reserve.txt');

                return false;
            }

        }


    }


#endregion


    public function ReserveByBankCharter724($RequestNumber)
    {

        $Model = Load::library('Model');
        $sql = "SELECT * FROM book_local_tb WHERE request_number='{$RequestNumber}'";
        $book = $Model->load($sql);
        if (!empty($book) && $book['successfull'] != "book" && $book['api_id'] == '8') {
            $url = $this->apiAddress . "Flight/reserveByBank/{$RequestNumber}";

            $dataSend['price'] = functions::CalculateDiscount($RequestNumber);
            $dataSend['url'] = ROOT_ADDRESS."/returnBankPrivateSource7?requestNumber={$RequestNumber}";
            $emptyArray = json_encode($dataSend);
            $Reserve = $this->curlExecution($url, $emptyArray, 'yes');
            error_log('try show result method ticketedByBank in : ' . date('Y/m/d H:i:s') . ' buy  With RequestNumber : =>' . $book['request_number'] . ' AND array Equal  =>' . json_encode($Reserve, true) . " \n", 3, LOGS_DIR . 'log_method_reserve_by_bank.txt');

            if (empty($Reserve)) {
                $MessageError = functions::Xmlinformation("FinalReservationError");

                $data_error['client_id'] = CLIENT_ID;
                $data_error['request_number'] = $RequestNumber;
                $data_error['action'] = 'Reserve';
                $data_error['creation_date_int'] = time();
                $this->getController('logErrorFlights')->insertLogErrorFlights($data_error);
            } elseif (!empty($Reserve) && !$Reserve['result']) {
                $MessageError = functions::ShowError($Reserve['Messages']['errorCode']);

                $data_error['client_id'] = CLIENT_ID;
                $data_error['request_number'] = $RequestNumber;
                $data_error['action'] = 'Reserve';
                $data_error['creation_date_int'] = time();
                $this->getController('logErrorFlights')->insertLogErrorFlights($data_error);
            }else{
                header("Location:". $Reserve['data']['linkpay']);
            }
        } else {
            $MessageError = functions::Xmlinformation("InvalidFlight");

            $data_error['client_id'] = CLIENT_ID;
            $data_error['request_number'] = $RequestNumber;
            $data_error['action'] = 'Reserve';
            $data_error['creation_date_int'] = time();
            $this->getController('logErrorFlights')->insertLogErrorFlights($data_error);
        }


        return false;

    }

    public function getFinalDataSource7($RequestNumber,$dataReturn)
    {
        $url = $this->apiAddress . "Flight/getDataTicket/{$RequestNumber}";
        $dataReturn['price'] = functions::CalculateDiscount($RequestNumber);
        $dataReturn['url'] = ROOT_ADDRESS."/returnBankPrivateSource7?requestNumber={$RequestNumber}";
        $data = json_encode($dataReturn);
        $Reserve = $this->curlExecution($url, $data, 'yes');
        error_log('try show result method ticketedByBank in : ' . date('Y/m/d H:i:s') . ' buy  With RequestNumber : =>' . $RequestNumber . ' AND array Equal  =>' . json_encode($Reserve, true) . " \n", 3, LOGS_DIR . 'log_method_return_Source7_by_bank.txt');

        return $Reserve;
    }
#region convert_toman_rial

    public function convert_toman_rial($param, $type, $ZoneType = null)
    {

        if ($type == "charter" && $ZoneType != "portal") {
            return ($param + 1500) * 10;
        } else {
            return $param *= 10;
        }
    }

#endregion
//region ShowPriceTicket

    public function ShowPriceTicket($type, $price, $SourceId)
    {

        switch ($SourceId) {
            case '12':
            case '13':
                if ($type == 'charter') {
                    return (functions::convert_toman_rial(($price + 1500))) ;
                } elseif ($type == 'system') {
                    return ($price) * 10;
                }
                break;
            case '10':
            case '15':
            case '17':
            case '18':
            case '19':
            case '20':
            case '22':
            case '21':
            case '43':
                return round($price);
                break;
            /*  case '1':
              case '11':
              case '8':
              case '14':
              case '16':
              case '5':*/
            default:
                return (functions::convert_toman_rial($price)) ;
                break;

        }
    }
    //endregion
#region calculateTransactionPrice

    public function calculateTransactionPrice($requestNumber)
    {
        $bookLocal = Load::model('book_local');
        $privateCharterSources = functions::privateCharterFlights();
        $ClientIdPrivateCharterSources = functions::ClientIdCharterPrivateFlight();
        $percentPublic = functions::percentPublic() ;

        $rec = $bookLocal->GetInfoBookLocal($requestNumber);
        list($TicketPrice,$fare) = $this->get_total_ticket_price($requestNumber, 'no');

        $check_private = ($rec['pid_private'] == '1') ? 'private' : 'public';

        $totalAmount = 0;
        if ($rec['IsInternal'] == '1') {
            if ($rec['flight_type'] == "system") {//بلیط سیستمی
                if ($check_private == 'public') {

//                    dar tarikh 13 ordibehesht 1404 tebgh darkhast aghaye afshar systemy ha haman meghdar total azashon kasr beshe
//                    $totalAmount = $TicketPrice - ($fare * $percentPublic) + ($rec['irantech_commission'] * $rec['count_id']);
//                    $totalAmount = $TicketPrice - (($TicketPrice - (($TicketPrice * 4573) / 100000)) * (($percentPublic))) + ($rec['irantech_commission'] * $rec['count_id']);
                    if($rec['api_id'] == 17) {
                        //dar tarikh 21 ordibehesht 1404 tebgh darkhast aghaye afshar source 17 bayad 3 darsad fare azash kam she az moshtari gerefte she
                        $percent = 3 ;
                        $totalAmount = $TicketPrice - (($fare * $percent) / 100) + ($rec['irantech_commission'] * $rec['count_id']);
                    }else{
                        $totalAmount = $TicketPrice + ($rec['irantech_commission'] * $rec['count_id']);
                    }
                    $type = ' سیستمی پید اشتراکی ';
                } else {
                    $totalAmount = 0 + ($rec['irantech_commission'] * $rec['count_id']);
                    $type = ' سیستمی پید اختصاصی ';
                }
            } else {//بلیط چارتری
                if (in_array($rec['api_id'], $privateCharterSources) && in_array(CLIENT_ID, $ClientIdPrivateCharterSources)) {
                    $totalAmount = 0 + ($rec['irantech_commission'] * $rec['count_id']);
                    $type = ' چارتری پید اختصاصی ';
                } else {
                    $totalAmount = $TicketPrice + ($rec['irantech_commission'] * $rec['count_id']);
                    $type = ' چارتری ';
                }
            }
        } else {
            if ($rec['api_id'] != '10') {
                if ($rec['flight_type'] != "system") {
                    $totalAmount = $TicketPrice + ($rec['irantech_commission'] * $rec['count_id']);
                    $type = ' چارتری  خارجی ';
                } else {
                    if ($check_private == 'private') {
                        $totalAmount = 0 + ($rec['irantech_commission'] * $rec['count_id']);
                        $type = ' سیستمی پید اختصاصی خارجی ';
                    } else {
                        if ($rec['api_id'] == '8') {
                            $totalAmount = $TicketPrice - ($fare * $percentPublic) + ($rec['irantech_commission'] * $rec['count_id']);
//                            $totalAmount = $TicketPrice - (($TicketPrice - (($TicketPrice * 4573) / 100000)) * (($percentPublic))) + ($rec['irantech_commission'] * $rec['count_id']);
                        } else {
                            $totalAmount = $TicketPrice + ($rec['irantech_commission'] * $rec['count_id']);
                        }
                        $type = ' سیستمی پید اشتراکی خارجی ';
                    }

                }

            } else if ($rec['api_id'] == '10') {
                if ($rec['flight_type'] == "system") {
                    if ($check_private == 'private') {
                        $totalAmount = 0 + ($rec['irantech_commission'] * $rec['count_id']);
                        $type = ' سیستمی پید اختصاصی خارجی ';
                    } else {
                        $totalAmount = $TicketPrice + ($rec['irantech_commission'] * $rec['count_id']);
                        $type = ' سیستمی پید اشتراکی خارجی ';
                    }
                } else {
                    $totalAmount = $TicketPrice + ($rec['irantech_commission'] * $rec['count_id']);
                    $type = ' چارتری خارجی ';
                }
            }
        }

        $output['transactionPrice'] = $totalAmount;
        $output['pidTitle'] = $type;

        return $output;
    }
#endregion
    /*#region calculateTransactionPriceByTemprory
        public function calculateTransactionPriceByTemprory($TemproryResult)
        {

            $isInternal = ($TemproryResult['IsInternalFlight'] == '1')  ? 'internal' : 'external' ;
                $check_private = functions::checkConfigPid($TemproryResult['Airline_IATA'],$isInternal,$TemproryResult['FlightType'] );

            $ClientIdPrivateCharter724 = functions::ClientIdCharterPrivateFlight();
            $PrivateCharter724 = functions::privateCharterFlights();

            if ($TemproryResult['IsInternalFlight'] == '1') {
                if ($check_private == 'public') {
                    if ($TemproryResult['FlightType'] == 'charter' && (!in_array($TemproryResult['SourceID'], $PrivateCharter724) || (in_array($TemproryResult['SourceID'], $PrivateCharter724) && !in_array(CLIENT_ID, $ClientIdPrivateCharter724)))) {
                        $CalcPrice = (($TemproryResult['AdtPrice'] * $TemproryResult['Adt_qty']) + 15000) + (($TemproryResult['ChdPrice'] * $TemproryResult['Chd_qty']) + 15000) + (($TemproryResult['InfPrice'] * $TemproryResult['Inf_qty']) + 15000);
                    } else if ($TemproryResult['FlightType'] == 'charter' && (in_array($TemproryResult['SourceID'], $PrivateCharter724) && in_array(CLIENT_ID, $ClientIdPrivateCharter724))) {
                        $CalcPrice = 0;
                    } else {
                        $CalcPrice = ($TemproryResult['AdtPrice'] * $TemproryResult['Adt_qty']) + ($TemproryResult['ChdPrice'] * $TemproryResult['Chd_qty']) + ($TemproryResult['InfPrice'] * $TemproryResult['Inf_qty']);
                    }
                } else {
                    $CalcPrice = 0;
                }
            } else {
                if (($check_private == 'public') || ($check_private == 'private' && $TemproryResult['FlightType'] == 'charter')) {
                    if ($TemproryResult['FlightType'] == 'charter') {
                        $CalcPrice = (($TemproryResult['AdtPrice'] * $TemproryResult['Adt_qty']) + 15000) + (($TemproryResult['ChdPrice'] * $TemproryResult['Chd_qty']) + 15000) + (($TemproryResult['InfPrice'] * $TemproryResult['Inf_qty']) + 15000);
                    } else {
                        $CalcPrice = ($TemproryResult['AdtPrice'] * $TemproryResult['Adt_qty']) + ($TemproryResult['ChdPrice'] * $TemproryResult['Chd_qty']) + ($TemproryResult['InfPrice'] * $TemproryResult['Inf_qty']);
                    }
                } else {
                    $CalcPrice = 0;
                }
    //            $CalcPrice = ($TemproryResult['AdtPrice'] * $TemproryResult['Adt_qty']) + ($TemproryResult['ChdPrice'] * $TemproryResult['Chd_qty']) + ($TemproryResult['InfPrice'] * $TemproryResult['Inf_qty']);
            }

            return $CalcPrice;
        }
    #endregion*/
#region get_total_ticket_price

    public function get_total_ticket_price($RequestNumber, $FlagPriceChange = 'yes', $calculat = null)
    {
        //yes means nesesary calculate  price changes
        $model = Load::model('book_local');
        $rec = $model->getWithCategory($RequestNumber);

        $amount = 0;
        $fare = 0;
        foreach ($rec as $each) {

            //در هر رکورد فقط یکی از قیمت ها با توجه به سن مقدار دارد و دوتای دیگر صفر هستند
            if ($each['flight_type'] == 'system') {
                $amount += $each['adt_price'] + $each['chd_price'] + $each['inf_price'];
                $fare += $each['adt_fare'] + $each['chd_fare'] + $each['inf_fare'];
            }
            else {
                $amount += $each['api_commission'] + $each['adt_price'] + $each['chd_price'] + $each['inf_price'];
                if ($FlagPriceChange == "yes") {
                    //تغییرات قیمت فقط برای چارتری
                    if ($each['flight_type'] == 'charter') {
                        if ($each['price_change'] > 0 && $each['price_change_type'] == 'cost') {
                            $amount += $each['price_change'];
                        } elseif ($each['price_change'] > 0 && $each['price_change_type'] == 'percent') {
                            $amountFake = $each['api_commission'] + $each['adt_price'] + $each['chd_price'] + $each['inf_price'];
                            $amount += $amountFake * ($each['price_change'] / 100);
                        }
                    }
                }
                $fare = '0';
            }
        }
        return array($amount,$fare);
    }

    public function get_total_customer_benefit_system_flight($RequestNumber)
    {
        $model = Load::model('book_local');
        $rec = $model->getWithCategory($RequestNumber);

        $amount = 0;
        foreach ($rec as $each) {

            if ($each['flight_type'] == 'system') {
                $amount += $each['system_flight_commission'];
            }
        }
        return $amount;
    }

#endregion
#region getAirport

    public function getAirport($Departure_Code)
    {
        $select_airport = new Model();
        $sql = " SELECT * FROM flight_route_tb WHERE Departure_Code='{$Departure_Code}' AND local_portal='0' ORDER BY  priorityArrival=0,priorityArrival ASC";
        $airport = $select_airport->select($sql);

        return $airport;
    }

#endregion

#region NameCity

    public function NameCity($param)
    {

        $select_airport = Load::library('ModelBase');

        $sql = " SELECT DISTINCT  Departure_City FROM flight_route_tb WHERE Departure_Code='{$param}'  ";

        $arival_city = $select_airport->load($sql);

        return $arival_city['Departure_City'];
    }

#endregion

    /*#region DetailTicket

        public function DetailTicket($RequestNumber, $AirlineIata)
        {
            $username = $this->username;

            $url = "http://Api.HiHoliday.ir/V4/{$this->typeRequest}/Detail/{$this->key_tabadol}/{$username}/{$RequestNumber}";

            $dataalaki = array();

            $detail = $this->curlExecution_Get($url, $dataalaki);

            return $detail;
        }

    #endregion*/

#region FristCheckCredit

    /*public function FristCheckCredit($TemproryResult, $credit = null)
    {
        $check_private = functions::check_pid($TemproryResult['Airline_IATA']);

        if ($credit != null) {
            $CreditTotal = $credit;
        } else {
            $CreditTotal = $this->get_credit();
        }

        if ($TemproryResult['IsInternalFlight'] == '1') {
            if (($check_private == 'public') || ($check_private == 'private' && $TemproryResult['FlightType'] == 'charter')) {
                if ($TemproryResult['FlightType'] == 'charter') {
                    $CalcPrice = (($TemproryResult['AdtPrice'] * $TemproryResult['Adt_qty']) + 15000) + (($TemproryResult['ChdPrice'] * $TemproryResult['Chd_qty']) + 15000) + (($TemproryResult['InfPrice'] * $TemproryResult['Inf_qty']) + 15000);
                } else {
                    $CalcPrice = ($TemproryResult['AdtPrice'] * $TemproryResult['Adt_qty']) + ($TemproryResult['ChdPrice'] * $TemproryResult['Chd_qty']) + ($TemproryResult['InfPrice'] * $TemproryResult['Inf_qty']);
                }


                if ($CalcPrice > $CreditTotal) {
                    $result['status'] = 'FALSE';
                    $result['credit'] = $CreditTotal - $CalcPrice;
                } else {
                    $result['status'] = 'TRUE';
                    $result['credit'] = $CreditTotal - $CalcPrice;
                }
            } else {
                $result['status'] = 'TRUE';
                $result['credit'] = '';
            }
        } else {
            $CalcPrice = ($TemproryResult['AdtPrice'] * $TemproryResult['Adt_qty']) + ($TemproryResult['ChdPrice'] * $TemproryResult['Chd_qty']) + ($TemproryResult['InfPrice'] * $TemproryResult['Inf_qty']);
            if ($CalcPrice > $CreditTotal) {
                $result['status'] = 'FALSE';
                $result['credit'] = $CreditTotal - $CalcPrice;
            } else {
                $result['status'] = 'TRUE';
                $result['credit'] = $CreditTotal - $CalcPrice;
            }
        }

        return $result;
    }*/

#endregion
#region CalenderFlight

    function CalenderFlight($Departure_Code, $Arrival_Code, $dateNow, $dateEnd)
    {

        $url = "http://api.hiholiday.ir/V4/Flight/CalendarRoute/c4463bb2-b13c-46f1-97b9-863a8e7e3a67/{$Departure_Code}/{$Arrival_Code}/{$dateNow}/{$dateEnd}";
        $dataEmpty = array();

        $data = curlExecution_Get($url, $dataEmpty);

        return $data;
    }

#endregion
#region MinimumPriceFlightInWeek

    function MinimumPriceFlightInWeek($Departure_Code, $Arrival_Code, $dateNow, $dateEnd)
    {

        $url = "http://api.hiholiday.ir/V4/Flight/CalendarRoute/c4463bb2-b13c-46f1-97b9-863a8e7e3a67/{$Departure_Code}/{$Arrival_Code}/{$dateNow}/{$dateEnd}";
        $dataEmpty = array();

        $data = $this->curlExecution_Get($url, $dataEmpty);

        return $data;
    }

#endregion


#region getPriceChanges

    public function getPriceChanges($airline, $deptDate, $origin = '', $destination = '')
    {
        $model = Load::library('Model');
        $sql = "SELECT * FROM price_changes_tb
        WHERE (airline_iata = '{$airline}' OR  airline_iata ='allAirline') AND (start_date <= '{$deptDate}' AND end_date >= '{$deptDate}') AND is_enable='yes'";
        $result = $model->load($sql);
        return $result;
    }

#endregion


#region checkDuplicate724
    public function checkDuplicate724($requestNumber)
    {
        $url = $this->apiAddress . "Flight/checkDuplicate724/{$requestNumber}";
        $data = json_encode(array());
        $resultCheckDuplicate = $this->curlExecution($url, $data, 'yes');
        error_log('try show result method ticketedByBank in : ' . date('Y/m/d H:i:s') . ' buy  With RequestNumber : =>' . $requestNumber . ' AND array Equal  =>' . json_encode($resultCheckDuplicate, true) . " \n", 3, LOGS_DIR . 'log_method_Duplicate_charter724.txt');
        return $resultCheckDuplicate['result'];
    }
#endregion


#region getAmountPenaltyAltrabo
    public function getAmountPenaltyAltrabo($requestNumber,$dataCancel)
    {
        $url = $this->apiAddress . "Flight/getAmountPenalty/{$requestNumber}";
        $data = json_encode($dataCancel);
        $resultGetAmountPenaltyAltrabo = $this->curlExecution($url, $data, 'yes');

        error_log('try show result method cancelAlterabo : ' . date('Y/m/d H:i:s') . ' buy  With RequestNumber : =>' . $requestNumber . ' AND array Equal  =>' . json_encode($resultGetAmountPenaltyAltrabo, true) . " \n", 3, LOGS_DIR . 'log_method_canceli_altrabo_view.txt');

        return $resultGetAmountPenaltyAltrabo;

    }
#endregion

#region getRefuandAltrabo
    public function getRefuandAltrabo($requestNumber,$dataCancel)
    {
        $url = $this->apiAddress . "Flight/refundAltrabo/{$requestNumber}";
        $data = json_encode($dataCancel);
        $resultGetAmountPenaltyAltrabo = $this->curlExecution($url, $data, 'yes');


        error_log('try show result method cancelAlterabo in : ' . date('Y/m/d H:i:s') . ' buy  With RequestNumber : =>' . $requestNumber . ' AND data is===>' . $data . ' array Equal  =>' . json_encode($resultGetAmountPenaltyAltrabo, true) . " \n", 3, LOGS_DIR . 'log_method_canceli_altrabo.txt');

        return $resultGetAmountPenaltyAltrabo;

    }
    public function clientFlightData()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if($_POST['code']){
                $code = isset($_POST['code']) ? 'code=' . $_POST['code'] : null;
            }
            if($_POST['date_start']){
                $date_start = isset($_POST['date_start']) ? 'date_start=' . $_POST['date_start'] : null;
            }
            if($_POST['date_end']){
                $date_start = isset($_POST['date_end']) ? 'date_end=' . $_POST['date_end'] : null;

            }
        }
        $query_param = implode('',[$code, $date_start, $date_end]);
        $url = "https://safar360.com/Core/V-1/Flight/getRequestedCode/$query_param" ; //TODO change this url accordingly

        header('Content-Type: application/json');
        $result = functions::curlExecution($url,[]);
        $final_response = [] ;
        foreach($result as $data){
            $final_response[] = [
                'id'     => $data['id'] ,
                'code'     => $data['code'] ,
                'businessMethodName'     => $data['businessMethodName'] ,
                'ApiMethodName'     => $data['ApiMethodName'] ,
                'response'     => htmlentities($data['response']) ,
                'request'     => htmlentities($data['request']) ,
            ];
        }
        echo json_encode($final_response);
    }
}

?>