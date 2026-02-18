<?php



//@ini_set('display_errors', 'on');

/**
 * Class factorTourLocal
 * @property factorTourLocal $factorTourLocal
 */
class factorTourLocal extends clientAuth
{
    public $tourBookingInfo = array();
    public $IsLogin;
    public $counterId;
    public $serviceDiscountLocal = array() ;
    public $error;
    public $errorMessage;
    public $portalServiceDiscount=array();
    public $localServiceDiscount=array();

    public function __construct()
    {

        $info_api = $this->getAccessTourWebService();

        if($info_api){
            $this->info_api = new tourApi($info_api);
        }
        
//        if($_SERVER['REMOTE_ADDR']=='84.241.4.20'){
//            echo json_encode($this->info_api,256|64); die();
//        }

        $this->IsLogin = Session::IsLogin();
        if ($this->IsLogin){
            $this->counterId = functions::getCounterTypeId($_SESSION['userId']);
        }else {
            $this->counterId = '5';
        }

        $this->portalServiceDiscount['public']=functions::ServiceDiscount($this->counterId, 'PublicPortalTour');
        $this->portalServiceDiscount['private']=functions::ServiceDiscount($this->counterId, 'PrivatePortalTour');
        $this->localServiceDiscount['public']=functions::ServiceDiscount($this->counterId, 'PublicLocalTour');
        $this->localServiceDiscount['private']=functions::ServiceDiscount($this->counterId, 'PrivateLocalTour');

    }

    #region registerPassengers
    public function registerPassengers() {


        /** @var requestReservation $requestReservationController */
        $requestReservationController = $this->getController('requestReservation');
        $bookTourLocalModel = $this->getModel('bookTourLocalModel');
        $reportTourModel = $this->getModel('reportTourModel');

        $creation_date_int = time();

        $idTour = filter_var($_POST['idTour'], FILTER_SANITIZE_STRING);
        $packageId = filter_var($_POST['packageId'], FILTER_SANITIZE_STRING);
        $passengerCount = filter_var($_POST['passengerCount'], FILTER_SANITIZE_STRING);
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $room_count = $_POST['countRoom'];


        $package_info = $this->getController('resultTourLocal')->setInfoReserveTourPackage($packageId,$room_count,$_POST['is_api']);



        $expCities = explode("/", $_POST['cities']);
        $cities = '';
        foreach ($expCities as $city){
            $cities .= trim($city) . ' / ';
        }
        $cities = substr($cities, 0, -3);

        $totalPrice = $_POST['typeTourReserve'] == 'oneDayTour' ? $_POST['totalPrice'] : $package_info['total_price_package'];

        if(functions::isEnableSetting('toman')) {
            $totalPrice = $totalPrice * 10 ;
        }


        $totalOriginPrice = filter_var($_POST['totalOriginPrice'], FILTER_SANITIZE_STRING);
        if(functions::isEnableSetting('toman')) {
            $totalOriginPrice = $totalOriginPrice * 10 ;
        }
        $totalPriceA = (isset($_POST['totalPriceA']) && $_POST['totalPriceA'] != '') ? filter_var($_POST['totalPriceA'], FILTER_SANITIZE_STRING) : '0';
        $currencyTitleFa = (isset($_POST['currencyTitleFa']) && $_POST['currencyTitleFa'] != '') ? filter_var($_POST['currencyTitleFa'], FILTER_SANITIZE_STRING) : '';
        $objResultTour = Load::controller('resultTourLocal');
        $objReservationTour = Load::controller('reservationTour');
        $paidPrice =$_POST['paymentPrice'];
        if(functions::isEnableSetting('toman')) {
            $paidPrice = $paidPrice * 10 ;
        }
        if (isset($_POST['oldFactorNumber']) && $_POST['oldFactorNumber'] != '') {
            $isResumeRequest = true;
            $factorNumber = filter_var($_POST['oldFactorNumber'], FILTER_SANITIZE_STRING);
            $idMember = filter_var($_POST['oldIdMember'], FILTER_SANITIZE_STRING);
        } else {
            $isResumeRequest = false;
            $factorNumber = filter_var($_POST['factorNumber'], FILTER_SANITIZE_STRING);
            $idMember = filter_var($_POST['idMember'], FILTER_SANITIZE_STRING);
        }
        $changedPrice =$objReservationTour->getRequestPriceChanged( $factorNumber) ;


        $serviceTitle = $_POST['serviceTitle'];

        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');


        if(isset($_POST['is_api']) && $_POST['is_api']){
            $resultInfoTour = $this->info_api->getInfoTour(['tour_id'=>$idTour]);
        }else{
            $sql = " SELECT T.*, TR.exit_hours
                 FROM 
                    reservation_tour_tb T
                    LEFT JOIN reservation_tour_rout_tb AS TR ON T.id=TR.fk_tour_id
                 WHERE 
                    T.id = '{$idTour}'
                 GROUP BY T.id";

            $resultInfoTour = $Model->load($sql);

        }

        if (!empty($resultInfoTour)) {

            $pre_paid =($objResultTour->prePaymentCalculate($totalPrice, $_POST['prepayment_percentage']));
            $paymentPrice = ($pre_paid > 0 ? ($pre_paid + $changedPrice) : 0 ) ;


            $this->tourBookingInfo['tour_id'] = $idTour;
            $this->tourBookingInfo['tour_agency_id'] = $resultInfoTour['agency_id'];
            $this->tourBookingInfo['tour_agency_name'] = $resultInfoTour['agency_name'];
            $this->tourBookingInfo['tour_name'] = $resultInfoTour['tour_name'];
            $this->tourBookingInfo['tour_code'] = $resultInfoTour['tour_code'];
            $this->tourBookingInfo['tour_type'] = $resultInfoTour['tour_type'];
            $this->tourBookingInfo['tour_free'] = $resultInfoTour['free'];
            $this->tourBookingInfo['tour_night'] = $resultInfoTour['night'];
            $this->tourBookingInfo['tour_day'] = $resultInfoTour['day'];
            $this->tourBookingInfo['tour_visa'] = $resultInfoTour['visa'];

            $this->tourBookingInfo['tour_insurance'] = $resultInfoTour['insurance'];
            $this->tourBookingInfo['tour_pic'] = $resultInfoTour['tour_pic'];
            $this->tourBookingInfo['tour_file'] = $resultInfoTour['tour_file'];
            $this->tourBookingInfo['tour_cities'] = $cities;
            $this->tourBookingInfo['tour_start_date'] = $startDate;
            $this->tourBookingInfo['tour_end_date'] = $endDate;
            $this->tourBookingInfo['tour_exit_hour'] = $resultInfoTour['exit_hours'];
            $this->tourBookingInfo['tour_stop_time_cancel'] = $resultInfoTour['stop_time_cancel'];
            $this->tourBookingInfo['tour_origin_country_id'] = $resultInfoTour['origin_country_id'];
            $this->tourBookingInfo['tour_origin_country_name'] = $resultInfoTour['origin_country_name'];
            $this->tourBookingInfo['tour_origin_city_id'] = $resultInfoTour['origin_city_id'];
            $this->tourBookingInfo['tour_origin_city_name'] = $resultInfoTour['origin_city_name'];
            $this->tourBookingInfo['tour_origin_region_id'] = $resultInfoTour['origin_region_id'];
            $this->tourBookingInfo['tour_origin_region_name'] = $resultInfoTour['origin_region_name'];


            $doDiscount=$objResultTour->doDiscount($idTour,['minPriceR'=>$totalOriginPrice]);
            $infoTourRoutByIdTour = ($_POST['is_api']) ? $this->info_api->infoTourRoutByIdTour(['tour_id'=>$idTour]): $objReservationTour->infoTourRoutByIdTour($idTour);
            $ServiceDiscount = '';
            foreach ($infoTourRoutByIdTour as $city){
                if ($city['tour_title'] == 'dept'){
                    if ($city['destination_country_id'] == '1'){
                        $ServiceDiscount = $this->localServiceDiscount;
                    } else {
                        $ServiceDiscount = $this->portalServiceDiscount;
                    }
                }
            }


            if(!empty($doDiscount['discountedMinPriceR'])){
                $this->tourBookingInfo['tour_discount_type']='percent';
                $totalPrice=$doDiscount['discountedMinPriceR'];
                $this->tourBookingInfo['tour_discount']=$ServiceDiscount['private']['off_percent'];
            }else{
                $this->tourBookingInfo['tour_discount_type'] = '';
                $this->tourBookingInfo['tour_discount'] = '';
            }
            $this->tourBookingInfo['tour_counter_id'] = $this->counterId;
            $this->tourBookingInfo['tour_origin_price'] = $doDiscount['minPriceR'];

          

            $sql = " SELECT name, family, mobile FROM members_tb WHERE id='{$resultInfoTour['user_id']}'";

            $user = $Model->load($sql);
            $this->tourBookingInfo['tour_agency_user_id'] = $resultInfoTour['user_id'];
            $this->tourBookingInfo['tour_agency_user_name'] = $user['name'] . ' ' . $user['family'];
            $this->tourBookingInfo['tour_agency_user_mobile'] = $user['mobile'];


        } else {

            $this->error = true;
            $this->errorMessage = 'متاسفانه مشکلی در فرآیند رزرو پیش آمده است. لطفا مجددا تلاش کنید.';
        }


        $arrayTypeVehicle = $objResultTour->getTypeVehicle($idTour,$_POST['is_api']);

        if (!empty($arrayTypeVehicle)) {

            $this->tourBookingInfo['tour_type_vehicle_name_dept'] = $arrayTypeVehicle['dept']['type_vehicle_name'];
            $this->tourBookingInfo['tour_airline_name_dept'] = $arrayTypeVehicle['dept']['airline_name'];
            $this->tourBookingInfo['tour_type_vehicle_name_return'] = $arrayTypeVehicle['return']['type_vehicle_name'];
            $this->tourBookingInfo['tour_airline_name_return'] = $arrayTypeVehicle['return']['airline_name'];

        } else {
            echo json_encode([$idTour,$resultInfoTour],256|64);

            $this->error = true;
            $this->errorMessage = 'متاسفانه مشکلی در فرآیند رزرو پیش آمده است. لطفا مجددا تلاش کنید.';
        }

        $package=  [];

        if ($_POST['typeTourReserve'] == 'noOneDayTour'){

            $package = $package_info ; //$objResultTour->setInfoReserveTourPackage($packageId, $_POST['countRoom']);
            functions::insertLog('package id ==>'.  json_encode($package),'setInfoReserveTourPackagedd');



        } elseif ($_POST['typeTourReserve'] == 'oneDayTour'){

//            echo json_encode($_POST,256|64);
            $package['adult_price_oneDayTour'] = ( $_POST['adultPriceOneDayTourR'] ) ? $_POST['adultPriceOneDayTourR'] : '';
            $package['adult_count_oneDayTour'] = ( $_POST['adultCountOneDayTour'] ) ? $_POST['adultCountOneDayTour'] : '';
            $package['child_price_oneDayTour'] = ( $_POST['childPriceOneDayTourR'] ) ? $_POST['childPriceOneDayTourR'] : '';
            $package['child_count_oneDayTour'] = ( $_POST['childCountOneDayTour'] ) ? $_POST['childCountOneDayTour'] : '';
            $package['infant_price_oneDayTour'] = ( $_POST['infantPriceOneDayTourR'] ) ? $_POST['infantPriceOneDayTourR'] : '';
            $package['adult_price_oneDayTour_a'] = ( $_POST['adultPriceOneDayTourA'] ) ? $_POST['adultPriceOneDayTourA'] : '';
            $package['child_price_oneDayTour_a'] = ( $_POST['childPriceOneDayTourA'] ) ? $_POST['childPriceOneDayTourA'] : '';
            $package['infant_price_oneDayTour_a'] = ( $_POST['infantPriceOneDayTourA'] ) ? $_POST['infantPriceOneDayTourA'] : '';
            $package['currencyTitleFa'] = ( $_POST['currencyTitleFa'] ) ? $_POST['currencyTitleFa'] : '';
        }

        $jsonPackage = json_encode($package, 256 | 64);
//        $jsonPackage = str_replace("\\", "\\\\", $jsonPackage);



        $this->tourBookingInfo['tour_package'] = $jsonPackage;


        $sql = " SELECT * FROM members_tb WHERE id='{$idMember}'";


        $user = $Model->load($sql);




        $checkSubAgency =  functions::checkExistSubAgency() ;
        if ($user['fk_agency_id'] > 0 || $checkSubAgency) {
            $agencyId = ($checkSubAgency) ? SUB_AGENCY_ID : $user['fk_agency_id'] ;
            $sql = " SELECT * FROM agency_tb WHERE id='{$agencyId}'";
            $agency = $Model->load($sql);
        }

        if(!$isResumeRequest){

            $this->tourBookingInfo['member_id'] = $user['id'];
            $this->tourBookingInfo['member_name'] = empty($user['name'])?$_POST['requestedMemberName']:$user['name'] . ' ' . $user['family'];
            $this->tourBookingInfo['member_mobile'] = empty($user['mobile'])?$_POST['requestedMemberPhoneNumber']:$user['mobile'];
            $this->tourBookingInfo['member_phone'] = $user['telephone'];
            $this->tourBookingInfo['member_email'] = $user['email'];
        }


        $this->tourBookingInfo['agency_id'] = $agency['id'];
        $this->tourBookingInfo['agency_name'] = $agency['name_fa'];
        $this->tourBookingInfo['agency_accountant'] = $agency['accountant'];
        $this->tourBookingInfo['agency_manager'] = $agency['manager'];
        $this->tourBookingInfo['agency_mobile'] = $agency['mobile'];

        $this->tourBookingInfo['tour_total_price'] = $totalPrice;
        $this->tourBookingInfo['tour_total_price_a'] = $totalPriceA;
        $this->tourBookingInfo['currency_title_fa'] = $currencyTitleFa;
        $this->tourBookingInfo['tour_payments_price'] = $paymentPrice;
        $this->tourBookingInfo['tour_payments_price_a'] = 0;
        $this->tourBookingInfo['total_price'] =  ($totalPrice + $changedPrice) ;
        $this->tourBookingInfo['factor_number'] = $factorNumber;
        $this->tourBookingInfo['client_id'] = CLIENT_ID;
        $this->tourBookingInfo['is_api'] = $_POST['is_api'];
        $this->tourBookingInfo['client_id_api'] = $resultInfoTour['client_id'];

        $this->tourBookingInfo['serviceTitle'] = $serviceTitle;

        $objClientAuth = Load::library('clientAuth');
        $objClientAuth->reservationTourAuth();
        $sourceId = $objClientAuth->sourceId;
        //$sourceId = '10';
        $irantechCommission = Load::controller('irantechCommission');
        $it_commission = $irantechCommission->getCommission($serviceTitle, $sourceId);
        $this->tourBookingInfo['irantech_commission'] = $it_commission;


        if ($this->IsLogin) {
            $passengerAddArray = array(
                'passengerName' => $this->tourBookingInfo['name'],
                'passengerNameEn' => $this->tourBookingInfo['name_en'],
                'passengerFamily' => $this->tourBookingInfo['family'],
                'passengerFamilyEn' => $this->tourBookingInfo['family_en'],
                'passengerGender' => $this->tourBookingInfo['gender'],
                'passengerBirthday' => $this->tourBookingInfo['birthday_fa'],
                'passengerNationalCode' => $this->tourBookingInfo['NationalCode'],
                'passengerBirthdayEn' => $this->tourBookingInfo['birthday'],
                'passengerPassportCountry' => $this->tourBookingInfo['passportCountry'],
                'passengerPassportNumber' => $this->tourBookingInfo['passportNumber'],
                'passengerPassportExpire' => $idMember,
                'memberID' => $this->tourBookingInfo['fk_members_tb_id'],
                'passengerNationality' => $_POST["passengerNationality"]
            );

            $passengerController = Load::controller('passengers');
            $passengerController->insert($passengerAddArray);
        }



        /* @var application $config */
        $config = Load::Config('application');
        $config->pathFile('reservationTour/passengersImages/');



        for ($i = 1; $i <= $passengerCount; $i++){

            $this->passenger[$i]['creation_date_int'] = $creation_date_int;
            $this->passenger[$i]['passenger_gender'] = $_POST["gender" . $i];
            $this->passenger[$i]['passenger_age'] = $_POST["passengerAge" . $i];
            $this->passenger[$i]['passenger_name_en'] = $_POST["nameEn" . $i];
            $this->passenger[$i]['passenger_family_en'] = $_POST["familyEn" . $i];
            $this->passenger[$i]['passenger_name'] = $_POST["nameFa" . $i];
            $this->passenger[$i]['passenger_family'] = $_POST["familyFa" . $i];
            $this->passenger[$i]['passenger_national_code'] = !empty($_POST["NationalCode" . $i]) ? $_POST["NationalCode" . $i] : '';
            $this->passenger[$i]['passportCountry'] = $_POST["passportCountry" . $i];
            $this->passenger[$i]['passportNumber'] = $_POST["passportNumber" . $i];
            $this->passenger[$i]['passportExpire'] = $_POST["passportExpire" . $i];
            $this->passenger[$i]['passenger_birthday'] = (isset($_POST["birthday" . $i]) && $_POST["birthday" . $i] != '') ? $_POST["birthday" . $i] : '';
            $this->passenger[$i]['passenger_birthday_en'] = (isset($_POST["birthdayEn" . $i]) && $_POST["birthdayEn" . $i] != '') ? $_POST["birthdayEn" . $i] : '';


            if (isset($_FILES['NationalImage' . $i]) && $_FILES['NationalImage' . $i] != "") {
                $inputName = 'NationalImage' . $i;
                $success = $config->UploadFile("", $inputName, "");
                $exp_name_pic = explode(':', $success);
                if ($exp_name_pic[0] == "done") {
                    $this->passenger[$i]['passenger_national_image'] = $exp_name_pic[1];

                } else {
                    $this->passenger[$i]['passenger_national_image'] = '';
                }

            } else {
                $this->passenger[$i]['passenger_national_image'] = '';
            }
            if (isset($_FILES['passportImage' . $i]) && $_FILES['passportImage' . $i] != "") {
                $inputName = 'passportImage' . $i;
                $success = $config->UploadFile("", $inputName, "");
                $exp_name_pic = explode(':', $success);
                if ($exp_name_pic[0] == "done") {
                    $this->passenger[$i]['passenger_passport_image'] = $exp_name_pic[1];

                } else {
                    $this->passenger[$i]['passenger_passport_image'] = '';
                }

            } else {
                $this->passenger[$i]['passenger_passport_image'] = '';
            }
            if (isset($_FILES['custom_file_fields_' . $i]) && $_FILES['custom_file_fields_' . $i] != "") {

                $custom_file_fields = functions::separateFiles('custom_file_fields_' . $i);
                $custom_file_field_name = json_decode($resultInfoTour['custom_file_fields'],true);
                $result_custom_file_fields=[];

                foreach ($custom_file_fields as $key=>$custom_file_field) {
                    $inputName = 'custom_file_fields_' . $i;
                    $_FILES[$inputName]=$custom_file_field;
                    $success = $config->UploadFile("", $inputName, "2097152");
                    $exp_name_pic = explode(':', $success);
                    if ($exp_name_pic[0] == "done") {
                        $uploaded_file_name = $exp_name_pic[1];

                    } else {
                        $uploaded_file_name = '';
                    }
                    $result_custom_file_fields[]=[
                        $custom_file_field_name[$key]=>$uploaded_file_name
                    ];
                }

                $this->passenger[$i]['custom_file_fields']=json_encode($result_custom_file_fields,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

            } else {
                $this->passenger[$i]['custom_file_fields'] = '';
            }



            $this->passenger[$i]['factor_number'] = $factorNumber;
            $this->passenger[$i]['member_id'] = $idMember;
            $this->passenger[$i]['type_application'] = $_POST["typeApplication"];

            $WHERE = !empty($this->passenger[$i]['passenger_national_code']) ? "passenger_national_code='{$this->passenger[$i]['passenger_national_code']}' " : "passportNumber='{$this->passenger[$i]['passportNumber']}'";

            $sql_check_book = " SELECT * FROM book_tour_local_tb WHERE factor_number ='{$factorNumber}' AND (passenger_national_code = '{$this->passenger[$i]['passenger_national_code']}' OR passportNumber = '{$this->passenger[$i]['passportNumber']}') ";

            $book_check = $Model->load($sql_check_book);
            
            if (empty($book_check) || $resultInfoTour['is_request'] == '1') {

                if($resultInfoTour['is_request'] == '1' && empty($book_check) && empty($book_check['status'])){

                    $this->tourBookingInfo['status'] = 'Requested';
                }




                if($isResumeRequest && !$_POST['is_api']){
                    $checkIsResumeRequest=$bookTourLocalModel->get(['id'])
                        ->where('factor_number',$factorNumber)
                        ->all();
                }




                if($checkIsResumeRequest){

                    $res[] = $bookTourLocalModel->updateWithBind($this->passenger[$i],[
                        'id'=>$checkIsResumeRequest[$i-1]['id']
                    ]);




                    $checkIsResumeRequest=$reportTourModel->get(['id'])
                        ->where('factor_number',$factorNumber)
                        ->all();
                    $res[] = $reportTourModel->updateWithBind($this->passenger[$i],[
                        'id'=>$checkIsResumeRequest[$i-1]['id']
                    ]);

                }

                elseif(!$requestReservationController->getRequest('tour',$factorNumber)){


                        $Model->setTable('book_tour_local_tb');
                        $res[] = $Model->insertLocal($this->passenger[$i]);


                    if($_POST['is_api'])
                    {
                        $this->getController('admin')->ConectDbClient("",  $resultInfoTour['client_id'], "Insert", $this->passenger[$i], "book_tour_local_tb", "");
                    }


                    $ModelBase->setTable('report_tour_tb');
                    $res[] = $ModelBase->insertLocal($this->passenger[$i]);
                }
            }

        }


        if (in_array('0', $res)){

            $this->error = true;
            $this->errorMessage = 'متاسفانه مشکلی در فرآیند رزرو پیش آمده است. لطفا مجددا تلاش کنید.';

        } else {



            $sms = 'مدیریت محترم آژانس ' . CLIENT_NAME . ' رزرو تور آفلاین '. $resultInfoTour['tour_name'] .' در سیستم ثبت شد.' ;
            $smsController = Load::controller('smsServices');
            $objSms = $smsController->initService('0');
            if($objSms) {
                $smsArray = array(
                    'smsMessage' => $sms,
                    'cellNumber' => CLIENT_MOBILE
                );
//            var_dump($smsArray);
//            die;
                $smsController->sendSMS($smsArray);
            }



            if($_POST['is_api'])
            {
                $this->getController('admin')->ConectDbClient('', $resultInfoTour['client_id'], 'Update', $this->tourBookingInfo, 'book_tour_local_tb', "factor_number='{$factorNumber}'");
            }
            $res2[] = $bookTourLocalModel->updateWithBind($this->tourBookingInfo,[
                'factor_number'=>$factorNumber
            ]);


            $res2[] = $reportTourModel->updateWithBind($this->tourBookingInfo,[
                'factor_number'=>$factorNumber
            ]);



            $this->tourBookingInfo['prepayment_percentage'] = $resultInfoTour['prepayment_percentage'];


        }
        $this->tourBookingInfo['tour_reason'] = $resultInfoTour['tour_reason'];


    }
    #endregion


    #region CreditCustomer
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
    #endregion


}