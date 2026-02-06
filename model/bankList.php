<?php

class bankList_tb extends Model {

    protected $table = 'bank_tb';
    protected $pk = 'id';

    function getAll($Condition) {
        $Condition = !empty($Condition) ? "WHERE ".$Condition : '';
        $result = parent::select("SELECT * FROM $this->table $Condition  ORDER BY $this->pk ASC");
        return $result;
    }

    public function get($param) {
        $result = parent::load("SELECT * FROM $this->table WHERE id = '{$param}' ORDER BY $this->pk ASC");
        return $result;
    }

    public function getByBankDir($param) {

        if(is_array($param['serviceTitle'])){
            $serviceStr = implode("','", $param['serviceTitle']);
        } else{
            $serviceStr = $param['serviceTitle'];
        }

          $Sql ="SELECT * FROM {$this->table} WHERE bank_dir = '{$param['bank_dir']}' AND enable = '1' AND
                                    CASE
                                      WHEN EXISTS(SELECT id FROM {$this->table} WHERE bank_dir = '{$param['bank_dir']}' AND enable = '1' AND serviceTitle in ('{$serviceStr}'))
                                        THEN serviceTitle IN ('{$serviceStr}')
                                      ELSE serviceTitle = 'All'
                                    END
                                    LIMIT 0,1" ;

        return parent::load($Sql);

    }

    function insertBank($InfoBank) {
   

        $data['title'] = $InfoBank['title'];
        $data['bank_dir'] = $InfoBank['bank_dir'];
        $data['param1'] = $InfoBank['param1'];
        $data['param2'] = $InfoBank['param2'];
        $data['param3'] = $InfoBank['param3'];
        $data['creation_date_int'] = time();


        $result = parent::insertLocal($data);

        if ($result) {
            return 'success : بانک با موفقیت ثبت شد';
        } else {
            return 'error : خطا در ثبت بانک';
        }
    }

    function updateBank($InfoBank) {

        $result = parent::load("select * from $this->table where $this->pk = '{$InfoBank['bankId']}'");

        $id = $result['id'];

        if (!empty($result)) {

            $data['param1'] = $InfoBank['param1'];
            $data['param2'] = $InfoBank['param2'];
            $data['param3'] = $InfoBank['param3'];
            $data['last_edit_int'] = time();
            $res_update = parent::update($data, "id='{$id}'");
            if ($res_update) {
                return 'success : اطلاعات بانک با موفقیت ویرایش شد';
            } else {
                return 'error : خطا در ویرایش اطلاعات بانک';
            }
        } else {
            return 'error : خطا در  شناسایی  بانک';
        }
    }

}
