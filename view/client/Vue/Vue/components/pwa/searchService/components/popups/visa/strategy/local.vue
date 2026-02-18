<template>
  <div>
    <div class="form-group">
      <div
        class="col-lg-12 col-md-12 col-12 col_search search_col col_with_route">
        <div class="form-group origin_start">
          <input
            @input="(evt) => (form.origin = evt.target.value)"
            autocomplete="nope"
            aria-haspopup="false"
            @keyup="prepareSearchCity('origin')"
            v-model="form.origin"
            ref="origin"
            type="text"
            class="form-control"
            :placeholder="`${useXmltag('Continent')}`" />

          <app-loading-spinner
            :class="`${getLang() == 'en' ? 'loading-spinner-holder-en' : 'loading-spinner-holder'}`"
            :loading="loading.origin"></app-loading-spinner>
        </div>
      </div>
      <div class="col-lg-12 col-md-12 col-12 col_search search_col">
        <div class="form-group">
          <input
            @input="(evt) => (form.destination = evt.target.value)"
            autocomplete="nope"
            aria-haspopup="false"
            @keyup="prepareSearchCity('destination')"
            v-model="form.destination"
            ref="destination"
            :disabled="!current_panel.selected_origin.value"
            type="text"
            class="inputSearchForeign form-control"
            :placeholder="`${useXmltag('Destinationcountry')}`" />
          <app-loading-spinner
            :class="`${getLang() == 'en' ? 'loading-spinner-holder-en' : 'loading-spinner-holder'}`"
            :loading="loading.destination"></app-loading-spinner>
        </div>
      </div>
    </div>

    <div class="list-cities">
      <h6 class="title-c d-flex">
        {{ current_panel.searched_cities ? useXmltag('Result')  : useXmltag('PopularRoutes')  }}
      </h6>
      <ul>
        <li
          v-if="city_list === null"
          class="d-flex justify-content-center py-4">
          <app-loading-spinner :loading="true"></app-loading-spinner>
        </li>
        <li v-for="city in city_list" :key="city.value" class="item_c">
          <button
            @click="selectCity(city)"
            class="btn btn-block"
            :disabled="current_panel.selected_origin.value === city.value ||
              current_panel.selected_destination.value === city.value">
            {{ getLang() == 'fa' ? city.title :  city.title_en }}
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
        origin: false,
        destination: false,
      },
      refillable: {
        define: "origin",
        origin: "selected_origin",
        destination: "selected_destination",
      },
    }
  },
  computed: {
    form(){
      console.log('ad',{
        "origin": this.current_panel.selected_origin.title,
        "destination": this.current_panel.selected_destination.title
      })
      return {
        "origin": this.getLang() == 'fa' ?  this.current_panel.selected_origin.title : this.current_panel.selected_origin.title_en,
        "destination": this.getLang() == 'fa' ?  this.current_panel.selected_destination.title :  this.current_panel.selected_destination.title_en
      }

    },
    current_panel() {
      let current_panel = this.panel_data[this.index_data.key]

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
    console.log('awd')
  },
  methods: {
    async callOpenPanel(destination_country) {
      console.log('destination_country',destination_country)
      console.log(destination_country)
      await this.$store.dispatch("pwaGetDefaultCities", {
        index: this.index_data.key,
        strategy: this.index_data.strategy,
        conditions: {
          destination_country: destination_country,
        },
      })
    },
    async selectCity(city) {

      console.log('destination_continent: city.value',{destination_continent: city.value})
      await this.$store.dispatch("pwaGetDefaultCities", {
        index: this.index_data.key,
        strategy: this.index_data.strategy,
        conditions: {
          continent_id: city.value,
        },
      })

      console.log('this.index_data.key',this.index_data.key)
      await this.$store.commit("setPwaData", {
        index: this.index_data.key,
        data: {
          [this.refillable[this.refillable.define]]: city,
        },
      })

      this.form[this.refillable.define] = this.getLang() == 'fa' ? city.title : city.title_en

      if(this.refillable.define == 'origin'){
        await this.$store.commit("setPwaData", {
          index: this.index_data.key,
          data: {
            [this.refillable['destination']]: {
              title: null,
              airport: null,
              value: null,
            },
          },
        })

        this.refillable.define = "destination"

      }

      await this.$refs.destination.focus()

      if (this.form.destination) {
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
        this.loading.origin = false
        this.loading.destination = false
        // this.loading[loading_index] = false
      }
      await this.$store.dispatch("pwaGetSearchedCities", {
        index: this.index_data.key,
        strategy: this.index_data.strategy,
        searchable: searchable,
      })
      this.loading[loading_index] = false
    },
  },
  watch: {
    "index_data.spot": {
      handler: function (after, before) {
        if (after) {
          if(this.index_data.spot == 'continent'){
            this.refillable.define='origin'
          }else{
            this.refillable.define='destination'

          }
        }
      },
      deep: true,
      immediate: true,
    },
  },
}
</script>
