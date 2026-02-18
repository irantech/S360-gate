<template>
   <div>
     <popup></popup>
     <div class="content_main_app position-unset">
         <div class="flex flex-wrap">
           <section class="banner-app-hotelato" v-if='client_data.client_id === "327"'>
             <img :src="banner.pic" :alt="banner.title">
             <svg version="1.1" id="circle_banner" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 500 250" enable-background="new 0 0 500 250" xml:space="preserve" preserveAspectRatio="none"><path fill="#FFFFFF" d="M250,246.5c-97.85,0-186.344-40.044-250-104.633V250h500V141.867C436.344,206.456,347.85,246.5,250,246.5z"></path></svg>
           </section>
            <a v-else :href="`${client_data.client_id != '150' ?`/gds/${getLang()}/app` : 'https://www.hoteldebitcard.ir/s/'}`"  class="logo">
               <img
                  :src="client_data.project_files + `/icons/icon-512x512.png`"
                  :alt="`logo`" />
            </a>
            <a v-if="client_data.client_id != '150'"
               :href="`/gds/${getLang()}/app?to=information`"
               class="nav-link align-items-center header-vertical-dots text-dark font-weight-bold"
               data-index="3">
               <svg
                  style="width: 23px; height: 23px px; margin-top: 2px"
                  version="1.1"
class="site-fill-text-color"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                  x="0px"
                  y="0px"
                  viewBox="0 0 1000 1000"
                  enable-background="new 0 0 1000 1000"
                  xml:space="preserve">
                  <g>
                     <path
                        d="M990,210.3c0,38.7-31.3,70-70,70H80c-38.7,0-70-31.3-70-70l0,0c0-38.7,31.3-70,70-70H920C958.5,140.2,990,171.6,990,210.3L990,210.3L990,210.3z" />
                     <path
                        d="M713.4,500c0,38.7-31.3,70-70,70H80c-38.7,0-70-31.3-70-70l0,0c0-38.7,31.3-70,70-70l563.3,0C682,430,713.4,461.3,713.4,500L713.4,500L713.4,500z" />
                    <path
                      d="M503.4,789.7c0,38.7-31.3,70-70,70H80c-38.7,0-70-31.3-70-70l0,0c0-38.7,31.3-70,70-70h353.4C472.1,719.7,503.4,751.2,503.4,789.7L503.4,789.7L503.4,789.7z" />

                  </g>
               </svg>

               <span class="nav-text"></span>
            </a>
           <div class="lang" v-if='lang_logo'>
             <a :href="`${`/gds/${lang_logo}/app`}`"  class="">
                <img alt="img" :src="`${getUrlWithoutLang()}view/client/Vue/assets/images/language-icon-${lang_logo}.png`"/>
             </a>
           </div>
         </div>
         <div class="search_box position-unset container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
               <li
                  v-for="(service, index) in client_data.client_services_detail"
                  class="nav-item"
                  v-if="active_service == '' || (active_service != '' &&  service.MainService.toLowerCase() == active_service)"

                  :class="`order-` + service.order_number">
                  <a
                     class="nav-link"
                     :class="{
                        active:
                           service.order_number === '1' ||
                           (active_service != '' &&  service.MainService.toLowerCase() == active_service) ||
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
                        <span> {{ useXmltag(service.MainService).toLowerCase() }} </span>
                     </h4>
                  </a>
               </li>
            </ul>
            <div class="tab-content position-unset" id="myTabContent">
               <div
                  v-for="(service, index) in client_data.client_services_detail"
                  v-if="(active_service != '' &&  service.MainService.toLowerCase() == active_service) || active_service == ''"
                  :class="{
                     'show active':
                        service.order_number === '1' ||
                        (active_service != '' &&  service.MainService.toLowerCase() == active_service) ||
                        (index === 0 && service.order_number === null),
                  }"
                  class="tab-pane position-unset"
                  :id="service.MainService.toLowerCase()"
                  role="tabpanel"
                  :aria-labelledby="service.MainService.toLowerCase() + `-tab`">
                  <component
                     :main_url="client_data.online_url"
                     :service="service"
                     :is="
                        service.MainService.toLowerCase() + `-tab`
                     "></component>
               </div>
            </div>
         </div>

         <hotel v-show='client_data.client_id === "327"'></hotel>
         <blog v-show='client_data.client_id === "327"'></blog>

<!--               <footer-section :page="pwa_page_data.index"></footer-section>-->
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
import entertainmentTab from "./components/tabs/entertainment/index"
import footerSection from "./../components/footer"
import popup from "../components/popup"
import hotel from "../services/hotel"
import blog from "../services/article"

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
      "visa-tab": visaTab,
      "entertainment-tab": entertainmentTab,
      "footer-section": footerSection,
       "popup":popup,
       "hotel":hotel,
       "blog":blog,
   },
   created() {
       if(this.pwa_page_data.active_service != null) {
         if(this.pwa_page_data.active_service.service != null){
            this.active_service = this.pwa_page_data.active_service.service
         }
       }
      this.$store.dispatch("pwaGetClientData", this.api_gds_client_data())
     this.getBanner();
   },
   computed: {
      client_data() {
         return this.$store.state.pwa_page
      },
     lang_logo() {
       let lang = '' ;
       if(this.client_data.client_id == '358' || this.client_data.client_id == '4') {
         if(this.getLang() == 'ru') {
           lang = 'en'
         }else{
           lang = 'ru'
         }
       }else if(this.client_data.client_id == '368') {
         if(this.getLang() == 'en') {
           lang = 'ru'
         }else{
           lang = 'en'
         }
       }
       return lang
     }
   },
  methods: {
    async getBanner() {

      let _this = this
      await axios
        .post(
          amadeusPath + "ajax",
          {
            className: "galleryBanner",
            method: "listGalleryBannerApi",
            is_active: 1,
            limit: '1',
          },
          {
            "Content-Type": "application/json",
          }
        )
        .then(async function(response) {
          _this.banner = response.data.data[0]
        })
        .catch(async function(error) {
          console.log(error);
        });
    }
  },

   data() {
      return {
         active_service : '' ,
         icons: {
            flight: "&#xe800;",
            hotel: "&#xe808;",
            tour: "&#xe809;",
            train: "&#xe803;",
            bus: "&#xe80c;",
            insurance: "&#xe80d;",
            entertainment: "&#xe804;",
            visa: "&#xe80b;",
         },
          banner : ''
         // main_url:window.location.hostname+'/gds/fa'
      }
   },
}
</script>
