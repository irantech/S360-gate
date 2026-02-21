<template>
  <form class="d-contents row">
    <div class="col-lg-2 col-md-12 col-12 col_search">
      <div class="form-group">
        <!--        @click="callOpenPanel('origin_country')"-->
        <div
          class="fake-input align-content-center font-11 text-muted align-items-center d-flex form-control inp_flight p-3-5">
          <span class="far fa-location" :class="`${getLang() == 'en' ? 'mr-2' : 'ml-2'}`"></span>
          <span class='text-muted' v-if="form[index_data.strategy].origin.country.title">
            {{ getLang() == 'fa' ?   form[index_data.strategy].origin.country.title : 'iran'}}
          </span>
          <span v-else>{{ useXmltag('Origincountry') }}</span>
        </div>
      </div>
    </div>

    <div class="col-lg-2 col-md-12 col-12 col_search">
      <div class="form-group">
        <div
          @click="callOpenPanel('origin_city')"
          class="fake-input align-content-center font-11 text-muted align-items-center d-flex form-control inp_flight p-3-5">
          <span class="far fa-location" :class="`${getLang() == 'en' ? 'mr-2' : 'ml-2'}`"></span>
          <span v-if="form[index_data.strategy].origin.city.title || form[index_data.strategy].origin.city.title_en">
            {{ getLang() == 'fa' ?  form[index_data.strategy].origin.city.title : form[index_data.strategy].origin.city.title_en }}
          </span>
          <span v-else> {{ useXmltag('Origincity') }}</span>
        </div>

        <app-loading-spinner
          :class="`${getLang() == 'en' ? 'loading-spinner-holder-en' : 'loading-spinner-holder'}`"
          :loading="loading.origin.city"></app-loading-spinner>
      </div>
    </div>

    <div class="col-lg-2 col-md-12 col-12 col_search">
      <div class="form-group">
        <div
          @click="callOpenPanel('destination_country')"
          class="fake-input align-content-center font-11 text-muted align-items-center d-flex form-control inp_flight p-3-5">
          <span class="far fa-location" :class="`${getLang() == 'en' ? 'mr-2' : 'ml-2'}`"></span>
          <span v-if="form[index_data.strategy].destination.country.title || form[index_data.strategy].destination.country.title_en">
            {{getLang() == 'fa' ?  form[index_data.strategy].destination.country.title :form[index_data.strategy].destination.country.title_en }}
          </span>
          <span v-else>{{ useXmltag('Destinationcountry') }}</span>
        </div>

        <app-loading-spinner
          :class="`${getLang() == 'en' ? 'loading-spinner-holder-en' : 'loading-spinner-holder'}`"
          :loading="loading.destination.country"></app-loading-spinner>
      </div>
    </div>

    <div class="col-lg-2 col-md-12 col-12 col_search">
      <div class="form-group">
        <div
          @click="callOpenPanel('destination_city')"
          class="fake-input align-content-center font-11 text-muted align-items-center d-flex form-control inp_flight p-3-5">
          <span class="far fa-location" :class="`${getLang() == 'en' ? 'mr-2' : 'ml-2'}`"></span>
          <span v-if="form[index_data.strategy].destination.city.title || form[index_data.strategy].destination.city.title_en">
            {{getLang() == 'fa' ? form[index_data.strategy].destination.city.title : form[index_data.strategy].destination.city.title_en}}
          </span>
          <span v-else>{{ useXmltag('Destinationcity') }}</span>
        </div>

        <app-loading-spinner
          :class="`${getLang() == 'en' ? 'loading-spinner-holder-en' : 'loading-spinner-holder'}`"
          :loading="loading.destination.city"></app-loading-spinner>
      </div>
    </div>

    <div class="col-lg-2 col-md-12 col-12 col_search date_search">
      <div class="form-group">
        <template>
          <date_picker
            :placeholder="`${useXmltag('Wentdate')}`"
            ref="datepicker"
            :auto-submit="true"
            :locale="form.lang_datepicker"
            type="month"
            popover="bottom-right"
            :format="form.format_datepicker"
            :min="dateNow('-')"
            v-model="form[index_data.strategy].departure"
          />

          <!--

            :max="dateNow('-', 2)"


            -->
        </template>
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
        destination: {
          country: false,
          city: false,
        },
        origin: {
          country: false,
          city: false,
        },
      },
    }
  },
  methods: {
    callOpenPanel(spot) {
      let data = {
        strategy: this.index_data.strategy,
        spot: spot,
      }
      if (spot === "origin_city") {
        this.loading.origin.city = true
        console.log('this.form[this.index_data.strategy].origin.country',this.form[this.index_data.strategy].origin.country)
        data["conditions"] = {
          origin_country: {
            country:this.form[this.index_data.strategy].origin.country
          }
        }
      }
      if (spot === "destination_country") {
        this.loading.destination.country = true
        data["conditions"] = {
          origin_city: this.form[this.index_data.strategy].origin,
        }
      }
      if (spot === "destination_city") {
        this.loading.destination.city = true
        data["conditions"] = {
          destination_country: this.form[this.index_data.strategy].destination,
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

      // https://s360online.iran-tech.com/gds/fa/resultTourLocal/1-all/12-all/1400-12-08/all
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
          title: useXmltag('ChooseDepartureDate'),
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
          title: useXmltag('ChooseDestination'),
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
          title: useXmltag('ChooseOrigin'),
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
            this.loading.origin.city = false
            this.loading.destination.country = false
            this.loading.destination.city = false
          }, 100)
        }
      },
      deep: true,
    },
    "current_panel_data.selected_origin": {
      handler: function (after, before) {
        if (after) {
          if (after.city.value) {
            this.callOpenPanel('destination_country')
          }
        }
      },
      deep: true,
      immediate: true,
    },
    "current_panel_data.selected_destination": {
      handler: async function (after, before) {
        if (after) {

          if (after.city.value) {
            this.$refs.datepicker.focus()
          }
        }
      },
      deep: true,
      immediate: true,
    },
    "form.external.destination.country.value": {
      handler: async function (after, before) {
        if (after) {

          if (after) {
            setTimeout(() => {
              this.callOpenPanel('destination_city')
            }, 300)


          }
        }
      },
      deep: true,
      immediate: true,
    },
  },
}
</script>
