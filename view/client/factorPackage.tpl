{*{$smarty.post|json_encode}*}
<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>
{load_presentation_object filename="members" assign="objMember"}
{load_presentation_object filename="package" assign="objPackage"}
{load_presentation_object filename="passengersDetailLocal" assign="objDetail"}
{$objMember->get()}
{assign var="InfoCounter" value=$objFunctions->infoCounterType($objMember->list['fk_counter_type_id'])}
<div id="flight_factorLocal" class="s-u-content-result ">
    <div id="lightboxContainer" class="lightboxContainerOpacity "></div>
    <div class="Clr"></div>



        <div class="s-u-result-wrapper">
            <span>

            </span>
            <ul>
                <div id="fligh_Detail_local" class="s-u-content-result">
                    {assign var="hotelInfo" value=$objPackage->getDataBookHotel($smarty.post.factorNumberHotel)}

                    {assign var="direction" value='TwoWay'}


                        <div class="hotel_section">

                             <span class="titr_package">
             ##Invoice##
        </span>


                            <div class="image_hotel">
                                <img src="{$hotelInfo['hotel_pictures']}" class="w-100">
                            </div>
                            <div class="content_hotel">
                                <div class="title_h">اطلاعات هتل</div>
                                <div class="name_h info_h"><span
                                            class="site-main-text-color">نام هتل : </span>{$hotelInfo['hotel_name']}</div>
                                <div class="city_h info_h"><span
                                            class="site-main-text-color">نام شهر مقصد : </span>{$hotelInfo['city_name']}</div>
                                <div class="addres_h info_h"><span
                                            class="site-main-text-color">آدرس هتل : </span>{$hotelInfo['hotel_address']}</div>
                                <div class="dateStart_h info_h"><span
                                            class="site-main-text-color">تاریخ شروع : </span><span>{$hotelInfo['start_date']}</span>:-
                                    تاریخ پایان<span>{$hotelInfo['end_date']}</span>
                                </div>
                                <div class="night_h info_h"><span
                                            class="site-main-text-color">تعداد شب : </span><span>{$hotelInfo['number_night']}</span>
                                </div>
                            </div>
                        </div>

                        <div class="s-u-passenger-wrapper">



                                    <div class="titr_package">اطلاعات پرواز</div>

                                        {if $objDetail->ArrayDeptForeign neq ''}
                                            <div class="flight_section">
                                            <div class=" international-available-airlines  ">

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
                                                            <span class="flight-type">{if $objDetail->FlightType[$direction] eq 'system'}##SystemType##{else} ##CharterType##{/if}</span>
                                                            <span class="sit-class">{$objDetail->SeatClass[$direction]}</span>
                                                            <span class="tavaghof">{if $objDetail->countRoute[$direction] gt '1'}{($objDetail->ArrayDeptForeign|@count)-1} ##Stopi##{else} ##Nostop##  {/if}</span>
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



                        </div>




                </div>
            </ul>


        </div>

        <div class="main-Content-bottom Dash-ContentL-B">
            <div class="main-Content-bottom-table Dash-ContentL-B-Table">
                <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title l-p-p-header l-p-p-header-change site-bg-main-color">
                    <i class="icon-table"></i>
                    <h3>##PassengersList##</h3>
                    <p>
                        (
                        <i> {$objDetail->Adt_qty} ##Adult## </i> -
                        <i>{$objDetail->Chd_qty} ##Child##</i> -
                        <i> {$objDetail->Inf_qty} ##Baby## </i>)
                    </p>
                </div>
                <div class="table-responsive">
                    <table id="passengers" class="display" cellspacing="0" width="100%">

                        <thead>
                        <tr>
                            <th>##Ages##</th>
                            <th>##Name##</th>
                            <th>##Family##</th>
                            <th>##Nameenglish##</th>
                            <th>##Familyenglish##</th>
                            <th>##Happybirthday##</th>
                            <th>##Numpassport##/##Nationalnumber##</th>
                        </tr>
                        </thead>
                        <tbody>
                        {*{$objFactor->direction}*}
                        {*<pre>{$FlightSelected[$objFactor->direction]|print_r}</pre>*}

                        {assign var="Passengers" value=$objPackage->getDataFlight($smarty.post.RequestNumberFlight)}
                        {foreach $Passengers as $KeyFlight=>$Flight}
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
                                <td>
                                    <p>{$Flight['passenger_name']}</p>
                                </td>
                                <td>
                                    <p>{$Flight['passenger_family']}</p>
                                </td>
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
                                <td>
                                    <p>
                                        {if $Flight['passenger_national_code'] eq  '0000000000' && $Flight['passportCountry'] neq 'IRN'}
                                            {assign var="nationalCodePreson" value=$Flight['passportNumber']}
                                        {else}
                                            {assign var="nationalCodePreson" value=$Flight['passenger_national_code']}
                                        {/if}

                                    </p>
                                </td>

                            </tr>
                        {/foreach}
                        <tr>
                            {assign var="priceTotalCurrencyCalculated" value=$objPackage->CalculatePackagePrice($smarty.post.RequestNumberFlight,$smarty.post.factorNumberHotel)}
                            <td class="TotalPrice_td_2">
                                <p class="last-price-factor-local">
                                    ##TotalPrice## : {$priceTotalCurrencyCalculated['total']|number_format}
                                    &nbsp; ریال</p>
                            </td>

                            <td class="TotalPrice_td_2">
                                <p class="last-price-factor-local">
                                    ##FlightPrice## : {$priceTotalCurrencyCalculated['priceFlight']|number_format}
                                    &nbsp; ریال</p>
                            </td>

                            <td class="TotalPrice_td_2">
                                <p class="last-price-factor-local">
                                    ##HotelPrice## : {$priceTotalCurrencyCalculated['priceHotel']|number_format}
                                    &nbsp; ریال</p>
                            </td>
                            <td colspan="4" class="txtLeft TotalPrice_td"></td>

                        </tr>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>

</div>
<div class="s-u-result-wrapper">
    <div class="s-u-result-item-change direcR iranR txt12 txtRed s-u-result-item-RulsCheck">
        <div style="width: 100%">
            <p class="s-u-result-item-RulsCheck-item">
                <input  class="FilterHoteltype Show_by_filters FilterHoteltypeName-top" id="RulsCheck"
                       name="heck_list1" value="" type="checkbox">
                <label class="FilterHoteltypeName site-main-text-color-a " for="RulsCheck">
                    <a class="txtRed" href="{$smarty.const.URL_RULS}" target="_blank">##Seerules##</a>
                    ##IhavestudiedIhavenoobjection##
                </label>
            </p>
        </div>
    </div>
</div>

<div class="btns_factors_n">
    <div class="btn_research__">
        <!-- <a href="" onclick="return false" class="f-loader-check loaderpassengers"  style="display:none"></a> -->
        <button type="button" class="loading_on_click cancel-passenger"
                onclick="BackToHome('{$objDetail->reSearchAddress}'); return false">
            ##Repeatsearch## <i class="fa fa-refresh"></i></button>

    </div>
    <div class="passengersDetailLocal_next">
        <a href="" onclick="return false" class="f-loader-check loaderfactors" id="loader_check"
           style="display:none"></a>
        <a class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-bg-main-color factorLocal-btn"
           id="ok"
           onclick="pricePay('','')">##Approvefinal##</a>
    </div>
</div>

<!-- bank connect -->
{*<div class="main-pay-content">*}
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 s-u-passenger-wrapper-change "
     style="padding: 0">

    <!-- payment methods drop down -->
    {assign var="memberCreditPermition" value="0"}
    {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] == '5'}
        {$memberCreditPermition = "1"}
    {/if}

    {assign var="counterCreditPermition" value="0"}
    {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] != '5'}
        {$counterCreditPermition = "1"}
    {/if}

    {assign var="PricePackage" value=$objPackage->calculatePricePackage($smarty.post.RequestNumberFlight,$smarty.post.factorNumberHotel)}

    {assign var="bankInputs" value=['flag' => 'check_credit_package', 'requestNumberFlight' => $smarty.post.RequestNumberFlight,'factorNumberHotel' => $smarty.post.factorNumberHotel,'typeTrip' => 'package', 'paymentPrice' => $PricePackage]}
    {assign var="bankAction" value="`$smarty.const.ROOT_ADDRESS`/goBankPackage"}

    {assign var="creditInputs" value=['flag' => 'buyByCreditPackage',  'requestNumberFlight' => $smarty.post.RequestNumberFlight,'factorNumber' => $smarty.post.factorNumberHotel]}
    {assign var="creditAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankPackage"}

    {assign var="currencyPermition" value="0"}
    {if $smarty.const.ISCURRENCY && $smarty.post.CurrencyCode > 0}
        {$currencyPermition = "1"}
        {assign var="currencyInputs" value=['flag' => 'check_credit','requestNumberFlight' => $smarty.post.RequestNumberFlight,'factorNumber' => $smarty.post.factorNumberHotel,  'amount' => $objDetail->Amount, 'currencyCode' => $smarty.post.CurrencyCode]}
        {assign var="currencyAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankPackage"}
    {/if}

    <!-- payment methods drop down -->
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`paymentMethods.tpl"}

</div>

<!--BACK TO TOP BUTTON-->
<div class="backToTop"></div>

