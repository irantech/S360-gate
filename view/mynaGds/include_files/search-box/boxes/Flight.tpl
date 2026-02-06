<div class="__box__ tab-pane active" id="Flight">
    {include file="./sections/Flight/internal/btn_radio_internal_external.tpl"}
    <div class="d_flex flex-wrap internal-flight-js justify-content-center" id="internal_flight">
        <form class="d_contents" id="internal_flight_form" method="post" name="internal_flight_form" target="_blank">
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
    <div class="flex-wrap international-flight-js justify-content-center" id="international_flight">
        <form class="d_contents" data-action="https://s360online.iran-tech.com/" id="international_flight_form"
              method="post" name="international_flight_form" target="_blank">
            {include file="./sections/Flight/international/btn_type_way.tpl"}
            {include file="./sections/Flight/international/origin_search_box.tpl"}
            {include file="./sections/Flight/international/destination_search_box.tpl"}
            {include file="./sections/Flight/international/date_flight.tpl"}
            {include file="./sections/Flight/international/passenger_count.tpl"}
            <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search margin-center p-1">
                <button class="btn theme-btn seub-btn b-0" onclick="searchFlight('international')" type="button"><span>جستجو</span>
                </button>
            </div>
        </form>
    </div>
    <div class="flex-wrap flight-multi-way-js" id="flight_multi_way">
        <input class="count-path-js" type="hidden" value="2" />
        <div class="col-md-12 col-xs-12 col-sm-12 d-ceckboxs">
            <div class="cntr">
                <label class="btn-radio select_multiway click_flight_oneWay" for="rdo-3">
                    <svg height="20px" viewbox="0 0 20 20" width="20px">
                        <circle cx="10" cy="10" r="9"></circle>
                        <path class="inner"
                              d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"></path>
                        <path class="outer"
                              d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"></path>
                    </svg>
                    <span>یک طرفه </span>
                </label>
                <label class="btn-radio select_multiway click_flight_twoWay" for="rdo-4">
                    <input class="multiselectportal" id="rdo-4" name="select-rb" type="radio" value="2" />
                    <svg height="20px" viewbox="0 0 20 20" width="20px">
                        <circle cx="10" cy="10" r="9"></circle>
                        <path class="inner"
                              d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"></path>
                        <path class="outer"
                              d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"></path>
                    </svg>
                    <span>دو طرفه </span>
                </label>
                <label class="btn-radio select_multiway click_flight_multiTrack" for="rdo-5">
                    <input checked="" class="multiselectportal" id="rdo-3" name="select-rb" type="radio" value="1" />
                    <svg height="20px" viewbox="0 0 20 20" width="20px">
                        <circle cx="10" cy="10" r="9"></circle>
                        <path class="inner"
                              d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"></path>
                        <path class="outer"
                              d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"></path>
                    </svg>
                </label></div>
        </div>

    </div>
</div>