<?php
/**
 * Created by PhpStorm.
 * User: Developer10
 * Date: 9/15/2021
 * Time: 3:15 PM
 */

class busRouteModel extends ModelBase {
	
	protected $table = 'bus_route_tb';
	protected $pk = 'id';
	
	/**
	 * @return array
	 */
	public function getAllRoutes() {
		$sql = "SELECT * FROM {$this->table} WHERE iataCode !='' GROUP BY iataCode";
		
		return parent::select( $sql );
	}
	
	/**
	 * @param string $route_name
	 * @param bool   $single
	 *
	 * @return array|bool|mixed
	 */
	public function searchRoutes( $route_name = '', $single = false ) {
		if ( ! $route_name ) {
			return false;
		}
		$sql
			= "SELECT * FROM bus_route_tb WHERE iataCode !='' AND (name_fa LIKE '%{$route_name}%' OR name_en LIKE '%{$route_name}%' OR iataCode LIKE '%{$route_name}%' OR code LIKE '%{$route_name}%')";
		if ( $single ) {
			return parent::load( $sql );
		}
		
		return parent::select( $sql );
	}
	
}