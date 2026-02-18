<?php

class uploadFiles extends clientAuth {
    /**
     * @var string
     */
    public $noPhotoUrl , $uploadsBaseUrl;
    private $uploadsTb , $page_limit;
    /**
     * @var string
     */
    private $photoUrl;
    public function __construct() {
        parent::__construct();
        $this->uploadsTb = 'upload_files_tb';
        $this->page_limit = 1;
        $this->noPhotoUrl = 'project_files/images/no-photo.png';
        $this->photoUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/';
        $this->uploadsBaseUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/uploadFiles' . '/';
    }
    /**
     * @param array $uploadsList
     * @return array
     */
    public function addUploadsIndexes(array $uploadsList) {
        $result = [];
        foreach ($uploadsList as $key => $upload) {
            $result[$key] = $upload;
            $time_date = functions::ConvertToDateJalaliInt($upload['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['file'] = $this->photoUrl . 'uploadFiles/' . CLIENT_ID . '/'. $upload['file'];
            $result[$key]['link'] = "{$this->uploadsBaseUrl}{$upload['id']}";
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
    public function insertUploads($params) {
        $upload_model = $this->getModel('uploadFileModel');
        if (isset($_FILES['gallery_files']) && $_FILES['gallery_files'] != "") {
            $separated_files = functions::separateFiles('gallery_files');

            foreach ($separated_files as $image_key => $separated_file) {
                $_FILES['file'] = $separated_file;
                $config = Load::Config('application');
                $path = "uploadFiles/".CLIENT_ID."/";
                $config->pathFile($path);
                $ext = explode(".", $_FILES['file']['name']);
                $_FILES['file']['name'] = date("sB")."-" . rand(10, 10000);
                $ext = strtolower($ext[count($ext)-1]);
                $_FILES['file']['name'] = $_FILES['file']['name'].".".$ext;
                if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif','webp' ) ) ) {
                    $type = 'pic';
                }
                else{
                    $type = 'file';
                }
                $success = $config->UploadFile($type, "file", 99900000);
                $explode_name_pic = explode(':', $success);
                if ($explode_name_pic[0] == "done") {
                    $insert_result = $upload_model->insertWithBind([
                        'client_id' => CLIENT_ID ,
                        'file' => $explode_name_pic[1],
                    ]);
                }

            }
            if ($insert_result) {
                return self::returnJson(true, 'آپلود فایل با موفقیت انجام شد');
            }
            return self::returnJson(false, 'خطا در آپلود فایل جدید.', null, 500);

        }
    }

    public function listUpload($data_main_page = []) {
        $result = [];
        $uploadList = $this->getModel('uploadFileModel')->get();
        $upload_table = $uploadList->getTable();
        if (!isset($data_main_page['limit']) || empty($data_main_page['limit'])) {
            $data_main_page['limit'] = 10;
        }
        $uploadList->orderBy($upload_table . '.id', 'DESC');

        $listUpload = $uploadList->all();
        foreach ($listUpload as $key => $value) {
            $pic = $listUpload[$key]['file'];
            $ext = explode(".", $pic);
            $ext = strtolower($ext[count($ext)-1]);
            if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif','webp' ) ) ) {
                $type = 'pic';
            }
            else{
                $type = 'file';
            }
            $listUpload[$key]['type'] = $type;
            $listUpload[$key]['kind'] = $ext;
        }
        $result = $this->addUploadsIndexes($listUpload);
        return $result;
    }
    public function findUploadById($id) {
        return $this->getModel('uploadFileModel')->get()->where('id', $id)->find();
    }
    public function deleteUpload($data_update) {
        $check_exist_upload = $this->findUploadById($data_update['id']);
        if ($check_exist_upload) {
            $path = PIC_ROOT . 'uploads/'.CLIENT_ID.'/' . $check_exist_upload['file'];
            $result_update_upload = $this->getModel('uploadFileModel')->delete("id='{$data_update['id']}'");
            if ($result_update_upload) {
                unlink($path);
                return functions::withSuccess('', 200, 'حذف فایل با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در حذف');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }
    public function deleteAllUpload() {
        
        if (isset($_POST['checkbox'])) {
            foreach ($_POST['checkbox'] as $k => $v) {
                if ($v != 'false') {
                    $check_exist_upload = $this->findUploadById($v);
                    $path = PIC_ROOT . 'uploads/' . CLIENT_ID . '/' . $check_exist_upload['file'];
                    $result_update_upload = $this->getModel('uploadFileModel')->delete("id='{$v}'");
                    if ($result_update_upload) {
                        unlink($path);
                        $this->getModel('uploadFileModel')->delete("id='$v'");
                    }
                }
            }
            return self::returnJson(true, 'حذف فایل با موفقیت انجام شد');
        }else {
            return functions::withSuccess('', 200, 'خطا در ارسال اطلاعات');
        }
    }
    public function getFile($id) {
        $file_model = $this->getModel('uploadFileModel');
        $file_table = $file_model->getTable();
        $file = $file_model
            ->get(
                [
                    $file_table . '.*',
                ], true
            )
            ->where($file_table . '.id', $id)
            ->find(false);

        $pic = $this->addUploadsIndexes([$file])[0]['pic'];
        $ext = explode(".", $pic);
        $ext = strtolower($ext[count($ext)-1]);
        $this->addUploadsIndexes([$file])[0]['type']  = '';
        if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' , 'webp' ) ) ) {
            $type = 'pic';
        } else {
            $type = 'file';
        }
        $file['type'] = $type;
        return $this->addUploadsIndexes([$file])[0];
    }

}