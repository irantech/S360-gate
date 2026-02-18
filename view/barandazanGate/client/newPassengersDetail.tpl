
{load_presentation_object filename="detailHotel" assign="objHotel"}
<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>
{assign var="InfoMember" value=$objFunctions->infoMember($objSession->getUserId())}

{assign var="requestNumber" value=$smarty.post.requestNumber}
{*{$objHotel->getInfoHotelRoom($smarty.post.idHotel_reserve)}*}
{*{$objHotel->getPassengersDetailHotel($smarty.post.factorNumber, $smarty.post.startDate_reserve, $smarty.post.nights_reserve, $smarty.post.TotalNumberRoom_Reserve) assign="temproryHotel"}*}
<code style="display: none;color:red">Post:<br/>{$smarty.post|json_encode:256}</code>
{assign var="hotelDetail" value=$objHotel->getTemporaryHotelDetails($smarty.post.factorNumber)}

{assign var="temproryRooms" value=$objHotel->getTemporaryRooms($smarty.post.factorNumber)}
{assign var="researchAddress" value=$objHotel->generateResearchAddress($smarty.post.factorNumber)}
{assign  var="source_id" value=$smarty.post.source_id}

<pre style="color:cyan;display: none;">hotelDetail:<br/>{$hotelDetail|json_encode:256}</pre>
<pre style="display:none;color:lightGray">temproryRooms:<br/>{$temproryRooms|json_encode:256}</pre>
<pre style="display:none;color:lightGray">researchAddress:<br/>{$researchAddress}</pre>

{assign  var="IsInternal" value=$smarty.post.IsInternal}
{*{$IsInternal|var_dump}*}
{if $IsInternal eq 'true'}
    {$IsInternal = '1'}
{/if}

{if ($IsInternal eq '1'  && ($source_id neq '17'  and $source_id neq '29'))}

    {assign var="typeApplication" value="api"}
    {assign var="temproryHotelLocal" value=$objHotel->getPassengersDetailHotelLocal($smarty.post.factorNumber, $smarty.post.startDate_reserve, $smarty.post.nights_reserve, $smarty.post.TotalNumberRoom_Reserve)}
    {*    {$temproryHotelLocal|var_dump}*}
{else}

    {assign var="typeApplication" value="externalApi"}
    {assign var="temproryHotelLocal" value=$objHotel->getPassengersDetailHotelExternal($smarty.post.factorNumber, $smarty.post.startDate_reserve, $smarty.post.nights_reserve, $smarty.post.TotalNumberRoom_Reserve,$smarty.post.searchRooms)}

{/if}


{load_presentation_object filename="passengersDetailLocal" assign="objDetail"}

{assign var="passengers" value=$objDetail->getCustomers()}
{assign var="adultCount" value=0}
{assign var="childCount" value=0}

<div id="steps" style="margin: 10px 0">
    <div class="steps_items">
        <div class="step done">
            <span class=""><i class="fa fa-check"></i></span>
            <h3>##Selectionhotel##</h3>
        </div>
        <i class="separator  done "></i>
        <div class="step done">
            <span class="flat_icon_airplane"><i class="fa fa-check"></i></span>
            <h3>##StayInformation##</h3>

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
            <h3> ##PassengersInformation## </h3>
        </div>
        <i class="separator"></i>
        <div class="step ">
            <span class="flat_icon_airplane">
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                     width="128.000000pt" height="128.000000pt" viewBox="0 0 128.000000 128.000000"
                     preserveAspectRatio="xMidYMid meet">
<metadata>
Created by potrace 1.16, written by Peter Selinger 2001-2019
</metadata>
<g transform="translate(0.000000,128.000000) scale(0.100000,-0.100000)"
   fill="#000000" stroke="none">
<path d="M499 1247 c-223 -115 -217 -433 9 -544 73 -36 182 -38 253 -6 237
107 248 437 17 552 -52 27 -72 31 -139 31 -68 0 -85 -4 -140 -33z m276 -177
c19 -21 18 -22 -75 -115 l-94 -95 -53 52 -53 52 22 23 22 23 31 -30 31 -30 69
70 c38 39 72 70 76 70 3 0 14 -9 24 -20z"/>
<path d="M70 565 l0 -345 570 0 570 0 0 345 0 345 -104 0 -104 0 -6 -34 c-9
-47 -75 -146 -124 -184 -75 -60 -126 -77 -232 -77 -106 0 -157 17 -232 77 -49
38 -115 137 -124 184 l-6 34 -104 0 -104 0 0 -345z m980 -150 l0 -105 -145 0
-145 0 0 105 0 105 145 0 145 0 0 -105z m-410 -75 l0 -30 -205 0 -205 0 0 30
0 30 205 0 205 0 0 -30z"/>
<path d="M0 150 c0 -45 61 -120 113 -139 39 -15 1015 -15 1054 0 52 19 113 94
113 139 0 7 -207 10 -640 10 -433 0 -640 -3 -640 -10z"/>
</g>
</svg>
            </span>
            <h3> ##Reservationhotel## </h3>
        </div>
    </div>
    <div class="counter counter-analog"
         data-direction="down"
         data-format="59:59"
         data-stop="00:00"
         style="direction: ltr"> 10:00</div>
</div>
<div>

</div>


<div id="lightboxContainer" class="lightboxContainerOpacity"></div>
<!-- last passenger list -->
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`passengerPopup.tpl"}
<!--end  last passenger list -->


{if $hotelDetail}
    <form method="post" id="formHotel" action="" class="w-100 {if $typeApplication eq 'externalApi'}is_external_hotel{/if}">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 s-u-passenger-wrapper-change">
     <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
         ##Youbookingfollowinghotel## <i class="ravis-icon-hotel-title  zmdi-hc-fw"></i>
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
                            {if isset($hotelDetail['hotel_name']) and !empty($hotelDetail['hotel_name'])}
                                <h4 class="hotel-booking-room-name"> {$hotelDetail['hotel_name']} </h4>
                            {/if}
                            {if isset($hotelDetail['hotel_starCode']) and !empty($hotelDetail['hotel_starCode'])}
                                <span title="{$hotelDetail['hotel_starCode']} ##Star##" class="hotel-star" style="padding-bottom: 0">
                                {for $s=1 to $hotelDetail['hotel_starCode']}
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                {/for}

                                    {*                                {for $ss=$s to 5}*}
                                    {*                                    <i class="fa fa-star-o" aria-hidden="true"></i>*}
                                    {*                                {/for}*}
                            </span>
                            {/if}
                            {if isset($hotelDetail['hotel_address']) and !empty($hotelDetail['hotel_address'])}
                                <span class="hotel-booking-room-content-location ">
                                 {$hotelDetail['hotel_address']}
                                </span>
                            {/if}
                            {if isset($Hotel) AND $Hotel['rules']}
                                <p class="hotel-booking-roomm-description hotel-result-item-rule">
                                    <span class="fa fa-bell-o"></span>
                                    {$hotelDetail['rules']}
                                </p>
                            {/if}
                        </div>

                        <div class="hotel-booking-room-date">
                            <ul>
                                {if isset($hotelDetail['start_date']) and !empty($hotelDetail['start_date'])}
                                    <li class="hotel-check-text"><i class="fa fa-calendar-times-o"></i> ##Enterdate## :
                                        <span class="hotel-check-date" dir="rtl">{$hotelDetail['start_date']}</span></li>
                                {/if}
                                {if isset($hotelDetail['end_date']) and !empty($hotelDetail['end_date'])}
                                    <li class="hotel-check-text"><i class="fa fa-calendar-check-o"></i> ##Exitdate## :
                                        <span class="hotel-check-date" dir="rtl">{$hotelDetail['end_date']}</span></li>
                                {/if}
                                {if isset($hotelDetail['number_night']) and !empty($hotelDetail['number_night'])}
                                    <li class="hotel-check-text"><i class="fa fa-bed"></i> {$hotelDetail['number_night']}
                                        ##Timenight##
                                    </li>
                                {/if}
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
                                    {if isset($hotelDetail.is_internal) and $hotelDetail.is_internal == 1 }
                                        <div class="th_hotel">##Price##</div>
                                    {else}
                                        <div class="th_hotel">##CapacityRoom##</div>
                                    {/if}
                                </div>
                            </div>

                            <div class="tbody_hotel">
                                {assign var="total_price" value=0}
                                {foreach $temproryRooms as $k=>$room}

                                    {assign var="has_breakfast" value=(strpos($room.room_name,'صبحانه') && !strpos($room.room_name,'بدون صبحانه'))}
                                    {assign var="room_count" value=$room.room_count}

                                    {if isset($c) AND $c eq 1 }
                                        {assign var="roomTypeCodes" value="{$room.room_id}"}
                                        {assign var="numberOfRooms" value="{$room.room_count}"}
                                        {$c = 2}
                                    {else}
                                        {assign var="roomTypeCodes" value="{if isset($roomTypeCodes) }{$roomTypeCodes}{/if},{$room.room_id}"}
                                        {assign var="numberOfRooms" value="{if isset($numberOfRooms) }{$numberOfRooms}{/if},{$room.room_count}"}
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
                                                <input type="hidden" name="child_count-{$room.room_id}" id="child_count-{$room.room_id}" value="{$room.child_count}">
                                                <input type="hidden" name="extra_bed_count-{$room.room_id}" id="extra_bed_count-{$room.room_id}" value="{$room.extra_bed_count}">
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
                                        {if $room.is_internal }

                                            <div class="th_hotel hidden-xs">
                                                {if $has_breakfast neq false }
                                                    <ul class="HotelRoomFeatureList">
                                                        <li class="Breakfast">
                                                            <i class="fa fa-coffee"></i>
                                                            ##Breakfast##
                                                        </li>
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
                                                -
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

                        <i>{$totalPriceCurrency.TypeCurrency}</i>
                    </div>
                </div>
            </div>
        </div>
    </form>
{/if}

<div class="clear"></div>

{if $smarty.post.source_id neq '29'}

    <form method="post" id="formPassengerDetailHotelLocal" action="{$smarty.const.ROOT_ADDRESS}/factorHotelNew">


        <input type="hidden" name="StatusRefresh" id="StatusRefresh" value="NoRefresh">
        <input type="hidden" id="numberRow" value="0">
        <input type="hidden" value="{$requestNumber}" name="requestNumber">
        {*    <code style='color: red;'>{$smarty.post|json_encode}</code>*}

        {*        {var_dump($temproryHotelLocal[0]['is_internal'])}*}
        {*        {var_dump($smarty.post.source_id)}*}

        {if $temproryHotelLocal[0]['is_internal'] eq '1' && ($smarty.post.source_id neq '17' )}

            {assign var="rooms_count" value=0}

            <input type="hidden" name="ZoneFlight" id="ZoneFlight" value="Local">
            {foreach $temproryHotelLocal as $keyRooms => $room}
                {assign var="i" value=0}
                {$rooms_count=($rooms_count+$room['room_count'])}
                {$keyRooms = $keyRooms + 1}
                <input type="hidden" name="roomIndex{$keyRooms}" value="{$room['RoomIndex']}">
                {$NumberRoom = $objHotel->CounterRoomReserve($room['room_id'])*1}
                {$adultCount = $NumberRoom}
                {if $NumberRoom ge 1 }
                    {for $number=1 to $NumberRoom}
                        {$i=$i+1}
                        <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">
                       <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color direcR">
                           {if $NumberRoom eq 1}
                               {$objFunctions->displayRoomName($room.room_name,$number,'',false,true)}
                           {else}
                               {$objFunctions->displayRoomName($room.room_name,$number)}
                               {*{$objFunctions->StrReplaceInXml(['@@room_name@@' => $room.room_name],'HotelSingleRoomDisplayName')}*}
                           {/if}
                           {if $room['extra_bed_count'] gt 0} <small> + {$room['extra_bed_count']} ##Extrabed##</small> {/if}
                           {if $objSession->IsLogin()}
                               <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change" onclick="setHidenFildnumberRow('A{$keyRooms}{$i}')">
                                     <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i> ##Passengerbook##
                                 </span>
                           {/if}
                           <!-- <i class="soap-icon-family"></i> -->
                       </span>
                            <input type="hidden" name="RoomCount_Reserve{$room['room_id']}" id="RoomCount_Reserve{$room['room_id']}" value="{$number}">
                            <input type="hidden" name="Id_Select_Room{$keyRooms}{$i}" id="Id_Select_Room{$keyRooms}{$i}" value="{$room['room_id']}">

                            <div class="panel-default-change site-border-main-color">
                                <div class="panel-heading-change">

                                    <span class="hidden-xs-down">##Nation##:</span>

                                    <span class="kindOfPasenger">
                                    <label class="control--checkbox">
                                        <span>##Iranian##</span>
                                        <input type="radio" name="passengerNationalityA{$keyRooms}{$i}" id="passengerNationalityA{$keyRooms}{$i}"
                                               value="0" class="nationalityChange" checked="checked">
                                        <div class="checkbox ">
                                            <div class="filler"></div>
                                             <svg fill="#000000" viewBox="0 0 30 30">
                                        <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                                       </svg>
                                        </div>
                                    </label>
                                </span>
                                    <span class="kindOfPasenger">
                                    <label class="control--checkbox">
                                        <span>##Another##</span>
                                        <input type="radio" name="passengerNationalityA{$keyRooms}{$i}" id="passengerNationalityA{$keyRooms}{$i}"
                                               value="1" class="nationalityChange">
                                        <div class="checkbox ">
                                            <div class="filler"></div>
                                             <svg fill="#000000" viewBox="0 0 30 30">
                                        <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                                       </svg>
                                        </div>
                                    </label>
                                </span>


                                </div>

                                <div class="clear"></div>

                                <div class="panel-body-change">

                                    <div class="s-u-passenger-item s-u-passenger-item-change ">
                                        <select data-placeholder="##Sex##" id="genderA{$keyRooms}{$i}" name="genderA{$keyRooms}{$i}">
                                            <option value="" disabled="" selected="selected">##Sex##</option>
                                            <option value="Male">##Sir##</option>
                                            <option value="Female">##Lady##</option>
                                        </select>
                                    </div>

                                    <div class="{if $typeApplication eq 'externalApi'}s-u-passenger-item {/if}s-u-passenger-item-hotel s-u-passenger-item-change">
                                        <input id="nameEnA{$keyRooms}{$i}" type="text" placeholder="##Nameenglish##" name="nameEnA{$keyRooms}{$i}"
                                               oninput="return validateEnglishInput('nameEnA{$keyRooms}{$i}')" class="">
                                    </div>
                                    <div class="{if $typeApplication eq 'externalApi'}s-u-passenger-item {/if}s-u-passenger-item-hotel s-u-passenger-item-change">
                                        <input id="familyEnA{$keyRooms}{$i}" type="text" placeholder="##Familyenglish##"
                                               name="familyEnA{$keyRooms}{$i}"
                                               oninput="return validateEnglishInput('familyEnA{$keyRooms}{$i}')" class="">
                                    </div>
                                    <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                        <input id="birthdayEnA{$keyRooms}{$i}" type="text" placeholder="##miladihappybirthday##"
                                               name="birthdayEnA{$keyRooms}{$i}" class="gregorianAdultBirthdayCalendar"
                                               readonly="readonly">
                                    </div>
                                    {if $smarty.const.SOFTWARE_LANG eq 'fa' and $source_id neq '17'}
                                        <div class="s-u-passenger-item s-u-passenger-item-change">
                                            <input id="nameFaA{$keyRooms}{$i}" type="text" placeholder="##Namepersion##" name="nameFaA{$keyRooms}{$i}"
                                                   oninput="return validatePersianInput('nameFaA{$keyRooms}{$i}')"  class="justpersian">
                                        </div>
                                    {/if}
                                    {if $smarty.const.SOFTWARE_LANG eq 'fa' and $source_id neq '17'}
                                        <div class="s-u-passenger-item s-u-passenger-item-change">
                                            <input id="familyFaA{$keyRooms}{$i}" type="text" placeholder="##Familypersion##"
                                                   name="familyFaA{$keyRooms}{$i}"
                                                   oninput="return validatePersianInput('familyFaA{$keyRooms}{$i}')"
                                                   class="justpersian">
                                        </div>
                                    {/if}
                                    {if $IsInternal eq '1' and $source_id neq '17' }
                                        <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                            <input id="birthdayA{$keyRooms}{$i}" type="text" placeholder="##shamsihappybirthday##"
                                                   name="birthdayA{$keyRooms}{$i}" class="shamsiAdultBirthdayCalendar" readonly="readonly">
                                        </div>
                                    {elseif $smarty.const.SOFTWARE_LANG neq 'fa' and $source_id neq '17' }
                                        <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                            <input id="birthdayA{$keyRooms}{$i}" type="text" placeholder="##miladihappybirthday##"
                                                   name="birthdayA{$keyRooms}{$i}" class="gregorianAdultBirthdayCalendar" readonly="readonly">
                                        </div>
                                    {/if}
                                    {if $IsInternal eq '1'  and $source_id neq '17' }
                                        <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                            <input id="NationalCodeA{$keyRooms}{$i}" type="text" inputmode="number" placeholder="##Nationalnumber##"
                                                   name="NationalCodeA{$keyRooms}{$i}" maxlength="10" class="UniqNationalCode">
                                        </div>
                                    {/if}
                                    <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                        <select name="passportCountryA{$keyRooms}{$i}" id="passportCountryA{$keyRooms}{$i}" class="select2">
                                            <option value="">##Countryissuingpassport##</option>
                                            {foreach $objFunctions->CountryCodes() as $Country}
                                                <option value="{$Country.code}">{$Country[$objFunctions->changeFieldNameByLanguage('title')]}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                        <input id="passportNumberA{$keyRooms}{$i}" type="text" placeholder="##Numpassport##"
                                               name="passportNumberA{$keyRooms}{$i}" class="UniqPassportNumber">
                                    </div>

                                    {*  {if $room.source_id neq 13}
                                      <div class="s-u-passenger-item s-u-passenger-item-change">
                                          <div class="dropdownRoom">
                                              <div class="dropbtnSelectRoom" id="dropbtnSelectRoom{$keyRooms}{$i}">##Chooseflatlayout##</div>
                                              <div class="dropdown-content-room txt12" id="showDropdown{$keyRooms}{$i}">
                                                  <a onclick="SelectTypeRoom('Double','{$keyRooms}{$i}')"><i
                                                              class="ravis-icon-double-bed site-main-text-color"></i>
                                                      ##Twobeduser## </a>
                                                  <a onclick="SelectTypeRoom('Twin','{$keyRooms}{$i}')"><i
                                                              class="ravis-icon-hotel-single-bed site-main-text-color"></i><i
                                                              class="ravis-icon-hotel-single-bed site-main-text-color "></i>
                                                      ##Onebeduser## </a>
                                              </div>
                                          </div>
                                      </div>
                                      <input type="hidden" data-source_id="{$room.source_id}" id="BedType{$keyRooms}{$i}" name="BedType{$keyRooms}{$i}">
                                      {/if}*}

                                    {if $room['room_name']|strpos:"ساعته"}
                                        <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                            <select name="timeEnteringRoom{$keyRooms}{$i}" id="timeEnteringRoom{$keyRooms}{$i}" class="select2">
                                                <option value="">##selectTimeEnteringRoom##...</option>
                                                {for $s = 1 to 9}
                                                    <option value="{$s}">{$s}</option>
                                                {/for}
                                                {for $s = 10 to 24}
                                                    <option value="{$s}">{$s}</option>
                                                {/for}
                                            </select>
                                        </div>
                                    {/if}

                                    <div class="alert_msg" id="messageA{$keyRooms}{$i}"></div>
                                </div>
                            </div>

                            <div class="clear"></div>

                        </div>
                    {/for}
                {/if}
            {/foreach}
        {elseif  $temproryHotelLocal[0]['is_internal'] eq '0' || ($temproryHotelLocal[0]['is_internal'] eq '1' && $smarty.post.source_id eq '17')}
            {assign var="i" value=0}
            {assign var="rooms_count" value=0}
            <input type="hidden" name="ZoneFlight" id="ZoneFlight" value="external">

            {foreach $temproryHotelLocal as $keyRooms=>$room}

                {$keyRooms= $keyRooms+1}
                {$childCount = $room['ChildCount']}
                {$adultCount = $room['AdultsCount']}
                {assign var='room_name' value="{$room['room_name']}"}
                {if ($temproryHotelLocal|count) gt 1}
                    {$room_name="{$objFunctions->ConvertNthNumber($keyRooms)} {$room['room_name']}"}
                {/if}
                <input type="hidden" name="adultCount{$keyRooms}" id="adultCount{$keyRooms}" value="{$room['AdultsCount']}">
                {for $adultNumber = 1 to $room['AdultsCount']}
                    <input type="hidden" name="roomIndex{$keyRooms}" value="{$room['RoomIndex']}">

                    <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">
                    <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color direcR">

                       {$objFunctions->displayRoomName($room_name,$adultNumber,'Adt',true)}
                        {*{$room['room_name']} <span class="countRoom">(##Informationpassenger## {$keyRooms} - {$adultNumber})</span>*}
                       <!-- <i class="soap-icon-family"></i> -->
		           </span>

                        <input type="hidden" name="RoomCount_Reserve{$room['room_id']}" id="RoomCount_Reserve{$room['room_id']}"
                               value="1">
                        <input type="hidden" name="Id_Select_Room{$keyRooms}" id="Id_Select_Room{$keyRooms}" value="{$room['room_id']}">

                        <div class="panel-default-change site-border-main-color">
                            <div class="panel-heading-change">

                                <span class="hidden-xs-down">##Nation##:</span>

                                <span class="kindOfPasenger">
                                <label class="control--checkbox">
                                    <span>##Iranian##</span>
                                    <input type="radio" name="passengerNationalityA{$keyRooms}{$adultNumber}"
                                           id="passengerNationalityA{$keyRooms}{$adultNumber}"
                                           value="0" class="nationalityChange" checked="checked">
                                    <div class="checkbox">
                                        <div class="filler"></div>
                                         <svg fill="#000000" viewBox="0 0 30 30">
                                    <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                                   </svg>
                                    </div>
                                </label>
                            </span>
                                <span class="kindOfPasenger">
                                <label class="control--checkbox">
                                    <span>##Another##</span>
                                    <input type="radio" name="passengerNationalityA{$keyRooms}{$adultNumber}"
                                           id="passengerNationalityA{$keyRooms}{$adultNumber}"
                                           value="1" class="nationalityChange">
                                    <div class="checkbox">
                                        <div class="filler"></div>
                                         <svg fill="#000000" viewBox="0 0 30 30">
                                    <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                                   </svg>
                                    </div>
                                </label>
                            </span>

                                {if $objSession->IsLogin()}
                                    <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change site-bg-main-color"
                                          onclick="setHidenFildnumberRow('A{$keyRooms}{$adultNumber}')">
                                     <i class="zmdi zmdi-pin-account zmdi-hc-fw site-bg-main-color"></i> ##Passengerbook##
                                 </span>
                                {/if}
                            </div>

                            <div class="clear"></div>

                            <div class="panel-body-change">

                                <div class="s-u-passenger-item  s-u-passenger-item-change ">
                                    <select id="genderA{$keyRooms}{$adultNumber}" name="genderA{$keyRooms}{$adultNumber}" required aria-required="true">
                                        <option value="" disabled="" selected="selected">##Sex##</option>
                                        <option value="Male">##Sir##</option>
                                        <option value="Female">##Lady##</option>
                                    </select>
                                </div>

                                <div class="{if $typeApplication eq 'externalApi'}s-u-passenger-item {/if}s-u-passenger-item-hotel s-u-passenger-item-change">
                                    <input id="nameEnA{$keyRooms}{$adultNumber}" type="text" placeholder="##Nameenglish##"
                                           name="nameEnA{$keyRooms}{$adultNumber}"
                                           oninput="return validateEnglishInput('nameEnA{$keyRooms}{$adultNumber}')" class="">
                                </div>
                                <div class="{if $typeApplication eq 'externalApi'}s-u-passenger-item {/if}s-u-passenger-item-hotel s-u-passenger-item-change">
                                    <input id="familyEnA{$keyRooms}{$adultNumber}" type="text" placeholder="##Familyenglish##"
                                           name="familyEnA{$keyRooms}{$adultNumber}"
                                           oninput="return validateEnglishInput('familyEnA{$keyRooms}{$adultNumber}')" class="">
                                </div>
                                <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                    <input id="birthdayEnA{$keyRooms}{$adultNumber}" type="text" placeholder="##miladihappybirthday##"
                                           name="birthdayEnA{$keyRooms}{$adultNumber}" class="gregorianAdultBirthdayCalendar"
                                           readonly="readonly">
                                </div>
                                {if $smarty.const.SOFTWARE_LANG eq 'fa' and $source_id neq '17'  }
                                    <div class="s-u-passenger-item s-u-passenger-item-change">
                                        <input id="nameFaA{$keyRooms}{$adultNumber}" type="text" placeholder="##Namepersion##"
                                               name="nameFaA{$keyRooms}{$adultNumber}"
                                               oninput="return validatePersianInput('nameFaA{$keyRooms}{$adultNumber}')" class="justpersian">
                                    </div>
                                {/if}
                                {if $smarty.const.SOFTWARE_LANG eq 'fa' and $source_id neq '17' }
                                    <div class="s-u-passenger-item s-u-passenger-item-change">
                                        <input id="familyFaA{$keyRooms}{$adultNumber}" type="text" placeholder="##Familypersion##"
                                               name="familyFaA{$keyRooms}{$adultNumber}"
                                               oninput="return validatePersianInput('nameFaA{$keyRooms}{$adultNumber}')" class="justpersian">
                                    </div>
                                {/if}

                                {if $IsInternal eq '1'  }
                                    <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                        <input id="birthdayA{$keyRooms}{$adultNumber}" type="text" placeholder="##shamsihappybirthday##"
                                               name="birthdayA{$keyRooms}{$adultNumber}" class="shamsiAdultBirthdayCalendar" readonly="readonly">
                                    </div>
                                {else}
                                    <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                        <input id="birthdayA{$keyRooms}{$adultNumber}" type="text" placeholder="##shamsihappybirthday##"
                                               name="birthdayA{$keyRooms}{$adultNumber}" class="shamsiAdultBirthdayCalendar" readonly="readonly">
                                    </div>
                                {/if}
                                {if $IsInternal eq '1'  }
                                    <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                        <input id="NationalCodeA{$keyRooms}{$adultNumber}" type="text" placeholder="##Nationalnumber##"
                                               name="NationalCodeA{$keyRooms}{$adultNumber}" maxlength="10" class="UniqNationalCode">
                                    </div>
                                {/if}
                                <div class="s-u-passenger-item s-u-passenger-item-change noneIranian ">
                                    <select name="passportCountryA{$keyRooms}{$adultNumber}" id="passportCountryA{$keyRooms}{$adultNumber}"
                                            class="select2">
                                        <option value="">##Countryissuingpassport##</option>
                                        {foreach $objFunctions->CountryCodes() as $Country}
                                            <option value="{$Country['code']}">
                                                {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                                    {$Country['titleFa']}
                                                {else}
                                                    {$Country['titleEn']}
                                                {/if}
                                            </option>
                                        {/foreach}
                                    </select>
                                </div>
                                {if $IsInternal neq '1' || ($IsInternal eq '1' &&  $smarty.post.source_id eq '17') }
                                    <div class="s-u-passenger-item s-u-passenger-item-change {if $IsInternal eq '1'  &&  $smarty.post.source_id eq '17' }noneIranian{/if}">
                                        <input id="passportNumberA{$keyRooms}{$adultNumber}" type="text" placeholder="##Numpassport##"
                                               name="passportNumberA{$keyRooms}{$adultNumber}" class="UniqPassportNumber">
                                    </div>
                                {/if}
                                <input type="hidden" id="BedType{$keyRooms}{$adultNumber}" name="BedType{$keyRooms}{$adultNumber}" value="Twin">
                                <div class="alert_msg" id="messageA{$keyRooms}{$adultNumber}"></div>
                            </div>
                        </div>

                        <div class="clear"></div>

                    </div>
                {/for}

                {if $room['ChildCount'] gt 0}
                    <input type="hidden" name="childCount{$keyRooms}" id="childCount{$keyRooms}" value="{$room['ChildCount']}">
                    {for $childNumber = 1 to $room['ChildCount']}
                        <input type="hidden" name="roomIndex{$keyRooms}" value="{$room['RoomIndex']}">
                        <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">
		           <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color direcR">

                       {$objFunctions->displayRoomName($room_name,$adultNumber,'Chd',true)}
                       {*{$room['room_name']} <span class="countRoom">(##Informationpassenger## ##Child##{$keyRooms}-{$childNumber})</span>*}
                       <!-- <i class="soap-icon-family"></i> -->
		           </span>

                            <input type="hidden" name="RoomCount_Reserve{$room['room_id']}" id="RoomCount_Reserve{$room['room_id']}"
                                   value="1">
                            <input type="hidden" name="Id_Select_Room{$keyRooms}" id="Id_Select_Room{$keyRooms}" value="{$room['room_id']}">

                            <div class="panel-default-change site-border-main-color">
                                <div class="panel-heading-change">

                                    <span class="hidden-xs-down">##Nation##:</span>

                                    <span class="kindOfPasenger">
                                <label class="control--checkbox">
                                    <span>##Iranian##</span>
                                    <input type="radio" name="passengerNationalityC{$keyRooms}{$childNumber}"
                                           id="passengerNationalityC{$keyRooms}{$childNumber}"
                                           value="0" class="nationalityChange" checked="checked">
                                    <div class="checkbox">
                                        <div class="filler"></div>
                                        <svg fill="#000000" viewBox="0 0 30 30">
                                    <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                                   </svg>
                                    </div>
                                </label>
                            </span>
                                    <span class="kindOfPasenger">
                                <label class="control--checkbox">
                                    <span>##Another##</span>
                                    <input type="radio" name="passengerNationalityC{$keyRooms}{$childNumber}"
                                           id="passengerNationalityC{$keyRooms}{$childNumber}"
                                           value="1" class="nationalityChange">
                                    <div class="checkbox">
                                        <div class="filler"></div>
                                        <svg fill="#000000" viewBox="0 0 30 30">
                                    <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>
                                   </svg>
                                    </div>
                                </label>
                            </span>

                                    {if $objSession->IsLogin()}
                                        <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change site-bg-main-color"
                                              onclick="setHidenFildnumberRow('C{$keyRooms}{$childNumber}')">
                                     <i class="zmdi zmdi-pin-account zmdi-hc-fw site-bg-main-color"></i> ##Passengerbook##
                                 </span>
                                    {/if}
                                </div>

                                <div class="clear"></div>

                                <div class="panel-body-change">

                                    <div class="s-u-passenger-item  s-u-passenger-item-change ">
                                        <select id="genderC{$keyRooms}{$childNumber}" name="genderC{$keyRooms}{$childNumber}">
                                            <option value="" disabled="" selected="selected">##Sex##</option>
                                            <option value="Male">##Sir##</option>
                                            <option value="Female">##Lady##</option>
                                        </select>
                                    </div>

                                    <div class="{if $typeApplication eq 'externalApi'}s-u-passenger-item {/if}s-u-passenger-item-hotel s-u-passenger-item-change">
                                        <input id="nameEnC{$keyRooms}{$childNumber}" type="text" placeholder="##Nameenglish##"
                                               name="nameEnC{$keyRooms}{$childNumber}"
                                               oninput="return validateEnglishInput('nameEnC{$keyRooms}{$childNumber}')" class="">
                                    </div>
                                    <div class="{if $typeApplication eq 'externalApi'}s-u-passenger-item {/if}s-u-passenger-item-hotel s-u-passenger-item-change">
                                        <input id="familyEnC{$keyRooms}{$childNumber}" type="text" placeholder="##Familyenglish##"
                                               name="familyEnC{$keyRooms}{$childNumber}"
                                               oninput="return validateEnglishInput('familyEnC{$keyRooms}{$childNumber}')" class="">
                                    </div>
                                    <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                        <input id="birthdayEnC{$keyRooms}{$childNumber}" type="text" placeholder="##miladihappybirthday##"
                                               name="birthdayEnC{$keyRooms}{$childNumber}" class="gregorianChildBirthdayCalendar"
                                               readonly="readonly">
                                    </div>
                                    {if $smarty.const.SOFTWARE_LANG eq 'fa' and $source_id neq '17' }
                                        <div class="s-u-passenger-item s-u-passenger-item-change">
                                            <input id="nameFaC{$keyRooms}{$childNumber}" type="text" placeholder="##Namepersion##"
                                                   name="nameFaC{$keyRooms}{$childNumber}"
                                                   oninput="return validatePersianInput('nameFaC{$keyRooms}{$childNumber}')" class="justpersian">
                                        </div>
                                    {/if}
                                    {if $smarty.const.SOFTWARE_LANG eq 'fa' and $source_id neq '17' }
                                        <div class="s-u-passenger-item s-u-passenger-item-change">
                                            <input id="familyFaC{$keyRooms}{$childNumber}" type="text" placeholder="##Familypersion##"
                                                   name="familyFaC{$keyRooms}{$childNumber}"
                                                   oninput="return validatePersianInput('familyFaC{$keyRooms}{$childNumber}')"
                                                   class="justpersian">
                                        </div>
                                    {/if}
                                    <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                        <input id="birthdayC{$keyRooms}{$childNumber}" type="text" placeholder="##shamsihappybirthday##"
                                               name="birthdayC{$keyRooms}{$childNumber}" class="shamsiChildBirthdayCalendar" readonly="readonly">
                                    </div>
                                    {if $IsInternal eq '1' }
                                        <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                            <input id="NationalCodeC{$keyRooms}{$childNumber}" type="text" placeholder="##Nationalnumber##"
                                                   name="NationalCodeC{$keyRooms}{$childNumber}" maxlength="10" class="UniqNationalCode">
                                        </div>
                                    {/if}

                                    <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                        <select name="passportCountryC{$keyRooms}{$childNumber}" id="passportCountryC{$keyRooms}{$childNumber}"
                                                class="select2">
                                            <option value="">##Countryissuingpassport##</option>
                                            {foreach $objFunctions->CountryCodes() as $Country}
                                                <option value="{$Country['code']}">{$Country['titleFa']}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="s-u-passenger-item s-u-passenger-item-change {if $IsInternal eq '1'}noneIranian {/if}">
                                        <input id="passportNumberC{$keyRooms}{$childNumber}" type="text" placeholder="##Numpassport##"
                                               name="passportNumberC{$keyRooms}{$childNumber}" class="UniqPassportNumber">
                                    </div>
                                    {*                                <div class="s-u-passenger-item s-u-passenger-item-change {if $smarty.post.IsInternal eq '1'}noneIranian {/if}">*}
                                    {*                                    <input id="passportExpireC{$keyRooms}{$childNumber}" class="gregorianFromTodayCalendar" type="text"*}
                                    {*                                           placeholder="##Passportexpirydate##" name="passportExpireC{$keyRooms}{$childNumber}">*}
                                    {*                                </div>*}

                                    {if $room['room_name']|strpos:"ساعته"}
                                        <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                            <select name="timeEnteringRoom{$keyRooms}" id="timeEnteringRoom{$keyRooms}" class="select2">
                                                <option value="">##selectTimeEnteringRoom##...</option>
                                                {for $s = 1 to 9}
                                                    <option value="{$s}">{$s}</option>
                                                {/for}
                                                {for $s = 10 to 24}
                                                    <option value="{$s}">{$s}</option>
                                                {/for}
                                            </select>
                                        </div>
                                    {/if}

                                    <input type="hidden" id="BedType{$keyRooms}" name="BedType{$keyRooms}" value="Twin">

                                    <div class="alert_msg" id="messageC{$keyRooms}{$childNumber}"></div>
                                </div>
                            </div>

                            <div class="clear"></div>

                        </div>
                    {/for}
                {/if}
                {$rooms_count = ($rooms_count + 1)}
            {/foreach}
        {/if}

        <input type="hidden" name="rooms_count" value="{$rooms_count}">
        <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer first ">
          <span class="s-u-last-p-pasenger s-u-last-p-pasenger-change passenger_leader site-main-text-color">
             ##InformationSaler##
          </span>
            <div class="clear"></div>
            <div class="panel-default-change-Buyer">

                <div class="s-u-passenger-items s-u-passenger-item-change">
                    <input id="passenger_leader_room_fullName" type="text" placeholder="##Namefamily##"
                            {if (is_array($InfoMember) && ($InfoMember.name neq '' || $InfoMember.family neq ''))} value="{$InfoMember.name} {$InfoMember.family}" {/if}
                           name="passenger_leader_room_fullName" class="dir-ltr">
                </div>

                <div class="s-u-passenger-items s-u-passenger-item-change">
                    <input id="passenger_leader_room" type="text" placeholder="##Phonenumber##" name="passenger_leader_room"
                            {if (is_array($InfoMember) && $InfoMember.name neq '' )} value="{$InfoMember.mobile}" {/if}
                           class="dir-ltr">
                </div>

                {if $objFunctions->checkClientConfigurationAccess("more_information_passenger_hotel")}
                    <input type="hidden" id="require_extra_fields" value="true">
                    <div class="s-u-passenger-items s-u-passenger-item-change">
                        <input id="passenger_leader_room_email" type="text" placeholder="##Email##" name="passenger_leader_room_email" class="dir-ltr">
                    </div>

                    <div class="s-u-passenger-items s-u-passenger-item-change">
                        <input id="passenger_leader_room_postalcode" type="text" placeholder="##Postalcode##" name="passenger_leader_room_postalcode" class="dir-ltr">
                    </div>
                    <div class="s-u-passenger-items s-u-passenger-item-change s-u-passenger-item-change full-width">
                        <input id="passenger_leader_room_address" type="text" placeholder="##Address##" name="passenger_leader_room_address" class="dir-ltr">
                    </div>
                {else}
                    <input type="hidden" id="require_extra_fields" value="false">
                {/if}

                <div class="alert_msg" id="messagePassengerLeader"></div>
            </div>
            <div class="clear"></div>
        </div>

        

        <input type="hidden" id="TotalNumberRoom_Reserve" name="TotalNumberRoom_Reserve" value="{$TotalNumberRoom}">
        <input type="hidden" id="TotalPrice_Reserve" name="TotalPrice_Reserve" value="{$TotalPrice}">
        <input type="hidden" id="idCity_Reserve" name="idCity_Reserve" value="{$smarty.post.IdCity_Reserve}">
        <input type="hidden" id="Hotel_Reserve" name="Hotel_Reserve" value="{$smarty.post.idHotel_reserve}">
        <input type="hidden" id="RoomTypeCodes_Reserve" name="RoomTypeCodes_Reserve" value="{$roomTypeCodes}">
        <input type="hidden" id="NumberOfRooms_Reserve" name="NumberOfRooms_Reserve" value="{$numberOfRooms}">
        <input type="hidden" id="StartDate_Reserve" name="StartDate_Reserve" value="{$smarty.post.startDate_reserve}">
        <input type="hidden" id="EndDate_Reserve" name="EndDate_Reserve" value="{$smarty.post.endDate_reserve}">
        <input type="hidden" id="Nights_Reserve" name="Nights_Reserve" value="{$smarty.post.nights_reserve}">
        <input type="hidden" id="time_remmaining" value="" name="time_remmaining">
        <input type="hidden" id="factorNumber" name="factorNumber" value="{$smarty.post.factorNumber}">
        <input type="hidden" id="typeApplication" name="typeApplication" value="{$typeApplication}">
        <input type="hidden" id="source_id" name="source_id" value="{$smarty.post.source_id}">
        <input type="hidden" id="is_internal" name="is_internal" value="{$IsInternal}">
        <input type="hidden" id="CurrencyCode" name="CurrencyCode" value="{$smarty.post.CurrencyCode}">
        <input type="hidden" value="" name="idMember" id="idMember">

        <div class="btns_factors_n">
            <div class="next_hotel__">
                <a href="" onclick="return false" class="f-loader-check loaderpassengers" id="loader_check" style="display:none"></a>
                <button type="button" onclick="checkHotelNew('{$smarty.now}','{$adultCount}','{$childCount}','{$requestNumber}')"
                        class="s-u-submit-passenger s-u-select-flight-change s-u-submit-passenger-Buyer site-bg-main-color"
                        id="send_data">
                    ##NextStepInvoice##&nbsp;
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            </div>
        </div>

    </form>

{else}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`passengerHotel/flightio.tpl"}
{/if}


{include file="`$smarty.const.FRONT_CURRENT_CLIENT`hotelTimeoutModal.tpl"}
{literal}

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
          $(this).find(".closeBtn").click(function () {
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

       });


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
{/literal}