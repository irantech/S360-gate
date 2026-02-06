<?php
/**
 * Created by PhpStorm.
 * User: AbbasPC
 * Date: 10/31/2018
 * Time: 2:54 PM
 */

/**
 * Class currency
 * @property currency $currency
 */
//if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//   @ini_set('display_errors', 1);
//   @ini_set('display_errors', 'on');
//}
class currency extends baseController{

    #region __construct
    public function __construct() {

    }
    #endregion

    /**
     * @return bool|mixed|currencyModel
     */
    public function currencyModel() {
        return Load::getModel('currencyModel');
    }
    public function currencyEquivalentModel() {
        return Load::getModel('currencyEquivalentModel');
    }
    /**
     * @return bool|mixed|currencyEquivalentHistoryModel
     */
    public function currencyEquivalentHistoryModel() {
        return $this->getModel('currencyEquivalentHistoryModel');
    }

    #region CurrencyList
    public function CurrencyList($is_json = false) {
        // Get all currencies from the base database
        $currencyList = $this->currencyModel()->get()->all();

        // Get customer-specific currencies if not admin
        if (TYPE_ADMIN != '1') {
            $customerCurrencyModel = $this->getModel('customerCurrencyModel');
            $customerCurrencyList = $customerCurrencyModel->get()->all();

            // Create a map of customer currencies by ID for quick lookup
            $customerCurrencyMap = [];
            foreach ($customerCurrencyList as $customerCurrency) {
                $customerCurrencyMap[$customerCurrency['base_currency_id']] = $customerCurrency;
            }

            // Merge the data - override base currencies with customer currencies where they exist
            foreach ($currencyList as $key => $currency) {
                if (isset($customerCurrencyMap[$currency['id']])) {
                    // Mark this currency as customized
                    $currencyList[$key]['is_customized'] = true;
                    
                    // Override base currency properties with customer currency properties
                    foreach ($customerCurrencyMap[$currency['id']] as $prop => $value) {
                        // Skip the ID field and base_currency_id field
                        if ($prop != 'id' && $prop != 'base_currency_id') {
                            $currencyList[$key][$prop] = $value;
                        }
                    }
                } else {
                    // This currency is using the base settings
                    $currencyList[$key]['is_customized'] = false;
                }
            }
        }

        if ($is_json) {
            return functions::withSuccess($currencyList, 200, 'successfully Fetch');
        }
        return $currencyList;
    }
    #endregion

    #region InsertCurrency
    public function InsertCurrency($param) {
        // Only admin can insert new currencies to the base database
        if (TYPE_ADMIN != '1') {
            return "Error : شما دسترسی لازم برای ایجاد ارز جدید را ندارید";
        }

        $currency_model = $this->getModel('currencyModel');

        $data['CurrencyTitle'] = $param['CurrencyTitle'];
        $data['CurrencyTitleEn'] = $param['CurrencyTitleEn'];
        $data['CurrencyShortName'] = $param['CurrencyShortName'];
        $data['CurrencyPrice'] = $param['CurrencyPrice'];
        $data['IsEnable'] = "Enable";
        $data['CurrencyCode'] = rand('0000', '9999');
        $data['CreationDateInt'] = time();
        $config = Load::Config('application');
        $config->pathFile('flagCurrency/');
        $success = $config->UploadFile("pic", "CurrencyFlag", "");
        $explode_name_pic = explode(':', $success);

        if ($explode_name_pic[0] == "done") {
            $data['CurrencyFlag'] = $explode_name_pic[1];
        }

        // Insert using ORM
        $currency = $currency_model->insertWithBind($data);

        if ($currency) {
            $history_model = $this->currencyEquivalentHistoryModel();
            $dataHistory['Action'] = 'add';
            $dataHistory['CurrencyCode'] = $data['CurrencyCode'];
            $dataHistory['EqAmount'] = $data['EqAmount'];
            $dataHistory['CreationDateInt'] = time();

            $history_model->insertWithBind($dataHistory);

            return "Success : معادل ارزی جدید با موفقیت ثبت شد";
        } else {
            return "Error : خطا در ثبت معادل ارزی جدید";
        }
    }
    #endregion

    #region ShowInfo
    public function ShowInfo_old($currency_code) {
        if ($currency_code == 0) {
            return array('id' => 0, "CurrencyTitle" => 'ریال');
        }

        // If not admin, check customer-specific currency record first
        if (TYPE_ADMIN != '1') {
            $customerCurrencyModel = $this->getModel('customerCurrencyModel');
            $customerCurrency = $customerCurrencyModel->get()->where('base_currency_id', $currency_code)->find();

            if ($customerCurrency) {
                // Add the base ID for reference
                $customerCurrency['id'] = $currency_code;
                return $customerCurrency;
            }
        }

        // Return the base currency record
        return $this->currencyModel()->get()->where('id', $currency_code)->find();
    }
    public function ShowInfo($currency_code)
    {
        if ($currency_code == 0) {
            return array('id' => 0, "CurrencyTitle" => 'ریال');
        }
        $hasAccess = functions::checkClientConfigurationAccess('custom_currency');

        $motherData = $this->currencyModel()->get()->where('CurrencyCode', $currency_code)->where('IsEnable', 'Enable')->find();

        if (empty($motherData)) {
            return array('error' => 'Currency not found');
        }
        $EqAmount = null;
        if ($hasAccess) {
            $clientCurrency = $this->currencyEquivalentModel()->get()->where('CurrencyCode', $currency_code)->where('IsEnable', 'Enable')->find();
            if (!empty($clientCurrency) && !empty($clientCurrency['EqAmount']) && $clientCurrency['EqAmount'] > 0) {
                $EqAmount = $clientCurrency['EqAmount'];
            } else {
                $EqAmount = $motherData['CurrencyPrice'];
            }
        } else {
            $EqAmount = $motherData['CurrencyPrice'];
        }

        $result = array(
            'CurrencyCode'    => $motherData['CurrencyCode'],
            'CurrencyTitle'   => $motherData['CurrencyTitle'],
            'CurrencyTitleEn' => $motherData['CurrencyTitleEn'],
            'CurrencyFlag'    => $motherData['CurrencyFlag'],
            'EqAmount'        => $EqAmount,
        );
        return $result;
    }
    #endregion

    #region EditCurrency
    public function EditCurrency($param) {
        $currency_model = $this->getModel('currencyModel');

        // Get currency info using ORM
        $InfoCurrency = $currency_model->get()->where('id', $param['id'])->find();

        if ($InfoCurrency) {
            $data['CurrencyTitle'] = $param['CurrencyTitle'];
            $data['CurrencyTitleEn'] = $param['CurrencyTitleEn'];
            $data['CurrencyShortName'] = $param['CurrencyShortName'];
            $data['CurrencyPrice'] = $param['CurrencyPrice'];
            $data['LastEditInt'] = time();

            if (empty($_FILES['CurrencyFlag'])) {
                $explode_name_pic[0] = 'done';
                $explode_name_pic[1] = $InfoCurrency['CurrencyFlag'];
            } else {
                $config = Load::Config('application');
                $config->pathFile('flagCurrency/');
                $success = $config->UploadFile("pic", "CurrencyFlag", "");
                $explode_name_pic = explode(':', $success);
            }

            if ($explode_name_pic[0] == "done") {
                $data['CurrencyFlag'] = $explode_name_pic[1];
            }

            // Determine which model to use based on TYPE_ADMIN
            if (TYPE_ADMIN == '1') {
                // Admin can edit the base currency
                $currency_model->updateWithBind($data, ['id' => $param['id']]);
            } else {
                // Non-admin users edit in their own database
                $customer_currency_model = $this->getModel('customerCurrencyModel');

                // Check if a customer-specific currency record already exists
                $customerCurrency = $customer_currency_model->get()->where('base_currency_id', $param['id'])->find();

                if ($customerCurrency) {
                    // Update existing customer currency record
                    $customer_currency_model->updateWithBind($data, ['base_currency_id' => $param['id']]);
                } else {
                    // Create new customer currency record
                    $data['base_currency_id'] = $param['id'];
                    $data['CurrencyCode'] = $InfoCurrency['CurrencyCode'];
                    $data['CreationDateInt'] = time();
                    $customer_currency_model->insertWithBind($data);
                }
            }

            // Record history using ORM
            $history_model = $this->currencyEquivalentHistoryModel();
            $dataHistory['Action'] = 'changePrice';
            $dataHistory['CurrencyCode'] = $InfoCurrency['CurrencyCode'];
            $dataHistory['EqAmount'] = $data['CurrencyPrice'];
            $dataHistory['CreationDateInt'] = time();

            $history_model->insertWithBind($dataHistory);

            return "Success : معادل ارزی با موفقیت بروز رسانی شد";
        } else {
            return "Error : درخواست شما معتبر نمی باشد";
        }
    }
    #endregion

    #region StatusCurrency
    public function StatusCurrency($param) {
        $currency_model = $this->getModel('currencyModel');

        // Get currency info using ORM
        $InfoCurrency = $currency_model->get()->where('id', $param['id'])->find();

        if ($InfoCurrency['IsEnable'] == 'Enable') {
            $data['IsEnable'] = 'Disable';
        } elseif ($InfoCurrency['IsEnable'] == 'Disable') {
            $data['IsEnable'] = 'Enable';
        }

        // Determine which model to use based on TYPE_ADMIN
        if (TYPE_ADMIN == '1') {
            // Admin can update the base currency status
            $currency_model->updateWithBind($data, ['id' => $param['id']]);
        } else {
            // Non-admin users update in their own database
            $customer_currency_model = $this->getModel('customerCurrencyModel');

            // Check if a customer-specific currency record already exists
            $customerCurrency = $customer_currency_model->get()->where('base_currency_id', $param['id'])->find();

            if ($customerCurrency) {
                // Update existing customer currency record
                $customer_currency_model->updateWithBind($data, ['base_currency_id' => $param['id']]);
            } else {
                // Create new customer currency record
                $data['base_currency_id'] = $param['id'];
                $data['CurrencyCode'] = $InfoCurrency['CurrencyCode'];
                $data['CurrencyTitle'] = $InfoCurrency['CurrencyTitle'];
                $data['CurrencyTitleEn'] = $InfoCurrency['CurrencyTitleEn'];
                $data['CurrencyShortName'] = $InfoCurrency['CurrencyShortName'];
                $data['CurrencyPrice'] = $InfoCurrency['CurrencyPrice'];
                $data['CurrencyFlag'] = $InfoCurrency['CurrencyFlag'];
                $data['CreationDateInt'] = time();
                $customer_currency_model->insertWithBind($data);
            }
        }

        return "Success : وضعیت ارز با موفقیت تغییر یافت";
    }
    #endregion

    #region [UpdatePriceCustomerCurrency]
    public function UpdatePriceGdsCurrency($param) {
        if ($param['EqAmount']) {
            $currency_model = $this->getModel('currencyModel');

            $data['CurrencyPrice'] = $param['EqAmount'];

            // Get the base currency info using ORM
            $baseCurrency = $currency_model->get()->where('CurrencyCode', $param['CurrencyCode'])->find();


            if (!$baseCurrency) {
                return "Error : ارز مورد نظر یافت نشد";
            }

            // Determine which model to use based on TYPE_ADMIN

            if (TYPE_ADMIN == '1') {
                // Admin can update the base currency price
                $currency_model->updateWithBind($data, ['CurrencyCode' => $param['CurrencyCode']]);

            } else {
                // Non-admin users update in their own database
                $customer_currency_model = $this->getModel('customerCurrencyModel');

                // Check if a customer-specific currency record already exists
                $customerCurrency = $customer_currency_model->get()->where('CurrencyCode', $param['CurrencyCode'])->find();

                if ($customerCurrency) {
                    // Update existing customer currency record
                    $customer_currency_model->updateWithBind($data, ['CurrencyCode' => $param['CurrencyCode']]);
                } else {
                    // Create new customer currency record
                    $data['base_currency_id'] = $baseCurrency['id'];
                    $data['CurrencyCode'] = $param['CurrencyCode'];
                    $data['CurrencyTitle'] = $baseCurrency['CurrencyTitle'];
                    $data['CurrencyTitleEn'] = $baseCurrency['CurrencyTitleEn'];
                    $data['CurrencyShortName'] = $baseCurrency['CurrencyShortName'];
                    $data['CurrencyFlag'] = $baseCurrency['CurrencyFlag'];
                    $data['IsEnable'] = $baseCurrency['IsEnable'];
                    $data['CreationDateInt'] = time();
                    $customer_currency_model->insertWithBind($data);
                }
            }

            // Record history using ORM
            $history_model = $this->currencyEquivalentHistoryModel();
            $dataHistory['Action'] = 'changePrice';
            $dataHistory['CurrencyCode'] = $param['CurrencyCode'];
            $dataHistory['EqAmount'] = $param['EqAmount'];
            $dataHistory['CreationDateInt'] = time();

            $history_model->insertWithBind($dataHistory);

            return "Success : قیمت معادل ارزی با موفقیت بروز رسانی شد";
        } else {
            return "Error : قیمت معادل نمیتواند خالی باشد";
        }
    }
    #endregion

    #region ResetCurrencyToDefault
    public function ResetCurrencyToDefault($param) {
        // Only non-admin users can reset to default (admin users already use the base records)
        if (TYPE_ADMIN == '1') {
            return "Error : این عملیات فقط برای کاربران غیر مدیر قابل انجام است";
        }

        $customer_currency_model = $this->getModel('customerCurrencyModel');
        
        // Get the base currency ID
        $currency_id = $param['id'];
        
        // Delete the customer-specific currency record
        $result = $customer_currency_model->delete(['base_currency_id' => $currency_id]);
        
        if ($result) {
            return "Success : تنظیمات ارز با موفقیت به حالت پیش فرض بازگردانده شد";
        } else {
            return "Error : خطا در بازگرداندن تنظیمات ارز به حالت پیش فرض";
        }
    }
    #endregion

}