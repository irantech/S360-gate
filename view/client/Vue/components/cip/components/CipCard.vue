<template>
   <div class="card-cip-search">
      <div class="card-cip-container">
         <div class="parent-img-cip">
            <img :src="cip.CipInfo.Image" @error="handleImageError" />
         </div>
         <div class="parent-body-cip">
            <h2>
               {{ lang === "fa" ? cip.CipInfo.Title.fa : cip.CipInfo.Title.en }}
            </h2>
            <div class="cip-info-class-trip-type">
               <span
                  ><i class="fa-solid fa-earth-americas mr-1"></i>
                  {{
                     cip.CipInfo.TripType === "international"
                        ? " پرواز بین المللی"
                        : " پرواز داخلی"
                  }}</span
               >
               <span
                  v-if="cip.CipInfo.FlightType === 'inbound'"
                  class="mr-0 mr-md-2"
                  ><i class="fa-solid fa-plane-arrival"></i>
                  <span>پرواز ورودی به فرودگاه</span>
               </span>
               <span v-else
                  >
                  <i class="fa-solid fa-plane-departure mr-1"></i
                  ><span> پرواز خروجی از فرودگاه</span></span
               >

            </div>

            <div class="mt-3">
            <span v-if="cip.isIranian == 1" class="is-iranian-cip">
                     فقط ملیت ایران
               </span>
            <span v-if="cip.isIranian == 0" class="is-not-iranian-cip">
                     همه ملیت‌ها بجز ایران
               </span>
            </div>
            <div class="my-3 cip-notes" v-if="cip.CipInfo.Notes.fa" >
               <span v-text=" cip.CipInfo.Notes.fa"></span>
            </div>
         </div>
         <div class="parent-price-cip">
            <div class="parent-nights-cip">
               <div class="parent-price-discount-cip">
                  <span>قیمت هر بزرگسال</span>
                  <div class="price-discount">
                     <div class="price-total">
                        <span>{{
                           formatPrice(cip.PassengerDatas[0].TotalPrice)
                        }}</span>
                        ریال
                     </div>
                  </div>
               </div>
               <a @click="checkLogin" style="cursor:pointer">
<!--               <a :href="`${baseUrl}${lang}/cip-detail/${cip.Code}/${cip.SourceId}`">-->
                  <span>رزرو</span>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                     <path
                        d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"></path>
                  </svg>
               </a>
            </div>
         </div>
      </div>
      <CipDetail :cip="{cip}" />
   </div>
</template>

<script>
import HotelDetailModal from "./HotelDetailModal.vue"
import CipDetail from "./CipDetail.vue"
import SeatClass from "../../global/filters/seatclass.vue"

export default {
   components: {SeatClass, HotelDetailModal, CipDetail},
   data() {
      return {
         showHotelModal: false,
      }
   },
   name: "CipCard",
   props: {
      cip: {
         type: Object,
         required: true,
      },
      baseUrl: {
         type: String,
         required: true,
      },
      lang: {
         type: String,
         required: true,
      },
   },
   methods: {
      formatPrice(price) {
         const num = Number(price)
         if (isNaN(num)) return "0"
         return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      },
      handleImageError(event) {
         event.target.src =
            amadeusPath + "view/client/assets/images/no-image.jpg"
      },
      openHotelModal() {
         this.showHotelModal = true
      },
      saveCipAndRedirect() {

         try {
            // ذخیره اطلاعات CIP در localStorage
            localStorage.setItem('selectedCip', JSON.stringify(this.cip));

            // ذخیره زمان انقضا (اختیاری - برای 1 ساعت)
            const expirationTime = new Date().getTime() + (60 * 60 * 1000);
            localStorage.setItem('cipExpiration', expirationTime.toString());

            // ریدایرکت به صفحه جزئیات
            window.location.href = `${this.baseUrl}${this.lang}/cip-detail/${this.cip.Code}/${this.cip.SourceId}`;
         } catch (error) {
            console.error('Error saving CIP to localStorage:', error);
            // در صورت خطا، به روش قبلی ریدایرکت شود
            window.location.href = `${this.baseUrl}${this.lang}/cip-detail/${this.cip.Code}/${this.cip.SourceId}`;
         }


      },
      checkLogin() {
         axios.post(
            amadeusPath + "ajax",
            {
               className: "cip",
               method: "checkLogin",
            },
            {
               headers: {
                  "Content-Type": "application/json",
               },
            }
         )
            .then((response) => {
               if (response.data.data.statusCode == 200) {

                     this.saveCipAndRedirect(); // حالا this درست کار می‌کنه

                  } else {
                  window.cipCode = this.cip.Code;
                  window.sourceId = this.cip.SourceId;
                  window.cipData = JSON.parse(JSON.stringify(this.cip));
                  setTimeout(function () {
                     const modal = document.getElementsByClassName("cd-user-modal")[0];
                     if (modal) {
                        modal.classList.add("is-visible");
                     }
                  }, 1000)
                  }

            })
            .catch((error) => {
               this.$swal({
                  icon: "error",
                  toast: true,
                  position: "bottom-end",
                  showConfirmButton: false,
                  timerProgressBar: true,
                  timer: 4000,
                  width: 600,
                  iconColor: "#FFFFFF",
                  background: "#2f2f2f",
                  title: "خطا در بررسی وضعیت لاگین",
               })
            })
      }



   }



}
</script>
