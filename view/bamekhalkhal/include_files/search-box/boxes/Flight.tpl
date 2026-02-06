<div class="__box__ tab-pane" id="Flight">
    {include file="./sections/Flight/internal/btn_radio_internal_external.tpl"}

    <div id="internal_flight" class="_internal d_flex flex-wrap internal-flight-js">
        <form method="post" class="d_contents" target="_blank" id="internal_flight_form" name="internal_flight_form">
            {include file="./sections/Flight/internal/btn_type_way.tpl"}
            {include file="./sections/Flight/internal/origin_selection.tpl"}
            {include file="./sections/Flight/internal/destination_selection.tpl"}
            {include file="./sections/Flight/internal/date_flight.tpl"}
            {include file="./sections/Flight/internal/passenger_count.tpl"}
            <div class="col-12 btn_s col_search margin-center p-1">
                <button type="button" onclick="searchFlight('internal')"
                        class="btn theme-btn seub-btn b-0"><span>جستجو</span></button>
            </div>
        </form>
    </div>

<div class="__box__ tab-pane " id="Flight-international">
    <div id="international_flight" class="_external flex-wrap international-flight-js">
        <form data-action="https://s360online.iran-tech.com/" method="post" target="_blank" class="d_contents" id="international_flight_form" name="international_flight_form">
            {include file="./sections/Flight/international/btn_type_way.tpl"}
            {include file="./sections/Flight/international/origin_search_box.tpl"}
            {include file="./sections/Flight/international/destination_search_box.tpl"}
            {include file="./sections/Flight/international/date_flight.tpl"}
            {include file="./sections/Flight/international/passenger_count.tpl"}
            <div class="col-12 btn_s col_search margin-center p-1">
                <button type="button" class="btn theme-btn seub-btn b-0"
                        onclick="searchFlight('international')"><span>جستجو</span></button>
            </div>
        </form>
    </div>
</div>
</div>