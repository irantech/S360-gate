<template>
  <div>
    <div class="form-group">
      <div class="col-lg-12 col-md-12 col-12 col_search search_col">
        <div class="form-group">
          <input
            @input="(evt) => (form.destination = evt.target.value)"
            autocomplete="nope"
            aria-haspopup="false"
            @keyup="prepareSearchCity('destination')"
            v-model="form.destination"
            ref="destination"
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
            :disabled="
              current_panel.selected_destination.DepartureCode ===
              city.DepartureCode
            ">
            {{getLang() == 'fa' ? city.DepartureCityFa : city.DepartureCityEn }} ({{getLang() == 'fa' ?   city.CountryFa : city.CountryEn}})
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
      form: {
        destination: null,
      },
      loading: {
        destination: false,
      },
      refillable: {
        define: "destination",
        destination: "selected_destination",
      },
    }
  },
  computed: {
    current_panel() {
      return this.panel_data[this.index_data.key]
    },
    city_list() {
      if (!this.current_panel.searched_cities) {
        return this.current_panel.default_cities
      } else {
        return this.current_panel.searched_cities
      }
    },
  },
  methods: {
    async selectCity(city) {
      console.log(this.refillable[this.refillable.define])
      await this.$store.commit("setPwaData", {
        index: this.index_data.key,
        data: {
          [this.refillable[this.refillable.define]]: city,
        },
      })
      if(this.getLang() == 'fa') {
        this.form[this.refillable.define] =
          city.DepartureCityFa + "(" + city.CountryFa + ")"
      }else{
        this.form[this.refillable.define] =
          city.DepartureCityEn + "(" + city.CountryEn + ")"
      }

      this.refillable.define = "destination"
      await this.$refs.destination.focus()
      await this.$store.commit("setPwaData", {
        index: this.index_data.key,
        data: {searched_cities: null},
      })
      if (this.form.destination) {
        this.panel_data.status = false
      }
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
              this.panel_data.city_template,
          },
        })
        this.loading[loading_index] = false
      }
      await this.$store.dispatch("pwaGetSearchedCities", {
        index: this.index_data.key,
        strategy: this.index_data.strategy,
        searchable: searchable,
      })
      this.loading[loading_index] = false
    },
  },
  /*watch: {
    "panel_data.status": {
      handler: function (after, before) {
        if (after) {
          setTimeout(() => {
            this.$refs.destination.focus();
          }, 100);
        }
      },
      deep: true,
      immediate: true,
    },
  },*/
}
</script>
