<?php

class appointmentStatus extends clientAuth
{
    private $appointmentStatusTb;

    public function __construct()
    {
        parent::__construct();

        $this->appointmentStatusTb = 'appointment_status_tb';
    }

    /**
     * @param $status_id
     * @return array|bool|mixed|string
     */
    public function getAppointmentStatus($status_id){
        $appointment_status_model = $this->getModel('appointmentStatusModel') ;
        $result =  $appointment_status_model->get()
            ->where('id',$status_id)
            ->find();
        return  $result;
    }

    /**
     * @return array
     */
    public function getAppointmentStatusList(){

        $appointment_status_model = $this->getModel('appointmentStatusModel')->get() ;

        return  $appointment_status_model->all();
    }

    /**
     * @param $status_id
     * @return string
     */
    public function getButtonStatus($status_id){

        switch ($status_id) {
            case 1 :
                $button = 'btn btn-default cursor-default ' ;
                break;
            case 2 :
                $button = 'btn btn-info cursor-default' ;
                break;
            case 3 :
                $button = 'btn btn-warning cursor-default' ;
                break ;

            case 4 :
                $button = 'btn btn-danger cursor-default' ;
                break ;
            case 5 :
                $button = 'btn btn-success cursor-default' ;
                break ;
            case 6 :
                $button = 'btn btn-primary cursor-default' ;
                break ;
            default :
                $button = '' ;
                break ;
        }
        return  $button ;
    }

    public function getAppointmentStatusReasonById($params){

        $appointment_status_model = $this->getModel('appointmentStatusModel');
        $appointment_status_table = $appointment_status_model->getTable();

        $appointment_status_reason_model = $this->getModel('appointmentStatusReasonModel');
        $appointment_status_reason_table = $appointment_status_reason_model->getTable();

        $status_reasons = $appointment_status_reason_model
            ->get([
                $appointment_status_reason_table . '.*',
            ], true)
            ->join($appointment_status_table, 'id', 'status_id')
            ->where('status_id', $params['status_id']);

        $status_reasons =  $status_reasons->all();

        if($params['is_json']){
            return functions::withSuccess($status_reasons,200,'data fetched successfully');
        }

        return  $status_reasons ;
    }

    public function getAppointmentStatusReason($status_reason_id) {
        $appointment_status_reason_model = $this->getModel('appointmentStatusReasonModel');
        $result =  $appointment_status_reason_model->get()
            ->where('id',$status_reason_id)
            ->find();
        return  $result;
    }

    /**
     * @return array
     */
    public function getAppointmentStatusListCount(){

         $appointment_status_model = $this->getModel('appointmentStatusModel') ;
         $appointment_status_tb = $appointment_status_model->getTable();
         $appointment_model = $this->getModel('appointmentModel');
         $appointment_tb = $appointment_model->getTable();

         $appointment_status_model = $appointment_status_model->get([
             '*',
             'count('.$appointment_tb.'.id) as count'
         ])->join($appointment_tb, 'status_id', 'id')
             ->where($appointment_tb . '.deleted_at', null, 'IS')
             ->groupBy($appointment_tb.'.status_id');


        return  $appointment_status_model->all();
    }



}
?>