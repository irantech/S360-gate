<?php
/**
 * Class smsPanel
 * @property smsPanel $smsPanel
 */
class smsPanel
{
    #region cunstruct
    public function __construct()
    {

    }
    #endregion

    #region getAllSmsServices: get list of all sms services
    public function getAllSmsServices()
    {
        $ModelBase = Load::library('ModelBase');

        $sqlSelect = "SELECT * FROM sms_services_tb";
        return $ModelBase->select($sqlSelect);
    }
    #endregion

    #region setSmsService: set a sms service to customer
    public function setSmsService($param)
    {

        $clientID = filter_var($param['clientID'], FILTER_VALIDATE_INT);

        $data['smsService'] = filter_var($param['smsService'], FILTER_SANITIZE_STRING);
        $data['smsUsername'] = filter_var($param['smsUsername'], FILTER_SANITIZE_STRING);
        $data['smsPassword'] = filter_var($param['smsPassword'], FILTER_SANITIZE_STRING);
        $data['smsNumber'] = filter_var($param['smsNumber'], FILTER_SANITIZE_STRING);
        $data['isActive'] = filter_var($param['isActive'], FILTER_VALIDATE_INT);
        $data['token'] = filter_var($param['token'], FILTER_SANITIZE_STRING);
        $data['patternCode'] = json_encode($param['pattern']);

        if(!empty($clientID)){

            $result = $this->getSmsService($clientID);
            $admin = Load::controller('admin');

            if(!empty($result)){

                $data['lastEditInt'] = time();
                $condition = "id='{$result['id']}'";
                $resultInsert = $admin->ConectDbClient('', $clientID, 'Update', $data, 'sms_service_info_tb', $condition);

                if ($resultInsert) {
                    $output['result_status'] = 'success';
                    $output['result_message'] = 'ویرایش سرویس پیامک با موفقیت انجام شد';
                } else {
                    $output['result_status'] = 'error';
                    $output['result_message'] = 'خطا در فرایند ویرایش سرویس پیامک';
                }

            } else{
                $data['creationDateInt'] = time();
                $resultInsert = $admin->ConectDbClient('', $clientID, 'Insert', $data, 'sms_service_info_tb', '');

                if ($resultInsert) {
                    $output['result_status'] = 'success';
                    $output['result_message'] = 'افزودن سرویس پیامک با موفقیت انجام شد';
                } else {
                    $output['result_status'] = 'error';
                    $output['result_message'] = 'خطا در فرایند افزودن سرویس پیامک';
                }
            }
        } else {
            $output['result_status'] = 'error';
            $output['result_message'] = 'خطا در فرایند ویرایش سرویس پیامک';
        }

        return $output;
    }
    #endregion

    #region setSmsService: set a sms service to customer
    public function getSmsService($clientID)
    {
        $clientID = filter_var($clientID, FILTER_VALIDATE_INT);
        $admin = Load::controller('admin');

        $sql = "SELECT * FROM sms_service_info_tb WHERE isActive='1' LIMIT 0,1";
        return $admin->ConectDbClient($sql, $clientID, 'Select', '', '', '');
    }
    #endregion

    #region allMessages: list of all sms messages
    public function allMessages($custom = '')
    {
        $condition = '';
        if($custom != '' && $custom == '1'){
            $condition = "WHERE isActive = 'yes' AND smsUsage = 'custom'";
        }

        $Model = Load::library('Model');

        $sqlSelect = "SELECT * FROM sms_message_tb {$condition}";
        return $Model->select($sqlSelect);
    }
    #endregion

    #region getMessageByID: get one specified record of sms message by id
    public function getMessageByID($param)
    {
        $Model = Load::library('Model');

        $param = filter_var($param, FILTER_VALIDATE_INT);

        $sqlSelect = "SELECT * FROM sms_message_tb WHERE id='{$param}'";
        return $Model->load($sqlSelect);
    }
    #endregion

    #region getMessageByUsage: get one specified record of sms message by smsUsage
    public function getMessageByUsage($param)
    {
        $Model = Load::library('Model');

        $param = filter_var($param, FILTER_SANITIZE_STRING);

        $sqlSelect = "SELECT * FROM sms_message_tb WHERE isActive = 'yes' AND smsUsage='{$param}'";
        return $Model->load($sqlSelect);
    }
    #endregion

    #region messageUsages: list of all sms message usages
    public function messageUsages()
    {
        $usages = array(
            'welcome' => 'خوش آمدگویی پس از ثبت نام',
            'birthday' => 'تبریک تولد',
            'afterReserveToManager' => 'پس از هر خرید به مدیر سایت',
            'afterTicketReserve' => 'پس از خرید بلیط',
            'cancelRequestTicketToManager' => 'اعلام درخواست کنسلی بلیط به مدیر سایت',
            'cancelConfirmTicket' => 'پس از تایید درخواست کنسلی بلیط به مسافر',
            'afterInsuranceReserve' => 'پس از خرید بیمه',
            'onRequestHotel' => 'در هنگام آفلاین شدن هتل به مسافر',
            'onRequestHotelToManager' => 'در هنگام آفلاین شدن هتل به مدیر سایت',
            'onRequestConfirm' => 'پس از تایید ظرفیت هتل توسط مدیر سایت',
            'onRequestNoConfirm' => 'پس از عدم تایید ظرفیت هتل توسط مدیر سایت',
            'afterHotelReserve' => 'پس از خرید قطعی هتل',
            'afterHotelPreReservePayment' => 'پس از پیش رزرو هتل',
            'afterHotelReserveToManager' => 'پس از خرید قطعی هتل به مدیر سایت',
            'afterVisaReserve' => 'پس از خرید ویزا',
            'interactiveOffCode' => 'ارسال کد ترانسفر',
            'temporaryReservationEuropcare' => 'پس از رزرو موقت اجاره خودرو',
            'bookedSuccessfullyEuropcar' => 'پس از رزرو قطعی اجاره خودرو',
            'cancellationEuropcar' => 'پس از کنسلی رزرو اجاره خودرو',
            'noShowEuropcar' => 'پس از noShow شدن رزرو اجاره خودرو',
//            'temporaryReservationTour' => 'پس از پیش رزرو تور',
            'bookedSuccessfullyTour' => 'پس از رزرو قطعی تور',
            'confirmTourReserve' => 'پس از تایید تور توسط کارگزار',
            'confirmCancelTourReserve' => 'پس از تایید کنسلی تور توسط کارگزار',
            'bookedSuccessfullyGasht' => 'پس از رزرو قطعی گشت',
            'bookedSuccessfullyBus' => 'پس از رزرو قطعی اتوبوس',
            'custom' => 'متفرقه',
            'memberLogin' => 'ورود کاربر به پنل',
        );

        return $usages;
    }
    #endregion

    #region messageAdd: add a message
    public function messageAdd($param)
    {
        $data['title'] = filter_var($param['title'], FILTER_SANITIZE_STRING);
        $data['smsUsage'] = filter_var($param['smsUsage'], FILTER_SANITIZE_STRING);
        $data['body'] = filter_var($param['body'], FILTER_SANITIZE_STRING);
        $data['creationDateInt'] = time();

        $usage = $this->getMessageByUsage($data['smsUsage']);
        if($data['smsUsage'] == 'custom' || ($data['smsUsage'] != 'custom' && empty($usage))) {

            $Model = Load::library('Model');
            $Model->setTable('sms_message_tb');
            $resultInsert = $Model->insertLocal($data);

            if ($resultInsert) {
                $output['result_status'] = 'success';
                $output['result_message'] = 'افزودن متن پیامک با موفقیت انجام شد';
            } else {
                $output['result_status'] = 'error';
                $output['result_message'] = 'خطا در فرایند افزودن متن پیامک';
            }
        } else {
            $output['result_status'] = 'error';
            $output['result_message'] = 'برای کاربرد وارد شده تنها می توانید یک پیامک تعریف نمایید';
        }

        return $output;
    }
    #endregion

    #region messageEdit: edit a message
    public function messageEdit($param)
    {
        $param['id'] = filter_var($param['id'], FILTER_VALIDATE_INT);
        $data['smsUsage'] = filter_var($param['smsUsage'], FILTER_SANITIZE_STRING);

        $Model = Load::library('Model');
        $sqlExist = "SELECT (SELECT id FROM sms_message_tb WHERE id = '{$param['id']}') AS existID,
                      (SELECT COUNT(id) FROM sms_message_tb WHERE isActive = 'yes' AND smsUsage='{$data['smsUsage']}' AND id != '{$param['id']}') AS noRepeat";
        $resultSelect = $Model->load($sqlExist);

        if(!empty($resultSelect['existID'])) {

            if($resultSelect['noRepeat'] == 0) {

                $data['title'] = filter_var($param['title'], FILTER_SANITIZE_STRING);
                $data['body'] = filter_var($param['body'], FILTER_SANITIZE_STRING);
                $data['lastEditInt'] = time();

                $Condition = "id='{$param['id']}'";
                $Model->setTable('sms_message_tb');
                $resultInsert = $Model->update($data, $Condition);

                if ($resultInsert) {
                    $output['result_status'] = 'success';
                    $output['result_message'] = 'ویرایش متن پیامک با موفقیت انجام شد';
                } else {
                    $output['result_status'] = 'error';
                    $output['result_message'] = 'خطا در فرایند ویرایش متن پیامک';
                }

            } else {
                $output['result_status'] = 'error';
                $output['result_message'] = 'برای کاربرد وارد شده تنها می توانید یک پیامک تعریف نمایید';
            }

        } else{
            $output['result_status'] = 'error';
            $output['result_message'] = 'خطا در ویرایش متن پیامک، پیام مورد نظر یافت نشد';
        }

        return $output;
    }
    #endregion

    #region activateMessage: active or deactive a message
    public function activateMessage($param)
    {
        $param['id'] = filter_var($param['id'], FILTER_VALIDATE_INT);

        $Model = Load::library('Model');
        $sql = "SELECT SM.*, 
                (SELECT COUNT(id) FROM sms_message_tb WHERE isActive = 'yes' AND smsUsage = SM.smsUsage AND id != SM.id) AS existActive
                FROM sms_message_tb AS SM WHERE SM.id='{$param['id']}'";
        $rec = $Model->load($sql);

        if(!($rec['isActive'] == 'no' && $rec['existActive'] > 0)) {
            if ($rec['isActive'] == 'yes') {
                $data['isActive'] = 'no';
            } else {
                $data['isActive'] = 'yes';
            }

            $Model->setTable('sms_message_tb');
            $res = $Model->update($data, "id='{$rec['id']}'");

            if ($res) {
                $output['result_status'] = 'success';
                $output['result_message'] = 'وضعیت پیامک با موفقیت تغییر یافت';
            } else {
                $output['result_status'] = 'error';
                $output['result_message'] = 'خطا در فرایند تغییر وضعیت پیامک';
            }
        } else {
            $output['result_status'] = 'error';
            $output['result_message'] = 'برای کاربرد مذکور یک پیام فعال دیگر وجود دارد، ابتدا آن را غیرفعال کنید';
        }

        return $output;
    }
    #endregion

    #region getManualReceiverGroups
    public function getManualReceiverGroups()
    {
        $receivers = array();

        $memberGroups = Load::controller('memberGroups');
        $groupsList = $memberGroups->ListAll();

        foreach ($groupsList as $item){
            $receivers[$item['id']] = $item['title'];
        }

//        $receivers[''] = 'افرادی که خدمات x را خریداری کرده اند';
//        $receivers[''] = 'افرادی که خدمات x را خریداری نکرده اند';
        $receivers['guests'] = 'خریداران مهمان';
        $receivers['custom'] = 'شماره همراه';
        $receivers['all'] = 'همه';

        return $receivers;
    }
    #endregion

    #region getReportNewSameID
    public function getReportNewSameID()
    {
        $Model = Load::library('Model');

        $query = "SELECT COALESCE((SELECT MAX(sameID) + 1 FROM sms_reports_tb), 1) AS sameID";
        $result = $Model->load($query);
        return $result['sameID'];
    }
    #endregion

    #region getGroupReports
    public function getGroupReports($type)
    {


        $sendType = filter_var($type, FILTER_SANITIZE_STRING);

        if($sendType == 'manual'){
            $sendType = 'manual';
        } else{
            $sendType = 'auto';
        }

        $Model = Load::library('Model');
        $query = "SELECT report.*,
                   blt.pnr as pnr_number
            FROM sms_reports_tb AS report
            LEFT JOIN book_local_tb blt 
                ON report.request_number = blt.request_number
            WHERE report.sendType = '{$sendType}'
            AND report.id = (
                SELECT MAX(id)
                FROM sms_reports_tb
                WHERE sameID = report.sameID
            )
            ORDER BY report.creationDateInt DESC
            LIMIT 50
";


        return $Model->select($query);
    }
    #endregion

    #region getReportsBySameID
    public function getReportsBySameID($sameID)
    {

        $sameID = filter_var($sameID, FILTER_VALIDATE_INT);

        $Model = Load::library('Model');
        $query = "SELECT * FROM sms_reports_tb WHERE sameID = '{$sameID}'";
        $result = $Model->select($query);
        foreach ($result as $item){
            if($item['sendStatus'] == '1') {
                $this->checkReportDelivery($item['sendSuccessCode']);
            }
        }

        return $Model->select($query);
    }
    #endregion

    #region checkReportDelivery
    public function checkReportDelivery($successCode)
    {
	    /** @var smsServices $smsServices */
	    $smsServices = Load::controller('smsServices');
        $objSms      = $smsServices->initService(0);
        if($objSms) {
            $smsServices->checkDelivery($successCode);
        }
    }
    #endregion

}