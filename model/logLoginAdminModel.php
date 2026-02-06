<?php

class logLoginAdminModel extends Model
{
    protected $table = 'log_login_admin_tb';

    public function insertDataLog() {
        //        $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
        $data_log =[
            'ip'=>$_SERVER['REMOTE_ADDR'],
            'browser'=>$_SERVER['HTTP_USER_AGENT'],
            'creation_date_int'=> time(),
        ];

        $this->insertWithBind($data_log);
    }

}