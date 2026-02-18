<?php
// enable extension=php_mcrypt.dll AND extension=php_soap.dll AND extension=php_openssl.dll on php.ini

date_default_timezone_set('Asia/Tehran');

function addpadding($string, $blocksize = 32) {
    $len = strlen($string);
    $pad = $blocksize - ($len % $blocksize);
    $string .= str_repeat(chr($pad), $pad);
    return $string;
}

function strippadding($string) {
    $slast = ord(substr($string, -1));
    $slastc = chr($slast);
    $pcheck = substr($string, -$slast);
    if (preg_match("/$slastc{" . $slast . "}/", $string)) {
        $string = substr($string, 0, strlen($string) - $slast);
        return $string;
    } else {
        return false;
    }
}

function encrypt($key, $iv, $string = "") {
    $key = base64_decode($key);
    $iv = base64_decode($iv);
    return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, addpadding($string), MCRYPT_MODE_CBC, $iv));
}

function decrypt($key, $iv, $string = "") {
    $key = base64_decode($key);
    $iv = base64_decode($iv);
    $string = base64_decode($string);
    return strippadding(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_CBC, $iv));
}



?>