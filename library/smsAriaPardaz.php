<?php
class smsAriaPardaz extends smsServicesAbstract {

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
        $this->soapClient = new SoapClient("http://ariapardaz.ir/post/send.asmx?WSDL");
    }
    #endregion

    #region smsSend
    public function smsSend($input) {

        functions::insertLog('send input: ' . json_encode($input), 'log_smsService');
        $output = $this->soapClient->SendSms(
            array(
                'username' => $this->smsUserName,
                'password' => $this->smsPassword,
                'from' => $this->smsNumber,
                'to' => array($input['cellNumber']),
                'text' => $input['smsMessage'],
                'isflash' => false,
                'udh' => '',
                'recId' => array(0),
                'status' => 0
            )
        );
        functions::insertLog('send output: ' . json_encode($output), 'log_smsService');

        settype($output->recId->long, 'string');

        if($output->SendSmsResult == '1'){
            $return['result_status'] = 'success';
            $return['result_message'] = 'پیام با موفقیت ارسال شد';
            $return['result_code'] = $output->recId->long;
        } else{
            $return['result_status'] = 'error';
            $return['result_message'] = $this->smsErrorMessage($output->SendSmsResult);
            $return['result_code'] = $output->recId->long;
        }

        return $return;
    }
    #endregion

    #region smsErrorMessage
    public function smsErrorMessage($errorCode){

        $messages = array(
            '0' => 'نام کاربری یا رمز عبور اشتباه می باشد',
            '1' => 'درخواست با موفقیت انجام شد',
            '2' => 'اعتبار کافی نمی باشد',
            '3' => 'محدودیت در ارسال روزانه',
            '4' => 'محدودیت در حجم ارسال',
            '5' => 'شماره فرستنده معتبر نمی باشد',
            '6' => 'سامانه در حال به روز رسانی می باشد',
            '7' => 'متن، حاوی کلمه فیلتر شده می باشد'
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
        $output = $this->soapClient->GetDelivery(
            array(
//                'username' => $this->smsUserName,
//                'password' => $this->smsPassword,
                'recId' => $successCode
            )
        );
        functions::insertLog('delivery output: ' . json_encode($output), 'log_smsService');

        $return = $this->smsDeliveryMessage($output->GetDeliveryResult);

        functions::insertLog('delivery return: ' . $return, 'log_smsService');

//        return $return;
        return '';
    }
    #endregion

    #region smsDeliveryMessage
    public function smsDeliveryMessage($deliveryCode){

        $messages = array(
            '0' => 'ارسال شده به مخابرات',
            '1' => 'رسیده به گوشی',
            '2' => 'نرسیده به گوشی',
            '3' => 'خطای مخابراتی',
            '5' => 'خطای نامشخص',
            '8' => 'رسیده به مخابرات',
            '9' => 'وضعیت تحویل آپدیت نشده است و یا هنوز مشخص نمی باشد',
            '16' => 'نرسیده به مخابرات',
            '100' => 'نامشخص'
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

        /*$output = $this->soapClient->GetCredit(
            array(
                'username' => $this->smsUserName,
                'password' => $this->smsPassword
            )
        );

        if(!empty($output->GetCreditResult)){
            return $output->GetCreditResult;
        } else{
            return 0;
        }*/
    }
    #endregion

}