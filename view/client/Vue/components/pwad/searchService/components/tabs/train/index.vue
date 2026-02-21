<template>
   <div class="w-100">
      <div class="switches">
         <label
            @click="form[index_data.strategy].options.round_trip = false"
            for="rdo_train"
            class="btn-radio">
            <input
               :checked="form[index_data.strategy].options.round_trip === false"
               type="radio"
               id="rdo_train"
               name="DOM_TripMode_train"
               value="1"
               class="Oneway" />
            <svg width="20px" height="20px" viewBox="0 0 20 20">
               <circle
                  class="site-svg-path-color"
                  cx="10"
                  cy="10"
                  r="9"></circle>
               <path
                  d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
                  class="inner site-svg-path-color"></path>
               <path
                  d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
                  class="outer site-svg-path-color"></path>
            </svg>
            <span>یک طرفه </span>
         </label>

         <label
            @click="form[index_data.strategy].options.round_trip = true"
            for="rdo_train2"
            class="btn-radio">
            <input
               type="radio"
               :checked="form[index_data.strategy].options.round_trip === true"
               id="rdo_train2"
               name="DOM_TripMode_train"
               value="2"
               class="multiWays TwowayTrain" />
            <svg width="20px" height="20px" viewBox="0 0 20 20">
               <circle
                  class="site-svg-path-color"
                  cx="10"
                  cy="10"
                  r="9"></circle>
               <path
                  d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
                  class="inner site-svg-path-color"></path>
               <path
                  d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
                  class="outer site-svg-path-color"></path>
            </svg>
            <span>دو طرفه </span>
         </label>
      </div>

      <div class="row m-auto">
         <form
            class="d_contents w-100"
            method="post"
            name="gds_train"
            id="gds_train">
            <div class="col-lg-2 col-md-12 col-12 col_search">
               <div class="form-group origin_start">
                  <div
                     @click="openPanel('origin')"
                     class="fake-input align-content-center font-11 text-muted align-items-center d-flex form-control inp_flight p-3-5">
                     <span class="far fa-location ml-2"></span>
                     <span v-if="form[index_data.strategy].origin.title">
                        {{ form[index_data.strategy].origin.title }}
                     </span>
                     <span v-else>مبدأ ( نام شهر)</span>
                  </div>

                  <app-loading-spinner
                     class="loading-spinner-holder"
                     :loading="loading.origin"></app-loading-spinner>
               </div>
            </div>

            <div class="col-lg-2 col-md-12 col-12 col_search">
               <div class="form-group origin_start">
                  <div
                     @click="openPanel('destination')"
                     class="fake-input align-content-center font-11 text-muted align-items-center d-flex form-control inp_flight p-3-5">
                     <span class="far fa-location ml-2"></span>
                     <span v-if="form[index_data.strategy].destination.title">
                        {{ form[index_data.strategy].destination.title }}
                     </span>
                     <span v-else>مقصد ( نام شهر)</span>
                  </div>

                  <app-loading-spinner
                     class="loading-spinner-holder"
                     :loading="loading.destination"></app-loading-spinner>
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
                        popover
                        placeholder="تاریخ برگشت"
                        ref="datepicker_departure"
                        :disabled="
                           !form[index_data.strategy].options.round_trip
                        "
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
            key: "train",
            title: "قطار",
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
               return_date: null,
               passengers_number: {
                  max: 10,
                  adult: {
                     value: 1,
                  },
                  child: {
                     value: 0,
                  },
                  infant: {
                     value: 0,
                  },
                  seat_type: "default",
                  dedicated_coupe: false,
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
         this.form[this.index_data.strategy].destination =
            panel_data_destination
      },
      switchOriginDestination() {
         let current_origin_panel_data = this.current_panel_data.selected_origin

         this.current_panel_data.selected_origin =
            this.current_panel_data.selected_destination

         this.current_panel_data.selected_destination =
            current_origin_panel_data
      },

      async openPanel(spot) {
         this.loading[spot] = true
         await this.$store.dispatch("pwaGetDefaultCities", {
            index: this.index_data.key,
            strategy: this.index_data.strategy,
            conditions: {
               // type:destination
            },
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
         let round_trip = fetch_form.options.round_trip
         let seat_type = fetch_form.passengers_number.seat_type
         let result_seat_type
         switch (seat_type) {
            case "default":
               result_seat_type = "3"
               break
            case "men_only":
               result_seat_type = "1"
               break
            case "women_only":
               result_seat_type = "2"
               break
         }
         let dedicated_coupe = fetch_form.passengers_number.dedicated_coupe
         let result_dedicated_coupe = dedicated_coupe ? "1" : "0"
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
         // https://s360online.iran-tech.com/gds/fa/resultTrainApi/670-4/1400-12-20/1/3-2-1/1/
         if (status) {
            this.loading.form = true
            let url =
               this.main_url +
               "/" +
               "resultTrainApi" +
               "/" +
               origin_value +
               "-" +
               destination_value +
               "/" +
               result_date +
               "/" +
               result_seat_type +
               "/" +
               result_count +
               "/" +
               result_dedicated_coupe

            console.log(url)
            window.location.href = url
         }
      },
   },
   watch: {
      "form.local.departure": {
         handler: function (after, before) {
            if (after) {
               if (this.form.local.options.round_trip) {
                  this.$refs.datepicker_departure.focus()
               } else {
                  this.form.local.options.passengers_number = true
               }
            }
         },
         deep: true,
         immediate: true,
      },
      "form.local.return_date": {
         handler: function (after, before) {
            if (after) {
               this.form.local.options.passengers_number = true
            }
         },
         deep: true,
         immediate: true,
      },
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
