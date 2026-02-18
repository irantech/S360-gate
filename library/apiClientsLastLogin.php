<?php
require_once __DIR__ . '/../config/configBase.php';
try {
    $pdo = new PDO(PDO_DSN_BASE . ";charset=utf8", DB_USERNAME_BASE, DB_PASSWORD_BASE, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'status' => 'error',
        'message' => 'خطا در اتصال به دیتابیس: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// کوئری برای دریافت hash_id و آخرین زمان لاگین
$sql = "SELECT 
            c.hash_id_whmcs, 
            MAX(l.last_login) AS last_login
        FROM 
            clients_tb c
            LEFT JOIN login_tb l ON c.id = l.client_id
        WHERE c.hash_id_whmcs != ''
        GROUP BY c.hash_id_whmcs
        ORDER BY last_login DESC";

try {
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $output = [];
    foreach ($rows as $row) {
        $output[] = [
            'hash_id_whmcs' => $row['hash_id_whmcs'],
            'last_login' => $row['last_login']
        ];
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'status' => 'success',
        'data' => $output
    ], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'status' => 'error',
        'message' => 'خطا در اجرای کوئری: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}

?>