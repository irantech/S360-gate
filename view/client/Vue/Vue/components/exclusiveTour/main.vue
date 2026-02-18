<template>
   <div class="search-tour">
      <!-- Loading State -->
      <TourLoading v-if="loading" />

      <!-- Main Content -->
      <div v-else class="parent-search-tour">
         <!-- Filter Sidebar -->
         <FilterSidebar
            :price_tour_filter="priceFilter"
            @setSearchedName="setSearchedName"
            @setPriceFilter="setPriceFilter" />

         <!-- Tour List or Empty State -->
         <TourList
            v-if="filteredTours.length > 0"
            :tours="filteredTours"
            :request-number="requestNumber"
            :base-url="baseUrl"
            :lang="lang" />

         <TourEmptyState
            v-else
            message="هیچ توری یافت نشد"
            description="لطفا فیلترهای خود را تغییر دهید یا دوباره جستجو کنید" />
      </div>
   </div>
</template>
<script>
import VueModal from "@kouts/vue-modal"
import "@kouts/vue-modal/dist/vue-modal.css"
import FilterSidebar from "./filter/FilterSidebar.vue"
import TourList from "./components/TourList.vue"
import TourLoading from "./components/TourLoading.vue"
import TourEmptyState from "./components/TourEmptyState.vue"

export default {

   components: {
      Modal: VueModal,
      FilterSidebar,
      TourList,
      TourLoading,
      TourEmptyState
   },
   props: {
      constData: {
         type: Object,
         required: true,
      },
   },
   data() {
      return {
         loading: false,
         searchedName: null,
         filteredPrice: null,
         check_min_max: true,
      }
   },
   computed: {
      exclusiveTours() {
         if (!this.$store.state.exclusiveTourList) return []
         return this.$store.state.exclusiveTourList.Packages || []
      },
      requestNumber() {
         if (!this.$store.state.exclusiveTourList) return ''
         return this.$store.state.exclusiveTourList.Code || ''
      },
      baseUrl() {
         return this.getUrlWithoutLang()
      },
      lang() {
         return this.getLang()
      },
      filteredTours() {
         if (this.exclusiveTours && this.exclusiveTours.length > 0) {
            const filtered = this.exclusiveTours
               .filter(tour => {
                  return this.searchedName === null
                     ? tour
                     : tour.Hotel.Name.includes(this.searchedName)
               })
               .filter(tour => {
                  // اگر فیلتر قیمت وجود نداره یا check_min_max درسته، همه رو نشون بده
                  if (!this.filteredPrice || !this.filteredPrice.length || this.check_min_max) {
                     return true
                  }

                  const price = Number(tour.TotalPrice)
                  return (
                     price >= this.filteredPrice[0] &&
                     price <= this.filteredPrice[1]
                  )
               })
            return filtered
         }
         return []
      },
      priceFilter() {
         if (!this.exclusiveTours || this.exclusiveTours.length === 0) return []
         const prices = this.exclusiveTours
            .map(tour => Number(tour.TotalPrice))
            .filter(price => !isNaN(price))
            .sort((a, b) => a - b)
         return prices.length > 0 ? [Math.min(...prices), Math.max(...prices)] : []
      },
   },
   async mounted() {
      await this.doSearch()
   },
   methods: {
      setSearchedName(value) {
         this.searchedName = value
      },
      setPriceFilter(valuePrice, checkMinMax) {
         this.filteredPrice = valuePrice
         this.check_min_max = checkMinMax
      },
      async doSearch() {
         this.loading = true
         let dataSearch = this.parseData(this.constData)
         let data = {
            className: "exclusiveTour",
            method: "GetPackage",
            dataSearch: dataSearch,
         }
         let _this = this
         await axios
            .post(amadeusPath + "ajax", data, {
               "Content-Type": "application/json",
            })
            .then(async function (response) {
               _this.loading = false
               const exclusiveTourList = response.data
               await _this.$store.commit(
                  "setExclusiveTourList",
                  exclusiveTourList
               )
            })
            .catch(function (error) {
               _this.loading = false
            })
      },
      parseData(data) {
         const result = {...data}
         result.is_internal = result.is_internal === "1"
         const roomParts = (result.rooms || "").split("R:").filter(Boolean)

         result.Rooms = roomParts.map(room => {
            const [adults, children, agesRaw] = room.split("-")
            const Ages = agesRaw ? agesRaw.split(",").map(Number) : []
            return {
               Adults: Number(adults),
               Children: Number(children),
               Ages,
            }
         })

         delete result.rooms

         return result
      },
   },
}
</script>