<?php 
class discount_tb extends ModelBase{
	protected $table = 'discount_tb';
	protected $pk = 'id';
	
	/* function  getAll(){  
		$result=parent::select("select * from $this->table where del='no'  ORDER BY $this->pk ASC");
		return $result;
	}
	 */
	function discount_insert($amount,$fk_counter_type_id,$fk_airline_id){
		$data=array(
				'amount' =>"'".$amount."'",
				'fk_counter_type_id' =>"'".$fk_counter_type_id."'",
				'fk_airline_id' =>"'".$fk_airline_id."'"	
		);
		return parent::insert($data);		
	}
		
	function get($airlineID,$counterTypeID){
		$result=parent::load("select * from $this->table where fk_counter_type_id = '$counterTypeID' and fk_airline_id='$airlineID' and  del='no'");
		return $result['amount'];
	}
	
/* 	function discount_delete($id){
		//return parent::delete("id='$id'");
		$data=array(
			'del'=>"'yes'"
		);
		return parent::update($data, "id='$id'");
	}
	*/
	function discount_update($airlinID,$counterTypeID,$amount){
		$data=array(
				'amount' =>"'".$amount."'"			
		);
		return parent::update($data, "fk_counter_type_id='".$counterTypeID."' and fk_airline_id='".$airlinID."'");
	} 
	
	
}