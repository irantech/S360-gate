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
            <span class="text-price-sort iranL">{{ useXmltag('Baseprice')}}</span>
        </div>
        <div :class="['sorting-inner time_sort_color', timeSort ? 'sorting-active-color-main' : '']" @click="timeSortFlight()" id="time_sort">
            <span v-html="icon_svg_header_2"></span>
            <span class="text-price-sort iranL">{{ useXmltag('BaseStartTime')}}</span>

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
        <div class="dateprice filter_search_mobile ">
            <div class=" site-border-main-color lowerSortSelectVue" id="lowerSortSelect" @click="show_lowest = !show_lowest">
                           <span class="dataprice-icon">
                              <span v-html="icon_svg_header_4"></span>
                           </span>
                <span class="text-dateprice site-main-text-color">{{useXmltag('CalenderPrice')}}</span>
                <input type="hidden" value="desc" name="currentTimeSort" id="currentTimeSort">
            </div>

        </div>
        <div class="filter_search_mobile_res">
            <span v-html="icon_svg_header_5"></span>
            <span class="site-main-text-color">{{useXmltag('Filter')}} </span>
        </div>
    </div>

        <advertisement :advertiseList='dataSearch.Advertises'></advertisement>
        <lowest-price :data_search="dataSearch" :show_lowest="show_lowest" :loader_lowest="loader_lowest"></lowest-price>
    </div>
</template>

<script>

    import lowestPrice from "./lowestPrice";
    import advertisement from "./advertisement";
    export default {
        name: "topHeader",
        props: ['dataSearch'],
        data() {
            return {
                icon_svg_header_1: `<span class="svg"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free v5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M304 416h-64a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h64a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm-128-64h-48V48a16 16 0 0 0-16-16H80a16 16 0 0 0-16 16v304H16c-14.19 0-21.37 17.24-11.29 27.31l80 96a16 16 0 0 0 22.62 0l80-96C197.35 369.26 190.22 352 176 352zm256-192H240a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h192a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm-64 128H240a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h128a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zM496 32H240a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h256a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"/></svg></span>`,
                icon_svg_header_2_desc: `<span class="svg"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free v5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M240 96h64a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16h-64a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16zm0 128h128a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16H240a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16zm256 192H240a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h256a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm-256-64h192a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16H240a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16zM16 160h48v304a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V160h48c14.21 0 21.39-17.24 11.31-27.31l-80-96a16 16 0 0 0-22.62 0l-80 96C-5.35 142.74 1.78 160 16 160z"/></svg></span>`,
                icon_svg_header_2: `<span class="svg"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M0 24C0 10.7 10.7 0 24 0H360c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V67c0 40.3-16 79-44.5 107.5L225.9 256l81.5 81.5C336 366 352 404.7 352 445v19h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H24c-13.3 0-24-10.7-24-24s10.7-24 24-24h8V445c0-40.3 16-79 44.5-107.5L158.1 256 76.5 174.5C48 146 32 107.3 32 67V48H24C10.7 48 0 37.3 0 24zM273.5 140.5C293 121 304 94.6 304 67V48H80V67c0 27.6 11 54 30.5 73.5L192 222.1l81.5-81.5z"/></svg></span>`,
                icon_svg_header_3: `<svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  version="1.1"  x="0" y="0" viewBox="0 0 512 512"  xml:space="preserve" class="site-bg-svg-color"><g><g xmlns="http://www.w3.org/2000/svg"><path d="m420.404 0h-328.808c-50.506 0-91.596 41.09-91.596 91.596v328.809c0 50.505 41.09 91.595 91.596 91.595h328.809c50.505 0 91.595-41.09 91.595-91.596v-328.808c0-50.506-41.09-91.596-91.596-91.596zm61.596 420.404c0 33.964-27.632 61.596-61.596 61.596h-328.808c-33.964 0-61.596-27.632-61.596-61.596v-328.808c0-33.964 27.632-61.596 61.596-61.596h328.809c33.963 0 61.595 27.632 61.595 61.596z"  data-original="#000000" style="" class=""/><path d="m432.733 112.467h-228.461c-6.281-18.655-23.926-32.133-44.672-32.133s-38.391 13.478-44.672 32.133h-35.661c-8.284 0-15 6.716-15 15s6.716 15 15 15h35.662c6.281 18.655 23.926 32.133 44.672 32.133s38.391-13.478 44.672-32.133h228.461c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-273.133 32.133c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.686 17.133 17.133-7.686 17.133-17.133 17.133z"  data-original="#000000" style="" class=""/><path d="m432.733 241h-35.662c-6.281-18.655-23.927-32.133-44.672-32.133s-38.39 13.478-44.671 32.133h-228.461c-8.284 0-15 6.716-15 15s6.716 15 15 15h228.461c6.281 18.655 23.927 32.133 44.672 32.133s38.391-13.478 44.672-32.133h35.662c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-80.333 32.133c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.686 17.133 17.133-7.686 17.133-17.133 17.133z"  data-original="#000000" style="" class=""/><path d="m432.733 369.533h-164.194c-6.281-18.655-23.926-32.133-44.672-32.133s-38.391 13.478-44.672 32.133h-99.928c-8.284 0-15 6.716-15 15s6.716 15 15 15h99.928c6.281 18.655 23.926 32.133 44.672 32.133s38.391-13.478 44.672-32.133h164.195c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-208.866 32.134c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.685 17.133 17.132-7.686 17.134-17.133 17.134z"  data-original="#000000" style="" class=""/></g></g></svg>`,
                icon_svg_header_4: `<svg class="site-bg-svg-color" height="512pt" viewBox="0 0 512 512" width="512pt" xmlns="http://www.w3.org/2000/svg"><path d="m452 40h-24v-40h-40v40h-264v-40h-40v40h-24c-33.085938 0-60 26.914062-60 60v352c0 33.085938 26.914062 60 60 60h392c33.085938 0 60-26.914062 60-60v-352c0-33.085938-26.914062-60-60-60zm-392 40h24v40h40v-40h264v40h40v-40h24c11.027344 0 20 8.972656 20 20v48h-432v-48c0-11.027344 8.972656-20 20-20zm392 392h-392c-11.027344 0-20-8.972656-20-20v-264h432v264c0 11.027344-8.972656 20-20 20zm-136-42h120v-120h-120zm40-80h40v40h-40zm0 0"></path></svg>`,
                icon_svg_header_5: `<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0" y="0" viewBox="0 0 512 512" xml:space="preserve" class="site-bg-svg-color"><g><g xmlns="http://www.w3.org/2000/svg"><path d="m420.404 0h-328.808c-50.506 0-91.596 41.09-91.596 91.596v328.809c0 50.505 41.09 91.595 91.596 91.595h328.809c50.505 0 91.595-41.09 91.595-91.596v-328.808c0-50.506-41.09-91.596-91.596-91.596zm61.596 420.404c0 33.964-27.632 61.596-61.596 61.596h-328.808c-33.964 0-61.596-27.632-61.596-61.596v-328.808c0-33.964 27.632-61.596 61.596-61.596h328.809c33.963 0 61.595 27.632 61.595 61.596z" data-original="#000000" style="" class=""></path><path d="m432.733 112.467h-228.461c-6.281-18.655-23.926-32.133-44.672-32.133s-38.391 13.478-44.672 32.133h-35.661c-8.284 0-15 6.716-15 15s6.716 15 15 15h35.662c6.281 18.655 23.926 32.133 44.672 32.133s38.391-13.478 44.672-32.133h228.461c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-273.133 32.133c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.686 17.133 17.133-7.686 17.133-17.133 17.133z" data-original="#000000" style="" class=""></path><path d="m432.733 241h-35.662c-6.281-18.655-23.927-32.133-44.672-32.133s-38.39 13.478-44.671 32.133h-228.461c-8.284 0-15 6.716-15 15s6.716 15 15 15h228.461c6.281 18.655 23.927 32.133 44.672 32.133s38.391-13.478 44.672-32.133h35.662c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-80.333 32.133c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.686 17.133 17.133-7.686 17.133-17.133 17.133z" data-original="#000000" style="" class=""></path><path d="m432.733 369.533h-164.194c-6.281-18.655-23.926-32.133-44.672-32.133s-38.391 13.478-44.672 32.133h-99.928c-8.284 0-15 6.716-15 15s6.716 15 15 15h99.928c6.281 18.655 23.926 32.133 44.672 32.133s38.391-13.478 44.672-32.133h164.195c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-208.866 32.134c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.685 17.133 17.132-7.686 17.134-17.133 17.134z" data-original="#000000" style="" class=""></path></g></g></svg>`,
                data_search: [],
                show_lowest : true,
                loader_lowest : true ,
                has_lowest_set : false,
                timeSort: false,
                priceSort: false
            }
        },
        components:{
            'lowest-price':lowestPrice ,
            'advertisement':advertisement ,
        },
        methods: {
            timeSortFlight() {
                this.timeSort = !this.timeSort;
                this.$emit('sortByTime')
            },
            priceSortFlight() {
                this.priceSort = !this.priceSort;
                this.$emit('sortByPrice')
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
            }
        },
        watch: {
            dataSearch() {
                let _this = this;
                if (_this.dataSearch) {

                    _this.data_search = _this.dataSearch.dataSearch;
                    if(!_this.has_lowest_set){
                      this.getLowestPrice();
                    }
                }
            }
        } ,
    }
</script>
<style scoped>

</style>