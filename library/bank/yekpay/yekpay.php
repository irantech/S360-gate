<?php

require_once( LIBRARY_DIR . 'bank/BankBase.php' );

class yekpay extends BankBase {
	public $apiUrl;
	public $paymentUrl;

	public function __construct() {
		$this->apiUrl     = "https://gate.yekpay.com/api/payment/";
		$this->paymentUrl = "https://gate.yekpay.com/api/payment/";
	}

	public function requestPayment( $data = array() ) {
		if ( ! $data['payment'] || ! $data['bank'] ) {
			return $this->showResult( false, $data, 'bank or payment not correct' );
		}
		functions::insertLog('generatePaymentRequest : '.json_encode($data,256|64),'yekpay_log');
		$params = self::generatePaymentRequest( $data );
        functions::insertLog('request payment request : '.json_encode($params,256|64),'yekpay_log');
		$result = functions::curlExecution( $this->apiUrl . 'request', json_encode( $params, 256 | 64 ), 'json' );
		functions::insertLog('request payment response : '.json_encode($data,256|64),'yekpay_log');

		if ( isset( $result['Code'] ) && $result['Code'] == 100 ) {
			$paymentUrl = $this->paymentUrl . 'start/' . $result['Authority'];

			return $this->showResult( true, [ 'url' => $paymentUrl ], 'go to payment page' );
		}

		return $this->showResult( false, $result, 'Error payment request' );

	}

	private function generatePaymentRequest( $bank_request = array() ) {
		$payment = $bank_request['payment'];
		$bank    = $bank_request['bank'];
		$extra   = $payment['extraData'];
		$params  = array();

		$params['firstName']        = $extra['firstName'];
		$params['lastName']         = $extra['lastName'];
		$params['mobile']           = $extra['mobile'];
		$params['email']            = $extra['email'];
		$params['city']             = $extra['city'];
		$params['country']          = $extra['country'];
		$params['address']          = $extra['address'];
		$params['merchantId']       = $bank['param3'];
		$params['postalCode']       = $extra['postalCode'];
		$params['fromCurrencyCode'] = self::getCurrencyCode( $extra['currency'] );
		$params['toCurrencyCode']   = self::getCurrencyCode( $extra['currency'] );
		$params['amount']           = $payment['amount'];
		$params['description']      = $payment['description'];
		$params['orderNumber']      = $payment['factorNumber'];
		$params['callback']         = $payment['callback'];

//		echo json_encode([$bank_request,$params],256|64);

		return $params;
	}

	private function getCurrencyCode( $currency = null ) {
		$SessionCurrency = ( $currency && $currency >= 0 ) ? $currency : Session::getCurrency();
		/** @var currencyEquivalent $currencyEquivalent */
		$currencyEquivalent = Load::controller( 'currencyEquivalent' );
		$InfoCurrency       = $currencyEquivalent->InfoCurrency( $SessionCurrency );
//		functions::insertLog(json_encode($InfoCurrency,256|64),'yekpay_log');
		$currencyCodes = [
			'EUR' => 978,
			'IRR' => 364,
			'AED' => 784,
			'GBP' => 826,
			'TRY' => 949,
			'CNY' => 156,
			'JPY' => 392,
			'RUB' => 643,
		];

		$code = $currencyCodes[ $InfoCurrency['CurrencyShortName'] ];

		return $code;

	}

	public function verifyPayment( $verify_params = array() ) {
		if ( ! $verify_params['payment'] || ! $verify_params['bank'] ) {
			return $this->showResult( false, $verify_params, 'bank or payment not correct' );
		}
		$payment = $verify_params['payment'];
		$bank    = $verify_params['bank'];
		try {
			if ( isset( $payment['status'] ) && $payment['status'] == '1' ) {
				$verify_data = [
					'authority'  => $payment['authority'],
					'merchantId' => $bank['param3']
				];

                functions::insertLog('verify curl request '.json_encode($verify_data,256|64),'yekpay_log');
				$verify = functions::curlExecution( $this->apiUrl . 'verify', json_encode( $verify_data,256|64 ), 'json' );
                functions::insertLog('verify curl response '.json_encode($verify,256|64),'yekpay_log');
				if ( isset( $verify['Code'] ) && $verify['Code'] == '100' ) {
//					$verify['tracking_code'] = $verify['Tracking'];
//					$verify['order_number'] = $verify['OrderNo'];

					return $this->showResult( true, $verify, 'payment verify completed' );
				}

				return $this->showResult( false, $verify, functions::Xmlinformation( 'ErrorVerify' ) );

			}

			return $this->showResult( false, $verify_params, functions::Xmlinformation( 'NoPayment' ) );

		} catch ( Exception $e ) {
			return $this->showResult( false, $e->getCode(), $e->getMessage() );
		}


	}
}