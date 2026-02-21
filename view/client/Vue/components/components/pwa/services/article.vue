<template>
  <section class="box-app-hotelato">
    <div class="container-app-hotelato">
      <h2>وبلاگ</h2>
      <div class="swiper-container owl-box-app-hotelato">
        <div class="swiper-wrapper ">
          <div class="swiper-slide" v-for='(blog , index) in blog_list' :key='index'>
            <a :href="blog.link" class="link-parent-box-app-hotelato">
              <img :src="blog.image" :alt="blog.image">
              <h3>{{ blog.title }}</h3>
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
  name: "blogs",
  components: {

  },

  data() {
    return {
      blog_list : []
    }
  },
  created() {
    this.getBlogs();
  },
  computed: {
  },
  methods: {
    async getBlogs() {
      let _this = this
      await axios
        .post(
          amadeusPath + "ajax",
          {
            className: "articles",
            method: "apiGetArticle",
            service: 'Public',
            section: 'article',
            limit: '6'
          },
          {
            "Content-Type": "application/json",
          }
        )
        .then(async function (response) {
          _this.blog_list = response.data.data
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
