<div class="__box__ tab-pane active" id="Flight">
    {include file="./sections/Flight/internal/btn_radio_internal_external.tpl"}
    <div class="_internal d_flex flex-wrap internal-flight-js" id="internal_flight">
        <form class="d_contents" id="internal_flight_form" method="post" name="internal_flight_form"
              target="_blank">

            {include file="./sections/Flight/internal/btn_type_way.tpl"}
            {include file="./sections/Flight/internal/origin_selection.tpl"}
            {include file="./sections/Flight/internal/destination_selection.tpl"}
            {include file="./sections/Flight/internal/date_flight.tpl"}
            {include file="./sections/Flight/internal/passenger_count.tpl"}

            <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search margin-center p-1">
                <button class="btn theme-btn seub-btn b-0" onclick="searchFlight('internal')" type="button">
                    <span>جستجو</span>
                </button>
            </div>
        </form>
    </div>
    <div class="_external flex-wrap international-flight-js" id="international_flight">
        <form class="d_contents" data-action="https://s360online.iran-tech.com/"
              id="international_flight_form" method="post" name="international_flight_form"
              target="_blank">

            {include file="./sections/Flight/international/btn_type_way.tpl"}
            {include file="./sections/Flight/international/origin_search_box.tpl"}
            {include file="./sections/Flight/international/destination_search_box.tpl"}
            {include file="./sections/Flight/international/date_flight.tpl"}
            {include file="./sections/Flight/international/passenger_count.tpl"}

            <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search margin-center p-1">
                <button class="btn theme-btn seub-btn b-0" onclick="searchFlight('international')"
                        type="button"><span>جستجو</span></button>
            </div>
        </form>
    </div>
</div>