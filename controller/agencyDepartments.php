<?php
class agencyDepartments extends ClientAuth{
    protected $agency_depart_model;
    public function __construct() {
        parent::__construct();
        $this->agency_depart_model = $this->getModel('agencyDepartmentsModel');
    }

    //insert
    public function insertAgencyDepart($params){

        if (empty($params)) {
            $params = $_POST;
        }
        // بررسی صحت دریافت اطلاعات
        if (empty($params['title'])) {
            echo json_encode([
                'success' => false,
                'message' => 'پارامترها ناقص هستند',
                'params' => $params,
            ]);
            return;
        }

        $insert_data = $this->agency_depart_model->insertWithBind([
            'title' => $params['title'],
            'code' => $params['code'],
            'description' => $params['description'],
            'del'=>'no'
        ]);

         if ($insert_data) {
            return functions::JsonSuccess($insert_data, 'واحد مورد نظر ثبت گردید');
        }
        return functions::JsonError($insert_data, 'خطا در ثبت واحد', 200);
    }

    //list
    public function getAgencyDepart() {
        $Departs = $this->agency_depart_model->get()->where('del','no')->all();
        return $this->agencyDepartIndexes($Departs);
    }
    //show list
    public function agencyDepartIndexes($Departs) {
        $result = [];
        foreach ($Departs as $key => $Depart) {
            $result[$key] = $Depart;
            $cleanText = strip_tags($Depart['description']);
            $result[$key]['short_description'] = mb_substr($cleanText, 0, 50) . '...';
        }
        return $result;
    }

    //delete az List
    public function deleteAgencyDepart($params) {
        $Depart = $this->agency_depart_model->get()->where('id', $params['id'])->find();

        if ($Depart) {
            $result = $this->agency_depart_model->updateWithBind([
                    'del' => 'yes'
                ], [
                    'id' => $params['id']
                ]);
            if($result)
                return functions::JsonSuccess($result, 'رکورد مورد نظر حذف شد');
            else
                return functions::JsonError($result, 'خطا در حذف ', 200);
        }
        return functions::JsonError($Depart, 'خطا در حذف ', 200);
    }

    //edit
    public function getAgencyDepartById($id) {
        $Depart = $this->agency_depart_model->get()->where('id', $id)->find();
        return $Depart;
    }
    public function editAgencyDepart($params) {
        $Depart = $this->agency_depart_model->get()->where('id', $params['depart_id'])->find();

        if ($Depart) {
            $result = $this->agency_depart_model->updateWithBind([
                    'title' => $params['title'],
                    'code' => $params['code'],
                    'description' => $params['description']
                ], [
                    'id' => $params['depart_id']
                ]);
            if($result)
                return functions::JsonSuccess($result, 'رکورد مورد نظر ویرایش شد');
            else
                return functions::JsonError($result, 'خطا در ویرایش ', 200);
        }
        return functions::JsonError($Depart, 'خطا در ویرایش ', 200);
    }
}