<?php


class bookInsuranceModel extends Model
{
    protected $table = 'book_insurance_tb';
    protected $pk = 'id';

    public function getReportInsuranceAgency($agencyId)
    {
         $sql = "SELECT * FROM {$this->table} AS insurance"
        ." LEFT JOIN members_tb AS members ON members.id = insurance.member_id"
        ." WHERE members.fk_agency_id='{$agencyId}' GROUP BY insurance.factor_number";
        return parent::select($sql);
    }
}