<div class="col-12 col_search search_col">
    <p class="label_input">شهر یا آدرس مقصد</p>
    <div class="form-group">
        <span class="destnition_start">
        <input type="text"
               onclick="displayCityList('destination')"
               autocomplete='off'
               id="route_destination_internal"
               name="route_destination_internal"
               class="inputSearchForeign form-control route_destination_internal-js"
               placeholder="##SelectDestinationCity##">
        </span>
        <input id="route_destination_internal"
               class="destination-internal-js"
               type="hidden"
               value=""
               placeholder="##Destination##"
               data-border-red="#route_destination_internal"
               name="route_destination_internal">
        <div id="list_destination_airport_internal"
             class="resultUlInputSearch list-show-result list-destination-airport-internal-js">
        </div>
        <div id="list_destination_popular_internal"
             class="w-300 resultUlInputSearch list-show-result list_popular_destination_internal-js">
        </div>
    </div>
</div>