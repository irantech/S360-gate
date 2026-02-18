<?php
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

class representatives extends clientAuth {

    /**
     * @var string
     */
    protected $table = 'representatives_tb';
    protected $table_request = 'request_service_tb';
    private $representativesTb,$page_limit,$requestServiceTb;
    /**
     * @var string
     */
    private $photoUrl;
    public function __construct() {
        parent::__construct();
        $this->page_limit = 6;
        $this->representativesTb = 'representatives_tb';
        $this->requestServiceTb = 'request_service_tb';
        $this->photoUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/';
    }

    public function change_order($params){

        if (isset($params['data'])) {
            foreach ($params['data'] as $k => $v) {
                $representatives_model = $this->getModel('representativesModel');
                $dataUpdate = [
                    'order_p' => $v
                ];
                $check = $representatives_model->updateWithBind($dataUpdate, ['id' => $k]);
            }
            return self::returnJson(true, 'درخواست شما با موفقیت انجام شد');
        }else {
            return self::returnJson(true, 'هیچ موردی انتخاب نشده یا تغییری اعمال نشده است');
        }
    }

    public function addRepresentativesIndexes(array $orderList) {
        $result = [];
        foreach ($orderList as $key => $list) {
            $result[$key] = $list;
            $time_date = functions::ConvertToDateJalaliInt($list['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['image'] = $this->photoUrl . 'representatives/' . CLIENT_ID . '/'. $list['image'];
        }

        return $result;
    }
    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        return json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    }
    //region [application]
    /**
     * @return application|mixed
     */
    public function application() {
        return Load::Config( 'application' );
    }
    //endregion
    private function uploadPic($name_file ) {
        $application = $this->application() ;
        $application->pathFile('representatives/' . CLIENT_ID . '/');

        $ext = explode(".", $_FILES[$name_file][name]);
        $_FILES[$name_file][name] = date("sB")."-" . rand(10, 10000);
        $ext = strtolower($ext[count($ext)-1]);
        $_FILES[$name_file][name] = $_FILES['pic'][name].".".$ext;
        if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
            $type = 'pic';
        } else{
            $type = 'file';
        }

        $success = $application->UploadFile("pic", $name_file, "");
        $explode_name_pic = explode(':', $success);
        if ($explode_name_pic[0] == 'done') {
            $info_file = $explode_name_pic[1];
        } else {
            $info_file = '';
        }
        return $info_file;
    }
    private function uploadPicNew($name_file ) {
        $application = $this->application() ;
        $application->pathFile('representatives/' . CLIENT_ID . '/');



        $ext = explode(".", $_FILES[$name_file][name]);
        $_FILES[$name_file][name] = date("sB")."-" . rand(10, 10000);
        $ext = strtolower($ext[count($ext)-1]);
        $_FILES[$name_file][name] = $_FILES['pic'][name].".".$ext;
        if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
            $type = 'pic';
        } else{
            $type = 'file';
        }


        $success = $application->UploadFile($type, $name_file, "");
        $explode_name_pic = explode(':', $success);
        if ($explode_name_pic[0] == 'done') {
            $info_file = $explode_name_pic[1];
        } else {
            $info_file = '';
        }
        return $info_file;
    }
    public function representativesModel() {
        return Load::getModel( 'representativesModel' );
    }
    public function insertRepresentativesArray($representatives) {

       $status_upload = true;
       $data = $representatives;
        $count = 0;
        $tmp = mt_rand(1, 15);
        do {
            $tmp .= mt_rand(0, 15);
        } while (++$count < 16);
        $uniq = $tmp;
        $trackingCode = substr($uniq, 0, 10);


        $data['image'] = $this->uploadPic('image');
        $status_upload = !empty($data['image']) ? true : false;

        if ($status_upload) {
            $result = $this->representativesModel()->insertWithBind( $data );
        } else {
            return functions::withError($status_upload, 400, "خطا : خطا در آپلود فایل");
        }

        if (Session::adminIsLogin()) {
            $status = 'accept';
        }else {
            $status = 'not_seen';
        }

        $data_request = [
          'status' => $status,
          'language' => $representatives['language'],
          'module_id' => $result,
          'module_title' => 'representatives',
          'tracking_code' => $trackingCode,
        ];
        $request_model = Load::getModel('requestServiceModel');
        $request_model->insertWithBind($data_request);
        if ( $result ) {
            return functions::withSuccess('', 200, " ".functions::Xmlinformation('YourRequestHasBeenSuccessfullyRegistered')." <br> ".functions::Xmlinformation('TrackingCode')." $trackingCode   ");

        } else {
            return functions::withError('', 400, functions::Xmlinformation('YourRequestHasBeenSuccessfullyRegistered'));
        }


    }
    public function listRepresentatives($type = 'admin')
    {

        $representatives_model = $this->getModel('representativesModel');
        $representatives_table = $representatives_model->getTable();
        $request_service_model = $this->getModel('requestServiceModel');
        $request_service_table = $request_service_model->getTable();

        $result = $representatives_model->get([
            $representatives_table.'.*',
            $representatives_table . '.id AS oId',
            $representatives_table . '.order_p AS order_main',
            $request_service_table.'.*',
            $request_service_table . '.id AS sId',
            $request_service_table . '.status AS rss',
        ] ,true)
            ->join($request_service_table, 'module_id', 'id')
            ->where($request_service_table . '.module_title' , 'representatives');
        if ($type == 'client') {
            $result = $result->where($request_service_table . '.status' , 'accept')->where($request_service_table . '.language' , SOFTWARE_LANG);
            $result = $result->orderBy('order_main' , 'DESC')->all(false);
        } else if($type == 'admin') {
            $result = $result->orderBy('oId' , 'DESC')->all(false);
        }
        return $this->addRepresentativesIndexes($result);
    }

    public function infoRepresentatives($trackingCode)
    {

        $representatives_model = $this->getModel('representativesModel');
        $representatives_table = $representatives_model->getTable();
        $request_service_model = $this->getModel('requestServiceModel');
        $request_service_table = $request_service_model->getTable();

        $representatives = $representatives_model->get([
            $representatives_table.'.*',
            $representatives_table . '.id AS rId',
            $request_service_table.'.*',
            $request_service_table . '.id AS sId',
        ] ,true)
            ->join($request_service_table, 'module_id', 'id')
            ->where($request_service_table . '.tracking_code' , $trackingCode)
            ->where($request_service_table . '.module_title' , representatives)
            ->find(false);
        if (!empty($representatives)) {

            if (isset($representatives['country']) && !empty($representatives['country'])) {
                $representatives['country'] = $this->RepresentativesCountries($representatives['country'])[0]['name'];
            }


            if (isset($representatives['province']) && !empty($representatives['province'])) {
                $representatives['province'] = $this->RepresentativesCity($representatives['province'])[0]['name'];
            } else {
                $representatives['province'] = '-';
            }




            $result = '';
            $result .= '
            <div >
            <table class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>'.functions::Xmlinformation('managerName')->__toString().'</th>
                    <th>'.functions::Xmlinformation('YourMobileNumber')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Callphone')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Email')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Country')->__toString().'</th>
                    <th>'.functions::Xmlinformation('State')->__toString().'</th>
                </tr>
                </thead>
                <tbody>
            ';
            $result .= '<tr>';
            $result .= '<td>'.$representatives['manager_name'].'</td>';
            $result .= '<td>'.$representatives['mobile_number'].'</td>';
            $result .= '<td>'.$representatives['phone_number'].'</td>';
            $result .= '<td>'.$representatives['email'].'</td>';
            $result .= '<td>'.$representatives['country'].'</td>';
            $result .= '<td>'.$representatives['province'].'</td>';
            $result .= '</tr>';
            $result .= '</table>';
            $result .= '</div>';
            $result .= '<hr>';
            $result .= '<div class="container">';
            $result .= '</div>';
            $result .= '<br>';
            $result .= '<br>';
            $result .= '<br>';
            $result .= '<br>';


            if ($representatives['status'] == 'not_seen') {
                $result .= '<p class="btn btn-warning" style="margin: 10px 0 10px 0">'.functions::Xmlinformation('AdminHasNotseen')->__toString().'</p>';
            }elseif ($representatives['status'] == 'seen') {
                $result .= '<p class="btn btn-primary" style="margin: 10px 0 10px 0">'.functions::Xmlinformation('AdminHasSeen')->__toString().'</p>';
            }elseif ($representatives['status'] == 'accept') {
                $result .= '<p class="btn btn-success" style="margin: 10px 0 10px 0">'.functions::Xmlinformation('AcceptUserRequest')->__toString().'</p>';
            }elseif ($representatives['status'] == 'reject') {
                $result .= '<p class="btn btn-danger" style="margin: 10px 0 10px 0">'.functions::Xmlinformation('RejectUserRequest')->__toString().'</p>';
            }
            $result .= '<hr>';
            if ($representatives['admin_response'] != ''){
                $result .= '<p class="btn btn-primary">'.functions::Xmlinformation('AdminResponseToYourRequest')->__toString().' :</p>';
                $result .= '<p class="font-20">' . $representatives['admin_response'] . '</p>';
            }
            $result .= '<br>';
            $result .= '<br>';            $result .= '';
            return $result;
        }

    }

    public function getRepresentatives($id) {

        $representatives_model = $this->getModel('representativesModel');
        $representatives_table = $representatives_model->getTable();
        $request_service_model = $this->getModel('requestServiceModel');
        $request_service_table = $request_service_model->getTable();
        $request_record = $request_service_model->get()
            ->where('module_id', $id)
            ->where('module_title', 'representatives')
            ->find();
        if ($request_record['status'] == 'not_seen'){
            $dataUpdate = [
                'status' => 'seen',
                'updated_seen_admin_at' => date('Y-m-d H:i:s', time()),
            ];
            $request_service_model->updateWithBind($dataUpdate, ['id' => $request_record['id']]);
        }

        $representatives = $representatives_model->get([
            $representatives_table.'.*',
            $representatives_table . '.id AS oId',
            $representatives_table . '.language AS oLang',
            $request_service_table.'.*',
            $request_service_table . '.id AS sId',
        ] ,true)
            ->join($request_service_table, 'module_id', 'id')
            ->where($representatives_table . '.id' , $id)
            ->where($request_service_table . '.module_title' , 'representatives')
            ->find(false);
//var_dump($this->addRepresentativesIndexes([$representatives])[0]);
//die;
        return $this->addRepresentativesIndexes([$representatives])[0];
    }
    public function findRepresentativesById($id) {
        return $this->getModel('representativesModel')->get()->where('id' , $id)->find();
    }
    public function updateRepresentatives($params) {
        $requestService_model = $this->getModel('requestServiceModel');
        $order_request = $requestService_model->get()
        ->where('id', $params['request_id'])
            ->find();
        $dataUpdate = [
            'admin_response'  => $params['admin_response'],
            'status'  => $params['status_id'],
            'language'  => $params['language'],
            'admin_id'  => CLIENT_ID,
            'updated_at'    => date('Y-m-d H:i:s', time()),
        ];
        $update_request_service = $requestService_model->updateWithBind($dataUpdate, ['id' => $order_request['id']]);



        $dataUpdateFile =[];
        if ( isset($_FILES['image']['name'])) {
            $result_upload = self::uploadPic('image');
            $dataUpdateFile = [
                'image' => $result_upload,
            ];

        }


        $dataUpdate = [
            'language'      => $params['language'],
            'manager_name'      => $params['manager_name'],
            'company_name'      => $params['company_name'],
            'english_company_name'       => $params['english_company_name'],
            'phone_number'    => $params['phone_number'],
            'mobile_number'    => $params['mobile_number'],
            'fax_number'      => $params['fax_number'],
            'email'      => $params['email'],
            'website'      => $params['website'],
            'postal_code'      => $params['postal_code'],
            'country'      => $params['country'],
            'province'      => $params['province'],
            'city'      => $params['city'],
            'address'      => $params['address'],
            'lat_p'      => $params['lat_p'],
            'long_p'      => $params['long_p'],
            'activity_type'      => $params['activity_type'],
            'updated_at'    => date('Y-m-d H:i:s', time()),
        ];
        $result = array_merge($dataUpdate,$dataUpdateFile);
        $update = $this->representativesModel()->updateWithBind($result, ['id' => $params['representatives_id']]);

        if ($update && $update_request_service) {
            return self::returnJson(true, 'درخواست با موفقیت در سیستم بروزرسانی شد');
        }
        return self::returnJson(false, 'خطا در ثبت اطلاعات در سیستم.', null, 500);
    }

    public function selected_provinces($id = null) {
        $selected_provinces = [];
        $provinceIds = [];
        if ($id) {
            $provinces = $this->RepresentativesCities($id);
        } else {
            $provinces = $this->RepresentativesCities();
        }

        $list_agencies = $this->listRepresentatives('client');
        foreach ($list_agencies as $item) {
            if ($item['province'] && !in_array($item['province'] , $provinceIds)) {
                $provinceIds[] = $item['province'];
                foreach ($provinces as $p) {
                    if ($p['id'] == $item['province']) {
                        $selected_provinces[] = $p;
                    }
                }
            }
        }
        return $selected_provinces;
    }

    public function selected_countries() {

        $selected_countries = [];
        $countriesIds = [];
        $countries = $this->RepresentativesCountries();
        $list_agencies = $this->listRepresentatives('client');
        foreach ($list_agencies as $item) {
            if ($item['country'] && !in_array($item['country'] , $countriesIds)) {
                $countriesIds[] = $item['country'];
                foreach ($countries as $country) {
                    if ($country['id'] == $item['country']) {
                        $selected_countries[] = $country;
                    }
                }
            }
        }
        return $selected_countries;
    }


    public function deleteRepresentatives($data) {
        $check_exist_representatives = $this->findRepresentativesById($data['id']);
        if ($check_exist_representatives) {
            $this->getModel('requestServiceModel')->delete("module_id='{$data['id']}' AND module_title='representatives' ");
//            $result_delete = $this->getModel('representativesModel')->delete("id='{$data['id']}'");
            $result_delete = $this->getModel('representativesModel')->softDelete([
                'id' => $data['id']
            ]);
            if ($result_delete) {

                return functions::withSuccess('', 200, 'حذف با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در حذف');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }



    public function RepresentativesCountries($id = null) {
        $Model = Load::library('Model');

        $sql = " SELECT c.*
                    FROM reservation_country_tb AS c
                    JOIN reservation_city_tb AS ct
                    ON c.id = ct.id_country
                    WHERE c.is_del = 'no'
                    AND ct.is_del = 'no'
                    GROUP BY c.id
                    ORDER BY c.id ASC;";
        if ($id) {
            $sql = " SELECT * FROM reservation_country_tb WHERE id='$id' and is_del='no' ORDER BY id ASC";
        }
        $country = $Model->select($sql);

        return $country;
    }
    public function RepresentativesCity ($id = null) {
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

    public function RepresentativesCities($id = null) {
        $Model = Load::library('Model');
        $sql = " SELECT * FROM reservation_city_tb WHERE  is_del='no' ORDER BY id ASC";
        if ($id) {
            $sql = " SELECT * FROM reservation_city_tb WHERE id_country='{$id}' AND is_del='no' ORDER BY id ASC";
        }
        $city = $Model->select($sql);

        $items = null;
        foreach ($city as $val) {
            $items[] = [ 'id' => $val['id'], 'name' => $val['name'], 'name_en' => $val['name_en']];
        }
        return $items;
    }



}