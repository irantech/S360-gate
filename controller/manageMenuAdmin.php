<?php

class manageMenuAdmin extends clientAuth
{
    public function __construct() {
       parent::__construct();
    }

    public function servicesAccessClient() {
        return $this->getAccessServiceClient();
    }

    public function getRelevantService($params) {

        $relevant_service = $this->getController('services')->getServicesByIdGroup($params['service']);
        if($params['is_json']){
            return functions::withSuccess($relevant_service,200,'data fetched successfully');
        }
        return $relevant_service;
    }

    public function listAccessHistoryCounter($member_id) {
        $accesses =  $this->getModel('accessHistoryCounterModel')->get()->where('member_id',$member_id)->all();
        $services = $this->getController('services')->getAllServices();
       
        $array_services =[];

        foreach ($services as $service) {
            $array_services[$service['TitleEn']] = $service ;
        }
        $final_array=[];

        foreach ($accesses as $key=>$access) {
            $final_array[$key] = $access;
            $final_array[$key]['title_fa'] = $array_services[$access['service_title']]['TitleFa'];
        }
        
        return $final_array ;
    }

    public function registerAccessHistoryCounter($params) {

        $check_exist = $this->getModel('accessHistoryCounterModel')
            ->get()
            ->where('member_id',$params['member_id'])
            ->where('service_title',$params['service_title'])
            ->all();
        if(!$check_exist){
            $data_insert['member_id'] = $params['member_id'];
            $data_insert['service_title'] = $params['service_title'];
            $data_insert['creation_date_int'] = time();
            $result_register_access_history_counter = $this->getModel('accessHistoryCounterModel')->insertLocal($data_insert);
            if($result_register_access_history_counter){
                return functions::withSuccess($result_register_access_history_counter,200,'دسترسی با موفقیت ثبت شد');
            }
            return functions::withError('',400,'خطا در ثبت دسترسی');
        }
        return functions::withError('',400,'این دسترسی قبلا ثبت شده است');
    }


    public function deleteAccessHistoryCounter($params) {

        $condition = ['id'=>$params['id']];
        $check_delete = $this->getModel('accessHistoryCounterModel')
            ->get()
            ->delete($condition);
        if($check_delete){
            return functions::withSuccess($check_delete,200,'دسترسی با موفقیت حذف شد');

        }
        return functions::withError('',400,'خطا در حذف دسترسی');
    }

    public function getAccessServiceCounter($member_id) {

        $services = $this->listAccessHistoryCounter($member_id);
        $final_array = [];
        foreach ($services as $service) {
            $final_array[] = "'".$service['service_title']."'";
        }
        return implode(",",$final_array) ;
    }

    public function getMembersAccessHistory($service_title) {

        $objSms = $this->getController('smsServices');

        $members_table_name = $this->getModel('membersModel')->getTable();

        $members_have_access = $this->getModel('accessHistoryCounterModel')
            ->get(['*',$members_table_name.'.*'])
            ->join($members_table_name,'id','member_id','INNER')
            ->where('service_title',$service_title)
            ->all();

        functions::insertLog('after get access'.json_encode($members_have_access,256),'log_sms_request');

        foreach ($members_have_access as $member) {
            if ($objSms) {
                $objSms->initService('0');
                $sms = "همکار محترم درخواست جدیدی در سیستم ثبت شده است ،شما میتوانید با مراجعه به پنل ادمین ،جزییات درخواست را مشاهده کنید";
                $smsArray = array(
                    'smsMessage' => $sms,
                    'cellNumber' => $member['mobile']
                );
            
                functions::insertLog('before sms'.json_encode($members_have_access,256),'log_sms_request');

                $objSms->sendSMS($smsArray);
            }
        }

    }
}