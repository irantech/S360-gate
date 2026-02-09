<template>
  <div>
    <div class="form-group">
      <div
        class="col-lg-12 col-md-12 col-12 col_search search_col col_with_route">
        <div class="form-group origin_start">
          <input
            @input="
              (evt) => (external_form.destination.country = evt.target.value)
            "
            @keyup="
              prepareSearchCity(
                external_form.destination.country,
                'destination'
              )
            "
            v-model="external_form.destination.country"
            ref="destination_country"
            type="text"
            class="form-control"
            :placeholder="`${useXmltag('Destinationcountry')}`" />
          <app-loading-spinner
            :class="`${getLang() == 'en' ? 'loading-spinner-holder-en' : 'loading-spinner-holder'}`"
            :loading="loading.destination.country"></app-loading-spinner>
        </div>
      </div>
      <div class="col-lg-12 col-md-12 col-12 col_search search_col">
        <div class="form-group">
          <input
            @keyup="
              prepareSearchCity(external_form.destination.city, 'destination')
            "
            @input="
              (evt) => (external_form.destination.city = evt.target.value)
            "
            autocomplete="nope"
            aria-haspopup="false"
            v-model="external_form.destination.city"
            ref="destination_city"
            :disabled="!current_panel.selected_origin"
            type="text"
            class="inputSearchForeign form-control"
            :placeholder="`${useXmltag('Destinationcity')}`" />
          <app-loading-spinner
            class="loading-spinner-holder"
            :loading="loading.destination.city"></app-loading-spinner>
        </div>
      </div>
    </div>

    <div class="list-cities">
      <h6 class="title-c d-flex">
        {{ current_panel.searched_cities ?useXmltag('Result')  : useXmltag('Result') }}
      </h6>
      <ul>
        <li class="item_c">
          <button
            @click="selectCity(allItem)"
            class="btn btn-block">
            {{useXmltag('All')}}
          </button>
        </li>
        <li
          v-for="item in city_list"
          v-if="item[spot_index] && item"
          :key="item[spot_index].value"
          class="item_c">
          <button
            @click="selectCity(item)"
            class="btn btn-block"
            :disabled="
              current_panel.selected_origin[spot_index].value ===
                item[spot_index].value ||
              current_panel.selected_destination[spot_index].value ===
                item[spot_index].value
            ">
            {{  getLang() == 'fa' ?  item[spot_index].title : item[spot_index].title_en}}
          </button>
        </li>
      </ul>
    </div>
  </div>
</template>
<script>
export default {
  props: ["index_data", "panel_data", "form"],
  data() {
    return {
      allItem : {
        "city": { "title": "همه مقاصد", "title_en": "all", "value": "all" },
        "country": { "title": "همه مقاصد", "title_en": "all", "value": "all" }
      },
      external_form: {
        origin: {
          city: null,
          country: null,
        },
        destination: {
          city: null,
          country: null,
        },
      },
      loading: {
        destination: {
          city: false,
          country: false,
        },
      },
      refillable: {
        define: {
          value: "destination_country",
          index: "destination",
          city_list_index: "country",
        },
        origin_city: {
          index: "city",
          value: "selected_origin",
        },
        destination_country: {
          index: "country",
          value: "selected_destination",
        },
        destination_city: {
          index: "city",
          value: "selected_destination",
        },
      },
    }
  },
  computed: {
    current_panel() {
      return this.panel_data[this.index_data.key]
    },
    spot_index() {
      let spot = this.form.spot
      if (spot === "destination_city") {
        return "city"
      } else {
        return "country"
      }
    },
    city_list() {
      if (this.current_panel.searched_cities) {
        return this.current_panel.searched_cities
      } else {
        return this.current_panel.default_cities
      }
    },
  },
  methods: {
    async callOpenPanel(destination_country) {
      console.log(destination_country)
      await this.$store.dispatch("pwaGetDefaultCities", {
        index: this.index_data.key,
        strategy: this.index_data.strategy,
        conditions: {
          destination_country: destination_country,
        },
      })
    },
    async selectCity(item) {
      let index_name = this.refillable[this.refillable.define.value]["index"]
      let value_name = this.refillable[this.refillable.define.value]["value"]
      this.current_panel[value_name][index_name] =
        item[this.refillable.define.city_list_index]

      await this.$store.commit("setPwaData", {
        index: this.index_data.key,
        data: {
          [value_name]: this.current_panel[value_name],
        },
      })
      this.getLang() == 'fa' ? item[this.refillable.define.city_list_index].title :item[this.refillable.define.city_list_index].title_en

      this.external_form[this.refillable.define.index][index_name] =
        this.getLang() == 'fa' ?   item[this.refillable.define.city_list_index].title : item[this.refillable.define.city_list_index].title_en

      this.refillable.define.value = "destination_city"
      this.refillable.define.city_list_index = "city"

      await this.callOpenPanel(this.current_panel[value_name])

      await this.$refs[this.current_panel.spot].focus()
      await this.$store.commit("setPwaData", {
        index: this.index_data.key,
        data: {searched_cities: null},
      })
      if (this.external_form.destination) {
        this.panel_data.status = false
      }
    },
    prepareSearchCity(value, define) {
      if (this.timer) {
        clearTimeout(this.timer)
        this.timer = null
      }
      this.timer = setTimeout(() => {
        this.refillable.define.value = define
        this.searchCity(value)
      }, 485)
    },
    async searchCity(searchable) {
      let loading_index = this.refillable.define.value
      this.loading[loading_index] = true
      if (!searchable) {
        this.external_form[this.refillable.define.value] = null
        await this.$store.commit("setPwaData", {
          index: this.index_data.key,
          data: {
            [this.refillable[this.refillable.define.value]]:
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
            if (!this.external_form.destination.city) {
              this.$refs.destination_country.focus();
            } else {
              this.$refs.destination_city.focus();
            }
          }, 100);
        }
      },
      deep: true,
      immediate: true,
    },
  },*/
}
</script>
