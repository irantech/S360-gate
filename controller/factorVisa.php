<?php
/**
 * Class factorVisa
 * @property factorVisa $factorVisa
 */
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');




class factorVisa
{
    public $bookInfo = array();
    public $error;
    public $errorMessage;
    public $IsLogin;
    public $priceWithDiscount;
    public $check_exist_doubtful ;

    public function __construct()
    {
        $this->IsLogin = Session::IsLogin();

        if(!empty($_POST)){

            $check_exist_char = functions::existDoubtfulCharacter($_POST);

            if($check_exist_char){
                $this->check_exist_doubtful = $check_exist_char;
            }
        }


    }


    public function fileIndex($file, $index)
    {
        $final['name']=$file['name'][$index];
        $final['type']=$file['type'][$index];
        $final['tmp_name']=$file['tmp_name'][$index];
        $final['error']=$file['error'][$index];
        $final['size']=$file['size'][$index];

        return $final;
    }


    public function hasUploadFile($inputName) {
        return (
            isset($_FILES[$inputName]) &&
            (
                (is_array($_FILES[$inputName]['name']) && !empty($_FILES[$inputName]['name'][0])) ||
                (!is_array($_FILES[$inputName]['name']) && !empty($_FILES[$inputName]['name']))
            )
        );
    }

    #region registerBooks
    public function registerBooks($_POSTt)
    {


        if($this->check_exist_doubtful){
            $this->error = true;
            $this->errorMessage = functions::Xmlinformation('doubtCharacter');

        }else{

            $factorNumber = filter_var($_POSTt['factorNumber'], FILTER_SANITIZE_NUMBER_INT);
            $idMember = filter_var($_POSTt['idMember'], FILTER_VALIDATE_INT);
            $visaID = filter_var($_POSTt['visaID'], FILTER_VALIDATE_INT);
            $adultQty = filter_var($_POSTt['numAdult'], FILTER_VALIDATE_INT);
            $childQty = filter_var($_POSTt['numChild'], FILTER_VALIDATE_INT);
//            $infantQty = filter_var($_POSTt['count_infant_internal'], FILTER_VALIDATE_INT);
            $passengerCount = $adultQty + $childQty ;


            $Model = Load::library('Model');
            $ModelBase = Load::library('ModelBase');
            /**@var $passengerController passengers */
            $passengerController = Load::controller('passengers');

            $visaController = Load::controller('visa');
            $visaInfo = $visaController->getVisaByID($visaID);

            $countryController = Load::controller('country');
            $countryInfo = $countryController->getCountryByCode($visaInfo['countryCode']);

            $resultVisaController = Load::controller('resultReservationVisa');
            $discountedPrice = $resultVisaController->calcDiscountedPrice($visaInfo['mainCost']);
            $this->priceWithDiscount = $discountedPrice['price'];

            if(ISCURRENCY && $_POSTt['CurrencyCode'] > 0){
                $Currency = Load::controller('currencyEquivalent');
                $InfoCurrency = $Currency->InfoCurrency($_POSTt['CurrencyCode']);

            }

            $query = "SELECT * FROM members_tb WHERE id = '{$idMember}'";
            $user = $Model->load($query);
            $checkSubAgency =  functions::checkExistSubAgency() ;
            if ($user['fk_agency_id'] > 0 || $checkSubAgency) {
                $agencyId = ($checkSubAgency) ? SUB_AGENCY_ID : $user['fk_agency_id'];
                $sql = " SELECT * FROM agency_tb WHERE id='{$agencyId}'";
                $agency = $Model->load($sql);

            }

            if (!empty($visaInfo)) {

                $this->bookInfo['factor_number'] = $factorNumber;

                $this->bookInfo['member_id'] = $user['id'];
                $this->bookInfo['member_name'] = $user['name'] . ' ' . $user['family'];
                $this->bookInfo['member_mobile'] = $user['mobile'];
                $this->bookInfo['member_email'] = $user['email'];

                $this->bookInfo['mobile_buyer'] = isset($_POSTt["Mobile_buyer"]) ? $_POSTt["Mobile_buyer"] : $_POSTt["Mobile"];
                $this->bookInfo['tel_buyer'] = isset($_POSTt["Telephone"]) ? $_POSTt["Telephone"] : '';
                $this->bookInfo['email_buyer'] = isset($_POSTt["Email_buyer"]) ? $_POSTt["Email_buyer"] : $_POSTt["Email"];

                if (!empty($agency)) {
                    $this->bookInfo['agency_id'] = $agency['id'];
                    $this->bookInfo['agency_name'] = $agency['name_fa'];
                    $this->bookInfo['agency_accountant'] = $agency['accountant'];
                    $this->bookInfo['agency_manager'] = $agency['manager'];
                    $this->bookInfo['agency_mobile'] = $agency['mobile'];

                }

                $this->bookInfo['visa_id'] = $visaInfo['id'];
                $this->bookInfo['visa_title'] = $visaInfo['title'];
                $this->bookInfo['visa_destination_code'] = $visaInfo['countryCode'];
                $this->bookInfo['visa_destination'] = $countryInfo['name'];
                $this->bookInfo['visa_type'] = $visaInfo['visaTypeTitle'];
                $this->bookInfo['visa_descriptions'] = addslashes($visaInfo['descriptions']);
                $this->bookInfo['visa_deadline'] = $visaInfo['deadline'];
                $this->bookInfo['visa_validity_duration'] = $visaInfo['validityDuration'];
                $this->bookInfo['visa_allowed_use_no'] = $visaInfo['allowedUseNo'];
                $this->bookInfo['visa_main_cost'] = $visaInfo['mainCost'];
                $this->bookInfo['visa_OnlinePayment'] = $visaInfo['OnlinePayment'];
                $this->bookInfo['visa_prepayment_cost'] = $visaInfo['prePaymentCost'];
                $this->bookInfo['visa_currencyType'] = $visaInfo['currencyType'];

//                $this->bookInfo['status'] = (isset($_POSTt['OnlinePayment']) && $_POSTt['OnlinePayment'] == 'yes' ? 'nothing':'book');
                $this->bookInfo['status'] = 'prereserve';
                if(isset($_POSTt['OnlinePayment']) && $_POSTt['OnlinePayment'] != 'yes'){
                    $this->bookInfo['payment_date'] = date('Y-m-d H:i:s');
                }
                $this->bookInfo['del'] = 'no';
                $this->bookInfo['percent_discount'] = $discountedPrice['percent'];
                $this->bookInfo['price_change'] = 0;
                $this->bookInfo['price_change_type'] = 'none';
                $this->bookInfo['total_price'] = $discountedPrice['price'] * $passengerCount;
                $this->bookInfo['serviceTitle'] = functions::getVisaServiceType();
                $this->bookInfo['currency_code'] = $_POSTt['CurrencyCode'];
                $this->bookInfo['currency_equivalent'] = !empty($InfoCurrency) ? $InfoCurrency['EqAmount'] : '0';
                $this->bookInfo['creation_date'] = date('Y-m-d H:i:s');
                $this->bookInfo['creation_date_int'] = time();

                $passengerCounter = 0;
                $config=Load::Config('application');
                $config->pathFile('visaPassengersFiles/');

                if($adultQty > 0) {
                    for ($i = 1; $i <= $adultQty; $i++) { //adult


                        $data = array();


                        $count=count($_FILES["VisaFileA" . $i]['name']);
                        $passengers_file=[];

                        /*for ($fileIndex = 0; $fileIndex < $count; $fileIndex++){
                            $_FILES["SingleVisaFileA".$i]=$this->fileIndex($_FILES["VisaFileA".$i], $fileIndex);
                            $success=$config->UploadFile("pic", "SingleVisaFileA".$i, 99900000);
                            $explod_name_pic=explode(':', $success);
                            $passengers_file[]=$explod_name_pic[1];
                        }*/

//                        $data['passengers_file'] = json_encode($passengers_file,true);

                        $data['passenger_gender'] = $_POSTt["genderA" . $i];
                        $data['passenger_name'] = $_POSTt["nameFaA" . $i];
                        $data['passenger_name_en'] = $_POSTt["nameEnA" . $i];
                        $data['passenger_family'] = $_POSTt["familyFaA" . $i];
                        $data['passenger_family_en'] = $_POSTt["familyEnA" . $i];
                        if ($_POSTt["passengerNationalityA" . $i] == '0') {
                            $data['passenger_birthday'] = $_POSTt["birthdayA" . $i];
                        } else {
                            $data['passenger_birthday_en'] = $_POSTt["birthdayEnA" . $i];
                            $data['passenger_country'] = $_POSTt["passportCountryA" . $i];
                        }
                        $data['passenger_national_code'] = $_POSTt["NationalCodeA" . $i];
                        $data['passport_number'] = $_POSTt["passportNumberA" . $i];
                        $data['passport_expire'] = $_POSTt["passportExpireA" . $i];
                        $data['passenger_age'] = 'Adt';




                        $this->bookInfo['passengers'][$passengerCounter++] = $data;
                        if ($this->IsLogin) {


                            $passengerAddArray = array(
                                'passengerName' => $data['passenger_name'],
                                'passengerNameEn' => $data['passenger_name_en'],
                                'passengerFamily' => $data['passenger_family'],
                                'passengerFamilyEn' => $data['passenger_family_en'],
                                'passengerGender' => $data['passenger_gender'],
                                'passengerBirthday' => $data['passenger_birthday'],
                                'passengerNationalCode' => $data['passenger_national_code'],
                                'passengerBirthdayEn' => $data['passenger_birthday_en'],
                                'passengerPassportCountry' => !empty($_POSTt["passportCountryA" . $i]) ? $_POSTt["passportCountryA" . $i] : '',
                                'passengerPassportNumber' => $data['passport_number'],
                                'passengerPassportExpire' => $data['passport_expire'],
                                'memberID' => $user['id'],
                                'passengerNationality' => $_POSTt["passengerNationalityA" . $i]
                            );
                           $ress= $passengerController->insert($passengerAddArray);
                            functions::insertLog('$ress: ' . json_encode($ress) , '000shojaee');

                        }

                    }
                }




                if($childQty > 0) {
                    for ($i = 1; $i <= $_POSTt['numChild']; $i++) { //child


                        $data = array();

                        $count=count($_FILES["VisaFileC" . $i]['name']);
                        $passengers_file=[];

                        /*for ($fileIndex = 0; $fileIndex < $count; $fileIndex++){
                            $_FILES["SingleVisaFileC".$i]=$this->fileIndex($_FILES["VisaFileC".$i], $fileIndex);
                            $success=$config->UploadFile("pic", "SingleVisaFileC".$i, 99900000);
                            $explod_name_pic=explode(':', $success);
                            $passengers_file[]=$explod_name_pic[1];
                        }*/





                        $data['passengers_file'] = json_encode($passengers_file,true);


                        $data['passenger_gender'] = $_POSTt["genderC" . $i];
                        $data['passenger_name'] = $_POSTt["nameFaC" . $i];
                        $data['passenger_name_en'] = $_POSTt["nameEnC" . $i];
                        $data['passenger_family'] = $_POSTt["familyFaC" . $i];
                        $data['passenger_family_en'] = $_POSTt["familyEnC" . $i];
                        if ($_POSTt["passengerNationalityC" . $i] == '0') {
                            $data['passenger_birthday'] = $_POSTt["birthdayC" . $i];
                        } else {
                            $data['passenger_birthday_en'] = $_POSTt["birthdayEnC" . $i];
                            $data['passenger_country'] = $_POSTt["passportCountryC" . $i];
                        }
                        $data['passenger_national_code'] = $_POSTt["NationalCodeC" . $i];
                        $data['passport_number'] = $_POSTt["passportNumberC" . $i];
                        $data['passport_expire'] = $_POSTt["passportExpireC" . $i];
                        $data['passenger_age'] = 'Chd';


                        $this->bookInfo['passengers'][$passengerCounter++] = $data;

                        if ($this->IsLogin) {
                            $passengerAddArray = array(
                                'passengerName' => $data['passenger_name'],
                                'passengerNameEn' => $data['passenger_name_en'],
                                'passengerFamily' => $data['passenger_family'],
                                'passengerFamilyEn' => $data['passenger_family_en'],
                                'passengerGender' => $data['passenger_gender'],
                                'passengerBirthday' => $data['passenger_birthday'],
                                'passengerNationalCode' => $data['passenger_national_code'],
                                'passengerBirthdayEn' => $data['passenger_birthday_en'],
                                'passengerPassportCountry' => !empty($_POSTt["passportCountryC" . $i]) ? $_POSTt["passportCountryC" . $i] : '',
                                'passengerPassportNumber' => $data['passport_number'],
                                'passengerPassportExpire' => $data['passport_expire'],
                                'memberID' => $user['id'],
                                'passengerNationality' => $_POSTt["passengerNationalityC" . $i]
                            );
                            $passengerController->insert($passengerAddArray);
                        }

                    }

                }

//                foreach ($this->bookInfo['passengers'] as $passenger_key=>$eachPassenger){
//
//                    $WHERE = !empty($eachPassenger['passenger_national_code']) ? "passenger_national_code='{$eachPassenger['passenger_national_code']}' " : "passport_number='{$eachPassenger['passport_number']}'";
//
//                    $query_book_check = "SELECT * FROM book_visa_tb WHERE factor_number ='{$factorNumber}' AND member_id='{$idMember}' " .
//                        "AND passenger_gender = '{$eachPassenger['passenger_gender']}' AND {$WHERE} ";
//                    $result_book_check = $Model->load($query_book_check);
//
//                    $hasFileA = false;
//                    $hasFileB = false;
//
//
//                    if (isset($_FILES['custom_file_fields_A_' . ($passenger_key + 1)]) && $_FILES['custom_file_fields_A_' . ($passenger_key + 1)] != "") {
//                        $hasFileA = true;
//
//                        $custom_file_fields = functions::separateFiles('custom_file_fields_A_' . ($passenger_key + 1));
//                        $custom_file_field_name = json_decode($visaInfo['custom_file_fields'],true);
//
//                        $result_custom_file_fields=[];
//                        foreach ($custom_file_fields as $key=>$custom_file_field) {
//                            $inputName = 'custom_file_fields_A_' . ($passenger_key + 1);
//                            $_FILES[$inputName]=$custom_file_field;
//                            $success = $config->UploadFile("pic", $inputName, "2097152");
//                            $exp_name_pic = explode(':', $success);
//                            if ($exp_name_pic[0] == "done") {
//                                $uploaded_file_name = $exp_name_pic[1];
//
//                            } else {
//                                $uploaded_file_name = '';
//                            }
//                            $result_custom_file_fields[]=[
//                                $custom_file_field_name[$key]=>$uploaded_file_name
//                            ];
//                        }
//
//                        $this->bookInfo['custom_file_fields']=json_encode($result_custom_file_fields,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
//                        $Model->setTabffle('book_visa_tb');
//
//
//
//
//                        $dataBook = $this->bookInfo;
//
//
//                        unset($dataBook['passengers']);
//                        unset($dataBook['visa_OnlinePayment']);
//                        unset($dataBook['visa_currencyType']);
//
//
//
//                        $eachPassenger['unique_code'] = $this->generateUniqueCode();
//
//                        $dataBook = array_merge($dataBook, $eachPassenger);
//
//
//                        $res[] = $Model->insertLocal($dataBook);
//
//                        $ModelBase->setTable('report_visa_tb');
//                        $dataReport = $dataBook;
//                        $dataReport['client_id'] = CLIENT_ID;
//                        $dataReport['remote_addr'] = $_SERVER['REMOTE_ADDR'];
//                        $res[] = $ModelBase->insertLocal($dataReport);
//
//                    }
//
//                    if (isset($_FILES['custom_file_fields_C_' . ($passenger_key + 1)]) && $_FILES['custom_file_fields_C_' . ($passenger_key + 1)] != "") {
//                        $hasFileB = true;
//
//
//                        $custom_file_fields = functions::separateFiles('custom_file_fields_C_' . ($passenger_key + 1));
//                        $custom_file_field_name = json_decode($visaInfo['custom_file_fields'],true);
//
//                        $result_custom_file_fields=[];
//                        foreach ($custom_file_fields as $key=>$custom_file_field) {
//                            $inputName = 'custom_file_fields_C_' . ($passenger_key + 1);
//                            $_FILES[$inputName]=$custom_file_field;
//                            $success = $config->UploadFile("pic", $inputName, "2097152");
//                            $exp_name_pic = explode(':', $success);
//                            if ($exp_name_pic[0] == "done") {
//                                $uploaded_file_name = $exp_name_pic[1];
//
//                            } else {
//                                $uploaded_file_name = '';
//                            }
//                            $result_custom_file_fields[]=[
//                                $custom_file_field_name[$key]=>$uploaded_file_name
//                            ];
//
//                        }
//
//
//                        $this->bookInfo['custom_file_fields']=json_encode($result_custom_file_fields,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
//                        $Model->setTable('book_visa_tb');
//
//
//
//
//                        $dataBook = $this->bookInfo;
//
//
//                        unset($dataBook['passengers']);
//                        unset($dataBook['visa_OnlinePayment']);
//                        unset($dataBook['visa_currencyType']);
//
//
//
//                        $eachPassenger['unique_code'] = $this->generateUniqueCode();
//
//                        $dataBook = array_merge($dataBook, $eachPassenger);
//
//
//                        $res[] = $Model->insertLocal($dataBook);
//
//                        $ModelBase->setTable('report_visa_tb');
//                        $dataReport = $dataBook;
//                        $dataReport['client_id'] = CLIENT_ID;
//                        $dataReport['remote_addr'] = $_SERVER['REMOTE_ADDR'];
//                        $res[] = $ModelBase->insertLocal($dataReport);
//
//                    }
//
//                    if ($hasFileA === false && $hasFileB === false){
//
//                        $Model->setTable('book_visa_tb');
//
//                        $dataBook = $this->bookInfo;
//
//
//                        unset($dataBook['passengers']);
//                        unset($dataBook['visa_OnlinePayment']);
//                        unset($dataBook['visa_currencyType']);
//
//
//
//                        $eachPassenger['unique_code'] = $this->generateUniqueCode();
//
//                        $dataBook = array_merge($dataBook, $eachPassenger);
//
//
//                        $res[] = $Model->insertLocal($dataBook);
//
//                        $ModelBase->setTable('report_visa_tb');
//                        $dataReport = $dataBook;
//                        $dataReport['client_id'] = CLIENT_ID;
//                        $dataReport['remote_addr'] = $_SERVER['REMOTE_ADDR'];
//                        $res[] = $ModelBase->insertLocal($dataReport);
//
//                    }
//
//
//                }
                foreach ($this->bookInfo['passengers'] as $passenger_key => $eachPassenger) {

                    $result_custom_file_fields = array();

                    /* ================= FILE A ================= */
                    $inputA = 'custom_file_fields_A_' . ($passenger_key + 1);

                    if ($this->hasUploadFile($inputA)) {

                        $filesA = functions::separateFiles($inputA);

                        foreach ($filesA as $file) {
                            $_FILES[$inputA] = $file;

                            $success = $config->UploadFile("pic", $inputA, "2097152");
                            $exp = explode(':', $success);

                            if ($exp[0] === 'done') {
                                $result_custom_file_fields[] = array(
                                    'passport' => $exp[1]
                                );
                            }
                        }
                    }

                    /* ================= FILE C ================= */
                    $inputC = 'custom_file_fields_C_' . ($passenger_key + 1);

                    if ($this->hasUploadFile($inputC)) {

                        $filesC = functions::separateFiles($inputC);

                        foreach ($filesC as $file) {
                            $_FILES[$inputC] = $file;

                            $success = $config->UploadFile("pic", $inputC, "2097152");
                            $exp = explode(':', $success);

                            if ($exp[0] === 'done') {
                                $result_custom_file_fields[] = array(
                                    'photo' => $exp[1]
                                );
                            }
                        }
                    }

                    /* ================= INSERT ================= */
                    $this->bookInfo['custom_file_fields'] = json_encode(
                        $result_custom_file_fields,
                        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                    );

                    $Model->setTable('book_visa_tb');

                    $dataBook = $this->bookInfo;
                    unset(
                        $dataBook['passengers'],
                        $dataBook['visa_OnlinePayment'],
                        $dataBook['visa_currencyType']
                    );

                    $eachPassenger['unique_code'] = $this->generateUniqueCode();
                    $dataBook = array_merge($dataBook, $eachPassenger);

                    $Model->insertLocal($dataBook);

                    /* ================= REPORT ================= */
                    $ModelBase->setTable('report_visa_tb');

                    $dataReport = $dataBook;
                    $dataReport['client_id']   = CLIENT_ID;
                    $dataReport['remote_addr'] = $_SERVER['REMOTE_ADDR'];

                    $ModelBase->insertLocal($dataReport);
                }

                if (in_array('0', $res)){
                    $this->error = true;
                    $this->errorMessage = 'متاسفانه مشکلی در فرآیند رزرو پیش آمده است. لطفا مجددا تلاش کنید.';

                }

            } else {

                $this->error = true;
                $this->errorMessage = 'متاسفانه مشکلی در فرآیند رزرو پیش آمده است. لطفا مجددا تلاش کنید.';
            }
        }



    }
    #endregion

    #region getVisaInfoByFactorNumber
    public function getVisaInfoByFactorNumber($factorNumber)
    {
        $Model = Load::library('Model');
        $factorNumber = filter_var($factorNumber, FILTER_SANITIZE_NUMBER_INT);

        $query = "SELECT *, COUNT(id) as reserveCount FROM book_visa_tb WHERE factor_number = '{$factorNumber}' LIMIT 0,1";


        return $Model->load($query);
    }
    #endregion

    #region generateUniqueCode
    public function generateUniqueCode()
    {
        $uniqueCode = rand(000000,999999);

        $Model = Load::library('Model');
        $query = "SELECT id FROM book_visa_tb WHERE unique_code = '{$uniqueCode}'";
        $result = $Model->load($query);

        if(empty($result)){
            return $uniqueCode;
        } else{
            return $this->generateUniqueCode();
        }
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