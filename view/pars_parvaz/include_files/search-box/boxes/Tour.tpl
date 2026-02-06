<div aria-labelledby="tour-tab" class="__box__ tab-pane {if $active} active {/if}" id="Tour_internal" role="tabpanel">
<div class="d-flex flex-wrap">
<form class="d-contents">
{include file="./sections/Tour/internal/origin_city_tour.tpl"}
{include file="./sections/Tour/internal/destination_city_tour.tpl"}
{include file="./sections/Tour/internal/date_teravel.tpl"}
<div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search">
<button class="btn theme-btn seub-btn b-0" onclick="searchInternalTour()" type="button">
<span>
جستجو
 </span>
</button>
</div>
</form>
</div>
</div>
<div aria-labelledby="tour_international-tab" class="__box__ tab-pane" id="Tour_external" role="tabpanel">
<div class="d-flex flex-wrap">
<form class="d-contents">
{include file="./sections/Tour/international/country_origin.tpl"}
{include file="./sections/Tour/international/city_origin.tpl"}
{include file="./sections/Tour/international/country_destination.tpl"}
{include file="./sections/Tour/international/city_destination.tpl"}
{include file="./sections/Tour/international/date_travel.tpl"}
<div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search">
<button class="btn theme-btn seub-btn b-0" onclick="searchInternationalTour()" type="button">
<span>
جستجو
 </span>
</button>
</div>
</form>
</div>
</div>
