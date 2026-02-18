<?php
error_reporting(0);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

class appointmentField extends clientAuth
{
    private $appointmentFieldTb;

    public function __construct()
    {
        parent::__construct();

        $this->appointmentFieldTb = 'appointment_field_tb';
    }


    /**
     * @param array $recommendationFields
     * @return array
     */

    public function getAppointmentFields(){

        $appointment_field_model = $this->getModel('appointmentFieldModel')->get() ;
        return  $appointment_field_model->all();
    }

    /**
     * @param $field_id
     * @return array|bool|mixed|string
     */
    public function getAppointmentField($field_id){
        $appointment_field_model = $this->getModel('appointmentFieldModel') ;
        $result =  $appointment_field_model->get()
            ->where('id',$field_id)
            ->find();
        return  $result;
    }


}

?>