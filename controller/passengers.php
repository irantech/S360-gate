<?php
//if($_SERVER['REMOTE_ADDR']=='151.243.6.158') {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}
/**
 * Class Passengers
 * @property Passengers $Passengers
 */
class Passengers extends clientAuth {

    public $name = '';
    public $nameEn = '';
    public $family = '';
    public $familyEn = '';
    public $gender = '';
    public $birthday = '';
    public $passportCountry = '';
    public $passportNumber = '';
    public $passportExpire = '';
    public $memberID = '';
    public $deleteID = '';
    public $passengers;
    public $list = array();     //array that include list of counter Types
    protected $passengers_model;

    public function __construct() {
        //////////// delet one counter///////////////////
        parent::__construct();
        $this->passengers_model = $this->getModel('passengersModel');
    }
    public function monthsPersian($value = '') {
        $month = Array();
        $month[1]='فروردین';
        $month[2]='اردیبهشت';
        $month[3]='خرداد';
        $month[4]='تیر';
        $month[5]='مرداد';
        $month[6]='شهریور';
        $month[7]='مهر';
        $month[8]='آبان';
        $month[9]='آذر';
        $month[10]='دی';
        $month[11]='بهمن';
        $month[12]='اسفند';
        return $month;
    }
    public function monthsMiladi() {
        $month = Array();
        $month[1]='January';
        $month[2]='February';
        $month[3]='March';
        $month[4]='April';
        $month[5]='May';
        $month[6]='June';
        $month[7]='July';
        $month[8]='August';
        $month[9]='September';
        $month[10]='October';
        $month[11]='November';
        $month[12]='December';
        return $month;
    }
    public function changeMonthIr($data = '') {
        $index = self::monthsPersian();
        for ($i = 1; $i < count($index)+1; $i++) {
            if ($i < 10) {
                $i = ltrim($i, '0');
            }
            if ($i ==  $data) {
                $result = $index[$i];
            }
        }
        return $result;
    }
    public function changeMonthNoIr($data = '') {
        $index = self::monthsMiladi();
        for ($i = 1; $i < count($index)+1; $i++) {
            if ($i < 10) {
                $i = ltrim($i, '0');
            }
            if ($i ==  $data) {
                $result = $index[$i];
            }
        }
        return $result;
    }
    public function removeZeroBeginningNumber($data = '') {
        if ($data < 10) {
            $data = ltrim($data, '0');
        }
        return $data;
    }
    public function getAll($fk_members_tb_id=null) {
        $fk_members_tb_id = empty($fk_members_tb_id) ?  Session::getUserId(): $fk_members_tb_id;
        return $this->getModel('passengersModel')->get()->where('fk_members_tb_id',$fk_members_tb_id)->where('del', 'no')->all();
    }
    public function getAllGds($fk_members_tb_id=null) {
        $fk_members_tb_id = empty($fk_members_tb_id) ?  Session::getUserId(): $fk_members_tb_id;
        $result =  $this->getModel('passengersModel')->get()->where('fk_members_tb_id',$fk_members_tb_id)->all();
        foreach ($result as $key => $value) {
            $date_birth_ir = explode('-', $value['birthday_fa'] );
            $result[$key]['date_year_ir'] = $date_birth_ir[0];
            $result[$key]['date_month_ir'] = self::changeMonthIr($date_birth_ir[1]);
            $result[$key]['date_day_ir'] = self::removeZeroBeginningNumber($date_birth_ir[2]);
            $date_birth_en = explode('-', $value['birthday'] );
            $result[$key]['date_year_en'] = $date_birth_en[0];
            $result[$key]['date_month_en'] = self::changeMonthNoIr($date_birth_en[1]);
            $result[$key]['date_day_en'] = self::removeZeroBeginningNumber($date_birth_en[2]);
            $date_passport_expire = explode('-', $value['passportExpire'] );
            $result[$key]['date_passport_expire_year'] = $date_passport_expire[0];
            $result[$key]['date_passport_expire_month'] = self::changeMonthNoIr($date_passport_expire[1]);
            $result[$key]['date_passport_expire_day'] = self::removeZeroBeginningNumber($date_passport_expire[2]);

        }
        return $result;
    }

    public function showedit($id) {
        Load::autoload('Model');
        $Model = new Model();
        if (isset($id) && !empty($id)) {
            $edit_query = " SELECT * FROM  passengers_tb  WHERE id='{$id}'";
            $res_edit = $Model->load($edit_query);
            if (!empty($res_edit)) {
                $this->list = $res_edit;
            } else {
                header("Location: " . ROOT_ADDRESS_WITHOUT_LANG .'/'. FOLDER_ADMIN ."/404.tpl");
            }
        } else {
            header("Location: " . ROOT_ADDRESS_WITHOUT_LANG .'/'. FOLDER_ADMIN ."/404.tpl");
        }
    }

    /**
     * get one counter
     * @return information array
     */
    public function get($id = '') {
        $id = ($id == '') ? $id = $this->editID : $id;
        return $this->getModel('passengersModel')->get()->where('id',$id)->find();
    }

    /**
     * delete passenger
     */
    public function delete_passenger($id) {
        $model = Load::model('passengers');
        return $model->passengers_delete($id);
    }

    /**
     * update counter
     * @param get data from public variabl class for update
     * @return 1 for successful
     */
    public function update($input) {

        $passengerID = filter_var($input['passengerId'], FILTER_VALIDATE_INT);

        if($input['passengerNationality'] == '0'){

            $birthDateFa = filter_var($input['passengerBirthday'], FILTER_SANITIZE_STRING);
            $birthDate = functions::ConvertToMiladi($birthDateFa);
            $nationalCode = filter_var($input['passengerNationalCode'], FILTER_SANITIZE_NUMBER_INT);
            $passportCountry = 'IRN';

        } else{

            $birthDate = filter_var($input['passengerBirthdayEn'], FILTER_SANITIZE_STRING);
            $birthDateFa = str_replace('/', '-', functions::convertDateFlight($birthDate));
            $nationalCode = '';
            $passportCountry = filter_var($input['passengerPassportCountry'], FILTER_SANITIZE_STRING);

        }

        $passengerInfo['name'] = filter_var($input['passengerName'], FILTER_SANITIZE_STRING);
        $passengerInfo['name_en'] = filter_var($input['passengerNameEn'], FILTER_SANITIZE_STRING);
        $passengerInfo['family'] = filter_var($input['passengerFamily'], FILTER_SANITIZE_STRING);
        $passengerInfo['family_en'] = filter_var($input['passengerFamilyEn'], FILTER_SANITIZE_STRING);
        $passengerInfo['gender'] = filter_var($input['passengerGender'], FILTER_SANITIZE_STRING);
        $passengerInfo['birthday'] = $birthDate;
        $passengerInfo['birthday_fa'] = $birthDateFa;
        $passengerInfo['passportCountry'] = $passportCountry;
        $passengerInfo['passportNumber'] = (isset($input['passengerPassportNumber']) ? filter_var($input['passengerPassportNumber'], FILTER_SANITIZE_STRING) : '');
        $passengerInfo['passportExpire'] = (isset($input['passengerPassportExpire']) ? filter_var($input['passengerPassportExpire'], FILTER_SANITIZE_STRING) : '');
        $passengerInfo['NationalCode'] = $nationalCode;
        $passengerInfo['fk_members_tb_id'] = (!empty($input['memberID']) ? filter_var($input['memberID'], FILTER_VALIDATE_INT) : Session::getUserId());
        $passengerInfo['is_foreign'] = filter_var($input['passengerNationality'], FILTER_VALIDATE_INT);

        if(!empty($passengerInfo['name']) && !empty($passengerInfo['family']) && (!empty($passengerInfo['NationalCode']) || !empty($passengerInfo['passportNumber']))){

            $passengerModel = Load::model('passengers');
            $result = $passengerModel->passengers_update($passengerInfo, $passengerID);
        } else{
            $result['result_status'] = 'error';
            $result['result_message'] = 'خطا به دلیل ارسال مقادیر نامعتبر';
        }

        return $result;
    }

    public function clientUpdate($input) {

        $passengerID = filter_var($input['passengerId'], FILTER_VALIDATE_INT);

        if($input['passengerNationalityEdit'] == '0'){
            $birthDateFa = $input['passengerBirthday'];
            $birthDate = functions::ConvertToMiladi($birthDateFa);
            $nationalCode = filter_var($input['passengerNationalCode'], FILTER_SANITIZE_NUMBER_INT);
            $passportCountry = 'IRN';

        } else{

            $birthDate = filter_var($input['passengerBirthdayEn'], FILTER_SANITIZE_STRING);
            $birthDateFa = str_replace('/', '-', functions::convertDateFlight($birthDate));
            $nationalCode = '';
            $passportCountry = filter_var($input['passengerPassportCountry'], FILTER_SANITIZE_STRING);

        }

        $passengerInfo['name'] = filter_var($input['passengerName'], FILTER_SANITIZE_STRING);
        $passengerInfo['name_en'] = filter_var($input['passengerNameEn'], FILTER_SANITIZE_STRING);
        $passengerInfo['family'] = filter_var($input['passengerFamily'], FILTER_SANITIZE_STRING);
        $passengerInfo['family_en'] = filter_var($input['passengerFamilyEn'], FILTER_SANITIZE_STRING);
        $passengerInfo['gender'] = filter_var($input['passengerGender'], FILTER_SANITIZE_STRING);
        $passengerInfo['birthday'] = $birthDate;
        $passengerInfo['birthday_fa'] = $birthDateFa;
        $passengerInfo['passportCountry'] = $passportCountry;
        $passengerInfo['passportNumber'] = (isset($input['passengerPassportNumber']) ? filter_var($input['passengerPassportNumber'], FILTER_SANITIZE_STRING) : '');
        $passengerInfo['passportExpire'] = (isset($input['passengerPassportExpire']) ? filter_var($input['passengerPassportExpire'], FILTER_SANITIZE_STRING) : '');
        $passengerInfo['NationalCode'] = $nationalCode;
        $passengerInfo['fk_members_tb_id'] = (!empty($input['memberID']) ? filter_var($input['memberID'], FILTER_VALIDATE_INT) : Session::getUserId());
        $passengerInfo['is_foreign'] = filter_var($input['passengerNationalityEdit'], FILTER_VALIDATE_INT);

        if(!empty($passengerInfo['name']) && !empty($passengerInfo['family']) && (!empty($passengerInfo['NationalCode']) || !empty($passengerInfo['passportNumber']))){

            $Condition = "id='{$passengerID}'";
            $Model = Load::library('Model');
            $Model->setTable('passengers_tb');
            $updatePriorityCode = $Model->update($passengerInfo, $Condition);

            if($updatePriorityCode){
                $result['result_status'] = 'success';
                $result['result_message'] = 'انجام شد';
            }
        } else{
            $result['result_status'] = 'error';
            $result['result_message'] = 'خطا به دلیل ارسال مقادیر نامعتبر';
        }

        return $result;
    }

    /**
     * insert passenger
     * @param input array of inputs
     * @return array of result
     */
    public function insert($input) {

        if($input['passengerNationality'] == '0'){

            $birthDateFa = filter_var($input['passengerBirthday'], FILTER_SANITIZE_STRING);
            $birthDate = functions::ConvertToMiladi($birthDateFa);
            $nationalCode = filter_var($input['passengerNationalCode'], FILTER_SANITIZE_NUMBER_INT);
            $passportCountry = 'IRN';

        } else{

            $birthDate = filter_var($input['passengerBirthdayEn'], FILTER_SANITIZE_STRING);
            $birthDateFa = str_replace('/', '-', functions::convertDateFlight($birthDate));
            $nationalCode = '';
            $passportCountry = filter_var($input['passengerPassportCountry'], FILTER_SANITIZE_STRING);

        }

        $passengerInfo['name'] = filter_var($input['passengerName'], FILTER_SANITIZE_STRING);
        $passengerInfo['name_en'] = filter_var($input['passengerNameEn'], FILTER_SANITIZE_STRING);
        $passengerInfo['family'] = filter_var($input['passengerFamily'], FILTER_SANITIZE_STRING);
        $passengerInfo['family_en'] = filter_var($input['passengerFamilyEn'], FILTER_SANITIZE_STRING);
        $passengerInfo['gender'] = filter_var($input['passengerGender'], FILTER_SANITIZE_STRING);
        $passengerInfo['birthday'] = $birthDate;
        $passengerInfo['birthday_fa'] = $birthDateFa;
        $passengerInfo['passportCountry'] = $passportCountry;
        $passengerInfo['passportNumber'] = (isset($input['passengerPassportNumber']) ? filter_var($input['passengerPassportNumber'], FILTER_SANITIZE_STRING) : '');
        $passengerInfo['passportExpire'] = (isset($input['passengerPassportExpire']) ? filter_var($input['passengerPassportExpire'], FILTER_SANITIZE_STRING) : '');
        $passengerInfo['NationalCode'] = $nationalCode;
        $passengerInfo['fk_members_tb_id'] = (!empty($input['memberID']) ? filter_var($input['memberID'], FILTER_VALIDATE_INT) : Session::getUserId());
        $passengerInfo['is_foreign'] = filter_var($input['passengerNationality'], FILTER_VALIDATE_INT);
        $passengerInfo['del'] = 'no';
        functions::insertLog(json_encode($passengerInfo,256),'checkPassenger');
        if((!empty($passengerInfo['name']) || !empty($passengerInfo['name_en'])) &&
            (!empty($passengerInfo['family']) || !empty($passengerInfo['family_en']) ) &&
            (!empty($passengerInfo['NationalCode']) || !empty($passengerInfo['passportNumber']))){

            /** @var passengers_tb $passengerModel */
            $passengerModel = Load::model('passengers');

            $result = $passengerModel->passengers_insert($passengerInfo);
        } else{
            $result['result_status'] = 'error';
            $result['result_message'] = 'خطا به دلیل ارسال مقادیر نامعتبر';
        }

        return $result;
    }


    public function SelectPassengerOld()
    {
        return $this->getCustomers();
    }

    public function getCustomers($customer_id = null){
        $customer_id = $customer_id ?: Session::getUserId();
        return $this->passengers = $this->passengers_model->get()->where('fk_members_tb_id',$customer_id)->where('del','no')->orderBy('id','DESC')->all();
    }
    public function getCustomer($id = null){
        if(!$id){
            return false;
        }
        return $this->passengers_model->get()->where('id',$id)->where('del','no')->find();
    }

    public function countPassengers($customer_id) {
        return count($this->getCustomers($customer_id));
    }
    public function changeMonthUser($data) {
        $index = self::monthsPersian();
        for ($i = 1; $i < count($index)+1; $i++) {
            if ($index[$i] ===  $data) {
                if ($i < 10) {
                    $i = '0'.$i;
                }
                $result = $i;
            }
        }
        return $result;
    }
    public function changeMonthUserNoIr($data) {
        $index = self::monthsMiladi();
        for ($i = 1; $i < count($index)+1; $i++) {
            if ($index[$i] ===  $data) {
                if ($i < 10) {
                    $i = '0'.$i;
                }
                $result = $i;
            }
        }
        return $result;
    }
    public function zeroBeginningNumber($data) {
        if ($data < 10) {
            $data = '0'.$data;
        }
        return $data;
    }
    public function clientUpdateData($input) {

        $passengerID = filter_var($input['passengerId'], FILTER_VALIDATE_INT);

        if (isset($input['is_foreign']) && $input['is_foreign'] == '0') {
            $passportCountry = 'IRN';
            if (isset($input['birth_month_ir']) && !empty($input['birth_month_ir']) && isset($input['birth_day_ir']) && !empty($input['birth_day_ir']) && isset($input['birth_year_ir']) && !empty($input['birth_year_ir'])) {
                $input['birth_month_ir'] = filter_var(trim($input['birth_month_ir']), FILTER_SANITIZE_STRING);
                $input['birth_day_ir'] = filter_var(trim($input['birth_day_ir']), FILTER_SANITIZE_NUMBER_INT);
                $input['birth_year_ir'] = filter_var(trim($input['birth_year_ir']), FILTER_SANITIZE_NUMBER_INT);
                $input['birth_month_ir'] = self::changeMonthUser($input['birth_month_ir']);
                $input['birth_day_ir'] = self::zeroBeginningNumber($input['birth_day_ir']);
                $birthDateFa = $input['birth_year_ir'] . '-' . $input['birth_month_ir'] . '-' . $input['birth_day_ir'];
                $birthDate = functions::ConvertToMiladi($birthDateFa);
            }
            if (isset($input['date_passport_expire_day_ir']) && !empty($input['date_passport_expire_day_ir']) && isset($input['date_passport_expire_month_ir']) && !empty($input['date_passport_expire_month_ir']) && isset($input['date_passport_expire_year_ir']) && !empty($input['date_passport_expire_year_ir'])) {
                $input['date_passport_expire_day_ir'] = filter_var(trim($input['date_passport_expire_day_ir']), FILTER_SANITIZE_NUMBER_INT);
                $input['date_passport_expire_month_ir'] = filter_var(trim($input['date_passport_expire_month_ir']), FILTER_SANITIZE_STRING);
                $input['date_passport_expire_year_ir'] = filter_var(trim($input['date_passport_expire_year_ir']), FILTER_SANITIZE_NUMBER_INT);
                $input['date_passport_expire_day_ir'] = self::zeroBeginningNumber($input['date_passport_expire_day_ir']);
                $input['date_passport_expire_month_ir'] = self::changeMonthUser($input['date_passport_expire_month_ir']);
                $passportExpire_ir = $input['date_passport_expire_year_ir'] . '-' . $input['date_passport_expire_month_ir'] . '-' . $input['date_passport_expire_day_ir'];
                $passportExpire = functions::ConvertToMiladi($passportExpire_ir);
            }
        }else {
            $passportCountry = (isset($input['passport_country_id']) ? filter_var($input['passport_country_id'], FILTER_SANITIZE_STRING) : '');

            if (isset($input['birth_day_miladi']) && !empty($input['birth_day_miladi']) && isset($input['birth_month_miladi']) && !empty($input['birth_month_miladi']) && isset($input['birth_year_miladi']) && !empty($input['birth_year_miladi'])) {
                $input['birth_day_miladi'] = filter_var(trim($input['birth_day_miladi']), FILTER_SANITIZE_NUMBER_INT);
                $input['birth_month_miladi'] = filter_var(trim($input['birth_month_miladi']), FILTER_SANITIZE_STRING);
                $input['birth_year_miladi'] = filter_var(trim($input['birth_year_miladi']), FILTER_SANITIZE_NUMBER_INT);
                $input['birth_day_miladi'] = self::zeroBeginningNumber($input['birth_day_miladi']);
                $input['birth_month_miladi'] = self::changeMonthUserNoIr($input['birth_month_miladi']);
                $birthDate = $input['birth_year_miladi'] . '-' . $input['birth_month_miladi'] . '-' . $input['birth_day_miladi'];
                $birthDateFa = functions::ConvertToJalali($birthDate);
            }
            if (isset($input['date_passport_expire_day']) && !empty($input['date_passport_expire_day']) && isset($input['date_passport_expire_month']) && !empty($input['date_passport_expire_month']) && isset($input['date_passport_expire_year']) && !empty($input['date_passport_expire_year'])) {
                $input['date_passport_expire_day'] = filter_var(trim($input['date_passport_expire_day']), FILTER_SANITIZE_NUMBER_INT);
                $input['date_passport_expire_month'] = filter_var(trim($input['date_passport_expire_month']), FILTER_SANITIZE_STRING);
                $input['date_passport_expire_year'] = filter_var(trim($input['date_passport_expire_year']), FILTER_SANITIZE_NUMBER_INT);
                $input['date_passport_expire_day'] = self::zeroBeginningNumber($input['date_passport_expire_day']);
                $input['date_passport_expire_month'] = self::changeMonthUserNoIr($input['date_passport_expire_month']);
                $passportExpire = $input['date_passport_expire_year'] . '-' . $input['date_passport_expire_month'] . '-' . $input['date_passport_expire_day'];
                $passportExpire_ir = functions::ConvertToJalali($passportExpire);
            }
        }


        $passengerInfo['name'] = filter_var($input['passengerName'], FILTER_SANITIZE_STRING);
        $passengerInfo['name_en'] = filter_var($input['passengerNameEn'], FILTER_SANITIZE_STRING);
        $passengerInfo['family'] = filter_var($input['passengerFamily'], FILTER_SANITIZE_STRING);
        $passengerInfo['family_en'] = filter_var($input['passengerFamilyEn'], FILTER_SANITIZE_STRING);
        $passengerInfo['gender'] = filter_var($input['passengerGender'], FILTER_SANITIZE_STRING);
        $passengerInfo['birthday'] = $birthDate;
        $passengerInfo['birthday_fa'] = $birthDateFa;
        $passengerInfo['passportNumber'] = (isset($input['passportNumber']) ? filter_var($input['passportNumber'], FILTER_SANITIZE_STRING) : '');
        $passengerInfo['NationalCode'] = (isset($input['passengerNationalCode']) ? filter_var($input['passengerNationalCode'], FILTER_SANITIZE_STRING) : '');
        $passengerInfo['passportCountry'] = $passportCountry;
        $passengerInfo['passportExpire'] = $passportExpire;
        $passengerInfo['passportExpire_ir'] = $passportExpire_ir;
        $passengerInfo['fk_members_tb_id'] = (!empty($input['memberID']) ? filter_var($input['memberID'], FILTER_VALIDATE_INT) : Session::getUserId());
        $passengerInfo['is_foreign'] = filter_var($input['is_foreign'], FILTER_VALIDATE_INT);

        if(!empty($passengerInfo['name']) && !empty($passengerInfo['family']) && (!empty($passengerInfo['NationalCode']) || !empty($passengerInfo['passportNumber']))){
            $passengerModel = Load::model('passengers');
            $result = $passengerModel->passengers_update($passengerInfo, $passengerID);

        } else{
            $result['result_status'] = 'error';
            $result['result_message'] = 'خطا به دلیل ارسال مقادیر نامعتبر';
        }

        return $result;
    }

    public function clientAddData($input) {

        if (isset($_POST['is_foreign']) && $_POST['is_foreign'] == '0'){
         $passportCountry = 'IRN';
         $passengerNationalCode = (isset($input['passengerNationalCode']) ? filter_var($input['passengerNationalCode'], FILTER_SANITIZE_STRING) : '');
            if (isset($input['birth_month_ir']) && !empty($input['birth_month_ir']) && isset($input['birth_day_ir']) && !empty($input['birth_day_ir']) && isset($input['birth_year_ir']) && !empty($input['birth_year_ir'])) {
            $input['birth_month_ir'] = filter_var(trim($input['birth_month_ir']) , FILTER_SANITIZE_STRING);
            $input['birth_day_ir'] = filter_var(trim($input['birth_day_ir']) , FILTER_SANITIZE_NUMBER_INT);
            $input['birth_year_ir'] = filter_var(trim($input['birth_year_ir']) , FILTER_SANITIZE_NUMBER_INT);
            $input['birth_month_ir'] = self::changeMonthUser($input['birth_month_ir']);
            $input['birth_day_ir'] = self::zeroBeginningNumber($input['birth_day_ir']);
            $birthDateFa = $input['birth_year_ir'].'-'.$input['birth_month_ir'].'-'.$input['birth_day_ir'];
            $birthDate = functions::ConvertToMiladi($birthDateFa);

        }
        if (isset($input['date_passport_expire_day_ir']) && !empty($input['date_passport_expire_day_ir']) && isset($input['date_passport_expire_month_ir']) && !empty($input['date_passport_expire_month_ir']) && isset($input['date_passport_expire_year_ir']) && !empty($input['date_passport_expire_year_ir'])) {
            $input['date_passport_expire_day_ir'] = filter_var(trim($input['date_passport_expire_day_ir']) , FILTER_SANITIZE_NUMBER_INT);
            $input['date_passport_expire_month_ir'] = filter_var(trim($input['date_passport_expire_month_ir']) , FILTER_SANITIZE_STRING);
            $input['date_passport_expire_year_ir'] = filter_var(trim($input['date_passport_expire_year_ir']) , FILTER_SANITIZE_NUMBER_INT);
            $input['date_passport_expire_day_ir'] = self::zeroBeginningNumber($input['date_passport_expire_day_ir']);
            $input['date_passport_expire_month_ir'] = self::changeMonthUser($input['date_passport_expire_month_ir']);
            $passportExpire_ir = $input['date_passport_expire_year_ir'].'-'.$input['date_passport_expire_month_ir'].'-'.$input['date_passport_expire_day_ir'];
            $passportExpire = functions::ConvertToMiladi($passportExpire_ir);
        }
        }else {
            $passportCountry = (isset($input['passport_country_id']) ? filter_var($input['passport_country_id'], FILTER_SANITIZE_STRING) : '');
            if (isset($input['birth_day_miladi']) && !empty($input['birth_day_miladi']) && isset($input['birth_month_miladi']) && !empty($input['birth_month_miladi']) && isset($input['birth_year_miladi']) && !empty($input['birth_year_miladi'])) {
                $input['birth_day_miladi'] = filter_var(trim($input['birth_day_miladi']), FILTER_SANITIZE_NUMBER_INT);
                $input['birth_month_miladi'] = filter_var(trim($input['birth_month_miladi']), FILTER_SANITIZE_STRING);
                $input['birth_year_miladi'] = filter_var(trim($input['birth_year_miladi']), FILTER_SANITIZE_NUMBER_INT);
                $input['birth_day_miladi'] = self::zeroBeginningNumber($input['birth_day_miladi']);
                $input['birth_month_miladi'] = self::changeMonthUserNoIr($input['birth_month_miladi']);

                $birthDate = $input['birth_year_miladi'] . '-' . $input['birth_month_miladi'] . '-' . $input['birth_day_miladi'];
                $birthDateFa = functions::ConvertToJalali($birthDate);
            }

            if (isset($input['date_passport_expire_day']) && !empty($input['date_passport_expire_day']) && isset($input['date_passport_expire_month']) && !empty($input['date_passport_expire_month']) && isset($input['date_passport_expire_year']) && !empty($input['date_passport_expire_year'])) {
                $input['date_passport_expire_day'] = filter_var(trim($input['date_passport_expire_day']), FILTER_SANITIZE_NUMBER_INT);
                $input['date_passport_expire_month'] = filter_var(trim($input['date_passport_expire_month']), FILTER_SANITIZE_STRING);
                $input['date_passport_expire_year'] = filter_var(trim($input['date_passport_expire_year']), FILTER_SANITIZE_NUMBER_INT);
                $input['date_passport_expire_day'] = self::zeroBeginningNumber($input['date_passport_expire_day']);
                $input['date_passport_expire_month'] = self::changeMonthUserNoIr($input['date_passport_expire_month']);
                $passportExpire = $input['date_passport_expire_year'] . '-' . $input['date_passport_expire_month'] . '-' . $input['date_passport_expire_day'];
                $passportExpire_ir = functions::ConvertToJalali($passportExpire);
            }
        }


        $passengerInfo['passportCountry'] = $passportCountry;
        $passengerInfo['name'] = filter_var($input['passengerName'], FILTER_SANITIZE_STRING);
        $passengerInfo['name_en'] = filter_var($input['passengerNameEn'], FILTER_SANITIZE_STRING);
        $passengerInfo['family'] = filter_var($input['passengerFamily'], FILTER_SANITIZE_STRING);
        $passengerInfo['family_en'] = filter_var($input['passengerFamilyEn'], FILTER_SANITIZE_STRING);
        $passengerInfo['gender'] = filter_var($input['passengerGender'], FILTER_SANITIZE_STRING);
        $passengerInfo['birthday'] = $birthDate;
        $passengerInfo['birthday_fa'] = $birthDateFa;
        $passengerInfo['passportNumber'] = (isset($input['passportNumber']) ? filter_var($input['passportNumber'], FILTER_SANITIZE_STRING) : '');
        $passengerInfo['NationalCode'] = (isset($input['passengerNationalCode']) ? filter_var($input['passengerNationalCode'], FILTER_SANITIZE_STRING) : '');
        $passengerInfo['passportExpire'] = $passportExpire;
        $passengerInfo['passportExpire_ir'] = $passportExpire_ir;
        $passengerInfo['fk_members_tb_id'] = (!empty($input['memberID']) ? filter_var($input['memberID'], FILTER_VALIDATE_INT) : Session::getUserId());
        $passengerInfo['is_foreign'] = filter_var($input['is_foreign'], FILTER_VALIDATE_INT);

        if(($passengerInfo['gender']) && (!empty($passengerInfo['name']) || !empty($passengerInfo['name_en'])) &&
            (!empty($passengerInfo['family']) || !empty($passengerInfo['family_en']) ) &&
            (!empty($passengerInfo['NationalCode']))){

            /** @var passengers_tb $passengerModel */
            $passengerModel = Load::model('passengers');

            $result = $passengerModel->passengers_insert($passengerInfo);
        } else{
            $result['result_status'] = 'error';
            $result['result_message'] = 'خطا به دلیل ارسال مقادیر نامعتبر';
        }

        return $result;
    }
//    public function findPassengerById1($id) {
//var_dump($this->getModel('passengers'));
//        return $this->getModel('passengers_tb')->get()->where('id', $id );
//    }

//    public function findPassengerById($id) {
//
//        return  $this->getModel('passengersModel')->get($id);
////        var_dump($aaa);
//    }

    public function findPassengerById($id) {
        return $this->getModel('passengersModel')->get()->where('id', $id)->where('del' , 'no')->find();
    }
    public function clientDeletePassenger($data) {

       $check_exist_passenger= $this->findPassengerById($data['passengerId']);
       if ($check_exist_passenger) {
           $data_update_status['del'] = 'yes';
           $condition_update_status ="id='{$check_exist_passenger['id']}'";
           $delete_passenger = $this->getModel('passengersModel')->updateWithBind($data_update_status,$condition_update_status);
           if($delete_passenger){
               $result['result_status'] = 'success';
               $result['result_message'] = 'انجام شد';
           } else{
               $result['result_status'] = 'error';
               $result['result_message'] = 'حذف انجام نشد';
           }
       } else{
           $result['result_status'] = 'error';
           $result['result_message'] = 'خطای ارسال اطلاعات نادرست';
       }

       return $result;


    }

    public function yearsPersian() {
        $Year =  dateTimeSetting::jdate("Y",time(),'','','en');
        $arr = array();
        for($i = $Year - 90; $i <= $Year ; $i++) {
            $arr[] = $i;
        }
        return $arr;
    }
    public function yearsPersianExpire() {
        $Year =  dateTimeSetting::jdate("Y",time(),'','','en');
        $arr = array();
        for($i = $Year + 10; $Year <= $i ; $i--) {
            $arr[] = $i;
        }
        return $arr;
    }
    public function yearsMiladi() {
        $Year =  date("Y",time());
        $arr = array();
        for($i = $Year - 90; $i <= $Year ; $i++) {
            $arr[] = $i;
        }
        return $arr;
    }
    public function yearsMiladiExpire() {
        $Year =  date("Y",time());
        $arr = array();
        for($i = $Year + 10; $Year <= $i ; $i--) {
            $arr[] = $i;
        }
        return $arr;
    }


}