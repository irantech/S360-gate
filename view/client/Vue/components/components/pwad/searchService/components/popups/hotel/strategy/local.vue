<template>
  <div>
    <div class="form-group">
      <div
        class="col-lg-12 col-md-12 col-12 col_search search_col col_with_route">
        <div class="form-group origin_start">
          <input
            @input="(evt) => (form.destination = evt.target.value)"
            autocomplete="nope"
            aria-haspopup="false"
            @keyup="prepareSearchCity('destination')"
            v-model="form.destination"
            ref="destination"
            type="text"
            class="form-control"
            placeholder="مبدأ ( نام شهر یا فرودگاه )" />
          <app-loading-spinner
            class="loading-spinner-holder"
            :loading="loading.destination"></app-loading-spinner>
        </div>
      </div>
    </div>

    <div class="list-cities">
      <h6 class="title-c d-flex">
        {{ current_panel.searched_cities ? "نتایج جستجو" : "شهر های پر تردد" }}
      </h6>
      <ul>
        <li
          v-if="city_list === null"
          class="d-flex justify-content-center py-4">
          <app-loading-spinner :loading="true"></app-loading-spinner>
        </li>
        <template
          v-if="city_list"
          v-for="(available_index, key) in available_indexes">
          <li
            v-if="
              city_list[key] !== undefined &&
              city_list[key] !== null &&
              city_list[key] !== ''
            "
            v-for="item in city_list[key]">
            <button @click="selectCity(item)" class="btn btn-block">
              {{ item[available_index.title_index] }}
            </button>
          </li>
        </template>
      </ul>
    </div>
  </div>
</template>
<script>
export default {
  props: ["index_data", "panel_data"],
  data() {
    return {
      available_indexes: {
        Cities: {
          value_index: "",
          title_index: "CityName",
        },
        ReservationHotels: {
          value_index: "",
          title_index: "HotelName",
        },
        ApiHotels: {
          value_index: "",
          title_index: "HotelName",
        },
      },
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
      await this.$store.commit("setPwaData", {
        index: this.index_data.key,
        data: {
          [this.refillable[this.refillable.define]]: city,
        },
      })
      this.form[this.refillable.define] =
        city[this.available_indexes[city["index_name"]].title_index]
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
