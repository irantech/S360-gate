<div class="tab-pane {if $smarty.const.PAGE_TITLE eq 'flight' || $smarty.const.PAGE_TITLE eq 'flight' || $smarty.const.PAGE_TITLE eq 'internalFlight'} active {/if} " id="Flight">
    <div class='row'>
        <div class='col-lg-6 col-12'>
            {include file="./sections/flight/internal/btn_radio_internal_external.tpl"}
            <div id="internal_flight" class="d_flex flex-wrap internal-flight-js">
                <form method="post" class="d_contents" target="_blank" id="internal_flight_form" name="internal_flight_form">
                    <div class="col-12 col_search">
                        <h6>پرواز داخلی ایده آل را با بهترین قیمت پیدا کنید</h6>
                    </div>
                    {include file="./sections/flight/internal/btn_type_way.tpl"}
                    {include file="./sections/flight/internal/origin_selection.tpl"}
                    {include file="./sections/flight/internal/destination_selection.tpl"}
                    {include file="./sections/flight/internal/date_flight.tpl"}
                    {include file="./sections/flight/internal/passenger_count.tpl"}
                    <div class="col-lg-12 col-sm-6 col-12 btn_s col_search">
                        <button type="button" onclick="searchFlight('internal')"
                                class="btn theme-btn seub-btn b-0"><span>##Search##</span></button>
                    </div>
                </form>
            </div>
            <div id="international_flight" class="flex-wrap international-flight-js">
                <form data-action="https://s360online.iran-tech.com/" method="post" target="_blank"
                      class="d_contents" id="international_flight_form" name="international_flight_form">
                    <div class="col-12 col_search">
                        <h6>پرواز خارجی ایده آل را با بهترین قیمت پیدا کنید</h6>
                    </div>
                    {include file="./sections/flight/international/btn_type_way.tpl"}
                    {include file="./sections/flight/international/origin_search_box.tpl"}
                    {include file="./sections/flight/international/destination_search_box.tpl"}
                    {include file="./sections/flight/international/date_flight.tpl"}
                    {include file="./sections/flight/international/passenger_count.tpl"}

                    <div class="col-lg-12 col-sm-6 col-12 btn_s col_search">
                        <button type="button" class="btn theme-btn seub-btn b-0"
                                onclick="searchFlight('international')"><span>##Search##</span></button>
                    </div>
                </form>
            </div>
        </div>
        <section class="col-lg-6 col-12 text_banner_main d-flex align-items-center">
            <div class="ticker">
                <ul>
                    <li>پرواز به زیبایی های جهان</li>
                    <li>با فلای ایر تور</li>
                </ul>
            </div>
        </section>
    </div>
</div>
