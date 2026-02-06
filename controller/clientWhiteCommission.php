<?php


class clientWhiteCommission extends clientAuth{

    public function __construct(){
        parent::__construct();
    }


    public function getCommissionPartner($data){
        return $this->getModel('clientWhiteCommissionModel')->get()->where('client_id',$data['client_id'])->where('client_id_parent',$data['parent_id'])->where('detail_type',$data['detail_type'])->where('type',$data['type'])->find();
    }

    public function deletedCommission($data){
        $resultDeleteCommission = $this->getModel('clientWhiteCommissionModel')->delete("id='{$data['id']}'");

        if(!$resultDeleteCommission){
            return functions::withError('',400,'خطا در حذف کمیسیون');
        }
        return functions::withSuccess('',200,'حذف با موفقیت انجام شد');
    }



}