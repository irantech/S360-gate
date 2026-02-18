<template>
   <div class="search-cip">
      <!-- Loading State -->
      <CipLoading v-if="loading" />

      <!-- Main Content -->
      <div v-else class="parent-search-cip">
         <!-- Filter Sidebar -->
         <FilterSidebar
            :price_cip_filter="priceFilter"
            @setPriceFilter="setPriceFilter" />

      <!--  filter mobile responsive       -->
<!--         <FilterMobile :price_cip_filter="priceFilter"  @setPriceFilter="setPriceFilter" />-->

         <CipList
            v-if="filteredCip.length > 0"
            :cip="filteredCip"
            :request-number="requestNumber"
            :base-url="baseUrl"
            :lang="lang" />

         <CipEmptyState
            v-else
            message="هیچ تشریفاتی یافت نشد"
            description="لطفا فیلترهای خود را تغییر دهید یا دوباره جستجو کنید" />
      </div>
   </div>
</template>
<script>
import VueModal from "@kouts/vue-modal"
import "@kouts/vue-modal/dist/vue-modal.css"
import FilterSidebar from "./filter/FilterSidebar.vue"
import CipList from "./components/CipList.vue"
import CipLoading from "./components/CipLoading.vue"
import CipEmptyState from "./components/CipEmptyState.vue"
import FilterMobile from "./filter/FilterMobile.vue"

export default {

   components: {
      Modal: VueModal,
      FilterSidebar,
      CipList,
      CipLoading,
      CipEmptyState,
      FilterMobile
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

         showFilter: false
      }
   },
   computed: {
      cip() {
         if (!this.$store.state.cipList) return []
         return this.$store.state.cipList || []
      },
      requestNumber() {
         if (!this.$store.state.cipList) return ''
         return this.$store.state.cipList.Code || ''
      },
      baseUrl() {
         return this.getUrlWithoutLang()
      },
      lang() {
         return this.getLang()
      },
      filteredCip() {
         if (this.cip && this.cip.length > 0) {

               const filtered = this.cip
               .filter(cip => {
                  // اگر فیلتر قیمت وجود نداره یا check_min_max درسته، همه رو نشون بده
                  if (!this.filteredPrice || !this.filteredPrice.length || this.check_min_max) {
                     return true
                  }
                  const price = Number(cip.PassengerDatas[0].TotalPrice)
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
         if (!this.cip || this.cip.length === 0) return []
         const prices = this.cip
            .map(cip => Number(cip.PassengerDatas[0].TotalPrice))
            .filter(price => !isNaN(price))
            .sort((a, b) => a - b)
         return prices.length > 0 ? [Math.min(...prices), Math.max(...prices)] : []
      },
   },
   async mounted() {
      await this.doSearch()
   },
   methods: {
      setPriceFilter(valuePrice, checkMinMax) {
         this.filteredPrice = valuePrice
         this.check_min_max = checkMinMax
      },
      async doSearch() {
         this.loading = true
         let dataSearch = this.parseData(this.constData)
         let data = {
            className: "cip",
            method: "GetCip",
            dataSearch: dataSearch,
         }
         let _this = this
         await axios
            .post(amadeusPath + "ajax", data, {
               "Content-Type": "application/json",
            })
            .then(async function (response) {
               _this.loading = false
               const cipList = response.data
               await _this.$store.commit(
                  "setCipList",
                  cipList
               )
            })
            .catch(function (error) {
               _this.loading = false
            })
      },
      parseData(data) {
         const result = {...data}

         return result
      },
   },

}
</script>