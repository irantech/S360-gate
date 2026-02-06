<?php
/**
 * Created by PhpStorm.
 * User: AbbasPC
 * Date: 10/28/2018
 * Time: 10:46 AM
 */
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
class currencyEquivalent extends clientAuth {

    #region __construct
    public function __construct() {

parent::__construct();
    }
    #endregion

    /**
     * @return bool|mixed|currencyModel
     */
    public function currencyModel() {
        return Load::getModel('currencyModel');
    }

    /**
     * @return bool|mixed|currencyEquivalentModel
     */
    public function currencyEquivalentModel() {
        return Load::getModel('currencyEquivalentModel');
    }
    /**
     * @return bool|mixed|customerCurrencyModel
     */
    public function customerCurrencyModel() {
        return Load::getModel('customerCurrencyModel');
    }

    /**
     * @return bool|mixed|currencyEquivalentHistoryModel
     */
    public function currencyEquivalentHistoryModel() {
        return $this->getModel('currencyEquivalentHistoryModel');
    }



    #region [ListCurrencyEquivalent]
    public function ListCurrencyEquivalent_old() {
        $currency = $this->currencyModel()->get()->where('IsEnable', 'Enable')->all();

        if (empty($currency)) {
            $currency = array();
        }

        $Equivalent = array();
        foreach ($currency as $currencyItem) {

                $resultCurrencyEquivalent = $this->currencyEquivalentModel()->get()->where('CurrencyCode', $currencyItem['CurrencyCode'])->find();


            if (!empty($resultCurrencyEquivalent)) {
                $resultCurrencyEquivalent['CurrencyTitle'] =  $currencyItem['CurrencyTitle'];
                $resultCurrencyEquivalent['CurrencyTitleEn'] =  $currencyItem['CurrencyTitleEn'];
                $resultCurrencyEquivalent['EqAmount'] =  $currencyItem['CurrencyPrice'];
                $resultCurrencyEquivalent['IsEnable'] =  $currencyItem['IsEnable'];
                $resultCurrencyEquivalent['CurrencyFlag']  =  $currencyItem['CurrencyFlag'];
                $Equivalent[] = $resultCurrencyEquivalent;
            }

        }
        return $Equivalent;
    }

    public function ListCurrencyEquivalentAdmin_old() {
        $currency = $this->currencyEquivalentModel()->get()->where('IsEnable', 'Enable')->all();

        if (empty($currency)) {
            $currency = array();
        }

        $Equivalent = array();
        foreach ($currency as $currencyItem) {

            $resultCurrencyEquivalent = $this->currencyModel()->get()->where('CurrencyCode', $currencyItem['CurrencyCode'])->find();

            if (!empty($resultCurrencyEquivalent)) {
                $resultCurrencyEquivalent['CurrencyTitle'] =  $resultCurrencyEquivalent['CurrencyTitle'];
                $resultCurrencyEquivalent['CurrencyTitleEn'] =  $resultCurrencyEquivalent['CurrencyTitleEn'];
                if(functions::checkClientConfigurationAccess('custom_currency')) {
                    $resultCurrencyEquivalent['EqAmount'] =  $currencyItem['EqAmount'];
                }else{
                    $resultCurrencyEquivalent['EqAmount'] =  $resultCurrencyEquivalent['CurrencyPrice'];
                }

                $resultCurrencyEquivalent['CurrencyFlag']  =  $resultCurrencyEquivalent['CurrencyFlag'];
                $Equivalent[] = $resultCurrencyEquivalent;
            }

        }
        return $Equivalent;
    }

    public function ListCurrencyEquivalentAdmin() {

        $Equivalent = array();

        $hasAccess = functions::checkClientConfigurationAccess('custom_currency');

        if ($hasAccess) {
            $currencies = $this->currencyEquivalentModel()->get()->where('IsEnable', 'Enable')->all();

            foreach ($currencies as $currencyItem) {
                $motherData = $this->currencyModel()->get()->where('CurrencyCode', $currencyItem['CurrencyCode'])->find();
                if (!empty($motherData)) {
                    $item = array(
                        'CurrencyCode'    => $motherData['CurrencyCode'],
                        'CurrencyTitle'   => $motherData['CurrencyTitle'],
                        'CurrencyTitleEn' => $motherData['CurrencyTitleEn'],
                        'CurrencyFlag'    => $motherData['CurrencyFlag'],
                        'EqAmount'        => $currencyItem['EqAmount'],
                    );
                    $Equivalent[] = $item;
                }
            }

        } else {
            $currencies = $this->currencyModel()->get()->where('IsEnable', 'Enable')->all();

            foreach ($currencies as $currencyItem) {
                $item = array(
                    'CurrencyCode'    => $currencyItem['CurrencyCode'],
                    'CurrencyTitle'   => $currencyItem['CurrencyTitle'],
                    'CurrencyTitleEn' => $currencyItem['CurrencyTitleEn'],
                    'CurrencyFlag'    => $currencyItem['CurrencyFlag'],
                    'EqAmount'        => $currencyItem['CurrencyPrice'],
                );
                $Equivalent[] = $item;
            }
        }

        return $Equivalent;
    }

    public function ListCurrencyEquivalent() {

        $Equivalent = array();

        $hasAccess = functions::checkClientConfigurationAccess('custom_currency');

        if ($hasAccess) {
            $currencies = $this->currencyEquivalentModel()->get()->where('IsEnable', 'Enable')->all();

            foreach ($currencies as $currencyItem) {
                $motherData = $this->currencyModel()->get()->where('CurrencyCode', $currencyItem['CurrencyCode'])->where('IsEnable', 'Enable')->find();
                if (!empty($motherData)) {
                    $item = array(
                        'CurrencyCode'    => $motherData['CurrencyCode'],
                        'CurrencyTitle'   => $motherData['CurrencyTitle'],
                        'CurrencyTitleEn' => $motherData['CurrencyTitleEn'],
                        'CurrencyFlag'    => $motherData['CurrencyFlag'],
                        'EqAmount'        => $currencyItem['EqAmount'],
                    );
                    $Equivalent[] = $item;
                }
            }

        } else {
            $currencies = $this->currencyModel()->get()->where('IsEnable', 'Enable')->all();

            foreach ($currencies as $currencyItem) {
                $item = array(
                    'CurrencyCode'    => $currencyItem['CurrencyCode'],
                    'CurrencyTitle'   => $currencyItem['CurrencyTitle'],
                    'CurrencyTitleEn' => $currencyItem['CurrencyTitleEn'],
                    'CurrencyFlag'    => $currencyItem['CurrencyFlag'],
                    'EqAmount'        => $currencyItem['CurrencyPrice'],
                );
                $Equivalent[] = $item;
            }
        }

        return $Equivalent;
    }

    #endregion

    public function ListCurrencyEquivalentObj($only_enabled_currency_equivalent = null)
    {
        $currencies = $this->getModel('currencyModel')->get()->where('IsEnable', 'Enable')->all();
        if (empty($currencies)) {
            $currencies = array();
        }
        $Equivalent = '';
        $resultCurrencyEquivalent = array();
        foreach ($currencies as $currency) {
            // Determine which model to use based on TYPE_ADMIN
            if (TYPE_ADMIN == '1') {
                $currency_equivalent = $this->getModel('currencyEquivalentModel')->get();
                $currency_equivalent = $currency_equivalent->where('CurrencyCode', $currency['CurrencyCode']);
                if ($only_enabled_currency_equivalent) {
                    $currency_equivalent = $currency_equivalent->where('IsEnable', 'Enable');
                }
                $currency_equivalent = $currency_equivalent->find();
            } else {
                // First check customer-specific equivalent
                $currency_equivalent = $this->getModel('customerCurrencyEquivalentModel')->get();
                $currency_equivalent = $currency_equivalent->where('CurrencyCode', $currency['CurrencyCode']);
                if ($only_enabled_currency_equivalent) {
                    $currency_equivalent = $currency_equivalent->where('IsEnable', 'Enable');
                }
                $customer_equivalent = $currency_equivalent->find();

                if (!$customer_equivalent) {
                    // Fall back to base equivalent
                    $currency_equivalent = $this->getModel('currencyEquivalentModel')->get();
                    $currency_equivalent = $currency_equivalent->where('CurrencyCode', $currency['CurrencyCode']);
                    if ($only_enabled_currency_equivalent) {
                        $currency_equivalent = $currency_equivalent->where('IsEnable', 'Enable');
                    }
                    $currency_equivalent = $currency_equivalent->find();
                } else {
                    $currency_equivalent = $customer_equivalent;
                }
            }

            if (!empty($currency_equivalent)) {
                $resultCurrencyEquivalent['CurrencyTitle'] = $currency['CurrencyTitle'];
                $resultCurrencyEquivalent['CurrencyTitleEn'] = $currency['CurrencyTitleEn'];
                $resultCurrencyEquivalent['EqAmount'] = $currency['CurrencyPrice'];
                $resultCurrencyEquivalent['CurrencyFlag'] = $currency['CurrencyFlag'];
                $resultCurrencyEquivalent['CurrencyCode'] = $currency_equivalent['CurrencyCode'];
                $Equivalent .= $resultCurrencyEquivalent;
            }
        }
        return json_encode($Equivalent, 256);
    }
    #endregion

    #region [InsertCurrency]
    public function InsertCurrency($param) {
        // Only admin can insert new currencies to the base database
        if (TYPE_ADMIN != '1') {
            return "Error : شما دسترسی لازم برای ایجاد معادل ارزی جدید را ندارید";
        }

        $data['EqAmount'] = $param['EqAmount'];
        $data['IsEnable'] = "Enable";
        $data['CurrencyCode'] = $param['CurrencyCode'];
        $data['CreationDateInt'] = time();

        // Insert using ORM
        $currency = $this->currencyEquivalentModel()->insertWithBind($data);

        if ($currency) {
            $dataHistory['Action'] = 'add';
            $dataHistory['CurrencyCode'] = $data['CurrencyCode'];
            $dataHistory['EqAmount'] = $data['EqAmount'];
            $dataHistory['CreationDateInt'] = time();

            $this->currencyEquivalentHistoryModel()->insertWithBind($dataHistory);

            return "Success : معادل ارزی جدید با موفقیت ثبت شد";
        } else {
            return "Error : خطا در ثبت معادل ارزی جدید";
        }
    }
    #endregion

    #region [ListCurrency]

    public function ListCurrency() {
        return $this->currencyModel()->get()->where('IsEnable','Enable')->all();

    }
    #endregion

    #region [StatusCurrencyEquivalent]
    public function StatusCurrencyEquivalent($param) {
        if (isset($param['CurrencyCode']) && !empty($param['CurrencyCode'])) {
            // Determine which model to use based on TYPE_ADMIN
            if (TYPE_ADMIN == '1') {
                $currencyEquivalent = $this->currencyEquivalentModel()->get()->where('CurrencyCode', $param['CurrencyCode'])->find();
                $targetModel = $this->currencyEquivalentModel();
            } else {
                // For non-admin, check if record exists in customer model
                $currencyEquivalent = $this->getModel('customerCurrencyEquivalentModel')->get()->where('CurrencyCode', $param['CurrencyCode'])->find();

                if (!$currencyEquivalent) {
                    // If not in customer model, get from base model to create a copy
                    $currencyEquivalent = $this->currencyEquivalentModel()->get()->where('CurrencyCode', $param['CurrencyCode'])->find();
                }

                $targetModel = $this->getModel('customerCurrencyEquivalentModel');
            }

            if (!empty($currencyEquivalent)) {
                if ($currencyEquivalent['IsEnable'] == 'Enable') {
                    $data['IsEnable'] = 'Disable';
                } else {
                    $data['IsEnable'] = 'Enable';
                }

                if (TYPE_ADMIN == '1' || !empty($currencyEquivalent['id'])) {
                    // Update existing record
                    $targetModel->updateWithBind($data, ['CurrencyCode' => $param['CurrencyCode']]);
                } else {
                    // Create new customer record
                    $data['CurrencyCode'] = $param['CurrencyCode'];
                    $data['EqAmount'] = $currencyEquivalent['EqAmount'];
                    $data['DefaultCurrency'] = $currencyEquivalent['DefaultCurrency'];
                    $data['CreationDateInt'] = time();
                    $targetModel->insertWithBind($data);
                }

                // Record history
                $dataHistory['Action'] = ($data['IsEnable'] == 'Enable') ? 'active' : 'inactive';
                $dataHistory['CurrencyCode'] = $param['CurrencyCode'];
                $dataHistory['EqAmount'] = $currencyEquivalent['EqAmount'];
                $dataHistory['CreationDateInt'] = time();

                $this->currencyEquivalentHistoryModel()->insertWithBind($dataHistory);

                return "Success : وضعیت معادل ارزی با موفقیت بروز رسانی شد";
            } else {
                return "Error : درخواست معتبر نمی باشد";
            }
        } else {
            return "Error : درخواست معتبر نمی باشد";
        }
    }
    #endregion

    #region [DefaultCurrencyEquivalent]
    public function DefaultCurrencyEquivalent($param) {
        if (isset($param['CurrencyCode']) && !empty($param['CurrencyCode'])) {
            // Determine which model to use based on TYPE_ADMIN
            if (TYPE_ADMIN == '1') {
                $targetModel = $this->currencyEquivalentModel();
                $defaultCurrency = $targetModel->get()->where('DefaultCurrency', '1')->find();
            } else {
                $targetModel = $this->getModel('customerCurrencyEquivalentModel');
                $defaultCurrency = $targetModel->get()->where('DefaultCurrency', '1')->find();
            }

            if (!empty($defaultCurrency)) {
                // Update old default currency
                $targetModel->updateWithBind(['DefaultCurrency' => '0'], ['DefaultCurrency' => '1']);

                // Update new default currency
                if (TYPE_ADMIN == '1') {
                    $currencyToUpdate = $targetModel->get()->where('CurrencyCode', $param['CurrencyCode'])->find();

                    if ($currencyToUpdate) {
                        $targetModel->updateWithBind(['DefaultCurrency' => '1'], ['CurrencyCode' => $param['CurrencyCode']]);
                    } else {
                        // Get currency from base model
                        $baseCurrency = $this->currencyModel()->get()->where('CurrencyCode', $param['CurrencyCode'])->find();

                        if ($baseCurrency) {
                            $data = [
                                'DefaultCurrency' => '1',
                                'CurrencyCode' => $param['CurrencyCode'],
                                'EqAmount' => $baseCurrency['CurrencyPrice'],
                                'IsEnable' => 'Enable',
                                'CreationDateInt' => time()
                            ];
                            $targetModel->insertWithBind($data);
                        } else {
                            return "Error : ارز مورد نظر یافت نشد";
                        }
                    }
                } else {
                    // For non-admin users
                    $currencyToUpdate = $targetModel->get()->where('CurrencyCode', $param['CurrencyCode'])->find();

                    if ($currencyToUpdate) {
                        $targetModel->updateWithBind(['DefaultCurrency' => '1'], ['CurrencyCode' => $param['CurrencyCode']]);
                    } else {
                        // Get from base model
                        $baseCurrency = $this->currencyEquivalentModel()->get()->where('CurrencyCode', $param['CurrencyCode'])->find();

                        if (!$baseCurrency) {
                            // Get from currency model
                            $baseCurrency = $this->currencyModel()->get()->where('CurrencyCode', $param['CurrencyCode'])->find();

                            if ($baseCurrency) {
                                $data = [
                                    'DefaultCurrency' => '1',
                                    'CurrencyCode' => $param['CurrencyCode'],
                                    'EqAmount' => $baseCurrency['CurrencyPrice'],
                                    'IsEnable' => 'Enable',
                                    'CreationDateInt' => time()
                                ];
                            } else {
                                return "Error : ارز مورد نظر یافت نشد";
                            }
                        } else {
                            $data = [
                                'DefaultCurrency' => '1',
                                'CurrencyCode' => $baseCurrency['CurrencyCode'],
                                'EqAmount' => $baseCurrency['EqAmount'],
                                'IsEnable' => $baseCurrency['IsEnable'],
                                'CreationDateInt' => time()
                            ];
                        }

                        $targetModel->insertWithBind($data);
                    }
                }

                return "Success : بروز رسانی ارز پیش فرض با موفقیت انجام شد";
            } else {
                // No default currency exists yet
                if (TYPE_ADMIN == '1') {
                    $currencyToUpdate = $targetModel->get()->where('CurrencyCode', $param['CurrencyCode'])->find();

                    if ($currencyToUpdate) {
                        $targetModel->updateWithBind(['DefaultCurrency' => '1'], ['CurrencyCode' => $param['CurrencyCode']]);
                    } else {
                        // Get currency from base model
                        $baseCurrency = $this->currencyModel()->get()->where('CurrencyCode', $param['CurrencyCode'])->find();

                        if ($baseCurrency) {
                            $data = [
                                'DefaultCurrency' => '1',
                                'CurrencyCode' => $param['CurrencyCode'],
                                'EqAmount' => $baseCurrency['CurrencyPrice'],
                                'IsEnable' => 'Enable',
                                'CreationDateInt' => time()
                            ];
                            $targetModel->insertWithBind($data);
                        } else {
                            return "Error : ارز مورد نظر یافت نشد";
                        }
                    }
                } else {
                    // For non-admin users
                    $currencyToUpdate = $targetModel->get()->where('CurrencyCode', $param['CurrencyCode'])->find();

                    if ($currencyToUpdate) {
                        $targetModel->updateWithBind(['DefaultCurrency' => '1'], ['CurrencyCode' => $param['CurrencyCode']]);
                    } else {
                        // Get from base model
                        $baseCurrency = $this->currencyEquivalentModel()->get()->where('CurrencyCode', $param['CurrencyCode'])->find();

                        if (!$baseCurrency) {
                            // Get from currency model
                            $baseCurrency = $this->currencyModel()->get()->where('CurrencyCode', $param['CurrencyCode'])->find();

                            if ($baseCurrency) {
                                $data = [
                                    'DefaultCurrency' => '1',
                                    'CurrencyCode' => $param['CurrencyCode'],
                                    'EqAmount' => $baseCurrency['CurrencyPrice'],
                                    'IsEnable' => 'Enable',
                                    'CreationDateInt' => time()
                                ];
                            } else {
                                return "Error : ارز مورد نظر یافت نشد";
                            }
                        } else {
                            $data = [
                                'DefaultCurrency' => '1',
                                'CurrencyCode' => $baseCurrency['CurrencyCode'],
                                'EqAmount' => $baseCurrency['EqAmount'],
                                'IsEnable' => $baseCurrency['IsEnable'],
                                'CreationDateInt' => time()
                            ];
                        }

                        $targetModel->insertWithBind($data);
                    }
                }

                return "Success : بروز رسانی ارز پیش فرض با موفقیت انجام شد";
            }
        } else {
            return "Error : درخواست معتبر نمی باشد";
        }
    }
    #endregion

    #region [InfoCurrency]
    public function InfoCurrency($Code) {
        $is_json = false;

        if(is_array($Code)){
            $is_json_print = $Code['is_json'];
            $Code = $Code['code'];
            $is_json = $is_json_print;
        }

        if($Code > 0) {






            $currency = $this->currencyModel()->get()
                ->where('CurrencyCode', $Code)
                ->where('IsEnable', 'Enable')
                ->find();
            // Determine which model to use based on TYPE_ADMIN
            $hasAccess = functions::checkClientConfigurationAccess('custom_currency');

            if ($hasAccess) {
                // First check customer-specific equivalent
                $customer_default_currency = $this->currencyEquivalentModel()->get()
                    ->where('CurrencyCode', $Code)
                    ->find();


//                if ($customer_default_currency) {
//                    // Fall back to base equivalent
//                    $currency = $customer_default_currency;
//                }
            }


            if ($hasAccess && isset($customer_default_currency['EqAmount']) && $customer_default_currency['EqAmount'] > 0) {
                $currency['EqAmount'] = $customer_default_currency['EqAmount'];
            }else{
           $currency['EqAmount'] = $currency['CurrencyPrice'];
       }
        } else {
            $currency = array();
        }



        return $is_json ? functions::withSuccess($currency, 200, 'successfully fetch data') : $currency;
    }
    #endregion

    #region [CurrencyEquivalent]
    public function InfoCurrencyObj($code) {
        if ($code > 0) {
            // Determine which model to use based on TYPE_ADMIN
            if (TYPE_ADMIN == '1') {
                $resultCurrencyEquivalent = $this->currencyEquivalentModel()->get()->where('CurrencyCode', $code)->find();
            } else {
                // First check customer-specific equivalent
                $resultCurrencyEquivalent = $this->getModel('customerCurrencyEquivalentModel')->get()->where('CurrencyCode', $code)->find();

                if (!$resultCurrencyEquivalent) {
                    // Fall back to base equivalent
                    $resultCurrencyEquivalent = $this->currencyEquivalentModel()->get()->where('CurrencyCode', $code)->find();
                }
            }

            if (!empty($resultCurrencyEquivalent)) {
                $resultCurrency = $this->getModel('currencyModel')->get()->where('CurrencyCode', $code)->find();
                $resultCurrencyEquivalent['CurrencyTitleEn'] = $resultCurrency['CurrencyTitleEn'];
                $resultCurrencyEquivalent['CurrencyTitleFa'] = $resultCurrency['CurrencyTitle'];
                $resultCurrencyEquivalent['EqAmount'] = $resultCurrency['CurrencyPrice'];
                $resultCurrencyEquivalent['CurrencyFlag'] = $resultCurrency['CurrencyFlag'];
                $resultCurrencyEquivalent['CurrencyShortName'] = $resultCurrency['CurrencyShortName'];
            } else {
                $resultCurrencyEquivalent = array();
            }
        } else {
            $resultCurrencyEquivalent = array();
        }
        return json_encode($resultCurrencyEquivalent);
    }
    #endregion

    #region CurrencyEquivalent
    public function CurrencyEquivalent($Param) {
        if(is_array($Param))
        {
            $currency_code = $Param['code'];
        }else{
            $currency_code = $Param;
        }
//        Session::setCurrency($currency_code);

        return $this->InfoCurrency($Param);
    }
    #endregion


    #region CurrencyDefault
    public function CurrencyDefault() {

        $default_currency_code = $this->currencyEquivalentModel()->get()
            ->where('DefaultCurrency', '1')
            ->where('IsEnable', 'Enable')
            ->find();

        $default_currency = $this->currencyModel()->get()
            ->where('CurrencyCode', $default_currency_code['CurrencyCode'])
            ->where('IsEnable', 'Enable')
            ->find();
        // Determine which model to use based on TYPE_ADMIN
        if (TYPE_ADMIN != '1')   {
            // First check customer-specific equivalent
            $customer_default_currency = $this->customerCurrencyModel()->get()
                ->where('CurrencyCode', $default_currency_code['CurrencyCode'])
                ->where('IsEnable', 'Enable')
                ->find();


            if ($customer_default_currency) {
                // Fall back to base equivalent
                $default_currency = $customer_default_currency;
            }
        }




        return $default_currency;
    }
    #endregion


    public function calculateEquivalent($currency, $amount) {
        $resultCurrency = $this->getModel('currencyModel')->get()->where('CurrencyShortName', $currency)->find();
        $currency_code = $resultCurrency['CurrencyCode'];
        $calculated_amount = 0;

        if($currency_code > 0) {
            // Determine which model to use based on TYPE_ADMIN
            if (TYPE_ADMIN == '1') {
                $resultCurrencyEquivalent = $this->currencyEquivalentModel()->get()->where('CurrencyCode', $currency_code)->find();
            } else {
                // First check customer-specific equivalent
                $resultCurrencyEquivalent = $this->getModel('customerCurrencyEquivalentModel')->get()->where('CurrencyCode', $currency_code)->find();

                if (!$resultCurrencyEquivalent) {
                    // Fall back to base equivalent
                    $resultCurrencyEquivalent = $this->currencyEquivalentModel()->get()->where('CurrencyCode', $currency_code)->find();
                }
            }

            if (!empty($resultCurrencyEquivalent)) {
                $calculated_amount = $resultCurrencyEquivalent['EqAmount'] * $amount;
            }
        }

        return $calculated_amount;
    }


    public function ListCurrencyCustomer() {
        // همه ارزها از جدول مادر
        $currencyAll = $this->getModel('currencyModel')->get()->where('IsEnable', 'Enable')->all();

        // همه داده‌های جدول مشتری
        $customerEquivalents = $this->currencyEquivalentModel()->get()->all();
        $customerMap = [];
        foreach ($customerEquivalents as $ce) {
            $customerMap[$ce['CurrencyCode']] = $ce;
        }

        $list = [];
        $number = 0;

        foreach ($currencyAll as $currency) {
            $number++;
            $currencyCode = $currency['CurrencyCode'];

            // وضعیت پیش فرض ستون‌ها
            $isActive = 'non_active';
            $isDefault = 'non_default';
            $IsEnable = 'Disable';
            $DefaultCurrency = '0';

            // بررسی در جدول مشتری
            if (isset($customerMap[$currencyCode])) {
                $cust = $customerMap[$currencyCode];
                $IsEnable = $cust['IsEnable'];
                $DefaultCurrency = $cust['DefaultCurrency'];

                if ($cust['IsEnable'] == 'Enable') {
                    $isActive = 'is_active';
                }
                if ($cust['DefaultCurrency'] == '1') {
                    $isDefault = 'is_default';
                }

                // قیمت از جدول مشتری اگر موجود باشه
                if (!empty($cust['EqAmount'])) {
                    $CurrencyPrice = $cust['EqAmount'];
                    $priceSource = 'customer';
                }else{
                    $CurrencyPrice = $currency['CurrencyPrice'];
                    $priceSource = 'master';
                }
            }
            else {
                // اگر در جدول مشتری وجود ندارد، از جدول مادر می‌خوانیم
                $CurrencyPrice = $currency['CurrencyPrice'];
                $priceSource = 'master';
            }

            $list[] = [
                'id' => $currency['id'],
                'CurrencyTitle' => $currency['CurrencyTitle'],
                'CurrencyTitleEn' => $currency['CurrencyTitleEn'],
                'CurrencyShortName' => $currency['CurrencyShortName'],
                'CurrencyFlag' => $currency['CurrencyFlag'],
                'CurrencyPrice' => $CurrencyPrice,
                'CurrencyCode' => $currencyCode,
                'IsEnable' => $IsEnable,
                'DefaultCurrency' => $DefaultCurrency,
                'active' => $isActive,
                'default' => $isDefault,
                'is_customized' => isset($cust),
                'price_source' => $priceSource
            ];
        }

        return $list;
    }






    public function ListCurrencyCustomer_old() {
        // Get all currencies from the base database
        $currencyAll = $this->getModel('currencyModel')->get()->all();

        // Get base currency equivalents
        $baseCurrencyEquivalents = $this->currencyEquivalentModel()->get()->all();

        // Create a map of base currency equivalents by CurrencyCode for quick lookup
        $baseCurrencyEquivalentMap = [];
        foreach ($baseCurrencyEquivalents as $equivalent) {
            $baseCurrencyEquivalentMap[$equivalent['CurrencyCode']] = $equivalent;
        }

        // If not admin, get customer-specific currency equivalents and currencies
        $customerCurrencyEquivalentMap = [];
        $customerCurrencyMap = [];
        if (TYPE_ADMIN != '1') {
            // Get customer currency equivalents
            $customerCurrencyEquivalents = $this->getModel('customerCurrencyEquivalentModel')->get()->all();
            foreach ($customerCurrencyEquivalents as $equivalent) {
                $customerCurrencyEquivalentMap[$equivalent['CurrencyCode']] = $equivalent;
            }

            // Get customer currencies
            $customerCurrencies = $this->getModel('customerCurrencyModel')->get()->all();
            foreach ($customerCurrencies as $currency) {
                $customerCurrencyMap[$currency['base_currency_id']] = $currency;
            }
        }

        $list = [];
        foreach ($currencyAll as $currency) {
            $currencyData = $currency;
            $isActive = 'non_active';
            $isDefault = 'non_default';

            // Check if currency has an equivalent in base database
            if (isset($baseCurrencyEquivalentMap[$currency['CurrencyCode']])) {
                $baseEquivalent = $baseCurrencyEquivalentMap[$currency['CurrencyCode']];


                if ($baseEquivalent['IsEnable'] == 'Enable') {
                    $isActive = 'is_active';
                }

                if ($baseEquivalent['DefaultCurrency'] == '1') {
                    $isDefault = 'is_default';
                }
            }

            // If not admin, check if currency has a customer-specific version and override data
//            var_dump($customerCurrencyMap);
            if (TYPE_ADMIN != '1') {

                // Override with customer currency data if available
                if (isset($customerCurrencyMap[$currency['id']])) {
                    $customerCurrency = $customerCurrencyMap[$currency['id']];

                    // Override currency properties with customer currency properties
                    foreach ($customerCurrency as $prop => $value) {
                        // Skip the ID field and base_currency_id field
                        if ($prop != 'id' && $prop != 'base_currency_id') {
                            $currencyData[$prop] = $value;
                        }
                    }

                    // Mark as customized since it exists in customer database
                    $currencyData['is_customized'] = true;
                } else {
                    // Not customized
                    $currencyData['is_customized'] = false;
                }

                // Override with customer currency equivalent data if available
                if (isset($customerCurrencyEquivalentMap[$currency['CurrencyCode']])) {
                    $customerEquivalent = $customerCurrencyEquivalentMap[$currency['CurrencyCode']];


                    if ($customerEquivalent['IsEnable'] == 'Enable') {
                        $isActive = 'is_active';
                    } else {
                        $isActive = 'non_active';
                    }

                    if ($customerEquivalent['DefaultCurrency'] == '1') {
                        $isDefault = 'is_default';
                    } else {
                        $isDefault = 'non_default';
                    }
                }
            } else {
                // Admin always sees base data, never customized
                $currencyData['is_customized'] = false;
            }

             $list[] = [
                'id' => $currency['id'],

                'CurrencyTitle' => $currencyData['CurrencyTitle'],
                'CurrencyTitleEn' => $currencyData['CurrencyTitleEn'],
                'CurrencyShortName' => $currencyData['CurrencyShortName'],
                'CurrencyFlag' => $currencyData['CurrencyFlag'],
                'CurrencyPrice' => $currencyData['CurrencyPrice'],
                'CurrencyCode' => $currency['CurrencyCode'],
                'IsEnable' => $currencyData['IsEnable'],
                'DefaultCurrency' => $baseEquivalent['DefaultCurrency'],
                'active' => $isActive,
                'default' => $isDefault,
                'is_customized' => isset($currencyData['is_customized']) ? $currencyData['is_customized'] : false
            ];
        }

        return $list;
    }





    #region [StatusCurrencyCustomer]
    public function StatusCurrencyCustomer($param) {
        if (isset($param['CurrencyCode']) && !empty($param['CurrencyCode'])) {

                $targetModel = $this->currencyEquivalentModel();
//                $currencyModel = $this->customerCurrencyModel();
                $currencyEquivalent = $targetModel->get()->where('CurrencyCode', $param['CurrencyCode'])->find();


            if (!empty($currencyEquivalent)) {
                if ($currencyEquivalent['IsEnable'] == 'Enable') {
                    $data['IsEnable'] = 'Disable';
                } else {
                    $data['IsEnable'] = 'Enable';
                }


                $targetModel->updateWithBind($data, ['CurrencyCode' => $param['CurrencyCode']]);
//                $currencyModel->updateWithBind($data, ['CurrencyCode' => $param['CurrencyCode']]);
                return "Success : وضعیت معادل ارزی با موفقیت بروز رسانی شد";
            } else {
                // Get currency info from currency model
                $infoCurrency = $this->getModel('currencyModel')->get()->where('CurrencyCode', $param['CurrencyCode'])->find();
                if ($infoCurrency) {
                    $data['EqAmount'] = $infoCurrency['CurrencyPrice'];
                    $data['IsEnable'] = "Enable";
                    $data['DefaultCurrency'] = "0";
                    $data['CurrencyCode'] = $param['CurrencyCode'];
                    $data['CreationDateInt'] = time();

                    $targetModel->insertWithBind($data);
                    return "Success : وضعیت معادل ارزی با موفقیت بروز رسانی شد";
                } else {
                    return "Error : ارز مورد نظر یافت نشد";
                }
            }
        } else {
            return "Error : درخواست معتبر نمی باشد";
        }
    }
    #endregion


    #region [Default_Currency_Equivalent]
    public function DefaultCurrencyCustomer_old($param) {


        if (isset($param['CurrencyCode']) && !empty($param['CurrencyCode'])) {
            // Determine which model to use based on TYPE_ADMIN
            if (TYPE_ADMIN == '1') {
                $targetModel = $this->currencyEquivalentModel();
                $currencyEquivalent = $targetModel->get()->where('CurrencyCode', $param['CurrencyCode'])->find();
            } else {
                $targetModel = $this->currencyEquivalentModel();
                $currencyEquivalent = $targetModel->get()->where('CurrencyCode', $param['CurrencyCode'])->find();
            }

            if (!empty($currencyEquivalent)) {
                if ($currencyEquivalent['DefaultCurrency'] == '1') {
                    $data['DefaultCurrency'] = '0';
                } else {
                    $data['DefaultCurrency'] = '1';
                }

                $targetModel->updateWithBind($data, ['CurrencyCode' => $param['CurrencyCode']]);

                return "Success : وضعیت معادل ارزی با موفقیت بروز رسانی شد";
            } else {
                // Get currency info from currency model
                $infoCurrency = $this->getModel('currencyModel')->get()->where('CurrencyCode', $param['CurrencyCode'])->find();

                if ($infoCurrency) {
                    $data['EqAmount'] = $infoCurrency['CurrencyPrice'];
                    $data['IsEnable'] = "Enable";
                    $data['DefaultCurrency'] = "1";
                    $data['CurrencyCode'] = $param['CurrencyCode'];
                    $data['CreationDateInt'] = time();

                    $targetModel->insertWithBind($data);
                    $targetModel->updateWithBind(['DefaultCurrency' => '0'], ['CurrencyCode !=' => $param['CurrencyCode']]);

                    return "Success : وضعیت معادل ارزی با موفقیت بروز رسانی شد";
                } else {
                    return "Error : ارز مورد نظر یافت نشد";
                }
            }
        } else {
            return "Error : درخواست معتبر نمی باشد";
        }
    }


    public function DefaultCurrencyCustomer($param) {


        if (isset($param['CurrencyCode']) && !empty($param['CurrencyCode'])) {
                $currencyCode = $param['CurrencyCode'];
                $targetModel = $this->currencyEquivalentModel();
            // بررسی اینکه ارز مورد نظر در جدول مشتری وجود دارد یا نه
            $currencyEquivalent = $targetModel->get()->where('CurrencyCode', $currencyCode)->find();



            if (!empty($currencyEquivalent)) {
                // اگر فعال است → فقط خودش را غیرفعال کن
                if ($currencyEquivalent['DefaultCurrency'] == '1') {

                    $targetModel->updateWithBind(
                        ['DefaultCurrency' => '0'],
                        ['CurrencyCode' => $currencyCode]
                    );

                    return "Success : وضعیت ارز انتخابی غیرفعال شد";

                } else {
                    // اگر غیرفعال است → خودش را فعال و بقیه را غیرفعال کن

                    // بقیه را غیرفعال کن (بدون استفاده از CurrencyCode != برای جلوگیری از خطا)
                    $allCurrencies = $targetModel->get()->all();
                    if (!empty($allCurrencies)) {
                        foreach ($allCurrencies as $item) {
                            if ($item['CurrencyCode'] != $currencyCode) {
                                $targetModel->updateWithBind(['DefaultCurrency' => '0'], ['CurrencyCode' => $item['CurrencyCode']]);
                            }
                        }
                    }

                    // همین ارز را فعال کن
                    $targetModel->updateWithBind(['DefaultCurrency' => '1'], ['CurrencyCode' => $currencyCode]);

                    return "Success : وضعیت ارز انتخابی فعال و سایر ارزها غیرفعال شدند";
                }
            } else {
                // اگر ارز در جدول مشتری وجود ندارد
                $infoCurrency = $this->getModel('currencyModel')->get()->where('CurrencyCode', $currencyCode)->find();

                if ($infoCurrency) {

                    // بقیه را غیرفعال کن
                    $allCurrencies = $targetModel->get()->all();
                    if (!empty($allCurrencies)) {
                        foreach ($allCurrencies as $item) {
                            $targetModel->updateWithBind(['DefaultCurrency' => '0'], ['CurrencyCode' => $item['CurrencyCode']]);
                        }
                    }

                    // ارز جدید را از جدول مادر اضافه و فعال کن
                    $data['EqAmount']        = $infoCurrency['CurrencyPrice'];
                    $data['IsEnable']        = "Enable";
                    $data['DefaultCurrency'] = "1";
                    $data['CurrencyCode']    = $infoCurrency['CurrencyCode'];
                    $data['CreationDateInt'] = time();

                    $targetModel->insertWithBind($data);

                    return "Success : ارز جدید اضافه و فعال شد و سایر ارزها غیرفعال شدند";

                } else {
                    return "Error : ارز مورد نظر یافت نشد";
                }
            }
        }



    #endregion




}


    public function UpdatePriceCustomerCurrency($param)
    {
        if (empty($param['EqAmount'])) {
            return "Error : قیمت معادل نمی‌تواند خالی باشد";
        }

        $currencyEquivalentModel = $this->getModel('currencyEquivalentModel');

        $data['EqAmount'] = $param['EqAmount'];

        // تلاش برای آپدیت رکورد مربوط به ارز
        $updated = $currencyEquivalentModel->updateWithBind(
            $data,
            ['CurrencyCode' => $param['CurrencyCode']]
        );

        if ($updated) {
            return "Success : قیمت معادل ارزی با موفقیت به‌روزرسانی شد";
        } else {
            return "Error : ارز مورد نظر برای به‌روزرسانی یافت نشد";
        }
    }





}