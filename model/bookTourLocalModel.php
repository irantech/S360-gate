<?php


class bookTourLocalModel extends Model
{
        protected $table = 'book_tour_local_tb';
        protected $pk ='id';

    public function getReportTourAgency($agencyId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE agency_id='{$agencyId}' GROUP BY factor_number";
        return parent::select($sql,'assoc');
    }
}