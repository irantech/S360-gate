<template>
    <div>
        <div class="ribbon" v-if="each_flight.source_id=='special'">
            <span>{{ useXmltag('specialoffer')}}</span>
        </div>

        <div class="international-available-item">
            <div class="international-available-info">
                <div class="international-available-item-right-Cell my-slideup">
                    <div class="d-none">
                        <div class="site-bg-main-color" v-if="each_flight.seat_class_en == 'business'">
                            <span class="iranM ">{{ each_flight.seat_class }}</span>
                        </div>
                    </div>
                        <template v-for='(flight,index_flight) in each_flight.output_routes_detail'>
                            <airline-out-put-flight :each_airline_flight="flight" :key_each_airline_flight="index_flight" :data_search="data_search"></airline-out-put-flight>
                            <info-multi-out-put-flight :each_airline_flight="flight" :key_each_airline_flight="index_flight"></info-multi-out-put-flight>

                        </template>


                </div>

                <price-flight :each_price_flight="each_flight" :data_search="data_search"></price-flight>

                <div class="international-available-details">
                    <div>
                        <div class=" international-available-panel-min">
                            <ul class="tabs">
                                <li class="tab-link  site-border-top-main-color detailShow current" :data-tab="`tab-1-${key_flight}`" :counterTab="`${key_flight}`">
                                    {{ useXmltag('Informationflight')}}
                                </li>
                                <li class="tab-link site-border-top-main-color "  :data-tab="`tab-2-${key_flight}`">
                                    {{ useXmltag('TermsandConditions')}}
                                </li>
<!--                                  <li class="tab-link site-border-top-main-color"  :data-tab="`tab-3-${key_flight}`" @click="getAirRules()">-->
<!--                                      {{ useXmltag('Ticketrules')}}-->
<!--                                  </li>-->
                            </ul>

                            <div :id="`tab-1-${key_flight}`" class="tab-content current">
                                <detail-depart-flight :dept_detail_flight="each_flight.output_routes_detail" :data_search="data_search" @modalDetail="modalDetailEach"></detail-depart-flight>

                            </div>
                            <div :id="`tab-2-${key_flight}`" class="tab-content">
                                <ul class="ruleText">
                                    <li>
                                        {{ useXmltag('Presencepassengerobligatoryhalfhoursbeforetimeflightairport')}}
                                    </li>

                                    <li>
                                        {{ useXmltag('Havingvalididentificationdocumentboardingaircraft')}}
                                    </li>

                                    <li>
                                        {{ useXmltag('Delayhurryflightnotificationmadeviamobilenumber')}}
                                    </li>

                                    <li>
                                        {{ useXmltag('Theticketsissuedpassengersnon')}}
                                    </li>

                                    <li>
                                        {{ useXmltag('Youreceivehappysendemailsendusemail')}}
                                    </li>

                                    <li>
                                        {{ useXmltag('Probabilitychangingcharterflightssystemcasesflightswillreturncharterercase')}}
                                    </li>

                                    <li>
                                        {{ useXmltag('ServiceslicensestoragesmaintenanceServicescustomshoistingtransportcargohandling')}}

                                    </li>

                                    <li>
                                        {{ useXmltag('PassengerwishesmakebetweenflightOtherwiseresponsibilitypassengercancelticket')}}
                                    </li>

                                    <li>
                                        {{ useXmltag('Shoulddifferentcancellationhourscancellationflightconsignmentfine')}}

                                    </li>

                                    <li>
                                        {{ useXmltag('UnderpossiblenationalsAfghanistanBangladeshPakistanfutureresponsibilitiesuser')}}

                                    </li>

                                    <li>
                                        {{ useXmltag('ResponsibilityvisacontrolpassengerresponsibilityContactyoufurtherinformation')}}
                                    </li>

                                    <li>
                                        {{ useXmltag('Youhaveproblems')}}

                                    </li>

                                    <li>
                                        {{ useXmltag('RuleFlightAirPortIstanbul')}}
                                    </li>
                                </ul>

                            </div>
                               <div :id="`tab-3-${key_flight}`" class="tab-content w-100">

                                       <img :src="`${getUrlWithoutLang()}/view/client/assets/images/load21.gif`"
                                            width="120px"
                                            alt="" class="loaderDetail"
                                            style="width: 50px;position: relative;"
                                            :id="`loaderDetail${each_flight.flight_id}`" v-if="is_show_loader">

                                   <rules-flight :data_ruls="data_rules" v-if='is_show_rules'></rules-flight>



                               </div>
                        </div>
                    </div>
                    <span class="international-available-detail-btn more_1 ">
                 <div class="text_div_morei site-main-text-color iranM " v-if="each_flight.point_club > 0 ">
                     {{ useXmltag('Yourpurchasepoints')}} {{ each_flight.point_club}} {{ useXmltag('Point')}}
                 </div>
                 <div class="my-more-info slideDownAirDescription">
                     {{ useXmltag('Moredetail')}}
                     <i class="fa fa-angle-down"></i>
                 </div>
             </span>
                    <span class="international-available-detail-btn slideUpAirDescription displayiN">
                   <i class="fa fa-angle-up"></i>
                 </span>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import airlineOutPutFlight from "./airlineOutPutFlight";
    import infoMultiOutPutFlight from "./infoMultiOutPutFlight";
    import priceFlight from "./priceFlight";
    import detailDepartFlight from "./detailDepartFlight";
    import rulesFlight from './rulesFlight';

    export default {
        name: "eachFlight",
        props: ['each_flight', 'key_flight','data_search'],
        components: {
            'airlineOutPutFlight': airlineOutPutFlight,
            'infoMultiOutPutFlight': infoMultiOutPutFlight,
            'priceFlight': priceFlight,
            'detailDepartFlight': detailDepartFlight,
            'rulesFlight':rulesFlight
        },
        data(){
            return{
                data_rules : {},
                is_show_rules : false,
                is_show_loader : true
            }
        },
        methods:{
            modalDetailEach(value){
                this.$emit('modalShowTicketDetail', value);
            },
            getAirRules(){
                // document.getElementById(this.each_flight.flight_id).classList.add('skeleton');
                let _this = this;
                axios.post(amadeusPath + 'ajax',
                  {
                      className: 'newApiFlight',
                      method: 'getInfoRulesFlight',
                      request_number: _this.each_flight.unique_code,
                      agency_id:_this.each_flight.agency_id,
                      fare_source_code :_this.each_flight.flight_id
                  },
                  {
                      'Content-Type': 'application/json'
                  }).then(function (response) {
                    console.log(response.data.data);
                    _this.data_rules = response.data.data ;
                    _this.is_show_rules = true;
                    _this.is_show_loader = false;
                    // document.getElementById(_this.dept_detail_flight[0].flight_id).classList.remove('skeleton');
                }).catch(function (error) {
                });

            }
        }
    }
</script>

<style scoped>

</style>