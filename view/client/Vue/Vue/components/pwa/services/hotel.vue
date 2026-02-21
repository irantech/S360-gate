<template>
  <section class="box-app-hotelato" v-if='hotel_list.length > 0'>
    <div class="container-app-hotelato">
      <h2>پیشنهاد ما</h2>
      <div class="swiper-container owl-box-app-hotelato">
        <div class="swiper-wrapper ">
          <div class="swiper-slide" v-for='(hotel , index) in hotel_list' :key='index'>
            <a :href="`${client_data.online_url}/detailHotel/api/${hotel.HotelIndex}`" class="link-parent-box-app-hotelato">
              <img :src="hotel.Picture" :alt="hotel.Name">
              <h3>{{ hotel.Name }}</h3>
            </a>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>
<script>

import Swiper from 'swiper';
import 'swiper/css/swiper.css';
export default {
  name: "hotels",
  data() {
    return {
      hotel_list : []
    }
  },
  created() {
    this.getHotels();
  },
  computed: {
    client_data() {
      return this.$store.state.pwa_page
    },
  },
  methods: {
    async getHotels() {
      let _this = this
      await axios
        .post(
          amadeusPath + "ajax",
          {
            className: "resultHotelLocal",
            method: "apiGetHotelWebservice",
            type: 'internal',
            Count: '6',
          },
          {
            "Content-Type": "application/json",
          }
        )
        .then(async function (response) {
          _this.hotel_list = response.data.data
          _this.$nextTick(() => {
            _this.swiper = new Swiper('.swiper-container', {
              slidesPerView: 2,
              spaceBetween: 10,
              loop: true,
            });
          });
        })
        .catch(async function (error) {
          console.log(error);
        });
    }
  },

}
</script>
