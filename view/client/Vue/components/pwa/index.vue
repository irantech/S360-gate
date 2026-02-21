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
import information from "./information/index"
import popup from "./components/popup"
export default {
  components: {
    "search-service": searchService,
    "user-profile": userProfile,
    "purchase-record": purchaseRecord,
    "information": information,
  },
  name: "index.vue",
  created() {
    const urlParams = new URLSearchParams(window.location.search)
    const referrer = urlParams.get("to")
    let active_service = ''
    const url = window.location.pathname;
    let url_params = url.split('/')
    let last_url_params = url_params[url_params.length - 1] ;
    if(last_url_params != 'app') {
         active_service = last_url_params;
         if(active_service) {
           let active_params = active_service.split('-')

           this.$store.dispatch("pwaActiveService", {
             service: active_params[0],
             type: active_params[1],
           })
         }

    }
    let available_pages = ["search-service", "purchase-record", "user-profile", "information"]

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
