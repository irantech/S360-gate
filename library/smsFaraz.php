<?php

/**
 * Class smsFaraz
 * @property smsFaraz $smsFaraz
 */
class smsFaraz extends smsServicesAbstract {
	
	public $smsUserName = '';
	public $smsPassword = '';
	public $smsNumber = '';
	public $soapClient = '';
	public $token = '';
	
	/**
	 * smsFaraz constructor.
	 */
	public function __construct() {
	
	}
	
	#region init: initialize sms information
	public function init( $input ) {
		$this->smsUserName = $input['smsUsername'];
		$this->smsPassword = $input['smsPassword'];
		$this->smsNumber   = $input['smsNumber'];
		$this->token       = 'Authorization: AccessKey' . ' ' . $input['token'];
		//        $this->soapClient = 'http://188.0.240.110/api/select';
		//		$this->soapClient = 'http://188.0.240.110/services.jspd';
		$this->soapClient = 'http://ippanel.com/services.jspd';
		//        $this->soapClient = 'http://rest.ippanel.com/v1/messages';
		
	}
	#endregion
	
	
	#region initIrantechParam: initialize irantech sms information
	public function initIrantechParam() {
		
		$this->smsUserName = 'irantech888';
		$this->smsPassword = '4hbhE374VWPw';
		$this->smsNumber   = '3000505';
		$this->token       = 'AccessKey ijlG3FbeO8jcsjfDscw66oRbVwm4BDuqzLMVH0FweOw=';
		//        $this->soapClient = 'http://rest.ippanel.com/v1/messages';
		$this->soapClient = 'http://ippanel.com/services.jspd';
		
	}
	#endregion
	
	#region sendSmsWithApi
	/*    public function smsSend($data)
		{
			$dataToSend = array(
				"originator" => "+983000505",
				"recipients" => $data['cellNumber'],
				"message" => $data['smsMessage']
			);
			$header = array(
				$this->token
			);
			functions::insertLog('url=>'. $this->soapClient. ' send input: ' . json_encode($dataToSend,256|64), 'log_smsService');
			$output = $this->curlExecutionPost($this->soapClient, $dataToSend,$header);
			functions::insertLog('send output: ' . json_encode($output), 'log_smsService');
		}*/
	#endregion
	
	
	#region smsSend
	/**
	 * @param $input
	 *
	 * @return mixed
	 */
	public function smsSend( $input ) {
		
		functions::insertLog( 'send input: ' . json_encode( $input ), 'log_smsService' );
		
		$dataSms = array(
			'op'      => 'send',
			'uname'   => $this->smsUserName,
			'pass'    => $this->smsPassword,
			'from'    => $this->smsNumber,
			'to'      => $input['cellNumber'],
			'message' => $input['smsMessage']
		);
		
		//        $this->soapClient ='http://ippanel.com/services.jspd';
		
		$output = $this->curlExecutionPost( $this->soapClient, $dataSms );
		functions::insertLog( 'send output: ' . json_encode( $output ), 'log_smsService' );
		if ( isset( $output[0] ) && $output[0] == '0' ) {
			$return['result_status']  = 'success';
			$return['result_message'] = 'پیام با موفقیت ارسال شد';
			$return['result_code']    = $output[1];
		} else {
			$return['result_status']  = 'error';
			$return['result_message'] = $this->smsErrorMessage( $output[0] );
			//            $return['result_message'] = '';
			$return['result_code'] = ( ! empty( $output[1] ) ) ? $output[1] : '';
		}
		
		return $return;
		
	}
	#endregion
	
	#region smsErrorMessage
	public function smsErrorMessage( $errorCode ) {
		$messages = array(
			'0'    => 'عملیات با موفقیت انجام شده است',
			'1'    => 'متن پیام خالی می باشد',
			'2'    => 'کاربر محدود گردیده است',
			'3'    => 'خط به شما تعلق ندارد',
			'4'    => 'گیرندگان خالی است',
			'5'    => 'اعتبار کافی نیست',
			'7'    => 'خط مورد نظر برای ارسال انبوه مناسب نمیباشد',
			'9'    => 'خط مورد نظر در این ساعت امکان ارسال ندارد',
			'98'   => 'حداکثر تعداد گیرنده رعایت نشده است',
			'99'   => 'اپراتور خط ارسالی قطع می باشد',
			'21'   => 'پسوند فایل صوتی نامعتبر است',
			'22'   => 'سایز فایل صوتی نامعتبر است',
			'23'   => 'تعداد تلاش در پیام صوتی نامعتبر است',
			'100'  => 'شماره مخاطب دفترچه تلفن نامعتبر می باشد',
			'101'  => 'شماره مخاطب در دفترچه تلفن وجود دارد',
			'102'  => 'شماره مخاطب با موفقیت در دفترچه تلفن ذخیره گردید',
			'111'  => 'حداکثر تعداد گیرنده برای ارسال پیام صوتی رعایت نشده است',
			'131'  => 'تعداد تلاش در پیام صوتی باید یکبار باشد',
			'132'  => 'آدرس فایل صوتی وارد نگردیده است',
			'301'  => 'از حرف ویژه در نام کاربری استفاده گردیده است',
			'266'  => 'ارسال با خط اشتراکی امکان پذیر نیست',
			'302'  => 'قیمت گذاری انجام نگریده است',
			'303'  => 'نام کاربری وارد نگردیده است',
			'304'  => 'نام کاربری قبلا انتخاب گردیده است',
			'305'  => 'نام کاربری وارد نگردیده است',
			'306'  => 'کد ملی وارد نگردیده است',
			'307'  => 'کد ملی به خطا وارد شده است',
			'308'  => 'شماره شناسنامه نا معتبر است',
			'309'  => 'شماره شناسنامه وارد نگردیده است',
			'310'  => 'ایمیل کاربر وارد نگردیده است',
			'311'  => 'شماره تلفن وارد نگردیده است',
			'312'  => 'تلفن به درستی وارد نگردیده است',
			'313'  => 'آدرس شما وارد نگردیده است',
			'314'  => 'شماره موبایل را وارد نکرده اید',
			'315'  => 'شماره موبایل به نادرستی وارد گردیده است',
			'316'  => 'سطح دسترسی به نادرستی وارد گردیده است',
			'317'  => 'کلمه عبور وارد نگردیده است',
			'455'  => 'ارسال در آینده برای کد بالک ارسالی لغو شد',
			'456'  => 'کد بالک ارسالی نامعتبر است',
			'458'  => 'کد تیکت نامعتبر است',
			'964'  => 'شما دسترسی نمایندگی ندارید',
			'962'  => 'نام کاربری یا کلمه عبور نادرست می باشد',
			'963'  => 'دسترسی نامعتبر می باشد',
			'971'  => 'پترن ارسالی نامعتبر است',
			'970'  => 'پارامتر های ارسالی برای پترن نامعتبر است',
			'972'  => 'دریافت کننده برای ارسال پترن نامعتبر می باشد',
			'992'  => 'ارسال پیام از ساعت 8 تا 23 می باشد',
			'993'  => 'دفترچه تلفن باید یک آرایه باش',
			'994'  => 'لطفا تصویری از کارت بانکی خود را از منو مدارک ارسال کنی',
			'995'  => 'جهت ارسال با خطوط اشتراکی سامانه، لطفا شماره کارت بانکی خود را به دلیل تکمیل فرایند احراز هویت از بخش ارسال مدارک ثبت نمایید',
			'996'  => 'پترن فعال نیست',
			'997'  => 'شما اجازه ارسال از این پترن را ندارید',
			'998'  => 'کارت ملی یا کارت بانکی شما تایید نشده است',
			'1001' => 'فرمت نام کاربری درست نمیباشد(حداقل ۵ کاراکتر، فقط حروف و اعداد)',
			'1002' => 'گذر واژه خیلی ساده میباشد(حداقل ۸ کاراکتر بوده و نامکاربری، ایمیل و شماره موبایل در آن وجود نداشته باشد)',
			'1004' => 'مشکل در ثبت، با پشتیبانی تماس بگیرید',
			'1005' => 'مشکل در ثبت، با پشتیبانی تماس بگیرید'
		);
		
		return ( isset( $messages[ $errorCode ] ) ) ? $messages[ $errorCode ] : 'خطا در ارسال با کد ' . $errorCode;
	}
	#endregion
	
	#region smsDeliveryCheck
	
	/**
	 * @param $successCode
	 *
	 * @return mixed|string
	 */
	public function smsDeliveryCheck( $successCode ) {
		$data   = array(
			'op'     => 'delivery',
			'uname'  => $this->smsUserName,
			'pass'   => $this->smsPassword,
			'uinqid' => $successCode
		);
		$output = $this->curlExecutionPost( $this->soapClient, $data );
		
		functions::insertLog( 'delivery input: ' . json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ), 'log_smsService' );
		functions::insertLog( 'delivery output: ' . json_encode( $output, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ), 'log_smsService' );
		$response = json_decode( $output[1] );
		
		/*this is to check if request success or not*/
		if ( $output[0] != '0' ) {
			return $this->smsErrorMessage( $response[0] );
		}
		if ( is_array( $response ) ) {
			foreach ( $response as $item ) {
				if ( strpos( $item, ":" ) !== false ) {
					$explode = explode( ':', $item );
					
					return $this->smsDeliveryMessage( $explode[1] );
				}
				
				return $this->smsDeliveryMessage( null );
			}
		}
		
		return $this->smsDeliveryMessage( null );
	}
	#endregion
	
	#region smsDeliveryMessage
	/**
	 * @param $deliveryCode
	 *
	 * @return mixed|string
	 */
	public function smsDeliveryMessage( $deliveryCode ) {
		
		if ( null == $deliveryCode ) {
			return 'خطای تعریف نشده با کد NULL';
		}
		
		$messages = array(
			'pending'   => 'به مخابرات ارسال شده',
			'failed'    => 'خطا در ارسال',
			'delivered' => 'رسیده به گوشی',
			'send'      => 'ارسال شده',
		);
		
		return isset( $messages[ $deliveryCode ] ) ? $messages[ $deliveryCode ] : "خطای تعریف نشده با کد {$deliveryCode}";
	}
	#endregion
	
	#region smsGetCredit
	public function smsGetCredit() {
		
		/*$output = $this->curlExecutionPost(
			$this->soapClient,
			array(
				'op' => 'credit',
				'uname' => $this->smsUserName,
				'pass' => $this->smsPassword
			)
		);

		if($output->GetCreditResult == '1'){
			return $output->GetCreditResult;
		} else{
			return 0;
		}*/
	}
	#endregion
	
	#origin pattern
	public function smsSendPattern( $input ) {
		if ( isset( $input['credit'] ) ) {
			$inputData[] = array( "credit" => $input['credit'] );
		} else {
			$inputData[] = $input['data'];
		}
		
		$url = "https://ippanel.com/api/select";
		
		$dataSms = array(
			'user'        => $this->smsUserName,
			'pass'        => $this->smsPassword,
			'fromNum'     => "3000505",
			'toNum'       => $input['cellNumber'],
			'patternCode' => $input['code'],
			'op'          => 'pattern',
			'inputData'   => $inputData,
		);

		$output = $this->curlExecutionPost( $url, json_encode( $dataSms ) );

        error_log( 'url=>' . $url . ' && patternCode=>' . json_encode( $dataSms, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . "And response =>" . json_encode( $output, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . " \n" . date( 'Y/m/d H:i:s' ) . " \n", 3, LOGS_DIR . 'logSms.txt' );
		
		if ( isset( $output->SendSmsResult ) && $output->SendSmsResult == '1' ) {
			$return['result_status']  = 'success';
			$return['result_message'] = 'پیام با موفقیت ارسال شد';
			$return['result_code']    = $output->recId->long;
		} else {
			$return['result_status'] = 'error';
			//$return['result_message'] = empty($this->smsErrorMessage($output->SendSmsResult));
			$return['result_message'] = '';
			$return['result_code']    = ( ! empty( $output->recId->long ) ) ? $output->recId->long : '';
		}
		
	}
	
	#endorigin
	
	public function smsByPattern( $patternCode, $mobiles = [], $patternVariables = [] ) {

		$url = "https://ippanel.com/api/select";
		foreach ( $mobiles as $mobile ) {
			$dataSms = array(
				'user'        => $this->smsUserName,
				'pass'        => $this->smsPassword,
				'fromNum'     => $this->smsNumber,
				'toNum'       => $mobile,
				'patternCode' => $patternCode,
				'op'          => 'pattern',
				'inputData'   => [ $patternVariables ],
			);

			$output  = $this->curlExecutionPost( $url, json_encode( $dataSms ) );
			error_log( 'url=>' . $url . ' && patternCode=>' . json_encode( $dataSms, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . "And response =>" . $output . " \n" . date( 'Y/m/d H:i:s' ) . " \n", 3, LOGS_DIR . 'logSms.txt' );
			
		}
		
	}
	
	#region curlExecutionPost
	public function curlExecutionPost( $url, $data, $header = null ) {
		functions::insertLog( 'send header===> ' . json_encode( $header ), 'log_smsService' );
		$handle = curl_init( $url );
		curl_setopt( $handle, CURLOPT_SSL_VERIFYHOST, 0 );
		curl_setopt( $handle, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt( $handle, CURLOPT_POST, true );
		curl_setopt( $handle, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $handle, CURLOPT_POSTFIELDS, $data );

		if(!empty($header)) {
            curl_setopt( $handle, CURLOPT_HTTPHEADER, $header );
        }

		
		$result = curl_exec( $handle );
		
		return json_decode( $result, true );
		
	}
	#endregion
	
}