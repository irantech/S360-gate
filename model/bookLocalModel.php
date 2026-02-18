<?php


class bookLocalModel extends Model
{
    protected $table = 'book_local_tb';

    public function getInfoFlightByFactorNumberWithGroupByDirection($factorNumber)
    {
        $sql = "SELECT * FROM {$this->table} WHERE factor_number = '{$factorNumber}' GROUP BY direction";
        return parent::select($sql);
    }

    public function getTicketsByRequestNumber($requestNumber)
    {
        $sql = "SELECT * FROM {$this->table} WHERE request_number = '{$requestNumber}'";
        return parent::select($sql);

//        return $this->get()->where(array("request_number"=>$requestNumber))->all();
    }

}