<?php


class subAgencyModel extends ModelBase
{
    protected $table = 'sub_agency_tb';
    protected $pk = 'id';
    protected $clientId = CLIENT_ID ;


    public function deleteSubAgency($data)
    {
        $condition = "agency_id='{$data['id']}' AND url_agency='{$data['domain']}'";
        return parent::delete($condition);
    }

    public function getSubAgencyInfo($data)
    {
        $checkExistSubAgencySql = "SELECT * FROM {$this->table} WHERE client_id='{$this->clientId}' AND agency_id='{$data['id']}' AND url_agency='{$data['domain']}'";
        return parent::load($checkExistSubAgencySql);
    }


    public function getSubAgencyInfoByDomain($data)
    {
       echo  $checkExistSubAgencySql = "SELECT * FROM {$this->table} WHERE client_id='{$this->clientId}' AND url_agency='{$data}'";
        return parent::load($checkExistSubAgencySql);
    }
}