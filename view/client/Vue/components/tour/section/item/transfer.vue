<template>
  <div v-if='transferData && transferData.airline_name' class="parent-bag-airline">
    <span>{{ transferData.tour_title[0] }}:</span>
    <div class="img-airline-tour">
      <span>{{ transferData.airline_name }}</span>
      <img :src="transferData.vehicle.logo_address" :alt="'img-' + transferData.vehicle.name_en">
    </div>
  </div>
</template>

<script>
export default {
  name: 'tour-section-item-transfer',
  props: {
    transfer: {
      type: Object,
      required: true
    },
    type: {
      type: String,
      default: 'dept'
    }
  },
  computed: {
    transferData() {
      return this.transfer[this.type];
    }
  }
};
</script>
