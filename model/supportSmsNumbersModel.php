<?php

class supportSmsNumbersModel extends ModelBase{
	protected $table = 'support_sms_numbers_tb';
	protected $pk = 'id';

	public function getSupportNumbers( $service_name = 'flight' ) {
		$result = $this->get('phone_number')->where('active_'.$service_name,'1')->all();
		foreach ( $result as $item ) {
			$return[] = $item['phone_number'];
		}
		return $return;
	}
}