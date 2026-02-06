<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col col_with_route">
    <div class="form-group origin_start">
        <input autocomplete="off" class="form-control inputSearchForeign iata-origin-international-js" id="iata_origin_international" name="iata_origin_international" onclick='displayCityListExternal("origin" , event)' placeholder="مبدأ (شهر,فرودگاه)" type="text"/>

        <input class="origin-international-js" data-border-red="#iata_origin_international" id="origin_international" name="iata_origin_international" type="hidden" value=""/>

        <div class="resultUlInputSearch list-show-result list-origin-airport-international-js" id="list_airport_origin_international">
        </div>
        <div class="resultUlInputSearch list-show-result list_popular_origin_external-js" id="list_origin_popular_external">
        </div>
    </div>
    <button onclick="reversDestination('international')"
            class="switch_routs"
            type="button" name="button">
        <i class="fas fa-exchange-alt"></i>
    </button>
</div>