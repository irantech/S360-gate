<?php

session_start();


if(isset($_POST['captchaAjax'])) {

    require_once dirname(__FILE__) . '/securimage.php';
    $securimage = new Securimage();

	$captchaInput = $_POST['captchaAjax'];

//	$captchaInput = $securimage->persianToEnglish($captchaInput);

    if ($securimage->check($captchaInput) == false) {
        echo false;
        
    } else {
        echo true;
    }
    $securimage->createCode();
}
