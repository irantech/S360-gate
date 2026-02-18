<?php

/**
 * Class apiExternalHotel
 * @property apiExternalHotel $apiExternalHotel
 */
class apiExternalHotel extends ApiHotelCore {
	
	protected $urlApi;
	public $requestUrl;
	
	function __construct() {
		parent::__construct();
	}
	
	public function searchHotel( $param = [] ) {



		$start = microtime(true);
//		functions::insertLog('searchHotel '.$start,'times');
//		functions::insertLog('searchHotel Param => '.json_encode($param),'times');
//		$param['startDate'] = $param['startDate'] ? $param['startDate'] : dateTimeSetting::jtoday();
//		$param['calendar_type'] = isset($param['calendar_type']) ? $param['calendar_type'] : 'jalali';
//
//		if(SOFTWARE_LANG != 'fa'){
//			$param['startDate'] = $param['startDate'] ? $param['startDate'] : date('Y-m-d');
//			$param['calendar_type'] = '';
//		}
//
		if ( ! $this->checkStartDate( $param['startDate'],$param['calendarType'] ) ) {
            functions::insertLog('check start date has error'.$param['startDate'] .' ct=>'.$param['calendarType'],'times');
			return $this->showError( functions::Xmlinformation( 'InvalidStartDate' ), 400 );
		}
		$searchParams['city']      = $param['city'];
		$searchParams['calendarType']      = $param['calendarType'];
		$searchParams['isInternal']      = false;
		if(isset($param['countryNameEn'])){
			$searchParams['Country'] = $param['countryNameEn'];
		}
		$searchParams['startDate'] = $param['startDate'];
		$searchParams['endDate'] = $param['endDate'];
		$searchParams['nationality'] = isset($param['nationality']) ? $param['nationality'] : 'IR';
		$finalChildCount           = $finalAdultCount = [];
        functions::insertLog('searchHotel $searchParams before rooms => '.json_encode($searchParams),'times');
		foreach ( json_decode( $param['rooms'], true ) as $key => $room ) {
			$childCount = $adultCount = 0;
			$age = [];
			foreach ( $room as $passenger ) {
				
				if($passenger['PassengerAge'] != 0){
                    if ($passenger['PassengerAge'] <= 12) {
                        $age[] = $passenger['PassengerAge'];
                    }
				}
				
				if ( $passenger['PassengerAge'] > 12 ) {
					$adultCount ++;
				} else {
					$childCount ++;
				}
			}
			$searchParams['roomsArray'][] = [ 'Adults' => $adultCount, 'Children' => $childCount, 'Ages' => $age ];
		}
		
//		$searchParams['rooms'] = $param['rooms'];

//		$searchParams['roomsArray'] = json_encode( [ 'Adults' => $finalAdultCount, 'Children' => $finalChildCount ] );
		
		//		$searchParams['adultsCount'] = 1;
		//		$datajson = json_encode( $searchParams);
		//		$searchParams['AdultsCount'] = $finalAdultCount;
		//		$searchParams['ChildCount'] = $finalChildCount;
		functions::insertLog(json_encode($searchParams,256|64),'external_hotel_search_params');
        functions::insertLog('searchHotel $searchParams before hotelList => '.json_encode($searchParams),'times');

        return $this->hotelList( $searchParams );
	}
	
	private function curlExecutionPost( $url, $data ) {
		functions::insertLog( "request url => " . $url, 'apiExternalHotel' );
		functions::insertLog( "request data => " . $data, 'apiExternalHotel' );
		
		$handle = curl_init( $url );
		curl_setopt( $handle, CURLOPT_POST, true );
		curl_setopt( $handle, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $handle, CURLOPT_POSTFIELDS, $data );
		curl_setopt( $handle, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json' ) );
		$result = curl_exec( $handle );
		
		functions::insertLog( "response data => " . $result, 'apiExternalHotel' );
		
		return json_decode( $result, true );
	}
	
	
	#region login
	public function login( $jsonData ) {
		try {
			$url    = $this->requestUrl . "Login";
			$result = $this->curlExecutionPost( $url, $jsonData );
			if ( ! empty( $result['LoginID'] ) ) {
				return $result['LoginID'];
			} else {
				return false;
			}
			
		} catch ( Exception $e ) {
			
			$textError = json_decode( $e->getMessage() );
			functions::insertLog( $textError, 'apiExternalHotel' );
			
			return $textError;
		}
		
	}
	#endregion
	
	
	#region hotelCityList
	public function hotelCityList( $jsonData ) {
		try {
			$url    = $this->requestUrl . "HotelCityList";
			$result = $this->curlExecutionPost( $url, $jsonData );
			
			return $result;
			
		} catch ( Exception $e ) {
			
			$textError = json_decode( $e->getMessage() );
			functions::insertLog( $textError, 'apiExternalHotel' );
			
			return $textError;
		}
	}
	#endregion
	
	
	#region HotelSearch
	public function hotelSearch( $jsonData ) {
		try {
			$url    = $this->requestUrl . "HotelSearch";
			$result = $this->curlExecutionPost( $url, $jsonData );
			
			return $result;
			
		} catch ( Exception $e ) {
			
			$textError = json_encode( $e->getMessage() );
			functions::insertLog( $textError, 'apiExternalHotel' );
			
			return $textError;
		}
	}
	#endregion
	
	
	#region hotelDetail
	public function hotelDetail( $jsonData ) {
		try {
			$url    = $this->requestUrl . "HotelDetail";
			$result = $this->curlExecutionPost( $url, $jsonData );
			
			return $result;
			
		} catch ( Exception $e ) {
			
			$textError = json_encode( $e->getMessage() );
			functions::insertLog( $textError, 'apiExternalHotel' );
			
			return $textError;
		}
	}
	#endregion
	
	
	#region HotelPriceDetail
	public function hotelPriceDetail( $jsonData ) {
		try {
			$url    = $this->requestUrl . "HotelPriceDetail";
			$result = $this->curlExecutionPost( $url, $jsonData );
			
			return $result;
			
		} catch ( Exception $e ) {
			
			$textError = json_encode( $e->getMessage() );
			functions::insertLog( $textError, 'apiExternalHotel' );
			
			return $textError;
		}
	}
	#endregion
	
	#region hotelPreReserve
	public function hotelPreReserve( $jsonData ) {
		try {
			$url    = $this->requestUrl . "HotelPreReserve";
			$result = $this->curlExecutionPost( $url, $jsonData );
			
			return $result;
			
		} catch ( Exception $e ) {
			
			$textError = json_encode( $e->getMessage() );
			functions::insertLog( $textError, 'apiExternalHotel' );
			
			return $textError;
		}
	}
	#endregion
	
	
	#region hotelReserve
	public function hotelReserve( $jsonData ) {
		try {
			if ( isset( $_SERVER["HTTP_HOST"] ) && ( strpos( $_SERVER["HTTP_HOST"], '192.168.1.100' ) !== false || strpos( $_SERVER["HTTP_HOST"], 'online.1011.ir' ) !== false || strpos( $_SERVER["HTTP_HOST"], 'agency.1011.ir' ) !== false || strpos( $_SERVER["HTTP_HOST"], 'indobare.com' ) !== false || strpos( $_SERVER["HTTP_HOST"], 'iran-tech.com' ) !== false || strpos( $_SERVER["HTTP_HOST"], 'boomeem.com' ) !== false || strpos( $_SERVER["HTTP_HOST"], 'test.1011.ir' ) !== false ) ) {//local && test
				$this->requestUrl = 'http://safar360.com/CoreTest/ExternalHotel/';
			} else {
//				$this->requestUrl = 'http://safar360.com/Core/ExternalHotel/';
				$this->requestUrl = 'http://safar360.com/Core/ExternalHotel/';
			}
			
			$url    = $this->requestUrl . "HotelReserve";
			$result = $this->curlExecutionPost( $url, $jsonData );
			
			return $result;
			
		} catch ( Exception $e ) {
			
			$textError = json_encode( $e->getMessage() );
			functions::insertLog( $textError, 'apiExternalHotel' );
			
			return $textError;
		}
	}
	#endregion
	
	
	#region productCancelationDetail
	public function productCancelationDetail( $jsonData ) {
		try {
			$url    = $this->requestUrl . "ProductCancelationDetail";
			$result = $this->curlExecutionPost( $url, $jsonData );
			
			return $result;
			
		} catch ( Exception $e ) {
			
			$textError = json_encode( $e->getMessage() );
			functions::insertLog( $textError, 'apiExternalHotel' );
			
			return $textError;
		}
	}
	#endregion
	
	
	#region productCancelation
	public function productCancelation( $jsonData ) {
		try {
			$url    = $this->requestUrl . "ProductCancelation";
			$result = $this->curlExecutionPost( $url, $jsonData );
			
			return $result;
			
		} catch ( Exception $e ) {
			
			$textError = json_encode( $e->getMessage() );
			functions::insertLog( $textError, 'apiExternalHotel' );
			
			return $textError;
		}
	}
	#endregion
	
	
}


?>