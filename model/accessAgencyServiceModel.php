<?php


class accessAgencyServiceModel extends Model
{
    protected $table = 'access_agency_service_tb';
    protected $pk = 'id';

    public function getAccessSubAgency($agency_id)
    {
            $sql = "SELECT * FROM {$this->table} WHERE agencyId='{$agency_id}'";
            return parent::select($sql);
    }
}