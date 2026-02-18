<?php


class postage
{

    public $requestUrl='https://postbar.myna.ir/api/';
    public $client_token='df2c64b9b691ef4bfd1a2ad0fe81987fa7b983027f2383849b6dcca8d4ad75a26dea579b0abe8ab2d6246c027167a83672f2023fc6af42532581fadb05eb43ad';
    public $ClientName;

    public function __construct()
    {

    }
    public function curlExecutionPost($url, $data)
    {

        $handle=curl_init($url);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $this->getJson_encode($data));
        curl_setopt($handle, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
        ));
         $result=curl_exec($handle);

                functions::insertLog("response => ".$result, 'hsauighduig');

        return json_decode($result, true);
    }

    public function getJson_encode($array)
    {
        return json_encode($array);
    }



    public function loginApp()
    {
        $url=$this->requestUrl.'gds/login';
        $response=$this->curlExecutionPost($url, [
            'email'=>'a@a.com',
            'password'=>'a',
            'client_token'=>$this->client_token
        ]);


        return $response['user'];
    }

    public function shipmentList()
    {
        $loginApp=$this->loginApp();



        $url=$this->requestUrl.'get/shipments';
        $response=$this->curlExecutionPost($url, [
            'token'=>$loginApp['token']
        ]);


        return $response;
    }
    public function changeAccessResponse($params)
    {
        $loginApp=$this->loginApp();
        $url=$this->requestUrl.'edit/AccessResponse/shipment';

        $response=$this->curlExecutionPost($url, [
            'token'=>$loginApp['token'],
            'shipment_id'=>$params['shipment_id'],
        ]);

        return $response;
    }
    public function ChangeUserType($params)
    {
        $loginApp=$this->loginApp();
        $url=$this->requestUrl.'user/edit/userType';

        $response=$this->curlExecutionPost($url, [
            'token'=>$loginApp['token'],
            'user_id'=>$params['user_id'],
        ]);

        return $response;
    }
    public function usersList()
    {
        $loginApp=$this->loginApp();
        $url=$this->requestUrl.'users/list';

        $response=$this->curlExecutionPost($url, [
            'token'=>$loginApp['token'],
        ]);

        return $response;
    }
}