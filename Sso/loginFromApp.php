<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ===== ساخت baseUrl =====
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$domain = $_SERVER['HTTP_HOST'];
$baseUrl = $protocol . $domain;

// ===== دریافت token =====
if (!isset($_GET['token']) || $_GET['token'] === '') die("توکن ارسال نشده است.");
$decoded = base64_decode($_GET['token']);
if ($decoded === false) die("توکن Base64 نامعتبر است.");

// ===== فراخوانی سرویس mock token =====
$token_endpoint = $baseUrl . "/gds/Sso/mock/mock_connect_token.php";
$post_fields = http_build_query([
    "grant_type" => "refresh_token",
    "refresh_token" => $decoded
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $token_endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/x-www-form-urlencoded"]);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$response = curl_exec($ch);
$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$err = curl_error($ch);
curl_close($ch);

if ($response === false || $http_status >= 400) {
    die("خطا در فراخوانی سرویس توکن. http_status={$http_status}, err={$err}, resp={$response}");
}

$data = json_decode($response, true);
if (!is_array($data)) die("پاسخ توکن JSON معتبر نیست: " . htmlspecialchars($response));

// ===== استخراج userData =====
$userInfo = [];
if (isset($data['id_token'])) {
    $parts = explode('.', $data['id_token']);
    $payload_b64 = $parts[1];
    $payload_b64 .= str_repeat('=', 4 - (strlen($payload_b64) % 4)); // padding
    $payload_json = base64_decode(strtr($payload_b64, '-_', '+/'));
    $userInfo = json_decode($payload_json, true);
} elseif (isset($data['user_info'])) {
    $userInfo = $data['user_info'];
} else {
    $possible = ['given_name','family_name','firstname','lastname','mobile','Mobile','email'];
    foreach ($possible as $k) if(isset($data[$k])) $userInfo[$k] = $data[$k];
}

$userData = array(
    'firstname' => isset($userInfo['given_name']) ? $userInfo['given_name'] :
        (isset($userInfo['firstname']) ? $userInfo['firstname'] : ''),
    'lastname'  => isset($userInfo['family_name']) ? $userInfo['family_name'] :
        (isset($userInfo['lastname']) ? $userInfo['lastname'] : ''),
    'mobile'    => isset($userInfo['Mobile']) ? $userInfo['Mobile'] :
        (isset($userInfo['mobile']) ? $userInfo['mobile'] : ''),
    'email'     => isset($userInfo['email']) ? $userInfo['email'] : ''
);


// ===== ارسال به user_ajax.php و گرفتن هدر =====
$postData = [
    'flag' => 'memberRegisterSso',
    'entry' => $userData['mobile'],
    'password' => '123456',
    'name' => $userData['firstname'],
    'family' => $userData['lastname'],
    'mobile' => $userData['mobile'],
    'reagentCode' => '',
    'Type' => 'app'
];
// ===== ارسال به user_ajax.php و گرفتن فقط بدنه JSON =====
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/gds/user_ajax.php');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false); // فقط بدنه JSON
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$response = curl_exec($ch);
$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$err = curl_error($ch);
curl_close($ch);

// decode JSON
$info_member = json_decode($response, true);
// ===== ست کردن سشن با داده های برگشتی =====
if ($info_member && isset($info_member['data'])) {
    session_start();
    $_SESSION['Login']         = 'success';
    $_SESSION['nameUser']      = $info_member['data']['nameUser'];
    $_SESSION['userId']        = $info_member['data']['userId'];
    $_SESSION['typeUser']      = $info_member['data']['typeUser'];
    $_SESSION['cardNo']        = $info_member['data']['cardNo'];
    $_SESSION['LastLogin']     = time();
    $_SESSION['counterTypeId'] = $info_member['data']['counterTypeId'];
    $_SESSION['layout']        = $info_member['data']['layout'];
}
// ===== ریدایرکت نهایی =====
header("Location: $baseUrl");
exit;
?>