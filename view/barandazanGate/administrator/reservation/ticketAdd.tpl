{load_presentation_object filename="reservationTicket" assign="objResult"}
{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}

{$objPublic->getAllCounter('all')} {*گرفتن لیست انواع کانتر*}
{assign var=agencies value=$objPublic->getCharterSeatAgencies()} {*گرفتن لیست آژانس هایی که سیت چارتر دارند*}
{assign var=ListTypeOfVehicle value=$objPublic->listTypeOfPlane([
    'type_of_vehicle' => $objResult->flyDataForTicket.type_of_vehicle_id,
    'selected_id' => $objResult->flyDataForTicket.type_of_plane
])}

{load_presentation_object filename="temporaryData" assign="objTemporary"}
{assign var="tempData" value=$objTemporary->getAllByReference($smarty.get.fly_id,'fly_number')}
{assign var="jsonData" value=$tempData.data|@json_decode:true}

<link href="assets/css/ticketAdd.css" rel="stylesheet">
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>بازرگانی</li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/reservation/reportTicket">گزارش چارتری</a></li>
                <li class="active">افزودن برنامه پروازی جدید</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <form id="FormTicket2" method="post" action="">
                    <input type="hidden" name="flag" value="insert_ticket">
                    {* Flight Data Display Table - Show when hasFlyData is true *}
                    {if $objResult->hasFlyData}
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
                    {/if}

                    {* Hidden inputs to preserve values when hasFlyData is true *}
                    {if $objResult->hasFlyData}
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
                        <input type="hidden" name="vehicle_grade" value="{$objResult->flyDataForTicket.vehicle_grade_id}">
                        <input type="hidden" name="day_onrequest" value="{$objResult->flyDataForTicket.day_onrequest}">
                    {/if}

                    {* Form fields - hidden when hasFlyData is true *}
                    <div class="form-group col-sm-4 {if $objResult->hasFlyData}form-field-hidden{/if}">
                        <label for="origin_country" class="control-label">کشور مبدا</label><span class="star">*</span>
                        <select name="origin_country" id="origin_country" class="form-control " >
                            <option value="">انتخاب کنید....</option>
                            {foreach $objPublic->ListCountry() as $country}
                                <option value="{$country['id']}" {if $objResult->hasFlyData && $objResult->flyDataForTicket.origin_country == $country['id']}selected{/if}>{$country['name']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-4 {if $objResult->hasFlyData}form-field-hidden{/if}">
                        <label for="origin_city" class="control-label">شهر مبدا</label><span class="star">*</span>
                        <select name="origin_city" id="origin_city" class="form-control " >
                            {if $objResult->hasFlyData}
                                <option value="{$objResult->flyDataForTicket.origin_city}" selected>{$objResult->flyDataForTicket.origin_city_name}</option>
                            {/if}
                        </select>
                    </div>
                    <div class="form-group col-sm-4 {if $objResult->hasFlyData}form-field-hidden{/if}">
                        <label for="origin_region" class="control-label">منطقه مبدا</label>
                        <select name="origin_region" id="origin_region" class="form-control " >
                            {if $objResult->hasFlyData}
                                <option value="{$objResult->flyDataForTicket.origin_region}" selected>{$objResult->flyDataForTicket.origin_region_name}</option>
                            {/if}
                        </select>
                    </div>
                    <div class="form-group col-sm-4 {if $objResult->hasFlyData}form-field-hidden{/if}">
                        <label for="destination_country" class="control-label">کشور مقصد</label><span
                                class="star">*</span>
                        <select name="destination_country" id="destination_country" class="form-control " >
                            <option value="">انتخاب کنید....</option>
                            {foreach $objPublic->ListCountry() as $country}
                                <option value="{$country['id']}" {if $objResult->hasFlyData && $objResult->flyDataForTicket.destination_country == $country['id']}selected{/if}>{$country['name']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-4 {if $objResult->hasFlyData}form-field-hidden{/if}">
                        <label for="destination_city" class="control-label">شهر مقصد</label><span class="star">*</span>
                        <select name="destination_city" id="destination_city" class="form-control " >
                            {if $objResult->hasFlyData}
                                <option value="{$objResult->flyDataForTicket.destination_city}" selected>{$objResult->flyDataForTicket.destination_city_name}</option>
                            {/if}
                        </select>
                    </div>
                    <div class="form-group col-sm-4 {if $objResult->hasFlyData}form-field-hidden{/if}">
                        <label for="destination_region" class="control-label">منطقه مقصد</label>
                        <select name="destination_region" id="destination_region" class="form-control " >
                            {if $objResult->hasFlyData}
                                <option value="{$objResult->flyDataForTicket.destination_region}" selected>{$objResult->flyDataForTicket.destination_region_name}</option>
                            {/if}
                        </select>
                    </div>
                    <div class="form-group col-sm-3 {if $objResult->hasFlyData}form-field-hidden{/if}">
                        <label for="airline" class="control-label">شرکت حمل و نقل</label><span class="star">*</span>
                        <select name="airline" id="airline" class="form-control " onChange="FlyCodeTicket()" >
                            <option value="">انتخاب کنید....</option>
                            {foreach $objPublic->ListOtherAirline() as $airline}
                                <option value="{$airline['id']}" {if $objResult->hasFlyData && $objResult->flyDataForTicket.airline == $airline['id']}selected{/if}>{$airline['name']}</option>
                            {/foreach}
                            {foreach $objPublic->ListAirline() as $airline}
                                <option value="{$airline['id']}" {if $objResult->hasFlyData && $objResult->flyDataForTicket.airline == $airline['id']}selected{/if}>{$airline['name_fa']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-3 {if $objResult->hasFlyData}form-field-hidden{/if}">
                        <label for="fly_code" class="control-label">شماره پرواز</label><span class="star">*</span>
                        <select name="fly_code" id="fly_code" class="form-control " onChange="InformationFlyNumber()" >
                            <option value="">انتخاب کنید....</option>
                            {if $objResult->hasFlyData}
                                <option value="{$objResult->flyDataForTicket.id}" selected>{$objResult->flyDataForTicket.fly_code}</option>
                            {/if}
                        </select>
                    </div>
                    <div class="form-group col-sm-2 {if $objResult->hasFlyData}form-field-hidden{/if}">
                        <label for="vehicle_grade" class="control-label"> درجه وسیله نقلیه</label>
                        <input type="text" class="form-control" name="vehicle_grade"
                               value="{if $objResult->hasFlyData}{$objResult->flyDataForTicket.vehicle_grade_id}{/if}"
                               id="vehicle_grade"
                               placeholder="درجه وسیله نقلیه را وارد کنید"
                                {if $objResult->hasFlyData}{/if}
                        >
                    </div>
                    <div class="form-group col-sm-2 {if $objResult->hasFlyData}form-field-hidden{/if}">
                        <label for="flight_time" class="control-label">مدت زمان پرواز</label><span class="star">*</span>
                        <input type="text" class="form-control" name="flight_time" value="{if $objResult->hasFlyData}{$objResult->flyDataForTicket.time}{/if}"
                               id="flight_time" placeholder="مدت زمان پرواز را وارد کنید" {if $objResult->hasFlyData}{/if}>
                    </div>
                    <div class="form-group col-sm-3 {if $objResult->hasFlyData}form-field-hidden{/if}">
                        <label for="type_of_vehicle" class="control-label">مدل وسیله نقلیه</label><span
                                class="star">*</span>
                        <select name="type_of_vehicle" id="type_of_vehicle" class="form-control " >
                            <option value="">انتخاب کنید....</option>
                            {foreach key=key item=item from=$objResult->showTypeOfVehicle()}
                                <option value="{$item['id']}" {if $objResult->hasFlyData && $objResult->flyDataForTicket.type_of_vehicle_id == $item['id']}selected{/if}>{$item['name']} - {$item['name_type_model']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-2 {if $objResult->hasFlyData}form-field-hidden{/if}">
                        <label for="day_onrequest" class="control-label">زمان توقف فروش (ساعت)</label>
                        <input type="text" class="form-control" name="day_onrequest" value="{if $objResult->hasFlyData}{$objResult->flyDataForTicket.day_onrequest}{/if}"
                               id="day_onrequest" placeholder="زمان توقف فروش را وارد کنید" {if $objResult->hasFlyData}{/if}>
                    </div>

                    <!-- INFO FLY CONTAINER (REPLACEMENT) -->
                    <!-- ================= INFO FLY BOX ================= -->

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-sm-12">

                            <div class="info-fly-container">

                                <div class="info-fly-title">
                                    <i class="fa fa-plane"></i>
                                    اطلاعات فروش بلیط
                                </div>

                                <div class="row">

                                    <!-- بار رایگان -->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>میزان بار رایگان</label>
                                            <input type="text" class="form-control" id="free" value="20">
                                        </div>
                                    </div>

                                    <!-- درجه وسیله نقلیه -->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>درجه وسیله نقلیه <span class="star">*</span></label>
                                            <select id="vehicle_grades" class="form-control select2" multiple>
                                                {foreach $objResult->getAllGrades() as $g}
                                                    <option value="{$g.id}">{$g.name}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                    </div>

                                    <!-- فروشنده -->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>نام فروشنده <span class="star">*</span></label>

                                            <div class="dropdown seller-dropdown">
                                                <div class="form-control dropdown-toggle"
                                                     data-toggle="dropdown"
                                                     id="sellerDropdown"
                                                     role="button">
                                                    <span id="sellerDropdownText">انتخاب فروشنده</span>
                                                    <i class="fa fa-chevron-down pull-left"></i>
                                                </div>

                                                <ul class="dropdown-menu">
                                                    <li class="px-2">
                                                        <input type="text"
                                                               class="form-control input-sm"
                                                               placeholder="جستجو..."
                                                               onkeyup="filterSellerList(this)">
                                                    </li>

                                                    {foreach $agencies as $seller}
                                                        <li>
                                                            <a href="javascript:void(0)"
                                                               onclick="selectSeller('{$seller.id}','{$seller.name_fa}')">
                                                                {$seller.name_fa}
                                                            </a>
                                                        </li>
                                                    {/foreach}
                                                </ul>
                                            </div>

                                            <input type="hidden" id="seller_id">
                                        </div>
                                    </div>

                                    <!-- قیمت -->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>قیمت هر صندلی <span class="star">*</span></label>
                                            <input type="text" class="form-control" id="seller_price">
                                        </div>
                                    </div>

                                    <!-- تاریخ شروع -->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>شروع تاریخ پرواز <span class="star">*</span></label>
                                            <input type="text" class="form-control datepicker" id="start_date">
                                        </div>
                                    </div>

                                    <!-- تاریخ پایان -->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>پایان تاریخ پرواز <span class="star">*</span></label>
                                            <input type="text" class="form-control datepicker" id="end_date">
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- ================= /INFO FLY BOX ================= -->



                    <!-- /INFO FLY CONTAINER -->


                    <div class="form-row day-selection-container">
                        <div class="day-selection-title">
                            <i class="fa fa-calendar"></i>
                            انتخاب روزها<span class="star">*</span>
                        </div>

                        <!-- Day Selection Cards -->
                        <div class="day-cards-grid" id="daySelectionCards">
                            <!-- شنبه -->
                            <div class="day-card" id="dayCard0">
                                <div class="day-card-indicator"></div>
                                <div class="day-card-header">
                                    <div class="checkbox checkbox-success">
                                        <input id="sh0" name="sh0" class="day-checkbox" type="checkbox" value="0" tabindex="7" onchange="toggleDayCardChange(0)">
                                        <label for="sh0">شنبه</label>
                                    </div>
                                </div>
                                <div class="day-card-body" id="dayCardBody0">
                                    <div class="day-card-content">
                                        <div class="time-input-group">
                                            <input type="text" name="day_departure_time_0" id="day_departure_time_0"
                                                   class="time-input input-change-price w-100"
                                                   data-time-format="true" placeholder="ساعت حرکت" maxlength="5"
                                                   value="{$tmp.departure_hours}:{$tmp.departure_minutes}"  tabindex="9">
                                        </div>
                                        <div class="capacity-field">
                                            <select name="day_type_of_vehicle_0" id="day_type_of_vehicle_0" class="form-control" tabindex="10">
                                                {$ListTypeOfVehicle nofilter}
                                            </select>
                                        </div>
                                        <div class="capacity-fields" id="capacityFields0">
                                            <!-- Capacity fields will be dynamically generated here -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- یکشنبه -->
                            <div class="day-card" id="dayCard1">
                                <div class="day-card-indicator"></div>
                                <div class="day-card-header">
                                    <div class="checkbox checkbox-success">
                                        <input id="sh1" name="sh1" class="day-checkbox" type="checkbox" value="1"  tabindex="14" onchange="toggleDayCardChange(1)">
                                        <label for="sh1">یکشنبه</label>
                                    </div>
                                </div>
                                <div class="day-card-body" id="dayCardBody1">
                                    <div class="day-card-content">
                                        <div class="time-input-group">
                                            <input type="text" name="day_departure_time_1" id="day_departure_time_1"
                                                   class="time-input input-change-price w-100" data-time-format="true"
                                                   placeholder="ساعت حرکت" maxlength="5"
                                                   value="{$tmp.departure_hours}:{$tmp.departure_minutes}" tabindex="15">
                                        </div>
                                        <div class="capacity-field">
                                            <select name="day_type_of_vehicle_1" id="day_type_of_vehicle_1" class="form-control" tabindex="16">
                                                {$ListTypeOfVehicle nofilter}
                                            </select>
                                        </div>
                                        <div class="capacity-fields" id="capacityFields1">
                                            <!-- Capacity fields will be dynamically generated here -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- دوشنبه -->
                            <div class="day-card" id="dayCard2">
                                <div class="day-card-indicator"></div>
                                <div class="day-card-header">
                                    <div class="checkbox checkbox-success">
                                        <input id="sh2" name="sh2" class="day-checkbox" type="checkbox" value="2" tabindex="20" onchange="toggleDayCardChange(2)">
                                        <label for="sh2">دوشنبه</label>
                                    </div>
                                </div>
                                <div class="day-card-body" id="dayCardBody2">
                                    <div class="day-card-content">
                                        <div class="time-input-group">
                                            <input type="text" name="day_departure_time_2" id="day_departure_time_2"
                                                   class="time-input input-change-price w-100" data-time-format="true" tabindex="21"
                                                   placeholder="ساعت حرکت" maxlength="5" value="{$tmp.departure_hours}:{$tmp.departure_minutes}">
                                        </div>
                                        <div class="capacity-field">
                                            <select name="day_type_of_vehicle_2" id="day_type_of_vehicle_2" class="form-control" tabindex="22">
                                                {$ListTypeOfVehicle nofilter}
                                            </select>
                                        </div>
                                        <div class="capacity-fields" id="capacityFields2">
                                            <!-- Capacity fields will be dynamically generated here -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- سه‌شنبه -->
                            <div class="day-card" id="dayCard3">
                                <div class="day-card-indicator"></div>
                                <div class="day-card-header">
                                    <div class="checkbox checkbox-success">
                                        <input id="sh3" name="sh3" class="day-checkbox" type="checkbox" value="3" tabindex="26" onchange="toggleDayCardChange(3)">
                                        <label for="sh3">سه‌شنبه</label>
                                    </div>
                                </div>
                                <div class="day-card-body" id="dayCardBody3">
                                    <div class="day-card-content">
                                        <div class="time-input-group">
                                            <input type="text" name="day_departure_time_3" id="day_departure_time_3"
                                                   class="time-input input-change-price w-100" data-time-format="true" tabindex="27"
                                                   placeholder="ساعت حرکت" maxlength="5" value="{$tmp.departure_hours}:{$tmp.departure_minutes}">
                                        </div>
                                        <div class="capacity-field">
                                            <select name="day_type_of_vehicle_3" id="day_type_of_vehicle_3" class="form-control" tabindex="28">
                                                {$ListTypeOfVehicle nofilter}
                                            </select>
                                        </div>
                                        <div class="capacity-fields" id="capacityFields3">
                                            <!-- Capacity fields will be dynamically generated here -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- چهارشنبه -->
                            <div class="day-card" id="dayCard4">
                                <div class="day-card-indicator"></div>
                                <div class="day-card-header">
                                    <div class="checkbox checkbox-success">
                                        <input id="sh4" name="sh4" class="day-checkbox" type="checkbox" value="4" tabindex="32" onchange="toggleDayCardChange(4)">
                                        <label for="sh4">چهارشنبه</label>
                                    </div>
                                </div>
                                <div class="day-card-body" id="dayCardBody4">
                                    <div class="day-card-content">
                                        <div class="time-input-group">
                                            <input type="text" name="day_departure_time_4" id="day_departure_time_4"
                                                   class="time-input input-change-price w-100" data-time-format="true" tabindex="33"
                                                   placeholder="ساعت حرکت" maxlength="5" value="{$tmp.departure_hours}:{$tmp.departure_minutes}">
                                        </div>
                                        <div class="capacity-field">
                                            <select name="day_type_of_vehicle_4" id="day_type_of_vehicle_4" class="form-control" tabindex="34">
                                                {$ListTypeOfVehicle nofilter}
                                            </select>
                                        </div>
                                        <div class="capacity-fields" id="capacityFields4">
                                            <!-- Capacity fields will be dynamically generated here -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- پنج‌شنبه -->
                            <div class="day-card" id="dayCard5">
                                <div class="day-card-indicator"></div>
                                <div class="day-card-header">
                                    <div class="checkbox checkbox-success">
                                        <input id="sh5" name="sh5" class="day-checkbox" type="checkbox" value="5" tabindex="38" onchange="toggleDayCardChange(5)">
                                        <label for="sh5">پنج‌شنبه</label>
                                    </div>
                                </div>
                                <div class="day-card-body" id="dayCardBody5">
                                    <div class="day-card-content">
                                        <div class="time-input-group">
                                            <input type="text" name="day_departure_time_5" id="day_departure_time_5"
                                                   class="time-input input-change-price w-100" data-time-format="true" tabindex="39"
                                                   placeholder="ساعت حرکت" maxlength="5" value="{$tmp.departure_hours}:{$tmp.departure_minutes}">
                                        </div>
                                        <div class="capacity-field">
                                            <select name="day_type_of_vehicle_5" id="day_type_of_vehicle_5" class="form-control" tabindex="40">
                                                {$ListTypeOfVehicle nofilter}
                                            </select>
                                        </div>
                                        <div class="capacity-fields" id="capacityFields5">
                                            <!-- Capacity fields will be dynamically generated here -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- جمعه -->
                            <div class="day-card" id="dayCard6">
                                <div class="day-card-indicator"></div>
                                <div class="day-card-header">
                                    <div class="checkbox checkbox-success">
                                        <input id="sh6" name="sh6" class="day-checkbox" type="checkbox" value="6" tabindex="44" onchange="toggleDayCardChange(6)">
                                        <label for="sh6">جمعه</label>
                                    </div>
                                </div>
                                <div class="day-card-body" id="dayCardBody6">
                                    <div class="day-card-content">
                                        <div class="time-input-group">
                                            <input type="text" name="day_departure_time_6" id="day_departure_time_6"
                                                   class="time-input input-change-price w-100" data-time-format="true" tabindex="45"
                                                   placeholder="ساعت حرکت" maxlength="5" value="{$tmp.departure_hours}:{$tmp.departure_minutes}">
                                        </div>
                                        <div class="capacity-field">
                                            <select name="day_type_of_vehicle_6" id="day_type_of_vehicle_6" class="form-control" tabindex="46">
                                                {$ListTypeOfVehicle nofilter}
                                            </select>
                                        </div>
                                        <div class="capacity-fields" id="capacityFields6">
                                            <!-- Capacity fields will be dynamically generated here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                   <div class="form-row compact-allocation-section">
                            <div class="compact-header">
                                <div class="header-left">
                                    <i class="fa fa-users"></i>
                                    <h5>اختصاص سهمیه صندلی  </h5>
                                </div>
                                <!-- Agency Selection -->
                                <div class="compact-agency-selection">
                                    <!-- Compact Capacity Limits -->
                                    <div class="compact-limits" id="capacityLimitsPanel" style="display: none;">
                                        <div class="compact-limits-grid" id="limitsGrid">
                                            <!-- Dynamic content will be inserted here -->
                                        </div>
                                    </div>
                                    به
                                    <div class="dropdown-wrapper">
                                        <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                                id="dropdownMenu1" data-toggle="dropdown" tabindex="50"
                                                aria-haspopup="true" aria-expanded="true">
                                            <i class="fa fa-plus"></i>
                                            همکار
                                        </button>

                                        <ul class="dropdown-menu checkbox-menu allow-focus" aria-labelledby="dropdownMenu1" style="max-height:250px;overflow-y:auto;">
                                            <!-- سرچ -->
                                            <li class="px-2">
                                                <input type="text" class="form-control form-control-sm" placeholder="جستجو..." onkeyup="filterAgencies(this)">
                                            </li>
                                            <!-- گزینه‌ها -->
                                            {foreach $agencies as $agency}
                                                <li>
                                                    <label class="agency-checkbox d-block px-2 py-1">
                                                        <input type="checkbox" onclick="selectAgencyForDays('{$agency['id']}','{$agency['name_fa']}',this)">
                                                        <span class="agency-name">{$agency['name_fa']} - {$agency['seat_charter_code']}</span>
                                                    </label>
                                                </li>
                                            {/foreach}
                                        </ul>

                                        <script>
                                           // ۱. آرایه آژانس‌ها
                                           var agencies = [
                                               {foreach $agencies as $agency}
                                              { id: "{$agency['id']}", name: "{$agency['name_fa']}", seat_code: "{$agency['seat_charter_code']}" }{if !$agency@last},{/if}
                                               {/foreach}
                                           ];
                                        </script>
                                    </div>
                                </div>

                                <div class="header-right">
                                    <div class="compact-status" id="allocationStatus">
                                        <span class="status-dot"></span>
                                        <span class="status-text">آماده</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="compact-content">

                                <!-- Compact Agency Allocation Grid -->
                                <div id="agency-allocation-grid" class="compact-allocation-grid" style="display: none;">
                                <!-- Dynamic content will be inserted here -->
                                </div>
                                
                                <!-- Compact Empty State -->
                                <div id="agency-empty-state" class="compact-empty-state">
                                    <i class="fa fa-calendar-check-o"></i>
                                    <span>ابتدا روزهای هفته و سپس آژانس‌ها را انتخاب کنید</span>
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
                                                           {if $number eq 1 || $number eq 2}checked{/if}
                                                           type="checkbox" value="1">
                                                    <label for="chk_user{$number}"> {$item.name} </label>
                                                </div>
                                            </td>
                                            <td>
                                                {assign var="tabIndex" value=$tabIndex+1}
                                                <input type="text" class="form-control" name="comition_ticket{$number}" value="" tabindex="{$tabIndex}"
                                                       id="comition_ticket{$number}" placeholder="درصد کمیسیون را وارد کنید">
                                            </td>
                                            <td>
                                                {assign var="tabIndex" value=$tabIndex+1}
                                                <input type="text" class="form-control" name="maximum_buy{$number}" value="" tabindex="{$tabIndex}"
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
                                            <td><input type="text" class="form-control" name="cost_two_way1" value="" tabindex="112"
                                                       id="cost_two_way1" placeholder="قیمت یک LEG از دو طرفه"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_two_way_print1" value="" tabindex="113"
                                                       id="cost_two_way_print1" placeholder="قیمت چاپ"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_one_way1" value="" tabindex="114"
                                                       id="cost_one_way1" placeholder="قیمت یکطرفه"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_one_way_print1" value="" tabindex="115"
                                                       id="cost_one_way_print1" placeholder="قیمت چاپ"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_Ndays1" value="" tabindex="116"
                                                       id="cost_Ndays1" placeholder="قیمت بیش از n روز"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>کودک(2 تا 12)</td>
                                            <input name="age2" type="hidden" id="age2" value="CHD">
                                            <td><input type="text" class="form-control" name="cost_two_way2" value="" tabindex="117"
                                                       id="cost_two_way2" placeholder="قیمت یک LEG از دو طرفه"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_two_way_print2" value="" tabindex="118"
                                                       id="cost_two_way_print2" placeholder="قیمت چاپ"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_one_way2" value="" tabindex="119"
                                                       id="cost_one_way2" placeholder="قیمت یکطرفه"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_one_way_print2" value="" tabindex="120"
                                                       id="cost_one_way_print2" placeholder="قیمت چاپ"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_Ndays2" value="" tabindex="121"
                                                       id="cost_Ndays2" placeholder="قیمت بیش از n روز"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>نوزاد(2-)</td>
                                            <input name="age3" type="hidden" id="age3" value="INF">
                                            <td><input type="text" class="form-control" name="cost_two_way3" value="" tabindex="122"
                                                       id="cost_two_way3" placeholder="قیمت یک LEG از دو طرفه"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_two_way_print3" value="" tabindex="123"
                                                       id="cost_two_way_print3" placeholder="قیمت چاپ"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_one_way3" value="" tabindex="124"
                                                       id="cost_one_way3" placeholder="قیمت یکطرفه"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_one_way_print3" value="" tabindex="125"
                                                       id="cost_one_way_print3" placeholder="قیمت چاپ"
                                                       onkeypress="isDigit(this)" onkeyup="javascript:separator(this);">
                                            </td>
                                            <td><input type="text" class="form-control" name="cost_Ndays3" value="" tabindex="126"
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
                                    <textarea type="text" class="form-control" name="description_ticket" id="description_ticket" placeholder="" tabindex="127"></textarea>
                                </div>

                                <!-- خدمات -->
                                <div class="form-row m-t-20">
                                    <label for="services_ticket" class="control-label">خدمات</label>
                                    <textarea type="text" class="form-control" name="services_ticket" id="services_ticket" placeholder="" tabindex="128"></textarea>
                                </div>

                                <!-- گزینه ویژه -->
                                <div class="form-group col-sm-2 m-t-20">
                                    <div class="checkbox checkbox-success">
                                        <input id="chk_flag_special" name="chk_flag_special" type="checkbox" value="1" tabindex="129">
                                        <label for="chk_flag_special"> ویژه </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-success" id="btn_FirstInsert" tabindex="130">ارسال اطلاعات</button>
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
