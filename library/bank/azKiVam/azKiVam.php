<?php
require_once(LIBRARY_DIR . 'bank/BankBase.php');

class azKiVam extends BankBase
{
//    private $baseUrl = 'https://api.azkiloan.com/';
    private $baseUrl = 'https://api.azkivam.com/';
    private $merchantId;
    private $username;
    private $password;
    private $authToken;

    private function logRequest($url, $payload, $headers, $method = 'POST')
    {
        $logData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'url' => $url,
            'method' => $method,
            'headers' => $headers,
            'payload' => $payload
        ];
        functions::insertLog('azKiVam Request: ' . json_encode($logData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), 'azkivamLog');
    }

    private function logResponse($url, $response, $httpCode)
    {
        $logData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'url' => $url,
            'http_code' => $httpCode,
            'response' => $response
        ];
        functions::insertLog('azKiVam Response: ' . json_encode($logData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), 'azkivamLog');
    }

    public function requestPayment($request_data = [])
    {
        $this->merchantId = $request_data['merchant_id'];
        $this->username = $request_data['username'];
        $this->password = $request_data['password'];

        // دریافت توکن دسترسی
        $this->authToken = $this->getAuthToken();
        if (!$this->authToken) {
            return $this->showResult(false, null, 'خطا در دریافت توکن دسترسی');
        }

        $payload = [
            'amount' => $request_data['amount'],
            'redirect_uri' => $request_data['revertURL'],
            'fallback_uri' => $request_data['revertURL'],
            'provider_id' => $request_data['provider_id'],
            'mobile_number' => $request_data['mobile_number'],
            'merchant_id' => $this->merchantId,
            'items' => [
                [
                    'name' => 'Payment for ' . $request_data['factor_number'],
                    'count' => 1,
                    'amount' => $request_data['amount'],
                    'url' => $request_data['item_url']
                ]
            ]
        ];

        $headers = [
            'Authorization: Bearer ' . $this->authToken,
            'Content-Type: application/json'
        ];

        $response = $this->curlRequest($this->baseUrl . 'payment/purchase', $payload, $headers);

        if (!$response || $response['rsCode'] != 0) {
            return $this->showResult(false, $response, 'خطا در اتصال به درگاه پرداخت');
        }

        return $this->showResult(true, [
            'payment_uri' => $response['result']['payment_uri'],
            'ticket_id' => $response['result']['ticket_id']
        ], 'هدایت به درگاه پرداخت');
    }

    public function verifyPayment($verify_params = [])
    {
        $this->merchantId = $verify_params['merchant_id'];
        $this->username = $verify_params['username'];
        $this->password = $verify_params['password'];

        // دریافت توکن دسترسی
        $this->authToken = $this->getAuthToken();
        if (!$this->authToken) {
            return $this->showResult(false, null, 'خطا در دریافت توکن دسترسی');
        }

        $payload = [
            'ticket_id' => $verify_params['ticket_id'],
            'provider_id' => $verify_params['provider_id']
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
        $validStatuses = [2, 6, 8];

        if (!in_array($status, $validStatuses)) {
            return $this->showResult(false, $response, 'پرداخت ناموفق بود');
        }

        return $this->showResult(true, [
            'trackingCode' => isset($response['result']['tracking_code']) ? $response['result']['tracking_code'] : $verify_params['ticket_id'],
            'amount' => $response['result']['amount'],
            'factorNumber' => $verify_params['provider_id']
        ], 'پرداخت با موفقیت تأیید شد');
    }

    private function curlRequest($url, $data = [], $headers = [], $method = 'POST')
    {
        // لاگ درخواست
        $this->logRequest($url, $data, $headers, $method);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $defaultHeaders = [
            'Content-Type: application/json',
            'Accept: application/json'
        ];
        $headers = array_merge($defaultHeaders, $headers);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $redirectUrl = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
        $effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

        // لاگ پاسخ
        $this->logResponse($url, [
            'http_code' => $httpCode,
            'redirect_url' => $redirectUrl,
            'effective_url' => $effectiveUrl,
            'response' => $response
        ], $httpCode);

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            return ['rsCode' => 1, 'message' => "CURL Error: $error"];
        }

        curl_close($ch);
        $decodedResponse = json_decode($response, true) ?: $response;

        return $decodedResponse;
    }

    private function getAuthToken()
    {
        $authUrl = $this->baseUrl . 'auth/authenticate';
        $authData = [
            'username' => $this->username,
            'password' => $this->password
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

    public function showResult($success, $data, $message)
    {
        return [
            'success' => $success,
            'data' => $data,
            'message' => $message
        ];
    }
}