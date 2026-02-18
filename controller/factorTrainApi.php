<?php

/**/
/**
 * Class factorTrainApi
 * @property factorTrainApi $factorTrainApi
 */
class factorTrainApi extends newApiTrain
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

    public function registerPassengersTrain($ticketnumber,$InfoTrain,$type)
    {
        $result = Session::IsLogin();
        $this->ServiceCode = $InfoTrain['ServiceCode'];
        $this->UniqueId = $InfoTrain['UniqueId'];
        $this->serviceSessionId = $InfoTrain['ServiceSessionId'];
        if($type == 'ONEWAY'){
            $this->ticket_number = $ticketnumber;
        }else{
            $this->ticket_number_return = $ticketnumber;
        }

        $sql = "SELECT * FROM book_train_tb WHERE TicketNumber='{$this->ticket_number}' AND TicketNumber <> ''";

        $existFactorNumber = $this->Model->load($sql);

        if(empty($existFactorNumber)) {
            $this->factorNumber = substr(time(), 0, 5) . mt_rand(000, 999) . substr(time(), 5, 10);
        }else{
            $this->factorNumber = $existFactorNumber['factor_number'] ;
        }

        $model = Load::library('Model');
        $modelBase = Load::library('ModelBase');
        $passengerController = Load::controller('passengers');
        $SqlMember = "SELECT * FROM members_tb WHERE id='{$_SESSION["userId"]}'";
        $member = $model->load($SqlMember);
        $checkSubAgency =  functions::checkExistSubAgency() ;
        if ($member['fk_agency_id'] > 0 || $checkSubAgency) {
            $agencyId = ($checkSubAgency) ? SUB_AGENCY_ID : $member['fk_agency_id'];
            $sql = " SELECT * FROM agency_tb WHERE id='{$agencyId}'";
            $agency = $model->load($sql);
        }

        $irantechCommission = Load::controller('irantechCommission');
        $it_commission = $irantechCommission->getCommission('Train', '14');


        if(isset($_POST["nameFaA1"]) || isset($_POST["nameEnA1"])) {

            $this->passengerArr =array();
             for ($i = 1; $i <= $_POST["adult"]; $i++) {

                 $this->passengerArr['passenger_age'] = 'Adt';
                 $this->passengerArr['passenger_gender'] = $_POST["genderA".$i];
                 $this->passengerArr['passenger_name_en'] = $_POST["nameEnA".$i];
                 $this->passengerArr['passenger_family_en'] = $_POST["familyEnA".$i];
                 $this->passengerArr['passenger_birthday_en'] = $_POST["birthdayEnA".$i];
                 $this->passengerArr['passenger_birthday'] = $_POST["birthdayA".$i];
                 $this->passengerArr['passenger_national_code'] = $_POST["NationalCodeA".$i];
                 $this->passengerArr['passportCountry'] = $_POST["passportCountryA".$i];
                 $this->passengerArr['passportNumber'] = $_POST["passportNumberA".$i];
                 $this->passengerArr['passportExpire'] = $_POST["passportExpireA".$i];
                 $this->passengerArr['passenger_name'] = $_POST["nameFaA".$i];
                 $this->passengerArr['passenger_family'] = $_POST["familyFaA".$i];
                 $this->passengerArr['discount_inf_price'] = ($type =='ONEWAY' ?  $_POST["costOffA".$i] : $_POST["costOffReturnA".$i]);
                 $this->passengerArr['percent_discount'] = ($type =='ONEWAY' ?  $_POST["percentA".$i] : $_POST["percentReturnA".$i]);
                 $this->passengerArr['member_id'] = $_SESSION['userId'];
                 $this->passengerArr['member_name'] = $member['name'] .' '.$member['family'];
                 $this->passengerArr['member_mobile'] = $member['mobile'];
                 $this->passengerArr['member_phone'] = $member['telephone'];
                 $this->passengerArr['member_email'] = $member['email'];
                 $this->passengerArr['mobile_buyer'] = $_POST['Mobile_buyer'];
                 $this->passengerArr['email_buyer'] = $_POST['Email'];
                 $this->passengerArr['agency_id'] = $agency_info['id'];
                 $this->passengerArr['agency_name'] = $agency_info['name_fa'];
                 $this->passengerArr['agency_accountant'] = $agency_info['accountant'];
                 $this->passengerArr['agency_manager'] = $agency_info['manager'];
                 $this->passengerArr['agency_mobile'] = $agency_info['phone'];
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
                 $this->passengerArr['FullPrice'] = ($type =='ONEWAY' ?  $_POST["priceAdultA$i"] : $_POST["priceAdultReturnA$i"]);
                 $this->passengerArr['Cost'] = ($type =='ONEWAY' ?  $_POST["priceAdultA$i"] : $_POST["priceAdultReturnA$i"]);
                 $this->passengerArr['CompartmentCapicity'] = $InfoTrain["CompartmentCapicity"];
                 $this->passengerArr['IsCompartment'] = 1;
                 $this->passengerArr['CircularNumberSerial'] = $InfoTrain["CircularNumberSerial"];
                 $this->passengerArr['Adult'] = 1;
                 $this->passengerArr['Child'] = 0;
                 $this->passengerArr['Infant'] = 0;
                 $this->passengerArr['ServiceCode'] = $_POST["ServiceCode"];
                 $this->passengerArr['UniqueId'] = $_POST["UniqueId"];
                 $this->passengerArr['factor_number'] = $this->factorNumber;
                 $this->passengerArr['irantech_commission'] = $it_commission;
                 $this->passengerArr['creation_date'] = date('Y-m-d H:i:s');
                 $this->passengerArr['creation_date_int'] = time();
                 $this->passengerArr['Route_Type'] = ($type == 'ONEWAY') ? '1' : '2';
                 $this->passengerArr['requestNumber'] = ($type =='ONEWAY') ? $_POST['requestNumber']: $_POST['requestNumberReturn'];
                 $this->passengerArr['is_specific'] = (($type =='ONEWAY') && isset($_POST['is_specific_dept']) && trim($_POST['is_specific_dept'])=='yes') ? 'yes' : 'no';
                 $this->passengerArr['serviceTitle'] = (($type =='ONEWAY') && isset($_POST['is_specific_dept']) && trim($_POST['is_specific_dept'])=='yes') ? 'PrivateTrain'  : 'Train';
                 $this->passengerArr['is_registered'] = '0';


                 if ($_POST["serviceA".$i] != '') {
                     $service = explode('##', $_POST["serviceA".$i]);
                     $this->passengerArr['Service'] = $service[0];
                     $this->passengerArr['service_price'] = preg_replace("/[^0-9]/", '', $service[0]);
                     $this->passengerArr['ServiceTypeCode'] = $service[1];
                 }
                 if ($type == 'TOWEWAY') {
                     if($_POST["serviceReturnA".$i] != ''){
                         $service = explode('##', $_POST["serviceReturnA".$i]);
                         $this->passengerArr['Service'] = $service[0];
                         $this->passengerArr['service_price'] = preg_replace("/[^0-9]/", '', $service[0]);
                         $this->passengerArr['ServiceTypeCode'] = $service[1];
                     }
                     $this->passengerArr['is_specific'] = (isset($_POST['is_specific_return']) && trim($_POST['is_specific_return'])=='yes') ? 'yes' : 'no';
                     $this->passengerArr['serviceTitle'] = (isset($_POST['is_specific_return']) && trim($_POST['is_specific_return'])=='yes')? 'PrivateTrain'  : 'Train';
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
                         'passengerNationality' => $_POST["passengerNationalityA".$i]
                     );
                     $passengerController->insert($passengerAddArray);
                 }

                 $condition = (isset($_POST['nameFaA'.$i]) ?  "passenger_national_code='{$this->passengerArr["passenger_national_code"]}'" : "passportNumber ='{$this->passengerArr["passportNumber"]}'");

                 $sql_check_book = " SELECT * FROM book_train_tb WHERE requestNumber='{$this->passengerArr['requestNumber']}' AND {$condition} AND member_id='{$_SESSION["userId"]}'";
                 $book_check = $model->load($sql_check_book);


                 if (empty($book_check)) {
                     $model->setTable('book_train_tb');
                     unset($this->passengerArr['client_id']);
                     $model->insertLocal($this->passengerArr);

                     $this->passengerArr['client_id'] = CLIENT_ID;
                     $modelBase->setTable('report_train_tb');
                     $modelBase->insertLocal($this->passengerArr);
                 }

             }

            if (isset($_POST["CheckCoupe"]) && $_POST["CheckCoupe"] == 1 && $type=='ONEWAY') {
                $this->passengerArr = array();
                for ($i = 1; $i <= $_POST["ExtraPersonCoupe"]; $i++) {
                    $this->passengerArr['passenger_age'] = 'Adt';
                    $this->passengerArr['passenger_gender'] = $_POST["genderA".$i];
                    $this->passengerArr['passenger_name_en'] = $_POST["nameEnA".$i];
                    $this->passengerArr['passenger_family_en'] = $_POST["familyEnA".$i];
                    $this->passengerArr['passenger_birthday_en'] = $_POST["birthdayENA".$i];
                    $this->passengerArr['passenger_birthday'] = $_POST["birthdayA".$i];
                    $this->passengerArr['passenger_national_code'] = $_POST["NationalCodeA".$i];
                    $this->passengerArr['passportCountry'] = $_POST["passportCountryA".$i];
                    $this->passengerArr['passportNumber'] = $_POST["passportNumberA".$i];
                    $this->passengerArr['passportExpire'] = $_POST["passportExpireA".$i];
                    $this->passengerArr['passenger_name'] = $_POST["nameFaA".$i];
                    $this->passengerArr['passenger_family'] = $_POST["familyFaA".$i];
                    $this->passengerArr['member_id'] = $_SESSION['userId'];
                    $this->passengerArr['member_name'] = $member['name'] .' '.$member['family'];
                    $this->passengerArr['member_mobile'] = $member['mobile'];
                    $this->passengerArr['member_phone'] = $member['telephone'];
                    $this->passengerArr['member_email'] = $member['email'];
                    $this->passengerArr['mobile_buyer'] = $_POST['Mobile_buyer'];
                    $this->passengerArr['email_buyer'] = $_POST['Email'];
                    $this->passengerArr['agency_id'] = $agency_info['id'];
                    $this->passengerArr['agency_name'] = $agency_info['name_fa'];
                    $this->passengerArr['agency_accountant'] = $agency_info['accountant'];
                    $this->passengerArr['agency_manager'] = $agency_info['manager'];
                    $this->passengerArr['agency_mobile'] = $agency_info['phone'];
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
                    $this->passengerArr['FullPrice'] = $_POST["TariffPriceCoupe"];
                    $this->passengerArr['Cost'] = $_POST["TariffPriceCoupe"];
                    $this->passengerArr['discount_inf_price'] = $_POST["costOffCoupe"];
                    $this->passengerArr['percent_discount'] = $_POST["percentCoupe"];
                    $this->passengerArr['CompartmentCapicity'] = $InfoTrain["CompartmentCapicity"];
                    $this->passengerArr['IsCompartment'] = 1;
                    $this->passengerArr['CircularNumberSerial'] = $InfoTrain["CircularNumberSerial"];
                    $this->passengerArr['Adult'] = 1;
                    $this->passengerArr['Child'] = 0;
                    $this->passengerArr['Infant'] = 0;
                    $this->passengerArr['ServiceCode'] = $_POST["ServiceCode"];
                    $this->passengerArr['UniqueId'] = $_POST["UniqueId"];
                    $this->passengerArr['factor_number'] = $this->factorNumber;
                    $this->passengerArr['irantech_commission'] = $it_commission;
                    $this->passengerArr['creation_date'] = date('Y-m-d H:i:s');
                    $this->passengerArr['creation_date_int'] = time();
                    $this->passengerArr['extra_chair'] = 1;
                    $this->passengerArr['Route_Type'] = '1' ;
                    $this->passengerArr['requestNumber'] = $_POST['requestNumber'];
                    $this->passengerArr['is_specific'] = (isset($_POST['is_specific_dept']) && trim($_POST['is_specific_dept'])=='yes') ? 'yes' : 'no';
                    $this->passengerArr['serviceTitle'] = (isset($_POST['is_specific_dept']) && trim($_POST['is_specific_dept'])=='yes') ? 'PrivateTrain': 'Train';
                    $this->passengerArr['is_registered'] = '0';

                    $model->setTable('book_train_tb');
                    unset($this->passengerArr['client_id']);
                    $model->insertLocal($this->passengerArr);

                    $passengerArr['client_id'] = CLIENT_ID;
                    $modelBase->setTable('report_train_tb');
                    $modelBase->insertLocal($this->passengerArr);
                }

            }

            if (isset($_POST["CheckCoupeReturn"]) && $_POST["CheckCoupeReturn"] == 1 && $type=='TOWEWAY') {
                $this->passengerArr = array();
                for ($i = 1; $i <= $_POST["ExtraPersonCoupeReturn"]; $i++) {
                    $this->passengerArr['passenger_age'] = 'Adt';
                    $this->passengerArr['passenger_gender'] = $_POST["genderA".$i];
                    $this->passengerArr['passenger_name_en'] = $_POST["nameEnA".$i];
                    $this->passengerArr['passenger_family_en'] = $_POST["familyEnA".$i];
                    $this->passengerArr['passenger_birthday_en'] = $_POST["birthdayEnA".$i];
                    $this->passengerArr['passenger_birthday'] = $_POST["birthdayA".$i];
                    $this->passengerArr['passenger_national_code'] = $_POST["NationalCodeA".$i];
                    $this->passengerArr['passportCountry'] = $_POST["passportCountryA".$i];
                    $this->passengerArr['passportNumber'] = $_POST["passportNumberA".$i];
                    $this->passengerArr['passportExpire'] = $_POST["passportExpireA".$i];
                    $this->passengerArr['passenger_name'] = $_POST["nameFaA".$i];
                    $this->passengerArr['passenger_family'] = $_POST["familyFaA".$i];
                    $this->passengerArr['member_id'] = $_SESSION['userId'];
                    $this->passengerArr['member_name'] = $member['name'].' '.$member['family'];
                    $this->passengerArr['member_mobile'] = $member['mobile'];
                    $this->passengerArr['member_phone'] = $member['telephone'];
                    $this->passengerArr['member_email'] = $member['email'];
                    $this->passengerArr['mobile_buyer'] = $_POST['Mobile_buyer'];
                    $this->passengerArr['email_buyer'] = $_POST['Email'];
                    $this->passengerArr['agency_id'] = $agency_info['id'];
                    $this->passengerArr['agency_name'] = $agency_info['name_fa'];
                    $this->passengerArr['agency_accountant'] = $agency_info['accountant'];
                    $this->passengerArr['agency_manager'] = $agency_info['manager'];
                    $this->passengerArr['agency_mobile'] = $agency_info['phone'];
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
                    $this->passengerArr['FullPrice'] = $_POST["TariffPriceCoupeReturn"];
                    $this->passengerArr['Cost'] = $_POST["TariffPriceCoupeReturn"];
                    $this->passengerArr['discount_inf_price'] = $_POST["costOffCoupeReturn"];
                    $this->passengerArr['percent_discount'] = $_POST["percentCoupeReturn"];
                    $this->passengerArr['CompartmentCapicity'] = $InfoTrain["CompartmentCapicity"];
                    $this->passengerArr['IsCompartment'] = 1;
                    $this->passengerArr['CircularNumberSerial'] = $InfoTrain["CircularNumberSerial"];
                    $this->passengerArr['Adult'] = 1;
                    $this->passengerArr['Child'] = 0;
                    $this->passengerArr['Infant'] = 0;
                    $this->passengerArr['ServiceCode'] = $_POST["ServiceCode"];
                    $this->passengerArr['UniqueId'] = $_POST["UniqueId"];
                    $this->passengerArr['factor_number'] = $this->factorNumber;
                    $this->passengerArr['irantech_commission'] = $it_commission;
                    $this->passengerArr['creation_date'] = date('Y-m-d H:i:s');
                    $this->passengerArr['creation_date_int'] = time();
                    $this->passengerArr['extra_chair'] = 1;
                    $this->passengerArr['Route_Type'] = '2';
                    $this->passengerArr['requestNumber'] = $_POST['requestNumberReturn'];
                    $this->passengerArr['is_specific'] = (isset($_POST['is_specific_return']) &&  trim($_POST['is_specific_return'])=='yes') ? 'yes' : 'no';
                    $this->passengerArr['serviceTitle'] = (isset($_POST['is_specific_return']) && trim($_POST['is_specific_return'])=='yes') ? 'PrivateTrain': 'Train';
                    $this->passengerArr['is_registered'] = '0';
                    $model->setTable('book_train_tb');
                    unset($this->passengerArr['client_id']);
                    $model->insertLocal($this->passengerArr);

                    $passengerArr['client_id'] = CLIENT_ID;

                    $modelBase->setTable('report_train_tb');
                    $modelBase->insertLocal($this->passengerArr);
                }

            }
        }

        if(isset($_POST["nameFaC1"]) || isset($_POST['nameEnC1'])) {
            $this->passengerArr =array();
            for ($i = 1; $i <= $_POST["child"]; $i++) {
                $this->passengerArr['passenger_age'] = 'Chd';
                $this->passengerArr['passenger_gender'] = $_POST["genderC$i"];
                $this->passengerArr['passenger_name_en'] = $_POST["nameEnC$i"];
                $this->passengerArr['passenger_family_en'] = $_POST["familyEnC$i"];
                $this->passengerArr['passenger_birthday_en'] = $_POST["birthdayENC$i"];
                $this->passengerArr['passenger_birthday'] = $_POST["birthdayC$i"];
                $this->passengerArr['passenger_national_code'] = $_POST["NationalCodeC$i"];
                $this->passengerArr['passportCountry'] = $_POST["passportCountryC$i"];
                $this->passengerArr['passportNumber'] = $_POST["passportNumberC$i"];
                $this->passengerArr['passportExpire'] = $_POST["passportExpireC$i"];
                $this->passengerArr['passenger_name'] = $_POST["nameFaC$i"];
                $this->passengerArr['passenger_family'] = $_POST["familyFaC$i"];
                $this->passengerArr['member_id'] = $_SESSION['userId'];
                $this->passengerArr['member_name'] = $member['name'].' '.$member['family'];
                $this->passengerArr['member_mobile'] = $member['mobile'];
                $this->passengerArr['member_phone'] = $member['telephone'];
                $this->passengerArr['member_email'] = $member['email'];
                $this->passengerArr['mobile_buyer'] = $_POST['Mobile_buyer'];
                $this->passengerArr['email_buyer'] = $_POST['Email'];
                $this->passengerArr['agency_id'] = $agency_info['id'];
                $this->passengerArr['agency_name'] = $agency_info['name_fa'];
                $this->passengerArr['agency_accountant'] = $agency_info['accountant'];
                $this->passengerArr['agency_manager'] = $agency_info['manager'];
                $this->passengerArr['agency_mobile'] = $agency_info['phone'];
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
                $this->passengerArr['FullPrice'] = ($type =='ONEWAY' ?  $_POST["priceChildC$i"] : $_POST["priceChildReturnC$i"]);
                $this->passengerArr['Cost'] = ($type =='ONEWAY' ?  $_POST["priceChildC$i"] : $_POST["priceChildReturnC$i"]);
                $this->passengerArr['discount_inf_price'] = ($type =='ONEWAY' ?  $_POST["costOffC".$i] : $_POST["costOffReturnC".$i]);
                $this->passengerArr['percent_discount'] = ($type =='ONEWAY' ?  $_POST["percentC".$i] : $_POST["percentReturnC".$i]);
                $this->passengerArr['CompartmentCapicity'] = $InfoTrain["CompartmentCapicity"];
                $this->passengerArr['IsCompartment'] = 1;
                $this->passengerArr['CircularNumberSerial'] = $InfoTrain["CircularNumberSerial"];
                $this->passengerArr['Adult'] =0 ;
                $this->passengerArr['Child'] = 1;
                $this->passengerArr['Infant'] = 0;
                $this->passengerArr['ServiceCode'] = $_POST["ServiceCode"];
                $this->passengerArr['UniqueId'] = $_POST["UniqueId"];
                $this->passengerArr['factor_number'] = $this->factorNumber;
                $this->passengerArr['irantech_commission'] = $it_commission;
                $this->passengerArr['creation_date'] = date('Y-m-d H:i:s');
                $this->passengerArr['creation_date_int'] = time();
                $this->passengerArr['requestNumber'] = ($type =='ONEWAY') ? $_POST['requestNumber']: $_POST['requestNumberReturn'];
                $this->passengerArr['Route_Type'] = ($type == 'ONEWAY') ? '1' : '2';
                $this->passengerArr['is_specific'] = (isset($_POST['is_specific_dept']) && trim($_POST['is_specific_dept'])=='yes') ? 'yes' : 'no';
                $this->passengerArr['serviceTitle'] = (isset($_POST['is_specific_dept']) && trim($_POST['is_specific_dept'])=='yes') ? 'PrivateTrain': 'Train';
                $this->passengerArr['is_registered'] = '0';
                if($_POST["serviceC$i"]!=''){
                    $service = explode('##',$_POST["serviceC$i"]);
                    $this->passengerArr['Service'] = $service[0];
                    $this->passengerArr['service_price'] =preg_replace("/[^0-9]/", '', $service[0]);
                    $this->passengerArr['ServiceTypeCode'] = $service[1];
                }

                if($type == 'TOWEWAY'){
                    if($_POST["serviceReturnC$i"]!='')
                    {
                        $service = explode('##',$_POST["serviceReturnC$i"]);
                        $this->passengerArr['Service'] = $service[0];
                        $this->passengerArr['service_price'] =preg_replace("/[^0-9]/", '', $service[0]);
                        $this->passengerArr['ServiceTypeCode'] = $service[1];
                    }
                    $this->passengerArr['is_specific'] = (isset($_POST['is_specific_return']) && trim($_POST['is_specific_return'])=='yes') ? 'yes' : 'no';
                    $this->passengerArr['serviceTitle'] =(isset($_POST['is_specific_return']) && trim($_POST['is_specific_return'])=='yes') ? 'PrivateTrain' : 'Train';
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
                $condition = (isset($_POST['nameFaC'.$i]) ?  "passenger_national_code='{$this->passengerArr["passenger_national_code"]}'" : "passportNumber ='{$this->passengerArr["passportNumber"]}'");

                $sql_check_book = " SELECT * FROM book_train_tb WHERE requestNumber='{$this->passengerArr['requestNumber']}' AND {$condition} AND member_id='{$_SESSION["userId"]}'";
                $book_check = $model->load($sql_check_book);


                if (empty($book_check)) {
                    $model->setTable('book_train_tb');
                    unset($this->passengerArr['client_id']);
                    $model->insertLocal($this->passengerArr);


                    $this->passengerArr['client_id'] = CLIENT_ID;
                    $modelBase->setTable('report_train_tb');
                    $modelBase->insertLocal($this->passengerArr);
                }

            }




        }

        if(isset($_POST["nameFaI1"]) || isset($_POST["nameEnI1"])) {
            $this->passengerArr =array();
            for ($i = 1; $i <= $_POST["infant"]; $i++) {
                $this->passengerArr['passenger_age'] = 'Inf';
                $this->passengerArr['passenger_gender'] = $_POST["genderI$i"];
                $this->passengerArr['passenger_name_en'] = $_POST["nameEnI$i"];
                $this->passengerArr['passenger_family_en'] = $_POST["familyEnI$i"];
                $this->passengerArr['passenger_birthday_en'] = $_POST["birthdayENI$i"];
                $this->passengerArr['passenger_birthday'] = $_POST["birthdayI$i"];
                $this->passengerArr['passenger_national_code'] = $_POST["NationalCodeI$i"];
                $this->passengerArr['passportCountry'] = $_POST["passportCountryI$i"];
                $this->passengerArr['passportNumber'] = $_POST["passportNumberI$i"];
                $this->passengerArr['passportExpire'] = $_POST["passportExpireI$i"];
                $this->passengerArr['passenger_name'] = $_POST["nameFaI$i"];
                $this->passengerArr['passenger_family'] = $_POST["familyFaI$i"];
                $this->passengerArr['discount_inf_price'] = 0;
                $this->passengerArr['percent_discount'] = 0;
                $this->passengerArr['member_id'] = $_SESSION['userId'];
                $this->passengerArr['member_name'] = $member['name'].' '.$member['family'];
                $this->passengerArr['member_mobile'] = $member['mobile'];
                $this->passengerArr['member_phone'] = $member['telephone'];
                $this->passengerArr['member_email'] = $member['email'];
                $this->passengerArr['mobile_buyer'] = $_POST['Mobile_buyer'];
                $this->passengerArr['email_buyer'] = $_POST['Email'];
                $this->passengerArr['agency_id'] = $agency_info['id'];
                $this->passengerArr['agency_name'] = $agency_info['name_fa'];
                $this->passengerArr['agency_accountant'] = $agency_info['accountant'];
                $this->passengerArr['agency_manager'] = $agency_info['manager'];
                $this->passengerArr['agency_mobile'] = $agency_info['phone'];
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
                $this->passengerArr['FullPrice'] = ($type =='ONEWAY' ?  $_POST["priceInfantI$i"] : $_POST["priceInfantReturnI$i"]);
                $this->passengerArr['Cost'] = ($type =='ONEWAY' ?  $_POST["priceInfantI$i"] : $_POST["priceInfantReturnI$i"]);
                $this->passengerArr['CompartmentCapicity'] = $InfoTrain["CompartmentCapicity"];
                $this->passengerArr['IsCompartment'] = 1;
                $this->passengerArr['CircularNumberSerial'] = $InfoTrain["CircularNumberSerial"];
                $this->passengerArr['Adult'] = 0;
                $this->passengerArr['Child'] = 0;
                $this->passengerArr['Infant'] = 1;
                $this->passengerArr['ServiceCode'] = $_POST["ServiceCode"];
                $this->passengerArr['UniqueId'] = $_POST["UniqueId"];
                $this->passengerArr['factor_number'] = $this->factorNumber;
                $this->passengerArr['irantech_commission'] = $it_commission;
                $this->passengerArr['creation_date'] = date('Y-m-d H:i:s');
                $this->passengerArr['creation_date_int'] = time();
                $this->passengerArr['Route_Type'] = ($type == 'ONEWAY') ? '1' : '2';
                $this->passengerArr['requestNumber'] = ($type =='ONEWAY') ? $_POST['requestNumber']: $_POST['requestNumberReturn'];
                $this->passengerArr['is_specific'] = (isset($_POST['is_specific_dept']) && trim($_POST['is_specific_dept'])=='yes') ? 'yes' : 'no';
                $this->passengerArr['serviceTitle'] = (isset($_POST['is_specific_dept']) && trim($_POST['is_specific_dept'])=='yes') ? 'PrivateTrain': 'Train';
                $this->passengerArr['is_registered'] = '0';
                if($type == 'TOWEWAY'){
                    if($_POST["serviceReturnI$i"]!='')
                    {
                        $service = explode('##',$_POST["serviceReturnC$i"]);
                        $this->passengerArr['Service'] = $service[0];
                        $this->passengerArr['service_price'] =preg_replace("/[^0-9]/", '', $service[0]);
                        $this->passengerArr['ServiceTypeCode'] = $service[1];
                    }
                    $this->passengerArr['is_specific'] = (isset($_POST['is_specific_return']) && trim($_POST['is_specific_return'])=='yes') ? 'yes' : 'no';
                    $this->passengerArr['serviceTitle'] =(isset($_POST['is_specific_return']) && trim($_POST['is_specific_return'])=='yes') ? 'PrivateTrain' : 'Train';
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
                $condition = (isset($_POST['nameFaI'.$i]) ?  "passenger_national_code='{$this->passengerArr["passenger_national_code"]}'" : "passportNumber ='{$this->passengerArr["passportNumber"]}'");

                $sql_check_book = " SELECT * FROM book_train_tb WHERE requestNumber='{$this->passengerArr['requestNumber']}' AND {$condition} AND member_id='{$_SESSION["userId"]}'";
                $book_check = $model->load($sql_check_book);


                if (empty($book_check)) {
                    $model->setTable('book_train_tb');
                    unset($this->passengerArr['client_id']);
                    $model->insertLocal($this->passengerArr);


                    $this->passengerArr['client_id'] = CLIENT_ID;
                    $modelBase->setTable('report_train_tb');
                    $modelBase->insertLocal($this->passengerArr);
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

    public function getTotalPriceByFactorNumber($factorNumber){
        $Model = Load::library('Model');

        $sql_query ="SELECT * FROM book_train_tb WHERE passenger_factor_num = '{$factorNumber}' ";

        return $Model->load($sql_query);
    }

    public function getPassengerList($requestNumber,$serviceCode)
    {
	    /** @var bookTrainModel $bookTrainModel */
	    $bookTrainModel = Load::getModel('bookTrainModel');
	    $listPassenger = $bookTrainModel->get()->where('requestNumber',$requestNumber)->where('ServiceCode',$serviceCode)->where('extra_chair','1','!=')->all();
	    foreach ($listPassenger as $Passenger){
            $ServicePrice = preg_replace("/[^0-9]/", '', $Passenger['Service']);
            $price= ($Passenger['Cost']-$Passenger['discount_inf_price']) +  $ServicePrice;
            $this->totalPrice += ($price/*- $discountPrice['costOff']*/);
        }

        return $listPassenger;
    }
}


