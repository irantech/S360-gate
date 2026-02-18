<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>

{load_presentation_object filename="resultReservationTicket" assign="objResult"}
{assign var="infoTicket" value=$objResult->infoTicket()}

{assign var="InfoMember" value=$objFunctions->infoMember($objSession->getUserId())}



{if $objResult->errorPage eq true}
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 s-u-passenger-wrapper-change">
    <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
        ##Note##
        <i class="zmdi zmdi-alert-circle mart10  zmdi-hc-fw"></i>
    </span>
        <div class="s-u-result-wrapper">
            <span class="s-u-result-item-change direcR iranR txt12 txtRed">{$objResult->errorMessage}</span>
        </div>
    </div>
{else}

    {load_presentation_object filename="passengersDetailLocal" assign="objDetail"}
    {$objDetail->getCustomers()}   {*گرفتن اطلاعات مربوط به مسافران هر مشتری*}
    <div id="lightboxContainer" class="lightboxContainerOpacity"></div>
    <!-- last passenger list -->
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`passengerPopup.tpl"}
    <!--end  last passenger list -->
<div class="container-fluid">
    <div id="steps">
        <div class="steps_items">
            <div class="step done">

            <span class="">
                <i class="fa fa-check"></i>
            </span>

                <h3>##Selectionflight##</h3>

            </div>
            <i class="separator donetoactive"></i>
            <div class="step active">
        <span class="flat_icon_airplane">
        <svg id="Capa_1" enable-background="new 0 0 501.577 501.577" height="25" viewBox="0 0 501.577 501.577" width="25"
             xmlns="http://www.w3.org/2000/svg">
    <g>
        <path d="m441 145.789h29v105h-29z"/>
        <path d="m60 85.789h-60v387.898l60-209.999z"/>
        <path d="m86.314 280.789-60 210h420.263l55-210z"/>
        <g>
            <path d="m210.074 85.789c-19.299 0-35 15.701-35 35v20c0 19.299 15.701 35 35 35 11.095 0 21.303-5.118 28.008-14.041 4.574-6.089 6.992-13.337 6.992-20.959v-20c0-7.622-2.418-14.871-6.993-20.962-6.706-8.921-16.914-14.038-28.007-14.038z"/>
            <path d="m150.074 250.789h119.926.074v-28.82c0-10.283-4.439-20.067-12.18-26.844l-5.646-4.941c-11.675 9.932-26.667 15.605-42.174 15.605-16.086 0-30.814-5.887-42.176-15.602l-5.647 4.94c-7.737 6.773-12.177 16.557-12.177 26.841z"/>
            <path d="m410 145.789v-135h-320v240h29.901.099.074v-28.82c0-18.933 8.172-36.944 22.42-49.417l7.624-6.67c-3.245-7.725-5.044-16.202-5.044-25.093v-20c0-35.841 29.159-65 65-65 20.312 0 39.749 9.727 51.991 26.018l.002.003c8.51 11.329 13.007 24.808 13.007 38.979v20c0 8.747-1.719 17.228-5.031 25.104l7.609 6.658c14.25 12.475 22.422 30.486 22.422 49.418v28.82h110.926v-105zm-30 15h-55v-30h55zm0-60h-85v-30h85z"/>
        </g>
    </g>
</svg>

            </span>
                <h3>##PassengersInformation##</h3>

            </div>
            <i class="separator"></i>
            <div class="step " >
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
                <h3> ##Approvefinal## </h3>
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
                <h3> ##TicketReservation## </h3>
            </div>
        </div>

        <div class="counter counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"
             style="direction: ltr"> {$objDetail->SetTimeLimit($objDetail->totalQty)}</div>

    </div>
    <div id="fligh_Detail_local" class="s-u-content-result">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 s-u-passenger-wrapper">
        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color ">
            <i class="zmdi zmdi-ticket-star mart10  zmdi-hc-fw"></i>##Purchasingfollowingticket##
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

                        <div class="s-u-result-item-div s-u-result-content-item-div-change">
                            {if $smarty.post.typeApplication eq 'reservation'}
                                <span>##FlightNumber## : {$infoTicket['dept']['FlightNumber']}</span>
                            {elseif $smarty.post.typeApplication eq 'reservationBus'}{*تعریف اتوبوس در پنل ادمین و نمایش آن به عنوان تور تهرانگردی تهران (برای مشتری جوی)*}
                                <span>##Nametour##: {$infoTicket['dept']['FlightNumber']}</span>
                            {else}
                                <span> {$infoTicket['dept']['FlightNumber']}</span>
                            {/if}
                        </div>
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
                                            <span class="s-u-result-item-date-format s-u-result-item-date-format-change iranB">{$OriginateDate['day']}
                                                ,{$OriginateDate['date_now']}</span>
                                            <span class="s-u-bozorg s-u-bozorg-change  txt14 yekanB">{$infoTicket['dept']['OriginTime']}</span>
                                        </div>
                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr">
                                            <span class="iranB">{$infoTicket['dept']['DestinationCity']}</span>
                                            <span class="s-u-result-item-date-format s-u-result-item-date-format-change iranB">{$OriginateDateArrival['day']}
                                                ,{$OriginateDateArrival['date_now']}</span>
                                            <span class="s-u-bozorg s-u-bozorg-change  txt14 yekanB">{$infoTicket['dept']['DestinationTime']}</span>
                                        </div>
                                    {elseif $smarty.post.typeApplication eq 'reservationBus'}
                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr">
                                            <span class="iranB">{$infoTicket['dept']['DestinationRegion']}</span>
                                            <span class="s-u-result-item-date-format s-u-result-item-date-format-change iranB">{$OriginateDate['day']}
                                                ,{$OriginateDate['date_now']}</span>
                                        </div>
                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr">
                                            <span>##Starttime##: </span>
                                            <span class="s-u-bozorg s-u-bozorg-change  txt14 yekanB"> از {$infoTicket['dept']['OriginTime']}
                                                تا {$infoTicket['dept']['DestinationTime']} </span>
                                        </div>
                                    {/if}

                                    <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr  show-div">
<!--                                        <span> {$objResult->getTypeVehicle($infoTicket['dept']['TypeVehicle'])}
                                            : {$infoTicket['dept']['TypeVehicleFa']} </span>-->
                                        <span>##Starttime##</span>
                                        <span class="s-u-bozorg s-u-bozorg-change font12">
                                        <i class="font-chanhe"> {$infoTicket['dept']['Hour']} </i> ##Hour##
                                        <i class="font-chanhe"> {$infoTicket['dept']['Minutes']} </i> ##Minutes##
                                    </span>
                                        {if $smarty.post.typeApplication eq 'reservation'}
                                            <div class="shenase-nerkhi">
                                                <span class="Direction-rtl">##RateiD## : {$infoTicket['dept']['CabinType']}</span>
                                            </div>
                                        {/if}
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
                                                {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($infoTicket['dept']['PriceWithDiscount'], $infoTicket['CurrencyCode'])}
                                                <i>{$objFunctions->numberFormat($mainCurrency.AmountCurrency)}</i>{$mainCurrency.TypeCurrency}
                                            {else}
                                                {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($infoTicket['dept']['AdtPrice'], $infoTicket['CurrencyCode'])}
                                                <i>{$objFunctions->numberFormat($mainCurrency.AmountCurrency)}</i>
                                                {$mainCurrency.TypeCurrency}
                                            {/if}
                                        </span>



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
                                            <span class="s-u-result-item-date-format s-u-result-item-date-format-change iranB">{$OriginateDate['day']}
                                                ,{$OriginateDate['date_now']}</span>
                                            <span class="s-u-bozorg s-u-bozorg-change  txt14 yekanB">{$infoTicket['return']['OriginTime']}</span>
                                        </div>

                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr">
                                            <span class="iranB">{$infoTicket['return']['DestinationCity']}</span>
                                            <span class="s-u-result-item-date-format s-u-result-item-date-format-change iranB">{$OriginateDateArrival['day']}
                                                ,{$OriginateDateArrival['date_now']}</span>
                                            <span class="s-u-bozorg s-u-bozorg-change  txt14 yekanB">{$infoTicket['return']['DestinationTime']}</span>
                                        </div>

                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr  show-div">
<!--                                            <span> {$objResult->getTypeVehicle($infoTicket['dept']['TypeVehicle'])}
                                                : {$infoTicket['return']['TypeVehicleFa']} </span>-->
                                            <span>##Starttime##</span>
                                            <span class="s-u-bozorg s-u-bozorg-change font12">
                                        <i class="font-chanhe"> {$infoTicket['return']['Hour']} </i> ##Hour##
                                        <i class="font-chanhe"> {$infoTicket['return']['Minutes']} </i> ##Minutes##
                                    </span>
                                            <div class="shenase-nerkhi">
                                                <span class="Direction-rtl">##RateiD## : {$infoTicket['return']['CabinType']}</span>
                                            </div>
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
                                                {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($infoTicket['return']['PriceWithDiscount'], $infoTicket['CurrencyCode'])}
                                                <i>{$objFunctions->numberFormat($mainCurrency.AmountCurrency)}</i>
{$mainCurrency.TypeCurrency}
                                            {else}
                                                {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($infoTicket['return']['AdtPrice'], $infoTicket['CurrencyCode'])}

                                                <i>{$objFunctions->numberFormat($mainCurrency.AmountCurrency)}</i>
                                                {$mainCurrency.TypeCurrency}
                                            {/if}
                                        </span>



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

    </div>
    </div>
    <div class="price-Box displayNone" id="ShowInfoFlightCabinType"></div>
    <div class="clear"></div>

    <form method="post" id="formPassengerDetailTicketReservation" action="{$smarty.const.ROOT_ADDRESS}/factorTicketReservation">

        <input type="hidden" name="StatusRefresh" id="StatusRefresh" value="NoRefresh"/>
        <input type="hidden" id="numberRow" value="0">
        <input type="hidden" id="time_remmaining" value="" name="time_remmaining">
        <input type="hidden" id="CountAdult" name="CountAdult" value="{$smarty.post.CountAdult}">
        <input type="hidden" id="CountChild" name="CountChild" value="{$smarty.post.CountChild}">
        <input type="hidden" id="CountInfo" name="CountInfo" value="{$smarty.post.CountInfo}">
        <input type="hidden" id="IdFlight" name="IdFlight" value="{$smarty.post.IdFlight}">
        <input type="hidden" id="flight_id_return" name="flight_id_return" value="{$smarty.post.flight_id_return}">
        <input type="hidden" id="FlightDirection" name="FlightDirection" value="{$smarty.post.FlightDirection}">
        <input type="hidden" id="MultiWay" name="MultiWay" value="{$smarty.post.MultiWay}">
        <input type="hidden" id="FactorNumber" name="FactorNumber" value="{$objResult->createFactorNumber()}">
        <input type="hidden" value="" name="IdMember" id="IdMember">
        <input type="hidden" name="ZoneFlight" id="ZoneFlight" value="{$infoTicket['dept']['ZoneFlight']}">
        <input type="hidden" name="typeApplication" id="typeApplication" value="{$smarty.post.typeApplication}">
        <input type="hidden" name="CurrencyCode" id="CurrencyCode" value="{$infoTicket['CurrencyCode']}">

        {for $nAdult=1 to $smarty.post.CountAdult}
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 s-u-passenger-wrapper s-u-passenger-wrapper-change">

        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color ">
            ##Adult##
                {if $objSession->IsLogin()}
                    <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change"
                          onclick="setHidenFildnumberRow('A{$nAdult}')">
                        <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i> ##Passengerbook##
                    </span>
                {/if}
            <i class="soap-icon-family"></i>
        </span>
                <div class="panel-default-change">
                    <div class="panel-default-change pull-right">


                        {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                        <span class="kindOfPasenger">
                            <label class="control--checkbox">
                                <span>##Iranian##</span>
                                <input type="radio" name="passengerNationalityA{$nAdult}"
                                       id="passengerNationalityA{$nAdult}" value="0" class="nationalityChange"
                                       {if $smarty.const.SOFTWARE_LANG eq 'fa'}checked="checked"{/if}>
                                <div class="checkbox">
                                    <div class="filler"></div>
                                 <svg fill="#000000"  viewBox="0 0 30 30" >
                                            <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                                           </svg>
                                </div>
                            </label>
                        </span>
                        <span class="kindOfPasenger">
                            <label class="control--checkbox">
                                <span>##Noiranian##</span>
                                <input type="radio" name="passengerNationalityA{$nAdult}"
                                       id="passengerNationalityA{$nAdult}" value="1" class="nationalityChange">
                                <div class="checkbox">
                                    <div class="filler"></div>
                                    <svg fill="#000000"  viewBox="0 0 30 30" >
                                            <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                                           </svg>
                                </div>
                            </label>
                        </span>
                        {/if}



                    </div>
                    <div class="clear"></div>

                    <div class="panel-body-change">
                        <div class="s-u-passenger-item  s-u-passenger-item-change ">
                            <select id="genderA{$nAdult}" name="genderA{$nAdult}">
                                <option value="" disabled="" selected="selected">##Sex##</option>
                                <option value="Male">##Sir##</option>
                                <option value="Female">##Lady##</option>
                            </select>
                        </div>

                        <div class="s-u-passenger-item s-u-passenger-item-changes">
                            <input id="nameEnA{$nAdult}" type="text" placeholder="##Nameenglish##"
                                   name="nameEnA{$nAdult}"
                                   onkeypress="return isAlfabetKeyFields(event, 'nameEnA{$nAdult}')"
                                   class="">
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change">
                            <input id="familyEnA{$nAdult}" type="text" placeholder="##Familyenglish##"
                                   name="familyEnA{$nAdult}"
                                   onkeypress="return isAlfabetKeyFields(event, 'familyEnA{$nAdult}')"
                                   class="">
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                            <input id="birthdayEnA{$nAdult}" type="text" placeholder="##miladihappybirthday##"
                                   name="birthdayEnA{$nAdult}"
                                   class="gregorianAdultBirthdayCalendar" readonly="readonly">
                        </div>
                        {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                        <div class="s-u-passenger-item s-u-passenger-item-change justpersian_name">
                            <input id="nameFaA{$nAdult}" type="text" placeholder="##Namepersion##"
                                   name="nameFaA{$nAdult}"
                                   onkeypress=" return persianLetters(event, 'nameFaA{$nAdult}')"
                                   class="justpersian">
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change justpersian_name">
                            <input id="familyFaA{$nAdult}" type="text" placeholder="##Familypersion##"
                                   name="familyFaA{$nAdult}"
                                   onkeypress=" return persianLetters(event, 'familyFaA{$nAdult}')"
                                   class="justpersian">
                        </div>
                        {/if}
                        <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                            <input id="birthdayA{$nAdult}" type="text"
                                   placeholder="##shamsihappybirthday##" name="birthdayA{$nAdult}"
                                   class="shamsiAdultBirthdayCalendar" readonly="readonly">
                        </div>

                        <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                            <input id="NationalCodeA{$nAdult}" type="tel"
                                   placeholder="##Nationalnumber##" name="NationalCodeA{$nAdult}" maxlength="10"
                                   class="UniqNationalCode"
                                   onkeyup="return checkNumber(event, 'NationalCodeA{$nAdult}')">
                        </div>

                        <div class="s-u-passenger-item s-u-passenger-item-change select-meliat noneIranian">
                            <select name="passportCountryA{$nAdult}" id="passportCountryA{$nAdult}" class="select2">
                                <option value="">##Countryissuingpassport##</option>
                                {foreach $objFunctions->CountryCodes() as $Country}
                                    <option value="{$Country['code']}">{if $smarty.const.SOFTWARE_LANG eq 'fa'}{$Country['titleFa']}{else}{$Country['titleEn']}{/if}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change {if $infoTicket['dept']['ZoneFlight'] eq 'Local'}noneIranian{/if}">
                            <input id="passportNumberA{$nAdult}" type="text" placeholder="##Numpassport##"
                                   name="passportNumberA{$nAdult}" class="UniqPassportNumber"
                                   onkeypress="return isAlfabetNumberKeyFields(event, 'passportNumberA{$nAdult}')">
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change {if $infoTicket['dept']['ZoneFlight'] eq 'Local'}noneIranian{/if}">
                            <input id="passportExpireA{$nAdult}" class="gregorianFromTodayCalendar" type="text"
                                   placeholder="##Passportexpirydate##" name="passportExpireA{$nAdult}">
                        </div>

                        <div id="messageA{$nAdult}"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        {/for}


        {if $smarty.post.CountChild neq '0'}
            {for $nChild=1 to $smarty.post.CountChild}
                <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change  first">

                <span class="s-u-last-p-koodak s-u-last-p-koodak-change site-main-text-color">##Child##
                       {if $objSession->IsLogin()}
                           <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change"
                                 onclick="setHidenFildnumberRow('C{$nChild}')">
                                <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i> ##Passengerbook##
                            </span>
                       {/if}
                    <i class="soap-icon-man-3"></i>
                </span>

                    <div class="panel-default-change ">
                        <div class="panel-default-change pull-right">



                            <span class="kindOfPasenger">
                            <label class="control--checkbox">
                                <span>##Iranian##</span>
                                <input type="radio" name="passengerNationalityC{$nChild}"
                                       id="passengerNationalityC{$nChild}"
                                       value="0" class="nationalityChange" checked="checked">
                                <div class="checkbox">
                                    <div class="filler"></div>
                                   <svg fill="#000000"  viewBox="0 0 30 30" >
                                        <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                                     </svg>
                                </div>
							</label>
                        </span>
                            <span class="kindOfPasenger">
                            <label class="control--checkbox">
                                <span>##Noiranian##</span>
                                <input type="radio" name="passengerNationalityC{$nChild}"
                                       id="passengerNationalityC{$nChild}"
                                       value="1" class="nationalityChange">
                                <div class="checkbox">
                                    <div class="filler"></div>
                                   <svg fill="#000000"  viewBox="0 0 30 30" >
                                            <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                                           </svg>
                                </div>
							</label>
                        </span>



                        </div>
                        <div class="clear"></div>
                        <div class="panel-body-change">
                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <select id="genderC{$nChild}" name="genderC{$nChild}">
                                    <option value="" disabled="" selected="selected">##Sex##</option>
                                    <option value="Male">##Sir##</option>
                                    <option value="Female">##Lady##</option>
                                </select>
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <input id="nameEnC{$nChild}" type="text" placeholder="##Nameenglish##"
                                       name="nameEnC{$nChild}"
                                       onkeypress="return isAlfabetKeyFields(event, 'nameEnC{$nChild}')">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <input id="familyEnC{$nChild}" type="text" placeholder="##Familyenglish##"
                                       name="familyEnC{$nChild}"
                                       onkeypress="return isAlfabetKeyFields(event, 'familyEnC{$nChild}')">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <input id="birthdayEnC{$nChild}" type="text" placeholder="##miladihappybirthday##"
                                       name="birthdayEnC{$nChild}"
                                       class="gregorianChildBirthdayCalendar" readonly="readonly">
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <input id="nameFaC{$nChild}" type="text" placeholder="##Namepersion##"
                                       name="nameFaC{$nChild}"
                                       onkeypress=" return persianLetters(event, 'nameFaC{$nChild}')"
                                       class="justpersian">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <input id="familyFaC{$nChild}" type="text" placeholder="##Familypersion##"
                                       name="familyFaC{$nChild}"
                                       onkeypress=" return persianLetters(event, 'familyFaC{$nChild}')"
                                       class="justpersian">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input id="birthdayC{$nChild}" type="text" placeholder="##shamsihappybirthday##"
                                       name="birthdayC{$nChild}"
                                       class="shamsiChildBirthdayCalendar" readonly="readonly">
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input id="NationalCodeC{$nChild}" type="tel" placeholder="##Nationalnumber##"
                                       name="NationalCodeC{$nChild}"
                                       maxlength="10" class="UniqNationalCode"
                                       onkeyup="return checkNumber(event, 'NationalCodeC{$nChild}')">
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change select-meliat noneIranian">
                                <select name="passportCountryC{$nChild}" id="passportCountryC{$nChild}" class="select2">
                                    <option value="">##Countryissuingpassport##</option>
                                    {foreach $objFunctions->CountryCodes() as $Country}
                                        <option value="{$Country['code']}">{$Country['titleFa']}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change {if $infoTicket['dept']['ZoneFlight'] eq 'Local'}noneIranian{/if}">
                                <input id="passportNumberC{$nChild}" type="text" placeholder="##Numpassport##"
                                       name="passportNumberC{$nChild}"
                                       class="UniqPassportNumber"
                                       onkeypress="return isAlfabetNumberKeyFields(event, 'passportNumberC{$nChild}')">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change {if $infoTicket['dept']['ZoneFlight'] eq 'Local'}noneIranian{/if}">
                                <input id="passportExpireC{$nChild}" class="gregorianFromTodayCalendar" type="text"
                                       placeholder="##Passportexpirydate##" name="passportExpireC{$nChild}">
                            </div>

                            <div id="messageC{$nChild}"></div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            {/for}
        {/if}


        {if $smarty.post.CountInfo neq '0'}
            {for $nInfo=1 to $smarty.post.CountInfo}
                <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">
                <span class="s-u-last-p-nozad s-u-last-p-nozad-change site-main-text-color">##Baby##
                             {if $objSession->IsLogin()}
                                 <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change"
                                       onclick="setHidenFildnumberRow('I{$nInfo}')">
                                <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i> ##Passengerbook##
                            </span>
                             {/if}
                    <i class="soap-icon-man-1"></i>
                </span>
                    <div class="panel-default-change ">
                        <div class="panel-default-change pull-right">



                            <span class="kindOfPasenger">
                            <label class="control--checkbox">
                                <span>##Iranian##</span>
                                <input type="radio" name="passengerNationalityI{$nInfo}"
                                       id="passengerNationalityI{$nInfo}" value="0" class="nationalityChange"
                                       checked="checked">
                                <div class="checkbox">
                                    <div class="filler"></div>
                                  <svg fill="#000000"  viewBox="0 0 30 30" >
                                            <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                                           </svg>
                                </div>
							</label>
                        </span>
                            <span class="kindOfPasenger">
                            <label class="control--checkbox">
                                <span>##Noiranian##</span>
                                <input type="radio" name="passengerNationalityI{$nInfo}"
                                       id="passengerNationalityI{$nInfo}" value="1" class="nationalityChange">
                                <div class="checkbox">
                                    <div class="filler"></div>
                                  <svg fill="#000000"  viewBox="0 0 30 30" >
                                            <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                                           </svg>
                                </div>
							</label>
                        </span>



                        </div>
                        <div class="clear"></div>
                        <div class="panel-body-change ">
                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <select id="genderI{$nInfo}" name="genderI{$nInfo}">
                                    <option value="" disabled="" selected="selected">##Sex##</option>
                                    <option value="Male">##Sir##</option>
                                    <option value="Female">##Lady##</option>
                                </select>
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <input id="nameEnI{$nInfo}" type="text" placeholder="##Nameenglish##"
                                       name="nameEnI{$nInfo}"
                                       onkeypress="return isAlfabetKeyFields(event, 'nameEnI{$nInfo}')">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <input id="familyEnI{$nInfo}" type="text" placeholder="##Familyenglish##"
                                       name="familyEnI{$nInfo}"
                                       onkeypress="return isAlfabetKeyFields(event, 'familyEnI{$nInfo}')">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <input id="birthdayEnI{$nInfo}" type="text" placeholder="##miladihappybirthday##"
                                       name="birthdayEnI{$nInfo}"
                                       class="gregorianInfantBirthdayCalendar" readonly="readonly">
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <input id="nameFaI{$nInfo}" type="text" placeholder="##Namepersion##"
                                       name="nameFaI{$nInfo}"
                                       onkeypress=" return persianLetters(event, 'nameFaI{$nInfo}')"
                                       class="justpersian">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <input id="familyFaI{$nInfo}" type="text" placeholder="##Familypersion##"
                                       name="familyFaI{$nInfo}"
                                       onkeypress=" return persianLetters(event, 'familyFaI{$nInfo}')"
                                       class="justpersian">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input id="birthdayI{$nInfo}" type="text" placeholder="##shamsihappybirthday##"
                                       name="birthdayI{$nInfo}"
                                       class="shamsiInfantBirthdayCalendar" readonly="readonly">
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input id="NationalCodeI{$nInfo}" type="tel" placeholder="##Nationalnumber##"
                                       name="NationalCodeI{$nInfo}" maxlength="10" class="UniqNationalCode"
                                       onkeyup="return checkNumber(event, 'NationalCodeI{$nInfo}')">
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <select name="passportCountryI{$nInfo}" id="passportCountryI{$nInfo}"
                                        class="select2">
                                    <option value="">##Countryissuingpassport##</option>
                                    {foreach $objFunctions->CountryCodes() as $Country}
                                        <option value="{$Country['code']}">{$Country['titleFa']}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change {if $infoTicket['dept']['ZoneFlight'] eq 'Local'}noneIranian{/if}">
                                <input id="passportNumberI{$nInfo}" type="text" placeholder="##Numpassport##"
                                       name="passportNumberI{$nInfo}"
                                       class="UniqPassportNumber"
                                       onkeypress="return isAlfabetNumberKeyFields(event, 'passportNumberI{$nInfo}')">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change {if $infoTicket['dept']['ZoneFlight'] eq 'Local'}noneIranian{/if}">
                                <input id="passportExpireI{$nInfo}" class="gregorianFromTodayCalendar" type="text"
                                       placeholder="##Passportexpirydate##" name="passportExpireI{$nInfo}">
                            </div>

                            <div id="messageI{$nInfo}"></div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            {/for}
        {/if}


        <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer  first">
          <span class="s-u-last-p-pasenger s-u-last-p-pasenger-change site-main-text-color site-border-main-color">
              ##InformationSaler## <i class="zmdi zmdi-account-box-phone zmdi-hc-fw"></i>
          </span>
            <input type="hidden" name="UsageNotLogin" value="yes" id="UsageNotLogin">
            <div class="clear"></div>
            <div class="panel-default-change-Buyer ">
                <div class="s-u-passenger-items s-u-passenger-item-change">
                    <input id="Mobile" type="text" placeholder="##Phonenumber##" name="Mobile"
                           {if $objSession->IsLogin()}value="{$InfoMember.mobile}"{/if}
                           class="dir-ltr" onkeypress="return checkNumber(event, 'Mobile')">
                </div>
                {if not $objSession->IsLogin()}
                    <div class="s-u-passenger-items s-u-passenger-item-change">
                        <input id="Telephone" type="text" placeholder="##Phone##" name="Telephone"
                               class="dir-ltr" onkeypress="return checkNumber(event, 'Telephone')">
                    </div>
                {/if}
                <div class="s-u-passenger-items s-u-passenger-item-change padl0">
                    <input id="Email" type="email" placeholder="##Email##" name="Email"
                           {if $objSession->IsLogin()}value="{$InfoMember.email}"{/if} class="dir-ltr">
                </div>
                <div id="messageInfo"></div>
            </div>
            <div class="clear"></div>
        </div>

        <div class="clear"></div>

        <div class="btns_factors_n">


            <div class="btn_research__">
                <input type="button" value="##Optout##" class="loading_on_click cancel-passenger" onclick="BackToHome(); return false">

            </div>

            <div class="passengersDetailLocal_next">
                <a href="" onclick="return false" class="f-loader-check loaderpassengers" id="loader_check" style="display:none"></a>

                <input type="button" value="##NextStepInvoice##"
                       class="s-u-submit-passenger s-u-select-flight-change site-bg-main-color s-u-submit-passenger-Buyer"
                       id="send_data"
                       onclick="checkTicketReservation('{$smarty.now}', '{$infoTicket['countAdult']}', '{$infoTicket['countChild']}', '{$infoTicket['countInfo']}')">
            </div>

        </div>
    </form>

    </div>
{literal}
    <script type="text/javascript">
        $(document).ready(function () {

            var table = $('#passengers').DataTable();

            $('#passengers tbody').on('click', 'tr', function () {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });

            $('#button').click(function () {
                table.row('.selected').remove().draw(false);
            });

        });
    </script>

    <!-- counter menu -->
    <script src="assets/js/classie.js"></script>
    <script src="assets/js/sidebarEffects.js"></script>

    <!-- jQuery Site Scipts -->
    <script src="assets/js/script.js"></script>

    <script src="assets/js/jdate.min.js" type="text/javascript"></script>
    <script src="assets/js/jdate.js" type="text/javascript"></script>
    <script src="assets/js/jquery.counter.js" type="text/javascript"></script>
    <script type="text/javascript">
        $('.counter').counter({});

        $('.counter').on('counterStop', function () {
            $('.lazy_loader_flight').slideDown({
                start: function () {
                    $(this).css({
                        display: "flex"
                    })
                }
            });

        });
    </script>

    <script type="text/javascript">
        function pad(val) {
            var valString = val + "";
            if (valString.length < 2) {
                return "0" + valString;
            } else {
                return valString;
            }
        }

        // hide popup
        $('.s-u-t-r-p .s-u-t-r-p-h').on("click", function (e) {
            e.preventDefault();
            $(".s-u-black-container").fadeOut('slow');
            $(".s-u-t-r-p").fadeOut('fast');
            return false;
        });
        $('.s-u-b-r-p .s-u-t-r-p-h').on("click", function (e) {
            e.preventDefault();
            $(".s-u-black-container").fadeOut('slow');
            $(".s-u-b-r-p").fadeOut('fast');
            return false;
        });
        $('.s-u-black-container').on("click", function (e) {
            e.preventDefault();
            $('.s-u-black-container').fadeOut('slow');
            $('.s-u-b-r-p').fadeOut('fast');
            $('.s-u-t-r-p').fadeOut('fast');
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {

            $('body').on('click','.slideUpAirDescription',function(){
                $(this).addClass('displayiN');
                $(this).parent('.international-available-details').find('.international-available-panel-min').removeClass('international-available-panel-max');
                $('.international-available-detail-btn.more_1 ').removeClass('displayiN');
            });
            $('body').on('click','.slideDownAirDescription',function(){
                $(this).parents('.international-available-details').find('.international-available-panel-min').addClass('international-available-panel-max');
                $('.slideUpAirDescription').removeClass('displayiN');
            });


            $('ul.tabs li').on("click", function () {

                $(this).siblings().removeClass("current");
                $(this).parent("ul.tabs").siblings(".tab-content").removeClass("current");


                var tab_id = $(this).attr('data-tab');


                $(this).addClass('current');
                $(this).parent("ul.tabs").siblings("#" + tab_id).addClass("current");

            });
        });

    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('body').delegate('.closeBtn', 'click', function () {

                $(".price-Box").removeClass("displayBlock");
                $("#lightboxContainer").removeClass("displayBlock");
            });

            $("div#lightboxContainer").click(function () {

                $(".price-Box").removeClass("displayBlock");
                $("#lightboxContainer").removeClass("displayBlock");
            });

            $("div#lightboxContainer").click(function () {

                $(".Cancellation-Box").removeClass("displayBlock");
                $("#lightboxContainer").removeClass("displayBlock");
            });

            $("div#lightboxContainer").click(function () {
                $(".last-p-popup").css("display", "none");
            });

            $('.DetailSelectTicket').on('click', function (e) {
                $(this).parent().siblings('.DetailSelectTicketContect').slideToggle('fast');
            });
        });

    </script>
{/literal}








{/if}
