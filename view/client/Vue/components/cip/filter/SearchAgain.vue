<template>
   <div class="search-again-wrapper">
      <button
         class="btn-search-again"
         type="button"
         @click="go"
      >
         جست‌وجوی مجدد
      </button>
   </div>
</template>

<script>
export default {
   name: 'SearchAgain',
   methods: {
      go() {
         window.location.href = '/gds/fa/page/cip'
      }
   }
}
</script>
