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

if (isset($_POST['flag']) && $_POST['flag'] == 'CheckedLogin') {
    unset($_POST['flag']);
    Load::autoload('apiGashtTransfer');
    $Local = new apiGashtTransfer;
    echo $Local->CheckedLogin();

}

if (isset($_POST['flag']) && $_POST['flag'] == 'gasht_info') {
    $gasht = Load::controller('resultGasht');
    unset($_POST['flag']);
    echo $gasht->saveSelectedGasht($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == "register_memeberGasht") {

    $Local = Load::autoload('apiHotelLocal');
    $Local = new apiHotelLocal();
    $Local->registerPassengerOnline();
}
if (isset($_POST['flag']) && $_POST['flag'] == "GashtReserve") {

    $successFlag = 'FALSE';
    $Model = Load::library('Model');
    $ModelBase = Load::library('ModelBase');
    $queryBook = "SELECT * FROM book_gasht_local_tb WHERE passenger_factor_num = '{$_POST['factorNumber']}'";
    $resultBook = $Model->select($queryBook);

    foreach ($resultBook as $each) {
//



            $successFlag = 'TRUE';

            $dataUpdate['status'] = 'prereserve';
            $Condition = "passenger_factor_num='{$_POST['factorNumber']}'";
            $Model->setTable('book_gasht_local_tb');
            $resultUpdate = $Model->update($dataUpdate, $Condition);

            if($resultUpdate){
                $ModelBase->setTable('report_gasht_tb');
                $ModelBase->update($dataUpdate, $Condition);
            }



    }

    echo $successFlag;


}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'gashtPriceChanges') {

    $priceChanges = Load::controller('gashtPriceChanges');
    unset($_POST['flag']);
    echo $priceChanges->update($_POST);
}



elseif (isset($_POST['flag']) && $_POST['flag'] == 'createExcelFile') {
    unset($_POST['flag']);

    $controller = Load::controller('bookingGasht');
    $result = $controller->createExcelFile($_POST);

    echo $result;
}
?>