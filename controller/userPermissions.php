<?php
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
class userPermissions  extends clientAuth {
	
	public function __construct() {

	    parent::__construct();
	}
    public function setUserPermissions($userId,$canInsert,$canUpdate,$canDelete,$role)
    {
        $Model = Load::library('Model');
        $Model->setTable('user_permissions_tb');
        // بررسی وجود رکورد
        $resultPer= $this->getModel('userPermissionsModel')
            ->get(['id'])
            ->where('user_id', $userId)
            ->find();
        if ($resultPer['id']>0) {
            // رکورد موجود است → آپدیت
            $data = [
                'can_insert' => $canInsert,
                'can_update' => $canUpdate,
                'can_delete' => $canDelete,
                'updated_at' => date( 'Y-m-d H:i:s' )
            ];

            $condition = "id='{$resultPer['id']}' ";
            $resUpdate = $Model->update($data, $condition);

            if ($resUpdate) {
                return 'Success:تغییر دسترسی عملیات با موفقیت انجام شد';
            }
            return 'Error:خطا در تغییر دسترسی عملیات';
        } else {
            // رکورد موجود نیست → درج
            $data = [
                'user_id'=> $userId,
                'role' => $role,
                'can_insert' => $canInsert,
                'can_update' => $canUpdate,
                'can_delete' => $canDelete,
                'created_at' => date( 'Y-m-d H:i:s' ),
                'updated_at' => date( 'Y-m-d H:i:s' )
            ];
            $resInsert = $Model->insertLocal($data);
            if ($resInsert) {
                return 'Success:ثبت دسترسی عملیات با موفقیت انجام شد';
            }
            return 'Error:خطا در ثبت دسترسی عملیات';
        }
    }

    public function getUserPermissionById($userId){
        $resultPer= $this->getModel('userPermissionsModel')
            ->get()
            ->where('user_id', $userId)
            ->find();
        return $resultPer;
    }
}