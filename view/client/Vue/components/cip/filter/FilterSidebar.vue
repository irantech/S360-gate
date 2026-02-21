<template>
   <aside class="side-bar-cip">
      <div class="filter-side-bar">
<!--         <h2>فیلتر ها</h2>-->

<!--         <FilterPrice-->
<!--            :price_cip_filter="price_cip_filter"-->
<!--            @setPriceFilter="setPriceFilter"-->
<!--         />-->

         <!-- جست‌وجوی مجدد -->
         <SearchAgain :to="{ name: 'cip-search' }" />
      </div>
   </aside>
</template>

<script>
import FilterPrice from "./FilterPrice.vue"
import SearchAgain from "./SearchAgain.vue"

export default {
   name: 'FilterSidebar',
   components: {
      FilterPrice,
      SearchAgain
   },
   props: {
      price_cip_filter: {
         type: Array,
         default: () => []
      }
   },
   methods: {
      setPriceFilter(valuePrice, checkMinMax) {
         this.$emit('setPriceFilter', valuePrice, checkMinMax)
      }
   }
}
</script>
