<?php
//if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}


class gdsModule extends clientAuth
{

    protected $model = '';

    public function __construct() {
        parent::__construct();
        $this->model = $this->getModel('gdsModuleModel');
    }


    public function getListModule() {
        return $this->model->get()->all();
    }
    public function getAccessModule() {
        $access_list=$this->getModel('gdsAccessAdminModel')->where('client_id' , CLIENT_ID)->get()
            ->all();

        $list_access = '';
        foreach ($access_list as $select) {
            $last_arr[] = $select['gds_module_id'];
            $list_access = implode(',',$last_arr);
        }

        $listModule=$this->model
            ->get()
            ->all();

        $list = [];
        $explode = explode(',', $list_access);
        foreach ($listModule as $item) {
            if (in_array($item['id'], $explode)) {
                $active = 'is_active';
            } else {
                $active = 'non_active';
            }
            $list[] = [
                'id' => $item['id'],
                'title' => $item['title'],
                'gds_controller' => $item['gds_controller'] ,
                'gds_table' => $item['gds_table'] ,
                'active' => $active
            ];
        }
        return $list;
    }

    public function addGdsModule($params) {

        $data_add_gds_module['title'] = $params['title'];
        $data_add_gds_module['gds_controller'] = $params['gds_controller'];
        $data_add_gds_module['gds_table'] = $params['gds_table'];
        $data_add_gds_module['creation_date_int'] = time();

        $result_add_gds_module = $this->model->insertWithBind($data_add_gds_module);

        if ($result_add_gds_module) {
            return functions::withSuccess('', 200, 'افزودن مآژول جدید با موفقیت انجام شد');
        }

        return functions::withError('', 400, 'خطا در افزودن ماژول جدید');
    }

    public function editGdsModule($params) {

        $check_exist_gds_module = $this->getGdsModuleById($params['gds_module_id']);
        if ($check_exist_gds_module) {
            $data = [
                'title' => $params['title'],
                'gds_controller' => $params['gds_controller'],
                'gds_table' => $params['gds_table'],
                'creation_date_int' => time()
            ];

            $result_edit_gds_module = $this->model->updateWithBind($data, ['id' => $params['gds_module_id']]);

            if ($result_edit_gds_module) {
                return functions::withSuccess('', 200, 'ویرایش ماژول با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش ماژول');
        }
        return functions::withError('', 400, 'خطا در ویرایش ماژول');
    }

    public function getGdsModuleById($id) {
        return $this->model->get()->where('id', $id)->find();
    }
    public function findModuleByIdAccess($moduleId , $agencyId) {
        return $this->getModel('gdsAccessAdminModel')->get()->where('gds_module_id' , $moduleId)->where('client_id' , $agencyId)->find();
    }
    public function updateGdsAccessAdmin($data_update) {

        $check_exist_module = $this->getGdsModuleById($data_update['moduleId']);

        $check_exist_access = $this->findModuleByIdAccess($data_update['moduleId'] , $data_update['agencyId']);

        if ($check_exist_access['id']>0) {
            $this->getModel('gdsAccessAdminModel')->delete("id='{$check_exist_access['id']}'");
            return functions::withSuccess('', 200, 'تغییر دسترسی با موفقیت انجام شد');

        }else {
            $dataInsert = [
                'gds_module_id' => $check_exist_module['id'],
                'client_id' => $data_update['agencyId'],
                'created_at' => date('Y-m-d H:i:s', time()),
            ];
            $this->getModel('gdsAccessAdminModel')->insertWithBind($dataInsert);

            return functions::withSuccess('', 200, 'تغییر دسترسی با موفقیت انجام شد');
        }
    }


}