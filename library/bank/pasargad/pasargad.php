<?php
require_once(LIBRARY_DIR . 'bank/BankBase.php');

class pasargad extends BankBase
{

    private $url = 'https://pep.shaparak.ir/dorsa1';

    public function requestPayment($request_data = [] ) {

//        if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
//            var_dump($request_data);
//            die();
//        }
        $url = $this->url . '/api/payment/purchase';
        $token = $request_data['token'] ;
        unset($request_data['token']);
        $response = $this->CallAPI($url,json_encode($request_data)  ,$token );
        
        if ($response["resultCode"] != "0") {
            return $this->showResult(false, $response, 'Error code = ' . $response["resultMsg"]);
        }


        return $this->showResult(true, [
            'link' => $response['data']['url'],
            'urlId' => $response['data']['urlId'],
        ], 'go to payment page');

    }

    public function getToken($request_data = []) {

        $url = $this->url . '/token/getToken';

        $userName = $request_data['username'];
        $password = $request_data['password'];

        $request = array(
            'username' => $userName,
            'password' => $password
        );
        functions::insertLog('before token ==>'.json_encode($request,256),'logBankPasargad');

        $response = $this->CallAPI($url, json_encode($request));
        functions::insertLog('after token ==>'.json_encode($response,256),'logBankPasargad');

        if ($response["resultCode"] != "0") {
            return $this->showResult(false, $response, 'Error code = ' . $response["resultMsg"]);
        }


        return $this->showResult(true, [
            'token' => $response['token'],
        ], 'get token');
    }


    private function CallAPI($url,$request_data, $token = null)
    {


        $handle = curl_init( $url );
        curl_setopt( $handle, CURLOPT_POST, true );
        curl_setopt( $handle, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $handle, CURLOPT_SSL_VERIFYHOST, 0 );
        curl_setopt( $handle, CURLOPT_SSL_VERIFYPEER, 0 );
        curl_setopt( $handle, CURLOPT_POSTFIELDS, $request_data );

        if ( isset($token) && !empty($token)) {

            curl_setopt( $handle, CURLOPT_HTTPHEADER,
                array('Content-Type: application/json' ,
                'Authorization: Bearer '.$token ) );
        }else{
            curl_setopt( $handle, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json' ) );
        }
        $result  = curl_exec( $handle );
        return json_decode($result, JSON_OBJECT_AS_ARRAY);
    }

    /**
     * @inheritDoc
     */
    public function verifyPayment($verify_params = []) {

        $url = $this->url . '/api/payment/confirm-transactions';
        $token = $verify_params['token'] ;
        unset($verify_params['token']);

        $response = $this->CallAPI($url,json_encode($verify_params)  ,$token );

        if ($response["resultCode"] == 0) {

            $response_array = [
                'trackingCode' => $response["data"]['trackId'],
                'amount' => $response["data"]['amount'],
                'factorNumber' => $verify_params['invoice'],
            ];
            
            return $this->showResult(true, $response_array, 'تراکنش انجام شد');
        }else{

            if($response['resultCode'] && $response['resultCode'] == '13325'){
                return $this->showResult(false, [], 'پرداختی انجام نشده است. (شما از پرداخت انصراف داده اید)');
            }elseif ($response['resultCode'] && $response['resultCode'] == '13016'){
                return $this->showResult(false, [], ' تراکنشی یافت نشد.');
            }elseif ($response['resultCode'] && $response['resultCode'] == '13022'){
                return $this->showResult(false, [], ' تراکنش پرداخت نشده است.');
            }elseif ($response['resultCode'] && $response['resultCode'] == '13030'){
                return $this->showResult(false, [], 'تراکنش تایید شده و ناموفق است. ');
            }elseif ($response['resultCode'] && $response['resultCode'] == '13031'){
                return $this->showResult(false, [], 'تراکنش در انتظار تایید است. ');
            }
            elseif ($response['resultCode'] && $response['resultCode'] == '13046'){
                return $this->showResult(false, [], 'تراکنش تسویه شده است. ');
            }else{
                $message = ' نتیجه تراکنش ناموفق بود.';
                $response['factorNumber'] = $verify_params['invoice'];
                return $this->showResult(false, $response, $message);
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
    }
}