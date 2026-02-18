<template>
    <div class="international-available-airlines-info ">
        <div class="airlines-info destination txtLeft"><span
                class="iranB txt18">{{flight.departure_name}}</span> <span
                class="iranM txt19 timeSortDep">{{ flight.departure_time}}</span></div>
        <div class="airlines-info">
            <div class="airlines-info-inner">
                <div class="airline-line">
                    <div class="loc-icon">
                        <i class="flat_circle site-bg-main-color "></i>
                    </div>
                    <div class="plane-icon">
                        <span v-html="svg1"></span>
                    </div>
                    <div class="loc-icon-destination">
                       <span v-html="svg2"></span>
                    </div>
                </div>
                <span class="flight-type iranB "> {{flight.flight_type}} </span>
                <span class="source" style="color: white;">{{flight.source_name}}</span>
            </div>
        </div>
        <div class="airlines-info destination txtRight">
            <span class="iranB txt18">{{flight.arrival_name}}</span>
            <span class="iranM txt19">{{flight.arrival_time}}</span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "outPutFlight",
        props: ['data_search', 'flight'],
        data() {
            return {
                svg1: `<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path d="M445.355,67.036l-0.391-0.392c-19.986-19.006-59.898,14.749-59.898,14.749l-72.463,57.049l-76.285-13.52c11.005-15.953,14.32-31.79,6.983-39.127c-9.503-9.503-33.263-1.15-53.068,18.655c-3.464,3.464-6.568,7.049-9.297,10.657l-58.574-10.381L83.346,137.97l159.044,72.979L140.427,334.152l-63.505-11.906l-16.083,16.06L173.696,451.16l16.058-16.082l-11.906-63.506l123.204-101.963l72.979,159.043l33.244-39.016l-10.381-58.574c3.609-2.729,7.193-5.832,10.658-9.297c19.805-19.805,28.158-43.564,18.656-53.066c-7.339-7.338-23.177-4.022-39.13,6.982l-13.52-76.284l57.049-72.464C430.607,126.934,464.363,87.021,445.355,67.036z"></path></svg>`,
                svg2:` <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px"
                             viewBox="0 0 512 512" xml:space="preserve" class="site-main-text-color"><g><g><path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"></path></g></g></svg>`,
            }
        }
    }
</script>

<style scoped>

</style>