<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>
<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>
{load_presentation_object filename="package" assign="objPackage"}
{load_presentation_object filename="detailHotel" assign="objResult"}
{load_presentation_object filename="passengersDetailLocal" assign="objDetail"}
{assign var="InfoMember" value=$objFunctions->infoMember($objSession->getUserId())}
{assign var="InfoCounter" value=$objFunctions->infoCounterType($InfoMember.fk_counter_type_id)}
{assign var="dataPackage" value=$objPackage->getDataTempPackage($smarty.post)}

{$objDetail->getCustomers()}   {*گرفتن اطلاعات مربوط به مسافران هر مشتری*}
{if $smarty.const.SOFTWARE_LANG eq 'fa'}
    {assign var="CalendarType" value='Jalali'}
{else}
    {assign var="CalendarType" value='miladi'}
{/if}

<pre style="opacity: 0">{$smarty.post|json_encode}</pre>


<!--<label id="seconds">00</label>:<label id="minutes">00</label>-->
<div>
    <div id="steps">
        <div class="steps_items">
            <div class="step done ">

                <span class=""><i class="fa fa-check"></i></span>
                <h3>##Selectionflight##</h3>
            </div>
            <i class="separator donetoactive"></i>
            <div class="step active ">
                <span class="flat_icon_airplane"><i class="fa fa-check"></i></span>
                <h3>##PassengersInformation##</h3>

            </div>
            <i class="separator "></i>
            <div class="step  ">
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
            <div class="step">
            <span class="flat_icon_airplane">
                <svg enable-background="new 0 0 512 512" height="25" viewBox="0 0 512 512" width="25"
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
             style="direction: ltr"> {$objDetail->SetTimeLimit($objDetail->totalQty)}</div>

    </div>

    <div id="lightboxContainer" class="lightboxContainerOpacity"></div>

    <!-- last passenger list -->
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`passengerPopup.tpl"}
    <!--end  last passenger list -->

    <div id="fligh_Detail_local" class="s-u-content-result">
        <form id="SendDataToPackageFactor"></form>
        {assign var="hotelInfo" value=$dataPackage['hotel'][0]}
        {assign var="direction" value='TwoWay'}


        <div class="">

            <div class="hotel_section">

                <div class="titr_package">##Purchasingfollowingticket##</div>
                <div class="image_hotel">
                    <img src="{$hotelInfo['hotel_pictures']}" class="w-100" alt=""/>
                </div>

                <div class="content_hotel">
                    <div class="title_h">##HotelInformation##</div>
                    <div class="name_h info_h"><span
                                class="site-main-text-color">##Namehotel## : </span>{$hotelInfo['hotel_name']}</div>
                    <div class="city_h info_h"><span
                                class="site-main-text-color">##NameDestinationCity## : </span>{$hotelInfo['city_name']}</div>
                    <div class="addres_h info_h"><span
                                class="site-main-text-color">##Addresshotel## : </span>{$hotelInfo['hotel_address']}</div>
                    <div class="dateStart_h info_h"><span
                                class="site-main-text-color">##StartDate## : </span><span>{$hotelInfo['start_date']}</span>:-
                        ##EndDate##<span>{$hotelInfo['end_date']}</span>
                    </div>
                    <div class="night_h info_h"><span
                                class="site-main-text-color">##Countnight## : </span><span>{$hotelInfo['number_night']}</span>
                    </div>
                </div>
            </div>


            <div class="s-u-passenger-wrapper">

                <div class="titr_package">##Informationflight##</div>

                {if $objDetail->ArrayDeptForeign neq ''}
                    <div class="flight_section">
                        <div class=" international-available-airlines ">

                            <div class="international-available-airlines-logo">
                                <img src="{$objFunctions->getAirlinePhoto($objDetail->ArrayDeptForeign[0]['Airline_IATA'])}"
                                     alt="{$objDetail->ArrayDeptForeign[0]['Airline_IATA']}"
                                     title="{$objDetail->ArrayDeptForeign[0]['Airline_IATA']}">
                            </div>
                            <div class="international-available-airlines-log-info">

                                                        <span class="open txt13 disN740">
                                                        {if $objDetail->ArrayDeptForeign|@count gt '1'}##Howmanypaths##/ ##Airline##{else}{$objFunctions->AirlineName($objDetail->RoutesTicket[$direction][0]['Airline_IATA'])}{/if}</span>
                            </div>

                        </div>
                        <div class="international-available-airlines-info ">
                            <div class="airlines-info txtLeft origin-city">

                                <span class="open city-name-flight">{$objDetail->ArrayDeptForeign[0]['OriginCity']}</span>
                                {assign var="DepartureInfo" value=$objFunctions->NameCityForeign($objDetail->ArrayDeptForeign[0]['OriginAirportIata'])}
                                <span class="openB airport-name-flight">{$DepartureInfo['AirportFa']}</span>
                                <div class="date-time">

                                </div>
                                <div class="date-time">

                                                        <span class="date-flight">
                                                        <p class="farsi-date">{$objDetail->dateDeptForeignJalaliDeparture[$direction]}</p> <p
                                                                    class="speratopr-foraign site-main-text-color"> / </p> <p
                                                                    class="foreign-date">{$objDetail->dateDeptForeignMiladiDeparture[$direction]}</p>
                                                        </span>
                                    <span class="time-flight">{$objDetail->ArrayDeptForeign[0]['Time']}</span>
                                </div>


                            </div>

                            <div class="airlines-info">
                                <div class="airlines-info-inner">
                                                            <span class="iranL txt12">
                                                                 {assign var="TotalLongTime" value=":"|explode:$objDetail->ArrayDeptForeign[0]['TotalLongTime']}
                                                                ##Flighttime##{if $TotalLongTime[0] gt '0'} {$TotalLongTime[0]} ##dayand## {/if}{$TotalLongTime[1]}
                                                                ##timeand## {$TotalLongTime[2]}##Minute##
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
                                    <div class="charters">
                                        <span class="flight-type">{if $objDetail->FlightType[$direction] eq 'system'}##SystemType##{else} ##CharterType##{/if}</span>
                                        <span class="sit-class">{$objDetail->SeatClass[$direction]}</span>
                                        <span class="tavaghof">{if $objDetail->countRoute[$direction] gt '1'}{($objDetail->ArrayDeptForeign|@count)-1} ##Stopi##{else} ##Nostop##  {/if}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="airlines-info txtRight destination-city">
                                <span class="open city-name-flight">{$objDetail->ArrayDeptForeign[(($objDetail->ArrayDeptForeign|@count) - 1)]['DestiCity']}</span>
                                {assign var="ArrivalInfo" value=$objFunctions->NameCityForeign($objDetail->ArrayDeptForeign[(($objDetail->ArrayDeptForeign|@count) - 1)]['DestiAirportIata'])}
                                <span class="openB airport-name-flight">{$ArrivalInfo['AirportFa']}</span>
                                <div class="date-time">

                                </div>
                                <div class="date-time">
                                                    <span class="date-flight"><p
                                                                class="farsi-date">{$objDetail->dateDeptForeignJalaliArrival[$direction]}</p> <p
                                                                class="speratopr-foraign site-main-text-color"> / </p>
                                                    <p class="foreign-date float-right">{$objDetail->dateDeptForeignMiladiArrival[$direction]} </p>
                                                    </span>
                                    <span class="time-flight">{$objDetail->ArrayDeptForeign[(($objDetail->ArrayDeptForeign|@count) - 1)]['ArrivalTime']}</span>


                                </div>

                            </div>

                        </div>
                    </div>
                {/if}

                {if $objDetail->ArrayReturnForeign neq ''}
                    <div class="flight_section">
                        <div class=" international-available-airlines  ">

                            <div class="international-available-airlines-logo">
                                <img src="{$objFunctions->getAirlinePhoto($objDetail->ArrayReturnForeign[0]['Airline_IATA'])}"
                                     alt="{$objDetail->ArrayReturnForeign[0]['Airline_IATA']}"
                                     title="{$objDetail->ArrayReturnForeign[0]['Airline_IATA']}">
                            </div>
                            <div class="international-available-airlines-log-info">

                                                        <span class="open txt13 disN740">
                                                        {if $objDetail->ArrayReturnForeign|@count gt '1'}##Howmanypaths##/ ##Airline##{else}{$objFunctions->AirlineName($objDetail->RoutesTicket[$direction][0]['Airline_IATA'])}{/if}</span>
                            </div>
                        </div>
                        <div class="international-available-airlines-info ">
                            <div class="airlines-info txtLeft origin-city">

                                <span class="open city-name-flight">{$objDetail->ArrayReturnForeign[0]['OriginCity']}</span>
                                {assign var="DepartureInfo" value=$objFunctions->NameCityForeign($objDetail->ArrayReturnForeign[0]['OriginAirportIata'])}
                                <span class="openB airport-name-flight">{$DepartureInfo['AirportFa']}</span>
                                <div class="date-time">

                                </div>
                                <div class="date-time">

                                                        <span class="date-flight">
                                                        <p class="farsi-date">{$objDetail->dateReturnForeignJalaliDeparture[$direction]}</p>
                                                         <p class="speratopr-foraign site-main-text-color"> / </p>
                                                                    <p class="foreign-date">{$objDetail->dateReturnForeignMiladiDeparture[$direction]}</p>
                                                        </span>
                                    <span class="time-flight">{$objDetail->ArrayReturnForeign[0]['Time']}</span>
                                </div>


                            </div>

                            <div class="airlines-info">
                                <div class="airlines-info-inner">
                                                            <span class="iranL txt12">
                                                          {assign var="TotalLongTime" value=":"|explode:$objDetail->ArrayReturnForeign[0]['TotalLongTime']}
                                                                ##Flighttime##{if $TotalLongTime[0] gt '0'} {$TotalLongTime[0]}##dayand##{/if}{$TotalLongTime[1]}
                                                                ##timeand## {$TotalLongTime[2]}##Minute##
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
                                    <div class="charters">
                                        <span class="flight-type ">{if $objDetail->FlightType[$direction] eq 'system'}##SystemType##{else} ##CharterType##{/if}</span>
                                        <span class="sit-class ">{$objDetail->SeatClass[$direction]}</span>
                                        <span class="tavaghof ">{if $objDetail->ArrayReturnForeign|@count gt '1'}{($objDetail->ArrayReturnForeign|@count)-1} ##Stopi##{else}##Nostop##{/if}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="airlines-info txtRight destination-city">
                                <span class="open city-name-flight">{$objDetail->RoutesTicket[$direction][($objDetail->countRoute[$direction] - 1)]['DestiCity']}</span>
                                {assign var="ArrivalInfo" value=$objFunctions->NameCityForeign($objDetail->RoutesTicket[$direction][($objDetail->countRoute[$direction] - 1)]['DestiAirportIata'])}
                                <span class="openB airport-name-flight">{$ArrivalInfo['AirportFa']}</span>
                                <div class="date-time">

                                </div>
                                <div class="date-time">
                                                    <span class="date-flight"><p
                                                                class="farsi-date">{$objDetail->dateReturnForeignJalaliArrival[$direction]}</p> <p
                                                                class="speratopr-foraign site-main-text-color"> / </p>
                                                    <p class="foreign-date float-right">{$objDetail->dateReturnForeignMiladiArrival[$direction]} </p>
                                                    </span>
                                    <span class="time-flight">{$objDetail->ArrayReturnForeign[(($objDetail->ArrayReturnForeign|@count) - 1)]['ArrivalTime']}</span>


                                </div>

                            </div>

                        </div>
                    </div>
                {/if}
                <div class="prices_div">
                    <div class="col-lg-4 cols">
                        ##FlightPrice##: <span>{$objDetail->Amount|number_format} <i>##Rial##</i></span>
                    </div>
                    <div class="col-lg-4 cols">
                        ##HotelPrice##:<span>{$hotelInfo['room_price_current']|number_format} <i>##Rial##</i></span>
                    </div>
                    <div class="col-lg-4 cols total_price">
                        ##FinalPrice##:<span>{$smarty.post.totalPrice|number_format} <i>##Rial##</i></span>
                    </div>

                </div>

            </div>

        </div>


    </div>

    <div class="clear"></div>
    <form method="post" id="formPassengerDetailPackage" action="#">

        {*فرم ثبت نام به تعداد افراد بزرگسال*}
        {for $i=1 to $objDetail->Adt_qty}
            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">

                <span class="titr_package">
            ##Adult## <i class="soap-icon-family"></i>
                        {if $objSession->IsLogin() and ($smarty.session.typeUser eq 'counter')}
                            <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change"
                                  onclick="setHidenFildnumberRow('A{$i}')">
                            <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i> ##Passengerbook##
                                </span>
                        {/if}
                </span>

                <div class="panel-default-change">
                    <div class="panel-heading-change">

                        <span class="hidden-xs-down">##Nation##:</span>

                        <span class="kindOfPasenger">
						    <label class="control--checkbox">
                                <span>##Iranian##</span>
                                <input checked type="radio" name="passengerNationalityA{$i}" id="passengerNationalityA{$i}"
                                       value="0" class="nationalityChange">
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
                                <input type="radio" name="passengerNationalityA{$i}" id="passengerNationalityA{$i}"
                                       value="1" class="nationalityChange">
                                <div class="checkbox">
                                    <div class="filler"></div>
                                     <svg fill="#000000"  viewBox="0 0 30 30" >
                                    <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                                   </svg>
                                </div>
							</label>
                        </span>

                        <span class="member-price">
                                {assign var="showPice" value="0"}
                            {foreach key=direction item=item from=$objDetail->Direction}
                                {if $objSession->IsLogin()}
                                    {$showPice = $showPice + $objDetail->AdtPriceByChange[$direction]}
                                {else}
                                    {$showPice = $showPice + $objDetail->AdtPrice[$direction]}
                                {/if}
                            {/foreach}
                                <i>{$objFunctions->numberFormat($showPice)}</i> {$objDetail->AdtPriceType[$direction]}
                            </span>



                    </div>

                    <div class="clear"></div>

                    <div class="panel-body-change">
                        <div class="s-u-passenger-item  s-u-passenger-item-change ">
                            <select class="" id="genderA{$i}" name="genderA{$i}">
                                <option value=""  selected="selected">##Sex##</option>
                                <option value="Male">##Sir##</option>
                                <option value="Female">##Lady##</option>
                            </select>
                        </div>

                        <div class="s-u-passenger-item s-u-passenger-item-change">
                            <input id="nameEnA{$i}" type="text" placeholder="##Nameenglish##" name="nameEnA{$i}"
                                   onkeypress="return isAlfabetKeyFields(event, 'nameEnA{$i}')" class="">
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change">
                            <input id="familyEnA{$i}" type="text" placeholder="##Familyenglish##"
                                   name="familyEnA{$i}"
                                   onkeypress="return isAlfabetKeyFields(event, 'familyEnA{$i}')" class="">
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                            <input id="birthdayEnA{$i}" type="text"
                                   placeholder="##miladihappybirthday##(##Noiranian##)"
                                   name="birthdayEnA{$i}" class="gregorianAdultBirthdayCalendar"
                                   readonly="readonly">
                        </div>

                        <div class="s-u-passenger-item s-u-passenger-item-change">
                            <input id="nameFaA{$i}" type="text" placeholder="##Namepersion##" name="nameFaA{$i}"
                                   onkeypress=" return persianLetters(event, 'nameFaA{$i}')" class="justpersian">
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change">
                            <input id="familyFaA{$i}" type="text" placeholder="##Familypersion##"
                                   name="familyFaA{$i}" onkeypress=" return persianLetters(event, 'familyFaA{$i}')"
                                   class="justpersian">
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                            <input id="birthdayA{$i}" type="text" placeholder="##shamsihappybirthday##"
                                   name="birthdayA{$i}"
                                   class="shamsiAdultBirthdayCalendar" readonly="readonly">
                        </div>

                        <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                            <input id="NationalCodeA{$i}" type="tel" placeholder="##Nationalnumber##"
                                   name="NationalCodeA{$i}"
                                   maxlength="10" class="UniqNationalCode"
                                   onkeyup="return checkNumber(event, 'NationalCodeA{$i}')">
                        </div>

                        <div class="s-u-passenger-item s-u-passenger-item-change select-meliat noneIranian">
                            <select name="passportCountryA{$i}" id="passportCountryA{$i}"
                                    class="select2">
                                <option value="">##Countryissuingpassport##</option>
                                {foreach $objFunctions->CountryCodes() as $Country}
                                    <option value="{if $objDetail->SourceID['dept']=='10'
                                    || $objDetail->SourceID['TwoWay']=='10'  }
                                            {$Country['code_two_letter']}{else}{$Country['code']}{/if}"
                                            {if $smarty.post.ZoneFlight neq 'Local' && $Country['code'] eq 'IRN'}selected="selected"{/if}>{$Country['titleFa']}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change {if $objDetail->isInternal eq true}noneIranian{/if}">
                            <input id="passportNumberA{$i}" type="text" placeholder="##Numpassport##"
                                   name="passportNumberA{$i}" class="UniqPassportNumber"
                                   onkeypress="return isAlfabetNumberKeyFields(event, 'passportNumberA{$i}')">
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change {if $objDetail->isInternal eq true}noneIranian{/if}">
                            <input id="passportExpireA{$i}" class="gregorianFromTodayCalendar" type="text"
                                   placeholder="##Passportexpirydate##" name="passportExpireA{$i}">
                        </div>

                        <div class="alert_msg" id="messageA{$i}"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        {/for}

        {*فرم ثبت نام به تعداد کودکان*}
        {for $i=1 to $objDetail->Chd_qty}
            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change  first">

                <span class="titr_package">
                ##Child## <i class="soap-icon-man-3"></i>
                          {if $objSession->IsLogin() and ($smarty.session.typeUser eq 'counter')}
                              <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change"
                                    onclick="setHidenFildnumberRow('C{$i}')">
                            <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i>##Passengerbook##
                        </span>
                          {/if}
                </span>
                <div class="panel-default-change  site-border-main-color">
                    <div class="panel-heading-change">

                        <span class="hidden-xs-down">##Nation##:</span>

                        <span class="kindOfPasenger">
						    <label class="control--checkbox">
                                <span>##Iranian##</span>
                                <input type="radio" name="passengerNationalityC{$i}" id="passengerNationalityC{$i}"
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
                                <input type="radio" name="passengerNationalityC{$i}" id="passengerNationalityC{$i}"
                                       value="1" class="nationalityChange">
                                <div class="checkbox">
                                    <div class="filler"></div>
                                     <svg fill="#000000"  viewBox="0 0 30 30" >
                                    <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                                   </svg>
                                </div>
							</label>
                        </span>
                        <span class="member-price ">
                                {assign var="showPice" value="0"}
                            {if $objDetail->SourceID['dept']=='8'}
                                {foreach key=direction item=item from=$objDetail->Direction}
                                    {if $objSession->IsLogin()}
                                        {$showPice = $showPice + $objDetail->ChdPriceByChange[$direction]}
                                    {else}
                                        {$showPice = $showPice + $objDetail->ChdPrice[$direction]}
                                    {/if}
                                {/foreach}
                            {else}
                                {$showPice = $showPice + $objDetail->ChdPrice[$direction]}
                            {/if}
                                <i>{$objFunctions->numberFormat($showPice)}</i> {$objDetail->AdtPriceType[$direction]}
                            </span>


                    </div>

                    <div class="clear"></div>

                    <div class="panel-body-change">
                        <div class="s-u-passenger-item s-u-passenger-item-change">
                            <select id="genderC{$i}" name="genderC{$i}">
                                <option value="" disabled selected="selected">##Sex##</option>
                                <option value="Male">##Boy##</option>
                                <option value="Female">##Girl##</option>
                            </select>
                        </div>

                        <div class="s-u-passenger-item s-u-passenger-item-change">
                            <input id="nameEnC{$i}" type="text" placeholder="##Nameenglish##" name="nameEnC{$i}"
                                   onkeypress="return isAlfabetKeyFields(event, 'nameEnC{$i}')">
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change">
                            <input id="familyEnC{$i}" type="text" placeholder="##Familyenglish##"
                                   name="familyEnC{$i}"
                                   onkeypress="return isAlfabetKeyFields(event, 'familyEnC{$i}')">
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                            <input id="birthdayEnC{$i}" type="text" placeholder="##miladihappybirthday##"
                                   name="birthdayEnC{$i}" class="gregorianChildBirthdayCalendar"
                                   readonly="readonly">
                        </div>

                        <div class="s-u-passenger-item s-u-passenger-item-change">
                            <input id="nameFaC{$i}" type="text" placeholder="##Namepersion##" name="nameFaC{$i}"
                                   onkeypress=" return persianLetters(event, 'nameFaC{$i}')" class="justpersian">
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change">
                            <input id="familyFaC{$i}" type="text" placeholder="##Familypersion##"
                                   name="familyFaC{$i}" onkeypress=" return persianLetters(event, 'familyFaC{$i}')"
                                   class="justpersian">
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                            <input id="birthdayC{$i}" type="text" placeholder="##shamsihappybirthday##"
                                   name="birthdayC{$i}"
                                   class="shamsiChildBirthdayCalendar" readonly="readonly">
                        </div>

                        <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                            <input id="NationalCodeC{$i}" type="tel" placeholder="##Nationalnumber##"
                                   name="NationalCodeC{$i}"
                                   maxlength="10" class="UniqNationalCode"
                                   onkeyup="return checkNumber(event, 'NationalCodeC{$i}')">
                        </div>

                        <div class="s-u-passenger-item s-u-passenger-item-change select-meliat noneIranian">
                            <select name="passportCountryC{$i}" id="passportCountryC{$i}"
                                    class="select2">
                                <option value="">##Countryissuingpassport##</option>
                                {foreach $objFunctions->CountryCodes() as $Country}
                                    <option value="{if $objDetail->SourceID['dept']=='10' || $objDetail->SourceID['dept']=='10' || $objDetail->SourceID['dept']=='10' }{$Country['code_two_letter']}{else}{$Country['code']}{/if}"
                                            {if $smarty.post.ZoneFlight neq 'Local' && $Country['code'] eq 'IRN'}selected="selected"{/if}>{$Country['titleFa']}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change {if $objDetail->isInternal eq true}noneIranian{/if}">
                            <input id="passportNumberC{$i}" type="text" placeholder="##Numpassport##"
                                   name="passportNumberC{$i}" class="UniqPassportNumber"
                                   onkeypress="return isAlfabetNumberKeyFields(event, 'passportNumberC{$i}')">
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change  {if $objDetail->isInternal eq true}noneIranian{/if}">
                            <input id="passportExpireC{$i}" class="gregorianFromTodayCalendar" type="text"
                                   placeholder="##Passportexpirydate##" name="passportExpireC{$i}">
                        </div>

                        <div class="alert_msg" id="messageC{$i}"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        {/for}

        {*فرم ثبت نام به تعداد نوزادان*}
        {for $i=1 to $objDetail->Inf_qty}
            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">
                <span class="titr_package">
                ##Baby##<i class="soap-icon-man-1"></i>
                            {if $objSession->IsLogin() and ($smarty.session.typeUser eq 'counter')}
                                <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change"
                                      onclick="setHidenFildnumberRow('I{$i}')">
                            <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i>##Passengerlist##
                        </span>
                            {/if}
                </span>
                <div class="panel-default-change site-border-main-color">
                    <div class="panel-heading-change">

                        <span class="hidden-xs-down">##Nation##:</span>

                        <span class="kindOfPasenger">
                            <label class="control--checkbox">
                                <span>##Iranian##</span>
                                <input type="radio" name="passengerNationalityI{$i}" id="passengerNationalityI{$i}"
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
                                <input type="radio" name="passengerNationalityI{$i}" id="passengerNationalityI{$i}"
                                       value="1" class="nationalityChange">
                                <div class="checkbox">
                                    <div class="filler"></div>
                                     <svg fill="#000000"  viewBox="0 0 30 30" >
                                    <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                                   </svg>
                                </div>
							</label>
                        </span>
                        <span class="member-price">
                            {assign var="showPice" value="0"}
                            {foreach key=direction item=item from=$objDetail->Direction}
                                {$showPice = $showPice + $objDetail->InfPrice[$direction]}
                            {/foreach}
                                <i>{$objFunctions->numberFormat($showPice)}</i> {$objDetail->AdtPriceType[$direction]}
                            </span>


                    </div>

                    <div class="clear"></div>

                    <div class="panel-body-change ">
                        <div class="s-u-passenger-item s-u-passenger-item-change">
                            <select id="genderI{$i}" name="genderI{$i}">
                                <option value="" disabled selected="selected">##Sex##</option>
                                <option value="Male">##Boy##</option>
                                <option value="Female">##Girl##</option>
                            </select>
                        </div>

                        <div class="s-u-passenger-item s-u-passenger-item-change">
                            <input id="nameEnI{$i}" type="text" placeholder="##Nameenglish##" name="nameEnI{$i}"
                                   onkeypress="return isAlfabetKeyFields(event, 'nameEnI{$i}')">
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change">
                            <input id="familyEnI{$i}" type="text" placeholder="##Familyenglish##"
                                   name="familyEnI{$i}"
                                   onkeypress="return isAlfabetKeyFields(event, 'familyEnI{$i}')">
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                            <input id="birthdayEnI{$i}" type="text" placeholder="##miladihappybirthday##"
                                   name="birthdayEnI{$i}" class="gregorianInfantBirthdayCalendar"
                                   readonly="readonly">
                        </div>

                        <div class="s-u-passenger-item s-u-passenger-item-change">
                            <input id="nameFaI{$i}" type="text" placeholder="##Namepersion##" name="nameFaI{$i}"
                                   onkeypress=" return persianLetters(event, 'nameFaI{$i}')" class="justpersian">
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change">
                            <input id="familyFaI{$i}" type="text" placeholder="##Familypersion##"
                                   name="familyFaI{$i}" onkeypress=" return persianLetters(event, 'familyFaI{$i}')"
                                   class="justpersian">
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                            <input id="birthdayI{$i}" type="text" placeholder="##shamsihappybirthday##"
                                   name="birthdayI{$i}"
                                   class="shamsiInfantBirthdayCalendar" readonly="readonly">
                        </div>

                        <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                            <input id="NationalCodeI{$i}" type="tel" placeholder="##Nationalnumber##"
                                   name="NationalCodeI{$i}"
                                   maxlength="10" class="UniqNationalCode"
                                   onkeyup="return checkNumber(event, 'NationalCodeI{$i}')">
                        </div>

                        <div class="s-u-passenger-item s-u-passenger-item-change select-meliat noneIranian">
                            <select name="passportCountryI{$i}" id="passportCountryI{$i}"
                                    class="select2">
                                <option value="">##Countryissuingشpassport##</option>
                                {foreach $objFunctions->CountryCodes() as $Country}
                                    <option value="{if $objDetail->SourceID['dept']=='10' || $objDetail->SourceID['dept']=='10' || $objDetail->SourceID['dept']=='10' }{$Country['code_two_letter']}{else}{$Country['code']}{/if}"
                                            {if $smarty.post.ZoneFlight neq 'Local' && $Country['code'] eq 'IRN'}selected="selected"{/if}>{$Country['titleFa']}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change  {if $objDetail->isInternal eq true}noneIranian{/if}">
                            <input id="passportNumberI{$i}" type="text" placeholder="##Numpassport##"
                                   name="passportNumberI{$i}" class="UniqPassportNumber"
                                   onkeypress="return isAlfabetNumberKeyFields(event, 'passportNumberI{$i}')">
                        </div>
                        <div class="s-u-passenger-item s-u-passenger-item-change  {if $objDetail->isInternal eq true}noneIranian{/if}">
                            <input id="passportExpireI{$i}" class="gregorianFromTodayCalendar" type="text"
                                   placeholder="##Passportexpirydate##" name="passportExpireI{$i}">
                        </div>

                        <div class="alert_msg" id="messageI{$i}"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        {/for}

        {if $objSession->IsLogin()}
            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">

                <span class="titr_package">##InformationSaler##

                </span>

                <div class="clear"></div>
                <div class="panel-default-change-Buyer boxInformationBuyer">
                    <div class="s-u-passenger-items widthInputInformationBuyer s-u-passenger-item-change no-star">
                        <input id="Mobile_buyer" type="tel" placeholder="##SalerPhone##" name="Mobile_buyer"
                               value="{$InfoMember.mobile}"
                               onkeypress="return checkNumber(event, 'Mobile_buyer')"/>
                    </div>

                    <div class="s-u-passenger-items widthInputInformationBuyer padl0 s-u-passenger-item-change no-star">
                        <input id="Email_buyer" type="email" placeholder="##Emailbuyer##" name="Email_buyer"
                               value="{$InfoMember.email}"/>
                    </div>
                    <div id="errorInfo"></div>
                </div>
                <div class="clear"></div>
            </div>
        {/if}

        {if not $objSession->IsLogin()}
            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer  first">
                <span class="titr_package">
                    ##InformationSaler##
                </span>
                <input type="hidden" name="UsageNotLogin" value="yes" id="UsageNotLogin">
                <div class="clear"></div>
                <div class="panel-default-change-Buyer">
                    <div class="s-u-passenger-items
                         {($smarty.const.SOFTWARE_LANG != 'fa') ? 'display-none-after':''} s-u-passenger-item-change">
                        <input id="Mobile" type="tel" placeholder="##Phonenumber##" name="Mobile" class=""
                               onkeypress="return checkNumber(event, 'Mobile')">
                    </div>
                    <div class="s-u-passenger-items s-u-passenger-item-change s-u-passenger-items_Telephone">
                        <input id="Telephone" type="tel" placeholder="##Phone##" name="Telephone" class=""
                               onkeypress="return checkNumber(event, 'Telephone')">
                    </div>
                    <div class="{($smarty.const.SOFTWARE_LANG != 'fa') ? 's-u-passenger-item':''}
                         s-u-passenger-items s-u-passenger-item-change padl0 s-u-passenger-items_email">
                        <input id="Email" type="email" placeholder="##Email##(##optional##)" name="Email" class="">
                    </div>
                    <div class="alert_msg" id="messageInfo"></div>
                </div>
                <div class="clear"></div>
            </div>
        {/if}

        <div class="clear"></div>
        <input type="hidden" id="numberRow" value="0">
        <input type="hidden" id="factorNumber" name="factorNumber" value="{$smarty.post.factorNumberHotel}">
        <input type="hidden" id="Id_Select_Room" name="Id_Select_Room" value="{$smarty.post.roomIdSelected}">
        <input type="hidden" value="{$objDetail->temporary}" name="temporary" id="temporary">
        <input type="hidden" value="" name="RequestNumber_TwoWay" id="RequestNumber_TwoWay">
        <input type="hidden" value="{$smarty.post.RequestNumberHotel}" name="RequestNumberHotel"
               id="RequestNumberHotel">
        <input type="hidden" value="" name="IdMember" id="IdMember">
        <input type="hidden" value="{if $smarty.post.isInternal eq true}api{else}externalApi {/if}"
               name="typeApplication" id="typeApplication">
        <input type="hidden" value="package" name="typeReserve" id="typeReserve">
        <input type="hidden" id="factor_number_Flight" value="" name="factor_number_Flight">
        <input type="hidden" id="SourceIdFlight" name="SourceIdFlight" value='{$objDetail->SourceID|json_encode}'>
        <input type="hidden" value="{$smarty.post.ZoneFlight}" name="ZoneFlight" id="ZoneFlight">
        <input type="hidden" value="{$objDetail->CurrencyCode}" name="CurrencyCode" id="CurrencyCode">


        <div class="btns_factors_n">


            <div class="btn_research__">
                <!-- <a href="" onclick="return false" class="f-loader-check loaderpassengers"  style="display:none"></a> -->
                <button type="button" class="loading_on_click cancel-passenger"
                        onclick="BackToHome('{$objDetail->reSearchAddress}'); return false">##Repeatsearch##
                </button>

            </div>

            <div class="passengersDetailLocal_next">
                <a href="" onclick="return false" class="f-loader-check loaderpassengers" id="loader_check"
                   style="display:none"></a>

                <input type="button"
                       onclick="sendDataToPrereservePackage('{$objDetail->flightMKTime}', '{$objDetail->Adt_qty}', '{$objDetail->Chd_qty}', '{$objDetail->Inf_qty}', '{$objDetail->temporary}')"
                       value="##NextStepInvoice##"
                       class="s-u-submit-passenger s-u-select-flight-change site-bg-main-color s-u-submit-passenger-Buyer"
                       id="send_data">
            </div>

        </div>
    </form>


</div>
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
            <span class="timeout-modal__title site-main-text-color">##searchTitleLoder##!</span>

            <p class="timeout-modal__flight">
                ##OrderSearceBeginning##
            </p>
            <a class="btn btn_back_home site-main-text-color" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}">بازگشت به صفحه اصلی</a>
        </div>
    </div>
</div>

{literal}
    <script src="assets/js/jquery.counter.js" type="text/javascript"></script>
<!-- counter menu -->
    <script src="assets/js/classie.js"></script>
    <script src="assets/js/sidebarEffects.js"></script>

<!-- jQuery Site Scipts -->
    <script src="assets/js/script.js"></script>

    <script src="assets/js/jdate.min.js" type="text/javascript"></script>
    <script src="assets/js/jdate.js" type="text/javascript"></script>
    <script src="assets/js/jquery.counter.js" type="text/javascript"></script>
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


        $('ul.tabs li').on("click", function () {

            $(this).siblings().removeClass("current");
            $(this).parent("ul.tabs").siblings(".tab-content").removeClass("current");


            var tab_id = $(this).attr('data-tab');


            $(this).addClass('current');
            $(this).parent("ul.tabs").siblings("#" + tab_id).addClass("current");

        });


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

    });

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
{/literal}