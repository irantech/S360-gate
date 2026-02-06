
<div class="tab-pane  {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="{$client['MainService']}" role="tabpanel" aria-labelledby="{$client['MainService']}-tab">
    <div id="hotel_khareji" class="row flex-wrap international-hotel-js" style='display: flex'>
        <div class="empty-box"></div>
        <form target="_blank" data-action="https://s360online.iran-tech.com/" class="d_contents"  method="post" id="international_hotel">
            {include file="./sections/hotel/international/destination_city.tpl"}
            {include file="./sections/hotel/international/check_in_date.tpl"}
            {include file="./sections/hotel/international/check_out_date.tpl"}
            {include file="./sections/hotel/international/count_passenger_room.tpl"}

            <div class="col-lg-3 col-md-6 col-sm-6 col-12 btn_s col_search margin-center">
                <input type="hidden" id="nights_hotel" name="nights_hotel" class='nights-hotel-js'>
                <button  type="button" onclick="searchInternationalHotel()"
                         class="btn theme-btn seub-btn b-0">
                    <span class="span-search">##Search## </span>
                </button>

            </div>
        </form>
    </div>
    <input type='hidden' id="type_section" name="type_section" class="type-section-js" value="internal">
</div>