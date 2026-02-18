<?php
require_once(LIBRARY_DIR . 'bank/BankBase.php');
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
class zarrinPlus extends BankBase
{

    private $url = 'https://api.zarinplus.com/payment/v2/';

    public function requestPayment($request_data = [])
    {
            $url = 'https://api.zarinplus.com/payment/v2/request/';

        $request = [
            'amount' => $request_data['amount'],
            'cancel' => $request_data['cancel'],
            'success' => $request_data['success'],
            'item' => $request_data['item'],
            'cellphone' => $request_data['cellphone'],
            'email' => $request_data['email'],
            'token' => $request_data['token']
        ];
//        var_dump($url);
//        echo "<hr>";
//        echo json_encode($request);
//        die;
        $response = $this->curlRequest($url, $request);

//        echo json_encode($response);
//        die;
        if (!$response["status"]) {
            return $this->showResult(false, $response, 'Error message = ' . $response["message"]);
        }

        return $this->showResult(true, [
            'authority' => $response['authority'],
            'redirect_url' => $response['redirect_url']
        ], 'go to payment page');
    }


    private function curlRequest($url, $params = [])
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return ['status' => false, 'message' => curl_error($ch)];
        }

        curl_close($ch);
        return json_decode($response, true);
    }

    /**
     * @inheritDoc
     */
    public function verifyPayment($verify_params = [])
    {
        $url = $this->url . 'verify/';

        $request = [
            'authority' => $verify_params['authority'],
            'token' => $verify_params['token'],
            'amount' => $verify_params['amount'],
        ];

        functions::insertLog('ZarinPlus verify params: ' . json_encode($request), 'logBankZarinPlus');

        $response = $this->curlRequest($url, $request);

        functions::insertLog('ZarinPlus verify response: ' . json_encode($response), 'logBankZarinPlus');

        // بررسی پاسخ
        if (!isset($response['status']) || !$response['status']) {
            return $this->showResult(false, $response, 'تأیید پرداخت ناموفق بود. پیام خطا: ' . $response['message']);
        }

        // بررسی کد داده برگشتی
        if (!isset($response['data']['code']) || $response['data']['code'] != 200) {
            return $this->showResult(false, $response, 'تراکنش نهایی نشد. کد وضعیت: ' . $response['data']['code']);
        }

        // ساخت آرایه خروجی نهایی (مثل قبل)
        $response_array = [
            'trackingCode' => $response['data']['reference'],
            'amount' => $response['data']['amount'],
            'cellphone' => $response['data']['cellphone'],
        ];

        return $this->showResult(true, $response_array, 'تراکنش تأیید شد');
    }

    public function reversePayment($reverse_params = [])
    {
        $url = $this->url . 'reverse/';

        $request = [
            'reference' => $reverse_params['reference'],
            'authority' => $reverse_params['authority'],
            'token' => $reverse_params['token'],
        ];

        functions::insertLog('ZarinPlus reverse params: ' . json_encode($request), 'logBankZarinPlus');

        $response = $this->curlRequest($url, $request);

        functions::insertLog('ZarinPlus reverse response: ' . json_encode($response), 'logBankZarinPlus');

        if (!isset($response['status']) || !$response['status']) {
            return $this->showResult(false, $response, 'بازگشت تراکنش ناموفق بود. پیام خطا: ' . $response['message']);
        }

        $response_array = [
            'code'    => $response['data']['code'],
            'message' => $response['data']['message'],
            'amount'  => $response['data']['amount'],
            'item'    => $response['data']['item'],
            'email'   => $response['data']['email'],
            'cellphone' => $response['data']['cellphone'],
        ];

        return $this->showResult(true, $response_array, 'تراکنش با موفقیت بازگشت داده شد');
    }

    public function showResult($status, $data, $message = '')
    {
        return [
            'status'  => $status,
            'data'    => $data,
            'message' => $message,
        ];
    }






}