<?php
require 'config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require CONFIG_DIR . 'configBase.php';
require LIBRARY_DIR . 'functions.php';
require CONTROLLERS_DIR . 'dateTimeSetting.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));


if (isset($_POST['flag']) && $_POST['flag'] == 'changeListRobot') {
    $servicesTelegram = Load::controller('serviceTelegram');
    unset($_POST['flag']);

    echo $servicesTelegram->updateTelegram($_POST);
}
else if (isset($_POST['flag']) && $_POST['flag'] == 'DeactiveList') {

    $servicesTelegram = Load::controller('serviceTelegram');
    unset($_POST['flag']);

    echo $servicesTelegram->changeonlineTelegram($_POST);
}
else if(isset($_POST['flag']) && $_POST['flag'] == 'createRobot')
{

    $servicesTelegram = Load::controller('serviceTelegram');
    unset($_POST['flag']);

    echo $servicesTelegram->createRobot($_POST);


}
else if(isset($_POST['flag']) && $_POST['flag'] == 'checkUser')
{


    $servicesTelegram = Load::controller('serviceTelegram');
    unset($_POST['flag']);

    echo $servicesTelegram->checkUser($_POST);


}
else if (isset($_POST['flag']) && $_POST['flag'] == 'createListRobot') {

    $servicesTelegram = Load::controller('serviceTelegram');
    unset($_POST['flag']);

    echo $servicesTelegram->createRobot($_POST);
} else if(isset($_POST['flag']) && $_POST['flag'] == 'sendinformationInGroup') {

    $servicesTelegram = Load::controller('serviceTelegram');
    unset($_POST['flag']);

    echo $servicesTelegram->sendInformationData($_POST);


}
else if(isset($_POST['flag']) && $_POST['flag'] == 'sendListRobotInGroup')
{


    $servicesTelegram = Load::controller('serviceTelegram');
    unset($_POST['flag']);

    echo $servicesTelegram->sendDataRobot($_POST);


}
else if(isset($_POST['flag']) && $_POST['flag'] == 'removeRobot')
{

    $servicesTelegram = Load::controller('serviceTelegram');
    unset($_POST['flag']);
    echo $servicesTelegram->removeRobot($_POST);


}else if(isset($_POST['flag']) && $_POST['flag'] == 'insertRouteRobot') {
    $servicesTelegram = Load::controller('manageTelegram');
    unset($_POST['flag']);
    echo $servicesTelegram->insertRouteRobot($_POST);
}


?>