<?php

class marketPlaceRole extends clientAuth
{
    public $model;
    public function __construct() {
        parent::__construct();

        $this->model = $this->getModel('marketPlaceRoleModel');
    }

    public function setRoleMember($params){
        $data_insert = [
          'member_id'   => $params['member_id'] ,
          'role_id'     => $params['role_id'] ,
        ];
        $insert = $this->model->insert($data_insert) ;

    }

    public function hasAccess($params) {
        $result =   $this->model->get('*')
            ->join('market_place_role_tb' , 'id' , 'role_id')
            ->where('member_id' , Session::getUserId())
            ->where('title' , $params['role'])
            ->find();
        if($result) {
            return true ;
        }
        return false ;
    }

    public function setMarketPlaceMember($params) {
        $member_model = $this->getModel('members');
        $result_insert_member = $member_model->memberInsert($params) ;

        $role_member_params = [
            'member_id'       => $result_insert_member  ,
            'role_id'         => $params['role_id']  ,
        ];
        $this->setRoleMember($role_member_params);
    }
}