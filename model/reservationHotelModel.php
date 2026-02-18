<?php
/**
 * Created by PhpStorm.
 * User: Developer10
 * Date: 9/22/2021
 * Time: 11:13 AM
 */

class reservationHotelModel extends Model {
	public function __construct() {
		parent::__construct();
		$this->table = 'reservation_hotel_tb';
		$this->pk = 'id';
	}
}