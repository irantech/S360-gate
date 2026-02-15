<template>
  <div class='modal_style_parent'>
    <div class="modal-flight modal-filter" style='right:0 !important;'>
      <div class="parent-modal-flight">
        <div class="header-modal-flight">
          <h3>{{ useXmltag('Filters')}}</h3>
          <button @click="hideModal()">{{ useXmltag('JustReturn') }}</button>
        </div>
        <div class="body-modal-flight">
          <side-filter :flight_count='flight_count' :type="type"/>
        </div>
        <div class="footer-modal-flight">
          <button  @click="hideModal()"> اعمال فیلتر</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import sideFilter from '../sideFilter'

export default {
  name: 'responsive-filter',
  props :['flight_count' , 'type'],
  methods : {
    hideModal() {
      this.$emit('closeFilterModal')
    }
  },
  components: {
    'side-filter': sideFilter
  },
}
</script>
