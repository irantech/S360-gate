<?php

class fullCapacityAdmin extends clientAuth {
    /**
     * @var string
     */
    public $noPhotoUrl , $fullCapacityAdminBaseUrl;
    private $fullCapacityAdminTb , $page_limit;
    /**
     * @var string
     */
    private $photoUrl;
    public function __construct() {
    parent::__construct();
    $this->fullCapacityAdminTb = 'full_capacity_admin_tb';
    $this->page_limit = 6;
    $this->noPhotoUrl = 'project_files/images/no-photo.png';
    $this->photoUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/';
    $this->fullCapacityAdminBaseUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/fullCapacityAdmin' . '/';
    }
    /**
     * @param array $fullCapacityAdminList
     * @return array
     */
    public function addFullCapacityAdminIndexes(array $fullCapacityAdminList) {
        $result = [];

        foreach ($fullCapacityAdminList as $key => $item) {

            $result[$key] = $item;
            $time_date = functions::ConvertToDateJalaliInt($item['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['is_active'] = "{$item['is_active']}";
            $result[$key]['alt'] = $item['title'] ?: '';
            $result[$key]['pic'] = $this->photoUrl . 'fullCapacityAdmin/'. $item['pic'];
            $result[$key]['pic_medium'] = $this->photoUrl . 'fullCapacityAdmin/medium/' . $item['pic'];
            $result[$key]['pic_thumb'] = $this->photoUrl . 'fullCapacityAdmin/thumb/' . $item['pic'];


        }

        return $result;
    }


    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        return json_encode([
            'success' => $success,
            'message' => $message,
            'code' => $statusCode,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
    public function insertFullCapacityAdmin($params) {
        /** @var application $config */
        $config = Load::Config('application');
        $path = "fullCapacityAdmin/";
        $config->pathFile($path);
        $ext = explode(".", $_FILES['pic'][name]);
        $_FILES['pic'][name] = date("sB")."-" . rand(10, 10000);
        $ext = strtolower($ext[count($ext)-1]);
        $_FILES['pic'][name] = $_FILES['pic'][name].".".$ext;
        if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
            $type = 'pic';
        } else{
            $type = 'file';
        }
        $result_upload = $config->UploadFile($type, "pic", "");
        $explode_name_pic = explode(':', $result_upload);

        if ($explode_name_pic[0] == 'done') {
            $result_upload = $explode_name_pic[1];
        }else{
            return functions::withError('', 200, $explode_name_pic[0]);
        }
        if ($type = 'pic'){
            functions::SaveImages('pic/fullCapacityAdmin/' ,'', $result_upload);
        }
        if (empty($result_upload)) {
            return functions::withError('', 200, 'ورود فیلد تصویر اجباری می باشد');
        }
        $data = [
            'pic' => $result_upload,
            'title' => $params['title'],
            'is_active' => true,
            'created_at' => date('Y-m-d H:i:s', time()),
        ];

        $insert = $this->getModel('fullCapacityAdminModel')->insertWithBind($data);
        if ($insert) {
            return self::returnJson(true, 'افزودن تصویر با موفقیت انجام شد');
        }


        return self::returnJson(false, 'خطا در ثبت گالری بنر جدید.', null, 500);

    }

    public function listFullCapacityAdmin($data_main_page = []) {
        $result = [];
        $full_capacity_list = $this->getModel('fullCapacityAdminModel')->get();
        $table = $full_capacity_list->getTable();
        if (!isset($data_main_page['limit']) || empty($data_main_page['limit'])) {
            $data_main_page['limit'] = 10;
        }
        if ($data_main_page['is_active'] ) {
            $full_capacity_list->where($table . '.is_active', 1);
        }
        $full_capacity_list->orderBy('id' ,'DESC')->limit(0,$data_main_page['limit']);

        $list_item= $full_capacity_list->all();
        foreach ($list_item as $key => $value) {
           $pic = $list_item[$key]['pic'];
            $ext = explode(".", $pic);
            $ext = strtolower($ext[count($ext)-1]);
            if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
                $type = 'pic';
            } else {
                $type = 'file';
            }
            $list_item[$key]['type'] = $type;
            }
        $result = $this->addFullCapacityAdminIndexes($list_item);
        return $result;
    }

    public function findFullCapacityAdminById($id) {
        return $this->getModel('fullCapacityAdminModel')->get()->where('id', $id)->find();
    }

    public function updateStatusFullCapacityAdmin($data_update) {
        $check_exist_item = $this->findFullCapacityAdminById($data_update['id']);
        if ($check_exist_item) {
            $data_update_status['is_active'] = ($check_exist_item['is_active'] == 1) ? 0 : 1;
            $condition_update_status ="id='{$check_exist_item['id']}'";
            $result_update_item = $this->getModel('fullCapacityAdminModel')->updateWithBind($data_update_status,$condition_update_status);
            if ($result_update_item) {
                return functions::withSuccess('', 200, 'ویرایش وضعیت تصویر با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش وضعیت تصویر ');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');

    }

    public function deleteFullCapacityAdmin($data_update) {
        $check_exist_item_id = $this->findFullCapacityAdminById($data_update['id']);
        if ($check_exist_item_id) {
            $path = PIC_ROOT . 'fullCapacityAdmin/'.$check_exist_item_id['pic'];
            $pathThumb = PIC_ROOT . 'fullCapacityAdmin/thumb/' .'/'. $check_exist_item_id['pic'];
            $pathMedium = PIC_ROOT . 'fullCapacityAdmin/medium/' .'/'. $check_exist_item_id['pic'];
            $result = $this->getModel('fullCapacityAdminModel')->delete("id='{$data_update['id']}'");
            if ($result) {
                unlink($path);
                unlink($pathThumb);
                unlink($pathMedium);
                unlink(PIC_ROOT . 'fullCapacityAdmin/' . $check_exist_item_id['file']);
                return functions::withSuccess('', 200, 'حذف تصویر با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در حذف تصویر');

        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }

    public function getFullCapacityAdmin($id) {
        $item_model = $this->getModel('fullCapacityAdminModel');
        $item_table = $item_model->getTable();
        $query = $item_model
            ->get(
                [
                    $item_table . '.*',
                ], true
            )
            ->where($item_table . '.id', $id)
            ->find(false);

        $pic = $this->addFullCapacityAdminIndexes([$query])[0]['pic'];
        $ext = explode(".", $pic);
        $ext = strtolower($ext[count($ext)-1]);
        $this->addFullCapacityAdminIndexes([$query])[0]['type']  = '';
        if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
            $type = 'pic';
        } else {
            $type = 'file';
        }
        $query['type'] = $type;
        return $this->addFullCapacityAdminIndexes([$query])[0];
    }


    public function updateFullCapacityAdmin($params) {
        /** @var itemModel $item_model */
        $item_model = $this->getModel('fullCapacityAdminModel');
        $dataUpdate =[];

        if (isset($_FILES['pic'][name])) {
            $check_exist = $this->findFullCapacityAdminById($params['id']);
            if ($check_exist) {
                functions::DeleteImages('fullCapacityAdmin/' ,$check_exist['pic']);
            }
            /** @var application $config */
            $config = Load::Config('application');
            $path = "fullCapacityAdmin/";
            $config->pathFile($path);
            $ext = explode(".", $_FILES['pic'][name]);
            $_FILES['pic'][name] = date("sB")."-" . rand(10, 10000);
            $ext = strtolower($ext[count($ext)-1]);
            $_FILES['pic'][name] = $_FILES['pic'][name].".".$ext;
            if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
                $type = 'pic';
            } else{
                $type = 'file';
            }
            $result_upload = $config->UploadFile($type, "pic", "");
            $explode_name_pic = explode(':', $result_upload);

            if ($explode_name_pic[0] == 'done') {
                $result_upload = $explode_name_pic[1];
            }else{
                return functions::withError('', 200, $explode_name_pic[0]);
            }
            $dataUpdate = [
                'pic' => $result_upload,
            ];
            if ($type = 'pic'){
            functions::SaveImages('pic/fullCapacityAdmin/' ,'', $result_upload);
            }
            if (empty($dataUpdate)) {
                return functions::withError('', 200, 'ورود فیلد تصویر اجباری می باشد');
            }
        }

        $data = [
            'title' => $params['title'],
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];
        $result = array_merge($dataUpdate,$data);

        $update = $item_model->updateWithBind($result, ['id' => $params['id']]);

        if ($update) {
            return functions::withSuccess('', 200, 'ویرایش تصویر  با موفقیت انجام شد');
        }

    }


}