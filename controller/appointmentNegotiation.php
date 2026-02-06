<?php

class appointmentNegotiation extends clientAuth
{
    private $appointmentNegotiationTb, $appointmentTb , $appointmentStatus , $appointment;


    /**

     * @var string
     */

    public function __construct()
    {
        parent::__construct();

        $this->appointmentNegotiationTb = 'appointment_negotiation_tb';
        $this->appointmentTb = 'appointment_tb';
        $this->appointmentStatus = Load::controller('appointmentStatus');
    }

    /**
     * @param array $appointmentNegotiationList
     * @return array
     */
    public function addAppointmentNegotiationIndexes(array $appointmentNegotiationList) {
        $result = [];

        foreach ($appointmentNegotiationList as $key => $appointmentNegotiation) {

            $result[$key] = $appointmentNegotiation;
            $time_date = functions::ConvertToDateJalaliInt($appointmentNegotiation['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);

            $result[$key]['status'] =        $this->appointmentStatus->getAppointmentStatus($appointmentNegotiation['status_id']);
            $result[$key]['status_reason'] = $this->appointmentStatus->getAppointmentStatusReason($appointmentNegotiation['status_reason_id']);
        }

        return $result;
    }


    /**
     * @param array $params
     */

    public function insertAppointmentNegotiation($params)
    {

        $appointment_model = Load::getModel('appointmentNegotiationModel');
        $arg = array(
            'reminder_time'      => FILTER_SANITIZE_STRING,
            'status_reason_id'   => FILTER_SANITIZE_NUMBER_INT,
            'appointment_id'     => FILTER_SANITIZE_NUMBER_INT,
            'status_id'          => FILTER_SANITIZE_NUMBER_INT,
            'negotiation_comment'            => FILTER_SANITIZE_STRING,
        );
        $dataPost = filter_var_array($params, $arg);

        $appointment['appointment_id'] = $dataPost['appointment_id'];
        $appointment['reminder_time'] = $dataPost['reminder_time'];
        $appointment['status_id'] = $dataPost['status_id'];
        $appointment['status_reason_id'] = $dataPost['status_reason_id'];
        $appointment['comment'] = $dataPost['negotiation_comment'];
        $appointment['created_at'] = date('Y-m-d H:i:s', time());

        $insert = $appointment_model->insertWithBind($appointment);

        if ($insert) {
            return self::returnJson(true, 'این مذاکره با موفقیت برای شما ثبت شد.');
        }

        return self::returnJson(false, 'خطا در ثبت اطلاعات در سیستم.', null, 500);
    }


    /**
     * @return array
     */

    public function getAppointmentsNegotiations(){

        $appointment_negotiation_model = $this->getModel('appointmentNegotiationModel');

        $appointment_negotiation_table = $appointment_negotiation_model->getTable();

        $appointment_negotiations = $appointment_negotiation_model
            ->get('*' ,  true);

        $appointment_negotiations = $appointment_negotiations
            ->where($appointment_negotiation_table . '.deleted_at', null, 'IS');

        $appointment_negotiations = $appointment_negotiations->orderBy($appointment_negotiation_table . '.id');

        $appointment_negotiations = $appointment_negotiations->all(false);

        $result['data'] = $this->addAppointmentNegotiationIndexes($appointment_negotiations);

        return $result;
    }


    public function getAppointmentNegotiationByAppointmentId($appointmentId) {

        $appointment_negotiation_model = $this->getModel('appointmentNegotiationModel');
        $appointment_negotiation_tb = $appointment_negotiation_model->getTable();
        $appointment_model = $this->getModel('appointmentModel');
        $appointment_tb = $appointment_model->getTable();

        $appointment_negotiations = $appointment_negotiation_model
            ->get([
                $appointment_negotiation_tb . '.*',
            ], true)
            ->join($appointment_tb, 'id', 'appointment_id')
            ->where('appointment_id', $appointmentId);


        $appointment_negotiations = $appointment_negotiations->all(false);

        $result['data'] = $this->addAppointmentNegotiationIndexes($appointment_negotiations);

        return $result;
    }

    public function getLastNegotiationById($appointment_id){

        $appointment_negotiation_model = $this->getModel('appointmentNegotiationModel');

        $appointment_negotiations = $appointment_negotiation_model
            ->get(['*'], true)
            ->where('appointment_id', $appointment_id)->orderBy('updated_at' , 'desc')->limit(0,1)->all(false);
        return $this->addAppointmentNegotiationIndexes($appointment_negotiations);

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


}