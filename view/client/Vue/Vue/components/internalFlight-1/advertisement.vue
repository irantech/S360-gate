<template>
  <div class="advertises" v-if="advertiseList.length > 0">
    <div class="advertise-item" v-for="(advertise, index) in advertiseList"
         v-html="advertise.content"></div>
  </div>
</template>

<script>
export default {
  name: "advertisement",
  props:['advertiseList'],
}
</script>

<style scoped>

</style>