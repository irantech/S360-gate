<div class="tab-pane {if $client['order_number'] eq '1' || $active_tab eq $client['MainService']}active{/if}"
     id="{$client['MainService']}" role="tabpanel" aria-labelledby="{$client['MainService']}-tab">
    <div id="flight_khareji">
        <form method="post" target="_blank" class="d_contents" id="international_flight_form" name="international_flight_form">
            {include file="./sections/flight/international/btn_type_way.tpl"}
            {include file="./sections/flight/international/origin_search_box.tpl"}
            {include file="./sections/flight/international/destination_search_box.tpl"}
            {include file="./sections/flight/international/date_flight.tpl"}
            {include file="./sections/flight/international/passenger_count.tpl"}
            <div class="col-lg-2 col-md-6 col-sm-6 col-6 btn_s col_search">
                <button type="button" onclick="searchFlight('international')" class="button height_C w-100">
                     <span>
                        جستجو
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
