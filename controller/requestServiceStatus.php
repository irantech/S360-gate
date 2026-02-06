<?php

class requestServiceStatus extends clientAuth
{
    private $requestServiceStatusTb;

    public function __construct()
    {
        parent::__construct();

        $this->requestServiceStatusTb = 'request_service_status_tb';
    }

    /**
     * @param $status_id
     * @return array|bool|mixed|string
     */
    public function getRequestServiceStatus($status_id){
        $request_service_status_model = $this->getModel('requestServiceStatusModel') ;
        $result =  $request_service_status_model->get()
            ->where('value',$status_id)
            ->find();
        return  $result;
    }

    /**
     * @return array
     */
    public function getRequestServiceStatusList(){

        $request_service_status_model = $this->getModel('requestServiceStatusModel')->get() ;

        return  $request_service_status_model->all();
    }



}
?>