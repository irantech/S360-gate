<?php
//    error_reporting(1);
//    error_reporting(E_ALL);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');

class userModuleReports extends clientAuth
{
    // property که مستقیم توسط Smarty استفاده می‌شود
    public $modules = array();
    public $Model ;
    public $total_modules_count;
    public $total_purchased_modules_count;

    public function __construct()
    {
        parent::__construct();
        $this->loadModulesForCurrentClient();

    }

    /**
     * بارگذاری ماژول‌ها برای مشتری فعلی با CLIENT_ID
     */
    private function loadModulesForCurrentClient()
    {
        // 1. گرفتن مشتری
        $clientId = CLIENT_ID;
        $model = $this->getModel('clientsModel');
        $clientArray = $model->get(array("id", "hash_id_whmcs"))
            ->where('id', $clientId)->all();

        if (!$clientArray) {
            $this->modules = array();
            $this->total_modules_count = 0;
            $this->total_purchased_modules_count = 0;
            return;
        }

        $client = $clientArray[0];
        $customerHash = $client['hash_id_whmcs'];

        // 2. گرفتن ماژول‌های مشتری
        $customersModulesJson = file_get_contents("https://safar360.com/gds/customersModules.json");
        $customersModules = json_decode($customersModulesJson, true);

        $customerData = null;
        if (is_array($customersModules)) {
            foreach ($customersModules as $c) {
                if ($c['customer_hash_id'] == $customerHash) {
                    $customerData = $c;
                    break;
                }
            }
        }

        $purchasedModuleIds = array();
        if ($customerData && isset($customerData['unique_module_ids'])) {
            $purchasedModuleIds = $customerData['unique_module_ids'];
        }

        // 3. گرفتن همه ماژول‌ها
        $allModulesJson = file_get_contents("https://safar360.com/gds/allModules.json");
        $allModules = json_decode($allModulesJson, true);

        $this->modules = array();
        if (is_array($allModules)) {
            foreach ($allModules as $m) {
                $this->modules[] = array(
                    'title' => $m['name'],
                    'desc'  => $m['description'],
                    'purchased' => in_array($m['id'], $purchasedModuleIds)
                );
            }

            // 4. مرتب‌سازی بر اساس purchased (true جلوتر)
            usort($this->modules, function($a, $b) {
                return ($a['purchased'] === $b['purchased']) ? 0 : ($a['purchased'] ? -1 : 1);
            });
        }

        // 5. محاسبه تعداد کل و خریداری شده
        $this->total_modules_count = is_array($allModules) ? count($allModules) : 0;
        $this->total_purchased_modules_count = is_array($purchasedModuleIds) ? count($purchasedModuleIds) : 0;
    }


    /**
     * تابع getModules برای دسترسی داخلی یا تست
     */
    public function getModules()
    {
        return $this->modules;
    }


}

