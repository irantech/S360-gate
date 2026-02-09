<template>
   <div id="internal_tour" class="d_flex flex-wrap internal-tour-js">
      <form
         data-action="s360online.iran-tech.com/"
         name="gdstourLocal"
         target="_blank"
         id="internal_tour_form"
         class="d_contents"
         method="post">
         <div
            class="col-lg-3 col-md-6 col-sm-6 col-12 col_search search_col p-1">
            <div class="form-group destination_start">
               <div
                  class="s-u-in-out-wrapper raft raft-change change-bor w-100">
                  <select
                     @change="getDestinationCountryData(true)"
                     v-model="selectedOriginCity"
                     placeholder='شهر مبدا'
                     class="form-control">
                     <option
                        :value="city.value"
                        v-for="city in defaultData.origin_cities">
                        {{ city.title }}
                     </option>
                  </select>
               </div>
            </div>
         </div>
         <div
            class="col-lg-3 col-md-6 col-sm-6 col-12 col_search search_col p-1">
            <div class="form-group destination_start">
               <div
                  class="s-u-in-out-wrapper raft raft-change change-bor w-100">
                  <select
                     @change="getDestinationCityData(true)"
                     v-model="selectedDestinationCountry"  placeholder='کشور مقصد'
                     class="form-control">
                     <option
                        :value="country.id"
                        v-for="country in defaultData.destination_countries">
                        {{ country.name }}
                     </option>
                  </select>
               </div>
            </div>
         </div>
         <div
            class="col-lg-3 col-md-6 col-sm-6 col-12 col_search search_col p-1">
            <div class="form-group destination_start">
               <div
                  class="s-u-in-out-wrapper raft raft-change change-bor w-100">
                  <select
                     v-model="selectedDestinationCity"
                     placeholder='شهر مقصد'
                     class="form-control">
                     <option
                        :value="city.id"
                        v-for="city in defaultData.destination_cities"
                        value="1">
                        {{ city.name }}
                     </option>
                  </select>
               </div>
            </div>
         </div>
         <div
            class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
            <div class="form-group destination_start">
               <div
                  class="s-u-in-out-wrapper raft raft-change change-bor w-100">
                  <select v-model="selectedDate" class="form-control">
                     <option
                        v-for="(month, index) in months"
                        :key="index"
                        :value="month.date">
                        {{ month.name }}
                     </option>
                  </select>
               </div>
            </div>
         </div>
         <div
            class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
            <div class="form-group destination_start">
               <div
                  class="s-u-in-out-wrapper raft raft-change change-bor w-100">
                  <select v-model="selectedType" class="form-control">
                     <option
                        v-for="(type, index) in defaultData.types"
                        :key="index"
                        :value="type.id">
                        {{ type.tour_type }}
                     </option>
                  </select>
               </div>
            </div>
         </div>

         <div
            class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search margin-center p-1">
            <button
               type="button"
               @click="doSearchInit()"
               class="btn theme-btn seub-btn b-0">
               <span>جستجو</span>
            </button>
         </div>
      </form>
   </div>
</template>
<script>
export default {
   name: "tour-section-header-search-international-form",
   data() {
      return {
         selectedOriginCity: null,
         selectedDestinationCountry: null,
         selectedDestinationCity: null,
         selectedDate: null,
         selectedType: null,
         months: [],
         tourTypes: [],
         defaultData: {
            types: [],
            origin_cities: [],
            destination_cities: [],
            destination_countries: [],
         },
      }
   },
   computed: {
      tourData() {
         return this.$store.state.tours.data
      },
   },
   async created() {
      this.generateNextFiveMonths()
      await this.getData()

      if(this.$store.state.tours.defaultTab == 'international') {
        this.selectedType = this.tourData.type
        if(this.tourData.lang == 'fa') {

          this.selectedDate = new Intl.DateTimeFormat("fa-IR-u-nu-latn", {
            year: "numeric",
            month: "2-digit",
            day: "2-digit",
          })
            .format(new Date(this.tourData.date))
            .replace(/\//g, "-")
        }else{
          this.selectedDate = this.tourData.date
        }

        this.selectedOriginCity = Number(this.tourData.origin_city)
          ? Number(this.tourData.origin_city)
          : this.tourData.origin_city
        if (this.selectedOriginCity) {
          await this.getDestinationCountryData()
        }
        this.selectedDestinationCity = Number(this.tourData.destination_city)
          ? Number(this.tourData.destination_city)
          : this.tourData.destination_city
        this.selectedDestinationCountry = Number(
          this.tourData.destination_country
        )
          ? Number(this.tourData.destination_country)
          : this.tourData.destination_country
      }


      if (this.selectedOriginCity) {
         await this.getDestinationCountryData()
         if (this.selectedDestinationCountry) {
            await this.getDestinationCityData()
         }
      }
   },
   methods: {
      async doSearchInit() {
        console.log('sssss')
         let status = true
         let origin_city_value = this.selectedOriginCity
         let destination_city_value = this.selectedDestinationCity
         let origin_country_value = 1
         let destination_country_value = this.selectedDestinationCountry
         let departure_date = this.selectedDate
         let type = this.selectedType

         if (!destination_city_value) {
            status = false
            this.$swal({
               icon: "error",
               toast: true,
               position: "bottom",
               showConfirmButton: false,
               timerProgressBar: true,
               timer: 4000,
               title: useXmltag("ChooseDestination"),
            })
            return false
         }

         let tourData = Object.create(this.tourData)
         tourData.origin_city = Number(this.selectedOriginCity)
            ? Number(this.selectedOriginCity)
            : this.selectedOriginCity
         tourData.destination_country = Number(this.selectedDestinationCountry)
            ? Number(this.selectedDestinationCountry)
            : this.selectedDestinationCountry
         tourData.destination_city = Number(this.selectedDestinationCity)
            ? Number(this.selectedDestinationCity)
            : this.selectedDestinationCity
         tourData.type = this.selectedType
         tourData.date = this.selectedDate.replaceAll("-", "")

         this.$store.commit("setTourList", tourData)

         const destinationName = this.defaultData.destination_cities
            .find(item => {
               return item.id === destination_city_value
            })
            ?.name?.replace(" ", "-")
         // history.pushState({}, null, `/gds/tours/تور-های-${destinationName}?origin=${origin_country_value}-${origin_city_value}&date=${departure_date}`);

         this.$emit("doSearch")

         await axios
            .post(
               amadeusPath + "ajax",
               {
                  className: "tourSlugController",
                  method: "callReverse",
                  to_json: "1",
                  params: {
                     country_id: destination_country_value,
                     city_id: destination_city_value,
                  },
               },
               {
                  "Content-Type": "application/json",
               }
            )
            .then(async function (response) {
               // await _this.$store.commit("setTourList", response.data.data)
               const data = response.data.data
              console.log('fateme' ,data )
               history.pushState(
                  {},
                  null,
                  `/gds/tours/${data.slug_fa}?origin=${origin_country_value}-${origin_city_value}&date=${departure_date}&type=${type}`
               )
            })
            .catch(function (error) {
               console.log(error)
               // _this.loading = false
            })

         /*
      if (!departure_date) {
        status = false
        this.$swal({
          icon: 'error',
          toast: true,
          position: 'bottom',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 4000,
          title: useXmltag('ChooseDepartureDate'),
        })
      }
      if (!destination_city_value) {
        status = false
        this.$swal({
          icon: 'error',
          toast: true,
          position: 'bottom',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 4000,
          title: useXmltag('ChooseDestination'),
        })
      }
      if (!origin_city_value) {
        status = false
        this.$swal({
          icon: 'error',
          toast: true,
          position: 'bottom',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 4000,
          title: useXmltag('ChooseOrigin'),
        })
      }
      if (status) {
        this.loading.form = true
        let url =
          this.main_url +
          '/' +
          'resultTourLocal' +
          '/' +
          origin_country_value +
          '-' +
          origin_city_value +
          '/' +
          destination_country_value +
          '-' +
          destination_city_value +
          '/' +
          departure_date +
          '/' +
          'all'

        console.log(url)
        window.location.href = url
      }*/
      },

      generateNextFiveMonths() {
         const options = {year: "numeric", month: "long", day: "2-digit"}
         const locale = "fa-IR-u-nu-latn"
         let months = []
         const currentDate = new Date()

         months.push({
            date: "all",
            name: "all",
         })

         for (let i = 0; i < 5; i++) {
            const futureDate = new Date(currentDate)
            futureDate.setMonth(currentDate.getMonth() + i)
            const formattedDate = futureDate.toLocaleDateString(locale, options)
            const formattedNumberDate = futureDate.toLocaleDateString(locale, {
               year: "numeric",
               month: "numeric",
               day: "2-digit",
            })

            const [number_year, number_month, number_day] =
               formattedNumberDate.split("/")

            const paddedMonth = number_month.padStart(2, "0")
            const paddedDay = number_day.padStart(2, "0")

            const monthYear = `${formattedDate.split(" ")[1]} ${
               formattedDate.split(" ")[2]
            }`

            const persianDate = `${number_year}-${paddedMonth}-01`

            if (!months.some(m => m.date === monthYear)) {
               months.push({
                  date: persianDate,
                  name: monthYear,
               })
            }
         }
         this.months = months
      },
      async getDestinationData(new_origin = false) {
         let _this = this
         let nowDate = new Date()

         // replace slashes
         const formattedDate = new Intl.DateTimeFormat("fa-IR-u-nu-latn", {
            year: "numeric",
            month: "2-digit",
            day: "2-digit",
         })
            .format(nowDate)
            .replace(/\//g, "")

         let conditions = [
            {
               index: "start_date",
               table: "reservation_tour_tb",
               operator: ">",
               value: formattedDate,
            },
            {
               index: "origin_country_id",
               table: "reservation_tour_tb",
               operator: "=",
               value: this.tourData.origin_country,
            },
            {
               index: "origin_city_id",
               table: "reservation_tour_tb",
               operator: "=",
               value: this.selectedOriginCity,
            },
            {
               index: "destination_country_id",
               table: "reservation_tour_rout_tb",
               operator: "=",
               value: this.tourData.origin_country,
            },
            {
               index: "is_show",
               table: "reservation_tour_tb",
               value: "yes",
            },
            {
               index: "is_del",
               table: "reservation_city_tb",
               value: "no",
            },
            {
               index: "is_del",
               table: "reservation_tour_tb",
               value: "no",
            },
         ]
         let data = {
            className: "mainTour",
            method: "getTourCities",
            tour_type_title: "dept",
            city_id: this.selectedOriginCity,
            getters: [
               "reservation_city_tb.name as city_title",
               "reservation_city_tb.id as city_value",
               " '' as country_title",
               "reservation_city_tb.id_country as country_value",
            ],
            conditions: conditions,
         }
         await axios
            .post(amadeusPath + "ajax", data, {
               "Content-Type": "application/json",
            })
            .then(async function (response) {
               // await _this.$store.commit("setTourList", response.data.data)
               if (new_origin) {
                  _this.selectedDestinationCity = null
               }
               _this.defaultData.destination_cities = response.data.data
               _this.loading = false
            })
            .catch(function (error) {
               console.log(error)
               _this.loading = false
            })
      },
      async getDestinationCountryData(new_origin = false) {
         let _this = this
         let nowDate = new Date()

         // replace slashes

         let data = {
            className: "mainTour",
            method: "callGetCountry",
            tour_type_title: "dept",
            origin_city_id: this.selectedOriginCity,
         }
         await axios
            .post(amadeusPath + "ajax", data, {
               "Content-Type": "application/json",
            })
            .then(async function (response) {
               // await _this.$store.commit("setTourList", response.data.data)
               if (response.data.status === "success") {
                  if (new_origin) {
                     if (_this.selectedOriginCity === "all") {
                        _this.selectedDestinationCountry = "all"
                        _this.selectedDestinationCity = "all"
                     } else {
                        _this.selectedDestinationCity = null
                     }
                  }

                  _this.defaultData.destination_countries = [
                     {
                        value: "all",
                        title: "همه",
                        name: "همه",
                        id: "all",
                     },
                  ]
                  response.data.data.forEach(item => {
                     _this.defaultData.destination_countries.push(item)
                  })
               }
               _this.loading = false
            })
            .catch(function (error) {
               console.log(error)
               _this.loading = false
            })
      },
      async getDestinationCityData(new_origin = false) {
         let _this = this
         let nowDate = new Date()

         // replace slashes

         let data = {
            className: "mainTour",
            method: "getInternationalTourCities",
            tour_type_title: "dept",
            origin_city_id: this.selectedOriginCity,
            destination_country_id: this.selectedDestinationCountry,
         }
         await axios
            .post(amadeusPath + "ajax", data, {
               "Content-Type": "application/json",
            })
            .then(async function (response) {
               if (
                  response.data.status === "success" &&
                  response.data.data
               )
               {
                  if (new_origin) {
                     if (_this.selectedDestinationCountry === "all") {
                        _this.selectedDestinationCity = "all"
                     } else {
                        _this.selectedDestinationCity = null
                     }
                  }

                  _this.defaultData.destination_cities = [
                     {
                        value: "all",
                        title: "همه",
                        name: "همه",
                        id: "all",
                     },
                  ]
                  response.data.data.forEach(item => {
                     _this.defaultData.destination_cities.push(item)
                  })
               }
               _this.loading = false
            })
            .catch(function (error) {
               console.log(error)
               _this.loading = false
            })
      },
      async getData() {
         let _this = this
         let nowDate = new Date()

         // replace slashes
         const formattedDate = new Intl.DateTimeFormat("fa-IR-u-nu-latn", {
            year: "numeric",
            month: "2-digit",
            day: "2-digit",
         })
            .format(nowDate)
            .replace(/\//g, "")

         let data = {
            className: "mainTour",
            method: "getInternationalTourCities",
            to_json: "1",
            get_init_data: "1",
            destination_country_id: this.selectedDestinationCountry,
            get_origin: "1",
         }
         await axios
            .post(amadeusPath + "ajax", data, {
               "Content-Type": "application/json",
            })
            .then(async function (response) {
               // await _this.$store.commit("setTourList", response.data.data)
               _this.defaultData.origin_cities = [
                  {
                     value: "all",
                     title: "همه",
                     name: "همه",
                     id: "all",
                  },
               ]
               response.data.data.cities.forEach(item => {
                  _this.defaultData.origin_cities.push(item)
               })

               _this.defaultData.types = response.data.data.types
               _this.defaultData.types.unshift({
                  id: "all",
                  tour_type: "همه",
               })
               _this.loading = false
            })
            .catch(function (error) {
               console.log(error)
               _this.loading = false
            })
      },
   },
}
</script>
