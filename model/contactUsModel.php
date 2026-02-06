<?php

class contactUsModel extends Model{

    protected $table = 'contactus_tb';

    function getAll() {
        $result = parent::select("SELECT C.* , A.name_fa FROM {$this->table} C LEFT JOIN agency_tb A 
                    ON (C.agency_id = A.id) 
                    ORDER BY id DESC ");

        return $result;
    }

    /*function get($param) {

          $result = parent::load("SELECT C.* , A.name_fa FROM {$this->table} C LEFT JOIN agency_tb A 
                    ON (C.agency_id = A.id)  WHERE C.id = {$param}" );
        if($result['seen_at'] == null)
        {
            $date =  date( 'Y-m-d H:i:s', time() );

            $data = array(
                'seen_at' => $date
            );
            parent::update($data, "id='$param'");
        }
        return $result;
    }*/

    function insertContact($data) {
        $result = parent::insertLocal($data);
        if($result){
            return true;
        }
        else {
            return false;
        }
    }

    function getAgency() {
        $result = parent::select("SELECT C.* , A.* FROM {$this->table} C INNER JOIN agency_tb A 
                    ON (C.agency_id = A.id)  WHWRE C.agency_id = ".SUB_AGENCY_ID."
                    ORDER BY id ASC");

        return $result;
    }

}





?>