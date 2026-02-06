<?php

class marketplaceCommission extends clientAuth
{
    public $model;

    public function __construct() {
        parent::__construct();

        $this->model = $this->getModel('marketplaceCommissionModel');
    }

    public function insertCommissionMarketplace($data)
    {

        $is_market  = $this->checkMarketplaceService($data);
        if(!$is_market) {
            return functions::withError('', 400, 'هتلی یافت نشد.');
        }
        $commissionExist = $this->model->get()
        ->where('type_id', $data['type_id'])
        ->where('type', $data['type'])->find();
        if (!$commissionExist || ($commissionExist && !empty($commissionExist['deleted_at']))){
            $resultInsertCommission =  $this->model->insertWithBind($data);

            if(!$resultInsertCommission)
            {
                return functions::withError('', 400, 'خطا در تعریف کمیسیون');
            }
            return functions::withSuccess('',200,'کمیسیون با موفقیت تنظیم شد');
        }else{
            $resultUpdateCommission =  $this->model->updateWithBind($data , ['type_id' => $data['type_id'] , 'type' => $data['type']]);
            if(!$resultUpdateCommission)
            {
                return functions::withError('', 400, 'تغییری یافت نشد.');
            }
            return functions::withSuccess('',200,'کمیسیون با موفقیت تنظیم شد');
        }
    }

    public function getCommissionMarketplace($data){
        return $this->model->get()->where('type_id',$data['service_id'])
            ->where('type',$data['type'])->orWhereNull('deleted_at')->find();
    }
    public function checkMarketplaceService($params) {

        if($params['type'] == 'hotel'){
            $type_class = $this->getController('reservationHotel');
            $type = $type_class->getHotelById(['id' => $params['type_id']]) ;
            if($type['user_id']){
                return true ;
            }
        }
        return false;
    }

}
