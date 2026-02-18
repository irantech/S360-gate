<template>
   <div class="box-cip">
      <CipCard
         v-for="(cipItem, index) in cip"
         :key="index"
         :cip="cipItem"
         :request-number="requestNumber"
         :base-url="baseUrl"
         :lang="lang" />

   </div>
</template>

<script>
import CipCard from './CipCard.vue'

export default {
   name: 'CipList',
   components: {
      CipCard
   },
   props: {
      cip: {
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
