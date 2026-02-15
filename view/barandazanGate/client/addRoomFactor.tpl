<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>
{load_presentation_object filename="editHotelBooking" assign="objHotel"}
{$objHotel->getInfoHotel($smarty.post.factorNumber)}

{load_presentation_object filename="addRoomFactor" assign="objFactor"}
{load_presentation_object filename="resultHotelLocal" assign="objResult"}

{$objFactor->statusRefresh()}

{**اضافه کردن اطلاعات مسافران به جدول و گرفتن اطلاعات مربوط به مسافران**}
{if $smarty.post.bookingStage eq 'finalRegistration'}
    {$objFactor->registerPassengersReservationHotel()}
{/if}
{$objFactor->getPassengersHotel()}
{$listOneDayTour = $objResult->getInfoReserveOneDayTour($smarty.post.factorNumber)}


{load_presentation_object filename="members" assign="objMember"}
{$objMember->get()}
<div class="s-u-content-result">

    <div id="lightboxContainer" class="lightboxContainerOpacity"></div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 s-u-passenger-wrapper-change " >
        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
            ##Note## <i class="zmdi zmdi-alert-circle mart10  zmdi-hc-fw"></i>
        </span>
        <div class="s-u-result-wrapper">
            <span class="s-u-result-item-change direcR iranR txt12 txtRed">
                ##DontReloadPageInfo##
            </span>
        </div>

        <div class="s-u-result-wrapper">
            <span class="s-u-result-item-change direcR iranR txt12 txtRed">
                ##Duelimitationsseasonhotelbookingshotel##
                <br>
                ##Assurancecaseproblemappropriateconditionsbook##
            </span>
        </div>

    </div>
    <div class="Clr"></div>


    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 s-u-passenger-wrapper-change">

        <input type="hidden" name="typeApplication" id="typeApplication" value="{$smarty.post.typeApplication}">

        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
            <i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart10"></i>
        </span>

        <div class="hotel-booking-room marb0">

            <div class="col-md-3 nopad">
                {if $smarty.post.typeApplication eq 'reservation'}
                <div class="ribbon-special-hotel"><span><i>  ##Specialhotel## </i></span></div>
                {/if}
                <div class="hotel-booking-room-image">
                    <a><img src="pic/{$objHotel->infoHotel['hotel_pictures']}" alt="hotel-image"></a>
                </div>
            </div>

            <div class="col-md-9 ">
                <div class="hotel-booking-room-content">
                    <div class="hotel-booking-room-text">

                        <b class="hotel-booking-room-name"> {$objHotel->infoHotel['hotel_name']} </b>

                        <span class="hotel-star">
                           {for $s=1 to $objHotel->infoHotel['hotel_starCode']}
                               <i class="fa fa-star" aria-hidden="true"></i>
                           {/for}
                            {for $ss=$s to 5}
                                <i class="fa fa-star-o" aria-hidden="true"></i>
                            {/for}
                        </span>

                        <span class="hotel-booking-room-content-location fa fa-map-marker ">
                             <a href="#"> {$objHotel->infoHotel['hotel_address']} </a>
                        </span>
                        <p class="hotel-booking-roomm-description hotel-result-item-rule">
                            <span class="fa fa-bell-o"></span>
                            {$objHotel->infoHotel['hotel_rules']}
                        </p>

                        <input type="hidden" id="night" name="night" value="{$objHotel->infoHotel['number_night']}">
                        <div class="hotel-booking-room-text">
                            <ul>
                                <li class="hotel-check-text"><i class="fa fa-calendar-times-o"></i>  ##Enterdate## :
                                    <span  class="hotel-check-date" dir="rtl">{{$objHotel->infoHotel['start_date']}}</span></li>
                                <li class="hotel-check-text"><i class="fa fa-calendar-check-o"></i> ##Exitdate##  :
                                    <span class="hotel-check-date" dir="rtl">{{$objHotel->infoHotel['end_date']}}</span></li>
                                <li class="hotel-check-text"><i class="fa fa-bed"></i> {{$objHotel->infoHotel['number_night']}} ##Night##</li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="clear"></div>
        <div class="hotel-booking-room">

            <h4 class="tableOrderHeadTitle site-bg-main-color">
                <span>  ##Listroom##</span>
            </h4>
            <div class="rp-tableOrder site-border-main-color">
                <table>
                    <thead>
                    <tr class="Hotel-tableOrderHead">
                        <th class="Hotel-tableOrderHead-c1"> ##Informationbed##</th>
                        <th class="Hotel-tableOrderHead-c2">##CapacityRoom## </th>
                        <th class="Hotel-tableOrderHead-c3">##Countroom## </th>
                        <th class="Hotel-tableOrderHead-c4"> ##Exterabed##</th>
                        <th class="Hotel-tableOrderHead-c4">##Serviceroom##</th>
                        <th class="Hotel-tableOrderHead-c5">   ##Priceforanynight##</th>
                        <th class="Hotel-tableOrderHead-c6">##TotalPrice## </th>
                    </tr>
                    </thead>
                    <tbody>

                    {foreach  $objFactor->temproryHotel['room']  as $room}

                    <tr>
                        <td class="Hotel-tableOrderHead">
                            <h5 class="roomsTitle">{$room['room_name']}</h5>
                        </td>

                        <td class="Hotel-tableOrderHead">
                            <div class="roomCapacity">
                                <i class="fa fa-user txt15"></i> <i class="inIcon">x</i><i class="txtIcon ng-binding">{$room['max_capacity_count_room']}</i>
                            </div>
                        </td>

                        <td class="Hotel-tableOrderHead">
                            <h5 class="roomCapacity"><i class="txtIcon ng-binding">{$room['room_count']}</i></h5>
                            <input type="hidden" name="RoomCount{$room['room_id']}" id="RoomCount{$room['room_id']}" value="{$room['room_count']}">
                        </td>

                        <td class="Hotel-tableOrderHead">
                            <h5 class="roomCapacity"><i class="txtIcon ng-binding">{$room['flat_ext_count']}</i></h5>
                        </td>

                        <td class="Hotel-tableOrderHead">
                            <ul class="HotelRoomFeatureList">
                                <li class="Breakfast"><i class="fa fa-coffee"></i> ##Breakfast##</li>
                            </ul>
                        </td>
                        <td class="Hotel-tableOrderHead">
                            {assign var="roomCurrency" value=$objFunctions->CurrencyCalculate($room['price_current'], $smarty.post.CurrencyCode, $smarty.post.CurrencyEquivalent)}
                            <span class="pricePerNight"><span class="currency">
                                 {$objFunctions->numberFormat($roomCurrency.AmountCurrency)}
                                 {*if $room['passenger'] eq 'Foreign'*}
                                    {*$room['price_foreign_current']|number_format:0:".":","*}
                                 {*else*}
                                    {*$room['price_current']|number_format:0:".":","*}
                                 {*/if*}
                            </span> {$roomCurrency.TypeCurrency} </span>
                        </td>
                        <td class="Hotel-tableOrderHead">
                            {assign var="everyRoomCurrency" value=$objFunctions->CurrencyCalculate($room['room_price'], $smarty.post.CurrencyCode, $smarty.post.CurrencyEquivalent)}
                            <div class="roomFinalPrice ">{$objFunctions->numberFormat($everyRoomCurrency.AmountCurrency)} {$everyRoomCurrency.TypeCurrency}</div>
                        </td>
                    </tr>
                    {/foreach}

                    </tbody>
                </table>
            </div>


            {if $smarty.post.typeApplication eq 'reservation' && $listOneDayTour neq ''}
            <h4 class="tableOrderHeadTitle site-bg-main-color">
                <span>##Onedaypatrol##</span>
            </h4>
            <div class="rp-tableOrder site-border-main-color">
                <table>
                    <thead>
                    <tr class="Hotel-tableOrderHead">
                        <th class="Hotel-tableOrderHead-c1"> ##Titletour##  </th>
                        <th class="Hotel-tableOrderHead-c6"> ##TotalPrice##</th>
                    </tr>
                    </thead>
                    <tbody>

                    {foreach  $listOneDayTour  as $val}

                        <tr>
                            <td class="Hotel-tableOrderHead">
                                <h5 class="roomsTitle">{$val['title']}</h5>
                            </td>

                            <td class="Hotel-tableOrderHead">
                                {assign var="tourCurrency" value=$objFunctions->CurrencyCalculate($val['price'], $smarty.post.CurrencyCode, $smarty.post.CurrencyEquivalent)}
                                <div class="roomFinalPrice ">{$objFunctions->numberFormat($tourCurrency.AmountCurrency)} {$tourCurrency.TypeCurrency}</div>
                            </td>
                        </tr>
                    {/foreach}

                    </tbody>
                </table>
            </div>
            {/if}



            {if $objResult->showOneDayTour eq 'True'}
                <h4 class="tableOrderHeadTitle site-bg-main-color">
                    <span>##Onedaypatrol##</span>
                </h4>
                <div class="rp-tableOrder site-border-main-color">
                    <table>
                        <thead>
                        <tr class="Hotel-tableOrderHead">
                            <th class="Hotel-tableOrderHead-c1">  ##Titletour##  </th>
                            <th class="Hotel-tableOrderHead-c6"> ##TotalPrice##</th>
                        </tr>
                        </thead>
                        <tbody>

                        {foreach  $objResult->listOneDayTour  as $val}

                            <tr>
                                <td class="Hotel-tableOrderHead">
                                    <h5 class="roomsTitle">{$val['title']}</h5>
                                </td>

                                <td class="Hotel-tableOrderHead">
                                    {assign var="tourCurrency" value=$objFunctions->CurrencyCalculate($val['price'], $smarty.post.CurrencyCode, $smarty.post.CurrencyEquivalent)}
                                    <div class="roomFinalPrice ">{$objFunctions->numberFormat($tourCurrency.AmountCurrency)} {$tourCurrency.TypeCurrency}</div>
                                </td>
                            </tr>
                        {/foreach}

                        </tbody>
                    </table>
                </div>
            {/if}

            <div class="DivTotalPrice ">
                {assign var="paymentPriceCurrency" value=$objFunctions->CurrencyCalculate($objFactor->paymentPrice, $smarty.post.CurrencyCode, $smarty.post.CurrencyEquivalent)}
                <div class="fltl">##Amountpayable## : <span>{$objFunctions->numberFormat($paymentPriceCurrency.AmountCurrency)}</span> {$paymentPriceCurrency.TypeCurrency}</div>
            </div>
        </div>

        <div class="clear"></div>


        <div class="main-Content-bottom Dash-ContentL-B">
            <div class="main-Content-bottom-table Dash-ContentL-B-Table">
                {if $objFactor->temproryHotel['passenger'][0]['passenger_name'] neq ''}
                <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title l-p-p-header l-p-p-header-change site-bg-main-color">
                    <i class="icon-table"></i><h3>##Listpassengers## </h3>
                </div>

                <table id="passengers"  class="display" cellspacing="0" width="100%">

                    <thead>
                    <tr>
                        <th> ##Ages##</th>
                        <th>##Name##</th>
                        <th> ##Nameenglish##</th>
                        <th> ##Family##</th>
                        <th> ##Familyenglish##</th>
                        <th>##Happybirthday## </th>
                        <th>##Numpassport## / ##Nationalnumber##</th>
                    </tr>
                    </thead>
                    <tbody>

                    {foreach $objFactor->temproryHotel['passenger'] as $i=>$passenger}
                    <tr>
                        <td>{$passenger['title_flat_type']}</td>
                        <td>
                            <p>{$passenger['passenger_name']}</p>
                        </td>
                        <td>
                            <p>{$passenger['passenger_name_en']}</p>
                        </td>
                        <td>
                            <p>{$passenger['passenger_family']}</p>
                        </td>
                        <td>
                            <p>{$passenger['passenger_family_en']}</p>
                        </td>
                        <td><p>{if !$passenger['passenger_birthday']} {$passenger['passenger_birthday_en']} {else} {$passenger['passenger_birthday']}{/if}</p></td>
                        <td><p>{if $passenger['passenger_national_code'] eq ''}{$Adt['passportNumber']}{else}{$passenger['passenger_national_code']}{/if}</p></td>
                    </tr>
                    {/foreach}

                    </tbody>


                </table>
                {elseif $objFactor->temproryHotel['type_application'] eq 'reservation'}
                    <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title l-p-p-header l-p-p-header-change site-bg-main-color">
                        <i class="icon-table"></i><h3> ##TravelerGuard##</h3>
                    </div>
                    <div class="Dash-ContentL-Title-leader">
                        <span class="leaderRoom-Title">##Family## :</span>
                        <span class="leaderRoom">{$objFactor->temproryHotel['passenger_leader_fullName']}</span>
                        <span class="leaderRoom-Title">##Telephone## :</span>
                        <span class="leaderRoom">{$objFactor->temproryHotel['passenger_leader_tell']}</span>
                    </div>
                {/if}
            </div>
        </div>
    </div>
    <div class="clear"></div>

        <!--  برای رزرو یک اتاق یا بیشتر به صورت موقت، و بازگرداندن یک شماره درخواست و شماره ( پی ان آر ) برای اعمال دستورات بر روی این رزرو-->
        <input type="hidden" value="" name="RequestNumber" id="RequestNumber">
        <input type="hidden" value="" name="RequestPNR" id="RequestPNR">
        <input type="hidden" value="" name="total_price" id="total_price">
        <input type="hidden" name="paymentPrice" id="paymentPrice" value="{$objFactor->paymentPrice}">

</div>
<div class="clear"></div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 s-u-passenger-wrapper-change  " style="padding: 0">
        <div class="s-u-result-wrapper">
            <div class="s-u-result-item-change direcR iranR txt12 txtRed s-u-result-item-RulsCheck">
                <div style="text-align: right">
                    {assign var="serviceType" value=$objFunctions->TypeServiceHotel($smarty.post.typeApplication)} {* لازم برای انتخاب نوع بانک *}
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
                                        <input type="hidden" name="priceWithoutDiscountCode" id="priceWithoutDiscountCode" value="{$paymentPriceCurrency.AmountCurrency}" />
                                        <button type="button" onclick="setDiscountCode('{$serviceType}', '{$smarty.post.CurrencyCode}')" class="site-secondary-text-color site-main-button-flat-color iranR discount-code-btn">##Reviewapplycode##  </button>
                                    </span>
                                    </div>
                                    <div class="col-sm-4 col-xs-12">
                                        <span class="discount-code-error"></span>
                                    </div>
                                </div>
                                <div class="row separate-part-discount">
                                    <div class="info-box__price info-box__item pull-left">
                                        <div class="item-discount">
                                            <span class="item-discount__label">  ##Amountpayable## :</span>
                                            <span class="price__amount-price price-after-discount-code">{$objFunctions->numberFormat($paymentPriceCurrency.AmountCurrency)}</span>
                                            <span class="price__unit-price">{$paymentPriceCurrency.TypeCurrency}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/if}
                    <p class="s-u-result-item-RulsCheck-item">
                        <input class="FilterHoteltype Show_by_filters FilterHoteltypeName-top" id="RulsCheck" name="heck_list1" value="" type="checkbox">
                        <label class="FilterHoteltypeName site-main-text-color-a " for="RulsCheck">
                            <a class="txtRed" href="{$smarty.const.URL_RULS}" target="_blank">##Seerules## </a> ##IhavestudiedIhavenoobjection##
                        </label>
                    </p>
                </div>
            </div>
        </div>
    </div>


<div class="btn-final-confirmation" id="btn-final-Reserve">
    <a href="" onclick="return false" class="f-loader-check loaderfactors"  id="loader_check" style="display:none"></a>
    <a class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-main-button-color" id="final_ok_and_insert_passenger"
       onclick="ReserveTemprory('{$smarty.post.factorNumber}', '{$smarty.post.typeApplication}')"> ##Approvefinal##  </a>
</div>
<div id="messageBook" class="error-flight"></div>
<div class="" style="position: relative;display:inline-block;float:left;margin-left: 10px;">
    <input type="button" value="##Return##" class="cancel-passenger" onclick="BackToEditReserve('{$smarty.post.factorNumber}'); return false">
</div>



<!-- OnRequest -->

<div id="cancelHotel" class="displayN">
<div class="main-cancel-box s-u-p-factor-bank s-u-p-factor-bank-change">
    <h4 class="site-bg-main-color site-bg-color-border-bottom site-main-button-flat-color">##Cancelrequest##</h4>
    <div class="s-u-select-bank mart30">
        <span> ##Yourrequesthascanceledtolackof##</span>
        <span class="author"><i> ##Youcanbookanotherhotel##</i></span>
    </div>
    <div class="s-u-select-update-wrapper">
        <a class="s-u-select-update s-u-select-update-change site-main-button-flat-color"
           onclick="backToResultHotelLocal('{$objFactor->city}', '{$objFactor->startDate}', '{$objFactor->numberNight}')"> ##Anotherhotel##   </a>
    </div>
</div>
</div>

<div id="onRequestOnlinePassenger" class="displayN">
    <div class="Attention Attention-change" >
        <div class="s-u-select-bank mart30 marb30 bg-yellow" >
            <input type="hidden" name="factorNumber" id="factorNumber" value="{$objFactor->temproryHotel['factor_number']}">
            <span class="author">
                <i class="bg-yellow"> ##Dearguestsuccessfullyregisteredbooking##</i>
            </span>
            <div class="msg">
                <span class="box-offline-reserve offline-reserve-msg">
                    <span class="msg-time">
                        <div class="counter d-none counter-analog" data-direction="down" data-format="59:59.9" data-stop="00:00:00.0" data-interval="100" style="direction: ltr">10:00:0</div>
                    </span>
                </span>
                <span class="box-offline-reserve offline-factorNumber"> ##Invoicenumber##: {$objFactor->temproryHotel['factor_number']}</span>
            </div>
        </div>
    </div>
    <div class="btn-final-confirmation">
        <a class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-main-button-color"
           onclick="backToResultHotelLocal('{$objFactor->city}', '{$objFactor->startDate}', '{$objFactor->numberNight}')"> ##Return##  </a>
    </div>
</div>


<div id="onRequest" class="displayN">
    <div class="Attention Attention-change" >
        <div class="s-u-select-bank mart30 marb30 bg-yellow" >
            <input type="hidden" name="factorNumber" id="factorNumber" value="{$objFactor->temproryHotel['factor_number']}">
            <span class="author">
                <i class="bg-yellow"> ##Dearguestsuccessfullyregisteredbooking##</i>
            </span>
            <div class="msg">
                <span class="box-offline-reserve offline-reserve-msg">##Usehotelshoppingpaymentbooking##</span>
                <span class="box-offline-reserve offline-factorNumber">  ##Invoicenumber##: {$objFactor->temproryHotel['factor_number']}</span>
            </div>
        </div>
    </div>
    <div class="btn-final-confirmation">
        <a class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-main-button-color"
           onclick="backToResultHotelLocal('{$objFactor->city}', '{$objFactor->startDate}', '{$objFactor->numberNight}')"> ##Return##  </a>
    </div>
</div>




<div id="confirmHotel" class="displayN">

    <div class="Attention Attention-change" >
        <div class="s-u-select-bank mart30 marb30 bg-yellow" >
            <span class="author">
                <i class="bg-yellow"> ##Dearguestrequestapprovedbookingfee##</i>
            </span>
            <div class="msg">
                <span class="box-offline-reserve offline-reserve-msg">
                    <span class="msg-time">
                        <div class="counterBank counter-analog" data-direction="down" data-format="59:59.9" data-stop="00:00:00.0" data-interval="100" style="direction: ltr">10:00:0</div>
                    </span>
                </span>
                <span class="box-offline-reserve offline-factorNumber"> ##Invoicenumber## : {$objFactor->temproryHotel['factor_number']}</span>
            </div>
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

    {assign var="bankInputs" value=['flag' => 'check_credit_hotel', 'factorNumber' => $objFactor->temproryHotel['factor_number'], 'typeApplication' => $smarty.post.typeApplication, 'typeTrip' => 'hotelLocal', 'paymentPrice' => $objFactor->paymentPrice, 'serviceType' => $serviceType]}
    {assign var="bankAction" value="`$smarty.const.ROOT_ADDRESS`/goBankHotelLocal"}

    {assign var="creditInputs" value=['flag' => 'buyByCreditHotelLocal', 'factorNumber' => $objFactor->temproryHotel['factor_number'], 'typeApplication' => $smarty.post.typeApplication]}
    {assign var="creditAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankHotelLocal"}

    {assign var="currencyPermition" value="0"}
    {if $smarty.const.ISCURRENCY && $smarty.post.CurrencyCode > 0}
        {$currencyPermition = "1"}
        {assign var="currencyInputs" value=['flag' => 'check_credit_hotel', 'factorNumber' => $objFactor->temproryHotel['factor_number'], 'typeApplication' => $smarty.post.typeApplication, 'typeTrip' => 'hotelLocal', 'paymentPrice' => $objFactor->paymentPrice, 'serviceType' => $serviceType, 'amount' => $paymentPriceCurrency.AmountCurrency, 'currencyCode' => $smarty.post.CurrencyCode]}
        {assign var="currencyAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankHotelLocal"}
    {/if}

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`paymentMethods.tpl"}
    <!-- payment methods drop down -->


</div>






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
<script src="assets/js/jdate.min.js" type="text/javascript"></script>
<script src="assets/js/jdate.js" type="text/javascript"></script>
<script src="assets/js/jquery.counter.js" type="text/javascript"></script>
<script type="text/javascript">

    function timeForConfirmHotel(){
        setInterval(function () {

            var factorNumber = $('#factorNumber').val();
            $.post(amadeusPath + 'hotel_ajax.php',
                {
                    factorNumber: factorNumber,
                    flag: "checkForConfirmHotel"
                },
                function (data) {

                    if (data.indexOf('PreReserve') > -1) {

                        $('#onRequestOnlinePassenger').addClass('displayN');
                        $('#confirmHotel').removeClass('displayN');
                        $('.counterBank').counter({});
                        setTimeout(function () {
                            $('#final_ok_and_insert_passenger').removeAttr("onclick").attr("disabled", true).css('cursor', 'not-allowed').text('تایید شده');

                            $('.s-u-p-factor-bank-change').show();
                            $('#loader_check').css("display", "none");
                            $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow');
                        }, 2000);

                    }else if (data.indexOf('Cancelled') > -1) {

                        $('#onRequestOnlinePassenger').addClass('displayN');
                        $('#cancelHotel').removeClass('displayN');
                    }


                });

        },60000);
    }


    $('.counter').on('counterStop', function () {

        var factorNumber = $('#factorNumber').val();

        $.post(amadeusPath + 'hotel_ajax.php',
            {
                factorNumber: factorNumber,
                flag: "checkForConfirmHotel"
            },
            function (data) {

                if (data.indexOf('PreReserve') > -1) {

                    $('#onRequestOnlinePassenger').addClass('displayN');
                    $('#confirmHotel').removeClass('displayN');
                    $('.counterBank').counter({});
                    setTimeout(function () {
                        $('#final_ok_and_insert_passenger').removeAttr("onclick").attr("disabled", true).css('cursor', 'not-allowed').text('##Accepted##');

                        $('.s-u-p-factor-bank-change').show();
                        $('#loader_check').css("display", "none");
                        $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow');
                    }, 2000);

                }else if (data.indexOf('Cancelled') > -1) {

                    $('#onRequestOnlinePassenger').addClass('displayN');
                    $('#cancelHotel').removeClass('displayN');

                } else {

                    $.post(amadeusPath + 'hotel_ajax.php',
                        {
                            factorNumber: factorNumber,
                            flag: "cancelReserveHotel"
                        },
                        function (data) {

                            $('#onRequestOnlinePassenger').addClass('displayN');
                            $('#cancelHotel').removeClass('displayN');

                        });

                }


            });

    });


    $('.counterBank').on('counterStop', function () {

        var factorNumber = $('#factorNumber').val();
        $.post(amadeusPath + 'hotel_ajax.php',
            {
                factorNumber: factorNumber,
                flag: "cancelReserveHotel"
            },
            function (data) {

                $.alert({
                    title: '##Reservationhotel##',
                    icon: 'fa fa-times',
                    content: "##Yourhotelreservationdeadlineexpiredrestart##",
                    rtl: true,
                    type: 'red'
                });
                location.href = '{/literal}{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}{literal}';

            });

    });

</script>
<!-- modal login    -->
<script type="text/javascript" src="assets/js/modal-login.js"></script>


{/literal}

