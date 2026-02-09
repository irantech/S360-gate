<template>
   <div v-if="origin" class="w-100 d-block">

      <div v-show="!searchBox" class="box-data-tour">
         <div class="parent-data-tour">
            <div class="">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                  <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                  <path
                     d="M144 56v72h96V56c0-4.4-3.6-8-8-8H152c-4.4 0-8 3.6-8 8zM96 128V56c0-30.9 25.1-56 56-56h80c30.9 0 56 25.1 56 56v72h32c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64v8c0 13.3-10.7 24-24 24s-24-10.7-24-24v-8H112v8c0 13.3-10.7 24-24 24s-24-10.7-24-24l0-8c-35.3 0-64-28.7-64-64V192c0-35.3 28.7-64 64-64H96zM64 176c-8.8 0-16 7.2-16 16V416c0 8.8 7.2 16 16 16H320c8.8 0 16-7.2 16-16V192c0-8.8-7.2-16-16-16H64zm32 72c0-13.3 10.7-24 24-24H264c13.3 0 24 10.7 24 24s-10.7 24-24 24H120c-13.3 0-24-10.7-24-24zm0 112c0-13.3 10.7-24 24-24H264c13.3 0 24 10.7 24 24s-10.7 24-24 24H120c-13.3 0-24-10.7-24-24z" />
               </svg>

               <h3>
                  {{ tourDescription }}
               </h3>
            </div>
            <article>
               <div class="">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                     <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                     <path
                        d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z" />
                  </svg>
                  <h3>
                     {{ formattedDate }}
                  </h3>
               </div>
            </article>
         </div>
         <a @click='openSearchBoxModal()' class="parent-change-search">
            تغییر جستجو
         </a>
      </div>

      <div v-if="searchBox" class="tab-content" id="searchBoxContent">
            <div class="tab-pane active" >
               <div class="radios switches">
                  <div class="switch">
                     <input
                        @click="switchType('international')"
                        :checked="defaultTab === 'international'"
                        autocomplete="off"
                        type="radio"
                        class="switch-input switch-input-tour-js"
                        name="btn_switch_tour"
                        id="btn_switch_tour_international"
                        value="0" />
                     <label
                        for="btn_switch_tour_international"
                        class="switch-label switch-label-on"
                        >خارجی</label
                     >
                     <input
                        @click="switchType('internal')"
                        :checked="defaultTab === 'internal'"
                        autocomplete="off"
                        type="radio"
                        class="switch-input switch-input-tour-js"
                        id='btn_switch_tour_internal'
                        name="btn_switch_tour"
                        value="1"
                      />
                     <label
                        for="btn_switch_tour_internal"
                        class="switch-label switch-label-off"
                        >داخلی</label
                     >
                     <span class="switch-selection"></span>
                  </div>
                  <button
                     @click="searchBox = false"
                     class="close-search-box"
                     type="button">
                     <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512">
                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path
                           d="M180.7 180.7C186.9 174.4 197.1 174.4 203.3 180.7L256 233.4L308.7 180.7C314.9 174.4 325.1 174.4 331.3 180.7C337.6 186.9 337.6 197.1 331.3 203.3L278.6 256L331.3 308.7C337.6 314.9 337.6 325.1 331.3 331.3C325.1 337.6 314.9 337.6 308.7 331.3L256 278.6L203.3 331.3C197.1 337.6 186.9 337.6 180.7 331.3C174.4 325.1 174.4 314.9 180.7 308.7L233.4 256L180.7 203.3C174.4 197.1 174.4 186.9 180.7 180.7zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 32C132.3 32 32 132.3 32 256C32 379.7 132.3 480 256 480C379.7 480 480 379.7 480 256C480 132.3 379.7 32 256 32z"></path>
                     </svg>
                  </button>
               </div>

               <tour-section-header-search-internal-form
                  v-show="defaultTab === 'internal'"
                  @doSearch="doSearch()"
                  :const-data="constData" />
               <tour-section-header-search-international-form
                  v-show="defaultTab === 'international'"
                  @doSearch="doSearch()"
                  :const-data="constData" />
               <input
                  type="hidden"
                  name="type_section"
                  class="type-section-js"
                  value="internal" />
            </div>
         </div>
       <Modal v-model="search_box_modal" v-if='search_box_modal'
            :rtl=true wrapper-class="modal-wrapper">
         <div class="modal-tour modal-filter">
           <div class="parent-modal-tour">
             <div class="header-modal-tour">
               <h3>{{ useXmltag('searchAgain') }}</h3>
               <button @click="hideModal()">{{ useXmltag('JustReturn') }}</button>
             </div>
             <div class="body-modal-tourt">
                <div class="tab-pane active" >
           <div class="radios switches">
             <div class="switch">
               <input
                 @click="switchType('international')"
                 :checked="defaultTab === 'international'"
                 autocomplete="off"
                 type="radio"
                 class="switch-input switch-input-tour-js"
                 name="btn_switch_tour"
                 value="0"
                 id="btn_switch_tour_international" />
               <label
                 for="btn_switch_tour_international"
                 class="switch-label switch-label-on"
               >خارجی</label
               >
               <input
                 @click="switchType('internal')"
                 :checked="defaultTab === 'internal'"
                 autocomplete="off"
                 type="radio"
                 class="switch-input switch-input-tour-js"
                 name="btn_switch_tour"
                 value="1"
                 id="btn_switch_tour_internal" />
               <label
                 for="btn_switch_tour_internal"
                 class="switch-label switch-label-off"
               >داخلی</label
               >
               <span class="switch-selection"></span>
             </div>

           </div>

           <tour-section-header-search-internal-form
             v-show="defaultTab === 'internal'"
             @doSearch="doSearch()"
             :const-data="constData" />
           <tour-section-header-search-international-form
             v-show="defaultTab === 'international'"
             @doSearch="doSearch()"
             :const-data="constData" />
           <input
             type="hidden"
             id="type_section"
             name="type_section"
             class="type-section-js"
             value="internal" />
         </div>
             </div>
           </div>
         </div>
      </Modal>
   </div>
</template>
<script>
import VueSkeletonLoader from 'skeleton-loader-vue'
import TourSectionHeaderSearchInternalForm from './search-internal/form.vue'
import TourSectionHeaderSearchInternationalForm from './search-international/form.vue'

export default {
   name: "tour-section-header-navbar",
   components: {
      TourSectionHeaderSearchInternalForm,
      TourSectionHeaderSearchInternationalForm,
      VueSkeletonLoader,
   },

   data() {
      return {
         searchBox: true,
         search_box_modal : false ,
         windowWidth : window.innerWidth
      }
   },
   computed: {
      constData() {
         return this.$store.state.tours.data
      },
      defaultTab: {
         get() {
            return this.$store.state.tours.defaultTab
         },
         set(new_tab) {
            this.$store.commit("setTourTab", new_tab)
         },
      },
      origin() {
         return this.constData.origin_data
      },
      destination() {
        return this.constData.destination_data
      },
      tourDescription() {
         if (this.origin && this.destination) {
            const originCity =
               this.origin.city === "all" ? "all" : this.origin.city.name
            const originCountry = this.origin.country.name

            const destinationCity =
               this.destination.city === "all"
                  ? "all"
                  : this.destination.city.name
            const destinationCountry = this.destination.country.name

            if (originCity === "all" && destinationCity === "all") {
               return `همه ی تور های ${originCountry} به ${destinationCountry}`
            } else if (originCity === "all") {
               return `همه ی تور های ${destinationCity}`
            } else if (
               originCity &&
               destinationCity === "all" &&
               destinationCountry && destinationCountry!==1
            ) {
               return `همه ی تور های ${destinationCountry} از ${originCity}`
            } else if (
               originCity &&
               destinationCity === "all" &&
               destinationCountry
            ) {
               return `همه ی تور های ${originCity} به ${destinationCountry}`
            } else if (destinationCity === "all" && destinationCountry) {
               return `همه ی تور های ${destinationCountry}`
            } else if (destinationCity === "all") {
               return `همه ی تور های ${originCity}`
            } else if (originCity === destinationCity) {
               return `تور های داخلی ${originCity}`
            } else {
               return `تور های ${originCity} به ${destinationCity}`
            }
         }
      },
      date() {
         return this.constData.date === "all"
            ? new Date()
            : new Date(this.constData.date)
      },
      formattedDate() {
         // Get the date parts separately
         const options = {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
         }
         const dateParts = this.date
            .toLocaleDateString("fa-IR", options)

            .split(" ")

         // Reorder the date parts to match the desired format
         return `${dateParts[3]}, ${dateParts[2]} ${dateParts[1]} ${dateParts[0]}`
      },
   },
   methods: {
     switchType(type) {
       this.defaultTab = type
     },
     openSearchBoxModal() {
       if(this.windowWidth <= 576 ){
         this.search_box_modal = true
       }else{
         this.searchBox = !this.searchBox
       }
     },
      hideSearchBox() {
         this.searchBox = true
      },
      doSearch() {
         this.$emit("doSearch")
      },
     hideModal () {
       this.search_box_modal = false
     }
   },
   created() {
      // add event for if scroll happen then hide search box:
      // window.addEventListener("scroll", () => {
      //   if(this.windowWidth > 576) {
      //     this.hideSearchBox()
      //   }
      //
      // })
   },
}
</script>
