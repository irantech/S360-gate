<?php
require_once(LIBRARY_DIR . 'bank/BankBase.php');

class sadad extends BankBase
{

    private $url = 'https://sadad.shaparak.ir/vpg/api/v0/Request/';

    public function requestPayment($request_data = []) {
        session_start();

        $url = 'https://sadad.shaparak.ir/vpg/api/v0/Request/PaymentRequest';

        $key = $request_data['api_key'];
        $terminal = $request_data['terminal'];
        $merchant = $request_data['merchant'];
        $amount = ($request_data['amount']);
        $factor_umber = $request_data['factor_number'];
        $call_back_url = $request_data['revertURL'];
        $local_date_time = date("m/d/Y g:i:s a");
        $sign_data = $this->encrypt_pkcs7("$terminal;$factor_umber;$amount", "$key");;


        $request = array(
            'TerminalId' => $terminal,
            'MerchantId' => $merchant,
            'Amount' => $amount,
            'SignData' => $sign_data,
            'ReturnUrl' => $call_back_url,
            'LocalDateTime' => $local_date_time,
            'OrderId' => $factor_umber
        );


        $response = $this->CallAPI($url, $request);


        error_reporting(1);
        error_reporting(E_ALL | E_STRICT);
        @ini_set('display_errors', 1);
        @ini_set('display_errors', 'on');


        if ($response["ResCode"] != "0") {
            return $this->showResult(false, $response, 'Error code = ' . $response["ResCode"]);
        }


        return $this->showResult(true, [

            'token' => $response['Token'],
            'sign_data' => $this->encrypt_pkcs7($response['Token'], $key),
            'link' => 'https://sadad.shaparak.ir/VPG/Purchase?Token=' . $response['Token']

        ], 'go to payment page');

    }

    private function encrypt_pkcs7($str, $key) {
        $key = base64_decode($key);
        $ciphertext = OpenSSL_encrypt($str, "DES-EDE3", $key, OPENSSL_RAW_DATA);
        return base64_encode($ciphertext);
    }

    public function CallAPI($url, $data = false) {

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json; charset=utf-8',
                'Referer: ' . SERVER_HTTP . CLIENT_DOMAIN,
                'Referrer-Policy: strict-origin-when-cross-origin'));
            curl_setopt($ch, CURLOPT_POST, 0);
            if ($data)
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_REFERER, "https://online.bahartravel.com/gds/Send.php");
            $result = curl_exec($ch);
            curl_close($ch);
            return !empty($result) ? json_decode($result, true) : false;
        } catch (Exception $ex) {
            return false;
        }

    }

    /**
     * @inheritDoc
     */
    public function verifyPayment($verify_params = []) {


        if (isset($verify_params['res_code']) && $verify_params['res_code'] == '0') {

            $url = 'https://sadad.shaparak.ir/vpg/api/v0/Advice/Verify';


            $token = $verify_params['token'];
            $key = $verify_params['api_key'];
            $factor_number = $verify_params['factor_number'];

            $sign_data = $this->encrypt_pkcs7($token, "$key");


            $request = [
                'Token' => $token,
                'SignData' => $sign_data,

            ];


            $response = $this->CallAPI($url, $request);





            if ($response["ResCode"] == -1 || $response["ResCode"] != 0) {
                $message = $response["Description"];
                $response['factorNumber'] = $factor_number;


                return $this->showResult(false, $response, $message);
            }


            $response_array = [
                'trackingCode' => $response['RetrivalRefNo'],
                'amount' => ($response['amount']),
                'factorNumber' => $factor_number,
            ];
            return $this->showResult(true, $response_array, 'تراکنش انجام شد');
        } else {

            if($verify_params['res_code'] && $verify_params['res_code'] == '-1'){
                return $this->showResult(false, [], 'پرداختی انجام نشده است. (شما از پرداخت انصراف داده اید)');
            }elseif ($verify_params['res_code'] && $verify_params['res_code'] == '101'){
                return $this->showResult(false, [], 'مهلت ارسال تراکنش به پايان رسید.');
            }elseif ($verify_params['res_code'] && $verify_params['res_code'] == '100'){
                return $this->showResult(false, [], 'درخواست تکراريست)قبال در سیستم با موفقیت ثبت شده است(');
            }else{
                return $this->showResult(false, [], ' نتیجه تراکنش ناموفق بود.');

            }


        }
    }

    private function curlRequest($url, $request_data) {


        $data_string = http_build_query($request_data);
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        $result = curl_exec($ch);
        curl_close($ch);


        $log = [
            'request_url' => $url,
            'request' => $request_data,
            'response' => $result,
        ];

        functions::insertLog(json_encode($log), 'sadadLog');

        return json_decode($result, JSON_OBJECT_AS_ARRAY);
    }
}
