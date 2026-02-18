<?php

/**
 * Class repeatStepSourceFour
 * @property repeatStepSourceFour $repeatStepSourceFour
 */
class repeatStepSourceFour extends clientAuth
{
    public $StepUniqueCode = '';
    public $apiAddress = '';
    public $transactions;

    public function __construct()
    {
        if ((isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], '192.168.1.100') !== false) || (isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], 'online.1011.ir') !== false) || (isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], '1011.ir') !== false) || (isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], 'localhost') !== false)) {//local
//            $this->apiAddress = 'http://safar360.com/CoreTestDeveloper/V-1/';
            $this->apiAddress = 'http://safar360.com/CoreTestDeveloper/V-1/';
        } else {
//            $this->apiAddress = 'http://185.204.101.23/Core/';
//            $this->apiAddress = 'http://safar360.com/Core/V-1/';
            $this->apiAddress = 'http://safar360.com/Core/V-1/';
        }

        $this->transactions = $this->getModel('transactionsModel');
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

    public function Search($RequestNumber, $ClientId, $SourceId = null)
    {

        $Ticket = $this->FindTicket($RequestNumber, 'load');

        $InfoUser = $this->InfoUser($ClientId);
        $uniqueCode = $this->UniqueCode($InfoUser['Username']);
        $this->StepUniqueCode = $uniqueCode;

        echo $url = $this->apiAddress . "Flight/Search/" . $uniqueCode;

        $d['Adult'] = (is_numeric($Ticket['adt_qty']) && !empty($Ticket['adt_qty']) && $Ticket['adt_qty'] > 0) ? $Ticket['adt_qty'] : '1';
        $d['Child'] = (is_numeric($Ticket['chd_qty']) && !empty($Ticket['chd_qty']) && $Ticket['chd_qty'] > 0) ? $Ticket['chd_qty'] : '0';
        $d['Infant'] = (is_numeric($Ticket['inf_qty']) && !empty($Ticket['inf_qty']) && $Ticket['inf_qty'] > 0) ? $Ticket['inf_qty'] : '0';
        $d['Origin'] = $Ticket['origin_airport_iata'];
        $d['Destination'] = $Ticket['desti_airport_iata'];
        $d['DepartureDate'] = functions::DateJalali($Ticket['date_flight']);
        $d['ArrivalDate'] = '';
        $d['UserName'] = $InfoUser['Username'];
        $d['IsInternal'] = true;
        $d['Page'] = "1";
        $d['Count'] = "120";

        $JsonArray = json_encode($d);


        $searchTicket = functions::curlExecution($url, $JsonArray, 'yes');
        $ListSearchTicket = (isset($searchTicket['Flights']) && !empty($searchTicket['Flights']) ? $searchTicket['Flights'] : array());


        foreach ($ListSearchTicket as $key => $Ticket) {
            if ($Ticket['SourceId'] == '8' && $Ticket['SourceName'] == 'Source7' && strtolower($Ticket['FlightType']) == 'system') {
                $TicketArrayFinal[$key] = $Ticket;

            } else {
                if ($Ticket['SourceId'] == '11' && $Ticket['SourceName'] == 'Source10' && strtolower($Ticket['FlightType']) == 'system') {
                    $TicketArrayFinal[$key] = $Ticket;
                }
            }


        }
        return $TicketArrayFinal;

    }
    #endregion

    #regionRevalidateAndPreReserve
    public function RevalidateAndPreReserve($UniqueCode, $ClientId, $FlightID, $RequestNumber, $SourceId)
    {

        Load::autoload('ModelBase');
        $ModelBase = new ModelBase;

        $InfoTicket = $this->FindTicket($RequestNumber, 'select');
        echo $url = $this->apiAddress . "Flight/Revalidate/" . $UniqueCode;


        $InfoUser = $this->InfoUser($ClientId);
        $d['UserName'] = $InfoUser['Username'];//'kabkan-caspian';//$this->userPishro;
        $d['FlightID'] = $FlightID;
        $d['AdultCount'] = $InfoTicket[0]['AdultCount'];
        $d['ChildCount'] = $InfoTicket[0]['ChildCount'];
        $d['InfantCount'] = $InfoTicket[0]['InfantCount'];
        $d['SourceId'] = $SourceId;

        $data_json = json_encode($d);
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
                        $Price['Adt'] = functions::convert_toman_rial($RequestFares['TotalFare']);
                        $PriceFare['Adt'] = functions::convert_toman_rial($RequestFares['BaseFare']);
                        $PriceTax['Adt'] = functions::convert_toman_rial($RequestFares['Tax']);
                    }
                    if (strtolower($RequestFares['PassengerType']) == "chd") {
                        $Price['Chd'] = functions::convert_toman_rial($RequestFares['TotalFare']);
                        $PriceFare['Chd'] = functions::convert_toman_rial($RequestFares['BaseFare']);
                        $PriceTax['Chd'] = functions::convert_toman_rial($RequestFares['Tax']);
                    }
                    if (strtolower($RequestFares['PassengerType']) == "inf") {
                        $Price['Inf'] = functions::convert_toman_rial($RequestFares['TotalFare']);
                        $PriceFare['Inf'] = functions::convert_toman_rial($RequestFares['BaseFare']);
                        $PriceTax['Inf'] = functions::convert_toman_rial($RequestFares['Tax']);
                    }

                }

                foreach ($book['Result']['Request']['RequestPassengers'] as $ReqPassenger) {
                    if (strtolower($ReqPassenger['PassengerType']) == "adt") {
                        $dataBook['adt_price'] = $Price['Adt'];
                        $dataBook['adt_fare'] = $PriceFare['Adt'];
                        $dataBook['adt_tax'] = $PriceTax['Adt'];
                        list($api_commission, $agency_commission, $supplier_commission) = $this->commission($Tickets[0]['flight_type'], $dataBook['adt_price'], 'public', $Tickets[0]['price_change'], $Tickets[0]['price_change_type'], $Tickets[0]['adt_fare']);
                        $dataBook['api_commission'] = $api_commission;
                        $dataBook['agency_commission'] = $agency_commission;
                        $dataBook['supplier_commission'] = $supplier_commission;
                        $dataBook['irantech_commission'] = $it_commission;
                    } else if (strtolower($ReqPassenger['PassengerType']) == "chd") {
                        $dataBook['chd_price'] = $Price['Chd'];
                        $dataBook['chd_fare'] = $PriceFare['Chd'];
                        $dataBook['chd_tax'] = $PriceTax['Chd'];
                        list($api_commission, $agency_commission, $supplier_commission) = $this->commission($Tickets[0]['flight_type'], $dataBook['chd_price'], 'public', $Tickets[0]['price_change'], $Tickets[0]['price_change_type'], $Tickets[0]['chd_fare']);
                        $dataBook['api_commission'] = $api_commission;
                        $dataBook['agency_commission'] = $agency_commission;
                        $dataBook['supplier_commission'] = $supplier_commission;
                        $dataBook['irantech_commission'] = $it_commission;
                    } else if (strtolower($ReqPassenger['PassengerType']) == "inf") {
                        $dataBook['inf_price'] = $Price['Inf'];
                        $dataBook['inf_fare'] = $PriceFare['Inf'];
                        $dataBook['inf_tax'] = $PriceTax['Inf'];
                        list($api_commission, $agency_commission, $supplier_commission) = $this->commission($Tickets[0]['flight_type'], $dataBook['inf_price'], 'public', $Tickets[0]['price_change'], $Tickets[0]['price_change_type'], $Tickets[0]['inf_fare']);
                        $dataBook['api_commission'] = $api_commission;
                        $dataBook['agency_commission'] = $agency_commission;
                        $dataBook['supplier_commission'] = $supplier_commission;
                        $dataBook['irantech_commission'] = $it_commission;
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
                    $ReserveTicket = functions::curlExecution($url, $emptyArray, 'yes');
                    error_log('try show result Request Client In Reserve in : ' . date('Y/m/d H:i:s') . '   Request equal in With RequestNumber : => ' . $Param['RequestNumber'] . ':' . " \n" . "Response equal in With RequestNumber=>" . $Param['RequestNumber'] . ":" . " " . json_encode($ReserveTicket, true) . " \n", 3, LOGS_DIR . 'log_repeatStepBookTicket.txt');
                    $flag = false;
                    if ($ReserveTicket['Result']['Request']['Status'] == 'Ticketed') {

                        $this->UpdateCreditAdminAgency($InfoTicket, $Param['RequestNumberOfTicketOld']);
                        $this->DecreaseAgency($InfoTicket, $Param['RequestNumberOfTicketOld']);


                        if (!empty($ReserveTicket['Result']['Request']['RequestPassengers'])) {

                            foreach ($Tickets as $i => $Ticket) {
                                $dataReserve['successfull'] = 'book';
                                $dataReserve['payment_date'] = Date('Y-m-d H:i:s');
                                $dataReserve['pnr'] = $ReserveTicket['Result']['Request']['OutputRoutes'][0]['AirlinePnr'];
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
                    if ($flag) {
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
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

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

    #region commission

    public function commission($flight_type, $api_price, $private = NULL, $price_change = NULL, $price_change_type = NULL, $priceFare)
    {
        /*
         * @param $flight_type string , value is charter OR system;
         * @param $api_price  int , value is basefare of api output
         * @param $private string , value is public OR private ;
         * @param $price_change int , value calculate in function getPriceChanges ;
         * @param $price_change_type string , value is cost or percent ;
         */


        if ($flight_type == "charter") {
            $api_commission = "15000";
            $agency_commission = ($price_change_type == 'percent' ? ($api_price + $api_commission) * ($price_change / 100) : $price_change);
            $supplier_commission = $api_price + $api_commission;
        } else if ($flight_type == "system") {
            $api_commission = "10000";
            $agency_commission = round($priceFare * (4 / 100));
            $supplier_commission = $api_price - $agency_commission;
        }


        return array($api_commission, $agency_commission, $supplier_commission);
    }

    #endregion

    #region UpdateCreditAdminAgency
    public function UpdateCreditAdminAgency($InfoTicket, $RequestNumberOld)
    {

        $ModelBase = Load::library('ModelBase');
        $apiLocal = Load::library('apiLocal');
        $admin = Load::controller('admin');
        $percentPublic = functions::percentPublic();
        list($Price, $fare) = $apiLocal->get_total_ticket_price($InfoTicket['request_number']);

        $QueryDetectDirection = "SELECT id, factor_number, request_number, direction,type_app  FROM report_tb WHERE factor_number='{$InfoTicket['factor_number']}' GROUP BY request_number";
        $ResultDetectDirection = $ModelBase->select($QueryDetectDirection);
        $sqlTransaction = "SELECT * FROM transaction_tb WHERE FactorNumber='{$InfoTicket['factor_number']}'";
        $Transaction = $admin->ConectDbClient($sqlTransaction, $InfoTicket['client_id'], "Select");
        if (count($ResultDetectDirection) > 1) {
            if (strtolower($InfoTicket['flight_type']) == 'system') {
                $PriceTicketNew = $Price + ($InfoTicket['irantech_commission'] * $InfoTicket['count_id']);
//                    dar tarikh 13 ordibehesht 1404 tebgh darkhast aghaye afshar systemy ha haman meghdar total azashon kasr beshe
//                $PriceTicketNew = $Price - ($fare * $percentPublic) + ($InfoTicket['irantech_commission'] * $InfoTicket['count_id']);
//                $PriceTicketNew = $Price - (($Price - (($Price * 4573) / 100000)) * (($percentPublic))) + ($InfoTicket['irantech_commission'] * $InfoTicket['count_id']);

            } else {
                $PriceTicketNew = $Price + (IT_COMMISSION * $InfoTicket['count_id']);
            }

            $data['price'] = $PriceTicketNew + $Transaction['Price'];
            $searchReplaceArray = array(
                $RequestNumberOld => $InfoTicket['request_number'],
                'سیستمی پید اختصاصی' => ((strtolower($InfoTicket['flight_type']) == 'system') ? 'سیستمی اشتراکی' : 'چارتری'),
            );
            $data['Comment'] = str_replace(
                array_keys($searchReplaceArray),
                array_values($searchReplaceArray),
                $Transaction['Comment']
            );
        } else {

            if (strtolower($InfoTicket['flight_type']) == 'system') {
//                $data['Price'] = $Price - (($Price - (($Price * 4573) / 100000)) * (($percentPublic))) + ($InfoTicket['irantech_commission'] * $InfoTicket['count_id']);
                $data['Price'] = $Price - ($fare * $percentPublic) + ($InfoTicket['irantech_commission'] * $InfoTicket['count_id']);
            } else {
                $data['Price'] = $Price + ($InfoTicket['irantech_commission'] * $InfoTicket['count_id']);
            }
            $searchReplaceArray = array(
                $RequestNumberOld => $InfoTicket['request_number'],
                'سیستمی پید اختصاصی' => ((strtolower($InfoTicket['flight_type']) == 'system') ? 'سیستمی اشتراکی' : 'چارتری'),
            );
            $data['Comment'] = str_replace(
                array_keys($searchReplaceArray),
                array_values($searchReplaceArray),
                $Transaction['Comment']
            );


        }

        $condition = " FactorNumber = '{$InfoTicket['factor_number']}' ";
        $admin->ConectDbClient('', $InfoTicket['client_id'], "Update", $data, "transaction_tb", $condition);

        //for admin panel , transaction table
        $data['clientID'] = $InfoTicket['client_id'];
        $this->transactions->updateTransaction($data, $condition);
    }
    #endregion

    #region Decrease Agency

    public function DecreaseAgency($InfoTicket, $RequestNumberOfTicketOld)
    {
        $admin = Load::controller('admin');
        $data['credit'] = functions::CalculateDiscount($InfoTicket['request_number'], 'yes');
        $data['requestNumber'] = $InfoTicket['request_number'];

        $condition = " requestNumber = '{$RequestNumberOfTicketOld}' ";
        $admin->ConectDbClient('', $InfoTicket['client_id'], "Update", $data, "credit_detail_tb", $condition);
    }
    #endregion

}