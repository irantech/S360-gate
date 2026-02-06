<?php
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
class rentCar extends clientAuth {
    /**
     * @var string
     */
    public $noPhotoUrl , $rentCarCategoryBaseUrl;
    private $rentCarCategoryTb , $rentCarTb ,$rentCarBrand , $page_limit, $mainCity;
    /**
     * @var string
     */
    private $photoUrl;
    public function __construct() {
    parent::__construct();
    $this->rentCarCategoryTb = 'rent_car_category_tb';
    $this->rentCarTb = 'rent_car_tb';
    $this->rentCarBrandTb = 'rent_car_brand_tb';
    $this->page_limit = 6;
    $this->noPhotoUrl = 'project_files/images/no-photo.png';
    $this->photoUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/';
    $this->mainCity = Load::controller('mainCity');
    $this->rentCarCategoryBaseUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/rentCarCategory' . '/';
    }

    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        return json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }


    public function addCategoryIndexes(array $categoryList){
        $result = [];
        foreach ($categoryList as $key => $category) {
            $result[$key] = $category;
            $time_date = functions::ConvertToDateJalaliInt($category['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['is_active'] = "{$category['is_active']}";
            $result[$key]['alt'] = $category['title'] ?: '';
            $result[$key]['pic'] = $this->photoUrl . 'rentCarCategory/' . CLIENT_ID . '/'. $category['pic'];
            $result[$key]['pic_medium'] = $this->photoUrl . 'rentCarCategory/' . CLIENT_ID . '/medium/'. $category['pic'];
            $result[$key]['pic_thumb'] = $this->photoUrl . 'rentCarCategory/' . CLIENT_ID . '/thumb/'. $category['pic'];

        }
        return $result;
    }
    public function addCarIndexes(array $list){
        $result = [];
        foreach ($list as $key => $item) {
            $result[$key] = $item;
            $time_date = functions::ConvertToDateJalaliInt($item['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['is_active'] = "{$item['is_active']}";
            $result[$key]['alt'] = $item['title'] ?: '';
            $result[$key]['pic_1'] = $this->photoUrl . 'rentCar/' . CLIENT_ID . '/'. $item['pic'];
            $result[$key]['pic_show'] = (!empty($item['pic'])) ? $result[$key]['pic_1'] : $this->noPhotoUrl;
            $result[$key]['pic_medium'] = $this->photoUrl . 'rentCar/' . CLIENT_ID . '/medium/' . $item['pic'];
            $result[$key]['pic_thumb'] = $this->photoUrl . 'rentCar/' . CLIENT_ID . '/thumb/' . $item['pic'];
            $result[$key]['gallery'] = $this->rentCarGallery($item['id']);

        }
        return $result;
    }


    public function changeNameUpload($fileName) {
        $ext = explode(".", $fileName);
        $fileName = date("sB")."-" . rand(10, 10000);
        $ext = strtolower($ext[count($ext)-1]);
        $fileName = $fileName.".".$ext;
        return $fileName;
    }

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
    public function insertRentCarCategory($params) {

        $dataUpdate =[];
        if ( isset($_FILES['pic']['name'])) {
            $result_upload = self::uploadPic('pic', 'rentCarCategory');
            $dataUpdate = [
                'pic' => $result_upload,
            ];
            if (empty($result_upload)) {
                return functions::withError('', 200, 'ورود فیلد تصویر اجباری می باشد');
            }
        }
        $data = [
            'title' => $params['title'],
            'code' => $params['code'],
            'description' => $params['description'],
            'is_active' => true,
            'created_at' => date('Y-m-d H:i:s', time()),
        ];
        $result = array_merge($dataUpdate,$data);
        $insert = $this->getModel('rentCarCategoryModel')->insertWithBind($result);
        if ($insert) {
            return self::returnJson(true, 'افزودن دسته بندی با موفقیت انجام شد');
        }

        return self::returnJson(false, 'خطا در ثبت دسته بندی جدید.', null, 500);

    }


    public function listCategory($get_data = []) {

        $result = [];
        $category_model = $this->getModel('rentCarCategoryModel')->get()->where('deleted_at', null, 'IS');
        $category_table = $category_model->getTable();

        if ($get_data['is_active'] ) {
            $category_model->where($category_table . '.is_active', 1);
        }

        if (isset($get_data['order']) || !empty($get_data['order'])) {
            $category_model->orderBy($category_table . '.orders', $get_data['order']);
        }else {
            $category_model->orderBy($category_table . '.id', 'DESC');
        }
//        $category_model->orderBy('id', 'DESC');
        if (isset($get_data['limit']) || !empty($get_data['limit'])) {
            $category_model->limit(0, $get_data['limit']);
        }
        $listCategory = $category_model->all(false);
        foreach ($listCategory as $key => $value) {
            $pic = $listCategory[$key]['pic'];
            $ext = explode(".", $pic);
            $ext = strtolower($ext[count($ext)-1]);
            if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
                $type = 'pic';
            } else {
                $type = 'file';
            }
            $listCategory[$key]['type'] = $type;
        }
        $result = $this->addCategoryIndexes($listCategory);
        return $result;
    }

    public function countCarList($catId = null) {
        $car_model = $this->getModel('rentCarModel')->get()->where('cat_id', $catId);
        $result =  $car_model->all();
        $count = count($result);
        return $count;
    }

    public function findCategoryById($id) {
        return $this->getModel('rentCarCategoryModel')->get()->where('id', $id)->find();
    }
    public function updateActiveCategory($data_update) {
        $check_exist_cat = $this->findCategoryById($data_update['id']);
        if ($check_exist_cat) {
            $data_update_status['is_active'] = ($check_exist_cat['is_active'] == 1) ? 0 : 1;
            $condition_update_status ="id='{$check_exist_cat['id']}'";
            $result_update_cat = $this->getModel('rentCarCategoryModel')->updateWithBind($data_update_status,$condition_update_status);
            if ($result_update_cat) {
                return functions::withSuccess('', 200, 'ویرایش وضعیت دسته بندی خودرو  با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش وضعیت دسته بندی ');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }


    public function deleteCategory($params) {
        $result = $this->getModel('rentCarCategoryModel')->softDelete([
            'id' => $params['id']
        ]);
        if ($result) {
            return functions::JsonSuccess($result, 'دسته بندی مورد نظر حذف شد');
        }
        return functions::JsonError($result, 'خطا در حذف', 200);
    }

    public function changeOrder($params){
        if (isset($params['data'])) {
            foreach ($params['data'] as $k => $v) {
                $model = $this->getModel('rentCarCategoryModel');
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



    public function getCategory($id) {
        $category_model = $this->getModel('rentCarCategoryModel');
        $category_table = $category_model->getTable();
        $category = $category_model
            ->get(
                [
                    $category_table . '.*',
                ], true
            )
            ->where($category_table . '.id', $id)
            ->find(false);

        $pic = $this->addCategoryIndexes([$category])[0]['pic'];
        $ext = explode(".", $pic);
        $ext = strtolower($ext[count($ext)-1]);
        $this->addCategoryIndexes([$category])[0]['type']  = '';
        if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
            $type = 'pic';
        } else {
            $type = 'file';
        }
        $category['type'] = $type;
        return $this->addCategoryIndexes([$category])[0];
    }

    public function updateCategory($params) {
        $category_model = $this->getModel('rentCarCategoryModel');
        $dataUpdate =[];
        if ( isset($_FILES['pic']['name'])) {
            $result_upload = self::uploadPic('pic', 'rentCarCategory');
            if (empty($result_upload)) {
                return functions::withError('', 200, 'ورود فیلد تصویر اجباری می باشد');
            }
            $dataUpdate = [
                'pic' => $result_upload,
            ];
        }
        $data = [
            'title' => $params['title'],
            'code' => $params['code'],
            'description' => $params['description'],
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];
        $result = array_merge($dataUpdate,$data);
        $update = $category_model->updateWithBind($result, ['id' => $params['id']]);
        if ($update) {
            return functions::withSuccess('', 200, 'ویرایش دسته بندی خودرو  با موفقیت انجام شد');

        }

    }


    public function insertCar($params) {

        $temp_rent_car_model = Load::getModel('rentCarModel');
        $rent_car_gallery_model = $this->getModel('rentCarGalleryModel');
        if ($params['catId']) {
            $dataUpdate =[];
            if ( isset($_FILES['pic']['name'])) {
                $result_upload = self::uploadPic('pic', 'rentCar');
                $dataUpdate = [
                    'pic' => $result_upload,
                ];
                if (empty($result_upload)) {
                    return functions::withError('', 200, 'ورود فیلد تصویر اجباری می باشد');
                }
            }

            $data = [
                'cat_id' => $params['catId'],
                'brand_id' => $params['brandId'],
                'title' => $params['title'],
                'code' => $params['code'],
                'price_customer' => $params['price_customer'],
                'price_colleague' => $params['price_colleague'],
                'content' => $params['content'],
                'description' => $params['description'],
                'alt_pic' => $params['alt_pic'],
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s', time()),
            ];
            $config = Load::Config('application');
            $path = "rentCar/".CLIENT_ID."/gallery/";

            $config->pathFile($path);

            if (isset($_FILES['gallery_files']) && $_FILES['gallery_files'] != "") {

                $separated_files = functions::separateFiles('gallery_files');
                foreach ($separated_files as $image_key => $separated_file) {
                    $_FILES['file'] ='';
                    $_FILES['file'] = $separated_file;

                    if ($params['gallery_selected'] && $params['gallery_selected'] == $image_key) {
                        $_FILES['pic'] = $separated_file;
                        $params['feature_alt_image'] = $params['gallery_file_alts'][$image_key];
                        $_FILES['pic']['name'] = self::changeNameUpload($_FILES['pic']['name']);
                        $feature_upload = $config->UploadFile("pic", "pic", "5120000");
                        $explode_name_pic = explode(':', $feature_upload);
                        if ($explode_name_pic[0] == 'done') {
                            $pic = $path . $explode_name_pic[1];
//                            $dataInsert['pic'] = $pic;
                            $dataUpdate = [
                                'pic' => $pic,
                            ];
                            $data['alt_pic'] = $params['alt_pic'];
                        }


                    }
                }
            }


            $result = array_merge($dataUpdate,$data);


            $insert = $this->getModel('rentCarModel')->insertWithBind($result);
            $last_rent_car_id = $temp_rent_car_model->getLastId();
            if ($insert) {

                if (isset($_FILES['gallery_files']) && $_FILES['gallery_files'] != "") {

                    $separated_files = functions::separateFiles('gallery_files');
                    foreach ($separated_files as $image_key => $separated_file) {
                        $_FILES['file'] = $separated_file;
                        if ($params['gallery_selected'] && $params['gallery_selected'] == $image_key) {
                            $success = $feature_upload;
                        }else{

                            $_FILES['file']['name'] = self::changeNameUpload($_FILES['file']['name']);
                            $success = $config->UploadFile("pic", "file", "5120000");
                        }

                        $explode_name_pic = explode(':', $success);
                        if ($explode_name_pic[0] == "done") {

                            $rent_car_gallery_model->insertWithBind([
                                'rent_car_id' => $insert,
                                'file' => $explode_name_pic[1],
                                'alt' => $params['gallery_file_alts'][$image_key],
                            ]);
                        }

                    }
                }
            }
            if ($insert) {


                //var_dump($params['RentCar']["parameter_cat"][0]);
                //var_dump($params['RentCar']["question"][0]);
                //var_dump($params['RentCar']["answer"][0]);
                //die;


                if ($params['AddedItem']) {

                    $array_final=array();
                    foreach($_POST['AddedItem'] as $k => $v){
                            if ($v != '') {
                                $array_final[$k] = $v;

                        }
                    }

                    foreach($array_final  as $key=> $value){
                            $dataInsertItem = [
                                'rent_car_id' => $last_rent_car_id,
                                'parameter_cat' => $value['parameter_cat'],
                                'question' => $value['question'],
                                'answer' => $value['answer'],
                            ];
                            $this->getModel('rentCarParameterItemModel')->insertWithBind($dataInsertItem);
                    }
                }

            }
            if ($insert) {
                return self::returnJson(true, 'افزودن خودرو با موفقیت انجام شد');
            }
            return self::returnJson(false, 'خطا در ثبت خودرو جدید.', 500);

        }else{
            return self::returnJson(false, 'لطفا یک دسته بندی انتخاب نمائید', 500);
        }

    }
    public function rentCarGallery($rent_car_id) {
        $rent_car_gallery_model = $this->getModel('rentCarGalleryModel');

        $data = $rent_car_gallery_model->get()
            ->where('rent_car_id', $rent_car_id)
            ->all();

        $result = [];
        foreach ($data as $key => $item) {
            $result[] = [
                'src' => SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/rentCar/'. CLIENT_ID .'/gallery/' . $item['file'],
                'alt' => $item['alt'] ?: 'gallery image ' . $key,
                'id' => $item['id'],
            ];
        }
        return $result;
    }
    public function listCar($get_data = []) {

        $result = [];
        $carList = $this->getModel('rentCarModel')->get()->where('deleted_at', null, 'IS');
        $pic_table = $carList->getTable();


        if ($get_data['is_active'] ) {
            $carList->where($pic_table . '.is_active', 1);
        }
        if ($get_data['catId'] ) {
            $carList->where($pic_table . '.cat_id', $get_data['catId']);
        }
        $carList->orderBy('id', 'DESC');
        if (isset($get_data['limit']) || !empty($get_data['limit'])) {
            $carList->limit(0, $get_data['limit']);
        }

        $listCar = $carList->all(false);
        foreach ($listCar as $key => $value) {
            $pic = $listCar[$key]['pic'];
            $ext = explode(".", $pic);
            $ext = strtolower($ext[count($ext)-1]);
            if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
                $type = 'pic';
            } else {
                $type = 'file';
            }
            $listCar[$key]['type'] = $type;
            $listCar[$key]['cat_title'] = $this->getModel('rentCarCategoryModel')->get()->where('id', $listCar[$key]['cat_id'])->find();

        }
        $result = $this->addCarIndexes($listCar);
        return $result;
    }
    public function findCarById($id) {
        return $this->getModel('rentCarModel')->get()->where('id', $id)->find();
    }
    public function updateActiveCar($data_update) {
        $check_exist_car = $this->findCarById($data_update['id']);
        if ($check_exist_car) {
            $data_update_status['is_active'] = ($check_exist_car['is_active'] == 1) ? 0 : 1;
            $condition_update_status ="id='{$check_exist_car['id']}'";
            $result_update_car = $this->getModel('rentCarModel')->updateWithBind($data_update_status,$condition_update_status);
            if ($result_update_car) {
                return functions::withSuccess('', 200, 'ویرایش وضعیت نمایش خودرو با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش وضعیت نمایش خودرو ');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }


    public function deleteCar($params) {
        $result = $this->getModel('rentCarModel')->softDelete([
            'id' => $params['id']
        ]);
        if ($result) {
            return functions::JsonSuccess($result, 'خودرو مورد نظر حذف شد');
        }
        return functions::JsonError($result, 'خطا در حذف', 200);
    }

    public function getRentCar($id) {
        $car_model = $this->getModel('rentCarModel');
        $car_table = $car_model->getTable();
        $list_car = $car_model
            ->get(
                [
                    $car_table . '.*',
                ], true
            )
            ->where($car_table . '.id', $id)
            ->find(false);
        $pic = $this->addCarIndexes([$list_car])[0]['pic'];
        $ext = explode(".", $pic);
        $ext = strtolower($ext[count($ext)-1]);
        $this->addCarIndexes([$list_car])[0]['type']  = '';
        if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
            $type = 'pic';
        } else {
            $type = 'file';
        }
        $list_car['type'] = $type;
        return $this->addCarIndexes([$list_car])[0];
    }

    public function updateRentCar($params) {

        /** @var carModel $car_model */
        $car_model = $this->getModel('rentCarModel');
        $dataUpdate =[];
        if ( isset($_FILES['pic']['name'])) {
            $result_upload = self::uploadPic('pic', 'rentCar');
            if (empty($result_upload)) {
                return functions::withError('', 200, 'ورود فیلد تصویر اجباری می باشد');
            }
            $dataUpdate = [
                'pic' => $result_upload,
            ];
        }
        $data = [
            'cat_id' => $params['catId'],
            'brand_id' => $params['brandId'],
            'title' => $params['title'],
            'code' => $params['code'],
            'alt_pic' => $params['alt_pic'],
            'price_customer' => $params['price_customer'],
            'price_colleague' => $params['price_colleague'],
            'content' => $params['content'],
            'description' => $params['description'],
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];
        $result = array_merge($dataUpdate,$data);
        $update = $car_model->updateWithBind($result, ['id' => $params['id']]);



        //var_dump($params['RentCar']["parameter_cat"][0]);
        //var_dump($params['RentCar']["question"][0]);
        //var_dump($params['RentCar']["answer"][0]);
        //die;
//        var_dump($params['AddedItem']);
//        die;
        if ($params['AddedItem']) {
            $array_final=array();
            foreach($_POST['AddedItem'] as $k => $v){
                    if ($v != '') {
                        $array_final[$k] = $v;
                    }
            }
//            $this->getModel('rentCarParameterItemModel')->delete("rent_car_id='{$params['id']}'");

            foreach($array_final  as $key=> $value){

                if (isset($value['hasId'])) {
                    $data_param = [
                        'rent_car_id' => $params['id'],
                        'parameter_cat' => $value['parameter_cat'],
                        'question' => $value['question'],
                        'answer' => $value['answer'],
                        'updated_at' => date('Y-m-d H:i:s', time()),
                    ];
                    $update = $this->getModel('rentCarParameterItemModel')->updateWithBind($data_param, ['id' => $value['hasId']]);
                }else {
                    $dataInsertItem = [
                        'rent_car_id' => $params['id'],
                        'parameter_cat' => $value['parameter_cat'],
                        'question' => $value['question'],
                        'answer' => $value['answer'],
                        'updated_at' => date('Y-m-d H:i:s', time()),
                    ];
                    $this->getModel('rentCarParameterItemModel')->insertWithBind($dataInsertItem);
                }


            }
        }
//        if ($params['parameter_cat']) {
//            $array_final=array();
//            foreach($_POST['parameter_cat'] as $k => $v){
//                foreach($v as $k1 => $v1){
//                    if ($v1 != '') {
//                        $array_final[$k1][$k] = $v1;
//                    }
//                }
//            }
//            foreach($array_final  as $key=> $value){
//                $dataInsertItem = [
//                    'rent_car_id' => $params['id'],
//                    'parameter_cat' => $value['parameter_cat'],
//                    'question' => $value['question'],
//                    'answer' => $value['answer'],
//                ];
//                $this->getModel('rentCarParameterItemModel')->insertWithBind($dataInsertItem);
//            }
//        }
//

        $rent_car_gallery_model = $this->getModel('rentCarGalleryModel');
        if ($params['previous_gallery_selected']) {
            $check_exist = $rent_car_gallery_model->get()
                ->where('id', $params['previous_gallery_selected'])
                ->find();
            if ($check_exist) {
                $dataUpdate['feature_image'] = $check_exist['file'];
                $dataUpdate['feature_alt_image'] = $check_exist['alt'];


            }

        }


        if ($params['previous_gallery_file_alts']) {
            foreach ($params['previous_gallery_file_alts'] as $key => $alt) {
                $rent_car_gallery_model->updateWithBind([
                    'alt' => $alt
                ], [
                    'id' => $key
                ]);
            }
        }

        if ($update) {
            return functions::withSuccess('', 200, 'ویرایش خودرو با موفقیت انجام شد');

        }

    }

    public function deleteParameterItem($params) {
        $result = $this->getModel('rentCarParameterItemModel')->softDelete([
            'id' => $params['id']
        ]);
        if ($result) {
            return functions::JsonSuccess($result, 'پارامتر مورد نظر حذف شد');
        }
        return functions::JsonError($result, 'خطا در حذف', 200);
    }
    public function changeOrderItem($params){
        if (isset($params['data'])) {
            foreach ($params['data'] as $k => $v) {
                $model = $this->getModel('rentCarModel');
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

//    start for brand


    public function addBrandIndexes(array $brandList){
        $result = [];
        foreach ($brandList as $key => $brand) {
            $result[$key] = $brand;
            $time_date = functions::ConvertToDateJalaliInt($brand['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['is_active'] = "{$brand['is_active']}";
            $result[$key]['alt'] = $brand['title'] ?: '';
            $result[$key]['pic'] = $this->photoUrl . 'rentCarBrand/' . CLIENT_ID . '/'. $brand['pic'];
            $result[$key]['pic_medium'] = $this->photoUrl . 'rentCarBrand/' . CLIENT_ID . '/medium/'. $brand['pic'];
            $result[$key]['pic_thumb'] = $this->photoUrl . 'rentCarBrand/' . CLIENT_ID . '/thumb/'. $brand['pic'];

        }
        return $result;
    }

    public function listBrands() {
        $result = [];
        $brand_model = $this->getModel('rentCarBrandModel')->get()->where('deleted_at', null, 'IS');
        $brand_table = $brand_model->getTable();
        $brand_model->orderBy('id', 'DESC');
        $listBrand = $brand_model->all(false);
        foreach ($listBrand as $key => $value) {
            $pic = $listBrand[$key]['pic'];
            $ext = explode(".", $pic);
            $ext = strtolower($ext[count($ext)-1]);
            if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
                $type = 'pic';
            } else {
                $type = 'file';
            }
            $listBrand[$key]['type'] = $type;
        }
        $result = $this->addBrandIndexes($listBrand);
        return $result;
    }

    public function insertRentCarBrand($params) {

        $dataUpdate =[];
        if ( isset($_FILES['pic']['name'])) {
            $result_upload = self::uploadPic('pic', 'rentCarBrand');
            $dataUpdate = [
                'pic' => $result_upload,
            ];
//            if (empty($result_upload)) {
//                return functions::withError('', 200, 'ورود فیلد تصویر اجباری می باشد');
//            }
        }
        $data = [
            'title' => $params['title'],
            'title_en' => $params['title_en'],
            'description' => $params['description'],
            'is_active' => true,
            'created_at' => date('Y-m-d H:i:s', time()),
        ];
        $result = array_merge($dataUpdate,$data);
        $insert = $this->getModel('rentCarBrandModel')->insertWithBind($result);
        if ($insert) {
            return self::returnJson(true, 'افزودن برند با موفقیت انجام شد');
        }

        return self::returnJson(false, 'خطا در ثبت برند جدید.', null, 500);

    }


    public function changeOrderBrand($params){
        if (isset($params['data'])) {
            foreach ($params['data'] as $k => $v) {
                $model = $this->getModel('rentCarBrandModel');
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
    public function findBrandById($id) {
        return $this->getModel('rentCarBrandModel')->get()->where('id', $id)->find();
    }
    public function updateActiveBrand($data_update) {
        $check_exist_brand = $this->findBrandById($data_update['id']);
        if ($check_exist_brand) {
            $data_update_status['is_active'] = ($check_exist_brand['is_active'] == 1) ? 0 : 1;
            $condition_update_status ="id='{$check_exist_brand['id']}'";
            $result_update_cat = $this->getModel('rentCarBrandModel')->updateWithBind($data_update_status,$condition_update_status);
            if ($result_update_cat) {
                return functions::withSuccess('', 200, 'ویرایش وضعیت برند خودرو  با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش وضعیت برند خودرو ');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }

    public function deleteRentCarBrand($params) {
        $result = $this->getModel('rentCarBrandModel')->softDelete([
            'id' => $params['id']
        ]);
        if ($result) {
            return functions::JsonSuccess($result, 'برند مورد نظر حذف شد');
        }
        return functions::JsonError($result, 'خطا در حذف', 200);
    }
    public function getBrand($id) {
        $brand_model = $this->getModel('rentCarBrandModel');
        $brand_table = $brand_model->getTable();
        $brand = $brand_model
            ->get(
                [
                    $brand_table . '.*',
                ], true
            )
            ->where($brand_table . '.id', $id)
            ->find(false);

        $pic = $this->addBrandIndexes([$brand])[0]['pic'];
        $ext = explode(".", $pic);
        $ext = strtolower($ext[count($ext)-1]);
        $this->addBrandIndexes([$brand])[0]['type']  = '';
        if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
            $type = 'pic';
        } else {
            $type = 'file';
        }
        $brand['type'] = $type;
        return $this->addBrandIndexes([$brand])[0];
    }

    public function updateBrand($params) {
        $category_model = $this->getModel('rentCarBrandModel');
        $dataUpdate =[];
        if ( isset($_FILES['pic']['name'])) {
            $result_upload = self::uploadPic('pic', 'rentCarBrand');
//            if (empty($result_upload)) {
//                return functions::withError('', 200, 'ورود فیلد تصویر اجباری می باشد');
//            }
            $dataUpdate = [
                'pic' => $result_upload,
            ];
        }
        $data = [
            'title' => $params['title'],
            'title_en' => $params['title_en'],
            'description' => $params['description'],
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];
        $result = array_merge($dataUpdate,$data);
        $update = $category_model->updateWithBind($result, ['id' => $params['id']]);
        if ($update) {
            return functions::withSuccess('', 200, 'ویرایش برند خودرو  با موفقیت انجام شد');

        }

    }

    public function listParameterCar() {
        $result = [];
        $model = $this->getModel('rentCarParameterCatModel')->get()->where('deleted_at', null, 'IS');
        $table = $model->getTable();
        $model->orderBy('id', 'DESC');
        $list = $model->all(false);
        return $list;
    }

    public function listParameterItem($id) {
        $result = [];
        $item_list = $this->getModel('rentCarParameterItemModel')->get()->where('deleted_at', null, 'IS');
        $item_table = $item_list->getTable();
        if ($id ) {
            $item_list->where($item_table . '.rent_car_id', $id);
        }
        $result = $item_list->all(false);
        return $result;
    }


    public function getCategoriesParameter($parameter_cat_id) {
        $item_model = $this->getModel('rentCarParameterItemModel');
        $item_table = $item_model->getTable();
        $categories = $this->getModel('rentCarParameterCatModel')->get();
        $categories = $categories->where('deleted_at', null, 'IS')->orderBy('orders' , 'ASC')->all(false);
        $result = $this->addCategoryIndexes($categories);
        foreach ($categories as $key => $category){
            $parameter = [] ;
            $parameter = $item_model
                ->get([
                    $item_table . '.*'
                ], true)
                ->where($item_table . '.rent_car_id', $parameter_cat_id)
                ->where($item_table . '.parameter_cat', $category['id'])
                ->all(false);

            $result[$key]['parameter_items'] = $this->addCarIndexes($parameter) ;
            $result[$key]['item_count'] = count($parameter) ;
        }
        $last_result = [];
        $category_count = 0 ;
        foreach ($result as $key => $category){
            if($category['item_count'] > 0 ) {
                $last_result[] = $category;
                $category_count ++;
            }
        }
        return $last_result;
    }

    public function rentCarModel() {
        return Load::getModel( 'bookRentCarModel' );
    }
    public function orderReserveCar($data) {
        $count = 0;
        $tmp = mt_rand(1, 15);
        do {
            $tmp .= mt_rand(0, 15);
        } while (++$count < 16);
        $uniq = $tmp;
        $trackingCode = substr($uniq, 0, 10);
        $data_send = [
            'language' => SOFTWARE_LANG,
            'carId' => $data['carId'],
            'carType' => $data['carType'],
            'count_people' => $data['count_people'],
            'rent_date' => $data['rent_date'],
            'rent_place' => $data['rent_place'],
            'delivery_date' => $data['delivery_date'],
            'delivery_place' => $data['delivery_place'],
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile']
        ];
            $result = $this->rentCarModel()->insertWithBind($data_send);
            Load::library('Session');
            $user_id = Session::getUserId();

            $data_request = [
                'user_id' => $user_id,
                'module_id' => $result,
                'module_title' => 'rentCar',
                'tracking_code' => $trackingCode,
            ];
            $request_model = Load::getModel('requestServiceModel');
            $request_model->insertWithBind($data_request);

        if ( $result ) {
            $text_result = functions::Xmlinformation('YourRequestHasBeenSuccessfullyRegistered')->__toString(). '<br>'. functions::Xmlinformation('YourTrackingCode')->__toString() .':' . $trackingCode;
            return self::returnJson(true,  $text_result);
        } else {
            $text_result = functions::Xmlinformation('ErrorOrderRentCar ')->__toString(). '<br>'.':' . $trackingCode;
//            return "error : خطا در ثبت درخواست";
            return self::returnJson(false, $text_result);
        }

    }
    public function listReserveRentCar() {
        $rent_car_model = $this->getModel('bookRentCarModel');
        $rent_car_table = $rent_car_model->getTable();
        $request_service_model = $this->getModel('requestServiceModel');
        $request_service_table = $request_service_model->getTable();

        $result = $rent_car_model->get([
            $rent_car_table.'.*',
            $rent_car_table . '.id AS rId',
            $request_service_table.'.*',
            $request_service_table . '.id AS sId',
        ] ,true)
            ->join($request_service_table, 'module_id', 'id')
            ->where($request_service_table . '.module_title' , 'rentCar')
            ->where($request_service_table . '.deleted_at', null, 'IS')
            ->orderBy('rId' , 'DESC')->all(false);
        return $result;
    }
    public function listCity ($id = null) {
        $Model = Load::library('Model');
        if ($id) {
            $sql = " SELECT * FROM reservation_city_tb WHERE id='{$id}' AND is_del='no' ORDER BY id ASC";
        }
        $city = $Model->select($sql);

        $items = null;
        foreach ($city as $val) {
            $items[] = [ 'id' => $val['id'], 'name' => $val['name'], 'name_en' => $val['name_en']];
        }
        return $items;
    }
    public function getRentCarReserve($id) {
        $rent_car_model = $this->getModel('bookRentCarModel');
        $rent_car_table = $rent_car_model->getTable();
        $request_service_model = $this->getModel('requestServiceModel');
        $request_service_table = $request_service_model->getTable();
        $request_record = $request_service_model->get()
            ->where('module_id', $id)
            ->where('module_title', 'rentCar')
            ->find();
        if ($request_record['status'] == 'not_seen'){
            $dataUpdate = [
                'status' => 'seen',
                'updated_seen_admin_at' => date('Y-m-d H:i:s', time()),
            ];
            $request_service_model->updateWithBind($dataUpdate, ['id' => $request_record['id']]);
        }
        $rent_car = $rent_car_model->get([
            $rent_car_table.'.*',
            $rent_car_table . '.id AS rId',
            $request_service_table.'.*',
            $request_service_table . '.id AS sId',
        ] ,true)
            ->join($request_service_table, 'module_id', 'id')
            ->where($rent_car_table . '.id' , $id)
            ->where($request_service_table . '.module_title' , 'rentCar')
            ->find(false);
        $rent_car['rent_place_name'] = $this->mainCity->fetchCityRecord($rent_car['rent_place'])[0]['name'];
        $rent_car['delivery_place_name'] = $this->mainCity->fetchCityRecord($rent_car['delivery_place'])[0]['name'];
        return $rent_car;
    }


    public function updateAdminResponse($params) {

        $order_services_model = $this->getModel('requestServiceModel');
        $order_request = $order_services_model->get()
            ->where('id', $params['request_id'])
            ->find();
        $dataUpdate = [
            'admin_response'  => $params['admin_response'],
            'status'  => $params['status_id'],
            'admin_id'  => CLIENT_ID,
            'updated_at'    => date('Y-m-d H:i:s', time()),
        ];
        $update = $order_services_model->updateWithBind($dataUpdate, ['id' => $order_request['id']]);
        if ($update) {
            return self::returnJson(true, functions::Xmlinformation('AdminResponseSuccessfullySystem')->__toString());
        }
        return self::returnJson(false, functions::Xmlinformation('Errorrecordinginformation')->__toString(), null, 500);
    }


    public function deleteReserveRentCar($params) {

        $result = $this->getModel('bookRentCarModel')->softDelete([
            'id' => $params['id']
        ]);
        $this->getModel('requestServiceModel')->softDelete("module_id='{$params['id']}' AND module_title='rentCar' ");


        if ($result) {
            return functions::JsonSuccess($result, 'درخواست  خودرو حذف شد');
        }
        return functions::JsonError($result, 'خطا در حذف', 200);
    }

    public function rentCarTracking($trackingCode) {

        $rent_car_model = $this->getModel('bookRentCarModel');
        $rent_car_table = $rent_car_model->getTable();
        $request_model = $this->getModel('requestServiceModel');
        $request_table = $request_model->getTable();
        $sql = $rent_car_model->get([
            $rent_car_table.'.*',
            $rent_car_table . '.id AS rId',
            $request_table.'.*',
            $request_table . '.id AS sId',
        ] ,true)
            ->join($request_table, 'module_id', 'id')
            ->where($request_table . '.tracking_code' , $trackingCode)
            ->where($request_table . '.module_title' , 'rentCar')
            ->find(false);

        if (!empty($sql)) {
            if (isset($sql['rent_place']) && !empty($sql['rent_place'])) {
                $sql['province_title'] = $this->listCity($sql['rent_place'])[0]['name'];
            }
            if (isset($sql['delivery_place']) && !empty($sql['delivery_place'])) {
                $sql['province_title_delivery'] = $this->listCity($sql['delivery_place'])[0]['name'];
            }

            $info_car = $this->getRentCar($sql['carId']);

            $status_result = $this->getModel('requestServiceStatusModel')
                ->get()
                ->where('value' , $sql['status'])
                ->find();
            $sql['status_title'] = $status_result['title'];

            $result = '';
            $result .= '
            <div class="">
            <table class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>'.functions::Xmlinformation('Name')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Count')->__toString().'</th>
                    <th>'.functions::Xmlinformation('rentDate')->__toString().'</th>
                    <th>'.functions::Xmlinformation('rentPlace')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Deliverydate')->__toString().'</th>
                    <th>'.functions::Xmlinformation('recivePlace')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Email')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Phonenumber')->__toString().'</th>

                </tr>
                </thead>
                <tbody>
            ';
            $result .= '<tr>';
            $result .= '<td>'.$sql['name'].'</td>';
            $result .= '<td>'.$sql['count_people'].'</td>';
            $result .= '<td>'.$sql['rent_date'].'</td>';
            $result .= '<td>'.$sql['province_title'].'</td>';
            $result .= '<td>'.$sql['delivery_date'].'</td>';
            $result .= '<td>'.$sql['province_title_delivery'].'</td>';
            $result .= '<td>'.$sql['email'].'</td>';
            $result .= '<td>'.$sql['mobile'].'</td>';
            $result .= '</tr>';
            $result .= '</table>';
            $result .= '<br>';
            $result .= '<hr>';
            $result .= '<div class=""> <h2  style="margin: 10px 7px 14px 0;  font-size: 20px;  font-weight: bold;">مشخصات خودرو</h2></div>';
            $result .= ' <table class="display" cellspacing="0" width="100%">';
            $result .= '<thead>
                           <tr>
                    <th>'.functions::Xmlinformation('Namecar')->__toString().'</th>
                    <th>'.functions::Xmlinformation('CodeCar')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Price')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Showinformation')->__toString().'</th>
                
                </tr>
               </thead>';
            $result .= '<tr>';
            $result .= '<td>'.$info_car['title'] .'</td>';
            $result .= '<td>'.$info_car['code'] .'</td>';
            $result .= '<td>'.$info_car['price_customer'] .'</td>';
            $result .= '<td><a class="btn btn-primary" target="_blank" href="' . ROOT_ADDRESS_WITHOUT_LANG . '/reserveCar/' . $info_car['id'] . '" >'.functions::Xmlinformation('LinkCar')->__toString() .'</a></td>';
            $result .= '</tr>';
            $result .= '</table>';
            $result .= '</div>';
            $result .= '<br>';
            $result .= '<div class="parent-file">';
            if ($sql['tracking_code']) {
                $result .= '<div>';
                $result .= ''.functions::Xmlinformation('TrackingCode')->__toString().' :  ';
                $result .= ''.$sql['tracking_code'].'';
                $result .= '</div>';
            }
            if ($sql['file']) {
                $result .= '<div>';
                $result .= ''.functions::Xmlinformation('YourSentFile')->__toString().' :  ';
                $result .= '<a href="'.$sql['file'].'" target="_blank" class="btn btn-primary margin-10">'.functions::Xmlinformation('Passport')->__toString().'</a> ';
                $result .= '<a href="'.$sql['pic'].'" target="_blank" class="btn btn-primary margin-10">'.functions::Xmlinformation('Image')->__toString().'</a> ';
                $result .= '</div>';
            }
            if ($sql['status'] == 'not_seen') {
                $result .= "<p class='text-order bg-warning' style='margin: 20px;padding: 15px;' >".functions::Xmlinformation('AdminHasNotseen')->__toString()."</p>";
            }elseif ($sql['status'] == 'seen') {
                $result .= "<p class='text-order bg-success' style='margin: 20px;padding: 15px;' >".functions::Xmlinformation('AdminHasSeen')->__toString()."</p>";
            }elseif ($sql['status'] == 'accept') {
                $result .= "<p class='text-order bg-success' style='margin: 20px;padding: 15px;' >".functions::Xmlinformation('AcceptUserRequest')->__toString()."</p>";
            }elseif ($sql['status'] == 'reject') {
                $result .= "<p class='text-order bg-danger' style='margin: 20px;padding: 15px;' >".functions::Xmlinformation('RejectUserRequest')->__toString()."</p>";
            }
            $result .= '</div>';
            $result .= '<div class="parent-btn-order">';
            if ($sql['admin_response'] != ''){
                $result .= '<p class=" ml-2" style=\'margin: 20px;\' >'.functions::Xmlinformation('AdminResponseToYourRequest')->__toString().' :</p>';
                $result .= '<p class="font-18" style=\'margin: 20px;\' >' . $sql['admin_response'] . '</p>';
            }
            $result .= '</div>';
            $result .= '';
            return $result;

        }
    }

}