
<div class="tab-pane" id="hotel-internalTab" role="tabpanel" aria-labelledby="hotel-internal-tab">
    <div id="internal_hotel" class="d_flex flex-wrap internal-hotel-js">
        <form data-action="s360online.iran-tech.com/" name="gdsHotelLocal"
              target="_blank" id="internal_hotel_form" class="d_contents" method="post">
            <div class="w-100 mb-2">
                <div class="cntr p-1 h-48"></div>
            </div>
            {include file="./sections/hotel/internal/destination_city.tpl"}
            {include file="./sections/hotel/internal/check_in_date.tpl"}
            {include file="./sections/hotel/internal/check_out_date.tpl"}
            {include file="./sections/hotel/internal/count_passenger_room.tpl"}
            <div class="w-100">
                <div class="mx-auto col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search">
                    <button type="button" onclick="searchInternalHotel()"
                            class="btn button w-100 h-100 seub-btn b-0"><span>جستجو</span></button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="tab-pane" id="hotel-internationTab" role="tabpanel" aria-labelledby="hotel-internation-tab">

    <div id="international_hotel" class="flex-wrap international-hotel-js">
        <form target="_blank" data-action="https://s360online.iran-tech.com/" class="d_contents"  method="post" id="international_hotel_form">
            <div class="w-100 mb-2">
                <div class="cntr p-1 h-48"></div>
            </div>
            {include file="./sections/hotel/international/destination_city.tpl"}
            {include file="./sections/hotel/international/check_in_date.tpl"}
            {include file="./sections/hotel/international/check_out_date.tpl"}
            {include file="./sections/hotel/international/count_passenger_room.tpl"}

            <div class="w-100">
                <div class="mx-auto col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search">
                    <input type="hidden" id="nights_hotel" name="nights_hotel" value="" placeholder='تاریخ خروج' class='nights-hotel-js'>
                    <button onclick="searchInternationalHotel()" type="button"  class="btn button w-100 h-100 seub-btn b-0"><span>جستجو</span></button>
                </div>
            </div>
        </form>
    </div>
</div>
<input type='hidden' id="type_section" name="type_section" class="type-section-js" value="internal">
