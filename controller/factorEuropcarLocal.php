<?php

class factorEuropcarLocal extends apiEuropcarLocal
{
    public $carBookingInfo = array();
    public $thingInfo = array();
    public $IsLogin ;
    public $counterId ;
    public $serviceDiscountLocal = array() ;
    public $error ;
    public $errorMessage ;



    public function __construct()
    {
        $this->IsLogin = Session::IsLogin();
        if ($this->IsLogin){
            $this->counterId = functions::getCounterTypeId($_SESSION['userId']);
            $this->serviceDiscountLocal = functions::ServiceDiscount($this->counterId, 'LocalEuropcar');
            //$this->serviceDiscountPortal = functions::ServiceDiscount($this->counterId, 'PortalEuropcar');
            if (!empty($this->serviceDiscountLocal)){
                $this->serviceDiscountLocal['off_percent'] = round($this->serviceDiscountLocal['off_percent']);
            }
        }else {
            $this->counterId = '5';
        }

    }

    public function registerPassengers()
    {

        $factorNumber = $_POST['factorNumber'];
        $idMember = $_POST['IdMember'];

        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $passengerController = Load::controller('passengers');

        $this->carBookingInfo['passenger_gender'] = $_POST["genderA1"];
        $this->carBookingInfo['passenger_name_en'] = $_POST["nameEnA1"];
        $this->carBookingInfo['passenger_family_en'] = $_POST["familyEnA1"];
        $this->carBookingInfo['passenger_name'] = $_POST["nameFaA1"];
        $this->carBookingInfo['passenger_family'] = $_POST["familyFaA1"];
        $this->carBookingInfo['passenger_national_code'] = !empty($_POST["NationalCodeA1"]) ? $_POST["NationalCodeA1"] : '';
        $this->carBookingInfo['passportCountry'] = $_POST["passportCountryA1"];
        $this->carBookingInfo['passportNumber'] = $_POST["passportNumberA1"];
        $this->carBookingInfo['passportExpire'] = $_POST["passportExpireA1"];
        $this->carBookingInfo['passenger_mobile'] = $_POST["MobileA1"];
        $this->carBookingInfo['passenger_telephone'] = $_POST["TelephoneA1"];
        $this->carBookingInfo['passenger_email'] = $_POST["EmailA1"];
        $this->carBookingInfo['refund_type'] = $_POST["RefundTypeA1"];
        $this->carBookingInfo['driving_crimes_type'] = $_POST["DrivingCrimesTypeA1"];
        $this->carBookingInfo['passenger_address'] = $_POST["AddressA1"];

        $this->carBookingInfo['has_source_station_return_cost'] = (isset($_POST["HasSourceStationReturnCost"]) && $_POST["HasSourceStationReturnCost"] == '1') ? '1' : '0';
        $this->carBookingInfo['has_dest_station_return_cost'] = (isset($_POST["HasDestStationReturnCost"]) && $_POST["HasDestStationReturnCost"] == '1') ? '1' : '0';

        $this->carBookingInfo['passenger_birthday'] = (isset($_POST["birthdayA1"]) && $_POST["birthdayA1"] != '') ? $_POST["birthdayA1"] : '';
        $this->carBookingInfo['passenger_birthday_en'] = (isset($_POST["birthdayEnA1"]) && $_POST["birthdayEnA1"] != '') ? $_POST["birthdayEnA1"] : '';
        $this->carBookingInfo['passenger_age'] = 'Adt';


        parent::curl_init();
        $result = parent::getCarsById($_POST["idCar"]);
        if ($result['message']=='Successful') {

            $this->carBookingInfo['car_id'] = $_POST['idCar'];
            $this->carBookingInfo['car_name'] = $result['GetCarsByIdResult']['Brand']['Name'] . ' - ' . $result['GetCarsByIdResult']['Model'];
            $this->carBookingInfo['car_name_en'] = $result['GetCarsByIdResult']['Brand']['EngName'];
            $this->carBookingInfo['car_image'] = "http://webs.europcar.ir" . substr($result['GetCarsByIdResult']['Img'],1);
            $this->carBookingInfo['car_passenger_count'] = $result['GetCarsByIdResult']['PassengerCount'];
            $this->carBookingInfo['car_allowed_km'] = $result['GetCarsByIdResult']['AllowedKm'];
            $this->carBookingInfo['car_min_age_to_rent'] = $result['GetCarsByIdResult']['MinAgeToRent'];
            $this->carBookingInfo['car_add_km_cos_rial'] = $result['GetCarsByIdResult']['AddKmCostRial'];
            $this->carBookingInfo['car_insurance_cost_rial'] = $result['GetCarsByIdResult']['InsuranceCostRial'];

        } else {

            $this->error = true;
            $this->errorMessage = 'متاسفانه مشکلی در فرآیند رزرو پیش آمده است. لطفا مجددا تلاش کنید.';
        }


        $sql = " SELECT * FROM members_tb WHERE id='{$idMember}'";
        $user = $Model->load($sql);
        if ($user['fk_agency_id'] != '') {
            $sql = " SELECT * FROM agency_tb WHERE id='{$user['fk_agency_id']}'";
            $agency = $Model->load($sql);
        }

        $this->carBookingInfo['member_id'] = $user['id'];
        $this->carBookingInfo['member_name'] = $user['name'] . ' ' . $user['family'];
        $this->carBookingInfo['member_mobile'] = $user['mobile'];
        $this->carBookingInfo['member_phone'] = $user['telephone'];
        $this->carBookingInfo['member_email'] = $user['email'];

        $this->carBookingInfo['agency_id'] = $agency['id'];
        $this->carBookingInfo['agency_name'] = $agency['name_fa'];
        $this->carBookingInfo['agency_accountant'] = $agency['accountant'];
        $this->carBookingInfo['agency_manager'] = $agency['manager'];
        $this->carBookingInfo['agency_mobile'] = $agency['mobile'];


        $this->carBookingInfo['source_station_id'] = $_POST["sourceStationId"];
        $this->carBookingInfo['source_station_name'] = $_POST["sourceStationName"];
        $this->carBookingInfo['dest_station_id'] = $_POST["destStationId"];
        $this->carBookingInfo['dest_station_name'] = $_POST["destStationName"];
        $this->carBookingInfo['get_car_date_time'] = $_POST["getCarDateTime"];
        $this->carBookingInfo['return_car_date_time'] = $_POST["returnCarDateTime"];
        $this->carBookingInfo['type_application'] = $_POST["typeApplication"];

        if(ISCURRENCY && $_POST['CurrencyCode'] > 0){
            $Currency = Load::controller('currencyEquivalent');
            $InfoCurrency = $Currency->InfoCurrency($_POST['CurrencyCode']);
        }

        $this->carBookingInfo['currency_code'] = $_POST['CurrencyCode'];
        $this->carBookingInfo['currency_equivalent'] = !empty($InfoCurrency) ? $InfoCurrency['EqAmount'] : '0';

        if (!empty($_POST['selectThingsId'])){

            $expThingsId = explode("/", $_POST['selectThingsId']);
            $i = 0;
            foreach ($expThingsId as $val){
                if ($_POST['countThings' . $val] > 0){
                    $this->thingInfo[$i]['thingsId'] = $val;
                    $this->thingInfo[$i]['thingsName'] = $_POST['thingsName' . $val];
                    $this->thingInfo[$i]['countThings'] = $_POST['countThings' . $val];
                    $this->thingInfo[$i]['priceThings'] = $_POST['priceThings' . $val];
                    $i++;
                }

            }

            $jsonData = json_encode($this->thingInfo, JSON_UNESCAPED_UNICODE);
            $this->carBookingInfo['reserve_car_thing_info'] = $jsonData;

        } else {

            $this->carBookingInfo['reserve_car_thing_info'] = '';
        }

        $config = Load::Config('application');
        $config->pathFile('europcar/');

        $this->carBookingInfo['identity_file_type'] = $_POST["IdentityFileType"];
        if (isset($_FILES['IdentityFile']) && $_FILES['IdentityFile']!=""){

            $successIdentity = $config->UploadFile("pic", "IdentityFile", "");
            $explodeIdentity = explode(':', $successIdentity);

            if ($explodeIdentity[0] == "done") {

                $this->carBookingInfo['identity_file'] = $explodeIdentity[1];
                $ext = substr(strrchr($explodeIdentity[1], '.'), 1);
                $this->carBookingInfo['identity_file_extension'] = $ext;

            }else {
                $this->error = true;
                $this->errorMessage = 'متاسفانه مشکلی در آپلود فایل مدرک هویتی پیش آمده است. لطفا مجددا تلاش کنید.';

            }

        }else {
            $this->error = true;
            $this->errorMessage = 'متاسفانه مشکلی در آپلود فایل مدرک هویتی پیش آمده است. لطفا مجددا تلاش کنید.';

        }

        $this->carBookingInfo['habitation_file_type'] = $_POST["HabitationFileType"];
        if (isset($_FILES['HabitationFile']) && $_FILES['HabitationFile']!=""){

            $successHabitation = $config->UploadFile("pic", "HabitationFile", "");
            $explodeHabitation = explode(':', $successHabitation);

            if ($explodeHabitation[0] == "done") {

                $this->carBookingInfo['habitation_file'] = $explodeHabitation[1];
                $ext = substr(strrchr($explodeHabitation[1], '.'), 1);
                $this->carBookingInfo['habitation_file_extension'] = $ext;

            }else {
                $this->error = true;
                $this->errorMessage = 'متاسفانه مشکلی در آپلود فایل مدرک محل سکونت پیش آمده است. لطفا مجددا تلاش کنید.';
            }

        }else {
            $this->error = true;
            $this->errorMessage = 'متاسفانه مشکلی در آپلود فایل مدرک محل سکونت پیش آمده است. لطفا مجددا تلاش کنید.';
        }

        $this->carBookingInfo['job_file_type'] = $_POST["JobFileType"];
        if (isset($_FILES['JobFile']) && $_FILES['JobFile']!=""){

            $successJob = $config->UploadFile("pic", "JobFile", "");
            $explodeJob = explode(':', $successJob);

            if ($explodeJob[0] == "done") {

                $this->carBookingInfo['job_file'] = $explodeJob[1];
                $ext = substr(strrchr($explodeJob[1], '.'), 1);
                $this->carBookingInfo['job_file_extension'] = $ext;

            }else {
                $this->error = true;
                $this->errorMessage = 'متاسفانه مشکلی در آپلود فایل مدرک شغلی پیش آمده است. لطفا مجددا تلاش کنید.';
            }

        }else {
            $this->error = true;
            $this->errorMessage = 'متاسفانه مشکلی در آپلود فایل مدرک شغلی پیش آمده است. لطفا مجددا تلاش کنید.';
        }

        $this->carBookingInfo['things_price'] = $_POST["paymentsPrice"] - $_POST["paymentsPriceCar"];
        $this->carBookingInfo['car_price'] = $_POST["paymentsPriceCar"];
        $this->carBookingInfo['total_price'] = $_POST["paymentsPrice"];
        $this->carBookingInfo['factor_number'] = $factorNumber;
        $this->carBookingInfo['client_id'] = CLIENT_ID;
        if ($this->serviceDiscountLocal['off_percent']>0){
            $this->carBookingInfo['off_percent'] = $this->serviceDiscountLocal['off_percent'];
        } else {
            $this->carBookingInfo['off_percent'] = 0;
        }
        $this->carBookingInfo['serviceTitle'] = 'LocalEuropcar';


        $objClientAuth = Load::library('clientAuth');
        $objClientAuth->apiEuropcarAuth();
        $sourceId = $objClientAuth->sourceId;
        //$sourceId = '9';
        $irantechCommission = Load::controller('irantechCommission');
        $it_commission = $irantechCommission->getCommission('LocalEuropcar', $sourceId);
        $this->carBookingInfo['irantech_commission'] = $it_commission;



        if ($this->IsLogin) {
            $passengerAddArray = array(
                'passengerName' => $this->carBookingInfo['name'],
                'passengerNameEn' => $this->carBookingInfo['name_en'],
                'passengerFamily' => $this->carBookingInfo['family'],
                'passengerFamilyEn' => $this->carBookingInfo['family_en'],
                'passengerGender' => $this->carBookingInfo['gender'],
                'passengerBirthday' => $this->carBookingInfo['birthday_fa'],
                'passengerNationalCode' => $this->carBookingInfo['NationalCode'],
                'passengerBirthdayEn' => $this->carBookingInfo['birthday'],
                'passengerPassportCountry' => $this->carBookingInfo['passportCountry'],
                'passengerPassportNumber' => $this->carBookingInfo['passportNumber'],
                'passengerPassportExpire' => $idMember,
                'memberID' => $this->carBookingInfo['fk_members_tb_id'],
                'passengerNationality' => $_POST["passengerNationality"]
            );
            $passengerController->insert($passengerAddArray);
        }


        //echo Load::plog($this->carBookingInfo);
        //die();

        $sql_check_book = " SELECT * FROM book_europcar_local_tb WHERE factor_number ='{$factorNumber}' AND member_id='{$idMember}'";
        $book_check = $Model->load($sql_check_book);


        if (empty($book_check)) {
            $Model->setTable('book_europcar_local_tb');
            $Model->insertLocal($this->carBookingInfo);

            $ModelBase->setTable('report_europcar_tb');
            $ModelBase->insertLocal($this->carBookingInfo);
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
}