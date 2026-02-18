<template>
   <div class="card-tour-search" onclick="showModal('.modal-card')">
      <tour-section-item-link :tour="tour">
         <div class="parent-img-tour">
            <img
               :src="
                  tour.tour_pic === ''
                     ? `${getUrlWithoutLang()}view/client/Vue/assets/images/no-image.jpg`
                     : tour.full_url_tour_pic
               "
               alt="img-tour" />
         </div>
      </tour-section-item-link>
      <div class="parent-body-tour">
         <tour-section-item-link class="w-100" :tour="tour">
            <h2>
               {{ tour.tour_name }}
            </h2>
            <tour-section-item-night :tour="tour" />
         </tour-section-item-link>
         <div
            v-if="tour.pointClub !== null && tour.pointClub !== undefined"
            class="tour-point-club"
         >
            <div class="tour-point-club">
               <i class="flat_cup"></i>

               <span class="point-label">
                    امتیاز شما از این خرید
               </span>
               <span class="point-colon">:</span>
               <span class="point-value"> {{ tour.pointClub }} امتیاز</span>
            </div>

         </div>

         <div class="parent-data-tour">
            <div class="parent-origin-destination">
               <div class="tour-went-return">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                     <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                     <path
                        d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"></path>
                  </svg>
                  <span>مبدا:</span>
                  <h6>
                     {{ tour.origin_country_name }}
                     -
                     {{ tour.origin_city_name }}
                  </h6>
               </div>
               <div class="tour-went-return">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                     <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                     <path
                        d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"></path>
                  </svg>
                  <span>مقصد:</span>
                  <h6>
                     <template v-for="destination in tour.destinations">
                        <span v-if="destination.night != 0">
                           {{ destination.city_name }}
                        </span>
                     </template>
                  </h6>
               </div>
            </div>
            <div class="parent-bag-data-tour">
               <tour-section-item-hotel-star
                  v-if="tour.hotels && tour.hotels.length"
                  :hotels="tour.hotels" />

               <tour-section-item-transfer
                  :transfer="tour.getTypeVehicle"
                  type="dept" />
               <tour-section-item-transfer
                  :transfer="tour.getTypeVehicle"
                  type="return" />
            </div>
         </div>
      </div>
      <div class="parent-price-tour">
         <tour-section-item-price :tour="tour" />
         <div class="parent-nights-tour">
            <p v-if="tour.night != 0">
               {{ tour.night }}
               شب
            </p>
            <p v-else>یک روزه</p>
            <tour-section-item-link class="w-100" :tour="tour">
               <button>
                  <span>رزرو تور</span>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                     <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                     <path
                        d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"></path>
                  </svg>
               </button>
            </tour-section-item-link>
         </div>
      </div>
   </div>
</template>
<script>
import TourSectionItemLink from "./link.vue"
import TourSectionItemHotelStar from "./hotel-star.vue"
import TourSectionItemTransfer from "./transfer.vue"
import TourSectionItemNight from "./night.vue"
import TourSectionItemPrice from "./price.vue"

export default {
   name: "tour-section-item-section",
   components: {
      TourSectionItemPrice,
      TourSectionItemNight,
      TourSectionItemTransfer,
      TourSectionItemHotelStar,
      TourSectionItemLink,
   },
   props: {
      tour: {
         required: true,
         type: Object,
      },
   },


}
</script>