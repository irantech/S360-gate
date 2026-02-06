<?php
/**
 * Class factorInsurance
 * @property factorInsurance $factorInsurance
 */
class factorInsurance extends insurance {

    public $data =[];
    public $Adt_qty = 0;
    public $Chd_qty = 0;
    public $Inf_qty = 0;
    public $IsLogin;
    public $factor_number;
    public $source_name_fa = '';
    public $serviceTitle = '';

    #region construct get posts and put it into an associative array
    public function __construct() {


        $this->IsLogin = Session::IsLogin();
        $this->factor_number = substr(time(), 0, 4) . mt_rand(00000, 99999) . substr(time(), 6, 10);
        $this->source_name_fa = parent::getInsuranceName($_POST['source_name']);
        $this->serviceTitle = parent::serviceTypeCheck($_POST['source_name']);
        $count = $_POST['count'];
        $i = 1;

        while (!empty($_POST["gender" . $i])) {

            if($_POST["passenger_age" . $i] == 'Adt'){
                $this->Adt_qty++;
            } elseif($_POST["passenger_age" . $i] == 'Chd'){
                $this->Chd_qty++;
            } elseif($_POST["passenger_age" . $i] == 'Inf'){
                $this->Inf_qty++;
            }

            $this->data['info'][$i]['factor_number']                 =      $this->factor_number;
            $this->data['info'][$i]['passengerNationality']          =      $_POST["passengerNationality". $i];
            $this->data['info'][$i]['passenger_gender']              =      $_POST["gender". $i];
            $this->data['info'][$i]['passenger_name']                =      $_POST["nameFa". $i];
            $this->data['info'][$i]['passenger_name_en']             =      $_POST["nameEn" . $i];
            $this->data['info'][$i]['passenger_family']              =      $_POST["familyFa" . $i];
            $this->data['info'][$i]['passenger_family_en']           =      $_POST["familyEn" . $i];
            if(empty($_POST["birthday" . $i])) {
                $this->data['info'][$i]['passenger_birth_date']      =      functions::ConvertToJalali($_POST["birthdayEn" . $i]);
            }else{
                $this->data['info'][$i]['passenger_birth_date']      =      $_POST["birthday" . $i];
            }
            if(empty($_POST["birthdayEn" . $i])) {
                $this->data['info'][$i]['passenger_birth_date_en']   =     functions::ConvertToMiladi($_POST["birthday" . $i]);
            }else{
                $this->data['info'][$i]['passenger_birth_date_en']   =      $_POST["birthdayEn" . $i];
            }

            $this->data['info'][$i]['passenger_national_code']       =      $_POST["NationalCode" . $i];
            $this->data['info'][$i]['passport_number']               =      $_POST["passportNumber" . $i];
            $this->data['info'][$i]['passportExpire']                =      isset($_POST["passportExpire" . $i]) ? $_POST["passportExpire" . $i] : '';
            $this->data['info'][$i]['passportCountry']               =      isset($_POST["passportCountry" . $i]) ? $_POST["passportCountry" . $i] : '';
            $this->data['info'][$i]['passenger_age']                 =      $_POST["passenger_age" . $i];
            $this->data['info'][$i]['visa_type']                     =      $_POST["visaType" . $i];
            $this->data['info'][$i]['insurance_baseprice']           =      $_POST["insurance_baseprice" . $i];
            $this->data['info'][$i]['paid_price']                    =      $_POST["paid_price" . $i];
            $this->data['info'][$i]['discount_percentage']           =      $_POST["discount_percentage" . $i];
            $this->data['info'][$i]['insurance_tax']                 =      $_POST["insurance_tax" . $i];
            $this->data['info'][$i]['api_commission']                =      $_POST["api_commission" . $i];
            $this->data['info'][$i]['mobile_buyer']                  =      isset($_POST["Mobile_buyer"]) ? $_POST["Mobile_buyer"] : $_POST["Mobile"];
            $this->data['info'][$i]['email_buyer']                   =      isset($_POST["Email_buyer"]) ? $_POST["Email_buyer"] : $_POST["Email"];
            $this->data['info'][$i]['tel_buyer']                     =      isset($_POST["Telephone"]) ? $_POST["Telephone"] : '';
            $this->data['info'][$i]['destination']                   =      $_POST["destination"];
            $this->data['info'][$i]['destination_iata']              =      $_POST["destination_iata"];
            $this->data['info'][$i]['origin']                        =      $_POST["origin"];
            $this->data['info'][$i]['origin_iata']                   =      $_POST["origin_iata"];
            $this->data['info'][$i]['duration']                      =      $_POST["num_day"];
            $this->data['info'][$i]['source_name']                   =      $_POST["source_name"];
            $this->data['info'][$i]['source_name_fa']                =      $this->source_name_fa;
            $this->data['info'][$i]['zone_code']                     =      $_POST["zone_code"];
            $this->data['info'][$i]['caption']                       =      $_POST["caption"];
            $this->data['info'][$i]['serviceTitle']                  =      $this->serviceTitle;
            $this->data['IdMember']                                  =      $_POST["IdMember"];
            $this->data['CurrencyCode']                              =      $_POST["CurrencyCode"];

            $i++;
        }

    }
    #endregion

    #region insert books into table
    public function bookInsert() {

//        echo json_encode($this->data);
//        die;



        $Model = Load::library('Model');
        $query = "SELECT * FROM members_tb WHERE id='{$this->data['IdMember']}'";
        $user = $Model->load($query);

        $irantechCommission = Load::controller('irantechCommission');
        $insurancePriceChanges = Load::controller('insurancePriceChanges');
        $priceChanges = $insurancePriceChanges->getByCounter($user['fk_counter_type_id']);

        if(ISCURRENCY && $this->data['CurrencyCode'] > 0){
            $Currency = Load::controller('currencyEquivalent');
            $InfoCurrency = $Currency->InfoCurrency($this->data['CurrencyCode']);
        }

        $passengerController = Load::controller('passengers');

        foreach ($this->data['info'] as $data){
            $record = array();

            $passenger_name = !empty($data['passenger_name']) ? $data['passenger_name'] : $data['passenger_name_en'];
            $passenger_family = !empty($data['passenger_family']) ? $data['passenger_family'] : $data['passenger_name_en'];

            $record['factor_number']               = $data['factor_number'];
            $record['passenger_gender']            = $data['passenger_gender'];
            $record['passenger_name']              = $passenger_name;
            $record['passenger_name_en']           = $data['passenger_name_en'];
            $record['passenger_family']            = $passenger_family;
            $record['passenger_family_en']         = $data['passenger_family_en'];
            $record['passenger_birth_date']        = $data['passenger_birth_date'];
            $record['passenger_birth_date_en']     = $data['passenger_birth_date_en'];
            $record['passenger_national_code']     = $data['passenger_national_code'];
            $record['passport_number']             = $data['passport_number'];
            $record['passenger_age']               = $data['passenger_age'];
            $record['visa_type']                   = $data['visa_type'];
            $record['mobile_buyer']                = $data['mobile_buyer'];
            $record['email_buyer']                 = $data['email_buyer'];
            $record['tel_buyer']                   = $data['tel_buyer'];
            $record['destination']                 = $data['destination'];
            $record['origin']                      = $data['origin'];
            $record['zone_code']                   = $data['zone_code'];
            $record['caption']                     = $data['caption'];
            $record['destination_iata']            = $data['destination_iata'];
            $record['origin_iata']                 = $data['origin_iata'];
            $record['duration']                    = $data['duration'];
            $record['source_name']                 = $data['source_name'];
            $record['source_name_fa']              = $data['source_name_fa'];
            $record['base_price']                  = $data['insurance_baseprice'];
            $record['discount_percentage']                  = $data['discount_percentage'];
            $record['paid_price']                  = $data['paid_price'];
            $record['tax']                         = $data['insurance_tax'];
            $record['api_commission']              = $data['api_commission'];
            if($data['serviceTitle']=='PublicPortalInsurance'){
                $it_commission = $irantechCommission->getCommission($data['serviceTitle'], '4');
            }else if($data['serviceTitle']=='PrivateLocalInsurance') {
                $it_commission = $irantechCommission->getCommission($data['serviceTitle'], '4');
            }
            $record['irantech_commission']         = $it_commission;
            $record['agency_commission']           = parent::getAgencyCommission($data['source_name'],$data['insurance_baseprice'],$data['api_commission']);
            $record['serviceTitle']                = $data['serviceTitle'];
            $record['creation_date']               = date('Y-m-d H:i:s');
            $record['creation_date_int']           = time();
            $record['currency_code']               = $this->data['CurrencyCode'];
            $record['currency_equivalent']         = !empty($InfoCurrency) ? $InfoCurrency['EqAmount'] : '0';

            $record['member_id']                  = $user['id'];
            $record['member_name']                = $user['name'] . ' ' . $user['family'];
            $record['member_mobile']              = $user['mobile'];
            $record['member_email']               = $user['email'];
            $record['agency_id']               = $user['fk_agency_id'];
//        if(  $_SERVER['REMOTE_ADDR']=='5.201.144.255'  ) {
//            var_dump('aaaa');
//            echo json_encode($record);
//            var_dump('bbbb');
//            die;
//        }

            #region insert passenger
            if($user['is_member'] == '1'){

                $passengerAddArray = array(
                    'passengerName' => $record['passenger_name'],
                    'passengerNameEn' => $record['passenger_name_en'],
                    'passengerFamily' => $record['passenger_family'],
                    'passengerFamilyEn' => $record['passenger_family_en'],
                    'passengerGender' => $record['passenger_gender'],
                    'passengerBirthday' => $record['passenger_birth_date'],
                    'passengerNationalCode' => $record['passenger_national_code'],
                    'passengerBirthdayEn' => $record['passenger_birth_date_en'],
                    'passengerPassportCountry' => $data['passportCountry'],
                    'passengerPassportNumber' => $record['passport_number'],
                    'passengerPassportExpire' => $data['passportExpire'],
                    'memberID' => $user['id'],
                    'passengerNationality' => $data['passengerNationality']
                );
            
                $passengerController->insert($passengerAddArray);

            }
            #endregion

            if(!empty($priceChanges)){
                $record['price_change'] = $priceChanges['price'];
                $record['price_change_type'] = $priceChanges['changeType'];
            }
          
            $Model->setTable('book_insurance_tb');
            $res = $Model->insertLocal($record);

            if ($res) {
                $record['client_id'] = CLIENT_ID;
                $record['remote_addr'] = $_SERVER['REMOTE_ADDR'];

                Load::autoload('ModelBase');
                $ModelBase = new ModelBase();
                
                $ModelBase->setTable('report_insurance_tb');
                $ModelBase->insertLocal($record);
               
            }

        }

    }
    #endregion

    #region get agency credit
    public function CreditCustomer()
    {
        Load::autoload('Model');
        $Model = new Model();

        if ($this->IsLogin) {

            Load::autoload('Model');
            $creditModel = new Model();
            $SqlMember = "SELECT * FROM members_tb WHERE id='{$_SESSION["userId"]}'";

            $member = $Model->load($SqlMember);

            $agencyID = $member['fk_agency_id'];

            $sql_charge = "SELECT sum(credit) AS total_charge FROM credit_detail_tb WHERE type='increase' AND fk_agency_id='{$agencyID}'";
            $charge = $creditModel->load($sql_charge);
            $total_charge = $charge['total_charge'];

            $sql_buy = "SELECT sum(credit) AS total_buy FROM credit_detail_tb WHERE type='decrease' AND fk_agency_id='{$agencyID}'";
            $buy = $creditModel->load($sql_buy);
            $total_buy = $buy['total_buy'];

            $total_transaction = $total_charge - $total_buy;
            return $total_transaction;

        }
    }
    #endregion

}
?>
