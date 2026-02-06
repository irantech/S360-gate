<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search col_with_route p-1">
    <div class="form-group">
        <div class="form-group origin_start">
            <input
                    onclick="displayCityList('origin')"
                    type="text" name="route_origin_internal"
                    id="route_origin_internal"
                    autocomplete='off'
                    class="form-control inputSearchLocal route_origin_internal-js"
                    placeholder="المبدأ (مدينة)">
            <input id="route_origin_internal"
                   class="origin-internal-js"
                   type="hidden"
                   placeholder="المبدأ"
                   data-border-red="#route_origin_internal"
                   value=""
                   name="route_origin_internal">
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
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M443.3 139.3c6.2-6.2 6.2-16.4 0-22.6l-96-96c-6.2-6.2-16.4-6.2-22.6 0s-6.2 16.4 0 22.6L393.4 112 16 112c-8.8 0-16 7.2-16 16s7.2 16 16 16l377.4 0-68.7 68.7c-6.2 6.2-6.2 16.4 0 22.6s16.4 6.2 22.6 0l96-96zm-342.6 352c6.2 6.2 16.4 6.2 22.6 0s6.2-16.4 0-22.6L54.6 400 432 400c8.8 0 16-7.2 16-16s-7.2-16-16-16L54.6 368l68.7-68.7c6.2-6.2 6.2-16.4 0-22.6s-16.4-6.2-22.6 0l-96 96c-6.2 6.2-6.2 16.4 0 22.6l96 96z"/></svg>
    </button>
</div>