<?php

class userRole extends clientAuth {

    public $model;
    public $activity_log_controller;
    public $price;
    public $priceForMa;

    public function __construct() {
        parent::__construct();

        $this->model = $this->getModel('userRoleModel');
        $this->activity_log_controller  =   $this->getController('activityLog');
    }

    public function setUserRole($params) {

        $member_model = $this->getModel('membersModel');
        $member_controller  = $this->getController('members') ;
        // if user has no access to this hotel return error
        if($params['set_new_user']) {

            $member =  $this->registerUser($params)  ;

            $member = json_decode($member , true);
            if(!$member['success']) {
                if($member['position'] == 'ExistsUser') {
                    $exist_member  = $member_model->getMemberByUserName($params);
                    if($exist_member){
                        if($exist_member['name'] || $exist_member['family']) {
                            $name = $exist_member['name'] . ' ' . $exist_member['family'] ;
                        }else{
                            $name = $exist_member['user_name'] ;
                        }
                        return functions::withError($exist_member,400 ,  'کاربری با نام '.$name.' قبلا در سیستم ثبت شده است. ایا منظورتون همان کاربر موجود در سیستم است.');
                    }else{
                        return functions::withError([],400 ,  $member['message']);
                    }
                }
                return functions::withError([],400 ,  $member['message']);
            }
            $user_id = $member['data']['id'] ;
        }else{

            $member = $member_model->getMemberByUserName(['entry' => $params['entry']]);

            $user_id = $member['id'] ;

            $info_member = functions::infoAgencyByMemberId(Session::getUserId());

            if($info_member) {
                $active_params = [
                    'agency_id' => $info_member['fk_agency_id'],
                    'typeCounterId' => '1',
                    'id' => $user_id
                ];
                $result_json = $member_controller->changeMemberToCounter($active_params);

                if (!$result_json) {
                    return $result_json;
                }

                foreach ($params['role'] as $role) {
                    foreach ($params['item_id'] as $item) {
                        $this->model->delete([
                            'user_id' => $user_id,
                            'role' => $role ,
                            'item_table' => $this->getUserRoleType($params['item_type']) ,
                            'item_id' => $item
                        ]);
                    }
                }

            }
        }
        if(!empty($params['role'])) {
            foreach ($params['role'] as $role) {
                $dataInsert = [
                    'role'        => $role ,
                    'user_id'     => $user_id
                ];

                if(!empty($params['item_type']) && !empty($params['item_id'])) {
                    foreach ($params['item_id'] as $item) {

                        $dataInsert['item_table'] = $this->getUserRoleType($params['item_type']);
                        $dataInsert['item_id']    = $item;
                        $insert = $this->model->insertWithBind($dataInsert);

                    }
                    if ($insert) {
                        return functions::withSuccess($dataInsert , 200 , 'اطلاعات با موفقیت در سیستم به ثبت رسید');
                    }else{
                        return functions::withError([],400 ,  'خطا در ثبت اطلاعات در سیستم.');
                    }
                }else{

                    return functions::withError([],400 ,  'هتلی انتخاب نشده است.');
                }


            }
        }else{
            return functions::withError([],400 ,  'هیچ نقشی انتخاب نشده است.');
        }







    }

    public function updateUserRole($params) {

        $member_controller  = $this->getController('members') ;
        $user = $this->model->get(['*'])->where('id' , $params['user_role_id'])->find();
        if($user['user_id']) {
            $member = $member_controller->changeUserRolePassword(['user_id' => $user['user_id'] ,'password' => $params['password'] ]) ;

            if($member) {
                return functions::withSuccess($member , 200 , 'اطلاعات با موفقیت در سیستم به ثبت رسید');
//                $dataUpdate = [
//                    'role'        => $params['role'] ,
//                    'user_id'     => $member['id']
//                ];
//
//                if(isset($params['item_type']) && isset($params['item_id'])) {
//                    $dataInsert['item_table'] = $this->getUserRoleType($params['item_type']);
//                    $dataInsert['item_id']    = $params['item_id'];
//                }
//
//                $update = $this->model->updateWithBind($dataUpdate , ['id' => $params['hotel_role_id']]);
//                if ($update) {
//                    return functions::withSuccess($dataUpdate , 200 , 'اطلاعات با موفقیت در سیستم به ثبت رسید');
//                }
            }else{
                return functions::withError([],400 ,  'تغییری اعمال نشد .');
            }
        }
        return functions::withError([],400 ,  'خطا در ثبت اطلاعات در سیستم.');
    }

    public function deleteRole($params) {

        $result = $this->model->delete(['id'=>$params['user_role_id']]);
        if ($result) {
            return functions::withSuccess([] , 200 , 'اطلاعات با موفقیت حذف شد');
        }

        return functions::withError([],400 ,  'خطا در حذف اطلاعات در سیستم.');
    }
    public function getUserRoleType($type) {
        switch ($type) {
            case 'hotel'  :
                return 'reservation_hotel_tb' ;
        }
    }

    public function registerUser($params) {

        $member_controller = $this->getController('members') ;
        $params['no_login'] = true;
        $result_register_member_json = $member_controller->memberInsert($params) ;

        $result_register_member = json_decode($result_register_member_json , true) ;
        if($result_register_member['success']) {
            $new_member   =  $result_register_member['data'] ;
            $info_member = functions::infoAgencyByMemberId(Session::getUserId());
            if($info_member) {
                $active_params = [
                    'agency_id'            => $info_member['fk_agency_id'] ,
                    'typeCounterId'        => '1' ,
                    'id'                   => $new_member['id']
                ];
                $result_json =  $member_controller->changeMemberToCounter($active_params);
                $result = json_decode($result_json , true) ;
                if($result['success']) {
                    return functions::toJson(['success' => true, 'message' => $result['message'], 'data' => $new_member]);
                }else{
                    return $result_json ;
                }
            }else{
                return functions::toJson(['success' => false, 'message' => 'انجام شد', 'position' => 'not_have_agency']);
            }

        }else{

            return $result_register_member_json ;
        }

    }

    public function getUserList($params) {
        $member_table = $this->getModel('membersModel')->getTable();
        $type = $this->getUserRoleType($params['item_table']) ;
        return $this->model->get(['*' , $member_table . '.user_name' , $type.'.name as item_name'])
            ->join($member_table , 'id' , 'user_id')
            ->join($type , 'id' , 'item_id')
            ->whereIn('item_id'  , $params['item_id'])
            ->where('item_table' , $type)
            ->all();
    }

    public function getUserRoleAccess($type) {

        $type = $this->getUserRoleType($type) ;
        return $this->model->get(['*'])
            ->join($type , 'id' , 'item_id')
            ->where('item_table' , $type)
            ->where('user_role_tb.user_id' , Session::getUserId())
            ->all();
    }


    public function hasAccessItem($params) {
        $type = $this->getUserRoleType($params['type']) ;
        return $this->model->get(['*'])
            ->join($type , 'id' , 'item_id')
            ->where('item_table' , $type)
            ->where('item_id' , $params['item_id'])
            ->where('user_role_tb.user_id' , Session::getUserId())
            ->all();
    }

    public function checkUserExistence($params) {
        $members_model = $this->getModel('membersModel');
        $exist_member  = $members_model->getMemberByUserName($params);
        if($exist_member){
            return functions::toJson(['success' => true, 'message' => 'کاربر یافت شد.', 'data' => $exist_member]);
        }else{
            return functions::toJson(['success' => false, 'message' => 'انجام شد' ]);
        }

    }

    public function getUserRoleReservationMobile($type , $item_id) {
        $members_model = $this->getModel('membersModel');
        $mobile_list = [] ;
        $type = $this->getUserRoleType($type) ;
        $users =  $this->model->get(['user_id'])->where('role' , 'accountant' , '!=')->where('item_table' , $type)->where('item_id' , $item_id)->groupBy('user_id')->all();
        foreach ( $users as $user){
           $member =  $members_model->getMemberById($user['user_id']);
            if($member['mobile']){
                $mobile_list[]  = $member['mobile'];
            }

        }
        return $mobile_list ;
    }

    public function getUserById($user_id) {
        $members_model = $this->getModel('membersModel');
        return  $members_model->getMemberById($user_id);
    }
}