<?php
session_start();
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');
$pageCallCurllFactorIrantech='yes';
require '../config/bootstrap.php';

if (IdWhmcsCurll != '(NULL)' && IdWhmcsCurll != '') {
    // آماده سازی داده برای ارسال
    $data = json_encode([
        'id_whmcs' => IdWhmcsCurll
    ]);

    $url = "https://www.iran-tech.com/factors/CurlFromOtherSyatems/ResultFactor.php";
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json; charset=UTF-8',
        'Content-Length: ' . strlen($data)
    ]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $response_to_send = [];

    if ($http_code == 200) {
        if ($response == 'ErrorDataInput') {
            $response_to_send['error'] = 'آیدی تیکت شما در بخش تمدید دامنه نیاز به تنظیم مجدد دارد. لطفا با شرکت تماس حاصل فرمائید';
        } else if ($response == 'ErrorDoesNotExist') {
            $response_to_send['error'] = 'آیدی تیکت شما توسط بخش اداری نیاز به تنظیم مجدد دارد. لطفا با شرکت تماس حاصل فرمائید';
        } else {
            $response_data = json_decode($response, true);

            // تابع برای تعیین کلاس
            $getClass = function($text) {
                if (strpos($text, 'پرداخت نشده ای دارید') !== false) return 'Orang';
                if (strpos($text, 'قطع شده است') !== false) return 'Red';
                if (strpos($text, 'پرداخت نموده اید') !== false || strpos($text, 'حساب می شود') !== false) return 'Green';
                return '';
            };

            $response_to_send = [
                'ShowDivFactorIrantech' => 'Yes',
                'dore1' => $response_data['dore1'],
                'dore2' => $response_data['dore2'],
                'dore3' => $response_data['dore3'],
                'ClassBoxDore1' => $getClass($response_data['dore1']),
                'ClassBoxDore2' => $getClass($response_data['dore2']),
                'ClassBoxDore3' => $getClass($response_data['dore3']),
            ];
            $_SESSION['access_blocked'] = false; // ثبت استفاده
            // اگر یکی از دوره ها قطع شده باشد
            if (
                strpos($response_data['dore1'], 'قطع شده است') !== false ||
                strpos($response_data['dore2'], 'قطع شده است') !== false ||
                strpos($response_data['dore3'], 'قطع شده است') !== false
            ) {
                $_SESSION['access_blocked'] = true; // ثبت ممنوعیت استفاده
                $response_to_send['stop_execution'] = true;

                //update table clients_tb baraye gozaresh be agahye afshar  1404/11/19
                require_once __DIR__ . '/../config/configBase.php';
                $pdo = new PDO(PDO_DSN_BASE . ";charset=utf8", DB_USERNAME_BASE, DB_PASSWORD_BASE, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
                $stmt = $pdo->prepare(
                    "UPDATE clients_tb 
                             SET status_factor_admin = 'Close' 
                             WHERE hash_id_whmcs = :hash_id_whmcs"
                );
                $stmt->execute([
                    ':hash_id_whmcs' => IdWhmcsCurll
                ]);

            }

        }
    } else {
        $response_to_send['error'] = 'لطفا با تیم Backend تماس حاصل فرمائید.';
    }

    echo json_encode($response_to_send);
    exit;
}
?>
