<?php

class apiGateWayCharter724 extends clientAuth
{

    protected $site_id ;
    protected $charge_type;
    protected $url ;
    public function __construct() {

        $this->site_id = 10939;
        $this->charge_type = 2;
        $this->url = "https://charter725.ir/webservice/bank_common/";
    }


    public function getToken($params) {

        if ($params['price'] >= '20000000' && $params['price'] <= '1000000000') {
            $api_url = $this->url . "gettoken.php";
            $data_request = [
                'site_ID' => $this->site_id,
                'charge_type' => $this->charge_type,
                'price' => $params['price']
            ];

            $token = functions::curlExecution($api_url, $data_request);
            functions::insertLog('getToken' . json_encode($token), '0_check_bank_charter');

            if (isset($token['token'])) {
                $params['token'] = $token['token'];
                $result_set_transaction = $this->getController('transaction')->setPrimitiveTransactionForGateWayCharter724($params);
                if ($result_set_transaction) {

                    $return_param = [
                        'token' => $token['token'],
                        'factor_number' => $result_set_transaction,
                        'url' => $this->url . 'sendBank.php'
                    ];
                    return functions::withSuccess($return_param, 200, 'ok');
                }
                return functions::withError('', 400, 'خطا در ثبت درخواست');
            }
            return functions::withError('', 400, 'خطا در اجرای درخواست');
        }
        return functions::withError('', 400, 'مبلغ وارد شده باید بین 20,000,000 ریال و  1,000,000,000 ریال باشد');
    }

    public function verifyTransaction($token) {

        $api_url = $this->url . "verify_bank.php";
        $data_request = [
            'site_ID' => $this->site_id,
            'token'=> $token,
        ];

        $check_status =  functions::curlExecution($api_url,$data_request);

        functions::insertLog('verify with token'. $token.'=>'.json_encode($check_status),'0_check_bank_charter');

        if($check_status['State']=='OK'){
            return $check_status ;
        }
        return false ;
    }
}

