<template>
  <div>
    <component
      :pwa_page_data="pwa_page_data"
      :is="pwa_page_data.index"></component>
  </div>
</template>

<script>
import searchService from "./searchService/index"
import userProfile from "./userProfile/index"
import purchaseRecord from "./purchaseRecord/index"
export default {
  components: {
    "search-service": searchService,
    "user-profile": userProfile,
    "purchase-record": purchaseRecord,
  },
  name: "index.vue",
  created() {
    const urlParams = new URLSearchParams(window.location.search)
    const referrer = urlParams.get("to")
    let available_pages = ["search-service", "purchase-record", "user-profile"]

    if (referrer) {
      for (let key in available_pages) {
        if (referrer === available_pages[key]) {
          this.$store.dispatch("pwaChangePage", {
            index: available_pages[key],
          })
        }
      }
    }
  },
  computed: {
    pwa_page_data() {
      return this.$store.state.pwa_page
    },
  },
}
</script>

<style scoped></style>
