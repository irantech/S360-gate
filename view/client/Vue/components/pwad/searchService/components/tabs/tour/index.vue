<template>
  <div>
    <div class="radios switches">
      <div class="switch">
        <input
          autocomplete="off"
          type="radio"
          class="switch-input"
          name="DOM_TripMode5"
          value="1"
          id="tour_l" />
        <label
          @click="changeStrategy('external')"
          for="tour_l"
          class="switch-label switch-label-on">
          خارجی</label
        >
        <input
          autocomplete="off"
          type="radio"
          class="switch-input"
          checked="checked"
          name="DOM_TripMode5"
          value="2"
          id="tour_f" />
        <label
          @click="changeStrategy('local')"
          checked
          for="tour_f"
          class="switch-label switch-label-off"
          >داخلی</label
        >
        <span class="switch-selection site-bg-main-color"></span>
      </div>
    </div>

    <div v-if="index_data.strategy === 'local'" id="tour_dakheli" class="row">
      <strategy-local
        :main_url="main_url"
        :index_data="index_data"
        :form="form"
        :current_panel_data="current_panel_data"
        :panel_data="panel_data"
        @openPanel="openPanel"></strategy-local>
    </div>

    <div v-if="index_data.strategy === 'external'" class="row">
      <strategy-external
        :main_url="main_url"
        :index_data="index_data"
        :form="form"
        :current_panel_data="current_panel_data"
        :panel_data="panel_data"
        @openPanel="openPanel"></strategy-external>
    </div>

    <popup-city
      :current_panel_data="current_panel_data"
      :form="form"
      :panel_data="panel_data"
      :index_data="index_data"></popup-city>
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
        key: "tour",
        title: "تور",
        strategy: "local",
      },

      form: {
        local: {
          origin: {
            country: {
              title: null,
              value: null,
            },
            city: {
              title: null,
              value: null,
            },
          },
          destination: {
            country: {
              title: null,
              value: null,
            },
            city: {
              title: null,
              value: null,
            },
          },
          departure: null,
        },
        external: {
          origin: {
            country: {
              title: null,
              value: null,
            },
            city: {
              title: null,
              value: null,
            },
          },
          destination: {
            country: {
              title: null,
              value: null,
            },
            city: {
              title: null,
              value: null,
            },
          },
          departure: null,
        },
        spot: "",
        format_datepicker: "jYYYY-jMM-jDD",
        lang_datepicker: "fa",
      },
    }
  },
  computed: {
    panel_data() {
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
     * @param {array} params strategy|spot
     */
    async openPanel(params) {
      await this.$store.dispatch("pwaGetDefaultCities", {
        index: this.index_data.key,
        strategy: params.strategy,
        conditions: params.conditions,
      })

      this.$store.commit("setPwaData", {
        index: this.index_data.key,
        data: {
          spot: params.spot,
        },
      })

      this.form.spot = params.spot

      await this.$store.commit("setPwaDefaultStatus", true)
    },
    async changeStrategy(strategy) {
      this.index_data.strategy = strategy
      await this.$store.dispatch("pwaChangeTab", {
        index: this.index_data.key,
        strategy: strategy,
      })
    },
  },
}
</script>
