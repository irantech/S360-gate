<?php
// از سمت سایت iran-tech.com وصل میشیم و فاکتورهایی که پرداخت نشده را close می کنیم
//iran-tech.com/factors/CurlFromOtherSyatems/CheckFactorForSafar360.php

require_once __DIR__ . '/../config/configBase.php';

try {
    $pdo = new PDO(PDO_DSN_BASE . ";charset=utf8", DB_USERNAME_BASE, DB_PASSWORD_BASE, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => [],
        'fail' => [],
        'error' => 'خطا در اتصال به دیتابیس'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// دریافت JSON ارسال شده از سمت مشتری
$input = json_decode(file_get_contents('php://input'), true);

$success = [];
$fail = [];

if (is_array($input) && !empty($input)) {

    $stmt = $pdo->prepare(
        "UPDATE clients_tb 
         SET status_factor_user = 'Close' 
         WHERE hash_id_whmcs = :hash_id_whmcs"
    );

    foreach ($input as $hash_id_whmcs) {

        $hash_id_whmcs = trim($hash_id_whmcs);
        if ($hash_id_whmcs === '') continue;

        try {
            $stmt->execute([
                ':hash_id_whmcs' => $hash_id_whmcs
            ]);

            if ($stmt->rowCount() > 0) {
                $success[] = $hash_id_whmcs;
            } else {
                $fail[] = $hash_id_whmcs;
            }

        } catch (PDOException $e) {
            $fail[] = $hash_id_whmcs;
        }
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => $success,
        'fail' => $fail
    ], JSON_UNESCAPED_UNICODE);
}
?>
