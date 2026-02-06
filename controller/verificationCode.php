<?php

class verificationCode extends clientAuth
{
    /**
     * @var airportModel|bool|FlightPortalModel|flightRouteCustomerModel|flightRouteModel|mixed|Model|ModelBase|reservationTourTourtypeModel
     */
    private $verificationCodeModel;
    private $validTime = 5;
    private $expired = 'expired';
    private $used = 'used';
    private $unused = 'unused';

    public function __construct() {

        parent::__construct();
        if (SOFTWARE_LANG === 'en' || SOFTWARE_LANG === 'ru')
            return false;
        $this->verificationCodeModel = $this->getModel('verificationCodeModel');
    }

    public function callCreate($params) {
   
        return  $this->create($params['entry']);
    }

    public function create($entry) {


        if(functions::isMobileOrEmail($entry) == 'mobile'){
            $mobile = $entry;
        }else{
            $member = $this->getMember($entry);
            $mobile = $member['mobile'];
        }


        /**@var $smsController smsServices */
/*        $smsController = $this->getController('smsServices');
        $objSms = $smsController->initService('0');*/
//        functions::insertLog('SMS Service initialized: ' . ($objSms ? 'OK' : 'FAIL'), '0000log_sms_debug');

        /**@var $smsController smsServices */
        $smsController = $this->getController('smsServices');
        $objSms = $smsController->initService('0');
        $code = $this->generateCode();




        if (!empty($mobile) && $this->store($mobile, $code) && $objSms) {

//            functions::insertLog('Failed to store OTP for mobile: ' . $mobile, '0000log_sms_debug');

            $verification_pattern =   $smsController->getPattern('verification_code');


                $params = [
                    'code' => 'registerLogin',
                    'param1' => $code
                ];
                $patternMessage = Load::controller('patternMessage');
                $pattern_message = $patternMessage->getPatternMessage($params);




            if($verification_pattern) {
               $smsArray = array(
                    'data' => ['verification_code' => $code],
                    'cellNumber' => $mobile,
                    'code' => $verification_pattern['pattern'],
                    'smsMessage' => $pattern_message
                );

                $result = $smsController->smsSendPattern($smsArray);
            }

            return true;
        }

        return false;
    }

    /**
     * @param $entry
     * @return int|mixed
     */
    private function getMember($entry) {

        /** @var members_tb $membersModel */
        $membersModel = Load::model('members');

        return $membersModel->getByEmail($entry);
    }

    private function generateCode() {
        return rand(1000, 9999);
    }

    private function store($entry, $code) {

        $verificationCodeModel = $this->getModel('verificationCodeModel');
        $abbasi = $verificationCodeModel->insertWithBind([
            'entry' => $entry,
            'code' => $code,
            'status' => $this->unused
        ]);

        return $abbasi;
    }

    /**
     * @param $code
     * @return string
     */
    private function getSmsText($code) {
        return "دوست عزیز رمز عبور یکبار مصرف " . CLIENT_NAME . " آماده است." . PHP_EOL . "CODE: " . $code;
    }

    public function validateCode($entry, $code) {

        $is_mobile = functions::isMobileOrEmail($entry) ;

        if($is_mobile=='email'){
            $info_member = $this->getMember($entry);
            $entry = $info_member['mobile'];
        }

        $validateRecord = $this->verificationCodeModel->get()
            ->where('entry', $entry)
            ->where('code', $code)
            ->where('status', $this->unused)
            ->find();
 

        if ($validateRecord) {
            if ($this->isExpired($validateRecord['created_at'])) {
                $this->changeStatus($validateRecord['id'], $this->expired);
                $this->create($entry);
                return [
                    'status' => false,
                    'message' => 'optExpired'
                ];
            }

            $this->changeStatus($validateRecord['id'], $this->used);

            return [
                'status' => true,
            ];
        }
        return [
            'status' => false
        ];
    }

    private function isExpired($created_at) {
        $current_time = time();
        $created_at_time = strtotime($created_at);
        $time_diff_minutes = ($current_time - $created_at_time) / 60;
        if ($time_diff_minutes >= $this->validTime) {
            // Time has passed $this->validTime minutes or more
            return true;
        }
        return false;
    }

    public function changeStatus($validate_id, $status) {
        return $this->verificationCodeModel->updateWithBind([
            'status' => $status
        ], [
            'id' => $validate_id
        ]);
    }

    public function checkExistCodeVerification($params) {
        $verificationCodeModel = $this->getModel('verificationCodeModel');
        $result = $verificationCodeModel->get()
            ->where('entry', $params['entry'])
            ->where('status', $this->unused)
            ->orderBy('id')->limit(0, 1)->find();

        if (!empty($result)) {
            if ($this->isExpired($result['created_at'])) {
                return [
                    'status'=>true,
                    'code'=>null
                ];
            }
            return [
                'status'=>false,
                'code'=>$result['code']
            ];
        }
        return [
            'status'=>true,
            'code'=>null
        ];

    }

}