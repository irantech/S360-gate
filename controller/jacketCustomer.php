<?php

//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

/**
 * Class members
 * @property jacketCustomer $jacketCustomer
 */

class jacketCustomer extends clientAuth {

    protected $jacketCustomerModel ;

    public function __construct() {

        $this->jacketCustomerModel = $this->getModel('jacketCustomerModel');
    }

    public function insertCustomer( $params ) {

        $ClientID = !empty($params['ClientId'])? $params['ClientId'] : CLIENT_ID ;

        $data['clientId']   = $ClientID;
        $data['password']   = $params['password'];
        $data['userName']   = $params['userName'];
        $data['isActive']   = 'no';

            $result =  $this->jacketCustomerModel->insertWithBind($data);


        if($result)
        {
            return "success : ثبت مشتری با موفقیت انجام شد ";
        }else{
            return "error : خطا در ثبت مشتری";
        }

    }

    public function jacketCustomerClient( $client_id ) {

        return $this->jacketCustomerModel->get()->where('clientId' , $client_id)->find();
    }

    public function checkJacketCustomer( $param ) {

        $password = functions::encryptPassword($param['password']);
        $result = $this->jacketCustomerModel->get()
            ->where('userName' , $param['userName'])
            ->where('password' , $password);

        if(isset($param['ipAddress']) && !empty($param['ipAddress'])){
            $result = $result->where('ipAddress' , $param['ipAddress']);
        }

        $result = $result->find();


        if($result) {
            return true ;
        }
        return false;
    }

    public function getJacketCustomerInfo( $param ) {

        $password = functions::encryptPassword($param['password']);
        $clientAuthModel = Load::getModel('clientAuthModel');
        $ModelBase = new ModelBase();

        $customer = $this->jacketCustomerModel->get()
            ->where('userName' , $param['userName'])
            ->where('password' , $password)
            ->where('ipAddress' , $param['ipAddress'])
            ->find();

        if($customer) {
            $customer['password'] = $param['password'];
            $accessesClient = $clientAuthModel->getAccessServiceClient($customer['clientId']);
            $SqlClient ="SELECT Domain ,MainDomain ,Title ,Logo FROM clients_tb WHERE id = '{$customer['clientId']}'";
            $client  = $ModelBase->select($SqlClient);
            return [
                'customer'    => $customer ,
                'accessList'  => $accessesClient ,
                'client'      => $client ,
            ];

        }

        return false;
    }

    public function checkActivate( $param ) {
        return $this->jacketCustomerModel->get()
            ->where('clientId' , $param['clientId'])
            ->find();
    }
}