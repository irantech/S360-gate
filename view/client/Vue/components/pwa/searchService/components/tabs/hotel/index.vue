<template>
  <div>
    <div v-if="this.$store.state.pwa_page.active_service == null || (this.$store.state.pwa_page.active_service && this.$store.state.pwa_page.active_service.type == null)" class="radios switches">
      <div :class="['switch mt-2' , this.$store.state.pwa_page.client_id == 390 ? 'd-none' :  '']" v-if="service.which == 'both'">
        <input
          autocomplete="off"
          type="radio"
          class="switch-input"
          name="DOM_TripMode4"
          value="1"
          id="hotel_l" />
        <label
          @click="changeStrategy('external')"
          for="hotel_l"
          class="switch-label switch-label-on">
          {{ useXmltag('Foreign')}}</label
        >
        <input
          autocomplete="off"
          type="radio"
          class="switch-input"
          name="DOM_TripMode4"
          value="2"
          checked="checked"
          id="hotel_f" />
        <label
          @click="changeStrategy('local')"
          checked
          for="hotel_f"
          class="switch-label switch-label-off"
          >{{ useXmltag('Internal')}}</label
        >
        <span class="switch-selection site-bg-main-color"></span>
      </div>
    </div>

    <div v-if="index_data.strategy === 'local' && (service.which == 'both' || service.which == 'Local')" id="hotel_dakheli" class="row">
      <strategy-local
        :main_url="main_url"
        :index_data="index_data"
        :form="form"
        :current_panel_data="current_panel_data"
        @openPanel="openPanel"></strategy-local>
    </div>

    <div v-if="index_data.strategy === 'external' && (service.which == 'both' || service.which == 'Foreign')" class="row">
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
  props: ["main_url" , "service"],
  data() {
    return {
      index_data: {
        key: "hotel",
        title: useXmltag('Hotel'),
        strategy: "local",
      },

      form: {
        local: {
          destination: {
            country: {
              title: null,
              value: null,
            },
            city: {
              title: null,
              value: null,
            },
            hotel: {
              title: null,
              value: null,
            },
          },
          departure: null,
          return_date: null,
          difference: null,

          options: {
            passengers_number: false,
          },
        },
        external: {
          destination: {
            country: {
              title: null,
              value: null,
            },
            city: {
              title: null,
              value: null,
            },
            hotel: {
              title: null,
              value: null,
            },
          },
          departure: null,
          return_date: null,
          difference: null,
          passengers_number: {
            adult: {
              max: 6,
            },
            child: {
              max: 4,
            },
            rooms: [
              {
                adult: {
                  value: 1,
                },
                child: {
                  value: 0,
                  age: [],
                },
              },
            ],
          },
          options: {
            passengers_number: false,
          },
        },
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
  created(){
    if(this.getLang() != 'fa') {
      this.form.lang_datepicker = this.getLang();
    }
    if(this.service.which != 'both') {
      if(this.service.which == 'Local') {
        this.index_data.strategy = 'local'
      }else{
        this.index_data.strategy = 'external'
      }
    }
    if(this.$store.state.pwa_page.active_service != null) {
      if(this.$store.state.pwa_page.active_service.type) {
        this.index_data.strategy = this.$store.state.pwa_page.active_service.type
      }
    }
  }
}
</script>
