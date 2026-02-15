<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css" />

{load_presentation_object filename="resultHotelLocal" assign="objResult"}
{load_presentation_object filename="passengersDetailLocal" assign="objDetail"}

{$objResult->getReservationHotel($smarty.post.idHotel_reserve)}
{$objResult->getPassengersDetailHotelForReservation($smarty.post)}	{**گرفتن اطلاعات مربوط به هتل **}


{$objDetail->getCustomers()}   {*گرفتن اطلاعات مربوط به مسافران هر مشتری*}

<span id="SOFTWARE_LANG_SPAN" data-lang="{$smarty.const.SOFTWARE_LANG}" class="d-none"></span>

{if $smarty.const.SOFTWARE_LANG === 'en'}
    {assign var="countryTitleName" value="titleEn"}
{else}
    {assign var="countryTitleName" value="titleFa"}
{/if}

{if isset($smarty.post.factor_number)}
    {assign var="FactorNumber" value=$smarty.post.factor_number}
{else}
    {assign var="FactorNumber" value=$objResult->getFactorNumber()}
{/if}




   <form  method="post" id="requestForm" action="{$smarty.const.ROOT_ADDRESS}/factorRequest">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 s-u-passenger-wrapper-change">
            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">##Youbookingfollowinghotel##</span>

            <div class="hotel-booking-room marb0">

                <div class="col-md-3 nopad">
                    <div class="hotel-booking-room-image">
                        <a>
                            <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$objResult->infoReservationHotel['logo']}" alt="{$objResult->infoReservationHotel['name']}">
                        </a>
                    </div>
                </div>

                <div class="col-md-9 pl-0 ">
                    <div class="hotel-booking-room-content">
                        <div class="hotel-booking-room-text">
                            <b class="hotel-booking-room-name"> {$objResult->infoReservationHotel['name']} </b>

                            <span class="hotel-star">
                           {for $s=1 to $objResult->infoReservationHotel['star_code']}
                               <i class="fa fa-star" aria-hidden="true"></i>
                           {/for}
                                {for $ss=$s to 5}
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                {/for}
                        </span>

                            <span class="hotel-booking-room-content-location ">
                             {$objResult->infoReservationHotel['address']}
                        </span>
<!--
                            <p class="hotel-booking-roomm-description hotel-result-item-rule">
                                <span class="fa fa-bell-o"></span>
                                {$objResult->infoReservationHotel['rules']}
                            </p>

                            <span class="maxlist-more nzr-show-up "> <a> ##Open## </a></span>
                            <span class="maxlist-more  nzr-show-down" style="display: none;"><a> ##Close## </a></span>

-->


                        </div>

                        <div class="hotel-booking-room-text">
                            <ul>
                                <li class="hotel-check-text"><i class="fa fa-calendar-times-o"></i> ##Enterdate## :
                                    <span  class="hotel-check-date" dir="rtl">{$smarty.post.startDate_reserve}</span></li>
                                <li class="hotel-check-text"><i class="fa fa-calendar-check-o"></i> ##Exitdate## :
                                    <span class="hotel-check-date" dir="rtl">{$smarty.post.endDate_reserve}</span></li>
                                <li class="hotel-check-text"><i class="fa fa-bed"></i> {$smarty.post.nights_reserve} ##Night##</li>
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
                                    <div  class="th_hotel hidden-xs">##Service##</div>
                                    <div  class="th_hotel">##Price##</div>
                                </div>
                            </div>
                            <div class="tbody_hotel">
                                {assign var="TotalPrice" value=0}
                                {foreach  $objResult->temproryHotelRoom  as $i=>$Hotel}
                                {$TotalPrice = $TotalPrice + $Hotel['TotalPriceRoom']}
                                    {$RoomPrice1night}
                                <div class="tr_hotel hotel_room_row">
                                    <div class="th_hotel">
                                        {assign var="everyNightCurrency" value=$objFunctions->CurrencyCalculate($Hotel['RoomPrice1night'], $smarty.post.CurrencyCode)}
                                        {if $everyNightCurrency gt 0 AND $smarty.post.nights_reserve gt 0}
                                        <div class="box_pricees">
                                            <div class="detail_room_hotel detail_room_hotel_new">
                                                {for $night_number =0; $night_number < $smarty.post.nights_reserve; $night_number++}
                                                    {assign var='night_date' value=$objFunctions->DateAddDay($smarty.post.startDate_reserve,$night_number)}
                                                    <div class="details">
                                                        <div class="AvailableSeprate site-bg-main-color site-bg-color-border-right-b ">{$night_date}</div>
                                                        <div class="seprate">
                                                                        <span><b>{$Hotel['RoomPrice1night']|number_format}</b>##Rial## <i class="fa fa-male checkIcon"></i>
                                                                            <span class="tooltip-price">##Adult##</span>
                                                                        </span>
                                                            {if $Hotel.TotalPriceBedEXT gt 0 AND $Hotel.ExtraBedCount gt 0}
                                                                <span><b>{$Hotel.TotalPriceBedEXT|number_format}</b>##Rial## <i class="fa fa-plus checkIcon"></i>
                                                                    <span class="tooltip-price">##Extrabed##</span>
                                                                </span>
                                                            {/if}
                                                            {if $Hotel.TotalPriceBedCHD gt 0 AND $Hotel.ExtraChildBedCount gt 0}
                                                                <span><b>{$price.child_price|number_format}</b>##Rial## <i class="fa fa-user checkIcon"></i>
                                                                    <span class="tooltip-price">##Child##</span>
                                                                </span>
                                                            {/if}
                                                        </div>
                                                    </div>
                                                {/for}
                                            </div>
                                        </div>
                                        {/if}
                                        <span class="roomsTitle">{$Hotel['RoomName']}</span>
                                        <i class="txtIcon ng-binding">{$Hotel['RoomCapacity']}</i>
                                        <h5 class="">
                                            {$objFunctions->StrReplaceInXml(['@@count@@'=>$objFunctions->ConvertNumberToAlphabet({$Hotel['RoomCount']})],'RoomCountNumber')}
                                        </h5>
                                        <input type="hidden" name="RoomCount{$Hotel['room_id']}" id="RoomCount{$Hotel['IdRoom']}" value="{$Hotel['RoomCount']}">
                                        <div class="roomCapacity">
                                            <i class="fa fa-user txt15"></i> <i class="inIcon">x</i><i class="txtIcon ng-binding">{$Hotel['RoomCapacity']}</i>
                                        </div>

                                        <input type="hidden" name="RoomCount{$Hotel['room_id']}" id="RoomCount{$Hotel['IdRoom']}" value="{$Hotel['RoomCount']}">
                                        {if $Hotel.ExtraBedCount gt 0}
                                            <div class="extra-bed-element d-flex justify-content-center">
                                                <div class="extra-bed-count">
                                                    <span class='d-flex mx-1'>
                                                        {$Hotel['ExtraBedCount']}<i class="inIcon">x</i>
                                                    </span>
                                                </div>
                                                <span class="extra-bed-title">##HotelExtraBed##</span>

                                            </div>
                                        {/if}
                                        {if $Hotel.ExtraChildBedCount gt 0}
                                            <div class="extra-bed-element d-flex justify-content-center">
                                                <div class="extra-bed-count">
                                                    <span class='d-flex mx-1' >
                                                        {$Hotel['ExtraChildBedCount']}<i class="inIcon">x</i>
                                                    </span>
                                                </div>
                                                <span class="extra-bed-title">
                                                    {if $Hotel['fromAge'] neq 0 || $Hotel['toAge'] neq 0}
                                                        {$objFunctions->StrReplaceInXml(['@@from@@'=>$Hotel['fromAge'],'@@to@@'=>$Hotel['toAge']],'HotelExtraChildBed')}
                                                    {else}
                                                        ##HotelExtraChild##
                                                    {/if}
                                                </span>

                                            </div>
                                        {/if}
                                    </div>
                                    <div class="th_hotel hidden-xs">
                                        <ul class="HotelRoomFeatureList">
                                            {if $Hotel['Breakfast'] eq 'yes'}
                                                <li class="Breakfast"><i class="fa fa-coffee"></i> ##Breakfast##</li>
                                            {/if}
                                            {if $Hotel['Lunch'] eq 'yes'}
                                                <li class="Breakfast"><i class="fa fa-cutlery"></i> ##Lunch##</li>
                                            {/if}
                                            {if $Hotel['Dinner'] eq 'yes'}
                                                <li class="Breakfast"><i class="fa fa-cutlery"></i> ##Dinner##</li>
                                            {/if}
                                        </ul>
                                    </div>

                                    <div class="th_hotel totalRoomCurrency_hotel">
                                        {assign var="totalRoomCurrency" value=$objFunctions->CurrencyCalculate($Hotel['TotalPriceRoom'], $smarty.post.CurrencyCode)}
                                        <div class="roomFinalPrice">{$objFunctions->numberFormat($totalRoomCurrency.AmountCurrency)} <i>{$totalRoomCurrency.TypeCurrency}</i>
                                            <span class=" plus_price_room" title="جزییات قیمت برای هر اتاق">
                                                <i class="far fa-list-alt"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {/foreach}


                            </div>
                        </div>
                    </div>
                </div>
                <div class="DivTotalPrice">
                    {assign var="totalPriceCurrency" value=$objFunctions->CurrencyCalculate($TotalPrice, $smarty.post.CurrencyCode)}
                    <div class="">##Amountpayable## :
                        <span>{$objFunctions->numberFormat($totalPriceCurrency.AmountCurrency)}</span> <i>{$totalPriceCurrency.TypeCurrency}</i></div>
                </div>
            </div>

        </div>



       {foreach  $objResult->temproryHotelRoom  as $i=>$Room}
               {if $c eq 1 }
                   {assign var="roomTypeCodes" value="{$Room['IdRoom']}"}
                   {assign var="numberOfRooms" value="{$Room['RoomCount']}"}
                   {$c= 2}
               {else}
                   {assign var="roomTypeCodes" value="{$roomTypeCodes},{$Room['IdRoom']}"}
                   {assign var="numberOfRooms" value="{$numberOfRooms},{$Room['RoomCount']}"}
               {/if}
               {assign var="EXTCapacity" value=$Room['maximum_extra_beds'] + $Room['maximum_extra_chd_beds']}
               {assign var="dbl_total" value=$Room['RoomCount'] * $Room['RoomCapacity']}
               {assign var="ext_total" value=$Room['ExtraBedCount']}
               {assign var="echd_total" value=$Room['ExtraChildBedCount']}
               {assign var="extra_total" value=$Room['ExtraBedCount'] + $Room['ExtraChildBedCount'] * $EXTCapacity}
               {for $RC=1 to $Room['RoomCount']}
                   {assign var="dbl_room" value="1"}
                   {assign var="ext_room" value="1"}
                   {assign var="echd_room" value="1"}

                   {assign var="room_capacity" value=$Room['RoomCapacity'] + $Room['maximum_extra_beds'] + $Room['maximum_extra_chd_beds']}
                   {assign var="extra_beds_capacity" value=$Room['maximum_extra_beds']}
                   {assign var="extra_chd_beds_capacity" value=$Room['maximum_extra_chd_beds']}

                   {*                    {for $C=1 to $room_capacity}*}

                   {assign var="flag" value="0"}

                   {if $dbl_total neq 0 && $dbl_room lte $Room['RoomCapacity']}

                       {assign var="roommate" value="IdRoom:`$Room['IdRoom']`_RoomCount:`$RC`_DBL:`$dbl_room`"}

                       {assign var="title" value="##Themainbed## "}
                       {assign var="titleAge" value="##Adultagegroup## (12+)"}
                       {assign var="flat_type" value="DBL"}
                       {$dbl_room = $dbl_room + 1}
                       {$dbl_total = $dbl_total -1}
                       {$flag=1}
                   {elseif ($ext_room le $extra_beds_capacity) && $ext_total neq 0 && $extra_total neq 0}
                       {assign var="roommate" value="IdRoom:`$Room['IdRoom']`_RoomCount:`$RC`_EXT:`$ext_room`"}
                       {assign var="title" value="##Exterabed##"}
                       {assign var="titleAge" value="##Adult##"}
                       {assign var="flat_type" value="EXT"}
                       {$ext_room = $ext_room + 1}
                       {$ext_total = $ext_total - 1}
                       {$extra_total = $extra_total - 1}
                       {$flag=1}
                   {elseif ($echd_room le $extra_chd_beds_capacity) && $echd_total neq 0 && $extra_total neq 0}
                       {assign var="roommate" value="IdRoom:`$Room['IdRoom']`_RoomCount:`$RC`_CEXT:`$echd_room`"}
                       {assign var="title" value="##Exterabed##"}
                       {assign var="titleAge" value="##Child##"}
                       {assign var="flat_type" value="ECHD"}
                       {$echd_room = $echd_room + 1}
                       {$echd_total = $echd_total - 1}
                       {$extra_total = $extra_total - 1}
                       {$flag=1}

                   {/if}

                   {if $flag eq 1}
                       {$countPassenger = $countPassenger + 1}
                   {/if}

                   {if $flag eq 1}
                        <input type="hidden" id="roommate{$countPassenger}" name="roommate{$countPassenger}"
                              value="{$roommate}">
                       <input type="hidden" id="flat_type{$countPassenger}"
                              name="flat_type{$countPassenger}" value="{$flat_type}">
                       <input type="hidden" name="room_id{$countPassenger}" id="room_id{$countPassenger}"
                              value="{$Room['IdRoom']}">
                       <input type="hidden" name="IdHotelRoomPrice{$countPassenger}"
                              id="IdHotelRoomPrice{$countPassenger}" value="{$Room[{$flat_type}]}">
                       <input type="hidden" name="extraBedCount{$countPassenger}"
                              id="extraBedCount{$countPassenger}" value="{$Room['ExtraBedCount']}">
                       <input type="hidden" name="extraChildBedCount{$countPassenger}"
                              id="extraChildBedCount{$countPassenger}" value="{$Room['ExtraChildBedCount']}">
                       <input type="hidden" name="extraBedPrice{$countPassenger}"
                              id="extraBedPrice{$countPassenger}" value="{$Room['OnlinePriceEXT']}">
                       <input type="hidden" name="extraChildBedPrice{$countPassenger}"
                              id="extraChildBedPrice{$countPassenger}" value="{$Room['OnlinePriceECHD']}">
                   {/if}
               {/for}
           </div>
       {/foreach}

       <input type="hidden" name="TypeRoomHotel" id="TypeRoomHotel" value="{$objResult->TotalRoomId}">
       <input type="hidden" name="guestUserStatus" id="guestUserStatus" value="{$objResult->guestUserStatus}">


       <input type="hidden" name="idMember" id="idMember" value="">
       <input type="hidden" id="typeApplication" name="typeApplication" value="{$smarty.post.typeApplication}">
       <input type="hidden" name="factorNumber" id="factorNumber" value="{$smarty.post.factorNumber}">
       <input type="hidden" name="ZoneFlight" id="ZoneFlight" value="{$objResult->infoReservationHotel['ZoneFlight']}">
       <input type="hidden" id="RoomTypeCodes_Reserve" name="RoomTypeCodes_Reserve" value="{$roomTypeCodes}">
       <input type="hidden" id="NumberOfRooms_Reserve" name="NumberOfRooms_Reserve" value="{$numberOfRooms}">
       <input type="hidden" id="time_remmaining" value="" name="time_remmaining">
       <input type="hidden" id="TotalPrice_Reserve" name="TotalPrice_Reserve" value="{$TotalPrice}">
       <input type="hidden" id="idCity_Reserve" name="idCity_Reserve" value="{$smarty.post.IdCity_Reserve}">
       <input type="hidden" id="Hotel_Reserve" name="Hotel_Reserve" value="{$smarty.post.idHotel_reserve}">
       <input type="hidden" id="StartDate_Reserve" name="StartDate_Reserve" value="{$smarty.post.startDate_reserve}">
       <input type="hidden" id="EndDate_Reserve" name="EndDate_Reserve" value="{$smarty.post.endDate_reserve}">
       <input type="hidden" id="Nights_Reserve" name="Nights_Reserve" value="{$smarty.post.nights_reserve}">
       <input type="hidden" id="CurrencyCode" name="CurrencyCode" value="{$smarty.post.CurrencyCode}">
    </form>
   <div class="clear"></div>

