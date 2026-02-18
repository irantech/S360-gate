{load_presentation_object filename="reservationTicket" assign="objResult"}
{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}
{$objPublic->getAllCounter('all')} {*گرفتن لیست انواع کانتر*}
{assign var=agencies value=$objPublic->getCharterSeatAgencies()} {*گرفتن لیست آژانس هایی که سیت چارتر دارند*}

{$objResult->charterReportByIdSame($smarty.get.id, $smarty.get.sDate, $smarty.get.eDate)}
{assign var="loadFlyDataForTicket" value=$objResult->loadFlyDataForTicket($objResult->ticket['fly_code'])}

{assign var=listTypeOfPlane2 value=$objPublic->listTypeOfPlane2($objResult->ticket['airline'])}
{load_presentation_object filename="temporaryData" assign="objTemporary"}
{assign var="tempData" value=$objTemporary->getAllByReference($objResult->ticket['fly_code'],'fly_number')}
{assign var="jsonData" value=$tempData.data|@json_decode:true}
{assign var="classes" value=$objResult->classesListByIdSame($smarty.get.id)}  {*لیست کلاس های این پکیج*}
{assign var="classesDetail" value=$objResult->classesDetailByIdSame($smarty.get.id)}  {*لیست کلاس های این پکیج با ظرفیت *}


{* گرفتن پارامترهای GET *}
{assign var=startDate value=$smarty.get.sDate}
{assign var=endDate value=$smarty.get.eDate}
{* افزودن / بین سال، ماه و روز *}
{assign var=startDate formatted value="`$startDate|substr:0:4`-`$startDate|substr:4:2`-`$startDate|substr:6:2`"}
{assign var=endDate formatted value="`$endDate|substr:0:4`-`$endDate|substr:4:2`-`$endDate|substr:6:2`"}

{assign var="daysWeek" value=$objResult->getDaysWeekAnyTicket($smarty.get.id, $smarty.get.sDate, $smarty.get.eDate)}

<link href="assets/css/ticketAdd.css" rel="stylesheet">
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>بازرگانی</li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/reservation/reportTicket">  ویرایش تجمیعی پرواز</a></li>
                <li class="active">ویرایش برنامه پروازی </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <form id="FormEditTicket" method="post" action="">
                    <input type="hidden" name="flag" value="editTickets">
                    <input type="hidden" name="flag" value="editTickets">
                    <input type="hidden" value="{$smarty.get.id}" name="id_same" id="id_same">
                    <input type="hidden" value="{$smarty.get.sDate}" name="sDate" id="sDate">
                    <input type="hidden" value="{$smarty.get.eDate}" name="eDate" id="eDate">
                    {* Flight Data Display Table - Show when hasFlyData is true *}
                    <div class="flight-data-container">
                        <div class="flight-data-title">
                            <i class="fa fa-plane"></i>
                            اطلاعات پرواز انتخاب شده
                        </div>
                        <div class="flight-data-badges">
                            <div class="flight-badge">
                                <span class="badge-label">مبدا:</span>
                                <span class="badge-value">
                                    {foreach $objPublic->ListCountry() as $country}
                                        {if $objResult->flyDataForTicket.origin_country == $country['id']}{$country['name']}{/if}
                                    {/foreach}
                                    - {$objResult->flyDataForTicket.origin_city_name}
                                    {if $objResult->flyDataForTicket.origin_region_name}- {$objResult->flyDataForTicket.origin_region_name}{/if}
                                </span>
                            </div>
                            <div class="flight-badge">
                                <span class="badge-label">مقصد:</span>
                                <span class="badge-value">
                                    {foreach $objPublic->ListCountry() as $country}
                                        {if $objResult->flyDataForTicket.destination_country == $country['id']}{$country['name']}{/if}
                                    {/foreach}
                                    - {$objResult->flyDataForTicket.destination_city_name}
                                    {if $objResult->flyDataForTicket.destination_region_name}- {$objResult->flyDataForTicket.destination_region_name}{/if}
                                </span>
                            </div>
                            <div class="flight-badge">
                                <span class="badge-label">وسیله حمل و نقل:</span>
                                {assign var="vehicleName" value=$objPublic->ShowName('reservation_type_of_vehicle_tb',$objResult->flyDataForTicket.type_of_vehicle_id)}

                                {if $vehicleName eq 'هواپیما'}
                                    {assign var="airlineName" value=$objPublic->ShowNameBase('airline_tb','name_fa',$objResult->flyDataForTicket.airline)}
                                {else}
                                    {assign var="airlineName" value=$objPublic->ShowName('reservation_transport_companies_tb',$objResult->flyDataForTicket.airline)}
                                {/if}

                                {assign var="typeOfPlaneName" value=$objPublic->ShowName('reservation_vehicle_model_tb',$objResult->flyDataForTicket.type_of_plane)}

                                {assign var="flyCode" value=$objResult->flyDataForTicket.fly_code}

                                <span class="badge-value  rtl-text" title="{$typeOfPlaneName} - {$flyCode}">
                                     {$vehicleName}
                                     -
                                     {$airlineName}
                                     -
                                     {$typeOfPlaneName}
                                     -
                                     {$flyCode}
                                </span>
                            </div>
                            <div class="flight-badge">
                                <span class="badge-label">جزئیات:</span>
                                <span class="badge-value">
                                    ساعت حرکت :
                                    {assign var="tmp" value=$objResult->flyDataForTicket.departure_hours|@json_decode:true}
                                    {$tmp.departure_hours}:{$tmp.departure_minutes}
                                     -
                                    ساعت فرود :
                                    {$objResult->flyDataForTicket.time}
                                </span>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="origin_country" value="{$objResult->flyDataForTicket.origin_country}">
                    <input type="hidden" name="origin_city" value="{$objResult->flyDataForTicket.origin_city}">
                    <input type="hidden" name="origin_region" value="{$objResult->flyDataForTicket.origin_region}">
                    <input type="hidden" name="destination_country" value="{$objResult->flyDataForTicket.destination_country}">
                    <input type="hidden" name="destination_city" value="{$objResult->flyDataForTicket.destination_city}">
                    <input type="hidden" name="destination_region" value="{$objResult->flyDataForTicket.destination_region}">
                    <input type="hidden" name="airline" value="{$objResult->flyDataForTicket.airline}">
                    <input type="hidden" name="fly_code" value="{$objResult->flyDataForTicket.id}">
                    <input type="hidden" name="flight_time" value="{$objResult->flyDataForTicket.time}">
                    <input type="hidden" name="type_of_vehicle" value="{$objResult->flyDataForTicket.type_of_vehicle_id}">
                    <input type="hidden" name="day_onrequest" value="{$objResult->flyDataForTicket.day_onrequest}">

                    <div class="form-row info-fly-container">
                        <div class="form-group col-sm-2">
                            <label for="free" class="control-label">میزان بار رایگان</label>
                            <input type="text" class="form-control" name="free" value="{$objResult->ticket['free']}" id="free" tabindex="1">
                        </div>

                        <div class="form-group col-sm-2">
                            <label for="vehicle_grades" class="control-label">درجه وسیله نقلیه</label><span class="star">*</span>
                            {assign var="hidden_vals" value=""}
                            {foreach from=$classes item=cls name=classLoop}
                                <input type="hidden" name="vehicle_grades[]" value="{$cls.id}">
                                {assign var="hidden_vals" value="`$hidden_vals``$cls.abbreviation`"}
                                {if !$smarty.foreach.classLoop.last}
                                    {assign var="hidden_vals" value="`$hidden_vals`,"}
                                {/if}
                            {/foreach}
                            <input type="hidden" name="current_vehicle_grade" value="{$hidden_vals}" id="current_vehicle_grade"  tabindex="2" readonly>
                            <div class="form-control" readonly>{$hidden_vals}</div>
                        </div>

                        {* پیدا کردن نام فروشنده انتخاب شده *}
                        {foreach $agencies as $seller}
                            {if $seller.id == $objResult->ticket['seller_id']}
                                {assign var=selectedSellerName value=$seller.name_fa}
                            {/if}
                        {/foreach}

                        <div class="form-group col-sm-2">
                            <label for="seller_id" class="control-label">نام فروشنده</label><span class="star">*</span>
                            <div class="dropdown">
                                <div class="form-control dropdown-toggle d-flex justify-content-between align-items-center"
                                     id="sellerDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                     role="button" style="cursor:pointer;" tabindex="3">
                                    <span id="sellerDropdownText">{$selectedSellerName}</span>
                                    <i class="fa fa-chevron-down small" aria-hidden="true"></i>
                                </div>
                                <div class="dropdown-menu w-100 p-2" aria-labelledby="sellerDropdown"
                                     style="max-height:260px; overflow-y:auto;">
                                    <input type="text" class="form-control form-control-sm mb-2"
                                           placeholder="جستجو..." onkeyup="filterSellerList(this)">
                                    <ul id="seller_list" class="list-unstyled mb-0">
                                        {foreach $agencies as $seller}
                                            <li>
                                                <a href="javascript:void(0)" class="dropdown-item py-1"
                                                   onclick="selectSeller('{$seller.id}', '{$seller.name_fa}')">
                                                    {$seller.name_fa}
                                                </a>
                                            </li>
                                        {/foreach}
                                    </ul>
                                </div>
                            </div>
                            <input type="hidden" name="seller_id" id="seller_id" value="{$objResult->ticket['seller_id']}">
                        </div>


                        <div class="form-group col-sm-2">
                            <label for="seller_price" class="control-label">قیمت هر صندلی</label><span class="star">*</span>
                            <input type="text" class="form-control" name="seller_price" value="{$objResult->ticket['seller_price']|number_format:0:',':','}" tabindex="4"
                                   id="seller_price" onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                        </div>

                        <div class="form-group col-sm-2">
                            <label for="start_date" class="control-label">شروع تاریخ پرواز</label><span class="star">*</span>
                            <input type="text" class="form-control" name="start_date" value="{$startDate}" tabindex="5" id="start_date" readonly>
                        </div>

                        <div class="form-group col-sm-2">
                            <label for="end_date" class="control-label">پایان تاریخ پرواز</label><span class="star">*</span>
                            <input type="text" class="form-control" name="end_date" value="{$endDate}" tabindex="6" id="end_date" readonly>
                        </div>
                    </div>

                    <div class="form-row day-selection-container">
                        <div class="day-selection-title">
                            <i class="fa fa-calendar"></i>
                            انتخاب روزها<span class="star">*</span>
                        </div>
                        <!-- Day Selection Cards -->
                        <div class="day-cards-grid" id="daySelectionCards">
                            <!-- شنبه -->
                            <div class="day-card {if 0|in_array:$daysWeek}active{/if}" id="dayCard0">
                                <div class="day-card-indicator"></div>
                                <div class="day-card-header">
                                    <div class="checkbox checkbox-success">
                                        <input id="sh0" name="sh0" class="day-checkbox" type="checkbox" value="0" tabindex="7"  {if 0|in_array:$daysWeek} checked {/if}  onclick="return false;">{*onchange="toggleDayCardChange(0)"*}
                                        <label for="sh0">شنبه</label>
                                    </div>
                                </div>
                                {if 0|in_array:$daysWeek}
                                <div class="day-card-body" id="dayCardBody0">
                                    <div class="day-card-content">
                                        <div class="time-input-group">
                                            {assign var="degrreFirst" value="0_{$classes[0]['id']}"}
                                            <input type="text" name="day_departure_time_0" id="day_departure_time_0"
                                                   class="time-input input-change-price w-100"
                                                   data-time-format="true" placeholder="ساعت حرکت" maxlength="5"
                                                   value="{$classesDetail[{$degrreFirst}]['exitHour']|substr:0:5}"
                                                   tabindex="9">
                                        </div>
                                        <div class="capacity-field">
                                            <select name="day_type_of_vehicle_0" id="day_type_of_vehicle_0" class="form-control" tabindex="10">
                                                {foreach from=$listTypeOfPlane2 item=TOP name=PalneLoop}
                                                    {if $classesDetail[{$degrreFirst}]['typeOfVehicle']==$TOP.id}
                                                        {assign var="selectedNow" value="selected"}
                                                    {else}
                                                        {assign var="selectedNow" value=""}
                                                    {/if}
                                                    <option value="{$TOP.id}" {$selectedNow}>{$TOP.name} ({$TOP.abbreviation})</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                        <div class="capacity-fields" id="capacityFields0">
                                            <!-- Capacity fields will be dynamically generated here -->
                                            {assign var="tabIndex" value=11}
                                            {foreach $classes as $cls}
                                                {assign var="NameCapacityNow" value="0_{$cls.id}"}
                                                <div class="capacity-field">
                                                    <label>کلاس {$cls.abbreviation}</label>
                                                    <input type="number"
                                                           name="day_capacity_0_{$cls.id}"
                                                           id="day_capacity_0_{$cls.id}"
                                                           placeholder="ظرفیت"
                                                           min="0"
                                                           class="form-control"
                                                           tabindex="{$tabIndex}"
                                                           value="{$classesDetail[{$NameCapacityNow}]['flyTotalCapacity']}"
                                                           >{*onchange="updateCapacityForGrade('0', {$cls.id}, this.value)"*}
                                                </div>
                                                {assign var="tabIndex" value=$tabIndex+1}
                                            {/foreach}
                                        </div>
                                    </div>
                                </div>
                                {/if}
                            </div>

                            <!-- یکشنبه -->
                            <div class="day-card {if 1|in_array:$daysWeek}active{/if}" id="dayCard1">
                                <div class="day-card-indicator"></div>
                                <div class="day-card-header">
                                    <div class="checkbox checkbox-success">
                                        <input id="sh1" name="sh1" class="day-checkbox" type="checkbox" value="1"  tabindex="14" {if 1|in_array:$daysWeek} checked {/if}  onclick="return false;">{* onchange="toggleDayCardChange(1)"*}
                                        <label for="sh1">یکشنبه</label>
                                    </div>
                                </div>
                                {if 1|in_array:$daysWeek}
                                <div class="day-card-body" id="dayCardBody1">
                                    <div class="day-card-content">
                                        <div class="time-input-group">
                                            {assign var="degrreFirst" value="1_{$classes[0]['id']}"}
                                            <input type="text" name="day_departure_time_1" id="day_departure_time_1"
                                                   class="time-input input-change-price w-100" data-time-format="true"
                                                   placeholder="ساعت حرکت" maxlength="5"
                                                   value="{$classesDetail[{$degrreFirst}]['exitHour']|substr:0:5}"
                                                   tabindex="15">
                                        </div>
                                        <div class="capacity-field">
                                            <select name="day_type_of_vehicle_1" id="day_type_of_vehicle_1" class="form-control" tabindex="16">
                                                {foreach from=$listTypeOfPlane2 item=TOP name=PalneLoop}
                                                    {if $classesDetail[{$degrreFirst}]['typeOfVehicle']==$TOP.id}
                                                        {assign var="selectedNow" value="selected"}
                                                    {else}
                                                        {assign var="selectedNow" value=""}
                                                    {/if}
                                                    <option value="{$TOP.id}" {$selectedNow}>{$TOP.name} ({$TOP.abbreviation})</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                        <div class="capacity-fields" id="capacityFields1">
                                            <!-- Capacity fields will be dynamically generated here -->
                                            {assign var="tabIndex" value=17}
                                            {foreach $classes as $cls}
                                                {assign var="NameCapacityNow" value="1_{$cls.id}"}
                                                <div class="capacity-field">
                                                    <label>کلاس {$cls.abbreviation}</label>
                                                    <input type="number"
                                                           name="day_capacity_1_{$cls.id}"
                                                           id="day_capacity_1_{$cls.id}"
                                                           placeholder="ظرفیت"
                                                           min="0"
                                                           class="form-control"
                                                           tabindex="{$tabIndex}"
                                                           value="{$classesDetail[{$NameCapacityNow}]['flyTotalCapacity']}"
                                                           >{*onchange="updateCapacityForGrade('1', {$cls.id}, this.value)"*}
                                                </div>
                                                {assign var="tabIndex" value=$tabIndex+1}
                                            {/foreach}
                                        </div>
                                    </div>
                                </div>
                                {/if}
                            </div>

                            <!-- دوشنبه -->
                            <div class="day-card {if 2|in_array:$daysWeek}active{/if}" id="dayCard2">
                                <div class="day-card-indicator"></div>
                                <div class="day-card-header">
                                    <div class="checkbox checkbox-success">
                                        <input id="sh2" name="sh2" class="day-checkbox" type="checkbox" value="2" tabindex="20"  {if 2|in_array:$daysWeek}  checked {/if}  onclick="return false;">{* onchange="toggleDayCardChange(2)"*}
                                        <label for="sh2">دوشنبه</label>
                                    </div>
                                </div>
                                {if 2|in_array:$daysWeek}
                                <div class="day-card-body" id="dayCardBody2">
                                    <div class="day-card-content">
                                        <div class="time-input-group">
                                            {assign var="degrreFirst" value="2_{$classes[0]['id']}"}
                                            <input type="text" name="day_departure_time_2" id="day_departure_time_2"
                                                   class="time-input input-change-price w-100" data-time-format="true" tabindex="21"
                                                   placeholder="ساعت حرکت" maxlength="5"
                                                   value="{$classesDetail[{$degrreFirst}]['exitHour']|substr:0:5}"
                                            >
                                        </div>
                                        <div class="capacity-field">
                                            <select name="day_type_of_vehicle_2" id="day_type_of_vehicle_2" class="form-control" tabindex="22">
                                                {foreach from=$listTypeOfPlane2 item=TOP name=PalneLoop}
                                                    {if $classesDetail[{$degrreFirst}]['typeOfVehicle']==$TOP.id}
                                                        {assign var="selectedNow" value="selected"}
                                                    {else}
                                                        {assign var="selectedNow" value=""}
                                                    {/if}
                                                    <option value="{$TOP.id}" {$selectedNow}>{$TOP.name} ({$TOP.abbreviation})</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                        <div class="capacity-fields" id="capacityFields2">

                                            <!-- Capacity fields will be dynamically generated here -->
                                            {assign var="tabIndex" value=23}
                                            {foreach $classes as $cls}
                                                {assign var="NameCapacityNow" value="2_{$cls.id}"}
                                                <div class="capacity-field">
                                                    <label>کلاس {$cls.abbreviation}</label>
                                                    <input type="number"
                                                           name="day_capacity_2_{$cls.id}"
                                                           id="day_capacity_2_{$cls.id}"
                                                           placeholder="ظرفیت"
                                                           min="0"
                                                           class="form-control"
                                                           tabindex="{$tabIndex}"
                                                           value="{$classesDetail[{$NameCapacityNow}]['flyTotalCapacity']}"
                                                           >{*onchange="updateCapacityForGrade('2', {$cls.id}, this.value)"*}
                                                </div>
                                                {assign var="tabIndex" value=$tabIndex+1}
                                            {/foreach}
                                        </div>
                                    </div>
                                </div>
                                {/if}
                            </div>

                            <!-- سه‌شنبه -->
                            <div class="day-card {if 3|in_array:$daysWeek}active{/if}" id="dayCard3">
                                <div class="day-card-indicator"></div>
                                <div class="day-card-header">
                                    <div class="checkbox checkbox-success">
                                        <input id="sh3" name="sh3" class="day-checkbox" type="checkbox" value="3" tabindex="26" {if 3|in_array:$daysWeek} checked {/if}  onclick="return false;">{* onchange="toggleDayCardChange(3)"*}
                                        <label for="sh3">سه‌شنبه</label>
                                    </div>
                                </div>
                                {if 3|in_array:$daysWeek}
                                <div class="day-card-body" id="dayCardBody3">
                                    <div class="day-card-content">
                                        <div class="time-input-group">
                                            {assign var="degrreFirst" value="3_{$classes[0]['id']}"}
                                            <input type="text" name="day_departure_time_3" id="day_departure_time_3"
                                                   class="time-input input-change-price w-100" data-time-format="true" tabindex="27"
                                                   placeholder="ساعت حرکت" maxlength="5"
                                                   value="{$classesDetail[{$degrreFirst}]['exitHour']|substr:0:5}">
                                        </div>
                                        <div class="capacity-field">
                                            <select name="day_type_of_vehicle_3" id="day_type_of_vehicle_3" class="form-control" tabindex="28">
                                                {foreach from=$listTypeOfPlane2 item=TOP name=PalneLoop}
                                                    {if $classesDetail[{$degrreFirst}]['typeOfVehicle']==$TOP.id}
                                                        {assign var="selectedNow" value="selected"}
                                                    {else}
                                                        {assign var="selectedNow" value=""}
                                                    {/if}
                                                    <option value="{$TOP.id}" {$selectedNow}>{$TOP.name} ({$TOP.abbreviation})</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                        <div class="capacity-fields" id="capacityFields3">
                                            <!-- Capacity fields will be dynamically generated here -->
                                            {assign var="tabIndex" value=29}
                                            {foreach $classes as $cls}
                                                {assign var="NameCapacityNow" value="3_{$cls.id}"}
                                                <div class="capacity-field">
                                                    <label>کلاس {$cls.abbreviation}</label>
                                                    <input type="number"
                                                           name="day_capacity_3_{$cls.id}"
                                                           id="day_capacity_3_{$cls.id}"
                                                           placeholder="ظرفیت"
                                                           min="0"
                                                           class="form-control"
                                                           tabindex="{$tabIndex}"
                                                           value="{$classesDetail[{$NameCapacityNow}]['flyTotalCapacity']}"
                                                           >{*onchange="updateCapacityForGrade('3', {$cls.id}, this.value)"*}
                                                </div>
                                                {assign var="tabIndex" value=$tabIndex+1}
                                            {/foreach}
                                        </div>
                                    </div>
                                </div>
                                {/if}
                            </div>

                            <!-- چهارشنبه -->
                            <div class="day-card {if 4|in_array:$daysWeek}active{/if}" id="dayCard4">
                                <div class="day-card-indicator"></div>
                                <div class="day-card-header">
                                    <div class="checkbox checkbox-success">
                                        <input id="sh4" name="sh4" class="day-checkbox" type="checkbox" value="4" tabindex="32" {if 4|in_array:$daysWeek} checked {/if}  onclick="return false;">{* onchange="toggleDayCardChange(4)"*}
                                        <label for="sh4">چهارشنبه</label>
                                    </div>
                                </div>
                                {if 4|in_array:$daysWeek}
                                <div class="day-card-body" id="dayCardBody4">
                                    <div class="day-card-content">
                                        <div class="time-input-group">
                                            {assign var="degrreFirst" value="4_{$classes[0]['id']}"}
                                            <input type="text" name="day_departure_time_4" id="day_departure_time_4"
                                                   class="time-input input-change-price w-100" data-time-format="true" tabindex="33"
                                                   placeholder="ساعت حرکت" maxlength="5"
                                                   value="{$classesDetail[{$degrreFirst}]['exitHour']|substr:0:5}">
                                        </div>
                                        <div class="capacity-field">
                                            <select name="day_type_of_vehicle_4" id="day_type_of_vehicle_4" class="form-control" tabindex="34">
                                                {foreach from=$listTypeOfPlane2 item=TOP name=PalneLoop}
                                                    {if $classesDetail[{$degrreFirst}]['typeOfVehicle']==$TOP.id}
                                                        {assign var="selectedNow" value="selected"}
                                                    {else}
                                                        {assign var="selectedNow" value=""}
                                                    {/if}
                                                   <option value="{$TOP.id}" {$selectedNow}>{$TOP.name} ({$TOP.abbreviation})</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                        <div class="capacity-fields" id="capacityFields4">
                                            <!-- Capacity fields will be dynamically generated here -->
                                            {assign var="tabIndex" value=35}
                                            {foreach $classes as $cls}
                                                {assign var="NameCapacityNow" value="4_{$cls.id}"}
                                                <div class="capacity-field">
                                                    <label>کلاس {$cls.abbreviation}</label>
                                                    <input type="number"
                                                           name="day_capacity_4_{$cls.id}"
                                                           id="day_capacity_4_{$cls.id}"
                                                           placeholder="ظرفیت"
                                                           min="0"
                                                           class="form-control"
                                                           tabindex="{$tabIndex}"
                                                           value="{$classesDetail[{$NameCapacityNow}]['flyTotalCapacity']}"
                                                           >{*onchange="updateCapacityForGrade('4', {$cls.id}, this.value)"*}
                                                </div>
                                                {assign var="tabIndex" value=$tabIndex+1}
                                            {/foreach}
                                        </div>
                                    </div>
                                </div>
                                {/if}
                            </div>

                            <!-- پنج‌شنبه -->
                            <div class="day-card {if 5|in_array:$daysWeek}active{/if}" id="dayCard5">
                                <div class="day-card-indicator"></div>
                                <div class="day-card-header">
                                    <div class="checkbox checkbox-success">
                                        <input id="sh5" name="sh5" class="day-checkbox" type="checkbox" value="5" tabindex="38" {if 5|in_array:$daysWeek} checked {/if}  onclick="return false;">{* onchange="toggleDayCardChange(5)"*}
                                        <label for="sh5">پنج‌شنبه</label>
                                    </div>
                                </div>
                                {if 5|in_array:$daysWeek}
                                <div class="day-card-body" id="dayCardBody5">
                                    <div class="day-card-content">
                                        <div class="time-input-group">
                                            {assign var="degrreFirst" value="5_{$classes[0]['id']}"}
                                            <input type="text" name="day_departure_time_5" id="day_departure_time_5"
                                                   class="time-input input-change-price w-100" data-time-format="true" tabindex="39"
                                                   placeholder="ساعت حرکت" maxlength="5"
                                                   value="{$classesDetail[{$degrreFirst}]['exitHour']|substr:0:5}">
                                        </div>
                                        <div class="capacity-field">
                                            <select name="day_type_of_vehicle_5" id="day_type_of_vehicle_5" class="form-control" tabindex="40">
                                                {foreach from=$listTypeOfPlane2 item=TOP name=PalneLoop}
                                                    {if $classesDetail[{$degrreFirst}]['typeOfVehicle']==$TOP.id}
                                                        {assign var="selectedNow" value="selected"}
                                                    {else}
                                                        {assign var="selectedNow" value=""}
                                                    {/if}
                                                    <option value="{$TOP.id}" {$selectedNow}>{$TOP.name} ({$TOP.abbreviation})</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                        <div class="capacity-fields" id="capacityFields5">
                                            <!-- Capacity fields will be dynamically generated here -->
                                            {assign var="tabIndex" value=41}
                                            {foreach $classes as $cls}
                                                {assign var="NameCapacityNow" value="5_{$cls.id}"}
                                                <div class="capacity-field">
                                                    <label>کلاس {$cls.abbreviation}</label>
                                                    <input type="number"
                                                           name="day_capacity_5_{$cls.id}"
                                                           id="day_capacity_5_{$cls.id}"
                                                           placeholder="ظرفیت"
                                                           min="0"
                                                           class="form-control"
                                                           tabindex="{$tabIndex}"
                                                           value="{$classesDetail[{$NameCapacityNow}]['flyTotalCapacity']}"
                                                           >{*onchange="updateCapacityForGrade('5', {$cls.id}, this.value)"*}
                                                </div>
                                                {assign var="tabIndex" value=$tabIndex+1}
                                            {/foreach}
                                        </div>
                                    </div>
                                </div>
                                {/if}
                            </div>

                            <!-- جمعه -->
                            <div class="day-card {if 6|in_array:$daysWeek}active{/if}" id="dayCard6">
                                <div class="day-card-indicator"></div>
                                <div class="day-card-header">
                                    <div class="checkbox checkbox-success">
                                        <input id="sh6" name="sh6" class="day-checkbox" type="checkbox" value="6" tabindex="44" {if 6|in_array:$daysWeek} checked {/if}  onclick="return false;">{* onchange="toggleDayCardChange(6)"*}
                                        <label for="sh6">جمعه</label>
                                    </div>
                                </div>
                                {if 6|in_array:$daysWeek}
                                <div class="day-card-body" id="dayCardBody6">
                                    <div class="day-card-content">
                                        <div class="time-input-group">
                                            {assign var="degrreFirst" value="6_{$classes[0]['id']}"}
                                            <input type="text" name="day_departure_time_6" id="day_departure_time_6"
                                                   class="time-input input-change-price w-100" data-time-format="true" tabindex="45"
                                                   placeholder="ساعت حرکت" maxlength="5"
                                                   value="{$classesDetail[{$degrreFirst}]['exitHour']|substr:0:5}">
                                        </div>
                                        <div class="capacity-field">
                                            <select name="day_type_of_vehicle_6" id="day_type_of_vehicle_6" class="form-control" tabindex="46">
                                                {foreach from=$listTypeOfPlane2 item=TOP name=PalneLoop}
                                                    {if $classesDetail[{$degrreFirst}]['typeOfVehicle']==$TOP.id}
                                                        {assign var="selectedNow" value="selected"}
                                                    {else}
                                                        {assign var="selectedNow" value=""}
                                                    {/if}
                                                    <option value="{$TOP.id}" {$selectedNow}>{$TOP.name} ({$TOP.abbreviation})</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                        <div class="capacity-fields" id="capacityFields6">
                                            <!-- Capacity fields will be dynamically generated here -->
                                            {assign var="tabIndex" value=47}
                                            {foreach $classes as $cls}
                                                {assign var="NameCapacityNow" value="6_{$cls.id}"}
                                                <div class="capacity-field">
                                                    <label>کلاس {$cls.abbreviation}</label>
                                                    <input type="number"
                                                           name="day_capacity_6_{$cls.id}"
                                                           id="day_capacity_6_{$cls.id}"
                                                           placeholder="ظرفیت"
                                                           min="0"
                                                           class="form-control"
                                                           tabindex="{$tabIndex}"
                                                           value="{$classesDetail[{$NameCapacityNow}]['flyTotalCapacity']}"
                                                           >{*onchange="updateCapacityForGrade('6', {$cls.id}, this.value)"*}
                                                </div>
                                                {assign var="tabIndex" value=$tabIndex+1}
                                            {/foreach}
                                        </div>
                                    </div>
                                </div>
                                {/if}
                            </div>
                        </div>
                    </div>

                    <div class="form-row compact-allocation-section">
                        <div class="compact-content">

                            <!-- Compact Agency Allocation Grid -->
                            <div id="agency-allocation-grid" class="compact-allocation-grid" style="">
                                <div class="allocation-grid-header">
                                    <i class="fa fa-calendar"></i>
                                    <h5>تخصیص صندلی</h5>
                                </div>
                                <div class="allocation-grid-body">

                                    {foreach from=$objResult->ticket.agencies key=agencyId item=agency}

                                        <div class="agency-allocation-row">

                                            <div class="agency-row-header">
                                                <span class="agency-name">{$agency.agency_name}</span>
                                            </div>

                                            <div class="days-allocation-grid">

                                                {foreach from=$agency.tickets key=ticketIndex item=ticket}

                                                    <div class="day-allocation-item active">

                                                        <span class="day-name">{$ticket.dayName} - {$ticket.nameClass}</span>

                                                        <input type="number"
                                                               class="day-allocation-input"
                                                               placeholder="تعداد"
                                                               min="0"
                                                               value="{$ticket.count}"
                                                               name="agency_selected[{$agency.agency_id}][{$ticket.dayNumber}][{$ticket.idClass}]"
                                                               data-agency="{$agency.agency_id}"
                                                               data-day="{$ticket.dayNumber}"
                                                               data-grade="{$ticket.idClass}"
                                                               data-limit="{$ticket.count}"

                                                        >{*
                                                        max="{$ticket.count}"
                                                        onchange="updateGradeAllocation('{$agency.agency_id}', {$ticket.dayNumber}, {$ticket.idClass}, this.value)"
                                                        *}

                                                        <input type="hidden"
                                                               name="agency_day_grade_{$agency.agency_id}_{$ticket.dayNumber}_{$ticket.idClass}"
                                                               value="{$ticket.count}"
                                                               data-agency="{$agency.agency_id}"
                                                               data-day="{$ticket.dayNumber}"
                                                               data-grade="{$ticket.idClass}"
                                                        >

                                                    </div>

                                                {/foreach}

                                            </div>

                                        </div>

                                    {/foreach}

                                </div>
                            </div>
                        </div>
                    </div>


                   <div class="panel panel-default">
                        <div class="panel-heading TitleSectionsDashboard" style="cursor: pointer;" data-toggle="collapse" data-target="#userSelection">
                            <h6>
                                انتخاب کاربر
                                <div class="pull-right"><i class="fa fa-chevron-down"></i></div>
                            </h6>
                        </div>
                        <div id="userSelection" class="panel-collapse collapse" style="overflow: auto;">
                            <div class="panel-body">
                                <!-- جدول انتخاب کاربر -->
                                <table class="table color-table table-gray" id="SecondInsertForUser">
                                    <thead>
                                    <tr>
                                        <th>انتخاب کاربر</th>
                                        <th>درصد کمیسیون</th>
                                        <th>حداکثر خرید</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {assign var="tabIndex" value=99}
                                    {assign var="number" value="0"}
                                    {foreach key=key item=item from=$objPublic->listCounter}
                                        {$number=$number+1}
                                        <tr>
                                            <td>
                                                <div class="checkbox checkbox-success">
                                                    {assign var="tabIndex" value=$tabIndex+1}
                                                    <input id="chk_user{$number}" name="chk_user{$number}" class="form-control" tabindex="{$tabIndex}"
                                                           {if $objResult->users[$item.id]['type_user'] neq ''}checked{/if}
                                                           type="checkbox" value="1">
                                                    <label for="chk_user{$number}"> {$item.name} </label>
                                                </div>
                                            </td>
                                            <td>
                                                {assign var="tabIndex" value=$tabIndex+1}
                                                <input type="text" class="form-control" name="comition_ticket{$number}"
                                                       value="{$objResult->users[$item.id]['comition_ticket']}"
                                                       tabindex="{$tabIndex}"
                                                       id="comition_ticket{$number}" placeholder="درصد کمیسیون را وارد کنید">
                                            </td>
                                            <td>
                                                {assign var="tabIndex" value=$tabIndex+1}
                                                <input type="text" class="form-control" name="maximum_buy{$number}"
                                                       value="{$objResult->users[$item.id]['maximum_buy']}"
                                                       tabindex="{$tabIndex}"
                                                       id="maximum_buy{$number}" placeholder="حداکثر خرید را وارد کنید"></td>
                                            <input name="type_user{$number}" type="hidden" id="type_user{$number}" value="{$item.id}">
                                        </tr>
                                    {/foreach}
                                    </tbody>
                                </table>
                                <input name="count_other_user" type="hidden" id="count_other_user" value="{$number}">
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading TitleSectionsDashboard" tabindex="111" style="cursor: pointer;" data-toggle="collapse" data-target="#pricing">
                            <h6>
                                قیمت گذاری بلیط
                                <div class="pull-right"><i class="fa fa-chevron-down"></i></div>
                            </h6>
                        </div>
                        <div id="pricing" class="panel-collapse collapse" style="overflow: auto;">
                            <div class="panel-body">
                                <!-- جدول قیمت گذاری -->
                                <div class="table-responsive">
                                    <table class="table color-table table-gray" id="FirstInsertForUser">
                                        <thead>
                                        <tr>
                                            <th>سن</th>
                                            <th>قیمت یک LEG از دو طرفه</th>
                                            <th>قیمت چاپ</th>
                                            <th>قیمت یکطرفه</th>
                                            <th>قیمت چاپ</th>
                                            <th>قیمت بیش از n روز</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>بزرگسال(12+)</td>
                                            <input name="age1" type="hidden" id="age1" value="ADL">
                                            <td><input type="text" class="form-control" name="cost_two_way1"
                                                       value="{$objResult->priceTicket['ADL']['cost_two_way']|number_format:0:',':','}"
                                                       tabindex="112"
                                                       id="cost_two_way1" placeholder="قیمت یک LEG از دو طرفه"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_two_way_print1"
                                                       value="{$objResult->priceTicket['ADL']['cost_two_way_print']|number_format:0:',':','}"
                                                       tabindex="113"
                                                       id="cost_two_way_print1" placeholder="قیمت چاپ"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_one_way1"
                                                       value="{$objResult->priceTicket['ADL']['cost_one_way']|number_format:0:',':','}"
                                                       tabindex="114"
                                                       id="cost_one_way1" placeholder="قیمت یکطرفه"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_one_way_print1"
                                                       value="{$objResult->priceTicket['ADL']['cost_one_way_print']|number_format:0:',':','}"
                                                       tabindex="115"
                                                       id="cost_one_way_print1" placeholder="قیمت چاپ"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_Ndays1"
                                                       value="{$objResult->priceTicket['ADL']['cost_Ndays']|number_format:0:',':','}"
                                                       tabindex="116"
                                                       id="cost_Ndays1" placeholder="قیمت بیش از n روز"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>کودک(2 تا 12)</td>
                                            <input name="age2" type="hidden" id="age2" value="CHD">
                                            <td><input type="text" class="form-control" name="cost_two_way2"
                                                       value="{$objResult->priceTicket['CHD']['cost_two_way']|number_format:0:',':','}"
                                                       tabindex="117"
                                                       id="cost_two_way2" placeholder="قیمت یک LEG از دو طرفه"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_two_way_print2"
                                                       value="{$objResult->priceTicket['CHD']['cost_two_way_print']|number_format:0:',':','}"
                                                       tabindex="118"
                                                       id="cost_two_way_print2" placeholder="قیمت چاپ"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_one_way2"
                                                       value="{$objResult->priceTicket['CHD']['cost_one_way']|number_format:0:',':','}"
                                                       tabindex="119"
                                                       id="cost_one_way2" placeholder="قیمت یکطرفه"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_one_way_print2"
                                                       value="{$objResult->priceTicket['CHD']['cost_one_way_print']|number_format:0:',':','}"
                                                       tabindex="120"
                                                       id="cost_one_way_print2" placeholder="قیمت چاپ"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_Ndays2"
                                                       value="{$objResult->priceTicket['CHD']['cost_Ndays']|number_format:0:',':','}"
                                                       tabindex="121"
                                                       id="cost_Ndays2" placeholder="قیمت بیش از n روز"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>نوزاد(2-)</td>
                                            <input name="age3" type="hidden" id="age3" value="INF">
                                            <td><input type="text" class="form-control" name="cost_two_way3"
                                                       value="{$objResult->priceTicket['INF']['cost_two_way']|number_format:0:',':','}"
                                                       tabindex="122"
                                                       id="cost_two_way3" placeholder="قیمت یک LEG از دو طرفه"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_two_way_print3"
                                                       value="{$objResult->priceTicket['INF']['cost_two_way_print']|number_format:0:',':','}"
                                                       tabindex="123"
                                                       id="cost_two_way_print3" placeholder="قیمت چاپ"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_one_way3"
                                                       value="{$objResult->priceTicket['INF']['cost_one_way']|number_format:0:',':','}"
                                                       tabindex="124"
                                                       id="cost_one_way3" placeholder="قیمت یکطرفه"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_one_way_print3"
                                                       value="{$objResult->priceTicket['INF']['cost_one_way_print']|number_format:0:',':','}"
                                                       tabindex="125"
                                                       id="cost_one_way_print3" placeholder="قیمت چاپ"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_Ndays3"
                                                       value="{$objResult->priceTicket['INF']['cost_Ndays']|number_format:0:',':','}"
                                                       tabindex="126"
                                                       id="cost_Ndays3" placeholder="قیمت بیش از n روز"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- توضیحات -->
                                <div class="form-row m-t-20">
                                    <label for="description_ticket" class="control-label">توضیحات</label>
                                    <textarea type="text" class="form-control" name="description_ticket" id="description_ticket" placeholder="" tabindex="127">{$objResult->ticket['description_ticket']}</textarea>
                                </div>

                                <!-- خدمات -->
                                <div class="form-row m-t-20">
                                    <label for="services_ticket" class="control-label">خدمات</label>
                                    <textarea type="text" class="form-control" name="services_ticket" id="services_ticket" placeholder="" tabindex="128">{$objResult->ticket['services_ticket']}</textarea>
                                </div>

                                <!-- گزینه ویژه -->
                                <div class="form-group col-sm-2 m-t-20">
                                    <div class="checkbox checkbox-success">
                                        <input id="chk_flag_special" name="chk_flag_special" type="checkbox" value="1" tabindex="129" {if $objResult->ticket['flag_special'] eq 'yes'}checked{/if}>
                                        <label for="chk_flag_special"> ویژه </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-success" id="btn_FirstInsert" tabindex="130">ویرایش اطلاعات</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>

</div>
<div class="loaderPublic displayN"></div>
<script type="text/javascript" src="assets/JsFiles/reservationTicket.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationPublicFunctions.js"></script>
<script type="text/javascript" src="assets/JsFiles/ticketAdd.js"></script>
{if isset($smarty.get.id)}
    <script>
       var isEditMode = true;
    </script>
{/if}
<script type="text/javascript">
    // Pass PHP variable to JavaScript
    var hasFlyData = {$objResult->hasFlyData|default:false};

   // ۲. فانکشن مشترک جستجو
   function searchAgencies(query) {
      query = query.toLowerCase();
      return agencies.filter(a => a.name.toLowerCase().includes(query));
   }

    function filterAgencies(input) {
       var filter = $(input).val().toLowerCase().trim();
       var $ul = $(input).closest("ul");
       var items = $ul.find("li").not(":first");

       items.each(function(){
          var txt = $(this).find(".agency-name").text().toLowerCase();
          if (filter === "" || txt.indexOf(filter) !== -1) {
             $(this).show();
          } else {
             $(this).hide();
          }
       });
    }
    $(document).ready(function() {
       $('#seller_title').on('keyup', function() {
          var val = $(this).val();
          var list = $('#seller_suggestions');
          list.empty().hide();

          if (val.length > 0) {
             var results = searchAgencies(val); // اگه برای فروشنده‌ها هم آرایه ساختی
             if (results.length > 0) {
                results.forEach(function(a) {
                   list.append(
                      '<li class="list-group-item list-group-item-action" data-id="' + a.id + '">' + a.name + ' - ' + a.seat_code + '</li>'
                   );
                });
                list.show();
             }
          }
       });
    });

    // انتخاب از نتایج سرچ
    $(document).on('click', '#seller_suggestions li', function(){
       var name = $(this).text();
       var id = $(this).data('id');
       $('#seller_title').val(name);
       $('#seller_id').val(id);
       $('#sellerDropdown').text(name); // همزمان روی دکمه هم ست بشه
       $('#seller_suggestions').hide();
    });

    function selectSeller(id, name) {
       $('#sellerDropdown').text(name);
       $('#seller_id').val(id);
       $('#sellerDropdown').dropdown('toggle');
    }

    function filterSellerList(input) {
       var filter = input.value.toLowerCase();
       $('#seller_list li').each(function(){
          var text = $(this).text().toLowerCase();
          $(this).toggle(text.indexOf(filter) > -1);
       });
    }
</script>
<style>/* برای Chrome, Safari, Edge */
    .capacity-fields input[type=number]::-webkit-inner-spin-button,
    .capacity-fields input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .capacity-fields input[type=number] {
        -moz-appearance: textfield;
    }
</style>
