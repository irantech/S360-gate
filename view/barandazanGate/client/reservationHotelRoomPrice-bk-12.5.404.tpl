
{$CurrencyEquivalent = ''}



<input id="typeApplication" name="typeApplication" type="hidden" value="{$typeApplication}">
<input name="idHotel_reserve" id="idHotel_reserve" value="{$idHotel}" type="hidden">
<input name="startDate_reserve" id="startDate_reserve" value="{$startDate}" type="hidden">
<input name="endDate_reserve" id="endDate_reserve" value="{$endDate}" type="hidden">
<input name="nights_reserve" id="nights_reserve" value="{$number_night}" type="hidden">
<input name="IdCity_Reserve" id="IdCity_Reserve" value="{$idCity}" type="hidden">

{*<div class="box-reserve-hotel-fix ">
    <div class="box-reserve-hotel-fix-items">
        <span><b class="roomFinalTxt">0 ##Selectedroom## </b> ##For## {$number_night} ##Timenight##</span>
        <span class="roomFinalPrice site-main-text-color">0 ##Rial##</span>
        <span class="roomFinalBtn multi-rooms-price-btn-container">
            <button id="btnReserve" type="button" disabled="disabled"
                    class="site-secondary-text-color site-bg-main-color site-main-button-color-hover"
                    onclick="ReserveHotel()">##Reservation##
            </button>
            <img class="imgLoad" src="assets/images/load2.gif" id="img"/>
        </span>

    </div>
</div>*}
{*{$objResult->SearchHotel|var_dump}*}
{*{$objResult->RoomPrices|json_encode}*}
{*{$objResult->SearchHotel.prepayment_percentage}*}

{assign var="AllTypeRoomHotel" value=""}
{assign var="TotalNumberRoom" value=""}
{foreach $objResult->reservationHotelRoom as $room}
{if ($objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['TotalCapacity'] > 0  && $smarty.const.CLIENT_ID == '327') || $smarty.const.CLIENT_ID != '327'}
{$objResult->explodeRoom($room.room_name)}
{$AllTypeRoomHotel = "`$AllTypeRoomHotel``$room.id_room`/"}
{$TotalNumberRoom = $TotalNumberRoom + 1}


    <div class="hotel-detail-room-list special_list_room">
        <div class="hotel-rooms-name-container">
            <input type="hidden" name="statusDiscount" id="statusDiscount" value="{$objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['statusDiscount']}">

            <span class="hotel-rooms-name">
                <i class="fa fa-bed-empty"></i>
                                {$objResult->typeRoom}
                {if $objResult->typeTitle neq ''}
                    {$objResult->typeTitle}
                {/if}
                {if $objResult->typeQuality neq ''}
                    {$objResult->typeQuality}
                {/if}
                            </span>

            {if $objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['RemainingCapacity'] gt 0}
                <span class="online-badge"><span class="online-txt">
                        <i class="fa fa-bolt text-dark"></i>##Onlinereservation##</span></span>
            {elseif $room['show_request'] == 'yes'}
                <span class="online-badge"><span class="online-txt">
                        <i class="fa fa-bell-concierge text-dark"></i>##RequestedHotel##</span></span>
            {/if}
            {if $objResult->RoomPrices[$room.id_room]['CHD'][$startDate]['toAge'] neq 0}
                <span class="online-badge mr-1"><span class="online-txt">
                        <i class="fa fa-child"></i>{$objFunctions->StrReplaceInXml(['@@age@@'=>$objResult->RoomPrices[$room.id_room]['CHD'][$startDate]['toAge']],'FreeHotelChild')}</span></span>
            {/if}
            {if $objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['Discount'] neq 0}
                <span class="hotel-room-number-label site-bg-main-color site-bg-color-border-bottom">{$objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['Discount']} % ##Discount##</span>
            {/if}

        </div>
        <div class="hotel-rooms-item">
            <div class="hotel-rooms-row">
                <div class="hotel-rooms-local-content-col">

                        <div class="divided-list">
                            <div class="divided-list-item ">
                                <span class="number_person">
                                    <i class="fa fa-user"></i>
                                    {$room.room_capacity} ##People##
                                </span>
                            </div>
<!--                            <div class="divided-list-item">
                                {if $objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['Breakfast'] eq 'yes'
                                    || $objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['Lunch'] eq 'yes'
                                    || $objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['Dinner'] eq 'yes'}
                                    <span><i class="fa fa-bed"></i>
                                        {if $objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['Breakfast'] eq 'yes'}
                                            ##Breakfast##
                                        {/if}
                                        {if $objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['Lunch'] eq 'yes'}
                                            ##Lunch##
                                        {/if}
                                        {if $objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['Dinner'] eq 'yes'}
                                            ##Dinner##
                                        {/if}
                                    </span>
                                {else}
                                    <span><i class="fa fa-bed"></i>##Onlyroom##</span>
                                {/if}
                            </div>-->

                            <div class="DetailRoom showCancelRule" id="btnCancelRule-{$room.id_room}" data-roomindex="{$room.id_room}" onclick="moreHotelReservationTab(event.currentTarget)">
                                <span>  ##Pricedetails##  </span>
                                <i class="fa fa-angle-down"></i>
                            </div>

                        </div>

                        <div class="divided-list divided-list2">
                            <div class="divided-list-item">
                                <input type="hidden" name="priceRoom{$room.id_room}" id="priceRoom{$room.id_room}" value="">
                                <input type="hidden" id="FinalRoomCount_Reserve{$room.id_room}" value="" data-amount="">
                                <input type="hidden" id="FinalPriceRoom_Reserve{$room.id_room}" value="" data-amount="">
                                <span class="title_price">##Priceforanynight##</span>
                                {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['PriceOnlineForView'], $CurrencyCode, $CurrencyEquivalent)}
                                {assign var="currencyPrice" value=$objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['PriceCurrencyForView']}
                                {assign var="currencyType" value=$objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['CurrencyTypeForView']}
                                {assign var="currencyTitle" value=''}
                                {assign var="currency_price" value=['AmountCurrency'=>0,'TypeCurrency'=>'']}
                                {if $currencyType eq '1'}
                                    {$currencyTitle = $objFunctions->Xmlinformation('Dollar')}
                                {elseif $currencyType eq '2'}
                                    {$currencyTitle = $objFunctions->Xmlinformation('Derham')}
                                {elseif $currencyType eq '3'}
                                    {$currencyTitle = $objFunctions->Xmlinformation('Euro')}
                                {/if}
                                {if $currencyPrice gt 0 AND $currencyType gt 0}
                                    {$currency_price = ['AmountCurrency'=>$currencyPrice,'TypeCurrency'=>$currencyTitle]}
                                {/if}
                                {if $objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['Discount'] neq 0}

                                    {assign var="disabledCurrency" value=$objFunctions->CurrencyCalculate($objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['PriceBoardForView'], $CurrencyCode, $CurrencyEquivalent)}
                                    <strike class="currency priceOff">{$objFunctions->numberFormat($disabledCurrency.AmountCurrency)}</strike>
                                {/if}

                                <span class="price_number">
{*                                   {if $currency_price.AmountCurrency gt 0}*}
{*                                    <i>{$objFunctions->numberFormat($currency_price.AmountCurrency)}</i>*}
{*                                        {$currency_price.TypeCurrency}*}
{*                                        {$objFunctions->Xmlinformation('EqualTo')}*}
{*                                    {/if}*}
                                    <i class="site-main-text-color">{$objFunctions->numberFormat($mainCurrency.AmountCurrency)}</i>
                                </span>
                                    {$mainCurrency.TypeCurrency}
                                </span>
                            </div>
                        </div>
                </div>
                <div class="hotel-rooms-price-col">
                    <div class="selsect-room-reserve s-u-bank-title">{if $smarty.const.SOFTWARE_LANG neq 'en' } ##Countroom##{/if}</div>



                    <div class="number_room number_room-reservation">
                        <i class="plus_room" data-type_application="reservation" data-room_token="{$room.id_room}"> + </i>
                        <input  min="1" max="9" type="number"
                                class="val_number_room" value="0"
                                id="RoomCount{$room.id_room}"
                                name="RoomCount{$room.id_room}"
                                onchange="checkForReserve({$room.id_room})"/>
                        <i class=" minus_room " data-type_application="reservation" data-room_token="{$room.id_room}" > - </i>
                    </div>

                    <div class="select nuumbrtRoom extraBed">
                        <input type="hidden" value="{$room.maximum_extra_beds}" id="maximum_extra_beds{$room.id_room}" name="maximum_extra_beds{$room.id_room}">
                        <input type="hidden" value="{$room.maximum_extra_chd_beds}" id="maximum_extra_chd_beds{$room.id_room}" name="maximum_extra_chd_beds{$room.id_room}">
                        <input type="hidden" value="{{$objResult->RoomPrices[$room.id_room]['ECHD'][$startDate]['fromAge']}}" id="extra_child_from_age{$room.id_room}" name="extra_child_from_age{$room.id_room}">
                        <input type="hidden" value="{{$objResult->RoomPrices[$room.id_room]['ECHD'][$startDate]['toAge']}}" id="extra_child_to_age{$room.id_room}" name="extra_child_to_age{$room.id_room}">
                        <input type="hidden" value="" id="ExtraBed{$room.id_room}" name="ExtraBed{$room.id_room}">
                        <input type="hidden" value="" id="ExtraChildBed{$room.id_room}" name="ExtraChildBed{$room.id_room}">
                        <select name="ExtraBedRoom{$room.id_room}" id="ExtraBedRoom{$room.id_room}"
                                onchange="calculateExtraBedCount({$room.id_room})">
                            <option selected="">##Extrabed##</option>
                        </select>
                    </div>




                </div>
            </div>

        </div>
        <div class="hotel-rooms-footer">
            <div class="divided-list-item divided-detail d-flex flex-column">
                <div class="hotel-rooms-rule-row">
                    <div class="col-xs-12 col-md-12 box-cancel-rule">
                        <img class="imgLoad" src="assets/images/load.gif"
                             id="loaderCancel-{$room.id_room}">
                        <div class="box-cancel-rule-col displayN" id="boxCancelRule-{$room.id_room}">
                            <div>
                                <ul class="nav nav-pills" id="pills-tab-{$room.id_room}" role="tablist">
                                    {if $objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['PriceOnlineForView'] gt 0}
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="price-hotel-details-{$room.id_room}-tab" data-toggle="pill" data-target="#price-hotel-details-{$room.id_room}" type="button" role="tab" aria-controls="price-hotel-details-{$room.id_room}" aria-selected="true">##priceHotelDetail##</button>
                                        </li>
                                    {/if}
                                    {if $objResult->infoRoomGallery[$room.id_room] eq 'true'}
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id=room-pictures-{$room.id_room}-tab" data-toggle="pill" data-target="#room-pictures-{$room.id_room}" type="button" role="tab" aria-controls="room-pictures-{$room.id_room}" aria-selected="true">##Roompictures##</button>
                                        </li>
                                    {/if}
                                    {if $objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['SpecificDescription'] neq ''}
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="specific-description-{$room.id_room}-tab" data-toggle="pill" data-target="#specific-description-{$room.id_room}" type="button" role="tab" aria-controls="specific-description-{$room.id_room}" aria-selected="false">##Specificdescription##</button>
                                        </li>
                                    {/if}
                                    {if $objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['OtherServices'] neq ''}
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="other-service-{$room.id_room}-tab" data-toggle="pill" data-target="#other-service-{$room.id_room}" type="button" role="tab" aria-controls="other-service-{$room.id_room}" aria-selected="false">##Patrolotherservices##</button>
                                        </li>
                                    {/if}
                                    {if $objResult->infoRoomFacilities[$room.id_room] eq 'true'}
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="info-room-facility-{$room.id_room}-tab" data-toggle="pill" data-target="#info-room-facility-{$room.id_room}" type="button" role="tab" aria-controls="info-room-facility-{$room.id_room}" aria-selected="false">##Service##  ##Room##</button>
                                        </li>
                                    {/if}
                                </ul>
                                <div class="tab-content" id="pills-tabContent-{$room.id_room}">
                                    {if $objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['PriceOnlineForView'] gt 0}
                                        <div class="tab-pane fade show active" id="price-hotel-details-{$room.id_room}" role="tabpanel" aria-labelledby="price-hotel-details-{$room.id_room}-tab">
                                            {assign var="fkDBL" value=''}
                                            {assign var="fkEXT" value=''}
                                            {assign var="fkECHD" value=''}
                                            {assign var="CostRoom" value=0}
                                            {assign var="CostBedEXT" value=0}
                                            {assign var="CostBedCHD" value=0}
                                            {assign var="ageFrom" value=0}
                                            {assign var="ageTo" value=0}

                                             <div class='price-hotel-details-grid'>
                                                 {foreach $objResult->RoomPrices[$room.id_room]['DBL'] as $roomPrice}

                                                     {$fkDBL = "`$fkDBL``$roomPrice.id`/"}
                                                     {$fkEXT = "`$fkEXT``$objResult->RoomPrices[$room.id_room]['EXT'][$roomPrice.Date]['id']`/"}
                                                     {$fkECHD = "`$fkECHD``$objResult->RoomPrices[$room.id_room]['ECHD'][$roomPrice.Date]['id']`/"}
                                                     {$CostRoom = $CostRoom + $roomPrice.PriceOnline}
                                                     {$CostBedEXT = $CostBedEXT + $objResult->RoomPrices[$room.id_room]['EXT'][$roomPrice.Date]['PriceOnline']}
                                                     {$CostBedCHD = $CostBedCHD + $objResult->RoomPrices[$room.id_room]['ECHD'][$roomPrice.Date]['PriceOnline']}
                                                     {$ageFrom = $objResult->RoomPrices[$room.id_room]['ECHD'][$roomPrice.Date]['fromAge']}
                                                     {$ageTo = $objResult->RoomPrices[$room.id_room]['ECHD'][$roomPrice.Date]['toAge']}

                                                     {if $roomPrice.RemainingCapacity neq 0}
                                                        <div>
                                                            <span>{$roomPrice.Date}</span>

                                                            {assign var="everyPriceCurrency" value=$objFunctions->CurrencyCalculate($roomPrice.PriceOnline, $CurrencyCode, $CurrencyEquivalent)}
                                                            {assign var="childCurrency" value=$objFunctions->CurrencyCalculate($objResult->RoomPrices[$room.id_room]['ECHD'][$roomPrice.Date]['PriceOnline'], $CurrencyCode, $CurrencyEquivalent)}
                                                            {assign var="extraBedCurrency" value=$objFunctions->CurrencyCalculate($objResult->RoomPrices[$room.id_room]['EXT'][$roomPrice.Date]['PriceOnline'], $CurrencyCode, $CurrencyEquivalent)}

                                                            {assign var=currency_price value=['AmountCurrency'=>0,'TypeCurrency'=>'']}
                                                            {if $roomPrice.PriceCurrencyForView gt 0}
                                                                {assign var="currencyTitle" value=''}
                                                                {if $roomPrice.CurrencyTypeForView eq '1'}
                                                                    {$currencyTitle = $objFunctions->Xmlinformation('Dollar')}
                                                                {elseif $roomPrice.CurrencyTypeForView eq '2'}
                                                                    {$currencyTitle = $objFunctions->Xmlinformation('Derham')}
                                                                {elseif $roomPrice.CurrencyTypeForView eq '3'}
                                                                    {$currencyTitle = $objFunctions->Xmlinformation('Euro')}
                                                                {/if}
                                                                {$currency_price = ['AmountCurrency'=>$roomPrice.PriceCurrencyForView,'TypeCurrency'=>$currencyTitle]}
                                                            {/if}
                                                            <div>
                                                                {if $currency_price.AmountCurrency gt 0}
                                                                    {$currency_price.TypeCurrency}
                                                                {/if}
                                                                <h2>

                                                                    ##roomPrice##:
                                                                    {$objFunctions->numberFormat($everyPriceCurrency.AmountCurrency)}
                                                                    {$everyPriceCurrency.TypeCurrency}
                                                                </h2>
                                                                <h2>
                                                                    {if $ageFrom neq 0 || $ageTo neq 0}
                                                                        {$objFunctions->StrReplaceInXml(['@@from@@'=>$ageFrom , '@@to@@'=>$ageTo],'HotelExtraChildBed')}:
                                                                    {else}
                                                                        ##HotelExtraChild##:
                                                                    {/if}

                                                                    {$objFunctions->numberFormat($childCurrency.AmountCurrency)}
                                                                    {$childCurrency.TypeCurrency}
                                                                </h2>
                                                                <h2>
                                                                    ##HotelExtraBed##:
                                                                    {$objFunctions->numberFormat($extraBedCurrency.AmountCurrency)}
                                                                    {$childCurrency.TypeCurrency}
                                                                </h2>
                                                            </div>
                                                        </div>
                                                     {else}

                                                         <div>
                                                             <span>{$roomPrice.Date}</span>
                                                             {assign var="everyPriceCurrency" value=$objFunctions->CurrencyCalculate($roomPrice.PriceOnline, $CurrencyCode, $CurrencyEquivalent)}
                                                             {assign var="childCurrency" value=$objFunctions->CurrencyCalculate($objResult->RoomPrices[$room.id_room]['ECHD'][$roomPrice.Date]['PriceOnline'], $CurrencyCode, $CurrencyEquivalent)}
                                                             {assign var="extraBedCurrency" value=$objFunctions->CurrencyCalculate($objResult->RoomPrices[$room.id_room]['EXT'][$roomPrice.Date]['PriceOnline'], $CurrencyCode, $CurrencyEquivalent)}

                                                             {assign var="currency_price" value=['AmountCurrency'=>0,'TypeCurrency'=>'']}
                                                             {if $roomPrice.PriceCurrencyForView gt 0}
                                                                 {assign var="currencyTitle" value=''}
                                                                 {if $roomPrice.CurrencyTypeForView eq '1'}
                                                                     {$currencyTitle = $objFunctions->Xmlinformation('Dollar')}
                                                                 {elseif $roomPrice.CurrencyTypeForView eq '2'}
                                                                     {$currencyTitle = $objFunctions->Xmlinformation('Derham')}
                                                                 {elseif $roomPrice.CurrencyTypeForView eq '3'}
                                                                     {$currencyTitle = $objFunctions->Xmlinformation('Euro')}
                                                                 {/if}
                                                                 {$currency_price = ['AmountCurrency'=>$roomPrice.PriceCurrencyForView,'TypeCurrency'=>$currencyTitle]}
                                                             {/if}
                                                             <div>
                                                                 {if $currency_price.AmountCurrency gt 0}
                                                                     <b>{$objFunctions->numberFormat($currency_price.AmountCurrency)}</b> {$currency_price.TypeCurrency}
                                                                     {$objFunctions->Xmlinformation('EqualTo')}
                                                                 {/if}
                                                                 <h2>
                                                                     ##roomPrice##:
                                                                     {$objFunctions->numberFormat($everyPriceCurrency.AmountCurrency)}
                                                                     {$everyPriceCurrency.TypeCurrency}
                                                                 </h2>
                                                                 <h2>
                                                                     {if $ageFrom neq 0 || $ageTo neq 0}
                                                                         {$objFunctions->StrReplaceInXml(['@@from@@'=>$ageFrom , '@@to@@'=>$ageTo],'HotelExtraChildBed')}:
                                                                     {else}
                                                                         ##HotelExtraChild##:
                                                                     {/if}
                                                                     {$objFunctions->numberFormat($childCurrency.AmountCurrency)}
                                                                     {$childCurrency.TypeCurrency}
                                                                 </h2>
                                                                 <h2>
                                                                     ##HotelExtraBed##:
                                                                     {$objFunctions->numberFormat($extraBedCurrency.AmountCurrency)}
                                                                     {$childCurrency.TypeCurrency}
                                                                 </h2>
                                                             </div>
                                                         </div>
                                                     {/if}
                                                 {/foreach}
                                            </div>

                                            {assign var="bedEXTCurrency" value=$objFunctions->CurrencyCalculate($CostBedEXT, $CurrencyCode, $CurrencyEquivalent)}
                                            {assign var="bedCHDCurrency" value=$objFunctions->CurrencyCalculate($CostBedCHD, $CurrencyCode, $CurrencyEquivalent)}
                                            {assign var="roomCurrency" value=$objFunctions->CurrencyCalculate($CostRoom, $CurrencyCode, $CurrencyEquivalent)}

                                            <input type="hidden" name="CostkolHotelRoom_EXT{$room.id_room}" id="CostkolHotelRoom_EXT{$room.id_room}" value="{$CostBedEXT}" data-amount="{$bedEXTCurrency.AmountCurrency}" data-unit="{$bedEXTCurrency.TypeCurrency}">
                                            <input type="hidden" name="CostkolHotelRoom_CHD{$room.id_room}" id="CostkolHotelRoom_CHD{$room.id_room}" value="{$CostBedCHD}" data-amount="{$bedCHDCurrency.AmountCurrency}" data-unit="{$bedCHDCurrency.TypeCurrency}">
                                            <input type="hidden" name="CostkolHotelRoom_DBL{$room.id_room}" id="CostkolHotelRoom_DBL{$room.id_room}" value="{$CostRoom}" data-amount="{$roomCurrency.AmountCurrency}" data-unit="{$roomCurrency.TypeCurrency}">
                                            <input name="fkDBL{$room.id_room}" id="fkDBL{$room.id_room}" value="{$fkDBL}" type="hidden">
                                            <input name="fkEXT{$room.id_room}" id="fkEXT{$room.id_room}" value="{$fkEXT}" type="hidden">
                                            <input name="fkECHD{$room.id_room}" id="fkECHD{$room.id_room}" value="{$fkECHD}" type="hidden">
                                            <input type="hidden" name="prepaymentPercentage" id="prepaymentPercentage" value="{$objResult->SearchHotel.prepayment_percentage}"  data-amount="{$objResult->SearchHotel.prepayment_percentage}" data-unit="##PrePrice##">

                                        </div>
                                    {/if}
                                    {if $objResult->infoRoomGallery[$room.id_room] eq 'true'}
                                        <div class="tab-pane fade" id="room-pictures-{$room.id_room}" role="tabpanel" aria-labelledby="room-pictures-{$room.id_room}-tab">
                                            <div class="room-image-item">
                                                {foreach $objResult->roomGallery[$room.id_room] as $gallery}
                                                    {if $gallery.pic_format eq 'webm'}
                                                        <a data-fancybox="images{$room.id_room}" href="{$gallery['pic_url']}" class="room-image-box" data-webm="{$gallery['pic_url']}">
                                                            <img class="room-image" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/videoPlayer.jpg" alt="{$gallery['pic_name']}">
                                                        </a>
                                                    {else}
                                                        <a data-fancybox="images{$room.id_room}" href="{$gallery['pic_url']}" class="room-image-box">
                                                            <img class="room-image" src="{$gallery['pic_url']}" alt="{$gallery['pic_name']}">
                                                        </a>
                                                    {/if}
                                                {/foreach}
                                            </div>
                                        </div>
                                    {/if}
                                    {if $objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['SpecificDescription'] neq ''}
                                        <div class="tab-pane fade" id="specific-description-{$room.id_room}" role="tabpanel" aria-labelledby="specific-description-{$room.id_room}-tab">
                                            <p>{$objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['SpecificDescription']} </p>
                                        </div>
                                    {/if}
                                    {if $objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['OtherServices'] neq ''}
                                        <div class="tab-pane fade" id="other-service-{$room.id_room}" role="tabpanel" aria-labelledby="other-service-{$room.id_room}-tab">
                                            <p>{$objResult->RoomPrices[$room.id_room]['DBL'][$startDate]['OtherServices']} </p>
                                        </div>
                                    {/if}
                                    {if $objResult->infoRoomFacilities[$room.id_room] eq 'true'}
                                        <div class="tab-pane fade" id="info-room-facility-{$room.id_room}" role="tabpanel" aria-labelledby="info-room-facility-{$room.id_room}-tab">
                                            {foreach $objResult->roomFacilities[$room.id_room] as $facilities}
                                                <p class="servicesHotel"><i class="{$facilities['icon_class']}"></i> {$facilities['title']} </p>
                                            {/foreach}
                                        </div>
                                    {/if}
                                </div>
                            </div>
{*                            <span class="close-hotel-reservation-tab" onclick="closeHotelReservationTab()">*}
{*                                <i class="fa fa-angle-up"></i>*}
{*                            </span>*}
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    {/if}
{/foreach}

<input name="TypeRoomHotel" id="TypeRoomHotel" value="{$AllTypeRoomHotel}" type="hidden">
<input name="TotalNumberRoom" id="TotalNumberRoom" value="{$TotalNumberRoom}" type="hidden">






