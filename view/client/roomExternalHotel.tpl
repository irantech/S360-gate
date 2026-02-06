{load_presentation_object filename="resultHotelLocal" assign="objResultHotelLocal"}
{load_presentation_object filename="resultExternalHotel" assign="objExternalHotel"}
{load_presentation_object filename="reservationTour" assign="objTour"}

{assign var="typeApplication" value=$smarty.const.TYPE_APPLICATION}
{assign var="hotelId" value=$smarty.const.HOTEL_ID}
{assign var="hotelNameEn" value=$smarty.const.HOTEL_NAME_EN}
{assign var="nights" value=$smarty.const.NIGHTS}
{assign var="searchRooms" value=$smarty.const.SEARCH_ROOMS}
{assign var="loginIdApi" value=$smarty.const.LOGIN_ID_API}
{assign var="searchIdApi" value=$smarty.const.SEARCH_ID_API}
{if $smarty.const.START_DATE neq ''}
    {assign var="startDate" value=$smarty.const.START_DATE}
    {assign var="endDate" value=$smarty.const.END_DATE}
{else}
    {assign var="startDate" value=$objResultHotelLocal->getStartDateToday()}
    {assign var="endDate" value=$objResultHotelLocal->getEndDateToday()}
{/if}
{assign var="currencyCode" value=$smarty.const.CURRENCY_CODEE}

{assign var="hotel" value=$objExternalHotel->getHotelDetail($hotelId, $searchIdApi, $loginIdApi)}
{assign var="numberOfRooms" value=$objFunctions->numberOfRoomsExternalHotelSearch($searchRooms)}


<!-- login and register popup -->
{assign var="useType" value="externalHotel"}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentLoginRegister.tpl"}
<!-- login and register popup -->

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


    <div class="container">
        <div class="row">

            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 nopad">

                <div class="filterBox">
                    <div class="filtertip_hotel site-bg-main-color site-bg-color-border-bottom ">
                        <p class="txt14">##Hotelcontactinformation##</p>
                    </div>

                    <div class="filtertip-searchbox filtertip-searchbox-box1">
                        <div class="box-external-hotel-detail">

                            <div class="external-hotel-address">
                                <span> ##Address## </span>
                                <span>{$hotel.HotelAddress}</span>
                            </div>

                            {if $hotel.PhoneNumber neq ''}
                                <div class="external-hotel-tell">
                                    <span>##Phonenumber## </span><span>{$hotel.PhoneNumber}</span>
                                </div>
                            {/if}

                            {if $hotel.HotelEmail neq ''}
                                <div class="external-hotel-email">
                                    <span>##Email##</span>
                                    <span>{$hotel.HotelEmail}</span>
                                </div>
                            {/if}

                            <div class="rp-hotel-box">
                                <div id="mapDiv" class="gmap3"></div>
                            </div>

                        </div>
                    </div>
                </div>


                {assign var="city" value=$objExternalHotel->getCity($objExternalHotel->convertStringForUrl($hotel['CountryName']), $objExternalHotel->convertStringForUrl($hotel['CityName']))}
                <div class="filterBox {*filtertip-searchbox*}">

                    <div class="filtertip_hotel site-bg-main-color site-bg-color-border-bottom ">
                        <p class="txt14">##Repeatsearch##</p>
                    </div>

                    <div class="filtertip-searchbox filtertip-searchbox-box1">
                        <form class="search-wrapper" action="" method="post">

                            <input type="hidden" name="rooms" id="rooms" value="{$searchRooms}">

                            <div class="inputSearchForeign-box inputSearchForeign-pad">
                                <div class="s-u-in-out-wrapper raft raft-change change-bor">
                                    <input id="destination_country" name="destination_country" type="hidden"
                                           value="{$objExternalHotel->convertStringForUrl($city['country_name_en'])}">
                                    <input id="destination_city" name="destination_city" type="hidden"
                                           value="{$objExternalHotel->convertStringForUrl($city['city_name_en'])}">
                                    <input id="autoComplateSearchIN" name="autoComplateSearchIN"
                                           class="inputSearchForeign" type="text"
                                           value="{$city['city_name_fa']}"
                                           onkeyup="searchCity()">
                                    <img src="assets/images/load.gif" id="LoaderForeignDep" name="LoaderForeignDep"
                                         class="loaderSearch">
                                    <ul id="listSearchCity" class="ul-inputSearch-externalHotel displayNone"></ul>
                                </div>
                            </div>

                            {assign var="classNameStartDate" value="shamsiDeptCalendarToCalculateNights"}
                            {assign var="classNameEndDate" value="shamsiReturnCalendarToCalculateNights"}
                            {if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || $startDate|substr:0:4 gt 2000}
                                {$classNameStartDate="deptCalendarToCalculateNights"}
                            {/if}

                            {if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || $endDate|substr:0:4 gt 2000}
                                {$classNameEndDate="returnCalendarToCalculateNights"}
                            {/if}

                            <div class="form-hotel-item  form-hotel-item-searchBox-date padl5">
                                <span class="fa-stack fa-lg calendar-icon site-main-text-color">
                                    <i class="fa fa-calendar fa-stack-1x"></i>
                                </span>
                                <div class="input">
                                    <input type="text" placeholder="  ##Wentdate##" id="startDate" name="startDate"
                                           value="{$startDate}"
                                           class="{$classNameStartDate}">
                                </div>
                            </div>

                            <div class="form-hotel-item form-hotel-item-searchBox-date padr5">
                                <span class="fa-stack fa-lg calendar-icon site-main-text-color">
                                    <i class="fa fa-calendar fa-stack-1x"></i>
                                </span>
                                <div class="input">
                                    <input type="text" placeholder="  ##Returndate##" id="endDate" name="endDate"
                                           value="{$endDate}"
                                           class="{$classNameEndDate}">
                                </div>
                            </div>

                            <div class="form-hotel-item   form-hotel-item-searchBox-date padr1">
                                <div class="form-hotel-item-boder">
                                    <span class="fa-stack fa-lg calendar-icon ">
                                        <i class="fa fa-bed fa-stack-1x site-main-text-color"></i>
                                    </span>
                                    <span class="lh33 stayingTime">{$nights} ##Night## </span>
                                    <input type="hidden" id="stayingTime" name="stayingTime" value="{$nights}"/>
                                </div>
                            </div>

                            <div class="form-hotel-item  form-hotel-item-searchBox-date padr5 mart8">
                                <div class="select">
                                    <select name="countRoom" id="countRoom" class="select2">
                                        <option value="1" {if $numberOfRooms['countRoom'] eq '1'} selected {/if}>1 ##Room##</option>
                                        <option value="2" {if $numberOfRooms['countRoom'] eq '2'} selected {/if}>2 ##Room##</option>
                                        <option value="3" {if $numberOfRooms['countRoom'] eq '3'} selected {/if}>3 ##Room##</option>
                                        <option value="4" {if $numberOfRooms['countRoom'] eq '4'} selected {/if}>4 ##Room##</option>
                                    </select>
                                </div>
                            </div>


                            <div id="box-foreign-hotel-room">
                                <div class="clrB site-main-text-color-drck box-foreign-hotel-room-item">
                                    <div class="myroom-hotel">
                                        {foreach from=$numberOfRooms['rooms'] key=key item=room}
                                            {assign var="count" value=$key+1}
                                            <div class="myroom-hotel-item" data-roomNumber="{$count}">
                                                <div class="myroom-hotel-item-title site-main-text-color">##Room##  {$objTour->textNumber($count)}<span class="close"></span></div>
                                                <div class="myroom-hotel-item-info">
                                                    <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
                                                        <span>##Adultnumber##<i>(12 ##yearsandup##)</i></span>
                                                        <div>
                                                            <i class="addParentEHotel fas fa-plus  site-main-text-color site-bg-color-dock-border"></i>
                                                            <input type="number" name="adult{$count}" id="adult{$count}" readonly=""
                                                                   class="countParentEHotel" min="0" value="{$room['AdultCount']}" max="5">
                                                            <i class="minusParentEHotel fas fa-minus  site-main-text-color site-bg-color-dock-border"></i>
                                                        </div>
                                                    </div>
                                                    <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
                                                        <span>##Numberofchildren##<i>(##Under## 12 ##Year##)</i></span>
                                                        <div>
                                                            <i class="addChildEHotel fas fa-plus  site-main-text-color site-bg-color-dock-border"></i>
                                                            <input type="number" readonly="" name="child{$count}" id="child{$count}"
                                                                   class="countChildEHotel" min="0" value="{$room['ChildrenCount']}" max="5">
                                                            <i class="minusChildEHotel fas fa-minus  site-main-text-color site-bg-color-dock-border"></i>
                                                        </div>
                                                    </div>
                                                    <div class="tarikh-tavalods">
                                                        {if $room['ChildrenCount'] neq '0'}
                                                            {for $i=1 to $room['ChildrenCount']}
                                                                <div class="tarikh-tavalod-item"><span>##Childage## <i>{$objTour->textNumber($i)}</i></span>
                                                                    <select id="childAge{$count}{$i}" name="childAge{$count}{$i}">
                                                                        <option value="1"
                                                                                {if {$room['ChildrenAge'][$i-1]} eq '1'}selected{/if}>
                                                                            0 ##To## 1 ##Year##
                                                                        </option>
                                                                        <option value="2"
                                                                                {if {$room['ChildrenAge'][$i-1]} eq '2'}selected{/if}>
                                                                            1 ##To## 2 ##Year##
                                                                        </option>
                                                                        <option value="3"
                                                                                {if {$room['ChildrenAge'][$i-1]} eq '3'}selected{/if}>
                                                                            2 ##To## 3 ##Year##
                                                                        </option>
                                                                        <option value="4"
                                                                                {if {$room['ChildrenAge'][$i-1]} eq '4'}selected{/if}>
                                                                            3 ##To## 4 ##Year##
                                                                        </option>
                                                                        <option value="5"
                                                                                {if {$room['ChildrenAge'][$i-1]} eq '5'}selected{/if}>
                                                                            4 ##To## 5 ##Year##
                                                                        </option>
                                                                        <option value="6"
                                                                                {if {$room['ChildrenAge'][$i-1]} eq '6'}selected{/if}>
                                                                            5 ##To## 6 ##Year##
                                                                        </option>
                                                                        <option value="7"
                                                                                {if {$room['ChildrenAge'][$i-1]} eq '7'}selected{/if}>
                                                                            6 ##To## 7 ##Year##
                                                                        </option>
                                                                        <option value="8"
                                                                                {if {$room['ChildrenAge'][$i-1]} eq '8'}selected{/if}>
                                                                            7 ##To## 8 ##Year##
                                                                        </option>
                                                                        <option value="9"
                                                                                {if {$room['ChildrenAge'][$i-1]} eq '9'}selected{/if}>
                                                                            8 ##To## 9 ##Year##
                                                                        </option>
                                                                        <option value="10"
                                                                                {if {$room['ChildrenAge'][$i-1]} eq '10'}selected{/if}>
                                                                            9 ##To## 10 ##Year##
                                                                        </option>
                                                                        <option value="11"
                                                                                {if {$room['ChildrenAge'][$i-1]} eq '11'}selected{/if}>
                                                                            10 ##To## 11 ##Year##
                                                                        </option>
                                                                        <option value="12"
                                                                                {if {$room['ChildrenAge'][$i-1]} eq '12'}selected{/if}>
                                                                            11 ##To## 12 ##Year##
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            {/for}
                                                        {/if}
                                                    </div>
                                                </div>
                                            </div>
                                        {/foreach}
                                    </div>
                                </div>
                            </div>

                            <div class="form-hotel-item  form-hotel-item-searchBox-btn">
                                <span></span>
                                <div class="input">
                                    <button class="site-main-button-color site-secondary-text-color"
                                            type="button" id="searchHotelLocal" onclick="submitSearchExternalHotel()">
                                        ##Search##
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
            <!-- LIST CONTENT-->
            <div class="col-lg-8 col-md-12  col-sm-12 col-xs-12 padl0 pad990">


                <div class="external-hotel-name">
                    <div class="hotel-rate-outer">
                        <div class="hotel-rate">
                            <div class="rp-cel-hotel-star">
                                {if $hotel.HotelStars gt 0}
                                    {for $s=1 to $hotel.HotelStars}
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
                            </div>
                            <div class="hotel-rate-text">##Hotel## {$hotel.HotelStars} ##Star##</div>
                        </div>
                    </div>
                    <div class="hotel-name">
                        <h1>{$hotel.HotelPersianName}</h1>
                    </div>
                </div>



                <div class="hotel-khareji-thumb">
                    <div class="hotel-thumb-carousel owl-carousel">
                        {foreach $hotel.ImagesList as $k => $image}
                            <div class="hotel-thumb-item">
                                <a data-fancybox="gallery " href="{$image.ImageURL}">
                                    <img src="{$image.ImageURL}" alt="{$image.Title}">
                                </a>
                            </div>
                        {/foreach}
                    </div>
                </div>


                <div class="filter-type-of-food">
                    <div class="filter-type-of-food-items">
                        <span class="filter-type-of-food-item"> ##Typeoffood##:</span>

                        <span class="filter-type-of-food-item">
                            <input type="checkbox" class="FilterHoteltype ShowAllFoodType" id="foodTypeAll" name="foodType" value="all" checked>
                            <label class="FilterHoteltypeName site-main-text-color-a" for="foodTypeAll">##All##</label>
                        </span>

                        <span class="filter-type-of-food-item">
                            <input type="checkbox" class="FilterHoteltype ShowByFiltersFreeBreakfast"
                                   id="foodTypeBreeBreakfast" name="foodTypeBreeBreakfast" value="yes">
                            <label class="FilterHoteltypeName site-main-text-color-a"
                                   for="foodTypeBreeBreakfast">##Withbreakfast##</label>
                        </span>

                        <span class="filter-type-of-food-item">
                            <input type="checkbox" class="FilterHoteltype ShowByFiltersFreeBreakfast"
                                   id="foodTypeRoomOnly" name="foodTypeRoomOnly" value="no">
                            <label class="FilterHoteltypeName site-main-text-color-a"
                                   for="foodTypeRoomOnly">##Onlyroom##</label>
                        </span>

                    </div>
                </div>




                <!-- detail room -->
                <form action="" method="post" id="formExternalHotelReserve">

                    <input id="hotelId" name="hotelId" type="hidden" value="{$hotelId}">
                    <input name="roomId" id="roomId" type="hidden" value="">
                    <input id="loginIdApi" name="loginIdApi" type="hidden" value="{$loginIdApi}">
                    <input id="searchIdApi" name="searchIdApi" type="hidden" value="{$searchIdApi}">
                    <input id="startDate" name="startDate" type="hidden" value="{$startDate}">
                    <input id="endDate" name="endDate" type="hidden" value="{$endDate}">
                    <input id="nights" name="nights" type="hidden" value="{$nights}">
                    <input id="searchRooms" name="searchRooms" type="hidden" value="{$searchRooms}">
                    <input name="typeApplication" id="typeApplication" type="hidden"
                           value="{$typeApplication}">
                    <input name="href" id="href" type="hidden"
                           value="passengersDetailExternalHotel">
                    <input name="factorNumber" id="factorNumber" type="hidden" value="">
                    <input name="CurrencyCode" id="CurrencyCode" type="hidden"
                           value="{$currencyCode}">


                    <div class="hotel-detail-room-list">

                        {assign var="city" value=$objExternalHotel->getCity($hotel.CityName)}
                        {assign var="priceChange" value=$objFunctions->getHotelPriceChange($city['place_id'], $hotel.HotelStars, $objExternalHotel->counterId, $startDate, 'externalApi')}

                        {foreach $hotel.RoomsDetail as $room}


                            {assign var="amount" value=$room['FullAmount']}
                            {if $priceChange neq false && $room['FullAmount'] neq 0}
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
                                {$priceWithoutDiscount = $amount}
                                {$priceWithoutDiscountCurrency = $objFunctions->CurrencyCalculate($priceWithoutDiscount, $currencyCode)}
                                {$amount = $amount - (($amount * $objExternalHotel->serviceDiscount['externalApi']['off_percent']) / 100)}
                            {/if}

                            {$amountCurrency = $objFunctions->CurrencyCalculate($amount, $currencyCode)}
                            {assign var="price1night" value=$amountCurrency['AmountCurrency']/$nights}

                            {assign var="freeBreakfastRooms" value=""}

                            <div class="hotel-rooms-item">
                                <div class="hotel-rooms-row">
                                    <div class="hotel-rooms-content-col">
                                        {foreach $room['RoomList'] as $k => $item}
                                            {assign var="numberRomm" value=$objTour->textNumber($k+1)}

                                            {if $item['FreeBreakfast'] eq true}
                                                {$freeBreakfastRooms = "{$freeBreakfastRooms}{'|yes'}"}
                                            {else}
                                                {$freeBreakfastRooms = "{$freeBreakfastRooms}{'|no'}"}
                                            {/if}

                                            <div class="hotel-rooms-content">
                                                <div class="hotel-rooms-name-container">
                                                    <span class="hotel-room-number-label site-bg-main-color site-bg-color-border-bottom ">##Room## {$numberRomm}</span>
                                                    <span class="hotel-rooms-name">{$item['RoomName']}</span>
                                                </div>

                                                {if $numberOfRooms['countRoom'] eq 1}
                                                    <div class="divided-list">
                                                        <div class="divided-list-item">
                                                            <span><i class="fa fa-bed"></i>{$objExternalHotel->getFacilityRoomPersian($item['BreakfastType'])} {*if $item['FreeBreakfast'] eq true}(صبحانه رایگان){/if*} </span>
                                                        </div>
                                                        <div class="divided-list-item">
                                                            {if $k eq 0}
                                                                <span><i class="fa fa-money"></i>##Priceforonenights##: {$objFunctions->numberFormat($price1night)} {$amountCurrency['TypeCurrency']}</span>
                                                            {else}
                                                                <span><i class="fa fa-money"></i>##Priceaccordingtopackage##</span>
                                                            {/if}
                                                        </div>
                                                    </div>

                                                    <div class="divided-list">
                                                        <div class="divided-list-item">
                                                            <span><i class="fa fa-male"></i>{$objExternalHotel->rooms[$k]['AdultCount']} ##Adult##</span>
                                                            {if $objExternalHotel->rooms[$k]['ChildrenCount'] gt 0}
                                                                <span><i class="fa fa-child"></i>{$objExternalHotel->rooms[$k]['ChildrenCount']} ##Child##</span>
                                                            {/if}
                                                        </div>
                                                        <div class="divided-list-item">
                                                            <div class="DetailRoom showCancelRule"
                                                                 id="btnCancelRule-{$room['ReservePackageID']}"
                                                                 data-RoomIndex="{$room['ReservePackageID']}">
                                                                <i class="fa fa-angle-down"></i>
                                                                <span> ##Cancellationrules## </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                {else}
                                                    <div class="divided-list">
                                                        <div class="divided-list-item">
                                                            <span><i class="fa fa-bed"></i>{$objExternalHotel->getFacilityRoomPersian($item['BreakfastType'])}</span>
                                                        </div>
                                                        <div class="divided-list-item">
                                                            <span><i class="fa fa-male"></i>{$objExternalHotel->rooms[$k]['AdultCount']} ##Adult##</span>
                                                            {if $objExternalHotel->rooms[$k]['ChildrenCount'] gt 0}
                                                                <span><i class="fa fa-child"></i>{$objExternalHotel->rooms[$k]['ChildrenCount']} ##Child##</span>
                                                            {/if}
                                                        </div>
                                                        <div class="divided-list-item">
                                                            {if $k eq 0}
                                                                <span><i class="fa fa-money"></i>##Priceforonenights##: {$objFunctions->numberFormat($price1night)} {$amountCurrency['TypeCurrency']}</span>
                                                            {else}
                                                                <span><i class="fa fa-money"></i>##Priceaccordingtopackage##</span>
                                                            {/if}
                                                        </div>
                                                    </div>
                                                {/if}

                                            </div>
                                        {/foreach}
                                        <input type="hidden" name="inputFreeBreakfastRooms" id="inputFreeBreakfastRooms" value="{$freeBreakfastRooms}">
                                    </div>


                                    <div class="hotel-rooms-price-col">
                                        <div class="hotel-rooms-price-items">

                                            <div>##Pricefor## {$nights} ##Night##</div>
                                            <div>
                                                {if $objExternalHotel->serviceDiscount['externalApi'] neq '' && $objExternalHotel->serviceDiscount['externalApi']['off_percent'] gt 0}
                                                    <strike>{$objFunctions->numberFormat($priceWithoutDiscountCurrency['AmountCurrency'])}</strike>
                                                {/if}
                                                <div class="final-price"><i class="site-main-text-color">{$objFunctions->numberFormat($amountCurrency['AmountCurrency'])}</i> {$amountCurrency['TypeCurrency']} </div>
                                            </div>
                                        </div>
                                        <div class="multi-rooms-price-btn-container">
                                            <button id="btnReserve-{$room['ReservePackageID']}"
                                                    type="button"
                                                    class="site-secondary-text-color site-bg-main-color site-main-button-color-hover"
                                                    onclick="reserveExternalHotel('{$room['ReservePackageID']}')">
                                                ##Reservation##
                                            </button>
                                            <img class="imgLoad" src="assets/images/load2.gif"
                                                 id="img-{$room['ReservePackageID']}">
                                        </div>
                                    </div>
                                </div>
                                {if $numberOfRooms['countRoom'] gt 1}
                                <div class="hotel-rooms-rule-row">
                                    <div class="col-xs-12 col-md-12 box-cancel-rule-btn">
                                        <div class="DetailRoom showCancelRule"
                                             id="btnCancelRule-{$room['ReservePackageID']}"
                                             data-RoomIndex="{$room['ReservePackageID']}">
                                            <i class="fa fa-angle-down"></i>
                                            <span> ##Cancellationrules## </span>
                                        </div>
                                    </div>
                                </div>
                                {/if}
                                <div class="hotel-rooms-rule-row">
                                    <div class="col-xs-12 col-md-12 box-cancel-rule">
                                        <img class="imgLoad" src="assets/images/load.gif"
                                             id="loaderCancel-{$room['ReservePackageID']}">
                                        <div class="box-cancel-rule-col" id="boxCancelRule-{$room['ReservePackageID']}"></div>
                                    </div>
                                </div>
                            </div>

                        {/foreach}

                    </div>
                </form>
                <!-- end detail room -->


                <div class="hotel-panel">

                    <div class="hotel-desc">
                        <div class="hotel-fea-title">##Descriptionhotel##</div>
                        <p>
                            {$hotel.BreifingDescription}
                            {foreach $hotel.DescriptionList as $item}
                                {$item.Description}
                            {/foreach}
                        </p>


                        <div class="hotel-fea">
                            <div class="hotel-fea-title">##PossibilitiesHotel##</div>
                            <div class="hotel-fea-inner">
                                {if !empty($hotel.AttributeList)}
                                    {foreach $hotel.AttributeList as $val}
                                        <div title="{$val.Title}" class="hotel-fea-item">{$val.Title}</div>
                                    {/foreach}
                                {else}
                                    <div title="MINIBAR" class="hotel-fea-item">MINIBAR</div>
                                    <div title="TV" class="hotel-fea-item">TV</div>
                                    <div title="WI-FI" class="hotel-fea-item">WI-FI</div>
                                    <div title="ROOM SERVICE" class="hotel-fea-item">ROOM SERVICE</div>
                                    <div title="SATELLITE TV" class="hotel-fea-item">SATELLITE TV</div>
                                {/if}
                            </div>
                        </div>

                    </div>

                </div>


            </div>
        </div>
    </div>
{/if}



{literal}
<script type="text/javascript" src="assets/js/modal-login.js"></script>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
      integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
      crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
        integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
        crossorigin=""></script>

<script>
    // position we will use later ,
    let lon = {/literal}{$hotel.MapLang}{literal};
    let lat = {/literal}{$hotel.MapLat}{literal};
    // initialize map
    map = L.map('mapDiv').setView([lat, lon], 15);
    // set map tiles source
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        maxZoom: 100,
    }).addTo(map);
    // add marker to the map
    marker = L.marker([lat, lon]).addTo(map);
</script>


    <script type="text/javascript">
        $(document).ready(function () {


            $('.hotel-thumb-carousel').owlCarousel({
                items: 2,
                rtl: true,
                loop: true,
                center: true,
                margin: 5,
                nav: true,
                dots: false,
                autoplay: true,
                autoplayTimeout: 4500,
                autoplaySpeed: 1000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    575: {
                        items: 2,

                    }
                }
            });


            $("body").delegate(".showCancelRule", "click", function () {

                let roomId = $(this).data("roomindex");
                let hotelId = $('#hotelId').val();
                let searchId = $('#searchIdApi').val();
                let loginId = $('#loginIdApi').val();

                $("#boxCancelRule").html('');
                $("#loaderCancel-" + roomId).show();
                //$("#btnCancelRule-" + roomId).css('opacity', '0.5').css('cursor', 'progress');
                $("#btnCancelRule-" + roomId).removeClass('showCancelRule').addClass('hideCancelRule').css('opacity', '0.5').css('cursor', 'progress');
                $("#btnCancelRule-" + roomId + " i").removeClass("fa fa-angle-down").addClass("fa fa-angle-up");

                $.post(amadeusPath + 'hotel_ajax.php',
                    {
                        hotelId: hotelId,
                        roomId: roomId,
                        searchId: searchId,
                        loginId: loginId,
                        flag: 'getInfoRoomExternalHotel'
                    },
                    function (data) {
                        $("#boxCancelRule-" + roomId).html(data);
                        $("#loaderCancel-" + roomId).hide();
                        $("#btnCancelRule-" + roomId).css('opacity', '1').css('cursor', 'pointer');
                    });
            });
            $("body").delegate(".hideCancelRule", "click", function () {
                let roomId = $(this).data("roomindex");
                $("#boxCancelRule-" + roomId).html('');
                $("#btnCancelRule-" + roomId).removeClass('hideCancelRule').addClass('showCancelRule').css('opacity', '1').css('cursor', 'pointer');
                $("#btnCancelRule-" + roomId + " i").removeClass("fa fa-angle-up").addClass("fa fa-angle-down");
            });


            // freebreakfast
            $(".ShowByFiltersFreeBreakfast").on("click", function () {
                $('.ShowAllFoodType').prop('checked', true);
                let roomList = $(".hotel-rooms-item");
                let isCheck = 0;
                roomList.hide();
                $("input:checkbox.ShowByFiltersFreeBreakfast").each(function () {
                    let check = $(this).prop('checked');
                    if (check == true) {
                        let val = $(this).val();
                        console.log('val', val);
                        isCheck++;
                        $('.ShowAllFoodType').prop('checked', false);
                        roomList.filter(function () {
                            let freeBreakfast = $(this).find("input[name='inputFreeBreakfastRooms']").val();
                            console.log('freeBreakfast', freeBreakfast);
                            let search = freeBreakfast.indexOf(val);
                            if (search > -1) {
                                return true;
                            }
                        }).show();
                    }
                });

                setTimeout(function () {
                    if (isCheck == 0) {
                        roomList.show();
                    }
                }, 30);

                $('html, body').animate({
                    scrollTop: $('.filter-type-of-food').offset().top
                }, 'slow');

            });

            $(".ShowAllFoodType").on("click", function () {
                let roomList = $(".hotel-rooms-item");
                roomList.show();
                let check = $(this).prop('checked');
                if (check == true) {
                    $("input:checkbox.ShowByFiltersFreeBreakfast").each(function () {
                        $(this).prop("checked", false);
                    });
                } else {
                    $(".ShowAllFoodType").prop("checked", true);
                }
                $('html, body').animate({
                    scrollTop: $('.filter-type-of-food').offset().top
                }, 'slow');
            });
            // end freebreakfast

        });
    </script>
    <script src="assets/js/html5gallery.js"></script>
    <script src="assets/js/jquery.fancybox.min.js"></script>



    <script>
        $(document).ready(function () {

            $('body').on('click', '.myroom-hotel-item .close', function () {
                let roomNumber = $(this).parents(".myroom-hotel-item").data("roomnumber");
                $(this).parents(".myroom-hotel-item").remove();
                let countRoom = parseInt($('#countRoom').val()) - 1;
                $("#countRoom option:selected").prop("selected",false);
                $("#countRoom option[value=" + countRoom + "]").prop("selected",true);
                let numberRoom = 1;
                let numberText = useXmltag('First');
                $('.myroom-hotel-item').each(function () {
                    $(this).data("roomnumber", numberRoom);
                    if (numberRoom == 1) {
                        numberText = useXmltag('First');
                    } else if (numberRoom == 2) {
                        numberText = useXmltag('Second');
                    } else if (numberRoom == 3) {
                        numberText = useXmltag('Third');
                    } else if (numberRoom == 4) {
                        numberText = useXmltag('Fourth');
                    }
                    $(this).find('.myroom-hotel-item-title').html(useXmltag('Room') + ' ' + numberText + '<span class="close"></span>');
                    $(this).find(".myroom-hotel-item-info").find("input[name^='adult']").attr("name", "adult" + numberRoom);
                    $(this).find(".myroom-hotel-item-info").find("input[name^='adult']").attr("id", "adult" + numberRoom);
                    $(this).find(".myroom-hotel-item-info").find("input[name^='child']").attr("name", "child" + numberRoom);
                    $(this).find(".myroom-hotel-item-info").find("input[name^='child']").attr("id", "child" + numberRoom);
                    let numberChild = 1;
                    let inputNameSelectChildAge = $(this).find(".tarikh-tavalods .tarikh-tavalod-item");
                    inputNameSelectChildAge.each(function () {
                        $(this).find("select[name^='childAge']").attr("name", "childAge" + numberRoom + numberChild);
                        $(this).find("select[name^='childAge']").attr("id", "childAge" + numberRoom + numberChild);
                        numberChild++;
                    });
                    numberRoom++;
                });
            });

            $('#countRoom').on('change', function () {
                let roomCount = $("#countRoom").val();
                createRoomHotel(roomCount);
                $(".myroom-hotel").find(".myroom-hotel-item").remove();
                let code = createRoomHotel(roomCount);
                $(".myroom-hotel").append(code);
            });

            $('body').on('click', 'i.addParentEHotel', function () {
                let inputNum = $(this).siblings(".countParentEHotel").val();
                inputNum++;
                $(this).siblings(".countParentEHotel").val(inputNum);
            });

            $('body').on('click', 'i.minusParentEHotel', function () {
                let inputNum = $(this).siblings(".countParentEHotel").val();
                if (inputNum != 0) {
                    inputNum--;
                    $(this).siblings(".countParentEHotel").val(inputNum);
                }
                else {
                    $(this).siblings(".countParentEHotel").val('0');
                }
            });

            $('body').on('click', 'i.addChildEHotel', function () {
                let inputNum = $(this).siblings(".countChildEHotel").val();
                inputNum++;
                if (inputNum < 5) {
                    $(this).siblings(".countChildEHotel").val(inputNum);
                    let roomNumber = $(this).parents(".myroom-hotel-item").data("roomnumber");
                    let htmlBox = createBirthdayCalendar(inputNum, roomNumber);
                    $(this).parents(".myroom-hotel-item-info").find(".tarikh-tavalods").html(htmlBox);
                }
            });

            $('body').on('click', 'i.minusChildEHotel', function () {
                let inputNum = $(this).siblings(".countChildEHotel").val();
                if (inputNum != 0) {
                    inputNum--;
                    $(this).siblings(".countChildEHotel").val(inputNum);
                    let roomNumber = $(this).parents(".myroom-hotel-item").data("roomnumber");
                    let htmlBox = createBirthdayCalendar(inputNum, roomNumber);
                    $(this).parents(".myroom-hotel-item-info").find(".tarikh-tavalods").html(htmlBox);
                }
                else {
                    $(this).siblings(".countChildEHotel").val('0');
                }
            });

        });


        function createRoomHotel(roomCount) {

            let HtmlCode = "";
            let i = 1;
            let numberText = useXmltag('First');
            while (i <= roomCount) {
                if (i == 1) {
                    numberText = useXmltag('First');
                } else if (i == 2) {
                    numberText = useXmltag('Second');
                } else if (i == 3) {
                    numberText = useXmltag('Third');
                } else if (i == 4) {
                    numberText = useXmltag('Fourth');
                }
                HtmlCode +=
                    '<div class="myroom-hotel-item" data-roomNumber="' + i + '">'
                    + '<div class="myroom-hotel-item-title site-main-text-color">' + useXmltag('Room') + '  ' + numberText + '<span class="close"></span></div>'
                    + '<div class="myroom-hotel-item-info">'
                    + '<div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">'
                    + '<span>' + useXmltag('Adultnumber') + '<i>(12 ' + useXmltag ('yearsandup') + ')</i></span>'
                    + '<div>'
                    + '<i class="addParentEHotel fa fa-plus  site-main-text-color site-bg-color-dock-border"></i>'
                    + '<input readonly class="countParentEHotel"  min="0" value="1" max="5" type="number" name="adult' + i + '" id="adult' + i + '">'
                    + '<i class="minusParentEHotel fa fa-minus  site-main-text-color site-bg-color-dock-border"></i>'
                    + '</div>'
                    + '</div>'
                    + '<div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">'
                    + '<span>' + useXmltag('Numberofchildren') + '<i>(' + useXmltag ('Under') + ' 12 ' + useXmltag ('Year') + '</i></span>'
                    + '<div>'
                    + '<i class="addChildEHotel fa fa-plus  site-main-text-color site-bg-color-dock-border"></i>'
                    + '<input readonly class="countChildEHotel" min="0" value="0" max="5" type="number" name="child' + i + '" id="child' + i + '">'
                    + '<i class="minusChildEHotel fa fa-minus  site-main-text-color site-bg-color-dock-border"></i>'
                    + '</div>'
                    + '</div>'
                    + '<div class="tarikh-tavalods">'
                    + '</div>'
                    + '</div>'
                    + '</div>';

                i++;
            }

            return HtmlCode;
        }

        function createBirthdayCalendar(inputNum, roomNumber) {
            let i = 1;
            let HtmlCode = "";
            let numberTextChild = "";
            while (i <= inputNum) {
                if (i == 1) {
                    numberTextChild = useXmltag('First');
                } else if (i == 2) {
                    numberTextChild = useXmltag('Second');
                } else if (i == 3) {
                    numberTextChild = useXmltag('Third');
                } else if (i == 4) {
                    numberTextChild = useXmltag('Fourth');
                }
                HtmlCode += '<div class="tarikh-tavalod-item">'
                    + '<span>' + useXmltag ('Childage') + ' <i>' + numberTextChild + '</i></span>'
                    + '<select id="childAge' + roomNumber + i + '" name="childAge' + roomNumber + i + '">'
                    + '<option value="1">0 ##To## 1 ##Year##</option>'
                    + '<option value="2">1 ##To## 2 ##Year##</option>'
                    + '<option value="3">2 ##To## 3 ##Year##</option>'
                    + '<option value="4">3 ##To## 4 ##Year##</option>'
                    + '<option value="5">4 ##To## 5 ##Year##</option>'
                    + '<option value="6">5 ##To## 6 ##Year##</option>'
                    + '<option value="7">6 ##To## 7 ##Year##</option>'
                    + '<option value="8">7 ##To## 8 ##Year##</option>'
                    + '<option value="9">8 ##To## 9 ##Year##</option>'
                    + '<option value="10">9 ##To## 10 ##Year##</option>'
                    + '<option value="11">10 ##To## 11 ##Year##</option>'
                    + '<option value="12">11 ##To## 12 ##Year##</option>'
                    + '</select>'
                    + '</div>';
                i++;
            }
            return HtmlCode;
        }

    </script>

{/literal}

