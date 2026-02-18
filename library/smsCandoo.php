<?php

/**
 * Class smsCandoo
 * @property smsCandoo $smsCandoo
 */
class smsCandoo extends smsServicesAbstract {
	
	public $smsUserName = '';
	public $smsPassword = '';
	public $smsNumber = '';
	public $soapClient = '';
    public $token = '';
	/**
	 * smsCandoo constructor.
	 */
	public function __construct() {
	
	}
	
	#region init: initialize sms information
	public function init( $input ) {

        $this->smsUserName = $input['smsUsername'];
        $this->smsPassword = $input['smsPassword'];
        $this->smsNumber = $input['smsNumber'];
        $this->url = 'https://my.candoosms.com/services/rest/index.php';
        $this->token       = 'Authorization: AccessKey' . ' ' . $input['token'];
//        $this->soapClient = new SoapClient("https://my.candoosms.com/services/rest/index.php");
//        if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
//            var_dump($this->soapClient);
//            die();
//        }
	}
	#endregion
	
	
	#region initIrantechParam: initialize irantech sms information
//	public function initIrantechParam() {
//        $this->smsUserName = 'abazar_afshar';
//        $this->smsPassword = '123456';
//        $this->smsNumber = '989999178450';
//        $this->url = 'https://my.candoosms.com/services/rest/index.php';
//
//	}
	#endregion

	#region smsSend
	/**
	 * @param $input
	 *
	 * @return mixed
	 */
    public function smsSend($input) {

        $api_url = $this->url;
        $api_username = $this->smsUserName;
        $api_password = $this->smsPassword;
        $api_from = trim($this->smsNumber);

        $messages = [
            [
                'sender' => $api_from,
                'recipient' => $input['cellNumber'],
                'body' => $input['smsMessage'],
                'customerId' => isset($notification->user) ? $notification->user->id : '1',
            ]
        ];

        $request = [
            'username' => $api_username,
            'password' => $api_password,
            'method' => 'send',
            'messages' => $messages
        ];

        error_log('Request in Candoo=> '.json_encode($request) .'In Time=>'.date('Y/m/d H:i:s') . " \n", 3,  'CandooSMS.log');

        $res = $this->curlExecutionPost($api_url, $request);
        $status = $res['status'];
        error_log(PHP_EOL . json_encode($res), 3, 'CandooSMS.log');
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
//echo json_encode($output);
//die;
			$output  = $this->curlExecutionPost( $url, json_encode( $dataSms ) );
			error_log( 'url=>' . $url . ' && patternCode=>' . json_encode( $dataSms, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . "And response =>" . $output . " \n" . date( 'Y/m/d H:i:s' ) . " \n", 3, LOGS_DIR . 'logSms.txt' );
			
		}
		
	}


    private function curlExecutionPost($url, $data)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);


        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === FALSE) {
            $response = curl_error($ch);
        }

        curl_close($ch);

        return [
            'status' => $httpCode,
            'response' => $response
        ];
    }

    public function smsSendPattern($input) {

        $api_url = $this->url;
        $api_username = $this->smsUserName;
        $api_password = $this->smsPassword;
        $api_from = trim($this->smsNumber);

        $messages = [
            [
                'sender' => $api_from,
                'recipient' => $input['cellNumber'],
                'body' => $input['smsMessage'],
                'customerId' => isset($notification->user) ? $notification->user->id : '1',
            ]
        ];

        $request = [
            'username' => $api_username,
            'password' => $api_password,
            'method' => 'send',
            'messages' => $messages
        ];

        error_log('Request in Candoo=> '.json_encode($request) .'In Time=>'.date('Y/m/d H:i:s') . " \n", 3,  'CandooSMS.log');
//        if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
//            echo json_encode($request);
//            die();
//        }
        $res = $this->curlExecutionPost($api_url, $request);
        $status = $res['status'];
        error_log(PHP_EOL . json_encode($res), 3, 'CandooSMS.log');
    }


}