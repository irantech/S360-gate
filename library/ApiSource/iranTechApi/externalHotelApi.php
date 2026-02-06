<?php
error_reporting(1);
error_reporting(E_ALL | E_STRICT);
@ini_set('display_errors', 1);
@ini_set('display_errors', 'on');


class externalHotelApi
{

    protected $userNameRequest;

    public $transactions;
    public function __construct()
    {
        $this->transactions = $this->getModel('transactionsModel');
        header("Content-type: application/json;");
        $dataResponse = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && (strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false)) {

            $dataRequest = file_get_contents('php://input');

            $url = $_SERVER['REQUEST_URI'];
            $arrayUrl = explode('/', $url);

            $requestUrl = '';
            if ($arrayUrl[2] == 'apiExternalHotelTest') {
                $requestUrl = 'http://safar360.com/CoreTest/ExternalHotel/';
            } elseif ($arrayUrl[2] == 'apiExternalHotel') {
//                $requestUrl = 'http://safar360.com/Core/ExternalHotel/';
                $requestUrl = 'http://safar360.com/Core/ExternalHotel/';
            } else {
                $dataResponse['ErrorDetail'] = [
                    'Code' => 'EH-00',
                    'Message' => 'Not Valid URL',
                    'MessagePersian' => ''
                ];
            }

            if (!empty($requestUrl)) {

                $dataRequestArray = json_decode($dataRequest, true);
                if (isset($dataRequestArray['UserName']) && isset($dataRequestArray['Password'])) {

                    $userName = filter_var($dataRequestArray['UserName'], FILTER_SANITIZE_STRING);
                    $key = filter_var($dataRequestArray['Password'], FILTER_SANITIZE_STRING);

                    $ModelBase = Load::library('ModelBase');
                    $Sql = "SELECT clientId FROM client_user_api WHERE userName='{$userName}' AND keyTabdol='{$key}'";
                    $resClient = $ModelBase->load($Sql);
                    error_log(' in __construct of time is : ' . date('Y/m/d H:i:s') . 'AND  data is : => ' .$Sql . ' AND response is=>' . json_encode($resClient) . " \n" , 3, LOGS_DIR . 'logHotelPriceApi.txt');
                    if (!empty($resClient)) {
                        $this->userNameRequest = $userName ;
                        $SqlClientAuth = "SELECT Username FROM client_auth_tb WHERE ClientId='{$resClient['clientId']}' AND SourceId='12' AND serviceId='10'";
                        $resClientAuth = $ModelBase->load($SqlClientAuth);
                        if (!empty($resClientAuth)){

                            $methodName = lcfirst($arrayUrl[3]);
                            $arrayMethod = ['login', 'hotelCityList', 'hotelSearch', 'hotelDetail', 'hotelPriceDetail', 'hotelPreReserve', 'hotelReserve'];
                            if (in_array($methodName, $arrayMethod)){

                                //unset($dataRequestArray['Password']);
                                $dataRequestArray['UserName'] = $resClientAuth['Username'];
                                $dataRequest = json_encode($dataRequestArray);
                                $dataResponse = $this->$methodName($requestUrl, $dataRequest);

                            } else {
                                $dataResponse['ErrorDetail'] = [
                                    'Code' => 'EH-04',
                                    'Message' => 'Not Valid Request => ' . $methodName,
                                    'MessagePersian' => ''
                                ];
                            }


                        } else {
                            $dataResponse['ErrorDetail'] = [
                                'Code' => 'EH-03',
                                'Message' => 'Not Access UserName Or Password',
                                'MessagePersian' => ''
                            ];
                        }



                    } else {
                        $dataResponse['ErrorDetail'] = [
                            'Code' => 'EH-02',
                            'Message' => 'Not Valid UserName Or Password',
                            'MessagePersian' => ''
                        ];
                    }


                } else {
                    $dataResponse['ErrorDetail'] = [
                        'Code' => 'EH-01',
                        'Message' => 'Please Send UserName and Password',
                        'MessagePersian' => ''
                    ];
                }

            }


        } else {
            $dataResponse['ErrorDetail'] = [
                'Code' => 'EH-00',
                'Message' => 'Not Valid Request Method',
                'MessagePersian' => ''
            ];
        }

        echo json_encode($dataResponse);
    }


    public function login($requestUrl, $dataRequest)
    {

        /*$dataRequest = json_decode($dataRequest, true);
        if (isset($dataRequest['UserName']) && isset($dataRequest['Password'])) {

            $userName = filter_var($dataRequest['UserName'], FILTER_SANITIZE_STRING);
            $key = filter_var($dataRequest['Password'], FILTER_SANITIZE_STRING);

            $ModelBase = Load::library('ModelBase');
            $Sql = "SELECT clientId FROM client_user_api WHERE userName='{$userName}' AND keyTabdol='{$key}'";
            $resClient = $ModelBase->load($Sql);

            if (!empty($resClient)) {

                $SqlClientAuth = "SELECT Username FROM client_auth_tb WHERE ClientId='{$resClient['clientId']}' AND SourceId='12' AND serviceId='10'";
                $resClientAuth = $ModelBase->load($SqlClientAuth);

                if (!empty($resClientAuth)){
                    try {
                        $url = $requestUrl . "Login";
                        $data['UserName'] = $resClientAuth['Username'];
                        $jsonData = json_encode($data);
                        $dataResponse = functions::curlExecution($url, $jsonData, 'yes');

                    } catch (Exception $e) {
                        $dataResponse['ErrorDetail'] = [
                            'Code' => 'EHL-04',
                            'Message' => '',
                            'MessagePersian' => ''
                        ];
                    }


                } else {
                    $dataResponse['ErrorDetail'] = [
                        'Code' => 'EHL-03',
                        'Message' => 'Not Valid UserName Or Password',
                        'MessagePersian' => ''
                    ];
                }



            } else {
                $dataResponse['ErrorDetail'] = [
                    'Code' => 'EHL-02',
                    'Message' => 'Not Valid UserName Or Password',
                    'MessagePersian' => ''
                ];
            }


        } else {
            $dataResponse['ErrorDetail'] = [
                'Code' => 'EHL-01',
                'Message' => 'Please Send UserName and Password',
                'MessagePersian' => ''
            ];
        }*/

        try {
            $url = $requestUrl . "Login";
            $dataResponse = functions::curlExecution($url, $dataRequest, 'yes');

        } catch (Exception $e) {
            $dataResponse['ErrorDetail'] = [
                'Code' => 'EHL-01',
                'Message' => '',
                'MessagePersian' => ''
            ];
        }


        return $dataResponse;
    }

    public function hotelCityList($requestUrl, $dataRequest)
    {
        try {
            $url = $requestUrl . "HotelCityList";
            $dataResponse = functions::curlExecution($url, $dataRequest, 'yes');

        } catch (Exception $e) {
            $dataResponse['ErrorDetail'] = [
                'Code' => 'EHCL-01',
                'Message' => 'System error',
                'MessagePersian' => 'خطای سیستمی'
            ];
        }


        return $dataResponse;
    }

    public function hotelSearch($requestUrl, $dataRequest)
    {
        try {
            $url = $requestUrl . "HotelSearch";
            $dataResponse = functions::curlExecution($url, $dataRequest, 'yes');

        } catch (Exception $e) {
            $dataResponse['ErrorDetail'] = [
                'Code' => 'EHS-01',
                'Message' => 'System error',
                'MessagePersian' => 'خطای سیستمی'
            ];
        }

        return $dataResponse;
    }

    public function hotelDetail($requestUrl, $dataRequest)
    {
        try {
            $url = $requestUrl . "HotelDetail";
            $dataResponse = functions::curlExecution($url, $dataRequest, 'yes');

        } catch (Exception $e) {
            $dataResponse['ErrorDetail'] = [
                'Code' => 'EHD-01',
                'Message' => 'System error',
                'MessagePersian' => 'خطای سیستمی'
            ];
        }

        return $dataResponse;
    }

    public function hotelPriceDetail($requestUrl, $dataRequest)
    {
        error_log('first hotel pricetime is : ' . date('Y/m/d H:i:s') . 'AND  data is : => ' . $dataRequest  . " \n" , 3, LOGS_DIR . 'logHotelPriceApi.txt');
        try {
            $url = $requestUrl . "HotelPriceDetail";
            $arrayDataRequest = json_decode($dataRequest, true);
            $arrayDataHotelPriceDetail['UserName'] = $arrayDataRequest['UserName'];
            $arrayDataHotelPriceDetail['HotelIndex'] = $arrayDataRequest['HotelIndex'];
            $arrayDataHotelPriceDetail['RoomIndex'] = $arrayDataRequest['RoomIndex'];
            $arrayDataHotelPriceDetail['SearchID'] = $arrayDataRequest['SearchID'];
            $arrayDataHotelPriceDetail['MemberSessionID'] = $arrayDataRequest['MemberSessionID'];
            $resultHotelPriceDetail = functions::curlExecution($url, json_encode($arrayDataHotelPriceDetail), 'yes');
            if (!empty($resultHotelPriceDetail) && isset($resultHotelPriceDetail['FullAmount']) && $resultHotelPriceDetail['FullAmount'] > 0) {

                $startDate = str_replace("-", "", $arrayDataRequest['FromDate']);
                $night = $arrayDataRequest['ReserveLength'];
                $endDate = date('Ymd', strtotime("" . $startDate . ",+ $night day"));;

                $arrayDataHotelDetail['UserName'] = $arrayDataRequest['UserName'];
                $arrayDataHotelDetail['HotelIndex'] = $arrayDataRequest['HotelIndex'];
                $arrayDataHotelDetail['SearchID'] = $arrayDataRequest['SearchID'];
                $arrayDataHotelDetail['MemberSessionID'] = $arrayDataRequest['MemberSessionID'];
                $resultHotel = $this->hotelDetail($requestUrl, json_encode($arrayDataHotelDetail));

                if (!empty($resultHotel)) {

                    $factorNumber = substr(time(), 0, 3) . mt_rand(0000, 9999) . substr(time(), 7, 10);
                    $dataInsert['factor_number'] = $factorNumber;
                    $dataInsert['login_id'] = $arrayDataRequest['MemberSessionID'];
                    $dataInsert['search_id'] = $arrayDataRequest['SearchID'];
                    $dataInsert['start_date'] = functions::ConvertToJalali($arrayDataRequest['FromDate']);
                    $dataInsert['end_date'] = functions::ConvertToJalali($endDate);
                    $dataInsert['night'] = $night;
                    $dataInsert['city_name'] = $resultHotel['CityName'];
                    $dataInsert['country_name'] = $resultHotel['CountryName'];
                    $dataInsert['hotel_id'] = $resultHotel['HotelIndex'];
                    $dataInsert['hotel_name'] = $resultHotel['HotelName'];
                    $dataInsert['hotel_persian_name'] = $resultHotel['HotelPersianName'];
                    $dataInsert['hotel_type'] = $resultHotel['HotelType'];
                    $dataInsert['image_url'] = $resultHotel['ImageURL'];
                    $dataInsert['hotel_descriptions'] = $resultHotel['BreifingDescription'];
                    $dataInsert['hotel_stars'] = $resultHotel['HotelStars'];
                    $dataInsert['hotel_address'] = $resultHotel['HotelAddress'];
                    foreach ($resultHotel['RoomsDetail'] as $room) {
                        if ($room['ReservePackageID'] == $arrayDataRequest['RoomIndex']) {
                            $dataInsert['room_id'] = $arrayDataRequest['RoomIndex'];
                            $dataInsert['room_list'] = json_encode($room['RoomList']);
                            break;
                        }
                    }

                    $dataInsert['price_detail_id'] = $resultHotelPriceDetail['PriceDetailID'];
                    $dataInsert['full_amount'] = $resultHotelPriceDetail['FullAmount'];
                    $dataInsert['full_waged_amount'] = $resultHotelPriceDetail['FullWagedAmount'];
                    $dataInsert['member_profit'] = $resultHotelPriceDetail['MemberProfit'];
                    $dataInsert['room_count'] = $resultHotelPriceDetail['RoomCount'];
                    $dataInsert['website_commission'] = $resultHotelPriceDetail['WebsiteCommission'];
                    $dataInsert['company_commission'] = $resultHotelPriceDetail['CompanyCommission'];
                    $dataInsert['employee_commission'] = $resultHotelPriceDetail['EmployeeCommission'];
                    $dataInsert['service_amount'] = $resultHotelPriceDetail['ServiceAmount'];
                    $dataInsert['service_provider_id'] = $resultHotelPriceDetail['ServiceProviderID'];
                    $dataInsert['hotel_rule'] = $resultHotelPriceDetail['HotelRule'];
                    $dataInsert['cancel_rule'] = json_encode($resultHotelPriceDetail['CancelationRules']);
                    $dataInsert['create_date_in'] = dateTimeSetting::jtoday();
                    $dataInsert['create_time_in'] = date('H:i:s');

                    $key = filter_var($arrayDataRequest['Password'], FILTER_SANITIZE_STRING);
                    $ModelBase = Load::library('ModelBase');
                    $Sql = "SELECT clientId FROM client_user_api WHERE userName='{$this->userNameRequest}' AND keyTabdol='{$key}'";
                    $resClient = $ModelBase->load($Sql);
                    error_log('time is : ' . date('Y/m/d H:i:s') . 'AND  data is : => ' .$Sql . ' AND response is=>' . json_encode($resClient) . " \n" , 3, LOGS_DIR . 'logHotelPriceApi.txt');
                    if (!empty($resClient)){
                        $agencyID = $resClient['clientId'];

                        $admin = Load::controller('admin');
                        $sqlCheck = " SELECT id FROM temprory_external_hotel_tb 
                                  WHERE login_id = '{$arrayDataRequest['MemberSessionID']}' AND search_id = '{$arrayDataRequest['SearchID']}' ";
                        $resultCheck = $admin->ConectDbClient($sqlCheck, $agencyID, "Select", "", "", "");
                        if (empty($resultCheck)) {
                            $resultTemprory = $admin->ConectDbClient('', $agencyID, "Insert", $dataInsert, "temprory_external_hotel_tb", "");
                        } else {
                            $condition = " login_id = '{$arrayDataRequest['MemberSessionID']}' AND search_id = '{$arrayDataRequest['SearchID']}' ";
                            $resultTemprory = $admin->ConectDbClient('', $agencyID, "Update", $dataInsert, "temprory_external_hotel_tb", $condition);
                        }

                        if ($resultTemprory) {
                            $dataResponse = [
                                'PreReserveNumber' => $factorNumber,
                                'Result' => $resultHotelPriceDetail
                            ];
                        } else {
                            $dataResponse['ErrorDetail'] = [
                                'Code' => 'EHPD-05',
                                'Message' => 'Not Valid MemberSessionID Or SearchID',
                                'MessagePersian' => ''
                            ];
                        }

                    } else {
                        $dataResponse['ErrorDetail'] = [
                            'Code' => 'EHPD-04',
                            'Message' => 'Not Valid UserName Or Password',
                            'MessagePersian' => ''
                        ];
                    }
                } else {
                    $dataResponse['ErrorDetail'] = [
                        'Code' => 'EHPD-03',
                        'Message' => 'Not Valid Request Data',
                        'MessagePersian' => ''
                    ];
                }

            } else {
                $dataResponse['ErrorDetail'] = [
                    'Code' => 'EHPD-02',
                    'Message' => 'Not Valid Request Data',
                    'MessagePersian' => ''
                ];
            }
        } catch (Exception $e) {
            $dataResponse['ErrorDetail'] = [
                'Code' => 'EHPD-01',
                'Message' => 'System error',
                'MessagePersian' => 'خطای سیستمی'
            ];
        }


        return $dataResponse;
    }

    public function hotelPreReserve($requestUrl, $dataRequest)
    {
        try {

            $arrayDataRequest = json_decode($dataRequest, true);
            $factorNumber = filter_var($arrayDataRequest['PreReserveNumber'], FILTER_SANITIZE_STRING);
            //$agencyID = filter_var($arrayDataRequest['AgencyID'], FILTER_SANITIZE_STRING);
            $key = filter_var($arrayDataRequest['Password'], FILTER_SANITIZE_STRING);
            $ModelBase = Load::library('ModelBase');
            $Sql = "SELECT clientId FROM client_user_api WHERE userName='{$this->userNameRequest}' AND keyTabdol='{$key}'";
            $resClient = $ModelBase->load($Sql);
            if (!empty($resClient)) {
                $agencyID = $resClient['clientId'];
                $admin = Load::controller('admin');
                $modelBase = Load::library('ModelBase');

                $sqlBook = " SELECT id FROM book_hotel_local_tb WHERE factor_number = '{$factorNumber}' ";
                $temproryBook = $admin->ConectDbClient($sqlBook, $agencyID, "Select", "", "", "");
                if (!empty($temproryBook)) {
                    $dataResponse = array(
                        'RequestStatus' => 'Error',
                        'ErrorMessage' => 'No Reserve Info By PreReserveNumber: ' . $factorNumber,
                        'ErrorCode' => 'E4Hotel',
                        'Result' => array()
                    );
                } else {
                    $sqlTemprory = " SELECT * FROM temprory_external_hotel_tb WHERE factor_number = '{$factorNumber}' ";
                    $temproryReserve = $admin->ConectDbClient($sqlTemprory, $agencyID, "Select", "", "", "");
                    if (empty($temproryReserve)) {
                        $dataResponse = array(
                            'RequestStatus' => 'Error',
                            'ErrorMessage' => 'THERE IS PreReserveNumber IN YOUR LAST INVOICE, DON`T USE PreReserveNumber TWICE',
                            'ErrorMessagePersian' => '.از شماره فاکتور دوباره استفاده نکنید',
                            'ErrorCode' => 'EH-06',
                            'Result' => array()
                        );
                    } else {

                        if (isset($arrayDataRequest['BookArray']['TestMode'])) {//test
                            //$arrayDataRequest['BookArray']['TestMode']==true-> به دلیل استفاده از محیط واقعی این مورد  که در شرط بود برداشته شد

                            $request['UserName'] = $arrayDataRequest['UserName'];
                            $request['Password'] = $arrayDataRequest['Password'];
                            $request['LoginID'] = $temproryReserve['login_id'];
                            $request['CallBackURL'] = 'https://pg.sairosoft.com/payment/check/{{' . $factorNumber . '}}';
                            $request['PaymentTypeID'] = 1;
                            $request['PaymentCode'] = '';
                            $request['ServiceName'] = 'HOTEL';
                            $request['MemberDescription'] = '';
                            $request['PriceDetailID'] = $temproryReserve['price_detail_id'];
                            $request['Description'] = '';
                            $requestBookArray['TestMode'] = $arrayDataRequest['BookArray']['TestMode']; // true;
                            $requestBookArray['Nationality'] = 'IR';
                            $requestBookArray['ContactInfo']['Email'] = 'info@iran-tech.com';
                            $requestBookArray['ContactInfo']['CellphoneNumber'] = '09222014065';
                            $requestBookArray['ContactInfo']['PhoneNumber'] = '09222014065';
                            $requestBookArray['ContactInfo']['Address'] = 'Tehran';
                            $requestBookArray['RoomList'] = $arrayDataRequest['BookArray']['RoomList'];
                            $jsonBookArray = json_encode($requestBookArray);
                            error_log(' RoomList is time=> : ' . date('Y/m/d H:i:s') . 'AND  data is : => ' .$jsonBookArray . " \n" , 3, LOGS_DIR . 'logHotelPriceApi.txt');
                            $request['BookArray'] = (string)$jsonBookArray;
                            $request['ExteraAgency'] = 0;

                            unset($request['Password']);
                            $jsonData = json_encode($request);
                            $url = $requestUrl . "HotelPreReserve";
                            $resultHotel = functions::curlExecution($url, $jsonData, 'yes');
                            if (isset($resultHotel['ErrorDetail']['Code']) && $resultHotel['ErrorDetail']['Code'] != '') {

                                $dataResponse['ErrorDetail'] = [
                                    'Code' => $resultHotel['ErrorDetail']['Code'],
                                    'Message' => $resultHotel['ErrorDetail']['Message'],
                                    'MessagePersian' => $resultHotel['ErrorDetail']['MessagePersian']
                                ];

                            } elseif (isset($resultHotel['PaymentCode']) && $resultHotel['PaymentCode'] != '') {

                                $dataInsertBook['status'] = "PreReserve";
                                $dataInsertBook['type_application'] = "externalApi";
                                $dataInsertBook['voucher_number'] = $resultHotel['PaymentCode'];
                                $dataInsertBook['voucher_url'] = 'http://test.1011.ir/gds_test/pdf&target=BookingHotelLocal&id=' . $factorNumber;
                                $dataInsertBook['total_price_api'] = $resultHotel['FullPaymentAmount'];
                                $dataInsertBook['payment_date'] = Date('Y-m-d H:i:s');
                                $dataInsertBook['creation_date_int'] = time();

                                $dataInsertBook['member_name'] = $arrayDataRequest['BookArray']['ContactInfo']['FullName'];
                                $dataInsertBook['member_mobile'] = $arrayDataRequest['BookArray']['ContactInfo']['CellphoneNumber'];
                                $dataInsertBook['member_phone'] = $arrayDataRequest['BookArray']['ContactInfo']['PhoneNumber'];
                                $dataInsertBook['member_email'] = $arrayDataRequest['BookArray']['ContactInfo']['Email'];
                                /*$city = $objExternalHotel->getCity($temproryReserve['city_name']);
                                $star = ($temproryReserve['hotel_stars'] > 0) ? $temproryReserve['hotel_stars'] : 2;
                                $dataInsertBook['city_id'] = $city['place_id'];*/
                                $dataInsertBook['city_id'] = $temproryReserve['city_name'];
                                $dataInsertBook['city_name'] = $temproryReserve['city_name'];
                                $dataInsertBook['hotel_id'] = $temproryReserve['hotel_id'];
                                $dataInsertBook['hotel_name'] = $temproryReserve['hotel_persian_name'];
                                $dataInsertBook['hotel_name_en'] = $temproryReserve['hotel_name'];
                                $dataInsertBook['hotel_address'] = $temproryReserve['hotel_address'];
                                $dataInsertBook['hotel_address_en'] = $temproryReserve['hotel_address'];
                                $dataInsertBook['hotel_starCode'] = '';
                                $dataInsertBook['hotel_pictures'] = $temproryReserve['image_url'];
                                $dataInsertBook['hotel_rules'] = $temproryReserve['hotel_descriptions'];
                                $dataInsertBook['room_id'] = $temproryReserve['room_id'];
                                $dataInsertBook['room_name'] = '';
                                $roomList = json_decode($temproryReserve['room_list'], true);
                                foreach ($roomList as $room) {
                                    $dataInsertBook['room_name'] .= $room['RoomName'] . ' - ';
                                }
                                $dataInsertBook['room_name'] = substr($dataInsertBook['room_name'], 0, -3);
                                $dataInsertBook['room_name_en'] = $dataInsertBook['room_name'];
                                $dataInsertBook['room_count'] = $temproryReserve['room_count'];
                                $dataInsertBook['start_date'] = $temproryReserve['start_date'];
                                $dataInsertBook['end_date'] = $temproryReserve['end_date'];
                                $dataInsertBook['number_night'] = $temproryReserve['night'];
                                $dataInsertBook['login_id'] = $temproryReserve['login_id'];
                                $dataInsertBook['type_application'] = 'externalApi';
                                $dataInsertBook['factor_number'] = $factorNumber;

                                $irantechCommission = Load::controller('irantechCommission');
                                $it_commission = $irantechCommission->getCommission('PublicPortalHotel', '12');
                                $dataInsertBook['irantech_commission'] = $it_commission;

                                $dataInsertBook['hotel_room_prices_id'] = $temproryReserve['price_detail_id'];
                                $dataInsertBook['room_price'] = $temproryReserve['full_amount'];
                                $dataInsertBook['room_online_price'] = $temproryReserve['full_amount'];
                                $dataInsertBook['room_bord_price'] = $temproryReserve['full_amount'];
                                $dataInsertBook['total_price'] = $temproryReserve['full_amount'];
                                $dataInsertBook['total_price_api'] = $temproryReserve['full_amount'];

                                $resultBook = [];
                                foreach ($arrayDataRequest['BookArray']['RoomList'] as $nRoom => $rooms) {
                                    foreach ($rooms as $nPassenger => $passenger) {
                                        $dataInsertBook['passenger_name'] = $passenger['FirstName'];
                                        $dataInsertBook['passenger_name_en'] = $passenger['FirstNameEnglish'];
                                        $dataInsertBook['passenger_family'] = $passenger['LastName'];
                                        $dataInsertBook['passenger_family_en'] = $passenger['LastNameEnglish'];
                                        $dataInsertBook['passenger_birthday'] = $passenger['Age'];
                                        $dataInsertBook['roommate'] = $nRoom + 1;

                                        $resultBook[] = $admin->ConectDbClient('', $agencyID, "Insert", $dataInsertBook, "book_hotel_local_tb", "");


                                        $modelBase->setTable("report_hotel_tb");
                                        $dataInsertBook['voucher_url'] = $resultHotel['PaymentURL'];
                                        $dataInsertBook['client_id'] = $agencyID;
                                        $resultBook[] = $modelBase->insertLocal($dataInsertBook);
                                    }
                                }

                                if (in_array("0", $resultBook)) {

                                    $dataResponse['ErrorDetail'] = [
                                        'Code' => 'EHPR-04',
                                        'Message' => 'ERROR ON PRE-RESERVE',
                                        'MessagePersian' => 'خطایی در ثبت اطلاعات شما پیش آمده است.'
                                    ];

                                } else {
                                    $dataResponse = [
                                        'Status' => 'success',
                                        'PreReserveNumber' => $factorNumber,
                                        'FullPaymentAmount' => $resultHotel['FullPaymentAmount']
                                    ];
                                }

                            }


                        } else {
                            $dataResponse['ErrorDetail'] = [
                                'Code' => 'EHPR-03',
                                'Message' => 'ERROR ON PRE-RESERVE',
                                'MessagePersian' => 'خطایی در ارسال اطلاعات شما وجود دارد.'
                            ];
                        }


                    }


                }



            } else {
                $dataResponse['ErrorDetail'] = [
                    'Code' => 'EHPR-02',
                    'Message' => 'Not Valid UserName Or Password',
                    'MessagePersian' => ''
                ];
            }




        } catch (Exception $e) {
            $dataResponse['ErrorDetail'] = [
                'Code' => 'EHPR-01',
                'Message' => '',
                'MessagePersian' => ''
            ];
        }

        return $dataResponse;
    }

    public function hotelReserve($requestUrl, $dataRequest)
    {
        try {
            $arrayDataRequest = json_decode($dataRequest, true);
            $factorNumber = filter_var($arrayDataRequest['PreReserveNumber'], FILTER_SANITIZE_STRING);
            //$agencyID = filter_var($arrayDataRequest['AgencyID'], FILTER_SANITIZE_STRING);
            $key = filter_var($arrayDataRequest['Password'], FILTER_SANITIZE_STRING);
            $ModelBase = Load::library('ModelBase');
            $Sql = "SELECT clientId FROM client_user_api WHERE userName='{$this->userNameRequest}' AND keyTabdol='{$key}'";
            $resClient = $ModelBase->load($Sql);
            if (!empty($resClient)) {
                $agencyID = $resClient['clientId'];


                $admin = Load::controller('admin');
                $modelBase = Load::library('ModelBase');

                $sqlBook = " 
                SELECT
                    ( SELECT SUM( room_price ) FROM book_hotel_local_tb WHERE factor_number = '{$factorNumber}' ) AS totalPriceTransaction,
                    ( SELECT COUNT(id) FROM book_hotel_local_tb WHERE factor_number = '{$factorNumber}' ) as countPassengers,
                    BH.* 
                FROM
                    book_hotel_local_tb AS BH 
                WHERE
                    BH.factor_number = '{$factorNumber}'
                    ";
                $reserveInfo = $admin->ConectDbClient($sqlBook, $agencyID, "Select", "", "", "");
                if ($reserveInfo['status'] == 'PreReserve'){

                    $comment = " رزرو " . " " . $reserveInfo['city_name'] . " - " . $reserveInfo['hotel_name'] . " " . "به شماره رزرو " . " " . $reserveInfo['factor_number'];
                    $total_price = $reserveInfo['totalPriceTransaction'];
                    $reason = 'buy_external_hotel';
                    if (isset($reserveInfo['irantech_commission']) && $reserveInfo['irantech_commission'] > 0) {
                        $total_price += $reserveInfo['irantech_commission'] * $reserveInfo['countPassengers'];
                    }

                    // Caution: اعتبارسنجی صاحب سیستم
                    $check = $this->checkCredit($total_price, $agencyID);
                    if ($check['status'] == 'TRUE') {
                        $existTransaction = $this->getTransactionByFactorNumber($factorNumber, $agencyID);
                        if (empty($existTransaction)) {
                            // Caution: کاهش اعتبار موقت صاحب سیستم
                            $reduceTransaction = $this->decreasePendingCredit($total_price, $factorNumber, $comment, $reason, $agencyID);
                            if ($reduceTransaction) {

                                $url = $requestUrl . "HotelReserve";
                                $request['UserName'] = $arrayDataRequest['UserName'];
                                $request['Password'] = $arrayDataRequest['Password'];
                                $request['PaymentCode'] = $reserveInfo['voucher_number'];
                                $request['MemberSessionID'] = $reserveInfo['login_id'];
                                $jsonData = json_encode($request);
                                $resultHotel = functions::curlExecution($url, $jsonData, 'yes');
                                if (!empty($resultHotel) && $resultHotel['Status'] == 'error') {

                                    $data['status'] = 'credit';
                                    $data['payment_type'] = 'credit';
                                    $data['creation_date_int'] = time();

                                    $condition = " factor_number='{$factorNumber}' ";
                                    $resUpdate[] = $admin->ConectDbClient('', $agencyID, 'Update', $data, 'book_hotel_local_tb', $condition);

                                    $modelBase->setTable('report_hotel_tb');
                                    $resUpdate[] = $modelBase->update($data, $condition);

                                    $dataResponse = array(
                                        'RequestStatus' => 'Error',
                                        'ErrorMessage' => 'ERROR ON RESERVE',
                                        'ErrorMessagePersian' => 'اشکالی در فرآیند رزرو هتل پیش آمده است.',
                                        'ErrorCode' => 'EH-07',
                                        'Result' => array()
                                    );

                                } elseif (!empty($resultHotel) && $resultHotel['Status'] == 'success') {


                                    // Caution: آپدیت تراکنش به موفق
                                    $this->setCreditToSuccess($factorNumber, $agencyID);

                                    $bookArray = json_decode($resultHotel['MemberSellList'][0]['BookingArray'], true);

                                    $data['status'] = 'BookedSuccessfully';
                                    $data['payment_date'] = Date('Y-m-d H:i:s');
                                    $data['creation_date_int'] = time();
                                    $data['booking_array'] = json_encode($resultHotel['MemberSellList']);
                                    $data['request_number'] = $bookArray['FNPPNRCode'];
                                    $data['pnr'] = $bookArray['FNPOrderID'];
                                    $data['payment_type'] = 'credit';

                                    $condition = " factor_number='{$factorNumber}' ";
                                    $resUpdate[] = $admin->ConectDbClient('', $agencyID, 'Update', $data, 'book_hotel_local_tb', $condition);

                                    $modelBase->setTable('report_hotel_tb');
                                    $resUpdate[] = $modelBase->update($data, $condition);


                                    if (in_array("0", $resUpdate)) {
                                        $dataResponse['ErrorDetail'] = [
                                            'Code' => 'EHR-07',
                                            'Message' => 'ERROR ON RESERVE',
                                            'MessagePersian' => 'رزرو هتل با موفقیت انجام شده. خطایی در ثبت اطلاعات شما رخ داد است. لطفا با پشتیبانی تماس بگیرید.'
                                        ];
                                    } else {
                                        $dataResponse = [
                                            'Status' => 'success',
                                            'ReserveNumber' => $factorNumber,
                                            'voucher_url' => 'http://test.1011.ir/gds_test/pdf&target=BookingHotelLocal&id=' . $factorNumber
                                        ];
                                    }


                                }


                            } else {
                                $dataResponse['ErrorDetail'] = [
                                    'Code' => 'EHR-06',
                                    'Message' => 'ERROR ON RESERVE',
                                    'MessagePersian' => 'همکار گرامی، در کسر اعتبار شما مشکلی به وجود آمده است.'
                                ];
                            }

                        } else {
                            $dataResponse['ErrorDetail'] = [
                                'Code' => 'EHR-05',
                                'Message' => 'ERROR ON RESERVE',
                                'MessagePersian' => 'شماره فاکتور برای کاهش اعتبار شما تکراری است. از هر شماره فاکتور فقط یک بار میتوانید خرید انجام دهید.'
                            ];
                        }

                    } else {
                        $dataResponse['ErrorDetail'] = [
                            'Code' => 'EHR-04',
                            'Message' => 'ERROR ON RESERVE',
                            'MessagePersian' => 'همکار گرامی، اعتبارکافی نمی باشد'
                        ];
                    }

                } else {
                    $dataResponse['ErrorDetail'] = [
                        'Code' => 'EHR-03',
                        'Message' => 'ERROR ON RESERVE',
                        'MessagePersian' => 'همکار گرامی، برای قطعی کردن رزرو، رزرو باید در حالت پیش رزرو باشد.'
                    ];
                }



            } else {
                $dataResponse['ErrorDetail'] = [
                    'Code' => 'EHR-02',
                    'Message' => 'Not Valid UserName Or Password',
                    'MessagePersian' => ''
                ];
            }


        } catch (Exception $e) {
            $dataResponse['ErrorDetail'] = [
                'Code' => 'EHR-01',
                'Message' => '',
                'MessagePersian' => ''
            ];
        }

        return $dataResponse;
    }




    public function checkCredit($amountToCheck, $clientId)
    {
        $admin = Load::controller('admin');
        //600: pending records under 10 minutes are included
        $time = time() - (600);

        $query = "SELECT"
            . " COALESCE((SELECT SUM(Price) FROM transaction_tb WHERE Status='1'), 0) as `credit`, "
            . " COALESCE((SELECT SUM(Price) FROM transaction_tb WHERE Status='2' AND"
            . " ((PaymentStatus = 'success') OR (PaymentStatus = 'pending' AND CreationDateInt > '{$time}')) ), 0) as `debit` ";
        $result = $admin->ConectDbClient($query, $clientId, 'Select', '', '', '');
        $currentCredit = $result['credit'] - $result['debit'];
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

    public function getTransactionByFactorNumber($factorNumber, $clientId)
    {
        $admin = Load::controller('admin');
        $query = "SELECT * FROM transaction_tb WHERE FactorNumber = '{$factorNumber}'";
        $result = $admin->ConectDbClient($query, $clientId, 'SelectAll', '', '', '');

        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function decreasePendingCredit($amount, $factorNumber, $comment, $reason, $clientId)
    {
        $admin = Load::controller('admin');
        $data['Price'] = $amount;
        $data['FactorNumber'] = $factorNumber;
        $data['Comment'] = $comment;
        $data['Reason'] = $reason;
        $data['Status'] = '2';
        $data['PaymentStatus'] = 'pending';
        $data['creationDateInt'] = time();
        $data['BankTrackingCode'] = 'کسر موقت';
        $admin->ConectDbClient('', $clientId, "Insert", $data, "transaction_tb", "");
        $data['clientID'] = $clientId;
        $this->transactions->insertTransaction($data);
        return true;
    }

    public function setCreditToSuccess($factorNumber, $clientId)
    {
        $admin = Load::controller('admin');
        $data['PaymentStatus'] = 'success';
        $data['PriceDate'] = date("Y-m-d H:i:s");
        $data['BankTrackingCode'] = '';
        $condition = "FactorNumber = '{$factorNumber}'";
        $result = $admin->ConectDbClient('', $clientId, 'Update', $data, 'transaction_tb', $condition);
        $data['clientID'] =$clientId;
        $this->transactions->updateTransaction($data,$condition);
        return $result;
    }


    /*public function productView($requestUrl, $dataRequest)
    {
        try {
            $url = $requestUrl . "ProductView";
            $result = functions::curlExecution($url, $dataRequest, 'yes');
        } catch (Exception $e) {
            $dataResponse = array(
                'RequestStatus' => 'Error',
                'ErrorMessage' => json_decode($e->getMessage()),
                'ErrorMessagePersian' => '',
                'ErrorCode' => 'EH-08',
                'Result' => []
            );
        }

        $dataResponse = array(
            'Result' => $result
        );
        return $dataResponse;
    }

    public function productCancelationDetail($requestUrl, $dataRequest)
    {
        try {
            $url = $requestUrl . "ProductCancelationDetail";
            $result = functions::curlExecution($url, $dataRequest, 'yes');
        } catch (Exception $e) {
            $dataResponse = array(
                'RequestStatus' => 'Error',
                'ErrorMessage' => json_decode($e->getMessage()),
                'ErrorMessagePersian' => '',
                'ErrorCode' => 'EH-09',
                'Result' => []
            );
        }

        $dataResponse = array(
            'Result' => $result
        );
        return $dataResponse;
    }

    public function productCancelation($requestUrl, $dataRequest)
    {
        try {
            $url = $requestUrl . "ProductCancelation";
            $result = functions::curlExecution($url, $dataRequest, 'yes');
        } catch (Exception $e) {
            $dataResponse = array(
                'RequestStatus' => 'Error',
                'ErrorMessage' => json_decode($e->getMessage()),
                'ErrorMessagePersian' => '',
                'ErrorCode' => 'EH-10',
                'Result' => []
            );
        }

        $dataResponse = array(
            'Result' => $result
        );
        return $dataResponse;
    }

    public function checkCancelationStatus($requestUrl, $dataRequest)
    {
        try {
            $url = $requestUrl . "CheckCancelationStatus";
            $result = functions::curlExecution($url, $dataRequest, 'yes');
        } catch (Exception $e) {
            $dataResponse = array(
                'RequestStatus' => 'Error',
                'ErrorMessage' => json_decode($e->getMessage()),
                'ErrorMessagePersian' => '',
                'ErrorCode' => 'EH-11',
                'Result' => []
            );
        }

        $dataResponse = array(
            'Result' => $result
        );
        return $dataResponse;
    }*/

}


new externalHotelApi();