{assign var='cities' value=$obj_main_page->getBusRoutes()}<div class="__box__ tab-pane {if $active} active {/if}" id="Bus">
 <div class="col-md-12 col-12">
<div class="row">
 <form class="d_contents" data-action="://s360online.iran-tech.com/" id="gds_local_bus" method="post" name="gds_local_bus" target="_blank">
<div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search p-1">
 <div class="form-group">
<select aria-hidden="true" class="select-route-bus-js select-origin-route-bus-js" data-placeholder="نام شهر مبدأ" id="origin_bus" name="origin_bus" tabindex="-1">
 <option value="">##ChoseOption##...</option>
{foreach $cities as $city}
<option value="{$city['id']}">{$city['text']}</option>
{/foreach}
</select>
 </div>
</div>
<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search p-1">
 <div class="form-group">
<select aria-hidden="true" class="select-route-bus-js select-destination-route-bus-js select2-hidden-accessible" data-placeholder="نام شهر مقصد" id="destination_bus" name="destination_bus" tabindex="-1">
 <option value="">##ChoseOption##...</option>
{foreach $cities as $city}
<option value="{$city['id']}">{$city['text']}</option>
{/foreach}
</select>
 </div>
</div>
<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search search_col p-1">
 <div class="form-group">
<input class="shamsiDeptCalendar departure-date-bus-js form-control" id="departure_date_bus" name="departure_date_bus" placeholder="تاریخ حرکت" type="text">
 </div>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search p-1">
 <button class="btn theme-btn seub-btn b-0" onclick="searchBus()" type="button">
<span>
 جستجو
</span>
 </button>
</div>
 </form>
</div>
 </div>
</div>
