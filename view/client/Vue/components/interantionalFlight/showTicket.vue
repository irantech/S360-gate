<template>
  <div id='result' class='col-lg-9 col-md-12 col-sm-12 col-xs-12 col-padding-5'>
    <loader :dataSearch='dataSearch' v-if='is_show_loader'></loader>
    <div class=' s-u-ajax-container foreign'>
      <div class='s-u-result-wrapper'>
        <header-flight-foreign :dataSearch='dataSearch' @sortByTime='timeSort'
                               @sortByPrice='priceSort'></header-flight-foreign>
        <div class='fullCapacity_div' v-if='!is_show_loader && (this.$store.state.isComplete || flights.length == 0)'>
          <img v-if="full_capacity['pic_url'] !='' && full_capacity['pic']"  :src="full_capacity['pic_url']" alt="fullCapacity">
          <img v-else  :src="`${getUrlWithoutLang()}view/client/assets/images/fullCapacity.png`" alt="fullCapacity">

          <h2 v-if='flights.length === 0'>{{ useXmltag('Noflight') }}</h2>
          <h2 v-else-if='this.$store.state.isComplete'>{{ useXmltag('FullCapacityRequestOffline') }}</h2>
          <request-offline v-if='has_request_offline_access && (this.$store.state.isComplete || flights.length == 0)'
                           :dataSearch='dataSearch'></request-offline>
        </div>
        <div id='s-u-result-wrapper-ul' class='foraign' v-if='!is_show_loader && flights.length > 0'>
                    <div class='items item_flight' id='showTicketItems'>
            <virtual-list
                          :data-key="'flight_id'"
                          :data-sources= 'flights'
                          :data-component='virtualScrollEachFlight'
                          :extra-props="{data_search:dataSearch}"
                          :item-class="'showListSort'"
                          :page-mode="true"
                          :estimate-size="135"
            />
            <!--                        <div class="showListSort" v-for="(flight,key_flight) in flights" :key="key_flight">
                                        <div class="international-available-box foreign deptFlight"
                                             :class="[flight.time_flight_name ,flight.flight_type_li, (dataSearch.dataSearch.MultiWay !='multi_destination' ) ? flight.airline:''] ">
                                                    <template v-if='dataSearch.dataSearch.MultiWay=="multi_destination"'>
                                                        <each-multi-flight :each_flight="flight" :data_search="dataSearch" :key_flight="key_flight" @modalShowTicketDetail='modalShowTicket'></each-multi-flight>
                                                    </template>
                                                    <template v-else>
                                                        <each-flight :each_flight="flight" :data_search="dataSearch" :key_flight="key_flight" @modalShowTicketDetail='modalShowTicket'></each-flight>
                                                    </template>
                                            <div class="clear"></div>
                                        </div>
                                    </div>-->
          </div>
        </div>

        <!--                <div id="s-u-result-wrapper-ul" class="foraign" v-else>-->
        <!--                    <ul  id="s-u-result-wrapper-ul" class="items item_flight" v-if="!is_show_loader">-->
        <!--                        <div class="userProfileInfo-messge ">-->
        <!--                            <div class="messge-login BoxErrorSearch ">-->
        <!--                                <div class="alarm_icon_msg">-->
        <!--                                    <i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>-->
        <!--                                </div>-->
        <!--                                <div class="TextBoxErrorSearch">-->
        <!--                                   {{useXmltag('Noflight')}} {{useXmltag('Changedate')}}-->
        <!--                                </div>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </ul>-->
        <!--                </div>-->
      </div>
    </div>

  </div>
</template>

<script>
import headerFlightForeign from './header'
import loader from './loader'
import requestOffline from '../requestOffline/main'
import virtualScrollEachFlight from './virtualScrollEachFlight.vue'
import VirtualList from 'vue-virtual-scroll-list'

export default {
  name: 'showTicket',
  computed: {
    virtualScrollEachFlight() {
      return virtualScrollEachFlight
    },
  },
  props: ['flights', 'dataSearch', 'has_request_offline_access' , 'full_capacity'],
  components: {
    'header-flight-foreign': headerFlightForeign,
    'loader': loader,
    'request-offline': requestOffline,
    'virtualScrollEachFlight': virtualScrollEachFlight,
    'virtual-list': VirtualList,

  },
  data() {
    return {
      is_show_loader: true,
      data_search: [],
      items: [],
    }
  },
  methods: {
    timeSort() {
      this.$emit('sortTimeOfShowTicket')
    },
    priceSort() {
      this.$emit('sortPriceOfShowTicket')
    },
    modalShowTicket(value) {
      this.$emit('modalBaggageDetailInMain', value)
    },
  },
  created: function() {

  },
  watch: {
    flights() {
      if (this.flights) {
        this.is_show_loader = false
      }



    },

  },
  mounted() {

  },
}
</script>

<style scoped>

</style>