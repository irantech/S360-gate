<?php


class bookHotelLocalModel extends Model
{
    protected $table = 'book_hotel_local_tb';
    protected $pk = 'id';

    public function getReportHotelAgency($agencyId)
    {
	    $result = $this->get()->where('agency_id',$agencyId)->groupBy('factor_number')->all();
	    return $result;
    	
//        $sql = "SELECT * FROM {$this->table} WHERE agency_id='{$agencyId}' GROUP BY factor_number";
//        return parent::select($sql,'assoc');
    }
}