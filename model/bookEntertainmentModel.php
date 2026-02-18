<?php


class bookEntertainmentModel extends Model
{
    protected $table = 'book_entertainment_tb';
    protected $pk = 'id';

    public function getReportEntertainmentAgency($agencyId)
    {
	    $result = $this->get()->where('agency_id',$agencyId)->all();
	    return $result;
	    
//        $sql = "SELECT * fROM {$this->table} WHERE agency_id='{$agencyId}'";

//        return parent::select($sql);
    }
}