<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>
{load_presentation_object filename="resultBusTicket" assign="objResult"}
{assign var="result" value=$objResult->getDetailBusTicket($smarty.post)}
{assign var="InfoMember" value=$objFunctions->infoMember($objSession->getUserId())}
{load_presentation_object filename="passengersDetailLocal" assign="objDetail"}
{$objDetail->getCustomers()}   {*گرفتن اطلاعات مربوط به مسافران هر مشتری*}

<div id="steps">
    <div class="steps_items">
        <div class="step done ">

            <span class=""><i class="fa fa-check"></i></span>
            <h3>##Busreserve##</h3>
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

    <div class="counter d-none counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"
         style="direction: ltr">06:00</div>

</div>



{*<div>
    <div class="counter d-none counter-analog" data-direction="down" data-format="59:59" data-stop="00:00" style="direction: ltr">05:00</div>
</div>*}

<div id="lightboxContainer" class="lightboxContainerOpacity"></div>
<!-- last passenger list -->
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`passengerPopup.tpl"}
<!--end  last passenger list -->

{if $objResult->error}
    <div class="s-u-content-result">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 s-u-passenger-wrapper-change">
            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                <i class="zmdi zmdi-alert-circle mart10  zmdi-hc-fw"></i>
                ##Note##
            </span>
            <div class="s-u-result-wrapper">
                <span class="s-u-result-item-change direcR iranR txt12 txtRed">{$objResult->errorMessage}</span>
            </div>
        </div>
    </div>
{else}
    {*<div class="container mt-3">
        <div class="row">
            <div class="col-lg-12 p-0">
                <div class="alert alert-info" role="alert">
                    <div class="row vertical-align">
                        <div class="col-xs-1 text-center">
                            <i class="fa fa-info fa-2x"></i>
                        </div>
                        <div class="col-xs-11">
                            <strong>##Note## : </strong> ##DontReloadPageInfo##
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>*}
    <div class="s-u-content-result">



        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 s-u-passenger-wrapper-change">
            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                <i class="zmdi zmdi-ticket-star mart10  zmdi-hc-fw"></i>
               ##Isbuying##
            </span>

            <div class="bus-details">
                <div class="bus-info-grid">
                    <!-- Company Info -->
                    <div class="bus-company">
                        <div class="bus-logo">
                            <img src="{$objFunctions->getCompanyBusPhoto($result['detailBus']['company'])}"
                                 alt="{$result['detailBus']['company']}" title="{$result['detailBus']['company']}">
                        </div>
                        <div>
                            <div class="company-name">{$result['detailBus']['company']}</div>
                            <div class="option-name">{$result['detailBus']['car_type']}</div>
                        </div>
                    </div>

                    <!-- Route Info -->
                    <div class="route-info">
                        <div class="departure-time">
                            {$result['detailBus']['time_move']}
                        </div>
                        <div class="travel-date">
                            {$result['date']['dayName']}, {$result['date']['dataString']}
                        </div>

                        <div class="route-details">
                            <div class="location">
                                <div class="location-city">{$result['detailBus']['origin_city']}</div>
                                <div class="location-terminal">{$result['detailBus']['origin_terminal']}</div>
                            </div>
                            <div class="route-arrow">→</div>
                            <div class="location">
                                <div class="location-city">{$result['detailBus']['destination_city']}</div>
                                <div class="location-terminal">{$result['detailBus']['destination_terminal']}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Price Info -->
                    <div class="price-info">
                        {assign var="amountCurrency" value=$objFunctions->CurrencyCalculate($result['price'], $smarty.post.CurrencyCode)}
                        {assign var="setPriceChanges" value=$objResult->setPriceChanges($amountCurrency.AmountCurrency)}

                        {if $setPriceChanges > 0}
                            <div class="price-original">
                                {$objFunctions->numberFormat($result['priceWithoutDiscount'])} {$amountCurrency.TypeCurrency}
                            </div>
                        {/if}

                        <div class="price">
                            {if $setPriceChanges > 0}
                                {$objFunctions->numberFormat($result['price'])}
                            {else}
                                {$objFunctions->numberFormat($amountCurrency.AmountCurrency)}
                            {/if}
                            {$amountCurrency.TypeCurrency}
                        </div>
                        <div class="capacity-info">
                            <span>##Capacity##</span>
                            <span>{$result['detailBus']['count_free_chairs']} صندلی</span>
                        </div>
                    </div>
                </div>
            </div>




{*            <div class="s-u-result-wrapper">*}
{*                <ul>*}

{*                    <li class="col-md-12 d-flex align-items-center flex-wrap">*}

{*                        <div class="s-u-result-item-div s-u-result-item-div-change col-xs-12 col-sm-12 col-md-2 s-u-result-item-div-width">*}
{*                            <div class="s-u-result-item-div-logo s-u-result-item-div-logo-change roundedLogo">*}
{*                                <img src="{$objFunctions->getCompanyBusPhoto($result['detailBus']['company'])}"*}
{*                                     alt="{$result['detailBus']['company']}" title="{$result['detailBus']['company']}">*}
{*                            </div>*}
{*                            <div class="s-u-result-item-div s-u-result-content-item-div-change">*}
{*                                <span class="silence_heading">{$result['detailBus']['company']}</span>*}
{*                            </div>*}
{*                            *}{*<span class="displayib-change d-block"> ظرفیت : {$result['detailBus']['count_free_chairs']} </span>*}
{*                        </div>*}

{*                        <div class="s-u-result-item-wrapper-change col-xs-12 col-sm-12 col-md-10">*}

{*                            <div class="details-wrapper-change">*}

{*                                <div class="s-u-result-raft first-row-change">*}

{*                                    <div style="border:none" class="s-u-result-item-div right-Cell-change fltr padb5 displayN400 ">*}



{*                                            <div class="col-md-3 col-sm-12 col-12 align-items-center flex-wrap d-flex xs-block">*}
{*                                                <div class="col-xs-12 silence_div4 text-dark">*}
{*                                                    <span class="d-block">##Origin## : {$result['detailBus']['origin_city']}</span>*}
{*                                                <div class="col-xs-12 mt-2 silence_text d-block">##OriginTerminal## : {$result['detailBus']['origin_terminal']}</div>*}
{*                                                </div>*}

{*                                                <div class="col-xs-12 silence_div4 text-dark">*}
{*                                                    <span class="d-block">##Destination## : {$result['detailBus']['destination_city']}</span>*}
{*                                                <div class="col-xs-12 mt-2 silence_text d-block">##DestinationTerminal## : {$result['detailBus']['destination_terminal']}</div>*}
{*                                                </div>*}
{*                                                *}{*<span class="s-u-bozorg s-u-bozorg-change  txt14 yekanB">##Between##</span>*}
{*                                            </div>*}
{*                                            <div class="col-md-3 col-sm-12 col-12 align-items-center flex-wrap silence_div6 ">*}
{*                                                <div class="col-md-12 col-6 silence_text text-dark">*}
{*                                                    <div >##Capacity## : <span>{$result['detailBus']['count_free_chairs']}</span></div>*}
{*                                                </div>*}
{*                                                <div class="col-md-12 col-6 silence_text text-dark ">*}
{*                                                    <div >##Bustype## : <span>{$result['detailBus']['car_type']}</span></div>*}
{*                                                </div>*}
{*                                                <span>##Bustype## : {$result['detailBus']['car_type']}</span>*}
{*                                                <span>{$result['detailBus']['description']}</span>*}
{*                                                *}{*<span class="s-u-bozorg s-u-bozorg-change font12">*}
{*                                                    <i class="font-chanhe"> CountChairs </i>##Chair##*}
{*                                                </span>*}
{*                                            </div>*}
{*                                            <div class="col-md-3 col-sm-12 col-12 align-items-center flex-wrap d-flex xs-block xs-bus-padd">*}

{*                                                <div class="col-12 silence_div6">*}
{*                                                *}{*$objResult->DateJalali2($InfoBus.DateMove)*}
{*                                                    ##dateMove## : <span class="text-bold"> {$result['date']['dayName']}, {$result['date']['dataString']}</span>*}
{*                                                </div>*}
{*                                                <div class="col-12 silence_div6">*}
{*                                                    ##timeMove## : <span class="text-bold">{$result['detailBus']['time_move']}</span>*}
{*                                                </div>*}
{*                                            </div>*}
{*                                            <div class="col-md-3 d-flex">*}
{*                                                    <div class="col-md-12 align-items-center flex-wrap d-flex">*}
{*                                                        <div class="s-u-bozorg s-u-bozorg-change">*}

{*                                                            {assign var="amountCurrency" value=$objFunctions->CurrencyCalculate($result['price'], $smarty.post.CurrencyCode)}*}
{*                                                            {assign var="setPriceChanges" value=$objResult->setPriceChanges($amountCurrency.AmountCurrency)}*}


{*                                                            {if $setPriceChanges > 0}*}
{*                                                                <strike><i class="iranM site-main-text-color-drck CurrencyCal" data-amount="{$objFunctions->numberFormat($result['priceWithoutDiscount'])}">*}
{*                                                                        {$objFunctions->numberFormat($result['priceWithoutDiscount'])}</i></strike>*}

{*                                                                <span class="CurrencyText">{$amountCurrency.TypeCurrency}</span>*}


{*                                                                <span class="s-u-bozorg price">*}
{*                                                            <i>{$objFunctions->numberFormat($result['price'])}</i>*}
{*                                                            {$amountCurrency.TypeCurrency}*}
{*                                                        </span>*}
{*                                                            {else}*}
{*                                                                <span class="s-u-bozorg price">*}
{*                                                            <i>{$objFunctions->numberFormat($amountCurrency.AmountCurrency)}</i>*}
{*                                                            {$amountCurrency.TypeCurrency}*}
{*                                                        </span>*}
{*                                                            {/if}*}



{*                                                            *}{*{if $result['priceWithoutDiscount']  neq 0}*}
{*                                                                {assign var="amountCurrency" value=$objFunctions->CurrencyCalculate($result['priceWithoutDiscount'], $smarty.post.CurrencyCode)}*}
{*                                                                <div class="shenase-nerkhi">awdawd*}
{*                                                                    <span class="Direction-rtl" style="text-decoration: line-through;">*}
{*                                                                        <i>{$objFunctions->numberFormat($amountCurrency.AmountCurrency)}</i>*}
{*                                                                    </span>*}
{*                                                                </div>*}
{*                                                            {/if}*}

{*                                                            {assign var="amountCurrency" value=$objFunctions->CurrencyCalculate($result['price'], $smarty.post.CurrencyCode)}*}
{*                                                            <span class="s-u-bozorg price">*}
{*                                                                <i>{$objFunctions->numberFormat(round($amountCurrency.AmountCurrency,-4))}</i>*}
{*                                                                {$amountCurrency.TypeCurrency}*}
{*                                                            </span>*}
{*                                                        </div>*}
{*                                                    </div>*}
{*                                                </div>*}



{*                                    </div>*}


{*                                </div>*}

{*                            </div>*}
{*                        </div>*}

{*                    </li>*}

{*                </ul>*}
{*            </div>*}

            <div class="price-Box displayNone" id="ShowInfoFlightCabinType"></div>

        </div>
        <div class="clear"></div>


        <form method="post" id="formPassengerDetailBusTicket" action="{$smarty.const.ROOT_ADDRESS}/factorBusTicket">

            <input type="hidden" id="numberRow" value="0">
            <input type="hidden" id="currencyCode" name="currencyCode" value="{$smarty.post.currencyCode}">
            <input type="hidden" id="requestNumber" name="requestNumber" value="{$smarty.post.requestNumber}">
            <input type="hidden" id="busCode" name="busCode" value="{$smarty.post.busCode}">
            <input type="hidden" id="sourceCode" name="sourceCode" value="{$smarty.post.sourceCode}">
            <input type="hidden" id="factorNumber" name="factorNumber" value="{$smarty.post.factorNumber}">
            <input type="hidden" name="time_remmaining" id="time_remmaining" value="">
            <input type="hidden" name="idMember" id="idMember" value="">
            <input type="hidden" name="chairNumberReserve" id="chairNumberReserve" value="">
            <input type="hidden" name="countChairReserve" id="countChairReserve" value="0">
            <input type="hidden" name="countChairRowFirst" id="countChairRowFirst" value="0">

{*            {if count($result['refundRules']) > 0}*}

                <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer first">
                    <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                           ##ConsoleFines##
                    </span>
                    <div class="panel-default-change-Buyer-parent--new row">
                        <div data-name="bus-refund-rules" class="desctiptionBus right w-100">
                            <div class="alert-bus">
                                <h6>10% جریمه</h6>
                                <p>از زمان صدور تا 1 ساعت قبل از حرکت</p>
                            </div>
                            <div class="alert-bus">
                                <h6>50% جریمه حضوری</h6>
                                <p>از 1 ساعت قبل از حرکت تا پس از آن</p>
                            </div>
                        </div>
{*                        <div class="desctiptionBus right w-100">*}
{*                {foreach $result['refundRules'] as $rule}*}
{*                            <div class="alert alert-primary" role="alert">*}
{*                    {if isset($rule.From) && isset($rule.Percent)}*}
{*                        {assign var=time value=$rule.From|substr:1}*}
{*                        {assign var=hours value=$time|replace:":":" "}*}
{*                        {assign var=hours value=$hours|intval}*}
{*                        از لحظه خرید تا {$hours} ساعت قبل از حرکت کسر  {$rule.Percent}% جریمه*}
{*                    {elseif isset($rule.To) && isset($rule.Percent)}*}
{*                        {assign var=time value=$rule.To|substr:1}*}
{*                        {assign var=hours value=$time|replace:":":" "}*}
{*                        {assign var=hours value=$hours|intval}*}
{*                        از {$hours} ساعت قبل از حرکت کسر  {$rule.Percent}% جریمه*}
{*                    {/if}*}
{*                            </div>*}
{*                {/foreach}*}
{*                        </div>*}
                    </div>
                </div>

{*            {/if}*}

            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer first">
                <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                       ##Seatselect##
                </span>
              {*  <span class="s-u-last-p-pasenger s-u-last-p-pasenger-change site-bg-main-color">
                    ##Seatselect## <i class="zmdi zmdi-account-box-phone zmdi-hc-fw"></i>
                </span>*}



                <div class="panel-default-change-Buyer-parent row">

                    {if $smarty.const.SOFTWARE_LANG === 'fa'}
                        <div class=" right col-lg-4 col-md-12">
                            <div class="detailBus--new">
                                <svg viewBox="0 0 24 24" width="1.5em" height="1.5em" fill="currentColor" class="align-top ml-2 shrink-0" data-v-4c79b6d3=""><path d="M12 1.5c5.799 0 10.5 4.701 10.5 10.5S17.799 22.5 12 22.5 1.5 17.799 1.5 12 6.201 1.5 12 1.5ZM12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18Zm0 6a.75.75 0 0 1 .745.663l.005.087v7.5a.75.75 0 0 1-1.495.087l-.005-.087v-7.5A.75.75 0 0 1 12 9Zm0-3a.75.75 0 0 1 .745.663l.005.087v.75a.75.75 0 0 1-1.495.087L11.25 7.5v-.75A.75.75 0 0 1 12 6Z"></path></svg>
                                <p>
                                     صندلی‌های موردنظر خود را انتخاب نمایید.
                                    <br>  صندلی‌ها با اولین کلیک انتخاب  و با  <br> کلیک
                                    بعدی از انتخاب خارج می‌شوند.
                                </p>
                            </div>
                            <div class="detailBus--new">
                                <svg viewBox="0 0 24 24" width="1.5em" height="1.5em" fill="currentColor" class="align-top ml-2 shrink-0" data-v-4c79b6d3=""><path d="M12 1.5c5.799 0 10.5 4.701 10.5 10.5S17.799 22.5 12 22.5 1.5 17.799 1.5 12 6.201 1.5 12 1.5ZM12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18Zm0 6a.75.75 0 0 1 .745.663l.005.087v7.5a.75.75 0 0 1-1.495.087l-.005-.087v-7.5A.75.75 0 0 1 12 9Zm0-3a.75.75 0 0 1 .745.663l.005.087v.75a.75.75 0 0 1-1.495.087L11.25 7.5v-.75A.75.75 0 0 1 12 6Z"></path></svg>
                                <p>
                                  بر اساس قانون انتخاب صندلی های <br>
                                    اول برای بانوان محدود شده است.
                                </p>
                            </div>
                        </div>
                    {else}
                        <div class=" right col-lg-4 col-md-12">
                        <span class="detailBus">
                            <i class="zmdi zmdi-check site-main-text-color"></i>##Loveseat##
                        </span>
                            <span class="detailBus">
                            <i class="zmdi zmdi-check site-main-text-color"></i>##Over1##
                        </span>
                            <span class="detailBus">
                            <i class="zmdi zmdi-check site-main-text-color"></i>##Changestatus##
                        </span>
                            <span class="detailBus"><i class="zmdi zmdi-check site-main-text-color"></i>##Womanmandatory## </span>
                            <span class="detailBus"><i class="zmdi zmdi-check site-main-text-color"></i>##Nextseat##</span>
                        </div>
                    {/if}

                    <div class="busChoose left col-lg-8 col-md-12">

                        <div class='border border-50 d-flex gap-10 justify-content-between p-3 rounded'>

                            <ul class="cabin d-flex flex-wrap w-100 px-2">

                                <li class="row0 itemRow  justify-content-between">


                                    {foreach key=key item=itemCh from=$result['seates']}
                                        {if $itemCh.column eq 1}
                                            <div class="colomn1 d-flex flex-wrap seat-item">
                                                <span class="row{$itemCh.row} type{$itemCh.status} seat_parent_number">
                                            <a class="chair_bus"
                                               {if $itemCh.chairNumber eq '-1'}style="opacity:0;"{/if}>
                                                <i class="align-items-center d-flex flex-wrap justify-content-center rounded seat_number">{$itemCh.chairNumber}</i>
                                                <input type="hidden" name="chairNumber{$itemCh.chairNumber}"
                                                       id="chairNumber{$itemCh.chairNumber}"
                                                       value="{$itemCh.chairNumber}">
                                            </a>
                                        </span>
                                            </div>
                                        {/if}
                                    {/foreach}
                                </li>

                                <li class="row1 itemRow  justify-content-between">
                                    {foreach key=key item=itemCh from=$result['seates']}
                                        {if $itemCh.column eq 2}
                                            <div class="colomn2 d-flex flex-wrap seat-item">
                                        <span class="row{$itemCh.row} type{$itemCh.status} seat_parent_number">
                                            <a class="chair_bus"
                                               {if $itemCh.chairNumber eq '-1'}style="opacity:0;"{/if}>
                                            <i class="align-items-center d-flex flex-wrap justify-content-center rounded seat_number">{$itemCh.chairNumber}</i>
                                            <input type="hidden" name="chairNumber{$itemCh.chairNumber}"
                                                   id="chairNumber{$itemCh.chairNumber}"
                                                   value="{$itemCh.chairNumber}">
                                            </a>
                                        </span>
                                            </div>
                                        {/if}
                                    {/foreach}
                                </li>

                                <li class="row2 itemRow  justify-content-between">
                                    {foreach key=key item=itemCh from=$result['seates']}

                                        {if $itemCh.column eq 3}
                                            <div class="colomn3 d-flex flex-wrap seat-item">
                                                <span class="row{$itemCh.row} type{$itemCh.status} seat_parent_number">
                                                    <a class="chair_bus"
                                                       {if $itemCh.chairNumber eq '-1'}style="opacity:0;"{/if}>
                                                    <i class="align-items-center d-flex flex-wrap justify-content-center rounded seat_number">{$itemCh.chairNumber}</i>
                                                    <input type="hidden" name="chairNumber{$itemCh.chairNumber}"
                                                           id="chairNumber{$itemCh.chairNumber}"
                                                           value="{$itemCh.chairNumber}">
                                                    </a>
                                                </span>
                                            </div>
                                        {/if}
                                    {/foreach}
                                </li>

                                <li class="row3 itemRow  justify-content-between">
                                    {foreach key=key item=itemCh from=$result['seates']}
                                        {if $itemCh.column eq 4}
                                            <div class="colomn4 d-flex flex-wrap seat-item">
                                        <span class="row{$itemCh.row} type{$itemCh.status} seat_parent_number">
                                            <a class="chair_bus"
                                               {if $itemCh.chairNumber eq '-1'}style="opacity:0;"{/if}>
                                            <i class="align-items-center d-flex flex-wrap justify-content-center rounded seat_number">{$itemCh.chairNumber}</i>
                                            <input type="hidden" name="chairNumber{$itemCh.chairNumber}"
                                                   id="chairNumber{$itemCh.chairNumber}"
                                                   value="{$itemCh.chairNumber}">
                                            </a>
                                        </span>
                                            </div>
                                        {/if}
                                    {/foreach}
                                </li>

                                <li class="row4 itemRow  justify-content-between">
                                    {foreach key=key item=itemCh from=$result['seates']}
                                        {if $itemCh.column eq 5}
                                            <div class="colomn5 d-flex flex-wrap seat-item">
                                        <span class="row{$itemCh.row} type{$itemCh.status} seat_parent_number">
                                            <a class="chair_bus"
                                               {if $itemCh.chairNumber eq '-1'}style="opacity:0;"{/if}>
                                            <i class="align-items-center d-flex flex-wrap justify-content-center rounded seat_number">{$itemCh.chairNumber}</i>
                                            <input type="hidden" name="chairNumber{$itemCh.chairNumber}"
                                                   id="chairNumber{$itemCh.chairNumber}"
                                                   value="{$itemCh.chairNumber}">
                                            </a>
                                        </span>
                                            </div>
                                        {/if}
                                    {/foreach}
                                </li>

                            </ul>
                            <span class='d-flex flex-wrap border-left '></span>
                            <div class='parent-car-steering-wheel'>
                                <span class="text-vertical">جلوی وسیله نقلیه</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024" version="1.1"><path d="M370.513 874.855c-48.815-20.02-92.685-50.082-129.215-87.716-69.276-71.384-112.122-170.011-112.122-278.945 0-108.918 42.846-207.544 112.122-278.929 69.836-71.953 170.267-107.93 270.706-107.93 100.423 0 200.861 35.977 270.688 107.93 69.276 71.384 112.131 170.01 112.131 278.929 0 108.934-42.855 207.561-112.131 278.945-36.52 37.633-80.399 67.694-129.205 87.716-45.187 18.524-93.334 27.811-141.483 27.811-48.166 0-96.298-9.288-141.491-27.811l0 0zM512.005 199.998c-80.213 0-160.425 28.732-216.19 86.211-33.202 34.203-58.802 76.253-73.97 123.216-4.189 15.772 1.398 23.218 16.742 22.364 50.317-1.991 158.745-3.58 181.017-4.735-19.13 22.356-30.724 51.706-30.724 83.843 0 35.031 13.779 66.757 36.06 89.716 7.949 8.2 16.994 15.277 26.875 20.983 18.62 10.778 39.397 16.165 60.19 16.174 20.785-0.008 41.563-5.396 60.181-16.174 9.881-5.707 18.919-12.783 26.875-20.983 22.281-22.959 36.06-54.684 36.06-89.716 0-32.136-11.603-61.488-30.716-83.843 22.263 1.155 130.691 2.744 181.001 4.735 15.345 0.853 20.94-6.593 16.742-22.364-15.159-46.962-40.762-89.012-73.971-123.216-55.764-57.48-135.968-86.211-216.174-86.211l0 0zM581.084 439.837c-35.645-36.729-102.534-36.729-138.178 0-17.676 18.215-28.613 43.389-28.613 71.185 0 27.811 10.937 52.978 28.613 71.199 6.813 7.011 14.615 13.002 23.19 17.704 28.483 15.645 63.324 15.645 91.808 0 8.566-4.702 16.377-10.694 23.182-17.704 17.684-18.222 28.62-43.389 28.62-71.199 0.001-27.794-10.936-52.969-28.62-71.185l0 0zM529.738 548.203c13.365-6.761 22.564-20.933 22.564-37.307 0-17.353-10.337-32.221-25.008-38.428-9.71-4.108-20.875-4.108-30.586 0-14.672 6.208-25.008 21.076-25.008 38.428 0 16.373 9.191 30.546 22.555 37.307 11.074 5.588 24.423 5.588 35.483 0l0 0zM575.449 817.192c58.964-12.818 111.669-43.147 152.728-85.459 42.896-44.2 73.092-101.47 84.509-165.509 4.109-17.369-3.143-22.69-15.848-22.272-25.626-0.56-51.261-0.452-75.691 4.293-87.041 16.909-118.171 60.19-133.574 159.829-5.595 36.193-9.151 78.547-12.123 109.118l0 0zM448.541 817.192c-2.963-30.572-6.528-72.925-12.114-109.118-15.404-99.638-46.54-142.919-133.583-159.829-24.423-4.745-50.065-4.853-75.691-4.293-12.699-0.418-19.957 4.902-15.841 22.272 11.408 64.039 41.614 121.309 84.501 165.509 41.068 42.312 93.764 72.64 152.728 85.459z"/></svg>
                            </div>
                        </div>


                        <div class="col-xs-12 no-pad">
                            <div class="bus-component__seat-status row">
                                <div class="color-rang">
                                    <div class="seat-status__passenger-selection"></div>
                                    <span class="set-text-position">##Yourselect##</span></div>
                                <div class="color-rang">
                                    <div class="seat-status__reserve-disabled"></div>
                                    <span>##Ineligible##</span></div>
                                <div class="color-rang">
                                    <div class="seat-status__reserve-by-male"></div>
                                    <span class="set-text-position">##manselected##</span></div>
                                <div class="color-rang">
                                    <div class="seat-status__reserve-by-female"></div>
                                    <span class="set-text-position">##Womanselected##</span></div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="clear"></div>

{*                <div id="errorForFemale" class="messageInfo1"></div>*}
                <div id="messageChairNumberReserve" class="messageInfo1"></div>

            </div>

            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer first_1 first">
                <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                ##TravelerGuard## <span class='chair-number mr-1'></span>
<input type="hidden" class='chair-number_aaa' name="aaa" value="24">
                         {if $objSession->IsLogin()}
                             <span class="s-u-last-passenger-btn "
                                   onclick="setHidenFildnumberRow('1')">
                                         <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i> ##Passengerbook##
                                     </span>
                         {/if}
            </span>
               {* <span class="s-u-last-p-pasenger s-u-last-p-pasenger-change site-bg-main-color">
                    ##TravelerGuard## <i class="zmdi zmdi-account-box-phone zmdi-hc-fw"></i>
                </span>*}

                <div class="panel-default-change-Buyer">


                        <div class="panel-heading-change d-none">
                            <i class="room-kind-bed"> ##Adultagegroup## (+11) </i>
                            <span class="kindOfPasenger">
                                    <label class="control--checkbox">
                                        <span>##Iranian##</span>
                                        <input type="radio" name="passengerNationality1"
                                               id="passengerNationality1"
                                               value="0" class="nationalityChange" checked="checked">
                                        <div class="checkbox ">
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
                                        <input type="radio" name="passengerNationality1"
                                               id="passengerNationality1"
                                               value="1" class="nationalityChange">
                                        <div class="checkbox ">
                                            <div class="filler"></div>
                                            <svg fill="#000000"  viewBox="0 0 30 30" >
                                            <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                                           </svg>
                                        </div>
                                    </label>
                                </span>

                        </div>

                        <div class="panel-body-change">

                            <div class="s-u-passenger-item  s-u-passenger-item-change">
                                <select id="gender1" name="gender1">
                                    <option value="" disabled="" selected="selected">##Sex##</option>
                                    <option value="Male">##Sir##</option>
                                    <option value="Female">##Lady##</option>
                                </select>
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <input id="nameFa1" type="text" placeholder="##Namepersion##" name="nameFa1"
                                       onkeypress=" return persianLetters(event, 'nameFa1')" class="justpersian">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <input id="familyFa1" type="text" placeholder="##Familypersion##"
                                       name="familyFa1"
                                       onkeypress=" return persianLetters(event, 'familyFa1')" class="justpersian">
                            </div>
{*                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change">*}
{*                                <input id="nameEn1" type="text" placeholder="##Nameenglish##" name="nameEn1"*}
{*                                       onkeypress="return isAlfabetKeyFields(event, 'nameEn1')" class="">*}
{*                            </div>*}
{*                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change">*}
{*                                <input id="familyEn1" type="text" placeholder="##Familyenglish##" name="familyEn1"*}
{*                                       onkeypress="return isAlfabetKeyFields(event, 'familyEn1')" class="">*}
{*                            </div>*}
                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input id="birthday1" type="text" placeholder="##shamsihappybirthday##" name="birthday1"
                                       class="shamsiDriverBirthdayCalendar pwt-datepicker-input-element"
                                       readonly="readonly">
                            </div>
                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change noneIranian d-none">
                                <input id="birthdayEn1" type="text" placeholder="##miladihappybirthday##"
                                       name="birthdayEn1" readonly="readonly">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input id="NationalCode1" type="tel" placeholder="##Nationalnumber##"
                                       name="NationalCode1"
                                       maxlength="10"
                                       class="UniqNationalCode">
                            </div>


                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change select-meliat noneIranian d-none">
                                <select name="passportCountry1" id="passportCountry1"
                                        class="select2">
                                    <option value="">##Countryissuingpassport##</option>
                                    {foreach $objFunctions->CountryCodes() as $Country}
                                        <option value="{$Country['code']}">{$Country['titleFa']}</option>
                                    {/foreach}
                                </select>
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian d-none">
                                <input id="passportNumber1" type="text" placeholder="##Numpassport##"
                                       name="passportNumber1" class="UniqPassportNumber">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian d-none">
                                <input id="passportExpire1"
                                       class="gregorianFromTodayCalendar pwt-datepicker-input-element"
                                       type="text" placeholder="##Passportexpirydate##" name="passportExpire1">
                            </div>


                        </div>

                </div>
                <div id="errorMessagePassenger" class="messageInfo"></div>
                <div class="clear"></div>

            </div>

            <div class='bus-passenger'></div>
            <div class="clear"></div>

            {if not $objSession->IsLogin()}
                <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer first">
                    <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                        ##InformationSaler##
                    </span>
               {* <span class="s-u-last-p-pasenger s-u-last-p-pasenger-change site-bg-main-color">
                    ##InformationSaler## <i class="zmdi zmdi-account-box-phone zmdi-hc-fw"></i>
                </span>*}
                    <input type="hidden" name="UsageNotLogin" value="yes" id="UsageNotLogin">
                    <div class="clear"></div>
                    <div class="panel-default-change-Buyer">
                        <div class="s-u-passenger-items s-u-passenger-item-change">
                            <input id="Mobile" type="text" placeholder="##Phonenumber## " name="Mobile" class="dir-ltr">
                        </div>
                        <div class="s-u-passenger-items no-after-before s-u-passenger-item-change">
                            <input id="Telephone" type="text" placeholder="##Phone##" name="Telephone" class="dir-ltr">
                        </div>
                        <div class="s-u-passenger-items no-after-before s-u-passenger-item-change padl0">
                            <input id="Email" type="email" placeholder="##Email##" name="Email" class="dir-ltr">
                        </div>
                        <div id="messageInfo"></div>
                    </div>
                    <div class="clear"></div>
                </div>
            {/if}

            {if $objSession->IsLogin()}
                <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer first">
                    <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">

                         ##Travelerprofile##
                    </span>
             {*   <span class="s-u-last-p-pasenger s-u-last-p-pasenger-change site-bg-main-color">
                    ##InformationSaler## <i class="zmdi zmdi-account-box-phone zmdi-hc-fw"></i>
                </span>*}
                    <input type="hidden" name="UsageNotLogin" value="no" id="UsageNotLogin">
                    <div class="clear"></div>
                    <div class="panel-default-change-Buyer">

                        <div class="s-u-passenger-item s-u-passenger-item-change ">
                            <input id="email1" type="email" placeholder="##Email##" name="email1" value="{$InfoMember.email}">
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change">
                            <input id="mobilePhone1" type="tel" placeholder="##Mobile##" name="mobilePhone1"
                                   maxlength="11" value="{$InfoMember.mobile}">
                        </div>

                        <div id="messageInfo"></div>
                    </div>
                    <div class="clear"></div>
                </div>
            {/if}


            <div class="btns_factors_n">
                <div class="passengersDetailLocal_next">
                    <a href="" onclick="return false"
                       class="f-loader-check loaderpassengers" id="loader_check" style="display:none"></a>

                    <button type='button'
                            id="send_data"
                            onclick="checkBusLocal('{$smarty.now}',$(this))"
                            class='btn s-u-submit-passenger s-u-select-flight-change s-u-submit-passenger-Buyer site-bg-main-color'>
                        ##Nextstep## (##Invoice##)
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>
            </div>
        </form>

    </div>
{/if}
<div class="lazy-loader-parent lazy_loader_flight">
    <div class="modal-content-flight">
        <div class="modal-body-flight">
            <div class="img_timeoute_svg">

                <svg id="Capa_1" enable-background="new 0 0 512 512" viewBox="0 0 512 512"
                     xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <circle cx="211.748" cy="217.219" fill="#365e7d" r="211.748"/>
                        <path d="m423.496 217.219c0-116.945-94.803-211.748-211.748-211.748-4.761 0-9.482.173-14.165.483 105.408 6.964 189.73 91.05 197.055 196.357.498 7.155-5.367 13.072-12.538 12.919-1.099-.023-2.201-.035-3.306-.035-87.332 0-158.129 70.797-158.129 158.129 0 8.201.627 16.255 1.833 24.118 2.384 15.542-8.906 29.961-24.594 31.022-.107.007-.214.014-.321.021 4.683.309 9.404.483 14.165.483 117.636-.001 211.748-95.585 211.748-211.749z"
                              fill="#2b4d66"/>
                        <circle cx="211.748" cy="217.219" fill="#f4fbff" r="162.544"/>
                        <path d="m374.292 217.219c0-89.77-72.773-162.544-162.544-162.544-4.404 0-8.765.181-13.08.525 83.965 6.687 149.953 77.174 149.461 162.972-.003.004-.006.007-.009.011-68.587 13.484-119.741 70.667-126.655 138.902-1.189 11.73-10.375 21.111-22.124 22.097-.224.019-.448.037-.673.055 94.649 7.542 175.624-67.027 175.624-162.018z"
                              fill="#daf1f4"/>
                        <g>
                            <g>
                                <path d="m211.748 104.963c-4.268 0-7.726-3.459-7.726-7.726v-10.922c0-4.268 3.459-7.726 7.726-7.726s7.726 3.459 7.726 7.726v10.922c0 4.267-3.458 7.726-7.726 7.726z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m296.588 140.105c-1.978 0-3.955-.755-5.464-2.264-3.017-3.017-3.017-7.909.001-10.927l7.723-7.722c3.017-3.017 7.909-3.016 10.927.001 3.017 3.017 3.017 7.909-.001 10.927l-7.723 7.722c-1.508 1.508-3.486 2.263-5.463 2.263z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m342.653 224.945h-10.923c-4.268 0-7.726-3.459-7.726-7.726 0-4.268 3.459-7.726 7.726-7.726h10.923c4.268 0 7.726 3.459 7.726 7.726s-3.459 7.726-7.726 7.726z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m214.925 359.027c-4.268 0-7.726-3.459-7.726-7.726v-10.923c0-4.268 3.459-7.726 7.726-7.726s7.726 3.459 7.726 7.726v10.923c.001 4.268-3.458 7.726-7.726 7.726z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m119.185 317.508c-1.977 0-3.955-.755-5.464-2.263-3.017-3.018-3.017-7.909 0-10.928l7.723-7.723c3.018-3.016 7.909-3.016 10.928 0 3.017 3.018 3.017 7.909 0 10.928l-7.723 7.723c-1.51 1.509-3.487 2.263-5.464 2.263z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m91.766 224.945h-10.922c-4.268 0-7.726-3.459-7.726-7.726 0-4.268 3.459-7.726 7.726-7.726h10.923c4.268 0 7.726 3.459 7.726 7.726s-3.459 7.726-7.727 7.726z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m126.908 140.105c-1.977 0-3.955-.755-5.463-2.263l-7.723-7.722c-3.018-3.017-3.018-7.909-.001-10.927 3.018-3.018 7.91-3.017 10.927-.001l7.723 7.722c3.018 3.017 3.018 7.909.001 10.927-1.509 1.509-3.487 2.264-5.464 2.264z"
                                      fill="#365e7d"/>
                            </g>
                        </g>
                        <g>
                            <path d="m211.748 228.123h-37.545c-4.268 0-7.726-3.459-7.726-7.726s3.459-7.726 7.726-7.726h29.819v-65.392c0-4.268 3.459-7.726 7.726-7.726s7.726 3.459 7.726 7.726v73.119c0 4.266-3.458 7.725-7.726 7.725z"
                                  fill="#2b4d66"/>
                        </g>
                        <circle cx="378.794" cy="373.323" fill="#dd636e" r="133.206"/>
                        <path d="m378.794 240.117c-5.186 0-10.3.307-15.331.884 66.345 7.604 117.875 63.941 117.875 132.322s-51.53 124.718-117.875 132.322c5.032.577 10.145.884 15.331.884 73.568 0 133.206-59.638 133.206-133.206 0-73.567-59.638-133.206-133.206-133.206z"
                              fill="#da4a54"/>
                        <path d="m400.647 373.323 39.246-39.246c6.035-6.034 6.035-15.819 0-21.853-6.034-6.034-15.819-6.034-21.853 0l-39.246 39.246-39.246-39.246c-6.034-6.036-15.819-6.034-21.853 0-6.035 6.034-6.035 15.819 0 21.853l39.246 39.246-39.246 39.246c-6.035 6.034-6.035 15.819 0 21.853 3.017 3.017 6.972 4.526 10.927 4.526s7.909-1.509 10.927-4.526l39.246-39.246 39.246 39.246c3.017 3.018 6.972 4.526 10.927 4.526s7.909-1.509 10.927-4.526c6.035-6.034 6.035-15.819 0-21.853z"
                              fill="#f4fbff"/>
                        <g>
                            <path d="m400.647 373.323 39.246-39.246c6.035-6.034 6.035-15.819 0-21.853-5.885-5.884-15.327-6.013-21.388-.42.154.142.315.271.465.42 6.035 6.034 6.035 15.819 0 21.853l-32.777 32.777c-3.573 3.573-3.573 9.366 0 12.939l32.777 32.777c6.035 6.034 6.035 15.819 0 21.853-.149.15-.311.279-.465.421 2.954 2.726 6.703 4.106 10.462 4.106 3.955 0 7.909-1.509 10.927-4.526 6.035-6.034 6.035-15.819 0-21.853z"
                                  fill="#daf1f4"/>
                        </g>
                    </g>
                </svg>
            </div>
            <span class="timeout-modal__title site-main-text-color">##Endofsearchtime##!</span>

            <p class="timeout-modal__flight">
                به منظور بروزرسانی قیمت ها ، لطفا جستجوی خود را از ابتدا انجام دهید.
            </p>
            <button onclick="BackToHome('{$objDetail->reSearchAddress}'); return false" type="button" class="loading_on_click btn btn-research site-bg-main-color">
                ##Repeatsearch##
            </button>
            <a class="btn btn_back_home site-main-text-color" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}">##Returntohome##</a>

        </div>
    </div>
</div>
{literal}
    <script type="text/javascript">
        $(document).ready(function () {
            let table = $('#passengers').DataTable();
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

    <script src="assets/js/classie.js"></script>
    <script src="assets/js/sidebarEffects.js"></script>
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
   /* $('.counter').on('counterStop', function () {
        $.confirm({
            theme: 'supervan',// 'material', 'bootstrap'
            title: '##Update##',
            icon: 'fa fa-clock',
            content: '##Reserveend##',
            rtl: true,
            closeIcon: true,
            type: 'orange',
            buttons: {
                confirm: {
                    text: '##Approve##',
                    btnClass: 'btn-green',
                    action: function () {
                        location.href = '{/literal}http://{$smarty.const.CLIENT_MAIN_DOMAIN}{literal}';
                    }
                },
                cancel: {
                    text: '##Optout##',
                    btnClass: 'btn-orange',
                    action: function () {
                        location.href = '{/literal}http://{$smarty.const.CLIENT_MAIN_DOMAIN}{literal}';
                    }
                }
            }
        });
    });*/

    $(document).ready(function () {
      $('.itemRow').each(function(){

        if(!$(this).find('span').length){
          $(this).addClass('w-100')
        }
      })
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

    });
</script>
{/literal}
