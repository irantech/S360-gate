<?php

class appointmentRecognition extends clientAuth
{

    private $appointmentRecognitionTb;

    public function __construct()
    {
        parent::__construct();

        $this->appointmentRecognitionTb = 'appointment_recognition_tb';
    }

    /**
     * @param $recognition_id
     * @return array|bool|mixed|string
     */
    public function getAppointmentRecognition($recognition_id){
        $appointment_recognition_model = $this->getModel('appointmentRecognitionModel') ;
        $result =  $appointment_recognition_model->get()
            ->where('id',$recognition_id)
            ->find();

        return  $result;
    }

    /**
     * @param array $recommendationRecognitionList
     * @return array
     */

    public function getAppointmentRecognitions(){
        $appointment_recognition_model = $this->getModel('appointmentRecognitionModel')->get() ;
        $result =  $appointment_recognition_model->all();
        return  $result;
    }
}
