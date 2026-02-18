<template>
  <div>
    <div class="parent-data-search-box-flight">
      <div class="data-flight" :class='scroll_down' >
        <div class="container">
          <div class="box-data-flight" v-show='!detail_search_box' @click='windowWidth > 576 ? showDetailSearchBox() : null'>
            <div class="parent-data-flight">
              <div class="parent-search-box-title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M482.3 192c34.2 0 93.7 29 93.7 64c0 36-59.5 64-93.7 64l-116.6 0L265.2 495.9c-5.7 10-16.3 16.1-27.8 16.1l-56.2 0c-10.6 0-18.3-10.2-15.4-20.4l49-171.6L112 320 68.8 377.6c-3 4-7.8 6.4-12.8 6.4l-42 0c-7.8 0-14-6.3-14-14c0-1.3 .2-2.6 .5-3.9L32 256 .5 145.9c-.4-1.3-.5-2.6-.5-3.9c0-7.8 6.3-14 14-14l42 0c5 0 9.8 2.4 12.8 6.4L112 192l102.9 0-49-171.6C162.9 10.2 170.6 0 181.2 0l56.2 0c11.5 0 22.1 6.2 27.8 16.1L365.7 192l116.6 0z"/></svg>
                <h3>{{ useXmltag('FlightTicket')}} {{ dataSearch.name_departure }} {{ useXmltag('On')}} {{ dataSearch.name_arrival }}</h3>
              </div>
              <div class="parent-search-box-back-forth">
                <div class="">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zm64 80v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H336zM64 400v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H208zm112 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z"/></svg>
                  <h3>{{ useXmltag('Went')}}: {{dataSearch.DateFlightWithName}}</h3>
                </div>
                <div v-if="dataSearch.MultiWay == 'TwoWay'" class="">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zm64 80v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H336zM64 400v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H208zm112 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z"/></svg>
                  <h3>{{ useXmltag('JustReturn')}}: {{dataSearch.DateFlightReturnWithName}}</h3>
                </div>
              </div>
            </div>
            <a class="parent-change-search"  @click='windowWidth <= 576 ? openSearchBoxModal() : null'>
              {{ useXmltag('ChangeSearchType')}}
            </a>
          </div>
          <div class="new_search_box" v-show='detail_search_box'>
            <div class="tab-content" id="searchBoxContent">
              <div class="tab-pane active" id="Flight">
                <div id="internal_flight" class="d_flex flex-wrap internal-flight-js">
                  <form method="post" class="d_contents" target="_blank" id="internal_flight_form" name="internal_flight_form">
                    <switch_date />
                    <originDestination :stored_origin_cities='stored_origin_cities'
                                       :stored_arrival_cities='stored_arrival_cities'
                                       :type="'international'"/>
                    <date :type="'international'"/>
                    <passengers :type="'international'" />
                    <approve :searchModule="'international-flight'"/>

                  </form>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <Modal v-model="search_box_modal" v-if='search_box_modal'
           :rtl=true wrapper-class="modal-wrapper">
      <search-box-responsive @closeFilterModal='closeSearchBoxModal()'
                             :stored_origin_cities='stored_origin_cities'
                             :stored_arrival_cities='stored_arrival_cities'
                             :type="'international'"/>
    </Modal>
  </div>

</template>

<script>
import passengers from '../global/searchBox/passengers'
import date from '../global/searchBox/date'
import switch_date from '../global/searchBox/switch'
import originDestination from '../global/searchBox/international/originDestination'

import approve from '../global/searchBox/approve'

import responsiveSearchBox from '../global/modal/resSearch'
import VueModal from '@kouts/vue-modal';
import '@kouts/vue-modal/dist/vue-modal.css'

export default {
  name: "searchBox",
  components: {
    'passengers'  : passengers,
    'date'        : date,
    'switch_date'      : switch_date,
    'originDestination'      : originDestination,
    'approve'     : approve ,
    'search-box-responsive'  : responsiveSearchBox,
    'Modal' : VueModal,
  },
  data() {
    return {
      'detail_search_box'  : false,
      'scroll_down'        : '' ,
      is_reverse           : false ,
      search_box_modal     : false ,
      stored_origin_cities : [],
      stored_arrival_cities : [] ,
      windowWidth : window.innerWidth
    }
  },
  methods : {
    openSearchBoxModal() {
      this.search_box_modal = true
    },
    closeSearchBoxModal() {
      this.search_box_modal = false
    },
    showDetailSearchBox() {
      this.detail_search_box = !this.detail_search_box
    },
    getPopularFlightList() {
      this.$store.dispatch('getPopularInternationalFlight', {method: 'getPopularInternationalFlight'})
    },
    setSearchedStorage() {
      this.is_stored_local_storage = true
      let storage_searched_cities =  localStorage.getItem('internationalSearchedCities')
      if(storage_searched_cities == null || storage_searched_cities == "null" ) {
        let storage_origin_cities = []
        let storage_arrival_cities = []
        storage_origin_cities.push({
          DepartureCode : this.iata_origin  ,
          [`DepartureCity${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`] : this.dataSearch.name_departure ,
          [`Country${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`]: this.dataSearch.country_departure ,
          [`Airport${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`]: this.dataSearch.airport_departure ,
        })
        storage_arrival_cities.push({
          DepartureCode : this.iata_arrival  ,
          [`DepartureCity${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`]:this.dataSearch.name_arrival,
          [`Country${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`]: this.dataSearch.country_arrival ,
          [`Airport${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`]: this.dataSearch.airport_arrival ,
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
            [`DepartureCity${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`] : this.dataSearch.name_departure ,
            [`Country${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`]: this.dataSearch.country_departure ,
            [`Airport${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`]: this.dataSearch.airport_departure ,
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
                [`DepartureCity${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`]: this.dataSearch.name_departure ,
                [`Country${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`]: this.dataSearch.country_departure ,
                [`Airport${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`]: this.dataSearch.airport_departure ,
              })
            }
          }
          storage_origin_cities = storage_searched_cities.origin
        }
        if(!storage_searched_cities['arrival']) {
          storage_arrival_cities.push({
            DepartureCode : this.iata_arrival  ,
            [`DepartureCity${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`]:this.dataSearch.name_arrival,
            [`Country${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`]: this.dataSearch.country_arrival ,
            [`Airport${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`]: this.dataSearch.airport_arrival ,
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
                [`DepartureCity${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`]: this.dataSearch.name_arrival,
                [`Country${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`]: this.dataSearch.country_arrival ,
                [`Airport${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`]: this.dataSearch.airport_arrival ,
              })
            }

          }
          storage_arrival_cities = storage_searched_cities.arrival
        }
        localStorage.setItem("internationalSearchedCities", JSON.stringify({ origin : storage_origin_cities , arrival :storage_arrival_cities}));
      }
    },
  },
  mounted(){
    this.getPopularFlightList()
    this.setSearchedStorage()
    window.document.onscroll = () => {
      if (this.responsiveMobile() === false) {
        this.detail_search_box = false
      }
      if (window.scrollY > 50) {
        this.scroll_down = 'toggleClassNavbar'
        this.detail_search_box = false
      } else {
        this.scroll_down = ''
      }
    }
  } ,
  computed :{
    dataSearch() {
      return this.$store.state.setDataSearch.dataSearch
    },
    searchForm() {
      return this.$store.state.formDataSearch
    }
  },

}
</script>