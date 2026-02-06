{assign var="obj_main_page" value=$obj_main_page }
<div class="tab-pane {if $smarty.const.GDS_SWITCH neq 'page'}active{/if}" id="{$client['MainService']}">
    <div id="internal_flight" class="d_flex flex-wrap internal-flight-js">
        <form method="post" class="d_contents" target="_blank" id="internal_flight_form" name="internal_flight_form">
            {include file="./sections/flight/internal/btn_type_way.tpl"}
            {include file="./sections/flight/internal/origin_selection.tpl"}
            {include file="./sections/flight/internal/destination_selection.tpl"}
            {include file="./sections/flight/internal/date_flight.tpl"}
            {include file="./sections/flight/internal/passenger_count.tpl"}
            <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search margin-center">
                <button type="button" onclick="searchFlight('internal')"
                        class="btn theme-btn seub-btn b-0"><span>##Search##</span></button>
            </div>
        </form>
    </div>
</div>
