<div class="col-lg-6 col-md-6 col-sm-6 col-12 col_search search_col col_with_route margin-bottom">
    <div class="form-group origin_start">
        <input type="text"
               onclick='displayCityListExternal("origin" , event)'
               name="iata_origin_international"
               id="iata_origin_international"
               autocomplete='off'
               class="form-control  inputSearchForeign iata-origin-international-js"
               placeholder="مبدأ (شهر,فرودگاه)">
        <input id="origin_international"
               placeholder="مبدأ"
               class="origin-international-js"
               type="hidden" value=""
               data-border-red="#iata_origin_international"
               name="iata_origin_international">
        <div id="list_airport_origin_international"
             class="resultUlInputSearch list-show-result list-origin-airport-international-js">
        </div>
        <div id="list_origin_popular_external"
             class="resultUlInputSearch list-show-result list_popular_origin_external-js">
        </div>
        <i class="fa-regular fa-location-dot icon-location-flight-kh"></i>
    </div>
    <button onclick="reversDestination('international')"
            class="switch_routs"
            type="button" name="button">
        <i class="fas fa-exchange-alt"></i>
    </button>
</div>