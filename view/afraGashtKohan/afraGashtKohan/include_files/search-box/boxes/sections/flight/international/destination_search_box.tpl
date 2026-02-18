<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
    <div class="form-group">
        <span class="destnition_start">
        <input type="text"
               onclick='displayCityListExternal("destination" , event)'
               autocomplete='off'
               id="iata_destination_international"
               name="iata_destination_international"
               class="inputSearchForeign form-control iata-destination-international-js"
               placeholder="##DestinationCityAirPlane2##">
        </span>
        <input id="destination_international"
               class="destination-international-js"
               type="hidden"
               value="" placeholder="##Destination##"
               data-border-red="#iata_destination_international"
               name="destination_international">
        <div id="list_destination_airport_international"
             class="resultUlInputSearch list-show-result list-destination-airport-international-js">
        </div>
        <div id="list_destination_popular_external"
             class="w-390 resultUlInputSearch list-show-result list_popular_destination_external-js">
        </div>
    </div>
</div>