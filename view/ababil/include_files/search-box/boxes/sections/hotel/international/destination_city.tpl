<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search search_col">
    <div class="form-group">
<!--          <span class="destination_start">
              <input type="text"
                     data-search='international'
                     id="international_Hotel"
                     name="international_Hotel"
                     class="form-control search-hotel-js text-search-hotel-js"
                     placeholder="شهر مقصد">
          </span>
        <div id="divCityExternalHotelLists" class=" resultUlInputSearch d-none div-hotel-city-js"></div>
        <input id="destination_country"
               placeholder="شهر مقصد"
               name="destination_country"
               class='destination-country-js'
               value="" type="hidden">
        <input id="destination_city"
               name="destination_city"
               class='destination-city-js'
               value=""
               type="hidden">-->

        <div class="inputSearchForeign-box inputSearchForeign-pad_Fhotel w-100">
            <div class="s-u-in-out-wrapper raft raft-change change-bor">
                <input id="autoComplateSearchIN_2" name="autoComplateSearchIN"
                       class="inputSearchForeign w-100 form-control" type="text" value=""
                       placeholder='##Selection## ##City##'
                       autocomplete="off"
                       onkeyup="searchCity('externalHotel')"
                       onclick="openBoxPopular('externalHotel')">
                <input id="destination_country" name="destination_country"type="hidden" value="" placeholder='##Selection## ##City##'>

                <input class="destination-country-js" name="destination-country-js"type="hidden" value="" placeholder='##Selection## ##City##'>
                <input class="destination-city-js" name="destination-city-js"type="hidden" value="" placeholder='##Selection## ##City##'>

                <input id="destination_city_foreign" name="destination_city_foreign"type="hidden" value="" placeholder='##Selection## ##City##'>
                <input id="destination_city" name="destination_city"type="hidden" value="" placeholder='##Selection## ##City##'>
                <ul id="listSearchCity_2" class="ul-inputSearch-externalHotel displayiN"></ul>
            </div>
        </div>
    </div>
</div>