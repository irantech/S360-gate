<?php


class userPassCustomers extends clientAuth {
    /**
     * @var string
     */
    private $userPassCustomerTb , $page_limit;
    /**
     * @var string
     */
    public function __construct() {
    parent::__construct();
    $this->userPassCustomerTb = 'user_pass_customers_tb';
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

    public function customerIndexes(array $customerList) {
        $result = [];

        foreach ($customerList as $key => $customer) {
            $result[$key] = $customer;
            $time_date = functions::ConvertToDateJalaliInt($customer['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);

        }
        return $result;
    }

    public function listCustomer() {
        $customerList = $this->getModel('userPassCustomersModel')->get();
        $customerList->orderBy('id', 'ASC');
        $list = $customerList->all();
        return  $this->customerIndexes($list);
    }

    public function insertCustomer($params) {

        $dataInsert = [
            'title' => $params['title'],
            'domain' => $params['domain'],
            'user_name' => $params['user_name'],
            'password' => $params['password'],
            'link' => $params['link'],
            'is_active' => true,
            'created_at' => date('Y-m-d H:i:s', time()),
        ];
        $insert = $this->getModel('userPassCustomersModel')->insertWithBind($dataInsert);
        if ($insert) {
            return self::returnJson(true, 'افزودن مشتری با موفقیت انجام شد');
        }
        return self::returnJson(false, 'خطا در ثبت مشتری جدید.', null, 500);
    }
    public function findCustomerById($id) {
        return $this->getModel('userPassCustomersModel')->get()->where('id', $id)->find();
    }
    public function updateActiveCustomer($data_update) {

        $check_exist_customer = $this->findCustomerById($data_update['id']);
        if ($check_exist_customer) {
            $data_update_status['is_active'] = ($check_exist_customer['is_active'] == 1) ? 0 : 1;
            $condition_update_status ="id='{$check_exist_customer['id']}'";
            $result_update = $this->getModel('userPassCustomersModel')->updateWithBind($data_update_status,$condition_update_status);

            if ($result_update) {
                return functions::withSuccess('', 200, 'ویرایش وضعیت مشتری با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش وضعیت ');

        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');

    }
    public function getCustomer($id) {
        $customer_model = $this->getModel('userPassCustomersModel');
        $customer_table = $customer_model->getTable();
        $customer = $customer_model
            ->get(
                [
                    $customer_table . '.*',
                ], true
            )
            ->where($customer_table . '.id', $id)
            ->find(false);
        return $this->customerIndexes([$customer])[0];
    }
    public function deleteCustomer($data_update) {
        $check_exist_customer= $this->findCustomerById($data_update['id']);
        if ($check_exist_customer) {
            $result_update_customer = $this->getModel('userPassCustomersModel')->delete("id='{$data_update['id']}'");
            if ($result_update_customer) {
                return functions::withSuccess('', 200, 'حذف مشتری با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در حذف');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }


    public function updateCustomer($params) {
        /** @var userPassCustomersModel $customer_model */
        $customer_model = $this->getModel('userPassCustomersModel');
        $data = [
            'title' => $params['title'],
            'domain' => $params['domain'],
//            'user_name' => $params['user_name'],
//            'password' => $params['password'],
            'link' => $params['link'],
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];
        $update = $customer_model->updateWithBind($data, ['id' => $params['id']]);
        if ($update) {
            return self::returnJson(true, 'ویرایش مشتری با موفقیت انجام شد');

        }

    }
    public function changePasswordCustomer($params) {
        /** @var userPassCustomersModel $customer_model */
        $customer_model = $this->getModel('userPassCustomersModel');

        $new_pass = $params['new_password'];
        $new_password_repeat = $params['new_password_repeat'];
        $cheke_user = $this->getModel('loginModel')->get()->where('username', $params['user_name'])->find();

        if ($cheke_user) {

         if ($new_pass === $new_password_repeat) {
             $data = [
                 'password' => $params['new_password'],
                 'updated_password_at' => date('Y-m-d H:i:s', time()),
             ];

             $new_pass_hash =  functions::encryptPassword( $params['new_password'] );
             $token = functions::encryptPassword($cheke_user['client_id']);
             $data_login_update = [
                 'password' => $new_pass_hash,
                 'token' => $token,
             ];
             $update = $customer_model->updateWithBind($data, ['id' => $params['id']]);
             $this->getModel('loginModel')->updateWithBind($data_login_update, ['username' => $params['user_name']]);

             if ($update) {
                 return self::returnJson(true, 'ویرایش مشتری با موفقیت انجام شد');

             }
         }  else {
             return functions::withError('',200,'رمز عبور و تکرار آن برابر نمی باشد!');

         }

        }else{
            return functions::withError('',200,'این مشتری وجود ندارد!');
            die;
        }


    }

    public function excelCustomer($data_update) {
        $ModelBase = Load::library('ModelBase');
        $Sql = "SELECT * FROM support WHERE  (id % 2) > 0 ";
        $result = $ModelBase->select($Sql);
        foreach ($result as $key => $params) {
            $dataCustomer = [
                'title' => $params['f1'],
                'domain' => $params['f2'],
                'link' => $params['f3'],
                'user_name' => $params['f4'],
                'password' => $params['f5'],
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s', time()),
            ];
            $this->getModel('userPassCustomersModel')->insertWithBind($dataCustomer);
        }
        return self::returnJson(true, 'آپلود اکسل با موفقیت انجام شد');

    }

}