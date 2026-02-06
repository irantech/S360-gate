<div class="__box__ tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'}active{/if}" id="Hotel">

    <div class="empty-div"></div>
    <div id="internal_hotel" class="d_flex flex-wrap internal-hotel-js">
        <form class="d_contents" data-action="s360online.iran-tech.com/" id="internal_hotel_form" method="post" name="gdsHotelLocal" target="_blank">
            {include file="./sections/Hotel/internal/destination_city.tpl"}
            {include file="./sections/Hotel/internal/check_in_date.tpl"}
            {include file="./sections/Hotel/internal/check_out_date.tpl"}
            {include file="./sections/Hotel/internal/count_passenger_room.tpl"}


            <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search margin-center p-1">
                <button type="button" onclick="searchInternalHotel()" class="btn theme-btn seub-btn b-0">
                    <span>بحث</span>
                </button>
            </div>
        </form>
    </div>


    <input type='hidden' id="type_section" name="type_section" class="type-section-js" value="internal">
</div>