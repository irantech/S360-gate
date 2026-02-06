<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search col_with_route">
    <div class="form-group">
        <div class="form-group origin_start">
            <input autocomplete="off" class="form-control inputSearchLocal route_origin_internal-js" id="route_origin_internal" name="route_origin_internal" onclick="displayCityList('origin')" placeholder="مبدأ ( شهر )" type="text"/>
            <input class="origin-internal-js" data-border-red="#route_origin_internal" id="route_origin_internal" name="route_origin_internal" placeholder="مبدأ" type="hidden" value=""/>
            <div id="list_airport_origin_internal"
                 class="resultUlInputSearch list-show-result list-origin-airport-internal-js">
            </div>
            <div id="list_origin_popular_internal"
                 class="resultUlInputSearch list-show-result list_popular_origin_internal-js">
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