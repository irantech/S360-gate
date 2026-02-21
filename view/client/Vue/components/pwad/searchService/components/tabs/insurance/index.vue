<template>
  <div>
    <div class="row">
      <form method="post" class="d_contents" id="gds_bus" name="gds_bus">
        <div class="col-lg-2 col-md-12 col-12 col_search">
          <div class="form-group">
            <div
              @click="openPanel('')"
              class="fake-input align-content-center font-11 text-muted align-items-center d-flex form-control inp_flight p-3-5">
              <span class="far fa-location" :class="`${getLang() == 'en' ? 'mr-2' : 'ml-2'}`"></span>
              <span v-if="form[index_data.strategy].origin.title">
                {{ form[index_data.strategy].origin.title }}
              </span>
              <span v-else>نام کشور مقصد</span>
            </div>

            <app-loading-spinner
              class="loading-spinner-holder"
              :loading="loading.origin"></app-loading-spinner>
          </div>
        </div>

        <div
          class="col-lg-2 position-unset col-md-12 col-sm-12 col-12 col_search">
          <passenger-count-box
            :form="form"
            :strategy="index_data.strategy"></passenger-count-box>
        </div>

        <div
          v-if="form[index_data.strategy].passengers.count"
          v-for="(item, key) in parseInt(
            form[index_data.strategy].passengers.count
          )"
          class="col-lg-2 col-md-12 col-12 col_search date_search">
          <div class="form-group">
            <template>
              <date_picker
                popover
                :placeholder="'تاریخ تولد ' + (key + 1)"
                :locale="form.lang_datepicker"
                :auto-submit="true"
                v-model="form[index_data.strategy].passengers.birth_dates[key]"
                :max="dateNow('-')"
                :format="form.format_datepicker"
                popover="bottom-right" />
            </template>
          </div>
        </div>

        <div class="col-lg-2 col-md-12 col-12 btn_s col_search">
          <button
            type="button"
            class="btn theme-btn seub-btn b-0 site-bg-main-color"
            @click="searchInit">
            <span>جستجو</span>
          </button>
          <app-loading-spinner
            class="loading-spinner-holder"
            :loading="loading.form"></app-loading-spinner>
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
        origin: false,
      },
      index_data: {
        key: "insurance",
        title: "بیمه",
        strategy: "local",
      },

      form: {
        local: {
          origin: {
            title: null,
            value: null,
          },
          duration: null,
          passengers: {
            count: 1,
            max: 9,
            min: 1,
            birth_dates: [],
          },
          options:{
            passengers:false
          }
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

    async openPanel() {
      this.loading.origin = true
      await this.$store.dispatch("pwaGetDefaultCities", {
        index: this.index_data.key,
        strategy: this.index_data.strategy,
      })

      await this.$store.commit("setPwaDefaultStatus", true)
      this.loading.origin = false
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
      let duration_value = fetch_form.duration
      let passenger = fetch_form.passengers
      let passenger_birth_dates = []
      let result_passenger_birth_dates = ""

      for (let value in parseInt(passenger.count)) {
        // console.log('key',key)
      }



      for (let item in passenger_birth_dates) {
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
          title: "مبداء را انتخاب کنید.",
        })
      }
      if (parseInt(passenger.count) < 1) {
        status = false
        this.$swal({
          icon: "error",
          toast: true,
          position: "bottom",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 4000,
          title: "حداقل یک نفر را اضافه کنید",
        })
      }
      if (duration_value === null) {
        status = false
        this.$swal({
          icon: "error",
          toast: true,
          position: "bottom",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 4000,
          title: "مدت سفر خود را وارد کنید",
        })
      }

      for (let i = 0; i < parseInt(passenger.count); i++) {
        if (passenger.birth_dates[i]) {
          console.log(passenger.birth_dates[i])
          passenger_birth_dates[i] = passenger.birth_dates[i]
          result_passenger_birth_dates += passenger_birth_dates[i] + "/"
        } else {
          status = false
          this.$swal({
            icon: "error",
            toast: true,
            position: "bottom",
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 4000,
            title: "تاریخ های تولد را تکمیل کنید.",
          })
          break
        }
      }

      // https://s360online.iran-tech.com/gds/fa/resultInsurance/2/AZE/5/1/1400-12-08/
      if (status) {
        this.loading.form = true

        let url =
          this.main_url +
          "/" +
          "resultInsurance" +
          "/" +
          "2" +
          "/" +
          origin_value +
          "/" +
          duration_value +
          "/" +
          parseInt(passenger.count) +
          "/" +
          result_passenger_birth_dates

        console.log(url)
        window.location.href = url
      }
    },
    modifyNewPassengerIndex() {
      let passenger = this.form[this.index_data.strategy].passengers
      let count = passenger.count
      for (let each_item in count) {
        passenger.birth_dates[each_item] = null
      }
    },
  },
  watch: {
    "current_panel_data.selected_origin": {
      handler: function (after, before) {
        if (after) {
          if (after.value) {
            this.form.local.options.passengers=true
          }
        }
      },
      deep: true,
      immediate: true,
    },
  },
}
</script>
