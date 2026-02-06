<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>


{assign var="hotelId" value=$smarty.post.hotelId}
{assign var="roomId" value=$smarty.post.roomId}
{assign var="startDate" value=$smarty.post.startDate}
{assign var="endDate" value=$smarty.post.endDate}
{assign var="nights" value=$smarty.post.nights}
{assign var="searchRooms" value=$smarty.post.searchRooms}
{assign var="loginIdApi" value=$smarty.post.loginIdApi}
{assign var="searchIdApi" value=$smarty.post.searchIdApi}
{assign var="typeApplication" value=$smarty.post.typeApplication}
{assign var="factorNumber" value=$smarty.post.factorNumber}
{assign var="currencyCode" value=$smarty.post.CurrencyCode}


{load_presentation_object filename="resultExternalHotel" assign="objExternalHotel"}
{assign var="reserveInfo" value=$objExternalHotel->getPreInvoice($factorNumber)}

{load_presentation_object filename="passengersDetailLocal" assign="objDetail"}
{$objDetail->getCustomers()}   {*گرفتن اطلاعات مربوط به مسافران هر مشتری*}



{if $objExternalHotel->error eq 'true'}
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 s-u-passenger-wrapper-change">
        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
           ##Note## <i class="zmdi zmdi-alert-circle mart10  zmdi-hc-fw"></i>
        </span>
        <div class="s-u-result-wrapper">
            <span class="s-u-result-item-change direcR iranR txt12 txtRed">{$objExternalHotel->errorMessage}</span>
        </div>
    </div>
{else}
    <div>
        <div class="counter d-none counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"
             style="direction: ltr">10:00</div>
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

                        {assign var="city" value=$objExternalHotel->getCity($reserveInfo['city_name'])}
                        {assign var="priceChange" value=$objFunctions->getHotelPriceChange($city['core_id'], $reserveInfo['hotel_stars'], $objExternalHotel->counterId, $reserveInfo['start_date'], 'externalApi')}

                        {assign var="amount" value=$reserveInfo['full_amount']}
                        {if $priceChange neq false && $reserveInfo['full_amount'] neq 0}
                            {if $priceChange['change_type'] eq 'increase' && $priceChange['price_type'] eq 'cost'}
                                {assign var="amount" value=$amount + $priceChange['price']}
                            {elseif $priceChange['change_type'] eq 'decrease' && $priceChange['price_type'] eq 'cost'}
                                {assign var="amount" value=$amount - $priceChange['price']}
                            {elseif $priceChange['change_type'] eq 'increase' && $priceChange['price_type'] eq 'percent'}
                                {assign var="amount" value=($amount * $priceChange['price'] / 100) + $amount}
                            {elseif $priceChange['change_type'] eq 'decrease' && $priceChange['price_type'] eq 'percent'}
                                {assign var="amount" value=($amount * $priceChange['price'] / 100) - $amount}
                            {/if}
                        {/if}

                        {if $objExternalHotel->serviceDiscount['externalApi'] neq '' && $objExternalHotel->serviceDiscount['externalApi']['off_percent'] gt 0}
                            {$amount = $amount - (($amount * $objExternalHotel->serviceDiscount['externalApi']['off_percent']) / 100)}
                        {/if}

                        {$amountCurrency = $objFunctions->CurrencyCalculate($amount, $currencyCode)}

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



    <form method="post" id="formPassengerDetailHotelLocal" action="{$smarty.const.ROOT_ADDRESS}/factorExternalHotel">

        <input type="hidden" id="numberRow" value="0">
        <input type="hidden" name="ZoneFlight" id="ZoneFlight" value="Portal">


        <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">
            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">##Informationpassenger##<i
                        class="fa fa-male" aria-hidden="true"></i></span>


            {assign var="i" value=0}
            {foreach from=$objExternalHotel->numberOfRooms['rooms'] key=key item=room}

                {assign var="RC" value=$key+1}
                <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first s-u-lest-room-person-name-change site-border-main-color">

                    <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change s-u-lest-room-person-name-title-change site-bg-main-color">##Room## {$RC}</span>


                    {for $AC=1 to $room['AdultCount']}
                        {$i = $i + 1}
                        <div class="panel-default-change pull-right panel-room-default-change box_every_passenger">

                            <div class="panel-heading-change">
                                <i class="room-kind-bed"> ##Adultagegroup## (+11) </i>
                                <span class="kindOfPasenger">
                                    <label class="control--checkbox">
                                        <span>##Iranian##</span>
                                        <input type="radio" name="passengerNationalityA{$i}"
                                               id="passengerNationalityA{$i}"
                                               value="0" class="nationalityChange" checked="checked">
                                        <div class="checkbox site-bg-main-color site-border-main-color">
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
                                        <input type="radio" name="passengerNationalityA{$i}"
                                               id="passengerNationalityA{$i}"
                                               value="1" class="nationalityChange">
                                        <div class="checkbox site-bg-main-color site-border-main-color">
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


                            <div class="panel-body-change box_every_passenger">

                                <input type="hidden" id="roommate{$i}" name="roommate{$i}" value="{$RC}">
                                <input type="hidden" id="passengerAge{$i}" name="passengerAge{$i}" value="Adt">

                                <div class="s-u-passenger-item-hotel  s-u-passenger-item-change">
                                    <select id="genderA{$i}" name="genderA{$i}">
                                        <option value="" disabled="" selected="selected">##Sex##</option>
                                        <option value="Male">##Sir##</option>
                                        <option value="Female">##Lady##</option>
                                    </select>
                                </div>

                                <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                    <input id="nameEnA{$i}" type="text" placeholder="##Nameenglish##" name="nameEnA{$i}"
                                           onkeypress="return isAlfabetKeyFields(event, 'nameEnA{$i}')">
                                </div>
                                <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                    <input id="familyEnA{$i}" type="text" placeholder="##Familyenglish##"
                                           name="familyEnA{$i}"
                                           onkeypress="return isAlfabetKeyFields(event, 'familyEnA{$i}')">
                                </div>
                                <div class="s-u-passenger-item-hotel s-u-passenger-item-change noneIranian">
                                    <input id="birthdayEnA{$i}" type="text" placeholder="##miladihappybirthday##"
                                           name="birthdayEnA{$i}" class="gregorianAdultBirthdayCalendar"
                                           readonly="readonly">
                                </div>

                                <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                    <input id="nameFaA{$i}" type="text" placeholder="##Namepersion##"
                                           name="nameFaA{$i}"
                                           onkeypress=" return persianLetters(event, 'nameFaA{$i}')"
                                           class="justpersian">
                                </div>
                                <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                    <input id="familyFaA{$i}" type="text" placeholder="##Familypersion##"
                                           name="familyFaA{$i}"
                                           onkeypress=" return persianLetters(event, 'familyFaA{$i}')"
                                           class="justpersian">
                                </div>
                                <div class="s-u-passenger-item-hotel s-u-passenger-item-change justIranian">
                                    <input id="birthdayA{$i}" type="text" placeholder="##shamsihappybirthday##"
                                           name="birthdayA{$i}"
                                           class="shamsiAdultBirthdayCalendar" readonly="readonly">
                                </div>

                                <div class="s-u-passenger-item-hotel s-u-passenger-item-change justIranian">
                                    <input id="NationalCodeA{$i}" type="tel" placeholder="##Nationalnumber##"
                                           name="NationalCodeA{$i}"
                                           maxlength="10" class="UniqNationalCode">
                                </div>

                                <div class="s-u-passenger-item-hotel s-u-passenger-item-change select-meliat noneIranian">
                                    <select name="passportCountryA{$i}" id="passportCountryA{$i}"
                                            class="select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                        <option value="">##Countryissuingpassport##</option>
                                        {foreach $objFunctions->CountryCodes() as $Country}
                                            <option value="{$Country['code']}">{$Country['titleFa']}</option>
                                        {/foreach}
                                    </select>
                                </div>
                                <div class="s-u-passenger-item-hotel s-u-passenger-item-change noneIranian">
                                    <input id="passportNumberA{$i}" type="text" placeholder="##Numpassport##"
                                           name="passportNumberA{$i}" class="UniqPassportNumber"
                                           onkeypress="return isAlfabetNumberKeyFields(event, 'passportNumberA{$i}')">
                                </div>
                                <div class="s-u-passenger-item-hotel s-u-passenger-item-change noneIranian">
                                    <input id="passportExpireA{$i}" class="gregorianFromTodayCalendar"
                                           type="text" placeholder="##Passportexpirydate##" name="passportExpireA{$i}">
                                </div>

                                <div id="messageA{$i}"></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    {/for}


                    {for $CC=1 to $room['ChildrenCount']}
                        {$i = $i + 1}
                        <div class="panel-default-change pull-right panel-room-default-change box_every_passenger">

                            <div class="panel-heading-change">

                                <i class="room-kind-bed"> ##Thechildsagegroup## </i>

                                <span class="kindOfPasenger">
                                    <label class="control--checkbox">
                                        <span>##Iranian##</span>
                                        <input type="radio" name="passengerNationalityA{$i}"
                                               id="passengerNationalityA{$i}"
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
                                        <input type="radio" name="passengerNationalityA{$i}"
                                               id="passengerNationalityA{$i}"
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


                            <div class="panel-body-change box_every_passenger">

                                <input type="hidden" id="roommate{$i}" name="roommate{$i}" value="{$RC}">
                                <input type="hidden" id="passengerAge{$i}" name="passengerAge{$i}" value="Chd">
                                <input type="hidden" id="ageA{$i}" name="ageA{$i}" value="{$room['ChildrenAge'][$CC-1]}">

                                <div class="s-u-passenger-item-hotel  s-u-passenger-item-change">
                                    <select id="genderA{$i}" name="genderA{$i}">
                                        <option value="" disabled="" selected="selected">##Sex##</option>
                                        <option value="Male">##Sir##</option>
                                        <option value="Female">##Lady##</option>
                                    </select>
                                </div>

                                <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                    <input id="nameEnA{$i}" type="text" placeholder="##Nameenglish##" name="nameEnA{$i}"
                                           onkeypress="return isAlfabetKeyFields(event, 'nameEnA{$i}')">
                                </div>
                                <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                    <input id="familyEnA{$i}" type="text" placeholder="##Familyenglish##"
                                           name="familyEnA{$i}"
                                           onkeypress="return isAlfabetKeyFields(event, 'familyEnA{$i}')">
                                </div>
                                <div class="s-u-passenger-item-hotel s-u-passenger-item-change noneIranian">
                                    <input id="birthdayEnA{$i}" type="text" placeholder="##miladihappybirthday##"
                                           name="birthdayEnA{$i}" readonly="readonly"
                                           value="{$room['ChildrenAge'][$CC-1]} سال " disabled>
                                </div>

                                <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                    <input id="nameFaA{$i}" type="text" placeholder="##Namepersion##"
                                           name="nameFaA{$i}"
                                           onkeypress=" return persianLetters(event, 'nameFaA{$i}')"
                                           class="justpersian">
                                </div>
                                <div class="s-u-passenger-item-hotel s-u-passenger-item-change">
                                    <input id="familyFaA{$i}" type="text" placeholder="##shamsihappybirthday##)"
                                           name="familyFaA{$i}"
                                           onkeypress=" return persianLetters(event, 'familyFaA{$i}')"
                                           class="justpersian">
                                </div>
                                <div class="s-u-passenger-item-hotel s-u-passenger-item-change justIranian">
                                    <input id="birthdayA{$i}" type="text" placeholder="##shamsihappybirthday##"
                                           name="birthdayA{$i}" value="{$room['ChildrenAge'][$CC-1]} سال "
                                           readonly="readonly" disabled>
                                </div>

                                <div class="s-u-passenger-item-hotel s-u-passenger-item-change justIranian">
                                    <input id="NationalCodeA{$i}" type="tel" placeholder="##Nationalnumber##"
                                           name="NationalCodeA{$i}"
                                           maxlength="10" class="UniqNationalCode">
                                </div>

                                <div class="s-u-passenger-item-hotel s-u-passenger-item-change select-meliat noneIranian">
                                    <select name="passportCountryA{$i}" id="passportCountryA{$i}"
                                            class="select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                        <option value="">##Countryissuingpassport##</option>
                                        {foreach $objFunctions->CountryCodes() as $Country}
                                            <option value="{$Country['code']}">{$Country['titleFa']}</option>
                                        {/foreach}
                                    </select>
                                </div>
                                <div class="s-u-passenger-item-hotel s-u-passenger-item-change noneIranian">
                                    <input id="passportNumberA{$i}" type="text" placeholder="##Passportexpirydate##"
                                           name="passportNumberA{$i}" class="UniqPassportNumber"
                                           onkeypress="return isAlfabetNumberKeyFields(event, 'passportNumberA{$i}')">
                                </div>
                                <div class="s-u-passenger-item-hotel s-u-passenger-item-change noneIranian">
                                    <input id="passportExpireA{$i}" class="gregorianFromTodayCalendar"
                                           type="text" placeholder="##Passportexpirydate##" name="passportExpireA{$i}">
                                </div>

                                <div id="messageA{$i}"></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    {/for}


                </div>
            {/foreach}

        </div>
        <div class="clear"></div>


        {*<div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">
            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">##Headgroupinformation##<i
                        class="fa fa-male" aria-hidden="true"></i></span>
            <div class="clear"></div>
            <div class="panel-default-change-Buyer site-bg-main-color">

                <div class="s-u-passenger-items s-u-passenger-item-change">
                    <input id="email" type="email" placeholder="##Email##" name="email" class="dir-ltr">
                </div>

                <div class="s-u-passenger-items s-u-passenger-item-change">
                    <input id="cellphoneNumber" type="text" placeholder="##Phonenumber## " name="cellphoneNumber"
                           class="dir-ltr">
                </div>

                <div class="s-u-passenger-items s-u-passenger-item-change">
                    <input id="phoneNumber" type="text" placeholder="##Phonenumber## " name="phoneNumber"
                           class="dir-ltr">
                </div>

                <div class="s-u-passenger-items s-u-passenger-item-change width100">
                    <textarea id="address" type="text" placeholder="##Address##" name="address"
                              class="dir-ltr"></textarea>
                </div>

                <div id="messagePassengerLeader"></div>
            </div>
            <div class="clear"></div>*}

        </div>
        <div class="clear"></div>


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


        <input type="hidden" name="typeApplication" id="typeApplication" value="{$typeApplication}">
        <input type="hidden" name="factorNumber" id="factorNumber" value="{$factorNumber}">
        <input type="hidden" id="time_remmaining" value="" name="time_remmaining">
        <input type="hidden" id="CurrencyCode" name="CurrencyCode" value="{$currencyCode}">
        <input type="hidden" value="" name="idMember" id="idMember">

        <div style="position: relative;display: inline-block;float: left;">
            <a href="" onclick="return false"
               class="f-loader-check loaderpassengers" id="loader_check" style="display:none"></a>
            <input type="button" onclick="checkHotelLocal('{$smarty.now}','{$i}')"
                   value="##Nextstep##(##Invoice##)&nbsp; >>"
                   class="s-u-submit-passenger s-u-select-flight-change s-u-submit-passenger-Buyer site-main-button-color"
                   id="send_data">
        </div>


    </form>
{/if}





{literal}

    <script src="assets/js/script.js"></script>
    <script src="assets/js/jdate.min.js" type="text/javascript"></script>
    <script src="assets/js/jdate.js" type="text/javascript"></script>
    <script src="assets/js/jquery.counter.js" type="text/javascript"></script>

<script type="text/javascript">
    /*$('.counter').counter({});
    $('.counter').on('counterStop', function () {
         $.alert({
             title: '##Reservationhotel##',
             icon: 'fa fa-times',
             content: "##Yourhotelreservationdeadlinehasexpiredpleaserestart##",
             rtl: true,
             type: 'red'
         });
         //location.href = '{/literal}{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}{literal}';
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

        $(function () {
            $(document).tooltip();
        });


        $(document).ready(function () {
            let table = $('#passengers').DataTable();

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
    <script>
        let acc = document.getElementsByClassName("accordion");
        let i;
        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function () {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        }
    </script>
{/literal}