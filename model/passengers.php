<?php

class passengers_tb extends Model {

    protected $table = 'passengers_tb';
    protected $pk = 'id';

    public function getAll($fk_members_tb_id) {
      return  parent::select("SELECT * FROM $this->table  WHERE `fk_members_tb_id`='$fk_members_tb_id' AND `del` = 'no' ORDER BY $this->pk Desc ");
    }


    public function getAllpassengers($fk_members_tb_id) {
        return parent::load("select count(id) as passengers from $this->table  where `fk_members_tb_id`='$fk_members_tb_id' and `del` = 'no' ORDER BY $this->pk ASC");
    }

    public function get($id = '') {
       return  parent::load("select * from $this->table  where $this->pk='$id' and `del` = 'no'");
    }

    public function passengers_insert($data) {

        if($data['is_foreign'] == '1'){
            $condition = " AND passportNumber = '{$data['passportNumber']}' ";
        } else{
            $condition = " AND NationalCode = '{$data['NationalCode']}' ";
        }
        $sqlExist = "SELECT COUNT(id) AS repeated, id FROM {$this->table} WHERE fk_members_tb_id = '{$data['fk_members_tb_id']}' {$condition} AND  del = 'no'";

        $resultExist = parent::load($sqlExist);



        functions::insertLog('before check repeated==>'.json_encode($resultExist,256),'checkPassenger');
        if($resultExist['repeated'] == 0) {
            functions::insertLog('after check repeated==>'.json_encode($data,256),'checkPassenger');
            functions::insertLog('******************','checkPassenger');
            $resultAdd = parent::insertLocal($data);
            if ($resultAdd) {
                $result['lastId'] = parent::getLastId();
                $result['result_status'] = 'success';
                $result['result_message'] = 'مسافر جدید با موفقیت ثبت شد';
            } else {
                $result['result_status'] = 'error';
                $result['result_message'] = 'خطا در ثبت مسافر';
            }

        } else {

            $result = $this->passengers_update($data, $resultExist['id']);

            $result['result_status'] = 'error';
            $result['result_message'] = 'مسافری با کد ملی و یا شماره پاسپورت مذکور قبلا ثبت شده است';
        }

        return $result;
    }

    public function passengers_update($data, $id) {


        if($data['is_foreign'] == '1'){
            if ($data['passportNumber'] != '') {
                $condition = " AND passportNumber = '{$data['passportNumber']}' ";
            }else{
                $condition = " AND passportNumber = '' ";
            }
        } else{
            if ($data['NationalCode'] != '') {
                $condition = " AND NationalCode = '{$data['NationalCode']}' ";
            }else {
                $condition = " AND NationalCode = '' ";
            }

        }

         $sqlExist = "SELECT " .
                    "(SELECT COUNT(id) FROM {$this->table} WHERE fk_members_tb_id = '{$data['fk_members_tb_id']}' AND id = '{$id}' AND  del = 'no') AS exist, " .
                    "(SELECT COUNT(id) FROM {$this->table} WHERE fk_members_tb_id = '{$data['fk_members_tb_id']}' AND id != '{$id}' {$condition} AND  del = 'no') AS repeated";
        $resultExist = parent::load($sqlExist);


        if ($resultExist['exist'] > 0) {
            if ((int)$resultExist['repeated'] == 0) {
                $resultUpdate = parent::update($data, "id = '{$id}'");
                if ($resultUpdate) {
                    $result['lastId'] = $id;
                    $result['result_status'] = 'success';
                    $result['result_message'] = 'اطلاعات مسافر با موفقیت ویرایش شد';
                } else {
                    $result['result_status'] = 'error';
                    $result['result_message'] = 'خطا در ویرایش اطلاعات مسافر';
                }

            } else {
                $result['lastId'] = $id;
                $result['result_status'] = 'error';
                $result['result_message'] = 'مسافری با کد ملی و یا شماره گذرنامه مذکور قبلا ثبت شده است';
            }

        } else {
            $result['result_status'] = 'error';
            $result['result_message'] = 'رکوردی با اطلاعات وارد شده وجود دارد <br> کد ملی یا شماره گذرنامه را مجددا بررسی نمایید ';
        }

        return $result;
    }

    public function passengers_delete($id) {
        $data['del'] = 'yes';
        $res = parent::update($data, "id='$id'");
        if ($res) {
            echo "success:حذف مشتری با موفقیت انجام شد";
        } else {
            echo "error : خطا در حذف مشتری";
        }
    }


    public function insertPassenger($data)
    {
        $passengerAddArray = array(
            'passengerName' => $data['name'],
            'passengerNameEn' => $data['name_en'],
            'passengerFamily' => $data['family'],
            'passengerFamilyEn' => $data['family_en'],
            'passengerGender' => $data['gender'],
            'passengerBirthday' => $data['birthday_fa'],
            'passengerNationalCode' => $data['NationalCode'],
            'passengerBirthdayEn' => $data['birthday'],
            'passengerPassportCountry' => $data['passportCountry'],
            'passengerPassportNumber' => $data['passportNumber'],
            'passengerPassportExpire' => $data['passportExpire'],
            'memberID' => $data['fk_members_tb_id'],
            'passengerNationality' => $data["passengerNationality"]

        );
        parent::insert ($passengerAddArray);

    }

}
