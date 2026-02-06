<?php


/**
 * Class listCancelUser
 * @property listCancelUser $listCancelUser
 */
class listCancelUser extends clientAuth
{

    public $id = '';
    public $list;
    public $edit;

    public $transactions;

    public function __construct()
    {
        $this->transactions = $this->getModel('transactionsModel');
        $this->admin = Load::controller('admin');

    }

    public function listCancelLocal()
    {
        Load::autoload('Model');
        $Model = new Model();

//        $sql = "SELECT cancel.*,book.pnr , book.eticket_number , book.pid_private FROM cancel_ticket_details_tb AS cancel"
//              ." LEFT JOIN book_local_tb AS book  ON  book.request_number=cancel.RequestNumber"
//              ." WHERE 1=1 ";


        $sql = "
SELECT 
    cancel.*, 
    book.pnr, 
    book.eticket_number, 
    book.pid_private,
    hotel.type_application
FROM cancel_ticket_details_tb AS cancel
LEFT JOIN book_local_tb AS book 
    ON book.request_number = cancel.RequestNumber
LEFT JOIN book_hotel_local_tb AS hotel
    ON hotel.factor_number = cancel.FactorNumber
WHERE 1=1
";


        if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {
            $date_of = explode('-', $_POST['date_of']);
            $date_to = explode('-', $_POST['to_date']);
            $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
            $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            $sql .= " AND DateRequestMemberInt >= '{$date_of_int}' AND DateRequestMemberInt  <= '{$date_to_int}'";
        }

        if (!empty($_POST['RequestNumber'])) {
            $sql .= " AND cancel.RequestNumber ='{$_POST['RequestNumber']}'";
        }

        if (!empty($_POST['pnr'])) {
            $sql .= " AND book.pnr ='{$_POST['pnr']}'";
        }

        if (!empty($_POST['eticket_number'])) {
            $sql .= " AND book.eticket_number ='{$_POST['eticket_number']}'";
        }

        $sql .="GROUP BY cancel.DateRequestMemberInt DESC";



//            var_dump($sql);
//            die();


        $res = $Model->select($sql);


        return $res;
    }

//    public function totalPriceFlight($Param, $id, $ClientId){
//        $listCancel = Load::controller('listCancel');
//        $Cancel = $listCancel->InfoCancelTicket($Param, $id, $ClientId);
//        $typeFlightCancel = ($Cancel[0]['TypeCancel'] == 'flight' || $Cancel[0]['TypeCancel'] == '');
//        $indemnityPrice = '0';
//
//        if ($typeFlightCancel) {
//            if($Cancel[0]['flight_type'] == 'system' && $Cancel[0]['IsInternal'] == '1') {
//                list($TotalPrice,$fare) = functions::TotalPriceCancelTicketSystem($Cancel);
//                $PricePenalty = functions::CalculatePenaltyPriceCancel($TotalPrice,$fare, $Cancel[0]);
//                $indemnityPrice =round($PricePenalty-(30000 * count($Cancel)));
//
//            }elseif($Cancel[0]['flight_type'] == 'charter'){
//                $TotalPrice = functions::TotalPriceNetTicketCharter($Cancel);
//
//                $indemnityPrice = round(functions::CalculatePenaltyPriceCancelCharter($TotalPrice, $Cancel[0]));
//
//
//            }
//        }
//
//        return $indemnityPrice;
//    }

    public function UserSendPercentForAgency($Param) {


        $sql = " SELECT * FROM cancel_ticket_details_tb WHERE id='{$Param['id']}'AND RequestNumber='{$Param['RequestNumber']}' ";


        $InfoCancel = $this->admin->ConectDbClient($sql, $Param['ClientId'], "Select", "", "", "");

        if (!empty($InfoCancel)) {
            $data['PercentIndemnity'] = $Param['PercentIndemnity'];
            $data['DescriptionAdmin'] = $Param['DescriptionAdmin'];
            $data['Status'] = 'ConfirmCancel';
            $data['DateConfirmCancelInt'] = time();

//            $indemnityPrice = $this->totalPriceFlight($Param['RequestNumber'] , $Param['id'] , $Param['ClientId']);

//            $data['PriceIndemnity'] = $indemnityPrice;
            $data['PriceIndemnity'] = 0;
            $Condition = "id={$Param['id']} AND RequestNumber='{$Param['RequestNumber']}'";

            $result = $this->admin->ConectDbClient('', $Param['ClientId'], "Update", $data, "cancel_ticket_details_tb", $Condition);

            if ($result) {

                $smsController = Load::controller('smsServices');
                $objSms = $smsController->initService('1');
                if ($objSms) {

                    $client_info = $this->getController('partner')->infoClient($Param['ClientId']) ;

//                    $cancel_type = ($InfoCancel['TypeCancel']=='flight') ? 'پرواز' :'اتوبوس' ;


                    if($InfoCancel['TypeCancel']=='flight')
                    {
                        $type='پرواز';
                    }elseif($InfoCancel['TypeCancel']=='bus'){
                        $type='اتوبوس';
                    }elseif($InfoCancel['TypeCancel']=='hotel'){
                        $type='هتل';
                    }elseif($InfoCancel['TypeCancel']=='insurance'){
                        $type='بیمه';
                    }elseif($InfoCancel['TypeCancel']=='gashttransfer'){
                        $type='گشت و ترانسفر';
                    }elseif($InfoCancel['TypeCancel']=='europcar'){
                        $type='اجاره خودرو';
                    }elseif($result['TypeCancel']=='tour'){
                        $type='تور';
                    }elseif($InfoCancel['TypeCancel']=='visa'){
                        $type='ویزا';
                    }elseif($InfoCancel['TypeCancel']=='entertainment'){
                        $type='تفریحات';
                    }else{
                        $type='قطار';
                    }
                    Load::autoload('Model');
                    $Model = new Model();
                    $request_number = $Param['RequestNumber'];

                    if($InfoCancel['TypeCancel']=='flight') {
                        $sql = "
                        SELECT member_mobile , factor_number , origin_city , desti_city
                        FROM book_local_tb
                        WHERE request_number = '$request_number'
                          AND member_mobile IS NOT NULL
                          AND member_mobile <> ''
                        ORDER BY id DESC
                        LIMIT 1
                    ";
                        $res = $Model->load($sql);
                        $sms = " مسافر گرامی درصد جریمه کنسلی پرواز {$res['origin_city']} به {$res['desti_city']} {$cancel_type}به شماره درخواست ";
                        $sms .= $res['factor_number'];
                        $sms .= PHP_EOL;
                        $sms .= " به میزان %";
                        $sms .= $Param['PercentIndemnity'];
                        $sms .= " میباشد. خواهشمند است با توجه به احتمال افزایش درصد جریمه اعلامی ، در صورت تمایل به کنسلی نهایتا تا 15 دقیقه دیگر با پشتیبانی تماس حاصل فرمایید، در غیر این صورت بلیط شما با جریمه مذکور کنسل میگردد.  با تشکر  ";
                        $sms .= PHP_EOL;
                        $sms .= "http://{$client_info['Domain']}";

                        $cellArray = array(
                            'manager' => $res['member_mobile'],
                        );
                        foreach ($cellArray as $cellNumber) {
                            $smsArray = array(
                                'smsMessage' => $sms,
                                'cellNumber' => $cellNumber
                            );
                            $smsController->sendSMS($smsArray);
                        }
                    } if($InfoCancel['TypeCancel']=='hotel'){
                        $sql = "
                        SELECT member_mobile , factor_number , hotel_name
                        FROM book_hotel_local_tb
                        WHERE factor_number = '$request_number'
                          AND member_mobile IS NOT NULL
                          AND member_mobile <> ''
                        ORDER BY id DESC
                        LIMIT 1
                    ";
                        $res = $Model->load($sql);
                        $sms = " مسافر گرامی درصد جریمه کنسلی {$res['hotel_name']} {$cancel_type}به شماره درخواست ";
                        $sms .= $res['factor_number'];
                        $sms .= PHP_EOL;
                        $sms .= " به میزان %";
                        $sms .= $Param['PercentIndemnity'];
                        $sms .= " میباشد. خواهشمند است با توجه به احتمال افزایش درصد جریمه اعلامی ، در صورت تمایل به کنسلی نهایتا تا 15 دقیقه دیگر با پشتیبانی تماس حاصل فرمایید، در غیر این صورت هتل شما با جریمه مذکور کنسل میگردد.  با تشکر  ";
                        $sms .= PHP_EOL;
                        $sms .= "http://{$client_info['Domain']}";

                        $cellArray = array(
                            'manager' => $res['member_mobile'],
                        );
                        foreach ($cellArray as $cellNumber) {
                            $smsArray = array(
                                'smsMessage' => $sms,
                                'cellNumber' => $cellNumber
                            );
                            $smsController->sendSMS($smsArray);
                    }

                }

                return 'success : درصد تعیین شده با موفقیت ثبت شد';
            } else {
                return 'error : خطا در ثبت درصد ،لطفا مجددا تلاش نمائید';
            }
        } else {
            return 'error : در خواست  نا معتبر است';
        }
    }}
    public function format_hour($num)
    {

        $time = date("H:i", strtotime($num));

        return $time;
    }

    public function total_price($RequestNumber)
    {
        Load::autoload('apiLocal');
        $Model = new apiLocal();

        $amount = $Model->get_total_ticket_price($RequestNumber, 'yes');

        return $amount;
    }

    public function TypeFlight($request_number)
    {

        Load::autoload('Model');
        $Model = new Model();

        $sql = "select * from book_local_tb  where request_number='$request_number' ";
        $result = $Model->load($sql);

        $this->Pid = $result['pd_private'];

        return $result['flight_type'];
    }

    public function ConfirmCancelByAgency($Param)
    {

        $Model = Load::library('Model');
        $smsController = Load::controller('smsServices');

        $id = $Param['id'];
        $RequestNumber = $Param['RequestNumber'];
      
        $sql = "SELECT  * FROM  cancel_ticket_details_tb  WHERE  id={$id} AND RequestNumber='{$RequestNumber}' ";
        $result = $Model->load($sql);

        if($Param['typeCancel']=='flight') {
            $sqlBook = "SELECT  * FROM  book_local_tb  WHERE request_number='{$RequestNumber}'";
            $resultBook = $Model->load($sqlBook);
            $date = dateTimeSetting::jdate("Y-F-d", functions::ConvertToDateJalaliInt($resultBook['date_flight']));
        }elseif ($Param['typeCancel']=='bus'){
            $sqlBook = "SELECT  * FROM  book_bus_tb  WHERE order_code='{$RequestNumber}'";
            $resultBook = $Model->load($sqlBook);
            $date = dateTimeSetting::jdate("Y-F-d", time(),'','','en');
        }


        if (!empty($result)) {
            if(!empty($Param['Indemnity'])) {
                $data['DescriptionClient'] = $Param['DescriptionClient'];
                $data['Status'] = "ConfirmClient";
                $data['PercentIndemnity'] = $Param['Indemnity'];
                $data['DateRequestCancelClientInt'] = time();
                $data['DateSetIndemnityInt'] = time();
                $data['DateConfirmClientInt'] = time();
            }else{
                $data['DescriptionClient'] = $Param['DescriptionClient'];
                $data['Status'] = "RequestClient";
                $data['DateRequestCancelClientInt'] = time();
            }
            $isCreditPayment =$Param['isCreditPayment'];

            if($isCreditPayment =='true')
            {
                $data['isCreditPayment'] = "1";
            }else{
                $data['isCreditPayment'] = '0';
            }

            $Model->setTable('cancel_ticket_details_tb');
            $Condition = "id={$id} AND RequestNumber='{$RequestNumber}'";
            $UpdateResult = $Model->update($data, $Condition);

            if ($UpdateResult) {

                $smsController = Load::controller('smsServices');
                $objSms = $smsController->initService('1');

                if($objSms) {

                    if($result['TypeCancel']=='flight')
                    {
                        if (strtolower($resultBook['flight_type']) == 'system') {
                            if ($resultBook['pid_private'] == '1') {
                                $type = 'سیستمی اختصاصی';
                            } else {
                                $type = 'سیستمی اشتراکی';
                            }
                        } else {
                            $type = 'چارتری';
                        }
                    }elseif($result['TypeCancel']=='bus'){
                        $type='اتوبوس';
                    }elseif($result['TypeCancel']=='hotel'){
                        $type='هتل';
                    }elseif($result['TypeCancel']=='insurance'){
                        $type='بیمه';
                    }elseif($result['TypeCancel']=='gashttransfer'){
                        $type='گشت و ترانسفر';
                    }elseif($result['TypeCancel']=='europcar'){
                        $type='اجاره خودرو';
                    }elseif($result['TypeCancel']=='tour'){
                        $type='تور';
                    }elseif($result['TypeCancel']=='visa'){
                        $type='ویزا';
                    }elseif($result['TypeCancel']=='entertainment'){
                        $type='تفریحات';
                    }else{
                        $type='قطار';
                    }

                    $sms = "کنسلی جدید-" . CLIENT_NAME . "-{$date}-{$type}";
                    $cellArray = array(
                        'abasi2' => '09057078341',
                        'alami' => '09155909722',
                        'hasti' => '09351252904'

                    );
                    foreach ($cellArray as $cellNumber){
                        $smsArray = array(
                            'smsMessage' => $sms,
                            'cellNumber' => $cellNumber
                        );
                        $smsController->sendSMS($smsArray);
                    }
                }

                return "success : در خواست شما با موفقیت به سمت کارگزار هدایت شد";
            } else {
                return "error : خطا در ثبت در خواست،لطفا مجددا تلاش نمائید";
            }


        } else {
            return "error : درخواست معتبر نمی باشد";
        }
    }


    public function FailedCancelByAgency($Param)
    {

        Load::autoload('Model');
        $Model = new Model();
        $id = $Param['id'];
        $RequestNumber = $Param['RequestNumber'];

        $sql = "SELECT  * FROM  cancel_ticket_details_tb  WHERE  id={$id} AND RequestNumber='{$RequestNumber}' ";
        $result = $Model->load($sql);

        if ($result) {
            $data['DescriptionClient'] = $Param['DescriptionClient'];
            $data['Status'] = "SetCancelClient";
            $data['DateSetCancelInt'] = time();

            $Model->setTable('cancel_ticket_details_tb');

            $Condition = "id={$id} AND RequestNumber='{$RequestNumber}'";
            $UpdateResult = $Model->update($data, $Condition);

            if ($UpdateResult) {
                return "success : رد در خواست با موفقیت ثبت شد";
            } else {
                return "error : خطا در ثبت در خواست،لطفا مجددا تلاش نمائید";
            }


        } else {
            return "error : درخواست معتبر نمی باشد";
        }
    }

    public function ConfirmAgencyForPercent($Param)
    {


        Load::autoload('Model');
        $Model=new Model();
        $id=$Param['id'];
        $RequestNumber=$Param['RequestNumber'];
        $serviceType=$_POST['serviceType'];


        $sql="SELECT  * FROM  cancel_ticket_details_tb  WHERE  id={$id} AND RequestNumber='{$RequestNumber}' ";
        $result=$Model->load($sql);

        if($result){

            $data['Status']="ConfirmClient";
            $data['DateConfirmClientInt']=time();

            $Model->setTable('cancel_ticket_details_tb');

            $Condition="id={$id} AND RequestNumber='{$RequestNumber}'";
            $UpdateResult=$Model->update($data, $Condition);

            if($UpdateResult){
                return "success : در خواست شما با موفقیت به سمت کارگزار هدایت شد";
            }
            return "error : خطا در ثبت در خواست،لطفا مجددا تلاش نمائید";
        }
        return "error : درخواست معتبر نمی باشد";
    }

    public function FailedAgencyForPercent($Param)
    {

        Load::autoload('Model');
        $Model = new Model();
        $id = $Param['id'];
        $RequestNumber = $Param['RequestNumber'];

        $sql = "SELECT  * FROM  cancel_ticket_details_tb  WHERE  id={$id} AND RequestNumber='{$RequestNumber}' ";
        $result = $Model->load($sql);

        if ($result) {
            $data['Status'] = "SetFailedIndemnity";
            $data['DateSetFailedIndemnityInt'] = time();

            $Model->setTable('cancel_ticket_details_tb');

            $Condition = "id={$id} AND RequestNumber='{$RequestNumber}'";
            $UpdateResult = $Model->update($data, $Condition);

            if ($UpdateResult) {
                return "success : رد درصد توسط آژانس با موفقیت انجام شد";
            } else {
                return "error : خطا در ثبت در خواست،لطفا مجددا تلاش نمائید";
            }


        } else {
            return "error : درخواست معتبر نمی باشد";
        }
    }

    public function ConfirmPercentAndPricePrivate($Param)
    {

        Load::autoload('Model');
        Load::autoload('ModelBase');
        $Model = new Model();
        $ModelBase = new ModelBase();
        $id = $Param['id'];
        $RequestNumber = $Param['RequestNumber'];

        $sql = "SELECT  * FROM  cancel_ticket_details_tb  WHERE  id={$id} AND RequestNumber='{$RequestNumber}' ";

        $result = $Model->load($sql);

        if ($result) {

            $data['Status'] = "ConfirmCancel";
            $data['DateConfirmClientInt'] = time();
            $data['DateSetIndemnityInt'] = time();
            $data['DateConfirmCancelInt'] = time();
            $data['PercentIndemnity'] = $Param['PercentIndemnity'];
            $data['PriceIndemnity'] = $Param['PriceIndemnity'];
            $data['DescriptionClient'] = $Param['DescriptionClient'];
            $data['DescriptionAdmin'] = "پرواز اختصاصی بوده و آژانس مربوطه اقدام به اعلام درصد و پرداخت مبلغ نموده است";

            $Model->setTable('cancel_ticket_details_tb');

            $Condition = "id={$id} AND RequestNumber='{$RequestNumber}'";
            $UpdateResult = $Model->update($data, $Condition);

            $sql = "SELECT * FROM cancel_ticket_tb WHERE IdDetail='{$id}'";

            $InfoCancelNationalCodes = $Model->select($sql);

            if ($UpdateResult) {

                if($result['TypeCancel'] == 'flight') {
                    $transaction_reason = 'بند برگشت استرداد بلیط ' . $Param['RequestNumber'] . '';
                }else if($result['TypeCancel'] == 'hotel'){
                    $transaction_reason = 'بند برگشت استرداد هتل ' . $Param['RequestNumber'] . '';
                }else if($result['TypeCancel'] == 'bus'){
                    $transaction_reason = 'بند برگشت استرداد اتوبوس ' . $Param['RequestNumber'] . '';
                }else if($result['TypeCancel'] == 'insurance'){
                    $transaction_reason = 'بند برگشت استرداد بیمه ' . $Param['RequestNumber'] . '';
                }

                $d['Price'] = '0';
                $d['Comment'] = $transaction_reason;
                $d['Status'] = '1';
                $d['Reason'] = 'indemnity_cancel';
                $d['FactorNumber'] = 'ES' . rand(100000, 999999);
                $d['PaymentStatus'] = 'success';
                $d['CreationDateInt'] = time();
                $d['PriceDate'] = date("Y-m-d H:i:s");

                $Model->setTable('transaction_tb');
                $Model->insertLocal($d);

                //for admin panel and transactions table
                $this->transactions->insertTransaction($d);

                $NationalCodeUser = array();
                foreach ($InfoCancelNationalCodes as $key => $NationalCode) {

                    $NationalCodeUser[] = $NationalCode['NationalCode'];
                    $join = join(',', $NationalCodeUser);
                    $book['request_cancel'] = 'confirm';

                    $Condition = "request_number='{$RequestNumber}' AND passenger_national_code='{$NationalCode['NationalCode']}'";

                    $Model->setTable('book_local_tb');
                    $Model->update($book, $Condition);

                    $ModelBase->setTable('report_tb');
                    $ModelBase->update($book, $Condition);
                }


                $sqlBook = "SELECT   * FROM  book_local_tb  WHERE request_number='{$RequestNumber}' AND passenger_national_code in($join) ";
                $resultBook = $Model->select($sqlBook);


                $arrayEticketNumber = array();
                $dm['Pnr'] = isset($resultBook[0]['pnr']) ? $resultBook[0]['pnr'] : '0';
                foreach ($resultBook as $item) {
                    $arrayEticketNumber[] = $item['eticket_number'];
                }
                $dm['EticketNumber'] = $arrayEticketNumber;
//                Load::autoload('apiLocal');
//                $ApiLocal = new apiLocal();
//                $url = "http://trusttest.ir/V4/FlightRequest/CancelInfo";
//
//                $JsonArray = json_encode($dm);
//                $ApiLocal->curlExecution($url, $JsonArray, 'yes');

                return "success : در خواست شما با موفقیت انجام شد";
            } else {
                return "error : خطا در ثبت درخواست";
            }
        } else {
            return "error : درخواست معتبر نمی باشد";
        }
    }


    public function getReportCancelAgency($agencyId)
    {
        /** @var cancelTicketModel $cancelTicketModel */
	    $cancelTicketModel = Load::getmodel('cancelTicketModel');
        $infoMembersAgency =  $cancelTicketModel->getReportCancelAgency($agencyId);

        $dataMemberAgency = array();

        foreach ($infoMembersAgency as $key=>$item) {

            $dataMemberAgency[$key]['column'] = $key + 1;
            $dataMemberAgency[$key]['requestNumberAndFactorNumber'] = $item['RequestNumber'].'<br/><hr/> '. $item['FactorNumber'];
            $dataMemberAgency[$key]['status'] = functions::titleStatusCancel($item['Status']);
            $dataMemberAgency[$key]['percentPenalty'] = $item['PercentIndemnity'] .' %';
            $dataMemberAgency[$key]['amountReturned'] = $item['PriceIndemnity'];
            $dataMemberAgency[$key]['type'] = functions::ConvertByLanguage($item['TypeCancel']);
        }


        $dataMemberAgency = array('data'=>$dataMemberAgency);
        return json_encode($dataMemberAgency);
    }

    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        return json_encode([
            'success' => $success,
            'message' => $message,
            'code' => $statusCode,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function DirectCancellationFlightAdmin($params)
    {
        $listCancelController = Load::controller('listCancel');
        $userToAgency = $listCancelController->SetRequestCancelUser($params , false , true);

        if (strpos($userToAgency, 'error') !== false) {
            return $this->returnJson(false , 'در مرحله ارسال کنسلی از کاربر به آژانس خطایی رخ داده');
        }

        $cancelTicketDetailsModel = $this->getModel('cancelTicketDetailsModel');
        $idInCancelTb = $cancelTicketDetailsModel
            ->get('*')
            ->where('RequestNumber', $params['RequestNumber'])
            ->find(false);
        $params['id'] = $idInCancelTb['id'];
        $params['TypeCancel'] = $idInCancelTb['TypeCancel'];


        $CancellationFeeSettingController = Load::controller('cancellationFeeSetting');
        $CalculateIndemnity = $CancellationFeeSettingController->CalculateIndemnity($params['RequestNumber']);

        if (isset($CalculateIndemnity) && is_numeric($CalculateIndemnity)) {
            $params['Indemnity'] = $CalculateIndemnity;
        } else {
            $params['Indemnity'] = '';
        }


        $agencyToAdmin  = $this->ConfirmCancelByAgency($params);


        if (strpos($agencyToAdmin, 'error') !== false) {
            return $this->returnJson(false , 'در مرحله ارسال کنسلی از آژانس به ادمین اصلی خطایی رخ داده');
        }

        return $this->returnJson(true , 'درخواست کنسلی با موفقیت ثبت شد و وضعیت رزرو در پنل کاربر نیز تغییر کرد');
    }

    public function DirectCancellationHotelAdmin($params) {

        $listCancelController = Load::controller('cancelBuy');
        $userToAgency = $listCancelController->setCancelRequestUser($params);

        if (strpos($userToAgency, 'error') !== false) {
            return $this->returnJson(false , 'در مرحله ارسال کنسلی از کاربر به آژانس خطایی رخ داده' , $userToAgency);
        }

        $cancelTicketDetailsModel = $this->getModel('cancelTicketDetailsModel');
        $idInCancelTb = $cancelTicketDetailsModel
            ->get('*')
            ->where('FactorNumber', $params['FactorNumber'])
            ->find(false);
        $params['id'] = $idInCancelTb['id'];
        $params['TypeCancel'] = $idInCancelTb['TypeCancel'];


        $agencyToAdmin  = $this->ConfirmCancelByAgency($params);

        if (strpos($agencyToAdmin, 'error') !== false) {
            return $this->returnJson(false , 'در مرحله ارسال کنسلی از آژانس به ادمین اصلی خطایی رخ داده');
        }

        return $this->returnJson(true , 'درخواست کنسلی با موفقیت ثبت شد و وضعیت رزرو در پنل کاربر نیز تغییر کرد');

    }

}
