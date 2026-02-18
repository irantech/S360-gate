<template>
   <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 parvaz-sidebar col-padding-5">
      <div class="parent_sidebar">
         <div class="currency-gds" v-if="data_search.is_currency > 0" @click="showListCurrencyExist()">
            <div class="currency-inner DivDefaultCurrency" >
               <img :src="`${getUrlWithoutLang()}/pic/flagCurrency/Iran.png`"  alt="" id="IconDefaultCurrency" v-if="currency_info ===''">
               <img :src="`${getUrlWithoutLang()}/pic/flagCurrency/${currency_info.CurrencyFlag}`" alt="" id="IconDefaultCurrency" v-else>
               <span class="TitleDefaultCurrency" id="TitleDefaultCurrency">  {{ currency_title}}</span>
               <span class="currency-arrow"></span>
            </div>
            <div class="change-currency show-currency" 	v-show="is_show_currency_list" >
               <div class="change-currency-inner">
                  <div class="change-currency-item main" @click="ConvertCurrency('0','Iran.png','ریال ایران')">
                     <img :src="`${getUrlWithoutLang()}/pic/flagCurrency/Iran.png`" alt="">
                     <span>{{useXmltag('Rial')}}</span>
                  </div>

                  <template v-for="currency in list_currency">
                     <div class="change-currency-item"
                          @click="ConvertCurrency(currency.CurrencyCode,currency.CurrencyFlag,currency.CurrencyTitle)">
                        <img :src="`${getUrlWithoutLang()}/pic/flagCurrency/${currency.CurrencyFlag}`"
                             alt="">
                        <span>{{currency.CurrencyTitle}}</span>
                     </div>
                  </template>
                  <!---->
               </div>
            </div>
         </div>
         <!-- Result search -->
         <div class="filtertip parvaz-filter-change site-bg-main-color site-bg-color-border-bottom">
            <a v-if="today_date"
               :href="`${amadeusPathByLang()}international/1/${data_search.origin}-${data_search.destination}/${dataSearch.prev}/Y/${data_search.adult}-${data_search.child}-${data_search.infant}`">
                   <span class=" chooseiconDay icons tooltipWeighDay right site-border-text-color">
                       <i class="zmdi zmdi-chevron-right iconDay site-secondary-text-color"></i>
                       <span class="tooltiptextWeightDay"> {{ useXmltag('Previousday') }} </span>
                   </span>
            </a>
            <a v-else v-on:click.prevent.stop="" href="#">
                       <span class=" chooseiconDay icons tooltipWeighDay right site-border-text-color">
                           <i class="zmdi zmdi-chevron-right iconDay site-secondary-text-color"></i>
                           <span class="tooltiptextWeightDay"> {{ useXmltag('Previousday') }} </span>
                        </span>
            </a>
            <div class="tip-content ">
               <p class="">
                  <span class=" bold counthotel">{{ data_search.name_departure}}</span>
                  {{ useXmltag('On') }}
                  <span class=" bold counthotel">{{ data_search.name_arrival}}</span>
               </p>
               <p class="counthotel txt12">{{data_search.DateFlightWithName}} </p>
               <div class="silence_span ph-item2" v-if="countFlights > 0">{{ countFlights }} {{
                     useXmltag('NumberFlightFound')}}
               </div>
            </div>
            <a v-if="today_date"
               :href="`${amadeusPathByLang()}international/1/${data_search.origin}-${data_search.destination}/${dataSearch.next}/Y/${data_search.adult}-${data_search.child}-${data_search.infant}`">
                   <span class="chooseiconDay icons tooltipWeighDay left site-border-text-color">
                       <i class="zmdi zmdi-chevron-left iconDay site-secondary-text-color">
                       </i>
                           <span class="tooltiptextWeightDay">  {{ useXmltag('Nextday') }}  </span>
                   </span>
            </a>
            <a v-else v-on:click.prevent.stop="" href="#">
                     <span class="chooseiconDay icons tooltipWeighDay left site-border-text-color">
                       <i class="zmdi zmdi-chevron-left iconDay site-secondary-text-color">
                       </i>
                           <span class="tooltiptextWeightDay">  {{ useXmltag('Nextday') }}  </span>
                   </span>
            </a>
            <div class="open-sidebar-parvaz " @click="showSearchBoxTicket()">

               {{ useXmltag('ChangeSearchType') }}
            </div>
         </div>
         <!-- search box -->
         <main-sidebar :dataSearch='dataSearch' :countFlights='countFlights'></main-sidebar>
         <div class="s-u-filter-wrapper s-u-filter-wrapper-fo">
            <ul id="s-u-filter-wrapper-ul">
               <span class="s-u-close-filter"></span>

               <!-- pricefilter -->
               <li class="s-u-filter-item" data-group="flight-price">
                           <span class="s-u-filter-title">
                           <i class="zmdi zmdi-money site-main-text-color-drck"></i>  {{ useXmltag('Price') }}</span>
                  <div class="s-u-filter-content slider_range_parent ">
                     <vue-slider v-model="value_price" :tooltip="'always'"  :min="min_price_props" :max="max_price_props" @change="priceRangeSlider(value_price)">
                        <template v-slot:tooltip="{value}">
                           <div class="vue-slider-dot-tooltip-inner vue-slider-dot-tooltip-inner-top site-bg-main-color  site-border-main-color">{{ value| formatNumber }}</div>
                        </template>

                        <template v-slot:process="{ start, end, style, index }">
                           <div class="vue-slider-process vue-slider-dot-tooltip-inner site-bg-main-color" :style="[style]">
                              <!-- Can add custom elements here -->
                           </div>
                        </template>
                     </vue-slider>

                  </div>
               </li>
               <!-- flight duplicate filter -->

               <li class="s-u-filter-item p-2 py-3">
                  <div class="form-check form-switch p-0">
                     <div class="d-flex align-items-center justify-content-between p-0 w-100">
                        <label for="duplicateFlightSwitch" style="margin:0 !important;">
                           <i class="fa fa-eraser FlightRepetitionCount site-main-text-color-drck" style="font-size:13px !important"></i>
                           <span class="" style="font-weight:500 !important;font-size:13px">{{ useXmltag('FlightRepetition') }}</span>
                        </label>

                        <span
                           :data-inactive="useXmltag('Inactive')"
                           :data-active="useXmltag('Active')"
                           :class="[
    'tzCBPart',
    'site-bg-filter-color',
    'filter-to-check',
    'duplicateFlightSwitch',
    duplicateFlight ? 'checked' : ''
  ]"                    @click="toggleDuplicateFlights">
    </span>


                     </div>
                     <input
                        type="checkbox"
                        id="duplicateFlightSwitch"
                        class="check-switch"
                        v-model="duplicateFlight"
                        style="display:none;" />


                     <p :class="[
                    duplicateFlight ? 'd-none' : 'd-block','small','mt-2'
                 ]" style="font-weight:500 !important;font-size:11px">
                        {{removedCount}} {{ useXmltag('FlightRepetitionCount') }}
                     </p>
                  </div>
               </li>
               <!-- flight Interrupt filter -->
               <li class="s-u-filter-item" data-group="flight-interrupt">

                  <span class="s-u-filter-title"><i class="zmdi zmdi-filter-list site-main-text-color-drck"></i>{{ useXmltag('Stop') }}  </span>

                  <div class="s-u-filter-content">

                     <ul class="s-u-filter-item-time filter-interrupt-ul filter-interrupt-ul-f">

                        <li>
                           <label for="filter-interrupt">
                              <span>{{ useXmltag('All') }} </span>
                           </label>
                           <span :data-inactive="useXmltag('Inactive')" :data-active="useXmltag('Active') "
                                 class="tzCBPart site-bg-filter-color checked filter-to-check all_stop"
                                 @click="stopFilterFlight('all_stop')" filtered="all_stop"></span>
                           <input class="check-switch" type="checkbox" id="filter-interrupt" value="allStop"
                                  checked="checked"/>

                        </li>

                        <li v-for="turn_interrupt in interrupt">
                           <label :for="`filter-${turn_interrupt.name_en}`">
                              <span>{{ turn_interrupt.name_fa }}</span>
                           </label>
                           <span :data-inactive="useXmltag('Inactive')" :data-active="useXmltag('Active')"
                                 class="tzCBPart site-bg-filter-color stop"
                                 @click="stopFilterFlight(turn_interrupt.name_en)"
                                 :class="`${turn_interrupt.name_en}`"></span>
                           <input class="check-switch" type="checkbox" :id="`filter-${turn_interrupt.name_en}`"
                                  :value="`${turn_interrupt.name_en}`"/>

                        </li>

                     </ul>
                  </div>
               </li>
               <!-- flight type filter -->
               <li class="s-u-filter-item" data-group="flight-type">

                        <span class="s-u-filter-title"><i
                           class="zmdi zmdi-flight-takeoff site-main-text-color-drck"></i> {{ useXmltag('Typeflight') }} </span>

                  <div class="s-u-filter-content">

                     <ul class="s-u-filter-item-time filter-type-ul filter-type-ul-f">

                        <li>
                           <label for="filter-type">
                              <span>{{ useXmltag('All') }}</span>
                           </label>
                           <span :data-inactive="useXmltag('Inactive')" :data-active="useXmltag('Active')"
                                 class="tzCBPart site-bg-filter-color checked filter-to-check type_flight all_type_flight"
                                 @click="typeFilterFlight('all_type_flight')"></span>
                           <input class="check-switch" type="checkbox" id="filter-type" value="allFlightType"
                                  checked="checked"/>

                        </li>

                        <li v-for="filter_flight in typeFlightFilter">
                           <label :for="`filter-${filter_flight.name_en}`">
                              <span>{{filter_flight.name_fa }}</span>
                           </label>
                           <span :data-inactive="useXmltag('Inactive')" :data-active="useXmltag('Active')"
                                 class="tzCBPart site-bg-filter-color type_flight"
                                 @click="typeFilterFlight(filter_flight.name_en)"
                                 :class="`${filter_flight.name_en}`"></span>
                           <input class="check-switch" type="checkbox" :id="`filter-${filter_flight.name_en}`"
                                  :value="`${filter_flight.name_en}`"/>
                        </li>
                     </ul>
                  </div>
               </li>
               <!-- seat class filter -->
               <li class="s-u-filter-item" data-group="flight-seat">

                       <span class="s-u-filter-title"><i class="zmdi zmdi-airline-seat-recline-extra"></i>
                          {{ useXmltag('Classflight') }}
                       </span>

                  <div class="s-u-filter-content">

                     <ul class="s-u-filter-item-time filter-seat-ul filter-seat-ul-f">

                        <li>
                           <label for="filter-seat">
                              <span>{{ useXmltag('All') }}</span>
                           </label>
                           <span :data-inactive="useXmltag('Inactive')" :data-active="useXmltag('Active')"
                                 class="tzCBPart site-bg-filter-color checked filter-to-check all_seat_class"
                                 @click="seatClassFilterFlight('all_seat_class')"></span>
                           <input class="check-switch" type="checkbox" id="filter-seat" value="allSeatClass"
                                  checked="checked"/>
                        </li>

                        <li v-for="seat_class in seatClassFilter">
                           <label :for="`filter-${seat_class.name_en}`">
                              <span>{{ seat_class.name_fa }}</span>
                           </label>
                           <span :data-inactive="useXmltag('Inactive')" :data-active="useXmltag('Active')"
                                 class="tzCBPart site-bg-filter-color seat_class"
                                 @click="seatClassFilterFlight(seat_class.name_en)"
                                 :class="`${seat_class.name_en}`"></span>
                           <input class="check-switch" type="checkbox" :id="`filter-${seat_class.name_en}`"
                                  :value="`${seat_class.name_en}`"/>
                        </li>
                     </ul>
                  </div>
               </li>
               <li class="s-u-filter-item" data-group="flight-airline">
                  <span class="s-u-filter-title"><i class="zmdi zmdi-local-airport site-main-text-color-drck"></i> {{ useXmltag('Airline') }}</span>
                  <div class="s-u-filter-content">
                     <ul class="s-u-filter-item-time filter-airline-ul filter-airline-ul-f">
                        <li>
                           <label for="filter-airline">
                              <span>{{ useXmltag('All') }}</span>
                           </label>
                           <span :data-inactive="useXmltag('Inactive')" :data-active="useXmltag('Active')"
                                 class="tzCBPart site-bg-filter-color checked filter-to-check  all_airline"
                                 @click="airlineFilterFlight('all_airline')"></span>
                           <input class="check-switch" type="checkbox" id="filter-airline" value="allAirline"
                                  checked="checked"/>

                        </li>

                        <template v-for="data_each_airline in minPriceAirline">
                           <li :id="`${data_each_airline.name_en}-filter`">
                              <label :for="`filter-${data_each_airline.name_en}`" class='align-items-center'>
                                 <i :id="`${data_each_airline.name_en}-minPrice`">{{data_each_airline.price}}</i>
                                 <span class='text-left'>{{ data_each_airline.name}}</span>
                              </label>
                              <span :data-inactive="useXmltag('Inactive')" :data-active="useXmltag('Active')"
                                    class="tzCBPart site-bg-filter-color airline"
                                    @click="airlineFilterFlight(data_each_airline.name_en)"
                                    :class="`${data_each_airline.name_en}`"></span>
                              <input class="check-switch" type="checkbox"
                                     :id="`filter-${data_each_airline.name_en}`"
                                     v-model="data_each_airline.name_en"/>
                           </li>
                        </template>
                     </ul>
                  </div>
               </li>

               <!-- time filter -->
               <li class="s-u-filter-item" data-group="flight-time">
                  <span class="s-u-filter-title "><i class="zmdi zmdi-time site-main-text-color-drck"></i>{{ useXmltag('RunTime') }} </span>
                  <div class="s-u-filter-content">
                     <ul class="s-u-filter-item-time filter-time-ul filter-time-ul-f">
                        <li>
                           <label for="filter-time">
                              <span>{{ useXmltag('All') }}</span>
                           </label>
                           <span :data-inactive="useXmltag('Inactive')" :data-active="useXmltag('Active')"
                                 class="tzCBPart site-bg-filter-color checked filter-to-check all_time"
                                 id="allTime"
                                 v-on:click="timeFilterFlightForeign('all_time')"></span>
                           <input class="check-switch" type="checkbox" id="filter-time" value="allTime"
                                  checked="checked"/>

                        </li>
                        <template v-for="each_time in timeFilter">
                           <li>
                              <label :for="`filter-${each_time.name_en}`">
                                 <i>{{each_time.value}}</i>
                                 <span>{{each_time.name_fa}}</span>
                              </label>
                              <span :data-inactive="useXmltag('Inactive')" :data-active="useXmltag('Active')"
                                    class="tzCBPart site-bg-filter-color time"
                                    @click="timeFilterFlightForeign(each_time.time)"
                                    :class="`${each_time.time}`"></span>
                              <input class="check-switch" type="checkbox" :id="`filter-${each_time.time}`"
                                     v-model="each_time.time"/>
                           </li>
                        </template>
                     </ul>
                  </div>
               </li>

               <div class="articles-list d-none">
                  <h6>{{ useXmltag('RelatedArticles') }}</h6>
                  <ul></ul>
               </div>
            </ul>
         </div>
      </div>
   </div>
</template>

<script>
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/default.css'
import mainSidebar from './mainSidebar'

export default {
   name: "sidebar",
   props: ['dataSearch', 'price', 'interrupt', 'timeFilter', 'typeFlightFilter', 'seatClassFilter', 'minPriceAirline', 'countFlights'],
   data() {
      return {
         is_show_currency_list:false,
         currency_title:'',
         value_price: [0, 0],
         title_origin_city : '',
         title_arrival_city : '',
         iata_origin : '',
         iata_arrival : '',
         cities_origin : [] ,
         cities_arrival : [] ,
         min_price_props: 0,
         max_price_props: 0,
         data_search: [],
         currency_info: '',
         error_currency_info: '',
         list_currency: [],
         today_date: true,
         date_picker_departure: '',
         date_picker_return: '',
         multi_way: '',
         multi_way_check: false,
         is_search: false,
         is_arrival_search: false,
         format_datepicker: 'jYYYY-jMM-jDD',
         duplicateFlight: true,
         originalDeptFlights: [],
         originalReturnFlights: [],
         firstTimeApplied: false,
         removedCount:0,
         isOfferFilterActive: false,
         lang_datepicker: 'fa',
         svg_icon_1: `<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" x="0" y="0" viewBox="0 0 907.62 907.619" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><g xmlns="http://www.w3.org/2000/svg"><path d="M591.672,907.618c28.995,0,52.5-23.505,52.5-52.5V179.839l42.191,41.688c10.232,10.11,23.567,15.155,36.898,15.155   c13.541,0,27.078-5.207,37.347-15.601c20.379-20.625,20.18-53.865-0.445-74.244L626.892,15.155C617.062,5.442,603.803,0,589.993,0   c-0.104,0-0.211,0-0.314,0.001c-13.923,0.084-27.244,5.694-37.03,15.6l-129.913,131.48c-20.379,20.625-20.18,53.865,0.445,74.244   c20.626,20.381,53.866,20.181,74.245-0.445l41.747-42.25v676.489C539.172,884.113,562.677,907.618,591.672,907.618z"></path><path d="M315.948,0c-28.995,0-52.5,23.505-52.5,52.5v676.489l-41.747-42.25c-20.379-20.625-53.62-20.825-74.245-0.445   c-20.625,20.379-20.825,53.619-0.445,74.244l129.912,131.479c9.787,9.905,23.106,15.518,37.029,15.601   c0.105,0.001,0.21,0.001,0.315,0.001c13.81,0,27.07-5.442,36.899-15.155L484.44,760.78c20.625-20.379,20.824-53.619,0.445-74.244   c-20.379-20.626-53.62-20.825-74.245-0.445l-42.192,41.688V52.5C368.448,23.505,344.943,0,315.948,0z" style=""></path></g></g></svg>`,
         svg_icon_2: `<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g transform="matrix(-1,-1.2246467991473532e-16,1.2246467991473532e-16,-1,512,512)"><g xmlns="http://www.w3.org/2000/svg"><g><path d="M374.108,373.328c-7.829-7.792-20.492-7.762-28.284,0.067L276,443.557V20c0-11.046-8.954-20-20-20    c-11.046,0-20,8.954-20,20v423.558l-69.824-70.164c-7.792-7.829-20.455-7.859-28.284-0.067c-7.83,7.793-7.859,20.456-0.068,28.285    l104,104.504c0.006,0.007,0.013,0.012,0.019,0.018c7.792,7.809,20.496,7.834,28.314,0.001c0.006-0.007,0.013-0.012,0.019-0.018    l104-104.504C381.966,393.785,381.939,381.121,374.108,373.328z" style="" class=""></path></g></g></g></svg>`,
      }
   },
   methods: {
      activateSeatClassFilter(classFlight) {
        // DO NOT emit to parent if this is initial load from URL
        // The parent (main.vue) already set the filter in created()
        // Emitting here would cause the filter to toggle off!

        // Only update UI - Remove checked from "همه" (All)
        let allSeatClassElements = document.getElementsByClassName('all_seat_class');

        if (allSeatClassElements.length > 0) {
          // Force remove checked class multiple times to ensure it's removed
          for (let i = 0; i < allSeatClassElements.length; i++) {
            allSeatClassElements[i].classList.remove("checked");
          }
        }

        // Find and activate the specific class
        let specificClassElements = document.getElementsByClassName(classFlight);

        if (specificClassElements.length > 0) {
          for (let i = 0; i < specificClassElements.length; i++) {
            if (specificClassElements[i].classList.contains('seat_class')) {
              specificClassElements[i].classList.add("checked");
              break;
            }
          }
        }
      },
      showListCurrencyExist(){
         this.is_show_currency_list = !this.is_show_currency_list;

         if(document.querySelector(".show-currency").classList.contains("d-block")) {
            document.getElementsByClassName('show-currency')[0].classList.remove("d-block");

         }else{
            document.getElementsByClassName('show-currency')[0].classList.add("d-block");
         }
      },
      async ConvertCurrency(code, Icon, Title){
         let _this = this ;
         document.getElementById('IconDefaultCurrency').setAttribute('src', rootMainPath + '/gds/pic/flagCurrency/' + Icon);
         _this.currency_title = Title ;
         await axios.post(amadeusPath + 'ajax',{
            className: 'currencyEquivalent',
            method: 'CurrencyEquivalent',
            code : code,
            is_json:true
         },{
            'Content-Type': 'application/json'
         }).then(function (response) {

            _this.is_show_currency_list= false;
            _this.$store.commit('setPriceCurrency',response.data);
         }).catch(function (error) {
         });

      },
      async getCurrencyInfo(){
         let _this = this;
         await axios.post(amadeusPath + 'ajax',
            {
               className: 'newApiFlight',
               method: 'infoCurrency',
               is_json:true
            },
            {
               'Content-Type': 'application/json'
            }).then(function (response) {
            _this.currency_info = response.data.data;
            if(_this.dataSearch.dataSearch.software_lang !=='fa')
            {
               _this.currency_title = _this.currency_info.CurrencyTitleEn ;
            }else{
               _this.currency_title = _this.currency_info.CurrencyTitleFa ;
            }
         }).catch(function (error) {
            _this.error_currency_info = error.message
         });
      },
      async listCurrency(){
         let _this = this;
         await axios.post(amadeusPath + 'ajax',
            {
               className: 'newApiFlight',
               method: 'listCurrency',
               is_json:true
            },
            {
               'Content-Type': 'application/json'
            }).then(function (response) {
            _this.list_currency = response.data.data
         }).catch(function (error) {
            _this.list_currency = null
         });
      },
      async checkToDayDate() {
         let _this = this;
         await axios.post(amadeusPath + 'ajax',
            {
               className: 'newApiFlight',
               method: 'checkToDayDate',
               dateSearch: _this.dataSearch.dataSearch.departureDate
            },
            {
               'Content-Type': 'application/json'
            }).then(function (response) {
            _this.today_date = response.data.data;
            _this.multi_way = (_this.dataSearch.dataSearch.MultiWay == 'TwoWay') ? true : false;

         }).catch(function (error) {
            _this.today_date = error.message
         });
      },
      timeFilterFlightForeign(value) {
         this.$emit('filterFlights', value, 'time');
      },
      stopFilterFlight(value) {
         this.$emit('filterFlights', value, 'stop');
      },
      typeFilterFlight(value) {
         this.$emit('filterFlights', value, 'type_flight');
      },
      airlineFilterFlight(value) {
         this.$emit('filterFlights', value, 'airline');
      },
      seatClassFilterFlight(value) {
         this.$emit('filterFlights', value, 'seat_class');
      },
      priceRangeSlider(value){
         this.$emit('filterPriceFlights', value, 'price_sidebar');
      },

      toggleDuplicateFlights() {
         this.duplicateFlight = !this.duplicateFlight;
         this.applyFilter(this.duplicateFlight);
      },

      applyFilter(isOn) {
         const removeDuplicates = (arr) => {
            if (!arr || arr.length === 0) return [];

            const map = new Map();

            arr.forEach(f => {
               const isSpecialSeat =
                  f.seat_class_en === 'business' || f.seat_class_en === 'premium_economy';

               const cabinPart = isSpecialSeat ? f.cabin_type : '';
               const key =
                  `${f.departure_time}|${f.flight_type}|${cabinPart}|${f.airline_name_en}`;

               const price = f.price?.adult?.price ?? Infinity;

               if (price === 0) return;

               // فقط اگر قیمت معتبر نباشد، از آن صرف‌نظر کن
               if (price === null || price === undefined || price === Infinity) {
                  return;
               }

               if (!map.has(key)) {
                  map.set(key, f);
               } else {
                  const old = map.get(key);
                  const oldPrice = old.price?.adult?.price ?? Infinity;
                  if (price < oldPrice) map.set(key, f);
               }
            });

            return [...map.values()];
         };

         // دریافت داده اصلی (با یا بدون فیلتر پیشنهاد ویژه)
         let baseData = this.isOfferFilterActive
            ? this.originalDeptFlights.filter(f => f.is_private === 'private')
            : this.originalDeptFlights;

         if (isOn) {
            // فیلتر تکراری فعال: حذف تکراری‌ها
            const deptFiltered = removeDuplicates(baseData);
            this.$store.commit("updateInternationalFlights", deptFiltered);
         } else {
            // فیلتر تکراری غیرفعال: نمایش همه
            const deptFiltered = removeDuplicates(baseData);

            const originalNoZero = baseData.filter(f => {
               const price = f?.price?.adult?.price ?? 0;
               return price !== 0;
            });

            const filteredNoZero = deptFiltered.filter(f => {
               const price = f?.price?.adult?.price ?? 0;
               return price !== 0;
            });

            this.removedCount = originalNoZero.length - filteredNoZero.length;

            this.$store.commit("updateInternationalFlights",
               JSON.parse(JSON.stringify(baseData))
            );
         }
      },

      updateOfferFilterStatus(isActive) {
         this.isOfferFilterActive = isActive;
         this.applyFilter(this.duplicateFlight);
      }



   },
   computed: {
      flights() {
         return this.$store.state.flights;
      }
   },
   created: function () {
      this.enableCross = false

   },
   watch: {
      flights: {
         handler(newFlights) {
            if (newFlights && newFlights.length > 0 && !this.firstTimeApplied) {
               this.originalDeptFlights = JSON.parse(JSON.stringify(newFlights));
               this.firstTimeApplied = true;
               this.applyFilter(true);
            }
         },
         immediate: true
      },
      dataSearch() {
         let _this = this;
         if (_this.dataSearch) {
            _this.data_search = _this.dataSearch.dataSearch;
            _this.title_origin_city = `${_this.data_search.airport_departure}-${_this.data_search.country_departure}-${_this.data_search.name_departure}-${_this.data_search.origin}`;
            _this.iata_origin = _this.data_search.origin;
            _this.title_arrival_city = `${_this.data_search.airport_arrival}-${_this.data_search.country_arrival}-${_this.data_search.name_arrival}-${_this.data_search.destination}`;
            _this.iata_arrival = _this.data_search.destination;
            // _this.checkToDayDate();
            _this.getCurrencyInfo();
            _this.listCurrency();

         }

      },
      price() {
         if (this.price) {
            this.min_price_props = this.price.min_price ;
            this.max_price_props = this.price.max_price;
            this.value_price = [this.price.min_price,this.price.max_price];
         }
      },
      seatClassFilter: {
        handler: function(newVal, oldVal) {
          // Check if we have a classFlight parameter in URL and filters are now loaded
          // seatClassFilter can be either an Array or an Object
          const hasFilters = newVal && (
            (Array.isArray(newVal) && newVal.length > 0) ||
            (typeof newVal === 'object' && Object.keys(newVal).length > 0)
          );

          if (hasFilters && this.data_search && this.data_search.classFlight) {
            const classFlight = this.data_search.classFlight;

            // Give DOM more time to render the filter items
            setTimeout(() => {
              this.activateSeatClassFilter(classFlight);
            }, 800);
          }
        },
        deep: true,
        immediate: true
      }
   },
   components: {
      'VueSlider': VueSlider,
      'mainSidebar' : mainSidebar
   },
   mounted() {
      if (this.price) {
         this.min_price_props = this.price.min_price ;
         this.max_price_props = this.price.max_price;
         this.value_price = [this.price.min_price,this.price.max_price];

      }

      // گوش دادن به تغییرات فیلتر پیشنهاد ویژه از header
      this.$root.$on('offerFilterChanged', (isActive) => {
         this.updateOfferFilterStatus(isActive);
      });

   },

   beforeDestroy() {
      // حذف event listener برای جلوگیری از memory leak
      this.$root.$off('offerFilterChanged');
   }

}
</script>
