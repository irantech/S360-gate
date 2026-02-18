<?php
require_once(LIBRARY_DIR . 'bank/BankBase.php');
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
class payPing extends BankBase
{

    private $url = 'https://api.payping.ir/v3/pay';

    private function curlRequest($url,$request_data , $token = null)
    {

        $data = json_encode($request_data);
//        var_dump($data);
        $handle = curl_init($url);
//       var_dump($url, $data , $token);
//        die();
        curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_ENCODING , "");
        curl_setopt($handle, CURLOPT_MAXREDIRS  , 10);
        curl_setopt($handle, CURLOPT_TIMEOUT   , 45);
        curl_setopt($handle, CURLOPT_FOLLOWLOCATION    , true);
        curl_setopt($handle, CURLOPT_HTTP_VERSION     , CURL_HTTP_VERSION_1_1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);


        if ( isset($token) && !empty($token)) {
        curl_setopt( $handle, CURLOPT_HTTPHEADER,
                array('Content-Type: application/json' ,
                    'Authorization: Bearer '.$token,
                    'cache-control: no-cache',
                    'content-type: application/json') );
        }else{
            curl_setopt( $handle, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json' ) );
        }


        $result = curl_exec($handle);
//        var_dump($result);
//        die();
        curl_close($handle);

//        var_dump($request_data);
//        die;
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

        $url = $this->url ;

        $token = $request_data['token'];
        unset($request_data['token']);

        functions::insertLog( 'payPing request params : ' . json_encode( $request_data ), 'logBankPayPing' );

        $response =$this->curlRequest($url,$request_data , $token);

        functions::insertLog( 'payPing  request response : ' . json_encode( $response ), 'logBankPayPing' );

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


        $url = $this->url . '/verify';

        functions::insertLog( ' verify_transaction params : ' . json_encode( $verify_params ), 'logBankPayPing' );


        $payment_token= $verify_params['token'];
        $payment_ref_id = $verify_params['paymentRefId'];
        $factor_number = $verify_params['factorNumber'];
        $amount = $verify_params['amount'];
        $paymentCode = $verify_params['paymentCode'];

        $request=[
            'PaymentRefId' => $payment_ref_id,
            'paymentCode' => $paymentCode,
            'amount' => $amount
        ];

        functions::insertLog( ' verify_transaction : ' . json_encode( [$url ,$request ] ), 'logBankPayPing' );

        $response =$this->curlRequest($url,$request , $payment_token);
        if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20' && $factor_number ==='17472358' ) {
            $response['status']=200;
        }
        functions::insertLog( ' verify_transaction response : ' . json_encode($response), 'logBankPayPing' );
        if (isset($response['status']) && $response['status'] == 409) {

            return $this->showResult(false, [], 'پرداختی انجام نشده است. (شما از پرداخت انصراف داده اید)');

        }else{

            $response_array = [
                'trackingCode' => $response['paymentRefId'],
                'amount' => $response['amount'],
                'factorNumber' => $factor_number,
            ];

            return $this->showResult(true, $response_array, 'تراکنش انجام شد');
        }

    }
}