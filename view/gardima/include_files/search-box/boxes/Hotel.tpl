<div class="__box__ tab-pane  {if $active} active {/if}" id="Hotel">
{include file="./sections/Hotel/international/btn_radio_internal_external.tpl"}
<div class="d_flex flex-wrap internal-hotel-js" id="internal_hotel">
<form class="d_contents" data-action="s360online.iran-tech.com/" id="internal_hotel_form" method="post" name="gdsHotelLocal" target="_blank">
{include file="./sections/Hotel/internal/destination_city.tpl"}
{include file="./sections/Hotel/internal/check_in_date.tpl"}
{include file="./sections/Hotel/internal/check_out_date.tpl"}
{include file="./sections/Hotel/internal/count_passenger_room.tpl"}
<div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search margin-center p-1">
<button class="btn theme-btn seub-btn b-0" onclick="searchInternalHotel(true)" type="button"><span>جستجو</span></button>
</div>
</form>
</div>
<div class="flex-wrap international-hotel-js" id="international_hotel">
<form class="d_contents" data-action="https://s360online.iran-tech.com/" id="international_hotel_form" method="post" target="_blank">
{include file="./sections/Hotel/international/destination_city.tpl"}
{include file="./sections/Hotel/international/check_in_date.tpl"}
{include file="./sections/Hotel/international/check_out_date.tpl"}
{include file="./sections/Hotel/international/count_passenger_room.tpl"}
<div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search margin-center p-1">
<input class="nights-hotel-js" id="nights_hotel" name="nights_hotel" placeholder="تاریخ خروج" type="hidden" value=""/>
<button class="btn theme-btn seub-btn b-0" onclick="searchInternationalHotel(true)" type="button"><span>جستجو</span></button>
</div>
</form>
</div>
<input class="type-section-js" id="type_section" name="type_section" type="hidden" value="internal"/>
</div>