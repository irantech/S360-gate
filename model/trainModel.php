<?php


class trainModel extends Model
{
    protected $table = 'book_train_tb';
    protected $pk ='id';

    public function getReportTrainAgency($agencyId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE agency_id='{$agencyId}' GROUP BY factor_number";
        return parent::select($sql,'assoc');
    }
}