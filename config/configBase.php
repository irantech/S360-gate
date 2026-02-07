<?php
ob_start();
defined('DB_PERSISTENCY_BASE') or define('DB_PERSISTENCY_BASE', 'true');
defined('DB_SERVER_BASE') or define('DB_SERVER_BASE', 'localhost');
date_default_timezone_set('Asia/Tehran');

if(isset($_SERVER["HTTP_HOST"]) && (strpos($_SERVER["HTTP_HOST"],'192.168.1.100')!==false || strpos($_SERVER["HTTP_HOST"],'localhost')!==false)){//local
    defined('DB_DATABASE_BASE') or define('DB_DATABASE_BASE', 'amadeus_db');
    defined('DB_USERNAME_BASE') or define('DB_USERNAME_BASE', 'root');
    defined('DB_PASSWORD_BASE') or define('DB_PASSWORD_BASE', '');
}

defined('PDO_DSN_BASE') or define('PDO_DSN_BASE', 'mysql:host=' . DB_SERVER_BASE . ';dbname=' . DB_DATABASE_BASE);

?>