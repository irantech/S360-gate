<template>
   <aside class="side-bar-tour">
      <div class="filter-side-bar">
         <h2>فیلتر ها</h2>

         <FilterPrice
            :price_tour_filter="price_tour_filter"
            @setPriceFilter="setPriceFilter"
         />

         <FilterName
            @setSearchedName="setSearchedName"
         />

         <!-- جست‌وجوی مجدد -->
         <SearchAgain :to="{ name: 'tour-search' }" />
      </div>
   </aside>
</template>

<script>
import FilterPrice from "./FilterPrice.vue"
import FilterName from "./FilterName.vue"
import SearchAgain from "./SearchAgain.vue"

export default {
   name: 'FilterSidebar',
   components: {
      FilterPrice,
      FilterName,
      SearchAgain
   },
   props: {
      price_tour_filter: {
         type: Array,
         default: () => []
      }
   },
   methods: {
      setSearchedName(value) {
         this.$emit('setSearchedName', value)
      },
      setPriceFilter(valuePrice, checkMinMax) {
         this.$emit('setPriceFilter', valuePrice, checkMinMax)
      }
   }
}
</script>
