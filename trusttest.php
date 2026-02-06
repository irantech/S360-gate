<?php
include "library/Jalali.php";
date_default_timezone_set('Asia/Tehran');

defined('DB_DATABASE_BASE') or define('DB_DATABASE_BASE', 'safar360_gds');
defined('DB_USERNAME_BASE') or define('DB_USERNAME_BASE', 'safar360_OnRes');
defined('DB_PASSWORD_BASE') or define('DB_PASSWORD_BASE', 'Safar@360#');

$conn = mysql_connect("localhost", DB_USERNAME_BASE, DB_PASSWORD_BASE) or die("Invalid server or user.");
mysql_select_db(DB_DATABASE_BASE, $conn);
mysql_query("SET NAMES UTF8", $conn);

echo $sql = "SELECT
	AUTH.Username,
	Client.MainDomain
FROM
	client_auth_tb AS AUTH
	INNER JOIN client_source_tb AS SOURCE ON AUTH.SourceId = SOURCE.id
	INNER JOIN client_services_tb AS SERVICE ON SOURCE.ServiceId = SERVICE.id 
	INNER JOIN clients_tb AS Client ON Client.id = AUTH.clientId 
WHERE
	SERVICE.Service = 'HotelLocal' 
	AND AUTH.IsActive = 'Active'";
$rsl = find_all_by_sql($sql, $conn);

foreach ($rsl as $key=>$rs)
{
    $xx[]=$rs['Username'].'=>'.$rs['MainDomain'] ;
}

echo '<pre>'.print_r($xx,true).'</pre>';

function find_all_by_sql($sql, $conn)
{
    $result_sql = mysql_query($sql, $conn);
    while ($data_query = mysql_fetch_assoc($result_sql)) {

        $data_total[] = $data_query;
    }

    return $data_total;
}