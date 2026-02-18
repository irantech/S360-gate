<?php
ini_set( 'precision', 15 );

require_once(  LIBRARY_DIR.'bank/BankBase.php');
require_once( LIBRARY_DIR.'bank/zaincash/includes/autoload.php' );

use \Firebase\JWT\JWT;

class zain extends BankBase {
	protected $msisdn;
	protected $secret;
	protected $merchantid;
	protected $testmode;
	protected $language;
	public $algorithm;
	public $baseUrl;
	
	
	public function __construct() {
		$this->testmode = true;
		$this->baseUrl  = 'https://api.zaincash.iq/transaction/';
		
		if ( $this->testmode ) {
			$this->baseUrl = 'https://test.zaincash.iq/transaction/';
		}
		
		$this->algorithm = 'HS256';
		
	}
	
	public function apiRoute( $method = 'init', $params = [] ) {
		$queries = '';
		if ( $params ) {
			$queries = http_build_query( $params );
			
			return "{$this->baseUrl}{$method}?{$queries}";
		}
		
		return "{$this->baseUrl}{$method}";
		//		$this->paymentUrl = $this->baseUrl . 'pay?id=';
	}
	
	private function tokenEncode( $params = [],$secret = '') {
		$jwt = new Firebase\JWT\JWT;
		if (property_exists($jwt, 'leeway')) {
			$jwt::$leeway = 100;
		}
		
		$token = $jwt::encode( $params,      //Data to be encoded in the JWT
			$secret, $this->algorithm );
		return urlencode($token);
	}
	
	private function tokenDecode( $token = '', $secret = '' ) {
		if ( ! $token ) {
			return false;
		}
		functions::insertLog('zain decode before: '.json_encode([$token,$secret,$this->algorithm]),'010Zain');
		$jwt = new Firebase\JWT\JWT;
		if (property_exists($jwt, 'leeway')) {
			$jwt::$leeway = 100;
		}
		
//		$jwt::$timestamp = (new DateTime())->setTimezone( new DateTimeZone('Europe/London'))->getTimestamp();
		
		$return = (array) $jwt::decode( $token, $secret, array( $this->algorithm ) );
		functions::insertLog('zain after before: '.json_encode($return),'010Zain');
		
		return $return;
	}
	
	/**
	 * @param array $params
	 *
	 * @return array
	 */
	public function requestPayment( $params = [] ) {
		$bank    = $params['bank'];
		$payment = $params['payment'];
		
		$factorNumber = $payment['factorNumber'];
		$comment      = "buy request {$payment['serviceType']} ticket FN: {$payment['factorNumber']}";
		$callback     = $payment['callback'];
		
		$merchantId = $bank['param2'];
		$msisdn     = $bank['param4'];
		$secret     = $bank['param5'];
		
//		$now = new DateTime();
		
		$tokenParams = [
			'amount'      => $payment['amount'],
			'serviceType' => $comment,
			'msisdn'      => $msisdn,
			'orderId'     => $factorNumber,
			'redirectUrl' => $callback,
			'iat'  => strtotime('now'),
			'exp'  => strtotime('+4 hours')
		];
//
//		$tokenParams = [
//			'amount'  => $amount,
//			'serviceType'  => $service_type,
//			'msisdn'  => $this->msisdn,
//			'orderId'  => $order_id,
//			'redirectUrl'  => $this->redirection_url,
//			'iat'  => $now->getTimestamp(),
//			'exp'  => $now->getTimestamp()+60*60*4
//		];
		
		$token = self::tokenEncode( $tokenParams,$secret);
		
		$lang = SOFTWARE_LANG == 'ar' ? SOFTWARE_LANG : 'en';
		$reqData = [
			'token'      => $token,
			'merchantId' => $merchantId,
			'lang'       => $lang,
		];
		$initUrl = self::apiRoute( 'init' );
		
		$options = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($reqData),
			),
		);
		
		$context  = stream_context_create($options);
		
		$curl = file_get_contents($initUrl, false, $context);
		functions::insertLog(' options: '.json_encode($options).' context '.$context,'000curlExecution');
		functions::insertLog(' curl response '.$curl,'000curlExecution');
		$curl = json_decode($curl,true);
//		$curl    = functions::curlExecution( $initUrl, $reqData, 'form' );
		if ( ! isset( $curl['id'] ) ) {
			return $this->showResult(false,null ,'transaction_id not created');
		}
		$paymentUrl = self::apiRoute( 'pay', [ 'id' => $curl['id'] ] );
		return $this->showResult(true,[ 'url' => $paymentUrl ],'ready for payment');
	}
	
	
	public function verifyPayment( $data= [] ) {
		$token = $data['payment']['token'];
		$bank = $data['bank'];
		functions::insertLog('zain data : '.json_encode($data),'010Zain');
		$result = self::tokenDecode($token,$bank['param5']);
//		functions::insertLog('zain data : '.json_encode($data),'010Zain');
		functions::insertLog('zain token  : '.$token,'010Zain');
		functions::insertLog('zain secret : '.$bank['param5'],'010Zain');
		functions::insertLog('result decoded : '.json_encode($result,256|64),'010Zain');
		if(isset($result['status']) && $result['status'] == 'success'
		   /*todo: I've added this line below only for testing response to bank.php we have to remove this line in the live version*/
		   || ($result['status'] == 'failed' && $result['orderid'] == $data['payment']['factorNumber'])
		){
			$return_data =[
				'tracking_code'=>$result['id'],
			];
			return $this->showResult(true,$return_data,'sample verify');
		}
		
		return $this->showResult(false,$result,'sample verify');
		
	}
	
	public function verify( $params = [] ) {
		
		$result = $this->tokenDecode( $params['token'] );
		
	}
}