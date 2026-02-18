<template>
  <div class="card-flight-search">
    <div class="parent-data-ticket-search-flight col-lg-9 col-md-9 col-sm-12 col-12 p-0">
      <div class="parent-back-forth-search-flight">
        <div class="flight-number col-lg-1 col-md-2 col-sm-2 col-2 p-0">
          <img :src="`/gds/pic/airline/${flight.airline}.png`" alt="img-airline" class="tooltips" :data-tooltip="useXmltag('AirlineName')" data-tooltip-pos="up" data-tooltip-length="fit">
          <span>{{ flight.flight_number }}</span>
        </div>
        <div class="flight-origin col-lg-3 col-md-2 col-sm-2 col-2 p-0">
          <h2>{{ flight.departure_time }}</h2>
          <span> {{ flight.departure_name }}</span>
        </div>
        <div class="flight-dotted-line col-lg-6 col-md-6 col-sm-6 col-6 p-0">
          <span class="circle-flight-origin"></span>
          <span class="border-flight-search">
              <svg data-v-662bafff="" class="plan-search-flight-svg"  aria-hidden="true" focusable="false" data-prefix="far" data-icon="plane" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path class="" fill="currentColor" d="M576 256C576 305 502.1 336 464.2 336H382.2L282.4 496C276.4 506 266.4 512 254.4 512H189.5C179.5 512 169.5 508 163.5 500C157.6 492 155.6 480.1 158.6 471L201.5 336H152.5L113.6 388C107.6 396 98.61 400 88.62 400H31.7C22.72 400 12.73 396 6.74 388C.7485 380-1.248 370 1.747 360L31.7 256L.7488 152C-1.248 143 .7488 133 6.74 125C12.73 117 22.72 112 31.7 112H88.62C98.61 112 107.6 117 113.6 125L152.5 176H201.5L158.6 41C155.6 32 157.6 21 163.5 13C169.5 5 179.5 0 189.5 0H254.4C265.4 0 277.4 7 281.4 16L381.2 176H463.2C502.1 176 576 208 576 256H576zM527.1 256C525.1 246 489.1 224 463.2 224H355.3L245.4 48H211.5L266.4 224H128.6L80.63 160H53.67L81.63 256L53.67 352H80.63L128.6 288H266.4L211.5 464H245.4L355.3 288H463.2C490.1 288 526.1 267 527.1 256V256z"></path></svg>
          </span>
          <span class="circle-flight-destination"></span>
        </div>
        <div class="flight-destination col-lg-3 col-md-2 col-sm-2 col-2 p-0">
          <h2  v-if='flight.arrival_time'>{{ flight.arrival_time }}</h2>
          <span> {{ flight.arrival_name }}</span>
        </div>
        <div class="parent-time-trip" v-if='flight.duration_time'>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M138 0H298V48H242V97.4c43.4 5 82.8 23.3 113.8 50.9L385 119l17-17L435.9 136l-17 17-31 31c24 33.9 38.1 75.3 38.1 120c0 114.9-93.1 208-208 208S10 418.9 10 304C10 197.2 90.4 109.3 194 97.4V48H138V0zm80 464a160 160 0 1 0 0-320 160 160 0 1 0 0 320zm24-248V320v24H194V320 216 192h48v24z"/></svg>
          <span>
              {{ flight.duration_time }}
          </span>
        </div>
        <div class="number-remaining-seats"  v-if="flight.capacity > 0">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" ><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path class="fa-primary" d="M32 0C49.67 0 64 14.33 64 32V143.6C64 150.1 65.32 156.5 67.88 162.5L121.7 288H416C428.1 288 439.2 294.8 444.6 305.7C450 316.5 448.9 329.5 441.6 339.2L398.4 396.8C389.3 408.9 375.1 416 360 416H170.2C131.8 416 97.09 393.1 81.96 357.8L9.056 187.7C3.081 173.8 0 158.7 0 143.6V32C0 14.33 14.33 .0003 32 .0003V0z"/><path class="fa-secondary" d="M264 416V464H360C373.3 464 384 474.7 384 488C384 501.3 373.3 512 360 512H120C106.7 512 96 501.3 96 488C96 474.7 106.7 464 120 464H216V416H264zM80.53 192H320C337.7 192 352 206.3 352 224C352 241.7 337.7 256 320 256H107.1L80.53 192z"/></svg>
          <span>
               {{ flight.capacity }} {{useXmltag('Leftseat')}}
          </span>
        </div>
      </div>
      <div class="parent-ticket-type-tail-brand">
        <div class="tail-brand-flight-search">
          <img class="img-plan" src="images/dom.png" alt="img-plan">
        </div>
        <div class="ticket-type">
          <div>
            {{ flight.flight_type }}
          </div>
          <div>
            {{ flight.seat_class }}
          </div>
        </div>
      </div>
    </div>
    <price-flight class='parent-price-search-flight col-lg-3 col-md-3 col-sm-12 col-12 p-0' :flight='flight' @openFlightDetail='openDetail()' :show_detail='show_detail' :type="'domestic'"/>
    <flight-detail v-show='show_detail' :flight='flight' :type="'domestic'"/>
  </div>
</template>


<script>
import priceFlight from '../global/priceFlight'
import flightDetail from '../global/flightDetail'
export default  {
  name : 'flight' ,
  props : ['flight'] ,
  components: {
    'price-flight': priceFlight,
    'flight-detail' : flightDetail
  },
  data() {
    return {
      show_detail : false ,
      openDetailTitle : useXmltag('FlightDetail'),
      openDetailIcon : '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M362.7 203.9l-159.1 144c-6.125 5.469-15.31 5.469-21.44 0L21.29 203.9C14.73 197.1 14.2 187.9 20.1 181.3C26.38 174.4 36.5 174.5 42.73 180.1L192 314.5l149.3-134.4c6.594-5.877 16.69-5.361 22.62 1.188C369.8 187.9 369.3 197.1 362.7 203.9z"/></svg>',
    }
  },
  methods : {
    openDetail() {
      this.show_detail = !this.show_detail
    }
  }
}
</script>