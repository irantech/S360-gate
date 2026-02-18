<template>
  <div class="w-100">
    <div class="row">
      <form method="post" class="d_contents w-100" id="gds_bus" name="gds_bus">
        <div class='row'>
          <div class="col-lg-3 col-md-12 col-12 col_search">
            <div class="form-group">
              <div
                @click="openPanel('origin')"
                class="fake-input align-content-center font-11 text-muted align-items-center d-flex form-control inp_flight p-3-5">
                <span class="far fa-location " :class="`${getLang() == 'en' ? 'mr-2' : 'ml-2'}`"></span>
                <span v-if="form[index_data.strategy].origin.title">
                {{ form[index_data.strategy].origin.title }}
              </span>
                <span v-else> {{ useXmltag('cityrTrain')}}</span>
              </div>

              <app-loading-spinner
                class="loading-spinner-holder"
                :loading="loading.origin"></app-loading-spinner>
            </div>
          </div>

          <div class="col-lg-3 col-md-12 col-12 col_search">
            <div class="form-group">
              <div
                @click="openPanel('destination')"
                class="fake-input align-content-center font-11 text-muted align-items-center d-flex form-control inp_flight p-3-5">
                <span class="far fa-location" :class="`${getLang() == 'en' ? 'mr-2' : 'ml-2'}`"></span>
                <span v-if="form[index_data.strategy].destination.title">
                {{ form[index_data.strategy].destination.title }}
              </span>
                <span v-else>{{ useXmltag('DesOrTrain')}}</span>
              </div>

              <app-loading-spinner
                class="loading-spinner-holder"
                :loading="loading.destination"></app-loading-spinner>
            </div>
          </div>

          <div class="col-lg-3 col-md-12 col-12 col_search date_search2">
            <div class="form-group">
              <template>
                <date_picker
                  popover
                  :placeholder="`${useXmltag('dateMove')}`"
                  ref="datepicker"
                  :locale="form.lang_datepicker"
                  :auto-submit="true"
                  v-model="form[index_data.strategy].departure"
                  :min="dateNow('-')"
                  :format="form.format_datepicker"
                  popover="bottom-right" />
              </template>
            </div>
          </div>

          <div class="col-lg-3 col-md-12 col-12 btn_s col_search">
            <button
              type="button"
              class="btn theme-btn seub-btn b-0 site-bg-main-color"
              @click="searchInit">
              <span>{{ useXmltag('Search')}}</span>
            </button>
            <app-loading-spinner
              class="loading-spinner-holder"
              :loading="loading.form"></app-loading-spinner>
          </div>
        </div>

      </form>
    </div>
    <popup-city
      :current_panel_data="current_panel_data"
      :form="form"
      :panel_data="panel_data"
      :index_data="index_data"></popup-city>
  </div>
</template>
<script>
import passengerCountBox from "./addons/passengerCountBox/index"
import popupCity from "../../popups/index"

export default {
  components: {
    "passenger-count-box": passengerCountBox,
    "popup-city": popupCity,
  },
  props: ["main_url"],
  data() {
    return {
      loading: {
        form: false,
        destination: false,
        origin: false,
      },
      index_data: {
        key: "bus",
        title: useXmltag('Bus'),
        strategy: "local",
      },

      form: {
        local: {
          origin: {
            title: null,
            value: null,
          },
          destination: {
            title: null,
            value: null,
          },
          departure: null,
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
    switchOriginDestination() {
      let current_origin_panel_data = this.current_panel_data.selected_origin

      this.current_panel_data.selected_origin =
        this.current_panel_data.selected_destination

      this.current_panel_data.selected_destination = current_origin_panel_data
    },

    async openPanel(spot) {
      this.loading[spot] = true
      await this.$store.dispatch("pwaGetDefaultCities", {
        index: this.index_data.key,
        strategy: this.index_data.strategy,
      })

      await this.$store.commit("setPwaDefaultStatus", true)
      this.loading[spot] = false
    },
    async changeStrategy(strategy) {
      this.index_data.strategy = strategy
      await this.$store.dispatch("pwaChangeTab", {
        index: this.index_data.key,
        strategy: strategy,
      })
    },
    searchInit() {
      let status = true
      let fetch_form = this.form[this.index_data.strategy]
      let origin_value = fetch_form.origin.value
      let destination_value = fetch_form.destination.value
      let departure_date = fetch_form.departure

      if (!departure_date) {
        status = false
        this.$swal({
          icon: "error",
          toast: true,
          position: "bottom",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 4000,
          title: useXmltag('ChooseGoDate'),
        })
      }
      if (!destination_value) {
        status = false
        this.$swal({
          icon: "error",
          toast: true,
          position: "bottom",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 4000,
          title: useXmltag('ChooseDestination'),
        })
      }
      if (!origin_value) {
        status = false
        this.$swal({
          icon: "error",
          toast: true,
          position: "bottom",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 4000,
          title: useXmltag('ChooseOrigin'),
        })
      }
      // https://s360online.iran-tech.com/gds/fa/buses/THR-MHD/1401-01-06
      if (status) {
        this.loading.form = true
        let url =
          this.main_url +
          "/" +
          "buses" +
          "/" +
          origin_value +
          "-" +
          destination_value +
          "/" +
          departure_date

        console.log(url)
        window.location.href = url
      }
    },
  },
  watch: {
    "current_panel_data.selected_destination": {
      handler: function (after, before) {
        if (after) {
          if (after.value) {
            this.$refs.datepicker.focus()
          }
        }
      },
      deep: true,
      immediate: true,
    },
  },
}
</script>
