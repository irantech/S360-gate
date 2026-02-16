<?php

class transactions extends clientAuth
{
    public static $admin;
    public static $reports = [];
    public $total_charge = 0;
    public $total_buy = 0;
    public $total_transaction = 0;
    public $is_search = 0;
    public $total_charge_search = 0;
    public $total_buy_search = 0;
    public $total_transaction_search = 0;
    public $remain_prev = 0;

    public $apiAddress;
    public $transactions;
    public function __construct() {
        self::$admin =  Load::controller('admin');
        $this->modelTransactions = $this->getModel('transactionsModel');
        $this->apiAddress = functions::UrlSource();
        $this->transactions = $this->getModel('transactionsModel');
    }


    public function index()
    {

        // die(json_encode($this->mergeTransactionsAndSort()));
        $res = [];
        try {

            foreach ( $this->mergeTransactionsAndSort() as $key => $value)
            {
                $res[] = $this->insertToTB($value);
            }
            echo json_encode(['status' => 'success','message'=> 'saved records!','result' => $res]);

        }
        catch (Exception $e)
        {
            echo json_encode(['status' => 'error','message'=> $e]);
        }

    }

    public function insertToTB($array)
    {

        if(is_null($array['PriceDate']))
        {
            $year = 'p_null_year';
        }else
        {
            $date = new DateTime($array['PriceDate']);
            $year = $date->format('Y');
        }

        $created_at = date("Y-m-d H:i:s", $array['CreationDateInt']);
        $updated_at = date("Y-m-d H:i:s", $array['LastEditInt']);


        $clientID = $array[0]['clientID'];
        $price = $array['Price'];
        $payment_date = $array['PriceDate'];
        $factor_number = $array['FactorNumber'];
        $status = (string)$array['status'];
        $reason = $array['Reason'];
        $comment = $array['Comment'];
        $tracking_code = $array['BankTrackingCode'];
        $payment_status = (string)$array['PaymentStatus'];
        $creation_date_int = $array['CreationDateInt'];
        $last_edit_int = $array['LastEditInt'];
        $created_at = (string)$created_at;
        $updated_at = (string)$updated_at;


        $data = [
            'clientID' => $clientID,
            'price' => $price,
            'PriceDate' => $payment_date,
            'FactorNumber' => $factor_number,
            'status' => $status,
            'reason' => $reason,
            'comment' => $comment,
            'BankTrackingCode' => $tracking_code,
            'PaymentStatus' => $payment_status,
            'CreationDateInt' => $creation_date_int,
            'LastEditInt' => $last_edit_int,
            'year' => $year,
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ];
        $this->modelTransactions->insertWithBind($data);
    }

    public function mergeTransactionsAndSort()
    {
        foreach ($this->clients() as $client) {

            self::$reports[$client['id']] =
                [
                    'ClientID' => $client['id'],
                    'transactions' => $this->transactions($client['id'])
                ];
        }

        $allTransactions = [];
        foreach (self::$reports as $client) {
            $allTransactions = array_merge($allTransactions, $client['transactions']);
        }
        usort($allTransactions, function($a, $b) {

            $dateA = strtotime($a['PriceDate']);
            $dateB = strtotime($b['PriceDate']);
            return  $dateA - $dateB;
        });

        return $allTransactions;
    }

    public function addClientID($array,$clientID)
    {
        $result = [];
        foreach ($array as $key => $val)
        {
            array_push($val,['clientID' => $clientID]);
            $result[] = $val;
        }
        return $result;
    }
    public function transactions($clientID)
    {
        $sql = "SELECT * FROM transaction_tb";
        return $this->addClientID($this->connector($sql,$clientID),$clientID);
    }
    public function connector($sql,$clientID)
    {
        return self::$admin->ConectDbClient($sql,$clientID, "SelectAll", "", "", "");
    }

    public function clients()
    {
        $model = $this->getModel('clientsModel');
        $result = $model->get("id", true);
        $sql = $result->toSql();
        return $result->all();
    }

    public function getAllTransactions(){

        $params = $_POST ;
        $Model = Load::library('ModelBase');

        $EndPostDate = $StartTimeNow = date("Y-m-d");
        $time = time() - (600);

        $StartPostDate = $SevenDaysAgo = date('Y-m-d', strtotime(" -0 days"));

        if (!empty($params['date_of'])) {
            $StartDateExplode = explode('-', $_POST['date_of']);
            $StartPostDate = dateTimeSetting::jalali_to_gregorian($StartDateExplode[0], $StartDateExplode[1], $StartDateExplode[2], '-');
        }
        if (!empty($params['to_date'])) {
            $EndDateExplode = explode('-', $_POST['to_date']);
            $EndPostDate = dateTimeSetting::jalali_to_gregorian($EndDateExplode[0], $EndDateExplode[1], $EndDateExplode[2], '-');
        }

        $sql = "SELECT 
    t.*,  clients_tb.AgencyName as client_name ,

    CASE 
        WHEN (t.Reason = 'buy' or t.Reason = 'buy_reservation_ticket') THEN report_tb.origin_city
        ELSE NULL
    END AS origin_city,

    CASE 
        WHEN (t.Reason = 'buy' or t.Reason = 'buy_reservation_ticket') THEN report_tb.desti_city
        WHEN (t.Reason = 'buy_hotel' OR t.Reason = 'buy_reservation_hotel') THEN report_hotel_tb.city_name
        ELSE NULL
    END AS destination_city,
		
    CASE 
        WHEN (t.Reason = 'buy' or t.Reason = 'buy_reservation_ticket') THEN report_tb.pid_private
    
        ELSE NULL
    END AS private,
    
    	
    CASE 
        WHEN (t.Reason = 'buy' or t.Reason = 'buy_reservation_ticket') THEN report_tb.date_flight
        WHEN (t.Reason = 'buy_hotel' OR t.Reason = 'buy_reservation_hotel') THEN report_hotel_tb.start_date
        WHEN t.Reason = 'buy_bus'  THEN report_bus_tb.DateMove
        WHEN t.Reason = 'buy_train'  THEN report_train_tb.MoveDate
        WHEN t.Reason = 'buy_gasht_transfer'  THEN report_gasht_tb.passenger_entryDate
        ELSE NULL
    END AS service_date,

    CASE 
        WHEN (t.Reason = 'buy' or t.Reason = 'buy_reservation_ticket') THEN report_tb.api_id
        WHEN (t.Reason = 'buy_hotel' OR t.Reason = 'buy_reservation_hotel') THEN report_hotel_tb.source_id
        WHEN t.Reason = 'buy_bus' THEN report_bus_tb.SourceName
        WHEN t.Reason = 'buy_insurance' THEN report_insurance_tb.source_name_fa
        ELSE NULL
    END AS source,
 CASE 
        WHEN (t.Reason = 'buy' or t.Reason = 'buy_reservation_ticket') THEN report_tb.total_price
        WHEN (t.Reason = 'buy_hotel' OR t.Reason = 'buy_reservation_hotel') THEN report_hotel_tb.total_price
        WHEN t.Reason = 'buy_bus' THEN report_bus_tb.total_price
        WHEN t.Reason = 'buy_train' THEN report_train_tb.FullPrice
        WHEN t.Reason = 'buy_insurance' THEN report_insurance_tb.paid_price
        WHEN t.Reason = 'buy_gasht_transfer' THEN report_insurance_tb.paid_price
        ELSE NULL
    END AS customer_price,

 CASE 
        WHEN (t.Reason = 'buy' or t.Reason = 'buy_reservation_ticket') THEN report_tb.pid_private
        WHEN (t.Reason = 'buy_hotel' OR t.Reason = 'buy_reservation_hotel') THEN report_hotel_tb.serviceTitle
        WHEN t.Reason = 'buy_bus' THEN report_bus_tb.WebServiceType
        WHEN t.Reason = 'buy_insurance' THEN report_insurance_tb.serviceTitle
        WHEN t.Reason = 'buy_reservation_tour' THEN report_insurance_tb.serviceTitle
        ELSE NULL
    END AS publicOrPrivate

        
FROM transactions t

LEFT JOIN clients_tb  
ON t.clientID = clients_tb.id
    
LEFT JOIN report_tb  
    ON t.FactorNumber = report_tb.factor_number AND (t.Reason = 'buy' OR t.Reason = 'buy_reservation_ticket')

LEFT JOIN report_hotel_tb 
    ON t.FactorNumber = report_hotel_tb.factor_number AND (t.Reason = 'buy_hotel' OR t.Reason = 'buy_reservation_hotel')

LEFT JOIN report_bus_tb 
    ON t.FactorNumber = report_bus_tb.passenger_factor_num AND t.Reason = 'buy_bus'
    
LEFT JOIN report_insurance_tb 
    ON t.FactorNumber = report_insurance_tb.factor_number AND t.Reason = 'buy_insurance'
    
LEFT JOIN report_train_tb 
    ON t.FactorNumber = report_train_tb.factor_number AND t.Reason = 'buy_train'
    
LEFT JOIN report_gasht_tb  
    ON t.FactorNumber = report_gasht_tb.passenger_factor_num AND t.Reason = 'buy_gasht_transfer'
         WHERE 1=1 " ;


        if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {
            $sql .= " AND ( (t.PriceDate >= '{$StartPostDate} 00:00:00 ' AND t.PriceDate <= '{$EndPostDate} 23:59:59')
                OR (t.PaymentStatus = 'pending' AND t.CreationDateInt > '{$time}'))";
        }
        else {
            $sql .= " AND ((t.PaymentStatus = 'success') AND (t.PriceDate <= '{$StartTimeNow} 23:59:59' AND
                     t.PriceDate  >= '{$SevenDaysAgo} 00:00:00')
                    OR (t.PaymentStatus = 'pending' AND t.CreationDateInt > '{$time}' ))";

        }


        if (!empty($_POST['CodeRahgiri']) && $_POST['CodeRahgiri'] > 0) {
            $sql .= " AND t.BankTrackingCode = '{$_POST['CodeRahgiri']}'";
        }


        if (!empty($_POST['FactorNumber']) && $_POST['FactorNumber'] > 0) {
            $sql .= " AND t.FactorNumber= '{$_POST['FactorNumber']}'";
        }
        $Reason = !empty($_POST['Reason']) ? $_POST['Reason'] : 'buy';
        if ($_POST['Reason'] != 'all') {
            if($_POST['Reason']=='buy'){
                $sql .= " AND (t.Reason= 'buy' OR t.Reason= 'buy_hotel' OR t.Reason= 'buy_insurance' OR t.Reason= 'buy_reservation_hotel' OR t.Reason= 'buy_reservation_ticket' OR t.Reason= 'buy_foreign_hotel'
                    OR t.Reason= 'buy_Europcar' OR t.Reason= 'buy_reservation_tour' OR t.Reason= 'buy_reservation_visa' OR t.Reason= 'buy_gasht_transfer' OR t.Reason= 'buy_train' OR t.Reason= 'buy_bus' OR t.Reason= 'buy_entertainment' OR t.Reason= 'buy_visa_plan' OR t.Reason= 'buy_package' ) ";
            }else{
                $sql .= " AND (t.Reason='{$Reason}') ";
            }
        }
        $sql .= 'GROUP BY id ORDER BY t.PriceDate ASC' ;

        $transactions = $Model->select($sql);

//        $sql_remain_prev = "SELECT SUM(Price) AS sum_price FROM  transactions  WHERE PriceDate IS NOT NULL AND (( PaymentStatus = 'success' ) AND PriceDate <= '{$StartPostDate} 00:00:00' )  GROUP BY `Status`" ;
//        $sum_price  = $Model->select($sql_remain_prev);


        $sql_charge = "SELECT sum(Price) AS total_charge FROM transactions WHERE Status='1' AND PaymentStatus = 'success'";


        $sql_buy = "SELECT SUM(Price) AS total_buy FROM transactions WHERE Status='2' AND"
            . " ((PaymentStatus = 'success') OR (PaymentStatus = 'pending' AND CreationDateInt > '{$time}')  ) ";

        $charge = $Model->select($sql_charge);
        $this->total_charge = $charge[0]['total_charge'];

        $buy = $Model->select($sql_buy);
        $this->total_buy = $buy[0]['total_buy'];
        $this->total_transaction = $this->total_charge - $this->total_buy;

        $this->is_search = false ;



        if((isset($_POST['flag']) && $_POST['flag']=='newCreateExcelFileForTransactionUser'))
        {

            $sql_charge_search = " SELECT SUM(Price) AS total_charge FROM transactions WHERE Status='1' AND PaymentStatus = 'success'  ";

            $sql_buy_search = " SELECT SUM(Price) AS total_buy FROM transactions WHERE Status='2' AND ((PaymentStatus = 'success') OR (PaymentStatus = 'pending' AND CreationDateInt > '{$time}')  )  ";

            if (!empty($_POST['to_date'])) {
                $sql_charge_search .=" AND PriceDate >= '{$StartPostDate} 00:00:00' AND PriceDate <= '{$EndPostDate} 23:59:59'";
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
                    OR Reason= 'buy_Europcar' OR Reason= 'buy_reservation_tour' OR Reason= 'buy_reservation_visa' OR Reason= 'buy_gasht_transfer' OR Reason= 'buy_train' OR Reason= 'buy_bus' OR Reason= 'buy_entertainment' OR Reason= 'buy_visa_plan' OR Reason= 'buy_package' ) ";
                }else{
                    $sql_buy_search .= " AND (Reason='{$_POST['Reason']}') ";
                }

                $sql_charge_search .= " AND Reason= '{$_POST['Reason']}'";
            }

            $buy_search = $Model->select($sql_buy_search);
            $charge_search = $Model->select($sql_charge_search);

            $sql_remain_prev = "SELECT SUM(Price) AS sum_price FROM  transactions  WHERE PriceDate IS NOT NULL AND (( PaymentStatus = 'success' ) AND PriceDate <= '{$StartPostDate} 00:00:00' )  GROUP BY `Status`" ;

            $total_remain_prev = $Model->select($sql_remain_prev);

            $total_transaction_search = $charge_search[0]['total_charge'] - $buy_search[0]['total_buy'] ;
            $this->total_transaction_search = $total_transaction_search;
            $this->total_charge_search = $charge_search[0]['total_charge'];
            $this->total_buy_search = $buy_search[0]['total_buy'];
            $this->is_search = true;

        }



        $total_transaction_remain = $total_remain_prev[0]['sum_price'] - $total_remain_prev[1]['sum_price']  ;
        $this->remain_prev = $total_transaction_remain;

        $result = [] ;

        foreach ($transactions as $transaction) {
            if ($transaction['PaymentStatus'] == 'success') {
                $depositToAccount = ($transaction['Status'] == '1') ? $transaction['Price'] : 0;
                $accountDeducted = ($transaction['Status'] == '2') ? $transaction['Price'] : 0;

                if ($transaction['Status'] == '1') {
                    $total_transaction_remain = intval($total_transaction_remain) + intval($transaction['Price']);
                } else {
                    $total_transaction_remain = intval($total_transaction_remain) - intval($transaction['Price']);
                }

                $result[] = [
                    'id'                   => $transaction['id'] ,
                    'client_name'          => $transaction['client_name'] ,
                    'Reason'               => $transaction['Reason'] ,
                    'client_id'            => $transaction['clientID'] ,
                    'price'                => $transaction['Price'] ,
                    'factor_number'        => $transaction['FactorNumber'] ,
                    'service'              => self::getService($transaction['Reason']),
                    'cacheOrCredit'        => self::checkTransactionCacheOrCredit($transaction['BankTrackingCode']),
                    'publicOrPrivate'      => self::getPublicPrivate($transaction['publicOrPrivate']),
                    'type'                 => self::getTransactionType($transaction['Reason']),
                    'comment'              => $transaction['Comment'],
                    'date'                 => dateTimeSetting::jdate("Y-m-d H:i:s",$transaction['CreationDateInt']),
                    'service_date'         => $transaction['service_date'],
                    'origin'               => $transaction['origin_city'],
                    'destination'          => $transaction['destination_city'],
                    'customer_price'       => $transaction['customer_price'],
                    'source'               => self::getSourceName($transaction['source']),
                    'depositToAccount'     => $depositToAccount,
                    'accountDeducted'      => $accountDeducted,
                    'remain'               => $total_transaction_remain,
                ];
            }
        }
        return array_reverse($result);
    }

    public function getAllProviderTransactions()
    {
        $params = $_POST ;
        $getParams = $_GET;
        $api_id = $getParams['api_id'];
        $type = $getParams['sourceType'];
        $Model = Load::library('ModelBase');
        $EndPostDate = $StartTimeNow = date("Y-m-d");
        $time = time() - (600);
        $SevenDaysAgo = date('Y-m-d', strtotime(" -7 days"));
        if (!empty($params['date_of'])) {
            $StartDateExplode = explode('-', $_POST['date_of']);
            $StartPostDate = dateTimeSetting::jalali_to_gregorian($StartDateExplode[0], $StartDateExplode[1], $StartDateExplode[2], '-');
        }
        if (!empty($params['to_date'])) {
            $EndDateExplode = explode('-', $_POST['to_date']);
            $EndPostDate = dateTimeSetting::jalali_to_gregorian($EndDateExplode[0], $EndDateExplode[1], $EndDateExplode[2], '-');
        }

        $sql = "SELECT 
    t.*,  clients_tb.AgencyName as client_name ,

    CASE 
        WHEN (report_tb.id is not null) THEN report_tb.origin_city
        ELSE NULL
    END AS origin_city,

    CASE 
        WHEN (report_tb.id is not null) THEN report_tb.desti_city
        WHEN (report_hotel_tb.id is not null) THEN report_hotel_tb.city_name
        ELSE NULL
    END AS destination_city,
		
    CASE 
        WHEN (t.Reason = 'buy' or t.Reason = 'buy_reservation_ticket') THEN report_tb.pid_private
    
        ELSE NULL
    END AS private,
    
    	
    CASE 
        WHEN (report_tb.id is not null) THEN report_tb.date_flight
        WHEN (report_hotel_tb.id is not null) THEN report_hotel_tb.start_date
        WHEN t.Reason = 'buy_bus'  THEN report_bus_tb.DateMove
        WHEN t.Reason = 'buy_train'  THEN report_train_tb.MoveDate
        WHEN t.Reason = 'buy_gasht_transfer'  THEN report_gasht_tb.passenger_entryDate
        ELSE NULL
    END AS service_date,

    CASE 
        WHEN (report_tb.id is not null) THEN report_tb.api_id
        WHEN (report_hotel_tb.id is not null) THEN report_hotel_tb.source_id
        WHEN t.Reason = 'buy_bus' THEN report_bus_tb.SourceName
        WHEN t.Reason = 'buy_insurance' THEN report_insurance_tb.source_name_fa
        ELSE NULL
    END AS source,
 CASE 
        WHEN (t.Reason = 'buy' or t.Reason = 'buy_reservation_ticket') THEN report_tb.total_price
        WHEN (t.Reason = 'buy_hotel' OR t.Reason = 'buy_reservation_hotel') THEN report_hotel_tb.total_price
        WHEN t.Reason = 'buy_bus' THEN report_bus_tb.total_price
        WHEN t.Reason = 'buy_train' THEN report_train_tb.FullPrice
        WHEN t.Reason = 'buy_insurance' THEN report_insurance_tb.paid_price
        WHEN t.Reason = 'buy_gasht_transfer' THEN report_insurance_tb.paid_price
        ELSE NULL
    END AS customer_price,

 CASE 
        WHEN (report_tb.id is not null) THEN report_tb.pid_private
        WHEN (report_hotel_tb.id is not null) THEN report_hotel_tb.serviceTitle
        WHEN t.Reason = 'buy_bus' THEN report_bus_tb.WebServiceType
        WHEN t.Reason = 'buy_insurance' THEN report_insurance_tb.serviceTitle
        WHEN t.Reason = 'buy_reservation_tour' THEN report_insurance_tb.serviceTitle
        ELSE NULL
    END AS publicOrPrivate,
 CASE 
        WHEN (report_tb.id is not null) THEN report_tb.pnr
        WHEN (report_hotel_tb.id is not null) THEN report_hotel_tb.pnr
        WHEN t.Reason = 'buy_bus' THEN report_bus_tb.pnr
        WHEN t.Reason = 'buy_insurance' THEN report_insurance_tb.pnr
        WHEN t.Reason = 'buy_reservation_tour' THEN report_insurance_tb.pnr
        ELSE NULL
    END AS pnr
FROM transactions t

LEFT JOIN clients_tb  
ON t.clientID = clients_tb.id
    
LEFT JOIN report_tb  
    ON t.FactorNumber = report_tb.factor_number 

LEFT JOIN report_hotel_tb 
    ON t.FactorNumber = report_hotel_tb.factor_number 

LEFT JOIN report_bus_tb 
    ON t.FactorNumber = report_bus_tb.passenger_factor_num AND t.Reason = 'buy_bus'
    
LEFT JOIN report_insurance_tb 
    ON t.FactorNumber = report_insurance_tb.factor_number AND t.Reason = 'buy_insurance'
    
LEFT JOIN report_train_tb 
    ON t.FactorNumber = report_train_tb.factor_number AND t.Reason = 'buy_train'


LEFT JOIN report_gasht_tb  
    ON t.FactorNumber = report_gasht_tb.passenger_factor_num AND t.Reason = 'buy_gasht_transfer'
         WHERE 1=1 " ;


        if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {
            $sql .= " AND ( (t.PriceDate >= '{$StartPostDate} 00:00:00 ' AND t.PriceDate <= '{$EndPostDate} 23:59:59')
                OR (t.PaymentStatus = 'pending' AND t.CreationDateInt > '{$time}'))";
        }
        else {
            $sql .= " AND ( (t.PriceDate >= '{$SevenDaysAgo} 00:00:00 ' AND t.PriceDate <= '{$EndPostDate} 23:59:59')
                OR (t.PaymentStatus = 'pending' AND t.CreationDateInt > '{$time}'))";

        }

        if(!empty($api_id)){
            $sql .= " AND (
            CASE
               WHEN (report_tb.id IS NOT NULL) THEN report_tb.api_id
               WHEN (report_hotel_tb.id IS NOT NULL) THEN report_hotel_tb.source_id
               WHEN t.Reason = 'buy_bus' THEN report_bus_tb.SourceName
               WHEN t.Reason = 'buy_insurance' THEN report_insurance_tb.source_name_fa
               ELSE NULL
            END = $api_id OR t.api_id = $api_id
                            )";
        }
        if($type == 'flight'){
            $sql .= " AND (report_tb.id is not null OR t.sourceType = $type) ";
        }
        if($type == 'hotel'){
            $sql .= " AND (report_hotel_tb.id is not null OR t.api_id = $api_id) ";
        }
        if($type == 'bus'){
            $sql .= " AND (report_bus_tb.id is not null OR t.sourceType = $type) ";
        }
        if($type == 'train'){
            $sql .= " AND (report_train_tb.id is not null OR t.sourceType = $type) ";
        }



        if (!empty($_POST['CodeRahgiri']) && $_POST['CodeRahgiri'] > 0) {
            $sql .= " AND t.BankTrackingCode = '{$_POST['CodeRahgiri']}'";
        }


        if (!empty($_POST['FactorNumber']) && $_POST['FactorNumber'] > 0) {
            $sql .= " AND t.FactorNumber= '{$_POST['FactorNumber']}'";
        }
        $Reason = !empty($_POST['Reason']) ? $_POST['Reason'] : "all";

        if ($Reason != 'all') {
            if($_POST['Reason']=='buy'){
                $sql .= " AND (t.Reason= 'buy' OR t.Reason= 'buy_hotel' OR t.Reason= 'buy_insurance' OR t.Reason= 'buy_reservation_hotel' OR t.Reason= 'buy_reservation_ticket' OR t.Reason= 'buy_foreign_hotel'
                    OR t.Reason= 'buy_Europcar' OR t.Reason= 'buy_reservation_tour' OR t.Reason= 'buy_reservation_visa' OR t.Reason= 'buy_gasht_transfer' OR t.Reason= 'buy_train' OR t.Reason= 'buy_bus' OR t.Reason= 'buy_entertainment' OR t.Reason= 'buy_visa_plan' OR t.Reason= 'buy_package' ) ";
            }else{
                $sql .= " AND (t.Reason='{$Reason}') ";
            }
        }
        $sql .= 'GROUP BY id ORDER BY t.PriceDate ASC' ;



        $transactions = $Model->select($sql);

//        $sql_remain_prev = "SELECT SUM(Price) AS sum_price FROM  transactions  WHERE PriceDate IS NOT NULL AND (( PaymentStatus = 'success' ) AND PriceDate <= '{$StartPostDate} 00:00:00' )  GROUP BY `Status`" ;
//        $sum_price  = $Model->select($sql_remain_prev);


        $sql_charge = "SELECT sum(Price) AS total_charge FROM transactions WHERE Status='1' AND PaymentStatus = 'success'";


        $sql_buy = "SELECT SUM(Price) AS total_buy FROM transactions WHERE Status='2' AND"
            . " ((PaymentStatus = 'success') OR (PaymentStatus = 'pending' AND CreationDateInt > '{$time}')  ) ";

        $charge = $Model->select($sql_charge);
        $this->total_charge = $charge[0]['total_charge'];

        $buy = $Model->select($sql_buy);
        $this->total_buy = $buy[0]['total_buy'];
        $this->total_transaction = $this->total_charge - $this->total_buy;

        $this->is_search = false ;



        if((isset($_POST['flag']) && $_POST['flag']=='newCreateExcelFileForTransactionUser'))
        {

            $sql_charge_search = " SELECT SUM(Price) AS total_charge FROM transactions WHERE Status='1' AND PaymentStatus = 'success'  ";

            $sql_buy_search = " SELECT SUM(Price) AS total_buy FROM transactions WHERE Status='2' AND ((PaymentStatus = 'success') OR (PaymentStatus = 'pending' AND CreationDateInt > '{$time}')  )  ";

            if (!empty($_POST['to_date'])) {
                $sql_charge_search .=" AND PriceDate >= '{$StartPostDate} 00:00:00' AND PriceDate <= '{$EndPostDate} 23:59:59'";
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
                    OR Reason= 'buy_Europcar' OR Reason= 'buy_reservation_tour' OR Reason= 'buy_reservation_visa' OR Reason= 'buy_gasht_transfer' OR Reason= 'buy_train' OR Reason= 'buy_bus' OR Reason= 'buy_entertainment' OR Reason= 'buy_visa_plan' OR Reason= 'buy_package' ) ";
                }else{
                    $sql_buy_search .= " AND (Reason='{$_POST['Reason']}') ";
                }

                $sql_charge_search .= " AND Reason= '{$_POST['Reason']}'";
            }

            $buy_search = $Model->select($sql_buy_search);
            $charge_search = $Model->select($sql_charge_search);

            $sql_remain_prev = "SELECT SUM(Price) AS sum_price FROM  transactions  WHERE PriceDate IS NOT NULL AND (( PaymentStatus = 'success' ) AND PriceDate <= '{$StartPostDate} 00:00:00' )  GROUP BY `Status`" ;

            $total_remain_prev = $Model->select($sql_remain_prev);

            $total_transaction_search = $charge_search[0]['total_charge'] - $buy_search[0]['total_buy'] ;
            $this->total_transaction_search = $total_transaction_search;
            $this->total_charge_search = $charge_search[0]['total_charge'];
            $this->total_buy_search = $buy_search[0]['total_buy'];
            $this->is_search = true;

        }



        $total_transaction_remain = $total_remain_prev[0]['sum_price'] - $total_remain_prev[1]['sum_price']  ;
        $this->remain_prev = $total_transaction_remain;

        $result = [] ;

        foreach ($transactions as $transaction) {
            if ($transaction['PaymentStatus'] == 'success') {
                $depositToAccount = ($transaction['Status'] == '1') ? $transaction['Price'] : 0;
                $accountDeducted = ($transaction['Status'] == '2') ? $transaction['Price'] : 0;

                if ($transaction['Status'] == '1') {
                    $total_transaction_remain = intval($total_transaction_remain) + intval($transaction['Price']);
                } else {
                    $total_transaction_remain = intval($total_transaction_remain) - intval($transaction['Price']);
                }

                $result[] = [
                    'id'                   => $transaction['id'] ,
                    'client_name'          => $transaction['client_name'] ,
                    'Reason'               => $transaction['Reason'] ,
                    'pnr'               => $transaction['pnr'] ,
                    'client_id'            => $transaction['clientID'] ,
                    'price'                => $transaction['Price'] ,
                    'factor_number'        => $transaction['FactorNumber'] ,
                    'service'              => self::getService($transaction['Reason']),
                    'cacheOrCredit'        => self::checkTransactionCacheOrCredit($transaction['BankTrackingCode']),
                    'publicOrPrivate'      => self::getPublicPrivate($transaction['publicOrPrivate']),
                    'type'                 => self::getTransactionType($transaction['Reason']),
                    'comment'              => $transaction['Comment'],
                    'date'                 => dateTimeSetting::jdate("Y-m-d H:i:s",$transaction['CreationDateInt']),
                    'service_date'         => $transaction['service_date'],
                    'origin'               => $transaction['origin_city'],
                    'destination'          => $transaction['destination_city'],
                    'customer_price'       => $transaction['customer_price'],
                    'source'               => self::getSourceName($transaction['source']),
                    'depositToAccount'     => $depositToAccount,
                    'accountDeducted'      => $accountDeducted,
                    'remain'               => $total_transaction_remain,
                ];
            }
        }
        return array_reverse($result);
    }

    public function getAllProviders(){


        /*        $Model = $this->getModel('apiProvidersModel');
                $providersArray = $Model->get(array("id", "name","status"))
                    ->where('status', 'enable')
                    ->all();*/

        $dataSend['Method'] = 'listServer' ;
        $data = json_encode($dataSend);
        $url = $this->apiAddress."baseFile/source/";
        $providersArray = functions::curlExecution($url,$data,'yes');

        $final_array = [];

        $time = time() - (600);

        foreach ($providersArray as $index => $provider){
            $condition='';
            if($provider['sourceType'] == 'flight'){
                $condition .= " AND (rt.id is not null or (t.api_id = {$provider['sourceCode']}) AND t.sourceType = 'flight') ";
            }elseif($provider['sourceType'] == 'hotel'){
                $condition .= " AND (rht.id is not null or (t.api_id = {$provider['sourceCode']}) AND t.sourceType = 'hotel') ";
            }elseif($provider['sourceType'] == 'bus'){
                $condition .= " AND (rbt.id is not null or (t.api_id = {$provider['sourceCode']}) AND t.sourceType = 'bus') ";
            }else{
                $condition .= " AND FALSE ";
            }

//            if($providersArray[$index]['sourceType'] ==  'flight' )
//            {
            $sql_charge_search = " SELECT SUM(t.Price) AS total_charge FROM transactions t
                                         left join report_tb rt on t.FactorNumber = rt.factor_number And rt.api_id = {$provider['sourceCode']}
                                         left join report_hotel_tb rht on t.FactorNumber = rht.factor_number And rht.source_id =  {$provider['sourceCode']}
                                         left join report_bus_tb rbt on t.FactorNumber = rbt.passenger_factor_num And rbt.SourceCode = {$provider['sourceCode']}
                                         WHERE t.Status='1' AND t.PaymentStatus = 'success' 
                                            $condition       
                                           ";
            $sql_buy_search = " SELECT SUM(t.Price) AS total_buy FROM transactions t
                                      left join report_tb rt on t.FactorNumber = rt.factor_number And rt.api_id = {$provider['sourceCode']}
                                      left join report_hotel_tb rht on t.FactorNumber = rht.factor_number And rht.source_id =  {$provider['sourceCode']}
                                      left join report_bus_tb rbt on t.FactorNumber = rbt.passenger_factor_num And rbt.SourceCode = {$provider['sourceCode']}
                                      WHERE t.Status='2' AND ((t.PaymentStatus = 'success') OR (t.PaymentStatus = 'pending' AND t.CreationDateInt > '{$time}')  )  
                                       $condition";
//            var_dump($sql_charge_search);
            $ModelBase = Load::library('ModelBase');
            $buy_search = $ModelBase->select($sql_buy_search);
            $charge_search = $ModelBase->select($sql_charge_search);
            $providersArray[$index]['total_remain_transaction'] = $charge_search[0]['total_charge'] - $buy_search[0]['total_buy'] ;
            $final_array[$index] = $providersArray[$index];
//            }
        }


        return array_reverse($final_array);
    }

    public function insertProviderTransaction($info, $api_id = null){


        $increaseReasonArray = array("charge", "increase", "Reason");// This array includes reasons for increasing client credit

        $decreaseReasonArray = array("decrease", "indemnity_edit_ticket",);// This array includes reasons for decreasing client credit

//        $pendingStatusArray = array('increase', 'decrease', 'indemnity_edit_ticket', 'diff_price');// This array includes reasons for pending status client credit

        $data_insert_transaction['Price'] = $info['Price'];
        $data_insert_transaction['Comment'] = $info['Comment'];
        $data_insert_transaction['Reason'] = $info['Reason'];
        $data_insert_transaction['sourceType'] = $info['sourceType'];
        $data_insert_transaction['api_id'] = $api_id;
        $data_insert_transaction['PaymentStatus'] =  'success';
        $data_insert_transaction['CreationDateInt'] = time();
        $data_insert_transaction['FactorNumber'] = 'OP' . mt_rand(100000, 999999);
        $data_insert_transaction['PriceDate'] = date("Y-m-d H:i:s");
        if (in_array($info['Reason'], $increaseReasonArray)) {
            $data_insert_transaction['Status'] = '1';
        } else if (in_array($info['Reason'], $decreaseReasonArray)) {
            $data_insert_transaction['Status'] = '2';
        }
        $result = $this->getModel('transactionsModel')->insertLocal($data_insert_transaction);


        if ($result) {
            return 'success : تراکنش با موفقیت انجام شد';
        }
        return 'error : خطا در ثبت تراکنش ';

    }

    private function getService($transaction_reason){
        switch ($transaction_reason) {
            case 'buy':
            case 'buy_reservation_ticket':
                $service = 'بلیط';
                break;
            case 'buy_hotel':
            case 'buy_reservation_hotel':
                $service = 'هتل';
                break;
            case 'buy_bus':
                $service = 'اتوبوس';
                break;
            case 'buy_insurance':
                $service = 'بیمه';
                break;
            case 'buy_train':
                $service = 'قطار';
                break;
            case 'buy_gasht_transfer':
                $service = 'گشت و ترانسفر';
                break;
            case 'buy_package':
                $service = 'پرواز+ هتل';
                break;
            case 'buy_reservation_tour':
                $service = 'تور';
                break;
            case 'indemnity_cancel':
                $service = 'کنسلی';
                break;
            case 'increase':
                $service = 'واریز';
                break;
            default:
                $service = 'ـــــــ';
                break;
        }
        return $service ;
    }
    private function checkTransactionCacheOrCredit($Bank_tracking_code){
        if($Bank_tracking_code){
            return 'نقدی';
        }
        return 'اعتباری';
    }
    private function getTransactionType($transaction_reason){
        switch ($transaction_reason) {
            case 'charge':
                $type = 'شارژحساب';
            case 'increase':
                $type = 'واریز به حساب شما';
                break;
            case 'decrease':
                $type = 'کسر از حساب شما';
                break;
            case 'buy':
                $type = 'خرید پرواز';
                break;
            case 'buy_hotel':
                $type = 'خرید هتل';
                break;
            case 'buy_bus':
                $type = 'خرید اتوبوس';
                break;
            case 'buy_reservation_hotel':
                $type = 'خرید هتل رزرواسیون';
                break;
            case 'buy_reservation_ticket':
                $type = 'خرید بلیط رزرواسیون';
                break;
            case 'buy_insurance':
                $type = 'خرید بیمه';
                break;
            case 'buy_train':
                $type = 'خرید قطار';
                break;
            case 'buy_gasht_transfer':
                $type = 'خرید گشت ترانسفر';
                break;
            case 'buy_reservation_tour':
                $type = 'خرید تور';
                break;
//            case 'price_cancel':
//                $ReasonFa = 'مبلغ کنسلی';
//                break;
            case 'indemnity_cancel':
                $type = 'کنسلی';
                break;
//
//            case 'indemnity_edit_ticket':
//                $ReasonFa = 'جریمه اصلاح بلیط';
//                break;
//            case 'diff_price':
//                $ReasonFa = 'واریز تغییر قیمت شناسه نرخی';
//                break;
//            case 'buy_package':
//                $ReasonFa = 'پرواز+ هتل';
//                break;
            default:
                $type = 'ـــــــ';
                break;
        }
        return $type ;
    }

    private function getSourceName($source) {
        switch ($source) {
            case '13':
                return $source . '(اقامت)';
            case '21':
                return $source . '(چارتر118)';
            case '17':
                return $source . '(فلایتیو)';
            case '43':
                return $source . 'سیتی نت';
            default:
                return 'نقدی';
        }
    }
    private function getPublicPrivate($private_public) {
        switch ($private_public) {
            case "1":
            case 'PrivateLocalInsurance':
            case 'PrivatePortalInsurance':
            case 'PrivatePortalHotel':
            case 'PrivateLocalHotel':
            case 'PrivatePortalTour':
            case 'PrivateLocalTour':
            case 'Private':
                return 'اختصاصی';
            case "0":
            case "PublicLocalHotel":
            case "PublicPortalInsurance":
            case "PublicLocalInsurance":
            case "PublicPortalHotel":
            case "public":
                return 'اشتراکی';
            default:
                return '----';
        }
    }

    public function getLastTransactionBalanceStatus($clientID,$numberFactor)
    {

        $ResultIdInTrabsaction = $this->modelTransactions
            ->get(['id'])
            ->where('clientID', $clientID)
            ->where('FactorNumber', $numberFactor)
            ->find();
        $IdInTrabsaction =$ResultIdInTrabsaction['id'];

        $TotalChargeClient=0;
        $ResultChargeClient = $this->modelTransactions
            ->get(['Price'])
            ->where('clientID',$clientID)
            ->where('Status','1')
            ->where('PaymentStatus','success')
            ->where('id',$IdInTrabsaction,'<')
            ->all();
        foreach ($ResultChargeClient as $row) {
            $TotalChargeClient += $row['Price'];
        }

        //sum price ta Ghabl In kharid
        $TotalBuyClient=0;
        if($IdInTrabsaction!='') {
            $time = time() - 600;
            $Model = Load::library('ModelBase');
            $sqlBuy = "SELECT sum(Price) AS total_buy FROM transactions 
                       WHERE 
                            clientID='{$clientID}' AND 
                            Status='2' AND 
                            id< {$IdInTrabsaction} AND
                            (
                                PaymentStatus = 'success' OR 
                                (PaymentStatus = 'pending' AND CreationDateInt > '{$time}')
                            )";
            $ResultBuy = $Model->select($sqlBuy);
            $TotalBuyClient=$ResultBuy[0]['total_buy'];
        }

        return ($TotalChargeClient-$TotalBuyClient);
    }
}