<?php

class paystar {

    private $apiBase = 'https://api.paystar.shop/api/pardakht/';
    private $gatewayId;
    private $amount;
    private $orderId;
    private $callback;

    public function requestPayment( $params ) {
        $this->gatewayId = $params['gateway_id'];
        $this->amount    = $params['amount'];
        $this->orderId   = $params['order_id'];
        $this->callback  = $params['callback'];

        $data = [
            'amount'     => $this->amount,
            'order_id'   => $this->orderId,
            'callback'   => $this->callback,
            'callback_method' => 0
        ];

        $response = $this->callAPI('create', $data);

        if ( isset($response['status']) && $response['status'] == 1 ) {
            return [
                'success' => true,
                'data' => [
                    'link' => $this->apiBase.'payment?token=' . $response['data']['token'],
                    'token' => $response['data']['token'],
                ]
            ];
        } else {
            return [
                'success' => false,
                'message' => $response['message'] ?? 'خطا در ارتباط با درگاه',
            ];
        }
    }

    public function verifyPayment( $params ) {
        $logFile = 'logs/logBankPaystar_request.txt'; // مسیر فایل لاگ
        $logData = $this->findTokenFromLog($logFile, $params['gateway_id'], $params['order_id']);
        if (!$logData || !$logData['token'] || !$logData['amount']) {
            return [
                'success' => false,
                'message' => 'اطلاعات ارسالی به بانک اشتباه می باشد.'
            ];
        }

        $loggedToken = $logData['token'];
        $loggedAmount = $logData['amount'];

        $data = [
            'token' => $loggedToken,
            'ref_num'   => $params['ref_num'],
            'amount'    => $loggedAmount,//$params['amount']
        ];

        $this->gatewayId = $params['gateway_id'];
        $response = $this->callAPI('verify', $data);

        if ( isset($response['status']) && $response['status'] == 1 ) {
            return [
                'success' => true,
                'data' => [
                    'amount'         => $params['amount'],
                    'order_id'       => $params['order_id'],
                    'tracking_code'  => $params['tracking_code'],
                ]
            ];
        } else {
            return [
                'success' => false,
                'message' => $response['message'] ?? 'تراکنش ناموفق بود',
            ];
        }
    }


    private function callAPI($endpoint, $data) {
        $url = $this->apiBase . $endpoint;

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->gatewayId
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            curl_close($ch);
            return [
                'status' => 0,
                'message' => 'cURL error: ' . curl_error($ch)
            ];
        }

        curl_close($ch);
        return json_decode($response, true);
    }
    public function findTokenFromLog($filePath, $gatewayId, $orderId) {
        if (!file_exists($filePath)) {
            return null; // فایل وجود ندارد
        }

        $handle = fopen($filePath, "r");
        if (!$handle) {
            return null; // خطا در باز کردن فایل
        }

        $result = null;

        while (($line = fgets($handle)) !== false) {
            if (strpos($line, 'requestPayment') !== false) {
                $pos = strpos($line, 'requestPayment : ');
                if ($pos !== false) {
                    $jsonStr = substr($line, $pos + strlen('requestPayment : '));
                    $jsonStr = trim($jsonStr);
                    $data = json_decode($jsonStr, true);

                    if (json_last_error() !== JSON_ERROR_NONE) {
                        continue; // JSON نامعتبر
                    }

                    if (
                        isset($data['params']['gateway_id'], $data['params']['order_id']) &&
                        $data['params']['gateway_id'] === $gatewayId &&
                        $data['params']['order_id'] === $orderId
                    ) {
                        if (isset($data['request_payment']['data']['token'])) {
                            $result = [
                                'token'  => $data['request_payment']['data']['token'],
                                'amount' => $data['params']['amount'] ?? null
                            ];
                            break;
                        }
                    }
                }
            }
        }

        fclose($handle);
        return $result;
    }


}
?>