<template>
    <div class="lowest animated fadeIn" id="lowest" v-if="show_lowest">
        <div class="price-data-title">
            <span> {{ translateXmlByParams('MessageLowestPrice',{'origin' : dataSearch.name_departure , 'destination' : dataSearch.name_arrival}) }}</span>
        </div>
        <span class="f-loader f-loader-check flightFifteen" id="flightFifteen" v-if="loader_lowest" >
            <div class="stage filter-contrast">
                <div class="dot-shuttle"></div>
            </div>
        </span>
            <input type="hidden" value="" id="checkOpenFifteenFlight">

      <!--  <carousel :dots="false" :nav="false" :autoHeight="true" :autoWith="true">
            <div id="showDataFlight">
                <template v-for="lowest_price in lowestFlightPrice ">
                    <div :class="`col_t_price ${lowest_price.class_min_price}` ">
                        <div>
                            <a :href="`${lowest_price.url}`">
                                <div class="lowest-date">
                                    <span class="ld-d">{{ lowest_price.date_for_show}}</span>
                                    <span class="ld-dn">{{ lowest_price.name_date}}</span>
                                </div>
                                <span class="s_price">{{ lowest_price.price_final}}</span>
                            </a>
                        </div>
                    </div>
                </template>
            </div>
        </carousel>-->
        <div id="showDataFlight">
          <carousel :rtl="true" :perPage="6" :navigationEnabled="true" :paginationEnabled="false">
              <template v-for="lowest_price in lowestFlightPrice ">
                <slide>
                    <div :class="`col_t_price ${lowest_price.class_min_price}` ">
                        <div>
                            <a :href="`${lowest_price.url}`">
                                <div class="lowest-date">
                                    <span class="ld-d">{{ lowest_price.date_for_show}}</span>
                                    <span class="ld-dn">{{ lowest_price.name_date}}</span>
                                </div>
                                <span class="s_price" v-if="lowest_price.price_final !=''">{{ lowest_price.price_final}}</span>
                                <span class="s_price" v-else>{{useXmltag('FullCapacity')}}</span>
                            </a>
                        </div>
                    </div>
                </slide>
              </template>
          </carousel>
        </div>

    </div>
</template>

<script>
    import { Carousel, Slide } from 'vue-carousel';
    export default {
        name: "lowestPrice",
        props:['data_search' , 'show_lowest' , 'loader_lowest'],
        components:{
            Carousel,
            Slide
        },
        data(){
            return{
                loader_flag : false ,
                dataSearch : {},

            }
        },
        methods: {
        },
        computed: {
            lowestFlightPrice() {
               return this.$store.state.lowestFlightPrice;
            },
        },
        watch: {
            data_search() {
                if (this.data_search) {
                    this.dataSearch = this.data_search.dataSearch
                }
            },

        }
    }
</script>

<style scoped>

</style>