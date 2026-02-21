<template>
   <div>
      <div class="row">
         <form method="post" class="d_contents" id="gds_bus" name="gds_bus">

            <div class="col-lg-2 col-md-12 col-12 col_search">
               <div class="form-group">
                  <div
                     @click="openPanel('country')"
                     class="fake-input align-content-center font-11 text-muted align-items-center d-flex form-control inp_flight p-3-5">
                     <span class="far fa-location" :class="`${getLang() == 'en' ? 'mr-2' : 'ml-2'}`"></span>
                     <span v-if="form.local.country.title ||form.local.country.title_en">
                        {{getLang() == 'fa' ?  form.local.country.title : form.local.country.title_en}}
                     </span>
                     <span v-else>{{ useXmltag('SelectDestinationCountry')}}</span>
                  </div>

                  <app-loading-spinner
                    :class="`${getLang() == 'en' ? 'loading-spinner-holder-en' : 'loading-spinner-holder'}`"
                     :loading="loading.origin"></app-loading-spinner>
               </div>
            </div>
            <div class="col-lg-2 col-md-12 col-12 col_search">
               <div class="form-group">
                  <div
                     @click="
                        openPanel('city',{
                           country_id: form.local.country.value,
                        })
                     "
                     class="fake-input align-content-center font-11 text-muted align-items-center d-flex form-control inp_flight p-3-5">
                     <span class="far fa-location" :class="`${getLang() == 'en' ? 'mr-2' : 'ml-2'}`"></span>
                     <span v-if="form.local.city.title || form.local.city.title_en">
                        {{getLang() == 'fa' ?   form.local.city.title : form.local.city.title_en }}
                     </span>
                     <span v-else>{{ useXmltag('SelectDestinationCity')}}</span>
                  </div>

                  <app-loading-spinner
                    :class="`${getLang() == 'en' ? 'loading-spinner-holder-en' : 'loading-spinner-holder'}`"
                     :loading="loading.city"></app-loading-spinner>
               </div>
            </div>
            <div class="col-lg-2 col-md-12 col-12 col_search">
               <div class="form-group">
                  <div
                    ref='category'
                     @click="
                        openPanel('category',
                           {
                              city_id:
                                 form.local.city.value,
                           }
                        )
                     "
                     class="fake-input align-content-center font-11 text-muted align-items-center d-flex form-control inp_flight p-3-5">
                     <span class="far fa-location" :class="`${getLang() == 'en' ? 'mr-2' : 'ml-2'}`"></span>
                     <span v-if="form.local.category.title || form.local.category.title_en">
                        {{getLang() == 'fa' ?  form.local.category.title : form.local.category.title_en}}
                     </span>
                     <span v-else>{{ useXmltag('ChoseCategory')}}</span>
                  </div>

                  <app-loading-spinner
                    :class="`${getLang() == 'en' ? 'loading-spinner-holder-en' : 'loading-spinner-holder'}`"
                     :loading="loading.category"></app-loading-spinner>
               </div>
            </div>

            <div class="col-lg-2 col-md-12 col-12 col_search">
               <div class="form-group">
                  <div
                    ref='sub_category'
                    @click="
                        openPanel('sub_category',
                           {
                               city_id:
                                 form.local.city.value,
                              category_id:
                                 form.local.category.value,
                           }
                        )
                     "
                    class="fake-input align-content-center font-11 text-muted align-items-center d-flex form-control inp_flight p-3-5">
                     <span class="far fa-location" :class="`${getLang() == 'en' ? 'mr-2' : 'ml-2'}`"></span>
                     <span v-if="form.local.sub_category.title || form.local.sub_category.title_en">
                        {{getLang() == 'fa' ?  form.local.sub_category.title  : form.local.sub_category.title_en }}
                     </span>
                     <span v-else>{{ useXmltag('AllEntertainments')}}</span>
                  </div>

                  <app-loading-spinner
                    :class="`${getLang() == 'en' ? 'loading-spinner-holder-en' : 'loading-spinner-holder'}`"
                    :loading="loading.sub_category"></app-loading-spinner>
               </div>
            </div>



            <div class="col-lg-2 col-md-12 col-12 btn_s col_search">
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
            country: false,
            city: false,
            category: false,
            sub_category: false,
         },
         index_data: {
            key: "entertainment",
            title: useXmltag('SelectDestinationCountry'),
            strategy: "destination",
         },

         form: {
            local: {
               country: {
                  title: null,
                  value: null,
               },
               city: {
                  title: null,
                  value: null,
               },
               category: {
                  title: null,
                  value: null,
               },
               sub_category: {
                  title: null,
                  value: null,
               },
            },
            format_datepicker: "jYYYY-jMM-jDD",
            lang_datepicker: this.getLang(),
         },
      }
   },
   computed: {
      panel_data() {
         return this.$store.state.panel_data
      },
      current_panel_data() {
         this.updateForm()
         const data=this.$store.state.panel_data[this.index_data.key]
         if(data.selected_city.value && !data.selected_sub_category.value){
            this.$refs.category.click()

         }
         console.log('ddd',data)
         return data
      },
   },
   methods: {
      updateForm() {
         let current_panel_data = this.panel_data[this.index_data.key]
         let panel_data_country = current_panel_data.selected_country
         let panel_data_city = current_panel_data.selected_city
         let panel_data_category = current_panel_data.selected_category
         let panel_data_sub_category = current_panel_data.selected_sub_category

         this.form.local.country = panel_data_country
         this.form.local.city = panel_data_city
         this.form.local.category = panel_data_category
         this.form.local.sub_category = panel_data_sub_category

      },

      async openPanel(spot, conditions = null) {
         console.log("params", conditions)
         console.log("spot", spot)


         if(spot==='city' && !this.current_panel_data.selected_country.value){
            conditions=null
            spot='country'
         }


         const loadingKey = `${spot}`;
         const strategy = spot === 'category'|| spot ==='sub_category' ? 'category' : 'destination';
         const title = spot === 'category' || spot === 'sub_category' ?useXmltag('AllEntertainments')  :useXmltag('SelectDestinationCity');
         console.log("strategy", strategy)

         this.loading[loadingKey] = true;
         this.index_data = {
            key: "entertainment",
            title: title,
            strategy: strategy,
            spot: spot,
         }

         let data = {
            index: this.index_data.key,
            strategy: this.index_data.strategy,
            conditions: conditions,
         }

         await this.$store.dispatch("pwaGetDefaultCities", data)
         await this.$store.commit("setPwaDefaultStatus", true)
         this.loading[loadingKey] = false;
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
         let country_value = fetch_form.country.value
         let city_value = fetch_form.city.value
         let sub_category_value = fetch_form.sub_category.value



         if (!sub_category_value) {
            status = false
            this.$swal({
               icon: "error",
               toast: true,
               position: "bottom",
               showConfirmButton: false,
               timerProgressBar: true,
               timer: 4000,
               title: useXmltag('ChoseCategory'),
            })
         }


         if (!city_value) {
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
         if (!country_value) {
            status = false
            this.$swal({
               icon: "error",
               toast: true,
               position: "bottom",
               showConfirmButton: false,
               timerProgressBar: true,
               timer: 4000,
               title:useXmltag('PleaseEnterCountry'),
            })
         }
         // https://s360online.iran-tech.com/gds/fa/resultEntertainment/1/1/28
         if (status) {
            this.loading.form = true

            let url =
               this.main_url +
               "/" +
               "resultEntertainment" +
               "/" +
              country_value +
               "/" +
              city_value +
               "/" +
               sub_category_value

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
/*      "current_panel_data.selected_city": {
         handler: function (after, before) {
            if (after) {
               console.log('after.value',after.value)
               if ((after.value !=='' && after.value !== null )) {
                  this.$refs.category.click()
               }
            }
         },
         deep: true,
         immediate: true,
      },*/

   },
}
</script>
