<template>
  <div>
    <div class="filter-parent">
      <currency-filter v-if="dataSearch && dataSearch.is_currency > 0" />
      <div class="filter-item">
        <time-filter :type='type'/>
        <price-filter :type='type' />
        <capacity-filter :type='type'/>

      </div>
      <div class="parent-filter-responsive">
        <div class="header-filter-responsive" @click='openSort()'>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M7 377l96 96c9.4 9.4 24.6 9.4 33.9 0l96-96c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-55 55V56c0-13.3-10.7-24-24-24s-24 10.7-24 24V398.1L41 343c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9zM359 39l-96 96c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l55-55V456c0 13.3 10.7 24 24 24s24-10.7 24-24V113.9l55 55c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L393 39c-9.4-9.4-24.6-9.4-33.9 0z"/></svg>
          <h4>{{ textSort }}</h4>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class=""><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M362.7 203.9l-159.1 144c-6.125 5.469-15.31 5.469-21.44 0L21.29 203.9C14.73 197.1 14.2 187.9 20.1 181.3C26.38 174.4 36.5 174.5 42.73 180.1L192 314.5l149.3-134.4c6.594-5.877 16.69-5.361 22.62 1.188C369.8 187.9 369.3 197.1 362.7 203.9z"></path></svg>
        <ul class="-filter_ul" v-show='openSortItems'>
          <li @click='closedSort("time")'>
            <div>
              <time-filter :type='type'/>
            </div>
          </li>
          <li @click='closedSort("price")'>
            <div>
              <price-filter :type='type'/>
            </div>
          </li>
          <li @click='closedSort("capacity")'>
            <div>
              <capacity-filter :type='type'/>
            </div>
          </li>
        </ul>
      </div>
      <div class="parent-filter-responsive-btn" @click='openResponsiveFilter()'>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M151.6 469.6C145.5 476.2 137 480 128 480s-17.5-3.8-23.6-10.4l-88-96c-11.9-13-11.1-33.3 2-45.2s33.3-11.1 45.2 2L96 365.7V64c0-17.7 14.3-32 32-32s32 14.3 32 32V365.7l32.4-35.4c11.9-13 32.2-13.9 45.2-2s13.9 32.2 2 45.2l-88 96zM320 480c-17.7 0-32-14.3-32-32s14.3-32 32-32h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H320zm0-128c-17.7 0-32-14.3-32-32s14.3-32 32-32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H320zm0-128c-17.7 0-32-14.3-32-32s14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H320zm0-128c-17.7 0-32-14.3-32-32s14.3-32 32-32H544c17.7 0 32 14.3 32 32s-14.3 32-32 32H320z"/></svg>
        <h4>{{ useXmltag('Filters')}}</h4>
      </div>
      <previous-next-day-filter :type='type'/>
    </div>
    <Modal v-model="responsiveMobile" v-if='responsiveMobile'
           :rtl=true wrapper-class="modal-wrapper">
      <responsive-filter @closeFilterModal='closeResponsiveFilter()' :type='type' :flight_count='flight_count'/>
    </Modal>
  </div>

</template>

<script>
import currency from './filters/currency'
import previousNextDay from './filters/previousNextDay'
import time from './filters/time'
import price from './filters/price'
import capacity from './filters/capacity'
import responsiveFilter from '../global/modal/resFilter'
import VueModal from '@kouts/vue-modal';
import '@kouts/vue-modal/dist/vue-modal.css'
export default  {
  name : 'topFilter' ,
  props :[
    'type',
    'flight_count'
  ],
  components : {
    'previous-next-day-filter'  : previousNextDay,
    'currency-filter'  : currency,
    'time-filter'  : time,
    'price-filter'  : price,
    'capacity-filter'  : capacity,
    'responsive-filter'  : responsiveFilter,
    'Modal' : VueModal,
  },
  data() {
    return {
      openSortItems : false ,
      responsiveMobile : false,
      textSort:'',

    }
  },
  created(){
    this.textSort = this.useXmltag('Sorting');
  },
  methods : {
    openSort() {
      this.openSortItems = !this.openSortItems
    } ,
    openResponsiveFilter() {
      this.$store.commit('setMobileHeaderSearchBox',false)
      let _this = this
      _this.responsiveMobile =  true
    },
    closeResponsiveFilter() {
      this.$store.commit('setMobileHeaderSearchBox',true)
      let _this = this
      _this.responsiveMobile =  false
    },
    closedSort(sortType){
      if (sortType === 'time') {
        this.textSort = 'زمان';
      } else if(sortType === 'price') {
        this.textSort = 'قیمت';
      } else if(sortType === 'capacity') {
         this.textSort = 'ظرفیت';
      }
      this.openSort();
    }
  },
  computed: {
    dataSearch() {
      return this.$store.state.setDataSearch.dataSearch
    }
  }
}
</script>