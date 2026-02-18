<template>
   <div class="hotel-modal-overlay" @click.self="close">

      <div class="hotel-modal">

         <!-- Header -->
         <div class="modal-header">
            <h3>جزئیات اقامتگاه</h3>
            <button class="btn-close" @click="close">×</button>
         </div>

         <!-- Gallery Preview -->
         <div class="hotel-gallery">
            <img
               v-if="hotel.gallery.length"
               v-for="(img, i) in hotel.gallery.slice(0,5)"
               :key="i"
               :src="img.thumbnail"
               @click="openLightbox(i)"
            />
         </div>

         <!-- Tabs -->
         <div class="modal-tabs">
            <button
               v-for="tab in tabs"
               :key="tab"
               :class="{ active: activeTab === tab }"
               @click="activeTab = tab"
            >
               {{ tab }}
            </button>
         </div>

         <!-- Content -->
         <div class="modal-body">

            <!-- Facilities -->
            <div v-if="activeTab === 'امکانات'" class="facilities">
               <div v-for="(item, i) in hotel.facilities" :key="i" class="facility-item">
                  <i :class="item[1]"></i>
                  <span>{{ item[0] }}</span>
               </div>
            </div>

            <!-- Description -->
            <div
               v-if="activeTab === 'توضیحات'"
               class="text-box hotel-description"
               v-html="hotel.description"
            ></div>


            <!-- Rules -->
            <div v-if="activeTab === 'قوانین'">
               <div v-for="(rule, i) in hotel.rules" :key="i" class="rule-box">
                  <h4>{{ rule.Name }}</h4>
                  <p>{{ rule.Description }}</p>
               </div>
            </div>

            <!-- Address -->
            <div v-if="activeTab === 'آدرس'" class="text-box">
               {{ hotel.address }}
            </div>

            <!-- Map -->
            <div v-if="activeTab === 'نقشه'" class="map-box">
               <div v-if="mapLoading" class="map-loader">
                  <div class="spinner"></div>
                  <span>در حال بارگذاری نقشه…</span>
               </div>

               <!-- Map -->
               <iframe
                  v-show="!mapLoading"
                  :src="mapUrl"
                  loading="lazy"
                  @load="mapLoading = false"
               ></iframe>

            </div>


         </div>
      </div>

      <!-- Lightbox -->
      <div v-if="lightbox.open" class="lightbox">
         <button class="nav left" @click="prevImage">‹</button>
         <img :src="hotel.gallery[lightbox.index].full" />
         <button class="nav right" @click="nextImage">›</button>
         <span class="close" @click="closeLightbox">×</span>
      </div>

   </div>
</template>

<script>

const YOUR_GALLERY_ARRAY = [
   { full:"https://porsetare.com/gds/pic/205293119image-finall_best.jpg", medium:"https://porsetare.com/gds/pic/205293119image-finall_best.jpg", thumbnail:"https://porsetare.com/gds/pic/205293119image-finall_best.jpg" },
   { full:"https://porsetare.com/gds/pic/45401550IMG_5618_1000.jpg", medium:"https://porsetare.com/gds/pic/45401550IMG_5618_1000.jpg", thumbnail:"https://porsetare.com/gds/pic/45401550IMG_5618_1000.jpg" },
   { full:"https://porsetare.com/gds/pic/154091570IMG_5760_1000.jpg", medium:"https://porsetare.com/gds/pic/154091570IMG_5760_1000.jpg", thumbnail:"https://porsetare.com/gds/pic/154091570IMG_5760_1000.jpg" },
   { full:"https://porsetare.com/gds/pic/554106179BEN00726_1000.jpg", medium:"https://porsetare.com/gds/pic/554106179BEN00726_1000.jpg", thumbnail:"https://porsetare.com/gds/pic/554106179BEN00726_1000.jpg" },
   { full:"https://porsetare.com/gds/pic/224108502IMG_6140_1000.jpg", medium:"https://porsetare.com/gds/pic/224108502IMG_6140_1000.jpg", thumbnail:"https://porsetare.com/gds/pic/224108502IMG_6140_1000.jpg" }
]

const YOUR_FACILITY_ARRAY = [
   ["استخر", "ravis-icon-swimming-pool"],
   ["اینترنت", "fa fa-wifi"],
   ["تاکسی هتل", "fa fa-car"],
   ["صبحانه و بوفه", "ravis-icon-soup-bowl"],
   ["سرویس رایگان", "fa fa-taxi"]
]

export default {

   props: {
      hotelId: { type: Number, required: true }
   },

   data() {
      return {
         hotel: {
            gallery: [],
            facilities: [],
            rules: [],
            description: '',
            address: '',
            map: {
               latitude: '',
               longitude: ''
            }
         },
         activeTab: 'امکانات',
         tabs: ['امکانات', 'توضیحات', 'قوانین', 'آدرس', 'نقشه'],
         lightbox: { open: false, index: 0 },
         gallery: [],
         facilities: [],
         mapLoading: true
      }
   },
   watch: {
      activeTab(val) {
         if (val === 'نقشه') {
            this.mapLoading = true
         }
      }
   },


   computed: {
      mapUrl() {
         if (!this.hotel) return ''
         return `https://maps.google.com/maps?q=${this.hotel.map.latitude},${this.hotel.map.longitude}&z=15&output=embed`
      },

   },

   mounted() {
      this.fetchHotelDetail()
      window.addEventListener('keydown', this.onKeydown)
   },

   beforeDestroy() { // اگر Vue3 داری: beforeUnmount
      window.removeEventListener('keydown', this.onKeydown)
      document.body.style.overflow = ''
   },

   methods: {
      close() {
         this.$emit('close')
      },

      openLightbox(index) {
         this.lightbox.index = index
         this.lightbox.open = true
         document.body.style.overflow = 'hidden'
      },

      closeLightbox() {
         this.lightbox.open = false
         document.body.style.overflow = ''
      },

      nextImage() {
         if (!this.hotel?.gallery?.length) return
         this.lightbox.index = (this.lightbox.index + 1) % this.hotel.gallery.length
      },

      prevImage() {
         if (!this.hotel?.gallery?.length) return
         this.lightbox.index = (this.lightbox.index - 1 + this.hotel.gallery.length) % this.hotel.gallery.length
      },

      onKeydown(e) {
         if (!this.lightbox.open) return
         if (e.key === 'Escape') this.closeLightbox()
         if (e.key === 'ArrowRight') this.nextImage()
         if (e.key === 'ArrowLeft') this.prevImage()
      },

      async fetchHotelDetail() {
         this.loading = true

         const payload = {
            className: 'exclusiveTour',
            method: 'GetHotelDetail',
            data: {hotel_id: this.hotelId}
         }

         try {
            const response = await axios.post(
               amadeusPath + 'ajax',
               payload,
               { headers: { 'Content-Type': 'application/json' } }
            )

            this.hotel = response.data
         } catch (e) {
            console.error('Hotel detail error', e)
         } finally {
            this.loading = false
         }
      }

   }
}
</script>
