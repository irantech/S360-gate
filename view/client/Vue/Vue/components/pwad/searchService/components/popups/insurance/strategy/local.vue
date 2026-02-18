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
            placeholder="نام کشور مقصد" />
          <app-loading-spinner
            class="loading-spinner-holder"
            :loading="loading.origin"></app-loading-spinner>
        </div>
      </div>
    </div>

    <div class="list-cities">
      <h6 class="title-c d-flex">
        {{ current_panel.searched_cities ? "نتایج جستجو" : "شهر های پر تردد" }}
      </h6>
      <ul>
        <li v-for="city in city_list" :key="city.value" class="item_c">
          <button
            @click="selectCity(city)"
            class="btn btn-block"
            :disabled="
              current_panel.selected_origin.value === city.value ||
              current_panel.selected_destination.value === city.value
            ">
            {{ city.title }}
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
        define: "origin",
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
      this.form[this.refillable.define] = city.title
      await this.$store.commit("setPwaData", {
        index: this.index_data.key,
        data: {searched_cities: null},
      })
      if (this.form.origin) {
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
  /*watch: {
    "panel_data.status": {
      handler: function (after, before) {
        if (after) {
          setTimeout(() => {
            this.$refs.origin.focus();
          }, 100);
        }
      },
      deep: true,
      immediate: true,
    },
  },*/
}
</script>
