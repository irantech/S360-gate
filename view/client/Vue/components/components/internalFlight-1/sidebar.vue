<template>
  <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 parvaz-sidebar col-padding-5">
    <div class="parent_sidebar">
      <div class="currency-gds" v-if="data_search.is_currency > 0" @click="showListCurrencyExist()">
        <div class="currency-inner DivDefaultCurrency">
          <img :src="`${getUrlWithoutLang()}/pic/flagCurrency/Iran.png`" alt="" id="IconDefaultCurrency"
               v-if="currency_info ===''">
          <img :src="`${getUrlWithoutLang()}/pic/flagCurrency/${currency_info.CurrencyFlag}`" alt=""
               id="IconDefaultCurrency" v-else>
          <span class="TitleDefaultCurrency" id="TitleDefaultCurrency">  {{ currency_title}}</span>
          <span class="currency-arrow"></span>
        </div>

        <div class="change-currency show-currency" v-show="is_show_currency_list">
          <div class="change-currency-inner">
            <div class="change-currency-item main" @click="ConvertCurrency('0','Iran.png','ریال ایران')">
              <img :src="`${getUrlWithoutLang()}/pic/flagCurrency/Iran.png`" alt="">
              <span>{{useXmltag('Rial')}}</span>
            </div>

            <template v-for="currency in list_currency">
              <div class="change-currency-item"
                   @click="ConvertCurrency(currency.CurrencyCode,currency.CurrencyFlag,currency.CurrencyTitle)">
                <img :src="`${getUrlWithoutLang()}/pic/flagCurrency/${currency.CurrencyFlag}`"
                     alt="">
                <span>{{currency.CurrencyTitle}}</span>
              </div>
            </template>
            <!---->
          </div>
        </div>
      </div>
      <div class="filter_airline_flight">
        <div class="filtertip parvaz-filter-change site-bg-main-color site-bg-color-border-bottom ">
          <a v-if="today_date"
             :href="`${amadeusPathByLang()}search-flight/1/${data_search.origin}-${data_search.destination}/${dataSearch.prev}/Y/${data_search.adult}-${data_search.child}-${data_search.infant}`">
                       <span class=" chooseiconDay icons tooltipWeighDay right site-border-text-color">
                           <i class="zmdi zmdi-chevron-right iconDay site-secondary-text-color"></i>
                           <span class="tooltiptextWeightDay"> {{ useXmltag('Previousday') }} </span>
                       </span>
          </a>
          <a v-else v-on:click.prevent.stop="" href="#">
                           <span class=" chooseiconDay icons tooltipWeighDay right site-border-text-color">
                               <i class="zmdi zmdi-chevron-right iconDay site-secondary-text-color"></i>
                               <span class="tooltiptextWeightDay"> {{ useXmltag('Previousday') }} </span>
                            </span>
          </a>
          <div class="tip-content ">
            <p class="">
              <span class=" bold counthotel">{{ data_search.name_departure}}</span>
              {{ useXmltag('On') }}
              <span class=" bold counthotel">{{ data_search.name_arrival}}</span>
            </p>
            <p class="counthotel txt12">{{data_search.DateFlightWithName}} </p>
            <div class="silence_span ph-item2" v-if="countFlights > 0">{{ countFlights }} {{
              useXmltag('NumberFlightFound')}}
            </div>
          </div>
          <a v-if="today_date"
             :href="`${amadeusPathByLang()}search-flight/1/${data_search.origin}-${data_search.destination}/${dataSearch.next}/Y/${data_search.adult}-${data_search.child}-${data_search.infant}`">
                       <span class="chooseiconDay icons tooltipWeighDay left site-border-text-color">
                           <i class="zmdi zmdi-chevron-left iconDay site-secondary-text-color">
                           </i>
                               <span class="tooltiptextWeightDay">  {{ useXmltag('Nextday') }}  </span>
                       </span>
          </a>
          <a v-else v-on:click.prevent.stop="" href="#">
                     <span class="chooseiconDay icons tooltipWeighDay left site-border-text-color">
                       <i class="zmdi zmdi-chevron-left iconDay site-secondary-text-color">
                       </i>
                           <span class="tooltiptextWeightDay">  {{ useXmltag('Nextday') }}  </span>
                   </span>
          </a>
          <div class="open-sidebar-parvaz " @click="showSearchBoxTicket()">

            {{ useXmltag('ChangeSearchType') }}
          </div>
        </div>

      </div>
      <!-- search box -->
      <div class=" s-u-update-popup-change">
        <form class="search-wrapper" action="" method="post">
          <div class="displayib padr20 padl20">
            <div class="ways_btns">
              <div @click="changeWays_('Oneway')" class="radiobtn Oneway">
                <input type="radio" id="huey" name="drone" value="huey"
                       :checked="(multi_way==false) ? 'checked' : ''">
                <label class=" site-bg-main-color-before" for="huey">
                  <i v-html="svg_icon_2"></i>
                  {{ useXmltag('Oneway') }}
                </label>
              </div>
              <div @click="changeWays_('Twoway')" class="radiobtn Twoway  ">
                <input type="radio" id="dewey" name="drone" value="dewey"
                       :checked="(multi_way) ? 'checked' : ''"
                       :class="(multi_way) ? 'checked' : ''" class="multiWays">
                <label class="site-bg-main-color-before" for="dewey">
                  <i v-html="svg_icon_1"></i>
                  {{ useXmltag('Twoway') }}

                </label>
              </div>
            </div>
          </div>

          <div class="d-flex flex-wrap align-items-center position-relative">
            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change position-relative">
              <div class="s-u-in-out-wrapper raft raft-change change-bor position-relative">
                <input id="search_origin_local" class="select option1 selectOneFlightVue search-box-selectOneFlightVue inputSearchForeign" type="text"
                       ref="origin"
                       :lang="`${getLang()}`"
                       v-model="title_origin_city_search"
                       name="origin" @keyup="searchCity" @focus="focusSearchCity"
                       @click.stop="dropBox('origin')">
                <img :src="`${getUrlWithoutLang()}view/client/assets/images/load.gif`"  id="LoaderForeignDep" name="LoaderForeignDep"
                     class="loaderSearch" v-show='search_origin_loading'>
                <input id="origin_local" class="" type="hidden" v-model="iata_origin"
                       name="origin">
                <div v-if="(cities_origin.length == 0 & title_origin_city_search == '') || show_popular">

                  <ul  class="resultFlight_international search-box-resultFlight" v-show="is_search">
                    <div class='parent-titr' v-if="stored_origin_cities && stored_origin_cities.length > 0 ">
                      <span>{{ useXmltag('History') }}</span>
                      <span class='delete-pointer' @click.stop="clearSearchedCities('arrival')">
                        {{ useXmltag('Clear') }}
                      </span>
                    </div>
                    <li v-for="city in stored_origin_cities" @click.stop="selectAirportOrigin(city,getLang())">
                      <i class="fa fa fa-clock-o my-icon-loction  margin-left-5 margin-right-5"></i>
                      {{ city[`Departure_City${getLang().charAt(0).toUpperCase() + getLang().slice(1)}`] }}
                      ({{ city[`Departure_Code`] }})
                    </li>
                    <span>{{ useXmltag('PopularRoutes') }}</span>
                    <li v-for="city in $store.state.popular_internal_flights" @click.stop="selectAirportOrigin(city,getLang())">
                      <i class="fa fa-map-marker my-icon-loction margin-left-5 margin-right-5"></i>
                      {{ city[`Departure_City${getLang().charAt(0).toUpperCase() + getLang().slice(1)}`] }}
                      ({{ city[`Departure_Code`] }})
                    </li>
                  </ul>
                </div>
                <div v-else>
                  <ul  class="resultFlight_international search-box-resultFlight" v-show='is_search'>
                    <li v-for="city in cities_origin" @click.stop="selectAirportOrigin(city,getLang())">
                      <i class="fa fa-map-marker my-icon-loction margin-left-5 margin-right-5"></i>
                      {{ city[`Departure_City${getLang().charAt(0).toUpperCase() + getLang().slice(1)}`] }}
                      ({{ city[`Departure_Code`] }})
                    </li>
                  </ul>
                </div>

              </div>
            </div>
            <div class="swap-flight-box search-box-swap-flight-box" @click="reversDestinations()">
              <span class="swap-flight-search-box-new"><i class="zmdi zmdi-swap site-main-text-color"></i></span>
            </div>
            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change bargasht bargasht-change change-bor position-relative">
              <div class="s-u-in-out-wrapper ">
                <input id="destination_city" class="inputSearchForeign search-box-inputSearchForeign" type="text"
                       v-model="title_arrival_city_search" :lang="`${getLang()}`"
                       ref='arrival' name="destination"
                       @keyup="searchCityArrival"  @focus="focusSearchArrivalCity"
                       @click.stop="dropBox('arrival')">
                <img :src="`${getUrlWithoutLang()}view/client/assets/images/load.gif`" id="LoaderForeignReturn" name="LoaderForeignReturn"
                     class="loaderSearch" v-if="search_arrival_loading">
                <input id="destination_local" class="" type="hidden" v-model="iata_arrival"
                       name="destination_local">
                <div v-if="(cities_arrival.length == 0 & title_arrival_city_search == '') || show_arrival_popular">

                  <ul class="resultFlight_international search-box-resultFlight" v-show="is_arrival_search">
                    <div class='parent-titr' v-if="stored_arrival_cities && stored_arrival_cities.length > 0 ">
                      <span> {{ useXmltag('History') }}</span>
                      <span class='delete-pointer' @click.stop="clearSearchedCities('origin')">
                         {{ useXmltag('Clear') }}
                      </span>
                    </div>
                    <li v-for="city in stored_arrival_cities" @click.stop="selectAirportArrival(city,getLang())">
                      <i class="fa fa fa-clock-o my-icon-loction   margin-left-5 margin-right-5"></i>
                      {{ city[`Departure_City${getLang().charAt(0).toUpperCase() + getLang().slice(1)}`] }}
                      ({{ city[`Departure_Code`] }})
                    </li>
                    <span>{{ useXmltag('PopularRoutes') }}</span>
                    <li v-for="city in $store.state.popular_internal_flights" @click.stop="selectAirportArrival(city,getLang())">
                      <i class="fa fa-map-marker my-icon-loction   margin-left-5 margin-right-5"></i>
                      {{ city[`Departure_City${getLang().charAt(0).toUpperCase() + getLang().slice(1)}`] }}
                      ({{ city[`Departure_Code`] }})
                    </li>
                  </ul>
                </div>
                <div v-else>
                  <ul class="resultFlight_international search-box-resultFlight" v-show="is_arrival_search">
                    <li v-for="city in cities_arrival" @click.stop="selectAirportArrival(city,getLang())">
                      <i class=" fa fa-map-marker my-icon-loction   margin-left-5 margin-right-5"></i>
                      {{ city[`Departure_City${getLang().charAt(0).toUpperCase() + getLang().slice(1)}`] }}
                      ({{ city[`Departure_Code`] }})
                    </li>
                  </ul>
                </div>

              </div>
            </div>
          </div>


          <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100 ">
            <div class="s-u-form-date-wrapper">
              <div class="s-u-date-pick">
                <div class="s-u-jalali s-u-jalali-change calender-overflow-inherit">
                  <i class="zmdi zmdi-calendar-note site-main-text-color"></i>
                  <template>
                    <date-picker v-model="date_departure" :inputFormat="format_datepicker"
                                 :auto-submit="true" :locale="lang_datepicker"
                                 :from="dateNow('-')"  mode="single"
                                 :column="column"
                                 name="dept_date"
                                 id="dept_date_local" :styles="styles"
                    >
                      <template #icon></template>
                    </date-picker>
                  </template>
                </div>
              </div>
            </div>
          </div>


          <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100"
               :class="(multi_way) ? 'showHidden' :'hidden'">
            <div class="s-u-form-date-wrapper">
              <div class="s-u-date-pick">
                <div class="s-u-jalali s-u-jalali-change calender-overflow-inherit">
                  <i class="zmdi zmdi-calendar-note site-main-text-color"></i>
                  <template>
                    <date-picker-return v-model="date_return" :inputFormat="format_datepicker"
                                 :auto-submit="true"
                                 :column="column"
                                 mode="single" :locale="lang_datepicker"
                                 :placeholder="`${useXmltag('Returndate')}`" name="dept_date_return"
                                 id="dept_date_local_return"  :styles="styles"
                    >
                      <template #icon></template>
                    </date-picker-return>
                  </template>
                </div>
              </div>
            </div>
          </div>
          <div class="number_passengers">
            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100">
              <div class="s-u-form-input-wrapper">
                <p class="s-u-number-input  s-u-number-input-change  inp-adt inp-adt-change">
                  <i class="plus zmdi zmdi-plus-circle site-main-text-color-h "
                     id="add1"></i>
                  <span>
                                                                              <input class="site-main-text-color-drck"
                                                                                     id="qty1" type="text"
                                                                                     v-model="data_search.adult"
                                                                                     name="adult" min="0" max="9">

                                                                                   {{ useXmltag('Adult') }}
                                                                           </span>
                  <input type="hidden" name="adult_qty" id="adult_qty" v-model="data_search.adult">
                  <i class="minus zmdi zmdi-minus-circle site-main-text-color-h "
                     id="minus1"></i>
                </p>
              </div>
            </div>
            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100">
              <div class="s-u-form-input-wrapper">
                <p class="s-u-number-input  s-u-number-input-change  inp-child inp-child-change">
                  <i class="plus zmdi zmdi-plus-circle site-main-text-color-h "
                     id="add2"></i>
                  <span>
                                                                          <input class="site-main-text-color-drck"
                                                                                 id="qty2" type="text"
                                                                                 v-model="data_search.child"
                                                                                 name="child" min="0" max="9">
                                                                               {{ useXmltag('Child') }}
                                                                           </span>
                  <input type="hidden" name="child_qty" id="child_qty" v-model="data_search.child">
                  <i class="minus zmdi zmdi-minus-circle site-main-text-color-h "
                     id="minus2"></i>
                </p>
              </div>
            </div>
            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100">
              <div class="s-u-form-input-wrapper">
                <p class="s-u-number-input  s-u-number-input-change  inp-baby inp-baby-change">
                  <i class="plus zmdi zmdi-plus-circle site-main-text-color-h "
                     id="add3"></i>
                  <span>
                                                                               <input class="site-main-text-color-drck"
                                                                                      id="qty3" type="text"
                                                                                      v-model="data_search.infant"
                                                                                      name="infant" min="0" max="9">
                                                                               {{ useXmltag('Baby') }}
                                                                           </span>
                  <input type="hidden" name="infant_qty" id="infant_qty" v-model="data_search.infant">
                  <i class="minus zmdi zmdi-minus-circle site-main-text-color-h "
                     id="minus3"></i>
                </p>
              </div>
            </div>


          </div>


          <div class="s-u-search-wrapper s-u-num-inp s-u-num-inp-search-change">
            <a href="" @click="event.preventDefault()" class="f-loader-check f-loader-check-bar"
               id="loader_check_submit" style="display:none"></a>

            <button type="button" @click="submitLocalSide('local-flight')" id="sendFlight"

                    class="site-bg-main-color"> {{ useXmltag('Search') }}
            </button>
          </div>
        </form>
        <div class="message_error_portal"></div>
      </div>
      <div class="s-u-filter-wrapper s-u-filter-wrapper-fo">
        <ul id="s-u-filter-wrapper-ul">
          <span class="s-u-close-filter"></span>

          <!-- pricefilter -->
          <li class="s-u-filter-item" data-group="flight-price">
                           <span class="s-u-filter-title">
                           <i class="zmdi zmdi-money site-main-text-color-drck"></i>  {{ useXmltag('Price') }}</span>
            <div class="s-u-filter-content slider_range_parent ">
              <vue-slider v-model="value_price" :tooltip="'always'" :min="min_price_props" :max="max_price_props"
                          @change="priceRangeSlider(value_price)">
                <template v-slot:tooltip="{value}">
                  <div
                    class="vue-slider-dot-tooltip-inner vue-slider-dot-tooltip-inner-top site-bg-main-color  site-border-main-color">
                    {{ value| formatNumber }}
                  </div>
                </template>

                <template v-slot:process="{ start, end, style, index }">
                  <div class="vue-slider-process vue-slider-dot-tooltip-inner site-bg-main-color" :style="[style]">
                    <!-- Can add custom elements here -->
                  </div>
                </template>
              </vue-slider>

            </div>
          </li>
          <!-- flight type filter -->
          <li class="s-u-filter-item" data-group="flight-type">

                        <span class="s-u-filter-title"><i
                          class="zmdi zmdi-flight-takeoff site-main-text-color-drck"></i> {{ useXmltag('Typeflight') }} </span>

            <div class="s-u-filter-content">

              <ul class="s-u-filter-item-time filter-type-ul filter-type-ul-f">

                <li>
                  <label for="filter-type">
                    <span>{{ useXmltag('All') }}</span>
                  </label>
                  <span :data-inactive="useXmltag('Inactive')" :data-active="useXmltag('Active')"
                        class="tzCBPart site-bg-filter-color checked filter-to-check type_flight all_type_flight"
                        @click="typeFilterFlight('all_type_flight')"></span>
                  <input class="check-switch" type="checkbox" id="filter-type" value="allFlightType"
                         checked="checked" />

                </li>

                <li v-for="filter_flight in typeFlightFilter">
                  <label :for="`filter-${filter_flight.name_en}`">
                    <span>{{filter_flight.name_fa }}</span>
                  </label>
                  <span :data-inactive="useXmltag('Inactive')" :data-active="useXmltag('Active')"
                        class="tzCBPart site-bg-filter-color type_flight"
                        @click="typeFilterFlight(filter_flight.name_en)"
                        :class="`${filter_flight.name_en}`"></span>
                  <input class="check-switch" type="checkbox" :id="`filter-${filter_flight.name_en}`"
                         :value="`${filter_flight.name_en}`" />
                </li>
              </ul>
            </div>
          </li>
          <!-- seat class filter -->
          <li class="s-u-filter-item" data-group="flight-seat">

                       <span class="s-u-filter-title"><i class="zmdi zmdi-airline-seat-recline-extra"></i>
                          {{ useXmltag('Classflight') }}
                       </span>

            <div class="s-u-filter-content">

              <ul class="s-u-filter-item-time filter-seat-ul filter-seat-ul-f">

                <li>
                  <label for="filter-seat">
                    <span>{{ useXmltag('All') }}</span>
                  </label>
                  <span :data-inactive="useXmltag('Inactive')" :data-active="useXmltag('Active')"
                        class="tzCBPart site-bg-filter-color checked filter-to-check all_seat_class"
                        @click="seatClassFilterFlight('all_seat_class')"></span>
                  <input class="check-switch" type="checkbox" id="filter-seat" value="allSeatClass"
                         checked="checked" />
                </li>

                <li v-for="seat_class in seatClassFilter">
                  <label :for="`filter-${seat_class.name_en}`">
                    <span>{{ seat_class.name_fa }}</span>
                  </label>
                  <span :data-inactive="useXmltag('Inactive')" :data-active="useXmltag('Active')"
                        class="tzCBPart site-bg-filter-color seat_class"
                        @click="seatClassFilterFlight(seat_class.name_en)"
                        :class="`${seat_class.name_en}`"></span>
                  <input class="check-switch" type="checkbox" :id="`filter-${seat_class.name_en}`"
                         :value="`${seat_class.name_en}`" />
                </li>
              </ul>
            </div>
          </li>
          <li class="s-u-filter-item" data-group="flight-airline">
            <span class="s-u-filter-title"><i class="zmdi zmdi-local-airport site-main-text-color-drck"></i> {{ useXmltag('Airline') }}</span>
            <div class="s-u-filter-content">
              <ul class="s-u-filter-item-time filter-airline-ul filter-airline-ul-f">
                <li>
                  <label for="filter-airline">
                    <span>{{ useXmltag('All') }}</span>
                  </label>
                  <span :data-inactive="useXmltag('Inactive')" :data-active="useXmltag('Active')"
                        class="tzCBPart site-bg-filter-color checked filter-to-check  all_airline"
                        @click="airlineFilterFlight('all_airline')"></span>
                  <input class="check-switch" type="checkbox" id="filter-airline" value="allAirline"
                         checked="checked" />

                </li>

                <template v-for="data_each_airline in minPriceAirline">
                  <li :id="`${data_each_airline.name_en}-filter`">
                    <label :for="`filter-${data_each_airline.name_en}`">
                      <i :id="`${data_each_airline.name_en}-minPrice`">{{data_each_airline.price}}</i>
                      <span>{{ data_each_airline.name}}</span>
                    </label>
                    <span :data-inactive="useXmltag('Inactive')" :data-active="useXmltag('Active')"
                          class="tzCBPart site-bg-filter-color airline"
                          @click="airlineFilterFlight(data_each_airline.name_en)"
                          :class="`${data_each_airline.name_en}`"></span>
                    <input class="check-switch" type="checkbox"
                           :id="`filter-${data_each_airline.name_en}`"
                           v-model="data_each_airline.name_en" />
                  </li>
                </template>
              </ul>
            </div>
          </li>

          <!-- time filter -->
          <li class="s-u-filter-item" data-group="flight-time">
            <span class="s-u-filter-title "><i class="zmdi zmdi-time site-main-text-color-drck"></i>{{ useXmltag('RunTime') }} </span>
            <div class="s-u-filter-content">
              <ul class="s-u-filter-item-time filter-time-ul filter-time-ul-f">
                <li>
                  <label for="filter-time">
                    <span>{{ useXmltag('All') }}</span>
                  </label>
                  <span :data-inactive="useXmltag('Inactive')" :data-active="useXmltag('Active')"
                        class="tzCBPart site-bg-filter-color checked filter-to-check all_time"
                        id="allTime"
                        v-on:click="timeFilterFlightForeign('all_time')"></span>
                  <input class="check-switch" type="checkbox" id="filter-time" value="allTime"
                         checked="checked" />

                </li>
                <template v-for="each_time in timeFilter">
                  <li>
                    <label :for="`filter-${each_time.name_en}`">
                      <i>{{each_time.value}}</i>
                      <span>{{each_time.name_fa}}</span>
                    </label>
                    <span :data-inactive="useXmltag('Inactive')" :data-active="useXmltag('Active')"
                          class="tzCBPart site-bg-filter-color time"
                          @click="timeFilterFlightForeign(each_time.time)"
                          :class="`${each_time.time}`"></span>
                    <input class="check-switch" type="checkbox" :id="`filter-${each_time.time}`"
                           v-model="each_time.time" />
                  </li>
                </template>
              </ul>
            </div>
          </li>

          <div class="articles-list d-none">
            <h6>{{ useXmltag('RelatedArticles') }}</h6>
            <ul></ul>
          </div>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
  import VueSlider from 'vue-slider-component'
  import 'vue-slider-component/theme/default.css'
  import vSelect from 'vue-select'
  import 'vue-select/dist/vue-select.css'
  import datePicker from '@alireza-ab/vue-persian-datepicker'
  // import select2Jq from './select2-jq'


  export default {
    name: 'sidebar',
    props: ['dataSearch', 'price', 'timeFilter', 'typeFlightFilter', 'seatClassFilter', 'minPriceAirline', 'countFlights'],
    data() {
      return {
        search_origin_loading : false ,
        search_arrival_loading : false ,
        departure_code: '',
        is_show_currency_list: false,
        show_popular : false,
        show_arrival_popular : false,
        currency_title: '',
        value_price: [0, 0],
        title_origin_city: '',
        title_arrival_city: '',
        title_origin_city_search : '',
        title_arrival_city_search : '',
        iata_origin: '',
        iata_arrival: '',
        stored_origin_cities : [] ,
        stored_arrival_cities : [] ,
        cities_origin: [],
        popular_cities_origin : [],
        cities_arrival: [],
        min_price_props: 0,
        max_price_props: 0,
        data_search: [],
        currency_info: '',
        error_currency_info: '',
        list_currency: [],
        today_date: true,
        date_picker_departure: '',
        date_picker_return: '',
        multi_way: '',
        multi_way_check: false,
        is_search: false,
        is_arrival_search: false,
        format_datepicker: 'jYYYY-jMM-jDD',
        lang_datepicker: 'fa',
        svg_icon_1: `<svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:svgjs='http://svgjs.com/svgjs' version='1.1' x='0' y='0' viewBox='0 0 907.62 907.619' style='enable-background:new 0 0 512 512' xml:space='preserve' class=''><g><g xmlns='http://www.w3.org/2000/svg'><path d='M591.672,907.618c28.995,0,52.5-23.505,52.5-52.5V179.839l42.191,41.688c10.232,10.11,23.567,15.155,36.898,15.155   c13.541,0,27.078-5.207,37.347-15.601c20.379-20.625,20.18-53.865-0.445-74.244L626.892,15.155C617.062,5.442,603.803,0,589.993,0   c-0.104,0-0.211,0-0.314,0.001c-13.923,0.084-27.244,5.694-37.03,15.6l-129.913,131.48c-20.379,20.625-20.18,53.865,0.445,74.244   c20.626,20.381,53.866,20.181,74.245-0.445l41.747-42.25v676.489C539.172,884.113,562.677,907.618,591.672,907.618z'></path><path d='M315.948,0c-28.995,0-52.5,23.505-52.5,52.5v676.489l-41.747-42.25c-20.379-20.625-53.62-20.825-74.245-0.445   c-20.625,20.379-20.825,53.619-0.445,74.244l129.912,131.479c9.787,9.905,23.106,15.518,37.029,15.601   c0.105,0.001,0.21,0.001,0.315,0.001c13.81,0,27.07-5.442,36.899-15.155L484.44,760.78c20.625-20.379,20.824-53.619,0.445-74.244   c-20.379-20.626-53.62-20.825-74.245-0.445l-42.192,41.688V52.5C368.448,23.505,344.943,0,315.948,0z' style=''></path></g></g></svg>`,
        svg_icon_2: `<svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' version='1.1' x='0' y='0' viewBox='0 0 512 512' style='enable-background:new 0 0 512 512' xml:space='preserve' class=''><g transform='matrix(-1,-1.2246467991473532e-16,1.2246467991473532e-16,-1,512,512)'><g xmlns='http://www.w3.org/2000/svg'><g><path d='M374.108,373.328c-7.829-7.792-20.492-7.762-28.284,0.067L276,443.557V20c0-11.046-8.954-20-20-20    c-11.046,0-20,8.954-20,20v423.558l-69.824-70.164c-7.792-7.829-20.455-7.859-28.284-0.067c-7.83,7.793-7.859,20.456-0.068,28.285    l104,104.504c0.006,0.007,0.013,0.012,0.019,0.018c7.792,7.809,20.496,7.834,28.314,0.001c0.006-0.007,0.013-0.012,0.019-0.018    l104-104.504C381.966,393.785,381.939,381.121,374.108,373.328z' style='' class=''></path></g></g></g></svg>`,
        styles: {
          'primary-color': main_color,
        },
        date_departure:'',
        date_return:'',
        column: {
          576: 1,  // under 576px, column count is 1
          992: 2,  // under 992px, column count is 2
        }
      }
    },
    methods: {
      dropBox(type){
        if(type == 'origin'){
          this.is_search = !this.is_search ;
          this.is_arrival_search = false
        }else if(type == 'arrival'){
          this.is_arrival_search = !this.is_arrival_search ;
          this.is_search = false
        }

      },
      clearSearchedCities(type) {
        console.log(type)
        if(type == 'origin') {
            this.stored_arrival_cities = []
        }else {
          this.stored_origin_cities = []
        }
        let getSearchedCities = JSON.parse(localStorage.getItem('internalSearchedCities'))
        console.log(getSearchedCities)
        localStorage.setItem('internalSearchedCities' , JSON.stringify({[type] : getSearchedCities[type]}));
      },
      setSearchedStorage() {
        let storage_searched_cities =  localStorage.getItem('internalSearchedCities')

        if(storage_searched_cities == null || storage_searched_cities == "null" || Object.keys(JSON.parse(storage_searched_cities)).length == 0 ) {
          let storage_origin_cities = []
          let storage_arrival_cities = []
          storage_origin_cities.push({
            Departure_Code : this.iata_origin  ,
            [`Departure_City${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`] : this.data_search.name_departure
          })
          storage_arrival_cities.push({
            Departure_Code : this.iata_arrival  ,
            [`Departure_City${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`] : this.data_search.name_arrival
          })

          this.stored_origin_cities = storage_origin_cities
          this.stored_arrival_cities = storage_arrival_cities

          localStorage.setItem("internalSearchedCities", JSON.stringify( { origin :  storage_origin_cities , arrival :storage_arrival_cities } ));
        }
        else {
          let storage_searched_cities =  JSON.parse(localStorage.getItem('internalSearchedCities'))
          let storage_origin_cities = []
          let storage_arrival_cities = []
          if(!storage_searched_cities['origin']){
            storage_origin_cities.push({
              Departure_Code : this.iata_origin  ,
              [`Departure_City${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`] : this.data_search.name_departure
            })
            this.stored_origin_cities = storage_origin_cities
          }else {
            this.stored_origin_cities = storage_searched_cities.origin
            if(storage_searched_cities.origin && storage_searched_cities.origin.length > 0 ) {
              let has_stored = storage_searched_cities.origin.find(city => {
                return city.Departure_Code == this.iata_origin
              })
              if (!has_stored) {
                if (storage_searched_cities.origin.length == 5) {
                  storage_searched_cities.origin.shift()
                }
                storage_searched_cities.origin.push({
                  Departure_Code: this.iata_origin,
                  [`Departure_City${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`]: this.data_search.name_departure
                })
              }
            }
            storage_origin_cities = storage_searched_cities.origin
          }

          if(!storage_searched_cities['arrival']) {
            storage_arrival_cities.push({
              Departure_Code : this.iata_arrival  ,
              [`Departure_City${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`] : this.data_search.name_arrival
            })
            this.stored_arrival_cities = storage_arrival_cities
          }
          else {
            this.stored_arrival_cities = storage_searched_cities.arrival
            if(storage_searched_cities.arrival && storage_searched_cities.arrival.length > 0){
              let has_stored = storage_searched_cities.arrival.find(city => {
                return city.Departure_Code == this.iata_arrival
              })
              if (!has_stored) {
                if (storage_searched_cities.arrival.length == 5) {
                  storage_searched_cities.arrival.shift()
                }
                storage_searched_cities.arrival.push({
                  Departure_Code: this.iata_arrival,
                  [`Departure_City${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`]: this.data_search.name_arrival
                })
              }
            }
            storage_arrival_cities = storage_searched_cities.arrival
          }
          localStorage.setItem("internalSearchedCities", JSON.stringify({ origin : storage_origin_cities , arrival :storage_arrival_cities}));
        }
      },
      showListCurrencyExist() {
        this.is_show_currency_list = !this.is_show_currency_list

        if (document.querySelector('.show-currency').classList.contains('d-block')) {
          document.getElementsByClassName('show-currency')[0].classList.remove('d-block')

        } else {
          document.getElementsByClassName('show-currency')[0].classList.add('d-block')
        }
      },
      ConvertCurrency(code, Icon, Title) {
        let _this = this
        document.getElementById('IconDefaultCurrency').setAttribute('src', rootMainPath + '/gds/pic/flagCurrency/' + Icon)
        _this.currency_title = Title
        axios.post(amadeusPath + 'ajax', {
          className: 'currencyEquivalent',
          method: 'CurrencyEquivalent',
          code: code,
          is_json: true,
        }, {
          'Content-Type': 'application/json',
        }).then(function(response) {

          _this.is_show_currency_list = false
          _this.$store.commit('setPriceCurrency', response.data)
        }).catch(function(error) {
          console.log(error)
        })

      },
      searchCityBackup: function(lang) {
        let _this = this
        axios.post(amadeusPath + 'ajax', {
          className: 'newApiFlight',
          method: 'getCitiesFlightInternal',
          iata_city: value_city,
          language: lang,
        }, {
          'Content-Type': 'application/json',
        }).then(function(response) {

          console.log(response)
          // _this.cities_origin = response.data.data

          let cities = response.data.data;
          let obj_cities;

          Object.keys(cities).forEach(key => {
            obj_cities = {}
            obj_cities.id = cities[key].Departure_Code;
            obj_cities.text = `${cities[key].Departure_City}(${cities[key].Departure_Code})`;
            _this.cities_origin.push(obj_cities);

          });
          console.log('bf object push==>' + JSON.stringify(_this.cities_origin))

          _this.searchCityArrival({
            target: {
              value: _this.iata_origin,
              lang: _this.data_search.software_lang,
            },
          })

          _this.iata_arrival = _this.data_search.destination
        }).catch(function(error) {
          console.log(error)
        })
      },
      focusSearchCity(){
        let _this = this
        _this.show_popular = true
      },
      focusSearchArrivalCity(){
        let _this = this
        _this.show_arrival_popular = true
      },
      searchCity: function(lang) {
        let _this = this

        _this.show_popular = false
        _this.is_search = true
        if(_this.title_origin_city_search != '') {
          _this.search_origin_loading = true
            axios.post(amadeusPath + 'ajax', {
              className: 'newApiFlight',
              method: 'searchCitiesFlightInternal',
              value: _this.title_origin_city_search,
            }, {
              'Content-Type': 'application/json',
            }).then(function(response) {
              _this.cities_origin = response.data.data
              _this.search_origin_loading = false
            }).catch(function(error) {
              _this.search_origin_loading = false
              console.log(error)
            })
        }else {
          _this.cities_origin = []
        }

      },
      selectAirportOrigin(city, lang) {
        lang = (lang !== 'fa') ? 'en' : 'fa'
        this.dataSearch.name_departure = city[`Departure_City${lang.charAt(0).toUpperCase() + lang.slice(1)}`]
        this.dataSearch.origin = city.Departure_Code
        this.cities_origin = []
        this.is_search = false
        this.iata_origin = city.Departure_Code
        this.title_origin_city_search = city[`Departure_City${lang.charAt(0).toUpperCase() + lang.slice(1)}`]
        if( this.iata_origin == this.iata_arrival) {
          this.$refs.arrival.focus();
          this.is_arrival_search = true
          this.iata_arrival = ''
          this.dataSearch.name_arrival = ''
          this.dataSearch.destination =  ''
          this.title_arrival_city_search = ''
        }
      },
      selectAirportArrival(city, lang) {
        lang = (lang !== 'fa') ? 'en' : 'fa'
        this.dataSearch.name_arrival = city[`Departure_City${lang.charAt(0).toUpperCase() + lang.slice(1)}`]
        this.dataSearch.destination =  city.Departure_Code
        this.cities_arrival = []
        this.is_arrival_search = false
        this.iata_arrival = city.Departure_Code
        this.title_arrival_city_search = city[`Departure_City${lang.charAt(0).toUpperCase() + lang.slice(1)}`]
        if( this.iata_origin == this.iata_arrival) {
          this.$refs.origin.focus();
          this.is_search = true
          this.iata_origin = ''
          this.dataSearch.name_departure = ''
          this.dataSearch.origin = ''
          this.title_origin_city_search =''
        }
      },
      searchCityArrivalBackup: function(event) {

        let value_city = event.target.value
        let _this = this
        this.iata_arrival = 0
        let lang = (event.target.lang !== 'fa') ? 'en' : 'fa'
        axios.post(amadeusPath + 'ajax', {
          className: 'newApiFlight',
          method: 'getCitiesFlightInternal',
          iata_city: value_city,
        }, {
          'Content-Type': 'application/json',
        }).then(function(response) {
          _this.cities_arrival = response.data.data
        }).catch(function(error) {
          console.log(error)
        })

      },
      searchCityArrival: function(event) {

        let value_city = event.target.value
        let _this = this
        _this.show_arrival_popular = false
        _this.is_arrival_search = true
        let lang = (event.target.lang !== 'fa') ? 'en' : 'fa'
        if(_this.title_arrival_city_search != '') {
          _this.search_arrival_loading = true
          axios.post(amadeusPath + 'ajax', {
            className: 'newApiFlight',
            method: 'searchCitiesFlightInternal',
            value: _this.title_arrival_city_search,
          }, {
            'Content-Type': 'application/json',
          }).then(function(response) {
            _this.search_arrival_loading = false
            _this.cities_arrival = response.data.data
          }).catch(function(error) {
            _this.search_arrival_loading = false
            console.log(error)
          })
        }else {
          _this.cities_arrival = []
        }

      },
      getCurrencyInfo() {
        let _this = this
        axios.post(amadeusPath + 'ajax',
          {
            className: 'newApiFlight',
            method: 'infoCurrency',
            is_json: true,
          },
          {
            'Content-Type': 'application/json',
          }).then(function(response) {
          _this.currency_info = response.data.data
          if (_this.dataSearch.dataSearch.software_lang !== 'fa') {
            _this.currency_title = _this.currency_info.CurrencyTitleEn
          } else {
            _this.currency_title = _this.currency_info.CurrencyTitleFa
          }

        }).catch(function(error) {
          _this.error_currency_info = error.message
        })

      },
      listCurrency() {
        let _this = this
        axios.post(amadeusPath + 'ajax',
          {
            className: 'newApiFlight',
            method: 'listCurrency',
            is_json: true,
          },
          {
            'Content-Type': 'application/json',
          }).then(function(response) {
          _this.list_currency = response.data.data
        }).catch(function(error) {
          _this.list_currency = null
        })
      },
      async checkToDayDate() {
        let _this = this
        await axios.post(amadeusPath + 'ajax',
          {
            className: 'newApiFlight',
            method: 'checkToDayDate',
            dateSearch: _this.dataSearch.dataSearch.departureDate,
          },
          {
            'Content-Type': 'application/json',
          }).then(function(response) {
          console.log(_this.dataSearch.MultiWay);
          _this.today_date = response.data.data
          _this.multi_way = (_this.dataSearch.MultiWay == 'TwoWay') ? true : false

        }).catch(function(error) {
          _this.today_date = error.message
        })
      },
      timeFilterFlightForeign(value) {
        this.$emit('filterFlights', value, 'time')
      },
      typeFilterFlight(value) {
        this.$emit('filterFlights', value, 'type_flight')
      },
      airlineFilterFlight(value) {
        this.$emit('filterFlights', value, 'airline')
      },
      seatClassFilterFlight(value) {
        this.$emit('filterFlights', value, 'seat_class')
      },
      priceRangeSlider(value) {
        this.$emit('filterPriceFlights', value, 'price_sidebar')
      },
      reversDestinations() {

        let title_origin = this.title_origin_city_search
        let iata_origin = this.iata_origin
        let title_arrival = this.title_arrival_city_search
        let iata_arrival = this.iata_arrival
        this.title_origin_city_search = title_arrival
        this.iata_origin = iata_arrival

        this.title_arrival_city_search = title_origin
        this.iata_arrival = iata_origin
      },
      getPopularFlightList() {
        let _this = this
        this.$store.dispatch('getPopularInternalFlight', {method: 'searchCitiesFlightInternal'})
      }
    },
    created: function() {
      this.enableCross = false;
      let self = this;
      window.addEventListener('click', function(e){
        // close dropdown when clicked outside
        if (!self.$el.contains(e.target)){
          self.is_search = false
          self.is_arrival_search = false
        }
      })
    },
    watch: {
      'dataSearch': {
        handler: function(after, before) {
          if (after) {
            let _this = this
            console.log(this.dataSearch)
              if (this.dataSearch) {
                this.data_search = this.dataSearch.dataSearch

                this.title_origin_city_search = this.data_search.name_departure
                this.title_arrival_city_search = this.data_search.name_arrival

                this.iata_origin = this.data_search.origin
                this.iata_arrival = this.data_search.destination
                this.date_departure = this.data_search.departure_date_en
                this.date_return = this.data_search.arrival_date_en

                this.setSearchedStorage()

                this.checkToDayDate()
                this.getCurrencyInfo()
                this.listCurrency()
                this.getPopularFlightList()
                // this.searchCity(this.dataSearch.dataSearch.software_lang)

                if (this.dataSearch.dataSearch.software_lang != 'fa') {
                  this.format_datepicker = 'YYYY-MM-DD'
                  this.lang_datepicker = 'en'
                }
              }
            }
        },
        deep: true,
        immediate: true,
      },
      price() {
        if (this.price) {
          this.min_price_props = this.price.min_price
          this.max_price_props = this.price.max_price
          this.value_price = [this.price.min_price, this.price.max_price]
        }
      },
    },
    components: {
      'VueSlider': VueSlider,
      'v-select': vSelect,
      'date-picker': datePicker,
      'date-picker-return': datePicker

    },
    mounted() {
      if (this.price) {
        this.min_price_props = this.price.min_price
        this.max_price_props = this.price.max_price
        this.value_price = [this.price.min_price, this.price.max_price]

      }

    },
    computed:{
  /*    date_departure(){

          let data_store = JSON.parse(JSON.stringify(this.dataSearch.dataSearch));
          console.log(data_store.departure_date_en);
          return data_store.departure_date_en;

      },
      date_return(){

        let data_store_return = JSON.parse(JSON.stringify(this.dataSearch.dataSearch));
        console.log(data_store_return.arrival_date_en);
        return data_store_return.arrival_date_en;

      },*/

    }

  }
</script>
<style>



</style>