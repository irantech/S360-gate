<?php

class repeatStepsPrivateTicket extends clientAuth
{
    public $StepUniqueCode = '';
    public $apiAddress = '';

    public $transactions;

    public function __construct()
    {
        if ((isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], '192.168.1.100') !== false) || (isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], 'online.1011.ir') !== false) || (isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], '1011.ir') !== false) || (isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], 'localhost') !== false)) {//local
//            $this->apiAddress = 'http://safar360.com/CoreTestDeveloper/';
            $this->apiAddress = 'http://safar360.com/CoreTestDeveloper/';
        } else {
//            $this->apiAddress = 'http://185.204.101.23/Core/';
//            $this->apiAddress = 'http://safar360.com/Core/';
            $this->apiAddress = 'http://safar360.com/Core/';
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

    public function Search($RequestNumber, $ClientId,$Type=null)
    {

        $Ticket = $this->FindTicket($RequestNumber, 'load');

        $DateEx = explode('T',$Ticket['date_flight']);
        echo "https://safarbooking.com/Cache?clear=". $Ticket['origin_airport_iata'].",". $Ticket['desti_airport_iata'].",".$DateEx[0].",".$Ticket['airline_iata'];
        echo "<br/>";
        $InfoUser = $this->InfoUser($ClientId);
        $uniqueCode = $this->UniqueCode($InfoUser['Username']);
        $this->StepUniqueCode = $uniqueCode;

       echo '<br/>'.$url = $this->apiAddress . "Flight/Search/" . $uniqueCode; 

        $d['Adult'] = (is_numeric($Ticket['adt_qty']) && !empty($Ticket['adt_qty']) && $Ticket['adt_qty'] > 0) ? $Ticket['adt_qty'] : '1';
        $d['Child'] = (is_numeric($Ticket['chd_qty']) && !empty($Ticket['chd_qty']) && $Ticket['chd_qty'] > 0) ? $Ticket['chd_qty'] : '0';
        $d['Infant'] = (is_numeric($Ticket['inf_qty']) && !empty($Ticket['inf_qty']) && $Ticket['inf_qty'] > 0) ? $Ticket['inf_qty'] : '0';
        $d['Origin'] = $Ticket['origin_airport_iata'];
        $d['Destination'] = $Ticket['desti_airport_iata'];
        $d['DepartureDate'] = functions::DateJalali($Ticket['date_flight']);
        $d['ArrivalDate'] = '';
        $d['UserName'] = $InfoUser['Username'];
        $d['IsInternal'] = true;
        $d['Page'] =  "1" ;
        $d['Count'] ="120" ;

        $JsonArray = json_encode($d);


        $searchTicket = functions::curlExecution($url, $JsonArray, 'yes');
        $ListSearchTicket = (isset($searchTicket['Flights']) && !empty($searchTicket['Flights']) ? $searchTicket['Flights'] : array());
      //  echo Load::plog ($ListSearchTicket);


        foreach ($ListSearchTicket as $key => $Ticket) {

            if($Type=='M10')
            {
                if ($Ticket['SourceId'] == '11' && $Ticket['SourceName'] == 'Source10') {
                    $TicketArrayFinal[$key] = $Ticket;
                }
            }else{
                if ($Ticket['SourceId'] == '1' && $Ticket['SourceName'] == 'Source5') {
                    $TicketArrayFinal[$key] = $Ticket;
                }
            }

        }
//        echo Load::plog ($TicketArrayFinal);

        return $TicketArrayFinal;

    }
    #endregion

    #regionRevalidateAndPreReserve
    public function RevalidateAndPreReserve($UniqueCode, $ClientId, $FlightID, $RequestNumber, $SourceId)
    {

        Load::autoload('ModelBase');
        $ModelBase = new ModelBase;

        $InfoTicket = $this->FindTicket($RequestNumber, 'select');
       echo  $url =  $this->apiAddress . "Flight/Revalidate/" . $UniqueCode;


        $InfoUser = $this->InfoUser($ClientId);
        $d['UserName'] = $InfoUser['Username'];//'kabkan-caspian';//$this->userPishro;
        $d['FlightID'] = $FlightID;
        $d['ReturnFlightID'] = '';
        $d['AdultCount'] = $InfoTicket[0]['AdultCount'];
        $d['ChildCount'] = $InfoTicket[0]['ChildCount'];
        $d['InfantCount'] = $InfoTicket[0]['InfantCount'];
        $d['SourceId'] = $SourceId;

        $data_json = json_encode($d);
        $Revalidate = functions::curlExecution($url, $data_json, 'yes');

//        echo Load::plog($Revalidate);
        error_log('try show result Request Client In Book in : ' . date('Y/m/d H:i:s') . '   Request equal in With FlightID : => ' . $UniqueCode . ': ' . $data_json . " \n" . "Response equal in With RequestNumber=>" . $UniqueCode . ":" . " " . json_encode($Revalidate, true) . " \n", 3, LOGS_DIR . 'log_repeatStepRevalidateTicket.txt');
        if (isset($Revalidate['RequestStatus']) && $Revalidate['RequestStatus'] == 'Success' && !empty($Revalidate['Result']['Flight']['FlightID']) && $Revalidate['Result']['Flight']['PassengerDatas'][0]['BasePrice'] > 0) {
            $url =  $this->apiAddress ."Flight/PreReserve/" . $Revalidate['Result']['SessionID'];

            $emptyArray = array();
            $Reserve = functions::curlExecution($url, $emptyArray, 'yes');

            if (!empty($Reserve['Result']['Request'])) {

                $TicketRequestNumber['request_number'] = $Reserve['Result']['Request']['RequestNumber'] ;
                $TicketRequestNumber['api_id'] = $Reserve['Result']['SourceId'] ;
                $TicketRequestNumber['pnr'] = '' ;
                $TicketRequestNumber['eticket_number'] = '' ;


                $Condition = "request_number='{$RequestNumber}'";
                $ModelBase->setTable('report_tb');
                $ModelBase->update($TicketRequestNumber,$Condition);

                $admin = Load::controller('admin');
                $admin->ConectDbClient('', $InfoTicket[0]['client_id'], "Update", $TicketRequestNumber, "book_local_tb", $Condition);


                $SqlCredit = "SELECT * FROM credit_detail_tb WHERE requestNumber='{$RequestNumber}'";
                $InfoDetail = $admin->ConectDbClient($SqlCredit, $InfoTicket[0]['client_id'], "Select", "", "", "");

                $SqlTransaction = "SELECT * FROM transaction_tb WHERE FactorNumber='{$InfoTicket['factor_number']}'";
                $InfoTransaction = $admin->ConectDbClient($SqlTransaction, $InfoTicket[0]['client_id'], "Select", "", "", "");


                $ConditionCreditDetail = "requestNumber='{$RequestNumber}'";
                $CreditRequestNumber['requestNumber'] = $Reserve['Result']['Request']['RequestNumber'] ;
                $CreditRequestNumber['comment'] = str_replace(trim($RequestNumber),trim($CreditRequestNumber['requestNumber']),$InfoDetail['comment']);
                $admin->ConectDbClient('', $InfoTicket[0]['client_id'], "Update", $CreditRequestNumber, "credit_detail_tb", $ConditionCreditDetail);

                $ConditionTransaction = "FactorNumber='{$InfoTransaction['FactorNumber']}'";
                $Transaction['Comment'] = str_replace(trim($RequestNumber),trim($CreditRequestNumber['requestNumber']),$InfoTransaction['Comment']);
                $admin->ConectDbClient('', $InfoTicket[0]['client_id'], "Update", $Transaction, "transaction_tb", $ConditionTransaction);

                //for admin panel , transaction table
                $Transaction['clientID'] =  $InfoTicket[0]['client_id'];
                $this->transactions->updateTransaction($Transaction, $ConditionTransaction);



                $data['RequestNumberOfReserve'] = $TicketRequestNumber['request_number'];
                $data['RequestNumberOfTicketOld'] = $RequestNumber;
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

        $Tickets = $this->FindTicket($Param['RequestNumber'], 'select');

        if (!empty($Tickets)) {
            $data['securityCode'] = '';
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
                $data['Books'][$key]['Nationality'] = !empty($rec['passportCountry']) && $rec['passportCountry'] != 'IRN' ? $rec['passportCountry'] : "IRN";
                $data['Books'][$key]['AreaCode'] = "21";
                $data['Books'][$key]['CountryCode'] = "98";
                $data['Books'][$key]['PhoneNumber'] = !empty($rec['mobile_buyer']) ? $rec['mobile_buyer'] : "{$rec['member_mobile']}";
                $data['Books'][$key]['Email'] = 'info@iran-tech.com';//(!empty($rec['email_buyer'])) ? $rec['email_buyer'] : $rec['member_email'];

            }


            $url = $this->apiAddress . "Flight/Book/{$Param['RequestNumber']}";
            $info_json_passengers = json_encode($data);
            $book = functions::curlExecution($url, $info_json_passengers, 'yes');
            error_log('try show result Request Client In Book in : ' . date('Y/m/d H:i:s') . '   Request equal in With RequestNumber : => ' . $Param['RequestNumber'] . ': ' . $info_json_passengers . " \n" . "Response equal in With RequestNumber=>" . $Param['RequestNumber']  . ":" . " " . json_encode($book, true) . " \n", 3, LOGS_DIR . 'log_repeatStepBookTicket.txt');

                if (!empty($book) && isset($book['Result']['ProviderStatus']) && $book['Result']['ProviderStatus'] != "Error") {

                    $url = $this->apiAddress . "Flight/Reserve/{$Param['RequestNumber']}";
                    $emptyArray = array();
                    functions::curlExecution($url, $emptyArray, 'yes');
                    $data['message'] = 'اطلاعات ارسال شد';

                }else{
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
        (SELECT SUM(inf_qty) FROM report_tb WHERE request_number='{$RequestNumber}') AS InfantCount
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


}