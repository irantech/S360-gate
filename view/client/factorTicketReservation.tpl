<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>

{load_presentation_object filename="resultReservationTicket" assign="objResult"}
{assign var="infoTicket" value=$objResult->infoTicket()}


{load_presentation_object filename="members" assign="objMember"}
{$objMember->get()}


{load_presentation_object filename="factorTicketReservation" assign="objFactor"}
<!-- can't submit refresh -->
{$objFactor->statusRefresh()}

{$objFactor->registerPassengersReservationTicket()}

{assign var='arrPrice' value=$objFactor->getPassengersReservationTicket()}
<div class="container-fluid">

<div class="s-u-content-result">
    <div id="lightboxContainer" class="lightboxContainerOpacity"></div>
<div id="flight_factorLocal" class="s-u-content-result ">
    <div id="steps">
    <div class="steps_items">
        <div class="step done ">

            <span class=""><i class="fa fa-check"></i></span>
            <h3>##Selectionflight##</h3>
        </div>
        <i class="separator done"></i>
        <div class="step done ">
        <span class="flat_icon_airplane"><i class="fa fa-check"></i></span>
            <h3>##PassengersInformation##</h3>

        </div>
        <i class="separator donetoactive"></i>
        <div class="step active " >
             <span class="flat_icon_airplane">
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="25" height="25">
    <g id="Contact_form" data-name="Contact form">
        <path d="M20.293,30.707A1,1,0,0,1,20,30v3h3a1,1,0,0,1-.707-.293Z"/>
        <path d="M21,29H20v1a1,1,0,0,1,1-1Z"/>
        <path d="M23,20.586,24.586,19H21a1,1,0,0,1,.707.293Z"/>
        <path d="M21,39H20v1a1,1,0,0,1,1-1Z"/>
        <path d="M23,30.586,24.586,29H21a1,1,0,0,1,.707.293Z"/>
        <path d="M20.293,40.707A1,1,0,0,1,20,40v3h3a1,1,0,0,1-.707-.293Z"/>
        <path d="M23,40.586,24.586,39H21a1,1,0,0,1,.707.293Z"/>
        <path d="M21,19H20v1a1,1,0,0,1,1-1Z"/>
        <path d="M49.351,35.187,52,37.836V4H14V49H47.183A7.243,7.243,0,0,1,48.331,45.5l-4.638-4.638a4.032,4.032,0,0,1,0-5.661A4.1,4.1,0,0,1,49.351,35.187ZM47,21H31a1,1,0,0,1,0-2H47a1,1,0,0,1,0,2Zm1,3a1,1,0,0,1-1,1H31a1,1,0,0,1,0-2H47A1,1,0,0,1,48,24ZM18,7a1,1,0,0,1,1-1H47a1,1,0,0,1,1,1v6a1,1,0,0,1-1,1H19a1,1,0,0,1-1-1ZM40,35H31a1,1,0,0,1,0-2h9a1,1,0,0,1,0,2Zm1,5a1,1,0,0,1-1,1H31a1,1,0,0,1,0-2h9A1,1,0,0,1,41,40ZM28.707,37.707l-5,5A1,1,0,0,1,23,43h2a1,1,0,0,1,0,2H19a1,1,0,0,1-1-1V38a1,1,0,0,1,1-1h6a1,1,0,0,1,.931.655l1.362-1.362a1,1,0,0,1,1.414,1.414Zm0-10-5,5A1,1,0,0,1,23,33h2a1,1,0,0,1,0,2H19a1,1,0,0,1-1-1V28a1,1,0,0,1,1-1h6a1,1,0,0,1,.931.655l1.362-1.362a1,1,0,0,1,1.414,1.414Zm0-10-5,5A1,1,0,0,1,23,23h2a1,1,0,0,1,0,2H19a1,1,0,0,1-1-1V18a1,1,0,0,1,1-1h6a1,1,0,0,1,.931.655l1.362-1.362a1,1,0,0,1,1.414,1.414ZM43,43a1,1,0,0,1,0,2H31a1,1,0,0,1,0-2ZM31,31a1,1,0,0,1,0-2H47a1,1,0,0,1,0,2Z"/>
        <path d="M58.01,61,58,59.616a2.985,2.985,0,0,1,.5-1.678l.653-.981A4.979,4.979,0,0,0,60,54.183v-13.7a6.959,6.959,0,0,0-2.05-4.95L54,31.584v8.252l2.427,2.427a1,1,0,0,1-1.414,1.414l-7.07-7.07a2.071,2.071,0,0,0-2.841.006,2.022,2.022,0,0,0,.008,2.833l5.247,5.247a1,1,0,0,1,.053,1.357,5.3,5.3,0,0,0-.1,6.746l.465.575a1,1,0,1,1-1.554,1.258l-.47-.58A7.3,7.3,0,0,1,47.316,51H43.905a8.915,8.915,0,0,0,1.356,6.584l.572.863A1,1,0,0,1,46,59v2Z"/>
        <rect x="20" y="8" width="26" height="4"/>
        <path d="M20.293,20.707A1,1,0,0,1,20,20v3h3a1,1,0,0,1-.707-.293Z"/>
    </g>
</svg>
             </span>
            <h3>##Approvefinal##</h3>
        </div>
        <i class="separator"></i>
        <div class="step" >
            <span class="flat_icon_airplane">
                <svg  enable-background="new 0 0 512 512" height="25" viewBox="0 0 512 512" width="25"
                      xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <g>
                            <path d="m497 91h-331c-8.28 0-15 6.72-15 15 0 8.27-6.73 15-15 15s-15-6.73-15-15c0-8.28-6.72-15-15-15h-91c-8.28 0-15 6.72-15 15v300c0 8.28 6.72 15 15 15h91c8.28 0 15-6.72 15-15 0-8.27 6.73-15 15-15s15 6.73 15 15c0 8.28 6.72 15 15 15h331c8.28 0 15-6.72 15-15v-300c0-8.28-6.72-15-15-15zm-361 210h-61c-8.28 0-15-6.72-15-15s6.72-15 15-15h61c8.28 0 15 6.72 15 15s-6.72 15-15 15zm60-60h-121c-8.28 0-15-6.72-15-15s6.72-15 15-15h121c8.28 0 15 6.72 15 15s-6.72 15-15 15zm250.61 85.61c-5.825 5.825-15.339 5.882-21.22 0l-64.39-64.4v47.57l25.61 25.61c5.85 5.86 5.85 15.36 0 21.22-5.825 5.825-15.339 5.882-21.22 0l-19.39-19.4-19.39 19.4c-5.86 5.85-15.36 5.85-21.22 0-5.85-5.86-5.85-15.36 0-21.22l25.61-25.61v-47.57l-64.39 64.4c-5.86 5.85-15.36 5.85-21.22 0-5.85-5.86-5.85-15.36 0-21.22l85.61-85.61v-53.78c0-8.28 6.72-15 15-15s15 6.72 15 15v53.78l85.61 85.61c5.85 5.86 5.85 15.36 0 21.22z"/>
                        </g>
                    </g>
                </svg>
            </span>
            <h3>##TicketReservation##</h3>
        </div>
    </div>

    <div class="counter counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"
         style="direction: ltr"> {$smarty.post.time_remmaining}</div>

</div>

    <div class="Clr"></div>

    <div class="s-u-passenger-wrapper-change s-u-passenger-wrapper">
       <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color site-border-main-color">
            <i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart10"></i> ##Invoice##
        </span>
    <div class="s-u-result-wrapper">
        <ul>

            <li class="s-u-result-item-header displayiN">
                <div class="s-u-result-item-div">
                    <p class="s-u-result-item-div-title s-u-result-item-div-logo-icon"></p>
                </div>
                <div class="s-u-result-item-wrapper">

                    <div class="s-u-result-item-div">
                        <p class="s-u-result-item-div-title s-u-result-item-div-time-out"></p>
                    </div>

                    <div class="s-u-result-item-div">
                        <p class="s-u-result-item-div-title s-u-result-item-div-duration-local"></p>
                    </div>

                    <div class="s-u-result-item-div">
                        <p class="s-u-result-item-div-title s-u-result-item-div-flight-number-local"></p>
                    </div>

                    <div class="s-u-result-item-div">
                        <p class="s-u-result-item-div-title s-u-result-item-div-flight-number"></p>
                    </div>

                </div>

                <div class="s-u-result-item-div">
                    <p class="s-u-result-item-div-title s-u-result-item-div-flight-price"></p>
                </div>

            </li>

            <!-- result item -->
            <li class="s-u-result-item s-u-result-item-change wow blit-flight-passenger fadeInDown">
                {if $smarty.post.typeApplication eq 'reservation'}
                    <div class="blite-rafto-bargasht-text raft-blit"><span>##Onewayticket##</span></div>
                {/if}

                <div class="s-u-result-item-div s-u-result-item-div-change col-xs-3 col-sm-2 s-u-result-item-div-width">
                    <div class="s-u-result-item-div-logo s-u-result-item-div-logo-change">
                        {if $objResult->getTypeVehicle($infoTicket['dept']['TypeVehicle']) eq 'هواپیما'}
                            <img src="{$objFunctions->getAirlinePhoto($infoTicket['dept']['Airline'])}">
                        {else}
                            <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$infoTicket['dept']['Image']}">
                        {/if}
                    </div>

<!--                    <div class="s-u-result-item-div s-u-result-content-item-div-change">
                        {if $smarty.post.typeApplication eq 'reservation'}
                            <span>##Numflight##: {$infoTicket['dept']['FlightNumber']}</span>

                        {elseif $smarty.post.typeApplication eq 'reservationBus'}{*تعریف اتوبوس در پنل ادمین و نمایش آن به عنوان تور تهرانگردی تهران (برای مشتری جوی)*}
                            <span> ##Nametour##:  {$infoTicket['dept']['FlightNumber']}</span>

                        {else}
                            <span> {$infoTicket['dept']['FlightNumber']}</span>
                        {/if}
                    </div>-->
                    {if $smarty.post.typeApplication eq 'reservation'}
                        <span class="displayib-change d-block">##CharterType##</span>
                    {/if}
                </div>

                <div class="s-u-result-item-wrapper s-u-result-item-wrapper-change col-xs-9 col-sm-10">

                    <div class="details-wrapper-change">

                        <div class="s-u-result-raft first-row-change">
                            <div class="s-u-result-item-div  s-u-result-items-div-change right-Cell-change fltr padb5 displayN400 ">

                                {assign var="OriginateDate" value=$objFunctions->NewFormatDate($infoTicket['dept']['OriginDate'])}
                                {assign var="OriginateDateArrival" value=$objFunctions->NewFormatDate($infoTicket['dept']['OriginDate'])}

                                {if $smarty.post.typeApplication eq 'reservation'}
                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr">
                                            <span class="iranB">{$infoTicket['dept']['OriginCity']}</span>
                                            <span class="s-u-result-item-date-format s-u-result-item-date-format-change iranB">{$OriginateDate['day']},{$OriginateDate['date_now']}</span>
                                            <span class="s-u-bozorg s-u-bozorg-change  txt14 yekanB">{$infoTicket['dept']['OriginTime']}</span>
                                        </div>

                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr">
                                            <span class="iranB">{$infoTicket['dept']['DestinationCity']}</span>
                                            <span class="s-u-result-item-date-format s-u-result-item-date-format-change iranB">{$OriginateDateArrival['day']},{$OriginateDateArrival['date_now']}</span>
                                            <span class="s-u-bozorg s-u-bozorg-change  txt14 yekanB">{$infoTicket['dept']['DestinationTime']}</span>
                                        </div>
                                    {elseif $smarty.post.typeApplication eq 'reservationBus'}
                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr">
                                            <span class="iranB">{$infoTicket['dept']['DestinationRegion']}</span>
                                            <span class="s-u-result-item-date-format s-u-result-item-date-format-change iranB">{$OriginateDate['day']},{$OriginateDate['date_now']}</span>
                                        </div>

                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr">
                                            <span>##Starttime##: </span>
                                            <span class="s-u-bozorg s-u-bozorg-change  txt14 yekanB"> ##From## {$infoTicket['dept']['OriginTime']} ##To## {$infoTicket['dept']['DestinationTime']} </span>
                                        </div>
                                    {/if}

                                <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr  show-div">
<!--                                    <span> {$objResult->getTypeVehicle($infoTicket['dept']['TypeVehicle'])} : {$infoTicket['dept']['TypeVehicleFa']} </span>-->
                                    <span>##RunTime##</span>
                                    <span class="s-u-bozorg s-u-bozorg-change font12">
                                        <i class="font-chanhe"> {$infoTicket['dept']['Hour']} </i> ##Hour##
                                        <i class="font-chanhe"> {$infoTicket['dept']['Minutes']} </i> ##Minutes##
                                    </span>
                                </div>

                            </div>
                            <div class="s-u-result-item-div  s-u-result-items-div-change right-Cell-change fltr padb5 displayB400 ">
                                <span class="iranB">{$infoTicket['dept']['OriginCity']}</span>
                                <span class="iranB">{$infoTicket['dept']['DestinationCity']}</span>

                                <span class="s-u-result-item-date-format s-u-result-item-date-format-change font15">{$infoTicket['dept']['OriginDate']}</span>
                                <span class="s-u-bozorg s-u-bozorg-change  txt14 yekanB">08:45</span>
                            </div>
                            <div class="left-Cell-change">
                                <div class="s-u-bozorg s-u-bozorg-change">
                                    <span class="s-u-bozorg price">
                                        {if $infoTicket['dept']['PriceWithDiscount'] neq 0}
                                            {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($infoTicket['dept']['PriceWithDiscount'], $smarty.post.CurrencyCode)}
                                            <i>{$objFunctions->numberFormat($mainCurrency.AmountCurrency)}</i> {$mainCurrency.TypeCurrency}
                                        {else}
                                            {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($infoTicket['dept']['AdtPrice'], $smarty.post.CurrencyCode)}
                                            <i>{$objFunctions->numberFormat($mainCurrency.AmountCurrency)}</i> {$mainCurrency.TypeCurrency}
                                        {/if}
                                    </span>

                                    {if $smarty.post.typeApplication eq 'reservation'}
                                    <div class="shenase-nerkhi">
                                        <span class="Direction-rtl">##RateiD## : {$infoTicket['dept']['CabinType']}</span>
                                    </div>
                                    {/if}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </li>



            {if $smarty.post.typeApplication eq 'reservation' && $infoTicket['return'] neq ''}
                <li class="s-u-result-item s-u-result-item-change wow blit-flight-passenger fadeInDown">
                    <div class="blite-rafto-bargasht-text raft-blit"><span>##Returnticket##</span></div>

                    <div class="s-u-result-item-div s-u-result-item-div-change col-xs-3 col-sm-2 s-u-result-item-div-width">
                        <div class="s-u-result-item-div-logo s-u-result-item-div-logo-change">
                            {if $objResult->getTypeVehicle($infoTicket['return']['TypeVehicle']) eq 'هواپیما'}
                                <img src="{$objFunctions->getAirlinePhoto($infoTicket['return']['Airline'])}">
                            {else}
                                <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$infoTicket['return']['Image']}">
                            {/if}
                        </div>

                        <div class="s-u-result-item-div s-u-result-content-item-div-change">
                            <span>##Numflight## : {$infoTicket['return']['FlightNumber']}</span>
                        </div>
                        <span class="displayib-change d-block">##CharterType##</span>
                    </div>

                    <div class="s-u-result-item-wrapper s-u-result-item-wrapper-change col-xs-9 col-sm-10">

                        <div class="details-wrapper-change">

                            <div class="s-u-result-raft first-row-change">
                                <div class="s-u-result-item-div  s-u-result-items-div-change right-Cell-change fltr padb5 displayN400 ">

                                    {assign var="OriginateDate" value=$objFunctions->NewFormatDate($infoTicket['return']['OriginDate'])}
                                    {assign var="OriginateDateArrival" value=$objFunctions->NewFormatDate($infoTicket['return']['OriginDate'])}

                                    <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr">
                                        <span class="iranB">{$infoTicket['return']['OriginCity']}</span>
                                        <span class="s-u-result-item-date-format s-u-result-item-date-format-change iranB">{$OriginateDate['day']},{$OriginateDate['date_now']}</span>
                                        <span class="s-u-bozorg s-u-bozorg-change  txt14 yekanB">{$infoTicket['return']['OriginTime']}</span>
                                    </div>

                                    <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr">
                                        <span class="iranB">{$infoTicket['return']['DestinationCity']}</span>
                                        <span class="s-u-result-item-date-format s-u-result-item-date-format-change iranB">{$OriginateDateArrival['day']},{$OriginateDateArrival['date_now']}</span>
                                        <span class="s-u-bozorg s-u-bozorg-change  txt14 yekanB">{$infoTicket['return']['DestinationTime']}</span>
                                    </div>

                                    <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr  show-div">
                                        <span> {$objResult->getTypeVehicle($infoTicket['dept']['TypeVehicle'])} : {$infoTicket['return']['TypeVehicleFa']} </span>
                                        <span>##RunTime## </span>
                                        <span class="s-u-bozorg s-u-bozorg-change font12">
                                        <i class="font-chanhe"> {$infoTicket['return']['Hour']} </i> ##Hour##
                                        <i class="font-chanhe"> {$infoTicket['return']['Minutes']} </i> ##Minutes##
                                    </span>
                                    </div>

                                </div>
                                <div class="s-u-result-item-div  s-u-result-items-div-change right-Cell-change fltr padb5 displayB400 ">
                                    <span class="iranB">{$infoTicket['return']['OriginCity']}</span>
                                    <span class="iranB">{$infoTicket['return']['DestinationCity']}</span>

                                    <span class="s-u-result-item-date-format s-u-result-item-date-format-change font15">{$infoTicket['return']['OriginDate']}</span>
                                    <span class="s-u-bozorg s-u-bozorg-change  txt14 yekanB">08:45</span>
                                </div>
                                <div class="left-Cell-change">
                                    <div class="s-u-bozorg s-u-bozorg-change">
                                        <span class="s-u-bozorg price">
                                            {if $infoTicket['return']['PriceWithDiscount'] neq 0}
                                                {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($infoTicket['return']['PriceWithDiscount'], $smarty.post.CurrencyCode)}
                                                <i>{$objFunctions->numberFormat($mainCurrency.AmountCurrency)}</i> {$mainCurrency.TypeCurrency}
                                            {else}
                                                {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($infoTicket['return']['AdtPrice'], $smarty.post.CurrencyCode)}
                                                <i>{$objFunctions->numberFormat($mainCurrency.AmountCurrency)}</i> {$mainCurrency.TypeCurrency}
                                            {/if}
                                        </span>

                                        <div class="shenase-nerkhi">
                                            <span class="Direction-rtl">##RateiD## : {$infoTicket['return']['CabinType']}</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </li>
            {/if}



        </ul>
    </div>

    <div class="price-Box displayNone" id="ShowInfoFlightCabinType"></div>
    <div class="clear"></div>

</div>


    <div class="main-Content-bottom Dash-ContentL-B">
    <div class="main-Content-bottom-table Dash-ContentL-B-Table">
        <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title l-p-p-header l-p-p-header-change site-bg-main-color">
            <i class="icon-table"></i><h3>##Listpassengers##</h3>
            <p>
                (
                <i> {$smarty.post.CountAdult} ##Adult## </i>
                {if $smarty.post.CountChild neq 0} - <i>{$smarty.post.CountChild} ##Child##</i>{/if}
                {if $smarty.post.CountInfo neq 0} - <i>{$smarty.post.CountInfo} ##Baby##</i>{/if}
                )
            </p>
        </div>

        <table id="passengers" class="display" width="100%" cellspacing="0">

            <thead>
            <tr>
                <th>##Ages##</th>
                {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                <th>##Name## </th>
                <th>##Family##</th>
                {/if}
                <th>##Nameenglish##</th>
                <th>##Familyenglish##</th>
                <th>##Happybirthday##</th>
                <th>##Numpassport##/##Nationalnumber##</th>
                {if $infoTicket['return'] neq ''}
                    <th>##Wentprice##</th>
                    <th>##Returnprice## </th>
                {else}
                    <th>##Price##</th>
                {/if}
            </tr>
            </thead>
            <tbody>

            {foreach  $objFactor->AdtInfo  as $i=>$Adt}
                {if $Adt['passenger_national_code'] eq '0000000000'}
                    {assign var="index" value=$Adt['passportNumber']}
                {else}
                    {assign var="index" value=$Adt['passenger_national_code']}
                {/if}
            <tr>
                <td> ##Adult## </td>
                 {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                <td><p>{$Adt['passenger_name']}</p></td>
                <td><p>{$Adt['passenger_family']}</p></td>
                {/if}
                <td><p>{$Adt['passenger_name_en']}</p></td>
                <td><p>{$Adt['passenger_family_en']}</p></td>
                <td><p>{if !$Adt['passenger_birthday']} {$Adt['passenger_birthday_en']} {else} {$Adt['passenger_birthday']}{/if}</p></td>
                <td><p>{if $Adt['passenger_national_code'] eq '0000000000'}{$Adt['passportNumber']}{else}{$Adt['passenger_national_code']}{/if}</p></td>
                {if $infoTicket['return'] neq ''}
                    {assign var="deptMainCurrency" value=$objFunctions->CurrencyCalculate($arrPrice[$index]['dept'], $smarty.post.CurrencyCode)}
                    {assign var="returnMainCurrency" value=$objFunctions->CurrencyCalculate($arrPrice[$index]['return'], $smarty.post.CurrencyCode)}

                    <td><p>{$objFunctions->numberFormat($deptMainCurrency.AmountCurrency)} {$deptMainCurrency.TypeCurrency}</p></td>
                    <td><p>{$objFunctions->numberFormat($returnMainCurrency.AmountCurrency)} {$deptMainCurrency.TypeCurrency}</p></td>
                {else}
                    <td><p>
                        {if $Adt['percent_discount'] neq 0}
                            {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($Adt['discount_adt_price'], $smarty.post.CurrencyCode)}
                            {$objFunctions->numberFormat($mainCurrency.AmountCurrency)} {$mainCurrency.TypeCurrency}
                        {else}
                            {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($Adt['adt_price'], $smarty.post.CurrencyCode)}
                            {$objFunctions->numberFormat($mainCurrency.AmountCurrency)} {$mainCurrency.TypeCurrency}
                        {/if}
                    </p></td>
                {/if}
            </tr>
            {/foreach}

            {foreach  $objFactor->ChdInfo  as $Chd}
                {if $Chd['passenger_national_code'] eq '0000000000'}
                    {assign var="index" value=$Chd['passportNumber']}
                {else}
                    {assign var="index" value=$Chd['passenger_national_code']}
                {/if}
            <tr>
                <td>##Child##</td>
                 {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                <td><p>{$Chd['passenger_name']}</p></td>
                <td><p>{$Chd['passenger_family']}</p></td>
                {/if}
                <td><p>{$Chd['passenger_name_en']}</p></td>
                <td><p>{$Chd['passenger_family_en']}</p></td>
                <td><p>{if !$Chd['passenger_birthday']} {$Chd['passenger_birthday_en']} {else} {$Chd['passenger_birthday']}{/if}</p></td>
                <td><p>{if $Chd['passenger_national_code'] eq '0000000000' }{$Chd['passportNumber']}{else}{$Chd['passenger_national_code']}{/if}</p></td>
                {if $infoTicket['return'] neq ''}
                    {assign var="deptMainCurrency" value=$objFunctions->CurrencyCalculate($arrPrice[$index]['dept'], $smarty.post.CurrencyCode)}
                    {assign var="returnMainCurrency" value=$objFunctions->CurrencyCalculate($arrPrice[$index]['return'], $smarty.post.CurrencyCode)}

                    <td><p>{$objFunctions->numberFormat($deptMainCurrency.AmountCurrency)} {$deptMainCurrency.TypeCurrency}</p></td>
                    <td><p>{$objFunctions->numberFormat($returnMainCurrency.AmountCurrency)} {$deptMainCurrency.TypeCurrency}</p></td>
                {else}
                    <td><p>
                        {if $Chd['percent_discount'] neq 0}
                            {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($Chd['discount_chd_price'], $smarty.post.CurrencyCode)}
                            {$objFunctions->numberFormat($mainCurrency.AmountCurrency)} {$mainCurrency.TypeCurrency}
                        {else}
                            {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($Chd['chd_price'], $smarty.post.CurrencyCode)}
                            {$objFunctions->numberFormat($mainCurrency.AmountCurrency)} {$mainCurrency.TypeCurrency}
                        {/if}
                    </p></td>
                {/if}

            </tr>
            {/foreach}

            {foreach  $objFactor->InfInfo  as $Inf}
            {if $Inf['passenger_national_code'] eq '0000000000'}
                {assign var="index" value=$Inf['passportNumber']}
            {else}
                {assign var="index" value=$Inf['passenger_national_code']}
            {/if}
            <tr>
                <td>##Baby##</td>
                 {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                <td><p>{$Inf['passenger_name']}</p></td>
                <td><p>{$Inf['passenger_family']}</p></td>
                {/if}
                <td><p>{$Inf['passenger_name_en']}</p></td>
                <td><p>{$Inf['passenger_family_en']}</p></td>
                <td><p>{if !$Inf['passenger_birthday']} {$Inf['passenger_birthday_en']} {else} {$Inf['passenger_birthday']}{/if}</p></td>
                <td><p>{if $Inf['passenger_national_code'] eq '0000000000'}{$Inf['passportNumber']}{else}{$Inf['passenger_national_code']}{/if}</p></td>
                {if $infoTicket['return'] neq ''}
                    {assign var="deptMainCurrency" value=$objFunctions->CurrencyCalculate($arrPrice[$index]['dept'], $smarty.post.CurrencyCode)}
                    {assign var="returnMainCurrency" value=$objFunctions->CurrencyCalculate($arrPrice[$index]['return'], $smarty.post.CurrencyCode)}

                    <td><p>{$objFunctions->numberFormat($deptMainCurrency.AmountCurrency)} {$deptMainCurrency.TypeCurrency}</p></td>
                    <td><p>{$objFunctions->numberFormat($returnMainCurrency.AmountCurrency)} {$deptMainCurrency.TypeCurrency}</p></td>
                {else}
                    <td><p>
                        {if $Inf['percent_discount'] neq 0}
                            {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($Inf['discount_inf_price'], $smarty.post.CurrencyCode)}
                            {$objFunctions->numberFormat($mainCurrency.AmountCurrency)} {$mainCurrency.TypeCurrency}
                        {else}
                            {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($Inf['inf_price'], $smarty.post.CurrencyCode)}
                            {$objFunctions->numberFormat($mainCurrency.AmountCurrency)} {$mainCurrency.TypeCurrency}
                        {/if}
                    </p></td>
                {/if}

            </tr>
            {/foreach}

            <tr>
                {assign var="totalMainCurrency" value=$objFunctions->CurrencyCalculate($objFactor->totalPrice, $smarty.post.CurrencyCode)}

                <td  colspan="{if $infoTicket['return'] neq ''}
                {if $smarty.const.SOFTWARE_LANG eq 'fa'}8{else}6{/if}
                {else} {if $smarty.const.SOFTWARE_LANG eq 'fa'}7{else}5{/if}
                {/if}" class="txtLeft td_price" >##TotalPrice## :</td>
                <td class="td_price"><p class="price-after-discount-code td_price">{$objFunctions->numberFormat($totalMainCurrency.AmountCurrency)} {$totalMainCurrency.TypeCurrency}</p></td>

            </tr>

            </tbody>
        </table>
    </div>
</div>




<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 s-u-passenger-wrapper-change  " style="padding: 0">
    <div class="s-u-result-wrapper">
        <div class="s-u-result-item-change direcR iranR txt12 txtRed s-u-result-item-RulsCheck">
            <div style="text-align: right">
                {foreach key=direction item=item from=$objResult->direction} {* لازم برای انتخاب نوع بانک *}
                    {append var='serviceType' index=$direction value=$objFunctions->TypeService('charter', $smarty.post.ZoneFlight, 'private', '', $objResult->infoTicket[$direction]['Airline'])}
                {/foreach}
                {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] =='5'}
                    <div class="s-u-result-item-RulsCheck-item">
                        <input class="FilterHoteltype Show_all FilterHoteltypeName-top" id="discount_code" name="" value=""   type="checkbox">
                        <label class="FilterHoteltypeName site-main-text-color-a  " for="discount_code" >##Ihavediscountcodewantuse##</label>

                        <div class="col-sm-12  parent-discount displayiN ">
                            <div class="row separate-part-discount">
                                <div class="col-sm-6 col-xs-12">
                                    <label for="discount-code">##Codediscount## :</label>
                                    <input type="text" id="discount-code" class="form-control" >
                                </div>
                                <div class="col-sm-2 col-xs-12">
                                <span class="input-group-btn">
                                    <input type="hidden" name="priceWithoutDiscountCode" id="priceWithoutDiscountCode" value="{$totalMainCurrency.AmountCurrency}" />
                                    <button type="button" onclick='setDiscountCode({$serviceType|json_encode}, {$smarty.post.CurrencyCode})' class="site-secondary-text-color site-main-button-flat-color iranR discount-code-btn">##Reviewapplycode##  </button>
                                </span>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <span class="discount-code-error"></span>
                                </div>
                            </div>
                            <div class="row separate-part-discount">
                                <div class="info-box__price info-box__item pull-left">
                                    <div class="item-discount">
                                        <span class="item-discount__label">##Amountpayable## :</span>
                                        <span class="price__amount-price price-after-discount-code">{$objFunctions->numberFormat($totalMainCurrency.AmountCurrency)}</span>
                                        <span class="price__unit-price">{$totalMainCurrency.TypeCurrency}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {/if}

                <p class="s-u-result-item-RulsCheck-item">
                    <input class="FilterHoteltype Show_by_filters FilterHoteltypeName-top" id="RulsCheck" name="heck_list1" value="" type="checkbox">
                    <label class="FilterHoteltypeName roulst__factor site-main-text-color-a " for="RulsCheck">
                        <a class="txtRed" href="{$smarty.const.URL_RULS}" target="_blank">##Seerules## </a> ##IhavestudiedIhavenoobjection##
                    </label>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>

<div class="btns_factors_n">
<div class="passengersDetailLocal_next">
        <a href="" onclick="return false" class="f-loader-check loaderfactors" id="loader_check" style="display:none"></a>
    <a class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-bg-main-color factorLocal-btn"
       id="final_ok_and_insert_passenger"
       onclick="reserveTicket('{$objFactor->factorNumber}', '{$objFactor->idMember}')">##Approvefinal##  </a>
</div>
</div>
<div id="messageBook" class="error-flight"></div>
</div>
</div>
</div>




<!-- bank connect -->
<div class="main-pay-content">


    <!-- payment methods drop down -->
    {assign var="memberCreditPermition" value="0"}
    {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] == '5'}
        {$memberCreditPermition = "1"}
    {/if}

    {assign var="counterCreditPermition" value="0"}
    {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] != '5'}
        {$counterCreditPermition = "1"}
    {/if}

    {assign var="bankInputs" value=['flag' => 'check_credit_reservation_ticket', 'factorNumber' => $objFactor->factorNumber, 'paymentPrice' => $objFactor->totalPrice, 'serviceType' => $serviceType]}
    {assign var="bankAction" value="`$smarty.const.ROOT_ADDRESS`/goBankReservationTicket"}

    {assign var="creditInputs" value=['flag' => 'buyByCreditReservationTicket', 'factorNumber' => $objFactor->factorNumber, 'paymentPrice' => $objFactor->totalPrice, 'userId' => $smarty.session.userId]}
    {assign var="creditAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankReservationTicket"}

    {assign var="currencyPermition" value="0"}
    {if $smarty.const.ISCURRENCY && $smarty.post.CurrencyCode > 0}
        {$currencyPermition = "1"}
        {assign var="currencyInputs" value=['flag' => 'check_credit_reservation_ticket', 'factorNumber' => $objFactor->factorNumber, 'paymentPrice' => $objFactor->totalPrice, 'serviceType' => $serviceType, 'amount' => $totalMainCurrency.AmountCurrency, 'currencyCode' => $smarty.post.CurrencyCode]}
        {assign var="currencyAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankReservationTicket"}
    {/if}

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`paymentMethods.tpl"}
    <!-- payment methods drop down -->


</div>


<!--BACK TO TOP BUTTON-->
<div class="backToTop"></div>


{literal}

<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#passengers').DataTable()

        $('#passengers tbody').on('click', 'tr', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected')
            } else {
                table.$('tr.selected').removeClass('selected')
                $(this).addClass('selected')
            }
        })

        $('#button').click(function () {
            table.row('.selected').remove().draw(false)
        })
    })


    $('body').delegate('.closeBtn', 'click', function () {

        $('.price-Box').removeClass('displayBlock')
        $('#lightboxContainer').removeClass('displayBlock')
    })
</script>

<!-- jQuery Site Scipts -->
<script src="assets/js/jquery.counter.js" type="text/javascript"></script>
<script>
   $('.counter').counter({})
   $('.counter').on('counterStop', function () {
       $.confirm({
           theme: 'supervan' ,// 'material', 'bootstrap'
           title: '##Update##',
           icon: 'fa fa-clock',
           content: '##bookingexpiredreservationbeginning##',
           rtl: true,
           closeIcon: true,
           type: 'orange',
           buttons: {
               confirm: {
                   text: '##Approve##',
                   btnClass: 'btn-green',
                   action: function () {
                       location.href = '{/literal}{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}{literal}'
                   },
               },
               cancel: {
                   text: '##Optout##',
                   btnClass: 'btn-orange',
                   action: function () {
                       location.href = '{/literal}{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}{literal}'
                   },
               },
           },
       })
   })
</script>
<script src="assets/js/script.js"></script>
     <!-- modal login    -->
<script type="text/javascript" src="assets/js/modal-login.js"></script>

{/literal}