{assign var="obj_main_page" value=$obj_main_page }
<div class="tab-pane active show" id="flight-internalTab" role="tabpanel" aria-labelledby="flight-internal-tab">
    <div id="internal_flight" class="d_flex flex-wrap ">
        <form method="post" class="d_contents" target="_blank" id="internal_flight_form" name="internal_flight_form">
            {include file="./sections/flight/internal/btn_type_way.tpl"}
            {include file="./sections/flight/internal/origin_selection.tpl"}
            {include file="./sections/flight/internal/destination_selection.tpl"}
            {include file="./sections/flight/internal/date_flight.tpl"}
            {include file="./sections/flight/internal/passenger_count.tpl"}
            <input type="hidden" name="set_international" id="set_international" value="1">
            <div class="w-100">
                <div class="mx-auto col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search">
                    <button type="button"  onclick="searchFlight('internal')"
                            class="btn button w-100 h-100 seub-btn b-0">
                                    <span>
                                    جستجو
                                </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="tab-pane" id="flight-internationTab" role="tabpanel" aria-labelledby="flight-internation-tab">
        <div id="international_flight" class="flex-wrap international-flight-js">
            <form data-action="https://s360online.iran-tech.com/" method="post" target="_blank"
                  class="d_contents" id="international_flight_form" name="international_flight_form">
                {include file="./sections/flight/international/btn_type_way.tpl"}
                {include file="./sections/flight/international/origin_search_box.tpl"}
                {include file="./sections/flight/international/destination_search_box.tpl"}
                {include file="./sections/flight/international/date_flight.tpl"}
                {include file="./sections/flight/international/passenger_count.tpl"}
                <div class="w-100">
                    <div class="mx-auto col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search">
                        <button type="button" class="btn button w-100 h-100 seub-btn b-0"
                                onclick="searchFlight('international')"><span>جستجو</span></button>
                    </div>
                </div>
            </form>
        </div>
        <div id="flight_multi_way" class="flex-wrap flight-multi-way-js" style="display: none">
            <input type="hidden" class="count-path-js" value="2">
                {include file="./sections/flight/multi-way/btn_type_way.tpl"}
                {include file="./sections/flight/multi-way/departure_first_multy_way.tpl"}
                {include file="./sections/flight/multi-way/destination_first_multi_way.tpl"}
                {include file="./sections/flight/multi-way/date_first_multi_way.tpl"}
                {include file="./sections/flight/multi-way/count_passenger_multi_way.tpl"}
                {include file="./sections/flight/multi-way/add_flight_multy_way.tpl"}
                <div   class="col-12 p-0 pt-1 d-flex flex-wrap parent_multiTrack parent_multiTrack additional-flight-multi-way-js">
                    <div class="col-12 px-0 style-sm d-flex flex-wrap">
                        {include file="./sections/flight/multi-way/departure_secend_multi_way.tpl"}

                        {include file="./sections/flight/multi-way/destination_second_multi_way.tpl"}

                        {include file="./sections/flight/multi-way/date_second_multi_way.tpl"}
                        {include file="./sections/flight/multi-way/remove_additional_multi_way.tpl"}
                    </div>
                </div>
            <div class="d-sm-none d-block col-12 btn_s col_search">
                <button type="button" class="btn_multiTrack seub-btn b-0"
                        onclick="newAdditionalExternal(this)"><span
                            class="d-flex align-items-center justify-content-center">افزودن پرواز </span>
                </button>
            </div>
            <div class="mx-auto d-lg-none d-block col-md-6 col-12 btn_s col_search">
                <button type="button" class="btn button w-100 h-100 seub-btn b-0"
                        onclick="severalPathFlight()"><span>جستجو</span></button>
            </div>

        </div>
</div>