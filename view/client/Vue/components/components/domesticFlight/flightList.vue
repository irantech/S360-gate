<template>
  <div>

    <div class="selectedTicket" v-show="this.$store.state.typeTripFlight === 'return'">
      <h5 class="raft-ticket">
        <a @click="backTrip()"><i class="zmdi zmdi-close site-secondary-text-color"></i></a>
        {{useXmltag("TicketSelected")}}
      </h5>
      <div id="myList1" class="showListSort">


      </div>
      <div class="twowayWarning">
        <p>{{useXmltag('Payattentionfollowingpoints')}}</p>
        <ul>
          <li>{{ useXmltag('DueLimitationsTwoWayAgreementBetweenIran')}}</li>
          <li>{{ useXmltag('TermsAirlinesCharterFlightsLessThanPercentLikely')}}</li>
        </ul>
      </div>
      <h5 class="bargasht-ticket">{{useXmltag('SelectReturnTicket')}}</h5>
    </div>

    <div v-for="(flight,key_flight) in filteredFlights" :key="key_flight" :id="flight.flight_id">
      <div  data-typeappticket="noReservation" :class="[flight.time_flight_name , flight.airline ,flight.flight_type_li]" >
        <input  type="hidden" value="noReservation" name="typeAppTicket" id="typeAppTicket">
        <flight :flight='flight'/>
      </div>
    </div>
  </div>
</template>


<script>
import flight from './flight'

export default  {
  name : 'flightList' ,
  components: {
    'flight': flight,
  },
  data() {
    return {
    }
  },
  computed:{
    flights() {
      if(this.$store.state.setDataSearch.MultiWay ==='TwoWay'){
        if(this.$store.state.typeTripFlight === 'dept'){
          this.$store.commit('setTypeTripFlight','dept');
          return this.$store.state.flights.dept;
        }else{

          this.$store.commit('setTypeTripFlight','return');
          this.price_filter_flight = [this.price.min_price,this.price.max_price]
          return this.$store.state.flights.return;
        }
      }else{
        this.$store.commit('setTypeTripFlight','dept');
        return this.$store.state.flights.dept;
      }

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
    filteredFlights() {
      console.log(this.$store.state.price_filter_flight[0] , this.$store.state.price_filter_flight[1], this.$store.state.check_min_max_price)
      if(this.flights && this.flights.length > 0 )
      {
        return this.flights.filter(flight => {
            return (this.$store.state.time_filter.length == 1 && this.$store.state.time_filter[0] == 'all_time') ? flight : this.$store.state.time_filter.includes(flight.time_flight_name)
          }
        ).filter(flight => {
            return (this.$store.state.stop_filter.length == 1 && this.$store.state.stop_filter[0] == 'all_stop') ? flight : this.$store.state.stop_filter.includes(flight.count_interrupt)
          }
        ).filter(flight => {
            return (this.$store.state.airline_filter.length == 1 && this.$store.state.airline_filter[0] == 'all_airline') ? flight : this.$store.state.airline_filter.includes(flight.airline)
          }
        ).filter(flight => {
            return (this.$store.state.seat_class_filter.length == 1 && this.$store.state.seat_class_filter[0] == 'all_seat_class') ? flight : this.$store.state.seat_class_filter.includes(flight.seat_class_en)
          }
        ).filter(flight => {
            return (this.$store.state.type_flight_filter.length == 1 && this.$store.state.type_flight_filter[0] == 'all_type_flight') ? flight : this.$store.state.type_flight_filter.includes(flight.flight_type_li)
          }
        )
          .filter(flight => {

            return ((flight.price.adult.price >= this.$store.state.price_filter_flight[0]  && flight.price.adult.price <= this.$store.state.price_filter_flight[1]) || (flight.price.adult.price == 0 && this.$store.state.check_min_max_price));
          }
        )
      }
      return [];

    },

  } ,
  watch : {
    filteredFlights() {
      this.$emit('filtered_flights_count' , this.filteredFlights.length)
    }
  }
}
</script>