<?php

class gallery extends clientAuth {
    /**
     * @var string
     */
    public $noPhotoUrl , $galleryCategoryBaseUrl;
    private $galleryCategoryTb , $galleryTb , $page_limit;
    /**
     * @var string
     */
    private $photoUrl;
    public function __construct() {
    parent::__construct();
    $this->galleryCategoryTb = 'gallery_category_tb';
    $this->galleryTb = 'gallery_tb';
    $this->page_limit = 6;
    $this->noPhotoUrl = 'project_files/images/no-photo.png';
    $this->photoUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/';
    $this->galleryCategoryBaseUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/galleryCategory' . '/';
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
     * @param array $galleryCategoryList
     * @return array
     */

    public function addGalleryCategoryIndexes(array $categoryList){
        $result = [];
        foreach ($categoryList as $key => $category) {
            $result[$key] = $category;
            $time_date = functions::ConvertToDateJalaliInt($category['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['is_active'] = "{$category['is_active']}";
            $result[$key]['alt'] = $category['title'] ?: '';
            $result[$key]['tiny_title'] = $category['title'] ?: '';
            $result[$key]['tiny_text'] = $category['description'] ?: '';
            $result[$key]['pic'] = $this->photoUrl . 'galleryCategory/' . CLIENT_ID . '/'. $category['pic'];
            $result[$key]['pic_medium'] = $this->photoUrl . 'galleryCategory/' . CLIENT_ID . '/medium/'. $category['pic'];
            $result[$key]['pic_thumb'] = $this->photoUrl . 'galleryCategory/' . CLIENT_ID . '/thumb/'. $category['pic'];

        }
        return $result;
    }
    public function addGalleryPicIndexes(array $picList){
        $result = [];
        foreach ($picList as $key => $pic) {
            $result[$key] = $pic;
            $time_date = functions::ConvertToDateJalaliInt($pic['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['is_active'] = "{$pic['is_active']}";
            $result[$key]['alt'] = $pic['title'] ?: '';
            $result[$key]['tiny_title'] = $pic['title'] ?: '';
            $result[$key]['tiny_text'] = $pic['description'] ?: '';
            $result[$key]['pic'] = $this->photoUrl . 'galleryPic/' . CLIENT_ID . '/'. $pic['pic'];
            $result[$key]['pic_medium'] = $this->photoUrl . 'galleryPic/' . CLIENT_ID . '/medium/' . $pic['pic'];
            $result[$key]['pic_thumb'] = $this->photoUrl . 'galleryPic/' . CLIENT_ID . '/thumb/' . $pic['pic'];

        }
        return $result;
    }


    public function insertGalleryCategory($params) {
        /** @var application $config */
        $config = Load::Config('application');
        $path = "galleryCategory/".CLIENT_ID."/";
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
            functions::SaveImages('pic/galleryCategory/'.CLIENT_ID ,'', $result_upload);
        }
        if (empty($result_upload)) {
            return functions::withError('', 200, 'ورود فیلد تصویر اجباری می باشد');
        }
        $dataGalleryCategory = [
            'pic' => $result_upload,
            'title' => $params['title'],
            'language' => $params['language'],
            'description' => $params['description'],
            'is_active' => true,
            'created_at' => date('Y-m-d H:i:s', time()),
        ];

        $insert = $this->getModel('galleryCategoryModel')->insertWithBind($dataGalleryCategory);
        if ($insert) {
            return self::returnJson(true, 'افزودن دسته بندی با موفقیت انجام شد');
        }


        return self::returnJson(false, 'خطا در ثبت دسته بندی جدید.', null, 500);

    }


    public function listGalleryCategory($data_main_page = []) {
        $result = [];
        $gallery_category_model = $this->getModel('galleryCategoryModel')->get();
        $gallery_category_table = $gallery_category_model->getTable();
        if (!isset($data_main_page['limit']) || empty($data_main_page['limit'])) {
            $data_main_page['limit'] = 10;
        }
        if ($data_main_page['is_active'] ) {
            $gallery_category_model->where($gallery_category_table . '.is_active', 1);
        }
        $gallery_category_model->orderBy('id' , 'DESC')->limit(0,$data_main_page['limit']);
        $listGalleryCategory = $gallery_category_model->all();
        foreach ($listGalleryCategory as $key => $value) {
            $pic = $listGalleryCategory[$key]['pic'];
            $ext = explode(".", $pic);
            $ext = strtolower($ext[count($ext)-1]);
            if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
                $type = 'pic';
            } else {
                $type = 'file';
            }
            $listGalleryCategory[$key]['type'] = $type;
        }
        $result = $this->addGalleryCategoryIndexes($listGalleryCategory);
        return $result;
    }

    public function listGalleryCategorySite($data_main_page = []) {
        $result = [];
        $gallery_category_model = $this->getModel('galleryCategoryModel')->get();
        $gallery_category_table = $gallery_category_model->getTable();
        if (!isset($data_main_page['limit']) || empty($data_main_page['limit'])) {
            $data_main_page['limit'] = 10;
        }
        $gallery_category_model->where($gallery_category_table . '.language', SOFTWARE_LANG);

        if ($data_main_page['is_active'] ) {
            $gallery_category_model->where($gallery_category_table . '.is_active', 1);
        }
        if (isset($data_main_page['order']) || !empty($data_main_page['order'])) {
            $gallery_category_model->orderBy($gallery_category_table . '.orders', $data_main_page['order']);
        }else {
            $gallery_category_model->orderBy($gallery_category_table . '.id', 'DESC');
        }
        $gallery_category_model->limit(0,$data_main_page['limit']);

        $listGalleryCategory = $gallery_category_model->all();
        foreach ($listGalleryCategory as $key => $value) {
            $pic = $listGalleryCategory[$key]['pic'];
            $ext = explode(".", $pic);
            $ext = strtolower($ext[count($ext)-1]);
            if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
                $type = 'pic';
            } else {
                $type = 'file';
            }
            $listGalleryCategory[$key]['type'] = $type;
        }
        $result = $this->addGalleryCategoryIndexes($listGalleryCategory);
        return array_chunk($result,3);
//        return $result;
    }

    public function findGalleryCategoryById($id) {
        return $this->getModel('galleryCategoryModel')->get()->where('id', $id)->find();
    }
    public function updateActiveGalleryCategory($data_update) {
        $check_exist_gallery_cat = $this->findGalleryCategoryById($data_update['id']);
        if ($check_exist_gallery_cat) {
            $data_update_status['is_active'] = ($check_exist_gallery_cat['is_active'] == 1) ? 0 : 1;
            $condition_update_status ="id='{$check_exist_gallery_cat['id']}'";
            $result_update_gallery_cat = $this->getModel('galleryCategoryModel')->updateWithBind($data_update_status,$condition_update_status);
            if ($result_update_gallery_cat) {
                return functions::withSuccess('', 200, 'ویرایش وضعیت دسته بندی گالری  با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش وضعیت دسته بندی ');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }
    public function deleteGalleryCategory($data_update) {
        $check_exist_gallery_category = $this->findGalleryCategoryById($data_update['id']);
        if ($check_exist_gallery_category) {
            $path = PIC_ROOT . 'galleryCategory/' .CLIENT_ID.'/'.$check_exist_gallery_category['pic'];
            $pathThumb = PIC_ROOT . 'galleryCategory/'.CLIENT_ID. '/thumb/' .'/'. $check_exist_gallery_category['pic'];
            $pathMedium = PIC_ROOT . 'galleryCategory/'.CLIENT_ID. '/medium/' .'/'. $check_exist_gallery_category['pic'];
            $result_update_gallery_category = $this->getModel('galleryCategoryModel')->delete("id='{$data_update['id']}'");
            if ($result_update_gallery_category) {
                unlink($path);
                unlink($pathThumb);
                unlink($pathMedium);
                return functions::withSuccess('', 200, 'حذف دسته بندی گالری با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در حذف دسته بندی گالری');
        }
    }


    public function changeOrder($params){
        if (isset($params['data'])) {
            foreach ($params['data'] as $k => $v) {
                $model = $this->getModel('galleryCategoryModel');
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
    public function getGalleryCategory($id) {
        $gallery_category_model = $this->getModel('galleryCategoryModel');
        $gallery_category_table = $gallery_category_model->getTable();
        $gallery_category = $gallery_category_model
            ->get(
                [
                    $gallery_category_table . '.*',
                ], true
            )
            ->where($gallery_category_table . '.id', $id)
            ->find(false);

        $pic = $this->addGalleryCategoryIndexes([$gallery_category])[0]['pic'];
        $ext = explode(".", $pic);
        $ext = strtolower($ext[count($ext)-1]);
        $this->addGalleryCategoryIndexes([$gallery_category])[0]['type']  = '';
        if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
            $type = 'pic';
        } else {
            $type = 'file';
        }
        $gallery_category['type'] = $type;
        return $this->addGalleryCategoryIndexes([$gallery_category])[0];
    }

    public function updateGalleryCategory($params) {
        /** @var galleryCategoryModel $gallery_category_model */
        $gallery_category_model = $this->getModel('galleryCategoryModel');
        $dataUpdate =[];
        if (isset($_FILES['pic']['name'])) {
            $check_exist = $this->findGalleryCategoryById($params['id']);
            if ($check_exist) {
                functions::DeleteImages('galleryCategory/'.CLIENT_ID.'/' ,$check_exist['pic']);
            }
            /** @var application $config */
            $config = Load::Config('application');
            $path = "galleryCategory/".CLIENT_ID."/";
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
                functions::SaveImages('pic/galleryCategory/'.CLIENT_ID ,'', $result_upload);
            }
            if (empty($dataUpdate)) {
                return functions::withError('', 200, 'ورود فیلد تصویر اجباری می باشد');
            }
        }
        $data = [
            'title' => $params['title'],
            'description' => $params['description'],
            'language' => $params['language'],
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];
        $result = array_merge($dataUpdate,$data);
        $update = $gallery_category_model->updateWithBind($result, ['id' => $params['id']]);
        if ($update) {
//            return functions::withSuccess('', 200, 'ویرایش دسته بندی گالری  با موفقیت انجام شد');
            return self::returnJson(true, 'ویرایش دسته بندی گالری با موفقیت انجام شد');

        }

    }

    public function countPicList($catId = null) {

        $gallery_pic_model = $this->getModel('galleryPicModel')->get()->where('cat_id', $catId);
        $result =  $gallery_pic_model->all();
        $count = count($result);
        return $count;
    }

    //add pic for category
    public function insertGalleryPic($params) {
        if ($params['catId']) {
            /** @var application $config */
            $config = Load::Config('application');
            $path = "galleryPic/" . CLIENT_ID . "/";
            $config->pathFile($path);
            $ext = explode(".", $_FILES['pic']['name']);
            $_FILES['pic']['name'] = date("sB") . "-" . rand(10, 10000);
            $ext = strtolower($ext[count($ext) - 1]);
            $_FILES['pic']['name'] = $_FILES['pic']['name'] . "." . $ext;
            if (in_array($ext, array('jpg', 'jpe', 'jpeg', 'png', 'gif'))) {
                $type = 'pic';
            } else {
                $type = 'file';
            }
            $result_upload = $config->UploadFile($type, "pic", "");
            $explode_name_pic = explode(':', $result_upload);

            if ($explode_name_pic[0] == 'done') {
                $result_upload = $explode_name_pic[1];
            } else {
                return functions::withError('', 200, $explode_name_pic[0]);
            }
            if ($type = 'pic') {
                functions::SaveImages('pic/galleryPic/' . CLIENT_ID, '', $result_upload);
            }
            if (empty($result_upload)) {
                return functions::withError('', 200, 'ورود فیلد تصویر اجباری می باشد');
            }
            $dataGalleryPic = [
                'cat_id' => $params['catId'],
                'pic' => $result_upload,
                'title' => $params['title'],
                'description' => $params['description'],
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s', time()),
            ];

            $insert = $this->getModel('galleryPicModel')->insertWithBind($dataGalleryPic);
            if ($insert) {
                return self::returnJson(true, 'افزودن تصویر با موفقیت انجام شد');
            }
            return self::returnJson(false, 'خطا در ثبت تصویر جدید.', 500);

        }else{
            return self::returnJson(false, 'لطفا یک دسته بندی انتخاب نمائید', 500);
        }

    }

    public function listGalleryPic($data_main_page = []) {
        $result = [];
        $galleryPicList = $this->getModel('galleryPicModel')->get();
        $pic_table = $galleryPicList->getTable();
        if (!isset($data_main_page['limit']) || empty($data_main_page['limit'])) {
            $data_main_page['limit'] = 10;
        }

        if (isset($data_main_page['is_active']) || !empty($data_main_page['is_active'])) {
            $galleryPicList->where($pic_table . '.is_active', 1);
        }
        if ($data_main_page['catId'] ) {
            $galleryPicList->where($pic_table . '.cat_id', $data_main_page['catId']);
        }
        $galleryPicList->orderBy('id' ,'DESC')->limit(0,$data_main_page['limit']);

        $listPic = $galleryPicList->all();
        foreach ($listPic as $key => $value) {
            $pic = $listPic[$key]['pic'];
            $ext = explode(".", $pic);
            $ext = strtolower($ext[count($ext)-1]);
            if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
                $type = 'pic';
            } else {
                $type = 'file';
            }
            $listPic[$key]['type'] = $type;
            $listPic[$key]['cat_title'] = $this->getModel('galleryCategoryModel')->get()->where('id', $listPic[$key]['cat_id'])->find();

        }
        $result = $this->addGalleryPicIndexes($listPic);
        return $result;
    }

    public function findGalleryPicById($id) {
        return $this->getModel('galleryPicModel')->get()->where('id', $id)->find();
    }
    public function updateActiveGalleryPic($data_update) {
        $check_exist_gallery_pic = $this->findGalleryPicById($data_update['id']);
        if ($check_exist_gallery_pic) {
            $data_update_status['is_active'] = ($check_exist_gallery_pic['is_active'] == 1) ? 0 : 1;
            $condition_update_status ="id='{$check_exist_gallery_pic['id']}'";
            $result_update_gallery_pic = $this->getModel('galleryPicModel')->updateWithBind($data_update_status,$condition_update_status);
            if ($result_update_gallery_pic) {
                return functions::withSuccess('', 200, 'ویرایش وضعیت نمایش تصویر  با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش وضعیت نمایش تصویر ');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }

    public function deleteGalleryPic($data_update) {
        $check_exist_gallery_pic = $this->findGalleryPicById($data_update['id']);
        if ($check_exist_gallery_pic) {
            $path = PIC_ROOT . 'galleryPic/' .CLIENT_ID.'/'.$check_exist_gallery_pic['pic'];
            $pathThumb = PIC_ROOT . 'galleryPic/'.CLIENT_ID. '/thumb/' .'/'. $check_exist_gallery_pic['pic'];
            $pathMedium = PIC_ROOT . 'galleryPic/'.CLIENT_ID. '/medium/' .'/'. $check_exist_gallery_pic['pic'];
            $result_update_gallery_pic = $this->getModel('galleryPicModel')->delete("id='{$data_update['id']}'");
            if ($result_update_gallery_pic) {
                unlink($path);
                unlink($pathThumb);
                unlink($pathMedium);
                return functions::withSuccess('', 200, 'حذف تصویر با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در حذف تصویر');
        }
    }

    public function getGalleryPic($id) {
        $gallery_pic_model = $this->getModel('galleryPicModel');
        $gallery_pic_table = $gallery_pic_model->getTable();
        $gallery_pic = $gallery_pic_model
            ->get(
                [
                    $gallery_pic_table . '.*',
                ], true
            )
            ->where($gallery_pic_table . '.id', $id)
            ->find(false);

        $pic = $this->addGalleryPicIndexes([$gallery_pic])[0]['pic'];
        $ext = explode(".", $pic);
        $ext = strtolower($ext[count($ext)-1]);
        $this->addGalleryPicIndexes([$gallery_pic])[0]['type']  = '';
        if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
            $type = 'pic';
        } else {
            $type = 'file';
        }
        $gallery_pic['type'] = $type;
        return $this->addGalleryPicIndexes([$gallery_pic])[0];
    }
    public function updateGalleryPic($params) {
        /** @var galleryPicModel $gallery_pic_model */
        $gallery_pic_model = $this->getModel('galleryPicModel');
        $dataUpdate =[];
        if (isset($_FILES['pic']['name'])) {
            $check_exist = $this->findGalleryPicById($params['id']);
            if ($check_exist) {
                functions::DeleteImages('galleryPic/'.CLIENT_ID.'/' ,$check_exist['pic']);
            }
            /** @var application $config */
            $config = Load::Config('application');
            $path = "galleryPic/".CLIENT_ID."/";
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
                functions::SaveImages('pic/galleryPic/'.CLIENT_ID ,'', $result_upload);
            }
            if (empty($dataUpdate)) {
                return functions::withError('', 200, 'ورود فیلد تصویر اجباری می باشد');
            }
        }
        $data = [
            'cat_id' => $params['catId'],
            'title' => $params['title'],
            'description' => $params['description'],
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];
        $result = array_merge($dataUpdate,$data);
        $update = $gallery_pic_model->updateWithBind($result, ['id' => $params['id']]);
        if ($update) {
            return functions::withSuccess('', 200, 'ویرایش تصویر با موفقیت انجام شد');

        }

    }

}