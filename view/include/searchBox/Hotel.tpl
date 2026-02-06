
<div class="tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="Hotel">

    {include file="./sections/hotel/international/btn_radio_internal_external.tpl"}
    <div id="internal_hotel" class="d_flex flex-wrap internal-hotel-js">
        <form data-action="s360online.iran-tech.com/" name="gdsHotelLocal"
              target="_blank" id="internal_hotel_form" class="d_contents" method="post">
            {include file="./sections/hotel/internal/destination_city.tpl"}
            {include file="./sections/hotel/internal/check_in_date.tpl"}
            {include file="./sections/hotel/internal/check_out_date.tpl"}
            {include file="./sections/hotel/internal/count_passenger_room.tpl"}
            <div class="{if isset($col) } {$col} {else} col-lg-2{/if} col-md-3 col-sm-6 col-12 btn_s col_search margin-center">
                <button type="button" onclick="searchInternalHotel()"
                        class="btn theme-btn seub-btn b-0"><span>##Search##</span></button>
            </div>
        </form>
    </div>
    <div id="international_hotel" class="flex-wrap international-hotel-js">
        <form target="_blank" data-action="https://s360online.iran-tech.com/" class="d_contents"  method="post" id="international_hotel_form">
            {include file="./sections/hotel/international/destination_city.tpl"}
            {include file="./sections/hotel/international/check_in_date.tpl"}
            {include file="./sections/hotel/international/check_out_date.tpl"}
            {include file="./sections/hotel/international/count_passenger_room.tpl"}

            <div class="{if isset($col) } {$col} {else} col-lg-2{/if} col-md-3 col-sm-6 col-12 btn_s col_search margin-center">
                <input type="hidden" id="nights_hotel" name="nights_hotel" value="" placeholder='##Exitdate##' class='nights-hotel-js'>

                <button onclick="searchInternationalHotel()" type="button"  class="btn theme-btn seub-btn b-0"><span>##Search##</span></button>
            </div>
        </form>
    </div>
    <input type='hidden' id="type_section" name="type_section" class="type-section-js" value="internal">
</div>