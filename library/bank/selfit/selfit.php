<?php

require_once(LIBRARY_DIR . 'bank/BankBase.php');

class selfit extends BankBase {
    private $apiUrl;
    private $paymentUrl;
    private $verifyUrl;
    private $cancelUrl;
    private $tokenUrl;
    private $bank;

    public function __construct() {
        $this->apiUrl = "https://api.selfit.ir";
        $this->tokenUrl = $this->apiUrl . "/api/ThirdParty/v1/Authentication";
        $this->paymentUrl = $this->apiUrl . "/api/ThirdParty/v1/Pay/GetPaymentUrl";
        $this->verifyUrl = $this->apiUrl . "/api/ThirdParty/v1/Pay/Inquiry";
        $this->cancelUrl = $this->apiUrl . "/api/ThirdParty/v1/Pay/Cancel";
        
        // Initialize bank property
        $this->bank = Load::controller('bank');
    }

    /**
     * Get authentication token from SELFiT API
     * 
     * @param string $username The username
     * @param string $password The password
     * @return string|null Access token or null on failure
     */
    private function getAuthToken($username, $password) {
        $data = [
            'username' => $username,
            'password' => $password
        ];

        functions::insertLog('SELFiT auth request: ' . json_encode($data, JSON_UNESCAPED_UNICODE), 'selfit_log');
        
        $headers = ['Content-Type: application/json'];
        $result = $this->bank->selfitCurlExecution($this->tokenUrl, json_encode($data), 'json', [], $headers);
        
        functions::insertLog('SELFiT auth response: ' . json_encode($result, JSON_UNESCAPED_UNICODE), 'selfit_log');
        
        if (isset($result['data']) && isset($result['data']['access_token'])) {
            return $result['data']['access_token'];
        }
        
        return null;
    }

    /**
     * Request payment from SELFiT gateway
     *
     * @param array $request_data
     * @return array
     */
    public function requestPayment($request_data = []) {
        if (!isset($request_data['payment']) || !isset($request_data['bank'])) {
            return $this->showResult(false, $request_data, 'Bank or payment data is incorrect');
        }

        functions::insertLog('SELFiT payment request: ' . json_encode($request_data, JSON_UNESCAPED_UNICODE), 'selfit_log');
        
        $payment = $request_data['payment'];
        $bank = $request_data['bank'];
        
        // Get customer details
        $userDetails = $this->getDetailsForExteranlBank($payment['factor_number'], $payment['pay_for']);

        // Get auth token
        $token = $this->getAuthToken($bank['param1'], $bank['param2']);
        
        if (!$token) {
            return $this->showResult(false, [], 'Failed to authenticate with SELFiT API');
        }
        
        // Build payment request URL
        $amount = $payment['amount'];
        $mobilePhone = isset($userDetails['mobile']) ? $userDetails['mobile'] : '09190091997';
//        $mobilePhone = '09190091997';
        $metaData = "Order: {$payment['factor_number']} - {$payment['pay_for']}";
        $redirectUrl = $payment['callback_url'];
        
        $paymentRequestUrl = $this->paymentUrl . "?mobilePhone=" . urlencode($mobilePhone) . 
                             "&amount=" . urlencode($amount) .
                             "&redirectUrl=" . urlencode($redirectUrl) . 
                             "&metaData=" . urlencode($metaData);
        
        // Call the API with token
        $headers = [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ];

        functions::insertLog('SELFiT payment request URL: ' . $paymentRequestUrl, 'selfit_log');
        functions::insertLog('SELFiT payment request headers: ' . json_encode($headers, JSON_UNESCAPED_UNICODE), 'selfit_log');
        
        $result = $this->bank->selfitCurlExecution($paymentRequestUrl, null, 'json', [], $headers, 'GET');

        functions::insertLog('SELFiT payment response: ' . json_encode($result, JSON_UNESCAPED_UNICODE), 'selfit_log');
        
        // Check for BadRequest error which typically means user isn't registered in SELFiT
        if (isset($result['isSuccess']) && $result['isSuccess'] === false) {
            if (isset($result['statusCode']) && $result['statusCode'] === 'BadRequest') {
                return $this->showResult(false, [], 'کاربر در سامانه سلفیت ثبت نام نشده است. لطفا ابتدا در اپلیکیشن سلفیت ثبت نام کنید یا از روش پرداخت دیگری استفاده نمایید.');
            }
            
            // Handle other errors
            $errorMessage = isset($result['message']) ? $result['message'] : 'خطا در اتصال به درگاه پرداخت سلفیت';
            return $this->showResult(false, [], $errorMessage);
        }
        
        if (isset($result['data']) && isset($result['data']['payment_url'])) {
            $response_data = [
                'id' => $result['data']['id'],
                'url' => $result['data']['payment_url'],
                'token' => $token
            ];
            
            return $this->showResult(true, $response_data, 'Redirecting to payment page');
        }
        
        return $this->showResult(false, $result, 'خطا در دریافت لینک پرداخت از سلفیت');
    }

    /**
     * Verify payment with SELFiT API
     *
     * @param array $verify_params
     * @return array
     */
    public function verifyPayment($verify_params = []) {
        functions::insertLog('SELFiT verify request: ' . json_encode($verify_params, JSON_UNESCAPED_UNICODE), 'selfit_log');
        
        $factorNumber = $verify_params['factor_number'];
        $paymentId = isset($verify_params['payment_id']) ? $verify_params['payment_id'] : '';
        $token = isset($verify_params['token']) ? $verify_params['token'] : '';
        
        // If token and payment_id aren't provided in verify_params, try to get them from URL parameters
        if (empty($paymentId) && isset($_GET['payment_id'])) {
            $paymentId = $_GET['payment_id'];
        }
        
        if (empty($token) && isset($_GET['token'])) {
            $token = $_GET['token'];
        }
        
        if (empty($paymentId) || empty($token)) {
            return $this->showResult(false, [], 'اطلاعات پرداخت ناقص است');
        }
        
        // Call verification API
        $verifyUrl = $this->verifyUrl . "?id=" . urlencode($paymentId);
        
        $headers = [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ];
        
        $result = $this->bank->selfitCurlExecution($verifyUrl, null, 'json', [], $headers, 'GET');
        
        functions::insertLog('SELFiT verify response: ' . json_encode($result, JSON_UNESCAPED_UNICODE), 'selfit_log');

        if (isset($result['data']) &&
            isset($result['data']['transaction_status']) &&
            $result['data']['transaction_status'] === 'Paid'
        && (isset($result['data']['invoice_status']) &&
                $result['data']['invoice_status'] === 'Complete')
        && (isset($result['isSuccess']) &&
                $result['isSuccess'] === true)
        ) {
            $response_data = [
                'transaction_id' => $factorNumber,
                'factorNumber' => $factorNumber,
                'trackingCode' => $factorNumber,
                'rrn' => '',
                'card_number' => ''
            ];
            
            return $this->showResult(true, $response_data, 'پرداخت با موفقیت انجام شد');
        }
        
        // Check for specific error messages
        if (isset($result['isSuccess']) && $result['isSuccess'] === false) {
            $errorMessage = isset($result['message']) ? $result['message'] : 'پرداخت انجام نشد یا با خطا مواجه شد';
            
            // Customize error messages based on status code
            if (isset($result['statusCode'])) {
                switch ($result['statusCode']) {
                    case 'NotFound':
                        $errorMessage = 'تراکنش مورد نظر یافت نشد';
                        break;
                    case 'Unauthorized':
                        $errorMessage = 'خطای احراز هویت در سامانه سلفیت';
                        break;
                    case 'BadRequest':
                        $errorMessage = 'درخواست نامعتبر به سامانه سلفیت ارسال شده است';
                        break;
                }
            }
            
            $response_data = [
                'factorNumber' => $factorNumber,
                'errorMessage' => $errorMessage
            ];
            
            return $this->showResult(false, $response_data, $errorMessage);
        }
        
        $response_data = [
            'factorNumber' => $factorNumber
        ];
        
        return $this->showResult(false, $response_data, 'پرداخت ناموفق بود');
    }
    
    /**
     * Cancel payment with SELFiT API
     *
     * @param array $cancel_params
     * @return array
     */
    public function cancelPayment($cancel_params = []) {
        functions::insertLog('SELFiT cancel request: ' . json_encode($cancel_params, JSON_UNESCAPED_UNICODE), 'selfit_log');
        
        $paymentId = isset($cancel_params['payment_id']) ? $cancel_params['payment_id'] : '';
        $token = isset($cancel_params['token']) ? $cancel_params['token'] : '';
        
        if (empty($paymentId) || empty($token)) {
            return $this->showResult(false, [], 'Missing payment ID or token');
        }
        
        // Prepare cancel request
        $data = [
            'id' => $paymentId
        ];
        
        $headers = [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ];
        
        $result = $this->bank->selfitCurlExecution($this->cancelUrl, json_encode($data), 'json', [], $headers);
        
        functions::insertLog('SELFiT cancel response: ' . json_encode($result, JSON_UNESCAPED_UNICODE), 'selfit_log');
        
        if (isset($result['success']) && $result['success'] === true) {
            return $this->showResult(true, [], 'Payment cancelled successfully');
        }
        
        return $this->showResult(false, $result, 'Payment cancellation failed');
    }
} 