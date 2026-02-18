<template>
  <div>
    <div class="form-group">
      <div
        class="col-lg-12 col-md-12 col-12 col_search search_col col_with_route">
        <div class="form-group origin_start">
          <input
            v-model="form.origin.country"
            ref="origin"
            disabled
            type="text"
            class="form-control"
            placeholder="کشور مبدأ" />
        </div>
      </div>
      <div class="col-lg-12 col-md-12 col-12 col_search search_col">
        <div class="form-group">
          <input
            @input="(evt) => (form.origin.city = evt.target.value)"
            autocomplete="nope"
            aria-haspopup="false"
            @keyup="prepareSearchCity(form.origin.city, 'origin')"
            v-model="form.origin.city"
            ref="origin_city"
            :disabled="!current_panel.selected_origin"
            type="text"
            class="inputSearchForeign form-control"
            placeholder="شهر مبدأ" />
          <app-loading-spinner
            class="loading-spinner-holder"
            :loading="loading.origin"></app-loading-spinner>
        </div>
      </div>
    </div>

    <div class="list-cities">
      <h6 class="title-c d-flex">
        {{ current_panel.searched_cities ? "نتایج جستجو" : "نتایج جستجو" }}
      </h6>

      <ul>
        <li
          v-for="item in city_list"
          v-if="item.city"
          :key="item.city.value"
          class="item_c">
          <button
            @click="selectCity(item)"
            class="btn btn-block"
            :disabled="
              current_panel.selected_origin.city.value === item.city.value ||
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
        origin: {
          city: null,
          country: "ایران",
        },

        destination: {
          city: null,
          country: null,
        },
      },
      loading: {
        origin: false,
      },
      refillable: {
        define: {
          value: "origin_city",
          index: "origin",
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
    city_list() {
      if (!this.current_panel.searched_cities) {
        return this.current_panel.default_cities
      } else {
        return this.current_panel.searched_cities
      }
    },
  },
  methods: {
    async selectCity(item) {
      let index_name = this.refillable[this.refillable.define.value]["index"]
      let value_name = this.refillable[this.refillable.define.value]["value"]
      this.current_panel[value_name][index_name] = item.city

      await this.$store.commit("setPwaData", {
        index: this.index_data.key,
        data: {
          [value_name]: this.current_panel[value_name],
        },
      })
      this.form[this.refillable.define.index][index_name] = item.city.title

      this.refillable.define.value = "origin_city"
      await this.$refs.origin_city.focus()
      await this.$store.commit("setPwaData", {
        index: this.index_data.key,
        data: {searched_cities: null},
      })
      if (this.form.destination) {
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
      let loading_index = this.refillable.define.index
      this.loading[loading_index] = true
      if (!searchable) {
        this.form[this.refillable.define.value] = null
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
            console.log("awd");
            this.$refs.origin_city.focus();
          }, 100);
        }
      },
      deep: true,
      immediate: true,
    },
  },*/
}
</script>
