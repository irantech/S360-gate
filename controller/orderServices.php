<?php

class orderServices extends clientAuth {
    /**
     * @var string
     */
    protected $table = 'order_services_tb';
    protected $table_request = 'request_service_tb';
    private $orderServicesTb,$page_limit,$requestServiceTb;
    /**
     * @var string
     */
    private $photoUrl;
    public function __construct() {
        parent::__construct();
        $this->page_limit = 6;
        $this->orderServicesTb = 'order_services_tb';
        $this->requestServiceTb = 'request_service_tb';
        $this->photoUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/';
    }

    public function addOrderServicesIndexes(array $orderList) {
        $result = [];

        foreach ($orderList as $key => $list) {
            $result[$key] = $list;
            $time_date = functions::ConvertToDateJalaliInt($list['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['file_order'] = $this->photoUrl . 'orderServices/' . CLIENT_ID . '/'. $list['file'];
            $country = $this->getModel('countryCodesModel')
                ->get()
                ->where('id' , $list['country'])
                ->find();
            $result[$key]['country_name'] = $country['titleFa'];


            $kind_order = $this->getModel('orderServicesKindModel')
                ->get()
                ->where('id' , $list['kind_service'])
                ->find();
            $result[$key]['kind_title'] = $kind_order['titleFa'];
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
    /**
     * @return application|mixed
     */
    public function application() {
        return Load::Config( 'application' );
    }

    private function uploadPic($name_file ) {
        $application = $this->application() ;
        $application->pathFile('orderServices/' . CLIENT_ID . '/');
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
    public function orderServicesModel() {
        return Load::getModel( 'orderServicesModel' );
    }
    public function insertOrderServicesArray($orderServices) {

       $status_upload = true;
       $data = $orderServices;
        $count = 0;
        $tmp = mt_rand(1, 15);
        do {
            $tmp .= mt_rand(0, 15);
        } while (++$count < 16);
        $uniq = $tmp;
        $trackingCode = substr($uniq, 0, 10);

        $data['file'] = $this->uploadPic('file');
        $status_upload = !empty($data['file']) ? true : false;
        $result = $this->orderServicesModel()->insertWithBind( $data );

        $data_request = [
          'module_id' => $result,
          'module_title' => 'orderServices',
          'tracking_code' => $trackingCode,
        ];
        $request_model = Load::getModel('requestServiceModel');
        $request_model->insertWithBind($data_request);
        if ( $result ) {
            return functions::Xmlinformation('InsertingDataIsSuccessfull') ."<br>". functions::Xmlinformation('YourTrackingCode') .$trackingCode;
        } else {
            return functions::Xmlinformation('Errorrecordinginformation');
        }
    }
    public function listOrderServices()
    {
        $order_services_model = $this->getModel('orderServicesModel');
        $order_services_table = $order_services_model->getTable();
        $request_service_model = $this->getModel('requestServiceModel');
        $request_service_table = $request_service_model->getTable();

        $result = $order_services_model->get([
            $order_services_table.'.*',
            $order_services_table . '.id AS oId',
            $request_service_table.'.*',
            $request_service_table . '.id AS sId',
        ] ,true)
            ->join($request_service_table, 'module_id', 'id')
            ->where($request_service_table . '.module_title' , orderServices)->orderBy('oId' , 'DESC')->all(false);
        return $this->addOrderServicesIndexes($result);
    }

    public function getOrderServices($id) {

        $order_services_model = $this->getModel('orderServicesModel');
        $order_services_table = $order_services_model->getTable();
        $request_service_model = $this->getModel('requestServiceModel');
        $request_service_table = $request_service_model->getTable();
        $request_record = $request_service_model->get()
            ->where('module_id', $id)
            ->where('module_title', orderServices)
            ->find();
        if ($request_record['status'] == 'not_seen'){
            $dataUpdate = [
                'status' => 'seen',
                'updated_seen_admin_at' => date('Y-m-d H:i:s', time()),
            ];
            $request_service_model->updateWithBind($dataUpdate, ['id' => $request_record['id']]);
        }

        $orderServices = $order_services_model->get([
            $order_services_table.'.*',
            $order_services_table . '.id AS oId',
            $request_service_table.'.*',
            $request_service_table . '.id AS sId',
        ] ,true)
            ->join($request_service_table, 'module_id', 'id')
            ->where($order_services_table . '.id' , $id)
            ->where($request_service_table . '.module_title' , orderServices)
            ->find(false);

        return $this->addOrderServicesIndexes([$orderServices])[0];
    }
    public function findOrderServicesById($id) {
        return $this->getModel('orderServicesModel')->get()->where('id' , $id)->find();
    }
    public function updateOrderServices($params) {

        $order_services_model = $this->getModel('requestServiceModel');
        $order_request = $order_services_model->get()
        ->where('id', $params['order_services_id'])
            ->find();
        $dataUpdate = [
            'admin_response'  => $params['admin_response'],
            'status'  => $params['status_id'],
            'admin_id'  => CLIENT_ID,
            'updated_at'    => date('Y-m-d H:i:s', time()),
        ];
        $update = $order_services_model->updateWithBind($dataUpdate, ['id' => $order_request['id']]);
        if ($update) {
            return self::returnJson(true, 'درخواست با موفقیت در سیستم بروزرسانی شد');
        }
        return self::returnJson(false, 'خطا در ثبت اطلاعات در سیستم.', null, 500);
    }


    public function deleteOrderServices($data) {
        $check_exist_order_services = $this->findOrderServicesById($data['id']);
        if ($check_exist_order_services) {
            $this->getModel('requestServiceModel')->delete("module_id='{$data['id']}' AND module_title='orderServices' ");
            $result_delete = $this->getModel('orderServicesModel')->delete("id='{$data['id']}'");
            if ($result_delete) {

                return functions::withSuccess('', 200, 'حذف با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در حذف');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }

    public function infoOrderServicesTracking($trackingCode) {
        $order_model = $this->getModel('orderServicesModel');
        $order_table = $order_model->getTable();
        $request_model = $this->getModel('requestServiceModel');
        $request_table = $request_model->getTable();
        $sql = $order_model->get([
            $order_table.'.*',
            $order_table . '.id AS oId',
            $request_table.'.*',
            $request_table . '.id AS sId',
        ] ,true)
            ->join($request_table, 'module_id', 'id')
            ->where($request_table . '.tracking_code' , $trackingCode)
            ->where($request_table . '.module_title' , orderServices)
            ->find(false);

        if (!empty($sql)) {
            $sql['file_service'] = $this->photoUrl . 'orderServices/' . CLIENT_ID . '/'. $sql['file'];

            $country = $this->getModel('countryCodesModel')
                ->get()
                ->where('id' , $sql['country'])
                ->find();
            $sql['country_name'] = $country['titleFa'];

            $kind_order = $this->getModel('orderServicesKindModel')
                ->get()
                ->where('id' , $sql['kind_service'])
                ->find();
            $sql['kind_title'] = $kind_order['titleFa'];
            $result = '';
            $result .= '
            <div class="">
            <table class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>'.functions::Xmlinformation('Namefamily')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Age')->__toString().'</th>
                    <th>'.functions::Xmlinformation('NumberRequests')->__toString().'</th>
                    <th>'.functions::Xmlinformation('YourMobileNumber')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Email')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Address')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Country')->__toString().'</th>
                    <th>'.functions::Xmlinformation('RequestedService')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Description')->__toString().'</th>
                    <th>'.functions::Xmlinformation('DateStart')->__toString().'</th>
                    <th>'.functions::Xmlinformation('DateEnd')->__toString().'</th>
                
                </tr>
                </thead>
                <tbody>
            ';
            $result .= '<tr>';
            $result .= '<td>'.$sql['name'].'</td>';
            $result .= '<td>'.$sql['age'].'</td>';
            $result .= '<td>'.$sql['number_requests'].'</td>';
            $result .= '<td>'.$sql['mobile'].'</td>';
            $result .= '<td>'.$sql['email'].'</td>';
            $result .= '<td>'.$sql['address'].'</td>';
            $result .= '<td>'.$sql['country_name'].'</td>';
            $result .= '<td>'.$sql['kind_title'].'</td>';
            $result .= '<td>'.$sql['comment'].'</td>';
            $result .= '<td>'.$sql['date_start'].'</td>';
            $result .= '<td>'.$sql['date_end'].'</td>';
            $result .= '</tr>';
            $result .= '</table>';
            $result .= '</div>';
            $result .= '<div class="parent-file">';
            if ($sql['tracking_code']) {
                $result .= '<div>';
                $result .= ''.functions::Xmlinformation('TrackingCode')->__toString().'  :  ';
                $result .= ''.$sql['tracking_code'].'';
                $result .= '</div>';
            }
            if ($sql['file']) {
                $result .= '<div>';
                $result .= ''.functions::Xmlinformation('YourSentFile')->__toString().' :  ';
                $result .= '<a href="'.$sql['file_service'].'" target="_blank" class="btn btn-primary margin-10">مشاهده فایل</a> ';
                $result .= '</div>';
            }

            if ($sql['status'] == 'not_seen') {
                $result .= "<p class='text-order bg-warning' >".functions::Xmlinformation('AdminHasNotseen')->__toString()."</p>";
            }elseif ($sql['status'] == 'seen') {
                $result .= "<p class='text-order bg-success' >".functions::Xmlinformation('AdminHasSeen')->__toString()."</p>";
            }elseif ($sql['status'] == 'accept') {
                $result .= "<p class='text-order bg-success' >".functions::Xmlinformation('AcceptUserRequest')->__toString()."</p>";
            }elseif ($sql['status'] == 'reject') {
                $result .= "<p class='text-order bg-danger' >".functions::Xmlinformation('RejectUserRequest')->__toString()."</p>";
            }
            $result .= '</div>';
            $result .= '<div class="parent-btn-order">';
            if ($sql['admin_response'] != ''){
                $result .= '<p class=" ml-2">'.functions::Xmlinformation('AdminResponseToYourRequest')->__toString().' :</p>';
                $result .= '<p class="font-18">' . $sql['admin_response'] . '</p>';
            }
            $result .= '</div>';
            $result .= '';
            return $result;

        }
    }

}