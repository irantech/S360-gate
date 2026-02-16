<?php

/**
 * Class accountcharge
 * @property $accountchargeController accountcharge controller
 */
class accountcharge extends clientAuth
{


	public $id = '';
	public $agencyID = '';
	public $credit = '';
	public $becauseOf = '';
	public $date = '';
	public $comment = '';
	public $list;
	public $list_sub;
	public $message;
	public $total_charge = 0;
	public $total_buy = 0;
	public $total_transaction = 0;
	public $is_search = 0;
    public $total_charge_search = 0;
	public $total_buy_search = 0;
	public $total_transaction_search = 0;
	public $total_transactionNew = 0;
	public $ClientId;
	public $TotalChargeUserToday;
    public $remain_prev ;
    public $total_repeated_price  = 0  ;
    public $start_transaction_date   ;
    public $end_transaction_date   ;

    public $transactions;

	public function __construct()
	{
            parent::__construct();
			$this->ClientId = (isset($_GET['id'])) ? filter_var($_GET['id'], FILTER_VALIDATE_INT): '';

            $this->transactions = $this->getModel('transactionsModel');
	}



    public function createExcelFile($param)
	{

		$_POST = $param;
        if($this->ClientId == '' && $_POST['client_id'] > 0)
        {
            $this->ClientId = $_POST['client_id'] ;
        }
		$this->listAccountCharge('yes');

		if (!empty($this->list)) {

			// برای نام گذاری سطر اول فایل اکسل //
			$firstRowColumnsHeading = ['ردیف', 'شماره فاکتور', 'توضیحات', 'تاریخ تراکنش', 'نوع تراکنش'
				, 'واریز شده به حساب', 'کسر شده از حساب', 'مانده حساب', 'کد رهگیری تراکنش'];
            $firstRowWidth = [10, 50, 40, 20, 20, 30, 30, 50, 20];
            $data_excel = [];


            foreach ( $this->list as $key=>$item) {
                $data_excel[$key]['number_column'] = $item['number_column'];
                $data_excel[$key]['FactorInvoice'] = $item['FactorNumber'];
                $data_excel[$key]['Comment'] = $item['Comment'];
                $data_excel[$key]['transactionDate'] = $item['transactionDate'];
                $data_excel[$key]['ReasonFa'] = $item['ReasonFa'];
                $data_excel[$key]['depositToAccount'] = number_format($item['depositToAccount'], 0, '.', '');
                $data_excel[$key]['accountDeducted'] = number_format($item['accountDeducted'], 0, '.', '');
                $data_excel[$key]['remain'] = number_format($item['remain'], 0, '.', '');
                $data_excel[$key]['BankTrackingCode'] = $item['BankTrackingCode'];
            }
            
			/** @var createExcelFile $objCreateExcelFile */
			$objCreateExcelFile = Load::controller('createExcelFile');
			$resultExcel = $objCreateExcelFile->create($data_excel, $firstRowColumnsHeading,$firstRowWidth);
			if ($resultExcel['message'] == 'success') {
				return 'success|' . $resultExcel['fileName'];
			} else {
				return 'error|متاسفانه در ساخت فایل اکسل مشکلی پیش آمده. لطفا مجددا تلاش کنید';
			}


		} else {
			return 'error|اطلاعاتی برای ساخت فایل اکسسل وجود ندارد.';
		}


	}


    public function createNewExcelFile($param)
    {


        $_POST = $param;
        if($this->ClientId == '' && $_POST['client_id'] > 0)
        {
            $this->ClientId = $_POST['client_id'] ;
        }
        $this->listTransactions('yes');

        if (!empty($this->list)) {

            // برای نام گذاری سطر اول فایل اکسل //
            $firstRowColumnsHeading = ['ردیف', 'شماره فاکتور', 'توضیحات', 'تاریخ تراکنش', 'نوع تراکنش'
                , 'واریز شده به حساب', 'کسر شده از حساب', 'مانده حساب', 'کد رهگیری تراکنش'];
            $firstRowWidth = [10, 50, 40, 20, 20, 30, 30, 50, 20];
            $data_excel = [];



            foreach ($this->list as $key=>$item) {

                $data_excel[$key]['number_column'] = $key + 1;
                $data_excel[$key]['FactorInvoice'] =$item['FactorNumber'];
                $data_excel[$key]['Comment'] = $item['Comment'];
                $data_excel[$key]['transactionDate'] = $item['transactionDate'];
                $data_excel[$key]['ReasonFa'] = $item['ReasonFa'];
                $data_excel[$key]['depositToAccount'] = number_format($item['depositToAccount'], 0, '.', '');
                $data_excel[$key]['accountDeducted'] = number_format($item['accountDeducted'], 0, '.', '');
                $data_excel[$key]['remain'] = number_format($item['remain'], 0, '.', '');
                $data_excel[$key]['BankTrackingCode'] = $item['BankTrackingCode'];
            }

            /** @var createExcelFile $objCreateExcelFile */
            $objCreateExcelFile = Load::controller('createExcelFile');
            $resultExcel = $objCreateExcelFile->create($data_excel, $firstRowColumnsHeading,$firstRowWidth);
            if ($resultExcel['message'] == 'success') {
                return 'success|' . $resultExcel['fileName'];
            } else {
                return 'error|متاسفانه در ساخت فایل اکسل مشکلی پیش آمده. لطفا مجددا تلاش کنید';
            }


        } else {
            return 'error|اطلاعاتی برای ساخت فایل اکسسل وجود ندارد.';
        }


    }

	public function listAccountCharge($reportForExcel = null)
	{

		$time = time() - (600);

		$EndPostDate = $StartTimeNow = date("Y-m-d");
		$StartPostDate = $SevenDaysAgo = date('Y-m-d', strtotime(" -7 days"));

		if (isset($_POST['date_of']) && !empty($_POST['date_of'])) {
			$StartDateExplode = explode('-', $_POST['date_of']);
			$StartPostDate = dateTimeSetting::jalali_to_gregorian($StartDateExplode[0], $StartDateExplode[1], $StartDateExplode[2], '-');
		}
		if (isset($_POST['to_date']) && !empty($_POST['to_date'])) {
			$EndDateExplode = explode('-', $_POST['to_date']);
			$EndPostDate = dateTimeSetting::jalali_to_gregorian($EndDateExplode[0], $EndDateExplode[1], $EndDateExplode[2], '-');


		}

		if ($this->ClientId > 0) {

			/** @var Admin $admin */
			$admin = Load::controller('admin');

			$sql = "SELECT T.* FROM transaction_tb T  WHERE 1=1 AND "
				. " ((T.PaymentStatus = 'success') OR (T.Status = '2' AND T.PaymentStatus = 'pending' AND T.CreationDateInt > '{$time}')) ";


			if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {
				$sql .= " AND ( (T.PriceDate >= '{$StartPostDate} 00:00:00 ' AND T.PriceDate <= '{$EndPostDate} 23:59:59')
                OR (T.PaymentStatus = 'pending' AND T.CreationDateInt > '{$time}'))";
			} else {
					$sql .= "AND ((T.PriceDate <= '{$StartTimeNow} 23:59:59' AND T.PriceDate  >= '{$SevenDaysAgo} 00:00:00') 
                    OR (T.PaymentStatus = 'pending' AND T.CreationDateInt > '{$time}'))";
			}


			if (!empty($_POST['CodeRahgiri']) && $_POST['CodeRahgiri'] > 0) {
				$sql .= " AND T.BankTrackingCode = '{$_POST['CodeRahgiri']}'";
			}


			if (!empty($_POST['FactorNumber']) && $_POST['FactorNumber'] > 0) {
				$sql .= " AND T.FactorNumber= '{$_POST['FactorNumber']}'";
			}
			if (!empty($_POST['Reason'])) {
                if($_POST['Reason']=='buy'){
                    $sql .= " AND (T.Reason= 'buy' OR T.Reason= 'buy_hotel' OR T.Reason= 'buy_insurance' OR T.Reason= 'buy_reservation_hotel' OR T.Reason= 'buy_reservation_ticket' OR T.Reason= 'buy_foreign_hotel'
                    OR T.Reason= 'buy_Europcar' OR T.Reason= 'buy_reservation_tour' OR T.Reason= 'buy_reservation_visa' OR T.Reason= 'buy_gasht_transfer' OR T.Reason= 'buy_train' OR T.Reason= 'buy_bus' OR T.Reason= 'buy_entertainment' OR T.Reason= 'buy_visa_plan' OR T.Reason= 'buy_package OR T.Reason= 'buy_cip' ) ";
                }else{
                    $sql .= " AND (T.Reason='{$_POST['Reason']}') ";
                }
			}

			$sql .= "GROUP BY T.id
                ORDER BY T.CreationDateInt DESC";




            $transactions = $admin->ConectDbClient($sql, $this->ClientId, "SelectAll", "", "", "");

			$sql_charge = "SELECT sum(Price) AS total_charge FROM transaction_tb WHERE Status='1' AND PaymentStatus = 'success'";
			
			$charge = $admin->ConectDbClient($sql_charge, $this->ClientId, "Select", "", "", "");
			$this->total_charge = $charge['total_charge'];

			 $sql_buy = "SELECT SUM(Price) AS total_buy FROM transaction_tb WHERE Status='2' AND"
				. " ((PaymentStatus = 'success') OR (PaymentStatus = 'pending' AND CreationDateInt > '{$time}')) ";

			$buy = $admin->ConectDbClient($sql_buy, $this->ClientId, "Select", "", "", "");
			$this->total_buy = $buy['total_buy'];

		}
        else {
            $Model = Load::library('Model');
            if($_POST['Repeated'] === 'yes') {

                $sql = "SELECT * ,  COUNT(*) as duplicate_count FROM transaction_tb T WHERE 1=1 ";
            }else{
                $sql = "SELECT T.* FROM transaction_tb T  WHERE 1=1 AND"
                    . " ((T.PaymentStatus = 'success') OR (T.Status = '2' AND T.PaymentStatus = 'pending' AND T.CreationDateInt > '{$time}')) ";

            }




            if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {
                $sql .= " AND ( (T.PriceDate >= '{$StartPostDate} 00:00:00 ' AND T.PriceDate <= '{$EndPostDate} 23:59:59')
                OR (T.PaymentStatus = 'pending' AND T.CreationDateInt > '{$time}'))";
            } else {
                    $sql .= "AND ((T.PriceDate <= '{$StartTimeNow} 23:59:59' AND T.PriceDate  >= '{$SevenDaysAgo} 00:00:00') 
                    OR (T.PaymentStatus = 'pending' AND T.CreationDateInt > '{$time}'))";
            }


			if (!empty($_POST['CodeRahgiri']) && $_POST['CodeRahgiri'] > 0) {
				$sql .= " AND T.BankTrackingCode = '{$_POST['CodeRahgiri']}'";
			}


			if (!empty($_POST['FactorNumber']) && $_POST['FactorNumber'] > 0) {
				$sql .= " AND T.FactorNumber= '{$_POST['FactorNumber']}'";
			}

			if (!empty($_POST['Reason'])) {
                if($_POST['Reason']=='buy'){
                    $sql .= " AND (T.Reason= 'buy' OR T.Reason= 'buy_hotel' OR T.Reason= 'buy_insurance' OR T.Reason= 'buy_reservation_hotel' OR T.Reason= 'buy_reservation_ticket' OR T.Reason= 'buy_foreign_hotel'
                    OR T.Reason= 'buy_Europcar' OR T.Reason= 'buy_reservation_tour' OR T.Reason= 'buy_reservation_visa' OR T.Reason= 'buy_gasht_transfer' OR T.Reason= 'buy_train' OR T.Reason= 'buy_bus' OR T.Reason= 'buy_entertainment' OR T.Reason= 'buy_visa_plan' OR T.Reason= 'buy_package OR T.Reason= 'buy_cip' ) ";
                }else{
                    $sql .= " AND (T.Reason='{$_POST['Reason']}') ";
                }
			}

            if($_POST['Repeated'] === 'yes') {
                $sql .= "AND Reason = 'indemnity_cancel'
                        GROUP BY FactorNumber , Reason ,Comment  , Status
                        HAVING COUNT(*) > 1;";
                $transactions = $Model->select($sql);
                $ids = array_column($transactions, 'FactorNumber');
                $transaction_model = $this->getModel('transactionModel');
                $transactions = $transaction_model->get()->whereIn('FactorNumber' , $ids)->where('Reason' , 'indemnity_cancel' )->all();
                
            }else{
                $sql .= " GROUP BY T.id
                ORDER BY T.CreationDateInt DESC";
                $transactions = $Model->select($sql);
            }








			$sql_charge = "SELECT sum(Price) AS total_charge FROM transaction_tb WHERE Status='1' AND PaymentStatus = 'success'";


			$charge = $Model->load($sql_charge);
			$this->total_charge = $charge['total_charge'];

			$sql_buy = "SELECT SUM(Price) AS total_buy  FROM transaction_tb WHERE Status='2' AND"
				. " ((PaymentStatus = 'success') OR (Status = '2' AND PaymentStatus = 'pending' AND CreationDateInt > '{$time}')) ";


			$buy = $Model->load($sql_buy);
			$this->total_buy = $buy['total_buy'];
		}


		$total_transaction = $this->total_transaction = $this->total_charge - $this->total_buy;

        if(isset($_POST['flag']) && $_POST['flag']=='createExcelFileForTransactionUser')
        {
            $sql_charge_search = " SELECT SUM(Price) AS total_charge FROM transaction_tb WHERE Status='1' AND PaymentStatus = 'success' AND ";
            $sql_buy_search = " SELECT SUM(Price) AS total_buy FROM transaction_tb WHERE Status='2' AND ((PaymentStatus = 'success') OR (PaymentStatus = 'pending' AND CreationDateInt > '{$time}')) AND ";
            if (!empty($_POST['to_date'])) {
                $sql_charge_search.=" PriceDate >= '{$StartPostDate} 00:00:00' AND PriceDate <= '{$EndPostDate} 23:59:59'";
                $sql_buy_search    .= " (PriceDate >= '{$StartPostDate} 00:00:00' AND  PriceDate <= '{$EndPostDate} 23:59:59')";
            }

            if (!empty($_POST['CodeRahgiri']) && $_POST['CodeRahgiri'] > 0) {
                $sql_buy_search .= " AND BankTrackingCode = '{$_POST['CodeRahgiri']}'";
                $sql_charge_search .= " AND BankTrackingCode = '{$_POST['CodeRahgiri']}'";
            }


            if (!empty($_POST['FactorNumber']) && $_POST['FactorNumber'] > 0) {
                $sql_buy_search .= " AND FactorNumber= '{$_POST['FactorNumber']}'";
                $sql_charge_search .= " AND FactorNumber= '{$_POST['FactorNumber']}'";
            }

            if (!empty($_POST['Reason'])) {
                if($_POST['Reason']=='buy'){
                    $sql_buy_search .= " AND (Reason= 'buy' OR Reason= 'buy_hotel' OR Reason= 'buy_insurance' OR Reason= 'buy_reservation_hotel' OR Reason= 'buy_reservation_ticket' OR Reason= 'buy_foreign_hotel'
                    OR Reason= 'buy_Europcar' OR Reason= 'buy_reservation_tour' OR Reason= 'buy_reservation_visa' OR Reason= 'buy_gasht_transfer' OR Reason= 'buy_train' OR Reason= 'buy_bus' OR Reason= 'buy_entertainment' OR Reason= 'buy_visa_plan' OR Reason= 'buy_package OR Reason= 'buy_cip' ) ";
                }else{
                    $sql_buy_search .= " AND (Reason='{$_POST['Reason']}') ";
                }

                $sql_charge_search .= " AND Reason= '{$_POST['Reason']}'";
            }

       /*     echo $sql;
            echo '<hr/>';
            echo $sql_buy_search ;
            echo '<hr/>';
            echo $sql_charge_search;*/

            if (!empty($this->ClientId)) {
                $buy_search = $admin->ConectDbClient($sql_buy_search, $this->ClientId, "Select", "", "", "");
                $charge_search = $admin->ConectDbClient($sql_charge_search, $this->ClientId, "Select", "", "", "");
            } else {
                $buy_search = $this->getModel('transactionModel')->load($sql_buy_search);
                $charge_search = $this->getModel('transactionModel')->load($sql_charge_search);
            }

            $total_transaction_search = $charge_search['total_charge'] - $buy_search['total_buy'] ;
            $this->total_transaction_search = $total_transaction_search;
            $this->total_charge_search = $charge_search['total_charge'];
            $this->total_buy_search = $buy_search['total_buy'];
            $this->is_search = true;
        }

		$dataRows = [];
		foreach ($transactions as $k => $transaction) {
			$numberColumn = $k + 2;

			switch ($transaction['Reason']) {
			case 'buy':
				$ReasonFa = 'خرید بلیط';
				break;
			case 'buy_hotel':
				$ReasonFa = 'رزرو هتل';
				break;
			case 'buy_bus':
				$ReasonFa = 'خرید بلیط اتوبوس';
				break;
			case 'buy_reservation_hotel':
				$ReasonFa = 'رزرو هتل رزرواسیون';
				break;
			case 'buy_reservation_ticket':
				$ReasonFa = 'خرید بلیط رزرواسیون';
				break;
			case 'buy_insurance':
				$ReasonFa = 'رزرو بیمه';
				break;
            case 'buy_train':
                 $ReasonFa = 'رزرو قطار';
                 break;
			case 'buy_gasht_transfer':
				$ReasonFa = 'رزرو گشت و ترانسفر';
				break;
			case 'charge':
				$ReasonFa = 'شارژحساب';
				break;
			case 'price_cancel':
				$ReasonFa = 'مبلغ کنسلی';
				break;
			case 'indemnity_cancel':
				$ReasonFa = 'استرداد وجه';
				break;
			case 'increase':
				$ReasonFa = 'واریز به حساب شما';
				break;
			case 'decrease':
				$ReasonFa = 'کسر از حساب شما';
				break;
			case 'indemnity_edit_ticket':
				$ReasonFa = 'جریمه اصلاح بلیط';
				break;
			case 'diff_price':
				$ReasonFa = 'واریز تغییر قیمت شناسه نرخی';
				break;
			case 'buy_package':
				$ReasonFa = 'پرواز+ هتل';
				break;
                case 'buy_cip':
                    $ReasonFa = 'تشریفات فرودگاه';
                    break;
			default:
				$ReasonFa = 'ـــــــ';
				break;
			}


			$dataRows[$k]['number_column'] = $numberColumn - 1;
			$dataRows[$k]['FactorNumber'] = $transaction['FactorNumber'];
			$dataRows[$k]['Comment'] = $transaction['Comment'];
			if (!empty($transaction['PriceDate'])) {
				/** @var bookshow $objBook */
				$objBook = Load::controller('bookshow');
				$dataRows[$k]['transactionDate'] = $objBook->DateJalali($transaction['PriceDate']);
			} else {
				$dataRows[$k]['transactionDate'] = dateTimeSetting::jdate($transaction['CreationDateInt']);
			}
			$dataRows[$k]['ReasonFa'] = $ReasonFa;
			/*if ($transaction['payment_type'] == 'cash') {
				$dataRows[$k]['payment_type_fa'] = 'نقدی';
			} elseif ($transaction['payment_type'] == 'credit') {
				$dataRows[$k]['payment_type_fa'] = 'اعتباری';
			} else {
				$dataRows[$k]['payment_type_fa'] = 'ـــــــ';
			}*/
			$dataRows[$k]['depositToAccount'] = ($transaction['Status'] == '1') ? $transaction['Price'] : 0;
			$dataRows[$k]['accountDeducted'] = ($transaction['Status'] == '2') ? $transaction['Price'] : 0;
			$dataRows[$k]['remain'] = $total_transaction;
			if ($transaction['Status'] == '1') {
				$total_transaction = $total_transaction - $transaction['Price'];
			} else {
				$total_transaction = $total_transaction + $transaction['Price'];
			}
			$dataRows[$k]['BankTrackingCode'] = (!empty($transaction['BankTrackingCode'])) ? $transaction['BankTrackingCode'] : 'ـــــــــــــ';

			if (!isset($reportForExcel) || (isset($reportForExcel) && $reportForExcel == 'no')) {

				$dataRows[$k]['id'] = $transaction['id'];
				$dataRows[$k]['Reason'] = $transaction['Reason'];
				$dataRows[$k]['payment_type'] = $transaction['payment_type'];
				$dataRows[$k]['Status'] = $transaction['Status'];
				if($this->ClientId !=''){

				    $info_client = $this->getController('partner')->infoClient($this->ClientId);
				    $domain = $info_client['Domain'] ;
                }else{
                    $domain = CLIENT_DOMAIN ;
                }
				$dataRows[$k]['domain_agency'] = $domain  ;


            }


		}


        if($_POST['Repeated'] === 'yes') {

            foreach ($dataRows as $item) {
                $key = $item['FactorNumber'] . '_' . substr($item['Comment'], -20);
                $groupedByFactorDomainComment[$key][] = $item;
            }
            $multipleItemCommentGroups = [] ;
            foreach ($groupedByFactorDomainComment as $key =>  $group) {
                if(count($group) > 1) {
                    $multipleItemCommentGroups[$key] = $group ;
                }
            }

            $dataRows = [] ;
            foreach ($multipleItemCommentGroups as $factorNumber => $records) {
                foreach ($records as $record) {
                    $dataRows[] = $record;
                }

            }

            
            $colorList = ["#ff0000a6", "#808080b8"];
            $colorIndex = 0;

            foreach ($dataRows as &$item) {
                $factorNumber = $item['FactorNumber'];
                if (!isset($factorColors[$factorNumber])) {
                    $factorColors[$factorNumber] = $colorList[$colorIndex % count($colorList)];
                    $colorIndex++;
                }
                // Apply the color to the current item
                $item['color'] = $factorColors[$factorNumber];
            }
            unset($item);
        }


          if (empty($this->ClientId))   {
            $sql_repeated = "SELECT * , COUNT(*) as duplicate_count
                FROM transaction_tb
                where Reason = 'indemnity_cancel'
                GROUP BY FactorNumber , Reason ,Comment  , Status
                HAVING COUNT(*) > 1;";


            $repeated = $Model->select($sql_repeated);
      
            if($repeated) {

                $ids = array_column($repeated, 'FactorNumber');
                $transaction_model = $this->getModel('transactionModel');
                $repeated_transactions = $transaction_model->get()->whereIn('FactorNumber' , $ids)->where('Reason' , 'indemnity_cancel' )->all();

                $this->start_transaction_date = dateTimeSetting::jdate('Y-m-d' , $repeated[0]['CreationDateInt']) ;
                $date = new DateTime();
                $timestamp = $date->getTimestamp();
                $this->end_transaction_date = dateTimeSetting::jdate('Y-m-d' , $timestamp ) ;

                foreach ($repeated_transactions as $rep) {
                    $this->total_repeated_price += $rep['Price'];
                }
                $this->total_repeated_price = $this->total_repeated_price /2 ;
            }
        }

		$this->list = $dataRows;


	}

    //region [insert]
    public function insert($info, $clientID = null){

        $increaseReasonArray = array("charge", "increase", "Reason");// This array includes reasons for increasing client credit

        $decreaseReasonArray = array("decrease", "indemnity_edit_ticket",);// This array includes reasons for decreasing client credit

        $pendingStatusArray = array('increase', 'decrease', 'indemnity_edit_ticket', 'diff_price');// This array includes reasons for pending status client credit

        $data_insert_transaction['Price'] = $info['Price'];
        $data_insert_transaction['Comment'] = $info['Comment'];
        $data_insert_transaction['Reason'] = $info['Reason'];
        $data_insert_transaction['PaymentStatus'] = in_array($info['Reason'], $pendingStatusArray) ? 'pending' : 'success';
        $data_insert_transaction['CreationDateInt'] = time();
        $data_insert_transaction['FactorNumber'] = 'OP' . mt_rand(100000, 999999);
        $data_insert_transaction['PriceDate'] = date("Y-m-d H:i:s");
        if (in_array($info['Reason'], $increaseReasonArray)) {
            $data_insert_transaction['Status'] = '1';
        } else if (in_array($info['Reason'], $decreaseReasonArray)) {
            $data_insert_transaction['Status'] = '2';
        }

        if (!empty($clientID)) {
            //This is for when credit is entered from the main admin panel for client
            $result = $this->getController('admin')->ConectDbClient("", $clientID, "Insert", $data_insert_transaction, "transaction_tb", "");

            $data_insert_transaction['clientID'] = $clientID;
            $this->transactions->insertTransaction($data_insert_transaction);
        } else {
            $result = $this->getModel('transactionModel')->insertLocal($data_insert_transaction);

            $this->transactions->insertTransaction($data_insert_transaction);
        }

        if ($result) {
            return 'success : تراکنش با موفقیت انجام شد';
        }
        return 'error : خطا در ثبت تراکنش ';

    }
    //endregion

	public function initBankData($price, $factor_number, $tracking_code)
	{

		$data['Price'] = $price;
		$data['FactorNumber'] = $factor_number;
		$data['Status'] = 1;
		$data['Reason'] = 'charge';
		$data['Comment'] = 'شارژ حساب با کد رهگیری ' . $tracking_code;
		$data['BankTrackingCode'] = $tracking_code;
		$data['PaymentStatus'] = 'success';
		$data['CreationDateInt'] = time();
		$data['PriceDate'] = date("Y-m-d H:i:s");
		$res = $this->getModel('transactionModel')->get()->where('BankTrackingCode',$data['BankTrackingCode'])->where('FactorNumber',$data['FactorNumber'])->find();

		if (empty($res)) {
            $this->getModel('transactionModel')->insertWithBind($data);
            $this->transactions->insertTransaction($data);
			/*todo : Request to insert data in accountant software using api function */
            return true;
		}
        return false;
	}

	public function giveRequestNumber($factor_number){
        $result = $this->getModel('reportModel')->get()->where('factor_number',$factor_number)->find();

        return $result['request_number'];
	}

	public function listViewForAdmin()
	{
		$StartTimeNow = date("Y-m-d");
		$SevenDaysAgo = date('Y-m-d', strtotime(" 0 days"));

		$StartDateExplode = explode('-', $_POST['date_of']);
		$EndDateExplode = explode('-', $_POST['to_date']);

		$StartPostDate = dateTimeSetting::jalali_to_gregorian($StartDateExplode[0], $StartDateExplode[1], $StartDateExplode[2], '-');
		$EndPostDate = dateTimeSetting::jalali_to_gregorian($EndDateExplode[0], $EndDateExplode[1], $EndDateExplode[2], '-');


		$res = $this->getController('partner')->allClients();

		$show_client_pay = [];

		foreach ($res as $each) {

				$sql = "SELECT * FROM transaction_tb WHERE Status='1'  AND PaymentStatus='success'";
				if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {
					$sql .= " AND PriceDate >= '{$StartPostDate} 00:00:00 ' AND PriceDate <= '{$EndPostDate} 23:59:59'";
				} else {
					if (empty($_POST)) {
						$sql .= "AND PriceDate <= '{$StartTimeNow} 23:59:59' AND PriceDate  >= '{$SevenDaysAgo} 00:00:00'";
					}
				}
				if (!empty($_POST['CodeRahgiri']) && $_POST['CodeRahgiri'] > 0) {
					$sql .= " AND BankTrackingCode = '{$_POST['CodeRahgiri']}'";
				}
				if (!empty($_POST['FactorNumber']) && $_POST['FactorNumber'] > 0) {
					$sql .= " AND FactorNumber= '{$_POST['FactorNumber']}'";
				}
				$sql .= " ORDER BY id DESC";
				$clientPay = $this->getController('admin')->ConectDbClient($sql, $each['id'], "SelectAll", "", "", "");

				foreach ($clientPay as $key => $pay) {
					$pay['AgencyName'] = $each['AgencyName'];
                    $show_client_pay[] = $pay;
				}

		}


		$Payment = array();
		foreach ($show_client_pay as $key => $row) {
			$Payment['PriceDate'][$key] = $row['PriceDate'];
		}

		array_multisort($Payment['PriceDate'], SORT_DESC, $show_client_pay);


		return $show_client_pay;
	}

	public function ClientName($id){
		$ClientName = $this->getController('partner')->infoClient($id);

		return $ClientName['AgencyName'];
	}

	public function newTransaction()
	{
		$time = time() - (600);

		$EndPostDate = $StartTimeNow = date("Y-m-d");
		$StartPostDate = $SevenDaysAgo = date('Y-m-d', strtotime(" -7 days"));

		if (isset($_POST['date_of']) && !empty($_POST['date_of'])) {
			$StartDateExplode = explode('-', $_POST['date_of']);
			$StartPostDate = dateTimeSetting::jalali_to_gregorian($StartDateExplode[0], $StartDateExplode[1], $StartDateExplode[2], '-');
		}
		if (isset($_POST['to_date']) && !empty($_POST['to_date'])) {
			$EndDateExplode = explode('-', $_POST['to_date']);
			$EndPostDate = dateTimeSetting::jalali_to_gregorian($EndDateExplode[0], $EndDateExplode[1], $EndDateExplode[2], '-');


		}

		if (!empty($this->ClientId)) {

			/** @var admin $admin */
			$admin = Load::controller('admin');

			$sql = "SELECT T.*, B.payment_type FROM transaction_tb T LEFT JOIN book_local_tb B 
                ON (T.FactorNumber = B.factor_number AND T.FactorNumber != '' AND B.factor_number > '0') WHERE 1=1 AND"
				. " ((T.PaymentStatus = 'success') OR (T.PaymentStatus = 'pending' AND T.CreationDateInt > '{$time}')) ";


			if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {
				$sql .= " AND ( (T.PriceDate >= '{$StartPostDate} 00:00:00 ' AND T.PriceDate <= '{$EndPostDate} 23:59:59')
                OR (T.PaymentStatus = 'pending' AND T.CreationDateInt > '{$time}' AND T.PriceDate IS NULL) )";
			} else {
				if (empty($_POST)) {
					$sql .= "AND ((T.PriceDate <= '{$StartTimeNow} 23:59:59' AND T.PriceDate  >= '{$SevenDaysAgo} 00:00:00') 
                    OR (T.PaymentStatus = 'pending' AND T.CreationDateInt > '{$time}' AND T.PriceDate IS NULL) )";
				}
			}


			if (!empty($_POST['CodeRahgiri']) && $_POST['CodeRahgiri'] > 0) {
				$sql .= " AND T.BankTrackingCode = '{$_POST['CodeRahgiri']}'";
			}


			if (!empty($_POST['FactorNumber']) && $_POST['FactorNumber'] > 0) {
				$sql .= " AND T.FactorNumber= '{$_POST['FactorNumber']}'";
			}


			$sql .= "GROUP BY T.id
                 ORDER BY T.CreationDateInt DESC";

			$this->list = $admin->ConectDbClient($sql, $this->ClientId, "SelectAll", "", "", "");

			$sql_charge = "SELECT sum(Price) AS total_charge FROM transaction_tb WHERE Status='1'";
			$charge = $admin->ConectDbClient($sql_charge, $this->ClientId, "Select", "", "", "");
			$this->total_charge = $charge['total_charge'];

			$sql_buy = "SELECT SUM(Price) AS total_buy FROM transaction_tb WHERE Status='2' AND"
				. " ((PaymentStatus = 'success') OR (PaymentStatus = 'pending' AND CreationDateInt > '{$time}')) ";
			$buy = $admin->ConectDbClient($sql_buy, $this->ClientId, "Select", "", "", "");
			$this->total_buy = $buy['total_buy'];
		} else {
			$Model = Load::library('Model');

			$sql = "SELECT T.*, B.payment_type FROM transaction_tb T LEFT JOIN book_local_tb  B 
                ON (T.FactorNumber = B.factor_number AND T.FactorNumber != '' AND B.factor_number > '0') WHERE 1=1 AND"
				. " ((T.PaymentStatus = 'success') OR (T.PaymentStatus = 'pending' AND T.CreationDateInt > '{$time}')) ";

			if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {
				$sql .= " AND ( (T.PriceDate >= '{$StartPostDate} 00:00:00 ' AND T.PriceDate <= '{$EndPostDate} 23:59:59')
                OR (T.PaymentStatus = 'pending' AND T.CreationDateInt > '{$time}' AND T.PriceDate IS NULL) )";
			} else {
				if (empty($_POST)) {
					$sql .= "AND ((T.PriceDate <= '{$StartTimeNow} 23:59:59' AND T.PriceDate  >= '{$SevenDaysAgo} 00:00:00') 
                    OR (T.PaymentStatus = 'pending' AND T.CreationDateInt > '{$time}' AND T.PriceDate IS NULL) )";
				}
			}


			if (!empty($_POST['CodeRahgiri']) && $_POST['CodeRahgiri'] > 0) {
				$sql .= " AND T.BankTrackingCode = '{$_POST['CodeRahgiri']}'";
			}


			if (!empty($_POST['FactorNumber']) && $_POST['FactorNumber'] > 0) {
				$sql .= " AND T.FactorNumber= '{$_POST['FactorNumber']}'";
			}


			$sql .= " GROUP BY T.id
                ORDER BY T.CreationDateInt DESC";

			$transactions = $Model->select($sql);
			$this->list = $transactions;

			$sql_charge = "SELECT sum(Price) AS total_charge FROM transaction_tb WHERE Status='1'";
			$charge = $Model->load($sql_charge);
			$this->total_charge = $charge['total_charge'];

			$sql_buy = "SELECT SUM(Price) AS total_buy  FROM transaction_tb WHERE Status='2' AND"
				. " ((PaymentStatus = 'success') OR (PaymentStatus = 'pending' AND CreationDateInt > '{$time}')) ";
			$buy = $Model->load($sql_buy);
			$this->total_buy = $buy['total_buy'];
		}

		$this->total_transactionNew = $this->total_charge - $this->total_buy;
	}


	public function StoreInfoChargeAgency($amount, $factorNumber, $tracingCode)
	{

        $InfoChargeAgency = array(
            'fk_agency_id' => Session::getAgencyId(),
            'credit' => $amount,
            'type' => 'increase',
            'reason' => 'deposit',
            'Comment' => 'شارژ حساب با کد رهگیری ' . $tracingCode,
            'trackingCode' => $tracingCode,
            'PaymentStatus' => 'success',
            'member_id' => '0',
            'creation_date_int' => time(),
            'factorNumber' => $factorNumber,
            'credit_date' => dateTimeSetting::jdate("Y-m-d H:i:s", time(),'','','en')
        );
        $this->getModel('creditDetailModel')->insertLocal($InfoChargeAgency);
	}

	public function ListTransactionUser(){
		return $this->getController('memberCredit')->listAllSuccessCreditMember();
	}

	public function existAward($factor_number){
        $result = $this->getController('memberCredit')->checkExistMemberCreditByFactorNumber($factor_number);
		if (empty($result)) {
			return true;
		}
		return false;
	}

	public function ListPendingCreditManual()
	{


		/** @var admin $admin */
		$admin = Load::controller('admin');
		$ModelBase = Load::library('ModelBase');

		$sql = " select partner.*,login.token from clients_tb AS partner
                LEFT JOIN login_tb AS login On login.client_id = partner.id
                WHERE  partner.id > 1  ORDER BY partner.id ASC";
		$res = $ModelBase->select($sql);
		$showClientTransaction = [];
		foreach ($res as $each) {

			if ($each['id'] > '1') {

				$sql = "SELECT * FROM transaction_tb WHERE (Reason='increase' OR Reason='decrease') AND PaymentStatus='pending'  ORDER BY id DESC ";

				$clientTransaction = $admin->ConectDbClient($sql, $each['id'], "SelectAll", "", "", "");

				foreach ($clientTransaction as $key => $transaction) {
					$transaction['AgencyName'] = $each['AgencyName'];
					$transaction['clientId'] = $each['id'];
					$transaction['token'] = $each['token'];
					$showClientTransaction [] = $transaction;
				}
			}
		}
		$Transactions = array();
		foreach ($showClientTransaction as $key => $row) {
			$Transactions['PriceDate'][$key] = $row['PriceDate'];
		}

		array_multisort($Transactions['PriceDate'], SORT_DESC, $showClientTransaction);

		return $showClientTransaction;
	}

	public function changeStatusPaymentManual($params)
	{
		/** @var admin $admin */
		$admin = Load::controller('admin');
		$Transaction = [];
		if ($params['type'] == 'accept') {
			$Transaction['PaymentStatus'] = 'success';
		} else if ($params['type'] == 'reject') {
			$Transaction['PaymentStatus'] = 'reject';
		}
		$ConditionTransaction = " FactorNumber='{$params['factorNumber']}' ";
		$updateTransaction = $admin->ConectDbClient('', $params['ClientId'], "Update", $Transaction, "transaction_tb", $ConditionTransaction);

        $Transaction['clientID'] = $params['ClientId'];
        $this->transactions->updateTransaction($Transaction,$ConditionTransaction);


		if ($updateTransaction) {
			return 'success:تغییر وضعیت درخواست با موفقیت  انجام شد ';
		}

		return 'error:خطا در تغییر وضعیت ';
	}

    public function partnerWhiteLabelTransaction($client_id ,$reportForExcel = null)
    {

        $info_client = $this->getController('partner')->infoClient($client_id);

        if(!empty($info_client) && $info_client['parent_id']== CLIENT_ID){

            $time = time() - (600);

            $EndPostDate = $StartTimeNow = date("Y-m-d");
            $StartPostDate = $SevenDaysAgo = date('Y-m-d', strtotime(" -7 days"));

            if (isset($_POST['date_of']) && !empty($_POST['date_of'])) {
                $StartDateExplode = explode('-', $_POST['date_of']);
                $StartPostDate = dateTimeSetting::jalali_to_gregorian($StartDateExplode[0], $StartDateExplode[1], $StartDateExplode[2], '-');
            }

            if (isset($_POST['to_date']) && !empty($_POST['to_date'])) {
                $EndDateExplode = explode('-', $_POST['to_date']);
                $EndPostDate = dateTimeSetting::jalali_to_gregorian($EndDateExplode[0], $EndDateExplode[1], $EndDateExplode[2], '-');
            }



            /** @var Admin $admin */
            $admin = Load::controller('admin');

            $sql = "SELECT T.*, B.payment_type FROM transaction_tb T LEFT JOIN book_local_tb B 
                ON (T.FactorNumber = B.factor_number AND T.FactorNumber != '' AND B.factor_number > '0') WHERE 1=1 AND"
                . " ((T.PaymentStatus = 'success') OR (IF(B.payment_type='cash' ,T.PaymentStatus = 'pending' AND T.CreationDateInt > '{$time}' ,''))) ";


            if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {
                $sql .= " AND ( (T.PriceDate >= '{$StartPostDate} 00:00:00 ' AND T.PriceDate <= '{$EndPostDate} 23:59:59')
                OR (IF(B.payment_type='cash' ,T.PaymentStatus = 'pending' AND T.CreationDateInt > '{$time}'  , '')) )";
            } else {
                if (empty($_POST)) {
                    $sql .= "AND ((T.PriceDate <= '{$StartTimeNow} 23:59:59' AND T.PriceDate  >= '{$SevenDaysAgo} 00:00:00') 
                    OR (IF(B.payment_type='cash' ,T.PaymentStatus = 'pending' AND T.CreationDateInt > '{$time}' ,'')) )";
                }
            }


            if (!empty($_POST['CodeRahgiri']) && $_POST['CodeRahgiri'] > 0) {
                $sql .= " AND T.BankTrackingCode = '{$_POST['CodeRahgiri']}'";
            }


            if (!empty($_POST['FactorNumber']) && $_POST['FactorNumber'] > 0) {
                $sql .= " AND T.FactorNumber= '{$_POST['FactorNumber']}'";
            }
            if (!empty($_POST['Reason'])) {
                $sql .= " AND T.Reason= '{$_POST['Reason']}'";
            }

            $sql .= "GROUP BY T.id
                ORDER BY T.CreationDateInt DESC";



            $transactions = $admin->ConectDbClient($sql, $client_id, "SelectAll", "", "", "");

            $sql_charge = "SELECT sum(Price) AS total_charge FROM transaction_tb WHERE Status='1' AND PaymentStatus = 'success'";
            if (!empty($_POST['to_date'])) {
                $sql_charge .= " AND PriceDate <= '{$EndPostDate} 23:59:59'";
            }
            $charge = $admin->ConectDbClient($sql_charge, $client_id, "Select", "", "", "");
            $this->total_charge = $charge['total_charge'];

            $sql_buy = "SELECT SUM(Price) AS total_buy FROM transaction_tb WHERE Status='2' AND"
                . " ((PaymentStatus = 'success') OR (PaymentStatus = 'pending' AND CreationDateInt > '{$time}')) ";
            if (!empty($_POST['to_date'])) {
                $sql_buy .= " AND  PriceDate <= '{$EndPostDate} 23:59:59'";
            }
            $buy = $admin->ConectDbClient($sql_buy, $client_id, "Select", "", "", "");
            $this->total_buy = $buy['total_buy'];




            $total_transaction = $this->total_transaction = $this->total_charge - $this->total_buy;

            $dataRows = [];
            foreach ($transactions as $k => $transaction) {
                $numberColumn = $k + 2;

                switch ($transaction['Reason']) {
                    case 'buy':
                        $ReasonFa = 'خرید بلیط';
                        break;
                    case 'buy_hotel':
                        $ReasonFa = 'رزرو هتل';
                        break;
                    case 'buy_bus':
                        $ReasonFa = 'خرید بلیط اتوبوس';
                        break;
                    case 'buy_reservation_hotel':
                        $ReasonFa = 'رزرو هتل رزرواسیون';
                        break;
                    case 'buy_reservation_ticket':
                        $ReasonFa = 'خرید بلیط رزرواسیون';
                        break;
                    case 'buy_insurance':
                        $ReasonFa = 'رزرو بیمه';
                        break;
                    case 'buy_train':
                        $ReasonFa = 'رزرو قطار';
                        break;
                    case 'buy_gasht_transfer':
                        $ReasonFa = 'رزرو گشت و ترانسفر';
                        break;
                    case 'charge':
                        $ReasonFa = 'شارژحساب';
                        break;
                    case 'price_cancel':
                        $ReasonFa = 'مبلغ کنسلی';
                        break;
                    case 'indemnity_cancel':
                        $ReasonFa = 'استرداد وجه';
                        break;
                    case 'increase':
                        $ReasonFa = 'واریز به حساب شما';
                        break;
                    case 'decrease':
                        $ReasonFa = 'کسر از حساب شما';
                        break;
                    case 'indemnity_edit_ticket':
                        $ReasonFa = 'جریمه اصلاح بلیط';
                        break;
                    case 'diff_price':
                        $ReasonFa = 'واریز تغییر قیمت شناسه نرخی';
                        break;
                    case 'buy_package':
                        $ReasonFa = 'پرواز+ هتل';
                        break;
                    case 'buy_cip':
                        $ReasonFa = 'تشریفات فرودگاه';
                        break;
                    default:
                        $ReasonFa = 'ـــــــ';
                        break;
                }


                $dataRows[$k]['number_column'] = $numberColumn - 1;
                $dataRows[$k]['FactorNumber'] = $transaction['FactorNumber'];
                $dataRows[$k]['Comment'] = $transaction['Comment'];
                if (!empty($transaction['PriceDate'])) {
                    /** @var bookshow $objBook */
                    $objBook = Load::controller('bookshow');
                    $dataRows[$k]['transactionDate'] = $objBook->DateJalali($transaction['PriceDate']);
                } else {
                    $dataRows[$k]['transactionDate'] = dateTimeSetting::jdate($transaction['CreationDateInt']);
                }
                $dataRows[$k]['ReasonFa'] = $ReasonFa;
                if ($transaction['payment_type'] == 'cash') {
                    $dataRows[$k]['payment_type_fa'] = 'نقدی';
                } elseif ($transaction['payment_type'] == 'credit') {
                    $dataRows[$k]['payment_type_fa'] = 'اعتباری';
                } else {
                    $dataRows[$k]['payment_type_fa'] = 'ـــــــ';
                }
                $dataRows[$k]['depositToAccount'] = ($transaction['Status'] == '1') ? $transaction['Price'] : 0;
                $dataRows[$k]['accountDeducted'] = ($transaction['Status'] == '2') ? $transaction['Price'] : 0;
                $dataRows[$k]['remain'] = $total_transaction;
                if ($transaction['Status'] == '1') {
                    $total_transaction = $total_transaction - $transaction['Price'];
                } else {
                    $total_transaction = $total_transaction + $transaction['Price'];
                }
                $dataRows[$k]['BankTrackingCode'] = (!empty($transaction['BankTrackingCode'])) ? $transaction['BankTrackingCode'] : 'ـــــــــــــ';

                if (!isset($reportForExcel) || (isset($reportForExcel) && $reportForExcel == 'no')) {

                    $dataRows[$k]['id'] = $transaction['id'];
                    $dataRows[$k]['Reason'] = $transaction['Reason'];
                    $dataRows[$k]['payment_type'] = $transaction['payment_type'];
                    $dataRows[$k]['Status'] = $transaction['Status'];
                    $dataRows[$k]['domain_agency'] = $info_client['Domain']  ;

                }

            }
            $this->list = $dataRows;
        }

    }

    public function addTransactionToPartnerWhiteLabel($info) {
        $increaseReasonArray = array("charge", "increase", "Reason");// This array includes reasons for increasing client credit

        $decreaseReasonArray = array("decrease", "indemnity_edit_ticket");// This array includes reasons for decreasing client credit

        $pendingStatusArray = array('increase', 'decrease', 'indemnity_edit_ticket', 'diff_price');// This array includes reasons for pending status client credit

        $data_insert_transaction['Price'] = $info['Price'];
        $data_insert_transaction['Comment'] = $info['Comment'];
        $data_insert_transaction['Reason'] = $info['Reason'];
        $data_insert_transaction['PaymentStatus'] = 'success';
        $data_insert_transaction['CreationDateInt'] = time();
        $data_insert_transaction['FactorNumber'] = 'HM' . mt_rand(100000, 999999);
        $data_insert_transaction['PriceDate'] = date("Y-m-d H:i:s");
        if (in_array($info['Reason'], $increaseReasonArray)) {
            $data_insert_transaction['Status'] = '1';
        } else if (in_array($info['Reason'], $decreaseReasonArray)) {
            $data_insert_transaction['Status'] = '2';
        }
            //This is for when credit is entered from the main admin panel for client
            $result = $this->getController('admin')->ConectDbClient("", $info['Client_id'], "Insert", $data_insert_transaction, "transaction_tb", "");

               $data_insert_transaction['clientID'] = $info['Client_id'];
               $this->transactions->insertTransaction($data_insert_transaction);

        if ($result) {
            return functions::withSuccess($result,200,'تراکنش با موفقیت انجام شد');
        }
        return functions::withError(null,200,'خطا در ثبت تراکنش');
    }


    public function listTransactions($reportForExcel = null){
      

        $time = time() - (600);

        $EndPostDate = $StartTimeNow = date("Y-m-d");
        $StartPostDate = $SevenDaysAgo = date('Y-m-d', strtotime(" -7 days"));

        if (isset($_POST['date_of']) && !empty($_POST['date_of'])) {
            $StartDateExplode = explode('-', $_POST['date_of']);
            $StartPostDate = dateTimeSetting::jalali_to_gregorian($StartDateExplode[0], $StartDateExplode[1], $StartDateExplode[2], '-');
        }
        if (isset($_POST['to_date']) && !empty($_POST['to_date'])) {
            $EndDateExplode = explode('-', $_POST['to_date']);
            $EndPostDate = dateTimeSetting::jalali_to_gregorian($EndDateExplode[0], $EndDateExplode[1], $EndDateExplode[2], '-');
        }





            $sql = "SELECT T.* FROM transaction_tb T WHERE 1=1";


            if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {
                $sql .= " AND ( ((T.PaymentStatus = 'success') AND T.PriceDate >= '{$StartPostDate} 00:00:00 ' AND T.PriceDate <= '{$EndPostDate} 23:59:59')
                OR (T.PaymentStatus = 'pending' AND T.CreationDateInt > '{$time}'))";
            }
            else {
                    $sql .= " AND ((T.PaymentStatus = 'success') AND (T.PriceDate <= '{$StartTimeNow} 23:59:59' AND
                     T.PriceDate  >= '{$SevenDaysAgo} 00:00:00')
                    OR (T.PaymentStatus = 'pending' AND T.CreationDateInt > '{$time}' ))";

            }


            if (!empty($_POST['CodeRahgiri']) && $_POST['CodeRahgiri'] > 0) {
                $sql .= " AND T.BankTrackingCode = '{$_POST['CodeRahgiri']}'";
            }


            if (!empty($_POST['FactorNumber']) && $_POST['FactorNumber'] > 0) {
                $sql .= " AND T.FactorNumber= '{$_POST['FactorNumber']}'";
            }
            if (!empty($_POST['Reason'])) {
                if($_POST['Reason']=='buy'){
                    $sql .= " AND (Reason= 'buy' OR Reason= 'buy_hotel' OR Reason= 'buy_insurance' OR Reason= 'buy_reservation_hotel' OR Reason= 'buy_reservation_ticket' OR Reason= 'buy_foreign_hotel'
                    OR Reason= 'buy_Europcar' OR Reason= 'buy_reservation_tour' OR Reason= 'buy_reservation_visa' OR Reason= 'buy_gasht_transfer' OR Reason= 'buy_train' OR Reason= 'buy_bus' OR Reason= 'buy_entertainment' OR Reason= 'buy_visa_plan' OR Reason= 'buy_package OR Reason= 'buy_cip' ) ";
                }else{
                    $sql .= " AND (Reason='{$_POST['Reason']}') ";
                }
            }

            $sql .= "GROUP BY T.id
                ORDER BY T.PriceDate ASC";


//            echo $sql ; die();

        /** @var Admin $admin */
        $admin = Load::controller('admin');

            $sql_charge = "SELECT sum(Price) AS total_charge FROM transaction_tb WHERE Status='1' AND PaymentStatus = 'success'";
           /*else{
                $sql_charge .= "  AND PriceDate >= '{$StartTimeNow} 00:00:00' AND  PriceDate <= '{$SevenDaysAgo} 23:59:59'";
            }*/




//OR( FactorNumber IN  ('1683253825325','1686472973066','169247466197','1692687823589','1701554587155','1701563298821','1701663823736','1701812441612','1701947942955','1701976859007','1702154187495','1702313596985','1702671928770','1703021063154','1704227981843','1704556730727','1705373204638','1705597679227','1706077203853','170607605131','1706034806781','1706041609432','1706157981128','1706360145932','170631548545','1706516053398'
//))
            $sql_buy = "SELECT SUM(Price) AS total_buy FROM transaction_tb WHERE Status='2' AND"
                . " ((PaymentStatus = 'success') OR (PaymentStatus = 'pending' AND CreationDateInt > '{$time}')  ) ";
       /*else{
            $sql_buy .= "  AND PriceDate >= '{$StartTimeNow} 00:00:00' AND  PriceDate <= '{$SevenDaysAgo} 23:59:59'";
        }*/




        if (!empty($this->ClientId)) {
            $transactions = $admin->ConectDbClient($sql, $this->ClientId, "SelectAll", "", "", "");
            $buy = $admin->ConectDbClient($sql_buy, $this->ClientId, "Select", "", "", "");
            $charge = $admin->ConectDbClient($sql_charge, $this->ClientId, "Select", "", "", "");
        } else {
            $transactions = $this->getModel('transactionModel')->select($sql);
            $buy = $this->getModel('transactionModel')->load($sql_buy);
            $charge = $this->getModel('transactionModel')->load($sql_charge);
        }

        $this->is_search = false ;



        if((isset($_POST['flag']) && $_POST['flag']=='newCreateExcelFileForTransactionUser') || $reportForExcel=='yes')
        {

            $sql_charge_search = " SELECT SUM(Price) AS total_charge FROM transaction_tb WHERE Status='1' AND PaymentStatus = 'success'  ";

            //OR( FactorNumber IN  ('1683253825325','1686472973066','169247466197','1692687823589','1701554587155','1701563298821','1701663823736','1701812441612','1701947942955','1701976859007','1702154187495','1702313596985','1702671928770','1703021063154','1704227981843','1704556730727','1705373204638','1705597679227','1706077203853','170607605131','1706034806781','1706041609432','1706157981128','1706360145932','170631548545','1706516053398'
            //))
             $sql_buy_search = " SELECT SUM(Price) AS total_buy FROM transaction_tb WHERE Status='2' AND ((PaymentStatus = 'success') OR (PaymentStatus = 'pending' AND CreationDateInt > '{$time}')  )  ";
            if (!empty($_POST['to_date'])) {
                $sql_charge_search.=" AND PriceDate >= '{$StartPostDate} 00:00:00' AND PriceDate <= '{$EndPostDate} 23:59:59'";
                $sql_buy_search    .= " AND  (PriceDate >= '{$StartPostDate} 00:00:00' AND  PriceDate <= '{$EndPostDate} 23:59:59')";
            }


            if (!empty($_POST['CodeRahgiri']) && $_POST['CodeRahgiri'] > 0) {
                $sql_buy_search .= " AND BankTrackingCode = '{$_POST['CodeRahgiri']}'";
                $sql_charge_search .= " AND BankTrackingCode = '{$_POST['CodeRahgiri']}'";
            }


            if (!empty($_POST['FactorNumber']) && $_POST['FactorNumber'] > 0) {
                $sql_buy_search .= " AND FactorNumber= '{$_POST['FactorNumber']}'";
                $sql_charge_search .= " AND FactorNumber= '{$_POST['FactorNumber']}'";
            }

            if (!empty($_POST['Reason'])) {

                if($_POST['Reason']=='buy'){
                    $sql_buy_search .= " AND (Reason= 'buy' OR Reason= 'buy_hotel' OR Reason= 'buy_insurance' OR Reason= 'buy_reservation_hotel' OR Reason= 'buy_reservation_ticket' OR Reason= 'buy_foreign_hotel'
                    OR Reason= 'buy_Europcar' OR Reason= 'buy_reservation_tour' OR Reason= 'buy_reservation_visa' OR Reason= 'buy_gasht_transfer' OR Reason= 'buy_train' OR Reason= 'buy_bus' OR Reason= 'buy_entertainment' OR Reason= 'buy_visa_plan' OR Reason= 'buy_package' OR Reason= 'buy_cip' ) ";
                }else{
                    $sql_buy_search .= " AND (Reason='{$_POST['Reason']}') ";
                }

                $sql_charge_search .= " AND Reason= '{$_POST['Reason']}'";
            }

            /*     echo $sql;
                 echo '<hr/>';
                 echo $sql_buy_search ;
                 echo '<hr/>';
                 echo $sql_charge_search;*/
            
            
             $sql_remain_prev = "SELECT SUM(Price) AS sum_price FROM  transaction_tb  WHERE PriceDate IS NOT NULL AND (( PaymentStatus = 'success' ) AND PriceDate <= '{$StartPostDate} 00:00:00' )  GROUP BY `Status`" ;

            if (!empty($this->ClientId)) {
                $buy_search = $admin->ConectDbClient($sql_buy_search, $this->ClientId, "Select", "", "", "");
                $charge_search = $admin->ConectDbClient($sql_charge_search, $this->ClientId, "Select", "", "", "");
                $total_remain_prev = $admin->ConectDbClient($sql_remain_prev, $this->ClientId, "SelectAll", "", "", "");
            } else {
                $buy_search = $this->getModel('transactionModel')->load($sql_buy_search);
                $charge_search = $this->getModel('transactionModel')->load($sql_charge_search);
                $total_remain_prev = $this->getModel('transactionModel')->select($sql_remain_prev);
            }

            $total_transaction_search = $charge_search['total_charge'] - $buy_search['total_buy'] ;
            $this->total_transaction_search = $total_transaction_search;
            $this->total_charge_search = $charge_search['total_charge'];
            $this->total_buy_search = $buy_search['total_buy'];
            $this->is_search = true;

        }
       

        $this->total_buy = $buy['total_buy'];
        $this->total_charge = $charge['total_charge'];
        $total_transaction = $this->total_transaction = $this->total_charge - $this->total_buy;

        




        $factor_numbers=['1683253825325','1686472973066','169247466197','1692687823589','1701554587155','1701563298821','1701663823736','1701812441612','1701947942955','1701976859007','1702154187495','1702313596985','1702671928770','1703021063154','1704227981843','1704556730727','1705373204638','1705597679227','1706077203853','170607605131','1706034806781','1706041609432','1706157981128','1706360145932','170631548545','1706516053398'
        ];
        $dataRows = [];

         $total_transaction_remain_preve = $total_remain_prev[0]['sum_price'] - $total_remain_prev[1]['sum_price']  ;
        $this->remain_prev = $total_transaction_remain_preve ;


        foreach ($transactions as $k => $transaction) {

            if($transaction['PaymentStatus']=='success' /*|| (in_array($transaction['FactorNumber'],$factor_numbers))*/){
                $numberColumn = $k + 2;

                if(in_array($transaction['FactorNumber'],$factor_numbers)){
                    $dataRows[$k]['isPending'] = true;
                }else{
                    $dataRows[$k]['isPending'] = false;
                }

                switch ($transaction['Reason']) {
                    case 'buy':
                        $ReasonFa = 'خرید بلیط';
                        break;
                    case 'buy_hotel':
                        $ReasonFa = 'رزرو هتل';
                        break;
                    case 'buy_bus':
                        $ReasonFa = 'خرید بلیط اتوبوس';
                        break;
                    case 'buy_reservation_hotel':
                        $ReasonFa = 'رزرو هتل رزرواسیون';
                        break;
                    case 'buy_reservation_ticket':
                        $ReasonFa = 'خرید بلیط رزرواسیون';
                        break;
                    case 'buy_insurance':
                        $ReasonFa = 'رزرو بیمه';
                        break;
                    case 'buy_gasht_transfer':
                        $ReasonFa = 'رزرو گشت و ترانسفر';
                        break;
                    case 'charge':
                        $ReasonFa = 'شارژحساب';
                        break;
                    case 'price_cancel':
                        $ReasonFa = 'مبلغ کنسلی';
                        break;
                    case 'indemnity_cancel':
                        $ReasonFa = 'استرداد وجه';
                        break;
                    case 'increase':
                        $ReasonFa = 'واریز به حساب شما';
                        break;
                    case 'decrease':
                        $ReasonFa = 'کسر از حساب شما';
                        break;
                    case 'indemnity_edit_ticket':
                        $ReasonFa = 'جریمه اصلاح بلیط';
                        break;
                    case 'diff_price':
                        $ReasonFa = 'واریز تغییر قیمت شناسه نرخی';
                        break;
                    case 'buy_package':
                        $ReasonFa = 'پرواز+ هتل';
                        break;
                    case 'buy_cip':
                        $ReasonFa = 'تشریفات فرودگاه';
                        break;
                    default:
                        $ReasonFa = 'ـــــــ';
                        break;
                }
                $dataRows[$k]['number_column'] = $numberColumn - 1;
                $dataRows[$k]['FactorNumber'] = $transaction['FactorNumber'];
                $dataRows[$k]['Comment'] = $transaction['Comment'];
                if (!empty($transaction['PriceDate'])) {
                    /** @var bookshow $objBook */
                    $objBook = Load::controller('bookshow');
                    $dataRows[$k]['transactionDate'] = $objBook->DateJalali($transaction['PriceDate']);
                } else {
                    $dataRows[$k]['transactionDate'] = dateTimeSetting::jdate($transaction['CreationDateInt']);
                }
                $dataRows[$k]['ReasonFa'] = $ReasonFa;
                if ($transaction['payment_type'] == 'cash') {
                    $dataRows[$k]['payment_type_fa'] = 'نقدی';
                } elseif ($transaction['payment_type'] == 'credit') {
                    $dataRows[$k]['payment_type_fa'] = 'اعتباری';
                } else {
                    $dataRows[$k]['payment_type_fa'] = 'ـــــــ';
                }
                $dataRows[$k]['depositToAccount'] = ($transaction['Status'] == '1') ? $transaction['Price'] : 0;
                $dataRows[$k]['accountDeducted'] = ($transaction['Status'] == '2') ? $transaction['Price'] : 0;
                if ($transaction['Status'] == '1') {
                    $total_transaction_remain_preve = intval($total_transaction_remain_preve) + intval($transaction['Price']);
                } else {
                    $total_transaction_remain_preve = intval($total_transaction_remain_preve) - intval($transaction['Price']);
                }
//                echo $k.'==>'.$transaction['Price'].'==>'.$total_transaction_remain_preve.'<br/>';
                $dataRows[$k]['remain'] = $total_transaction_remain_preve;
                $dataRows[$k]['BankTrackingCode'] = (!empty($transaction['BankTrackingCode'])) ? $transaction['BankTrackingCode'] : 'ـــــــــــــ';

                if (!isset($reportForExcel) || (isset($reportForExcel) && $reportForExcel == 'no')) {

                    $dataRows[$k]['id'] = $transaction['id'];
                    $dataRows[$k]['Reason'] = $transaction['Reason'];
                    $dataRows[$k]['payment_type'] = $transaction['payment_type'];
                    $dataRows[$k]['Status'] = $transaction['Status'];
                    if($this->ClientId !=''){

                        $info_client = $this->getController('partner')->infoClient($this->ClientId);
                        $domain = $info_client['Domain'] ;
                    }else{
                        $domain = CLIENT_DOMAIN ;
                    }
                    $dataRows[$k]['domain_agency'] = $domain  ;
                }
            }
        }

        $dataRows = array_reverse($dataRows);
        $this->list = $dataRows;
    }


    public function allTransactions() {
   

        $clients = $this->getController('partner')->allClients();
        $StartTimeNow = date("Y-m-d");
        $time = time() - (600);
        if (isset($_POST['date_of']) && !empty($_POST['date_of'])) {
            $StartDateExplode = explode('-', $_POST['date_of']);
            $StartPostDate = dateTimeSetting::jalali_to_gregorian($StartDateExplode[0], $StartDateExplode[1], $StartDateExplode[2], '-');
        }
        if (isset($_POST['to_date']) && !empty($_POST['to_date'])) {
            $EndDateExplode = explode('-', $_POST['to_date']);
            $EndPostDate = dateTimeSetting::jalali_to_gregorian($EndDateExplode[0], $EndDateExplode[1], $EndDateExplode[2], '-');
        }



        $sql = "SELECT T.* FROM transaction_tb T WHERE  T.CreationDateInt IS NOT NULL ";

        if(isset($_POST['to_date'])){
            $sql .=" AND ((T.PriceDate >= '{$StartPostDate} 00:00:00' AND T.PriceDate <= '{$EndPostDate} 23:59:59' AND T.PaymentStatus = 'success')
                OR (T.PaymentStatus = 'pending' AND T.CreationDateInt > '{$time}'))";
        }else{
            $sql .=" AND ((T.PriceDate >= '{$StartTimeNow} 00:00:00' AND T.PriceDate <= '{$StartTimeNow} 23:59:59' AND T.PaymentStatus = 'success')
                OR (T.PaymentStatus = 'pending' AND T.CreationDateInt > '{$time}') )";
        }


        if (!empty($_POST['CodeRahgiri']) && $_POST['CodeRahgiri'] > 0) {
            $sql .= " AND T.BankTrackingCode = '{$_POST['CodeRahgiri']}'";
        }


        if (!empty($_POST['FactorNumber']) && $_POST['FactorNumber'] > 0) {
            $sql .= " AND T.FactorNumber= '{$_POST['FactorNumber']}'";
        }
        if (!empty($_POST['Reason'])) {
            $sql .= " AND T.Reason= '{$_POST['Reason']}'";
        }

        $data_rows=[];
        $transactions=[];
        $transactions_final=[];
        $i=0;
        foreach ($clients as $key=>$client) {

            $transactions_client = $this->getController('admin')->ConectDbClient($sql, $client['id'] , "SelectAll", "", "", "");

            if (!empty($transactions_client)) {

                foreach ($transactions_client as $key_transaction => $item) {
                    if (!isset($transactions[$i])) {
                        $transactions[$i] = []; // Initialize $transactions[$i] if it doesn't exist
                    }
                    $transactions[$i][$key_transaction] = $item;
                    $transactions[$i][$key_transaction]['client_name'] = $client['AgencyName'];
                    $transactions[$i][$key_transaction]['domain'] = $client['Domain'];
                }
                $i++; // Increment $i after processing each client's transactions
            }
        }

        foreach ($transactions as $each_transaction) {
            foreach ($each_transaction as $item) {
                $transactions_final[]= $item;
            }

        }

        foreach ($transactions_final as $key_main_sort => $item_sort) {
            $main_sort['CreationDateInt'][] = $item_sort['CreationDateInt'];
        }


        if (!empty($main_sort)) {
            array_multisort($main_sort['CreationDateInt'], SORT_DESC, $transactions_final);
        }

        foreach ($transactions_final as $item) {

            $domain = $item['domain'];
            $factorNumber = $item['FactorNumber'];
            $reason = $item['Reason'];

            // Initialize if not already set
            if (!isset($domainFactorCounts[$domain])) {
                $domainFactorCounts[$domain] = [];
            }

            // Increment the count for the FactorNumber
            if (!isset($domainFactorCounts[$domain][$reason][$factorNumber])) {
                $domainFactorCounts[$domain][$reason][$factorNumber] = 0;
            }
            $domainFactorCounts[$domain][$reason][$factorNumber]++;
        }


        foreach ($transactions_final as $k => $transaction) {

            if($transaction['PaymentStatus']=='success'){
                $numberColumn = $k + 2;

                $data_rows[$k]['color'] = '';
                if($domainFactorCounts[$transaction['domain']][$transaction['Reason']][$transaction['FactorNumber']] > 1 ) {
                    if($transaction['Reason'] == 'buy') {
                        $data_rows[$k]['color'] = 'green';
                    }else if($transaction['Reason'] == 'indemnity_cancel'){
                        $data_rows[$k]['color'] = 'red';
                    }

                }

                switch ($transaction['Reason']) {
                    case 'buy':
                        $ReasonFa = 'خرید بلیط';
                        break;
                    case 'buy_hotel':
                        $ReasonFa = 'رزرو هتل';
                        break;
                    case 'buy_bus':
                        $ReasonFa = 'خرید بلیط اتوبوس';
                        break;
                    case 'buy_reservation_hotel':
                        $ReasonFa = 'رزرو هتل رزرواسیون';
                        break;
                    case 'buy_reservation_ticket':
                        $ReasonFa = 'خرید بلیط رزرواسیون';
                        break;
                    case 'buy_insurance':
                        $ReasonFa = 'رزرو بیمه';
                        break;
                    case 'buy_train':
                        $ReasonFa = 'رزرو قطار';
                        break;
                    case 'buy_gasht_transfer':
                        $ReasonFa = 'رزرو گشت و ترانسفر';
                        break;
                    case 'charge':
                        $ReasonFa = 'شارژحساب';
                        break;
                    case 'price_cancel':
                        $ReasonFa = 'مبلغ کنسلی';
                        break;
                    case 'indemnity_cancel':
                        $ReasonFa = 'استرداد وجه';
                        break;
                    case 'increase':
                        $ReasonFa = 'واریز به حساب شما';
                        break;
                    case 'decrease':
                        $ReasonFa = 'کسر از حساب شما';
                        break;
                    case 'indemnity_edit_ticket':
                        $ReasonFa = 'جریمه اصلاح بلیط';
                        break;
                    case 'diff_price':
                        $ReasonFa = 'واریز تغییر قیمت شناسه نرخی';
                        break;
                    case 'buy_package':
                        $ReasonFa = 'پرواز+ هتل';
                        break;
                        case 'buy_cip':
                    $ReasonFa = 'تشریفات فرودگاه';
                    break;
                    default:
                        $ReasonFa = 'ـــــــ';
                        break;
                }
                $data_rows[$k]['number_column'] = $numberColumn - 1;
                $data_rows[$k]['FactorNumber'] = $transaction['FactorNumber'];
                $data_rows[$k]['Comment'] = $transaction['Comment'];
                $data_rows[$k]['transactionDate'] = dateTimeSetting::jdate("Y-m-d H:i:s",$transaction['CreationDateInt']);
                $data_rows[$k]['ReasonFa'] = $ReasonFa;
                $data_rows[$k]['depositToAccount'] = ($transaction['Status'] == '1') ? $transaction['Price'] : 0;
                $data_rows[$k]['accountDeducted'] = ($transaction['Status'] == '2') ? $transaction['Price'] : 0;

                $data_rows[$k]['BankTrackingCode'] = (!empty($transaction['BankTrackingCode'])) ? $transaction['BankTrackingCode'] : 'ـــــــــــــ';

                if (!isset($reportForExcel) || (isset($reportForExcel) && $reportForExcel == 'no')) {

                    $data_rows[$k]['id']     = $transaction['id'];
                    $data_rows[$k]['Reason'] = $transaction['Reason'];
                    $data_rows[$k]['Status'] = $transaction['Status'];
                    $data_rows[$k]['domain_agency'] = $transaction['domain']  ;
                    $data_rows[$k]['client_name'] = $transaction['client_name']  ;
                }
            }

        }
        
        if($_POST['color'] && $_POST['color']  == 'red') {
            $result = [];

            foreach ($data_rows as $k => $row) {
                if ($row['color'] == 'red') {
                    $result[] = $row;
                }
            }
            $data_rows = $result;


// 2. Group items with same factor number, domain_agency, and specific comment part
            $groupedByFactorDomainComment = [];
            foreach ($data_rows as $item) {
                if($item['domain_agency'] != 'hotelatoir.com'){
                    $key = $item['FactorNumber'] . '_' . $item['domain_agency'] . '_' . substr($item['Comment'], -20);
                    $groupedByFactorDomainComment[$key][] = $item;
                }

            }
            $multipleItemCommentGroups = [] ;
            foreach ($groupedByFactorDomainComment as $key =>  $group) {

                if(count($group) > 1) {
                    $multipleItemCommentGroups[$key] = $group ;
                }
            }

            $data_rows = [] ; 
            foreach ($multipleItemCommentGroups as $factorNumber => $records) {
                foreach ($records as $record) {
                    $data_rows[] = $record;
                }

            }

          
            usort($data_rows, function ($a, $b) {
                if ($a['domain_agency'] === $b['domain_agency']) {
                    // If domains are the same, sort by FactorNumber
                    return strcmp($a['FactorNumber'], $b['FactorNumber']);
                }
                // Otherwise, sort by domain
                return strcmp($a['domain_agency'], $b['domain_agency']);
            });


            $factorColors = [];
            $colorList = ["red", "gray"];
            $colorIndex = 0;

            foreach ($data_rows as &$item) {
                $factorNumber = $item['FactorNumber'];
                if (!isset($factorColors[$factorNumber])) {
                    $factorColors[$factorNumber] = $colorList[$colorIndex % count($colorList)];
                    $colorIndex++;
                }
                // Apply the color to the current item
                $item['color'] = $factorColors[$factorNumber];
            }
            unset($item);

            foreach ($data_rows as $item) {
               $calculates[$item['domain_agency']][] = $item ;
            }
            $total_calculate = [] ;
            foreach($calculates as $key => $client ){
                foreach($client as $counter => $record) {
                    $total_calculate[$key]['amount'] += $record['depositToAccount'];
                }
            }
            return ['result' => $data_rows , 'calculate' => $total_calculate];
        }


        return ['result' => $data_rows];

    }

    //region [insert]
    public function insertCreditUser($info){

        $data_insert_transaction['Price'] = $info['Price'];
        $data_insert_transaction['Comment'] = $info['Comment'];
        $data_insert_transaction['Reason'] = $info['Reason'];
        $data_insert_transaction['PaymentStatus'] = $info['PaymentStatus'];
        $data_insert_transaction['CreationDateInt'] = time();
        $data_insert_transaction['FactorNumber'] = 'TransferCredit' . mt_rand(100000, 999999);
        $data_insert_transaction['PriceDate'] = date("Y-m-d H:i:s");
        $data_insert_transaction['Status'] = $info['status'];

            $result = $this->getModel('transactionModel')->insertLocal($data_insert_transaction);
            $this->transactions->insertTransaction($data_insert_transaction);

        if ($result) {
            return 'success : تراکنش با موفقیت انجام شد';
        }
        return 'error : خطا در ثبت تراکنش ';

    }
    //endregion

}

