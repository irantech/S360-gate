<?php

class loginModel extends ModelBase
{

    protected $table = 'login_tb';
    protected $pk = 'id';

    function login($data_login) {
        if (!empty($data_login['client_id'])) {
            $token = filter_var($data_login['client_id'], FILTER_SANITIZE_STRING);


            return $this->get()->where('token', $token)->find();
        }
        $password = functions::encryptPassword($data_login['password']);
        return $this->get(['is_enable'])->where('username', $data_login['username'])->where('password', $password)->where('client_id', CLIENT_ID)->find();
    }

    function  updateLastLogin($CLIENT_ID)
    {
        $return=$this->get()->updateWithBind(['last_login'=>date('Y-m-d H-i-s')],['client_id'=>$CLIENT_ID]);

    }
}