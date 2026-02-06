<?php
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
class introductIran extends clientAuth {
    /**
     * @var string
     */
    public $noPhotoUrl , $introductIranBaseUrl;
    private $introductIranTb , $introductIranItemTb , $page_limit;
    /**
     * @var string
     */
    private $photoUrl;
    public function __construct() {
    parent::__construct();
    $this->introductIranTb = 'introduct_iran_tb';
    $this->introductIranItemTb = 'introduct_iran_item_tb';
    $this->page_limit = 6;
    $this->noPhotoUrl = 'project_files/images/no-photo.png';
    $this->photoUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/';
    $this->introductIranBaseUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/introductIran' . '/';
    }

    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        return json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }


    public function addProvinceIndexes(array $categoryList){
        $result = [];
        foreach ($categoryList as $key => $category) {
            $result[$key] = $category;
            $time_date = functions::ConvertToDateJalaliInt($category['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['is_active'] = "{$category['is_active']}";
            $result[$key]['alt'] = $category['title'] ?: '';
            $result[$key]['pic_show'] = $this->photoUrl . 'introductIran/' . CLIENT_ID . '/'. $category['pic'];
            $result[$key]['pic_medium'] = $this->photoUrl . 'introductIran/' . CLIENT_ID . '/medium/'. $category['pic'];
            $result[$key]['pic_thumb'] = $this->photoUrl . 'introductIran/' . CLIENT_ID . '/thumb/'. $category['pic'];

        }
        return $result;
    }
    public function addItemIndexes(array $picList){
        $result = [];
        foreach ($picList as $key => $pic) {
            $result[$key] = $pic;
            $time_date = functions::ConvertToDateJalaliInt($pic['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['is_active'] = "{$pic['is_active']}";
            $result[$key]['alt'] = $pic['title'] ?: '';
            $result[$key]['pic_show'] = $this->photoUrl . 'introductIranItem/' . CLIENT_ID . '/'. $pic['pic'];
            $result[$key]['pic_medium'] = $this->photoUrl . 'introductIranItem/' . CLIENT_ID . '/medium/' . $pic['pic'];
            $result[$key]['pic_thumb'] = $this->photoUrl . 'introductIranItem/' . CLIENT_ID . '/thumb/' . $pic['pic'];

            $result[$key]['pic_show2'] = $this->photoUrl . 'introductIranItem/' . CLIENT_ID . '/'. $pic['pic2'];
            $result[$key]['pic_medium2'] = $this->photoUrl . 'introductIranItem/' . CLIENT_ID . '/medium/' . $pic['pic2'];
            $result[$key]['pic_thumb2'] = $this->photoUrl . 'introductIranItem/' . CLIENT_ID . '/thumb/' . $pic['pic2'];
        }
        return $result;
    }


//    public function changeNameUpload($fileName) {
//        $ext = explode(".", $fileName);
//        $fileName = date("sB")."-" . rand(10, 10000);
//        $ext = strtolower($ext[count($ext)-1]);
//        $fileName = $fileName.".".$ext;
//        return $fileName;
//    }

    public function uploadPic($name , $folder) {
        /** @var application $config */
        $config = Load::Config('application');
        $path = $folder."/" . CLIENT_ID . "/";
        $config->pathFile($path);
        $ext = explode(".", $_FILES[$name]['name']);
        $_FILES[$name]['name'] = date("sB") . rand(10, 10000);
        $ext = strtolower($ext[count($ext) - 1]);
        $_FILES[$name]['name'] = $_FILES[$name]['name'] . "." . $ext;
        if (in_array($ext, array('jpg', 'jpe', 'jpeg', 'png', 'gif'))) {
            $type = 'pic';
        } else {
            $type = 'file';
        }
        $result = $config->UploadFile($type, $name, "");
        $explode_name_pic = explode(':', $result);
        if ($explode_name_pic[0] == 'done') {
            $result = $explode_name_pic[1];
        } else {
            return functions::withError('', 200, $explode_name_pic[0]);
        }
        if ($type = 'pic') {
            functions::SaveImages("pic/". $folder ."/" . CLIENT_ID, '', $result);
        }
        return $result;
    }
    public function insertProvince($params) {

        $dataUpdate =[];
        if ( isset($_FILES['pic']['name'])) {
            $result_upload = self::uploadPic('pic', 'introductIran');
            $dataUpdate = [
                'pic' => $result_upload,
            ];
            if (empty($result_upload)) {
                return functions::withError('', 200, 'ورود فیلد تصویر اجباری می باشد');
            }
        }
//        $params['description'] = filter_var($params['description'], FILTER_SANITIZE_STRING);
        $data = [
            'language' => $params['language'],
            'title' => $params['title'],
            'note_province' => $params['note_province'],
            'history_province' => $params['history_province'],
            'museums_province' => $params['museums_province'],
            'handicrafts_province' => $params['handicrafts_province'],
            'video_url' => $params['video_url'],
            'is_active' => true,
            'created_at' => date('Y-m-d H:i:s', time()),
        ];
        $result = array_merge($dataUpdate,$data);
        $insert = $this->getModel('introductIranModel')->insertWithBind($result);
        if ($insert) {
            return self::returnJson(true, 'افزودن استان با موفقیت انجام شد');
        }

        return self::returnJson(false, 'خطا در ثبت استان جدید.', null, 500);

    }


    public function listProvince($data_main_page = []) {
//var_dump($data_main_page);
//die;
        $result = [];
        $province_model = $this->getModel('introductIranModel')
            ->get()
            ->where('deleted_at', null, 'IS');
        $province_table = $province_model->getTable();

        if ($data_main_page['is_active '] ) {
            $province_model->where($province_table . '.is_active', 1);
        }
        $province_model->orderBy('orders', 'ASC');
        if (isset($data_main_page['limit']) || !empty($data_main_page['limit'])) {
            $province_model->limit(0, $data_main_page['limit']);
        }
        $listProvince = $province_model->all(false);

        foreach ($listProvince as $key => $value) {
            $pic = $listProvince[$key]['pic'];
            $ext = explode(".", $pic);
            $ext = strtolower($ext[count($ext)-1]);
            if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
                $type = 'pic';
            } else {
                $type = 'file';
            }
            $listProvince[$key]['type'] = $type;
        }
        $result = $this->addProvinceIndexes($listProvince);
        return $result;
    }

    public function listProvinceSite($data_main_page = []) {
//var_dump($data_main_page);
//die;
        $result = [];
        $province_model = $this->getModel('introductIranModel')
            ->get()
            ->where('deleted_at', null, 'IS')
            ->where('language', SOFTWARE_LANG);
        $province_table = $province_model->getTable();

        if ($data_main_page['is_active '] ) {
            $province_model->where($province_table . '.is_active', 1);
        }
        $province_model->orderBy('orders', 'ASC');
        if (isset($data_main_page['limit']) || !empty($data_main_page['limit'])) {
            $province_model->limit(0, $data_main_page['limit']);
        }
        $listProvince = $province_model->all(false);

        foreach ($listProvince as $key => $value) {
            $pic = $listProvince[$key]['pic'];
            $ext = explode(".", $pic);
            $ext = strtolower($ext[count($ext)-1]);
            if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
                $type = 'pic';
            } else {
                $type = 'file';
            }
            $listProvince[$key]['type'] = $type;
        }
        $result = $this->addProvinceIndexes($listProvince);
        return $result;
    }


    public function countItemList($provinceId = null) {
        $item_model = $this->getModel('introductIranItemModel')->get()->where('province_id', $provinceId);
        $result =  $item_model->all();
        $count = count($result);
        return $count;
    }

    public function findProvinceById($id) {
        return $this->getModel('introductIranModel')->get()->where('id', $id)->find();
    }
    public function updateActiveProvince($data_update) {
        $check_exist_province = $this->findProvinceById($data_update['id']);
        if ($check_exist_province) {
            $data_update_status['is_active'] = ($check_exist_province['is_active'] == 1) ? 0 : 1;
            $condition_update_status ="id='{$check_exist_province['id']}'";
            $result_update = $this->getModel('introductIranModel')->updateWithBind($data_update_status,$condition_update_status);
            if ($result_update) {
                return functions::withSuccess('', 200, 'ویرایش وضعیت استان  با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش وضعیت استان ');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }


    public function deleteProvince($params) {
        $result = $this->getModel('introductIranModel')->softDelete([
            'id' => $params['id']
        ]);
        if ($result) {
            return functions::JsonSuccess($result, 'استان مورد نظر حذف شد');
        }
        return functions::JsonError($result, 'خطا در حذف', 200);
    }


    public function changeOrder($params){
        if (isset($params['data'])) {
            foreach ($params['data'] as $k => $v) {
                $model = $this->getModel('introductIranModel');
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

    public function getProvince($id) {
        $province_model = $this->getModel('introductIranModel');
        $province_table = $province_model->getTable();
        $category = $province_model
            ->get(
                [
                    $province_table . '.*',
                ], true
            )
            ->where($province_table . '.id', $id)
            ->find(false);

        $pic = $this->addProvinceIndexes([$category])[0]['pic'];
        $ext = explode(".", $pic);
        $ext = strtolower($ext[count($ext)-1]);
        $this->addProvinceIndexes([$category])[0]['type']  = '';
        if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
            $type = 'pic';
        } else {
            $type = 'file';
        }
        $category['type'] = $type;
        return $this->addProvinceIndexes([$category])[0];
    }

    public function updateProvince($params) {

        $province_model = $this->getModel('introductIranModel');
        $dataUpdate =[];
        if ( isset($_FILES['pic']['name'])) {
            $result_upload = self::uploadPic('pic', 'introductIran');
            if (empty($result_upload)) {
                return functions::withError('', 200, 'ورود فیلد تصویر اجباری می باشد');
            }
            $dataUpdate = [
                'pic' => $result_upload,
            ];
        }
        $data = [
            'language' => $params['language'],
            'title' => $params['title'],
            'note_province' => $params['note_province'],
            'history_province' => $params['history_province'],
            'museums_province' => $params['museums_province'],
            'handicrafts_province' => $params['handicrafts_province'],
            'video_url' => $params['video_url'],
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];
        $result = array_merge($dataUpdate,$data);
        $update = $province_model->updateWithBind($result, ['id' => $params['id']]);
        if ($update) {
            return functions::withSuccess('', 200, 'ویرایش استان  با موفقیت انجام شد');

        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');

    }

    public function insertItem($params) {
        if ($params['provinceId']) {
            $dataUpdate =[];
            if ( isset($_FILES['pic']['name'])) {
                $result_upload = self::uploadPic('pic', 'introductIranItem');
                $dataUpdate = [
                    'pic' => $result_upload,
                ];
                if (empty($result_upload)) {
                    return functions::withError('', 200, 'ورود فیلد تصویر اجباری می باشد');
                }
            }
            $dataUpdate2 =[];
            if ( $_FILES['pic2']['name']) {
                $result_upload2 = self::uploadPic('pic2', 'introductIranItem');
                $dataUpdate2 = [
                    'pic2' => $result_upload2,
                ];

            }
            $data = [
                'province_id' => $params['provinceId'],
                'title' => $params['title'],
                'video_url' => $params['video_url'],
                'content' => $params['content'],
                'description' => $params['description'],
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s', time()),
            ];
            $result = array_merge($dataUpdate,$dataUpdate2,$data);
            $insert = $this->getModel('introductIranItemModel')->insertWithBind($result);
            if ($insert) {
                return self::returnJson(true, 'افزودن آثار باستانی با موفقیت انجام شد');
            }
            return self::returnJson(false, 'خطا در ثبت آثار باستانی جدید.', 500);

        }else{
            return self::returnJson(false, 'لطفا یک استان انتخاب نمائید', 500);
        }

    }

    public function listItem($data_main_page = []) {

        $result = [];
        $itemList = $this->getModel('introductIranItemModel')->get()->where('deleted_at', null, 'IS');
        $item_table = $itemList->getTable();


        if ($data_main_page['is_active'] ) {
            $itemList->where($item_table . '.is_active', 1);
        }
        if ($data_main_page['provinceId'] ) {
            $itemList->where($item_table . '.province_id', $data_main_page['provinceId']);
        }
        $itemList->orderBy('orders', 'ASC');
        if (isset($data_main_page['limit']) || !empty($data_main_page['limit'])) {
            $itemList->limit(0, $data_main_page['limit']);
        }

        $listItem = $itemList->all(false);
        foreach ($listItem as $key => $value) {
            $pic = $listItem[$key]['pic'];
            $ext = explode(".", $pic);
            $ext = strtolower($ext[count($ext)-1]);
            if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
                $type = 'pic';
            } else {
                $type = 'file';
            }
            $listItem[$key]['type'] = $type;
            $listItem[$key]['cat_title'] = $this->getModel('introductIranModel')->get()->where('id', $listItem[$key]['province_id'])->find();

        }
        $result = $this->addItemIndexes($listItem);
        return $result;
    }
    public function findItemById($id) {
        return $this->getModel('introductIranItemModel')->get()->where('id', $id)->find();
    }
    public function updateActiveItem($data_update) {
        $check_exist_item = $this->findItemById($data_update['id']);
        if ($check_exist_item) {
            $data_update_status['is_active'] = ($check_exist_item['is_active'] == 1) ? 0 : 1;
            $condition_update_status ="id='{$check_exist_item['id']}'";
            $result_update_item = $this->getModel('introductIranItemModel')->updateWithBind($data_update_status,$condition_update_status);
            if ($result_update_item) {
                return functions::withSuccess('', 200, 'ویرایش وضعیت نمایش آثار باستانی با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش وضعیت نمایش آثار باستانی ');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }
    public function deleteItem($params) {
        $result = $this->getModel('introductIranItemModel')->softDelete([
            'id' => $params['id']
        ]);
        if ($result) {
            return functions::JsonSuccess($result, 'آثار باستانی مورد نظر حذف شد');
        }
        return functions::JsonError($result, 'خطا در حذف', 200);
    }

    public function getItem($id) {
        $item_model = $this->getModel('introductIranItemModel');
        $item_table = $item_model->getTable();
        $list_item = $item_model
            ->get(
                [
                    $item_table . '.*',
                ], true
            )
            ->where($item_table . '.id', $id)
            ->find(false);
        $pic = $this->addItemIndexes([$list_item])[0]['pic'];
        $ext = explode(".", $pic);
        $ext = strtolower($ext[count($ext)-1]);
        $this->addItemIndexes([$list_item])[0]['type']  = '';
        if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
            $type = 'pic';
        } else {
            $type = 'file';
        }
        $list_item['type'] = $type;
        return $this->addItemIndexes([$list_item])[0];
    }

    public function updateItem($params) {
        /** @var itemModel $item_model */
        $item_model = $this->getModel('introductIranItemModel');
        $dataUpdate =[];
        if ( isset($_FILES['pic']['name'])) {
            $result_upload = self::uploadPic('pic', 'introductIranItem');
            if (empty($result_upload)) {
                return functions::withError('', 200, 'ورود فیلد تصویر اجباری می باشد');
            }
            $dataUpdate = [
                'pic' => $result_upload,
            ];
        }
        $dataUpdate2 =[];
        if ( $_FILES['pic2']['name']) {
            $result_upload2 = self::uploadPic('pic2', 'introductIranItem');
            $dataUpdate2 = [
                'pic2' => $result_upload2,
            ];

        }
        $data = [
            'province_id' => $params['provinceId'],
            'title' => $params['title'],
            'video_url' => $params['video_url'],
            'content' => $params['content'],
            'description' => $params['description'],
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];
        $result = array_merge($dataUpdate,$dataUpdate2,$data);
        $update = $item_model->updateWithBind($result, ['id' => $params['id']]);
        if ($update) {
            return functions::withSuccess('', 200, 'ویرایش آثار باستانی با موفقیت انجام شد');

        }

    }



    public function changeOrderItem($params){
        if (isset($params['data'])) {
            foreach ($params['data'] as $k => $v) {
                $model = $this->getModel('introductIranItemModel');
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

    public function my_substr($text, $start = 0, $end) {
        if (empty($text))
            return '';

        if (strlen($text) > $end) {
            $endText = '...';
        } else {
            $endText = '';
        }
        $out = mb_strcut($text, $start, $end, "UTF-8");

        $text = '' . $out . '' . $endText . '';

        return $text;
    }

    public function getListAncient($data_main_page = []) {
//        var_dump($data_main_page);
//        die;
        $result = [];
        $itemList = $this->getModel('introductIranItemModel')->get()->where('deleted_at', null, 'IS');
        $item_table = $itemList->getTable();


        if ($data_main_page['is_active'] ) {
            $itemList->where($item_table . '.is_active', 1);
        }

        if ($data_main_page['provinceId']  ) {
            $itemList->where($item_table . '.province_id', $data_main_page['provinceId']);
        }
        $itemList->orderBy('orders', 'ASC');
        if (isset($data_main_page['limit']) || !empty($data_main_page['limit'])) {
            $itemList->limit(0, $data_main_page['limit']);
        }

        $listItem = $itemList->all(false);
      
        $result = $this->addItemIndexes($listItem);
        return $result;
    }

}