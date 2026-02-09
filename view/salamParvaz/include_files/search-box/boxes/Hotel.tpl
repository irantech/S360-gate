<div class="__box__ tab-pane shadow-box {if  $smarty.const.GDS_SWITCH eq 'page'}active{/if} search-background" id="Hotel_internal" style="padding:2.5px !important">
    {*    {include file="./sections/Hotel/international/btn_radio_internal_external.tpl"}*}
    <div class="d_flex flex-wrap align-items-center internal-hotel-js searchbox-style searchbox-style-hotel" id="internal_hotel">
        <form class="d_contents" data-action="s360online.iran-tech.com/" id="internal_hotel_form" method="post" name="gdsHotelLocal" target="_blank">
            {include file="./sections/Hotel/internal/destination_city.tpl"}
            {include file="./sections/Hotel/internal/check_in_date.tpl"}
            {include file="./sections/Hotel/internal/check_out_date.tpl"}
            {include file="./sections/Hotel/internal/count_passenger_room.tpl"}
            <div class="col-xl-1 col-lg-6 col-md-6 col-sm-6 col-12 btn_s col_search d-flex mr-auto m-sm-auto">
                <button class="btn theme-btn seub-btn b-0 mb-xl-0  mb-sm-2" style="left:8px" onclick="searchInternalHotel(true)" type="button"><span>جستجو</span></button>
            </div>
        </form>
    </div>
</div>
<div class="__box__ tab-pane shadow-box {if  $smarty.const.GDS_SWITCH eq 'page'}active{/if} search-background" id="Hotel_external" style="padding:2.5px !important">

    <div class="flex-wrap international-hotel-js d-flex align-items-center searchbox-style searchbox-style-hotel" id="international_hotel">
        <form class="d_contents" data-action="https://s360online.iran-tech.com/" id="international_hotel_form" method="post" target="_blank">
            {include file="./sections/Hotel/international/destination_city.tpl"}
            {include file="./sections/Hotel/international/check_in_date.tpl"}
            {include file="./sections/Hotel/international/check_out_date.tpl"}
            {include file="./sections/Hotel/international/count_passenger_room.tpl"}
            <div class="col-xl-1 col-lg-6 col-md-6 col-sm-6 col-12 btn_s col_search d-flex mr-auto m-sm-auto">
                <input class="nights-hotel-js" id="nights_hotel" name="nights_hotel" placeholder="تاریخ خروج" type="hidden" value=""/>
                <button class="btn theme-btn seub-btn b-0 mb-xl-0 mb-sm-2" style="left:8px" onclick="searchInternationalHotel(true)" type="button"><span>جستجو</span></button>
            </div>
        </form>
    </div>
    <input class="type-section-js" id="type_section" name="type_section" type="hidden" value="internal"/>
</div>
