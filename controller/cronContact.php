<?php


date_default_timezone_set('Asia/Tehran');

defined('DB_DATABASE_BASE') or define('DB_DATABASE_BASE', 'safar360_gds');
defined('DB_USERNAME_BASE') or define('DB_USERNAME_BASE', 'safar360_OnRes');
defined('DB_PASSWORD_BASE') or define('DB_PASSWORD_BASE', 'Safar@360#');

//$conn = mysql_connect("localhost", DB_USERNAME_BASE, DB_PASSWORD_BASE) or die("Invalid server or user.");
$connection = mysqli_connect('localhost',DB_USERNAME_BASE,DB_PASSWORD_BASE,DB_DATABASE_BASE) or die("Invalid server or user.");
mysqli_set_charset($connection,'utf8');

$sql_get_clients = "SELECT * FROM " . DB_DATABASE_BASE . ".clients_tb WHERE id = '283' GROUP BY DbName";
$client_query = mysqli_query($connection,$sql_get_clients);

while ($row = mysqli_fetch_assoc($client_query)){

    $user = $row['DbUser'];
    $pass = $row['DbPass'];
    $db = $row['DbName'];
    $client_connection = mysqli_connect('localhost',$user,$pass,$db);
    mysqli_set_charset($client_connection,'utf8');

    $client_sql =  "SELECT * FROM `contactus_tb`  ORDER BY `id` ASC" ;


    $client_sql = str_replace('{{CLIENT_NAME}}',$row['DbName'],$client_sql);

    $result = mysqli_query($client_connection,$client_sql);
    while($fetch = mysqli_fetch_assoc($result)) {
        var_dump($fetch);
        $counter = 0;
        $tmp = mt_rand(1, 15);
        do {
            $tmp .= mt_rand(0, 15);
        } while (++$counter < 16);
        $uniq = $tmp;
        $random_code = substr($uniq, 0, 10);

        $query =  "INSERT INTO `request_service_tb`("
            . "`tracking_code`,"
            . "`module_title`,"
            . "`module_id`,"
            . "`created_at`"
            . ") VALUES("
            . "'$random_code',"
            . "'contactUs',"
            . "'" . $fetch['id'] . "',"
            . "'" . $fetch['created_at'] . "'"
            . ")";
        var_dump($query);
        mysqli_query($client_connection,$query);
        
        echo $fetch['id'] .'<br>';
    }
}



echo "Filnel";


?>