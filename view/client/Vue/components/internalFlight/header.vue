<template>
    <div>
       <div id="sortFlightInternal" class="sorting2">
        <div class="sorting-inner date-change iranL prev">
            <a class="prev-date" v-if="data_search.MultiWay !='TwoWay'"
               :href="`${amadeusPathByLang()}search-flight/1/${data_search.origin}-${data_search.destination}/${dataSearch.prev}/Y/${data_search.adult}-${data_search.child}-${data_search.infant}`">
                <i class="zmdi zmdi-chevron-right iconDay"></i>
                <span>{{ useXmltag('Previousday')}}</span>
            </a>
            <a class="prev-date" v-else href="#" v-on:click.prevent.stop="">
                <i class="zmdi zmdi-chevron-right iconDay"></i>
                <span>{{ useXmltag('Previousday')}}</span>
            </a>
        </div>
        <div :class="['sorting-inner price_sort_color', priceSort ? 'sorting-active-color-main' : '']" @click="priceSortFlight()"
             id="price_sort">

            <span v-if="priceSort" v-html="icon_svg_header_1"></span>
           <span v-if="!priceSort" v-html="icon_svg_header_2_desc"></span>
            <span class="text-price-sort iranL d-none d-md-block">{{ useXmltag('Baseprice')}}</span>
           <span class="text-price-sort iranL d-md-none">{{ useXmltag('Price')}}</span>
        </div>
        <div :class="['sorting-inner' , timeSort ? 'sorting-active-color-main' : '']" @click="timeSortFlight()" id="time_sort">
            <span v-html="icon_svg_header_2" :class=" [timeSort ? 'icon-best-start-time' : 'icon-best-start-time-s' ]"></span>
            <span class="text-price-sort iranL d-none d-md-block">{{ useXmltag('BaseStartTime')}}</span>
           <span class="text-price-sort iranL d-md-none">{{ useXmltag('Time')}}</span>
        </div>
          <div :class="['text-price-sort iranL' , showOfferFlights ? 'sorting-active-color-main' : '']" @click="toggleOfferFlight()" id="duplicate_flight">
             <span v-html="icon_svg_header_6"></span>
             <span class="mr-1 text-offer-btn d-none d-md-block">{{ useXmltag('specialoffer')}}</span>
             <span class="mr-1 text-offer-btn d-md-none">{{ useXmltag('specialoffer2')}}</span>

          </div>
        <div class="sorting-inner date-change iranL next">
            <a class="next-date" v-if="data_search.MultiWay !='TwoWay'"
               :href="`${amadeusPathByLang()}search-flight/1/${data_search.origin}-${data_search.destination}/${dataSearch.next}/Y/${data_search.adult}-${data_search.child}-${data_search.infant}`">
                <span>{{ useXmltag('Nextday')}}</span>
                <i class="zmdi zmdi-chevron-left iconDay"></i>
            </a>
            <a class="next-date" v-else href="#" v-on:click.prevent.stop="">
                <span>{{ useXmltag('Nextday')}}</span>
                <i class="zmdi zmdi-chevron-left iconDay"></i>
            </a>
        </div>
<!--        <div class="dateprice filter_search_mobile " @click="show_lowest = !show_lowest">-->
<!--            <div class=" site-border-main-color lowerSortSelectVue" id="lowerSortSelect" >-->
<!--                           <span class="dataprice-icon">-->
<!--                              <span v-html="icon_svg_header_4"></span>-->
<!--                           </span>-->
<!--                <span class="text-dateprice site-main-text-color">{{useXmltag('CalenderPrice')}}</span>-->
<!--                <input type="hidden" value="desc" name="currentTimeSort" id="currentTimeSort">-->
<!--            </div>-->

<!--        </div>-->
        <div class="filter_search_mobile_res">
            <span v-html="icon_svg_header_5"></span>
            <span class="site-main-text-color">{{useXmltag('Filter')}} </span>
        </div>
    </div>

        <advertisement :advertiseList='dataSearch.Advertises'></advertisement>
       <span class="d-none">
          ddddddddddddddddddddddddddddd
       </span>
<!--        <lowest-price :data_search="dataSearch" :show_lowest="show_lowest" :loader_lowest="loader_lowest"></lowest-price>-->
    </div>
</template>

<script>

    import lowestPrice from "./lowestPrice";
    import advertisement from "./advertisement";
    export default {
       name: "topHeader",
       props: ['dataSearch', 'flights'],
       data() {
          return {
             icon_svg_header_1: `<svg class="svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free v5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M304 416h-64a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h64a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm-128-64h-48V48a16 16 0 0 0-16-16H80a16 16 0 0 0-16 16v304H16c-14.19 0-21.37 17.24-11.29 27.31l80 96a16 16 0 0 0 22.62 0l80-96C197.35 369.26 190.22 352 176 352zm256-192H240a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h192a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm-64 128H240a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h128a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zM496 32H240a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h256a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"/></svg>`,
             icon_svg_header_2_desc: `<svg class="svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free v5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M240 96h64a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16h-64a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16zm0 128h128a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16H240a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16zm256 192H240a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h256a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm-256-64h192a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16H240a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16zM16 160h48v304a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V160h48c14.21 0 21.39-17.24 11.31-27.31l-80-96a16 16 0 0 0-22.62 0l-80 96C-5.35 142.74 1.78 160 16 160z"/></svg>`,
             icon_svg_header_2: `<span class="svg"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M0 24C0 10.7 10.7 0 24 0H360c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V67c0 40.3-16 79-44.5 107.5L225.9 256l81.5 81.5C336 366 352 404.7 352 445v19h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H24c-13.3 0-24-10.7-24-24s10.7-24 24-24h8V445c0-40.3 16-79 44.5-107.5L158.1 256 76.5 174.5C48 146 32 107.3 32 67V48H24C10.7 48 0 37.3 0 24zM273.5 140.5C293 121 304 94.6 304 67V48H80V67c0 27.6 11 54 30.5 73.5L192 222.1l81.5-81.5z"/></svg></span>`,
             icon_svg_header_3: `<svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  version="1.1"  x="0" y="0" viewBox="0 0 512 512"  xml:space="preserve" class="site-bg-svg-color"><g><g xmlns="http://www.w3.org/2000/svg"><path d="m420.404 0h-328.808c-50.506 0-91.596 41.09-91.596 91.596v328.809c0 50.505 41.09 91.595 91.596 91.595h328.809c50.505 0 91.595-41.09 91.595-91.596v-328.808c0-50.506-41.09-91.596-91.596-91.596zm61.596 420.404c0 33.964-27.632 61.596-61.596 61.596h-328.808c-33.964 0-61.596-27.632-61.596-61.596v-328.808c0-33.964 27.632-61.596 61.596-61.596h328.809c33.963 0 61.595 27.632 61.595 61.596z"  data-original="#000000" style="" class=""/><path d="m432.733 112.467h-228.461c-6.281-18.655-23.926-32.133-44.672-32.133s-38.391 13.478-44.672 32.133h-35.661c-8.284 0-15 6.716-15 15s6.716 15 15 15h35.662c6.281 18.655 23.926 32.133 44.672 32.133s38.391-13.478 44.672-32.133h228.461c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-273.133 32.133c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.686 17.133 17.133-7.686 17.133-17.133 17.133z"  data-original="#000000" style="" class=""/><path d="m432.733 241h-35.662c-6.281-18.655-23.927-32.133-44.672-32.133s-38.39 13.478-44.671 32.133h-228.461c-8.284 0-15 6.716-15 15s6.716 15 15 15h228.461c6.281 18.655 23.927 32.133 44.672 32.133s38.391-13.478 44.672-32.133h35.662c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-80.333 32.133c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.686 17.133 17.133-7.686 17.133-17.133 17.133z"  data-original="#000000" style="" class=""/><path d="m432.733 369.533h-164.194c-6.281-18.655-23.926-32.133-44.672-32.133s-38.391 13.478-44.672 32.133h-99.928c-8.284 0-15 6.716-15 15s6.716 15 15 15h99.928c6.281 18.655 23.926 32.133 44.672 32.133s38.391-13.478 44.672-32.133h164.195c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-208.866 32.134c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.685 17.133 17.132-7.686 17.134-17.133 17.134z"  data-original="#000000" style="" class=""/></g></g></svg>`,
             icon_svg_header_4: `<svg class="site-bg-svg-color" height="512pt" viewBox="0 0 512 512" width="512pt" xmlns="http://www.w3.org/2000/svg"><path d="m452 40h-24v-40h-40v40h-264v-40h-40v40h-24c-33.085938 0-60 26.914062-60 60v352c0 33.085938 26.914062 60 60 60h392c33.085938 0 60-26.914062 60-60v-352c0-33.085938-26.914062-60-60-60zm-392 40h24v40h40v-40h264v40h40v-40h24c11.027344 0 20 8.972656 20 20v48h-432v-48c0-11.027344 8.972656-20 20-20zm392 392h-392c-11.027344 0-20-8.972656-20-20v-264h432v264c0 11.027344-8.972656 20-20 20zm-136-42h120v-120h-120zm40-80h40v40h-40zm0 0"></path></svg>`,
             icon_svg_header_5: `<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0" y="0" viewBox="0 0 512 512" xml:space="preserve" class="site-bg-svg-color"><g><g xmlns="http://www.w3.org/2000/svg"><path d="m420.404 0h-328.808c-50.506 0-91.596 41.09-91.596 91.596v328.809c0 50.505 41.09 91.595 91.596 91.595h328.809c50.505 0 91.595-41.09 91.595-91.596v-328.808c0-50.506-41.09-91.596-91.596-91.596zm61.596 420.404c0 33.964-27.632 61.596-61.596 61.596h-328.808c-33.964 0-61.596-27.632-61.596-61.596v-328.808c0-33.964 27.632-61.596 61.596-61.596h328.809c33.963 0 61.595 27.632 61.595 61.596z" data-original="#000000" style="" class=""></path><path d="m432.733 112.467h-228.461c-6.281-18.655-23.926-32.133-44.672-32.133s-38.391 13.478-44.672 32.133h-35.661c-8.284 0-15 6.716-15 15s6.716 15 15 15h35.662c6.281 18.655 23.926 32.133 44.672 32.133s38.391-13.478 44.672-32.133h228.461c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-273.133 32.133c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.686 17.133 17.133-7.686 17.133-17.133 17.133z" data-original="#000000" style="" class=""></path><path d="m432.733 241h-35.662c-6.281-18.655-23.927-32.133-44.672-32.133s-38.39 13.478-44.671 32.133h-228.461c-8.284 0-15 6.716-15 15s6.716 15 15 15h228.461c6.281 18.655 23.927 32.133 44.672 32.133s38.391-13.478 44.672-32.133h35.662c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-80.333 32.133c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.686 17.133 17.133-7.686 17.133-17.133 17.133z" data-original="#000000" style="" class=""></path><path d="m432.733 369.533h-164.194c-6.281-18.655-23.926-32.133-44.672-32.133s-38.391 13.478-44.672 32.133h-99.928c-8.284 0-15 6.716-15 15s6.716 15 15 15h99.928c6.281 18.655 23.926 32.133 44.672 32.133s38.391-13.478 44.672-32.133h164.195c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-208.866 32.134c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.685 17.133 17.132-7.686 17.134-17.133 17.134z" data-original="#000000" style="" class=""></path></g></g></svg>`,
             icon_svg_header_6: `<span class="svg svg-medal"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M4.1 38.2L106.4 191.5c11.2-11.6 23.7-21.9 37.3-30.6L68.4 48h64.5l54.9 91.5c15.8-5.5 32.4-9.1 49.6-10.6l-6.1-10.1L169.3 15.5C163.5 5.9 153.1 0 141.9 0H24.6C11 0 0 11 0 24.6c0 4.8 1.4 9.6 4.1 13.6zm276.6 80.5l-6.1 10.1c17.2 1.5 33.8 5.2 49.6 10.6L379.2 48h64.5L368.4 160.9c13.6 8.7 26.1 19 37.3 30.6L507.9 38.2c2.7-4 4.1-8.8 4.1-13.6C512 11 501 0 487.4 0H370.1c-11.2 0-21.7 5.9-27.4 15.5L280.8 118.7zM256 208a128 128 0 1 1 0 256 128 128 0 1 1 0-256zm0 304a176 176 0 1 0 0-352 176 176 0 1 0 0 352zm7.2-257.5c-2.9-5.9-11.4-5.9-14.3 0l-19.2 38.9c-1.2 2.4-3.4 4-6 4.4L180.7 304c-6.6 1-9.2 9-4.4 13.6l31 30.2c1.9 1.8 2.7 4.5 2.3 7.1l-7.3 42.7c-1.1 6.5 5.7 11.5 11.6 8.4L252.3 386c2.3-1.2 5.1-1.2 7.4 0l38.4 20.2c5.9 3.1 12.7-1.9 11.6-8.4L302.4 355c-.4-2.6 .4-5.2 2.3-7.1l31-30.2c4.7-4.6 2.1-12.7-4.4-13.6l-42.9-6.2c-2.6-.4-4.9-2-6-4.4l-19.2-38.9z"/></svg></span>`,



             data_search: [],
             show_lowest: false,
             loader_lowest: true,
             has_lowest_set: true,
             showOfferFlights:false,
             originalOfferFlightsDept:[],
             originalOfferFlightsReturn:[],
             duplicateFlight: false,
             priceSort:true,
             timeSort:false

          }
       },

       components: {
          // 'lowest-price':lowestPrice ,
          'advertisement': advertisement,
       },
       methods: {
          timeSortFlight() {
             if (this.showOfferFlights === true) {
                this.toggleOfferFlight();
             }

             this.priceSort = false;
             this.timeSort = !this.timeSort; // Toggle between true/false
             this.showOfferFlights = false;
             this.$emit("sortByTime", this.timeSort)
          },
          priceSortFlight() {
             if (this.showOfferFlights === true) {
                this.toggleOfferFlight();
             }

             this.priceSort = !this.priceSort;
             this.timeSort = false;
             this.showOfferFlights = false;


             this.$emit("sortByPrice",this.priceSort)
          },


          getLowestPrice(){
                this.has_lowest_set == true
                let data_store_lowest = this.$store.state.lowestFlightPrice ;
                if(data_store_lowest.length == undefined){
                    this.$store.dispatch('getLowestPrice', {origin: this.dataSearch.dataSearch.origin, destination: this.dataSearch.dataSearch.destination , passengers : this.dataSearch.dataSearch.adult+'-'+this.dataSearch.dataSearch.child+'-'+this.dataSearch.dataSearch.infant}).then(response => {
                        this.show_lowest = true ;
                        this.loader_lowest = false ;
                    });
                }
            },
          toggleOfferFlight() {
             this.priceSort = false;
             this.timeSort = false;

             const dept = this.$store.state.flights.dept || [];
             const ret = this.$store.state.flights.return || [];

             if (!Array.isArray(this.originalOfferFlightsDept) || this.originalOfferFlightsDept.length === 0) {
                this.originalOfferFlightsDept = [...dept];
             }

             if (!Array.isArray(this.originalOfferFlightsReturn) || this.originalOfferFlightsReturn.length === 0) {
                this.originalOfferFlightsReturn = [...ret];
             }

             this.showOfferFlights = !this.showOfferFlights;

             if (this.showOfferFlights) {
                const filteredDept = this.originalOfferFlightsDept.filter(f => f.is_private === 'private');
                const filteredReturn = this.originalOfferFlightsReturn.filter(f => f.is_private === 'private');

                this.$store.commit("setDeptFlights", filteredDept);
                this.$store.commit("setReturnFlights", filteredReturn);

             } else {
                this.$store.commit("setDeptFlights", this.originalOfferFlightsDept);
                this.$store.commit("setReturnFlights", this.originalOfferFlightsReturn);
             }

             this.$emit("updateShowOfferFlights", this.showOfferFlights);
          }


       },

       watch: {
            dataSearch() {
                let _this = this;
                if (_this.dataSearch) {

                    _this.data_search = _this.dataSearch.dataSearch;
                    // if(!_this.has_lowest_set){
                    //   // this.getLowestPrice();
                    // }
                }
            },

        } ,
    }
</script>
<style scoped>

</style>