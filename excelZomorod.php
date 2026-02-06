<?php


require 'config/bootstrap.php';
require CONFIG_DIR . 'configBase.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));



$admin = Load::controller('admin');


$Clients = functions::AllClients();
foreach ($Clients as $client) {
    $sql = "SELECT * FROM members_tb WHERE fk_counter_type_id >= '1' AND fk_counter_type_id < '5'";
    $members = $admin->ConectDbClient($sql, $client['id'], "SelectAll", "", "");
    foreach ($members as $member) {
        $member['ClientName'] = $client['AgencyName'];
        $member['ClientId'] = $client['id'];
        $memberClients[] = $member;

    }
}
if(isset($_GET['type']) && $_GET['type']=='excel' && isset($_GET['method'])) {


    if($_GET['method']=="customer")
    {
        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=filename" . date("YmdHis") . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Lacation: excel.htm?id=yes");

        $_xml = '';
        $_xml = "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
        $_xml .= "<dataroot xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'>";


        $_xml .= "<Table1>";
        $_xml .= "<row>ردیف</row>";
        $_xml .= "<AgencyName>نام آژانس</AgencyName>";
        $_xml .= "<CounterName>نام کانتر</CounterName>";
        $_xml .= "<Ticket>تعداد زمرد بلیط</Ticket>";
        $_xml .= "<Hotel>تعداد زمرد هتل</Hotel>";
        $_xml .= "<Insurance>تعداد زمرد بیمه</Insurance>";
        $_xml .= "<Total>تعداد کل</Total>";
        $_xml .= "</Table1>";
        $row = 1;

        foreach ($memberClients as $key => $memberClient) {

            $Zomorod = sqlZomorod($memberClient['id'], $memberClient['ClientId']);
            $fullName = $memberClient['name'] . ' ' . $memberClient['family'];
            $_xml .= "<Table1>";
            $_xml .= "<row>" . ($key + 1) . "</row>";
            $_xml .= "<AgencyName>" . $memberClient['ClientName'] . "</AgencyName>";
            $_xml .= "<CounterName>" . $fullName . "</CounterName>";
            $_xml .= "<Ticket>" . $Zomorod['TicketCount'] . "</Ticket>";
            $_xml .= "<Hotel>" . $Zomorod['HotelCount'] . "</Hotel>";
            $_xml .= "<Insurance>" . $Zomorod['insuranceCount'] . "</Insurance>";
            $_xml .= "<Total>" . $Zomorod['total'] . "</Total>";
            $_xml .= "</Table1>";
        }
        $_xml .= "</dataroot>";
        print  $_xml;
    }
    elseif($_GET['method']=="ticket")
    {
        $Ticket=isset($_GET['data']) ? $_GET['data'] : array() ;
        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=filename" . date("YmdHis") . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Lacation: excel.htm?id=yes");

        $_xml = '';
        $_xml = "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
        $_xml .= "<dataroot xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'>";


        $_xml .= "<Table1>";
        $_xml .= "<row>ردیف</row>";
        $_xml .= "<passengerName>نام  </passengerName>";
        $_xml .= "<passengerFamily>نام خانوادگی  </passengerFamily>";
        $_xml .= "<agencyname>  نام آژانس</agencyname>";
        $_xml .= "</Table1>";
        $row = 1;

        foreach ($Tours as $key => $itemTour) {

            $_xml .= "<Table1>";
            $_xml .= "<row>" . ($key + 1) . "</row>";
            $_xml .= "<passengerName>" . $itemTour['passenger_name'] . "</passengerName>";
            $_xml .= "<passengerFamily>" . $itemTour['passenger_family'] . "</passengerFamily>";
            $_xml .= "<agencyname>" . $itemTour['agency_name'] . "</agencyname>";
            $_xml .= "</Table1>";

        }
        $_xml .= "</dataroot>";
        print  $_xml;
    }
}

elseif($_GET['type']=='json'){
    
    foreach ($memberClients as $key => $Client) {

        $Zomorod = sqlZomorod($Client['id'], $Client['ClientId']);
        $fullName = $Client['name'] . ' ' . $Client['family'];


        $data['NameAgency'] = $Client['ClientName'];
        $data['NameUser'] = $fullName ;
        $data['gem']= $Zomorod['total'];

        $ClientsGem[]= $data;
    }
    $dataGems['DataGems'] =array(

        'Status' =>'Success',
        'Gems'=> $ClientsGem
    );
    echo json_encode($dataGems);
}

#region sqlZomorod
 function sqlZomorod($UserId,$ClientId)
{
    $admin = Load::controller('admin');
    $TicketInfoSql = "SELECT count(DISTINCT request_number) AS TicketCount FROM book_local_tb WHERE member_id='{$UserId}' AND (successfull='book')";
    $CountTicket = $admin->ConectDbClient($TicketInfoSql, $ClientId, "Select", "", "");

    $TicketInfoSql = "SELECT count(DISTINCT factor_number) AS HotelCount FROM book_hotel_local_tb WHERE member_id='{$UserId}' AND status='BookedSuccessfully'";
    $CountHotel = $admin->ConectDbClient($TicketInfoSql, $ClientId, "Select", "", "");

    $TicketInfoSql = "SELECT count(DISTINCT factor_number) AS insuranceCount FROM book_insurance_tb WHERE member_id='{$UserId}' AND status='book'";
    $CountInsurance = $admin->ConectDbClient($TicketInfoSql,$ClientId, "Select", "", "");


    $data['total'] =  $CountTicket['TicketCount'] + $CountHotel['HotelCount'] + $CountInsurance['insuranceCount'];
    $data['TicketCount'] =  $CountTicket['TicketCount'] ;
    $data['HotelCount'] =  $CountHotel['HotelCount'] ;
    $data['insuranceCount'] =  $CountInsurance['insuranceCount'] ;

    return $data;

}
#endregion