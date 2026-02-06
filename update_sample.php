<meta charset="utf-8">
<?php
/*
 * todo: please paste sql below
 * note: there is no need to include DbName in sql.
 *
 */

$client_sql = <<<SQL


SQL;

 

include "library/Jalali.php";
date_default_timezone_set('Asia/Tehran');

defined('DB_DATABASE_BASE') or define('DB_DATABASE_BASE', 'safar360_gds');
defined('DB_USERNAME_BASE') or define('DB_USERNAME_BASE', 'safar360');
defined('DB_PASSWORD_BASE') or define('DB_PASSWORD_BASE', 'GW@!pvGOZ$h9Mk[JdoU');

//$conn = mysql_connect("localhost", DB_USERNAME_BASE, DB_PASSWORD_BASE) or die("Invalid server or user.");
$connection = mysqli_connect('localhost',DB_USERNAME_BASE,DB_PASSWORD_BASE,DB_DATABASE_BASE) or die("Invalid server or user.");
mysqli_set_charset($connection,'utf8');

$sql_get_clients = "SELECT * FROM " . DB_DATABASE_BASE . ".clients_tb WHERE id > '1' GROUP BY DbName";
$client_query = mysqli_query($connection,$sql_get_clients);

while ($row = mysqli_fetch_assoc($client_query)){

      $user = $row['DbUser'];
      $pass = $row['DbPass'];
      $db = $row['DbName'];
      $client_connection = mysqli_connect('localhost',$user,$pass,$db);

      try{
          mysqli_set_charset($client_connection,'utf8');
          $client_sql = str_replace('{{CLIENT_NAME}}',$row['DbName'],$client_sql);
//          var_dump($client_sql);
//          die();
          $result = mysqli_query($client_connection,$client_sql);


//          echo  $row['id'].'-'.$row['DbName'];
//          echo '<br><code>';
//          echo $row['AgencyName'];
//          echo '</code><br> ';
//          echo count($result);
//          echo '<hr>';
//          $results = array();
       /*   while ($res_row = mysqli_fetch_assoc($result)) {
              var_dump($res_row);
              $results[] = $res_row;
          }*/

//          if(count($results) > 0)
//          {

              echo $row['DbName'];
              echo '<br><code>';
              echo $row['AgencyName'];
              echo '</code><br> ';
              echo $client_sql ;
              echo '</code><br>' .
                  $row['AgencyName'] .
                  '<pre style="color: red">';
          var_dump($result);
//              echo count($results);
              echo '</pre><hr>';
//          }


      }catch (Exception $exception){
          echo $exception->getMessage() ;
      }

}


var_dump($results);
die();
