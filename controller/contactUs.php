<?php
//if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}
class contactUs extends clientAuth
{
    public function __construct()
    {
        parent::__construct();
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
    public function insertContactInfo($info)
    {

        $arg = array(
            'name' => FILTER_SANITIZE_STRING,
            'message' => FILTER_SANITIZE_STRING,
            'phone' => FILTER_SANITIZE_NUMBER_INT,
            'email' => FILTER_VALIDATE_EMAIL,
        );
        $dataPost = filter_var_array($info, $arg);
        $counter = 0;
        $tmp = mt_rand(1, 15);
        do {
            $tmp .= mt_rand(0, 15);
        } while (++$counter < 16);
        $uniq = $tmp;
        $random_code = substr($uniq, 0, 10);
        $member_id = Session::getUserId();
        $agency_id = SUB_AGENCY_ID;
        if (isset($info['type']) && $info['type'] == 'feedback') {
            $data['type'] = 'feedback';
        }else if (isset($info['type']) && $info['type'] == 'lastminute') {
            $data['type'] = 'lastminute';
        }
        else{
            $data['type'] = 'contactUs';
        }

        $data['name'] = $dataPost['name'];
        $data['mobile'] = $dataPost['phone'];
        $data['email'] = $dataPost['email'];
        $data['comment'] = $dataPost['message'];
        $data['language'] = SOFTWARE_LANG;
        $data['agency_id'] = $agency_id;
        $data['created_at'] = date('Y-m-d H:i:s', time());
        $data['member_id'] = ($member_id) ? $member_id : '0';
        /** @var contactUsModel $contactUs */
        $contactUs = Load::getModel('contactUsModel');
        $data = $contactUs->insertContact($data);
        $last_id = $contactUs->getLastId();
        $data_request = [
            'user_id' => $member_id,
            'module_id' => $last_id,
            'module_title' => 'contactUs',
            'tracking_code' => $random_code,
        ];
        $temp_model = Load::getModel('requestServiceModel');
        $temp_model->insertWithBind($data_request);
//        if ($data == true) {
//            return 'success : ' . functions::Xmlinformation('ApplicationSuccessfullyRegistered');
//        } else {
//            return 'error: ' . functions::Xmlinformation('ErrorSubmittingRequest');
//        }
        $msg = functions::Xmlinformation('InsertingDataIsSuccessfull') ."<br>". functions::Xmlinformation('YourTrackingCode') .$random_code;
//        var_dump($msg);
        if ($data == true) {

        return self::returnJson(true, $msg);
        } else {
            return self::returnJson(false, functions::Xmlinformation('Errorrecordinginformation'), null, 500);
        }




    }


    public function GetData($type = null)
    {

        $contact_us_model = $this->getModel('contactUsModel');
        $contact_table = $contact_us_model->getTable();
        $request_service_model = $this->getModel('requestServiceModel');
        $request_service_table = $request_service_model->getTable();
        $contactUs = $contact_us_model->get([
            $contact_table.'.*', $contact_table.'.language as lang',
            $contact_table . '.id AS cId',
            $request_service_table.'.*',
            $request_service_table . '.id AS sId',
        ] ,true)
            ->join($request_service_table, 'module_id', 'id');
            $contactUs = $contactUs->where($request_service_table . '.module_title' , contactUs);
            if ($type) {
                $contactUs = $contactUs->where($contact_table . '.type' , $type);
            } else {
                $contactUs = $contactUs->where($contact_table . '.type' , 'contactUs' );
            }
            $contactUs = $contactUs->orderBy('cId' , 'DESC')->all(false);

        return $contactUs;
    }



    public function GetContact($contactId, $json = false)
    {

        $contact_us_model = $this->getModel('contactUsModel');
        $agency_model = $this->getModel('agencyModel');

        $data = $contact_us_model->get([
            $contact_us_model->getTable() . '.*',
            $agency_model->getTable() . '.name_fa',
        ],true)
            ->join($agency_model->getTable(), 'id', 'agency_id', 'LEFT')
            ->where($contact_us_model->getTable() . '.id', $contactId)
            ->all()[0];

        if ($json)
            return json_encode($data);
        return $data;
    }

    public function GetAgencyContact()
    {
        /** @var contactUsModel $contact */
        $contact = Load::getModel('contactUsModel');
        return $contact->getAgency();
    }
    public function infoContactUs($param)
    {

        $trackingCode = $param['request_service_number'] ;
        if(isset($param['type']) && !empty($param['type'])){
            $type = $param['type'];
        }else{
            $type = 'contactUs';
        }


        $contact_us_model = $this->getModel('contactUsModel');
        $contact_table = $contact_us_model->getTable();
        $request_service_model = $this->getModel('requestServiceModel');
        $request_service_table = $request_service_model->getTable();
        $contactUs = $contact_us_model->get([
            $contact_table.'.*',
            $contact_table . '.id AS cId',
            $request_service_table.'.*',
            $request_service_table . '.id AS sId',
        ] ,true)
            ->join($request_service_table, 'module_id', 'id')
            ->where($request_service_table . '.tracking_code' , $trackingCode)
            ->where($request_service_table . '.module_title' , contactUs)
            ->where($contact_table . '.type' , $type)
            ->find(false);

        if (!empty($contactUs)) {
            $result = '';
            $result .= '
            <div class="container">
            <table class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>'.functions::Xmlinformation('Namefamily')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Phonenumber')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Email')->__toString().'</th>
                    <th>'.functions::Xmlinformation('contactMessage')->__toString().'</th>
                
                </tr>
                </thead>
                <tbody>
            ';
            $result .= '<tr>';
            $result .= '<td>'.$contactUs['name'].'</td>';
            $result .= '<td>'.$contactUs['mobile'].'</td>';
            $result .= '<td>'.$contactUs['email'].'</td>';
            $result .= '<td>'.$contactUs['comment'].'</td>';
            $result .= '</tr>';
            $result .= '</table>';
            $result .= '</div>';
            $result .= '<hr>';
            $result .= '<div class="container">';
            $result .= '</div>';
            $result .= '<br>';
            $result .= '<br>';


            if ($contactUs['status'] == 'not_seen') {
                $result .= "<p class='text-order bg-warning' style='margin: 20px;padding: 15px;' >".functions::Xmlinformation('AdminHasNotseen')->__toString()."</p>";
            }elseif ($contactUs['status'] == 'seen') {
                $result .= "<p class='text-order bg-success' style='margin: 20px;padding: 15px;' >".functions::Xmlinformation('AdminHasSeen')->__toString()."</p>";
            }elseif ($contactUs['status'] == 'accept') {
                $result .= "<p class='text-order bg-success' style='margin: 20px;padding: 15px;' >".functions::Xmlinformation('AcceptUserRequest')->__toString()."</p>";
            }elseif ($contactUs['status'] == 'reject') {
                $result .= "<p class='text-order bg-danger' style='margin: 20px;padding: 15px;' >".functions::Xmlinformation('RejectUserRequest')->__toString()."</p>";
            }
    $result .= '<hr>';
    if ($contactUs['admin_response'] != ''){
        $result .= '<p class=" ml-2" style=\'margin: 20px;\' >'.functions::Xmlinformation('AdminResponseToYourRequest')->__toString().' :</p>';
        $result .= '<p class="font-20" style=\'margin: 20px;\' >' . $contactUs['admin_response'] . '</p>';
    }
    $result .= '<br>';
    $result .= '<br>';
            $result .= '';
            return $result;

        }

    }


    public function getContactUs($id) {

        $contact_us_model = $this->getModel('contactUsModel');
        $contact_us_table = $contact_us_model->getTable();
        $request_service_model = $this->getModel('requestServiceModel');
        $request_service_table = $request_service_model->getTable();
        $request_record = $request_service_model->get()
            ->where('module_id', $id)
            ->where('module_title', contactUs)
            ->find();
        if ($request_record['status'] == 'not_seen'){
            $dataUpdate = [
                'status' => 'seen',
                'updated_seen_admin_at' => date('Y-m-d H:i:s', time()),
            ];
            $request_service_model->updateWithBind($dataUpdate, ['id' => $request_record['id']]);
        }

        $contactUs = $contact_us_model->get([
            $contact_us_table.'.*',$contact_us_table.'.language as lang',
            $contact_us_table . '.id AS eId',
            $request_service_table.'.*',
            $request_service_table . '.id AS sId',
        ] ,true)
            ->join($request_service_table, 'module_id', 'id')
            ->where($contact_us_table . '.id' , $id)
            ->find(false);
        return($contactUs);

    }

    public function updateContactUs($params) {

        $request_service_model = $this->getModel('requestServiceModel');

        $request_service = $request_service_model->get()
            ->where('id', $params['contact_id'])
            ->find();

        $dataUpdate = [
            'admin_response'  => $params['admin_response'],
            'status'  => $params['status_id'],
            'admin_id'  => CLIENT_ID,
            'updated_at'    => date('Y-m-d H:i:s', time()),
        ];

        $update = $request_service_model->updateWithBind($dataUpdate, ['id' => $request_service['id']]);


        if ($update) {

            return self::returnJson(true, 'درخواست با موفقیت در سیستم بروزرسانی شد');
        }

        return self::returnJson(false, 'خطا در ثبت اطلاعات در سیستم.', null, 500);
    }





}