<template>
  <div class="filter-parent">
    <div class="filter-item">
      <a href="javascript:" :class="{'active-top' : activeFilter == 'priceDesc'}" @click="filterPrice('desc')">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width=""
          height=""
          viewBox="0 0 14 14">
          <g
            fill=""
            stroke=""
            stroke-linecap="round"
            stroke-linejoin="round">
            <path d="M9.5 10.5h4v-4" />
            <path
              d="M13.5 10.5L7.85 4.85a.5.5 0 0 0-.7 0l-2.3 2.3a.5.5 0 0 1-.7 0L.5 3.5" />
          </g>
        </svg>
        <h4>کمترین قیمت</h4>
      </a>
      <a href="javascript:" :class="{'active-top' : activeFilter == 'priceAsc'}"  @click="filterPrice('asc')">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width=""
          height=""
          viewBox="0 0 14 14">
          <g
            fill=""
            stroke=""
            stroke-linecap="round"
            stroke-linejoin="round">
            <path d="M9.5 3.5h4v4" />
            <path
              d="M13.5 3.5L7.85 9.15a.5.5 0 0 1-.7 0l-2.3-2.3a.5.5 0 0 0-.7 0L.5 10.5" />
          </g>
        </svg>
        <h4>بیشترین قیمت</h4>
      </a>
      <a href="javascript:" :class="{'active-top' : activeFilter == 'timeDesc'}" @click="filterTime('desc')">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 576 512">
          <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
          <path
            d="M111 39c9.4-9.4 24.6-9.4 33.9 0l96 96c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-55-55V456c0 13.3-10.7 24-24 24s-24-10.7-24-24V113.9L49 169c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l96-96zm201 9h48c13.3 0 24 10.7 24 24s-10.7 24-24 24H312c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 128H424c13.3 0 24 10.7 24 24s-10.7 24-24 24H312c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 128H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H312c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 128H552c13.3 0 24 10.7 24 24s-10.7 24-24 24H312c-13.3 0-24-10.7-24-24s10.7-24 24-24z" />
        </svg>
        <h4>نزدیکترین قیمت</h4>
      </a>
      <a href="javascript:" :class="{'active-top' : activeFilter == 'timeAsc'}" @click="filterTime('asc')">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 576 512">
          <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
          <path
            d="M15 377l96 96c9.4 9.4 24.6 9.4 33.9 0l96-96c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-55 55V56c0-13.3-10.7-24-24-24s-24 10.7-24 24V398.1L49 343c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9zM312 480h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H312c-13.3 0-24 10.7-24 24s10.7 24 24 24zm0-128H424c13.3 0 24-10.7 24-24s-10.7-24-24-24H312c-13.3 0-24 10.7-24 24s10.7 24 24 24zm0-128H488c13.3 0 24-10.7 24-24s-10.7-24-24-24H312c-13.3 0-24 10.7-24 24s10.7 24 24 24zm0-128H552c13.3 0 24-10.7 24-24s-10.7-24-24-24H312c-13.3 0-24 10.7-24 24s10.7 24 24 24z" />
        </svg>
        <h4>دیرترین قیمت</h4>
      </a>
    </div>
    <div class="parent-filter-responsive">
      <div class="header-filter-responsive" @click.prevent='openSort()'>
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 512 512">
          <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
          <path
            d="M7 377l96 96c9.4 9.4 24.6 9.4 33.9 0l96-96c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-55 55V56c0-13.3-10.7-24-24-24s-24 10.7-24 24V398.1L41 343c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9zM359 39l-96 96c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l55-55V456c0 13.3 10.7 24 24 24s24-10.7 24-24V113.9l55 55c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L393 39c-9.4-9.4-24.6-9.4-33.9 0z"></path>
        </svg>
        <h4>{{ filter_title }}</h4>
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 384 512"
          class="">
          <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
          <path
            d="M362.7 203.9l-159.1 144c-6.125 5.469-15.31 5.469-21.44 0L21.29 203.9C14.73 197.1 14.2 187.9 20.1 181.3C26.38 174.4 36.5 174.5 42.73 180.1L192 314.5l149.3-134.4c6.594-5.877 16.69-5.361 22.62 1.188C369.8 187.9 369.3 197.1 362.7 203.9z"></path>
        </svg>
      </div>

      <ul class="-filter_ul" v-show='openSortItems'>
        <li>
          <div @click="filterPrice('desc' , 'کمترین قیمت')">
            <span> کمترین قیمت </span>
          </div>
        </li>
        <li>
          <div @click="filterPrice('asc' , 'بیشترین قیمت')">
            <span> بیشترین قیمت </span>
          </div>
        </li>
        <li>
          <div @click="filterTime('desc' , 'نزدیکترین قیمت')">
            <span> نزدیکترین قیمت </span>
          </div>
        </li>
        <li>
          <div @click="filterTime('asc', 'دیرترین قیمت')">
            <span> دیرترین قیمت </span>
          </div>
        </li>
      </ul>
    </div>
    <div
      class="parent-filter-responsive-btn"
      @click="openResponsiveFilter()">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 512 512">
        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
        <path
          d="M310.8 64C333.5 64 352 82.46 352 105.2C352 115.6 348.1 125.7 340.1 133.3L247.1 233.4V415.4C247.1 433.4 233.4 448 215.4 448C208.1 448 202.7 446.1 197.4 442.6L121.1 392.8C110.7 385.4 104 372.8 104 359.4V233.4L11.02 133.3C3.936 125.7 0 115.6 0 105.2C0 82.46 18.46 64 41.23 64H310.8zM151.1 224V355.1L199.1 386.8V224C199.1 217.9 202.3 212.1 206.4 207.7L295.2 112H56.75L145.6 207.7C149.7 212.1 151.1 217.9 151.1 224H151.1zM488 392C501.3 392 512 402.7 512 416C512 429.3 501.3 440 488 440H344C330.7 440 320 429.3 320 416C320 402.7 330.7 392 344 392H488zM320 256C320 242.7 330.7 232 344 232H488C501.3 232 512 242.7 512 256C512 269.3 501.3 280 488 280H344C330.7 280 320 269.3 320 256zM488 72C501.3 72 512 82.75 512 96C512 109.3 501.3 120 488 120H408C394.7 120 384 109.3 384 96C384 82.75 394.7 72 408 72H488z" />
      </svg>
      <h4>{{ useXmltag('Filters')}}</h4>
    </div>
  </div>
</template>

<script>

import responsiveFilter from "../modal/filter"
import VueModal from '@kouts/vue-modal';
import '@kouts/vue-modal/dist/vue-modal.css'

export default{
  name : 'tour-top-filter' ,
  props: ['tourCount'] ,
  data() {
     return {
       filter_title : 'مرتب سازی' ,
       openSortItems : false ,
       activeFilter  : ''
     }
  },
  components: {

    'Modal' : VueModal,
  },
  methods : {
    openSort() {
      this.openSortItems = !this.openSortItems
    } ,
    filterPrice(type , title) {
      this.filter_title = title
      this.openSortItems = false
      if(type == 'desc') {
        this.activeFilter = 'priceDesc'
      }else{
        this.activeFilter = 'priceAsc'
      }

      this.$store.commit('priceSortTour', type);
    },
    filterTime(type , title) {
      this.filter_title = title
      this.openSortItems = false
      if(type == 'desc') {
        this.activeFilter = 'timeDesc'
      }else{
        this.activeFilter = 'timeAsc'
      }

      this.$store.commit('timeSortTour', type);
    } ,
    openResponsiveFilter() {
      this.$emit('openResponsiveFilter')
    },
    close (e) {
      if (!this.$el.contains(e.target)) {
        this.openSortItems = false
      }
    }
  } ,
  mounted () {
    document.addEventListener('click', this.close)
  },
  beforeDestroy () {
    document.removeEventListener('click',this.close)
  }
}
</script>