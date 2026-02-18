<?php
class smsMehrafraz extends smsServicesAbstract {

    public $smsUserName = '';
    public $smsPassword = '';
    public $smsNumber = '';
    public $soapClient = '';

    function __construct() {
        
    }

    #region init: initialize sms information
    public function init($input)
    {
        $this->smsUserName = $input['smsUsername'];
        $this->smsPassword = $input['smsPassword'];
        $this->smsNumber = $input['smsNumber'];
        $this->soapClient = new SoapClient("http://mehrafraz.com/webservice/Service.asmx?wsdl");
    }
    #endregion

    #region initIrantechParam: initialize irantech sms information
    public function initIrantechParam() {

        $this->smsUserName = 'irantech';
        $this->smsPassword = '09383493154Aba2';
        $this->smsNumber = 'agency';
        $this->soapClient = new SoapClient("http://mehrafraz.com/webservice/Service.asmx?wsdl");

    }
    #endregion

    #region smsSend
    public function smsSend($input) {

        $getID = substr(time(), 0, 2) . mt_rand(000, 999) . substr(time(), 8, 10);

        functions::insertLog('send input: ' . json_encode($input), 'log_smsService');
        $output = $this->soapClient->SendSms(
            array(
                'cUserName' => $this->smsUserName,
                'cPassword' => $this->smsPassword,
                'cBody' => $input['smsMessage'],
                'cSmsnumber' => $input['cellNumber'],
                'cGetid' => $getID,
                'nCMessage' => '1',
                'nTypeSent' => '1',
                'm_SchedulDate' => '',
                'cDomainname' => $this->smsNumber,
                'nSpeedsms' => '0',
                'nPeriodmin' => '0',
                'cstarttime' => '',
                'cEndTime' => ''
            )
        );
        functions::insertLog('send output: ' . json_encode($output), 'log_smsService');

        if($output->SendSmsResult >= 0){
            $return['result_status'] = 'success';
            $return['result_message'] = 'پیام با موفقیت ارسال شد';
            $return['result_code'] = $getID;
        } else{
            $return['result_status'] = 'error';
            $return['result_message'] = $this->smsErrorMessage($output->SendSmsResult);
            $return['result_code'] = $getID;
        }

        return $return;
    }
    #endregion

    #region smsErrorMessage
    public function smsErrorMessage($errorCode){

        $messages = array(
            '-1' => 'مقادیر ارسال شده صحیح نمی باشد',
            '-2' => 'نام کاربری و یا نام دامنه اشتباه می باشد',
            '-3' => 'رمز عبور اشتباه می باشد',
            '-4' => 'اعتبار کافی نمی باشد',
            '-5' => 'حساب شما مسدود شده است',
            '-6' => 'شماره گیرنده خالی است',
            '-9' => 'شماره گیرنده باید عدد باشد',
            '-21' => 'شماره فرستنده خالی است',
            '-44' => 'رمز عبور اشتباه می باشد، تنها 2 بار دیگر می توانید سعی کنید، در غیر این صورت حساب شما به مدت 3 دقیقه معلق خواهد شد',
            '-45' => 'رمز عبور اشتباه می باشد، تنها 1 بار دیگر می توانید سعی کنید، در غیر این صورت حساب شما به مدت 3 دقیقه معلق خواهد شد',
            '-46' => 'حساب شما به مدت 3 دقیقه معلق است',
            '-54' => 'طول پیام از حداکثر مجاز دریافتی این اپراتور بیشتر است'
        );

        if(!empty($messages[$errorCode])){
            return $messages[$errorCode];
        } else{
            return 'خطا در ارسال با کد ' . $errorCode;
        }
    }
    #endregion

    #region smsDeliveryCheck
    public function smsDeliveryCheck($successCode)
    {
        functions::insertLog('delivery input: ' . $successCode, 'log_smsService');
        $output = $this->soapClient->GetDeliveryWithGetid(
            array(
                'cUserName' => $this->smsUserName,
                'cPassword' => $this->smsPassword,
                'cGetid' => $successCode,
                'lReturnSid' => '0',
                'cDomainname' => $this->smsNumber
            )
        );
        functions::insertLog('delivery output: ' . json_encode($output), 'log_smsService');

        $return = $this->smsDeliveryMessage($output->GetDeliveryWithGetidResult->string);

        functions::insertLog('delivery return: ' . $return, 'log_smsService');

        return $return;
    }
    #endregion

    #region smsDeliveryMessage
    public function smsDeliveryMessage($deliveryCode){

        $messages = array(
            '0' => 'در صف ارسال',
            '1' => 'به مخابرات ارسال شده',
            '2' => 'رسیده به گوشی',
            '3' => 'نرسیده به گوشی',
            '4' => 'گیرنده در لیست سیاه قرار دارد',
            '5' => 'کارشناسی نشده',
            '6' => 'کنسل شده',
            '7' => 'مقصد ناشناخته',
            '8' => 'به BTS ارسال شد',
            '12' => 'به اپراتور ارسال نشده',
            '16' => 'در راه ارسال به BTS ناکام مانده'
        );

        if(!empty($messages[$deliveryCode])){
            return $messages[$deliveryCode];
        } else{
            return 'خطای تعریف نشده با کد ' . $deliveryCode;
        }
    }
    #endregion

    #region smsGetCredit
    public function smsGetCredit(){

        /*$output = $this->soapClient->GetuserInfo(
            array(
                'cUserName' => $this->smsUserName,
                'cPassword' => $this->smsPassword,
                'cDomainname' => $this->smsNumber
            )
        );

        if($output->GetuserInfoResult == '1'){
            return $output->GetuserInfoResult;
        } else{
            return 0;
        }*/
    }
    #endregion

}