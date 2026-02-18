<?php
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
class iranVisa extends clientAuth {
    /**
     * @var string
     */
    protected $table = 'iran_visa_tb';
    private $iranVisaTb,$page_limit,$requestServiceTb ;
    /**
     * @var string
     */

    public function __construct() {
        parent::__construct();
        $this->iranVisaTb = 'iran_visa_tb';
        $this->page_limit = 6;
        $this->requestServiceTb = 'request_service_tb';
        $this->photoUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/';
    }

    public function addIranVisaIndexes(array $iranVisaList) {
        $result = [];
        foreach ($iranVisaList as $key => $list) {
            $result[$key] = $list;
            $time_date = functions::ConvertToDateJalaliInt($list['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['name_family'] = $list['name'] . ' ' . $list['family'];
            $result[$key]['gender_title'] = ($list['sex'] == 'Male') ? functions::Xmlinformation('Male')->__toString() : functions::Xmlinformation('Female')->__toString();
            $result[$key]['file'] = $this->photoUrl . 'iranVisa/' . CLIENT_ID . '/'. $list['file_passport'];
            $result[$key]['pic'] = $this->photoUrl . 'iranVisa/' . CLIENT_ID . '/'. $list['pic_user'];

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
    public function application() {
        return Load::Config( 'application' );
    }
    private function uploadPic($name_file ) {
        $application = $this->application() ;
        $application->pathFile('iranVisa/' . CLIENT_ID . '/');
        $ext = explode(".", $_FILES[$name_file]['name']);
        $_FILES[$name_file]['name'] = date("sB")."-" . rand(10, 10000);
        $ext = strtolower($ext[count($ext)-1]);
        $_FILES[$name_file]['name'] = $_FILES['pic']['name'].".".$ext;
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
    public function iranVisaModel() {
        return Load::getModel( 'iranVisaModel' );
    }
    public function insertIranVisa($data) {
        if ( $data['enter_date'] > $data['exit_date']) {
            $text_result = functions::Xmlinformation('Errorrecordinginformation')->__toString(). '<br>'. functions::Xmlinformation('ComparisonEntryExitDates')->__toString();
            return self::returnJson(false, $text_result);
        }else {


        $count = 0;
        $tmp = mt_rand(1, 15);
        do {
            $tmp .= mt_rand(0, 15);
        } while (++$count < 16);
        $uniq = $tmp;
        $trackingCode = substr($uniq, 0, 10);

        $data['file_passport_final'] = $this->uploadPic('file_passport');
        $data['pic_user_final'] = $this->uploadPic('pic_user');

        $data_send = [
            'language' => SOFTWARE_LANG,
            'name' => $data['name'],
            'nickName' => $data['nickName'],
            'family' => $data['family'],
            'nationality' => $data['nationality'],
            'sex' => $data['sex'],
            'country_birth' => $data['country_birth'],
            'father_name' => $data['father_name'],
            'type_passport' => $data['type_passport'],
            'profession_title' => $data['profession_title'],
            'company_name' => $data['company_name'],
            'ever_been_iran' => $data['ever_been_iran'],
            'number_trip_iran' => $data['number_trip_iran'],
            'married' => $data['married'],
            'type_visa' => $data['type_visa'],
            'enter_date' => $data['enter_date'],
            'exit_date' => $data['exit_date'],
            'previous_nationality' => $data['previous_nationality'],
            'mobile' => $data['mobile'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'hotels_accommodation' => $data['hotels_accommodation'],
            'file_passport' => $data['file_passport_final'],
            'pic_user' => $data['pic_user_final']
        ];


        if ($data['file_passport_final'] && $data['pic_user_final']){
            $result = $this->iranVisaModel()->insertWithBind($data_send);

        $data_request = [
            'module_id' => $result,
            'module_title' => 'iranVisa',
            'tracking_code' => $trackingCode,
        ];
        $request_model = Load::getModel('requestServiceModel');
        $request_model->insertWithBind($data_request);
        }
        if ( $result ) {
            $text_result = functions::Xmlinformation('YourRequestHasBeenSuccessfullyRegistered')->__toString(). '<br>'. functions::Xmlinformation('YourTrackingCode')->__toString() .':' . $trackingCode;
            return self::returnJson(true,  $text_result);
        } else {
            $text_result = functions::Xmlinformation('Errorrecordinginformation')->__toString(). '<br>'. functions::Xmlinformation('CheckInputInformationPassportPhoto')->__toString();
            return self::returnJson(false, $text_result);

        }
      }


    }

    public function listIranVisa() {
        $iran_visa_model = $this->getModel('iranVisaModel');
        $iran_visa_table = $iran_visa_model->getTable();
        $request_service_model = $this->getModel('requestServiceModel');
        $request_service_table = $request_service_model->getTable();

        $result = $iran_visa_model->get([
            $iran_visa_table.'.*',
            $iran_visa_table.'.language AS LANG',
            $iran_visa_table . '.id AS vId',
            $request_service_table.'.*',
            $request_service_table . '.id AS sId',
        ] ,true)
            ->join($request_service_table, 'module_id', 'id')
            ->where($request_service_table . '.module_title' , 'iranVisa')->orderBy('vId' , 'DESC')->all(false);
        return $this->addIranVisaIndexes($result);
    }

    public function getIranVisa($id) {
        $iran_visa_model = $this->getModel('iranVisaModel');
        $iran_visa_table = $iran_visa_model->getTable();
        $request_service_model = $this->getModel('requestServiceModel');
        $request_service_table = $request_service_model->getTable();
        $request_record = $request_service_model->get()
            ->where('module_id', $id)
            ->where('module_title', iranVisa)
            ->find();
        if ($request_record['status'] == 'not_seen'){
            $dataUpdate = [
                'status' => 'seen',
                'updated_seen_admin_at' => date('Y-m-d H:i:s', time()),
            ];
            $request_service_model->updateWithBind($dataUpdate, ['id' => $request_record['id']]);
        }

        $iranVisa = $iran_visa_model->get([
            $iran_visa_table.'.*',
            $iran_visa_table . '.id AS vId',
            $request_service_table.'.*',
            $request_service_table . '.id AS sId',
        ] ,true)
            ->join($request_service_table, 'module_id', 'id')
            ->where($iran_visa_table . '.id' , $id)
            ->where($request_service_table . '.module_title' , iranVisa)
            ->find(false);

        return $this->addIranVisaIndexes([$iranVisa])[0];
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


    public function findIranVisaById($id) {
        return $this->getModel('iranVisaModel')->get()->where('id' , $id)->find();
    }
    public function deleteIranVisa($data) {
        $check_exist_iran_visa = $this->findIranVisaById($data['id']);
        if ($check_exist_iran_visa) {
            $this->getModel('requestServiceModel')->delete("module_id='{$data['id']}' AND module_title='iranVisa' ");
            $result_delete = $this->getModel('iranVisaModel')->delete("id='{$data['id']}'");
            if ($result_delete) {

                return functions::withSuccess('', 200, 'حذف با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در حذف');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }

    public function infoIranVisaTracking($trackingCode) {

        $iran_visa_model = $this->getModel('iranVisaModel');
        $iran_visa_table = $iran_visa_model->getTable();
        $request_model = $this->getModel('requestServiceModel');
        $request_table = $request_model->getTable();
        $sql = $iran_visa_model->get([
            $iran_visa_table.'.*',
            $iran_visa_table . '.id AS vId',
            $request_table.'.*',
            $request_table . '.id AS sId',
        ] ,true)
            ->join($request_table, 'module_id', 'id')
            ->where($request_table . '.tracking_code' , $trackingCode)
            ->where($request_table . '.module_title' , 'iranVisa')
            ->find(false);

        if (!empty($sql)) {
            $sql['file'] = $this->photoUrl . 'iranVisa/' . CLIENT_ID . '/'. $sql['file_passport'];
            $sql['pic'] = $this->photoUrl . 'iranVisa/' . CLIENT_ID . '/'. $sql['pic_user'];

            $sex = $this->addIranVisaIndexes([$sql])[0]['sex'];
            if ($sex == 'Male') {
                $sex = functions::Xmlinformation('Male')->__toString();
            }elseif ($sex == 'Female') {
                $sex = functions::Xmlinformation('Female')->__toString();
            }else {
                $sex = '---';
            }
            $type_passport = $this->addIranVisaIndexes([$sql])[0]['type_passport'];
            if ($type_passport == 'Ordinary') {
                $type_passport = functions::Xmlinformation('Ordinary')->__toString();
            }elseif ($type_passport == 'Service') {
                $type_passport = functions::Xmlinformation('ServicePassport')->__toString();
            }elseif ($type_passport == 'Political') {
                $type_passport = functions::Xmlinformation('Political')->__toString();
            }elseif ($type_passport == 'Travel-Document') {
                $type_passport = functions::Xmlinformation('TravelDocument')->__toString();
            }elseif ($type_passport == 'Laissez-Passer') {
                $type_passport = functions::Xmlinformation('LaissezPasser')->__toString();
            }elseif ($type_passport == 'Refuge') {
                $type_passport = functions::Xmlinformation('Refuge')->__toString();
            }else {
                $type_passport = '---';
            }
            $married = $this->addIranVisaIndexes([$sql])[0]['married'];
            if ($married== 'Single') {
                $married = functions::Xmlinformation('Single')->__toString();
            }elseif ($married == 'Married') {
                $married = functions::Xmlinformation('Married')->__toString();
            }elseif ($married == 'Divorced') {
                $married = functions::Xmlinformation('Divorced')->__toString();
            }else {
                $married = '---';
            }

            $type_visa = $this->addIranVisaIndexes([$sql])[0]['type_visa'];
            if ($type_visa== 'Tourist') {
                $type_visa = functions::Xmlinformation('Tourist')->__toString();
            }elseif ($type_visa == 'Business') {
                $type_visa = functions::Xmlinformation('Business')->__toString();
            }elseif ($type_visa == 'Multiple_Entry') {
                $type_visa = functions::Xmlinformation('MultipleEntry')->__toString();
            }elseif ($type_visa == 'Pilgrimage') {
                $type_visa = functions::Xmlinformation('Pilgrimage')->__toString();
            }elseif ($type_visa == 'Treatment') {
                $type_visa = functions::Xmlinformation('Treatment')->__toString();
            }else {
                $type_visa = '---';
            }

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
                    <th>'.functions::Xmlinformation('NickName')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Family')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Nation')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Gender')->__toString().'</th>
                    <th>'.functions::Xmlinformation('CountryBirth')->__toString().'</th>
                    <th>'.functions::Xmlinformation('FatherName')->__toString().'</th>
                    <th>'.functions::Xmlinformation('TypePassport')->__toString().'</th>
                    <th>'.functions::Xmlinformation('ProfessionTitle')->__toString().'</th>
                    <th>'.functions::Xmlinformation('CompanyNameYou')->__toString().'</th>
                    <th>'.functions::Xmlinformation('TravelIran')->__toString().'</th>
                     <th>'.functions::Xmlinformation('HowManyTripsToIran')->__toString().'</th>

                </tr>
                </thead>
                <tbody>
            ';
            $result .= '<tr>';
            $result .= '<td>'.$sql['name'].'</td>';
            $result .= '<td>'.$sql['nickName'].'</td>';
            $result .= '<td>'.$sql['family'].'</td>';
            $result .= '<td>'.$sql['nationality'].'</td>';
            $result .= '<td>'.$sex.'</td>';
            $result .= '<td>'.$sql['country_birth'].'</td>';
            $result .= '<td>'.$sql['father_name'].'</td>';
            $result .= '<td>'.$type_passport.'</td>';
            $result .= '<td>'.$sql['profession_title'].'</td>';
            $result .= '<td>'.$sql['company_name'].'</td>';
            $result .= '<td>'.$sql['ever_been_iran'].'</td>';
            $result .= '<td>'.$sql['number_trip_iran'].'</td>';
            $result .= '</tr>';
            $result .= '</table>';
            $result .= '<br>';
            $result .= '<hr>';
            $result .= ' <table class="display" cellspacing="0" width="100%">';
            $result .= '<thead>
                           <tr>
                    <th>'.functions::Xmlinformation('Maritalstatus')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Typevisa')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Enterdate')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Exitdate')->__toString().'</th>
                    <th>'.functions::Xmlinformation('PreviousNationality')->__toString().'</th>
                    <th>'.functions::Xmlinformation('YourMobileNumber')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Phone')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Email')->__toString().'</th>
                    <th>'.functions::Xmlinformation('StayHotelName')->__toString().'</th>
                
                </tr>
               </thead>';
            $result .= '<tr>';
            $result .= '<td>'.$married.'</td>';
            $result .= '<td>'.$type_visa.'</td>';
            $result .= '<td>'.$sql['enter_date'].'</td>';
            $result .= '<td>'.$sql['exit_date'].'</td>';
            $result .= '<td>'.$sql['previous_nationality'].'</td>';
            $result .= '<td>'.$sql['mobile'].'</td>';
            $result .= '<td>'.$sql['phone'].'</td>';
            $result .= '<td>'.$sql['email'].'</td>';
            $result .= '<td>'.$sql['hotels_accommodation'].'</td>';
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


