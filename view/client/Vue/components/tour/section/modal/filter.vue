<template>
  <div class="modal-tour modal-filter">
    <div class="parent-modal-tour">
      <div class="header-modal-tour">
        <h3>{{ useXmltag('Filters')}}</h3>
        <button @click="hideModal()">{{ useXmltag('JustReturn') }}</button>
      </div>
      <div class="body-modal-tour">
        <tour-filter :tourCount='tourCount'/>
      </div>
      <div class="footer-modal-tour">
        <button @click="hideModal()">اعمال فیلتر</button>
      </div>
    </div>
  </div>
</template>


<script>

import tourFilter from '../filter/main'
export default {
  name: "responsiveFilter",
  props:['tourCount'] ,
  components: {tourFilter},
  data() {
    return {

    }
  },
  methods : {
    hideModal() {
      this.$emit('closeFilterModal')
    }
  },

}
</script>