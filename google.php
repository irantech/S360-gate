<?php


$url = "http://google.com";
$data = array();
$handle = curl_init($url);
curl_setopt($handle, CURLOPT_HTTPGET, true);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_HTTPGET, $data);
$result = curl_exec($handle);
//$result =  json_decode($result, true);
print_r($result) ;
