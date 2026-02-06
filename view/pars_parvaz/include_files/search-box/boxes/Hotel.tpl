<div aria-labelledby="hotel-tab" class="__box__ tab-pane {if $active}active{/if} internal-hotel-js" id="Hotel_internal" role="tabpanel">
    <div class="d-flex flex-wrap">
        <form class="d-contents">
            {include file="./sections/Hotel/internal/destination_city.tpl"}
            {include file="./sections/Hotel/internal/check_in_date.tpl"}
            {include file="./sections/Hotel/internal/check_out_date.tpl"}
            {include file="./sections/Hotel/internal/count_passenger_room.tpl"}
            <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search">
                <button class="btn theme-btn seub-btn b-0" onclick="searchInternalHotel()" type="button">
                    <span>جستجو</span></button>
            </div>
        </form>
    </div>
</div>
<div aria-labelledby="hotel_international-tab" class="__box__ tab-pane international-hotel-js" id="Hotel_external" role="tabpanel">
    <div id='international_hotel' class="d-flex flex-wrap">
        <form class="d-contents">
            {include file="./sections/Hotel/international/destination_city.tpl"}
            {include file="./sections/Hotel/international/check_in_date.tpl"}
            {include file="./sections/Hotel/international/check_out_date.tpl"}
            {include file="./sections/Hotel/international/count_passenger_room.tpl"}
            <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search">
                <input id="NightsForExternalHotelLocal" name="nights" type="hidden"/>
                <input type="hidden" id="nights_hotel" name="nights_hotel" value="" placeholder='##Exitdate##' class='nights-hotel-js'>

                <button class="btn theme-btn seub-btn b-0" onclick="searchInternationalHotel()" type="button">
                    <span>جستجو</span>
                </button>
            </div>
        </form>
    </div>
    <input type='hidden' id="type_section" name="type_section" class="type-section-js" value="internal">

</div>