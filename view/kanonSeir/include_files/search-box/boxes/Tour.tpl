<div aria-labelledby="tour-tab" class="__box__ tab-pane active show {if $active} active {/if}" id="Tour_internal">
<div class="col-12">
<div class="row">
<form class="d_contents" id="gdsTourLocal" method="post" name="gdsTourLocal" target="_blank">
{include file="./sections/Tour/internal/origin_city_tour.tpl"}
{include file="./sections/Tour/internal/destination_city_tour.tpl"}
{include file="./sections/Tour/internal/date_teravel.tpl"}
<div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search p-1">
<button class="btn theme-btn seub-btn b-0" onclick="searchInternalTour()" type="button">
<span>
 جستجو
</span>
</button>
</div>
</form>
</div>
</div>
</div>
<div aria-labelledby="tour-kh-tab" class="__box__ tab-pane {if $active} active {/if}" id="Tour_external">
<div class="col-12">
<div class="row">
<form class="d_contents" id="gdsPortalLocal" method="post" name="gdsPortalLocal" target="_blank">
{include file="./sections/Tour/international/country_origin.tpl"}
{include file="./sections/Tour/international/city_origin.tpl"}
{include file="./sections/Tour/international/country_destination.tpl"}
{include file="./sections/Tour/international/city_destination.tpl"}
{include file="./sections/Tour/international/date_travel.tpl"}
<div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search p-1">
<button class="btn theme-btn seub-btn b-0" onclick="searchInternationalTour()" type="button">
<span>
 جستجو
</span>
</button>
</div>
</form>
</div>
</div>
</div>
