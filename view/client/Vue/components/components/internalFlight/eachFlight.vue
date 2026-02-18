<template>
  <div>

  <div class="ribbon" v-if="flight.source_id=='special'">
    <span>{{ useXmltag('specialoffer')}}</span>
  </div>

  <div :class="[
  'international-available-item',
  flight.is_private == 'private' ? 'border-is-private' : ''
]">
                        <div class="international-available-info">
                            <div class="international-available-item-right-Cell ">
                                <div class="right_busin_div" v-if="flight.seat_class_en=='business'">
                                    <div class="bg-golden">
                                        <span class="iranM">{{flight.seat_class}}</span>
                                    </div>
                                </div>
                               <div class="right_busin_div" v-if="flight.seat_class_en=='premium_economy'">
                                  <div class="site-bg-main-color">
                                     <span class="iranM">{{flight.seat_class}}</span>
                                  </div>
                               </div>
                                <airline-fight :data_search="data_search" :flight="flight"></airline-fight>
                                <out-put-flight :data_search="data_search" :flight="flight" :showOfferFlights="showOfferFlights"></out-put-flight>

                            </div>
                            <price-flight :data_search="data_search" :flight="flight"></price-flight>
                            <detail-flight :data_search="data_search" :flight="flight"></detail-flight>

                        </div>
                        <div class="clear"></div>
                    </div>
  </div>

</template>

<script>
    import airlineFight from "./airlineFight";
    import outPutFlight from "./outPutFlight";
    import priceFlight from "./priceFlight";
    import detailFlight from "./detailFlight";
    export default {
        name: "eachFlight",
        props:['flight','data_search','key_flight','showOfferFlights'],
        components:{
            'airline-fight':airlineFight,
            'out-put-flight':outPutFlight,
            'price-flight':priceFlight,
            'detail-flight':detailFlight,
        },
        data() {
            return {

            }
        },
        methods: {

        }


    }
</script>

<style scoped>

</style>