<?php


class bookTicketFlight extends apiLocal
{

    protected $reportModel;
    protected $bookLocalModel;
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
        $this->bookLocalModel = $this->bookLocalModel();
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
        return Load::getModel('bookLocalModel');
    }

    /**
     * @return reportModel|bool
     */
    protected function reportModel() {
        return Load::getModel('reportModel');
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
    public function bookFlight($dataBooked) {


        functions::insertLog('params==>' . json_encode($dataBooked, 256), 'newBookTicket');

        $factorNumber = $dataBooked['factorNumber'];
        $payType = $dataBooked['paymentType'];

        $this->updatePaymentWayBook($factorNumber, $payType);

        if ($payType != 'credit') {
            $this->updateInfoBankBookFlight($dataBooked['trackingCode']);
            $this->tracking_code = $dataBooked['trackingCode'] ;
        }

        $infoTicketFlights = $this->bookLocalModel->getInfoFlightByFactorNumberWithGroupByDirection($factorNumber);


        $count_flight = count($infoTicketFlights);
        $resultBook = false;
        foreach ($infoTicketFlights as $key=>$eachDirection) {
            $eachDirection['count_flight'] = $count_flight ;
            functions::insertLog('in foreach==>' . json_encode([$eachDirection['factor_number'], $eachDirection['successfull']], 256), 'newBookTicket');
            if ($eachDirection['successfull'] !== "book" && $eachDirection['successfull'] !== "error") {
                functions::insertLog('before updateStatusProcessing==>' . json_encode([$eachDirection['factor_number'], $resultBook], 256), 'newBookTicket');
                $this->updateStatusProcessing($eachDirection['factor_number']);
                $check_private = ($eachDirection['pid_private'] == '1');
                $checkForSourceFive = false;
                if ($eachDirection['flight_type'] == 'system') {
                    $checkForSourceFive = $this->checkForSourceFive($eachDirection);
                }
                if ($check_private
                    && $eachDirection['flight_type'] == 'system'
                    && ($eachDirection['api_id'] == '8') && $checkForSourceFive && ($eachDirection['IsInternal'] == '1')) {
                    functions::insertLog('before reserveTicket==>' . json_encode([$eachDirection['factor_number'], $resultBook], 256), 'newBookTicket');
                    $resultBook = $this->bookPrivateSourceFiveOfSourceSeven($payType, $eachDirection);
                    functions::insertLog('after bookPrivateSourceFiveOfSourceSeven==>' . json_encode([$eachDirection['factor_number'], $resultBook], 256), 'newBookTicket');

                }
                else {

                    try {
                        $startTime = time();
                        $maxTime = ($eachDirection['count_flight'] > 1) ? 140 : 70;
                        set_time_limit($maxTime + 5);

                        $resultBook = $this->reserveTicket($payType, $eachDirection);

                        $elapsed = time() - $startTime;
                        if ($elapsed > $maxTime) {
                            return functions::withSuccess('pending', 408, 'Tickets require more time to be issued');
                        }

                    } catch (Exception $e) {
                        return functions::withError('', 500, 'Error when booking a flight');
                    }


                    functions::insertLog('after reserveTicket==>' . json_encode([$eachDirection['factor_number'], $resultBook], 256), 'newBookTicket');

                }
                functions::insertLog('**************************************', 'newBookTicket');

            }
            else {
                return functions::withError('', 403, 'پرواز قبلا به نتیجه رسیده است');
            }
        }

        if ($resultBook) {
            return functions::withSuccess($resultBook, 200, 'پرواز با موفقیت صادر شد');
        }
        return functions::withError('failed', 400, 'Flight booking encountered an error.');

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
        $this->bookLocalModel->updateWithBind($data, $condition);
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

        $this->bookLocalModel->updateWithBind($dataUpdate, $condition);
    }
#endregion

    private function updateStatusProcessing($factorNumber) {
        $data['successfull'] = 'processing';
        $condition = "factor_number='{$factorNumber}' AND successfull != 'pending' AND (successfull !='book' AND successfull !='private_reserve') ";
        $this->bookLocalModel->updateWithBind($data, $condition);
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

    /**
     * @param $payType
     * @param $eachDirection
     * @return boolean
     */
    private function bookPrivateSourceFiveOfSourceSeven($payType, $eachDirection) {
        return $this->updateInfoFlight($payType, $eachDirection);
    }

    /**
     * @param $payType
     * @param $eachDirection
     * @param array $ReserveTicket
     * @return bool
     */
    private function updateInfoFlight($payType, $eachDirection, $ReserveTicket = array()) {


        $check_private = ($eachDirection['pid_private'] == '1');
        $PrivateFlightFake = false;
        $checkForSourceFive = false;
        $resultBookedFlight = false;
        $resultReportModelBase = false;
        if ($eachDirection['flight_type'] == 'system') {
            $checkForSourceFive = $this->checkForSourceFive($eachDirection);
        }
        if ($check_private
            && $eachDirection['flight_type'] == 'system'
            && ($eachDirection['api_id'] == '8')
            && $checkForSourceFive && ($eachDirection['IsInternal'] == '1')) {

            $PrivateFlightFake = true;
        }

        if ($payType != 'credit') {
            // Caution: آپدیت تراکنش به موفق
            $this->transaction->setCreditToSuccess($eachDirection['factor_number'], $eachDirection['tracking_code_bank']);
        }
        $ticketsCurrent = $this->bookLocalModel->getTicketsByRequestNumber($eachDirection['request_number']);
        foreach ($ticketsCurrent as $i => $privateTicket) {
            $data['successfull'] = 'book';
            $data['pnr'] = $PrivateFlightFake ? 'PN57' . rand(0000, 9999) : $ReserveTicket['Result']['Request']['OutputRoutes'][0]['AirlinePnr'];
            $data['eticket_number'] = $PrivateFlightFake ? 'TE57' . rand(0000, 9999) : $ReserveTicket['Result']['Request']['RequestPassengers'][$i]['TicketNumber'];
            if($eachDirection['api_id'] == '16'){
                $data['pnr_return'] = $ReserveTicket['Result']['Request']['ReturnRoutes'][0]['AirlinePnr'];
                $data['eticket_number_return'] = !empty($ReserveTicket['Result']['Request']['RequestPassengers']) ? $ReserveTicket['Result']['Request']['RequestPassengers'][$i]['TicketNumberReturn'] : '';

            }
            $uniqCondition = (($ticketsCurrent[$i]['passenger_national_code'] != '0000000000') ? (" AND passenger_national_code = '{$ticketsCurrent[$i]['passenger_national_code']}' ") : (" AND passportNumber = '{$ticketsCurrent[$i]['passportNumber']}'"));
            $condition = " request_number = '{$eachDirection['request_number']}' " . $uniqCondition;
            $result = $this->bookLocalModel->update($data, $condition);
            functions::insertLog('after bookPrivateSourceFiveOfSourceSeven==>' . json_encode([$eachDirection['factor_number'], $result], 256), 'newBookTicket');

            if (isset($result) && $result) {
                functions::insertLog('after both==>' . json_encode([$eachDirection['factor_number'], $result], 256), 'newBookTicket');

                $data['successfull'] = $check_private ? 'private_reserve' : 'book';
                $data['private_m4'] = $PrivateFlightFake ? '1' : '3';
                $resultReportModelBase = $this->reportModel->update($data, $condition);
                functions::insertLog('after reportModel update==>' . json_encode([$eachDirection['factor_number'], $resultReportModelBase], 256), 'newBookTicket');

                $this->flightDirectionOK[$eachDirection['direction']] = true;
                $this->paymentDate = $data['payment_date'];

                if(functions::checkClientConfigurationAccess('call_back')) {
                    $call_back_api =$this->getController('callBackUrl');
                    $call_back_api->sendBookedData($ticketsCurrent , 'insurance') ;
                }

            }

            $resultBookedFlight = ($result && $resultReportModelBase);

            functions::insertLog('after both 2==>' . json_encode([$eachDirection['factor_number'], $resultBookedFlight], 256), 'newBookTicket');
            if ($resultBookedFlight) {


                functions::insertLog('after both 3==>' . json_encode([$eachDirection['factor_number'], $resultBookedFlight], 256), 'newBookTicket');

                $this->transaction->calculateProfitClient($eachDirection,'Flight');

                $this->discountCodes->DiscountCodesUseConfirm($eachDirection['factor_number']);
                $this->members->memberCreditConfirm($eachDirection['factor_number'], $this->tracking_code);
                // for send data to accounting after success
                $this->getController('apiAccounting')->sendDataFlight($eachDirection);

                functions::insertLog('after both 4==>' . json_encode([$eachDirection['factor_number'], $resultBookedFlight], 256), 'newBookTicket');

//                $this->sendSmsLowChargeClient();
                functions::insertLog('after both 5==>' . json_encode([$eachDirection['factor_number'], $resultBookedFlight], 256), 'newBookTicket');

//                $this->sendSmsWarningToMangerIrantech($eachDirection);
                functions::insertLog('after both 6==>' . json_encode([$eachDirection['factor_number'], $resultBookedFlight], 256), 'newBookTicket');

                //email to buyer
                $this->emailTicketSelf($eachDirection);
                functions::insertLog('after both 7==>' . json_encode([$eachDirection['factor_number'], $resultBookedFlight], 256), 'newBookTicket');

                $this->sendSmsToClient($eachDirection);
                functions::insertLog('after both 8==>' . json_encode([$eachDirection['factor_number'], $resultBookedFlight], 256), 'newBookTicket');


            }
            functions::insertLog('after both 8-1==>' . json_encode([$eachDirection['factor_number'], $resultBookedFlight], 256), 'newBookTicket');

        }
        functions::insertLog('after both 9==>' . json_encode([$eachDirection['factor_number'], $resultBookedFlight], 256), 'newBookTicket');



        if(Session::IsLogin() && $resultBookedFlight){
            $data_point = [
                'service' =>'Flight',
                'service_title' =>$eachDirection['serviceTitle'],
                'factor_number' =>$eachDirection['factor_number'],
                'base_company' =>$eachDirection['airline_iata'],
                'company' =>$eachDirection['flight_number'],
                'counter_id' => Session::getCounterTypeId(),
                'price' => functions::CalculateDiscount($eachDirection['factor_number']),
            ];

            $this->getController('historyPointClub')->setPointMemberIntoTable($data_point);

        }
        return $resultBookedFlight;
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
    private function sendSmsToMyCompany($params) {
            $cellArray = array(
                'araste' => '09211559872',
            );
            $objSms = $this->smsService->getController('smsServices')->initService('1');
            if ($objSms) {
                $this->smsService->smsByPattern('yz1dox8r5q6h40x', $cellArray, array('request_number'=> $params['request_number']));
        }

    }

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
    private function emailTicketSelf($data) {


        if (!empty($data)) {
            $title = "چاپ بلیط";
            $subjectEmail = "خرید بلیط هواپیما";

            $emailBody = 'با سلام' . '<br>';
            $emailBody .= 'دوست عزیز؛ از اینکه خدمات ما را انتخاب نموده اید سپاسگزاریم' . '<br>';
            $emailBody .= 'لطفا جهت مشاهده و ' . $title . ' بر روی دکمه ' . $title . ' که در قسمت پایین قرار دارد کلیک نمایید ' . '<br>';

            $param['title'] = 'بلیط هواپیما از  ' . $data['origin_city'] . ' به ' . $data['desti_city'];

            $param['body'] = $emailBody;
            if ($data['type_app'] == 'reservation') {
                $param['pdf'][0]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=BookingReservationTicket&id=' . $data['request_number'];
            } else {
                if ($data['IsInternal'] == '1') {
                    $param['pdf'][0]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=parvazBookingLocal&id=' . $data['request_number'];
                } else {
                    $param['pdf'][0]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=ticketForeign&id=' . $data['request_number'];
                }

            }
            $param['pdf'][0]['button_title'] = $title;

            $to = $data['email_buyer'];
            $subject = $subjectEmail;
            $message = functions::emailTemplate($param);
            $headers = "From: noreply@" . CLIENT_MAIN_DOMAIN . "\r\n";
//	        $headers .="Bcc: ghorbani2006@gmail.com\r\n";
            $headers .="Bcc: developer@iran-tech.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8";
            ini_set('SMTP', 'smtphost');
            ini_set('smtp_port', 25);

            mail($to, $subject, $message, $headers);
        }
    }

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
                'sms_service' => 'بلیط',
                'sms_factor_number' => $eachDirection['request_number'],
                'sms_airline' => $eachDirection['airline_name'],
                'sms_origin' => $eachDirection['origin_city'],
                'sms_destination' => $eachDirection['desti_city'],
                'sms_flight_number' => $eachDirection['flight_number'],
                'sms_flight_date' => dateTimeSetting::jdate("Y-F-d", functions::ConvertToDateJalaliInt($eachDirection['date_flight'])),
                'sms_flight_time' => $eachDirection['time_flight'],
                'sms_pdf' => ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=parvazBookingLocal&id=" . $eachDirection['request_number'] . '&lang=fa',
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
            $messageVariables['sms_name'] = $eachDirection['passenger_name_en'] . ' ' . $eachDirection['passenger_family_en'];
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


        $resultBookedFlight = false;
        functions::insertLog('first reserve ticket==>' . json_encode([$eachDirection['factor_number']], 256), 'newBookTicket');

        $ReserveTicket = parent::Reserve($eachDirection['request_number'], $eachDirection['api_id']);



        functions::insertLog('after reserve ticket==>' . json_encode([$eachDirection['factor_number']], 256), 'newBookTicket');


        if (isset($ReserveTicket['Result']['Request']['Status']) && $ReserveTicket['Result']['Request']['Status'] == 'Ticketed') {
            if (!empty($ReserveTicket['Result']['Request']['RequestPassengers'])) {
                functions::insertLog('before updateInfoFlight==>' . json_encode([$eachDirection['factor_number'], $ReserveTicket], 256), 'newBookTicket');

                $resultBookedFlight = $this->updateInfoFlight($payType, $eachDirection, $ReserveTicket);
                functions::insertLog('after updateInfoFlight==>' . json_encode([$eachDirection['factor_number'], $resultBookedFlight], 256), 'newBookTicket');
            }
        } else {
            if ($payType == 'credit') {
                $this->sendSmsToMyCompany($eachDirection);
                if ($eachDirection['successfull'] != 'book') {
                    if ($eachDirection['direction'] == 'dept') {
                        $this->transaction->pendingTransactionCurrent($eachDirection['factor_number']);
                    }
                    if ($eachDirection['direction'] == 'return') {
                        $this->transaction->changeTransactionInReturnFailure($eachDirection['request_number']);
                    }
                    $this->transaction->deleteCreditAgencyCurrent($eachDirection['request_number']);
                }
            }
        }
        return $resultBookedFlight;
    }


}