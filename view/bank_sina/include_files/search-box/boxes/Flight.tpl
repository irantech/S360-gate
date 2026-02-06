{assign var="obj_main_page" value=$obj_main_page }
<div class="tab-pane active" id="{$client['MainService']}">
    {include file="./sections/flight/internal/btn_radio_internal_external.tpl"}

    <div id="internal_flight" class="d_flex flex-wrap internal-flight-js" style='display: flex;'>
        <form method="post" class="d_contents" target="_blank" id="internal_flight_form" name="internal_flight_form" style=''>
            {include file="./sections/flight/internal/btn_type_way.tpl"}
            {include file="./sections/flight/internal/origin_selection.tpl"}
            {include file="./sections/flight/internal/destination_selection.tpl"}
            {include file="./sections/flight/internal/date_flight.tpl"}
            {include file="./sections/flight/internal/passenger_count.tpl"}
            <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search center-margin">
                <button type="button" onclick="searchFlight('internal')"
                        class="btn theme-btn seub-btn b-0"><span>##Search##</span></button>
            </div>
        </form>
    </div>
    <div id="international_flight" class="flex-wrap international-flight-js" style='display:none'>
        <form data-action="https://s360online.iran-tech.com/" method="post" target="_blank"
              class="d_contents" id="international_flight_form" name="international_flight_form">
            {include file="./sections/flight/international/btn_type_way.tpl"}
            {include file="./sections/flight/international/origin_search_box.tpl"}
            {include file="./sections/flight/international/destination_search_box.tpl"}
            {include file="./sections/flight/international/date_flight.tpl"}
            {include file="./sections/flight/international/passenger_count.tpl"}

            <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search center-margin">
                <button type="button" class="btn theme-btn seub-btn b-0"
                        onclick="searchFlight('international')"><span>##Search##</span></button>
            </div>
        </form>
    </div>
</div>






