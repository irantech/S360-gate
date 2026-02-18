<?php

/**
 * Class smsFaraz
 * @property smsKavenegar $smsKavenegar
 */
class smsKavenegar extends smsServicesAbstract {

    public $smsUserName = '';
    public $smsPassword = '';
    public $smsNumber = '';
    public $apiKey = '';
    public $baseUrl = 'https://api.kavenegar.com/v1/';



    /**
     * smsKavenegar constructor.
     */
    public function __construct() {

    }

    #region init: initialize sms information
    public function init( $input ) {
        $this->smsUserName = $input['smsUsername'];
        $this->smsPassword = $input['smsPassword'];
        $this->apiKey = $input['token']; // API Key from input
        $this->smsNumber = $input['smsNumber']; // Sender number
        $this->url = 'https://api.kavenegar.com/v1/';

    }
    #endregion





    #region smsSend
    /**
     * @param $input
     *
     * @return mixed
     */
    public function smsSend( $input ) {

        var_dump('56');
        die;
        functions::insertLog('send input: ' . json_encode($input), 'log_smsService');

        $url = $this->baseUrl . $this->apiKey . '/sms/send.json';
        $data = [
            'receptor' => $input['cellNumber'],
            'sender' => $this->smsNumber,
            'message' => $input['smsMessage']
        ];

        $output = $this->curlExecutionPost($url, $data);
        functions::insertLog('send output: ' . json_encode($output), 'log_smsService');

        if(isset($output['return']['status']) && $output['return']['status'] == 200) {
            $messageId = $output['entries'][0]['messageid'];
            $return['result_status'] = 'success';
            $return['result_message'] = 'پیام با موفقیت ارسال شد';
            $return['result_code'] = $messageId;
        } else {
            $errorCode = isset($output['return']['status']) ? $output['return']['status'] : 'unknown';
            $return['result_status'] = 'error';
            $return['result_message'] = $this->smsErrorMessage($errorCode);
            $return['result_code'] = $errorCode;
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
            '1005' => 'مشکل در ثبت، با پشتیبانی تماس بگیرید',
            '200' => 'درخواست تایید شد',
            '400' => 'پارامترها ناقص هستند',
            '401' => 'حساب کاربری غیرفعال شده است',
            '402' => 'عملیات ناموفق بود',
            '403' => 'کد شناسائی API-Key معتبر نمی‌باشد',
            '404' => 'متد نامشخص است',
            '405' => 'متد Get/Post اشتباه است',
            '406' => 'پارامترهای اجباری خالی ارسال شده اند',
            '407' => 'دسترسی به اطلاعات مورد نظر برای شما امکان پذیر نیست',
            '409' => 'سرور قادر به پاسخگوئی نیست بعدا تلاش کنید',
            '411' => 'دریافت کننده نامعتبر است',
            '412' => 'ارسال کننده نامعتبر است',
            '413' => 'پیام خالی است و یا طول پیام بیش از حد مجاز می‌باشد',
            '414' => 'حجم درخواست بیشتر از حد مجاز است',
            '415' => 'اندیس شروع بزرگ تر از کل تعداد شماره های مورد نظر است',
            '416' => 'IP سرویس مبدا با تنظیمات مطابقت ندارد',
            '417' => 'تاریخ ارسال اشتباه است و فرمت آن صحیح نمی باشد',
            '418' => 'اعتبار شما کافی نمی‌باشد',
            '419' => 'طول آرایه متن و گیرنده و فرستنده هم اندازه نیست',
            '420' => 'استفاده از لینک در متن پیام برای شما محدود شده است',
            '422' => 'داده ها به دلیل وجود کاراکتر نامناسب قابل پردازش نیست',
            '424' => 'الگوی مورد نظر پیدا نشد',
            '426' => 'استفاده از این متد نیازمند سرویس پیشرفته می‌باشد',
            '427' => 'استفاده از این خط نیازمند ایجاد سطح دسترسی می باشد',
            '428' => 'ارسال کد از طریق تماس تلفنی امکان پذیر نیست',
            '429' => 'IP محدود شده است',
            '431' => 'ساختار کد صحیح نمی‌باشد',
            '432' => 'پارامتر کد در متن پیام پیدا نشد',
            '451' => 'فراخوانی بیش از حد در بازه زمانی مشخص IP محدود شده',
            '501' => 'فقط امکان ارسال پیام تست به شماره صاحب حساب کاربری وجود دارد'
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
        functions::insertLog('delivery input: ' . $successCode, 'log_smsService');

        $url = $this->baseUrl . $this->apiKey . '/sms/status.json';
        $data = [
            'messageid' => $successCode
        ];

        $output = $this->curlExecutionPost($url, $data);
        functions::insertLog('delivery output: ' . json_encode($output), 'log_smsService');

        if(isset($output['return']['status']) && $output['return']['status'] == 200) {
            $status = $output['entries'][0]['status'];
            $return = $this->smsDeliveryMessage($status);
        } else {
            $return = 'خطا در دریافت وضعیت تحویل';
        }

        functions::insertLog('delivery return: ' . $return, 'log_smsService');
        return $return;
    }
    #endregion

    #region smsDeliveryMessage
    /**
     * @param $deliveryCode
     *
     * @return mixed|string
     */
    public function smsDeliveryMessage( $deliveryCode ) {

        $messages = array(
            '1' => 'در صف ارسال قرار دارد',
            '2' => 'زمان بندی شده (ارسال در تاریخ معین)',
            '4' => 'ارسال شده به مخابرات',
            '5' => 'ارسال شده به مخابرات',
            '6' => 'خطا در ارسال پیام',
            '10' => 'رسیده به گیرنده',
            '11' => 'نرسیده به گیرنده',
            '13' => 'ارسال پیام لغو شده',
            '14' => 'بلاک شده است',
            '100' => 'شناسه پیامک نامعتبر است'
        );

        if(!empty($messages[$deliveryCode])){
            return $messages[$deliveryCode];
        } else{
            return 'خطای تعریف نشده با کد ' . $deliveryCode;
        }
    }
    #endregion

    #region smsGetCredit
    public function smsGetCredit() {

        $url = $this->baseUrl . $this->apiKey . '/account/info.json';
        $output = $this->curlExecutionPost($url, []);

        if(isset($output['return']['status']) && $output['return']['status'] == 200) {
            return $output['entries']['remaincredit'];
        } else{
            return 0;
        }
    }
    #endregion

    private function curlExecutionPost($url, $data) {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return json_decode($result, true);
    }
    #origin pattern
    public function smsSendPattern($input) {

        // بررسی پارامترهای ضروری
        if (empty($input['cellNumber']) || empty($input['code'])) {
            return [
                'result_status' => 'error',
                'result_message' => 'پارامترهای cellNumber و code اجباری هستند.',
                'result_code' => ''
            ];
        }

        // پارامتر 'variables' می تواند یک آرایه از توکن ها باشد (مثلا ['token' => '12345', 'token2' => 'John'])
        $patternVariables = isset($input['data']) ? $input['data'] : [];

        // اصلاح کلید متغیر برای پنل کاوه نگار
        if (isset($patternVariables['verification_code'])) {
            $patternVariables['token'] = $patternVariables['verification_code'];
            unset($patternVariables['verification_code']);
        }
        // URL endpoint
        $url = $this->baseUrl . $this->apiKey . '/verify/lookup.json';

        // آماده سازی داده ها برای ارسال
        $data = [
            'receptor' => $input['cellNumber'],
            'template' => $input['code'],  // اسم الگو در پنل
        ];
        $data = array_merge($data, $patternVariables);
        // اضافه کردن توکن ها به داده ها
        // فرض می کنیم $patternVariables آرایه ای است مانند ['token' => '123', 'token10' => 'abc']
        $data = array_merge($data, $patternVariables);

        // اجرای درخواست POST به API کاوه نگار
//        var_dump('salammmmm');
//        var_dump($url  , $data);
//        die;
        $output = $this->curlExecutionPost($url, $data);

        // نمایش ریکوئست و ریسپانس برای دیباگ
//        var_dump('API URL:', $url);
//        var_dump('API REQUEST:', $data);
//        var_dump('API RESPONSE:', $output);
//        die;
        // ثبت لاگ برای دیباگ
        functions::insertLog('Pattern Send - Input: ' . json_encode($data) . ' - Output: ' . json_encode($output), 'log_smsService_kavenegar');

        // پردازش پاسخ
        if (isset($output['return']['status']) && $output['return']['status'] == 200) {
            $messageId = isset($output['entries'][0]['messageid']) ? $output['entries'][0]['messageid'] : null;
            $return['result_status'] = 'success';
            $return['result_message'] = 'پیام الگودار با موفقیت ارسال شد.';
            $return['result_code'] = $messageId;
        } else {
            $errorCode = isset($output['return']['status']) ? $output['return']['status'] : 'unknown';
            $return['result_status'] = 'error';
            $return['result_message'] = $this->smsErrorMessage($errorCode);
            $return['result_code'] = $errorCode;
        }

        return $return;
    }
#endregion

    #endorigin

    public function smsByPattern($patternCode, $mobiles = [], $patternVariables = []) {

        $results = [];

        foreach ($mobiles as $mobile) {
            // برای هر شماره موبایل، یک درخواست جداگانه به متد lookup ارسال کنید
            $input = [
                'cellNumber' => $mobile,
                'code' => $patternCode,
                'data' => $patternVariables // آرایه ای از توکن ها
            ];
            $result = $this->smsSendPattern($input);
            $results[$mobile] = $result;

            // تاخیر کوچک برای جلوگیری از Rate Limit (اختیاری)
            usleep(100000); // 0.1 ثانیه
        }

        return $results;
    }





}