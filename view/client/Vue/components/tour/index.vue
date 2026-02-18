<template>
   <div>
      <section class="search-tour">
         <div class="parent-data-search-box-tour">
            <div class="data-tour">
               <div class="">
                  <tour-section-header-navbar
                     v-if="tourData"
                     @doSearch="doSearch"
                     :const-data="tourData" />
               </div>
            </div>
         </div>
         <div class="">
            <div class="parent-search-tour">
               <tour-section-filter-main
                  v-if="!responsiveMobile"
                  :tourCount="tourCount"
                  :price_tour_filter="tourDefaultPriceFilter"
                  @setSearchedName="setSearchedName"
                  @setVehicle="setVehicle"
                  @setTransportCompany="setTransportCompany"
                  @setPriceFilter="setPriceFilter"
                  @setHotelStar="setHotelStar" />
               <div class="box-tour">
                  <tour-top-filter
                     @openResponsiveFilter="openResponsiveFilter" />
                 <div v-if='tour_loading' data-name="tour-loading" class="align-items-center my-4 flex-wrap gap-10 justify-content-center w-100 " style="text-align: center;">
                   <div class="loader-spinner"></div>
                 </div>
                  <tour-section-item-section
                     v-for="(tour, index) in filteredTours"
                     :key="index"
                     :tour="tour" />
               </div>
            </div>
         </div>
      </section>
     <Transition>
      <Modal
         v-model="responsiveMobile"
         v-if="responsiveMobile"
         :rtl="true"
         wrapper-class="modal-wrapper">
         <div class="modal-tour modal-filter">
            <div class="parent-modal-tour">
               <div class="header-modal-tour">
                  <h3>{{ useXmltag("Filters") }}</h3>
                  <button @click="closeResponsiveFilter()">
                     {{ useXmltag("JustReturn") }}
                  </button>
               </div>
               <div class="body-modal-tour">
                  <tour-section-filter-main
                     :tourCount="tourCount"
                     :price_tour_filter="tourDefaultPriceFilter"
                     @setSearchedName="setSearchedName"
                     @setVehicle="setVehicle"
                     @setTransportCompany="setTransportCompany"
                     @setPriceFilter="setPriceFilter"
                     @setHotelStar="setHotelStar" />
               </div>
               <div class="footer-modal-tour">
                  <button @click="closeResponsiveFilter()">اعمال فیلتر</button>
               </div>
            </div>
         </div>
      </Modal>
     </Transition>
   </div>
</template>
<script>
import TourSectionItemSection from "./section/item/section.vue"
import TourSectionHeaderNavbar from "./section/header/navbar.vue"
import TourSectionFilterMain from "./section/filter/main.vue"
import TourTopFilter from "./section/filter/top.vue"
import responsiveFilter from "./section/modal/filter"
import VueModal from '@kouts/vue-modal';
import '@kouts/vue-modal/dist/vue-modal.css'

export default {
   components: {
      responsiveFilter,
      TourSectionHeaderNavbar,
      TourSectionItemSection,
      TourSectionFilterMain,
      TourTopFilter,
     'Modal' : VueModal,
   },
   props: {
      constData: {
         type: Object,
         required: true,
      },
   },
   data() {
      return {
         responsiveMobile: false,
         loading: false,
         searchedName: null,
         selectedHotelStars: [],
         selectedVehicle: [],
         selectedTransportCompany: [],
         check_min_max: true,
         filteredPrice: [],
         tour_loading :false
      }
   },
   computed: {
      tours() {
         // this.$store.commit("setFilteredTourList", this.doFilter())
         return this.$store.state.tours.list
      },
      filteredTours() {
         if (this.tours && this.tours.length > 0) {
            return this.tours
               .filter(tour => {
                  return this.searchedName === null
                     ? tour
                     : tour.tour_name.includes(this.searchedName)
               })
               .filter(tour => {
                  if (
                     this.selectedHotelStars &&
                     this.selectedHotelStars.length
                  ) {
                     // check one of this.customFilters.stars (array) include inside tour.hotels each and inside of it in hote.star
                     return this.selectedHotelStars.some(star => {
                        if (tour.hotels && tour.hotels.length) {
                           return tour.hotels.some(hotel => {
                              return Number(hotel.star) === Number(star)
                           })
                        } else {
                           if (Number(star) === 0) {
                              return tour
                           }
                        }
                     })
                  } else {
                     return tour
                  }
               })
               .filter(tour => {
                  if (this.selectedVehicle && this.selectedVehicle.length) {
                     // check one of this.selectedVehicle (array) equal to tour.getTypeVehicle.dept.type_vehicle_name or tour.getTypeVehicle.return.type_vehicle_name
                     return this.selectedVehicle.some(vehicle => {
                        if (tour.getTypeVehicle.dept) {
                           if (
                              tour.getTypeVehicle.dept &&
                              tour.getTypeVehicle.dept.type_vehicle_name ===
                                 vehicle
                           ) {
                              return true
                           }
                        }
                        if (tour.getTypeVehicle["return"]) {
                           if (
                              tour.getTypeVehicle["return"] &&
                              tour.getTypeVehicle["return"]
                                 .type_vehicle_name === vehicle
                           ) {
                              return true
                           }
                        }
                        if (Number(vehicle) === 0) {
                           return true
                        }
                     })
                  } else {
                     return tour
                  }
               })
               .filter(tour =>
               {
                  if (
                     this.selectedTransportCompany &&
                     this.selectedTransportCompany.length
                  ) {
                     // check one of this.selectedVehicle (array) equal to tour.getTypeVehicle.dept.type_vehicle_name or tour.getTypeVehicle.return.type_vehicle_name
                     return this.selectedTransportCompany.some(vehicle => {

                        if (tour.getTypeVehicle.dept) {
                           if (
                              tour.getTypeVehicle.dept &&
                              tour.getTypeVehicle.dept.vehicle.abbreviation ===
                                 vehicle
                           ) {
                              return true
                           }
                        }
                        if (tour.getTypeVehicle["return"]) {
                           if (
                              tour.getTypeVehicle["return"] &&
                              tour.getTypeVehicle["return"].vehicle
                                 .abbreviation === vehicle
                           ) {
                              return true
                           }
                        }
                        if (Number(vehicle) === 0) {
                           return true
                        }
                     })
                  } else {
                     return tour
                  }
               })
               .filter(tour => {
                  if (
                     this.tourDefaultPriceFilter &&
                     this.tourDefaultPriceFilter.length
                  ) {
                     return (
                        (tour.discount.discount.after_discount >=
                           this.filteredPrice[0] &&
                           tour.discount.discount.after_discount <=
                              this.filteredPrice[1]) ||
                        (tour.discount.discount.after_discount == null &&
                           this.check_min_max)
                     )
                  } else {
                     return tour
                  }
               })
         }
         return []
      },
      tourData() {
         return this.$store.state.tours.data
      },
      defaultTab: {
         get() {
            return this.$store.state.tours.defaultTab
         },
         set(new_tab) {
            this.$store.commit("setTourTab", new_tab)
         },
      },

      tourDefaultFilters: {
         get() {
            return this.$store.state.tours.filters.defaultData
         },
         set(new_val) {
            this.$store.commit("setTourDefaultFilters", new_val)
         },
      },
      customFilters: {
         get() {
            return this.$store.state.tours.filters.customData
         },
         set(new_val) {
            this.$store.commit("setTourCustomFilters", new_val)
         },
      },
      tourDefaultPriceFilter: {
         get() {
            return this.tourDefaultFilters.prices
         },
         set(new_val) {
            // this.tourDefaultFilters.prices = new_val
            // this.$store.commit("setTourDefaultFilters", new_val)
         },
      },

      tourCount() {
         return this.filteredTours.length
      },
   },
   async mounted() {
      await this.setData()
      await this.doSearch()
   },
   methods: {
      doFilter() {},
      async setData() {
         let data = this.constData
         if (data && data?.origin_data) {
            data.origin_data = JSON.parse(data.origin_data?.replace(/'/g, '"'))
         }

         if (data && data?.destination_data) {
            data.destination_data = JSON.parse(
               data.destination_data?.replace(/'/g, '"')
            )
         }
         await this.$store.commit("setTourData", data)

         const result = this.tourData.destination_data

         if (Number(result.country.id) === 1) {
            this.defaultTab = "internal"
         } else {
            this.defaultTab = "international"
         }
         return result
      },
      async doSearch() {
        this.tour_loading = true
         let formattedDate = this.tourData.date
         if (this.tourData.date === "all") {
            let nowDate = new Date()
            formattedDate = new Intl.DateTimeFormat("fa-IR-u-nu-latn", {
               year: "numeric",
               month: "2-digit",
               day: "2-digit",
            })
               .format(nowDate)
               .replace(/\//g, "")
         }

         let conditions = [
            {
               index: "start_date",
               table: "reservation_tour_tb",
               operator: ">",
               value: formattedDate,
            },

            {
               index: "is_show",
               table: "reservation_tour_tb",
               value: "yes",
            },
            {
               index: "is_del",
               table: "reservation_tour_tb",
               value: "no",
            },
            {
               index: "is_del",
               table: "reservation_tour_tb",
               value: "no",
            },
            {
               index: "tour_title",
               table: "reservation_tour_rout_tb",
               value: "dept",
            }
            // {
            //    index: "night",
            //    table: "reservation_tour_rout_tb",
            //    operator: "!=",
            //    value: 0,
            // },
            // {
            //    index: "is_route_fake",
            //    table: "reservation_tour_rout_tb",
            //    operator: "!=",
            //    value: 0,
            // }
         ]

         if (this.tourData.origin_country !== "all") {
            conditions.push({
               index: "origin_country_id",
               table: "reservation_tour_tb",
               operator: "=",
               value: Number(this.tourData.origin_country),
            })
         }
         if (
            this.tourData.origin_city !== "all" &&
            Number(this.tourData.origin_city) > 0
         ) {
            conditions.push({
               index: "origin_city_id",
               table: "reservation_tour_tb",
               operator: "=",
               value: Number(this.tourData.origin_city),
            })
         }

         if (
            this.tourData.destination_country !== "all" &&
            Number(this.tourData.destination_country) > 0
         ) {
            conditions.push({
               index: "destination_country_id",
               table: "reservation_tour_rout_tb",
               operator: "=",
               value: Number(
                  this.defaultTab === "internal"
                     ? 1
                     : this.tourData.destination_country
               ),
            })
         }

         if (
            this.tourData.destination_city !== "all" &&
            Number(this.tourData.destination_city) > 0
         ) {
            conditions.push({
               index: "destination_city_id",
               table: "reservation_tour_rout_tb",
               operator: "=",
               value: Number(this.tourData.destination_city),
            })
         }
         if (this.tourData.type !== "all") {
            conditions.push({
               index: "tour_type_id",
               table: "reservation_tour_tb",
               operator: "LIKE",
               value: '%"' + Number(this.tourData.type) + '"%',
            })
         }

         conditions.push({
            index: "language",
            table: "reservation_tour_tb",
            operator: "=",
            value: this.tourData.lang,
         })

         let data = {
            className: "mainTour",
            method: "getTourList2",
            limit: "100",
            conditions: conditions,
         }
         let _this = this
         this.$store.commit("setTourLoading", true)
         await axios
            .post(amadeusPath + "ajax", data, {
               "Content-Type": "application/json",
            })
            .then(async function (response) {
              _this.tour_loading = false
               const tours = response.data.data.tours
               const filters = response.data.data.filters
               await _this.$store.commit("setTourList", tours)
               await _this.$store.commit("setTourDefaultFilters", filters)
               await _this.$store.commit("setTourLoading", false)
            })
            .catch(function (error) {
               _this.$store.commit("setTourLoading", false)
            })
      },
      setSearchedName(value) {
         this.searchedName = value
      },
      setHotelStar(stars) {
         this.selectedHotelStars = stars
      },
      setVehicle(vehicles) {
         this.selectedVehicle = vehicles
      },
      setTransportCompany(transportCompany) {
         this.selectedTransportCompany = transportCompany
      },
      setPriceFilter(valuePrice, checkMinMax) {
         this.filteredPrice = valuePrice
         this.check_min_max = checkMinMax
      },
      closeResponsiveFilter() {
         this.responsiveMobile = false
      },
      openResponsiveFilter() {
        this.responsiveMobile = true
      },
   },
}
</script>
<style>
.v-enter-active{
  transition: all 0.3s ease-out;
  right: 0;
}
.v-leave-active{
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}
.v-enter-from,
.v-leave-to {
  transform: translateX(20px);
  opacity: 0;
}
</style>