<?php

//if($_SERVER['REMOTE_ADDR'] == '93.118.161.174') {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}
class agency_tb extends Model
{

    protected $table = 'agency_tb';
    protected $pk = 'id';

    public function getAll()
    {
        $result = parent::select("select * from $this->table where del='no'  ORDER BY $this->pk ASC");

        return $result;
    }

    public function getPrimaryAgency(){
    	$result = parent::load("SELECT * FROM {$this->table} WHERE isColleague='0' LIMIT 0,1");
    	return $result;
    }

    public function insertAgency($data)
    {
        return  parent::insertLocal($data);
    }

    public function get($id)
    {
        return parent::load("select * from {$this->table} where {$this->pk} = '{$id}' and  del='no'");
    }

    public function update_for_edit($dataEditAgency,$id)
    {
        return  parent::update($dataEditAgency, "id='{$id}'");
    }

    public function getLastId()
    {
        return parent::getLastId();
    }

    public function login($email, $password)
    {
        $password = functions::encryptPassword($password);
        $email = strtolower($email);
        return parent::load("select * from $this->table where (email = '$email' OR mobile = '$email') and password='$password' and active='on'");
    }

}
