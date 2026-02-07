<?php

//define('_PS_DEBUG_SQL_', true);
define('DB_PERSISTENCY', 'true');
define('DB_SERVER', 'localhost');

define("DEFAULT_LANGUAGE", "ir");
define("DEFAULT_DIRECTION", "rtl");

date_default_timezone_set('Asia/Tehran');
//CHANGING LANGUAGE
if (isset($_POST['changeLang'])) {
    $lang = $_POST['changeLang'];

    if ($_POST['changeLang'] == 'gb')
        $direction = "ltr";
    else
        $direction = "rtl";

    setcookie('site_language', $lang, time() + 3600 * 24 * 5);
    setcookie('site_direction', $direction, time() + 3600 * 24 * 5);
}
else {
    if (isset($_COOKIE['site_language'])) {
        $lang = $_COOKIE['site_language'];
        $direction = $_COOKIE['site_direction'];
    } else {
        $lang = DEFAULT_LANGUAGE;
        $direction = DEFAULT_DIRECTION;

        setcookie('site_language', $lang, time() + 3600 * 24 * 5);
        setcookie('site_direction', $direction, time() + 3600 * 24 * 5);
    }
}

    define('DB_DATABASE', $client['DbName']);
    define('DB_USERNAME', $client['DbUser']);
    define('DB_PASSWORD', $client['DbPass']);

define('PDO_DSN', 'mysql:host=' . DB_SERVER . ';dbname=' . DB_DATABASE);

// PERFORMANCE: Maximum two-way flight combinations to process
// Higher value = more options but slower response time
// Lower value = faster response but fewer options
// Recommended: 300-800 depending on server performance
// Default: 500
if (!defined('MAX_TWOWAY_COMBINATIONS')) {
    define('MAX_TWOWAY_COMBINATIONS', 500);
}

