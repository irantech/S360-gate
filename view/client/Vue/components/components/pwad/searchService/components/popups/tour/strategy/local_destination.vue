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
            :disabled="!current_panel.selected_origin"
            type="text"
            class="inputSearchForeign form-control"
            placeholder="مقصد ( نام شهر یا فرودگاه )" />
          <app-loading-spinner
            class="loading-spinner-holder"
            :loading="loading.destination"></app-loading-spinner>
        </div>
      </div>
    </div>

    <div class="list-cities">
      <h6 class="title-c d-flex">
        {{ current_panel.searched_cities ? "نتایج جستجو" : "نتایج جستجو" }}
      </h6>
      <ul>
        <li
          v-if="city_list === null"
          class="d-flex justify-content-center py-4">
          <app-loading-spinner :loading="true"></app-loading-spinner>
        </li>
        <li
          v-for="item in city_list"
          v-if="item.city"
          :key="item.city.value"
          class="item_c">
          <button
            @click="selectCity(item)"
            class="btn btn-block"
            :disabled="
              current_panel.selected_destination.city.value === item.city.value
            ">
            {{ item.city.title }}
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
        origin: null,
        destination: null,
      },
      loading: {
        origin: false,
        destination: false,
      },
      refillable: {
        define: "destination",
        origin: "selected_origin",
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
      await this.$store.commit("setPwaData", {
        index: this.index_data.key,
        data: {
          [this.refillable[this.refillable.define]]: city,
        },
      })
      this.form[this.refillable.define] = city.city.title
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
  watch: {
    "panel_data.status": {
      handler: function (after, before) {
        if (after) {
          setTimeout(() => {
            if (!this.form.origin) {
              // this.$refs.origin.focus()
            } else {
              this.$refs.destination.focus()
            }
          }, 100)
        }
      },
      deep: true,
      immediate: true,
    },
  },
}
</script>
