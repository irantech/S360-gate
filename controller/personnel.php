<?php

//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

class personnel extends clientAuth
{
    public $noPhotoUrl , $personnelBaseUrl;
    private $personnelTb;
    /**
     * @var string
     */
    private $page_limit;
        /**

         * @var string
         */
    private $photoUrl;

    public function __construct() {
        parent::__construct();
        $this->personnelTb = 'personnel_tb';
        $this->page_limit = 6;
        $this->noPhotoUrl = 'project_files/images/nophoto.png';
        $this->photoUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/';
        $this->personnelBaseUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/personnel' . '/';
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

    public function addPersonnelIndexes(array $personnelList) {
        $result = [];

        foreach ($personnelList as $key => $personnel) {
            $result[$key] = $personnel;
            $time_date = functions::ConvertToDateJalaliInt($personnel['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['image'] = $this->featuredImageUrl($personnel['image']);
            $result[$key]['link'] = "{$this->personnelBaseUrl}{$personnel['id']}";

        }
        return $result;
    }

    public function storePersonnel($params) {

        $media = [];
        foreach ($params['socialLinks'] as $key => $record) {
            if ($record['link']!='' && $record['social_media']!='') {
                $media[$key] = $record;
            }
        }
        /** @var personnelModel $Model */
        $personnel_model = $this->getModel('personnelModel');
        $personnel['name'] = $params['name'];
        $personnel['position'] = $params['position'];
        $personnel['education'] = $params['education'];
        $personnel['experience'] = $params['experience'];
        $personnel['language'] = $params['language'];
//        $personnel['social_media'] = json_encode($params['socialLinks'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $personnel['social_media'] = json_encode($media, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $personnel['created_at'] = date('Y-m-d H:i:s', time());
        $personnel['updated_at'] = date('Y-m-d H:i:s', time());

        if (isset($_FILES['feature_image'])) {
            /** @var application $config */
            $config = Load::Config('application');
            $path = "personnel/";
            $config->pathFile($path);
            $ext = explode(".", $_FILES['feature_image'][name]);
            $_FILES['feature_image'][name] = date("sB")."-" . rand(10, 10000);
            $ext = strtolower($ext[count($ext)-1]);
            $_FILES['feature_image'][name] = $_FILES['feature_image'][name].".".$ext;
            if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
                $type = 'pic';
            } else{
                $type = 'file';
            }
            $avatar_image_upload = $config->UploadFile($type, "feature_image", "");
            $explode_name_pic = explode(':', $avatar_image_upload);
            if ($explode_name_pic[0] == 'done') {
                $feature_image = $path . $explode_name_pic[1];
                $personnel['image'] = $feature_image;
            }
        }
        $insert = $personnel_model->insertWithBind($personnel);
        if ($insert) {
            return self::returnJson(true, 'این پرسنل با موفقیت در سیستم به ثبت رسید');
        }

        return self::returnJson(false, 'خطا در ثبت اطلاعات در سیستم.', null, 500);

    }

    public function updatePersonnel($params) {

        /** @var application $config */
        /** @var personnelModel $personnel_model */
        $personnel_model = $this->getModel('personnelModel');
        $dataUpdate = [
            'name'      => $params['name'],
            'language'      => $params['language'],
            'position'       => $params['position'],
            'education'    => $params['education'],
            'experience'    => $params['experience'],
            'language'      => $params['language'],
            'social_media'       => json_encode($params['socialLinks'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'updated_at'    => date('Y-m-d H:i:s', time()),
        ];

        if (isset($_FILES['feature_image'])) {
            /** @var application $config */
            $config = Load::Config('application');
            $path = "personnel/";
            $config->pathFile($path);
            $ext = explode(".", $_FILES['feature_image'][name]);
            $_FILES['feature_image'][name] = date("sB")."-" . rand(10, 10000);
            $ext = strtolower($ext[count($ext)-1]);
            $_FILES['feature_image'][name] = $_FILES['feature_image'][name].".".$ext;
            if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
                $type = 'pic';
            } else{
                $type = 'file';
            }
            $feature_upload = $config->UploadFile($type, "feature_image", "");
            $explode_name_pic = explode(':', $feature_upload);
            if ($explode_name_pic[0] == 'done') {
                $feature_image = $path . $explode_name_pic[1];
                $dataUpdate['image'] = $feature_image;
            }
        }

        $update = $personnel_model->updateWithBind($dataUpdate, ['id' => $params['personnel_id']]);

        if ($update) {
            return self::returnJson(true, 'پرسنل با موفقیت در سیستم بروزرسانی شد');
        }

        return self::returnJson(false, 'خطا در ثبت اطلاعات در سیستم.', null, 500);
    }


    public function getPersonnels($data_main_page = []){

        $personnel_model = $this->getModel('personnelModel');
        $personnel_table = $personnel_model->getTable();
        $personnels = $personnel_model
            ->get([
                $personnel_table . '.*',
            ], true);
        if ($data_main_page['lang'] != '' ) {
            $personnels->where($personnel_table . '.language', $data_main_page['lang']);
        }
        $personnels = $personnels->where($personnel_table . '.deleted_at', null, 'IS');
        $personnels = $personnels->orderBy($personnel_table . '.id');

        $personnels = $personnels->all(false);
        $result['data'] = $this->addPersonnelIndexes($personnels);
        return $result;
    }

    public function getPersonnel($id) {
        $personnel_model = $this->getModel('personnelModel');
        $personnel_table = $personnel_model->getTable();
        $personnel = $personnel_model
            ->get(
                [
                    $personnel_table . '.*',
                ], true
            )
            ->where($personnel_table . '.id', $id)
            ->find(false);
        return $this->addPersonnelIndexes([$personnel])[0];
    }

    public function DeletePersonnel($params) {
        $result = $this->getModel('personnelModel')->softDelete([
            'id' => $params['personnel_id']
        ]);
        if ($result) {
            return functions::JsonSuccess($result, 'این پرسنل حذف شد');
        }
        return functions::JsonError($result, 'خطا در پرسنل', 200);
    }


    public function featuredImageUrl($feature_image) {
        $url = (!empty($feature_image)) ? $this->photoUrl . $feature_image : $this->noPhotoUrl;
        return str_replace('personnels', 'personnels', $url);
    }

    public function getPersonnelsPosition($data_search) {

        $personnel_model = $this->getModel('personnelModel');
        $personnel_table = $personnel_model->getTable();

        if (!isset($data_search['limit']) || empty($data_search['limit'])) {
            $data_search['limit'] = 10;
        }
        $personnels = $personnel_model->get()
            ->where($personnel_table . '.deleted_at', null, 'IS');
        $personnels = $personnels->orderBy($personnel_table . '.created_at');

        $personnels = $personnels->limit(0, $data_search['limit'])->all(false);

        return $this->addPersonnelIndexes($personnels);

    }


}
