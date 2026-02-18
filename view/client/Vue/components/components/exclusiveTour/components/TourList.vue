<template>
   <div class="box-tour">
      <TourCard
         v-for="(tour, index) in tours"
         :key="index"
         :tour="tour"
         :request-number="requestNumber"
         :base-url="baseUrl"
         :lang="lang" />
   </div>
</template>

<script>
import TourCard from './TourCard.vue'

export default {
   name: 'TourList',
   components: {
      TourCard
   },
   props: {
      tours: {
         type: Array,
         required: true,
         default: () => []
      },
      requestNumber: {
         type: String,
         required: true
      },
      baseUrl: {
         type: String,
         required: true
      },
      lang: {
         type: String,
         required: true
      }
   }
}
</script>
