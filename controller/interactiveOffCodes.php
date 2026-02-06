<?php

class interactiveOffCodes
{
    public $resultSelectForEdit;

    #region cunstruct
    public function __construct()
    {

    }
    #endregion

    #region listAllGroup: list of all discount codes and count of used
    public function listAllGroup()
    {
        $Model = Load::library('Model');

        $sqlCodes = "SELECT IG.*, 
                    (SELECT COUNT(id) FROM interactive_off_codes_tb WHERE interactiveID = IG.id) AS codesCount, 
                    (SELECT COUNT(id) FROM interactive_off_codes_tb WHERE interactiveID = IG.id AND used = '1') AS usedCount  
                    FROM interactive_groups_tb IG ORDER BY IG.priority";
        $resultSelect = $Model->select($sqlCodes);

        return $resultSelect;
    }
    #endregion

    #region getGroupByID: one specified record of interactive group of off codes
    public function getGroupByID($param)
    {
        $param = filter_var($param, FILTER_VALIDATE_INT);

        $Model = Load::library('Model');
        $sqlSelect = "SELECT * FROM interactive_groups_tb WHERE id='{$param}'";
        return $Model->load($sqlSelect);
    }
    #endregion

    #region getOffCodeByFactorNumber: one specified record of interactive off code by factor number
    public function getOffCodeByFactorNumber($param)
    {
        $param = filter_var($param, FILTER_SANITIZE_NUMBER_INT);

        $Model = Load::library('Model');
        $sqlSelect = "SELECT * FROM interactive_off_codes_tb WHERE factorNumber = '{$param}'";
        return $Model->load($sqlSelect);
    }
    #endregion

    #region offCodesByInteractiveID: list of interactive off codes of a specific group
    public function offCodesByInteractiveID($param)
    {
        $param = filter_var($param, FILTER_VALIDATE_INT);

        $Model = Load::library('Model');
        $sqlSelect = "SELECT IOC.*, CONCAT(M.name, ' ', M.family) AS memberName 
        FROM interactive_off_codes_tb AS IOC LEFT JOIN members_tb M ON IOC.memberID = M.id 
        WHERE IOC.interactiveID = '{$param}'";
        return $Model->select($sqlSelect);
    }
    #endregion

    #region interactiveOffCodesAdd: add a discount code
    public function interactiveOffCodesAdd($param)
    {
        $Model = Load::library('Model');

        $explodeExpireDate = explode('-', filter_var($param['expireDate'], FILTER_SANITIZE_STRING));
        $jmkExpireDate = dateTimeSetting::jmktime(23, 59, 59, $explodeExpireDate[1], $explodeExpireDate[2], $explodeExpireDate[0]);

        //priority
        $priorityController = Load::controller('priority');
        $priorityController->init('interactive_groups_tb', 'priority');

        $data['title'] = filter_var($param['title'], FILTER_SANITIZE_STRING);
        $data['expireDateInt'] = $jmkExpireDate;
        $data['originIata'] = json_encode($param['origin']);
        $data['destinationIata'] = json_encode($param['destination']);
        $data['priority'] = $priorityController->getMaxPriority() + 1;
        $data['creationDateInt'] = time();

        $Model->setTable('interactive_groups_tb');
        $resultInsert = $Model->insertLocal($data);

        if($resultInsert) {

            $insertedID = $Model->getLastId();

            //services
            $servicesDiscount = Load::controller('servicesDiscount');
            $servicesDiscount->getAllServices();

            foreach ($servicesDiscount->services as $service) {
                if (isset($_POST['Check' . $service['TitleEn']]) && $_POST['Check' . $service['TitleEn']] == '1') {

                    $dataServices['interactiveID'] = $insertedID;
                    $dataServices['serviceTitle'] = $service['TitleEn'];

                    $Model->setTable('interactive_services_tb');
                    $Model->insertLocal($dataServices);

                }
            }

            //off codes
            if(!empty($_FILES['excelCodes'])) {
                $excel = Load::library('importFromExcel');
                $excelContent = $excel->getFile($_FILES['excelCodes']['tmp_name']);

                foreach ($excelContent as $row) {
                    foreach ($row as $col) {
                        if(!empty($col)) {
                            $dataOffCode['interactiveID'] = $insertedID;
                            $dataOffCode['offCode'] = $col;
                            $dataOffCode['creationDateInt'] = time();

                            $Model->setTable('interactive_off_codes_tb');
                            $Model->insertLocal($dataOffCode);
                        }
                    }
                }
            }

        }

        if ($resultInsert) {
            $output['result_status'] = 'success';
            $output['result_message'] = 'افزودن کدهای تخفیف با موفقیت انجام شد';

        } else {
            $output['result_status'] = 'error';
            $output['result_message'] = 'خطا در فرایند افزودن کدهای تخفیف';
        }

        return $output;
    }
    #endregion

    #region interactiveOffCodesEdit: edit a discount code
    public function interactiveOffCodesEdit($param)
    {
        $param['id'] = filter_var($param['id'], FILTER_VALIDATE_INT);
        $param['priority'] = filter_var($param['priority'], FILTER_VALIDATE_INT);

        $Model = Load::library('Model');
        $sqlExist = "SELECT id FROM interactive_groups_tb WHERE id = '{$param['id']}'";
        $resultExist = $Model->load($sqlExist);

        if (!empty($resultExist)):

            $explodeExpireDate = explode('-', filter_var($param['expireDate'], FILTER_SANITIZE_STRING));
            $jmkExpireDate = dateTimeSetting::jmktime(23, 59, 59, $explodeExpireDate[1], $explodeExpireDate[2], $explodeExpireDate[0]);

            $data['title'] = filter_var($param['title'], FILTER_SANITIZE_STRING);
            $data['expireDateInt'] = $jmkExpireDate;
            $data['originIata'] = json_encode($param['origin']);
            $data['destinationIata'] = json_encode($param['destination']);
            $data['lastEditInt'] = time();

            $Condition = "id='{$param['id']}'";
            $Model->setTable('interactive_groups_tb');
            $resultUpdate = $Model->update($data, $Condition);

            //priority
            $priorityController = Load::controller('priority');
            $priorityController->init('interactive_groups_tb', 'priority');
            $priorityController->updatePriority('id', $param['id'], $param['priority']);

            $servicesDiscount = Load::controller('servicesDiscount');
            $servicesDiscount->getAllServices();

            //services
            $selectedServices = array();
            foreach ($servicesDiscount->services as $service) {
                if (isset($_POST['Check' . $service['TitleEn']]) && $_POST['Check' . $service['TitleEn']] == '1') {

                    array_push($selectedServices, $service['TitleEn']);

                }
            }

            foreach ($servicesDiscount->services as $service) {

                if (in_array($service['TitleEn'], $selectedServices) && !$this->HasThisService($param['id'], $service['TitleEn'])) {
                    $dataServices['interactiveID'] = $param['id'];
                    $dataServices['serviceTitle'] = $service['TitleEn'];

                    $Model->setTable('interactive_services_tb');
                    $Model->insertLocal($dataServices);
                } elseif (!in_array($service['TitleEn'], $selectedServices) && $this->HasThisService($param['id'], $service['TitleEn'])) {
                    $Model->setTable('interactive_services_tb');
                    $Model->delete(" interactiveID = '{$param['id']}' AND serviceTitle = '{$service['TitleEn']}' ");
                }

            }

            //off codes
            if(!empty($_FILES['excelCodes'])) {
                $excel = Load::library('importFromExcel');
                $excelContent = $excel->getFile($_FILES['excelCodes']['tmp_name']);

                foreach ($excelContent as $row) {
                    foreach ($row as $col) {

                        if(!empty($col) && !$this->HasThisOffCode($param['id'], $col)){

                            $dataOffCode['interactiveID'] = $param['id'];
                            $dataOffCode['offCode'] = $col;
                            $dataOffCode['creationDateInt'] = time();

                            $Model->setTable('interactive_off_codes_tb');
                            $Model->insertLocal($dataOffCode);
                        }
                    }
                }
            }

            if ($resultUpdate) {
                $output['result_status'] = 'success';
                $output['result_message'] = 'ویرایش کدهای تخفیف با موفقیت انجام شد';

            } else {
                $output['result_status'] = 'error';
                $output['result_message'] = 'خطا در فرایند ویرایش کدهای تخفیف';
            }

        else:
            $output['result_status'] = 'error';
            $output['result_message'] = 'خطا در ویرایش کدهای تخفیف، گروه کد تخفیف مورد نظر یافت نشد';
        endif;

        return $output;
    }
    #endregion

    #region HasThisService: check if a interactive off code has a specified service
    public function HasThisService($interactiveID ,$serviceTitle)
    {
        $Model = Load::library('Model');

        $interactiveID = filter_var($interactiveID, FILTER_VALIDATE_INT);
        $serviceTitle = filter_var($serviceTitle, FILTER_SANITIZE_STRING);

        $sqlExist = "SELECT id FROM interactive_services_tb WHERE interactiveID = '{$interactiveID}' AND serviceTitle = '{$serviceTitle}'";
        $resultSelect = $Model->load($sqlExist);

        if(Empty($resultSelect)){
            return false;
        } else{
            return true;
        }
    }
    #endregion

    #region HasThisOffCode: check if a interactive off code has a specified off code
    public function HasThisOffCode($interactiveID, $offCode)
    {
        $Model = Load::library('Model');

        $interactiveID = filter_var($interactiveID, FILTER_VALIDATE_INT);
        $offCode = filter_var($offCode, FILTER_SANITIZE_STRING);

        $sqlExist = "SELECT id FROM interactive_off_codes_tb WHERE interactiveID = '{$interactiveID}' AND offCode = '{$offCode}'";
        $resultSelect = $Model->load($sqlExist);

        if(Empty($resultSelect)){
            return false;
        } else{
            return true;
        }
    }
    #endregion

    #region offCodeUse: alocate an off code to a user
    public function offCodeUse($factorNumber, $serviceTitle, $destination, $origin = '')
    {
        /*if(Session::IsLogin()) {*/

           if(Session::getUserId() > 0)
           {
               $userId = Session::getUserId();
           }else{
               $userId = $_SESSION['userCostumer'];
           }
            $memberInfo = functions::infoMember($userId);
            if(/*$memberInfo['is_member'] == '1' &&*/ $memberInfo['fk_counter_type_id'] == '5' ) {

                $Model = Load::library('Model');

                $jdate = dateTimeSetting::jdate("Y/m/d", time());
                $ex = explode("/", $jdate);
                $today = dateTimeSetting::jmktime(0, 0, 0, $ex[1], $ex[2], $ex[0]);

                $originCondition = '';
                if ($origin != '') {
                    $originCondition = "IG.originIata LIKE '%{$origin}%' OR ";
                }

                $sqlSelect = "SELECT IG.id, IG.title, IOC.offCode, IOC.id AS offID
                FROM interactive_groups_tb IG INNER JOIN interactive_off_codes_tb IOC ON IG.id = IOC.interactiveID
                INNER JOIN interactive_services_tb IST ON IG.id = IST.interactiveID 
                WHERE IOC.used != '1' AND IST.serviceTitle = '{$serviceTitle}' AND IG.expireDateInt > '{$today}'
                AND ({$originCondition} IG.destinationIata LIKE '%{$destination}%')
                ORDER BY IG.priority, IOC.id LIMIT 0,1";
                $result = $Model->load($sqlSelect);

                if (!empty($result)) {

                    $data['used'] = '1';
                    $data['memberID'] = Session::getUserId();
                    $data['factorNumber'] = $factorNumber;
                    $data['lastEditInt'] = time();

                    $Condition = "id = '{$result['offID']}'";
                    $Model->setTable('interactive_off_codes_tb');
                    $Model->update($data, $Condition);

                    $output['code'] = $result['offCode'];
                    $output['title'] = $result['title'];

                    //sms
                    $smsController = Load::controller('smsServices');
                    $objSms = $smsController->initService('0');
                    if($objSms) {
                        $messageVariables = array(
                            'sms_name' => $memberInfo['name'] . ' ' . $memberInfo['family'],
                            'sms_interactive_title' => $output['title'],
                            'sms_interactive_code' => $output['code'],
                            'sms_agency' => CLIENT_NAME,
                            'sms_agency_mobile' => CLIENT_MOBILE,
                            'sms_agency_phone' => CLIENT_PHONE,
                            'sms_agency_email' => CLIENT_EMAIL,
                            'sms_agency_address' => CLIENT_ADDRESS,
                        );
                        $smsArray = array(
                            'smsMessage' => $smsController->getUsableMessage('interactiveOffCode', $messageVariables),
                            'cellNumber' => $memberInfo['mobile'],
                            'smsMessageTitle' => 'interactiveOffCode',
                            'memberID' => (!empty($memberInfo['id']) ? $memberInfo['id'] : ''),
                            'receiverName' => $messageVariables['sms_name'],
                        );
                        $smsController->sendSMS($smsArray);
                    }

                    return $output;
                }

                return '';
            }

            /*return '';*/
       /* }else{

        }*/

        /*return '';*/
    }
    #endregion

    #region getReSendableGroups
    public function getReSendableGroups($factorNumber, $memberID, $serviceTitle, $destination, $origin = '')
    {
        $memberInfo = functions::infoMember($memberID);
        if($memberInfo['is_member'] == '1' && ($memberInfo['fk_counter_type_id'] == '1' || $memberInfo['fk_counter_type_id'] == '5')) {

            $Model = Load::library('Model');

            $jdate = dateTimeSetting::jdate("Y/m/d", time());
            $ex = explode("/", $jdate);
            $today = dateTimeSetting::jmktime(0, 0, 0, $ex[1], $ex[2], $ex[0]);

            $originCondition = '';
            if ($origin != '') {
                $originCondition = "IG.originIata LIKE '%{$origin}%' OR ";
            }

            $sqlSelect = "SELECT IG.id, IG.title
                    FROM interactive_groups_tb IG INNER JOIN interactive_off_codes_tb IOC ON IG.id = IOC.interactiveID
                    INNER JOIN interactive_services_tb IST ON IG.id = IST.interactiveID 
                    WHERE IOC.used != '1' AND IST.serviceTitle = '{$serviceTitle}' AND IG.expireDateInt > '{$today}'
                    AND ({$originCondition} IG.destinationIata LIKE '%{$destination}%')
                    AND IOC.interactiveID NOT IN(SELECT interactiveID FROM interactive_off_codes_tb WHERE factorNumber = '{$factorNumber}')
                    GROUP BY IG.id
                    ORDER BY IG.priority";
            $result = $Model->select($sqlSelect);

            if(!empty($result)){
                return $result;
            }

            return '';
        }

        return '';
    }
    #endregion

    #region reSendOffCode
    public function reSendOffCode($param)
    {
        $Model = Load::library('Model');
        $memberInfo = functions::infoMember($param['memberID']);

        $sqlSelect = "SELECT IOC.id, IOC.offCode, IG.title FROM interactive_off_codes_tb IOC 
                    INNER JOIN interactive_groups_tb IG ON IOC.interactiveID = IG.id
                    WHERE IOC.interactiveID = '{$param['offCodeGroup']}' AND IOC.used != '1' 
                    ORDER BY IOC.id LIMIT 0,1";
        $result = $Model->load($sqlSelect);

        if(!empty($result)) {

            $data['used'] = '1';
            $data['memberID'] = $param['memberID'];
            $data['factorNumber'] = $param['factorNumber'];
            $data['lastEditInt'] = time();

            $Condition = "id = '{$result['id']}'";
            $Model->setTable('interactive_off_codes_tb');
            $Model->update($data, $Condition);

            //sms
            $smsController = Load::controller('smsServices');
            $objSms = $smsController->initService('0');
            if ($objSms) {
                $messageVariables = array(
                    'sms_name' => $memberInfo['name'] . ' ' . $memberInfo['family'],
                    'sms_interactive_title' => $result['title'],
                    'sms_interactive_code' => $result['offCode'],
                    'sms_agency' => CLIENT_NAME,
                    'sms_agency_mobile' => CLIENT_MOBILE,
                    'sms_agency_phone' => CLIENT_PHONE,
                    'sms_agency_email' => CLIENT_EMAIL,
                    'sms_agency_address' => CLIENT_ADDRESS,
                );
                $smsArray = array(
                    'smsMessage' => $smsController->getUsableMessage('interactiveOffCode', $messageVariables),
                    'cellNumber' => $memberInfo['mobile'],
                    'smsMessageTitle' => 'interactiveOffCode',
                    'memberID' => (!empty($memberInfo['id']) ? $memberInfo['id'] : ''),
                    'receiverName' => $messageVariables['sms_name'],
                );
                $smsController->sendSMS($smsArray);
            }

            $output['result_status'] = 'success';
            $output['result_message'] = 'پیامک کد ترانسفر با موفقیت به خریدار ارسال شد';

        } else{
            $output['result_status'] = 'error';
            $output['result_message'] = 'متاسفانه کدهای گروه انتخاب شده به پایان رسیده';
        }

        return $output;
    }
    #endregion
}