<?php
class login_tb extends ModelBase{
	protected $table = 'login_tb';
	protected $pk = 'id';

	function login($username,$password,$ClientId=null){

		if(!empty($ClientId))
        {
            $token = filter_var($ClientId,FILTER_SANITIZE_STRING);
//            $Sql = "CALL loginAdminAuto('{$token}')";
            $Sql = "SELECT * FROM login_tb WHERE token='{$token}'";
        }else{
            $password=functions::encryptPassword($password);
            $client_id = CLIENT_ID ;
//            $Sql = "CALL loginAdmin('{$username}','{$password}','{$client_id}')";
             $Sql="SELECT is_enable FROM login_tb WHERE username ='{$username}' AND password = '{$password}' AND client_id='{$client_id}'";
        }

        return parent::load($Sql);
	}



}
