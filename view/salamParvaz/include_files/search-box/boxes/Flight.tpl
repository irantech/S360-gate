<div class="__box__ tab-pane shadow-box active search-background" id="Flight_internal" >
    <div id="internal_flight" class="_internal align-items-center d_flex flex-wrap internal-flight-js searchbox-style">
        <form method="post" class="d_contents searchbox-postion" data-target="_blank" target="_blank" id="internal_flight_form"
              name="internal_flight_form">

            {include file="./sections/Flight/internal/btn_type_way.tpl"}
            <input type="hidden" id="flight_class_internal" name="flight_class_internal" value="all">

            {include file="./sections/Flight/internal/origin_selection.tpl"}
            {include file="./sections/Flight/internal/destination_selection.tpl"}
            {include file="./sections/Flight/internal/date_flight.tpl"}
            {include file="./sections/Flight/internal/passenger_count.tpl"}




            <div class="col-xl-1 col-lg-6 col-md-6 col-sm-6 col-12 btn_s col_search mr-auto mb-xl-0 mb-sm-2">
                <button type="button" onclick="searchFlight('internal')"
                        class="btn theme-btn seub-btn b-0"><span>جستجو</span></button>
            </div>
        </form>
    </div>
</div>

<div class="__box__ tab-pane shadow-box  search-background" id="Flight_external">
    <div id="international_flight" class="_external align-items-center flex-wrap international-flight-js searchbox-style">
        <form method="post" data-target="_blank"
              class="d_contents" id="international_flight_form" target="_blank" name="international_flight_form">


            {include file="./sections/Flight/international/btn_type_way.tpl"}
            <input type="hidden" id="flight_class_international" name="flight_class_international" value="all">


            {include file="./sections/Flight/international/origin_search_box.tpl"}
            {include file="./sections/Flight/international/destination_search_box.tpl"}
            {include file="./sections/Flight/international/date_flight.tpl"}
            {include file="./sections/Flight/international/passenger_count.tpl"}
            <div class="col-xl-1 col-lg-6 col-md-6 col-sm-6 col-12 btn_s col_search mr-auto  mb-xl-0 mb-sm-2">
                <button type="button" class="btn theme-btn seub-btn b-0"
                        onclick="searchFlight('international')"><span>جستجو</span></button>
            </div>
        </form>
    </div>
</div>
