<?php

//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

// خط پایین مربوط به ارسال ایمیل پس از رزرو پرواز میباشد ، باید در هاست آپلود باشد اما اگر روی لوکال کامنت نباشید لوکال سفید میاد
require '/home/safar360/public_html/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Class members
 * @property members $members
 */

class members extends clientAuth {

	public $name = '';
	public $family = '';
	public $mobile = '';
	public $email = '';
	public $counterTypeId = '';
	public $password;
	public $agancyName;
	public $deleteID = '';
	public $editID = '';
	public $userID = '';
	public $message = '';    //message that show after insert new agency
	public $list = array();
    public $members_model;//array that include notification of counter

	public function __construct() {
        parent::__construct();

		//////////// active or inactive one airline///////////////////

		$user = Session::IsLogin();
		if ( $user ) {
			$this->userID = Session::getUserId();
		}
        $this->members_model = $this->getModel('membersModel') ;
	}
    public function getMemberById($id){
        $member = $this->getModel('membersModel')->get()->where('id', $id)->find();
        return $member;
    }

    public function ReturnOutLoginApp($info_member){
        // === اگر از طریق App آمده، خروجی مخصوص بازگشت داده کامل بده ===
        return functions::toJson(array(
            'success' => true,
            'message' => functions::Xmlinformation('SuccessRegisterUser')->__toString(),
            'position' => 'resLoginSuccess',
            'data' => array(
                'nameUser'      => $info_member['name'] . ' ' . $info_member['family'],
                'userId'        => $info_member['id'],
                'typeUser'      => 'counter',
                'cardNo'        => (isset($info_member['card_number']) ? $info_member['card_number'] : ''),
                'counterTypeId' => (isset($info_member['fk_counter_type_id']) ? $info_member['fk_counter_type_id'] : ''),
                'layout'        => (isset($info_member['TypeOs']) ? $info_member['TypeOs'] : ''),
            )
        ));
    }
    public function memberInsert($data) {
        $exist_member = $this->members_model->getMemberByUserName($data);
        if (!$exist_member || ($exist_member['is_member'] == 0)) {

            if ($exist_member && $exist_member['is_member'] == 0) {

                $data['info_member'] = $exist_member ;
                $res = $this->registerGustMembers($data);

                $info_member = $res ? $exist_member : [];
            } else {

                $res = $this->insertSpecificMember($data);
                $info_member = $res ;
            }
            if(functions::checkClientConfigurationAccess('call_back')) {
                $call_back_api =$this->getController('callBackUrl');
                $call_back_api->sendRegisteredUser($info_member , 'insert') ;
            }

            if(isset($info_member['id']) && $info_member['id'] > 0 && $data['no_login']) {
                return functions::toJson(['success' => true, 'message' => functions::Xmlinformation('SuccessRegisterUser')->__toString(), 'position' => 'resLoginSuccess' , 'data' => $info_member]);
            }

            if (isset($info_member['id']) && $info_member['id'] > 0) {
                if($data['reagentCode']){
                    $this->setPointReagentCode($data['reagentCode'], $info_member);
                }

                if(SOFTWARE_LANG == 'fa') {
                    //sms
                    $smsController = Load::controller('smsServices');
                    $objSms = $smsController->initService('0');

                    if ($objSms) {
                        $messageVariables = array(
                            'sms_name' => $data['name'] . ' ' . $data['family'],
                            'sms_username' => $data['entry'],
                            'sms_reagent_code' => $data['reagentCode'],
                            'sms_agency' => CLIENT_NAME,
                            'sms_agency_mobile' => CLIENT_MOBILE,
                            'sms_agency_phone' => CLIENT_PHONE,
                            'sms_agency_email' => CLIENT_EMAIL,
                            'sms_agency_address' => CLIENT_ADDRESS,
                        );

//                    $emoji = functions::createEmoji('\uD83D\uDE01');
                        $UserLoginInformation = PHP_EOL . functions::Xmlinformation('UserName') . ':' . $data['entry'] ;

                        $smsArray = array(
                            'smsMessage' => $smsController->getUsableMessage('welcome', $messageVariables) . $UserLoginInformation,
                            'cellNumber' => $data['entry'],
                            'smsMessageTitle' => 'welcome',
                            'memberID' => (!empty($registeredMember['id']) ? $registeredMember['id'] : ''),
                            'receiverName' => $messageVariables['sms_name'],
                        );

                        $smsController->sendSMS( $smsArray );
                    }
                }
                if (filter_var($data['entry'], FILTER_VALIDATE_EMAIL)){
                    $emailBody = functions::Xmlinformation('HiThere') . '<br>';
                    $emailBody .= functions::StrReplaceInXml([
                            "@@name@@" => $data['name'],
                            "@@family@@" => $data['family']
                        ], "HiDearNameFamily") . '' . functions::Xmlinformation('EmailRegistrationTextOne') . ' <br> ' . functions::Xmlinformation("EmailRegistrationTextTwo") . '<br>';
                    $emailBody .= functions::Xmlinformation('UserName') . $data['entry'] . '<br>';

                    $param['title'] = functions::StrReplaceInXml(["@@name@@" => CLIENT_NAME], "RegisterWebsiteName");
                    $param['body'] = $emailBody;

                    $to = $data['entry'];
                    $subject = functions::StrReplaceInXml(["@@name@@" => CLIENT_NAME], "RegisterWebsiteName");
                    $message = functions::emailTemplate($param);
                    $headers = "From: noreply@" . CLIENT_DOMAIN . "\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-type: text/html; charset=UTF-8";
                    ini_set('SMTP', 'smtphost');
                    ini_set('smtp_port', 25);
                    mail($to, $subject, $message, $headers);
                }

                $resLogin = $this->memberLogin($data['entry'], $data['password'], 'off', '0', 'byRegister');
                if ($resLogin && isset($data['Type']) && strtolower($data['Type']) == 'app') {
                    return  $this->ReturnOutLoginApp($info_member);
                }
                else if ($resLogin) {
                    return functions::toJson(['success' => true, 'message' => functions::Xmlinformation('Loginsuccessfully')->__toString(), 'position' => 'resLoginSuccess', 'redirect_url' => $_SESSION['refer_url']]);
                }
                return functions::toJson(['success' => false, 'message' => functions::Xmlinformation('ErrorLoggingIn')->__toString(), 'position' => 'resLoginError', 'redirect_url' => '']);
            }

            if (isset($data['Type']) && strtolower($data['Type']) == 'app') {
                return  $this->ReturnOutLoginApp($info_member);
            }
            return functions::toJson(['success' => false, 'message' => functions::Xmlinformation('RegistrationFailedTryAgain')->__toString(), 'position' => 'resError', 'redirect_url' => '']);
        }

        if (isset($data['Type']) && strtolower($data['Type']) == 'app' && $exist_member && $exist_member['is_member'] == 1) {
            return $this->ReturnOutLoginApp($exist_member);
        }
        else if(SOFTWARE_LANG == 'fa') {
            return functions::toJson(['success' => false, 'message' => functions::Xmlinformation('MobileIsDuplicate')->__toString(), 'position' => 'ExistsUser', 'redirect_url' => '']);
        }else{
            return functions::toJson(['success' => false, 'message' => functions::Xmlinformation('EmailIsDuplicate')->__toString(), 'position' => 'ExistsUser', 'redirect_url' => '']);
        }
    }

    /**
     * @param $entry
     * @param $password
     * @param string $remember
     * @param int $organizationLevel
     *
     * @param $isEnableClub
     *
     * @return bool|string
     */
    public function memberLogin($entry, $password, $remember = 'off', $organizationLevel = 0, $isEnableClub) {

        $data_login['entry'] = $entry ;
        $data_login['password']  = functions::encryptPassword($password) ;

        $result = $this->members_model->getMemberByUserAndPassword($data_login);

        if(!$result){

            if(SOFTWARE_LANG === 'fa'){
            $validateResult= $this->getController('verificationCode')->validateCode($entry,$password);

            if($validateResult['status']){
                $result=$this->members_model->getMemberByUserName($data_login);
            }else{
                if($validateResult['message']){
                    return $validateResult['message'];
                }
            }
            }else{
                $result=$this->members_model->getMemberByUserName($data_login);
            }
        }

        if ($result['fk_counter_type_id'] != 5) {
            $agencyInfo = functions::infoAgencyByMemberId($result['id']);
            $result = $agencyInfo['active'] == 'on' ? $result : array();
        }
        if (empty($result)) {
            return false;
        } else {
            Session::LoginDo($result['name'] . ' ' . $result['family'], $result['id'], $result['card_number']);

            Session::setCounterTypeId($result['fk_counter_type_id']);
            if ($organizationLevel != 0) {
                Session::setOrganization($organizationLevel);
            }


            if (isset($_POST['setcoockie']) && $_POST['setcoockie'] == "yes") {
                setcookie('LoginPanel', 'Yes', time() + (86400 * 30), '/', null, 0);
            }

            if ($remember == 'on') {
                $login_time = 3600 * 24;
                setcookie('email', $entry, time() + $login_time, ("/"));
                setcookie('password', $password, time() + $login_time, ("/"));
            } else {
                $entry = " ";
                $password = " ";
                setcookie('email', $entry, time() - 3600, ("/"));
                setcookie('password', $password, time() - 3600, ("/"));
            }

            if(SOFTWARE_LANG == 'fa'  && CLIENT_ID == '271') {
                //sms
                $smsController = Load::controller('smsServices');
                $objSms = $smsController->initService('0');

                if ($objSms) {
                    $messageVariables = array(
                        'sms_name' => $result['name'] . ' ' . $result['family'],
                        'sms_agency' => CLIENT_NAME,
                        'sms_agency_mobile' => CLIENT_MOBILE,
                        'sms_agency_phone' => CLIENT_PHONE,
                        'sms_agency_email' => CLIENT_EMAIL,
                        'sms_agency_address' => CLIENT_ADDRESS,
                    );

                    $smsArray = array(
                        'smsMessage' => $smsController->getUsableMessage('memberLogin', $messageVariables),
                        'cellNumber' => $result['mobile'],
                        'smsMessageTitle' => 'memberLogin',
                        'memberID' => (!empty($result['id']) ? $result['id'] : ''),
                        'receiverName' => $messageVariables['sms_name'],
                    );

                    $smsController->sendSMS( $smsArray );
                }
            }

            return functions::withSuccess($result['id'],200,'ورود با موفقیت انجام شد');
        }
        //        }

    }

    /**
     * get information about one passenger
     *
     * @param int $idpass : PassengerID
     *
     * @return array
     */
    public function getInfoPassenger($idpass) {
        $passengers = Load::model('passengers');

        return $passengers->get($idpass);
    }

    /**
     * get information about counters
     *
     * @param $type number beetwen 0(for get online passengers) or 1(for get counters exept online passenger).
     * @param $id number(id counter_type_tb) , for get counters with special type
     *
     * @return set List variable
     */
    public function getCounters($type = 5, $id = '') {
        $model = Load::model('members');
        $result = $model->getCounters($type, $id);
        $this->list = $result;

        foreach ($result as $i => $counter) {
            $model_book = Load::model('book_local');
            $costumer = $model_book->count_costumer($counter['id']);

            $this->list[$i]['count_costumer'] = $costumer['counted'];

            $model_passengers = Load::model('passengers');
            $passengers = $model_passengers->getAllpassengers($counter['id']);
            //print_r($passengers);
            $this->list[$i]['passengers'] = $passengers['passengers'];
        }
    }

    /**
     * get information about members who registerd in site
     */
    public function getMembers() {
        $model = Load::model('members');

        return $model->getCounters('1');
    }

    public function getGuestUser() {
        Load::autoload('Model');

        $Model = new  Model();

        $sql = " SELECT member.*,
        (SELECT COUNT(request_number) FROM book_local_tb WHERE member_id= member.id AND (successfull='book' OR successfull='pid_private')) AS CountCustomer
         FROM members_tb AS member WHERE member.is_member='0'  AND member.fk_counter_type_id='5'";

        $res = $Model->select($sql);

        return $res;


    }

    /**
     * get information about counters
     *
     * @param $id number(id agency_tb) , for get counters with special agency
     *
     * @return set List variable
     */
    public function getCountersByAgency($id = '',$isMember) {

        if (!empty($id)) {
            $model = Load::model('members');
            $result = $model->getCountersByAgency($id,$isMember);
            return $result;
        }
    }

    public function ActiveAsCounter($param) {
        $Model = Load::library('Model');
        if (!isset($param['typeCounterId']) || $_POST['typeCounterId'] == '') {
            return 'error : لطفا کارنتر را انتخاب نمائید';
        }
        if (!isset($param['agency_id']) || $_POST['agency_id'] == '') {
            return 'error : لطفا آژانس پذیرنده کانتر را انتخاب نمائید';
        }

        $members_model = Load::model('members');
        $checkExistUser = $members_model->get($param['id']);
        if (!empty($checkExistUser)) {

            $d['fk_counter_type_id'] = $param['typeCounterId'];
            $d['fk_agency_id'] = $param['agency_id'];

            $Model->setTable('members_tb');


            $result = $Model->update($d, "id={$param['id']}");

            if ($result) {

                $dataClub['counterTypeId'] = $d['fk_counter_type_id'];
                $dataClub['cardNumber'] = $checkExistUser['card_number'];
                $resultCurl = functions::UpdateMemberInClub($dataClub);
                functions::insertLog('infoResultUpdateUserInClub=>' . json_encode($resultCurl), 'log_update_userInClub');

                return 'success : کاربر با موفقیت به کانتر ارتقا یافت ،شما میتوانید در لیست کانتر ها اطلاعات کاربر را مشاهده نمائید';
            } else {
                return 'error : خطا در ثبت اطلاعات ،لطفا مجددا تلاش فمائید و یا با پشتیبان خود تماس بگیرید';
            }

        } else {

            return 'error : کاربر شناسایی نشد ،مجددا تلاش نمائید و در صورت تکرار با پشتیبان خود تماس بگیرید';
        }

    }

    public function getMainUser() {
        Load::autoload('Model');
        $Model = new Model();

        /*$sql = "SELECT * ,
                 (SELECT COUNT(request_number) FROM book_local_tb WHERE member_id= member.id AND (successfull='book' OR successfull='pid_private') ) AS CountCustomer ,
                 (SELECT COUNT(id) FROM passengers_tb WHERE fk_members_tb_id= member.id ) AS CountPassenger
                  FROM members_tb AS member
                  WHERE member.fk_counter_type_id ='5' AND member.del='no' AND member.is_member='1' ORDER BY id ASC";*/

        $sql = "SELECT id,name, family, mobile,email,fk_counter_type_id,fk_agency_id,active,register_date
            FROM
                members_tb AS member
            WHERE
                member.fk_counter_type_id = '5'
                AND member.del = 'no'
                AND member.is_member = '1'
            ORDER BY
                id ASC";

        return $Model->select($sql);


    }

    /**
     * delete member
     */
    public function delete_counter($id) {
        $model = Load::model('members');

        return $model->members_delete($id);
    }

    /**
     * convert counter to passenger online
     */
    public function convert_counter($id) {
        $model = Load::model('members');

        return $model->convert_counter($id);
    }

    public function showedit($id) {

        $id = (!empty($id)) ? $id : Session::getAgencyId();
        Load::autoload('Model');
        $Model = new Model();
        if (isset($id) && !empty($id)) {
            $edit_query = " SELECT * FROM  members_tb  WHERE id='{$id}'";
            $res_edit = $Model->load($edit_query);
//            var_dump($res_edit);
//            die;
            if (!empty($res_edit)) {
                $this->list = $res_edit;
            } else {
                header("Location: " . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . "/404.tpl");
            }
        } else {
            header("Location: " . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . "/404.tpl");
        }
    }

    /**
     * update counter
     *
     * @param get data from public variabl class for update
     *
     * @return 1 for successful
     */
    public function updateCounter($data) {
        /** @var members_tb $model */
        $model = Load::model('members');
        $user = $model->get($data['counter_id']);
        $Connection = new Model();
        if (!$user['user_name']) {
            return 'error : کاربری با این مشخصات یافت نشد';
        }

        $checkMembersExist = $Connection->load("select * from members_tb where  email = '{$data['email']}' and  del='no' and id != '{$user['id']}'  ");
        if (!empty($checkMembersExist)) {
            return "error : این ایمیل قبلا ثبت شده است،لطفا ایمیل دیگری را وارد نمائید";
        }
        else {
            if(trim($data['is_member'])=='2'){
                $resultDepart= $this->getModel('membersModel')
                    ->get(['id'])
                    ->where('del', 'no')
                    ->where('id_departments',trim($data['id_departments']))
                    ->where('fk_agency_id',trim($data['agency_id']))
                    ->where('is_member','2')
                    ->where('active','on')
                    ->where('id',$user['id'],'!=')
                    ->find();

                if ($resultDepart['id']>0) {
                    return 'error : برای این واحد قبلا مدیر تعیین کرده اید';
                }
            }

            $data_update = [];
            $data_update['email'] = !empty($data['email']) ? strtolower(trim($data['email'])) : '';

            if (!empty($data['password'])) {
                $data_update['password'] = $model->encryptPassword($data['password']);
            }
            if (!empty($data['name'])) {
                $data_update['name'] = trim($data['name']);
            }
            if (!empty($data['family'])) {
                $data_update['family'] = trim($data['family']);
            }
            if (!empty($data['name_en'])) {
                $data_update['name_en'] = trim($data['name_en']);
            }
            if (!empty($data['family_en'])) {
                $data_update['family_en'] = trim($data['family_en']);
            }
            if (!empty($data['telephone'])) {
                $data_update['telephone'] = trim($data['telephone']);
            }
            //if (!empty($data['accessAdmin'])) {
                $data_update['accessAdmin'] = $data['accessAdmin'];
           // }
            if (!empty($data['typeCounter'])) {
                $data_update['fk_counter_type_id'] = trim($data['typeCounter']);
            }
            if (!empty($data['id_departments'])) {
                $data_update['id_departments'] = trim($data['id_departments']);
            }
            $result = $model->updateWithBind($data_update, ['id' => $user['id']]);
            if ($result) {
                return 'success : ویرایش با موفقیت انجام شد';
            }
            return 'error : خطا در بروزرسانی code 1';
        }
    }

    /**
     * insert counter
     *
     * @param get data from public variabl class for insert
     *
     * @return 1 for successful
     */
    public function addCounter($members) {

        $user = $this->members_model->getMemberByUserName($members['mobile']);
        if ($user) {
            return 'error : این ایمیل قبلا استفاده شده است';
        }
        if(trim($members['is_member'])=='2'){
            $resultDepart= $this->getModel('membersModel')
                ->get(['id'])
                ->where('del', 'no')
                ->where('id_departments',trim($members['id_departments']))
                ->where('fk_agency_id',trim($members['agency_id']))
                ->where('is_member','2')
                ->where('active','on')
                ->find();

            if ($resultDepart['id']>0) {
                return 'error : برای این واحد قبلا مدیر تعیین کرده اید';
            }
        }

        $data_insert = [
            'email' => trim($members['email']),
            'user_name' => trim($members['mobile']),
            'password' => functions::encryptPassword($members['password']),
            'name' => trim($members['name']),
            'family' => trim($members['family']),
            'name_en' => trim($members['name_en']),
            'family_en' => trim($members['family_en']),
            'mobile' => trim($members['mobile']),
            'fk_counter_type_id' => trim($members['fk_counter_type_id']),
            'fk_agency_id' => trim($members['agency_id']),
            'is_member' => trim($members['is_member']),
            'accessAdmin' => trim($members['accessAdmin']),
            'card_number' => $this->generateCardNumber(),
            'register_date' => Date('Y-m-d H:i:s'),
            'id_departments'=> trim($members['id_departments'])
        ];
        $insert_result = $this->members_model->insertWithBind($data_insert);

        if ($insert_result) {
            return 'success : افزودن کاربر جدید با موفقیت انجام شد';
        }
        return 'error : این ایمیل قبلا ثبت شده است،لطفا ایمیل دیگری را مورد استفاده قرار دهید';

    }

    public function addUser($members) {
        Load::autoload('Model');

        $Connection = new Model();
        $model_member = Load::model('members');
        $num = $model_member->getByEmail($members['email']);
        if ($num == 0) {
            //do not repeat reagent code
            do {
                $reagentCode = functions::generateRandomCode(5);
                $resultRepeat = $model_member->getByReagentCode($reagentCode);
            } while ($resultRepeat != 0 && is_array($resultRepeat));

            $data['password'] = $model_member->encryptPassword($members['password']);
            $data['email'] = strtolower($members['email']);
            $data['name'] = $members['name'];
            $data['family'] = $members['family'];
            $data['mobile'] = $members['mobile'];
            $data['fk_counter_type_id'] = '5';
            $data['fk_agency_id'] = '0';
            $data['is_member'] = '1';
            $data['del'] = 'no';
            $data['active'] = 'on';
            $data['card_number'] = $model_member->generateCardNo();
            $data['reagent_code'] = $reagentCode;

            $Connection->setTable('members_tb');

            $res = $Connection->insertLocal($data);
            if ($res) {
                echo 'success : افزودن کاربر جدید با موفقیت انجام شد';
            } else {
                echo 'error : خطا در ثبت کاربر ،لطفا مجددا اقدام نمائید و یا با وب مستر خودت تماس حاصل فرمائید';
            }
        } else {
            echo 'error : این ایمیل قبلا ثبت شده است،لطفا ایمیل دیگری را مورد استفاده قرار دهید';
        }
    }

    public function editUser($members) {
        $is_json=false;
        if($members['to_json'] === true){
            $is_json=true;
        }

        Load::autoload('Model');
        $model_member = Load::model('members');
        $Connection = new Model();
        $checkMembersExist = $Connection->load("select * from members_tb where  email = '{$members['email']}' and  del='no' and id != '{$members['memberID']}'  ");

        if (!empty($checkMembersExist)) {
            echo "error : این ایمیل قبلا ثبت شده است،لطفا ایمیل دیگری را وارد نمائید";
        } else {
            $result = $Connection->load("select * from members_tb where id = '{$members['memberID']}' and  del='no'");

            $id = $members['memberID'];
            if (!empty($result)) {

                $data['email'] = strtolower($members['email']);
                $data['name'] = $members['name'];
                $data['family'] = $members['family'];
                $data['name_en'] = $members['name_en'];
                $data['family_en'] = $members['family_en'];
                $data['telephone'] = $members['telephone'];
//              $data['mobile'] = $members['mobile'];
                $data['email'] = $members['email'];

               if (!empty($members['password'])) {
                    $data['password'] = $model_member->encryptPassword($members['password']);
                }



                $Connection->setTable('members_tb');
                $res_update = $Connection->update($data, "id='{$id}'");


                if ($members['reagentCode'] != '') {
                    /** @var membersModel $members_model */
                    $members_model=$this->getModel('membersModel');

                    $reagentResult = $members_model->get()->where('reagent_code',$members['reagentCode'])->find();


                    if ($reagentResult != 0) {
                        $reagentPoint = Load::controller('reagentPoint');
                        $reagentPointAmount = $reagentPoint->GetReagentPoint();

                        $dataCredit['memberId'] = $id;
                        $dataCredit['amount'] = $reagentPointAmount;
                        $dataCredit['state'] = 'charge';
                        $dataCredit['reason'] = 'reagent_code_presented';
                        $dataCredit['comment'] = 'اعتبار هدیه شده هنگام ثبت نام بابت ارائه کد معرف ' . $reagentResult['name'] . ' ' . $reagentResult['family'] . ' با کد ' . $reagentResult['reagent_code'];
                        $dataCredit['reagentCode'] = $members['reagentCode'];
                        $dataCredit['status'] = 'success';
                        $dataCredit['factorNumber'] = substr(time(), 0, 5) . mt_rand(000, 999) . substr(time(), 5, 10);
                        $dataCredit['creationDateInt'] = time();



                        /** @var membersCreditModel $members_credit_model */
                        $members_credit_model=$this->getModel('membersCreditModel');
                        $check=$members_credit_model->get()->where('memberId',$id)
                            ->where('reagentCode',$members['reagentCode'])->find();
                        if(!$check){
                            $members_credit_model->insertWithBind($dataCredit);
                        }


                    }
                }


                if ($res_update) {
                    if($is_json){
                        return true;
                    }
                    echo 'success : اطلاعات کاربر با موفقیت ویرایش شد';
                } else {
                    if($is_json){
                        return false;
                    }
                    echo 'error : خطا در ویرایش اطلاعات کاربر';
                }
            } else {

                echo "error : کاربر مورد نظر وجود ندارد،با وب مستر خود تماس بگیرید";
            }
        }
    }

    public function editUserBankDetail($details) {
        Load::autoload('Model');
        $Connection = new Model();
        $sql = "select * from counter_details_tb where  idmember = '{$details['memberID']}'";
        $checkMembersExist = $Connection->select($sql);


        if (!empty($checkMembersExist) && ($checkMembersExist['idmember'] != $details['memberID'])) {
            $data['name_hesab'] = $details['nameHesab'];
            $data['sheba'] = $details['sheba'];
            $data['bank_hesab'] = $details['hesabBank'];
            $Connection->setTable('counter_details_tb');
            $res_update = $Connection->update($data, "idmember='{$details['memberID']}'");
            if ($res_update) {
                echo 'success : اطلاعات کاربر با موفقیت ویرایش شد';
            } else {
                echo 'error : خطا در ویرایش اطلاعات کاربر';
            }
        } else {
            $data['name_hesab'] = $details['nameHesab'];
            $data['sheba'] = $details['sheba'];
            $data['bank_hesab'] = $details['hesabBank'];
            $data['idmember'] = $details['memberID'];


            $Connection->setTable('counter_details_tb');

            $res = $Connection->insertLocal($data);

            if ($res) {
                echo 'success : اطلاعات کاربر با موفقیت ثبت شد';
            } else {
                echo 'error : خطا در ثبت اطلاعات کاربر';
            }
        }
    }

    /**
     * get credit of members
     *
     * @param get data(user id) from session
     *
     * @return 0 for passengers online or counter without credit and return number for counter that thiers agensy have credit
     */
    public function getCredit() {
        $info_member = functions::infoAgencyByMemberId(Session::getUserId());
        $userAgencyId = $info_member['fk_agency_id'];

        if ($userAgencyId == '0') {  //counter without agency (maybe online passenger)
            return '0';
        } else {
            Load::autoload('Model');
            $creditModel = new Model();
            $sql_charge = "SELECT sum(credit) AS total_charge FROM credit_detail_tb WHERE type='increase' AND fk_agency_id='{$userAgencyId}'  AND (PaymentStatus='success' OR PaymentStatus IS NULL)";
            $charge = $creditModel->load($sql_charge);
            $total_charge = $charge['total_charge'];

            $sql_buy = "SELECT sum(credit) AS total_buy FROM credit_detail_tb WHERE type='decrease' AND fk_agency_id='{$userAgencyId}'  AND (PaymentStatus='success' OR PaymentStatus IS NULL)";
            $buy = $creditModel->load($sql_buy);
            $total_buy = $buy['total_buy'];

            $total_transaction = $total_charge - $total_buy;

            $total_transaction = ($info_member['payment']=='credit' && $info_member['limit_credit'] > 0 && (time() <= $info_member['time_limit_credit'])) ? ($total_transaction + $info_member['limit_credit']) : $total_transaction ;
            return ($total_transaction > 0) ? $total_transaction : 0;

        }
    }

    public function decreaseCounterCredit($amount, $requestNumber, $bookInfo, $type, $checkRepeat = 'yes') {

        $member_info = $this->membersModel()->get()->where('id', Session::getUserId())->find();
        if (!empty($member_info)) {
            $userAgencyId = $member_info['fk_agency_id'];
            $creditModel = Load::model('credit_detail');

            if ($checkRepeat == 'no' || ($checkRepeat == 'yes' && $creditModel->getByRequestNumber($requestNumber) == '0')) {
                $creditModel->decrease($userAgencyId, $amount, $bookInfo, $type);
            }
        }
    }

    /**
     * @return bool|mixed|membersModel
     */
    public function membersModel() {
        return Load::getModel('membersModel');
    }

    public function increaseAgencyCreditForEuropcar($factorNumber, $userAgencyId) {
        $InfoBook = functions::GetInfoEuropcar($factorNumber);

        $creditModel = Load::model('credit_detail');
        $creditModel->increase($userAgencyId, $InfoBook, 'Europcar');

    }

    public function forgetPassword($email) {


        if(functions::isMobileOrEmail($email) !=='email'){
            return 'error: ' . functions::Xmlinformation("PleaseEnterValidEmail");
        }
        $members = Load::model('members');
        $rec = $members->getByEmail($email);
        $applicant = $rec;
        $last_modify = $rec['last_resend_code'];
        $last_modifyDiff = time() - $last_modify;

        if ($rec == 0) {
            return 'error: ' . functions::Xmlinformation("NoUserFoundWithThisProfile");
        } elseif ((empty($rec['remember_code'])) || (!empty($rec['remember_code']) && $last_modifyDiff > 180)) {

            $key = functions::HashKey($rec['id'], 'encrypt');

            //$url = ROOT_ADDRESS_WITHOUT_LANG . "/recoverPass&key=" . $key;
            /*$emailContent = '
            <tr>
                <td valign="top" class="mcnTextContent" style="padding: 18px;color: #000000;font-size: 14px;font-weight: normal;text-align: center;">
                    <h3 class="m_-2679729263370124627null" style="text-align:center;display:block;margin:0;padding:0;color:#000000;font-family:tahoma,verdana,segoe,sans-serif;font-size:22px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal">
  بازیابی
                        <span style="color:#FFFFFF"><strong>رمز عبور</strong></span>
                    </h3>
                    <div style="margin-top: 20px;text-align:right;color:#FFFFFF; font-family:tahoma,verdana,segoe,sans-serif">
                    با سلام <br>
دوست عزیز؛ این ایمیل بنا به درخواست شما جهت بازیابی رمز عبورتان ارسال شده است <br>
                    در صورتی که شما این درخواست را داده اید بر روی دکمه بازیابی رمز عبور که در قسمت پایین قرار دارد کلیک نمایید و در غیر این صورت ایمیل را نادیده بگیرید <br>
           توجه کنید که لینک بازیابی رمز عبور تنها تا پایان امروز معتبر می باشد
                    </div>
                </td>
            </tr>
            ';
            $pdfButton = '
            <tr>
                <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 14px;">
                    <a class="mcnButton " title="بازیابی رمز عبور" href="' . $url . '" target="_blank" style="background-color: #284861;padding: 15px;margin:5px 0;border-radius: 10px;font-weight: bold;letter-spacing: 0px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">بازیابی رمز عبور</a>
                </td>
            </tr>
            ';*/
            $randNumber = functions::RandNumeric(5);
            $Model = Load::library('Model');
            if (SOFTWARE_LANG != 'fa') {

                //--------- Send By E-mail -----------
                $param['title'] = functions::Xmlinformation('Recoverypassword');
                $param['body'] = '
                ' . functions::Xmlinformation("EmailHasBeenSentUponRequestForPassword") . ' <br>
                ' . functions::Xmlinformation("ClickPasswordRecoveryButton") . ' <br>
                ' . functions::Xmlinformation("PasswordRecoveryValidOnlyToday") . '';
                $param['pdf'][0]['url'] = ROOT_ADDRESS_WITHOUT_LANG . "/recoverPass&key=" . $key;
                $param['pdf'][0]['button_title'] = functions::Xmlinformation("Recoverypassword");

                $to = $email;
                $subject = functions::Xmlinformation("Recoverypassword");
                $message = functions::emailTemplate($param);
                $headers = "From: noreply@" . CLIENT_DOMAIN . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=UTF-8";
                ini_set('SMTP', 'smtphost');
                ini_set('smtp_port', 25);
                if (mail($to, $subject, $message, $headers)) {
                    $Model->setTable('members_tb');
                    $data['remember_code'] = $randNumber;
                    $condition = "id='{$rec['id']}'";
                    $Model->update($data, $condition);

                    return 'success : ' . functions::Xmlinformation("EmailSentSuccessfully");
                } else {
                    return 'error :' . functions::Xmlinformation("ErrorSendingEmailTryAgain");
                }
                //---------END of Send By E-mail -----------
            } else {

                //sms
                $smsController = $this->getController('smsServices');
                $objSms = $smsController->initService('0');


                if ($objSms) {

                    $one_time_password_pattern =   $smsController->getPattern('one_time_password');
                    if($one_time_password_pattern) {
                        $smsController->smsByPattern($one_time_password_pattern['pattern'], array($rec['mobile']), array('verification_code' => $randNumber));
                    }else {
                        $sms = "دوست عزیز کد تایید شما " . $randNumber . " میباشد ، این کد جهت بازیابی رمز ورود می باشد لذا در اختیار شخص دیگری قرار ندهید.";
                        $smsArray = array(
                            'smsMessage' => $sms,
                            'cellNumber' => $rec['mobile']
                        );

                        $smsController->sendSMS($smsArray);
                    }
                    $Model->setTable('members_tb');
                    $data['remember_code'] = $randNumber;
                    $data['last_resend_code'] = time();
                    $condition = "id='{$rec['id']}'";
                    $Model->update($data, $condition);

                    if (isset($_POST['type']) && $_POST['type'] == 'App') {
                        $message['status'] = 'success';
                        $message['message'] = 'کد بازیابی رمز عبور با موفقیت ارسال شد';

                        return json_encode($message);
                    }

                    return 'success : ' . functions::Xmlinformation("ApplicationSuccessfullyRegistered");
                }
            }
        } else {
            if (isset($_POST['type']) && $_POST['type'] == 'App') {
                $message['status'] = 'error';
                $message['message'] = 'خطا در ارسال کد،لطفا با پشتیبانی خود تماس حاصل نمائید';

                return json_encode($message);
            }

            return 'error : ' . functions::Xmlinformation("InvalidRequest") . ' Left ' . (180 - $last_modifyDiff) . 's';
        }
    }

    public function forgetPassCheckCode($code) {
        $members = Load::model('members');
        $rec = $members->getByRememberCode($code);
        $applicant = $rec;
        if ($rec == 0) {
            if (isset($_POST['type']) && $_POST['type'] == 'App') {
                $message['status'] = 'error';
                $message['message'] = 'اطلاعات ارسال شده نا درست است';

                return json_encode($message);
            }

            return 'error: ' . functions::Xmlinformation("NoUserFoundWithThisProfile");
        } else {
            $randomPassword = functions::RandString(8);
            $HashedRandomPassword = $members->encryptPassword($randomPassword);

            $Model = Load::library('Model');
            $Model->setTable('members_tb');
            $data['remember_code'] = null;
            $data['password'] = $HashedRandomPassword;
            $condition = "id='{$rec['id']}'";
            $Model->update($data, $condition);

            $smsController = $this->getController('smsServices');
            $objSms = $smsController->initService('0');

            if ($objSms) {
                $forget_password = $smsController->getPattern('forget_password');
                if($forget_password) {
                    $smsController->smsByPattern($forget_password['pattern'], array($rec['mobile']), array('verification-code' => $randomPassword));
                }
                else {
                    $sms = "رمز ورود موقت شما : " . $randomPassword . PHP_EOL . "این کد ، رمز ورود شما جهت ورود به سیستم تا زمان تغییر مجدد رمز ورودتان می باشد لذا آن را در اختیار شخص دیگری قرار ندهید";
                    $smsArray = array(
                        'smsMessage' => $sms,
                        'cellNumber' => $rec['mobile']
                    );
                    $smsController->sendSMS($smsArray);
                }

            }
            if (isset($_POST['type']) && $_POST['type'] == 'App') {
                $message['status'] = 'success';
                $message['message'] = 'رمز جدید به شماره ی شما ارسال شد';

                return json_encode($message);
            }

            return 'success : رمز جدید به شماره ی شما ارسال شد';
        }
    }

    public function recoverPass($key, $newPass) {
        $members = Load::model('members');

        $d['password'] = $newPass;

        $userID = functions::HashKey($key, 'decrypt');
        $user = $members->get($userID);
        if (!empty($user)) {
            $members->updatePass($members->encryptPassword($d['password']), $user['id']);
            if ($members) {
                return 'success : کلمه عبور شما با موفقیت تغییر یافت ،لطفا مجددا اقدام به ورود کنید';
            } else {
                return 'error : خطا در بازیابی کلمه عبور لطفا مجددا اقدام کنید';
            }
        } else {
            return 'error : خطا در شناسایی  کاربر ، لطفا مجددا اقدام کنید';
        }
    }

    public function active_counter($id) {
        $model = Load::model('members');

        return $model->active($id);
    }

    public function active_user($id) {
        $model = Load::model('members');

        return $model->activeUser($id);
    }

    public function findUser($id) {
        return $this->getModel('membersModel')->get()->where('id', $id)->find();
    }

    public function SendEmailForOther($email, $request_number, $ClientID = null) {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        if (!empty($ClientID)) {
            $sql = " SELECT * FROM report_tb WHERE request_number='{$request_number}'";
            $res_model = $ModelBase->load($sql);
        } else {
             $sql = " SELECT * FROM book_local_tb WHERE request_number='{$request_number}'";
            $res_model = $Model->load($sql);
        }

        if (!empty($res_model)) {

            /*$pdfUrl = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=parvazBookingLocal&id=' . $request_number;

            $emailContent = '
            <tr>
                <td valign="top" class="mcnTextContent" style="padding: 18px;color: #000000;font-size: 14px;font-weight: normal;text-align: center;">
                    <h3 class="m_-2679729263370124627null" style="text-align:center;display:block;margin:0;padding:0;color:#000000;font-family:tahoma,verdana,segoe,sans-serif;font-size:22px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal">
بلیط هواپیما از
                        <span style="color:#FFFFFF"><strong>' . $res_model['origin_city'] . '</strong></span>
به
                        <span style="color:#FFFFFF"><strong>' . $res_model['desti_city'] . '</strong></span>
                    </h3>
                    <div style="margin-top: 20px;text-align:right;color:#FFFFFF; font-family:tahoma,verdana,segoe,sans-serif">
                    با سلام <br>
دوست عزیز؛ این پیام به درخواست ' . $res_model['member_name']. ' برای شما ارسال شده است <br>
 ایشان یک بلیط برای شما خریداری کرده اند،
                    لطفا جهت مشاهده و چاپ بلیط بر روی دکمه چاپ بلیط که در قسمت پایین قرار دارد کلیک نمایید
                    </div>
                </td>
            </tr>
            ';

            $pdfButton = '
            <tr>
                <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 14px;">
                    <a class="mcnButton " title="چاپ بلیط" href="' . $pdfUrl . '" target="_blank" style="background-color: #284861;padding: 15px;margin:5px 0;border-radius: 10px;font-weight: bold;letter-spacing: 0px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">چاپ بلیط</a>
                </td>
            </tr>
            ';*/

//            $param['title'] = 'بلیط هواپیما از ' . $res_model['origin_city'] . ' به ' . $res_model['desti_city'];
//            $param['body'] = '
//                    با سلام <br>
//دوست عزیز؛ این پیام به درخواست ' . $res_model['member_name'] . ' برای شما ارسال شده است <br>
// ایشان یک بلیط برای شما خریداری کرده اند،
//                    لطفا جهت مشاهده و چاپ بلیط بر روی دکمه چاپ بلیط که در قسمت پایین قرار دارد کلیک نمایید
//                    ';
//            $param['pdf'][0]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=parvazBookingLocal&id=' . $request_number;
//            $param['pdf'][0]['button_title'] = 'چاپ بلیط';
//
//
//            if (!empty($ClientID)) {
//                $Client = functions::infoClient($ClientID);
//                $AgencyDomain = $Client['Domain'];
//            } else {
//                $AgencyDomain = CLIENT_DOMAIN;
//            }
//
//            $to = $email;
//            $subject = "خرید بلیط هواپیما";
//            $message = functions::emailTemplate($param);
//            $headers = "From: noreply@" . $AgencyDomain . "\r\n";
////            $headers = "From:info@iran-tech.com\r\n";
//            $headers .= "MIME-Version: 1.0\r\n";
//            $headers .= "Content-type: text/html; charset=UTF-8";
//            ini_set('SMTP', 'smtphost');
//            ini_set('smtp_port', 25);
//
//            $result_mail =mail($to, $subject, $message, $headers) ;
//
//            if ($result_mail) {
//
//                return 'success : درخواست شما با موفقیت ارسال شد';
//            } else {
//                echo json_encode(error_get_last(),256);
//                return 'error : خطا در ثبت درخواست، لطفا مجددا اقدام نمائید';
//            }

            $mail = new PHPMailer(true);

            $agency = $this->getModel('clientsModel')->get()->where('id', CLIENT_ID)->find();

            $subject = $agency['AgencyName'] . " - ";
            $subject .= "بلیط پرواز ";
            $subject .= $res_model['origin_city'];
            $subject .= " به ";
            $subject .= $res_model['desti_city'];

            $message = "رزرو شما با موفقیت صادر شد، جهت دریافت بلیط روی لینک زیر کلیک نمایید :\r\n";

            $target = (SOFTWARE_LANG == 'fa') ? 'parvazBookingLocal' : 'ticketForeign';
            $message .= $agency['MainDomain'] . "/gds/pdf&target=" . $target . "&id=" . $request_number;


            try {
                $mail = new PHPMailer(true);
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'generaltravel2000@gmail.com';
                $mail->Password   = 'atcaqnobmlsjcywc';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom('generaltravel2000@gmail.com', $agency['AgencyName']);
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = $subject;
                $mail->Body    = $message;

                $mailSend = $mail->send();


                return 'success : درخواست شما با موفقیت ارسال شد';


            } catch (Exception $e) {
                return 'error : خطا در ثبت درخواست، لطفا مجددا اقدام نمائید';
            }
        } else {
            return 'error : خطا در ثبت درخواست، لطفا مجددا اقدام نمائید';
        }
    }

    public function SendHotelEmailForOther($email, $factor_number, $typeApplication) {
        if ($typeApplication == 'hotel') {

            $Model = Load::library('Model');
            $sql = " SELECT * FROM book_hotel_local_tb WHERE factor_number='{$factor_number}'";
            $res_model = $Model->load($sql);

            $pdfUrl = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=BookingHotelNew&id=' . $res_model['factor_number'];
            $titleTop = 'رزرو هتل';
            $title = 'هتل';
            $name = $res_model['hotel_name'];
            $city = $res_model['city_name'];

        } else if ($typeApplication == 'europcar') {

            $res_model = functions::GetInfoEuropcar($factor_number);

            $pdfUrl = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=BookingEuropcarLocal&id=' . $res_model['factor_number'];
            $titleTop = 'اجاره خودرو';
            $title = 'خودرو';
            $name = $res_model['car_name'];
            $city = '';

        } else if ($typeApplication == 'tour') {

            $res_model = functions::GetInfoTour($factor_number);

            $pdfUrl = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=BookingTourLocal&id=' . $res_model['factor_number'];
            $titleTop = 'رزرو تور';
            $title = 'تور';
            $name = $res_model['tour_name'] . ' - ' . $res_model['tour_code'];
            $city = '';

        } else if ($typeApplication == 'busTicket') {

            $res_model = functions::GetInfoBus($factor_number);

            $pdfUrl = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingBusShow&id=' . $res_model['passenger_factor_num'];
            $titleTop = 'رزرو اتوبوس';
            $title = 'اتوبوس';
            $name = $res_model['OriginCity'] . ' - ' . $res_model['DestinationCity'];
            $city = '';
        }


        if (!empty($res_model)) {

            $param['title'] = $titleTop . ' ' . $name;
            if ($city != '') {
                $param['title'] .= ' ' . $city;
            }
            $param['body'] = '
                    با سلام <br>
دوست عزیز؛ این پیام به درخواست ' . $res_model['member_name'] . ' برای شما ارسال شده است <br>
 ایشان برای شما ' . $title . ' رزرو کرده اند،
                    لطفا جهت مشاهده و چاپ واچر ' . $title . ' بر روی دکمه چاپ واچر ' . $title . ' که در قسمت پایین قرار دارد کلیک نمایید
                    ';
            $param['pdf'][0]['url'] = $pdfUrl;
            $param['pdf'][0]['button_title'] = 'چاپ واچر ' . $title;

            $to = $email;
            $subject = "رزرو " . $title;
            $message = functions::emailTemplate($param);
            $headers = "From: noreply@" . CLIENT_DOMAIN . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8";
            ini_set('SMTP', 'smtphost');
            ini_set('smtp_port', 25);
            if (mail($to, $subject, $message, $headers)) {
                return 'success : درخواست شما با موفقیت ارسال شد';
            } else {
                return 'error : خطا درثبت درخواست ،لطفا مجددا اقدام نمائید';
            }
        } else {
            return 'error : خطا درثبت درخواست ،لطفا مجددا اقدام نمائید';
        }


    }

    public function SendInsuranceEmailForOther($email, $factor_number) {
        $Model = Load::library('Model');
        $sql = " SELECT * FROM book_insurance_tb WHERE factor_number='{$factor_number}'";
        $res_model = $Model->load($sql);

        if (!empty($res_model)) {

            $bookingInsurance = Load::controller('bookingInsurance');
            $res_pdf = $bookingInsurance->bookRecordsByFactorNumber($factor_number);
            $count_reserve = count($res_pdf);

            /*$emailContent = '
            <tr>
                <td valign="top" class="mcnTextContent" style="padding: 18px;color: #000000;font-size: 14px;font-weight: normal;text-align: center;">
                    <h3 class="m_-2679729263370124627null" style="text-align:center;display:block;margin:0;padding:0;color:#000000;font-family:tahoma,verdana,segoe,sans-serif;font-size:22px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal">
 رزرو '.$count_reserve.' عدد بیمه
                        <span style="color:#FFFFFF"><strong>' . $res_model['caption'] . '</strong></span>
به مقصد
                        <span style="color:#FFFFFF"><strong>' . $res_model['destination'] . '</strong></span>
                    </h3>
                    <div style="margin-top: 20px;text-align:right;color:#FFFFFF; font-family:tahoma,verdana,segoe,sans-serif">
                    با سلام <br>
دوست عزیز؛ این پیام به درخواست ' . $res_model['member_name'] . ' ' . $res_model['member_family'] . ' برای شما ارسال شده است <br>
                   ایشان برای شما بیمه نامه رزرو کرده اند،
                   لطفا جهت مشاهده و چاپ بیمه نامه ها روی دکمه چاپ بیمه نامه مربوطه که در قسمت پایین قرار دارد کلیک نمایید
                    </div>
                </td>
            </tr>
            ';*/

            //$pdfButton = '';
            foreach ($res_pdf as $k => $each) {

                $param['pdf'][$k]['url'] = $bookingInsurance->getReservePdf($each['source_name'], $each['pnr']);
                $param['pdf'][$k]['button_title'] = 'چاپ بیمه نامه ' . $each['passenger_name'] . ' ' . $each['passenger_family'];

                /*$pdfButton .= '
                <tr>
                    <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 14px;">
                        <a class="mcnButton " title="چاپ بیمه نامه" href="' . $bookingInsurance->getReservePdf($each['source_name'], $each['pnr']) . '" target="_blank" style="background-color: #284861;padding: 15px;margin:5px 0;border-radius: 10px;font-weight: bold;letter-spacing: 0px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">چاپ بیمه نامه '.$each['passenger_name'].' '.$each['passenger_family'].'</a>
                    </td>
                </tr>
                ';*/
            }


            $param['title'] = 'رزرو ' . $count_reserve . ' عدد بیمه ' . $res_model['caption'] . 'به مقصد' . $res_model['destination'];
            $param['body'] = '
                    با سلام <br>
دوست عزیز؛ این پیام به درخواست ' . $res_model['member_name'] . ' ' . $res_model['member_family'] . ' برای شما ارسال شده است <br>
                   ایشان برای شما بیمه نامه رزرو کرده اند،
                   لطفا جهت مشاهده و چاپ بیمه نامه ها روی دکمه چاپ بیمه نامه مربوطه که در قسمت پایین قرار دارد کلیک نمایید
                    ';;


            $to = $email;
            $subject = "خرید بیمه مسافرتی";
            $message = functions::emailTemplate($param);
            $headers = "From: noreply@" . CLIENT_DOMAIN . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8";
            ini_set('SMTP', 'smtphost');
            ini_set('smtp_port', 25);
            if (mail($to, $subject, $message, $headers)) {
                return 'success : درخواست شما با موفقیت ارسال شد';
            } else {
                return 'error : خطا درثبت درخواست ،لطفا مجددا اقدام نمائید';
            }
        } else {
            return 'error : خطا درثبت درخواست ،لطفا مجددا اقدام نمائید';
        }
    }

    public function SendVisaEmailForOther($email, $factor_number) {
        $bookingVisa = Load::controller('bookingVisa');
        $visaInfo = $bookingVisa->bookInfo($factor_number);

        if (!empty($visaInfo)) {

            $res_pdf = $bookingVisa->bookRecords($factor_number);
            $count_reserve = count($res_pdf);

            /*$emailContent = '
            <tr>
                <td valign="top" class="mcnTextContent" style="padding: 18px;color: #000000;font-size: 14px;font-weight: normal;text-align: center;">
                    <h3 class="m_-2679729263370124627null" style="text-align:center;display:block;margin:0;padding:0;color:#000000;font-family:tahoma,verdana,segoe,sans-serif;font-size:22px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal">
 رزرو '.$count_reserve.' عدد
                        <span style="color:#FFFFFF"><strong>' . $visaInfo['visa_title'] . '</strong></span>
به مقصد
                        <span style="color:#FFFFFF"><strong>' . $visaInfo['visa_destination'] . '</strong></span>
                    </h3>
                    <div style="margin-top: 20px;text-align:right;color:#FFFFFF; font-family:tahoma,verdana,segoe,sans-serif">
                    با سلام <br>
دوست عزیز؛ این پیام به درخواست ' . $visaInfo['member_name'] . ' ' . $visaInfo['member_family'] . ' برای شما ارسال شده است <br>
                   ایشان برای شما ویزا رزرو کرده اند،
                   لطفا جهت مشاهده و چاپ واچر(های) ویزا روی دکمه چاپ واچر مربوطه که در قسمت پایین قرار دارد کلیک نمایید
                    </div>
                </td>
            </tr>
            ';*/

            //$pdfButton = '';
            foreach ($res_pdf as $k => $each) {

                $param['pdf'][$k]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingVisa&id=' . $each['unique_code'];
                $param['pdf'][$k]['button_title'] = 'چاپ بیمه نامه ' . $each['passenger_name'] . ' ' . $each['passenger_family'];

                /*$pdfButton .= '
                <tr>
                    <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 14px;">
                        <a class="mcnButton " title="چاپ واچر" href="' . ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingVisa&id=' . $each['unique_code'] . '" target="_blank" style="background-color: #284861;padding: 15px;margin:5px 0;border-radius: 10px;font-weight: bold;letter-spacing: 0px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">چاپ بیمه نامه '.$each['passenger_name'].' '.$each['passenger_family'].'</a>
                    </td>
                </tr>
                ';*/
            }

            $param['title'] = 'رزرو ' . $count_reserve . ' عدد ' . $visaInfo['visa_title'] . 'به مقصد ' . $visaInfo['visa_destination'];
            $param['body'] = '
                    با سلام <br>
دوست عزیز؛ این پیام به درخواست ' . $visaInfo['member_name'] . ' ' . $visaInfo['member_family'] . ' برای شما ارسال شده است <br>
                   ایشان برای شما ویزا رزرو کرده اند،
                   لطفا جهت مشاهده و چاپ واچر(های) ویزا روی دکمه چاپ واچر مربوطه که در قسمت پایین قرار دارد کلیک نمایید
                    ';


            $to = $email;
            $subject = "رزرو ویزا";
            $message = functions::emailTemplate($param);
            $headers = "From: noreply@" . CLIENT_DOMAIN . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8";
            ini_set('SMTP', 'smtphost');
            ini_set('smtp_port', 25);
            if (mail($to, $subject, $message, $headers)) {
                return 'success : درخواست شما با موفقیت ارسال شد';
            } else {
                return 'error : خطا درثبت درخواست ،لطفا مجددا اقدام نمائید';
            }
        } else {
            return 'error : خطا درثبت درخواست ،لطفا مجددا اقدام نمائید';
        }
    }

    public function addCreditToReagent() {
        //get user's info
        $this->get();

        if (Session::IsLogin() && $this->list['fk_counter_type_id'] == '5') {

            $members = Load::model('members');
            if (!$members->memberHasFirstBuy($this->list['id'])) {

                //add credit for user's reagent
                $presenterReagentCode = $members->getPresenterReagentCode($this->list['id']);
                if ($presenterReagentCode != '0') {
                    $presenter = $members->getByReagentCode($presenterReagentCode);

                    $reagentPoint = Load::controller('reagentPoint');
                    $reagentPointAmount = $reagentPoint->GetReagentPoint();

                    $dataCredit['memberId'] = $presenter['id'];
                    $dataCredit['amount'] = $reagentPointAmount;
                    $dataCredit['state'] = 'charge';
                    $dataCredit['reason'] = 'reagent_code_presenter';
                    $dataCredit['comment'] = 'اعتبار هدیه شده بابت معرفی ' . $this->list['name'] . ' ' . $this->list['family'] . '، استفاده از کد تخفیف ' . $presenterReagentCode;
                    $dataCredit['reagentCode'] = $presenterReagentCode;
                    $dataCredit['status'] = 'success';
                    $members->membersCreditAdd($dataCredit);
                }

                //add first buy of this user
                $members->memberFirstBuyAdd($this->list['id']);
            }
        }

    }

    /**
     * get one counter
     * @return information array
     */
    public function get($fields = array()) {
        $model = Load::model('members');
        $this->list = $model->get($this->userID);
     }

    public function getMemberCredit() {

        //get user's info
        $this->get();

        $userId = Session::getUserId();
        /** @var members_tb $members */
        $members = Load::model('members');
        $credit = $members->getMemberCredit($userId);

        return $credit;
    }

    public function getAllMemberCredits() {
        //get user's info
        $this->get();

        $members = Load::model('members');

        return $members->memberCreditsList($this->list['id']);
    }

    #region memberCreditConfirm: set credit record from pending to success by factor number couse it's unique

    public function memberCreditConfirm($factorNumber, $bankTrackingCode) {
        $Model = Load::library('Model');

        $data['status'] = 'success';
        if ($bankTrackingCode != 'member_credit') {
            $data['bankTrackingCode'] = $bankTrackingCode;
        }
        $data['lastEditInt'] = time();

        $Condition = " factorNumber = '{$factorNumber}'";
        $Model->setTable('members_credit_tb');
        $Model->update($data, $Condition);
    }
    #endregion

    #region reduceAmountViaMemberCredit

    public function reduceAmountViaMemberCredit($amount, $factorNumber, $memberId) {
        $members = Load::model('members');
        $credit = $members->getMemberCredit($memberId);
        if ($credit > 0) {
            $dataCredit['memberId'] = $memberId;
            $dataCredit['amount'] = ($credit > $amount ? $amount : $credit);
            $dataCredit['factorNumber'] = $factorNumber;
            $dataCredit['state'] = 'buy';
            $dataCredit['reason'] = 'buy';
            $dataCredit['comment'] = 'کسر از اعتبار برای خرید با شماره فاکتور ' . $factorNumber;
            $dataCredit['status'] = 'pending';
            $addResult = $members->membersCreditAdd($dataCredit);
            if ($addResult) {
                $amount -= $credit;
            }
        }

        return $amount;
    }
    #endregion

    #region presentedMembers: list of members used reagent code of a specified member

    public function presentedMembers($id) {
        $members = Load::model('members');
        $info = $members->get($id);

        return $members->getPresentedMembers($info['reagent_code']);
    }
    #endregion

    #region infoZomorod

    /**
     * @param $UserId
     */
    public function infoZomorod($UserId) {
        $Model = Load::library('Model');
        $TicketInfoSql = "SELECT count(DISTINCT request_number) AS TicketCount FROM book_local_tb WHERE member_id='{$UserId}' AND (successfull='book')";
        $CountTicket = $Model->load($TicketInfoSql);

        $TicketInfoSql = "SELECT count(DISTINCT factor_number) AS HotelCount FROM book_hotel_local_tb WHERE member_id='{$UserId}' AND status='BookedSuccessfully'";
        $CountHotel = $Model->load($TicketInfoSql);

        $TicketInfoSql = "SELECT count(DISTINCT factor_number) AS insuranceCount FROM book_insurance_tb WHERE member_id='{$UserId}' AND status='book'";
        $CountInsurance = $Model->load($TicketInfoSql);

        return $CountTicket['TicketCount'] + $CountHotel['HotelCount'] + $CountInsurance['insuranceCount'];
    }

    #endregion

    public function showBankDetails($UserId) {
        $Model = Load::library('Model');
        $sql = "SELECT * FROM counter_details_tb WHERE idmember='{$UserId}'";
        $bankDetails = $Model->load($sql);

        return $bankDetails;

    }

    public function updateBankCounter($data) {
        $edit = '';
        $detail['name_hesab'] = $data['nameHesab'];
        $detail['sheba'] = $data['sheba'];
        $detail['bank_hesab'] = $data['hesabBank'];
        $detail['idmember'] = $data['memberID'];
        $result_status = '';
        $Model = Load::library('Model');
        $Model->setTable('counter_details_tb');
        $sql = "select * from counter_details_tb where  idmember = '{$detail['idmember']}'";
        $profile = $Model->load($sql);
        $edit = $profile['sheba'];
        if ($data['typeMember'] == 'mother') {
            if ($edit == '') {
                $config = Load::Config('application');
                $success = $config->UploadFile("pic", "picture", "200000");
                $explod_name_pic = explode(':', $success);

                if ($explod_name_pic[0] == "done") {
                    $detail['picture'] = $explod_name_pic[1];
                }

                if (!empty($detail['picture'])) {
                    $result = $Model->insertLocal($detail);
                    if ($result) {
                        echo 'success : اطلاعات حساب شما ثبت شد';
                    } else {
                        echo 'error : خطا در ثبت اطلاعات';
                    }
                } else {
                    echo 'error : لطفا تصویر پرسنلی را با فرمت صحیح ارسال نمائید';
                }

            } else {
                if (empty($_FILES['picture'])) {
                    $sql = "SELECT * FROM counter_details_tb WHERE idmember= '{$detail['idmember']}'";
                    $result = $Model->load($sql);
                    $success = "done:" . $result['picture'];
                    $explod_name_pic = explode(':', $success);
                    $detail['picture'] = $explod_name_pic[1];
                } else {
                    $config = Load::Config('application');
                    $success = $config->UploadFile("pic", "picture", "200000");
                    $explod_name_pic = explode(':', $success);
                    if ($explod_name_pic[0] == "done") {
                        $detail['picture'] = $explod_name_pic[1];
                    }

                }

                if (!empty($detail['picture'])) {
                    $condition = 'idmember=' . $detail['idmember'] . '';
                    $result = $Model->Update($detail, $condition);
                    if ($result) {
                        echo 'success : اطلاعات حساب شما ثبت شد';
                    } else {
                        echo 'error : خطا در ثبت اطلاعات';
                    }
                } else {
                    echo 'error : لطفا تصویر پرسنلی را با فرمت صحیح ارسال نمائید';
                }

            }
        } else {
            if ($edit == '') {

                $result = $Model->insertLocal($detail);
                if ($result) {
                    echo 'success :اطلاعات حساب شما ثبت شد';
                } else {
                    echo 'error : خطا در ثبت اطلاعات';
                }


            } else {

                $condition = 'idmember=' . $detail['idmember'] . '';
                $result = $Model->Update($detail, $condition);
                if ($result) {
                    echo 'success : اطلاعات حساب شما بروزرسانی شد';

                } else {
                    echo 'error : خطا در ثبت اطلاعات';
                }
            }

        }

        return $result_status;
    }

    public function SendGashtEmailForOther($email, $factor_number) {
        $infoBook = functions::GetInfoGasht($factor_number);

        if (!empty($infoBook)) {

            /*$emailContent = '
            <tr>
                <td valign="top" class="mcnTextContent" style="padding: 18px;color: #000000;font-size: 14px;font-weight: normal;text-align: center;">
                    <h3 class="m_-2679729263370124627null" style="text-align:center;display:block;margin:0;padding:0;color:#000000;font-family:tahoma,verdana,segoe,sans-serif;font-size:22px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal">
 رزرو   گشت و ترانسفر
                        <span style="color:#FFFFFF"><strong>' . $infoBook['passenger_serviceName'] . '</strong></span>
به مقصد
                        <span style="color:#FFFFFF"><strong>' . $infoBook['passenger_serviceCityName'] . '</strong></span>
                    </h3>
                    <div style="margin-top: 20px;text-align:right;color:#FFFFFF; font-family:tahoma,verdana,segoe,sans-serif">
                    با سلام <br>
دوست عزیز؛ این پیام به درخواست ' . $infoBook['passenger_name'] . ' ' . $infoBook['passenger_family'] . ' برای شما ارسال شده است <br>
ایشان برای شما '.($infoBook['passenger_serviceRequestType']==0?'گشت':'ترانسفر').' رزرو کرده اند،
                   لطفا جهت مشاهده و چاپ واچر روی دکمه چاپ واچر مربوطه که در قسمت پایین قرار دارد کلیک نمایید
                    </div>
                </td>
            </tr>
            ';*/
            /*$pdfButton .= '

            <tr>
                <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 14px;">
                    <a class="mcnButton " title="چاپ واچر" href="' . ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingGasht&id=' . $infoBook['passenger_factor_num'] . '" target="_blank" style="background-color: #284861;padding: 15px;margin:5px 0;border-radius: 10px;font-weight: bold;letter-spacing: 0px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">چاپ واچر ' . $infoBook['passenger_name'] . ' ' . $infoBook['passenger_family'] . '</a>
                </td>
            </tr>
            ';*/

            $param['title'] = ' رزرو   گشت و ترانسفر ' . $infoBook['passenger_serviceName'] . ' به مقصد ' . $infoBook['passenger_serviceCityName'];
            $param['body'] = '
                    با سلام <br>
دوست عزیز؛ این پیام به درخواست ' . $infoBook['passenger_name'] . ' ' . $infoBook['passenger_family'] . ' برای شما ارسال شده است <br>
ایشان برای شما ' . ($infoBook['passenger_serviceRequestType'] == 0 ? 'گشت' : 'ترانسفر') . ' رزرو کرده اند،
                   لطفا جهت مشاهده و چاپ واچر روی دکمه چاپ واچر مربوطه که در قسمت پایین قرار دارد کلیک نمایید
                    ';
            $param['pdf'][0]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingGasht&id=' . $infoBook['passenger_factor_num'];
            $param['pdf'][0]['button_title'] = 'چاپ واچر ' . $infoBook['passenger_name'];

            $to = $email;
            $subject = "خرید گشت و ترانسفر";
            $message = functions::emailTemplate($param);
            $headers = "From: noreply@" . CLIENT_DOMAIN . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8";
            ini_set('SMTP', 'smtphost');
            ini_set('smtp_port', 25);

            if (mail($to, $subject, $message, $headers)) {

                return 'success : درخواست شما با موفقیت ارسال شد';
            } else {

                return 'error : خطا درثبت درخواست ،لطفا مجددا اقدام نمائید';
            }
        } else {

            return 'error : خطا درثبت درخواست ،لطفا مجددا اقدام نمائید';
        }
    }

    public function SendBusEmailForOther($email, $factor_number) {
        $infoBook = functions::GetInfoBus($factor_number);

        if (!empty($infoBook)) {

            $param['title'] = 'رزرو   بلیط اتوبوس از' . $infoBook['OriginName'] . ' به مقصد ' . $infoBook['SelectedDestName'];
            $param['body'] = '
                    با سلام <br>
دوست عزیز؛ این پیام به درخواست ' . $infoBook['passenger_name'] . ' ' . $infoBook['passenger_family'] . ' برای شما ارسال شده است <br>
ایشان برای شما بلیط اتوبوس رزرو کرده اند،
                   لطفا جهت مشاهده و چاپ بلیط روی دکمه چاپ بلیط مربوطه که در قسمت پایین قرار دارد کلیک نمایید
                    ';
            $param['pdf'][0]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingBusApi&id=' . $infoBook['passenger_factor_num'];
            $param['pdf'][0]['button_title'] = 'چاپ بلیط' . $infoBook['passenger_name'] . ' ' . $infoBook['passenger_family'];


            $to = $email;
            $subject = "خرید بلیط اتوبوس";
            $message = functions::emailTemplate($param);
            $headers = "From: noreply@" . CLIENT_DOMAIN . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8";
            ini_set('SMTP', 'smtphost');
            ini_set('smtp_port', 25);

            if (mail($to, $subject, $message, $headers)) {

                return 'success : درخواست شما با موفقیت ارسال شد';
            } else {

                return 'error : خطا درثبت درخواست ،لطفا مجددا اقدام نمائید';
            }
        } else {

            return 'error : خطا درثبت درخواست ،لطفا مجددا اقدام نمائید';
        }
    }
    public function SendTrainEmailForOther($email, $factor_number) {
        $infoBook = functions::GetInfoTrain($factor_number);

        if (!empty($infoBook)) {

            $param['title'] = 'رزرو   بلیط قطار از' . $infoBook[0]['Departure_City'] . ' به مقصد ' . $infoBook[0]['Arrival_City'];
            $param['body'] = '
                    با سلام <br>
دوست عزیز؛ این پیام به درخواست ' . $infoBook[0]['passenger_name'] . ' ' . $infoBook[0]['passenger_family'] . ' برای شما ارسال شده است <br>
ایشان برای شما بلیط قطار رزرو کرده اند،
                   لطفا جهت مشاهده و چاپ بلیط روی دکمه چاپ بلیط مربوطه که در قسمت پایین قرار دارد کلیک نمایید
                    ';
            $param['pdf'][0]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=trainBooking&id=' . $infoBook[0]['requestNumber'];
            $param['pdf'][0]['button_title'] = 'چاپ بلیط' . $infoBook[0]['passenger_name'] . ' ' . $infoBook[0]['passenger_family'];


            $to = $email;
            $subject = "خرید بلیط قطار";
            $message = functions::emailTemplate($param);
            $headers = "From: noreply@" . CLIENT_DOMAIN . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8";
            ini_set('SMTP', 'smtphost');
            ini_set('smtp_port', 25);
          
            if (mail($to, $subject, $message, $headers)) {

                return 'success : درخواست شما با موفقیت ارسال شد';
            } else {

                return 'error : خطا درثبت درخواست ،لطفا مجددا اقدام نمائید';
            }
        } else {

            return 'error : خطا درثبت درخواست ،لطفا مجددا اقدام نمائید';
        }
    }


    public function updateMembersClub() {

        $membersModel = Load::model('members');

        $members = $membersModel->getAll();

        $allMembersClub = $this->getMemberClub();


        foreach ($allMembersClub as $keyMembers => $valMembers) {
            $allMembersClubCartNumber[] = $valMembers['shomare_cart'];
        }


        foreach ($members as $member) {
            if (!in_array($member['card_number'], $allMembersClubCartNumber)) {
                $memberForUpdate[] = $member;
            }
        }


        if (!empty($memberForUpdate)) {
            $url = "https://www.iran-tech.com/old/v10/fa/admin/cronjob/insertDataToClubOfGds.php";

            $data['method'] = 'updateMembers';
            $data['Domain'] = CLIENT_MAIN_DOMAIN;
            $data['members'] = $memberForUpdate;

            $dataSend = json_encode($data);
            $result = functions::curlExecution($url, $dataSend);
            functions::insertLog('LogInsertUserClub=>' . $dataSend . '===>result: ' . json_encode($result), 'LogInsertUserClub');
            if ($result['status'] == 'success') {

                $dataMessage['message'] = $result['message'];
                $dataMessage['status'] = 'success';

                return json_encode($dataMessage);
            }
            $dataMessage['message'] = $result['message'];
            $dataMessage['status'] = 'error';

            return json_encode($dataMessage);
        }
        $dataMessage['message'] = "کاربر جدید برای ثبت در باشگاه وجود ندارد";
        $dataMessage['status'] = 'error';

        return json_encode($dataMessage);


    }

    public function getMemberClub() {
        $url = "https://www.iran-tech.com/old/v10/fa/admin/cronjob/insertDataToClubOfGds.php";

        $data['method'] = 'getAllMembersClub';
        $data['Domain'] = CLIENT_MAIN_DOMAIN;

        $dataSend = json_encode($data);
        functions::insertLog('logGetMembersClub=>' . $dataSend, 'logAllMembers');
        $result = functions::curlExecution($url, $dataSend);
        functions::insertLog('logGetMembersClub=>' . json_encode($result), 'logAllMembers');

        return $result;
    }

    public function findMemberByClubId($clubId) {
        $Model = Load::library('Model');

        $sql = "SELECT * FROM members_tb WHERE card_number='{$clubId}'";

        return $Model->load($sql);
    }

    public function findMemberByEmail($email) {
        $Model = Load::library('Model');

        $sql = "SELECT * FROM members_tb WHERE email='{$email}'";

        return $Model->load($sql);
    }

    public function findMemberCredit($factorNumber, $state = null) {
        $Model = Load::library('Model');

        if ($state == null) {
            $state = 'buy';
        }
        $sqlCheckExistCredit = "SELECT * FROM members_credit_tb WHERE  factorNumber='{$factorNumber}' AND state='{$state}'";

        return $Model->load($sqlCheckExistCredit);
    }

    public function sendDataToClub() {
        $bookshow = Load::controller('bookshow');
        $Model = Load::library('Model');
        if (IS_ENABLE_CLUB == '1') {

            $lastUpdate = $this->findLastUpdateClub();
            if (empty($lastUpdate)) {
                $buyUser = $bookshow->ListAllBuyClient();
            } else {
                $buyUser = $bookshow->ListAllBuyClient($lastUpdate);
            }

            if (!empty($buyUser)) {
                $dataHistory['creationDateInt'] = time();
                $dataHistory['memberId'] = Session::getUserId();

                $Model->setTable('history_send_point');
                $Model->insertLocal($dataHistory);

                $data['cardNumber'] = Session::getCardNumber();
                $data['point'] = $buyUser;
                functions::registerBuyInClub($data);
                echo 'success';
            }
        }
    }

    public function findLastUpdateClub() {
        $Model = Load::library('Model');
        $userId = Session::getUserId();

        $timeCalculated = time();
        $threeDayAge = (60 * 60 * 24 * 3);
        $sqlCheckExistCredit = "SELECT * FROM history_send_point WHERE memberId = '{$userId}' AND ('{$timeCalculated}' - creationDateInt) < '{$threeDayAge}'  ORDER BY id DESC  LIMIT 0,1";

        return $Model->load($sqlCheckExistCredit);
    }

    public function listMembersAgency($agencyId) {

        $membersModel = Load::model('members');
        $infoMembersAgency = $membersModel->listMembersAgency($agencyId);

        $dataMemberAgency = array();
        $onlinePassenger = functions::Xmlinformation('OnlinePassenger');
        $guestPassenger = functions::Xmlinformation('GuestPassenger');

        foreach ($infoMembersAgency as $key => $item) {

            $dataMemberAgency[$key]['column'] = $key + 1;
            $dataMemberAgency[$key]['nameAndFamily'] = $item['name'] . ' ' . $item['family'];
            $dataMemberAgency[$key]['email'] = $item['email'];
            $dataMemberAgency[$key]['mobile'] = $item['mobile'];
            $dataMemberAgency[$key]['memberId'] = $item['id'];

            if ($this->isCounter($item['id'])) {
                $type_user = 'کانتر';
            } else {
                if ($item['is_member'] == '1') {
                    $type_user = $onlinePassenger[0]->__toString();
                } else {
                    $type_user = $guestPassenger[0]->__toString();
                }
            }
            $dataMemberAgency[$key]['typeUser'] = $type_user;
            $model_passengers = Load::model('passengers');
            $passengerData = $model_passengers->getAllpassengers($item['id']);
            $dataMemberAgency[$key]['passengerCount'] = $passengerData['passengers'];
        }


        $dataMemberAgency = array('data' => $dataMemberAgency);

        return json_encode($dataMemberAgency);

    }

    /**
     * @param array $data
     *
     * @return bool|mixed|string
     */
    public function getUsersListJson($data = array()) {

        $deleted = (string)isset($data['deleted']) ? $data['deleted'] : 'no';

        //		$order = strtoupper( isset( $data['order'] ) ? $data['order'] : 'ASC' );

        $start = $data['start'];
        $limit = $data['length'];

        $order_index = $data['order'][0]['column'];
        $order_dir = $data['order'][0]['dir'];
        $search_value = $data['search']['value'];

        $order_fields = array(
            'id', 'name', 'user_name' , 'register_date'
        );

        /** @var Model $Model */
        $Model = Load::library('Model');

        $result = $Model->setTable('members_tb', true)->get(array(
            'id',
            'name',
            'family',
            'mobile',
            'email',
            'user_name',
            'fk_counter_type_id',
            'fk_agency_id',
            'active',
            'register_date'
        ))->where('fk_counter_type_id', '5')
            ->where('del', $deleted)
            ->where('is_member', '1')
            ->openParentheses()
            ->like('name', $search_value)
            ->like('family', $search_value)
            ->like('user_name', $search_value)
            ->closeParentheses()
            ->orderBy($order_fields[$order_index], $order_dir)
            ->limit($start, $limit)
            ->all(false);

        $total = $Model->get('count(id) AS count', true)
            ->where('fk_counter_type_id', '5')
            ->where('del', $deleted)
            ->where('is_member', '1')
            ->find(false);
        $response = array();
        if (!empty($result)) {
            $columns = array(
                array('title' => 'ردیف', 'data' => 'rowNumber'),
                array('title' => 'نام و نام خانوادگی', 'data' => 'nameAndFamily')
            );
            foreach ($result as $key => $item) {
                $response[$key]['rowNumber'] = $key + 1;
                $response[$key]['nameAndFamily'] = $item['name'] . ' ' . $item['family'];
                $response[$key]['user_name'] = $item['user_name'];
                $status_html = '<a href="#" onclick="active_User(\'' . $item['id'] . '\'); return false;">';
                if ($item['active'] == 'on') {
                    $status_html .= '<input type="checkbox" class="js-switch" data-color="#99d683" data-secondary-color="#f96262" data-size="small" checked/>';
                } else {
                    $status_html .= '<input type="checkbox" class="js-switch" data-color="#99d683" data-secondary-color="#f96262" data-size="small"/>';
                }
                $status_html .= '</a>';
                $response[$key]['status'] = $status_html;
                $response[$key]['date'] = functions::DateJalali($item['register_date']);
                $response[$key]['modal_button'] = '<button type="button" title="' . $item['id'] . '" data-id="' . $item['id'] . '" data-type-id="' . $item['fk_counter_type_id'] . '" class="fcbtn btn btn-outline btn-primary btn-1f" data-toggle="modal" data-target="#editUserModal">عملیات</button>';
            }

            $result = array(
                'data' => $response,
                'status' => 'success',
                'code' => 200,
                'message' => 'users listed successfully',
                'recordsFiltered' => $total['count'],
                'recordsTotal' => count($response)
            );
            return functions::toJson($result);
        }
        $response = array('rowNumber' => 0, 'nameAndFamily' => '', 'status' => '', 'date' => '', 'modal_button' => '');
        $result = array(
            'data' => $response,
            'status' => 'success',
            'code' => 200,
            'message' => 'users listed successfully',
            'recordsFiltered' => $total,
        );
        return functions::toJson($result);
    }

    /**
     * @param $member_id
     * @return bool
     */
    public function isCounter($member_id = null) {
        $member = $this->getMember($member_id);
        return ($member['fk_counter_type_id'] >= 1 && $member['fk_counter_type_id'] < 5);
    }

    public function getMember($member_id = null) {
        return $this->members_model->getMemberById($member_id);
    }

    public function registerGuestUser($params) {

        $data_register_guest_user = array();
        foreach ($params as $key=>$param){
            $data_register_guest_user[$key] = functions::checkParamsInput($param);
        }

        /*$data_insert_register_guest_user['mobile'] = $data_register_guest_user['mobile'];
        $data_insert_register_guest_user['email'] = $data_register_guest_user['email'];
        $data_insert_register_guest_user['name'] = $data_register_guest_user['full_name'];*/



        $data_insert_register_guest_user['password'] = functions::encryptPassword(functions::randomString(10));
        $data_insert_register_guest_user['email'] = strtolower($data_register_guest_user['email']);
        $data_insert_register_guest_user['name'] = $data_register_guest_user['full_name'];
        $data_insert_register_guest_user['mobile'] = $data_register_guest_user['mobile'];
        $data_insert_register_guest_user['TypeOs'] = functions::getOsUser();
        $data_insert_register_guest_user['fk_counter_type_id'] = '5';
        $data_insert_register_guest_user['fk_agency_id'] = '0';
        $data_insert_register_guest_user['is_member'] = '0';

        $result_register_guest_user = $this->getModel('membersModel')->insertLocal($data_insert_register_guest_user);

        if($result_register_guest_user){
            return functions::withSuccess('',200,'ثبت اطلاعات با موفقیت انجام شد');
        }
        return functions::withError('',400,'خطا در ثبت اطلاعات ،لطفا با پشتیبان تماس بگیرید!');
    }


    public function getMemberCounterByDataLogin($data_member) {
        return $this->getModel('membersModel')->get()
            ->where('email',$data_member['username'])
            ->where('password',functions::encryptPassword($data_member['password']))
            ->where('fk_counter_type_id','5','<>')
            ->find();
    }

    public function getInfoCountersAgency($params){

        $counter_type_table_name  = $this->getModel('counterTypeModel')->getTable();
        $members_table_name  = $this->getModel('membersModel')->getTable();
        $result_info_counter_agency = $this->getModel('membersModel')
            ->get([$members_table_name.'.*', $counter_type_table_name.'.name as title_counter'],true)
            ->join($counter_type_table_name,'id','fk_counter_type_id')
            ->where($members_table_name.'.fk_agency_id',$params['agency_id'])
            ->all();

            if($params['is_json']) {
                return functions::withSuccess($result_info_counter_agency,200,'data fetched successfully');
            }

            return $result_info_counter_agency;


        }


    public function checkExistence($entry) {

        if($this->members_model->getExistMemberByUserName($entry)){
            return true;
        }
            return false;
    }
    public function callCheckExistence($param) {

        return $this->checkExistence($param);
    }

    public function callMemberLogin($params) {

        //todo fix remember me checkbox
        $result =  $this->memberLogin($params['entry'],$params['password'],'off',0,false);
        if($result){
                return true;
        }
        return false;
    }

    public function callMemberRegister($params) {

        $verification_code = $this->getController('verificationCode')->validateCode($params['entry'],$params['password']);
        if($verification_code['status']){
            $result = json_decode($this->memberInsert($params), true);
            $response = [];
            if ($result['success']) {
                $response['data']['member_id'] = Session::getUserId();
            }
            return functions::withError($response,200,"کد تایید شما معتبر می باشد");
        }

        return functions::withError($verification_code['message'],401,"کد تایید شما معتبر نمی باشد");


    }

    public function callAuthenticateDigitCodeCreate($params) {

        /** @var verificationCode $verificationCode */
        $verification_code = $this->getController('verificationCode')->checkExistCodeVerification($params);

        if ($verification_code['status']) {
            return $this->getController('verificationCode')->create($params['entry']);
        }
           return true;
    }
    public function callAuthenticateEditUser($params) {

        $member = $this->members_model->getMemberByUserName($params);
        if($member){
            $data_update_member['name']=$params['name'];
            $data_update_member['family']=$params['family'];
            $data_update_member['password']= functions::encryptPassword($params['password']);

            $result_update =  $this->members_model->updateMember($data_update_member,$member['id']);
            if($result_update){

                if(functions::checkClientConfigurationAccess('call_back')) {
                    $info_member = $this->members_model->getMemberById($member['id']);
                    $call_back_api =$this->getController('callBackUrl');
                    $call_back_api->sendRegisteredUser($info_member , 'edit') ;
                }
                if($params['reagentCode']){
                    $result_repeat = $this->members_model->getReagentCode($params['reagentCode']);
                    if($result_repeat){
                        $member['name'] = $params['name'] ;
                        $result_reagent_code = $this->setPointReagentCode($params['reagentCode'], $member);
                        $this->memberLogin($params['entry'],$params['password'],'off',0,false);
                        return [
                            'status'=>true,
                            'message'=> 'ثبت نام با موفقیت انجام شد',
                        ];
                    }
                    return [
                        'status'=>false,
                        'message'=>'کد معرف وارد شده معتبر نمی باشد'
                    ];
                }
                 $this->memberLogin($params['entry'],$params['password'],'off',0,false);
                return [
                    'status'=>true,
                    'message'=> 'ثبت نام با موفقیت انجام شد',
                ];
            }
            return [
                'status'=>false,
                'message'=>'خطا در تکمیل ثبت نام'
            ];
        }

        return false;
    }

    public function callChangePassword($params) {
        return $this->changePassword($params['password']);
    }
    public function changePassword($password) {
        $member_id=$_SESSION['userId'];
       //check $password length must be bigger than 6

        $member=$this->getModel('membersModel')->get()
            ->where('id',$member_id)
            ->find();

        if($member){

            return $this->getModel('membersModel')->updateWithBind([
                'password'=>functions::encryptPassword($password)
            ],[
                'id'=>$member['id']
            ]);
        }
        return false;
    }

//    public function uploadImageProfile($data) {
//
//            var_dump($_FILES);
//
//        var_dump($data);
//        die;
//    }

    public function getMemberJson() {
        $member = null;
        $member_id = Session::getUserId();
        if($member_id) {
            $member=  $this->getModel('membersModel')->get()
                ->where('id', $member_id)->find();
            $result['result']['status'] = 'success';
        }else {
            $result['result']['status'] = 'error';
        }
        $result['result']['data'] = $member;

        return functions::clearJsonHiddenCharacters(json_encode($result));

    }

    public function registerGustMembers($params) {
        //do not repeat reagent code
        do {
            $reagent_code = functions::generateRandomCode(5);
            $result_repeat = $this->members_model->getReagentCode($reagent_code);
        } while ($result_repeat);

            /** @param string $index Either "email" or "mobile". */
            $type_entry = functions::isMobileOrEmail($params['entry']) ;

            $index = ($type_entry == 'email') ?  'user_name' :  'mobile';
            $data['password'] = functions:: encryptPassword($params['password']);
            $data['user_name'] = strtolower($params['entry']);
            $data['mobile'] = ($type_entry == 'email') ? $params['info_members']['mobile'] : $params['entry'];
            $data['email'] = ($type_entry == 'email') ?  $params['entry'] : $params['info_members']['email'];
            $data['name'] = !empty($params['name']) ? $params['name'] : '';
            $data['family'] =!empty($params['family']) ?  $params['family'] : '';
            $data['TypeOs'] = functions::getOsUser();
            $data['fk_counter_type_id'] = '5';
            $data['fk_agency_id'] = '0';
            $data['is_member'] = '1';
            $data['card_number'] = $this->generateCardNumber();
            $data['reagent_code'] = $reagent_code;

            return $this->members_model->registerGustUser($data,$index);

    }

    public function generateCardNumber() {
        $max_card_number = $this->members_model->getMaxCardNumberMembers();
        return functions::getCodeMember($max_card_number);
    }

    private function insertSpecificMember($params) {

        //do not repeat reagent code
        do {
            list($reagent_code, $result_repeat) = $this->getReagenCode();
        } while ($result_repeat);


        $type_entry = functions::isMobileOrEmail($params['entry']) ;
        $data['password'] = functions:: encryptPassword($params['password']);
        $data['user_name'] = strtolower($params['entry']);
        $data['mobile'] = ($type_entry == 'mobile') ? $params['entry'] : '';
        $data['email'] = ($type_entry == 'email') ?  $params['entry'] : '';
        $data['name'] = !empty($params['name']) ? $params['name'] : '';
        $data['family'] =!empty($params['family']) ?  $params['family'] : '';
        $data['TypeOs'] = functions::getOsUser();
        $data['fk_counter_type_id'] = '5';
        $data['fk_agency_id'] = '0';
        $data['is_member'] = '1';
        $data['card_number'] = $this->generateCardNumber();
        $data['reagent_code'] = $reagent_code;


        $return_result = $this->members_model->registerMember($data);

        return $this->getMember($return_result);
    }


    private function getReagenCode() {
        $reagent_code = functions::generateRandomCode(5);
        $result_repeat = $this->members_model->getReagentCode($reagent_code);
        return array($reagent_code, $result_repeat);
    }

    /**
     * @param $reagentCode
     * @param $member
     */
    public function setPointReagentCode($reagentCode, $member) {
            $reagentResult = $this->members_model->getReagentCode($reagentCode);
            if ($reagentResult) {
                $reagentPointAmount = $this->getController('reagentPoint')->GetReagentPoint();
                $data_credit['memberId'] = $member['id'];
                $data_credit['amount'] = $reagentPointAmount;
                $data_credit['state'] = 'charge';
                $data_credit['reason'] = 'reagent_code_presented';
                $data_credit['comment'] = 'اعتبار هدیه شده هنگام ثبت نام بابت ارائه کد معرف ' . $reagentResult['name'] . ' ' . $reagentResult['family'] . ' با کد ' . $reagentResult['reagent_code'];
                $data_credit['reagentCode'] = $reagentCode;
                $data_credit['status'] = 'success';
                $data_credit['factorNumber'] = substr(time(), 0, 5) . mt_rand(000, 999) . substr(time(), 5, 10);
                $data_credit['creationDateInt'] = time();
                $this->getController('memberCredit')->addCreditMemberForReagentCode($data_credit);
                $data_credit['memberId'] = $reagentResult['id'];
                $data_credit['reagentCode'] = null;
                $data_credit['comment'] = 'اعتبار هدیه شده بابت ثبت نام کاربر '.$member['name']. ' ' . $member['family'] .'   از طریق استفاده از کد معرف ' . $reagentResult['reagent_code'];
                $this->getController('memberCredit')->addCreditMemberForReagentCode($data_credit);

            }
        }

        public function checkReagentCode($params) {
            return  $this->members_model->getReagentCode($params['reagentCode']);
        }




    public function showInfoCurrency($currency_code) {
        /** @var currency $info_currency */
        $currency_controller = Load::controller('currency');
        $info_currency = $currency_controller->ShowInfo($currency_code);
        return $info_currency ;
    }

    public function changeMemberToCounter($param) {
        $Model = Load::library('Model');
        if (!isset($param['typeCounterId'])) {
            return 'error : لطفا کارنتر را انتخاب نمائید';
        }
        if (!isset($param['agency_id'])) {
            return 'error : لطفا آژانس پذیرنده کانتر را انتخاب نمائید';
        }

        $members_model = Load::model('members');
        $checkExistUser = $members_model->get($param['id']);
        if (!empty($checkExistUser)) {

            $d['fk_counter_type_id'] = $param['typeCounterId'];
            $d['fk_agency_id'] = $param['agency_id'];

            $Model->setTable('members_tb');


            $result = $Model->update($d, "id={$param['id']}");

            if ($result) {
                return functions::toJson(['success' => true, 'message' => 'کاربر با موفقیت به کانتر ارتقا یافت ،شما میتوانید در لیست کانتر ها اطلاعات کاربر را مشاهده نمائید', 'position' => 'change_to_user']);

            } else {
                return functions::toJson(['success' => false, 'message' => 'خطا در ثبت اطلاعات ،لطفا مجددا تلاش فمائید و یا با پشتیبان خود تماس بگیرید', 'position' => 'not_exist_user']);
            }

        } else {
            return functions::toJson(['success' => false, 'message' =>  'کاربر شناسایی نشد ،مجددا تلاش نمائید و در صورت تکرار با پشتیبان خود تماس بگیرید', 'position' => 'not_exist_user']);
        }

    }

    public function updateCounterByAgency($data) {
        /** @var members_tb $model */

        $model = Load::model('members');
        $user = $model->get($data['counter_id']);
        $Connection = new Model();
        if (!$user['entry']) {
            return functions::toJson(['success' => false, 'message' => 'کاربری با این مشخصات یافت نشد']);

        }
        $checkMembersExist = $Connection->load("select * from members_tb where   del='no' and id != '{$user['id']}'  ");

        $data_update = [];
        $data_update['email'] = !empty($data['email']) ? strtolower(trim($data['email'])) : '';

        if (!empty($data['password'])) {
            $data_update['password'] = $model->encryptPassword($data['password']);
        }

        $result = $model->updateWithBind($data_update, ['id' => $user['id']]);
        if ($result) {
            return functions::toJson(['success' => true, 'message' => 'ویرایش با موفقیت انجام شد']);
            return 'success : ';
        }
        return functions::toJson(['success' => false, 'message' => 'خطا در بروزرسانی اطلاعات کانتر']);

    }
    public function changeUserRolePassword($params) {

        //check $password length must be bigger than 6

        $member=$this->getModel('membersModel')->get()
            ->where('id',$params['user_id'])
            ->find();

        if($member){

            return $this->getModel('membersModel')->updateWithBind([
                'password'=>functions::encryptPassword($params['password'])
            ],[
                'id'=>$member['id']
            ]);
        }
        return false;
    }
    public function UpdateGuestUsers($data) {
        $Model = Load::library('Model');

        $check_exist_cancel = $this->getModel('membersModel')->get()->where('mobile', $data['mobile'])->find();

        if ($check_exist_cancel) {
            $dataUpdate['name']=$data['name'];
            $dataUpdate['family']=$data['family'];
            $dataUpdate['is_member']=$data['is_member'];
            $Model->setTable('members_tb');
            $Condition="mobile={$data['mobile']} AND email='{$data['email']}' AND is_member=0  ";
            $UpdateResult = $Model->update($dataUpdate, $Condition);
            if($UpdateResult){
                return "success : در خواست شما با موفقیت انجام شد";
            }
        }
        return "error : درخواست معتبر نمی باشد";
    }
}