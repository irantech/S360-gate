<?php
// mock_connect_token.php
header('Content-Type: application/json; charset=utf-8');

// helper: base64url encode (بدون padding)
function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

$header = array("alg" => "HS256", "typ" => "JWT");
$payload = array(
    "given_name" => $_POST['given_name'],
    "family_name" => $_POST['family_name'],
    "email" => $_POST['email'],
    "Mobile" => $_POST['Mobile'],
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
