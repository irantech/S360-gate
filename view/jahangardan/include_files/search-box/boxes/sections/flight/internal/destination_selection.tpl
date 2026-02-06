{*<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">*}
{*    <div class="form-group">*}
{*        <select data-placeholder="انتخاب مقصد" name="route_destination_internal" id="route_destination_internal"*}
{*                class="select2_in select2-hidden-accessible destination-internal-js" tabindex="-1" aria-hidden="true">*}
{*            <option value="">انتخاب مقصد</option>*}
{*        </select>*}
{*    </div>*}
{*</div>*}
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
    <div class="form-group">
        <span class="destnition_start">
        <input type="text"
               onclick="displayCityList('destination')"
               autocomplete='off'
               id="route_destination_internal"
               name="route_destination_internal"
               class="inputSearchForeign form-control route_destination_internal-js"
               placeholder="مقصد ( شهر )">
        </span>
        <input id="route_destination_internal"
               class="destination-internal-js"
               type="hidden"
               value=""
               placeholder="مقصد"
               data-border-red="#route_destination_internal"
               name="route_destination_internal">
        <div id="list_destination_airport_internal"
             class="resultUlInputSearch list-show-result list-destination-airport-internal-js">
        </div>
        <div id="list_destination_popular_internal"
             class="resultUlInputSearch list-show-result list_popular_destination_internal-js">
        </div>
    </div>
</div>