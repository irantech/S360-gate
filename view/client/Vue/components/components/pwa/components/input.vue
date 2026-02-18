<template>
  <div class="w-100">
    <input
      :ref="_ref"
      :value="value"
      @input="handleInput"
      :type="type ? type : 'text'"
      v-model="input_value"
      class="form-control"
      :disabled="disabled"
      :placeholder="title" />

    <app-loading-spinner :loading="loading"></app-loading-spinner>
  </div>
</template>

<script>
export default {
  name: "appInput",
  props: {
    loading: {
      type: Boolean,
      default: false,
    },
    value: {},
    title: {
      type: String,
      default: "اینجا بنویسید",
    },
    type: {
      type: String,
      default: "text",
    },
    search: {
      default: null,
    },
    _ref: {
      default: null,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    define: {
      type: String,
    },
  },
  data() {
    return {
      input_value: this.value,
    }
  },
  methods: {
    prepareSearchCity(define) {
      console.log("awd")
    },
    handleInput(e) {
      this.$emit("input", this.input_value)
    },
  },
}
</script>
