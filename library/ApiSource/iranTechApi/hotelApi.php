<?php
//ini_set( "zlib.output_compression", 1 );

//error_reporting( 1 );
//error_reporting( E_ALL | E_STRICT );
//@ini_set( 'display_errors', 1 );
//@ini_set( 'display_errors', 'on' );

class hotelApi extends clientAuth {
	private $entries, $authUser, $authPass, $apiRoute, $apiRoot, $ClientId;

    public $transactions;
	
	public function __construct() {

        $this->transactions = $this->getModel('transactionsModel');

        parent::__construct();
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        header("Access-Control-Allow-Credentials: true");
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            // اگر مرورگر درخواست preflight فرستاد، یه پاسخ ساده بده و برو
            header("HTTP/1.1 200 OK");
            exit();
        }
		header( "Content-type: application/json;charset=utf-8;" );
		$requestType = $_SERVER['REQUEST_METHOD'];
		$this->setApiRoot();
		$this->authUser = isset( $_SERVER['PHP_AUTH_USER'] ) ? $_SERVER['PHP_AUTH_USER'] : null;
		$this->authPass = isset( $_SERVER['PHP_AUTH_PW'] ) ? $_SERVER['PHP_AUTH_PW'] : null;
		$requestUrl     = str_replace( '/?', '?', $_SERVER['REQUEST_URI'] );
		$parseUrl       = explode( '/', $requestUrl );
		$method         = $parseUrl[3];
		$this->setRoute( $method );
		$entries = file_get_contents( 'php://input' );

		if ( ! $this->checkJson( $entries ) ) {
			$this->showJson( [ 'Success' => false, 'Message' => 'invalid request', 'request' => $entries ], 'invalid request', 400 );
		}
		
		if ( $requestType == 'GET' ) {
			if ( strpos( $method, '?' ) !== false ) {
				$parseUrl = parse_url( $requestUrl );
				parse_str( $parseUrl['query'], $params );
				$path    = $parseUrl['path'];
				$explode = explode( '/', $path );
				$method  = end( $explode );
				
				return $this->$method( $params );
			} else {
				return $this->$method();
			}
		}
		
		$this->entries = json_decode( $entries, true );

		$username = $this->getAuthUsername( $this->authUser, $this->authPass , $method );
      
		if ( ! $username ) {
			$this->showJson( [
				'Error'   => 'authError',
				'Message' => 'username not found',
				'Data'    => [ 'username' => $this->authUser, 'pass' => $this->authPass ]
			], 'Send User and Password Basic Auth In header', 401 );
		}
		
		$this->setClientId( $this->authUser, $this->authPass );
		
		return $this->$method( $this->entries );
	}
	
	protected function setClientId( $user, $pass ) {
		/** @var ModelBase $ModelBase */
		$ModelBase = Load::library( 'ModelBase' );
		$Sql       = "SELECT clientId FROM client_user_api WHERE userName='{$user}' AND keyTabdol='{$pass}'";
		$resClient = $ModelBase->load( $Sql );
		if ( ! $resClient ) {
			return false;
		}
		$this->ClientId = $resClient['clientId'];
		
		return true;
		
	}
	
	private function setApiRoot() {
			$this->apiRoot = 'http://safar360.com/Core/V-1/Hotels/';
	}
	
	private function setRoute( $route ) {
		return $this->apiRoute = $this->apiRoot . $route;
	}
	
	private function getAuthUsername( $username = null, $password = null  ,$method=null) {

	    if($method =='HotelList')
        {
            $condition= ($this->entries['IsInternal']) ? "(AUTH.SourceId='6' AND AUTH.serviceId='3')" : "(AUTH.SourceId='12' AND AUTH.serviceId='10')" ;
        }else{
            $condition= "((AUTH.SourceId='6' AND AUTH.serviceId='3') OR (AUTH.SourceId='12' AND AUTH.serviceId='10'))" ;
        }

        $Sql = "SELECT AUTH.Username,API.clientId FROM client_auth_tb AS AUTH
				LEFT JOIN client_user_api AS API ON AUTH.ClientId = API.clientId
				WHERE API.userName='{$username}' AND API.keyTabdol='{$password}'
				AND AUTH.ClientId=API.clientId AND $condition";
		
		/** @var ModelBase $ModelBase */
		$ModelBase = Load::library( 'ModelBase' );
		$UserName  = $ModelBase->load( $Sql );
		
        return $UserName['clientId'] != '299' ? $UserName['Username'] : false;
		
	}
	
	private function isRequestType( $type = 'GET' ) {
		$type = strtoupper( $type );
		
		return ( $_SERVER['REQUEST_METHOD'] == strtoupper( $type ) ) ? true : false;
	}
	
	private function checkJson( $jsonInput = null ) {
		if ( in_array( $_SERVER['REQUEST_METHOD'], [ 'POST', 'PATCH', 'PUT' ] ) ) {
			return ( json_decode( $jsonInput ) != null ) ? true : false;
		}
		
		return true;
	}
	
	protected function returnJson( $result = null, $message = '', $status = 200, $success = true, $onlyResult = false ) {
		if ( isset( $result['Error'] ) ) {
			$response['Error'] = $result['Error'];
		}
		if ( isset( $status ) && ! empty( $status ) ) {
			$response['StatusCode'] = $status;
		}
		if ( isset( $success ) ) {
			$response['Success'] = $success;
		}
		if ( isset( $message ) && ! empty( $message ) ) {
			$response['Message'] = $message;
		}
		if ( isset( $result['RequestNumber'] ) ) {
			$response['RequestNumber'] = $result['RequestNumber'];
			//			$response['Result'] = $result['Result'];
		}
        if ( isset( $result['PriceSessionId'] ) && ! empty( $result['PriceSessionId'] ) ) {
            $response['PriceSessionId'] = $result['PriceSessionId'];
        }
		$response['Result'] = isset( $result['Result'] ) ? $result['Result'] : $result;
		
		if ( $onlyResult === true ) {
			$response = $result;
		}
		
		return json_encode( $response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
	}
	
	protected function showJson( $result = null, $message = '', $status = 200, $success = true, $onlyResult = false ) {
		http_response_code( $status );
		echo $this->returnJson( $result, $message, $status, $success, $onlyResult );
		exit();
	}
	
	protected function processRequest( $type = 'get', $method = '', $data = null, $checkAuth = false ) {
		if ( $checkAuth ) {

			$username = $this->getAuthUsername( $this->authUser, $this->authPass );
			if ( ! $username ) {
				$this->showJson( [
					'Error'   => 'authError',
					'Message' => 'username not found',
					'Data'    => [ 'username' => $username, 'pass' => $this->authPass ]
				], 'Send User and Password Basic Auth In header', 401 );
			}
			$headers = [ 'auth_user' => $username, 'auth_pass' => $this->authPass ];

			return $this->doRequest( $method, $data, $type, $headers );
			
		}

		return $this->doRequest( $method, $data, $type );
	}
	
	protected function doRequest( $method = '', $data = null, $type = 'get', $headers = [] ) {
		if ( $type == 'get' ) {
			return $this->CurlGet( $method, $data );
		}
		
		return $this->CurlPost( $method, $data, $headers );
	}
	
	protected function showResult( $result = [] ) {
		$finalResult = [];
		if ( isset( $result['RequestNumber'] ) ) {
			$RequestNumber                = $result['RequestNumber'];
			$finalResult['RequestNumber'] = $RequestNumber;
			unset( $result['RequestNumber'] );
		}
		$message    = '';
		$statusCode = 200;
		$success    = false;
		if ( isset( $result['Message'] ) ) {
			$message = $result['Message'];
			unset( $result['Message'] );
		}
		if ( isset( $result['StatusCode'] ) ) {
			$statusCode = $result['StatusCode'];
			unset( $result['StatusCode'] );
		}
		if ( isset( $result['Success'] ) ) {
			$success = $result['Success'];
			unset( $result['Success'] );
		}
		
		$finalResult['Result'] = $result['Result'];
		$this->showJson( $finalResult, $message, $statusCode, $success );
	}
	
	protected function CurlGet( $apiRoute = '', $data = [] ) {
		$this->setRoute( $apiRoute );
        $data = json_encode($data, 256 | 64);
        $this->apiRoute    = str_replace(" ", '%20', $this->apiRoute);
		$apiResult = functions::curlExecution_Get( $this->apiRoute, $data );

		//		var_dump($this->apiRoute);
		if ( ! $apiResult ) {
			$result['Success'] = false;
			$result['Error']   = [ 'Code' => 'GT-500', 'Message' => 'خطایی غیر منتظره رخ داد لطفا پس از چند لحظه دوباره تلاش کنید' ];
			$result['Message'] = 'Unexpected Error, Please try again later';
			$result['Result']  = [$apiResult];
			
			return $result;
		}
		
		return $apiResult;
	}
	
	protected function CurlPost( $apiRoute = '', $data = [], $headers = [] ) {
        $headers = array_merge( [ 'auth_user' => $this->authUser, 'auth_pass' => $this->authPass ],$headers );
        $this->setRoute( $apiRoute );
        $DS         = DIRECTORY_SEPARATOR;
        $jsonData   = json_encode( $data, 256 | 64 );
        $dateLogDir = LOGS_DIR . 'hotels' . $DS . dateTimeSetting::jdate( 'Y-m-d', '', '', '', 'en' );
        if ( ! file_exists( $dateLogDir ) ) {
            mkdir( $dateLogDir , 0777, true);
        }
		error_log( 'Request to ' . $apiRoute . ' In ' . date( 'Y/m/d H:i:s' ) . 'URL => ' . $this->apiRoute . ' HEADERS =>  ' . $this->returnJson( $headers, null, null, false, true ) . PHP_EOL . ' request_body is : => ' . PHP_EOL . $this->returnJson( $data, null, null, false, true ) . PHP_EOL, 3, LOGS_DIR . 'hotels/' . dateTimeSetting::jdate( 'Y-m-d', '', '', '', 'en' ) . '/POST_API-' . $apiRoute . '.txt' );

        $apiResult = functions::curlExecution( $this->apiRoute, $jsonData, $headers );
		error_log( 'response from ' . $apiRoute . ' In ' . date( 'Y/m/d H:i:s' ) . ' response_body is : => ' . PHP_EOL . json_encode( $apiResult, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . PHP_EOL . PHP_EOL, 3, LOGS_DIR . 'hotels/' . dateTimeSetting::jdate( 'Y-m-d', '', '', '', 'en' ) . '/POST_API-' . $apiRoute . '.txt' );
		if ( ! $apiResult || ! isset( $apiResult['Result'] ) ) {
			$result['Error']   = $apiResult;
			$result['Success'] = false;
			$result['Result']  = [
				'Code'    => $apiRoute . '-Curl',
				'Message' => 'Error on Receive data from API',
			];
			if ( isset( $apiResult['Error'] ) ) {
				$this->showError( $apiResult['StatusCode'], $apiResult['Message'], $apiResult['Error']['Code'], $apiResult['Error']['Message'], $apiResult['Error']['MessagePersian'] );
			}
			
			return $result;
		}
		
		return $apiResult;
	}
	
	protected function showError( $errorStatus = 400, $message = '', $errorCode = '', $errorMessage = '', $errorMessagePersian = '',$result = null ) {
		$errorCode           = ! empty( $errorCode ) ? $errorCode : '000';
		$errorMessagePersian = ! empty( $errorMessagePersian ) ? $errorMessagePersian : 'خطای غیر منتظره رخ داده است';
		$errorMessage        = ! empty( $errorMessage ) ? $errorMessage : 'Unexpected Error';
		$message             = ! empty( $message ) ? $message : 'خطا';
		
		$return['Success']    = false;
		$return['StatusCode'] = $errorStatus;
		$return['Message']    = $message;
		$return['Error']      = [
			'Code'           => $errorCode,
			'Message'        => $errorMessage,
			'MessagePersian' => $errorMessagePersian,
		];
		$return['Result']     = $result;
		$this->showJson( $return, $message, $errorStatus, false, true );
	}
	
	protected function insertReport( $dataInsert, $count = 1 ) {
		/** @var ModelBase $MB */
		/** @var admin $admin */
		$dataInsert['creation_date_int'] = time();
		$MB                              = Load::library( 'ModelBase' );
		$admin                           = Load::controller( 'admin' );
		$insertResult                    = false;
		$MB->setTable( 'report_hotel_tb' );
		for ( $c = 0; $c < $count; $c ++ ) {
			$adminInsert = $MB->insertLocal( $dataInsert );
			unset( $dataInsert['client_id'] );
			$clientInsert = $admin->ConectDbClient( '', $this->ClientId, "Insert", $dataInsert, "book_hotel_local_tb", "" );
			if ( $adminInsert && $clientInsert ) {
				$insertResult = true;
			}
		}
		
		return $insertResult;
	}
	
	protected function updateReport( $dataUpdate = [], $RequestNumber = '' ) {
		/** @var ModelBase $MB */
		/** @var admin $admin */
		$updateResult = false;
		$MB           = Load::library( 'ModelBase' );
		$MB->setTable( 'report_hotel_tb' );
		$admin       = Load::controller( 'admin' );
		$update      = $MB->update( $dataUpdate, "request_number='{$RequestNumber}'" );
		$adminUpdate = $admin->ConectDbClient( '', $this->ClientId, 'Update', $dataUpdate, 'book_hotel_local_tb', "request_number='{$RequestNumber}'" );
		if ( $update && $adminUpdate ) {
			$updateResult = true;
		}
		
		return $updateResult;
	}
	
	protected function getUserByEmail( $email ) {
		$Model = Load::library( 'Model' );
		/** @var admin $admin */
		$admin = Load::controller( 'admin' );
		
		$sql   = "SELECT * FROM members_tb WHERE email='{$email}'";
		$return = $admin->ConectDbClient($sql,$this->ClientId,'Select',null,null,null);
		return $return;
	}
	
	public function getCredit( $clientId ) {
		/** @var admin $admin */
		$admin = Load::controller( 'admin' );
		
		//600: pending records under 10 minutes are included
		$time = time() - ( 600 );
		
		$query  = "SELECT" . " COALESCE((SELECT SUM(Price) FROM transaction_tb WHERE Status='1'), 0) as `credit`, " . " COALESCE((SELECT SUM(Price) FROM transaction_tb WHERE Status='2' AND" . " ((PaymentStatus = 'success') OR (PaymentStatus = 'pending' AND CreationDateInt > '{$time}')) ), 0) as `debit` ";
		$result = $admin->ConectDbClient( $query, $clientId, 'Select', '', '', '' );
		
		return $result['credit'] - $result['debit'];
	}
	
	public function checkInternal( $data ) {
		$city = $data['City'];
		if ( ! $city ) {
			$this->showError( 400, 'خطا در پارامترهای ارسالی', 'checkInternal-400', 'City parameter is required', 'پارامتر شهر الزامی است' );
		}
		$apiResult = $this->processRequest( 'get', "checkInternal/{$city}" );
		$this->showJson( $apiResult );
	}
	
	public function countries() {
		$apiResult = $this->processRequest( 'get', 'countries' );
		$this->showResult( $apiResult );
	}
	
	public function cities( $data = [] ) {

		$country   = isset( $data['Country'] ) ? $data['Country'] : 'iran';
		$apiResult = $this->processRequest( 'get', "cities/{$country}" );

		$this->showResult( $apiResult );
	}
	
	public function getBookDetail( $RequestNumber = null, $clientId = null ) {
		if ( ! $clientId ) {
			$clientId = $this->ClientId;
		}
		if ( ! $RequestNumber ) {
			return false;
		}
		$admin       = Load::controller( 'admin' );
		$sql         = "SELECT * FROM book_hotel_local_tb WHERE request_number='{$RequestNumber}' ";
		$reserveInfo = $admin->ConectDbClient( $sql, $clientId, 'SelectAll', '', '', '' );
		
		return $reserveInfo;
	}
	
	public function hotelList( $data ) {
		if ( ! isset( $data['City'] ) || $data['City'] == '' ) {
			$this->showError( 400, 'اسم شهر الزامی است', '400', 'City is needed', 'لطفا نام شهری که میخواهید را ارسال کنید' );
		}
		if ( isset( $data['IsInternal'] ) && $data['IsInternal'] == false ) {
			if ( ! isset( $data['Country'] ) && ! is_string( $data['Country'] ) ) {
				$this->showError(  400, '', '400', 'Country is needed', 'برای هتلهای خارجی ارسال کشور الزامی است'  );
			}
		}
		if ( ! $data['IsInternal'] && ! isset( $data['Rooms'] ) && ! isset( $data['Rooms'][0]['Adults'] ) ) {
			$this->showError( 400, 'تعداد بزرگسالان الزامی است', '400', 'Adults Count is needed', 'لطفا تعداد افراد بزرگسال را ارسال کنید' );
		}
		
		if ( $data['StartDate'] < dateTimeSetting::jtoday( '-' ) ) {
			$this->showError( 400, 'StartDate invalid', 'HotelList-0031', 'StartDate can\'t be a past date', 'تاریخ شروع نمیتواند یک تاریخ گذشته باشد.' );
		}
		if ( ! isset( $data['EndDate'] ) || empty( $data['EndDate'] ) ) {
			$this->showError( 400, 'خطا در ارسال پارامترهای الزامی', 'HotelList-004', 'EndDate is required', 'پارامتر EndDate الزامی است' );
		}
		if ( $data['EndDate'] <= $data['StartDate'] ) {
			$this->showError( 400, 'خطا در ارسال پارامترهای الزامی', 'HotelList-0041', 'EndDate must be after StartDate', 'تاریخ پایان باید بعد از تاریخ شروع باشد' );
		}
		$apiResult = $this->processRequest( 'post', 'HotelList', $data, true );
		if ( $apiResult['Success'] == true ) {
			$this->showJson( $apiResult, $apiResult['Message'], $apiResult['StatusCode'], $apiResult['Success'] );
		}
		$this->showError( 400, 'Unexpected Error', 'HL-000', 'We have unexpected error. please try again later', 'خطای غیر منتظره ای رخ داده است. لطفا بعدا دوباره تلاش کنید',$apiResult );
		//		}
		//		$this->showError( 500, $insert );
	}
	
	public function Detail( $data ) {
		if ( ! $this->isRequestType( 'post' ) ) {
			$this->showError( 400, 'Bad Request Type', '400', 'Bad Request Type', 'خطا! نوع درخواست معتبر نیست ' );
		}
		$RequestNumber = $data['RequestNumber'];
		if ( ! $RequestNumber ) {
			$this->showError( 400, 'کد پیگیری الزامی است', 'tr-000', 'RequestNumber is require', 'کد پیگیری را ارسال کنید' );
		}
		
		$hotelIndex = $data['HotelIndex'];
		if ( ! $hotelIndex ) {
			$this->showError( 400, 'پارامتر HotelIndex الزامی است', 'detail-000', 'HotelIndex is require', 'لطفا پارامتر HotelIndex را ارسال کنید' );
		}
		$apiResult = $this->processRequest( 'post', 'Detail', $data, true );
		if ( isset( $apiResult['Success'] ) && $apiResult['Success'] == true ) {
			$this->showJson( $apiResult['Result'], $apiResult['Message'], $apiResult['StatusCode'], $apiResult['Success'] );
		}
		echo json_encode($apiResult);exit();
		$this->showError( 400, 'Unexpected Error', 'DT-400', 'we get an unexpected error. please try again later', 'خطایی غیر منتظره رخ داده است. لطفا بعدا دوباره تلاش کنید.' );
	}
	
	public function Prices( $data ) {
		if ( ! $this->isRequestType( 'post' ) ) {
			$this->showError( 400, 'Bad Request Type', '400', 'Bad Request Type', 'خطا! نوع درخواست معتبر نیست ' );
		}
		$RequestNumber = $data['RequestNumber'];
		if ( ! $RequestNumber ) {
			$this->showError( 400, 'کد پیگیری الزامی است', 'tr-000', 'RequestNumber is require', 'کد پیگیری را ارسال کنید' );
		}
		$bookDetail = self::getBookDetail( $RequestNumber );
		
		$child_counts = $adult_counts = 0;
		foreach ( $bookDetail as $item ) {
			if ( $item['passenger_age'] == 'Adt' ) {
				$adult_counts ++;
			}
			if ( $item['passenger_age'] == 'Chd' ) {
				$child_counts ++;
			}
		}
		
		$data['AdultsCount'] = $adult_counts;
		$data['ChildCount']  = $child_counts;
		
		$apiResult = $this->processRequest( 'post', 'Prices', $data, true );
		if ( $apiResult['Success'] == true ) {
			$this->showJson( $apiResult, $apiResult['Message'], $apiResult['StatusCode'], $apiResult['Success'] );
		}
		$this->showError( 400, 'Unexpected Error', 'DT-400', 'we get an unexpected error. please try again later', 'خطایی غیر منتظره رخ داده است. لطفا بعدا دوباره تلاش کنید.' );
		
	}
	
	public function Book( $data ) {
		if ( ! $this->isRequestType( 'post' ) ) {
			$this->showError( 400, 'Bad Request Type', 'b-400', 'Bad Request Type', 'خطا! نوع درخواست معتبر نیست ' );
		}
		$RequestNumber = $data['RequestNumber'];
		if ( ! $RequestNumber ) {
			$this->showError( 400, 'کد پیگیری الزامی است', 'b-001', 'RequestNumber is require', 'کد پیگیری را ارسال کنید' );
		}
		
		$Rooms = $data['Rooms'];
		if ( ! $Rooms ) {
			$this->showError( 400, 'کد اتاق الزامی ست الزامی است', 'b-002', 'Rooms is require', 'لطفا کد اتاق برای رزرو را ارسال کنید' );
		}
		
		$Buyer = $data['Buyer'];
		if ( ! $Buyer || ! is_array( $Buyer ) ) {
			$this->showError( 400, 'اطلاعات خریدار الزامی است', 'b-003', 'Buyer is require', 'اطلاعات خریدار را ارسال کنید' );
		}
		
		$Passengers = $data['Passengers'];
		if ( ! $Passengers || ! is_array( $Passengers ) ) {
			$this->showError( 400, 'اطلاعات مسافرین الزامی است', 'BK-004', 'Passengers is require', 'اطلاعات مسافرین را ارسال کنید' );
			
		}
		/*
		if ( count( $Rooms ) != count( $Passengers ) ) {
			$this->showError( 400, 'اطلاعات وارد شده صحیح نیست', 'BK-005', 'Please Post Each room a passenger', 'لطفا برای هر اتاق یک سرگروه ارسال کنید'.count( $Passengers ).'-'.count($Rooms) );
		}*/
        $data['Buyer']['Mobile'] = '09129409530';
		$apiResult = $this->processRequest( 'post', 'Book', $data, true );
		if ( !isset($apiResult['Success']) || $apiResult['Success'] != true || $apiResult['StatusCode'] != 200 ) {
			$this->showError( 400, $apiResult );
		}
		
		/** @var ModelBase $ModelBase */
		/** @var Model $Model */
		/** @var members_tb $members_model */
		/** @var admin $admin */
		/** @var irantechCommission $irantechCommission */
		
		$ModelBase          = Load::library( 'ModelBase' );
		$Model              = Load::library( 'Model' );
		$members_model      = Load::model( 'members' );
		$admin              = Load::controller( 'admin' );
		$irantechCommission = Load::controller( 'irantechCommission' );
		
		$cityName      = $apiResult['Result']['ReservationDetails'][0]['CityName'];
		$checkInternal = $this->processRequest( 'get', "checkInternal/{$cityName}" );
		if ( $checkInternal ) {
			$it_commission = $irantechCommission->getCommission( 'PublicLocalHotel', '9' ,$this->ClientId);
			$serviceTitle  = 'PublicLocalHotel';
		} else {
			$it_commission = $irantechCommission->getCommission( 'PublicPortalHotel', '10',$this->ClientId );
			$serviceTitle  = 'PublicPortalHotel';
		}
		
		$dataInsert['irantech_commission'] = $it_commission;
		$factorNumber                      = $this->generateFactorNumber();
		//		$this->showJson($apiResult['Result']['ReservationDetails'][0]['CityIndex']);
		$apiResultReservation = $apiResult['Result']['ReservationDetails'];
        $total_price_api = $total_price_board = $total_price_online = 0;
		foreach ( $apiResultReservation as $key => $item ) {
			
			$roomIndex = $Rooms[ $key ]['RoomCode'];
			$roomCount = $Rooms[ $key ]['RoomCount'];
			
			
			
			$prices    = $item['Room']['Rates'][0]['Prices'];
			$startDate = $prices[0]['Date'];
			$endDate   = $prices[ count( $prices ) - 1 ]['Date'];
			
			//			$startDate = dateTimeSetting::jdate( 'Y-m-d', strtotime( $startDate ), '', '', 'en' );
			//			$endDate   = dateTimeSetting::jdate( 'Y-m-d', strtotime( $endDate ), '', '', 'en' );
			
			$dataInsert['hotel_id']                = $item['HotelIndex'];
			$dataInsert['city_id']                 = $item['CityIndex'];
			$dataInsert['request_number']          = $data['RequestNumber'];
			$dataInsert['room_id']                 = $roomIndex;
			$dataInsert['room_name']               = $item['Room']['RoomName'];
			$dataInsert['serviceTitle']            = $serviceTitle;
			$dataInsert['room_count']              = $roomCount;
			$dataInsert['start_date']              = $startDate;
			$dataInsert['end_date']                = $endDate;
			$dataInsert['number_night']            = count( $prices );
			$dataInsert['hotel_name']              = $item['HotelName'];
			$dataInsert['hotel_address']           = $item['HotelAddress'];
			$dataInsert['hotel_telNumber']         = $item['HotelPhone'];
			$dataInsert['hotel_starCode']          = $item['HotelStars'];
			$dataInsert['hotel_entryHour']         = $item['HotelCheckTimesIn'] ?: '14:00';
			$dataInsert['hotel_leaveHour']         = $item['HotelCheckTimesOut'] ?: '12:00';
			$dataInsert['hotel_pictures']          = $item['HotelPictures'][0]['full'];
			$dataInsert['factor_number']           = $factorNumber;
			$dataInsert['city_name']               = $item['CityName'];
//            $dataInsert['passenger_name']          = $Passengers[ $key ]['FirstName'];
//            $dataInsert['passenger_family']        = $Passengers[ $key ]['LastName'];
			$dataInsert['passenger_name']          = $data['Passengers'][ $key ]['FirstName'];
			$dataInsert['passenger_name_en']       = isset( $data['Passengers'][ $key ]['FirstNameEn'] ) && ! empty( $data['Passengers'][ $key ]['FirstNameEn'] ) ? $data['Passengers'][ $key ]['FirstNameEn'] : '';
			$dataInsert['passenger_family']        = $data['Passengers'][ $key ]['LastName'];
			$dataInsert['passenger_family_en']     = isset( $data['Passengers'][ $key ]['LastNameEn'] ) && ! empty( $data['Passengers'][ $key ]['LastNameEn'] ) ? $data['Passengers'][ $key ]['LastNameEn'] : '';
			$dataInsert['passenger_gender']        = isset( $data['Passengers'][ $key ]['Gender'] ) && ! empty( $data['Passengers'][ $key ]['Gender'] ) ? $data['Passengers'][ $key ]['Gender'] : '';
			$dataInsert['passenger_birthday']      = isset( $data['Passengers'][ $key ]['Birthday'] ) && ! empty( $data['Passengers'][ $key ]['Birthday'] ) ? $data['Passengers'][ $key ]['Birthday'] : '';
			$dataInsert['passenger_birthday_en']   = isset( $data['Passengers'][ $key ]['BirthdayEn'] ) && ! empty( $data['Passengers'][ $key ]['BirthdayEn'] ) ? $data['Passengers'][ $key ]['BirthdayEn'] : '';
			$dataInsert['passenger_national_code'] = isset( $data['Passengers'][ $key ]['NationalCode'] ) && ! empty( $data['Passengers'][ $key ]['NationalCode'] ) ? $data['Passengers'][ $key ]['NationalCode'] : '0000000000';
			$dataInsert['passportNumber']          = isset( $data['Passengers'][ $key ]['PassportNumber'] ) && ! empty( $data['Passengers'][ $key ]['PassportNumber'] ) ? $data['Passengers'][ $key ]['PassportNumber'] : '0000000000';
			
			$dataInsert['member_mobile'] = $dataInsert['passenger_leader_room'] = $data['Buyer']['Mobile'];
			$dataInsert['member_name']   = ( $data['Buyer']['FirstName'] . ' ' . $data['Buyer']['LastName'] );
			$dataInsert['member_email']  = $data['Buyer']['Email'];
			$dataInsert['passenger_leader_room_fullName'] = $data['Buyer']['FirstName'] . ' ' . $data['Buyer']['LastName'];
			$dataInsert['payment_type'] = 'credit';
			$dataInsert['payment_date'] = date( 'Y-m-d H:i:s', time());
			$dataInsert['total_price']  = $item['Room']['Rates'][$key]['TotalPrices']['Online'];
			$dataInsert['room_price']  = $item['Room']['Rates'][$key]['TotalPrices']['Online'];
			$dataInsert['room_bord_price']  = $item['Room']['Rates'][$key]['TotalPrices']['Board'];
			$dataInsert['type_application']  = 'api';

			$getMember = $this->getUserByEmail( $data['Buyer']['Email'] );
			
			$IdMember = $getMember['id'];
			
			if ( ! $IdMember ) {
				$dataMember['mobile']    = $data['Buyer']['Mobile'];
				$dataMember['telephone'] = '';
				$dataMember['name']      = $data['Buyer']['FirstName'];
				$dataMember['family']    = $data['Buyer']['LastName'];
				$dataMember['email']     = $data['Buyer']['Email'];
				$dataMember['password']  = $members_model->encryptPassword( $data['Buyer']['Mobile'] );
				$dataMember['is_member'] = '0';
				//				$dataMember              = [];
				$res                     = $admin->ConectDbClient( '', $this->ClientId, "Insert", $dataMember, "members_tb", "" );

				
				$membersNew              = $this->getUserByEmail( $dataMember['email'] );
				$IdMember                = $membersNew['id'];
			}
			
			$dataInsert['member_id'] = $IdMember;
			$dataInsert['status']    = 'PreReserve';
			$dataInsert['request_from']    = 'api';
			$dataInsert['client_id'] = $this->ClientId;
			$dataInsert['creation_date_int'] = time();
			$this->insertReport($dataInsert);
//			$ModelBase->setTable( 'report_hotel_tb' );
//			$ModelBase->insertLocal( $dataInsert );
//			$admin->ConectDbClient('',$this->ClientId,'Insert',$dataInsert,'book_hotel_local_tb');
//			$Model->setTable( 'book_hotel_local_tb' );
//			$Model->insertLocal( $dataInsert );
		}


		
		$this->showJson( $apiResult, $apiResult['Message'], $apiResult['StatusCode'], $apiResult['Success'] );
	}
	
	public function WaitList( $data ) {
		if ( ! $this->isRequestType( 'post' ) ) {
			$this->showError( 400, 'Bad Request Type', '400', 'Bad Request Type', 'خطا! نوع درخواست معتبر نیست ' );
		}
		$RequestNumber = $data['RequestNumber'];
		if ( ! $RequestNumber ) {
			$this->showError( 400, 'کد پیگیری الزامی است', 'tr-000', 'RequestNumber is require', 'کد پیگیری را ارسال کنید' );
		}
		$this->showJson( $data );
		$apiResult = $this->processRequest( 'post', 'WaitList', $data, true );
		$this->showJson( $apiResult, 'success', $apiResult['StatusCode'], $apiResult['Success'] );
	}
	
	public function Reserve( $data ) {
		if ( ! $this->isRequestType( 'post' ) ) {
			$this->showError( 400, 'Bad Request Type', '400', 'Bad Request Type', 'خطا! نوع درخواست معتبر نیست ' );
		}
		$RequestNumber = $data['RequestNumber'];
		if ( ! $RequestNumber ) {
			$this->showError( 400, 'کد پیگیری الزامی است', 'tr-000', 'RequestNumber is require', 'کد پیگیری را ارسال کنید' );
		}
		
		//		$this->showJson( $data );
		
		
		/** @var Model $model */
		/** @var ModelBase $modelBase */
		/** @var members_tb $members_model */
		$model              = Load::library( 'Model' );
		$modelBase          = Load::library( 'ModelBase' );
		$members_model      = Load::model( 'members' );
		$admin              = Load::controller( 'admin' );
		$irantechCommission = Load::controller( 'irantechCommission' );
		
		$bookDetail = self::getBookDetail( $RequestNumber, $this->ClientId );
		$agencyID   = $this->ClientId;
		//		var_dump($bookDetail);
		$factorNumber = $bookDetail[0]['factor_number'];
		
		$sqlBook        = "SELECT
                    ( SELECT SUM( room_price ) FROM book_hotel_local_tb WHERE factor_number = '{$factorNumber}' ) AS totalPriceTransaction,
                    ( SELECT COUNT(id) FROM book_hotel_local_tb WHERE factor_number = '{$factorNumber}' ) as countPassengers,
                    BH.* FROM book_hotel_local_tb AS BH WHERE BH.factor_number = '{$factorNumber}';";
		$reserveInfo    = $admin->ConectDbClient( $sqlBook, $this->ClientId, "Select", "", "", "" );
		$sqlService     = "SELECT TitleFa,TitleEn FROM services_tb WHERE TitleEn = '{$reserveInfo['serviceTitle']}'";
		$service        = $modelBase->load( $sqlService );
		$serviceTitleFa = $service['TitleFa'];
		
		$comment = " رزرو $serviceTitleFa  در شهر {$reserveInfo['city_name']}  - هتل  {$reserveInfo['hotel_name']} به شماره فاکتور  {$reserveInfo['factor_number']}";
		
		$reason = '';
		$total_price = $reserveInfo['totalPriceTransaction'];
		if ( $reserveInfo['serviceTitle'] == 'PublicLocalHotel' ) {
			$reason = 'buy_internal_hotel';
		} elseif ( $reserveInfo['serviceTitle'] == 'PublicPortalHotel' ) {
			$reason = 'buy_external_hotel';
		}
		if ( isset( $reserveInfo['irantech_commission'] ) && $reserveInfo['irantech_commission'] > 0 ) {
			$total_price += $reserveInfo['irantech_commission'] * $reserveInfo['countPassengers'];
		}
		
		$check = $this->checkCredit( $total_price, $this->ClientId );
		
		if ( $check['status'] == 'FALSE' ) {
			$this->showError( 422, 'عدم اعتبار کافی', 'BK-005', 'not enough credit', 'اعتبار شما برای این خرید کافی نیست' );
		}
		$existTransaction = $this->getTransactionByFactorNumber( $factorNumber, $agencyID );
		if ( $existTransaction) {
			$this->showError( 400, 'شماره فاکتور تکراری', 'BK-006', 'Duplicate Factor Number', 'شماره فاکتور تکراری است. هر شماره فاکتور فقط یک بار قابل استفاده است' );
		}
		$reduceTransaction = $this->decreasePendingCredit( $total_price, $factorNumber, $comment, $reason, $agencyID );
		if ( ! $reduceTransaction ) {
			$this->showError( '500', 'decrease Credit Error', 'BK-500', 'Error On decrease Credit please try again later', 'خطایی در هنگام کسر اعتبار شما اتفاق افتاد. لطفا پس از چند لحظه دوباره تلاش کنید' );
		}

		$this->showError(500,'خطا','S-500','System is Updating','سیستم در حال بروزرسانی است');

		$apiResult = $this->processRequest( 'post', 'Reserve', $data, true );
		if ( $apiResult['Success'] == true ) {
			$VoucherNumber = 'VoucherNumber';
			$this->setCreditToSuccess( $factorNumber, 'member_credit', $this->ClientId );
			$updateArray = [ 'status' => 'BookedSuccessfully' ];
			
			$this->updateReport( $updateArray, $RequestNumber );
			$this->showJson( $apiResult, '', $apiResult['StatusCode'], $apiResult['Success'] );
		} else {
            $this->showJson( $apiResult, $apiResult['Message'], $apiResult['StatusCode'], $apiResult['Success'] );
		}
	}
	
	public function Cancel( $data ) {
		if ( ! $this->isRequestType( 'post' ) ) {
			$this->showError( 400, 'Bad Request Type', '400', 'Bad Request Type', 'خطا! نوع درخواست معتبر نیست ' );
		}
		$RequestNumber = $data['RequestNumber'];
		if ( ! $RequestNumber ) {
			$this->showError( 400, 'کد پیگیری الزامی است', 'tr-000', 'RequestNumber is require', 'کد پیگیری را ارسال کنید' );
		}
		$this->showJson( $data );
		$apiResult = $this->processRequest( 'post', 'Cancel', $data, true );
		$this->showJson( $apiResult, 'success', $apiResult['StatusCode'], $apiResult['Success'] );
	}
	
	public function checkOfflineStatus( $data ) {
		if ( ! $this->isRequestType( 'post' ) ) {
			$this->showError( 400, 'Bad Request Type', '400', 'Bad Request Type', 'خطا! نوع درخواست معتبر نیست ' );
		}
		$RequestNumber = $data['RequestNumber'];
		if ( ! $RequestNumber ) {
			$this->showError( 400, 'کد پیگیری الزامی است', 'tr-000', 'RequestNumber is require', 'کد پیگیری را ارسال کنید' );
		}
		
		$apiResult = $this->processRequest('post','checkOfflineStatus',$data,true);
		
		$this->showJson($apiResult,$apiResult['Message'],$apiResult['StatusCode'],$apiResult['Success']);
	}
	
	public function generateFactorNumber() {
		$factorNumber = substr( time(), 0, 3 ) . mt_rand( 0000, 9999 ) . substr( time(), 7, 10 );
		
		return $factorNumber;
	}
	
	public function checkCredit( $amountToCheck, $clientId ) {
		$admin = Load::controller( 'admin' );
		//600: pending records under 10 minutes are included
		$time = time() - ( 600 );
		
		$query           = "SELECT" . " COALESCE((SELECT SUM(Price) FROM transaction_tb WHERE Status='1'), 0) as `credit`, " . " COALESCE((SELECT SUM(Price) FROM transaction_tb WHERE Status='2' AND" . " ((PaymentStatus = 'success') OR (PaymentStatus = 'pending' AND CreationDateInt > '{$time}')) ), 0) as `debit` ";
		$result          = $admin->ConectDbClient( $query, $clientId, 'Select', '', '', '' );
		$currentCredit   = $result['credit'] - $result['debit'];
		$remainingCredit = $currentCredit - $amountToCheck;
		if ( $currentCredit >= 0 ) {
			if ( $amountToCheck > $currentCredit ) {
				$result['status'] = 'FALSE';
				$result['credit'] = $remainingCredit;
			} else {
				$result['status'] = 'TRUE';
				$result['credit'] = $remainingCredit;
			}
		} else {
			$result['status'] = 'FALSE';
			$result['credit'] = $remainingCredit;
		}
		
		return $result;
	}
	
	public function getTransactionByFactorNumber( $factorNumber, $clientId ) {
		$admin  = Load::controller( 'admin' );
		$query  = "SELECT * FROM transaction_tb WHERE FactorNumber = '{$factorNumber}'";
		$result = $admin->ConectDbClient( $query, $clientId, 'SelectAll', '', '', '' );
		
		if ( ! empty( $result ) ) {
			return $result;
		} else {
			return false;
		}
	}
	
	public function decreasePendingCredit( $amount, $factorNumber, $comment, $reason, $clientId ) {
		$admin                    = Load::controller( 'admin' );
		$data['Price']            = $amount;
		$data['FactorNumber']     = $factorNumber;
		$data['Comment']          = $comment;
		$data['Reason']           = $reason;
		$data['Status']           = '2';
		$data['PaymentStatus']    = 'pending';
		$data['creationDateInt']  = time();
		$data['BankTrackingCode'] = 'کسر موقت';
		$admin->ConectDbClient( '', $clientId, "Insert", $data, "transaction_tb", "" );

        $data['clientID'] = $clientId;
        $this->transactions->insertTransaction( $data );
		return true;
	}
	
	public function setCreditToSuccess( $factorNumber, $bankTrackingCode, $clientId ) {
		$admin                    = Load::controller( 'admin' );
		$data['PaymentStatus']    = 'success';
		$data['PriceDate']        = date( "Y-m-d H:i:s" );
		$data['BankTrackingCode'] = $bankTrackingCode != 'member_credit' ? $bankTrackingCode : '';
		$condition                = "FactorNumber = '{$factorNumber}'";


        $result = $admin->ConectDbClient( '', $clientId, 'Update', $data, 'transaction_tb', $condition );

        $data['clientID'] = $clientId;
        $this->transactions->updateTransaction($data,$condition);
		return $result;

	}
}

new hotelApi();

