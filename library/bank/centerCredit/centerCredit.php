<?php
require_once(LIBRARY_DIR . 'bank/BankBase.php');
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
class centerCredit extends BankBase
{

    private $url = 'https://test3ds.bcc.kz:5445/cgi-bin/cgi_link';
//    private $url = 'https://payment.centercredit.kz/api/payment';

    private function curlRequest($url,$request_data)
    {

        $url = 'https://test3ds.bcc.kz:5445/cgi-bin/cgi_link';
//        $data = json_encode($request_data);

        $data['CARD']   = '4463755551594568';
        $data['MERCHANT']   = 'AG2POST90033823';
        $data['TERMINAL']   = 'AG2POST90033823';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/x-www-form-urlencoded"
        ));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // or any other value

        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);  // Disable proxy
        curl_setopt($ch, CURLOPT_PROXY, "");  // Clear proxy setting



        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'خطا: ' . curl_errno($ch) . ' ' .  curl_error($ch);die();
        } else {
            $result = json_decode($response, true);
            if ($result['status'] === 'success') {
                header('Location: ' . $result['payment_url']);
                exit;
            } else {
                echo 'خطا در پرداخت: ' . $result['message'];
            }
        }
        curl_close($ch);

        return json_decode($result, JSON_OBJECT_AS_ARRAY);
    }

    public function requestPayment($request_data = [])
    {


        $url = $this->url ;
        functions::insertLog( 'payPing request params : ' . json_encode( $request_data ), 'logBankPayPing' );

        $response =$this->curlRequest($url,$request_data);

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
        $reciept_clientRefId = $verify_params['clientRefId'];

        $request=[
            'PaymentRefId'=>$reciept_clientRefId
        ];

        functions::insertLog( ' verify_transaction : ' . json_encode( [$url ,$request ] ), 'logBankPayPing' );

        $response =$this->curlRequest($url,$request , $payment_token);
        functions::insertLog( ' verify_transaction response : ' . json_encode($response), 'logBankPayPing' );

//var_dump($response);
//die;
        if (!$response["success"]) {
            $message=functions::Xmlinformation( 'NoPayment' )->__toString();
            return $this->showResult(false, $response,$message);
        }
        $url = $this->url . 'confirm_transaction';
        functions::insertLog( ' confirm_transaction : ' . json_encode( [$url ,$request ] ), 'logBankPayPing' );

        $confirm_response =$this->curlRequest($url,$request);

        functions::insertLog( ' confirm_transaction response : ' . json_encode($response), 'logBankPayPing' );

        if (!$confirm_response["success"]) {
            $message=functions::Xmlinformation( 'NoPayment' )->__toString();
            return $this->showResult(false, $response,$message);
        }

        $url = $this->url . 'get_transaction';
        functions::insertLog( ' get_transaction : ' . json_encode( [$url ,$request ] ), 'logBankPayPing' );

        $get_response =$this->curlRequest($url,$request);
        functions::insertLog( ' get_transaction response : ' . json_encode($response), 'logBankPayPing' );

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