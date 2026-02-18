<?php
require_once(LIBRARY_DIR . 'bank/BankBase.php');

class nextPay extends BankBase
{

    private $url = 'https://nextpay.ir/nx/gateway/';

    private function curlRequest($url,$request_data)
    {



          $data_string = http_build_query($request_data);
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING , "");
        curl_setopt($ch, CURLOPT_MAXREDIRS  , 10);
        curl_setopt($ch, CURLOPT_TIMEOUT   , 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION    , true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION     , CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        $result = curl_exec($ch);
        curl_close($ch);


        $log=[
            'request_url'=>$url,
            'request'=>$request_data,
            'response'=>$result,
        ];

        functions::insertLog(json_encode($log),'nextpayLog');

        return json_decode($result, JSON_OBJECT_AS_ARRAY);
    }
    public function requestPayment($request_data = [])
    {
        $url = $this->url . 'token';

        $api_key= $request_data['api_key'];
        $amount = functions::convert_rial_toman($request_data['amount']);
        $factor_umber = $request_data['factor_number'];
        $call_back_url = $request_data['revertURL'];

        $request=[
            'api_key'=>$api_key,
            'order_id'=>$factor_umber,
            'amount'=>$amount,
            'callback_uri'=>$call_back_url,
        ];



        $response =$this->curlRequest($url,$request);


        if ($response["code"] != "-1") {
            return $this->showResult(false, $response, 'Error code = '.$response["code"]);
        }
        return $this->showResult(true, $response, 'go to payment page');

    }

    /**
     * @inheritDoc
     */
    public function verifyPayment($verify_params = [])
    {
        $url = $this->url . 'verify';


        $api_key= $verify_params['api_key'];
        $trans_id = $verify_params['trans_id'];
        $amount = functions::convert_rial_toman($verify_params['amount']);


        $request=[
            'api_key'=>$api_key,
            'trans_id'=>$trans_id,
            'amount'=>$amount,
        ];


        $response =$this->curlRequest($url,$request);



        if ($response["code"] != "0") {
            $message='Error code = '.$response["code"];
            $response['factorNumber'] = $response['order_id'];
            if ($response["code"] == "-4") {
                $message=functions::Xmlinformation( 'NoPayment' )->__toString();
            }

            return $this->showResult(false, $response,$message);
        }



        $response_array=[
            'trackingCode'=>$response['Shaparak_Ref_Id'],
            'amount'=>functions::convert_toman_rial($response['amount']),
            'factorNumber'=>$_GET['order_id'],
        ];
        return $this->showResult(true, $response_array, 'تراکنش انجام شد');

    }
}