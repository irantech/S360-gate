<?php

class apiStripe
{
    public $secretKey;
    public $address;

    public function __construct()
    {

    }

    public function init()
    {
        $bank = functions::InfoBank('1');
        $this->bankDir = $bank['bank_dir'];
        $this->secretKey = $bank['param1'];
        $this->address = 'https://api.stripe.com/v1/';
    }

    public function curlExecution($url, $data)
    {
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $this->secretKey));
        $result = curl_exec($handle);
        return json_decode($result, true);
    }

    public function createCardToken($params)
    {
        $url = $this->address . 'tokens';
        $data = "card[number]=" . $params['cardNumber'] .
                "&card[exp_month]=" . $params['cardExpireMonth'] .
                "&card[exp_year]=" . $params['cardExpireYear'] .
                "&card[cvc]=" . $params['cardCVC'];
        $result = $this->curlExecution($url, $data);

        if(!empty($result['error'])){

            $output['status'] = false;
            $output['message'] = $result['error']['message'];

        } else{
            $output['status'] = true;
            $output['token'] = $result['id'];
        }

        return $output;
    }

    public function chargeByToken($params)
    {
        $url = $this->address . 'charges';
        $data = "amount=" . $params['amount'] .
                "&currency=" . $params['currency'] .
                "&source=" . $params['token'] .
                "&metadata[factor_number]=" . $params['factorNumber'] .
                "&description=" . $params['description'];
        $result = $this->curlExecution($url, $data);

        if(!empty($result['error'])){

            $output['status'] = false;
            $output['message'] = $result['error']['message'];

        } else{
            $output['status'] = true;
            $output['result'] = $result['id'];
        }

        return $output;
    }
}

?>