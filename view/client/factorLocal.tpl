<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>
{load_presentation_object filename="passengersDetailLocal" assign="objDetail"}
{load_presentation_object filename="factorLocal" assign="objFactor"}
{load_presentation_object filename="members" assign="objMember"}
{$objMember->get()}
{assign var="InfoCounter" value=$objFunctions->infoCounterType($objMember->list['fk_counter_type_id'])}
{assign var="FlightSelected" value=$objFactor->getSpecific($objFactor->factor_number)}

{assign var="PriceTotal" value=$objFunctions->CalculateDiscount($objFactor->factor_number)}

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
                به منظور بروزرسانی قیمت ها و پرواز ها، لطفا جستجوی خود را از ابتدا انجام دهید.
            </p>
            <button onclick="BackToHome('{$objDetail->reSearchAddress}'); return false" type="button" class="loading_on_click btn btn-research site-bg-main-color">
                ##Repeatsearch##
            </button>
            <a class="btn btn_back_home site-main-text-color" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}">##Returntohome##</a>

        </div>
    </div>
</div>
<div class="">
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


<div id="flight_factorLocal" class="s-u-content-result ">
    <div id="lightboxContainer" class="lightboxContainerOpacity "></div>

    {assign var="existChange" value=$objFunctions->checkExistChangePrice($FlightSelected,$objDetail->arrayTemp)}



    {if $existChange eq  true}
    <div class="Clr"></div>
    <div class=" s-u-passenger-wrapper-change s-u-passenger-wrapper-change_nn  ">
        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change color-alert  ">
            <i class="zmdi zmdi-alert-circle  zmdi-hc-fw"></i>
         ##Pricechange##
        </span>
        <div class="factorl_nn_parent">
        {foreach $FlightSelected as $direction=>$item}
            <div class="factorl_nn">
                <ul class="s-u-last-p-bozorgsal_n">

                    {foreach $item as $chackChange}
                        {if $chackChange['passenger_age'] eq 'Adt'}
                            {assign var='messageChangePrice' value=$objFunctions->checkIncreasePrice($chackChange['adt_price'],$objDetail->CheckAdtPrice[$direction],$chackChange['passenger_age'],$chackChange['courrency_code'],$chackChange['flight_type'],$direction)}
                            {if $messageChangePrice neq ''}
                                <li>
                                    <div class="s-u-result-wrapper">
                        <span class="s-u-result-item-change ">
                                {$messageChangePrice}
                        </span>
                                    </div>
                                </li>
                            {/if}
                        {elseif $chackChange['passenger_age'] eq 'Chd'}
                            {assign var='messageChangePrice' value=$objFunctions->checkIncreasePrice($chackChange['chd_price'],$objDetail->CheckChdPrice[$direction],$chackChange['passenger_age'],$chackChange['courrency_code'],$chackChange['flight_type'],$direction)}
                            {if $messageChangePrice neq ''}
                                <li>
                                    <div class="s-u-result-wrapper">
                        <span class="s-u-result-item-change direcR iranR txt14 txtRed">
                                {$messageChangePrice}
                        </span>
                                    </div>
                                </li>
                            {/if}
                        {elseif $chackChange['passenger_age'] eq 'Inf'}
                            {assign var='messageChangePrice' value=$objFunctions->checkIncreasePrice($chackChange['inf_price'],$objDetail->CheckInfPrice[$direction],$chackChange['passenger_age'],$chackChange['courrency_code'],$chackChange['flight_type'],$direction)}
                            {if $messageChangePrice neq ''}
                                <li>
                                    <div class="s-u-result-wrapper">
                        <span class="s-u-result-item-change direcR iranR txt14 txtRed">
                             {$messageChangePrice}
                                     </span>
                                    </div>
                                </li>
                            {/if}
                        {/if}
                    {/foreach}


                </ul>
            </div>
        {/foreach}
        </div>
    </div>
    {/if}



    {if $objFactor->Source_ID['dept'] eq '8' && $FlightSelected['dept'][0]['supplier_address'] neq '' && ($FlightSelected['dept'][0]['origin_airport_iata'] == 'IST'|| $FlightSelected['dept'][0]['desti_airport_iata'] == 'IST')}
        <div class=" s-u-passenger-wrapper-change s-u-passenger-wrapper-change_nn  ">
        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change color-alert  " style="color:#ee384e">
            <i class="zmdi zmdi-alert-circle mart10  zmdi-hc-fw"></i>
         ##Note##
        </span>
            <div class="factorl_nn_parent">

                    <div class="factorl_nn">
                        <ul class="s-u-last-p-bozorgsal_n">

                            <li>
                                <div class="s-u-result-wrapper">
                                    <span class="s-u-result-item-change  iranR txt14 txtRed" style="color:#ee384e">
                                            {$FlightSelected['dept'][0]['supplier_address']}
                                    </span>
                                </div>
                            </li>


                        </ul>
                    </div>

            </div>
        </div>
    {/if}
    <div class="Clr"></div>
    <div class="s-u-passenger-wrapper-change s-u-passenger-wrapper ">

        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color site-border-main-color">
            <i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart10"></i> ##Invoice##
        </span>

        <div class="s-u-result-wrapper">
            <span>

            </span>
            <ul>
                {foreach $FlightSelected as $direction=>$item}
                    {assign var="FlightisInternal" value=$item[0]['IsInternal']}
                    <li class="s-u-result-item s-u-result-item-change blit-flight-passenger2 wow fadeInDown">
                        <div class="blite-rafto-bargasht-text raft-blit"><span>##Onewayticket##</span></div>
                        {if $smarty.post.ZoneFlight eq 'Local'}
                            <div class="s-u-result-item-div s-u-result-item-div-change col-xs-3 col-sm-2 s-u-result-item-div-width">
                                <div class="s-u-result-item-div-logo s-u-result-item-div-logo-change">
                                    <img src="{$objFunctions->getAirlinePhoto($item[0]['airline_iata'])}">
                                </div>

                                <div class="s-u-result-item-div s-u-result-content-item-div-change">
                                    <span>##FlightNumber## : {$item[0]['flight_number']}</span>
                                </div>
                            </div>
                            <div class="s-u-result-item-wrapper s-u-result-item-wrapper-change col-xs-9 col-sm-10">

                                <div class="details-wrapper-change">

                                    <div class="s-u-result-raft first-row-change">
                                        <div class="s-u-result-item-div-p right-Cell-change custom-width-100">

                                            <div class="s-u-result-item-div s-u-result-items-div-change ">
{*                                                <span class="iranB">{$item[0]['desti_airport_iata']}</span>*}
                                                <span class="iranB">
                                                     {if $smarty.post.ZoneFlight eq 'Local'}
                                                         {assign var="OriginCityNameByLanguage" value=$objFunctions->CityInternal($item[0]['origin_airport_iata'])}
                                                     {else}
                                                         {assign var="OriginCityNameByLanguage" value=$objFunctions->CityForeign($objFunctions->mapIataCode($item[0]['origin_airport_iata']))}
                                                     {/if}
                                                    {$OriginCityNameByLanguage[$objFunctions->changeFieldNameByLanguage('Departure_City')]}
                                                </span>
                                                <span class="s-u-result-item-date-format s-u-result-item-date-format-change font15">
                                                    {$objFunctions->ConvertDateByLanguage($smarty.const.SOFTWARE_LANG,$item[0]['date_flight'],'/','jalali',true)}</span>
                                                <span class="s-u-bozorg "> {$objFunctions->format_hour($item[0]['time_flight'])}</span>
                                            </div>

                                            <div class="s-u-result-item-div s-u-result-items-div-change ">
{*                                                <span class="iranB">{$item[0]['desti_city']}</span>*}
                                                <span class="iranB">
                                                     {if $smarty.post.ZoneFlight eq 'Local'}
                                                         {assign var="DestinationCityNameByLanguage" value=$objFunctions->CityInternal($item[0]['desti_airport_iata'])}
                                                     {else}
                                                         {assign var="DestinationCityNameByLanguage" value=$objFunctions->CityForeign($objFunctions->mapIataCode($item[0]['desti_airport_iata']))}
                                                     {/if}
                                                    {$DestinationCityNameByLanguage[$objFunctions->changeFieldNameByLanguage('Departure_City')]}
                                                </span>
                                                <span class="s-u-result-item-date-format s-u-result-item-date-format-change font15">{$objFunctions->ConvertDateByLanguage($smarty.const.SOFTWARE_LANG,$objFunctions->Date_arrival($item[0]['origin_airport_iata'], $item[0]['desti_airport_iata'], $item[0]['time_flight'],$item[0]['date_flight']),'/')}</span>
                                                <span class="s-u-bozorg "> {$objDetail->format_hour_arrival($item[0]['origin_airport_iata'], $item[0]['desti_airport_iata'], $item[0]['time_flight'])}</span>
                                                <!--<span class="s-u-result-item-date-format miladi">{$objDetail->DeptDateJalali[$direction]}</span>-->
                                            </div>

                                            <div class="border-0 s-u-result-item-div s-u-result-items-div-change s-u-result-item-div-last ">
                                                {if $objDetail->AircraftCode[$direction] neq ''}<span>##Typeairline## : {$objDetail->AircraftCode[$direction]}</span>{/if}
                                                <span class="s-u-bozorg s-u-bozorg-change font12">
{*                                                    <span>  ##Flighttime## :</span>*}
{*                                                        <i class="font-chanhe">*}
{*                                                        {$objDetail->LongTimeFlightMinutes($objDetail->OriginAirportIata[$direction],*}
{*                                                        $objDetail->DestiAirportIata[$direction])}:*}
{*                                                    </i>*}
{*                                                    <i class="font-chanhe">*}
{*                                                        {$objDetail->LongTimeFlightHours($objDetail->OriginAirportIata[$direction],*}
{*                                                        $objDetail->DestiAirportIata[$direction])}*}
{*                                                    </i>*}
                                                    <span class="displayib-change d-block flight-class--new"> {if $item[0]['flight_type'] eq 'charter'}##CharterType##{else}##SystemType##{/if}</span>
                                                </span>
                                            </div>

                                        </div>
                                        <div class="s-u-result-item-div  s-u-result-items-div-change right-Cell-change fltr padb5 displayB400 ">
                                            <span class="iranB">{$item[0]['origin_city']}</span>
                                            <span class="iranB">{$item[0]['desti_city']}</span>

                                            <span class="s-u-result-item-date-format s-u-result-item-date-format-change font15">{$objFunctions->Date_arrival($item[0]['origin_airport_iata'], $item[0]['desti_airport_iata'], $item[0]['time_flight'], $item[0]['date_flight'])}</span>

                                            <span class="s-u-bozorg s-u-bozorg-change  txt14 yekanB">{$objDetail->format_hour($item[0]['time_flight'])}</span>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        {else}

                            {assign var="detailTicketForeign" value=$objFactor->detailRoutesOfBook($objFactor->RequestNumber[$direction],$direction)}

                            {if $direction eq 'multi_destination'}
                                <div class="international-available-box  foreign">
                                    <div class="international-available-item ">
                                        <div class="international-available-info">
                                            <div class="international-available-item-right-Cell w-100 no-before-after">
                                                {foreach $objDetail->RoutesTicket[$direction] as $key=>$route}
                                                    {assign var="RouteDepartureInfo" value=$objFunctions->NameCityForeign($objFunctions->mapIataCode($route['OriginAirportIata']))}
                                                    {assign var="RouteArrivalInfo" value=$objFunctions->NameCityForeign($objFunctions->mapIataCode($route['DestiAirportIata']))}
                                                    <div class=" international-available-airlines  ">

                                                        <div class="international-available-airlines-logo">
                                                            <img src="{$objFunctions->getAirlinePhoto($route['Airline_IATA'])}"
                                                                 alt="{$route['Airline_IATA']}"
                                                                 title="{$route['Airline_IATA']}">
                                                        </div>
                                                        <div class="international-available-airlines-log-info">

                                                            {* <span class="open txt13 disN740">
                                                             {if $objDetail->ArrayDeptForeign|@count gt '1'}##MultiAirline##{else}{$objFunctions->AirlineName($objDetail->RoutesTicket[$direction][0]['Airline_IATA'])}{/if}</span>*}
                                                        </div>

                                                    </div>

                                                    <div class="international-available-airlines-info ">
                                                        <div class="airlines-info txtLeft origin-city">

                                                            <span class="open city-name-flight">
                                                                {assign var="OriginCityNameByLanguage" value=$objFunctions->CityForeign($objFunctions->mapIataCode($route['OriginAirportIata']))}
                                                                {$OriginCityNameByLanguage[$objFunctions->changeFieldNameByLanguage('DepartureCity')]}
                                                        </span>
                                                            {assign var="DepartureInfo" value=$objFunctions->NameCityForeign($objFunctions->mapIataCode($route['OriginAirportIata']))}
                                                            <span class="openB airport-name-flight">{$DepartureInfo[$AirportLangName]}</span>

                                                            <div class="date-time">
                                                                <span class="time-flight">{$route['Time']|substr:0:5 }</span>
                                                            </div>


                                                        </div>

                                                        <div class="airlines-info">
                                                            <div class="airlines-info-inner">{*11*}
                                                                <div class="airline-line">
                                                                    <div class="loc-icon">
                                                                        <svg version="1.1" class="site-main-text-color"
                                                                             id="Layer_1"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                             x="0px" y="0px" width="32px"
                                                                             viewBox="0 0 512 512"
                                                                             style="enable-background:new 0 0 512 512;"
                                                                             xml:space="preserve">
																<g>
                                                                    <g>
                                                                        <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035
																			c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719
																			c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"/>
                                                                    </g>
                                                                </g>
																</svg>
                                                                    </div>

                                                                    <div class="plane-icon">
                                                                        <svg version="1.1" id="Capa_1"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                             x="0px" y="0px"
                                                                             width="32px" viewBox="0 0 512 512"
                                                                             enable-background="new 0 0 512 512"
                                                                             xml:space="preserve">
																<path d="M445.355,67.036l-0.391-0.392c-19.986-19.006-59.898,14.749-59.898,14.749l-72.463,57.049l-76.285-13.52
																	c11.005-15.953,14.32-31.79,6.983-39.127c-9.503-9.503-33.263-1.15-53.068,18.655c-3.464,3.464-6.568,7.049-9.297,10.657
																	l-58.574-10.381L83.346,137.97l159.044,72.979L140.427,334.152l-63.505-11.906l-16.083,16.06L173.696,451.16l16.058-16.082
																	l-11.906-63.506l123.204-101.963l72.979,159.043l33.244-39.016l-10.381-58.574c3.609-2.729,7.193-5.832,10.658-9.297
																	c19.805-19.805,28.158-43.564,18.656-53.066c-7.339-7.338-23.177-4.022-39.13,6.982l-13.52-76.284l57.049-72.464
																	C430.607,126.934,464.363,87.021,445.355,67.036z"/>
																</svg>

                                                                    </div>

                                                                    <div class="loc-icon-destination">
                                                                        <svg version="1.1" class="site-main-text-color"
                                                                             id="Layer_1"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                             x="0px" y="0px" width="32px"
                                                                             viewBox="0 0 512 512"
                                                                             style="enable-background:new 0 0 512 512;"
                                                                             xml:space="preserve">
																<g>
                                                                    <g>
                                                                        <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035
																			c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719
																			c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"/>
                                                                    </g>
                                                                </g>
																</svg>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="date-time">
                                                                  <span class="date-flight">
                                                                       {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                                                           <p class="farsi-date">{$route['Date']}</p>
                                                                       {/if}

                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="airlines-info txtRight destination-city">
                                                            <span class="open city-name-flight">
                                                                {assign var="DestCityNameByLanguage" value=$objFunctions->CityForeign($objFunctions->mapIataCode($route['DestiAirportIata']))}
                                                                {$DestCityNameByLanguage[$objFunctions->changeFieldNameByLanguage('DepartureCity')]}
                                                            </span>
                                                            {assign var="ArrivalInfo" value=$objFunctions->NameCityForeign($objFunctions->mapIataCode($objDetail->RoutesTicket[$direction][$route['DestiAirportIata']]))}
                                                            <span class="openB airport-name-flight">{$ArrivalInfo[$AirportLangName]}</span>
                                                            <div class="date-time">
                                                                <span class="date-flight">
                                                                     {if $smarty.const.SOFTWARE_LANG neq 'fa'}
                                                                         <p class="foreign-date float-right">{$objDetail->dateForeignMiladiArrival[$direction]} </p>
                                                                     {/if}
                                                                </span>
                                                                <span class="time-flight">
                                                                    {$route['ArrivalTime']|substr:0:5}
                                                                </span>


                                                            </div>

                                                        </div>

                                                    </div>
                                                {/foreach}


                                            </div>

                                        </div>
                                    </div>
                                </div>
                            {elseif $smarty.post.ZoneFlight eq 'TestParto'}
                                <div class="international-available-box  foreign">

                                    <div class="international-available-item ">
                                        <div class="international-available-info">
                                            <div class="international-available-item-right-Cell w-100 no-before-after">

                                                {if $objDetail->ArrayDeptForeign neq ''}
                                                    <div class=" international-available-airlines  ">

                                                        <div class="international-available-airlines-logo">
                                                            <img src="{$objFunctions->getAirlinePhoto($objDetail->ArrayDeptForeign[0]['Airline_IATA'])}"
                                                                 alt="{$objDetail->ArrayDeptForeign[0]['Airline_IATA']}"
                                                                 title="{$objDetail->ArrayDeptForeign[0]['Airline_IATA']}">
                                                        </div>
                                                        <div class="international-available-airlines-log-info">

                                                    <span class="open txt13 disN740">
                                                    {if $objDetail->ArrayDeptForeign|@count gt '1'}##MultiAirline##{else}{$objFunctions->AirlineName($objDetail->RoutesTicket[$direction][0]['Airline_IATA'])}{/if}</span>
                                                        </div>
                                                    </div>
                                                    <div class="international-available-airlines-info ">
                                                        <div class="airlines-info txtLeft origin-city">

                                                            <span class="open city-name-flight">

                                                                {assign var="OriginCityNameByLanguage" value=$objFunctions->CityForeign($objDetail->ArrayDeptForeign[0]['OriginAirportIata'])}



                                                                {$OriginCityNameByLanguage[$objFunctions->changeFieldNameByLanguage('DepartureCity')]}
                                                            </span>

                                                            {*                                                            <span class="open city-name-flight">{$objDetail->ArrayDeptForeign[0]['OriginCity']}</span>*}

                                                            <span class="openB airport-name-flight"> {$OriginCityNameByLanguage[$objFunctions->changeFieldNameByLanguage('Airport')]}</span>

                                                            <div class="date-time">
                                                                <span class="time-flight">{$objDetail->ArrayDeptForeign[0]['Time']|substr:0:5 }</span>
                                                            </div>


                                                        </div>

                                                        <div class="airlines-info">
                                                            <div class="airlines-info-inner">{*11*}
                                                                {if $objDetail->SourceID[$direction] !='8'}
                                                                    <span class="iranL">
                                                                             {assign var="TotalLongTime" value=":"|explode:$objDetail->ArrayDeptForeign[0]['TotalLongTime']}
                                                                            ##Flighttime##{if $TotalLongTime[0] gt '0'} {$TotalLongTime[0]} ##dayand## {/if}{$TotalLongTime[1]}
                                                                            ##timeand## {$TotalLongTime[2]}##Minute##
                                                                        </span>
                                                                {/if}
                                                                <div class="airline-line">
                                                                    <div class="loc-icon">
                                                                        <svg version="1.1" class="site-main-text-color"
                                                                             id="Layer_1"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                             x="0px" y="0px" width="32px"
                                                                             viewBox="0 0 512 512"
                                                                             style="enable-background:new 0 0 512 512;"
                                                                             xml:space="preserve">
																<g>
                                                                    <g>
                                                                        <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035
																			c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719
																			c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"/>
                                                                    </g>
                                                                </g>
																</svg>
                                                                    </div>

                                                                    <div class="plane-icon">
                                                                        <svg version="1.1" id="Capa_1"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                             x="0px" y="0px"
                                                                             width="32px" viewBox="0 0 512 512"
                                                                             enable-background="new 0 0 512 512"
                                                                             xml:space="preserve">
																<path d="M445.355,67.036l-0.391-0.392c-19.986-19.006-59.898,14.749-59.898,14.749l-72.463,57.049l-76.285-13.52
																	c11.005-15.953,14.32-31.79,6.983-39.127c-9.503-9.503-33.263-1.15-53.068,18.655c-3.464,3.464-6.568,7.049-9.297,10.657
																	l-58.574-10.381L83.346,137.97l159.044,72.979L140.427,334.152l-63.505-11.906l-16.083,16.06L173.696,451.16l16.058-16.082
																	l-11.906-63.506l123.204-101.963l72.979,159.043l33.244-39.016l-10.381-58.574c3.609-2.729,7.193-5.832,10.658-9.297
																	c19.805-19.805,28.158-43.564,18.656-53.066c-7.339-7.338-23.177-4.022-39.13,6.982l-13.52-76.284l57.049-72.464
																	C430.607,126.934,464.363,87.021,445.355,67.036z"/>
																</svg>

                                                                    </div>

                                                                    <div class="loc-icon-destination">
                                                                        <svg version="1.1" class="site-main-text-color"
                                                                             id="Layer_1"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                             x="0px" y="0px" width="32px"
                                                                             viewBox="0 0 512 512"
                                                                             style="enable-background:new 0 0 512 512;"
                                                                             xml:space="preserve">
																<g>
                                                                    <g>
                                                                        <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035
																			c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719
																			c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"/>
                                                                    </g>
                                                                </g>
																</svg>
                                                                    </div>

                                                                </div>
                                                                <span class="flight-type">{if $objDetail->FlightType[$direction] eq 'system'}##SystemType##{else} ##CharterType##{/if}</span>
                                                                <span class="sit-class">{$objDetail->SeatClass[$direction]}</span>
                                                                <span class="tavaghof ">{if $objDetail->countRoute[$direction] gt '1'}{($objDetail->ArrayDeptForeign|@count)-1} ##Stopi##{else} ##Nostop##  {/if}</span>

                                                            </div>
                                                            <div class="date-time">
                                                                  <span class="date-flight">
                                                                       {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                                                           <p class="farsi-date">{$objDetail->dateDeptForeignJalaliDeparture[$direction]}</p>
                                                                           <p class="speratopr-foraign"> / </p>
                                                                       {/if}

                                                                    <p class="foreign-date">{$objDetail->dateDeptForeignMiladiDeparture[$direction]}</p>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="airlines-info txtRight destination-city">
                                                            {*                                                            <span class="open city-name-flight">{$objDetail->ArrayDeptForeign[(($objDetail->ArrayDeptForeign|@count) - 1)]['DestiCity']}</span>*}
                                                            <span class="open city-name-flight">

                                                                     {assign var="OriginCityNameByLanguage" value=$objFunctions->CityForeign($objDetail->ArrayDeptForeign[(($objDetail->ArrayDeptForeign|@count) - 1)]['DestiAirportIata'])}



                                                                {$OriginCityNameByLanguage[$objFunctions->changeFieldNameByLanguage('DepartureCity')]}
                                                        </span>

                                                            <span class="openB airport-name-flight"> {$OriginCityNameByLanguage[$objFunctions->changeFieldNameByLanguage('Airport')]}</span>
                                                            <div class="date-time">
                                                                <span class="time-flight">{$objDetail->ArrayDeptForeign[(($objDetail->ArrayDeptForeign|@count) - 1)]['ArrivalTime']|substr:0:5}</span>
                                                            </div>

                                                        </div>

                                                    </div>
                                                {/if}
                                                {if $objDetail->ArrayReturnForeign neq ''}
                                                    <div class=" international-available-airlines">
                                                        <div class="international-available-airlines-logo">
                                                            <img src="{$objFunctions->getAirlinePhoto($objDetail->ArrayReturnForeign[0]['Airline_IATA'])}"
                                                                 alt="{$objDetail->ArrayReturnForeign[0]['Airline_IATA']}"
                                                                 title="{$objDetail->ArrayReturnForeign[0]['Airline_IATA']}">
                                                        </div>
                                                        <div class="international-available-airlines-log-info">

                                                    <span class="open txt13 disN740">
                                                    {if $objDetail->ArrayReturnForeign|@count gt '1'}##MultiAirline##{else}{$objFunctions->AirlineName($objDetail->RoutesTicket[$direction][0]['Airline_IATA'])}{/if}</span>
                                                        </div>
                                                    </div>
                                                    <div class="international-available-airlines-info ">
                                                        <div class="airlines-info txtLeft origin-city">
                                                            {*                                                            <span class="open city-name-flight">{$objDetail->ArrayReturnForeign[0]['OriginCity']}</span>*}
                                                            <span class="open city-name-flight">

                                                                     {assign var="OriginCityNameByLanguage" value=$objFunctions->CityForeign($objDetail->ArrayDeptForeign[(($objDetail->ArrayDeptForeign|@count) - 1)]['DestiAirportIata'])}



                                                                {$OriginCityNameByLanguage[$objFunctions->changeFieldNameByLanguage('DepartureCity')]}
                                                        </span>

                                                            <span class="openB airport-name-flight"> {$OriginCityNameByLanguage[$objFunctions->changeFieldNameByLanguage('Airport')]}</span>
                                                            <div class="date-time">
                                                                <span class="time-flight">{$objDetail->ArrayReturnForeign[0]['Time']|substr:0:5}</span>
                                                            </div>
                                                        </div>

                                                        <div class="airlines-info">
                                                            <div class="airlines-info-inner">{*11*}
                                                                {if $objDetail->SourceID[$direction] !='8'}
                                                                    <span class="iranL">
                                                                              {assign var="TotalLongTime" value=":"|explode:$objDetail->ArrayReturnForeign[0]['TotalLongTime']}
                                                                            ##Flighttime##{if $TotalLongTime[0] gt '0'} {$TotalLongTime[0]}##dayand##{/if}{$TotalLongTime[1]}
                                                                            ##timeand## {$TotalLongTime[2]}##Minute##
                                                                        </span>
                                                                {/if}
                                                                <div class="airline-line">
                                                                    <div class="loc-icon">
                                                                        <svg version="1.1" class="site-main-text-color"
                                                                             id="Layer_1"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                             x="0px" y="0px" width="32px"
                                                                             viewBox="0 0 512 512"
                                                                             style="enable-background:new 0 0 512 512;"
                                                                             xml:space="preserve">
																<g>
                                                                    <g>
                                                                        <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035
																			c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719
																			c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"/>
                                                                    </g>
                                                                </g>
																</svg>
                                                                    </div>

                                                                    <div class="plane-icon">
                                                                        <svg version="1.1" id="Capa_1"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                             x="0px" y="0px"
                                                                             width="32px" viewBox="0 0 512 512"
                                                                             enable-background="new 0 0 512 512"
                                                                             xml:space="preserve">
																<path d="M445.355,67.036l-0.391-0.392c-19.986-19.006-59.898,14.749-59.898,14.749l-72.463,57.049l-76.285-13.52
																	c11.005-15.953,14.32-31.79,6.983-39.127c-9.503-9.503-33.263-1.15-53.068,18.655c-3.464,3.464-6.568,7.049-9.297,10.657
																	l-58.574-10.381L83.346,137.97l159.044,72.979L140.427,334.152l-63.505-11.906l-16.083,16.06L173.696,451.16l16.058-16.082
																	l-11.906-63.506l123.204-101.963l72.979,159.043l33.244-39.016l-10.381-58.574c3.609-2.729,7.193-5.832,10.658-9.297
																	c19.805-19.805,28.158-43.564,18.656-53.066c-7.339-7.338-23.177-4.022-39.13,6.982l-13.52-76.284l57.049-72.464
																	C430.607,126.934,464.363,87.021,445.355,67.036z"/>
																</svg>

                                                                    </div>

                                                                    <div class="loc-icon-destination">
                                                                        <svg version="1.1" class="site-main-text-color"
                                                                             id="Layer_1"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                             x="0px" y="0px" width="32px"
                                                                             viewBox="0 0 512 512"
                                                                             style="enable-background:new 0 0 512 512;"
                                                                             xml:space="preserve">
																<g>
                                                                    <g>
                                                                        <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035
																			c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719
																			c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"/>
                                                                    </g>
                                                                </g>
																</svg>
                                                                    </div>

                                                                </div>
                                                                <span class="flight-type iranB txt13">{if $objDetail->FlightType[$direction] eq 'system'}##SystemType##{else} ##CharterType##{/if}</span>
                                                                <span class="sit-class iranL txt13">{$objDetail->SeatClass[$direction]}</span>
                                                                <span class="tavaghof iranL txt13">{if $objDetail->ArrayReturnForeign|@count gt '1'}{($objDetail->ArrayReturnForeign|@count)-1} ##Stopi##{else}##Nostop##{/if}</span>
                                                                <div class="date-time">
                                                                  <span class="date-flight">
                                                                  {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                                                      <p class="farsi-date">{$objDetail->dateReturnForeignJalaliDeparture[$direction]}</p>
                                                                      <p class="speratopr-foraign"> / </p>
                                                                  {/if}
                                                                    <p class="foreign-date">{$objDetail->dateReturnForeignMiladiDeparture[$direction]}</p>
                                                                    </span>
                                                                </div>


                                                            </div>
                                                        </div>
                                                        <div class="airlines-info txtRight destination-city">
                                                            {*                                                            <span class="open city-name-flight">{$objDetail->RoutesTicket[$direction][($objDetail->countRoute[$direction] - 1)]['DestiCity']}</span>*}
                                                            <span class="open city-name-flight">

                                                                {assign var="OriginCityNameByLanguage" value=$objFunctions->CityForeign($objDetail->ArrayDeptForeign[0]['OriginAirportIata'])}



                                                                {$OriginCityNameByLanguage[$objFunctions->changeFieldNameByLanguage('DepartureCity')]}

                                                        </span>

                                                            <span class="openB airport-name-flight"> {$OriginCityNameByLanguage[$objFunctions->changeFieldNameByLanguage('Airport')]}</span>

                                                            <div class="date-time">

                                                                <span class="time-flight">{$objDetail->ArrayReturnForeign[(($objDetail->ArrayReturnForeign|@count) - 1)]['ArrivalTime']|substr:0:5}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                {/if}

                                            </div>

                                        </div>
                                    </div>

                                    <div class="clear"></div>
                                </div>
                            {else}
                                <div class="international-available-box  foreign">

                                    <div class="international-available-item ">
                                        <div class="international-available-info">
                                            <div class="international-available-item-right-Cell w-100 no-before-after border-0 flight-international-factor-detail">

                                                {if $direction eq 'TwoWay'}

                                                    {if $detailTicketForeign['dept'] neq ''}
                                                        <div class=" international-available-airlines  ">

                                                            <div class="international-available-airlines-logo">
                                                                <img src="{$objFunctions->getAirlinePhoto($detailTicketForeign['dept'][0]['Airline_IATA'])}"
                                                                     alt="{$detailTicketForeign['dept'][0]['Airline_IATA']}"
                                                                     title="{$detailTicketForeign['dept']['Airline_IATA']}">
                                                            </div>
                                                            <div class="international-available-airlines-log-info">
                                                                <span class="open txt13 disN740">
                                                                {$detailTicketForeign['dept'][0]['FlightNumber']}
                                                                </span>
                                                                <span class="open txt13 disN740">
                                                             {if $detailTicketForeign['dept']|@count gt '1'}##MultiAirline##{else}{$objFunctions->AirlineName($detailTicketForeign['dept'][0]['Airline_IATA'])}{/if}
                                                            </span>
                                                            </div>

                                                        </div>
                                                        <div class="international-available-airlines-info ">
                                                            <div class="airlines-info txtLeft origin-city">


                                                                {*                                                            <span class="open city-name-flight">{$detailTicketForeign['dept'][0]['OriginCity']}</span>*}
                                                                <span class="open city-name-flight">
                                                            {if $smarty.post.ZoneFlight eq 'Local'}
                                                                {assign var="OriginCityNameByLanguage" value=$objFunctions->CityInternal($detailTicketForeign['dept'][0]['OriginAirportIata'])}
                                                            {else}
                                                                {assign var="OriginCityNameByLanguage" value=$objFunctions->CityForeign($objFunctions->mapIataCode($detailTicketForeign['dept'][0]['OriginAirportIata']))}
                                                            {/if}
                                                                    {$OriginCityNameByLanguage[$objFunctions->changeFieldNameByLanguage('DepartureCity')]}
                                                        </span>




                                                                {assign var="DepartureInfo" value=$objFunctions->NameCityForeign($objFunctions->mapIataCode($detailTicketForeign['dept'][0]['OriginAirportIata']))}
                                                                <span class="openB airport-name-flight">{$DepartureInfo[$objFunctions->changeFieldNameByLanguage('Airport')]}</span>

                                                                <div class="date-time">

													<span class="date-flight">
                                                          {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                                              <p class="farsi-date">{$objFunctions->dateFormatSpecialJalali($detailTicketForeign['dept'][0]['DepartureDate'],'dF')}</p> <p
                                                                  class="speratopr-foraign"> / </p>
                                                          {/if}
													 <p
                                                                class="foreign-date">{$objFunctions->dateFormatSpecialMiladi($detailTicketForeign['dept'][0]['DepartureDate'],'jM')}</p>
													</span>
                                                                    <span class="time-flight">
                                                                    {$detailTicketForeign['dept'][0]['DepartureTime']|substr:0:5}</span>
                                                                </div>


                                                            </div>

                                                            <div class="airlines-info">
                                                                <div class="airlines-info-inner">
                                                        <span class="iranL txt12">
                                                             {assign var="TotalLongTime" value=":"|explode:$detailTicketForeign['dept'][0]['TotalLongTime']}
                                                            ##Flightlength##{if $TotalLongTime[0] gt '0'} {$TotalLongTime[0]} روز و{/if}{$TotalLongTime[1]}
                                                            ##Hour## {$TotalLongTime[2]}##Minutes##
                                                        </span>
                                                                    <div class="airline-line">
                                                                        <div class="loc-icon">
                                                                            <svg version="1.1"
                                                                                 class="site-main-text-color"
                                                                                 id="Layer_1"
                                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                 x="0px" y="0px" width="32px"
                                                                                 viewBox="0 0 512 512"
                                                                                 style="enable-background:new 0 0 512 512;"
                                                                                 xml:space="preserve">
																<g>
                                                                    <g>
                                                                        <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035
																			c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719
																			c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"/>
                                                                    </g>
                                                                </g>
																</svg>
                                                                        </div>

                                                                        <div class="plane-icon">
                                                                            <svg version="1.1" id="Capa_1"
                                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                 x="0px" y="0px"
                                                                                 width="32px" viewBox="0 0 512 512"
                                                                                 enable-background="new 0 0 512 512"
                                                                                 xml:space="preserve">
																<path d="M445.355,67.036l-0.391-0.392c-19.986-19.006-59.898,14.749-59.898,14.749l-72.463,57.049l-76.285-13.52
																	c11.005-15.953,14.32-31.79,6.983-39.127c-9.503-9.503-33.263-1.15-53.068,18.655c-3.464,3.464-6.568,7.049-9.297,10.657
																	l-58.574-10.381L83.346,137.97l159.044,72.979L140.427,334.152l-63.505-11.906l-16.083,16.06L173.696,451.16l16.058-16.082
																	l-11.906-63.506l123.204-101.963l72.979,159.043l33.244-39.016l-10.381-58.574c3.609-2.729,7.193-5.832,10.658-9.297
																	c19.805-19.805,28.158-43.564,18.656-53.066c-7.339-7.338-23.177-4.022-39.13,6.982l-13.52-76.284l57.049-72.464
																	C430.607,126.934,464.363,87.021,445.355,67.036z"/>
																</svg>

                                                                        </div>

                                                                        <div class="loc-icon-destination">
                                                                            <svg version="1.1"
                                                                                 class="site-main-text-color"
                                                                                 id="Layer_1"
                                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                 x="0px" y="0px" width="32px"
                                                                                 viewBox="0 0 512 512"
                                                                                 style="enable-background:new 0 0 512 512;"
                                                                                 xml:space="preserve">
																<g>
                                                                    <g>
                                                                        <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035
																			c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719
																			c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"/>
                                                                    </g>
                                                                </g>
																</svg>
                                                                        </div>

                                                                    </div>
                                                                    <span class="flight-type iranB txt13">{if $item[0]['flight_type'] eq 'system'}##SystemType##{else} ##CharterType##{/if}</span>
                                                                    <span class="sit-class iranL txt13">{if $item[0]['seat_class'] eq 'B' || $item[0]['seat_class'] eq 'C'}##BusinessType##{else}##EconomicsType##{/if}</span>
                                                                    <span class="tavaghof iranL txt13">{if $detailTicketForeign['dept']|@count gt '1'}{($detailTicketForeign['dept']|@count)-1} ##Stop##{else}##Nostop##{/if}</span>

                                                                </div>
                                                            </div>
                                                            <div class="airlines-info txtRight destination-city">
                                                                {*                                                            <span class="open city-name-flight">{$objDetail->ArrayDeptForeign[(($detailTicketForeign['dept']|@count) - 1)]['DestiCity']}</span>*}
                                                                <span class="open city-name-flight">
                                                            {if $smarty.post.ZoneFlight eq 'Local'}
                                                                {assign var="DestCityNameByLanguage" value=$objFunctions->CityInternal($objDetail->ArrayDeptForeign[(($detailTicketForeign['dept']|@count) - 1)]['DestiAirportIata'])}
                                                            {else}
                                                                {assign var="DestCityNameByLanguage" value=$objFunctions->CityForeign($objDetail->ArrayDeptForeign[(($detailTicketForeign['dept']|@count) - 1)]['DestiAirportIata'])}
                                                            {/if}
                                                                    {$DestCityNameByLanguage[$objFunctions->changeFieldNameByLanguage('DepartureCity')]}
                                                        </span>
                                                                {assign var="ArrivalInfo" value=$objFunctions->NameCityForeign($objFunctions->mapIataCode($objDetail->ArrayDeptForeign[(($detailTicketForeign['dept']|@count) - 1)]['DestiAirportIata']))}
                                                                <span class="openB airport-name-flight">{$ArrivalInfo[$objFunctions->changeFieldNameByLanguage('Airport')]}</span>
                                                                <div class="date-time">
                                                                	<span class="date-flight">
                                                                           {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                                                               <p class="farsi-date">
                                                                                   {$objFunctions->dateFormatSpecialJalali($detailTicketForeign['dept'][(($detailTicketForeign['dept']|@count) - 1)]['ArrivalDate'],'dF')}</p>
                                                                               <p class="speratopr-foraign"> / </p>
                                                                           {/if}
                                                                             <p class="foreign-date">{$objFunctions->dateFormatSpecialMiladi($detailTicketForeign['dept'][(($detailTicketForeign['dept']|@count) - 1)]['ArrivalDate'],'jM')}</p>
                                                                            </span>

                                                                    <span class="time-flight">{$objDetail->ArrayDeptForeign[(($detailTicketForeign['dept']|@count) - 1)]['ArrivalTime']|substr:0:5}</span>


                                                                </div>

                                                            </div>

                                                        </div>
                                                    {/if}
                                                    {if  $detailTicketForeign['return'] neq ''}


                                                        <div class=" international-available-airlines  ">

                                                            <div class="international-available-airlines-logo">
                                                                <img src="{$objFunctions->getAirlinePhoto($detailTicketForeign['return'][0]['Airline_IATA'])}"
                                                                     alt="{$detailTicketForeign['return'][0]['Airline_IATA']}"
                                                                     title="{$detailTicketForeign['return'][0]['Airline_IATA']}">
                                                            </div>
                                                            <div class="international-available-airlines-log-info">
                                                  <span class="open txt13 disN740">
                                                    {$detailTicketForeign['return'][0]['FlightNumber']}</span>

                                                                <span class="open txt13 disN740">
                                                    {if $detailTicketForeign['return']|@count gt '1'}##MultiAirline##{else}{$objFunctions->AirlineName($detailTicketForeign['return'][0]['Airline_IATA'])}{/if}</span>
                                                            </div>
                                                        </div>
                                                        <div class="international-available-airlines-info ">
                                                            <div class="airlines-info txtLeft origin-city">

                                                                {*                                                            <span class="open city-name-flight">{$detailTicketForeign['return'][0]['OriginCity']}</span>*}
                                                                <span class="open city-name-flight">
                                                            {if $smarty.post.ZoneFlight eq 'Local'}
                                                                {assign var="OriginCityNameByLanguage" value=$objFunctions->CityInternal($detailTicketForeign['return'][0]['OriginAirportIata'])}
                                                            {else}
                                                                {assign var="OriginCityNameByLanguage" value=$objFunctions->CityForeign($objFunctions->mapIataCode($detailTicketForeign['return'][0]['OriginAirportIata']))}
                                                            {/if}
                                                                    {$OriginCityNameByLanguage[$objFunctions->changeFieldNameByLanguage('DepartureCity')]}
                                                        </span>
                                                                {assign var="DepartureInfo" value=$objFunctions->NameCityForeign($objFunctions->mapIataCode($detailTicketForeign['return'][0]['OriginAirportIata']))}
                                                                <span class="openB airport-name-flight">{$DepartureInfo[$objFunctions->changeFieldNameByLanguage('Airport')]}</span>

                                                                <div class="date-time">

                                                                    <span class="date-flight">
                                                                           {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                                                               <p class="farsi-date">{$objFunctions->dateFormatSpecialJalali($detailTicketForeign['return'][(($detailTicketForeign['return']|@count) - 1)]['DepartureDate'],'dF')}</p> <p
                                                                                   class="speratopr-foraign "> / </p>
                                                                           {/if}
                                                                     <p
                                                                                class="foreign-date">{$objFunctions->dateFormatSpecialMiladi($detailTicketForeign['return'][(($detailTicketForeign['return']|@count) - 1)]['DepartureDate'],'jM')}</p>
                                                                    </span>
                                                                    <span class="time-flight">{$detailTicketForeign['return'][0]['DepartureTime']|substr:0:5}</span>
                                                                </div>


                                                            </div>

                                                            <div class="airlines-info">
                                                                <div class="airlines-info-inner">
                                                        <span class="iranL txt12">
                                                             {assign var="TotalLongTime" value=":"|explode:$detailTicketForeign['return'][0]['TotalLongTime']}
                                                                ##Flightlength##{if $TotalLongTime[0] gt '0'} {$TotalLongTime[0]} ##dayand##{/if}{$TotalLongTime[1]}
                                                                ##HourAnd## {$TotalLongTime[2]}##Minutes##
                                                        </span>
                                                                    <div class="airline-line">
                                                                        <div class="loc-icon">
                                                                            <svg version="1.1"
                                                                                 class="site-main-text-color"
                                                                                 id="Layer_1"
                                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                 x="0px" y="0px" width="32px"
                                                                                 viewBox="0 0 512 512"
                                                                                 style="enable-background:new 0 0 512 512;"
                                                                                 xml:space="preserve">
																<g>
                                                                    <g>
                                                                        <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035
																			c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719
																			c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"/>
                                                                    </g>
                                                                </g>
																</svg>
                                                                        </div>

                                                                        <div class="plane-icon">
                                                                            <svg version="1.1" id="Capa_1"
                                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                 x="0px" y="0px"
                                                                                 width="32px" viewBox="0 0 512 512"
                                                                                 enable-background="new 0 0 512 512"
                                                                                 xml:space="preserve">
																<path d="M445.355,67.036l-0.391-0.392c-19.986-19.006-59.898,14.749-59.898,14.749l-72.463,57.049l-76.285-13.52
																	c11.005-15.953,14.32-31.79,6.983-39.127c-9.503-9.503-33.263-1.15-53.068,18.655c-3.464,3.464-6.568,7.049-9.297,10.657
																	l-58.574-10.381L83.346,137.97l159.044,72.979L140.427,334.152l-63.505-11.906l-16.083,16.06L173.696,451.16l16.058-16.082
																	l-11.906-63.506l123.204-101.963l72.979,159.043l33.244-39.016l-10.381-58.574c3.609-2.729,7.193-5.832,10.658-9.297
																	c19.805-19.805,28.158-43.564,18.656-53.066c-7.339-7.338-23.177-4.022-39.13,6.982l-13.52-76.284l57.049-72.464
																	C430.607,126.934,464.363,87.021,445.355,67.036z"/>
																</svg>

                                                                        </div>

                                                                        <div class="loc-icon-destination">
                                                                            <svg version="1.1"
                                                                                 class="site-main-text-color"
                                                                                 id="Layer_1"
                                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                 x="0px" y="0px" width="32px"
                                                                                 viewBox="0 0 512 512"
                                                                                 style="enable-background:new 0 0 512 512;"
                                                                                 xml:space="preserve">
																<g>
                                                                    <g>
                                                                        <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035
																			c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719
																			c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"/>
                                                                    </g>
                                                                </g>
																</svg>
                                                                        </div>

                                                                    </div>
                                                                    <span class="flight-type iranB txt13">{if $item[0]['flight_type'] eq 'system'}##SystemType##{else} ##CharterType##{/if}</span>
                                                                    <span class="sit-class iranL txt13">{if $item[0]['seat_class'] eq 'B' || $item[0]['seat_class'] eq 'C'}##BusinessType##{else}##EconomicsType##{/if}</span>
                                                                    <span class="tavaghof iranL txt13">{if $detailTicketForeign['return']|@count gt '1'}{($detailTicketForeign['return']|@count)-1} ##Stop##{else}##Nostop##{/if}</span>

                                                                </div>
                                                            </div>
                                                            <div class="airlines-info txtRight destination-city">
                                                                {*                                                            <span class="open city-name-flight">{$detailTicketForeign['return'][(($detailTicketForeign['return']|@count) - 1)]['DestinationCity']}</span>*}
                                                                <span class="open city-name-flight">
                                                            {if $smarty.post.ZoneFlight eq 'Local'}
                                                                {assign var="DestCityNameByLanguage" value=$objFunctions->CityInternal($detailTicketForeign['return'][(($detailTicketForeign['return']|@count) - 1)]['DestinationAirportIata'])}
                                                            {else}
                                                                {assign var="DestCityNameByLanguage" value=$objFunctions->CityForeign($objFunctions->mapIataCode($detailTicketForeign['return'][(($detailTicketForeign['return']|@count) - 1)]['DestinationAirportIata']))}
                                                            {/if}
                                                                    {$DestCityNameByLanguage[$objFunctions->changeFieldNameByLanguage('DepartureCity')]}
                                                        </span>
                                                                {assign var="ArrivalInfo" value=$objFunctions->NameCityForeign($objFunctions->mapIataCode($detailTicketForeign['return'][(($detailTicketForeign['return']|@count) - 1)]['DestinationAirportIata']))}
                                                                <span class="openB airport-name-flight">{$ArrivalInfo[$objFunctions->changeFieldNameByLanguage('Airport')]}</span>

                                                                <div class="date-time">
                                                                	<span class="date-flight">
                                                                                          {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                                                                              <p class="farsi-date">{$objFunctions->dateFormatSpecialJalali($detailTicketForeign['return'][(($detailTicketForeign['return']|@count) - 1)]['ArrivalDate'],'dF')}</p> <p
                                                                                                  class="speratopr-foraign "> / </p>
                                                                                          {/if}



													                         <p
                                                                                class="foreign-date">{$objFunctions->dateFormatSpecialMiladi($detailTicketForeign['return'][(($detailTicketForeign['return']|@count) - 1)]['ArrivalDate'],'jM')}</p>
													</span>

                                                                    <span class="time-flight">{$detailTicketForeign['return'][(($detailTicketForeign['return']|@count) - 1)]['ArrivalTime']|substr:0:5}</span>


                                                                </div>

                                                            </div>

                                                        </div>
                                                    {/if}


                                                {else}
                                                    {assign var="countFlightOneTrip" value=count($detailTicketForeign['oneTrip'])}
                                                    <div class=" international-available-airlines  ">

                                                        <div class="international-available-airlines-logo">
                                                            <img src="{$objFunctions->getAirlinePhoto($detailTicketForeign['oneTrip'][0]['Airline_IATA'])}"
                                                                 alt="{$detailTicketForeign['oneTrip'][0]['Airline_IATA']}"
                                                                 title="{$detailTicketForeign['oneTrip'][0]['Airline_IATA']}">
                                                        </div>
                                                        <div class="international-available-airlines-log-info">
                                              <span class="open txt13 disN740">
                                                    {$detailTicketForeign['oneTrip'][0]['FlightNumber']}</span>
                                                            <span class="open txt13 disN740">
                                                    {if  $countFlightOneTrip gt '1'}##MultiAirline##{else}{$objFunctions->AirlineName($detailTicketForeign['oneTrip'][0]['Airline_IATA'])}{/if}</span>
                                                        </div>
                                                    </div>
                                                    <div class="international-available-airlines-info ">
                                                        <div class="airlines-info txtLeft origin-city">
                                                            {assign var="CityForeignOrigin" value=$objFunctions->CityForeign($objFunctions->mapIataCode($detailTicketForeign['oneTrip'][0]['OriginAirportIata']))}
                                                            {assign var="CityForeignOriginDepartureCity" value=$objFunctions->NameCityForeign('DepartureCity')}


                                                            {*                                                        {$detailTicketForeign['oneTrip'][0]|print_r}*}
                                                            <span class="open city-name-flight">{$CityForeignOrigin[$objFunctions->changeFieldNameByLanguage('DepartureCity')]}</span>
                                                            {assign var="DepartureInfo" value=$objFunctions->NameCityForeign($detailTicketForeign['oneTrip'][0]['OriginAirportIata'])}
                                                            {assign var="ChangeAirlineIndexNameByLanguage" value=$objFunctions->changeFieldNameByLanguage('Airport')}
                                                            <span class="openB airport-name-flight">{$DepartureInfo[$ChangeAirlineIndexNameByLanguage]}</span>
                                                            <div class="date-time">

													<span class="date-flight">
													<p class="farsi-date">
                                                          {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                                        {$objFunctions->dateFormatSpecialJalali($detailTicketForeign['oneTrip'][0]['DepartureDate'],'dF')}</p>
                                                        <p  class="speratopr-foraign "> /</p>
                                                                              {/if}

                                                        <p class="foreign-date">{$objFunctions->dateFormatSpecialMiladi($detailTicketForeign['oneTrip'][0]['DepartureDate'],'jM')}</p>
													</span>
                                                                <span class="time-flight">{$detailTicketForeign['oneTrip'][0]['DepartureTime']|substr:0:5}</span>
                                                            </div>


                                                        </div>

                                                        <div class="airlines-info">
                                                            <div class="airlines-info-inner">
                                                        <span class="iranL txt12">
                                                         {assign var="TotalLongTime" value=":"|explode:$detailTicketForeign['oneTrip'][0]['TotalLongTime']}

                                                            {if  $TotalLongTime[1] gt '0'}
                                                                ##Flighttime##
                                                                {if $TotalLongTime[0] gt '0'}
                                                                    {$TotalLongTime[0]} ##Day## ##AND##
                                                                {/if}
                                                                {$TotalLongTime[1]}
                                                                ##HourAnd##
                                                                {$TotalLongTime[2]}
                                                                ##Minutes##
                                                            {/if}
                                                        </span>
                                                                <div class="airline-line">
                                                                    <div class="loc-icon">
                                                                        <svg version="1.1" class="site-main-text-color"
                                                                             id="Layer_1"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                             x="0px" y="0px" width="32px"
                                                                             viewBox="0 0 512 512"
                                                                             style="enable-background:new 0 0 512 512;"
                                                                             xml:space="preserve">
																<g>
                                                                    <g>
                                                                        <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035
																			c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719
																			c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"/>
                                                                    </g>
                                                                </g>
																</svg>
                                                                    </div>

                                                                    <div class="plane-icon">
                                                                        <svg version="1.1" id="Capa_1"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                             x="0px" y="0px"
                                                                             width="32px" viewBox="0 0 512 512"
                                                                             enable-background="new 0 0 512 512"
                                                                             xml:space="preserve">
																<path d="M445.355,67.036l-0.391-0.392c-19.986-19.006-59.898,14.749-59.898,14.749l-72.463,57.049l-76.285-13.52
																	c11.005-15.953,14.32-31.79,6.983-39.127c-9.503-9.503-33.263-1.15-53.068,18.655c-3.464,3.464-6.568,7.049-9.297,10.657
																	l-58.574-10.381L83.346,137.97l159.044,72.979L140.427,334.152l-63.505-11.906l-16.083,16.06L173.696,451.16l16.058-16.082
																	l-11.906-63.506l123.204-101.963l72.979,159.043l33.244-39.016l-10.381-58.574c3.609-2.729,7.193-5.832,10.658-9.297
																	c19.805-19.805,28.158-43.564,18.656-53.066c-7.339-7.338-23.177-4.022-39.13,6.982l-13.52-76.284l57.049-72.464
																	C430.607,126.934,464.363,87.021,445.355,67.036z"/>
																</svg>

                                                                    </div>

                                                                    <div class="loc-icon-destination">
                                                                        <svg version="1.1" class="site-main-text-color"
                                                                             id="Layer_1"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                             x="0px" y="0px" width="32px"
                                                                             viewBox="0 0 512 512"
                                                                             style="enable-background:new 0 0 512 512;"
                                                                             xml:space="preserve">
																<g>
                                                                    <g>
                                                                        <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035
																			c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719
																			c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"/>
                                                                    </g>
                                                                </g>
																</svg>
                                                                    </div>

                                                                </div>

                                                                <span class="flight-type iranB txt13">{if $item[0]['flight_type'] eq 'system'}##SystemType##{else} ##CharterType##{/if}</span>
                                                                <span class="sit-class iranL txt13">{if ($item[0]['seat_class'] eq 'B' || $item[0]['SeatClass'] eq 'C')}##BusinessType##{else}##EconomicsType##{/if}</span>
                                                                <span class="tavaghof iranL txt13">{if $countFlightOneTrip gt '1'}{$countFlightOneTrip-1} ##Stop##{else}##Nostop##{/if}</span>

                                                            </div>
                                                        </div>
                                                        {assign var="DestCityNameByLanguage" value=$objFunctions->CityForeign($objFunctions->mapIataCode($detailTicketForeign['oneTrip'][($objDetail->countRoute[$direction] - 1)]['DestinationAirportIata']))}

                                                        <div class="airlines-info txtRight destination-city">
                                                            {$DestCityNameByLanguage[$objFunctions->changeFieldNameByLanguage('DepartureCity')]}

                                                            <span class="open city-name-flight">{$CityForeignOriginDepartureCity[$objFunctions->changeFieldNameByLanguage('DepartureCity')]}</span>
                                                            {assign var="ArrivalInfo" value=$objFunctions->NameCityForeign($objFunctions->mapIataCode($detailTicketForeign['oneTrip'][($objDetail->countRoute[$direction] - 1)]['DestinationAirportIata']))}
                                                            {assign var="ChangeArrivalIndexNameByLanguage" value=$objFunctions->changeFieldNameByLanguage('Airport')}
                                                            <span class="openB airport-name-flight">{$ArrivalInfo[$ChangeArrivalIndexNameByLanguage]}</span>

                                                            <div class="date-time">
                                                                {if $detailTicketForeign['oneTrip'][0]['ArrivalDate'] neq ''}
                                                                    <span class="date-flight">
                                                                        {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                                                            <p class="farsi-date">
                                                        {$objFunctions->dateFormatSpecialJalali($detailTicketForeign['oneTrip'][0]['ArrivalDate'],'dF')}
                                                    </p>
                                                                        {/if}

                                                    <p  class="speratopr-foraign"> / </p>
												<p class="foreign-date float-right">{$objFunctions->dateFormatSpecialMiladi($detailTicketForeign['oneTrip'][0]['ArrivalDate'],'jM')} </p>
												</span>
                                                                {/if}
                                                                <span class="time-flight">{$detailTicketForeign['oneTrip'][($objDetail->countRoute[$direction] - 1)]['ArrivalTime']|substr:0:5}</span>


                                                            </div>

                                                        </div>

                                                    </div>
                                                {/if}

                                            </div>


                                        </div>

                                    </div>

                                    <div class="clear"></div>
                                </div>
                            {/if}

                        {/if}
                    </li>
                {/foreach}
            </ul>


        </div>
    </div>
</div>

<div class="Clr"></div>

<div class="main-Content-bottom Dash-ContentL-B">
    <div class="main-Content-bottom-table Dash-ContentL-B-Table">
        <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title l-p-p-header l-p-p-header-change site-bg-main-color">
            <i class="icon-table"></i>
            <h3>##Passengers##</h3>
            <p>
                (
                <i> {$objDetail->Adt_qty} ##Adult## </i> -
                <i>{$objDetail->Chd_qty} ##Child##</i> -
                <i> {$objDetail->Inf_qty} ##Baby## </i>)
            </p>
        </div>
        <div class="table-responsive">
        <table style='table-layout: fixed;' id="passengers" class="display table-responsive" cellspacing="0" width="100%">

            <thead>
            <tr>
                <th>##Sex##</th>
                {*if $smarty.const.SOFTWARE_LANG eq 'fa'}
                <th>##Name##</th>
                <th>##Family##</th>
                {/if*}
                <th>##Nameenglish##</th>
                <th>##Familyenglish##</th>
                <th>##Happybirthday##</th>
                <th>##Numpassport##/##Nationalnumber##</th>
                <th>##Price##</th>
            </tr>
            </thead>
            <tbody>
            {*{$objFactor->direction}*}
            {*<pre>{$FlightSelected[$objFactor->direction]|print_r}</pre>*}
            {foreach $FlightSelected[$objFactor->direction] as $KeyFlight=>$Flight}
                <tr>
                    <td>
                        {if $Flight['passenger_age'] eq 'Adt'}
                            ##Adult##
                        {elseif $Flight['passenger_age'] eq 'Chd'}
                            ##Child##
                        {elseif $Flight['passenger_age'] eq 'Inf'}
                            ##Baby##
                        {/if}

                    </td>
                    {*if $smarty.const.SOFTWARE_LANG eq 'fa'}
                    <td>
                        <p>{$Flight['passenger_name']}</p>
                    </td>
                    <td>
                        <p>{$Flight['passenger_family']}</p>
                    </td>
                    {/if*}
                    <td>
                        <p>{$Flight['passenger_name_en']}</p>
                    </td>
                    <td>
                        <p>{$Flight['passenger_family_en']}</p>
                    </td>
                    <td>
                        <p>{if !$Flight['passenger_birthday']} {$Flight['passenger_birthday_en']} {else} {$Flight['passenger_birthday']}{/if}</p>
                    </td>
                    <td>
                        <p>{if $Flight['passenger_national_code'] eq '0000000000'}{$Flight['passportNumber']}{else}{$Flight['passenger_national_code']}{/if}</p>
                    </td>
                    <td class="price">
                        <p>
                            {if $Flight['passenger_national_code'] eq  '0000000000' && $Flight['passportCountry'] neq 'IRN'}
                                {assign var="nationalCodePreson" value=$Flight['passportNumber']}
                            {else}
                                {assign var="nationalCodePreson" value=$Flight['passenger_national_code']}
                            {/if}
                            <i>

                                {assign var="priceTotalOnePersone" value=$objFunctions->CurrencyCalculate($objFactor->CalculatePriceOnePerson($objFactor->factor_number,$nationalCodePreson),$Flight['currency_code'])}
{*                                {$priceTotalOnePersone['AmountCurrency']|number_format}*}
                                {$objFunctions->numberFormat($priceTotalOnePersone['AmountCurrency'])}
                                &nbsp;{$priceTotalOnePersone['TypeCurrency']}

                            </i>
                        </p>
                    </td>

                </tr>

            {/foreach}
            {assign var="priceTotalCurrencyCalculated" value=$objFunctions->CurrencyCalculate($PriceTotal,$FlightSelected[$objFactor->direction][0]['currency_code'])}
            {assign var="amount_price_special_discount" value=0}

            {if $FlightSelected['dept'][0]['special_discount_type'] neq ''}
            {assign var="total_price_without_special" value=$objFunctions->CalculateDiscount($objFactor->factor_number,'',false)}
                {assign var="priceWithoutSpecialTotalCurrencyCalculated" value=$objFunctions->CurrencyCalculate($total_price_without_special,$FlightSelected[$objFactor->direction][0]['currency_code'])}
                {$amount_price_special_discount = $objFunctions->calculateSpecialDiscount($FlightSelected['dept'][0]['special_discount_type'],$FlightSelected['dept'][0]['special_discount_amount'],$priceWithoutSpecialTotalCurrencyCalculated['AmountCurrency'])}
                <tr>

                    <td colspan=" {if $smarty.const.SOFTWARE_LANG eq 'fa'}7{else}5{/if}" class="txtLeft TotalPrice_td">##Discount## </td>
                    <td class="TotalPrice_td_2">
                        <p class="last-price-factor-local">{$amount_price_special_discount|number_format}##Rial##</p>
                    </td>

                </tr>

                {/if}
            <tr>

                <td colspan="5" class="txtLeft TotalPrice_td">##TotalPrice## </td>
                <td class="TotalPrice_td_2">
                    <p class="last-price-factor-local">
{*                        {$priceTotalCurrencyCalculated['AmountCurrency']|number_format}*}

                            {$objFunctions->numberFormat($priceTotalCurrencyCalculated['AmountCurrency'])}
                            {$priceTotalCurrencyCalculated['TypeCurrency']}


                        &nbsp;</p>
                </td>

            </tr>

            </tbody>

        </table>
        </div>
    </div>
</div>

{foreach key=direction item=item from=$objDetail->Direction}
    {if $direction eq 'dept'}
     {*   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 s-u-passenger-wrapper-change  "
             style="padding: 0;margin: 15px 0px 0px !important;">
            <div class="peygiri-code">
                <div>
                    <span>##TrackingCode## :</span>
                    <span>{$objFactor->RequestNumber['dept']}</span>
                    <span>##TrackingCodeText##</span>
                </div>
            </div>
        </div>*}
    {/if}
{/foreach}
<div class=" s-u-passenger-wrapper-change s-u-passenger-wrapper "
     style="padding: 0">

    <div class="s-u-result-wrapper">
        <div class="s-u-result-item-change direcR iranR txt12 txtRed s-u-result-item-RulsCheck">
            <div style="width: 100%">
                {foreach key=direction item=item from=$objDetail->Direction} {* لازم برای انتخاب نوع بانک *}
                    {assign var="lowerFlightType" value=$objDetail->FlightType[$direction]|lower}
                    {if $lowerFlightType eq 'system'}
                        {assign var="typeTicket" value=""}
                    {else}
                        {assign var="typeTicket" value="public"}
                    {/if}

                    {if $smarty.post.ZoneFlight eq 'Local'}
                    {assign var="isInternal" value="internal"}
                    {else}
                        {assign var="isInterbal" value="external"}
                    {/if}
                    {append var='serviceType' index=$direction value=$objFunctions->TypeService($objDetail->FlightType[$direction], $smarty.post.ZoneFlight, $typeTicket, $objFunctions->checkConfigPid($objDetail->Airline_IATA[$direction],$isInternal,$objDetail->FlightType[$direction]), $smarty.post.ZoneFlight, $objDetail->Airline_IATA[$direction])}
                {/foreach}


                {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] =='5'}
                    <div class="s-u-result-item-RulsCheck-item">
{*                        <input class="FilterHoteltype FilterHoteltypeName-top" id="discount_code" name=""*}
{*                               value="" type="checkbox">*}
{*                        <label class="FilterHoteltypeName site-main-text-color-a" for="discount_code">##Ihavediscountcodewantuse##</label>*}

                        <div class="col-sm-12 parent-discount">
{*                            <div class="row separate-part-discount">*}
{*                                <div class="col-sm-6 col-lg-4 col-10 d-flex flex-column pr-0">*}
{*                                    <label for="discount-code">*}
{*                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M200.3 81.5C210.9 61.5 231.9 48 256 48s45.1 13.5 55.7 33.5C317.1 91.7 329 96.6 340 93.2c21.6-6.6 46.1-1.4 63.1 15.7s22.3 41.5 15.7 63.1c-3.4 11 1.5 22.9 11.7 28.2c20 10.6 33.5 31.6 33.5 55.7s-13.5 45.1-33.5 55.7c-10.2 5.4-15.1 17.2-11.7 28.2c6.6 21.6 1.4 46.1-15.7 63.1s-41.5 22.3-63.1 15.7c-11-3.4-22.9 1.5-28.2 11.7c-10.6 20-31.6 33.5-55.7 33.5s-45.1-13.5-55.7-33.5c-5.4-10.2-17.2-15.1-28.2-11.7c-21.6 6.6-46.1 1.4-63.1-15.7S86.6 361.6 93.2 340c3.4-11-1.5-22.9-11.7-28.2C61.5 301.1 48 280.1 48 256s13.5-45.1 33.5-55.7C91.7 194.9 96.6 183 93.2 172c-6.6-21.6-1.4-46.1 15.7-63.1S150.4 86.6 172 93.2c11 3.4 22.9-1.5 28.2-11.7zM256 0c-35.9 0-67.8 17-88.1 43.4c-33-4.3-67.6 6.2-93 31.6s-35.9 60-31.6 93C17 188.2 0 220.1 0 256s17 67.8 43.4 88.1c-4.3 33 6.2 67.6 31.6 93s60 35.9 93 31.6C188.2 495 220.1 512 256 512s67.8-17 88.1-43.4c33 4.3 67.6-6.2 93-31.6s35.9-60 31.6-93C495 323.8 512 291.9 512 256s-17-67.8-43.4-88.1c4.3-33-6.2-67.6-31.6-93s-60-35.9-93-31.6C323.8 17 291.9 0 256 0zM192 224a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm160 96a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zM337 209c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L175 303c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0L337 209z"></path></svg>*}
{*                                        ##RegisterDiscountCode##*}
{*                                    </label>*}
{*                                    <p>##IfYouHaveAdiscountCode##</p>*}
{*                                    <input type="text" id="discount-code" class="form-control" placeholder="##Codediscount## ...">*}
{*                                    <span class="discount-code-error"></span>*}
{*                                </div>*}
{*                                <div class="col-sm-2 col-2 d-flex p-0">*}
{*                                <span class="input-group-btn">*}
{*                                    <input type="hidden" name="priceWithoutDiscountCode" id="priceWithoutDiscountCode"*}
{*                                           value="{$PriceTotal}"/>*}
{*                                    <button type="button"*}
{*                                            onclick='setDiscountCode({$serviceType|json_encode}, {$smarty.post.CurrencyCode})'*}
{*                                            class="site-secondary-text-color site-bg-main-color iranR discount-code-btn">##Apply##</button>*}
{*                                </span>*}
{*                                </div>*}
{*                            </div>*}
                            <div class="discount-code-new">
                                <div class="title-discount-code">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M200.3 81.5C210.9 61.5 231.9 48 256 48s45.1 13.5 55.7 33.5C317.1 91.7 329 96.6 340 93.2c21.6-6.6 46.1-1.4 63.1 15.7s22.3 41.5 15.7 63.1c-3.4 11 1.5 22.9 11.7 28.2c20 10.6 33.5 31.6 33.5 55.7s-13.5 45.1-33.5 55.7c-10.2 5.4-15.1 17.2-11.7 28.2c6.6 21.6 1.4 46.1-15.7 63.1s-41.5 22.3-63.1 15.7c-11-3.4-22.9 1.5-28.2 11.7c-10.6 20-31.6 33.5-55.7 33.5s-45.1-13.5-55.7-33.5c-5.4-10.2-17.2-15.1-28.2-11.7c-21.6 6.6-46.1 1.4-63.1-15.7S86.6 361.6 93.2 340c3.4-11-1.5-22.9-11.7-28.2C61.5 301.1 48 280.1 48 256s13.5-45.1 33.5-55.7C91.7 194.9 96.6 183 93.2 172c-6.6-21.6-1.4-46.1 15.7-63.1S150.4 86.6 172 93.2c11 3.4 22.9-1.5 28.2-11.7zM256 0c-35.9 0-67.8 17-88.1 43.4c-33-4.3-67.6 6.2-93 31.6s-35.9 60-31.6 93C17 188.2 0 220.1 0 256s17 67.8 43.4 88.1c-4.3 33 6.2 67.6 31.6 93s60 35.9 93 31.6C188.2 495 220.1 512 256 512s67.8-17 88.1-43.4c33 4.3 67.6-6.2 93-31.6s35.9-60 31.6-93C495 323.8 512 291.9 512 256s-17-67.8-43.4-88.1c4.3-33-6.2-67.6-31.6-93s-60-35.9-93-31.6C323.8 17 291.9 0 256 0zM192 224a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm160 96a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zM337 209c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L175 303c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0L337 209z"></path></svg>
                                    <h2>##RegisterDiscountCode##</h2>
                                </div>
                                <div class="discount-code-data">
                                    <h3>##IfYouHaveAdiscountCode##</h3>
                                    <div class="form-discount-code">
                                        <input type="text" placeholder="##Codediscount## ..." id="discount-code">
                                        <input type="hidden" name="priceWithoutDiscountCode" id="priceWithoutDiscountCode"
                                               value="{$PriceTotal}"/>
                                        <button type="button" onclick='setDiscountCode({$serviceType|json_encode}, {$smarty.post.CurrencyCode})' class="site-bg-main-color">
                                            ##Apply##
                                        </button>
                                    </div>
                                    <span class="discount-code-error"></span>
                                </div>
                            </div>
                            <div class="row">
                                {*                            <div class="info-box__price info-box__item pull-left">
                                                                <div class="item-discount">
                                                                    <span class="item-discount__label">##Amountpayable## :</span>
                                                                    <span class="price__amount-price price-after-discount-code">{$objFunctions->numberFormat($objDetail->Amount)}</span>
                                                                    <span class="price__unit-price">{$objDetail->AdtPriceType[$direction]}</span>
                                                                </div>
                                                            </div>*}
                                <div class="a-takhfif-box">
                                    <div class="a-takhfif-box-inner">
                                        <div class="a-takhfif-before">
                                            <span>##PreviousPrice##</span>
                                            <span>{$objFunctions->numberFormat($PriceTotal)}
                                                <i>{$objDetail->AdtPriceType[$direction]}</i></span>
                                        </div>
                                        <div class="a-takhfif-offer">
                                            <span>##DiscountAmount##</span>
                                            <span><span class="discountAmount">0</span>
                                                <i>{$objDetail->AdtPriceType[$direction]}</i></span>
                                        </div>
                                        <div class="a-takhfif-after">
                                            <span>##FinalAmount##</span>
                                            <span class="price-after-discount-code">{$objFunctions->numberFormat($PriceTotal)}
                                                <i>{$objDetail->AdtPriceType[$direction]}</i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                {/if}

                <p class="s-u-result-item-RulsCheck-item">
                    <input class="FilterHoteltype Show_by_filters FilterHoteltypeName-top" id="RulsCheck"
                           name="heck_list1" value="" type="checkbox">
                    <label class="FilterHoteltypeName site-main-text-color-a " for="RulsCheck">
                        <a class="site-main-text-color" href="{$smarty.const.URL_RULS}" target="_blank">##Seerules##</a>
                        ##IhavestudiedIhavenoobjection##
                    </label>
                </p>


                {if $FlightisInternal == '1'}
{*                    <p class="s-u-result-item-RulsCheck-item">*}
{*                        <input class="FilterHoteltype Show_by_filters FilterHoteltypeName-top" id="CovidRulsCheck"*}
{*                                value="" type="checkbox">*}
{*                        <label class="FilterHoteltypeName site-main-text-color-a " for="CovidRulsCheck">*}
{*                            <a class="site-main-text-color" href="{$smarty.const.ROOT_ADDRESS}/covidform" target="_blank">##SeeCovidRules## </a>*}
{*                            ##CovidTerms##*}
{*                        </label>*}
{*                    </p>*}
                {/if}

            </div>




        </div>
    </div>

</div>
    {if $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter' && $smarty.const.SOFTWARE_LANG == 'fa' }
        <div class="return-bank-box">
                <div class="row">
                    <div class="col-md-12 mr-auto ml-auto">
                        <div class="return-bank-inner price-change">
                            <div>
                                <div class="w-100">
                                    <div class="change-price text-right">
                                        <div class="change-price-titile">
                                            ##IncreasePrice##
                                        </div>
                                        <div>##DearCounter##</div>
                                        <div class="change-price-info">
                                            <p>##NewPriceForTicket##</p>


                                            <p>##InfoNewPriceForTicket##</p>
                                            <div class="change-price-input">
                                                <input placeholder="##EnterYourPriceToRial##" type="text"
                                                       name="ChangePriceStepFinal"
                                                       data-factorNumber="{$objFactor->factor_number}"
                                                       id="ChangePriceStepFinal">
                                                <button onclick="ChangePriceStepFinal()"
                                                        id="ChangePriceStepFinalBtn">##Send##
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    {/if}
<div class="btns_factors_n">
{*<div class="btn_research__">*}
{*    <!-- <a href="" onclick="return false" class="f-loader-check loaderpassengers"  style="display:none"></a> -->*}
{*    <button type="button" class="cancel-passenger" onclick="BackToHome('{$objDetail->reSearchAddress}'); return false">*}
{*        ##Repeatsearch## <i class="fa fa-refresh"></i></button>*}

</div>
<div class="passengersDetailLocal_next">
    <a href="" onclick="return false" class="f-loader-check loaderfactors" id="loader_check" style="display:none"></a>
    <a class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-bg-main-color factorLocal-btn"
       id="ok"
       onclick="pricePay('{$objFactor->factor_number}','flight')">
        ##Approvefinal##
        <svg class="svg-arrow--btn" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path data-v-2824aec9="" d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"></path></svg>
    </a>
</div>
</div>
<div id="messageBook" class="error-flight"></div>


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

    {assign var="PaymentPrivateCharter724" value="0"}
    {if ($objFactor->direction eq 'dept' &&  $objFactor->direction neq 'return') && $objFactor->Source_ID['dept'] eq '8' && $objFunctions->checkPrivateFlight($objFactor->RequestNumber['dept'])}
        {$PaymentPrivateCharter724 = "1"}
    {/if}

    {assign var="bankInputs" value=['type_service'=>'flight','flag' => 'check_credit', 'RequestNumber' => $objFactor->RequestNumber, 'serviceType' => $serviceType]}
    {assign var="bankAction" value="`$smarty.const.ROOT_ADDRESS`/goBankLocal"}



    {assign var="creditInputs" value=['flag' => 'buyByCreditLocal', 'factorNumber' => $objFactor->factor_number, 'RequestNumber' => $objFactor->RequestNumber]}
    {assign var="creditAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankLocal"}
{*    {if $smarty.const.CLIENT_ID eq '186' || $smarty.const.CLIENT_ID eq '4'|| $smarty.const.CLIENT_ID eq '255'|| $smarty.const.CLIENT_ID eq '169'}
    {assign var="creditAction" value="`$smarty.const.ROOT_ADDRESS`/processFlight"}
        {else}
    {assign var="creditAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankLocal"}
    {/if}*}

    {assign var="creditAction" value="`$smarty.const.ROOT_ADDRESS`/processFlight"}


    {assign var="currencyPermition" value="0"}
    {if $smarty.const.ISCURRENCY && $smarty.post.CurrencyCode > 0}
        {$currencyPermition = "1"}
        {assign var="currencyInputs" value=['flag' => 'check_credit', 'factorNumber' => $objFactor->factor_number, 'RequestNumber' => $objFactor->RequestNumber, 'serviceType' => $serviceType, 'amount' => $objDetail->Amount, 'currencyCode' => $smarty.post.CurrencyCode]}
        {assign var="currencyAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankLocal"}
    {/if}

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`paymentMethods.tpl"}
    <!-- payment methods drop down -->


</div>
</div>
<!--BACK TO TOP BUTTON-->
<div class="backToTop"></div>

{literal}
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
            $(this).find(".closeBtn").click(function () {

                $(".Cancellation-Box").removeClass("displayBlock");
                $("#lightboxContainer").removeClass("displayBlock");
            });
            $("div#lightboxContainer").click(function () {

                $(".Cancellation-Box").removeClass("displayBlock");
                $("#lightboxContainer").removeClass("displayBlock");
            });
            $('.DetailSelectTicket').on('click', function (e) {
                $(this).parent().siblings('.DetailSelectTicketContect').slideToggle('fast');
            });
        });
    </script>
<!-- jQuery Site Scipts -->
    <script src="assets/js/jquery.counter.js" type="text/javascript"></script>
<script>
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
    <script src="assets/js/script.js"></script>

<!-- modal login    -->
    <script type="text/javascript" src="assets/js/modal-login.js"></script>
{/literal}

<div class="price-Box displayNone" id="ShowInfoFlightCabinType"></div>