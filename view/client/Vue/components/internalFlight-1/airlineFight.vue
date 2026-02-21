<template>
    <div class=" international-available-airlines">
        <div class="international-available-airlines-logo">
            <div>
                <div class="logo-airline-ico"></div>
            </div>
        </div>
        <div class="international-available-airlines-log-info  pt-2">
            <div class="esterdad-blit">
                    <span class="sandali-span2 iranL  text-dark">
                        <i class="font-chanhe "></i>
                        {{flight.airline_name}}

                    </span>
            </div>
        </div>
        <div class="international-available-airlines-log-info pt-2">
            <div class="esterdad-blit" v-if="flight.capacity > 0">
                <span class="sandali-span2 iranL sandali-span2-margin-right site-main-text-color">
                <i class="font-chanhe"></i>
                {{flight.capacity}} {{useXmltag('Chair')}}
                </span>
            </div>
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