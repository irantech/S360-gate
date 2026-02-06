{assign var="obj_main_page " value=$obj_main_page }
<div class="__box__ tab-pane {if $smarty.const.GDS_SWITCH eq 'mainPage' || $smarty.const.PAGE_TITLE == 'hotel' }active {/if} " id="Hotel">

    <div class="row">
        <div class="col-lg-6 col-12">
            {include file="./sections/Hotel/international/btn_radio_internal_external.tpl"}
            <div class="d_flex flex-wrap internal-hotel-js" id="internal_hotel">
                <form class="d_contents" data-action="s360online.iran-tech.com/" id="internal_hotel_form" method="post" name="gdsHotelLocal" target="_blank">
                    <div class="col-12 col_search">
                        <h6>هتل ایده آل را با بهترین قیمت پیدا کنید</h6>
                    </div>
                    {include file="./sections/Hotel/internal/destination_city.tpl"}
                    {include file="./sections/Hotel/internal/check_in_date.tpl"}
                    {include file="./sections/Hotel/internal/check_out_date.tpl"}
                    {include file="./sections/Hotel/internal/count_passenger_room.tpl"}
                    <div class="col-12 btn_s col_search">
                        <button class="mt-2 btn theme-btn seub-btn b-0" onclick="searchInternalHotel()" type="button"><span>جستجو</span></button>
                    </div>
                </form>
            </div>
            <div class="flex-wrap international-hotel-js" id="international_hotel">
                <form class="d_contents" data-action="https://s360online.iran-tech.com/" id="international_hotel_form" method="post" target="_blank">
                    <div class="col-12 col_search">
                        <h6>هتل ایده آل را با بهترین قیمت پیدا کنید</h6></div>
                    {include file="./sections/Hotel/international/destination_city.tpl"}
                    {include file="./sections/Hotel/international/check_in_date.tpl"}
                    {include file="./sections/Hotel/international/check_out_date.tpl"}
                    {include file="./sections/Hotel/international/count_passenger_room.tpl"}
                    <div class=" col-12 btn_s col_search">
                        <input class="nights-hotel-js" id="nights_hotel" name="nights_hotel" placeholder="تاریخ خروج" type="hidden" value=""/>
                        <button class="mt-2 btn theme-btn seub-btn b-0" onclick="searchInternationalHotel()" type="button"><span>جستجو</span></button>
                    </div>
                </form>
            </div>
        </div>
        <input class="type-section-js" id="type_section" name="type_section" type="hidden" value="internal"/>
        {foreach $banners as $key => $banner}
        <section class="col-lg-6 col-12 text_banner_main d-flex align-items-center">
            <div class="ticker">
                <ul>
                    <li>{$banner['title']}</li>
                    <li>{$banner['description']}</li>
                </ul>
            </div>
        </section>
        {/foreach}
    </div>
</div>