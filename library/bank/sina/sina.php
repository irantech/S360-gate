<?php
require_once(LIBRARY_DIR . 'bank/BankBase.php');

class sina extends BankBase
{

    private $url = 'https://sibank.sinabank.ir/api/v1/payment/get/token';

    public function requestPayment($request_data = []) {
        session_start();

//        $url = 'https://sina.sinabank.ir/vpg/api/v0/Request/PaymentRequest';
        $url = 'https://sibank.sinabank.ir/api/v1/payment/get/token';
        $redirectUrl = $request_data['revertURL'];
        $callbackUrl = $request_data['revertURL'];
        $merchant = $request_data['merchant'];
        $userId = $request_data['userId'];
        $token = $request_data['token'];
        $amount = $request_data['amount'];

//        'mobile' => '09123619745',
//        'nationalId' => '0011913517',
//        'nationalId' => '1292344822',
//            'mobile' => '09120879497',
        $factorItems = [
            'nationalId' => '0011913517',
            'mobile' => '09123619745',
            'orderId' => $request_data['factor_number'],
            'description' =>"خرید اعتباری",
            'amount' =>$amount,
            'date' =>dateTimeSetting::jdate( "Y/m/d", time() )
        ];

        $request = array(
            'callbackUrl' => $callbackUrl,
            'redirectUrl' => $redirectUrl,
            'merchant' => $merchant,
            'userId' => $userId,
            'token' => $token,
            'factorItems' => $factorItems
        );


        $response = $this->CallAPI($url, $request);

//        $require_data = [
//            'url' => $response['data']['url'],
//            'status' => $response['data']['status']
//        ];
//
//        return $this->showResult(true, $require_data, 'go to payment page');



        if ($response['data']["status"] != "true") {

            return $this->showResult(false, $response, 'Error code = '.$response['data']["transaction_id"]);
        }
        return $this->showResult(true, $response, 'go to payment page');


    }

    private function encrypt_pkcs7($str, $key) {
        $key = base64_decode($key);
        $ciphertext = OpenSSL_encrypt($str, "DES-EDE3", $key, OPENSSL_RAW_DATA);
        return base64_encode($ciphertext);
    }



    private function CallAPI($url,$request_data)
    {
        $data_string = json_encode($request_data);
//        var_dump(json_encode($request_data));
//        die;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        ));

        $result = curl_exec($ch);

        curl_close($ch);

        return json_decode($result, JSON_OBJECT_AS_ARRAY);
    }
    /**
     * @inheritDoc
     */
    public function verifyPayment($verify_params = []) {

        if (isset($verify_params['transaction_id'])) {

            $url = 'https://sibank.sinabank.ir/api/v1/payment/verify/status';

            $request = array(
                'url' => 'https://sina.sinabank.ir/vpg/api/v0/Advice/Verify',
                'transactionId' => $verify_params['transaction_id'],
                'merchant' => $verify_params['merchant'],
                'userId' => $verify_params['userId'],
                'token' => $verify_params['token'],
            );

            $response = $this->CallAPI($url, $request);
//            var_dump(json_encode($request));
//            die;
            if ($response["success"] == false) {
                $message = $response["error"];
                $response['factorNumber'] = $verify_params['factor_number'];
                $response['trackingCode'] = $verify_params['factor_number'];
                return $this->showResult(false, $response, $message);
            }else {
                $response_array = [
                    'factorNumber' => $verify_params['factor_number'],
                    'trackingCode' => $verify_params['factor_number'],
                    'amount' => ($verify_params['amount']),
                ];
                return $this->showResult(true, $response_array, 'تراکنش انجام شد');
            }

        }

    }


    public static function insertLogHold( $message, $fileName) {

            $messages =  "   " . $message . " \n  ";

        error_log( $messages, 3, LOGS_DIR . $fileName . '.txt' );
    }
    public static function insertLogHolds( $data, $fileName) {

        $file_all =  file_get_contents(LOGS_DIR . $fileName . '.txt');
        $get_file = json_decode($file_all);
        if($get_file) {
            array_push($get_file , $data) ;
        }else{
            $get_file[0]  = $data;
        }
        $new_array_json = json_encode($get_file);
        file_put_contents(LOGS_DIR . $fileName . '.txt', $new_array_json);
//        die();
    }

}