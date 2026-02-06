<?php
/**
 * Created by PhpStorm.
 * User: Developer10
 * Date: 9/22/2021
 * Time: 11:13 AM
 */

class reservationCityModel extends Model {
	public function __construct() {
		parent::__construct();
		$this->table = 'reservation_city_tb';
		$this->pk = 'id';
	}
	
	public function getAllTourCities($idCountry = null, $tourType = null, $route = null)
	{
		$dateNow = dateTimeSetting::jdate("Ymd",'','','','en');
		if ($route == 'dept'){
			
			$sql = " SELECT
                      C.id, C.name,C.name_en
                  FROM
                      {$this->table} AS C
                      INNER JOIN reservation_tour_tb AS T ON C.id = T.origin_city_id
                  WHERE
                      T.is_del = 'no' AND T.is_show = 'yes' AND T.start_date > '{$dateNow}'
                  ";
			
			if (isset($tourType) && $tourType == 'external'){
				$sql .= " AND C.id_country = '1' ";
			}
			
		} elseif ($route == 'return') {
			
			$sql = " SELECT
                      C.id, C.name
                  FROM
                      {$this->table} AS C
                      INNER JOIN reservation_tour_rout_tb AS TR ON C.id = TR.destination_city_id
                      INNER JOIN reservation_tour_tb AS T ON T.id = TR.fk_tour_id
                  WHERE
                      T.is_del = 'no' AND T.is_show = 'yes' AND TR.is_del = 'no' AND T.start_date > '{$dateNow}'
                  ";
			
			if (isset($tourType) && $tourType == 'external'){
				$sql .= " AND C.id_country != '1' ";
			}
		}
		if (isset($idCountry) && is_numeric($idCountry)) {
			$sql .= " AND C.id_country = '{$idCountry}' ";
		}
		$sql .= "
            GROUP BY C.id
            ORDER BY T.id DESC
          ";
		$result = $this->select($sql);
		
		return $result;
	}
}