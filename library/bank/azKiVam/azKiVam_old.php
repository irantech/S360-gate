<?php
//if(  $_SERVER['REMOTE_ADDR']=='93.118.161.174'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}

require_once(LIBRARY_DIR . 'bank/BankBase.php');


class azKiVam extends BankBase
{
    private $baseUrl = 'https://api.azkiloan.com/';
    private $merchantId;
    private $apiKey;
    private $authToken;



    public function requestPayment($request_data = [])
    {
        $this->merchantId = $request_data['merchant_id'];
        $this->apiKey = $request_data['api_key'];

        // دریافت توکن دسترسی
        $this->authToken = $this->getAuthToken();
        if (!$this->authToken) {
            return $this->showResult(false, null, 'خطا در دریافت توکن دسترسی');
        }

        $payload = [
            'amount' => $request_data['amount'],
            'redirect_uri' => $request_data['redirect_uri'],
            'fallback_uri' => $request_data['fallback_uri'],
            'provider_id' => $request_data['provider_id'] ? $request_data['provider_id'] : '123456',
//            'mobile_number' => isset($request_data['mobile_number']) ? $request_data['mobile_number'] : '09151010724',
            'mobile_number' => isset($request_data['mobile_number']) ? $request_data['mobile_number'] : '09123456789',
            'merchant_id' => $this->merchantId,
            'items' => [
                [
                    'name' => 'Payment for ' . $request_data['order_id'],
                    'count' => 1,
                    'amount' => $request_data['amount'],
                    'url' => isset($request_data['item_url']) ? $request_data['item_url'] : ''
                ]
            ]
        ];

        $headers = [
            'Authorization: Bearer ' . $this->authToken,
            'Content-Type: application/json'
        ];

        $response = $this->curlRequest($this->baseUrl . 'payment/purchase', $payload, $headers);
//        echo json_encode($response);
//        die;
        if (!$response || $response['rsCode'] != 0) {
            return $this->showResult(false, $response, 'خطا در اتصال به درگاه پرداخت');
        }

        return $this->showResult(true, [
            'payment_url' => $response['result']['payment_uri'],
            'ticket_id' => $response['result']['ticket_id']
        ], 'هدایت به درگاه پرداخت');
    }

    public function verifyPayment($verify_params = [])
    {
        $this->merchantId = $verify_params['merchant_id'];
        $this->apiKey = $verify_params['api_key'];

        // دریافت توکن دسترسی
        $this->authToken = $this->getAuthToken();
        if (!$this->authToken) {
            return $this->showResult(false, null, 'خطا در دریافت توکن دسترسی');
        }

        $payload = [
            'ticket_id' => $verify_params['ticket_id']
        ];

        $headers = [
            'Authorization: Bearer ' . $this->authToken,
            'Content-Type: application/json'
        ];

        $response = $this->curlRequest(
            $this->baseUrl . 'payment/verify',
            $payload,
            $headers,
            'POST'
        );

        if (!$response || $response['rsCode'] != 0) {
            return $this->showResult(false, $response, 'خطا در تأیید پرداخت');
        }

        $status = isset($response['result']['status']) ? $response['result']['status'] : null;
        $validStatuses = [2, 6, 8]; // Verified, Settled, Done

        if (!in_array($status, $validStatuses)) {
            return $this->showResult(false, $response, 'پرداخت ناموفق بود');
        }

        return $this->showResult(true, [
            'trackingCode' => $verify_params['ticket_id'],
            'amount' => $response['result']['amount'],
            'factorNumber' => $verify_params['order_id']
        ], 'پرداخت با موفقیت تأیید شد');
    }

    private function curlRequest($url, $data = [], $headers = [], $method = 'POST') {
        $ch = curl_init();

        // تنظیمات پایه
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // افزودن هدرهای پیش‌فرض
        $defaultHeaders = [
            'Content-Type: application/json',
            'Accept: application/json'
        ];
        $headers = array_merge($defaultHeaders, $headers);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // فعال کردن حالت دیباگ
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        $verbose = fopen('php://temp', 'w+');
        curl_setopt($ch, CURLOPT_STDERR, $verbose);

        // تنظیم روش درخواست
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // زمان انتظار برای اتصال
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //

//        echo json_encode($response);
//        die;
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // بررسی خطاها
        if ($response === false) {
            $error = curl_error($ch);
            rewind($verbose);
            $verboseLog = stream_get_contents($verbose);
            fclose($verbose);
            curl_close($ch);
            error_log("cURL Error: $error | Verbose Log: $verboseLog");
            return ['rsCode' => 1, 'message' => "CURL Error: $error"];
        }

        // ذخیره لاگ
        $log = [
            'url' => $url,
            'request' => $data,
            'response' => $response,
            'http_code' => $httpCode,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        file_put_contents('curl_debug.log', print_r($log, true), FILE_APPEND);

        curl_close($ch);
        return json_decode($response, true) ?: $response; // اگر JSON نبود، خود پاسخ را برگردان
    }

    private function getAuthToken()
    {
        $authUrl = $this->baseUrl . 'auth/authenticate';
//        $authUrl = $this->baseUrl . 'auth';
        $authData = [
            'username' => 'abibaltesti',
            'password' => 'RUzNk9JH'
        ];

        $headers = [
            'Content-Type: application/json',
            'Accept: application/json'
        ];

        $response = $this->curlRequest($authUrl, $authData, $headers, 'POST');

        if (isset($response['result']['accessToken'])) {
            return $response['result']['accessToken'];
        }

        return null;
    }

    /**
     * دریافت وضعیت پرداخت از درگاه
     *
     * @param array $params شامل:
     * - merchant_id: شناسه فروشگاه
     * - api_key: کلید API
     * - ticket_id: شناسه تیکت پرداخت
     * @return array پاسخ درگاه
     */
    public function getPaymentStatus($params = [])
    {
        // دریافت توکن دسترسی
        $this->authToken = $this->getAuthToken();
        if (!$this->authToken) {
            return $this->showResult(false, null, 'خطا در دریافت توکن دسترسی');
        }

        $headers = [
            'Authorization: Bearer ' . $this->authToken,
            'Content-Type: application/json'
        ];

        $payload = [
            'ticket_id' => $params['ticket_id']
        ];

        $response = $this->curlRequest(
            $this->baseUrl . 'payment/status',
            $payload,
            $headers,
            'POST'
        );

        if (!$response || $response['rsCode'] != 0) {
            return $this->showResult(false, $response, 'خطا در دریافت وضعیت پرداخت');
        }

        return $this->showResult(true, [
            'status' => isset($response['result']['status']) ? $response['result']['status'] : null,
            'amount' => isset($response['result']['amount']) ? $response['result']['amount'] : null,
            'ticket_id' => $params['ticket_id']
        ], 'وضعیت پرداخت دریافت شد');
    }
}