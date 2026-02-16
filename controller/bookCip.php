<?php


class bookCip extends cip
{

    protected $reportModel;
    protected $bookModel;
    protected $flightDirectionOK;
    protected $smsService;
    protected $transaction;
    protected $paymentDate;
    protected $discountCodes;
    protected $members;
    protected $tracking_code;

    /**
     * bookTicketFlight constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->bookModel = $this->bookLocalModel();
        $this->reportModel = $this->reportModel();
        $this->smsService = $this->smsService();
        $this->transaction = $this->transaction();
        $this->discountCodes = $this->discountCodes();
        $this->members = $this->members();
    }

    /**
     * @return bookLocalModel|bool
     */
    protected function bookLocalModel() {
        return Load::getModel('cipModel');
    }

    /**
     * @return reportModel|bool
     */
    protected function reportModel() {
        return Load::getModel('cipBaseModel');
    }

    /**
     * @return smsServices|bool
     */
    protected function smsService() {
        return Load::controller('smsServices');
    }

    /**
     * @return transaction|bool
     */
    protected function transaction() {
        return Load::controller('transaction');
    }

    /**
     * @return discountCodes|bool
     */
    protected function discountCodes() {
        return Load::controller('discountCodes');
    }

    /**
     * @return members|bool
     */
    protected function members() {
        return Load::controller('members');
    }

    /**
     * @param $dataBooked
     * @return boolean
     */
    public function book($dataBooked) {


        functions::insertLog('params==>' . json_encode($dataBooked, 256), 'newBookCip');

        $factorNumber = $dataBooked['factorNumber'];
        $payType = $dataBooked['paymentType'];

        $this->updatePaymentWayBook($factorNumber, $payType);

        if ($payType != 'credit') {
            $this->updateInfoBankBookFlight($dataBooked['trackingCode']);
            $this->tracking_code = $dataBooked['trackingCode'] ;
        }

        $info = $this->bookModel->get(['*'])
            ->where('factor_number', $factorNumber)
            ->limit(0, 1)
            ->find();

        functions::insertLog('$info: ' . json_encode($info) , '000shojaee');
        $resultBook = false;

        functions::insertLog('in foreach==>' . json_encode([$info['factor_number'], $info['successfull']], 256), 'newBookCip');
        if ($info['successfull'] !== "book" && $info['successfull'] !== "error") {
            functions::insertLog('before updateStatusProcessing==>' . json_encode([$info['factor_number'], $resultBook], 256), 'newBookCip');
            $this->updateStatusProcessing($info['factor_number']);

            try {
                $startTime = time();
                $maxTime = 70;
                set_time_limit($maxTime + 5);

                $resultBook = $this->reserveTicket($payType, $info);


                $elapsed = time() - $startTime;
                if ($elapsed > $maxTime) {
                    return functions::withSuccess('pending', 408, 'Tickets require more time to be issued');
                }

            }
            catch (Exception $e) {
                return functions::withError('', 500, 'Error when booking a flight');
            }


            functions::insertLog('after reserveTicket==>' . json_encode([$info['factor_number'], $resultBook], 256), 'newBookCip');

            functions::insertLog('**************************************', 'newBookCip');

        }
        else {
            return functions::withError('', 403, 'تشریفات فرودگاه قبلا به نتیجه رسیده است');
        }

        if ($resultBook) {
            return functions::withSuccess($resultBook, 200, 'تشریفات فرودگاه با موفقیت صادر شد');
        }
        return functions::withError('failed', 400, 'cip booking encountered an error.');

    }

    //region bookPrivateSourceFiveOfSourceSeven

    /**
     * @param $factorNumber
     * @param $payType
     */
    private function updatePaymentWayBook($factorNumber, $payType) {
        $data['payment_date'] = Date('Y-m-d H:i:s');
        $data['payment_type'] = ($payType == 'credit') ? 'credit' : 'cash';
        $condition = "factor_number='{$factorNumber}'";
        $this->bookModel->updateWithBind($data, $condition);
        $this->reportModel->updateWithBind($data, $condition);
    }
    //endregion

    #region checkForeSourceFive

    private function updateInfoBankBookFlight($data) {
        $condition = " factor_number='" . $data['trackingCode'] . "' AND successfull = 'bank' ";
        $dataUpdate = array(
            'tracking_code_bank' => $data['trackingCode'],
            'payment_date' => Date('Y-m-d H:i:s')
        );
        $this->bookModel->updateWithBind($dataUpdate, $condition);
    }
#endregion

    private function updateStatusProcessing($factorNumber) {
        $data['successfull'] = 'processing';
        $condition = "factor_number='{$factorNumber}' AND successfull != 'pending' AND (successfull !='book' AND successfull !='private_reserve') ";
        $this->bookModel->updateWithBind($data, $condition);
        $this->reportModel->updateWithBind($data, $condition);
    }

    public function checkForSourceFive($param) {
        /** @var airline $airlineController */
        $airlineController = Load::controller('airline');
        $dataCheckConfigAirline['flightType'] = $param['flight_type'];
        $dataCheckConfigAirline['airline'] = $param['airline_iata'];
        $dataCheckConfigAirline['isInternal'] = ($param['IsInternal'] == '1') ? 'isInternal' : 'External';
        $dataCheckConfigAirline['sourceId'] = $param['sourceId'];
        $dataCheckConfigAirline['info'] = 'completed';

        return $airlineController->checkSourceAirline($dataCheckConfigAirline);
    }

    private function updateInfo($payType, $eachDirection, $ReserveTicket = array()) {



        if ($payType != 'credit') {
            // Caution: آپدیت تراکنش به موفق
            $this->transaction->setCreditToSuccess($eachDirection['factor_number'], $eachDirection['tracking_code_bank']);
        }

        $this->members->memberCreditConfirm($eachDirection['factor_number'], $this->tracking_code);

        //email to buyer
        $this->sendSmsToClient($eachDirection);


        return true;
    }

    /**
     *
     */
    private function sendSmsLowChargeClient() {

        $accountchargeController = $this->getcontroller('transaction')->getCredit();
        if ($accountchargeController < 10000000) {
            //sms to site manager
            $objSms = $this->smsService->initService('1');
            if ($objSms) {
                $sms = "مدیریت محترم آژانس" . " " . CLIENT_NAME . PHP_EOL . " شارژ حساب کاربری شما در نرم افزار سفر 360 به کمتر از 10,000,000 ریال رسیده است";
                $smsArray = array(
                    'smsMessage' => $sms,
                    'cellNumber' => CLIENT_MOBILE
                );
                $this->smsService->sendSMS($smsArray);
            }
        }
    }
    /**
     *
     */

    /**
     * @param $eachDirection
     */
    private function sendSmsWarningToMangerIrantech($eachDirection) {
        $objSms = $this->smsService->initService('1');
        if ($objSms) {
            $ServerName = functions::TitleSource($eachDirection['api_id']);
            $date = dateTimeSetting::jdate("Y-F-d", functions::ConvertToDateJalaliInt($eachDirection['date_flight']));
            $sms = "{$ServerName} -" . CLIENT_NAME . "-{$eachDirection['airline_name']}-{$date}";
            $cellArray = array(
                'afshar' => '09123493154',
                'fanipor' => '09129409530',
                'araste' => '09211559872'

            );
            foreach ($cellArray as $cellNumber) {
                $smsArray = array(
                    'smsMessage' => $sms,
                    'cellNumber' => $cellNumber
                );
                $this->smsService->sendSMS($smsArray);
            }
        }
    }

    /**
     * @param $data
     */

    /**
     * @param $eachDirection
     * @return mixed
     */
    private function sendSmsToClient($eachDirection) {
//sms to buyer
        $objSms = $this->smsService->initService('0');
        if ($objSms) {
            //to member
            $messageVariables = array(
                'sms_name' => $eachDirection['member_name'],
                'sms_service' => 'تشریفات',
                'sms_factor_number' => $eachDirection['request_number'],
                'sms_cip_name' => $eachDirection['cip_name'],
                'sms_flight_date' => $eachDirection['date_time'],
                'sms_agency' => CLIENT_NAME,
                'sms_agency_mobile' => CLIENT_MOBILE,
                'sms_agency_phone' => CLIENT_PHONE,
                'sms_agency_email' => CLIENT_EMAIL,
                'sms_agency_address' => CLIENT_ADDRESS
            );
            $smsArray = array(
                'smsMessage' => $this->smsService->getUsableMessage('afterTicketReserve', $messageVariables),
                'cellNumber' => $eachDirection['member_mobile'],
                'smsMessageTitle' => 'afterTicketReserve',
                'memberID' => (!empty($eachDirection['member_id']) ? $eachDirection['member_id'] : ''),
                'receiverName' => $messageVariables['sms_name'],
            );
            $this->smsService->sendSMS($smsArray);

            //to manager
            $smsArray = array(
                'smsMessage' => $this->smsService->getUsableMessage('afterReserveToManager', $messageVariables),
                'cellNumber' => CLIENT_MOBILE,
                'smsMessageTitle' => 'afterReserveToManager',
                'memberID' => (!empty($eachDirection['member_id']) ? $eachDirection['member_id'] : ''),
                'receiverName' => 'مدیر سایت',
            );
            $this->smsService->sendSMS($smsArray);

            //to first passenger
            $messageVariables['sms_name'] = $eachDirection['passenger_name'] . ' ' . $eachDirection['passenger_family'];
            $smsArray = array(
                'smsMessage' => $this->smsService->getUsableMessage('afterTicketReserve', $messageVariables),
                'cellNumber' => $eachDirection['mobile_buyer'],
                'smsMessageTitle' => 'afterTicketReserve',
                'memberID' => (!empty($eachDirection['member_id']) ? $eachDirection['member_id'] : ''),
                'receiverName' => $messageVariables['sms_name'],
            );
            $this->smsService->sendSMS($smsArray);
        }
    }

    /**
     * @param $payType
     * @param $eachDirection
     * @return boolean
     */
    private function reserveTicket($payType, $eachDirection) {

        functions::insertLog('$eachDirection: ' . json_encode($eachDirection) , '000shojaee');
        $resultBookedFlight = false;
        functions::insertLog('first reserve ticket==>' . json_encode([$eachDirection['factor_number']], 256), 'newBookCip');

        $ReserveTicket = parent::Book($eachDirection);



        functions::insertLog('after reserve ticket==>' . json_encode([$eachDirection['factor_number']], 256), 'newBookCip');

        if (!empty($ReserveTicket) && $ReserveTicket['curl_error'] == false && !empty($ReserveTicket['Pnr'])) {
            functions::insertLog('before updateInfo==>' . json_encode([$eachDirection['factor_number'], $ReserveTicket], 256), 'newBookCip');
            $resultBookedFlight = $this->updateInfo($payType, $eachDirection, $ReserveTicket);

            functions::insertLog('after updateInfo==>' . json_encode([$eachDirection['factor_number'], $resultBookedFlight], 256), 'newBookCip');
        }
        else {
            if ($payType == 'credit') {
                if ($eachDirection['successfull'] != 'book') {
                    $this->transaction->pendingTransactionCurrent($eachDirection['factor_number']);
                    $this->transaction->deleteCreditAgencyCurrent($eachDirection['request_number']);
                }
            }
        }
        return $resultBookedFlight;
    }

    public function getItem($reqNum) {
        return $this->bookModel->getOneByReq($reqNum);
    }

}