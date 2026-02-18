<?php 
class bookshow extends Model{
	protected $table = 'credit_detail_tb';
	protected $pk = 'id';
	
	function  getAll($agencyID){  
		$result=parent::select("select * from $this->table where  fk_agency_id='$agencyID' ORDER BY $this->pk ASC");
		return $result;
	}
	
	function get($id){
		 $result=parent::load("select * from $this->table where id='$id' ");
		return $result; 
	}	
	
	function insert($agencyID,$credit,$becauseOf,$date,$comment){	
		$data=array(
				'fk_agency_id' =>"'".$agencyID."'",
				'credit' =>"'".$credit."'",
				'type' =>"'".$becauseOf."'",
				'credit_date' =>"'".$date."'",
				'comment' =>"'".$comment."'"
		);
		return parent::insert($data);
	}
}