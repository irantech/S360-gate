{load_presentation_object filename="reservationPublicFunctions" assign="objResult"}
{load_presentation_object filename="reservationBasicInformation" assign="objBasic"}
{assign var="filterOptions" value=$objResult->getFlyFilterOptions()}
{assign var="internationalRoutes" value=$objResult->ListOriginAirport('international')}
{assign var="internalRoutes" value=$objResult->ListOriginAirport()}

<link href="assets/css/flyNumber.css" rel="stylesheet">
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li class="active">ثبت شماره پرواز</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                {*  <h3 class="box-title m-b-0">شماره پرواز</h3>
              <p class="text-muted m-b-30">
                     <span style="margin: 10px;">
                          <a href="flyNumberAdd" class="btn btn-info waves-effect waves-light " type="button">
                             <span class="btn-label"><i class="fa fa-plus"></i></span>افزودن شماره پرواز جدید
                         </a>
                     </span>
                 </p>*}
                <!-- Quick Add Form Row -->
                <div class="quick-add-form-row"  style="background-color: #fcfcfc;">
                    <div class="filter-header">
                        <span><i class="fa fa-plus text-success"></i> افزودن سریع پرواز </span>
                    </div>
                    <div class="quick-add-form-container">
                        <div class="quick-add-form" id="quick-add-form">
                            <div class="form-group">

                                <select name="origin_airport_name" id="quick_origin_airport" tabindex="1"
                                        class="form-control input-sm select2"
                                        onchange="quickOnOriginAirportChange()">

                                    <option value="">انتخاب مبدا...</option>
                                    {assign var="seen" value=[]}

                                    {* پروازهای بین‌المللی *}
                                    {foreach $internationalRoutes as $route}
                                        {assign var="code" value=$route.DepartureCode}
                                        {if !in_array($code, $seen)}
                                            <option value="{$route.DepartureCode}" data-type="international">
                                                {$route.country_name} - {$route.DepartureCityFa} - {$route.AirportFa} ({$route.DepartureCode})
                                            </option>
                                            {append var="seen" value=$code}
                                        {/if}
                                    {/foreach}

                                    {* پروازهای داخلی *}
                                    {foreach $internalRoutes as $route}
                                        {assign var="code" value=$route.Departure_Code}
                                        {if !in_array($code, $seen)}
                                            <option value="{$route.Departure_Code}" data-type="internal">
                                                {$route.country_name} - {$route.Departure_City} ({$route.Departure_Code})
                                            </option>
                                            {append var="seen" value=$code}
                                        {/if}
                                    {/foreach}
                                </select>

                                <select name="origin_region" id="quick_origin_region" tabindex="2"
                                        class="form-control input-sm region-select select2">
                                    <option value="">انتخاب ترمینال مبدا...</option>
                                </select>

                                <input type="hidden" name="origin_country" id="quick_origin_country" value="">
                                <input type="hidden" name="origin_city" id="quick_origin_city" value="">
                                <input type="hidden" name="select_type_flight" id="quick_select_type_flight" value="">
                            </div>
                            <div class="form-group">
                                <select name="destination_airport_name" id="quick_destination_airport" tabindex="3"
                                        class="form-control input-sm select2"
                                        onchange="quickOnDestinationAirportChange()">

                                    <option value="">انتخاب مقصد...</option>
                                    {assign var="seen" value=[]}

                                    {* پروازهای بین‌المللی *}
                                    {foreach $internationalRoutes as $route}
                                        {assign var="code" value=$route.DepartureCode}
                                        {if !in_array($code, $seen)}
                                            <option value="{$route.DepartureCode}" data-type="international">
                                                {$route.country_name} - {$route.DepartureCityFa} - {$route.AirportFa} ({$route.DepartureCode})
                                            </option>
                                            {append var="seen" value=$code}
                                        {/if}
                                    {/foreach}

                                    {* پروازهای داخلی *}
                                    {foreach $internalRoutes as $route}
                                        {assign var="code" value=$route.Departure_Code}
                                        {if !in_array($code, $seen)}
                                            <option value="{$route.Departure_Code}" data-type="internal">
                                                {$route.country_name} - {$route.Departure_City} ({$route.Departure_Code})
                                            </option>
                                            {append var="seen" value=$code}
                                        {/if}
                                    {/foreach}
                                </select>

                                <select name="destination_region" id="quick_destination_region" tabindex="4"
                                        class="form-control input-sm region-select select2">
                                    <option value="">انتخاب ترمینال مقصد...</option>
                                </select>
                                <input type="hidden" name="destination_country" id="quick_destination_country" value="">
                                <input type="hidden" name="destination_city" id="quick_destination_city" value="">
                            </div>
                            <div class="form-group">
                                <select name="quick_type_of_vehicle" id="quick_type_of_vehicle" tabindex="5"
                                        class="form-control input-sm select2"
                                        onchange="onchangeTypeOfVehicle()">
                                    <option value="">انتخاب نوع وسیله حمل و نقل...</option>
                                    {foreach $objBasic->SelectAll('reservation_type_of_vehicle_tb') as $typeVehicle}
                                        <option value="{$typeVehicle['id']}" {if $typeVehicle['name'] eq 'هواپیما'} selected {/if}>{$typeVehicle['name']}</option>
                                    {/foreach}
                                </select>
                                <select name="airline" id="quick_airline" tabindex="6"
                                        class="form-control input-sm region-select select2"
                                        style="margin-top: 5px;">
                                    <option value="">...انتخاب شرکت حمل و نقل</option>
                                </select>
                                <select name="type_of_plane" id="type_of_plane" tabindex="7"
                                        class="form-control input-sm region-select select2"
                                        style="margin-top: 5px;">
                                    <option value="">... مدل وسیله نقلیه</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" tabindex="8"  name="fly_code" id="quick_fly_code" class="form-control input-sm"  placeholder="شماره پرواز">
                                <input type="text" tabindex="9" name="departure_time" id="quick_departure_time" class="form-control input-sm time-input" data-time-format="true" placeholder="ساعت حرکت" maxlength="5">
                                <input type="text" tabindex="10" name="duration" id="quick_duration" class="form-control input-sm time-input" data-time-format="true" placeholder="ساعت فرود" maxlength="5">
                            </div>
                            <div class="form-group">
                                <button type="button" id="btnInsFlyNumber" class="btn-filter" onclick="quickSaveFlyNumber()" tabindex="11">
                                    <i class="fa fa-save"></i> ذخیره
                                </button>

                                <button type="button" id="btnEditFlyNumber" class="btn-filter" onclick="quickUpdateFlyNumber()" tabindex="12" style="display:none">
                                    <i class="fa fa-save"></i> ویرایش
                                </button>
                                <input type="hidden" name="idEditFlyNumber" id="idEditFlyNumber" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Filter Bar -->
                <div class="filter-bar" style="background-color: #fcfdfe;">
                    <div class="filter-header">
                        <span><i class="fa fa-filter"></i> فیلترهای جستجو</span>
                    </div>
                    <div class="filter-grid">
                        <div class="filter-row">
                            <div class="filter-group">
                                <label for="originFilter">مبدا:</label>
                                    <select class="filter-select select2" id="originFilter" name="originFilter" tabindex="13">
                                    <option value="">همه</option>
                                        {foreach from=$filterOptions.origins item=origin}
                                            <option value="{$origin.id}">{$origin.name}</option>
                                        {/foreach}
                                </select>
                            </div>
                            <div class="filter-group">
                                <label for="destinationFilter">مقصد:</label>
                                    <select class="filter-select select2" id="destinationFilter" name="destinationFilter" tabindex="14">
                                    <option value="">همه</option>
                                        {foreach from=$filterOptions.destinations item=destination}
                                            <option value="{$destination.id}">{$destination.name}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="filter-group">
                                <label for="flyCodeFilter">شماره پرواز:</label>
                                    <select class="filter-select select2" id="flyCodeFilter" name="flyCodeFilter" onchange="handleFlightCodeChange()" tabindex="15">
                                    <option value="">همه</option>
                                        {foreach from=$filterOptions.flight_codes item=flightCode}
                                            <option value="{$flightCode.id}">{$flightCode.name}</option>
                                    {/foreach}
                                </select>
                                    <input type="text" class="filter-input" id="flyCodeCustomInput" name="flyCodeCustomInput" placeholder="شماره پرواز سفارشی" style="display: none; margin-top: 5px;">
                            </div>
                            <div class="filter-group">
                                    <label for="airlineFilter">هواپیمایی:</label>
                                    <select class="filter-select select2" id="airlineFilter" name="airlineFilter" tabindex="16">
                                    <option value="">همه</option>
                                        {foreach from=$filterOptions.airlines item=airline}
                                            <option value="{$airline.id}">{$airline.name}</option>
                                        {/foreach}
                                </select>
                            </div>
                            <div class="filter-actions">
                                <button type="button" class="btn-filter" onclick="loadFilteredFlyData()" tabindex="17">
                                    <i class="fa fa-filter"></i>
                                    اعمال فیلتر
                                </button>
                            </div>
                            </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center myTable01">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>مبدا</th>
                            <th>ترمینال</th>
                            <th>مقصد</th>
                            <th>ترمینال</th>
                            <th>شماره</th>
                            <th>نوع وسیله نقلیه</th>
                            <th>شرکت حمل و نقل</th>
                            <th>مدل وسیله نقلیه</th>
                            <th>ساعت حرکت</th>
                            <th>ساعت فرود</th>
                            <th>ویرایش</th>
                            <th>برنامه پروازی</th>
                        </tr>
                        </thead>
                        <tbody id="flyTableBody" class="flyTableBody01">
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objBasic->getReservationFlyRecords()}
                        {$number=$number+1}
                        <tr id="del-{$item.id}" style="text-align: right;">
                            <td id="borderFlyNumber-{$item.id}">{$number}</td>
                            <td>
                                {$objResult->ShowName('reservation_country_tb',$item.origin_country)} -
                                {$objResult->ShowName('reservation_city_tb',$item.origin_city)}
                            </td>
                            <td>
                                {$objResult->ShowName('reservation_region_tb',$item.origin_region)}
                            </td>

                            <td>
                                {$objResult->ShowName('reservation_country_tb',$item.destination_country)} -
                                {$objResult->ShowName('reservation_city_tb',$item.destination_city)}
                            </td>
                            <td>
                                {$objResult->ShowName('reservation_region_tb',$item.destination_region)}
                            </td>
                            <td>{$item.fly_code}</td>
                            <td>
                                {$objResult->ShowName(' reservation_type_of_vehicle_tb',$item.type_of_vehicle_id)}
                            </td>
                            <td>
                                {if $objResult->ShowName('reservation_type_of_vehicle_tb',$item.type_of_vehicle_id) eq 'هواپیما'}
                                    {$objResult->ShowNameBase('airline_tb','name_fa',$item.airline)}
                                {else}
                                    {$objResult->ShowName('reservation_transport_companies_tb',$item.airline)}
                                {/if}
                            </td>
                            <td>
                                {if $item.type_of_plane neq ''}
                                    {$objResult->ShowName('reservation_vehicle_model_tb',$item.type_of_plane)}
                                {elseif $item.vehicle_model neq ''}
                                    ---- <br/> {$item.vehicle_model}
                                {/if}
                            </td>
                            <td>
                                {if $item.DataTmp neq ''}
                                    {assign var="tmp" value=$item.DataTmp|@json_decode:true}
                                    {$tmp.departure_hours}:{$tmp.departure_minutes}
                                {elseif $item.exit_hour neq ''}
                                    {$item.exit_hour}
                                {/if}
                            </td>
                            <td>
                                {if $item.time neq ''}
                                    {$item.time}
                                {else}
                                    -
                                {/if}
                            </td>
                            <td>
                               {* 1403==>  href="flyNumberEdit&id={$item.id}"  *}
                                <a href='javascript:void(0)' onclick='quickEditFly({$item.id})'>
                                    <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش">

                                    </i>
                                </a>
                            </td>
                            <td>
                                <a href="ticketAdd?fly_id={$item.id}" title="افزودن برنامه پروازی">
                                    <i  class="fcbtn btn btn-outline btn-success btn-1e fa fa-ticket tooltip-success"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="افزودن برنامه پروازی">

                                    </i>
                                </a>
                            </td>
{*                            <td>*}
{*                                {if $objBasic->permissionToDelete('reservation_ticket_tb', 'fly_code', $item.id) eq 'yes'}*}
{*                                    <a href="#" onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title="حذف شماره پرواز" data-placement="right"*}
{*                                       data-content="امکان حذف وجود ندارد"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>*}
{*                                    </a>*}
{*                                {else}*}
{*                                    <a id="DelChangePrice-{$item.id}" href="#" onclick="logical_deletion('{$item.id}', 'reservation_fly_tb'); return false" class="popoverBox  popover-danger" data-toggle="popover" title="حذف تغییرات" data-placement="right"*}
{*                                       data-content="حذف"> <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>*}
{*                                    </a>*}
{*                                {/if}*}
{*                            </td>*}

                        </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش ثبت شماره پرواز   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/381/--.html" target="_blank" class="i-btn"></a>

</div>
<div class="loaderPublic displayN"></div>
<script>

   $('.select2').select2();

   $(document).on('focus', '.select2-selection--single', function (e) {

      let $select = $(this).closest('.select2-container').prev('select.select2');

      if (!$select.data('opened-by-focus')) {
         $select.select2('open');
         $select.data('opened-by-focus', true);
      }
   });

   $(document).on('select2:close', 'select.select2', function () {
      $(this).data('opened-by-focus', false);
   });


</script>
<script type="text/javascript" src="assets/JsFiles/reservationTicket.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>
<script type="text/javascript" src="assets/JsFiles/flyNumberQuickAdd.js"></script>