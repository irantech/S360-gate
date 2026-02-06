<div class="__box__ tab-pane {if $active} active {/if}" id="Hotel1">
    <div id="internal_hotel" class="d_flex flex-wrap internal-hotel-js">
        <form data-action="s360online.iran-tech.com/" name="gdsHotelLocal"
              target="_blank" id="internal_hotel_form" class="d_contents" method="post">
            {include file="./sections/Hotel/internal/destination_city.tpl"}
            {include file="./sections/Hotel/internal/check_in_date.tpl"}
            {include file="./sections/Hotel/internal/check_out_date.tpl"}
            {include file="./sections/Hotel/internal/count_passenger_room.tpl"}
            <div class="col-12 btn_s col_search margin-center p-1">
                <button type="button" onclick="searchInternalHotel()"
                        class="btn theme-btn seub-btn b-0"><span>جستجو</span></button>
            </div>
        </form>
    </div>
</div>