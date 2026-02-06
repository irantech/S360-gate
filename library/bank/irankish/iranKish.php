<?php
require_once(LIBRARY_DIR . 'bank/BankBase.php');

class iranKish extends BankBase
{

    private $url = 'https://ikc.shaparak.ir/';

    private function curlRequest($url,$request_data)
    {
        $data_string = json_encode($request_data);
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
    public function requestPayment($request_data = [])
    {
        $url = $this->url . 'api/v3/tokenization/make';

        $terminalID = $request_data['terminal_id'];
        $password = $request_data['password'];
        $acceptorId = $request_data['acceptor_id'];
        $pub_key = $request_data['pub_key'];
        $amount = intval($request_data['amount']);



        $token = $this->generateAuthenticationEnvelope($pub_key, $terminalID, $password, $amount);


        $data = [];
        $data["request"] = [
            "acceptorId" => $acceptorId,
            "amount" => $amount,
            "billInfo" => null,
            "paymentId" => null,
            "requestId" => $request_data['factor_number'],
            "requestTimestamp" => time(),
            "revertUri" => $request_data['revertURL'],
            "terminalId" => $terminalID,
            "transactionType" => "Purchase"
        ];
        $data['authenticationEnvelope'] = $token;
        functions::insertLog('my request ==>'.json_encode($data,256),'iran_requset');
        functions::insertLog('my request ==>'.json_encode($url,256),'iran_requset');

        $response =$this->curlRequest($url,$data);
        functions::insertLog('my request ==>'.json_encode($response,256),'iran_requset');
        if ($response["responseCode"] != "00") {
            return $this->showResult(false, $response, 'Error authentication.');
        }


        $paymentUrl = $this->url . 'iuiv3/IPG/Index/';
        $require_data = [
            'url' => $paymentUrl,
            'tokenIdentity' => $response['result']['token']
        ];
        return $this->showResult(true, $require_data, 'go to payment page');

    }

    public function generateAuthenticationEnvelope($pub_key, $terminalID, $password, $amount)
    {
        $data = $terminalID . $password . str_pad($amount, 12, '0', STR_PAD_LEFT) . '00';

        $data = hex2bin($data);
        $AESSecretKey = openssl_random_pseudo_bytes(16);
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($data, $cipher, $AESSecretKey, $options = OPENSSL_RAW_DATA, $iv);
        $hmac = hash('sha256', $ciphertext_raw, true);
        $crypttext = '';

        openssl_public_encrypt($AESSecretKey . $hmac, $crypttext, $pub_key);
//        if (!openssl_public_encrypt($AESSecretKey . $hmac, $crypttext, $pub_key)) {
//            echo "Encryption failed: " . openssl_error_string();
//        }
        return array(
            "data" => bin2hex($crypttext),
            "iv" => bin2hex($iv),
        );
    }

    /**
     * @inheritDoc
     */
    public function verifyPayment($verify_params = [])
    {
        $url = $this->url . 'api/v3/confirmation/purchase';
        $terminalID = $verify_params['terminal_id'];


        $data  = [
            "terminalId" => $terminalID,
            "retrievalReferenceNumber" => $_POST['retrievalReferenceNumber'],
            "systemTraceAuditNumber" => $_POST['systemTraceAuditNumber'],
            "tokenIdentity" => $_POST['token'],
        ];


        $response =$this->curlRequest($url,$data);



        if (!$response["status"]) {
            return $this->showResult(false, $response, $response["description"]);

        }



        $response_array=[
          'trackingCode'=>$_POST['systemTraceAuditNumber'],
          'factorNumber'=>$_POST['requestId'],
        ];
        return $this->showResult(true, $response_array, $response["description"]);

    }
}