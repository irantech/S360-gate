{load_presentation_object filename="manifestController" assign="objManifestController"}
{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}

{assign var="filterOptions" value=$objManifestController->getFilterOptions()}
{assign var="manifestResult" value=$objManifestController->getPaginatedManifestResults()}
{assign var="manifestData" value=$manifestResult.data}
{assign var="manifestStats" value=$objManifestController->getManifestStatistics()}
{assign var="vehicleGrades" value=$objManifestController->getVehicleGrades()}
{assign var="ListSeller" value=$objPublic->getCharterSeatAgencies()} {*گرفتن لیست آژانس هایی که سیت چارتر دارند*}
{assign var="ListTypeOfPlane" value=$objPublic->listAllTypeOfPlane()}
{assign var="ListAllFlyCode" value=$objPublic->ListAllFlyCode()}

<link href="assets/css/resultReservationTicket.css" rel="stylesheet">
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>بازرگانی</li>
                <li class="active">لیست برنامه پروازها</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <!-- Filter Bar -->
            <div class="filter-bar">
                <div class="filter-header">
                    <h4><i class="fa fa-filter"></i> فیلترهای جستجو</h4>
                </div>
                <div class="filter-grid">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label for="dateFrom">از تاریخ:</label>
                            <input type="text" class="filter-input datepicker" tabindex="1" value="{$filterOptions.currentDate|replace:"/":"-"}"
                                   id="dateFrom" name="dateFrom">
                        </div>
                        <div class="filter-group">
                            <label for="dateTo">تا تاریخ:</label>
                            <input type="text" class="filter-input datepicker" tabindex="2" value="{$filterOptions.tomorrowDate|replace:"/":"-"}" id="dateTo" name="dateTo" >
                        </div>

                        <div class="filter-group">
                            <label for="weekDaysFilterSelect" class="control-label">روزهای هفته: </label>
                            <select name="weekDaysFilter[]" id="weekDaysFilterSelect" multiple class="select2"  tabindex="3">
                                <option value="شنبه">شنبه</option>
                                <option value="یکشنبه">یکشنبه</option>
                                <option value="دوشنبه">دوشنبه</option>
                                <option value="سه شنبه">سه شنبه</option>
                                <option value="چهارشنبه">چهارشنبه</option>
                                <option value="پنجشنبه">پنجشنبه</option>
                                <option value="جمعه">جمعه</option>
                            </select>
                        </div>


                        <div class="filter-group">
                            <label for="airlineFilter">هواپیمایی:</label>
                            <select class="filter-select" id="airlineFilter" name="airlineFilter" tabindex="3">
                                <option value="">همه</option>
                                {foreach from=$filterOptions.airlines item=airline}
                                    <option value="{$airline.value}">{$airline.label}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="filter-group" style="position: relative; width: 100%;">
                            <label for="flightDropdownFilter">شماره پرواز:</label>
                            <div class="dropdown">
                                <div  tabindex="4" class="form-control filter-select dropdown-toggle d-flex justify-content-between align-items-center"
                                     id="flightDropdownFilter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                     role="button" style="padding: 0.75rem 1rem !important;">
                                    <span id="flightDropdownFilterText">انتخاب کنید</span>
                                    <i class="fa fa-chevron-down small" aria-hidden="true"></i>
                                </div>
                                <div class="dropdown-menu w-100 p-2" aria-labelledby="flightDropdownFilter"
                                     style="max-height:260px; overflow-y:auto;">
                                    <input type="text" class="form-control form-control-sm mb-2"
                                           placeholder="جستجو..." onkeyup="filterFlightList(this)">
                                    <ul id="flight_list" class="list-unstyled mb-0">
                                        <li>
                                            <a href="javascript:void(0)" class="dropdown-item py-1"  onclick="clearFlyCodeFilter()">
                                                — هیچ کدام —
                                            </a>
                                        </li>
                                        {foreach $filterOptions.fly_codes as $flyCode}
                                            <li>
                                                <a href="javascript:void(0)" class="dropdown-item py-1"
                                                   onclick="selectFlight('{$flyCode}', '{$flyCode}')">
                                                    {$flyCode}
                                                </a>
                                            </li>
                                        {/foreach}
                                    </ul>
                                </div>
                            </div>
                            <input type="hidden" name="flyCodeFilter" id="flyCodeFilter">
                        </div>
                    </div>
                    <div class="filter-row">
                        <div class="filter-group">
                            <label for="flightClassFilter">کلاس پرواز:</label>
                            <select class="filter-select" id="flightClassFilter" name="flightClassFilter" tabindex="5">
                                <option value="">همه</option>
                                {foreach from=$filterOptions.vehicle_grades item=grade}
                                    <option value="{$grade}">{$grade}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="originFilter">مبدأ:</label>
                            <select class="filter-select" id="originFilter" name="originFilter" tabindex="6">
                                <option value="">همه</option>
                                {foreach from=$filterOptions.origins item=origin}
                                    <option value="{$origin}">{$origin}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="destinationFilter">مقصد:</label>
                            <select class="filter-select" id="destinationFilter" name="destinationFilter" tabindex="7">
                                <option value="">همه</option>
                                {foreach from=$filterOptions.destinations item=destination}
                                    <option value="{$destination}">{$destination}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="filter-group" style="position: relative; width: 100%;">
                            <label for="sellerFilter">فروشنده:</label>

                            <div class="dropdown">
                                <div tabindex="8" class="form-control filter-select dropdown-toggle d-flex justify-content-between align-items-center"
                                     id="sellerDropdownFilter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                     role="button" style="padding: 0.75rem 1rem !important;" >
                                    <span id="sellerDropdownFilterText">انتخاب کنید</span>
                                    <i class="fa fa-chevron-down small" aria-hidden="true"></i>
                                </div>
                                <div class="dropdown-menu w-100 p-2" aria-labelledby="sellerDropdownFilter"
                                     style="max-height:260px; overflow-y:auto;">
                                    <input type="text" class="form-control form-control-sm mb-2"
                                           placeholder="جستجو..." onkeyup="filterSellerListFilter(this)">
                                    <ul id="seller_list_filter" class="list-unstyled mb-0">
                                        <li>
                                            <a href="javascript:void(0)" class="dropdown-item py-1"  onclick="clearSellerFilter()">
                                                — هیچ کدام —
                                            </a>
                                        </li>
                                        {foreach $ListSeller  as $seller}
                                            <li>
                                                <a href="javascript:void(0)" class="dropdown-item py-1"
                                                   onclick="selectSellerFilter('{$seller.id}', '{$seller.name_fa}')">
                                                    {$seller.name_fa} - {$seller.seat_charter_code}
                                                </a>
                                            </li>
                                        {/foreach}
                                    </ul>
                                </div>
                            </div>

                            <input type="hidden" name="seller_id_filter" id="seller_id_filter">
                        </div>
                        <div class="filter-group">
                            <label for="statusFilter">وضعیت:</label>
                            <select class="filter-select" id="statusFilter" name="statusFilter" tabindex="9">
                                <option value="">همه</option>
                                <option value="Cancelled">کنسلی</option>
                                <option value="Blocked">مسدودی</option>
                                <option value="Actived">فعال</option>
                            </select>
                        </div>
                    </div>
                    <div class="filter-row">
                        <div class="filter-actions">
                            <button type="button" class="btn-filter" onclick="loadManifestData()" tabindex="10">
                                <i class="fa fa-filter"></i>
                                اعمال فیلتر
                            </button>
                            <button type="button" class="btn-clear" onclick="clearFilters()" tabindex="11">
                                <i class="fa fa-times"></i>
                                پاک کردن فیلترها
                            </button>
                        </div>
                    </div>

                    <div class="box-btn-excel" style="margin-right: 10px;">
                        <a onclick="FunCreateExcelManifest()" class="btn btn-success waves-effect waves-light "
                           type="button" id="btn-excel">
                            <span class="btn-label"><i class="fa fa-download"></i></span>اکسل لیست پروازها</a>

                        <a onclick="FunPrintManifest()" class="btn btn-info waves-effect waves-light "
                           type="button" id="btn-print_manifest">
                            <span class="btn-label"><i class="fa fa-download"></i></span>پرینت لیست پروازها</a>

                        <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/load.gif" alt="please wait ..."
                             id="loader-excel" class="displayN">
                    </div>

                </div>
            </div>

            <!-- Statistics Cards -->
            {if $manifestStats.total_flights > 0}
                <div class="stats-cards">
                    <div class="stat-card">
                        <div class="stat-icon primary">
                            <i class="fa fa-plane"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-number">{$manifestStats.total_flights}</span>
                            <span class="stat-label">کل پروازها</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon success">
                            <i class="fa fa-ticket"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-number">{$manifestStats.total_tickets}</span>
                            <span class="stat-label">کل بلیط‌ها</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon warning">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-number">{$manifestStats.total_passengers}</span>
                            <span class="stat-label">کل مسافران</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon info">
                            <i class="fa fa-chart-pie"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-number">{$manifestStats.total_capacity}</span>
                            <span class="stat-label">کل ظرفیت</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card">
                            <div class="stat-icon success">
                                <i class="fa fa-check-circle"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-number">{$manifestStats.total_booked}</span>
                                <span class="stat-label">رزرو شده</span>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon danger">
                            <i class="fa fa-clock-o"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-number">{$manifestStats.total_remaining}</span>
                            <span class="stat-label">باقی مانده</span>
                        </div>
                    </div>
                </div>
            {/if}

            <!-- Main Table -->

                <div class="table-container" style="padding-bottom: 20px !important;{if !$manifestData} display: none !important;  {/if}">
                    <div class="ShowResultManiFest">
                        <div class="table-wrapper" style="margin-bottom: 20px !important;">
                        <table id="flightsTable" class="display">
                            <thead>
                            <tr>
                                {*<th style="text-align: right !important;">
                                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                </th>*}
                                <th style="text-align: right !important;">ردیف</th>
                                <th style="text-align: right !important;">فروشنده</th>
                                <th style="text-align: right !important;">ایرلاین</th>
                                <th style="text-align: right !important;">پرواز</th>
                                <th style="text-align: right !important;">کلاس</th>
                                <th style="text-align: right !important;">روز</th>
                                <th style="text-align: right !important;">تاریخ</th>
                                <th style="text-align: right !important;">مبدا</th>
                                <th style="text-align: right !important;">مقصد</th>
                                <th style="text-align: right !important;">حرکت</th>
                                <th style="text-align: right !important;">فرود</th>
                                <th style="text-align: right !important;">وضعیت</th>
                                <th style="text-align: right !important;">مانیفست</th>
                                <th style="text-align: right !important;">خرید</th>
                                <th style="text-align: right !important;">واگذار</th>
                                <th style="text-align: right !important;">مانده</th>
                                <th style="text-align: right !important;">رزرو</th>
                                <th style="text-align: right !important;">مانده کل</th>
                                <th style="text-align: right !important;">  عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            {if $manifestData}
                            {assign var="rowIndex" value=0}
                            {foreach from=$manifestData item=dateData name=dateLoop}
                                {foreach from=$dateData.routes item=routeData name=routeLoop}
                                    {foreach from=$routeData.flights item=flightData name=flightLoop}
                                        {assign var="rowIndex" value=$rowIndex+1}
                                        <tr class="flight-row" data-flight-id="{$flightData.flight.fly_code}" data-date="{$dateData.date}">
                                           {*<td style="text-align: right !important;">
                                                <input
                                                        type="checkbox"
                                                        class="row-checkbox"
                                                        name="flight_checkbox[]"
                                                        id="flight_checkbox_{$flightData.tickets[0].ticket.ticket_id}"
                                                        value="{$flightData.tickets[0].ticket.ticket_id}">
                                            </td>*}
                                            <td style="text-align: right !important;">
                                                {$rowIndex}
                                            </td>
                                            <td class="seller" style="text-align: right !important;">
                                                {if $flightData.tickets[0].ticket.seller_idNow}
                                                    {assign var="sellerId" value=$flightData.tickets[0].ticket.seller_idNow}
                                                    {assign var="sellerName" value=""}
                                                    {foreach $ListSeller as $agency}
                                                        {if $agency.id == $sellerId}
                                                            {assign var="sellerName" value=$agency.name_fa|cat:" - "|cat:$agency.seat_charter_code}
                                                            {break}
                                                        {/if}
                                                    {/foreach}
                                                    <span>{$sellerName}</span>
                                                {else}
                                                    <span class="no-data">-</span>
                                                {/if}
                                            </td>
                                            <td class="aircraft-type" style="text-align: right !important;">
                                                {if $routeData.airline_abbreviation}
                                                    {$routeData.airline_abbreviation}
                                                {elseif $flightData.tickets[0].airline_abbreviation}
                                                    {$flightData.tickets[0].airline_abbreviation}
                                                {else}
                                                    <span class="no-data">-</span>
                                                {/if}
                                            </td>

                                            <td class="flight-number" style="text-align: right !important;">
                                                <strong>{$flightData.flight.fly_code}</strong>
                                            </td>

                                            <td class="flight-class" style="text-align: right !important;">
                                                {if $routeData.vehicle_grade}
                                                    <span class="flight-class-badge">{$routeData.vehicle_grade}</span>
                                                {elseif $flightData.flight.vehicle_grade_name}
                                                    <span class="flight-class-badge">{$flightData.flight.vehicle_grade_name}</span>
                                                {else}
                                                    <span class="no-data">-</span>
                                                {/if}
                                            </td>

                                            <td class="day-of-week" style="text-align: right !important;">
                                                {$dateData.stringWeek}
                                            </td>

                                            <td class="flight-date" style="text-align: right !important;">
                                                {assign var="dateStr" value=$dateData.date}

                                                {if preg_match('/^(\d{4})(\d{2})(\d{2})$/', $dateStr, $matches)}
                                                    {$matches[1]}/{$matches[2]}/{$matches[3]}
                                                {else}
                                                    {$dateStr}
                                                {/if}
                                            </td>

                                            <td class="origin" style="text-align: right !important;">
                                                {if $routeData.route_name}
                                                    {assign var="routeParts" value="-"|explode:$routeData.route_name}
                                                    {if $routeParts|@count >= 2}
                                                        {$routeParts[0]}
                                                    {else}
                                                        {$routeData.route_name}
                                                    {/if}
                                                {else}
                                                    <span class="no-data">-</span>
                                                {/if}
                                            </td>
                                            <td class="destination" style="text-align: right !important;">
                                                {if $routeData.route_name}
                                                    {assign var="routeParts" value="-"|explode:$routeData.route_name}
                                                    {if $routeParts|@count >= 2}
                                                        {$routeParts[1]}
                                                    {else}
                                                        {$routeData.route_name}
                                                    {/if}
                                                {else}
                                                    <span class="no-data">-</span>
                                                {/if}
                                            </td>
                                            <td class="departure-time" style="text-align: right !important;">
                                                {if $flightData.tickets[0].ticket.start_time}
                                                    <span class="time-badge departure">{$flightData.tickets[0].ticket.start_time}</span>
                                                {else}
                                                    <span class="no-data">-</span>
                                                {/if}
                                            </td>
                                            <td class="arrival-time" style="text-align: right !important;">
                                                {if $flightData.tickets[0].ticket.finish_time}
                                                    <span class="time-badge arrival">{$flightData.tickets[0].ticket.finish_time}</span>
                                                {else}
                                                    <span class="no-data">-</span>
                                                {/if}
                                            </td>
                                            <td class="ticket-status" style="text-align: right !important;">
                                                {assign var="status" value=$flightData.tickets[0].ticket.status}
                                                {if $status == "Cancelled"}
                                                    <span class="status-cancelled" title="کنسلی">C</span>
                                                {elseif $status == "Blocked"}
                                                    <span class="status-blocked" title="مسدودی">&#10006;</span>
                                                {elseif $status == "Actived"}
                                                    <span class="status-actived" title="فعال">&#10004;</span>
                                                {else}
                                                    <span class="status-none" title="بدون وضعیت">-</span>
                                                {/if}
                                            </td>
                                            <td class="ticket-manifest" style="text-align: right !important;">
                                                {if $flightData.tickets[0].ticket.status_manifest eq '1'}
                                                    <span class="status-actived" title="ارسال مانیفست">&#10004;</span>
                                                {/if}
                                            </td>
                                            <td class="capacity-total" style="text-align: right !important;">
                                                {if $flightData.tickets[0].ticket.fly_total_capacity}
                                                    <span class="capacity-number">{$flightData.tickets[0].ticket.fly_total_capacity}</span>
                                                {else}
                                                    <span class="no-data">-</span>
                                                {/if}
                                            </td>
                                            <td class="capacity-allocated" style="text-align: right !important;">
                                                {if $flightData.tickets[0].ticket.total_manifest_capacity}
                                                    <span class="capacity-number allocated">{$flightData.tickets[0].ticket.total_manifest_capacity}</span>
                                                {else}
                                                    <span class="no-data">-</span>
                                                {/if}
                                            </td>
                                            <td class="capacity-remaining" style="text-align: right !important;">
                                                {assign var="remainingTotal" value=$flightData.tickets[0].ticket.fly_total_capacity - $flightData.tickets[0].ticket.total_manifest_capacity}
                                                {$remainingTotal}
                                            </td>
                                            <td class="capacity-reserved" style="text-align: right !important;">
                                                {if $flightData.tickets[0].ticket.fly_total_capacity}
                                                    {assign var="manifestCount" value=$flightData.tickets[0].ticket.manifest_records_count|default:0}
                                                    {assign var="bookCount" value=$flightData.tickets[0].ticket.book_records_count|default:0}
                                                    {assign var="reservedCapacity" value=$manifestCount + $bookCount}
                                                    <span class="capacity-number reserved">{$reservedCapacity}</span>
                                                {else}
                                                    <span class="no-data">-</span>
                                                {/if}
                                            </td>
                                            <td class="capacity-remaining-total" style="text-align: right !important;">
                                                {if $flightData.tickets[0].ticket.fly_total_capacity}
                                                    {assign var="totalCapacity" value=$flightData.tickets[0].ticket.fly_total_capacity}
                                                    {assign var="manifestCount" value=$flightData.tickets[0].ticket.manifest_records_count|default:0}
                                                    {assign var="bookCount" value=$flightData.tickets[0].ticket.book_records_count|default:0}
                                                    {assign var="reservedCapacity" value=$manifestCount + $bookCount}
                                                    {assign var="remainingCapacity" value=$totalCapacity - $reservedCapacity}
                                                    <span class="capacity-number remaining {if $remainingCapacity == 0}warning{/if}">{$remainingCapacity}</span>
                                                {else}
                                                    <span class="no-data">-</span>
                                                {/if}
                                            </td>
                                            <td class="actions" style="text-align: right !important;">
                                                <div class="btn-group m-r-10">

                                                    <button aria-expanded="true" data-toggle="dropdown"
                                                            class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light btn-xs"
                                                            type="button"> عملیات <span class="caret"></span></button>

                                                    <ul role="menu"
                                                        class="dropdown-menu dropdown-menu-left animated flipInY py-1 px-0">
                                                        <li class="li-list-operator">
                                                            <a onclick="showSellerDetails(
                                                                                            '{$flightData.flight.fly_code}',
                                                                                            '{$sellerName}',
                                                                                            '{$flightData.tickets[0].ticket.seller_priceNow|number_format:0:',':','}',
                                                                                            '{$flightData.tickets[0].ticket.ticket_id}',
                                                                                            '{$remainingTotal}')" >
                                                                <i class="fcbtn btn btn-outline btn-success btn-1e fa fa-money tooltip-success"
                                                                   data-toggle="tooltip" data-placement="top" title=""
                                                                   data-original-title="سیت چارترها"></i>
                                                            </a>
                                                        </li>
                                                        <li class="li-list-operator">
                                                            <a onclick="showFlightDetails('{$flightData.tickets[0].ticket.ticket_id}')">
                                                                <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                                   data-toggle="tooltip" data-placement="top" title=""
                                                                   data-original-title="جزئیات مانیفست"></i>
                                                            </a>
                                                        </li>
                                                        {*
                                                        <li class="li-list-operator">
                                                            <a onclick="showFlightStatus('{$flightData.tickets[0].ticket.ticket_id}')">
                                                                <i class="fcbtn btn btn-outline btn-warning btn-1c tooltip-warning fa fa-plane"
                                                                   data-toggle="tooltip" data-placement="top"
                                                                   data-original-title="وضعیت پرواز"></i>
                                                            </a>
                                                        </li>

                                                        <li class="li-list-operator">
                                                            <a onclick="ShowTotalFlightCapacity('{$flightData.tickets[0].ticket.ticket_id}')">
                                                                <i class="fcbtn btn btn-outline btn-danger btn-1c tooltip-danger fa fa-users"
                                                                          data-toggle="tooltip" data-placement="top"
                                                                   data-original-title="سهمیه کل پرواز"></i>
                                                            </a>
                                                        </li>
                                                        <li class="li-list-operator">
                                                            <a onclick="EditFlightSchedule('{$flightData.tickets[0].ticket.ticket_id}')">
                                                                <i class="fcbtn btn btn-outline btn-success btn-1e tooltip-success fa fa-edit"
                                                                   data-toggle="tooltip" data-placement="top"
                                                                   data-original-title="ویرایش برنامه پروازی"></i>
                                                            </a>
                                                        </li>
                                                        *}
                                                        <li class="li-list-operator">
                                                            <a onclick="ShowStatusManifest('{$flightData.tickets[0].ticket.ticket_id}')">
                                                                <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-list-alt"
                                                                   data-toggle="tooltip" data-placement="top"
                                                                   data-original-title="وضعیت مانیفست"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>

                                            </td>
                                        </tr>
                                    {/foreach}
                                {/foreach}
                            {/foreach}
                            {/if}
                            </tbody>
                        </table>
                    </div>
                    </div>
                    {*
                    <div class="text-center mt-3">
                        <button id="bulkEditBtn" class="btn btn-primary" >
                            <i class="fa fa-edit"></i> ویرایش دسته‌جمعی
                        </button>
                    </div>
                    *}
                </div>
            {if !$manifestData}
                <div class="empty-state">
                    <div class="empty-content">
                        <i class="fa fa-plane-slash"></i>
                        <h3>هیچ پروازی یافت نشد</h3>
                        <p>هیچ پرواز یا بلیطی در سیستم رزرواسیون یافت نشد.</p>
                        <button class="btn-primary" onclick="refreshData()">
                            <i class="fa fa-refresh"></i>
                            بروز رسانی
                        </button>
                    </div>
                </div>
            {/if}
            </div>
        </div>
    </div>

    <!-- Flight Details Modal -->
    <div id="flightDetailsModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-plane"></i>
                        جزئیات مانیفست
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="flightDetailsContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
    <!-- Flight Status Capacity Modal -->
    <div id="globalOperationModal" class="modal fade" id="mainModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width:500px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="globalOperationTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="globalOperationContent">
                    <!-- محتوا با جاوااسکریپت تغییر می‌کند -->
                </div>
            </div>
        </div>
    </div>
    <!-- Seller Details Modal -->
    <div id="sellerDetailsModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-user"></i>
                        اطلاعات سیت چارترها
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="sellerDetailsContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

<div class="loaderPublic displayN"></div>
<script>
   // آرایه‌ها
   var agencies = [
       {foreach $ListSeller as $agency}
      { id: "{$agency['id']}", name: "{$agency['name_fa']}" }{if !$agency@last},{/if}
       {/foreach}
   ];
   var TypeOfPlanes = [
       {foreach $ListTypeOfPlane as $type}
      {
         id: "{$type['id']}",
         id_vehicle: "{$type['id_type_of_vehicle']}",
         name: "{$type['name']}",
         abbreviation: "{$type['abbreviation']}"
      }{if !$type@last},{/if}
       {/foreach}
   ];
   var flightCode = [
       {foreach $filterOptions.fly_codes as $flyCode}
      { id: "{$flyCode}", name: "{$flyCode}" }{if !$flyCode@last},{/if}
       {/foreach}
   ];
   var ListAllFlyCode = [
       {foreach $ListAllFlyCode as $flyCode}
      { id: "{$flyCode.id}", name: "{$flyCode.fly_code}" }{if !$flyCode@last},{/if}
       {/foreach}
   ];
   const todayJalali = '{$filterOptions.currentDate|replace:"/":"-"}';
   const tomorrowJalali = '{$filterOptions.tomorrowDate|replace:"/":"-"}';

   $(document).ready(function() {
      $('#flightsTable').DataTable({
         pageLength: 200,
         lengthMenu: [
            [200, 400, 600, 800, 1000],
            [200, 400, 600, 800, 1000]
         ],
         language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fa.json'
         },
         ordering: false,
         searching: true,
         responsive: true,
         scrollY: '70vh',
         scrollCollapse: true,
         paging: true,
         fixedHeader: true,

         initComplete: function() {
            $('#flightsTable_wrapper .dataTables_filter, #flightsTable_wrapper .dataTables_length').css({
               'margin': '10px'
            });
         }
      });

      // وقتی دکمه ویرایش دسته جمعی زده شد
     /* $('#bulkEditBtn').on('click', function() {
         // گرفتن همه آی‌دی‌های انتخاب شده
         selectedTickets = Array.from(document.querySelectorAll('.row-checkbox:checked'))
            .map(chk => chk.value);

         if(selectedTickets.length === 0) {
            alert('پروازی انتخاب نشده است');
            return false;
         }
         // ticket_id اولین مورد برای بارگذاری اولیه
         ticket_id = selectedTickets[0];
         // باز کردن مودال و بارگذاری اطلاعات
         openBulkEditModal(ticket_id);
      });*/

      $('#weekDaysFilterSelect').select2({
         placeholder: "انتخاب کنید",
         allowClear: true,
         dir: "rtl"
      });

      $('#weekDaysFilterSelect').on('change', function() {
         const selected = $(this).val(); // آرایه ['Saturday','Monday',...]
         $('#weekDaysFilter').val(selected ? selected.join(',') : '');
      });
   });
</script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
<script type="text/javascript" src="assets/JsFiles/manifest-results2.js"></script>
