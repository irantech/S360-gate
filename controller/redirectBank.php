<?php

//            error_reporting(1);
//            error_reporting(E_ALL | E_STRICT);
//            @ini_set('display_errors', 1);
//            @ini_set('display_errors', 'on');

class redirectBank extends clientAuth {

    public $redirectBankModel ;
    public function __construct() {
        parent::__construct();
        $this->redirectBankModel  = $this->getModel('redirectBankModel');
    }
    public function redirectBankUrls() {

        if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20' ) {

            session_start();
//            error_reporting(1);
//            error_reporting(E_ALL | E_STRICT);
//            @ini_set('display_errors', 1);
//            @ini_set('display_errors', 'on');


        }
        $redirect_bank   = $this->redirectBankModel->get(['*'])
            ->where('client_id' , CLIENT_ID)->where('active' , 1)->find();

        if($redirect_bank) {
            return $redirect_bank ;
        }else{
            return false;
        }
    }

    public function replaceRedirectBankUrls() {

        $redirect_bank   = $this->redirectBankModel->get(['*'])
            ->where('replace_client_id' , CLIENT_ID)->where('active' , 1)->find();
        if($redirect_bank) {
            return $redirect_bank ;
        }else{
            return false;
        }
    }

    public function createReturnUrl($params) {

        $getParams = '';

        unset($params['redirectUrl']);

        foreach ($params as $key=>$param) {
            if($key && $param) {
                $getParams .= '&'.$key.'='.$param ;
            }

        }

        return $getParams ;
    }

}