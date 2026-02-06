{load_presentation_object filename="passengersDetailLocal" assign="objDetail"}
{load_presentation_object filename="members" assign="objMember"}
{load_presentation_object filename="redirectBank" assign="objRedirectBank"}

{$objDetail->getCustomers()}
{$objMember->get()}

{assign var="redirectBank" value=$objRedirectBank->redirectBankUrls()}

{if $smarty.const.SOFTWARE_LANG === 'en'}
    {assign var="countryTitleName" value="titleEn"}
{else}
    {assign var="countryTitleName" value="titleFa"}
{/if}
<div id="lightboxContainer" class="lightboxContainerOpacity"></div>
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentLoginRegister.tpl" useType="exclusiveTour"}
<!-- last passenger list -->
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`passengerPopup.tpl"}
<!--end  last passenger list -->
<div id="steps">
    <div class="steps_items">
        <div class="step done">

            <span class="">
                <i class="fa fa-check"></i>
            </span>

            <h3>##SelectionExclusiveTour##</h3>

        </div>
        <i class="separator donetoactive"></i>
        <div class="step active">
            <span class="flat_icon_airplane">
                <svg width="26" height="26" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                    <g fill="currentColor">
                        <path d="M32 4C22.6 4 15 11.6 15 21c0 12.7 15.3 31.4 16 32.2a1.5 1.5 0 0 0 2 0C33.7 52.4 49 33.7 49 21 49 11.6 41.4 4 32 4zm0 24a7 7 0 1 1 0-14 7 7 0 0 1 0 14z"/>
                        <rect x="8" y="40" width="48" height="3" rx="1.5"/>
                        <circle cx="22" cy="41.5" r="4"/>
                        <rect x="8" y="50" width="48" height="3" rx="1.5"/>
                        <circle cx="42" cy="51.5" r="4"/>
                    </g>
                </svg>
            </span>
            <h3>##TourSpecifications##</h3>
        </div>
        <i class="separator"></i>
        <div class="step">
            <span class="flat_icon_airplane">
                            <svg id="Capa_1" enable-background="new 0 0 501.577 501.577" height="25" viewBox="0 0 501.577 501.577" width="25"
                                 xmlns="http://www.w3.org/2000/svg">
                            <g>
                            <path d="m441 145.789h29v105h-29z"/>
                            <path d="m60 85.789h-60v387.898l60-209.999z"/>
                            <path d="m86.314 280.789-60 210h420.263l55-210z"/>
                            <g>
                                <path d="m210.074 85.789c-19.299 0-35 15.701-35 35v20c0 19.299 15.701 35 35 35 11.095 0 21.303-5.118 28.008-14.041 4.574-6.089 6.992-13.337 6.992-20.959v-20c0-7.622-2.418-14.871-6.993-20.962-6.706-8.921-16.914-14.038-28.007-14.038z"/>
                                <path d="m150.074 250.789h119.926.074v-28.82c0-10.283-4.439-20.067-12.18-26.844l-5.646-4.941c-11.675 9.932-26.667 15.605-42.174 15.605-16.086 0-30.814-5.887-42.176-15.602l-5.647 4.94c-7.737 6.773-12.177 16.557-12.177 26.841z"/>
                                <path d="m410 145.789v-135h-320v240h29.901.099.074v-28.82c0-18.933 8.172-36.944 22.42-49.417l7.624-6.67c-3.245-7.725-5.044-16.202-5.044-25.093v-20c0-35.841 29.159-65 65-65 20.312 0 39.749 9.727 51.991 26.018l.002.003c8.51 11.329 13.007 24.808 13.007 38.979v20c0 8.747-1.719 17.228-5.031 25.104l7.609 6.658c14.25 12.475 22.422 30.486 22.422 49.418v28.82h110.926v-105zm-30 15h-55v-30h55zm0-60h-85v-30h85z"/>
                            </g>
                        </g>
                    </svg>

            </span>
            <h3>##PassengersInformation##</h3>

        </div>
        <i class="separator"></i>
        <div class="step " >
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
            <h3> ##Approvefinal## </h3>
        </div>
        <i class="separator"></i>
        <div class="step" >
            <span class="flat_icon_airplane">
                <svg  enable-background="new 0 0 512 512" height="25" viewBox="0 0 512 512" width="25"
                      xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <g>
                            <path d="m497 91h-331c-8.28 0-15 6.72-15 15 0 8.27-6.73 15-15 15s-15-6.73-15-15c0-8.28-6.72-15-15-15h-91c-8.28 0-15 6.72-15 15v300c0 8.28 6.72 15 15 15h91c8.28 0 15-6.72 15-15 0-8.27 6.73-15 15-15s15 6.73 15 15c0 8.28 6.72 15 15 15h331c8.28 0 15-6.72 15-15v-300c0-8.28-6.72-15-15-15zm-361 210h-61c-8.28 0-15-6.72-15-15s6.72-15 15-15h61c8.28 0 15 6.72 15 15s-6.72 15-15 15zm60-60h-121c-8.28 0-15-6.72-15-15s6.72-15 15-15h121c8.28 0 15 6.72 15 15s-6.72 15-15 15zm250.61 85.61c-5.825 5.825-15.339 5.882-21.22 0l-64.39-64.4v47.57l25.61 25.61c5.85 5.86 5.85 15.36 0 21.22-5.825 5.825-15.339 5.882-21.22 0l-19.39-19.4-19.39 19.4c-5.86 5.85-15.36 5.85-21.22 0-5.85-5.86-5.85-15.36 0-21.22l25.61-25.61v-47.57l-64.39 64.4c-5.86 5.85-15.36 5.85-21.22 0-5.85-5.86-5.85-15.36 0-21.22l85.61-85.61v-53.78c0-8.28 6.72-15 15-15s15 6.72 15 15v53.78l85.61 85.61c5.85 5.86 5.85 15.36 0 21.22z"/>
                        </g>
                    </g>
                </svg>
            </span>
            <h3> ##TicketReservation## </h3>
        </div>
    </div>
</div>

<div class="parent-hotel-details--new w-100">
    <div class="box-hotel--new right_hotel_section content-detailHotel">

    </div>
    <div class="side-bar-hotel--new sidebar-detailHotel">
{*        <div class="filter_hotel_boxes filter_hotel_boxes_detail-internal_hotel">*}
{*            *}{*                    {if $typeApplication eq 'api' AND $sourceId neq '17' AND $sourceId neq '29'}*}
{*            *}{*                        <div class="filterBox Reserve_box_detail">*}
{*            *}{*                            <div class="filtertip_hotel_detail site-bg-main-color site-bg-color-border-bottom ">*}
{*            *}{*                                <p class="txt14">##Reserve##</p>*}
{*            *}{*                            </div>*}
{*            *}{*                            <div class="filtertip-searchbox filtertip-searchbox-box1">*}
{*            *}{*                                <div class="w-100">*}
{*            *}{*                                    <div class="box-reserve-hotel-fix-items-2 main-fixed-bottom-js">*}
{*            *}{*                                <span>*}
{*            *}{*                                    <b class="roomFinalTxt">0 ##Selectedroom## </b>*}
{*            *}{*                                    ##For##  ##EachTimenight##*}
{*            *}{*                                </span>*}
{*            *}{*                                        <div class="parent-fixed--new">*}
{*            *}{*                                            <span class="roomFinalPrice">0 <i>##Rial##</i></span>*}
{*            *}{*                                            <span class="roomFinalBtn multi-rooms-price-btn-container">*}
{*            *}{*                                    <button id="btnReserve" type="button" disabled="disabled"*}
{*            *}{*                                            class="site-secondary-text-color site-bg-main-color "*}
{*            *}{*                                            onclick="ReserveHotel()">*}
{*            *}{*                                        ##Reservation##*}
{*            *}{*                                        <i class="fa-solid fa-arrow-left"></i>*}
{*            *}{*                                    </button>*}
{*            *}{*                                        <img class="imgLoad" src="assets/images/load2.gif" id="img"/>*}
{*            *}{*                                </span>*}
{*            *}{*                                        </div>*}
{*            *}{*                                    </div>*}
{*            *}{*                                </div>*}
{*            *}{*                            </div>*}
{*            *}{*                        </div>*}
{*            *}{*                    {/if}*}

{*            <div class="filterBox filterBoxTop">*}
{*                {if $typeApplication eq 'externalApi' OR $sourceId eq '17' or $sourceId eq '29'}*}
{*                    <input type="hidden" name="searchRooms" id="searchRooms" value="{$searchRooms}">*}
{*                {/if}*}

{*                *}{*                        <div class="filtertip_hotel_detail site-bg-main-color site-bg-color-border-bottom" onclick="researchAccordionBtnDetailHotel()">*}
{*                *}{*                            <p class="txt14 text-center">##Repeatsearch##</p>*}
{*                *}{*                            <i class="fa-solid fa-chevron-down"></i>*}
{*                *}{*                        </div>*}

{*                <div class="filtertip-searchbox filtertip-searchbox-box1 d-sm-flex">*}
{*                    <div class=" w-100">*}
{*                        {if $typeApplication eq 'externalApi'}*}
{*                            <form class="search-wrapper parent-research-external-hotel-detail-sidebar" action="" method="post">*}
{*                                <input id="typeApplication" name="typeApplication" type="hidden" value="{$typeApplication}">*}
{*                                <input type="hidden" name="rooms" id="rooms" value="{$searchRooms}">*}
{*                                <input type="hidden" name="searchRooms" id="searchRooms" value="{$searchRooms}">*}
{*                                <div class="inputSearchForeign-box inputSearchForeign-pad_Fhotel">*}
{*                                    <div class="s-u-in-out-wrapper raft raft-change change-bor">*}
{*                                        <input id="destination_country" name="destination_country" type="hidden" value="">*}
{*                                        <input id="destination_city" name="destination_city" type="hidden" value="">*}
{*                                        <input id="autoComplateSearchIN" name="autoComplateSearchIN" class="inputSearchForeign" type="text"*}
{*                                               value="" onkeyup="searchCity()">*}
{*                                        <img src="assets/images/load.gif" id="LoaderForeignDep" name="LoaderForeignDep" class="loaderSearch">*}
{*                                        <ul id="listSearchCity" class="ul-inputSearch-externalHotel displayNone"></ul>*}
{*                                    </div>*}
{*                                </div>*}
{*                                {assign var="classNameStartDate" value="shamsiDeptCalendarToCalculateNights"}*}
{*                                {assign var="classNameEndDate" value="shamsiReturnCalendarToCalculateNights"}*}
{*                                {if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || (isset($startDate) AND $startDate|substr:0:4 gt 2000)}*}
{*                                    {$classNameStartDate="deptCalendarToCalculateNights"}*}
{*                                {/if}*}
{*                                {if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || (isset($endDate) AND $endDate|substr:0:4 gt 2000)}*}
{*                                    {$classNameEndDate="returnCalendarToCalculateNights"}*}
{*                                {/if}*}
{*                                <div class="parent-data-night-room--new">*}
{*                                    <div class="form-hotel-item form-hotel-item-searchBox-date">*}
{*                                        <div class="input parent-box-input">*}
{*                                            <div class="parent-box-calendar">*}
{*                                                <i class="fa fa-calendar"></i>*}
{*                                                <input type="text" placeholder="##Enterdate##" id="startDateForeign" name="startDate"*}
{*                                                       value="{$startDate}"*}
{*                                                       class="{$classNameStartDate} calendar--input">*}
{*                                            </div>*}
{*                                            <i class="fa fa-angle-down"></i>*}
{*                                        </div>*}
{*                                    </div>*}
{*                                    <div class="form-hotel-item form-hotel-item-searchBox-date">*}
{*                                        <div class="input parent-box-input">*}
{*                                            <div class="parent-box-calendar">*}
{*                                                <i class="fa fa-calendar"></i>*}
{*                                                <input type="text" placeholder="##Exitdate##" id="endDateForeign" name="endDate"*}
{*                                                       value="{$endDate}"*}
{*                                                       class="{$classNameEndDate} calendar--input">*}
{*                                            </div>*}
{*                                            <i class="fa fa-angle-down"></i>*}
{*                                        </div>*}
{*                                    </div>*}
{*                                </div>*}
{*                                <div class="parent-data-night-room--new">*}
{*                                    <div class="form-hotel-item form-hotel-item-searchBox-date mt-0">*}
{*                                        <div class=" parent-box-input parent-box-input--h">*}
{*                                            <i class="fa fa-moon"></i>*}
{*                                            <span class="lh33 stayingTime">{$nights} ##Night## </span>*}
{*                                            <input type="hidden" id="stayingTime" name="stayingTime" value="{$nights}"/>*}
{*                                        </div>*}
{*                                    </div>*}
{*                                    <div class="form-hotel-item  form-hotel-item-searchBox-date mart2  parent-box-input parent-box-input--h p-0">*}
{*                                        <div class="select">*}
{*                                            <select name="countRoom" id="countRoom" class="select2">*}
{*                                                <option value="1" {if $numberOfRooms['countRoom'] eq '1'} selected {/if}>1 ##Room##</option>*}
{*                                                <option value="2" {if $numberOfRooms['countRoom'] eq '2'} selected {/if}>2 ##Room##</option>*}
{*                                                <option value="3" {if $numberOfRooms['countRoom'] eq '3'} selected {/if}>3 ##Room##</option>*}
{*                                                <option value="4" {if $numberOfRooms['countRoom'] eq '4'} selected {/if}>4 ##Room##</option>*}
{*                                            </select>*}
{*                                        </div>*}
{*                                    </div>*}
{*                                </div>*}


{*                                <div id="box-foreign-hotel-room">*}
{*                                    <div class="clrB site-main-text-color-drck box-foreign-hotel-room-item">*}
{*                                        <div class="myroom-hotel">*}
{*                                            {foreach from=$numberOfRooms['rooms'] key=key item=room}*}
{*                                                {assign var="count" value=$key+1}*}
{*                                                <div class="myroom-hotel-item" data-roomNumber="{$count}">*}
{*                                                    <div class="myroom-hotel-item-title site-main-text-color">*}
{*                                                        ##Room## {$objFunctions->textNumber($count)}<span class="close"></span></div>*}
{*                                                    <div class="myroom-hotel-item-info">*}
{*                                                        <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">*}
{*                                                            <span>##Adultnumber##</span>*}
{*                                                            <div>*}
{*                                                                <i class="addParentEHotel fa fa-plus  site-main-text-color site-bg-color-dock-border"></i>*}
{*                                                                <input type="text" name="adult{$count}" id="adult{$count}" readonly=""*}
{*                                                                       class="countParentEHotel" min="0" value="{$room['AdultCount']}"*}
{*                                                                       max="5">*}
{*                                                                <i class="minusParentEHotel fa fa-minus  site-main-text-color site-bg-color-dock-border"></i>*}
{*                                                            </div>*}
{*                                                        </div>*}
{*                                                        <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">*}
{*                                                            <span>##Numberofchildren##</span>*}
{*                                                            <div>*}
{*                                                                <i class="addChildEHotel fa fa-plus  site-main-text-color site-bg-color-dock-border"></i>*}
{*                                                                <input type="text" readonly="" name="child{$count}" id="child{$count}"*}
{*                                                                       class="countChildEHotel" min="0" value="{$room['ChildrenCount']}"*}
{*                                                                       max="5">*}
{*                                                                <i class="minusChildEHotel fa fa-minus  site-main-text-color site-bg-color-dock-border"></i>*}
{*                                                            </div>*}
{*                                                        </div>*}
{*                                                        <div class="tarikh-tavalods">*}
{*                                                            {if $room['ChildrenCount'] neq '0'}*}
{*                                                                {for $i=1 to $room['ChildrenCount']}*}
{*                                                                    <div class="tarikh-tavalod-item">*}
{*                                                                        <span>##Childage## <i>{$objFunctions->textNumber($i)}</i></span>*}
{*                                                                        <select id="childAge{$count}{$i}" name="childAge{$count}{$i}">*}
{*                                                                            <option value="1"*}
{*                                                                                    {if {$room['ChildrenAge'][$i-1]} eq '1'}selected{/if}>*}
{*                                                                                0 ##To## 1 ##Year##*}
{*                                                                            </option>*}
{*                                                                            <option value="2"*}
{*                                                                                    {if {$room['ChildrenAge'][$i-1]} eq '2'}selected{/if}>*}
{*                                                                                1 ##To## 2 ##Year##*}
{*                                                                            </option>*}
{*                                                                            <option value="3"*}
{*                                                                                    {if {$room['ChildrenAge'][$i-1]} eq '3'}selected{/if}>*}
{*                                                                                2 ##To## 3 ##Year##*}
{*                                                                            </option>*}
{*                                                                            <option value="4"*}
{*                                                                                    {if {$room['ChildrenAge'][$i-1]} eq '4'}selected{/if}>*}
{*                                                                                3 ##To## 4 ##Year##*}
{*                                                                            </option>*}
{*                                                                            <option value="5"*}
{*                                                                                    {if {$room['ChildrenAge'][$i-1]} eq '5'}selected{/if}>*}
{*                                                                                4 ##To## 5 ##Year##*}
{*                                                                            </option>*}
{*                                                                            <option value="6"*}
{*                                                                                    {if {$room['ChildrenAge'][$i-1]} eq '6'}selected{/if}>*}
{*                                                                                5 ##To## 6 ##Year##*}
{*                                                                            </option>*}
{*                                                                            <option value="7"*}
{*                                                                                    {if {$room['ChildrenAge'][$i-1]} eq '7'}selected{/if}>*}
{*                                                                                6 ##To## 7 ##Year##*}
{*                                                                            </option>*}
{*                                                                            <option value="8"*}
{*                                                                                    {if {$room['ChildrenAge'][$i-1]} eq '8'}selected{/if}>*}
{*                                                                                7 ##To## 8 ##Year##*}
{*                                                                            </option>*}
{*                                                                            <option value="9"*}
{*                                                                                    {if {$room['ChildrenAge'][$i-1]} eq '9'}selected{/if}>*}
{*                                                                                8 ##To## 9 ##Year##*}
{*                                                                            </option>*}
{*                                                                            <option value="10"*}
{*                                                                                    {if {$room['ChildrenAge'][$i-1]} eq '10'}selected{/if}>*}
{*                                                                                9 ##To## 10 ##Year##*}
{*                                                                            </option>*}
{*                                                                            <option value="11"*}
{*                                                                                    {if {$room['ChildrenAge'][$i-1]} eq '11'}selected{/if}>*}
{*                                                                                10 ##To## 11 ##Year##*}
{*                                                                            </option>*}
{*                                                                            <option value="12"*}
{*                                                                                    {if {$room['ChildrenAge'][$i-1]} eq '12'}selected{/if}>*}
{*                                                                                11 ##To## 12 ##Year##*}
{*                                                                            </option>*}
{*                                                                        </select>*}
{*                                                                    </div>*}
{*                                                                {/for}*}
{*                                                            {/if}*}
{*                                                        </div>*}
{*                                                    </div>*}
{*                                                </div>*}
{*                                            {/foreach}*}
{*                                        </div>*}
{*                                    </div>*}
{*                                </div>*}
{*                                {if $newSearchbox}*}
{*                                    <input type="hidden" id="type" name="type" value="new">*}
{*                                {/if}*}
{*                                {if $nationality}*}
{*                                    <input type="hidden" id="nationality" name="nationality" value="{$nationality}">*}
{*                                {/if}*}
{*                                <div class="form-hotel-item  form-hotel-item-searchBox-btn">*}
{*                                    <span></span>*}
{*                                    <div class="input">*}
{*                                        <button class="site-bg-main-color site-secondary-text-color"*}
{*                                                type="button" id="searchHotelLocal" onclick="submitSearchExternalHotel(true)">##Repeatsearch##*}
{*                                        </button>*}
{*                                    </div>*}
{*                                </div>*}
{*                            </form>*}
{*                        {else}*}
{*                            <form action="" method="post" id="formHotel">*}
{*                                <input type="hidden" value="{$requestNumber}" name="requestNumber">*}
{*                                <input id="webServiceType" name="webServiceType" type="hidden" value="">*}
{*                                <input id="page" name="page" type="hidden" value="">*}
{*                                <input id="idHotel_select" name="idHotel_select" type="hidden" value="{$hotelIndex}">*}
{*                                <input id="typeApplication" name="typeApplication" type="hidden" value="{$typeApplication}">*}
{*                                <input id="idCity" name="idCity" type="hidden" value="">*}
{*                                <input id="nights" name="nights" type="hidden" value="">*}
{*                                <input id="CurrencyCode" name="CurrencyCode" type="hidden" value=""/>*}

{*                                <div class="filtertip-searchbox filtertip-searchbox-box1 parent-research-internal-hotel-detail-sidebar">*}
{*                                    <div class="parent-counter-analog">*}
{*                                        <span class="City hotelDetailHotelName"></span>*}
{*                                        <div class="counter counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"*}
{*                                             style="direction: ltr">10:00</div>*}
{*                                    </div>*}
{*                                    {assign var="classNameStartDate" value="hotelStartDateShamsi"}*}
{*                                    {assign var="classNameEndDate" value="hotelEndDateShamsi"}*}
{*                                    {if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || $smarty.const.SEARCH_START_DATE|substr:0:4 gt 2000}*}
{*                                        {$classNameStartDate="deptCalendarToCalculateNights"}*}
{*                                    {/if}*}

{*                                    {if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || ( isset($search_end_date) AND $search_end_date|substr:0:4 gt 2000 )}*}
{*                                        {$classNameEndDate="returnCalendarToCalculateNights"}*}
{*                                    {/if}*}

{*                                    <div class="parent-calender--new">*}
{*                                        <div class="form-hotel-item  form-hotel-item-searchBox-date">*}

{*                                            <div class="input parent-box-input">*}
{*                                                <div class="parent-box-calendar">*}
{*                                                    <i class="fa fa-calendar"></i>*}
{*                                                    <input type="text" placeholder=" ##Enterdate## " id="startDate"*}
{*                                                           name="startDateForHotelLocal"*}
{*                                                           class="{$classNameStartDate} calendar--input"*}
{*                                                           value="">*}
{*                                                </div>*}
{*                                                <i class="fa fa-angle-down"></i>*}
{*                                            </div>*}
{*                                        </div>*}
{*                                        <div class="form-hotel-item  form-hotel-item-searchBox-date">*}

{*                                            <div class="input parent-box-input">*}
{*                                                <div class="parent-box-calendar">*}
{*                                                    <i class="fa fa-calendar"></i>*}
{*                                                    <input type="text" placeholder="##Exitdate##" id="endDate" name="endDateForHotelLocal"*}
{*                                                           class="{$classNameEndDate} calendar--input"*}
{*                                                           value="{$endDate}">*}
{*                                                </div>*}
{*                                                <i class="fa fa-angle-down"></i>*}
{*                                            </div>*}
{*                                        </div>*}
{*                                    </div>*}

{*                                    <div class="form-hotel-item {if $sourceId eq '17' or  $sourceId eq '29'}form-hotel-item-searchBox-date{/if} parent-box--icon">*}
{*                                        <div class="">*}
{*                                            <i class="fa fa-moon"></i>*}
{*                                            <span class="lh35 stayingTime"> ##Night## </span>*}
{*                                            <input type="hidden" id="stayingTime" name="stayingTime" value="1"/>*}
{*                                        </div>*}
{*                                        <div class="form-hotel-item  form-hotel-item-searchBox-btn">*}
{*                                            <span></span>*}
{*                                            <div class="input">*}
{*                                                <button class="site-secondary-text-colo" type="button" id="searchHotelLocal"*}
{*                                                        onclick="hotelDetail('{$typeApplication}', '{$hotelIndex}', '{$hotelNameEn}','{$requestNumber}')">*}
{*                                                    ##Repeatsearch##*}
{*                                                </button>*}
{*                                            </div>*}
{*                                        </div>*}
{*                                        </span>*}


{*                                    </div>*}
{*                                    {if $sourceId eq '17' or  $sourceId eq '29'}*}

{*                                        <div class="form-hotel-item  form-hotel-item-searchBox-date mart2">*}
{*                                            <div class="select">*}
{*                                                <select name="countRoom" id="countRoom" class="select2">*}
{*                                                    <option value="1" {if $numberOfRooms['countRoom'] eq '1'} selected {/if}>1 ##Room##</option>*}
{*                                                    <option value="2" {if $numberOfRooms['countRoom'] eq '2'} selected {/if}>2 ##Room##</option>*}
{*                                                    <option value="3" {if $numberOfRooms['countRoom'] eq '3'} selected {/if}>3 ##Room##</option>*}
{*                                                    <option value="4" {if $numberOfRooms['countRoom'] eq '4'} selected {/if}>4 ##Room##</option>*}
{*                                                </select>*}
{*                                            </div>*}
{*                                        </div>*}
{*                                        <div id="box-foreign-hotel-room">*}
{*                                            <div class="clrB site-main-text-color-drck box-foreign-hotel-room-item">*}
{*                                                <div class="myroom-hotel">*}
{*                                                    {foreach from=$numberOfRooms['rooms'] key=key item=room}*}
{*                                                        {assign var="count" value=$key+1}*}
{*                                                        <div class="myroom-hotel-item" data-roomNumber="{$count}">*}
{*                                                            <div class="myroom-hotel-item-title site-main-text-color">*}
{*                                                                ##Room## {$objFunctions->textNumber($count)}<span class="close"></span></div>*}
{*                                                            <div class="myroom-hotel-item-info">*}
{*                                                                <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">*}
{*                                                                    <span>##Adultnumber##<i>(12 ##yearsandup##)</i></span>*}
{*                                                                    <div>*}
{*                                                                        <i class="addParentEHotel fa fa-plus  site-main-text-color site-bg-color-dock-border"></i>*}
{*                                                                        <input type="text" name="adult{$count}" id="adult{$count}" readonly=""*}
{*                                                                               class="countParentEHotel" min="0" value="{$room['AdultCount']}"*}
{*                                                                               max="5">*}
{*                                                                        <i class="minusParentEHotel fa fa-minus  site-main-text-color site-bg-color-dock-border"></i>*}
{*                                                                    </div>*}
{*                                                                </div>*}
{*                                                                <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">*}
{*                                                                    <span>##Numberofchildren##<i>(##Under## 12 ##Year##)</i></span>*}
{*                                                                    <div>*}
{*                                                                        <i class="addChildEHotel fa fa-plus  site-main-text-color site-bg-color-dock-border"></i>*}
{*                                                                        <input type="text" readonly="" name="child{$count}" id="child{$count}"*}
{*                                                                               class="countChildEHotel" min="0" value="{$room['ChildrenCount']}"*}
{*                                                                               max="5">*}
{*                                                                        <i class="minusChildEHotel fa fa-minus  site-main-text-color site-bg-color-dock-border"></i>*}
{*                                                                    </div>*}
{*                                                                </div>*}
{*                                                                <div class="tarikh-tavalods">*}
{*                                                                    {if $room['ChildrenCount'] neq '0'}*}
{*                                                                        {for $i=1 to $room['ChildrenCount']}*}
{*                                                                            <div class="tarikh-tavalod-item">*}
{*                                                                                <span>##Childage## <i>{$objFunctions->textNumber($i)}</i></span>*}
{*                                                                                <select id="childAge{$count}{$i}" name="childAge{$count}{$i}">*}
{*                                                                                    <option value="1"*}
{*                                                                                            {if {$room['ChildrenAge'][$i-1]} eq '1'}selected{/if}>*}
{*                                                                                        0 ##To## 1 ##Year##*}
{*                                                                                    </option>*}
{*                                                                                    <option value="2"*}
{*                                                                                            {if {$room['ChildrenAge'][$i-1]} eq '2'}selected{/if}>*}
{*                                                                                        1 ##To## 2 ##Year##*}
{*                                                                                    </option>*}
{*                                                                                    <option value="3"*}
{*                                                                                            {if {$room['ChildrenAge'][$i-1]} eq '3'}selected{/if}>*}
{*                                                                                        2 ##To## 3 ##Year##*}
{*                                                                                    </option>*}
{*                                                                                    <option value="4"*}
{*                                                                                            {if {$room['ChildrenAge'][$i-1]} eq '4'}selected{/if}>*}
{*                                                                                        3 ##To## 4 ##Year##*}
{*                                                                                    </option>*}
{*                                                                                    <option value="5"*}
{*                                                                                            {if {$room['ChildrenAge'][$i-1]} eq '5'}selected{/if}>*}
{*                                                                                        4 ##To## 5 ##Year##*}
{*                                                                                    </option>*}
{*                                                                                    <option value="6"*}
{*                                                                                            {if {$room['ChildrenAge'][$i-1]} eq '6'}selected{/if}>*}
{*                                                                                        5 ##To## 6 ##Year##*}
{*                                                                                    </option>*}
{*                                                                                    <option value="7"*}
{*                                                                                            {if {$room['ChildrenAge'][$i-1]} eq '7'}selected{/if}>*}
{*                                                                                        6 ##To## 7 ##Year##*}
{*                                                                                    </option>*}
{*                                                                                    <option value="8"*}
{*                                                                                            {if {$room['ChildrenAge'][$i-1]} eq '8'}selected{/if}>*}
{*                                                                                        7 ##To## 8 ##Year##*}
{*                                                                                    </option>*}
{*                                                                                    <option value="9"*}
{*                                                                                            {if {$room['ChildrenAge'][$i-1]} eq '9'}selected{/if}>*}
{*                                                                                        8 ##To## 9 ##Year##*}
{*                                                                                    </option>*}
{*                                                                                    <option value="10"*}
{*                                                                                            {if {$room['ChildrenAge'][$i-1]} eq '10'}selected{/if}>*}
{*                                                                                        9 ##To## 10 ##Year##*}
{*                                                                                    </option>*}
{*                                                                                    <option value="11"*}
{*                                                                                            {if {$room['ChildrenAge'][$i-1]} eq '11'}selected{/if}>*}
{*                                                                                        10 ##To## 11 ##Year##*}
{*                                                                                    </option>*}
{*                                                                                    <option value="12"*}
{*                                                                                            {if {$room['ChildrenAge'][$i-1]} eq '12'}selected{/if}>*}
{*                                                                                        11 ##To## 12 ##Year##*}
{*                                                                                    </option>*}
{*                                                                                </select>*}
{*                                                                            </div>*}
{*                                                                        {/for}*}
{*                                                                    {/if}*}
{*                                                                </div>*}
{*                                                            </div>*}
{*                                                        </div>*}
{*                                                    {/foreach}*}
{*                                                </div>*}
{*                                            </div>*}
{*                                        </div>*}

{*                                    {/if}*}

{*                                </div>*}

{*                            </form>*}
{*                        {/if}*}
{*                    </div>*}
{*                </div>*}
{*                {if $typeApplication eq 'api' AND $sourceId neq '17' AND $sourceId neq '29'}*}
{*                    <div class="box-reserve-hotel-fix-items-2">*}
{*                        <span class="City">صورتحساب  شما</span>*}
{*                        <div class="parent--price">*}
{*                            <div class="box--price">*}
{*                                <p class="roomFinalTxt">0 اتاق </p>*}
{*                            </div>*}
{*                            <h6 class="roomFinalPrice site-main-text-color">0 <i>##Rial##</i></h6>*}
{*                        </div>*}

{*                        {if $objResult->SearchHotel.prepayment_percentage gt 0}*}
{*                            <div class="parent-advance--payment">*}
{*                                <p>  {$objResult->SearchHotel.prepayment_percentage} % پیش پرداخت</p>*}
{*                                <h6 class='roomFinalPrepaymentPackagePrice'></h6>*}
{*                            </div>*}
{*                        {/if}*}
{*                        <span class="roomFinalBtn multi-rooms-price-btn-container">*}
{*                                    <button id="btnReserve" type="button" class="site-secondary-text-color site-bg-main-color " onclick="ReserveHotel()">*}
{*                                        ##Reservation##*}
{*                                        <i class="fa-solid fa-arrow-left"></i>*}
{*                                    </button>*}
{*                                        <img class="imgLoad" src="https://192.168.1.100/gds/view/client/assets/images/load2.gif" id="img">*}
{*                                </span>*}
{*                    </div>*}
{*                {/if}*}
{*            </div>*}
{*        </div>*}

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

{if $objSession->IsLogin()}
<span class="price-after-discount-code d-none">
    <i>ریال</i>
</span>
{/if}

<!-- bank connect -->
<div class="main-pay-content">

    <!-- payment methods drop down -->
    {assign var="memberCreditPermition" value="0"}
    {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] == '5'}
        {$memberCreditPermition = "1"}
    {/if}

    {assign var="counterCreditPermition" value="0"}
    {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] != '5'}
        {$counterCreditPermition = "1"}
    {/if}

    {assign var="bankInputs" value=['type_service'=>'exclusiveTour','flag' => 'check_credit_exclusive_tour', 'requestNumber' => $smarty.const.REQUEST_NUMBER]}
    {if $redirectBank}
        {assign var="bankAction" value="https://`$redirectBank['replace_url']`/gds/`$smarty.const.SOFTWARE_LANG`/goBankExclusiveTour"}
    {else}
        {assign var="bankAction" value="`$smarty.const.ROOT_ADDRESS`/goBankExclusiveTour"}
    {/if}


    {assign var="creditInputs" value=['flag' => 'buyByCreditExclusiveTour', 'requestNumber' => $smarty.const.REQUEST_NUMBER, 'paymentStatus' => 'fullPayment']}
    {assign var="creditAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankExclusiveTour"}

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`paymentMethods.tpl"}

</div>
</div>

<style>
/* استایل برای فیلدهای دارای خطا */
.entry_div.error-border input,
.entry_div.error-border select {
   border: 2px solid #dc3545 !important;
   background-color: #fff5f5 !important;
}

.entry_div.error-border {
   animation: shake 0.5s;
}

@keyframes shake {
   0%, 100% { transform: translateX(0); }
   10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
   20%, 40%, 60%, 80% { transform: translateX(5px); }
}
</style>

<script src="assets/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="assets/js/jdate.min.js" type="text/javascript"></script>
<script src="assets/js/jdate.js" type="text/javascript"></script>
<script src="assets/js/customForExclusiveTour.js"></script>
<script>
   window.isUserLoggedIn = {if $objSession->IsLogin()}true{else}false{/if};

   // لیست کشورها برای select2
   window.countryCodes = [
      {foreach $objFunctions->CountryCodes() as $Country}
         {
            code: '{$Country['code']}',
            name: '{$Country[$countryTitleName]|escape:'javascript'}'
         },
      {/foreach}
   ];

   GetPackageDetail('{$smarty.const.REQUEST_NUMBER}' , '{$smarty.const.SOURCE_ID}' , '{$smarty.const.HOTEL_GLOBAL_ID}' , '{$objFunctions->CalculateCredit()}');
</script>