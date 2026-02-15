{load_presentation_object filename="manifestController" assign="objManifestController"}
{assign var="dates" value=$objManifestController->DateChangeManiFest()}
{assign var="activeFlights" value=$objManifestController->getPaginatedManifestResults(['FlagPanelUser'=>'Yes','date_from' => $dates.todayJalali])}
{assign var="archiveFlights" value=$objManifestController->getPaginatedManifestResults(['FlagPanelUser'=>'Yes','ListArchive'=>'Yes','date_to' => $dates.yesterdayJalali])}
{assign var="manifestDataActive" value=$activeFlights.data}
{assign var="manifestDataArchive" value=$archiveFlights.data}

{include file="`$smarty.const.FRONT_CURRENT_CLIENT`agencyMenu.tpl"}
<div class="container mt-5">
    <div class="tabs">
        <div class="tab" data-tab="tab1">پروازهای آرشیو </div>
        <div class="tab" data-tab="tab2">پروازهای فعال</div>
    </div>
    <div class="content" id="tab1">
        <table dir="rtl" class="OutSerach">
            <thead>
            <tr>
                <th>ردیف</th>
                <th>هواپیمایی</th>
                <th>پرواز</th>
                <th>کلاس</th>
                <th>روز هفته</th>
                <th>تاریخ</th>
                <th>مبدأ</th>
                <th>مقصد</th>
                <th>ساعت</th>
                <th>فرود</th>
                <th>مشاهده مانیفست</th>
            </tr>
            </thead>
            <tbody>
            {assign var="rowIndex" value=0}
            {foreach from=$manifestDataArchive item=dateData name=dateLoop}
                {foreach from=$dateData.routes item=routeData name=routeLoop}
                    {foreach from=$routeData.flights item=flightData name=flightLoop}
                        {assign var="rowIndex" value=$rowIndex+1}
                        <tr class="flight-row">
                            <td>{$rowIndex}</td>
                            <td class="aircraft-type">
                                {if $routeData.airline_abbreviation}
                                    {$routeData.airline_abbreviation}
                                {elseif $flightData.tickets[0].airline_abbreviation}
                                    {$flightData.tickets[0].airline_abbreviation}
                                {else}
                                    <span class="no-data">-</span>
                                {/if}
                            </td>
                            <td class="flight-number">
                                <strong>{$flightData.flight.fly_code}</strong>
                            </td>
                            <td class="flight-class">
                                {if $routeData.vehicle_grade}
                                    <span class="flight-class-badge">{$routeData.vehicle_grade}</span>
                                {elseif $flightData.flight.vehicle_grade_name}
                                    <span class="flight-class-badge">{$flightData.flight.vehicle_grade_name}</span>
                                {else}
                                    <span class="no-data">-</span>
                                {/if}
                            </td>
                            <td class="day-of-week">
                                {* Try different date formats to handle the date properly *}
                                {assign var="dayNames" value=['دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه','یکشنبه']}
                                {assign var="dateStr" value=$dateData.date}

                                {* First try Y/m/d format *}
                                {assign var="dateObj" value=DateTime::createFromFormat('Y/m/d', $dateStr)}
                                {if !$dateObj}
                                    {* Try Y-m-d format *}
                                    {assign var="dateObj" value=DateTime::createFromFormat('Y-m-d', $dateStr)}
                                {/if}
                                {if !$dateObj}
                                    {* Try Ymd format (without separators) *}
                                    {assign var="dateObj" value=DateTime::createFromFormat('Ymd', $dateStr)}
                                {/if}

                                {if $dateObj}
                                    {$dayNames[$dateObj->format('w')]}
                                {else}
                                    <span class="no-data">-</span>
                                {/if}
                            </td>
                            <td class="flight-date">
                                {assign var="dateStr" value=$dateData.date}

                                {if preg_match('/^(\d{4})(\d{2})(\d{2})$/', $dateStr, $matches)}
                                    {$matches[1]}/{$matches[2]}/{$matches[3]}
                                {else}
                                    {$dateStr}
                                {/if}
                            </td>

                            <td class="origin">
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

                            <td class="destination">
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


                            <td class="departure-time">
                                {if $flightData.tickets[0].ticket.start_time}
                                    <span class="time-badge departure">{$flightData.tickets[0].ticket.start_time}</span>
                                {else}
                                    <span class="no-data">-</span>
                                {/if}
                            </td>
                            <td class="arrival-time">
                                {if $flightData.tickets[0].ticket.finish_time}
                                    <span class="time-badge arrival">{$flightData.tickets[0].ticket.finish_time}</span>
                                {else}
                                    <span class="no-data">-</span>
                                {/if}
                            </td>
                            <td>
                                <a href="{$smarty.const.ROOT_ADDRESS}/showManifest&id={$flightData.tickets[0].ticket.ticket_id}" target="_blank">
                                    <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                       data-toggle="tooltip" data-placement="top" title="مشاهده مانیفست"></i>
                                </a>
                            </td>
                        </tr>
                    {/foreach}
                {/foreach}
            {/foreach}
            </tbody>
        </table>
    </div>
    <div class="content" id="tab2">
        <table dir="rtl" class="OutSerach">
            <thead>
            <tr>
                <th>ردیف</th>
                <th>هواپیمایی</th>
                <th>پرواز</th>
                <th>کلاس</th>
                <th>روز هفته</th>
                <th>تاریخ</th>
                <th>مبدأ</th>
                <th>مقصد</th>
                <th>ساعت</th>
                <th>فرود</th>
                <th>مشاهده مانیفست</th>
            </tr>
            </thead>
            <tbody>
            {assign var="rowIndex" value=0}
            {foreach from=$manifestDataActive item=dateData name=dateLoop}
                {foreach from=$dateData.routes item=routeData name=routeLoop}
                    {foreach from=$routeData.flights item=flightData name=flightLoop}
                        {assign var="rowIndex" value=$rowIndex+1}
                        <tr class="flight-row">
                            <td>{$rowIndex}</td>
                            <td class="aircraft-type">
                                {if $routeData.airline_abbreviation}
                                    {$routeData.airline_abbreviation}
                                {elseif $flightData.tickets[0].airline_abbreviation}
                                    {$flightData.tickets[0].airline_abbreviation}
                                {else}
                                    <span class="no-data">-</span>
                                {/if}
                            </td>
                            <td class="flight-number">
                                <strong>{$flightData.flight.fly_code}</strong>
                            </td>
                            <td class="flight-class">
                                {if $routeData.vehicle_grade}
                                    <span class="flight-class-badge">{$routeData.vehicle_grade}</span>
                                {elseif $flightData.flight.vehicle_grade_name}
                                    <span class="flight-class-badge">{$flightData.flight.vehicle_grade_name}</span>
                                {else}
                                    <span class="no-data">-</span>
                                {/if}
                            </td>
                            <td class="day-of-week">
                                {* Try different date formats to handle the date properly *}
                                {assign var="dayNames" value=['دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه','یکشنبه']}
                                {assign var="dateStr" value=$dateData.date}

                                {* First try Y/m/d format *}
                                {assign var="dateObj" value=DateTime::createFromFormat('Y/m/d', $dateStr)}
                                {if !$dateObj}
                                    {* Try Y-m-d format *}
                                    {assign var="dateObj" value=DateTime::createFromFormat('Y-m-d', $dateStr)}
                                {/if}
                                {if !$dateObj}
                                    {* Try Ymd format (without separators) *}
                                    {assign var="dateObj" value=DateTime::createFromFormat('Ymd', $dateStr)}
                                {/if}

                                {if $dateObj}
                                    {$dayNames[$dateObj->format('w')]}
                                {else}
                                    <span class="no-data">-</span>
                                {/if}
                            </td>
                            <td class="flight-date">
                                {assign var="dateStr" value=$dateData.date}

                                {if preg_match('/^(\d{4})(\d{2})(\d{2})$/', $dateStr, $matches)}
                                    {$matches[1]}/{$matches[2]}/{$matches[3]}
                                {else}
                                    {$dateStr}
                                {/if}
                            </td>

                            <td class="origin">
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

                            <td class="destination">
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


                            <td class="departure-time">
                                {if $flightData.tickets[0].ticket.start_time}
                                    <span class="time-badge departure">{$flightData.tickets[0].ticket.start_time}</span>
                                {else}
                                    <span class="no-data">-</span>
                                {/if}
                            </td>
                            <td class="arrival-time">
                                {if $flightData.tickets[0].ticket.finish_time}
                                    <span class="time-badge arrival">{$flightData.tickets[0].ticket.finish_time}</span>
                                {else}
                                    <span class="no-data">-</span>
                                {/if}
                            </td>
                            <td>
                                <a href="{$smarty.const.ROOT_ADDRESS}/showManifest&id={$flightData.tickets[0].ticket.ticket_id}"  target="_blank">
                                    <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                       data-toggle="tooltip" data-placement="top" title="مشاهده مانیفست"></i>
                                </a>
                            </td>
                        </tr>
                    {/foreach}
                {/foreach}
            {/foreach}
            </tbody>
        </table>
    </div>
</div>
<script>
   // انتخاب تبها و محتواها
   const tabs = document.querySelectorAll('.tab');
   const contents = document.querySelectorAll('.content');

   tabs.forEach(tab => {
      tab.addEventListener('click', () => {
         // حذف کلاس active از همه تبها و محتواها
         tabs.forEach(t => t.classList.remove('active'));
         contents.forEach(c => c.classList.remove('active'));

         // افزودن کلاس active به تب و محتوای انتخاب‌شده
         tab.classList.add('active');
         document.getElementById(tab.dataset.tab).classList.add('active');
      });
   });

   // ✅ فعال‌سازی تب اول به صورت پیش‌فرض
   if (tabs.length > 0 && contents.length > 0) {
      tabs[1].classList.add('active');
      contents[1].classList.add('active');
   }
</script>
