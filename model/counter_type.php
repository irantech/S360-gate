<?php
class counter_type_tb extends Model {

    protected $table = 'counter_type_tb';
    protected $pk = 'id';

    function getAll($type = '') {
        if ($type == 'all') {
            $result = parent::select("select * from $this->table where del='no'  ORDER BY $this->pk ASC");
        } else {
            $result = parent::select("select * from $this->table where del='no' and id!='0' ORDER BY $this->pk ASC");
        }
        return $result;
    }

    function counter_type_insert($name) {
        $data = array(
            'name' => "'" . $name . "'"
        );
        return parent::insert($data);
    }
    function get($id) {
        $result = parent::load("select * from $this->table where $this->pk = '$id' and  del='no'");
        return $result;
    }
    function getById($id) {
        $result = parent::load("select * from $this->table where $this->pk = '$id' and  del='no'");
        return $result;
    }

    function counter_type_delete($id) {
        //	return parent::delete("id='$id'");
        $data = array(
            'del' => "'yes'"
        );
        return parent::update($data, "id='$id'");
    }

    function counter_type_update($info) {
        $data['discount_system_private'] = $info['discount_system_private'];
        $data['discount_system_public'] = $info['discount_system_public'];
        $data['discount_charter'] = $info['discount_charter'];
        $data['discount_hotel'] = $info['discount_hotel'];
        $id = $info['type_id'];
        $update_res = parent::update($data, "id='{$id}' "); {

            if($update_res)
            {
                echo 'success : نوع کانتر با موفقیت ویرایش شد ';
            } else {
                echo 'error : خطا در ویرایش نوع کانتر';
            }
        }
    }


    function getAllButSelected($id) {

        $result = parent::select("select * from $this->table where del='no' AND $this->pk != '$id'  ORDER BY $this->pk ASC");

        return $result;
    }

}
