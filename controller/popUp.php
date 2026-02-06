<?php


class popUp extends clientAuth {
    /**
     * @var string
     */
    public $noPhotoUrl , $popUpBaseUrl;
    private $popUpTb , $page_limit;
    /**
     * @var string
     */
    private $photoUrl;
    public function __construct() {
    parent::__construct();
    $this->popUpTb = 'pop_up_tb';
    $this->page_limit = 6;
    $this->noPhotoUrl = 'project_files/images/no-photo.png';
    $this->photoUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/';
    $this->popUpBaseUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/popUp' . '/';
    }

    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        return json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
    /**
     * @param array $popUpList
     * @return array
     */

    public function addPopUpIndexes(array $popUpList){
        $result = [];
        foreach ($popUpList as $key => $popUp) {
            $result[$key] = $popUp;
            $time_date = functions::ConvertToDateJalaliInt($popUp['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['is_active'] = "{$popUp['is_active']}";
            $result[$key]['alt'] = $popUp['title'] ?: '';
            $result[$key]['pic'] = $this->photoUrl . 'popUp/'. $popUp['pic'];
            $result[$key]['pic_medium'] = $this->photoUrl . 'popUp/medium/' . $popUp['pic'];
            $result[$key]['pic_thumb'] = $this->photoUrl . 'popUp/thumb/' . $popUp['pic'];
            $result[$key]['pic_mobile'] = $this->photoUrl . 'popUp/'. $popUp['pic_mobile'];
            $result[$key]['pic_sample'] = $this->photoUrl . 'popUp/'. $popUp['pic_sample'];

        }
        return $result;
    }

    public function listPopUp($data_main_page = []) {
        $result = [];
        $popUpList = $this->getModel('popUpModel')->get();
        $pop_table = $popUpList->getTable();
        if (!isset($data_main_page['limit']) || empty($data_main_page['limit'])) {
            $data_main_page['limit'] = 10;
        }

        if ($data_main_page['is_active'] ) {
            $popUpList->where($pop_table . '.is_active', 1)->limit(0,$data_main_page['limit']);
        }
        $listPopUp = $popUpList->all();
        foreach ($listPopUp as $key => $value) {
            $pic = $listPopUp[$key]['pic'];
            $ext = explode(".", $pic);
            $ext = strtolower($ext[count($ext)-1]);
            if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
                $type = 'pic';
            } else {
                $type = 'file';
            }
            $listPopUp[$key]['type'] = $type;
        }
        $result = $this->addPopUpIndexes($listPopUp);
        return $result;
    }

    public function insertPopUp($params) {

        /** @var application $config */
        $config = Load::Config('application');
        $path = "popUp/";
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
            functions::SaveImages('pic/popUp','', $result_upload);
        }
        if (empty($result_upload)) {
            return functions::withError('', 200, 'ورود فیلد فایل اجباری می باشد');
        }


        $ext = explode(".", $_FILES['pic_mobile'][name]);
        $_FILES['pic_mobile'][name] = date("sB")."-" . rand(10, 10000);
        $ext = strtolower($ext[count($ext)-1]);
        $_FILES['pic_mobile'][name] = $_FILES['pic_mobile'][name].".".$ext;
        if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
            $type_mobile = 'pic_mobile';
        } else{
            $type_mobile = 'file_mobile';
        }
        $result_upload_mobile = $config->UploadFile($type_mobile, "pic_mobile", "");
        $explode_name_pic = explode(':', $result_upload_mobile);

        if ($explode_name_pic[0] == 'done') {
            $result_upload_mobile = $explode_name_pic[1];
        }else{
            return functions::withError('', 200, $explode_name_pic[0]);
        }
        if ($type_mobile = 'pic_mobile'){
            functions::SaveImages('pic/popUp','', $result_upload_mobile);
        }
        if (empty($result_upload_mobile)) {
            return functions::withError('', 200, 'ورود فیلد تصویر موبایل اجباری می باشد');
        }

        $ext = explode(".", $_FILES['pic_sample'][name]);
        $_FILES['pic_sample'][name] = date("sB")."-" . rand(10, 10000);
        $ext = strtolower($ext[count($ext)-1]);
        $_FILES['pic_sample'][name] = $_FILES['pic_sample'][name].".".$ext;
        if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
            $type_sample = 'pic_sample';
        } else{
            $type_sample = 'file_sample';
        }
        $result_upload_sample = $config->UploadFile($type_sample, "pic_sample", "");
        $explode_name_pic = explode(':', $result_upload_sample);

        if ($explode_name_pic[0] == 'done') {
            $result_upload_sample = $explode_name_pic[1];
        }else{
            return functions::withError('', 200, $explode_name_pic[0]);
        }
        if ($type_mobile = 'pic_sample'){
            functions::SaveImages('pic/popUp','', $result_upload_sample);
        }
        if (empty($result_upload_sample)) {
            return functions::withError('', 200, 'ورود فیلد تصویر sample اجباری می باشد');
        }


        $dataPopUp = [
            'pic' => $result_upload,
            'title' => $params['title'],
            'description' => $params['description'],
            'is_active' => true,
            'created_at' => date('Y-m-d H:i:s', time()),
        ];

        $insert = $this->getModel('popUpModel')->insertWithBind($dataPopUp);
        if ($insert) {
            return self::returnJson(true, 'افزودن پاپ آپ با موفقیت انجام شد');
        }


        return self::returnJson(false, 'خطا در ثبت پاپ آپ جدید.', null, 500);

    }
    public function findPopUpById($id) {
        return $this->getModel('popUpModel')->get()->where('id', $id)->find();
    }
    public function updateActivePopUp($data_update) {

        $check_exist_pop_up = $this->findPopUpById($data_update['id']);
        if ($check_exist_pop_up) {
            $data_update_status['is_active'] = ($check_exist_pop_up['is_active'] == 1) ? 0 : 1;
            $condition_update_status ="id='{$check_exist_pop_up['id']}'";
            $result_update_pop_up = $this->getModel('popUpModel')->updateWithBind($data_update_status,$condition_update_status);

            if ($result_update_pop_up) {
                return functions::withSuccess('', 200, 'ویرایش وضعیت با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش وضعیت ');

        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');

    }
    public function getPopUp($id) {
        $pop_up_model = $this->getModel('popUpModel');
        $pop_up_table = $pop_up_model->getTable();
        $pop_up = $pop_up_model
            ->get(
                [
                    $pop_up_table . '.*',
                ], true
            )
            ->where($pop_up_table . '.id', $id)
            ->find(false);

        $pic = $this->addPopUpIndexes([$pop_up])[0]['pic'];
        $ext = explode(".", $pic);
        $ext = strtolower($ext[count($ext)-1]);
        $this->addPopUpIndexes([$pop_up])[0]['type']  = '';
        if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
            $type = 'pic';
        } else {
            $type = 'file';
        }
        $pop_up['type'] = $type;

        $pic_mobile = $this->addPopUpIndexes([$pop_up])[0]['pic_mobile'];
        $ext = explode(".", $pic_mobile);
        $ext = strtolower($ext[count($ext)-1]);
        $this->addPopUpIndexes([$pop_up])[0]['type_mobile']  = '';
        if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
            $type_mobile = 'pic_mobile';
        } else {
            $type_mobile = 'file_mobile';
        }
        $pop_up['type_mobile'] = $type_mobile;

        $pic_sample = $this->addPopUpIndexes([$pop_up])[0]['pic_sample'];
        $ext = explode(".", $pic_sample);
        $ext = strtolower($ext[count($ext)-1]);
        $this->addPopUpIndexes([$pop_up])[0]['type_sample']  = '';
        if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
            $type_sample = 'pic_sample';
        } else {
            $type_sample = 'file_sample';
        }
        $pop_up['type_sample'] = $type_sample;
        return $this->addPopUpIndexes([$pop_up])[0];
    }
    public function deletePopUp($data_update) {
        $check_exist_pop_up = $this->findPopUpById($data_update['id']);
        if ($check_exist_pop_up) {
            $path = PIC_ROOT . 'popUp/' . $check_exist_pop_up['pic'];
            $pathThumb = PIC_ROOT . 'popUp/thumb/' . $check_exist_pop_up['pic'];
            $pathMedium = PIC_ROOT . 'popUp/medium/' . $check_exist_pop_up['pic'];
            $result_update_pop_up = $this->getModel('popUpModel')->delete("id='{$data_update['id']}'");
            if ($result_update_pop_up) {
                unlink($path);
                unlink($pathThumb);
                unlink($pathMedium);
//                unlink(PIC_ROOT . 'popUp/' . $check_exist['file']);
                return functions::withSuccess('', 200, 'حذف پاپ آپ با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در حذف');

        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }


    public function updatePopUp($params) {
        /** @var popUpModel $pop_up_model */
        $pop_up_model = $this->getModel('popUpModel');

        $dataUpdate_1 =[];
        $dataUpdate_2 =[];
        $dataUpdate_3 =[];
        if (isset($_FILES['pic'][name])) {

            $check_exist = $this->findPopUpById($params['id']);
            if ($check_exist) {
                functions::DeleteImages('popUp/' ,$check_exist['pic']);
            }


            /** @var application $config */
            $config = Load::Config('application');
            $path = "popUp/";
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
            $result_upload_1 = $config->UploadFile($type, "pic", "");
            $explode_name_pic_1 = explode(':', $result_upload_1);

            if ($explode_name_pic_1[0] == 'done') {
                $result_upload_1 = $explode_name_pic_1[1];
            }else{
                return functions::withError('', 200, $explode_name_pic_1[0]);
            }
            $dataUpdate_1 = [
                'pic' => $result_upload_1,
            ];
            if ($type = 'pic'){
                functions::SaveImages('pic/popUp','', $result_upload_1);
            }
            if (empty($dataUpdate_1)) {
                return functions::withError('', 200, 'ورود فیلد تصویر اجباری می باشد');
            }
        }

        if (isset($_FILES['pic_mobile'][name])) {
            $check_exist = $this->findPopUpById($params['id']);
            if ($check_exist) {
                functions::DeleteImages('popUp/' ,$check_exist['pic_mobile']);
            }


            /** @var application $config */
            $config = Load::Config('application');
            $path = "popUp/";
            $config->pathFile($path);
            $ext = explode(".", $_FILES['pic_mobile'][name]);
            $_FILES['pic_mobile'][name] = date("sB")."-" . rand(10, 10000);
            $ext = strtolower($ext[count($ext)-1]);
            $_FILES['pic_mobile'][name] = $_FILES['pic_mobile'][name].".".$ext;
            if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
                $type_mobile = 'pic';
            } else{
                $type_mobile = 'file';
            }
            $result_upload_mobile = $config->UploadFile($type_mobile, "pic_mobile", "");
            $explode_name_pic_2 = explode(':', $result_upload_mobile);

            if ($explode_name_pic_2[0] == 'done') {
                $result_upload_mobile = $explode_name_pic_2[1];
            }else{
                return functions::withError('', 200, $explode_name_pic_2[0]);
            }
            $dataUpdate_2 = [
                'pic_mobile' => $result_upload_mobile,
            ];
            if ($type_mobile = 'pic_mobile'){
                functions::SaveImages('pic/popUp','', $result_upload_mobile);
            }
            if (empty($dataUpdate_2)) {
                return functions::withError('', 200, 'ورود فیلد تصویر موبایل اجباری می باشد');
            }
        }

        if (isset($_FILES['pic_sample'][name])) {
            $check_exist = $this->findPopUpById($params['id']);
            if ($check_exist) {
                functions::DeleteImages('popUp/' ,$check_exist['pic_sample']);
            }


            /** @var application $config */
            $config = Load::Config('application');
            $path = "popUp/";
            $config->pathFile($path);
            $ext = explode(".", $_FILES['pic_sample'][name]);
            $_FILES['pic_sample'][name] = date("sB")."-" . rand(10, 10000);
            $ext = strtolower($ext[count($ext)-1]);
            $_FILES['pic_sample'][name] = $_FILES['pic_sample'][name].".".$ext;
            if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
                $type_sample = 'pic';
            } else{
                $type_sample = 'file';
            }
            $result_upload_sample = $config->UploadFile($type_sample, "pic_sample", "");
            $explode_name_pic_3 = explode(':', $result_upload_sample);

            if ($explode_name_pic_3[0] == 'done') {
                $result_upload_sample = $explode_name_pic_3[1];
            }else{
                return functions::withError('', 200, $explode_name_pic_3[0]);
            }
            $dataUpdate_3 = [
                'pic_sample' => $result_upload_sample,
            ];
            if ($type_sample = 'pic_sample'){
                functions::SaveImages('pic/popUp','', $result_upload_sample);
            }
            if (empty($dataUpdate_3)) {
                return functions::withError('', 200, 'ورود فیلد تصویر سمپل اجباری می باشد');
            }
        }

        if (mb_strlen($params['description'], 'UTF-8') > 400) {
            return functions::withError('', 200, 'حداکثر میتوانید 400 کاراکتر وارد کنید.');
        }

        $data = [
            'title' => $params['title'],
            'description' => $params['description'],
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];
        $result = array_merge($dataUpdate_1,$dataUpdate_2,$dataUpdate_3,$data);

        $update = $pop_up_model->updateWithBind($result, ['id' => $params['id']]);

        if ($update) {
            return functions::withSuccess('', 200, 'ویرایش پاپ آپ  با موفقیت انجام شد');
        }

    }

    public function ModalShowPopUp(){

        if (!isset($_COOKIE['popUpAdmin'])) {
            
            $pop_model = $this->getModel('popUpModel')->get()->where('is_active', 1);

            $result =  $pop_model->all();
        
            $result = $this->addPopUpIndexes($result);
            return $result;
        }
    }

}