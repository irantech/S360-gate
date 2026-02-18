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
                     @change="getDestinationData(true)"
                     v-model="selectedOriginCity"
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
                     v-model="selectedDestinationCity"
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
   name: "tour-section-header-search-internal-form",
   data() {
      return {
         selectedOriginCity: null,
         selectedDestinationCity: null,
         selectedDate: null,
         selectedType: null,
         months: [],
         tourTypes: [],
         defaultData: {
            types: [],
            origin_cities: [],
            destination_cities: [],
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
     if(this.$store.state.tours.defaultTab == 'internal') {
       this.selectedType = this.tourData.type
       if (this.tourData.lang == 'fa' && this.tourData.date != 'all') {

         this.selectedDate = new Intl.DateTimeFormat("fa-IR-u-nu-latn", {
           year: "numeric",
           month: "2-digit",
           day: "2-digit",
         })
           .format(new Date(this.tourData.date))
           .replace(/\//g, "-")
       } else {
         this.selectedDate = this.tourData.date
       }

       this.selectedOriginCity = Number(this.tourData.origin_city)
         ? Number(this.tourData.origin_city)
         : this.tourData.origin_city
       this.selectedDestinationCity = Number(this.tourData.destination_city)
         ? Number(this.tourData.destination_city)
         : this.tourData.destination_city
     }




      await this.getDestinationData()
   },
   methods: {
      async doSearchInit() {
         let status = true
         let origin_city_value = this.selectedOriginCity
         let destination_city_value = this.selectedDestinationCity
         let origin_country_value = 1
         let destination_country_value = 1
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
         tourData.destination_city = Number(this.selectedDestinationCity)
            ? Number(this.selectedDestinationCity)
            : this.selectedDestinationCity
         tourData.type = this.selectedType
         tourData.date = this.selectedDate.replaceAll("-", "")

         this.$store.commit("setTourList", tourData)

         const originName = this.defaultData.origin_cities.find(item => {
            if (origin_city_value === "all") {
               return item.id === "all"
            } else {
               const id = item?.id
                  ? Number(item.id)
                     ? Number(item.id)
                     : item.id
                  : Number(item?.value)
                  ? Number(item?.value)
                  : item?.value

               return id === Number(origin_city_value)
            }
         })

         const destinationName = this.defaultData.destination_cities.find(
            item => {
               if (destination_city_value === "all") {
                  return item.id === "all"
               } else {
                  return Number(item.id) === Number(destination_city_value)
               }
            }
         )
         // history.pushState({}, null, `/gds/tours/تور-های-${destinationName}?origin=${origin_country_value}-${origin_city_value}&date=${departure_date}`);

         this.$emit("doSearch")
        console.log('1o')
        console.log(this.tourData.origin_data.city)
        console.log(this.selectedOriginCity)

        if(this.tourData.origin_data.city == 'all') {
          this.tourData.origin_data.city.id = 'all'
        }
         this.tourData.origin_data.city.id = Number(this.selectedOriginCity)
            ? Number(this.selectedOriginCity)
            : this.selectedOriginCity
        console.log('1-1')
         this.tourData.origin_data.city.name = originName.title
            ? originName.title
            : originName.name
        console.log('2')
         this.tourData.destination_data.city = {
            id: Number(this.selectedDestinationCity)
               ? Number(this.selectedDestinationCity)
               : this.selectedDestinationCity,
            name: destinationName.title
               ? destinationName.title
               : destinationName.name,
         }
        console.log('3')
         await this.$store.commit("setTourData", this.tourData)
        console.log('4')
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

         let data = {
            className: "mainTour",
            method: "getTourCities",
            tour_type_title: "dept",
            city_id: this.selectedOriginCity,
         }
         await axios
            .post(amadeusPath + "ajax", data, {
               "Content-Type": "application/json",
            })
            .then(async function (response) {
               // await _this.$store.commit("setTourList", response.data.data)
               if (new_origin) {
                  _this.selectedDestinationCity = "all"
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
               _this.loading = false
            })
            .catch(function (error) {
               console.log(error)
               _this.loading = false
            })
      },
      async getData() {
         let _this = this

         let data = {
            className: "mainTour",
            method: "getInternalTourCities",
            to_json: "1",
            get_init_data: "1",

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
