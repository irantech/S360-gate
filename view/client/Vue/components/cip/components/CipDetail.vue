<script>
export default {
   name: "CipDetail",
   props: ["cip"],
   data() {
      return {
         fee_cancel: "",
         data_rules: {},
         is_show_rules: false,
         is_show_loader: true,
      }
   },
   mounted() {
      console.log("cip list:", this.cip.cip)
   },
   methods: {
      formatPrice(price) {
         const num = Number(price)
         if (isNaN(num)) return "0"
         return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      }
   },

}
</script>

<template>
   <div class="international-available-details">
      <div class="international-available-panel-min">
         <ul class="tabs">
            <li
               data-tab="tab-1-0"
               class="tab-link current site-border-top-main-color">
               شرح خدمات
            </li>
            <li data-tab="tab-2-0" class="tab-link site-border-top-main-color">
               قوانین
            </li>
            <li data-tab="tab-3-0" class="tab-link site-border-top-main-color">
               سرویس های جانبی
            </li>
            <li data-tab="tab-4-0" class="tab-link site-border-top-main-color">
               جزئیات قیمت
            </li>
            <li data-tab="tab-5-0" class="tab-link site-border-top-main-color">
               نکات
            </li>
         </ul>
         <div id="tab-1-0" class="tab-content current">
            <span
               v-if="cip.cip.CipInfo.Desciption.fa"
               v-html="cip.cip.CipInfo.Desciption.fa"></span>
            <span v-else v-html="cip.cip.CipInfo.Desciption.en"></span>




         </div>
         <div id="tab-2-0" class="tab-content">
            <div
               class="price-Content cip-service site-border-main-color"
               style="position: relative; overflow: visible">
               <div class="tblprice">
                  <div class="parent-counter-ticket-details">
                     <table>
                        <thead>
                        <tr >
                           <th>رده سنی</th>
                           <th>شرح</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>

                           <td class="td-cip-rules-title" v-if="cip.cip.CipInfo.Rules.ADT[0]">
                              بزرگسال
                           </td>
                                <td class="td-cip-rules" v-if="cip.cip.CipInfo.Rules.ADT[0]" v-html="cip.cip.CipInfo.Rules.ADT[0]">

                           </td>


                        </tr>
                        <tr>

                           <td class="td-cip-rules-title" v-if="cip.cip.CipInfo.Rules.CHD[0]">
                              کودک
                           </td>
                           <td class="td-cip-rules" v-if="cip.cip.CipInfo.Rules.CHD[0]" v-html="cip.cip.CipInfo.Rules.CHD[0]">

                           </td>
                        </tr>
                        <tr>

                           <td class="td-cip-rules-title" v-if="cip.cip.CipInfo.Rules.INF[0]">
                              نوزاد
                           </td>
                           <td class="td-cip-rules" v-if="cip.cip.CipInfo.Rules.INF[0]" v-html="cip.cip.CipInfo.Rules.INF[0]">

                           </td>
                        </tr>
                        </tbody>
                     </table>
                  </div>
               </div>

            </div>





         </div>
         <div id="tab-3-0" class="tab-content">
            <div
               class="price-Content cip-service site-border-main-color"
               style="position: relative; overflow: visible">
               <div class="tblprice">
                  <div class="parent-counter-ticket-details">
                     <table>
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>عنوان</th>
                              <th>توضیحات</th>
                              <th>قیمت</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr
                              v-for="(item, index) in cip.cip.Services"
                              :key="index">
                              <td>{{ index + 1 }}</td>
                              <td v-if="item.CipInfo.Title.fa">
                                 {{ item.CipInfo.Title.fa }}
                              </td>
                              <td v-else>{{ item.CipInfo.Title.en }}</td>
                              <td v-if="item.CipInfo.Desciption.fa">
                                 {{ item.CipInfo.Desciption.fa }}
                              </td>
                              <td v-else>{{ item.CipInfo.Desciption.en }}</td>
                              <td>
                                 {{
                                    formatPrice(
                                       item.PassengerDatas[0].TotalPrice
                                    )
                                 }}
                                 ریال
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>

            </div>
         </div>
         <div id="tab-4-0" class="tab-content">
            <div
               class="price-Content site-border-main-color"
               style="position: relative; overflow: visible">
               <div class="tblprice">
                  <div class="parent-counter-ticket-details d-none d-md-block">
                     <table>
                        <thead>
                           <tr>
                              <th>رده سنی</th>
                              <th>قیمت پایه</th>
                              <th>مالیات</th>
                              <th>کمیسیون</th>
                              <th>قیمت نهایی (ریال)</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr
                              v-for="(item, index) in cip.cip.PassengerDatas"
                              :key="index">
                              <td v-if="item.PassengerType === 'ADT'">
                                 بزرگسال
                              </td>
                              <td v-else-if="item.PassengerType === 'CHD'">
                                 کودک
                              </td>
                              <td v-else-if="item.PassengerType === 'INF'">
                                 نوزاد
                              </td>
                              <td>{{ formatPrice(item.BasePrice) }}</td>
                              <td>{{ formatPrice(item.TaxPrice) }}</td>
                              <td>{{ formatPrice(item.CommisionPrice) }}</td>
                              <td v-if="item.TotalPrice !== 0">
                                 {{ formatPrice(item.TotalPrice) }}
                              </td>
                              <td v-else>0</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>

                  <div class="d-md-none tab-price-mobile-cip">
                  <ul class="tabs d-md-none tabs-mobile">
                     <li
                        data-tab="tab-4-1"
                        class="current tabs-li-mobile" style="line-height:30px !important;">
                        بزرگسال
                     </li> <li
                        data-tab="tab-4-2"
                        class=" tabs-li-mobile" style="line-height:30px !important;">
                     کودک
                     </li> <li
                        data-tab="tab-4-3"
                        class=" tabs-li-mobile" style="line-height:30px !important;">
                     نوزاد
                     </li>
                  </ul>
                  <div id="tab-4-1" class="tab-content current">
                     <div class="price-card-mobile">
                     <div class="price-row">
                        <span>قیمت پایه</span>
                        <strong>{{formatPrice(cip.cip.PassengerDatas[0].BasePrice)}}</strong>
                     </div>

                     <div class="price-row">
                        <span>مالیات</span>
                        <strong>{{formatPrice(cip.cip.PassengerDatas[0].TaxPrice)}}</strong>
                     </div>

                     <div
                        class="price-row"
                     >
                        <span>کمیسیون</span>
                        <strong>{{formatPrice(cip.cip.PassengerDatas[0].CommisionPrice)}}</strong>
                     </div>
                     <div class="price-row price-total">
                        <span>قیمت نهایی</span>
                        <strong> {{formatPrice(cip.cip.PassengerDatas[0].TotalPrice)}}  <span> ریال </span></strong>
                     </div>
                     </div>
                  </div>
                  <div id="tab-4-2" class="tab-content">
                     <div class="price-card-mobile">
                        <div class="price-row">
                           <span>قیمت پایه</span>
                           <strong>{{formatPrice(cip.cip.PassengerDatas[1].BasePrice)}}</strong>
                        </div>

                        <div class="price-row">
                           <span>مالیات</span>
                           <strong>{{formatPrice(cip.cip.PassengerDatas[1].TaxPrice)}}</strong>
                        </div>

                        <div
                           class="price-row"
                        >
                           <span>کمیسیون</span>
                           <strong>{{formatPrice(cip.cip.PassengerDatas[1].CommisionPrice)}}</strong>
                        </div>
                        <div class="price-row price-total">
                           <span>قیمت نهایی</span>
                           <strong>{{formatPrice(cip.cip.PassengerDatas[1].TotalPrice)}}  <span> ریال </span></strong>
                        </div>
                     </div>
                  </div>
                  <div id="tab-4-3" class="tab-content">
                     <div class="price-card-mobile">
                        <div class="price-row">
                           <span>قیمت پایه</span>
                           <strong>{{formatPrice(cip.cip.PassengerDatas[2].BasePrice)}}</strong>
                        </div>

                        <div class="price-row">
                           <span>مالیات</span>
                           <strong>{{formatPrice(cip.cip.PassengerDatas[2].TaxPrice)}}</strong>
                        </div>

                        <div
                           class="price-row"
                        >
                           <span>کمیسیون</span>
                           <strong>{{formatPrice(cip.cip.PassengerDatas[2].CommisionPrice)}}</strong>
                        </div>
                        <div class="price-row price-total">
                           <span>قیمت نهایی</span>
                           <strong>{{formatPrice(cip.cip.PassengerDatas[2].TotalPrice)}} <span> ریال </span></strong>
                        </div>
                     </div>
                  </div>
                  </div>

                  </div>

            </div>

         </div>
         <div id="tab-5-0" class="tab-content">

            <p v-for="(item, index) in cip.cip.CipInfo.Notes" :key="index">
               {{ item }}
            </p>

         </div>
      </div>

      <span class="international-available-detail-btn more_1">
         <div class="my-more-info slideDownAirDescription">
            {{ useXmltag("MoreDetails") }}
            <i class="fa fa-angle-down"></i>
         </div>
      </span>
      <span
         class="international-available-detail-btn slideUpAirDescription displayiN">
         <i class="fa fa-angle-up site-main-text-color"></i>
      </span>
   </div>
</template>

<style scoped></style>