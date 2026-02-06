<?php

class LogErrorServer
{

    public $listBank;
    public $info;
    public $ClientId;

    /**
     * if form was send  "get data-> upload logo -> insert DB"
     */
    public function __construct()
    {

    }

    public function InfoShow()
    {

        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();
          $sql = " SELECT * FROM log_res_action_tb ORDER BY creation_date_int DESC ";


        $res = $ModelBase->select($sql) ;

        return $res;
    }

    public function ShowLog($id)
    {

        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();
        $sql = " SELECT * FROM log_res_action_tb WHERE id='{$id}' ORDER BY creation_date_int DESC ";


        $res = $ModelBase->load($sql) ;

        return $res;
    }



}

?>
