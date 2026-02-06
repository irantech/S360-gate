<?php

class employmentMilitary extends clientAuth
{

    private $employmentMilitary;

    public function __construct()
    {
        parent::__construct();

        $this->employmentMilitary = 'employment_military_tb';
    }


    /**
     * @param $military_id
     * @return array|bool|mixed|string
     */
    public function getEmploymentMilitary($military_id){
        $employment_military_model = $this->getModel('employmentMilitaryModel') ;
        $result =  $employment_military_model->get()
            ->where('id',$military_id)
            ->find();
        $result =  $employment_military_model->all();
        return  $result;
    }

    /**
     * @param array $employmentMilitaryList
     * @return array
     */

    public function getEmploymentMilitaries(){
        $employment_military_model = $this->getModel('employmentMilitaryModel')->get() ;
        $result =  $employment_military_model->all();
        return  $result;
    }
}
