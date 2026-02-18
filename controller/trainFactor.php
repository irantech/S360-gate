<?php
/**
 * Class trainFactor
 * @property trainFactor $trainFactor
 */
//if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}

class trainFactor extends trainCore
{
    public $passengerArr = array(); // Specifications of adult
    public $passengerArr1 = array(); // Specifications of adult
    public $time_remmaining;
    public $IdMember;
    public $IsLogin;
    public $CounterId;
    public $Source_ID;
    public $serviceTitle = 'TrainApi';
    public $ticket_number;
    public $ticket_number_return;
    public $totalPrice = 0;
    public $deptAdultPrice = 0;
    public $returnAdultPrice = 0;
    public $factorNumber;
    public $ServiceCode;
    public $UniqueId;
    public $serviceSessionId;

    public function __construct()
    {
//        echo Load::plog($_POST); die();
        $this->IsLogin = Session::IsLogin();
        if (isset($_POST['IdMember'])) {
            $this->IdMember = $_POST['IdMember'];
        }
//        $this->factor_number =$_POST['factorNumber'];

        parent::__construct();


//        $this->serviceTitle = parent::serviceTypeCheck($_POST['source_name']);
    }

    public function registerPassengersTrain($ticketnumber, $InfoTrain, $type)
    {

    
        if($ticketnumber == null) {
            return false ;
        }

        $is_login = Session::IsLogin();
        $UserId = ($is_login) ? $_SESSION['userId'] : $_SESSION['userCostumer'];
        $model = Load::library('Model');
        /** @var ModelBase $modelBase */
        $modelBase = Load::library('ModelBase');
        $SqlMember = "SELECT * FROM members_tb WHERE id='{$UserId}'";
        $member = $model->load($SqlMember);

         $SqlAgency = "SELECT * FROM agency_tb WHERE id='{$member['fk_agency_id']}'";

        $agency_info = $model->load($SqlAgency);
        /** @var bookTrainModel $book_model */
        $book_model = Load::getModel('bookTrainModel');
        $this->ServiceCode = $InfoTrain['ServiceCode'];
        $this->UniqueId = $InfoTrain['UniqueId'];
        $this->serviceSessionId = $InfoTrain['ServiceSessionId'];
        if ($type == 'ONEWAY') {
            $this->ticket_number = $ticketnumber;
        } else {
            $this->ticket_number_return = $ticketnumber;
        }
        $passenger_count = intval($InfoTrain['Adult'] + $InfoTrain['Child'] + $InfoTrain['Infant']);
//        $sql = "SELECT * FROM book_train_tb WHERE TicketNumber='{$this->ticket_number}' AND TicketNumber <> ''";
//
//        $existFactorNumber = $this->Model->load($sql);
        $existFactorNumber = $book_model->get()->where('TicketNumber', $this->ticket_number)->where('TicketNumber', '', '<>')->find();

        if (empty($existFactorNumber)) {
            $this->factorNumber = substr(time(), 0, 5) . mt_rand(000, 999) . substr(time(), 5, 10);
        } else {
            $this->factorNumber = $existFactorNumber['factor_number'];
        }




        /** @var passengers $passengerController */
        $passengerController = Load::controller('passengers');
    /*    $checkSubAgency = functions::checkExistSubAgency();
        if ($member['fk_agency_id'] > 0 || $checkSubAgency) {
            $agencyId = ($checkSubAgency) ? SUB_AGENCY_ID : $member['fk_agency_id'];
            $sql = " SELECT * FROM agency_tb WHERE id='{$agencyId}'";
            $agency = $model->load($sql);
        }*/

        $irantechCommission = Load::controller('irantechCommission');
        $it_commission = $irantechCommission->getCommission('Train', '14');
        $is_set_adult_price = false ;
        $is_set_adult_return_price = false ;


        if (isset($_POST["nameFaA1"]) || isset($_POST["nameEnA1"])) {

            $this->passengerArr = array();
            for ($i = 1; $i <= $InfoTrain['Adult']; $i++) {
              
                $this->passengerArr['passenger_age'] = 'Adt';
                $this->passengerArr['passenger_gender'] = $_POST["genderA" . $i];
                $this->passengerArr['passenger_name_en'] = $_POST["nameEnA" . $i];
                $this->passengerArr['passenger_family_en'] = $_POST["familyEnA" . $i];
                $this->passengerArr['passenger_birthday_en'] = isset($_POST["birthdayEnA$i"]) ? $_POST["birthdayEnA$i"] : functions::ConvertToMiladi($_POST["birthdayA$i"],'-');
                $this->passengerArr['passenger_birthday'] =  isset($_POST["birthdayA$i"]) ? $_POST["birthdayA$i"] : functions::ConvertToJalali($_POST["birthdayEnA" . $i]);
                $this->passengerArr['passenger_national_code'] = isset( $_POST["NationalCodeA" . $i]) ?  $_POST["NationalCodeA" . $i] : '0000000000' ;
                $this->passengerArr['passportCountry'] = $_POST["passportCountryA" . $i];
                $this->passengerArr['passportNumber'] = $_POST["passportNumberA" . $i];
                $this->passengerArr['passportExpire'] = $_POST["passportExpireA" . $i];
                $this->passengerArr['passenger_name'] = isset( $_POST["nameFaA" . $i]) ?  $_POST["nameFaA" . $i] : '';
                $this->passengerArr['passenger_family'] = $_POST["familyFaA" . $i];
                $this->passengerArr['discount_inf_price'] = ($type == 'ONEWAY' ? isset($_POST["costOffA" . $i]) ? $_POST["costOffA" . $i] : 0 : isset($_POST["costOffReturnA" . $i])? $_POST["costOffReturnA" . $i]:0);
                $this->passengerArr['percent_discount'] = ($type == 'ONEWAY' ? isset($_POST["percentA" . $i]) ? $_POST["percentA" . $i] : 0 : isset($_POST["percentReturnA" . $i])? $_POST["percentReturnA" . $i]:0);
                $this->passengerArr['member_id'] = $UserId;
                $this->passengerArr['member_name'] = $member['name'] . ' ' . $member['family'];
                $this->passengerArr['member_mobile'] = $member['mobile'];
                $this->passengerArr['member_email'] = $member['email'];
                $this->passengerArr['mobile_buyer'] = $_POST['Mobile_buyer'];
                $this->passengerArr['email_buyer'] = $_POST['Email'];
                $this->passengerArr['agency_id'] = !empty($agency_info) ? $agency_info['id']: 0;
                $this->passengerArr['agency_name'] =  !empty($agency_info) ? $agency_info['name_fa']:'';
                $this->passengerArr['agency_accountant'] = !empty($agency_info) ? $agency_info['accountant'] : '';
                $this->passengerArr['agency_manager'] = !empty($agency_info) ? $agency_info['manager'] : '';
                $this->passengerArr['agency_mobile'] = !empty($agency_info) ? $agency_info['phone'] : '';
                $this->passengerArr['TicketNumber'] = $ticketnumber;
                $this->passengerArr['CompanyName'] = $InfoTrain["CompanyName"];
                $this->passengerArr['Departure_City'] = $InfoTrain["Departure_City"];
                $this->passengerArr['Arrival_City'] = $InfoTrain["Arrival_City"];
                $this->passengerArr['Dep_Code'] = $InfoTrain["Dep_Code"];
                $this->passengerArr['Arr_Code'] = $InfoTrain["Arr_Code"];
                $this->passengerArr['WagonName'] = $InfoTrain["WagonName"];
                $this->passengerArr['WagonType'] = $InfoTrain["WagonType"];
                $this->passengerArr['TrainNumber'] = $InfoTrain["TrainNumber"];
                $this->passengerArr['MoveDate'] = $InfoTrain["MoveDate"];
                $this->passengerArr['ExitDate'] = $InfoTrain["ExitDate"];
                $this->passengerArr['ExitTime'] = $InfoTrain["ExitTime"];
                $this->passengerArr['sex_code'] = $InfoTrain["PassengerNum"];
                $this->passengerArr['TimeOfArrival'] = $InfoTrain["TimeOfArrival"];
                if($_POST["passengerNationalityA" . $i] == 0){
                    if($type == 'ONEWAY') {
                       $price_final_cost = $_POST["priceAdultA"] > 0 ? $_POST["priceAdultA"] : '' ;
                       if(!$is_set_adult_price){
                           $this->deptAdultPrice = $price_final_cost;
                           $is_set_adult_price = true;
                       }
                    } else{
                       $price_final_cost = $_POST["priceAdultReturnA"] > 0 ? $_POST["priceAdultReturnA"] : ''   ;
                        if(!$is_set_adult_return_price){
                            $this->returnAdultPrice = $price_final_cost;
                            $is_set_adult_return_price = true;
                        }
                    }
                }  else{
                   if($type == 'ONEWAY') {
                        $price_final_cost = $_POST["nonIranian"] > 0 ? $_POST["nonIranian"] : '' ;
                       if(!$is_set_adult_price){
                           $this->deptAdultPrice = $price_final_cost;
                           $is_set_adult_price = true;
                       }

                   }else{
                        $price_final_cost = $_POST["priceNoneIranianReturn"] > 0 ? $_POST["priceNoneIranianReturn"] : ''   ;
                       if(!$is_set_adult_return_price){
                           $this->returnAdultPrice = $price_final_cost;
                           $is_set_adult_return_price = true;
                       }
                   }
                }
                $this->passengerArr['FullPrice'] = $price_final_cost;
                $this->passengerArr['Cost'] =  $price_final_cost;
                $this->passengerArr['CompartmentCapicity'] = $InfoTrain["CompartmentCapicity"];
                $this->passengerArr['IsCompartment'] = 1;
                $this->passengerArr['CircularNumberSerial'] = $InfoTrain["CircularNumberSerial"];
                $this->passengerArr['Adult'] = 1;
                $this->passengerArr['Child'] = 0;
                $this->passengerArr['Infant'] = 0;
                $this->passengerArr['ServiceCode'] = $_POST["ServiceCode"];
                $this->passengerArr['UniqueId'] = $this->UniqueId;
                $this->passengerArr['factor_number'] = $this->factorNumber;
                $this->passengerArr['irantech_commission'] = $it_commission;
                $this->passengerArr['creation_date'] = date('Y-m-d H:i:s');
                $this->passengerArr['creation_date_int'] = time();
                $this->passengerArr['Route_Type'] = ($type == 'ONEWAY') ? '1' : '2';
                $this->passengerArr['requestNumber'] = ($type == 'ONEWAY') ? $_POST['request_number_dept'] : $_POST['request_number_return'];
                $this->passengerArr['is_specific'] = (($type == 'ONEWAY') && isset($_POST['is_specific_dept']) && trim($_POST['is_specific_dept']) == 'yes') ? 'yes' : 'no';
                $this->passengerArr['serviceTitle'] = (($type == 'ONEWAY') && isset($_POST['is_specific_dept']) && trim($_POST['is_specific_dept']) == 'yes') ? 'PrivateTrain' : 'Train';
                $this->passengerArr['is_registered'] = '0';
                $this->passengerArr['extra_chair'] = 0;

                if (isset($_POST["serviceA" . $i]) && $_POST["serviceA" . $i] != '' && $type == 'ONEWAY') {
                    $service = explode('@@', $_POST["serviceA" . $i]);
                    
                    $this->passengerArr['Service'] = $service[0].'-'.$service[1];
                    $this->passengerArr['service_price'] = $service[1] ;
                    $this->passengerArr['ServiceTypeCode'] = $service[2];
                }
                if (isset($_POST["freeA" . $i]) && $_POST["freeA" . $i] != '' && $type == 'ONEWAY') {
                    $service = explode('@@', $_POST["freeA" . $i]);
                    $this->passengerArr['free_service'] = $service[0];
                    $this->passengerArr['free_service_code'] = $service[1];
                }
                if ($type == 'TOWEWAY' ) {
                    if ($_POST["serviceReturnA" . $i] !='') {
                        $service = explode('@@', $_POST["serviceReturnA" . $i]);
                        $this->passengerArr['Service'] = $service[0].'-'.$service[1];
                        $this->passengerArr['service_price'] = $service[1] ;
                        $this->passengerArr['ServiceTypeCode'] = $service[2];;
                    }
                    if ($_POST["freeReturnA" . $i] !='') {
                        $service = explode('@@', $_POST["freeReturnA" . $i]);
                        $this->passengerArr['free_service'] = $service[0];
                        $this->passengerArr['free_service_code'] = $service[1];
                    }
                    $this->passengerArr['is_specific'] = (isset($_POST['is_specific_return']) && trim($_POST['is_specific_return']) == 'yes') ? 'yes' : 'no';
                    $this->passengerArr['serviceTitle'] = (isset($_POST['is_specific_return']) && trim($_POST['is_specific_return']) == 'yes') ? 'PrivateTrain' : 'Train';
                }

                if ($is_login) {
                    $passengerAddArray = array(
                        'passengerName' => $this->passengerArr['passenger_name'],
                        'passengerNameEn' => $this->passengerArr['passenger_name_en'],
                        'passengerFamily' => $this->passengerArr['passenger_family'],
                        'passengerFamilyEn' => $this->passengerArr['passenger_family_en'],
                        'passengerGender' => $this->passengerArr['passenger_gender'],
                        'passengerBirthday' => $this->passengerArr['passenger_birthday'],
                        'passengerNationalCode' => $this->passengerArr['passenger_national_code'],
                        'passengerBirthdayEn' => $this->passengerArr['passenger_birthday'],
                        'passengerPassportCountry' => $this->passengerArr['passportCountry'],
                        'passengerPassportNumber' => $this->passengerArr['passportNumber'],
                        'passengerPassportExpire' => $this->passengerArr['passportExpire'],
                        'memberID' => $this->passengerArr['member_id'],
                        'passengerNationality' => $_POST["passengerNationalityA" . $i]
                    );
                    $passengerController->insert($passengerAddArray);
                }

//                 $condition = (isset($_POST['nameFaA'.$i]) ?  "passenger_national_code='{$this->passengerArr["passenger_national_code"]}'" : "passportNumber ='{$this->passengerArr["passportNumber"]}'");
                $book_check = $book_model->get()->where('requestNumber', $this->passengerArr['requestNumber'])->where('member_id', $UserId);

                if(isset($_POST['nameFaA'.$i])){
                    $book_check = $book_check->where('passenger_national_code',$this->passengerArr["passenger_national_code"]);
                }else{
                    $book_check = $book_check->where('passportNumber',$this->passengerArr["passportNumber"]);
                }
//                $conditions = isset($_POST['nameFaA' . $i]) ? ['index'=>"passenger_national_code" ,'value'=> $this->passengerArr["passenger_national_code"]] : ['index'=>'passportNumber','value' => $this->passengerArr["passportNumber"]];

//                 $sql_check_book = " SELECT * FROM book_train_tb WHERE requestNumber='{$this->passengerArr['requestNumber']}' AND {$condition} AND member_id='{$_SESSION["userId"]}'";
//                 $book_check = $model->load($sql_check_book);

                $book_check = $book_check->find();
//                echo '<pre style="color : darkblue">'.json_encode($book_check,256).'</pre>';
//                 echo '<code>'.json_encode($_POST,256|64).'</code>';
//                 echo '<code>'.json_encode($this->passengerArr,256|64).'</code>';
                if (empty($book_check)) {
                    unset($this->passengerArr['client_id']);
                    $book_insert = $book_model->insertWithBind($this->passengerArr);
                    $this->passengerArr['client_id'] = CLIENT_ID;

                    functions::insertLog('passengerArr' . json_encode($this->passengerArr,256), 'train_report');
                    $report_insert = $modelBase->insertWithBind($this->passengerArr, 'report_train_tb');
                    functions::insertLog('report insert result === ' . json_encode([$book_insert,$report_insert],256), 'train_report');

                }
            }
//echo json_encode('test');die();
            if (isset($_POST["CheckCoupe"]) && $_POST["CheckCoupe"] == "1" && $type == 'ONEWAY') {


                $count_passenger_coupe = ((ceil($passenger_count/$InfoTrain['CompartmentCapicity']) * $InfoTrain['CompartmentCapicity'])-($passenger_count)) ;

                $this->passengerArr = array();
                for ($i = 1; $i <= $count_passenger_coupe; $i++) {

                    $this->passengerArr['passenger_age'] = 'Adt';
                    $this->passengerArr['passenger_gender'] = $_POST["genderA1" ];
                    $this->passengerArr['passenger_name_en'] = $_POST["nameEnA1" ];
                    $this->passengerArr['passenger_family_en'] = $_POST["familyEnA1" ];
                    $this->passengerArr['passenger_birthday_en'] = isset($_POST["birthdayEnA1"]) ? $_POST["birthdayEnA1"] : functions::ConvertToMiladi($_POST["birthdayA1"],'-');
                    $this->passengerArr['passenger_birthday'] = $_POST["birthdayA1"];
                    $this->passengerArr['passenger_national_code'] = $_POST["NationalCodeA1"];
                    $this->passengerArr['passportCountry'] = $_POST["passportCountryA1"];
                    $this->passengerArr['passportNumber'] = $_POST["passportNumberA1"];
                    $this->passengerArr['passportExpire'] = $_POST["passportExpireA1"];
                    $this->passengerArr['passenger_name'] = $_POST["nameFaA1"];
                    $this->passengerArr['passenger_family'] = $_POST["familyFaA1"];
                    $this->passengerArr['member_id'] = $UserId;
                    $this->passengerArr['member_name'] = $member['name'] . ' ' . $member['family'];
                    $this->passengerArr['member_mobile'] = $member['mobile'];
                    $this->passengerArr['member_email'] = $member['email'];
                    $this->passengerArr['mobile_buyer'] = $_POST['Mobile_buyer'];
                    $this->passengerArr['email_buyer'] = $_POST['Email'];
                    $this->passengerArr['agency_id'] = !empty($agency_info) ? $agency_info['id']: 0;
                    $this->passengerArr['agency_name'] =  !empty($agency_info) ? $agency_info['name_fa']:'';
                    $this->passengerArr['agency_accountant'] = !empty($agency_info) ? $agency_info['accountant'] : '';
                    $this->passengerArr['agency_manager'] = !empty($agency_info) ? $agency_info['manager'] : '';
                    $this->passengerArr['agency_mobile'] = !empty($agency_info) ? $agency_info['phone'] : '';
                    $this->passengerArr['TicketNumber'] = $ticketnumber;
                    $this->passengerArr['CompanyName'] = $InfoTrain["CompanyName"];
                    $this->passengerArr['Departure_City'] = $InfoTrain["Departure_City"];
                    $this->passengerArr['Arrival_City'] = $InfoTrain["Arrival_City"];
                    $this->passengerArr['Dep_Code'] = $InfoTrain["Dep_Code"];
                    $this->passengerArr['Arr_Code'] = $InfoTrain["Arr_Code"];
                    $this->passengerArr['WagonName'] = $InfoTrain["WagonName"];
                    $this->passengerArr['WagonType'] = $InfoTrain["WagonType"];
                    $this->passengerArr['TrainNumber'] = $InfoTrain["TrainNumber"];
                    $this->passengerArr['MoveDate'] = $InfoTrain["MoveDate"];
                    $this->passengerArr['ExitDate'] = $InfoTrain["ExitDate"];
                    $this->passengerArr['ExitTime'] = $InfoTrain["ExitTime"];
                    $this->passengerArr['sex_code'] = $InfoTrain["PassengerNum"];
                    $this->passengerArr['TimeOfArrival'] = $InfoTrain["TimeOfArrival"];
                    $this->passengerArr['FullPrice'] = $_POST["TariffPriceCoupe"] > 0 ? $_POST["TariffPriceCoupe"] : '';
                    $this->passengerArr['Cost'] = $_POST["TariffPriceCoupe"] > 0 ? $_POST["TariffPriceCoupe"] : '';
                    $this->passengerArr['discount_inf_price'] = isset($_POST["costOffCoupe"]) ? $_POST["costOffCoupe"] : '0';
                    $this->passengerArr['percent_discount'] =   isset($_POST["percentCoupe"]) ? $_POST["percentCoupe"] : '0';
                    $this->passengerArr['CompartmentCapicity'] = $InfoTrain["CompartmentCapicity"];
                    $this->passengerArr['IsCompartment'] = 1;
                    $this->passengerArr['CircularNumberSerial'] = $InfoTrain["CircularNumberSerial"];
                    $this->passengerArr['Adult'] = 1;
                    $this->passengerArr['Child'] = 0;
                    $this->passengerArr['Infant'] = 0;
                    $this->passengerArr['ServiceCode'] = $_POST["ServiceCode"];
                    $this->passengerArr['UniqueId'] = $this->UniqueId;
                    $this->passengerArr['factor_number'] = $this->factorNumber;
                    $this->passengerArr['irantech_commission'] = $it_commission;
                    $this->passengerArr['creation_date'] = date('Y-m-d H:i:s');
                    $this->passengerArr['creation_date_int'] = time();
                    $this->passengerArr['extra_chair'] = 1;
                    $this->passengerArr['Route_Type'] = '1';
                    $this->passengerArr['requestNumber'] = $_POST['request_number_dept'];
                    $this->passengerArr['is_specific'] = (isset($_POST['is_specific_dept']) && trim($_POST['is_specific_dept']) == 'yes') ? 'yes' : 'no';
                    $this->passengerArr['serviceTitle'] = (isset($_POST['is_specific_dept']) && trim($_POST['is_specific_dept']) == 'yes') ? 'PrivateTrain' : 'Train';
                    $this->passengerArr['is_registered'] = '0';

                    unset($this->passengerArr['client_id']);
                    $book_model->insertWithBind($this->passengerArr);

                    $passengerArr['client_id'] = CLIENT_ID;
                    functions::insertLog('passengerArr coupe dept' . json_encode($this->passengerArr,256), 'train_report');
                    $modelBase->insertWithBind($this->passengerArr, 'report_train_tb');
                }

            }

            if (isset($_POST["CheckCoupeReturn"]) && $_POST["CheckCoupeReturn"] == 1 && $type == 'TOWEWAY') {
                $count_passenger_coupe = ((ceil($passenger_count/$InfoTrain['CompartmentCapicity']) * $InfoTrain['CompartmentCapicity'])-($passenger_count)) ;

                $this->passengerArr = array();
                for ($i = 1; $i <= $count_passenger_coupe; $i++) {
                    $this->passengerArr['passenger_age'] = 'Adt';
                    $this->passengerArr['passenger_gender'] = $_POST["genderA1"];
                    $this->passengerArr['passenger_name_en'] = $_POST["nameEnA1"];
                    $this->passengerArr['passenger_family_en'] = $_POST["familyEnA1"];
                    $this->passengerArr['passenger_birthday_en'] = isset($_POST["birthdayEnA1"]) ? $_POST["birthdayEnA1"] : functions::ConvertToMiladi($_POST["birthdayA1"],'-');
                    $this->passengerArr['passenger_birthday'] = $_POST["birthdayA1"];
                    $this->passengerArr['passenger_national_code'] = $_POST["NationalCodeA1"];
                    $this->passengerArr['passportCountry'] = $_POST["passportCountryA1"];
                    $this->passengerArr['passportNumber'] = $_POST["passportNumberA1"];
                    $this->passengerArr['passportExpire'] = $_POST["passportExpireA1"];
                    $this->passengerArr['passenger_name'] = $_POST["nameFaA1"];
                    $this->passengerArr['passenger_family'] = $_POST["familyFaA1"];
                    $this->passengerArr['member_id'] = $UserId;
                    $this->passengerArr['member_name'] = $member['name'] . ' ' . $member['family'];
                    $this->passengerArr['member_mobile'] = $member['mobile'];
                    $this->passengerArr['member_email'] = $member['email'];
                    $this->passengerArr['mobile_buyer'] = $_POST['Mobile_buyer'];
                    $this->passengerArr['email_buyer'] = $_POST['Email'];
                    $this->passengerArr['agency_id'] = !empty($agency_info) ? $agency_info['id']: 0;
                    $this->passengerArr['agency_name'] =  !empty($agency_info) ? $agency_info['name_fa']:'';
                    $this->passengerArr['agency_accountant'] = !empty($agency_info) ? $agency_info['accountant'] : '';
                    $this->passengerArr['agency_manager'] = !empty($agency_info) ? $agency_info['manager'] : '';
                    $this->passengerArr['agency_mobile'] = !empty($agency_info) ? $agency_info['phone'] : '';
                    $this->passengerArr['TicketNumber'] = $ticketnumber;
                    $this->passengerArr['CompanyName'] = $InfoTrain["CompanyName"];
                    $this->passengerArr['Departure_City'] = $InfoTrain["Departure_City"];
                    $this->passengerArr['Arrival_City'] = $InfoTrain["Arrival_City"];
                    $this->passengerArr['Dep_Code'] = $InfoTrain["Dep_Code"];
                    $this->passengerArr['Arr_Code'] = $InfoTrain["Arr_Code"];
                    $this->passengerArr['WagonName'] = $InfoTrain["WagonName"];
                    $this->passengerArr['WagonType'] = $InfoTrain["WagonType"];
                    $this->passengerArr['TrainNumber'] = $InfoTrain["TrainNumber"];
                    $this->passengerArr['MoveDate'] = $InfoTrain["MoveDate"];
                    $this->passengerArr['ExitDate'] = $InfoTrain["ExitDate"];
                    $this->passengerArr['ExitTime'] = $InfoTrain["ExitTime"];
                    $this->passengerArr['sex_code'] = $InfoTrain["PassengerNum"];
                    $this->passengerArr['TimeOfArrival'] = $InfoTrain["TimeOfArrival"];
                    $this->passengerArr['FullPrice'] = $_POST["TariffPriceCoupeReturn"] > 0 ?  $_POST["TariffPriceCoupeReturn"]:'';
                    $this->passengerArr['Cost'] = $_POST["TariffPriceCoupeReturn"] > 0 ?  $_POST["TariffPriceCoupeReturn"]:'';
                    $this->passengerArr['discount_inf_price'] = isset($_POST["costOffCoupeReturn"]) ? $_POST["costOffCoupeReturn"] : '0';
                    $this->passengerArr['percent_discount'] = isset($_POST["percentCoupeReturn"]) ? $_POST["percentCoupeReturn"] : '0';
                    $this->passengerArr['CompartmentCapicity'] = $InfoTrain["CompartmentCapicity"];
                    $this->passengerArr['IsCompartment'] = 1;
                    $this->passengerArr['CircularNumberSerial'] = $InfoTrain["CircularNumberSerial"];
                    $this->passengerArr['Adult'] = 1;
                    $this->passengerArr['Child'] = 0;
                    $this->passengerArr['Infant'] = 0;
                    $this->passengerArr['ServiceCode'] = $_POST["ServiceCode"];
                    $this->passengerArr['UniqueId'] = $this->UniqueId;
                    $this->passengerArr['factor_number'] = $this->factorNumber;
                    $this->passengerArr['irantech_commission'] = $it_commission;
                    $this->passengerArr['creation_date'] = date('Y-m-d H:i:s');
                    $this->passengerArr['creation_date_int'] = time();
                    $this->passengerArr['extra_chair'] = 1;
                    $this->passengerArr['Route_Type'] = '2';
                    $this->passengerArr['requestNumber'] = $_POST['request_number_return'];
                    $this->passengerArr['is_specific'] = (isset($_POST['is_specific_return']) && trim($_POST['is_specific_return']) == 'yes') ? 'yes' : 'no';
                    $this->passengerArr['serviceTitle'] = (isset($_POST['is_specific_return']) && trim($_POST['is_specific_return']) == 'yes') ? 'PrivateTrain' : 'Train';
                    $this->passengerArr['is_registered'] = '0';
//                    $model->setTable('book_train_tb');
                    unset($this->passengerArr['client_id']);
                    $book_model->insertWithBind($this->passengerArr);
                    $passengerArr['client_id'] = CLIENT_ID;
                    functions::insertLog('passengerArr coupe return' . json_encode($this->passengerArr,256), 'train_report');
                    $modelBase->insertWithBind($this->passengerArr, 'report_train_tb');
                }

            }
        }

        if (isset($_POST["nameFaC1"]) || isset($_POST['nameEnC1'])) {
            $this->passengerArr = array();
            for ($i = 1; $i <= $InfoTrain['Child']; $i++) {
                $this->passengerArr['passenger_age'] = 'Chd';
                $this->passengerArr['passenger_gender'] = $_POST["genderC$i"];
                $this->passengerArr['passenger_name_en'] = $_POST["nameEnC$i"];
                $this->passengerArr['passenger_family_en'] = $_POST["familyEnC$i"];

                $this->passengerArr['passenger_birthday_en'] = isset($_POST["birthdayEnC$i"]) ? $_POST["birthdayEnC$i"] : functions::ConvertToMiladi($_POST["birthdayC$i"],'-');
                $this->passengerArr['passenger_birthday'] =  isset($_POST["birthdayC$i"]) ? $_POST["birthdayC$i"] : functions::ConvertToJalali($_POST["birthdayEnC" . $i]);

                $this->passengerArr['passenger_national_code'] =  isset( $_POST["NationalCodeC$i"]) ?  $_POST["NationalCodeC$i"] : '0000000000' ;
                $this->passengerArr['passportCountry'] = $_POST["passportCountryC$i"];
                $this->passengerArr['passportNumber'] = $_POST["passportNumberC$i"];
                $this->passengerArr['passportExpire'] = $_POST["passportExpireC$i"];
                $this->passengerArr['passenger_name'] = $_POST["nameFaC$i"];
                $this->passengerArr['passenger_family'] = $_POST["familyFaC$i"];
                $this->passengerArr['member_id'] = $UserId;
                $this->passengerArr['member_name'] = $member['name'] . ' ' . $member['family'];
                $this->passengerArr['member_mobile'] = $member['mobile'];
                $this->passengerArr['member_email'] = $member['email'];
                $this->passengerArr['mobile_buyer'] = $_POST['Mobile_buyer'];
                $this->passengerArr['email_buyer'] = $_POST['Email'];
                $this->passengerArr['agency_id'] = !empty($agency_info) ? $agency_info['id']: 0;
                $this->passengerArr['agency_name'] =  !empty($agency_info) ? $agency_info['name_fa']:'';
                $this->passengerArr['agency_accountant'] = !empty($agency_info) ? $agency_info['accountant'] : '';
                $this->passengerArr['agency_manager'] = !empty($agency_info) ? $agency_info['manager'] : '';
                $this->passengerArr['agency_mobile'] = !empty($agency_info) ? $agency_info['phone'] : '';
                $this->passengerArr['TicketNumber'] = $ticketnumber;
                $this->passengerArr['CompanyName'] = $InfoTrain["CompanyName"];
                $this->passengerArr['Departure_City'] = $InfoTrain["Departure_City"];
                $this->passengerArr['Arrival_City'] = $InfoTrain["Arrival_City"];
                $this->passengerArr['Dep_Code'] = $InfoTrain["Dep_Code"];
                $this->passengerArr['Arr_Code'] = $InfoTrain["Arr_Code"];
                $this->passengerArr['WagonName'] = $InfoTrain["WagonName"];
                $this->passengerArr['WagonType'] = $InfoTrain["WagonType"];
                $this->passengerArr['TrainNumber'] = $InfoTrain["TrainNumber"];
                $this->passengerArr['MoveDate'] = $InfoTrain["MoveDate"];
                $this->passengerArr['ExitDate'] = $InfoTrain["ExitDate"];
                $this->passengerArr['ExitTime'] = $InfoTrain["ExitTime"];
                $this->passengerArr['sex_code'] = $InfoTrain["PassengerNum"];
                $this->passengerArr['TimeOfArrival'] = $InfoTrain["TimeOfArrival"];


                if($_POST["passengerNationalityC" . $i] == 0){
                    if($type == 'ONEWAY') {
                       $price_final_cost = $_POST["priceChildC"] > 0 ? $_POST["priceChildC"] : '' ;
                    } else{
                       $price_final_cost = $_POST["priceChildReturnC"] > 0 ? $_POST["priceChildReturnC"] : ''   ;
                    }
                }  else{
                   if($type == 'ONEWAY') {
                        $price_final_cost = $_POST["nonIranian"] > 0 ? $_POST["nonIranian"] : '' ;
                   }else{
                        $price_final_cost = $_POST["priceNoneIranianReturn"] > 0 ? $_POST["priceNoneIranianReturn"] : ''   ;
                   }
                }

                $this->passengerArr['FullPrice'] = $price_final_cost;
                $this->passengerArr['Cost'] = $price_final_cost;
                $this->passengerArr['discount_inf_price'] = ($type == 'ONEWAY' ? (isset( $_POST["costOffC" . $i]) ?  $_POST["costOffC" . $i] : '0') : (isset($_POST["costOffReturnC" . $i]) ? $_POST["costOffReturnC" . $i] : '0'));
                $this->passengerArr['percent_discount'] = ($type == 'ONEWAY' ? (isset( $_POST["costOffC" . $i]) ?  $_POST["costOffC" . $i] : '0') : (isset($_POST["costOffReturnC" . $i]) ? $_POST["costOffReturnC" . $i] : '0'));
                $this->passengerArr['CompartmentCapicity'] = $InfoTrain["CompartmentCapicity"];
                $this->passengerArr['IsCompartment'] = 1;
                $this->passengerArr['CircularNumberSerial'] = $InfoTrain["CircularNumberSerial"];
                $this->passengerArr['Adult'] = 0;
                $this->passengerArr['Child'] = 1;
                $this->passengerArr['Infant'] = 0;
                $this->passengerArr['ServiceCode'] = $_POST["ServiceCode"];
                $this->passengerArr['UniqueId'] = $this->UniqueId;
                $this->passengerArr['factor_number'] = $this->factorNumber;
                $this->passengerArr['irantech_commission'] = $it_commission;
                $this->passengerArr['creation_date'] = date('Y-m-d H:i:s');
                $this->passengerArr['creation_date_int'] = time();
                $this->passengerArr['requestNumber'] = ($type == 'ONEWAY') ? $_POST['request_number_dept'] : $_POST['request_number_return'];
                $this->passengerArr['Route_Type'] = ($type == 'ONEWAY') ? '1' : '2';
                $this->passengerArr['is_specific'] = (isset($_POST['is_specific_dept']) && trim($_POST['is_specific_dept']) == 'yes') ? 'yes' : 'no';
                $this->passengerArr['serviceTitle'] = (isset($_POST['is_specific_dept']) && trim($_POST['is_specific_dept']) == 'yes') ? 'PrivateTrain' : 'Train';
                $this->passengerArr['is_registered'] = '0';
                $this->passengerArr['extra_chair'] = 0;
                if (isset($_POST["serviceC" . $i]) && $_POST["serviceC" . $i] != '' && $type == 'ONEWAY') {

                    $service = explode('@@', $_POST["serviceC" . $i]);
                    $this->passengerArr['Service'] = $service[0].'-'.$service[1];
                    $this->passengerArr['service_price'] = $service[1] ;
                    $this->passengerArr['ServiceTypeCode'] = $service[2];;

                }

                if (isset($_POST["freeC" . $i]) && $_POST["freeC" . $i] != '' && $type == 'ONEWAY') {

                    $service = explode('@@', $_POST["freeC" . $i]);
                    $this->passengerArr['free_service'] = $service[0];
                    $this->passengerArr['free_service_code'] = $service[1];

                }

                if ($type == 'TOWEWAY') {
                    if (isset($_POST["serviceReturnC$i"]) &&  $_POST["serviceReturnC$i"]!= '') {
                        $service = explode('@@', $_POST["serviceReturnC" . $i]);
                        $this->passengerArr['Service'] = $service[0].'-'.$service[1];
                        $this->passengerArr['service_price'] = $service[1] ;
                        $this->passengerArr['ServiceTypeCode'] = $service[2];
                    }
                    if (isset($_POST["freeReturnC$i"]) &&  $_POST["freeReturnC$i"]!= '') {
                        $service = explode('@@', $_POST["serviceReturnC" . $i]);
                        $this->passengerArr['free_service'] = $service[0];
                        $this->passengerArr['free_service_code'] = $service[1];
                    }
                    $this->passengerArr['is_specific'] = (isset($_POST['is_specific_return']) && trim($_POST['is_specific_return']) == 'yes') ? 'yes' : 'no';
                    $this->passengerArr['serviceTitle'] = (isset($_POST['is_specific_return']) && trim($_POST['is_specific_return']) == 'yes') ? 'PrivateTrain' : 'Train';
                    $this->passengerArr['is_registered'] = '0';
                }

                if ($result) {
                    $passengerAddArray = array(
                        'passengerName' => $this->passengerArr['passenger_name'],
                        'passengerNameEn' => $this->passengerArr['passenger_name_en'],
                        'passengerFamily' => $this->passengerArr['passenger_family'],
                        'passengerFamilyEn' => $this->passengerArr['passenger_family_en'],
                        'passengerGender' => $this->passengerArr['passenger_gender'],
                        'passengerBirthday' => $this->passengerArr['passenger_birthday'],
                        'passengerNationalCode' => $this->passengerArr['passenger_national_code'],
                        'passengerBirthdayEn' => $this->passengerArr['passenger_birthday'],
                        'passengerPassportCountry' => $this->passengerArr['passportCountry'],
                        'passengerPassportNumber' => $this->passengerArr['passportNumber'],
                        'passengerPassportExpire' => $this->passengerArr['passportExpire'],
                        'memberID' => $this->passengerArr['member_id'],
                        'passengerNationality' => $_POST["passengerNationalityC$i"]
                    );
                    $passengerController->insert($passengerAddArray);
                }
                $condition = (isset($_POST['nameFaC' . $i]) ? "passenger_national_code='{$this->passengerArr["passenger_national_code"]}'" : "passportNumber ='{$this->passengerArr["passportNumber"]}'");

                $sql_check_book = " SELECT * FROM book_train_tb WHERE requestNumber='{$this->passengerArr['requestNumber']}' AND {$condition} AND member_id='{$UserId}'";
                $book_check = $model->load($sql_check_book);


                if (empty($book_check)) {
//                    $model->setTable('book_train_tb');
                    unset($this->passengerArr['client_id']);
//                    $model->insertWithBind($this->passengerArr);
                
                    $book_model->insertWithBind($this->passengerArr);
                    $this->passengerArr['client_id'] = CLIENT_ID;
                    functions::insertLog('passengerArr child ' . json_encode($this->passengerArr,256), 'train_report');
                    $modelBase->insertWithBind($this->passengerArr, 'report_train_tb');
                }

            }
        }

        if (isset($_POST["nameFaI1"]) || isset($_POST["nameEnI1"])) {
            $this->passengerArr = array();
            for ($i = 1; $i <= $InfoTrain['Infant']; $i++) {
                $this->passengerArr['passenger_age'] = 'Inf';
                $this->passengerArr['passenger_gender'] = $_POST["genderI$i"];
                $this->passengerArr['passenger_name_en'] = $_POST["nameEnI$i"];
                $this->passengerArr['passenger_family_en'] = $_POST["familyEnI$i"];
                $this->passengerArr['passenger_birthday_en'] = isset($_POST["birthdayENI$i"]) ? $_POST["birthdayENI$i"] : functions::ConvertToMiladi($_POST["birthdayI$i"],'-');
                $this->passengerArr['passenger_birthday'] =  isset($_POST["birthdayI$i"]) ? $_POST["birthdayI$i"] : functions::ConvertToJalali($_POST["birthdayENI" . $i]);
                $this->passengerArr['passenger_national_code'] = isset( $_POST["NationalCodeI$i"]) ?  $_POST["NationalCodeI$i"] : '0000000000' ;
               
                $this->passengerArr['passportCountry'] = $_POST["passportCountryI$i"];
                $this->passengerArr['passportNumber'] = $_POST["passportNumberI$i"];
                $this->passengerArr['passportExpire'] = $_POST["passportExpireI$i"];
                $this->passengerArr['passenger_name'] = $_POST["nameFaI$i"];
                $this->passengerArr['passenger_family'] = $_POST["familyFaI$i"];
                $this->passengerArr['discount_inf_price'] = 0;
                $this->passengerArr['percent_discount'] = 0;
                $this->passengerArr['member_id'] = $UserId;
                $this->passengerArr['member_name'] = $member['name'] . ' ' . $member['family'];
                $this->passengerArr['member_mobile'] = $member['mobile'];
                $this->passengerArr['member_email'] = $member['email'];
                $this->passengerArr['mobile_buyer'] = $_POST['Mobile_buyer'];
                $this->passengerArr['email_buyer'] = $_POST['Email'];
                $this->passengerArr['agency_id'] = !empty($agency_info) ? $agency_info['id']: 0;
                $this->passengerArr['agency_name'] =  !empty($agency_info) ? $agency_info['name_fa']:'';
                $this->passengerArr['agency_accountant'] = !empty($agency_info) ? $agency_info['accountant'] : '';
                $this->passengerArr['agency_manager'] = !empty($agency_info) ? $agency_info['manager'] : '';
                $this->passengerArr['agency_mobile'] = !empty($agency_info) ? $agency_info['phone'] : '';
                $this->passengerArr['TicketNumber'] = $ticketnumber;
                $this->passengerArr['CompanyName'] = $InfoTrain["CompanyName"];
                $this->passengerArr['Departure_City'] = $InfoTrain["Departure_City"];
                $this->passengerArr['Arrival_City'] = $InfoTrain["Arrival_City"];
                $this->passengerArr['Dep_Code'] = $InfoTrain["Dep_Code"];
                $this->passengerArr['Arr_Code'] = $InfoTrain["Arr_Code"];
                $this->passengerArr['WagonName'] = $InfoTrain["WagonName"];
                $this->passengerArr['WagonType'] = $InfoTrain["WagonType"];
                $this->passengerArr['TrainNumber'] = $InfoTrain["TrainNumber"];
                $this->passengerArr['MoveDate'] = $InfoTrain["MoveDate"];
                $this->passengerArr['ExitDate'] = $InfoTrain["ExitDate"];
                $this->passengerArr['ExitTime'] = $InfoTrain["ExitTime"];
                $this->passengerArr['sex_code'] = $InfoTrain["PassengerNum"];
                $this->passengerArr['TimeOfArrival'] = $InfoTrain["TimeOfArrival"];




                if($_POST["passengerNationalityI" . $i] == 0){
                    if($type == 'ONEWAY') {
                       $price_final_cost = $_POST["priceInfantI"] > 0 ? $_POST["priceInfantI"] : '' ;
                    } else{
                       $price_final_cost = $_POST["priceInfantReturnI"] > 0 ? $_POST["priceInfantReturnI"] : ''   ;
                    }
                }  else{
                   if($type == 'ONEWAY') {
                        $price_final_cost = $_POST["nonIranian"] > 0 ? $_POST["nonIranian"] : '' ;
                   }else{
                        $price_final_cost = $_POST["priceNoneIranianReturn"] > 0 ? $_POST["priceNoneIranianReturn"] : ''   ;
                   }
                }
                $this->passengerArr['FullPrice'] = $price_final_cost;
                $this->passengerArr['Cost'] = $price_final_cost;
                $this->passengerArr['CompartmentCapicity'] = $InfoTrain["CompartmentCapicity"];
                $this->passengerArr['IsCompartment'] = 1;
                $this->passengerArr['CircularNumberSerial'] = $InfoTrain["CircularNumberSerial"];
                $this->passengerArr['Adult'] = 0;
                $this->passengerArr['Child'] = 0;
                $this->passengerArr['Infant'] = 1;
                $this->passengerArr['ServiceCode'] = $_POST["ServiceCode"];
                $this->passengerArr['UniqueId'] = $this->UniqueId;
                $this->passengerArr['factor_number'] = $this->factorNumber;
                $this->passengerArr['irantech_commission'] = $it_commission;
                $this->passengerArr['creation_date'] = date('Y-m-d H:i:s');
                $this->passengerArr['creation_date_int'] = time();
                $this->passengerArr['Route_Type'] = ($type == 'ONEWAY') ? '1' : '2';
                $this->passengerArr['requestNumber'] = ($type == 'ONEWAY') ? $_POST['request_number_dept'] : $_POST['request_number_return'];
                $this->passengerArr['is_specific'] = (isset($_POST['is_specific_dept']) && trim($_POST['is_specific_dept']) == 'yes') ? 'yes' : 'no';
                $this->passengerArr['serviceTitle'] = (isset($_POST['is_specific_dept']) && trim($_POST['is_specific_dept']) == 'yes') ? 'PrivateTrain' : 'Train';
                $this->passengerArr['is_registered'] = '0';
                $this->passengerArr['extra_chair'] = 0;

                if (isset($_POST["serviceI" . $i]) && $_POST["serviceI" . $i] != '' && $type == 'ONEWAY') {

                    $service = explode('@@', $_POST["serviceI" . $i]);
                    $this->passengerArr['Service'] = $service[0].'-'.$service[1];
                    $this->passengerArr['service_price'] = $service[1] ;
                    $this->passengerArr['ServiceTypeCode'] = $service[2];;

                }
                if ($type == 'TOWEWAY') {
                    if ($_POST["serviceReturnI$i"] != '') {
                        $service = explode('@@', $_POST["serviceReturnI" . $i]);
                        $this->passengerArr['Service'] = $service[0].'-'.$service[1];
                        $this->passengerArr['service_price'] = $service[1] ;
                        $this->passengerArr['ServiceTypeCode'] = $service[2];
                    }
                    $this->passengerArr['is_specific'] = (isset($_POST['is_specific_return']) && trim($_POST['is_specific_return']) == 'yes') ? 'yes' : 'no';
                    $this->passengerArr['serviceTitle'] = (isset($_POST['is_specific_return']) && trim($_POST['is_specific_return']) == 'yes') ? 'PrivateTrain' : 'Train';
                    $this->passengerArr['is_registered'] = '0';
                }
                if ($result) {
                    $passengerAddArray = array(
                        'passengerName' => $this->passengerArr['passenger_name'],
                        'passengerNameEn' => $this->passengerArr['passenger_name_en'],
                        'passengerFamily' => $this->passengerArr['passenger_family'],
                        'passengerFamilyEn' => $this->passengerArr['passenger_family_en'],
                        'passengerGender' => $this->passengerArr['passenger_gender'],
                        'passengerBirthday' => $this->passengerArr['passenger_birthday'],
                        'passengerNationalCode' => $this->passengerArr['passenger_national_code'],
                        'passengerBirthdayEn' => $this->passengerArr['passenger_birthday'],
                        'passengerPassportCountry' => $this->passengerArr['passportCountry'],
                        'passengerPassportNumber' => $this->passengerArr['passportNumber'],
                        'passengerPassportExpire' => $this->passengerArr['passportExpire'],
                        'memberID' => $this->passengerArr['member_id'],
                        'passengerNationality' => $_POST["passengerNationalityI$i"]
                    );
                    $passengerController->insert($passengerAddArray);
                }
                $condition = (isset($_POST['nameFaI' . $i]) ? "passenger_national_code='{$this->passengerArr["passenger_national_code"]}'" : "passportNumber ='{$this->passengerArr["passportNumber"]}'");

                $sql_check_book = " SELECT * FROM book_train_tb WHERE requestNumber='{$this->passengerArr['requestNumber']}' AND {$condition} AND member_id='{$UserId}'";
                $book_check = $model->load($sql_check_book);


                if (empty($book_check)) {
                    unset($this->passengerArr['client_id']);
                    $book_model->insertWithBind($this->passengerArr);
                    $this->passengerArr['client_id'] = CLIENT_ID;
                    functions::insertLog('passengerArr infant dept' . json_encode($this->passengerArr,256), 'train_report');
                    $modelBase->insertWithBind($this->passengerArr, 'report_train_tb');
                }
            }
        }

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

    public function getTotalPriceByFactorNumber($factorNumber)
    {
        $Model = Load::library('Model');

        $sql_query = "SELECT * FROM book_train_tb WHERE passenger_factor_num = '{$factorNumber}' ";

        return $Model->load($sql_query);
    }

    public function getPassengerList($requestNumber, $serviceCode)
    {
        /** @var bookTrainModel $bookTrainModel */
        $bookTrainModel = Load::getModel('bookTrainModel');
        $listPassenger = $bookTrainModel->get()->where('requestNumber', $requestNumber)->where('ServiceCode', $serviceCode);
        $listPassenger = $listPassenger->openParentheses();
        $listPassenger = $listPassenger->where('extra_chair', '1', '!=')->orWhereNull('extra_chair');
        $listPassenger = $listPassenger->closeParentheses();
      
        $listPassenger = $listPassenger->all();
        foreach ($listPassenger as $Passenger) {
            $ServicePrice = $Passenger['service_price'];
            $price = ($Passenger['Cost'] - $Passenger['discount_inf_price']) + $ServicePrice;
            $this->totalPrice += ($price/*- $discountPrice['costOff']*/);
        }


        return $listPassenger;
    }

    public function doubleCheckPrice($request_number) {

        $check = $this->getSpecialPrices($request_number);

        functions::insertLog('check price result==>'.json_encode($check,256),'check_price_train');

        if(!isset($check['result_status'])){
            $prices = $this->getModel('bookTrainModel')->get()->where('requestNumber', $request_number)->all();

            functions::insertLog('prices Result===>'.json_encode($prices,256),'check_price_train');

            $check_final_price = 1;
            $type_passenger = '';
            $triif= 0;
            foreach ($prices as $each_price) {

                if($each_price['passportCountry']) {
                        $triif = 9 ;
                }
                elseif($each_price['passenger_age']=='Adt'  && $each_price['extra_chair'] == '1'){
                    $triif = 5 ;
                }elseif($each_price['passenger_age']=='Chd'){
                    $triif = 2 ;
                }elseif($each_price['passenger_age']=='Inf'){
                    $triif = 6 ;
                }elseif($each_price['passenger_age']=='Adt'){
                    $triif = 1 ;
                }


                if($each_price['FullPrice'] != $check[$triif]){
                    $check_final_price = 0;
                    break ;
                }

            }

            if($check_final_price==0){
                return false;
            }
            return true;
        }
        return false;
    }
}


