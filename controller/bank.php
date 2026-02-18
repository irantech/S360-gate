<?php
class bank {

	public $selectedBank;
	public $serviceType = ''; //this one can be array
	public $amountToPay = 0;
	public $clientID;
	public $token;
	public $factorNumber;
	public $bankTitle;
	public $callBackPage;
	public $callBackURL;
	public $trackingCode;
	public $failMessage;
	public $isCurrency;
	public $transactionStatus = '';
	public $detect_service_payment;
	private $bankParam1 = '', $bankParam2 = '', $bankParam3 = '', $bankParam4 = '', $bankParam5 = '', $bankServiceType = ''; //this one should not be array
	public $return_immediately=false;
	public $additionalData;
	#region construct
	public function __construct() {


	}
	#endregion

	#region initial bank parameters
	public function initBankParams( $bank ) {


		$this->selectedBank = filter_var( $bank, FILTER_SANITIZE_STRING );

		if ( isset( $_POST['serviceType'] ) ) {
			$this->serviceType = $_POST['serviceType']; //serviceType can be string or array, and this is why i didnt filter it
		} elseif ( isset( $_GET['serviceType'] ) ) {
			$this->serviceType = filter_var( $_GET['serviceType'], FILTER_SANITIZE_STRING );
		}

		if ( $this->selectedBank != 'credit' ) {


			$initialValues = array(
				'bank_dir'     => $this->selectedBank,
				'serviceTitle' => $this->serviceType
			);

			/** @var bankList_tb $bankModel */
			$bankModel = Load::model( 'bankList' );
			$bankInfo  = $bankModel->getByBankDir( $initialValues );

			$this->bankTitle       = $bankInfo['title'];
			$this->bankParam1      = $bankInfo['param1'];
			$this->bankParam2      = $bankInfo['param2'];
			$this->bankParam3      = $bankInfo['param3'];
			$this->bankParam4      = $bankInfo['param4'];
			$this->bankParam5      = $bankInfo['param5'];
			$this->bankServiceType = $bankInfo['serviceTitle'];
			$this->isCurrency      = $bankInfo['is_currency'];

		}

	}
	#endregion

	public function initializeAdminBank($operation,$bank_name,$amount,$factor_number,$call_back_url,array $params)
	{
		$this->selectedBank=$bank_name;
		$this->callBackPage=$call_back_url;
		$this->factorNumber=$factor_number;
		$this->return_immediately=true;
		$this->amountToPay= $amount;
		$this->bankParam1=$params[0];
		$this->bankParam2=$params[1];
		$this->bankParam3=$params[2];
		$this->bankParam4=$params[3];
		$this->bankParam5=$params[4];


		return $this->executeBank($operation);
	}


	#region calculateAmount that goes to bank
	/**
	 * this function will set amount and factor number and callback page
	 *
	 * @param $payFor    string: 'local' OR 'hotelLocal' OR 'insurance' OR 'ReservationTicket'
	 * @param $requestID integer: the request(factor) number of books
	 */
	public function calculateAmount( $payFor, $requestID = null, $amount = null , $additionalData = null) {

		$this->detect_service_payment = $payFor;

		$redirectBankController        = Load::controller( 'redirectBank' );
		$redirectBank   = $redirectBankController->redirectBankUrls();

		if ( $payFor == 'local' ) {

			foreach ( $requestID as $direction => $request_number ) {
				$this->amountToPay  += functions::CalculateDiscount( $request_number, 'yes' );
				$model              = Load::model( 'book_local' );
				$rec                = $model->GetInfoBookLocal( $request_number );
				$this->factorNumber = $rec['factor_number'];
			}
			if(isset($redirectBank) && !empty($redirectBank)) {
				$this->callBackPage = SERVER_HTTP.$redirectBank['replace_url'].'/gds/'.SOFTWARE_LANG.'/transferReturnBank&redirectUrl=processFlight';
			}
			else {
				$this->callBackPage = ROOT_ADDRESS . "/" . 'processFlight';
			}
		}
		elseif ( $payFor == 'hotelLocal' ) {

			$infoBook           = functions::GetInfoHotel( $requestID );
			$this->amountToPay  = $infoBook['hotel_payments_price'] > 0 ?  $infoBook['hotel_payments_price'] : $infoBook['total_price'];

			if($infoBook['payment_status'] =='fullPayment') {
				$this->amountToPay = $infoBook['total_price'] - $infoBook['hotel_payments_price'];
			}

			$this->factorNumber = $requestID;

			if(isset($redirectBank) && !empty($redirectBank)) {
				$this->callBackPage = SERVER_HTTP.$redirectBank['replace_url'].'/gds/'.SOFTWARE_LANG.'/transferReturnBank&redirectUrl=returnBankHotelNew';
			}else{
				$this->callBackPage = ROOT_ADDRESS . "/" . 'returnBankHotelNew';
			}


			$this->amountToPay  = $amount;


		}
		elseif ( $payFor == 'europcarLocal' ) {

			$infoBook           = functions::GetInfoEuropcar( $requestID );
			$this->amountToPay  = $infoBook['total_price'];
			$this->factorNumber = $requestID;

			if(isset($redirectBank) && !empty($redirectBank)) {
				$this->callBackPage = SERVER_HTTP.$redirectBank['replace_url'].'/gds/'.SOFTWARE_LANG.'/transferReturnBank&redirectUrl=returnBankEuropcarLocal';
			}else{
				$this->callBackPage = ROOT_ADDRESS . "/" . 'returnBankEuropcarLocal';
			}



		}
		elseif ( $payFor == 'reservationTourLocal' ) {

			$infoBook           = functions::GetInfoTour( $requestID );
			$this->amountToPay  = $infoBook['tour_payments_price'] > 0 ?  $infoBook['tour_payments_price'] : $infoBook['total_price'];
			if($infoBook['payment_status'] =='fullPayment') {
				$this->amountToPay = $infoBook['total_price'] - $infoBook['tour_payments_price'];
			}
			$this->factorNumber = $requestID;
			if(isset($redirectBank) && !empty($redirectBank)) {
				$this->callBackPage = SERVER_HTTP.$redirectBank['replace_url'].'/gds/'.SOFTWARE_LANG.'/transferReturnBank&redirectUrl=returnBankTourLocal';
			}else{
				$this->callBackPage = ROOT_ADDRESS . "/" . 'returnBankTourLocal';
			}



		}
		elseif ( $payFor == 'busTicket' ) {

			$infoBook           = functions::GetInfoBus( $requestID );
			$this->amountToPay  = $infoBook['total_price'];
			$this->factorNumber = $requestID;
			if(isset($redirectBank) && !empty($redirectBank)) {
				$this->callBackPage = SERVER_HTTP.$redirectBank['replace_url'].'/gds/'.SOFTWARE_LANG.'/transferReturnBank&redirectUrl=returnBankBusTicket&factorNumber=' . $requestID;
			}else{
				$this->callBackPage = ROOT_ADDRESS . "/" . 'returnBankBusTicket&factorNumber=' . $requestID;
			}



		}
		elseif ( $payFor == 'insurance' ) {

			$insurance          = Load::controller( 'insurance' );
			$insurancePrice     = $insurance->getTotalPriceByFactorNumber( $requestID );
			$this->amountToPay  = $insurancePrice['totalPrice'];


			$this->factorNumber = $requestID;
			if(isset($redirectBank) && !empty($redirectBank)) {
				$this->callBackPage = SERVER_HTTP.$redirectBank['replace_url'].'/gds/'.SOFTWARE_LANG.'/transferReturnBank&redirectUrl=returnBankInsurance';
			}else{
				$this->callBackPage = ROOT_ADDRESS . "/" . 'returnBankInsurance';
			}



		}
		elseif ( $payFor == 'reservationVisa' ) {
			$factorVisa         = Load::controller( 'factorVisa' );
			$infoBook           = $factorVisa->getVisaInfoByFactorNumber( $requestID );
			$this->amountToPay  = $infoBook['visa_prepayment_cost'] * $infoBook['reserveCount'];
			$this->factorNumber = $requestID;
			if(isset($redirectBank) && !empty($redirectBank)) {
				$this->callBackPage = SERVER_HTTP.$redirectBank['replace_url'].'/gds/'.SOFTWARE_LANG.'/transferReturnBank&redirectUrl=returnBankVisa';
			}else{
				$this->callBackPage = ROOT_ADDRESS . "/" . 'returnBankVisa';
			}


		}
		elseif ( $payFor == 'ReservationTicket' ) {

			$this->amountToPay  = $amount;
			$this->factorNumber = $requestID;
			if(isset($redirectBank) && !empty($redirectBank)) {
				$this->callBackPage = SERVER_HTTP.$redirectBank['replace_url'].'/gds/'.SOFTWARE_LANG.'/transferReturnBank&redirectUrl=returnBankReservationTicket';
			}else{
				$this->callBackPage = ROOT_ADDRESS . "/" . 'returnBankReservationTicket';
			}


		}
		elseif ( $payFor == 'Admin' ) {

			$this->amountToPay  = $amount;
			$this->factorNumber = rand( '000000000', '111111111' );
			$this->callBackPage = 'itadmin/ticket/returnBankAdminAgency';

		}
		elseif ( $payFor == 'clientCredit' ) {

			$this->amountToPay  = $amount;
			$this->factorNumber = $requestID;
			$this->callBackPage = ROOT_ADDRESS . "/" . 'uipanel/ewallet/returnBank';

		}
		elseif ( $payFor == 'App' ) {

			foreach ( $requestID as $direction => $request_number ) {
				$this->amountToPay  += functions::CalculateDiscount( $request_number, 'yes' );
				$model              = Load::model( 'book_local' );
				$rec                = $model->GetInfoBookLocal( $request_number );
				$this->factorNumber = $rec['factor_number'];
				$this->callBackPage = ROOT_ADDRESS_WITHOUT_LANG . "/" . 'app/ReturnBank/returnBankFlight.php?';
			}


		}
		elseif ( $payFor == 'hotelApp' ) {

			$this->factorNumber = $requestID;
			$this->callBackPage = ROOT_ADDRESS_WITHOUT_LANG . "/" . 'app/ReturnBank/returnBankHotel.php?';
			$infoHotel          = functions::getInfoHotel( $requestID );
			$this->amountToPay  = $infoHotel['total_price'];

		}
		elseif ( $payFor == 'gasht' ) {

			$factorGasht        = Load::controller( 'factorGasht' );
			$this->factorNumber = $requestID;
			$this->callBackPage = ROOT_ADDRESS . "/" . 'returnBankGasht';
			$factorGashtPrice   = $factorGasht->getTotalPriceByFactorNumber( $requestID );
			$this->amountToPay  = $factorGashtPrice['passenger_servicePriceAfterOff'] * $factorGashtPrice['passenger_number'];

		}
		elseif ( $payFor == 'train' ) {

			$factorTrain        = Load::controller( 'trainBooking' );
			$this->factorNumber = $requestID;
			$this->callBackPage = ROOT_ADDRESS . "/" . 'trainReturnBank';

			$this->amountToPay  = $factorTrain->TotalPriceByFactorNumber( $requestID );



		}
		elseif ( $payFor == 'Entertainment' ) {

			$objFactorEntertainment = Load::controller( 'entertainment' );
			$reserveInfo            = $objFactorEntertainment->GetInfoEntertainment( $requestID );
			$this->amountToPay      = $reserveInfo['DiscountPrice'];
			$this->factorNumber     = $requestID;
			$this->callBackPage     = ROOT_ADDRESS . "/" . 'returnBankEntertainment';

		}
		elseif ( $payFor == 'package' ) {

			$this->factorNumber = $requestID;
			$this->callBackPage = ROOT_ADDRESS . "/" . 'returnBankPackage';
			$this->amountToPay  = $amount;

		}
		elseif ( $payFor == 'onlinePayment' ) {

			$factorOnlinePayment = Load::controller( 'onlinePayment' );

			if(isset($redirectBank) && !empty($redirectBank)) {
				$this->callBackPage = SERVER_HTTP.$redirectBank['replace_url'].'/gds/'.SOFTWARE_LANG.'/transferReturnBank&redirectUrl=returnBankOnlinePayment';
			}else{
				$this->callBackPage = ROOT_ADDRESS . "/" . 'returnBankOnlinePayment' ;
			}
			$this->factorNumber = $requestID;

			$factorOnlinePaymentPrice   = $factorOnlinePayment->findOnlinePaymentByCode( $requestID );
			$this->amountToPay  = $amount ;


		}
		elseif($payFor == 'charge_credit_sign'){
			$this->factorNumber = $requestID;
			if(isset($redirectBank) && !empty($redirectBank)) {
				$this->callBackPage = SERVER_HTTP.$redirectBank['replace_url'].'/gds/'.SOFTWARE_LANG.'/transferReturnBank&redirectUrl=returnBankCreditAgency&factorNumber=' . $this->factorNumber  . '&type=creditAgency';
			}else{
				$this->callBackPage    = ROOT_ADDRESS . '/returnBankCreditAgency&factorNumber=' . $this->factorNumber  . '&type=creditAgency';
			}
			$this->amountToPay  = $amount ;
			$this->additionalData  = $additionalData ;
		}
		elseif($payFor == 'charge_credit_member'){
			$this->factorNumber = $requestID;

			if(isset($redirectBank) && !empty($redirectBank)) {
				$this->callBackPage = SERVER_HTTP.$redirectBank['replace_url'].'/gds/'.SOFTWARE_LANG.'/transferReturnBank&redirectUrl=returnChargeAccountUser&factorNumber=' . $this->factorNumber;
			}else{
				$this->callBackPage    = ROOT_ADDRESS . "/" . 'returnChargeAccountUser&factorNumber=' . $this->factorNumber;
			}

			$this->amountToPay  = $amount ;
		}
		elseif ( $payFor == 'exclusiveTour' ) {
			$bookModel = Load::getModel('exclusiveTourModel');
			$reserveInfo  = $bookModel->getOneByReq($requestID);
			$this->amountToPay  = $reserveInfo[0]['total_price'];
			$this->factorNumber = $reserveInfo[0]['factor_number'];
			if(isset($redirectBank) && !empty($redirectBank)) {
				$this->callBackPage = SERVER_HTTP.$redirectBank['replace_url'].'/gds/'.SOFTWARE_LANG.'/transferReturnBank&redirectUrl=returnBankExclusiveTour';
			}else{
				$this->callBackPage = ROOT_ADDRESS . "/" . 'returnBankExclusiveTour';
			}
		}	elseif ( $payFor == 'cip' ) {
			$bookModel = Load::getModel('cipModel');
			$reserveInfo  = $bookModel->getOneByReq($requestID);
			$this->amountToPay  = $reserveInfo[0]['total_price'];
			$this->factorNumber = $reserveInfo[0]['factor_number'];
			if(isset($redirectBank) && !empty($redirectBank)) {
				$this->callBackPage = SERVER_HTTP.$redirectBank['replace_url'].'/gds/'.SOFTWARE_LANG.'/transferReturnBank&redirectUrl=returnBankCip';
			}else{
				$this->callBackPage = ROOT_ADDRESS . "/" . 'returnBankCip';
			}
		}

		#region price changing by discount code and credits
		if ( isset( $_POST['discountCode'] ) || isset( $_POST['memberCreditUse'] ) ) {
			$arg      = array(
				'discountCode'    => FILTER_SANITIZE_STRING,
				'memberCreditUse' => FILTER_VALIDATE_BOOLEAN
			);
			$dataPost = filter_var_array( $_POST, $arg );
			$memberId = Session::getUserId();

			#region discount code
			if ( $dataPost['discountCode'] != '' ) {
				$discountCodes     = Load::controller( 'discountCodes' );
				$this->amountToPay = $discountCodes->reduceAmountViaDiscountCode( $this->amountToPay, $this->factorNumber, $memberId, $dataPost['discountCode'], $this->serviceType );

			}
			#endregion

			#region use member credit
			if ( $dataPost['memberCreditUse'] ) {
				$members           = Load::controller( 'members' );
				$this->amountToPay = $members->reduceAmountViaMemberCredit( $this->amountToPay, $this->factorNumber, $memberId );

			}
			#endregion
		}
		#endregion

		//region for user account charge
		if ( $_POST['serviceType'] == 'chargeAccountUser' ) {
			$this->amountToPay  = $_POST['price'];
			$this->factorNumber = $_POST['factorNumber'];
			$this->callBackPage = ROOT_ADDRESS . "/" . 'returnChargeAccountUser&factorNumber=' . $_POST['factorNumber'];

		}
		//endregion

		//region for user account charge agency subAgency fast
//		if ( $_POST['serviceType'] == 'increaseCreditAgency' ) {
////			$this->bankTitle       = 'pasargad';
////			$this->bankParam1      = '379918';
////			$this->bankParam2      = '384790';
////			$this->bankParam3      = '<RSAKeyValue><Modulus>vVYGdEx9XSxOY0+35rMTxdch/+6G9HdKHOGUsludVupUJjmM2fsA9FX33ds4yjh6TRk9JPEdA9H3kKRRYUUH4IAKviPxKUG5UW70E17otFUB3UEewQxDfPV+4EKgGguKUV6uO+tc7rhJ9ORoKh7qrYJcRG8srhPdAy3N5HmbK0E=</Modulus><Exponent>AQAB</Exponent><P>3Mnuzg8uEQj3upXCNzY2TWvw3b17aq1vZfKssq3auJyrtlE/VCqqZeKcncDDcHnz2SqmNCKtLjOtRWla9cHlnw==</P><Q>24f7Oz/03Rw424zn/D6bUAjBdskpY2t+PU+i3/rl68oqoZ7SZfu/d9ECKHPbw8NxbLaaSdcD1TwCUU/evWCDHw==</Q><DP>VTQMVzLeeS53w2aFs57VJ92O71NvLETP54zV/oI/FN1JGquR/94TMgxYmjxIb8BwTQ87YoU7RcglhtLYilyQSw==</DP><DQ>XBWD+mxvZ7gI2X8XaCVSvJWPoSXsKHnUcB9RcKYrf2ZDz5txIbohrD6Nqy4+BrWahEFsIoEAaJdNWZIpGkK7fQ==</DQ><InverseQ>UEuvirKmbzv+cuyXTtRxTPXcqQ/UvhghhGcbxl0dwcFZsjswCUZRfErAy5OrH+CW7dzfZxYz3LCsaA2qv6qcDw==</InverseQ><D>XbpHSa1P5h730yv0ku0VnbvJJgQzpLOk6bU2QjEeK5em/qFAu+wI5evk31wVue3JhX84CKCfx3NaxazCaI+evMdMFRv2F4Gqc7RBvnl3TcWlyZkEF/8iXH7OYqXpocVwCAgnfYWNQqlfANTEmUFhdMAT+biekC5goJ/K6FuGDm0=</D></RSAKeyValue>';
//			$this->amountToPay     = $_POST['price'];
//			$this->factorNumber    = $_POST['factorNumber'];
//			$this->callBackPage    = ROOT_ADDRESS . '/returnChargeAccountUser&factorNumber=' . $_POST['factorNumber'] . '&idMember=' . Session::getUserId() . '&type=creditAgency';
//			$this->bankServiceType = 'increaseCreditAgency';
//		}
		//endregion

	}
	#endregion

	#region executeBank: which bank to execut and go or return
	public function executeBank( $operation ) {


		if ( $operation == 'go' ) {

			$this->callBackURL = $this->callBackPage . "&bank=" . $this->selectedBank . ( ! empty( $this->bankServiceType ) ? "&serviceType=" . $this->bankServiceType : '' );

		}


		switch ( $this->selectedBank ) {
			case 'pasargad':
				return $this->executePasargad( $operation );
				break;

			case 'mellat':
				return $this->executeMellat( $operation );
				break;

			case 'keshavarzi':
				return $this->executeKeshavarzi( $operation );
				break;

			case 'irankish':

				return $this->executeIranKish( $operation );
				break;

			case 'mabnakartaria':
				return $this->executeMabnaKartAria( $operation );
				break;

			case 'samankish':
				return $this->executeSamanKish( $operation );
				break;

			case 'fanavacard':
				return $this->executeFanAvaCard( $operation );
				break;

			case 'parsian':
				return $this->executeParsian( $operation );
				break;

			case 'credit':
				return $this->executeFullCredit( $operation );
				break;
			case 'zarin':
				return $this->executeZarinPall( $operation );
				break;
			case 'idpay':
				return $this->executeIDPay( $operation );
				break;
			case 'yekpay':
				return $this->executeYekpay( $operation );
				break;
			case 'zain':
				return $this->executeZain( $operation );
				break;
			case 'saderat':
				return $this->executeSaderat( $operation );
				break;
			case 'nextpay':
				return $this->executeNextPay( $operation );
				break;
			case 'sadad':
				return $this->executeSadad( $operation );
				break;
			case 'sina':
				return $this->executeSina( $operation );
				break;
			case 'kippa':
				return $this->executeKippa( $operation );
				break;
			case 'payPing':
				return $this->executePayPing( $operation );
				break;
			case 'zarrinPlus':
				return $this->executeZarrinPlus( $operation );
				break;
			case 'selfit':
				return $this->executeSELFiT( $operation );
				break;
//			case 'centerCredit':
//				return $this->executeCenterCredit( $operation );
//				break;
			case 'publicBank':
				return $this->executePublicBank( $operation );
				break;
			case 'azKiVam':
				return $this->executeAzKiVamBank( $operation );
				break;
		}

		return false;

	}
	#endregion

	#region sendToBank
	public function sendToBank( $link, $data ) {
		echo '<script>sendForm("' . $link . '", \'' . json_encode( $data ) . '\');</script>';

	}
	#endregion

	#execution of Bank Pasargad
	public function executePasargad( $operation ) {

//		require_once( LIBRARY_DIR . "bank/pasargad/parser.php" );
//		require_once( LIBRARY_DIR . "bank/pasargad/RSAProcessor.class.php" );
		require_once( LIBRARY_DIR . 'bank/pasargad/pasargad.php');
		$client = new pasargad();

		if ( $operation == 'go' ) {
			$request['username']  = $this->bankParam1 ;
			$request['password']  = $this->bankParam2 ;
			$token = $client->getToken($request) ;

			if($token['success'] == true){
				$invoiceDate = date( "Y/m/d" );
				$sendArray['invoiceDate']     = $invoiceDate;
				$sendArray['invoice']   	  = $this->factorNumber;
				$sendArray['amount']          = intval($this->amountToPay);
				$sendArray['serviceCode']     = "8";
				$sendArray['serviceType']     = "PURCHASE";
				$sendArray['terminalNumber']  = $this->bankParam3;
				$sendArray['token']           = $token['data']['token'];
				$sendArray['callbackApi']	  = $this->callBackURL;

				functions::insertLog('before go ==>'.json_encode($sendArray,256),'logBankPasargad');


				$requestPurchase = $client->requestPayment($sendArray ) ;
				functions::insertLog('after go ==>'.json_encode($requestPurchase,256),'logBankPasargad');

				$save_data = [
					'urlId'		=> 	$requestPurchase['data']['urlId'],
					'invoice'	=> $this->factorNumber,
					'token'		=> $token['data']['token']
				];
				$client->insertLogHolds( $save_data ,'sina/logBankHoldPasargad');

//				if ( ( $this->bankParam1 == '379918' && $this->bankParam2 == '384790' ) && CLIENT_DOMAIN != 'online.indobare.com' ) {
//					$sendLink = "https://indobare.com/developer/pasargardRedirectBank.php";
//				} else {
//					$sendLink = 'https://pep.shaparak.ir/gateway.aspx';
//				}
				header('Location:'. $requestPurchase['data']['link'] );
			}
//			$processor   = new RSAProcessor( $this->bankParam3, RSAKeyType::XMLString );


		} elseif ( $operation == 'return' ) {
			$file =  file_get_contents(SITE_ROOT . "/logs/sina/logBankHoldPasargad.txt");
			$get_file = json_decode($file , true);
			$invoiceNumber = $_GET['invoiceId'] ;

			foreach ($get_file as $data ) {
				if($data['invoice'] == $invoiceNumber ){
					$result = $data ;
				}
			}

			$params['invoice'] = $data['invoice'];
			$params['urlId']   = $data['urlId'];
			$params['token']   = $data['token'];

			$verify_payment=$client->verifyPayment($params);

			functions::insertLog('verifyPayment : ' . json_encode([
					'$params'=>$params,
					'$verify_payment'=>$verify_payment,
				],256),'PasargadLog_verifyPayment');


			if ( $verify_payment['success'] ) {
				return $this->returnMethod(true,$operation,[
					'factorNumber'=>$verify_payment['data']['factorNumber'],
					'amount'=>$verify_payment['data']['amount'],
					'trackingCode'=>$verify_payment['data']['trackingCode'] ,
                    'transactionStatus'=>'success',
				]);
			} else {

				return $this->returnMethod(false,$operation,[
					'factorNumber'=>$verify_payment['data']['factorNumber'],
					'failMessage'=>$verify_payment['message'],
					'transactionStatus'=>'failed',
				]);
			}

//			$fields             = array( 'invoiceUID' => $_GET['tref'] );
//			$result             = post2https( $fields, 'https://pep.shaparak.ir/CheckTransactionResult.aspx' );
//			$array_buy          = makeXMLTree( $result );
//			$this->factorNumber = $array_buy["resultObj"]["invoiceNumber"];
//
//			functions::insertLog( 'after return bank by in=>' . $_GET['tref'] . ' array result is==>' . json_encode( $array_buy ), 'log_bank' );

//			if ( $array_buy["resultObj"]["result"] == "True" && $array_buy["resultObj"]["action"] == "1003" ) {
//
//				$processor      = new RSAProcessor( $this->bankParam3, RSAKeyType::XMLString );
//				$fields         = array(
//					'MerchantCode'  => $array_buy["resultObj"]["merchantCode"],
//					'TerminalCode'  => $array_buy["resultObj"]["terminalCode"],
//					'InvoiceNumber' => $array_buy["resultObj"]["invoiceNumber"],
//					'InvoiceDate'   => $array_buy["resultObj"]["invoiceDate"],
//					'amount'        => $array_buy["resultObj"]["amount"],
//					'TimeStamp'     => date( "Y/m/d H:i:s" ),
//					'sign'          => ''
//				);
//				$data           = "#" . $fields['MerchantCode'] . "#" . $fields['TerminalCode'] . "#" . $fields['InvoiceNumber'] . "#" . $fields['InvoiceDate'] . "#" . $fields['amount'] . "#" . $fields['TimeStamp'] . "#";
//				$data           = sha1( $data, true );
//				$data           = $processor->sign( $data );
//				$fields['sign'] = base64_encode( $data );
//				$verifyresult   = post2https( $fields, 'https://pep.shaparak.ir/VerifyPayment.aspx' );
//				$array_verify   = makeXMLTree( $verifyresult );
//				functions::insertLog( 'after verify bank by data=>' . json_encode( $data ) . ' verify with factorNumber=>' . $array_buy["resultObj"]["invoiceNumber"] . '==>' . json_encode( $array_verify ), 'log_bank' );
//				if ( $array_verify["actionResult"]["result"] == "True" ) { //success
//
//					$this->trackingCode = $array_buy["resultObj"]["transactionReferenceID"];
//
//				} else {
//					$this->failMessage       = functions::Xmlinformation( 'ErrorVerify' );
//					$this->transactionStatus = 'failed';
//				}
//			} else {
//				$this->failMessage       = functions::Xmlinformation( 'NoPayment' );
//				$this->transactionStatus = 'failed';
//			}

		}


	}
	#endregion

	#execution of Bank Mellat
	public function executeMellat( $operation ) {


		require_once( LIBRARY_DIR . "bank/mellat/nusoap.php" );

		if ( $operation == 'go' ) {

			sleep(1);
			try {
				$client = new nusoap_client( 'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl' );
			} catch ( Exception $e ) {
				$this->failMessage = functions::Xmlinformation( 'ErrorCallWebServices' ).'خطای اتصال فنی';
			}

			$namespace = 'http://interfaces.core.sw.bps.com/';
			$localDate = date( "Ymd" );
			$localTime = date( "His" );

			$parameters = array(
				'terminalId'     => $this->bankParam3,
				'userName'       => $this->bankParam1,
				'userPassword'   => $this->bankParam2,
				'orderId'        => $this->factorNumber,
				'amount'         => intval($this->amountToPay),
				'localDate'      => $localDate,
				'localTime'      => $localTime,
				'additionalData' => '',
				'callBackUrl'    => $this->callBackURL,
				'payerId'        => '0'
			);
			functions::insertLog('error before if1 params=> '.$this->factorNumber.' ==> '.json_encode($parameters),'logBnakMellat');

			$err = $client->getError();

			if ( $err ) {
			functions::insertLog('error before if1=> '.$this->factorNumber.' ==> '.json_encode($err),'logBnakMellat');
				$this->failMessage = functions::Xmlinformation( 'ErrorConnectBank' );
			} else {
				$result = $client->call( 'bpPayRequest', $parameters, $namespace );
				functions::insertLog('error after result=>'.$this->factorNumber.' ==> '.json_encode($result),'logBnakMellat');

				if ( $client->fault ) {
					$this->failMessage = functions::Xmlinformation( 'ErrorConnectBank' );
				} else {
					$resultStr = $result;
					$err       = $client->getError();

					if ( $err ) {
						functions::insertLog('error after if2=>'.$this->factorNumber.' ==> '.json_encode($err),'logBnakMellat');

						$this->failMessage = functions::Xmlinformation( 'ErrorConnectBank' );
					} else {
						$res     = explode( ',', $resultStr );
						$ResCode = $res[0];
						if ( $ResCode == '0' ) {

							$sendLink           = 'https://bpm.shaparak.ir/pgwchannel/startpay.mellat';
							$sendArray['RefId'] = $res[1];
							$this->sendToBank( $sendLink, $sendArray );

						} else {
							functions::insertLog('lastElse=>'.$this->factorNumber.' ==> '.json_encode($ResCode),'logBnakMellat');

							$this->failMessage = functions::Xmlinformation( 'ErrorConnectBank' ) . ' ' . $ResCode;
						}
					}
				}
			}

		} elseif ( $operation == 'return' ) {

			date_default_timezone_set( "Asia/Tehran" );
			$ResultCode         = $_POST["ResCode"];
			$SaleReferenceId    = $_POST["SaleReferenceId"];
			$this->factorNumber = $_POST["SaleOrderId"];
			functions::insertLog('$ResultCode=>'.$this->factorNumber.' ==> '.json_encode($ResultCode),'logBankMellatConfirm');
			if ( $ResultCode == 0 ) {
				try {
					$client = new nusoap_client( 'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl' );
				} catch ( Exception $e ) {
					$this->failMessage = functions::Xmlinformation( 'ErrorConnectBank' );;
					$this->transactionStatus = 'failed';
				}

				$namespace  = 'http://interfaces.core.sw.bps.com/';
				$parameters = array(
					'terminalId'      => $this->bankParam3,
					'userName'        => $this->bankParam1,
					'userPassword'    => $this->bankParam2,
					'orderId'         => $this->factorNumber,
					'saleOrderId'     => $this->factorNumber,
					'saleReferenceId' => $SaleReferenceId
				);
				functions::insertLog(' before bpVerifyRequest=>'.$this->factorNumber.' ==> '.json_encode([$parameters,$namespace]),'logBankMellatConfirm');
				sleep(1);
				$result     = $client->call( 'bpVerifyRequest', $parameters, $namespace );
				functions::insertLog('bpVerifyRequest=>'.$this->factorNumber.' ==> '.json_encode([$result,gettype($result),$client->getError()]),'logBankMellatConfirm');
				if ( strval($result) === '0') { //success

					$settle = $client->call( 'bpSettleRequest', $parameters, $namespace );
					functions::insertLog('settle=>'.$this->factorNumber.' ==> '.json_encode([$settle,gettype($settle),$client->getError()]),'logBankMellatConfirm');
                    if (strval($settle) === '0') {
                    functions::insertLog('after settle=>'.$this->factorNumber.' ==> '.json_encode([$settle,gettype($settle),$client->getError()]),'logBankMellatConfirm');
                        $this->trackingCode = $SaleReferenceId;
                    }else{
						$this->transactionStatus = 'failed';
					}
					functions::insertLog('*****************************************************************','logBankMellatConfirm');

				} else {
//					$client->call( 'bpReversalRequest', $parameters, $namespace );
					$this->failMessage       = functions::Xmlinformation( 'ErrorVerify' );
					$this->transactionStatus = 'failed';
					functions::insertLog('*****************************************************************','logBankMellatConfirm');

				}
			} else {
				$this->failMessage       = functions::Xmlinformation( 'NoPayment' );
				$this->transactionStatus = 'failed';
				functions::insertLog('*****************************************************************','logBankMellatConfirm');

			}

		}

	}
	#endregion

	#execution of Bank Keshavarzi
	public function executeKeshavarzi( $operation ) {

		require_once( LIBRARY_DIR . 'bank/keshavarzi/ipgcfg.php' );
		$WebServiceUrl = "https://services.asanpardakht.net/paygate/merchantservices.asmx?WSDL";

		if ( $operation == 'go' ) {

			$localDate      = date( "Ymd His" );
			$additionalData = '';
			$req            = "1,{$this->bankParam1},{$this->bankParam2},{$this->factorNumber},{$this->amountToPay},{$localDate},{$additionalData},{$this->callBackURL},0";
			//اگر قصد واريز پول به چند شبا را داريد، خط زير را به رشته بالايی اضافه کنيد
			// ,Shaba1,Mablagh1,Shaba2,Mablagh2,Shaba3,Mablagh3
			//حداکثر تا 7 شبا می‌توانيد به رشته خود اضافه کنيد
			$encryptedRequest = encrypt( $this->bankParam4, $this->bankParam5, $req );

			try {
				$opts   = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false ) );
				$params = array( 'stream_context' => stream_context_create( $opts ) );
				$client = @new soapclient( $WebServiceUrl, $params );
			} catch ( SoapFault $E ) {
				$this->failMessage = functions::Xmlinformation( 'ErrorCallWebServices' );
			}

			$params = array(
				'merchantConfigurationID' => $this->bankParam3,
				'encryptedRequest'        => $encryptedRequest
			);

			$result = $client->RequestOperation( $params );
			if ( $result->RequestOperationResult ) {

				$result = $result->RequestOperationResult;
				if ( $result{0} == '0' ) {

					$sendLink           = 'https://asan.shaparak.ir/';
					$sendArray['RefId'] = substr( $result, 2 );
					$this->sendToBank( $sendLink, $sendArray );

				} else {
					$this->failMessage = functions::Xmlinformation( 'ErrorConnectBank' ) . ':' . $result;
				}

			} else {
				$this->failMessage = functions::Xmlinformation( 'ErrorCallMethodBank' );
			}

		} elseif ( $operation == 'return' ) {

			$ReturningParams    = $_POST['ReturningParams'];
			$ReturningParams    = decrypt( $this->bankParam4, $this->bankParam5, $ReturningParams );
			$RetArr             = explode( ",", $ReturningParams );
			$this->amountToPay  = $RetArr[0];
			$this->factorNumber = $RetArr[1];
			$ResCode            = $RetArr[3];
			$PayGateTranID      = $RetArr[5];

			if ( $ResCode != '0' && $ResCode != '00' ) {
				$this->failMessage       = functions::Xmlinformation( 'NoPayment' );
				$this->transactionStatus = 'failed';
			} else {
				//تراکنش با موفقیت صورت پذیرفت
				$this->trackingCode = $PayGateTranID;

				try {
					$opts   = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false ) );
					$params = array( 'stream_context' => stream_context_create( $opts ) );
					$client = @new soapclient( $WebServiceUrl, $params );
				} catch ( SoapFault $E ) {
					$this->failMessage       = functions::Xmlinformation( 'ErrorCallWebServices' );
					$this->transactionStatus = 'failed';
				}

				$encryptedCredintials = encrypt( $this->bankParam4, $this->bankParam5, "{$this->bankParam1},{$this->bankParam2}" );
				$params               = array(
					'merchantConfigurationID' => $this->bankParam3,
					'encryptedCredentials'    => $encryptedCredintials,
					'payGateTranID'           => $this->trackingCode
				);

				//Verify
				$result = $client->RequestVerification( $params );
				if ( $result->RequestVerificationResult ) {
					if ( $result->RequestVerificationResult != '500' ) {
						$this->failMessage       = functions::Xmlinformation( 'ErrorVerify' ) . ':' . $result->RequestVerificationResult;
						$this->transactionStatus = 'failed';
					}
				} else {
					$this->failMessage       = functions::Xmlinformation( 'ErrorVerify' );
					$this->transactionStatus = 'failed';
				}

				//Settlment
				$result = $client->RequestReconciliation( $params );
				if ( $result->RequestReconciliationResult ) {
					if ( $result->RequestReconciliationResult != '600' ) {
						$this->failMessage       = functions::Xmlinformation( 'ErrorSettlement' ) . ': ' . $result->RequestReconciliationResult;
						$this->transactionStatus = 'failed';
					}
				} else {
					$this->failMessage       = functions::Xmlinformation( 'ErrorSettlement' );
					$this->transactionStatus = 'failed';
				}

			}

		}

	}
	#endregion

	#execution of Bank IranKish
	public function executeIranKish( $operation ) {

		require_once( LIBRARY_DIR . 'bank/irankish/iranKish.php' );
		$client = new iranKish();

		$params['amount'] = $this->amountToPay;


		$params['terminal_id'] = $this->bankParam1;
		$params['factor_number'] = $this->factorNumber;
		$params['password'] = $this->bankParam2;
		$params['pub_key'] = $this->bankParam3;
		$params['acceptor_id'] = $this->bankParam4;
		$params['revertURL'] = $this->callBackURL;

		if ( $operation == 'go' ) {
			$request_payment=$client->requestPayment($params);

			functions::insertLog('after log==>'.json_encode($request_payment,256),'logRequestBankIranKish');

			if ( $request_payment['success'] ) {
				$link   = $request_payment['data']['url'];
				$inputs = [
					'tokenIdentity'=>$request_payment['data']['tokenIdentity']
				];
				$this->sendToBank( $link, $inputs );
			} else {
				$this->failMessage = functions::Xmlinformation( 'ErrorConnectBank' );
			}
		} elseif ( $operation == 'return' ) {


			$params['amount'] = $this->amountToPay;
			$params['terminal_id'] = $this->bankParam1;
			$params['factor_number'] = $this->factorNumber;
			$params['password'] = $this->bankParam2;
			$params['token'] = $_POST['token'];


			$request_payment=$client->verifyPayment($params);


			functions::insertLog('after verify==>'.json_encode($request_payment,256),'logBankIranKish');

			if ( $request_payment['success'] ) {
				$this->factorNumber = $request_payment['data']['factorNumber'];
				$this->trackingCode = $request_payment['data']['trackingCode'];
			} else {
				$this->failMessage = $request_payment['data']['description'];
			}



		}

	}
	#endregion

	public function indexChanger($params)
	{
		foreach ($params as $key => $param) {
			$this->$key = $param;
		}
	}

	/**
	 * attention:
	 * if u want to use some bank as admins default bank
	 * you need to add this methode
	 * btw you can change it if you have some better way.
	 * @param $status true|false
	 * @param $operation 'go'|'return'
	 * @param $params array
	 * @return array|void
	 */
	public function returnMethod($status, $operation, $params)
	{
		if ($this->return_immediately) {
			return $params;
		}
		if ($operation == 'go') {
			if ($status) {
				$this->sendToBank($params['link'], $params['inputs']);
			} else {
				$this->indexChanger($params);
			}
		} else {
			$this->indexChanger($params);
		}
	}

	#execution of Next Pay
	public function executeNextPay( $operation ) {

 /* return $this->returnMethod(false,$operation,array(
            'failMessage'=>'اختلال در اتصال به درگاه بانکی',
        ));*/
//		return false ;

		require_once( LIBRARY_DIR . 'bank/nextpay/nextPay.php' );


		$client = new nextPay();


		if ( $operation == 'go' ) {

			$params['amount'] = $this->amountToPay;
			$params['api_key'] = $this->bankParam1;

			$params['factor_number'] = $this->factorNumber;
			$params['revertURL'] = $this->callBackURL;

			$request_payment=$client->requestPayment($params);

			functions::insertLog('requestPayment : ' . json_encode([
				'params'=>$params,
				'request_payment'=>$request_payment,
				],256),'nextpayLog_verifyPayment');


			if ( $request_payment['success'] ) {
				$trans_id   = $request_payment['data']['trans_id'];
				$link   = 'https://nextpay.ir/nx/gateway/payment/'.$trans_id;
				$inputs = [];

				$array_data = array(
					'link'=>$link,
					'inputs'=>$inputs
				);

				if($this->return_immediately){
					return functions::withSuccess($array_data);
				}else{
					return $this->returnMethod(true,$operation,$array_data);
				}

			} else {
				if($this->return_immediately){
					return functions::withError(array('failMessage'=>functions::Xmlinformation( 'ErrorConnectBank' )->__toString()),'401',functions::Xmlinformation( 'ErrorConnectBank' )->__toString());
				}else{
					return $this->returnMethod(false,$operation,array(
						'failMessage'=>functions::Xmlinformation( 'ErrorConnectBank' )->__toString(),
					));
				}

			}
		} elseif ( $operation == 'return' ) {

			if($this->amountToPay == 0){
				$this->amountToPay=(filter_var( $_GET['amount'], FILTER_SANITIZE_NUMBER_INT ))*10;
			}
			$params['api_key'] = $this->bankParam1;
			$params['amount'] = $this->amountToPay;
			$params['trans_id'] = $_GET['trans_id'];


			$verify_payment=$client->verifyPayment($params);

			functions::insertLog('verifyPayment : ' . json_encode([
					'$params'=>$params,
					'$verify_payment'=>$verify_payment,
				],256),'nextpayLog_verifyPayment');


			if ( $verify_payment['success'] ) {
				return $this->returnMethod(true,$operation,[
					'factorNumber'=>$verify_payment['data']['factorNumber'],
					'amount'=>$verify_payment['data']['amount'],
					'trackingCode'=>$verify_payment['data']['trackingCode']
				]);
			} else {

				return $this->returnMethod(false,$operation,[
					'factorNumber'=>$verify_payment['data']['factorNumber'],
					'failMessage'=>$verify_payment['message'],
					'transactionStatus'=>'failed',
				]);
			}

		}

	}
	#endregion


	#execution of Sadad
	public function executeSadad( $operation ) {
		require_once( LIBRARY_DIR . 'bank/sadad/sadad.php');
		$client = new sadad();

		$params['merchant'] = $this->bankParam1;
		$params['terminal'] = $this->bankParam2;
		$params['api_key'] = $this->bankParam3;
		$params['amount'] = $this->amountToPay;
		$params['factor_number'] = $this->factorNumber;
		$params['revertURL'] = $this->callBackURL;

		if ( $operation == 'go' ) {



			$request_payment=$client->requestPayment($params);

			functions::insertLog('requestPayment : ' . json_encode([
					'params'=>$params,
					'request_payment'=>$request_payment,
				],256),'sadadLog_request_payment');


			if ( $request_payment['success'] ) {
				$token   = $request_payment['data']['token'];
				$link   = $request_payment['data']['link'];
				$inputs = [];





				$array_data = array(
					'link'=>$link,
					'inputs'=>$inputs
				);


				if($this->return_immediately){
					return functions::withSuccess($array_data);
				}else{
					header('Location:'.$link);
//					return $this->returnMethod(true,$operation,$array_data);
				}

			} else {
				if($this->return_immediately){
					return functions::withError(array('failMessage'=>functions::Xmlinformation( 'ErrorConnectBank' )->__toString()),'401',functions::Xmlinformation( 'ErrorConnectBank' )->__toString());
				}else{
					return $this->returnMethod(false,$operation,array(
						'failMessage'=>functions::Xmlinformation( 'ErrorConnectBank' )->__toString(),
					));
				}

			}
		} elseif ( $operation == 'return' ) {



			$params['factor_number'] = $_POST['OrderId'];
			$params['token'] = $_POST['token'];
			$params['res_code'] = $_POST['ResCode'];


			$verify_payment=$client->verifyPayment($params);

			functions::insertLog('verifyPayment : ' . json_encode([
					'$params'=>$params,
					'$verify_payment'=>$verify_payment,
				],256),'nextpayLog_verifyPayment');


			if ( $verify_payment['success'] ) {
				return $this->returnMethod(true,$operation,[
					'factorNumber'=>$verify_payment['data']['factorNumber'],
					'amount'=>$verify_payment['data']['amount'],
					'trackingCode'=>$verify_payment['data']['trackingCode']
				]);
			} else {

				return $this->returnMethod(false,$operation,[
					'factorNumber'=>$verify_payment['data']['factorNumber'],
					'failMessage'=>$verify_payment['message'],
					'transactionStatus'=>'failed',
				]);
			}

		}

	}
	#endregion

	#execution of Bank Mabna Kart Aria
	public function executeMabnaKartAria( $operation ) {

		require_once( LIBRARY_DIR . 'bank/mabnakartaria/requirements.php' );
		require_once( LIBRARY_DIR . 'bank/mabnakartaria/sessions.php' );
		require_once( LIBRARY_DIR . 'bank/mabnakartaria/nusoap.new.php' );

		if ( $operation == 'go' ) {

			$__AMT    = $this->amountToPay;
			$__CRN    = $this->factorNumber;
			$__MID    = ! empty( $__MID ) ? $__MID : null;
			$__TID    = ! empty( $__TID ) ? $__TID : null;
			$__REFADD = $this->callBackURL;

			if ( isset( $this->amountToPay ) ) {
				require_once( LIBRARY_DIR . 'bank/mabnakartaria/do.php' );
			}

			if ( $VERIFY_RESULT == 1 ) {

				$sendLink           = 'https://mabna.shaparak.ir';
				$sendArray['TOKEN'] = $WS_RESULT["return"]["token"];
				$this->sendToBank( $sendLink, $sendArray );

			} elseif ( $VERIFY_RESULT == 0 ) {
				$this->failMessage = functions::Xmlinformation( 'ErrorConnectBank' );
			} else {
				$this->failMessage = functions::Xmlinformation( 'ErrorSignBank' );
			}

		} elseif ( $operation == 'return' ) {

			$__AMT              = ! empty( $_POST['amount'] ) ? $_POST['amount'] : null;
			$__CRN              = ! empty( $_POST['CRN'] ) ? $_POST['CRN'] : null;
			$__TRN              = ! empty( $_POST['TRN'] ) ? $_POST['TRN'] : null;
			$__RESCODE          = ! empty( $_POST['RESCODE'] ) ? $_POST['RESCODE'] : null;
			$__MID              = ! empty( $__MID ) ? $__MID : null;
			$__TID              = ! empty( $__TID ) ? $__TID : null;
			$this->factorNumber = $__CRN;

			if ( ! empty( $__RESCODE ) && ! is_null( $__RESCODE ) ) {

				require_once( LIBRARY_DIR . 'bank/mabnakartaria/verify.php' );

				if ( ! empty( $WSResult['return']['RESCODE'] ) ) {

					//تراکنش با موفقیت صورت پذیرفت
					if ( ( $WSResult['return']['RESCODE'] == '00' ) && ( $WSResult['return']['successful'] == true ) ) {

						$this->trackingCode = $__TRN;

					} else {
						$this->failMessage       = functions::Xmlinformation( 'NoPayment' );
						$this->transactionStatus = 'failed';
					}
				} else {
					$this->failMessage       = functions::Xmlinformation( 'ErrorVerify' );
					$this->transactionStatus = 'failed';
				}
			} else {
				$this->failMessage       = functions::Xmlinformation( 'ErrorCallWebServices' );
				$this->transactionStatus = 'failed';
			}

		}

	}
	#endregion

	#execution of Bank SamanKish
	public function executeSamanKish( $operation ) {

		if ( $operation == 'go' ) {
//			$bankUrl               = 'https://sep.shaparak.ir/MobilePG/MobilePayment';
			$bankUrl               = 'https://sep.shaparak.ir/OnlinePG/OnlinePG';
			$params['Action']      = 'Token';

			$params['Amount']      = $this->amountToPay;



			$params['TerminalId']  = $this->bankParam1;
			$params['ResNum']      = $this->factorNumber;
			$params['RedirectURL'] = $this->callBackURL;
			$params['CellNumber']  = ''; //شماره موبایل دارنده کارت
			$params['ResNum1']  = $this->additionalData;
//			Load::autoload( 'apiLocal' );
//			$api    = new apiLocal();
//			$result = $api->curlExecution( $bankUrl, $params,'yes' );

        functions::insertLog('before payment==>'.json_encode($params,256),'SamanKish');

			$result = functions::curlExecution($bankUrl,json_encode($params,256),'json');

        functions::insertLog('after payment==>'.json_encode($result,256),'SamanKish');
			if ( isset( $result['token'] ) ) {

//				$sendLink           = 'https://sep.shaparak.ir/MobilePG/MobilePayment';
				$sendLink           = 'https://sep.shaparak.ir/OnlinePG/OnlinePG';
				$sendArray['Token'] = $result['token'];
				functions::insertLog('before return 0==>'. Session::IsLogin() . '----' . $this->factorNumber,'logBankHotelato');

				$this->sendToBank( $sendLink, $sendArray );
			} else {
				$this->failMessage = functions::Xmlinformation( 'ErrorConnectBank' ).serialize($result);
			}

		}
		elseif ( $operation == 'return' ) {

			require_once( LIBRARY_DIR . 'bank/samankish/nusoap.php' );
			functions::insertLog('request==>'.json_encode($_POST).'==> bank comes here','log_train_fateme');

			$resultCode         = trim( $_POST['Status'] ); // وضعیت تراکنش که برای تراکنش موفق عدد 2 میباشد
			$referenceDigit     = trim( $_POST['RefNum'] ); // رسید دیجیتالی خرید
			$this->factorNumber = trim( $_POST['ResNum'] );
			$referenceId        = trim( $_POST['TraceNo'] ); // شناسه مرجع که بانک میسازه و قابل پیگیری هست
			$amount             = trim( $_POST['Amount'] );

			if ( $resultCode == '2' ) {
				functions::insertLog('request==>'.$this->factorNumber.'==> bank comes here','log_train_fateme');

				//تراکنش با موفقیت صورت پذیرفت
				$soapclient = new nusoap_client( 'https://sep.shaparak.ir/payments/referencepayment.asmx?WSDL', 'wsdl' );
				$soapProxy  = $soapclient->getProxy();
				$result     = $soapProxy->VerifyTransaction( $referenceDigit, $this->bankParam1 );
				functions::insertLog('after verify==>'.json_encode([$result,$_POST],256),'logBankSamanKish');



				if ( $result > 0 && $result == $amount ) {

					$this->trackingCode = $referenceId;

				} else {

					$this->failMessage       = functions::Xmlinformation( 'ErrorVerify' );
					$this->transactionStatus = 'failed';
				}
			} else {

				$this->failMessage       = functions::Xmlinformation( 'NoPayment' );
				$this->transactionStatus = 'failed';
			}
		}

	}
	#endregion

	#execution of Bank Fan Ava Card
	public function executeFanAvaCard( $operation ) {

		if ( $operation == 'go' ) {

			$sendLink                 = 'https://fcp.shaparak.ir/_ipgw_/payment/simple/';
			$sendArray['Amount']      = $this->amountToPay;
			$sendArray['ResNum']      = $this->factorNumber;
			$sendArray['MID']         = $this->bankParam1;
			$sendArray['RedirectURL'] = $this->callBackURL;
			$sendArray['Language']    = 'fa';
			$this->sendToBank( $sendLink, $sendArray );

		} elseif ( $operation == 'return' ) {

			require_once( LIBRARY_DIR . 'bank/fanavacard/nusoap.php' );
			$resultCode         = trim( $_POST['State'] ); // وضعیت تراکنش که برای تراکنش موفق عدد 2 میباشد
			$refNum             = trim( $_POST['RefNum'] ); // شماره پیگیری تراکنش
			$this->factorNumber = trim( $_POST['ResNum'] );
			$amount             = trim( $_POST['transactionAmount'] );

			if ( $resultCode == 'OK' ) {

				//تراکنش با موفقیت صورت پذیرفت
				$info           = new stdClass();
				$info->username = $this->bankParam1;
				$info->password = $this->bankParam2;
				$soapclient     = new nusoap_client( 'https://FCP.shaparak.ir/ref-payment/jax/merchantAuth?wsdl', true );
				$loginResult    = $soapclient->call( 'login', array( 'loginRequest' => $info ) );

				$contextInfo              = new stdClass();
				$contextInfo->data        = new stdClass();
				$contextInfo->data->entry = array( 'key' => 'SESSION_ID', 'value' => $loginResult['return'] );

				$requestInfo             = new stdClass();
				$requestInfo->refNumList = $refNum;

				$soapclient   = new nusoap_client( 'https://FCP.shaparak.ir/ref-payment/jax/merchantAuth?wsdl', true );
				$verifyResult = $soapclient->call( 'verifyTransaction', array( 'context' => $contextInfo, 'verifyRequest' => $requestInfo ) );
				functions::insertLog('after verify==>'.json_encode($verifyResult,256),'logBankFanava');
				$amount = $verifyResult['return']['verifyResponseResults']['amount'];
				$error  = $verifyResult['return']['verifyResponseResults']['verificationError'];

				$errorHandler[ TRANSACTION_NOT_FOUND_ERROR ]   = functions::Xmlinformation( 'NoFindTransaction' );
				$errorHandler[ TRANSACTION_IS_NOT_VERIFIABLE ] = functions::Xmlinformation( 'ReturnTranscationByBank' );
				$errorHandler[ INVALID_SESSION_EXCEPTION ]     = functions::Xmlinformation( 'SessionExpired' );
				$errorHandler[ VALIDATION_EXCEPTION ]          = functions::Xmlinformation( 'InvalidParameterBank' );
				$errorHandler[ SYSTEM_ERROR ]                  = functions::Xmlinformation( 'ErrorSystemBank' );

				if ( $error ) {

					$this->failMessage       = $errorHandler[ $error ];
					$this->transactionStatus = 'failed';

				} else {
					$this->trackingCode = $refNum;
				}

			} else {
				$this->failMessage       = functions::Xmlinformation( 'NoPayment' );
				$this->transactionStatus = 'failed';
			}

		}

	}
	#endregion

	#execution of Bank Parsian
	public function executeParsian( $operation ) {

		if ( $operation == 'go' ) {

			ini_set( 'soap.wsdl_cache_enabled', '0' );
			$wsdl_url = "https://pec.shaparak.ir/NewIPGServices/Sale/SaleService.asmx?WSDL";
			$params   = array(
				'LoginAccount' => $this->bankParam1,
				'Amount'       => $this->amountToPay,
				'OrderId'      => $this->factorNumber,
				'CallBackUrl'  => $this->callBackURL
			);
			$client   = new SoapClient( $wsdl_url );

			try {
				$result = $client->SalePaymentRequest( array( 'requestData' => $params ) );
				functions::insertLog( 'result bank parsian with factorNumber =>' . $this->factorNumber . ' With Price=>' . $this->amountToPay . ' With Param=>' . json_encode( $params ) . ' AND  Result=>' . json_encode( $result ), 'logBankParsian' );
				if ( $result->SalePaymentRequestResult->Token && $result->SalePaymentRequestResult->Status === 0 ) {

					$sendLink  = "https://pec.shaparak.ir/NewIPG/?Token=" . $result->SalePaymentRequestResult->Token;
					$sendArray = array();
					$this->sendToBank( $sendLink, $sendArray );

				} elseif ( $result->SalePaymentRequestResult->Status != '0' ) {

					$this->failMessage = $result->SalePaymentRequestResult->Message;

				}
			} catch ( Exception $ex ) {
				$this->failMessage = functions::Xmlinformation( 'ErrorCallWebServices' );
			}

		} elseif ( $operation == 'return' ) {

			$Token              = $_POST['Token'];
			$status             = $_POST['status'];
			$amount             = $_POST['Amount'];
			$this->factorNumber = $_POST['OrderId'];
			$wsdl_url           = "https://pec.shaparak.ir/NewIPGServices/Confirm/ConfirmService.asmx?WSDL";
			$params             = array(
				'LoginAccount' => $this->bankParam1,
				'Token'        => $Token
			);

			$client = new SoapClient( $wsdl_url );

			try {
				$result = $client->ConfirmPayment( array( 'requestData' => $params ) );
				functions::insertLog( 'result bank parsian with factorNumber =>' . $this->factorNumber . ' With Token=>' . $Token . ' With Result=>' . json_encode( $result ), 'logBankParsian' );
				if ( $result->ConfirmPaymentResult->Status != '0' ) {
					$this->failMessage       = ! empty( $result->ConfirmPaymentResult->Message ) ? $result->ConfirmPaymentResult->Message : functions::Xmlinformation( 'NoPayment' );
					$this->transactionStatus = 'failed';
					$this->token             = $Token;
				} else {
					$this->trackingCode = $_POST['RRN'];
					$this->factorNumber = $_POST['OrderId'];
					$this->token        = $Token;
				}

			} catch ( Exception $ex ) {
				$this->failMessage       = functions::Xmlinformation( 'ErrorCallWebServices' );
				$this->transactionStatus = 'failed';
				$this->token             = $Token;
			}

		} elseif ( $operation == 'reversal' ) {
			$wsdl_url = "https://pec.shaparak.ir/NewIPGServices/Reverse/ReversalService.asmx?WSDL";
			$params   = array(
				'LoginAccount' => $this->bankParam1,
				'Token'        => $_POST['Token']
			);

			$client = new SoapClient( $wsdl_url );

			try {
				$result = $client->ReversalRequest( array( 'requestData' => $params ) );
				functions::insertLog( 'ReversalRequest bank parsian with factorNumber =>' . $this->factorNumber . ' With Token=>' . $_POST['Token'] . ' With Result=>' . json_encode( $result ), 'logBankParsian' );

				$paramRevers['factorNumber']    = $_POST['OrderId'];
				$paramRevers['bankName']        = $this->selectedBank;
				$paramRevers['token']           = $_POST['Token'];
				$paramRevers['responsebank']    = json_encode( $result );
				$paramRevers['creationDate']    = dateTimeSetting::jdate( "Y-m-d H:i:s", time() );
				$paramRevers['creationDateInt'] = time();
				$transactionController          = Load::controller( 'transaction' );
				$transactionController->log_transaction_revers( $paramRevers );
			} catch ( Exception $ex ) {

			}
		}

	}
	#endregion

	#execution of full credit buy by online passenger
	public function executeFullCredit( $operation ) {

		if ( $operation == 'go' ) {

			$sendLink                  = $this->callBackURL;
			$sendArray['amount']       = $this->amountToPay;
			$sendArray['factorNumber'] = $this->factorNumber;
			$this->sendToBank( $sendLink, $sendArray );

		} elseif ( $operation == 'return' ) {

			$arg      = array(
				'amount'       => FILTER_VALIDATE_INT,
				'factorNumber' => FILTER_SANITIZE_STRING
			);
			$dataPost = filter_var_array( $_POST, $arg );

			if ( $dataPost['factorNumber'] != '' ) {

				$this->factorNumber = $dataPost['factorNumber'];
				$this->trackingCode = 'member_credit';

			} else {
				$this->failMessage       = functions::Xmlinformation( 'ErrorOfPayment' );
				$this->transactionStatus = 'failed';
			}

		}

	}
	#endregion

	#execution of Dargah Zarin
	public function executeZarinPall($operation)
	{

		require_once(LIBRARY_DIR . "bank/zarin/zarinpal_function.php");
		$client = new zarinpal();
		$amount=intval($this->amountToPay);

		if ($operation == 'go') {
			$callback_url = $this->callBackURL . '&FactorNumber=' . $this->factorNumber . '&amount=' . $amount;  // Required
			$params = [
				'merchant_id' => $this->bankParam1,
				'amount' => $amount,
				'description' => 'توضیحات تراکنش ',
				'email' => CLIENT_EMAIL,
				'mobile' =>CLIENT_MOBILE ,
				'callback_url' => $callback_url,
			];

			functions::insertLog('request' . json_encode($params, 256 | 64), 'log_bank_zarin_request_test');
			$request_payment = $client->requestPayment($params);
			functions::insertLog('response' . json_encode($request_payment, 256 | 64), 'log_bank_zarin_request_test');



			if ($request_payment['success']) {
				$authority = $request_payment['data']['data']['authority'];
				$link = $client->paymentUrl() . $authority;
				$inputs = [];

				$array_data = array(
					'link' => $link,
					'inputs' => $inputs
				);

				if ($this->return_immediately) {
					return functions::withSuccess($array_data);
				} else {
					return $this->returnMethod(true, $operation, $array_data);
				}

			} else {
				if ($this->return_immediately) {
					return functions::withError(array('failMessage' => functions::Xmlinformation('ErrorConnectBank')->__toString()), '401', functions::Xmlinformation('ErrorConnectBank')->__toString());
				} else {
					return $this->returnMethod(false, $operation, array(
						'failMessage' => functions::Xmlinformation('ErrorConnectBank')->__toString(),
					));
				}
			}

		}
		elseif ($operation == 'return') {
			if($this->amountToPay == 0){
				$this->amountToPay=(filter_var( $_GET['amount'], FILTER_SANITIZE_NUMBER_INT ));
				$amount=intval($this->amountToPay);
			}

			$params = array(
				"merchant_id" => $this->bankParam1,
				"authority" => $_GET['Authority'],
				"amount" => $amount
			);
			$this->factorNumber = $_GET['FactorNumber'];

			functions::insertLog('request' . json_encode($params, 256 | 64), 'log_bank_zarin_verify_test');
			$verify_payment = $client->verifyPayment($params);
			functions::insertLog('response' . json_encode($verify_payment, 256 | 64), 'log_bank_zarin_verify_test');


			if ($verify_payment['success']) {
				return $this->returnMethod(true, $operation, [
					'factorNumber' => $this->factorNumber,
					'amount' => $verify_payment['data']['data']['amount'],
					'trackingCode' => $verify_payment['data']['data']['ref_id']
				]);
			} else {
				return $this->returnMethod(false, $operation, [
					'factorNumber' => $this->factorNumber,
					'failMessage' => $client->error_message($verify_payment['data']['errors']['code']),
					'transactionStatus' => 'failed',
				]);
			}

		}


	}
	#endregion

	#execution of Bank executeIDPay
	public function executeIDPay( $operation ) {
		/*echo print_r($this);
		die();*/

		if ( $operation == 'go' ) {

			$bankUrl            = 'https://api.idpay.ir/v1.1/payment';
			$params['Action']   = 'Token';
			$params['order_id'] = $this->factorNumber;
			$params['amount']   = $this->amountToPay;
			$params['name']     = '';
			$params['phone']    = ''; //شماره موبایل دارنده کارت
			$params['mail']     = '';
			$params['desc']     = 'توضیحات پرداخت کننده';
			$params['callback'] = $this->callBackURL;


			$result = functions::curlExecution( $bankUrl, json_encode( $params, true ), [
				'Content-Type:application/json',
				'X-API-KEY:' . $this->bankParam3,
				'X-SANDBOX:0'
			] );

			functions::insertLog('result go bank=>'.json_encode($result),'logIdpay');

			if ( isset( $result['id'] ) ) {

				$sendLink        = $result['link'];
				$sendArray['id'] = $result['id'];
				$this->sendToBank( $sendLink, $sendArray );
			} else {
				$this->failMessage = functions::Xmlinformation( 'ErrorConnectBank' );
			}

		} elseif ( $operation == 'return' ) {


			$bankUrl            = 'https://api.idpay.ir/v1.1/payment/verify';
			$params['id']       = $_GET['id'];
			$params['order_id'] = $_GET['order_id'];


			if ( $_GET['status'] == '10' ) {
				$result = functions::curlExecution( $bankUrl, json_encode( $params, true ), [
					'Content-Type:application/json',
					'X-API-KEY:' . $this->bankParam3,
					'X-SANDBOX:1'
				] );


				if ( isset( $result['status'] ) && $result['status'] == '100' ) {
					//تراکنش با موفقیت صورت پذیرفت
					$sendLink        = $result['link'];
					$sendArray['id'] = $result['id'];

					$this->trackingCode = $result['track_id'];
					$this->factorNumber = $result['order_id'];

				} else {
					functions::insertLog( 'idPay in Error => ' . json_encode( $result, true ), 'log_idPay' );
					$this->failMessage       = functions::Xmlinformation( 'ErrorVerify' );
					$this->transactionStatus = 'failed';
				}
			} else {
				$this->failMessage       = functions::Xmlinformation( 'NoPayment' );
				$this->transactionStatus = 'failed';
			}
		}

	}
	#endregion

	#execution of Bank executeIDPay
	public function executeYekpay( $operation ) {
		require_once( LIBRARY_DIR . "bank/yekpay/yekpay.php" );
		$bankClass = new yekpay();

		$reportDetails = $bankClass->getDetailsForExteranlBank( $this->factorNumber, $this->detect_service_payment );
		//		$reportDetails['currency'] = Session::getCurrency();
		/** @var transaction $transaction */
		$transaction = Load::controller( 'transaction' );
		$description = $transaction->getTransactionByFactorNumber( $this->factorNumber );
		$bankParams  = [
			'param1'       => $this->bankParam1,
			'param2'       => $this->bankParam2,
			'param3'       => $this->bankParam3,
			'param4'       => $this->bankParam4,
			'param5'       => $this->bankParam5,
			'serviceTitle' => $this->bankServiceType,
			'isCurrency'   => $this->isCurrency,
		];

		$calculateCurrency = functions::CurrencyCalculate( $this->amountToPay );
		$amount            = $calculateCurrency['AmountCurrency'];

		/*todo: amount is added with 5 it must be deleted on the live*/
		$paymentParams = [
			'amount'       => number_format( $amount, 2, '.', '' ),
			'factorNumber' => $this->factorNumber,
			'serviceType'  => is_array( $this->serviceType ) ? $this->serviceType['dept'] : $this->serviceType,
			'callback'     => $this->callBackURL,
			'description'  => isset( $description['Comment'] ) ? $description['Comment'] : 'Testing comment',
			'extraData'    => $reportDetails
		];

		if ( $operation == 'go' ) {
			$requestResult = $bankClass->requestPayment( [ 'bank' => $bankParams, 'payment' => $paymentParams ] );

			if ( $requestResult['success'] ) {
				$link   = $requestResult['data']['url'];
				$inputs = [];
				$this->sendToBank( $link, $inputs );
			} else {
				$this->failMessage = functions::Xmlinformation( 'ErrorConnectBank' );
			}

		} elseif ( $operation == 'return' ) {
			$verify_params['bank']    = $bankParams;
			$verify_params['payment'] = $_POST;

			functions::insertLog( 'yekpay params : ' . json_encode( $verify_params ), '010yekpay' );

			$verify_result = $bankClass->verifyPayment( $verify_params );

			if ( $verify_result['success'] ) {
				$this->trackingCode = $verify_result['data']['Tracking'];
				$this->factorNumber = $verify_result['data']['OrderNo'];
			} else {
				$this->failMessage = $verify_result['message'];
				//				functions::insertLog( 'idPay in Error => ' . json_encode( $verify_result, true ), 'log_idPay' );
				//				$this->failMessage       = functions::Xmlinformation( 'ErrorVerify' );
				$this->transactionStatus = 'failed';
			}
			//			$bankUrl = '';
			//			$bankUrl            = $bankUrl . 'verify';
			//			$params['id']       = $_GET['id'];
			//			$params['order_id'] = $_GET['order_id'];
			//
			//
			//			if ( $_GET['status'] == '10' ) {
			//				$result = functions::curlExecution( $bankUrl, json_encode( $params, true ), [
			//					'Content-Type:application/json',
			//					'X-API-KEY:' . $this->bankParam3,
			//					'X-SANDBOX:1'
			//				] );
			//
			//
			//				if ( isset( $result['status'] ) && $result['status'] == '100' ) {
			//					//تراکنش با موفقیت صورت پذیرفت
			//					$sendLink        = $result['link'];
			//					$sendArray['id'] = $result['id'];
			//
			//					$this->trackingCode = $result['track_id'];
			//					$this->factorNumber = $result['order_id'];
			//
			//				} else {
			//					functions::insertLog( 'idPay in Error => ' . json_encode( $result, true ), 'log_idPay' );
			//					$this->failMessage       = functions::Xmlinformation( 'ErrorVerify' );
			//					$this->transactionStatus = 'failed';
			//				}
			//			} else {
			//				$this->failMessage       = functions::Xmlinformation( 'NoPayment' );
			//				$this->transactionStatus = 'failed';
			//			}
		}

	}
	#endregion

	#execution of Bank executeIDPay
	public function executeSaderat( $operation ) {
		if ( $operation == 'go' ) {
			$MerchantID          = $this->bankParam1;
			$Amount              = $this->amountToPay;
			$CallbackURL         = $this->callBackURL . '&FactorNumber=' . $this->factorNumber . '&amount=' . $this->amountToPay;  // Required
			$dataQuery           = 'Amount=' . $Amount . '&callbackURL=' . urlencode( $CallbackURL ) . '&InvoiceID=' . $this->factorNumber . '&TerminalID=' . $MerchantID . '&Payload=1';
			$AddressServiceToken = "https://sepehr.shaparak.ir:8081/V1/PeymentApi/GetToken";

			functions::insertLog( 'saderat in before request with factor_number=> ' .$this->factorNumber.' data is==>'. json_encode( $dataQuery, true ), 'log_request_saderat' );

			$response            = functions::curlExecution( $AddressServiceToken, $dataQuery );

			functions::insertLog( 'saderat in after request with factor_number=> ' .$this->factorNumber.' data is==>'. json_encode( $response, true ), 'log_request_saderat' );

			$decode_token_array  = ( $response );
			$status              = $decode_token_array['Status'];
			$access_token        = $decode_token_array['Accesstoken'];

			if ( ! empty( $access_token ) && $status == 0 ) {

				$AddressIpgPay = "https://sepehr.shaparak.ir:8080/pay";
				$sendArray     = array(
					'TerminalID' => $MerchantID,
					'token'      => $access_token,
					'getMethod'  => '1',
				);

				$this->sendToBank( $AddressIpgPay, $sendArray );
			} else {

				echo 'ERR: ' . $status;
			}
		}
		elseif ( $operation == 'return' ) {
			$this->factorNumber = $_GET['FactorNumber'];
			if ( $_GET['respcode'] == 0 ) {
				$digitalreceipt      = $_GET['digitalreceipt'];
				$respcode            = $_GET['respcode'];
				$amount              = $_GET['amount'];
				$rrn                 = $_GET['rrn'];
				$dataQuery           = 'digitalreceipt=' . $digitalreceipt . '&Tid=' . $respcode;
				$AddressServiceToken = "https://sepehr.shaparak.ir:8081/V1/PeymentApi/Advice";

				functions::insertLog( 'saderat in before advice with factor_number=> ' .$this->factorNumber.' data is==>'. json_encode( $dataQuery, true ), 'log_return_saderat' );

				$response            = functions::curlExecution( $AddressServiceToken, $dataQuery );

				functions::insertLog( 'saderat in after advice with factor_number=> ' .$this->factorNumber.' data is==>'. json_encode( $response, true ), 'log_return_saderat' );

				$decode_token_array  = ( $response );
				$status              = $decode_token_array['Status'];
				$return_id           = $decode_token_array['ReturnId'];
				$message             = $decode_token_array['Message'];
				if ( $respcode == 0 && $status == "Ok" && $return_id == $amount ) {
					$this->trackingCode = $rrn;
				} else {
					$this->failMessage       = functions::Xmlinformation( 'ErrorOfPayment' ) . ' ' . $message;
					$this->transactionStatus = 'failed';
				}
			} else {
				$this->failMessage       = functions::Xmlinformation( 'NoPayment' );
				$this->transactionStatus = 'failed';
			}
		}
	}
	#endregion

	#region
	public function executeZain( $operation ) {

		require_once( LIBRARY_DIR . "bank/zaincash/zain.php" );
		$zain = new zain();
		$reportDetails             = $zain->getDetailsForExteranlBank( $this->factorNumber, $this->detect_service_payment );
		$reportDetails['currency'] = Session::getCurrency();
		/** @var transaction $transaction */
		$transaction = Load::controller( 'transaction' );
		$description = $transaction->getTransactionByFactorNumber( $this->factorNumber );

		$bankParams = array(
			'param1'       => $this->bankParam1,
			'param2'       => $this->bankParam2,
			'param3'       => $this->bankParam3,
			'param4'       => $this->bankParam4,
			'param5'       => $this->bankParam5,
			'serviceTitle' => $this->bankServiceType,
			'isCurrency'   => $this->isCurrency,
		);

		$amount = functions::CurrencyCalculate( $this->amountToPay )['AmountCurrency'];

		$paymentParams = array(
			'amount'       => $amount,
			'factorNumber' => $this->factorNumber . sprintf( '%02d', mt_rand( 1, 99 ) ),
			'serviceType'  => is_array( $this->serviceType ) ? $this->serviceType['dept'] : $this->serviceType,
			'callback'     => $this->callBackURL,
			'description'  => $description,
			'extraData'    => $reportDetails
		);

		if ( $operation == 'go' ) {
			$requestResult = $zain->requestPayment( [ 'bank' => $bankParams, 'payment' => $paymentParams ] );
			functions::insertLog('after verify==>'.json_encode($requestResult,256),'logBankZain');

			if ( $requestResult['success'] ) {
				$link   = $requestResult['data']['url'];
				$inputs = [];
				$this->sendToBank( $link, $inputs );
			}
			$this->failMessage = functions::Xmlinformation( 'ErrorConnectBank' );

		} elseif ( $operation == 'return' ) {
			$verify_params['bank']                    = $bankParams;
			$verify_params['payment']                 = $_REQUEST;
			$verify_params['payment']['factorNumber'] = $this->factorNumber;


			$verify_result = $zain->verifyPayment( $verify_params );
			if ( $verify_result['success'] ) {
				$this->trackingCode = $verify_result['data']['tracking_code'];
			}
		}
	}
	#endregion


	public function executePublicBank($operation) {
		if ( $operation == 'go' ) {
			$api_url = "https://charter725.ir/webservice/bank_common/gettoken.php";
//			$api_url = "https://barakatalkawthar.com/webservice/bank_common/gettoken.php";

			$data_request = [
				'site_ID' => intval($this->bankParam1),
				'charge_type' => intval($this->bankParam2),
				'price' =>  intval($this->amountToPay)
			];
			$token = functions::curlExecution($api_url, $data_request);

			if (isset($token['token'])) {
				$data_payment=[
					'factor_number'=> $this->factorNumber,
					'token'=> $token['token']
				];
				Load::getModel('infoPaymentCharter724Model')->insertData($data_payment);
			$sendLink                  = "https://charter725.ir/webservice/bank_common/sendBank.php";
//			$sendLink                  = "https://barakatalkawthar.com/webservice/bank_common/sendBank.php";
				$sendArray =[
					'token'=> $token['token'],
					'ResNum' =>$this->factorNumber,
					'backUrl' => $this->callBackURL,
					'mobile' => '09383493154'
				];
				functions::insertLog('send data=> '.json_encode($sendArray,256|64),'publicBank');
			$this->sendToBank( $sendLink, $sendArray );
			}else{
				$this->failMessage = $token['token'];
			}

		}elseif ($operation=='return'){
			$this->factorNumber = $_GET['ResNum'];
			$get_data = Load::getModel('infoPaymentCharter724Model')->getDataByFactorNumber($this->factorNumber);
			$api_url = "https://charter725.ir/webservice/bank_common/verify_bank.php";
//			$api_url = "https://barakatalkawthar.com/webservice/bank_common/verify_bank.php";
			$data_request = [
				'site_ID' => $this->bankParam1,
				'token'=> $get_data['token'],
			];

			$check_status =  functions::curlExecution($api_url,$data_request);

			functions::insertLog('verify with factorNumber'.$this->factorNumber.'=> with request=>'.json_encode($data_request).' response=>'.json_encode($check_status),'publicBank');

			if($check_status['State']=='OK'){
				$this->trackingCode = $get_data['token'];
			} else {
				$this->failMessage       = functions::Xmlinformation( 'ErrorOfPayment' ) .'پرداخت تایید شده نیست';
				$this->transactionStatus = 'failed';
			}
		}
	}



	#execution of sina
	public function executeSina( $operation ) {
		require_once( LIBRARY_DIR . 'bank/sina/sina.php');
		$client = new sina();
		$params['merchant'] = $this->bankParam3; // code customer
		$params['factor_number'] = $this->factorNumber;
		$params['userId'] = $this->bankParam1;//user
		$params['token'] = $this->bankParam2;//password
		$params['amount'] = $this->amountToPay;
		$params['revertURL'] = $this->callBackURL;
//		$params['factorItems'] = [
//			'nationalId' => "0058904999",
//			'mobile' => CLIENT_MOBILE,
//			'description' =>"خرید اعتباری",
//			'amount' =>$this->amountToPay,
//			'date' =>dateTimeSetting::jdate( "Y/m/d", time() ),
//		];


		if ( $operation == 'go' ) {

			$requestResult=$client->requestPayment($params);
			functions::insertLog('requestPayment : ' . json_encode([
					'params'=>$params,
					'request_payment'=>$requestResult,
				],256),'logBankSina');

			$insertValues = array(
				'factor_number'     => $this->factorNumber,
				'amount'     => $this->amountToPay,
				'revertURL'     => $this->callBackURL,
				'transaction_id' => $requestResult['data']['data']['transaction_id']
			);

			$client->insertLogHolds( $insertValues,'sina/logBankHoldSina');


			if ( $requestResult['success'] ) {
				$link   = $requestResult['data']['data']['url'];
				header('Location:'.$link);
			}
			$this->failMessage = functions::Xmlinformation( 'ErrorConnectBank' );





		} elseif ( $operation == 'return' ) {
//			var_dump($_POST);
//			die();
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
			$file =  file_get_contents(SITE_ROOT . "/logs/sina/logBankHoldSina.txt");
			$get_file = json_decode($file , true);
			$last_item = end($get_file);


			$params = array(
				'transaction_id'     => $last_item['transaction_id'],
				'factor_number'     => $last_item['factor_number'],
				'amount'     => $last_item['amount'],
				'merchant'     => $this->bankParam3,
				'userId'     => $this->bankParam1,
				'token' => $this->bankParam2
			);

			$verify_payment=$client->verifyPayment($params);
//var_dump($verify_payment);
//die;
			functions::insertLog('verifyPayment : ' . json_encode([
					'params'=>$params,
					'verify_payment'=>$verify_payment,
				],256),'logReturnBankSina');

//	var_dump($verify_payment['data']['trackingCode']);
//	die;


			if ( $verify_payment['success'] ) {
				return $this->returnMethod(true,$operation,[
					'factorNumber'=>$verify_payment['data']['factorNumber'],
					'amount'=>$verify_payment['data']['amount'],
					'trackingCode'=>$verify_payment['data']['factorNumber']
				]);
			}
			else {

				return $this->returnMethod(false,$operation,[
					'factorNumber'=>$verify_payment['data']['factorNumber'],
					'failMessage'=>$verify_payment['message'],
					'transactionStatus'=>'failed',
				]);
			}

		}
	}

	#execution of Bank Pasargad
	public function executeKippa( $operation ) {

		require_once( LIBRARY_DIR . 'bank/kippa/kippa.php');
		$client = new kippa();

		if ( $operation == 'go' ) {

			$invoiceDate = date( "Y/m/d H:i:s" );
			$sendArray['amount']          = intval($this->amountToPay);
			$sendArray['token']           = $this->bankParam1;
			$sendArray['callbackApi']	  = $this->callBackURL;
//			$sendArray['invoiceDate']     = $invoiceDate;
			$sendArray['invoice']   	  = $this->factorNumber;

			$requestPurchase = $client->requestPayment($sendArray ) ;

			functions::insertLog('requestPayment : ' . json_encode([
					'params'=>$sendArray,
					'request_payment'=>$requestPurchase,
				],256),'logBankKippa');



			if($requestPurchase['data']['Status'] == 200) {

				$sendLink           = $requestPurchase['data']['Content']['payment_url'];
				$sendArray['payment_token'] = $requestPurchase['data']['Content']['payment_token'];
				$this->sendToBank( $sendLink, $sendArray );
			}

			$this->failMessage = functions::Xmlinformation( 'ErrorConnectBank' );
		} elseif ( $operation == 'return' ) {

			$verify_params['payment'] = $_POST;

			functions::insertLog( 'kippa params : ' . json_encode( $verify_params ), 'logBankKippa' );

			$verify_result = $client->verifyPayment( $verify_params );
			functions::insertLog( 'kippa response : ' . json_encode( $verify_result ), 'logBankKippa' );

			if ( $verify_result['success'] ) {
				$this->trackingCode = $verify_result['data']['trackingCode'];
				$this->factorNumber = $verify_result['data']['factorNumber'];
			} else {
				$this->failMessage = $verify_result['message'];
				$this->transactionStatus = 'failed';
			}
		}


	}
	#endregion

	##execution of Bank payPing
	public function executePayPing( $operation ) {

		require_once( LIBRARY_DIR . 'bank/payPing/payPing.php');
		$client = new payPing();


		if ( $operation == 'go' ) {

			$invoiceDate = date( "Y/m/d H:i:s" );
			$sendArray['Amount']          = intval($this->amountToPay)/10;
			$sendArray['ReturnUrl']          = $this->callBackURL;
			$sendArray['PayerIdentity']          = '09211559872';
			$sendArray['ClientRefId']          = $this->factorNumber;
			$sendArray['token']          = 	$this->bankParam1;
//			$sendArray['invoiceDate']     = $invoiceDate;
//			$sendArray['invoice']   	  = $this->factorNumber;

			$requestPurchase = $client->requestPayment($sendArray);

			functions::insertLog('requestPayment : ' . json_encode([
					'params'=>$sendArray,
					'request_payment'=>$requestPurchase,
				],256),'logBankPayPing');


			$sendLink           = $requestPurchase['data']['url'];
			$sendArray['PaymentRefId'] = $requestPurchase['data']['paymentCode'];

			header('Location:'. $sendLink );

		} elseif ( $operation == 'return' ) {
			$params = $_POST ;


			if($params['status'] == 1) {
				$params = json_decode($params['data'] , true) ;

				$verify_params['factorNumber'] = $params['clientRefId'];
				$verify_params['paymentRefId'] = $params['paymentRefId'];
				$verify_params['token']          = 	$this->bankParam1;
				$verify_params['amount']          = 	$params['gatewayAmount'];
				$verify_params['paymentCode']          = 	$params['paymentCode'];

				functions::insertLog( 'payPing params : ' . json_encode( $verify_params ), 'logBankPayPing' );

				$verify_result = $client->verifyPayment( $verify_params );
				functions::insertLog( 'payPing response : ' . json_encode( $verify_result ), 'logBankPayPing' );
//				if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//					var_dump($verify_result);
//					die;
//				}
				if ( $verify_result['success'] ) {

					$this->trackingCode = $verify_result['data']['trackingCode'];
					$this->factorNumber = $verify_result['data']['factorNumber'];
				} else {
					$this->failMessage = $verify_result['message'];
					$this->transactionStatus = 'failed';
				}
			}else{

				$this->transactionStatus = 'failed';
			}

		}


	}
	#endregion

	##execution of Bank payPing
	public function executeCenterCredit( $operation ) {

		require_once( LIBRARY_DIR . 'bank/centerCredit/centerCredit.php');
		$client = new centerCredit();

		if ( $operation == 'go' ) {

			$invoiceDate = date( "Y/m/d H:i:s" );
			$sendArray['AMOUNT']          = intval($this->amountToPay);
			$sendArray['CURRENCY']          = 'KZT';
			$sendArray['ORDER']          = $this->factorNumber;
			$sendArray['DESC']          = $this->factorNumber;
			$sendArray['MERCHANT']          = $this->bankParam1;
			$sendArray['MERCH_NAME']          = 'AVIATOP';
			$sendArray['MERCH_URL']          = $this->bankParam1;
			$sendArray['COUNTRY']          = 'KZ';
			$sendArray['TERMINAL']          = $this->bankParam1;
			$sendArray['TIMESTAMP']          = $invoiceDate;
			$sendArray['MERCH_GMT']          = '+6';
			$sendArray['TRTYPE']          = '0';
			$sendArray['LANG']          = SOFTWARE_LANG;
			$sendArray['NONCE']          = $this->bankParam3;
			$sendArray['BACKREF']          = $this->callBackURL;
			$sendArray['merchant_id']          = $this->bankParam1;
			$sendArray['return_url']          = $this->callBackURL;
			$sendArray['secret_key']          = $this->bankParam3;



////			$key = "6BB0AC02E47BDF73D98FEB777F3B5294";
////			$data = "6350.00339813355871446156812merchantname8888888811614202002240739211132F2B2DD7E603A7AAF5E1BC35DEE1F6C9A";
////			$decodedKey = pack("H\\*", $key);
////			echo hash_hmac("sha1", $data, $decodedKey);
//
//			$MERCH_NAME =	'00000001';
//			$ORDER = '27';
//			$AMOUNT = '400';
//			$CURRENCY = 398;
//			$secret_key = $sendArray['secret_key'];
//
//			$signature = hash_hmac('sha1', $MERCH_NAME . $ORDER . $AMOUNT . $CURRENCY, $secret_key);
			$signature = hash_hmac('sha1', $sendArray['merchant_id'] . $sendArray['ORDER'] . $sendArray['AMOUNT'] . $sendArray['CURRENCY'], $sendArray['secret_key']);


			$sendArray['signature']          = $signature;
			$sendArray['P_SIGN']          = $signature;

			$requestPurchase = $client->requestPayment($sendArray);
//			if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
//				var_dump($requestPurchase);
//				die();
//			}
			functions::insertLog('requestPayment : ' . json_encode([
					'params'=>$sendArray,
					'request_payment'=>$requestPurchase,
				],256),'logBankPayPing');


			$sendLink           = $requestPurchase['data']['url'];
			$sendArray['PaymentRefId'] = $requestPurchase['data']['paymentCode'];

			$this->sendToBank( $sendLink, $sendArray );
			$this->failMessage = functions::Xmlinformation( 'ErrorConnectBank' );
		}
		elseif ( $operation == 'return' ) {
			$params = $_POST['data'] ;
			$params = json_decode($params , true) ;
			$verify_params['clientRefId'] = (int)$params['clientRefId'];
			$verify_params['paymentCode'] = $params['paymentCode'];
			$verify_params['token']          = 	$this->bankParam1;

			functions::insertLog( 'payPing params : ' . json_encode( $verify_params ), 'logBankPayPing' );

			$verify_result = $client->verifyPayment( $verify_params );
			functions::insertLog( 'payPing response : ' . json_encode( $verify_result ), 'logBankPayPing' );

			if ( $verify_result['status'] ) {
				$this->PaymentRefId = $verify_result['data']['PaymentRefId'];
			} else {
				$this->failMessage = $verify_result['message'];
				$this->transactionStatus = 'failed';
			}
		}


	}
	#endregion

	##execution of Bank zarrinPlus
	public function executeZarrinPlus( $operation ) {

		require_once( LIBRARY_DIR . 'bank/zarrinPlus/zarrinPlus.php');
		$client = new zarrinPlus();



		if ( $operation == 'go' ) {


			$invoiceDate = date( "Y/m/d H:i:s" );
			$sendArray['amount']          = intval($this->amountToPay);
			$sendArray['cancel']          = 'http://www.mystore.com/cancel/';
//			$sendArray['success']          = 'http://www.mystore.com/success/';
			$sendArray['success']          = $this->callBackURL;
			$sendArray['item']          = $this->factorNumber;
			$sendArray['cellphone']          = '09151010724';
			$sendArray['email']          = 'yourname@domain.com';
			$sendArray['token']          = $this->bankParam1;
			$sendArray['ReturnUrl']          = $this->callBackURL;
//			$sendArray['ClientRefId']          = $this->factorNumber;
//			$sendArray['invoiceDate']     = $invoiceDate;
//			$sendArray['invoice']   	  = $this->factorNumber;


			functions::insertLog('ZarrinPlus Request Send: ' . json_encode($sendArray, 256), 'logBankZarrinPlus');

			$requestPurchase = $client->requestPayment($sendArray);

			functions::insertLog('ZarrinPlus Request Response: ' . json_encode($requestPurchase, 256), 'logBankZarrinPlus');
			// ذخیره لاگ مشابه پاسارگاد
			$save_data = [
				'authority'    => $requestPurchase['data']['authority'],
				'factorNumber' => $this->factorNumber,
				'token'        => $this->bankParam1,
				'amount'       => intval($this->amountToPay)
			];
			$logLine = json_encode($save_data) . "\n";
			file_put_contents(SITE_ROOT . "/logs/zarrinPlus/logBankHoldZarrinPlus.txt", $logLine, FILE_APPEND);

			header('Location:' . $requestPurchase['data']['redirect_url']);
			exit;


		}
        elseif ( $operation == 'return' ) {
            $params = $_GET;
			$file_path = SITE_ROOT . "/logs/zarrinPlus/logBankHoldZarrinPlus.txt";


			$authority = $_GET['authority'] ? $_GET['authority'] : null;
			if (!$authority) {
				return $this->returnMethod(false, $operation, [
					'failMessage' => 'کد authority دریافت نشد.',
					'transactionStatus' => 'failed',
				]);
			}


			$lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

			foreach ($lines as $line) {
				$data = json_decode($line, true);
				if (isset($data['authority']) && $data['authority'] === $authority) {
					$result = $data;
					break;
				}
			}

			if (!isset($result)) {
				return $this->returnMethod(false, $operation, [
					'failMessage' => 'اطلاعات تراکنش یافت نشد.',
					'transactionStatus' => 'failed',
				]);
			}

			$params = [
				'authority' => $authority,
				'token'     => $result['token'],
				'amount'    => $result['amount']
			];

			$verify_result = $client->verifyPayment($params);

			functions::insertLog('ZarrinPlus verifyPayment response: ' . json_encode([
					'params' => $params,
					'verify' => $verify_result
				], 256), 'logBankZarrinPlus');

			if ($verify_result['status']) {
				return $this->returnMethod(true, $operation, [
					'factorNumber'      => $result['factorNumber'],
					'amount'            => $result['amount'],
					'trackingCode'      => $verify_result['data']['trackingCode'],
					'transactionStatus' => 'success'
				]);
			} else {
				return $this->returnMethod(false, $operation, [
					'factorNumber'      => $result['factorNumber'],
					'failMessage'       => $verify_result['message'],
					'transactionStatus' => 'failed'
				]);
			}
		}


        }

	#endregion

	#region executeSELFiT
	public function executeSELFiT($operation) {
		require_once(LIBRARY_DIR . "bank/selfit/selfit.php");
		$selfit = new selfit();

		$bankParams = [
			'param1' => $this->bankParam1, // Username
			'param2' => $this->bankParam2, // Password
			'param3' => $this->bankParam3, // Custom data if needed
			'param4' => $this->bankParam4,
			'param5' => $this->bankParam5,
			'serviceTitle' => $this->bankServiceType,
			'isCurrency' => $this->isCurrency,
		];

		$amount = $this->amountToPay;
		if ($this->isCurrency) {
			$calculateCurrency = functions::CurrencyCalculate($this->amountToPay);
			$amount = $calculateCurrency['AmountCurrency'];
		}

		$paymentParams = [
			'amount' => $amount/10,
			'factor_number' => $this->factorNumber,
			'pay_for' => $this->detect_service_payment,
			'callback_url' => $this->callBackURL.'&factor_number='.$this->factorNumber,
			'description' => '',
			'extraData' => ''
		];

		if ($operation == 'go') {
			$requestResult = $selfit->requestPayment(['bank' => $bankParams, 'payment' => $paymentParams]);
			
			if ($requestResult['success']) {
				// Store the payment_id and token in the session or as URL parameters
				$_SESSION['selfit_payment_id'] = $requestResult['data']['id'];
				$_SESSION['selfit_token'] = $requestResult['data']['token'];
				
				// Add parameters to callback URL
				$callbackWithParams = $this->callBackURL . 
					'&payment_id=' . $requestResult['data']['id'] .
					'&token=' . $requestResult['data']['token'];
				
				$link = $requestResult['data']['url'];
				$inputs = [];
				
				// Log the payment request details
				functions::insertLog('SELFiT bank execution: ' . json_encode([
					'operation' => 'go',
					'payment_id' => $requestResult['data']['id'],
					'token' => $requestResult['data']['token'],
					'url' => $link
				], JSON_UNESCAPED_UNICODE), 'selfit_bank_log');
				
//				$this->sendToBank($link, $inputs);
				header('Location:'. $link );

			} else {
				// Enhanced error handling
				$errorMessage = isset($requestResult['message']) ? $requestResult['message'] : functions::Xmlinformation('ErrorConnectBank')->__toString();
				
				// Log the error
				functions::insertLog('SELFiT bank error: ' . json_encode([
					'operation' => 'go',
					'error' => $errorMessage,
					'result' => $requestResult
				], JSON_UNESCAPED_UNICODE), 'selfit_bank_error_log');
				
				$this->failMessage = $errorMessage;
				$this->transactionStatus = 'failed';
				
				// If this is specifically about a user not registered in SELFiT
				if (strpos($errorMessage, 'کاربر در سامانه سلفیت ثبت نام نشده است') !== false) {
					// You could redirect to a specific page or handle this special case
					// For now, we'll just set the error message
					$this->failMessage = $errorMessage;
					
					// Add additional handling if needed
					// For example: record this specific error for analytics
					functions::insertLog('SELFiT user not registered: ' . json_encode([
						'factor_number' => $this->factorNumber,
						'mobile' => isset($paymentParams['extraData']['mobile']) ? $paymentParams['extraData']['mobile'] : 'unknown'
					], JSON_UNESCAPED_UNICODE), 'selfit_user_not_registered');
				}
			}
		}
		elseif ($operation == 'return') {
			// Get the payment_id and token from session or URL
			$payment_id = isset($_GET['payment_id']) ? $_GET['payment_id'] : 
				(isset($_SESSION['selfit_payment_id']) ? $_SESSION['selfit_payment_id'] : '');
			$token = isset($_GET['token']) ? $_GET['token'] : 
				(isset($_SESSION['selfit_token']) ? $_SESSION['selfit_token'] : '');

			if(!isset($this->factorNumber)){
				$this->factorNumber=$_GET['factor_number'];
			}
			$verifyParams = [
				'factor_number' => $this->factorNumber,
				'payment_id' => $payment_id,
				'token' => $token
			];
			
			// Log the verification request details
			functions::insertLog('SELFiT bank execution: ' . json_encode([
				'operation' => 'return',
				'verify_params' => $verifyParams
			], JSON_UNESCAPED_UNICODE), 'selfit_bank_log');
			
			$verifyResult = $selfit->verifyPayment($verifyParams);
			
			if ($verifyResult['success']) {
				$this->trackingCode = $this->factorNumber;
				$this->transactionStatus = 'success';
			} else {
				// Enhanced error handling for verification errors
				$errorMessage = isset($verifyResult['message']) ? $verifyResult['message'] : 'پرداخت ناموفق بود';
				
				// Log the verification error
				functions::insertLog('SELFiT verification error: ' . json_encode([
					'factor_number' => $this->factorNumber,
					'error' => $errorMessage,
					'result' => $verifyResult
				], JSON_UNESCAPED_UNICODE), 'selfit_bank_error_log');
				
				$this->failMessage = $errorMessage;
				$this->transactionStatus = 'failed';
			}
		}
	}
	#endregion

	#execution of Bank PayStar
	public function executePayStar( $operation ) {

		require_once( LIBRARY_DIR . 'bank/payStar/payStar.php');
		$client = new paystar();

		if ( $operation == 'go' ) {

			$params['gateway_id'] = $this->bankParam1; // فرض: شناسه درگاه
			$params['amount'] = $this->amountToPay;
			$params['order_id'] = $this->factorNumber;
			$params['callback'] = $this->callBackURL;

			$request_payment = $client->requestPayment($params);

			functions::insertLog('requestPayment : ' . json_encode([
					'params' => $params,
					'request_payment' => $request_payment,
				], 256), 'logBankPaystar_request');

			if ( $request_payment['success'] ) {
				$link = $request_payment['data']['link'];

				if($this->return_immediately){
					return functions::withSuccess([
						'link' => $link,
						'inputs' => []
					]);
				}else{
					header('Location:' . $link);
				}
			} else {
				return $this->returnMethod(false, $operation, [
					'failMessage' => $request_payment['message'] ?? functions::Xmlinformation('ErrorConnectBank')->__toString(),
				]);
			}

		}
		elseif ( $operation == 'return' ) {
			$params['ref_num'] = isset($_POST['ref_num']) ? $_POST['ref_num'] : isset($_GET['ref_num']) ? $_GET['ref_num'] : '';
			$params['order_id'] = isset($_POST['order_id']) ? $_POST['order_id'] : isset($_GET['order_id']) ? $_GET['order_id'] : '';
			$params['tracking_code'] = isset($_POST['tracking_code']) ? $_POST['tracking_code'] : isset($_GET['tracking_code']) ? $_GET['tracking_code'] : '';
			//$params['amount'] = $this->amountToPay; مقدارش صفر بود تو تابع veryfy پرش می کنیم
			$params['gateway_id'] = $this->bankParam1;

			$verify_payment = $client->verifyPayment($params);

			functions::insertLog('verifyPayment : ' . json_encode([
					'params' => $params,
					'verify_payment' => $verify_payment,
				], 256), 'logBankPaystar_verify');

			if ( $verify_payment['success'] ) {
				return $this->returnMethod(true, $operation, [
					'factorNumber' => $verify_payment['data']['order_id'],
					'amount' => $verify_payment['data']['amount'],
					'trackingCode' => $verify_payment['data']['tracking_code'],
				]);
			} else {
				return $this->returnMethod(false, $operation, [
					'factorNumber' => $params['order_id'],
					'failMessage' => $verify_payment['message'],
					'transactionStatus' => 'failed',
				]);
			}
		}
	}
	#endregion
	private function executeAzKiVamBank_old($operation)
	{

		require_once( LIBRARY_DIR . 'bank/azKiVam/azKiVam.php');
		$client = new azKiVam();

		$params = [
			'merchant_id' => $this->bankParam1, // MerchantId
			'api_key' => $this->bankParam2,     // ApiKey
			'amount' => (int)$this->amountToPay,
			'redirect_uri' => $this->callBackURL,
			'fallback_uri' => $this->callBackURL . '&status=failed',
			'order_id' => $this->factorNumber,
			'item_url' => SERVER_HTTP . CLIENT_DOMAIN,
			'provider_id' => 123456 // اضافه کردن provider_id
		];

		if ($operation == 'go') {

			$result = $client->requestPayment($params);

			if ($result['success']) {
				$this->sendToBank($result['data']['payment_url'], []);
			} else {
				$this->failMessage = $result['message'];
			}
		} elseif ($operation == 'return') {
//			var_dump('aaaa');
//			echo json_encode($operation);
//			die;
			$verifyParams = [
				'merchant_id' => $this->bankParam1,
				'api_key' => $this->bankParam2,
				'ticket_id' => isset($_GET['ticketId']) ? $_GET['ticketId'] : '',
				'order_id' => $this->factorNumber
			];

			// ابتدا وضعیت پرداخت را بررسی کنید
			$statusResult = $client->getPaymentStatus([
				'merchant_id' => $this->bankParam1,
				'api_key' => $this->bankParam2,
				'ticket_id' => isset($_GET['ticketId']) ? $_GET['ticketId'] : ''
			]);

			if ($statusResult && $statusResult['rsCode'] == 0) {
				$status = isset($statusResult['result']['status']) ? $statusResult['result']['status'] : null;
				$validStatuses = [2, 6, 8]; // Verified, Settled, Done

				if (in_array($status, $validStatuses)) {
					// سپس پرداخت را تأیید کنید
					$result = $client->verifyPayment($verifyParams);

					if ($result['success']) {
						$this->trackingCode = $result['data']['trackingCode'];
					} else {
						$this->failMessage = $result['message'];
						$this->transactionStatus = 'failed';
					}
				} else {
					$this->failMessage = 'وضعیت پرداخت نامعتبر است';
					$this->transactionStatus = 'failed';
				}
			} else {
				$this->failMessage = 'خطا در بررسی وضعیت پرداخت';
				$this->transactionStatus = 'failed';
			}
		}
	}


	private function executeAzKiVamBank_old2($operation)
	{

		require_once( LIBRARY_DIR . 'bank/azKiVam/azKiVam.php');
		$client = new azKiVam();
//		bankParam1 = provider_id
//		bankParam2 = merchant_id
//		bankParam3 = username
//		bankParam4 = password
//		bankParam5 = mobile

		if ($operation == 'go') {


			$params = [
				'amount' => $this->amountToPay,
				'provider_id' => $this->bankParam1,
				'merchant_id' => $this->bankParam2,
				'username' => $this->bankParam3,
				'password' => $this->bankParam4,
				'factor_number' => $this->factorNumber,
				'revertURL' => $this->callBackURL,
				'item_url' => SERVER_HTTP . CLIENT_DOMAIN,
				'mobile_number' => $this->bankParam5
			];

			$request_payment = $client->requestPayment($params);
//			if(  $_SERVER['REMOTE_ADDR']=='5.201.144.255'  ) {
//				var_dump('aaaa');
//				echo json_encode($request_payment);
//				var_dump('bbbb');
//				die;
//			}
//			functions::insertLog('requestPayment: ' . json_encode([
//					'params' => $params,
//					'response' => $request_payment
//				], JSON_PRETTY_PRINT), 'azkivamLog');

			functions::insertLog('executeAzKiVamBank(go) - requestPayment response: ' . json_encode($request_payment, JSON_PRETTY_PRINT), 'azkivam/azkivamLog');

			if ($request_payment['success']) {
				$link = $request_payment['data']['payment_uri'];
				$inputs = [];

				$array_data = [
					'link' => $link,
					'inputs' => $inputs,
					'ticket_id' => $request_payment['data']['ticket_id'] // ذخیره ticket_id برای مرحله verify
				];

				if ($this->return_immediately) {
					return functions::withSuccess($array_data);
				} else {
					return $this->returnMethod(true, $operation, $array_data);
				}
			} else {
				if ($this->return_immediately) {
					return functions::withError(
						['failMessage' => $request_payment['message']],
						'401',
						$request_payment['message']
					);
				} else {
					return $this->returnMethod(false, $operation, [
						'failMessage' => $request_payment['message']
					]);
				}
			}
		} elseif ($operation == 'return') {
			$params = [
				'merchant_id' => $this->bankParam2,
				'ticket_id' => isset($_GET['ticketId']) ? $_GET['ticketId'] : '',
				'provider_id' => $this->bankParam1, // اصلاح شده - باید provider_id باشد
				'username' => $this->bankParam3,    // اضافه شده
				'password' => $this->bankParam4     // اضافه شده
			];
//			var_dump($params);
//			die;
			functions::insertLog('executeAzKiVamBank(return) - verifyPayment params: ' . json_encode($params, JSON_PRETTY_PRINT), 'azkivam/azkivamLog');

			$verify_payment = $client->verifyPayment($params);
//			echo json_encode($verify_payment);
//			die;
			functions::insertLog('executeAzKiVamBank(return) - verifyPayment response: ' . json_encode($verify_payment, JSON_PRETTY_PRINT), 'azkivam/azkivamLog');

			if ($verify_payment['success']) {
				return $this->returnMethod(true, $operation, [
					'factorNumber' => $verify_payment['data']['factorNumber'],
					'amount' => $verify_payment['data']['amount'],
					'trackingCode' => $verify_payment['data']['trackingCode']
				]);
			} else {
				return $this->returnMethod(false, $operation, [
					'factorNumber' => $this->factorNumber,
					'failMessage' => $verify_payment['message'],
					'transactionStatus' => 'failed'
				]);
			}
		}
	}

	private function executeAzKiVamBank($operation)
	{
		require_once(LIBRARY_DIR . 'bank/azKiVam/azKiVam.php');
		$client = new azKiVam();

		// لاگ اطلاعات بانک
		functions::insertLog('executeAzKiVamBank - Bank Params: ' . json_encode([
				'bankParam1' => $this->bankParam1,
				'bankParam2' => $this->bankParam2,
				'bankParam3' => $this->bankParam3,
				'bankParam4' => $this->bankParam4,
				'bankParam5' => $this->bankParam5,
				'amountToPay' => $this->amountToPay,
				'factorNumber' => $this->factorNumber,
				'callBackURL' => $this->callBackURL
			], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), 'azkivamLog');

		if ($operation == 'go') {
			$params = [
				'amount' => $this->amountToPay,
				'provider_id' => $this->bankParam1,
				'merchant_id' => $this->bankParam2,
				'username' => $this->bankParam3,
				'password' => $this->bankParam4,
				'factor_number' => $this->factorNumber,
				'revertURL' => $this->callBackURL,
				'item_url' => SERVER_HTTP . CLIENT_DOMAIN,
				'mobile_number' => $this->bankParam5
			];
//
			functions::insertLog('executeAzKiVamBank go() - requestPayment params: ' . json_encode($params, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), 'azkivamLog_go');

			$request_payment = $client->requestPayment($params);

			functions::insertLog('executeAzKiVamBank go() - requestPayment response: ' . json_encode($request_payment, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), 'azkivamLog_go');

			if ($request_payment['success']) {
				$link = $request_payment['data']['payment_uri'];
				$inputs = [];

				$array_data = [
					'link' => $link,
					'inputs' => $inputs,
					'ticket_id' => $request_payment['data']['ticket_id']
				];

				// لاگ لینک پرداخت
				functions::insertLog('executeAzKiVamBank _ticketIdddd_go() - Payment Link: ' . $link, 'azkivamLog');

				if ($this->return_immediately) {
					return functions::withSuccess($array_data);
				} else {
					return $this->returnMethod(true, $operation, $array_data);
				}
			} else {
				if ($this->return_immediately) {
					return functions::withError(
						['failMessage' => $request_payment['message']],
						'401',
						$request_payment['message']
					);
				} else {
					return $this->returnMethod(false, $operation, [
						'failMessage' => $request_payment['message']
					]);
				}
			}
		} elseif ($operation == 'return') {
			$ticketId = '';
			$status = '';
			// روش 1: استفاده از تابع parse_str برای پارامترهای QUERY_STRING
			if (isset($_SERVER['QUERY_STRING'])) {
				parse_str($_SERVER['QUERY_STRING'], $queryParams);
				$ticketId = isset($queryParams['ticketId']) ? $queryParams['ticketId'] : '';
				$status = isset($queryParams['status']) ? $queryParams['status'] : '';
			}

			// روش 2: بررسی مستقیم $_GET (اگر سرور به درستی پارامترها را parse کند)
			if (empty($ticketId)) {
				$ticketId = isset($_GET['ticketId']) ? $_GET['ticketId'] : '';
			}
			if (empty($status)) {
				$status = isset($_GET['status']) ? $_GET['status'] : '';
			}

			functions::insertLog('executeAzKiVamBank return() - Parsed Ticket ID: ' . $ticketId, 'azkivamLog');
			functions::insertLog('executeAzKiVamBank return() - Parsed Status: ' . $status, 'azkivamLog');

// لاگ تمام پارامترهای بازگشتی
			functions::insertLog('executeAzKiVamBank return() - GET Parameters: ' . json_encode($_GET, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), 'azkivamLog');
			functions::insertLog('executeAzKiVamBank return() - POST Parameters: ' . json_encode($_POST, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), 'azkivamLog');
			functions::insertLog('executeAzKiVamBank return() - SERVER Parameters: ' . json_encode([
					'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
					'HTTP_REFERER' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
					'REQUEST_URI' => $_SERVER['REQUEST_URI'],
					'QUERY_STRING' => isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : ''
				], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), 'azkivamLog');

// بررسی وضعیت پرداخت از پارامترهای بازگشتی
			$status = isset($_GET['status']) ? $_GET['status'] : (isset($_POST['status']) ? $_POST['status'] : '');
			$ticketId = isset($_GET['ticketId']) ? $_GET['ticketId'] : (isset($_POST['ticketId']) ? $_POST['ticketId'] : '');

			functions::insertLog('executeAzKiVamBank return() - Payment Status: ' . $status, 'azkivamLog');
			functions::insertLog('executeAzKiVamBank return() - Ticket ID: ' . $ticketId, 'azkivamLog');

// اگر وضعیت Failed است، پرداخت ناموفق بوده
			if ($status === 'Failed') {
				functions::insertLog('executeAzKiVamBank return() - Payment was failed or cancelled by user', 'azkivamLog');
				return $this->returnMethod(false, $operation, [
					'factorNumber' => $this->factorNumber,
					'failMessage' => 'پرداخت توسط کاربر لغو شد یا ناموفق بود',
					'transactionStatus' => 'cancelled',
					'ticketId' => $ticketId
				]);
			}

			$params = [
				'merchant_id' => $this->bankParam2,
				'ticket_id' => $ticketId,
				'provider_id' => $this->bankParam1,
				'username' => $this->bankParam3,
				'password' => $this->bankParam4
			];

			functions::insertLog('executeAzKiVamBank return() - verifyPayment params: ' . json_encode($params, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), 'azkivamLog');

			$verify_payment = $client->verifyPayment($params);

			functions::insertLog('executeAzKiVamBank return() - verifyPayment response: ' . json_encode($verify_payment, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), 'azkivamLog');

			if ($verify_payment['success']) {
				return $this->returnMethod(true, $operation, [
					'factorNumber' => $verify_payment['data']['factorNumber'],
					'amount' => $verify_payment['data']['amount'],
					'trackingCode' => $verify_payment['data']['trackingCode'],
					'ticketId' => $ticketId
				]);
			} else {
// بررسی نوع خطا
				$errorMessage = $verify_payment['message'];
				if (isset($verify_payment['data']['rsCode']) && $verify_payment['data']['rsCode'] == 28) {
					$errorMessage = 'پرداخت توسط کاربر لغو شد یا ناموفق بود';
				}

				return $this->returnMethod(false, $operation, [
					'factorNumber' => $this->factorNumber,
					'failMessage' => $errorMessage,
					'transactionStatus' => 'failed',
					'ticketId' => $ticketId
				]);
			}
		}
	}
	/**
	 * Special curl execution method for SELFiT API requests
	 * 
	 * @param string $url API endpoint URL
	 * @param mixed $data Request data (array or string)
	 * @param string $responseType Expected response type ('json' or other)
	 * @param array $extraParams Extra parameters for curl
	 * @param array $headers HTTP headers
	 * @param string $method HTTP method (GET/POST)
	 * @return mixed Response data
	 */
	public function selfitCurlExecution($url, $data = null, $responseType = 'json', $extraParams = [], $headers = [], $method = 'POST') {
		if (empty($headers)) {
			$headers = ['Content-Type: application/json'];
		}
		
		$ch = curl_init();
		
		// Set common curl options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		
		if ($method == 'POST') {
			curl_setopt($ch, CURLOPT_POST, true);
			if ($data) {
				if (is_array($data) && !in_array('Content-Type: application/x-www-form-urlencoded', $headers)) {
					$data = json_encode($data);
				}
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			}
		} else if ($method == 'GET' && $data) {
			// For GET requests with data, append as query parameters
			$queryParams = is_array($data) ? http_build_query($data) : $data;
			curl_setopt($ch, CURLOPT_URL, $url . (strpos($url, '?') ? '&' : '?') . $queryParams);
		}
		
		// Apply any extra parameters
		if (!empty($extraParams)) {
			foreach ($extraParams as $option => $value) {
				curl_setopt($ch, $option, $value);
			}
		}
		
		// Log request details
		functions::insertLog('SELFiT curl request: URL=' . $url . ', Headers=' . json_encode($headers) . 
			', Data=' . (is_array($data) ? json_encode($data) : $data) . 
			', Method=' . $method, 'selfit_log');
		
		// Execute the request
		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$error = curl_error($ch);
		
		curl_close($ch);
		
		// Log response
		functions::insertLog('SELFiT curl response: HTTP Code=' . $httpCode . 
			', Response=' . $response . 
			', Error=' . $error, 'selfit_log');
		
		// Parse response based on expected type
		if ($responseType == 'json') {
			$result = json_decode($response, true);
			if (!$result && $response) {
				return [
					'success' => false,
					'message' => 'Invalid JSON response: ' . $error,
					'response' => $response,
					'http_code' => $httpCode
				];
			}
			return $result;
		}
		
		return $response;
	}
}

?>
