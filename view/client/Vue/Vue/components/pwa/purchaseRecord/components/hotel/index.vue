<template>
  <div class="list-boxes pb-4">
    <div class="box-search w-100">
      <div class="row m-0 py-3 p-2 border-bottom align-items-center first-row">
        <span class="w-100 text-right mb-3">
          <i class="fa-solid fa-check icon-b"></i>

          {{ useXmltag("OrderNumber") }}  :
          <em class="">{{ item.factor_number }}</em></span
        >
        <span class="w-100 text-right">
          <i class="fa-solid fa-calendar-check icon-b"></i>
         :{{ useXmltag("Date") }}
          <em>{{ item.creation_date_int }}</em>
        </span>
      </div>
      <div class="row m-0 py-3 p-2">
        <span class="pl-2">{{ item.hotel_name }}</span>
        <span class="pl-2">{{ item.city_name }}</span>
        <span class="price" :class="`${getLang() == 'fa' ? 'mr-auto' : 'ml-auto'}`"> {{ item.price }} <em>تومان</em></span>
      </div>

      <div class="more-detail" :class="expand ? 'rotate' : ''">
        <div
          :class="expand ? 'h-270 transition-easy' : ''"
          class="list-more-detail">
          <div class="w-50">
            <span class="title">{{ useXmltag("Buydate") }}</span>
            <span>{{ item.creation_date_int }}</span>
          </div>

          <div class="w-50">
            <span class="title">{{ useXmltag("Namepassenger") }}</span>
            <span>{{ item.passenger_leader_room_fullName }}</span>
          </div>

          <div class="w-50">
            <span class="title">{{ useXmltag("Countnight") }}</span>
            <span>{{ item.number_night }}</span>
          </div>

          <div class="w-50">
            <span class="title">{{ useXmltag("Enterdate") }}</span>

            <span>{{ item.start_date }}</span>
          </div>
          <div class="w-50">
            <span class="title">{{ useXmltag("Exitdate") }}</span>
            <span>{{ item.end_date }}</span>
          </div>

          <div class="w-50">
            <span class="title">{{ useXmltag("Statusreservation") }}و</span>
            <span>{{ text_reservation_status }}</span>
          </div>

          <div v-if="item.status === 'BookedSuccessfully'" class="w-100 d-flex flex-wrap align-items-center">
            <a
              target="_blank"
              :href="`/gds/${getLang()}/pdf&target=bookhotelshow&id=${item.factor_number}`"
              class="col-5 offset-2 btn btn-success w-100 text-center"
              >{{ useXmltag("GetTicket") }} }}</a
            >
            <a :href="`/gds/${getLang()}/UserTracking&type=hotel`" class="col-5 btn btn-primary w-100 text-center">  {{ useXmltag("OsafarRefund") }}</a>
          </div>
        </div>

        <div @click="expand = !expand" class="more-click">
          <span class="d-flex align-items-center"
            >{{ useXmltag("MoreInformation") }}ر<i class="fa-regular fa-chevron-down mr-1"></i
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
