<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>


{assign var="typeApplication" value=$smarty.post.typeApplication}
{assign var="factorNumber" value=$smarty.post.factorNumber}
{assign var="idMember" value=$smarty.post.idMember}
{assign var="currencyCode" value=$smarty.post.CurrencyCode}

{load_presentation_object filename="resultExternalHotel" assign="objExternalHotel"}
{load_presentation_object filename="factorExternalHotel" assign="objFactor"}
{$objFactor->registerPassengersHotel()}
{assign var="reserveInfo" value=$objExternalHotel->getPreInvoice($factorNumber)}




{assign var="infoBank" value=$objFunctions->InfoBank()}
{load_presentation_object filename="members" assign="objMember"}
{$objMember->get()}




{if $objFactor->error eq true}
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 s-u-passenger-wrapper-change">
            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
               ##Note## <i class="zmdi zmdi-alert-circle mart10  zmdi-hc-fw"></i>
            </span>
        <div class="s-u-result-wrapper">
            <span class="s-u-result-item-change direcR iranR txt12 txtRed">{$objFactor->errorMessage}</span>
        </div>
    </div>
{else}


    <div class="s-u-content-result">

        <div>
            <div class="counter d-none counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"
                 style="direction: ltr">{$smarty.post.time_remmaining}</div>
        </div>
        <div id="lightboxContainer" class="lightboxContainerOpacity"></div>


        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 s-u-passenger-wrapper-change ">
        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
            ##Note## <i class="zmdi zmdi-alert-circle mart10  zmdi-hc-fw"></i>
        </span>

            <div class="s-u-result-wrapper">
            <span class="s-u-result-item-change direcR iranR txt12 txtRed">
                ##DontReloadPageInfo##
            </span>
            </div>

            <div class="s-u-result-wrapper">
                <span class="s-u-result-item-change direcR iranR txt12 txtRed">##Dearguestrequestapprovedbookingfee##</span>
                <span class="s-u-result-item-change direcR iranR txt12 txtRed">##Likelypricepaychangepaymentprice##</span>
            </div>

        </div>
        <div class="Clr"></div>


        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 s-u-passenger-wrapper-change">
            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">##Youbookingfollowinghotel##<i
                        class="ravis-icon-hotel mart10  zmdi-hc-fw"></i></span>

            <div class="hotel-booking-room marb0">

                <div class="col-md-3 nopad">
                    <div class="hotel-booking-room-image">
                        <a>
                            <img src="{$reserveInfo['image_url']}" alt="hotel-image">
                        </a>
                    </div>
                </div>

                <div class="col-md-9 ">
                    <div class="hotel-booking-room-content">
                        <div class="hotel-booking-room-text">
                            <b class="hotel-booking-room-name"> {$reserveInfo['hotel_persian_name']} </b>

                            <span class="hotel-star">

                                {if $reserveInfo['hotel_stars'] gt 0}
                                    {for $s=1 to $reserveInfo['hotel_stars']}
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    {/for}
                                    {for $ss=$s to 5}
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                {/for}
                                {else}
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                {/if}
                            </span>

                            <span class="hotel-booking-room-content-location fa fa-map-marker ">
                         <a href="#"> {$reserveInfo['hotel_address']} </a>
                       </span>
                        </div>

                        <div class="hotel-booking-room-text">
                            <ul>
                                <li class="hotel-check-text"><i class="fa fa-calendar-times-o"></i> ##Enterdate## :
                                    <span class="hotel-check-date" dir="rtl">{$reserveInfo['start_date']}</span></li>
                                <li class="hotel-check-text"><i class="fa fa-calendar-check-o"></i> ##Exitdate## :
                                    <span class="hotel-check-date" dir="rtl">{$reserveInfo['end_date']}</span></li>
                                <li class="hotel-check-text"><i class="fa fa-bed"></i> {$reserveInfo['night']}
                                    ##Timenight##
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            <div class="clear"></div>


            <div class="hotel-booking-room">

                <h4 class="tableOrderHeadTitle site-bg-main-color">
                    <span>##Listroom##</span>
                </h4>

                <div class="rp-tableOrder site-border-main-color">
                    <table>
                        <thead>
                        <tr class="Hotel-tableOrderHead">
                            <th class="Hotel-tableOrderHead-c1">##Typeroom##</th>
                            <th class="Hotel-tableOrderHead-c5">##Serviceroom##</th>
                            <th class="Hotel-tableOrderHead-c2">##CapacityRoom##</th>
                            <th class="Hotel-tableOrderHead-c7">##TotalPrice## (##Rial##)</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td class="Hotel-tableOrderHead">
                                {foreach $reserveInfo['room_list'] as $i=>$item}
                                    <h5 class="roomsTitle">{$item['RoomName']}</h5>
                                {/foreach}
                            </td>

                            <td class="Hotel-tableOrderHead">
                                <ul class="HotelRoomFeatureList">
                                    {foreach $reserveInfo['room_list'] as $item}
                                        <li class="Breakfast">{$objExternalHotel->getFacilityRoomPersian($item['BreakfastType'])}</li>
                                    {/foreach}
                                </ul>
                            </td>

                            <td class="Hotel-tableOrderHead">
                                <div class="roomCapacity">
                                    <i class="fa fa-male txt15"></i><i class="inIcon">x</i>
                                    <i class="txtIcon ng-binding">{$objExternalHotel->numberOfRooms['adultCount']}  </i>
                                    {if $objExternalHotel->numberOfRooms['adultCount'] neq '0'}
                                        <br>
                                        <i class="fa fa-child txt15"></i>
                                        <i class="inIcon">x</i>
                                        <i class="txtIcon ng-binding">{$objExternalHotel->numberOfRooms['childrenCount']}  </i>
                                    {/if}
                                </div>
                            </td>
                            {$amountCurrency = $objFunctions->CurrencyCalculate($objFactor->paymentPrice, $currencyCode)}
                            <td class="Hotel-tableOrderHead">
                                <div class="roomFinalPrice ">{$objFunctions->numberFormat($amountCurrency['AmountCurrency'])} {$amountCurrency['TypeCurrency']}</div>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <div class="DivTotalPrice ">
                    <div class="fltl">##Amountpayable## :
                        <span>{$objFunctions->numberFormat($amountCurrency['AmountCurrency'])}</span>
                        {$amountCurrency['TypeCurrency']}
                    </div>
                </div>

            </div>

        </div>
        <div class="clear"></div>


        <div class="main-Content-bottom Dash-ContentL-B">
            <div class="main-Content-bottom-table Dash-ContentL-B-Table">
                <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title l-p-p-header l-p-p-header-change site-bg-main-color">
                    <i class="icon-table"></i>
                    <h3>##Listpassengers##</h3>
                </div>

                <table id="passengers" class="display" cellspacing="0" width="100%">

                    <thead>
                    <tr>
                        <th>##Ages##</th>
                        <th>##Name##</th>
                        <th>##Family##</th>
                        <th>##Nameenglish##</th>
                        <th>##Familyenglish##</th>
                        <th>##Happybirthday##/##Age##</th>
                        <th>##Numpassport##/##Nationalnumber##</th>
                    </tr>
                    </thead>
                    <tbody>

                    {foreach $objFactor->passengers as $i=>$passenger}
                        <tr>
                            <td>
                                <p>
                                    {if $passenger['passenger_age'] eq 'Adt'}
                                        ##Adult##
                                    {else}
                                        ##Child##
                                    {/if}
                                </p>
                            </td>
                            <td><p>{$passenger['passenger_name']}</p></td>
                            <td><p>{$passenger['passenger_family']}</p></td>
                            <td><p>{$passenger['passenger_name_en']}</p></td>
                            <td><p>{$passenger['passenger_family_en']}</p></td>
                            <td>
                                <p>
                                    {if $passenger['passenger_age'] eq 'Adt'}
                                        {$passenger['passenger_birthday']}
                                    {else}
                                        {$passenger['passenger_birthday']} ##Year##
                                    {/if}
                                </p>
                            </td>
                            <td>
                                <p>{if $passenger['passenger_national_code'] eq ''}{$Adt['passportNumber']}{else}{$passenger['passenger_national_code']}{/if}</p>
                            </td>
                        </tr>
                    {/foreach}


                    </tbody>


                </table>
            </div>
        </div>
        <div class="clear"></div>


    </div>
    <div class="clear"></div>


    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 s-u-passenger-wrapper-change  "
         style="padding: 0">
        <div class="s-u-result-wrapper">
            <div class="s-u-result-item-change direcR iranR txt12 txtRed s-u-result-item-RulsCheck">
                <div style="text-align: right">
                    {assign var="serviceType" value=$objFunctions->TypeServiceHotel($smarty.post.typeApplication)} {* لازم برای انتخاب نوع بانک *}
                    {if ($smarty.post.typeApplication eq 'api' || $smarty.post.typeApplication eq 'externalApi') &&
                    $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] =='5'}
                        <div class="s-u-result-item-RulsCheck-item">
                            <input class="FilterHoteltype Show_all FilterHoteltypeName-top" id="discount_code" name=""
                                   value="" type="checkbox">
                            <label class="FilterHoteltypeName site-main-text-color-a  " for="discount_code">##Ihavediscountcodewantuse##</label>

                            <div class="col-sm-12  parent-discount displayiN ">
                                <div class="row separate-part-discount">
                                    <div class="col-sm-6 col-xs-12">
                                        <label for="discount-code">##Codediscount## :</label>
                                        <input type="text" id="discount-code" class="form-control">
                                    </div>
                                    <div class="col-sm-2 col-xs-12">
                                    <span class="input-group-btn">
                                        <input type="hidden" name="priceWithoutDiscountCode"
                                               id="priceWithoutDiscountCode" value="{$amountCurrency.AmountCurrency}"/>
                                        <button type="button" onclick="setDiscountCode('{$serviceType}', '{$currencyCode}')"
                                                class="site-secondary-text-color site-main-button-flat-color iranR discount-code-btn">##Reviewapplycode##  </button>
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
                                            <span class="price__amount-price price-after-discount-code">{($amountCurrency.AmountCurrency)|number_format}</span>
                                            <span class="price__unit-price">{$amountCurrency.TypeCurrency}</span>
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
                            <a class="txtRed" href="{$smarty.const.URL_RULS}" target="_blank">##Seerules## </a>
                            ##IhavestudiedIhavenoobjection##
                        </label>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>

    <div class="btn-final-confirmation" id="btn-final-Reserve">
        <a href="" onclick="return false" class="f-loader-check loaderfactors" id="loader_check" style="display:none"></a>
        <a class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-main-button-color"
           id="final_ok_and_insert_passenger"
           onclick="confirmAndBookingExternalHotel('{$factorNumber}')">##Approvefinal## </a>
    </div>
    <div id="messageBook-externalHotel"></div>

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

        {assign var="bankInputs" value=['flag' => 'check_credit_hotel', 'factorNumber' => $factorNumber, 'typeApplication' => $typeApplication, 'typeTrip' => 'hotelPortal', 'paymentPrice' => $objFactor->paymentPrice, 'serviceType' => $serviceType]}
        {assign var="bankAction" value="`$smarty.const.ROOT_ADDRESS`/goBankHotelLocal"}

        {assign var="creditInputs" value=['flag' => 'buyByCreditHotelLocal', 'factorNumber' => $factorNumber, 'typeApplication' => $typeApplication]}
        {assign var="creditAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankHotelLocal"}

        {assign var="currencyPermition" value="0"}
        {if $smarty.const.ISCURRENCY && $smarty.post.CurrencyCode > 0}
            {$currencyPermition = "1"}
            {assign var="currencyInputs" value=['flag' => 'check_credit_hotel', 'factorNumber' => $factorNumber, 'typeApplication' => $typeApplication, 'typeTrip' => 'hotelPortal', 'paymentPrice' => $objFactor->paymentPrice, 'serviceType' => $serviceType, 'amount' => $paymentPriceCurrency.AmountCurrency, 'currencyCode' => $smarty.post.CurrencyCode]}
            {assign var="currencyAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankHotelLocal"}
        {/if}

        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`paymentMethods.tpl"}
        <!-- payment methods drop down -->

    </div>


{/if}


<!--BACK TO TOP BUTTON-->
<div class="backToTop"></div>
{literal}
    <script type="text/javascript">
        $(document).ready(function () {
            $(this).find(".price-pop").click(function () {

                $(".price-Box").toggleClass("displayBlock");
                $("#lightboxContainer").addClass("displayBlock");
            });
            $(this).find(".closeBtn").click(function () {

                $(".price-Box").removeClass("displayBlock");
                $("#lightboxContainer").removeClass("displayBlock");
            });
            $("div#lightboxContainer").click(function () {

                $(".price-Box").removeClass("displayBlock");
                $("#lightboxContainer").removeClass("displayBlock");
            });
            $(this).find(".Cancellation-pop").click(function () {

                $(".Cancellation-Box").toggleClass("displayBlock");
                $("#lightboxContainer").addClass("displayBlock");
            });
            $(this).find(".closeBtn").click(function () {

                $(".Cancellation-Box").removeClass("displayBlock");
                $("#lightboxContainer").removeClass("displayBlock");
            });
            $("div#lightboxContainer").click(function () {

                $(".Cancellation-Box").removeClass("displayBlock");
                $("#lightboxContainer").removeClass("displayBlock");
            });
            // $('body').delegate('.DetailSelectTicket','click', function(e) {
            $('.DetailSelectTicket').on('click', function (e) {
                $(this).parent().siblings('.DetailSelectTicketContect').slideToggle('fast');
            });
        });
    </script>
{/literal}
{literal}
<!-- jQuery Site Scipts -->
    <script src="assets/js/script.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/jdate.min.js" type="text/javascript"></script>
    <script src="assets/js/jdate.js" type="text/javascript"></script>
    <script src="assets/js/jquery.counter.js" type="text/javascript"></script>
<script type="text/javascript">
   /* $('.counter').counter({});
    $('.counter').on('counterStop', function () {
        alert('مهلت رزور هتل شما به اتمام رسید لطفا مجددا اقدام نمایید');
        //location.href = '{/literal}{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}{literal}';
    });*/
</script>

<!-- modal login    -->
    <script type="text/javascript" src="assets/js/modal-login.js"></script>


{/literal}

