
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
    <div class="form-group">
                <span class="destnition_start">
                <input autocomplete="off" class="inputSearchForeign form-control iata-destination-international-js"
                       id="iata_destination_international" name="iata_destination_international"
                       onclick='displayCityListExternal("destination" , event)' placeholder="مقصد (شهر,فرودگاه)" type="text" />
                </span>
        <input class="destination-international-js"
               data-border-red="#iata_destination_international"
               id="destination_international" name="destination_international"
               type="hidden" value="" />
        <div class="resultUlInputSearch list-show-result list-destination-airport-international-js"
             id="list_destination_airport_international">
        </div>
        <div class="resultUlInputSearch list-show-result list_popular_destination_external-js"
             id="list_destination_popular_external">
        </div>
    </div>
</div>