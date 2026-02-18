<template>
  <form
    data-action="https://s360online.iran-tech.com/"
    method="post"
    class="d-contents"
    target="_blank">
    <div class="row">
      <div class="col-md-12 col-xs-12 col-sm-12 d-ceckboxs">
        <div class="cntr">
          <label
            @click="form[index_data.strategy].options.round_trip = false"
            for="rdo-1"
            class="btn-radio select_multiway">
            <input
              :checked="form[index_data.strategy].options.round_trip === false"
              type="radio"
              id="rdo-1"
              name="select-rb2"
              value="1" />
            <svg width="20px" height="20px" viewBox="0 0 20 20">
              <circle
                class="site-svg-path-color"
                cx="10"
                cy="10"
                r="9"></circle>
              <path
                d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
                class="inner"></path>
              <path
                d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
                class="outer"></path>
            </svg>
            <span>یک طرفه </span>
          </label>
          <label
            @click="form[index_data.strategy].options.round_trip = true"
            for="rdo-2"
            class="btn-radio select_multiway">
            <input
              :checked="form[index_data.strategy].options.round_trip === true"
              type="radio"
              id="rdo-2"
              name="select-rb2"
              value="2" />
            <svg width="20px" height="20px" viewBox="0 0 20 20">
              <circle cx="10" cy="10" r="9"></circle>
              <path
                d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
                class="inner"></path>
              <path
                d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
                class="outer"></path>
            </svg>
            <span>دو طرفه </span>
          </label>
        </div>
      </div>
      <div
        class="col-lg-2 col-md-12 col-12 col_search search_col col_with_route">
        <div class="form-group">
          <div
            @click="callOpenPanel()"
            class="fake-input align-content-center font-11 text-muted align-items-center d-flex form-control inp_flight p-3-5">
            <span class="far fa-location" :class="`${getLang() == 'en' ? 'mr-2' : 'ml-2'}`"></span>
            <span v-if="form[index_data.strategy].origin.title">
              {{ form[index_data.strategy].origin.title }} ({{
                form[index_data.strategy].origin.airport
              }}-{{ form[index_data.strategy].origin.value }})
            </span>
            <span v-else>مبدأ ( نام شهر یا فرودگاه )</span>
          </div>
        </div>
        <button
          @click="switchOriginDestination()"
          class="switch_routs"
          type="button"
          name="button">
          <i class="fas fa-exchange-alt site-main-text-color"></i>
        </button>
      </div>

      <div class="col-lg-2 col-md-12 col-12 col_search search_col">
        <div class="form-group">
          <div class="form-group">
            <div
              @click="callOpenPanel()"
              class="fake-input align-content-center font-11 text-muted align-items-center d-flex form-control inp_flight p-3-5">
              <span class="far fa-location" :class="`${getLang() == 'en' ? 'mr-2' : 'ml-2'}`"></span>
              <span v-if="form[index_data.strategy].destination.title">
                {{ form[index_data.strategy].destination.title }} ({{
                  form[index_data.strategy].destination.airport
                }}-{{ form[index_data.strategy].destination.value }})
              </span>
              <span v-else>مقصد ( نام شهر یا فرودگاه )</span>
            </div>
          </div>
          <input
            class=""
            type="hidden"
            value=""
            name="DestinationAirportPortal" />
        </div>
      </div>

      <div class="col-lg-4 col-md-12 col-12 col_search date_search">
        <div class="form-group">
          <template>
            <date_picker
              popover
              placeholder="تاریخ رفت"
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
              placeholder="تاریخ برگشت"
              ref='return_date'
              popover
              :disabled="!form[index_data.strategy].options.round_trip"
              :locale="form.lang_datepicker"
              :auto-submit="true"
              v-model="form[index_data.strategy].return_date"
              :min="form[index_data.strategy].departure"
              :format="form.format_datepicker"
              popover="bottom-right" />
          </template>
        </div>
      </div>
      <div class="col-lg-2 col-md-12 col-12 col_search">
        <passenger-count-box
          :form="form"
          :strategy="index_data.strategy"></passenger-count-box>
      </div>
      <div class="col-lg-2 col-md-12 col-12 btn_s col_search">
        <button
          type="button"
          @click="searchInit"
          class="btn theme-btn seub-btn b-0 site-bg-main-color">
          <span> جستجو </span>
        </button>
        <app-loading-spinner
          class="loading-spinner-holder"
          :loading="loading.form"></app-loading-spinner>
      </div>
    </div>
  </form>
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
      // https://s360online.iran-tech.com/gds/fa/international/1/IKA-NJF/1400-12-22/Y/2-0-0/
      let status = true
      let fetch_form = this.form[this.index_data.strategy]
      let round_trip = fetch_form.options.round_trip
      let result_round_trip = !round_trip ? "1" : "2"
      let origin_value = fetch_form.origin.value
      let destination_value = fetch_form.destination.value
      let departure_date = fetch_form.departure
      let return_date = fetch_form.return_date
      let result_date = !round_trip
        ? departure_date
        : departure_date + "&" + return_date
      let passengers = fetch_form.passengers_number
      let result_count =
        passengers.adult.value +
        "-" +
        passengers.child.value +
        "-" +
        passengers.infant.value

      if (round_trip && !return_date) {
        status = false
        this.$swal({
          icon: "error",
          toast: true,
          position: "bottom",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 4000,
          title: "تاریخ برگشت را انتخاب کنید.",
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
          title: "تاریخ رفت را انتخاب کنید.",
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
          title: "مقصد را انتخاب کنید.",
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
          title: "مبداء را انتخاب کنید.",
        })
      }
      if (status) {
        this.loading.form = true
        let url =
          this.main_url +
          "/" +
          "international" +
          "/" +
          result_round_trip +
          "/" +
          origin_value +
          "-" +
          destination_value +
          "/" +
          result_date +
          "/" +
          "Y" +
          "/" +
          result_count
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
    "form.external.departure": {
      handler: function (after, before) {
        if (after) {
          if(this.form.external.options.round_trip){
            this.$refs.return_date.focus()
          }else{
            this.form.external.options.passengers_number = true
          }
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
  },
}
</script>
