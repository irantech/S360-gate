<?php
require 'config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
require LIBRARY_DIR . 'SimpleXLSX.php';
require CONFIG_DIR . 'application.php';
require LIBRARY_DIR . 'functions.php';
require LIBRARY_DIR . 'Session.php';
require CONTROLLERS_DIR . 'dateTimeSetting.php';

//$xlsx = SimpleXLSX::parse('1.xlsx');
$xlsx = SimpleXLSX::parse('2.xlsx');

$datas = $xlsx->rows();
$dataTotal = array();


//foreach ($datas as $data){
//
//    $dataInsert['name']=$data[5];
//    $dataInsert['family']=$data[6];
//    $dataInsert['mobile']=$data[7];
//    $dataInsert['email']= 'shahedan'.$data[1].'@gmail.com';
//    $dataInsert['password']=functions::encryptPassword($data[1]);
//    $dataInsert['card_number']= '0';
//    $dataInsert['is_member']= '1';
//    $dataInsert['fk_counter_type_id']='5';
//    $dataInsert['fk_agency_id']='0';
//    $dataInsert['TypeOs']='Windows 10';
//    $dataInsert['active']='on';
//    $dataInsert['del']='no';
//    $dataInsert['register_date']= date("Y-m-d H:i:s");
//    $dataInsert['last_modify']=date("Y-m-d H:i:s");
//
//    insertMembers($dataInsert);
//    $dataTotal[] = $dataInsert ;
//}

//it is for 2.xlx
foreach ($datas as $data) {

    $dataInfoPersonal = explode('/', $data[3]);
    if (isset($dataInfoPersonal[0]) && isset($dataInfoPersonal[1])) {
        $dataInsert['name'] = $dataInfoPersonal[0];
        $dataInsert['family'] = $dataInfoPersonal[1];
        $dataInsert['mobile'] = $data[4];
        $dataInsert['email'] = 'shahedan' . $data[1] . '@gmail.com';
        $dataInsert['password'] = functions::encryptPassword($data[1]);
        $dataInsert['card_number'] = '0';
        $dataInsert['fk_counter_type_id'] = '5';
        $dataInsert['fk_agency_id'] = '0';
        $dataInsert['is_member'] = '1';
        $dataInsert['TypeOs'] = 'Windows 10';
        $dataInsert['active'] = 'on';
        $dataInsert['del'] = 'no';
        $dataInsert['register_date'] = date("Y-m-d H:i:s");
        $dataInsert['last_modify'] = date("Y-m-d H:i:s");
        insertMembers($dataInsert);
    }
    $dataTotal[] = $dataInfoPersonal;
}


function generateCardNo()
{

    /** @var admin $admin */
    $admin = Load::controller('admin');
    $sqlConfig = "select MAX(card_number) as MaxCardNo from members_tb";
    $result = $admin->ConectDbClient($sqlConfig, '4', "Select", "", "", "");

    if (!empty($result)) {
        $maxCardNo = $result['MaxCardNo'];
    } else {
        $maxCardNo = 0;
    }

    if ($maxCardNo == 0 || $maxCardNo == 1) {
        $card_number = CLIENT_PRE_CARD_NO . "00000001";
    } else {
        $dynamic_section = substr($maxCardNo, 8, 8) + 1;
        $zero_section = '';
        for ($j = strlen($dynamic_section); $j < 8; $j++) {
            $zero_section .= '0';
        }
        $card_number = CLIENT_PRE_CARD_NO . $zero_section . $dynamic_section;
    }

    return $card_number;

}


function insertMembers($data)
{
    /** @var admin $admin */
    $admin = Load::controller('admin');
    $admin->ConectDbClient('', '187', 'Insert', $data, 'members_tb');

}

echo '<pre>' . print_r($dataTotal, true) . '</pre>';
