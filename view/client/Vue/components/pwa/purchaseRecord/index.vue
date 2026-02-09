<template>
   <div v-if="purchase_data.data !== false" class="container">
      <purchase-tabs
         @searchTab="searchTab"
         :purchase_data="purchase_data"
         :form="form"
         :services="client_data.client_services"></purchase-tabs>
      <date-filter @searchTab="searchTab" :form="form"></date-filter>

      <component
         :is="purchase_data.index + '-purchase-item'"
         v-if="purchase_data.data"
         :key="item.request_number"
         v-for="item in purchase_data.data"
         :item="item"></component>

      <swipe-modal
         v-model="footer_sheet.status"
         @close="onCloseFooterSheet"
         contents-height="50vh"
         border-top-radius="16px">
         <div class="container my-2 w-100">
            <template v-if="footer_sheet.loading">
               <app-loading-spinner
                  class="mx-auto"
                  :loading="true"></app-loading-spinner>
            </template>
            <div v-else>
               <div
                  class="d-flex border-bottom mt-2 w-100 justify-content-center">
                  <span class="font-weight-bold h6">
                     {{ useXmltag('Pleaseselectthedesiredpassenger')}}
                  </span>
               </div>

               <div
                  class="align-items-center bg-light d-flex flex-wrap gap-3 justify-content-around mt-2 p-2 rounded w-100"
                  v-for="(item, index) in footer_sheet.data"
                  :key="item">
                  <input
                     class="SelectUser"
                     :disabled="
                        item.Status &&
                        item.passenger_national_code &&
                        item.Status != 'Nothing'
                     "
                     :value="
                        item.passenger_national_code != '0000000000' && item.passenger_national_code
                           ? item.passenger_national_code +
                             '-' +
                             item.passenger_age
                           : item.passenger_passport_number + '-' + item.passenger_age
                     "
                     type="checkbox"
                     name="SelectUser[]" />
                  <div class="d-flex gap-2 flex-wrap">
                     <span class="d-flex font-11 text-muted w-100">
                         {{ useXmltag('Namefamily')}}
                     </span>
                     <span class="d-flex font-14">
                        {{ item.passenger_name }}
                     </span>
                     <span class="d-flex font-14">
                        {{ item.passenger_family }}
                     </span>
                  </div>

                  <div class="d-flex gap-2 flex-wrap">
                     <span class="d-flex font-11 text-muted w-100">
                       {{ useXmltag('DateOfBirth')}}

                     </span>
                     <span class="d-flex font-14">
                        {{ item.passenger_birthday }}
                     </span>
                  </div>

                  <div class="d-flex gap-2 flex-wrap">
                     <span class="d-flex font-11 text-muted w-100">
                       {{ useXmltag('nationalCodeOrPassPort')}}
                     </span>
                     <span class="d-flex font-14">
                        {{ item.passenger_national_code }} /
                        {{ item.passenger_passport_number }}
                     </span>
                  </div>

                  <div
                     v-if="
                        item.Status &&
                        item.passenger_national_code &&
                        item.Status != 'Nothing'
                     "
                     class="d-flex gap-2 flex-wrap">
                     <button
                        v-if="item.Status == 'SetCancelClient'"
                        class="btn btn-danger font-11 btn-sm small"
                        disabled>
                       {{ useXmltag('RequestRejected')}}

                     </button>
                     <button
                        v-else
                        class="btn btn-warning font-11 btn-sm small"
                        disabled>
                       {{ useXmltag('Actionhasalreadybeentaken')}}
                     </button>
                  </div>
               </div>

               <div
                  class="d-flex mt-4 border-bottom w-100 justify-content-center">
                  <span class="font-weight-bold h6">
                    {{ useXmltag('Pleaseselectyourdesiredoptions')}}

                  </span>
               </div>

               <div
                  v-if="is_counter"
                  class="align-items-center bg-light d-flex flex-wrap gap-3 mt-2 p-2 rounded w-100">
                  <div class="row">
                     <div
                        class="col-md-12 d-flex font-weight-bold justify-content-center modal-h modal-text-center">
                        <label for="ReasonUser">
                          {{ useXmltag('Pleaseenteryourinformationreturningmoneyyouraccount')}}
                        </label>
                     </div>
                     <div
                        class="col-md-4 col-lg-4 col-sm-12 col-xs-12 nopad"
                        style="direction: rtl; margin: 10px">
                        <label style="float: right"> {{ useXmltag('Cardnumber')}}  </label>

                        <input
                           class="form-control"
                           type="text"
                           v-model="refund.form.CardNumber"
                           style="float: right; margin-right: 10px" />
                     </div>
                     <div
                        class="col-md-4 col-lg-4 col-sm-12 col-xs-12 nopad"
                        style="direction: rtl; margin: 10px">
                        <label style="float: right"> {{ useXmltag('Namebankowner')}}  </label>
                        <input
                           class="form-control"
                           type="text"
                           v-model="refund.form.AccountOwner"
                           style="float: right; margin-right: 10px" />
                     </div>

                     <div
                        class="col-md-3 col-lg-3 col-sm-12 col-xs-12 nopad"
                        style="direction: rtl; margin: 10px">
                        <label style="float: right">{{ useXmltag('Cardname')}} </label>
                        <input
                           class="form-control"
                           type="text"
                           v-model="refund.form.NameBank"
                           style="float: right; margin-right: 10px" />
                     </div>
                  </div>
               </div>

               <div
                  v-if="purchase_data.index == 'flight'"
                  class="align-items-center bg-light d-flex flex-wrap gap-3 mt-2 p-2 rounded w-100">
                  <div
                     v-if="
                        footer_sheet.refund.data &&
                        footer_sheet.refund.data.flight_type == 'system' &&
                        footer_sheet.refund.data.fee
                     "
                     class="align-items-center bg-light d-flex flex-wrap gap-3 p-2 rounded w-100">
                     <div class="justify-content-center d-flex flex-wrap w-100">
                        <div
                           class="justify-content-center d-flex flex-wrap w-100">
                           <div
                              class="col-md-12 d-flex font-weight-bold justify-content-center modal-h modal-text-center">
                             {{ useXmltag('DetailMoneyCancel')}}
                           </div>
                           <div class="cancel-policy-class">
                              <span>{{ useXmltag('Classflight')}} :</span><span>{{
                                 footer_sheet.refund.data.fee.TypeClass
                              }}</span>
                           </div>
                        </div>
                        <div
                           class="cancel-policy-inner d-flex flex-wrap overflow-auto w-100">
                           <div class="d-flex flex-wrap col-6">
                              <div
                                 class="align-items-center bg-white cancel-policy-item cancel_modal mb-3 w-100 d-flex flex-wrap font-weight-bold gap-4 justify-content-center p-3 rounded shadow-sm text-center">
                                 <span class="cancel-policy-item-text">
                                   {{ useXmltag('Fromthetimeticketissueuntilnoondaysbeforeflight')}}
                                 </span>
                                 <span
                                    class="cancel-policy-item-pnalty p-1 rounded shadow site-bg-main-color w-100">
                                    <span>
                                       {{
                                          footer_sheet.refund.data.fee
                                             .ThreeDaysBefore
                                       }}</span
                                    >
                                    % جریمه
                                 </span>
                              </div>
                           </div>

                           <div class="d-flex flex-wrap col-6">
                              <div
                                 class="align-items-center bg-white cancel-policy-item cancel_modal mb-3 w-100 d-flex flex-wrap font-weight-bold gap-4 justify-content-center p-3 rounded shadow-sm text-center">
                                 <span class="cancel-policy-item-text">
                                   {{ useXmltag('Fromnoondaysbeforeflightnoondaybeforeflight')}}
                                 </span>
                                 <span
                                    class="cancel-policy-item-pnalty p-1 rounded shadow site-bg-main-color w-100">
                                    <span>
                                       {{
                                          footer_sheet.refund.data.fee
                                             .OneDaysBefore
                                       }}</span
                                    >
                                   {{ useXmltag('PenaltyPercent')}}
                                 </span>
                              </div>
                           </div>
                           <div class="d-flex flex-wrap col-6">
                              <div
                                 class="align-items-center bg-white cancel-policy-item cancel_modal mb-3 w-100 d-flex flex-wrap font-weight-bold gap-4 justify-content-center p-3 rounded shadow-sm text-center">
                                 <span class="cancel-policy-item-text">
                                   {{ useXmltag('Fromnoondaybeforeflighthoursbeforeflight')}}
                                 </span>
                                 <span
                                    class="cancel-policy-item-pnalty p-1 rounded shadow site-bg-main-color w-100">
                                    <span>
                                       {{
                                          footer_sheet.refund.data.fee
                                             .ThreeHoursBefore
                                       }}</span
                                    >
                                    {{ useXmltag('PenaltyPercent')}}

                                 </span>
                              </div>
                           </div>
                           <div class="d-flex flex-wrap col-6">
                              <div
                                 class="align-items-center bg-white cancel-policy-item cancel_modal mb-3 w-100 d-flex flex-wrap font-weight-bold gap-4 justify-content-center p-3 rounded shadow-sm text-center">
                                 <span class="cancel-policy-item-text">
                                   {{ useXmltag('Fromnoondaybeforeflighthoursbeforeflight')}}
                                 </span>
                                 <span
                                    class="cancel-policy-item-pnalty p-1 rounded shadow site-bg-main-color w-100">
                                    <span>
                                       {{
                                          footer_sheet.refund.data.fee
                                             .ThirtyMinutesAgo
                                       }}</span
                                    >
                                   {{ useXmltag('Namefamily')}}
                                  {{ useXmltag('PenaltyPercent')}}
                                 </span>
                              </div>
                           </div>

                           <div class="d-flex flex-wrap col-6">
                              <div
                                 class="align-items-center bg-white cancel-policy-item cancel_modal mb-3 w-100 d-flex flex-wrap font-weight-bold gap-4 justify-content-center p-3 rounded shadow-sm text-center">
                                 <span class="cancel-policy-item-text">
                                   {{ useXmltag('Minutesbeforetheflight')}}
                                 </span>
                                 <span
                                    class="cancel-policy-item-pnalty p-1 rounded shadow site-bg-main-color w-100">
                                    <span>
                                       {{
                                          footer_sheet.refund.data.fee
                                             .OfThirtyMinutesAgoToNext
                                       }}</span
                                    >
                                   {{ useXmltag('Namefamily')}}
                                    {{ useXmltag('PenaltyPercent')}}
                                 </span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div
                     v-else-if="
                        footer_sheet.refund.data &&
                        footer_sheet.refund.data.flight_type == 'system' &&
                        !footer_sheet.refund.data.fee
                     "
                     class="d-flex flex-wrap justify-content-center row w-100">
                     <div
                        class="cancel-policy cancel_modal cancel-policy-charter1">
                        <div
                           class="justify-content-center d-flex flex-wrap w-100">
                           <div
                              class="col-md-12 d-flex font-weight-bold justify-content-center modal-h modal-text-center">
                             {{ useXmltag('DetailMoneyCancel')}}
                           </div>
                        </div>
                        <span class="site-bg-main-color">
                          {{ useXmltag('Contactbackupunitinformationaboutamountconsignmentfines')}}
                        </span>
                     </div>
                  </div>

                  <div
                     v-else
                     class="d-flex flex-wrap justify-content-center row w-100">
                     <div
                        class="cancel-policy cancel_modal cancel-policy-charter1">
                        <div
                           class="justify-content-center d-flex flex-wrap w-100">
                           <div
                              class="col-md-12 d-flex font-weight-bold justify-content-center modal-h modal-text-center">
                             {{ useXmltag('DetailMoneyCancel')}}
                           </div>
                        </div>
                        <span class="site-bg-main-color">
                          {{ useXmltag('ThecharterflightscharterunderstandingCivilAviationOrganization')}}

                        </span>
                     </div>
                  </div>
               </div>

               <div
                  class="align-items-center bg-light d-flex flex-wrap gap-3 mt-2 p-2 rounded w-100">
                  <select
                     class="form-control mart5"
                     v-model="refund.form.cancel_reason">
                     <option disabled selected value="">
                       {{ useXmltag('Choosereasonfortheconsole')}}
                     </option>
                     <option value="PersonalReason"> {{ useXmltag('Canselforpersonalreasons')}}</option>
                     <option
                        v-if="purchase_data.index == 'flight'"
                        value="DelayTwoHours">
                       {{ useXmltag('Delaymorethantwohours')}}
                     </option>
                     <option
                        v-if="purchase_data.index == 'flight'"
                        value="CancelByAirline">
                       {{ useXmltag('AbandonedbyAirline')}}
                     </option>
                  </select>

                  <div
                     class="align-items-center bg-light d-flex flex-wrap gap-3 mt-2 p-2 rounded w-100">
                     <input type="checkbox" v-model="refund.form.rules" />
                     <div class="d-flex gap-2 flex-wrap">
                        <span class="align-items-center d-flex font-14 gap-2">
                          {{ useXmltag('Iam')}}
                           <a href="/rules">{{ useXmltag('S360Rules')}}</a>
                          {{ useXmltag('CovidTerms')}}
                        </span>
                     </div>
                  </div>

                  <div
                     v-if="
                        purchase_data.index == 'flight' &&
                        footer_sheet.refund.data &&
                        !footer_sheet.refund.data.fee &&
                        footer_sheet.refund.data.flight_type != 'system'
                     "
                     class="align-items-center bg-light d-flex flex-wrap gap-3 mt-2 p-2 rounded w-100">
                     <input
                        type="checkbox"
                        v-model="refund.form.percent_no_matter" />
                     <div class="d-flex gap-2 flex-wrap">
                        <span class="align-items-center d-flex font-14 gap-2">
                          {{ useXmltag('Idonotcareaboutthepercentagepenaltypleasebesurecancel')}}
                        </span>
                     </div>
                  </div>

                  <button
                     @click="submitRefund"
                     :disabled="refund.loading"
                     class="btn btn-block btn-outline-danger d-flex gap-3 justify-content-center transition-easy">

                    {{ useXmltag('Register')}}
                     <app-loading-spinner
                        v-if="refund.loading"
                        class=""
                        :loading="true"></app-loading-spinner>
                  </button>
               </div>
            </div>
         </div>
      </swipe-modal>
   </div>
   <div v-else>
      <app-loading-spinner
         class="w-100-vh mx-auto"
         :loading="true"></app-loading-spinner>
   </div>
</template>

<script>
import footerSection from "./../components/footer"
import dateFilter from "./components/dateFilter"
import purchaseTabs from "./components/purchaseTabs"
import flightPurchaseItem from "./components/flight/index"
import hotelPurchaseItem from "./components/hotel/index"
import insurancePurchaseItem from "./components/insurance/index"
import tourPurchaseItem from "./components/tour/index"
import busPurchaseItem from "./components/bus/index"
import trainPurchaseItem from "./components/train/index"
import swipeModal from "@takuma-ru/vue-swipe-modal"


export default {
   name: "pwaUserProfile",
   props: ["pwa_page_data"],
   components: {
      "purchase-tabs": purchaseTabs,
      "date-filter": dateFilter,
      "footer-section": footerSection,

      "flight-purchase-item": flightPurchaseItem,
      "hotel-purchase-item": hotelPurchaseItem,
      "insurance-purchase-item": insurancePurchaseItem,
      "tour-purchase-item": tourPurchaseItem,
      "bus-purchase-item": busPurchaseItem,
      "train-purchase-item": trainPurchaseItem,
      "swipe-modal": swipeModal,
   },
   data() {
      return {
         isModal: false,
         refund_loading: false,
         refund: {
            loading: false,
            form: {
               cancel_reason: "",
               rules: false,
               percent_no_matter: false,
               AccountOwner: null,
               CardNumber: null,
               NameBank: null,
            },
         },
         form: {
            loading: false,
            date_range: {
               start: '',
               end: '',
            },
            reserve_status: null,
            factor_number: null,
         },
      }
   },
   mounted() {
      this.getDates() ;
      this.searchTab(this.purchase_data.index)
      this.$store.dispatch("pwaGetClientData", this.api_gds_client_data())
   },
   computed: {
      is_counter() {
         if (this.footer_sheet.refund.data) {
            return this.footer_sheet.refund.data.is_counter
         } else {
            return false
         }
      },
      purchase_data() {
         return this.$store.state.purchase_record
      },
      client_data() {
         return this.$store.state.pwa_page
      },
      footer_sheet() {
         let footer_sheet = this.client_data.footer_sheet
         let pwa_footer = document.getElementById("pwa-footer")
         if (footer_sheet.status) {
            pwa_footer.classList.add("d-none")
         } else {
            if (pwa_footer.classList.contains("d-none")) {
               pwa_footer.classList.remove("d-none")
            }
         }
         return footer_sheet
      },
   },
   methods: {
      getDates() {
        if(this.getLang() == 'fa') {
          this.form.date_range.start = new Date()
            .toLocaleDateString("fa-IR-u-nu-latn")
            .replace(/[/]/g, "-")
          let math_current_date = new Date()
          this.form.date_range.end = new Date(
            math_current_date.getTime() + 7 * 24 * 60 * 60 * 1000
          )
            .toLocaleDateString("fa-IR-u-nu-latn")

        }else{
          const now = new Date();
          let year = now.getFullYear();
          let month = String(now.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
          let day = String(now.getDate()).padStart(2, '0');
          this.form.date_range.start = year + '-' + month + '-' + day;


          const currentDate = new Date();
          currentDate.setDate(currentDate.getDate() + 10);
          let nextYear = currentDate.getFullYear();
          let nextMonth = String(currentDate.getMonth() + 1).padStart(2, '0');
          let nextDay = String(currentDate.getDate()).padStart(2, '0');
          this.form.date_range.end = nextYear + '-' + nextMonth + '-' + nextDay;

        }

      },
      async submitRefund() {
         this.refund.loading = true
         let _this = this
         let national = []
         national = $(".SelectUser:checked").map(function () {
            return $(this).val()
         })

         const NationalCodes = national.get()

         if (!NationalCodes.length) {
            _this.$swal({
               icon: "error",
               toast: true,
               position: "bottom",
               showConfirmButton: false,
               timerProgressBar: true,
               timer: 2500,
               title: useXmltag('PleasePersonOrCancellationReason'),
            })
            _this.refund.loading = false
            return false
         }
         if (!_this.refund.form.cancel_reason) {
            _this.$swal({
               icon: "error",
               toast: true,
               position: "bottom",
               showConfirmButton: false,
               timerProgressBar: true,
               timer: 2500,
               title: useXmltag('PleasePersonOrCancellationReason'),
            })
            _this.refund.loading = false
            return false
         }
         if (!_this.refund.form.rules) {
            _this.$swal({
               icon: "error",
               toast: true,
               position: "bottom",
               showConfirmButton: false,
               timerProgressBar: true,
               timer: 2500,
               title:useXmltag('ReadRulesSelectRules'),
            })
            _this.refund.loading = false
            return false
         }
         let percent_no_matter = "No"
         if (_this.refund.form.percent_no_matter) {
            percent_no_matter = "Yes"
         }

         await axios
            .post(
               amadeusPath + "ajax",
               {
                  className: "listCancel",
                  method: "GoToSetRequestCancelUser",
                  NationalCodes: NationalCodes,
                  Reasons: _this.refund.form.cancel_reason,
                  FactorNumber: _this.footer_sheet.refund.data.factor_number,
                  RequestNumber: _this.footer_sheet.refund.data.request_number,
                  MemberId: _this.footer_sheet.refund.data.member_id,
                  AccountOwner: _this.refund.form.AccountOwner,
                  CardNumber: _this.refund.form.CardNumber,
                  NameBank: _this.refund.form.NameBank,
                  PercentNoMatter: percent_no_matter,
                  typeService: _this.purchase_data.index,
               },
               {
                  "Content-Type": "application/json",
               }
            )
            .then(async function (response) {
               _this.refund.loading = false
               let result = response.data.split(":")

               _this.$swal({
                  icon: result[0].replace(" ", ""),
                  toast: false,
                  position: "bottom",
                  showConfirmButton: false,
                  timerProgressBar: false,
                  title: result[1],
               })
               _this.form.loading = false
               _this.onCloseFooterSheet()
            })
            .catch(function (error) {
               console.log(error)
               _this.refund.loading = false
            })
      },
      async onCloseFooterSheet() {
         await this.$store.commit("setPwaFooterSheetStatus", false)
      },
      async updateForm() {
         this.form.loading = true
         let _this = this
         await axios
            .post(
               amadeusPath + "ajax",
               {
                  className: "user",
                  method: "apiUpdateUser",
                  form: _this.form,
               },
               {
                  "Content-Type": "application/json",
               }
            )
            .then(async function (response) {
               _this.$swal({
                  icon: "success",
                  toast: true,
                  position: "bottom",
                  showConfirmButton: false,
                  timerProgressBar: true,
                  timer: 4000,
                  title: "ویرایش شد",
               })
               _this.form.loading = false
            })
            .catch(function (error) {
               console.log(error)
               _this.form.loading = false
            })
      },
      async searchTab(index = this.purchase_data.index) {
         this.form.loading = true
         await this.$store.dispatch("pwaChangePurchaseTab", {
            tab_index: index,
            form: this.form,
         })
         this.form.loading = false
      },
   },
}
</script>
