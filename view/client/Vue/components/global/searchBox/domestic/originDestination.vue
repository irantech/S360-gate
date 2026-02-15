<template>
  <div  class="d-flex col-lg-4 col-md-6 col-sm-6 col-12 col_with_route p-1">
    <div class="col-lg-6 col-md-6 col-sm-6 col-12 col_with_route px-1">
      <div class="form-group">
        <div class="origin_start">
          <input
            type="text"
            autocomplete='off'
            class="form-control inputSearchLocal input-searchBox-flight route_origin_internal-js"
            :placeholder="useXmltag('Origin')"
            ref="origin"
            :lang="`${getLang()}`"
            v-model="title_origin_city_search"
            name="origin" @keyup="searchCity()" @focus="focusSearchCity()"
            @click.stop="dropBox('origin')"
          >
          <img :src="`${getUrlWithoutLang()}view/client/assets/images/load.gif`"
               id="LoaderForeignDep" name="LoaderForeignDep"
               class="loaderSearch" v-show='search_origin_loading'>
          <input class="origin-internal-js"
                 id="origin_local"
                 type="hidden"
                 :value='iata_origin'>
          <div v-if="(cities_origin.length == 0 & title_origin_city_search == '') || show_popular"
               class="list-show-result resultUlInputSearch list-origin-airport-internal-js">
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
          <div id="list_origin_popular_internal"
               class="resultUlInputSearch list-show-result list_popular_origin_internal-js">
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
      <button  class="switch_routs"
               @click="reversDestinations()"
               type="button"
               name="button">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M443.3 139.3c6.2-6.2 6.2-16.4 0-22.6l-96-96c-6.2-6.2-16.4-6.2-22.6 0s-6.2 16.4 0 22.6L393.4 112 16 112c-8.8 0-16 7.2-16 16s7.2 16 16 16l377.4 0-68.7 68.7c-6.2 6.2-6.2 16.4 0 22.6s16.4 6.2 22.6 0l96-96zm-342.6 352c6.2 6.2 16.4 6.2 22.6 0s6.2-16.4 0-22.6L54.6 400 432 400c8.8 0 16-7.2 16-16s-7.2-16-16-16L54.6 368l68.7-68.7c6.2-6.2 6.2-16.4 0-22.6s-16.4-6.2-22.6 0l-96 96c-6.2 6.2-6.2 16.4 0 22.6l96 96z"/></svg>
      </button>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-12 px-1">
      <div class="form-group">
            <span class="destnition_start">
            <input type="text"
                   class="inputSearchForeign form-control input-searchBox-flight route_destination_internal-js"
                   :placeholder="useXmltag('Destination')"
                   v-model="title_arrival_city_search"
                   :lang="`${getLang()}`"
                   ref='arrival' name="destination"
                   @keyup="searchCityArrival()"  @focus="focusSearchArrivalCity()"
                   @click.stop="dropBox('arrival')">
               <img :src="`${getUrlWithoutLang()}view/client/assets/images/load.gif`" id="LoaderForeignReturn" name="LoaderForeignReturn"
                    class="loaderSearch" v-if="search_arrival_loading">
            </span>
        <input  id="destination_local"
                :value='iata_arrival'
               class="destination-internal-js"
               type="hidden">
        <div v-if="(cities_arrival.length == 0 & title_arrival_city_search == '') || show_arrival_popular" id="list_destination_airport_internal"
             class="resultUlInputSearch list-show-result list-destination-airport-internal-js">
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
        <div v-else id="list_destination_popular_internal"
             class="resultUlInputSearch list-show-result list_popular_destination_internal-js">
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
</template>

<script>
export default {
  name : 'origin-destination' ,
  props: ['stored_origin_cities' , 'stored_arrival_cities' ],
  data() {
    return {
      show_popular : false ,
      show_arrival_popular : false ,
      title_origin_city_search : '' ,
      iata_origin: '',
      title_arrival_city_search : '',
      iata_arrival: '',
      cities_origin: [],
      popular_cities_origin : [],
      is_search: false,
      search_origin_loading : false,
      cities_arrival: [],
      is_arrival_search: false,
      search_arrival_loading : false
    }
  } ,
  methods : {
    focusSearchCity() {
      this.show_popular = true
    },

    searchCity() {
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
    dropBox(type){
      if(type == 'origin'){
        this.is_search = !this.is_search ;
        this.is_arrival_search = false
      }else if(type == 'arrival'){
        this.is_arrival_search = !this.is_arrival_search ;
        this.is_search = false
      }

    },
    selectAirportOrigin(city, lang) {
      lang = (lang !== 'fa') ? 'en' : 'fa'
      this.searchForm.name_departure = city[`Departure_City${lang.charAt(0).toUpperCase() + lang.slice(1)}`]
      this.searchForm.origin = city.Departure_Code
      this.cities_origin = []
      this.is_search = false
      this.iata_origin = city.Departure_Code
      this.title_origin_city_search = city[`Departure_City${lang.charAt(0).toUpperCase() + lang.slice(1)}`]
      if( this.searchForm.origin == this.searchForm.destination) {
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
      this.searchForm.name_arrival = city[`Departure_City${lang.charAt(0).toUpperCase() + lang.slice(1)}`]
      this.searchForm.destination =  city.Departure_Code
      this.cities_arrival = []
      this.is_arrival_search = false
      this.iata_arrival = city.Departure_Code
      this.title_arrival_city_search = city[`Departure_City${lang.charAt(0).toUpperCase() + lang.slice(1)}`]

      if( this.searchForm.origin == this.searchForm.destination) {
        this.$refs.arrival.focus();
        this.is_arrival_search = true
        this.iata_arrival = ''
        this.dataSearch.name_arrival = ''
        this.dataSearch.destination =  ''
        this.title_arrival_city_search = ''
      }
    },
    clearSearchedCities(type) {
      if(type == 'origin') {
        this.stored_arrival_cities = []
      }else {
        this.stored_origin_cities = []
      }
      let getSearchedCities = JSON.parse(localStorage.getItem('internalSearchedCities'))
      localStorage.setItem('internalSearchedCities' , JSON.stringify({[type] : getSearchedCities[type]}));
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
    focusSearchArrivalCity(){
      let _this = this
      _this.show_arrival_popular = true
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
  },
  computed :{
    searchForm() {
      return this.$store.state.formDataSearch
    }
  },
  mounted() {
    this.title_origin_city_search = this.searchForm.name_departure
    this.iata_origin = this.searchForm.origin
    this.title_arrival_city_search = this.searchForm.name_arrival
    this.iata_arrival = this.searchForm.destination
  }

}
</script>