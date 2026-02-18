+

<template>
   <div class="card-tour-search" onclick="showModal('.modal-card')">
      <div class="parent-img-tour">
         <img
            :src="tour.Hotel.pic"
            @error="handleImageError"
         />
      </div>

      <div class="parent-body-tour">
         <h2>{{ tour.Hotel.Name }}</h2>

         <div class="parent-data-tour">
            <div class="parent-origin-destination">
               <!-- رفت -->
               <div class="tour-went-return">
                  <span>پرواز رفت:</span>
                  <div>
                     <img :src="`${baseUrl}pic/airline/${tour.OutputRoutes.Airline.Logo}`" />
                     {{ tour.OutputRoutes.Airline.Name }}
                  </div>
                  <div>
                     <i class="fa-solid fa-plane"></i>
                     {{ tour.OutputRoutes.FlightNo }}
                  </div>
                  <div>
                     <i class="fa-solid fa-clock"></i>
                     {{ tour.OutputRoutes.DepartureTime }}
                  </div>
               </div>

               <!-- برگشت -->
               <div class="tour-went-return">
                  <span>پرواز برگشت:</span>
                  <div>
                     <img :src="`${baseUrl}pic/airline/${tour.ReturnRoutes.Airline.Logo}`" />
                     {{ tour.ReturnRoutes.Airline.Name }}
                  </div>
                  <div>
                     <i class="fa-solid fa-plane"></i>
                     {{ tour.ReturnRoutes.FlightNo }}
                  </div>
                  <div>
                     <i class="fa-solid fa-clock"></i>
                     {{ tour.ReturnRoutes.DepartureTime }}
                  </div>
               </div>
            </div>
         </div>

         <div class="tour-hotel-action">
            <button class="tour-hotel-action__btn" @click.stop="openHotelModal">
               امکانات هتل
            </button>
         </div>
         <HotelDetailModal
            v-if="showHotelModal"
            :hotel-id="tour.Hotel.Id"
            @close="showHotelModal = false"
         />
      </div>

      <div class="parent-price-tour">
         <div class="parent-nights-tour">
            <div class="parent-price-discount-tour">
               <span>شروع از قیمت:</span>
               <div class="price-discount">
                  <div class="price-total">
                     <span>{{ formatPrice(tour.TotalPrice) }}</span>
                     ریال
                  </div>
               </div>
            </div>

            <a :href="`${baseUrl}${lang}/exclusive-tour-detail/${requestNumber}/${tour.SourceId}/${tour.Hotel.Id}`">
               <span>رزرو تور</span>
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                  <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"></path>
               </svg>
            </a>
         </div>
      </div>
   </div>
</template>

<script>
import HotelDetailModal from './HotelDetailModal.vue'
export default {
   components: { HotelDetailModal },
   data() {
      return {
         showHotelModal: false
      }
   },
   name: 'TourCard',
   props: {
      tour: {
         type: Object,
         required: true
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
   },
   methods: {
      formatPrice(price) {
         const num = Number(price)
         if (isNaN(num)) return '0'
         return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')
      },
      handleImageError(event) {
         event.target.src = 'https://192.168.1.100/gds/view/client/Vue/assets/images/no-image.jpg'
      },
      openHotelModal() {
         this.showHotelModal = true
      }
   }
}
</script>
