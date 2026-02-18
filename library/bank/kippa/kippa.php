<?php
require_once(LIBRARY_DIR . 'bank/BankBase.php');

class kippa extends BankBase
{

    private $url = 'https://api.kipaa.ir/ipg/v2/supplier/';

    private function curlRequest($url,$request_data , $token = null)
    {


        $data = json_encode($request_data);

        $handle = curl_init($url);

        curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_ENCODING , "");
        curl_setopt($handle, CURLOPT_MAXREDIRS  , 10);
        curl_setopt($handle, CURLOPT_TIMEOUT   , 0);
        curl_setopt($handle, CURLOPT_FOLLOWLOCATION    , true);
        curl_setopt($handle, CURLOPT_HTTP_VERSION     , CURL_HTTP_VERSION_1_1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);

        if ( isset($token) && !empty($token)) {


            curl_setopt( $handle, CURLOPT_HTTPHEADER,
                array('Content-Type: application/json' ,
                    'Authorization: Bearer '.$token ) );
        }else{
            curl_setopt( $handle, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json' ) );
        }


        $result = curl_exec($handle);

        curl_close($handle);


        $log=[
            'request_url'=>$url,
            'request'=>$request_data,
            'response'=>$result,
        ];

        functions::insertLog(json_encode($log),'nextpayLog');

        return json_decode($result, JSON_OBJECT_AS_ARRAY);
    }
    public function requestPayment($request_data = [])
    {
        $url = $this->url . 'request_payment_token';

//        $api_key= $request_data['api_key'];
//        $amount = functions::convert_rial_toman($request_data['amount']);
        $amount        = $request_data['amount'];
        $factor_umber  = $request_data['invoice'];
        $call_back_url = $request_data['callbackApi'];

        $request=[
            'merchant_order_id'=>$factor_umber,
            'amount'=>$amount,
            'callback_url'=>$call_back_url,
	        'details'=> ''
        ];

        functions::insertLog( 'kippa request params : ' . json_encode( $request ), 'logBankKippa' );


        $response =$this->curlRequest($url,$request , $request_data['token']);
        functions::insertLog( 'kippa  request response : ' . json_encode( $response ), 'logBankKippa' );


        /*    if($_SERVER['REMOTE_ADDR']==='151.243.7.188' && CLIENT_ID == '166'){
                var_dump($response);
                die();

            }*/

        if (!$response["Success"] && $response["Status"] != 200) {
            return $this->showResult(false, $response, 'Error code = '.$response["code"]);
        }

        return $this->showResult(true, $response, 'go to payment page');

    }

    /**
     * @inheritDoc
     */
    public function verifyPayment($verify_params = [])
    {
        $url = $this->url . 'verify_transaction';
        functions::insertLog( ' verify_transaction params : ' . json_encode( $verify_params ), 'logBankKippa' );


        $payment_token= $verify_params['payment']['payment_token'];
        $reciept_number = $verify_params['payment']['reciept_number'];

        $request=[
            'payment_token'=>$payment_token,
            'reciept_number'=>$reciept_number,
        ];
        
        functions::insertLog( ' verify_transaction : ' . json_encode( [$url ,$request ] ), 'logBankKippa' );

        $response =$this->curlRequest($url,$request);
        functions::insertLog( ' verify_transaction response : ' . json_encode($response), 'logBankKippa' );


        if (!$response["success"]) {
            $message=functions::Xmlinformation( 'NoPayment' )->__toString();
            return $this->showResult(false, $response,$message);
        }
        $url = $this->url . 'confirm_transaction';
        functions::insertLog( ' confirm_transaction : ' . json_encode( [$url ,$request ] ), 'logBankKippa' );

        $confirm_response =$this->curlRequest($url,$request);

        functions::insertLog( ' confirm_transaction response : ' . json_encode($response), 'logBankKippa' );

        if (!$confirm_response["success"]) {
            $message=functions::Xmlinformation( 'NoPayment' )->__toString();
            return $this->showResult(false, $response,$message);
        }

        $url = $this->url . 'get_transaction';
        functions::insertLog( ' get_transaction : ' . json_encode( [$url ,$request ] ), 'logBankKippa' );

        $get_response =$this->curlRequest($url,$request);
        functions::insertLog( ' get_transaction response : ' . json_encode($response), 'logBankKippa' );

        if (!$get_response["success"]) {
            $message=functions::Xmlinformation( 'NoPayment' )->__toString();
            return $this->showResult(false, $response,$message);
        }

        $response_array=[
            'trackingCode'=>$response['content']['ConfirmTransactionNumber'],
            'amount'=>$response['content']['Amount'],
            'factorNumber'=>$response['content']['MerchantOrderId'],
        ];
        return $this->showResult(true, $response_array, 'تراکنش انجام شد');

    }
}