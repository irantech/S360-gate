<?php
//if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}


class clients extends clientAuth {
    /**
     * @var string
     */
    private $clientsTb , $page_limit;
    /**
     * @var string
     */
    public function __construct() {
    parent::__construct();
    $this->clientsTb = 'clients_tb';
    $this->page_limit = 6;
    }

    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        return json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function clientsIndexes(array $clientList) {
        $result = [];

        foreach ($clientList as $key => $client) {
            $result[$key] = $client;
            $time_date = functions::ConvertToDateJalaliInt($client['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);

        }
        return $result;
    }

    public function listClients() {
        $clientList = $this->getModel('clientsModel')->get();
        $clientList->orderBy('id', 'ASC');
        $list = $clientList->all();
        return  $this->clientsIndexes($list);
    }
    public function listClosedClients() {
        $clientList = $this->getModel('clientsModel')
            ->get(['id','AgencyName','MainDomain','status_factor_user'])
            ->where('status_factor_user', 'Close')
            ->where('archived_at', NULL, 'IS')
            ->all();
        return $clientList;
    }
    public function listClosedAdminClients() {
        $clientList = $this->getModel('clientsModel')
            ->get(['id','AgencyName','MainDomain','status_factor_admin'])
            ->where('status_factor_admin', 'Close')
            ->where('archived_at', NULL, 'IS')
            ->all();
        return $clientList;
    }
    public function listWithoutHashIdWhmcsClients() {
        $clientList = $this->getModel('clientsModel')
            ->get(['id','AgencyName','MainDomain'])
            ->where('hash_id_whmcs', NULL, ' IS ')
            ->where('archived_at', NULL, 'IS')
            ->all();
        return $clientList;
    }
    public function setStatusFactorClient($params)
    {
        try {
            $client_id = isset($params['client_id']) ? $params['client_id'] : '';
            if (!$client_id) {
                return [
                    'status' => false,
                    'message' => 'شناسه نامعتبر است'
                ];
            }
            $this->getModel('clientsModel')
                ->updateWithBind(['status_factor_user' => ''], ['id' => $client_id]);
            return [
                'status' => true,
                'message' => 'وضعیت فاکتور با موفقیت ذخیره شد'
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'خطا در ذخیره وضعیت فاکتور'
            ];
        }
    }

    public function setStatusFactorAdminClient($params)
    {
        try {
            $client_id = isset($params['client_id']) ? $params['client_id'] : '';
            if (!$client_id) {
                return [
                    'status' => false,
                    'message' => 'شناسه نامعتبر است'
                ];
            }
            $this->getModel('clientsModel')
                ->updateWithBind(['status_factor_admin' => ''], ['id' => $client_id]);
            return [
                'status' => true,
                'message' => 'وضعیت فاکتور با موفقیت ذخیره شد'
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'خطا در ذخیره وضعیت فاکتور'
            ];
        }
    }
    public function isSafar360() {
        return json_encode(functions::isSafar360());
    }


}