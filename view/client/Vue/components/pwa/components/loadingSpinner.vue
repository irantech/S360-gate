<template>
  <div v-if="loading" id="loading-holder">
    <img
      class="w-100"
      :src="`${getUrlWithoutLang()}view/client/assets/images/spinner.gif`"
      alt="" />
  </div>
</template>

<script>
export default {
  name: "loadingSpinner",
  props: {
    loading: {
      default: false,
    },
  },
  methods: {},
}
</script>

<style scoped></style>
