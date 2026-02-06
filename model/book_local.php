<?php

class book_local_tb extends Model {

    protected $table = 'book_local_tb';
    protected $pk = 'id';

    public function get($id) {
        $result = parent::load("SELECT * FROM $this->table  WHERE $this->pk='$id'  OR request_number='$id'");
        return $result;
    }

    function updateBank($tracking_code_bank, $categoryNum) {

        $data = array(
            'tracking_code_bank' => $tracking_code_bank ,
            'payment_date' => Date('Y-m-d H:i:s')
        );

        $condition = " factor_number='" . $categoryNum . "' AND successfull = 'bank' ";

        $ModelBase = Load::library('ModelBase');

        $ModelBase->setTable('report_tb');
        $ModelBase->update($data,$condition);

        return parent::update($data, $condition);

    }

    function BookInfo($num) {
        $result = parent::load("SELECT * FROM $this->table WHERE request_number='$num'");
        return $result;
    }

    function getWithCategory($num) {
        if (TYPE_ADMIN == '1') {
            Load::autoload('ModelBase');
            $ModelBase = new ModelBase();
            $result = $ModelBase->select("SELECT * FROM report_tb WHERE request_number='$num'");
        } else {
            $result = parent::select("SELECT * FROM $this->table WHERE request_number='$num'");
        }
        return $result;
    }

    function GetInfoBookLocal($num) {

         $sql = "SELECT member_id, pid_private, origin_city, desti_city,irantech_commission, factor_number, request_number, tracking_code_bank, flight_type, airline_iata, api_id,IsInternal,direction,api_id,currency_code,currency_equivalent,"
            . " (SELECT COUNT(id)  FROM $this->table WHERE request_number='$num' ) AS count_id"
            . " FROM $this->table WHERE request_number='$num'" ;
        return parent::load($sql);
    }

    function update_book($factor_number, $info) {
        $data['successfull'] = 'book';
        $data['pnr'] = $info['AirlinePnr'];
        $data['eticket_number'] = $info['eticket_number'];


        $condition = " factor_number='" . $factor_number . "'";
        return parent::update($data, $condition);
    }

    function getTicketInfo($param) {

         $sql = "SELECT * FROM $this->table  WHERE  (request_number='{$param}' OR factor_number='{$param}') AND (successfull='book' OR successfull='private_reserve')";
        $result = parent::select($sql);

        return $result;
    }


    public function count_costumer($id) {
        $result = parent::load("SELECT  count(id) AS counted FROM $this->table  WHERE  member_id='$id' AND successfull='book' ");
        return $result;
    }

    public function updateToCredit($factorNumber) {
        $data = array(
            'successfull' => 'credit'
        );
        $condition = " factor_number = '" . $factorNumber . "'  AND (successfull <> 'book' AND successfull <> 'private_reserve') ";

        $ModelBase = Load::library('ModelBase');
        $ModelBase->setTable('report_tb');
        $ModelBase->update($data,$condition);

        return parent::update($data, $condition);
    }

    public function getReportFlightAgency($agencyId)
    {
        $sqlFlightAgency = "SELECT * FROM book_local_tb WHERE agency_id='{$agencyId}' GROUP BY request_number" ;

        return  parent::select($sqlFlightAgency);
    }
}
