<?php
/**
 * Created by PhpStorm.
 * User: Developer10
 * Date: 9/19/2021
 * Time: 5:25 PM
 */

class reservationCountryModel extends Model{

//	protected $table = '';
//	protected $pk;
    protected $table = 'reservation_country_tb' ;

	public function __construct() {
		parent::__construct();
		$this->table = 'reservation_country_tb';
		$this->pk = 'id';
	}
	
	public function getAllTourCountries( $tour_type = 'all', $route = 'dept' ) {
		$dateNow = dateTimeSetting::jdate("Ymd",'','','','en');
		$sql = '';
		if (isset($route) && $route == 'dept'){
			$sql = " SELECT
                  C.id, C.name,C.name_en
              FROM
                  {$this->table} AS C
                  INNER JOIN reservation_tour_tb AS T ON T.origin_country_id = C.id
              WHERE
                  T.is_del = 'no' AND T.is_show = 'yes' AND T.start_date > '{$dateNow}'
              ";
			
			if (isset($tour_type) && $tour_type == 'external'){
				$sql .= " AND C.id = '1' ";
			}
			
		} elseif (isset($route) && $route == 'return'){
			$sql = " SELECT
                  C.id, C.name
              FROM
                  {$this->table} AS C
                  INNER JOIN reservation_tour_rout_tb AS TR ON C.id=TR.destination_country_id
                  INNER JOIN reservation_tour_tb AS T ON T.id = TR.fk_tour_id
              WHERE
                  T.is_del = 'no' AND T.is_show = 'yes' AND TR.is_del = 'no' AND T.start_date > '{$dateNow}'
              ";
			
			if (isset($tour_type) && $tour_type == 'external'){
				$sql .= " AND C.id != '1' ";
			}
		}
		$sql .= "
            GROUP BY C.id
            ORDER BY T.id DESC
          ";
		return $this->select($sql);
	}

	
	
	
}