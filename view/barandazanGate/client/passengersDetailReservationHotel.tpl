<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>
{load_presentation_object filename="resultHotelLocal" assign="objResult"}

{$objResult->getReservationHotel($smarty.post.idHotel_reserve)}
{$objResult->getPassengersDetailHotelForReservation($smarty.post)}	{**گرفتن اطلاعات مربوط به هتل **}

{load_presentation_object filename="passengersDetailLocal" assign="objDetail"}
{$objDetail->getCustomers()}   {*گرفتن اطلاعات مربوط به مسافران هر مشتری*}


{if $objResult->errorUserType eq 'true'}

    {*
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 s-u-passenger-wrapper-change">
               <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                   ##Note## <i class="zmdi zmdi-alert-circle mart10  zmdi-hc-fw"></i>
               </span>
            <div class="s-u-result-wrapper">
                   <span class="s-u-result-item-change direcR iranR txt12 txtRed">
    ##Graphicdesignpurchaseconstraint##
                   </span>
            </div>
        </div>
    *}

{else}



    <div id="steps">
        <div class="steps_items">
            <div class="step done ">

                <span class=""><i class="fa fa-check"></i></span>
                <h3>##Selectionhotel##</h3>
            </div>
            <i class="separator done"></i>
            <div class="step done">
                <span class=""><i class="fa fa-check"></i></span>
                <h3>##StayInformation##</h3>

            </div>
            <i class="separator"></i>
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
                <h3> ##PassengersInformation## </h3>
            </div>
            <i class="separator"></i>
            <div class="step" >
            <span class="flat_icon_airplane">
               <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                    width="128.000000pt" height="128.000000pt" viewBox="0 0 128.000000 128.000000"
                    preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,128.000000) scale(0.100000,-0.100000)"
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
        <div>
            <div class="counter d-none counter-analog" data-direction="down" data-format="59:59" data-stop="00:00" style="direction: ltr">
                06:00</div>
        </div>
    </div>






    <div id="lightboxContainer" class="lightboxContainerOpacity"></div>
    <!-- last passenger list -->
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`passengerPopup.tpl"}
    <!--end  last passenger list -->



    <form  method="post" id="formHotel" action="">
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
                                        {assign var="totalRoomCurrency" value=$objFunctions->CurrencyCalculate($Hotel['TotalPriceRoom'], $smarty.post.CurrencyCode)}

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
                                        <span class="roomsTitle  extra-title-bed">{$Hotel['RoomName']}</span><br/>
                                        <div class="rooms-element d-flex justify-content-center  extra-title-bed"">
                                            {$objFunctions->StrReplaceInXml(['@@count@@'=>{$Hotel['RoomCount']}],'RoomCountNumber')}
                                        </div>
                                        {if $Hotel.ExtraChildBedCount gt 0}
                                            <div class="extra-bed-element d-flex justify-content-center extra-title-bed">
                                                <div class="extra-bed-count">
                                                    <span class='d-flex mx-1' >
                                                        {$Hotel['ExtraChildBedCount']}
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
                                        {if $Hotel.ExtBedCount gt 0}
                                            <div class="extra-bed-element d-flex justify-content-center extra-title-bed">
                                                <div class="extra-bed-count">
                                                    <span class='d-flex mx-1' >
                                                        {$Hotel['ExtBedCount']}
                                                    </span>
                                                </div>
                                                <span class="extra-bed-title">
                                                        ##HotelExtraBed##
                                                </span>
                                            </div>
                                        {/if}
                                        <input type="hidden" name="RoomCount{$Hotel['room_id']}" id="RoomCount{$Hotel['IdRoom']}" value="{$Hotel['RoomCount']}">
                                     </div>
                                    <div class="th_hotel hidden-xs">
                                        <ul class="HotelRoomFeatureList">
                                            {if $Hotel.Dinner neq 'yes' and $Hotel.Breakfast neq 'yes' and $Hotel.Lunch neq 'yes' }
                                            ---
                                            {else}
                                                {if $Hotel['Breakfast'] eq 'yes'}
                                                    <li class="Breakfast"><i class="fa fa-coffee"></i> ##Breakfast##</li>
                                                {/if}
                                                {if $Hotel['Lunch'] eq 'yes'}
                                                    <li class="Breakfast"><i class="fa fa-cutlery"></i> ##Lunch##</li>
                                                {/if}
                                                {if $Hotel['Dinner'] eq 'yes'}
                                                    <li class="Breakfast"><i class="fa fa-cutlery"></i> ##Dinner##</li>
                                                {/if}
                                            {/if}
                                        </ul>
                                    </div>
                                    <div class="th_hotel totalRoomCurrency_hotel">
                                        <div class="roomFinalPrice">
                                            {*<div class="main-price">
                                                {$objFunctions->numberFormat($totalRoomCurrency.AmountCurrency)}
                                                <i>{$totalRoomCurrency.TypeCurrency}</i>
                                               <span class="plus_price_room" title="جزییات قیمت برای هر اتاق">
                                                    <i class="far fa-list-alt"></i>
                                                </span>
                                            </div>*}
                                            <div class="extra-prices">
                                                <span class="extra-price-value">&nbsp;</span>
                                                <span class="extra-price-value">
                                                    {math equation="x * y * z" x=$Hotel.OnlinePriceDBL y=$Hotel.RoomCount z=$smarty.post.nights_reserve assign=totalPrice}
                                                    {$totalPrice|number_format}
                                                    {$totalRoomCurrency.TypeCurrency}
                                                </span>

                                                {if $Hotel['ExtraChildBedCount'] > 0}
                                                    <span class="extra-price-value">
                                                        {math equation="x * y * z" x=$Hotel.ExtraChildBedPrice y=$Hotel.ExtraChildBedCount z=$smarty.post.nights_reserve assign=totalPriceECHD}
                                                        {$totalPriceECHD|number_format}
                                                        {$totalRoomCurrency.TypeCurrency}
                                                    </span>
                                                {/if}
                                                {if $Hotel['ExtBedCount'] > 0}
                                                    <span class="extra-price-value">
                                                        {math equation="x * y * z" x=$Hotel.ExtBedPrice y=$Hotel.ExtBedCount z=$smarty.post.nights_reserve assign=totalPriceEXT}
                                                        {$totalPriceEXT|number_format}
                                                        {$totalRoomCurrency.TypeCurrency}
                                                    </span>
                                                {/if}
                                            </div>
                                        </div>
                                     </div>
                                </div>
                            {/foreach}

                            </div>
                        </div>
                    </div>
                    <div class="DivTotalPrice">
                        {assign var="totalPriceCurrency" value=$objFunctions->CurrencyCalculate($TotalPrice, $smarty.post.CurrencyCode)}
                        {assign var="prepaymentPercentage" value=$smarty.post.prepaymentPercentage}
                        <div class="">
                            ##Totalamount## :
                            <span>{$objFunctions->numberFormat($smarty.post.total_price_reserve)}</span>
                            <i>{$totalPriceCurrency.TypeCurrency}</i>
                        </div>

                        {if $prepaymentPercentage neq 0}
                            <div class="" >
                                <span>{$prepaymentPercentage}</span> <i>%</i>  ##Prereserve## :
                                {assign var="prePaymentPrice" value=$objResult->prePaymentCalculate($smarty.post.total_price_reserve,$prepaymentPercentage)}
                                <span>{$objFunctions->numberFormat($prePaymentPrice)}</span>
                                <i>{$totalPriceCurrency.TypeCurrency}</i>
                            </div>
                        {/if}
                    </div>
                </div>

            </div>
    </form>
    <div class="clear"></div>
    <form method="post" id="formPassengerDetailHotelLocal" action="{$smarty.const.ROOT_ADDRESS}/factorHotelLocal">

        <input type="hidden" name="StatusRefresh" id="StatusRefresh" value="NoRefresh"/>
        <input type="hidden" id="numberRow" value="0">
        <input type="hidden" id="typeApplication" name="typeApplication" value="{$smarty.post.typeApplication}">
        <input type="hidden" name="factorNumber" id="factorNumber" value="{$smarty.post.factorNumber}">
        <input type="hidden" name="total_price_reserve" id="total_price_reserve" value="{$smarty.post.total_price_reserve}">
        <input type="hidden" name="ZoneFlight" id="ZoneFlight" value="{$objResult->infoReservationHotel['ZoneFlight']}">

        {assign var="countPassenger" value="0"}
        {$c= 1}
        {*            <code >{$objResult->temproryHotelRoom|json_encode:256}</code>*}

        {foreach  $objResult->temproryHotelRoom  as $i=>$Room}

            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">
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
                        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color direcR">

                                        ##Informationpassenger## {$objFunctions->displayRoomName($Room.RoomName,$RC)}
                            {if $objSession->IsLogin()}
                                <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change site-bg-main-color"
                                      onclick="setHidenFildnumberRow('A{$countPassenger}')"><i class="zmdi zmdi-pin-account zmdi-hc-fw"></i>##Passengerbook##</span>
                            {/if}
                </span>
                        <div class="s-u-passenger-wrapper first ">

                            {*<span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change s-u-lest-room-person-name-title-change site-bg-main-color">*}
                            {*{$RC}) {$Room['RoomName']}*}

                            {*</span>*}





                            <div class="panel-default-change  panel-room-default-change box_every_passenger">

                                <div class="panel-heading-change">

                                    <input type="hidden" id="roommate{$countPassenger}" name="roommate{$countPassenger}"
                                           value="{$roommate}">
                                    <input type="hidden" id="flat_type{$countPassenger}"
                                           name="flat_type{$countPassenger}" value="{$flat_type}">
                                    <input type="hidden" name="room_id{$countPassenger}" id="room_id{$countPassenger}"
                                           value="{$Room['IdRoom']}">
                                    <input type="hidden" name="ExtBedCount{$countPassenger}" id="ExtBedCount{$countPassenger}"
                                           value="{$Room['ExtBedCount']}">
                                    <input type="hidden" name="ExtraChildBedCount{$countPassenger}" id="ExtraChildBedCount{$countPassenger}"
                                           value="{$Room['ExtraChildBedCount']}">
                                    <input type="hidden" name="ExtraChildBedPrice{$countPassenger}" id="ExtraChildBedPrice{$countPassenger}"
                                           value="{$Room['ExtraChildBedPrice']}">

                                    <input type="hidden" name="IdHotelRoomPrice{$countPassenger}"
                                           id="IdHotelRoomPrice{$countPassenger}" value="{$Room[{$flat_type}]}">

                                    <i class="room-kind-bed"> {$title} </i> {$titleAge}

                                    <span class="hidden-xs-down">##Nation##:</span>

                                    <span class="kindOfPasenger">
                                            <label class="control--checkbox">
                                                <span>##Iranian##</span>
                                                <input type="radio" name="passengerNationalityA{$countPassenger}" id="passengerNationalityA{$countPassenger}" value="0" class="nationalityChange" checked="checked">
                                                <div class="checkbox">
                                                    <div class="filler"></div>
                                                    <svg fill="#000000" viewBox="0 0 30 30">
                                                    <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z" />
                                                   </svg>
                                                </div>
                                            </label>
                                        </span>
                                    <span class="kindOfPasenger">
                                            <label class="control--checkbox">
                                                <span>##Noiranian##</span>
                                                <input type="radio" name="passengerNationalityA{$countPassenger}" id="passengerNationalityA{$countPassenger}" value="1" class="nationalityChange">
                                                <div class="checkbox">
                                                    <div class="filler"></div>
                                                    <svg fill="#000000" viewBox="0 0 30 30">
                                                    <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z" />
                                                   </svg>
                                                </div>
                                            </label>
                                        </span>


                                </div>


                                <div class="panel-body-change box_every_passenger">

                                    <div class="s-u-passenger-item-hotel  s-u-passenger-item-change">
                                        <select id="genderA{$countPassenger}" name="genderA{$countPassenger}">
                                            <option value="" disabled="" selected="selected">##Sex##</option>
                                            <option value="Male">##Sir##</option>
                                            <option value="Female">##Lady##</option>
                                        </select>
                                    </div>

                                    <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                        <input id="nameEnA{$countPassenger}" type="text" placeholder="##Nameenglish##" name="nameEnA{$countPassenger}" oninput="return validateEnglishInput('nameEnA{$countPassenger}')" class="">
                                    </div>
                                    <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                        <input id="familyEnA{$countPassenger}" type="text" placeholder="##Familyenglish##" name="familyEnA{$countPassenger}"
                                               oninput="return validateEnglishInput('familyEnA{$countPassenger}')" class="">
                                    </div>
                                    <div class="s-u-passenger-item-hotel s-u-passenger-item-change noneIranian">
                                        <input id="birthdayEnA{$countPassenger}" type="text" placeholder="##miladihappybirthday##" name="birthdayEnA{$countPassenger}"
                                               class="{if $flat_type eq 'ECHD'}gregorianUnder12BirthdayCalendar{else}gregorianAdultBirthdayCalendar{/if}" readonly="readonly">
                                    </div>

                                    <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                        <input id="nameFaA{$countPassenger}" type="text" placeholder="##Namepersion##" name="nameFaA{$countPassenger}"
                                               name="nameFaA{$countPassenger}"
                                               oninput="return validatePersianInput('nameFaA{$countPassenger}')"
                                               class="justpersian">
                                        <div id="errorContainer" style="color: red;"></div>
                                    </div>
                                    <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                        <input id="familyFaA{$countPassenger}" type="text" placeholder="##Familypersion##" name="familyFaA{$countPassenger}"
                                               oninput="return validatePersianInput('familyFaA{$countPassenger}')" class="justpersian">
                                    </div>
                                    <div class="s-u-passenger-item-hotel s-u-passenger-item-change justIranian">
                                        <input id="birthdayA{$countPassenger}" type="text" placeholder="##shamsihappybirthday##" name="birthdayA{$countPassenger}"
                                               class="{if $flat_type eq 'ECHD'}shamsiUnder6BirthdayCalendar{else}shamsiAdultBirthdayCalendar{/if}" readonly="readonly">
                                    </div>

                                    <div class="s-u-passenger-item-hotel s-u-passenger-item-change justIranian">
                                        <input id="NationalCodeA{$countPassenger}" type="tel" placeholder="##Nationalnumber##" name="NationalCodeA{$countPassenger}" maxlength="10"
                                               class="UniqNationalCode">
                                    </div>

                                    <div class="s-u-passenger-item-hotel s-u-passenger-item-change select-meliat noneIranian">
                                        <select name="passportCountryA{$countPassenger}" id="passportCountryA{$countPassenger}"
                                                class="select2">
                                            <option value="">##Countryissuingpassport##</option>
                                            {foreach $objFunctions->CountryCodes() as $Country}
                                                <option value="{$Country['code']}">{$Country['titleFa']}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="s-u-passenger-item-hotel s-u-passenger-item-change noneIranian">
                                        <input id="passportNumberA{$countPassenger}" type="text" placeholder="##Numpassport##"
                                               name="passportNumberA{$countPassenger}" class="UniqPassportNumber"
                                               onkeypress="return isAlfabetNumberKeyFields(event, 'passportNumberA{$countPassenger}')">
                                    </div>
                                    <div class="s-u-passenger-item-hotel s-u-passenger-item-change noneIranian">
                                        <input id="passportExpireA{$countPassenger}" class="gregorianFromTodayCalendar" type="text"
                                               placeholder="##Passportexpirydate##" name="passportExpireA{$countPassenger}">
                                    </div>

                                    <div id="messageA{$countPassenger}"></div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    {/if}



                    {*                        {/for}*}




                {/for}
            </div>
        {/foreach}

        <input type="hidden" name="TypeRoomHotel" id="TypeRoomHotel" value="{$objResult->TotalRoomId}">
        <input type="hidden" name="guestUserStatus" id="guestUserStatus" value="{$objResult->guestUserStatus}">

        <!--transfer-->
        {if $objResult->transfer_went neq 'no' || $objResult->transfer_back neq 'no'}
            <input type="hidden" id="isTransfer" name="isTransfer" value="true">
            <div class="accordion"><h2 class="accordion-title site-bg-main-color-a">##Freetransferfromhotel##</h2></div>
            <div class="panel height0">

                <div class="color_border_Mosafer">

                    <div class="S_DivInputForm s-u-passenger-item-change">
                        <input name="origin" id="origin" placeholder="##Origin##" type="text">
                    </div>
                    <div class="S_DivInputForm s-u-passenger-item-change">
                        <input name="destination" id="destination" placeholder="##Destination## : ##Iran## - ##Tehran##" readonly="" type="text">
                    </div>

                    {if $objResult->transfer_went neq 'no'}
                        <div class="S_DivInputForm s-u-passenger-item-change">
                            <input name="flight_date_went" id="flight_date_went" class="datePersian" placeholder="##Datemovewent## --/--/----" type="text">
                        </div>
                        <div class="S_DivInputForm s-u-passenger-item-change">
                            <input name="airline_went" id="airline_went" placeholder="##namevehicle## (##Train## - ##Airplane##)" type="text">
                        </div>
                        <div class="S_DivInputForm s-u-passenger-item-change">
                            <input name="flight_number_went" id="flight_number_went" placeholder="##Vehiclenumber##" type="text">
                        </div>
                        <div class="S_DivInputForm S_DivInputForm_H3 s-u-passenger-item-change">
                            <span class="Nopadding">
                                <select name="hour_went" id="hour_went" class="InputMin InputMiddel">
                                    <option value="">##Hour##</option>
                                    {for $i=0 to 9}
                                        <option value="0{$i}">0{$i}</option>
                                    {/for}
                                    {for $i=10 to 23}
                                        <option value="{$i}">{$i}</option>
                                    {/for}
                                </select>

                            </span>
                            <span class="Nopadding">
                                <select name="minutes_went" id="minutes_went" class="InputMin InputMiddel">
                                    <option value="">##Minutes##</option>
                                    {for $i=0 to 9}
                                        <option value="0{$i}">0{$i}</option>
                                    {/for}
                                    {for $i=10 to 66}
                                        <option value="{$i}">{$i}</option>
                                    {/for}
                                </select>
                            </span>
                        </div>
                        <br>
                    {/if}

                    {if $objResult->transfer_back neq 'no'}
                        <div class="S_DivInputForm s-u-passenger-item-change">
                            <input name="flight_date_back" id="flight_date_back" class="datePersian" placeholder="##Datemovereturn## --/--/----" type="text">
                        </div>
                        <div class="S_DivInputForm s-u-passenger-item-change">
                            <input name="airline_back" id="airline_back" placeholder="##namevehicle## (##Train## - ##Airplane##)" type="text">
                        </div>
                        <div class="S_DivInputForm s-u-passenger-item-change">
                            <input name="flight_number_back" id="flight_number_back" placeholder="##Vehiclenumber##" type="text">
                        </div>
                        <div class="S_DivInputForm S_DivInputForm_H3 s-u-passenger-item-change">
                            <span class="Nopadding">
                                <select name="hour_back" id="hour_back" class="InputMin InputMiddel">
                                        <option value="">##Hour##</option>
                                        {for $i=0 to 9}
                                            <option value="0{$i}">0{$i}</option>
                                        {/for}
                                    {for $i=10 to 23}
                                        <option value="{$i}">{$i}</option>
                                    {/for}
                                </select>

                            </span>
                            <span class="Nopadding">
                                <select name="minutes_back" id="minutes_back" class="InputMin InputMiddel">
                                        <option value="">##Minutes##</option>
                                        {for $i=0 to 9}
                                            <option value="0{$i}">0{$i}</option>
                                        {/for}
                                    {for $i=10 to 66}
                                        <option value="{$i}">{$i}</option>
                                    {/for}
                                </select>
                            </span>
                        </div>
                        <br>
                    {/if}

                </div>
            </div>
        {/if}




        <!--one day tour-->
        {$objResult->oneDayTour($smarty.post.idHotel_reserve, $smarty.post.IdCity_Reserve)}
        <input type="hidden" id="isOneDayTour" name="isOneDayTour" value="{$objResult->showOneDayTour}">
        {if $objResult->showOneDayTour eq 'True'}
            <div class="accordion"><h2 class="accordion-title site-bg-main-color-a">##Onedayspatrolrequest##</h2></div>
            <div class="panel height0">

                {assign var="count" value="0"}

                {foreach $objResult->listOneDayTour as $key=>$tour}
                    {$count = $count + 1}

                    <div class="box-oneTour">
                        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change s-u-lest-room-person-name-title-change site-bg-main-color">
                            {$tour['title']}
                        </span>

                        <input name="idOneDayTour{$count}" id="idOneDayTour{$count}" value="{$tour['id']}" type="hidden">

                        <div class="s-u-lest-room-person-content-change">
                            <div class="one_tour_box_title one_tour_box_title_change">
                                <div class="one_tour_box_row one_tour_box_row_change"> ##Price##</div>
                                <div class="one_tour_box_row one_tour_box_row_change">##Adult##</div>
                                <div class="one_tour_box_row one_tour_box_row_change">##Child##</div>
                                <div class="one_tour_box_row one_tour_box_row_change">##Baby##</div>
                            </div>

                            {if $tour['adt_price_rial'] gt 0}
                                <div class="one_tour_box">

                                    <div class="one_tour_box_row one_tour_box_room_row_change">##Price##</div>
                                    <div class="one_tour_box_row one_tour_box_room_row_change">
                                        <div class="one_tour_cost">
                                            {assign var="adtPriceCurrency" value=$objFunctions->CurrencyCalculate($tour['adt_price_rial'], $smarty.post.CurrencyCode)}
                                            <span>{$objFunctions->numberFormat($adtPriceCurrency.AmountCurrency)} {$adtPriceCurrency.TypeCurrency}</span>
                                            <input type="hidden" value="{$tour['adt_price_rial']}" name="adtPriceR{$count}" id="adtPriceR{$count}">
                                        </div>

                                        <div class="s-u-passenger-item s-u-passenger-item-room-change ">
                                            <select id="adtNumR{$count}" name="adtNumR{$count}">
                                                <option value="" disabled="" selected="selected">##Numberofrequests##</option>
                                                {for $i=0 to 9}
                                                    <option value="{$i}">{$i}</option>
                                                {/for}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="one_tour_box_row one_tour_box_room_row_change">
                                        <div class="one_tour_cost">
                                            {assign var="chdPriceCurrency" value=$objFunctions->CurrencyCalculate($tour['chd_price_rial'], $smarty.post.CurrencyCode)}
                                            <span>{$objFunctions->numberFormat($chdPriceCurrency.AmountCurrency)} {$chdPriceCurrency.TypeCurrency}</span>
                                            <input type="hidden" value="{$tour['chd_price_rial']}" name="chdPriceR{$count}" id=chdPriceR{$count}">
                                        </div>
                                        <div class="s-u-passenger-item  s-u-passenger-item-room-change ">
                                            <select id="chdNumR{$count}" name="chdNumR{$count}">
                                                <option value="" disabled="" selected="selected">##Numberofrequests##</option>
                                                {for $i=0 to 9}
                                                    <option value="{$i}">{$i}</option>
                                                {/for}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="one_tour_box_row one_tour_box_room_row_change">
                                        <div class="one_tour_cost">
                                            {assign var="infPriceCurrency" value=$objFunctions->CurrencyCalculate($tour['inf_price_rial'], $smarty.post.CurrencyCode)}
                                            <span>{$objFunctions->numberFormat($infPriceCurrency.AmountCurrency)} {$infPriceCurrency.TypeCurrency}</span>
                                            <input type="hidden" value="{$tour['inf_price_rial']}" name="infPriceR{$count}" id="infPriceR{$count}">
                                        </div>
                                        <div class="s-u-passenger-item  s-u-passenger-item-room-change ">
                                            <select id="infNumR{$count}" name="infNumR{$count}">
                                                <option value="" disabled="" selected="selected">##Countrequest##</option>
                                                {for $i=0 to 9}
                                                    <option value="{$i}">{$i}</option>
                                                {/for}
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            {/if}

                            {*{if $tour['adt_price_foreign'] gt 0}
                                <div class="one_tour_box">

                                    <div class="one_tour_box_row one_tour_box_room_row_change">قیمت ارزی</div>
                                    <div class="one_tour_box_row one_tour_box_room_row_change">
                                        <div class="one_tour_cost">
                                            <span>{$tour['adt_price_foreign']|number_format:0:".":","}</span>
                                            <input type="hidden" value="{$tour['adt_price_foreign']}" name="adtPriceA{$count}" id="adtPriceA{$count}">
                                        </div>

                                        <div class="s-u-passenger-item  s-u-passenger-item-room-change ">
                                            <select id="adtNumA{$count}" name="adtNumA{$count}">
                                                <option value="" disabled="" selected="selected">تعداد درخواست</option>
                                                {for $i=0 to 9}
                                                    <option value="{$i}">{$i}</option>
                                                {/for}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="one_tour_box_row one_tour_box_room_row_change">
                                        <div class="one_tour_cost">
                                            <span>{$tour['chd_price_foreign']|number_format:0:".":","}</span>
                                            <input type="hidden" value="{$tour['chd_price_foreign']}" name="chdPriceA{$count}" id="chdPriceA{$count}">
                                        </div>
                                        <div class="s-u-passenger-item  s-u-passenger-item-room-change ">
                                            <select id="chdNumA{$count}" name="chdNumA{$count}">
                                                <option value="" disabled="" selected="selected">تعداد درخواست</option>
                                                {for $i=0 to 9}
                                                    <option value="{$i}">{$i}</option>
                                                {/for}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="one_tour_box_row one_tour_box_room_row_change">
                                        <div class="one_tour_cost">
                                            <span>{$tour['inf_price_foreign']|number_format:0:".":","}</span>
                                            <input type="hidden" value="{$tour['inf_price_foreign']}" name="infPriceA{$count}" id="infPriceA{$count}">
                                        </div>
                                        <div class="s-u-passenger-item  s-u-passenger-item-room-change ">
                                            <select id="infNumA{$count}" name="infNumA{$count}">
                                                <option value="" disabled="" selected="selected">تعداد درخواست</option>
                                                {for $i=0 to 9}
                                                    <option value="{$i}">{$i}</option>
                                                {/for}
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            {/if}*}


                        </div>
                    </div>

                {/foreach}

                <input type="hidden" name="countOneDayTour" id="countOneDayTour" value="{$count}">

            </div>
        {/if}
        <!--end one day tour-->


        {assign var="moreInformationPassengerHotel" value=$objFunctions->checkClientConfigurationAccess('more_information_passenger_hotel')}


        <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer first ">
          <span class="s-u-last-p-pasenger s-u-last-p-pasenger-change site-main-text-color ">
              ##Headgroupinformation##
          </span>
            <div class="clear"></div>
            <div class="panel-default-change-Buyer">

                <div class="s-u-passenger-items s-u-passenger-item-change">
                    <input id="passenger_leader_room_fullName" type="text" placeholder="##Namefamily##" name="passenger_leader_room_fullName" class="dir-ltr">
                </div>

                <div class="s-u-passenger-items s-u-passenger-item-change">
                    <input id="passenger_leader_room" type="text" placeholder="##Phonenumber##" name="passenger_leader_room" class="dir-ltr">
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

                <div id="messagePassengerLeader"></div>
            </div>

            <div class="clear"></div>
        </div>

        {if not $objSession->IsLogin() && !$objFunctions->checkClientConfigurationAccess("more_information_passenger_hotel")}
            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer  first">
          <span class="s-u-last-p-pasenger s-u-last-p-pasenger-change site-bg-main-color">
           <i class="zmdi zmdi-account-box-phone zmdi-hc-fw"></i>   ##InformationSaler##
          </span>
                <input type="hidden" name="UsageNotLogin" value="yes" id="UsageNotLogin">
                <div class="clear"></div>
                <div class="panel-default-change-Buyer">
                    <div class="s-u-passenger-items s-u-passenger-item-change">
                        <input id="Mobile" type="text" placeholder="##Phonenumber##" name="Mobile" class="dir-ltr">
                    </div>
                    <div class="s-u-passenger-items s-u-passenger-item-change">
                        <input id="Telephone" type="text" placeholder="##Phone##" name="Telephone" class="dir-ltr">
                    </div>
                    <div class="s-u-passenger-items s-u-passenger-item-change padl0">
                        <input id="Email" type="email" placeholder="##Email##" name="Email" class="dir-ltr">
                    </div>
                    <div class="alert_msg" id="messageInfo"></div>
                </div>
                <div class="clear"></div>
            </div>
        {/if}


        <input type="hidden" id="RoomTypeCodes_Reserve" name="RoomTypeCodes_Reserve" value="{$roomTypeCodes}">
        <input type="hidden" id="NumberOfRooms_Reserve" name="NumberOfRooms_Reserve" value="{$numberOfRooms}">
        <input type="hidden" id="time_remmaining" value="" name="time_remmaining">
        <input type="hidden" value="" name="idMember" id="idMember">
        <input type="hidden" id="TotalPrice_Reserve" name="TotalPrice_Reserve" value="{$smarty.post.total_price_reserve}">
        <input type="hidden" id="prepaymentPercentage" name="prepaymentPercentage" value="{$prepaymentPercentage}">
        <input type="hidden" id="prePaymentPrice" name="prePaymentPrice" value="{$prePaymentPrice}">
        <input type="hidden" id="idCity_Reserve" name="idCity_Reserve" value="{$smarty.post.IdCity_Reserve}">
        <input type="hidden" id="Hotel_Reserve" name="Hotel_Reserve" value="{$smarty.post.idHotel_reserve}">
        <input type="hidden" id="StartDate_Reserve" name="StartDate_Reserve" value="{$smarty.post.startDate_reserve}">
        <input type="hidden" id="EndDate_Reserve" name="EndDate_Reserve" value="{$smarty.post.endDate_reserve}">
        <input type="hidden" id="Nights_Reserve" name="Nights_Reserve" value="{$smarty.post.nights_reserve}">
        <input type="hidden" id="CurrencyCode" name="CurrencyCode" value="{$smarty.post.CurrencyCode}">
        <input type="hidden" id="oldIdMember" name="oldIdMember" value="{if isset($smarty.post.idMember)}{$smarty.post.idMember}{/if}">
        <input type="hidden" id="resumeReserve" name="resumeReserve" value="{if isset($smarty.post.resumeReserve) and $smarty.post.resumeReserve}{$smarty.post.resumeReserve}{/if}">

        {foreach $objResult->temproryHotelRoom as $Hotel}
            {if $Hotel.ExtBedCount gt 0}
                <input type="hidden" name="ExtBedPricePerUnit{$Hotel.IdRoom}" value="{$Hotel.ExtBedPrice}">
                <input type="hidden" name="ExtBedCount{$Hotel.IdRoom}" value="{$Hotel.ExtBedCount}">
            {/if}
            {if $Hotel.ExtraChildBedCount gt 0}
                <input type="hidden" name="ExtraChildBedPricePerUnit{$Hotel.IdRoom}" value="{$Hotel.ExtraChildBedPrice}">
                <input type="hidden" name="ExtraChildBedCount{$Hotel.IdRoom}" value="{$Hotel.ExtraChildBedCount}">
            {/if}
        {/foreach}

        <div class="btns_factors_n">
            <div class="next_hotel__">
                <a href="#" onclick="return false" class="f-loader-check loaderpassengers" id="loader_check" style="display:none"></a>
                <input type="button" onclick="checkHotelLocal('{$smarty.now}','{$countPassenger}')" value="##NextStepInvoice##" id="send_data"
                       class="s-u-submit-passenger s-u-select-flight-change s-u-submit-passenger-Buyer site-bg-main-color">
            </div>
        </div>


    </form>
{/if}
{literal}

    <script src="assets/js/script.js"></script>
    <script src="assets/js/jdate.min.js" type="text/javascript"></script>
    <script src="assets/js/jdate.js" type="text/javascript"></script>
    <script src="assets/js/jquery.counter.js" type="text/javascript"></script>
<script type="text/javascript">
   // $('.counter').counter({});
   //  $('.counter').on('counterStop', function () {
   //      alert('##Yourhotelreservationdeadlinehasexpiredpleaserestart##');
   //location.href = '{/literal}{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}{literal}';
   // });
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
          $('.nzr-show-up').click(function () {
             $('p.hotel-booking-roomm-description').css('height','auto');
             $('.nzr-show-up').hide();
             $('.nzr-show-down').show();
          });

          $('.nzr-show-down').click(function () {
             $('p.hotel-booking-roomm-description').animate({height: '40px'});
             $('.nzr-show-up').show();
             $(this).hide();
          });

          /*$(this).find(".price-pop").click(function () {

                 $(".price-Box").toggleClass("displayBlock");
                 $("#lightboxContainer").addClass("displayBlock");
             });*/
          $(this).find(".closeBtn").click(function () {

             $(".price-Box").removeClass("displayBlock");
             $("#lightboxContainer").removeClass("displayBlock");
          });
          $("div#lightboxContainer").click(function () {

             $(".price-Box").removeClass("displayBlock");
             $("#lightboxContainer").removeClass("displayBlock");
          });
          /* $(this).find(".Cancellation-pop").click(function () {

               $(".Cancellation-Box").toggleClass("displayBlock");
               $("#lightboxContainer").addClass("displayBlock");
           });
           $(this).find(".closeBtn").click(function () {

               $(".Cancellation-Box").removeClass("displayBlock");
               $("#lightboxContainer").removeClass("displayBlock");
           });*/
          $("div#lightboxContainer").click(function () {

             $(".Cancellation-Box").removeClass("displayBlock");
             $("#lightboxContainer").removeClass("displayBlock");
          });

          $("div#lightboxContainer").click(function () {
             $(".last-p-popup").css("display", "none");
          });
       });
       /* $(function () {
           $(document).tooltip();
       });*/

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
    <script type="text/javascript">
       /*$('.select2').select2();
       $('.select2-num').select2({minimumResultsForSearch: Infinity});*/

    </script>
    <script>
       var acc = document.getElementsByClassName("accordion");
       var i;

       for (i = 0; i < acc.length; i++) {
          acc[i].addEventListener("click", function() {
             this.classList.toggle("active");
             var panel = this.nextElementSibling;
             if (panel.style.maxHeight){
                panel.style.maxHeight = null;
             } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
             }
          });
       }
    </script>


{/literal}