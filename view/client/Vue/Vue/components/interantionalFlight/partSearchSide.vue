<template>
  <div v-show='shouldShowSearchBox'>
    <template v-if="isMultiSearch">
    <div class="py-2">
      <div class="card">
        <div class="card-header multi_accordion_link p-0" :id="`heading_${index_key}`">
          <a href="javascript:"
             class="collapsed p-0 m-0 w-100 d-flex align-items-center justify-content-between flex-wrap"
             data-toggle="collapse" :data-target="`#collapse_${index_key}`" aria-expanded="false"
             :aria-controls="`collapse_${index_key}`">
            <div v-if='count_search_part > 1 && is_multi_destination'>
              <button id="create_search_box"
                      class="fa fa-trash-o"
                      @click="delete_path(`${index_key}`)"></button>
            </div>
            <h5 class='ml-auto mr-2 mb-0 d-flex align-items-end font-weight-normal'>
              {{ count_path }}
              <p class='m-0 mr-2 font_size_12_p d-flex align-items-center'>
                (
                {{iata_arrival}}
                <i class="flash_multi">
                  <span class='mx-2'>→</span>
                </i>
                <!--                  {{useXmltag('On')}}-->
                {{iata_origin}}
                )
              </p>
            </h5>
            <span class="my-auto">
                <i class="fa fa-angle-up"></i>
              </span>
          </a>
        </div>
        <div :id="`collapse_${index_key}`" class="collapse" :aria-labelledby="`heading_${index_key}`"
             data-parent="#accordion">
          <div class="card-body p-2">
            <div class="d-flex flex-wrap align-items-center position-relative">
              <div class="inputSearchForeign-box inputSearchForeign-pad ">
                <div class="s-u-in-out-wrapper raft raft-change change-bor">
                  <input id="origin_city_portal" class="inputSearchForeign" type="text"
                         :lang="`${lang}`"
                         v-model="title_origin_city"
                         name="origin" @keyup="searchCity" @focus="focusSearchCity">
                  <img :src="`${getUrlWithoutLang()}view/client/assets/images/load.gif`" id="LoaderForeignDep" name="LoaderForeignDep"
                       class="loaderSearch" v-if='search_origin_loading'>
                  <input :id="`origin_foreign${index_key}`" class="" type="hidden" v-model="iata_origin"
                         name="origin_foreign">
                  <ul id="ListAirPort" class="resultFlight_international" v-show="is_search">
                    <li v-for="city in cities_origin" @click="selectAirportOrigin(city,lang)">
                      <i
                        class="fa fa-map-marker my-icon-loction  margin-left-5 margin-right-5"></i>
                      {{ city[`Airport${lang.charAt(0).toUpperCase() + lang.slice(1)}`]}}
                    </li>
                  </ul>
                </div>
              </div>
              <div class="swap-flight-box foreignSwapBtn search-box-swap-flight-box-foreign" @click="reversDestinations()">
                <span class="swap-flight-search-box-new"><i class="zmdi zmdi-swap site-main-text-color"></i></span>
              </div>
              <div class="inputSearchForeign-box bargasht bargasht-change change-bor">
                <div class="s-u-in-out-wrapper ">

                  <input id="`destination_city_origin`" class="inputSearchForeign" type="text"
                         v-model="title_arrival_city"
                         name="origin"
                         :lang="`${dataSearch.software_lang}`" @keyup="searchCityArrival" @focus="focusSearchCity">
                  <img :src="`${getUrlWithoutLang()}view/client/assets/images/load.gif`" id="LoaderForeignReturn" name="LoaderForeignReturn"
                       class="loaderSearch" v-if='search_arrival_loading'>
                  <input :id="`destination_foreign${index_key}`" class="" type="hidden" v-model="iata_arrival"
                         name="destination_foreign">
                  <ul id="ListAirPortRetrun" class="resultFlight_international" v-show="is_arrival_search">
                    <li v-for="city in cities_arrival" @click="selectAirportArrival(city,lang)">
                      <i
                        class="fa fa-map-marker my-icon-loction  margin-left-5 margin-right-5"></i>
                      {{ city[`Airport${lang.charAt(0).toUpperCase() + lang.slice(1)}`]}}
                    </li>
                  </ul>
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
                                 :from="dateNow('-')" mode="single"
                                 :column="1"
                                 name="dept_date"
                                 :id="`dept_date_foreign${index_key}`" :styles="styles"
                                 :position="'bottom'"
                                 :auto-position="false"
                                 :placeholder="`${useXmltag('Wentdate')}`"
                      >
                        <template #icon></template>
                      </date-picker>
                    </template>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </template>
    <template v-else>
      <div class="d-flex flex-wrap align-items-center position-relative pt-2">
        <div class="inputSearchForeign-box inputSearchForeign-pad ">
          <div class="s-u-in-out-wrapper raft raft-change change-bor">
            <input id="origin_city_portal" class="inputSearchForeign search-box-selectOneFlightVue" type="text"
                   :lang="`${lang}`"
                   v-model="title_origin_city"
                   name="origin" @keyup="searchCity" @focus="focusSearchCity" @click.stop="dropBox('origin')">
             <span
                v-if="title_origin_city"
                class="clear-input"
                @click.stop="clearPortalOriginInput"
                title="Clear"
                >
                ×
              </span>
            <img :src="`${getUrlWithoutLang()}view/client/assets/images/load.gif`" id="LoaderForeignDep" name="LoaderForeignDep"
                 class="loaderSearch" v-if='search_origin_loading'>
            <input :id="`origin_foreign${index_key}`" class="" type="hidden" v-model="iata_origin"
                   name="origin_foreign">
            <div v-if="(cities_origin.length == 0 & title_origin_city == '') || show_popular">

              <ul id="ListAirPort" class="resultFlight_international search-box-resultFlight" v-show="is_search">
                <div class='parent-titr' v-if="stored_origin_cities.length > 0 ">
                  <span>{{ useXmltag('History') }}</span>
                  <span class='delete-pointer' @click.stop="clearSearchedCities('arrival')">{{ useXmltag('Clear') }}</span>
                </div>
                <li v-for="city in stored_origin_cities" @click.stop="selectAirportOrigin(city,lang)">
                  <i class="fa fa fa-clock-o my-icon-loction  margin-left-5 margin-right-5"></i>
                  {{ city[`Airport${lang.charAt(0).toUpperCase() + lang.slice(1)}`]}} -
                  {{ city[`Country${lang.charAt(0).toUpperCase() + lang.slice(1)}`]}} -
                  {{ city[`DepartureCity${lang.charAt(0).toUpperCase() + lang.slice(1)}`]}} -
                  {{ city.DepartureCode}}
                </li>
                <span>{{ useXmltag('PopularRoutes') }}</span>
                <li v-for="city in $store.state.popular_international_flights"
                    @click.stop="selectAirportOrigin(city,lang)">
                  <i class="fa fa-map-marker my-icon-loction  margin-left-5 margin-right-5"></i>
                  {{ city[`Airport${lang.charAt(0).toUpperCase() + lang.slice(1)}`]}} -
                  {{ city[`Country${lang.charAt(0).toUpperCase() + lang.slice(1)}`]}} -
                  {{ city[`DepartureCity${lang.charAt(0).toUpperCase() + lang.slice(1)}`]}} -
                  {{ city.DepartureCode}}
                </li>
              </ul>
            </div>
            <div v-else>
              <ul id="ListAirPort" class="resultFlight_international" v-show="is_search">
                <li v-for="city in cities_origin" @click="selectAirportOrigin(city,lang)">
                  <i class="fa fa-map-marker my-icon-loction  margin-left-5 margin-right-5"></i>
                  {{ city[`Airport${lang.charAt(0).toUpperCase() + lang.slice(1)}`]}} -
                  {{ city[`Country${lang.charAt(0).toUpperCase() + lang.slice(1)}`]}} -
                  {{ city[`DepartureCity${lang.charAt(0).toUpperCase() + lang.slice(1)}`]}} -
                  {{ city.DepartureCode}}
                </li>
              </ul>
            </div>

          </div>
        </div>
        <div class="swap-flight-box foreignSwapBtn search-box-swap-flight-box-foreign" @click="reversDestinations()">
          <span class="swap-flight-search-box-new"><i class="zmdi zmdi-swap site-main-text-color"></i></span>
        </div>
        <div class="inputSearchForeign-box bargasht bargasht-change change-bor">
          <div class="s-u-in-out-wrapper ">

            <input id="`destination_city_origin${index_key}`" class="inputSearchForeign search-box-selectOneFlightVue" type="text"
                   v-model="title_arrival_city"
                   name="origin"
                   :lang="`${dataSearch.software_lang}`" @keyup="searchCityArrival" @focus="focusSearchArrivalCity" @click.stop="dropBox('arrival')">
             <span
                v-if="title_arrival_city"
                class="clear-input"
                @click.stop="clearPortalArrivalInput"
                title="Clear"
             >
               ×
             </span>
            <img :src="`${getUrlWithoutLang()}view/client/assets/images/load.gif`" id="LoaderForeignReturn" name="LoaderForeignReturn"
                 class="loaderSearch" v-if='search_arrival_loading'>
            <input :id="`destination_foreign${index_key}`" class="" type="hidden" v-model="iata_arrival"
                   name="destination_foreign">

            <div v-if="(cities_arrival.length == 0 & title_arrival_city == '') || show_arrival_popular">
              <ul id="ListAirPortRetrun" class="resultFlight_international search-box-resultFlight" v-show="is_arrival_search">
                <div class='parent-titr' v-if="stored_arrival_cities.length > 0 ">
                  <span>{{ useXmltag('History') }}</span>
                  <span class='delete-pointer' @click.stop="clearSearchedCities('origin')">{{ useXmltag('Clear') }}</span>
                </div>
                <li v-for="city in stored_arrival_cities" @click.stop="selectAirportArrival(city,lang)">
                  <i class="fa fa-clock-o my-icon-loction  margin-left-5 margin-right-5"></i>
                  {{ city[`Airport${lang.charAt(0).toUpperCase() + lang.slice(1)}`]}} -
                  {{ city[`Country${lang.charAt(0).toUpperCase() + lang.slice(1)}`]}} -
                  {{ city[`DepartureCity${lang.charAt(0).toUpperCase() + lang.slice(1)}`]}} -
                  {{ city.DepartureCode}}
                </li>
                <span>{{ useXmltag('PopularRoutes') }}</span>
                <li v-for="city in $store.state.popular_international_flights" @click.stop="selectAirportArrival(city,lang)">
                  <i class="fa fa-map-marker my-icon-loction  margin-left-5 margin-right-5"></i>
                  {{ city[`Airport${lang.charAt(0).toUpperCase() + lang.slice(1)}`]}} -
                  {{ city[`Country${lang.charAt(0).toUpperCase() + lang.slice(1)}`]}} -
                  {{ city[`DepartureCity${lang.charAt(0).toUpperCase() + lang.slice(1)}`]}} -
                  {{ city.DepartureCode}}
                </li>
              </ul>
        </div>
            <div v-else>
              <ul id="ListAirPortRetrun" class="resultFlight_international" v-show="is_arrival_search">
                <li v-for="city in cities_arrival" @click="selectAirportArrival(city,lang)">
                  <i class="fa fa-map-marker my-icon-loction  margin-left-5 margin-right-5"></i>
                  {{ city[`Airport${lang.charAt(0).toUpperCase() + lang.slice(1)}`]}} -
                  {{ city[`Country${lang.charAt(0).toUpperCase() + lang.slice(1)}`]}} -
                  {{ city[`DepartureCity${lang.charAt(0).toUpperCase() + lang.slice(1)}`]}} -
                  {{ city.DepartureCode}}
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
                           :from="dateNow('-')" mode="single"
                           :column="1"
                           name="dept_date"
                           :id="`dept_date_foreign${index_key}`" :styles="styles"
                           :position="'bottom'"
                           :auto-position="false"
                           :placeholder="`${useXmltag('Wentdate')}`"
                  >
                    <template #icon></template>
                  </date-picker>
              </template>
            </div>
          </div>
        </div>
      </div>
      <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100 multi-route" v-if="search_box_type=='Twoway'">
        <div class="s-u-form-date-wrapper">
          <div class="s-u-date-pick">
            <div class="s-u-jalali s-u-jalali-change calender-overflow-inherit">
              <i class="zmdi zmdi-calendar-note site-main-text-color"></i>
              <template>
                <date-picker v-model="date_return" :inputFormat="format_datepicker"
                           :auto-submit="true"
                           :column="1"
                           mode="single" :locale="lang_datepicker"
                           :placeholder="`${useXmltag('Returndate')}`" name="dept_date_return"
                           id="dept_date_foreign_return" :styles="styles"
                           :position="'bottom'"
                           :auto-position="false"
                           :min="date_departure"
                  >
                    <template #icon></template>
                  </date-picker>
              </template>
            </div>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<script>
  import datePicker from '@alireza-ab/vue-persian-datepicker'
  export default {
    name: 'partSearchSide',
    props: ['dataSearch', 'other_data_search', 'index_key', 'count_search_part', 'is_multi_destination'],
    data() {
      return {
        search_origin_loading : false ,
        search_arrival_loading : false,
        is_stored_local_storage : false ,
        show_popular : false,
        show_arrival_popular : false,
        title_origin_city: '',
        title_arrival_city: '',
        iata_origin: '',
        iata_arrival: '',
        cities_origin: [],
        cities_arrival: [],
        stored_origin_cities : [] ,
        stored_arrival_cities : [] ,
        data_search: [],
        today_date: true,
        date_picker_departure: '',
        date_picker_return: '',
        departureDate: '',
        is_search: false,
        is_arrival_search: false,
        format_datepicker: 'jYYYY-jMM-jDD',
        lang_datepicker: 'fa',
        count_pass: 'fa',
        multi_way: false,
        styles: {
          'primary-color': main_color,
          '--dp-menu-offset': '0px',
          '--dp-menu-position': 'bottom',
          '--dp-menu-transform': 'translateY(0)',
          '--dp-menu-transition': 'none',
          '--dp-menu-z-index': '9999',
          '--dp-menu-box-shadow': '0 2px 4px rgba(0,0,0,0.1)',
          '--dp-menu-background-color': '#fff',
          '--dp-menu-border-radius': '4px',
          '--dp-menu-padding': '8px',
          '--dp-menu-width': '300px',
          '--dp-menu-height': 'auto',
          '--dp-menu-max-height': 'none',
          '--dp-menu-overflow': 'visible',
          '--dp-menu-position-fixed': 'true'
        },
        date_departure:'',
        date_return:'',
        isCalendarFocused: false,
        column: {
            1: 1,
        }
      }
    },
    components: {
      'date-picker': datePicker,
      'date-picker-return': datePicker,

    },
    methods: {
       clearPortalOriginInput() {
          this.title_origin_city = '';
          this.iata_origin = null;

          this.cities_origin = [];
          this.show_popular = true;
          this.is_search = false;
       },

       clearPortalArrivalInput() {
          this.title_arrival_city = '';
          this.iata_arrival = null;

          this.cities_arrival = [];
          this.show_arrival_popular = true;
          this.is_arrival_search = false;
       },
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
        if(type == 'origin') {
          this.stored_arrival_cities = []
        }else {
          this.stored_origin_cities = []
        }
        let getSearchedCities = JSON.parse(localStorage.getItem('internationalSearchedCities'))
        localStorage.setItem('internationalSearchedCities' , JSON.stringify({[type] : getSearchedCities[type]}));
      },
      setSearchedStorage() {

        this.is_stored_local_storage = true
        let storage_searched_cities =  localStorage.getItem('internationalSearchedCities')
        if(storage_searched_cities == null || storage_searched_cities == "null" ) {
          let storage_origin_cities = []
          let storage_arrival_cities = []
          storage_origin_cities.push({
            DepartureCode : this.iata_origin  ,
            [`DepartureCity${this.lang.charAt(0).toUpperCase() + this.lang.slice(1)}`] : this.dataSearch.name_departure ,
            [`Country${this.lang.charAt(0).toUpperCase() + this.lang.slice(1)}`]: this.dataSearch.country_departure ,
            [`Airport${this.lang.charAt(0).toUpperCase() + this.lang.slice(1)}`]: this.dataSearch.airport_departure ,
          })
          storage_arrival_cities.push({
            DepartureCode : this.iata_arrival  ,
            [`DepartureCity${this.lang.charAt(0).toUpperCase() + this.lang.slice(1)}`]:this.dataSearch.name_arrival,
            [`Country${this.lang.charAt(0).toUpperCase() + this.lang.slice(1)}`]: this.dataSearch.country_arrival ,
            [`Airport${this.lang.charAt(0).toUpperCase() + this.lang.slice(1)}`]: this.dataSearch.airport_arrival ,
          })
          this.stored_origin_cities = storage_origin_cities
          this.stored_arrival_cities = storage_arrival_cities
          localStorage.setItem("internationalSearchedCities", JSON.stringify({ origin : storage_origin_cities , arrival : storage_arrival_cities }));
        }
        else {
          let storage_searched_cities =  JSON.parse(localStorage.getItem('internationalSearchedCities'))
          let storage_origin_cities = []
          let storage_arrival_cities = []
          if(!storage_searched_cities['origin']){
            storage_origin_cities.push({
              DepartureCode : this.iata_origin  ,
              [`DepartureCity${this.lang.charAt(0).toUpperCase() + this.lang.slice(1)}`] : this.dataSearch.name_departure ,
              [`Country${this.lang.charAt(0).toUpperCase() + this.lang.slice(1)}`]: this.dataSearch.country_departure ,
              [`Airport${this.lang.charAt(0).toUpperCase() + this.lang.slice(1)}`]: this.dataSearch.airport_departure ,
            })
            this.stored_origin_cities = storage_origin_cities
          }else {
            this.stored_origin_cities = storage_searched_cities.origin
            if(storage_searched_cities.origin && storage_searched_cities.origin.length > 0 ) {
              let has_stored = storage_searched_cities.origin.find(city => {
                return city.DepartureCode == this.iata_origin
              })
              if (!has_stored) {
                if (storage_searched_cities.origin.length == 5) {
                  storage_searched_cities.origin.shift()
                }
                storage_searched_cities.origin.push({
                  DepartureCode: this.iata_origin ,
                  [`DepartureCity${this.lang.charAt(0).toUpperCase() + this.lang.slice(1)}`]: this.dataSearch.name_departure ,
                  [`Country${this.lang.charAt(0).toUpperCase() + this.lang.slice(1)}`]: this.dataSearch.country_departure ,
                  [`Airport${this.lang.charAt(0).toUpperCase() + this.lang.slice(1)}`]: this.dataSearch.airport_departure ,
                })
              }
            }
            storage_origin_cities = storage_searched_cities.origin
          }
          if(!storage_searched_cities['arrival']) {
            storage_arrival_cities.push({
              DepartureCode : this.iata_arrival  ,
              [`DepartureCity${this.lang.charAt(0).toUpperCase() + this.lang.slice(1)}`]:this.dataSearch.name_arrival,
              [`Country${this.lang.charAt(0).toUpperCase() + this.lang.slice(1)}`]: this.dataSearch.country_arrival ,
              [`Airport${this.lang.charAt(0).toUpperCase() + this.lang.slice(1)}`]: this.dataSearch.airport_arrival ,
            })
            this.stored_arrival_cities = storage_arrival_cities
          }else {
            this.stored_arrival_cities = storage_searched_cities.arrival
            if(storage_searched_cities.arrival && storage_searched_cities.arrival.length > 0 ) {
              let has_stored = storage_searched_cities.arrival.find(city => {
                return city.DepartureCode == this.iata_arrival
              })
              if (!has_stored) {
                if (storage_searched_cities.arrival.length == 5) {
                  storage_searched_cities.arrival.shift()
                }
                storage_searched_cities.arrival.push({
                  DepartureCode: this.iata_arrival,
                  [`DepartureCity${this.lang.charAt(0).toUpperCase() + this.lang.slice(1)}`]: this.dataSearch.name_arrival,
                  [`Country${this.lang.charAt(0).toUpperCase() + this.lang.slice(1)}`]: this.dataSearch.country_arrival ,
                  [`Airport${this.lang.charAt(0).toUpperCase() + this.lang.slice(1)}`]: this.dataSearch.airport_arrival ,
                })
              }

            }
            storage_arrival_cities = storage_searched_cities.arrival
          }
          localStorage.setItem("internationalSearchedCities", JSON.stringify({ origin : storage_origin_cities , arrival :storage_arrival_cities}));
        }
      },
      focusSearchCity: function(event) {
        let _this = this
        _this.show_popular = true
      },
      focusSearchArrivalCity: function(event) {
        let _this = this
        _this.show_arrival_popular = true
      },
      searchCity: function(event) {
        let value_city = event.target.value
        let _this = this
        _this.show_popular = false
        if (value_city.length >= 3) {
          _this.search_origin_loading = true
          let lang = (event.target.lang !== 'fa') ? 'en' : 'fa'
          axios.post(amadeusPath + 'ajax', {
            className: 'newApiFlight',
            method: 'getCityForeign',
            iata_city: value_city,
          }, {
            'Content-Type': 'application/json',
          }).then(function(response) {
            _this.search_origin_loading = false
            _this.cities_origin = response.data.data
            _this.is_search = true
            // _this.insertCityToUl(response.data.data,lang);
          }).catch(function(error) {
            _this.search_origin_loading = false
          })
        }
      },
      searchCityArrival: function(event) {
        let value_city = event.target.value
        let _this = this
        _this.show_arrival_popular = false
        if (value_city.length >= 3) {
          _this.search_arrival_loading = true
          let lang = (event.target.lang !== 'fa') ? 'en' : 'fa'
          axios.post(amadeusPath + 'ajax', {
            className: 'newApiFlight',
            method: 'getCityForeign',
            iata_city: value_city,
          }, {
            'Content-Type': 'application/json',
          }).then(function(response) {
            _this.search_arrival_loading = false
            _this.cities_arrival = response.data.data
            _this.is_arrival_search = true
            // _this.insertCityToUl(response.data.data,lang);
          }).catch(function(error) {
            _this.search_arrival_loading = false
          })
        }
      },
      selectAirportOrigin(city, lang) {
        lang = (lang !== 'fa') ? 'en' : 'fa'

        this.dataSearch.airport_departure = city[`Airport${lang.charAt(0).toUpperCase() + lang.slice(1)}`]
        this.dataSearch.country_departure = city[`Country${lang.charAt(0).toUpperCase() + lang.slice(1)}`]
        this.dataSearch.name_departure = city[`DepartureCity${lang.charAt(0).toUpperCase() + lang.slice(1)}`]
        this.dataSearch.origin = city.DepartureCode
        this.is_search = false
        this.iata_origin = `${city.DepartureCode}`

        this.title_origin_city = `${city[`Airport${lang.charAt(0).toUpperCase() + lang.slice(1)}`]}`
        if( this.iata_origin == this.iata_arrival) {

          this.is_arrival_search = true
          this.iata_arrival = ''
          this.dataSearch.airport_arrival = ''
          this.dataSearch.country_arrival = ''
          this.dataSearch.name_arrival = ''
          this.dataSearch.destination =  ''
          this.title_arrival_city = ''
        }

      },
      selectAirportArrival(city, lang) {
        lang = (lang !== 'fa') ? 'en' : 'fa'
        this.dataSearch.airport_arrival = city[`Airport${lang.charAt(0).toUpperCase() + lang.slice(1)}`]
        this.dataSearch.country_arrival = city[`Country${lang.charAt(0).toUpperCase() + lang.slice(1)}`]
        this.dataSearch.name_arrival = city[`DepartureCity${lang.charAt(0).toUpperCase() + lang.slice(1)}`]
        this.dataSearch.destination = city.DepartureCode
        this.is_arrival_search = false
        this.iata_arrival = `${city.DepartureCode}`
        this.title_arrival_city = `${city[`Airport${lang.charAt(0).toUpperCase() + lang.slice(1)}`]}`
        if( this.iata_origin == this.iata_arrival) {
          this.is_search = true
          this.iata_origin = ''
          this.dataSearch.airport_departure = ''
          this.dataSearch.country_departure = ''
          this.dataSearch.name_departure = ''
          this.dataSearch.origin =  ''
          this.title_origin_city = ''
        }
      },
      reversDestinations() {

        let title_origin = this.title_origin_city
        let iata_origin = this.iata_origin
        let title_arrival = this.title_arrival_city
        let iata_arrival = this.iata_arrival
        this.title_origin_city = title_arrival
        this.iata_origin = iata_arrival

        this.title_arrival_city = title_origin
        this.iata_arrival = iata_origin

        this.dataSearch.airport_departure = this.title_origin_city
        this.dataSearch.origin = this.iata_origin
        this.dataSearch.airport_arrival = this.title_arrival_city
        this.dataSearch.destination =  this.iata_arrival
      },
      delete_path(id) {
        this.$emit('delete_path_flight', id)
      },
      getPopularFlights() {
        let _this = this
        _this.$store.dispatch('getPopularInternationalFlight', {method: 'getPopularInternationalFlight'})
      }
    },
    created: function() {

       console.log('abbasi: ' , this.dataSearch.arrival_date_en)

      if (this.other_data_search.software_lang != 'fa' || !this.other_data_search.software_lang_check) {
        this.format_datepicker = 'YYYY-MM-DD'
        this.lang_datepicker = 'en'
      }


    },

    watch: {
      'dataSearch': {
        handler: function(after, before) {
          if (after) {
            let _this = this
            if (_this.dataSearch) {
              _this.title_origin_city = `${_this.dataSearch.airport_departure}`
              _this.iata_origin = _this.dataSearch.origin
              _this.title_arrival_city = `${_this.dataSearch.airport_arrival}`
              _this.iata_arrival = _this.dataSearch.destination
              _this.count_path = _this.dataSearch.count_path
              _this.multi_way =  (_this.other_data_search.MultiWay == 'TwoWay') ? true : false;
              _this.date_departure =  _this.dataSearch.departure_date_en
              if(_this.dataSearch.arrival_date_en === "") {
                _this.date_return =  _this.dataSearch.departure_date_en
              }
               else {
                _this.date_return =  _this.dataSearch.arrival_date_en
              }
              _this.getPopularFlights()
              if(!_this.is_stored_local_storage) {
                _this.setSearchedStorage()
              }
            }
          }
        },
        deep: true,
        immediate: true,
      },

       // watch: {
       //    'dataSearch': {
       //       handler: function(newVal, oldVal) {
       //          if (!newVal || JSON.stringify(newVal) === JSON.stringify(oldVal)) return;
       //
       //          this.$nextTick(() => {
       //             if (!this.is_stored_local_storage) {
       //                this.setSearchedStorage();
       //             }
       //          });
       //       },
       //       deep: true,
       //       immediate: true
       //    }
       // },

    },
    computed:{
      search_box_type() {
        return this.$store.state.data_search_type ;
      },
       shouldShowSearchBox() {
          return this.is_multi_destination || this.index_key == 0;
       },
       isMultiSearch() {
          return this.search_box_type === 'multiSearch' && this.is_multi_destination;
       },
      lang(){
        if(this.getLang() == 'ru') {
          return 'en'
        }
        return  this.getLang()
      }
    }
  }
</script>

<style>
/* Ensure the calendar appears above other elements */
.s-u-jalali {
  position: relative;
}
.pdp .pdp-picker{
   padding: 0 !important;
}
.pdp .pdp-picker .pdp-header .bottom{
   padding: 0.3rem 19px !important;
}
.pdp .pdp-picker .pdp-footer{
   padding: 0.3rem 14px !important;
}

/* همیشه تقویم را پایین input باز کن */
.dp__menu, .ui-datepicker {
   top: 100% !important;
   bottom: auto !important;
   left: 0 !important;
   right: auto !important;
   transform: none !important;
   /* اگر absolute جواب نداد، position: fixed را هم تست کن */
}
.pdp-picker{
   top: 100% !important;
   bottom: auto !important;
   left: 0 !important;
   right: auto !important;
   transform: none !important;
}
</style>

