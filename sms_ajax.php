<?php

$array_special_char = ["\n", "‘", "’", "“", "”", "„" , "(", ")", "<", ">","</","/>","alert","+","from","sleep"] ;
foreach ($_POST as $key=>$item) {
    $item_after_replace[$key] = str_replace($array_special_char, '', $item);

    $_POST[$key] = $item_after_replace[$key];
}

require 'config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require CONFIG_DIR . 'configBase.php';
require LIBRARY_DIR . 'functions.php';
require CONTROLLERS_DIR . 'dateTimeSetting.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));

if (isset($_POST['flag']) && $_POST['flag'] == 'memberGroupsAdd') {

    $controller = Load::controller('memberGroups');
    unset($_POST['flag']);
    $result = $controller->groupsAdd($_POST);

    echo json_encode($result);
}

elseif (isset($_POST['flag']) && $_POST['flag'] == 'memberGroupsEdit') {

    $controller = Load::controller('memberGroups');
    unset($_POST['flag']);
    $result = $controller->groupsEdit($_POST);

    echo json_encode($result);
}

elseif (isset($_POST['flag']) && $_POST['flag'] == 'setMmembersGroup') {

    $controller = Load::controller('memberGroups');
    unset($_POST['flag']);
    $result = $controller->setMmembersGroup($_POST);

    echo json_encode($result);
}

elseif (isset($_POST['flag']) && $_POST['flag'] == 'messageAdd') {

    $controller = Load::controller('smsPanel');
    unset($_POST['flag']);
    $result = $controller->messageAdd($_POST);

    echo json_encode($result);
}

elseif (isset($_POST['flag']) && $_POST['flag'] == 'messageEdit') {

    $controller = Load::controller('smsPanel');
    unset($_POST['flag']);
    $result = $controller->messageEdit($_POST);

    echo json_encode($result);
}

if (isset($_POST['flag']) && $_POST['flag'] == 'activateMessage') {

    $controller = Load::controller('smsPanel');
    unset($_POST['flag']);
    $result = $controller->activateMessage($_POST);

    echo json_encode($result);
}

elseif (isset($_POST['flag']) && $_POST['flag'] == 'setSmsService') {

    $controller = Load::controller('smsPanel');
    unset($_POST['flag']);
    $result = $controller->setSmsService($_POST);

    echo json_encode($result);
}

elseif (isset($_POST['flag']) && $_POST['flag'] == 'messageSend') {

    unset($_POST['flag']);
    $arg = array(
        'smsReceiver' => FILTER_SANITIZE_STRING,
        'smsMessage' => FILTER_VALIDATE_INT,
        'smsNumber' => FILTER_SANITIZE_STRING,
    );
    $dataPost = filter_var_array($_POST, $arg);

    //message
    $smsPanel = Load::controller('smsPanel');
    $resultMessage = $smsPanel->getMessageByID($dataPost['smsMessage']);

    //receivers
    if($dataPost['smsReceiver'] == 'custom'){ //custom number entered

        $smsNumber = explode(';', $dataPost['smsNumber']);
        foreach ($smsNumber as $key => $item){
            $receivers[$key]['mobile'] = $item;
        }

    } elseif (is_numeric($dataPost['smsReceiver'])){ //choose from one of member groups

        $memberGroups = Load::controller('memberGroups');
        $receivers = $memberGroups->getGroupMembers($dataPost['smsReceiver']);

    } elseif ($dataPost['smsReceiver'] == 'guests'){ //choose guest members who buy s.th

        $membersController = Load::controller('members');
        $receivers = $membersController->getGuestUser();

    } elseif ($dataPost['smsReceiver'] == 'all'){ //choose all members not guests

        $membersController = Load::controller('members');
        $receivers = $membersController->getMembers();

    }

    //sms
    $smsController = Load::controller('smsServices');
    $objSms = $smsController->initService('0');
    if($objSms) {

        $sendTo = $smsPanel->getManualReceiverGroups();
        $sameID = $smsPanel->getReportNewSameID();

        foreach ($receivers as $member) {
            if(trim($member['mobile']) != '') {
                $messageVariables = array(
                    'sms_name' => (!empty($member['name']) ? $member['name'] . ' ' . $member['family'] : ''),
                    'sms_username' => (!empty($member['email']) ? $member['email'] : ''),
                    'sms_reagent_code' => (!empty($member['reagent_code']) ? $member['reagent_code'] : ''),
                    'sms_agency' => CLIENT_NAME,
                    'sms_agency_mobile' => CLIENT_MOBILE,
                    'sms_agency_phone' => CLIENT_PHONE,
                    'sms_agency_email' => CLIENT_EMAIL,
                    'sms_agency_address' => CLIENT_ADDRESS,
                );
                $smsArray = array(
                    'smsMessage' => $smsController->provideMessageToSend($resultMessage['body'], $messageVariables),
                    'cellNumber' => $member['mobile'],
                    'smsMessageTitle' => $resultMessage['title'],
                    'memberID' => (!empty($member['id']) ? $member['id'] : ''),
                    'receiverName' => $messageVariables['sms_name'],
                    'sendType' => 'manual',
                    'sendTo' => $sendTo[$dataPost['smsReceiver']],
                    'sameID' => $sameID,
                );
                $smsController->sendSMS($smsArray);
            }
        }
    }

    $output['result_status'] = 'success';
    $output['result_message'] = 'عملیات مورد نظر انجام شد، برای اطلاع از نتیجه ارسال لطفا به صفحه گزارش های پیامک مراجعه نمایید';

    echo json_encode($output);
}

elseif (isset($_POST['flag']) && $_POST['flag'] == 'creditAdd') {

    if(Session::IsLogin()) {
        $model = Load::model('members');
        unset($_POST['flag']);

        $data['memberId'] = Session::getUserId();
        $data['amount'] = filter_var($_POST['amount'], FILTER_VALIDATE_INT);
        $data['factorNumber'] = substr(time(), 0, 4) . mt_rand(00000, 99999) . substr(time(), 6, 10);
        $data['state'] = 'charge';
        $data['reason'] = 'charge';
        $data['comment'] = (!empty($_POST['comment']) ? filter_var($_POST['comment'], FILTER_SANITIZE_STRING) : 'شارژ کیف پول الکترونیکی با شماره فاکتور ' . $data['factorNumber']);
        $data['status'] = 'pending';
        $addResult = $model->membersCreditAdd($data);

        if($addResult) {
            $result['result_status'] = 'success';
            $result['result_message'] = 'در حال اتصال به بانک';
            $result['result_factor_number'] = $data['factorNumber'];
        }
    } else{
        $result['result_status'] = 'error';
        $result['result_message'] = 'متأسفانه شما باید ابتدا وارد پنل باشگاه مشتریان شوید';
    }

    echo json_encode($result);
}

?>