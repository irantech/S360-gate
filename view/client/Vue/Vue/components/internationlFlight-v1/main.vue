<template>
  <section class="search-flight">
    <loader  v-if="is_show_loader"></loader>
    <search-box />
    <div class="container">
      <div class="parent-search-flight">

        <side-filter v-if='windowWidth > 576' :flight_count='flight_count' :type="'international'"/>
        <div class="box-flight">
          <top-filter :flight_count='flight_count' :type="'international'" />
          <flight-list @filtered_flights_count='setFlightCount' />
        </div>
      </div>
      <form method="post" id="formAjax" action="">
        <input type="hidden" :value="dataSearch.MultiWay" name="MultiWayTicket" id="MultiWayTicket"/>
        <input id="temporary" name="temporary" type="hidden" value="">
        <input id="ZoneFlight" name="ZoneFlight" type="hidden" value="">
        <input type="hidden" value='' name="SourceM5_ID" id="SourceM5_ID">
        <input type="hidden" value='' name="flight_id_private" id="flight_id_private">
      </form>
    </div>
  </section>

</template>


<script>
import searchBox from "./searchBox";
import sideFilter from "../global/sideFilter";
import topFilter from "../global/topFilter";
import flightList from "./flightList";
import loader from "../global/loader";

export default {
  name: "internationalFlight",
  components: {
    'search-box': searchBox,
    'side-filter': sideFilter,
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
      return this.$store.state.price;
    }
  },
  methods: {
    setFlightCount(value) {
      this.flight_count = value
    }
  },
  created() {
    let url_send = location.pathname.substring(0);
    let url_finally ='';
    let url_send_split = url_send.split('/')
    if(url_send_split.length <= 6 && url_send_split[4] !== undefined){
      if(url_send_split[5] !== undefined){
        url_finally = `/gds/fa/international-flight/1/${url_send_split[5]}/${dateNow('-')}/Y/1-0-0`;

        window.history.pushState({path: url_send}, "", url_finally);

        url_send = url_finally ;
      }
    }else{
      if(typeof query_param_get.mroute != 'undefined') {
        url_send = query_param_get;
      }
    }

    this.$store.dispatch('getDataSearch', {url:url_send}).then(response => {
      this.$store.dispatch('getFlight', {url: url_send,method:'flightInternational'}).then(response=>{
        this.$store.commit('priceFilter' , [this.price.min_price,this.price.max_price])
      })
    });
  },

}
</script>