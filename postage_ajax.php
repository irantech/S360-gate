<?php
require 'config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require CONFIG_DIR . 'configBase.php';
require LIBRARY_DIR . 'functions.php';
require CONTROLLERS_DIR . 'dateTimeSetting.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));

if (isset($_POST['flag']) && $_POST['flag'] == 'changeAccessResponse') {
    unset($_POST['flag']);

    $controller = Load::controller('postage');
    $result = $controller->changeAccessResponse($_POST);

    echo json_encode($result);
}elseif (isset($_POST['flag']) && $_POST['flag'] == 'postageChangeUserType') {
    unset($_POST['flag']);

    $controller = Load::controller('postage');
    $result = $controller->ChangeUserType($_POST);

    echo json_encode($result);
}