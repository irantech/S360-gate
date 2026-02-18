<?php


class clockTimezones extends clientAuth
{
	private $clock_timezone;

	public function __construct() {
		parent::__construct();

		$this->clock_timezone = 'clock_timezones_tb';
	}


	public function getClocks(){

		$clock_model = $this->getModel('clockTimezonesModel')->get() ;
		$result =  $clock_model->all();
		return  $result;
	}
	public function getClocksCount() {
		$clock_model = $this->getModel('clockTimezonesModel');
		return $clock_model->get([
			'count(id) as clock_count',
		], true)->find(false);
	}
}

?>

