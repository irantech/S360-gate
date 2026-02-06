<div class="__box__ tab-pane active" id="Flight_internal">
    <h5 class="title_searchBox">بلیط هواپیما</h5>
    <div id="internal_flight" class="d_flex flex-wrap internal-flight-js">
        <form class="d_contents" id="internal_flight_form" method="post" name="internal_flight_form" target="_blank">


            {include file="./sections/Flight/internal/btn_type_way.tpl"}
            {include file="./sections/Flight/internal/origin_selection.tpl"}
            {include file="./sections/Flight/internal/destination_selection.tpl"}
            {include file="./sections/Flight/internal/date_flight.tpl"}
            {include file="./sections/Flight/internal/passenger_count.tpl"}

            <div class="col-lg-2 col-md-12 col-sm-12 col-12 btn_s col_search margin-center">
                <button onclick="searchFlight('internal')" type="button" class="btn theme-btn seub-btn b-0">
                    <span class="fa fa-search"></span>
                    جستجو
                </button>
            </div>
        </form>
    </div>
</div>
<div class="__box__ tab-pane " id="Flight_external">
    <h5 class="title_searchBox">بلیط پرواز</h5>
    <div id="international_flight" class="flex-wrap d-flex international-flight-js">
        <form class="d_contents" data-action="https://s360online.iran-tech.com/" id="international_flight_form" method="post" name="international_flight_form" target="_blank">

            {include file="./sections/Flight/international/btn_type_way.tpl"}
            {include file="./sections/Flight/international/origin_search_box.tpl"}
            {include file="./sections/Flight/international/destination_search_box.tpl"}
            {include file="./sections/Flight/international/date_flight.tpl"}
            {include file="./sections/Flight/international/passenger_count.tpl"}

            <div class="col-lg-2 col-md-12 col-sm-12 col-12 btn_s col_search margin-center">
                <button onclick="searchFlight('international')" type="button" class="btn theme-btn seub-btn b-0">
                    <span class="fa fa-search"></span>
                    جستجو
                </button>
            </div>
        </form>
    </div>
</div>