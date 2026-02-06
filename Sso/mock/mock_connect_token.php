<?php
// mock_connect_token.php
header('Content-Type: application/json; charset=utf-8');

// helper: base64url encode (بدون padding)
function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

// دریافت ورودی (فرمت x-www-form-urlencoded expected)
$grant_type = isset($_POST['grant_type']) ? $_POST['grant_type'] : '';
$refresh_token = isset($_POST['refresh_token']) ? $_POST['refresh_token'] : 'test-refresh-token';

// اگر خواستی می‌تونی بر اساس $refresh_token پاسخ متفاوت بسازی.
// برای سادگی ما همیشه یک id_token و access_token ثابت برمی‌گردونیم.

$header = array("alg" => "HS256", "typ" => "JWT");
$payload = array(
    "given_name" => "علی",
    "family_name" => "محمدی",
    "email" => "ali@example.com",
    "Mobile" => "09197597588",
    "iat" => time(),
    "exp" => time() + 3600,
    "iss" => "mock.sso",
    // در صورت نیاز فیلدهای دیگری هم اضافه کن
);

$jwt = base64url_encode(json_encode($header)) . '.' . base64url_encode(json_encode($payload)) . '.' . 'MOCK_SIGNATURE';

// یک access_token ساده هم تولید می‌کنیم (رندوم)
if (!function_exists('random_bytes')) {
    function random_bytes($length) {
        $characters = '0123456789abcdef';
        $bytes = '';
        for ($i = 0; $i < $length; $i++) {
            $bytes .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $bytes;
    }
}

$access_token = 'mock_access_' . bin2hex(random_bytes(8));

$response = array(
    "id_token" => $jwt,
    "access_token" => $access_token,
    "expires_in" => 3600,
    "token_type" => "Bearer",
    "scope" => "openid profile"
);

// ارسال پاسخ JSON
echo json_encode($response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
