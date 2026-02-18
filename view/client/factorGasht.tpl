<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>
{load_presentation_object filename="factorGasht" assign="objFactor"}
{$objFactor->registerPassengersGasht()}

{load_presentation_object filename="members" assign="objMember"}
{$objMember->get()}
{assign var="InfoMember" value=$objFunctions->infoMember($objSession->getUserId())}
{assign var="InfoCounter" value=$objFunctions->infoCounterType($InfoMember.fk_counter_type_id)}

{assign var="infoBank" value=$objFunctions->InfoBank()}
<div class="container-fluid">
    <div id="steps">
        <div class="steps_items">
            <div class="step done ">
                <span class=""><i class="fa fa-check"></i></span>
                <h3>##Reserved##</h3>
            </div>
            <i class="separator  done"></i>
            <div class="step done">
        <span class="flat_icon_airplane">
     <i class="fa fa-check"></i>
            </span>
                <h3>##PassengersInformation##</h3>

            </div>
            <i class="separator donetoactive"></i>
            <div class="step active ">
             <span class="flat_icon_airplane">
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="25" height="25">
    <g id="Contact_form" data-name="Contact form">
        <path d="M20.293,30.707A1,1,0,0,1,20,30v3h3a1,1,0,0,1-.707-.293Z"></path>
        <path d="M21,29H20v1a1,1,0,0,1,1-1Z"></path>
        <path d="M23,20.586,24.586,19H21a1,1,0,0,1,.707.293Z"></path>
        <path d="M21,39H20v1a1,1,0,0,1,1-1Z"></path>
        <path d="M23,30.586,24.586,29H21a1,1,0,0,1,.707.293Z"></path>
        <path d="M20.293,40.707A1,1,0,0,1,20,40v3h3a1,1,0,0,1-.707-.293Z"></path>
        <path d="M23,40.586,24.586,39H21a1,1,0,0,1,.707.293Z"></path>
        <path d="M21,19H20v1a1,1,0,0,1,1-1Z"></path>
        <path d="M49.351,35.187,52,37.836V4H14V49H47.183A7.243,7.243,0,0,1,48.331,45.5l-4.638-4.638a4.032,4.032,0,0,1,0-5.661A4.1,4.1,0,0,1,49.351,35.187ZM47,21H31a1,1,0,0,1,0-2H47a1,1,0,0,1,0,2Zm1,3a1,1,0,0,1-1,1H31a1,1,0,0,1,0-2H47A1,1,0,0,1,48,24ZM18,7a1,1,0,0,1,1-1H47a1,1,0,0,1,1,1v6a1,1,0,0,1-1,1H19a1,1,0,0,1-1-1ZM40,35H31a1,1,0,0,1,0-2h9a1,1,0,0,1,0,2Zm1,5a1,1,0,0,1-1,1H31a1,1,0,0,1,0-2h9A1,1,0,0,1,41,40ZM28.707,37.707l-5,5A1,1,0,0,1,23,43h2a1,1,0,0,1,0,2H19a1,1,0,0,1-1-1V38a1,1,0,0,1,1-1h6a1,1,0,0,1,.931.655l1.362-1.362a1,1,0,0,1,1.414,1.414Zm0-10-5,5A1,1,0,0,1,23,33h2a1,1,0,0,1,0,2H19a1,1,0,0,1-1-1V28a1,1,0,0,1,1-1h6a1,1,0,0,1,.931.655l1.362-1.362a1,1,0,0,1,1.414,1.414Zm0-10-5,5A1,1,0,0,1,23,23h2a1,1,0,0,1,0,2H19a1,1,0,0,1-1-1V18a1,1,0,0,1,1-1h6a1,1,0,0,1,.931.655l1.362-1.362a1,1,0,0,1,1.414,1.414ZM43,43a1,1,0,0,1,0,2H31a1,1,0,0,1,0-2ZM31,31a1,1,0,0,1,0-2H47a1,1,0,0,1,0,2Z"></path>
        <path d="M58.01,61,58,59.616a2.985,2.985,0,0,1,.5-1.678l.653-.981A4.979,4.979,0,0,0,60,54.183v-13.7a6.959,6.959,0,0,0-2.05-4.95L54,31.584v8.252l2.427,2.427a1,1,0,0,1-1.414,1.414l-7.07-7.07a2.071,2.071,0,0,0-2.841.006,2.022,2.022,0,0,0,.008,2.833l5.247,5.247a1,1,0,0,1,.053,1.357,5.3,5.3,0,0,0-.1,6.746l.465.575a1,1,0,1,1-1.554,1.258l-.47-.58A7.3,7.3,0,0,1,47.316,51H43.905a8.915,8.915,0,0,0,1.356,6.584l.572.863A1,1,0,0,1,46,59v2Z"></path>
        <rect x="20" y="8" width="26" height="4"></rect>
        <path d="M20.293,20.707A1,1,0,0,1,20,20v3h3a1,1,0,0,1-.707-.293Z"></path>
    </g>
</svg>
             </span>
                <h3>##Approvefinal##</h3>
            </div>
            <i class="separator"></i>
            <div class="step">
            <span class="flat_icon_airplane">
           <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                width="128.000000pt" height="128.000000pt" viewBox="0 0 128.000000 128.000000"
                preserveAspectRatio="xMidYMid meet">

<g transform="translate(0.000000,128.000000) scale(0.100000,-0.100000)"
   fill="#000000" stroke="none">
<path d="M253 1138 c-4 -7 -25 -53 -45 -102 -42 -98 -41 -102 21 -131 47 -21
69 -63 55 -103 -9 -27 -11 -27 -114 -30 -68 -2 -107 -7 -112 -15 -13 -20 -9
-202 4 -215 7 -7 33 -12 58 -12 70 0 108 -52 84 -115 -9 -24 -58 -45 -102 -45
-27 0 -42 -5 -46 -16 -11 -29 -7 -199 6 -212 17 -17 1139 -17 1156 0 13 13 17
183 6 212 -4 11 -19 16 -46 16 -44 0 -93 21 -102 45 -24 64 14 115 85 115 25
0 50 5 57 12 8 8 12 46 12 104 0 100 -5 124 -26 124 -7 0 -221 85 -474 190
-254 105 -463 190 -465 190 -2 0 -7 -6 -12 -12z m397 -203 c193 -80 359 -149
368 -155 11 -6 -99 -9 -334 -10 l-352 0 5 43 c7 55 -16 101 -63 129 -19 11
-34 23 -34 28 0 16 43 110 51 110 4 0 166 -65 359 -145z m520 -279 l0 -64 -40
-7 c-132 -22 -157 -190 -38 -251 15 -8 38 -14 53 -14 24 0 25 -2 25 -65 l0
-65 -530 0 -530 0 0 65 c0 63 1 65 25 65 15 0 38 6 53 14 119 61 94 229 -38
251 l-40 7 0 64 0 64 530 0 530 0 0 -64z"/>
<path d="M862 658 c-32 -32 -1 -116 33 -88 26 22 14 100 -15 100 -3 0 -11 -5
-18 -12z"/>
<path d="M376 601 c-4 -5 -3 -16 0 -25 5 -14 31 -16 184 -16 181 0 195 3 182
38 -5 14 -357 18 -366 3z"/>
<path d="M862 498 c-32 -32 -1 -116 33 -88 26 22 14 100 -15 100 -3 0 -11 -5
-18 -12z"/>
<path d="M376 464 c-3 -9 -4 -20 0 -25 9 -15 361 -12 367 4 12 34 -3 37 -183
37 -153 0 -179 -2 -184 -16z"/>
<path d="M380 335 c-10 -12 -10 -18 0 -30 18 -22 342 -22 360 0 10 12 10 18 0
30 -10 12 -43 15 -180 15 -137 0 -170 -3 -180 -15z"/>
<path d="M862 338 c-32 -32 -1 -116 33 -88 26 22 14 100 -15 100 -3 0 -11 -5
-18 -12z"/>
</g>
</svg>

            </span>
                <h3>##TicketReservation##</h3>
            </div>
        </div>

        <div class="counter d-none counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"
             style="direction: ltr"> {$smarty.post.time_remmaining}</div>
    </div>



    <div class="s-u-content-result">
        {*<div>
            <div class="counter d-none counter-analog" data-direction="down" data-format="59:59" data-stop="00:00" style="direction: ltr"> {$smarty.post.time_remmaining}</div>
        </div>*}
        <div id="lightboxContainer" class="lightboxContainerOpacity" style="display: none"></div>

        {*<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 s-u-passenger-wrapper-change " >
            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                ##Note## <i class="zmdi zmdi-alert-circle mart10  zmdi-hc-fw"></i>
            </span>
            <div class="s-u-result-wrapper">
                <span class="s-u-result-item-change direcR iranR txt12 txtRed">
                    ##DontReloadPageInfo##
                </span>
            </div>
        </div>*}

        <div class="Clr"></div>

        <div class="s-u-passenger-wrapper-change">
            <div class="s-u-p-f-container s-u-result-item-change ">

            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change s-u-last-p-bozorgsal-change-edit site-main-text-color">
            <i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart10"></i>     ##Invoice##
            </span>

                <div class="s-u-result-wrapper ">
                    <div class="insurance-passenger-main-box">
                        <div class=" insurance-passenger-box-content">
                            <div class="insurance-passenger-content">
                                <div class=" gasht_content_passenger">
                                    <div class="hotel-booking-room-text">
                                        <b class="hotel-booking-room-name"> {$objFactor->passengerArr['passenger_serviceName']} </b>


                                        <span class="hotel-booking-room-content-location ">
                 <a> {$objFactor->passengerArr['passenger_serviceComment']} </a>
               </span>
                                    </div>

                                    <div class="hotel-booking-room-text">
                                        <ul>
                                            <li class="hotel-check-text"><i class="fa fa-calendar-times-o"></i> ##Date##          {if $objFactor->passengerArr['passenger_serviceRequestType'] eq '0'}
                                                    ##Gasht##
                                                {else}
                                                    ##transfer##
                                                {/if} :
                                                <span class="hotel-check-date" dir="rtl">{$objFactor->passengerArr['passenger_serviceRequestDate']}</span></li>
                                            <li class="hotel-check-text">
                                                <i class="fa fa-map"></i> ##City##              {if $objFactor->passengerArr['passenger_serviceRequestType'] eq '0'}
                                                    ##Gasht##
                                                {else}
                                                    ##transfer##
                                                {/if} :
                                                <span class="hotel-check-date" dir="rtl">{$objFactor->passengerArr['passenger_serviceCityName']}</span></li>
                                            {if $objFactor->passengerArr['passenger_serviceDiscount']  neq 0}
                                                <li class="hotel-check-text">


                                                    <i class="fa fa-dollar"></i> ##Discount## :
                                                    <span class="hotel-check-date" data-amount="{$objFactor->passengerArr['passenger_serviceDiscount']}" dir="rtl">%{$objFactor->passengerArr['passenger_serviceDiscount']}</span></li>
                                            {/if}
                                            {assign var="totalMainCurrency" value=$objFunctions->CurrencyCalculate($objFactor->passengerArr['passenger_servicePriceAfterOff'],$objFactor->passengerArr['currency_code'])}
                                            <li class="hotel-check-text">
                                                <i class="fa fa-dollar"></i> ##Price## :
                                                <span class="hotel-check-date" dir="rtl">{$objFunctions->numberFormat($totalMainCurrency.AmountCurrency)}</span> {$totalMainCurrency.TypeCurrency}</li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="main-Content-bottom Dash-ContentL-B">
            <div class="main-Content-bottom-table Dash-ContentL-B-Table">
                <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title l-p-p-header l-p-p-header-change site-bg-main-color">
                    <i class="icon-table"></i><h3>##RequestDetails##</h3>

                </div>

                <table id="passengers" cellspacing="0" width="100%">

                    <thead>
                    <tr>
                        <th>##Namepassenger##</th>
                        <th>##Familypassenger## </th>
                        <th> ##PhonenumberTraveler##</th>
                        <th>##Namehotel##</th>
                        <th>##Arrivaldatehotel##</th>
                        <th> ##Exitdatehotel##</th>
                        <th>##RunTime##</th>
                        <th>##Returntime##</th>
                        <th>##TransportVehicle##</th>
                        {if $objFactor->passengerArr['passenger_travelVehicle'] !='bus'}
                            <th>##Number##
                                {if $objFactor->passengerArr['passenger_travelVehicle'] =='train'}
                                    ##Train##
                                {elseif $objFactor->passengerArr['passenger_travelVehicle'] =='airplane'}
                                    ##Airplane##
                                {/if}
                            </th>
                        {/if}
                        <th>##Count##</th>
                    </tr>
                    </thead>
                    <tbody>


                    <tr>
                        <td><p>{$objFactor->passengerArr['passenger_name']}</p></td>
                        <td><p>{$objFactor->passengerArr['passenger_family']}</p></td>
                        <td><p>{$objFactor->passengerArr['passenger_mobile']}</p></td>
                        <td><p>{$objFactor->passengerArr['passenger_HotelName']}</p></td>
                        <td><p>{$objFactor->passengerArr['passenger_entryDate']}</p></td>
                        <td><p>{$objFactor->passengerArr['passenger_departureDate']}</p></td>
                        <td><p>{$objFactor->passengerArr['passenger_startTime']}</p></td>
                        <td><p>{$objFactor->passengerArr['passenger_endTime']}</p></td>
                        <td><p>{if $objFactor->passengerArr['passenger_travelVehicle'] =='train'}
                                    ##Train##
                                {elseif $objFactor->passengerArr['passenger_travelVehicle'] =='airplane'}
                                    ##Airplane##
                                {else}
                                    ##Bus##
                                {/if}</p></td>
                        {if $objFactor->passengerArr['passenger_travelVehicle'] !='bus'}
                            <td><p>{$objFactor->passengerArr['passenger_Voucher']}</p></td>
                        {/if}
                        <td><p>{$objFactor->passengerArr['passenger_number']}</p></td>
                    </tr>


                    <tr>
                        <td {if $objFactor->passengerArr['passenger_travelVehicle'] !='bus'} colspan="10" {else}colspan="9"{/if}class="txtLeft" >##TotalPrice## :</td>
                        <td><p>{$objFunctions->numberFormat($objFactor->passengerArr['passenger_number']*{$totalMainCurrency.AmountCurrency})} {$totalMainCurrency.TypeCurrency}</p></td>
                    </tr>
                    </tbody>


                </table>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 s-u-passenger-wrapper-change  " style="padding: 0">
            <div class="s-u-result-wrapper">
                <div class="s-u-result-item-change direcR iranR txt12 txtRed s-u-result-item-RulsCheck">
                    <div style="text-align: right">
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
                                        <input type="hidden" name="priceWithoutDiscountCode" id="priceWithoutDiscountCode" value="{($objFactor->passengerArr['passenger_number']*{$totalMainCurrency.AmountCurrency})}" />
                                        <button type="button" onclick="setDiscountCode('{$objFactor->serviceTitle}')" class="site-secondary-text-color site-main-button-flat-color iranR discount-code-btn">##Reviewapplycode##  </button>
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
                                                <span class="price__amount-price price-after-discount-code">{$objFunctions->numberFormat($objFactor->passengerArr['passenger_number']*{$totalMainCurrency.AmountCurrency})}</span>
                                                <span class="price__unit-price">##Rial##</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {/if}
                        <p class="s-u-result-item-RulsCheck-item">
                            <input class="FilterHoteltype Show_by_filters FilterHoteltypeName-top" id="RulsCheck" name="heck_list1" value="" type="checkbox">
                            <label class="FilterHoteltypeName site-main-text-color-a " for="RulsCheck">
                                <a class="site-main-text-color" href="{$smarty.const.URL_RULS}" target="_blank">##Seerules## </a> ##IhavestudiedIhavenoobjection##
                            </label>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="btns_factors_n">

        <div class="btn_research__" >
            <input type="button"  value="##Optout##" class="cancel-passenger"  onclick="BackToHome(); return false">
        </div>
            <div class="passengersDetailLocal_next">
                <a href="" onclick="return false" class="f-loader-check loaderfactors"  id="loader_check" style="display:none"></a>
                <span class="s-u-select-flight-change site-bg-main-color factorLocal-btn" id="final_ok_and_insert_passenger" onclick="preReserveGasht({$objFactor->factor_number})">##Approvefinal##</span>
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

            {assign var="bankInputs" value=['flag' => 'check_credit_gasht', 'factorNumber' => $objFactor->factor_number, 'typeTrip' => 'gashtTransfer', 'serviceType' => $objFactor->serviceTitle]}
            {assign var="bankAction" value="`$smarty.const.ROOT_ADDRESS`/goBankGasht"}

            {assign var="creditInputs" value=['flag' => 'buyByCreditGasht', 'factorNumber' => $objFactor->factor_number]}
            {assign var="creditAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankGasht"}

            {assign var="currencyPermition" value="0"}
            {if $smarty.const.ISCURRENCY && $smarty.post.CurrencyCode > 0}
                {$currencyPermition = "1"}
                {assign var="currencyInputs" value=['flag' => 'check_credit_gasht', 'factorNumber' => $objFactor->factor_number, 'serviceType' => $objFactor->serviceTitle, 'amount' => ($objFactor->passengerArr['passenger_number']*$totalMainCurrency.AmountCurrency), 'currencyCode' => $smarty.post.CurrencyCode]}
                {assign var="currencyAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankGasht"}
            {/if}

            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`paymentMethods.tpl"}
            <!-- payment methods drop down -->


        </div>

    </div>

</div>


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
{/literal}
{literal}
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
/*    $('.counter').on('counterStop', function () {
        $.confirm({
            theme: 'supervan' ,// 'material', 'bootstrap'
            title: '##Update##',
            icon: 'fa fa-clock',
            content: '##Yourreservationperiodexpiredmakereservationbeginning##',
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
</script>
    <script src="assets/js/script.js"></script>

<!-- modal login    -->
    <script type="text/javascript" src="assets/js/modal-login.js"></script>
{/literal}