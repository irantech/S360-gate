<div class="col-lg-6 col-md-6 col-sm-6 col-12 col_search search_col margin-bottom">
    <div class="form-group">
        <span class="destnition_start">
        <input type="text"
               onclick='displayCityListExternal("destination" , event)'
               autocomplete='off'
               id="iata_destination_international"
               name="iata_destination_international"
               class="inputSearchForeign form-control iata-destination-international-js"
               placeholder="مقصد (شهر,فرودگاه)">
        </span>
        <input id="destination_international"
               class="destination-international-js"
               type="hidden"
               value=""
               placeholder="مقصد"
               data-border-red="#iata_destination_international"
               name="destination_international">
        <div id="list_destination_airport_international"
             class="resultUlInputSearch list-show-result list-destination-airport-international-js">
        </div>
        <div id="list_destination_popular_external"
             class="resultUlInputSearch list-show-result list_popular_destination_external-js">
        </div>
        <i class="fa-regular fa-location-dot icon-location-flight-kh"></i>
    </div>
</div>