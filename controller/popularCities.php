<?php
/**
 * Created by PhpStorm.
 * User: Developer10
 * Date: 2/14/2022
 * Time: 10:43 AM
 */
class popularCities {
	
	public function __construct() {
	
	}
	
	/**
	 * @return bool|popularCitiesModel
	 */
	protected function popularCitiesModel() {
		return Load::getModel('popularCitiesModel');
	}
	
	public function getPopularCities( $params ) {
//		$service_type = (isset($params['service_type'])) ? $params['service_type'] : null;
		$order_by = (isset($params['order_by'])) ? $params['order_by'] : 'id';
		$order = (isset($params['order'])) ? $params['order'] : 'DESC';
		if(!isset($params['order_by'])){
			$order = 'RAND()';
			$order_by = '';
		}
		$count = (isset($params['count'])) ? (int) $params['count'] : 10;
		$model = $this->popularCitiesModel();
		$result = $model->get();
		$result = $result->orderBy($order_by,$order);
		$result = $result->limit(0,$count);
		$result = $result->all();
		foreach ( $result as $key => $item ) {
			$result[$key]['image_url'] = SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/popular-cities/'.CLIENT_ID.'/'.$item['image_url'];
		}
		return $result;
	}
	
}