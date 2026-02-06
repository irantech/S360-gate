<?php
class smsPayamakPanel extends smsServicesAbstract {

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
        $this->soapClient = new SoapClient('http://api.payamak-panel.com/post/send.asmx?wsdl', array('encoding' => 'UTF-8'));

    }
    #endregion

    #region smsSend
    public function smsSend($input) {

//        $getID = substr(time(), 0, 2) . mt_rand(000, 999) . substr(time(), 8, 10);

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
                'status' => 0x0
            )
        );
        functions::insertLog('send output: ' . json_encode($output), 'log_smsService');

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

        $url = 'https://rest.payamak-panel.com/api/SendSMS/GetDeliveries2';
        $data = array(
            'username' => $this->smsUserName,
            'password' => $this->smsPassword,
            'recID' => $successCode
        );
        $output = $this->curlExecutionPost($url, $data);

        functions::insertLog('delivery input: ' . json_encode($data), 'log_smsService');
        functions::insertLog('delivery output: ' . json_encode($output), 'log_smsService');

        $return = $this->smsDeliveryMessage($output['Value']);

//        return $return;
        return '';
    }
    #endregion

    #region smsDeliveryMessage
    public function smsDeliveryMessage($deliveryCode){

        $messages = array(
            '-2' => 'ورودی اشتباه است',
            '0' => 'به مخابرات ارسال شده',
            '1' => 'رسیده به گوشی',
            '2' => 'نرسیده به گوشی',
            '3' => 'خطای مخابراتی',
            '5' => 'خطای نامشخص',
            '8' => 'رسیده به مخابرات',
            '16' => 'نرسیده به مخابرات',
            '35' => 'گیرنده در لیست سیاه قرار دارد',
            '100' => 'نامشخص',
            '200' => 'ارسال شده',
            '300' => 'فیلتر شده',
            '400' => 'در لیست ارسال',
            '500' => 'عدم پذیرش'
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

        if($output->GetCreditResult == '1'){
            return $output->GetCreditResult;
        } else{
            return 0;
        }*/
    }
    #endregion

    /*public function convertLongNumberToString($long)
    {
        if(strpos($long,'E') > 0){
            $separator = strpos($long,'E');
        } elseif(strpos($long,'e') > 0){
            $separator = strpos($long,'e');
        } else{
            $separator = strpos($long,'+');
        }

        $x = floatval(substr($long,0,$separator));
        $y = str_replace(array('e', 'E', '+'),'',substr($long,$separator));

        $float = explode(".", $x);
        $decimalLength = strlen($float[1]);
        $zeroLength = $y - $decimalLength;
        $zeroPart = '';
        for($i = 1; $i <= $zeroLength; $i++){
            $zeroPart .= '0';
        }

        return $float[0] . $float[1] . $zeroPart;
    }*/

    #region curlExecutionPost
    /**
     * This function execute post curl with a url & array of data
     * @param $url string
     * @param $data an associative array of elements
     * @return jason decoded output
     * @author Naime Barati
     */
    public function curlExecutionPost($url, $data) {

        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        $result = curl_exec($handle);
        return json_decode($result, true);

    }
    #endregion

}