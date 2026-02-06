<?php
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
class fullCapacity extends clientAuth {
    /**
     * @var string
     */
    public $noPhotoUrl , $fullCapacityBaseUrl;
    private $fullCapacityTb , $page_limit;
    /**
     * @var string
     */
    private $photoUrl;
    public function __construct() {
    parent::__construct();
    $this->fullCapacityTb = 'full_capacity_tb';
    $this->page_limit = 6;
    $this->noPhotoUrl = 'project_files/images/no-photo.png';
    $this->photoUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/';
    $this->fullCapacityBaseUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/fullCapacity' . '/';
    }
    /**
     * @param array $fullCapacityList
     * @return array
     */
    public function addFullCapacityIndexes(array $fullCapacityList) {
        $result = [];

        foreach ($fullCapacityList as $key => $item) {
            $client_id  = CLIENT_ID ;
            $two_gain_site = $this->getClientId();
            if($two_gain_site) {
                $client_id = $two_gain_site;
            }

            $result[$key] = $item;
            $time_date = functions::ConvertToDateJalaliInt($item['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['is_active'] = "{$item['is_active']}";
            $result[$key]['alt'] = $item['title'] ?: '';

            $result[$key]['pic'] = $item['pic'] ?  $this->photoUrl . 'fullCapacity/' . $client_id . '/'. $item['pic'] : '';
            $result[$key]['pic_medium'] = $item['pic'] ? $this->photoUrl . 'fullCapacity/' . $client_id . '/medium/' . $item['pic'] : '';
            $result[$key]['pic_thumb'] =  $item['pic'] ? $this->photoUrl . 'fullCapacity/' . $client_id . '/thumb/' . $item['pic'] :'';


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
    public function insertFullCapacity($params) {
        /** @var application $config */
        $config = Load::Config('application');
        $path = "fullCapacity/".CLIENT_ID."/";
        $config->pathFile($path);
        $ext = explode(".", $_FILES['pic']['name']);
        $_FILES['pic']['name'] = date("sB")."-" . rand(10, 10000);
        $ext = strtolower($ext[count($ext)-1]);
        $_FILES['pic']['name'] = $_FILES['pic']['name'].".".$ext;
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
            functions::SaveImages('pic/fullCapacity/'.CLIENT_ID ,'', $result_upload);
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

        $insert = $this->getModel('fullCapacityModel')->insertWithBind($data);
        if ($insert) {
            return self::returnJson(true, 'افزودن تصویر با موفقیت انجام شد');
        }


        return self::returnJson(false, 'خطا در ثبت تصویر.', null, 500);

    }

    public function listFullCapacity($data_main_page = []) {
        $result = [];
        $full_capacity_list = $this->getModel('fullCapacityModel')->get();
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
        $result = $this->addFullCapacityIndexes($list_item);
        return $result;
    }

    public function findFullCapacityById($id) {
        return $this->getModel('fullCapacityModel')->get()->where('id', $id)->find();
    }

    public function updateStatusFullCapacity($data_update) {
        $check_exist_item = $this->findFullCapacityById($data_update['id']);
        if ($check_exist_item) {
            $data_update_status['is_active'] = ($check_exist_item['is_active'] == 1) ? 0 : 1;
            $condition_update_status ="id='{$check_exist_item['id']}'";
            $result_update_item = $this->getModel('fullCapacityModel')->updateWithBind($data_update_status,$condition_update_status);
            if ($result_update_item) {
                return functions::withSuccess('', 200, 'ویرایش وضعیت تصویر با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش وضعیت تصویر ');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');

    }

    public function deleteFullCapacity($data_update) {
        $check_exist_item_id = $this->findFullCapacityById($data_update['id']);
        if ($check_exist_item_id) {
            $path = PIC_ROOT . 'fullCapacity/' .CLIENT_ID.'/'.$check_exist_item_id['pic'];
            $pathThumb = PIC_ROOT . 'fullCapacity/'.CLIENT_ID. '/thumb/' .'/'. $check_exist_item_id['pic'];
            $pathMedium = PIC_ROOT . 'fullCapacity/'.CLIENT_ID. '/medium/' .'/'. $check_exist_item_id['pic'];
            $result = $this->getModel('fullCapacityModel')->delete("id='{$data_update['id']}'");
            if ($result) {
                unlink($path);
                unlink($pathThumb);
                unlink($pathMedium);
                unlink(PIC_ROOT . 'fullCapacity/' . $check_exist_item_id['file']);
                return functions::withSuccess('', 200, 'حذف تصویر با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در حذف تصویر');

        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }

    public function getFullCapacity($id) {
        $item_model = $this->getModel('fullCapacityModel');
        $item_table = $item_model->getTable();
        $query = $item_model
            ->get(
                [
                    $item_table . '.*',
                ], true
            )
            ->where($item_table . '.id', $id)
            ->find(false);

        $pic = $this->addFullCapacityIndexes([$query])[0]['pic'];
        $ext = explode(".", $pic);
        $ext = strtolower($ext[count($ext)-1]);
        $this->addFullCapacityIndexes([$query])[0]['type']  = '';
        if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
            $type = 'pic';
        } else {
            $type = 'file';
        }
        $query['type'] = $type;
        return $this->addFullCapacityIndexes([$query])[0];
    }



    public function updateFullCapacity($params) {
        /** @var itemModel $item_model */
        $item_model = $this->getModel('fullCapacityModel');
        $dataUpdate =[];

        if (isset($_FILES['pic']['name'])) {
            $check_exist = $this->findFullCapacityById($params['id']);
            if ($check_exist) {
                functions::DeleteImages('fullCapacity/'.CLIENT_ID.'/' ,$check_exist['pic']);
            }
            /** @var application $config */
            $config = Load::Config('application');
            $path = "fullCapacity/".CLIENT_ID."/";
            $config->pathFile($path);
            $ext = explode(".", $_FILES['pic']['name']);
            $_FILES['pic']['name'] = date("sB")."-" . rand(10, 10000);
            $ext = strtolower($ext[count($ext)-1]);
            $_FILES['pic']['name'] = $_FILES['pic']['name'].".".$ext;
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
            functions::SaveImages('pic/fullCapacity/'.CLIENT_ID ,'', $result_upload);
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


    public function findFullCapacityAdminById($id) {
        return $this->getModel('fullCapacityAdminModel')->get()->where('id', $id)->find();
    }

    public function changePic($params) {

        /** @var itemModel $item_model */
        $item_model = $this->getModel('fullCapacityModel');
        $dataUpdate =[];

        if (isset($_FILES['pic']['name'])) {
            $check_exist = $this->findFullCapacityById($params['id']);
            if ($check_exist) {
                functions::DeleteImages('fullCapacity/'.CLIENT_ID.'/' ,$check_exist['pic']);
            }
            /** @var application $config */
            $config = Load::Config('application');
            $path = "fullCapacity/".CLIENT_ID."/";
            $config->pathFile($path);
            $ext = explode(".", $_FILES['pic']['name']);
            $_FILES['pic']['name'] = date("sB")."-" . rand(10, 10000);
            $ext = strtolower($ext[count($ext)-1]);
            $_FILES['pic']['name'] = $_FILES['pic']['name'].".".$ext;
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
                functions::SaveImages('pic/fullCapacity/'.CLIENT_ID ,'', $result_upload);
            }
            if (empty($dataUpdate)) {
                return functions::withError('', 200, 'ورود فیلد تصویر اجباری می باشد');
            }
        }

        $check_exist_item = $this->findFullCapacityAdminById($params['item_select']);

        if ($check_exist_item) {
            $check_exist = $this->findFullCapacityById($params['id']);
            if ($check_exist) {
                functions::DeleteImages('fullCapacity/'.CLIENT_ID.'/' ,$check_exist['pic']);
            }
            $path_pic = $check_exist_item['pic'];
//            $path_pic = PIC_ROOT . 'fullCapacityAdmin/'.$check_exist_item['pic'];
//            $path_thumb = PIC_ROOT . 'fullCapacityAdmin/thumb/' .'/'. $check_exist_item['pic'];
//            $path_medium = PIC_ROOT . 'fullCapacityAdmin/medium/' .'/'. $check_exist_item['pic'];
            $pic_admin_id= $check_exist_item['id'];
            $pic_admin_title= $check_exist_item['title'];
            $title_user= '';
            $dataUpdate = [
                'pic' => '',
            ];
        }else {
            $path_pic = '';
            $pic_admin_id= '';
            $pic_admin_title= '';
            $title_user= $params['title'];
        }

        $data = [
            'title' => $title_user,
            'item_select' => $params['item_select'],
            'pic_admin_id' => $pic_admin_id,
            'pic_admin' => $path_pic,
            'pic_admin_title' => $pic_admin_title,
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];

        $result = array_merge($dataUpdate,$data);

        $update = $item_model->updateWithBind($result, ['id' => $params['id']]);

        if ($update) {
            return functions::withSuccess('', 200, 'ویرایش تصویر  با موفقیت انجام شد');
        }
    }


    public function getFullCapacitySite($param) {

        if(isset($param['id']) && !empty($param)) {
            $id = $param['id'] ;
        }else {
            $id = $param;
        }

        $item_model = $this->getModel('fullCapacityModel');
        $item_table = $item_model->getTable();
        $query = $item_model->get(
                [
                    $item_table . '.*',
                ], true
            )
            ->where($item_table . '.id', $id)
            ->find(false);

        $item_select = $this->addFullCapacityIndexes([$query])[0]['item_select'];
        if ($item_select==0) {
            $pic_url= $this->addFullCapacityIndexes([$query])[0]['pic'];
            $pic_title= $this->addFullCapacityIndexes([$query])[0]['title'];
        }else {
            $pic_site = $this->addFullCapacityIndexes([$query])[0]['pic_admin'];
            $pic_url = $this->photoUrl . 'fullCapacityAdmin/'. $pic_site;
            $pic_title= $this->addFullCapacityIndexes([$query])[0]['pic_admin_title'];
        }
        $query['pic_url'] = $pic_url;
        $query['pic_title'] = $pic_title;

        $result =  $this->addFullCapacityIndexes([$query])[0];

        if(isset($param['is_json']) && $param['is_json'] == true) {
            return json_encode($result);
        }else{
            return $result;
        }

    }

    private function getClientId() {
        if(CLIENT_ID == '333') {
            return '327';
        }
	return false;
    }

}