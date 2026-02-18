<?php

$url = $_SERVER['REQUEST_URI'];

$url_explode = explode('/', $url);

//$url_goal = 'http://safar360.com/Core/V-1/Flight/findFilesource15/' . $url_explode[3];
$url_goal = 'http://safar360.com/Core/V-1/Flight/findFilesource15/' . $url_explode[3];

$result = file_get_contents($url_goal);


$result = json_decode($result, true);
header('Content-Type: application/json');
if (empty($result)) {
    $result = array(
        'error' => true,
        'message' => 'Request is wrong'
    );
    echo json_encode($result, 128);

} else {

    echo json_encode($result, 128);

}

