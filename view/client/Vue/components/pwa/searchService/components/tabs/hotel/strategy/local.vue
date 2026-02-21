<template>
  <div class="w-100 row">
    <div class="col-lg-3 col-md-12 col-12 col_search search_col">
      <div class="form-group">
        <div
          @click="callOpenPanel()"
          class="fake-input align-content-center font-11 text-muted align-items-center d-flex form-control inp_flight p-3-5">
          <span class="far fa-location" :class="`${getLang() == 'en' ? 'mr-2' : 'ml-2'}`"></span>
          <span v-if="form[index_data.strategy].destination.CityName || form[index_data.strategy].destination.CityNameEn">
            {{ getLang() == 'fa' ?  form[index_data.strategy].destination.CityName : form[index_data.strategy].destination.CityNameEn }}
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
            :placeholder="`${useXmltag('Enterdate')}`"
            ref="datepicker"
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
            :placeholder="`${useXmltag('Exitdate')}`"
            ref="datepicker_departure"
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
      <div class="days-in-hotel">
        <input
          type="hidden"
          id="NightsForHotelLocal"
          name="NightsForHotelLocal"
          v-model="form[index_data.strategy].difference" />


          <i class="fal fa-moon"></i> {{ useXmltag('Stayigtime') }}
          <div class="result-st">
            <em class="days" id="stayingTimeForHotelLocal mx-1"> {{ difference }} </em>
            {{ useXmltag('Night') }}
          </div>

      </div>
    </div>

    <div class="col-lg-2 col-md-12 col-12 btn_s col_search">
      <button
        type="button"
        @click="searchInit"
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
  name: "strategy-local",
  props: ["openPanel", "current_panel_data", "form", "main_url", "index_data"],
  data() {
    return {
      loading: {
        form: false,
      },
    }
  },
  watch: {
    firstName: function (val) {
      this.fullName = val + " " + this.lastName
    },
    "form.local.departure": {
      handler: function (after, before) {
        if (after) {
          this.$refs.datepicker_departure.focus()
        }
      },
      deep: true,
      immediate: true,
    },
    "current_panel_data.selected_destination": {
      handler: function (after, before) {
        if (after) {
          if (after.CityId) {
            this.$refs.datepicker.focus()
          }
        }
      },
      deep: true,
      immediate: true,
    },
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
      let destination = fetch_form.destination
      let destination_value
      let departure_date = fetch_form.departure
      let return_date = fetch_form.return_date
      let difference_date = fetch_form.difference

      if (!return_date) {
        status = false
        this.$swal({
          icon: "error",
          toast: true,
          position: "bottom",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 4000,
          title: useXmltag('ChooseArrivalDate') ,
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
          title: useXmltag('ChooseDepartureDate'),
        })
      }
      if (!destination) {
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
      // https://s360online.iran-tech.com/gds/fa/searchHotel/1/1400-12-23/6
      if (status) {
        this.loading.form = true
        let url
        if (destination) {
          if (destination.index_name === "Cities") {
            destination_value = destination.CityId

            url =
              this.main_url +
              "/" +
              "searchHotel" +
              "/" +
              destination_value +
              "/" +
              departure_date +
              "/" +
              difference_date
          }
          if (destination.index_name === "ReservationHotels") {
            destination_value = destination.HotelId

            url =
              this.main_url +
              "/" +
              "roomHotelLocal" +
              "/" +
              "reservation" +
              "/" +
              destination_value +
              "/" +
              destination.HotelNameEn
          }
          if (destination.index_name === "ApiHotels") {
            destination_value = destination.HotelId

            url =
              this.main_url +
              "/" +
              "detailHotel" +
              "/" +
              "api" +
              "/" +
              destination_value
          }
        }

        console.log(url)
        window.location.href = url
      }
    },
  },
}
</script>
