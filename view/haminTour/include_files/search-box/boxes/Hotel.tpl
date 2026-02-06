<div class="__box__ tab-pane active" id="Hotel">
    <div id="internal_hotel" class="_internal d_flex flex-wrap internal-hotel-js">
        <form data-action="s360online.iran-tech.com/" name="gdsHotelLocal"
              target="_blank" id="internal_hotel_form" class="d_contents" method="post">
            {include file="./sections/Hotel/internal/destination_city.tpl"}
            {include file="./sections/Hotel/internal/check_in_date.tpl"}
            {include file="./sections/Hotel/internal/check_out_date.tpl"}
            {include file="./sections/Hotel/internal/count_passenger_room.tpl"}
            <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search margin-center p-1">
                <input type="hidden" id="nights_hotel" name="nights_hotel" value="" placeholder='تاریخ خروج' class='nights-hotel-js'>
                <button type="button" onclick="searchInternalHotel(true)"
                        class="btn theme-btn seub-btn b-0"><span>##Search##</span></button>
            </div>
        </form>
    </div>
    <input type='hidden' id="type_section" name="type_section" class="type-section-js" value="internal">
</div>