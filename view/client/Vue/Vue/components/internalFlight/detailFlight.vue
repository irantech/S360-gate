<template>

   <div class="international-available-details">
      <div>
         <div class=" international-available-panel-min">
            <ul class="tabs">
               <li data-tab="tab-1-0" class="tab-link current site-border-top-main-color ">
                  {{useXmltag('Informationflight')}}
               </li>
               <li data-tab="tab-2-0" class="tab-link site-border-top-main-color detailShow">
                  {{useXmltag('Price')}}
               </li>
               <li data-tab="tab-3-0" class="tab-link site-border-top-main-color" @click="getFeeCancel(`${flight.flight_type_li}`,`${flight.airline}`,`${flight.cabin_type}`)">
                  {{useXmltag('TermsandConditions')}}
               </li>
               <li class="tab-link site-border-top-main-color"  :data-tab="`tab-4-0`"
                   @click="getAirRules()" v-show="flight.source_id=='14'">
                  {{ useXmltag('Ticketrules')}}
               </li>
            </ul>
            <div id="tab-1-0" class="tab-content current">
               <div class="international-available-airlines-detail-tittle">
                        <span
                           class="iranB  lh25 displayb txtRight">
                            <i class="fa fa-circle site-main-text-color "></i>
                                                  {{useXmltag('Flight')}}
                                                  {{flight.departure_name}}
                                                   {{useXmltag('On')}}
                                                 {{flight.arrival_name}}
                                                   </span>
                  <div class=" international-available-airlines-detail  site-border-right-main-color">
                     <div class="international-available-airlines-logo-detail logo-airline-ico"></div>
                     <div class="international-available-airlines-info-detail my-info-detail ">
                                 <span class="airline_s"> {{useXmltag('Airline')}} :
                                        {{flight.airline_name}} ({{flight.airline}})
                                            <em>-</em>
                                 </span>
                        <span class="seatClass_s">
                                        {{flight.seat_class}}
                                        <em>-</em>
                                 </span>
                        <!--                                 <span class="capacity_s " v-if="flight.capacity > 0">-->
                        <!--                                        <i>{{useXmltag('Capacity')}} : </i>-->
                        <!--                                        {{flight.capacity}}-->
                        <!--                                        <em>-</em>-->
                        <!--                                 </span>-->
                        <div class="flightnumber_s" style="color: #666666;  font-size: 13px;">
                           <i> {{useXmltag('FlightNumber')}} : </i>
                           {{flight.flight_number}}
                           <em>-</em>
                        </div>
                        <span class="flighttime_s">
                                            {{useXmltag('Flighttime')}} :
                                            {{flight.duration_time}}
                                 </span>
                     </div>
                  </div>
                  <div class="international-available-airlines-detail   site-border-right-main-color">
                     <div class="airlines-detail-box ">
                        <span>{{flight.departure_name}}</span>
                        <span>{{flight.departure_date}} </span>
                        <span>{{flight.departure_time}}</span>
                     </div>
                     <div class="airlines-detail-box ">
                        <span>{{flight.arrival_name}}</span>
                        <span>{{flight.arrival_date}} </span>
                        <span>{{flight.arrival_time}}</span>
                     </div>
                     <div class="airlines-detail-box-2">
                                <span class="padt0 iranb  lh18 displayb" v-if="flight.baggage !=''">
                                    {{useXmltag('Permissible')}} :
                                    <i class="iranNum">{{flight.baggage}} {{useXmltag('Kg')}} </i>
                                </span>
                        <span class="padt0 iranL  lh18 displayb" v-if="flight.cabin_type !=''">
                                    {{useXmltag('Classrate')}} :
                                    <i class="openL"></i>
                                    {{flight.cabin_type}}
                                </span>
                        <span class="padt0 iranb  lh18 displayb" v-if="flight.aircraft !=''">
                                    {{useXmltag('Typeairline')}} :
                                    <i class="iranNum">{{flight.aircraft}} </i>
                                </span>
                     </div>
                  </div>
               </div>
            </div>
            <div id="tab-2-0" class="tab-content price-Box-Tab" >
               <div class="pop-up-h">
                  <span>{{ useXmltag('TicketDetailsBasedPriceID')}}</span>
               </div>
               <div class="price-Content site-border-main-color" style="position: relative; overflow: visible">
                                                  <span class="hidden-data" style="top: -10px">
                              fare: {{ flight.price.adult.p_fare_for_test.toLocaleString() }}
                              tax: {{ flight.price.adult.p_tax_for_test.toLocaleString() }}
                           </span>
                  <p id="AlertPanelHTC"></p>
                  <div class="tblprice">
                     <div v-if="!isMobile" class="parent-counter-ticket-details">
                        <table>
                           <thead>
                           <tr>
                              <th>رده سنی</th>
                              <th>قیمت پایه (fare)</th>
                              <th>مالیات و عوارض (tax)</th>
                              <th v-if="($store.state.isCounter || $store.state.isSafar360) && flight.flight_type_li == 'system'">
                                 کمیسیون آژانس
                              </th>
                              <th>تخفیف</th>
                              <th>قیمت نهایی (ریال)</th>
                           </tr>
                           </thead>
                           <tbody>
                           <tr v-for="row in priceTableRows" :key="row.key">
                              <td>{{ row.label }}</td>

                              <td>{{ row.fareDisplay }}</td>
                              <td>{{ row.taxDisplay }}</td>

                              <td v-if="($store.state.isCounter || $store.state.isSafar360) && flight.flight_type_li == 'system'">
                                 {{ row.markupDisplay }}
                              </td>

                              <td>{{ row.discountDisplay }}</td>

                              <td>{{ row.finalDisplay }}</td>
                           </tr>
                           </tbody>
                        </table>

                     </div>
                     <!-- MOBILE PRICE TABS -->
                     <div v-if="isMobile" class="price-tabs-mobile">
                        <ul class="price-tabs-header">
                           <li
                              v-for="row in priceTableRows"
                              :key="row.key"
                              :class="{ active: activePriceTab === row.key }"
                              @click="activePriceTab = row.key"
                           >
                              {{ row.label }}
                           </li>
                        </ul>

                        <div
                           v-for="row in priceTableRows"
                           :key="row.key + '-content'"
                           v-show="activePriceTab === row.key"
                           class="price-card-mobile"
                        >
                           <div class="price-row">
                              <span>قیمت پایه</span>
                              <strong>{{ row.fareDisplay }}</strong>
                           </div>

                           <div class="price-row">
                              <span>مالیات و عوارض</span>
                              <strong>{{ row.taxDisplay }}</strong>
                           </div>

                           <div
                              class="price-row"
                              v-if="$store.state.isCounter && flight.flight_type_li == 'system'"
                           >
                              <span>کمیسیون آژانس</span>
                              <strong>{{ row.markupDisplay }}</strong>
                           </div>

                           <div class="price-row">
                              <span>تخفیف</span>
                              <strong>{{ row.discountDisplay }}</strong>
                           </div>

                           <div class="price-row price-total">
                              <span>قیمت نهایی</span>
                              <strong>{{ row.finalDisplay }} ریال</strong>
                           </div>
                        </div>
                     </div>


                     <!--                            <div v-else class="parent-grid-ticket-details">-->
                     <!--                               <div class="parent-price-ticket-details">-->
                     <!--                                  <div class="tdpricelabel"> {{useXmltag('Adt')}} :</div>-->
                     <!--                                  <div class="tdprice">-->
                     <!--                                     <i v-if="flight.price.adult.has_discount=='yes'">{{flight.price.adult.with_discount}}</i>-->
                     <!--                                     <i v-else>{{flight.price.adult.price}}</i>-->
                     <!--                                     {{flight.price.adult.type_currency}}-->
                     <!--                                  </div>-->
                     <!--                               </div>-->
                     <!--                                <div class="parent-price-ticket-details">-->
                     <!--                                   <div class="tdpricelabel"> {{useXmltag('Chd')}} :</div>-->
                     <!--                                   <div class="tdprice">-->
                     <!--                                      <i v-if="flight.price.child.price > 0 ">{{flight.price.child.price}}</i>-->
                     <!--                                      <i v-else>{{useXmltag('PreInvoiceStep')}}</i>-->
                     <!--                                   </div>-->
                     <!--                                </div>-->
                     <!--                               <div class="parent-price-ticket-details">-->
                     <!--                                  <div class="tdpricelabel"> {{useXmltag('Inf')}} :</div>-->
                     <!--                                  <div class="tdprice">-->
                     <!--                                     <i v-if="flight.price.infant.price > 0 ">{{flight.price.infant.price}}</i>-->
                     <!--                                     <i v-else>{{useXmltag('PreInvoiceStep')}}</i>-->
                     <!--                                  </div>-->
                     <!--                               </div>-->
                     <!--                            </div>-->

                  </div>
               </div>



                  <!--                        <template v-if="fee_cancel !='' ">
                                              <div class="cancel-policy cancel_modal">
                                                  <div class="cancel-policy-head">
                                                      <div class="cancel-policy-head-text">{{useXmltag('DetailMoneyCancel')}}</div>
                                                      <div class="cancel-policy-class">
                                                          <span>{{useXmltag('Classflight')}} :</span>
                                                          <span> {{useXmltag('TypeClass')}} </span>
                                                      </div>
                                                  </div>
                                                  <div class="cancel-policy-inner">
                                                    <div class="cancel-policy-item cancel_modal">
                                                        <span class="cancel-policy-item-text site-main-text-color">{{useXmltag('Fromthetimeticketissueuntilnoondaysbeforeflight')}}</span>
                                                        <span class="cancel-policy-item-pnalty site-bg-main-color-admin site-bg-main-color" v-if="isNaN(`'${fee_cancel.ThreeDaysBefore}'`)">
                                                        {{ fee_cancel.ThreeDaysBefore }}
                                                    </span>
                                                        <span class="cancel-policy-item-pnalty site-bg-main-color-admin site-bg-main-color" v-else>
                                                         {{ fee_cancel.ThreeDaysBefore }} {{useXmltag('PenaltyPercent')}}
                                                    </span>
                                                    </div>

                                                    <div class="cancel-policy-item cancel_modal">
                                                    <span class="cancel-policy-item-text site-main-text-color">
                                                        {{useXmltag('Fromnoondaysbeforeflightnoondaybeforeflight')}}
                                                        </span>
                                                       <span class="cancel-policy-item-pnalty site-bg-main-color-admin site-bg-main-color"
                                                              v-if="isNaN(`'${fee_cancel.OneDaysBefore}'`)">
                                                        {{ fee_cancel.OneDaysBefore}}
                                                       </span>
                                                        <span class="cancel-policy-item-pnalty site-bg-main-color-admin site-bg-main-color" v-else>
                                                         {{ fee_cancel.OneDaysBefore}} {{useXmltag('PenaltyPercent')}}
                                                    </span>
                                                    </div>
                                                    <div class="cancel-policy-item cancel_modal">

                                                    <span class="cancel-policy-item-text site-main-text-color">
                                                        {{useXmltag('Fromnoondaybeforeflighthoursbeforeflight')}}
                                                    </span>

                                                        <span class="cancel-policy-item-pnalty site-bg-main-color-admin site-bg-main-color"
                                                              v-if="isNaN(`'${fee_cancel.ThreeHoursBefore}'`)">
                                                        {{ fee_cancel.ThreeHoursBefore}}
                                                    </span>
                                                        <span class="cancel-policy-item-pnalty site-bg-main-color-admin site-bg-main-color" v-else>
                                                         {{ fee_cancel.ThreeHoursBefore}} {{useXmltag('PenaltyPercent')}}
                                                    </span>
                                                    </div>
                                                    <div class="cancel-policy-item cancel_modal">
                                                        <span class="cancel-policy-item-text site-main-text-color">
                                                        {{useXmltag('Fromhoursbeforeflighttominutesbeforeflight')}}
                                                        </span>
                                                        <span class="cancel-policy-item-pnalty site-bg-main-color-admin site-bg-main-color site-bg-main-color"
                                                              v-if="isNaN(`'${fee_cancel.ThirtyMinutesAgo}'`)">
                                                        {{ fee_cancel.ThirtyMinutesAgo}}
                                                    </span>
                                                        <span class="cancel-policy-item-pnalty site-bg-main-color-admin site-bg-main-color" v-else>
                                                         {{ fee_cancel.ThirtyMinutesAgo}} {{useXmltag('PenaltyPercent')}}
                                                    </span>
                                                    </div>

                                                    <div class="cancel-policy-item cancel_modal">
                                                        {{ useXmltag('Minutesbeforetheflight')}}
                                                        <span class="cancel-policy-item-text site-main-text-color ">
                                                    </span>
                                                        <span class="cancel-policy-item-pnalty site-bg-main-color-admin site-bg-main-color"
                                                              v-if="isNaN(`'${fee_cancel.OfThirtyMinutesAgoToNext}'`)">
                                                        {{ fee_cancel.ThirtyMinutesAgo}}
                                                    </span>
                                                        <span class="cancel-policy-item-pnalty site-bg-main-color-admin site-bg-main-color" v-else>
                                                         {{ fee_cancel.ThirtyMinutesAgo}} {{useXmltag('OfThirtyMinutesAgoToNext')}}
                                                    </span>
                                                    </div>
                                                  </div>
                                              </div>
                                          </template>-->

               <div class="cancel-policy cancel-policy-charter" v-if="flight.flight_type_li !='system'">
                        <span class="">
                            {{useXmltag('ThecharterflightscharterunderstandingCivilAviationOrganization')}}
                        </span>
               </div>

            </div>
            <div id="tab-3-0" class="tab-content"><p class="iranL  lh25 displayb"></p>
               <ul>
                  <li>1- {{useXmltag('AccordingCivilAviationOrganizationResponsibilityResponsibleFlying')}}</li>
                  <li>2- {{useXmltag('ResponsibilityAllTravelInformationEntryIncorrectPassengerRePurchase')}}</li>
                  <li>3- {{useXmltag('MustEnterValidMobileNecessary')}}</li>
                  <li>4- {{useXmltag('AviationRegulationsBabyChildAdultAges')}}</li>
                  <li>5- {{useXmltag('CanNotBuyBabyChildTicketOnlineIndividuallySeparatelyAdultTickets')}}</li>
                  <li>6- {{useXmltag('AircraftDeterminedAnyChangeAircraftCarrierHoldingFlight')}}</li>
                  <li>7- {{useXmltag('PresenceDomesticFlightsRequiredForeignFlightsRequiredDocuments')}}</li>
               </ul>
               <cancel-policy
                  :fee_cancel="fee_cancel"
                  :flight_type_li="flight.flight_type_li"
               />
            </div>
            <div :id="`tab-4-0`" class="tab-content w-100" v-show="flight.source_id=='14'">

               <img :src="`${getUrlWithoutLang()}/view/client/assets/images/load21.gif`"
                    width="120px"
                    alt="" class="loaderDetail"
                    style="width: 50px;position: relative;"
                    :id="`loaderDetail${flight.flight_id}`" v-if="is_show_loader">

               <rules-flight :data_rules="data_rules" v-if='is_show_rules'></rules-flight>
            </div>
         </div>
      </div>
      <span class="international-available-detail-btn more_1 ">
             <div class="text_div_morei site-main-text-color iranM " v-if="flight.point_club > 0 ">
                     {{ useXmltag('Yourpurchasepoints')}} {{ flight.point_club}} {{ useXmltag('Point')}}
                 </div>
            <div class="my-more-info slideDownAirDescription">
                {{useXmltag('MoreDetails')}}
                <i class="fa fa-angle-down"></i>
            </div>
        </span>
      <span class="international-available-detail-btn  slideUpAirDescription displayiN">
            <i class="fa fa-angle-up site-main-text-color"></i>
        </span>
   </div>

</template>

<script>
import rulesFlight from './rulesFlight';
import CancelPolicy from './CancelPolicy.vue';
import airlineOutPutFlight from './airlineFight.vue'
import infoOutPutFlight from './outPutFlight.vue'
import airlineReturnFlight from './airlineReturnFlight.vue'
import infoReturnRouteFlight from './infoReturnRouteFlight.vue'
import priceFlight from './priceFlight.vue'
import detailDepartFlight from '../interantionalFlight/detailDepartFlight.vue'
import detailReturnFlight from '../interantionalFlight/detailReturnFlight.vue'
export default {
   name: "detailFlight",
   props:['flight','data_search'],
   data(){
      return {
         fee_cancel : '',
         data_rules : {},
         is_show_rules : false,
         is_show_loader : true ,
         isMobileView: window.innerWidth <= 768,
         activePriceTab: 'adult'
      }
   },
   components: {
      'rulesFlight':rulesFlight,
      'CancelPolicy':CancelPolicy
   },
   methods:{
      getFeeCancel(type_flight,airline_iata,cabin_type){
         if(type_flight==='system'){
            let _this = this
            axios.post(amadeusPath + 'ajax', {
               className: 'newApiFlight',
               method: 'getFeeCancel',
               airline_iata,
               cabin_type,
               is_json: true,
            }, {
               'Content-Type': 'application/json',
            }).then(response => {
               let data_fee = response.data; // <-- این الان یک آبجکت با key data هست

               if(Array.isArray(data_fee.data) && data_fee.data.length) {
                  this.fee_cancel = data_fee.data.map(item => ({
                     ...item,
                     fine_text: item.fine_text ||
                        (Number(item.fine_percentage) === 0 ? 'بدون جریمه' :
                           Number(item.fine_percentage) === 100 ? 'غیرقابل استرداد' :
                              `%${item.fine_percentage}`),
                     title: item.title || 'عنوان نامشخص'
                  }));
               } else {
                  this.fee_cancel = [];
               }
            }).catch(error => {
               console.log(error);
            });

         }

         return true ;
      } ,
      getAirRules(){

         let _this = this;
         axios.post(amadeusPath + 'ajax',
            {
               className: 'newApiFlight',
               method: 'getInfoRulesFlight',
               request_number: _this.flight.unique_code,
               agency_id:_this.flight.agency_id,
               fare_source_code :_this.flight.flight_id
            },
            {
               'Content-Type': 'application/json'
            }).then(function (response) {
            _this.data_rules = response.data.data ;
            _this.is_show_rules = true;
            _this.is_show_loader = false;
         }).catch(function (error) {
         });

      },
      _toNumber(v) {
         if (v === null || v === undefined || v === '') return NaN;
         const n = Number(v);
         return Number.isFinite(n) ? n : NaN;
      },
      _fmtNumber(v) {
         if (v === null || v === undefined || (typeof v === 'number' && Number.isNaN(v))) return '-';
         const n = Number(v);
         return Number.isNaN(n) ? '-' : n.toLocaleString();
      },
      handleResize() {
         this.isMobileView = window.innerWidth <= 768
      }
   },
   computed: {
      priceTableRows() {

         const isCounter = this.$store.state.isCounter;
         const isSafar360 = this.$store.state.isSafar360;
         const priceData = (this.flight && this.flight.price) ? this.flight.price : {};
         const typeMap = {
            adult: 'بزرگسال',
            child: 'کودک',
            infant: 'نوزاد'
         };

         const rows = [];

         Object.keys(priceData).forEach((key) => {
            const f = priceData[key] || {};

            let markupNum = null;
            if (f.price === 0 || f.price === '0' || f.price === null || f.price === undefined) {
               markupNum = null;
            } else {
               markupNum = this._toNumber(f.markup_amount);
            }


            const baseForFare = ((this.flight && this.flight.flight_type_li === 'charter') ? (f.fare + markupNum ?? null) : (f.fare ?? null));

            const fareNum = this._toNumber(baseForFare);
            const taxNum = this._toNumber(f.tax);



            let discountDisplay;
            if (f.with_discount == 0) {
               discountDisplay = '0';
            } else {
               const p = this._toNumber(f.price);
               const wd = this._toNumber(f.with_discount);
               discountDisplay = (!Number.isNaN(p) && !Number.isNaN(wd)) ? ( (p - wd).toLocaleString() ) : '-';
            }

            let finalDisplay;
            if ((isCounter || isSafar360) && this.flight.flight_type_li == 'system') {
               const p = this._toNumber(f.price);
               const wd = this._toNumber(f.with_discount);
               const mk = (markupNum === null) ? NaN : Number(markupNum);

               if (f.with_discount == 0) {
                  finalDisplay = (!Number.isNaN(p) && !Number.isNaN(mk)) ? ( (p - mk).toLocaleString() ) : '-';
               } else {
                  finalDisplay = (!Number.isNaN(wd) && !Number.isNaN(mk)) ? ( (wd - mk).toLocaleString() ) : '-';
               }

            } else {
               if (f.with_discount == 0) {
                  finalDisplay = f.price ? this._fmtNumber(f.price) : '-';
               } else {
                  finalDisplay = f.with_discount ? this._fmtNumber(f.with_discount) : '-';
               }
            }

            rows.push({
               key,
               label: typeMap[key] || key,
               fareDisplay: this._fmtNumber(fareNum),
               taxDisplay: this._fmtNumber(taxNum),
               markupDisplay: (markupNum === null ? '-' : Number(markupNum).toLocaleString()),
               discountDisplay,
               finalDisplay
            });
         });

         return rows;
      },
      isMobile() {
         return this.isMobileView
      }
   },
   mounted() {
      window.addEventListener('resize', this.handleResize)
   },
   beforeDestroy() {
      window.removeEventListener('resize', this.handleResize)
   }
}
</script>

<style scoped>

</style>