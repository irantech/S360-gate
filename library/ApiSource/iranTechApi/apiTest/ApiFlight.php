<?php


class ApiFlight extends clientAuth
{
    private $content;
    private $apiAddress;
    public $transactions;
    public function __construct() {

        $this->transactions = $this->getModel('transactionsModel');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        header("Access-Control-Allow-Credentials: true");

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            // اگر مرورگر درخواست preflight فرستاد، یه پاسخ ساده بده و برو
            header("HTTP/1.1 200 OK");
            exit();
        }
        parent::__construct();

        header("Content-type: application/json;");






        if ($_SERVER['REQUEST_METHOD'] == 'POST' && (strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false)) {
            $this->content = json_decode(file_get_contents('php://input'), true);

            if (isset($this->content['userName']) && !empty($this->content['userName'])) {
                $userName = filter_var($this->content['userName'], FILTER_SANITIZE_STRING);
                $key = filter_var($this->content['key'], FILTER_SANITIZE_STRING);
                $ModelBase = Load::library('ModelBase');
                $Sql = "SELECT * FROM client_user_api WHERE userName='{$userName}' AND keyTabdol='{$key}' AND is_enable='1'";
                $resClient = $ModelBase->load($Sql);


                if (!empty($resClient) && $resClient['clientId']=='299') {
                    if (empty($this->content['sourceId']) && empty($this->content['serviceId'])) {
                        $sourceId = '1';
                        $serviceId = '1';
                    } else {
                        $sourceId = filter_var($this->content['sourceId'], FILTER_SANITIZE_NUMBER_INT);
                        $serviceId = filter_var($this->content['serviceId'], FILTER_SANITIZE_NUMBER_INT);
                    }

                    $SqlClientAuth = "SELECT * FROM client_auth_tb WHERE ClientId='{$resClient['clientId']}' AND SourceId='{$sourceId}' AND serviceId='{$serviceId}' AND IsActive='Active'";
                    $resClientAuth = $ModelBase->load($SqlClientAuth);

                    if (!empty($resClientAuth)) {
                        unset($this->content['key']);
                        $url = $_SERVER['REQUEST_URI'];

                        $routeUrl = explode('/', $url);

                        if ($routeUrl[2] == 'apiTest') {
                            $this->apiAddress = 'http://safar360.com/CoreTest/V-1/';
                        } else {
                            $infoCode = array(
                                'Result' => array(
                                    'Value' => ''
                                ),
                                'RequestStatus' => 'Error',
                                'Message' => 'NotValidTypeRequest',
                                'MessageCode' => '0',
                                'Code' => ''
                            );

                            echo json_encode($infoCode);
                            die();
                        }

                        $dataInfo['clientId'] = $resClient['clientId'];
                        $dataInfo['userName'] = $resClientAuth['Username'];

                        $method = $routeUrl[3];

                        if (isset($routeUrl[4]) && !empty($routeUrl[4])) {
                            $dataInfo['code'] = $routeUrl[4];
                        }

                        echo $this->$method($this->content, $dataInfo);
                    } else {
                        $infoCode = array(
                            'Result' => array(
                                'Value' => ''
                            ),
                            'RequestStatus' => 'Error',
                            'Message' => 'Your Account Is Not Active',
                            'MessageCode' => 'E0User',
                            'Code' => ''
                        );
                        echo json_encode($infoCode);
                    }
                } else {
                    $infoCode = array(
                        'Result' => array(
                            'Value' => ''
                        ),
                        'RequestStatus' => 'Error',
                        'Message' => 'NotValidUserNameOrPassword',
                        'MessageCode' => 'E2User',
                        'Code' => ''
                    );
                    echo json_encode($infoCode);
                }
            } else {
                $infoCode = array(
                    'Result' => array(
                        'Value' => ''
                    ),
                    'RequestStatus' => 'Error',
                    'Message' => 'NotValidUserNameOrPassword',
                    'MessageCode' => 'E1User',
                    'Code' => ''
                );
                echo json_encode($infoCode);
            }


        } else {
            $infoCode = array(
                'Result' => array(
                    'Value' => ''
                ),
                'RequestStatus' => 'Error',
                'Message' => 'NotValidTypeRequest',
                'MessageCode' => 'E0Request',
                'Code' => ''
            );

            echo json_encode($infoCode);
        }
    }


    public function GetCode($param, $dataInfo) {

        $userName = $dataInfo['userName'];
        $url = $this->apiAddress . "Flight/GetCode/" . $userName;
        $JsonArray = array();
        $GetCode = functions::curlExecution($url, $JsonArray, 'yes');
        return json_encode($GetCode);
    }

    public function search($param, $dataInfo) {
        /** @var checkLimitPrice $check_limit_price_controller */
        $check_limit_price_controller = Load::controller('checkLimitPrice');
        if($param['IsInternal'] == false && $param['Origin']=='THR'){
            $infoCode = array(
                'Result' => array(
                    'Value' => ''
                ),
                'RequestStatus' => 'Error',
                'Message' => 'The Search Request Is Invalid',
                'MessageCode' => 'KKRequest',
                'Code' => ''
            );

            return  json_encode($infoCode);
        }

        $url = $this->apiAddress . "Flight/Search/" . $dataInfo['code'];
        $param['UserName'] = $dataInfo['userName'];
        $JsonArray = json_encode($param);
        $search = functions::curlExecution($url, $JsonArray, 'yes');


//        if ($param['IsInternal']) {
//
//            $data_check_limit['origin'] = $param['Origin'];
//            $data_check_limit['destination'] = $param['Destination'];
//            $result_check_price = $check_limit_price_controller->getChecKLimits($data_check_limit);
//
//            $array_check = [];
//
//            foreach ($search['Flights'] as $item) {
//
//                if ($item['PassengerDatas'][0]['TotalPrice'] == 0 || empty($result_check_price) || (($result_check_price['price'] / 10) >= $item['PassengerDatas'][0]['TotalPrice']) || $item['FlightType'] == 'system') {
//                    $array_check[] = $item;
//
//                }
//            }
//
//            $search['Flights'] = $array_check;
//        }




        return json_encode($search, 256);
    }


    public function revalidate($param, $dataInfo) {
        $url = $this->apiAddress . "Flight/Revalidate/" . $dataInfo['code'];
        $param['UserName'] = $dataInfo['userName'];
        $JsonArray = json_encode($param);
        $revalidate = functions::curlExecution($url, $JsonArray, 'yes');
        return json_encode($revalidate);
    }


    public function preReserve($param, $dataInfo) {
        $url = $this->apiAddress . "Flight/PreReserve/" . $dataInfo['code'];
        $JsonArray = array();
        $preReserve = functions::curlExecution($url, $JsonArray, 'yes');


        return json_encode($preReserve);
    }

    public function book($param, $dataInfo) {

        $model = Load::library('Model');
        $modelBase = Load::library('ModelBase');
        $apiLocal = Load::library('apiLocal');
        $members_model = Load::model('members');
        $admin = Load::controller('admin');
        $irantechCommission = Load::controller('irantechCommission');
        $requestNumber = $dataInfo['code'];
        $factor_number = substr(time(), 0, 5) . mt_rand(000, 999) . substr(time(), 5, 10);

        $checkExistBookQuery = "SELECT * FROM book_local_tb where request_number='{$requestNumber}'";
        $resultExist = $admin->ConectDbClient($checkExistBookQuery, $dataInfo['clientId'], 'Select', '', '', '');


        if (empty($resultExist)) {

            $requested_data = $param ;
            // change mobile number
            $pre_reserve_data = json_decode($this->preReserve($param, $dataInfo) , true) ;
            $sourceId = $pre_reserve_data['Result']['SourceId'] ;
         
            foreach ($param['Books'] as $key => $passengers) {
                $param['Books'][$key]['Nationality'] = 'IRN' ? 'IR' : $param['Books'][$key]['Nationality'];
                if( $sourceId=='8' && $pre_reserve_data['Result']['Request'] &&  $pre_reserve_data['Result']['Request']['OutputRoutes'][0]['Airline']['Code']=='IS'){
                    //az tarikh 4 bahman1402 mogharar shod baraye airline sepehran va server 7 shomare kharidar ersal shavad
                    $param['Books'][$key]['PhoneNumber']    =  $passengers['PhoneNumber'];
                    $param['Books'][$key]['Email']          =  $passengers['Email'];
                }
                else{
                    if($sourceId=='17') {
                        // dar tarikh 4 azar 1403 bana be darkhast aghaye afshar shomare poshtibani bere be flightio chon baraye moshtari 3 ta sms miraft
                        $param['Books'][$key]['PhoneNumber'] = '09057078341';
                    }else{
                        $param['Books'][$key]['PhoneNumber'] = CLIENT_MOBILE;
                    }
                    $param['Books'][$key]['Email'] = 'safar360@iran-tech.com';
                }
            }
            // change mobile number

            $url = $this->apiAddress . "Flight/Book/" . $requestNumber;
            $JsonArray = json_encode($param);

            $BookFlight = functions::curlExecution($url, $JsonArray, 'yes');
           
            if (isset($BookFlight['Result']['ProviderStatus']) && $BookFlight['Result']['ProviderStatus'] != "Error") {
                $param = $requested_data;
               
                $airlineName = !empty($BookFlight['RequestFlights']['OutputRoutes'][0]['Airline']['Name']) ? $BookFlight['RequestFlights']['OutputRoutes'][0]['Airline']['Name'] : '';
                error_log('try show result Request Client In Book in : ' . date('Y/m/d H:i:s') . 'AND  RequestNumber : => ' . $requestNumber . ': ' . $JsonArray . " \n" . "Response equal in With RequestNumber=>" . $requestNumber . ":" . " " . json_encode($BookFlight, true) . " \n", 3, LOGS_DIR . 'log_Request_Response_Api_Book.txt');

                $members = $this->login_members_online($param['Books'][0]['Email'], $dataInfo['clientId']);
                if (empty($members)) {

                    $dataMember['mobile'] = $param['Books'][0]['PhoneNumber'];
                    $dataMember['telephone'] = '';
                    $dataMember['email'] = $param['Books'][0]['Email'];
                    $dataMember['password'] = $members_model->encryptPassword($param['Books'][0]['PhoneNumber']);
                    $dataMember['is_member'] = '0';
                    $res = $admin->ConectDbClient('', $dataInfo['clientId'], "Insert", $dataMember, "members_tb", "");
                    $membersNew = $this->login_members_online($dataMember['email'], $dataInfo['clientId']);
                    $IdMember = $membersNew['id'];
                } else {
                    $IdMember = $members['id'];
                }

                $Count = count($BookFlight['Result']['Request']['RequestFlights']['OutputRoutes']);

                foreach ($param['Books'] as $key => $passengers) {

                    $iata = $BookFlight['Result']['Request']['RequestFlights']['OutputRoutes'][0]['Airline']['Code'];
                    $isInternal = ($BookFlight['Result']['Request']['IsInternal']) ? 'internal' : 'external';
                    $typeFlight = $BookFlight['Result']['Request']['RequestFlights']['OutputRoutes'][0]['FlightType'];

                    $check_private = (functions::checkConfigPid($iata, $isInternal, $typeFlight, $BookFlight['Result']['SourceId'], $dataInfo['clientId']) == 'private') ? 'private' : 'public';
                    $d['passenger_gender'] = ($passengers['PassengerTitle'] == 'MR') ? 'Male' : 'Female';
                    $d['passenger_name'] = $passengers['PersianFirstName'];
                    $d['passenger_family'] = $passengers['PersianLastName'];
                    $d['passenger_name_en'] = $passengers['FirstName'];
                    $d['passenger_family_en'] = $passengers['LastName'];
                    $d['passenger_birthday'] = str_replace('/', '-', functions::convertDateFlight($passengers['DateOfBirth']));
                    $d['passenger_birthday_en'] = $passengers['DateOfBirth'];
                    $d['passportCountry'] = $passengers['Nationality'] == 'IRN' ? 'IR' :  $passengers['Nationality'];
                    $d['passportNumber'] = $passengers['PassportNumber'];
                    $d['passportExpire'] = $passengers['PassportExpireDate'];
                    $d['mobile_buyer'] = $passengers['PhoneNumber'];
                    $d['email_buyer'] = $passengers['Email'];
                    $d['passenger_national_code'] = $passengers['NationalCode'];
                    $d['passenger_age'] = $passengers['PassengerType'];
                    $d['request_number'] = $requestNumber;
                    $d['factor_number'] = $factor_number;
                    $d['origin_city'] = functions::NameCity($BookFlight['Result']['Request']['RequestFlights']['OutputRoutes'][0]['Departure']['Code']);
                    $d['desti_city'] = functions::NameCity($BookFlight['Result']['Request']['RequestFlights']['OutputRoutes'][$Count - 1]['Arrival']['Code']);;
                    $d['origin_airport_iata'] = $BookFlight['Result']['Request']['RequestFlights']['OutputRoutes'][0]['Departure']['Code'];
                    $d['desti_airport_iata'] = $BookFlight['Result']['Request']['RequestFlights']['OutputRoutes'][$Count - 1]['Arrival']['Code'];
                    $d['date_flight'] = $BookFlight['Result']['Request']['RequestFlights']['OutputRoutes'][0]['DepartureDate'];
                    $d['time_flight'] = $BookFlight['Result']['Request']['RequestFlights']['OutputRoutes'][0]['DepartureTime'];
                    $d['flight_type'] = $BookFlight['Result']['Request']['RequestFlights']['OutputRoutes'][0]['FlightType'];
                    $d['flight_number'] = $BookFlight['Result']['Request']['RequestFlights']['OutputRoutes'][0]['FlightNo'];
                    $d['airline_iata'] = $iata;
                    $d['airline_name'] = $airlineName;
                    $d['seat_class'] = $BookFlight['Result']['Request']['RequestFlights']['OutputRoutes'][0]['SeatClass'];
                    $d['cabin_type'] = $BookFlight['Result']['Request']['RequestFlights']['OutputRoutes'][0]['CabinType'];
                    $d['IsInternal'] = ($BookFlight['Result']['Request']['IsInternal']) ? '1' : '0';
                    $d['api_id'] = $BookFlight['Result']['SourceId'];
                    $d['pid_private'] = ($check_private == 'private') ? '1' : '0';
                    $d['creation_date'] = date('Y-m-d');
                    $d['creation_date_int'] = time();
                    $d['type_app'] = "Api";
                    $d['supplier_name'] = isset($BookFlight['Result']['Supplier']) ? $BookFlight['Result']['Supplier']['Name'] : '';
                    $d['supplier_manager'] = isset($BookFlight['Result']['Supplier']) ? $BookFlight['Result']['Supplier']['ManagerName'] : '';
                    $d['supplier_website'] = isset($BookFlight['Result']['Supplier']) ? $BookFlight['Result']['Supplier']['Website'] : '';
                    $d['supplier_phone1'] = isset($BookFlight['Result']['Supplier']) ? $BookFlight['Result']['Supplier']['Phone1'] : '';
                    $d['supplier_phone2'] = isset($BookFlight['Result']['Supplier']) ? $BookFlight['Result']['Supplier']['Phone2'] : '';
                    $d['supplier_city'] = isset($BookFlight['Result']['Supplier']) ? $BookFlight['Result']['Supplier']['CityName'] : '';
                    $d['supplier_address'] = isset($BookFlight['Result']['Supplier']) ? $BookFlight['Result']['Supplier']['Address'] : '';
                    $d['successfull'] = "prereserve";
                    $d['currency_code'] = '0';
                    $d['member_id'] = $IdMember;
                    $d['member_name'] = '';
                    $d['member_email'] = $passengers['Email'];
                    $d['member_mobile'] = $passengers['PhoneNumber'];
                    $d['member_phone'] = '0';
                    $d['direction'] = !empty($BookFlight['Result']['Request']['RequestFlights']['ReturnRoutes']) ? 'TwoWay' : 'dept';
                    $PriceTax = array();
                    foreach ($BookFlight['Result']['Request']['RequestFares'] as $RequestFares) {
                        if ($d['api_id'] == '10' || $d['api_id'] == '15') {
                            if (strtolower($RequestFares['PassengerType']) == "adt") {
                                $Price['Adt'] = functions::ShowPriceTicket(strtolower($d['flight_type']), $RequestFares['TotalFare'], $d['api_id']);
                            }
                            if (strtolower($RequestFares['PassengerType']) == "chd") {
                                $Price['Chd'] = functions::ShowPriceTicket(strtolower($d['flight_type']), $RequestFares['TotalFare'], $d['api_id']);
                            }
                            if (strtolower($RequestFares['PassengerType']) == "inf") {
                                $Price['Inf'] = functions::ShowPriceTicket(strtolower($d['flight_type']), $RequestFares['TotalFare'], $d['api_id']);
                            }
                        } else {
                            if (strtolower($RequestFares['PassengerType']) == "adt") {
                                $Price['Adt'] = functions::convert_toman_rial($RequestFares['TotalFare']);
                                $PriceTax['Adt'] = functions::convert_toman_rial($RequestFares['Tax']);
                            }
                            if (strtolower($RequestFares['PassengerType']) == "chd") {
                                $Price['Chd'] = functions::convert_toman_rial($RequestFares['TotalFare']);
                                $PriceTax['Chd'] = functions::convert_toman_rial($RequestFares['Tax']);
                            }
                            if (strtolower($RequestFares['PassengerType']) == "inf") {
                                $Price['Inf'] = functions::convert_toman_rial($RequestFares['TotalFare']);
                                $PriceTax['Inf'] = functions::convert_toman_rial($RequestFares['Tax']);
                            }
                        }

                    }

                    $TypeZone = ($d['IsInternal'] == '1') ? 'Local' : 'Portal';
                    $TypeService = functions::TypeService($d['flight_type'], $TypeZone, strtolower($d['flight_type']) == 'system' ? '' : 'public', $check_private);

                    /*    if($dataInfo['clientId'] =='9' || $dataInfo['clientId'] =='179')
                        {
                            $it_commission = '32000';
                        }else{
                            $it_commission = '10000';
                        }*/

                    $it_commission = $irantechCommission->getFlightCommission($TypeService, $d['api_id'], $dataInfo['clientId']);
                    $d['serviceTitle'] = $TypeService;
//                foreach ($BookFlight['Result']['Request']['RequestPassengers'] as $ReqPassenger) {
                    if (strtolower($passengers['PassengerType']) == "adt") {
                        $d['adt_price'] = $Price['Adt'];
                        $d['adt_fare'] = ($Price['Adt'] - $PriceTax['Adt']);
                        $d['adt_tax'] = $PriceTax['Adt'];
                        $d['discount_adt_price'] = '0';
                        $d['adt_qty'] = '1';
                        $d['chd_price'] = '0';
                        $d['chd_fare'] = '0';
                        $d['chd_tax'] = '0';
                        $d['discount_chd_price'] = '0';
                        $d['chd_qty'] = '0';
                        $d['inf_price'] = '0';
                        $d['inf_fare'] = '0';
                        $d['inf_tax'] = '0';
                        $d['discount_inf_price'] = '0';
                        $d['inf_qty'] = '0';
                        $d['percent_discount'] = '0';
                        list($api_commission, $agency_commission, $supplier_commission) = $apiLocal->commission(strtolower($d['flight_type']), $d['adt_price'], $check_private, '0', '',$d['api_id'],$d['adt_fare'], $d['IsInternal']);
                        $d['api_commission'] = $api_commission;
                        $d['agency_commission'] = $agency_commission;
                        $d['supplier_commission'] = $supplier_commission;
                        $d['irantech_commission'] = $it_commission;
                    } else if (strtolower($passengers['PassengerType']) == "chd") {
                        $d['chd_price'] = $Price['Chd'];
                        $d['chd_fare'] = ($Price['Chd'] - $PriceTax['Chd']);
                        $d['chd_tax'] = $PriceTax['Chd'];
                        $d['discount_chd_price'] = $Price['discount_chd_price'];
                        $d['chd_qty'] = '1';
                        $d['adt_price'] = '0';
                        $d['adt_fare'] = '0';
                        $d['adt_tax'] = '0';
                        $d['discount_adt_price'] = '0';
                        $d['adt_qty'] = '0';
                        $d['inf_price'] = '0';
                        $d['inf_fare'] = '0';
                        $d['inf_tax'] = '0';
                        $d['discount_inf_price'] = '0';
                        $d['inf_qty'] = '0';
                        $d['percent_discount'] = $Price['percent_discount'];
                        list($api_commission, $agency_commission, $supplier_commission) = $apiLocal->commission(strtolower($d['flight_type']), $d['chd_price'], $check_private, '0', '', $d['api_id'], $d['chd_fare'], $d['IsInternal']);
                        $d['api_commission'] = $api_commission;
                        $d['agency_commission'] = $agency_commission;
                        $d['supplier_commission'] = $supplier_commission;
                        $d['irantech_commission'] = $it_commission;
                    } else if (strtolower($passengers['PassengerType']) == "inf") {
                        $d['inf_price'] = $Price['Inf'];
                        $d['inf_fare'] = ($Price['Inf'] - $PriceTax['Inf']);
                        $d['inf_tax'] = $PriceTax['Inf'];
                        $d['inf_qty'] = '1';
                        $d['adt_price'] = '0';
                        $d['adt_fare'] = '0';
                        $d['adt_tax'] = '0';
                        $d['discount_adt_price'] = '0';
                        $d['adt_qty'] = '0';
                        $d['chd_price'] = '0';
                        $d['chd_fare'] = '0';
                        $d['chd_tax'] = '0';
                        $d['discount_chd_price'] = '0';
                        $d['chd_qty'] = '0';
                        $d['percent_discount'] = '0';
                        list($api_commission, $agency_commission, $supplier_commission) = $apiLocal->commission(strtolower($d['flight_type']), $d['inf_price'], $check_private, '0', '', $d['api_id'], $d['inf_fare'], $d['IsInternal']);
                        $d['api_commission'] = $api_commission;
                        $d['agency_commission'] = $agency_commission;
                        $d['supplier_commission'] = $supplier_commission;
                        $d['irantech_commission'] = $it_commission;
                    }
                    unset($d['remote_addr']);
                    unset($d['client_id']);

                    functions::insertLog($requestNumber . '==>' . json_encode($d), 'param_db_request_book_api');
                    $admin->ConectDbClient('', $dataInfo['clientId'], "Insert", $d, "book_local_tb", "");
                    $d['remote_addr'] = $_SERVER['REMOTE_ADDR'];
                    $d['client_id'] = $dataInfo['clientId'];
                    $modelBase->setTable("report_tb");
                    $modelBase->insertLocal($d);

//                }
                }
                if ($d['IsInternal'] == '0') {
                    foreach ($BookFlight['Result']['Request']['RequestFlights']['OutputRoutes'] as $Routes) {
                        $DepartureDateExplode = explode('T', $Routes['DepartureDate']);
                        $DepartureDate = count($DepartureDateExplode) > 1 ? $DepartureDateExplode[0] : $Routes['DepartureDate'];
                        $ArrivalDateExplode = explode('T', $Routes['ArrivalDate']);
                        $ArrivalDate = count($ArrivalDateExplode) > 1 ? $ArrivalDateExplode[0] : $Routes['ArrivalDate'];

                        $BookRoutes['RequestNumber'] = $BookFlight['Result']['Request']['RequestNumber'];
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
//                        $BookRoutes['LongTime'] = $Routes['LongTime'];
                        $BookRoutes['CabinType'] = $Routes['CabinType'];
                        $BookRoutes['AirlineName'] = $Routes['Airline']['Name'];
                        $BookRoutes['Airline_IATA'] = $Routes['Airline']['Code'];
                        $BookRoutes['AircraftName'] = $Routes['Aircraft']['Manufacturer'];
                        $BookRoutes['FlightNumber'] = $Routes['FlightNo'];
                        $BookRoutes['Baggage'] = isset($Routes['Baggage']) ? $Routes['Baggage'][0]['Charge'] : '0';
                        $BookRoutes['BaggageType'] = isset($Routes['Baggage']) ? $Routes['Baggage'][0]['Code'] : '';
                        $BookRoutes['TypeRoute'] = 'Dept';

                        $admin->ConectDbClient('', $dataInfo['clientId'], "Insert", $BookRoutes, "book_routes_tb", "");
                        $modelBase->setTable("report_routes_tb");
                        $modelBase->insertLocal($BookRoutes);
                    }

                    if (!empty($BookFlight['Result']['Request']['RequestFlights']['ReturnRoutes'])) {
                        foreach ($BookFlight['Result']['Request']['RequestFlights']['ReturnRoutes'] as $RoutesReturn) {
                            $DepartureDateExplode = explode('T', $Routes['DepartureDate']);
                            $DepartureDate = count($DepartureDateExplode) > 1 ? $DepartureDateExplode[0] : $RoutesReturn['DepartureDate'];
                            $ArrivalDateExplode = explode('T', $Routes['ArrivalDate']);
                            $ArrivalDate = count($ArrivalDateExplode) > 1 ? $ArrivalDateExplode[0] : $RoutesReturn['ArrivalDate'];

                            $BookRoutesReturn['RequestNumber'] = $BookFlight['Result']['Request']['RequestNumber'];
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
//                          $BookRoutes['LongTime'] = $Routes['LongTime'];
                            $BookRoutesReturn['CabinType'] = $RoutesReturn['CabinType'];
                            $BookRoutesReturn['AirlineName'] = $RoutesReturn['Airline']['Name'];
                            $BookRoutesReturn['Airline_IATA'] = $RoutesReturn['Airline']['Code'];
                            $BookRoutesReturn['AircraftName'] = $RoutesReturn['Aircraft']['Manufacturer'];
                            $BookRoutesReturn['FlightNumber'] = $RoutesReturn['FlightNo'];
                            $BookRoutesReturn['Baggage'] = $RoutesReturn['Baggage'][0]['Charge'];
                            $BookRoutesReturn['BaggageType'] = $RoutesReturn['Baggage'][0]['Code'];
                            $BookRoutesReturn['TypeRoute'] = 'Return';

                            $admin->ConectDbClient('', $dataInfo['clientId'], "Insert", $BookRoutes, "book_routes_tb", "");
                            $modelBase->setTable("report_routes_tb");
                            $modelBase->insertLocal($BookRoutesReturn);
                        }
                    }
                }

            } else {

                $data['successfull'] = 'error';
                $condition = " request_number = '{$requestNumber}' ";
                $res = $admin->ConectDbClient('', $dataInfo['clientId'], 'Update', $data, 'book_local_tb', $condition);

                if ($res) {
                    $data['successfull'] = 'error';
                    $modelBase->setTable('report_tb');
                    $conditionBase = " request_number = '{$requestNumber}' ";
                    $modelBase->update($data, $conditionBase);
                }
            }


        } else {
            $resultFinal['Messages'] = array(
                'errorCode' => 'R000001',
                'errorMessage' => 'YouHaveSentRepeatedRequest',
            );
            $resultFinal['ResultDuration'] = '0';
            $resultFinal['ProviderStatus'] = 'errorSystem';
            $resultFinal['SourceId'] = '';
            $resultFinal['SourceName'] = '';
            $resultFinal['UserName'] = '';
            $resultFinal['Code'] = $dataInfo['code'];

            $BookFlight = $resultFinal;
        }


        return json_encode($BookFlight);

    }

    public function reserve($param, $dataInfo) {

        $modelBase = Load::library('ModelBase');
        $admin = Load::controller('admin');
        $reserveInfo = $this->getinfoBookLocal($dataInfo['code'], $dataInfo['clientId']);
        $factorNumber = $reserveInfo[0]['factor_number'];
        $request_number = $dataInfo['code'];
        $total_price = 0;

        $comment = "خرید" . " " . $reserveInfo[0]['count_id'] . " عدد بلیط " . (($reserveInfo[0]['direction'] == 'TwoWay') ? "دو طرفه" : "") . " هواپیما از" . " " . $reserveInfo[0]['origin_city'] . " به" . " " . $reserveInfo[0]['desti_city'] . " " . "به شماره رزرو ";


        $prices = $this->calculateTransactionPrice($request_number, $dataInfo['clientId']);

        $total_price += $prices['transactionPrice'];
        $comment .= ' ' . $request_number . $prices['pidTitle'];


        $existTransaction = $this->getTransactionByFactorNumber($factorNumber, $dataInfo['clientId']);

        if (empty($existTransaction)) {
            // Caution: اعتبارسنجی صاحب سیستم
            $check = $this->checkCredit($total_price, '', $dataInfo['clientId']);
            if ($check['status'] == 'TRUE') {

                // Caution: کاهش اعتبار موقت صاحب سیستم
                $reduceTransaction = $this->decreasePendingCredit($total_price, $factorNumber, $comment, 'buy', $dataInfo['clientId']);
                if ($reduceTransaction) {
                    $output = 'TRUE';
                } else {
                    $output = 'FALSE';
                }

            } else {
                $output = 'FALSE';
            }

        } else {
            $output = 'FALSE';
        }

        if (!empty($reserveInfo)) {
            if ($output == 'TRUE') {
                $url = $this->apiAddress . "Flight/Reserve/" . $dataInfo['code'];
                $JsonArray = array();
                $ReserveTicket = functions::curlExecution($url, $JsonArray, 'yes');
                error_log('try show Response equal in time=> ' . date('Y/m/d H:i:s') . ' ' . 'With RequestNumber' . $dataInfo['code'] . "=>" . " " . json_encode($ReserveTicket, true) . " \n", 3, LOGS_DIR . 'log_method_reserve_Api.txt');
                if (isset($ReserveTicket['Result']['Request']['Status']) && $ReserveTicket['Result']['Request']['Status'] == 'Ticketed') {
                    //موفق کردن کسر اعتبار
                    $this->setCreditToSuccess($reserveInfo[0]['factor_number'], $reserveInfo[0]['tracking_code_bank'], $dataInfo['clientId']);
                    foreach ($reserveInfo as $key => $resultBook) {
                        $data['payment_type'] = 'credit';
                        $data['pnr'] = $ReserveTicket['Result']['Request']['OutputRoutes'][0]['AirlinePnr'];
                        $data['eticket_number'] = $ReserveTicket['Result']['Request']['RequestPassengers'][$key]['TicketNumber'];
                        $data['successfull'] = 'book';
                        if ($resultBook['passenger_national_code'] != '0000000000') {
                            $uniqCondition = " AND passenger_national_code = '{$resultBook['passenger_national_code']}' ";
                        } else {
                            $uniqCondition = " AND passportNumber = '{$resultBook['passportNumber']}' ";
                        }
                        $condition = " request_number = '{$resultBook['request_number']}' " . $uniqCondition;
                        $res = $admin->ConectDbClient('', $dataInfo['clientId'], 'Update', $data, 'book_local_tb', $condition);

                        if ($res) {
                            $statusTicket = ($resultBook['pid_private'] == '1') ? 'private_reserve' : 'book';
                            $data['successfull'] = $statusTicket;
                            $modelBase->setTable('report_tb');
                            $conditionBase = " request_number = '{$resultBook['request_number']}' " . $uniqCondition;
                            $modelBase->update($data, $conditionBase);
                        }
                    }
                } else {
                    error_log('try show after last error equal in time=> ' . date('Y/m/d H:i:s') . ' ' . 'With RequestNumber' . $dataInfo['code'] . "=>" . " " . json_encode($ReserveTicket, true) . " \n", 3, LOGS_DIR . 'log_method_reserve_repeat_Api.txt');

                    foreach ($reserveInfo as $key => $resultBook) {
                        $data['payment_type'] = 'credit';
                        $data['pnr'] = '';
                        $data['eticket_number'] = '';
                        $data['successfull'] = 'error';
                        $condition = " request_number = '{$resultBook['request_number']}' ";
                        $res = $admin->ConectDbClient('', $dataInfo['clientId'], 'Update', $data, 'book_local_tb', $condition);

                        if ($res) {
                            $data['successfull'] = 'error';
                            $modelBase->setTable('report_tb');
                            $conditionBase = " request_number = '{$resultBook['request_number']}' ";
                            $modelBase->update($data, $conditionBase);
                        }
                    }

                }

            } else {
                $resultFinal['Messages'] = array(
                    'errorCode' => '000006',
                    'errorMessage' => 'CreditIsLow',
                );
                $resultFinal['ResultDuration'] = '0';
                $resultFinal['ProviderStatus'] = 'errorSystem';
                $resultFinal['SourceId'] = '';
                $resultFinal['SourceName'] = '';
                $resultFinal['UserName'] = '';
                $resultFinal['Code'] = $dataInfo['code'];

                $ReserveTicket = $resultFinal;
            }

        } else {
            $resultFinal['Messages'] = array(
                'errorCode' => '000005',
                'errorMessage' => 'ErrorInternalSystem',
            );
            $resultFinal['ResultDuration'] = '0';
            $resultFinal['ProviderStatus'] = 'errorSystem';
            $resultFinal['SourceId'] = '';
            $resultFinal['SourceName'] = '';
            $resultFinal['UserName'] = '';
            $resultFinal['Code'] = $dataInfo['code'];

            $ReserveTicket = $resultFinal;

        }

        return json_encode($ReserveTicket, 256 | 64);
    }

    public function setCreditToSuccess($factorNumber, $bankTrackingCode, $clientId) {
        $admin = Load::controller('admin');
        $data['PaymentStatus'] = 'success';
        $data['PriceDate'] = date("Y-m-d H:i:s");
        $data['BankTrackingCode'] = $bankTrackingCode != 'member_credit' ? $bankTrackingCode : '';
        $condition = "FactorNumber = '{$factorNumber}'";
        $result = $admin->ConectDbClient('', $clientId, 'Update', $data, 'transaction_tb', $condition);
        $data['clientID'] = $clientId;
        $this->transactions->updateTransaction($data,$condition);

        return $result;
    }

    public function getCredit($clientId) {
        $admin = Load::controller('admin');

        //600: pending records under 10 minutes are included
        $time = time() - (600);

        $query = "SELECT"
            . " COALESCE((SELECT SUM(Price) FROM transaction_tb WHERE Status='1'), 0) as `credit`, "
            . " COALESCE((SELECT SUM(Price) FROM transaction_tb WHERE Status='2' AND"
            . " ((PaymentStatus = 'success') OR (PaymentStatus = 'pending' AND CreationDateInt > '{$time}')) ), 0) as `debit` ";
        $result = $admin->ConectDbClient($query, $clientId, 'Select', '', '', '');

        return $result['credit'] - $result['debit'];
    }

    public function checkCredit($amountToCheck, $currentCredit = null, $clientId) {

        if ($currentCredit != null) {
            $currentCredit = $currentCredit;
        } else {
            $currentCredit = $this->getCredit($clientId);
        }

        $remainingCredit = $currentCredit - $amountToCheck;

        if ($currentCredit >= 0) {
            if ($amountToCheck > $currentCredit) {

                $result['status'] = 'FALSE';
                $result['credit'] = $remainingCredit;

            } else {
                $result['status'] = 'TRUE';
                $result['credit'] = $remainingCredit;
            }
        } else {
            $result['status'] = 'FALSE';
            $result['credit'] = $remainingCredit;
        }

        return $result;
    }

    public function getTransactionByFactorNumber($factorNumber, $clientId) {
        $admin = Load::controller('admin');
        $query = "SELECT * FROM transaction_tb WHERE FactorNumber = '{$factorNumber}'";
        $result = $admin->ConectDbClient($query, $clientId, 'SelectAll', '', '', '');

        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function decreasePendingCredit($amount, $factorNumber, $comment, $reason, $clientId) {
        $admin = Load::controller('admin');
        $data['Price'] = $amount;
        $data['FactorNumber'] = $factorNumber;
        $data['Comment'] = $comment;
        $data['Reason'] = $reason;
        $data['Status'] = '2';
        $data['PaymentStatus'] = 'pending';
        $data['creationDateInt'] = time();
        $data['BankTrackingCode'] = 'کسر موقت';

        $result = $admin->ConectDbClient('', $clientId, "Insert", $data, "transaction_tb", "");
        $data['clientID'] = $clientId;
        $this->transactions->insertTransaction($data);
        return true;
    }

#region get_total_ticket_price

    public function get_total_ticket_price($RequestNumber, $FlagPriceChange = 'yes', $clientId = null) {
        $admin = Load::controller('admin');
        //yes means nesesary calculate  price changes
        $sql = "SELECT * FROM book_local_tb WHERE request_number='{$RequestNumber}'";
        $rec = $admin->ConectDbClient($sql, $clientId, 'SelectAll', '', '', '');
        $amount = 0;
        $fare = 0;
        foreach ($rec as $each) {

            //در هر رکورد فقط یکی از قیمت ها با توجه به سن مقدار دارد و دوتای دیگر صفر هستند
            if ($each['flight_type'] == 'system') {
                $amount += $each['adt_price'] + $each['chd_price'] + $each['inf_price'];
                $fare += $each['adt_fare'] + $each['chd_fare'] + $each['inf_fare'];
            } else {
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
                        $fare = '0';
                    }
                }
            }
        }

        return array($amount, $fare);
    }

#endregion
    #region calculateTransactionPrice
    public function calculateTransactionPrice($requestNumber, $clientId) {
        $admin = Load::controller('admin');
        $privateCharterSources = functions::privateCharterFlights();
        $ClientIdPrivateCharterSources = functions::ClientIdCharterPrivateFlight();
        $percentPublic = functions::percentPublic();
        $sql = "SELECT member_id, pid_private, origin_city, desti_city,irantech_commission, factor_number, request_number, tracking_code_bank, flight_type, airline_iata, api_id,IsInternal,direction,api_id,"
            . " (SELECT COUNT(id)  FROM book_local_tb WHERE request_number='{$requestNumber}' ) AS count_id"
            . " FROM book_local_tb WHERE request_number='{$requestNumber}'";
        $rec = $admin->ConectDbClient($sql, $clientId, 'Select', '', '', '');
        list($TicketPrice, $fare) = $this->get_total_ticket_price($requestNumber, 'no', $clientId);

        $check_private = ($rec['pid_private'] == '1') ? 'private' : 'public';
        $type = '';
        $totalAmount = 0;
        if ($rec['IsInternal'] == '1') {
            if ($rec['flight_type'] == "system") {//بلیط سیستمی
                if ($check_private == 'public') {
                    $totalAmount = $TicketPrice + ($rec['irantech_commission'] * $rec['count_id']);
//                    dar tarikh 13 ordibehesht 1404 tebgh darkhast aghaye afshar systemy ha haman meghdar total azashon kasr beshe
//                    $totalAmount = ($TicketPrice - ($fare * $percentPublic)) + ($rec['irantech_commission'] * $rec['count_id']);
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
                        $totalAmount = $TicketPrice + ($rec['irantech_commission'] * $rec['count_id']);
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

#region getInfoBookLocal
    public function getInfoBookLocal($requestNumber, $clientId) {
        $admin = Load::controller('admin');
        $sql = "SELECT member_id,passenger_national_code,passportNumber, pid_private, origin_city, desti_city,irantech_commission, factor_number, request_number, tracking_code_bank, flight_type, airline_iata,IsInternal,direction,api_id,"
            . " (SELECT COUNT(id)  FROM book_local_tb WHERE request_number='{$requestNumber}' ) AS count_id"
            . " FROM book_local_tb WHERE request_number='{$requestNumber}' ";
        $reserveInfo = $admin->ConectDbClient($sql, $clientId, 'SelectAll', '', '', '');

        return $reserveInfo;
    }
#endregion

#region CancelApi
    public function cancelFlight($param, $dataInfo) {
        $admin = Load::controller('admin');
        $Cancel = Load::controller('listCancel');
        $sql = " SELECT * FROM book_local_tb WHERE request_number='{$dataInfo['code']}' AND successfull='book'";
        $results = $admin->ConectDbClient($sql, $dataInfo['clientId'], 'SelectAll', '', '', '');

        functions::insertLog('add cancel with api by ip=>' . $_SERVER['REMOTE_ADDR'] . '&&with code=>' . $dataInfo['code'] . '=>' . json_encode($param), 'log_request_cancel_api');

        foreach ($results as $key => $res) {
            if (!empty($param['NationalCodes'])) {
                foreach ($param['NationalCodes'] as $keyParam => $item) {
                    if ($res['passenger_national_code'] == $item || $res['passportNumber'] == $item) {
                        $dataCancel['NationalCodes'][] = $item . '-' . $res['passenger_age'];
                    }
                }
            } else {
                $MessageCancel['Status'] = 'error';
                $MessageCancel['Message'] = 'اطلاعات ارسالی برای کنسلی صحیح نمی باشد،لطفا با پشتیبانی تماس بگیرید';

                return json_encode($MessageCancel);

            }
        }


        $dataCancel['RequestNumber'] = $dataInfo['code'];
        $dataCancel['Status'] = 'RequestClient';
        $dataCancel['Reasons'] = $param['Reason'];
        $dataCancel['FactorNumber'] = $results[0]['factor_number'];
        $dataCancel['MemberId'] = $results[0]['member_id'];
        $dataCancel['flightType'] = $results[0]['flight_type'];
        $dataCancel['clientId'] = $dataInfo['clientId'];
        $dataCancel['typeService'] = 'flight';

        return $Cancel->SetRequestCancelUser($dataCancel, true);

    }
#endregion

#region login_members_online
    public function login_members_online($email, $clientId) {
        $admin = Load::controller('admin');
        $sql = "SELECT * FROM members_tb WHERE email='{$email}'";
        return $admin->ConectDbClient($sql, $clientId, 'Select', '', '', '');
    }
#endregion

#region  getCredit
    public function getCreditCustomer($param, $dataInfo) {
        $credit = $this->getCredit($dataInfo['clientId']);

        $data['Result']['Status'] = 'Success';
        $data['Result']['message'] = 'Get Credit Account';
        $data['Result']['data']['Credit'] = $credit;


        return json_encode($data);
    }

#endregion


}

new apiFlight();


