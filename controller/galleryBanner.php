<?php

class galleryBanner extends clientAuth {
    /**
     * @var string
     */
    public $noPhotoUrl , $galleryBannerBaseUrl;
    private $galleryBannerTb , $page_limit;
    /**
     * @var string
     */
    private $photoUrl;
    public function __construct() {
    parent::__construct();
    $this->galleryBannerTb = 'gallery_banner_tb';
    $this->page_limit = 6;
    $this->noPhotoUrl = 'project_files/images/no-photo.png';
    $this->photoUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/';
    $this->galleryBannerBaseUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/galleryBanner' . '/';
    }
    /**
     * @param array $galleryBannerList
     * @return array
     */
    public function addGalleryBannerIndexes(array $galleryBannerList) {
        $result = [];

        foreach ($galleryBannerList as $key => $galleryBanner) {

            $result[$key] = $galleryBanner;
            $time_date = functions::ConvertToDateJalaliInt($galleryBanner['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['tiny_text'] = strip_tags(substr_replace($galleryBanner['description'], "...", 250));
            $result[$key]['url'] = "{$galleryBanner['link']}";
            $result[$key]['is_active'] = "{$galleryBanner['is_active']}";
            $result[$key]['link'] = "{$this->galleryBannerBaseUrl}{$galleryBanner['id']}";
            $result[$key]['alt'] = $galleryBanner['title'] ?: '';
            $result[$key]['pic'] = $this->photoUrl . 'galleryBanner/' . CLIENT_ID . '/'. $galleryBanner['pic'];
            $result[$key]['pic_medium'] = $this->photoUrl . 'galleryBanner/' . CLIENT_ID . '/medium/' . $galleryBanner['pic'];
            $result[$key]['pic_thumb'] = $this->photoUrl . 'galleryBanner/' . CLIENT_ID . '/thumb/' . $galleryBanner['pic'];


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
    public function listGalleryBanner($data_main_page = []) {
        $result = [];
        $galleryBannerList = $this->getModel('galleryBannerModel')->get();
        $banner_table = $galleryBannerList->getTable();


        if ($data_main_page['is_active'] ) {
            $galleryBannerList->where($banner_table . '.is_active', 1);
            $galleryBannerList->where($banner_table . '.language', SOFTWARE_LANG);
        }
        if (isset($data_main_page['order']) || !empty($data_main_page['order'])) {
            $galleryBannerList->orderBy($banner_table . '.orders', $data_main_page['order']);
        }else {
            $galleryBannerList->orderBy($banner_table . '.id', 'DESC');
        }
        if (isset($data_main_page['limit']) || !empty($data_main_page['limit'])) {
            $galleryBannerList->limit(0,$data_main_page['limit']);
        }
        $listBanner = $galleryBannerList->all();
        foreach ($listBanner as $key => $value) {
           $pic = $listBanner[$key]['pic'];
            $ext = explode(".", $pic);
            $ext = strtolower($ext[count($ext)-1]);
            if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
                $type = 'pic';
            } else {
                $type = 'file';
            }
            $listBanner[$key]['type'] = $type;
            }

       return  $this->addGalleryBannerIndexes($listBanner);

    }

    public function insertGalleryBanner($params) {
        /** @var application $config */
        $config = Load::Config('application');
        $path = "galleryBanner/".CLIENT_ID."/";
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
            functions::SaveImages('pic/galleryBanner/'.CLIENT_ID ,'', $result_upload);
        }
        if (empty($result_upload)) {
            return functions::withError('', 200, 'ورود فیلد فایل اجباری می باشد');
        }
        $dataGalleryBanner = [
            'link' => $params['link'],
            'pic' => $result_upload,
            'title' => $params['title'],
            'description' => $params['description'],
            'iframe_code' => $params['iframe_code'],
            'language' => $params['language'],
            'is_active' => true,
            'created_at' => date('Y-m-d H:i:s', time()),
        ];

        $insert = $this->getModel('galleryBannerModel')->insertWithBind($dataGalleryBanner);
        if ($insert) {
            return self::returnJson(true, 'افزودن گالری بنر با موفقیت انجام شد');
        }


        return self::returnJson(false, 'خطا در ثبت گالری بنر جدید.', null, 500);

    }


    public function updateGalleryBanner($params) {
        /** @var galleryBannerModel $gallery_banner_model */
        $gallery_banner_model = $this->getModel('galleryBannerModel');
        $dataUpdate =[];

        if (isset($_FILES['pic']['name'])) {
            $check_exist = $this->findGalleryBannerById($params['id']);
            if ($check_exist) {
                functions::DeleteImages('galleryBanner/'.CLIENT_ID.'/' ,$check_exist['pic']);
            }


            /** @var application $config */
            $config = Load::Config('application');
            $path = "galleryBanner/".CLIENT_ID."/";
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
            functions::SaveImages('pic/galleryBanner/'.CLIENT_ID ,'', $result_upload);
            }
            if (empty($dataUpdate)) {
                return functions::withError('', 200, 'ورود فیلد تصویر اجباری می باشد');
            }
        }

        $data = [
            'link' => $params['link'],
            'title' => $params['title'],
            'language' => $params['language'],
            'description' => $params['description'],
            'iframe_code' => $params['iframe_code'],
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];
        $result = array_merge($dataUpdate,$data);

        $update = $gallery_banner_model->updateWithBind($result, ['id' => $params['id']]);

        if ($update) {
//            return functions::withSuccess('', 200, 'ویرایش گالری بنر  با موفقیت انجام شد');
            return self::returnJson(true, 'ویرایش گالری بنر با موفقیت انجام شد');

        }

    }


    public function findGalleryBannerById($id) {
        return $this->getModel('galleryBannerModel')->get()->where('id', $id)->find();
    }

    public function getGalleryBanner($id) {
        $gallery_banner_model = $this->getModel('galleryBannerModel');
        $gallery_banner_table = $gallery_banner_model->getTable();
        $gallery_banner = $gallery_banner_model
            ->get(
                [
                    $gallery_banner_table . '.*',
                ], true
            )
            ->where($gallery_banner_table . '.id', $id)
            ->find(false);

        $pic = $this->addGalleryBannerIndexes([$gallery_banner])[0]['pic'];
        $ext = explode(".", $pic);
        $ext = strtolower($ext[count($ext)-1]);
        $this->addGalleryBannerIndexes([$gallery_banner])[0]['type']  = '';
        if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
            $type = 'pic';
        } else {
            $type = 'file';
        }
        $gallery_banner['type'] = $type;
        return $this->addGalleryBannerIndexes([$gallery_banner])[0];
    }

    public function deleteGalleryBanner($data_update) {
        $check_exist_gallery_banner = $this->findGalleryBannerById($data_update['id']);
        if ($check_exist_gallery_banner) {
            $path = PIC_ROOT . 'galleryBanner/' .CLIENT_ID.'/'.$check_exist_gallery_banner['pic'];
            $pathThumb = PIC_ROOT . 'galleryBanner/'.CLIENT_ID. '/thumb/' .'/'. $check_exist_gallery_banner['pic'];
            $pathMedium = PIC_ROOT . 'galleryBanner/'.CLIENT_ID. '/medium/' .'/'. $check_exist_gallery_banner['pic'];
            $result_update_gallery_banner = $this->getModel('galleryBannerModel')->delete("id='{$data_update['id']}'");
            if ($result_update_gallery_banner) {
                unlink($path);
                unlink($pathThumb);
                unlink($pathMedium);
//                unlink(PIC_ROOT . 'galleryBanner/' . $check_exist['file']);
                return functions::withSuccess('', 200, 'حذف گالری بنر با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در حذف گالری بنر');

        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }


    public function updateStatusGalleryBanner($data_update) {

        $check_exist_gallery_banner = $this->findGalleryBannerById($data_update['id']);
        if ($check_exist_gallery_banner) {
            $data_update_status['is_active'] = ($check_exist_gallery_banner['is_active'] == 1) ? 0 : 1;
            $condition_update_status ="id='{$check_exist_gallery_banner['id']}'";
            $result_update_gallery_banner = $this->getModel('galleryBannerModel')->updateWithBind($data_update_status,$condition_update_status);

            if ($result_update_gallery_banner) {
                return functions::withSuccess('', 200, 'ویرایش وضعیت گالری بنر  با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش وضعیت گالری بنر ');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');

    }

    public function changeOrder($params){
        if (isset($params['data'])) {
            foreach ($params['data'] as $k => $v) {
                $model = $this->getModel('galleryBannerModel');
                $dataUpdate = [
                    'orders' => $v
                ];
                $model->updateWithBind($dataUpdate, ['id' => $k]);
            }
            return self::returnJson(true, 'درخواست شما با موفقیت انجام شد');
        }else {
            return self::returnJson(true, 'هیچ موردی انتخاب نشده یا تغییری اعمال نشده است');
        }
    }
    public function listGalleryBannerApi($params) {
        $result = $this->listGalleryBanner($params);
        return functions::withSuccess($result);
    }

}