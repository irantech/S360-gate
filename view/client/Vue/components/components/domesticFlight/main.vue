<template>
  <section class="search-flight">
    <loader  v-if="is_show_loader"></loader>
    <search-box />
    <div class="">
      <div class="parent-search-flight">
        <side-filter v-if='windowWidth > 576' :flight_count='flight_count' :type="'domestic'"/>
        <div class="box-flight">
          <price-calender />
          <top-filter :flight_count='flight_count'  :type="'domestic'"/>
          <flight-list @filtered_flights_count='setFlightCount' />
        </div>
      </div>
    </div>
  </section>
</template>


<script>
import searchBox from "./searchBox";
import sideFilter from "../global/sideFilter";
import priceCalender from "./priceCalender";
import topFilter from "../global/topFilter";
import flightList from "./flightList";
import loader from "../global/loader";

export default {
  name: "domesticFlight",
  components: {
    'search-box': searchBox,
    'side-filter': sideFilter,
    'price-calender': priceCalender,
    'topFilter'     : topFilter,
    'flightList'     : flightList,
    'loader'     : loader,
  },
  data() {
    return {

      is_show_loader: true,
      flight_count :  0 ,
      windowWidth : window.innerWidth
    }
  },
  computed :{
    dataSearch() {
      return this.$store.state.setDataSearch.dataSearch
    },
    price() {
      if(this.$store.state.setDataSearch.MultiWay ==='TwoWay'){
        if(this.$store.state.typeTripFlight=== 'dept')
        {
          return this.$store.state.price.dept;
        }else{
          return this.$store.state.price.return;
        }
      }else{
        return this.$store.state.price.dept;
      }

    },
  },
  methods: {
    setFlightCount(value) {
      this.flight_count = value
    },
    openResponsiveFilter() {
      let _this = this
      _this.responsiveMobile =  true
    },
  },
  created() {
    let url_send = location.pathname.substring(0);
    let url_finally ='';
    let url_send_split = url_send.split('/')

    if(url_send_split.length <= 6 ){
      if(url_send_split[5] !== undefined){
        url_finally = `/gds/fa/search-flight/1/${url_send_split[5]}/${dateNow('-')}/Y/1-0-0`;

        window.history.pushState({path: url_send}, "", url_finally);

        url_send = url_finally ;
      }else{
        console.log(location.pathname)
      }
    }
    this.$store.dispatch('getDataSearch', {url: url_send}).then(response => {
      this.$store.dispatch('getFlight', {url: url_send,method: 'flightInternalV1'}).then(response=>{
        this.is_show_loader = false

        this.$store.commit('priceFilter' , [this.price.min_price,this.price.max_price])
        this.price_filter_flight=[this.price.min_price,this.price.max_price]
      });
      this.$store.dispatch('getLowestPrice', {
        origin: this.dataSearch.origin,
        destination: this.dataSearch.destination ,
        passengers : this.dataSearch.adult+'-'+this.dataSearch.child+'-'+this.dataSearch.infant,
        method : 'getLowestPriceFlightV1'
      })
      this.$store.dispatch('checkTodayDate', {departureDate: this.dataSearch.departureDate})
    });
  },

}
</script>