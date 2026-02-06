<meta charset="utf-8">
<?php


include "library/Jalali.php";
date_default_timezone_set('Asia/Tehran');

defined('DB_DATABASE_BASE') or define('DB_DATABASE_BASE', 'safar360_gds');
defined('DB_USERNAME_BASE') or define('DB_USERNAME_BASE', 'safar360_OnRes');
defined('DB_PASSWORD_BASE') or define('DB_PASSWORD_BASE', 'Safar@360#');

$conn = mysql_connect("localhost", DB_USERNAME_BASE, DB_PASSWORD_BASE) or die("Invalid server or user.");
mysql_select_db(DB_DATABASE_BASE, $conn);
mysql_query("SET NAMES UTF8", $conn);

$sql = "SELECT * FROM " . DB_DATABASE_BASE . ".clients_tb WHERE id > '1'";
$rsl = mysql_query($sql, $conn);

$db = DB_DATABASE_BASE ;
$i=1;
while ($row = mysql_fetch_assoc($rsl)) {
    $conn_client = mysql_connect("localhost", $row['DbUser'], $row['DbPass']) or die("Invalid server or user.");
    mysql_select_db($row['DbName'], $conn_client);
    mysql_query("SET NAMES UTF8", $conn_client);

    /* ************************************************************************************************************* */




  $sql = "SELECT tr.Price,book.request_number,book.factor_number FROM {$row['DbName']}.transaction_tb as tr
         LEFT JOIN  {$row['DbName']}.book_local_tb as book ON book.factor_number = tr.FactorNumber            
         WHERE tr.Price < '100000' AND book.pid_private ='0' AND type_app='web' AND {$row['id']} <>'4' AND tr.PaymentStatus='success' AND tr.Reason='buy'
         AND tr.CreationDateInt > '1605423408' GROUP BY book.factor_number";

    $checks= find_all_by_sql($sql,$conn_client);

    if(!empty($checks))
    {
        foreach ($checks as $key=>$check)
        {
            echo $row['AgencyName'];
            echo '<br/>';
            echo $check['Price'].'-'.$check['request_number'].'-'.$check['factor_number'];
            echo '<br/>';
        }
        echo '<hr/>';
    }






}
function find_all_by_sql($sql, $conn)
{
    $result_sql = mysql_query($sql, $conn);
    while ($data_query = mysql_fetch_assoc($result_sql)) {

        $data_total[] = $data_query;
    }

    return $data_total;
}

function find_one_by_sql($sql, $conn)
{
    $result_sql = mysql_query($sql, $conn);
    $data_total = mysql_fetch_assoc($result_sql);

    return $data_total;
}