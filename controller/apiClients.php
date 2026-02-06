<?php





class apiClients extends clientAuth
{
    public $noPhotoUrl , $apiClientsBaseUrl;
    private $apiClientsTb;
    /**
     * @var string
     */
    private $page_limit;
        /**

         * @var string
         */
    private $photoUrl;

    public function __construct() {
        parent::__construct();
        $this->apiClientsTb = 'client_user_api';
        $this->page_limit = 6;
        $this->apiClientsBaseUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/apiClients' . '/';
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

    public function checkUserExist($userName = null, $id = null) {
        $apiClients_model = $this->getModel('apiClientsModel');
        $apiClients_table = $apiClients_model->getTable();
        $apiClients = $apiClients_model
            ->get(
                [
                    $apiClients_table . '.*',
                ], true
            );
        if ($id) {
            $apiClients = $apiClients->where($apiClients_table . '.id', $id);
        }
        if ($userName) {
            $apiClients = $apiClients->where($apiClients_table . '.userName', $userName);
        }

        $apiClients = $apiClients->find(false);

        return $apiClients;

    }

    public function storeApiClients($params) {

        $media = [];
        foreach ($params['socialLinks'] as $key => $record) {
            if ($record['link']!='' && $record['social_media']!='') {
                $media[$key] = $record;
            }
        }
        /** @var apiClientsModel $Model */
        $apiClients_model = $this->getModel('apiClientsModel');
        $apiClients['clientId'] = 299;
        $apiClients['userName'] = $params['userName'];
        $apiClients['keyTabdol'] = $params['keyTabdol'];
        $apiClients['creationDateInt'] = time();
//        var_dump($apiClients);
//        die();

        $check_user_name = $this->checkUserExist($apiClients['userName']);

        if (!$check_user_name) {
            $insert = $apiClients_model->insertWithBind($apiClients);
            if ($insert) {
                return self::returnJson(true, 'کاربر  با موفقیت در سیستم به ثبت رسید');
            }
        } else {
            return self::returnJson(false, $check_user_name, null, 500);
        }


        return self::returnJson(false, 'خطا در ثبت اطلاعات در سیستم.', null, 500);

    }

    public function make_enable($params = null) {

        $apiClients_model = $this->getModel('apiClientsModel');
        if ($params['val'] == 1){
            $data['is_enable'] = 0;
        } elseif ($params['val'] == 0) {
            $data['is_enable'] = 1;
        } else {
            $data['is_enable'] = 0;
        }

        if ($params) {
             $update = $apiClients_model->updateWithBind($data, ['id' => $params['id']]);
            if ($update) {
                return self::returnJson(true, 'مشتری با موفقیت در سیستم بروزرسانی شد');
            }
        }
        return self::returnJson(false, 'مشکلی پیش آمد.');

    }


    public function updateApiClients($params) {

        /** @var application $config */
        /** @var apiClientsModel $apiClients_model */
        $apiClients_model = $this->getModel('apiClientsModel');
        $dataUpdate['userName'] = $params['userName'];
        $dataUpdate['keyTabdol'] = $params['keyTabdol'];


        $check_up = true;
        $check_user_name = $this->checkUserExist($dataUpdate['userName']);
        if ($check_user_name) {
            $check_user_name_and_id = $this->checkUserExist($dataUpdate['userName'] ,$params['id'] );
            if (!$check_user_name_and_id) {
                $check_up = false;
            }
        }


        if ($check_up) {
            $update = $apiClients_model->updateWithBind($dataUpdate, ['id' => $params['id']]);
            if ($update) {
                return self::returnJson(true, 'مشتری با موفقیت در سیستم بروزرسانی شد');
            }
        } else {
            return self::returnJson(false, 'نام کاربری تکراری است.', null, 500);
        }

        return self::returnJson(false, $update, null, 500);


        return self::returnJson(false, 'خطا در ثبت اطلاعات در سیستم.', null, 500);
    }


    public function getApiClientById($id) {
        $apiClients_model = $this->getModel('apiClientsModel');
        $apiClients_table = $apiClients_model->getTable();
        $apiClients = $apiClients_model
            ->get(
                [
                    $apiClients_table . '.*',
                ], true
            )
            ->where($apiClients_table . '.id', $id)
            ->find(false);
        return $apiClients;
    }

    public function getApiClients() {

        $apiClients_model = $this->getModel('apiClientsModel');
        $apiClients_table = $apiClients_model->getTable();
        $apiClients = $apiClients_model
            ->get(
                [
                    $apiClients_table . '.*',
                ], true
            )
            ->orderBy('id','DESC')
            ->all(false);
        return $apiClients;
    }

    public function generateRandomString() {
        // Define characters allowed in the random string (excluding '.')
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@';
        $length = 40; // Total length of the string (4 parts of 5-10 characters each)

        $randomString = '';

        // Generate four parts of 5-10 characters separated by '-'
        for ($i = 0; $i < 4; $i++) {
            $partLength = mt_rand(5, 10); // Random length for each part
            $part = '';

            // Generate characters for each part
            for ($j = 0; $j < $partLength; $j++) {
                $part .= $characters[mt_rand(0, strlen($characters) - 1)];
            }

            $randomString .= $part; // Concatenate part
            if ($i < 3) {
                $randomString .= '-'; // Add hyphen between parts except for the last one
            }
        }

        return $randomString;
    }






}
