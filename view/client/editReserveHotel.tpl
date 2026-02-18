<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>
{load_presentation_object filename="resultHotelLocal" assign="objResult"}
{load_presentation_object filename="editHotelBooking" assign="objBook"}

{$objBook->getInfoHotel($smarty.get.id)}



{if $objBook->errorPages eq 'true'}
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 s-u-passenger-wrapper-change">
       <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">##Note##
           <i class="zmdi zmdi-alert-circle mart10  zmdi-hc-fw"></i>
       </span>
        <div class="s-u-result-wrapper">
            <span class="s-u-result-item-change direcR iranR txt12 txtRed">{$objBook->errorMessage}</span>
        </div>
    </div>
{else}


    <form  method="post" id="formEditHotel" class="edit-hotel" action="{$smarty.const.ROOT_ADDRESS}/hotel_ajax">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 s-u-passenger-wrapper-change">
            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">##Hotel## {$objBook->infoHotel['hotel_name']}<i class="ravis-icon-hotel mart10  zmdi-hc-fw"></i></span>

            <div class="hotel-booking-room marb0">

                <div class="col-md-3 nopad">
                    <div class="hotel-booking-room-image">
                        <a>
                            <img src="pic/{$objBook->infoHotel['hotel_pictures']}" alt="hotel-image">
                        </a>
                    </div>
                </div>

                <div class="col-md-9 ">
                    <div class="hotel-booking-room-content">
                        <div class="hotel-booking-room-text">

                            <b class="hotel-booking-room-name"> {$objBook->infoHotel['hotel_name']} </b>

                            <span class="hotel-star">
                           {for $s=1 to $objBook->infoHotel['hotel_starCode']}
                               <i class="fa fa-star" aria-hidden="true"></i>
                           {/for}
                                {for $ss=$s to 5}
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                {/for}
                        </span>

                            <span class="hotel-booking-room-content-location fa fa-map-marker ">
                             <a href="#"> {$objBook->infoHotel['hotel_address']} </a>
                        </span>
                            <p class="hotel-booking-roomm-description hotel-result-item-rule">
                                <span class="fa fa-bell-o"></span>
                                {$objBook->infoHotel['hotel_rules']}
                            </p>

                            <input type="hidden" id="nights" name="nights" value="{$objBook->infoHotel['number_night']}">
                            <div class="hotel-booking-room-text">
                                <ul>
                                    {*<li class="hotel-check-text">
                                        <i class="fa fa-calendar-times-o"></i> تاریخ ورود :
                                        <span class="hotel-check-date" dir="rtl">
                                            <input placeholder=" تاریخ رفت" id="startDate" name="startDate"
                                                   class="shamsiDeptCalendarToCalculateNights" value="{$objBook->infoHotel['start_date']}"
                                                   class="hasDatepicker" type="text">
                                        </span>
                                    </li>*}
                                    <li class="hotel-check-text padd0">
                                        <input placeholder=" ##Enterdate##" id="startDate" name="startDate"
                                               class="shamsiDeptCalendarToCalculateNights" value="{$objBook->infoHotel['start_date']}"
                                               class="hasDatepicker" type="text">
                                    </li>
                                    <li class="hotel-check-text padd0">
                                        <input placeholder="##Exitdate##" id="endDate" name="endDate"
                                               class="shamsiReturnCalendarToCalculateNights" value="{$objBook->infoHotel['end_date']}"
                                               class="hasDatepicker" type="text">
                                    </li>
                                    <li class="hotel-check-text"><i class="fa fa-bed"></i> <i id="stayingTimeForSearch">{$objBook->infoHotel['number_night']} ##Night##</i></li>
                                    <li class="hotel-check-text" style="padding: 0;">
                                        <button type="button" class="site-main-button-flat-color site-secondary-text-color" onclick="editDateReserve('{$smarty.get.id}')">##Changdate## </button>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="clear"></div>




        <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change edit-hotel-box first">
            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color edit-hotel-title">##Roominformationandpassengers##<i class="fa fa-male" aria-hidden="true"></i></span>

            {assign var="index" value="0"}
            {foreach $objBook->infoRoom as $roomId}

                {foreach $roomId as $roomCount}

                    {assign var="permissionAddExtraBeds" value=$objBook->permissionToAddExtraBeds($objBook->infoHotel['hotel_id'], $roomCount[$index]['room_id'], $roomCount[$index]['room_count'])}

                    <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first s-u-lest-room-person-name-change site-border-main-color edit-hotel-box-inner">
                        <div class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change s-u-lest-room-person-name-title-change site-bg-main-color">
                            {assign var="roomCurrency" value=$objFunctions->CurrencyCalculate($roomCount[$index]['room_price'], $objBook->CurrencyCode, $objBook->CurrencyEquivalent)}
                            {$roomCount[$index]['room_count']}) {$roomCount[$index]['room_name']} ({$objFunctions->numberFormat($roomCurrency.AmountCurrency)} {$roomCurrency.TypeCurrency})

                            {if $objBook->countRoomReserve gt '1'}
                            <div class="panel-Former-travelers-change panel-heading-room-change btn-delete-reserve" onclick="deleteRoom('{$roomCount[$index]['room_id']}', 'room', '{$smarty.get.id}', '{$roomCount[$index]['room_count']}')">
                                <span class="deleteReserve"><i class="fa fa-trash-o" aria-hidden="true"></i>##Deleteroom##</span>
                            </div>
                            {/if}
                        </div>



                        {foreach $roomCount as $item}
                            {$index = $index + 1}

                            <div class="panel-default-change pull-right panel-room-default-change box_every_passenger">
                                <div class="panel-heading-change">
                                    <div class="panel-head-hotel-box-right">
                                        <input id="roommate{$index}" name="roommate{$index}" value="{$item['roommate']}" type="hidden">
                                        <i class="room-kind-bed">{$item['title_flat_type']}</i> {$item['title_flat_age']}
                                        {if $item['flat_type'] neq 'DBL'}
                                            {assign var="roomCurrency" value=$objFunctions->CurrencyCalculate($item['room_price'], $objBook->CurrencyCode, $objBook->CurrencyEquivalent)}
                                            ({$objFunctions->numberFormat($roomCurrency.AmountCurrency)} {$roomCurrency.TypeCurrency})
                                        {/if}

                                        <div class="melliat-hotel-box">
                                            <span class="hidden-xs-down">##Nation##:</span>

                                            <span class="kindOfPasenger">
                                                    <label class="control--checkbox">
                                                        <span>##Iranian##</span>
                                                        <input type="radio" name="passengerNationality{$index}" id="passengerNationality{$index}" value="0" class="nationalityChange" checked="checked">
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
                                                    <input type="radio" name="passengerNationality{$index}" id="passengerNationality{$index}" value="1" class="nationalityChange">
                                                    <div class="checkbox">
                                                        <div class="filler"></div>
                                                        <svg width="20px" height="20px" viewBox="0 0 20 20">
                                                            <polyline points="4 11 8 15 16 6"></polyline>
                                                        </svg>
                                                    </div>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
									<div class="panel-head-hotel-box-left">

                                        {if $item['flat_type'] neq 'DBL'}
                                            <div class="panel-Former-travelers-change panel-heading-room-change s-u-last-passenger-btn" onclick="deleteRoom('{$item['id']}', 'extraBed', '{$smarty.get.id}', '{$roomCount[$index]['room_count']}')">
                                                <span class="deleteReserve"><i class="fa fa-trash-o" aria-hidden="true"></i> ##Removeextrabeds##</span>
                                            </div>
                                        {/if}
                                        {if $objSession->IsLogin()}
                                            <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change" onclick="setHidenFildnumberRow('{$index}')">
                                                <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i>##Passengerbook##
                                            </span>
                                        {/if}
                                    </div>
                                </div>



                                <div class="panel-body-change box_every_passenger">

                                    <div class="s-u-passenger-item-hotel  s-u-passenger-item-change">
                                        <select id="gender{$index}" name="gender{$index}">
                                            <option value="" disabled="" selected="selected">##Sex##</option>
                                            <option value="Male" {if $item['passenger_gender'] eq 'Male'}selected{/if}>##Sir##</option>
                                            <option value="Female" {if $item['passenger_gender'] eq 'Female'}selected{/if}>##Lady##</option>
                                        </select>
                                    </div>
                                    <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                        <input id="nameEn{$index}" placeholder="##Nameenglish##" name="nameEn{$index}"
                                               onkeypress="return isAlfabetKeyFields(event, 'nameEn{$index}')" class=""
                                               type="text" value="{$item['passenger_name_en']}">
                                    </div>
                                    <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                        <input id="familyEn{$index}" placeholder="##Familyenglish##" name="familyEn{$index}"
                                               onkeypress="return isAlfabetKeyFields(event, 'familyEn{$index}')" class=""
                                               type="text" value="{$item['passenger_family_en']}">
                                    </div>
                                    <div class="s-u-passenger-item-hotel s-u-passenger-item-change noneIranian">
                                        <input id="birthdayEn{$index}" type="text" placeholder="##miladihappybirthday##" name="birthdayEn{$index}"
                                               class="{if $item['flat_type'] eq 'ECHD'}gregorianUnder12BirthdayCalendar{else}gregorianAdultBirthdayCalendar{/if}"
                                               readonly="readonly" value="{$item['passenger_birthday_en']}">
                                    </div>

                                    <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                        <input id="nameFa{$index}" placeholder="##Namepersion##" name="nameFa{$index}"
                                               onkeypress=" return persianLetters(event, 'nameFa{$index}')" class="justpersian" type="text"
                                               value="{$item['passenger_name']}">
                                    </div>
                                    <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                        <input id="familyFa{$index}" placeholder="##Familypersion##" name="familyFa{$index}"
                                               onkeypress=" return persianLetters(event, 'familyFa{$index}')" class="justpersian" type="text"
                                               value="{$item['passenger_family']}">
                                    </div>
                                    <div class="s-u-passenger-item-hotel s-u-passenger-item-change justIranian">
                                        <input id="birthday{$index}" type="text" placeholder="##shamsihappybirthday##" name="birthday{$index}"
                                               class="{if $item['flat_type'] eq 'ECHD'}shamsiUnder12BirthdayCalendar{else}shamsiAdultBirthdayCalendar{/if}"
                                               readonly="readonly" value="{$item['passenger_birthday']}">
                                    </div>

                                    <div class="s-u-passenger-item-hotel s-u-passenger-item-change justIranian">
                                        <input id="NationalCode{$index}" placeholder="##Nationalnumber##" name="NationalCode{$index}"
                                               maxlength="10" class="UniqNationalCode" type="tel" value="{$item['passenger_national_code']}">
                                    </div>
                                    <div class="s-u-passenger-item-hotel s-u-passenger-item-change select-meliat noneIranian">
                                        <select name="passportCountry{$index}" id="passportCountry{$index}"
                                                class="select2">
                                            <option value="">##Countryissuingpassport##</option>
                                            {foreach $objFunctions->CountryCodes() as $Country}
                                                <option value="{$Country['code']}">{$Country['titleFa']}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="s-u-passenger-item-hotel s-u-passenger-item-change noneIranian">
                                        <input id="passportNumber{$index}" type="text" placeholder="##Numpassport##"
                                               name="passportNumber{$index}" class="UniqPassportNumber" value="{$item['passportNumber']}"
                                               onkeypress="return isAlfabetNumberKeyFields(event, 'passportNumber{$index}')">
                                    </div>
                                    <div class="s-u-passenger-item-hotel s-u-passenger-item-change noneIranian">
                                        <input id="passportExpire{$index}" class="gregorianFromTodayCalendar" type="text"
                                               placeholder="##Passportexpirydate##" name="passportExpire{$index}" value="{$item['passportExpire']}">
                                    </div>

                                    <div id="messageA1"></div>
                                </div>
                            </div>

                        {/foreach}

                        {if $permissionAddExtraBeds['extraBed'] eq 'True' || $permissionAddExtraBeds['extraChildBed'] eq 'True'}
                            <div class="panel-default-change pull-right panel-room-default-change box_every_passenger box-add-room-hotel">

                                <div class="">
                                    <div class="adult"> ##ExtrabedAdult##:</div>
                                    <select class=""
                                            name="extraBedSelect{$permissionAddExtraBeds['room_id']}{$permissionAddExtraBeds['room_count']}" id="extraBedSelect{$permissionAddExtraBeds['room_id']}{$permissionAddExtraBeds['room_count']}">
                                        <option selected="">تخت</option>
                                        {for $i=1 to $permissionAddExtraBeds['addNumberEXT']}
                                            <option value="{$i}">{$i}</option>
                                        {/for}
                                    </select>
                                </div>

                                <div class="">
                                    <div class="child"> ##Extrabedchild##:</div>
                                    <select class=""
                                            name="extraChildBedSelect{$permissionAddExtraBeds['room_id']}{$permissionAddExtraBeds['room_count']}" id="extraChildBedSelect{$permissionAddExtraBeds['room_id']}{$permissionAddExtraBeds['room_count']}">
                                        <option selected="">تخت</option>
                                        {for $i=1 to $permissionAddExtraBeds['addNumberECHD']}
                                            <option value="{$i}">{$i}</option>
                                        {/for}
                                    </select>
                                </div>

                                <div class="panel-Former-travelers-change panel-heading-room-change s-u-last-passenger-btn"
                                     onclick="addRoom('{$permissionAddExtraBeds['room_id']}', 'extraBed', '{$permissionAddExtraBeds['room_count']}')">
                                    <span class="addReserve"><i class="fa fa-plus" aria-hidden="true"></i>  ##Addexteraroom## </span>
                                </div>
                            </div>
                        {/if}



                        <div class="clear"></div>
                    </div>

                {/foreach}
            {/foreach}

            <input name="flag" id="flag" value="editPassengerHotel" type="hidden">
            <input name="factorNumber" id="factorNumber" value="{$smarty.get.id}" type="hidden">
            <input id="IdMember" name="IdMember" value="{$objBook->infoHotel['member_id']}" type="hidden">
            <div class="float_r_en" style="position: relative;display: inline-block;float: left;">
                <a href="#" class="f-loader-check loaderpassengers" id="loader_check" style="display:none"></a>
                <input type="submit" onclick="editPassengerHotel()" value="##Editnames##" id="send_data"
                       class="s-u-submit-passenger s-u-select-flight-change s-u-submit-passenger-Buyer site-main-button-color">
            </div>


            <!--one day tour-->
            {assign var="infoOneDayTour" value=$objResult->getInfoReserveOneDayTour($smarty.get.id)}
            {if $infoOneDayTour neq ''}
                <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first s-u-lest-room-person-name-change site-border-main-color edit-hotel-box-inner">

                    <div class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change s-u-lest-room-person-name-title-change site-bg-main-color">
                       ##Onetour##
                    </div>

                    {foreach  $infoOneDayTour  as $val}
                        <div class="panel-default-change pull-right panel-room-default-change box_every_passenger">

                            <div class="col-md-6">
                                <span class="span">##Title## : </span><span>{$val['title']}</span>
                            </div>
                            <div class="col-md-3">
                                {assign var="tourCurrency" value=$objFunctions->CurrencyCalculate($val['price'], $objBook->CurrencyCode, $objBook->CurrencyEquivalent)}
                                <span class="span">##Price## :</span><span>{$objFunctions->numberFormat($tourCurrency.AmountCurrency)} {$tourCurrency.TypeCurrency} </span>
                            </div>
                            <div class="col-md-3">
                                <div class="panel-Former-travelers-change panel-heading-room-change btn-delete-reserve"
                                     onclick="deleteOneDayTour('{$smarty.get.id}', '{$val['idBook']}', '{$val['price']}', '{$val['title']}', '{$objBook->infoHotel['total_price']}')">
                                    <span class="deleteReserve"><i class="fa fa-trash-o" aria-hidden="true"></i> ##Deletetour##</span>
                                </div>
                            </div>
                        </div>
                    {/foreach}
                    <div class="clear"></div>
                </div>
            {/if}

        </div>
        <div class="clear"></div>
    </form>


    <form  method="post" id="formAddRoom" action="{$smarty.const.ROOT_ADDRESS}/addRomReservationHotel">
        <input type="hidden" id="hotelId" name="hotelId" value="{$objBook->infoHotel['hotel_id']}">
        <input type="hidden" id="factorNumber" name="factorNumber" value="{$smarty.get.id}">
        <input type="hidden" id="roomId" name="roomId" value="">
        <input type="hidden" id="roomCount" name="roomCount" value="">
        <input type="hidden" id="extraBed" name="extraBed" value="">
        <input type="hidden" id="extraChildBed" name="extraChildBed" value="">
        <input type="hidden" id="typeBed" name="typeBed" value="">
        <input type="hidden" id="CurrencyCode" name="CurrencyCode" value="{$objBook->CurrencyCode}">
        <input type="hidden" id="CurrencyEquivalent" name="CurrencyEquivalent" value="{$objBook->CurrencyEquivalent}">
    </form>



    <!-- login and register popup -->
    {assign var="useType" value="hotel"}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentLoginRegister.tpl"}
    <!-- login and register popup -->


    {$objResult->getHotelRoom($objBook->infoHotel['hotel_id'])}
    {$objResult->getHotelRoomPrices($objBook->infoHotel['hotel_id'], $objBook->infoHotel['start_date'], $objBook->infoHotel['end_date'])}
    {$objResult->getInfoRoom($objBook->infoHotel['hotel_id'])}

    {assign var="idHotel" value=$objBook->infoHotel['hotel_id']}
    {assign var="idCity" value=$objBook->infoHotel['city_id']}
    {assign var="search_start_date" value=$objBook->infoHotel['start_date']}
    {assign var="search_end_date" value=$objBook->infoHotel['end_date']}
    {assign var="number_night" value=$objBook->infoHotel['number_night']}
    {assign var="typeApplication" value="reservation"}

    <div class="accordion"><h2 class="accordion-title site-bg-main-color-a">##Reservationroom## </h2></div>
    <div class="panel">
        <form action="" method="post" id="formHotelReserve">
            <input id="factorNumber" name="factorNumber" type="hidden" value="{$smarty.get.id}">
            <input id="href" name="href" type="hidden" value="addRomReservationHotel">
            <input id="typeBed" name="typeBed" type="hidden" value="room">
            <input id="totalPrice" name="totalPrice" type="hidden" value="{$objBook->infoHotel['total_price']}">
            <input type="hidden" id="CurrencyCode" name="CurrencyCode" value="{$objBook->CurrencyCode}">
            <input type="hidden" id="CurrencyEquivalent" name="CurrencyEquivalent" value="{$objBook->CurrencyEquivalent}">

            {assign var="CurrencyCode" value=$objBook->CurrencyCode}
            {assign var="CurrencyEquivalent" value=$objBook->CurrencyEquivalent}
            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`reservationHotelRoomPrice.tpl"}
        </form>
    </div>


    {$objResult->getReservationHotel($objBook->infoHotel['hotel_id'])}
    <!--transfer-->
    {if ($objResult->transfer_went neq 'no' || $objResult->transfer_back neq 'no') || $objBook->infoTransfer['origin'] neq ''}
        <form  method="post" id="formTransferHotel" action="{$smarty.const.ROOT_ADDRESS}/hotel_ajax">

            <div class="accordion active"><h2 class="accordion-title site-bg-main-color-a">##Freetransferfromhotel##</h2></div>
            <div class="panel">

                <div class="color_border_Mosafer">

                    <div class="S_DivInputForm s-u-passenger-item-change">
                        <input name="origin" id="origin" placeholder="##Origin##" type="text" value="{$objBook->infoTransfer['origin']}">
                    </div>
                    <div class="S_DivInputForm s-u-passenger-item-change">
                        <input name="destination" id="destination" placeholder="##Destination## : ایران - تهران" readonly="" type="text">
                    </div>
                    <div class="S_DivInputForm s-u-passenger-item-change"> &nbsp; </div>
                    <div class="S_DivInputForm s-u-passenger-item-change"> &nbsp; </div>
                    <br>

                    {if ($objResult->transfer_went neq 'no') || $objBook->infoTransfer['flight_date_went'] neq ''}
                        <div class="S_DivInputForm s-u-passenger-item-change">
                            <input name="flight_date_went" id="flight_date_went" class="datePersian"
                                   placeholder="##Datemovewent## --/--/----" type="text" value="{$objBook->infoTransfer['flight_date_went']}">
                        </div>
                        <div class="S_DivInputForm s-u-passenger-item-change">
                            <input name="airline_went" id="airline_went"
                                   placeholder="##namevehicle## (##Train## - ##Airplane##)" type="text" value="{$objBook->infoTransfer['airline_went']}">
                        </div>
                        <div class="S_DivInputForm s-u-passenger-item-change">
                            <input name="flight_number_went" id="flight_number_went"
                                   placeholder="##Vehiclenumber##" type="text" value="{$objBook->infoTransfer['flight_number_went']}">
                        </div>
                        <div class="S_DivInputForm S_DivInputForm_H3 s-u-passenger-item-change">
                    <span class="Nopadding">
                        <select name="hour_went" id="hour_went" class="InputMin InputMiddel">
                            {if $objBook->infoTransfer['hour_went'] neq ''}
                                <option value="{$objBook->infoTransfer['hour_went']}">{$objBook->infoTransfer['hour_went']}</option>
                            {else}
                                <option value="">##Hour##</option>
                            {/if}
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
                            {if $objBook->infoTransfer['minutes_went'] neq ''}
                                <option value="{$objBook->infoTransfer['minutes_went']}">{$objBook->infoTransfer['minutes_went']}</option>
                            {else}
                                <option value="">##Minutes##</option>
                            {/if}
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


                    {if ($objResult->transfer_went neq 'no') || $objBook->infoTransfer['flight_date_back'] neq ''}
                        <div class="S_DivInputForm s-u-passenger-item-change">
                            <input name="flight_date_back" id="flight_date_back" class="datePersian"
                                   placeholder="##Datemovereturn## --/--/----" type="text" value="{$objBook->infoTransfer['flight_date_back']}">
                        </div>
                        <div class="S_DivInputForm s-u-passenger-item-change">
                            <input name="airline_back" id="airline_back"
                                   placeholder="##namevehicle## (##Train## - ##Airplane##)" type="text" value="{$objBook->infoTransfer['airline_back']}">
                        </div>
                        <div class="S_DivInputForm s-u-passenger-item-change">
                            <input name="flight_number_back" id="flight_number_back"
                                   placeholder="##Vehiclenumber##" type="text" value="{$objBook->infoTransfer['flight_number_back']}">
                        </div>
                        <div class="S_DivInputForm S_DivInputForm_H3 s-u-passenger-item-change">
                    <span class="Nopadding">
                        <select name="hour_back" id="hour_back" class="InputMin InputMiddel">
                            {if $objBook->infoTransfer['hour_back'] neq ''}
                                <option value="{$objBook->infoTransfer['hour_back']}">{$objBook->infoTransfer['hour_back']}</option>
                            {else}
                                <option value="">##Hour##</option>
                            {/if}
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
                            {if $objBook->infoTransfer['minutes_back'] neq ''}
                                <option value="{$objBook->infoTransfer['minutes_back']}">{$objBook->infoTransfer['minutes_back']}</option>
                            {else}
                                <option value="">##Minutes##</option>
                            {/if}
                            {for $i=0 to 9}
                                <option value="0{$i}">0{$i}</option>
                            {/for}
                            {for $i=10 to 66}
                                <option value="{$i}">{$i}</option>
                            {/for}
                        </select>
                    </span>
                        </div>
                    {/if}

                </div>
                <div class="clear"></div>


                <input name="flag" id="flag" value="editTransferHotel" type="hidden">
                <input name="factorNumber" id="factorNumber" value="{$smarty.get.id}" type="hidden">
                <input id="type" name="type" value="" type="hidden">

                <div class="color_border_Mosafer">
                    <div class="float_r_en" style="position: relative;display: inline-block;float: left;">
                        <a href="#" class="f-loader-check loaderpassengers" id="loader_check" style="display:none"></a>
                        <input onclick="editTransferHotel('edit')" value="##Edittransfer##" id="send_data" type="submit"
                               class="s-u-submit-passenger s-u-select-flight-change s-u-submit-passenger-Buyer site-main-button-color">
                    </div>

                    <div class="float_r_en" style="position: relative;display: inline-block;float: left;">
                        <a href="#" class="f-loader-check loaderpassengers" id="loader_check" style="display:none"></a>
                        <input onclick="editTransferHotel('delete')" value="##Deletetransfer##" id="send_data" type="submit"
                               class="s-u-submit-passenger s-u-select-flight-change s-u-submit-passenger-Buyer site-main-button-color">
                    </div>
                </div>
                <div class="clear"></div>

            </div>
        </form>
    {/if}






    <!--one day tour-->
    {$objResult->oneDayTour($objBook->infoHotel['hotel_id'], $objBook->infoHotel['city_id'])}
    {if $objResult->showOneDayTour eq 'True'}
        <form  method="post" id="formOneDayTour" action="{$smarty.const.ROOT_ADDRESS}/addRomReservationHotel">

            <div class="accordion"><h2 class="accordion-title site-bg-main-color-a">##Onedayspatrolrequest##</h2></div>
            <div class="panel">

                {assign var="count" value="0"}
                {foreach $objResult->listOneDayTour as $key=>$tour}
                    {$count = $count + 1}

                    <div class="box-oneTour">
                        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change s-u-lest-room-person-name-title-change site-bg-main-color">{$tour['title']}</span>

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
                                            {assign var="adtPriceCurrency" value=$objFunctions->CurrencyCalculate($tour['adt_price_rial'], $objBook->CurrencyCode, $objBook->CurrencyEquivalent)}
                                            <span>{$objFunctions->numberFormat($adtPriceCurrency.AmountCurrency)} {$adtPriceCurrency.TypeCurrency}</span>
                                            <input type="hidden" value="{$tour['adt_price_rial']}" name="adtPriceR{$count}" id="adtPriceR{$count}">
                                        </div>

                                        <div class="s-u-passenger-item s-u-passenger-item-room-change ">
                                            <select id="adtNumR{$count}" name="adtNumR{$count}">
                                                <option value="" disabled="" selected="selected">##Countrequest## </option>
                                                {for $i=0 to 9}
                                                    <option value="{$i}">{$i}</option>
                                                {/for}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="one_tour_box_row one_tour_box_room_row_change">
                                        <div class="one_tour_cost">
                                            {assign var="chdPriceCurrency" value=$objFunctions->CurrencyCalculate($tour['chd_price_rial'], $objBook->CurrencyCode, $objBook->CurrencyEquivalent)}
                                            <span>{$objFunctions->numberFormat($chdPriceCurrency.AmountCurrency)} {$chdPriceCurrency.TypeCurrency}</span>
                                            <input type="hidden" value="{$tour['chd_price_rial']}" name="chdPriceR{$count}" id=chdPriceR{$count}">
                                        </div>
                                        <div class="s-u-passenger-item  s-u-passenger-item-room-change ">
                                            <select id="chdNumR{$count}" name="chdNumR{$count}">
                                                <option value="" disabled="" selected="selected">##Countrequest##</option>
                                                {for $i=0 to 9}
                                                    <option value="{$i}">{$i}</option>
                                                {/for}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="one_tour_box_row one_tour_box_room_row_change">
                                        <div class="one_tour_cost">
                                            {assign var="infPriceCurrency" value=$objFunctions->CurrencyCalculate($tour['inf_price_rial'], $objBook->CurrencyCode, $objBook->CurrencyEquivalent)}
                                            <span >{$objFunctions->numberFormat($infPriceCurrency.AmountCurrency)} {$infPriceCurrency.TypeCurrency}</span>
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


                <input type="hidden" id="hotelId" name="hotelId" value="{$objBook->infoHotel['hotel_id']}">
                <input type="hidden" id="factorNumber" name="factorNumber" value="{$smarty.get.id}">
                <input type="hidden" id="totalPrice" name="totalPrice" value="{$objBook->infoHotel['total_price']}">
                <input name="flag" id="flag" value="addOneDayTour" type="hidden">
                <input type="hidden" id="CurrencyCode" name="CurrencyCode" value="{$objBook->CurrencyCode}">
                <input type="hidden" id="CurrencyEquivalent" name="CurrencyEquivalent" value="{$objBook->CurrencyEquivalent}">

                <div class="color_border_Mosafer">
                    <div class="float_r_en" style="position: relative;display: inline-block;float: left;">
                        <a href="#" class="f-loader-check loaderpassengers" id="loader_check" style="display:none"></a>
                        <input onclick="addOneDayTour()" value="##Setonedaygasht##" id="send_data" type="submit"
                               class="s-u-submit-passenger s-u-select-flight-change s-u-submit-passenger-Buyer site-main-button-color">
                    </div>
                </div>
                <div class="clear"></div>

            </div>
        </form>
    {/if}

		<div class="hotel-last-section">
            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first s-u-lest-room-person-name-change site-border-main-color">
                <div class="panel-heading-change panel-heading-room-change">
                    {assign var="totalPriceCurrency" value=$objFunctions->CurrencyCalculate($objBook->infoHotel['total_price'], $objBook->CurrencyCode, $objBook->CurrencyEquivalent)}
                    <i class="room-kind-bed">##Totalallpaymentamount##: </i> {$objFunctions->numberFormat($totalPriceCurrency.AmountCurrency)} {$totalPriceCurrency.TypeCurrency}
                </div>
			</div>



    <div class="float_r_en" style="position: relative;display: inline-block;float: left;">
        <a href="#" onclick="return false" class="f-loader-check loaderpassengers" id="loader_check" style="display:none"></a>
        <input onclick="PreFactorReservationHotel('{$smarty.get.id}', '{$objBook->CurrencyCode}', '{$objBook->CurrencyEquivalent}')" value="##Nextstep##(##Invoice##)&nbsp; >>" id="send_data"
               class="s-u-submit-passenger s-u-select-flight-change s-u-submit-passenger-Buyer site-main-button-color" type="button">
    </div>
    </div>





{/if}




{literal}
    <script type="text/javascript" src="assets/js/modal-login.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/jdate.min.js" type="text/javascript"></script>
    <script src="assets/js/jdate.js" type="text/javascript"></script>
    <script src="assets/js/jquery.counter.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
        });
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

        $( "body" ).delegate( ".DetailPrice", "click", function() {
            $(this).parent().parent().next(".RoomDescription").toggleClass("trShowHideHotelDetail");
            $(this).parent().parent().next(".RoomDescription").find(".DetailPriceView").toggleClass("displayiN");
            $(this).children(".DetailPrice .fa").toggleClass("fa-caret-down fa-caret-up");
        });
    </script>
{/literal}