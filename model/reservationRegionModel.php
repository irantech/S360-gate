<?php
/**
 * Created by PhpStorm.
 * User: Developer10
 * Date: 9/22/2021
 * Time: 11:20 AM
 */

class reservationRegionModel extends Model {
	function __construct() {
		parent::__construct();
		$this->table = 'reservation_region_tb';
		$this->pk = 'id';
		
	}
	
	public function getAllTourRegions( $idCity = null, $tourType = null, $route = null ) {
		$dateNow = dateTimeSetting::jdate("Ymd",'','','','en');
		$sql = "SELECT * FROM {$this->table} WHERE 1=1 ";
		
		if ($route == 'dept'){
			
			$sql = " SELECT
                      R.id, R.name
                  FROM
                      {$this->table} AS R
                      INNER JOIN reservation_tour_tb AS T ON R.id=T.origin_region_id
                  WHERE
                      T.is_del = 'no' AND T.is_show = 'yes' AND T.start_date > '{$dateNow}'
                  ";
		} elseif ($route == 'return') {
			
			$sql = " SELECT
                      R.id, R.name
                  FROM
                      {$this->table} AS R
                      INNER JOIN reservation_tour_rout_tb AS TR ON R.id=TR.destination_region_id
                      INNER JOIN reservation_tour_tb AS T ON T.id = TR.fk_tour_id
                  WHERE
                      T.is_del = 'no' AND T.is_show = 'yes' AND TR.is_del = 'no' AND T.start_date > '{$dateNow}'
                  ";
		}
		if (isset($idCity) && is_numeric($idCity)) {
			$sql .= " AND R.id_city = '{$idCity}' ";
		}
		$sql .= "
            GROUP BY R.id
            ORDER BY T.id DESC
          ";
		$result = $this->select($sql);
		
		return $result;
	}
}