<?php

class cancelBuy extends clientAuth
{

    public $transactions;
    /**
     * listCancel constructor.
     */
    public function __construct() {
        $this->Model = Load::library('Model');
        $this->ModelBase =  Load::library('ModelBase');
        $this->admin = Load::controller('admin');

        $this->transactions = $this->getModel('transactionsModel');
    }
    public function setRequestCancel($param)
    {


        $Model = Load::library('Model');
        $smsController = Load::controller('smsServices');
        $ModelBase = Load::library('ModelBase');
        $sql = " SELECT id FROM cancel_buy_tb WHERE factor_number = '{$param['factorNumber']}' ";
        $check = $Model->load($sql);


        if (empty($check)) {

            $dateInsert['client_id'] = CLIENT_ID;
            $dateInsert['id_member'] = Session::getUserId();
            $dateInsert['type_application'] = $param['typeApplication'];
            $dateInsert['factor_number'] = $param['factorNumber'];
            $dateInsert['backCredit'] = $param['backCredit'];
            $dateInsert['account_owner'] = $param['accountOwner'];
            $dateInsert['card_number'] = $param['cardNumber'];
            $dateInsert['name_bank'] = $param['nameBank'];
            $dateInsert['comment_user'] = $param['comment'];
            $dateInsert['request_date'] = dateTimeSetting::jdate('Y-m-d', '', '', '', 'en');
            $dateInsert['request_time'] = date('H:m:s');
            $dateInsert['status'] = 'request_user';
            $dateInsert['creation_date_int'] = time();

            $Model->setTable('cancel_buy_tb');
            $resultInsert[] = $Model->insertLocal($dateInsert);

            $ModelBase->setTable('report_cancel_buy_tb');
            $resultInsert[] = $ModelBase->insertLocal($dateInsert);

            if (!in_array('0', $resultInsert)) {

                $sql = " SELECT * FROM book_train_tb WHERE factor_number = '{$param['factorNumber']}' ";
                $checkBook = $Model->load($sql);
                $objSms = $smsController->initService('0');
                if ($objSms) {
                    $sms = 'درخواست استرداد شما با شماره '. $param['factorNumber'] .'  موفقیت در سیستم ثبت شد،شما میتوانید از این پس از طریق حساب کاربری خود پیگیری امور کنسلی بلیط خود را پیگیری نمایید،با تشکر' . CLIENT_NAME;
                    $smsArray = array(
                        'smsMessage' => $sms,
                        'cellNumber' => $checkBook['mobile_buyer']
                    );
                    $smsController->sendSMS($smsArray);
                    $smsArrayCounter = array(
                        'smsMessage' => $sms,
                        'cellNumber' => $checkBook['mobile_member']
                    );
                    $smsController->sendSMS($smsArrayCounter);
                    $smsManager = 'کنسلی جدید در سیستم ثبت شد';
                    $smsArrayManage = array(
                        'smsMessage' => $smsManager,
                        'cellNumber' => CLIENT_MOBILE
                    );
                    $smsController->sendSMS($smsArrayManage);
                }
                return 'success : ' . functions::Xmlinformation('ApplicationSuccessfullyRegistered');

            } else {
                return 'error : ' . functions::Xmlinformation('ErrorRegisteringRequest');
            }
        } else {
            return 'error : ' . functions::Xmlinformation('ErrorRegisteringRequestCacselBuy');
        }

    }


    public function rejectCancelRequest($id, $descriptionClient, $clientId = null)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $dataUpdate['status'] = 'reject_cancel_request';
        $dataUpdate['comment_admin'] = $descriptionClient;
        $dataUpdate['confirm_date'] = dateTimeSetting::jdate('Y-m-d', '', '', '', 'en');
        $dataUpdate['confirm_time'] = date('H:m:s');
        $condition = " id = '{$id}' ";

        if (TYPE_ADMIN == 1) {
            $admin = Load::controller('admin');
            $result[] = $admin->ConectDbClient('', $clientId, 'Update', $dataUpdate, 'cancel_buy_tb', $condition);
        } else {
            $Model->setTable('cancel_buy_tb');
            $result[] = $Model->update($dataUpdate, $condition);
        }

        $ModelBase->setTable('report_cancel_buy_tb');
        $result[] = $ModelBase->update($dataUpdate, $condition);

        if (!in_array("0", $result)) {
            return 'success : ' . functions::Xmlinformation('ApplicationSuccessfullyRegistered');
        } else {
            return 'error : ' . functions::Xmlinformation('ErrorRegisteringRequest');
        }

    }


    public function confirmCancel($param)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $dataUpdate['cancel_percent'] = $param['cancelPercent'];
        $dataUpdate['cancel_price'] = $param['cancelPrice'];
        $dataUpdate['comment_admin'] = $param['descriptionClient'];
        $dataUpdate['confirm_date'] = dateTimeSetting::jdate('Y-m-d', '', '', '', 'en');
        $dataUpdate['confirm_time'] = date('H:m:s');
        $dataUpdate['status'] = 'confirm_admin';
        $condition = " factor_number = '{$param['factor_number']}' AND type_application='{$param['typeApp']}' ";

        if (TYPE_ADMIN == '1') {
            $admin = Load::controller('admin');
            $result = $admin->ConectDbClient('', $param['clientId'], 'Update', $dataUpdate, 'cancel_buy_tb', $condition);
        } else {
            $Model->setTable('cancel_buy_tb');
            $result = $Model->update($dataUpdate, $condition);
        }

        $ModelBase->setTable('report_cancel_buy_tb');
        $resultModelBase = $ModelBase->update($dataUpdate, $condition);

        if ($result && $resultModelBase) {
            return 'success : ' . functions::Xmlinformation('ApplicationSuccessfullyRegistered');
        } else {
            return 'error : ' . functions::Xmlinformation('ErrorRegisteringRequest');
        }

    }


    public function registerCancelBuy($param)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $sql = " SELECT * FROM cancel_buy_tb WHERE factor_number = '{$param['factor_number']}' AND type_application='{$param['typeApp']}'";
        $result = $Model->load($sql);
        if (!empty($result)) {

            $methodName = 'setCancel' . ucfirst($result['type_application']);
            $resultSetCancel = $this->$methodName($result['factor_number']);
            if ($resultSetCancel) {


                $dataUpdate['status'] = 'cancelled';
                $dataUpdate['cancelled_date'] = dateTimeSetting::jdate('Y-m-d', '', '', '', 'en');
                $dataUpdate['cancelled_time'] = date('H:m:s');
                $condition = " factor_number = '{$param['factor_number']}' AND type_application='{$param['typeApp']}' ";
                $Model->setTable('cancel_buy_tb');
                $resultUpdate = $Model->update($dataUpdate, $condition);

                $ModelBase->setTable('report_cancel_buy_tb');
                $resultUpdateModalBase = $ModelBase->update($dataUpdate, $condition);

                if ($resultUpdate && $resultUpdateModalBase) {

                    switch ($result['type_application']) {
                        case 'hotel':
                            $type_application = 'هتل';
                            break;
                        case 'insurance':
                            $type_application = 'بیمه';
                            break;
                        case 'gashttransfer':
                            $type_application = 'گشت و ترانسفر';
                            break;
                        case 'europcar':
                            $type_application = 'اجاره خودرو';
                            break;
                        case 'tour':
                            $type_application = 'تور';
                            break;
                        case 'visa':
                            $type_application = 'ویزا';
                            break;
                        case 'bus':
                            $type_application = 'اتوبوس';
                            break;
                        case 'train':
                            $type_application = 'قطار';
                            break;
                        default:
                            $type_application = '';
                            break;
                    }
                    $isReservationBuy = $this->isReservationBuy($result['type_application'], $result['factor_number'], $result['client_id']);
                    if (!$isReservationBuy) {
                        $sql = " SELECT SUM(Price) AS paymentPrice FROM transaction_tb WHERE PaymentStatus = 'success' AND FactorNumber = '{$result['factor_number']}' ";
                        $dataTransaction = $Model->load($sql);
                        if (!empty($dataTransaction)) {
                            $this->smsConfirmCancel($param);
                            $data['Price'] = $dataTransaction['paymentPrice'] - $result['cancel_price'];
                        } else {
                            return 'error : ' . functions::Xmlinformation('ErrorRegisteringRequest');
                        }
                    } elseif ($isReservationBuy) {
                        $data['Price'] = 0;
                    }

                    $data['FactorNumber'] = $result['factor_number'];
                    $data['Comment'] = 'کنسلی خرید ' . $type_application . ' به شماره فاکتور: ' . $result['factor_number'];
                    $data['Reason'] = 'increase';
                    $data['Status'] = '2';
                    $data['PaymentStatus'] = 'success';
                    $data['BankTrackingCode'] = '';
                    $data['CreationDateInt'] = time();
                    $data['PriceDate'] = date("Y-m-d H:i:s");
                    $Model->setTable('transaction_tb');
                    $resultTransaction = $Model->insertLocal($data);

                    //for admin panel and table transactions
                    $this->transactions->insertTransaction($data);

                    if ($resultTransaction) {

                        return 'success : ' . functions::Xmlinformation('ApplicationSuccessfullyRegistered');
                    } else {
                        return 'error : ' . functions::Xmlinformation('ErrorRegisteringRequest');
                    }

                } else {
                    return 'error : ' . functions::Xmlinformation('ErrorRegisteringRequest');
                }


            } else {
                return 'error : ' . functions::Xmlinformation('ErrorRegisteringRequest');
            }

        } else {
            return 'error : ' . functions::Xmlinformation('ErrorRegisteringRequest');
        }
    }

    public function isReservationBuy($typeApplication, $factorNumber, $clientId)
    {
        switch ($typeApplication) {
            case 'hotel':
                $sql = " SELECT type_application FROM book_hotel_local_tb WHERE factor_number = '{$factorNumber}' ";
                break;
            case 'tour':
                $sql = " SELECT type_application FROM book_tour_local_tb WHERE factor_number = '{$factorNumber}' ";
                break;
            default:
                $sql = "";
                break;
        }
        if ($sql != '') {

            if (TYPE_ADMIN == 1) {
                $admin = Load::controller('admin');
                $result = $admin->ConectDbClient($sql, $clientId, 'Select', '', '', '');

            } else {
                $Model = Load::library('Model');
                $result = $Model->load($sql);
            }

            if (!empty($result) && ($result['type_application'] == 'reservation_app' || $result['type_application'] == 'reservation')) {
                return true;
            } else {
                return false;
            }


        } else {
            return false;
        }

    }

    public function setCancelHotel($factorNumber)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $dataUpdate['status'] = 'Cancelled';
        $condition = " factor_number = '{$factorNumber}' ";
        $Model->setTable('book_hotel_local_tb');
        $resultUpdate = $Model->update($dataUpdate, $condition);

        $ModelBase->setTable('report_hotel_tb');
        $resultUpdateBase = $ModelBase->update($dataUpdate, $condition);

        if ($resultUpdate && $resultUpdateBase) {
            return true;
        } else {
            return false;
        }

    }

    public function setCancelInsurance($factorNumber)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $dataUpdate['status'] = 'cancel';
        $condition = " factor_number = '{$factorNumber}' ";
        $Model->setTable('book_insurance_tb');
        $resultUpdate = $Model->update($dataUpdate, $condition);

        $ModelBase->setTable('report_insurance_tb');
        $resultUpdateBase = $ModelBase->update($dataUpdate, $condition);

        if ($resultUpdate && $resultUpdateBase) {
            return true;
        } else {
            return false;
        }

    }

    public function setCancelTrain($factorNumber)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $dataUpdate['request_cancel'] = 'confirm';
        $condition = " factor_number = '{$factorNumber}' ";
        $Model->setTable('book_train_tb');
        $resultUpdate = $Model->update($dataUpdate, $condition);

        $ModelBase->setTable('report_train_tb');
        $resultUpdateBase = $ModelBase->update($dataUpdate, $condition);

        if ($resultUpdate && $resultUpdateBase) {
            return true;
        } else {
            return false;
        }

    }

    public function setCancelGashttransfer($factorNumber)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $dataUpdate['status'] = 'cancel';
        $condition = " passenger_factor_num = '{$factorNumber}' ";
        $Model->setTable('book_gasht_local_tb');
        $resultUpdate = $Model->update($dataUpdate, $condition);

        $ModelBase->setTable('report_gasht_tb');
        $resultUpdateBase = $ModelBase->update($dataUpdate, $condition);

        if ($resultUpdate && $resultUpdateBase) {
            return true;
        } else {
            return false;
        }

    }

    public function setCancelEuropcar($factorNumber)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $dataUpdate['status'] = 'Cancellation';
        $condition = " factor_number = '{$factorNumber}' ";
        $Model->setTable('book_europcar_local_tb');
        $resultUpdate = $Model->update($dataUpdate, $condition);

        $ModelBase->setTable('report_europcar_tb');
        $resultUpdateBase = $ModelBase->update($dataUpdate, $condition);

        if ($resultUpdate && $resultUpdateBase) {
            return true;
        } else {
            return false;
        }

    }

    public function setCancelTour($factorNumber)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $dataUpdate['status'] = 'Cancellation';
        $condition = " factor_number = '{$factorNumber}' ";
        $Model->setTable('book_tour_local_tb');
        $resultUpdate = $Model->update($dataUpdate, $condition);

        $ModelBase->setTable('report_tour_tb');
        $resultUpdateBase = $ModelBase->update($dataUpdate, $condition);

        if ($resultUpdate && $resultUpdateBase) {
            return true;
        } else {
            return false;
        }

    }

    public function setCancelVisa($factorNumber)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $dataUpdate['status'] = 'cancel';
        $condition = " factor_number = '{$factorNumber}' ";
        $Model->setTable('book_visa_tb');
        $resultUpdate = $Model->update($dataUpdate, $condition);

        $ModelBase->setTable('report_visa_tb');
        $resultUpdateBase = $ModelBase->update($dataUpdate, $condition);

        if ($resultUpdate && $resultUpdateBase) {
            return true;
        } else {
            return false;
        }

    }

    public function setCancelBus($factorNumber)
    {
        $objApi = Load::library('apiBus');
        $result = $objApi->cancellationBusTicket($factorNumber);
        if (!isset($result['ErrorDetail']['Code']) && $result['Status'] == 'Refunded') {

            $Model = Load::library('Model');
            $ModelBase = Load::library('ModelBase');

            $dataUpdate['status'] = 'cancel';
            $condition = " passenger_factor_num = '{$factorNumber}' ";
            $Model->setTable('book_bus_tb');
            $resultUpdate = $Model->update($dataUpdate, $condition);

            $ModelBase->setTable('report_bus_tb');
            $resultUpdateBase = $ModelBase->update($dataUpdate, $condition);

            if ($resultUpdate && $resultUpdateBase) {
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    public function createExcelFile($param)
    {

        $_POST = $param;
        $resultBook = $this->cancelReportBuy('yes');
        if (!empty($resultBook)) {

            // برای نام گذاری سطر اول فایل اکسل //
            $firstRowColumnsHeading = ['ردیف', 'نرم افزار', 'نام کاربر', 'نام آژانس', 'شماره فاکتور', 'توضیحات کاربر', ' تاریخ درخواست', 'ساعت درخواست',
                'توضیحات مدیریت', ' تاریخ تایید درخواست', 'ساعت تایید درخواست', 'وضعیت', 'درصد کنسلی', 'مبلغ کنسلی', 'تاریخ کنسلی', 'ساعت کنسلی'];

            $objCreateExcelFile = Load::controller('createExcelFile');
            $resultExcel = $objCreateExcelFile->create($resultBook, $firstRowColumnsHeading);
            if ($resultExcel['message'] == 'success') {
                return 'success|' . $resultExcel['fileName'];
            } else {
                return 'error|متاسفانه در ساخت فایل اکسل مشکلی پیش آمده. لطفا مجددا تلاش کنید';
            }


        } else {
            return 'error|اطلاعاتی برای ساخت فایل اکسسل وجود ندارد.';
        }


    }

    public function cancelReportBuy($reportForExcel = null)
    {
        $date = dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode = explode('-', $date);
        $date_now_int_start = dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date_now_int_end = dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);

        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        if (TYPE_ADMIN == 1) {
            $sql = " SELECT * FROM report_cancel_buy_tb WHERE 1=1 ";
        } else {
            $sql = " SELECT * FROM cancel_buy_tb WHERE 1=1 ";
        }


        if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {

            $date_of = explode('-', $_POST['date_of']);
            $date_to = explode('-', $_POST['to_date']);
            $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
            $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        } else {
            $sql .= "AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";
        }
        if (isset($_POST['status']) && $_POST['status'] != '' && $_POST['status'] != 'all') {
            $sql .= " AND status='{$_POST['status']}' ";
        }
        if (!empty($_POST['factor_number'])) {
            $sql .= " AND factor_number ='{$_POST['factor_number']}'";
        }
        $sql .= "  ORDER BY creation_date_int DESC ";

        if (TYPE_ADMIN == 1) {
            $result = $ModelBase->select($sql);
        } else {
            $result = $Model->select($sql);
        }

        $dataRows = [];
        foreach ($result as $k => $val) {
            $numberColumn = $k + 2;

            switch ($val['type_application']) {
                case 'hotel':
                    $type_application = 'هتل';
                    break;
                case 'insurance':
                    $type_application = 'بیمه';
                    break;
                case 'gashttransfer':
                    $type_application = 'گشت و ترانسفر';
                    break;
                case 'europcar':
                    $type_application = 'اجاره خودرو';
                    break;
                case 'tour':
                    $type_application = 'تور';
                    break;
                case 'visa':
                    $type_application = 'ویزا';
                    break;
                case 'bus':
                    $type_application = 'اتوبوس';
                    break;
                default:
                    $type_application = '';
                    break;
            }

            switch ($val['status']) {
                case 'request_user':
                    $status = 'درخواست کنسلی کاربر';
                    break;
                case 'confirm_admin':
                    $status = 'تایید درخواست کنسلی';
                    break;
                case 'cancelled':
                    $status = 'کنسل شده';
                    break;
                default:
                    $status = 'نامشخص';
                    break;
            }

            $infoMember = functions::infoMember($val['id_member']);
            $clientName = functions::ClientName($val['client_id']);

            $dataRows[$k]['number_column'] = $numberColumn - 1;
            $dataRows[$k]['type_application_fa'] = $type_application;
            $dataRows[$k]['member_name'] = $infoMember['name'] . ' ' . $infoMember['family'];
            $dataRows[$k]['client_name'] = $clientName;
            $dataRows[$k]['factor_number'] = $val['factor_number'];
            $dataRows[$k]['comment_user'] = $val['comment_user'];
            $dataRows[$k]['request_date'] = $val['request_date'];
            $dataRows[$k]['request_time'] = $val['request_time'];
            $dataRows[$k]['comment_admin'] = $val['comment_admin'];
            $dataRows[$k]['confirm_date'] = $val['confirm_date'];
            $dataRows[$k]['confirm_time'] = $val['confirm_time'];
            $dataRows[$k]['status_fa'] = $status;
            $dataRows[$k]['cancel_percent'] = $val['cancel_percent'];
            $dataRows[$k]['cancel_price'] = $val['cancel_price'];
            $dataRows[$k]['cancelled_date'] = $val['cancelled_date'];
            $dataRows[$k]['cancelled_time'] = $val['cancelled_time'];

            if (!isset($reportForExcel) || (isset($reportForExcel) && $reportForExcel == 'no')) {
                $dataRows[$k]['id'] = $val['id'];
                $dataRows[$k]['id_member'] = $val['id_member'];
                $dataRows[$k]['account_owner'] = $val['account_owner'];
                $dataRows[$k]['card_number'] = $val['card_number'];
                $dataRows[$k]['name_bank'] = $val['name_bank'];
                $dataRows[$k]['status'] = $val['status'];
                $dataRows[$k]['creation_date_int'] = $val['creation_date_int'];
                $dataRows[$k]['type_application'] = $val['type_application'];
                $dataRows[$k]['client_id'] = $val['client_id'];
            }

        }

        return $dataRows;
    }

    public function cancelReportBuyByFactorNumber($typeApplication, $factorNumber)
    {
        if (TYPE_ADMIN == '1') {
            $Model = Load::library('ModelBase');
            $tableNameCancel = 'report_cancel_buy_tb';

        } else {
            $Model = Load::library('Model');
            $tableNameCancel = 'cancel_buy_tb';
        }

        $sqlCancel = "SELECT * FROM {$tableNameCancel} WHERE type_application = '{$typeApplication}' AND factor_number = '{$factorNumber}' ";
        $resultCancel = $Model->load($sqlCancel);

        return $resultCancel;
    }

    #region smsConfirmCancel
    public function smsConfirmCancel($param)
    {
        $Model = Load::library('Model');
        $smsController = Load::controller('smsServices');
        $objSms = $smsController->initService('0');
        if ($objSms) {
            $sql = " SELECT * FROM book_train_tb WHERE factor_number = '{$param['factor_number']}' ";
            $result = $Model->load($sql);

            $sms = ' مسافر گرامی'.PHP_EOL.' بلیط با شماره فاکتور'.$param['factor_number']. PHP_EOL .' از قطار شماره'. $result['TrainNumber'].'مورخ '. functions::ConvertToJalali($result['ExitDate']). ' به علت استرداد معتبر نمی باشد'.PHP_EOL . CLIENT_NAME;
            $smsArray = array(
                'smsMessage' => $sms,
                'cellNumber' => $result['mobile_buyer']
            );

            $smsController->sendSMS($smsArray);
        }
    }
    #endregion



    public function setCancelRequestUser($params)
    {

        $Model = Load::library('Model');
        $smsController = Load::controller('smsServices');
//        $ModelBase = Load::library('ModelBase');
        $sql = " SELECT id FROM cancel_ticket_details_tb WHERE FactorNumber = '{$params['FactorNumber']}' ";
        $check = $Model->load($sql);


        if (empty($check)) {


            $data['PercentIndemnity'] =0;
            $data['PercentNoMatter'] ='No';
            $data['PriceIndemnity'] =0;
            $data['DateSetCancelInt'] = 0;
            $data['DateRequestCancelClientInt'] = 0;
            $data['DateSetIndemnityInt'] = 0;
            $data['DateSetFailedIndemnityInt'] = 0;
            $data['DateConfirmClientInt'] = 0;
            $data['DateConfirmCancelInt'] = 0;
//            $data['MemberId'] = CLIENT_ID;
            $data['MemberId'] = Session::getUserId();
            $data['TypeCancel'] = $params['typeService'];
            $data['backCredit'] = $params['backCredit'];
            $data['RequestNumber'] = $params['FactorNumber'];
            $data['FactorNumber'] = $params['FactorNumber'];
            $data['Status'] = $params['Status'];
            $data['ReasonMember'] = $params['Reasons'];
            $data['AccountOwner'] = isset($params['AccountOwner']) ? $params['AccountOwner'] : '';
            $data['CardNumber'] = isset($params['CardNumber']) ? $params['CardNumber'] : '';
            $data['NameBank'] = isset($params['NameBank']) ? $params['NameBank'] : '';
            $data['comment_user'] = isset($params['commentUser']) ? $params['commentUser'] : '';
            $data['DateRequestMemberInt'] = time();


            $Model->setTable('cancel_ticket_details_tb');
            $result = $Model->insertLocal($data);
            $id = $this->Model->getLastId();

            if ($result) {
                $d['IdDetail'] = $id;
                $d['NationalCode'] = $params['FactorNumber'];
                $Model->setTable('cancel_ticket_tb');
                $result22 = $Model->insertLocal($d);
//                return 'success :' . functions::Xmlinformation("PasswordSuccessfullyChanged");
                return 'success : درخواست کنسلی شما با موفقیت ثبت شد';

            }else{
                return 'error : ' . functions::Xmlinformation('ErrorRegisteringRequestCacselBuy');
            }

        } else {
            return 'error : ' . functions::Xmlinformation('ErrorRegisteringRequestCacselBuy');
        }

    }



}