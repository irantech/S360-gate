<?php

function curlExecution($url, $data, $flag = NULL)
{
    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_POST, true);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($handle, CURLOPT_POSTFIELDS, $data);

    $headers = array(
        "Content-Type: application/json;charset=utf-8",
        "Accept: application/json",
        "Accept-Encoding: gzip, deflate"
    );

// Attach headers to the cURL request
    curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($handle);
    echo $result;
    die();
    if(curl_exec($handle) === false)
    {
        echo 'Curl error: ' . curl_error($handle);
    }
    for ($i = 0; $i <= 31; ++$i) {
        $jsonData = str_replace(chr($i), "", $result);
    }
    $result = str_replace(chr(127), "", $result);
    echo '<hr/>';


    // This is the most common part
    // Some file begins with 'efbbbf' to mark the beginning of the file. (binary level)
    // here we detect it and we remove it, basically it's the first 3 characters
    if (0 === strpos(bin2hex($result), 'efbbbf')) {
        $result = substr($result, 3);
    }
    $return = json_decode($result, true);
    /*error_log(PHP_EOL.'url is "'.$url. '" and data => '.$data,3,'curlTest4.txt');
    /*error_log(PHP_EOL.gettype($result),3,'curlTest1.txt');



    error_log(PHP_EOL.print_r($return,true),3,'curlTest2.txt');*/
    return $return;
}


$url = 'https://mhd113.ir/api/Partners/Flight/Availability/V16/SearchByRouteAndDate';
$data = array(
       "OriginDestinationOptionList" =>  [
       [
           "OriginIataCode" => "IKA",
           "DestinationIataCode" => "TAS",
           "FlightDate" => "2024-10-02"
       ],
        [
            "OriginIataCode" => "TAS",
            "DestinationIataCode" => "IKA",
            "FlightDate" =>  "2024-10-09"
        ]
    ],
    "FetchSupplierWebserviceFlights" => false,
    "Language"=> "FA",
    "UserName"=>"AVIATOP",
    "Password"=>"971b84ebacfb8818224681a2d0b5f7f0"


);

var_dump($url,json_encode($data));

$request = curlExecution($url,json_encode($data),'yes');

echo json_encode($request);
die();
