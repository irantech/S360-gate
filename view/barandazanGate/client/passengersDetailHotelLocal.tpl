<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>
{load_presentation_object filename="resultHotelLocal" assign="objResult"}
{$objResult->getInfoHotelRoom($smarty.post.idHotel_reserve)}
{$objResult->getPassengersDetailHotel($smarty.post.factorNumber, $smarty.post.startDate_reserve, $smarty.post.nights_reserve, $smarty.post.TotalNumberRoom_Reserve)}    {**گرفتن اطلاعات مربوط به هتل **}

{load_presentation_object filename="passengersDetailLocal" assign="objDetail"}
{$objDetail->getCustomers()}   {*گرفتن اطلاعات مربوط به مسافران هر مشتری*}
{*<div>*}
{*<div class="counter d-none counter-analog" data-direction="down" data-format="59:59.9" data-stop="00:00:00.0" data-interval="100" style="direction: ltr"> {$objDetail->SetTimeLimitHotel($smarty.post.TotalNumberRoom)}:0</div>*}
{*</div>*}
<div>
    <div class="counter d-none counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"
         style="direction: ltr"> {$objDetail->SetTimeLimitHotel($smarty.post.TotalNumberRoom)}</div>
</div>
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

<form method="post" id="formHotel" action="">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 s-u-passenger-wrapper-change">
     <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
         ##Youbookingfollowinghotel## <i class="ravis-icon-hotel mart10  zmdi-hc-fw"></i>
     </span>

        {$c= 1}

        {assign var="RoomPrice1night" value=""}
        {assign var="RoomPrice" value=""}
        {assign var="TotalPrice" value=""}

        {foreach  $objResult->temproryHotel  as $i=>$Hotel}

        {if $i eq 0}

        {*$objResult->getAgencyCommission($Hotel['city_id'],$Hotel['hotel_starCode'],$Hotel['start_date'],$Hotel['number_night'])*}

        <div class="hotel-booking-room marb0">

            <div class="col-md-3 nopad">
                <div class="hotel-booking-room-image">
                    <a>
                        <img src="{$Hotel['hotel_pictures']}" alt="hotel-image">
                    </a>
                </div>
            </div>

            <div class="col-md-9 ">
                <div class="hotel-booking-room-content">
                    <div class="hotel-booking-room-text">
                        <b class="hotel-booking-room-name"> {$Hotel['hotel_name']} </b>

                        <span class="hotel-star">
                            {for $s=1 to $Hotel['hotel_starCode']}
                                <i class="fa fa-star" aria-hidden="true"></i>
                            {/for}
                            {for $ss=$s to 5}
                                <i class="fa fa-star-o" aria-hidden="true"></i>
                            {/for}
                        </span>

                        <span class="hotel-booking-room-content-location fa fa-map-marker ">
                 <a href="#"> {$Hotel['hotel_address']} </a>
               </span>
                        <p class="hotel-booking-roomm-description hotel-result-item-rule">
                            <span class="fa fa-bell-o"></span>
                            {$Hotel['rules']}
                        </p>
                    </div>

                    <div class="hotel-booking-room-text">
                        <ul>
                            <li class="hotel-check-text"><i class="fa fa-calendar-times-o"></i> ##Enterdate## :
                                <span class="hotel-check-date" dir="rtl">{$Hotel['start_date']}</span></li>
                            <li class="hotel-check-text"><i class="fa fa-calendar-check-o"></i> ##Exitdate## :
                                <span class="hotel-check-date" dir="rtl">{$Hotel['end_date']}</span></li>
                            <li class="hotel-check-text"><i class="fa fa-bed"></i> {$Hotel['number_night']}
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
                <div class="table-responsive">
                <div class="table_hotel_nz">
                    <div class="thead_hotel">
                    <div class="tr_hotel">
                        <div class="th_hotel">##Informationbed##</div>
                        <div class="th_hotel hidden-xs">##CapacityRoom##</div>
                        <div class="th_hotel hidden-xs">##Countroom##</div>
                        <div class="th_hotel hidden-xs">##Serviceroom##</div>
                        <div class="th_hotel ">##Priceforanynight##</div>
                        <div class="th_hotel">##TotalPrice##</div>
                    </div>
                    </div>

                    <div class="tbody_hotel">

                    {/if}



                    {if $c eq 1 }
                        {assign var="roomTypeCodes" value="{$Hotel['room_id']}"}
                        {assign var="numberOfRooms" value="{$Hotel['room_count']}"}
                        {$c= 2}
                    {else}
                        {assign var="roomTypeCodes" value="{$roomTypeCodes},{$Hotel['room_id']}"}
                        {assign var="numberOfRooms" value="{$numberOfRooms},{$Hotel['room_count']}"}
                    {/if}

                    {$TotalPrice = $TotalPrice + $Hotel['room_price_current']}

                    <div class="tr_hotel">
                        <div class="th_hotel ">
                            <h5 class="roomsTitle">{$Hotel['room_name']}</h5>
                            <div class="hidden-md-up roomCapacity">
                                <i class="fa fa-user txt15"></i> <i class="inIcon">x</i><i class="txtIcon ng-binding">{$Hotel['max_capacity_count_room']}</i>
                                <h5 class="" style="display: inline-block; width: 100%; font-size: 12px;">تعداد اتاق <i class="txtIcon ng-binding">{$Hotel['room_count']}</i></h5>
                                <input type="hidden" name="RoomCount{$Hotel['room_id']}" id="RoomCount{$Hotel['room_id']}"
                                       value="{$Hotel['room_count']}">
                            </div>
                        </div>

                        <div class="th_hotel hidden-xs">
                            <div class="roomCapacity">
                                <i class="fa fa-user txt15"></i> <i class="inIcon">x</i><i class="txtIcon ng-binding">{$Hotel['max_capacity_count_room']}</i>
                            </div>
                        </div>

                        <div class="th_hotel hidden-xs">
                            <h5 class="roomCapacity"><i class="txtIcon ng-binding">{$Hotel['room_count']}</i></h5>
                            <input type="hidden" name="RoomCount{$Hotel['room_id']}" id="RoomCount{$Hotel['room_id']}"
                                   value="{$Hotel['room_count']}">
                        </div>

                        <div class="th_hotel hidden-xs">
                            <ul class="HotelRoomFeatureList">
                                <li class="Breakfast"><i class="fa fa-coffee"></i> ##Breakfast##</li>
                            </ul>
                        </div>
                        <div class="th_hotel ">
                            {assign var="everyNightCurrency" value=$objFunctions->CurrencyCalculate($Hotel['price'], $smarty.post.CurrencyCode)}
                            <span class="pricePerNight"><span
                                        class="currency">{$objFunctions->numberFormat($everyNightCurrency.AmountCurrency)}</span> {$everyNightCurrency.TypeCurrency}</span>
                        </div>
                        <div class="th_hotel">
                            {assign var="totalRoomCurrency" value=$objFunctions->CurrencyCalculate($Hotel['room_price_current'], $smarty.post.CurrencyCode)}
                            <div class="roomFinalPrice ">{$objFunctions->numberFormat($totalRoomCurrency.AmountCurrency)} {$totalRoomCurrency.TypeCurrency}</div>
                        </div>
                    </div>
                    {/foreach}
                    </div>
                </div>

                </div>
            </div>
            <div class="DivTotalPrice ">
                {assign var="totalPriceCurrency" value=$objFunctions->CurrencyCalculate($TotalPrice, $smarty.post.CurrencyCode)}
                <div class="fltl">##Amountpayable## :
                    <span>{$objFunctions->numberFormat($totalPriceCurrency.AmountCurrency)}</span> {$totalPriceCurrency.TypeCurrency}
                </div>
            </div>
        </div>

    </div>
</form>


<div class="clear"></div>


<form method="post" id="formPassengerDetailHotelLocal" action="{$smarty.const.ROOT_ADDRESS}/factorHotelLocal">

    <input type="hidden" id="numberRow" value="0">
    <input type="hidden" name="ZoneFlight" id="ZoneFlight" value="Local">

    {assign var="i" value=0}
    {foreach $objResult->SearchHotelRoom as $room}

        {$NumberRoom = $objResult->CounterRoomReserve($room.Code)*1}

        {if $NumberRoom ge 1 }

            {for $number=1 to $NumberRoom}
                {$i=$i+1}
                <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">

		           <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color direcR">
		              {$room.Name} <span class="countRoom">(##Room## {$number})</span>
                       <!-- <i class="soap-icon-family"></i> -->
		           </span>

                    <input type="hidden" name="RoomCount_Reserve{$room.Code}" id="RoomCount_Reserve{$room.Code}"
                           value="{$number}">
                    <input type="hidden" name="Id_Select_Room{$i}" id="Id_Select_Room{$i}" value="{$room.Code}">

                    <div class="panel-default-change pull-right site-border-main-color">
                        <div class="panel-heading-change">

                            <span class="hidden-xs-down">##Nation##:</span>

                            <span class="kindOfPasenger">
                                <label class="control--checkbox">
                                    <span>##Iranian##</span>
                                    <input type="radio" name="passengerNationalityA{$i}" id="passengerNationalityA{$i}"
                                           value="0" class="nationalityChange" checked="checked">
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
                                    <span>##Noiranian##</span>
                                    <input type="radio" name="passengerNationalityA{$i}" id="passengerNationalityA{$i}"
                                           value="1" class="nationalityChange">
                                    <div class="checkbox">
                                        <div class="filler"></div>
                                        <svg width="20px" height="20px" viewBox="0 0 20 20">
                                            <polyline points="4 11 8 15 16 6"></polyline>
                                        </svg>
                                    </div>
                                </label>
                            </span>

                            {if $objSession->IsLogin()}
                                <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change"
                                      onclick="setHidenFildnumberRow('A{$i}')">
                                     <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i> ##Passengerbook##
                                 </span>
                            {/if}
                        </div>

                        <div class="clear"></div>

                        <div class="panel-body-change">

                            <div class="s-u-passenger-item  s-u-passenger-item-change ">
                                <select id="genderA{$i}" name="genderA{$i}">
                                    <option value="" disabled="" selected="selected">##Sex##</option>
                                    <option value="Male">##Sir##</option>
                                    <option value="Female">##Lady##</option>
                                </select>
                            </div>

                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                <input id="nameEnA{$i}" type="text" placeholder="##Nameenglish##" name="nameEnA{$i}"
                                       onkeypress="return isAlfabetKeyFields(event, 'nameEnA{$i}')" class="">
                            </div>
                            <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                <input id="familyEnA{$i}" type="text" placeholder="##Familyenglish##"
                                       name="familyEnA{$i}"
                                       onkeypress="return isAlfabetKeyFields(event, 'familyEnA{$i}')" class="">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <input id="birthdayEnA{$i}" type="text" placeholder="##miladihappybirthday##"
                                       name="birthdayEnA{$i}" class="gregorianAdultBirthdayCalendar"
                                       readonly="readonly">
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <input id="nameFaA{$i}" type="text" placeholder="##Namepersion##" name="nameFaA{$i}"
                                       onkeypress=" return persianLetters(event, 'nameFaA{$i}')" class="justpersian">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <input id="familyFaA{$i}" type="text" placeholder="##Familypersion##"
                                       name="familyFaA{$i}" onkeypress=" return persianLetters(event, 'familyFaA{$i}')"
                                       class="justpersian">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input id="birthdayA{$i}" type="text" placeholder="##shamsihappybirthday##"
                                       name="birthdayA{$i}" class="shamsiAdultBirthdayCalendar" readonly="readonly">
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input id="NationalCodeA{$i}" type="tel" placeholder="##Nationalnumber##"
                                       name="NationalCodeA{$i}" maxlength="10" class="UniqNationalCode">
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <select name="passportCountryA{$i}" id="passportCountryA{$i}" class="select2">
                                    <option value="">##Countryissuingpassport##</option>
                                    {foreach $objFunctions->CountryCodes() as $Country}
                                        <option value="{$Country['code']}">{$Country['titleFa']}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <input id="passportNumberA{$i}" type="text" placeholder="##Numpassport##"
                                       name="passportNumberA{$i}" class="UniqPassportNumber">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <input id="passportExpireA{$i}" class="gregorianFromTodayCalendar" type="text"
                                       placeholder="##Passportexpirydate##" name="passportExpireA{$i}">
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <div class="dropdownRoom">
                                    <div class="dropbtnSelectRoom" id="dropbtnSelectRoom{$i}">##Chooseflatlayout##</div>
                                    <div class="dropdown-content-room txt12" id="showDropdown{$i}">
                                        <a onclick="SelectTypeRoom('Double','{$i}')"><i
                                                    class="ravis-icon-double-bed site-main-text-color"></i>
                                            ##Twobeduser## </a>
                                        <a onclick="SelectTypeRoom('Twin','{$i}')"><i
                                                    class="ravis-icon-hotel-single-bed site-main-text-color"></i><i
                                                    class="ravis-icon-hotel-single-bed site-main-text-color "></i>
                                            ##Onebeduser## </a>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="BedType{$i}" name="BedType{$i}">


                            {if $room.Name|strpos:"ساعته"}
                                <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                    <select name="timeEnteringRoom{$i}" id="timeEnteringRoom{$i}" class="select2">
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

                            <div id="messageA{$i}"></div>
                        </div>
                    </div>

                    <div class="clear"></div>

                </div>
            {/for}
        {/if}

    {/foreach}

    <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer   first ">
          <span class="s-u-last-p-pasenger s-u-last-p-pasenger-change passenger_leader site-main-text-color">
              ##Headgroupinformation## <i class="zmdi zmdi-account-box-phone zmdi-hc-fw"></i>
          </span>
        <div class="clear"></div>
        <div class="panel-default-change-Buyer site-bg-main-color">

            <div class="s-u-passenger-items s-u-passenger-item-change">
                <input id="passenger_leader_room_fullName" type="text" placeholder="##Namefamily##"
                       name="passenger_leader_room_fullName" class="dir-ltr">
            </div>

            <div class="s-u-passenger-items s-u-passenger-item-change">
                <input id="passenger_leader_room" type="text" placeholder="##Phonenumber##" name="passenger_leader_room"
                       class="dir-ltr">
            </div>

            <div id="messagePassengerLeader"></div>
        </div>
        <div class="clear"></div>
    </div>


    {if not $objSession->IsLogin()}
        <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer  first">
          <span class="s-u-last-p-pasenger s-u-last-p-pasenger-change site-bg-main-color">
              ##InformationSaler## <i class="zmdi zmdi-account-box-phone zmdi-hc-fw"></i>
          </span>
            <input type="hidden" name="UsageNotLogin" value="yes" id="UsageNotLogin">
            <div class="clear"></div>
            <div class="panel-default-change-Buyer site-bg-main-color">
                <div class="s-u-passenger-items s-u-passenger-item-change">
                    <input id="Mobile" type="text" placeholder="##Phonenumber## " name="Mobile" class="dir-ltr">
                </div>
                <div class="s-u-passenger-items s-u-passenger-item-change">
                    <input id="Telephone" type="text" placeholder="##Phone##" name="Telephone" class="dir-ltr">
                </div>
                <div class="s-u-passenger-items s-u-passenger-item-change padl0">
                    <input id="Email" type="email" placeholder="##Email##" name="Email" class="dir-ltr">
                </div>
                <div id="messageInfo"></div>
            </div>
            <div class="clear"></div>
        </div>
    {/if}


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
    <input type="hidden" id="typeApplication" name="typeApplication" value="api">
    <input type="hidden" id="CurrencyCode" name="CurrencyCode" value="{$smarty.post.CurrencyCode}">
    <input type="hidden" value="" name="idMember" id="idMember">


    <div class="next_hotel__" style="position: relative;display: inline-block;float: left;">
        <a href="" onclick="return false" class="f-loader-check loaderpassengers"
           id="loader_check" style="display:none"></a>
        <input type="button" onclick="checkHotelLocal('{$smarty.now}','{$i}')" value="##NextStepInvoice##&nbsp; >>"
               class="s-u-submit-passenger s-u-select-flight-change s-u-submit-passenger-Buyer site-main-button-color"
               id="send_data">
    </div>


</form>


{literal}

    <script src="assets/js/script.js"></script>
    <script src="assets/js/jdate.min.js" type="text/javascript"></script>
    <script src="assets/js/jdate.js" type="text/javascript"></script>
    <script src="assets/js/jquery.counter.js" type="text/javascript"></script>
<script type="text/javascript">
    /*$('.counter').counter({});
    $('.counter').on('counterStop', function () {
        alert('##Yourhotelreservationdeadlinehasexpiredpleaserestart##');
        location.href = '{/literal}{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}{literal}';
    });*/
</script>

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