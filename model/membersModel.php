<?php


class membersModel extends Model {

    protected $table = 'members_tb';

    public function __construct() {
        parent::__construct();
    }

    public function getMemberById($id) {
        if (Session::IsLogin() && !$id) {
            $id = Session::getUserId();
        }
        return $this->get()->where('id', $id)->where('active','on')->find();
    }
    public function getMemberByUserName($params) {
        return $this->get()->where('user_name',$params['entry'])->where('active','on')->find();
    }
    public function getExistMemberByUserName($params) {
        return $this->get()->where('user_name',$params['entry'])->find();
    }
    public function getMemberByUserAndPassword($params) {

        return $this->get()->where('user_name',$params['entry'])->where('password',$params['password'])->where('active','on')->find();
    }

    public function registerGustUser($params,$index) {

     return parent::update($params,"{$index}='{$params['user_name']}'");
    }

    public function getMaxCardNumberMembers() {
        return  $this->get(['MAX(card_number) as MaxCardNo'], true)->find();
    }

    public function getReagentCode($reagent_code) {
        return $this->get()->where("reagent_code",$reagent_code)->find();
    }

    public function registerMember($params) {
        $this->insertLocal($params);
        return $this->getLastId();
    }

    public function updateMember($data,$id) {
        return $this->update($data,"id='{$id}'");
    }

}