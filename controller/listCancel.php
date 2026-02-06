<?php

//if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}
/**
 * Class listCancel
 * @property listCancel $listCancel
 * @property Model      $Model
 * @property ModelBase  $ModelBase
 * @property admin      $admin
 * @property string     $Pid
 */
class listCancel extends clientAuth {
	public $id = '';
	public $list;
	public $edit;
	public $Model;
	public $ModelBase;
	public $admin;
	public $Pid;

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

	public function ListCancelAdmin() {

		$sql = " SELECT * FROM clients_tb WHERE id >'1'";
		$res = $this->ModelBase->select($sql);


		$date = dateTimeSetting::jdate("Y-m-d", time());
		$date_now_explode = explode('-', $date);
		$date_now_int_start = dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
		$date_now_int_end = dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);

		$ListCancelClient = [];
		foreach ($res as $each) {

			if ($each['id'] > '1') {

				$sql = "SELECT TCancel.*, Cancel.*,Ticket.pnr,Ticket.IsInternal , Ticket.api_id "
                    . " FROM cancel_ticket_tb AS TCancel "
                    . " LEFT JOIN cancel_ticket_details_tb AS Cancel ON Cancel.id = TCancel.IdDetail"
                    . " LEFT JOIN book_local_tb AS Ticket ON Ticket.request_number = Cancel.RequestNumber"
                    . " WHERE Cancel.Status <> 'SetCancelClient' AND Cancel.Status <> 'RequestMember' AND Cancel.Status <> 'Nothing'"
                    . " AND Cancel.Status <> 'ConfirmCancel' AND Cancel.Status != 'close' ";


				if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {

					$date_of = explode('-', $_POST['date_of']);
					$date_to = explode('-', $_POST['to_date']);
					$date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
					$date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
					$sql .= " AND TCancel.DateRequestCancelClientInt >= '{$date_of_int}' AND TCancel.DateRequestCancelClientInt  <= '{$date_to_int}'";
				}

				if (!empty($_POST['Status'])) {

					$sql .= " AND TCancel.Status ='{$_POST['Status']}'  ";
				}

				if (!empty($_POST['RequestNumber'])) {
					$sql .= " AND TCancel.RequestNumber ='{$_POST['RequestNumber']}'";
				}


				$sql .= "GROUP BY TCancel.IdDetail ";

				$CancelClient = $this->admin->ConectDbClient($sql, $each['id'], "SelectAll", "", "", "");
                $apiProviders = [
                    '1'  => 'سرور 5',
                    '5'  => 'سرور 4',
                    '8'  => 'سرور 7',
                    '10' => 'سرور 9',
                    '11' => 'سرور 10',
                    '12' => 'سرور 12',
                    '13' => 'سرور 13',
                    '14' => 'سرور 14',
                    '15' => 'سرور 15',
                    '16' => 'سرور 16',
                    '17' => 'سرور 17',
                    '18' => 'سرور 18',
                    '19' => 'سرور 19',
                    '20' => 'سپهر',
                    '21' => 'چارتر118',
                    '43' => 'سیتی نت',
                ];





				if(!empty($CancelClient))
                {
                    foreach ($CancelClient as $key => &$CancelRequest) {
                        $CancelRequest['AgencyName'] = $each['AgencyName'];
                        $CancelRequest['ClientId'] = $each['id'];
                        $CancelRequest['provider_name'] =  isset($apiProviders[$CancelRequest['api_id']]) ? $apiProviders[$CancelRequest['api_id']] : 'نامشخص';
                        $ListCancelClient[] = $CancelRequest;
                    }
                }

			}
		}


        $Cancel = array();
		foreach ($ListCancelClient as $key => $row) {
			$Cancel['DateRequestCancelClientInt'][$key] = $row['DateRequestCancelClientInt'];
		}

		array_multisort($Cancel['DateRequestCancelClientInt'], SORT_DESC, $ListCancelClient);
        $factorColors = [];
        $colorList = ["#fbbdbd", "#d2cbcb"];
        $colorIndex = 0;

        foreach ($ListCancelClient as &$item) {
            $factorNumber = $item['FactorNumber'];
            if (!isset($factorColors[$factorNumber])) {
                $factorColors[$factorNumber] = $colorList[$colorIndex % count($colorList)];
                $colorIndex++;
            }
            // Apply the color to the current item
            $item['color'] = $factorColors[$factorNumber];
            $item['InfoRecord'] = $factorNumber;
        }
//        unset($item);
//        if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
//            var_dump($ListCancelClient);
//            die();
//        }

		return $ListCancelClient;
	}


	public function ListCancelAdminCertain() {
		$sql = " SELECT * FROM clients_tb";
		$res = $this->ModelBase->select($sql);

		$ListCancelClient = [];
		foreach ($res as $each) {

			if ($each['id'] > '1') {

				$sql = "SELECT TCancel.*, Cancel.*" . " FROM cancel_ticket_tb AS TCancel " . " LEFT JOIN cancel_ticket_details_tb AS Cancel ON Cancel.id = TCancel.IdDetail" . " WHERE  (Cancel.Status = 'ConfirmCancel' OR Cancel.Status = 'close') ";

                if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {

                    $date_of = explode('-', $_POST['date_of']);
                    $date_to = explode('-', $_POST['to_date']);

                }else{
                    $date1 = dateTimeSetting::jdate("Y-m-d", strtotime('-7 day'));
                    $date2 = dateTimeSetting::jdate("Y-m-d", time());
                    $date_of = explode('-', $date1);
                    $date_to = explode('-', $date2);


                }
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
                $sql .= " AND Cancel.DateRequestMemberInt >= '{$date_of_int}' AND Cancel.DateRequestMemberInt  <= '{$date_to_int}'";



                if (!empty($_POST['RequestNumber'])) {
                    $sql .= " AND Cancel.RequestNumber ='{$_POST['RequestNumber']}'";
                }

				$sql .=' GROUP BY TCancel.IdDetail ';

				$CancelClient = $this->admin->ConectDbClient($sql, $each['id'], "SelectAll", "", "", "");

				foreach ($CancelClient as $key => $CancelRequest) {
					$CancelRequest['AgencyName'] = $each['AgencyName'];
					$CancelRequest['ClientId'] = $each['id'];
					$ListCancelClient[] = $CancelRequest;
				}
			}

		}


		$Cancel = array();
		foreach ($ListCancelClient as $key => $row) {
			$Cancel['DateRequestCancelClientInt'][$key] = $row['DateRequestCancelClientInt'];
		}

		array_multisort($Cancel['DateRequestCancelClientInt'], SORT_DESC, $ListCancelClient);


		return $ListCancelClient;
	}

	public function TypeFlight($request_number) {
		$sql = "select * from book_local_tb  where request_number='{$request_number}' ";
		$result = $this->Model->load($sql);

		$this->Pid = $result['pd_private'];

		return $result['flight_type'];
	}

    public function GoToSetRequestCancelUser($params, $apiCancel = false) {

        $_POST = $params;
        $this->SetRequestCancelUser($params, $apiCancel);
    }
	public function SetRequestCancelUser($params, $apiCancel = false, $exitOption = false) {


        $Model = Load::library('Model');

        $has_not_canceled_national_code = [] ;
        foreach ($params['NationalCodes'] as $nationalCode) {
            $nationalCode = explode( '-' , $nationalCode) ;

            $sql = "SELECT * FROM cancel_ticket_details_tb
                INNER JOIN cancel_ticket_tb ON cancel_ticket_tb.IdDetail = cancel_ticket_details_tb.id
        WHERE cancel_ticket_details_tb.RequestNumber='{$params['RequestNumber']}'AND
              cancel_ticket_details_tb.FactorNumber='{$params['FactorNumber']}' AND
               cancel_ticket_tb.NationalCode='{$nationalCode[0]}'
              ";

            $ListCancelRTRD = $Model->select($sql);
            if(!$ListCancelRTRD) {
                $has_not_canceled_national_code[] =  $nationalCode;
            }
        }
        if(count($has_not_canceled_national_code) == 0 ) {
            if ($exitOption) {
                return;
            } else {
                echo 'error : خطا! درخواست کنسلی شما تکراری می باشد!';
                exit();
            }
        }


//        $sql = " SELECT * FROM cancel_ticket_details_tb WHERE RequestNumber='{$params['RequestNumber']}'AND FactorNumber='{$params['FactorNumber']}' ";
//        $ListCancelRTRD = $Model->select($sql);

//        if (!$ListCancelRTRD) {
            $smsController = Load::controller('smsServices');

            if ($apiCancel) {
                $_POST = $params;
            }

            $NationalCodesWithAge = $_POST['NationalCodes'];


            $BookResult = $this->getInfoCancelWithTypeService($_POST, $apiCancel);

            list($Age, $NationalCodes) = $this->getNationalCodesRequest($NationalCodesWithAge);
            list($adt, $chd, $inf) = $this->getCountAge($Age);

            if (!empty($BookResult)) {

                if (($BookResult['Adt_passenger'] - $adt) >= 1 || (($inf + $chd + $adt) == ($BookResult['Adt_passenger'] + $BookResult['Chd_passenger'] + $BookResult['Inf_passenger'])) || $_POST['typeService'] == 'bus') {

                    list($result, $id) = $this->insertInfoCancel($_POST, $apiCancel);

                    $_POST['idDetailCancel'] = $id;
                    if ($result) {
                        $this->insertNationalCodeCancel($NationalCodes, $_POST, $apiCancel);
                        //sms to site manager
                        /** @var smsServices $smsController */
                        $this->sendSmsCancel($smsController, $BookResult);

                        if ((isset($_POST['Type']) && $_POST['Type'] == 'App') || $apiCancel) {

                            if ($apiCancel) {

                                $objSms = $smsController->initService('1');
                                if ($objSms) {

                                    $sms = "کنسلی جدید از طرف " . CLIENT_NAME . "ثبت شد";
                                    $cellArray = array(
                                        'afraze' => '09057078341'
                                    );
                                    foreach ($cellArray as $cellNumber) {
                                        $smsArray = array(
                                            'smsMessage' => $sms,
                                            'cellNumber' => $cellNumber
                                        );
                                        $smsController->sendSMS($smsArray);
                                    }
                                }
                                $MessageCancel['Status'] = 'success';
                                $MessageCancel['Message'] = 'کنسلی شما با موفقیت ثبت شد،برای پیگیری روند به پنل مدیریت خود مراجعه فرمائید';

                                return json_encode($MessageCancel);
                            }
                            $MessageCancel['Status'] = 'success';
                            $MessageCancel['Message'] = functions::Xmlinformation('RequestCancellationYourPurchaseScrutiny');

                            return json_encode($MessageCancel);
                        } else {
                            if (Session::IsLogin()) {
                                if (!$exitOption) {
                                    echo 'success : ' . functions::Xmlinformation('YourPurchaseCancellationRequestSuccessfullySubmittedPlusDetail');
                                }
                                $objSms = $smsController->initService('0');
                                if ($objSms) {
                                    $sms = " مسافر گرامی  کنسلی شما، به شماره درخواست ";
                                    $sms .= $_POST['RequestNumber'];
                                    $sms .= PHP_EOL;
                                    $sms .= "در سیستم ثبت شد،شما میتوانید از قسمت پروفایل کاربری و یا قسمت پیگیری خرید ،کنسلی خود را پیگیری نمایید  ";


                                    $cellArray = array(
                                        'manager' => $BookResult['mobile_buyer'],
                                    );
                                    foreach ($cellArray as $cellNumber) {
                                        $smsArray = array(
                                            'smsMessage' => $sms,
                                            'cellNumber' => $cellNumber
                                        );
                                        $smsController->sendSMS($smsArray);
                                    }
                                }
                                if ($exitOption) {
                                    return;
                                } else {
                                    exit();
                                }
                            } else {
                                if ($exitOption) {
                                    return;
                                } else {
                                    echo 'success :  ' . functions::Xmlinformation('RequestCancellationYourPurchaseScrutiny');
                                    exit();
                                }
                            }
                        }

                    } else {
                        if ((isset($_POST['Type']) && $_POST['Type'] == 'App') || $apiCancel) {

                            $MessageCancel['Status'] = 'error';
                            $MessageCancel['Message'] = 'خطای غیر منتظره لطفا با پشتیبانی تماس بگیرید';

                            return json_encode($MessageCancel);
                        } else {
                            if ($exitOption) {
                                return;
                            } else {
                                echo 'error : خطای غیر منتظره لطفا با پشتیبانی تماس بگیرید';
                                exit();
                            }
                        }
                    }
                }
                else {
                    if ((isset($_POST['Type']) && $_POST['Type'] == 'App') || $apiCancel) {
                        $MessageCancel['Status'] = 'error';
                        $MessageCancel['Message'] = 'تعدادباقی مانده بزرگسال نمیتواند کمتر از تعداد کودک و نوزاد باشد';

                        return json_encode($MessageCancel);
                    } else {
                        if ($exitOption) {
                            return;
                        } else {
                            echo 'error : تعدادباقی مانده بزرگسال نمیتواند کمتر از تعداد کودک و نوزاد باشد';
                            exit();
                        }
                    }
                }
            } else {
                if ((isset($_POST['Type']) && $_POST['Type'] == 'App') || $apiCancel) {
                    $MessageCancel['Status'] = 'error';
                    $MessageCancel['Message'] = 'اطلاعات ارسالی برای کنسلی صحیح نمی باشد،لطفا با پشتیبانی تماس بگیرید';

                    return json_encode($MessageCancel);
                } else {
                    if ($exitOption) {
                        return;
                    } else {
                        echo 'error : اطلاعات ارسالی برای کنسلی صحیح نمی باشد،لطفا با پشتیبانی تماس بگیرید';
                        exit();
                    }
                }
            }
//        }

	}

	public function ShowInfoModalTicketCancel($RequestNumber, $ClientId, $IdDetail) {

	    $sql = "SELECT TCancel.*, " . " book.passenger_name, " . " book.passenger_family, " . " book.passenger_age, " . " book.passenger_national_code, " . " book.passportNumber, " . " book.passenger_birthday_en, " . " book.passenger_birthday, " . " book.factor_number, " . " book.member_id , " . " Cancel.* " . " FROM cancel_ticket_tb AS TCancel " . " LEFT JOIN cancel_ticket_details_tb AS Cancel ON Cancel.id = TCancel.IdDetail " . " LEFT JOIN book_local_tb AS book ON book.request_number = Cancel.RequestNumber AND ((TCancel.NationalCode =book.passenger_national_code) OR (TCancel.NationalCode =book.passportNumber)) " . " WHERE Cancel.RequestNumber='{$RequestNumber}' AND TCancel.IdDetail='{$IdDetail}' " . " GROUP BY TCancel.NationalCode ";

		$InfoCancel = $this->admin->ConectDbClient($sql, $ClientId, "SelectAll", "", "", "");

		return $InfoCancel;
	}

	/*
	 * @param $Param
	 */

	public function SendPercentForAgency($Param) {

		$sql = " SELECT * FROM cancel_ticket_details_tb WHERE id='{$Param['id']}'AND RequestNumber='{$Param['RequestNumber']}' ";

		$InfoCancel = $this->admin->ConectDbClient($sql, $Param['ClientId'], "Select", "", "", "");



		if (!empty($InfoCancel)) {
			$data['PercentIndemnity'] = $Param['PercentIndemnity'];
			$data['DescriptionAdmin'] = $Param['DescriptionAdmin'];
			$data['Status'] = 'SetIndemnity';
			$data['DateSetIndemnityInt'] = time();

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




                    $sms = " همکار گرامی درصد جریمه کنسلی {$cancel_type} به شماره درخواست ";
                    $sms .= $Param['RequestNumber'];
                    $sms .= PHP_EOL;
                    $sms .=" به میزان  ";
                    $sms .= $Param['PercentIndemnity'];
                    $sms .= " درصد تعیین شده است. خواهشمند است با توجه به احتمال افزایش درصد جریمه اعلامی ، در اسرع وقت جهت تایید یا عدم تایید جریمه مذکور از طریق لینک زیر اقدام فرمایید  ";
                    $sms .= PHP_EOL;
                    $sms .="http://{$client_info['Domain']}/gds/itadmin/ticket/userTicketCancellationHistory";

                    $cellArray = array(
                        'manager' => $client_info['Mobile'],
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
	}

	/*
	 * @param $Param
	 */

	public function SendPriceForCalculate($Param) {
        $Param['PriceIndemnity'] = str_replace(',', '', $Param['PriceIndemnity']);

		/** @var smsServices $smsController */
		$smsController = Load::controller('smsServices');
        Load::autoload('Model');
        $Model = new Model();
		$sql = " SELECT * FROM cancel_ticket_details_tb WHERE id='{$Param['id']}'AND RequestNumber='{$Param['RequestNumber']}' ";
		$InfoCancel = $this->admin->ConectDbClient($sql, $Param['ClientId'], "Select", "", "", "");
		$typeFightCancel = ($InfoCancel['TypeCancel'] == 'flight' || $InfoCancel['TypeCancel'] == '');


        if (!empty($InfoCancel)) {
            $data['PriceIndemnity'] = $Param['PriceIndemnity'];

            if($InfoCancel['TypeCancel']=='bus'){
                $apiBus=Load::library('apiBus');

                $reserveInfo= functions::GetInfoBus( $InfoCancel['FactorNumber'] );

                // we only able to refund Altraboo reserves
                if($reserveInfo['SourceCode'] != 'reservation_bus' && $reserveInfo['SourceCode'] != '10'){

                    $busRefundCheck=$apiBus->busRefundCheck($InfoCancel['FactorNumber'],$Param['ClientId']);

                    $busRefund=$apiBus->busRefund($InfoCancel['FactorNumber'],$Param['ClientId']);

                    if(!$busRefund['response']['SuccessfulStatus']['client'] || !$busRefund['response']['SuccessfulStatus']['provider']){
                        return 'error : خطا در کنسل کردن از سمت پروایدر';
                    }
                }




//                $dateMove = strtotime($reserveInfo['DateMove']);
//                $timeMove = strtotime($reserveInfo['TimeMove']);
//                $currentDate = strtotime(date('Y-m-d'));
//                $currentTime = time();
//
//                $dateDiff = $currentDate - $dateMove;
//                $timeDiff = $currentTime - $timeMove;

//                if ($dateDiff == 0 && $timeDiff < 3600) {
//                    //todo server time is wrong.
//                    if($busRefundCheck['data']['totalRefundableAmount'] == '0'){
//                        $busRefundCheck['data']['totalRefundableAmount']=10;
//                    }
//                }

                if($busRefundCheck['data']['totalRefundableAmount'] == '0'){
                    $busRefundCheck['data']['totalRefundableAmount']=10;
                }

//                $data['PriceIndemnity'] = $busRefundCheck['data']['totalRefundableAmount'];
            }

			$data['Status'] = 'ConfirmCancel';
			$data['DateConfirmCancelInt'] = time();

			$Condition = "id={$Param['id']} AND RequestNumber='{$Param['RequestNumber']}'";

			$result = $this->admin->ConectDbClient('', $Param['ClientId'], "Update", $data, "cancel_ticket_details_tb", $Condition);



			if (!empty($result)) {
				$InfoBook = $d = [];
				$titleType = '';
				if ($typeFightCancel) {
					list($InfoBook, $d) = $this->getInfoFlightForCancel($Param);
				}
                elseif ($InfoCancel['TypeCancel'] == 'train') {
					$InfoBook['factor_number'] = $InfoCancel['FactorNumber'];
					$d['Price'] = '0';
					$titleType = 'قطار';
				}
                elseif ($InfoCancel['TypeCancel'] == 'bus') {
                    $d['Price']=$Param['PriceIndemnity'];
                    if($reserveInfo['SourceCode'] == 'reservation_bus' ){
                        $d['Price']=0;
                    }
                    $InfoBook['factor_number'] = $InfoCancel['FactorNumber'];
                }
                elseif ($InfoCancel['TypeCancel'] == 'hotel') {
                    $d['Price']=$Param['PriceIndemnity'];
                    $InfoBook['factor_number'] = $InfoCancel['FactorNumber'];
                }
                elseif ($InfoCancel['TypeCancel'] == 'insurance') {
                    $d['Price']=$Param['PriceIndemnity'];
                    $InfoBook['factor_number'] = $InfoCancel['FactorNumber'];
                }

				$dataCancelTransaction['Comment'] = 'بند برگشت استرداد بلیط ' . $Param['RequestNumber'] . '' . $titleType;
				$dataCancelTransaction['Status'] = '1';
				$dataCancelTransaction['Reason'] = 'indemnity_cancel';
				$dataCancelTransaction['FactorNumber'] = $InfoBook['factor_number'];
				$dataCancelTransaction['price'] = $d['Price'];
				$dataCancelTransaction['PaymentStatus'] = 'success';
				$dataCancelTransaction['CreationDateInt'] = time();
				$dataCancelTransaction['PriceDate'] = date("Y-m-d H:i:s");


				$insert_transaction = $this->admin->ConectDbClient('', $Param['ClientId'], "Insert", $dataCancelTransaction, "transaction_tb", "");

                //for admin panel and transactions table
                $dataCancelTransaction['clientID'] = $Param['ClientId'];
                $this->transactions->insertTransaction($dataCancelTransaction);

                $member_query = " SELECT * FROM  members_tb  WHERE id='{$InfoCancel['MemberId']}'";
                $res_member = $Model->load( $member_query );


                if ($insert_transaction && $res_member['fk_counter_type_id']==2) {

                    $dataCreditCounter['fk_agency_id'] = $res_member['fk_agency_id'];
                    $dataCreditCounter['credit'] = $Param['PriceIndemnity'];
                    $dataCreditCounter['type'] = 'increase';
                    $dataCreditCounter['PaymentStatus'] = 'success';
                    $dataCreditCounter['comment'] = " استرداد خرید به شماره رزرو{$InfoCancel['FactorNumber']}";
                    $dataCreditCounter['member_id'] = $InfoCancel['MemberId'];
                    $dataCreditCounter['reason'] = 'Refund';
                    $dataCreditCounter['requestNumber'] = $InfoCancel['FactorNumber'];
                    $dataCreditCounter['creation_date_int'] = time();
                    $dataCreditCounter['credit_date'] = dateTimeSetting::jdate('Y-m-d',time());
                    $dataCreditCounter['factorNumber'] = $InfoCancel['FactorNumber'];
                    $insert_credit_counter = $this->admin->ConectDbClient('', $Param['ClientId'], "Insert", $dataCreditCounter, "credit_detail_tb", '');

                    if ($insert_credit_counter) {
                        $dataCancel['Status']="ConfirmCancel";
                        $dataCancel['DateConfirmClientInt']=time();
                        $dataCancel['confirmTransferWallet']='ReturnWalletCounter';

                        $Model->setTable('cancel_ticket_details_tb');

                        $Condition="id={$InfoCancel['id']} AND RequestNumber='{$InfoCancel['FactorNumber']}'";
                        $Model->update($dataCancel, $Condition);
                        echo 'Success : انتقال اعتبار به حساب کاربر انجام شد';
                    }
                }



				$sql = "SELECT * FROM cancel_ticket_tb WHERE IdDetail='{$Param['id']}'";
				$InfoCancelNationalCodes = $this->admin->ConectDbClient($sql, $Param['ClientId'], "SelectAll", "", "", "");

                $PriceIndemnityResult = false;

				foreach ($InfoCancelNationalCodes as $key => $NationalCode) {
					$book = [];
					if ($typeFightCancel) {
						$book['request_cancel'] = 'confirm';
						$Condition = "request_number='{$Param['RequestNumber']}' AND passenger_national_code='{$NationalCode['NationalCode']}'";
						$this->admin->ConectDbClient('', $Param['ClientId'], "Update", $book, "book_local_tb", $Condition);
						$this->ModelBase->setTable('report_tb');
					} elseif ($InfoCancel['TypeCancel'] == 'train') {
						$book['request_cancel'] = 'confirm';
						$Condition = "requestNumber='{$Param['RequestNumber']}' AND passenger_national_code='{$NationalCode['NationalCode']}'";

						$this->admin->ConectDbClient('', $Param['ClientId'], "Update", $book, "book_train_tb", $Condition);
						$this->ModelBase->setTable('report_train_tb');
					}elseif ($InfoCancel['TypeCancel'] == 'bus') {
                        $book['request_cancel'] = 'confirm';
                        $Condition = "order_code='{$Param['RequestNumber']}' AND passenger_national_code='{$NationalCode['NationalCode']}'";

                        $this->admin->ConectDbClient('', $Param['ClientId'], "Update", $book, "book_bus_tb", $Condition);
                        $this->ModelBase->setTable('report_bus_tb');
                    }
                    elseif ($InfoCancel['TypeCancel'] == 'hotel') {
                        $book['request_cancel'] = 'confirm';
                        $Condition = "factor_number='{$Param['RequestNumber']}' AND passenger_national_code='{$NationalCode['NationalCode']}'";

                        $this->admin->ConectDbClient('', $Param['ClientId'], "Update", $book, "book_hotel_local_tb", $Condition);
                        $this->ModelBase->setTable('report_hotel_tb');
                    }
                    elseif ($InfoCancel['TypeCancel'] == 'insurance') {

                        $book['request_cancel'] = 'confirm';
                        $Condition = "factor_number='{$Param['RequestNumber']}' AND passenger_national_code='{$NationalCode['NationalCode']}'";

                        $this->admin->ConectDbClient('', $Param['ClientId'], "Update", $book, "book_insurance_tb", $Condition);
                        $this->ModelBase->setTable('report_insurance_tb');
                    }

					$PriceIndemnityResult = $this->ModelBase->update($book, $Condition);

				}

                if($PriceIndemnityResult && $InfoCancel['isCreditPayment']=='1' && $typeFightCancel){

                    $dataCreditDetail['fk_agency_id'] = $InfoBook['agency_id'];
                    $dataCreditDetail['credit'] = $Param['PriceIndemnity'];
                    $dataCreditDetail['type'] = 'increase';
                    $dataCreditDetail['comment'] = "استرداد خرید به شماره رزرو{$InfoBook['request_number']}";
                    $dataCreditDetail['member_id'] = $InfoBook['member_id'];
                    $dataCreditDetail['reason'] = 'Refund';
                    $dataCreditDetail['requestNumber'] = $InfoBook['request_number'];
                    $dataCreditDetail['creation_date_int'] = time();
                    $dataCreditDetail['credit_date'] = dateTimeSetting::jdate('Y-m-d',time());
                    $dataCreditDetail['factorNumber'] = $InfoBook['factor_number'];

                    $this->admin->ConectDbClient('', $Param['ClientId'], "Insert", $dataCreditDetail, "credit_detail_tb", '');

                }

				//sms to buyer
				$objSms = $smsController->initService('0', $Param['ClientId']);
				if ($objSms) {
					$Client = functions::infoClient($Param['ClientId']);

					//to member
					$messageVariables = array('sms_name'             => $InfoBook['member_name'],
					                          'sms_service'          => 'بلیط',
					                          'sms_factor_number'    => $InfoBook['request_number'],
					                          'sms_airline'          => $InfoBook['airline_name'],
					                          'sms_origin'           => $InfoBook['origin_city'],
					                          'sms_destination'      => $InfoBook['desti_city'],
					                          'sms_flight_number'    => $InfoBook['flight_number'],
					                          'sms_flight_date'      => dateTimeSetting::jdate("Y-F-d", functions::ConvertToDateJalaliInt($InfoBook['date_flight'])),
					                          'sms_flight_time'      => $InfoBook['time_flight'],
					                          'sms_flight_indemnity' => $InfoCancel['PercentIndemnity'],
					                          'sms_agency'           => $Client['AgencyName'],
					                          'sms_agency_mobile'    => $Client['Mobile'],
					                          'sms_agency_phone'     => $Client['Phone'],
					                          'sms_agency_email'     => $Client['Email'],
					                          'sms_agency_address'   => $Client['Address'],);
					$smsArray = array('smsMessage'      => $smsController->getUsableMessage('cancelConfirmTicket', $messageVariables),
					                  'cellNumber'      => $InfoBook['member_mobile'],
					                  'smsMessageTitle' => 'cancelConfirmTicket',
					                  'memberID'        => (!empty($InfoBook['member_id']) ? $InfoBook['member_id'] : ''),
					                  'receiverName'    => $messageVariables['sms_name'],);
					$smsController->sendSMS($smsArray);
                    functions::insertLog('5=>','testTimeCancel');
					//to first passenger
					$messageVariables['sms_name'] = $InfoBook['passenger_name'] . ' ' . $InfoBook['passenger_family'];
					$smsArray = array('smsMessage'      => $smsController->getUsableMessage('cancelConfirmTicket', $messageVariables),
					                  'cellNumber'      => $InfoBook['mobile_buyer'],
					                  'smsMessageTitle' => 'cancelConfirmTicket',
					                  'memberID'        => (!empty($InfoBook['member_id']) ? $InfoBook['member_id'] : ''),
					                  'receiverName'    => $messageVariables['sms_name'],);
					$smsController->sendSMS($smsArray);
                    functions::insertLog('6=>','testTimeCancel');
				}

				return 'success : مبلغ تعیین شده با موفقیت ثبت شد';
			} else {
				return 'error : خطا در ثبت مبلغ ،لطفا مجددا تلاش نمائید';
			}
		} else {
			return 'error : در خواست  نا معتبر است';
		}
	}

	public function CancelRTRD() {
        $date = dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode = explode('-', $date);
        $date_now_int_start = dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date_now_int_end = dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);

        if(TYPE_ADMIN == '1')
        {
            $sql = " SELECT * FROM clients_tb WHERE id > '1'";

            if (!empty($_POST['client_id'])) {
                if ($_POST['client_id'] != "all") {
                    $sql .= " AND id ='{$_POST['client_id']}'";
                }
            }
            $res = $this->ModelBase->select($sql);

          $ListCancelRTRD = [];
            foreach ($res as $result) {
                $sql = "SELECT
                            Book.*,
                            CancelDetail.PercentIndemnity AS PercentIndemnity,
                            CancelDetail.PriceIndemnity AS PriceIndemnity,
                            CancelDetail.DateConfirmCancelInt AS CancelConfirmDate,
                            Count(Cancel.IdDetail) AS CountIdDetail
                        FROM
                            book_local_tb AS Book
                        INNER JOIN cancel_ticket_details_tb AS CancelDetail ON CancelDetail.RequestNumber = Book.request_number
                        INNER JOIN cancel_ticket_tb AS Cancel ON Cancel.IdDetail = CancelDetail.id
                        WHERE
                            CancelDetail. Status <> 'RequestMember'
                            AND CancelDetail.Status <> 'nothing'
                        ";

                if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {

                    $date_of = explode('-', $_POST['date_of']);
                    $date_to = explode('-', $_POST['to_date']);
                    $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                    $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
                    $sql .= " AND Book.creation_date_int >= '{$date_of_int}' AND Book.creation_date_int  <= '{$date_to_int}'";
                } else {
                    $sql .= "AND Book.creation_date_int >= '{$date_now_int_start}' AND Book.creation_date_int  <= '{$date_now_int_end}'";
                }
                if (!empty($_POST['flight_type'])) {
                    if ($_POST['flight_type'] == 'charterSourceFour') {
                        $sql .= " AND Book.flight_type ='charter' AND Book.api_id='5'";
                    } else if ($_POST['flight_type'] == 'charterSourceSeven') {
                        $sql .= " AND Book.flight_type ='charter' AND Book.api_id='8'";
                    } else if ($_POST['flight_type'] == 'SystemSourceFour') {
                        $sql .= " AND Book.flight_type ='system' AND Book.api_id='5'";
                    } else if ($_POST['flight_type'] == 'SystemSourceFive') {
                        $sql .= " AND Book.flight_type ='system' AND Book.api_id='1'";
                    } else if ($_POST['flight_type'] == 'SystemSourceTen') {
                        $sql .= " AND Book.flight_type ='system' AND Book.api_id='11'";
                    } else if ($_POST['flight_type'] == 'SystemSourceForeignNine') {
                        $sql .= " AND Book.flight_type ='system' AND Book.api_id='10' AND Book.IsInternal='0'";
                    }
                }

                if (!empty($_POST['StatusConfirm'])) {
                    if ($_POST['StatusConfirm'] == 'Confirm') {
                        $sql .= " AND Book.request_cancel='confirm'";
                    } elseif ($_POST['StatusConfirm'] == 'NotVerified') {
                        $sql .= " AND Book.request_cancel <> 'confirm'";
                    }
                }


                $sql .= " GROUP BY Book.eticket_number 
                        ORDER BY  Book.eticket_number ASC  ,Book.creation_date_int   DESC";
                $CancelClient = $this->admin->ConectDbClient($sql, $result['id'], "SelectAll", "", "", "");

                foreach ($CancelClient as $key => $CancelRequest) {
                    $CancelRequest['AgencyName'] = $result['AgencyName'];
                    $CancelRequest['ClientId'] = $result['id'];
                    $ListCancelRTRD[] = $CancelRequest;
                }
            }
            $Cancel = array();
            foreach ($ListCancelRTRD as $key => $row) {
                $Cancel['creation_date_int'][$key] = $row['creation_date_int'];
            }

            array_multisort($Cancel['creation_date_int'], SORT_DESC, $ListCancelRTRD);

        }else{
	        $Model = Load::library('Model');
            $sql = "SELECT
                            Book.*,
                            CancelDetail.PercentIndemnity AS PercentIndemnity,
                            CancelDetail.PriceIndemnity AS PriceIndemnity,
                            CancelDetail.DateConfirmCancelInt AS CancelConfirmDate,
                            Count(Cancel.IdDetail) AS CountIdDetail
                        FROM
                            book_local_tb AS Book
                        INNER JOIN cancel_ticket_details_tb AS CancelDetail ON CancelDetail.RequestNumber = Book.request_number
                        INNER JOIN cancel_ticket_tb AS Cancel ON Cancel.IdDetail = CancelDetail.id
                        WHERE
                            CancelDetail. Status <> 'RequestMember'
                            AND CancelDetail.Status <> 'nothing'
                        ";

            if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {

                $date_of = explode('-', $_POST['date_of']);
                $date_to = explode('-', $_POST['to_date']);
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
                $sql .= " AND Book.creation_date_int >= '{$date_of_int}' AND Book.creation_date_int  <= '{$date_to_int}'";
            } else {
                $sql .= "AND Book.creation_date_int >= '{$date_now_int_start}' AND Book.creation_date_int  <= '{$date_now_int_end}'";
            }
            if (!empty($_POST['flight_type'])) {
                if ($_POST['flight_type'] == 'charterSourceFour') {
                    $sql .= " AND Book.flight_type ='charter' AND Book.api_id='5'";
                } else if ($_POST['flight_type'] == 'charterSourceSeven') {
                    $sql .= " AND Book.flight_type ='charter' AND Book.api_id='8'";
                } else if ($_POST['flight_type'] == 'SystemSourceFour') {
                    $sql .= " AND Book.flight_type ='system' AND Book.api_id='5'";
                } else if ($_POST['flight_type'] == 'SystemSourceFive') {
                    $sql .= " AND Book.flight_type ='system' AND Book.api_id='1'";
                } else if ($_POST['flight_type'] == 'SystemSourceTen') {
                    $sql .= " AND Book.flight_type ='system' AND Book.api_id='11'";
                } else if ($_POST['flight_type'] == 'SystemSourceForeignNine') {
                    $sql .= " AND Book.flight_type ='system' AND Book.api_id='10' AND Book.IsInternal='0'";
                }
            }

            if (!empty($_POST['StatusConfirm'])) {
                if ($_POST['StatusConfirm'] == 'Confirm') {
                    $sql .= " AND Book.request_cancel='confirm'";
                } elseif ($_POST['StatusConfirm'] == 'NotVerified') {
                    $sql .= " AND Book.request_cancel <> 'confirm'";
                }
            }


            $sql .= " GROUP BY Book.eticket_number 
                        ORDER BY  Book.eticket_number ASC  ,Book.creation_date_int   DESC";

            $ListCancelRTRD = $Model->select($sql);

            $Cancel = array();
            foreach ($ListCancelRTRD as $key => $row) {
                $Cancel['creation_date_int'][$key] = $row['creation_date_int'];
            }

            array_multisort($Cancel['creation_date_int'], SORT_DESC, $ListCancelRTRD);

        }


		return $ListCancelRTRD;
	}

	public function InfoCancelTicket($RequestNumber, $IdCancel, $ClientId) {


		$SqlCancel = "SELECT * FROM cancel_ticket_details_tb WHERE id='{$IdCancel}'";
		$InfoCancel = $this->admin->ConectDbClient($SqlCancel, $ClientId, "Select", "", "", "");

		if ($InfoCancel['TypeCancel'] == 'flight' || $InfoCancel['TypeCancel'] == '') {
			$Sql = "SELECT 
             book.* , Cancel.PercentIndemnity as PercentIndemnity,
             Cancel.TypeCancel AS TypeCancel
             FROM cancel_ticket_tb AS TCancel 
             LEFT JOIN cancel_ticket_details_tb AS Cancel ON Cancel.id = TCancel.IdDetail 
             LEFT JOIN book_local_tb AS book ON book.request_number = Cancel.RequestNumber AND ((TCancel.NationalCode =book.passenger_national_code) OR (TCancel.NationalCode =book.passportNumber)) 
            WHERE book.request_number='{$RequestNumber}' AND TCancel.IdDetail='{$IdCancel}' 
             GROUP BY TCancel.NationalCode";

			return $this->admin->ConectDbClient($Sql, $ClientId, "SelectAll", "", "", "");
		}elseif ($InfoCancel['TypeCancel'] == 'bus'){
            $Sql = "SELECT 
             book.* , Cancel.PercentIndemnity as PercentIndemnity,
             Cancel.TypeCancel AS TypeCancel
             FROM cancel_ticket_tb AS TCancel 
             LEFT JOIN cancel_ticket_details_tb AS Cancel ON Cancel.id = TCancel.IdDetail 
             LEFT JOIN book_bus_tb AS book ON book.order_code = Cancel.RequestNumber AND ((TCancel.NationalCode =book.passenger_national_code) OR (TCancel.NationalCode =book.passportNumber)) 
            WHERE book.order_code='{$RequestNumber}' AND TCancel.IdDetail='{$IdCancel}' 
             GROUP BY TCancel.NationalCode";

            return $this->admin->ConectDbClient($Sql, $ClientId, "SelectAll", "", "", "");
        }elseif ($InfoCancel['TypeCancel'] == 'hotel'){
            $Sql = "SELECT 
             book.* , Cancel.PercentIndemnity as PercentIndemnity,
             Cancel.TypeCancel AS TypeCancel
             FROM cancel_ticket_tb AS TCancel 
             LEFT JOIN cancel_ticket_details_tb AS Cancel ON Cancel.id = TCancel.IdDetail 
             LEFT JOIN book_hotel_local_tb AS book ON book.factor_number = Cancel.RequestNumber AND ((TCancel.NationalCode =book.passenger_national_code) OR (TCancel.NationalCode =book.passportNumber)) 
            WHERE book.factor_number='{$RequestNumber}' AND TCancel.IdDetail='{$IdCancel}' 
             GROUP BY TCancel.NationalCode";

            return $this->admin->ConectDbClient($Sql, $ClientId, "SelectAll", "", "", "");
        }elseif ($InfoCancel['TypeCancel'] == 'insurance'){
            $Sql = "SELECT 
             book.* , Cancel.PercentIndemnity as PercentIndemnity,
             Cancel.TypeCancel AS TypeCancel
             FROM cancel_ticket_tb AS TCancel 
             LEFT JOIN cancel_ticket_details_tb AS Cancel ON Cancel.id = TCancel.IdDetail 
             LEFT JOIN book_insurance_tb AS book ON book.factor_number = Cancel.RequestNumber AND ((TCancel.NationalCode =book.passenger_national_code) OR (TCancel.NationalCode =book.passport_number)) 
            WHERE book.factor_number='{$RequestNumber}' AND TCancel.IdDetail='{$IdCancel}' 
             GROUP BY TCancel.NationalCode";

            return $this->admin->ConectDbClient($Sql, $ClientId, "SelectAll", "", "", "");
        }




        return $InfoCancel;
	}


	public function setTicketClose($param) {

		$sql = " SELECT * FROM cancel_ticket_details_tb WHERE id='{$param['id']}' ";
		$infoCancel = $this->admin->ConectDbClient($sql, $param['clientId'], "Select", "", "", "");
		if (!empty($infoCancel)) {

			$data['DescriptionAdmin'] = $param['descriptionClose'];
			$data['Status'] = 'close';
			$data['DateSetIndemnityInt'] = time();
			$data['DateConfirmCancelInt'] = time();

			$Condition = "id={$param['id']}";

			$result = $this->admin->ConectDbClient('', $param['clientId'], "Update", $data, "cancel_ticket_details_tb", $Condition);
			if ($result) {
				return 'success : درخواست شما با موفقیت ثبت شد';
			} else {
				return 'error : خطا در ثبت درخواست شما، لطفا مجددا تلاش نمائید';
			}

		} else {
			return 'error : در خواست  نا معتبر است';
		}
	}

	#region changePercentIndemnity
	public function changePercentIndemnity($param) {

		$sql = " SELECT * FROM cancel_ticket_details_tb WHERE id='{$param['id']}' ";
		$infoCancel = $this->admin->ConectDbClient($sql, $param['clientId'], "Select", "", "", "");
		if (!empty($infoCancel)) {

			$data['PercentIndemnity'] = $param['changePercentIndemnity'];

			$Condition = "id='{$param['id']}'";

			$result = $this->admin->ConectDbClient('', $param['clientId'], "Update", $data, "cancel_ticket_details_tb", $Condition);
			if ($result) {
				return 'success : درخواست شما با موفقیت ثبت شد';
			} else {
				return 'error : خطا در ثبت درخواست شما، لطفا مجددا تلاش نمائید';
			}

		} else {
			return 'error : در خواست  نا معتبر است';
		}
	}
	#endregion

	/**
	 * @param      $params
	 * @param null $apiCancel
	 * @return mixed
	 */
	protected function getFlightForCancel($params, $apiCancel = null) {

		$sql = " SELECT *,  "
            . " (Select COUNT(passenger_age) FROM book_local_tb WHERE passenger_age='Adt' AND request_number='{$params['RequestNumber']}' AND request_cancel <> 'confirm') AS Adt_passenger ,"
            . " (Select COUNT(passenger_age) FROM book_local_tb WHERE passenger_age='Chd' AND request_number='{$params['RequestNumber']}' AND request_cancel <> 'confirm') AS Chd_passenger ,"
            . " (Select COUNT(passenger_age) FROM book_local_tb WHERE passenger_age='Inf' AND request_number='{$params['RequestNumber']}' AND request_cancel <> 'confirm') AS Inf_passenger "
            . " FROM book_local_tb WHERE request_number='{$params['RequestNumber']}' AND successfull='book' AND request_cancel <> 'confirm' ";

		if ($apiCancel) {
			return $this->admin->ConectDbClient($sql, $params['clientId'], 'Select', '', '', '');
		}

		return $this->Model->load($sql);
	}

	/**
	 * @param      $params
	 * @return mixed
	 * @internal param null $apiCancel
	 */
	protected function getTrainForCancel($params) {

		$sql = " SELECT *,  " . " (Select COUNT(passenger_age) FROM book_train_tb WHERE passenger_age='Adt' AND requestNumber='{$params['RequestNumber']}' AND request_cancel <> 'confirm') AS Adt_passenger ," . " (Select COUNT(passenger_age) FROM book_train_tb WHERE passenger_age='Chd' AND requestNumber='{$params['RequestNumber']}' AND request_cancel <> 'confirm') AS Chd_passenger ," . " (Select COUNT(passenger_age) FROM book_train_tb WHERE passenger_age='Inf' AND requestNumber='{$params['RequestNumber']}' AND request_cancel <> 'confirm') AS Inf_passenger " . " FROM book_train_tb WHERE requestNumber='{$params['RequestNumber']}' AND successfull='book' AND request_cancel <> 'confirm' ";


		return $this->Model->load($sql);
	}

    protected function getBusForCancel($params) {
	    $sql = " SELECT *,  " . "
	1 AS Adt_passenger,
	0 AS Chd_passenger,
	0 AS Inf_passenger " . " FROM book_bus_tb WHERE order_code='{$params['RequestNumber']}' AND status='book' AND request_cancel <> 'confirm' ";


        return $this->Model->load($sql);
    }
    protected function getHotelForCancel($params) {

	    $sql = " SELECT *,  " . "
	1 AS Adt_passenger,
	0 AS Chd_passenger,
	0 AS Inf_passenger " . " FROM book_hotel_local_tb WHERE factor_number='{$params['RequestNumber']}' AND status='BookedSuccessfully' AND request_cancel <> 'confirm' ";

        return $this->Model->load($sql);
    }
    protected function getInsuranceForCancel($params) {

	    $sql = " SELECT *,  "
            . " (Select COUNT(passenger_age) FROM book_insurance_tb WHERE passenger_age='Adt' AND factor_number='{$params['RequestNumber']}' AND request_cancel <> 'confirm') AS Adt_passenger ,"
            . " (Select COUNT(passenger_age) FROM book_insurance_tb WHERE passenger_age='Chd' AND factor_number='{$params['RequestNumber']}' AND request_cancel <> 'confirm') AS Chd_passenger ,"
            . " (Select COUNT(passenger_age) FROM book_insurance_tb WHERE passenger_age='Inf' AND factor_number='{$params['RequestNumber']}' AND request_cancel <> 'confirm') AS Inf_passenger "
            . " FROM book_insurance_tb WHERE factor_number='{$params['RequestNumber']}' AND status='book' AND request_cancel <> 'confirm' ";


        return $this->Model->load($sql);
    }




	/**
	 * @param $NationalCodesWithAge
	 * @return array[]
	 * @internal param array $Type
	 * @internal param array $Age
	 * @internal param array $NationalCodes
	 */
	public function getNationalCodesRequest($NationalCodesWithAge) {
		$Type = array();
		$Age = array();
		$NationalCodes = array();
		foreach ($NationalCodesWithAge as $i => $rec) {
             
			$Type[] = explode('-', $rec);
			$Age[] = $Type[$i][1];
			$NationalCodes[] = $Type[$i][0];
		}

		return array($Age, $NationalCodes);
	}

	/**
	 * @param      $params
	 * @param bool $apiCancel
	 * @return array
	 */
	public function insertInfoCancel($params, $apiCancel = false) {

		$data['PercentIndemnity'] =0;
		$data['PriceIndemnity'] =0;
		$data['DateSetCancelInt'] = 0;
		$data['DateRequestCancelClientInt'] = 0;
		$data['DateSetIndemnityInt'] = 0;
		$data['DateSetFailedIndemnityInt'] = 0;
		$data['DateConfirmClientInt'] = 0;
		$data['DateConfirmCancelInt'] = 0;
		$data['MemberId'] = $params['MemberId'];
		$data['TypeCancel'] = $params['typeService'];
		$data['backCredit'] = $params['backCredit'];
		$data['FactorNumber'] = $params['FactorNumber'];
		$data['RequestNumber'] = $params['RequestNumber'];
		$data['ReasonMember'] = $params['Reasons'];
		$data['AccountOwner'] = isset($params['AccountOwner']) ? $params['AccountOwner'] : '';
		$data['CardNumber'] = isset($params['CardNumber']) ? $params['CardNumber'] : '';
		$data['NameBank'] = isset($params['NameBank']) ? $params['NameBank'] : '';
		$data['PercentNoMatter'] = isset($params['PercentNoMatter']) ? $params['PercentNoMatter'] : '';

//        var_dump($data);
//        die;
		if ($apiCancel || ((isset($params['admin']) && $params['admin'] == 'yes' && $params['flightType'] == 'system'))) {
			if ($params['flightType'] == 'system') {
				$CalculateIndemnity = $this->getIndemnityCancel($params['RequestNumber']);
				if (is_numeric($CalculateIndemnity)) {
					$data['PercentIndemnity'] = $CalculateIndemnity;
					$data['Status'] = 'ConfirmClient';
					$data['DateConfirmClientInt'] = time();
				}else{
                    $data['Status'] = 'RequestClient';
                }
			} else {
				$data['Status'] = 'RequestClient';
			}
			$data['DateRequestCancelClientInt'] = time();
		} else {
			$data['Status'] = 'RequestMember';
		}

		$data['DateRequestMemberInt'] = time();

		if (!$apiCancel) {


			$this->Model->setTable('cancel_ticket_details_tb');
			$result = $this->Model->insertLocal($data);

			$id = $this->Model->getLastId();

		} else {

			$result = $this->admin->ConectDbClient('', $params['clientId'], "Insert", $data, "cancel_ticket_details_tb", "");
			$sql = "SELECT * FROM cancel_ticket_details_tb ORDER BY id DESC LIMIT 1";
			$lastId = $this->admin->ConectDbClient($sql, $params['clientId'], 'Select', '', '', '');
			$id = $lastId['id'];
		}

		return array($result, $id);
	}

	/**
	 * @param array $NationalCodes
	 * @param array $params
	 * @param       $apiCancel
	 * @return bool|mixed
	 */
	public function insertNationalCodeCancel(array $NationalCodes, array $params, $apiCancel) {
		$d = array();
		$result = false;
		foreach ($NationalCodes as $code) {

			$d['IdDetail'] = $params['idDetailCancel'];
			$d['NationalCode'] = $code;

			if (!$apiCancel) {
				$this->Model->setTable('cancel_ticket_tb');
				$result = $this->Model->insertLocal($d);
			} else {
				$result = $this->admin->ConectDbClient('', $params['clientId'], "Insert", $d, "cancel_ticket_tb", "");
			}

		}

		return $result;
	}

	/**
	 * @param array $Age
	 * @return int[]
	 */
	public function getCountAge(array $Age) {
		$adt = 0;
		$chd = 0;
		$inf = 0;
		foreach ($Age as $a) {
			switch ($a) {
			case 'Adt':
				$adt++;
				break;
			case 'Chd':
				$chd++;
				break;
			case 'Inf':
				$inf++;
				break;
			}
		}

		return array($adt, $chd, $inf);
	}

	/**
	 * @param smsServices $smsController
	 * @param array       $BookResult
	 */
	protected function sendSmsCancel($smsController, $BookResult) {
		$objSms = $smsController->initService('0');
		if ($objSms) {
			$messageVariables = array('sms_name'          => $BookResult['member_name'], 'sms_service' => 'بلیط',
			                          'sms_factor_number' => $BookResult['request_number'],
			                          'sms_airline'       => $BookResult['airline_name'],
			                          'sms_origin'        => $BookResult['origin_city'],
			                          'sms_destination'   => $BookResult['desti_city'],
			                          'sms_flight_number' => $BookResult['flight_number'],
			                          'sms_flight_date'   => functions::DateJalali($BookResult['date_flight']),
			                          'sms_flight_time'   => $BookResult['time_flight'], 'sms_agency' => CLIENT_NAME,
			                          'sms_agency_mobile' => CLIENT_MOBILE, 'sms_agency_phone' => CLIENT_PHONE,
			                          'sms_agency_email'  => CLIENT_EMAIL, 'sms_agency_address' => CLIENT_ADDRESS,);
			$smsArray = array('smsMessage'   => $smsController->getUsableMessage('cancelRequestTicketToManager', $messageVariables),
			                  'cellNumber'   => CLIENT_MOBILE, 'smsMessageTitle' => 'cancelRequestTicketToManager',
			                  'memberID'     => (!empty($BookResult['member_id']) ? $BookResult['member_id'] : ''),
			                  'receiverName' => $messageVariables['sms_name'],);
			$smsController->sendSMS($smsArray);
		}
	}

	/**
	 * @param $params
	 * @return mixed
	 */
	protected function getIndemnityCancel($params) {
		/** @var cancellationFeeSetting $CancellationFeeSettingController */
		$CancellationFeeSettingController = Load::controller('cancellationFeeSetting');

		return $CancellationFeeSettingController->CalculateIndemnity($params);
	}

	/**
	 * @param $params
	 * @param $apiCancel
	 * @return mixed
	 */
	private function getInfoCancelWithTypeService($params, $apiCancel) {
		$BookResult = array();
		if ($params['typeService'] == 'flight') {
			$BookResult = $this->getFlightForCancel($params, $apiCancel);
		}

		if ($params['typeService'] == 'train') {
			$BookResult = $this->getTrainForCancel($params);
		}

        if ($params['typeService'] == 'bus') {
            $BookResult = $this->getBusForCancel($params);
        }
        if ($params['typeService'] == 'hotel') {
            $BookResult = $this->getHotelForCancel($params);
        }
        if ($params['typeService'] == 'insurance') {
            $BookResult = $this->getInsuranceForCancel($params);
        }

		return $BookResult;
	}

	public function InfoCancel($id) {
		$sql = "SELECT * FROM cancel_ticket_details_tb WHERE id='{$id}'";

		return $this->Model->load($sql);
	}

	/**
	 * @param $Param
	 * @return array
	 * @internal param $d
	 */
	private function getInfoFlightForCancel($Param) {
		$SqlBook = " SELECT * FROM book_local_tb WHERE request_number='{$Param['RequestNumber']}'";
		$InfoBook = $this->admin->ConectDbClient($SqlBook, $Param['ClientId'], "Select", "", "", "");

		if ($InfoBook['pid_private'] == '0') {
			$d['Price'] = $Param['PriceIndemnity'];
		} else {
			$d['Price'] = '0';
		}

		return array($InfoBook, $d);
	}


    public function setCancelNote($params) {

        $this->admin =  Load::controller('admin');
        $data['note_admin'] = $params['note_admin'] ;
        $condition = "id='{$params['id']}'";
        $result_update_note_cancel = $this->admin->ConectDbClient('', $params['client_id'], "Update", $data, "cancel_ticket_details_tb", $condition);

        if($result_update_note_cancel){
            return functions::withSuccess('',200,'یادداشت با موفقیت ذخیره شد');
        }
        return functions::withError('',400,'خطا در ثبت یادداشت');
    }

    public function setExpireTime($params) {

        $data['is_past'] = 1 ;
        $condition = "id='{$params['id']}'";
        $result_update_note_cancel = $this->admin->ConectDbClient('', $params['client_id'], "Update", $data, "cancel_ticket_details_tb", $condition);

        if($result_update_note_cancel){
            return functions::withSuccess('',200,'تنظیم تایم به عنوان  خارج از تایم اداری با موفقیت ذخیره شد');
        }
        return functions::withError('',400,'تنظیم تایم به عنوان  خارج از تایم اداری');
    }



}
