<?php
class reportBuyFromIt extends clientAuth
{
    protected $ticket_model;
    protected $hotel_model;
    protected $bus_model;
    protected $insurance_model;
    protected $transaction_model;
    protected $clientsById = [];
    public function __construct() {
        parent::__construct();
        $this->ticket_model = $this->getModel('reportModel');
        $this->hotel_model = $this->getModel('reportHotelModel');
        $this->bus_model = $this->getModel('reportBusModel');
        $this->insurance_model = $this->getModel('reportInsuranceModel');
        $this->transaction_model = $this->getModel('transactionsModel');
        $this->client_model = $this->getModel('clientsModel');
    }
    public function ShowBuysError($TypeList){
        $report_table = $this->ticket_model->getTable();
        $transaction_table = $this->transaction_model->getTable();
        $hotel_table = $this->hotel_model->getTable();
        $bus_table = $this->bus_model->getTable();
        $insurance_table = $this->insurance_model->getTable();

        $ListClientId=$this->ClientsType($TypeList);
        $clientIdString = implode(',', $ListClientId);

        //transaction By Reason
        $arrTransactionIncrease= [];
        $TransactionByReason = $this->transaction_model
            ->get([
                'id',
                'comment'
            ], true)
            ->where('Status', 2)
            ->where('PaymentStatus', 'success')
            ->where('Reason', 'decrease')
            ->all();
        $arrTransactionIncrease = [];
        foreach ($TransactionByReason as $row) {
            $arrTransactionIncrease[] = [
                'id' => $row['id'],
                'comment' => $row['comment']
            ];
        }

        $date_start = '1404-01-01';//az sale 1404/01/01 ra namayesh midahim
        $explode    = explode('-', $date_start);
        $date_of_int = dateTimeSetting::jmktime(
            0, 0, 0,
            $explode[1], // ماه
            $explode[2], // روز
            $explode[0]  // سال
        );
        // پرواز
       /* $reports = $this->ticket_model
            ->get([
                $report_table . '.total_price',
                $report_table . '.creation_date',
                $report_table . '.client_id',
                $report_table . '.factor_number',
                $report_table . '.pnr',
                $transaction_table . '.PaymentStatus',
                $transaction_table . '.id as IdTranc',
                $transaction_table . '.Price'
            ], true)
            ->join($transaction_table, 'FactorNumber', 'factor_number', 'LEFT')
            ->where($report_table . '.request_cancel', 'confirm', '!=')
            ->where($report_table . '.creation_date_int', $date_of_int, '>=')//1401/01/01

            ->openParentheses()   // successfull شرط
                ->where($report_table . '.successfull', 'book')
                ->orWhere($report_table . '.successfull', 'private_reserve')
            ->closeParentheses()

            ->where($report_table . '.serviceTitle', 'Public%', 'LIKE')

                ->openParentheses()   // شرط اصلی تراکنش‌ها
                    ->where($transaction_table . '.id', null, 'IS') // رکورد ندارد
                    ->orWhere($transaction_table . '.PaymentStatus', 'success', '!=') // موفق نیست
                    ->orwhere($transaction_table . '.Price', '0')
                ->closeParentheses()
            ->groupBy('factor_number')
            ->all();*/
       $modelBase = Load::library('ModelBase');

       $sql_query ="SELECT
                            R.total_price,
                            R.creation_date,
                            R.client_id,
                            R.factor_number,
                            R.request_number,
                            R.pnr,
                            T.PaymentStatus,
                            T.id as IdTranc,
                            T.Price
                    FROM  report_tb R LEFT JOIN  transactions T ON (R.factor_number=T.FactorNumber and R.client_id=T.clientID)
                    WHERE 
                         R.request_cancel!='confirm' and   
                         (R.successfull = 'book' or R.successfull = 'private_reserve') and
                         R.serviceTitle like 'Public%' and
                         R.creation_date_int>='".$date_of_int."' and 
                        (
                          T.id IS NULL or
                          (
                            T.Status='2' and
                            (
                               T.Reason like 'buy%' or
                               T.Reason=''
                            ) and 
                            (
                                T.PaymentStatus!='success' or
                                T.Price='0'
                            )
                          )
                        ) and
                        R.client_id IN ($clientIdString)
                     group by  R.request_number     
                     "; //در جدول تراکنش رکورد نداشته باشه یا اگه باشه موفق نباشه یا قیمت نداشته باشه و حتما رکورد خرید باشه
        $result_reports = $modelBase->select($sql_query);
        $reports = [];
        foreach ($result_reports as $k => $parvaz) {
            $result = [];
            $result['total_price']=$parvaz['total_price'];
            $result['client_id']=$parvaz['client_id'];
            $result['factor_number']=$parvaz['factor_number'];
            $result['request_number']=$parvaz['request_number'];
            $result['pnr']=$parvaz['pnr'];
            $result['status_record'] =$parvaz['PaymentStatus'].' - '.$parvaz['IdTranc'].'<br>'.$parvaz['Price'];
            $result['type'] ='پرواز';
            $expPaymentDate = [];
            if (!empty($parvaz['creation_date'])){
                $paymentDate = functions::set_date_payment($parvaz['creation_date']);
                $expPaymentDate = explode(" ", $paymentDate);
                $result['creation_date'] =$expPaymentDate[0];
            }
            $transactionLink = ROOT_ADDRESS_WITHOUT_LANG . '/itadmin/transactionUser&id=' . $parvaz['client_id'];
            $result['agency_name'] = isset($this->clientsById[$parvaz['client_id']]['name']) ? ' <a href="' . $transactionLink . '" data-toggle="tooltip" data-placement="top" data-original-title="مشاهده تراکنش ها" target="_blank">' .  $this->clientsById[$parvaz['client_id']]['name']. '</a>' : 'نامشخص';
            // بررسی وجود شماره فاکتور در کامنت‌ها
            $result['transaction_id'] = $result['transaction_comment'] = ''; // پیش‌فرض خالی
            foreach ($arrTransactionIncrease as $trans) {
                $comment = $trans['comment'];
                $factorPattern = '/(?<!\d)' . preg_quote($parvaz['factor_number'], '/') . '(?!\d)/';
                $requestPattern = '/(?<!\d)' . preg_quote($parvaz['request_number'], '/') . '(?!\d)/';

                if (preg_match($factorPattern, $comment) || preg_match($requestPattern, $comment)) {
                    $result['transaction_id'] = $trans['id']; // ذخیره آیدی تراکنش
                    $result['transaction_comment'] = $comment;
                    break;
                }
            }

            //info table client
            $result['status_record_client'] =$this->InfoClientTransaction($parvaz['client_id'],$parvaz['factor_number'],'buy');

            $reports[] = $result;
        }

        // هتل
        /*$reportHotel = $this->hotel_model
            ->get([
                $hotel_table.'.total_price',
                $hotel_table.'.creation_date_int AS creation_date',
                $hotel_table.'.client_id',
                $hotel_table.'.factor_number',
                $hotel_table.'.request_number',
                $hotel_table . '.pnr',
                $hotel_table . '.voucher_number',
                $transaction_table . '.PaymentStatus',
                $transaction_table . '.id as IdTranc',
                $transaction_table . '.Price'
            ], true)
            ->join($transaction_table, 'FactorNumber', 'factor_number', 'LEFT')
            ->where($hotel_table . '.status', 'BookedSuccessfully')
            ->where($hotel_table . '.serviceTitle', 'Public%', 'LIKE')
            ->where($hotel_table . '.creation_date_int', $date_of_int, '>=')//1401/01/01
            ->openParentheses()   // شرط اصلی تراکنش‌ها
                ->where($transaction_table . '.id', null, 'IS') // رکورد ندارد
                ->orWhere($transaction_table . '.PaymentStatus', 'success', '!=') // موفق نیست
                ->orwhere($transaction_table . '.Price', '0')
            ->closeParentheses()
            ->whereIn($hotel_table.'.client_id',$ListClientId)
            ->groupBy('factor_number')
            ->all();*/
        $sql_query ="SELECT
                            H.total_price,
                            H.creation_date_int AS creation_date,
                            H.client_id,
                            H.factor_number,
                            H.request_number,
                            H.pnr,
                            H.voucher_number,
                            T.PaymentStatus,
                            T.id as IdTranc,
                            T.Price
                    FROM  report_hotel_tb H LEFT JOIN  transactions T ON (H.factor_number=T.FactorNumber and H.client_id=T.clientID)
                    WHERE 
                         H.status = 'BookedSuccessfully' and
                         H.serviceTitle like 'Public%' and
                         H.creation_date_int>='".$date_of_int."' and 
                        (
                          T.id IS NULL or
                          (
                            T.Status='2' and
                            (
                               T.Reason like 'buy%' or
                               T.Reason=''
                            ) and 
                            (
                                T.PaymentStatus!='success' or
                                T.Price='0'
                            )
                          )
                        ) and
                        H.client_id IN ($clientIdString)
                     group by  H.request_number     
                     ";
        $result_Hotel = $modelBase->select($sql_query);
        $reportHotel = [];
        foreach ($result_Hotel as $k => $h) {
            $result = [];
            $result['total_price']=$h['total_price'];
            $result['client_id']=$h['client_id'];
            $result['factor_number']=$h['factor_number'];
            $result['request_number']=$h['request_number'];
            $result['pnr'] = $h['pnr'].'<br> VoucherNumber: '.$h['voucher_number'];
            $result['status_record'] =$h['PaymentStatus'].' - '.$h['IdTranc'].'<br>'.$h['Price'];
            $result['type'] = 'هتل';
            $result['creation_date']= dateTimeSetting::jdate('Y-m-d', $h['creation_date']);
            $transactionLink = ROOT_ADDRESS_WITHOUT_LANG . '/itadmin/transactionUser&id=' . $h['client_id'];
            $result['agency_name'] = isset($this->clientsById[$h['client_id']]['name']) ? ' <a href="' . $transactionLink . '" data-toggle="tooltip" data-placement="top" data-original-title="مشاهده تراکنش ها" target="_blank">' .  $this->clientsById[$h['client_id']]['name']. '</a>' : 'نامشخص';
            // بررسی وجود شماره فاکتور در کامنت‌ها
            $result['transaction_id'] = $result['transaction_comment'] = ''; // پیش‌فرض خالی
            foreach ($arrTransactionIncrease as $trans) {
                $comment = $trans['comment'];
                $factorPattern = '/(?<!\d)' . preg_quote($h['factor_number'], '/') . '(?!\d)/';
                $requestPattern = '/(?<!\d)' . preg_quote($h['request_number'], '/') . '(?!\d)/';

                if (preg_match($factorPattern, $comment) || preg_match($requestPattern, $comment)) {
                    $result['transaction_id'] = $trans['id']; // ذخیره آیدی تراکنش
                    $result['transaction_comment'] = $comment;
                    break;
                }
            }

            //info table client
            $result['status_record_client'] =$this->InfoClientTransaction($h['client_id'],$h['factor_number'],'buy_hotel');

            $reportHotel[]=$result;
        }


        // اتوبوس
        /*$reportBus = $this->bus_model
            ->get([
                $bus_table.'.total_price',
                $bus_table.'.creation_date_int AS creation_date',
                $bus_table.'.client_id',
                $bus_table.'.passenger_factor_num as factor_number',
                $bus_table . '.pnr',
                $transaction_table . '.PaymentStatus',
                $transaction_table . '.id as IdTranc',
                $transaction_table . '.Price'
            ], true)
            ->join($transaction_table, 'FactorNumber', 'passenger_factor_num', 'LEFT')
            ->where($bus_table . '.status', 'book')
            ->where($bus_table . '.WebServiceType', 'public%', 'LIKE')
            ->where($bus_table . '.creation_date_int', $date_of_int, '>=')//1401/01/01
                ->openParentheses()   // شرط اصلی تراکنش‌ها
                    ->where($transaction_table . '.id', null, 'IS') // رکورد ندارد
                    ->orWhere($transaction_table . '.PaymentStatus', 'success', '!=') // موفق نیست
                    ->orwhere($transaction_table . '.Price', '0')
                ->closeParentheses()
            ->whereIn($bus_table.'.client_id',$ListClientId)
            ->groupBy('passenger_factor_num')
            ->all();*/
        $sql_query ="SELECT
                            B.total_price,
                            B.creation_date_int AS creation_date,
                            B.client_id,
                            B.passenger_factor_num as factor_number,
                            B.pnr,
                            T.PaymentStatus,
                            T.id as IdTranc,
                            T.Price
                    FROM  report_bus_tb B LEFT JOIN  transactions T ON (B.passenger_factor_num=T.FactorNumber and B.client_id=T.clientID)
                    WHERE 
                         B.status = 'book' and
                         B.WebServiceType like 'public%' and
                         B.creation_date_int>='".$date_of_int."' and 
                        (
                          T.id IS NULL or
                          (
                            T.Status='2' and
                            (
                               T.Reason like 'buy%' or
                               T.Reason=''
                            ) and 
                            (
                                T.PaymentStatus!='success' or
                                T.Price='0'
                            )
                          )
                        ) and
                        B.client_id IN ($clientIdString)
                     group by  B.passenger_factor_num     
                     ";
        $result_Bus = $modelBase->select($sql_query);
        $reportBus = [];
        foreach ($result_Bus as $k => $b) {
            $result = [];
            $result['total_price']=$b['total_price'];
            $result['client_id']=$b['client_id'];
            $result['factor_number']=$b['factor_number'];
            $result['request_number'] = '';
            $result['pnr'] = $b['pnr'];
            $result['status_record'] =$b['PaymentStatus'].' - '.$b['IdTranc'].'<br>'.$b['Price'];
            $result['type'] = 'اتوبوس';
            $result['creation_date']= dateTimeSetting::jdate('Y-m-d', $b['creation_date']);
            $transactionLink = ROOT_ADDRESS_WITHOUT_LANG . '/itadmin/transactionUser&id=' . $b['client_id'];
            $result['agency_name'] = isset($this->clientsById[$b['client_id']]['name']) ? ' <a href="' . $transactionLink . '" data-toggle="tooltip" data-placement="top" data-original-title="مشاهده تراکنش ها" target="_blank">' .  $this->clientsById[$b['client_id']]['name']. '</a>' : 'نامشخص';
            // بررسی وجود شماره فاکتور در کامنت‌ها
            $result['transaction_id'] = $result['transaction_comment'] = ''; // پیش‌فرض خالی
            foreach ($arrTransactionIncrease as $trans) {
                $comment = $trans['comment'];
                $factorPattern = '/(?<!\d)' . preg_quote($b['factor_number'], '/') . '(?!\d)/';

                if (preg_match($factorPattern, $comment)) {
                    $result['transaction_id'] = $trans['id']; // ذخیره آیدی تراکنش
                    $result['transaction_comment'] = $comment;
                    break;
                }
            }

            //info table client
            $result['status_record_client'] =$this->InfoClientTransaction($b['client_id'],$b['factor_number'],'buy_bus');

            $reportBus[]=$result;
        }

        // بیمه
        /*$reportInsurance = $this->insurance_model
            ->get([
                'SUM('.$insurance_table.'.base_price + '.$insurance_table.'.tax) AS totalPrice',
                $insurance_table.'.creation_date_int AS creation_date',
                $insurance_table.'.client_id',
                $insurance_table.'.factor_number',
                $insurance_table . '.pnr',
                $transaction_table . '.PaymentStatus',
                $transaction_table . '.id as IdTranc',
                $transaction_table . '.Price'
            ], true)
            ->join($transaction_table, 'FactorNumber', 'factor_number', 'LEFT')
            ->where($insurance_table . '.status', 'book')
            ->where($insurance_table . '.serviceTitle', 'Public%', 'LIKE')
            ->where($insurance_table . '.creation_date_int', $date_of_int, '>=')//1401/01/01
                ->openParentheses()   // شرط اصلی تراکنش‌ها
                    ->where($transaction_table . '.id', null, 'IS') // رکورد ندارد
                    ->orWhere($transaction_table . '.PaymentStatus', 'success', '!=') // موفق نیست
                    ->orwhere($transaction_table . '.Price', '0')
                ->closeParentheses()
            ->whereIn($insurance_table.'.client_id',$ListClientId)
            ->groupBy('factor_number')
            ->all();*/
       $sql_query ="SELECT
                            SUM(I.base_price + I.tax) AS totalPrice,
                            I.creation_date_int AS creation_date,
                            I.client_id,
                            I.factor_number,
                            I.pnr,
                            T.PaymentStatus,
                            T.id as IdTranc,
                            T.Price
                    FROM  report_insurance_tb I LEFT JOIN  transactions T ON (I.factor_number=T.FactorNumber and I.client_id=T.clientID)
                    WHERE 
                         I.status = 'book' and
                         I.serviceTitle like 'Public%' and
                         I.creation_date_int>='".$date_of_int."' and 
                        (
                          T.id IS NULL or
                          (
                            T.Status='2' and
                            (
                               T.Reason like 'buy%' or
                               T.Reason=''
                            ) and 
                            (
                                T.PaymentStatus!='success' or
                                T.Price='0'
                            )
                          )
                        ) and
                        I.client_id IN ($clientIdString)
                     group by  I.factor_number     
                     ";
        $result_Ins = $modelBase->select($sql_query);
        $reportInsurance = [];
        foreach ($result_Ins as $k => $i) {
            $result = [];
            $result['total_price']=$i['total_price'];
            $result['client_id']=$i['client_id'];
            $result['factor_number']=$i['factor_number'];
            $result['request_number'] = '';
            $result['pnr'] = $i['pnr'];
            $result['status_record'] =$i['PaymentStatus'].' - '.$i['IdTranc'].'<br>'.$i['Price'];
            $result['type'] = 'بیمه';
            $result['creation_date']= dateTimeSetting::jdate('Y-m-d', $i['creation_date']);
            $transactionLink = ROOT_ADDRESS_WITHOUT_LANG . '/itadmin/transactionUser&id=' . $i['client_id'];
            $result['agency_name'] = isset($this->clientsById[$i['client_id']]['name']) ? ' <a href="' . $transactionLink . '" data-toggle="tooltip" data-placement="top" data-original-title="مشاهده تراکنش ها" target="_blank">' .  $this->clientsById[$i['client_id']]['name']. '</a>' : 'نامشخص';
            // بررسی وجود شماره فاکتور در کامنت‌ها
            $result['transaction_id'] = $result['transaction_comment'] = ''; // پیش‌فرض خالی
            foreach ($arrTransactionIncrease as $trans) {
                $comment = $trans['comment'];
                $factorPattern = '/(?<!\d)' . preg_quote($i['factor_number'], '/') . '(?!\d)/';

                if (preg_match($factorPattern, $comment)) {
                    $result['transaction_id'] = $trans['id']; // ذخیره آیدی تراکنش
                    $result['transaction_comment'] = $comment;
                    break;
                }
            }
            //info table client
            $result['status_record_client'] =$this->InfoClientTransaction($i['client_id'],$i['factor_number'],'buy_insurance');

            $reportInsurance[]=$result;
        }

        $all = array_merge($reports, $reportHotel, $reportBus, $reportInsurance);
        /*
        // فیلتر تاریخ از 1404/01/01 به بعد (معادل میلادی)
        $threshold_date ='1404/01/01';

        $all = array_filter($all, function($item) use ($threshold_date) {
            return strtotime($item['creation_date']) >= strtotime($threshold_date);
        });
        */
        // مرتب‌سازی بر اساس تاریخ
        usort($all, function($a, $b) {
            $a_date = explode('-', $a['creation_date']);
            $b_date = explode('-', $b['creation_date']);

            $a_ts = dateTimeSetting::jmktime(0, 0, 0, $a_date[1], $a_date[2], $a_date[0]);
            $b_ts = dateTimeSetting::jmktime(0, 0, 0, $b_date[1], $b_date[2], $b_date[0]);

            return $b_ts - $a_ts;
        });

        return $all;
    }

    public function TransactionRecordReport(){
        $clients = $this->client_model
            ->get([
                'id',
                'AgencyName'
            ])
            ->all();

        $clientsById = [];
        foreach ($clients as $c) {
            $clientsById[$c['id']]= $c['AgencyName'];
        }

        //transaction By Comment Like /after book
        $TransactionByComment = $this->transaction_model
            ->get([
                'clientID',
                'FactorNumber',
                'comment',
                'Reason',
                'PriceDate'
            ], true)
            ->where('Status', 2)
            ->where('PaymentStatus', 'success')
            ->where('comment','%/after book%','like')
            ->all();
        $arrTransaction = [];
        foreach ($TransactionByComment as $row) {
            $expPaymentDate = [];
            $paymentDate = functions::set_date_payment(substr($row['PriceDate'],0,10));
            $expPaymentDate = explode(" ", $paymentDate);
            $transactionLink = ROOT_ADDRESS_WITHOUT_LANG . '/itadmin/transactionUser&id=' . $row['clientID'];
            $arrTransaction[] = [
                'agency_name'        => isset($clientsById[$row['clientID']]) ? '<a href="' . $transactionLink . '" data-toggle="tooltip" data-placement="top" data-original-title="مشاهده تراکنش ها" target="_blank">' .  $clientsById[$row['clientID']]. '</a>' : 'نامشخص',
                'factor_number'      => $row['FactorNumber'],
                'PriceDate'          => $expPaymentDate[0],
                'type'               => $this->mapReasonToType($row['Reason']),
                'transaction_comment'=> $row['comment']
            ];
        }

        // مرتب‌سازی بر اساس تاریخ
        usort($arrTransaction, function($a, $b) {
            $a_date = explode('-', $a['PriceDate']);
            $b_date = explode('-', $b['PriceDate']);

            $a_ts = dateTimeSetting::jmktime(0, 0, 0, $a_date[1], $a_date[2], $a_date[0]);
            $b_ts = dateTimeSetting::jmktime(0, 0, 0, $b_date[1], $b_date[2], $b_date[0]);

            return $b_ts - $a_ts;
        });

        return $arrTransaction;
    }

    public function DuplicateIndemnityCancelReport($TypeList)
    {
        // گرفتن لیست آژانس‌ها
        $ListClientId = $this->ClientsType($TypeList);

        // گرفتن همه تراکنش‌های استرداد وجه موفق با شرط Status=1
        $transactions = $this->transaction_model
            ->get([
                'clientID',
                'FactorNumber',
                'comment',
                'PriceDate'
            ], true)
            ->where('Reason', 'indemnity_cancel')
            ->where('PaymentStatus', 'success')
            ->where('Status', 1)
            ->openParentheses()   // successfull شرط
                ->where('PriceDate', '2025-03-21 00:00:00','>=')//az sale 1404/01/01
                ->orWhere('PriceDate', '')
            ->closeParentheses()
            ->whereIn('clientID', $ListClientId)
            ->orderby('FactorNumber')
            ->all();

        // شمارش تعداد هر ترکیب (نام دیتابیس + شماره فاکتور)
        $factorCount = [];
        foreach ($transactions as $row) {
            $key = $this->clientsById[$row['clientID']]['DbName'] . '_' . $row['FactorNumber'];
            if (!isset($factorCount[$key])) {
                $factorCount[$key] = 0;
            }
            $factorCount[$key]++;
        }

        // انتخاب فقط یک رکورد برای هر ترکیب تکراری
        $arrTransaction = [];
        $addedKeys = []; // کلیدهایی که قبلاً اضافه شده‌اند
        foreach ($transactions as $row) {
            $key = $this->clientsById[$row['clientID']]['DbName'] . '_' . $row['FactorNumber'];
            if ($factorCount[$key] > 1 && !isset($addedKeys[$key])) {
                $paymentDate = functions::set_date_payment(substr($row['PriceDate'], 0, 10));
                $expPaymentDate = explode(" ", $paymentDate);
                $transactionLink = ROOT_ADDRESS_WITHOUT_LANG . '/itadmin/transactionUser&id=' . $row['clientID'];
                $arrTransaction[] = [
                    'agency_name'        => isset($this->clientsById[$row['clientID']]['name']) ? '<a href="' . $transactionLink . '" data-toggle="tooltip" data-placement="top" data-original-title="مشاهده تراکنش ها" target="_blank">' .  $this->clientsById[$row['clientID']]['name']. '</a>' : 'نامشخص',
                    'factor_number'      => $row['FactorNumber'],
                    'PriceDate'          => $expPaymentDate[0],
                    'transaction_comment'=> $row['comment']
                ];

                $addedKeys[$key] = true; // ثبت کلید به عنوان اضافه‌شده
            }
        }

        // مرتب‌سازی بر اساس تاریخ
        usort($arrTransaction, function($a, $b) {
            $a_date = explode('-', $a['PriceDate']);
            $b_date = explode('-', $b['PriceDate']);

            $a_ts = dateTimeSetting::jmktime(0, 0, 0, $a_date[1], $a_date[2], $a_date[0]);
            $b_ts = dateTimeSetting::jmktime(0, 0, 0, $b_date[1], $b_date[2], $b_date[0]);

            return $b_ts - $a_ts;
        });

        return $arrTransaction;
    }

    private function ClientsType($TypeList)
    {
        $clients = $this->client_model
            ->get([
                'id',
                'AgencyName',
                'archived_at',
                'DbName'
            ])
            ->all();

        $ListIdArchived=[];
        $ListIdActive=[];
        foreach ($clients as $c) {
            $this->clientsById[$c['id']]['name'] = $c['AgencyName'];
            $this->clientsById[$c['id']]['DbName'] = $c['DbName'];
            if(!empty($c['archived_at']))
                $ListIdArchived[]=$c['id'];
            else
                $ListIdActive[]=$c['id'];
        }
        if($TypeList=='Active')$ListClientId=$ListIdActive;
        else if($TypeList=='Archived') $ListClientId=$ListIdArchived;

        return $ListClientId;
    }

    private function mapReasonToType($reason)
    {
        $map = [
            'buy'                     => 'پرواز',
            'buy_hotel'               => 'هتل',
            'buy_reservation_hotel'   => 'رزرو هتل',
            'buy_insurance'           => 'بیمه',
            'buy_bus'                 => 'اتوبوس',
        ];

        return isset($map[$reason]) ? $map[$reason] : $reason;
    }

    private function InfoClientTransaction($client_id,$factor_number,$Reason)
    {
        //info table client
        $InfoClientSql = "SELECT 
                                    id,                                
                                    PaymentStatus,
                                    Price
                              FROM 
                                    transaction_tb
                              WHERE 
                                  FactorNumber='".$factor_number."' and 
                                  Status='2' and 
                                  (Reason='".$Reason."' or Reason='')
                                 ";
        $InfoClientRes = $this->getController('admin')
            ->ConectDbClient($InfoClientSql, $client_id, "Select", "", "");
        return ($InfoClientRes['PaymentStatus'].' - '.$InfoClientRes['id'].'<br>'.$InfoClientRes['Price']);

    }
}
