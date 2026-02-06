<?php

class reservationProof extends clientAuth {

    protected $reservation_proof_model;

    public function __construct() {
        parent::__construct();
        $this->reservation_proof_model = $this->getModel('reservationProofModel');
    }

    public function  uploadProof($params , $file) {

        $data = $params ;

        if (isset($_FILES['proof_file']) && $_FILES['proof_file'] != "") {

            $_FILES['file'] = $_FILES['proof_file'];
            $config = Load::Config('application');
            $config->pathFile('proof/');
            $success = $config->UploadFile("file", "file", 500000);

            $explode_name_pic = explode(':', $success);
            if ($explode_name_pic[0] == "done") {
                $uploaded_file = $explode_name_pic[1] ;
                $insertFile =   $this->reservation_proof_model
                    ->insertWithBind([
                        'request_number' => $data['request_number'],
                        'service_title' => $data['service_type'],
                        'file_title' => $data['proof_title'],
                        'file_path' => $uploaded_file,
                    ]);
                return [
                    'type' => 'success' ,
                    'data' => $insertFile
                ];
            }else {
                return [
                    'type' => 'error' ,
                    'data' => $success
                ];
            }
        }


    }

    public function getProofFile($request_number , $service_type) {
        $proof_file = $this->reservation_proof_model->get()
            ->where('request_number' , $request_number)
            ->where('service_title' , $service_type)
            ->find();
        return $proof_file;
    }

}