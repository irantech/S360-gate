<template>
  <div>
    <div class="radios">
      <div class="switch">
        <input
          autocomplete="off"
          type="radio"
          class="switch-input"
          name="DOM_TripMode8"
          value="1"
          id="raftobar" />
        <label
          @click="changeStrategy('external')"
          for="raftobar"
          class="switch-label switch-label-on">
          خارجی</label
        >
        <input
          autocomplete="off"
          type="radio"
          class="switch-input"
          name="DOM_TripMode8"
          value="2"
          checked="checked"
          id="raft" />
        <label
          @click="changeStrategy('local')"
          checked=""
          for="raft"
          ref="btn_local"
          class="switch-label switch-label-off">
          داخلی</label
        >
        <span class="switch-selection site-bg-main-color"></span>
      </div>
    </div>

    <div v-if="index_data.strategy === 'local'" id="flight_dakheli" class="row">
      <strategy-local
        rel="awdawdawd"
        :main_url="main_url"
        :index_data="index_data"
        :form="form"
        :current_panel_data="current_panel_data"
        @openPanel="openPanel"></strategy-local>
    </div>

    <div v-if="index_data.strategy === 'external'" class="row">
      <strategy-external
        :main_url="main_url"
        :index_data="index_data"
        :form="form"
        :current_panel_data="current_panel_data"
        @openPanel="openPanel"></strategy-external>
    </div>

    <popup-city :panel_data="panel_data" :index_data="index_data"></popup-city>
  </div>
</template>
<script>
import popupCity from "../../popups/index"
import strategyLocal from "./strategy/local"
import strategyExternal from "./strategy/external"

export default {
  components: {
    "popup-city": popupCity,
    "strategy-local": strategyLocal,
    "strategy-external": strategyExternal,
  },
  props: ["main_url"],
  data() {
    return {
      index_data: {
        key: "flight",
        title: "پرواز",
        strategy: "local",
      },

      form: {
        local: {
          origin: {
            title: null,
            airport: null,
            value: null,
          },
          destination: {
            title: null,
            airport: null,
            value: null,
          },
          departure: null,
          return_date: null,
          passengers_number: {
            max: 9,
            adult: {
              value: 1,
              min: 1,
            },
            child: {
              value: 0,
              min: 0,
            },
            infant: {
              value: 0,
              min: 0,
            },
          },
          options: {
            round_trip: false,
            passengers_number: false,
          },
        },
        external: {
          origin: {
            title: null,
            airport: null,
            value: null,
          },
          destination: {
            title: null,
            airport: null,
            value: null,
          },
          departure: null,
          return_date: null,
          passengers_number: {
            max: 9,
            adult: {
              value: 1,
              min: 1,
            },
            child: {
              value: 0,
              min: 0,
            },
            infant: {
              value: 0,
              min: 0,
            },
          },
          options: {
            round_trip: false,
            passengers_number: false,
          },
        },
        format_datepicker: "jYYYY-jMM-jDD",
        lang_datepicker: "fa",
      },
    }
  },
  created() {
    // console.log('awd created');
    // this.$refs.btn_local.click()
  },
  computed: {
    panel_data() {
      console.log("panel_data", this.$store.state.panel_data)

      return this.$store.state.panel_data
    },
    current_panel_data() {
      this.updateForm()
      return this.$store.state.panel_data[this.index_data.key]
    },
  },
  methods: {
    updateForm() {
      let current_panel_data = this.panel_data[this.index_data.key]
      let panel_data_origin = current_panel_data.selected_origin
      let panel_data_destination = current_panel_data.selected_destination

      this.form[this.index_data.strategy].origin = panel_data_origin
      this.form[this.index_data.strategy].destination = panel_data_destination
    },
    /**
     * @param {string} strategy local|external
     */
    async openPanel(strategy) {
      this.$store.commit("setPwaDefaultStatus", true)
      await this.$store.dispatch("pwaGetDefaultCities", {
        index: this.index_data.key,
        strategy: strategy,
      })
    },
    async changeStrategy(strategy) {
      this.index_data.strategy = strategy
      this.form[strategy].destination = this.panel_data.city_template
      this.form[strategy].origin = this.panel_data.city_template
      await this.$store.dispatch("pwaChangeTab", {
        index: this.index_data.key,
        strategy: strategy,
      })
    },
  },
}
</script>
