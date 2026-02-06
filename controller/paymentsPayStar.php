<?php
class paymentsPayStar extends clientAuth {
    private $bankParam1='';
    private $serviceType='';
    private $factorNumber='';
    private $callBackPage='';

    public function __construct()
    {

    }
    public function curlForCallSafar360($params){



        $data = json_encode([
            'amount' => $params['amount'],
            'clientID' => $params['clientID'],
            'operation' => 'go'
        ]);


        $url = "https://safar360.com/gds/fa/creditTopUp";
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json; charset=UTF-8',
            'Content-Length: ' . strlen($data)
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        header('Content-Type: application/json; charset=utf-8');

        if ($http_code == 200) {
            $result = json_decode($response, true);
            if ($result['success']) {
                return self::returnJson(true,'سلام 2', $result['data']['link']);
            } else {
                return self::returnJson(false, 'خطای من' , $response);
            }
        } else {
            return self::returnJson(false, 'خطا در ارتباط با سرور شارژ - ' . $http_code);
        }
    }

    public function initiatePaystarPayment($paramsPost) {

        //$this->initBankPa rams('PayStar');
        $this->bankParam1='dn15z0we2zk277';
        $this->serviceType = 'All';
        $this->factorNumber = 'ch' . functions::generateFactorNumber();
        $this->callBackPage = 'https://safar360.com/gds/fa/returnPaystarCreditTopUp';
        require_once(LIBRARY_DIR . 'bank/payStar/payStar.php');
        $bankPayStar = new paystar();

        if ($paramsPost['operation'] == 'go') {
            $params['gateway_id'] = $this->bankParam1;
            $params['amount'] = $paramsPost['price'];
            $params['order_id'] = $this->factorNumber;
            $params['callback'] = $this->callBackPage;

            $request_payment = $bankPayStar->requestPayment($params);

            functions::insertLog('requestPayment : ' . json_encode([
                    'params' => $paramsPost,
                    'request_payment' => $request_payment,
                ], 256), 'logTopUpPaystar_request');

            if ($request_payment['success']) {
                $link = $request_payment['data']['link'];
                header('Location:' . $link);
                exit;
            } else {
                return functions::withError([
                    'message' => $request_payment['message'] ?? functions::Xmlinformation('ErrorConnectBank')->__toString()
                ]);
            }

        }

        /*elseif ( $paramsPost['operation'] == 'return' ) {
            $params['ref_num'] = $_POST['ref_num'] ?? $_GET['ref_num'] ?? '';
            $params['order_id'] = $_POST['order_id'] ?? $_GET['order_id'] ?? '';
            $params['tracking_code'] = $_POST['tracking_code'] ?? $_GET['tracking_code'] ?? '';
            //$params['amount'] = $this->amountToPay; مقدارش صفر بود تو تابع veryfy پرش می کنیم
            $params['gateway_id'] = $this->bankParam1;

            $verify_payment = $bankPayStar->verifyPayment($params);

            functions::insertLog('verifyPayment : ' . json_encode([
                    'params' => $params,
                    'verify_payment' => $verify_payment,
                ], 256), 'logBankPaystar_verify');

            if ( $verify_payment['success'] ) {
                return $this->returnMethod(true, $operation, [
                    'factorNumber' => $verify_payment['data']['order_id'],
                    'amount' => $verify_payment['data']['amount'],
                    'trackingCode' => $verify_payment['data']['tracking_code'],
                ]);
            } else {
                return $this->returnMethod(false, $operation, [
                    'factorNumber' => $params['order_id'],
                    'failMessage' => $verify_payment['message'],
                    'transactionStatus' => 'failed',
                ]);
            }
        }*/


    }
    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        return json_encode([
            'success' => $success,
            'message' => $message,
            'code' => $statusCode,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

}