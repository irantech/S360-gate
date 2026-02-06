<div class="__box__ tab-pane {if $active} active {/if}" id="Hotel_internal">
    <h5 class="title_searchBox">رزرو هتل داخلی</h5>
    <div id="internal_hotel" class="d_flex flex-wrap internal-hotel-js">
        <form class="d_contents" data-action="s360online.iran-tech.com/" id="internal_hotel_form" method="post" name="gdsHotelLocal" target="_blank">

        <div class="col-md-12 col-xs-12 col-sm-12 d-ceckboxs p-0">
                <div class="cntr p-1"></div>
            </div>
            {include file="./sections/Hotel/internal/destination_city.tpl"}
            {include file="./sections/Hotel/internal/check_in_date.tpl"}
            {include file="./sections/Hotel/internal/check_out_date.tpl"}
            {include file="./sections/Hotel/internal/count_passenger_room.tpl"}

            <div class="col-lg-2 col-md-12 col-sm-12 col-12 btn_s col_search margin-center">
                <button onclick="searchInternalHotel()" type="button" class="btn theme-btn seub-btn b-0">
                    <span class="fa fa-search"></span>
                    جستجو
                </button>
            </div>
        </form>
    </div>
    <input type='hidden' id="type_section" name="type_section" class="type-section-js" value="internal">
</div>
<div class="__box__ tab-pane" id="Hotel_external">
    <h5 class="title_searchBox">رزرو هتل خارجی</h5>
    <div id="international_hotel" class="flex-wrap d-flex international-hotel-js">
        <form class="d_contents" data-action="https://s360online.iran-tech.com/" id="international_hotel_form" method="post" target="_blank">
            <div class="col-md-12 col-xs-12 col-sm-12 d-ceckboxs p-0">
                <div class="cntr p-1"></div>
            </div>
            {include file="./sections/Hotel/international/destination_city.tpl"}
            {include file="./sections/Hotel/international/check_in_date.tpl"}
            {include file="./sections/Hotel/international/check_out_date.tpl"}
            {include file="./sections/Hotel/international/count_passenger_room.tpl"}

            <div class="col-lg-2 col-md-12 col-sm-12 col-12 btn_s col_search margin-center">
                <input type="hidden" id="nights_hotel" name="nights_hotel" value="" placeholder='تاریخ خروج' class='nights-hotel-js'>
                <button onclick="searchInternationalHotel()" type="button" class="btn theme-btn seub-btn b-0">
                    <span class="fa fa-search"></span>
                    جستجو
                </button>
            </div>
        </form>
    </div>
</div>