<?php

require 'config/bootstrap.php';
require CONFIG_DIR.'config.php';
require CONFIG_DIR.'configBase.php';
require LIBRARY_DIR.'functions.php';
require CONTROLLERS_DIR.'dateTimeSetting.php';
require LIBRARY_DIR.'Load.php';
spl_autoload_register(array(
    'Load',
    'autoload'
));


$Model=Load::library('Model');
$ModelBase=Load::library('ModelBase');

echo $sql="SELECT BuRoute.*,cityCode.code,cityCode.name_fa,cityCode.name_en,cityCode.iataCode FROM bus_route_tb BuRoute 
            INNER JOIN city_code_tb AS cityCode ON cityCode.name_fa=BuRoute.Arrival_City
            
           WHERE cityCode.code != '' ";

$aa=$ModelBase->select($sql);


foreach($aa as $item){
    $data['Arrival_City_Safar724_Id']=$item['code'];
    $ModelBase->setTable('bus_route_tb');
    $condition="id ='".$item['id']."'";
    $ModelBase->update($data, $condition);

    //    $sql="SELECT * FROM city_code_tb WHERE name_fa ='".$item['Departure_City']."' AND code != ''";
    //    $aa2=$ModelBase->select($sql);
    //    foreach($aa2 as $item2){
    //        $condition="id ='".$item['id']."'";
    ////        $data['Departure_City_Safar724_Id']=$item2['code'];
    ////        $data['Arrival_City_Safar724_Id']=$item2['code'];
    //        if($item2['code'] !== ''){
    //
    //        $data['Departure_City_Safar724_Id']=$item2['code'];
    //        $data['Arrival_City_Safar724_Id']=$item2['code'];
    //
    //
    //        $ModelBase->setTable('bus_route_tb');
    //        $ModelBase->update($data,$condition);
    //        }
    //        echo $item['Arrival_City'].$item['Arrival_City_Safar724_Id'].'<br>';
    //    }

    //        echo $item['Arrival_City'].$item['Arrival_City_Safar724_Id'].'<br>';
}

