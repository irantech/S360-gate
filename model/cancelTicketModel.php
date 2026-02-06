<?php


class cancelTicketModel extends Model
{
    protected  $table ='cancel_ticket_tb';
    protected $pk = 'id';

    public function getReportCancelAgency($agencyId)
    {
        $sql =" SELECT cancelDetail.* FROM  {$this->table} AS cancel"
             ." INNER JOIN cancel_ticket_details_tb AS cancelDetail ON cancelDetail.id = cancel.IdDetail"
             ." INNER JOIN members_tb AS members ON members.id = cancelDetail.MemberId "
             ." WHERE members.fk_agency_id='{$agencyId}' ";
        return parent::select($sql,'assoc');
    }
}