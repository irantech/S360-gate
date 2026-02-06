<?php 
require 'config/bootstrap.php';
require CONFIG_DIR.'config.php';
require 'library/Load.php';
spl_autoload_register(array('Load', 'autoload'));

$modelLocal=Load::model('temporary_local');
$modelLocal->delete();

$modelPortal=Load::model('temporary_portal');
$modelPortal->delete();
?>


