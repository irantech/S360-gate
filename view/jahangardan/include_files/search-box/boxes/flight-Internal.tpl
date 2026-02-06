{assign var="obj_main_page" value=$obj_main_page }
<div class="tab-pane {if $client['order_number'] eq '1' || $active_tab eq $client['MainService']}active{/if}" id="{$client['MainService']}"
     role="tabpanel" aria-labelledby="{$client['MainService']}-tab">
    <div id="flight_dakheli">
        <form method="post" class="d_contents" target="_blank" id="internal_flight_form" name="internal_flight_form">
            {include file="./sections/flight/internal/btn_type_way.tpl"}
            {include file="./sections/flight/internal/origin_selection.tpl"}
            {include file="./sections/flight/internal/destination_selection.tpl"}
            {include file="./sections/flight/internal/date_flight.tpl"}
            {include file="./sections/flight/internal/passenger_count.tpl"}
            <div class="col-lg-2 col-md-6 col-sm-6 col-6 btn_s col_search">
                <button type="button" onclick="searchFlight('internal')" class="button height_C w-100">
                    <span>
                        جستجو
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
