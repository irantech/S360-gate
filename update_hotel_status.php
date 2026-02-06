<?php


defined('DB_DATABASE_BASE') or define('DB_DATABASE_BASE', 'safar360_gds');
defined('DB_USERNAME_BASE') or define('DB_USERNAME_BASE', 'safar360');
defined('DB_PASSWORD_BASE') or define('DB_PASSWORD_BASE', 'GW@!pvGOZ$h9Mk[JdoU');

$connection = mysqli_connect('localhost', DB_USERNAME_BASE, DB_PASSWORD_BASE, DB_DATABASE_BASE) or die("Invalid server or user.");
mysqli_set_charset($connection, 'utf8');

$sql_get_reports = "SELECT * FROM report_hotel_tb WHERE status = 'RequestRejected'";
$report_query = mysqli_query($connection, $sql_get_reports);

$clients = [];

while ($row = mysqli_fetch_assoc($report_query)) {
    $client_id = $row['client_id'];
    $factor_number = $row['factor_number'];

    if (!$client_id || !$factor_number) continue;

    if (!isset($clients[$client_id])) {
        $sql_get_client = "SELECT * FROM clients_tb WHERE id = $client_id";
        $client_query = mysqli_query($connection, $sql_get_client);
        $client = mysqli_fetch_assoc($client_query);

        if (!$client) continue;

        $user = $client['DbUser'];
        $pass = $client['DbPass'];
        $db = $client['DbName'];

        $client_connection = mysqli_connect('localhost', $user, $pass, $db);
        if (!$client_connection) continue;

        mysqli_set_charset($client_connection, 'utf8');
        $clients[$client_id] = $client_connection;
    }

    $client_connection = $clients[$client_id];
    $client_db = mysqli_real_escape_string($connection, $client['DbName']);
    $escaped_factor_number = mysqli_real_escape_string($client_connection, $factor_number);

    $client_sql = "SELECT status FROM $client_db.book_hotel_local_tb WHERE factor_number = '$escaped_factor_number' LIMIT 1";

    $client_query = mysqli_query($client_connection, $client_sql);
    $book = mysqli_fetch_assoc($client_query);

    if ($book && isset($book['status'])) {

        $status = mysqli_real_escape_string($connection, $book['status']);
        $update_sql = "UPDATE report_hotel_tb SET status = '$status' WHERE factor_number = '$escaped_factor_number'";

        mysqli_query($connection, $update_sql);
    }

}

echo "Done!";
