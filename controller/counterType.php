<?php
/**
 * Class CounterType
 * @property CounterType $CounterType
 */

class CounterType extends clientAuth {

    public $name = '';
    public $deleteID = '';
    public $editID = '';
    public $message = '';    //message that show after insert new counter type
    public $list = array();     //array that include list of counter Types

    /**
     * if form was send  "get data-> insert DB"
     */

    public function __construct() {
        parent::__construct();
    }


    /**
     * @param $name
     * @return bool
     */
    public function insert($name) {
        $counter = Load::model('counter_type');
        $result = $counter->counter_type_insert($name);
        if ($result) {
            $counterID = $counter->getLastId();
            $airline = Load::model('airline');
            $discount = Load::model('discount');
            $listairline = $airline->getAll();
            foreach ($listairline as $val) {
                ($counterID == '0') ? ($discount->discount_insert('50', $counterID, $val['id'])) : ($discount->discount_insert('0', $counterID, $val['id']));
            }
            echo "success : افزودن نوع کانتر با موفقیت انجام شد";
        } else {
            return false;
        }
    }

    
    public function showedit($id) {

         Load::autoload('Model');
        $Model = new Model();
        if (isset($id) && !empty($id)) {
            $edit_query = " SELECT * FROM  counter_type_tb  WHERE id='{$id}'";
            $res_edit = $Model->load($edit_query);
            if (!empty($res_edit)) {
                $this->list = $res_edit;
            } else {
                header("Location: " . ROOT_ADDRESS_WITHOUT_LANG .'/'. FOLDER_ADMIN ."/404.tpl");
            }
        } else {
            header("Location: " . ROOT_ADDRESS_WITHOUT_LANG .'/'. FOLDER_ADMIN ."/404.tpl");
        }
    }


    /**
     * @param $CType
     * @return mixed
     */
    public function update($CType) {
        $counter = Load::model('counter_type');
        return $counter->counter_type_update($CType);
    }


    /**
     * @param string $type
     */
    public function getAll($type = '') {
        $counter = Load::model('counter_type');
        if ($type == '') {
            $this->list = $counter->getAll();
        } else {
            $this->list = $counter->getAll('all');
        }

        //echo Load::plog($this->list);
    }

    /**
     * delete counter type
     */
    public function delete() {
        $counter = Load::model('counter_type');
        return $counter->counter_type_delete($this->deleteID);
    }

    /**
     * get one counter type
     * @return information array
     */
    public function get($id = '') {
        $counter = Load::model('counter_type');
        ($id != '') ? ($this->list = $counter->get($id)) : ($this->list = $counter->get($this->editID));
    }
    
    #region counterTypeListByID: get associative array of counter types by id
    public function counterTypeListByID()
    {
        $this->getAll();
        foreach ($this->list as $item){
            $id = $item['id'];
            $counterType[$id] = $item['name'];
        }

        return $counterType;
    }
    #endregion
    
    #region listCounterType
    public function listCounterType()
    {
        return $this->getModel('counterTypeModel')->get()->all();

    }
    #endregion

    public function getCounterType() {
        $IsLogin = Session::IsLogin();
        return ($IsLogin) ? Session::getCounterTypeId() : '5';
    }

}

?>
