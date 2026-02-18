<template>
       <div id="result" class="col-lg-9 col-md-12 col-sm-12 col-xs-12 col-padding-5">
            <loader :dataSearch="dataSearch" v-if="is_show_loader"></loader>
           <div class=" s-u-ajax-container foreign" >
               <div class="s-u-result-wrapper">
                   <header-flight-internal :dataSearch="dataSearch" :flights="flights" @updateFlights="applyUniqueFlights" @sortByTime="timeSort"  @sortByPrice="priceSort" @updateShowOfferFlights="updateShowOfferFlights"></header-flight-internal>
                  <!--    TODO: advertisement-->
                   <div class='fullCapacity_div' v-if='!is_show_loader && (flights.length === 0 || this.$store.state.isComplete)'>

                      <img v-if="full_capacity['pic_url'] !='' && full_capacity['pic']"  :src="full_capacity['pic_url']" alt="fullCapacity">
                      <img v-else  :src="`${getUrlWithoutLang()}view/client/assets/images/fullCapacity.png`" alt="fullCapacity">

                   <h2 v-if='flights.length === 0'>{{useXmltag('Noflight')}}</h2>
                   <h2 v-else-if='this.$store.state.isComplete'>{{ useXmltag('FullCapacityRequestOffline') }}</h2>
                   <request-offline v-if="has_request_offline_access && (this.$store.state.isComplete || flights.length == 0)" :dataSearch="dataSearch"></request-offline>
                 </div>
                   <ul id="s-u-result-wrapper-ul" v-if="!is_show_loader && flights.length > 0">
                       <div class="selectedTicket mart10 marb10"></div>
                       <div class="items item_flight"><!---->
                           <div class="selectedTicket" v-show="this.$store.state.typeTripFlight === 'return'">
                               <h5 class="raft-ticket">
                                   <a @click="backTrip()"><i class="zmdi zmdi-close site-secondary-text-color"></i></a>
                                   {{useXmltag("TicketSelected")}}
                               </h5>
                               <div id="myList1" class="showListSort">


                               </div>
                               <div class="twowayWarning">
<!--                                   <p>{{useXmltag('Payattentionfollowingpoints')}}</p>-->
<!--                                   <ul>-->
<!--                                       <li>{{ useXmltag('DueLimitationsTwoWayAgreementBetweenIran')}}</li>-->
<!--                                       <li>{{ useXmltag('TermsAirlinesCharterFlightsLessThanPercentLikely')}}</li>-->
<!--                                   </ul>-->
                                  <p>{{useXmltag('twowayWarningSentence')}}</p>
                               </div>
                               <h5 class="bargasht-ticket">{{useXmltag('SelectReturnTicket')}}</h5>
                           </div>

                         <div class="showListSort" v-for="(flight,key_flight) in twoWayFlight" :key="key_flight" :id="flight.flight_id">
                           <div  data-typeappticket="noReservation" class="international-available-box" :class="[flight.time_flight_name ,flight.flight_type_li ]" >
                              <span class="hidden-data">
                                 {{key_flight}}
                              </span>
                             <input  type="hidden" value="noReservation" name="typeAppTicket" id="typeAppTicket">
                             <each-twoWay-flight :each_flight="flight" :data_search="dataSearch" :key_flight="key_flight" :key="`twoWay_${key_flight}`"></each-twoWay-flight>
                           </div>
                         </div>
                           <div class="showListSort" v-for="(flight,key_flight) in flights" :key="key_flight" :id="flight.flight_id">

                               <div  data-typeappticket="noReservation" class="international-available-box" :class="[flight.time_flight_name , flight.airline ,flight.flight_type_li]" >
                                  <span class="hidden-data">
                                 {{key_flight}}
                              </span>
                                   <input  type="hidden" value="noReservation" name="typeAppTicket" id="typeAppTicket">
                                    <each-flight :flight="flight" :data_search="dataSearch" :key_flight="key_flight" :key='key_flight' :showOfferFlights="showOfferFlights"></each-flight>
                               </div>
                           </div>
                       </div>
                   </ul>

<!--                   <ul  id="s-u-result-wrapper-ul" class="items item_flight" v-else v-if='!is_show_loader && flights.length === 0'>-->
<!--                       <div class="userProfileInfo-messge ">-->
<!--                           <div class="messge-login BoxErrorSearch ">-->
<!--                               <div class="alarm_icon_msg">-->
<!--                                   <i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>-->
<!--                               </div>-->
<!--                               <div class="TextBoxErrorSearch">-->
<!--                                   {{useXmltag('Noflight')}} {{useXmltag('Changedate')}}-->
<!--                               </div>-->
<!--                           </div>-->
<!--                       </div>-->
<!--                   </ul>-->
               </div>
           </div>
       </div>

</template>

<script>

    import headerFlightInternal from "./header";
    import loader from "./loader";
    import eachFlight from "./eachFlight";
    import eachTwoWayFlight from "./eachTwoWayFlight.vue";
    import requestOffline from "../requestOffline/main";

    export default {
        name: "showTicket",
        props: ['flights', 'dataSearch' , 'has_request_offline_access' , 'full_capacity' , 'twoWayFlight'],
        components: {
            'header-flight-internal': headerFlightInternal,
            'each-flight':eachFlight,
            'each-twoWay-flight':eachTwoWayFlight,
            'loader':loader,
            'request-offline':requestOffline,
        },
        data() {
            return {
                is_show_loader: true,
                data_search: [],
                showOfferFlights: false,
            }
        },
        methods: {
            timeSort() {
                this.$emit('sortTimeOfShowTicket')
            },
            priceSort() {
                this.$emit('sortPriceOfShowTicket')
            },
            backTrip(){
                document.getElementById("myList1").innerHTML = "";
                this.$store.commit('setTypeTripFlight','dept');
            },
           applyUniqueFlights(newFlights) {

              console.log("flights قبل از commit:", this.$store.state.flights.dept);
              console.log("قبل از commit:", newFlights);

              this.$store.commit('updateDeptFlights', newFlights);

              console.log("flights بعد از commit:", this.$store.state.flights.dept);
           },
           updateShowOfferFlights(value) {
              this.showOfferFlights = value;
           }
        },
        created: function () {

        },
        watch: {
            flights() {
                if (this.flights.length || !this.$store.state.defaultLoader) {
                    this.is_show_loader = false
                }
            },

        }
    }
</script>

<style scoped>

</style>