<?php
header('Content-Type: application/json; charset=utf-8');

$jsonFile = __DIR__ . '/../customersModules.json';

// دریافت JSON خام
$raw = file_get_contents('php://input');
if (!$raw) {
    exit(json_encode(['status'=>'error','msg'=>'داده‌ای دریافت نشد']));
}

$customer = json_decode($raw, true);
if (!is_array($customer) || empty($customer['customer_hash_id'])) {
    exit(json_encode(['status'=>'error','msg'=>'JSON نامعتبر']));
}

$hashId = $customer['customer_hash_id'];

// اگر فایل وجود نداشت بساز
if (!file_exists($jsonFile)) {
    file_put_contents($jsonFile, json_encode([], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}

// خواندن فایل
$list = json_decode(file_get_contents($jsonFile), true);
if (!is_array($list)) {
    $list = [];
}

/* =============================
   REMOVE OLD CUSTOMER (IF EXISTS)
============================= */
$newList = [];
foreach ($list as $item) {
    if ($item['customer_hash_id'] != $hashId) {
        $newList[] = $item;
    }
}

/* =============================
   ADD NEW CUSTOMER (ALWAYS LAST)
============================= */
$newList[] = $customer;

// ذخیره نهایی
file_put_contents(
    $jsonFile,
    json_encode($newList, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);

echo json_encode([
    'status' => 'success',
    'msg'    => 'مشتری با موفقیت جایگزین شد',
    'customer_hash_id' => $hashId
]);
