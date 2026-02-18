{load_presentation_object filename="factorHotelNew" assign="objFactor"}
{load_presentation_object filename="detailHotel" assign="objHotel"}
{assign var="requestNumber" value=$smarty.post.requestNumber}
{load_presentation_object filename="members" assign="objMember"}
{*{$objFactor->StatusRefresh()}*}
{$objMember->get()}

{$objFactor->registerPassengersHotel()}
{assign var="hotelDetail" value=$objHotel->getTemporaryHotelDetails($smarty.post.factorNumber)}

{assign var="temproryRooms" value=$objHotel->getTemporaryRooms($smarty.post.factorNumber)}
<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>
<script src="assets/js/jquery.counter.js" type="text/javascript"></script>

<code style="display:none;color: #fb002a;">{$smarty.post|json_encode:256}</code>
<code style="display:none;color: #0abb17;">{$objFactor|json_encode:256}</code>
<div id="steps" style="margin: 10px 0">
    <div class="steps_items">
        <div class="step done ">
            <span class=""><i class="fa fa-check"></i></span>
            <h3>##Selectionhotel##</h3>
        </div>
        <i class="separator  done "></i>
        <div class="step done">
            <span class="flat_icon_airplane"><i class="fa fa-check"></i></span>
            <h3>##StayInformation##</h3>
        </div>
        <i class="separator done"></i>
        <div class="step done">
            <span class="flat_icon_airplane"><i class="fa fa-check"></i></span>
            <h3> ##PassengersInformation## </h3>
        </div>
        <i class="separator donetoactive"></i>
        <div class="step active ">
            <span class="flat_icon_airplane">
                  <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="128.000000pt" height="128.000000pt" viewBox="0 0 128.000000 128.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,128.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
<path d="M499 1247 c-223 -115 -217 -433 9 -544 73 -36 182 -38 253 -6 237 107 248 437 17 552 -52 27 -72 31 -139 31 -68 0 -85 -4 -140 -33z m276 -177 c19 -21 18 -22 -75 -115 l-94 -95 -53 52 -53 52 22 23 22 23 31 -30 31 -30 69 70 c38 39 72 70 76 70 3 0 14 -9 24 -20z"/><path d="M70 565 l0 -345 570 0 570 0 0 345 0 345 -104 0 -104 0 -6 -34 c-9
-47 -75 -146 -124 -184 -75 -60 -126 -77 -232 -77 -106 0 -157 17 -232 77 -49 38 -115 137 -124 184 l-6 34 -104 0 -104 0 0 -345z m980 -150 l0 -105 -145 0 -145 0 0 105 0 105 145 0 145 0 0 -105z m-410 -75 l0 -30 -205 0 -205 0 0 30 0 30 205 0 205 0 0 -30z"/>
<path d="M0 150 c0 -45 61 -120 113 -139 39 -15 1015 -15 1054 0 52 19 113 94 113 139 0 7 -207 10 -640 10 -433 0 -640 -3 -640 -10z"/>
</g></svg>
            </span>
            <h3> ##Reservationhotel## </h3>
        </div>
    </div>
    <div class="counter counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"
         style="direction: ltr">10:00</div>
</div>
{if $objFactor->error eq true}
    <div class="s-u-content-result">
        <div id="lightboxContainer" class="lightboxContainerOpacity">{$objFactor->errorMessage}</div>
        <div class="Clr"></div>
    </div>
{else}
    {if $hotelDetail}
<div class="s-u-content-result {if $hotelDetail.is_internal neq 1} is_external_hotel{/if}">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 s-u-passenger-wrapper-change">
     <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
         <i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart10"></i> ##Invoice##
     </span>
                <div class="hotel-booking-room marb0">

                    <div class="col-md-3 nopad">
                        <div class="hotel-booking-room-image">
                            <a>
                                <img src="{$hotelDetail['hotel_pictures']}" alt="hotel-image">
                            </a>
                        </div>
                    </div>

                    <div class="col-md-9 pl-0 ">
                        <div class="hotel-booking-room-content">
                            <div class="hotel-booking-room-text">
                                <h4 class="hotel-booking-room-name"> {$hotelDetail['hotel_name']} </h4>

                                <span title="{$hotelDetail['hotel_starCode']} ##Star##" class="hotel-star" style="padding-bottom: 0">
                            {for $s=1 to $hotelDetail['hotel_starCode']}
                                <i class="fa fa-star" aria-hidden="true"></i>
                            {/for}
{*                                    {for $ss=$s to 5}*}
{*                                        <i class="fa fa-star-o" aria-hidden="true"></i>*}
{*                                    {/for}*}
                        </span>
                                {if $hotelDetail['hotel_address']}
                                    <span class="hotel-booking-room-content-location ">
                              {$hotelDetail['hotel_address']}
                           </span>
                                {/if}
                                {if $Hotel['rules']}
                                    <p class="hotel-booking-roomm-description hotel-result-item-rule">
                                        <span class="fa fa-bell-o"></span>
                                        {$hotelDetail['rules']}
                                    </p>
                                {/if}
                            </div>

                            <div class="hotel-booking-room-date">
                                <ul>
                                    <li class="hotel-check-text"><i class="fa fa-calendar-times-o"></i> ##Enterdate## :
                                        <span class="hotel-check-date" dir="rtl">{$hotelDetail['start_date']}</span></li>
                                    <li class="hotel-check-text"><i class="fa fa-calendar-check-o"></i> ##Exitdate## :
                                        <span class="hotel-check-date" dir="rtl">{$hotelDetail['end_date']}</span></li>
                                    <li class="hotel-check-text"><i class="fa fa-bed"></i> {$hotelDetail['number_night']}
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
                    <div class="table-responsive ov">
                        <div class="table-responsive ov position-relative room_table">
                            <div class="table_hotel_nz">
                                <div class="thead_hotel">
                                    <div class="tr_hotel">
                                        <div class="th_hotel">##Specifications##</div>
                                        <div class="th_hotel hidden-xs">##Service##</div>
                                        {if $hotelDetail.is_internal == 1}
                                            <div class="th_hotel">##Price##</div>
                                        {else}
                                            <div class="th_hotel">##CapacityRoom##</div>
                                        {/if}
                                    </div>
                                </div>


                                <div class="tbody_hotel">
                                    {assign var="total_price" value=0}
                                    {foreach $temproryRooms as $k=>$room}
                                        <code style='display:none'>{$room|json_encode:256}</code>
                                        {assign var="has_breakfast" value=(strpos($room.room_name,'صبحانه') && !strpos($room.room_name,'بدون صبحانه'))}
                                        {assign var="room_count" value=$room.room_count}

                                        {if $c eq 1 }
                                            {assign var="roomTypeCodes" value="{$room.room_id}"}
                                            {assign var="numberOfRooms" value="{$room.room_count}"}
                                            {$c= 2}
                                        {else}
                                            {assign var="roomTypeCodes" value="{$roomTypeCodes},{$room.room_id}"}
                                            {assign var="numberOfRooms" value="{$numberOfRooms},{$room.room_count}"}
                                        {/if}

                                        <div class="tr_hotel hotel_room_row">

                                            <div class="th_hotel">
                                                {assign var="prices" value=$objHotel->getEachDayHotelPrices($room.factor_number,$room.room_id)}
                                                {if $room.is_internal eq '1'}
                                                    <div class="box_pricees">
                                                        <div class="detail_room_hotel detail_room_hotel_new">
                                                            {foreach $prices as $price}
                                                                <div class="details">
                                                                    <div class="AvailableSeprate site-bg-main-color site-bg-color-border-right-b ">{$price.date_current}</div>
                                                                    <div class="seprate">
                                                                    <span><b>{$price.price_current|number_format}</b>##Rial## <i class="fa fa-male checkIcon"></i>
                                                                        <span class="tooltip-price">##Adult##</span>
                                                                    </span>
                                                                        {if $room.extra_bed_count gt 0 AND $price.extra_bed_price gt 0}
                                                                            <span><b>{$price.extra_bed_price|number_format}</b>##Rial## <i class="fa fa-bed checkIcon"></i>
                                                                        <span class="tooltip-price">##Extrabed##</span>
                                                                    </span>
                                                                        {/if}
                                                                        {if $room.child_count gt 0 AND $price.child_price gt 0}
                                                                            <span><b>{$price.child_price|number_format}</b>##Rial## <i class="fas fa-baby-carriage"></i>
                                                                        <span class="tooltip-price">##Child##</span>
                                                                    </span>
                                                                        {/if}
                                                                    </div>
                                                                </div>
                                                            {/foreach}
                                                        </div>
                                                    </div>
                                                {/if}
                                                <span class="roomsTitle">{$room.room_name}</span>
                                                <div class="hidden-md-up roomCapacity">
                                                    <h5 class="" style="display: inline-block; width: 100%; font-size: 13px;">
                                                        {$objFunctions->StrReplaceInXml(['@@count@@'=>$objFunctions->ConvertNumberToAlphabet($room.room_count)],'RoomCountNumber')}
                                                    </h5>
                                                    <input type="hidden" name="RoomCount-{$room.room_id}" id="RoomCount-{$room.room_id}" value="{$room.room_count}">
                                                </div>
                                                {if $room.is_internal}
                                                    <input type="hidden" name="child_count-{$room.room_id}" id="child_count-{$room.room_id}"
                                                           value="{$room.child_count}">
                                                    <input type="hidden" name="extra_bed_count-{$room.room_id}" id="extra_bed_count-{$room.room_id}"
                                                           value="{$room.extra_bed_count}">

                                                    {if $room.extra_bed_count gt 0}
                                                        <div class="extra-bed-element d-flex justify-content-around">
                                                            <span class="extra-bed-title">##Extrabed##</span>
                                                            <div class="extra-bed-count"><span>{$room.extra_bed_count}</span><i class="inIcon">x</i><span>{$room.room_count}</span></div>
                                                            {assign var="totalExtraCurrency" value=0}
                                                            {$totalExtraCurrency=$objFunctions->CurrencyCalculate(($room.total_prices.extra_bed * $room.number_night), $smarty.post.CurrencyCode)}
                                                            <div class="extra-bed-price">{$objFunctions->numberFormat($totalExtraCurrency.AmountCurrency)} {$totalExtraCurrency.TypeCurrency}</div>
                                                        </div>
                                                    {/if}
                                                    {if $room.child_count gt 0}
                                                        <div class="child-element d-flex justify-content-around">
                                                            <span class="child-title">##Chd##</span>
                                                            <div class="child-count">{$room.child_count}</div>
                                                            {assign var="totalChildCurrency" value=0}
                                                            {$totalChildCurrency=$objFunctions->CurrencyCalculate(($room.total_prices.child *  $room.number_night), $smarty.post.CurrencyCode)}
                                                            <div class="child-price">{$objFunctions->numberFormat($totalChildCurrency.AmountCurrency)} {$totalChildCurrency.TypeCurrency}</div>
                                                        </div>
                                                    {/if}
                                                {/if}

                                            </div>
                                            {if $room.is_internal}
                                                    <div class="th_hotel hidden-xs">
                                                {if $has_breakfast neq false }
                                                        <ul class="HotelRoomFeatureList">
                                                            <li class="Breakfast"><i class="fa fa-coffee"></i> ##Breakfast##</li>
                                                        </ul>
                                                {else}
                                                    <span>---</span>
                                                {/if}
                                                    </div>

                                                <div class="th_hotel">


                                                        {$totalRoomCurrency=$objFunctions->CurrencyCalculate(($room.final_total ), $smarty.post.CurrencyCode)}


                                                    <div data-nights="{$room.number_night}"
                                                         data-child="{$room.child_count}"
                                                         data-extra-count="{$room.extra_bed_count}"
                                                         data-extra-price="{$room.extra_bed_count}"
                                                         data-child-price="{$room.child_price}"
                                                         class="roomFinalPrice roomPriceTable">
                                                        {if  $smarty.post.source_id neq '29'}
                                                            {$objFunctions->numberFormat($totalRoomCurrency.AmountCurrency)} <i> {$totalRoomCurrency.TypeCurrency}</i>
                                                        {else}
                                                            {$detailPrice=$objFunctions->CurrencyCalculate(($room.final_detail_price), $smarty.post.CurrencyCode)}
                                                            {$objFunctions->numberFormat($detailPrice.AmountCurrency)} <i> {$detailPrice.TypeCurrency}</i>
                                                        {/if}
                                                        {if $room.is_internal eq '1' and $smarty.post.source_id neq '29'}
                                                            <div class=" plus_price_room" title="جزییات قیمت برای هر اتاق">
                                                                <i class="far fa-list-alt"></i>
                                                            </div>
                                                        {/if}

                                                    </div>


                                                </div>
                                            {else}
                                                <div class="th_hotel hidden-xs">
                                                    ---
                                                </div>
                                                <div class="th_hotel ">

                                            <span class="pricePerNight">
                                                <span class="currency">
                                                    {$room.AdultsCount} ##Adult##
                                                    {$room.ChildCount} ##Child##
                                                </span>
                                            </span>
                                                </div>
                                            {/if}
                                        </div>
                                        {$total_price = $total_price + $totalRoomCurrency.AmountCurrency}
                                        {if $hotelDetail.is_internal eq '0'}
                                            {*<code>{$room|json_encode}</code>*}
                                            {$total_price = $room.room_price_current}
                                        {/if}

                                    {/foreach}
                                </div>


                            </div>


                        </div>


                    </div>

                    <div class="DivTotalPrice">
                        {assign var="totalPriceCurrency" value=$objFunctions->CurrencyCalculate($total_price, $smarty.post.CurrencyCode)}

                        <div class="fltl">##Amountpayable## :
                            {if $smarty.post.source_id eq '29'}
                                <span>{$objFunctions->numberFormat($totalPriceCurrency.AmountCurrency)}</span>
                            {else}
                                <span>{$objFunctions->numberFormat($total_price)}</span>
                            {/if}
                            {$totalPriceCurrency.TypeCurrency}
                        </div>
                    </div>
                </div>

                <div class='clear'></div>

{*                {$objFactor->getPassengersHotel()}*}
{*                <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title l-p-p-header l-p-p-header-change site-bg-main-color">*}
{*                <i class="icon-table"></i>*}
{*                <h3>##Listpassengers##</h3>*}
{*                </div>*}
{*                <div class='hotel-booking-passengers'>*}
{*                    <div class="table-responsive">*}
{*                    <table id="passengers" class="display" cellspacing="0" width="100%">*}

{*                    <thead>*}
{*                    <tr>*}
{*                    <th>##Ages##</th>*}
{*                    {if $smarty.const.SOFTWARE_LANG eq 'fa'  && ($hotelDetail['source_id'] eq '29' && $hotelDetail['is_internal'] eq 1)}*}
{*                        <th>##Name##</th>*}
{*                    {/if}*}
{*                    {if $hotelDetail['source_id'] neq '29' || ($hotelDetail['source_id'] eq '29' && $hotelDetail['is_internal'] neq 1)}*}
{*                        <th>##Nameenglish##</th>*}
{*                    {/if}*}
{*                    {if $smarty.const.SOFTWARE_LANG eq 'fa' && ($hotelDetail['source_id'] eq '29' && $hotelDetail['is_internal'] eq 1)}*}
{*                        <th>##Family##</th>*}
{*                    {/if}*}
{*                     {if $hotelDetail['source_id'] neq '29' || ($hotelDetail['source_id'] eq '29' && $hotelDetail['is_internal'] neq 1)}*}
{*                        <th>##Familyenglish##</th>*}


{*                     {/if}*}
{*                        {if $hotelDetail['source_id'] neq '29'}*}
{*                            <th>##Happybirthday##</th>*}
{*                        {/if}*}

{*                    <th>##Numpassport##/##Nationalnumber##</th>*}
{*                    </tr>*}
{*                    </thead>*}
{*                    <tbody>*}
{*                    {foreach $objFactor->temproryHotel.passenger as $i=>$passenger}*}
{*                    <tr>*}
{*                    <td>*}
{*                    ##{$passenger['passenger_ageCategory']}##*}
{*                    </td>*}
{*                    {if $smarty.const.SOFTWARE_LANG eq 'fa'  && ($hotelDetail['source_id'] eq '29' && $hotelDetail['is_internal'] eq 1)}*}
{*                        <td>*}
{*                        <p>{$passenger['passenger_name']}</p>*}
{*                        </td>*}
{*                    {/if}*}
{*                    {if $hotelDetail['source_id'] neq '29'  || ($hotelDetail['source_id'] eq '29' && $hotelDetail['is_internal'] neq 1)}*}
{*                    <td>*}
{*                    <p>{$passenger['passenger_name_en']}</p>*}
{*                    </td>*}
{*                    {/if}*}
{*                    {if $smarty.const.SOFTWARE_LANG eq 'fa' && ($hotelDetail['source_id'] eq '29' && $hotelDetail['is_internal'] eq 1)}*}
{*                        <td>*}
{*                        <p>{$passenger['passenger_family']}</p>*}
{*                        </td>*}
{*                    {/if}*}
{*                        {if $hotelDetail['source_id'] neq '29'  || ($hotelDetail['source_id'] eq '29' && $hotelDetail['is_internal'] neq 1)}*}
{*                    <td>*}

{*                    <p>{$passenger['passenger_family_en']}</p>*}
{*                    </td>*}
{*                        {/if}*}
{*                        {if $hotelDetail['source_id'] neq '29'}*}
{*                    <td>*}
{*                    <p>{if !$passenger['passenger_birthday']} {$passenger['passenger_birthday_en']} {else} {$passenger['passenger_birthday']}{/if}</p>*}
{*                    </td>*}
{*                        {/if}*}
{*                    <td>*}
{*                    <p>{if $passenger['passenger_national_code'] eq ''}{$passenger['passportNumber']}{else}{$passenger['passenger_national_code']}{/if}</p>*}
{*                    </td>*}
{*                    </tr>*}
{*                    {/foreach}*}

{*                    </tbody>*}


{*                    </table>*}
{*                    </div>*}
{*                </div>*}
{*            </div>*}
{*        </div>*}

        {*start edit here *}

        {*<div class="s-u-content-result {if $objFactor->temproryHotel['type_application'] eq 'externalApi'}is_external_hotel{/if}">*}
            {*<div id="lightboxContainer" class="lightboxContainerOpacity"></div>*}
            {*<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 s-u-passenger-wrapper-change">*}
                {*<input type="hidden" name="typeApplication" id="typeApplication" value="{$objFactor->temproryHotel['type_application']}">*}
                {*<span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">*}
            {*<i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart10"></i> ##Invoice##*}
                    {*<i class="ravis-icon-hotel zmdi-hc-fw mart10"></i> {$objFactor->temproryHotel['hotel_name']}*}
        {*</span>*}

                {*<div class="hotel-booking-room marb0">*}

                    {*<div class="col-md-3 nopad">*}

                        {*{if $objFactor->temproryHotel['type_application'] eq 'reservation'}*}
                            {*<div class="ribbon-special-hotel"><span><i> ##Specialhotel## </i></span></div>*}
                        {*{/if}*}

                        {*<div class="hotel-booking-room-image">*}
                            {*<a>*}
                                {*<img src="{$objFactor->temproryHotel['hotel_pictures']}" alt="hotel-image">*}
                            {*</a>*}
                        {*</div>*}
                    {*</div>*}

                    {*<div class="col-md-9 ">*}
                        {*<div class="hotel-booking-room-content">*}
                            {*<div class="hotel-booking-room-text">*}
                                {*<h4 class="hotel-booking-room-name"> {$objFactor->temproryHotel['hotel_name']} </h4>*}

                                {*<span class="hotel-star">*}
                                {*{for $s=1 to $objFactor->temproryHotel['hotel_starCode']}*}
                                    {*<i class="fa fa-star" aria-hidden="true"></i>*}
                                {*{/for}*}
                                    {*{for $ss=$s to 5}*}
                                        {*<i class="fa fa-star-o" aria-hidden="true"></i>*}
                                    {*{/for}*}
                            {*</span>*}
                                {*{if $objFactor->temproryHotel['hotel_address']}*}
                                    {*<span class="hotel-booking-room-content-location ">*}
                                {*{$objFactor->temproryHotel['hotel_address']}*}
                           {*</span>*}
                                {*{/if}*}
                                {*{if $objFactor->temproryHotel['hotel_rules']}*}
                                    {*<p class="hotel-booking-roomm-description hotel-result-item-rule">*}
                                        {*<span class="fa fa-bell-o"></span>*}
                                        {*{$objFactor->temproryHotel['hotel_rules']}*}
                                    {*</p>*}
                                {*{/if}*}
                            {*</div>*}

                            {*<div class="hotel-booking-room-text">*}
                                {*<ul>*}
                                    {*<li class="hotel-check-text"><i class="fa fa-calendar-times-o"></i> ##Enterdate## :*}
                                        {*<span class="hotel-check-date"*}
                                              {*dir="rtl">{$objFactor->temproryHotel['start_date']}</span></li>*}
                                    {*<li class="hotel-check-text"><i class="fa fa-calendar-check-o"></i> ##Exitdate## :*}
                                        {*<span class="hotel-check-date"*}
                                              {*dir="rtl">{$objFactor->temproryHotel['end_date']}</span></li>*}
                                    {*<li class="hotel-check-text"><i*}
                                                {*class="fa fa-bed"></i> {$objFactor->temproryHotel['number_night']} ##Night##*}
                                    {*</li>*}
                                {*</ul>*}
                            {*</div>*}

                        {*</div>*}
                    {*</div>*}
                {*</div>*}




            {*</div>*}
            {*<div class="hotel-booking-room s-u-passenger-wrapper-change">*}

                {*<h4 class="tableOrderHeadTitle site-bg-main-color">*}
                    {*<span>##Listroom##</span>*}
                {*</h4>*}
                {*<div class="rp-tableOrder site-border-main-color">*}
                    {*<div class="table-responsive">*}
                        {*<div class="table_hotel_nz">*}
                            {*{if $objFactor->temproryHotel['is_internal']}*}
                                {*{foreach  $objFactor->temproryHotel['room']  as $room}*}
                                    {*{assign var="has_breakfast" value=strpos($room['room_name'],'صبحانه')}*}
                                    {*<div class="thead_hotel">*}
                                        {*<div class="tr_hotel">*}

                                            {*<div class="th_hotel">##Informationbed##</div>*}
                                            {*{if $room['extra_bed_price'] and $room['extra_bed_count']}*}
                                                {*<div class="th_hotel ">##ExtrabedPrice##</div>*}
                                                {*<div class="th_hotel ">##Extrabed##</div>*}
                                            {*{/if}*}
                                            {*{if $room['extra_child_count'] and $room['extra_child_price']}*}
                                                {*<div class="th_hotel">##TotalChildPrice##</div>*}
                                                {*<div class="th_hotel">##Chd##</div>*}
                                            {*{/if}*}
                                            {*<div class="th_hotel hidden-xs">{if $has_breakfast}##Serviceroom##{/if}</div>*}
                                            {*<div class="th_hotel hidden-xs">##Priceforanynight##</div>*}
                                            {*<div class="th_hotel">##TotalPrice##</div>*}
                                        {*</div>*}
                                    {*</div>*}
                                    {*<div class="tbody_hotel">*}
                                        {*<div data-room-index="{$room['room_index']}" class="tr_hotel">*}
                                            {*<div class="th_hotel ">*}
                                                {*<h5 class="roomsTitle">{$room['room_name']}</h5>*}
                                                {*<div class="hidden-md-up roomCapacity">*}
                                                    {*<h5 class="" style="display: inline-block; width: 100%; font-size: 12px;">*}
                                                        {*{$objFunctions->StrReplaceInXml(['@@count@@'=>$room['room_count']],'RoomCountNumber')}*}
                                                    {*</h5>*}
                                                    {*<input type="hidden" name="RoomCount{$room['room_id']}" id="RoomCount{$room['room_id']}" value="{$room['room_count']}">*}
                                                {*</div>*}
                                            {*</div>*}
                                            {*{if $room['extra_bed_price'] and $room['extra_bed_count']}*}
                                                {*<div class=" th_hotel hidden-xs">*}
                                                    {*<h5 class="roomCapacity"><i class="txtIcon ng-binding">{$room['extra_bed_price']}</i></h5>*}
                                                    {*<input type="hidden" name="ExtraBedPrice{$room['room_id']}" id="RoomCount{$room['room_id']}"*}
                                                           {*value="{$room['extra_bed_price']}">*}
                                                {*</div>*}

                                                {*<div class=" th_hotel hidden-xs">*}
                                                    {*<h5 class="roomCapacity"><i class="txtIcon ng-binding">{$room['extra_bed_count']}</i>*}
                                                    {*</h5>*}
                                                    {*<input type="hidden" name="ExtraBed{$room['room_id']}" id="RoomCount{$room['room_id']}"*}
                                                           {*value="{$room['extra_bed_count']}">*}
                                                {*</div>*}
                                            {*{/if}*}

                                            {*{if $room['extra_child_count'] and $room['extra_child_price']}*}
                                                {*<div class=" th_hotel hidden-xs">*}
                                                    {*<h5 class="roomCapacity"><i class="txtIcon ng-binding">{$room['extra_child_count']}</i>*}
                                                    {*</h5>*}
                                                    {*<input type="hidden" name="ExtraChild{$room['room_id']}" id="RoomCount{$room['room_id']}"*}
                                                           {*value="{$room['extra_child_count']}">*}
                                                {*</div>*}
                                            {*{/if}*}

                                            {*<div class="th_hotel  hidden-xs">*}
                                                {*{if $has_breakfast}*}
                                                    {*<ul class="HotelRoomFeatureList">*}
                                                        {*<li class="Breakfast"><i class="fa fa-coffee"></i> ##Breakfast##</li>*}
                                                    {*</ul>*}
                                                {*{/if}*}
                                            {*</div>*}

                                            {*<div class="th_hotel  hidden-xs">*}
                                                {*{assign var="everyNightCurrency" value=$objFunctions->CurrencyCalculate($room['price_current'], $smarty.post.CurrencyCode)}*}
                                                {*<span class="pricePerNight">*}
                                            {*<span class="currency">*}
                                                {*{$objFunctions->numberFormat($everyNightCurrency.AmountCurrency)}*}
                                            {*</span>*}
                                                    {*{$everyNightCurrency.TypeCurrency}*}
                                        {*</span>*}
                                            {*</div>*}


                                            {*<div class="th_hotel">*}
                                                {*{assign var="roomCurrency" value=$objFunctions->CurrencyCalculate($room['room_price'], $smarty.post.CurrencyCode)}*}

                                                {*<div data-extra-bed-price="{$room['extra_bed_price']}" data-child-price="{$room['extra_child_price']}"*}
                                                     {*class="roomFinalPrice ">{$objFunctions->numberFormat($roomCurrency.AmountCurrency)} {$roomCurrency.TypeCurrency}</div>*}
                                            {*</div>*}
                                        {*</div>*}
                                    {*</div>*}
                                {*{/foreach}*}
                            {*{else}*}
                                {*<div class="thead_hotel">*}
                                    {*<div class="tr_hotel">*}
                                        {*<div class="th_hotel">##Informationbed##</div>*}
                                        {*<div class="th_hotel">##CapacityRoom##</div>*}
                                        {*<div class="th_hotel" style="max-width:40%">##Remarks##</div>*}
                                    {*</div>*}
                                {*</div>*}
                                {*<div class="tbody_hotel">*}
                                    {*{foreach  $objFactor->temproryHotel['room']  as $room}*}
                                        {*<div data-room-index="{$room['room_index']}" class="tr_hotel">*}
                                            {*<div class="th_hotel ">*}
                                                {*<h5 class="roomsTitle">{$room['room_name']}</h5>*}
                                                {*<div class="hidden-md-up roomCapacity">*}
                                                    {*<i class="fa fa-user txt15"></i>*}
                                                    {*<i class="inIcon">x</i>*}
                                                    {*<i class="txtIcon ng-binding">{$room['max_capacity_count_room']}</i>*}

                                                    {*<h5 class="" style="display: inline-block; width: 100%; font-size: 12px;">*}
                                                        {*{$objFunctions->StrReplaceInXml(['@@count@@'=>$room['room_count']],'RoomCountNumber')}*}
                                                    {*</h5>*}
                                                    {*<input type="hidden" name="RoomCount{$room['room_id']}" id="RoomCount{$room['room_id']}"*}
                                                           {*value="{$room['room_count']}">*}
                                                {*</div>*}
                                            {*</div>*}

                                            {*<div class="th_hotel">*}
                                                {*{$TotalPrice = $room['room_price_current']}*}
                                                {*{$room['AdultsCount']} ##Adult##*}
                                                {*{$room['ChildrenCount']} ##Child##*}
                                            {*</div>*}
                                            {*<div class="th_hotel" style="max-width: 150px;">*}
                                                {*<div class="remarks collapsed">*}
                                                    {*{$room['remarks']}*}
                                                {*</div>*}
                                            {*</div>*}
                                        {*</div>*}
                                    {*{/foreach}*}
                                {*</div>*}
                            {*{/if}*}
                        {*</div>*}
                    {*</div>*}
                {*</div>*}


                {*<div class="DivTotalPrice ">*}
                    {*{assign var="paymentPriceCurrency" value=$objFunctions->CurrencyCalculate($objFactor->paymentPrice, $smarty.post.CurrencyCode)}*}
                    {*<div class="fltl">##Amountpayable## :*}
                        {*<span>{$objFunctions->numberFormat($paymentPriceCurrency.AmountCurrency)}</span> {$paymentPriceCurrency.TypeCurrency}*}
                    {*</div>*}
                {*</div>*}
            {*</div>*}
            {*<div class="main-Content-bottom Dash-ContentL-B">*}
                {*<div class="main-Content-bottom-table Dash-ContentL-B-Table">*}
                    {*{if $objFactor->temproryHotel['passenger'][0]['passenger_name'] neq ''}*}
                        {*<div class="main-Content-bottom-table-Title Dash-ContentL-B-Title l-p-p-header l-p-p-header-change site-bg-main-color">*}
                            {*<i class="icon-table"></i>*}
                            {*<h3>##Listpassengers##</h3>*}
                        {*</div>*}
                        {*<div class="table-responsive">*}
                            {*<table id="passengers" class="display" cellspacing="0" width="100%">*}

                                {*<thead>*}
                                {*<tr>*}
                                    {*<th>##Ages##</th>*}
                                    {*<th>##Name##</th>*}
                                    {*<th>##Nameenglish##</th>*}
                                    {*<th>##Family##</th>*}
                                    {*<th>##Familyenglish##</th>*}
                                    {*<th>##Happybirthday##</th>*}
                                    {*<th>##Numpassport##/##Nationalnumber##</th>*}
                                {*</tr>*}
                                {*</thead>*}
                                {*<tbody>*}

                                {*{foreach $objFactor->temproryHotel['passenger'] as $i=>$passenger}*}
                                    {*<tr>*}
                                        {*<td>*}
                                            {*##{$passenger['passenger_ageCategory']}##*}
                                        {*</td>*}
                                        {*<td>*}
                                            {*<p>{$passenger['passenger_name']}</p>*}
                                        {*</td>*}
                                        {*<td>*}
                                            {*<p>{$passenger['passenger_name_en']}</p>*}
                                        {*</td>*}
                                        {*<td>*}
                                            {*<p>{$passenger['passenger_family']}</p>*}
                                        {*</td>*}
                                        {*<td>*}
                                            {*<p>{$passenger['passenger_family_en']}</p>*}
                                        {*</td>*}
                                        {*<td>*}
                                            {*<p>{if !$passenger['passenger_birthday']} {$passenger['passenger_birthday_en']} {else} {$passenger['passenger_birthday']}{/if}</p>*}
                                        {*</td>*}
                                        {*<td>*}
                                            {*<p>{if $passenger['passenger_national_code'] eq ''}{$passenger['passportNumber']}{else}{$passenger['passenger_national_code']}{/if}</p>*}
                                        {*</td>*}
                                    {*</tr>*}
                                {*{/foreach}*}

                                {*</tbody>*}


                            {*</table>*}
                        {*</div>*}
                    {*{elseif $objFactor->temproryHotel['type_application'] eq 'reservation'}*}
                        {*<div class="main-Content-bottom-table-Title Dash-ContentL-B-Title l-p-p-header l-p-p-header-change site-bg-main-color">*}
                            {*<i class="icon-table"></i>*}
                            {*<h3>##TravelerGuard##</h3>*}
                        {*</div>*}
                        {*<div class="Dash-ContentL-Title-leader">*}
                            {*<span class="leaderRoom-Title">  ##Namefamily##  :</span>*}
                            {*<span class="leaderRoom">{$objFactor->temproryHotel['passenger_leader_fullName']}</span>*}
                            {*<span class="leaderRoom-Title">##Telephone## :</span>*}
                            {*<span class="leaderRoom">{$objFactor->temproryHotel['passenger_leader_tell']}</span>*}
                        {*</div>*}
                    {*{/if}*}
                {*</div>*}
            {*</div>*}
            {*<div class="clear"></div>*}

            {*<!--  برای رزرو یک اتاق یا بیشتر به صورت موقت، و بازگرداندن یک شماره درخواست و شماره ( پی ان آر ) برای اعمال دستورات بر روی این رزرو-->*}
            {*<input type="hidden" value="{$requestNumber}" name="requestNumber" id="requestNumber">*}
            {*<input type="hidden" name="paymentPrice" id="paymentPrice" value="{$objFactor->paymentPrice}">*}

        {*</div>*}
        {*<div class="clear"></div>*}
        {*end edit here*}
    {/if}

    <div class="clear"></div>

    {$objFactor->getPassengersHotel()}

    <code style="display:none;color: #ff6802;">
        {$objFactor->temproryHotel|json_encode}
    </code>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40" style="padding: 0">
        <div class="s-u-result-wrapper">
            <div class="s-u-result-item-change direcR iranR txt12 txtRed s-u-result-item-RulsCheck">
                <div style="text-align: right">
                    {assign var="serviceType" value=$objFunctions->TypeServiceHotel($smarty.post.typeApplication)} {* لازم برای انتخاب نوع بانک *}
                    {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] =='5'}
                        <div class="s-u-result-item-RulsCheck-item">
{*                            <input class="FilterHoteltype Show_all FilterHoteltypeName-top" id="discount_code" name=""*}
{*                                   value="" type="checkbox">*}
{*                            <label class="FilterHoteltypeName site-main-text-color-a" for="discount_code">##Ihavediscountcodewantuse##</label>*}

                            <div class="col-sm-12  parent-discount">
{*                                <div class="row separate-part-discount">*}
{*                                    <div class="col-sm-6 col-lg-4 col-10 pr-0">*}
{*                                        <label for="discount-code" class="label-discount-code">##RegisterDiscountCode##</label>*}
{*                                        <input type="text" id="discount-code" class="form-control" placeholder="##Enteryourdiscountcode##">*}
{*                                        <span class="discount-code-error"></span>*}
{*                                    </div>*}
{*                                    <div class="col-sm-2 col-2 d-flex p-0">*}
{*                                    <span class="input-group-btn">*}
{*                                        <input type="hidden" name="priceWithoutDiscountCode"*}
{*                                               id="priceWithoutDiscountCode"*}
{*                                               value="{$total_price}"/>*}
{*                                        <button type="button"*}
{*                                                onclick="setDiscountCode('{$serviceType}', '{$smarty.post.CurrencyCode}')"*}
{*                                                class="site-secondary-text-color site-bg-main-color site-bg-main-color iranR discount-code-btn">##Apply##</button>*}
{*                                    </span>*}
{*                                    </div>*}
{*                                </div>*}

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
                                            <button type="button" onclick="setDiscountCode('{$serviceType}', '{$smarty.post.CurrencyCode}')" class="site-bg-main-color">
                                                ##Apply##
                                            </button>
                                        </div>
                                        <span class="discount-code-error"></span>
                                    </div>
                                </div>

                                <div class="row separate-part-discount">
                                    <div class="info-box__price info-box__item pull-left">
                                        <div class="item-discount">
                                            <span class="item-discount__label">##Amountpayable## :</span>
                                            <span class="price__amount-price price-after-discount-code">{$objFunctions->numberFormat($paymentPriceCurrency.AmountCurrency)}</span>
                                            <span class="price__unit-price">{$paymentPriceCurrency.TypeCurrency}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/if}
                    <div class="s-u-result-item-RulsCheck-item d-flex justify-content-between flex-sm-row flex-column">
                        <div class="d-flex">
                        <input class="FilterHoteltype Show_by_filters FilterHoteltypeName-top" id="RulsCheck"
                               name="heck_list1" value="" type="checkbox">
                        <label class="FilterHoteltypeName site-main-text-color-a " for="RulsCheck">
                            <a class="site-main-text-color" href="{$smarty.const.URL_RULS}" target="_blank">##Rules## </a>&zwnj; ##IhavestudiedIhavenoobjection##
                        </label>
                    </div>
                        <div class="btn-final-confirmation btns_factors_n" id="btn-final-Reserve">
                            <div class="next_hotel__">
                                <a href="" onclick="return false" class="f-loader-check loaderfactors" id="loader_check"
                                   style="display:none"></a>
                                <button class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-bg-main-color"
                                        id="final_ok_and_insert_passenger" onclick="ReserveTemproryNew('{$smarty.post.factorNumber}', '{$smarty.post.typeApplication}','{$smarty.post.requestNumber}')">##Approvefinal## </button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div id="messageBook" class="error-flight"></div>
    <!-- OnRequest -->
    <div id="cancelHotel" class="displayN">
        <div class="main-cancel-box s-u-p-factor-bank s-u-p-factor-bank-change">
            <h4 class="site-bg-main-color site-bg-color-border-bottom site-main-button-flat-color">
                ##Cancelrequest##</h4>
            <div class="s-u-select-bank mart30">
                <span> ##Yourrequesthascanceledtolackof##</span>
                <span class="author"><i>##Youcanbookanotherhotel##</i></span>
            </div>
            <div class="s-u-select-update-wrapper">
                <a class="s-u-select-update s-u-select-update-change site-main-button-flat-color"
                   onclick="backToResultHotelLocal('{$objFactor->city}', '{$objFactor->startDate}', '{$objFactor->numberNight}')">
                    ##Anotherhotel## </a>
            </div>
        </div>
    </div>
    <div id="onRequestOnlinePassenger" class="displayN">
        <div class="Attention Attention-change">
            <div class="s-u-select-bank mart30 marb30 bg-yellow">
                <input type="hidden" name="factorNumber" id="factorNumber"
                       value="{$objFactor->temproryHotel['factor_number']}">
                <span class="bg-yellow"> ##Dearguestsuccessfullyregisteredbooking##
                <br>
                <br>
                <span class="site-main-text-color"> ##HotelMoreDetailWithFactorNumber## </span>
                </span>
                <div class="msg">
                <span class="box-offline-reserve offline-reserve-msg">
                        <span class="msg-time">
                       <div class="counter counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"
                            style="direction: ltr">10:00</div>
                    </span>
                </span>
                    <span class="box-offline-reserve offline-factorNumber"> ##Invoicenumber##: {$objFactor->temproryHotel['factor_number']}</span>
                </div>
            </div>
        </div>
        <div class="btn-final-confirmation">
            <a class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-bg-main-color"
               onclick="backToResultHotelLocal('{$objFactor->city}', '{$objFactor->startDate}', '{$objFactor->numberNight}')">
                ##Return## </a>
        </div>
    </div>
    <div id="onRequest" class="displayN">
        <div class="Attention Attention-change">
            <div class="s-u-select-bank mart30 marb30 bg-yellow">
                <input type="hidden" name="factorNumber" id="factorNumber"
                       value="{$objFactor->temproryHotel['factor_number']}">
                <span class="bg-yellow"> ##Dearguestsuccessfullyregisteredbooking##
                <br>
                <br>
                <span class="site-main-text-color"> ##HotelMoreDetailWithFactorNumber## </span>
                </span>
                <div class="msg">
                    <span class="box-offline-reserve offline-reserve-msg">
                        <span class="msg-time">
                           <div class="counter counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"
                                style="direction: ltr">10:00</div>
                        </span>
                    </span>
                    <span class="box-offline-reserve offline-factorNumber"> ##Invoicenumber##: {$objFactor->temproryHotel['factor_number']}</span>
                </div>
            </div>
        </div>
        <div class="btn-final-confirmation">
            <a class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-main-button-color"
               onclick="backToResultHotelLocal('{$objFactor->city}', '{$objFactor->startDate}', '{$objFactor->numberNight}')">
                ##Return## </a>
        </div>
    </div>
    <div id="confirmHotel" class="displayN">
        <div class="Attention Attention-change">
            <div class="s-u-select-bank mart30 marb30 bg-yellow">
                <span class="author">
                    <i class="bg-yellow d-flex align-items-center"> ##Dearguestrequestapprovedbookingfee##</i>
                </span>
                <div class='d-flex flex-column col-12 col-md-8 mx-auto'>
                    <div id='webhook-change-price' class="alert alert-warning displayN" role="alert">
                        ##webhookPriceChange##
                        ##newPrice##: <span class="webhook-new-price"> </span>
                    </div>
                    <div class="alert alert-success text-center" role="alert">
                        ##Invoicenumber##: {$objFactor->temproryHotel['factor_number']}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="AdminChecking" class="displayN">
        <div class="Attention Attention-change">
            <div class="s-u-select-bank mart30 marb30 bg-yellow">
            <span class="author">
                <span class="bg-yellow site-main-text-color"> ##HotelMoreDetailWithFactorNumber##</span>
            </span>
                <div class="msg">
                <span class="box-offline-reserve offline-reserve-msg">
                    ##AdminCheckingMsg##
                </span>
                    <span class="box-offline-reserve offline-factorNumber"> ##Invoicenumber##: {$objFactor->temproryHotel['factor_number']}</span>
                </div>
            </div>
        </div>
    </div>
    <div id="PriceChange" class="displayN">
        <div class="Attention Attention-change">
            <div class="s-u-select-bank mart30 marb30 bg-yellow">
            <span class="author">
                <span class="bg-yellow site-main-text-color"> ##HotelChangePrice##</span>
            </span>
                <div class="msg"
                    <span class="box-offline-reserve offline-factorNumber">
                      ##newPrice##:
                        <span id='total_price'></span>
                    </span>
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

        {assign var="bank_total_price" value=$objFunctions->CurrencyToRial($total_price)}
        {assign var="bankInputs" value=['type_service'=>'hotel','flag' => 'check_credit_hotel', 'factorNumber' => $smarty.post.factorNumber, 'typeApplication' => $smarty.post.typeApplication, 'typeTrip' => 'hotel', 'paymentPrice' => $bank_total_price.AmountRial, 'serviceType' => $serviceType]}
        {assign var="bankAction" value="`$smarty.const.ROOT_ADDRESS`/goBankHotelLocal"}

        {assign var="creditInputs" value=['flag' => 'buyByCreditHotelLocal', 'factorNumber' => $objFactor->temproryHotel['factor_number'], 'typeApplication' => $smarty.post.typeApplication]}
        {assign var="creditAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankHotelNew"}

        {assign var="currencyPermition" value="0"}
        {if $smarty.const.ISCURRENCY && $smarty.post.CurrencyCode > 0}
            {$currencyPermition = "1"}
            {assign var="currencyInputs" value=['flag' => 'check_credit_hotel', 'factorNumber' => $objFactor->temproryHotel['factor_number'], 'typeApplication' => $smarty.post.typeApplication, 'typeTrip' => 'hotelLocal', 'paymentPrice' => $objFactor->paymentPrice, 'serviceType' => $serviceType, 'amount' => $paymentPriceCurrency.AmountCurrency, 'currencyCode' => $smarty.post.CurrencyCode]}
            {assign var="currencyAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankHotelNew"}
        {/if}

        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`paymentMethods.tpl"}
        <!-- payment methods drop down -->


    </div>
    <!--BACK TO TOP BUTTON-->
    <div class="backToTop"></div>
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`hotelTimeoutModal.tpl"}
{literal}
    <script type="text/javascript">
        $(document).ready(function () {
            $('.plus_price_room i').click(function () {
                $(this).parents('.hotel_room_row').find('.box_pricees').toggle();
                $(this).toggleClass('fa fa-times')
                $(this).toggleClass('far fa-list-alt')
            });
            $('.table-responsive').bind('click', function (e) {
                e.stopPropagation();
            });
            $('body').click(function () {
                $('.box_pricees').hide();
                $('.plus_price_room i').removeClass('fa fa-times')
                $('.plus_price_room i').addClass('far fa-list-alt')
            });
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

    <script type="text/javascript">
        function timeForConfirmHotel() {

            setInterval(function () {
              console.log('time for confirm hotel')
                let timeConfirmHotel = $('#timeConfirmHotel').val();
              // timeConfirmHotel = 'yes';
                console.log(timeConfirmHotel);
//                return false;
                if (timeConfirmHotel == 'yes') {

                    let factorNumber = $('#factorNumber').val();
                    $.post(amadeusPath + 'hotel_ajax.php',
                        {
                            dataTypeResult: 'json',
                            factorNumber: factorNumber,
                            flag: 'checkForConfirmHotel'
                        },
                        function (data) {
                      let response = JSON.parse(data);
                          console.log(response);

                            if (response.book =='PreReserve') {
                                $('#timeConfirmHotel').val('no');
                                $('#AdminChecking').addClass('displayN');
                                $('#onRequest').addClass('displayN');
                                $('#onRequestOnlinePassenger').addClass('displayN');
                                $('#confirmHotel').removeClass('displayN');



                                $('.counterBank').counter({});
                                setTimeout(function () {
                                    $('#final_ok_and_insert_passenger').removeAttr("onclick").attr("disabled", true).css('cursor', 'not-allowed').text('##Accepted##');

                                    $('.s-u-p-factor-bank-change').show();
                                    $('#loader_check').css("display", "none");
                                    // $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow');
                                }, 2000);
                                if(response.price_changed){
                                  $('#webhook-change-price').removeClass('displayN');
                                  $('.DivTotalPrice .fltl span').html(number_format(response.total_payment_price));
                                  $('.webhook-new-price').html(number_format(response.total_payment_price));

                                }
                            } else if (response.book == 'Cancelled') {
                                $('#timeConfirmHotel').val('no');
                                $('#onRequest').addClass('displayN');
                                $('#onRequestOnlinePassenger').addClass('displayN');
                                $('#AdminChecking').addClass('displayN');
                                $('#cancelHotel').removeClass('displayN');
                            } else if (response.admin_checked == '1') {
                                $('#timeConfirmHotel').val('no');
                                $('#factor_bank').addClass('displayN');
                                $('#confirmHotel').addClass('displayN');
                                $('#onRequest').addClass('displayN');
                                $('#onRequestOnlinePassenger').addClass('displayN');
                                $('#cancelHotel').addClass('displayN');
                                $('#AdminChecking').removeClass('displayN');
                            } else if (response.book == 'NoReserve') {
                              console.log('Book Method Error ');
                                $('#timeConfirmHotel').val('no');
                                $('#factor_bank').addClass('displayN');
                                $('#confirmHotel').addClass('displayN');
                                $('#onRequest').addClass('displayN');
                                $('#onRequestOnlinePassenger').addClass('displayN');
                                $('#cancelHotel').removeClass('displayN');
                                $('#AdminChecking').addClass('displayN');
                            }
                        });
                }

            }, 60000);

        }

        $('.counter').on('counterStop', function () {
          console.log('counnter sms')
            $('.lazy_loader_flight').slideDown({
                start: function () {
                    $(this).css({
                        display: "flex"
                    })
                }
            });

            var factorNumber = $('#factorNumber').val();
            $.post(amadeusPath + 'hotel_ajax.php',
                {
                    factorNumber: factorNumber,
                  dataTypeResult: 'json',
                    flag: "checkForConfirmHotel"
                },
                function (data) {
                  let response = JSON.parse(data);

                    if (response.book == 'PreReserve') {
                        $('#AdminChecking').addClass('displayN')
                        $('#onRequestOnlinePassenger').addClass('displayN');
                        $('#confirmHotel').removeClass('displayN');
                        $('.counterBank').counter({});
                        setTimeout(function () {
                            $('#final_ok_and_insert_passenger').removeAttr("onclick").attr("disabled", true).css('cursor', 'not-allowed').text('##Accepted##');

                            $('.s-u-p-factor-bank-change').show();
                            $('#loader_check').css("display", "none");
                            $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow');
                        }, 2000);
                      if(response.price_changed){

                        $('#webhook-change-price').removeClass('displayN');
                        $('.DivTotalPrice .fltl span').html(number_format(response.total_payment_price));
                        $('.webhook-new-price').html(number_format(response.total_payment_price));

                        $('.counter').counterUp({
                          delay: 100,
                          time: 10000
                        });
                      }
                    } else if (response.book == 'NoReserve') {

                      $('#timeConfirmHotel').val('no');
                      $('#factor_bank').addClass('displayN');
                      $('#confirmHotel').addClass('displayN');
                      $('#onRequest').addClass('displayN');
                      $('#onRequestOnlinePassenger').addClass('displayN');
                      $('#cancelHotel').removeClass('displayN');
                      $('#AdminChecking').addClass('displayN');
                      $('.counter').counterDown({
                        delay: 100,
                        time: 0
                      });
                    } else if (response.book == 'Cancelled') {

                        $('#onRequestOnlinePassenger').addClass('displayN');
                        $('#AdminChecking').addClass('displayN');
                        $('#cancelHotel').removeClass('displayN');
                      $('.counter').counterDown({
                        delay: 100,
                        time: 0
                      });
                    } else if (response.book == 'AdminChecking') {
                        $('#factor_bank').addClass('displayN');
                        $('#confirmHotel').addClass('displayN');
                        $('#onRequestOnlinePassenger').addClass('displayN');
                        $('#cancelHotel').addClass('displayN');
                        $('#AdminChecking').removeClass('displayN');
                      $('.counter').counterDown({
                        delay: 100,
                        time: 0
                      });
                    } else {

                        $.post(amadeusPath + 'hotel_ajax.php',
                            {
                                factorNumber: factorNumber,
                                flag: "cancelReserveHotel"
                            },
                            function (data) {
                                $('#AdminChecking').addClass('displayN')
                                $('#factor_bank').addClass('displayN');
                                $('#confirmHotel').addClass('displayN');
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
                    location.href = locationHref;

                });

        });

    </script>
    <!-- modal login    -->
    <script type="text/javascript" src="assets/js/modal-login.js"></script>
{/literal}

{/if}
{literal}
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
      
        $(document).on('click', '.remarks', function () {
            $(this).toggleClass('collapsed');
        });
    </script>
    <style>
        .remarks {
            padding: 10px;
            cursor: pointer;
            direction: ltr;
            text-align: justify;
        }

        .remarks.collapsed {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
{/literal}

