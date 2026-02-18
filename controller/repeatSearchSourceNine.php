<?php
/**
 * Created by PhpStorm.
 * User: AbbasPC
 * Date: 10/6/2020
 * Time: 2:24 PM
 */

class repeatSearchSourceNine
{

    public $StepUniqueCode = '';
    public $apiAddress = '';

    public function __construct()
    {
        if ((isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], '192.168.1.100') !== false) || (isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], 'online.1011.ir') !== false) || (isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], '1011.ir') !== false) || (isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], 'localhost') !== false)) {//local
//            $this->apiAddress = 'http://safar360.com/CoreTestDeveloper/V-1/';
            $this->apiAddress = 'http://safar360.com/CoreTestDeveloper/V-1/';
        } else {
//            $this->apiAddress = 'http://safar360.com/Core/V-1/';
            $this->apiAddress = 'http://safar360.com/Core/V-1/';
        }
    }

    #region UniqueCode

    public function UniqueCode($userName)
    {
        $url = $this->apiAddress . "Flight/GetCode/" . $userName;
        $JsonArray = array();
        $tickets = functions::curlExecution($url, $JsonArray, 'yes');

        return $tickets['Result']['Value'];

    }

    #endregion

    #region step UniqueCode AND Search

    public function Search($RequestNumber)
    {
        $Ticket = $this->FindTicket($RequestNumber, 'load');
        $routeTicket = $this->FindTicketSubDirection($RequestNumber);

        $InfoUser = $this->InfoUser($Ticket['client_id']);
        $uniqueCode = $this->UniqueCode($InfoUser['Username']);
        $this->StepUniqueCode = $uniqueCode;

         echo $url = $this->apiAddress . "Flight/Search/" . $uniqueCode;

        $d['Adult'] = (is_numeric($Ticket['adt_qty']) && !empty($Ticket['adt_qty']) && $Ticket['adt_qty'] > 0) ? $Ticket['adt_qty'] : '1';
        $d['Child'] = (is_numeric($Ticket['chd_qty']) && !empty($Ticket['chd_qty']) && $Ticket['chd_qty'] > 0) ? $Ticket['chd_qty'] : '0';
        $d['Infant'] = (is_numeric($Ticket['inf_qty']) && !empty($Ticket['inf_qty']) && $Ticket['inf_qty'] > 0) ? $Ticket['inf_qty'] : '0';
        $d['Origin'] = $Ticket['origin_airport_iata'];
        $d['Destination'] = ($Ticket['desti_airport_iata'] == 'IST' || $Ticket['desti_airport_iata']=='ISL' || $Ticket['desti_airport_iata']=='SAW') ? 'IST' : $Ticket['desti_airport_iata'];
        $d['DepartureDate'] = functions::DateJalali($Ticket['date_flight']);
        $d['ArrivalDate'] = ($Ticket['direction']=='TwoWay') ? functions::DateJalali($routeTicket[1]['DepartureDate']) : '';
        $d['UserName'] = $InfoUser['Username'];
        $d['IsInternal'] = false;

         $JsonArray = json_encode($d);

        $searchTicket = functions::curlExecution($url, $JsonArray, 'yes');
        $ListSearchTicket = (isset($searchTicket['Flights']) && !empty($searchTicket['Flights']) ? $searchTicket['Flights'] : array());
        if (!file_exists(LOGS_DIR . 'cashFlight/manualReserve/')) {
            mkdir(LOGS_DIR . 'cashFlight/manualReserve/', 0777, true);
        }


        foreach ($ListSearchTicket as $key => $Ticket) {
            $Code = DateTimeSetting::jdate("YmdHis", time(), '', '', 'en') . round(microtime(true) * rand('11', '99') * (sqrt(rand(11, 88))));
            $Ticket['uniqDetect'] = $Code ;
                if ($Ticket['SourceId'] == '10' && $Ticket['SourceName'] == 'Source9') {
                    $TicketArrayFinal[$key] = $Ticket;
            }
        }

        error_log(json_encode($TicketArrayFinal) . " \n", 3, LOGS_DIR . 'cashFlight/manualReserve/' . $this->StepUniqueCode . '.txt');
        return $TicketArrayFinal;

    }
    #endregion

    #regionRevalidateAndPreReserve
    public function RevalidateAndPreReserve($UniqueCode, $ClientId, $FlightID, $RequestNumber, $SourceId)
    {

        $ModelBase =Load::library('ModelBase');

        $InfoTicket = $this->FindTicket($RequestNumber, 'select');
        echo $url = $this->apiAddress . "Flight/Revalidate/" . RequestNumber;


        $InfoUser = $this->InfoUser($ClientId);
        $d['UserName'] = $InfoUser['Username'];
        $d['FlightID'] = $FlightID;
        $d['AdultCount'] = $InfoTicket[0]['AdultCount'];
        $d['ChildCount'] = $InfoTicket[0]['ChildCount'];
        $d['InfantCount'] = $InfoTicket[0]['InfantCount'];
        $d['SourceId'] = $SourceId;

       echo  $data_json = json_encode($d); die();
        $Revalidate = functions::curlExecution($url, $data_json, 'yes');
        error_log('try show result Request Client In Book in : ' . date('Y/m/d H:i:s') . '   Request equal in With FlightID : => ' . $FlightID . ': ' . $data_json . " \n" . "Response equal in With RequestNumber=>" . $FlightID . ":" . " " . json_encode($Revalidate, true) . " \n", 3, LOGS_DIR . 'log_repeatStepRevalidateTicket.txt');
        if (!empty($Revalidate['Result']['Flight']['FlightID']) && $Revalidate['Result']['Flight']['PassengerDatas'][0]['BasePrice'] > 0 && isset($Revalidate['Result']['ProviderStatus']) && $Revalidate['Result']['ProviderStatus'] != 'Error') {
            $url = $this->apiAddress . "Flight/PreReserve/" . $Revalidate['Result']['SessionID'];

            $emptyArray = array();
            $Reserve = functions::curlExecution($url, $emptyArray, 'yes');

            if (!empty($Reserve['Result']['Request'])) {

                $TicketRequestNumber['request_number'] = $Reserve['Result']['Request']['RequestNumber'];


                $Condition = "request_number='{$RequestNumber}'";
                $ModelBase->setTable('report_tb');
                $ModelBase->update($TicketRequestNumber, $Condition);

                $admin = Load::controller('admin');
                $admin->ConectDbClient('', $InfoTicket[0]['client_id'], "Update", $TicketRequestNumber, "book_local_tb", $Condition);

                $SqlCredit = "SELECT * FROM credit_detail_tb WHERE requestNumber='{$RequestNumber}'";
                $InfoDetail = $admin->ConectDbClient($SqlCredit, $InfoTicket[0]['client_id'], "Select", "", "", "");

                $SqlCredit = "SELECT * FROM credit_detail_tb WHERE requestNumber='{$RequestNumber}'";
                $InfoDetail = $admin->ConectDbClient($SqlCredit, $InfoTicket[0]['client_id'], "Select", "", "", "");
                $ConditionCreditDetail = "requestNumber='{$RequestNumber}'";
                $CreditRequestNumber['requestNumber'] = $Reserve['Result']['Request']['RequestNumber'];
                $CreditRequestNumber['comment'] = str_replace($RequestNumber, $CreditRequestNumber['requestNumber'], $InfoDetail['comment']);
                $admin->ConectDbClient('', $InfoTicket[0]['client_id'], "Update", $CreditRequestNumber, "credit_detail_tb", $ConditionCreditDetail);


                $data['RequestNumberOfReserve'] = $TicketRequestNumber['request_number'];
                $data['RequestNumberOfTicketOld'] = $RequestNumber;
                $data['CaptchaCode'] = urldecode($Revalidate['Result']['ImportantLink']);
                $data['UserInfo'] = $InfoTicket;
                $data['message'] = '';
            } else {
                $data['message'] = 'خطا در روند رزرو بلیط';
            }

        } else {
            $data['message'] = 'خطا در روند رزرو بلیط-اعتبار سنجی';
        }

        return $data;
    }

    #endregion

    #region BookAndReserve

    public function BookAndReserve($Param)
    {
        $admin = Load::controller('admin');
        $Tickets = $this->FindTicket($Param['RequestNumber'], 'select');
        $irantechCommission = Load::controller('irantechCommission');

        if (!empty($Tickets)) {
            $data['securityCode'] = (isset($Param['LinkCaptcha']) && !empty($Param['LinkCaptcha'])) ? $Param['LinkCaptcha'] : '';
            foreach ($Tickets as $key => $rec) {

                if (!empty($rec['passenger_birthday'])) {

                    $date_miladi = functions::ConvertToMiladi($rec['passenger_birthday']);
                }

                $data['Books'][$key]['FirstName'] = $rec['passenger_name_en'];
                $data['Books'][$key]['LastName'] = $rec['passenger_family_en'];
                $data['Books'][$key]['PersianFirstName'] = $rec['passenger_name'];
                $data['Books'][$key]['PersianLastName'] = $rec['passenger_family'];
                $data['Books'][$key]['PassengerType'] = $this->type_passengers(!empty($rec['passenger_birthday_en']) ? $rec['passenger_birthday_en'] : $date_miladi);
                $data['Books'][$key]['PassengerTitle'] = $this->type_title($rec['passenger_gender'], $data['Books'][$key]['PassengerType']);
                $data['Books'][$key]['DateOfBirth'] = !empty($rec['passenger_birthday_en']) ? $rec['passenger_birthday_en'] : $date_miladi;
                $data['Books'][$key]['NationalCode'] = ($rec['passenger_national_code'] == '0000000000') ? '' : $rec['passenger_national_code'];
                $data['Books'][$key]['PassportNumber'] = $rec['passportNumber'];
                $data['Books'][$key]['PassportExpireDate'] = $rec['passportExpire'];
                $data['Books'][$key]['Nationality'] = !empty($rec['passportCountry']) && $rec['passportCountry'] != 'IRN' ? $rec['passportCountry'] : "IR";
                $data['Books'][$key]['AreaCode'] = "21";
                $data['Books'][$key]['CountryCode'] = "98";

                $data['Books'][$key]['PhoneNumber'] = "09123493154";


                $data['Books'][$key]['Email'] = 'info@iran-tech.com';//(!empty($rec['email_buyer'])) ? $rec['email_buyer'] : "safar360@iran-tech.com";
                if (!empty($rec['passportNumber'])) {
                    $data['Books'][$key]['Documenttype'] = 'Psp';
                } else {
                    $data['Books'][$key]['Documenttype'] = 'Nic';
                }
            }


            $url = $this->apiAddress . "Flight/Book/{$Param['RequestNumber']}";
            $info_json_passengers = json_encode($data);
            $book = functions::curlExecution($url, $info_json_passengers, 'yes');
            error_log('try show result Request Client In Book in : ' . date('Y/m/d H:i:s') . '   Request equal in With RequestNumber : => ' . $Param['RequestNumber'] . ': ' . $info_json_passengers . " \n" . "Response equal in With RequestNumber=>" . $Param['RequestNumber'] . ":" . " " . json_encode($book, true) . " \n", 3, LOGS_DIR . 'log_repeatStepBookTicket.txt');

            if (!empty($book) && isset($book['Result']['ProviderStatus']) && $book['Result']['ProviderStatus'] != "Error") {


                $dataBook['api_id'] = $Param['api_id'];
                $dataBook['pid_private'] = '0';


                $it_commission = $irantechCommission->getFlightCommission('PublicLocalSystem', $dataBook['api_id']);

                foreach ($book['Result']['Request']['RequestFlights']['OutputRoutes'] as $RequestFlights) {


                    $dataBook['seat_class'] = $RequestFlights['SeatClass'];
                    $dataBook['cabin_type'] = $RequestFlights['CabinType'];
                    $dataBook['flight_number'] = $RequestFlights['FlightNo'];
                    $dataBook['airline_iata'] = $RequestFlights['Airline']['Code'];
                    $dataBook['airline_name'] = $RequestFlights['Airline']['Name'];
//                    $dataBook['flight_type'] = (strtolower($RequestFlights['FlightType']) == 'system') ? 'system' : 'charter';
                    $dataBook['serviceTitle'] = 'PublicLocalSystem';


                }
                foreach ($book['Result']['Request']['RequestFares'] as $RequestFares) {

                    if (strtolower($RequestFares['PassengerType']) == "adt") {
                        $Price['Adt']     =   functions::convert_toman_rial($RequestFares['TotalFare']);
                        $PriceFare['Adt'] =   functions::convert_toman_rial($RequestFares['BaseFare']);
                        $PriceTax['Adt']  =   functions::convert_toman_rial($RequestFares['TaxPrice']);
                    }
                    if (strtolower($RequestFares['PassengerType']) == "chd") {
                        $Price['Chd']     =   functions::convert_toman_rial($RequestFares['TotalFare']);
                        $PriceFare['Chd'] =   functions::convert_toman_rial($RequestFares['BaseFare']);
                        $PriceTax['Chd']  =   functions::convert_toman_rial($RequestFares['TaxPrice']);
                    }
                    if (strtolower($RequestFares['PassengerType']) == "inf") {
                        $Price['Inf']     =   functions::convert_toman_rial($RequestFares['TotalFare']);
                        $PriceFare['Inf'] =   functions::convert_toman_rial($RequestFares['BaseFare']);
                        $PriceTax['Inf']  =   functions::convert_toman_rial($RequestFares['TaxPrice']);
                    }

                }

                foreach ($book['Result']['Request']['RequestPassengers'] as $ReqPassenger) {
                    if (strtolower($ReqPassenger['PassengerType']) == "adt") {
                        $d['adt_price'] = $Price['Adt'];
                        $d['adt_fare'] = $PriceFare['Adt'];
                        $d['adt_tax']  = $PriceTax['Adt'];
                        $d['discount_adt_price'] = $Price['discount_adt_price'];
                        $d['adt_qty'] = '1';
                        $d['chd_price'] = '0';
                        $d['chd_fare'] = '0';
                        $d['chd_tax']  = '0';
                        $d['discount_chd_price'] = '0';
                        $d['chd_qty'] = '0';
                        $d['inf_price'] = '0';
                        $d['inf_fare'] ='0';
                        $d['inf_tax']  = '0';
                        $d['inf_qty'] = '0';
                        $d['discount_inf_price'] = '0';
                        $d['percent_discount'] = $Price['percent_discount'];
                        list($api_commission, $agency_commission, $supplier_commission) = $this->commission($Tickets[0]['flight_type'], $dataBook['adt_price'], 'public', $Tickets[0]['price_change'], $Tickets[0]['price_change_type'],$Tickets[0]['adt_fare']);
                        $d['api_commission'] = $api_commission;
                        $d['agency_commission'] = $agency_commission;
                        $d['supplier_commission'] = $supplier_commission;
                        $d['irantech_commission'] = $it_commission;
                    } else if (strtolower($ReqPassenger['PassengerType']) == "chd") {
                        $d['chd_price'] = $Price['Chd'];
                        $d['chd_fare'] = $PriceFare['Chd'];
                        $d['chd_tax']  = $PriceTax['Chd'];
                        $d['discount_chd_price'] = $Price['discount_chd_price'];
                        $d['chd_qty'] = '1';
                        $d['adt_price'] = '0';
                        $d['adt_fare'] = '0';
                        $d['adt_tax']  = '0';
                        $d['adt_qty'] = '0';
                        $d['discount_adt_price'] = '0';
                        $d['inf_qty'] = '0';
                        $d['inf_price'] = '0';
                        $d['inf_fare'] ='0';
                        $d['inf_tax']  = '0';
                        $d['discount_inf_price'] = '0';
                        $d['percent_discount'] = $Price['percent_discount'];
                        list($api_commission, $agency_commission, $supplier_commission) = $this->commission($Tickets[0]['flight_type'], $dataBook['chd_price'], 'public', $Tickets[0]['price_change'], $Tickets[0]['price_change_type'],$Tickets[0]['chd_fare']);
                        $d['api_commission'] = $api_commission;
                        $d['agency_commission'] = $agency_commission;
                        $d['supplier_commission'] = $supplier_commission;
                        $d['irantech_commission'] = $it_commission;
                    } else if (strtolower($ReqPassenger['PassengerType']) == "inf") {
                        $d['inf_price'] = $Price['Inf'];
                        $d['inf_fare'] = $PriceFare['Inf'];
                        $d['inf_tax']  = $PriceTax['Inf'];
                        $d['inf_qty'] = '1';
                        $d['adt_qty'] = '0';
                        $d['adt_price'] = '0';
                        $d['adt_fare'] = '0';
                        $d['adt_tax']  = '0';
                        $d['discount_adt_price'] = '0';
                        $d['chd_price'] = '0';
                        $d['chd_fare'] = '0';
                        $d['chd_tax']  = '0';
                        $d['discount_chd_price'] = '0';
                        $d['chd_qty'] = '0';
                        $d['percent_discount'] = '0';
                        list($api_commission, $agency_commission, $supplier_commission) = $this->commission($Tickets[0]['flight_type'], $dataBook['inf_price'], 'public', $Tickets[0]['price_change'], $Tickets[0]['price_change_type'],$Tickets[0]['inf_fare']);
                        $d['api_commission'] = $api_commission;
                        $d['agency_commission'] = $agency_commission;
                        $d['supplier_commission'] = $supplier_commission;
                        $d['irantech_commission'] = $it_commission;
                    }

                    $InfoTicket = $this->FindTicket($Param['RequestNumber'], 'load');
                    $condition = " request_number='{$Param['RequestNumber']}' AND passenger_age='{$ReqPassenger['PassengerType'] }'";
                    $res = $admin->ConectDbClient('', $InfoTicket['client_id'], "Update", $dataBook, "book_local_tb", $condition);
                    if ($res) {
                        $dataBook['private_m4'] = '2';
                        $dataBook['successfull'] = 'book';
                        $ModelBase = Load::library('ModelBase');
                        $ModelBase->setTable("report_tb");
                        $res_report = $ModelBase->update($dataBook, $condition);
                        if ($res_report) {
                            $FlagUpdate = true;
                        }
                    }
                }
                if ($FlagUpdate) {
                    $result['result_status'] = 'SuccessMethodBook';
                }


                if ($result['result_status'] == 'SuccessMethodBook') {


                    $url = $this->apiAddress . "Flight/Reserve/{$Param['RequestNumber']}";
                    $emptyArray = array();
                    $ReserveTicket =  functions::curlExecution($url, $emptyArray, 'yes');
                    error_log('try show result Request Client In Reserve in : ' . date('Y/m/d H:i:s') . '   Request equal in With RequestNumber : => ' . $Param['RequestNumber'] . ':' . " \n" . "Response equal in With RequestNumber=>" . $Param['RequestNumber'] . ":" . " " . json_encode($ReserveTicket, true) . " \n", 3, LOGS_DIR . 'log_repeatStepBookTicket.txt');
                    $flag = false ;
                    if ($ReserveTicket['Result']['Request']['Status'] == 'Ticketed') {

                        $this->UpdateCreditAdminAgency($InfoTicket,$Param['RequestNumberOfTicketOld']);
                        $this->DecreaseAgency($InfoTicket,$Param['RequestNumberOfTicketOld']);


                        if (!empty($ReserveTicket['Result']['Request']['RequestPassengers'])) {

                            foreach ($Tickets as $i => $Ticket) {
                                $dataReserve['successfull'] = 'book';
                                $dataReserve['payment_date'] = Date('Y-m-d H:i:s');
                                $dataReserve['pnr'] =$ReserveTicket['Result']['Request']['OutputRoutes'][0]['AirlinePnr'];
                                $dataReserve['eticket_number'] = $ReserveTicket['Result']['Request']['RequestPassengers'][$i]['TicketNumber'];

                                if ($Tickets[$i]['passenger_national_code'] != '0000000000') {
                                    $uniqCondition = " AND passenger_national_code = '{$Tickets[$i]['passenger_national_code']}' ";
                                } else {
                                    $uniqCondition = " AND passportNumber = '{$Tickets[$i]['passportNumber']}' ";
                                }

                                $condition = " request_number = '{$Param['RequestNumber']}' " . $uniqCondition;
                                $resReserve = $admin->ConectDbClient('', $InfoTicket['client_id'], "Update", $dataReserve, "book_local_tb", $condition);

                                if ($resReserve) {
                                    $dataReserve['private_m4'] = '2';
                                    $ModelBase->setTable('report_tb');
                                    $conditionBase = " request_number = '{$Param['RequestNumber']}' " . $uniqCondition;
                                    $ModelBase->update($dataReserve, $conditionBase);
                                }
                                $flag = true;
                            }

                        }
                    }
                    if($flag)
                    {
                        $data['message'] = 'اطلاعات ارسال شد';
                    }

                }

            } else {
                $data['message'] = 'خطا در مرحله تایید نهایی';
            }

        } else {
            $data['message'] = 'اطلاعات پرواز مورد نظر موجود نمی باشد';
        }

        return $data;

    }

    #endregion

    #region FindTicket
    public function FindTicket($RequestNumber, $Type)
    {
        $ModelBase = Load::library('ModelBase');

        $QueryFindTicket = "SELECT *,
        (SELECT SUM(adt_qty) FROM report_tb WHERE request_number='{$RequestNumber}') AS AdultCount,
        (SELECT SUM(chd_qty) FROM report_tb WHERE request_number='{$RequestNumber}') AS ChildCount,
        (SELECT SUM(inf_qty) FROM report_tb WHERE request_number='{$RequestNumber}') AS InfantCount,
        (SELECT COUNT(id)  FROM report_tb WHERE request_number='{$RequestNumber}' ) AS count_id
        FROM report_tb WHERE request_number='{$RequestNumber}'";
        $ResultFindTicket = $ModelBase->$Type($QueryFindTicket);
        return $ResultFindTicket;

    }
    #endregion

    #region InfoUser
    public function InfoUser($ClientId)
    {
        Load::autoload('clientAuth');
        $clientAuth = new clientAuth();
        $InfoUser = $clientAuth->ticketFlightAuth($ClientId);

        return $InfoUser;

    }
    #endregion

    #region type_passengers

    public function type_passengers($birthday)
    {

        $date_two = date("Y-m-d", strtotime("-2 year"));
        $date_twelve = date("Y-m-d", strtotime("-12 year"));

        if (strcmp($birthday, $date_two) > 0) {
            return "Inf";
        } elseif (strcmp($birthday, $date_two) <= 0 && strcmp($birthday, $date_twelve) > 0) {
            return "Chd";
        } else {
            return "Adt";
        }
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

    #region FindTicketSubDirection
    public function FindTicketSubDirection($RequestNumber)
    {
        $ModelBase = Load::library('ModelBase');

        $QueryFindTicket = "SELECT * FROM report_routes_tb WHERE requestNumber = '{$RequestNumber}' GROUP BY TypeRoute";
        $ResultFindTicket = $ModelBase->select($QueryFindTicket);
        return $ResultFindTicket;

    }
    #endregion

    public function ReserveFinal($requestNumber)
    {


        $ModelBase = Load::library('ModelBase');
        $admin = Load::controller('admin');
        echo $url = $this->apiAddress . "Flight/Reserve/{$requestNumber}";
          $emptyArray = array();
          $Reserve =  functions::curlExecution($url, $emptyArray, 'yes');
          error_log('try show result method ticketed in : ' . date('Y/m/d H:i:s') . ' buy  With RequestNumber : =>' . $requestNumber . ' AND array Equal  =>' . json_encode($Reserve, true) . " \n", 3, LOGS_DIR . 'log_method_reserve_manual.txt');

          if(isset($Reserve['Result']) && $Reserve['Result']['Request']['Status'] == 'Ticketed') {
              $query = "SELECT * FROM report_tb WHERE request_number = '{$requestNumber}'";
              $ticketsCurrent = $ModelBase->select($query);
              foreach ($ticketsCurrent as $i => $privateTicket) {
                  $data['pnr'] = $Reserve['Result']['Request']['OutputRoutes'][0]['AirlinePnr'];
                  $data['eticket_number'] = !empty($Reserve['Result']['Request']['RequestPassengers']) ? $Reserve['Result']['Request']['RequestPassengers'][$i]['TicketNumber'] : '';


                  if ($ticketsCurrent[$i]['passenger_national_code'] != '0000000000') {
                      $uniqCondition = " AND passenger_national_code = '{$ticketsCurrent[$i]['passenger_national_code']}' ";
                  } else {
                      $uniqCondition = " AND passportNumber = '{$ticketsCurrent[$i]['passportNumber']}' ";
                  }

                  $condition = " request_number = '{$requestNumber}' " . $uniqCondition;
                  if (empty($eachDirection['pnr']) && empty($eachDirection['eticket_number'])) {
                      $res = $admin->ConectDbClient('', $privateTicket['client_id'], 'Update', $data, 'book_local_tb', $condition);
                  }
                  if (isset($res) && $res) {
                      $data['private_m4'] = '1';
                      $ModelBase->setTable('report_tb');
                      $conditionBase = " request_number = '{$requestNumber}' " . $uniqCondition;
                      if (empty($privateTicket['pnr']) && empty($privateTicket['eticket_number'])) {
                          $ModelBase->update($data, $conditionBase);
                      }
                  }
              }

              echo 'ok';

              return 'success';
          }

          return 'false';


    }
}