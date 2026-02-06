{assign var="routes_departure_flight_internal" value=$obj_main_page->cityDepartureFlightInternal(false)}{*if use customer's database argument is true*}

<div class="col-12 col_search search_col">
    <p class="label_input">شهر یا آدرس مبدا</p>
    <div class="form-group">
        <div class="form-group origin_start">
            <input
                    onclick="displayCityList('origin')"
                    type="text" name="route_origin_internal"
                    id="route_origin_internal"
                    autocomplete='off'
                    class="form-control inputSearchLocal route_origin_internal-js"
                    placeholder="##Selectsource##">
            <input id="route_origin_internal"
                   class="origin-internal-js"
                   type="hidden"
                   placeholder="##Origin##"
                   data-border-red="#route_origin_internal"
                   value=""
                   name="route_origin_internal">
            <div id="list_airport_origin_internal"
                 class="resultUlInputSearch list-show-result list-origin-airport-internal-js">
            </div>
            <div id="list_origin_popular_internal"
                 class="w-300 resultUlInputSearch list-show-result list_popular_origin_internal-js">
            </div>
        </div>
    </div>
    <button onclick="reversRouteFlight('internal')"
            class="switch_routs"
            type="button"
            name="button">
        <i class="fas fa-exchange-alt"></i>
    </button>
</div>