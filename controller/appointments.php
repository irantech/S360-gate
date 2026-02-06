<?php
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
class appointments extends clientAuth
{
    private $appointmentTb, $appointmentField, $appointmentStatus , $appointmentRecognition , $appointmentNegotiation;
    /**
     * @var string
     */
    private $page_limit;
    /**

     * @var string
     */

    public function __construct()
    {
        parent::__construct();

        $this->appointmentTb = 'appointment_tb';
        $this->page_limit = 10;
        $this->appointmentStatus = Load::controller('appointmentStatus');
        $this->appointmentRecognition = Load::controller('appointmentRecognition');;
        $this->appointmentField = Load::controller('appointmentField') ;
        $this->appointmentNegotiation = Load::controller('appointmentNegotiation') ;
    }

    /**
     * @param array $appointmentList
     * @return array
     */
    public function addAppointmentIndexes(array $appointmentList) {
        $result = [];

        foreach ($appointmentList as $key => $appointment) {

            $result[$key] = $appointment;
            $time_date = functions::ConvertToDateJalaliInt($appointment['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);

            $result[$key]['field'] =        $this->appointmentField->getAppointmentField($appointment['field_id']);;
            $result[$key]['recognition'] =  $this->appointmentRecognition->getAppointmentRecognition($appointment['recognition_id']);;
            $result[$key]['status'] =       $this->appointmentStatus->getAppointmentStatus($appointment['status_id']);
            $result[$key]['negotiation'] =  $this->appointmentNegotiation->getAppointmentNegotiationByAppointmentId($appointment['id']);

        }

        return $result;
    }


    /**
     * @param array $params
     */

    public function insertAppointment($params)
    {

        $appointment_model = Load::getModel('appointmentModel');
        $arg = array(
            'fullName'           => FILTER_SANITIZE_STRING,
            'profession'         => FILTER_SANITIZE_STRING,
            'comment'            => FILTER_SANITIZE_STRING,
            'reserved_date'      => FILTER_SANITIZE_STRING,
            'reserved_time'      => FILTER_SANITIZE_STRING,
            'mobile'             => FILTER_SANITIZE_NUMBER_INT,
            'field_id'           => FILTER_SANITIZE_NUMBER_INT,
            'recognition_id'     => FILTER_SANITIZE_NUMBER_INT,
            'email'              => FILTER_VALIDATE_EMAIL,
            'is_admin'              => FILTER_SANITIZE_NUMBER_INT,
        );
        $dataPost = filter_var_array($params, $arg);
        $count = 0;
        $tmp = mt_rand(1, 15);
        do {
            $tmp .= mt_rand(0, 15);
        } while (++$count < 16);
        $member_id = Session::getUserId();
        $uniq = $tmp;
        $trackingCode = substr($uniq, 0, 10);
        $appointment['fullName'] = $dataPost['fullName'];
        $appointment['mobile'] = $dataPost['mobile'];
        $appointment['email'] = $dataPost['email'];
        $appointment['profession'] = $dataPost['profession'];
        $appointment['comment'] = $dataPost['comment'];
        $appointment['reserved_date'] = $dataPost['reserved_date'] ;
        $appointment['reserved_time'] = $dataPost['reserved_time'] ;
        $appointment['field_id']    = $dataPost['field_id'] ;
        $appointment['recognition_id']   = $dataPost['recognition_id'] ;
        if (isset($dataPost['is_admin']) && $dataPost['is_admin'] == 1) {
            $appointment['status_id'] = 2 ;
        }else {
            $appointment['status_id'] = 1 ;
        }
        $appointment['created_at'] = date('Y-m-d H:i:s', time());

        $insert = $appointment_model->insertWithBind($appointment);
        $user_id = ($member_id) ? $member_id : '0';

        if ($insert) {
            $data_request = [
                'user_id' => $user_id,
                'module_id' => $insert,
                'module_title' => 'appointment',
                'tracking_code' => $trackingCode,
            ];
            $temp_model = Load::getModel('requestServiceModel');
            $temp_model->insertWithBind($data_request);

            $msg = 'این رزرو با موفقیت برای شما ثبت شد' ."<br>". 'کد پیگیری شما :' .$trackingCode;

            return self::returnJson(true, $msg);
        }

        return self::returnJson(false, 'خطا در ثبت اطلاعات در سیستم.', null, 500);
    }


    public function updateAppointment($params) {

        $appointment_model = $this->getModel('appointmentModel');

        $appointment = $appointment_model->get()
            ->where('id', $params['appointment_id'])
            ->find();

        $dataUpdate = [
            'fullName'       => $params['fullName'],
            'mobile'         => $params['mobile'],
            'email'          => $params['email'],
            'profession'    => $params['profession'],
            'comment'       => $params['comment'],
            'reserved_date'       => $params['reserved_date'],
            'reserved_time'    => $params['reserved_time'],
            'field_id'      => $params['field_id'],
            'recognition_id'  => $params['recognition_id'],
            'status_id'  => $params['status_id'],
            'updated_at'    => date('Y-m-d H:i:s', time()),
        ];



        $update = $appointment_model->updateWithBind($dataUpdate, ['id' => $appointment['id']]);
        if ($params['status_id']) {
            $insert = $this->appointmentNegotiation->insertAppointmentNegotiation($params);
        }
        if ($update) {

            return self::returnJson(true, 'درخواست با موفقیت در سیستم بروزرسانی شد');
        }

        return self::returnJson(false, 'خطا در ثبت اطلاعات در سیستم.', null, 500);
    }


    /**
     * @param  $status , $page
     * @return array
     */

    public function getAppointments( $page = null){


        $appointment_model = $this->getModel('appointmentModel');
        $appointment_count_model = $this->getModel('appointmentModel');
        $appointment_table = $appointment_model->getTable();


        $appointment_negotiation_model = $this->getModel('appointmentNegotiationModel');
        $appointment_negotiation_tb = $appointment_negotiation_model->getTable();
        $request_service_model = $this->getModel('requestServiceModel');
        $request_service_table = $request_service_model->getTable();
        $appointment_count = $appointment_count_model
            ->get([
                'count(' . $appointment_table . '.id) as count',
            ], true);

        $whereCondition = false;
//        $appointments = "SELECT {$appointment_table}.* FROM {$appointment_table} ";
        $appointments = "SELECT {$appointment_table}.* ,
                                {$request_service_table}.* ,
                                {$appointment_table}.id as id ,
                                {$request_service_table}.id  as ids
                        FROM {$appointment_table}
                        LEFT JOIN {$request_service_table}
                        ON {$appointment_table}.id = {$request_service_table}.module_id 
                        ";
        if($_POST['reminder_time']) {

         $appointments .= "JOIN      (
              SELECT    MAX(id) max_id, appointment_id
              FROM      {$appointment_negotiation_tb}
              GROUP BY  appointment_id
                     ) c_max ON (c_max.appointment_id = appointments_tb.id)
                 JOIN      {$appointment_negotiation_tb} ON ({$appointment_negotiation_tb}.id =c_max.max_id)
                WHERE {$appointment_negotiation_tb}.reminder_time = '{$_POST['reminder_time']}'  ";
         $whereCondition = true;
        }

        if($_POST['appointment_status']) {

            /** @var TYPE_NAME $whereCondition */
            if($whereCondition) {
                $appointments .= "and {$appointment_table}.status_id = {$_POST['appointment_status']} " ;
            }else {
                $appointments .= "where {$appointment_table}.status_id = {$_POST['appointment_status']} " ;

            }
            $whereCondition = true;

        }

        if($_POST['fullName']) {

            if($whereCondition){
                $appointments .= "and {$appointment_table}.fullName like '%{$_POST['fullName']}%' " ;
            }else {
                $appointments .= "where {$appointment_table}.fullName like '%{$_POST['fullName']}%' " ;
            }
            $whereCondition = true;
        }


        if($whereCondition){
            $appointments .= "and {$appointment_table}.deleted_at is null and {$request_service_table}.module_title ='appointment' " ;
        }
        else {
            $appointments .= "where {$appointment_table}.deleted_at is null and {$request_service_table}.module_title ='appointment' " ;
        }


        $appointment_count = $appointment_count
            ->where($appointment_table . '.deleted_at', null, 'IS');
//        if($_POST['reminder_time']) {
//            $appointments .= "group by {$appointment_negotiation_tb}.appointment_id " ;
//        }
        $appointments .= "group by request_service_tb.module_id " ;
        $appointments .= "order by {$appointment_table}.id DESC" ;

        $count = $appointment_count->find();

        $result['items_count'] = $count['count'];
        $result['per_page'] = $this->page_limit;
        $result['count'] = ceil($count['count'] / $this->page_limit);
        $result['current_page'] = ROOT_ADDRESS . '/appointment?page=' . $page;

        for ($x = 0; $x < $result['count']; $x++) {
            $count = ($x + 1);
            $result['links'][] = [
                'index' => $count,
                'link' => ROOT_ADDRESS . '/appointment?page=' . $count
            ];
        }
        if ($page) {
            $offset = ($page - 1) * $this->page_limit;
            $appointments .= "order by limit {$offset},{$this->page_limit}" ;
        }
        $Model  = Load::library( 'Model' );

        $appointments = $Model->select( $appointments );
        $result['data'] = $this->addAppointmentIndexes($appointments);

        return $result;
    }



    /**
     * @param  int  $id
     * @return array
     */
    public function getAppointment($id) {
        $appointment_model = $this->getModel('appointmentModel');
        $appointment_table = $appointment_model->getTable();

        $appointment = $appointment_model
            ->get(
                [
                    $appointment_table . '.*',
                ], true
            )
            ->where($appointment_table . '.id', $id)
            ->where($appointment_table . '.deleted_at', null, 'IS')
            ->find(false);

        return $this->addAppointmentIndexes([$appointment])[0];
    }

    public function DeleteAppointment($params){

        $result = $this->getModel('appointmentModel')->softDelete([
            'id' => $params['appointment_id']
        ]);
        if ($result) {
            return functions::JsonSuccess($result, 'این رزرو حذف شد');
        }
        return functions::JsonError($result, 'خطا در حذف رزرو', 200);
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

    public function infoAppointmentTracking($trackingCode) {
        $appointment_model = $this->getModel('appointmentModel');
        $appointment_table = $appointment_model->getTable();
        $request_model = $this->getModel('requestServiceModel');
        $request_table = $request_model->getTable();
        $sql = $appointment_model->get([
            $appointment_table.'.*',
            $appointment_table . '.id AS appId',
            $request_table.'.*',
            $request_table . '.id AS sId',
        ] ,true)
            ->join($request_table, 'module_id', 'id')
            ->where($request_table . '.tracking_code' , $trackingCode)
            ->where($request_table . '.module_title' , appointment)
            ->find(false);
        if (!empty($sql)) {
            $sql['AppointmentNegotiation'] =  $this->appointmentNegotiation->getAppointmentNegotiationByAppointmentId($sql['appId']);
            $appointment_field_model = $this->getModel('appointmentFieldModel') ;
            $result_field =  $appointment_field_model->get()->where('id',$sql['field_id'])->find();
            $sql['field_id_name'] = $result_field['title'];
            $appointment_recognitions_model = $this->getModel('appointmentRecognitionModel') ;
            $result_recognitions =  $appointment_recognitions_model->get()->where('id',$sql['recognition_id'])->find();
            $sql['recognitions_id_name'] = $result_recognitions['title'];


            $result = '';
            $result .= '
            <div class="">
            <table class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>'.functions::Xmlinformation('Typevisa')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Namefamily')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Mobile')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Email')->__toString().'</th>
                    <th>'.functions::Xmlinformation('ProfessionTitle')->__toString().'</th>
                    <th>'.functions::Xmlinformation('MethodIntroduction')->__toString().'</th>
                    <th>'.functions::Xmlinformation('DateConsultation')->__toString().'</th>
                    <th>'.functions::Xmlinformation('TimeConsultation')->__toString().'</th>
                </tr>
                </thead>
                <tbody>
            ';
            $result .= '<tr>';
            $result .= '<td>'.$sql['field_id_name'].'</td>';
            $result .= '<td>'.$sql['fullName'].'</td>';
            $result .= '<td>'.$sql['mobile'].'</td>';
            $result .= '<td>'.$sql['email'].'</td>';
            $result .= '<td>'.$sql['profession'].'</td>';
            $result .= '<td>'.$sql['recognitions_id_name'].'</td>';
            $result .= '<td>'.$sql['reserved_date'].'</td>';
            $result .= '<td>'.$sql['reserved_time'].'</td>';
            $result .= '</tr>';
            $result .= '</table>';
            $result .= '</div>';
            $result .= '<hr>';
            $result .= '<div class="parent-btn-order" style="justify-content: right;margin-right: 25px;">';
            if ($sql['comment'] != ''){
                $result .= '<p class=" ml-2">'.functions::Xmlinformation('MoreExplain')->__toString().' :</p>';
                $result .= '<p class="font-18">' . $sql['comment'] . '</p>';
            }
            $result .= '</div>';
            if ($sql['AppointmentNegotiation']['data']) {

                $result .= '<hr>';
                $result .= '<div style="margin: 30px 10px 15px 0">';
                $result .= '<h4>';
                $result .= ''.functions::Xmlinformation('ConsultationTimesGiven')->__toString().'';
                $result .= '</h4>';
                $result .= '</div>';
            $result .= '
            <div class="">
            <table class="display table table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>'.functions::Xmlinformation('Row')->__toString().'</th>
                    <th>'.functions::Xmlinformation('RequestStatus')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Reason')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Description')->__toString().'</th>
                    <th>'.functions::Xmlinformation('ReminderDate')->__toString().'</th>
                    <th>'.functions::Xmlinformation('RegistrationDate')->__toString().'</th>
                </tr>
                </thead>
                <tbody>
            ';
                foreach ($sql['AppointmentNegotiation']['data']  as $key=>$negotiation) {
                        $key = $key + 1;
                    $result .= '<tr>';
                    $result .= '<td>' . $key . '</td>';
                    $result .= '<td>' . $negotiation['status']['title'] . '</td>';
                    $result .= '<td>' . $negotiation['status_reason']['title'] . '</td>';
                    $result .= '<td>' . $negotiation['comment'] . '</td>';
                    $result .= '<td>' . $negotiation['reminder_time'] . '</td>';
                    $result .= '<td>' . $negotiation['created_at'] . '</td>';
                    $result .= '</tr>';
                }

            $result .= '</table>';
            $result .= '</div>';
            }else{
                $result .= '<p class=" ml-2" style="margin: 50px 25px 13px 0;font-size: 16px;color: #ef384e;text-align: center;">'.functions::Xmlinformation('NoResponseAdmin')->__toString().' </p>';
            }
            $result .= '';
            return $result;
        }
    }


}