{literal}
    <style type="text/css">
        .container {
            display: table;
            border-bottom: 0px !important;
        }
        .temp {
            margin: 0 auto;
        }
        .temp-wrapper {
            padding: 0;
        }
        .temp-content {
            overflow: visible;
            padding: 0;
        }
        .row {
            margin: 30px auto 0;
        }
        .s-u-header {
            display: none !important;
        }
        .menu {
            display: none !important;
        }
        .s-u-counter-menu {
            display: none !important;
        }
        .detail {
            display: none !important
        }
        footer {
            display: none !important;
        }
        .backToTop {
            display: none !important;
        }
        .header-col-7 {
            width: 7%;
        }
        .header-col-14 {
            width: 14%;
        }
        .header-col-15 {
            width: 15%;
        }
        .header-col-20 {
            width: 20%;
        }
        .header-col-25 {
            width: 25%;
        }
        .header-col-30 {
            width: 30%;
        }
        .header-col-35 {
            width: 35%;
        }
        .header-col-33 {
            width: 33%;
        }
        .header-col-40 {
            width: 40%;
        }
        .header-col-45 {
            width: 45%;
        }
        .header-col-50 {
            width: 50%;
        }
        .header-col-75 {
            width: 75%;
        }
        .header-col-85 {
            width: 85%;
        }
        .header-col-100 {
            width: 100%;
        }
        .clear-both {
            clear: both;
        }
        .thead-td {
            border: 1px solid #666;
            padding: 8px;
            font-weight: bold
        }
        .tbody-td {
            border: 1px solid #666;
            padding: 8px
        }
        .pagebreak {
            page-break-after: always;
        }
        .tempBg {
            background-color: #FFFFFF !important;
        }
        body {
            background-color: #FFFFFF !important;
        }
        .trbgColor {
            background-color: #FFB400;
            color: #FFF;
        }
        .list {
            list-style: disc outside none;
            display: list-item;
        }
        .backInfo {
            background-color: #F2F0ED;
            width: 98%;
            height: 100px;
            padding: 10px;
        }
        .font-12 {
            font-size: 12px;
        }
        .marginInfo {
            text-align: right;
            margin-left: 5px;
        }
    </style>
{/literal}

{load_presentation_object filename="bookingBusShow" assign="objBookingBus"}
{load_presentation_object filename="BookingHotelLocal" assign="objBookingHotel"}

{assign var='list' value=$objBookingBus->getBookReportBusTicket($smarty.get.num)}

<!DOCTYPE html>
<html>
<head>
    <title>eticket</title>
</head>
<body>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 s-u-passenger-wrapper-change"
         style="margin-bottom: 15px">
        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change  site-main-text-color">
            ##Note## <i class="zmdi zmdi-alert-circle mart10  zmdi-hc-fw"></i>
        </span>
        <div class="s-u-result-wrapper">
            <span class="s-u-result-item-change direcR iranR txt12 txtRed">
                ##PleaseClickForPrintTicket##
                    <a class="eticketLocaltext" target="_blank"
                       href="{$smarty.const.ROOT_ADDRESS}/pdf&target=bookingBusShow&id={$smarty.get.num}"> ##Here##</a>
                ##DoClick##
            </span>
        </div>
    </div>
</div>


<div class="row">
    <div class="header-col-15 pull-right">
        <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$smarty.const.LOGO_AGENCY}" style="max-height: 80px;">
    </div>
</div>

<div class="row">

    <div class="header-col-100 pull-right " style="">

        <div class="header-col-35 pull-right font-12 marginInfo">
            <span style="text-align: left">##Invoicenumber## : </span><span>{$list[0]['passenger_factor_num']}</span>
        </div>

        <div class="header-col-30 pull-right font-12 marginInfo">
            <span>##Reservationdate## : </span><span>{$objBookingHotel->set_date_reserve($list[0]['creation_date'])}</span>
        </div>

        <div class="header-col-30 pull-right font-12 marginInfo">
            <span>##Reservationtime## : </span><span>{$objBookingHotel->set_time_payment($list[0]['payment_date'])}</span>
        </div>

    </div>
    <div class="clear-both"></div>
    <br/>

    <table width="100%" style="border-collapse: collapse;  margin:0px auto">
        <thead>
        <tr class="trbgColor">
            <td class="thead-td header-col-7">##Origin##</td>
            <td class="thead-td header-col-7">##Destination##</td>
            <td class="thead-td header-col-7">##Passengercompany##</td>
            <td class="thead-td header-col-7">##busType##</td>
            <td class="thead-td header-col-7">##Ticketnumber##</td>
            <td class="thead-td header-col-7">##SeatNumber##</td>
            <td class="thead-td header-col-7">##dateMove##</td>
            <td class="thead-td header-col-7">##timeMove##</td>
            <td class="thead-td header-col-20">##Totalamount##</td>
        </tr>
        </thead>
        <tr>
            <td class="tbody-td">{$list[0]['OriginCity']}</td>
            <td class="tbody-td">{$list[0]['DestinationCity']}</td>
            <td class="tbody-td">{$list[0]['CompanyName']}</td>
            <td class="tbody-td">{$list[0]['CarType']}</td>
            <td class="tbody-td">{$list[0]['ClientTraceNumber']}</td>
            <td class="tbody-td">{$list[0]['chairs']}</td>
            <td class="tbody-td">{$list[0]['DateMove']}</td>
            <td class="tbody-td">{$list[0]['TimeMove']}</td>
            <td class="tbody-td">{$list[0]['total_price']|number_format} ##Rial##</td>
        </tr>
    </table>
    <div class="clear-both"></div>
    <br/>


    <table width="100%" style="border-collapse: collapse; margin:0px auto ">
        <thead>
            <tr class="trbgColor">
                <td class="thead-td" style="width: 20%">##Namefamily##</td>
                <td class="thead-td" style="width: 10%">##Nationalnumber##</td>
                <td class="thead-td" style="width: 10%">##Phonenumber##</td>
                <td class="thead-td" style="width: 10%">##Email##</td>
        </thead>
        <tbody>
        {foreach $list as $key => $passenger}
            <tr>
                <td class="tbody-td">
                    <div>
                        {if  $passenger['passenger_gender'] =='Male'}
                            ##Sir##
                        {elseif $passenger['passenger_gender'] =='Female'}
                            ##Lady##
                        {/if}
                        {$passenger['passenger_name']} {$passenger['passenger_family']}
                    </div>
                </td>
                <td class="tbody-td">
                    {$passenger['passenger_national_code']}
                </td>
                <td class="tbody-td">{$passenger['passenger_mobile']}</td>
                <td class="tbody-td">{$passenger['passenger_email']}</td>
            </tr>
        {/foreach}
        </tbody>
    </table>


    <div class="clear-both"></div>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>

</div>


</body>
</html>

{literal}
    <script type="text/javascript">
        $(document).ready(function () {
            //window.print();
        });
    </script>
{/literal}