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

{load_presentation_object filename="parvazBookingLocal" assign="objBookingLocal"}
{load_presentation_object filename="resultLocal" assign="objResultLocal"}

{assign var='list' value=$objBookingLocal->getTicketDataByRequestNumber($smarty.get.num)}

<pre>{*$list|print_r*}</pre>
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
                    <a class="eticketLocaltext" target="_blank" href="{$smarty.const.ROOT_ADDRESS}/pdf&target=parvazBookingLocal&id={$smarty.get.num}"> ##Here##</a>
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
            <span style="text-align: left">##WachterNumber## : </span><span>{$list[0]['request_number']}</span>
        </div>

        <div class="header-col-30 pull-right font-12 marginInfo">
            <span>##Reservationdate## : </span><span>{$objBookingLocal->set_date_reserve($list[0]['creation_date'])}</span>
        </div>
        {if $list[0]['pnr'] neq '' && $list[0]['pnr'] neq '0'}
            <div class="header-col-30 pull-right font-12 marginInfo">
                <span>##Reservationtime## : </span><span>{$objBookingLocal->set_time_payment($list[0]['payment_date'])}</span>
            </div>
        {/if}

    </div>

    <div class="clear-both"></div>


    <h2 style="font-size: 15px;display: block;text-align: right;margin: 20px 0 10px;font-weight:bold">
        <span>##Informationflight## </span>
    </h2>

    <table width="100%" style="border-collapse: collapse;  margin:0px auto">
        <thead>
        <tr class="trbgColor">

            <td class="thead-td header-col-7">##Origin##</td>
            <td class="thead-td header-col-7">##Destination##</td>
            <td class="thead-td header-col-7">##Airline##</td>
            <td class="thead-td header-col-7"> ##FlightNumber##</td>
            <td class="thead-td header-col-7">##Date##</td>
            <td class="thead-td header-col-7">##Hour##</td>
            <td class="thead-td header-col-7">##PnrCode##</td>
            <td class="thead-td header-col-20">##Type## / ##Class##/##RateiD##</td>
            <td class="thead-td header-col-20">##Totalamount##</td>
        </tr>
        </thead>
        <tr>

            <td class="tbody-td">{$list[0]['origin_city']}</td>
            <td class="tbody-td">{$list[0]['desti_city']}</td>
            <td class="tbody-td">{$list[0]['airline_name']}</td>
            <td class="tbody-td">{$list[0]['flight_number']}</td>
            <td class="tbody-td">{$objBookingLocal->set_date_reserve($list[0]['date_flight'])}
            <td class="tbody-td"> {$objResultLocal->format_hour($list[0]['time_flight'])}
            </td>
            <td class="thead-td">{if $list[0]['pnr'] neq '' && $list[0]['pnr'] neq '0'}{$list[0]['pnr']}{else}---{/if}</td>
            <td class="tbody-td">{if $list[0]['flight_type']=='' || $list[0]['flight_type']=='charter'}##CharterType##
                {elseif $list[0]['flight_type']=='system'}##SystemType##
                {/if}/ {if $list[0]['seat_class']=='C' || $list[0]['seat_class']=='B'}##BusinessType##
                {else}##EconomicsType##
                {/if}/
                {$item['cabin_type']}
            </td>
            <td class="tbody-td">
                {$objFunctions->CalculateDiscount($list[0]['request_number'],'No')|number_format} ##Rial##
            </td>
        </tr>
    </table>
    <div class="clear-both"></div>
    <div style="font-size: 18px;display: block;text-align: right;margin: 30px 0 10px;font-weight:bold;width: 100%;height: 10px;">

    </div>

    <div class="clear-both"></div>

    <table width="100%" style="border-collapse: collapse; margin:0px auto ">
        <thead>
        <tr class="trbgColor">
                <td class="thead-td" style="width: 20%">##Namefamily##</td>
            <td class="thead-td" style="width: 10%">##Nationalnumber## / ##Passport##</td>
            <td class="thead-td" style="width: 10%">##Happybirthday##</td>
            <td class="thead-td" style="width: 10%"> ##Ages##</td>
            <td class="thead-td" style="width: 10%">##Nation##</td>
            <td class="thead-td" style="width: 10%">##Ticketnumber##</td>
            <td class="thead-td" style="width: 10%">##Firstprice##</td>
            <td class="thead-td" style="width: 10%">##Discountrate##</td>
            <td class="thead-td" style="width: 10%">##Finalprice##</td>
        </tr>
        </thead>
        <tbody>
        {foreach key=key item=item from=$list}

            {if $item['passportCountry'] eq '' || $item['passportCountry'] eq 'IRN' || $item['passportCountry'] eq 'IR'}

                {assign var="Country" value=$objFunctions->ChoosCountryPassenger('IRN')}

            {else}

                {assign var="Country" value=$objFunctions->ChoosCountryPassenger($item['passportCountry'])}

            {/if}

            {if $item['passenger_national_code'] !='0000000000'}
                {assign var="NationalCode" value=$item['passenger_national_code']}

            {else}
                {assign var="NationalCode" value=$item['passportNumber']}
            {/if}
            <tr>
                <td class="tbody-td">
                    <div>
                        {if  $item['passenger_gender'] =='Male'}
                            ##Sir##
                        {elseif $item['passenger_gender'] =='Female'}
                            ##Lady##
                        {/if}
                        {$item['passenger_name']} {$item['passenger_family']}
                    </div>
                    <div>
                        ({if  $item['passenger_gender'] =='Male'}
                        ##Sir##
                        {elseif $item['passenger_gender'] =='Female'}
                        ##Lady##
                        {/if}

                        {$item['passenger_name_en']} {$item['passenger_family_en']})
                    </div>
                </td>
                <td class="tbody-td">
                    {$NationalCode}
                </td>
                <td class="tbody-td">{if !empty($item['passenger_birthday'])} {$item['passenger_birthday']} {else}
                        {$item['passenger_birthday_en']} {/if}
                </td>
                <td class="tbody-td">{if $item['passenger_age'] =='Adt'} ##Adult## {elseif $item['passenger_age'] =='Chd'}##Child##
                    {elseif $item['passenger_age'] =='Inf'}##Baby##{/if}
                </td>

                <td class="tbody-td">{$Country['titleFa']}</td>
                <td class="tbody-td">{$item['eticket_number']}</td>
                <td class="tbody-td">{$objFunctions->CalculateForOnePersonWithOutDiscount($item['request_number'],$NationalCode,'No')|number_format}
                    ##Rial##
                </td>
                <td class="tbody-td">{$item['percent_discount']} %</td>
                <td class="tbody-td">{$objFunctions->CalculateDiscountOnePerson($item['request_number'],$NationalCode,'No')|number_format}
                    ##Rial##
                </td>


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