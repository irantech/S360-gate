{*{load_presentation_object filename="searchHotel" assign="objsearch"}*}
{assign var="classNameStartDate" value="hotelStartDateShamsi"}
{assign var="classNameEndDate" value="hotelEndDateShamsi"}
{if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || $paramSearch.startDate|substr:0:4 gt 2000}
    {$classNameStartDate="deptCalendarToCalculateNights"}
{/if}
{if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || $paramSearch.endDate|substr:0:4 gt 2000}
    {$classNameEndDate="returnCalendarToCalculateNights"}
{/if}

{assign var="numberOfRooms" value=$objFunctions->numberOfRoomsExternalHotelSearch($smarty.get.rooms)}


{assign var="info_select_hotel" value=$objReservationHotel->getSelectSrvice('Hotel')}
{assign var="info_city" value=$objReservationHotel->findCityNameById($info_select_hotel['city_id'])}


{assign var="newSearchbox" value=false}
{if $smarty.get.type == 'new'}
    {$newSearchbox = true}
{/if}
{if $smarty.const.GDS_SWITCH eq 'searchHotel'}
    {assign var='all_cities' value=$objsearch->Allcity()}
    {assign var="total_cities" value=$all_cities|count}
    {assign var="city_index" value=0}
    {assign var="obj_city" value=[]}
    {assign var="obj_cities" value=''}
    {foreach $all_cities as $key => $city}
        {$city_index = $key + 1}
        {if $smarty.const.SOFTWARE_LANG eq 'fa'}
            {assign var="display_name" value=$city.city_name}
        {else}
            {assign var="display_name" value=$city.city_name_en}
        {/if}
        {assign var="html" value="<div class='d-flex justify-content-between'><span>{$display_name}</span></div>"}
        {assign var="popular" value='<span class="badge border text-white bg-dark">پر تردد</span>'}
        {if $city.position neq NULL}
            {$html = "<div class='d-flex justify-content-between'><span>{$display_name}</span> {$popular}</div>"}
        {/if}
        {assign var="selected" value=''}
        {if $city.id eq $smarty.get.city}
            {$selected = 'selected'}
        {/if}
        {$obj_city[] = ['id'=>$city.id,'text'=>$display_name,'html'=>$html,'selected'=>$selected]}
    {/foreach}
    {$obj_cities = $obj_city|json_encode:256}
{literal}
    <script type="text/javascript">
      var all_cities = {/literal}{$obj_cities}{literal};
      {/literal}
    </script>
{/if}
<div class="filtertip-searchbox filtertip-searchbox-box1 filtertip_hotel_researh">
    <form class="search-wrapper parent-research-internal-hotel-sidebar parent-research-internal-hotel-sidebar--new" action="" method="post">
        <div class="form-hotel-item form-hotel-item-searchBox">
<!--            <div class="select">
                <select id="destination_city" name="destination_city" class="select2SearchHotelCities"></select>
            </div>-->



            <div class='inputSearchForeign-box inputSearchForeign-pad_Fhotel'>
                <div class="s-u-in-out-wrapper raft raft-change change-bor position-relative">

                    {if $info_select_hotel}
                        <input id="autoComplateSearchIN" name="autoComplateSearchIN"
                               class="inputSearchForeign has-night-badge"
                               type="text"
                               value="{$info_city['city_name']}"
                               placeholder='##Selection## ##City##'
                               autocomplete="off">
                        <input type="hidden" id="autoComplateSearchIN_hidden" value="{$info_city['id']}">
                    {else}
                        <input id="autoComplateSearchIN" name="autoComplateSearchIN"
                               class="inputSearchForeign has-night-badge"
                               type="text"
                               value=""
                               placeholder='##Selection## ##City##'
                               autocomplete="off"
                               onkeyup="searchCity('hotel')"
                               onclick="openBoxPopular('hotel')">
                    {/if}

                    <!-- NIGHT BADGE -->
                    <span class="night-badge">
                        {$paramSearch.nights} ##Night##
                    </span>

                    <input type='hidden' id='autoComplateSearchIN_hidden' value=''>
                    <img src="assets/images/load.gif" id="LoaderForeignDep" name="LoaderForeignDep"
                         class="loaderSearch">

                    <ul id="listSearchCity" class="ul-inputSearch-externalHotel displayiN"></ul>
                </div>
            </div>


        </div>
        <div class="parent-box-pageTwo--new">
            <div class="form-hotel-item form-hotel-item-searchBox-date">
                <div class="input">
                    <i class="fa fa-calendar site-main-text-color"></i>
                    <input type="text" class="{$classNameStartDate}"
                           placeholder=" ##Enterdate##" id="startDate" name="startDate"
                           value="{$paramSearch.startDate}">
                </div>
            </div>
            <div class="form-hotel-item  form-hotel-item-searchBox-date">
                <div class="input">
                    <i class="fa fa-calendar site-main-text-color"></i>
                    <input type="text" class="{$classNameEndDate}"
                           placeholder="##Exitdate## " id="endDate" name="endDate"
                           value="{$paramSearch.endDate}">
                </div>
            </div>
        </div>
        <div class="form-hotel-item parent-flex-night--new {if $newSearchbox}form-hotel-item-searchBox-date {/if} mt-0">
<!--            <div class="lh35 stayingTime">
                <span> {$paramSearch.nights} ##Night##</span>
            </div>-->
            <input type="hidden" id="stayingTime" name="stayingTime" value="{$paramSearch.nights}"/>
            <input type="hidden" id="hotelType" name="hotelType" value="{$paramSearch.hotelType}"/>
            <input type="hidden" id="star" name="star" value="{$paramSearch.star}"/>
            {*<input type="hidden" id="price" name="price" value="{$smarty.const.SEARCH_PRICE}"/>*}
        </div>

        {if $newSearchbox}
            <input type="hidden" id="type" name="type" value="new">

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
            <div class="w-100" id="box-foreign-hotel-room">
                <div class="clrB site-main-text-color-drck box-foreign-hotel-room-item">
                    <div class="myroom-hotel">
                        {foreach from=$numberOfRooms['rooms'] key=key item=room}
                            {assign var="count" value=$key+1}
                            <div class="myroom-hotel-item" data-roomNumber="{$count}">
                                <div class="myroom-hotel-item-title site-main-text-color">
                                    ##Numberpeopland##
                                </div>
{*                                <span class="close"></span>*}
{*                                {$objFunctions->textNumber($count)}*}
                                <div class="myroom-hotel-item-info">
                                    <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
                                        <span>##Adultnumber##<i>(12 ##yearsandup##)</i></span>
                                        <div>
                                            <i class="addParentEHotel fa fa-plus site-main-text-color"></i>
                                            <input type="text" name="adult{$count}" id="adult{$count}" readonly="" class="countParentEHotel" min="1" value="{$room.AdultCount}" max="6">
                                            <i class="minusParentEHotel fa fa-minus  site-main-text-color"></i>
                                        </div>
                                    </div>
                                    <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
                                        <span>##Numberofchildren##<i>(##Under## 12 ##Year##)</i></span>
                                        <div>
                                            <i class="addChildEHotel fa fa-plus  site-main-text-color"></i>
                                            <input type="text" readonly="" name="child{$count}"
                                                   id="child{$count}"
                                                   class="countChildEHotel" min="0"
                                                   value="{$room['ChildrenCount']}"
                                                   max="5">
                                            <i class="minusChildEHotel fa fa-minus  site-main-text-color"></i>
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
                                                            ۰ ##To## ۱ ##Year##
                                                        </option>
                                                        <option value="2"
                                                                {if {$room['ChildrenAge'][$i-1]} eq '2'}selected{/if}>
                                                            ۱ ##To## ۲ ##Year##
                                                        </option>
                                                        <option value="3"
                                                                {if {$room['ChildrenAge'][$i-1]} eq '3'}selected{/if}>
                                                            ۲ ##To## ۳ ##Year##
                                                        </option>
                                                        <option value="4"
                                                                {if {$room['ChildrenAge'][$i-1]} eq '4'}selected{/if}>
                                                            ۳ ##To## ۴ ##Year##
                                                        </option>
                                                        <option value="5"
                                                                {if {$room['ChildrenAge'][$i-1]} eq '5'}selected{/if}>
                                                            ۴ ##To## ۵ ##Year##
                                                        </option>
                                                        <option value="6"
                                                                {if {$room['ChildrenAge'][$i-1]} eq '6'}selected{/if}>
                                                            ۵ ##To## ۶ ##Year##
                                                        </option>
                                                        <option value="7"
                                                                {if {$room['ChildrenAge'][$i-1]} eq '7'}selected{/if}>
                                                            ۶ ##To## ۷ ##Year##
                                                        </option>
                                                        <option value="8"
                                                                {if {$room['ChildrenAge'][$i-1]} eq '8'}selected{/if}>
                                                            ۷ ##To## ۸ ##Year##
                                                        </option>
                                                        <option value="9"
                                                                {if {$room['ChildrenAge'][$i-1]} eq '9'}selected{/if}>
                                                            ۸ ##To## ۹ ##Year##
                                                        </option>
                                                        <option value="10"
                                                                {if {$room['ChildrenAge'][$i-1]} eq '10'}selected{/if}>
                                                            ۹ ##To## ۱۰ ##Year##
                                                        </option>
                                                        <option value="11"
                                                                {if {$room['ChildrenAge'][$i-1]} eq '11'}selected{/if}>
                                                            ۱۰ ##To## ۱۱ ##Year##
                                                        </option>
                                                        <option value="12"
                                                                {if {$room['ChildrenAge'][$i-1]} eq '12'}selected{/if}>
                                                            ۱۱ ##To## ۱۲ ##Year##
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

        <div class="form-hotel-item  form-hotel-item-searchBox-btn">
            <span></span>
            <div class="input">
                <button class="site-bg-main-color" type="button" id="searchHotelLocal"
                        onclick="submitSearchHotelLocal()">##Search##
                </button>
            </div>
        </div>
    </form>
</div>