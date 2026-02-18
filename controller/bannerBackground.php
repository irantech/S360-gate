<?php

class bannerBackground extends clientAuth {
    /**
     * @var string
     */
    private $bannerBackgroundTb , $page_limit;
    /**
     * @var string
     */
    private $photoUrl;
    public function __construct() {
    parent::__construct();
    $this->bannerBackgroundTb = 'banner_background_tb';
    $this->page_limit = 6;
        $this->photoUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/';
        $this->bannerBackgroundBaseUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/bannerBackground' . '/';
    }
    /**
     * @param array $bannerBackgroundList
     * @return array
     */
    public function addBannerBackgroundIndexes(array $bannerBackgroundList) {
        $result = [];

        foreach ($bannerBackgroundList as $key => $bannerBackground) {
            $result[$key] = $bannerBackground;
            $time_date = functions::ConvertToDateJalaliInt($bannerBackground['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['pic'] = $this->photoUrl . 'bannerBackground/'. $bannerBackground['pic'];

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

    public function listBannerBackground() {
        $bannerBackgroundList = $this->getModel('bannerBackgroundModel')->get();
        $bannerBackgroundList->orderBy('id', 'DESC');
        $listBanner = $bannerBackgroundList->all();
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
        return  $this->addBannerBackgroundIndexes($listBanner);
    }

    public function insertBannerBackground($params) {
        /** @var application $config */
        $config = Load::Config('application');
        $path = "bannerBackground/";
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
        $result_upload = $config->UploadFile($type, "pic", 524288);
        $explode_name_pic = explode(':', $result_upload);

        if ($explode_name_pic[0] == 'done') {
            $result_upload = $explode_name_pic[1];
        }else{
            return functions::withError('', 200, $explode_name_pic[0]);
        }
        if ($type = 'pic'){
            functions::SaveImages('pic/bannerBackground/' ,'', $result_upload);
        }
        if (empty($result_upload)) {
            return functions::withError('', 200, 'ورود فیلد فایل اجباری می باشد');
        }
        $data = [
            'pic' => $result_upload,
            'title' => $params['title'],
            'created_at' => date('Y-m-d H:i:s', time()),
        ];

        $insert = $this->getModel('bannerBackgroundModel')->insertWithBind($data);
        if ($insert) {
            return self::returnJson(true, 'افزودن بنر بک گراند با موفقیت انجام شد');
        }

        return self::returnJson(false, 'خطا در ثبت گالری بنر بک گراند جدید.', null, 500);

    }
    public function findBannerBackgroundById($id) {
        return $this->getModel('bannerBackgroundModel')->get()->where('id', $id)->find();
    }



    public function deleteBannerBackground($data_update) {
        $check_exist_gallery_banner = $this->findBannerBackgroundById($data_update['id']);
        if ($check_exist_gallery_banner) {
            $path = PIC_ROOT . 'bannerBackground/'.$check_exist_gallery_banner['pic'];
            $pathThumb = PIC_ROOT . 'bannerBackground/thumb/' .'/'. $check_exist_gallery_banner['pic'];
            $pathMedium = PIC_ROOT . 'bannerBackground/medium/' .'/'. $check_exist_gallery_banner['pic'];
            $result_update_gallery_banner = $this->getModel('bannerBackgroundModel')->delete("id='{$data_update['id']}'");
            if ($result_update_gallery_banner) {
                unlink($path);
                unlink($pathThumb);
                unlink($pathMedium);
                return functions::withSuccess('', 200, 'حذف  بنر بک گراند با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در حذف بنر بک گراند');

        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }

    public function getLastImageBackGround() {
        return $this->getModel('bannerBackgroundModel')->get()->orderBy('id')->limit(0,1)->find();
    }





}