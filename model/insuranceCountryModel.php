<?php
/**
 * Created by PhpStorm.
 * User: Developer10
 * Date: 9/15/2021
 * Time: 5:34 PM
 */

class insuranceCountryModel extends ModelBase {
	protected $table = 'insurance_country_tb';
	protected $pk = 'id';
	
	public function getAllCountries(){
		return $this->get()->groupBy('abbr')->orderBy('priority=0,priority', 'ASC')->all();
	}
	
}