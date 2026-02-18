<template>
    <div class=" international-available-airlines pt-2">
        <div class="international-available-airlines-logo international_logo_coming_back foreign"
             :class="each_return_flight.airline">
            <div class="logo-airline-ico-foreign"></div>
        </div>
      <div class="international-available-airlines-log-info pt-2">
        <div class="sandali-span2 iranL text-dark">{{ each_return_flight.airline_name}} ({{each_return_flight.airline}})</div>
      </div>

      <div class="international-available-airlines-log-info pt-2 site-main-text-color" v-if="each_return_flight.capacity > 0">
<!--        <div class="sandali-span2 iranL  site-main-text-color">{{ each_return_flight.capacity}}{{useXmltag('Chair')}}</div>-->
      </div>
    </div>
</template>

<script>
    export default {
        name: "airlineReturnFlight",
        props:['each_return_flight','key_each_airline_flight'],
    }
</script>

<style scoped>

</style>