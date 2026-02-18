<?php


class trainApi extends clientAuth {
	
	protected $serverUrl;
	protected $userName;
	protected $Model;
	protected $ModelBase;
	
	public function __construct() {
		parent::__construct();
//		$this->serverUrl = "http://192.168.1.100/CoreTestDeveloper/V-1/Train/";
//        $this->serverUrl = "http://safar360.com/Core/V-1/Train/";
        $this->serverUrl = "http://safar360.com/Core/V-1/Train/";
		$InfoSources     = parent::TrainAuth();
		$this->Model     = Load::library( 'Model' );
		$this->ModelBase = Load::library( 'ModelBase' );
		
		if ( ! empty( $InfoSources ) ) {
			$this->userName = $InfoSources['Username'];
		}
	}

	public function search( $data ) {
		
		$url = $this->serverUrl . "search";
		
		$dataSend = array(
			'FromStation'   => ( $data['type'] == 'dept' ) ? $data['FromStation'] : $data['ToStation'],
			'ToStation'     => ( $data['type'] == 'dept' ) ? $data['ToStation'] : $data['FromStation'],
			'MoveDate'      => $data['MoveDate'],
			'TypePassenger' => $data['TypePassenger'],
			'AdultCount'    => isset( $data['AdultCount'] ) ? $data['AdultCount'] : 1,
			'ChildCount'    => isset( $data['ChildCount'] ) ? $data['ChildCount'] : 0,
			'InfantCount'   => isset( $data['InfantCount'] ) ? $data['InfantCount'] : 0,
		);
		
		$dataSendJson = json_encode( $dataSend,256 | 64 );
		
		functions::insertLog( __METHOD__ . ' PARAMS - ' . $dataSendJson, 'train' );
		$curl_result = functions::curlExecution( $url, $dataSendJson, array( 'auth_user' => $this->userName, 'auth_pass' => $this->userName ) );
		functions::insertLog( __METHOD__ . ' - ' . json_encode( $curl_result, 256 | 64 ), 'train' );
		
		return $curl_result;
	}
	
	public function LockSeat( $params ) {
		$url = $this->serverUrl . "lockSeat";

		$dataSendJson = json_encode( $params,256 | 64 );
		//		functions::insertLog( 'Request==>' . $code . '==>' . $dataSendJson, 'log_train_LockSeat' );
		functions::insertLog( __METHOD__ . ' PARAMS - ' . $dataSendJson, 'train' );
		$result = functions::curlExecution( $url, $dataSendJson, array( 'auth_user' => $this->userName, 'auth_pass' => $this->userName ) );
		//		functions::insertLog( 'response==>' . $code . '==>' . json_encode( $result ), 'log_train_LockSeat' );
		//		functions::insertLog( '***************************************************', 'log_train_LockSeat' );
		functions::insertLog( __METHOD__ . ' - ' . json_encode( $result,256 | 64 ), 'train' );
		if ( ! isset( $result['statusError'] ) ) {
			return $result;
		}
		
		return array(
			'result_status'  => 'Error',
			'result_message' => 'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
		);
	}
	
	public function GetOptionalService($params) {
		$url          = $this->serverUrl . "getOptionalService";
		$dataSendJson = json_encode( $params,256 | 64 );
		functions::insertLog( __METHOD__ . ' PARAMS - ' . $dataSendJson, 'train' );
		$return = functions::curlExecution( $url, $dataSendJson, array( 'auth_user' => $this->userName, 'auth_pass' => $this->userName ) );
		functions::insertLog( __METHOD__ . ' - ' . json_encode( $return, 256 | 64 ), 'train' );
		
		return $return;
	}
	
	public function ViewPriceTicket( $params ) {
		$url          = $this->serverUrl . "viewPriceTicket";
		$dataSendJson = json_encode( $params ,256 | 64);
		functions::insertLog( __METHOD__ . ' PARAMS - ' . $dataSendJson, 'train' );
		$result = functions::curlExecution( $url, $dataSendJson, array( 'auth_user' => $this->userName, 'auth_pass' => $this->userName ) );
		functions::insertLog( __METHOD__ . ' - ' . json_encode( $result,256 | 64 ), 'train' );
		if ( isset( $result['Success'] ) || $result['Success'] ) {
			return $result;
		}
		
		return array(
			'result_status'  => 'Error',
			'result_message' => 'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
		);
	}
	
	public function RegisterTicket( $params ) {
		$url = $this->serverUrl . "registerTicket";
		/** @var \bookTrainModel $bookTrainModel */
		$bookTrainModel = Load::getModel( 'bookTrainModel' );
		
		$InfoTickets = $bookTrainModel
			->get()
			->where( 'TicketNumber', $params['TicketNumber'] )
			->where( 'TicketNumber', '', '<>' )
			->where( 'TicketNumber', '0', '<>' )->all();
		
		
		if ( ! empty( $InfoTickets ) && is_array($InfoTickets) ) {
			$charter = 0;
			$names = $families = $nationalcodes = $birthdates = $ticketNumbers = $Food = $tariff = $tcktType = $Srvcs = array();
			foreach ( $InfoTickets AS $data ) {
				$names[]         = $data['passenger_name'];
				$families[]      = $data['passenger_family'];
				$nationalcodes[] = ( $data['passenger_national_code'] == '' ? $data['passportNumber'] : $data['passenger_national_code'] );
				$birthdates[]    = str_replace( '-', '', $data['passenger_birthday'] );
				$ticketNumbers[] = $data['TicketNumber'];
				if ( $data['extra_chair'] == 1 ) {
					$tariff[] = 5;
					$charter  = 1;
				} elseif ( $data['Adult'] == 1 ) {
					$tariff[] = 1;
				} elseif ( $data['Child'] == 1 ) {
					$tariff[] = 2;
				} else {
					$tariff[] = 6;
				}
				if ( $data['ServiceTypeCode'] != '' ) {
					$Food[] = $data['ServiceTypeCode'];
				} else {
					$Food[] = 0;
				}
				$OrderNumber[] = '';
				$tcktType[]    = 1;
			}
			$Srvcs[][] = 0;
			
			$paramsRegisterTicket = array(
				//				'userName'      => $this->userName,
				'TicketNumber'  => $params['TicketNumber'],
				'names'         => $names,
				'families'      => $families,
				'nationalcodes' => $nationalcodes,
				'mobile_buyer'  => ! empty( $InfoTickets[0]['mobile_buyer'] ) ? $InfoTickets[0]['mobile_buyer'] : $InfoTickets[0]['member_mobile'],
				'tcktType'      => $tcktType,
				'tariff'        => $tariff,
				'Srvcs'         => $Srvcs,
				'ticketNumbers' => $ticketNumbers,
				'Food'          => $Food,
				'birthdates'    => $birthdates,
				'charter'       => $charter,
				'trainNumber'   => $InfoTickets[0]['TrainNumber']
			);
			$dataSendJson         = json_encode( $paramsRegisterTicket,256 | 64 );
			functions::insertLog( __METHOD__ . ' PARAMS - ' . $dataSendJson, 'train' );
			$registerTicket = functions::curlExecution( $url, $dataSendJson, array( 'auth_user' => $this->userName, 'auth_pass' => $this->userName ) );
			functions::insertLog( __METHOD__ . ' - ' . json_encode( $registerTicket,256 | 64 ), 'train' );
			
			if ( ! isset( $registerTicket['status'] ) ) {
				$model                 = Load::library( 'Model' );
				$ModelBase             = Load::library( 'ModelBase' );
				$data['is_registered'] = '1';
				$condition             = " requestNumber='{$params['code']}'";
				$bookTrainModel->updateWithBind($data,$condition);
//				$model->setTable( 'book_train_tb' );
//				$model->update( $data, $condition );
//				$ModelBase->setTable( 'report_train_tb' );
				$ModelBase->updateWithBind( $data, $condition,'report_train_tb' );
				
				return $registerTicket['RegisterTiketResult'];
			}
			
			return array(
				'result_status'  => 'Error',
				'result_message' => 'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
			);
			
		}
		
	}
	
	public function GetTicketAmount( $params ) {
		
		$url = $this->serverUrl . "getTicketAmount";
		
		$getTicketAmountParams = array(
			'P1'       => $params['TicketNumberDept'],
			'P2'       => ( ! empty( $params['TicketNumberReturn'] ) && $params['TicketNumberReturn'] > 0 ) ? $params['TicketNumberReturn'] : '-1',
			'RequestNumber'=>$params['code'],
		);
		$dataSendJson          = json_encode( $getTicketAmountParams,256 | 64 );
//		functions::insertLog( 'request==>' . $params['code'] . '==>' . $dataSendJson, 'log_train_GetTicketAmount' );
		functions::insertLog( __METHOD__ . ' PARAMS - ' . $dataSendJson, 'train' );
		$getAmountTicket = functions::curlExecution( $url, $dataSendJson, array( 'auth_user' => $this->userName, 'auth_pass' => $this->userName ) );
		functions::insertLog( __METHOD__ . ' - ' . json_encode( $getAmountTicket,256 | 64 ), 'train' );
		if ( ! isset( $getAmountTicket['statusError'] ) ) {
			return $getAmountTicket;
		}
		
		return array(
			'result_status'  => 'Error',
			'result_message' => 'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
		);
	}

	public function cancelTicket( $params ) {
		$url                   = $this->serverUrl . "cancelTicket";
		$getCancelTicketParams = array(
			'RequestNumber'=>$params['requestNumber'],
			'pTkSr'       => $params['TicketNumber'],
			'TrainNumber' => $params['TrainNumber'],
			'MoveDate'    => $params['MoveDate'],
		);
		$dataSendJson          = json_encode( $getCancelTicketParams,256 | 64 );
		functions::insertLog( __METHOD__ . ' - ' . json_encode( $getCancelTicketParams,256 | 64 ), 'train' );
		$result = functions::curlExecution( $url, $dataSendJson, array( 'auth_user' => $this->userName, 'auth_pass' => $this->userName ) );
		$dataSendJson          = json_encode( $result,256 | 64 );
//		functions::insertLog( 'response==>' . $params['requestNumber'] . '==>' . json_encode( $result ), 'log_train_CancelTicket' );
//		functions::insertLog( '***************************************************', 'log_train_CancelTicket' );
		if ( ! isset( $result['statusError'] ) ) {
			return $result;
		}
		
		return array(
			'result_status'  => 'Error',
			'result_message' => 'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
		);
	}
	
	public function DeleteTicket2( $params ) {
		$url                   = $this->serverUrl . "deleteTicket" ;
		$getDeleteTicketParams = array(
			'RequestNumber'=>$params['requestNumber'],
			'SaleId'      => $params['TicketNumber'],
			'TrainNumber' => $params['TrainNumber'],
			'MoveDate'    => $params['MoveDate'],
		);
		$dataSendJson          = json_encode( $getDeleteTicketParams,256|64 );
		functions::insertLog( __METHOD__ . ' PARAMS - ' . $dataSendJson, 'train' );
		$result = functions::curlExecution( $url, $dataSendJson, array( 'auth_user' => $this->userName, 'auth_pass' => $this->userName ) );
		functions::insertLog( __METHOD__ . ' - ' . json_encode( $result,256 | 64 ), 'train' );
		if ( ! isset( $result['statusError'] ) ) {
			return $result;
		}
		
		return array(
			'result_status'  => 'Error',
			'result_message' => 'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
		);
	}

	public function TicketReportA( $params ) {
		$url = $this->serverUrl . "ticketReportA";
		unset( $params['code'] );
		$getTicketReportAParams = array(
			'RequestNumber'=>$params['requestNumber'],
			'SaleId'   => $params['TicketNumber']
		);
		$dataSendJson           = json_encode( $getTicketReportAParams ,256|64);
		functions::insertLog( __METHOD__ . ' PARAMS - ' . $dataSendJson, 'train' );
		$result = functions::curlExecution( $url, $dataSendJson, array( 'auth_user' => $this->userName, 'auth_pass' => $this->userName ) );
		functions::insertLog( __METHOD__ . ' - ' . json_encode( $result,256 | 64 ), 'train' );
		if ( ! isset( $result['statusError'] ) ) {
			return $result;
		}
		
		return array(
			'result_status'  => 'Error',
			'result_message' => 'متاسفانه در در روند رزرو بلیط قطار اختلالی رخ داده لطفا مجددا تلاش نمائید'
		);
	}
}