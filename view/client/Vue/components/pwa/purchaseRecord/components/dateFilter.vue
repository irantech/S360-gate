<template>
  <div class="search_box">
    <div class="row">

      <div class="col-6 px-2">
        <label class=" w-100 px-2" :class="`${getLang() == 'fa' ? 'text-right' : 'text-left'}`">{{ useXmltag('DateStart') }}</label>
        <div class="form-group">
          <date_picker
            popover
            id="start"
            :locale="`${getLang()}`"
            :auto-submit="true"
            v-model="form.date_range.start"
            :format="`${getLang() == 'fa' ? 'jYYYY-jMM-jDD' : 'YYYY-MM-DD'}`"
            popover="bottom-right" />
        </div>
      </div>

      <div class="col-6 px-2">
        <label class=" w-100 px-2" :class="`${getLang() == 'fa' ? 'text-right' : 'text-left'}`">{{ useXmltag('DateEnd') }}</label>
        <div class="form-group">
          <date_picker
            popover
            id="start"
            :locale="`${getLang()}`"
            :auto-submit="true"
            v-model="form.date_range.end"
            :min="form.date_range.start"
            :format="`${getLang() == 'fa' ? 'jYYYY-jMM-jDD' : 'YYYY-MM-DD'}`"
            popover="bottom-right" />
        </div>
      </div>

      <div class="col-6 px-2">
        <div class="form-group mt-2">
          <label :class="`${getLang() == 'fa' ? 'text-right' : 'text-left'}`" class="w-100">{{ useXmltag('OrderNumber') }}</label>
          <input
            v-model="form.factor_number"
            type="text"
            class="form-control" />
        </div>
      </div>

      <div class="col-6 px-2">
        <div class="form-group mt-2">
          <label :class="`${getLang() == 'fa' ? 'text-right' : 'text-left'}`" class="w-100">{{ useXmltag('Statusreservation') }}</label>
          <select
            class="form-control"
            v-model="form.reserve_status"
            id="reserve_status">
            <option value="">{{ useXmltag('Statusreservation') }}</option>
            <option value="all">{{ useXmltag('All') }}</option>
            <option value="book">{{ useXmltag('Definitivereservation') }}</option>
            <option value="bank">{{ useXmltag('RedirectPayment') }}</option>
            <option value="prereserve">{{ useXmltag('Prereservation') }}</option>
            <option value="nothing">{{ useXmltag('Unknow') }}</option>
            <option value="canceled">{{ useXmltag('Cancel') }}</option>
          </select>
        </div>
      </div>

      <div class="col-12 my-2 px-2">
        <div class="form-group">
          <button @click="search" class="btn btnSub site-bg-main-color">
            {{ useXmltag('Search') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "date-filter",
  props: ["form", "searchTab"],
  methods: {
    search(index) {
      this.$emit("searchTab")
    },
  },
}
</script>
