<template>
   <div>
      <div class="form-group">
         <div
            class="col-lg-12 col-md-12 col-12 col_search search_col col_with_route">
            <div class="form-group origin_start">
               <input
                  @input="evt => (form.country = evt.target.value)"
                  autocomplete="nope"
                  aria-haspopup="false"
                  @keyup="prepareSearchCity('country')"
                  v-model="form.country"
                  ref="country"
                  type="text"
                  class="form-control"
                  :placeholder="`${useXmltag('SelectDestinationCountry')}`" />

               <app-loading-spinner
                 :class="`${getLang() == 'en' ? 'loading-spinner-holder-en' : 'loading-spinner-holder'}`"
                  :loading="loading.country"></app-loading-spinner>
            </div>
         </div>
         <div class="col-lg-12 col-md-12 col-12 col_search search_col">
            <div class="form-group">
               <input
                  @input="evt => (form.city = evt.target.value)"
                  autocomplete="nope"
                  aria-haspopup="false"
                  @keyup="prepareSearchCity('city')"
                  v-model="form.city"
                  ref="city"
                  :disabled="!current_panel.selected_country.value"
                  type="text"
                  class="inputSearchForeign form-control"
                  :placeholder="`${useXmltag('SelectDestinationCity')}`" />
               <app-loading-spinner
                 :class="`${getLang() == 'en' ? 'loading-spinner-holder-en' : 'loading-spinner-holder'}`"
                  :loading="loading.destination"></app-loading-spinner>
            </div>
         </div>
      </div>

      <div class="list-cities">
         <h6 class="title-c d-flex">
            {{
               current_panel.searched_cities ? useXmltag('Result') : useXmltag('PopularRoutes')
            }}
         </h6>
         <ul>
            <li
               v-if="city_list === null"
               class="d-flex justify-content-center py-4">
               <app-loading-spinner :loading="true"></app-loading-spinner>
            </li>
            <li v-for="city in city_list" :key="city.value" class="item_c">
               <button @click="selectCity(city)" class="btn btn-block">
                  {{getLang() == 'fa' ?  city.title : city.title_en }}
               </button>
            </li>
         </ul>
      </div>
   </div>
</template>
<script>
export default {
   props: ["index_data", "panel_data"],
   data() {
      return {
         loading: {
            country: false,
            destination: false,
         },
         refillable: {
            define: "country",
            country: "selected_country",
            city: "selected_city",
         },
      }
   },
   computed: {
      form() {

         return {
            country: this.current_panel.selected_country.title,
            city: this.current_panel.selected_city.title,
         }
      },
      current_panel() {
         let current_panel = this.panel_data[this.index_data.key]
         console.log("current_panel", current_panel)
         return current_panel
      },
      city_list() {
         if (!this.current_panel.searched_cities) {
            return this.current_panel.default_cities
         } else {
            return this.current_panel.searched_cities
         }
      },
   },
   created() {
      console.log("awd")
   },
   methods: {
      async callOpenPanel(destination_country) {
         await this.$store.dispatch("pwaGetDefaultCities", {
            index: this.index_data.key,
            strategy: this.index_data.strategy,
            conditions: {
               destination_country: destination_country,
            },
         })
      },
      async selectCity(city) {
         await this.$store.commit("setPwaData", {
            index: this.index_data.key,
            data: {
               [this.refillable[this.refillable.define]]: city,
            },
         })

         if (this.refillable.define === "country") {
            await this.$store.dispatch("pwaGetDefaultCities", {
               index: this.index_data.key,
               strategy: this.index_data.strategy,
               conditions: {
                  country_id: city.value,
               },
            })
            this.refillable.define = "city"
            await this.$refs.city.focus()
            this.form[this.refillable.define] = this.getLang() =='fa' ? city.title : city.title_en
         } else {
            this.panel_data.status = false
         }

         this.current_panel.searched_cities=null
      },

      prepareSearchCity(define) {
         let loading_index = this.refillable.define
         this.loading[loading_index] = true
         if (this.timer) {
            clearTimeout(this.timer)
            this.timer = null
         }
         this.timer = setTimeout(() => {
            this.refillable.define = define
            this.searchCity(this.form[define])
         }, 485)
      },
      async searchCity(searchable) {
         let loading_index = this.refillable.define
         this.loading[loading_index] = true
         if (!searchable) {
            this.form[this.refillable.define] = null
            await this.$store.commit("setPwaData", {
               index: this.index_data.key,
               data: {
                  [this.refillable[this.refillable.define]]:
                     this.current_panel.city_template,
               },
            })
            await this.$store.dispatch("pwaGetDefaultCities", {
               index: this.index_data.key,
               strategy: this.index_data.strategy,

            })
            this.loading[loading_index] = false
         }
         let data={
            index: this.index_data.key,
            strategy: this.index_data.strategy,
            searchable: searchable,
         }
         if(this.refillable.define === 'city'){
            // add conditions
            data.conditions = {
               country_id: this.current_panel.selected_country.value,
            }
         }
         await this.$store.dispatch("pwaGetSearchedCities",data )
         this.loading[loading_index] = false
      },
   },
   watch: {
      "index_data.spot": {
         handler: function (after, before) {
            if (after) {
               this.refillable.define = this.index_data.spot
            }
         },
         deep: true,
         immediate: true,
      },

   },
}
</script>
