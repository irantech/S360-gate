<template>
    <div class="international-available-details">
        <div>
            <div class=" international-available-panel-min">
                <ul class="tabs">
                    <li data-tab="tab-1-0" class="tab-link current site-border-top-main-color ">
                        {{useXmltag('Informationflight')}}
                    </li>
                    <li data-tab="tab-2-0" class="tab-link site-border-top-main-color detailShow" @click="getFeeCancel(`${flight.flight_type_li}`,`${flight.airline}`,`${flight.cabin_type}`)">
                        {{useXmltag('Price')}}
                    </li>
                    <li data-tab="tab-3-0" class="tab-link site-border-top-main-color">
                        {{useXmltag('TermsandConditions')}}
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
                                        {{flight.airline_name}}
                                            <em>-</em>
                                 </span>
                                 <span class="flightnumber_s ">
                                        <i> {{useXmltag('FlightNumber')}} : </i>
                                        {{flight.flight_number}}
                                        <em>-</em>
                                 </span>
                                 <span class="seatClass_s">
                                        {{flight.seat_class}}
                                        <em>-</em>
                                 </span>
                                 <span class="capacity_s " v-if="flight.capacity > 0">
                                        <i>{{useXmltag('Capacity')}} : </i>
                                        {{flight.capacity}}
                                        <em>-</em>
                                 </span>
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
                <div id="tab-2-0" class="tab-content price-Box-Tab">
                    <div class="pop-up-h site-bg-main-color"><span>  {{ useXmltag('TicketDetailsBasedPriceID')}}</span>
                    </div>
                    <div class="price-Content site-border-main-color"><p id="AlertPanelHTC"></p>
                        <div class="tblprice">
                            <div>
                                <div class="tdpricelabel"> {{useXmltag('Adt')}} :</div>
                                <div class="tdprice">
                                    <i v-if="flight.price.adult.has_discount=='yes'">{{flight.price.adult.with_discount}}</i>
                                    <i v-else>{{flight.price.adult.price}}</i>
                                    {{flight.price.adult.type_currency}}
                                </div>
                                <div class="tdpricelabel"> {{useXmltag('Chd')}} :</div>
                                <div class="tdprice">
                                    <i v-if="flight.price.child.price > 0 ">{{flight.price.child.price}}</i>
                                    <i v-else>{{useXmltag('PreInvoiceStep')}}</i>
                                </div>
                                <div class="tdpricelabel"> {{useXmltag('Inf')}} :</div>
                                <div class="tdprice">
                                    <i v-if="flight.price.infant.price > 0 ">{{flight.price.infant.price}}</i>
                                    <i v-else>{{useXmltag('PreInvoiceStep')}}</i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <template v-if="flight.flight_type_li =='system'">

                        <template v-if="fee_cancel !='' ">
                            <div class="cancel-policy cancel_modal">
                                <div class="cancel-policy-head">
                                    <div class="cancel-policy-head-text">{{useXmltag('DetailMoneyCancel')}}</div>
                                    <div class="cancel-policy-class">


                                        <span>{{useXmltag('Classflight')}} :</span>
                                        <span> {{useXmltag('TypeClass')}} </span></div>
                                </div>
                                <div class="cancel-policy-inner">
                                    <div class="cancel-policy-item cancel_modal">
                                        <span class="cancel-policy-item-text site-main-text-color">{{useXmltag('Fromthetimeticketissueuntilnoondaysbeforeflight')}}</span>
                                        <span class="cancel-policy-item-pnalty site-bg-main-color-admin site-bg-main-color" v-if="isNaN(`'${fee_cancel.ThreeDaysBefore}'`)">
                                        {{ fee_cancel.ThreeDaysBefore}}
                                    </span>
                                        <span class="cancel-policy-item-pnalty site-bg-main-color-admin site-bg-main-color" v-else>
                                         {{ fee_cancel.ThreeDaysBefore}} {{useXmltag('PenaltyPercent')}}
                                    </span>
                                    </div>

                                    <div class="cancel-policy-item cancel_modal">
                                    <span class="cancel-policy-item-text site-main-text-color">
                                        {{useXmltag('Fromnoondaysbeforeflightnoondaybeforeflight')}}
                                        </span>

                                        <span class="cancel-policy-item-pnalty site-bg-main-color-admin site-bg-main-color" v-if="isNaN(`'${fee_cancel.OneDaysBefore}'`)">
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

                                        <span class="cancel-policy-item-pnalty site-bg-main-color-admin site-bg-main-color" v-if="isNaN(`'${fee_cancel.ThreeHoursBefore}'`)">
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
                                        <span class="cancel-policy-item-pnalty site-bg-main-color-admin site-bg-main-color site-bg-main-color" v-if="isNaN(`'${fee_cancel.ThirtyMinutesAgo}'`)">
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
                                        <span class="cancel-policy-item-pnalty site-bg-main-color-admin site-bg-main-color" v-if="isNaN(`'${fee_cancel.OfThirtyMinutesAgoToNext}'`)">
                                        {{ fee_cancel.ThirtyMinutesAgo}}
                                    </span>
                                        <span class="cancel-policy-item-pnalty site-bg-main-color-admin site-bg-main-color" v-else>
                                         {{ fee_cancel.ThirtyMinutesAgo}} {{useXmltag('OfThirtyMinutesAgoToNext')}}
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <div class="cancel-policy cancel_modal cancel-policy-charter1">
                                <div class="cancel-policy-head">

                                    <div class="cancel-policy-head-text">
                                        {{ useXmltag('DetailMoneyCancel')}}
                                    </div>
                                </div>
                                <span class="site-bg-main-color-admin">
                                {{ useXmltag('Contactbackupunitinformationaboutamountconsignmentfines')}}</span>
                            </div>
                        </template>
                    </template>

                    <div class="cancel-policy cancel-policy-charter" v-if="flight.flight_type_li !='system'">
                        <span class="site-bg-main-color">
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
    export default {
        name: "detailFlight",
        props:['flight','data_search'],
        data(){
          return {
              fee_cancel : '',
          }
        },
        methods:{
            getFeeCancel(type_flight,airline_iata,cabin_type){
                if(type_flight==='system'){
                    let _this = this
                    axios.post(amadeusPath + 'ajax',
                      {
                          className: 'newApiFlight',
                          method: 'getFeeCancel',
                          airline_iata,
                          cabin_type ,
                          is_json: true,
                      },
                      {
                          'Content-Type': 'application/json',
                      }).then(function(response) {
                        let data_fee =  response.data.data;

                        console.log(data_fee)
                        if(data_fee !==""){
                            console.log(data_fee)

                            _this.fee_cancel  = data_fee ;
                        }else{
                            _this.fee_cancel = '' ;
                        }




                    }).catch(function(error) {
                        console.log(error)
                    })
                }

                return true ;
            }
        }
    }
</script>

<style scoped>

</style>