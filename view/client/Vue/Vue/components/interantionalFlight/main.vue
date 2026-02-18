<template>

    <div class="row">

        <sidebar :dataSearch="setDataSearch" :price="price" :interrupt="interrupt" :timeFilter="timeFilter"
                 :typeFlightFilter="typeFlightFilter" :seatClassFilter="seatClassFilter"
                 :minPriceAirline="minPriceAirline" :countFlights="count_flights" @filterFlights="filterFlightsFinally"
        @filterPriceFlights="filterPrice" @modalShowTicketDetail=""></sidebar>
        <show-ticket :flights="filteredFlights" :dataSearch="setDataSearch"
                     :has_request_offline_access="has_request_offline_access" :full_capacity='full_capacity'
                     @sortTimeOfShowTicket="timeSortFlight"
        @sortPriceOfShowTicket="priceSortFlight"></show-ticket>

        <form method="post" id="formAjax" action="">
            <input type="hidden" :value="setDataSearch.MultiWay" name="MultiWayTicket" id="MultiWayTicket"/>
            <input id="temporary" name="temporary" type="hidden" value="">
            <input id="ZoneFlight" name="ZoneFlight" type="hidden" value="">
            <input type="hidden" value='' name="SourceM5_ID" id="SourceM5_ID">
            <input type="hidden" value='' name="flight_id_private" id="flight_id_private">
        </form>
    </div>

<!--   <div class="requestNumber">-->
<!--      {{requestNumber}}-->
<!--      {{requestNumberNoData}}-->
<!--   </div>-->

</template>
<script>
    import sidebar from './sidebar.vue';
    import showTicket from "./showTicket";


    export default {
        name: "internationalFlight",
        components: {
            'sidebar': sidebar,
            'show-ticket': showTicket,

        },
        data() {
            return {
                time_filter: ['all_time'],
                stop_filter: ['all_stop'],
                type_flight_filter: ['all_type_flight'],
                airline_filter: ['all_airline'],
                seat_class_filter: ['all_seat_class'],
                price_filter_flight:[],
                time_sort_filter :'asc',
                price_sort_filter :'desc',
                showModal: false,
                data_modal : [] ,
                has_request_offline_access : false ,
                full_capacity : ''

            }
        },
        methods: {
            async checkRequestOfflineAccess(){
            let _this = this
            await axios
              .post(
                amadeusPath + "ajax",
                {
                  className: "requestOffline",
                  method: "checkAccess" ,
                  service : "international-flight"
                },
                {
                  "Content-Type": "application/json",
                }
              )
              .then(function (response) {
                if(response.data.result.status == 'success') {
                  _this.has_request_offline_access = response.data.result.data
                  _this.full_capacity = response.data.result.fullCapacity
                }
              })
          },
            filterPrice(value){
                this.price_filter_flight = value;
            },
            timeSortFlight(){
                if(document.querySelector("#price_sort").classList.contains("sorting-active-color-main")){
                    document.getElementsByClassName('price_sort_color')[0].classList.remove("sorting-active-color-main");
                    document.getElementsByClassName('time_sort_color')[0].classList.add("sorting-active-color-main");
                }

                if(this.time_sort_filter ==='desc'){
                    this.time_sort_filter = 'asc';
                    if(this.flights !==""){
                        this.flights.sort(function (a, b) {
                            return a.departure_time.localeCompare(b.departure_time);
                        });
                    }

                }else{
                    this.time_sort_filter = 'desc';
                    if(this.flights !=="") {
                        this.flights.sort(function (a, b) {
                            return b.departure_time.localeCompare(a.departure_time);
                        });
                    }
                }

            },
           priceSortFlight() {
              // تغییر رنگ دکمه‌ها
              if (document.querySelector("#time_sort") && document.querySelector("#time_sort").classList.contains("sorting-active-color-main")) {
                 let timeSortElement = document.querySelector('.time_sort_color');
                 let priceSortElement = document.querySelector('.price_sort_color');
                 if (timeSortElement) timeSortElement.classList.remove("sorting-active-color-main");
                 if (priceSortElement) priceSortElement.classList.add("sorting-active-color-main");
              }
              const asc = this.price_sort_filter === 'desc';
              this.price_sort_filter = asc ? 'asc' : 'desc';

              // Use store mutation to sort flights
              this.$store.commit('priceSortInternationalFlight', asc ? 'desc' : 'asc');
           },
            filterFlightsFinally(value, type) {
                if(type !== 'price_slider')
                {
                    if (value.indexOf('all') === -1) {
                        // This is a specific filter (not 'all')
                        let allElements = document.getElementsByClassName('all_' + type);
                        let valueElements = document.getElementsByClassName(value);

                        // Remove checked from ALL "all_*" elements
                        if (allElements.length > 0) {
                            for (let j = 0; j < allElements.length; j++) {
                                allElements[j].classList.remove("checked");
                            }
                        }

                        // Add checked to specific value
                        if (valueElements.length > 0) {
                            // For seat_class, we need to find the specific element with 'seat_class' class
                            if (type === 'seat_class') {
                                for (let i = 0; i < valueElements.length; i++) {
                                    if (valueElements[i].classList.contains('seat_class')) {
                                        valueElements[i].classList.add("checked");
                                        break;
                                    }
                                }
                            } else {
                                valueElements[0].classList.add("checked");
                            }
                        }
                    }
                    else{
                        // This is 'all' filter - remove all specific filters and activate 'all'
                        let class_for_remove = document.getElementsByClassName(type);
                        for (let i = 0; i < class_for_remove.length ; i++) {
                            class_for_remove[i].classList.remove("checked");
                        }
                        let allTypeElements = document.getElementsByClassName('all_' + type);
                        if (allTypeElements.length > 0) {
                            allTypeElements[0].classList.add("checked");
                        }
                    }
                }

                switch (type) {
                    case 'stop':
                        if (this.stop_filter.indexOf(value) !== -1) {
                            if (value.indexOf('all') === -1) {
                                document.getElementsByClassName(value)[0].classList.remove("checked");
                            }
                            this.stop_filter = this.deleteByValue(this.stop_filter, value);
                        } else {
                            document.getElementsByClassName(value)[0].classList.add("checked");
                            this.stop_filter.push(value);
                        }
                        if(this.stop_filter.length === 1 && this.stop_filter.indexOf('all') === -1){
                            document.getElementsByClassName('all_stop')[0].classList.add("checked");
                        }
                        break;
                    case 'type_flight':
                        if (this.type_flight_filter.indexOf(value) !== -1) {
                            if (value.indexOf('all') === -1) {
                                document.getElementsByClassName(value)[0].classList.remove("checked");
                            }
                            this.type_flight_filter = this.deleteByValue(this.type_flight_filter, value);
                        } else {
                            document.getElementsByClassName(value)[0].classList.add("checked");
                            this.type_flight_filter.push(value);
                        }
                        if(this.type_flight_filter.length === 1 && this.type_flight_filter.indexOf('all') === -1){
                            document.getElementsByClassName('all_type_flight')[0].classList.add("checked");
                        }
                        break;
                    case 'seat_class':
                        // Check if this is 'all_seat_class' (reset to show all)
                        if (value.indexOf('all') !== -1) {
                            this.seat_class_filter = ['all_seat_class'];
                        } else {
                            // This is a specific class (economy, business, premium_economy)
                            if (this.seat_class_filter.indexOf(value) !== -1) {
                                // Value already exists - this is a toggle off
                                if (value.indexOf('all') === -1) {
                                    let elements = document.getElementsByClassName(value);
                                    for (let i = 0; i < elements.length; i++) {
                                        if (elements[i].classList.contains('seat_class')) {
                                            elements[i].classList.remove("checked");
                                            break;
                                        }
                                    }
                                }
                                this.seat_class_filter = this.deleteByValue(this.seat_class_filter, value);

                                // If filter becomes empty, reset to all
                                if (this.seat_class_filter.length === 0) {
                                    this.seat_class_filter = ['all_seat_class'];
                                    let allElements = document.getElementsByClassName('all_seat_class');
                                    if (allElements.length > 0) {
                                        allElements[0].classList.add("checked");
                                    }
                                }
                            } else {
                                // Value doesn't exist - add it and remove 'all_seat_class'
                                // Remove 'all_seat_class' if it exists
                                if (this.seat_class_filter.indexOf('all_seat_class') !== -1) {
                                    this.seat_class_filter = this.deleteByValue(this.seat_class_filter, 'all_seat_class');
                                }

                                let elements = document.getElementsByClassName(value);
                                for (let i = 0; i < elements.length; i++) {
                                    if (elements[i].classList.contains('seat_class')) {
                                        elements[i].classList.add("checked");
                                        break;
                                    }
                                }
                                this.seat_class_filter.push(value);
                            }
                        }

                        break;
                    case 'airline':
                        if (this.airline_filter.indexOf(value) !== -1) {
                            if (value.indexOf('all') === -1) {
                                document.getElementsByClassName(value)[0].classList.remove("checked");
                            }
                            this.airline_filter = this.deleteByValue(this.airline_filter, value);
                        } else {
                            document.getElementsByClassName(value)[0].classList.add("checked");
                            this.airline_filter.push(value);
                        }
                        if(this.airline_filter.length === 1 && this.airline_filter.indexOf('all') === -1){
                            document.getElementsByClassName('all_airline')[0].classList.add("checked");
                        }
                        break;
                    case 'time':
                        if (this.time_filter.indexOf(value) !== -1) {
                            if (value.indexOf('all') === -1) {
                                document.getElementsByClassName(value)[0].classList.remove("checked");
                            }
                            this.time_filter = this.deleteByValue(this.time_filter, value);
                        } else {
                            document.getElementsByClassName(value)[0].classList.add("checked");
                            this.time_filter.push(value);
                        }
                        if(this.time_filter.length === 1 && this.time_filter.indexOf('all') === -1){
                            document.getElementsByClassName('all_time')[0].classList.add("checked");
                        }
                        break;
                        /*case 'price_slider':
                            console.log(value);
                            break;*/

                }
            },
            deleteByValue(items,val) {
                var items_temp = [];
                return items.filter(function (obj) {;
                    if(val.indexOf('all') !== -1){
                        if (obj === val) {
                            return  items_temp.push(obj);
                        }
                    }else{
                        if (obj !== val) {
                            return items_temp.push(obj);
                        }
                    }

                });
            },
            inArray(needle, haystack) {
                let length = haystack.length;
                for (let i = 0; i < length; i++) {
                    if (haystack[i] == needle) return true;
                }
                return false;
            }

        },
        created: function () {
            this.checkRequestOfflineAccess()
            let url_send = location.pathname.substring(0);
            let url_finally ='';
            let url_send_split = url_send.split('/')

            if(url_send_split.length <= 6 && url_send_split[4] !== undefined){
                if(url_send_split[5] !== undefined){
                    url_finally = `/gds/fa/international/1/${url_send_split[5]}/${dateNow('-')}/Y/1-0-0`;

                    window.history.pushState({path: url_send}, "", url_finally);

                    url_send = url_finally ;
                }


            }else{
                if(typeof query_param_get.mroute != 'undefined') {
                    url_send = query_param_get;
                }
            }


            this.$store.dispatch('getDataSearch', {url:url_send}).then(response => {
                // Set initial seat class filter based on classFlight from URL
                let classFlight = this.setDataSearch && this.setDataSearch.dataSearch ? this.setDataSearch.dataSearch.classFlight : null;

                if(classFlight && classFlight !== 'all') {
                    // User explicitly selected a specific class (economy, business, or premium_economy)
                    this.seat_class_filter = [classFlight];

                    // Mark the selected class as checked in UI with a delay to ensure DOM is ready
                    setTimeout(() => {
                        // Remove checked from ALL instances of all_seat_class
                        let classElements = document.getElementsByClassName('all_seat_class');
                        if(classElements.length > 0) {
                            for (let i = 0; i < classElements.length; i++) {
                                classElements[i].classList.remove("checked");
                            }
                        }

                        // Find element by class name (e.g., 'economy', 'business', 'premium_economy')
                        let selectedElements = document.getElementsByClassName(classFlight);

                        if(selectedElements.length > 0) {
                            // Find the specific seat_class element
                            for (let i = 0; i < selectedElements.length; i++) {
                                if (selectedElements[i].classList.contains('seat_class')) {
                                    selectedElements[i].classList.add("checked");
                                    break;
                                }
                            }
                        }
                    }, 1500);
                } else {
                    // classFlight is null/undefined or 'all' → show all classes
                    // seat_class_filter stays as ['all_seat_class'] (default)
                }

                this.$store.dispatch('getFlight', {url: url_send,method:'flightInternational'}).then(response=>{
                    this.price_filter_flight=[this.price.min_price,this.price.max_price]
                    // Apply default sorting by price (ascending) after data is loaded
                    this.$nextTick(() => {
                        setTimeout(() => {
                            this.priceSortFlight();
                        }, 100);
                    });
                })
            });

           this.$store.dispatch('isCounter').then(response=>{
           });
           this.$store.dispatch('isSafar360').then(response=>{
           });
        },
        computed: {
          count_flights(){
            return this.$store.state.count_flights ;
          },
            flights() {
                return this.$store.state.flights;
            }
            ,
            timeFilter() {
                return this.$store.state.timeFilter;
            }
            ,
            interrupt() {
                return this.$store.state.interrupt;
            }
            ,
            typeFlightFilter() {
                return this.$store.state.typeFlightFilter;
            }
            ,
            seatClassFilter() {
                return this.$store.state.seatClassFilter;
            }
            ,
            minPriceAirline() {
                return this.$store.state.minPriceAirline;
            }
            ,
            price() {
                return this.$store.state.price;
            },
           // requestNumber() {
           //    return this.$store.state.requestNumber
           // },
           // requestNumberNoData() {
           //    return this.$store.state.requestNumberNoData
           // },
            setDataSearch() {
                return this.$store.state.setDataSearch
            }
            ,
            filteredFlights() {
                if(this.flights !=null)
                {
                    const filtered = this.flights.filter(flight => {
                            return (this.time_filter.length == 1 && this.time_filter[0] == 'all_time') ? flight : this.time_filter.includes(flight.time_flight_name)
                        }
                    ).filter(flight => {
                            return (this.stop_filter.length == 1 && this.stop_filter[0] == 'all_stop') ? flight : this.stop_filter.includes(flight.count_interrupt)
                        }
                    ).filter(flight => {
                            return (this.airline_filter.length == 1 && this.airline_filter[0] == 'all_airline') ? flight : this.airline_filter.includes(flight.airline)
                        }
                    ).filter(flight => {
                            const showAll = this.seat_class_filter.length == 1 && this.seat_class_filter[0] == 'all_seat_class';
                            const matchesFilter = this.seat_class_filter.includes(flight.seat_class_en);
                            return showAll ? flight : matchesFilter;
                        }
                    ).filter(flight => {
                            return (this.type_flight_filter.length == 1 && this.type_flight_filter[0] == 'all_type_flight') ? flight : this.type_flight_filter.includes(flight.flight_type_li)
                        }
                    ).filter(flight => {
                            return flight.price.adult.price >= this.price_filter_flight[0]  && flight.price.adult.price <= this.price_filter_flight[1];
                        }
                    );

                    return filtered;
                }
                return [];

            }

        },
      watch:{
        filteredFlights(){
          let sort = [];
          let sort_zero = [];

          let flights = this.filteredFlights ;
          flights.forEach(function(arraySort, keySort) {
            if ((Math.round(arraySort.price.adult.price) > 0) || ['15','14'].includes(arraySort.source_id)) {
              sort.push(arraySort);
            } else {
              sort_zero.push(arraySort);
            }
          });
          this.$store.commit('getCount', sort.length);
        }
      }
    }
</script>
