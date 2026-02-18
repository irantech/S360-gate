<?php

//if($_SERVER['REMOTE_ADDR']==='5.201.144.255'){
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}

class user extends baseController
{

    public $userId = '';
    public $count = '';
    public $buy = array();
    public $message = '';
    public $classError = 'display-none';
    public $classMessage = 'display-none';
    public $credit;
    public $TicketCancel;
    public $Pid;
    public $showOneDayTour;
    public $listOneDayTour;
    public $Model;

    public function __construct()
    {
        $this->userId = Session::getUserId();
        $this->Model = Load::library('Model');
        $this->admin = Load::controller('admin');

//        if($_SERVER['REMOTE_ADDR']=='178.131.150.188'){
//            error_reporting(1);
//            error_reporting(E_ALL | E_STRICT);
//            @ini_set('display_errors', 1);
//            @ini_set('display_errors', 'on');
//        }
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
    function getProfile($id = '')
    {
        $model = Load::model('members');
        if ($id != '') {
            $this->userId = $id;
        }
        return $model->get($this->userId);
    }
    function getProfileGds($id = '')
    {
        $model = Load::model('members');
        if ($id != '') {
            $this->userId = $id;
        }
        $user = $model->get($this->userId);
        $birth_birth_ir = explode('-', $user['birthday']);
        $date_birth_no_ir = explode('-', $user['birthday_en']);
        $date_expire_passport_ir = explode('-', $user['expire_passport_ir']);
        $expire_passport_en = explode('-', $user['expire_passport_en']);

        $user['birth_year_ir'] = $birth_birth_ir[0];
        $user['birth_month_ir'] = self::changeMonthIr($birth_birth_ir[1]);
        $user['birth_day_ir'] = self::removeZeroBeginningNumber($birth_birth_ir[2]);

        $user['expire_year_ir'] = $date_expire_passport_ir[0];
        $user['expire_month_ir'] = self::changeMonthIr($date_expire_passport_ir[1]);
        $user['expire_day_ir'] = self::removeZeroBeginningNumber($date_expire_passport_ir[2]);

        $user['birth_year_miladi'] = $date_birth_no_ir[0];
        $user['birth_month_miladi'] = self::changeMonthNoIr($date_birth_no_ir[1]);
        $user['birth_day_miladi'] = self::removeZeroBeginningNumber($date_birth_no_ir[2]);

        $user['expire_year_miladi'] = $expire_passport_en[0];
        $user['expire_month_miladi'] = self::changeMonthNoIr($expire_passport_en[1]);
        $user['expire_day_miladi'] = self::removeZeroBeginningNumber($expire_passport_en[2]);
        if ($user['national_type'] == 'IR') {
            $user['nationality'] = $user['national_code'];
            $user['expire_pass'] = $user['expire_passport_ir'];
            $user['birth'] = $user['birthday'];
        }else{
            $user['nationality'] = $user['passport_country_id'];
            $user['expire_pass'] = $user['expire_passport_en'];
            $user['birth'] = $user['birthday_en'];
        }
        $array_score = array(
            $user['name'],
            $user['family'],
            $user['name_en'],
            $user['family_en'],
            $user['mobile'],
            $user['email'],
            $user['user_name'],
//            $user['gender'],
//            $user['national_type'],
//            $user['nationality'],
//            $user['birth'],
//            $user['expire_pass'],
//            $user['passport_number'],
            $user['telephone']);

        $score = 0;
        $score_item = 100/count($array_score);
        foreach ($array_score as $key => $value) {
            if ($value != '') {
                $score += $score_item;
            }
        }
        $user['score'] = ceil($score);
        $user['score_circle'] = $user['score']-1;
        return $user;
    }

    function getTypeCounter($id)
    {
        $model = Load::model('counter_type');
        $rec = $model->getById($id);

        return $rec['name'];

    }
    function getTypeCounterEn($faName)
    {
        if(SOFTWARE_LANG !== 'fa')
        {
            if($faName ==='کانتر طلایی'){
                return 'Golden Counter';
            }
            if($faName ==='آژانس مادر(5درصد)'){
                return 'Main Agency (5%)';
            }
            if($faName ==='کانتر نقره ای'){
                return 'Silver counter';
            }
            if($faName ==='کانتر برنزی ' || $faName ==='کانتر برنزی' ){
                return 'Bronze counter';
            }
            if($faName ==='مسافر آنلاین'){
                return 'online Passenger';
            }
        }
        return $faName;
    }

    function getAgencyName($id)
    {
        $model = Load::model('agency');
        $rec = $model->get($id);
        return $rec['name_fa'];
    }

    public function getReport($agencyId = '', $from = '', $to = '', $airline)
    {
        $model = Load::model('book');
        return $model->getReport($agencyId, $from, $to, $this->userId, $airline, '');
    }

    public function getReportAgency($from = '', $to = '')
    {
        $model = Load::model('book');
        return $model->getReportAgency($this->userId, $from, $to);
    }

    public function redirect( $url = '')
    {

        if($url){
            Session::init();
            Session::delete('refer_url');
            header("Location: {$url}");
            exit();
        }
        if (in_array(CLIENT_ID , functions::newLogin())){
            header('Location: profile');
        }else{
            header('Location: userProfile');
        }

        exit();
    }

    public function redirectOut($url = ''){
        Session::init();
        Session::delete('refer_url');

        if($url){
            Session::delete('refer_url');
            header("Location: {$url}");
        }
        if (in_array(CLIENT_ID , functions::newLogin())){
            header('Location: authenticate');
        }else{
            header('Location: loginUser');
        }


    }

    public function UserBuy($type=null)
    {

        $Model = Load::library('Model');

        $id = Session::getUserId();
        if(!empty($type) && $type=='App')
        {

            $sql = "SELECT * "
                . " FROM book_local_tb "
                . " WHERE member_id='{$id}' AND request_number > '0' AND successfull='book'  GROUP BY request_number ORDER BY creation_date_int DESC ";

        }else{
            $sql = "SELECT   origin_city,desti_city,request_number,creation_date_int,airline_name,flight_number,time_flight,date_flight,factor_number,successfull,IsInternal,type_app "
                . " FROM book_local_tb "
                . " WHERE member_id='{$id}' AND request_number > '0' AND successfull<>'nothing' GROUP BY request_number ORDER BY creation_date_int DESC ";

        }

        $buy = $Model->select($sql);

        return $buy;
    }

    public function DateJalali($param)
    {
        $explode_date = explode('-', $param);

        return dateTimeSetting::gregorian_to_jalali($explode_date[0], $explode_date[1], $explode_date[2], '/');
    }

    public function format_hour($num)
    {

        $time = date("H:i", strtotime($num));

        return $time;
    }

    public function showBuy($request_number)
    {

        $model = Load::model('book_local');
        $info_ticket = $model->BookInfo($request_number);

        return $info_ticket['passenger_name'] . ' ' . $info_ticket['passenger_family'];
    }

    public function set_date_reserve($date)
    {
        $date_orginal_exploded = explode(' ', $date);

        $date_miladi_exp = explode('-', $date_orginal_exploded[0]);

        echo dateTimeSetting::gregorian_to_jalali($date_miladi_exp[0], $date_miladi_exp[1], $date_miladi_exp[2], '-');
    }

    public function total_price($RequestNumber)
    {
        $apiLocal = Load::library('apiLocal');
        list($amount,$fare) = $apiLocal->get_total_ticket_price($RequestNumber, 'yes');
        echo $amount;
        return $amount;
    }

    public function compareDate($date, $time)
    {
        $DateOneMonth = time() - (60 * 24 * 60 * 60);

        $dateFlight = $date;
        $TimeFlight = date("H:i", strtotime($time));

        $date_expl = explode('-', $dateFlight);
        $time_expl = explode(':', $TimeFlight);


        $Flight_Time = mktime(intval($time_expl[0]), intval($time_expl[1]), 0, intval($date_expl[1]), intval($date_expl[2]), intval($date_expl[0]));


        if ($Flight_Time > $DateOneMonth) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function TypeUser()
    {
        $Model = Load::library('Model');

        $sql = " SELECT * FROM members_tb WHERE id='{$this->userId}'";
        $user = $Model->load($sql);

        if ($user['fk_counter_type_id'] == '5' || $user['fk_counter_type_id'] == '1') {
            return 'user';
        } else {
            return 'counter';
        }
    }

    public function changePassword($info){
        $model_members = Load::model('members');
        $members = $model_members->get($this->userId);
        $Model = Load::library('Model');

        $checkCountRepeat = functions::checkHistoryRequestUser();
        if(($checkCountRepeat['count'] % 3) == 0  && (time() - $checkCountRepeat['allow_time_change_password']  ) < (60*20))
        {
            return 'error : ' . functions::Xmlinformation("timeNotAllowChange");
        }else{

            if(empty($checkCountRepeat))
            {
                functions::insertCheckRequest();
            }else{
                functions::updateCheckRequest($checkCountRepeat);
                $old_pass = $model_members->encryptPassword($info['old_pass']);
                if (!empty($members)) {
//                        $sqlCheckPass = "SELECT * FROM members_tb WHERE password='{$old_pass}'";
//                        $clientCheckPass = $Model->load($sqlCheckPass);
//                        if (!empty($clientCheckPass)) {
                    $data['password'] = $model_members->encryptPassword($info['new_pass']);
                    $Model->setTable('members_tb');
                    $res = $Model->update($data, "id='{$this->userId}'");
                    if ($res) {
                        return 'success :' . functions::Xmlinformation("PasswordSuccessfullyChanged");
                    } else {
                        return 'error : ' . functions::Xmlinformation("Errorrecordinginformation");
                    }
//                        } else {
//                            return 'error: ' . functions::Xmlinformation("OldPasswordWrong");
//                        }
                } else {
                    return 'error: ' . functions::Xmlinformation("ErrorDetectingUser");
                }
            }
        }
    }

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

    public function InfoTicketCancel($FactorNumber)
    {
        $Modal = Load::library('Model');
        $sql = "SELECT * FROM cancel_ticket_tb WHERE FactorNumber='{$FactorNumber}'";
        $res = $Modal->load($sql);

        if ($res) {
            return 'Yes';

            $this->TicketCancel = $res;
        } else {
            return 'No';
        }
    }

    public function ListTrackingCancelTicket($UserId)
    {
        $Modal = Load::library('Model');

        $sql = "SELECT dCancel.*,Cancel.NationalCode AS NationalCode FROM cancel_ticket_details_tb AS dCancel "
            . " LEFT JOIN  cancel_ticket_tb AS Cancel ON Cancel.IdDetail = dCancel.id "
            . " WHERE dCancel.MemberId='{$UserId}' GROUP BY Cancel.IdDetail ORDER BY dCancel.id Desc";
        $res = $Modal->select($sql);

        return $res;
    }


    public function TypeFlight($request_number)
    {
        $Model = Load::library('Model');

        $sql = "select * from book_local_tb  where request_number='$request_number' ";
        $result = $Model->load($sql);

        $this->Pid = $result['pid_private'];

        return $result['flight_type'];
    }

    public function InfoModalTicketCancel($RequestNumber,$type,$clientId=null)
    {
        if($type=='flight'){
            return $this->getInfoTicketFlightCancel($RequestNumber,$clientId);
        }

        if($type=='train'){
            return $this->getInfoTicketTrainCancel($RequestNumber);
        }

        if($type=='bus'){
            return $this->getInfoTicketBusCancel($RequestNumber);
        }

        if($type=='hotel'){
            return $this->getInfoTicketHotelCancel($RequestNumber);
        }
        if($type=='insurance'){
            return $this->getInfoTicketInsuranceCancel($RequestNumber);
        }

    }

    public function InfoModalBusCancel($FactorNumber)
    {
        $Model = Load::library('Model');
        $sql = "SELECT  "
            . " book.id,"
            . " book.passenger_name, "
            . " book.passenger_family, "
            . " book.passenger_national_code, "
            . " book.member_mobile, "
            . " book.member_email, "
            . " book.member_id , "
            . " book.agency_name , "
            . " book.agency_manager , "
            . " book.passenger_factor_num , "
            . " book.status , "
            . " book.payment_date , "
            . " book.Price "
            . " FROM book_bus_tb AS book "
            . " WHERE book.passenger_factor_num ='{$FactorNumber}'";
        $res = $Model->select($sql);
        return $res[0];
    }


    public function ShowInfoModalTicketCancel($RequestNumber,$id,$ClientId=CLIENT_ID){
        $sqlExistCancel = "SELECT * FROM cancel_ticket_details_tb WHERE id='{$id}'";
        $resultExistCancel = $this->admin->ConectDbClient($sqlExistCancel, $ClientId, "Select", "", "", "");

        if(!empty($resultExistCancel)){
            $passport_number = 'book.passportNumber';
            $passenger_birthday_en = 'book.passenger_birthday_en';
            $passenger_birthday = 'book.passenger_birthday';
            $passenger_age = 'book.passenger_age';
            $passenger_factor_number = 'book.factor_number';
            if($resultExistCancel['TypeCancel']=='train'){
                $LeftJoin = "LEFT JOIN book_train_tb AS book ON book.requestNumber = Cancel.RequestNumber AND ((TCancel.NationalCode = book.passenger_national_code)OR(TCancel.NationalCode = book.passportNumber))";
            }else if($resultExistCancel['TypeCancel']=='hotel'){
                $LeftJoin = "LEFT JOIN book_hotel_local_tb AS book ON book.factor_number = Cancel.RequestNumber AND ((TCancel.NationalCode = book.passenger_national_code)OR(TCancel.NationalCode = book.passportNumber))";
            }else if($resultExistCancel['TypeCancel']=='bus'){
                $passenger_age = 'book.passenger_birthday';
                $passenger_factor_number = 'book.passenger_factor_num';
                $LeftJoin = "LEFT JOIN book_bus_tb AS book ON book.order_code = Cancel.RequestNumber AND ((TCancel.NationalCode = book.passenger_national_code)OR(TCancel.NationalCode = book.passportNumber))";
            }else if($resultExistCancel['TypeCancel'] == 'insurance'){
                $passport_number = 'book.passport_number';
                $passenger_birthday_en = 'book.passenger_birth_date_en';
                $passenger_birthday = 'book.passenger_birth_date';
                $LeftJoin = "LEFT JOIN book_insurance_tb AS book ON book.factor_number = Cancel.RequestNumber AND ((TCancel.NationalCode = book.passenger_national_code)OR(TCancel.NationalCode = book.passport_number))";
            }else{
                $LeftJoin = "LEFT JOIN book_local_tb AS book ON book.request_number = Cancel.RequestNumber AND ((TCancel.NationalCode = book.passenger_national_code)OR(TCancel.NationalCode = book.passportNumber))";
            }
        }
        $sql = "SELECT TCancel.*, "
            . " book.passenger_name, "
            . " book.passenger_family, "
            . " book.passenger_name_en, "
            . " book.passenger_family_en, "
            . " {$passenger_age}, "
            . " book.passenger_national_code, "
            . " {$passport_number}, "
            . " {$passenger_birthday_en}, "
            . " {$passenger_birthday}, "
            . "{$passenger_factor_number}, "
            . " book.member_id , "
            . " Cancel.* "
            . " FROM cancel_ticket_tb AS TCancel "
            . " INNER JOIN cancel_ticket_details_tb AS Cancel ON Cancel.id = TCancel.IdDetail "
            . "{$LeftJoin}"
            . " WHERE Cancel.RequestNumber='{$RequestNumber}' AND TCancel.IdDetail='{$id}' "
            . " GROUP BY TCancel.NationalCode ";

//        if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
//            var_dump($sql);
//            die();
//        }
//var_dump($sql);
//die;
        $InfoCancel = $this->admin->ConectDbClient($sql, $ClientId, "SelectAll", "", "", "");

        return $InfoCancel;
    }

    public function ShowInfoModalTicketCancel_new($RequestNumber, $id, $ClientId = CLIENT_ID)
    {
        $sqlExistCancel = "
        SELECT *
        FROM cancel_ticket_details_tb
        WHERE id = '{$id}'
    ";
        $cancelDetail = $this->admin->ConectDbClient($sqlExistCancel, $ClientId, "Select");

        if (empty($cancelDetail)) {
            return [];
        }

        /* -------------------------------
           Dynamic book table & fields
        -------------------------------- */
        $passport_number = 'book.passportNumber';
        $passenger_birthday_en = 'book.passenger_birthday_en';
        $passenger_birthday = 'book.passenger_birthday';
        $passenger_age = 'book.passenger_age';
        $passenger_factor_number = 'book.factor_number';
        $bookTable = 'book_local_tb';
        $bookJoinKey = 'book.request_number';

        switch ($cancelDetail['TypeCancel']) {
            case 'train':
                $bookTable = 'book_train_tb';
                $bookJoinKey = 'book.requestNumber';
                break;

            case 'hotel':
                $bookTable = 'book_hotel_local_tb';
                $bookJoinKey = 'book.factor_number';
                break;

            case 'bus':
                $bookTable = 'book_bus_tb';
                $bookJoinKey = 'book.order_code';
                $passenger_age = 'book.passenger_birthday';
                $passenger_factor_number = 'book.passenger_factor_num';
                break;

            case 'insurance':
                $bookTable = 'book_insurance_tb';
                $bookJoinKey = 'book.factor_number';
                $passport_number = 'book.passport_number';
                $passenger_birthday_en = 'book.passenger_birth_date_en';
                $passenger_birthday = 'book.passenger_birth_date';
                break;
        }

        /* -------------------------------
           Final SQL (CORRECT DESIGN)
        -------------------------------- */
        $sql = "
        SELECT
            book.*,

            book.passenger_name,
            book.passenger_family,
            book.passenger_name_en,
            book.passenger_family_en,
            {$passenger_age} AS passenger_age,
            book.passenger_national_code,
            {$passport_number} AS passportNumber,
            {$passenger_birthday_en} AS passenger_birthday_en,
            {$passenger_birthday} AS passenger_birthday,
            {$passenger_factor_number} AS factor_number,
            book.member_id,
            TCancel.*,
            TCancel.NationalCode AS cancel_national_code,
            Cancel.*

        FROM {$bookTable} AS book

        INNER JOIN cancel_ticket_details_tb AS Cancel
            ON Cancel.RequestNumber = {$bookJoinKey}
            AND Cancel.id = '{$id}'

        LEFT JOIN cancel_ticket_tb AS TCancel
            ON TCancel.IdDetail = Cancel.id
            AND (
                TCancel.NationalCode = book.passenger_national_code
                OR TCancel.NationalCode = {$passport_number}
            )

        WHERE {$bookJoinKey} = '{$RequestNumber}'
    ";

        return $this->admin->ConectDbClient($sql, $ClientId, "SelectAll");
    }

    public function info_insurance_client($factor_number)
    {
        $Model = Load::library('Model');

        $sql = "select *,"
            . " (SELECT COUNT(id) FROM book_insurance_tb WHERE factor_number='$factor_number') AS CountId "
            . " from book_insurance_tb  where factor_number='$factor_number' AND (factor_number > 0 || factor_number <> '')";
        $result = $Model->select($sql);

        $this->count = count($result);
        return $result;
    }

    public function total_price_insurance($factor_number)
    {
        $insurance = Load::controller('insurance');
        $amount = $insurance->getTotalPriceByFactorNumber($factor_number);
        return $amount['totalPrice'];
    }

    public function get_insurance_pdf($sourcName, $pnr)
    {
        $insurance = Load::controller('insurance');
        return $insurance->getReservePdf($sourcName, $pnr);
    }

    public function UserBuyInsurance()
    {
        $Model = Load::library('Model');

        $id = $this->userId;
        $sql = "SELECT * "
            . " FROM book_insurance_tb "
            . " WHERE member_id='{$id}' GROUP BY factor_number ORDER BY creation_date_int DESC ";
        $buy = $Model->select($sql);

        return $buy;
    }

    public function showBuyInsurance($factor_number)
    {

        $model = Load::model('book_insurance');
        $info_insurance = $model->BookInfo($factor_number);

        return $info_insurance['passenger_name'] . ' ' . $info_insurance['passenger_family'];
    }

    public function UserBuyHotel()
    {
        $Model = Load::library('Model');
        $id = $this->userId;
        $sql = "SELECT * "
            . " FROM book_hotel_local_tb "
            . " WHERE member_id='{$id}' GROUP BY factor_number ORDER BY creation_date_int DESC ";
        $buy = $Model->select($sql);

        return $buy;
    }

    public function UserBuyTour()
    {
        $Model = Load::library('Model');
        $id = $this->userId;
        $sql = "SELECT * "
            . " FROM book_tour_local_tb "
            . " WHERE member_id='{$id}' GROUP BY factor_number ORDER BY creation_date_int DESC ";
        $buy = $Model->select($sql);

        return $buy;
    }

    public function UserBuyVisa()
    {
        $Model = Load::library('Model');

        $id = $this->userId;
        $sql = "SELECT * "
            . ", (SELECT documents FROM visa_type_tb AS visaType WHERE visaType.title = visa_type) AS documents_visa"
            . " FROM book_visa_tb "
            . " WHERE member_id='{$id}' GROUP BY factor_number ORDER BY creation_date_int DESC ";
        $buy = $Model->select($sql);

        return $buy;
    }


    public function UserBuyEuropcar()
    {
        $Model = Load::library('Model');
        $id = $this->userId;
        $sql = "SELECT * "
            . " FROM book_europcar_local_tb "
            . " WHERE member_id='{$id}' GROUP BY factor_number ORDER BY creation_date_int DESC ";
        $buy = $Model->select($sql);

        return $buy;
    }
    public function UserBuyGasht()
    {
        $Model = Load::library('Model');
        $id = $this->userId;
        $sql = "SELECT * "
            . " FROM book_gasht_local_tb "
            . " WHERE member_id='{$id}' GROUP BY passenger_factor_num ORDER BY creation_date_int DESC ";
        $buy = $Model->select($sql);

        return $buy;
    }
    public function UserBuyBus()
    {
        $Model = Load::library('Model');
        $id = $this->userId;
        $sql = "SELECT * "
            . " FROM book_bus_tb "
            . " WHERE member_id='{$id}' GROUP BY passenger_factor_num ORDER BY creation_date_int DESC ";
        $buy = $Model->select($sql);
//        var_dump($buy);
        return $buy;

    }


    public function checkForEdit($status, $startDate)
    {
        $sDate_miladi = functions::ConvertToMiladi($startDate);
        $sDate_miladi = str_replace("-", "", $sDate_miladi);
        $result = date('Ymd', strtotime("".$sDate_miladi.",- 1 day"));
        $SDate = functions::ConvertToJalali($result);
        $SDate = str_replace("-", "", $SDate);

        $dateNow = dateTimeSetting::jdate("Ymd",'','','','en');

        $accessStatusEdit = array('Cancelled', 'NoReserve', 'PreReserve', 'OnRequest');

        if (in_array($status, $accessStatusEdit) && trim($SDate) > trim($dateNow)) {
            return true;
        } else {
            return false;
        }

    }



    ////////// reservation ticket /////////////////////
    #region [infoReservationTicket]
    public function infoReservationTicket($requestNumber)
    {

        if (TYPE_ADMIN == '1') {
            $ModelBase = Load::library('ModelBase');

            $sql = "select *,"
                . " (SELECT COUNT(id) FROM report_tb WHERE request_number='{$requestNumber}') AS CountId "
                . " from report_tb  where request_number='{$requestNumber}' AND (request_number > 0 || request_number <> '')  ";
            $result = $ModelBase->select($sql);
        } else {
            $Model = Load::library('Model');

            $sql = "select *,"
                . " (SELECT COUNT(id) FROM book_local_tb WHERE request_number='$requestNumber') AS CountId "
                . " from book_local_tb  where request_number='$requestNumber' AND (request_number > 0 || request_number <> '')";
            $result = $Model->select($sql);
        }

        $totalPrice = 0;
        $totalPriceWithoutDiscount = 0;
        foreach ($result as $val) {
            $namePrice = strtolower($val['passenger_age']) . '_price';
            $nameDiscountPrice = 'discount_' . strtolower($val['passenger_age']) . '_price';
            $totalPriceWithoutDiscount += $val[$namePrice];
            $totalPrice += $val[$nameDiscountPrice];
        }

        $this->count = count($result);
        $this->totalPrice = $totalPrice;
        $this->totalPriceWithoutDiscount = $totalPriceWithoutDiscount;

        return $result;
    }
    #endregion


    #region UpdateUser
    public function UpdateUser()
    {
        $userId = Session::getUserId(); // id کانتر یا آژانسی که لاگین کرده

        if(isset($_POST['name'])) {
            $data['name'] = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
        }



        if(isset($_POST['mobile'])) {
            $data['mobile'] = filter_var(trim($_POST['mobile']), FILTER_SANITIZE_NUMBER_INT);
        }

        if(isset($_POST['telephone'])) {
            $data['telephone'] = filter_var(trim($_POST['telephone']), FILTER_SANITIZE_NUMBER_INT);
        }

        if(isset($_POST['gender'])) {
            $data['gender'] = filter_var(trim($_POST['gender']), FILTER_SANITIZE_STRING);
        }

        if(isset($_POST['birthday'])) {
            $data['birthday'] = filter_var(trim($_POST['birthday']), FILTER_SANITIZE_STRING);
        }

        if(isset($_POST['address'])) {
            $data['address'] = filter_var(trim($_POST['address']), FILTER_SANITIZE_STRING);
        }

        if(isset($_POST['marriage'])) {
            $data['marriage'] = filter_var(trim($_POST['marriage']), FILTER_SANITIZE_STRING);
        }


        if (!empty($data) && !empty($userId)) {
            if(!empty($data['name']) && !empty($data['family']))
            {

                $model = Load::model('members');
                $resultUpdate = $model->updateProfile($data, $userId);
                if ($resultUpdate) {
                    $result['result_status'] = 'success';
                    $result['result_message'] = functions::Xmlinformation("InformationSuccessfullyUpdated")->__toString();
                    $_SESSION["nameUser"] =  $data['name'] . ' ' . $data['family'];
                } else {
                    $result['result_status'] = 'error';
                    $result['result_message'] = functions::Xmlinformation("ErrorUpdatingUserInformation")->__toString();
                }
            }else{
                $result['result_status'] = 'error';
                $result['result_message'] = functions::Xmlinformation("ErrorUpdatingUserInformation")->__toString();
            }

        }else {
            $result['result_status'] = 'error';
            $result['result_message'] = functions::Xmlinformation("ErrorUpdatingUserInformation")->__toString();
        }

        return $result ;
    }
    #endregion

    #region info_hotel_client
    public function info_hotel_client($factorNumber)
    {
        $Model = Load::library('Model');

        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');

            $sql = "select *,"
                . " (SELECT COUNT(id) FROM report_hotel_tb WHERE factor_number='{$factorNumber}') AS CountId "
                . " from report_hotel_tb  where factor_number='{$factorNumber}' ";
            $result = $ModelBase->select($sql);
        } else {

            $sql = "select *,"
                . " (SELECT COUNT(id) FROM book_hotel_local_tb WHERE factor_number='{$factorNumber}') AS CountId "
                . " from book_hotel_local_tb  where factor_number='{$factorNumber}' ";
            $result = $Model->select($sql);
        }

        $this->count = count($result);

        $sql_check = " SELECT * FROM 
                              reservation_book_one_day_tour_tb BT 
                              LEFT JOIN reservatin_one_day_tour_tb T ON BT.fk_id_one_day_tour=T.id
                        WHERE BT.fk_factor_number ='{$factorNumber}' ";
        $book = $Model->select($sql_check);

        if (!empty($book)){
            $this->showOneDayTour = 'True';
            foreach ($book as $k=>$val){

                $amountR = ($val['num_adt_r']*$val['adt_price_rial'])+($val['num_chd_r']*$val['chd_price_rial'])+($val['num_inf_r']*$val['inf_price_rial']);
                $amountA = ($val['num_adt_a']*$val['adt_price_foreign'])+($val['num_chd_a']*$val['chd_price_foreign'])+($val['num_inf_a']*$val['inf_price_foreign']);

                $listOneDayTour[$k]['title'] = $val['title'];
                $listOneDayTour[$k]['price'] = $amountR;
            }

            $this->listOneDayTour = $listOneDayTour;
        }else {
            $this->showOneDayTour = 'False';
        }

        return $result;
    }
    #endregion

    #region info_visa_client
    public function info_visa_client($factor_number)
    {
        $Model = Load::library('Model');

        $sql = "SELECT * FROM book_visa_tb  WHERE factor_number='$factor_number' AND (factor_number > 0 || factor_number <> '')";
        $result = $Model->select($sql);

        $this->count = count($result);
        return $result;
    }
    #endregion
    #region info_Gasht_client
    public function info_gasht_client($factor_number)
    {
        $Model = Load::library('Model');

        $sql = "SELECT * FROM book_gasht_local_tb  WHERE passenger_factor_num='$factor_number' AND (passenger_factor_num > 0 || passenger_factor_num <> '')";
        $result = $Model->select($sql);


        return $result;
    }
    #endregion
    public function get_gasht_pdf($sourcName, $pnr)
    {
        $factorGasht = Load::controller('factorGasht');
        return $factorGasht->getReservePdf($sourcName, $pnr);
    }
    #region info_Bus_client
    public function info_bus_client($factor_number)
    {
        $Model = Load::library('Model');

        $sql = "SELECT * FROM book_bus_tb  WHERE passenger_factor_num='$factor_number' AND (passenger_factor_num > 0 || passenger_factor_num <> '')";
        $result = $Model->select($sql);


        return $result;
    }
    #endregion
    #region info_europcar_client
    public function info_europcar_client($factor_number)
    {
        $Model = Load::library('Model');

        $sql = "SELECT * FROM book_europcar_local_tb  WHERE factor_number='$factor_number' AND (factor_number > 0 || factor_number <> '')";
        $result = $Model->select($sql);

        $this->count = count($result);
        return $result;
    }
    #endregion
    /**
     * @param $RequestNumber
     * @param null $clientId
     * @return mixed
     */
    private function getInfoTicketFlightCancel($RequestNumber,$clientId=null)
    {
        $sql = "SELECT  "
            . " book.id,"
            . " book.passenger_name, "
            . " book.passenger_family, "
            . " book.passenger_name_en, "
            . " book.passenger_family_en, "
            . " book.passenger_age, "
            . " book.passenger_national_code, "
            . " book.passportNumber, "
            . " book.passenger_birthday_en, "
            . " book.passenger_birthday, "
            . " book.factor_number, "
            . " book.member_id, "
            . " book.request_number, "
            . " book.flight_type, "
            . " book.airline_iata, "
            . " book.cabin_type, "
            . " book.adt_price, "
            . " book.chd_price, "
            . " book.inf_price, "
            . " book.adt_fare, "
            . " book.chd_fare, "
            . " book.inf_price, "
            . " book.api_commission, "
            . " book.inf_fare, "
            . " book.pid_private,"
            . " book.date_flight,"
            . " book.time_flight,"
            . " ( SELECT Cancel.NationalCode  FROM cancel_ticket_tb As Cancel"
            . " INNER JOIN cancel_ticket_details_tb AS detailCancel ON detailCancel.id=Cancel.IdDetail"
            . " WHERE (book.passenger_national_code=Cancel.NationalCode OR book.passportNumber=Cancel.NationalCode)  AND detailCancel.RequestNumber='{$RequestNumber}' GROUP BY Cancel.NationalCode ) AS NationalCode,"
            . " (SELECT detailCancel.`Status` FROM cancel_ticket_tb As Cancel"
            . "  INNER JOIN cancel_ticket_details_tb AS detailCancel ON detailCancel.id=Cancel.IdDetail"
            . "  WHERE (book.passenger_national_code=Cancel.NationalCode OR book.passportNumber=Cancel.NationalCode) AND detailCancel.RequestNumber='{$RequestNumber}' GROUP BY Cancel.NationalCode ) AS Status,"
            . " (SELECT detailCancel.`ReasonMember` FROM cancel_ticket_tb AS Cancel INNER JOIN cancel_ticket_details_tb AS detailCancel ON detailCancel.id = Cancel.IdDetail"
            . " WHERE( book.passenger_national_code = Cancel.NationalCode OR book.passportNumber = Cancel.NationalCode ) AND detailCancel.RequestNumber='{$RequestNumber}' GROUP BY Cancel.NationalCode ) AS ReasonMember"
            . " FROM book_local_tb AS book "
            . " WHERE book.request_number ='{$RequestNumber}'"
            . " GROUP BY book.id ";

        if($clientId > 0 && $clientId !="")
        {
            $admin= Load::controller('admin');

            return $admin->ConectDbClient($sql, $clientId, "SelectAll", "", "", "");
        }
        return $this->Model->select($sql);
    }

    /**
     * @param $RequestNumber
     * @return mixed
     */
    private function getInfoTicketTrainCancel($RequestNumber)
    {
        $sql = "SELECT  "
            . " book.id,"
            . " book.passenger_name, "
            . " book.passenger_family, "
            . " book.passenger_age, "
            . " book.passenger_national_code, "
            . " book.passportNumber, "
            . " book.passenger_birthday_en, "
            . " book.passenger_birthday, "
            . " book.factor_number, "
            . " book.member_id , "
            . " book.requestNumber , "
            . " ( SELECT Cancel.NationalCode  FROM cancel_ticket_tb As Cancel"
            . " INNER JOIN cancel_ticket_details_tb AS detailCancel ON detailCancel.id=Cancel.IdDetail"
            . " WHERE (book.passenger_national_code=Cancel.NationalCode OR book.passportNumber=Cancel.NationalCode)  AND detailCancel.RequestNumber='{$RequestNumber}') AS NationalCode,"
            . " ( SELECT detailCancel.`Status` FROM cancel_ticket_tb As Cancel"
            . "  INNER JOIN cancel_ticket_details_tb AS detailCancel ON detailCancel.id=Cancel.IdDetail"
            . "  WHERE (book.passenger_national_code=Cancel.NationalCode OR book.passportNumber=Cancel.NationalCode) AND detailCancel.RequestNumber='{$RequestNumber}') AS Status"
            . " FROM book_local_tb AS book "
            . " WHERE book.requestNumber ='{$RequestNumber}'"
            . " GROUP BY book.id ";
        return $this->Model->select($sql);
    }

    public function getInfoTicketBusCancel($order_code,$ClientId=CLIENT_ID)
    {
        $sql = "SELECT
                        book.id,
                        book.passenger_name,
                        book.passenger_family,
                        book.passenger_factor_num,
                        book.passenger_national_code,
                        book.passportNumber,
                        book.passenger_birthday,
                        book.member_id,
                        book.order_code,
                        book.total_price,
                        book.order_code AS RequestNumber,
                        cancelDetail.*,
                        cancelTicket.NationalCode as NationalCode
                    FROM
                        book_bus_tb AS book
                        LEFT JOIN cancel_ticket_tb AS cancelTicket ON book.passenger_national_code = cancelTicket.NationalCode 
                        OR book.passportNumber = cancelTicket.NationalCode
                        LEFT JOIN cancel_ticket_details_tb AS cancelDetail ON cancelDetail.id = cancelTicket.IdDetail 
                        AND cancelDetail.RequestNumber=book.order_code

                    WHERE
                        book.order_code = '{$order_code}' 
                    GROUP BY
                        book.id";

        /*if(CLIENT_ID == 166){
            var_dump($sql);
            die();
        }*/

        return $this->admin->ConectDbClient($sql, $ClientId, "SelectAll", "", "", "");
    }
    public function getInfoTicketHotelCancel($order_code,$ClientId=CLIENT_ID)
    {
        $sql = "SELECT
                        book.id,
                        book.passenger_name,
                        book.passenger_family,
                        book.passenger_national_code,
                        book.passenger_age,
                        book.passportNumber,
                        book.passenger_birthday,
                        book.member_id,
                        book.factor_number,
                        book.total_price,
                        book.factor_number as RequestNumber,
                        cancelDetail.*,
                        cancelTicket.NationalCode as NationalCode
                    FROM
                        book_hotel_local_tb AS book
                        LEFT JOIN cancel_ticket_tb AS cancelTicket ON book.passenger_national_code = cancelTicket.NationalCode 
                        OR book.passportNumber = cancelTicket.NationalCode
                        LEFT JOIN cancel_ticket_details_tb AS cancelDetail ON cancelDetail.id = cancelTicket.IdDetail 
                        AND cancelDetail.RequestNumber=book.factor_number

                    WHERE
                        book.factor_number = '{$order_code}' 
                    GROUP BY
                        book.id";

        /*if(CLIENT_ID == 166){
            var_dump($sql);
            die();
        }*/

        return $this->admin->ConectDbClient($sql, $ClientId, "SelectAll", "", "", "");
    }

    public function getInfoTicketInsuranceCancel($order_code,$ClientId=CLIENT_ID)
    {
        $sql = "SELECT
                        book.id,
                        book.passenger_name,
                        book.passenger_family,
                        book.passenger_national_code,
                        book.passenger_age,
                        book.passport_number as passportNumber,
                        book.passenger_birth_date as passenger_birthday,
                        book.member_id,
                        book.factor_number,
                        book.base_price as total_price,
                        book.factor_number as RequestNumber,
                        cancelDetail.*,
                        cancelTicket.NationalCode as NationalCode
                    FROM
                        book_insurance_tb AS book
                        LEFT JOIN cancel_ticket_tb AS cancelTicket ON book.passenger_national_code = cancelTicket.NationalCode 
                        OR book.passport_number = cancelTicket.NationalCode
                        LEFT JOIN cancel_ticket_details_tb AS cancelDetail ON cancelDetail.id = cancelTicket.IdDetail 
                        AND cancelDetail.RequestNumber=book.factor_number
                    WHERE
                        book.factor_number = '{$order_code}' 
                    GROUP BY
                        book.id";


        /*if(CLIENT_ID == 166){
            var_dump($sql);
            die();
        }*/

        return $this->admin->ConectDbClient($sql, $ClientId, "SelectAll", "", "", "");
    }


    //region getRequestCreditGift
    public function getRequestCreditGift()
    {
        $Sql = "SELECT credit.*, member.name, member.family FROM members_credit_tb AS credit 
                LEFT JOIN members_tb AS member ON member.id = credit.memberId 
                WHERE credit.reason='giftBuyTicket'";

        return $this->Model->select($Sql);
    }
    //endregion

    public function changeStatusMemberCredit($params)
    {

        $type_accept = ($params['type']=='accept') ? 'success' : 'error' ;

        $find_transaction = $this->getController('memberCredit')->getSpecificCreditMemberById($params['id']);

        $data['status'] = $type_accept;

        if($params['Price'] !=$find_transaction['amount']){
            $data['amount'] = str_replace(',','',$params['price']);
        }

        $condition = "id='{$params['id']}'";

        $res = $this->getModel('membersCreditModel')->update($data,$condition);

        if($res){
            if($params['type']!='accept'){
                $this->getController('historyPointClub')->deleteSpecificPointByFactorNumber($find_transaction['factorNumber']);
            }

            return 'success:تغییر وضعیت درخواست  با موفقیت انجام  شد  ';
        }else{
            return 'error:خطا در ثبت تغییر وضعیت درخواست ';
        }


    }



    #region apiUpdateUser
    public function apiUpdateUser($params)
    {

        $userId = Session::getUserId(); // id کانتر یا آژانسی که لاگین کرده

        if(isset($params['form']['name'])) {
            $data['name'] = $params['form']['name'];
        }

        if(isset($params['form']['family'])) {
            $data['family'] = $params['form']['family'];
        }

        if(isset($params['form']['mobile'])) {
            $data['mobile'] = $params['form']['mobile'];
        }

        if(isset($params['form']['telephone'])) {
            $data['telephone'] = $params['form']['telephone'];
        }

        if(isset($params['form']['gender'])) {
            $data['gender'] = $params['form']['gender'];
        }

        if(isset($params['form']['birth_date'])) {
            $data['birthday'] = $params['form']['birth_date'];
        }

        if(isset($params['form']['address'])) {
            $data['address'] = $params['form']['address'];
        }

        if(isset($params['form']['marriage'])) {
            $data['marriage'] = $params['form']['marriage'];
        }





        if (!empty($data) && !empty($userId)) {
            if(empty($data['name']) && empty($data['family']))
            {
                $message=functions::Xmlinformation("ErrorUpdatingUserInformation");
                return functions::withError(false,422,$message);
            }

        }else {
            $message=functions::Xmlinformation("ErrorUpdatingUserInformation");
            return functions::withError(false,500,$message);
        }

        $model = Load::model('members');
        return functions::withSuccess($model->updateProfile($data, $userId),201);

    }
    #endregion

    function apiGetProfile($params = '')
    {
        $is_login = Session::IsLogin();

        if ($is_login) {
            $model = Load::model('members');
            $userId = Session::getUserId();
            if ($params['id'] != '') {
                $userId = $params['id'];
            }
            $data = $model->get($userId);
            if ($data) {
                $data['agency_name'] = $this->getAgencyName($data['fk_agency_id']);
                $data['counter_type'] = $this->getTypeCounter($data['fk_counter_type_id']);
                $data['register_date'] = functions::DateJalali($data['register_date']);
                $data['last_modify'] = functions::DateJalali($data['last_modify']);
                return functions::withSuccess($data);
            }
            return functions::withError($data, 404);
        }
        return functions::withError(false, 403);

    }

    public function changeMonthUser($data) {
        $index = self::monthsPersian();
        for ($i = 1; $i < count($index); $i++) {
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
        for ($i = 1; $i < count($index); $i++) {
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
    public function UpdateUserProfile() {

        $userId = Session::getUserId(); // id کانتر یا آژانسی که لاگین کرده

        if (isset($_POST['gender'])) {
            $data['gender'] = filter_var(trim($_POST['gender']), FILTER_SANITIZE_STRING);
        }
        if (isset($_POST['national_type'])) {
            $data['national_type'] = filter_var(trim($_POST['national_type']), FILTER_SANITIZE_STRING);
        }
        if (isset($_POST['name'])) {
            $data['name'] = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
        }
        if (isset($_POST['family'])) {
            $data['family'] = filter_var(trim($_POST['family']), FILTER_SANITIZE_STRING);
        }
        if (isset($_POST['name_en'])) {
            $data['name_en'] = filter_var(trim($_POST['name_en']), FILTER_SANITIZE_STRING);
        }
        if (isset($_POST['family_en'])) {
            $data['family_en'] = filter_var(trim($_POST['family_en']), FILTER_SANITIZE_STRING);
        }

//        if (isset($_POST['national_code'])) {
//            $data['national_code'] = filter_var(trim($_POST['national_code']), FILTER_SANITIZE_NUMBER_INT);
//        }

//        if (isset($_POST['passport_country_id'])) {
//            $data['passport_country_id'] = filter_var(trim($_POST['passport_country_id']), FILTER_SANITIZE_STRING);
//        }
        if (isset($_POST['email'])) {
            $data['email'] = filter_var(trim($_POST['email']), FILTER_SANITIZE_STRING);
        }
        if (isset($_POST['telephone'])) {
            $data['telephone'] = filter_var(trim($_POST['telephone']), FILTER_SANITIZE_NUMBER_INT);
        }
//        if (isset($_POST['passport_number'])) {
//            $data['passport_number'] = filter_var(trim($_POST['passport_number']), FILTER_SANITIZE_STRING);
//        }

//        if (isset($_POST['national_type']) && $_POST['national_type'] == 'IR'){
//
//            if (isset($_POST['birth_day_ir']) && isset($_POST['birth_month_ir']) && isset($_POST['birth_year_ir']) && !empty($_POST['birth_month_ir']) && !empty($_POST['birth_day_ir']) && !empty($_POST['birth_year_ir'])) {
//                $_POST['birth_month_ir'] = filter_var(trim($_POST['birth_month_ir']), FILTER_SANITIZE_STRING);
//                $_POST['birth_day_ir'] = filter_var(trim($_POST['birth_day_ir']), FILTER_SANITIZE_NUMBER_INT);
//                $_POST['birth_year_ir'] = filter_var(trim($_POST['birth_year_ir']), FILTER_SANITIZE_NUMBER_INT);
//                $_POST['birth_month_ir'] = self::changeMonthUser($_POST['birth_month_ir']);
//                $_POST['birth_day_ir'] = self::zeroBeginningNumber($_POST['birth_day_ir']);
//                $data['birthday'] = $_POST['birth_year_ir'] . '-' . $_POST['birth_month_ir'] . '-' . $_POST['birth_day_ir'];
//                $data['birthday_en'] = functions::ConvertToMiladi($data['birthday']);
//            }else {
//                $data['birthday'] = '';
//                $data['birthday_en'] = '';
//            }
//            if (isset($_POST['expire_day_ir']) && isset($_POST['expire_month_ir']) && isset($_POST['expire_year_ir']) && !empty($_POST['expire_day_ir']) && !empty($_POST['expire_month_ir']) && !empty($_POST['expire_year_ir'])) {
//                $_POST['expire_day_ir'] = filter_var(trim($_POST['expire_day_ir']), FILTER_SANITIZE_NUMBER_INT);
//                $_POST['expire_month_ir'] = filter_var(trim($_POST['expire_month_ir']), FILTER_SANITIZE_STRING);
//                $_POST['expire_year_ir'] = filter_var(trim($_POST['expire_year_ir']), FILTER_SANITIZE_NUMBER_INT);
//                $_POST['expire_day_ir'] = self::zeroBeginningNumber($_POST['expire_day_ir']);
//                $_POST['expire_month_ir'] = self::changeMonthUser($_POST['expire_month_ir']);
//                $data['expire_passport_ir'] = $_POST['expire_year_ir'] . '-' . $_POST['expire_month_ir'] . '-' . $_POST['expire_day_ir'];
//                $data['expire_passport_en'] = functions::ConvertToMiladi($data['expire_passport_ir']);
//            }else {
//                $data['expire_passport_ir'] = '';
//                $data['expire_passport_en'] = '';
//            }
//
//        }else{
//
//            if (isset($_POST['birth_day_miladi']) && isset($_POST['birth_month_miladi']) && isset($_POST['birth_year_miladi']) && !empty($_POST['birth_day_miladi']) && !empty($_POST['birth_month_miladi']) && !empty($_POST['birth_year_miladi']))
//            {
//                $_POST['birth_day_miladi'] = filter_var(trim($_POST['birth_day_miladi']), FILTER_SANITIZE_NUMBER_INT);
//                $_POST['birth_month_miladi'] = filter_var(trim($_POST['birth_month_miladi']), FILTER_SANITIZE_STRING);
//                $_POST['birth_year_miladi'] = filter_var(trim($_POST['birth_year_miladi']), FILTER_SANITIZE_NUMBER_INT);
//                $_POST['birth_day_miladi'] = self::zeroBeginningNumber($_POST['birth_day_miladi']);
//                $_POST['birth_month_miladi'] = self::changeMonthUserNoIr($_POST['birth_month_miladi']);
//                $data['birthday_en'] = $_POST['birth_year_miladi'].'-'.$_POST['birth_month_miladi'].'-'.$_POST['birth_day_miladi'];
//                $data['birthday'] = functions::ConvertToJalali($data['birthday_en']);
//            }else {
//                $data['birthday'] = '';
//                $data['birthday_en'] = '';
//            }
//
//            if (isset($_POST['expire_day_miladi']) && isset($_POST['expire_month_miladi']) && isset($_POST['expire_year_miladi']) && !empty($_POST['expire_day_miladi']) && !empty($_POST['expire_month_miladi']) && !empty($_POST['expire_year_miladi'])) {
//                $_POST['expire_day_miladi'] = filter_var(trim($_POST['expire_day_miladi']), FILTER_SANITIZE_NUMBER_INT);
//                $_POST['expire_month_miladi'] = filter_var(trim($_POST['expire_month_miladi']), FILTER_SANITIZE_STRING);
//                $_POST['expire_year_miladi'] = filter_var(trim($_POST['expire_year_miladi']), FILTER_SANITIZE_NUMBER_INT);
//                $_POST['expire_day_miladi'] = self::zeroBeginningNumber($_POST['expire_day_miladi']);
//                $_POST['expire_month_miladi'] = self::changeMonthUserNoIr($_POST['expire_month_miladi']);
//                $data['expire_passport_en'] = $_POST['expire_year_miladi'] . '-' . $_POST['expire_month_miladi'] . '-' . $_POST['expire_day_miladi'];
//                $data['expire_passport_ir'] = functions::ConvertToJalali($data['expire_passport_en']);
//            }else {
//                $data['expire_passport_ir'] = '';
//                $data['expire_passport_en'] = '';
//            }
//        }


        if (!empty($data) && !empty($userId)) {
            if(!empty($data['name']) && !empty($data['family']))
            {

                $model = Load::model('members');

                $resultUpdate = $model->updateProfile($data, $userId);
                if ($resultUpdate) {
                    $result['result_status'] = 'success';
                    $result['result_message'] = functions::Xmlinformation("InformationSuccessfullyUpdated")->__toString();
                    $_SESSION["nameUser"] =  $data['name'] . ' ' . $data['family'];
                } else {
                    $result['result_status'] = 'error';
                    $result['result_message'] = functions::Xmlinformation("ErrorUpdatingUserInformation")->__toString();
                }
            }else{
                $result['result_status'] = 'error';
                $result['result_message'] = functions::Xmlinformation("ErrorUpdatingUserInformation")->__toString();
            }

        }else {
            $result['result_status'] = 'error';
            $result['result_message'] = functions::Xmlinformation("ErrorUpdatingUserInformation")->__toString();
        }
        return $result ;
    }

    public function getCountryName( $id ) {
        $ModelBase = Load::library( 'ModelBase' );
        $sql       = " SELECT titleFa,id FROM country_codes_tb WHERE id='" . $id . "'  ";
        return $ModelBase->load( $sql );
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
    public function yearsPersian() {
        $Year =  dateTimeSetting::jdate("Y",time(),'','','en');
        $arr = array();
        for($i = $Year - 90; $i <= $Year ; $i++) {
            $arr[] = $i;
        }
        return array_reverse($arr);
    }
    public function yearsPersianExpire() {
        $Year =  dateTimeSetting::jdate("Y",time(),'','','en');
        $arr = array();
        for($i = $Year + 10; $Year <= $i ; $i--) {
            $arr[] = $i;
        }
        return $arr;
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
    public function yearsMiladi() {
        $Year =  date("Y",time());
        $arr = array();
        for($i = $Year - 90; $i <= $Year ; $i++) {
            $arr[] = $i;
        }
        return array_reverse($arr);
    }
    public function yearsMiladiExpire() {
        $Year =  date("Y",time());
        $arr = array();
        for($i = $Year + 10; $Year <= $i ; $i--) {
            $arr[] = $i;
        }
        return $arr;
    }
    public function percentInfoComplete() {
        $list_item = array("", "", "");
    }


    public function getBookAllFlight($param = '') {
        $id = Session::getUserId();
        $Model = Load::library('Model');
        $info_agency = functions::infoAgencyByMemberId($id);
        $sql = "SELECT   
                   passenger_name,
                   passenger_name_en,
                   passenger_family,
                   passenger_family_en,
                   origin_city,
                   desti_city,
                   request_number,
                   creation_date_int,
                   airline_name,
                   eticket_number,
                   flight_number,
                   flight_type,
                   time_flight,
                   date_flight,
                   factor_number,
                   successfull,
                   IsInternal,
                   type_app,
                   request_cancel,
                   direction,
                   currency_code
                 FROM book_local_tb 
                 WHERE 
                    member_id='{$id}' AND request_number > '0' ";

        if (!empty($param['startDate']) && !empty($param['endDate'])) {
            $date_of = explode('-', $_POST['startDate']);
            $date_to = explode('-', $_POST['endDate']);
            if(SOFTWARE_LANG == 'fa'){
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }else{
                $date_of_int = mktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = mktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        }

        if (isset($param['factorNumber']) && $param['factorNumber'] != '') {
            $sql .= " AND (request_number LIKE '%{$param['factorNumber']}%' OR factor_number LIKE '%{$param['factorNumber']}%') ";
        }
        if (isset($param['statusGroup']) && $param['statusGroup'] == 'cancel') {
            $sql .= " AND successfull = 'book' AND request_cancel = 'confirm'  ";
        }elseif(isset($param['statusGroup']) && $param['statusGroup'] != '') {
            $sql .= " AND (successfull LIKE '%{$param['statusGroup']}%') ";
        }
        if (isset($param['passengerName']) && $param['passengerName'] != '') {
            $sql .= " AND ((concat(passenger_name,' ',passenger_family) LIKE '%{$param['passengerName']}%')  OR (concat(passenger_name,passenger_family) LIKE '%{$param['passengerName']}%'))";
        }
        $sql .= "
                GROUP BY request_number 
                ORDER BY creation_date_int DESC ";
//echo $sql;
        $bookList = $Model->select($sql);
        $result = [] ;
        foreach ($bookList as  $key => $item ){
            $amount_buy = functions::CalculateDiscount($item['request_number']) ;
            $number_format_float = ($info_agency['type_payment'] == 'currency' && SOFTWARE_LANG !="fa") ? 2 : 0 ;
            $bookList[$key]['price_final'] = number_format(functions::calcDiscountCodeByFactor($amount_buy, $item['factor_number']),$number_format_float);
            if ($item['IsInternal'] == 0) {
                $bookList[$key]['flight_internal_external'] = functions::Xmlinformation('Foreign')->__toString();
            }else {
                $bookList[$key]['flight_internal_external'] = functions::Xmlinformation('Internal')->__toString();
            }
            if ($item['creation_date_int'] != '') {
                $bookList[$key]['creation_date_int'] = functions::printDateIntByLanguage('Y/m/d',$item['creation_date_int'],SOFTWARE_LANG);
                $bookList[$key]['creation_time_int'] = functions::printDateIntByLanguage('H:i',$item['creation_date_int'],SOFTWARE_LANG);
            } else {
                $bookList[$key]['creation_date_int'] = '----';
                $bookList[$key]['creation_time_int'] = '';
            }

            if ($item['successfull'] == 'nothing') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknow')->__toString();
            }elseif ($item['successfull'] == 'error') {
                if($item['flight_type']=='system'){
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('ErrorPayment')->__toString();
                }elseif($item['flight_type']=='charter'){
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('ErrorPayment')->__toString();
                }elseif($item['flight_type']=='charterPrivate'){
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('errorCharterPrivate')->__toString();
                }
            }elseif ($item['successfull'] == 'prereserve') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Prereservation')->__toString();
            } elseif ($item['successfull'] == 'bank') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('RedirectPayment')->__toString();
            } elseif ($item['successfull'] == 'book') {
                if ($item['request_cancel'] == 'confirm') {
                    $bookList[$key]['view_status'] = functions::Xmlinformation('Definitivereservation')->__toString().' <span style="color: #fd6767; margin-right: 10px; ">('. functions::Xmlinformation('Refunded')->__toString().')</span>';
                }else {
                    $bookList[$key]['view_status'] = functions::Xmlinformation('Definitivereservation')->__toString();
                }
            }elseif ($item['successfull'] == 'processing') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('processingPrintFlight')->__toString();
            }elseif ($item['successfull'] == 'pending') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('pendingPrintFlight')->__toString();
            }elseif ($item['successfull'] == 'credit') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Credit')->__toString();
            }
            if ($item['direction'] == 'TwoWay') {
                $bookList[$key]['return_dept_TwoWay'] = " (" .functions::Xmlinformation('Twoway')->__toString() . ") ";
            } elseif ($item['direction'] == 'dept' ) {
                $bookList[$key]['return_dept_TwoWay'] = " (" .functions::Xmlinformation('Went')->__toString() . ") ";
            } elseif ($item['direction'] == 'return' ) {
                $bookList[$key]['return_dept_TwoWay'] = " (" .functions::Xmlinformation('JustReturn')->__toString() . ") ";
            } else {
                $bookList[$key]['return_dept_TwoWay'] = "";
            }
            $result[$key]['service'] = 'Flight';
            $result[$key]['title'] = functions::Xmlinformation('Flight')->__toString() .' '. $bookList[$key]['flight_internal_external'] . ' ' .$item['origin_city'] . ' - ' . $item['desti_city'] .' '. $bookList[$key]['return_dept_TwoWay'];
            $result[$key]['passenger_name'] = $item['passenger_name'] . ' ' . $item['passenger_family'];
            $result[$key]['date'] = $bookList[$key]['creation_date_int'];
            $result[$key]['time'] = $bookList[$key]['creation_time_int'];
            $result[$key]['status'] = [
                'title' => $item['successfull'],
                'value' => $bookList[$key]['view_status']
            ];
            $result[$key]['factor_number'] = $item['factor_number'];
            $result[$key]['price'] = $bookList[$key]['price_final'];
            if ($item['eticket_number']) {
                $eticket_number = $item['eticket_number'];
            }else{
                $eticket_number = '---';
            }
            $result[$key]['info_list'] = [
                [
                    'title' =>  functions::Xmlinformation('Ticketnumber')->__toString() ,
                    'value' => $eticket_number
                ],
                [
                    'title' => functions::Xmlinformation('AirlineCompany')->__toString() ,
                    'value' => $item['airline_name']
                ],
                [
                    'title' => functions::Xmlinformation('Route')->__toString() ,
                    'value' => $item['origin_city'] . ' - ' . $item['desti_city']
                ],
                [
                    'title' => functions::Xmlinformation('DateTimeDeparture')->__toString() ,
                    'value' => $item['date_flight'] . ' <br>  ساعت ' . $item['time_flight']
                ],
                [
                    'title' => functions::Xmlinformation('Amount')->__toString() ,
                    'value' =>  $bookList[$key]['price_final']
                ]
            ];

            $bookList[$key]['dataBtnPdf'] = '';
            $bookList[$key]['dataBtnPdfFreeLink'] = '';
            $bookList[$key]['ViewBill'] = '';
            $bookList[$key]['dataBtnCancel'] = '';
            $bookList[$key]['reservationProofVersa'] = '';
            if ($item['successfull'] == 'book') {
                if ($item['IsInternal'] == '0') {
                    $bookList[$key]['dataBtnPdf'] =  ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=ticketForeign&id=' . $item['request_number'];
                } else {
                    if (SOFTWARE_LANG != 'fa') {
                        $pagefinal = 'bookshow';
                    }else{
                        $pagefinal = 'parvazBookingLocal';
                    }
                    $bookList[$key]['dataBtnPdf'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target='.$pagefinal.'&id=' . $item['request_number'] . '&lang=fa';
                    $type_member = functions::TypeUser(session::getUserId());
                    if ($type_member == 'Counter') {
                        $bookList[$key]['dataBtnPdf'] =  ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target='.$pagefinal.'&id=' . $item['request_number'].'&lang=fa';
                        $bookList[$key]['dataBtnPdfFreeLink'] =  ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target='.$pagefinal.'&id=' . $item['request_number'] . '&cash=no';
                    }

                }
                $result[$key]['button_list'] = [
                    [
                        'title' => functions::Xmlinformation('PassengerListProfile')->__toString(),
                        'type' => 'button' ,
                        'function'  => "modalPassengerDetails(event.currentTarget  , ".$item['factor_number'].",'flight')" ,
                    ],
                    [
                        'title' => functions::Xmlinformation('GetTicket')->__toString(),
                        'type' => 'link',
                        'link' => $bookList[$key]['dataBtnPdf'],
                    ],
                    [
                        'title' => functions::Xmlinformation('Viewbill')->__toString(),
                        'type' => 'link',
                        'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=boxCheck&id=' . $item['request_number'],
                    ],

                ];
                if ($item['successfull'] == 'book' && $item['request_cancel'] == 'confirm' ) {
                    $result[$key]['button_list'][] =
                        [
                            'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                            'type' => 'link',
                            'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=parvazBookingLocal&id=' . $item['request_number'] .'&cancelStatus=confirm',
                        ];
                }else{
                    $result[$key]['button_list'][] =
                        [
                            'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                            'type' => 'button' ,
                            'function' => "ModalCancelUserProfile(event.currentTarget ,'flight' , '".$item['request_number']."')",

                        ];
                }
                if ($item['successfull'] == 'book') {
                    if ($item['IsInternal'] != '0') {
                        $result[$key]['button_list'][] =
                            [
                                'title' => functions::Xmlinformation('Freeticket')->__toString(),
                                'type' => 'link',
                                'link' => $bookList[$key]['dataBtnPdfFreeLink'],
                            ];
                    }
                }
                if(CLIENT_ID == 271){
                    $reservation_proof = Load::controller('reservationProof');
                    $file = $reservation_proof->getProofFile($item['request_number'] , 'Flight');
                    if($file && isset($file) && !empty($file)) {
                        $result[$key]['button_list'][] =
                            [
                                'title' => functions::Xmlinformation('ViewProof')->__toString(),
                                'type' => 'button' ,
                                'function'  => "modalForReservationProofVersa( event.currentTarget ,".$item['factor_number'].", 'flight')" ,
                            ];
                    }
                }else {
                    $bookList[$key]['reservationProofVersa'] = '';
                }


            }
        }
        return $result;
    }

    public function getBookAllExclusiveTour($param = '') {

        $id = Session::getUserId();
        $Model = Load::library('Model');

        $sql = "SELECT   
               passenger_name,
               passenger_family,
               origin_city,
               desti_city,
               request_number,
               creation_date_int,
               airline_name,
               ret_airline_name,
               flight_number,
               ret_flight_number,
               time_flight,
               ret_time_flight,
               date_flight,
               ret_date_flight,
               factor_number,
               successfull,
               IsInternal,
               type_app,
               hotel_name,
               check_in,
               check_out,
               total_price,
               request_cancel,
               entertainment_data_json,
               currency_code
             FROM book_exclusive_tour_tb 
             WHERE member_id='{$id}' AND request_number > '0' ";

        // === فیلتر تاریخ ===
        if (!empty($param['startDate']) && !empty($param['endDate'])) {
            $date_of = explode('-', $_POST['startDate']);
            $date_to = explode('-', $_POST['endDate']);
            if(SOFTWARE_LANG == 'fa'){
                $date_of_int = dateTimeSetting::jmktime(0,0,0,$date_of[1],$date_of[2],$date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23,59,59,$date_to[1],$date_to[2],$date_to[0]);
            } else {
                $date_of_int = mktime(0,0,0,$date_of[1],$date_of[2],$date_of[0]);
                $date_to_int = mktime(23,59,59,$date_to[1],$date_to[2],$date_to[0]);
            }
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int <= '{$date_to_int}'";
        }

        // === سایر فیلترها ===
        if (!empty($param['factorNumber'])) {
            $sql .= " AND (request_number LIKE '%{$param['factorNumber']}%' OR factor_number LIKE '%{$param['factorNumber']}%') ";
        }
        if (!empty($param['statusGroup'])) {
            if ($param['statusGroup'] == 'cancel') {
                $sql .= " AND successfull = 'book' AND request_cancel = 'confirm' ";
            } else {
                $sql .= " AND successfull LIKE '%{$param['statusGroup']}%' ";
            }
        }
        if (!empty($param['passengerName'])) {
            $sql .= " AND ((concat(passenger_name,' ',passenger_family) LIKE '%{$param['passengerName']}%')  
                     OR (concat(passenger_name,passenger_family) LIKE '%{$param['passengerName']}%'))";
        }

        $sql .= " GROUP BY request_number ORDER BY creation_date_int DESC";

        $bookList = $Model->select($sql);

        $result = [];

        foreach ($bookList as $key => $item) {
            $price_final = number_format($item['total_price']);
            //        ============================EntertainmentData============================
            $entertainmentSection = null;
            if (!empty($item['entertainment_data_json'])) {

                $entData = json_decode($item['entertainment_data_json'], true);

                if (is_array($entData) && count($entData)) {

                    $entItems = [];

                    foreach ($entData as $ent) {

                        $title = (isset($ent['tourTitle']) && $ent['tourTitle'] != '')
                            ? $ent['tourTitle']
                            : 'تفریح';

                        $price = (isset($ent['final_price']) && $ent['final_price'] != '')
                            ? number_format($ent['final_price'])
                            : '0';

                        $entItems[] = [
                            'title' => $title,
                            'value' => $price
                        ];
                    }

                    if (count($entItems)) {
                        $entertainmentSection = [
                            'title' => 'خدمات اضافه',
                            'items' => $entItems
                        ];
                    }
                }
            }
            //        ============================EntertainmentData============================

            // === تاریخ و زمان ===
            $creation_date = $item['creation_date_int'] ? functions::printDateIntByLanguage('Y/m/d', $item['creation_date_int'], SOFTWARE_LANG) : '----';
            $creation_time = $item['creation_date_int'] ? functions::printDateIntByLanguage('H:i', $item['creation_date_int'], SOFTWARE_LANG) : '';

            // === وضعیت ===
            switch ($item['successfull']) {
                case 'nothing': $view_status = functions::Xmlinformation('Unknow')->__toString(); break;
                case 'error': $view_status = functions::Xmlinformation('ErrorPayment')->__toString(); break;
                case 'lock': $view_status = functions::Xmlinformation('Prereservation')->__toString(); break;
                case 'bank': $view_status = functions::Xmlinformation('RedirectPayment')->__toString(); break;
                case 'book':
                    $view_status = functions::Xmlinformation('Definitivereservation')->__toString();
                    if ($item['request_cancel'] == 'confirm') {
                        $view_status .= ' <span style="color:#fd6767;margin-right:10px;">('.functions::Xmlinformation('Refunded')->__toString().')</span>';
                    }
                    break;
                case 'processing': $view_status = functions::Xmlinformation('processingPrintFlight')->__toString(); break;
                case 'pending': $view_status = functions::Xmlinformation('pendingPrintFlight')->__toString(); break;
                case 'credit': $view_status = functions::Xmlinformation('Credit')->__toString(); break;
                default: $view_status = 'نامشخص';
            }

            $result[$key]['service'] = 'ExclusiveTour';
            $result[$key]['title'] = functions::Xmlinformation('ExclusiveTour')->__toString() .' '. $item['origin_city'] .' - '. $item['desti_city'] .' ('. $item['hotel_name'].')';
            $result[$key]['date'] = $creation_date;
            $result[$key]['time'] = $creation_time;
            $result[$key]['status'] = [
                'title' => $item['successfull'],
                'value' => $view_status
            ];
            $result[$key]['factor_number'] = $item['factor_number'];
            $result[$key]['price'] = $price_final;

            // === ساختار جدید info_new_list ===
            $result[$key]['info_new_list'] = [
                [
                    'title' => 'پرواز رفت',
                    'items' => [
                        ['title' => 'شرکت هواپیمایی', 'value' => $item['airline_name'].' '.$item['flight_number']],
                        ['title' => 'مسیر', 'value' => $item['origin_city'] . ' - ' . $item['desti_city']],
                        ['title' => 'تاریخ و ساعت حرکت', 'value' => $item['date_flight'] . ' <br> ساعت ' . $item['time_flight']],
                    ]
                ],
                [
                    'title' => 'پرواز برگشت',
                    'items' => [
                        ['title' => 'شرکت هواپیمایی', 'value' => $item['airline_name'].' '.$item['ret_flight_number']],
                        ['title' => 'مسیر', 'value' => $item['desti_city'] . ' - ' . $item['origin_city']],
                        ['title' => 'تاریخ و ساعت حرکت', 'value' => $item['ret_date_flight'] . ' <br> ساعت ' . $item['ret_time_flight']],
                        // اختیاری ↓
                        // ['title' => 'مبلغ', 'value' => $ret_price_final],
                    ]
                ],
                [
                    'title' => 'هتل',
                    'items' => [
                        ['title' => 'نام هتل', 'value' => $item['hotel_name'] ?: '----'],
                        ['title' => 'تاریخ ورود', 'value' => $item['check_in']],
                        ['title' => 'تاریخ خروج', 'value' => $item['check_out']],
                    ]
                ]
            ];
            if ($entertainmentSection) {
                $result[$key]['info_new_list'][] = $entertainmentSection;
            }


            $bookList[$key]['dataBtnPdf'] = '';
            $bookList[$key]['dataBtnPdfFreeLink'] = '';
            $bookList[$key]['ViewBill'] = '';
            $bookList[$key]['dataBtnCancel'] = '';
            $bookList[$key]['reservationProofVersa'] = '';
            if ($item['successfull'] == 'book') {
                if ($item['IsInternal'] == '0') {
                    $bookList[$key]['dataBtnPdf'] =  ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=ticketForeign&id=' . $item['request_number'];
                } else {
                    if (SOFTWARE_LANG != 'fa') {
                        $pagefinal = 'bookshow';
                    }else{
                        $pagefinal = 'parvazBookingLocal';
                    }
                    $bookList[$key]['dataBtnPdf'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target='.$pagefinal.'&id=' . $item['request_number'] . '&lang=fa';
                    $type_member = functions::TypeUser(session::getUserId());
                    if ($type_member == 'Counter') {
                        /*$bookList[$key]['dataBtnPdf'] =  ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target='.$pagefinal.'&id=' . $item['request_number'].'&lang=fa';
                        $bookList[$key]['dataBtnPdfFreeLink'] =  ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target='.$pagefinal.'&id=' . $item['request_number'] . '&cash=no';*/
                    }

                }
                $result[$key]['button_list'] = [
                    [
                        'title' => functions::Xmlinformation('PassengerListProfile')->__toString(),
                        'type' => 'button' ,
                        'function'  => "ModalPassengerExclusiveTourDetails(event.currentTarget  , ".$item['factor_number'].",'exclusivetour')" ,
                    ],
                    [
                        'title' => functions::Xmlinformation('GetTicket')->__toString(),
                        'type' => 'link',
//                        'link' => $bookList[$key]['dataBtnPdf'],
                    ],
                    [
                        'title' => functions::Xmlinformation('Viewbill')->__toString(),
                        'type' => 'link',
//                        'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=boxCheck&id=' . $item['request_number'],
                    ],

                ];
                /* if ($item['successfull'] == 'book' && $item['request_cancel'] == 'confirm' ) {
                     $result[$key]['button_list'][] =
                         [
                             'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                             'type' => 'link',
                             'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=parvazBookingLocal&id=' . $item['request_number'] .'&cancelStatus=confirm',
                         ];
                 }else{
                     $result[$key]['button_list'][] =
                         [
                             'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                             'type' => 'button' ,
                             'function' => "ModalCancelUserProfile(event.currentTarget ,'flight' , '".$item['request_number']."')",

                         ];
                 }*/
                if ($item['successfull'] == 'book') {
                    if ($item['IsInternal'] != '0') {
                        $result[$key]['button_list'][] =
                            [
                                'title' => functions::Xmlinformation('Freeticket')->__toString(),
                                'type' => 'link',
                                'link' => $bookList[$key]['dataBtnPdfFreeLink'],
                            ];
                    }
                }
                if(CLIENT_ID == 271){
                    $reservation_proof = Load::controller('reservationProof');
                    $file = $reservation_proof->getProofFile($item['request_number'] , 'Flight');
                    if($file && isset($file) && !empty($file)) {
                        $result[$key]['button_list'][] =
                            [
                                'title' => functions::Xmlinformation('ViewProof')->__toString(),
                                'type' => 'button' ,
                                'function'  => "modalForReservationProofVersa( event.currentTarget ,".$item['factor_number'].", 'flight')" ,
                            ];
                    }
                }else {
                    $bookList[$key]['reservationProofVersa'] = '';
                }


            }

        }

        return $result;
    }


    public function getBookAllBus($param = '') {
        $id = Session::getUserId();
        $sql = "SELECT   
                    passenger_name,
                    passenger_family,
                    creation_date_int,
                    status,
                    total_price,
                    passenger_factor_num,
                    order_code,
                    OriginCity,
                    DestinationCity,
                    DateMove,
                    TimeMove,
                    BaseCompany,
                    CarType,
                    request_cancel,
                    passenger_birthday,
                    passenger_birthday_en ,
                     GROUP_CONCAT(passenger_chairs SEPARATOR ', ') AS chairs
                 FROM book_bus_tb 
                 WHERE 
                    member_id='{$id}' ";
        if (!empty($param['startDate']) && !empty($param['endDate'])) {

            $date_of = explode('-', $_POST['startDate']);
            $date_to = explode('-', $_POST['endDate']);
            if(SOFTWARE_LANG == 'fa'){
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }else{
                $date_of_int = mktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = mktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        }
        if (isset($param['factorNumber']) && $param['factorNumber'] != '') {
            $sql .= " AND (request_number LIKE '%{$param['factorNumber']}%' OR passenger_factor_num LIKE '%{$param['factorNumber']}%') ";
        }
        if (isset($param['statusGroup']) && $param['statusGroup'] == 'cancel') {
            $sql .= " AND status = 'book' AND request_cancel = 'confirm'  ";
        }elseif(isset($param['statusGroup']) && $param['statusGroup'] != '') {
            $sql .= " AND (status LIKE '%{$param['statusGroup']}%') ";
        }
        if (isset($param['passengerName']) && $param['passengerName'] != '') {
            $sql .= " AND ((concat(passenger_name,' ',passenger_family) LIKE '%{$param['passengerName']}%')  OR (concat(passenger_name,passenger_family) LIKE '%{$param['passengerName']}%'))";
        }
        $sql .= "
                GROUP BY passenger_factor_num 
                ORDER BY creation_date_int DESC ";
//        if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
//            var_dump($sql);
//            die();
//        }
        $Model = Load::library('Model');
        $bookList = $Model->select($sql);
        $result = [];
        foreach ($bookList as  $key => $item ){
            if ($item['status'] == 'book') {
                if ($item['request_cancel'] == 'confirm') {
                    $bookList[$key]['view_status'] = functions::Xmlinformation('Definitivereservation')->__toString().' <span style="color: #fd6767; margin-right: 10px; ">('. functions::Xmlinformation('Refunded')->__toString().')</span>';
                }else {
                    $bookList[$key]['view_status'] = functions::Xmlinformation('Definitivereservation')->__toString();
                }
            }elseif ($item['status'] == 'temporaryReservation') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Temporaryreservation')->__toString();
            } elseif ($item['status'] == 'prereserve') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Prereservation')->__toString();
            } elseif ($item['status'] == 'bank') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('NotPaid')->__toString();
            }elseif ($item['status'] == 'cancel') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Cancel')->__toString();
            }elseif ($item['status'] == 'nothing') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknown')->__toString();
            }else {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknown')->__toString();
            }
            $bookList[$key]['price_final'] = number_format(functions::calcDiscountCodeByFactor($item['total_price'], $item['passenger_factor_num']));
            $result[$key]['service'] = 'Bus';
            $result[$key]['title'] = functions::Xmlinformation('Bustype')->__toString() .' '. $item['OriginCity'] .' '. $item['DestinationCity'];
            $result[$key]['passenger_name'] = $item['passenger_name'] . ' ' . $item['passenger_family'];
            $result[$key]['date'] = $item['DateMove'];
            $result[$key]['time'] = $item['TimeMove'];
            $result[$key]['status'] = [
                'title' => $item['status'],
                'value' => $bookList[$key]['view_status']
            ];
            $result[$key]['factor_number'] = $item['passenger_factor_num'];
            $result[$key]['price'] = $bookList[$key]['price_final'];
            $result[$key]['info_list'] = [
                [
                    'title' => functions::Xmlinformation('Ticketnumber')->__toString() ,
                    'value' =>  $item['passenger_factor_num']
                ],
                [
                    'title' => functions::Xmlinformation('Passengercompany')->__toString() ,
                    'value' => $item['BaseCompany']
                ],
                [
                    'title' => functions::Xmlinformation('TypeCar')->__toString() ,
                    'value' => $item['CarType']
                ],
                [
                    'title' => functions::Xmlinformation('SeatNumber')->__toString() ,
                    'value' => $item['chairs']
                ],
                [
                    'title' => functions::Xmlinformation('Amount')->__toString() ,
                    'value' => $bookList[$key]['price_final']
                ],

            ];
            $result[$key]['button_list'] = [
                [
                    'title' => functions::Xmlinformation('Shownformation')->__toString() ,
                    'type' => 'button',
                    'function' => "modalTicketBusDetails(event.currentTarget ,".$item['passenger_factor_num']." , 'bus')",
                ],
            ];
            $bookList[$key]['dataBtnPdf'] = '';
            $bookList[$key]['ViewBill'] = '';
            $bookList[$key]['dataBtnCancel'] = '';
            if ($item['status'] == 'book') {
                $result[$key]['button_list'][] = [
                    'title' => functions::Xmlinformation('GetTicket')->__toString() ,
                    'type' => 'link',
                    'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingBusShow&id=' . $item['passenger_factor_num'],
                ];
                $result[$key]['button_list'][] = [
                    'title' => functions::Xmlinformation('Viewbill')->__toString(),
                    'type' => 'link',
                    'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=busBoxCheck&id=' . $item['passenger_factor_num'],
                ];

            }
            if ($item['status'] == 'book' && $item['request_cancel'] == 'confirm' ) {
                $result[$key]['button_list'][] =
                    [
                        'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                        'type' => 'link',
                        'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingBusShow&id=' . $item['passenger_factor_num'] .'&cancelStatus=confirm',
                    ];
            }
            else{
                $result[$key]['button_list'][] =
                    [
                        'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                        'type' => 'button' ,
                        'function' =>  "ModalCancelUserProfile(event.currentTarget ,'bus', ".$item['order_code'].")",

                    ];
            }


            if(CLIENT_ID == 271){
                $reservation_proof = Load::controller('reservationProof');
                $file = $reservation_proof->getProofFile($item['order_code'] , 'Bus');
                if($file && isset($file) && !empty($file)) {
                    $result[$key]['button_list'][] = [
                        'title' => functions::Xmlinformation('ViewProof')->__toString(),
                        'type' => 'button',
                        'function' =>  "modalForReservationProofVersa(event.currentTarget ,".$item['order_code'].", 'Bus')",
                    ];
                }
            }else {
                $bookList[$key]['reservationProofVersa'] = '';
            }
        }
        return $result;
    }

    public function getBookAllTrain($param = '') {
        $id = Session::getUserId();
        $Model = Load::library('Model');
        $train = Load::controller('bookingTrain');
        $sql = "SELECT   
                    passenger_name,
                    passenger_family,
                    creation_date_int,
                    ExitDate,
                    ExitTime,
                    successfull,
                    requestNumber,
                    factor_number,
                    CompanyName,
                    WagonName,
                    Departure_City,
                    Arrival_City,
                    TrainNumber,
                    TicketNumber
                 FROM book_train_tb 
                 WHERE 
                    member_id='{$id}' ";

        if (!empty($param['startDate']) && !empty($param['endDate'])) {

            $date_of = explode('-', $_POST['startDate']);
            $date_to = explode('-', $_POST['endDate']);
            if(SOFTWARE_LANG == 'fa'){
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }else{
                $date_of_int = mktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = mktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        }
        if (isset($param['factorNumber']) && $param['factorNumber'] != '') {
            $sql .= " AND (factor_number LIKE '%{$param['factorNumber']}%' OR requestNumber LIKE '%{$param['factorNumber']}%') ";
        }
        if (isset($param['statusGroup']) && $param['statusGroup'] != '') {
            $sql .= " AND (successfull LIKE '%{$param['statusGroup']}%') ";
        }
        if (isset($param['passengerName']) && $param['passengerName'] != '') {
            $sql .= " AND ((concat(passenger_name,' ',passenger_family) LIKE '%{$param['passengerName']}%')  OR (concat(passenger_name,passenger_family) LIKE '%{$param['passengerName']}%'))";
        }
        $sql .= "GROUP BY requestNumber,TrainNumber
                ORDER BY creation_date_int DESC ";
        $bookList = $Model->select($sql);
        $result = [];
        foreach ($bookList as  $key => $item ){
            if ($item['ExitDate'] != '') {
                $bookList[$key]['ExitDate'] = functions::printDateIntByLanguage('Y/m/d', strtotime($item['ExitDate']),SOFTWARE_LANG);
            } else {
                $bookList[$key]['ExitDate'] = '----';
            }
            if ($item['ExitTime'] != '') {
                $bookList[$key]['ExitTime'] = functions::format_hour($item['ExitTime']);
            } else {
                $bookList[$key]['ExitTime'] = '----';
            }

            if ($item['successfull'] == 'nothing') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknow')->__toString();
            } elseif ($item['successfull'] == 'prereserve') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Prereservation')->__toString();
            } elseif ($item['successfull'] == 'bank') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('RedirectPayment')->__toString();
            } elseif ($item['successfull'] == 'book') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Definitivereservation')->__toString();
            } elseif ($item['successfull'] == 'credit') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Paycredit')->__toString();
            } elseif ($item['successfull'] == 'error') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('ErrorPayment')->__toString();
            }
            $bookList[$key]['price_final'] =  number_format($train->TotalPriceByRequestNumber($item['requestNumber'],$item['successfull']));

            $result[$key]['service'] = 'Train';
            $result[$key]['title'] = functions::Xmlinformation('S360Train')->__toString() .' '. $item['Departure_City'] .' '. $item['Arrival_City'];
            $result[$key]['passenger_name'] = $item['passenger_name'] . ' ' . $item['passenger_family'];
            $result[$key]['date'] = $item['ExitDate'];
            $result[$key]['time'] = $item['ExitTime'];
            $result[$key]['status'] = [
                'title' => $item['successfull'],
                'value' => $bookList[$key]['view_status'],
            ];
            $result[$key]['factor_number'] = $item['factor_number'];
            $result[$key]['price'] = $bookList[$key]['price_final'];

            $result[$key]['info_list'] = [
                [
                    'title' => functions::Xmlinformation('Ticketnumber')->__toString(),
                    'value' => $item['TicketNumber']
                ],
                [
                    'title' => functions::Xmlinformation('Namepassenger')->__toString(),
                    'value' => $item['passenger_name'] .' '. $item['passenger_family']
                ],
                [
                    'title' => functions::Xmlinformation('TrainName')->__toString(),
                    'value' => $item['CompanyName']
                ],
                [
                    'title' => functions::Xmlinformation('TrainNumber')->__toString(),
                    'value' => $item['TrainNumber']
                ],
                [
                    'title' => functions::Xmlinformation('Hall')->__toString(),
                    'value' => $item['WagonName']
                ],
            ];

            $result[$key]['button_list'] = [
                [
                    'title' => functions::Xmlinformation('Shownformation')->__toString(),
                    'type' => 'link',
                    'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=trainBooking&id=' . $item['requestNumber']
                ],
            ];
            $bookList[$key]['dataBtnPdf'] = '';
            $bookList[$key]['dataBtnCancel'] = '';
            if ($item['successfull'] == 'book') {
                $result[$key]['button_list'][] = [
                    'title' => functions::Xmlinformation('ViewTickets')->__toString(),
                    'type' => 'link',
                    'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=trainBooking&id=' . $item['requestNumber']
                ];
                $result[$key]['button_list'][] = [
                    'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                    'type' => 'link',
                    'link' => 'https://refund.raja.ir'
                ];
            }
        }

        return $result;
    }

    public function getBookAllGashttransfer($param = '') {
        $id = Session::getUserId();
        $Model = Load::library('Model');
        $sql = "SELECT
                    member_id,
                    passenger_name,
                    passenger_family,
                    creation_date_int,
                    passenger_factor_num,
                    status,
                    passenger_serviceName,
                    passenger_serviceCityName,
                    passenger_number
                FROM book_gasht_local_tb WHERE member_id='{$id}' ";
        if (!empty($param['startDate']) && !empty($param['endDate'])) {

            $date_of = explode('-', $_POST['startDate']);
            $date_to = explode('-', $_POST['endDate']);
            if(SOFTWARE_LANG == 'fa'){
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }else{
                $date_of_int = mktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = mktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        }
        if (isset($param['factorNumber']) && $param['factorNumber'] != '') {
            $sql .= " AND passenger_factor_num LIKE '%{$param['factorNumber']}%' ";
        }
        if (isset($param['statusGroup']) && $param['statusGroup'] != '') {
            $sql .= " AND (status LIKE '%{$param['statusGroup']}%') ";
        }
        if (isset($param['passengerName']) && $param['passengerName'] != '') {
            $sql .= " AND ((concat(passenger_name,' ',passenger_family) LIKE '%{$param['passengerName']}%')  OR (concat(passenger_name,passenger_family) LIKE '%{$param['passengerName']}%'))";
        }
        $sql .= "
                GROUP BY passenger_factor_num 
                ORDER BY creation_date_int DESC ";
        $bookList = $Model->select($sql);
        $result = [];
        foreach ($bookList as  $key => $item ){

            if ($item['passenger_serviceRequestType'] == '0') {
                $bookList[$key]['typeService'] =  functions::Xmlinformation('Gasht')->__toString();
            } else {
                $bookList[$key]['typeService'] =  functions::Xmlinformation('Transfer')->__toString();
            }
            $bookList[$key]['price_final'] =  number_format($item['passenger_number'] * $item['passenger_servicePriceAfterOff']);
            if ($item['creation_date_int'] != '') {
                $bookList[$key]['creation_date_int'] =  functions::printDateIntByLanguage('Y/m/d', $item['creation_date_int'],SOFTWARE_LANG);
                $bookList[$key]['creation_time_int'] =  functions::printDateIntByLanguage('H:i:s', $item['creation_date_int'],SOFTWARE_LANG);
            } else {
                $bookList[$key]['creation_date_int'] =  '----';
                $bookList[$key]['creation_time_int'] =  '----';
            }

            if ($item['status'] == 'prereserve') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Prereservation')->__toString();
            } elseif ($item['status'] == 'bank') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('RedirectPayment')->__toString();
            } elseif ($item['status'] == 'book') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Definitivereservation')->__toString();
            } elseif ($item['status'] == 'cancel') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Cancel')->__toString();
            } else {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknow')->__toString();
            }

            $result[$key]['service'] = 'Gashttransfer';
            $result[$key]['title'] = $bookList[$key]['typeService'] . ' ' . $item['passenger_serviceName'] . ' ' . $item['passenger_serviceCityName'];
            $result[$key]['passenger_name'] = $item['passenger_name'] . ' ' . $item['passenger_family'];
            $result[$key]['date'] = $bookList[$key]['creation_date_int'];
            $result[$key]['time']  = $bookList[$key]['creation_time_int'];
            $result[$key]['status'] = [
                'title' => $item['status'],
                'value' => $bookList[$key]['view_status']
            ];
            $result[$key]['factor_number'] = $item['passenger_factor_num'];
            $result[$key]['price'] = $bookList[$key]['price_final'];
            $result[$key]['info_list'] = [
                [
                    'title' => functions::Xmlinformation('Servicetype')->__toString() .' / '. functions::Xmlinformation('Servicename')->__toString(),
                    'value' => $item['passenger_serviceName'],
                ],
                [
                    'title' => functions::Xmlinformation('Destination')->__toString(),
                    'value' => $item['passenger_serviceCityName'],
                ],
                [
                    'title' => functions::Xmlinformation('Namepassenger')->__toString(),
                    'value' => $item['passenger_name'] . ' ' .  $item['passenger_family'],
                ],
                [
                    'title' => functions::Xmlinformation('Countpeople')->__toString(),
                    'value' => $item['passenger_number'],
                ]
            ];


            $result[$key]['button_list'] = [
                [
                    'title' => functions::Xmlinformation('Seebookingpatrolstransfers')->__toString(),
                    'type' => 'button',
                    'function' => "modalListGashtTransfer(event.currentTarget , " . $item['passenger_factor_num'] . " , 'gashttransfer')",
                ]
            ];
            $bookList[$key]['dataBtnCancel'] = '';
            if ($item['status'] == 'book') {
                $result[$key]['button_list'][] = [
                    'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                    'type' => 'button',
                    'function' => "ModalCancelItemProfile(event.currentTarget , 'gashttransfer' , " . $item['passenger_factor_num'] . ")",
                ];
            }
        }
        return $result;
    }

    public function getBookAllTour($param = '') {
        $Model = Load::library('Model');
        $id = Session::getUserId();
        $sql = "SELECT   
                    passenger_name,
                    passenger_family,
                    member_id,
                    creation_date_int,
                    factor_number,
                    status,
                    tour_name,
                    tour_type,
                    total_price,
                    tour_night,
                    tour_day,
                    tour_id,
                    tour_origin_country_name,
                    tour_origin_city_name,
                    tour_origin_region_name,
                    tour_start_date,
                    tour_cities,
                    passengers_file_tour
                 FROM book_tour_local_tb 
                 WHERE 
                    member_id='{$id}' ";
        if (!empty($param['startDate']) && !empty($param['endDate'])) {

            $date_of = explode('-', $_POST['startDate']);
            $date_to = explode('-', $_POST['endDate']);
            if(SOFTWARE_LANG == 'fa'){
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }else{
                $date_of_int = mktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = mktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        }
        if (isset($param['factorNumber']) && $param['factorNumber'] != '') {
            $sql .= " AND factor_number LIKE '%{$param['factorNumber']}%' ";
        }
        if (isset($param['statusGroup']) && $param['statusGroup'] != '') {
            $sql .= " AND (status LIKE '%{$param['statusGroup']}%') ";
        }
        if (isset($param['passengerName']) && $param['passengerName'] != '') {
            $sql .= " AND ((concat(passenger_name,' ',passenger_family) LIKE '%{$param['passengerName']}%')  OR (concat(passenger_name,passenger_family) LIKE '%{$param['passengerName']}%'))";
        }
        $sql .= "
                GROUP BY factor_number 
                ORDER BY creation_date_int DESC ";
        $bookList = $Model->select($sql);
        $result = [];
        foreach ($bookList as $key => $item) {
            if ($item['tour_type'] != '') {
                $bookList[$key]['tour_type'] = $item['tour_type'];
            } else {
                $bookList[$key]['tour_type'] = '';
            }
            $bookList[$key]['price_final'] = number_format(functions::calcDiscountCodeByFactor($item['total_price'], $item['factor_number']));
            if ($item['tour_night'] > 0) {
                $bookList[$key]['tour_night'] = $item['tour_night'] .' '. functions::Xmlinformation('Night');
            } else {
                $bookList[$key]['tour_night'] = '';
            }
            if ($item['tour_day'] > 0) {
                $bookList[$key]['tour_day'] = $item['tour_day'] .' '. functions::Xmlinformation('Day');
            } else {
                $bookList[$key]['tour_day'] = '';
            }
            if ($item['creation_date_int'] != '') {
                $bookList[$key]['creation_date_int'] = functions::printDateIntByLanguage('Y/m/d',$item['creation_date_int'],SOFTWARE_LANG);
                $bookList[$key]['creation_time_int'] = functions::printDateIntByLanguage('H:i',$item['creation_date_int'],SOFTWARE_LANG);
            } else {
                $bookList[$key]['creation_date_int'] = '----';
                $bookList[$key]['creation_time_int'] = '----';
            }
            $is_request=false;
            $tour_reservation_controller=Load::controller('reservationTour');
            $tourDetail=$tour_reservation_controller->infoTourById($item['tour_id']);
            if($tourDetail['is_request'] =='1')
                $is_request=true;

            if ($is_request && $item['status'] == 'Requested') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Requested')->__toString();
            }
            elseif  ($is_request && $item['status'] == 'RequestRejected') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('RequestRejected')->__toString();
            }
            elseif  ($is_request && $item['status'] == 'RequestAccepted') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('RequestAccepted')->__toString();
            }
            elseif ($item['status'] == 'BookedSuccessfully') {
                $bookList[$key]['view_status'] = functions::Xmlinformation('Definitivereservation')->__toString();
            } elseif ($item['status'] == 'TemporaryReservation') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Temporaryreservation')->__toString().' '. functions::Xmlinformation('Paymentprebookingamount')->__toString();
            } elseif ($item['status'] == 'PreReserve') {
                $bookList[$key]['view_status'] =  '<span>'.functions::Xmlinformation('Temporaryreservation')->__toString().' '.functions::Xmlinformation('Paymentprebookingamount')->__toString().'</span>' .
                    ' <a class="receive-tickets-btn mr-2" target="_blank" href="' . ROOT_ADDRESS . '/UserTracking&type=tour&id=' . $item['factor_number'] . '">'.functions::Xmlinformation('paymentUser')->__toString().'</a>'
                ;
            } elseif ($item['status'] == 'TemporaryPreReserve') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Temporaryprebooking')->__toString();
            } elseif ($item['status'] == 'bank') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('RedirectPayment')->__toString();
            } elseif ($item['status'] == 'CancellationRequest') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Cancelrequestpassenger')->__toString();
            } elseif ($item['status'] == 'Cancellation') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Cancellation')->__toString() . '<span style="border: 1px dashed #d1d1d1; ">' . $item['cancellation_comment'] .'</span>';
            } else {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknow')->__toString();
            }
            if ($item['tour_start_date'] != '') {
                $bookList[$key]['enter_date'] =  functions::printDateIntByLanguage('Y-m-d',functions::convertJalaliDateToGregInt($item['tour_start_date']),SOFTWARE_LANG);
            } else {
                $bookList[$key]['enter_date'] = '----';
            }

            $result[$key]['service'] = 'Tour';
            $result[$key]['title'] = functions::Xmlinformation('Tour')->__toString() . ' ' . $item['tour_name'];
            $result[$key]['passenger_name'] = $item['passenger_name'] . ' ' . $item['passenger_family'];
            $result[$key]['tour_type'] = $bookList[$key]['tour_type'];
            $result[$key]['date'] = $bookList[$key]['creation_date_int'];
            $result[$key]['time'] = $bookList[$key]['creation_time_int'];
            $result[$key]['status'] = [
                'title' => $item['status'],
                'value' => $bookList[$key]['view_status']
            ];
            $result[$key]['factor_number'] = $item['factor_number'];
            $result[$key]['price'] = $bookList[$key]['price_final'];
            $result[$key]['info_list'] = [
                [
                    'title' => functions::Xmlinformation('Periodoftime')->__toString(),
                    'value' => $bookList[$key]['tour_night'] . ' ' .  $bookList[$key]['tour_day'],
                ],
                [
                    'title' => functions::Xmlinformation('Origin')->__toString(),
                    'value' => $item['tour_origin_country_name'] . ' ' . $item['tour_origin_city_name'] .' '. $item['tour_origin_region_name'],
                ],
                [
                    'title' => functions::Xmlinformation('Destination')->__toString(),
                    'value' => $item['tour_cities'],
                ],
                [
                    'title' => functions::Xmlinformation('Enterdate')->__toString(),
                    'value' => $bookList[$key]['enter_date'],
                ],
            ];

            $bookList[$key]['ViewDetails'] = '';
            $bookList[$key]['dataBtnPdf'] = '';
            $bookList[$key]['dataBtnCancel'] = '';
            $result[$key]['button_list'] = [
                [
                    'title' => functions::Xmlinformation('ShowReservation')->__toString(),
                    'type' => 'button',
                    'function' => "modalTourDetails(event.currentTarget , '".$item['factor_number']."' , 'tour')",
                ],
            ];
            if ($item['status'] == 'BookedSuccessfully') {
                $file_list = [] ;
                if ($item['passengers_file_tour'] != '') {
                    $array_file = json_decode($item['passengers_file_tour']);
                    $num = 0;
                    foreach ($array_file as $k => $file) {
                        $num = $num+1;
                        $file_list[$k] = [
                            'title' => functions::Xmlinformation('file')->__toString(). ' '.$num,
                            'type' => 'link',
                            'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pic/reservationTour/passengersImages/' . $file
                        ];

                    }
                }

                $result[$key]['button_list'][] = [
                    'title' => functions::Xmlinformation('Shownformation')->__toString(),
                    'type' => 'link',
                    'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=BookingTourLocal&id=' . $item['factor_number'],
                ];
                $result[$key]['button_list'][] = [
                    'title' => functions::Xmlinformation('Pdff')->__toString(),
                    'type' => 'link',
                    'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=BookingTourLocal&id=' . $item['factor_number']
                ];
                $result[$key]['button_list'][] = [
                    'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                    'type' => 'button',
                    'function' => "ModalCancelItemProfile(event.currentTarget ,'tour' , ".$item['factor_number'].")",
                ];
                $result[$key]['button_list'][] = [
                    'title' =>  functions::Xmlinformation('FilesTour')->__toString(),
                    'type' => 'file_list',
                    'file_list' => $file_list,
                ];

            }
            $bookList[$key]['enter_date'] =  functions::printDateIntByLanguage('Y/m/d',functions::convertJalaliDateToGregInt($item['tour_start_date']),SOFTWARE_LANG);
        }
        return $result;
    }

    public function getBookAllHotel($param = '') {
        $Model = Load::library('Model');
        $obj_user = Load::controller('user');
        $id = Session::getUserId();
        $sql = "SELECT   
                    passenger_name,
                    passenger_family,
                    member_id,
                    creation_date_int,
                    factor_number,
                    status,
                    total_price,
                    isInternal,
                    hotel_name,
                    city_name,
                    start_date,
                    request_cancel,
                    type_application,
                    passenger_leader_room_fullName,
                    number_night
                 FROM book_hotel_local_tb 
                 WHERE 
                    member_id='{$id}' ";
        if (!empty($param['startDate']) && !empty($param['endDate'])) {

            $date_of = explode('-', $_POST['startDate']);
            $date_to = explode('-', $_POST['endDate']);
            if(SOFTWARE_LANG == 'fa'){
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }else{
                $date_of_int = mktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = mktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        }
        if (isset($param['factorNumber']) && $param['factorNumber'] != '') {
            $sql .= " AND (factor_number LIKE '%{$param['factorNumber']}%') ";
        }
        if (isset($param['statusGroup']) && $param['statusGroup'] == 'cancel') {
            $sql .= " AND status = 'BookedSuccessfully' AND request_cancel = 'confirm'  ";
        }elseif(isset($param['statusGroup']) && $param['statusGroup'] != '') {
            $sql .= " AND (status LIKE '%{$param['statusGroup']}%') ";
        }
        if (isset($param['passengerName']) && $param['passengerName'] != '') {
            $sql .= " AND ((concat(passenger_name,' ',passenger_family) LIKE '%{$param['passengerName']}%')  OR (concat(passenger_name,passenger_family) LIKE '%{$param['passengerName']}%'))";
        }
        $sql .= "
                GROUP BY factor_number 
                ORDER BY creation_date_int DESC ";
//        echo $sql;
        $bookList = $Model->select($sql);
        $result = [] ;

        foreach ($bookList as  $key => $item ){
            if ($item['creation_date_int'] != '') {
                $bookList[$key]['creation_date_int'] = functions::printDateIntByLanguage('Y/m/d',$item['creation_date_int'],SOFTWARE_LANG);
                $bookList[$key]['creation_time_int'] = functions::printDateIntByLanguage('H:i',$item['creation_date_int'],SOFTWARE_LANG);
            } else {
                $bookList[$key]['creation_date_int'] = '----';
                $bookList[$key]['creation_time_int'] = '----';
            }
            $bookList[$key]['price_final'] = number_format(functions::calcDiscountCodeByFactor($item['total_price'], $item['factor_number']));
            if ($item['status'] == 'BookedSuccessfully') {
                if ($item['request_cancel'] == 'confirm') {
                    $bookList[$key]['view_status'] = functions::Xmlinformation('Definitivereservation')->__toString().' <span style="color: #fd6767; margin-right: 10px; ">('. functions::Xmlinformation('Refunded')->__toString().')</span>';
                }else {
                    $bookList[$key]['view_status'] = functions::Xmlinformation('Definitivereservation')->__toString();
                }
            } elseif ($item['status'] == 'bank') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('RedirectPayment')->__toString();
            } elseif ($item['status'] == 'PreReserve') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Prereservation')->__toString();
            }elseif ($item['status'] == 'OnRequest') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('OnRequestedHotel')->__toString();
            } elseif ($item['status'] == 'Cancelled') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Cancel')->__toString();
            } elseif ($item['status'] == 'pending') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('pendingPrintFlight')->__toString();
            } elseif ($item['status'] == 'Requested') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('PrepaidData')->__toString()."<br>".functions::Xmlinformation('WaitingForAccepted')->__toString();
            }elseif ($item['status'] == 'RequestRejected') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('ManagerDisapproval')->__toString();
            }elseif ($item['status'] == 'RequestAccepted') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('ContinuePay')->__toString();
            }

            else {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknow')->__toString();
            }
            if ($item['start_date'] != '') {
                $bookList[$key]['enter_date'] = functions::printDateIntByLanguage('Y/m/d',functions::convertJalaliDateToGregInt($item['start_date']),SOFTWARE_LANG);
            } else {
                $bookList[$key]['enter_date'] = '----';
            }

            $result[$key]['service'] = 'Hotel';
            $result[$key]['title'] = functions::Xmlinformation('Hotel')->__toString() .' '. $item['hotel_name'] . ' ' . $item['city_name'];
            $result[$key]['passenger_name'] = $item['passenger_name'] . ' ' . $item['passenger_family'];
            $result[$key]['date'] = $bookList[$key]['creation_date_int'];
            $result[$key]['time'] = $bookList[$key]['creation_time_int'];
            $result[$key]['status'] = [
                'title' => $item['status'],
                'value' => $bookList[$key]['view_status']
            ];
            $result[$key]['factor_number'] = $item['factor_number'];
            $result[$key]['price'] = $bookList[$key]['price_final'];
            $result[$key]['info_list'] = [
                [
                    'title' => functions::Xmlinformation('Buydate')->__toString() ,
                    'value' => $bookList[$key]['creation_date_int'] . ' ' . $bookList[$key]['creation_time_int']
                ],
                [
                    'title' => functions::Xmlinformation('Enterdate')->__toString() ,
                    'value' => $bookList[$key]['enter_date']
                ],
                [
                    'title' => functions::Xmlinformation('Stayigtime')->__toString() ,
                    'value' => $item['number_night'] . ' ' . functions::Xmlinformation('Night')->__toString() ,
                ],
                [
                    'title' => functions::Xmlinformation('Amount')->__toString() ,
                    'value' => $bookList[$key]['price_final']
                ],
            ];
            $bookList[$key]['notInternal'] = '';
            $bookList[$key]['isInternal'] = '';
            $bookList[$key]['edit_hotel'] = '';
            $bookList[$key]['dataBtnCancel'] = '';
            $bookList[$key]['reservationProofVersa'] = '';
            if ($item['status'] == 'BookedSuccessfully') {
                if(CLIENT_ID == 317) {
                    $bookList[$key]['pdfHotel'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&lang=en&target=bookNewhotelshow&id=' . $item['factor_number'];
                }else{
                    if ($item['isInternal'] != 0) {
//                        $bookList[$key]['pdfHotel'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=BookingHotelNew&id=' . $item['factor_number'];
                        $bookList[$key]['pdfHotel'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&lang=en&target=bookNewhotelshow&id=' . $item['factor_number'];

                    }else {
                        $bookList[$key]['pdfHotel']  = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookhotelshow&id=' . $item['factor_number'];
                    }
                }
            }

            $result[$key]['button_list'] = [
                [
                    'title' => functions::Xmlinformation('Shownformation')->__toString(),
                    'type' => 'button',
                    'function' => "modalListForHotelDetails(event.currentTarget ,".$item['factor_number']." , 'hotel')",
                ],
            ];
            if ($item['status'] == 'RequestAccepted' ){
                $result[$key]['button_list'][] =
                    [
                        'title' => functions::Xmlinformation('ConfirmLoginBank')->__toString(),
                        'type' => 'link',
                        'link' => ROOT_ADDRESS_WITHOUT_LANG . '/fa/UserTracking&type=hotel&id=' . $item['factor_number']
                    ];
            }
            if ($item['status'] == 'BookedSuccessfully'  ) {
                $result[$key]['button_list'][] =
                    [
                        'title' => functions::Xmlinformation('Pdff')->__toString(),
                        'type' => 'link',
                        'link' => $bookList[$key]['pdfHotel']
                    ];
            }
            if ($item['status'] == 'BookedSuccessfully' && $item['request_cancel'] == 'confirm' ) {
                $result[$key]['button_list'][] =
                    [
                        'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                        'type' => 'link',
                        'link' => ROOT_ADDRESS_WITHOUT_LANG . '/gds/pdf&target=BookingHotelLocal&id=' . $item['factor_number'] .'&cancelStatus=confirm',
                    ];
            }else{
                if ($item['status'] != 'Requested' && $item['status'] != 'RequestRejected' && $item['status'] != 'RequestAccepted') {
                    $result[$key]['button_list'][] =
                        [
                            'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                            'type' => 'button',
                            'function' => "ModalCancelItemProfile(event.currentTarget , 'hotel' , " . $item['factor_number'] . ")",
                        ];
                }
            }
            if(CLIENT_ID == 271){
                $reservation_proof = Load::controller('reservationProof');
                $file = $reservation_proof->getProofFile($item['factor_number'] , 'Hotel');

                if($file && isset($file) && !empty($file)) {
                    $result[$key]['button_list'][] = [
                        'title' => functions::Xmlinformation('ViewProof')->__toString(),
                        'type' => 'button' ,
                        'function'  => "modalForReservationProofVersa(event.currentTarget , ".$item['factor_number'].", 'hotel')" ,
                    ];
                }
            }
            if ($item['type_application'] == 'reservation' && $obj_user->checkForEdit($item['status'], $item['start_date']) == 'true') {
                $result[$key]['button_list'][] = [
                    'title' => functions::Xmlinformation('Editbookings')->__toString(),
                    'type' => 'link' ,
                    'link' => ROOT_ADDRESS . '/editReserveHotel&id=' . $item['factor_number']
                ];
            }
        }
        return $result;
    }

    public function getBookAllInsurance($param = '') {
        $Model = Load::library('Model');
        $obj_user = Load::controller('user');
        $id = Session::getUserId();
        $sql = "SELECT   
                    passenger_name,
                    passenger_family,
                    member_id,
                    creation_date_int,
                    factor_number,
                    status,
                    source_name_fa,
                    destination,
                    caption,
                    source_name_fa
                 FROM book_insurance_tb 
                 WHERE 
                    member_id='{$id}' ";
        if (!empty($param['startDate']) && !empty($param['endDate'])) {

            $date_of = explode('-', $_POST['startDate']);
            $date_to = explode('-', $_POST['endDate']);
            if(SOFTWARE_LANG == 'fa'){
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }else{
                $date_of_int = mktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = mktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        }
        if (isset($param['factorNumber']) && $param['factorNumber'] != '') {
            $sql .= " AND (factor_number LIKE '%{$param['factorNumber']}%') ";
        }
        if (isset($param['statusGroup']) && $param['statusGroup'] != '') {
            $sql .= " AND (status LIKE '%{$param['statusGroup']}%') ";
        }
        if (isset($param['passengerName']) && $param['passengerName'] != '') {
            $sql .= " AND ((concat(passenger_name,' ',passenger_family) LIKE '%{$param['passengerName']}%')  OR (concat(passenger_name,passenger_family) LIKE '%{$param['passengerName']}%'))";
        }
        $sql .= "
                GROUP BY factor_number 
                ORDER BY creation_date_int DESC ";
        $bookList = $Model->select($sql);
        $result = [];
        foreach ($bookList as $key => $item) {
            $bookList[$key]['view_caption']  = '';
            if ($item['caption'] != '') {
                $bookList[$key]['view_caption'] = ' ( '.$item['caption'].' ) ';
            }else{
                $bookList[$key]['view_caption'] = '';
            }
            if ($item['creation_date_int'] != '') {
                $bookList[$key]['creation_date_int'] = functions::printDateIntByLanguage('Y/m/d',$item['creation_date_int'],SOFTWARE_LANG);
                $bookList[$key]['creation_time_int'] = functions::printDateIntByLanguage('H:i',$item['creation_date_int'],SOFTWARE_LANG);
            } else {
                $bookList[$key]['creation_date_int'] = '----';
                $bookList[$key]['creation_time_int'] = '----';
            }
            if ($item['status'] == 'book') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Definitivereservation')->__toString();

            } elseif ($item['status'] == 'bank') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('RedirectPayment')->__toString();
            } elseif ($item['status'] == 'prereserve') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Prereservation')->__toString();
            } elseif ($item['status'] == 'cancel') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Cancel')->__toString();
            } else {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknow')->__toString();
            }
            $bookList[$key]['price_final'] =  number_format(functions::calcDiscountCodeByFactor($obj_user->total_price_insurance($item['factor_number']), $item['factor_number']));
            $bookList[$key]['factor_number'] = $obj_user->showBuyInsurance($item['factor_number']);

            $result[$key]['service'] = 'Insurance';
            $result[$key]['title'] = $item['source_name_fa'] . ' ' . $item['destination'] . ' ' . $item['view_caption'];
            $result[$key]['passenger_name'] = $item['passenger_name'] . ' ' . $item['passenger_family'];
            $result[$key]['date'] = $bookList[$key]['creation_date_int'];
            $result[$key]['time'] = $bookList[$key]['creation_time_int'];
            $result[$key]['status'] = [
                'title' => $item['status'],
                'value' => $bookList[$key]['view_status']
            ];
            $result[$key]['factor_number'] =  $bookList[$key]['factor_number'];
            $result[$key]['price'] = $bookList[$key]['price_final'];
            $result[$key]['info_list'] = [
                [
                    'title' => functions::Xmlinformation('Customername')->__toString(),
                    'value' => $bookList[$key]['factor_number']
                ],
                [
                    'title' => functions::Xmlinformation('Buydate')->__toString(),
                    'value' => $result[$key]['date'] . ' ' . $result[$key]['time']
                ],
                [
                    'title' => functions::Xmlinformation('Amount')->__toString(),
                    'value' => $bookList[$key]['price_final']
                ],
            ];

            $bookList[$key]['btnDetails'] = '';
            $bookList[$key]['dataBtnCancel'] = '';
            $bookList[$key]['reservationProofVersa'] = '';
            if ($item['status'] == 'book') {
                $result[$key]['button_list'] = [
                    [
                        'title' => functions::Xmlinformation('ShowReservation')->__toString(),
                        'type' => 'button',
                        'function' => "modalListInsuranceProfile(event.currentTarget ,".$item['factor_number'].")"
                    ],
                    [
                        'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                        'type' => 'button',
                        'function' => "ModalCancelItemProfile(event.currentTarget ,'insurance' , ".$item['factor_number'].")"
                    ]
                ];
            }
            if(CLIENT_ID == 271){
                $reservation_proof = Load::controller('reservationProof');
                $file = $reservation_proof->getProofFile($item['factor_number'] , 'Insurance');

                if($file && isset($file) && !empty($file)) {
                    $result[$key]['button_list'][] = [
                        'title' => functions::Xmlinformation('ViewProof')->__toString(),
                        'type' => 'button',
                        'function' => "modalForReservationProofVersa(event.currentTarget ,".$item['factor_number']." , 'Insurance')"
                    ];
                }
            }
        }
        return $result;
    }

    public function getBookAllVisa($param = '') {
        $Model = Load::library('Model');
        $id = Session::getUserId();
        $sql = "SELECT  
                    passenger_name,
                    passenger_family,
                    member_id,
                    creation_date_int,
                    factor_number,
                    total_price,
                    status,
                    visa_request_status_id,
                    visa_destination,
                    visa_title,
                    visa_type,
                   (SELECT documents FROM visa_type_tb AS visaType WHERE visaType.title = visa_type) AS documents_visa
                FROM book_visa_tb 
                WHERE member_id='{$id}' ";
        if (!empty($param['startDate']) && !empty($param['endDate'])) {

            $date_of = explode('-', $_POST['startDate']);
            $date_to = explode('-', $_POST['endDate']);
            if(SOFTWARE_LANG == 'fa'){
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }else{
                $date_of_int = mktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = mktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        }
        if (isset($param['factorNumber']) && $param['factorNumber'] != '') {
            $sql .= " AND factor_number LIKE '%{$param['factorNumber']}%' ";
        }
        if (isset($param['statusGroup']) && $param['statusGroup'] != '') {
            $sql .= " AND (status LIKE '%{$param['statusGroup']}%') ";
        }
        if (isset($param['passengerName']) && $param['passengerName'] != '') {
            $sql .= " AND ((concat(passenger_name,' ',passenger_family) LIKE '%{$param['passengerName']}%')  OR (concat(passenger_name,passenger_family) LIKE '%{$param['passengerName']}%'))";
        }
        $sql .= "
                GROUP BY factor_number 
                ORDER BY creation_date_int DESC ";
        $bookList = $Model->select($sql);
        /** @var visaRequestStatus $visaRequestStatus */
        $visaRequestStatus = Load::controller('visaRequestStatus');

        $result = [];
        foreach ($bookList as $key => $item) {
            if ($item['creation_date_int'] != '') {
                $bookList[$key]['creation_date_int'] = functions::printDateIntByLanguage('Y/m/d',$item['creation_date_int'],SOFTWARE_LANG);
                $bookList[$key]['creation_time_int'] = functions::printDateIntByLanguage('H:i',$item['creation_date_int'],SOFTWARE_LANG);
            } else {
                $bookList[$key]['creation_date_int'] = '----';
                $bookList[$key]['creation_time_int'] = '----';
            }
            $bookList[$key]['price_final'] = number_format(functions::calcDiscountCodeByFactor($item['total_price'], $item['factor_number']));

            if ($item['status'] == 'prereserve') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Prereservation')->__toString();
            } elseif ($item['status'] == 'bank') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('RedirectPayment')->__toString();
            } elseif ($item['status'] == 'book') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Definitivereservation')->__toString();
            } elseif ($item['status'] == 'cancel') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Cancel')->__toString();
            } else {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknow')->__toString();
            }

            $bookList[$key]['process_status'] = '';
            if($item['status'] == 'book'){
                if (isset($visaRequestStatus->getSingle($item['visa_request_status_id'])['title'])) {
                    $bookList[$key]['process_status'] = " ". $visaRequestStatus->getSingle($item['visa_request_status_id'])['title'] ;
                }else {
                    $bookList[$key]['process_status'] = " ". functions::Xmlinformation('NotSpecified')->__toString();
                }
            }
            if ($item['visa_destination'] != '') {
                $bookList[$key]['visa_destination'] = $item['visa_destination'];
            } else {
                $bookList[$key]['visa_destination'] = '----';
            }

            $result[$key]['service'] = 'Visa';
            $result[$key]['title'] = $item['visa_title'];
            $result[$key]['passenger_name'] = $item['passenger_name'] .' '. $item['passenger_family'];
            $result[$key]['date'] = $bookList[$key]['creation_date_int'];
            $result[$key]['time'] = $bookList[$key]['creation_time_int'];
            $result[$key]['status'] = [
                'title'  => $item['status'] ,
                'value'  => $bookList[$key]['view_status'] . ' ' . $bookList[$key]['process_status']
            ];
            $result[$key]['factor_number'] = $item['factor_number'];
            $result[$key]['price'] = $bookList[$key]['price_final'];
            $result[$key]['info_list'] = [
                [
                    'title' => functions::Xmlinformation('Typevisa')->__toString(),
                    'value' => $item['visa_type']
                ],
                [
                    'title' => functions::Xmlinformation('Destination')->__toString(),
                    'value' => $bookList[$key]['visa_destination']
                ],
                [
                    'title' => functions::Xmlinformation('Namepassenger')->__toString(),
                    'value' => $item['passenger_name'] . ' ' . $item['passenger_family']
                ],
                [
                    'title' => functions::Xmlinformation('Buydate')->__toString(),
                    'value' => $bookList[$key]['creation_date_int'] . ' ' . $bookList[$key]['creation_time_int']
                ],
                [
                    'title' => functions::Xmlinformation('Amount')->__toString(),
                    'value' => $bookList[$key]['price_final']
                ],
            ];

            $bookList[$key]['dataBtnCancel'] = '';
            $result[$key]['button_list'] = [
                [
                    'title' => functions::Xmlinformation('ShowReservation')->__toString() . ' ' . functions::Xmlinformation('Visa')->__toString(),
                    'type' => 'button',
                    'function' => "modalListForVisaDetails(event.currentTarget ,".$item['factor_number'].")"
                ]
            ];
            if ($item['status'] == 'book') {
                $result[$key]['button_list'][] = [
                    'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                    'type' => 'button',
                    'function' => "ModalCancelItemProfile(event.currentTarget ,'visa' , ".$item['factor_number'].")"
                ];
            }
        }
        return $result;

    }

    public function getBookAllEntertainment($param = '') {
        // info_list
        $Model = Load::library('Model');
        $id = Session::getUserId();
        $sql = "SELECT   
                    passenger_name,
                    passenger_family,
                    member_id,
                    creation_date_int,
                    factor_number,
                    successfull,
                    CountPeople,
                    EntertainmentId
                 FROM book_entertainment_tb 
                 WHERE 
                    member_id='{$id}' ";
        if (!empty($param['startDate']) && !empty($param['endDate'])) {
            $date_of = explode('-', $_POST['startDate']);
            $date_to = explode('-', $_POST['endDate']);
            if(SOFTWARE_LANG == 'fa'){
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }else{
                $date_of_int = mktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = mktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        }
        if (isset($param['factorNumber']) && $param['factorNumber'] != '') {
            $sql .= " AND ( factor_number LIKE '%{$param['factorNumber']}%') ";
        }
        if (isset($param['statusGroup']) && $param['statusGroup'] != '') {
            $sql .= " AND (successfull LIKE '%{$param['statusGroup']}%') ";
        }
        if (isset($param['passengerName']) && $param['passengerName'] != '') {
            $sql .= " AND (concat(passenger_name,' ',passenger_family) LIKE '%{$param['passengerName']}%')";
        }
        $sql .= "
                GROUP BY factor_number 
                ORDER BY creation_date_int DESC ";
        $bookList = $Model->select($sql);
        $result = [] ;
        foreach ($bookList as $key => $item) {

            $result[$key]['service'] = 'Entertainment';
            $entertainment=$this->getController('entertainment');
            $entertainment=$entertainment->GetEntertainmentData(null,null,null,null,$item['EntertainmentId'],null);
            if ($item['creation_date_int'] != '') {
                $bookList[$key]['creation_date_int'] = functions::printDateIntByLanguage('Y/m/d',$item['creation_date_int'],SOFTWARE_LANG);
                $bookList[$key]['creation_time_int'] = functions::printDateIntByLanguage('H:i',$item['creation_date_int'],SOFTWARE_LANG);
            } else {
                $bookList[$key]['creation_date_int'] = '----';
                $bookList[$key]['creation_time_int'] = '';
            }
            if ($item['successfull'] == 'book') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Definitivereservation')->__toString();
            } elseif ($item['successfull'] == 'temporaryReservation') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Temporaryreservation')->__toString();
            } elseif ($item['successfull'] == 'TemporaryPreReserve') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Prereservation')->__toString();
            } elseif ($item['successfull'] == 'prereserve') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Prereservation')->__toString();
            } elseif ($item['successfull'] == 'Requested') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Requested')->__toString();
            } elseif ($item['successfull'] == 'bank') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('NotPaid')->__toString();
            } elseif ($item['successfull'] == 'cancel') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Cancel')->__toString();
            } elseif ($item['successfull'] == 'nothing') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknown')->__toString();
            }else {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknown')->__toString();
            }
            $bookList[$key]['price_final'] = number_format($entertainment['price']);
            $bookList[$key]['entertainment_title'] = $entertainment['title'];

            $result[$key]['title'] = $entertainment['RCountryTitle'] . '-' . $entertainment['RCityTitle'];
            $result[$key]['passenger_name'] = $item['passenger_name'] . ' ' . $item['passenger_family'];
            $result[$key]['date'] = $bookList[$key]['creation_date_int'];
            $result[$key]['time'] = $bookList[$key]['creation_time_int'];
            $result[$key]['status'] = [
                'title'  => $item['successfull'] ,
                'value'  => $bookList[$key]['view_status']
            ];
            $result[$key]['factor_number'] = $item['factor_number'];
            $result[$key]['price'] = $bookList[$key]['price_final'];
            $result[$key]['info_list'] = [
                [
                    'title' => functions::Xmlinformation('EntertainmentTitle')->__toString() ,
                    'value' =>  $entertainment['title']
                ] ,
                [
                    'title' => functions::Xmlinformation('Countpeople')->__toString() ,
                    'value' =>  $item['CountPeople'] + functions::Xmlinformation('People')->__toString()
                ] ,
                [
                    'title' => functions::Xmlinformation('Buydate')->__toString() ,
                    'value' =>  $bookList[$key]['creation_date_int']
                ] ,
                [
                    'title' => functions::Xmlinformation('Amount')->__toString() ,
                    'value' =>  $bookList[$key]['price_final']+ functions::Xmlinformation('Rial')->__toString()
                ] ,
            ];

            $bookList[$key]['dataBtnCancel'] = '';
            $bookList[$key]['dataBtnPdf'] = '';
            if ($item['successfull'] == 'book') {
                $result[$key]['button_list'] = [
                    [
                        'title' => functions::Xmlinformation('Pdff')->__toString() ,
                        'type' => 'link' ,
                        'link' =>  ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=entertainment&id=' . $item['factor_number']
                    ] ,
                    [
                        'title' => functions::Xmlinformation('OsafarRefund')->__toString() ,
                        'type' => 'button' ,
                        'function'  => "ModalCancelItemProfile(event.currentTarget ,'entertainment' , ".$item['factor_number'].")" ,
                    ] ,
                ];
            }
        }
        return $result;
    }

    public function getBookAllEuropcar($param = '') {

        $Model = Load::library('Model');
        $id = Session::getUserId();
        $sql = "SELECT   
                    passenger_name,
                    passenger_family,
                    member_id,
                    creation_date_int,
                    factor_number,
                    status,
                    total_price,
                    car_name,
                    car_name_en
                 FROM book_europcar_local_tb 
                 WHERE 
                    member_id='{$id}' ";
        if (!empty($param['startDate']) && !empty($param['endDate'])) {
            $date_of = explode('-', $_POST['startDate']);
            $date_to = explode('-', $_POST['endDate']);
            if(SOFTWARE_LANG == 'fa'){
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }else{
                $date_of_int = mktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = mktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";
        }
        if (isset($param['factorNumber']) && $param['factorNumber'] != '') {
            $sql .= " AND (factor_number LIKE '%{$param['factorNumber']}%') ";
        }
        if (isset($param['statusGroup']) && $param['statusGroup'] != '') {
            $sql .= " AND (status LIKE '%{$param['statusGroup']}%') ";
        }
        if (isset($param['passengerName']) && $param['passengerName'] != '') {
            $sql .= " AND ((concat(passenger_name,' ',passenger_family) LIKE '%{$param['passengerName']}%')  OR (concat(passenger_name,passenger_family) LIKE '%{$param['passengerName']}%'))";
        }
        $sql .= "
                GROUP BY factor_number 
                ORDER BY creation_date_int DESC ";
        $bookList = $Model->select($sql);
        $result = [];
        foreach ($bookList as $key => $item) {
            if ($item['creation_date_int'] != '') {
                $bookList[$key]['creation_date_int'] = functions::printDateIntByLanguage('Y/m/d',$item['creation_date_int'],SOFTWARE_LANG) ;
                $bookList[$key]['creation_time_int'] = functions::printDateIntByLanguage('H:i',$item['creation_date_int'],SOFTWARE_LANG) ;
            } else {
                $bookList[$key]['creation_date_int'] = '----';
                $bookList[$key]['creation_time_int'] = '----';
            }
            if ($item['status'] == 'prereserve') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Prereservation')->__toString();
            } elseif ($item['status'] == 'bank') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('NotPaid')->__toString();
            } elseif ($item['status'] == 'credit') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Credit')->__toString();
            } elseif ($item['status'] == 'TemporaryReservation') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Temporaryreservation')->__toString();
            } elseif ($item['status'] == 'BookedSuccessfully') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Definitivereservation')->__toString();
            } elseif ($item['status'] == 'Cancellation') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Cancellation')->__toString();
            } elseif ($item['status'] == 'CancelFromEuropcar') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('CancelRequestByEuropcar')->__toString();
            } elseif ($item['status'] == 'NoShow') {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknown')->__toString();
            } else {
                $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknown')->__toString();
            }
            $bookList[$key]['price_final'] = number_format($item['total_price']);

            $result[$key]['service'] = 'Europcar';
            $result[$key]['title'] = functions::Xmlinformation('OrderNumber')->__toString() . ' ' . $item['car_name'];
            $result[$key]['passenger_name'] = $item['passenger_name'] . ' ' . $item['passenger_family'];
            $result[$key]['date'] = $bookList[$key]['creation_date_int'];
            $result[$key]['time'] = $bookList[$key]['creation_time_int'];
            $result[$key]['status'] = [
                'title'  => $item['status'] ,
                'value'  => $bookList[$key]['view_status']
            ];
            $result[$key]['factor_number'] = $item['factor_number'];
            $result[$key]['price'] = $bookList[$key]['price_final'];
            $result[$key]['info_list'] = [
                [
                    'title' => functions::Xmlinformation('Namecar')->__toString() ,
                    'value' =>  $item['car_name']
                ] ,
                [
                    'title' => functions::Xmlinformation('EnglishName')->__toString() ,
                    'value' =>  $item['car_name_en']
                ] ,
                [
                    'title' => functions::Xmlinformation('Buydate')->__toString() ,
                    'value' =>  $bookList[$key]['creation_date_int'] . ' ' . $bookList[$key]['creation_time_int']
                ] ,
                [
                    'title' => functions::Xmlinformation('Amount')->__toString() ,
                    'value' =>  $bookList[$key]['price_final']
                ] ,
            ];

            $bookList[$key]['dataBtnCancel'] = '';
            $result[$key]['button_list'] = [
                [
                    'title' => functions::Xmlinformation('Shownformation')->__toString() ,
                    'type' => 'button' ,
                    'function' => "modalListForEuropcarDetails(event.currentTarget , ".$item['factor_number'].")" ,
                ] ,
            ];
            if ($item['status'] == 'BookedSuccessfully') {
                $result[$key]['button_list'][] =
                    [
                        'title' => functions::Xmlinformation('OsafarRefund')->__toString() ,
                        'type' => 'button' ,
                        'function' => "ModalCancelItemProfile(event.currentTarget , 'europcar' , ".$item['factor_number'].")" ,
                    ] ;
            }
        }
        return $result;
    }

    public function getBookAllItem($param = '') {
        $Model = Load::library('Model');
        $obj_user = Load::controller('user');
        $memberId = Session::getUserId();

        $date = dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode = explode('-', $date);

        $conditions = '';
        $conditions_flight = '';
        $factor_number = '';
        $passenger_factor_num = '';
        $successfull = '';
        $status = '';
        if (!empty($param['startDate']) && !empty($param['endDate'])) {
            $date_of = explode('-', $param['startDate']);
            $date_to = explode('-', $param['endDate']);
            $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
            $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            $conditions .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";
            $conditions_flight .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";
        }
        if (isset($param['factorNumber']) && $param['factorNumber'] != '') {
            $factor_number .= " AND (factor_number  LIKE '%{$param['factorNumber']}%') ";
            $passenger_factor_num .= " AND (passenger_factor_num LIKE '%{$param['factorNumber']}%') ";
        }
        if (isset($param['statusGroup']) && $param['statusGroup'] == 'cancel') {
            $successfull .= " AND successfull = 'book' AND request_cancel = 'confirm' ";
            $status .= " AND (status = 'book' || status = 'BookedSuccessfully') AND request_cancel = 'confirm'  ";
        }elseif(isset($param['statusGroup']) && $param['statusGroup'] != '') {
            $successfull .= " AND (successfull LIKE '%{$param['statusGroup']}%') ";
            $status .= " AND (status LIKE '%{$param['statusGroup']}%') ";
        }
        if (isset($param['passengerName']) && $param['passengerName'] != '') {
            $conditions .= " AND ((concat(passenger_name,' ',passenger_family) LIKE '%{$param['passengerName']}%')  OR (concat(passenger_name,passenger_family) LIKE '%{$param['passengerName']}%'))";
            $conditions_flight .= " AND ((concat(passenger_name,' ',passenger_family) LIKE '%{$param['passengerName']}%')  OR (concat(passenger_name,passenger_family) LIKE '%{$param['passengerName']}%') OR (concat(passenger_name_en,' ',passenger_family_en) LIKE '%{$param['passengerName']}%')  OR (concat(passenger_name_en,passenger_family_en) LIKE '%{$param['passengerName']}%'))";
        }
        $tableNameFlight = 'book_local_tb';
        $tableNameBus = 'book_bus_tb';
        $tableNameTrain = 'book_train_tb';
        $tableNameGasht = 'book_gasht_local_tb';
        $tableNameTour = 'book_tour_local_tb';
        $tableNameHotel = 'book_hotel_local_tb';
        $tableNameInsurance = 'book_insurance_tb';
        $tableNameVisa = 'book_visa_tb';
        $tableNameEntertainment = 'book_entertainment_tb';
        $tableNameEuropcar = 'book_europcar_local_tb';
        $tableNameExclusiveTour = 'book_exclusive_tour_tb';

        $sql = "
            SELECT
                 'flight' As moduleTitle,                 
                  passenger_name AS passenger_name,
                  passenger_family AS passenger_family,     
                  passenger_name_en AS passenger_name_en,
                  passenger_family_en AS passenger_family_en,
                  '' AS passenger_serviceRequestType,
                  '' AS passenger_serviceName,
                  '' AS passenger_serviceCityName,
                  '' AS passenger_number,
                  total_price AS total_price,
                  factor_number AS factor_number,
                  '' AS entertainment_data_json,
                  creation_date_int AS  creation_date_int,
                  successfull AS statusBook, 
                  request_cancel AS request_cancel, 
                  '' AS car_name,
                  '' AS car_name_en,
                  '' AS CountPeople,
                  '' AS EntertainmentId, 
                  '' AS visa_request_status_id,
                  '' AS visa_destination,
                  '' AS visa_title,
                  '' AS visa_type,
                  '' AS documents_visa,
                  '' AS source_name_fa,
                  '' AS destination,
                  '' AS caption,     
                  '' AS hotel_name,               
                  '' AS start_date,               
                  '' AS city_name,               
                  '' AS passenger_leader_room_fullName,               
                  '' AS number_night,  
                  '' AS tour_type,
                  '' AS tour_night,
                  '' AS tour_day,
                  '' AS tour_id,
                  '' AS tour_start_date,
                  '' AS tour_origin_country_name,
                  '' AS tour_origin_city_name,
                  '' AS tour_origin_region_name,
                  '' AS tour_cities, 
                  '' AS tour_name,
                  '' AS passengers_file_tour,    
                  '' AS passenger_factor_num,
                  '' AS order_code,
                  request_number AS request_number,
                  airline_name AS airline_name,
                  time_flight AS time_flight,
                  flight_type AS flight_type,
                  date_flight AS date_flight,
                  IsInternal AS IsInternal,
                  flight_number AS flight_number,
                  eticket_number AS eticket_number,
                  '' AS DateMove,
                  '' AS TimeMove,
                  '' AS BaseCompany,
                  '' AS CarType,
                  '' AS chairs,
                  '' AS passenger_birthday_en,
                  '' AS passenger_birthday,
                  origin_city AS origin_city,
                  desti_city AS desti_city,
                  ''  AS ExitDate,
                  ''  AS ExitTime,
                  ''  AS CompanyName,
                  ''  AS WagonName,
                  direction  AS direction,
                  ''  AS TicketNumber,
                  ''  AS TrainNumber
            FROM
                {$tableNameFlight}
            WHERE
                member_id = '{$memberId}'
                {$conditions_flight} {$factor_number} {$successfull}
            GROUP BY 
                request_number 
             UNION
            SELECT
                 'bus' As moduleTitle,
                  passenger_name AS passenger_name,
                  passenger_family AS passenger_family,
                  '' AS passenger_name_en,
                  '' AS passenger_family_en,
                  '' AS passenger_serviceRequestType,
                  '' AS passenger_serviceName,
                  '' AS passenger_serviceCityName,
                  '' AS passenger_number,
                  total_price AS total_price,
                  '' AS factor_number,
                  '' AS entertainment_data_json,
                  creation_date_int AS  creation_date_int,
                  status AS statusBook,
                  request_cancel AS request_cancel, 
                  '' AS car_name,
                  '' AS car_name_en,
                  '' AS CountPeople,
                  '' AS EntertainmentId, 
                  '' AS visa_request_status_id,
                  '' AS visa_destination,
                  '' AS visa_title,
                  '' AS visa_type,
                  '' AS documents_visa,
                  '' AS source_name_fa,
                  '' AS destination,
                  '' AS caption,     
                  '' AS hotel_name,               
                  '' AS start_date,               
                  '' AS city_name,               
                  '' AS passenger_leader_room_fullName,               
                  '' AS number_night,  
                  '' AS tour_type,
                  '' AS tour_night,
                  '' AS tour_day,
                  '' AS tour_id,
                  '' AS tour_start_date,
                  '' AS tour_origin_country_name,
                  '' AS tour_origin_city_name,
                  '' AS tour_origin_region_name,
                  '' AS tour_cities,
                  '' AS tour_name,
                  '' AS passengers_file_tour,  
                  passenger_factor_num AS passenger_factor_num,
                  order_code AS order_code,
                  '' AS requestNumber,
                  '' AS airline_name,
                  '' AS time_flight,
                  '' AS flight_type,
                  '' AS date_flight,
                  '' AS IsInternal,
                  '' AS flight_number,
                  '' AS eticket_number,
                  DateMove AS DateMove,
                  TimeMove AS TimeMove,
                  BaseCompany AS BaseCompany,
                  CarType AS CarType,
                  GROUP_CONCAT(passenger_chairs SEPARATOR ', ') AS chairs,
                  passenger_birthday_en AS passenger_birthday_en,
                  passenger_birthday AS passenger_birthday,
                  OriginCity AS originCity,
                  DestinationCity  AS destiCity,
                  ''  AS ExitDate,
                  ''  AS ExitTime,
                  ''  AS CompanyName,
                  ''  AS WagonName,
                  ''  AS direction,
                  ''  AS TicketNumber,
                  ''  AS TrainNumber
            FROM
                {$tableNameBus} 
            WHERE
                member_id = '{$memberId}' 
                {$conditions} {$passenger_factor_num} {$status}
            GROUP BY
                passenger_factor_num 
             UNION
            SELECT
                 'train' As moduleTitle,
                  passenger_name AS passenger_name,
                  passenger_family AS passenger_family,
                  '' AS passenger_name_en,
                  '' AS passenger_family_en,
                  '' AS passenger_serviceRequestType,
                  '' AS passenger_serviceName,
                  '' AS passenger_serviceCityName,
                  '' AS passenger_number,
                  FullPrice AS total_price,
                  factor_number AS factor_number,
                  '' AS entertainment_data_json,
                  creation_date_int AS  creation_date_int,
                  successfull AS statusBook, 
                  request_cancel AS request_cancel, 
                  '' AS car_name,
                  '' AS car_name_en,
                  '' AS CountPeople,
                  '' AS EntertainmentId, 
                  '' AS visa_request_status_id,
                  '' AS visa_destination,
                  '' AS visa_title,
                  '' AS visa_type,
                  '' AS documents_visa,
                  '' AS source_name_fa,
                  '' AS destination,
                  '' AS caption,        
                  '' AS hotel_name,               
                  '' AS start_date,               
                  '' AS city_name,               
                  '' AS passenger_leader_room_fullName,               
                  '' AS number_night,  
                  '' AS tour_type,
                  '' AS tour_night,
                  '' AS tour_day,
                  '' AS tour_id,
                  '' AS tour_start_date,
                  '' AS tour_origin_country_name,
                  '' AS tour_origin_city_name,
                  '' AS tour_origin_region_name,
                  '' AS tour_cities,
                  '' AS tour_name,
                  '' AS passengers_file_tour,  
                  '' AS passenger_factor_num,
                  '' AS order_code,
                  requestNumber AS requestNumber,
                  '' AS airline_name,
                  '' AS time_flight,
                  '' AS flight_type,
                  '' AS date_flight,
                  '' AS IsInternal,
                  '' AS flight_number,
                  '' AS eticket_number,
                  '' AS DateMove,
                  '' AS TimeMove,
                  '' AS BaseCompany,
                  '' AS CarType,
                  '' AS chairs,
                  '' AS passenger_birthday_en,
                  '' AS passenger_birthday,
                  Departure_City AS originCity,
                  Arrival_City  AS destiCity,
                  ExitDate  AS ExitDate,
                  ExitTime  AS ExitTime,
                  CompanyName  AS CompanyName,
                  WagonName  AS WagonName,
                  ''  AS direction,
                  TicketNumber  AS TicketNumber,
                  TrainNumber  AS TrainNumber
            FROM
                {$tableNameTrain} 
            WHERE
                member_id = '{$memberId}' 
                {$conditions} {$factor_number} {$successfull}
            GROUP BY
                factor_number,TrainNumber
            
             UNION
            SELECT
                 'gashttransfer' As moduleTitle,
                  passenger_name AS passenger_name,
                  passenger_family AS passenger_family,
                  '' AS passenger_name_en,
                  '' AS passenger_family_en,
                  passenger_serviceRequestType AS passenger_serviceRequestType,
                  passenger_serviceName AS passenger_serviceName,
                  passenger_serviceCityName AS passenger_serviceCityName,
                  passenger_number AS passenger_number,
                  '' AS total_price,
                  '' AS factor_number,
                  '' AS entertainment_data_json,
                  creation_date_int AS  creation_date_int,
                  status AS statusBook,
                  '' AS request_cancel, 
                  '' AS car_name,
                  '' AS car_name_en,
                  '' AS CountPeople,
                  '' AS EntertainmentId, 
                  '' AS visa_request_status_id,
                  '' AS visa_destination,
                  '' AS visa_title,
                  '' AS visa_type,
                  '' AS documents_visa,
                  '' AS source_name_fa,
                  '' AS destination,
                  '' AS caption,     
                  '' AS hotel_name,               
                  '' AS start_date,               
                  '' AS city_name,               
                  '' AS passenger_leader_room_fullName,               
                  '' AS number_night,                 
                  '' AS tour_type,
                  '' AS tour_night,
                  '' AS tour_day,
                  '' AS tour_id,
                  '' AS tour_start_date,
                  '' AS tour_origin_country_name,
                  '' AS tour_origin_city_name,
                  '' AS tour_origin_region_name,
                  '' AS tour_cities, 
                  '' AS tour_name,
                  '' AS passengers_file_tour,              
                  passenger_factor_num AS passenger_factor_num,
                  '' AS order_code,
                  '' AS requestNumber,
                  '' AS airline_name,
                  '' AS time_flight,
                  '' AS flight_type,
                  '' AS date_flight,
                  '' AS IsInternal,
                  '' AS flight_number,
                  '' AS eticket_number,
                  '' AS DateMove,
                  '' AS TimeMove,
                  '' AS BaseCompany,
                  '' AS CarType,
                  '' AS chairs,
                  '' AS passenger_birthday_en,
                  '' AS passenger_birthday,
                  '' AS originCity,
                  ''  AS destiCity,
                  ''  AS ExitDate,
                  ''  AS ExitTime,
                  ''  AS CompanyName,
                  ''  AS WagonName,
                  ''  AS direction,
                  ''  AS TicketNumber,
                  ''  AS TrainNumber
            FROM
                {$tableNameGasht} 
            WHERE
                member_id = '{$memberId}' 
                {$conditions} {$status} {$passenger_factor_num}
            GROUP BY
                passenger_factor_num
                
             UNION
            SELECT
                 'tour' As moduleTitle,
                  passenger_name AS passenger_name,
                  passenger_family AS passenger_family,
                  '' AS passenger_name_en,
                  '' AS passenger_family_en,
                  '' AS passenger_serviceRequestType,
                  '' AS passenger_serviceName,
                  '' AS passenger_serviceCityName,
                  '' AS passenger_number,
                  total_price AS total_price,
                  factor_number AS factor_number,
                  '' AS entertainment_data_json,
                  creation_date_int AS  creation_date_int,
                  status AS statusBook,
                  '' AS request_cancel, 
                  '' AS car_name,
                  '' AS car_name_en,
                  '' AS CountPeople,
                  '' AS EntertainmentId, 
                   '' AS visa_request_status_id,
                  '' AS visa_destination,
                  '' AS visa_title,
                  '' AS visa_type,
                  '' AS documents_visa,
                  '' AS source_name_fa,
                  '' AS destination,
                  '' AS caption,     
                  '' AS hotel_name,               
                  '' AS start_date,               
                  '' AS city_name,               
                  '' AS passenger_leader_room_fullName,               
                  '' AS number_night,                    
                  tour_type AS tour_type,
                  tour_night AS tour_night,
                  tour_day AS tour_day,
                  tour_id AS tour_id,
                  tour_start_date AS tour_start_date,
                  tour_origin_country_name AS tour_origin_country_name,
                  tour_origin_city_name AS tour_origin_city_name,
                  tour_origin_region_name AS tour_origin_region_name,
                  tour_cities AS tour_cities,
                  tour_name AS tour_name,
                  passengers_file_tour AS passengers_file_tour,
                  '' AS passenger_factor_num,
                  '' AS order_code,
                  '' AS requestNumber,
                  '' AS airline_name,
                  '' AS time_flight,
                  '' AS flight_type,
                  '' AS date_flight,
                  '' AS IsInternal,
                  '' AS flight_number,
                  '' AS eticket_number,
                  '' AS DateMove,
                  '' AS TimeMove,
                  '' AS BaseCompany,
                  '' AS CarType,
                  '' AS chairs,
                  '' AS passenger_birthday_en,
                  '' AS passenger_birthday,
                  '' AS originCity,
                  '' AS destiCity,
                  '' AS ExitDate,
                  '' AS ExitTime,
                  ''  AS CompanyName,
                  ''  AS WagonName,
                  ''  AS direction,
                  ''  AS TicketNumber,
                  '' AS TrainNumber
            FROM
                {$tableNameTour} 
            WHERE
                member_id = '{$memberId}' 
                {$conditions} {$factor_number} {$status}
            GROUP BY
                factor_number 
             UNION
            SELECT
                 'hotel' As moduleTitle,
                  passenger_name AS passenger_name,
                  passenger_family AS passenger_family,
                  '' AS passenger_name_en,
                  '' AS passenger_family_en,
                  '' AS passenger_serviceRequestType,
                  '' AS passenger_serviceName,
                  '' AS passenger_serviceCityName,
                  '' AS passenger_number,
                  total_price AS total_price,
                  factor_number AS factor_number,
                  '' AS entertainment_data_json,
                  creation_date_int AS  creation_date_int,
                  status AS statusBook,
                  request_cancel AS request_cancel, 
                  '' AS car_name,
                  '' AS car_name_en,
                  '' AS CountPeople,
                  '' AS EntertainmentId, 
                  '' AS visa_request_status_id,
                  '' AS visa_destination,
                  '' AS visa_title,
                  '' AS visa_type,
                  '' AS documents_visa,
                  '' AS source_name_fa,
                  '' AS destination,
                  '' AS caption,                 
                  hotel_name AS hotel_name,               
                  start_date AS start_date,               
                  city_name AS city_name,               
                  passenger_leader_room_fullName AS passenger_leader_room_fullName,               
                  number_night AS number_night,               
                  '' AS tour_type,
                  '' AS tour_night,
                  '' AS tour_day,
                  '' AS tour_id,
                  '' AS tour_start_date,
                  '' AS tour_origin_country_name,
                  '' AS tour_origin_city_name,
                  '' AS tour_origin_region_name,
                  '' AS tour_cities,
                  '' AS tour_name,
                  '' AS passengers_file_tour,
                  '' AS passenger_factor_num,
                  '' AS order_code,
                  '' AS requestNumber,
                  '' AS airline_name,
                  '' AS time_flight,
                  '' AS flight_type,
                  '' AS date_flight,
                  '' AS IsInternal,
                  '' AS flight_number,
                  '' AS eticket_number,
                  '' AS DateMove,
                  '' AS TimeMove,
                  '' AS BaseCompany,
                  '' AS CarType,
                  '' AS chairs,
                  '' AS passenger_birthday_en,
                  '' AS passenger_birthday,
                  '' AS originCity,
                  '' AS destiCity,
                  '' AS ExitDate,
                  '' AS ExitTime,
                  ''  AS CompanyName,
                  ''  AS WagonName,
                  ''  AS direction,
                  ''  AS TicketNumber,
                  '' AS TrainNumber
            FROM
                {$tableNameHotel} 
            WHERE
                member_id = '{$memberId}' 
                {$conditions} {$factor_number} {$status}
            GROUP BY
                factor_number 
              UNION
            SELECT
                 'insurance' As moduleTitle,
                  passenger_name AS passenger_name,
                  passenger_family AS passenger_family,
                  '' AS passenger_name_en,
                  '' AS passenger_family_en,
                  '' AS passenger_serviceRequestType,
                  '' AS passenger_serviceName,
                  '' AS passenger_serviceCityName,
                  '' AS passenger_number,
                  '' AS total_price,
                  factor_number AS factor_number,
                  '' AS entertainment_data_json,
                  creation_date_int AS  creation_date_int,
                  status AS statusBook, 
                  request_cancel AS request_cancel, 
                  '' AS car_name,
                  '' AS car_name_en,
                  '' AS CountPeople,
                  '' AS EntertainmentId,  
                  '' AS visa_request_status_id,
                  '' AS visa_destination,
                  '' AS visa_title,
                  '' AS visa_type,
                  '' AS documents_visa,
                  source_name_fa AS source_name_fa,
                  destination AS destination,
                  caption AS caption,            
                  '' AS hotel_name,               
                  '' AS start_date,               
                  '' AS city_name,               
                  '' AS passenger_leader_room_fullName,               
                  '' AS number_night,               
                  '' AS tour_type,
                  '' AS tour_night,
                  '' AS tour_day,
                  '' AS tour_id,
                  '' AS tour_start_date,
                  '' AS tour_origin_country_name,
                  '' AS tour_origin_city_name,
                  '' AS tour_origin_region_name,
                  '' AS tour_cities,
                  '' AS tour_name,
                  '' AS passengers_file_tour,
                  '' AS passenger_factor_num,
                  '' AS order_code,
                  '' AS requestNumber,
                  '' AS airline_name,
                  '' AS time_flight,
                  '' AS flight_type,
                  '' AS date_flight,
                  '' AS IsInternal,
                  '' AS flight_number,
                  '' AS eticket_number,
                  '' AS DateMove,
                  '' AS TimeMove,
                  '' AS BaseCompany,
                  '' AS CarType,
                  '' AS chairs,
                  '' AS passenger_birthday_en,
                  '' AS passenger_birthday,
                  '' AS originCity,
                  '' AS destiCity,
                  '' AS ExitDate,
                  '' AS ExitTime,
                  ''  AS CompanyName,
                  ''  AS WagonName,
                  ''  AS direction,
                  ''  AS TicketNumber,
                  '' AS TrainNumber
            FROM
                {$tableNameInsurance} 
            WHERE
                member_id = '{$memberId}' 
                {$conditions} {$factor_number} {$status}
            GROUP BY
                factor_number 
 
      UNION
            SELECT
                 'visa' As moduleTitle,
                  passenger_name AS passenger_name,
                  passenger_family AS passenger_family,
                  '' AS passenger_name_en,
                  '' AS passenger_family_en,
                  '' AS passenger_serviceRequestType,
                  '' AS passenger_serviceName,
                  '' AS passenger_serviceCityName,
                  '' AS passenger_number,
                  total_price AS total_price,
                  factor_number AS factor_number,
                  '' AS entertainment_data_json,
                  creation_date_int AS  creation_date_int,
                  status AS statusBook, 
                  '' AS request_cancel, 
                  '' AS car_name,
                  '' AS car_name_en,
                  '' AS CountPeople,
                  '' AS EntertainmentId, 
                  visa_request_status_id AS visa_request_status_id,
                  visa_destination AS visa_destination,
                  visa_title AS visa_title,
                  visa_type AS visa_type,
                  (SELECT documents FROM visa_type_tb AS visaType WHERE visaType.title = visa_type) AS documents_visa,
                  '' AS source_name_fa,
                  '' AS destination,
                  '' AS caption,            
                  '' AS hotel_name,               
                  '' AS start_date,               
                  '' AS city_name,               
                  '' AS passenger_leader_room_fullName,               
                  '' AS number_night,               
                  '' AS tour_type,
                  '' AS tour_night,
                  '' AS tour_day,
                  '' AS tour_id,
                  '' AS tour_start_date,
                  '' AS tour_origin_country_name,
                  '' AS tour_origin_city_name,
                  '' AS tour_origin_region_name,
                  '' AS tour_cities,
                  '' AS tour_name,
                  '' AS passengers_file_tour,
                  '' AS passenger_factor_num,
                  '' AS order_code,
                  '' AS requestNumber,
                  '' AS airline_name,
                  '' AS time_flight,
                  '' AS flight_type,
                  '' AS date_flight,
                  '' AS IsInternal,
                  '' AS flight_number,
                  '' AS eticket_number,
                  '' AS DateMove,
                  '' AS TimeMove,
                  '' AS BaseCompany,
                  '' AS CarType,
                  '' AS chairs,
                  '' AS passenger_birthday_en,
                  '' AS passenger_birthday,
                  '' AS originCity,
                  '' AS destiCity,
                  '' AS ExitDate,
                  '' AS ExitTime,
                  ''  AS CompanyName,
                  ''  AS WagonName,
                  ''  AS direction,
                  ''  AS TicketNumber,
                  '' AS TrainNumber
            FROM
                {$tableNameVisa} 
            WHERE
                member_id = '{$memberId}' 
                {$conditions} {$factor_number} {$status}
            GROUP BY
                factor_number 
                    UNION
            SELECT
                 'entertainment' As moduleTitle,
                  passenger_name AS passenger_name,
                  passenger_family AS passenger_family,
                  '' AS passenger_name_en,
                  '' AS passenger_family_en,
                  '' AS passenger_serviceRequestType,
                  '' AS passenger_serviceName,
                  '' AS passenger_serviceCityName,
                  '' AS passenger_number,
                  '' AS total_price,
                  factor_number AS factor_number,
                  '' AS entertainment_data_json,
                  creation_date_int AS  creation_date_int,
                  successfull AS statusBook,  
                  request_cancel AS request_cancel, 
                  '' AS car_name,
                  '' AS car_name_en,
                  CountPeople AS CountPeople,
                  EntertainmentId AS EntertainmentId,
                  '' AS visa_request_status_id,
                  '' AS visa_destination,
                  '' AS visa_title,
                  '' AS visa_type,
                  '' AS documents_visa,
                  '' AS source_name_fa,
                  '' AS destination,
                  '' AS caption,            
                  '' AS hotel_name,               
                  '' AS start_date,               
                  '' AS city_name,               
                  '' AS passenger_leader_room_fullName,               
                  '' AS number_night,               
                  '' AS tour_type,
                  '' AS tour_night,
                  '' AS tour_day,
                  '' AS tour_id,
                  '' AS tour_start_date,
                  '' AS tour_origin_country_name,
                  '' AS tour_origin_city_name,
                  '' AS tour_origin_region_name,
                  '' AS tour_cities,
                  '' AS tour_name,
                  '' AS passengers_file_tour,
                  '' AS passenger_factor_num,
                  '' AS order_code,
                  '' AS requestNumber,
                  '' AS airline_name,
                  '' AS time_flight,
                  '' AS flight_type,
                  '' AS date_flight,
                  '' AS IsInternal,
                  '' AS flight_number,
                  '' AS eticket_number,
                  '' AS DateMove,
                  '' AS TimeMove,
                  '' AS BaseCompany,
                  '' AS CarType,
                  '' AS chairs,
                  '' AS passenger_birthday_en,
                  '' AS passenger_birthday,
                  '' AS originCity,
                  '' AS destiCity,
                  '' AS ExitDate,
                  '' AS ExitTime,
                  ''  AS CompanyName,
                  ''  AS WagonName,
                  ''  AS direction,
                  ''  AS TicketNumber,
                  '' AS TrainNumber
            FROM
                {$tableNameEntertainment} 
            WHERE
                member_id = '{$memberId}' 
                {$conditions} {$factor_number} {$successfull}
            GROUP BY
                factor_number 
                
                UNION
            SELECT
                 'europcar' As moduleTitle,
                  passenger_name AS passenger_name,
                  passenger_family AS passenger_family,
                  '' AS passenger_name_en,
                  '' AS passenger_family_en,
                  '' AS passenger_serviceRequestType,
                  '' AS passenger_serviceName,
                  '' AS passenger_serviceCityName,
                  '' AS passenger_number,
                  total_price AS total_price,
                  factor_number AS factor_number,
                  '' AS entertainment_data_json,
                  creation_date_int AS  creation_date_int,
                  status AS statusBook,  
                  '' AS request_cancel, 
                  car_name AS car_name,
                  car_name_en AS car_name_en,
                  '' AS CountPeople,
                  '' AS EntertainmentId,
                  '' AS visa_request_status_id,
                  '' AS visa_destination,
                  '' AS visa_title,
                  '' AS visa_type,
                  '' AS documents_visa,
                  '' AS source_name_fa,
                  '' AS destination,
                  '' AS caption,            
                  '' AS hotel_name,               
                  '' AS start_date,               
                  '' AS city_name,               
                  '' AS passenger_leader_room_fullName,               
                  '' AS number_night,               
                  '' AS tour_type,
                  '' AS tour_night,
                  '' AS tour_day,
                  '' AS tour_id,
                  '' AS tour_start_date,
                  '' AS tour_origin_country_name,
                  '' AS tour_origin_city_name,
                  '' AS tour_origin_region_name,
                  '' AS tour_cities,
                  '' AS tour_name,
                  '' AS passengers_file_tour,
                  '' AS passenger_factor_num,
                  '' AS order_code,
                  '' AS requestNumber,
                  '' AS airline_name,
                  '' AS time_flight,
                  '' AS flight_type,
                  '' AS date_flight,
                  '' AS IsInternal,
                  '' AS flight_number,
                  '' AS eticket_number,
                  '' AS DateMove,
                  '' AS TimeMove,
                  '' AS BaseCompany,
                  '' AS CarType,
                  '' AS chairs,
                  '' AS passenger_birthday_en,
                  '' AS passenger_birthday,
                  '' AS originCity,
                  '' AS destiCity,
                  '' AS ExitDate,
                  '' AS ExitTime,
                  ''  AS CompanyName,
                  ''  AS WagonName,
                  ''  AS direction,
                  ''  AS TicketNumber,
                  '' AS TrainNumber
            FROM
                {$tableNameEuropcar} 
            WHERE
                member_id = '{$memberId}' 
                {$conditions} {$factor_number} {$status}
            GROUP BY
                factor_number 
            UNION
        SELECT
             'exclusivetour' AS moduleTitle,
              passenger_name AS passenger_name,
              passenger_family AS passenger_family,
              '' AS passenger_name_en,
              '' AS passenger_family_en,
              '' AS passenger_serviceRequestType,
              '' AS passenger_serviceName,
              '' AS passenger_serviceCityName,
              '' AS passenger_number,
              total_price AS total_price,
              factor_number AS factor_number,
              entertainment_data_json AS entertainment_data_json,
              creation_date_int AS creation_date_int,
              successfull AS statusBook,
              request_cancel AS request_cancel,
              '' AS car_name,
              '' AS car_name_en,
              '' AS CountPeople,
              '' AS EntertainmentId,
              '' AS visa_request_status_id,
              '' AS visa_destination,
              '' AS visa_title,
              '' AS visa_type,
              '' AS documents_visa,
              '' AS source_name_fa,
              '' AS destination,
              '' AS caption,
              hotel_name AS hotel_name,
              check_in AS start_date,
              '' AS city_name,
              '' AS passenger_leader_room_fullName,
              '' AS number_night,
              '' AS tour_type,
              '' AS tour_night,
              '' AS tour_day,
              '' AS tour_id,
              '' AS tour_start_date,
              '' AS tour_origin_country_name,
              '' AS tour_origin_city_name,
              '' AS tour_origin_region_name,
              '' AS tour_cities,
              '' AS tour_name,
              '' AS passengers_file_tour,
              '' AS passenger_factor_num,
              '' AS order_code,
              request_number AS request_number,
              airline_name AS airline_name,
              time_flight AS time_flight,
              '' AS flight_type,
              date_flight AS date_flight,
              IsInternal AS IsInternal,
              flight_number AS flight_number,
              '' AS eticket_number,
              '' AS DateMove,
              '' AS TimeMove,
              '' AS BaseCompany,
              '' AS CarType,
              '' AS chairs,
              '' AS passenger_birthday_en,
              '' AS passenger_birthday,
              origin_city AS originCity,
              desti_city AS destiCity,
              '' AS ExitDate,
              '' AS ExitTime,
              '' AS CompanyName,
              '' AS WagonName,
              '' AS direction,
              '' AS TicketNumber,
              '' AS TrainNumber
        FROM {$tableNameExclusiveTour}
        WHERE member_id = '{$memberId}' AND request_number > '0'
        GROUP BY request_number
                ";
        $sql .= " ORDER BY creation_date_int DESC ";
//echo $sql;

        $bookList = $Model->select($sql);

        $result = [];
        foreach ($bookList as  $key => $item ){
            $bookList[$key]['dataBtnPdf'] = '';
            $bookList[$key]['ViewBill'] = '';
            $bookList[$key]['reservationProofVersa'] = '';
            $bookList[$key]['dataBtnCancel'] = '';
            $bookList[$key]['ViewDetails'] = '';
            $bookList[$key]['btnDetails'] = '';
            $bookList[$key]['dataBtnPdfFreeLink'] = '';

            $bookList[$key]['module_title'] = $item['moduleTitle'];
            if ($item['creation_date_int'] != '') {
                $bookList[$key]['creation_date_int'] = functions::printDateIntByLanguage('Y/m/d',$item['creation_date_int'],SOFTWARE_LANG);
                $bookList[$key]['creation_time_int'] = functions::printDateIntByLanguage('H:i',$item['creation_date_int'],SOFTWARE_LANG);
            } else {
                $bookList[$key]['creation_date_int'] = '----';
                $bookList[$key]['creation_time_int'] = '----';
            }
            if ($item['moduleTitle'] == 'flight') {
                $info_agency = functions::infoAgencyByMemberId($memberId);
                $amount_buy = functions::CalculateDiscount($item['request_number']) ;
                $number_format_float = ($info_agency['type_payment'] == 'currency' && SOFTWARE_LANG !="fa") ? 2 : 0 ;
                $bookList[$key]['price_final'] = number_format(functions::calcDiscountCodeByFactor($amount_buy, $item['factor_number']),$number_format_float);
                if ($item['IsInternal'] == 0) {
                    $bookList[$key]['flight_internal_external'] = functions::Xmlinformation('Foreign')->__toString();
                }else {
                    $bookList[$key]['flight_internal_external'] = functions::Xmlinformation('Internal')->__toString();
                }
                if ($item['airline_name'] != '') {
                    $bookList[$key]['airline_name'] = $item['airline_name'];
                } else {
                    $bookList[$key]['airline_name'] = '----';
                }
                if ($item['originCity'] != '') {
                    $bookList[$key]['origin_city'] = $item['originCity'];
                } else {
                    $bookList[$key]['origin_city'] = '----';
                }
                if ($item['destiCity'] != '') {
                    $bookList[$key]['desti_city'] = $item['destiCity'];
                } else {
                    $bookList[$key]['desti_city'] = '----';
                }

                $bookList[$key]['time_flight'] = $obj_user->format_hour($item['time_flight']);
                $bookList[$key]['date_flight'] = functions::printDateIntByLanguage('Y/m/d',strtotime($item['date_flight']),SOFTWARE_LANG);

                if ($item['statusBook'] == 'nothing') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknow')->__toString();
                }elseif ($item['statusBook'] == 'error') {
                    if($item['flight_type']=='system'){
                        $bookList[$key]['view_status'] =  functions::Xmlinformation('ErrorPayment')->__toString();
                    }elseif($item['flight_type']=='charter'){
                        $bookList[$key]['view_status'] =  functions::Xmlinformation('ErrorPayment')->__toString();
                    }elseif($item['flight_type']=='charterPrivate'){
                        $bookList[$key]['view_status'] =  functions::Xmlinformation('errorCharterPrivate')->__toString();
                    }
                }elseif ($item['statusBook'] == 'prereserve') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Prereservation')->__toString();
                } elseif ($item['statusBook'] == 'bank') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('RedirectPayment')->__toString();
                } elseif ($item['statusBook'] == 'book') {
                    if ($item['request_cancel'] == 'confirm') {
                        $bookList[$key]['view_status'] = functions::Xmlinformation('Definitivereservation')->__toString().' <span style="color: #fd6767; margin-right: 10px; ">('. functions::Xmlinformation('Refunded')->__toString().')</span>';
                    }else {
                        $bookList[$key]['view_status'] = functions::Xmlinformation('Definitivereservation')->__toString();
                    }
                }elseif ($item['statusBook'] == 'processing') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('processingPrintFlight')->__toString();
                }elseif ($item['statusBook'] == 'pending') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('pendingPrintFlight')->__toString();
                }elseif ($item['statusBook'] == 'credit') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Credit')->__toString();
                }

                if ($item['direction'] == 'TwoWay') {
                    $bookList[$key]['return_dept_TwoWay'] = " (" .functions::Xmlinformation('Twoway')->__toString() . ") ";
                } elseif ($item['direction'] == 'dept' ) {
                    $bookList[$key]['return_dept_TwoWay'] = " (" .functions::Xmlinformation('Went')->__toString() . ") ";
                } elseif ($item['direction'] == 'return' ) {
                    $bookList[$key]['return_dept_TwoWay'] = " (" .functions::Xmlinformation('JustReturn')->__toString() . ") ";
                } else {
                    $bookList[$key]['return_dept_TwoWay'] = "";
                }

                $result[$key]['service'] = 'Flight';
                $result[$key]['title'] = functions::Xmlinformation('Flight')->__toString() .' '. $bookList[$key]['flight_internal_external'] . ' ' .$item['origin_city'] . ' - ' . $item['desti_city'] .' '. $bookList[$key]['return_dept_TwoWay'];
                if ($item['passenger_name']=='' || $item['passenger_family']=='' ) {
                    $result[$key]['passenger_name'] = $item['passenger_name_en'] . ' ' . $item['passenger_family_en'];
                }else{
                    $result[$key]['passenger_name'] = $item['passenger_name'] . ' ' . $item['passenger_family'];
                }
                $result[$key]['date'] = $bookList[$key]['creation_date_int'];
                $result[$key]['time'] = $bookList[$key]['creation_time_int'];
                $result[$key]['status'] = [
                    'title' => $item['statusBook'],
                    'value' => $bookList[$key]['view_status']
                ];
                $result[$key]['factor_number'] = $item['factor_number'];
                $result[$key]['price'] = $bookList[$key]['price_final'];
                if ($item['eticket_number']) {
                    $eticket_number = $item['eticket_number'];
                }else{
                    $eticket_number = '---';
                }
                $result[$key]['info_list'] = [
                    [
                        'title' =>  functions::Xmlinformation('Ticketnumber')->__toString() ,
                        'value' => $eticket_number
                    ],
                    [
                        'title' => functions::Xmlinformation('AirlineCompany')->__toString() ,
                        'value' => $item['airline_name']
                    ],
                    [
                        'title' => functions::Xmlinformation('Route')->__toString() ,
                        'value' => $item['origin_city'] . ' - ' . $item['desti_city']
                    ],
                    [
                        'title' => functions::Xmlinformation('DateTimeDeparture')->__toString() ,
                        'value' => $item['date_flight'] . ' <br>  ساعت ' . $item['time_flight']
                    ],
                    [
                        'title' => functions::Xmlinformation('Amount')->__toString() ,
                        'value' =>  $bookList[$key]['price_final']
                    ]
                ];

                if ($item['statusBook'] == 'book') {
                    if ($item['IsInternal'] == '0') {
                        $bookList[$key]['dataBtnPdf'] =  ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=ticketForeign&id=' . $item['request_number'];
                    } else {
                        if (SOFTWARE_LANG != 'fa') {
                            $pagefinal = 'bookshow';
                        }else{
                            $pagefinal = 'parvazBookingLocal';
                        }
                        $bookList[$key]['dataBtnPdf'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target='.$pagefinal.'&id=' . $item['request_number'].'&lang=fa';
                        $type_member = functions::TypeUser(session::getUserId());
                        if ($type_member == 'Counter') {
                            $bookList[$key]['dataBtnPdf'] =  ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target='.$pagefinal.'&id=' . $item['request_number'].'&lang=fa';

                        }
                        $bookList[$key]['dataBtnPdfFreeLink'] =  ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target='.$pagefinal.'&id=' . $item['request_number'] . '&cash=no'.'&lang=fa';

                    }

                    $result[$key]['button_list'] = [
                        [
                            'title' => functions::Xmlinformation('PassengerListProfile')->__toString(),
                            'type' => 'button' ,
                            'function'  => "modalPassengerDetails(event.currentTarget  , ".$item['factor_number']." , 'flight')" ,
                        ],
                        [
                            'title' => functions::Xmlinformation('GetTicket')->__toString(),
                            'type' => 'link',
                            'link' => $bookList[$key]['dataBtnPdf'],
                        ],
                        [
                            'title' => functions::Xmlinformation('Viewbill')->__toString(),
                            'type' => 'link',
                            'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=boxCheck&id=' . $item['request_number'],
                        ],

                    ];
                    if ($item['statusBook'] == 'book' && $item['request_cancel'] == 'confirm' ) {
                        $result[$key]['button_list'][] =
                            [
                                'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                                'type' => 'link',
                                'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=parvazBookingLocal&id=' . $item['request_number'] .'&cancelStatus=confirm',
                            ];
                    }else{
                        $result[$key]['button_list'][] =
                            [
                                'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                                'type' => 'button' ,
                                'function' => "ModalCancelUserProfile(event.currentTarget ,'flight' , '".$item['request_number']."')",

                            ];
                    }
                    if ($item['statusBook'] == 'book') {
                        if ($item['IsInternal'] != '0') {
                            $result[$key]['button_list'][] =
                                [
                                    'title' => functions::Xmlinformation('Freeticket')->__toString(),
                                    'type' => 'link',
                                    'link' => $bookList[$key]['dataBtnPdfFreeLink'],
                                ];
                        }
                    }
                    if(CLIENT_ID == 271){
                        $reservation_proof = Load::controller('reservationProof');
                        $file = $reservation_proof->getProofFile($item['request_number'] , 'Flight');

                        if($file && isset($file) && !empty($file)) {
                            $result[$key]['button_list'][] = [
                                'title' => functions::Xmlinformation('ViewProof')->__toString(),
                                'type' => 'button' ,
                                'function'  => "modalForReservationProofVersa(event.currentTarget , ".$item['factor_number'].", 'flight')" ,
                            ];
                        }
                    }else {
                        $bookList[$key]['reservationProofVersa'] = '';
                    }
                }

            }
            elseif ($item['moduleTitle'] == 'bus') {
                if ($item['statusBook'] == 'book') {
                    if ($item['request_cancel'] == 'confirm') {
                        $bookList[$key]['view_status'] = functions::Xmlinformation('Definitivereservation')->__toString().' <span style="color: #fd6767; margin-right: 10px; ">('. functions::Xmlinformation('Refunded')->__toString().')</span>';
                    }else {
                        $bookList[$key]['view_status'] = functions::Xmlinformation('Definitivereservation')->__toString();
                    }
                }elseif ($item['statusBook'] == 'temporaryReservation') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Temporaryreservation')->__toString();
                } elseif ($item['statusBook'] == 'prereserve') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Prereservation')->__toString();
                } elseif ($item['statusBook'] == 'bank') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('NotPaid')->__toString();
                }elseif ($item['statusBook'] == 'cancel') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Cancel')->__toString();
                }elseif ($item['statusBook'] == 'nothing') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknown')->__toString();
                }else {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknown')->__toString();
                }
                if ($item['originCity'] != '') {
                    $bookList[$key]['origin_city'] = $item['originCity'];
                } else {
                    $bookList[$key]['origin_city'] = '----';
                }
                if ($item['destiCity'] != '') {
                    $bookList[$key]['desti_city'] = $item['destiCity'];
                } else {
                    $bookList[$key]['desti_city'] = '----';
                }
                $bookList[$key]['price_final'] = number_format(functions::calcDiscountCodeByFactor($item['total_price'], $item['passenger_factor_num']));

                $result[$key]['service'] = 'Bus';
                $result[$key]['title'] = functions::Xmlinformation('Bustype')->__toString() .' '. $item['OriginCity'] .' '. $item['DestinationCity'];
                $result[$key]['passenger_name'] = $item['passenger_name'] . ' ' . $item['passenger_family'];
                $result[$key]['date'] = $item['DateMove'];
                $result[$key]['time'] = $item['TimeMove'];
                $result[$key]['status'] = [
                    'title' => $item['statusBook'],
                    'value' => $bookList[$key]['view_status']
                ];
                $result[$key]['factor_number'] = $item['passenger_factor_num'];
                $result[$key]['price'] = $bookList[$key]['price_final'];
                $result[$key]['info_list'] = [
                    [
                        'title' => functions::Xmlinformation('Ticketnumber')->__toString() ,
                        'value' =>  $item['passenger_factor_num']
                    ],
                    [
                        'title' => functions::Xmlinformation('Passengercompany')->__toString() ,
                        'value' => $item['BaseCompany']
                    ],
                    [
                        'title' => functions::Xmlinformation('TypeCar')->__toString() ,
                        'value' => $item['CarType']
                    ],
                    [
                        'title' => functions::Xmlinformation('SeatNumber')->__toString() ,
                        'value' => $item['chairs']
                    ],
                    [
                        'title' => functions::Xmlinformation('Amount')->__toString() ,
                        'value' => $bookList[$key]['price_final']
                    ],

                ];
                $result[$key]['button_list'] = [
                    [
                        'title' => functions::Xmlinformation('Shownformation')->__toString() ,
                        'type' => 'button',
                        'function' => "modalTicketBusDetails(event.currentTarget , ".$item['passenger_factor_num']." , 'bus')",
                    ],
                ];

                if ($item['statusBook'] == 'book') {
                    $result[$key]['button_list'][] = [
                        'title' => functions::Xmlinformation('GetTicket')->__toString() ,
                        'type' => 'link',
                        'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingBusShow&id=' . $item['passenger_factor_num'],
                    ];
                    $result[$key]['button_list'][] = [
                        'title' => functions::Xmlinformation('Viewbill')->__toString(),
                        'type' => 'link',
                        'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=busBoxCheck&id=' . $item['passenger_factor_num'],
                    ];
                    $result[$key]['button_list'][] = [
                        'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                        'type' => 'button',
                        'function' =>  "ModalCancelUserProfile(event.currentTarget ,'bus', ".$item['order_code'].")",
                    ];
                }
                if ($item['statusBook'] == 'book' && $item['request_cancel'] == 'confirm' ) {
                    $result[$key]['button_list'][] =
                        [
                            'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                            'type' => 'link',
                            'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingBusShow&id=' . $item['passenger_factor_num'] .'&cancelStatus=confirm',
                        ];
                }else{
                    [
                        'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                        'type' => 'button' ,
                        'function' =>  "ModalCancelUserProfile(event.currentTarget ,'bus', ".$item['order_code'].")",

                    ];
                }

                if(CLIENT_ID == 271){
                    $reservation_proof = Load::controller('reservationProof');
                    $file = $reservation_proof->getProofFile($item['order_code'] , 'Bus');

                    if($file && isset($file) && !empty($file)) {
                        $result[$key]['button_list'][] = [
                            'title' => functions::Xmlinformation('ViewProof')->__toString(),
                            'type' => 'button',
                            'function' =>  "modalForReservationProofVersa(event.currentTarget ,".$item['order_code'].", 'Bus')",
                        ];
                    }
                }else {
                    $bookList[$key]['reservationProofVersa'] = '';
                }

            }
            elseif ($item['moduleTitle'] == 'train') {
                if ($item['ExitDate'] != '') {
                    $bookList[$key]['ExitDate'] = functions::printDateIntByLanguage('Y/m/d', strtotime($item['ExitDate']),SOFTWARE_LANG);
                } else {
                    $bookList[$key]['ExitDate'] = '----';
                }
                if ($item['ExitTime'] != '') {
                    $bookList[$key]['ExitTime'] = functions::format_hour($item['ExitTime']);
                } else {
                    $bookList[$key]['ExitTime'] = '----';
                }
                if ($item['originCity'] != '') {
                    $bookList[$key]['origin_city'] = $item['originCity'];
                } else {
                    $bookList[$key]['origin_city'] = '----';
                }
                if ($item['destiCity'] != '') {
                    $bookList[$key]['desti_city'] = $item['destiCity'];
                } else {
                    $bookList[$key]['desti_city'] = '----';
                }
                if ($item['statusBook'] == 'nothing') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknow')->__toString();
                } elseif ($item['statusBook'] == 'prereserve') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Prereservation')->__toString();
                } elseif ($item['statusBook'] == 'bank') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('RedirectPayment')->__toString();
                } elseif ($item['statusBook'] == 'book') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Definitivereservation')->__toString();
                }elseif ($item['successfull'] == 'credit') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Paycredit')->__toString();
                }elseif ($item['statusBook'] == 'error') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('ErrorPayment')->__toString();
                }else {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknow')->__toString();
                }
                $train = Load::controller('bookingTrain');
                $bookList[$key]['price_final'] =  number_format($train->TotalPriceByRequestNumber($item['request_number'],$item['successfull']));

                $result[$key]['service'] = 'Train';
                $result[$key]['title'] = functions::Xmlinformation('S360Train')->__toString() .' '. $item['Departure_City'] .' '. $item['Arrival_City'];
                $result[$key]['passenger_name'] = $item['passenger_name'] . ' ' . $item['passenger_family'];
                $result[$key]['date'] = $item['ExitDate'];
                $result[$key]['time'] = $item['ExitTime'];
                $result[$key]['status'] = [
                    'title' => $item['statusBook'],
                    'value' => $bookList[$key]['view_status'],
                ];
                $result[$key]['factor_number'] = $item['factor_number'];
                $result[$key]['price'] = $bookList[$key]['price_final'];

                $result[$key]['info_list'] = [
                    [
                        'title' => functions::Xmlinformation('Ticketnumber')->__toString(),
                        'value' => $item['TicketNumber']
                    ],
                    [
                        'title' => functions::Xmlinformation('Namepassenger')->__toString(),
                        'value' => $item['passenger_name'] .' '. $item['passenger_family']
                    ],
                    [
                        'title' => functions::Xmlinformation('TrainName')->__toString(),
                        'value' => $item['CompanyName']
                    ],
                    [
                        'title' => functions::Xmlinformation('TrainNumber')->__toString(),
                        'value' => $item['TrainNumber']
                    ],
                    [
                        'title' => functions::Xmlinformation('Hall')->__toString(),
                        'value' => $item['WagonName']
                    ],
                ];
                $result[$key]['button_list'] = [
                    [
                        'title' => functions::Xmlinformation('Shownformation')->__toString(),
                        'type' => 'link',
                        'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=trainBooking&id=' . $item['requestNumber']
                    ],
                ];
                if ($item['statusBook'] == 'book') {
                    $result[$key]['button_list'][] = [
                        'title' => functions::Xmlinformation('ViewTickets')->__toString(),
                        'type' => 'link',
                        'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=trainBooking&id=' . $item['request_number']
                    ];
                    $result[$key]['button_list'][] = [
                        'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                        'type' => 'link',
                        'link' => 'https://refund.raja.ir'
                    ];
                }
            }
            elseif ($item['moduleTitle'] == 'gashttransfer') {
                if ($item['passenger_serviceRequestType'] == '0') {
                    $bookList[$key]['typeService'] =  functions::Xmlinformation('Gasht')->__toString();
                } else {
                    $bookList[$key]['typeService'] =  functions::Xmlinformation('Transfer')->__toString();
                }
                $bookList[$key]['price_final'] =  number_format($item['passenger_number'] * $item['passenger_servicePriceAfterOff']);

                if ($item['statusBook'] == 'prereserve') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Prereservation')->__toString();
                } elseif ($item['statusBook'] == 'bank') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('RedirectPayment')->__toString();
                } elseif ($item['statusBook'] == 'book') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Definitivereservation')->__toString();
                } elseif ($item['statusBook'] == 'cancel') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Cancel')->__toString();
                } else {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknow')->__toString();
                }

                $result[$key]['service'] = 'Gashttransfer';
                $result[$key]['title'] = $bookList[$key]['typeService'] . ' ' . $item['passenger_serviceName'] . ' ' . $item['passenger_serviceCityName'];
                $result[$key]['passenger_name'] = $item['passenger_name'] . ' ' . $item['passenger_family'];
                $result[$key]['date'] = $bookList[$key]['creation_date_int'];
                $result[$key]['time']  = $bookList[$key]['creation_time_int'];
                $result[$key]['status'] = [
                    'title' => $item['statusBook'],
                    'value' => $bookList[$key]['view_status']
                ];
                $result[$key]['factor_number'] = $item['passenger_factor_num'];
                $result[$key]['price'] = $bookList[$key]['price_final'];
                $result[$key]['info_list'] = [
                    [
                        'title' => functions::Xmlinformation('Servicetype')->__toString() .' / '. functions::Xmlinformation('Servicename')->__toString(),
                        'value' => $item['passenger_serviceName'],
                    ],
                    [
                        'title' => functions::Xmlinformation('Destination')->__toString(),
                        'value' => $item['passenger_serviceCityName'],
                    ],
                    [
                        'title' => functions::Xmlinformation('Namepassenger')->__toString(),
                        'value' => $item['passenger_name'] . ' ' .  $item['passenger_family'],
                    ],
                    [
                        'title' => functions::Xmlinformation('Countpeople')->__toString(),
                        'value' => $item['passenger_number'],
                    ]
                ];
                $result[$key]['button_list'] = [
                    [
                        'title' => functions::Xmlinformation('Seebookingpatrolstransfers')->__toString(),
                        'type' => 'button',
                        'function' => "modalListGashtTransfer(event.currentTarget , " . $item['passenger_factor_num'] . " , 'gashttransfer')",
                    ]
                ];

                if ($item['statusBook'] == 'book') {
                    $result[$key]['button_list'][] = [
                        'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                        'type' => 'button',
                        'function' => "ModalCancelItemProfile(event.currentTarget , 'gashttransfer' , " . $item['passenger_factor_num'] . ")",
                    ];
                }
            }
            elseif ($item['moduleTitle'] == 'tour') {
                if ($item['tour_type'] != '') {
                    $bookList[$key]['tour_type'] = $item['tour_type'];
                } else {
                    $bookList[$key]['tour_type'] = '';
                }
                $bookList[$key]['price_final'] = number_format(functions::calcDiscountCodeByFactor($item['total_price'], $item['factor_number']));
                if ($item['tour_night'] > 0) {
                    $bookList[$key]['tour_night'] = $item['tour_night'] .' '. functions::Xmlinformation('Night');
                } else {
                    $bookList[$key]['tour_night'] = '';
                }
                if ($item['tour_day'] > 0) {
                    $bookList[$key]['tour_day'] = $item['tour_day'] .' '. functions::Xmlinformation('Day');
                } else {
                    $bookList[$key]['tour_day'] = '';
                }
                $is_request=false;
                $tour_reservation_controller=Load::controller('reservationTour');
                $tourDetail=$tour_reservation_controller->infoTourById($item['tour_id']);
                if($tourDetail['is_request'] =='1')
                    $is_request=true;

                if ($is_request && $item['statusBook'] == 'Requested') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Requested')->__toString();
                }
                elseif  ($is_request && $item['statusBook'] == 'RequestRejected') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('RequestRejected')->__toString();
                }
                elseif  ($is_request && $item['statusBook'] == 'RequestAccepted') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('RequestAccepted')->__toString();
                }
                elseif ($item['statusBook'] == 'BookedSuccessfully') {
                    $bookList[$key]['view_status'] =  '<span class="text-success">'.functions::Xmlinformation('Definitivereservation')->__toString().'</span>';
                } elseif ($item['statusBook'] == 'TemporaryReservation') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Temporaryreservation')->__toString().' '. functions::Xmlinformation('Paymentprebookingamount')->__toString();
                } elseif ($item['statusBook'] == 'PreReserve') {
                    $bookList[$key]['view_status'] =  '<span>'.functions::Xmlinformation('Temporaryreservation')->__toString().' '.functions::Xmlinformation('Paymentprebookingamount')->__toString().'</span>' .
                        ' <a class="receive-tickets-btn mr-2" target="_blank" href="' . ROOT_ADDRESS . '/UserTracking&type=tour&id=' . $item['factor_number'] . '">'.functions::Xmlinformation('paymentUser')->__toString().'</a>'
                    ;
                } elseif ($item['statusBook'] == 'TemporaryPreReserve') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Temporaryprebooking')->__toString();
                } elseif ($item['statusBook'] == 'bank') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('RedirectPayment')->__toString();
                } elseif ($item['statusBook'] == 'CancellationRequest') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Cancelrequestpassenger')->__toString();
                } elseif ($item['statusBook'] == 'Cancellation') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Cancellation')->__toString() . '<span style="border: 1px dashed #d1d1d1; ">' . $item['cancellation_comment'] .'</span>';
                } else {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknow')->__toString();
                }

                if ($item['tour_start_date'] != '') {
                    $bookList[$key]['enter_date'] =  functions::printDateIntByLanguage('Y/m/d',functions::convertJalaliDateToGregInt($item['tour_start_date']),SOFTWARE_LANG);
                } else {
                    $bookList[$key]['enter_date'] = '----';
                }
                $result[$key]['service'] = 'Tour';
                $result[$key]['title'] = functions::Xmlinformation('Tour')->__toString() . ' ' . $item['tour_name'];
                $result[$key]['passenger_name'] = $item['passenger_name'] . ' ' . $item['passenger_family'];
                $result[$key]['tour_type'] = $bookList[$key]['tour_type'];
                $result[$key]['date'] = $bookList[$key]['creation_date_int'];
                $result[$key]['time'] = $bookList[$key]['creation_time_int'];
                $result[$key]['status'] = [
                    'title' => $item['statusBook'],
                    'value' => $bookList[$key]['view_status']
                ];
                $result[$key]['factor_number'] = $item['factor_number'];
                $result[$key]['price'] = $bookList[$key]['price_final'];
                $result[$key]['info_list'] = [
                    [
                        'title' => functions::Xmlinformation('Periodoftime')->__toString(),
                        'value' => $bookList[$key]['tour_night'] . ' ' .  $bookList[$key]['tour_day'],
                    ],
                    [
                        'title' => functions::Xmlinformation('Origin')->__toString(),
                        'value' => $item['tour_origin_country_name'] . ' ' . $item['tour_origin_city_name'] .' '. $item['tour_origin_region_name'],
                    ],
                    [
                        'title' => functions::Xmlinformation('Destination')->__toString(),
                        'value' => $item['tour_cities'],
                    ],
                    [
                        'title' => functions::Xmlinformation('Enterdate')->__toString(),
                        'value' => $bookList[$key]['enter_date'],
                    ],
                ];

                $result[$key]['button_list'] = [
                    [
                        'title' => functions::Xmlinformation('ShowReservation')->__toString(),
                        'type' => 'button',
                        'function' => "modalTourDetails(event.currentTarget , '".$item['factor_number']."' , 'tour')",
                    ],
                ];

                if ($item['statusBook'] == 'BookedSuccessfully') {
                    $file_list = [] ;
                    if ($item['passengers_file_tour'] != '') {
                        $array_file = json_decode($item['passengers_file_tour']);
                        $num = 0;
                        foreach ($array_file as $k => $file) {
                            $num = $num+1;
                            $file_list[$k] = [
                                'title' => functions::Xmlinformation('file')->__toString(). ' '.$num,
                                'type' => 'link',
                                'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pic/reservationTour/passengersImages/' . $file
                            ];

                        }
                    }

                    $result[$key]['button_list'][] = [
                        'title' => functions::Xmlinformation('Shownformation')->__toString(),
                        'type' => 'link',
                        'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=BookingTourLocal&id=' . $item['factor_number'],
                    ];
                    $result[$key]['button_list'][] = [
                        'title' => functions::Xmlinformation('Pdff')->__toString(),
                        'type' => 'link',
                        'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=BookingTourLocal&id=' . $item['factor_number']
                    ];
                    $result[$key]['button_list'][] = [
                        'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                        'type' => 'button',
                        'function' => "ModalCancelItemProfile(event.currentTarget ,'tour' , ".$item['factor_number'].")",
                    ];
                    $result[$key]['button_list'][] = [
                        'title' =>  functions::Xmlinformation('FilesTour')->__toString(),
                        'type' => 'file_list',
                        'file_list' => $file_list,
                    ];

                }

            }
            elseif ($item['moduleTitle'] == 'hotel') {
                $bookList[$key]['price_final'] = number_format(functions::calcDiscountCodeByFactor($item['total_price'], $item['factor_number']));
                if ($item['statusBook'] == 'BookedSuccessfully') {
                    if ($item['request_cancel'] == 'confirm') {
                        $bookList[$key]['view_status'] = functions::Xmlinformation('Definitivereservation')->__toString().' <span style="color: #fd6767; margin-right: 10px; ">('. functions::Xmlinformation('Refunded')->__toString().')</span>';
                    }else {
                        $bookList[$key]['view_status'] = functions::Xmlinformation('Definitivereservation')->__toString();
                    }
                } elseif ($item['statusBook'] == 'bank') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('RedirectPayment')->__toString();
                } elseif ($item['statusBook'] == 'PreReserve') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Prereservation')->__toString();
                }elseif ($item['statusBook'] == 'OnRequest') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('OnRequestedHotel')->__toString();
                } elseif ($item['statusBook'] == 'Cancelled') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Cancel')->__toString();
                } elseif ($item['statusBook'] == 'pending') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('pendingPrintFlight')->__toString();
                }elseif ($item['statusBook'] == 'Requested') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('PrepaidData')->__toString()."<br>".functions::Xmlinformation('WaitingForAccepted')->__toString();
                }elseif ($item['statusBook'] == 'RequestRejected') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('ManagerDisapproval')->__toString();
                }elseif ($item['statusBook'] == 'RequestAccepted') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('ContinuePay')->__toString();
                } else {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknow')->__toString();
                }
                if ($item['start_date'] != '') {
                    $bookList[$key]['enter_date'] = functions::printDateIntByLanguage('Y/m/d',functions::convertJalaliDateToGregInt($item['start_date']),SOFTWARE_LANG);
                } else {
                    $bookList[$key]['enter_date'] = '----';
                }

                $result[$key]['service'] = 'Hotel';
                $result[$key]['title'] = functions::Xmlinformation('Hotel')->__toString() .' '. $item['hotel_name'] . ' ' . $item['city_name'];
                $result[$key]['passenger_name'] = $item['passenger_name'] . ' ' . $item['passenger_family'];
                $result[$key]['date'] = $bookList[$key]['creation_date_int'];
                $result[$key]['time'] = $bookList[$key]['creation_time_int'];
                $result[$key]['status'] = [
                    'title' => $item['statusBook'],
                    'value' => $bookList[$key]['view_status']
                ];
                $result[$key]['factor_number'] = $item['factor_number'];
                $result[$key]['price'] = $bookList[$key]['price_final'];
                $result[$key]['info_list'] = [
                    [
                        'title' => functions::Xmlinformation('Buydate')->__toString() ,
                        'value' => $bookList[$key]['creation_date_int'] . ' ' . $bookList[$key]['creation_time_int']
                    ],
                    [
                        'title' => functions::Xmlinformation('Enterdate')->__toString() ,
                        'value' => $bookList[$key]['enter_date']
                    ],
                    [
                        'title' => functions::Xmlinformation('Stayigtime')->__toString() ,
                        'value' => $item['number_night'] . ' ' . functions::Xmlinformation('Night')->__toString() ,
                    ],
                    [
                        'title' => functions::Xmlinformation('Amount')->__toString() ,
                        'value' => $bookList[$key]['price_final']
                    ],
                ];

                $bookList[$key]['notInternal'] = '';
                $bookList[$key]['isInternal'] = '';
                $bookList[$key]['dataBtnCancel'] = '';
                $bookList[$key]['edit_hotel'] = '';
                $bookList[$key]['reservationProofVersa'] = '';
                if ($item['statusBook'] == 'BookedSuccessfully') {
                    if(CLIENT_ID == 317) {
                        $bookList[$key]['pdfHotel'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&lang=en&target=bookNewhotelshow&id=' . $item['factor_number'];
                    }else{
                        if ($item['isInternal'] != 0) {
//                            $bookList[$key]['pdfHotel'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=BookingHotelNew&id=' . $item['factor_number'];
                            $bookList[$key]['pdfHotel'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&lang=en&target=bookNewhotelshow&id=' . $item['factor_number'];

                        }
                        else {
                            $bookList[$key]['pdfHotel']  = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookhotelshow&id=' . $item['factor_number'];
                        }
                    }

                }
                $result[$key]['button_list'] = [
                    [
                        'title' => functions::Xmlinformation('Shownformation')->__toString() ,
                        'type' => 'button',
                        'function' => "modalListForHotelDetails(event.currentTarget , ".$item['factor_number']." , 'hotel')",
                    ],

                ];
                if ($item['statusBook'] == 'RequestAccepted' ){
                    $result[$key]['button_list'][] =
                        [
                            'title' => functions::Xmlinformation('ConfirmLoginBank')->__toString(),
                            'type' => 'link',
                            'link' => ROOT_ADDRESS_WITHOUT_LANG . '/fa/UserTracking&type=hotel&id=' . $item['factor_number']
                        ];
                }
                if ($item['statusBook'] == 'BookedSuccessfully' ) {
                    $result[$key]['button_list'][] =
                        [
                            'title' => functions::Xmlinformation('Pdff')->__toString(),
                            'type' => 'link',
                            'link' => $bookList[$key]['pdfHotel'],
                        ];
                }
                if ($item['statusBook'] == 'BookedSuccessfully' && $item['request_cancel'] == 'confirm' ) {
                    $result[$key]['button_list'][] =
                        [
                            'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                            'type' => 'link',
                            'link' => ROOT_ADDRESS_WITHOUT_LANG . '/gds/pdf&target=BookingHotelLocal&id=' . $item['factor_number'] .'&cancelStatus=confirm',
                        ];
                }else{
                    if ($item['statusBook'] != 'Requested' && $item['statusBook'] != 'RequestRejected' && $item['statusBook'] != 'RequestAccepted'){
                        $result[$key]['button_list'][] =
                            [
                                'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                                'type' => 'button',
                                'function' => "ModalCancelItemProfile(event.currentTarget , 'hotel' , ".$item['factor_number'].")",
                            ];
                    }
                }

                if(CLIENT_ID == 271){
                    $reservationProof = Load::controller('reservationProof');
                    $file = $reservationProof->getProofFile($item['factor_number'] , 'Hotel');

                    if($file && isset($file) && !empty($file)) {
                        $result[$key]['button_list'][] = [
                            'title' => functions::Xmlinformation('ViewProof')->__toString(),
                            'type' => 'button' ,
                            'function'  => "modalForReservationProofVersa(event.currentTarget , ".$item['factor_number'].", 'hotel')" ,
                        ];
                    }
                }
                if ($item['type_application'] == 'reservation' && $obj_user->checkForEdit($item['statusBook'], $item['start_date']) == 'true') {
                    $result[$key]['button_list'][] = [
                        'title' => functions::Xmlinformation('Editbookings')->__toString(),
                        'type' => 'link' ,
                        'link' => ROOT_ADDRESS . '/editReserveHotel&id=' . $item['factor_number']
                    ];
                }

            }
            elseif ($item['moduleTitle'] == 'insurance') {
                $bookList[$key]['view_caption']  = '';
                if ($item['caption'] != '') {
                    $bookList[$key]['view_caption'] = ' ( '.$item['caption'].' ) ';
                }
                if ($item['statusBook'] == 'book') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Definitivereservation')->__toString();
                } elseif ($item['statusBook'] == 'bank') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('RedirectPayment')->__toString();
                } elseif ($item['statusBook'] == 'prereserve') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Prereservation')->__toString();
                } elseif ($item['statusBook'] == 'cancel') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Cancel')->__toString();
                } else {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknow')->__toString();
                }

                $bookList[$key]['price_final'] =  number_format(functions::calcDiscountCodeByFactor($obj_user->total_price_insurance($item['factor_number']), $item['factor_number']));
                $bookList[$key]['factor_number'] = $obj_user->showBuyInsurance($item['factor_number']);

                $result[$key]['service'] = 'Insurance';
                $result[$key]['title'] = $item['source_name_fa'] . ' ' . $item['destination'] . ' ' . $item['view_caption'];
                $result[$key]['passenger_name'] = $item['passenger_name'] . ' ' . $item['passenger_family'];
                $result[$key]['date'] = $bookList[$key]['creation_date_int'];
                $result[$key]['time'] = $bookList[$key]['creation_time_int'];
                $result[$key]['status'] = [
                    'title' => $item['statusBook'],
                    'value' => $bookList[$key]['view_status']
                ];
                $result[$key]['factor_number'] =  $bookList[$key]['factor_number'];
                $result[$key]['price'] = $bookList[$key]['price_final'];
                $result[$key]['info_list'] = [
                    [
                        'title' => functions::Xmlinformation('Customername')->__toString(),
                        'value' => $bookList[$key]['factor_number']
                    ],
                    [
                        'title' => functions::Xmlinformation('Buydate')->__toString(),
                        'value' => $result[$key]['date'] . ' ' . $result[$key]['time']
                    ],
                    [
                        'title' => functions::Xmlinformation('Amount')->__toString(),
                        'value' => $bookList[$key]['price_final']
                    ],
                ];
                if ($item['statusBook'] == 'book') {
                    $result[$key]['button_list'] = [
                        [
                            'title' => functions::Xmlinformation('ShowReservation')->__toString(),
                            'type' => 'button',
                            'function' => "modalListInsuranceProfile(event.currentTarget , ".$item['factor_number'].")"
                        ],
                        [
                            'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                            'type' => 'button',
                            'function' => "ModalCancelItemProfile(event.currentTarget , 'insurance' , ".$item['factor_number'].")"
                        ]
                    ];
                }
                if(CLIENT_ID == 271){
                    $reservation_proof = Load::controller('reservationProof');
                    $file = $reservation_proof->getProofFile($item['factor_number'] , 'Insurance');

                    if($file && isset($file) && !empty($file)) {
                        $result[$key]['button_list'][] = [
                            'title' => functions::Xmlinformation('ViewProof')->__toString(),
                            'type' => 'button',
                            'function' => "modalForReservationProofVersa(event.currentTarget ,".$item['factor_number']." , 'Insurance')"
                        ];
                    }
                }
            }
            elseif ($item['moduleTitle'] == 'visa') {
                /** @var visaRequestStatus $visaRequestStatus */
                $visaRequestStatus = Load::controller('visaRequestStatus');
                $bookList[$key]['price_final'] = number_format(functions::calcDiscountCodeByFactor($item['total_price'], $item['factor_number']));

                if ($item['statusBook'] == 'prereserve') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Prereservation')->__toString();
                } elseif ($item['statusBook'] == 'bank') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('RedirectPayment')->__toString();
                } elseif ($item['statusBook'] == 'book') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Definitivereservation')->__toString();
                } elseif ($item['statusBook'] == 'cancel') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Cancel')->__toString();
                } else {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknow')->__toString();
                }
                $bookList[$key]['process_status'] = '';
                if($item['statusBook'] == 'book'){
                    if (isset($visaRequestStatus->getSingle($item['visa_request_status_id'])['title'])) {
                        $bookList[$key]['process_status'] = " ". $visaRequestStatus->getSingle($item['visa_request_status_id'])['title'] ;
                    }else {
                        $bookList[$key]['process_status'] = " ". functions::Xmlinformation('NotSpecified')->__toString();
                    }
                }

                if ($item['visa_destination'] != '') {
                    $bookList[$key]['visa_destination'] = $item['visa_destination'];
                } else {
                    $bookList[$key]['visa_destination'] = '----';
                }
                $result[$key]['service'] = 'Visa';
                $result[$key]['title'] = $item['visa_title'];
                $result[$key]['passenger_name'] = $item['passenger_name'] .' '. $item['passenger_family'];
                $result[$key]['date'] = $bookList[$key]['creation_date_int'];
                $result[$key]['time'] = $bookList[$key]['creation_time_int'];
                $result[$key]['status'] = [
                    'title'  => $item['status'] ,
                    'value'  => $bookList[$key]['view_status'] . ' ' . $bookList[$key]['process_status']
                ];
                $result[$key]['factor_number'] = $item['factor_number'];
                $result[$key]['price'] = $bookList[$key]['price_final'];
                $result[$key]['info_list'] = [
                    [
                        'title' => functions::Xmlinformation('Typevisa')->__toString(),
                        'value' => $item['visa_type']
                    ],
                    [
                        'title' => functions::Xmlinformation('Destination')->__toString(),
                        'value' => $bookList[$key]['visa_destination']
                    ],
                    [
                        'title' => functions::Xmlinformation('Namepassenger')->__toString(),
                        'value' => $item['passenger_name'] . ' ' . $item['passenger_family']
                    ],
                    [
                        'title' => functions::Xmlinformation('Buydate')->__toString(),
                        'value' => $bookList[$key]['creation_date_int'] . ' ' . $bookList[$key]['creation_time_int']
                    ],
                    [
                        'title' => functions::Xmlinformation('Amount')->__toString(),
                        'value' => $bookList[$key]['price_final']
                    ],
                ];
                $bookList[$key]['dataBtnCancel'] = '';
                $result[$key]['button_list'] = [
                    [
                        'title' => functions::Xmlinformation('ShowReservation')->__toString() . ' ' . functions::Xmlinformation('Visa')->__toString(),
                        'type' => 'button',
                        'function' => "modalListForVisaDetails(event.currentTarget , ".$item['factor_number'].")"
                    ]
                ];
                if ($item['statusBook'] == 'book') {
                    $result[$key]['button_list'][] = [
                        'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                        'type' => 'button',
                        'function' => "ModalCancelItemProfile(event.currentTarget ,'visa' , ".$item['factor_number'].")"
                    ];
                }

            }
            elseif ($item['moduleTitle'] == 'entertainment') {
                $entertainment=$this->getController('entertainment');
                $entertainment=$entertainment->GetEntertainmentData(null,null,null,null,$item['EntertainmentId'],null);
                $bookList[$key]['RCountryTitle'] = $entertainment['RCountryTitle'];
                $bookList[$key]['RCityTitle'] = $entertainment['RCityTitle'];

                if ($item['statusBook'] == 'book') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Definitivereservation')->__toString();
                } elseif ($item['statusBook'] == 'temporaryReservation') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Temporaryreservation')->__toString();
                } elseif ($item['statusBook'] == 'prereserve') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Prereservation')->__toString();
                } elseif ($item['statusBook'] == 'bank') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('NotPaid')->__toString();
                } elseif ($item['statusBook'] == 'cancel') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Cancel')->__toString();
                } elseif ($item['statusBook'] == 'nothing') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknown')->__toString();
                }else {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknown')->__toString();
                }
                $bookList[$key]['price_final'] = number_format($entertainment['price']);
                $bookList[$key]['entertainment_title'] = $entertainment['title'];

                $result[$key]['service'] = 'Entertainment';
                $result[$key]['title'] = $entertainment['RCountryTitle'] . '-' . $entertainment['RCityTitle'];
                $result[$key]['passenger_name'] = $item['passenger_name'] . ' ' . $item['passenger_family'];
                $result[$key]['date'] = $bookList[$key]['creation_date_int'];
                $result[$key]['time'] = $bookList[$key]['creation_time_int'];
                $result[$key]['status'] = [
                    'title'  => $item['successfull'] ,
                    'value'  => $bookList[$key]['view_status']
                ];
                $result[$key]['factor_number'] = $item['factor_number'];
                $result[$key]['price'] = $bookList[$key]['price_final'];
                $result[$key]['info_list'] = [
                    [
                        'title' => functions::Xmlinformation('EntertainmentTitle')->__toString() ,
                        'value' =>  $entertainment['title']
                    ] ,
                    [
                        'title' => functions::Xmlinformation('Countpeople')->__toString() ,
                        'value' =>  $item['CountPeople'] + functions::Xmlinformation('People')->__toString()
                    ] ,
                    [
                        'title' => functions::Xmlinformation('Buydate')->__toString() ,
                        'value' =>  $bookList[$key]['creation_date_int']
                    ] ,
                    [
                        'title' => functions::Xmlinformation('Amount')->__toString() ,
                        'value' =>  $bookList[$key]['price_final']+ functions::Xmlinformation('Rial')->__toString()
                    ] ,
                ];

                if ($item['statusBook'] == 'book') {

                    $result[$key]['button_list'] = [
                        [
                            'title' => functions::Xmlinformation('Pdff')->__toString() ,
                            'type' => 'link' ,
                            'link' =>  ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=entertainment&id=' . $item['factor_number']
                        ]


                        ,
                        [
                            'title' => functions::Xmlinformation('OsafarRefund')->__toString() ,
                            'type' => 'button' ,
                            'function'  => "ModalCancelItemProfile(event.currentTarget , 'entertainment' , ".$item['factor_number'].")" ,
                        ] ,
                    ];
                }
            }
            elseif ($item['moduleTitle'] == 'europcar') {
                if ($item['statusBook'] == 'prereserve') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Prereservation')->__toString();
                } elseif ($item['statusBook'] == 'bank') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('NotPaid')->__toString();
                } elseif ($item['statusBook'] == 'credit') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Credit')->__toString();
                } elseif ($item['statusBook'] == 'TemporaryReservation') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Temporaryreservation')->__toString();
                } elseif ($item['statusBook'] == 'BookedSuccessfully') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Definitivereservation')->__toString();
                } elseif ($item['statusBook'] == 'Cancellation') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Cancellation')->__toString();
                } elseif ($item['statusBook'] == 'CancelFromEuropcar') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('CancelRequestByEuropcar')->__toString();
                } elseif ($item['statusBook'] == 'NoShow') {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknown')->__toString();
                } else {
                    $bookList[$key]['view_status'] =  functions::Xmlinformation('Unknown')->__toString();
                }
                $bookList[$key]['price_final'] = number_format($item['total_price']);

                $result[$key]['service'] = 'Europcar';
                $result[$key]['title'] = functions::Xmlinformation('OrderNumber')->__toString() . ' ' . $item['car_name'];
                $result[$key]['passenger_name'] = $item['passenger_name'] . ' ' . $item['passenger_family'];
                $result[$key]['date'] = $bookList[$key]['creation_date_int'];
                $result[$key]['time'] = $bookList[$key]['creation_time_int'];
                $result[$key]['status'] = [
                    'title'  => $item['statusBook'] ,
                    'value'  => $bookList[$key]['view_status']
                ];
                $result[$key]['factor_number'] = $item['factor_number'];
                $result[$key]['price'] = $bookList[$key]['price_final'];
                $result[$key]['info_list'] = [
                    [
                        'title' => functions::Xmlinformation('Namecar')->__toString() ,
                        'value' =>  $item['car_name']
                    ] ,
                    [
                        'title' => functions::Xmlinformation('EnglishName')->__toString() ,
                        'value' =>  $item['car_name_en']
                    ] ,
                    [
                        'title' => functions::Xmlinformation('Buydate')->__toString() ,
                        'value' =>  $bookList[$key]['creation_date_int'] . ' ' . $bookList[$key]['creation_time_int']
                    ] ,
                    [
                        'title' => functions::Xmlinformation('Amount')->__toString() ,
                        'value' =>  $bookList[$key]['price_final']
                    ] ,
                ];

                $bookList[$key]['dataBtnCancel'] = '';
                $result[$key]['button_list'] = [
                    [
                        'title' => functions::Xmlinformation('Shownformation')->__toString() ,
                        'type' => 'button' ,
                        'function' => "modalListForEuropcarDetails(event.currentTarget , ".$item['factor_number'].")" ,
                    ] ,
                ];
                if ($item['statusBook'] == 'BookedSuccessfully') {
                    $result[$key]['button_list'][] =
                        [
                            'title' => functions::Xmlinformation('OsafarRefund')->__toString() ,
                            'type' => 'button' ,
                            'function' => "ModalCancelItemProfile(event.currentTarget , 'europcar' , ".$item['factor_number'].")" ,
                        ] ;
                }
            }
            elseif ($item['moduleTitle'] == 'exclusivetour'){
                //        ============================EntertainmentData============================
                $entertainmentSection = null;
                if (!empty($item['entertainment_data_json'])) {

                    $entData = json_decode($item['entertainment_data_json'], true);

                    if (is_array($entData) && count($entData)) {

                        $entItems = [];

                        foreach ($entData as $ent) {

                            $title = (isset($ent['tourTitle']) && $ent['tourTitle'] != '')
                                ? $ent['tourTitle']
                                : 'تفریح';

                            $price = (isset($ent['final_price']) && $ent['final_price'] != '')
                                ? number_format($ent['final_price'])
                                : '0';

                            $entItems[] = [
                                'title' => $title,
                                'value' => $price
                            ];
                        }

                        if (count($entItems)) {
                            $entertainmentSection = [
                                'title' => 'خدمات اضافه',
                                'items' => $entItems
                            ];
                        }
                    }
                }
                //        ============================EntertainmentData============================
                $price_final = number_format($item['total_price']);
                // === تاریخ و زمان ===
                $creation_date = $item['creation_date_int'] ? functions::printDateIntByLanguage('Y/m/d', $item['creation_date_int'], SOFTWARE_LANG) : '----';
                $creation_time = $item['creation_date_int'] ? functions::printDateIntByLanguage('H:i', $item['creation_date_int'], SOFTWARE_LANG) : '';
                // === وضعیت ===
                switch ($item['statusBook']) {
                    case 'nothing': $view_status = functions::Xmlinformation('Unknow')->__toString(); break;
                    case 'error': $view_status = functions::Xmlinformation('ErrorPayment')->__toString(); break;
                    case 'lock': $view_status = functions::Xmlinformation('Prereservation')->__toString(); break;
                    case 'bank': $view_status = functions::Xmlinformation('RedirectPayment')->__toString(); break;
                    case 'book':
                        $view_status = functions::Xmlinformation('Definitivereservation')->__toString();
                        if ($item['request_cancel'] == 'confirm') {
                            $view_status .= ' <span style="color:#fd6767;margin-right:10px;">('.functions::Xmlinformation('Refunded')->__toString().')</span>';
                        }
                        break;
                    case 'processing': $view_status = functions::Xmlinformation('processingPrintFlight')->__toString(); break;
                    case 'pending': $view_status = functions::Xmlinformation('pendingPrintFlight')->__toString(); break;
                    case 'credit': $view_status = functions::Xmlinformation('Credit')->__toString(); break;
                    default: $view_status = 'نامشخص';
                }
                $result[$key]['service'] = 'ExclusiveTour';
                $result[$key]['title'] = functions::Xmlinformation('ExclusiveTour')->__toString() .' '. $item['origin_city'] .' - '. $item['desti_city'] .' ('. $item['hotel_name'].')';
                $result[$key]['date'] = $creation_date;
                $result[$key]['time'] = $creation_time;
                $result[$key]['status'] = [
                    'title' => $item['statusBook'],
                    'value' => $view_status
                ];
                $result[$key]['factor_number'] = $item['factor_number'];
                $result[$key]['price'] = $price_final;

                // === ساختار جدید info_new_list ===
                $result[$key]['info_new_list'] = [
                    [
                        'title' => 'پرواز رفت',
                        'items' => [
                            ['title' => 'شرکت هواپیمایی', 'value' => $item['airline_name'].' '.$item['flight_number']],
                            ['title' => 'مسیر', 'value' => $item['origin_city'] . ' - ' . $item['desti_city']],
                            ['title' => 'تاریخ و ساعت حرکت', 'value' => $item['date_flight'] . ' <br> ساعت ' . $item['time_flight']],
                        ]
                    ],
                    [
                        'title' => 'پرواز برگشت',
                        'items' => [
                            ['title' => 'شرکت هواپیمایی', 'value' => $item['airline_name'].' '.$item['ret_flight_number']],
                            ['title' => 'مسیر', 'value' => $item['desti_city'] . ' - ' . $item['origin_city']],
                            ['title' => 'تاریخ و ساعت حرکت', 'value' => $item['ret_date_flight'] . ' <br> ساعت ' . $item['ret_time_flight']],
                            // اختیاری ↓
                            // ['title' => 'مبلغ', 'value' => $ret_price_final],
                        ]
                    ],
                    [
                        'title' => 'هتل',
                        'items' => [
                            ['title' => 'نام هتل', 'value' => $item['hotel_name'] ?: '----'],
                            ['title' => 'تاریخ ورود', 'value' => $item['check_in']],
                            ['title' => 'تاریخ خروج', 'value' => $item['check_out']],
                        ]
                    ]
                ];

                if ($entertainmentSection) {
                    $result[$key]['info_new_list'][] = $entertainmentSection;
                }


                $bookList[$key]['dataBtnPdf'] = '';
                $bookList[$key]['dataBtnPdfFreeLink'] = '';
                $bookList[$key]['ViewBill'] = '';
                $bookList[$key]['dataBtnCancel'] = '';
                $bookList[$key]['reservationProofVersa'] = '';
                if ($item['statusBook'] == 'book') {
                    if ($item['IsInternal'] == '0') {
                        $bookList[$key]['dataBtnPdf'] =  ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=ticketForeign&id=' . $item['request_number'];
                    } else {
                        if (SOFTWARE_LANG != 'fa') {
                            $pagefinal = 'bookshow';
                        }else{
                            $pagefinal = 'parvazBookingLocal';
                        }
                        $bookList[$key]['dataBtnPdf'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target='.$pagefinal.'&id=' . $item['request_number'] . '&lang=fa';
                        $type_member = functions::TypeUser(session::getUserId());
                        if ($type_member == 'Counter') {
                            /*$bookList[$key]['dataBtnPdf'] =  ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target='.$pagefinal.'&id=' . $item['request_number'].'&lang=fa';
                            $bookList[$key]['dataBtnPdfFreeLink'] =  ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target='.$pagefinal.'&id=' . $item['request_number'] . '&cash=no';*/
                        }

                    }
                    $result[$key]['button_list'] = [
                        [
                            'title' => functions::Xmlinformation('PassengerListProfile')->__toString(),
                            'type' => 'button' ,
                            'function'  => "ModalPassengerExclusiveTourDetails(event.currentTarget  , ".$item['factor_number'].",'exclusivetour')" ,
                        ],
                        [
                            'title' => functions::Xmlinformation('GetTicket')->__toString(),
                            'type' => 'link',
//                        'link' => $bookList[$key]['dataBtnPdf'],
                        ],
                        [
                            'title' => functions::Xmlinformation('Viewbill')->__toString(),
                            'type' => 'link',
//                        'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=boxCheck&id=' . $item['request_number'],
                        ],

                    ];
                    /* if ($item['successfull'] == 'book' && $item['request_cancel'] == 'confirm' ) {
                         $result[$key]['button_list'][] =
                             [
                                 'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                                 'type' => 'link',
                                 'link' => ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=parvazBookingLocal&id=' . $item['request_number'] .'&cancelStatus=confirm',
                             ];
                     }else{
                         $result[$key]['button_list'][] =
                             [
                                 'title' => functions::Xmlinformation('OsafarRefund')->__toString(),
                                 'type' => 'button' ,
                                 'function' => "ModalCancelUserProfile(event.currentTarget ,'flight' , '".$item['request_number']."')",

                             ];
                     }*/
                    if ($item['statusBook'] == 'book') {
                        if ($item['IsInternal'] != '0') {
                            $result[$key]['button_list'][] =
                                [
                                    'title' => functions::Xmlinformation('Freeticket')->__toString(),
                                    'type' => 'link',
                                    'link' => $bookList[$key]['dataBtnPdfFreeLink'],
                                ];
                        }
                    }
                    if(CLIENT_ID == 271){
                        $reservation_proof = Load::controller('reservationProof');
                        $file = $reservation_proof->getProofFile($item['request_number'] , 'Flight');
                        if($file && isset($file) && !empty($file)) {
                            $result[$key]['button_list'][] =
                                [
                                    'title' => functions::Xmlinformation('ViewProof')->__toString(),
                                    'type' => 'button' ,
                                    'function'  => "modalForReservationProofVersa( event.currentTarget ,".$item['factor_number'].", 'flight')" ,
                                ];
                        }
                    }else {
                        $bookList[$key]['reservationProofVersa'] = '';
                    }
                }
            }
        }

//            echo json_encode($bookList);
//            die;

//        var_dump($result);
        return $result;

    }


    public function getPointOfClub() {
        return $this->getController('historyPointClub')->getPointClubMember(Session::getUserId());
    }


    public function checkIsCounter() {
        return $this->getController('members')->isCounter();

    }

    public function getCreditMember() {
        return $this->getController('memberCredit')->getRemainCreditMember();
    }

    public function getDiscountCodeUser($type) {
        if($type=='point')
        {
            $result_discount_codes =  $this->getController('discountCodes')->getPointDiscountCode();

        }else{
            $result_discount_codes =  $this->getController('discountCodes')->getPopularDiscountCode();

        }
        $discount_code_used = $this->getController('discountCodes')->getAllCodeDiscountUsed();
        $final_results = [];

        foreach ($discount_code_used as $result_used) {
            $final_results[$result_used['discountCode']][] = $result_used ;
        }


        $code_info = [];

        foreach ($result_discount_codes as $key=>$code) {

            $code_info[$key]['id'] = $code['id'];
            $code_info[$key]['title'] = $code['title'];
            $code_info[$key]['amount'] = $code['amount'];
            $code_info[$key]['stock'] = $code['stock'];
            $code_info[$key]['end_date_code'] = functions::dateDiff(date('Y-m-d', time()), date('Y-m-d', $code['endDateInt']));
            $code_info[$key]['code'] = $code['code'];
            $code_info[$key]['limit_point_club'] = $code['code'];
            $code_info[$key]['service_title'] = functions::getServiceDiscountGroupTitle($code['serviceTitle']);
            $code_info[$key]['count_used'] = intval($code['stock']) - intval(count($final_results[$code['code']]));
            $code_info[$key]['limit_point_club'] = intval($code['limit_point_club']);
        }


        shuffle($code_info);
        return $code_info ;
    }

    public function transactionCreditUser() {
        return $this->getController('memberCredit')->listAllSuccessCreditMember();
    }

    public function pointsClubUser() {

        $points =  $this->getController('historyPointClub')->getPointClubUser(Session::getUserId());

        $final_points = [];
        foreach ($points as $key => $point) {

            $final_points[$key]['point'] = $point['point'];
            $final_points[$key]['type_point'] = ($point['type_point']=='increase' ) ? functions::Xmlinformation('TypePointYes'):  functions::Xmlinformation('TypePointNo');
            $final_points[$key]['comment'] = $point['comment'];
            $final_points[$key]['factor_number'] = $point['factor_number'];
            $final_points[$key]['amount_price_point'] = $point['amount_price_point'];
            $final_points[$key]['is_consumed'] = ($point['is_consumed']==0 ) ? functions::Xmlinformation('Used'):  functions::Xmlinformation('UnUsed');
            $final_points[$key]['type_service'] = functions::getServiceDiscountGroupTitle($point['service_title']);

        }

        return $final_points ;
    }
    public function getAboutClub() {
        return $this->getController('aboutUs')->getData();
    }

    public function specialDiscountUser() {
        $final_array = [];
        $all_special_discounts = $this->getController('servicesDiscount')->getAllSpecialDiscount();

        foreach ($all_special_discounts as $item) {
            $final_array[$item['type_get_discount']][] = $item;

        }
        return $final_array;
    }

    public function getCodesPhoneSpecialDiscount() {

        $final_array = [];
        $all_special_discounts = $this->getController('servicesDiscount')->getAllSpecialDiscount();

        foreach ($all_special_discounts as $item) {
            if($item['type_get_discount']=='phone') {
                $final_array[] = $item['pre_code'];
            }

        }
        return $final_array;
    }

    public function getNationalCodesSpecialDiscount() {

        $final_array = [];
        $all_special_discounts = $this->getController('servicesDiscount')->getAllSpecialDiscount();

        foreach ($all_special_discounts as $item) {
            if($item['type_get_discount']=='national_code') {
                $final_array[] = $item['pre_code'];
            }

        }
        return $final_array;
    }

    public function getGetReagentPoint() {
        return $this->getController('reagentPoint')->GetReagentPoint();
    }

    public function getSumReagentPoint() {
        return $this->getController('memberCredit')->getSumReagentAward();
    }

    public function getCountUseMembersOfReagentCode($code) {
        return $this->getController('memberCredit')->countUseMembersOfReagentCode($code);
    }

    public function getFaqPublic() {
        return $this->getController('faqs')->getByPosition([
            'limit'=>10,
            'service'=>'Public',
        ]);
    }

    public function infoModalUserList($request_number, $type){
        if($type == 'flight') {
            $result =  $this->getInfoTicketFlightCancel($request_number);
        }
        return $result;
    }


    public function getTotalUserRewards($member_id) {
        return  $this->getModel('membersCreditModel')->get()->where('memberId',$member_id)->where('reason' , 'reagent_code_presented')->where('state' , 'charge' )->where('status' , 'success' )->all();
    }

    public function getInvitedUserList($reagent_code)
    {
        $members_model = $this->getModel('membersModel');
        $members_table = $members_model->getTable();
        $member_credit_model = $this->getModel('membersCreditModel');
        $member_credit_table = $member_credit_model->getTable();
        $result = $members_model->get([
            $members_table.'.*',
            $member_credit_table.'.*',
        ] ,true)
            ->join($member_credit_table, 'memberId', 'id')
            ->where($member_credit_table . '.reagentCode' , $reagent_code)->where($member_credit_table . '.status' , 'success')->orderBy('creationDateInt' , 'DESC')->all(false);

        return $result;
    }


}