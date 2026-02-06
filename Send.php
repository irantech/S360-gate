<meta charset="utf-8">
<?php
/*
 * todo: please paste sql below
 * note: there is no need to include DbName in sql.
 *
 */
error_reporting(0);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

$client_sql = <<<SQL
SELECT
	book.request_number,
	book.factor_number,
	book.member_id,
	book.creation_date_int,
	book.pnr,
	book.api_id,
	book.creation_date_int,
	transaction_tb.price,
	transaction_tb.PaymentStatus
FROM
	book_local_tb AS book
	LEFT JOIN transaction_tb AS transaction_tb ON transaction_tb.FactorNumber = book.factor_number 
WHERE
	( book.successfull = 'book' ) 
	AND transaction_tb.PaymentStatus = 'pending' AND book.creation_date_int >'1616313895' AND book.type_app !='reservation' AND book.pid_private ='0' AND transaction_tb.Reason='buy'
GROUP BY
	book.request_number
SQL;

include "library/Jalali.php";
include "library/functions.php";
include "controller/dateTimeSetting.php";
date_default_timezone_set('Asia/Tehran');

defined('DB_DATABASE_BASE') or define('DB_DATABASE_BASE', 'safar360_gds');
defined('DB_USERNAME_BASE') or define('DB_USERNAME_BASE', 'safar360');
defined('DB_PASSWORD_BASE') or define('DB_PASSWORD_BASE', 'GW@!pvGOZ$h9Mk[JdoU');

//$conn = mysql_connect("localhost", DB_USERNAME_BASE, DB_PASSWORD_BASE) or die("Invalid server or user.");
$connection = mysqli_connect('localhost',DB_USERNAME_BASE,DB_PASSWORD_BASE,DB_DATABASE_BASE) or die("Invalid server or user.");
mysqli_set_charset($connection,'utf8');

$sql_get_clients = "SELECT * FROM " . DB_DATABASE_BASE . ".clients_tb WHERE id > '1' GROUP BY DbName";
$client_query = mysqli_query($connection,$sql_get_clients);

$final_result = [];

$i = 1;
$price_final = 0 ;
while ($row = mysqli_fetch_assoc($client_query)){
    $factor_numbers = [];
    $user = $row['DbUser'];
    $pass = $row['DbPass'];
    $db   = $row['DbName'];
    $client_connection = mysqli_connect('localhost',$user,$pass,$db);




    try{
        mysqli_set_charset($client_connection,'utf8');
        $client_sql = str_replace('{{CLIENT_NAME}}',$row['DbName'],$client_sql);
//          die();
        $result = mysqli_query($client_connection,$client_sql);

        while ($res_row = mysqli_fetch_assoc($result)) {
              $final_result[$i][] = $res_row;
        }

        if(count($final_result[$i]) > 0){
            echo $row['AgencyName'] ;
            echo '<br/>';
            echo count($final_result[$i]);
            echo '<br/>';
            $price=0 ;
            foreach ($final_result[$i] as $res)
            {
                echo $res['factor_number'].'=>'.$res['request_number'].'=>'. number_format($res['price']).' ریال';
                echo '<br/>';
                $price += $res['price'] ;
            }
            echo '<br/>';
            echo 'total==>'. number_format($price).'ریال ';
            echo '<hr/>';

            $price_final += $price ;
        }


    }catch (Exception $exception){
        echo $exception->getMessage() ;
    }
    $i++;

}

echo number_format($price_final) ;
