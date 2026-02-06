<?php
//if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}

class memberCredit extends clientAuth{

    protected $user_id = null ;
    public function __construct(){
        parent::__construct();

        $this->user_id = Session::getUserId();
    }
    /**
     * @return bool|mixed|creditDetailModel
     */
    public function usersWalletModel() {
        return Load::getModel( 'membersCreditModel' );
    }
    public function listAllSuccessCreditMember(){

        return $this->getModel('membersCreditModel')->get()->where('memberId',$this->user_id)->where('status','pending','<>')->all();
    }
    public function getSpecificCreditMemberById($id){
        return $this->getModel('membersCreditModel')->get()->where('id',$id)->find();
    }

    public function checkExistMemberCreditByFactorNumber($factor_number){
       return  $this->getModel('membersCreditModel')->get()->where('factorNumber',$factor_number)->all();
    }
    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        return json_encode([
            'success' => $success,
            'message' => $message,
            'code' => $statusCode,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);


    }
    public function getRemainCreditMember() {
            $charge_credit_member = $this->getChargeMemberCredit();
            $consumed_credit_member = $this->getBuyMemberCredit();

            return intval($charge_credit_member['charge_amount'])- intval($consumed_credit_member['buy_amount']);
    }


    public function getChargeMemberCredit() {
        return $this->getModel('membersCreditModel')->get(["SUM(amount) AS charge_amount"],true)->where('memberId',$this->user_id)->where('status','success')->where('state','charge')->find();
    }
    public function getBuyMemberCredit() {
        return $this->getModel('membersCreditModel')->get(["SUM(amount) AS buy_amount"],true)->where('memberId',$this->user_id)->where('status','success')->where('state','buy')->find();
    }
    public function increaseChargeAccount($params) {

        $exist_factor = $this->checkExistMemberCreditByFactorNumber($params['factorNumber']);

        if (empty($exist_factor)) {
            $dataCredit['memberId'] = Session::getUserId();
            $dataCredit['amount'] = $params['price'];
            $dataCredit['factorNumber'] = $params['factorNumber'];
            $dataCredit['state'] = 'charge';
            $dataCredit['reason'] = 'charge';
            $dataCredit['comment'] = 'افزایش اعتبار کاربر به شماره فاکتور ' . $dataCredit['factorNumber'];
            $dataCredit['status'] = 'pending';
//            $dataCredit['type'] = 'increase';
            $dataCredit['creationDateInt'] = time();

            $this->getModel('membersCreditModel')->insertWithBind($dataCredit);
        }

    }

    public function UpdateChargeAccountUser($factorNumber, $trackingCode = null, $status) {
        $data['status'] = $status;
        $data['bankTrackingCode'] = $trackingCode;
        $condition = "factorNumber='{$factorNumber}'";

        $this->getModel('membersCreditModel')->update($data, $condition);
    }

    public function setGifPointToCreditUser($params) {

        if($params['point']){
            $price_to_point = PRICE_POINT ;
            $dataCredit['memberId'] = Session::getUserId();
            $dataCredit['amount'] = intval($params['point']) * intval($price_to_point) ;
            $dataCredit['factorNumber'] = 'CHC'.rand(000,999);
            $dataCredit['state'] = 'charge';
            $dataCredit['reason'] = 'giftBuyTicket';
            $dataCredit['comment'] = 'افزایش اعتبار کاربر بابت استفاده از امتیازات به میزان '. $params['point'].' امتیاز';
            $dataCredit['status'] = 'progress';

            $this->getModel('membersCreditModel')->insertWithBind($dataCredit);

            $params['factor_number'] =  $dataCredit['factorNumber'] ;
            $this->getController('historyPointClub')->decreasePointForConvertToCredit($params);

            return functions::withSuccess($params['point'],200,'ثبت درخواست امتیاز به اعتبار انجام شد،پس از تایید ،اعتبار قابل استفاده خواهد بود،چناچه تایید انجام نگیرد امتیاز به سبد امتیازی شما بارخواهد گشت');
        }

        return functions::withError('',401,'خطا در تبدیل امتیاز به اعتبار');

    }

    public function getSumReagentAward() {

        return $this->getModel('membersCreditModel')->get(['SUM(amount) AS sum_amount'],true)->where('memberId',Session::getUserId())->where('reason','reagent_code_presented')->where('state','charge')->where('status','success')->find();
    }

    public function countUseMembersOfReagentCode($code) {
        return $this->getModel('membersCreditModel')->get(['Count(amount) AS count_use_reagent'],true)->where('reagentCode',$code)->where('status','success')->find();
    }

    public function addCreditMemberForReagentCode($params) {
        $this->getModel('membersCreditModel')->insertLocal($params);
    }


   public function infoAdmin($type_admin , $adminId ,$typeAgency) {
       $name_admin = '';
       $Model = Load::library('Model');
        if ($type_admin == 1) {
            $name_admin = 'ایران تکنولوژی';
        }else{
            if ($typeAgency == 'AgencyPartner') {
                if($adminId) {
                    $sql_list = "SELECT * FROM members_tb WHERE id='{$adminId}' ";

                    $name_admin = $Model->load($sql_list);

                    $name_admin = $name_admin['name'] . ' ' . $name_admin['family'];

//                    $name_admin = $this->getModel('members_tb')->get()->where('id', $adminId)->find();
                }else{
                    $name_admin = '-----';
                }

            }elseif ($typeAgency == 'agency') {
                $name_admin = CLIENT_NAME;
            }else{
                $name_admin = '-----';
            }
        }
    return $name_admin;
   }


    public function getAll($memberID)
    {

        $memberID = !empty($memberID) ? $memberID : Session::getAgencyId();
        $Model = Load::library('Model');

//        $sql_list = "SELECT * FROM members_credit_tb WHERE memberId='{$memberID}' AND (status='success' OR status IS NULL)  ORDER BY creationDateInt DESC";
        $sql_list = "SELECT * FROM members_credit_tb WHERE memberId='{$memberID}'  ORDER BY creationDateInt ASC";

        $this->list = $Model->select($sql_list);
        $sql_charge = "SELECT sum(amount) AS total_charge FROM members_credit_tb WHERE state='charge' AND memberId='{$memberID} ' AND (status='success' OR status IS NULL)";
        $charge = $Model->load($sql_charge);
        $this->total_charge = $charge['total_charge'];

        $sql_buy = "SELECT sum(amount) AS total_buy FROM members_credit_tb WHERE state='buy' AND memberId='{$memberID}' AND (status='success' OR status IS NULL)";
        $buy = $Model->load($sql_buy);
        $this->total_buy = $buy['total_buy'];

        $sql_failed = "SELECT sum(amount) AS total_failed FROM members_credit_tb WHERE state='charge' AND memberId='{$memberID}' AND (status='pending')";
        $failed = $Model->load($sql_failed);
        $this->total_failed = $failed['total_failed'];

        $sql_pending = "SELECT sum(amount) AS total_pending FROM members_credit_tb WHERE state='buy' AND memberId='{$memberID}' AND (status='pending')";
        $pending = $Model->load($sql_pending);
        $this->total_pending = $pending['total_pending'];

        $this->total_transaction = $this->total_charge  - ($this->total_buy) ;
        $this->total_all = $this->total_charge ;
    }


    public function timeToDateJalali($time)
    {
        return dateTimeSetting::jdate("Y/m/d H:i:s", $time,'','','en');
    }
    /**
     * @return bool|mixed|membersModel
     */
    public function membersModel() {
        return Load::getModel( 'membersModel' );
    }
    public function insert_user_wallet($infoCredit)
    {



//        if (Session::adminIsLogin()) {
//            var_dump('xdcvsdcsdc');
//            die;
//            $data['name'] = ' مدیریت '.CLIENT_NAME;
//            $data['email'] = CLIENT_EMAIL;
//            $data['mobile'] = CLIENT_MOBILE;
//            $data['validate']=1;
//        }else {
//            var_dump('dppppp');
//        }


        $admin_id = (Session::adminIsLogin()) ? CLIENT_ID : '' ;
//        $client_name = (Session::adminIsLogin()) ? CLIENT_NAME : '' ;

        $member_info =  $this->membersModel()->get()->where('id',$infoCredit['memberID'])->find();
        if (!empty($member_info)) {
            $ii = 0;
            $temp = mt_rand(1 , 15);
            do {
                $temp .= mt_rand(0 , 15);
            } while (++$ii < 16);
            $uniq = $temp;
            $factorNumber = substr($uniq , 0 , 10);

            if ($infoCredit['becauseOf'] == 'increase') {
                $state = 'charge';
            }elseif ($infoCredit['becauseOf'] == 'decrease'){
                $state = 'buy';
            }else{
                $state = '';
            }
            $credit = str_replace(",", "", $infoCredit['credit']);
            $data ['type_admin'] = $infoCredit['type_admin'];
            $data ['adminId'] = $infoCredit['adminId'];
            $data ['typeAgency'] = $infoCredit['typeAgency'];
            $data ['memberId'] = $infoCredit['memberID'];
            $data['amount'] = $credit;
            $data['factorNumber'] = $factorNumber;
//            $data['type'] = $infoCredit['becauseOf'];
            $data['comment'] = $infoCredit['comment'];
            $data['status'] = 'success';
            $data['state'] = $state;
            $data['reason'] = $infoCredit['becauseOf'];
            $data['creationDateInt'] = time();
//            $data['creationDateInt'] = dateTimeSetting::jdate("Y-m-d", time(),'','','en');
            $result  = $this->usersWalletModel()->insertWithBind($data);
            $last_id = $this->usersWalletModel()->getLastId();

            if ($result) {;
                /*todo : function to insert agency credit in accountant system */

                echo 'success : اعتبار مورد نظر با موفقیت ثبت گردید';

            } else {
                echo 'error :  بروز اشکال در ثبت اعتبار ';
            }

        } else {
            echo 'error : کاربر مورد نظر معتبر نمی باشد';
        }
    }




    public function DecreaseMoneyMember($params) {

        $members = Load::model('members');
        $credit = $members->getMemberCredit($this->user_id);
        $amount =  $params['requested_amount'];

        if ($amount < $credit) {
            if ($credit > 0) {
                $ii = 0;
                $temp = mt_rand(1, 15);
                do {
                    $temp .= mt_rand(0, 15);
                } while (++$ii < 16);
                $uniq = $temp;
                $factorNumber = substr($uniq, 0, 10);
                $dataCredit['memberId'] = $this->user_id;
                $dataCredit['amount'] = ($credit > $amount ? $amount : $credit);
                $dataCredit['card_number'] = $params['card_number'];
                $dataCredit['factorNumber'] = $factorNumber;
                $dataCredit['state'] = 'buy';
                $dataCredit['reason'] = 'credit_deduction';
                $dataCredit['comment'] = 'برداشت نقدی از اعتبار توسط کاربر با شماره فاکتور ' . $factorNumber;
                $dataCredit['status'] = 'pending';
                $addResult = $members->membersCreditAdd($dataCredit);
                if ($addResult) {
                    return 'success :' . functions::Xmlinformation("RequestedDecreaseMoneyOfCredit");
                } else {
                    return 'error : ' . functions::Xmlinformation("Errorrecordinginformation");
                }
            }
        }else{
            return 'error : ' . functions::Xmlinformation("RequestedAmountIsMoreThanCredit");

        }





    }



    public function getAllRequest_old()
    {

        $Model = Load::library('Model');

        $sql_list = "SELECT * FROM members_credit_tb WHERE status='pending' AND state='buy' AND reason='credit_deduction'  ORDER BY creationDateInt DESC";
//        $res_edit   = $Model->select( $sql_list );
//        $sql_user = "SELECT *  FROM members_tb WHERE  id='".$res_edit[0]['memberId']."' ";
//          $member = $Model->load( $sql_user );
//        $sql_list->mamber_name = $member['name'] .' '. $member['family'];

//        echo $sql_list;
        $this->list = $Model->select($sql_list);

    }

    public function getAllRequest($data_main_page = []) {

//        $result = [];
        $itemList = $this->getModel('membersCreditModel')->get()
            ->where('status', 'pending')
            ->where('reason', 'credit_deduction')
            ->where('state', 'buy');
//        $item_table = $itemList->getTable();
        $listItem = $itemList->all(false);
        Load::autoload('Model');
        $Model = new Model();
        foreach ($listItem as $key => $value) {
            $member_query = " SELECT * FROM  members_tb  WHERE id='{$listItem[$key]['memberId']}'";
            $res_member = $Model->load( $member_query );
            $listItem[$key]['mamber_name'] = $res_member['name'] .' '. $res_member['family'];
            $listItem[$key]['mamber_mobile'] = $res_member['mobile'];
        }
        $result = $listItem;
        return $result;
    }

    public function getRequestUserInfo($id , $Param2) {



        $member_credit_model = $this->getModel('membersCreditModel')->get()->where('id', $id)->limit(0, 1);

        $result =  $member_credit_model->all();

        return $result[0];
    }

    public function findBrandById($id) {
        return $this->getModel('membersCreditModel')->get()->where('id', $id)->find();
    }
    public function confirmRequested($data_update) {
        $check_exist_brand = $this->findBrandById($data_update['RequestId']);
        if ($check_exist_brand) {
            $data_update_status['status'] = 'success';
            $condition_update_status ="id='{$check_exist_brand['id']}'";
            $result_update_cat = $this->getModel('membersCreditModel')->updateWithBind($data_update_status,$condition_update_status);
            if ($result_update_cat) {
                return functions::withSuccess('', 200, 'تایید پرداخت با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در تایید پرداخت ');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }
    public function RejectRequested($data_update) {
        $check_exist_brand = $this->findBrandById($data_update['RequestId']);
        if ($check_exist_brand) {
            $data_update_status['status'] = 'rejectAdmin';
            $condition_update_status ="id='{$check_exist_brand['id']}'";
            $result_update_cat = $this->getModel('membersCreditModel')->updateWithBind($data_update_status,$condition_update_status);
            if ($result_update_cat) {
                return functions::withSuccess('', 200, 'درخواست وجه از سمت کاربر تایید نشد');
            }
            return functions::withError('', 400, 'خطا در رد درخواست ');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }



//
//    public function ReturnAdminToWalletUser_old($requestId , $ItemId , $Price , $MemberId) {
//
//        $Model = Load::library('Model');
//         if ($Price != Null || $Price !='') {
//             $price_all = $Price;
//         }else {
//             $price_all = 0;
//         }
//
//        if($requestId){
//            $dataCredit['factorNumber'] = 'TransferCredit'.rand(000,999);
//            $dataCredit['state'] = 'buy';
//            $dataCredit['Reason'] = 'buy';
//            $dataCredit['Comment'] = 'انتقال به اعتبار کاربر به شماره فاکتور '. $dataCredit['factorNumber'].' ';
//            $dataCredit['status'] = 2;
//            $dataCredit['PaymentStatus'] = 'success';
//            $dataCredit['factor_number'] =  $dataCredit['factorNumber'] ;
//            $dataCredit['Price'] =  $price_all ;
//
//            $dataWallet ['memberID'] = $MemberId;
//            $dataWallet['amount'] = $price_all;
//            $dataWallet['factorNumber'] = 'TransferCredit'.rand(000,999);
//            $dataWallet['comment'] = 'انتقال به اعتبار کاربر به شماره فاکتور '. $dataWallet['factorNumber'].' ';
//            $dataWallet['status'] = 'success';
//            $dataWallet['state'] = 'charge';
//            $dataWallet['reason'] = 'increase';
//            $dataWallet['creationDateInt'] = time();
//
////            $result =  $this->getController('accountcharge')->insertCreditUser($dataCredit);
//            $result =  $this->usersWalletModel()->insertWithBind($dataWallet);
//            if ($result) {
//
////                $this->usersWalletModel()->insertWithBind($dataWallet);
//                $data['Status']="ConfirmCancel";
//                $data['DateConfirmClientInt']=time();
//                $data['confirmTransferWallet']=1;
//
//                $Model->setTable('cancel_ticket_details_tb');
//
//                $Condition="id={$ItemId} AND RequestNumber='{$requestId}'";
//                $Model->update($data, $Condition);
//                return functions::withSuccess($Price, 200, 'ثبت درخواست انتقال به اعتبار انجام شد،از این پس اعتبار توسط کاربر قابل استفاده خواهد بود', NULL);
//            }
//        }else{
//            return functions::withError('',401,'خطا در تبدیل انتقال اعتبار به کیف پول کاربر');
//
//        }
//
//    }
//
//




    public function ReturnAdminToWalletUser($data) {

        $Model = Load::library('Model');

        if($data['RequestNumber']){

            $dataWallet ['memberID'] = $data['ClientID'];
            $dataWallet['amount'] = $data['priceBack'];
            $dataWallet['factorNumber'] = 'TransferCredit'.rand(000,999);
            $dataWallet['comment'] = 'انتقال به اعتبار کاربر توسط ادمین به شماره فاکتور '. $dataWallet['factorNumber'].' ';
            $dataWallet['status'] = 'success';
            $dataWallet['state'] = 'charge';
            $dataWallet['reason'] = 'increase';
            $dataWallet['creationDateInt'] = time();
            $result =  $this->usersWalletModel()->insertWithBind($dataWallet);
            if ($result) {
                $dataCancel['Status']="ConfirmCancel";
                $dataCancel['DateConfirmClientInt']=time();
                $dataCancel['confirmTransferWallet']='ReturnWallet';

                $Model->setTable('cancel_ticket_details_tb');

                $Condition="id={$data['ParamId']} AND RequestNumber='{$data['RequestNumber']}'";
                $Model->update($dataCancel, $Condition);
                echo 'Success : انتقال اعتبار به حساب کاربر انجام شد';

            }
        }else{
            echo 'Success : خطا در انتقال اعتبار به کیف پول کاربر';

        }

    }





    public function getAllCreditMember($data_main_page = []) {

//        $result = [];
        $itemList = $this->getModel('membersCreditModel')->get()->orderBy('id' , 'DESC');
//        $item_table = $itemList->getTable();
        $listItem = $itemList->all(false);
        Load::autoload('Model');
        $Model = new Model();
        foreach ($listItem as $key => $value) {
            $member_query = " SELECT * FROM  members_tb  WHERE id='{$listItem[$key]['memberId']}'";
            $res_member = $Model->load( $member_query );

            $admin_query = " SELECT * FROM  members_tb  WHERE id='{$listItem[$key]['adminId']}'";
            $res_admin = $Model->load( $admin_query );

            $listItem[$key]['mamber_name'] = $res_member['name'] .' '. $res_member['family'];
            $listItem[$key]['mamber_mobile'] = $res_member['mobile'];
//            $_SESSION["adminLogin"]
            $listItem[$key]['admin_name'] = $res_admin['name'] .' '. $res_admin['family'];
            $listItem[$key]['admin_id'] = $res_admin['id'];
        }

        $result = $listItem;
        return $result;
    }


    public function ConfirmReturnBankUser($data) {
        $Model = Load::library('Model');

        $check_exist_cancel = $this->getModel('cancelTicketDetailsModel')->get()->where('id', $data['ParamId'])->find();
        if ($check_exist_cancel) {
            $dataCancel['confirmTransferWallet']='ReturnBankCart';
            $dataCancel['DateConfirmClientInt']=time();
            $Model->setTable('cancel_ticket_details_tb');
            $Condition="id={$data['ParamId']} AND RequestNumber='{$data['RequestNumber']}' AND TypeCancel='{$data['TypeCancel']}' AND MemberId='{$data['ClientID']}' ";
            $UpdateResult = $Model->update($dataCancel, $Condition);
//            var_dump($UpdateResult);die;
            if($UpdateResult){
                return "success : در خواست شما با موفقیت انجام شد";
            }
        }
        return "error : درخواست معتبر نمی باشد";


    }


}