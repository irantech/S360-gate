<?php
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

class onlinePayment extends clientAuth {
    /**
     * @var string
     */
    private $onlinePaymentTb , $factorNumber;
    /**
     * @var string
     */
    public function __construct() {
    parent::__construct();
        $this->onlinePaymentTb = 'online_payment_tb';
    }
    /**
     * @param array $onlinePaymentList
     * @return array
     */
    public function onlinePaymentModel() {
        return Load::getModel( 'onlinePaymentModel' );
    }
    public function addOnlinePaymentIndexes(array $onlinePaymentList) {
        $result = [];
        foreach ($onlinePaymentList as $key => $list) {
            $result[$key] = $list;
            $time_date = functions::ConvertToDateJalaliInt($list['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['tiny_text'] = strip_tags(substr_replace($list['babat'], "...", 250));
            $result[$key]['is_active'] = "{$list['view']}";
            $result[$key]['code'] = "{$list['code_rah']}";
        }
        return $result;
    }
    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        $return = json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return $return;
    }
    public function listOnlinePayment($data_main_page = []) {
        $result = [];
        $payment_list = $this->getModel('onlinePaymentModel')->get();
        $payment_table = $payment_list->getTable();
        if ($data_main_page['trackingCode'] ) {
            $payment_list->where($payment_table . '.tracking_code_admin', $data_main_page['trackingCode']);
        }
        $payment_list->orderBy('id' ,'DESC');
        $list_final= $payment_list->all();

        foreach ($list_final as $key => $value) {
            $price_model = $this->getModel('onlinePaymentPriceModel')->get()->where('tracking_code', $value['tracking_code_admin'])->find();
            $list_final[$key]['title_price'] = $price_model['title'];
            $list_final[$key]['id_price'] = $price_model['id'];
        }

        $result = $this->addOnlinePaymentIndexes($list_final);
        return $result;
    }
    public function findOnlinePaymentById($id) {
        return $this->getModel('onlinePaymentModel')->get()->where('id', $id)->find();
    }
    public function findOnlinePaymentByCode($requestNumber) {
        return $this->getModel('onlinePaymentModel')->get()->where('code_rah', $requestNumber)->find();
    }
    public function deleteOnlinePayment($data_delete) {
        $check_exist_online_payment = $this->findOnlinePaymentById($data_delete['id']);
        if ($check_exist_online_payment) {
            $result_update_online_payment = $this->getModel('onlinePaymentModel')->delete("id='{$data_delete['id']}'");
            if ($result_update_online_payment) {
                return functions::withSuccess('', 200, 'حذف با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در حذف جدبد');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }
    public function getOnlinePayment($id) {
        $online_model = $this->getModel('onlinePaymentModel');
        $online_table = $online_model->getTable();
        $dataUpdate = [
            'view' => 'seen',
        ];
        $online_model->updateWithBind($dataUpdate, ['id' => $id]);
        $item = $online_model->get([
            $online_table.'.*',
        ] ,true)
            ->where($online_table . '.id' , $id)
            ->find(false);
        return $this->addOnlinePaymentIndexes([$item])[0];
    }
    public function getOnlinePaymentClient($id) {
        $online_model = $this->getModel('onlinePaymentModel');
        $online_table = $online_model->getTable();

        $item = $online_model->get([
            $online_table.'.*',
        ] ,true)
            ->where($online_table . '.id' , $id)
            ->find(false);
        return $this->addOnlinePaymentIndexes([$item])[0];
    }

    public function insertOnlinePaymentArray($data) {

        if ($data['tracking_code_admin']) {
            $tracking_code_admin = $data['tracking_code_admin'];

            $check_exist_item = $this->getModel('onlinePaymentPriceModel')
                ->get()
                ->where('is_active' , 1)
                ->where('price' , $data['price'])
                ->where('tracking_code' , $tracking_code_admin)->find();

            if (!$check_exist_item) {
                return "error : رکورد مورد نظر یافت نشد";
            }

        }else{
            $tracking_code_admin = '';
        }
        $i = 0;
        $tmp = mt_rand(1, 15);
        do {
            $tmp .= mt_rand(1, 15);
        } while (++$i < 16);
        $uniq = $tmp;
        $code = date("sB").substr($uniq, 0, 10);
        $dataInsert = [
            'name' => $data['name'],
            'amount' => $data['price'],
            'phone' => $data['mobile'],
            'language' => SOFTWARE_LANG,
            'reason' => $data['reason'],
            'tracking_code_admin' => $tracking_code_admin,
            'code_rah' => $code,
            'view' => 'not_seen',
            'status' => 'hold',
            'created_at' => date('Y-m-d H:i:s', time()),
        ];

        $temp_onlinePayment_model = Load::getModel('onlinePaymentModel');
        $result = $this->getModel('onlinePaymentModel')->insertWithBind($dataInsert);

        if ( $result ) {
            $last_onlinePayment_id = $temp_onlinePayment_model->getLastId();
            $final_result = $this->getOnlinePaymentClient($last_onlinePayment_id);
            return $final_result;
        } else {
            return "error : خطا در ثبت درخواست";
        }
    }


    #region setPortBank
    public function setPortBank($bankDir, $factorNumber)
    {

        $initialValues=array(
            'bank_dir'=>$bankDir,
            'serviceTitle'=>$_POST['serviceType']
        );
        $bankModel=Load::model('bankList');
        $bankInfo=$bankModel->getByBankDir($initialValues);

        $data['name_bank_port']=$bankDir;
        $data['number_bank_port']=$bankInfo['param1'];

        $Model=Load::library('Model');
        $Model->setTable('online_payment_tb');

        $condition=" code_rah = '{$factorNumber}' ";
        $Model->update($data, $condition);

    }
    #endregion

    #region sendUserToBank
    public function sendUserToBank($factorNumber)
    {
        $data=array(
            'status'=>"bank"
        );

        $condition=" code_rah = '{$factorNumber}' ";
        $Model=Load::library('Model');

        $Model->setTable('online_payment_tb');
        $Model->update($data, $condition);

    }
    #endregion

    #region updateBank
    public function updateBank($trackingCode, $factorNumber)
    {

        $Model=Load::library('Model');


        $sql=" SELECT status FROM online_payment_tb WHERE code_rah = '{$factorNumber}' ";
        $onlinePayment =$Model->load($sql);

        if($onlinePayment['status']=='bank'){

            $data=array(
                'tracking_code_bank'=>"".$trackingCode."",
                'payment_date'=>Date('Y-m-d H:i:s')
            );
            $condition=" code_rah = '".$factorNumber."' AND status = 'bank' ";
            $Model->setTable('online_payment_tb');
            $Model->update($data, $condition);
        }
    }
    #endregion
   #region setBook
    public function setBook($paymentType=null, $factorNumber=null)
    {
        //echo Load::plog($_POST);
        //echo Load::plog($_GET);

        $Model=Load::library('Model');

        $smsController=Load::controller('smsServices');
        // پرداخت از درگاه//
        if(isset($factorNumber) && $factorNumber==''){
            $this->factorNumber=trim($factorNumber);
        }

//
        $sql=" SELECT * FROM online_payment_tb WHERE code_rah = '{$factorNumber}' AND ( status = 'bank' )";
        $resultBook=$Model->load($sql);

        if (!empty($resultBook)) {


            $dataUpdateOnlinePayment['payment_date'] = Date('Y-m-d H:i:s');
            $dataUpdateOnlinePayment['updated_at'] = time();
            $dataUpdateOnlinePayment['status'] = $paymentType;
//            if ($paymentType == 'cash') {
//                if ($resultBook['tracking_code_bank'] == 'member_credit') {
//                    $dataUpdateOnlinePayment['payment_type'] = 'member_credit';
//                    $dataUpdateOnlinePayment['tracking_code_bank'] = '';
//                } else {
//                    $dataUpdateOnlinePayment['payment_type'] = 'cash';
//                }
//            }

            $condition = " code_rah='{$factorNumber}' ";
            $Model->setTable('online_payment_tb');
            $res = $Model->update($dataUpdateOnlinePayment, $condition);

            if ($res) {


                $this->paymentDate = $dataUpdateOnlinePayment['payment_date'];





            }
        } else{


            $sms = "پرداخت انلاین خطای" . PHP_EOL;
            $sms .= " شماره فاکتور: {$factorNumber} - " . CLIENT_NAME . PHP_EOL;
            $this->supportsNotification($sms);


            $this->error=true;
            $this->errorMessage='اشکالی در فرآیند پرداخت پیش آمده است، لطفا برای پیگیری رزرو و یا برگرداندن اعتبار خود با پشتیبانی تماس حاصل نمائید';
        }


    }
    #endregion

    #region callFailed
    public function callFailed($payment_type, $factorNumber, $reason = '')
    {
        $Model=Load::library('Model');
        $sql=" SELECT * FROM online_payment_tb WHERE code_rah = '{$factorNumber}' AND ( status = 'bank' )";
        $resultBook=$Model->load($sql);

        if (!empty($resultBook)) {


            $dataUpdateOnlinePayment['payment_date'] = Date('Y-m-d H:i:s');
            $dataUpdateOnlinePayment['updated_at'] = time();
            $dataUpdateOnlinePayment['status'] = $payment_type;

            $condition = " code_rah='{$factorNumber}' ";
            $Model->setTable('online_payment_tb');
            $res = $Model->update($dataUpdateOnlinePayment, $condition);
        }

        $smsController = Load::controller('smsServices');
        $objSms = $smsController->initService('1');


        if (!$reason)
            $reason = 'ارتباط';

//        if ($objSms) {
//
//            $sms = 'خطا در پرداخت انلاین رخ داده است' . PHP_EOL
//                . 'شماره فاکتور : ' . $factorNumber . PHP_EOL
//                . 'دلیل : ' . $reason . PHP_EOL
//                . 'لطفا پیگیری کنید';
//
//            $cellArray = array(
//
//                'bahrami' => '09351252904',
//                'araste' => '09211559872',
//                'afraze' => '09916211232',
//                'fannipor' => '09129409530',
//                'abasi2' => '09057078341',
//
//            );
//            foreach ($cellArray as $cellNumber) {
//                $smsArray = array(
//                    'smsMessage' => $sms,
//                    'cellNumber' => $cellNumber
//                );
//                $smsController->sendSMS($smsArray);
//            }
//
//
//            $sms = 'خطا در پرداخت انلاین رخ داده است' . PHP_EOL
//                . 'شماره فاکتور : ' . $factorNumber . PHP_EOL
//                . 'دلیل : ' . $reason . PHP_EOL
//                . 'لطفا پیگیری کنید رییس';
//
//
//            $smsArray = array(
//                'smsMessage' => $sms,
//                'cellNumber' => '09108453606'
//            );
//            $smsController->sendSMS($smsArray);
//
//        }

    }
    #endregion


    public function getBankList() {
        return functions::InfoBank('1');
    }
    private function supportsNotification($sms) {
        //sms to our supports
        $smsController = Load::controller('smsServices');
        $objSms = $smsController->initService('1');
        if ($objSms) {



            $cellArray = array(
                'afraze' => '09916211232',
                'abasi2' => '09057078341',
                'bahrami' => '09351252904',
                'fanipor' => '09129409530',
                'araste' => '09211559872',


            );
            foreach ($cellArray as $cellNumber) {
                $smsArray = array(
                    'smsMessage' => $sms,
                    'cellNumber' => $cellNumber
                );
                $smsController->sendSMS($smsArray);
            }
        }
    }


    public function insertPrice($params) {

        $ii = 0;
        $temp = mt_rand(1, 15);
        do {
            $temp .= mt_rand(0, 15);
        } while (++$ii < 16);
        $uniq = $temp;
        $tracking_code = substr($uniq, 0, 10);
        $dataList = [
            'title' => $params['title'],
            'price' => $params['price'],
            'is_active' => false,
            'tracking_code' => $tracking_code,
            'created_at' => date('Y-m-d H:i:s', time()),
        ];

        $insert = $this->getModel('onlinePaymentPriceModel')->insertWithBind($dataList);
        if ($insert) {
            return self::returnJson(true, 'افزودن قیمت با موفقیت انجام شد');
        }

        return self::returnJson(false, 'خطا در ثبت قیمت جدید.', null, 500);

    }
    public function addPriceIndexes(array $priceList) {
        $result = [];
        foreach ($priceList as $key => $price) {
            $result[$key] = $price;
            $time_date = functions::ConvertToDateJalaliInt($price['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['is_active'] = "{$price['is_active']}";
        }
        return $result;
    }

    public function listPrice() {

        $List = $this->getModel('onlinePaymentPriceModel')->get();
        $price_table = $List->getTable();
        $list_price = $List->all();

        foreach ($list_price as $key => $value) {
            $price_model = $this->getModel('onlinePaymentModel')->get()->where('tracking_code_admin', $value['tracking_code']);
            $result =  $price_model->all();
            $count = count($result);
            $list_price[$key]['count_user'] = $count;
        }
        $result = $this->addPriceIndexes($list_price);
        return $result;
    }
    public function updateStatusPrice($dataStatus){
        $check_exist_item = $this->getModel('onlinePaymentPriceModel')->get()->where('id' , $dataStatus['id'])->find();
        if ($check_exist_item) {
            $data_update_status['is_active'] = ($check_exist_item['is_active'] == 1) ? 0 : 1;
            $condition_update_status ="id='{$check_exist_item['id']}'";
            $result_update = $this->getModel('onlinePaymentPriceModel')->updateWithBind($data_update_status,$condition_update_status);

            if ($result_update) {
                return functions::withSuccess('', 200, 'ویرایش وضعیت  با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش وضعیت ');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }


    public function deletePrice($params) {
        $result = $this->getModel('onlinePaymentPriceModel')->softDelete([
            'id' => $params['id']
        ]);
        if ($result) {
            return functions::JsonSuccess($result, 'آیتم مورد نظر حذف شد');
        }
        return functions::JsonError($result, 'خطا در حذف', 200);
    }
    public function getPayData($id) {
        $price_model = $this->getModel('onlinePaymentPriceModel');
        $price_table = $price_model->getTable();
        $price_item = $price_model->get([$price_table.'.*'], true)->where($price_table . '.id' , $id)->find(false);
        return $this->addPriceIndexes([$price_item])[0];
    }
    public function update_price($params) {
        $price_model = $this->getModel('onlinePaymentPriceModel');
        $dataUpdate =[];
        $data = [
            'title' => $params['title'],
            'price' => $params['price'],
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];
        $result = array_merge($dataUpdate,$data);
        $update = $price_model->updateWithBind($result, ['id' => $params['id']]);
        if ($update) {
            return functions::withSuccess('', 200, 'ویرایش قیمت با موفقیت انجام شد');
        }
    }
    public function getPayDataSite($code) {
        $price_model = $this->getModel('onlinePaymentPriceModel');
        $price_table = $price_model->getTable();
        $price_item = $price_model->get([$price_table.'.*'], true)->where($price_table . '.tracking_code' , $code)->find(false);
        return $this->addPriceIndexes([$price_item])[0];
    }

}