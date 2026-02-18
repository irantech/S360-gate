<?php
require_once('credentials.php');
require_once('includes/autoload.php');
use \Firebase\JWT\JWT;

// ----------------- Order Details --------------------------
//The total price of your order in Iraqi Dinar only like 1000 (if in dollar, multiply it by dollar-dinar exchange rate, like 1*1300=1300)
//Please note that it MUST BE MORE THAN 1000 IQD
$amount=1000;

//Type of service you provide, like 'Books', 'ecommerce cart', 'Hosting services', ...
$service_type="WordPress Cart";

//Order id, you can use it to help you in tagging transactions with your website IDs, if you have no order numbers in your website, leave it 1
//Variable Type is STRING, MAX: 512 chars
$order_id="Bill_1234567890";

//after a successful or failed order, the user will redirect to this url
$redirection_url='https://example.com/redirect.php';

/* ------------------------------------------------------------------------------
Notes about $redirection_url: 
in this url, the api will add a new parameter (token) to its end like:
https://example.com/redirect.php?token=XXXXXXXXXXXXXX
------------------------------------------------------------------------------  */

//building data
$data = [
'amount'  => $amount,        
'serviceType'  => $service_type,          
'msisdn'  => $msisdn,  
'orderId'  => $order_id,
'redirectUrl'  => $redirection_url,
'iat'  => time(),
'exp'  => time()+60*60*4
];

//Encoding Token
$newtoken = JWT::encode(
$data,      //Data to be encoded in the JWT
$secret ,'HS256'
);

//Check if test or production mode
if($production_cred){
	$tUrl = 'https://api.zaincash.iq/transaction/init';
	$rUrl = 'https://api.zaincash.iq/transaction/pay?id=';
}else{
	$tUrl = 'https://test.zaincash.iq/transaction/init';
	$rUrl = 'https://test.zaincash.iq/transaction/pay?id=';
}

//POSTing data to ZainCash API
$data_to_post = array();
$data_to_post['token'] = urlencode($newtoken);
$data_to_post['merchantId'] = $merchantid;
$data_to_post['lang'] = $language;
$options = array(
'http' => array(
'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
'method'  => 'POST',
'content' => http_build_query($data_to_post),
),
);
$context  = stream_context_create($options);
$response= file_get_contents($tUrl, false, $context);

//Parsing response
$array = json_decode($response, true);
$transaction_id = $array['id'];
$newurl=$rUrl.$transaction_id;
header('Location: '.$newurl);

/*
The last step is to redirect the customer to the NEW URL ==> $newurl
You can use : 
header('Location: '.$newurl);
After the customer buys, then will be redirected by ZainCash to $redirection_url 
with a token added to its end
Check the note about $redirection_url above and the illustration
*/
?>