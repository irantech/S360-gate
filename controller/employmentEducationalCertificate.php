<?php

class employmentEducationalCertificate extends clientAuth
{
    private $employmentEducationalCertificate;

    public function __construct() {
        parent::__construct();

        $this->employmentEducationalCertificate = 'employment_educational_certificate_tb';
    }

    /**
     * @param $certificate_id
     * @return array|bool|mixed|string
     */
    public function getEmploymentEducationalCertificate($certificate_id){
        $employment_educational_certificate_model = $this->getModel('employmentEducationalCertificateModel');
        $result = $employment_educational_certificate_model->get()
            ->where('id', $certificate_id)
            ->find();
        $result =  $employment_educational_certificate_model->all();
            return $result;
     }

    /**
     * @param array $employmentCertificateList
     * @return array
     */

    public function getEmploymentEducationalCertificates(){
        $employment_educational_certificate_model = $this->getModel('employmentEducationalCertificateModel')->get() ;
        $result =  $employment_educational_certificate_model->all();
        return  $result;
//        var_dump($result);
    }

}