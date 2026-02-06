<?php
error_reporting(0);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
//print_r($_POST);
/**
 * Class factorGasht
 * @property factorGasht $factorGasht
 */
class factorGasht extends apiGashtTransfer
{


    public $passengerArr = array(); // Specifications of adult
    public $passengerArr1 = array(); // Specifications of adult
    public $time_remmaining;
    public $IdMember;
    public $IsLogin;
    public $CounterId;
    public $Source_ID;
    public $serviceTitle = '';
    public $factor_number;

    public function __construct()
    {

        $this->IsLogin = Session::IsLogin();
        $this->IdMember = $_POST['IdMember'];
        $this->serviceTitle =$this->serviceTypeCheck($_POST['passenger_serviceRequestType']);
        $this->factor_number =$_POST['factorNumber'];


//        $this->serviceTitle = parent::serviceTypeCheck($_POST['source_name']);
    }

    public function registerPassengersGasht()
    {
        $result = Session::IsLogin();

       $factorNumber = $_POST['factorNumber'];
        $model = Load::library('Model');
        $modelBase = Load::library('ModelBase');
        $passengerController = Load::controller('passengers');
        $SqlMember = "SELECT * FROM members_tb WHERE id='{$_SESSION["userId"]}'";
        $member = $model->load($SqlMember);
        $SqlAgency = "SELECT * FROM agency_tb WHERE id='{$member['fk_agency_id']}'";
        $agency_info = $model->load($SqlAgency);
        $gashtPriceChanges = Load::controller('gashtPriceChanges');
        $priceChanges = $gashtPriceChanges->getByCounter($member['fk_counter_type_id']);
        if(ISCURRENCY && $_POST["CurrencyCode"] > 0){
            $Currency = Load::controller('currencyEquivalent');
            $InfoCurrency = $Currency->InfoCurrency($_POST['CurrencyCode']);
        }
        if(isset($_POST["nameFaG1"])) {

            $this->passengerArr['passenger_gender'] = $_POST["genderG1"];
            $this->passengerArr['passenger_nameEn'] = $_POST["nameEnG1"];
            $this->passengerArr['passenger_familyEn'] = $_POST["familyEnG1"];
            $this->passengerArr['passenger_birthday'] = $_POST["birthdayG1"];
            $this->passengerArr['passenger_NationalCode'] = $_POST["NationalCodeG1"];
            $this->passengerArr['passenger_passportCountry'] = $_POST["passportCountryG1"];
            $this->passengerArr['passenger_passportNumber'] = $_POST["passportNumberG1"];
            $this->passengerArr['passenger_passportExpire'] = $_POST["passportExpireG1"];
            $this->passengerArr['passenger_name'] = $_POST["nameFaG1"];
            $this->passengerArr['passenger_family'] = $_POST["familyFaG1"];
            $this->passengerArr['passenger_mobile'] = $_POST["buyerCompanionCellPhone"];
            $this->passengerArr['buyer_mobile'] = $_POST["buyerCompanionCellPhone"];
            $this->passengerArr['passenger_number'] = $_POST["peoplesG1"];
            $this->passengerArr['passenger_email'] = $_POST["Email"];
            $this->passengerArr['passenger_HotelName'] = $_POST["buyerHotelName"];
            $this->passengerArr['passenger_HotelAddress'] = $_POST["buyerHotelAddress"];
            $this->passengerArr['passenger_entryDate'] = $_POST["entryDate"];
            $this->passengerArr['passenger_departureDate'] = $_POST["departureDate"];
            $this->passengerArr['passenger_travelVehicle'] = $_POST["travelVehicle"];
            $this->passengerArr['passenger_orginCity'] = $_POST["orginCity"];
            $this->passengerArr['passenger_startTime'] = $_POST["startTime"];
            $this->passengerArr['passenger_endTime'] = $_POST["endTime"];
            if ($_POST["travelVehicle"] == 'bus') {
                $this->passengerArr['passenger_Voucher'] = '';
            } else {
                $this->passengerArr['passenger_Voucher'] = $_POST["trainOrAierplaneVoucher"];
            }
//            $this->adultArr[$i]['member_id '] = $_POST["IdMember"];
            $this->passengerArr['passenger_serviceName'] = $_POST["serviceName"];
            $this->passengerArr['passenger_serviceId'] = $_POST["serviceId"];
            $this->passengerArr['passenger_serviceComment'] = $_POST["serviceComment"];
            $this->passengerArr['passenger_servicePrice'] = $_POST["servicePrice"];
            $this->passengerArr['passenger_serviceDiscount'] = $_POST["serviceDiscount"];
            $this->passengerArr['passenger_servicePriceAfterOff'] = $_POST["servicePriceAfterOff"];
            $this->passengerArr['passenger_serviceRequestDate'] = $_POST["serviceRequestDate"];
            $this->passengerArr['passenger_serviceCityName'] = $_POST["serviceCityName"];
            $this->passengerArr['passenger_serviceRequestType'] = $_POST["serviceRequestType"];
            $this->passengerArr['passenger_serviceCityId'] = $_POST["serviceCityId"];
            $this->passengerArr['member_id'] = $_SESSION['userId'];
            $this->passengerArr['member_name'] = $member['name'];
            $this->passengerArr['member_mobile'] = $member['mobile'];
            $this->passengerArr['member_phone'] = $member['telephone'];
            $this->passengerArr['member_email'] = $member['email'];
            $this->passengerArr['agency_id'] = $agency_info['id'];
            $this->passengerArr['agency_name'] = $agency_info['name_fa'];
            $this->passengerArr['agency_accountant'] = $agency_info['accountant'];
            $this->passengerArr['agency_manager'] = $agency_info['manager'];
            $this->passengerArr['agency_mobile'] = $agency_info['phone'];
            $this->passengerArr['passenger_factor_num'] = $factorNumber;
            $this->passengerArr['encryptData'] =$_POST["encryptData"];
            $this->passengerArr['currency_code'] = $_POST["CurrencyCode"];
            $this->passengerArr['creation_date'] = date('Y-m-d H:i:s');
            $this->passengerArr['creation_date_int'] = time();
            if($priceChanges['changeType']=='cost'){
                $this->passengerArr['agency_commission']=$priceChanges['price'];
            }else{
                $this->passengerArr['agency_commission']=($priceChanges['price']*$_POST["servicePriceAfterOff"])/100;
            }
            if(!empty($priceChanges)){
                $this->passengerArr['price_change'] = $priceChanges['price'];
                $this->passengerArr['price_change_type'] = $priceChanges['changeType'];
            }
            $this->passengerArr['currency_equivalent'] = !empty($InfoCurrency) ? $InfoCurrency['EqAmount'] : '0';
//            $this->adultArr[$i]['Mobile_buyer'] = isset($_POST["Mobile_buyer"]) ? $_POST["Mobile_buyer"] : $_POST["Mobile"];
//            $this->adultArr[$i]['Email_buyer'] = isset($_POST["Email_buyer"]) ? $_POST["Email_buyer"] : $_POST["Email"];

            if ($result) {
                $passengerAddArray = array(
                    'passengerName' => $this->passengerArr['passenger_name'],
                    'passengerNameEn' => $this->passengerArr['passenger_nameEn'],
                    'passengerFamily' => $this->passengerArr['passenger_family'],
                    'passengerFamilyEn' =>$this->passengerArr['passenger_familyEn'],
                    'passengerGender' => $this->passengerArr['passenger_gender'],
                    'passengerBirthday' => $this->passengerArr['passenger_birthday'],
                    'passengerNationalCode' => $this->passengerArr['passenger_NationalCode'],
                    'passengerBirthdayEn' => $this->passengerArr['passenger_birthday'],
                    'passengerPassportCountry' => $this->passengerArr['passenger_passportCountry'],
                    'passengerPassportNumber' => $this->passengerArr['passenger_passportNumber'],
                    'passengerPassportExpire' => $this->passengerArr['passenger_passportExpire'],
                    'memberID' => $this->passengerArr['fk_members_tb_id'],
                    'passengerNationality' => $_POST["passengerNationalityG1"]
                );
                $passengerController->insert($passengerAddArray);
            }
            if($_POST["serviceRequestType"]==0){
                $serviceTitle = 'LocalGasht';
            } else{
                $serviceTitle = 'LocalTransfer';
            }
            $irantechCommission = Load::controller('irantechCommission');
            $it_commission = $irantechCommission->getCommission($serviceTitle, '8');

            $this->passengerArr1['serviceTitle'] = $serviceTitle;
            $this->passengerArr1['irantech_commission'] = $it_commission;
            $this->passengerArr1['passenger_gender'] = $_POST["genderG1"];
            $this->passengerArr1['passenger_name'] = $_POST["nameFaG1"];
            $this->passengerArr1['passenger_name_en'] = $_POST["nameEnG1"];
            $this->passengerArr1['passenger_family'] = $_POST["familyFaG1"];
            $this->passengerArr1['passenger_family_en'] =$_POST["familyEnG1"];
            $this->passengerArr1['passenger_birthday'] = $_POST["birthdayG1"];
            $this->passengerArr1['passenger_national_code'] = $_POST["NationalCodeG1"];
            $this->passengerArr1['passportCountry'] = $_POST["passportCountryG1"];
            $this->passengerArr1['passportNumber'] = $_POST["passportNumberG1"];
            $this->passengerArr1['passportExpire'] = $_POST["passportExpireG1"];
            $this->passengerArr1['member_id'] =  $_SESSION['userId'];
            $this->passengerArr1['member_name'] = $member['name'];
            $this->passengerArr1['member_mobile'] = $member['mobile'];
            $this->passengerArr1['member_phone'] = $member['telephone'];
            $this->passengerArr1['member_email'] = $member['email'];
            $this->passengerArr1['agency_id'] = $agency_info['id'];
            $this->passengerArr1['agency_name'] = $agency_info['name_fa'];
            $this->passengerArr1['agency_accountant'] = $agency_info['accountant'];
            $this->passengerArr1['agency_manager'] =  $agency_info['manager'];
            $this->passengerArr1['agency_mobile'] =  $agency_info['phone'];
            $this->passengerArr1['passenger_mobile'] = $_POST["buyerCompanionCellPhone"];
            $this->passengerArr1['buyer_mobile'] = $_POST["buyerCompanionCellPhone"];
            $this->passengerArr1['passenger_number'] = $_POST["peoplesG1"];
            $this->passengerArr1['passenger_email'] = $_POST["Email"];
            $this->passengerArr1['passenger_HotelName'] = $_POST["buyerHotelName"];
            $this->passengerArr1['passenger_HotelAddress'] = $_POST["buyerHotelAddress"];
            $this->passengerArr1['passenger_entryDate'] =  $_POST["entryDate"];
            $this->passengerArr1['passenger_departureDate'] =  $_POST["departureDate"];
            $this->passengerArr1['passenger_travelVehicle'] =  $_POST["travelVehicle"];
            $this->passengerArr1['passenger_orginCity'] = $_POST["orginCity"];
            $this->passengerArr1['passenger_startTime'] = $_POST["startTime"];
            $this->passengerArr1['passenger_endTime'] = $_POST["endTime"];
            $this->passengerArr1['passenger_Voucher'] = $_POST["trainOrAierplaneVoucher"];
            $this->passengerArr1['passenger_serviceName'] = $_POST["serviceName"];
            $this->passengerArr1['passenger_serviceId'] = $_POST["serviceId"];
            $this->passengerArr1['passenger_serviceComment'] = $_POST["serviceComment"];
            $this->passengerArr1['passenger_servicePrice'] = $_POST["servicePrice"];
            $this->passengerArr1['passenger_serviceDiscount'] = $_POST["serviceDiscount"];
            $this->passengerArr1['passenger_servicePriceAfterOff'] = $_POST["servicePriceAfterOff"];
            $this->passengerArr1['passenger_serviceRequestDate'] = $_POST["serviceRequestDate"];
            $this->passengerArr1['passenger_serviceCityName'] = $_POST["serviceCityName"];
            $this->passengerArr1['passenger_serviceRequestType'] = $_POST["serviceRequestType"];
            $this->passengerArr1['passenger_factor_num'] = $factorNumber;
            $this->passengerArr1['encryptData'] =$_POST["encryptData"];
            $this->passengerArr1['currency_code'] = $_POST["CurrencyCode"];
            $this->passengerArr1['currency_equivalent'] = !empty($InfoCurrency) ? $InfoCurrency['EqAmount'] : '0';
            $this->passengerArr1['creation_date'] = date('Y-m-d H:i:s');
            $this->passengerArr1['creation_date_int'] = time();
            if($priceChanges['changeType']=='cost'){
                $this->passengerArr1['agency_commission']=$priceChanges['price'];
            }else{
                $this->passengerArr1['agency_commission']=($priceChanges['price']*$_POST["servicePriceAfterOff"])/100;
            }

            if(!empty($priceChanges)){
                $this->passengerArr1['price_change'] = $priceChanges['price'];
                $this->passengerArr1['price_change_type'] = $priceChanges['changeType'];
            }
        }



     $sql_check_book = " SELECT * FROM book_gasht_local_tb WHERE passenger_factor_num='{$factorNumber}' AND member_id='{$_SESSION['userId']}'";
        $book_check = $model->load($sql_check_book);



        if (empty($book_check)) {
            $model->setTable('book_gasht_local_tb');
            $model->insertLocal($this->passengerArr1);

            $modelBase->setTable('report_gasht_tb');
            $modelBase->insertLocal($this->passengerArr1);
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
    #region serviceTypeCheck
    public function serviceTypeCheck($RequestType)
    {


        if ($RequestType == 0) {
            return 'LocalGasht';
        } elseif ($RequestType== 1) {
            return 'LocalTransfer';
        }

    }
    #endregion
    public function getTotalPriceByFactorNumber($factorNumber){
        $Model = Load::library('Model');

       $sql_query ="SELECT * FROM book_gasht_local_tb WHERE passenger_factor_num = '{$factorNumber}' ";

        return $Model->load($sql_query);
    }
}


