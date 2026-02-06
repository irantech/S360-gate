{*{$objFunctions->insertLog('first page resultExternalHotel', '00000-checkExternalHotel', 'yes')}*}
{load_presentation_object filename="reservationHotel" assign="objReservationHotel"}
{load_presentation_object filename="dateTimeSetting" assign="dateTime"}
{assign var="which_sort" value=$objReservationHotel->activeOrderHotel()}


{assign var="cityInfo" value=$objReservationHotel->getCitiesExternalByName($smarty.const.SEARCH_CITY)}

{assign var="countryNameEn" value=$smarty.const.SEARCH_COUNTRY}
{assign var="cityNameEn" value=$smarty.const.SEARCH_CITY}
{assign var="startDate" value=$smarty.const.SEARCH_START_DATE}
{assign var="endDate" value=$smarty.const.SEARCH_END_DATE}
{assign var="nights" value=$smarty.const.SEARCH_NIGHT}
{assign var="searchRooms" value=$smarty.const.SEARCH_ROOMS}
{assign var="searchHotelName" value=$smarty.const.SEARCH_HOTEL_NAME}
{assign var="nationality" value='IR'}
{assign var="tomorrow" value=$dateTime->tomorrow()}

{if $smarty.get.type eq 'new'}
    {$countryNameEn = $smarty.get.country}
    {$cityNameEn = $smarty.get.city}
    {$startDate = $smarty.get.start_date}
    {$endDate = $smarty.get.end_date}
    {$nights = $smarty.get.nights}
    {$searchRooms = $smarty.get.rooms}
    {$searchHotelName = $smarty.get.hotel_name}
    {$nationality = $smarty.get.nationality}
{/if}

{*{$objFunctions->insertLog('before numberOfRoomsExternalHotelSearch', '00000-checkExternalHotel', 'yes')}*}
{assign var="numberOfRooms" value=$objFunctions->numberOfRoomsExternalHotelSearch($searchRooms)}
{*{$objFunctions->insertLog('after numberOfRoomsExternalHotelSearch', '00000-checkExternalHotel', 'yes')}*}
{*{$objFunctions->insertLog('before numberOfRoomsExternalHotelRequested', '00000-checkExternalHotel', 'yes')}*}
{assign var="rooms" value=$objFunctions->numberOfRoomsExternalHotelRequested($numberOfRooms['rooms'])|json_encode}
{*{$objFunctions->insertLog('after numberOfRoomsExternalHotelRequested', '00000-checkExternalHotel', 'yes')}*}
{*{assign var='reservation_htoels' value=$obj_main_page->getExternalHotelCityList()}*}


<script type="text/javascript">
    /* *** List of hotels for preview alaki *** */
    // getResultExternalHotelPreview('{$countryNameEn}', '{$cityNameEn}', '{$startDate}', '{$nights}');
    let search_ajax_details = {
      'className' : 'resultSearchExternalHotel',
      'method' : 'searchDetails',
      'country': '{$countryNameEn}',
      'city' : '{$cityNameEn}',
      'start_date': '{$startDate}',
      'nights':'{$nights}',
      'nationality' : '{$nationality}',
      'rooms': JSON.parse(JSON.stringify({$rooms})),
    };

    externalHotelSearchDetails(search_ajax_details);

    /* *** List of hotels *** */
    getResultExternalHotelSearch('{$countryNameEn}', '{$cityNameEn}', '{$startDate}', '{$nights}', '{$rooms}','{$nationality}');
</script>


{load_presentation_object filename="currencyEquivalent" assign="objCurrency"}
<div class="progress-container">
    <div class="progress-bar site-bg-main-color" id="myBarHead"></div>
</div>
<input type='hidden' name='sort_hotel_type' id='sort_hotel_type' value='{$which_sort[0]['title_en']}'>
<div class="row minW-100 external_h w-100 m-auto">
    <div class="col-lg-3 col-md-12  col-12 col-padding-5">
        <div class="parent_sidebar">
            <!-- Change Currency Box -->
            {if $smarty.const.ISCURRENCY eq '1'}
                <div class="currency-gds">

                    {assign var="CurrencyInfo"  value=$objCurrency->InfoCurrency($objSession->getCurrency())}

                    {if $CurrencyInfo neq null}
                        <div class="currency-inner DivDefaultCurrency">
                            <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/flagCurrency/{$CurrencyInfo['CurrencyFlag']}"
                                 alt="" id="IconDefaultCurrency">
                            {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                <span class="TitleDefaultCurrency">{$CurrencyInfo['CurrencyTitleFa']}</span>
                                {else}
                                <span class="TitleDefaultCurrency">{$CurrencyInfo['CurrencyTitleEn']}</span>
                            {/if}

                            <span class="currency-arrow"></span>
                        </div>
                    {else}
                        <div class="currency-inner DivDefaultCurrency">
                            <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/flagCurrency/Iran.png" alt=""
                                 id="IconDefaultCurrency">
                            <span class="TitleDefaultCurrency">##IranianRial##</span>
                            <span class="currency-arrow"></span>
                        </div>
                    {/if}

                    <div class="change-currency">
                        <div class="change-currency-inner">
                            <div class="change-currency-item main"
                                 onclick="ConvertCurrency('0','Iran.png','##IranianRial##')">
                                <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/flagCurrency/Iran.png" alt="">
                                <span>##Iran##</span>
                            </div>
                            {foreach $objCurrency->ListCurrencyEquivalent()  as  $Currency}
                                <div class="change-currency-item"
                                     onclick="ConvertCurrency('{$Currency.CurrencyCode}','{$Currency.CurrencyFlag}','{$Currency.CurrencyTitle}')">
                                    <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/flagCurrency/{$Currency.CurrencyFlag}"
                                         alt="">
                                    <span>{$Currency.CurrencyTitle}</span>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                </div>
            {/if}

            <div class="filterBox filterBox_hotel_external ">
                <div class="filtertip_hotel site-bg-main-color site-bg-color-border-bottom ">
                    <div class="parent-mobile--new">
                        <p class="txt14"> ##Allhotelincity## <span class="hotel-city-name txt15 iranM " id="city_name_fa"></span></p>
                        <div class="txt14">
                        <span class="silence_span">
                      <div class="container_loading">
                          <div class="circle_load circle-1"></div>
                          <div class="circle_load circle-2"></div>
                          <div class="circle_load circle-3"></div>
                          <div class="circle_load circle-4"></div>
                          <div class="circle_load circle-5"></div>
                      </div>
                        <b id="countHotelHtml"></b> ##NumberHotelsFound##
                    </span>
                            {*{$startDate}
                            <a class="iranM">##To##</a>
                            <b dir="ltr">{$endDate}</b>*}
                        </div>
                    </div>
                    <div class="parent-mobile--filter">
                        <div class="research_Hotel site-main-text-color" onclick="showSearchBoxTicket()">##ChangeSearchType##</div>
                        <div class="filter_search_holel">
                            <svg class="site-bg-svg-color" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2024 Fonticons, Inc. --><path d="M0 73.7C0 50.7 18.7 32 41.7 32H470.3c23 0 41.7 18.7 41.7 41.7c0 9.6-3.3 18.9-9.4 26.3L336 304.5V447.7c0 17.8-14.5 32.3-32.3 32.3c-7.3 0-14.4-2.5-20.1-7l-92.5-73.4c-9.6-7.6-15.1-19.1-15.1-31.3V304.5L9.4 100C3.3 92.6 0 83.3 0 73.7zM55 80L218.6 280.8c3.5 4.3 5.4 9.6 5.4 15.2v68.4l64 50.8V296c0-5.5 1.9-10.9 5.4-15.2L457 80H55z"></path></svg>
                            <span class="site-main-text-color"> ##Filter##</span>
                        </div>
                    </div>
                </div>

                <div class="filtertip-searchbox filtertip-searchbox-box1 filtertip_hotel_researh">
                    <form class="search-wrapper parent-research-external-hotel-sidebar mt-4" action="" method="post">

                        <input type="hidden" name="rooms" id="rooms" value="{$searchRooms}">

                        <div class="inputSearchForeign-box inputSearchForeign-pad_Fhotel">
                            <div class="s-u-in-out-wrapper raft raft-change change-bor">
                                <input id="destination_country" name="destination_country" type="hidden"
                                       value="{$countryNameEn}">
                                <input id="destination_city" name="destination_city" type="hidden"
                                       value="{$cityNameEn}">
                                <input id="autoComplateSearchIN" name="autoComplateSearchIN"
                                       class="inputSearchForeign" type="text" value=""
                                       placeholder='##Selection## ##City##'
                                       autocomplete="off"
                                       onkeyup="searchCity('externalHotel')"
                                       onclick="openBoxPopular('externalHotel')">
                                <img src="assets/images/load.gif" id="LoaderForeignDep" name="LoaderForeignDep"
                                     class="loaderSearch">
                                <ul id="listSearchCity" class="ul-inputSearch-externalHotel displayiN"></ul>
                            </div>
                        </div>




                        {assign var="classNameStartDate" value="hotelStartDateShamsi"}
                        {assign var="classNameEndDate" value="hotelEndDateShamsi"}
                        {if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || $startDate|substr:0:4 gt 2000}
                            {$classNameStartDate="deptCalendarToCalculateNights"}
                        {/if}
                        {if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || $endDate|substr:0:4 gt 2000}
                            {$classNameEndDate="returnCalendarToCalculateNights"}
                        {/if}

                        <div class="form-hotel-item form-hotel-item-searchBox-date">
                            <div class="input">
                                <i class="fa fa-calendar site-main-text-color"></i>
                                <input type="text" placeholder="##Enterdate##" id="startDateForeign" name="startDate"
                                       value="{$startDate}"
                                       class="{$classNameStartDate}">
                            </div>
                        </div>

                        <div class="form-hotel-item form-hotel-item-searchBox-date">
                            <div class="input">
                                <i class="fa fa-calendar site-main-text-color"></i>
                                <input type="text" placeholder="##Exitdate##" id="endDateForeign" name="endDate"
                                       value="{$endDate}"
                                       class="{$classNameEndDate}">
                            </div>
                        </div>

                        <div class="form-hotel-item form-hotel-item-searchBox-date ">
                            <div class="form-hotel-item-boder">
                                <span class="stayingTime">{$nights} ##Night## </span>
                                <i class="calendar-icon fa fa-bed site-main-text-color"></i>
                                <input type="hidden" id="stayingTime" name="stayingTime" value="{$nights}"/>
                            </div>
                        </div>

                        <div class="form-hotel-item form-hotel-item-searchBox-date">
                            <div class="select">
                                <select name="countRoom" id="countRoom" class="select2">
                                    <option value="1" {if $numberOfRooms['countRoom'] eq '1'} selected {/if}>1
                                        ##Room##
                                    </option>
                                    <option value="2" {if $numberOfRooms['countRoom'] eq '2'} selected {/if}>2
                                        ##Room##
                                    </option>
                                    <option value="3" {if $numberOfRooms['countRoom'] eq '3'} selected {/if}>3
                                        ##Room##
                                    </option>
                                    <option value="4" {if $numberOfRooms['countRoom'] eq '4'} selected {/if}>4
                                        ##Room##
                                    </option>
                                </select>
                            </div>
                        </div>

                        {if $smarty.get.type eq 'new'}
                            <input type="hidden" id="type" name="type" value="new">
                            {load_presentation_object filename="country" assign="countryController"}
                            
                            <div class="form-hotel-item">
                                <div class="select">
                                    <select name="nationality" id="nationality" class="select2">
                                        {assign var="ocuntryTitle" value="titleEn"}
                                        {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                            {$ocuntryTitle = 'titleFa'}
                                        {/if}
                                        {foreach $countryController->getAllCountries() as $country}

                                            <option {if ($smarty.get.nationality eq $country.code_two_letter) OR ($smarty.get.nationality eq '' AND $country.code_two_letter eq 'IR')}selected="selected"{/if} value="{$country.code_two_letter}">{$country[$ocuntryTitle]} - {$country.code_two_letter}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>

                        {/if}


                        <div class="w-100" id="box-foreign-hotel-room">
                            <div class="clrB site-main-text-color-drck box-foreign-hotel-room-item">
                                <div class="myroom-hotel">
                                    {foreach from=$numberOfRooms['rooms'] key=key item=room}
                                        {assign var="count" value=$key+1}
                                        <div class="myroom-hotel-item" data-roomNumber="{$count}">
                                            <div class="myroom-hotel-item-title site-main-text-color">
                                                ##Room## {$objFunctions->textNumber($count)}<span class="close"></span>
                                            </div>
                                            <div class="myroom-hotel-item-info">
                                                <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
                                                    <span>##Adultnumber##</span>
                                                    <div>
                                                        <i class="addParentEHotel fa fa-plus site-main-text-color site-bg-color-dock-border"></i>
                                                        <input type="text" name="adult{$count}" id="adult{$count}" readonly="" class="countParentEHotel" min="1" value="{$room.AdultCount}" max="6">
                                                        <i class="minusParentEHotel fa fa-minus  site-main-text-color site-bg-color-dock-border"></i>
                                                    </div>
                                                </div>
                                                <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
                                                    <span>##Numberofchildren##</span>
                                                    <div>
                                                        <i class="addChildEHotel fa fa-plus  site-main-text-color site-bg-color-dock-border"></i>
                                                        <input type="text" readonly="" name="child{$count}"
                                                               id="child{$count}"
                                                               class="countChildEHotel" min="0"
                                                               value="{$room['ChildrenCount']}"
                                                               max="5">
                                                        <i class="minusChildEHotel fa fa-minus  site-main-text-color site-bg-color-dock-border"></i>
                                                    </div>
                                                </div>
                                                <div class="tarikh-tavalods">
                                                    {if $room['ChildrenCount'] neq '0'}
                                                        {for $i=1 to $room['ChildrenCount']}
                                                            <div class="tarikh-tavalod-item">
                                                                <span>##Childage## <i>{$objFunctions->textNumber($i)}</i></span>
                                                                <select id="childAge{$count}{$i}"
                                                                        name="childAge{$count}{$i}">
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
                                <button class="site-bg-main-color site-secondary-text-color"
                                        type="button" id="searchHotelLocal" onclick="submitSearchExternalHotel()">
                                    ##Search##
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="filterBox filterBox_external_hotel">
                <span class="s-u-close-filter"></span>
                <div class="filtertip-searchbox">
                    <span class="filter-title">##Namehotel##</span>
                    <div class="filter-content padb0">
                        <input type="text" class="form-hotel-item-searchHotelName" placeholder=" ##EnterHotelName##"
                               id="inputSearchHotel" value="{*$searchHotelName*}">
                        <i class="fa fa-search form-hotel-item-searchHotelName-i site-main-text-color"></i>
                    </div>
                </div>

                <div class="filtertip-searchbox">
                    <span class="filter-title"> ##Price## (##Rial##)</span>
                    <div class="filter-content padb0">
                        <div class="container_loading">
                            <div class="circle_load circle-1"></div>
                            <div class="circle_load circle-2"></div>
                            <div class="circle_load circle-3"></div>
                            <div class="circle_load circle-4"></div>
                            <div class="circle_load circle-5"></div>
                        </div>
                        <div class="filter-price-text">

                            <span> <i></i></span>
                            <span> <i></i></span>
                        </div>
                        <div id="slider-range"></div>
                    </div>
                </div>

                <div class="filtertip-searchbox">
                    <span class="filter-title">##Starhotel##</span>
                    <div class="filter-content padb10">

                        <div class="raste-item">
                            <input type="checkbox" class="FilterHoteltype hotelStarFilter" id="starHotel5"
                                   name="starHotel5"
                                   value="5">
                            <label class="FilterHoteltypeName site-main-text-color-a" for="starHotel5"></label>
                            <div class="hotel-star-filter-box">
                                <div class="hotel-star-filter star-5">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        </div>

                        <div class="raste-item">
                            <input type="checkbox" class="FilterHoteltype hotelStarFilter" id="starHotel4"
                                   name="starHotel4"
                                   value="4">
                            <label class="FilterHoteltypeName site-main-text-color-a" for="starHotel4"></label>
                            <div class="hotel-star-filter-box">
                                <div class="hotel-star-filter star-4">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        </div>

                        <div class="raste-item">
                            <input type="checkbox" class="FilterHoteltype hotelStarFilter" id="starHotel3"
                                   name="starHotel3"
                                   value="3">
                            <label class="FilterHoteltypeName site-main-text-color-a" for="starHotel3"></label>
                            <div class="hotel-star-filter-box">
                                <div class="hotel-star-filter star-3">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        </div>

                        <div class="raste-item">
                            <input type="checkbox" class="FilterHoteltype hotelStarFilter" id="starHotel2"
                                   name="starHotel2"
                                   value="2">
                            <label class="FilterHoteltypeName site-main-text-color-a" for="starHotel2"></label>
                            <div class="hotel-star-filter-box">
                                <div class="hotel-star-filter star-2">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="raste-item">
                            <input type="checkbox" class="FilterHoteltype hotelStarFilter" id="starHotel1"
                                   name="starHotel1"
                                   value="1">
                            <label class="FilterHoteltypeName site-main-text-color-a" for="starHotel1"></label>
                            <div class="hotel-star-filter-box">
                                <div class="hotel-star-filter star-1">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="filtertip-searchbox displayN">
                    <span class="filter-title">##Typeoffood##</span>
                    <div class="filter-content padb10">

                        <p class="raste-item">
                            <input type="checkbox" class="FilterHoteltype ShowAllFoodType" id="foodTypeAll"
                                   name="foodType"
                                   value="all" checked>
                            <label class="FilterHoteltypeName site-main-text-color-a" for="foodTypeAll">##All##</label>
                        </p>

                        <p class="raste-item">
                            <input type="checkbox" class="FilterHoteltype ShowByFiltersFreeBreakfast"
                                   id="foodTypeBreeBreakfast" name="foodTypeBreeBreakfast" value="yes">
                            <label class="FilterHoteltypeName site-main-text-color-a"
                                   for="foodTypeBreeBreakfast">##Withbreakfast##</label>
                        </p>

                        <p class="raste-item">
                            <input type="checkbox" class="FilterHoteltype ShowByFiltersFreeBreakfast"
                                   id="foodTypeRoomOnly" name="foodTypeRoomOnly" value="no">
                            <label class="FilterHoteltypeName site-main-text-color-a"
                                   for="foodTypeRoomOnly">##Onlyroom##</label>
                        </p>

                    </div>
                </div>


                <div id="facilitiesHtml"></div>


                {*// نمایش لاگ دریافت نتیجه از وب سرویس (برای آقای افشار) //*}
                <div class="filtertip-searchbox"
                     style="background: #f5f5f5; color: #f5f5f5;direction: ltr;text-align: left;">
                    <div class="filter-content padb10 padt10" id="logExternalHotel"></div>
                </div>


            </div>
        </div>
    </div>

    <!-- LIST CONTENT-->
    <div class="col-lg-9 col-md-12  col-12 col-padding-5 search_hotel_external">


        <div class="sort-by-section clearfix box">
            <div class="info-login">
                <div class="head-info-login">
                    <svg class="site-bg-svg-color" version="1.0" xmlns="http://www.w3.org/2000/svg"
                         width="128.000000pt" height="128.000000pt" viewBox="0 0 128.000000 128.000000"
                         preserveAspectRatio="xMidYMid meet">

                        <g transform="translate(0.000000,128.000000) scale(0.100000,-0.100000)" stroke="none">
                            <path d="M345 1055 c-14 -13 -25 -31 -25 -39 0 -12 -18 -16 -91 -18 -75 -2
-94 -6 -103 -20 -8 -13 -8 -23 0 -35 9 -15 28 -19 103 -21 73 -2 91 -6 91 -18
0 -8 11 -26 25 -39 21 -22 33 -25 95 -25 62 0 74 3 95 25 14 13 25 31 25 39 0
14 38 16 291 18 265 3 293 5 303 21 8 12 8 22 0 35 -10 15 -38 17 -303 20
-253 2 -291 4 -291 18 0 8 -11 26 -25 39 -21 22 -33 25 -95 25 -62 0 -74 -3
-95 -25z m135 -95 l0 -40 -40 0 -40 0 0 40 0 40 40 0 40 0 0 -40z"/>
                            <path d="M665 735 c-14 -13 -25 -31 -25 -39 0 -14 -34 -16 -251 -18 -227 -3
-253 -5 -263 -21 -8 -12 -8 -22 0 -35 10 -15 36 -17 263 -20 217 -2 251 -4
251 -18 0 -8 11 -26 25 -39 21 -22 33 -25 95 -25 62 0 74 3 95 25 14 13 25 31
25 39 0 13 22 16 131 18 113 3 133 6 143 20 8 13 8 23 0 36 -10 14 -30 17
-143 20 -109 2 -131 5 -131 18 0 8 -11 26 -25 39 -21 22 -33 25 -95 25 -62 0
-74 -3 -95 -25z m135 -95 l0 -40 -40 0 -40 0 0 40 0 40 40 0 40 0 0 -40z"/>
                            <path d="M345 415 c-14 -13 -25 -31 -25 -39 0 -12 -18 -16 -91 -18 -75 -2 -94
-6 -103 -21 -8 -12 -8 -22 0 -35 9 -14 28 -18 103 -20 73 -2 91 -6 91 -18 0
-8 11 -26 25 -39 21 -22 33 -25 95 -25 62 0 74 3 95 25 14 13 25 31 25 39 0
14 38 16 291 18 265 3 293 5 303 21 8 12 8 22 0 35 -10 15 -38 17 -303 20
-253 2 -291 4 -291 18 0 8 -11 26 -25 39 -21 22 -33 25 -95 25 -62 0 -74 -3
-95 -25z m135 -95 l0 -40 -40 0 -40 0 0 40 0 40 40 0 40 0 0 -40z"/>
                        </g>
                    </svg>

                    <span class="">
                                ##Sortby##
                    </span>
                </div>
                <div class="form-sort hotel-sort hotel-sort-hotel">

                    <div class="s-u-form-input-number col-md-6">
                        <div class="select">
                            <select class="select2" id="starSortSelect" tabindex="-1"
                                    aria-hidden="true" onchange="selectSortHotel(this);">
                                <option disabled="" selected="" hidden="">##Starhotel##</option>
                                <option value="min_star_code"> ##LTM##</option>
                                <option value="max_star_code"> ##MTL##</option>
                            </select>
                        </div>
                    </div>
                    <div class="s-u-form-input-number col-md-6 pr-0">
                        <div class="select">
                            <select class="select2" id="priceSortSelect" tabindex="-1"
                                    aria-hidden="true" onchange="selectSortHotel(this);">
                                <option disabled="" selected="" hidden="">##Price##</option>
                                <option value="min_room_price">##LTM##</option>
                                <option value="max_room_price"> ##MTL##</option>
                            </select>
                        </div>
                    </div>
                    {*<div class="s-u-form-input-number form-item form-item-sort countTiket">

                        <div class="loader-box-count-hotels">
                            <span></span>
                            <span>##Searching##...</span>
                        </div>

                        <div id="boxCountHotels" class="displayN">
                            <p>##Result##: <b id="countHotelHtml"></b> ##Hotel## </p>
                        </div>

                    </div>*}
                </div>
            </div>
        </div>
{*        <div class="loader-for-external-hotel-end">*}

{*            <div class='container'>*}
{*                <div class="loader">*}
{*                    *}{* <div class="duo duo1">*}
{*                         <div class="dot dot-a"></div>*}
{*                         <div class="dot dot-b"></div>*}
{*                     </div>*}
{*                     <div class="duo duo2">*}
{*                         <div class="dot dot-a"></div>*}
{*                         <div class="dot dot-b"></div>*}
{*                     </div>*}
{*                </div>*}

{*                <div class="text_loading">*}
{*                    <h4>*}
{*                        {$objFunctions->StrReplaceInXml(['@@cityName@@'=>$cityNameEn],'HotelSearchForCity')}*}
{*                    </h4>*}
{*                    <div class="result_loading">*}
{*                        <span class="nights_text">{$objFunctions->StrReplaceInXml(['@@nightsCount@@'=>$nights],'ForHowMenyNights')}</span>*}
{*                        {if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || $startDate|substr:0:4 gt 2000}*}
{*                            <span class="start_date_text"> {date('j F',strtotime($startDate))}</span>*}
{*                            ##To##*}
{*                            <span class="end_date_text">{date('j F',strtotime($endDate))}</span>*}
{*                        {else}*}
{*                            <span class="start_date_text"> {$objFunctions->dateFormatSpecialJalali($startDate,'j F')}</span>*}
{*                            ##To##*}
{*                            <span class="end_date_text">{$objFunctions->dateFormatSpecialJalali($endDate,'j F')}</span>*}
{*                        {/if}*}

{*                    </div>*}
{*                </div>*}
{*            </div>*}
{*        </div>*}

        <div id="loader-page" class="lazy-loader-parent loader-for-external-hotel-end">
            <div class="loader-page container site-bg-main-color">
                <div class="parent-in row">
                    <div class="loader-txt">
                        <div id="hotel_loader">
                            <span class="loader-date">
                             {if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || $startDate|substr:0:4 gt 2000}
                                 <span class="start_date_text"> {date('j F',strtotime($startDate))}</span>
                                    ##untill##
                                    <span class="end_date_text">{date('j F',strtotime($endDate))}</span>
                            {else}
                                    <span class="start_date_text"> {$objFunctions->dateFormatSpecialJalali($startDate,'j F')}</span>
                                    ##untill##
                                    <span class="end_date_text">{$objFunctions->dateFormatSpecialJalali($endDate,'j F')}</span>
                             {/if}
                            </span>
                            <div class="wrapper">
                                <div class="locstart"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M567.5 229.7C577.6 238.3 578.9 253.4 570.3 263.5C561.7 273.6 546.6 274.9 536.5 266.3L512 245.5V432C512 476.2 476.2 512 432 512H144C99.82 512 64 476.2 64 432V245.5L39.53 266.3C29.42 274.9 14.28 273.6 5.7 263.5C-2.875 253.4-1.634 238.3 8.473 229.7L272.5 5.7C281.4-1.9 294.6-1.9 303.5 5.7L567.5 229.7zM144 464H192V312C192 289.9 209.9 272 232 272H344C366.1 272 384 289.9 384 312V464H432C449.7 464 464 449.7 464 432V204.8L288 55.47L112 204.8V432C112 449.7 126.3 464 144 464V464zM240 464H336V320H240V464z"/></svg></div>
                                <div class="flightpath"><div class="airplane"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M352 48C352 21.49 373.5 0 400 0C426.5 0 448 21.49 448 48C448 74.51 426.5 96 400 96C373.5 96 352 74.51 352 48zM304.6 205.4C289.4 212.2 277.4 224.6 271.2 240.1L269.7 243.9C263.1 260.3 244.5 268.3 228.1 261.7C211.7 255.1 203.7 236.5 210.3 220.1L211.8 216.3C224.2 185.4 248.2 160.5 278.7 146.9L289.7 142C310.5 132.8 332.1 128 355.7 128C400.3 128 440.5 154.8 457.6 195.9L472.1 232.7L494.3 243.4C510.1 251.3 516.5 270.5 508.6 286.3C500.7 302.1 481.5 308.5 465.7 300.6L439 287.3C428.7 282.1 420.6 273.4 416.2 262.8L406.6 239.8L387.3 305.3L436.8 359.4C442.2 365.3 446.1 372.4 448 380.2L471 472.2C475.3 489.4 464.9 506.8 447.8 511C430.6 515.3 413.2 504.9 408.1 487.8L386.9 399.6L316.3 322.5C301.5 306.4 295.1 283.9 301.6 262.8L318.5 199.3C317.6 199.7 316.6 200.1 315.7 200.5L304.6 205.4zM292.7 344.2L333.4 388.6L318.9 424.8C316.5 430.9 312.9 436.4 308.3 440.9L246.6 502.6C234.1 515.1 213.9 515.1 201.4 502.6C188.9 490.1 188.9 469.9 201.4 457.4L260.7 398L285.7 335.6C287.8 338.6 290.2 341.4 292.7 344.2H292.7zM223.1 274.1C231.7 278.6 234.3 288.3 229.9 295.1L186.1 371.8C185.4 374.5 184.3 377.2 182.9 379.7L118.9 490.6C110 505.9 90.44 511.1 75.14 502.3L19.71 470.3C4.407 461.4-.8371 441.9 7.999 426.6L71.1 315.7C80.84 300.4 100.4 295.2 115.7 303.1L170.1 335.4L202.1 279.1C206.6 272.3 216.3 269.7 223.1 274.1H223.1z"/></svg></div></div>
                                <div class="locend"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M480 0C497.7 0 512 14.33 512 32C512 49.67 497.7 64 480 64V448C497.7 448 512 462.3 512 480C512 497.7 497.7 512 480 512H304V448H208V512H32C14.33 512 0 497.7 0 480C0 462.3 14.33 448 32 448V64C14.33 64 0 49.67 0 32C0 14.33 14.33 0 32 0H480zM112 96C103.2 96 96 103.2 96 112V144C96 152.8 103.2 160 112 160H144C152.8 160 160 152.8 160 144V112C160 103.2 152.8 96 144 96H112zM224 144C224 152.8 231.2 160 240 160H272C280.8 160 288 152.8 288 144V112C288 103.2 280.8 96 272 96H240C231.2 96 224 103.2 224 112V144zM368 96C359.2 96 352 103.2 352 112V144C352 152.8 359.2 160 368 160H400C408.8 160 416 152.8 416 144V112C416 103.2 408.8 96 400 96H368zM96 240C96 248.8 103.2 256 112 256H144C152.8 256 160 248.8 160 240V208C160 199.2 152.8 192 144 192H112C103.2 192 96 199.2 96 208V240zM240 192C231.2 192 224 199.2 224 208V240C224 248.8 231.2 256 240 256H272C280.8 256 288 248.8 288 240V208C288 199.2 280.8 192 272 192H240zM352 240C352 248.8 359.2 256 368 256H400C408.8 256 416 248.8 416 240V208C416 199.2 408.8 192 400 192H368C359.2 192 352 199.2 352 208V240zM256 288C211.2 288 173.5 318.7 162.1 360.2C159.7 373.1 170.7 384 184 384H328C341.3 384 352.3 373.1 349 360.2C338.5 318.7 300.8 288 256 288z"/></svg></div>
                            </div>
                        </div>
                        <div class="loader-distinc">
                            {$objFunctions->StrReplaceInXml(['@@cityName@@'=>$cityInfo[0]['city_name_fa']],'HotelSearchForCity')}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {if !$countryNameEn || !$cityNameEn || !$startDate || !$searchRooms}
            <div class="userProfileInfo-messge ">
                <div class="messge-login BoxErrorSearch">
                    <div style="float: right;"><i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
                    </div>
                    <div class="TextBoxErrorSearch">

                    </div>
                </div>
            </div>
        {else}
            <div id="hotelResult" data-typeApp="externalHotel">


                {*  {literal}
                      <script type="text/javascript">
                          $(function () {
                              // let elem = document.getElementById("myBar");
                              let elementInternal = document.getElementById("myBarSpan");
                              let width = 0;
                              let id = setInterval(frame1, 500);
                              function frame1() {
                                  if (width == 100) {
                                      clearInterval(id);
                                  } else if (width < 30) {
                                      width++;
                                      // elem.style.width = width + '%';
                                      if (elementInternal) {
                                          elementInternal.innerHTML = '% ' + width * 1;
                                      }
                                  } else if (width >= 30 && width < 99) {
                                      setInterval(frame2, 3500);
                                  }
                              }
                              function frame2() {
                                  if (width >= 30 && width < 99) {
                                      width++;
                                      // elem.style.width = width + '%';
                                      if (elementInternal) {
                                          elementInternal.innerHTML = '% ' + width * 1;
                                      }
                                  }
                              }
                              $('.images-circle').owlCarousel({
                                  items: 1,
                                  rtl: true,
                                  loop: true,
                                  mouseDrag: false,
                                  touchDrag: false,
                                  autoplay: true,
                                  smartSpeed: 2000,
                                  pullDrag: false,
                                  margin: 0,
                                  autoplayTimeout: 300,
                                  autoplaySpeed: 200,
                                  dots: false,
                                  autoplayHoverPause: true,
                              });
                          });
                      </script>
                  {/literal}*}


                {* *** List of hotels for preview alaki *** *}
                <div class="resultExternalHotelSearchAlaki"></div>
            </div>

            {assign var="moduleData" value=[
            'service'=>'Hotel',
            'origin'=>$cityNameEn
            ]}


            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`textSearchResults.tpl"
            moduleData=$moduleData}
            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`faqs.tpl"
            moduleData=$moduleData}
            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`articles.tpl"
            moduleData=$moduleData}


            <input type="hidden" name="countHotels" id="countHotels" value="">
            <input type="hidden" name="countDisplayHotels" id="countDisplayHotels" value="30">
            <form method="post" id="formHotel" action="">
                <input id="startDate" name="startDate" type="hidden" value="{$startDate}">
                <input id="endDate" name="endDate" type="hidden" value="{$endDate}">
                <input id="nights" name="nights" type="hidden" value="{$nights}">
                <input id="searchRooms" name="searchRooms" type="hidden" value="{$searchRooms}">
                <input id="loginIdApi" name="loginIdApi" type="hidden" value="">
                <input id="searchIdApi" name="searchIdApi" type="hidden" value="">
                <input id="typeApplication" name="typeApplication" type="hidden" value="">
                <input id="isExternal" name="isExternal" type="hidden" value="yes">
                <input id="CurrencyCode" name="CurrencyCode" type="hidden" class="CurrencyCode"
                       value="{$objSession->getCurrency()}">
            </form>
        {/if}


    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="map_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="exampleModalLongTitle">##hotelLocationOnMap##</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="mapContainer" class="gmap3"></div>
            </div>

        </div>
    </div>
</div>


{literal}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script>
    <script>
        window.onscroll = function () {
            myFunction()
        };

        function myFunction() {
            $('.progress-container').css('opacity', '1');


            var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            if (winScroll < 3) {
                $('.progress-container').css('opacity', '0');
            }
            var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            var scrolled = (winScroll / height) * 100;
            document.getElementById("myBarHead").style.width = scrolled + "%";
        };
        $(document).ready(function () {
            $(".currency-gds").click(function () {
                $('.change-currency').toggle();
                if ($(".currency-inner .currency-arrow").hasClass("currency-rotate")) {
                    $(".currency-inner .currency-arrow").removeClass('currency-rotate');
                } else {
                    $(".currency-inner .currency-arrow").addClass('currency-rotate')
                }
            });
            $('body').on('click', '.myroom-hotel-item .close', function () {
                let roomNumber = $(this).parents(".myroom-hotel-item").data("roomnumber");
                $(this).parents(".myroom-hotel-item").remove();
                let countRoom = parseInt($('#countRoom').val()) - 1;
                $("#countRoom option:selected").prop("selected", false);
                $("#countRoom option[value=" + countRoom + "]").prop("selected", true);
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
                    $(this).find(".myroom-hotel-item-info").find(".countParentEHotel").attr("name", "adult" + numberRoom);
                    $(this).find(".myroom-hotel-item-info").find(".countParentEHotel").attr("id", "adult" + numberRoom);
                    $(this).find(".myroom-hotel-item-info").find(".countChildEHotel").attr("name", "child" + numberRoom);
                    $(this).find(".myroom-hotel-item-info").find(".countChildEHotel").attr("id", "child" + numberRoom);
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
        });

        function createRoomHotel(roomCount) {

            console.log('bb'+roomCount)
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
                    + '<span>' + useXmltag('Adultnumber') + '<i>(12 ' + useXmltag('yearsandup') + ')</i></span>'
                    + '<div>'
                    + '<i class="addParentEHotel fa fa-plus  site-main-text-color site-bg-color-dock-border"></i>'
                    + '<input readonly class="countParentEHotel"  min="1" value="1" max="6" type="text" name="adult' + i + '" id="adult' + i + '">'
                    + '<i class="minusParentEHotel fa fa-minus  site-main-text-color site-bg-color-dock-border"></i>'
                    + '</div>'
                    + '</div>'
                    + '<div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">'
                    + '<span>' + useXmltag('Numberofchildren') + '<i>(' + useXmltag('Under') + ' 12 ' + useXmltag('Year') + '</i></span>'
                    + '<div>'
                    + '<i class="addChildEHotel fa fa-plus  site-main-text-color site-bg-color-dock-border"></i>'
                    + '<input readonly class="countChildEHotel" min="0" value="0" max="5" type="text" name="child' + i + '" id="child' + i + '">'
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
                    + '<span>' + useXmltag('Childage') + ' <i>' + numberTextChild + '</i></span>'
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
    <script src="assets/js/script.js"></script>
    <script src="assets/js/scrollWithPage.min.js"></script>
    <script type="text/javascript">
        // if ($(window).width() > 990) {
        //     $(".parent_sidebar").scrollWithPage(".external_h");
        // }
        $('body').on('click', '.filter-title', function () {
            $(this).parent().find('.filter-content').slideToggle();
            $(this).parent().toggleClass('hidden_filter');
        });

        $('body').on('click', '.filterBox_external_hotel', function (e) {
            e.stopPropagation();

        });
        $(function () {

            // freebreakfast
            $(".ShowByFiltersFreeBreakfast").on("click", function () {
                $('.ShowAllFoodType').prop('checked', true);
                let hotelList = $(".hotel-result-item");
                let isCheck = 0;
                let countHotels = 0;
                hotelList.hide();
                $("input:checkbox.ShowByFiltersFreeBreakfast").each(function () {
                    let check = $(this).prop('checked');
                    let val = $(this).val();
                    if (check == true) {
                        isCheck++;
                        $('.ShowAllFoodType').prop('checked', false);
                        hotelList.filter(function () {
                            let freeBreakfast = $(this).data("freebreakfast");
                            let search = freeBreakfast.indexOf(val);
                            if (search > -1) {
                                countHotels++;
                                return true;
                            }
                        }).show();
                    }

                });

                setTimeout(function () {
                    if (isCheck == 0) {
                        hotelList.show();
                        countHotels = hotelList.length;
                    }
                    $('#countHotels').val(countHotels);
                    $("#countHotel").html(countHotels);
                    $("#countHotelHtml").html(countHotels);
                }, 30);

                $('html, body').animate({
                    scrollTop: $('.search_hotel_external').offset().top
                }, 'slow');
                console.log(countHotels);
            });

            $(".ShowAllFoodType").on("click", function () {
                let hotelList = $(".hotel-result-item");
                hotelList.show();
                let countHotels = hotelList.length;
                $('#countHotels').val(countHotels);
                $("#countHotel").html(countHotels);
                $("#countHotelHtml").html(countHotels);

                let check = $(this).prop('checked');
                if (check == true) {
                    $("input:checkbox.ShowByFiltersFreeBreakfast").each(function () {
                        $(this).prop("checked", false);
                    });
                } else {
                    $(".ShowAllFoodType").prop("checked", true);
                }
                $('html, body').animate({
                    scrollTop: $('.search_hotel_external').offset().top
                }, 'slow');
            });
            // end freebreakfast


            //filterHotelStar
            $(".hotelStarFilter").on("click", function () {
                let hotelList = $(".hotel-result-item");
                let isCheck = 0;
                hotelList.hide();
                let countHotels = 0;
                $("input:checkbox.hotelStarFilter").each(function () {
                    let check = $(this).prop('checked');
                    let val = $(this).val();
                    if (check == true) {
                        isCheck++;
                        hotelList.filter(function () {
                            let star = $(this).data("star");
                            if (val == star) {
                                countHotels++;
                                return true;
                            }
                        }).show();
                    }
                });

                setTimeout(function () {
                    if (isCheck == 0) {
                        hotelList.show();
                        countHotels = hotelList.length;
                    }
                    $('#countHotels').val(countHotels);
                    $("#countHotel").html(countHotels);
                    $("#countHotelHtml").html(countHotels);
                }, 30);

                $('html, body').animate({
                    scrollTop: $('.search_hotel_external').offset().top
                }, 'slow');

            });
            // end filterHotelStar

            $("#inputSearchHotel").keyup(function () {

                let hotels = $(".hotel-result-item");
                let inputSearchHotel = $("#inputSearchHotel").val().toLowerCase();
                let countHotels = 0;
                hotels.filter(function () {
                    let hotelName = $(this).data("hotelname").toLowerCase()
                    let hotelAddress = $(this).attr("data-hoteladdress").toLowerCase();
                    let searchName = hotelName.indexOf(inputSearchHotel);
                    let searchAddress = hotelAddress.indexOf(inputSearchHotel);
                  // console.log(inputSearchHotel +'==>' + hotelAddress +'==>'+ searchAddress +'==>' +  typeof (searchAddress));
                    if (searchAddress !== -1) {
                        countHotels++;
                        return true;
                    }
                });

                setTimeout(function () {
                    $('#countHotels').val(countHotels);
                    $("#countHotel").html(countHotels);
                    $("#countHotelHtml").html(countHotels);
                }, 30);

                $('html, body').animate({
                    scrollTop: $('.search_hotel_external').offset().top
                }, 'slow');
            });


        });
    </script>
{/literal}

