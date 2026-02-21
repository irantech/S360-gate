<template>
  <div class="card_search" :class="panel_data.status ? 'opening' : ''">
    <div class="a-card__header">
      <div class="d-flex align-items-center py-3 px-2">
        <button @click="closePanel()" class="btn close-in" type="button">
          <i class="fas" :class="`${getLang() == 'en' ? 'fa-long-arrow-left' : 'fa-long-arrow-right'}`"></i>
        </button>
        <span :class="`${getLang() == 'en' ? 'ml-4' : 'mr-4'}`">
          {{ index_data.title }}
        </span>
      </div>
    </div>

    <div class="body-search p-3">
      <template v-if="index_data.key === 'flight'">
        <local-flight-popup
          v-if="panel_data[index_data.key].strategy === 'local'"
          :panel_data="panel_data"
          :index_data="index_data"></local-flight-popup>
        <external-flight-popup
          v-else-if="panel_data[index_data.key].strategy === 'external'"
          :panel_data="panel_data"
          :index_data="index_data"></external-flight-popup>
      </template>

      <template v-if="index_data.key === 'tour'">
        <local-origin-tour-popup
          v-if="
            panel_data[index_data.key].strategy === 'local' &&
            panel_data[index_data.key].spot === 'origin_city'
          "
          :panel_data="panel_data"
          :index_data="index_data"></local-origin-tour-popup>

        <local-destination-tour-popup
          v-if="
            panel_data[index_data.key].strategy === 'local' &&
            panel_data[index_data.key].spot === 'destination_city'
          "
          :panel_data="panel_data"
          :index_data="index_data"></local-destination-tour-popup>

        <external-origin-tour-popup
          v-if="
            panel_data[index_data.key].strategy === 'external' &&
            panel_data[index_data.key].spot === 'origin_city'
          "
          :panel_data="panel_data"
          :index_data="index_data"></external-origin-tour-popup>

        <external-destination-tour-popup
          v-if="
            panel_data[index_data.key].strategy === 'external' &&
            (panel_data[index_data.key].spot === 'destination_country' ||
              panel_data[index_data.key].spot === 'destination_city')
          "
          :current_panel_data="current_panel_data"
          :panel_data="panel_data"
          :form="form"
          :index_data="index_data"></external-destination-tour-popup>
      </template>

      <template v-if="index_data.key === 'train'">
        <local-train-popup
          v-if="panel_data[index_data.key].strategy === 'local'"
          :panel_data="panel_data"
          :index_data="index_data"></local-train-popup>
      </template>

      <template v-if="index_data.key === 'bus'">
        <local-bus-popup
          v-if="panel_data[index_data.key].strategy === 'local'"
          :panel_data="panel_data"
          :index_data="index_data"></local-bus-popup>
      </template>

      <template v-if="index_data.key === 'insurance'">
        <local-insurance-popup
          v-if="panel_data[index_data.key].strategy === 'local'"
          :panel_data="panel_data"
          :index_data="index_data"></local-insurance-popup>
      </template>

      <template v-if="index_data.key === 'visa'">
        <local-visa-popup
          v-if="panel_data[index_data.key].strategy === 'local'"
          :panel_data="panel_data"
          :index_data="index_data"></local-visa-popup>

        <type-visa-popup
          v-else-if="panel_data[index_data.key].strategy === 'type'"
          :panel_data="panel_data"
          :index_data="index_data"></type-visa-popup>
      </template>

      <template v-if="index_data.key === 'entertainment'">
        <destination-entertainment-popup
          v-if="panel_data[index_data.key].strategy === 'destination'"
          :panel_data="panel_data"
          :index_data="index_data"></destination-entertainment-popup>

        <category-entertainment-popup
          v-else-if="panel_data[index_data.key].strategy === 'category'"
          :panel_data="panel_data"
          :index_data="index_data"></category-entertainment-popup>
      </template>

      <template v-if="index_data.key === 'hotel'">
        <local-hotel-popup
          v-if="panel_data[index_data.key].strategy === 'local'"
          :panel_data="panel_data"
          :index_data="index_data"></local-hotel-popup>
        <external-hotel-popup
          v-if="panel_data[index_data.key].strategy === 'external'"
          :panel_data="panel_data"
          :index_data="index_data"></external-hotel-popup>
      </template>
    </div>
  </div>
</template>
<script>
import externalOriginTourPopup from "./tour/strategy/external_origin"
import externalDestinationTourPopup from "./tour/strategy/external_destination"
import localOriginTourPopup from "./tour/strategy/local_origin"
import localDestinationTourPopup from "./tour/strategy/local_destination"
import externalFlightPopup from "./flight/strategy/external"
import localFlightPopup from "./flight/strategy/local"
import localTrainPopup from "./train/strategy/local"
import localBusPopup from "./bus/strategy/local"
import localInsurancePopup from "./insurance/strategy/local"
import localVisaPopup from "./visa/strategy/local"
import typeVisaPopup from "./visa/strategy/type"
import destinationEntertainmentPopup from "./entertainment/strategy/destination"
import categoryEntertainmentPopup from "./entertainment/strategy/category"
import localHotelPopup from "./hotel/strategy/local"
import externalHotelPopup from "./hotel/strategy/external"

export default {
  props: ["index_data", "panel_data", "current_panel_data", "form"],
  components: {
    "external-origin-tour-popup": externalOriginTourPopup,
    "external-destination-tour-popup": externalDestinationTourPopup,
    "local-origin-tour-popup": localOriginTourPopup,
    "local-destination-tour-popup": localDestinationTourPopup,
    "local-flight-popup": localFlightPopup,
    "external-flight-popup": externalFlightPopup,
    "local-train-popup": localTrainPopup,
    "local-bus-popup": localBusPopup,
    "local-insurance-popup": localInsurancePopup,
    "local-visa-popup": localVisaPopup,
    "type-visa-popup": typeVisaPopup,
    "destination-entertainment-popup": destinationEntertainmentPopup,
    "category-entertainment-popup": categoryEntertainmentPopup,
    "local-hotel-popup": localHotelPopup,
    "external-hotel-popup": externalHotelPopup,
  },
  methods: {
    closePanel() {
      this.$store.dispatch("pwaClosePanel")
    },

  },

}
</script>
