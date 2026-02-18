<template>
  <div class="search_box">
    <div class="row">
      <label class="text-right w-100 px-2">تاریخ</label>
      <div class="col-6 px-2">
        <div class="form-group">
          <date_picker
            popover
            id="start"
            locale="fa"
            :auto-submit="true"
            v-model="form.date_range.start"
            format="jYYYY-jMM-jDD"
            popover="bottom-right" />
        </div>
      </div>

      <div class="col-6 px-2">
        <div class="form-group">
          <date_picker
            popover
            id="start"
            locale="fa"
            :auto-submit="true"
            v-model="form.date_range.end"
            :min="form.date_range.start"
            format="jYYYY-jMM-jDD"
            popover="bottom-right" />
        </div>
      </div>

      <div class="col-6 px-2">
        <div class="form-group mt-2">
          <label class="text-right w-100">شماره سفارش</label>
          <input
            v-model="form.factor_number"
            type="text"
            class="form-control" />
        </div>
      </div>

      <div class="col-6 px-2">
        <div class="form-group mt-2">
          <label class="text-right w-100">وضعیت رزرو</label>
          <select
            class="form-control"
            v-model="form.reserve_status"
            id="reserve_status">
            <option value="">وضعیت رزرو</option>
            <option value="all">همه</option>
            <option value="book">رزرو قطعی</option>
            <option value="bank">هدایت به درگاه پرداخت</option>
            <option value="prereserve">پیش رزرو</option>
            <option value="nothing">نا مشخص</option>
            <option value="canceled">کنسلی</option>
          </select>
        </div>
      </div>

      <div class="col-12 my-2 px-2">
        <div class="form-group">
          <button @click="search" class="btn btnSub site-bg-main-color">
            جستجو
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
