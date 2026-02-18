<template>
    <div class="international-available-airlines-info ">
        <div class="airlines-info txtLeft origin-city">
       <span class="open city-name-flight">
          {{ each_airline_flight.departure.departure_city}}
       </span>
            <span class="openB airport-name-flight">
           {{ each_airline_flight.departure.departure_airport}}
            </span>
            <div class="date-time">
            <span class="time-flight">
                {{ each_airline_flight.departure_time }}
            </span>
            </div>

        </div>
        <div class="airlines-info">
            <div class="airlines-info-inner">
<!--                <span class="iranL txt12">-->
<!--                    {{ each_airline_flight.duration_time}}-->
<!--                </span>-->
                <div class="airline-line">
                    <div class="loc-icon">
                        <span v-html="icon_svg_info_output_flight_1"></span>
                    </div>

                    <div class="plane-icon">
                        <span v-html="icon_svg_info_output_flight_2"></span>
                    </div>

                    <div class="loc-icon-destination">
                        <span v-html="icon_svg_info_output_flight_3"></span>
                    </div>

                </div>
<!--                <span class="tavaghof iranL txt13" >-->
<!--                     {{ each_airline_flight.departure_date}}-->
<!--                </span>-->
                <span class="source" style="color: white">{{ each_airline_flight.source_name}}</span>
            </div>
        </div>

        <div class="airlines-info txtRight origin-city">

        <span class="open city-name-flight">
           {{ each_airline_flight.arrival.arrival_city}}
        </span>
            <span class="openB airport-name-flight">
                {{ each_airline_flight.arrival.arrival_airport}}
            </span>
            <div class="date-time">
                <span class="time-flight">
                    {{ each_airline_flight.arrival_time }}
                </span>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "infoOutPutFlight",
        props: ['each_airline_flight', 'key_each_airline_flight'],
        data() {
            return {
                icon_svg_info_output_flight_1: `<svg id="Capa_1" viewBox="0 0 24 24" width="20px" height="20px" fill="currentColor" data-v-5483aaca=""><path d="M.601 12.008c0 .929.297 1.545 1.003 1.857.392.172.802.226 1.46.22l.362-.009 5.656-.24.26.368.326.493.42.659.87 1.41 1.573 2.626 1.678 2.855a2.204 2.204 0 0 0 1.858 1.155.9.9 0 0 0 .878-1.198l-3.018-8.582c-.008-.021-.002-.03.006-.03l6.447-.29.79 2.114.035.13c.257.593.77.862 1.287.761.61-.12 1.008-.711.889-1.322l-.005-.09.009-5.947c.05-.488-.338-1.007-.9-1.12-.546-.107-1.029.189-1.246.665l-.832 2.22-6.446-.29a.013.013 0 0 1-.011-.017l3.179-8.595a.9.9 0 0 0-.92-1.209l-.161.014c-.69.02-1.352.4-1.754 1.013L12.426 4.8l-1.21 2.02-.8 1.308-.54.86-.45.693-.238.347-.107.149-5.602-.264h-.623l-.16.007-.206.016c-1.287.127-1.889.767-1.889 2.072Z" fill-rule="evenodd"></path></svg>`,
                icon_svg_info_output_flight_2: `<svg id="Capa_1" viewBox="0 0 24 24" width="20px" height="20px" fill="currentColor" data-v-5483aaca=""><path d="M.601 12.008c0 .929.297 1.545 1.003 1.857.392.172.802.226 1.46.22l.362-.009 5.656-.24.26.368.326.493.42.659.87 1.41 1.573 2.626 1.678 2.855a2.204 2.204 0 0 0 1.858 1.155.9.9 0 0 0 .878-1.198l-3.018-8.582c-.008-.021-.002-.03.006-.03l6.447-.29.79 2.114.035.13c.257.593.77.862 1.287.761.61-.12 1.008-.711.889-1.322l-.005-.09.009-5.947c.05-.488-.338-1.007-.9-1.12-.546-.107-1.029.189-1.246.665l-.832 2.22-6.446-.29a.013.013 0 0 1-.011-.017l3.179-8.595a.9.9 0 0 0-.92-1.209l-.161.014c-.69.02-1.352.4-1.754 1.013L12.426 4.8l-1.21 2.02-.8 1.308-.54.86-.45.693-.238.347-.107.149-5.602-.264h-.623l-.16.007-.206.016c-1.287.127-1.889.767-1.889 2.072Z" fill-rule="evenodd"></path></svg>`,
                icon_svg_info_output_flight_3: `<svg version="1.1" class="site-main-text-color" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"> <g> <g> <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035 c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719 c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"/> </g> </g> </svg>`,
            }
        }
    }
</script>

<style scoped>

</style>