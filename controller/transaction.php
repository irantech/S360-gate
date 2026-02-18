<?php
/**
 * Created by PhpStorm.
 * User: barati
 * Date: 3/9/2019
 * Time: 11:28 AM
 */

/**
 * Class transaction
 * @property transaction $transaction
 */
class  transaction extends clientAuth {
    public $Model;
    public $transactionModel;

    public $transactions;
    public function __construct() {
        parent::__construct();
        $this->Model = Load::library('Model');
        $this->transactionModel = $this->transactionModel();
        $this->transactions = $this->getModel('transactionsModel');
    }

    /**
     * @return transactionModel|bool
     */
    public function transactionModel() {
        return Load::getModel('transactionModel');
    }

    public function getTransactionByFactorNumber($factorNumber) {
        $result =  $this->getModel('transactionModel')->get()->where('FactorNumber',$factorNumber)->find();
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function checkCredit($amountToCheck, $typeBuy = null, $currentCredit = null,$amount_to_bank=null) {
        $checkGetWayIranTech = functions::CheckGetWayIranTech(CLIENT_ID);
        if ($currentCredit != null) {
            $currentCredit = $currentCredit;
        } else {
            $currentCredit = $this->getCredit();
        }
        $remainingCredit = $currentCredit - $amountToCheck;
        if ($checkGetWayIranTech && $typeBuy == 'online') {
            $amountSendToGetWayIranTech = intval($amount_to_bank + $currentCredit);
            if ((intval($amountSendToGetWayIranTech) >= intval($amountToCheck)) && intval($amountSendToGetWayIranTech) >= 0) {
                $result['status'] = 'TRUE';
                $result['credit'] = $remainingCredit;
            } else {
                $result['status'] = 'FalseGetWay ';
                $result['credit'] = intval($remainingCredit);
                $result['currentCredit'] = $currentCredit;
                $result['amount_to_bank'] = $amount_to_bank;
                $result['amountSendToGetWayIranTech'] =  $amountSendToGetWayIranTech;
                $result['amountToCheck'] =  $amountToCheck;
            }


        }
        else {
            if ($currentCredit >= 0) {

                if ($amountToCheck > $currentCredit) {
                    $result['status'] = 'FALSE';
                    $result['credit'] = $remainingCredit;
                } else {
                    $result['status'] = 'TRUE';
                    $result['credit'] = $remainingCredit;
                }
            } else {
                $result['status'] = 'FALSE';
                $result['credit'] = $remainingCredit;
            }
        }

        return $result;
    }


    public function getCredit() {
        //600: pending records under 10 minutes are included
        $time = time() - (600);

        $query = "SELECT"
            . " COALESCE((SELECT SUM(Price) FROM transaction_tb WHERE Status='1' AND PaymentStatus = 'success'), 0) as `credit`, "
            . " COALESCE((SELECT SUM(Price) FROM transaction_tb WHERE Status='2' AND"
            . " ((PaymentStatus = 'success') OR (PaymentStatus = 'pending' AND CreationDateInt > '{$time}')) ), 0) as `debit` ";
        $result = $this->Model->load($query);

        return $result['credit'] - $result['debit'];
    }

    public function decreasePendingCredit($amount, $factorNumber, $comment, $reason) {

        $data['Price'] = $amount;
        $data['FactorNumber'] = $factorNumber;
        $data['Comment'] = $comment;
        $data['Reason'] = $reason;
        $data['Status'] = '2';
        $data['PaymentStatus'] = 'pending';
        $data['BankTrackingCode'] = 'کسر موقت';

        return $this->insertCredit($data);
    }

    public function InsertChargeThrowIranTechGetWay($amount, $factorNumber, $comment) {
        $data['Price'] = $amount;
        $data['FactorNumber'] = $factorNumber;
        $data['Comment'] = $comment;
        $data['Reason'] = 'charge';
        $data['Status'] = '1';
        $data['PaymentStatus'] = 'pending';
        $data['BankTrackingCode'] = 'واریز موقت شارژ';

        return $this->insertCredit($data);
    }

    public function insertCredit($data) {
        $data['CreationDateInt'] = time();
        $data['PriceDate'] = date("Y-m-d H:i:s");

        $this->Model->setTable('transaction_tb');
        $result = $this->Model->insertLocal($data);

        //for admin panel
        $this->transactions->insertTransaction($data);
        if ($result) {
            return $this->Model->getLastId();
        } else {
            return false;
        }
    }

    public function decreaseSuccessCredit($amount, $factorNumber, $comment, $reason) {
        $data['Price'] = $amount;
        $data['FactorNumber'] = $factorNumber;
        $data['Comment'] = $comment;
        $data['Reason'] = $reason;
        $data['Status'] = '2';
        $data['PaymentStatus'] = 'success';
        $data['BankTrackingCode'] = '';
        return $this->insertCredit($data);
    }

    public function setCreditToSuccess($factorNumber, $bankTrackingCode) {
        $data['PaymentStatus'] = 'success';
        $data['PriceDate'] = date("Y-m-d H:i:s");
        $data['BankTrackingCode'] = ($bankTrackingCode != 'member_credit') ? $bankTrackingCode : '';
        $condition = "FactorNumber = '{$factorNumber}'";

        return $this->updateCredit($data, $condition);
    }

    public function updateCredit($data, $condition) {
        $data['LastEditInt'] = time();

        $this->Model->setTable('transaction_tb');
        $result = $this->Model->update($data, $condition);
        //for admin panel , transaction table
        $this->transactions->updateTransaction($data, $condition);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function setCreditToPending($factorNumber) {
        $data['PaymentStatus'] = 'pending';
        $condition = "FactorNumber = '{$factorNumber}'";

        return $this->updateCredit($data, $condition);
    }


    #region calculateTransactionPriceTicketForIranTechBank
    public function calculateTransactionPriceTicketForIranTechBank($requestNumber) {

        $bookLocal = Load::model('book_local');
        $apiLocal = Load::library('apiLocal');
        $privateCharterSources = functions::privateCharterFlights();
        $ClientIdPrivateCharterSources = functions::ClientIdCharterPrivateFlight();
        $TicketPriceBank = functions::CalculateDiscount($requestNumber, 'yes');

        $rec = $bookLocal->GetInfoBookLocal($requestNumber);
        list($TicketPrice, $fare) = $apiLocal->get_total_ticket_price($requestNumber, 'no');


        $check_private = ($rec['pid_private'] == '1') ? 'private' : 'public';

        $percentPublic = functions::percentPublic();
        if ($rec['IsInternal'] == '1') {
            if ($rec['flight_type'] == "system") {//بلیط سیستمی
                if ($check_private == 'public') {

//                    dar tarikh 13 ordibehesht 1404 tebgh darkhast aghaye afshar systemy ha haman meghdar total azashon kasr beshe
//                    $Amount = $TicketPrice - ($fare * $percentPublic) + ($rec['irantech_commission'] * $rec['count_id']);
//                    $Amount = $TicketPrice - (($TicketPrice - (($TicketPrice * 4573) / 100000)) * (($percentPublic))) + ($rec['irantech_commission'] * $rec['count_id']);
                    if($rec['api_id'] == 17) {
                        //dar tarikh 21 ordibehesht 1404 tebgh darkhast aghaye afshar source 17 bayad 3 darsad fare azash kam she az moshtari gerefte she
                        $percent = 3 ;
                        $Amount = $TicketPrice - (($fare * $percent) / 100) + ($rec['irantech_commission'] * $rec['count_id']);
                    }else{
                        $Amount = $TicketPrice + ($rec['irantech_commission'] * $rec['count_id']);
                    }
                    $totalAmount = $TicketPriceBank - $Amount;
                    $type = ' سیستمی پید اشتراکی ';
                } else {
                    $Amount = 0 + ($rec['irantech_commission'] * $rec['count_id']);
                    $totalAmount = $TicketPriceBank - $Amount;
                    $type = ' سیستمی پید اختصاصی ';
                }
            } else {//بلیط چارتری
                if ($check_private == 'private') {
                    $Amount = 0 + ($rec['irantech_commission'] * $rec['count_id']);
                    $totalAmount = $TicketPriceBank - $Amount;
                    $type = ' چارتری پید اختصاصی ';
                } else {
                    $Amount = $TicketPrice + ($rec['irantech_commission'] * $rec['count_id']);
                    $totalAmount = $TicketPriceBank - $Amount;
                    $type = ' چارتری ';
                }
            }
        } else {
            if ($rec['api_id'] != '10') {
                if ($rec['flight_type'] != "system") {
                    $Amount = $TicketPrice + ($rec['irantech_commission'] * $rec['count_id']);
                    $totalAmount = $TicketPriceBank - $Amount;
                    $type = ' چارتری  خارجی ';
                } else {
                    if ($check_private == 'private') {
                        $Amount = 0 + ($rec['irantech_commission'] * $rec['count_id']);
                        $totalAmount = $TicketPriceBank - $Amount;
                        $type = ' سیستمی پید اختصاصی خارجی ';
                    } else {
                        if ($rec['api_id'] == '8') {
                            $Amount = $TicketPrice - ($fare * $percentPublic) + ($rec['irantech_commission'] * $rec['count_id']);
//                            $Amount = $TicketPrice - (($TicketPrice - (($TicketPrice * 4573) / 100000)) * (($percentPublic))) + ($rec['irantech_commission'] * $rec['count_id']);
                        } else {
                            $Amount = $TicketPrice + ($rec['irantech_commission'] * $rec['count_id']);
                        }
                        $totalAmount = $TicketPriceBank - $Amount;
                        $type = ' سیستمی پید اشتراکی خارجی ';
                    }

                }

            } else if ($rec['api_id'] == '10') {
                if ($rec['flight_type'] == "system") {
                    if ($check_private == 'private') {
                        $Amount = 0 + ($rec['irantech_commission'] * $rec['count_id']);
                        $type = ' سیستمی پید اختصاصی خارجی ';
                    } else {
                        $Amount = $TicketPrice + ($rec['irantech_commission'] * $rec['count_id']);
                        $type = ' سیستمی پید اشتراکی خارجی ';
                    }
                    $Amount = $TicketPriceBank - $Amount;
                } else {
                    $Amount = $TicketPrice + ($rec['irantech_commission'] * $rec['count_id']);
                    $type = ' چارتری خارجی ';
                }

                $totalAmount = $TicketPriceBank - $Amount;
            }
        }

        $output['transactionPrice'] = $totalAmount;
        $output['pidTitle'] = $type;

        return $output;
    }
#endregion

#region temproryCheck

    public function CheckCreditTemproryStep($params) {
        $isInternal = ($params['IsInternalFlight'] == '1') ? 'internal' : 'external';
        $check_private = functions::checkConfigPid($params['Airline_IATA'], $isInternal, $params['FlightType'],$params['SourceID']);
        if ($params['IsInternalFlight'] == '1') {
            if ($check_private == 'public') {
                $CalcPrice = (($params['AdtPrice'] * $params['Adt_qty']) + ($params['ChdPrice'] * $params['Chd_qty']) + ($params['InfPrice'] * $params['Inf_qty']));
            } else {
                $CalcPrice = 0;
            }
        }
        return $CalcPrice;
    }
#endRegion


#region calculateTransactionPrice

    public function calculateTransactionPrice($requestNumber) {
        $bookLocal = Load::model('book_local');
        $apiLocal = Load::library('apiLocal');
        $percentPublic = functions::percentPublic();
        $isCounter = $this->getController('login')->isCounter();
        $isCounter = json_decode($isCounter);

        $rec = $bookLocal->GetInfoBookLocal($requestNumber);
        list($TicketPrice, $fare) = $apiLocal->get_total_ticket_price($requestNumber, 'no');
        $customerBenefitSystemFlight = $apiLocal->get_total_customer_benefit_system_flight($requestNumber);



        $check_private = ($rec['pid_private'] == '1') ? 'private' : 'public';
        $totalAmount = 0;

        if ($rec['flight_type'] == "system") {
            if ($check_private == 'public') {

                if (($rec['IsInternal'] == '1')  || ( $rec['api_id'] != '10' && $rec['api_id'] != '14' &&  $rec['api_id'] != '15') ) {

//                    dar tarikh 13 ordibehesht 1404 tebgh darkhast aghaye afshar systemy ha haman meghdar total azashon kasr beshe
//                    $totalAmount = ($TicketPrice - ($fare * $percentPublic)) + ($rec['irantech_commission'] * $rec['count_id']);
//                    $totalAmount = $TicketPrice - (($TicketPrice - (($TicketPrice * 4573) / 100000)) * (($percentPublic))) + ($rec['irantech_commission'] * $rec['count_id']);
                    if($rec['api_id'] == 17) {
                        //dar tarikh 21 ordibehesht 1404 tebgh darkhast aghaye afshar source 17 bayad 3 darsad fare azash kam she az moshtari gerefte she
                        $percent = 3 ;
                        $totalAmount = $TicketPrice - (($fare * $percent) / 100) + ($rec['irantech_commission'] * $rec['count_id']);
                    }else{
//                        $totalAmount = $TicketPrice + ($rec['irantech_commission'] * $rec['count_id']);
                        if ($isCounter) {
                            $totalAmount = $TicketPrice;
                        } else {
                            $totalAmount = $TicketPrice - $customerBenefitSystemFlight;
                        }
                    }
                    if ($rec['IsInternal'] == '1') {
                        $type = ' سیستمی پید اشتراکی ';
                    } else {
                        $type = ' سیستمی  اشتراکی خارجی ';
                    }
                } else {
//                    $totalAmount = $TicketPrice + ($rec['irantech_commission'] * $rec['count_id']);
                    if ($isCounter) {
                        $totalAmount = $TicketPrice;
                    } else {
                        $totalAmount = $TicketPrice - $customerBenefitSystemFlight;
                    }
                    if ($rec['IsInternal'] == '1') {
                        $type = ' سیستمی پید اشتراکی ';
                    } else {
                        $type = ' سیستمی  اشتراکی خارجی ';
                    }

                }
            } else {
                $totalAmount = 0 + ($rec['irantech_commission'] * $rec['count_id']);
                if ($rec['IsInternal'] == '1') {
                    $type = ' سیستمی پید اختصاصی ';
                } else {
                    $type = ' سیستمی اختصاصی خارجی ';
                }
            }
        } else {
            if ($check_private == 'public') {
                $totalAmount = $TicketPrice + ($rec['irantech_commission'] * $rec['count_id']);
                if ($rec['IsInternal'] == '1') {
                    $type = ' چارتری ';
                } else {
                    $type = ' چارتری خارجی ';
                }
            } else {
                $totalAmount = 0 + ($rec['irantech_commission'] * $rec['count_id']);
                if ($rec['isInternal'] == '1') {
                    $type = ' چارتری داخلی ';
                } else {
                    $type = ' چارتری  اختصاصی ';
                }

            }
        }


        $output['transactionPrice'] = $totalAmount;
        $output['pidTitle'] = $type;

        return $output;
    }

    public function calculateTransactionPriceAdmin($requestNumber) {

        $bookLocal = $this->getModel('reportModel');

        $apiLocal = Load::library('apiLocal');
        $percentPublic = functions::percentPublic();

        $rec = $bookLocal->GetInfoReportLocal($requestNumber);

        list($TicketPrice, $fare) = $apiLocal->get_total_ticket_price($requestNumber, 'no');

        $check_private = ($rec['pid_private'] == '1') ? 'private' : 'public';
        $totalAmount = 0;

        if ($rec['flight_type'] == "system") {

            if ($check_private == 'public') {

                if (($rec['IsInternal'] == '1')  || ( $rec['api_id'] != '10' && $rec['api_id'] != '14' &&  $rec['api_id'] != '15') ) {

//                    dar tarikh 13 ordibehesht 1404 tebgh darkhast aghaye afshar systemy ha haman meghdar total azashon kasr beshe
//                    $totalAmount = ($TicketPrice - ($fare * $percentPublic)) + ($rec['irantech_commission'] * $rec['count_id']);
//                    $totalAmount = $TicketPrice - (($TicketPrice - (($TicketPrice * 4573) / 100000)) * (($percentPublic))) + ($rec['irantech_commission'] * $rec['count_id']);
                    if($rec['api_id'] == 17) {
                        //dar tarikh 21 ordibehesht 1404 tebgh darkhast aghaye afshar source 17 bayad 3 darsad fare azash kam she az moshtari gerefte she
                        $percent = 3 ;
                        $totalAmount = $TicketPrice - (($fare * $percent) / 100) + ($rec['irantech_commission'] * $rec['count_id']);
                    }else{
                        $totalAmount = $TicketPrice + ($rec['irantech_commission'] * $rec['count_id']);
                    }
                    if ($rec['IsInternal'] == '1') {
                        $type = ' سیستمی پید اشتراکی ';
                    } else {
                        $type = ' سیستمی  اشتراکی خارجی ';
                    }
                }
                else {
                    $totalAmount = $TicketPrice + ($rec['irantech_commission'] * $rec['count_id']);
                    if ($rec['IsInternal'] == '1') {
                        $type = ' سیستمی پید اشتراکی ';
                    } else {
                        $type = ' سیستمی  اشتراکی خارجی ';
                    }

                }
            } else {
                $totalAmount = 0 + ($rec['irantech_commission'] * $rec['count_id']);
                if ($rec['IsInternal'] == '1') {
                    $type = ' سیستمی پید اختصاصی ';
                } else {
                    $type = ' سیستمی اختصاصی خارجی ';
                }
            }
        } else {
            if ($check_private == 'public') {
                $totalAmount = $TicketPrice + ($rec['irantech_commission'] * $rec['count_id']);
                if ($rec['IsInternal'] == '1') {
                    $type = ' چارتری ';
                } else {
                    $type = ' چارتری خارجی ';
                }
            } else {
                $totalAmount = 0 + ($rec['irantech_commission'] * $rec['count_id']);
                if ($rec['isInternal'] == '1') {
                    $type = ' چارتری داخلی ';
                } else {
                    $type = ' چارتری  اختصاصی ';
                }

            }
        }


        $output['transactionPrice'] = $totalAmount;
        $output['pidTitle'] = $type;

        return $output;
    }

#endregion

    public function addTransactionToClientANDAgency($params) {

        $Model = Load::library('Model');
        $agencyController = Load::controller('agency');
        $factorNumber = 'AC' . substr(time(), 0, 5) . mt_rand(000, 999) . substr(time(), 5, 10);

        $agencyInfo = $agencyController->AgencyInfoByIdMember(Session::getUserId());


        $dataTransaction['Price'] = $params['price'];
        $dataTransaction['PriceDate'] = date("Y-m-d H:i:s");
        $dataTransaction['FactorNumber'] = $params['factorNumber'];
        $dataTransaction['Status'] = '1';
        $dataTransaction['Reason'] = 'charge';
        $dataTransaction['comment'] = 'واریز وجه آنی از طریق درگاه آنلاین توسط آژانس زیر مجموعه' . '(' . $agencyInfo['name_fa'] . ')';
        $dataTransaction['PaymentStatus'] = 'pending';
        $dataTransaction['CreationDateInt'] = time();

        $Model->setTable('transaction_tb');
        $res = $Model->insertLocal($dataTransaction);

        $this->transactions->insertTransaction($dataTransaction);
        if ($res) {
            return $factorNumber;
        }
    }


    public function updateTransactionAgency($idMember, $factorNumber, $tractionCode) {
        $Model = Load::library('Model');
        $agencyController = Load::controller('agency');
        $agencyInfo = $agencyController->AgencyInfoByIdMember($idMember);
        $condition = "FactorNumber='{$factorNumber}'";
        $dataTransactionAgency['PaymentStatus'] = 'success';
        $dataTransactionAgency['BankTrackingCode'] = $tractionCode;
        $Model->setTable('transaction_tb');
        $res = $Model->update($dataTransactionAgency, $condition);
        //for admin panel , transaction table
        $this->transactions->updateTransaction($dataTransactionAgency, $condition);

        if ($res) {
            $sqlInfoTransaction = " SELECT  * FROM transaction_tb WHERE FactorNumber='{$factorNumber}'  ";
            $infoTransaction = $Model->load($sqlInfoTransaction);

            $sqlInfoCredit = " SELECT  * FROM credit_detail_tb WHERE credit='{$infoTransaction['Price']}' AND member_id='{$idMember}' AND trackingCode='{$tractionCode}'   ";
            $infoCredit = $Model->load($sqlInfoCredit);


            $dataTransaction['fk_agency_id'] = $agencyInfo['id'];
            $dataTransaction['credit'] = $infoTransaction['Price'];
            $dataTransaction['type'] = 'increase';
            $dataTransaction['comment'] = 'واریز وجه آنی از طریق درگاه توسط(' . $agencyInfo['name_fa'] . ') آنلاین شماره پیگیری' . '' . $tractionCode;
            $dataTransaction['reason'] = 'deposit';
            $dataTransaction['member_id'] = $idMember;
            $dataTransaction['trackingCode'] = $tractionCode;
            $dataTransaction['PaymentStatus'] = 'success';
            $dataTransaction['creation_date_int'] = time();

            if (empty($infoCredit)) {
                $Model->setTable('credit_detail_tb');
                $Model->insertLocal($dataTransaction);
            }


        }
    }

    /**
     * @param $factorNumber
     * @param $requestNumber
     * @param $price
     */
    private function paymentIranTech($factorNumber, $requestNumber, $price) {
        $dataPaymentIranTech['factorNumber'] = $factorNumber;
        $dataPaymentIranTech['Price'] = $price;
        $dataPaymentIranTech['Comment'] = "بابت خرید به شماره رزرو {$requestNumber} از درگاه سفر 360 ";
        $dataPaymentIranTech['creationDateInt'] = time();

        $this->Model->setTable('payment_irantech_getway_tb');
        $this->Model->insertLocal($dataPaymentIranTech);
    }

    #region log_transaction_revers
    public function log_transaction_revers($data) {
        $this->Model->setTable('log_revers_bank');
        $this->Model->insertLocal($data);
    }
    #endregion

    #region delete_transaction_current
    public function pendingTransactionCurrent($factorNumber) {
        $data['PaymentStatus'] = 'pending';
        $condition = "FactorNumber = '{$factorNumber}' AND FactorNumber !=''";
        $this->transactionModel->updateWithBind($data, $condition);
        $this->transactions->updateTransaction($data, $condition);
    }
    #endregion

    #region delete_credit_Agency_current
    public function deleteCreditAgencyCurrent($requestNumber) {
        /** @var creditDetailModel $creditDetailModel */
        $creditDetailModel = Load::getModel('creditDetailModel');
        $condition = "requestNumber = '{$requestNumber}' AND requestNumber !='' AND type='decrease'";
        $data['PaymentStatus'] = 'pending' ;
        $creditDetailModel->update($data,$condition);
    }
    #endregion

    #region
    public function changeTransactionInReturnFailure($requestNumber) {
        /** @var bookLocalModel $bookLocalModel */
        $bookLocalModel = Load::getModel('bookLocalModel');
        $reserveInfo = $bookLocalModel->getTicketsByRequestNumber($requestNumber);
        $reserveInfoSingle = $reserveInfo[0];

        $prices = parent::calculateTransactionPrice($requestNumber);
        $comment = "خرید" . ' ' . count($reserveInfo) . " عدد بلیط هواپیما از" . ' ' . $reserveInfoSingle['origin_city'] . " به" . ' ' . $reserveInfoSingle['desti_city'] . ' ' . "به شماره رزرو " . ' ' . $requestNumber . $prices['pidTitle'];

        $data['Price'] = $prices['transactionPrice'];
        $data['Comment'] = $comment;
        $condition = " FactorNumber = '{$reserveInfoSingle['factor_number']}' ";
        $this->transaction->updateCredit($data, $condition);
    }

    #endregion


    //region calculateProfitClient
    /**
     * @param $data
     * @param null $type
     * @return bool
     */
    public function calculateProfitClient($data, $type = null) {
        if(PARENT_ID > 0){
            /** @var partner $partner_controller */
            $partner_controller = Load::controller('partner');

            /** @var admin $admin */
            $admin = Load::controller('admin');
            $factor_number = '';
            $service_title = '';
            $type_title = '';

            switch ($type) {
                case 'Hotel':
                    $factor_number = $data['factor_number'];
                    $service_title = $data['serviceTitle'];
                    $type_title = 'هتل';
                    break;
                case 'Flight':
                    $factor_number = $data['factor_number'];
                    $service_title = $data['serviceTitle'];
                    $type_title = 'پرواز';
                    break;
                default:
                    $factor_number = null;
                    $service_title = null;
                    $type_title    = null;
                    break;
            }

            $data_commission['detail_type'] = $service_title;
            $data_commission['client_id'] = CLIENT_ID;
            $data_commission['parent_id'] = PARENT_ID;
            $data_commission['type'] = $type;


            $commission_client = $this->getController('clientWhiteCommission')->getCommissionPartner($data_commission);
            $info_client = $this->getController('partner')->infoClient($data_commission['parent_id']);

            $price_commission = $this->calculateCommissionClient($data, $commission_client, $type);

            $client_name = CLIENT_NAME;
            $data_insert['FactorNumber'] = $factor_number;
            $data_insert['PriceDate'] = date("Y-m-d H:i:s");
            $data_insert['PaymentStatus'] = 'success';
            $data_insert['CreationDateInt'] = time();
            $data_insert['Price'] = $price_commission;


            $comment_client = "کسر مبلغ {$price_commission} بابت کارمزد خرید{$type_title} به آژانس {$info_client['AgencyName']} ";
            $comment_client_prent = "واریز مبلغ {$price_commission} بابت کارمزد خرید {$type_title} توسط آژانس {$client_name}";
            $status_client = '2';
            $status_client_parent = '1';
            $reason_client = 'decrease';
            $reason_client_parent = 'increase';
            $data_insert['Comment'] = $comment_client;
            $data_insert['Status'] = $status_client;
            $data_insert['Reason'] = $reason_client;

            $result_insert_client = $this->transactionModel->insertWithBind($data_insert);
            $this->transactions->insertTransaction($data_insert);
            $data_insert['Comment'] = $comment_client_prent;
            $data_insert['Status'] = $status_client_parent;
            $data_insert['Reason'] = $reason_client_parent;
            $result_insert_client_parent = $admin->ConectDbClient("", $data_commission['parent_id'], "Insert", $data_insert, "transaction_tb", "");

            $data_insert['clientID'] = $data_commission['parent_id'];
            $this->transactions->insertTransaction($data_insert);

            return ($result_insert_client && $result_insert_client_parent);
        }


    }
    //endregion

    //region calculateCommissionClient
    /**
     * @param $data
     * @param $commission_client
     * @param $type
     * @return int
     */
    private function calculateCommissionClient($data, $commission_client, $type) {
        switch ($type) {
            case 'Flight':
                return $this->flightCommissionClient($data, $commission_client);
                break;
            case 'Hotel':
                return $this->hotelCommissionClient($data,$commission_client);
                break;
        }


    }
    //endregion

    //region flightCommissionClient
    /**
     * @param $data
     * @param $commission_client
     * @return false|float|mixed
     */
    private function flightCommissionClient($data, $commission_client) {
        /** @var apiLocal $apiLocal_class */
        $apiLocal_class = Load::library('apiLocal');

        list($amount, $fare) = $apiLocal_class->get_total_ticket_price($data['request_number'], 'yes');

        if (strtolower($data['flight_type']) == 'system') {
            return ($commission_client['type_commission'] == 'price') ? ($commission_client['amount_commission']) : round(($fare * ($commission_client['amount_commission'] / 100)));

        }
        return ($commission_client['type_commission'] == 'price') ? ($commission_client['amount_commission']) : round(($amount * ($commission_client['amount_commission'] / 100)));

    }
    //endregion


    //region hotelCommissionClient
    /**
     * @param $data
     * @param $commission_client
     * @return false|float|mixed
     */
    public function hotelCommissionClient($data, $commission_client) {

        /** @var detailHotel $detail_hotel_controller */
        $detail_hotel_controller = Load::controller('detailHotel');
        $price = $detail_hotel_controller->calculateApiTotalPrice($data['factor_number']);
        return  ($commission_client['type_commission'] == 'price') ? ($commission_client['amount_commission']) : round(($price * ($commission_client['amount_commission'] / 100)));
    }
    //endregion

    //region allTransactionOneClient
    /**
     * @param $client_id
     * @return array
     */
    public function allTransactionOneClient($client_id) {
//        functions::displayErrorLog();
        /** @var admin $admin */
        $admin = Load::controller('admin');
        $date_previous = strtotime(date('Y-m-d', time()));
        $sql = "SELECT Reason,Price,Status,CreationDateInt FROM transaction_tb WHERE  PaymentStatus='success' ";
        $transactions = $admin->ConectDbClient($sql, $client_id, "SelectAll", "", "", "");
        $data_transaction = array();
        $data_transaction_total = array();

        for ($i = 0; $i < 10 ; $i++){
            $date = time() - ($i * 24 * 60 * 60);
            $date_next =  time() -(($i+1) * 24 * 60 * 60) ;


            $date_previous = date('Y-m-d',$date);

            foreach ($transactions as $transaction) {

                if ($transaction['Status'] == "1" && (($date_next < intval($transaction['CreationDateInt'])) &&(intval($transaction['CreationDateInt']) < intval($date)))) {
                    $data_transaction_total[$date_previous]['charge_today'] = ($data_transaction[$date_previous]['charge_today'] + $transaction['Price']);
                }else{
                    $data_transaction_total[$date_previous]['charge_today'] = 0 ;
                }
                if (($date >= intval($transaction['CreationDateInt']))) {
                    if ($transaction['Status'] == "2") {
                        $data_transaction[$date_previous]['buy_remaining'] = ($data_transaction[$date_previous]['buy_remaining'] + $transaction['Price']);
                    }
                    if ($transaction['Status'] == "1") {
                        $data_transaction[$date_previous]['charge_remaining'] = ($data_transaction[$date_previous]['charge_remaining'] + $transaction['Price']);
                    }
                }
            }
            $data_transaction_total[$date_previous]['total_remaining'] = $data_transaction[$date_previous]['charge_remaining'] -  $data_transaction[$date_previous]['buy_remaining'] ;
        }

        return $data_transaction_total;
    }
    //endregion

    //region findTransactionByFactorNumber
    /**
     * @param $factor_number
     * @return mixed
     */
    public function findTransactionByFactorNumber($factor_number) {

        return $this->getModel('transactionModel')->get()->where('FactorNumber',$factor_number)->find();
    }
    //endregion

    public function createTransactionRequestToBank($params)
    {
        $amount = $params['transaction_increase_amount'];
        $callback_url = ROOT_ADDRESS_WITHOUT_LANG . '/itadmin/transactionUser';
        $factor_number = 'ch' . functions::generateFactorNumber();
        $bank_params = [
            '91592c3d-4d24-4ab0-a0d2-00d51f5d6d83', //param 1
            '',//param 2
            '',//param 3
            '',//param 4
            '',//param 5
        ];
        if ($amount >= '20000000') {
            $bank_controller = $this->getController('bank');
            return $bank_controller->initializeAdminBank('go', 'nextpay', $amount, $factor_number, $callback_url, $bank_params);
        }
        return functions::withError($bank_params,401,'مبلغ از میزان تعیین شده کمتر میباشد');//todo: complete it
    }

    public function verifyTransactionResponseFromBank()
    {
        $factor_number = filter_var($_GET['order_id'], FILTER_SANITIZE_STRING);
        $bank_params = [
            '91592c3d-4d24-4ab0-a0d2-00d51f5d6d83', //param 1
            '',//param 2
            '',//param 3
            '',//param 4
            '',//param 5
        ];
        $verify_bank_transaction = $this->getController('bank')->initializeAdminBank('return', 'nextpay', '', $factor_number, '', $bank_params);
        if ((isset($verify_bank_transaction['trackingCode']) && isset($verify_bank_transaction['factorNumber'])) && ($verify_bank_transaction['trackingCode'] !== '' && $verify_bank_transaction['factorNumber'] !== '')) {
            return $this->getController('accountcharge')->initBankData($verify_bank_transaction['amount'], $verify_bank_transaction['factorNumber'], $verify_bank_transaction['trackingCode']);
        }
        return false;
    }

    public function setPrimitiveTransactionForGateWayCharter724($params) {

        $factor_number = intval(functions::generateFactorNumber());

        $data_transaction=[
            'Price' => $params['price'],
            'PriceDate' => date("Y-m-d H:i:s"),
            'FactorNumber'=>$factor_number,
            'Status'=>1,
            'Reason'=>'charge',
            'Comment'=>' شارژ حساب کاربری از درگاه ویژه با شماره پیگیری'. $params['token'],
            'BankTrackingCode'=>$params['token'],
            'PaymentStatus'=>'pending',
            'CreationDateInt'=>time()
        ];

        $res = $this->getModel('transactionModel')->insertLocal($data_transaction);
        $this->transactions->insertTransaction($data_transaction);

        if($res){

            return $factor_number;
        }

        return false ;
    }


    public function verifyTransactionResponseFromBankCharter724($token) {
        $info_payment = $this->getModel('transactionModel')->get()->where('BankTrackingCode',$token)->find();

        if($info_payment){
            $check_status_verify = $this->getController('apiGateWayCharter724')->verifyTransaction($token);

            if($check_status_verify){
                $data_transaction['PaymentStatus'] = 'success';
                $this->getModel('transactionModel')->update($data_transaction,"BankTrackingCode='{$token}' AND FactorNumber='{$info_payment['FactorNumber']}'");
                $this->transactions->updateTransaction($data_transaction,"BankTrackingCode='{$token}' AND FactorNumber='{$info_payment['FactorNumber']}'");
                return true ;
            }
            return false;
        }
        return false;
    }

    public function checkCreditNew($amountToCheck, $typeBuy = null, $currentCredit = null,$amount_to_bank=null , $selected_bank = null) {
        $checkGetWayIranTech = functions::CheckGetWayIranTech(CLIENT_ID);

        if ($currentCredit != null) {
            $currentCredit = $currentCredit;
        } else {
            $currentCredit = $this->getCredit();
        }
        $remainingCredit = $currentCredit - $amountToCheck;


        if ($checkGetWayIranTech && $typeBuy == 'online' && isset($selected_bank) && $selected_bank == 'publicBank') {
            $amountSendToGetWayIranTech = ($amount_to_bank + $currentCredit);
            if (($amountSendToGetWayIranTech >= $amountToCheck) && $amountSendToGetWayIranTech >= 0) {
                $result['status'] = 'TRUE';
                $result['credit'] = $remainingCredit;
            } else {
                $result['status'] = 'FalseGetWay ';
                $result['credit'] = intval($remainingCredit);
                $result['currentCredit'] = $currentCredit;
                $result['amount_to_bank'] = $amount_to_bank;
                $result['amountSendToGetWayIranTech'] =  $amountSendToGetWayIranTech;
                $result['amountToCheck'] =  $amountToCheck;
            }


        }
        else {

            if ($currentCredit >= 0) {

                if ($amountToCheck > $currentCredit) {
                    $result['status'] = 'FALSE';
                    $result['credit'] = $remainingCredit;
                } else {
                    $result['status'] = 'TRUE';
                    $result['credit'] = $remainingCredit;
                }
            } else {
                $result['status'] = 'FALSE';
                $result['credit'] = $remainingCredit;
            }
        }

        return $result;
    }

    public function getCreditByTrackingCode($tracking_code) {
        return $this->transactionModel->get('*')->where('BankTrackingCode' , $tracking_code)->find();
    }

    public function setBookTransaction($params){
        $service = $params['service'] ;
        $factor_number = $params['factor_number'];
        $payment_date = '';
        $client_id = '';
        if(!$factor_number){
            return functions::withError(false,404,'no factor_number has selected.') ;
        }
        if($service == 'flight') {

            $reserveInfo = $this->getModel('reportModel')->get()->where('factor_number',$factor_number)->find();
            if(!$reserveInfo) {
                return functions::withError(false,404,'not found report.') ;
            }
            $client_id = $reserveInfo['client_id'] ;
            $prices = self::calculateTransactionPriceAdmin( $reserveInfo['request_number'] );
            $total_price = $prices['transactionPrice'];

            if($reserveInfo['direction']=='multi_destination'){
                $count_direction = 'چند مسیره';
            }elseif($reserveInfo['direction']=='TwoWay'){
                $count_direction = 'دو طرفه';
            }else{
                $count_direction="";
            }
            $comment = "خرید" . " " . $reserveInfo['count_id'] . " عدد بلیط " . $count_direction . " هواپیما از" . " " . $reserveInfo['origin_city'] . " به" . " " . $reserveInfo['desti_city'] . " " . "به شماره رزرو ";
            $comment     .= ' ' . $reserveInfo['request_number'] . $prices['pidTitle'] . ' /after book';
            $reason = 'buy';

            $date = $reserveInfo['creation_date_int'];
            $newTimestamp = $date + (10 * 60);
            $price_date =  date("Y-m-d H:i:s", $newTimestamp);
        }
        else if($service == 'hotel') {
            $reserveInfo = $this->getModel('reportHotelModel')->get()->where('factor_number',$factor_number)->find();
            if(!$reserveInfo) {
                return functions::withError(false,404,'not found report.') ;
            }

            $client_id = $reserveInfo['client_id'] ;
            $comment  = " رزرو " . " " . $reserveInfo['room_count'] . " باب اتاق در شهر " . " " . $reserveInfo['city_name'] . " در " . " " . $reserveInfo['hotel_name'] . " " . "به شماره رزرو " . " " . $reserveInfo['factor_number'] . ' /after book';
            $reason      = 'buy_hotel';
            $total_price = $reserveInfo['total_price_api'];

            $date = $reserveInfo['creation_date_int'];
            $newTimestamp = $date + (10 * 60);
            $price_date =  date("Y-m-d H:i:s", $newTimestamp);

        }
        else if($service == 'bus') {
            $reserveInfo = $this->getModel('reportBusModel')->get()->where('passenger_factor_num',$factor_number)->find();
            if(!$reserveInfo) {
                return functions::withError(false,404,'not found report.') ;
            }
            $client_id = $reserveInfo['client_id'] ;
            $comment = " رزرو بلیط اتوبوس " . $reserveInfo['OriginCity'] . " - " . $reserveInfo['DestinationCity'] . " (" . $reserveInfo['CompanyName'] . ")، تاریخ حرکت: " . $reserveInfo['DateMove'] . " - ساعت حرکت: " . $reserveInfo['TimeMove'] . " به شماره فاکتور: " . $reserveInfo['passenger_factor_num'] . ' /after book';

            $reason  = 'buy_bus';
            if ( $reserveInfo['WebServiceType'] == 'private' ) {
                $total_price = 0;
            } else {
                $total_price = $reserveInfo['price_api'];
            }

            $date = $reserveInfo['creation_date_int'];
            $newTimestamp = $date + (10 * 60);
            $price_date =  date("Y-m-d H:i:s", $newTimestamp);

        }
        else if($service == 'insurance') {
            $modelBase = Load::library('ModelBase');
            $reserveInfo = $this->getModel('reportInsuranceModel')->get()->where('factor_number',$factor_number)->find();
            if(!$reserveInfo) {
                return functions::withError(false,404,'not found report.') ;
            }
            $sql_query ="SELECT 
                            SUM(paid_price) AS totalPrice,
                            SUM(base_price+tax) AS totalPriceIncreased,
                            SUM(agency_commission) AS totalAgencyCommission,
                            SUM(irantech_commission) AS irantech_commission
                    FROM report_insurance_tb WHERE factor_number = '{$factor_number}' ";

            $client_id = $reserveInfo['client_id'] ;
            $prices = $modelBase->load($sql_query);
            $public = 'private' ;
            if(strpos($reserveInfo['serviceTitle'], 'Public') === 0 ) {
                $public = 'public' ;
            }
            $comment = " رزرو " . " " . $reserveInfo['reserveCount'] . " عدد " . " " . $reserveInfo['source_name_fa'] . " به مقصد " . " " . $reserveInfo['destination'] . " " . "به شماره فاکتور " . " " . $factor_number . ( $public == 'private' ? ' اختصاصی ' : ' اشتراکی ' ) . ' /after book';

            if ( $public == 'public' ) {
                $total_price = ( $prices['totalPriceIncreased'] - $prices['totalAgencyCommission'] ) + $prices['irantech_commission'];
            } else {
                $total_price = 0 + $prices['irantech_commission'];
            }

            $reason = 'buy_insurance';

            $date = $reserveInfo['creation_date_int'];
            $newTimestamp = $date + (10 * 60);
            $price_date =  date("Y-m-d H:i:s", $newTimestamp);
        }

        if($total_price>0){
            $data['Price'] = $total_price;
        }else{
            $data['Price'] = str_replace(',', '', $params['custom_pricing']);
        }

        $data['FactorNumber'] = trim($factor_number);
        $data['Comment'] = $comment;
        $data['Reason'] = $reason;
        $data['Status'] = '2';
        $data['PaymentStatus'] = 'success';
        $data['BankTrackingCode'] = '';
        $data['CreationDateInt'] = time();
        $data['PriceDate'] = $price_date;
        $data['clientID'] = $client_id;

        $checkTransaction = $this->getModel('transactionsModel')
            ->get()
            ->where('FactorNumber', trim($factor_number))
            ->openParentheses()
                ->where('Reason', $reason)
                ->orWhere('Reason', '')
            ->closeParentheses()
            ->where('Status', '2')
            ->where('clientID', $client_id)
            ->find();
        if (empty($checkTransaction)){
            // ➕ INSERT
            //gds
            $this->transactions->insertTransaction($data);

            unset($data['clientID']);
            //client
            $result = $this->getController('admin')
                ->ConectDbClient('', $client_id, "Insert", $data, "transaction_tb");
        }
        else{
            $data['created_at'] = $checkTransaction['created_at'];
            //gds
            $result = $this->getModel('transactionsModel')
                ->updateWithBind($data, [
                    'id' => $checkTransaction['id']
                ]);

            //client
            unset($data['clientID']);
            unset($data['created_at']);
            $ConditionClient=" FactorNumber='".trim($factor_number)."' and Status='2' and (Reason='".$reason."' or Reason='') ";
            $result = $this->getController('admin')
                ->ConectDbClient( '', $client_id, 'Update', $data, 'transaction_tb', $ConditionClient );

        }

        if($result) {
            return functions::withSuccess([$data,$result],200,'updated successfully') ;
        }else{
            return functions::withError(false,500,'error inserting transaction.') ;

        }
    }
}