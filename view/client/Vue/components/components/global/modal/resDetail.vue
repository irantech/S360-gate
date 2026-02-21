<template>
  <div class="modal-flight modal-card" style='right:0 !important;'>
    <div class="parent-modal-flight">
      <div class="header-modal-flight">
        <h3>{{ useXmltag('Informationflight') }}</h3>
        <button @click="hideModal()">{{ useXmltag('JustReturn') }}</button>
      </div>
      <div class="body-modal-flight">
        <price-detail :flight='flight' :type='type'/>
      </div>
      <div class="footer-modal-flight" v-if="type == 'domestic'">
        <div class="modal-price">
          <detail-price :flight='flight' />
        </div>
        <button type="button" v-if="flight.source_id=='special'"
                :id="`btnReservationFlight_${flight.flight_id}`"
                @click="sendInfoReservationFlightForeign(`${flight.flight_id}`)">
          <span>{{useXmltag('Selectionflight')}}</span>
        </button>
        <button v-else type="button"  :id="`select${this.$store.state.typeTripFlight}`"
                :class='{"skeleton":is_show_loader}'
                :disabled='is_show_loader'
                @click="changeTripFlight(flight.capacity)">
          <template v-if="dataSearch.MultiWay==='TwoWay'">
            <template v-if="this.$store.state.typeTripFlight === 'dept'">
              {{useXmltag('PickWentFlight')}}
            </template>
            <template v-else>
              {{useXmltag('PickBackFlight')}}
            </template>
          </template>
          <template v-else>
            {{useXmltag('Selectionflight')}}
          </template>
        </button>

        <input type="hidden" :value="dataSearch.adult" id="CountAdult" class="CountAdult">
        <input type="hidden" :value="dataSearch.child" id="CountChild" class="CountChild">
        <input type="hidden" :value="dataSearch.infant" id="CountInfant" class="CountInfant">
        <input type="hidden" value="" name="session_filght_Id" id="session_filght_Id">
        <input type="hidden" value="reservation" id="typeApplication" class="typeApplication" v-if="flight.source_id=='special'">
        <input type="hidden" value="privateCharter" id="PrivateCharter" class="PrivateCharter" v-if="flight.source_id=='special'">
        <input type="hidden" :value="flight.flight_id" id="IdPrivate" class="IdPrivate" v-if="flight.source_id=='special'">
        <input type="hidden" :value="flight.flight_id_return" id="flight_id_return" class="flight_id_return" v-if="flight.source_id=='special'">
      </div>
      <div class="footer-modal-flight" v-else>
        <div class="modal-price">
          <detail-price :flight='flight' />
        </div>
        <button type="button" v-if="flight.source_id=='special'"
        :id="`btnReservationFlight_${flight.flight_id}`"
        @click="sendInfoReservationFlightForeign(`${flight.flight_id}`)">
        <span>{{useXmltag('Selectionflight')}}</span>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
        </button>
        <button v-else-if="flight.return_route !=''" type="button"
                :id="`nextStep_${flight.flight_id.replace('#','')}`">
          {{useXmltag('Selectionflight')}}
        </button>
        <button v-else type="button"
                :id="`nextStep_${flight.flight_id.replace('#','')}${flight.return_routes.flight_id_return.replace('#','')}`">
          {{useXmltag('Selectionflight')}}
        </button>

        <input type="hidden" value="" name="session_filght_Id" id="session_filght_Id">
        <span class="f-loader-check f-loader-check-change"
              :id="`loader_check_${flight.flight_id.replace('#','')}`"
              style="display:none"></span>

        <input type="hidden" value="" class="CurrencyCode">
        <input type="hidden" :value="flight.flight_id" class="FlightID">
        <input type="hidden" :value="flight.return_routes.return_flight_id" class="ReturnFlightID">
        <input type="hidden" :value="price_adult" class="AdtPrice">
        <input type="hidden" :value="flight.price.child.price" class="ChdPrice">
        <input type="hidden" :value="flight.price.infant.price" class="InfPrice">
        <input type="hidden" :value="flight.cabin_type" class="CabinType">
        <input type="hidden" :value="flight.airline" id="Airline_Code" class="Airline_Code">
        <input type="hidden" :value="flight.source_id" id="SourceId" class="SourceId">
        <input type="hidden" :value="flight.flight_type_li" id="FlightType" class="FlightType">
        <input type="hidden" :value="flight.unique_code" id="uniqueCode" class="uniqueCode">
        <input type="hidden" :value="flight.capacity" id="Capacity" class="priceWithoutDiscount">
        <input type="hidden" :value="dataSearch.adult" id="CountAdult" class="CountAdult">
        <input type="hidden" :value="dataSearch.child" id="CountChild" class="CountChild">
        <input type="hidden" :value="dataSearch.infant" id="CountInfant" class="CountInfant">
        <input type="hidden" value="dept" class="FlightDirection">
        <input type="hidden" value="reservation" id="typeApplication" class="typeApplication"
               v-if="flight.source_id=='special'">
        <input type="hidden" value="privateCharter" id="PrivateCharter" class="PrivateCharter"
               v-if="flight.source_id=='window.innerWidthspecial'">
        <input type="hidden" :value="each_price_flight.flight_id" id="IdPrivate" class="IdPrivate"
               v-if="flight.source_id=='special'">
        <input type="hidden" :value="each_price_flight.flight_id_return" id="flight_id_return"
               class="flight_id_return" v-if="flight.source_id=='special'">
      </div>
    </div>
  </div>
</template>

<script>

import DetailPrice from '../detailPrice'
import PriceDetail from '../flightDetail'
export default {
  name: 'responsive-detail',
  components: {PriceDetail, DetailPrice},
  props:['flight' , 'type'],
  methods : {
    hideModal () {
      this.$emit('closeFilterModal')
    }
  } ,
  computed : {
    dataSearch() {
      return   this.$store.state.setDataSearch.dataSearch
    },
  }
}
</script>
