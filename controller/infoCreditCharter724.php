<?php

class infoCreditCharter724 extends clientAuth
{
    public function __construct() {
        parent::__construct();
    }


    public function getCreditCharter724OfDb() {

        return  $this->getModel('checkCreditCharter724Model')->getLastRecordeCreditCharter724();
    }

    public function setRecordeCreditCharter724($credit) {
        $data_request=[
            'price'=> $credit,
            'creation_date_int'=> time(),
        ];
        $this->getModel('checkCreditCharter724Model')->insertRecordeCreditCharter724($data_request);
    }

    public function checkTimeSetRecordeCredit() {
        $time= (int) (time() - 120) ;

        $last_recorde = $this->getCreditCharter724OfDb();
        if($last_recorde['creation_date_int'] < $time || $last_recorde['price']==0 || empty($last_recorde)){
            return true ;
        }
        return false ;
    }

    public function getCreditCharter724() {

        $is_send_data_online = $this->checkTimeSetRecordeCredit();

        if($is_send_data_online){
            $url       = "http://safar360.com/Core/V-1/Flight/getCredit/irantechTest";
            $JsonArray = [];
            $credit =  functions::curlExecution( $url, $JsonArray, 'yes' );

            if($credit['data']['child_charge'] > 0){
                $this->setRecordeCreditCharter724($credit['data']['child_charge']);
            }
            return functions::withSuccess(['credit'=>number_format($credit['data']['child_charge'])],200,'ok');
        }
        $last_recorde = $this->getCreditCharter724OfDb();

        return functions::withSuccess(['credit'=>(!empty($last_recorde) ? number_format($last_recorde['price']) : 0)],200,'ok');


    }

}