<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>
{load_presentation_object filename="resultHotelLocal" assign="objResult"}

{load_presentation_object filename="editHotelBooking" assign="objHotel"}
{$objHotel->getInfoHotel($smarty.post.factorNumber)}



{load_presentation_object filename="passengersDetailLocal" assign="objDetail"}
{$objDetail->getCustomers()}   {*گرفتن اطلاعات مربوط به مسافران هر مشتری*}



{if $smarty.post.typeBed eq 'extraBed'}
    {assign var="hotelId" value=$smarty.post.hotelId}
    {assign var="roomId" value=$smarty.post.roomId}
    {assign var="roomCount" value=$smarty.post.roomCount}

{elseif $smarty.post.typeBed eq 'room'}

    {assign var="hotelId" value=$smarty.post.idHotel_reserve}
    {$objResult->getPassengersDetailHotelForReservation($smarty.post)}	{**گرفتن اطلاعات مربوط به هتل **}
{/if}
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 s-u-passenger-wrapper-change">
       <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
           ##Note## <i class="zmdi zmdi-alert-circle mart10  zmdi-hc-fw"></i>
       </span>
    <div class="s-u-result-wrapper">
           <span class="s-u-result-item-change direcR iranR txt12 txtRed">
               ##DontReloadPageInfo##
           </span>
    </div>
</div>



<div id="lightboxContainer" class="lightboxContainerOpacity"></div>
<!-- last passenger list -->
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`passengerPopup.tpl"}
<!--end  last passenger list -->


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 s-u-passenger-wrapper-change">
    <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">##Hotel## {$objHotel->infoHotel['hotel_name']}<i class="ravis-icon-hotel mart10  zmdi-hc-fw"></i></span>

    <div class="hotel-booking-room marb0">

        <div class="col-md-3 nopad">
            <div class="hotel-booking-room-image">
                <a>
                    <img src="pic/{$objHotel->infoHotel['hotel_pictures']}" alt="hotel-image">
                </a>
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
                            <li class="hotel-check-text"><i class="fa fa-calendar-times-o"></i> ##Enterdate##  :
                                <span  class="hotel-check-date" dir="rtl">{{$objHotel->infoHotel['start_date']}}</span></li>
                            <li class="hotel-check-text"><i class="fa fa-calendar-check-o"></i>  ##Exitdate## :
                                <span class="hotel-check-date" dir="rtl">{{$objHotel->infoHotel['end_date']}}</span></li>
                            <li class="hotel-check-text"><i class="fa fa-bed"></i> {{$objHotel->infoHotel['number_night']}} ##Night##</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <div class="clear"></div>
        {if $smarty.post.typeBed neq 'extraBed'}
        <div class="hotel-booking-room">
            <h4 class="tableOrderHeadTitle site-bg-main-color">
                <span>  ##Listroom##</span>
            </h4>
            <div class="rp-tableOrder site-border-main-color">
                <table>
                    <thead>
                    <tr class="Hotel-tableOrderHead">
                        <th class="Hotel-tableOrderHead-c1">##Informationbed## </th>
                        <th class="Hotel-tableOrderHead-c2">##CapacityRoom##</th>
                        <th class="Hotel-tableOrderHead-c3">##Countroom## </th>
                        <th class="Hotel-tableOrderHead-c4">##Exterabed## </th>
                        <th class="Hotel-tableOrderHead-c5">##Serviceroom## </th>
                        <th class="Hotel-tableOrderHead-c6"> ##Priceforanynight##</th>
                        <th class="Hotel-tableOrderHead-c7"> ##TotalPrice##</th>
                    </tr>
                    </thead>
                    <tbody>


                    {assign var="TotalPrice" value=""}

                    {foreach  $objResult->temproryHotelRoom  as $i=>$Hotel}

                        {$TotalPrice = $TotalPrice + $Hotel['TotalPriceRoom']}

                        <tr>
                            <td class="Hotel-tableOrderHead">
                                <h5 class="roomsTitle">{$Hotel['RoomName']}</h5>
                            </td>

                            <td class="Hotel-tableOrderHead">
                                <div class="roomCapacity">
                                    <i class="fa fa-user txt15"></i> <i class="inIcon">x</i><i class="txtIcon ng-binding">{$Hotel['RoomCapacity']}</i>
                                </div>
                            </td>

                            <td class="Hotel-tableOrderHead">
                                <h5 class="roomCapacity"><i class="txtIcon ng-binding">{$Hotel['RoomCount']}</i></h5>
                                <input type="hidden" name="RoomCount{$Hotel['room_id']}" id="RoomCount{$Hotel['IdRoom']}" value="{$Hotel['RoomCount']}">
                            </td>

                            <td class="Hotel-tableOrderHead">
                                <h5 class="roomCapacity"><i class="txtIcon ng-binding">{$Hotel['ExtraBedCount']+$Hotel['ExtraChildBedCount']}</i></h5>
                            </td>

                            <td class="Hotel-tableOrderHead">
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
                            </td>
                            <td class="Hotel-tableOrderHead">
                                {assign var="everyNightCurrency" value=$objFunctions->CurrencyCalculate($Hotel['RoomPrice1night'], $smarty.post.CurrencyCode, $smarty.post.CurrencyEquivalent)}
                                <span class="pricePerNight"><span class="currency">{$objFunctions->numberFormat($everyNightCurrency.AmountCurrency)}</span> {$everyNightCurrency.TypeCurrency}</span>
                            </td>
                            <td class="Hotel-tableOrderHead">
                                {assign var="totalRoomCurrency" value=$objFunctions->CurrencyCalculate($Hotel['TotalPriceRoom'], $smarty.post.CurrencyCode, $smarty.post.CurrencyEquivalent)}
                                <div class="roomFinalPrice ">{$objFunctions->numberFormat($totalRoomCurrency.AmountCurrency)} {$totalRoomCurrency.TypeCurrency}</div>
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>

            <div class="DivTotalPrice ">
                {assign var="totalPriceCurrency" value=$objFunctions->CurrencyCalculate($TotalPrice, $smarty.post.CurrencyCode, $smarty.post.CurrencyEquivalent)}
                <div class="fltl">##Total## : <span>{$objFunctions->numberFormat($totalPriceCurrency.AmountCurrency)}</span> {$totalPriceCurrency.TypeCurrency}</div>
            </div>

            {$TotalPrice = $TotalPrice + $smarty.post.totalPrice}
            <div class="DivTotalPrice ">
                {assign var="totalPriceCurrency" value=$objFunctions->CurrencyCalculate($TotalPrice, $smarty.post.CurrencyCode, $smarty.post.CurrencyEquivalent)}
                <div class="fltl">##Totalamountpayable## : <span>{$objFunctions->numberFormat($totalPriceCurrency.AmountCurrency)}</span> {$totalPriceCurrency.TypeCurrency}</div>
            </div>
            {/if}

        </div>


    </div>
</div>
<div class="clear"></div>



<form method="post" id="formPassengerDetailHotelLocal" action="{$smarty.const.ROOT_ADDRESS}/addRoomFactor">

    <input type="hidden" id="numberRow" value="0">
    <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">
        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color"> ##Informationpassenger##<i class="fa fa-male" aria-hidden="true"></i></span>

        {if $smarty.post.typeBed eq 'extraBed' && ($smarty.post.extraBed > 0 || $smarty.post.extraChildBed > 0)}

            {assign var="countExtraBed" value=$objHotel->addRoomReservations()}

            {assign var="countPassenger" value=0}
            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first s-u-lest-room-person-name-change site-border-main-color">
              <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change s-u-lest-room-person-name-title-change site-bg-main-color">
                  {$roomCount}) {$objHotel->room[$roomId][$roomCount]['room_name']}
              </span>

                {for $c=1 to $smarty.post.extraBed}
                    {$countPassenger = $countPassenger + 1}
                    {assign var="EXT" value=$countExtraBed['EXT'] + $c}
                    {assign var="roommate" value="IdRoom:`$roomId`_RoomCount:`$roomCount`_EXT:`$EXT`"}
                    <div class="panel-default-change pull-right panel-room-default-change box_every_passenger">
                        <div class="panel-heading-change">

                            <input type="hidden" id="roommate{$countPassenger}" name="roommate{$countPassenger}" value="{$roommate}">
                            <input type="hidden" id="flat_type{$countPassenger}" name="flat_type{$countPassenger}" value="EXT">
                            <input type="hidden" name="room_id{$countPassenger}" id="room_id{$countPassenger}" value="{$roomId}">
                            <input type="hidden" name="IdHotelRoomPrice{$countPassenger}" id="IdHotelRoomPrice{$countPassenger}" value="">

                            <i class="room-kind-bed">##Extrabed## </i> ##Adult##


                            <span class="hidden-xs-down">##Nation##:</span>

                            <span class="kindOfPasenger">
                                <label class="control--checkbox">
                                    <span>##Iranian##</span>
                                    <input type="radio" name="passengerNationalityA{$countPassenger}" id="passengerNationalityA{$countPassenger}" value="0" class="nationalityChange" checked="checked">
                                    <div class="checkbox">
                                        <div class="filler"></div>
                                        <svg width="20px" height="20px" viewBox="0 0 20 20">
                                            <polyline points="4 11 8 15 16 6"></polyline>
                                        </svg>
                                    </div>
                                </label>
                            </span>
                            <span class="kindOfPasenger">
                                <label class="control--checkbox">
                                    <span> ##Noiranian##</span>
                                    <input type="radio" name="passengerNationalityA{$countPassenger}" id="passengerNationalityA{$countPassenger}" value="1" class="nationalityChange">
                                    <div class="checkbox">
                                        <div class="filler"></div>
                                        <svg width="20px" height="20px" viewBox="0 0 20 20">
                                            <polyline points="4 11 8 15 16 6"></polyline>
                                        </svg>
                                    </div>
                                </label>
                            </span>

                            {if $objSession->IsLogin()}
                                <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change" onclick="setHidenFildnumberRow('A{$countPassenger}')">
                                    <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i>  ##Passengerbook##
                                </span>
                            {/if}



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
                                <input id="nameEnA{$countPassenger}" type="text" placeholder="##Nameenglish##" name="nameEnA{$countPassenger}" onkeypress="return isAlfabetKeyFields(event, 'nameEnA{$countPassenger}')" class="">
                            </div>
                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                <input id="familyEnA{$countPassenger}" type="text" placeholder="##Familyenglish##" name="familyEnA{$countPassenger}" onkeypress="return isAlfabetKeyFields(event, 'familyEnA{$countPassenger}')" class="">
                            </div>
                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change noneIranian">
                                <input id="birthdayEnA{$countPassenger}" type="text" placeholder="##miladihappybirthday##" name="birthdayEnA{$countPassenger}"
                                       class="gregorianAdultBirthdayCalendar" readonly="readonly">
                            </div>

                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                <input id="nameFaA{$countPassenger}" type="text" placeholder="##Namepersion##" name="nameFaA{$countPassenger}" onkeypress=" return persianLetters(event, 'nameFaA{$countPassenger}')" class="justpersian">
                            </div>
                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                <input id="familyFaA{$countPassenger}" type="text" placeholder="##Familypersion##" name="familyFaA{$countPassenger}" onkeypress=" return persianLetters(event, 'familyFaA{$countPassenger}')" class="justpersian">
                            </div>
                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change justIranian">
                                <input id="birthdayA{$countPassenger}" type="text" placeholder="##shamsihappybirthday##" name="birthdayA{$countPassenger}"
                                       class="shamsiAdultBirthdayCalendar" readonly="readonly">
                            </div>

                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change justIranian">
                                <input id="NationalCodeA{$countPassenger}" type="tel" placeholder="##Nationalnumber##" name="NationalCodeA{$countPassenger}" maxlength="10" class="UniqNationalCode">
                            </div>
                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change select-meliat noneIranian">
                                <select name="passportCountryA{$countPassenger}" id="passportCountryA{$countPassenger}"
                                        class="select2">
                                    <option value="">  ##Countryissuingpassport##</option>
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
                    <div class="clear"></div>
                {/for}

                {for $c=1 to $smarty.post.extraChildBed}
                    {$countPassenger = $countPassenger + 1}
                    {assign var="ECHD" value=$countExtraBed['ECHD'] + $c}
                    {assign var="roommate" value="IdRoom:`$roomId`_RoomCount:`$roomCount`_ECHD:`$ECHD`"}
                    <div class="panel-default-change pull-right panel-room-default-change box_every_passenger">
                        <div class="panel-heading-change">

                            <input type="hidden" id="roommate{$countPassenger}" name="roommate{$countPassenger}" value="{$roommate}">
                            <input type="hidden" id="flat_type{$countPassenger}" name="flat_type{$countPassenger}" value="ECHD">
                            <input type="hidden" name="room_id{$countPassenger}" id="room_id{$countPassenger}" value="{$roomId}">
                            <input type="hidden" name="IdHotelRoomPrice{$countPassenger}" id="IdHotelRoomPrice{$countPassenger}" value="">

                            <i class="room-kind-bed">  ##Exterabed## </i> ##Child##

                            <span class="hidden-xs-down">##Nation##:</span>

                            <span class="kindOfPasenger">
                                <label class="control--checkbox">
                                    <span>##Iranian##</span>
                                    <input type="radio" name="passengerNationalityA{$countPassenger}" id="passengerNationalityA{$countPassenger}" value="0" class="nationalityChange" checked="checked">
                                    <div class="checkbox">
                                        <div class="filler"></div>
                                        <svg width="20px" height="20px" viewBox="0 0 20 20">
                                            <polyline points="4 11 8 15 16 6"></polyline>
                                        </svg>
                                    </div>
                                </label>
                            </span>
                            <span class="kindOfPasenger">
                                <label class="control--checkbox">
                                    <span> ##Noiranian##</span>
                                    <input type="radio" name="passengerNationalityA{$countPassenger}" id="passengerNationalityA{$countPassenger}" value="1" class="nationalityChange">
                                    <div class="checkbox">
                                        <div class="filler"></div>
                                        <svg width="20px" height="20px" viewBox="0 0 20 20">
                                            <polyline points="4 11 8 15 16 6"></polyline>
                                        </svg>
                                    </div>
                                </label>
                            </span>

                            {if $objSession->IsLogin()}
                                <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change" onclick="setHidenFildnumberRow('A{$countPassenger}')">
                                    <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i> ##Passengerbook##
                                </span>
                            {/if}

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
                                <input id="nameEnA{$countPassenger}" type="text" placeholder="##Nameenglish##" name="nameEnA{$countPassenger}" onkeypress="return isAlfabetKeyFields(event, 'nameEnA{$countPassenger}')" class="">
                            </div>
                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                <input id="familyEnA{$countPassenger}" type="text" placeholder="##Familyenglish##" name="familyEnA{$countPassenger}" onkeypress="return isAlfabetKeyFields(event, 'familyEnA{$countPassenger}')" class="">
                            </div>
                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change noneIranian">
                                <input id="birthdayEnA{$countPassenger}" type="text" placeholder="##miladihappybirthday##" name="birthdayEnA{$countPassenger}"
                                       class="gregorianUnder12BirthdayCalendar" readonly="readonly">
                            </div>

                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                <input id="nameFaA{$countPassenger}" type="text" placeholder="##Namepersion##" name="nameFaA{$countPassenger}" onkeypress=" return persianLetters(event, 'nameFaA{$countPassenger}')" class="justpersian">
                            </div>
                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                <input id="familyFaA{$countPassenger}" type="text" placeholder="##Familypersion##" name="familyFaA{$countPassenger}" onkeypress=" return persianLetters(event, 'familyFaA{$countPassenger}')" class="justpersian">
                            </div>
                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change justIranian">
                                <input id="birthdayA{$countPassenger}" type="text" placeholder="##shamsihappybirthday##" name="birthdayA{$countPassenger}"
                                       class="shamsiUnder12BirthdayCalendar" readonly="readonly">
                            </div>

                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change justIranian">
                                <input id="NationalCodeA{$countPassenger}" type="tel" placeholder="##Nationalnumber##" name="NationalCodeA{$countPassenger}" maxlength="10" class="UniqNationalCode">
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
                                <input id="passportNumberA{$countPassenger}" type="text" placeholder="##Numpassport## "
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
                    <div class="clear"></div>
                {/for}

            </div>

        {elseif $smarty.post.typeBed eq 'room'}

            {assign var="countPassenger" value="0"}
            {$c= 1}

            {foreach  $objResult->temproryHotelRoom  as $i=>$Room}

                {assign var="countRoomReserve" value=$objHotel->addRoomReservations($Room['IdRoom'])}


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

                    <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first s-u-lest-room-person-name-change site-border-main-color">

                      <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change s-u-lest-room-person-name-title-change site-bg-main-color">
                          {$RC}) {$Room['RoomName']}
                      </span>

                        {assign var="dbl_room" value="1"}
                        {assign var="echd_room" value="1"}
                        {assign var="ext_room" value="1"}

                        {assign var="countRoom" value=$RC+$countRoomReserve['DBL']}

                        {assign var="room_capacity" value=$Room['RoomCapacity'] + $Room['maximum_extra_beds'] + $Room['maximum_extra_chd_beds']}
                        {assign var="extra_beds_capacity" value=$Room['maximum_extra_beds']}
                        {assign var="extra_chd_beds_capacity" value=$Room['maximum_extra_chd_beds']}

                        {for $C=1 to $room_capacity}

                            {assign var="flag" value="0"}

                            {if $dbl_total neq 0 && $dbl_room lte $Room['RoomCapacity']}

                                {assign var="roommate" value="IdRoom:`$Room['IdRoom']`_RoomCount:`$countRoom`_DBL:`$dbl_room`"}

                                {assign var="title" value="تخت اصلی "}
                                {assign var="titleAge" value="گروه سنی  بزرگسال (12+)"}
                                {assign var="flat_type" value="DBL"}
                                {$dbl_room = $dbl_room + 1}
                                {$dbl_total = $dbl_total -1}
                                {$flag=1}

                            {elseif ($ext_room le $extra_beds_capacity) && $ext_total neq 0 && $extra_total neq 0}

                                {assign var="roommate" value="IdRoom:`$Room['IdRoom']`_RoomCount:`$countRoom`_EXT:`$ext_room`"}

                                {assign var="title" value="##Exterabed##"}
                                {assign var="titleAge" value="##Adult##"}
                                {assign var="flat_type" value="EXT"}
                                {$ext_room = $ext_room + 1}
                                {$ext_total = $ext_total - 1}
                                {$extra_total = $extra_total - 1}
                                {$flag=1}

                            {elseif ($echd_room le $extra_chd_beds_capacity) && $echd_total neq 0 && $extra_total neq 0}

                                {assign var="roommate" value="IdRoom:`$Room['IdRoom']`_RoomCount:`$countRoom`_CEXT:`$echd_room`"}

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

                                <div class="panel-default-change pull-right panel-room-default-change box_every_passenger">
                                    <div class="panel-heading-change">

                                        <input type="hidden" id="roommate{$countPassenger}" name="roommate{$countPassenger}" value="{$roommate}">
                                        <input type="hidden" id="flat_type{$countPassenger}" name="flat_type{$countPassenger}" value="{$flat_type}">
                                        <input type="hidden" name="room_id{$countPassenger}" id="room_id{$countPassenger}" value="{$Room['IdRoom']}">
                                        <input type="hidden" name="IdHotelRoomPrice{$countPassenger}" id="IdHotelRoomPrice{$countPassenger}" value="{$Room[{$flat_type}]}">

                                        <i class="room-kind-bed"> {$title} </i> {$titleAge}

                                        <span class="hidden-xs-down">##Nation##:</span>

                                        <span class="kindOfPasenger">
                                            <label class="control--checkbox">
                                                <span>##Iranian##</span>
                                                <input type="radio" name="passengerNationalityA{$countPassenger}" id="passengerNationalityA{$countPassenger}" value="0" class="nationalityChange" checked="checked">
                                                <div class="checkbox">
                                                    <div class="filler"></div>
                                                    <svg width="20px" height="20px" viewBox="0 0 20 20">
                                                        <polyline points="4 11 8 15 16 6"></polyline>
                                                    </svg>
                                                </div>
                                            </label>
                                        </span>
                                        <span class="kindOfPasenger">
                                            <label class="control--checkbox">
                                                <span>##Noiranian## </span>
                                                <input type="radio" name="passengerNationalityA{$countPassenger}" id="passengerNationalityA{$countPassenger}" value="1" class="nationalityChange">
                                                <div class="checkbox">
                                                    <div class="filler"></div>
                                                    <svg width="20px" height="20px" viewBox="0 0 20 20">
                                                        <polyline points="4 11 8 15 16 6"></polyline>
                                                    </svg>
                                                </div>
                                            </label>
                                        </span>

                                        {if $objSession->IsLogin()}
                                            <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change" onclick="setHidenFildnumberRow('A{$countPassenger}')">
                                                <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i> ##Passengerbook##
                                            </span>
                                        {/if}


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
                                            <input id="nameEnA{$countPassenger}" type="text" placeholder="##Nameenglish##" name="nameEnA{$countPassenger}" onkeypress="return isAlfabetKeyFields(event, 'nameEnA{$countPassenger}')" class="">
                                        </div>
                                        <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                            <input id="familyEnA{$countPassenger}" type="text" placeholder="##Familyenglish##" name="familyEnA{$countPassenger}" onkeypress="return isAlfabetKeyFields(event, 'familyEnA{$countPassenger}')" class="">
                                        </div>
                                        <div class="s-u-passenger-item-hotel s-u-passenger-item-change noneIranian">
                                            <input id="birthdayEnA{$countPassenger}" type="text" placeholder="##miladihappybirthday##" name="birthdayEnA{$countPassenger}"
                                                   class="{if $flat_type eq 'ECHD'}gregorianUnder12BirthdayCalendar{else}gregorianAdultBirthdayCalendar{/if}" readonly="readonly">
                                        </div>

                                        <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                            <input id="nameFaA{$countPassenger}" type="text" placeholder="##Namepersion##" name="nameFaA{$countPassenger}" onkeypress=" return persianLetters(event, 'nameFaA{$countPassenger}')" class="justpersian">
                                        </div>
                                        <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                            <input id="familyFaA{$countPassenger}" type="text" placeholder="##Familypersion##" name="familyFaA{$countPassenger}" onkeypress=" return persianLetters(event, 'familyFaA{$countPassenger}')" class="justpersian">
                                        </div>
                                        <div class="s-u-passenger-item-hotel s-u-passenger-item-change justIranian">
                                            <input id="birthdayA{$countPassenger}" type="text" placeholder="##shamsihappybirthday##" name="birthdayA{$countPassenger}"
                                                   class="{if $flat_type eq 'ECHD'}shamsiUnder12BirthdayCalendar{else}shamsiAdultBirthdayCalendar{/if}" readonly="readonly">
                                        </div>

                                        <div class="s-u-passenger-item-hotel s-u-passenger-item-change justIranian">
                                            <input id="NationalCodeA{$countPassenger}" type="tel" placeholder="##Nationalnumber## " name="NationalCodeA{$countPassenger}" maxlength="10" class="UniqNationalCode">
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
                                <div class="clear"></div>


                            {/if}



                        {/for}

                    </div>


                {/for}

            {/foreach}

            <input type="hidden" name="TypeRoomHotel" id="TypeRoomHotel" value="{$objResult->TotalRoomId}">
            <input type="hidden" name="guestUserStatus" id="guestUserStatus" value="{$objResult->guestUserStatus}">

        {/if}

        <input type="hidden" name="TypeRoomHotel" id="TypeRoomHotel" value="">
    </div>



    <input type="hidden" id="bookingStage" name="bookingStage" value="finalRegistration">
    <input type="hidden" name="StatusRefresh" id="StatusRefresh" value="NoRefresh">
    <input type="hidden" id="typeApplication" name="typeApplication" value="reservation">
    <input type="hidden" name="hotelId" id="hotelId" value="{$hotelId}">
    <input type="hidden" name="factorNumber" id="factorNumber" value="{$smarty.post.factorNumber}">
    <input type="hidden" name="typeBed" id="typeBed" value="{$smarty.post.typeBed}">
    <input type="hidden" name="IdMember" id="IdMember" value="" >
    <input type="hidden" name="CurrencyCode" id="CurrencyCode" value="{$smarty.post.CurrencyCode}">
    <input type="hidden" name="CurrencyEquivalent" id="CurrencyEquivalent" value="{$smarty.post.CurrencyEquivalent}">

    {if $smarty.post.typeBed eq 'extraBed'}


        <input type="hidden" name="roomId" id="roomId" value="{$roomId}">
        <input type="hidden" name="roomCount" id="roomCount" value="{$roomCount}">
        <input type="hidden" name="extraBed" id="extraBed" value="{$smarty.post.extraBed}">
        <input type="hidden" name="extraChildBed" id="extraChildBed" value="{$smarty.post.extraChildBed}">

    {elseif $smarty.post.typeBed eq 'room'}

        <input type="hidden" id="RoomTypeCodes_Reserve" name="RoomTypeCodes_Reserve" value="{$roomTypeCodes}">
        <input type="hidden" id="NumberOfRooms_Reserve" name="NumberOfRooms_Reserve" value="{$numberOfRooms}">
        <input type="hidden" id="TotalPrice_Reserve" name="TotalPrice_Reserve" value="{$TotalPrice}">
        <input type="hidden" id="idCity_Reserve" name="idCity_Reserve" value="{$smarty.post.IdCity_Reserve}">
        <input type="hidden" id="StartDate_Reserve" name="StartDate_Reserve" value="{$smarty.post.startDate_reserve}">
        <input type="hidden" id="EndDate_Reserve" name="EndDate_Reserve" value="{$smarty.post.endDate_reserve}">
        <input type="hidden" id="Nights_Reserve" name="Nights_Reserve" value="{$smarty.post.nights_reserve}">

    {/if}

    <div style="position: relative;display: inline-block;float: left;">
        <a href="#" onclick="return false" class="f-loader-check loaderpassengers" id="loader_check" style="display:none"></a>
        <input type="button" onclick="checkHotelLocal('{$smarty.now}','{$countPassenger}')" value=" ##Nextstep##(##Invoice## )&nbsp; >>"
               id="send_data" class="s-u-submit-passenger s-u-select-flight-change s-u-submit-passenger-Buyer site-main-button-color">
    </div>


</form>








{literal}

<script src="assets/js/script.js"></script>
<script src="assets/js/jdate.min.js" type="text/javascript"></script>
<script src="assets/js/jdate.js" type="text/javascript"></script>
<script src="assets/js/jquery.counter.js" type="text/javascript"></script>


<script type="text/javascript">
    $(document).ready(function () {

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

    $(function () {
        $(document).tooltip();
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
<script type="text/javascript">
    $('.select2').select2();
    $('.select2-num').select2({minimumResultsForSearch: Infinity});

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