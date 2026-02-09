<template>
  <div class="owl-flight-parent">
    <div class="title-owl-flight-search">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path class="fa-primary" d="M240 256C213.6 256 192 277.6 192 303.1v160C192 490.4 213.6 512 239.1 512S288 490.4 288 464V303.1C288 277.6 266.4 256 240 256zM80 384C53.6 384 32 405.6 32 431.1v32C32 490.4 53.6 512 79.1 512S128 490.4 128 464v-32C128 405.6 106.4 384 80 384zM400 128C373.6 128 352 149.6 352 175.1v288C352 490.4 373.6 512 399.1 512C426.4 512 448 490.4 448 464V175.1C448 149.6 426.4 128 400 128zM560 0C533.6 0 512 21.6 512 47.1v416C512 490.4 533.6 512 559.1 512S608 490.4 608 464V47.1C608 21.6 586.4 0 560 0z"/></svg>
      <h4> {{ translateXmlByParams('MessageLowestPrice',{'origin' : dataSearch.name_departure , 'destination' : dataSearch.name_arrival}) }} </h4>
    </div>
    <span class="f-loader f-loader-check flightFifteen" id="flightFifteen" v-if="!lowestFlightPrice" >
          <div class="stage filter-contrast">
              <div class="dot-shuttle"></div>
          </div>
    </span>
    <carousel :perPage="slidesPerPage"  ref='carousel' :rtl="true" :navigate-to="20" :navigationEnabled="true" :paginationEnabled="false">
      <template #next>
        <button class="custom-nav next">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
            <path d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" />
          </svg>
        </button>
      </template>
      <template v-for="lowest_price in lowestFlightPrice ">
        <slide>
            <div :class="{'active_searched_date': lowest_price.search_date == dataSearch.departureDate}">
              <a :href="`${lowest_price.url}`" class="link-owl-flight-search" :class="{'link-owl-flight-search-active2': lowest_price.class_min_price}" >
                <span>{{lowest_price.name_date}} - {{ lowest_price.date_for_show}}</span>
                <h6 v-if="lowest_price.price_final !=''">{{ lowest_price.price_final}}</h6>
                <h6 v-else>{{useXmltag('FullCapacity')}}</h6>
              </a>
            </div>
        </slide>
      </template>
    </carousel>
  </div>
</template>

<script>
import { Carousel, Slide } from 'vue-carousel';

export default  {
  name : 'priceCalender' ,

  components:{
    Carousel,
    Slide
  },

  data() {
    return {
      has_calender : false,
      slidesPerPage: 7,
    }
  },
  mounted() {
    this.updateSlidesPerPage(); // مقداردهی اولیه
    window.addEventListener("resize", this.updateSlidesPerPage); // گوش دادن به تغییرات اندازه صفحه
  },
  beforeDestroy() {
    window.removeEventListener("resize", this.updateSlidesPerPage); // پاکسازی Event Listener
  },
  methods : {
    gotopage() {
      this.$refs.carousel.goToSlide(8)
    },
    updateSlidesPerPage() {
      if(window.innerWidth <= 576) {
        this.slidesPerPage = 3;
      }
      else if (window.innerWidth <= 768) {
        this.slidesPerPage = 4; // موبایل
      } else if (window.innerWidth <= 1024) {
        this.slidesPerPage = 4; // تبلت
      } else if (window.innerWidth <= 1025 || window.innerWidth <= 1199) {
        this.slidesPerPage = 5; // دسکتاپ
      }
    },
  },
  computed :{
    dataSearch() {
      return   this.$store.state.setDataSearch.dataSearch
    },
    lowestFlightPrice() {
      return this.$store.state.lowestFlightPrice;
    },
  },
}
</script>