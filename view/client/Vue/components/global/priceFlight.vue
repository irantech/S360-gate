<template>
      <div>
        <div class="price-flight-flex" v-if="type == 'domestic' && ((flight.capacity > 0 || flight.source_id=='14'|| flight.source_id=='15') && price_adult > 0)">
          <div class='parent-price-discount-price-ticket'  v-if="flight.price.adult.has_discount === 'yes'">
            <div class="price-discount">
              <span class='price-decoration' v-if="checkCurrency">
                {{ price_adult | formatNumberDecimal}}
              </span>
              <span class='price-decoration'  v-else>
                {{ price_adult | formatNumber}}
              </span>
              <div class="discount">٪27</div>
            </div>
            <div class="price-ticket">
              <h2 v-if="checkCurrency">{{ price_adult_with_discount  | formatNumberDecimal}}</h2>
              <h2 v-else>{{ price_adult_with_discount  | formatNumber}}</h2>
              <span>{{title_currency }}</span>
            </div>
          </div>
          <div v-else>
            <div class="price-ticket">
              <h2 v-if="checkCurrency"> {{ price_adult | formatNumberDecimal}}</h2>
              <h2 v-else> {{ price_adult | formatNumber}}</h2>
              <span>{{title_currency }}</span>
            </div>
          </div>
          <h4>{{useXmltag('AirlinePrice')}}</h4>
          <button type="button" v-if="windowWidth < 576 " @click='openDetailModal()'>
            <span>{{useXmltag('Selectionflight')}}</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
          </button>
          <button type="button" v-else-if="flight.source_id=='special'"
                  :id="`btnReservationFlight_${flight.flight_id}`"
                  @click="sendInfoReservationFlightForeign(`${flight.flight_id}`)">
            <span>{{useXmltag('Selectionflight')}}</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
          </button>
          <button v-else type="button"  :id="`select${this.$store.state.typeTripFlight}`"
                  :class='{"skeleton":is_show_loader}'
                  :disabled='is_show_loader'
                  @click="changeTripFlight(flight.capacity)">
            <template v-if="dataSearch.MultiWay==='TwoWay'">
              <template v-if="this.$store.state.typeTripFlight === 'dept'">
                {{useXmltag('PickWentFlight')}}
              </template>
              <template v-else>
                {{useXmltag('PickBackFlight')}}
              </template>
            </template>
            <template v-else>
              {{useXmltag('Selectionflight')}}
            </template>

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
          </button>

          <input type="hidden" :value="dataSearch.adult" id="CountAdult" class="CountAdult">
          <input type="hidden" :value="dataSearch.child" id="CountChild" class="CountChild">
          <input type="hidden" :value="dataSearch.infant" id="CountInfant" class="CountInfant">
          <input type="hidden" value="" name="session_filght_Id" id="session_filght_Id">
          <input type="hidden" value="reservation" id="typeApplication" class="typeApplication" v-if="flight.source_id=='special'">
          <input type="hidden" value="privateCharter" id="PrivateCharter" class="PrivateCharter" v-if="flight.source_id=='special'">
          <input type="hidden" :value="flight.flight_id" id="IdPrivate" class="IdPrivate" v-if="flight.source_id=='special'">
          <input type="hidden" :value="flight.flight_id_return" id="flight_id_return" class="flight_id_return" v-if="flight.source_id=='special'">



          <a @click='openFlightDetail()'>
            <span>{{ openTitle }}</span>
            <svg v-if='show_detail' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" style="transform: rotate(180deg);"><path d="M362.7 203.9l-159.1 144c-6.125 5.469-15.31 5.469-21.44 0L21.29 203.9C14.73 197.1 14.2 187.9 20.1 181.3C26.38 174.4 36.5 174.5 42.73 180.1L192 314.5l149.3-134.4c6.594-5.877 16.69-5.361 22.62 1.188C369.8 187.9 369.3 197.1 362.7 203.9z"></path></svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M362.7 203.9l-159.1 144c-6.125 5.469-15.31 5.469-21.44 0L21.29 203.9C14.73 197.1 14.2 187.9 20.1 181.3C26.38 174.4 36.5 174.5 42.73 180.1L192 314.5l149.3-134.4c6.594-5.877 16.69-5.361 22.62 1.188C369.8 187.9 369.3 197.1 362.7 203.9z"/></svg>
          </a>
        </div>
        <div class=""
             v-else-if="type == 'international' && ((flight.capacity > 0 || flight.source_id=='14'|| flight.source_id=='15') && price_adult > 0)">
          <div  v-if="flight.price.adult.has_discount === 'yes'">
            <div class="price-ticket">
              <h2 v-if="checkCurrency">
                {{ price_adult | formatNumberDecimal}}
              </h2>
              <h2 v-else>
                {{ price_adult | formatNumber}}
              </h2>
            </div>
            <div class="price-ticket">
              <h2 v-if="checkCurrency">{{ price_adult_with_discount  | formatNumberDecimal}}</h2>
              <h2 v-else>{{ price_adult_with_discount  | formatNumber}}</h2>
              <span>{{title_currency }}</span>
            </div>
          </div>
          <div v-else>
            <div class="price-ticket">
              <h2 v-if="checkCurrency"> {{ price_adult | formatNumberDecimal}}</h2>
              <h2 v-else> {{ price_adult | formatNumber}}</h2>
              <span>{{title_currency }}</span>
            </div>
          </div>
          <h4>{{useXmltag('AirlinePrice')}}</h4>

          <button type="button" v-if="windowWidth < 576" @click='openDetailModal()'>
            <span>{{useXmltag('Selectionflight')}}</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
          </button>
          <button type="button" v-else-if="flight.source_id=='special'"
                  :id="`btnReservationFlight_${flight.flight_id}`"
                  @click="sendInfoReservationFlightForeign(`${flight.flight_id}`)">
            <span>{{useXmltag('Selectionflight')}}</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
          </button>
          <button v-else-if="flight.return_route !=''" type="button"
                  :id="`nextStep_${flight.flight_id.replace('#','')}`">
            {{useXmltag('Selectionflight')}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
          </button>
          <button v-else type="button"
                  :id="`nextStep_${flight.flight_id.replace('#','')}${flight.return_routes.flight_id_return.replace('#','')}`">
            {{useXmltag('Selectionflight')}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
          </button>

          <input type="hidden" value="" name="session_filght_Id" id="session_filght_Id">
          <span class="f-loader-check f-loader-check-change"
                :id="`loader_check_${flight.flight_id.replace('#','')}`"
                style="display:none"></span>

          <input type="hidden" value="" class="CurrencyCode">
          <input type="hidden" :value="flight.flight_id" class="FlightID">
          <input type="hidden" :value="flight.return_routes.return_flight_id" class="ReturnFlightID">
          <input type="hidden" :value="price_adult" class="AdtPrice">
          <input type="hidden" :value="flight.price.child.price" class="ChdPrice">
          <input type="hidden" :value="flight.price.infant.price" class="InfPrice">
          <input type="hidden" :value="flight.cabin_type" class="CabinType">
          <input type="hidden" :value="flight.airline" id="Airline_Code" class="Airline_Code">
          <input type="hidden" :value="flight.source_id" id="SourceId" class="SourceId">
          <input type="hidden" :value="flight.flight_type_li" id="FlightType" class="FlightType">
          <input type="hidden" :value="flight.unique_code" id="uniqueCode" class="uniqueCode">
          <input type="hidden" :value="flight.capacity" id="Capacity" class="priceWithoutDiscount">
          <input type="hidden" :value="dataSearch.adult" id="CountAdult" class="CountAdult">
          <input type="hidden" :value="dataSearch.child" id="CountChild" class="CountChild">
          <input type="hidden" :value="dataSearch.infant" id="CountInfant" class="CountInfant">
          <input type="hidden" value="dept" class="FlightDirection">
          <input type="hidden" value="reservation" id="typeApplication" class="typeApplication"
                 v-if="flight.source_id=='special'">
          <input type="hidden" value="privateCharter" id="PrivateCharter" class="PrivateCharter"
                 v-if="flight.source_id=='window.innerWidthspecial'">
          <input type="hidden" :value="each_price_flight.flight_id" id="IdPrivate" class="IdPrivate"
                 v-if="flight.source_id=='special'">
          <input type="hidden" :value="each_price_flight.flight_id_return" id="flight_id_return"
                 class="flight_id_return" v-if="flight.source_id=='special'">

          <a @click='openFlightDetail()'>
            <span>{{ openTitle }}</span>
            <svg v-if='show_detail' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" style="transform: rotate(180deg);"><path d="M362.7 203.9l-159.1 144c-6.125 5.469-15.31 5.469-21.44 0L21.29 203.9C14.73 197.1 14.2 187.9 20.1 181.3C26.38 174.4 36.5 174.5 42.73 180.1L192 314.5l149.3-134.4c6.594-5.877 16.69-5.361 22.62 1.188C369.8 187.9 369.3 197.1 362.7 203.9z"></path></svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M362.7 203.9l-159.1 144c-6.125 5.469-15.31 5.469-21.44 0L21.29 203.9C14.73 197.1 14.2 187.9 20.1 181.3C26.38 174.4 36.5 174.5 42.73 180.1L192 314.5l149.3-134.4c6.594-5.877 16.69-5.361 22.62 1.188C369.8 187.9 369.3 197.1 362.7 203.9z"/></svg>
          </a>
        </div>
        <div class="" v-else>
          <button type="button">
            <span>{{useXmltag('FullCapacity')}}</span>
          </button>
          <a @click='openFlightDetail()'>
            <span>{{ openTitle }}</span>
            <svg v-if='show_detail' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" style="transform: rotate(180deg);"><path d="M362.7 203.9l-159.1 144c-6.125 5.469-15.31 5.469-21.44 0L21.29 203.9C14.73 197.1 14.2 187.9 20.1 181.3C26.38 174.4 36.5 174.5 42.73 180.1L192 314.5l149.3-134.4c6.594-5.877 16.69-5.361 22.62 1.188C369.8 187.9 369.3 197.1 362.7 203.9z"></path></svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M362.7 203.9l-159.1 144c-6.125 5.469-15.31 5.469-21.44 0L21.29 203.9C14.73 197.1 14.2 187.9 20.1 181.3C26.38 174.4 36.5 174.5 42.73 180.1L192 314.5l149.3-134.4c6.594-5.877 16.69-5.361 22.62 1.188C369.8 187.9 369.3 197.1 362.7 203.9z"/></svg>
          </a>

        </div>
        <Modal v-model="detail_modal" v-if='detail_modal'
               :rtl=true wrapper-class="modal-wrapper">
          <responsive-detail @closeFilterModal='closeDetailModal()'
                             :flight='flight'
                             :type="type"/>
        </Modal>
      </div>
</template>

<script>
import ResponsiveDetail from '../global/modal/resDetail'
import VueModal from '@kouts/vue-modal';
import '@kouts/vue-modal/dist/vue-modal.css'
export default  {
  name : 'price-flight' ,
  props : ['flight' , 'show_detail' , 'type' ],
  components: {
    ResponsiveDetail,
    'Modal' : VueModal,
  },
  data() {
    return{
      check_currency_data: true,
      is_show_loader : false,
      flight_direction : 'dept' ,
      detail_modal : false,

    }
  },
  computed:  {
    windowWidth () {
      return window.innerWidth
    },
    openTitle() {
      if(this.show_detail) {
       return  useXmltag('closeDetailBox')
      }else{
        return useXmltag('FlightDetail')
      }
    },
    price_adult() {
      let info_price = this.$store.state.priceCurrency;
      console.log(info_price)
      let price = this.flight.price.adult.price;
      let price_with_out_currency = this.flight.price.adult.price_with_out_currency;
      if(Object.keys(info_price).length !==0)
      {
        if (Object.keys(info_price.data).length > 1) {
          if (info_price.data.CurrencyCode > 0) {
            this.check_currency_data = true;
            return (price_with_out_currency / info_price.data.EqAmount).toFixed(2);
          }
        } else if (Object.keys(info_price.data).length === 0) {
          this.check_currency_data = false;
          return price_with_out_currency;
        }
      }

      return price;
    },
    checkCurrency() {
      let info_price = this.$store.state.priceCurrency;
      if (this.check_currency_data) {
        return (Object.keys(info_price).length > 1 || (this.flight.currency_code > 0));
      }
      return this.check_currency_data;

    },
    price_adult_with_discount() {
      let info_price = this.$store.state.priceCurrency;
      let price = this.flight.price.adult.with_discount;
      let price_discount_with_out_currency = this.flight.price.adult.price_discount_with_out_currency;
      if(Object.keys(info_price).length !==0) {
        if (Object.keys(info_price.data).length > 1) {
          if (info_price.data.CurrencyCode > 0) {
            this.check_currency_data = true;
            return (price_discount_with_out_currency / info_price.data.EqAmount).toFixed(2);
          }
        } else if (Object.keys(info_price.data).length === 0) {
          this.check_currency_data = false;
          return price_discount_with_out_currency;
        }
      }
      return price;
    },
    title_currency() {
      let info_price = this.$store.state.priceCurrency;
      let type_currency = this.flight.price.adult.type_currency;
      if (Object.keys(info_price).length !==0) {
        if (Object.keys(info_price.data).length > 0) {
          if (info_price.data.CurrencyCode > 0) {
            return info_price.data.CurrencyTitleEn;
          }
        } else if (Object.keys(info_price.data).length === 0) {

          return useXmltag('Rial');
        }
      }
      return type_currency;
    },
    dataSearch() {
      return   this.$store.state.setDataSearch.dataSearch
    },
  },
  methods : {
    openDetailModal() {
      this.$store.commit('setMobileHeaderSearchBox',false)
      this.detail_modal = true
    },
    closeDetailModal() {
      this.$store.commit('setMobileHeaderSearchBox',true)
      this.detail_modal = false
    },
    openFlightDetail() {
      this.$emit('openFlightDetail')
    } ,
    changeTripFlight(capacity){

      this.is_show_loader = true;
      var _this = this ;
      let request_capacity = parseInt(_this.dataSearch.adult) + parseInt(_this.dataSearch.child)
      if(parseInt(capacity) >= request_capacity || (_this.flight.source_id =='14' && capacity < 1))
      {
        if(_this.dataSearch.MultiWay==='TwoWay') {
          if(_this.$store.state.typeTripFlight === 'dept') {
            console.log('T-dept');

            axios.post(amadeusPath + 'ajax',{
              className: 'newApiFlight',
              method: 'revalidateFlight',
              Flight : _this.flight.flight_id,
              UniqueCode : _this.flight.unique_code,
              SourceId : _this.flight.source_id,
              adt : _this.dataSearch.adult,
              chd : _this.dataSearch.child,
              inf : _this.dataSearch.infant,
              FlightDirection : _this.flight_direction,
            },{
              'Content-Type': 'application/json'
            }).then(function (response) {
              let id_selected =  _this.flight.flight_id ;
              console.log('id_selected' , id_selected)
              let id_btn = "select"+_this.$store.state.typeTripFlight ;
              console.log('id_btn ' , id_btn);
              const node = document.getElementById(id_selected).lastChild;
              console.log('id_selected' , node)
              console.log(response)
              const clone = node.cloneNode(true);
              document.getElementById("myList1").appendChild(clone);
              document.getElementById(id_btn).remove();
              setTimeout(function(){
                _this.is_show_loader = false;
                // document.getElementById('loader_check_'+id_selected).style.display = 'none';
                console.log('loader===>'+ _this.is_show_loader);
                _this.$store.commit('setTypeTripFlight','return');
                _this.$store.commit('setFlightUniqId',response.data.data.result_uniq_id);
              }, 1000);
            }).catch(function (error) {
              _this.is_show_loader = false;
              _this.$swal({
                icon: "error",
                toast: true,
                position: "bottom-end",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 4000,
                width:600,
                iconColor:"#FFFFFF",
                background:"#FF0000",
                title: `<span style="color:#FFFFFF">${error.response.data.data.result_message}</span>`,
              });
            });
          }
          else{
            console.log('T-Return');
            axios.post(amadeusPath + 'ajax',{
              className: 'newApiFlight',
              method: 'revalidateFlight',
              Flight : _this.flight.flight_id,
              UniqueCode : _this.flight.unique_code,
              SourceId : _this.flight.source_id,
              adt : _this.dataSearch.adult,
              chd : _this.dataSearch.child,
              inf : _this.dataSearch.infant,
              FlightDirection : _this.$store.state.typeTripFlight,
              uniq_id : _this.$store.state.flightUniqId
            },{
              'Content-Type': 'application/json'
            }).then(function (response) {
              if(response.data.data.result_status=='SuccessLogged') {
                _this.sendDataToPassengerDetail(response.data.data);
              }else{
                _this.sendDataToPassengerDetailWithoutLogin(response.data.data);
              }
              // _this.is_show_loader = false;
            }).catch(function (error) {
              console.log(error);
              _this.is_show_loader = false;
              _this.$swal({
                icon: "error",
                toast: true,
                position: "bottom-end",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 4000,
                width:600,
                iconColor:"#FFFFFF",
                background:"#2f2f2f",
                title: `<span style="color:#FFFFFF">${error.response.data.data.result_message}</span>`,
              });
            });
          }

        }else{

          axios.post(amadeusPath + 'ajax',{
            className: 'newApiFlight',
            method: 'revalidateFlight',
            Flight : _this.flight.flight_id,
            UniqueCode : _this.flight.unique_code,
            SourceId : _this.flight.source_id,
            adt : _this.dataSearch.adult,
            chd : _this.dataSearch.child,
            inf : _this.dataSearch.infant,
            FlightDirection : _this.flight_direction,
          },{
            'Content-Type': 'application/json'
          }).then(function (response) {
            console.log(response.data.data)
            if(response.data.data.result_status=='SuccessLogged') {
              _this.sendDataToPassengerDetail(response.data.data);
            }else{
              _this.sendDataToPassengerDetailWithoutLogin(response.data.data);
            }
            // _this.is_show_loader = false;
          }).catch(function (error) {
            _this.is_show_loader = false;
            _this.$swal({
              icon: "error",
              toast: true,
              position: "bottom-end",
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 4000,
              width:600,
              iconColor:"#FFFFFF",
              background:"#FF0000",
              title: `<span style="color:#FFFFFF">${error.response.data.data.result_message}</span>`,
            });
          });
        }
      }
      else{
        _this.is_show_loader = false;
        _this.$swal({
          icon: "error",
          toast: true,
          position: "bottom-end",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 4000,
          width:600,
          iconColor:"#FFFFFF",
          background:"#480808",
          title: `<span style="color:#FFFFFF">${useXmltag('lowCapacityPassenger')}</span>`,
        });
      }

    },
    sendDataToPassengerDetail(data){
      let form = document.createElement("form");
      form.setAttribute("method", "POST");
      form.setAttribute("action", amadeusPathByLang + "passengersDetailLocal");

      let hiddenField = document.createElement("input");
      hiddenField.setAttribute("name", "temporary");
      hiddenField.setAttribute("value", data.result_uniq_id);
      form.appendChild(hiddenField);

      let hiddenField2 = document.createElement("input");
      hiddenField2.setAttribute("name", "ZoneFlight");
      hiddenField2.setAttribute("value", "Local");
      form.appendChild(hiddenField);
      form.appendChild(hiddenField2);
      document.body.appendChild(form);
      form.submit();
      document.body.removeChild(form);
    },
    sendDataToPassengerDetailWithoutLogin(data){

      document.getElementById('session_filght_Id').value  = data.result_uniq_id;
      document.getElementById('ZoneFlight').value = 'Local';
      let show_popup = document.getElementById('isShowLoginPopup').value ;

      if(show_popup === '1'){
        setTimeout(function(){
          document.getElementsByClassName('cd-user-modal')[0].classList.add("is-visible");
        }, 1000);
      }else{
        this.sendDataToPassengerDetail(data)
      }


    }
  }
}
</script>