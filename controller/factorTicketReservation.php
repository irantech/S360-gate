<?php
/**
 * Class factorTicketReservation
 * @property factorTicketReservation $factorTicketReservation
 */



class factorTicketReservation
{
    public $adultArr = array();
    public $IsLogin ;
    public $count_basket ;
    public $city ;
    public $numberNight ;
    public $startDate ;
    public $totalPrice ;
    public $idMember ;
    public $factorNumber ;


    public function __construct()
    {
        $this->IsLogin = Session::IsLogin();
    }


    public function statusRefresh(){
        /*session_start();
        if(isset($_POST['StatusRefresh']) AND $_POST['StatusRefresh'] == $_SESSION['StatusRefresh']){
            // can't submit refresh
            unset($_SESSION['StatusRefresh']);
            $count = $_POST['CountAdult'] . '-' . $_POST['CountChild'] .'-'. $_POST['CountInfo'];
            $DateFlight = str_replace("/", "-", $_POST['DateFlight']);
            header('Location: ' . ROOT_ADDRESS_WITHOUT_LANG . '/local/1/' . $_POST['Origin'] . '-' . $_POST['Destination'] . '/' . $DateFlight . '/Y/' . $count );
            exit();
        }
        else{
            $_SESSION['StatusRefresh'] = $_POST['StatusRefresh'];
        }*/
    }


    public function registerPassengersReservationTicket()
    {

        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $passengerController = Load::controller('passengers');

        $factor_number = $_POST['FactorNumber'];
        if (isset($_POST['ZoneFlight']) && $_POST['ZoneFlight']=='Local'){
            $isInternal = '1';
        }else {
            $isInternal = '0';
        }

        if(ISCURRENCY && $_POST['CurrencyCode'] > 0){
            $Currency = Load::controller('currencyEquivalent');
            $InfoCurrency = $Currency->InfoCurrency($_POST['CurrencyCode']);
        }

        $objResultTicket = Load::controller('resultReservationTicket');
        $ticket = $objResultTicket->infoTicket();


        $cost = 'cost_one_way';
        $count_flight = 1 ;
        if (isset($_POST['flight_id_return']) && !empty( $_POST['flight_id_return']))
        {
            $cost = 'cost_two_way';
            $count_flight = 2 ;
        }


        for($j=0; $j<$count_flight; $j++){

            if ($j==0){
                $direction = 'dept';
                $requestNumber = $objResultTicket->createRequestNumber();
            }else{
                $direction = 'return';
                $requestNumber = $objResultTicket->createRequestNumber();
            }

            $i = 1;
            while (isset($_POST["genderA" . $i])) {

                $this->adultArr[$i]['gender'] = $_POST["genderA" . $i];
                $this->adultArr[$i]['name_en'] = $_POST["nameEnA" . $i];
                $this->adultArr[$i]['family_en'] = $_POST["familyEnA" . $i];
                $this->adultArr[$i]['name'] = $_POST["nameFaA" . $i];
                $this->adultArr[$i]['family'] = $_POST["familyFaA" . $i];
                if ($_POST["passengerNationalityA" . $i] == '0') {
                    $this->adultArr[$i]['birthday_fa'] = $_POST["birthdayA" . $i];
                } else{
                    $this->adultArr[$i]['birthday'] = $_POST["birthdayEnA" . $i];
                }
                $this->adultArr[$i]['NationalCode'] = $_POST["NationalCodeA" . $i];
                $this->adultArr[$i]['fk_members_tb_id'] = $_POST["IdMember"];
                $this->adultArr[$i]['passportCountry'] = !empty($_POST["passportCountryA" . $i]) ? $_POST["passportCountryA" . $i] : 'IRN';
                $this->adultArr[$i]['passportNumber'] = $_POST["passportNumberA" . $i];
                $this->adultArr[$i]['passportExpire'] = $_POST["passportExpireA" . $i];

                $this->adultArr[$i]['Mobile_buyer'] = isset($_POST["Mobile"]) ? $_POST["Mobile"] : '';
                $this->adultArr[$i]['Email_buyer'] = isset($_POST["Email"]) ? $_POST["Email"] : '';

                $this->adultArr[$i]['currency_code'] = $_POST['CurrencyCode'];
                $this->adultArr[$i]['currency_equivalent'] = !empty($InfoCurrency) ? $InfoCurrency['EqAmount'] : '0';

                if ($this->IsLogin) {
                    $passengerAddArray = array(
                        'passengerName' => $this->adultArr[$i]['name'],
                        'passengerNameEn' => $this->adultArr[$i]['name_en'],
                        'passengerFamily' => $this->adultArr[$i]['family'],
                        'passengerFamilyEn' => $this->adultArr[$i]['family_en'],
                        'passengerGender' => $this->adultArr[$i]['gender'],
                        'passengerBirthday' => $this->adultArr[$i]['birthday_fa'],
                        'passengerNationalCode' => $this->adultArr[$i]['NationalCode'],
                        'passengerBirthdayEn' => $this->adultArr[$i]['birthday'],
                        'passengerPassportCountry' => $this->adultArr[$i]['passportCountry'],
                        'passengerPassportNumber' => $this->adultArr[$i]['passportNumber'],
                        'passengerPassportExpire' => $this->adultArr[$i]['passportExpire'],
                        'memberID' => $this->adultArr[$i]['fk_members_tb_id'],
                        'passengerNationality' => $_POST["passengerNationalityA" . $i]
                    );
                    $passengerController->insert($passengerAddArray);
                }

                $this->adultArr[$i]['FactorNumber'] = $factor_number;

                $this->FirstBookReservation($this->adultArr[$i], $_POST["IdMember"], $ticket[$direction], $direction, $requestNumber, $isInternal, $_POST['typeApplication']);

                if ($_POST["passengerNationalityA" . $i] == '0') {
                    $sql_check_book = " SELECT * FROM book_local_tb WHERE factor_number ='{$factor_number}' AND member_id='{$_POST['IdMember']}' "
                        . " AND passenger_national_code='{$_POST["NationalCodeA" . $i]}'"
                        . " AND passenger_gender='{$_POST['genderA' . $i]}' ";
                } else {
                    $sql_check_book = " SELECT * FROM book_local_tb WHERE factor_number ='{$factor_number}' AND member_id='{$_POST['IdMember']}' "
                        . " AND passportNumber='{$_POST["passportNumberA" . $i]}'"
                        . " AND passenger_gender='{$_POST['genderA' . $i]}' ";
                }

                $this->AdtInfo[$i] = $Model->load($sql_check_book);

                $i++;
            }

            $this->numberAdult = $i - 1;
            $i = 1;
            while (isset($_POST["genderC" . $i])) {
                $this->childtArr[$i]['gender'] = $_POST["genderC" . $i];
                $this->childtArr[$i]['name'] = $_POST["nameFaC" . $i];
                $this->childtArr[$i]['family'] = $_POST["familyFaC" . $i];
                $this->childtArr[$i]['name_en'] = $_POST["nameEnC" . $i];
                $this->childtArr[$i]['family_en'] = $_POST["familyEnC" . $i];
                if ($_POST["passengerNationalityC" . $i] == '0') {
                    $this->childtArr[$i]['birthday_fa'] = $_POST["birthdayC" . $i];
                } else{
                    $this->childtArr[$i]['birthday'] = $_POST["birthdayEnC" . $i];
                }
                $this->childtArr[$i]['NationalCode'] = $_POST["NationalCodeC" . $i];
                $this->childtArr[$i]['fk_members_tb_id'] = $_POST["IdMember"];
                $this->childtArr[$i]['passportCountry'] = !empty($_POST["passportCountryC" . $i]) ? $_POST["passportCountryC" . $i] : 'IRN';
                $this->childtArr[$i]['passportNumber'] = $_POST["passportNumberC" . $i];
                $this->childtArr[$i]['passportExpire'] = $_POST["passportExpireC" . $i];

                $this->childtArr[$i]['Mobile_buyer'] = isset($_POST["Mobile"]) ? $_POST["Mobile"] : '';
                $this->childtArr[$i]['Email_buyer'] = isset($_POST["Email"]) ? $_POST["Email"] : '';

                $this->childtArr[$i]['currency_code'] = $_POST['CurrencyCode'];
                $this->childtArr[$i]['currency_equivalent'] = !empty($InfoCurrency) ? $InfoCurrency['EqAmount'] : '0';

                if ($this->IsLogin) {
                    $passengerAddArray = array(
                        'passengerName' => $this->childtArr[$i]['name'],
                        'passengerNameEn' => $this->childtArr[$i]['name_en'],
                        'passengerFamily' => $this->childtArr[$i]['family'],
                        'passengerFamilyEn' => $this->childtArr[$i]['family_en'],
                        'passengerGender' => $this->childtArr[$i]['gender'],
                        'passengerBirthday' => $this->childtArr[$i]['birthday_fa'],
                        'passengerNationalCode' => $this->childtArr[$i]['NationalCode'],
                        'passengerBirthdayEn' => $this->childtArr[$i]['birthday'],
                        'passengerPassportCountry' => $this->childtArr[$i]['passportCountry'],
                        'passengerPassportNumber' => $this->childtArr[$i]['passportNumber'],
                        'passengerPassportExpire' => $this->childtArr[$i]['passportExpire'],
                        'memberID' => $this->childtArr[$i]['fk_members_tb_id'],
                        'passengerNationality' => $_POST["passengerNationalityC" . $i]
                    );
                    $passengerController->insert($passengerAddArray);
                }
                $this->childtArr[$i]['FactorNumber'] = $factor_number;

                $this->FirstBookReservation($this->childtArr[$i], $_POST["IdMember"], $ticket[$direction], $direction, $requestNumber, $isInternal);

                if ($_POST["passengerNationalityC" . $i] == '0') {
                    $sql_check_book = " SELECT * FROM book_local_tb WHERE factor_number ='{$factor_number}' AND member_id='{$_POST['IdMember']}' "
                        . "AND passenger_national_code='{$_POST["NationalCodeC" . $i]}'"
                        . " AND passenger_gender='{$_POST['genderC' . $i]}' ";
                } else {
                    $sql_check_book = " SELECT * FROM book_local_tb WHERE factor_number ='{$factor_number}' AND member_id='{$_POST['IdMember']}' "
                        . "AND passportNumber='{$_POST["passportNumberC" . $i]}'"
                        . " AND passenger_gender='{$_POST['genderC' . $i]}' ";
                }
                $this->ChdInfo[$i] = $Model->load($sql_check_book);

                $i++;
            }


            $i = 1;
            while (isset($_POST["genderI" . $i])) {
                $this->infantArr[$i]['gender'] = $_POST["genderI" . $i];
                $this->infantArr[$i]['name'] = $_POST["nameFaI" . $i];
                $this->infantArr[$i]['family'] = $_POST["familyFaI" . $i];
                $this->infantArr[$i]['name_en'] = $_POST["nameEnI" . $i];
                $this->infantArr[$i]['family_en'] = $_POST["familyEnI" . $i];
                if ($_POST["passengerNationalityI" . $i] == '0') {
                    $this->infantArr[$i]['birthday_fa'] = $_POST["birthdayI" . $i];
                } else{
                    $this->infantArr[$i]['birthday'] = $_POST["birthdayEnI" . $i];
                }
                $this->infantArr[$i]['NationalCode'] = $_POST["NationalCodeI" . $i];
                $this->infantArr[$i]['fk_members_tb_id'] = $_POST["IdMember"];
                $this->infantArr[$i]['passportCountry'] = !empty($_POST["passportCountryI" . $i]) ? $_POST["passportCountryI" . $i] : 'IRN';
                $this->infantArr[$i]['passportNumber'] = $_POST["passportNumberI" . $i];
                $this->infantArr[$i]['passportExpire'] = $_POST["passportExpireI" . $i];

                $this->infantArr[$i]['Mobile_buyer'] = isset($_POST["Mobile"]) ? $_POST["Mobile"] : '';
                $this->infantArr[$i]['Email_buyer'] = isset($_POST["Email"]) ? $_POST["Email"] : '';

                $this->infantArr[$i]['currency_code'] = $_POST['CurrencyCode'];
                $this->infantArr[$i]['currency_equivalent'] = !empty($InfoCurrency) ? $InfoCurrency['EqAmount'] : '0';


                if ($this->IsLogin) {
                    $passengerAddArray = array(
                        'passengerName' => $this->infantArr[$i]['name'],
                        'passengerNameEn' => $this->infantArr[$i]['name_en'],
                        'passengerFamily' => $this->infantArr[$i]['family'],
                        'passengerFamilyEn' => $this->infantArr[$i]['family_en'],
                        'passengerGender' => $this->infantArr[$i]['gender'],
                        'passengerBirthday' => $this->infantArr[$i]['birthday_fa'],
                        'passengerNationalCode' => $this->infantArr[$i]['NationalCode'],
                        'passengerBirthdayEn' => $this->infantArr[$i]['birthday'],
                        'passengerPassportCountry' => $this->infantArr[$i]['passportCountry'],
                        'passengerPassportNumber' => $this->infantArr[$i]['passportNumber'],
                        'passengerPassportExpire' => $this->infantArr[$i]['passportExpire'],
                        'memberID' => $this->infantArr[$i]['fk_members_tb_id'],
                        'passengerNationality' => $_POST["passengerNationalityI" . $i]
                    );
                    $passengerController->insert($passengerAddArray);
                }
                $this->infantArr[$i]['FactorNumber'] = $factor_number;

                $this->FirstBookReservation($this->infantArr[$i], $_POST["IdMember"], $ticket[$direction], $direction, $requestNumber, $isInternal);

                if($_POST["passengerNationalityI" . $i] == '0'){
                    $sql_check_book = " SELECT * FROM book_local_tb WHERE factor_number ='{$factor_number}' AND member_id='{$_POST['IdMember']}' "
                        . "AND passenger_national_code='{$_POST["NationalCodeI" . $i]}'"
                        . " AND passenger_gender='{$_POST['genderI' . $i]}' ";
                } else {
                    $sql_check_book = " SELECT * FROM book_local_tb WHERE factor_number ='{$factor_number}' AND member_id='{$_POST['IdMember']}' "
                        . "AND passportNumber='{$_POST["passportNumberI" . $i]}'"
                        . " AND passenger_gender='{$_POST['genderI' . $i]}' ";
                }


                $this->InfInfo[$i] = $Model->load($sql_check_book);

                $i++;
            }

            $sql = " SELECT 
                      SUM(adt_price) as adt_price, SUM(chd_price) as chd_price, SUM(inf_price) as inf_price,
                      SUM(discount_adt_price) as discount_adt_price, SUM(discount_chd_price) as discount_chd_price,
                      SUM(discount_inf_price) as discount_inf_price, percent_discount
                  FROM book_local_tb WHERE factor_number ='{$factor_number}' AND member_id='{$_POST['IdMember']}' ";
            $resultTotal = $Model->load($sql);

            if ($resultTotal['percent_discount']>0){
                $totalPrice = $resultTotal['discount_adt_price'] + $resultTotal['discount_chd_price'] + $resultTotal['discount_inf_price'];
            }else {
                $totalPrice = $resultTotal['adt_price'] + $resultTotal['chd_price'] + $resultTotal['inf_price'];
            }

            $dataPrice['total_price'] = $totalPrice;

            $Condition = "factor_number='{$factor_number}' ";
            $Model->setTable("book_local_tb");
            $Model->update($dataPrice, $Condition);

            $ModelBase->setTable("report_tb");
            $ModelBase->update($dataPrice, $Condition);

            $this->totalPrice = $totalPrice;
            $this->factorNumber = $factor_number;
            $this->idMember = $_POST["IdMember"];





        }


    }

    public function FirstBookReservation($passenger, $idMember, $ticket, $direction, $requestNumber, $isInternal, $typeApplication)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $condition = !empty($passenger['NationalCode']) ? "passenger_national_code='{$passenger['NationalCode']}' " : "passportNumber='{$passenger['passportNumber']}'";
        $sql_check_book = " SELECT * FROM book_local_tb WHERE factor_number ='{$passenger['FactorNumber']}' AND member_id='{$idMember}' AND $condition"
            . " AND passenger_gender='{$passenger['gender']}' AND direction='{$direction}' ";
        $book_check = $Model->load($sql_check_book);

        if (empty($book_check)) {
            if (!empty($passenger['birthday_fa'])) {

                $explode_br_fa = explode('-', $passenger['birthday_fa']);

                $date_miladi = dateTimeSetting::jalali_to_gregorian($explode_br_fa[0], $explode_br_fa[1], $explode_br_fa[2], '-');
            }

            $d['passenger_gender'] = $passenger['gender'];
            $d['passenger_name'] = $passenger['name'];
            $d['passenger_family'] = $passenger['family'];
            $d['passenger_name_en'] = $passenger['name_en'];
            $d['passenger_family_en'] = $passenger['family_en'];
            $d['passenger_birthday'] = $passenger['birthday_fa'];
            $d['passportCountry'] = $passenger['passportCountry'];
            $d['passportNumber'] = $passenger['passportNumber'];
            $d['passportExpire'] = $passenger['passportExpire'];
            $d['mobile_buyer'] = $passenger['Mobile_buyer'];
            $d['email_buyer'] = $passenger['Email_buyer'];

            if (isset($passenger['birthday'])) {
                $d['passenger_birthday_en'] = $passenger['birthday'];
            }
            $d['passenger_national_code'] = !empty($passenger['NationalCode']) ? $passenger['NationalCode'] : '0000000000';
            $passenger_age = $this->type_passengers(isset($passenger['birthday']) ? $passenger['birthday'] : $date_miladi);

            $sql = " SELECT * FROM members_tb WHERE id='{$idMember}'";
            $user = $Model->load($sql);

            $d['member_id'] = $user['id'];
            $d['member_name'] = $user['name'] . ' ' . $user['family'];
            $d['member_email'] = $user['email'];
            $d['member_mobile'] = $user['mobile'];
            $d['member_phone'] = $user['telephone'];


            if ($user['fk_agency_id'] > 0) {
                $sql = " SELECT * FROM agency_tb WHERE id='{$user['fk_agency_id']}'";
                $agency = $Model->load($sql);
            }
            $d['agency_id'] = $agency['id'];
            $d['agency_name'] = $agency['name_fa'];
            $d['agency_accountant'] = $agency['accountant'];
            $d['agency_manager'] = $agency['manager'];
            $d['agency_mobile'] = $agency['mobile'];

            $d['airline_iata'] = $ticket['Airline'];
            $d['airline_name'] = $ticket['AirlineName'];
            $d['origin_city'] = $ticket['OriginCity'];
            $d['desti_city'] = $ticket['DestinationCity'];
            $d['origin_airport_iata'] = $ticket['OriginAirport'];
            $d['desti_airport_iata'] = $ticket['DestinationAirport'];
            $d['seat_class'] = $ticket['SeatClass'];
            $d['date_flight'] = functions::ConvertToMiladi(str_replace("/", "-", $ticket['Date']));
            $d['time_flight'] = $ticket['OriginTime'];
            $d['flight_type'] = 'charterPrivate';
            $d['flight_number'] = $ticket['FlightNumber'];
            $d['cabin_type'] = $ticket['CabinType'];
            $d['passenger_age'] = $passenger_age;

            if ($passenger_age=='Adt'){

                $d['fk_id_ticket'] = $ticket['fk_id_ticket_Adt'];
                $d['adt_price'] = $ticket['AdtPrice'];
                $d['chd_price'] = '0';
                $d['inf_price'] = '0';
                $d['discount_adt_price'] = $ticket['PriceWithDiscount'];
                $d['discount_chd_price'] = '0';
                $d['discount_inf_price'] = '0';
                $d['adt_qty'] = '1';


            }else if ($passenger_age=='Chd'){

                $d['fk_id_ticket'] = $ticket['fk_id_ticket_Chd'];
                $d['adt_price'] = '0';
                $d['chd_price'] = $ticket['ChdPrice'];
                $d['inf_price'] = '0';
                $d['discount_adt_price'] = '0';
                $d['discount_chd_price'] = $ticket['ChdPriceWithDiscount'];
                $d['discount_inf_price'] = '0';
                $d['chd_qty'] = '1';


            }else if ($passenger_age=='Inf'){

                $d['fk_id_ticket'] = $ticket['fk_id_ticket_Inf'];
                $d['adt_price'] = '0';
                $d['chd_price'] = '0';
                $d['inf_price'] = $ticket['InfPrice'];
                $d['discount_adt_price'] = '0';
                $d['discount_chd_price'] = '0';
                $d['discount_inf_price'] = $ticket['InfPriceWithDiscount'];
                $d['inf_qty'] = '1';

            }
            $d['percent_discount'] = $ticket['AdtDiscount'];
            $d['factor_number'] = $passenger['FactorNumber'];
            $d['request_number'] = $requestNumber;
            $d['creation_date'] = date('Y-m-d');
            $d['creation_date_int'] = time();
            $d['type_app'] = $typeApplication;
            $d['api_id'] = "99";
            $d['direction'] = $direction;
            $d['IsInternal'] = $isInternal;
            $TypeZone = ($d['IsInternal'] == '1') ? 'Local' : 'Portal';
            $d['serviceTitle'] = functions::TypeService('charter', $TypeZone, 'private', '', $d['airline_iata']);
            $d['currency_code'] = $passenger['currency_code'];
            $d['currency_equivalent'] = $passenger['currency_equivalent'];




            $d['serviceTitle'] = 'TicketFlightReserveLocal';

            $objClientAuth = Load::library('clientAuth');
            $objClientAuth->ticketReservationFlightAuth();
            $sourceId = $objClientAuth->sourceId;
            //$sourceId = '7';
            $irantechCommission = Load::controller('irantechCommission');
            $it_commission = $irantechCommission->getCommission('TicketFlightReserveLocal', $sourceId);
            $d['irantech_commission'] = $it_commission;





            //echo Load::plog($d);
            $Model->setTable("book_local_tb");
            $Model->insertLocal($d);

            $d['remote_addr'] = $_SERVER['REMOTE_ADDR'];
            $d['client_id'] = CLIENT_ID;
            $ModelBase->setTable("report_tb");
            $ModelBase->insertLocal($d);
        }
    }

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


    public function getPassengersReservationTicket()
    {
        $Model = Load::library('Model');
        $factorNumber = $_POST['FactorNumber'];
        $sql = " SELECT *FROM book_local_tb WHERE factor_number='{$factorNumber}'";
        $Book = $Model->select($sql);

        foreach ($Book as $val){
            $index = (isset($val['passenger_national_code']) && $val['passenger_national_code'] != '') ? $val['passenger_national_code'] : $val['passportNumber'];
            $namePrice = strtolower($val['passenger_age']) . '_price';
            $nameDiscountPrice = 'discount_' . $namePrice;
            $result[$index][$val['direction']] = ($val[$nameDiscountPrice] > 0) ? $val[$nameDiscountPrice] : $val[$namePrice];
        }
        return $result;
    }

    public function CreditCustomer()
    {
        $Model = Load::library('Model');

        if ($this->IsLogin) {

            $SqlMember = "SELECT * FROM members_tb WHERE id='{$_SESSION["userId"]}'";
            $member = $Model->load($SqlMember);

            $agencyID = $member['fk_agency_id'];

            $sql_charge = "SELECT sum(credit) AS total_charge FROM credit_detail_tb WHERE type='increase' AND fk_agency_id='{$agencyID}'";
            $charge = $Model->load($sql_charge);
            $total_charge = $charge['total_charge'];

            $sql_buy = "SELECT sum(credit) AS total_buy FROM credit_detail_tb WHERE type='decrease' AND fk_agency_id='{$agencyID}'";
            $buy = $Model->load($sql_buy);
            $total_buy = $buy['total_buy'];

            $total_transaction = $total_charge - $total_buy;
            return $total_transaction;

        }
    }
}