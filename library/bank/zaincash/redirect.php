<?php
require_once('credentials.php');
require_once('includes/autoload.php');
use \Firebase\JWT\JWT;


/* ------------------------------------------------------------------------------
Notes about $redirection_url: 
in this url, the api will add a new parameter (token) to its end like:
https://example.com/redirect.php?token=XXXXXXXXXXXXXX
*/

if (isset($_GET['token'])){

	//you can decode the token by this PHP code:
	$result= JWT::decode($_GET['token'], $secret, array('HS256'));
	$result= (array) $result;

	//And to check for status of the transaction, use $result['status'], like this:
	if ($result['status']=='success'){
		//Successful transaction
		
		//$result will be like this example:
		/*
		array(5) {
			["status"]=>
			string(7) "success"
			["orderid"]=>
			string(9) "Bill12345"
			["id"]=>
			string(24) "58650f0f90c6362288da08cf"
			["iat"]=>
			int(1483018052)
			["exp"]=>
			int(1483032452)
		}
		*/
		
		
		
		
		
	}
	if ($result['status']=='failed'){
		//Failed transaction and its reason
		$reason=$result['msg'];
		
		
		
		//$result will be like this example:
		/*
		array(6) {
			["status"]=>
			string(6) "failed"
			["msg"]=>
			string(33) "Invalid credentials for requester"
			["orderid"]=>
			string(9) "Bill12345"
			["id"]=>
			string(24) "58650ca990c6362288da08c8"
			["iat"]=>
			int(1483017397)
			["exp"]=>
			int(1483020997)
		}
		*/

	}
} else {
	//Cancelled transaction (if he clicked "Cancel and go back"
	
	//NO TOKEN HERE, SO NO $result
}
?>