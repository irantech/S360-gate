<template>
  <div class="list-boxes py-2">
    <div class="box-search w-100">
      <div class="row m-0 py-3 p-2 border-bottom align-items-center first-row">
        <span class="w-100 text-right mb-3">
          <i class="fa-solid fa-check icon-b"></i>

          شماره سفارش :
          <em class="">{{ item.factor_number }}</em></span
        >
        <span class="w-100 text-right">
          <i class="fa-solid fa-calendar-check icon-b"></i>
          تاریخ سفارش :
          <em>{{ item.creation_date_int }}</em>
        </span>
      </div>
      <div class="row m-0 py-3 p-2">
        <span class="pl-2"
          >{{ item.source_name_fa }} / {{ item.destination }}</span
        >
        <span class="pl-2" v-if="item.caption">{{ item.caption }}</span>
        <span class="price mr-auto"> {{ item.price }} <em>تومان</em></span>
      </div>

      <div class="more-detail" :class="expand ? 'rotate' : ''">
        <div
          :class="expand ? 'h-270 transition-easy' : ''"
          class="list-more-detail">
          <div class="w-50">
            <span class="title">زمان خرید</span>
            <span>{{ item.creation_date_int }}</span>
          </div>

          <div class="w-50">
            <span class="title">نام مسافر</span>
            <span>{{ item.passenger_name }} {{ item.passenger_family }}</span>
          </div>

          <div class="w-50">
            <span class="title">مدت</span>
            <span>{{ item.duration }}</span>
          </div>

          <div class="w-50">
            <span class="title">وضعیت رزرو</span>
            <span>{{ text_reservation_status }}</span>
          </div>

          <div class="w-100 d-flex flex-wrap align-items-center">
            <a
              target="_blank"
              :href="`/gds/pdf&target=samanInsurance&id=${item.factor_number}`"
              class="col-5 offset-2 btn btn-success w-100 text-center">دریافت بلیط</a>
            <a href="/gds/fa/UserTracking&type=insurance" class="col-5 btn btn-primary w-100 text-center">استرداد</a>
          </div>
        </div>

        <div @click="expand = !expand" class="more-click">
          <span class="d-flex align-items-center"
            >اطلاعات بیشتر<i class="fa-regular fa-chevron-down mr-1"></i
          ></span>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped></style>
<script>
export default {
  name: "purchase-item",
  props: ["item"],
  data() {
    return {
      expand: false,
    }
  },
  computed: {
    text_reservation_status(){
      return this.reservation_status(this.item.status)
    },
  }
}
</script>
