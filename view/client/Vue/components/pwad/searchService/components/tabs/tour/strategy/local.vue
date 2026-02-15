<template>
  <form class="d-contents">
    <div class="col-lg-2 col-md-12 col-12 col_search search_col col_with_route">
      <div class="form-group origin_start">
        <div
          @click="callOpenPanel('origin_city')"
          class="fake-input align-content-center font-11 text-muted align-items-center d-flex form-control inp_flight p-3-5">
          <span class="far fa-location ml-2"></span>
          <span v-if="form[index_data.strategy].origin.city.title">
            {{ form[index_data.strategy].origin.city.title }}
          </span>
          <span v-else>مبدأ</span>
        </div>

        <app-loading-spinner
          class="loading-spinner-holder"
          :loading="loading.origin"></app-loading-spinner>
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
        <span class="destnition_start">
          <div
            @click="callOpenPanel('destination_city')"
            class="fake-input align-content-center font-11 text-muted align-items-center d-flex form-control inp_flight p-3-5">
            <span class="far fa-location ml-2"></span>
            <span v-if="form[index_data.strategy].destination.city.title">
              {{ form[index_data.strategy].destination.city.title }}
            </span>
            <span v-else>مقصد</span>
          </div>

          <app-loading-spinner
            class="loading-spinner-holder"
            :loading="loading.destination"></app-loading-spinner>
        </span>
      </div>
    </div>

    <div class="col-lg-2 col-md-12 col-12 col_search date_search">
      <div class="form-group">
        <template>
          <date_picker
            popover
            placeholder="تاریخ مسافرت"
            ref="datepicker"
            :locale="form.lang_datepicker"
            :auto-submit="true"
            v-model="form[index_data.strategy].departure"
            :min="dateNow('-')"
            :max="dateNow('-', 2)"
            type="month"
            :format="form.format_datepicker"
            popover="bottom-right" />
        </template>
      </div>
    </div>
    <div class="col-lg-2 col-md-12 col-12 btn_s col_search">
      <button
        type="button"
        @click="searchInit"
        class="btn theme-btn seub-btn b-0 site-bg-main-color">
        <span>جستجو</span>
      </button>
      <app-loading-spinner
        class="loading-spinner-holder"
        :loading="loading.form"></app-loading-spinner>
    </div>
  </form>
</template>
<script>
import passengerCountBox from "./../addons/passengerCountBox/index"

export default {
  components: {
    "passenger-count-box": passengerCountBox,
  },
  name: "strategy-local",
  props: [
    "openPanel",
    "current_panel_data",
    "panel_data",
    "form",
    "main_url",
    "index_data",
  ],
  data() {
    return {
      loading: {
        form: false,
        origin: false,
        destination: false,
      },
    }
  },
  methods: {
    async callOpenPanel(spot) {
      this.loading[spot] = true
      let data = {
        strategy: this.index_data.strategy,
        spot: spot,
      }

      if (spot === "destination_city") {
        data["conditions"] = {
          origin_city: this.form[this.index_data.strategy].origin,
        }
      }
      this.$emit("openPanel", data)
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
      let origin_city_value = fetch_form.origin.city.value
      let destination_city_value = fetch_form.destination.city.value
      let origin_country_value = fetch_form.origin.country.value
      let destination_country_value = fetch_form.destination.country.value
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
          title: "تاریخ رفت را انتخاب کنید.",
        })
      }
      if (!destination_city_value) {
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
      if (!origin_city_value) {
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
          "resultTourLocal" +
          "/" +
          origin_country_value +
          "-" +
          origin_city_value +
          "/" +
          destination_country_value +
          "-" +
          destination_city_value +
          "/" +
          departure_date +
          "/" +
          "all"

        console.log(url)
        window.location.href = url
      }
    },
  },
  watch: {
    "panel_data.status": {
      handler: function (after, before) {
        if (after) {
          setTimeout(() => {
            this.loading.origin = false
            this.loading.destination = false
          }, 100)
        }
      },
      deep: true,
    },

    "current_panel_data.selected_origin": {
      handler: function (after, before) {
        if (after) {
          if (after.city.value) {
            this.callOpenPanel('destination_city')
          }
        }
      },
      deep: true,
      immediate: true,
    },
    "current_panel_data.selected_destination": {
      handler: function (after, before) {
        if (after) {
          if (after.city.value) {
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
