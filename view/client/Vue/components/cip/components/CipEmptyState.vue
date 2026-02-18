<template>
   <div class="empty-state-cip">
      <div class="empty-state-content">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="100" height="100" fill="var(--mainColor, #3498db)">
            <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
         </svg>
         <h3>{{ message }}</h3>
         <p v-if="description">{{ description }}</p>
      </div>
   </div>
</template>

<script>
export default {
   name: 'CipEmptyState',
   props: {
      message: {
         type: String,
         default: 'هیچ تشریفاتی یافت نشد'
      },
      description: {
         type: String,
         default: 'لطفا فیلترهای خود را تغییر دهید و دوباره امتحان کنید'
      }
   }
}
</script>
