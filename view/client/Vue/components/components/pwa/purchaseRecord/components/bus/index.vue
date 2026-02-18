<template>
  <div class="list-boxes py-2">
    <div class="box-search w-100">
      <div class="row m-0 py-3 p-2 border-bottom align-items-center first-row">
        <span class="w-100 text-right mb-3">
          <i class="fa-solid fa-check icon-b"></i>

          شماره سفارش :
          <em class="">{{ item.passenger_factor_num }}</em></span
        >
        <span class="w-100 text-right">
          <i class="fa-solid fa-calendar-check icon-b"></i>
          تاریخ رزرو :
          <em>{{ item.creation_date_int }}</em>
        </span>
      </div>
      <div class="row m-0 py-3 p-2">
        <span class="pl-2"
          >{{ item.OriginCity }}-{{ item.DestinationCity }}</span
        >
        <span class="pl-2">{{ item.CompanyName }}</span>
        <span class="price mr-auto"> {{ item.price }} <em>تومان</em></span>
      </div>

      <div class="more-detail" :class="expand ? 'rotate' : ''">
        <div
          :class="expand ? 'h-270 transition-easy' : ''"
          class="list-more-detail">
          <div class="w-50">
            <span class="title">نام مسافر</span>
            <span>{{ item.passenger_name }} {{ item.passenger_family }}</span>
          </div>

          <div class="w-50">
            <span class="title">تاریخ رزرو</span>
            <span>{{ item.creation_date_int }}</span>
          </div>

          <div class="w-50">
            <span class="title">تاریخ حرکت</span>
            <span>{{ item.DateMove }} {{ item.TimeMove }}</span>
          </div>

          <div class="w-50">
            <span class="title">شماره صندلی</span>
            <span>{{ item.chairs }}</span>
          </div>

          <div class="w-50">
            <span class="title">نوع خودرو</span>
            <span>{{ item.CarType }} </span>
          </div>

          <div class="w-50">
            <span class="title">وضعیت رزرو</span>
            <span>{{ text_reservation_status }}</span>
          </div>

          <div v-if="item.status === 'book'" class="w-100 d-flex flex-wrap align-items-center">
            <a target="_blank" :href="`/gds/pdf&target=bookingBusShow&id=${item.passenger_factor_num}`" class="col-5 offset-2 btn btn-success w-100 text-center">دریافت بلیط</a>
            <button type='button' @click='openRefundData(item.passenger_factor_num,item.order_code,item.member_id)'
                     class="col-5 btn btn-primary w-100 text-center">استرداد</button>
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
  },
  methods: {
    async openRefundData(factor_number,request_number,member_id){
      await this.$store.commit('setPwaFooterSheetStatus',true)
      await this.$store.commit('setPwaFooterSheetLoading',true)
      let _this = this
      await axios
        .post(
          amadeusPath + "ajax",
          {
            className: "userBuy",
            method: "apiGetCancellationData",
            request_number: request_number,
            type: 'bus'
          },
          {
            "Content-Type": "application/json",
          }
        )
        .then(async function (response) {
          // Pushing the data to the result array.
          const result=[]
          response.data.data.data.forEach(function(item){
            result.push({
              passenger_name:item.passenger_name,
              passenger_family:item.passenger_family,
              passenger_birthday:item.passenger_birthday,
              passenger_age:'Adt',
              total_price:item.total_price,
              factor_number:item.passenger_factor_num,
              order_code:item.order_code,
              member_id:item.member_id,
              passenger_national_code:item.passenger_national_code,
              passenger_passport_number:item.passportNumber,
              Status:item.Status,
            })
          })


          // Setting the state of the store.
          await _this.$store.commit('setPwaFooterSheetData',result)
          await _this.$store.commit('setPwaFooterSheetRefundData',{
            factor_number:factor_number,
            request_number:request_number,
            member_id:member_id,
          })
          await _this.$store.commit('setPwaFooterSheetLoading',false)
        })
        .catch(function (error) {
          console.log(error)

        })
    }
  }
}
</script>
