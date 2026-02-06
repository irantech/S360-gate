<?php


class reportModel extends ModelBase
{
    protected $table = 'report_tb';

    public function getInfoFlightByFactorNumberWithGroupByDirection($factorNumber)
    {
        return $this->get()->where('factor_number',$factorNumber)->groupBy('direction')->all();
//        $sql = "SELECT * FROM {$this->table} WHERE factor_number = '{$factorNumber}' GROUP BY direction";
//        return parent::select($sql);
    }

    function GetInfoReportLocal($num) {

        $sql = "SELECT member_id, pid_private, origin_city, desti_city,irantech_commission, factor_number, request_number, tracking_code_bank, flight_type, airline_iata, api_id,IsInternal,direction,api_id,currency_code,currency_equivalent,"
            . " (SELECT COUNT(id)  FROM $this->table WHERE request_number='$num' ) AS count_id"
            . " FROM $this->table WHERE request_number='$num'" ;

       
        return parent::load($sql);
    }
}