<?php

class temporary_local_tb extends Model {

    protected $table = 'temporary_local_tb';
    protected $pk = 'id';

    public  function get($token) {
        $result = [] ;
        //get lase flight that user chose, maybe he chose more than one time in a search
         $Sql = "select * from $this->table where  uniq_id = '$token' AND Direction = 'dept' ORDER BY id DESC";
        $resultDept = parent::load($Sql,'assoc');
        if(!empty($resultDept)) {
            $result['dept'] = $resultDept;
        }

        $SqlReturn= "select * from $this->table where  uniq_id = '$token' AND Direction = 'return' ORDER BY id DESC" ;
        $resultReturn = parent::load($SqlReturn,'assoc');
        if(!empty($resultReturn)) {
            $result['return'] = $resultReturn;
        }

        $SqlTwoWay= "select * from $this->table where  uniq_id = '$token' AND Direction = 'TwoWay' ORDER BY id DESC" ;
        $resultReturn = parent::load($SqlTwoWay,'assoc');
        if(!empty($resultReturn)) {
            $result['TwoWay'] = $resultReturn;
        }

        $SqlTwoWay= "select * from $this->table where  uniq_id = '$token' AND Direction = 'multi_destination' ORDER BY id DESC" ;
        $resultReturn = parent::load($SqlTwoWay,'assoc');
        if(!empty($resultReturn)) {
            $result['multi_destination'] = $resultReturn;
        }
        return $result;
    }


// public   function insert_temprory($data) {
//        $result = parent::insertLocal($data);
//        if ($result) {
//            return self::getLastId();
//        }
//    }

  public  function getLastId() {
        return parent::getLastId();
    }

   public function temporary_local_delete() {
        $d = date('Y-m-d H:i:s', time() - 3600); // تاریخ و ساعت 1 ساعت پیش		
        parent::delete("date_register < '" . $d . "'");
    }
    
    public function TemproryInfo($param) {
        
        Load::autoload('Model');
        
        $Model = new Model();
        
        $sql = " SELECT * FROM temporary_local_tb WHERE token_session='{$param}' ";

        $temprory_local = $Model->load($sql);
        
        return $temprory_local ;
    }

}
