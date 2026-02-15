{load_presentation_object filename="detailHotel" assign="objHotel"}
{load_presentation_object filename="searchHotel" assign="objsearch"}
<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>
<link rel='stylesheet' href='assets/css/galleryTour/mBox.css'>
<link rel='stylesheet' href='assets/css/galleryTour/style.css'>
{assign var="typeApplication" value=$smarty.const.TYPE_APPLICATION}
{assign var="hotelIndex" value=$smarty.const.HOTEL_INDEX}
{assign var="sourceId" value=$hotelIndex|substr:0:2}
{assign var="requestNumber" value=$smarty.const.REQUEST_NUMBER}
{assign var="searchRooms" value=$smarty.request.searchRooms}

{if $searchRooms eq null AND $smarty.request.countRoom gt 0}
    {$searchRooms = ''}
    {for $i = 1; $i <= $smarty.request.countRoom;$i++}
        {assign var='adult' value="adult`$i`"}
        {assign var='child' value="child`$i`"}
         {if $smarty.post[$adult] > 0}
            {$searchRooms = "`$searchRooms`R:`$smarty.post[$adult]`" }
             {if $smarty.post[$child] > 0}
                 {$searchRooms = "`$searchRooms`-`$smarty.post[$child]`" }
                 {for $j = 1; $j <= $smarty.post[$child]; $j++}
                     {assign var="childAge" value="childAge`$i``$j`"}
                     {if $j eq '1'}
                         {$searchRooms = "`$searchRooms`-`$smarty.post[$childAge]`" }
                     {else}
                         {$searchRooms = "`$searchRooms`,`$smarty.post[$childAge]`" }
                     {/if}
                 {/for}
             {else}
                 {$searchRooms = "`$searchRooms`-0-0" }
             {/if}
        {/if}
    {/for}
    {else}
    {$searchRooms = $searchRooms}
{/if}


{if $searchRooms eq null}
    {$searchRooms = 'R:1-0-0'}
{/if}


{assign var="newSearchbox" value=false}

{if isset($smarty.get.type) AND $smarty.get.type == 'new'}
    {$newSearchbox = true}
{/if}
{if isset($smarty.request.nationality)}
    {assign var="nationality" value=$smarty.request.nationality}
{/if}



{assign var="numberOfRooms" value=$objFunctions->numberOfRoomsExternalHotelSearch($searchRooms)}
<code style="display:none;color:red">{$smarty.request|json_encode}</code>
<code style="display:none;color:red">{$smarty.get|json_encode}</code>
<code style="display:none;color:green">{$searchRooms|json_encode}</code>
<code style="display:none;color:brown">{$numberOfRooms|var_dump}</code>
{*<code>{$hotelIndex}</code>*}
<!-- login and register popup -->
{assign var="useType" value="newApiHotel"}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentLoginRegister.tpl"}
<!-- login and register popup -->
<div class="loaderPublicForHotel"></div>
<div class="container" id="hotelDetailContainer">
    <div class="row parent-app--new">
{*        <div id="steps">*}
{*            <div class="steps_items">*}
{*                <div class="step done ">*}

{*                    <span class=""><i class="fa fa-check"></i></span>*}
{*                    <h3>##Selectionhotel##</h3>*}
{*                </div>*}
{*                <i class="separator donetoactive"></i>*}
{*                <div class="step active">*}
{*        <span class="flat_icon_airplane">*}
{*        <svg id="Capa_1" enable-background="new 0 0 501.577 501.577" height="25" viewBox="0 0 501.577 501.577" width="25"*}
{*             xmlns="http://www.w3.org/2000/svg">*}
{*    <g>*}
{*        <path d="m441 145.789h29v105h-29z"/>*}
{*        <path d="m60 85.789h-60v387.898l60-209.999z"/>*}
{*        <path d="m86.314 280.789-60 210h420.263l55-210z"/>*}
{*        <g>*}
{*            <path d="m210.074 85.789c-19.299 0-35 15.701-35 35v20c0 19.299 15.701 35 35 35 11.095 0 21.303-5.118 28.008-14.041 4.574-6.089 6.992-13.337 6.992-20.959v-20c0-7.622-2.418-14.871-6.993-20.962-6.706-8.921-16.914-14.038-28.007-14.038z"/>*}
{*            <path d="m150.074 250.789h119.926.074v-28.82c0-10.283-4.439-20.067-12.18-26.844l-5.646-4.941c-11.675 9.932-26.667 15.605-42.174 15.605-16.086 0-30.814-5.887-42.176-15.602l-5.647 4.94c-7.737 6.773-12.177 16.557-12.177 26.841z"/>*}
{*            <path d="m410 145.789v-135h-320v240h29.901.099.074v-28.82c0-18.933 8.172-36.944 22.42-49.417l7.624-6.67c-3.245-7.725-5.044-16.202-5.044-25.093v-20c0-35.841 29.159-65 65-65 20.312 0 39.749 9.727 51.991 26.018l.002.003c8.51 11.329 13.007 24.808 13.007 38.979v20c0 8.747-1.719 17.228-5.031 25.104l7.609 6.658c14.25 12.475 22.422 30.486 22.422 49.418v28.82h110.926v-105zm-30 15h-55v-30h55zm0-60h-85v-30h85z"/>*}
{*        </g>*}
{*    </g>*}
{*</svg>*}

{*            </span>*}
{*                    <h3>##StayInformation##</h3>*}

{*                </div>*}
{*                <i class="separator"></i>*}
{*                <div class="step ">*}
{*             <span class="flat_icon_airplane">*}
{*                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="25" height="25">*}
{*    <g id="Contact_form" data-name="Contact form">*}
{*        <path d="M20.293,30.707A1,1,0,0,1,20,30v3h3a1,1,0,0,1-.707-.293Z"/>*}
{*        <path d="M21,29H20v1a1,1,0,0,1,1-1Z"/>*}
{*        <path d="M23,20.586,24.586,19H21a1,1,0,0,1,.707.293Z"/>*}
{*        <path d="M21,39H20v1a1,1,0,0,1,1-1Z"/>*}
{*        <path d="M23,30.586,24.586,29H21a1,1,0,0,1,.707.293Z"/>*}
{*        <path d="M20.293,40.707A1,1,0,0,1,20,40v3h3a1,1,0,0,1-.707-.293Z"/>*}
{*        <path d="M23,40.586,24.586,39H21a1,1,0,0,1,.707.293Z"/>*}
{*        <path d="M21,19H20v1a1,1,0,0,1,1-1Z"/>*}
{*        <path d="M49.351,35.187,52,37.836V4H14V49H47.183A7.243,7.243,0,0,1,48.331,45.5l-4.638-4.638a4.032,4.032,0,0,1,0-5.661A4.1,4.1,0,0,1,49.351,35.187ZM47,21H31a1,1,0,0,1,0-2H47a1,1,0,0,1,0,2Zm1,3a1,1,0,0,1-1,1H31a1,1,0,0,1,0-2H47A1,1,0,0,1,48,24ZM18,7a1,1,0,0,1,1-1H47a1,1,0,0,1,1,1v6a1,1,0,0,1-1,1H19a1,1,0,0,1-1-1ZM40,35H31a1,1,0,0,1,0-2h9a1,1,0,0,1,0,2Zm1,5a1,1,0,0,1-1,1H31a1,1,0,0,1,0-2h9A1,1,0,0,1,41,40ZM28.707,37.707l-5,5A1,1,0,0,1,23,43h2a1,1,0,0,1,0,2H19a1,1,0,0,1-1-1V38a1,1,0,0,1,1-1h6a1,1,0,0,1,.931.655l1.362-1.362a1,1,0,0,1,1.414,1.414Zm0-10-5,5A1,1,0,0,1,23,33h2a1,1,0,0,1,0,2H19a1,1,0,0,1-1-1V28a1,1,0,0,1,1-1h6a1,1,0,0,1,.931.655l1.362-1.362a1,1,0,0,1,1.414,1.414Zm0-10-5,5A1,1,0,0,1,23,23h2a1,1,0,0,1,0,2H19a1,1,0,0,1-1-1V18a1,1,0,0,1,1-1h6a1,1,0,0,1,.931.655l1.362-1.362a1,1,0,0,1,1.414,1.414ZM43,43a1,1,0,0,1,0,2H31a1,1,0,0,1,0-2ZM31,31a1,1,0,0,1,0-2H47a1,1,0,0,1,0,2Z"/>*}
{*        <path d="M58.01,61,58,59.616a2.985,2.985,0,0,1,.5-1.678l.653-.981A4.979,4.979,0,0,0,60,54.183v-13.7a6.959,6.959,0,0,0-2.05-4.95L54,31.584v8.252l2.427,2.427a1,1,0,0,1-1.414,1.414l-7.07-7.07a2.071,2.071,0,0,0-2.841.006,2.022,2.022,0,0,0,.008,2.833l5.247,5.247a1,1,0,0,1,.053,1.357,5.3,5.3,0,0,0-.1,6.746l.465.575a1,1,0,1,1-1.554,1.258l-.47-.58A7.3,7.3,0,0,1,47.316,51H43.905a8.915,8.915,0,0,0,1.356,6.584l.572.863A1,1,0,0,1,46,59v2Z"/>*}
{*        <rect x="20" y="8" width="26" height="4"/>*}
{*        <path d="M20.293,20.707A1,1,0,0,1,20,20v3h3a1,1,0,0,1-.707-.293Z"/>*}
{*    </g>*}
{*</svg>*}
{*             </span>*}
{*                    <h3> ##PassengersInformation## </h3>*}
{*                </div>*}
{*                <i class="separator"></i>*}
{*                <div class="step">*}
{*            <span class="flat_icon_airplane">*}
{*                <svg version="1.0" xmlns="http://www.w3.org/2000/svg"*}
{*                     width="128.000000pt" height="128.000000pt" viewBox="0 0 128.000000 128.000000"*}
{*                     preserveAspectRatio="xMidYMid meet">*}
{*<metadata>*}
{*Created by potrace 1.16, written by Peter Selinger 2001-2019*}
{*</metadata>*}
{*<g transform="translate(0.000000,128.000000) scale(0.100000,-0.100000)"*}
{*   fill="#000000" stroke="none">*}
{*<path d="M499 1247 c-223 -115 -217 -433 9 -544 73 -36 182 -38 253 -6 237*}
{*107 248 437 17 552 -52 27 -72 31 -139 31 -68 0 -85 -4 -140 -33z m276 -177*}
{*c19 -21 18 -22 -75 -115 l-94 -95 -53 52 -53 52 22 23 22 23 31 -30 31 -30 69*}
{*70 c38 39 72 70 76 70 3 0 14 -9 24 -20z"/>*}
{*<path d="M70 565 l0 -345 570 0 570 0 0 345 0 345 -104 0 -104 0 -6 -34 c-9*}
{*-47 -75 -146 -124 -184 -75 -60 -126 -77 -232 -77 -106 0 -157 17 -232 77 -49*}
{*38 -115 137 -124 184 l-6 34 -104 0 -104 0 0 -345z m980 -150 l0 -105 -145 0*}
{*-145 0 0 105 0 105 145 0 145 0 0 -105z m-410 -75 l0 -30 -205 0 -205 0 0 30*}
{*0 30 205 0 205 0 0 -30z"/>*}
{*<path d="M0 150 c0 -45 61 -120 113 -139 39 -15 1015 -15 1054 0 52 19 113 94*}
{*113 139 0 7 -207 10 -640 10 -433 0 -640 -3 -640 -10z"/>*}
{*</g>*}
{*</svg>*}
{*            </span>*}
{*                    <h3> ##Reservationhotel## </h3>*}
{*                </div>*}
{*            </div>*}
{*            <div class="counter counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"*}
{*                 style="direction: ltr">10:00</div>*}
{*        </div>*}
        <div class="parent-hotel-details--new w-100">
            <div class="box-hotel--new right_hotel_section content-detailHotel">

            </div>
            <div class="side-bar-hotel--new sidebar-detailHotel">
                <div class="filter_hotel_boxes filter_hotel_boxes_detail-internal_hotel">
{*                    {if $typeApplication eq 'api' AND $sourceId neq '17' AND $sourceId neq '29'}*}
{*                        <div class="filterBox Reserve_box_detail">*}
{*                            <div class="filtertip_hotel_detail site-bg-main-color site-bg-color-border-bottom ">*}
{*                                <p class="txt14">##Reserve##</p>*}
{*                            </div>*}
{*                            <div class="filtertip-searchbox filtertip-searchbox-box1">*}
{*                                <div class="w-100">*}
{*                                    <div class="box-reserve-hotel-fix-items-2 main-fixed-bottom-js">*}
{*                                <span>*}
{*                                    <b class="roomFinalTxt">0 ##Selectedroom## </b>*}
{*                                    ##For##  ##EachTimenight##*}
{*                                </span>*}
{*                                        <div class="parent-fixed--new">*}
{*                                            <span class="roomFinalPrice">0 <i>##Rial##</i></span>*}
{*                                            <span class="roomFinalBtn multi-rooms-price-btn-container">*}
{*                                    <button id="btnReserve" type="button" disabled="disabled"*}
{*                                            class="site-secondary-text-color site-bg-main-color "*}
{*                                            onclick="ReserveHotel()">*}
{*                                        ##Reservation##*}
{*                                        <i class="fa-solid fa-arrow-left"></i>*}
{*                                    </button>*}
{*                                        <img class="imgLoad" src="assets/images/load2.gif" id="img"/>*}
{*                                </span>*}
{*                                        </div>*}
{*                                    </div>*}
{*                                </div>*}
{*                            </div>*}
{*                        </div>*}
{*                    {/if}*}

                    <div class="filterBox filterBoxTop">
                        {if $typeApplication eq 'externalApi' OR $sourceId eq '17' or $sourceId eq '29'}
                            <input type="hidden" name="searchRooms" id="searchRooms" value="{$searchRooms}">
                        {/if}

{*                        <div class="filtertip_hotel_detail site-bg-main-color site-bg-color-border-bottom" onclick="researchAccordionBtnDetailHotel()">*}
{*                            <p class="txt14 text-center">##Repeatsearch##</p>*}
{*                            <i class="fa-solid fa-chevron-down"></i>*}
{*                        </div>*}

                        <div class="filtertip-searchbox filtertip-searchbox-box1 d-sm-flex">
                            <div class=" w-100">
                                {if $typeApplication eq 'externalApi'}
                                    <form class="search-wrapper parent-research-external-hotel-detail-sidebar" action="" method="post">
                                        <input id="typeApplication" name="typeApplication" type="hidden" value="{$typeApplication}">
                                        <input type="hidden" name="rooms" id="rooms" value="{$searchRooms}">
                                        <input type="hidden" name="searchRooms" id="searchRooms" value="{$searchRooms}">
                                        <div class="inputSearchForeign-box inputSearchForeign-pad_Fhotel">
                                            <div class="s-u-in-out-wrapper raft raft-change change-bor">
                                                <input id="destination_country" name="destination_country" type="hidden" value="">
                                                <input id="destination_city" name="destination_city" type="hidden" value="">
                                                <input id="autoComplateSearchIN" name="autoComplateSearchIN" class="inputSearchForeign" type="text"
                                                       value="" onkeyup="searchCity()">
                                                <img src="assets/images/load.gif" id="LoaderForeignDep" name="LoaderForeignDep" class="loaderSearch">
                                                <ul id="listSearchCity" class="ul-inputSearch-externalHotel displayNone"></ul>
                                            </div>
                                        </div>
                                        {assign var="classNameStartDate" value="shamsiDeptCalendarToCalculateNights"}
                                        {assign var="classNameEndDate" value="shamsiReturnCalendarToCalculateNights"}
                                        {if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || (isset($startDate) AND $startDate|substr:0:4 gt 2000)}
                                            {$classNameStartDate="deptCalendarToCalculateNights"}
                                        {/if}
                                        {if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || (isset($endDate) AND $endDate|substr:0:4 gt 2000)}
                                            {$classNameEndDate="returnCalendarToCalculateNights"}
                                        {/if}
                                        <div class="parent-data-night-room--new">
                                            <div class="form-hotel-item form-hotel-item-searchBox-date">
                                                <div class="input parent-box-input">
                                                    <div class="parent-box-calendar">
                                                        <i class="fa fa-calendar"></i>
                                                        <input type="text" placeholder="##Enterdate##" id="startDateForeign" name="startDate"
                                                               value="{$startDate}"
                                                               class="{$classNameStartDate} calendar--input">
                                                    </div>
                                                    <i class="fa fa-angle-down"></i>
                                                </div>
                                            </div>
                                            <div class="form-hotel-item form-hotel-item-searchBox-date">
                                                <div class="input parent-box-input">
                                                    <div class="parent-box-calendar">
                                                        <i class="fa fa-calendar"></i>
                                                        <input type="text" placeholder="##Exitdate##" id="endDateForeign" name="endDate"
                                                               value="{$endDate}"
                                                               class="{$classNameEndDate} calendar--input">
                                                    </div>
                                                    <i class="fa fa-angle-down"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="parent-data-night-room--new">
                                            <div class="form-hotel-item form-hotel-item-searchBox-date mt-0">
                                                <div class=" parent-box-input parent-box-input--h">
                                                    <i class="fa fa-moon"></i>
                                                    <span class="lh33 stayingTime">{$nights} ##Night## </span>
                                                    <input type="hidden" id="stayingTime" name="stayingTime" value="{$nights}"/>
                                                </div>
                                            </div>
                                            <div class="form-hotel-item  form-hotel-item-searchBox-date mart2  parent-box-input parent-box-input--h p-0">
                                                <div class="select">
                                                    <select name="countRoom" id="countRoom" class="select2">
                                                        <option value="1" {if $numberOfRooms['countRoom'] eq '1'} selected {/if}>1 ##Room##</option>
                                                        <option value="2" {if $numberOfRooms['countRoom'] eq '2'} selected {/if}>2 ##Room##</option>
                                                        <option value="3" {if $numberOfRooms['countRoom'] eq '3'} selected {/if}>3 ##Room##</option>
                                                        <option value="4" {if $numberOfRooms['countRoom'] eq '4'} selected {/if}>4 ##Room##</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div id="box-foreign-hotel-room">
                                            <div class="clrB site-main-text-color-drck box-foreign-hotel-room-item">
                                                <div class="myroom-hotel">
                                                    {foreach from=$numberOfRooms['rooms'] key=key item=room}
                                                        {assign var="count" value=$key+1}
                                                        <div class="myroom-hotel-item" data-roomNumber="{$count}">
                                                            <div class="myroom-hotel-item-title site-main-text-color">
                                                                ##Room## {$objFunctions->textNumber($count)}<span class="close"></span></div>
                                                            <div class="myroom-hotel-item-info">
                                                                <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
                                                                    <span>##Adultnumber##</span>
                                                                    <div>
                                                                        <i class="addParentEHotel fa fa-plus  site-main-text-color site-bg-color-dock-border"></i>
                                                                        <input type="text" name="adult{$count}" id="adult{$count}" readonly=""
                                                                               class="countParentEHotel" min="0" value="{$room['AdultCount']}"
                                                                               max="5">
                                                                        <i class="minusParentEHotel fa fa-minus  site-main-text-color site-bg-color-dock-border"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
                                                                    <span>##Numberofchildren##</span>
                                                                    <div>
                                                                        <i class="addChildEHotel fa fa-plus  site-main-text-color site-bg-color-dock-border"></i>
                                                                        <input type="text" readonly="" name="child{$count}" id="child{$count}"
                                                                               class="countChildEHotel" min="0" value="{$room['ChildrenCount']}"
                                                                               max="5">
                                                                        <i class="minusChildEHotel fa fa-minus  site-main-text-color site-bg-color-dock-border"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="tarikh-tavalods">
                                                                    {if $room['ChildrenCount'] neq '0'}
                                                                        {for $i=1 to $room['ChildrenCount']}
                                                                            <div class="tarikh-tavalod-item">
                                                                                <span>##Childage## <i>{$objFunctions->textNumber($i)}</i></span>
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
                                        {if $newSearchbox}
                                            <input type="hidden" id="type" name="type" value="new">
                                        {/if}
                                        {if $nationality}
                                            <input type="hidden" id="nationality" name="nationality" value="{$nationality}">
                                        {/if}
                                        <div class="form-hotel-item form-hotel-item-searchBox-btn">
                                            <span></span>
                                            <div class="input">
                                                <button class="site-bg-main-color site-secondary-text-color"
                                                        type="button"
                                                        id="searchHotelLocal"
                                                        onclick="submitSearchExternalHotel(true)">
                                                    <i class="fa-solid fa-rotate-right"></i>
                                                    ##Repeatsearch##
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                {else}
                                    <form action="" method="post" id="formHotel">
                                        <input type="hidden" value="{$requestNumber}" name="requestNumber">
                                        <input id="webServiceType" name="webServiceType" type="hidden" value="">
                                        <input id="page" name="page" type="hidden" value="">
                                        <input id="idHotel_select" name="idHotel_select" type="hidden" value="{$hotelIndex}">
                                        <input id="typeApplication" name="typeApplication" type="hidden" value="{$typeApplication}">
                                        <input id="idCity" name="idCity" type="hidden" value="">
                                        <input id="nights" name="nights" type="hidden" value="">
                                        <input id="CurrencyCode" name="CurrencyCode" type="hidden" value=""/>

                                        <div class="filtertip-searchbox filtertip-searchbox-box1 parent-research-internal-hotel-detail-sidebar">
                                            <div class="parent-counter-analog">
                                                <span class="City hotelDetailHotelName"></span>
                                                <div class="counter counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"
                                                     style="direction: ltr">10:00</div>
                                            </div>
                                            {assign var="classNameStartDate" value="hotelStartDateShamsi"}
                                            {assign var="classNameEndDate" value="hotelEndDateShamsi"}
                                            {if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || $smarty.const.SEARCH_START_DATE|substr:0:4 gt 2000}
                                                {$classNameStartDate="deptCalendarToCalculateNights"}
                                            {/if}

                                            {if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || ( isset($search_end_date) AND $search_end_date|substr:0:4 gt 2000 )}
                                                {$classNameEndDate="returnCalendarToCalculateNights"}
                                            {/if}

                                            <div class="parent-calender--new">
                                                <div class="form-hotel-item  form-hotel-item-searchBox-date">

                                                    <div class="input parent-box-input">
                                                        <div class="parent-box-calendar">
                                                            <i class="fa fa-calendar"></i>
                                                            <input type="text" placeholder=" ##Enterdate## " id="startDate"
                                                                   name="startDateForHotelLocal"
                                                                   class="{$classNameStartDate} calendar--input"
                                                                   value="">
                                                        </div>
                                                        <i class="fa fa-angle-down"></i>
                                                    </div>
                                                </div>
                                                <div class="form-hotel-item  form-hotel-item-searchBox-date">

                                                    <div class="input parent-box-input">
                                                        <div class="parent-box-calendar">
                                                            <i class="fa fa-calendar"></i>
                                                            <input type="text" placeholder="##Exitdate##" id="endDate" name="endDateForHotelLocal"
                                                                   class="{$classNameEndDate} calendar--input"
                                                                   value="{$endDate}">
                                                        </div>
                                                        <i class="fa fa-angle-down"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-hotel-item {if $sourceId eq '17' or  $sourceId eq '29'}form-hotel-item-searchBox-date{/if} parent-box--icon">
                                                <div class="">
                                                    <i class="fa fa-moon"></i>
                                                    <span class="lh35 stayingTime"> ##Night## </span>
                                                    <input type="hidden" id="stayingTime" name="stayingTime" value="1"/>
                                                </div>
                                                <div class="form-hotel-item form-hotel-item-searchBox-btn">
                                                    <span></span>
                                                    <div class="input">
                                                        <button class="site-secondary-text-colo"
                                                                type="button"
                                                                id="searchHotelLocal"
                                                                onclick="hotelDetail('{$typeApplication}', '{$hotelIndex}', '{$hotelNameEn}','{$requestNumber}')">
                                                            <i class="fa-solid fa-rotate-right"></i>
                                                            ##Repeatsearch##
                                                        </button>
                                                    </div>
                                                </div>
                                                </span>


                                            </div>
                                            {if $sourceId eq '17' or  $sourceId eq '29'}

                                                <div class="form-hotel-item  form-hotel-item-searchBox-date mart2">
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
                                                                    <div class="myroom-hotel-item-title site-main-text-color">
                                                                        ##Room## {$objFunctions->textNumber($count)}<span class="close"></span></div>
                                                                    <div class="myroom-hotel-item-info">
                                                                        <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
                                                                            <span>##Adultnumber##<i>(12 ##yearsandup##)</i></span>
                                                                            <div>
                                                                                <i class="addParentEHotel fa fa-plus  site-main-text-color site-bg-color-dock-border"></i>
                                                                                <input type="text" name="adult{$count}" id="adult{$count}" readonly=""
                                                                                       class="countParentEHotel" min="0" value="{$room['AdultCount']}"
                                                                                       max="5">
                                                                                <i class="minusParentEHotel fa fa-minus  site-main-text-color site-bg-color-dock-border"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
                                                                            <span>##Numberofchildren##<i>(##Under## 12 ##Year##)</i></span>
                                                                            <div>
                                                                                <i class="addChildEHotel fa fa-plus  site-main-text-color site-bg-color-dock-border"></i>
                                                                                <input type="text" readonly="" name="child{$count}" id="child{$count}"
                                                                                       class="countChildEHotel" min="0" value="{$room['ChildrenCount']}"
                                                                                       max="5">
                                                                                <i class="minusChildEHotel fa fa-minus  site-main-text-color site-bg-color-dock-border"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="tarikh-tavalods">
                                                                            {if $room['ChildrenCount'] neq '0'}
                                                                                {for $i=1 to $room['ChildrenCount']}
                                                                                    <div class="tarikh-tavalod-item">
                                                                                        <span>##Childage## <i>{$objFunctions->textNumber($i)}</i></span>
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

                                            {/if}

                                        </div>

                                    </form>
                                {/if}
                            </div>
                        </div>
                        {if $typeApplication eq 'api' AND $sourceId neq '17' AND $sourceId neq '29'}
                        <div class="box-reserve-hotel-fix-items-2">
                            <span class="City">صورتحساب  شما</span>
                            <div class="parent--price">
                                <div class="box--price">
                                    <p class="roomFinalTxt">0 اتاق </p>
                                </div>
                                <h6 class="roomFinalPrice site-main-text-color">0 <i>##Rial##</i></h6>
                            </div>

                            {if $objResult->SearchHotel.prepayment_percentage gt 0}
                                <div class="parent-advance--payment">
                                    <p>  {$objResult->SearchHotel.prepayment_percentage} % پیش پرداخت</p>
                                    <h6 class='roomFinalPrepaymentPackagePrice'></h6>
                                </div>
                            {/if}
                            <span class="roomFinalBtn multi-rooms-price-btn-container">
                                    <button id="btnReserve" type="button" class="site-secondary-text-color site-bg-main-color " onclick="ReserveHotel()" aaaaaaaaaaaaaaaaa>
                                        ##Reservation##
                                        <i class="fa-solid fa-arrow-left"></i>
                                    </button>
                                        <img class="imgLoad" src="https://192.168.1.100/gds/view/client/assets/images/load2.gif" id="img">
                                </span>
                        </div>
                        {/if}
                    </div>
                </div>

                <script src="assets/js/scrollWithPage.min.js"></script>
                {*            <script>*}
                {*              if($(window).width() > 990){*}
                {*                $(".filter_hotel_boxes").scrollWithPage(".sidebar-detailHotel");*}
                {*              }*}
                {*            </script>*}


            </div>
            <input type="hidden" id='ThisHotelResult' value='' name="ThisHotelResult">
            <input type="hidden" id='ThisPricesResult' value='' name="ThisPricesResult">
            <!-- LIST CONTENT-->
        </div>
    </div>
</div>
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`hotelTimeoutModal.tpl"}
{if $requestNumber eq '' }
    {assign var="paramDetail" value=[
    'flag'=>'directDetailHotel',
    'StartDate'=>$smarty.post.startDateForHotelLocal,
    'EndDate'=>$smarty.post.endDateForHotelLocal,
    'hotelIndex'=>$hotelIndex,
    'searchRooms' => $searchRooms,
    'typeApplication' => $typeApplication,
    'lang'=>$smarty.const.SOFTWARE_LANG]}
    <input type="hidden" value='{$objFunctions->clearJsonHiddenCharacters($paramDetail|json_encode:256)}' id="dataDetailHotel">
{else}
    {assign var="paramDetail" value=[
    'flag'=>'detailHotel',
    'hotelIndex'=>$hotelIndex,
    'requestNumber'=>$requestNumber,
    'searchRooms' => $searchRooms,
    'typeApplication' => $typeApplication,
    'lang'=>$smarty.const.SOFTWARE_LANG]}
    <input type="hidden" value='{$objFunctions->clearJsonHiddenCharacters($paramDetail|json_encode:256)}' id="dataDetailHotel">
{/if}
{literal}
    <script type="text/javascript" src="assets/js/modal-login.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
          integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
            integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
{/literal}

{literal}
    <script src="assets/js/html5gallery.js"></script>
    <script src="assets/js/jquery.fancybox.min.js"></script>
    <script src="assets/js/scrollWithPage.min.js"></script>
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

        $("body").delegate(".showCancelRule", "click", function () {
            let roomId = $(this).data("roomindex");
            $("#btnCancelRule-" + roomId).removeClass('showCancelRule').addClass('hideCancelRule').css('opacity', '0.5').css('cursor', 'progress');
            $("#btnCancelRule-" + roomId + " i").removeClass("fa fa-angle-down").addClass("fa fa-angle-up");
            $("#boxCancelRule-" + roomId).removeClass('displayiN');
            $("#btnCancelRule-" + roomId).css('opacity', '1').css('cursor', 'pointer');
        });
        $("body").delegate(".hideCancelRule", "click", function () {
            let roomId = $(this).data("roomindex");
            $("#boxCancelRule-" + roomId).addClass('displayiN');
            $("#btnCancelRule-" + roomId).removeClass('hideCancelRule').addClass('showCancelRule').css('opacity', '1').css('cursor', 'pointer');
            $("#btnCancelRule-" + roomId + " i").removeClass("fa fa-angle-up").addClass("fa fa-angle-down");
        });



    </script>
{/literal}

