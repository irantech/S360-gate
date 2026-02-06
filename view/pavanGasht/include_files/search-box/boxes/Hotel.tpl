<div class="__box__ tab-pane" id="Hotel">
{*    <div class="d_flex flex-wrap internal-hotel-js  custom-height mt-4" id="internal_hotel">*}
    <div class="d_flex flex-wrap internal-hotel-js custom-height" id="internal_hotel" style=" ">
        <form class="d_contents mt-3" data-action="s360online.iran-tech.com/" id="internal_hotel_form" method="post" name="gdsHotelLocal" target="_blank">
            {include file="./sections/Hotel/internal/destination_city.tpl"}
            {include file="./sections/Hotel/internal/check_in_date.tpl"}
            {include file="./sections/Hotel/internal/check_out_date.tpl"}
            {include file="./sections/Hotel/internal/count_passenger_room.tpl"}
{*            <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search d-flex margin-center">*}
{*                <button class="btn theme-btn seub-btn b-0" onclick="searchInternalHotel()" type="button"><span>جستجو</span></button>*}
{*            </div>*}
            <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search margin-center p-1">
                <button class="btn theme-btn seub-btn b-0" onclick="searchInternalHotel()" type="button"><span>جستجو</span></button>
            </div>
        </form>
    </div>
    <input class="type-section-js" id="type_section" name="type_section" type="hidden" value="internal"/>
</div>
