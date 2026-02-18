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
      },
      getServiceIcon(item) {
         let title = ((item.CipInfo.Title.en || '') + ' ' + (item.CipInfo.Title.fa || '')).toLowerCase();
         const iconMap = [
            { keys: ['pet', 'حیوان', 'حیوانات'], icon: 'fa fa-paw' },
            { keys: ['lounge', 'لانج', 'سالن'], icon: 'fa fa-couch' },
            { keys: ['fast track', 'فست ترک', 'مسیر سریع'], icon: 'fa fa-bolt' },
            { keys: ['porter', 'باربر', 'چمدان', 'baggage', 'luggage'], icon: 'fa fa-suitcase-rolling' },
            { keys: ['vip', 'ویژه', 'ویآیپی'], icon: 'fa fa-crown' },
            { keys: ['meet', 'greet', 'استقبال', 'پذیرایی'], icon: 'fa fa-handshake' },
            { keys: ['massage', 'ماساژ', 'spa', 'اسپا'], icon: 'fa fa-spa' },
            { keys: ['transfer', 'ترانسفر', 'انتقال', 'shuttle'], icon: 'fa fa-shuttle-van' },
            { keys: ['parking', 'پارکینگ', 'پارک'], icon: 'fa fa-parking' },
            { keys: ['wifi', 'اینترنت', 'internet'], icon: 'fa fa-wifi' },
            { keys: ['food', 'غذا', 'رستوران', 'restaurant', 'meal', 'وعده'], icon: 'fa fa-utensils' },
            { keys: ['drink', 'نوشیدنی', 'beverage', 'coffee', 'قهوه', 'چای', 'tea'], icon: 'fa fa-coffee' },
            { keys: ['wheelchair', 'ویلچر', 'معلول'], icon: 'fa fa-wheelchair' },
            { keys: ['buggy', 'باگی', 'cart'], icon: 'fa fa-car-side' },
            { keys: ['smoke', 'سیگار', 'دخانیات'], icon: 'fa fa-smoking' },
            { keys: ['pray', 'نماز', 'نمازخانه'], icon: 'fa fa-pray' },
            { keys: ['child', 'کودک', 'بچه', 'kids'], icon: 'fa fa-child' },
            { keys: ['bed', 'اتاق', 'استراحت', 'room', 'rest'], icon: 'fa fa-bed' },
            { keys: ['phone', 'تلفن', 'تماس'], icon: 'fa fa-phone' },
            { keys: ['guide', 'راهنما', 'escort', 'همراه'], icon: 'fa fa-user-tie' },
            { keys: ['insurance', 'بیمه'], icon: 'fa fa-shield-alt' },
            { keys: ['ticket', 'بلیط', 'بلیت'], icon: 'fa fa-ticket-alt' },
            { keys: ['photo', 'عکس', 'تصویر'], icon: 'fa fa-camera' },
            { keys: ['shop', 'فروشگاه', 'خرید', 'shopping'], icon: 'fa fa-shopping-bag' },
            { keys: ['security', 'امنیت', 'حفاظت'], icon: 'fa fa-lock' },
            { keys: ['flight', 'پرواز'], icon: 'fa fa-plane' },
         ];
         for (let entry of iconMap) {
            for (let key of entry.keys) {
               if (title.includes(key)) return entry.icon;
            }
         }
         return 'fa fa-concierge-bell';
      },
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
                           <tr>
                              <th>رده سنی</th>
                              <th>شرح</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td
                                 class="td-cip-rules-title"
                                 v-if="cip.cip.CipInfo.Rules.ADT[0]">
                                 بزرگسال
                              </td>
                              <td
                                 class="td-cip-rules"
                                 v-if="cip.cip.CipInfo.Rules.ADT[0]"
                                 v-html="cip.cip.CipInfo.Rules.ADT[0]"></td>
                           </tr>
                           <tr>
                              <td
                                 class="td-cip-rules-title"
                                 v-if="cip.cip.CipInfo.Rules.CHD[0]">
                                 کودک
                              </td>
                              <td
                                 class="td-cip-rules"
                                 v-if="cip.cip.CipInfo.Rules.CHD[0]"
                                 v-html="cip.cip.CipInfo.Rules.CHD[0]"></td>
                           </tr>
                           <tr>
                              <td
                                 class="td-cip-rules-title"
                                 v-if="cip.cip.CipInfo.Rules.INF[0]">
                                 نوزاد
                              </td>
                              <td
                                 class="td-cip-rules"
                                 v-if="cip.cip.CipInfo.Rules.INF[0]"
                                 v-html="cip.cip.CipInfo.Rules.INF[0]"></td>
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
                  <div class="parent-counter-ticket-details border-0 p-3">
                     <!--                     <table>-->
                     <!--                        <thead>-->
                     <!--                           <tr>-->
                     <!--                              <th>#</th>-->
                     <!--                              <th>عنوان</th>-->
                     <!--                              <th>توضیحات</th>-->
                     <!--                              <th>قیمت</th>-->
                     <!--                           </tr>-->
                     <!--                        </thead>-->
                     <!--                        <tbody>-->
                     <!--                           <tr-->
                     <!--                              v-for="(item, index) in cip.cip.Services"-->
                     <!--                              :key="index">-->
                     <!--                              <td>{{ index + 1 }}</td>-->
                     <!--                              <td v-if="item.CipInfo.Title.fa">-->
                     <!--                                 {{ item.CipInfo.Title.fa }}-->
                     <!--                              </td>-->
                     <!--                              <td v-else>{{ item.CipInfo.Title.en }}</td>-->
                     <!--                              <td v-if="item.CipInfo.Desciption.fa">-->
                     <!--                                 {{ item.CipInfo.Desciption.fa }}-->
                     <!--                              </td>-->
                     <!--                              <td v-else>{{ item.CipInfo.Desciption.en }}</td>-->
                     <!--                              <td>-->
                     <!--                                 {{-->
                     <!--                                    formatPrice(-->
                     <!--                                       item.PassengerDatas[0].TotalPrice-->
                     <!--                                    )-->
                     <!--                                 }}-->
                     <!--                                 ریال-->
                     <!--                              </td>-->
                     <!--                           </tr>-->
                     <!--                        </tbody>-->
                     <!--                     </table>-->

                     <div class="row cip-services-grid">
                        <div
                           class="col-lg-6 col-md-6 col-12 mb-2"
                           v-for="(item, index) in cip.cip.Services"
                           :key="index">
                           <div class="cip-service-card">
                              <div class="cip-service-card-header">
                                 <div class="cip-service-card-icon">
                                    <i :class="getServiceIcon(item)"></i>
                                 </div>
                                 <h4 class="cip-service-card-title" v-if="item.CipInfo.Title.fa">
                                    {{ item.CipInfo.Title.fa }}
                                 </h4>
                                 <h4 class="cip-service-card-title" v-else>
                                    {{ item.CipInfo.Title.en }}
                                 </h4>
                              </div>
                              <p class="cip-service-card-desc" v-if="item.CipInfo.Desciption.fa">
                                 {{ item.CipInfo.Desciption.fa }}
                              </p>
                              <p class="cip-service-card-desc" v-else>
                                 {{ item.CipInfo.Desciption.en }}
                              </p>
                              <div class="cip-service-card-footer">
                                 <span class="cip-service-card-price d-flex">
                                    <small>ریال</small>

                                    {{ formatPrice(item.PassengerDatas[0].TotalPrice) }}

                                 </span>
                              </div>
                           </div>
                        </div>
                     </div>
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
                           class="current tabs-li-mobile"
                           style="line-height: 30px !important">
                           بزرگسال
                        </li>
                        <li
                           data-tab="tab-4-2"
                           class="tabs-li-mobile"
                           style="line-height: 30px !important">
                           کودک
                        </li>
                        <li
                           data-tab="tab-4-3"
                           class="tabs-li-mobile"
                           style="line-height: 30px !important">
                           نوزاد
                        </li>
                     </ul>
                     <div id="tab-4-1" class="tab-content current">
                        <div class="price-card-mobile">
                           <div class="price-row">
                              <span>قیمت پایه</span>
                              <strong>{{
                                 formatPrice(
                                    cip.cip.PassengerDatas[0].BasePrice
                                 )
                              }}</strong>
                           </div>

                           <div class="price-row">
                              <span>مالیات</span>
                              <strong>{{
                                 formatPrice(cip.cip.PassengerDatas[0].TaxPrice)
                              }}</strong>
                           </div>

                           <div class="price-row">
                              <span>کمیسیون</span>
                              <strong>{{
                                 formatPrice(
                                    cip.cip.PassengerDatas[0].CommisionPrice
                                 )
                              }}</strong>
                           </div>
                           <div class="price-row price-total">
                              <span>قیمت نهایی</span>
                              <strong>
                                 {{
                                    formatPrice(
                                       cip.cip.PassengerDatas[0].TotalPrice
                                    )
                                 }}
                                 <span> ریال </span></strong
                              >
                           </div>
                        </div>
                     </div>
                     <div id="tab-4-2" class="tab-content">
                        <div class="price-card-mobile">
                           <div class="price-row">
                              <span>قیمت پایه</span>
                              <strong>{{
                                 formatPrice(
                                    cip.cip.PassengerDatas[1].BasePrice
                                 )
                              }}</strong>
                           </div>

                           <div class="price-row">
                              <span>مالیات</span>
                              <strong>{{
                                 formatPrice(cip.cip.PassengerDatas[1].TaxPrice)
                              }}</strong>
                           </div>

                           <div class="price-row">
                              <span>کمیسیون</span>
                              <strong>{{
                                 formatPrice(
                                    cip.cip.PassengerDatas[1].CommisionPrice
                                 )
                              }}</strong>
                           </div>
                           <div class="price-row price-total">
                              <span>قیمت نهایی</span>
                              <strong
                                 >{{
                                    formatPrice(
                                       cip.cip.PassengerDatas[1].TotalPrice
                                    )
                                 }}
                                 <span> ریال </span></strong
                              >
                           </div>
                        </div>
                     </div>
                     <div id="tab-4-3" class="tab-content">
                        <div class="price-card-mobile">
                           <div class="price-row">
                              <span>قیمت پایه</span>
                              <strong>{{
                                 formatPrice(
                                    cip.cip.PassengerDatas[2].BasePrice
                                 )
                              }}</strong>
                           </div>

                           <div class="price-row">
                              <span>مالیات</span>
                              <strong>{{
                                 formatPrice(cip.cip.PassengerDatas[2].TaxPrice)
                              }}</strong>
                           </div>

                           <div class="price-row">
                              <span>کمیسیون</span>
                              <strong>{{
                                 formatPrice(
                                    cip.cip.PassengerDatas[2].CommisionPrice
                                 )
                              }}</strong>
                           </div>
                           <div class="price-row price-total">
                              <span>قیمت نهایی</span>
                              <strong
                                 >{{
                                    formatPrice(
                                       cip.cip.PassengerDatas[2].TotalPrice
                                    )
                                 }}
                                 <span> ریال </span></strong
                              >
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