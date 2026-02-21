<template>
  <div>
    <div class="international-available-airlines-detail-tittle">
                <span class="iranB  lh25 displayb txtRight">
                    <i class="fa fa-circle site-main-text-color " v-show='data_search.dataSearch.MultiWay !="multi_destination"'></i>
                    {{ useXmltag('Wentflight')}}
                </span>
        <template v-for="detail_flight in dept_detail_flight">
            <div class=" international-available-airlines-detail  site-border-right-main-color">
                <div class="international-available-airlines-logo-detail foreign" :class="[detail_flight.airline.airline_code]">
                    <div class="logo-airline-ico-foreign"></div>
                </div>

                <div class="international-available-airlines-info-detail side-logo-detail">
                    <span class="airline_s">
                       <i>{{ useXmltag('Airline')}}</i>
                      {{ detail_flight.airline.airline_name}}({{detail_flight.airline.airline_code}}) <em>|</em>
                    </span>
                  <span class="airline_s" v-show="detail_flight.airline.airline_code_operator != null ">
                       <i>{{ useXmltag('AirlineOperator') }}</i>
                      {{detail_flight.airline.airline_code_operator }} <em>|</em>
                    </span>
                  <span class="flightnumber_s">
                     <i> {{ useXmltag('Numflight')}}: </i>
                      {{ detail_flight.flight_number}} <em>|</em>
                    </span>
<!--                  <span class="flightnumber_s">-->

<!--                      {{ detail_flight.departure_time}} <em>-</em>-->
<!--                    </span>-->
                    <span class="seatClass_s">
                      {{ detail_flight.seat_class}}
                    </span>
<!--                    <span class="capacity_s " v-if="detail_flight.capacity > 0">-->
<!--                        <em>-</em>{{ detail_flight.capacity}} {{ useXmltag('People')}}-->
<!--                    </span>-->
                </div>
            </div>
            <div class="international-available-airlines-detail site-border-right-main-color">
                <div class="airlines-detail-box-foreign origin-detail-box">
                    <span class="open  displayb  mr-4 ml-4">
                        {{ detail_flight.departure.departure_city}} ({{detail_flight.departure.departure_code}})
                    </span>
                    <span class="open  displayb mr-4 ml-4"> {{ detail_flight.departure.departure_airport}}</span>
                    <span class="openB  displayb mr-4 ml-4"> {{ detail_flight.departure_time}}</span>
                </div>

                <div class="airlines-detail-box-foreign destination-detail-box">
                    <span class="open  displayb mr-4 ml-4">{{ detail_flight.arrival.arrival_city}}({{ detail_flight.arrival.arrival_code}})</span>
                    <span class="open  displayb mr-4 ml-4">{{ detail_flight.arrival.arrival_airport}}</span>
                    <span class="openB  displayb mr-4 ml-4" v-if="detail_flight.arrival_date !=null"> {{ detail_flight.arrival_time}} </span>
<!--                  <span class="openB  displayb mr-4 ml-4" v-if="detail_flight.arrival_date !=null">{{ useXmltag('ArrivingTime')}} :({{ detail_flight.arrival_date_abbreviation}})  {{ detail_flight.arrival_time}}- {{ detail_flight.arrival_date}} </span>-->
                </div>

                <div class="airlines-detail-box details-detail-box ">
                                    <span class="w-100 cursor-pointer text-nowrap" v-if=" detail_flight.source_id =='14'"    @click='getBaggage()'>
                                            <i class="capacity_s">{{ detail_flight.baggage.baggage_statement}} </i>
                                            <i class="iranNum btn-baggage-search" :id='`${detail_flight.flight_id}`'>{{ useXmltag('BaggageRule')}}</i>
                                    </span>
                                    <span class='w-100 text-nowrap' v-else>
                                       {{ useXmltag('Permissibleamount')}} : <i class="iranNum">
                                      <span class="capacity_s w-100 ml-1 mr-0">{{ detail_flight.baggage.baggage_statement}} </span></i>
                                    </span>

                    <span class="w-100 text-nowrap" v-if="detail_flight.cabin_type !=''">  {{ useXmltag('Classrate')}} :<i class="openL ml-1 mr-0">{{ detail_flight.cabin_type}} </i> </span>

                </div>
            </div>
           <div class="international-available-airlines-detail airlines-stops-time "
                v-if="detail_flight.is_transit && data_search.dataSearch.MultiWay !='multi_destination'">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill airlines-stops-time-svg" viewBox="0 0 16 16">
                 <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
              </svg>
              <span class="iranB  lh25 displayib txtRight">
                    <span class=" iranb  lh18 displayib">
                        {{ useXmltag('Stopat')}}
                    </span>
                    <span class="open  displayib">
                       {{ detail_flight.arrival.arrival_city}}({{ detail_flight.arrival.arrival_airport}})
                    </span>
                </span>
              <span>بمدت</span>
              <span class="open  lh25 displayib fltl">
                 {{ formatTimeHM(detail_flight.transit) }}
                </span>

           </div>
        </template>
    </div>
    <Modal v-model="showModal"  :rtl=true wrapper-class="modal-wrapper">
      <body-modal :data_detail="data_modal"></body-modal>
    </Modal>
  </div>


</template>

<script>
      import bodyModal from './bodyModal';
      import VueModal from '@kouts/vue-modal';
      import '@kouts/vue-modal/dist/vue-modal.css'
    export default {
        name: "detailDepartFlight",
        props: ['dept_detail_flight','data_search'],
        components:{
        'Modal' : VueModal,
        'body-modal': bodyModal
      },
        data(){
            return{
              data_baggage : [],
              data_modal : [] ,
              showModal: false
            }
        },
       methods:{
        getBaggage(){
          document.getElementById(this.dept_detail_flight[0].flight_id).classList.add('skeleton');
          let _this = this;
          axios.post(amadeusPath + 'ajax',
            {
              className: 'newApiFlight',
              method: 'getInfoBaggage',
              request_number: _this.dept_detail_flight[0].request_number,
              flight_id :_this.dept_detail_flight[0].flight_id,
              source_id :_this.dept_detail_flight[0].source_id
            },
            {
              'Content-Type': 'application/json'
            }).then(function (response) {
            console.log(response.data.data);
            _this.data_baggage = response.data.data ;
            _this.callModal(_this.data_baggage)
            document.getElementById(_this.dept_detail_flight[0].flight_id).classList.remove('skeleton');
          }).catch(function (error) {
          });


        },
         callModal(value){
           this.data_modal = value ;
           this.showModal = true
         },

          formatTimeHM(time) {
             if (!time) return '';

             const [h, m] = time.split(':').map(Number);

             if (h === 0) {
                return `${m} دقیقه`;
             }

             return `${h} ساعت و ${m} دقیقه`;
          }
        }


    }
</script>

<style scoped>

</style>