<?php
/**
 * Created by PhpStorm.
 * User: Developer10
 * Date: 9/19/2021
 * Time: 12:20 PM
 */

abstract class BankBase {
	/**
	 * @param array $request_data
	 */
	abstract public function requestPayment( $request_data = [] );
	
	/**
	 * @param array $request_data
	 *
	 * @return mixed
	 */
	abstract public function verifyPayment( $verify_params = [] );
	
	/**
	 * @param bool $success
	 * @param array $data
	 * @param string $message
	 *
	 * @return array
	 */
	protected function showResult( $success = false, $data = [], $message = '' ) {
		return [
			'success' => (boolean) $success,
			'data'    => $data,
			'message' => $message
		];
	}
	/**
	 * @param array $fields
	 * @param array $conditions
	 * @param string $table
	 * @param bool $single
	 *
	 * @return array|bool|mixed
	 */
	public function _selectFromTb( $fields = [], $conditions = [], $model = '', $single = false ) {
        /** @var reportModel $get_model */
        $get_model = Load::getModel($model);
		
		if ( ! $get_model ) {
			return false;
		}
        $result = $get_model->get($fields);
        foreach ($conditions as $key => $value) {
            $result = $result->where($key, $value);
        }
        if($single){
            return $result->find();
        }
        return $result->all();

	}
	public function getDetailsForExteranlBank( $factor_number = null, $pay_for = null ) {
		
		$response = [
			'firstName' => 'TestName',
			'lastName'  => 'TestFamily',
			'mobile'    => '09129409530',
			'email'     => 'info@iran-tech.com',
			'city'      => 'Tehran',
			'country'   => 'IRAN',
			'address'   => 'تهران ایران',
			'postalCode'=> sprintf('%05d',mt_rand( 10000, 99999 )),
			'currency'=> Session::getCurrency()
		];
		
		/*
		 * 'hotelLocal'
		 * 'package'
		 * 'hotelApp'
		 *
		 * 'local'
		 * 'ReservationTicket'
		 *
		 * 'insurance'
		 *
		 * 'reservationTourLocal'
		 *
		 * 'europcarLocal'
		 *
		 * 'reservationVisa'
		 *
		 * 'train'
		 *
		 * 'gasht'
		 *
		 * 'busTicket'
		 *
		 * 'Entertainment'
		 *
		 *
		 * 'Admin'
		 * 'clientCredit'
		 * 'App'
		 *
		 * */
		switch ( $pay_for ) {
			case 'hotelLocal' :
			case 'package' :
			case 'hotelApp' :
				$table                 = TYPE_ADMIN ? 'reportHotelModel' : 'bookHotelLocalModel';
				$conditions            = [ 'factor_number' => $factor_number ];
				$detail                = self::_selectFromTb( [], $conditions, $table, true );
				$member                = functions::infoMember( $detail['member_id'] );
				$response['firstName'] = $member['name'] ? $member['name'] : $response['firstName'];
				$response['lastName']  = $member['family'] ? $member['family'] : $response['lastName'];
				$response['mobile']    = $member['mobile'] ? $member['mobile'] : $response['mobile'];
				$response['email']     = $member['email'] ? $member['email'] : $response['email'];
				$response['city']      = $detail['city_name'] ? $detail['city_name'] : $response['city'];
				$response['address']   = $detail['hotel_address'] ? $detail['hotel_address'] : $response['address'];
				
				break;
			case 'local':
			case 'ReservationTicket':
				$table      = TYPE_ADMIN ? 'reportModel' : 'bookLocalModel';
				$conditions            = [ 'factor_number' => $factor_number ];
				$detail                = self::_selectFromTb( [], $conditions, $table, true );
				$member                = functions::infoMember( $detail['member_id'] );
				$response['firstName'] = $member['name'] ? $member['name'] : $response['firstName'];
				$response['lastName']  = $member['family'] ? $member['family'] : $response['lastName'];
				$response['mobile']    = $member['mobile'] ? $member['mobile'] : $response['mobile'];
				$response['email']     = $member['email'] ? $member['email'] : $response['email'];
				$response['city']      = $detail['desti_city'] ? $detail['desti_city'] : $response['city'];
				
				break;
			case 'insurance' :
				$table      = TYPE_ADMIN ? 'reportInsuranceModel' : 'bookInsuranceModel';
				$conditions = [ 'factor_number' => $factor_number ];
				$detail     = self::_selectFromTb( [], $conditions, $table, true );
				$member     = functions::infoMember( $detail['member_id'] );
				$response['firstName'] = $member['name'] ? $member['name'] : $response['firstName'];
				$response['lastName']  = $member['family'] ? $member['family'] : $response['lastName'];
				$response['mobile']    = $member['mobile'] ? $member['mobile'] : $response['mobile'];
				$response['email']     = $member['email'] ? $member['email'] : $response['email'];
				
				break;
			case 'reservationTourLocal':
				$table      = TYPE_ADMIN ? 'reportTourModel' : 'bookTourLocalModel';
				$conditions = [ 'factor_number' => $factor_number ];
				$detail     = self::_selectFromTb( [], $conditions, $table, true );
				$member     = functions::infoMember( $detail['member_id'] );
				
				$response['firstName'] = $member['name'] ? $member['name'] : $response['firstName'];
				$response['lastName']  = $member['family'] ? $member['family'] : $response['lastName'];
				$response['mobile']    = $member['mobile'] ? $member['mobile'] : $response['mobile'];
				$response['email']     = $member['email'] ? $member['email'] : $response['email'];
				
				break;
			case 'europcarLocal':
				$table      = TYPE_ADMIN ? 'reportEuropcarModel' : 'bookEuropcarLocalModel';
				$conditions = [ 'factor_number' => $factor_number ];
				$detail     = self::_selectFromTb( [], $conditions, $table, true );
				$member     = functions::infoMember( $detail['member_id'] );
				
				$response['firstName'] = $member['name'] ? $member['name'] : $response['firstName'];
				$response['lastName']  = $member['family'] ? $member['family'] : $response['lastName'];
				$response['mobile']    = $member['mobile'] ? $member['mobile'] : $response['mobile'];
				$response['email']     = $member['email'] ? $member['email'] : $response['email'];
				
				break;
			case 'reservationVisa' :
			
				$table      = TYPE_ADMIN ? 'reportVisaModel' : 'bookVisaModel';
				$conditions = [ 'factor_number' => $factor_number ];
				$detail     = self::_selectFromTb( [], $conditions, $table, true );
				$member     = functions::infoMember( $detail['member_id'] );
				
				$response['firstName'] = $member['name'] ? $member['name'] : $response['firstName'];
				$response['lastName']  = $member['family'] ? $member['family'] : $response['lastName'];
				$response['mobile']    = $member['mobile'] ? $member['mobile'] : $response['mobile'];
				$response['email']     = $member['email'] ? $member['email'] : $response['email'];
				
				break;
			case 'train' :
				$table      = TYPE_ADMIN ? 'reportTrainModel' : 'bookTrainModel';
				$conditions = [ 'factor_number' => $factor_number ];
				$detail     = self::_selectFromTb( [], $conditions, $table, true );
				$member     = functions::infoMember( $detail['member_id'] );
				
				$response['firstName'] = $member['name'] ? $member['name'] : $response['firstName'];
				$response['lastName']  = $member['family'] ? $member['family'] : $response['lastName'];
				$response['mobile']    = $member['mobile'] ? $member['mobile'] : $response['mobile'];
				$response['email']     = $member['email'] ? $member['email'] : $response['email'];
				
				break;
			case 'gasht':
				$table      = TYPE_ADMIN ? 'reportGashtModel' : 'bookGashtLocalModel';
				$conditions = [ 'factor_number' => $factor_number ];
				$detail     = self::_selectFromTb( [], $conditions, $table, true );
				$member     = functions::infoMember( $detail['member_id'] );
				
				$response['firstName'] = $member['name'] ? $member['name'] : $response['firstName'];
				$response['lastName']  = $member['family'] ? $member['family'] : $response['lastName'];
				$response['mobile']    = $member['mobile'] ? $member['mobile'] : $response['mobile'];
				$response['email']     = $member['email'] ? $member['email'] : $response['email'];
				
				break;
			case 'busTicket' :
				$table      = TYPE_ADMIN ? 'reportBusModel' : 'bookBusModel';
				$conditions = [ 'passenger_factor_num' => $factor_number ];
				$detail     = self::_selectFromTb( [], $conditions, $table, true );
				$member     = functions::infoMember( $detail['member_id'] );
				
				$response['firstName'] = $member['name'] ? $member['name'] : $response['firstName'];
				$response['lastName']  = $member['family'] ? $member['family'] : $response['lastName'];
				$response['mobile']    = $member['mobile'] ? $member['mobile'] : $response['mobile'];
				$response['email']     = $member['email'] ? $member['email'] : $response['email'];
				
				break;
			case 'Entertainment' :
				$table      = TYPE_ADMIN ? 'reportEntertainmentModel' : 'bookEntertainmentModel';
				$conditions = [ 'factor_number' => $factor_number ];
				$detail     = self::_selectFromTb( [], $conditions, $table, true );
				$member     = functions::infoMember( $detail['member_id'] );
				
				$response['firstName'] = $member['name'] ? $member['name'] : $response['firstName'];
				$response['lastName']  = $member['family'] ? $member['family'] : $response['lastName'];
				$response['mobile']    = $member['mobile'] ? $member['mobile'] : $response['mobile'];
                $response['email']     = $member['email'] ? $member['email'] : $response['email'];
				
				break;
			default :

                break;
		}
		
		return $response;
	}
}