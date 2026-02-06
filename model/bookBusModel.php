<?php


class bookBusModel extends Model {
	protected $table = 'book_bus_tb';
	protected $pk = 'id';
	
	public function getReportBusAgency( $agencyId ) {
		
		$result = $this->get()->where('agency_id',$agencyId)->groupBy('passenger_factor_num')->all();
		return $result;

//		$sql = "SELECT * FROM {$this->table} WHERE agency_id='{$agencyId}' GROUP BY passenger_factor_num";

//		return parent::select( $sql, 'assoc' );
	}
}