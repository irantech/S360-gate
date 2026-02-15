<template>

        <div class=" international-available-airlines" v-if="data_search.dataSearch.MultiWay !='multi_destination'">
          <div class="international-available-airlines-logo foreign" :class="each_airline_flight.airline">
                <div class="logo-airline-ico-foreign"></div>
            </div>

          <div class="international-available-airlines-log-info pt-2">
            <div class="sandali-span2 iranL text-dark">{{ each_airline_flight.airline_name}} ({{each_airline_flight.airline}})</div>
          </div>

<!--          <div class="international-available-airlines-log-info pt-2 site-main-text-color" v-if="each_airline_flight.capacity > 0">-->

<!--            <div class="sandali-span2 iranL  site-main-text-color">{{ each_airline_flight.capacity}} {{useXmltag('Chair')}}</div>-->
<!--          </div>-->

           <span class="flightnumber_s pt-2">
               {{ each_airline_flight.flight_number}}
           </span>
        </div>


        <div class=" international-available-airlines" v-else>
            <div class="international-available-airlines-logo foreign" :class="[each_airline_flight.airline.airline_code]">
                <div class="logo-airline-ico-foreign"></div>
            </div>
            <div class="international-available-airlines-log-info pt-2">
              <div class="sandali-span2 iranL text-dark">{{ each_airline_flight.airline.airline_name}}</div>
           </div>
            <div class="international-available-airlines-log-info pt-2 site-main-text-color" v-if='each_airline_flight.capacity > 0'>
            <div class="sandali-span2 sandali-span2-margin-right iranL d-block w-100 text-end  site-main-text-color">{{ each_airline_flight.capacity}}{{useXmltag('Chair')}}</div>
          </div>
        </div>


</template>


<script>
    export default {
        name: "airlineOutPutFlight",
        props:['each_airline_flight','key_each_airline_flight','data_search'],
    }
</script>

<style scoped>

</style>