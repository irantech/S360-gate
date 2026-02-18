<template>
   <div>
      <div class="row">
         <form method="post" class="d_contents" id="gds_bus" name="gds_bus">
           <div class='row'>
             <div class="col-lg-3 col-md-12 col-12 col_search">
               <div class="form-group">
                 <div
                   @click="openPanel('continent')"
                   class="fake-input align-content-center font-11 text-muted align-items-center d-flex form-control inp_flight p-3-5">
                   <span class="far fa-location" :class="`${getLang() == 'en' ? 'mr-2' : 'ml-2'}`"></span>
                   <span v-if="form.local.origin.title || form.local.origin.title_en">
                        {{getLang() == 'fa' ?  form.local.origin.title : form.local.origin.title_en }}
                     </span>
                   <span v-else>{{ useXmltag('Continent') }}</span>
                 </div>

                 <app-loading-spinner
                   class="loading-spinner-holder"
                   :loading="loading.origin"></app-loading-spinner>
               </div>
             </div>
             <div class="col-lg-3 col-md-12 col-12 col_search">
               <div class="form-group">
                 <div
                   @click="
                        openPanel('country',{
                           continent_id: form.local.origin.value,
                        })
                     "
                   class="fake-input align-content-center font-11 text-muted align-items-center d-flex form-control inp_flight p-3-5">
                   <span class="far fa-location" :class="`${getLang() == 'en' ? 'mr-2' : 'ml-2'}`"></span>
                   <span v-if="form.local.destination.title || form.local.destination.title_en">
                        {{getLang() == 'fa' ?  form.local.destination.title : form.local.destination.title_en }}
                     </span>
                   <span v-else>{{ useXmltag('Destinationcountry') }}</span>
                 </div>

                 <app-loading-spinner
                   :class="`${getLang() == 'en' ? 'loading-spinner-holder-en' : 'loading-spinner-holder'}`"
                   :loading="loading.destination"></app-loading-spinner>
               </div>
             </div>
             <div class="col-lg-2 col-md-12 col-12 col_search">
               <div class="form-group">
                 <div
                   ref='type'
                   @click="
                        openPanel('type',
                           {
                              country_id:
                                 form.local.destination.value,
                           }
                        )
                     "
                   class="fake-input align-content-center font-11 text-muted align-items-center d-flex form-control inp_flight p-3-5">
                   <span class="far fa-location" :class="`${getLang() == 'en' ? 'mr-2' : 'ml-2'}`"></span>
                   <span v-if="form.local.type.title || form.local.type.title_en">
                        {{getLang() == 'fa' ?   form.local.type.title :  form.local.type.title_en}}
                     </span>
                   <span v-else>{{ useXmltag('Typevisa') }}</span>
                 </div>

                 <app-loading-spinner
                   :class="`${getLang() == 'en' ? 'loading-spinner-holder-en' : 'loading-spinner-holder'}`"
                   :loading="loading.type"></app-loading-spinner>
               </div>
             </div>

             <div
               class="col-lg-2 position-unset col-md-12 col-sm-12 col-12 col_search">
               <passenger-count-box
                 :form="form"
                 :strategy="index_data.strategy"></passenger-count-box>
             </div>


             <div class="col-lg-2 col-md-12 col-12 btn_s col_search">
               <button
                 type="button"
                 class="btn theme-btn seub-btn b-0 site-bg-main-color"
                 @click="searchInit">
                 <span>{{ useXmltag('Search') }}</span>
               </button>
               <app-loading-spinner
                 :class="`${getLang() == 'en' ? 'loading-spinner-holder-en' : 'loading-spinner-holder'}`"
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
            origin: false,
            destination: false,
            type: false,
         },
         index_data: {
            key: "visa",
            title:useXmltag('Visa'),
            strategy: "local",
            spot: "continent",
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
               type: {
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
               options: {
                  passengers: false,
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
         let panel_data_type = current_panel_data.selected_type
         let panel_data_destination = current_panel_data.selected_destination

         this.form.local.origin = panel_data_origin
         this.form.local.type = panel_data_type
         this.form.local.destination =
            panel_data_destination
      },
      switchOriginDestination() {
         let current_origin_panel_data = this.current_panel_data.selected_origin

         this.current_panel_data.selected_origin =
            this.current_panel_data.selected_destination

         this.current_panel_data.selected_destination =
            current_origin_panel_data
      },

      async openPanel(type,conditions = null) {
         console.log("params", conditions)
         this.loading.origin = true
         if(type==='country' && !this.current_panel_data.selected_origin.value){
            conditions=null
            type='continent'
         }
         this.index_data = {
            key: "visa",
            title: type==='type' ? useXmltag('Typevisa') : useXmltag('Visa'),
            strategy: type==='type' ? "type" : "local",
            spot: type,
         }
         console.log('index_data',this.index_data)

         let data = {
            index: this.index_data.key,
            strategy: this.index_data.strategy,
         }
         if (conditions) {

            data.conditions = conditions
         }
         await this.$store.dispatch("pwaGetDefaultCities", data)
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
         let fetch_form = this.form.local
         let destination_value = fetch_form.destination.value
         let type_value = fetch_form.type.value
         let duration_value = fetch_form.duration
         let passenger = fetch_form.passengers
         let passenger_birth_dates = []
         let result_passenger_birth_dates = ""

         for (let value in parseInt(passenger.count)) {
            // console.log('key',key)
         }

         for (let item in passenger_birth_dates) {
         }
         if (!type_value) {
            status = false
            this.$swal({
               icon: "error",
               toast: true,
               position: "bottom",
               showConfirmButton: false,
               timerProgressBar: true,
               timer: 4000,
               title: useXmltag('Choose') + useXmltag('Typevisa'),
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
               title: useXmltag('AtLeastOnePerson'),
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
         // https://s360online.iran-tech.com/gds/fa/resultVisa/BFA/2/1-NaN-NaN
         if (status) {
            this.loading.form = true

            let url =
               this.main_url +
               "/" +
               "resultVisa" +
               "/" +
              destination_value +
               "/" +
              type_value +
               "/" +
               parseInt(passenger.count)

            console.log(url)
            window.location.href = url
         }
      },
      modifyNewPassengerIndex() {
         let passenger = this.form.local.passengers
         let count = passenger.count
         for (let each_item in count) {
            passenger.birth_dates[each_item] = null
         }
      },
   },
   watch: {
      "current_panel_data.selected_destination": {
         handler: function (after, before) {
            if (after) {
               if ((before && after.value !== before.value) && (after.value !=='' && after.value !== null )) {
                  this.$refs.type.click()
               }
            }
         },
         deep: true,
         immediate: true,
      },

   },
}
</script>
