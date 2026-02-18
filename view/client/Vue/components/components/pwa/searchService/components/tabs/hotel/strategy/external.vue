<template>
  <div class="w-100 row">
    <div class="col-lg-3 col-md-12 col-12 col_search search_col">
      <div class="form-group">
        <div
          @click="callOpenPanel()"
          class="fake-input align-content-center font-11 text-muted align-items-center d-flex form-control inp_flight p-3-5">
          <span class="far fa-location" :class="`${getLang() == 'en' ? 'mr-2' : 'ml-2'}`"></span>
          <span v-if="form[index_data.strategy].destination.DepartureCityFa || form[index_data.strategy].destination.DepartureCityEn">
            {{ getLang() == 'fa' ? form[index_data.strategy].destination.DepartureCityFa : form[index_data.strategy].destination.DepartureCityEn }}
          </span>
          <span v-else>{{ useXmltag('SelectDestinationCity')}}</span>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-12 col-12 col_search date_search">
      <div class="form-group">
        <template>
          <date_picker
            popover
            ref="datepicker"
            :placeholder="`${useXmltag('Enterdate')}`"
            :locale="form.lang_datepicker"
            :auto-submit="true"
            v-model="form[index_data.strategy].departure"
            :min="dateNow('-')"
            :format="form.format_datepicker"
            popover="bottom-right" />
        </template>
      </div>
      <div class="form-group">
        <template>
          <date_picker
            popover
            ref="datepicker_departure"
            :placeholder="`${useXmltag('Exitdate')}`"
            :disabled="!form[index_data.strategy].departure"
            :locale="form.lang_datepicker"
            :auto-submit="true"
            v-model="form[index_data.strategy].return_date"
            :min="form[index_data.strategy].departure"
            :format="form.format_datepicker"
            popover="bottom-right" />
        </template>
      </div>
    </div>

    <div class="col-lg-3 col-md-12 col-12 col_search">
      <passenger-count-box
        :form="form"
        :strategy="index_data.strategy"></passenger-count-box>
    </div>

    <div class="col-lg-2 col-md-12 col-12 btn_s col_search">
      <input type="hidden" name="nights" id="NightsForExternalHotelLocal" />
      <button
        @click="searchInit()"
        type="button"
        class="btn theme-btn seub-btn b-0 site-bg-main-color">
        <span>{{ useXmltag('Search') }}</span>
      </button>
      <app-loading-spinner
        :class="`${getLang() == 'en' ? 'loading-spinner-holder-en' : 'loading-spinner-holder'}`"
        :loading="loading.form"></app-loading-spinner>
    </div>
  </div>
</template>
<script>
import passengerCountBox from "./../addons/passengerCountBox/index"

export default {
  components: {
    "passenger-count-box": passengerCountBox,
  },
  name: "strategy-external",
  props: ["openPanel", "current_panel_data", "form", "main_url", "index_data"],
  data() {
    return {
      loading: {
        form: false,
      },
    }
  },
  computed: {
    difference() {
      let difference = this.convertJalaliToGregorian(
        this.form[this.index_data.strategy].return_date,
        this.form[this.index_data.strategy].departure
      )
      this.form[this.index_data.strategy].difference = difference
      return difference
    },
  },
  methods: {
    callOpenPanel() {
      this.$emit("openPanel", this.index_data.strategy)
    },
    switchOriginDestination() {
      let current_origin_panel_data = this.current_panel_data.selected_origin

      this.current_panel_data.selected_origin =
        this.current_panel_data.selected_destination

      this.current_panel_data.selected_destination = current_origin_panel_data
    },
    searchInit() {
      let status = true
      let fetch_form = this.form[this.index_data.strategy]
      let destination_country = fetch_form.destination.CountryEn.replace(
        /\s+/g,
        "-"
      ).toLowerCase()
      let destination_city = fetch_form.destination.DepartureCityEn.replace(
        /\s+/g,
        "-"
      ).toLowerCase()
      let departure_date = fetch_form.departure
      let return_date = fetch_form.return_date
      let difference_date = fetch_form.difference

      if (!difference_date) {
        difference_date = this.convertJalaliToGregorian(
          fetch_form.departure,
          fetch_form.return_date
        )
      }

      let passengers = fetch_form.passengers_number

      let room_result = ""
      for (let room in passengers.rooms) {
        room_result += "R:" + passengers.rooms[room].adult.value

        if (passengers.rooms[room].child.value > 0) {
          room_result += "-" + passengers.rooms[room].child.value + "-"
          let separator = ","
          for (let age in passengers.rooms[room].child.age) {
            let calculate_age = parseInt(age) + 1
            if (calculate_age >= passengers.rooms[room].child.age.length) {
              separator = ""
            }
            room_result +=
              passengers.rooms[room].child.age[age].value + separator
          }
        } else {
          room_result += "-0-0"
        }
      }

      if (!return_date) {
        status = false
        this.$swal({
          icon: "error",
          toast: true,
          position: "bottom",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 4000,
          title: useXmltag('ChooseArrivalDate'),
        })
      }
      if (!departure_date) {
        status = false
        this.$swal({
          icon: "error",
          toast: true,
          position: "bottom",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 4000,
          title:useXmltag('ChooseDepartureDate'),
        })
      }
      if (!destination_country) {
        status = false
        this.$swal({
          icon: "error",
          toast: true,
          position: "bottom",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 4000,
          title:  useXmltag('ChooseDestination'),
        })
      }
      // https://s360online.iran-tech.com/gds/fa/resultExternalHotel/germany/frankfurt-am-main/1400-12-24/1400-12-26/2/R:1-2-2,3R:2-3-6,10,12

      if (status) {
        this.loading.form = true
        let url =
          this.main_url +
          "/" +
          "resultExternalHotel" +
          "/" +
          destination_country +
          "/" +
          destination_city +
          "/" +
          departure_date +
          "/" +
          return_date +
          "/" +
          this.difference +
          "/" +
          room_result
        console.log(url)
        window.location.href = url
      }
    },
  },
  watch: {
    firstName: function (val) {
      this.fullName = val + " " + this.lastName
    },
    "form.external.departure": {
      handler: function (after, before) {
        if (after) {
          this.$refs.datepicker_departure.focus()
        }
      },
      deep: true,
      immediate: true,
    },
    "form.external.return_date": {
      handler: function (after, before) {
        if (after) {
          this.form.external.options.passengers_number = true
        }
      },
      deep: true,
      immediate: true,
    },
    "current_panel_data.selected_destination": {
      handler: function (after, before) {
        if (after) {
          if (after.DepartureCode) {
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
