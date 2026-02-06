{assign var='cities' value=$obj_main_page->getBusRoutes()}<div class="__box__ tab-pane {if $active} active {/if}" id="Bus">
<h5 class="title_searchBox">
رزرو اتوبوس
 </h5>
<div class="col-md-12 col-xs-12 col-sm-12 d-ceckboxs p-0">
<div class="cntr p-1">
</div>
</div>
<div class="col-md-12 col-12">
<div class="row">
<form class="d_contents" data-action="://s360online.iran-tech.com/" id="gds_local_bus" method="post" name="gds_local_bus" target="_blank">
{include file="./sections/Bus/origin_selection.tpl"}
{include file="./sections/Bus/destination_selection.tpl"}
{include file="./sections/Bus/date_bus.tpl"}
<div class="col-lg-2 col-md-12 col-sm-6 col-12 btn_s col_search">
<button class="btn theme-btn seub-btn b-0" onclick="searchBus()" type="button">
<span class="fa fa-search">
</span>
جستجو
 </button>
</div>
</form>
</div>
</div>
</div>
