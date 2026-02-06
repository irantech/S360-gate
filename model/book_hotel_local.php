<?php

class book_hotel_local_tb extends Model {

    protected $table = 'book_hotel_local_tb';
//     protected $pk = 'id';

//     public function get($id) {
//         $result = parent::load("SELECT * FROM $this->table  WHERE $this->pk='$id'  OR request_number='$id'");
//         return $result;
//     }


    function getHotelInfo($factor_number) {

        $sql = "SELECT * FROM $this->table  WHERE  request_number='$factor_number' AND status='BookedSuccessfully' ";
        
        $result = parent::select($sql);

        return $result;
    }
    
    

}
