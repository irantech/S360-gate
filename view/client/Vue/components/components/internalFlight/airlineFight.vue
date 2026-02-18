<template>
    <div class=" international-available-airlines">
        <div class="international-available-airlines-logo"  :class="flight.airline">
            <div>
                <div class="logo-airline-ico"></div>
            </div>
        </div>
        <div class="international-available-airlines-log-info  ">
            <div class="esterdad-blit">
                    <span class="sandali-span2 iranL  text-dark">
                        <i class="font-chanhe "></i>
                        {{flight.airline_name}}

                    </span>
            </div>
        </div>
       <div class="flightnumber_s international-available-airlines-log-info pt-2">
<!--                                        <i> {{useXmltag('FlightNumber')}} : </i>-->
           {{flight.flight_number}}
       </div>
    </div>
</template>

<script>
    export default {
        name: "airlineFight",
        props:['flight']
    }
</script>

<style scoped>

</style>