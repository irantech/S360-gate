<template>
   <div>
      <div class="content_main_app position-unset">
         <a href="/gds/app" class="logo">
            <img
               :src="client_data.project_files + `/icons/icon-512x512.png`"
               :alt="`logo`" />
         </a>

         <div class="search_box position-unset container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
               <li
                  v-for="(service, index) in client_data.client_services_detail"
                  class="nav-item"
                  :class="`order-` + service.order_number">
                  <a
                     class="nav-link"
                     :class="{
                        active:
                           service.order_number === '1' ||
                           (index === 0 && service.order_number === null),
                     }"
                     :id="service.MainService.toLowerCase() + '-tab'"
                     data-toggle="tab"
                     :href="`#` + service.MainService.toLowerCase()"
                     role="tab"
                     :aria-controls="service.MainService.toLowerCase()"
                     aria-selected="true">
                     <h4>
                        <i
                           class="icon-tab icon-airplane"
                           v-html="icons[service.MainService.toLowerCase()]">
                        </i>
                        <span>{{ service.Title }}</span>
                     </h4>
                  </a>
               </li>
            </ul>
            <div class="tab-content position-unset" id="myTabContent">
               <div
                  v-for="(service, index) in client_data.client_services_detail"
                  :class="{
                     'show active':
                        service.order_number === '1' ||
                        (index === 0 && service.order_number === null),
                  }"
                  class="tab-pane position-unset"
                  :id="service.MainService.toLowerCase()"
                  role="tabpanel"
                  :aria-labelledby="service.MainService.toLowerCase() + `-tab`">
                  <component
                     :main_url="client_data.online_url"
                     :is="
                        service.MainService.toLowerCase() + `-tab`
                     "></component>
               </div>
            </div>
         </div>

         <!--      <footer-section :page="pwa_page_data.index"></footer-section>-->
      </div>
   </div>
</template>
<script>
import flightTab from "./components/tabs/flight/index"
import hotelTab from "./components/tabs/hotel/index"
import tourTab from "./components/tabs/tour/index"
import trainTab from "./components/tabs/train/index"
import busTab from "./components/tabs/bus/index"
import insuranceTab from "./components/tabs/insurance/index"
import visaTab from "./components/tabs/visa/index"
import footerSection from "./../components/footer"

export default {
   name: "searchService",
   props: ["pwa_page_data"],
   components: {
      "flight-tab": flightTab,
      "hotel-tab": hotelTab,
      "tour-tab": tourTab,
      "train-tab": trainTab,
      "bus-tab": busTab,
      "insurance-tab": insuranceTab,
      "footer-section": footerSection,
   },
   created() {
      this.$store.dispatch("pwaGetClientData", this.api_gds_client_data())
   },
   computed: {
      client_data() {
         return this.$store.state.pwa_page
      },
   },

   data() {
      return {
         icons: {
            flight:
               "\n" +
               '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M482.3 192C516.5 192 576 221 576 256C576 292 516.5 320 482.3 320H365.7L265.2 495.9C259.5 505.8 248.9 512 237.4 512H181.2C170.6 512 162.9 501.8 165.8 491.6L214.9 320H112L68.8 377.6C65.78 381.6 61.04 384 56 384H14.03C6.284 384 0 377.7 0 369.1C0 368.7 .1818 367.4 .5398 366.1L32 256L.5398 145.9C.1818 144.6 0 143.3 0 142C0 134.3 6.284 128 14.03 128H56C61.04 128 65.78 130.4 68.8 134.4L112 192H214.9L165.8 20.4C162.9 10.17 170.6 0 181.2 0H237.4C248.9 0 259.5 6.153 265.2 16.12L365.7 192H482.3z"/></svg>',
            hotel: "&#xe808;",
            tour: "&#xe809;",
            train: "&#xe803;",
            bus: "&#xe80c;",
            insurance: "&#xe80d;",
            visa: "&#xe80d;",
         },
         // main_url:window.location.hostname+'/gds/fa'
      }
   },
}
</script>
