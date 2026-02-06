<?php
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
class introductCountry extends clientAuth {
    /**
     * @var string
     */
    public $noPhotoUrl , $introductCountryBaseUrl;
    private $introductCountryTb , $introductCountryProvinceTb , $page_limit;
    /**
     * @var string
     */
    private $photoUrl;
    public function __construct() {
    parent::__construct();
    $this->introductCountryTb = 'introduct_country_tb';
    $this->introductCountryProvinceTb = 'introduct_country_province_tb';
    $this->page_limit = 6;
    $this->noPhotoUrl = 'project_files/images/no-photo.png';
    $this->photoUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/';
    $this->introductCountryBaseUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/introductCountry' . '/';
    }

    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        return json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }


    public function addCountryIndexes(array $categoryList){
        $result = [];
        foreach ($categoryList as $key => $category) {
            $result[$key] = $category;
            $time_date = functions::ConvertToDateJalaliInt($category['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['is_active'] = "{$category['is_active']}";
            $result[$key]['alt'] = $category['title'] ?: '';
            $result[$key]['pic_show'] = $this->photoUrl . 'introductCountry/' . CLIENT_ID . '/'. $category['pic'];
            $result[$key]['pic_medium'] = $this->photoUrl . 'introductCountry/' . CLIENT_ID . '/medium/'. $category['pic'];
            $result[$key]['pic_thumb'] = $this->photoUrl . 'introductCountry/' . CLIENT_ID . '/thumb/'. $category['pic'];

        }
        return $result;
    }
    public function addProvinceIndexes(array $picList){
        $result = [];
        foreach ($picList as $key => $pic) {
            $result[$key] = $pic;
            $time_date = functions::ConvertToDateJalaliInt($pic['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['is_active'] = "{$pic['is_active']}";
            $result[$key]['alt'] = $pic['title'] ?: '';
            $result[$key]['pic_show'] = $this->photoUrl . 'introductCountryProvince/' . CLIENT_ID . '/'. $pic['pic'];
            $result[$key]['pic_medium'] = $this->photoUrl . 'introductCountryProvince/' . CLIENT_ID . '/medium/' . $pic['pic'];
            $result[$key]['pic_thumb'] = $this->photoUrl . 'introductCountryProvince/' . CLIENT_ID . '/thumb/' . $pic['pic'];

            $result[$key]['pic_show2'] = $this->photoUrl . 'introductCountryProvince/' . CLIENT_ID . '/'. $pic['pic2'];
            $result[$key]['pic_medium2'] = $this->photoUrl . 'introductCountryProvince/' . CLIENT_ID . '/medium/' . $pic['pic2'];
            $result[$key]['pic_thumb2'] = $this->photoUrl . 'introductCountryProvince/' . CLIENT_ID . '/thumb/' . $pic['pic2'];
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
    public function insertCountry($params) {
        $dataUpdate =[];
        if ( isset($_FILES['pic']['name'])) {
            $result_upload = self::uploadPic('pic', 'introductCountry');
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
            'note_1' => $params['note_1'],
            'note_2' => $params['note_2'],
            'note_3' => $params['note_3'],
            'note_4' => $params['note_4'],
            'note_5' => $params['note_5'],
            'note_6' => $params['note_6'],
            'note_7' => $params['note_7'],
            'note_8' => $params['note_8'],
            'video_url' => $params['video_url'],
            'is_active' => true,
            'created_at' => date('Y-m-d H:i:s', time()),
        ];
        $result = array_merge($dataUpdate,$data);
        $insert = $this->getModel('introductCountryModel')->insertWithBind($result);
        if ($insert) {
            return self::returnJson(true, 'افزودن کشور با موفقیت انجام شد');
        }

        return self::returnJson(false, 'خطا در ثبت کشور جدید.', null, 500);

    }


    public function listCountry($data_main_page = []) {
//var_dump($data_main_page);
//die;
        $result = [];
        $country_model = $this->getModel('introductCountryModel')
            ->get()
            ->where('deleted_at', null, 'IS');
        $country_table = $country_model->getTable();

        if (@$data_main_page['is_active '] ) {
            $country_model->where($country_table . '.is_active', 1);
        }
        $country_model->orderBy('orders', 'ASC');
        if (isset($data_main_page['limit']) || !empty($data_main_page['limit'])) {
            $country_model->limit(0, $data_main_page['limit']);
        }
        $listCountry = $country_model->all(false);

        foreach ($listCountry as $key => $value) {
            $pic = $listCountry[$key]['pic'];
            $ext = explode(".", $pic);
            $ext = strtolower($ext[count($ext)-1]);
            if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
                $type = 'pic';
            } else {
                $type = 'file';
            }
            $listCountry[$key]['type'] = $type;
        }
        $result = $this->addCountryIndexes($listCountry);
        return $result;
    }

    public function listCountrySite($data_main_page = []) {
//var_dump($data_main_page);
//die;
        $result = [];
        $country_model = $this->getModel('introductCountryModel')
            ->get()
            ->where('deleted_at', null, 'IS')
            ->where('language', SOFTWARE_LANG);
        $country_table = $country_model->getTable();

        if (@$data_main_page['is_active '] ) {
            $country_model->where($country_table . '.is_active', 1);
        }
        $country_model->orderBy('title', 'ASC');
        $country_model->orderBy('orders', 'ASC');
        if (isset($data_main_page['limit']) || !empty($data_main_page['limit'])) {
            $country_model->limit(0, $data_main_page['limit']);
        }
        $listCountry = $country_model->all(false);

        foreach ($listCountry as $key => $value) {
            $pic = $listCountry[$key]['pic'];
            $ext = explode(".", $pic);
            $ext = strtolower($ext[count($ext)-1]);
            if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
                $type = 'pic';
            } else {
                $type = 'file';
            }
            $listCountry[$key]['type'] = $type;
        }
        $result = $this->addCountryIndexes($listCountry);
        return $result;
    }


    public function countItemList($countryId = null) {
        $item_model = $this->getModel('introductCountryProvinceModel')->get()->where('country_id', $countryId);
        $result =  $item_model->all();
        $count = count($result);
        return $count;
    }

    public function findCountryById($id) {
        return $this->getModel('introductCountryModel')->get()->where('id', $id)->find();
    }
    public function updateActiveCountry($data_update) {
        $check_exist_country = $this->findCountryById($data_update['id']);
        if ($check_exist_country) {
            $data_update_status['is_active'] = ($check_exist_country['is_active'] == 1) ? 0 : 1;
            $condition_update_status ="id='{$check_exist_country['id']}'";
            $result_update = $this->getModel('introductCountryModel')->updateWithBind($data_update_status,$condition_update_status);
            if ($result_update) {
                return functions::withSuccess('', 200, 'ویرایش وضعیت کشور  با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش وضعیت کشور ');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }


    public function deleteCountry($params) {
        $result = $this->getModel('introductCountryModel')->softDelete([
            'id' => $params['id']
        ]);
        if ($result) {
            return functions::JsonSuccess($result, 'کشور مورد نظر حذف شد');
        }
        return functions::JsonError($result, 'خطا در حذف', 200);
    }


    public function changeOrder($params){
        if (isset($params['data'])) {
            foreach ($params['data'] as $k => $v) {
                $model = $this->getModel('introductCountryModel');
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

    public function getCountry($id) {
        $country_model = $this->getModel('introductCountryModel');
        $country_table = $country_model->getTable();
        $category = $country_model
            ->get(
                [
                    $country_table . '.*',
                ], true
            )
            ->where($country_table . '.id', $id)
            ->find(false);

        $pic = $this->addCountryIndexes([$category])[0]['pic'];
        $ext = explode(".", $pic);
        $ext = strtolower($ext[count($ext)-1]);
        $this->addCountryIndexes([$category])[0]['type']  = '';
        if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
            $type = 'pic';
        } else {
            $type = 'file';
        }
        $category['type'] = $type;
        return $this->addCountryIndexes([$category])[0];
    }

    public function updateCountry($params) {
        $country_model = $this->getModel('introductCountryModel');
        $dataUpdate =[];
        if ( isset($_FILES['pic']['name'])) {
            $result_upload = self::uploadPic('pic', 'introductCountry');
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
            'note_1' => $params['note_1'],
            'note_2' => $params['note_2'],
            'note_3' => $params['note_3'],
            'note_4' => $params['note_4'],
            'note_5' => $params['note_5'],
            'note_6' => $params['note_6'],
            'note_7' => $params['note_7'],
            'note_8' => $params['note_8'],
            'video_url' => $params['video_url'],
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];
        $result = array_merge($dataUpdate,$data);
        $update = $country_model->updateWithBind($result, ['id' => $params['id']]);
        if ($update) {
            return functions::withSuccess('', 200, 'ویرایش کشور  با موفقیت انجام شد');

        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');

    }

    public function insertProvince($params) {
        if ($params['countryId']) {
            $dataUpdate =[];
            if ( isset($_FILES['pic']['name'])) {
                $result_upload = self::uploadPic('pic', 'introductCountryProvince');
                $dataUpdate = [
                    'pic' => $result_upload,
                ];
                if (empty($result_upload)) {
                    return functions::withError('', 200, 'ورود فیلد تصویر اجباری می باشد');
                }
            }
            $dataUpdate2 =[];
            if (@$_FILES['pic2']['name']) {
                $result_upload2 = self::uploadPic('pic2', 'introductCountryProvince');
                $dataUpdate2 = [
                    'pic2' => $result_upload2,
                ];

            }
            $data = [
                'country_id' => $params['countryId'],
                'title' => $params['title'],
                'video_url' => $params['video_url'],
                'content' => $params['content'],
                'description' => $params['description'],
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s', time()),
            ];
            $result = array_merge($dataUpdate,$dataUpdate2,$data);
            $insert = $this->getModel('introductCountryProvinceModel')->insertWithBind($result);
            if ($insert) {
                return self::returnJson(true, 'افزودن استان با موفقیت انجام شد');
            }
            return self::returnJson(false, 'خطا در ثبت استان جدید.', 500);

        }else{
            return self::returnJson(false, 'لطفا یک کشور انتخاب نمائید', 500);
        }

    }

    public function listProvince($data_main_page = []) {

        $result = [];
        $itemList = $this->getModel('introductCountryProvinceModel')->get()->where('deleted_at', null, 'IS');
        $item_table = $itemList->getTable();


        if (@$data_main_page['is_active'] ) {
            $itemList->where($item_table . '.is_active', 1);
        }
        if (@$data_main_page['countryId'] ) {
            $itemList->where($item_table . '.country_id', $data_main_page['countryId']);
        }
        $itemList->orderBy('orders', 'ASC');
        if (isset($data_main_page['limit']) || !empty($data_main_page['limit'])) {
            $itemList->limit(0, $data_main_page['limit']);
        }

        $listProvince = $itemList->all(false);
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
            $listProvince[$key]['cat_title'] = $this->getModel('introductCountryModel')->get()->where('id', $listProvince[$key]['country_id'])->find();

        }
        $result = $this->addProvinceIndexes($listProvince);
        return $result;
    }
    public function findProvinceById($id) {
        return $this->getModel('introductCountryProvinceModel')->get()->where('id', $id)->find();
    }
    public function updateActiveProvince($data_update) {
        $check_exist_province = $this->findProvinceById($data_update['id']);
        if ($check_exist_province) {
            $data_update_status['is_active'] = ($check_exist_province['is_active'] == 1) ? 0 : 1;
            $condition_update_status ="id='{$check_exist_province['id']}'";
            $result_update_province = $this->getModel('introductCountryProvinceModel')->updateWithBind($data_update_status,$condition_update_status);
            if ($result_update_province) {
                return functions::withSuccess('', 200, 'ویرایش وضعیت نمایش استان با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش وضعیت نمایش استان');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }
    public function deleteProvince($params) {
        $result = $this->getModel('introductCountryProvinceModel')->softDelete([
            'id' => $params['id']
        ]);
        if ($result) {
            return functions::JsonSuccess($result, 'استان مورد نظر حذف شد');
        }
        return functions::JsonError($result, 'خطا در حذف', 200);
    }

    public function getProvince($id) {
        $item_model = $this->getModel('introductCountryProvinceModel');
        $item_table = $item_model->getTable();
        $list_item = $item_model
            ->get(
                [
                    $item_table . '.*',
                ], true
            )
            ->where($item_table . '.id', $id)
            ->find(false);
        $pic = $this->addProvinceIndexes([$list_item])[0]['pic'];
        $ext = explode(".", $pic);
        $ext = strtolower($ext[count($ext)-1]);
        $this->addProvinceIndexes([$list_item])[0]['type']  = '';
        if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
            $type = 'pic';
        } else {
            $type = 'file';
        }
        $list_item['type'] = $type;
        return $this->addProvinceIndexes([$list_item])[0];
    }

    public function updateProvince($params) {
        /** @var CountryProvince $item_model */
        $province_model = $this->getModel('introductCountryProvinceModel');
        $dataUpdate =[];
        if ( isset($_FILES['pic']['name'])) {
            $result_upload = self::uploadPic('pic', 'introductCountryProvince');
            if (empty($result_upload)) {
                return functions::withError('', 200, 'ورود فیلد تصویر اجباری می باشد');
            }
            $dataUpdate = [
                'pic' => $result_upload,
            ];
        }
        $dataUpdate2 =[];
        if (@isset($_FILES['pic2']['name'])) {
            $result_upload2 = self::uploadPic('pic2', 'introductCountryProvince');
            $dataUpdate2 = [
                'pic2' => $result_upload2,
            ];

        }
        $data = [
            'country_id' => $params['countryId'],
            'title' => $params['title'],
            'video_url' => $params['video_url'],
            'content' => $params['content'],
            'description' => $params['description'],
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];
        $result = array_merge($dataUpdate,$dataUpdate2,$data);
        $update = $province_model->updateWithBind($result, ['id' => $params['id']]);
        if ($update) {
            return functions::withSuccess('', 200, 'ویرایش استان با موفقیت انجام شد');

        }

    }



    public function changeOrderProvince($params){
        if (isset($params['data'])) {
            foreach ($params['data'] as $k => $v) {
                $model = $this->getModel('introductCountryProvinceModel');
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

    public function getListProvince($data_main_page = []) {

        $result = [];
        $itemList = $this->getModel('introductCountryProvinceModel')->get()->where('deleted_at', null, 'IS');
        $item_table = $itemList->getTable();


        if ($data_main_page['is_active'] ) {
            $itemList->where($item_table . '.is_active', 1);
        }
        if ($data_main_page['countryId']  ) {
            $itemList->where($item_table . '.country_id', $data_main_page['countryId']);
        }
        $itemList->orderBy('orders', 'ASC');
        if (isset($data_main_page['limit']) || !empty($data_main_page['limit'])) {
            $itemList->limit(0, $data_main_page['limit']);
        }

        $listItem = $itemList->all(false);

        $result = $this->addProvinceIndexes($listItem);
        return $result;
    }

}