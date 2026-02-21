<template>
   <aside class="side-bar-tour">
        <tour-section-filter-count :tourCount='tourCount'/>
        <div class="filter-side-bar">
          <h2>فیلتر ها</h2>
          <tour-section-filter-price :price_tour_filter='price_tour_filter' @setPriceFilter='setPriceFilter'/>
          <tour-section-filter-name @setSearchedName='setSearchedName'/>
          <tour-section-filter-hotel-star @setHotelStar='setHotelStar'/>
          <tour-section-filter-transportation-type @setVehicle='setVehicle'/>
          <tour-section-filter-transportation @setTransportCompany='setTransportCompany'/>
        </div>
      </aside>
</template>

<script>
  import TourSectionFilterCount from "./count.vue"
  import TourSectionFilterPrice from "./price.vue"
  import TourSectionFilterName from "./name.vue"
  import TourSectionFilterHotelStar from "./hotelStar.vue"
  import TourSectionFilterTransportationType from "./transportationType.vue"
  import TourSectionFilterTransportation from "./transportation.vue"

  export default{
    name : 'tour-filter' ,
    components: {TourSectionFilterCount, TourSectionFilterPrice ,TourSectionFilterName ,
      TourSectionFilterHotelStar , TourSectionFilterTransportationType ,  TourSectionFilterTransportation},
    props : ['tourCount' ,'price_tour_filter'] ,
    methods : {
      setSearchedName(value) {
        this.$emit('setSearchedName' , value)
      },
      setVehicle(value) {
        this.$emit('setVehicle' , value)
      },
      setTransportCompany(value) {
        this.$emit('setTransportCompany' , value)
      },
      setHotelStar(value) {
        this.$emit('setHotelStar' , value)
      },
      setPriceFilter(valuePrice , checkMinMax) {
        this.$emit('setPriceFilter'  , valuePrice , checkMinMax)
      }
    }
  }
</script>