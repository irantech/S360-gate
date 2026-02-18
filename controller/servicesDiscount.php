<?php

/**
 * Class servicesDiscount
 * @property servicesDiscount $servicesDiscount
 */
class servicesDiscount extends clientAuth {

    public $list = array();     //array that include list of discounts
    public $services = array();     //array that include list of services

    public function __construct() {
        parent::__construct();
    }

    //region [listServiceDiscount]
    /**
     * @return array
     */
    public function listServiceDiscount()
    {
        return $this->getModel('servicesDiscountModel')->get()->all();
    }
    //endregion

    //region [listSpecialServiceDiscount]
    /**
     * @return array
     */
    public function listSpecialServiceDiscount(){
        $all_services = $this->getModel('servicesModel')->get()->all();

        $new_array_all_services = array();
        foreach ($all_services as $service){
            $new_array_all_services[$service['TitleEn']] = $service;
        }

        $special_discounts = $this->getAllSpecialDiscount();

        $new_array_special_discounts = array();

        foreach ($special_discounts as $key=>$discount) {
            $new_array_special_discounts[$key]['id'] = $discount['id'];
            $new_array_special_discounts[$key]['service_title'] = $new_array_all_services[$discount['service_title']]['TitleFa'];
            $new_array_special_discounts[$key]['amount'] = $discount['amount'].(($discount['type_discount']=='cash') ? 'ریال' : 'درصد');
            $new_array_special_discounts[$key]['type_discount'] = ($discount['type_discount']=='cash') ? 'ریالی' : 'درصدی';
            $new_array_special_discounts[$key]['type_get_discount'] =($discount['type_get_discount']=='phone') ? 'تلفن همراه کاربر' : 'کد ملی';
            $new_array_special_discounts[$key]['pre_code'] = $discount['pre_code'];
            $new_array_special_discounts[$key]['is_del_title'] = ($discount['is_del'] =='0') ? 'فعال' : 'غیر فعال';
            $new_array_special_discounts[$key]['is_del'] = $discount['is_del'] ;
            $new_array_special_discounts[$key]['creation_date_int'] = dateTimeSetting::jdate('Y-m-d H:i:s',$discount['creation_date_int'],'','','en');
        }


       return $new_array_special_discounts ;
    }
    //endregion

    public function getAllSpecialDiscount() {
        return  $this->getModel('specialServiceDiscountModel')->get()->where('is_del',0)->all();
    }
    public function getAllSpecialDiscountByType($type) {
        return  $this->getModel('specialServiceDiscountModel')->get()->where('type_get_discount',$type)->where('is_del',0)->all();
    }
    #region [update]

    /**
     * @param $input
     * @return string
     */
    public function update($input) {

        $Model = new Model();
        $Model->setTable('services_discount_tb');

        $record = $this->getDiscountByCounterAndService($input['counterID'], $input['serviceTitle']);
        if($record['id'] > 0) {
            $data['off_percent'] = $input['offPercent'];
            $condition = " counter_id = '{$input['counterID']}' AND service_title = '{$input['serviceTitle']}' ";
            $res = $Model->update($data, $condition);
        } else{
            $data['off_percent'] = $input['offPercent'];
            $data['service_title'] = $input['serviceTitle'];
            $data['counter_id'] = $input['counterID'];
            $data['creation_date'] = date('Y-m-d H:i:s');
            $if_market = false ;
            if($input['serviceTitle'] == 'marketplaceHotel') {
                $if_market = $this->checkMarketplaceService($input) ;
                if(!$if_market) {
                    return 'error : هتلی با این مشخصات در سیستم مارکت پلیس یافت نشد';
                }

            }
            $res = $Model->insertLocal($data);
            if($if_market) {
                $record = $Model->get()->orderBy('id' , 'desc')->find();
                $this->setMarketplaceService($input , $record['id']) ;
            }
        }

        if ($res) {
            return 'success :  تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در تغییرات';
        }

    }
    #endregion

    #region [get all flight price changes records]

    /**
     *
     */
    public function getAll() {

        $result = $this->listServiceDiscount();
        foreach ($result as $record){
            $service = $record['service_title'];
            $counter = $record['counter_id'];
            $this->list[$service][$counter] = $record;

        }

    }
    #endregion

    #region [get one record of services discount by counter_id and service_id]

    /**
     * @param $TypeCounter
     * @param $service
     * @return mixed
     */
    public function getDiscountByCounterAndService($TypeCounter, $service) {
        return $this->getModel('servicesDiscountModel')->get()->where('counter_id',$TypeCounter)
            ->where('service_title',$service)->find();

    }
    #endregion

    #region [get all services records]
    /**
     * get all services
     * @return array of services
     *
     */
    public function getAllServices() {
        $this->services = $this->getModel('servicesModel')->get()->all();
        return $this->services ;
    }
    #endregion

    #region [setDiscountForAll: set discount for all services and counters]

    public function setDiscountForAll($input) {

        $counterType = Load::controller('counterType');
        $counterType->getAll('all');

        $this->getAllServices();

        foreach ($this->services as $eachService){
            if(!in_array($eachService['TitleEn'], array('PrivateLocalHotel', 'PrivatePortalHotel', 'PrivateLocalCharter', 'PrivatePortalCharter'))) {
                foreach ($counterType->list as $eachCounter) {

                    $data['counterID'] = $eachCounter['id'];
                    $data['serviceTitle'] = $eachService['TitleEn'];
                    $data['offPercent'] = $input['serviceDiscountAll'];
                    $resultSet = $this->update($data);

                }
            }
        }

        return $resultSet;

    }
    #endregion

    #region [resetAll: reset all discount values]
    public function resetAll() {

        $Model = new Model();
        $Model->setTable('services_discount_tb');

        $data['off_percent'] = 0;
        $condition = "";
        $res = $Model->update($data, $condition);

        if ($res) {
            return 'success : تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در تغییرات';
        }

    }
    #endregion

    #region [setSpecialDiscount]
    public function setSpecialDiscount($params) {
        $find_exist_discount = $this->getModel('specialServiceDiscountModel')->get()
            ->where('service_title',$params['service_title'])
            ->where('pre_code',$params['pre_code'])
            ->where('type_get_discount',$params['type_get_discount'])
            ->where('is_del','0')
            ->find();

        if(empty($find_exist_discount)){
            $params['creation_date_int'] = time();
            $insert_discount = $this->getModel('specialServiceDiscountModel')->insertWithBind($params);
            if($insert_discount){
                return functions::withSuccess('',200,'ثبت تخفیف با موفقیت انجام شد');
            }
            return functions::withError('',400,'خطا در ثبت تخفیف');
        }
        return functions::withError('',400,'تخفیف مورد نظر قبلا ثبت شده است');

    }
    #endregion

    #region [getSpecialDiscount]
    public function getSpecialDiscount($data_discount=array()) {
        return $this->getModel('specialServiceDiscountModel')->get()
            ->where('service_title',$data_discount['service_title'])
            ->where('pre_code',$data_discount['pre_code'])
            ->where('type_get_discount',$data_discount['type_get_discount'])
            ->where('is_del','0')
            ->find();
    }
    #endregion

    #region [setSpecialDiscountUsed]
    public function setSpecialDiscountUsed($data_usage=array()) {
        return $this->getModel('specialDiscountUsedModel')->insertWithBind($data_usage);
    }
    #endregion

    #region [getSpecialDiscountUsed]
    public function getSpecialDiscountUsed($data_usage=array()) {
        return $this->getModel('specialDiscountUsedModel')->get()
            ->where('info_member_passenger',$data_usage['info_member_passenger'])
            ->where('status','success')
            ->find();
    }
    #endregion

    #region [updateSpecialDiscountUsed]
        public function updateSpecialDiscountUsed($factor_number) {

            $data_update_special_discount_used['status'] = 'success';
            $condition = "factor_number='{$factor_number}'" ;
            return $this->getModel('specialDiscountUsedModel')->updateWithBind($data_update_special_discount_used,$condition);
        }
    #endregion

    #region [updateSpecialDiscountUsed]
    public function softDeleteSpecialDiscount($param) {

        $data_delete_special_discount['is_del'] = '1';
        $condition = "id='{$param['id']}'" ;

        $soft_delete =  $this->getModel('specialServiceDiscountModel')->updateWithBind($data_delete_special_discount,$condition);
        if($soft_delete){
            return functions::withSuccess('',200,'حذف با موفقیت انجام شد');
        }
        return functions::withError('',400,'خطا در حذف تخفیف');
    }
    #endregion

    public function getSpecificDiscountUser($data_discount)
    {
        return $this->getModel('servicesDiscountModel')->get()->where('counter_id',$data_discount['counter_id'])->where('service_title',$data_discount['service_title'])->find();
    }

    public function getDiscountListSortByCounterAndServiceTitle()
    {
        $list_services_discount = $this->listServiceDiscount();
        $list_Services_finally = array();
        foreach ($list_services_discount as $item) {
            $list_Services_finally[$item['counter_id']][$item['service_title']] = $item;
        }

        return $list_Services_finally ;
   }

    public function checkMarketplaceService($params) {

        if($params['serviceTitle'] == 'marketplaceHotel'){
            $type_class = $this->getController('reservationHotel');
            $type = $type_class->getHotelById(['id' => $params['service_id']]) ;
            if($type['user_id']){
                return true ;
            }
        }
        return false;
    }
    public function setMarketplaceService($params , $change_id) {

        if(isset($params['serviceTitle'])) {
            $type = '' ;
            switch ($params['serviceTitle']) {
                case 'marketplaceHotel'  :
                    $type = 'hotel' ;
                    break;
            }
            $marketplace = $this->getModel('marketPlaceServiceModel') ;
            $if_exist = $marketplace->get()->where('service_id' , $params['service_id'])
                ->where('change_price_id' , $change_id)->where('service_type' ,$type)->find();
            if(!$if_exist) {
                $data_insert = [
                    'service_id'        => $params['service_id'] ,
                    'service_type'      => "'".$type."'" ,
                    'change_price_id'   => $change_id ,
                    'change_type'       => "'".'discount'."'"
                ];

                return $marketplace->insert($data_insert) ;
            }

        }

    }

    public function getDiscountByServiceAndMarketId($service , $market_id) {
        $service_type = '' ;
        $final_result = [] ;
        if($service == 'marketplaceHotel'){
            $service_type = 'hotel' ;
        }
        $result = $this->getModel('servicesDiscountModel')->get()
            ->join('marketplace_price_tb' ,'change_price_id' , 'id' )
            ->where('marketplace_price_tb.change_type' , 'discount')
            ->where('marketplace_price_tb.service_id' ,$market_id)
            ->where('marketplace_price_tb.service_type' ,$service_type)
            ->where('service_title',$service)->all();
        foreach ($result as $record){
            $service = $record['service_title'];
            $counter = $record['counter_id'];
            $final_result[$service][$counter] = $record;
        }
        return $final_result;

    }

    public function getDiscountByServiceAndMarketIdAndCounterId($service , $counter_id , $market_id) {
        $service_type = '' ;

        if($service == 'marketplaceHotel'){
            $service_type = 'hotel' ;
        }
        return $this->getModel('servicesDiscountModel')->get()
            ->join('marketplace_price_tb' ,'change_price_id' , 'id' )
            ->where('marketplace_price_tb.change_type' , 'discount')
            ->where('marketplace_price_tb.service_id' ,$market_id)
            ->where('marketplace_price_tb.service_type' ,$service_type)
            ->where('service_title',$service)
            ->where('counter_id',$counter_id)
            ->find();

    }
}

?>
