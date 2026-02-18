<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col col_with_route">
    <div class="form-group origin_start">
        <input type="text"
               onclick='displayCityListExternal("origin" , event)'
               name="iata_origin_international"
               id="iata_origin_international"
               autocomplete='off'
               class="form-control inputSearchForeign iata-origin-international-js"
               placeholder="##OriginCityAirPlane2##">
        <input id="origin_international"
               class="origin-international-js"
               type="hidden" value=""
               placeholder="##Origin##"
               data-border-red="#iata_origin_international"
               name="iata_origin_international">
        <div id="list_airport_origin_international"
             class="resultUlInputSearch list-show-result list-origin-airport-international-js">
        </div>
        <div id="list_origin_popular_external"
             class="w-390 resultUlInputSearch list-show-result list_popular_origin_external-js">
        </div>
    </div>
    <button onclick="reversDestination('international')"
            class="switch_routs"
            type="button" name="button">
        <i class="fas fa-exchange-alt"></i>
    </button>
</div>