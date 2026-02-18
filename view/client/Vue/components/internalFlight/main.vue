<template>


<div class="d-flex flex-wrap">


    <sidebar :dataSearch="setDataSearch" :price="price"  :timeFilter="timeFilter"
             :typeFlightFilter="typeFlightFilter" :seatClassFilter="seatClassFilter"
             :minPriceAirline="minPriceAirline" :countFlights="filteredFlights.length"
             @filterFlights="filterFlightsFinally"
             @filterPriceFlights="filterPrice"></sidebar>
    <show-ticket :flights="filteredFlights" :twoWayFlight='filteredTwoWayFlights' :dataSearch="setDataSearch" @sortTimeOfShowTicket="timeSortFlight"
                 :has_request_offline_access='has_request_offline_access' :full_capacity='full_capacity'
                 @sortPriceOfShowTicket="priceSortFlight" ></show-ticket>
  <input type="hidden" value='' name="flight_id_private" id="flight_id_private">
</div>
<!--   <div class="requestNumber">-->
<!--   {{requestNumber}}-->
<!--   {{requestNumberNoData}}-->
<!--   </div>-->
</template>

<script>
    import sidebar from "./sidebar";
    import showTicket from "./showTicket";
    export default {
        name: "internalFlight",
        components: {
            'sidebar': sidebar,
            'show-ticket': showTicket
        },
        data() {
            return {
                time_filter: ['all_time'],
                stop_filter: ['all_stop'],
                type_flight_filter: ['all_type_flight'],
                airline_filter: ['all_airline'],
                seat_class_filter: ['all_seat_class'],
                price_filter_flight:[0,0],
                time_sort_filter :'asc',
                price_sort_filter :'desc',
                trip_flight : 'dept',
                check_min_max_price: true ,
                has_request_offline_access : false ,
                full_capacity : '' ,
                twoWayFlight : [],
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
                    service : "internal-flight"
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


            if(parseInt(value[0]) != parseInt(this.price.min_price) || parseInt(value[1])!= parseInt(this.price.max_price)){
                this.check_min_max_price = false;
            }else{
                this.check_min_max_price = true;
            }
                this.price_filter_flight = value;
            },
            timeSortFlight(){
                // Update UI elements to show time sort is active
                if(document.querySelector("#price_sort") && document.querySelector("#price_sort").classList.contains("sorting-active-color-main")){
                    let priceSortElements = document.getElementsByClassName('price_sort_color');
                    let timeSortElements = document.getElementsByClassName('time_sort_color');
                    if (priceSortElements.length > 0) priceSortElements[0].classList.remove("sorting-active-color-main");
                    if (timeSortElements.length > 0) timeSortElements[0].classList.add("sorting-active-color-main");
                }

                // Ensure flights data exists before sorting
                if (!this.flights || this.flights.length === 0) {
                    return;
                }

                // Toggle sort direction and apply sort
                if(this.time_sort_filter ==='desc'){
                    this.time_sort_filter = 'asc';
                    this.flights.sort(function (a, b) {
                        return a.departure_time.localeCompare(b.departure_time);
                    });
                }else{
                    this.time_sort_filter = 'desc';
                    this.flights.sort(function (a, b) {
                        return b.departure_time.localeCompare(a.departure_time);
                    });
                }
            },
            priceSortFlight(){
               // Update UI elements to show price sort is active
               if (document.querySelector("#time_sort") && document.querySelector("#time_sort").classList.contains("sorting-active-color-main")) {
                  let timeSortElements = document.getElementsByClassName('time_sort_color');
                  let priceSortElements = document.getElementsByClassName('price_sort_color');
                  if (timeSortElements.length > 0) timeSortElements[0].classList.remove("sorting-active-color-main");
                  if (priceSortElements.length > 0) priceSortElements[0].classList.add("sorting-active-color-main");
               }

               // Toggle sort direction
               const asc = this.price_sort_filter === 'desc';
               this.price_sort_filter = asc ? 'asc' : 'desc';

               // Ensure flights data exists before sorting
               if (!this.flights || this.flights.length === 0) {
                  return;
               }

               // Use store mutation to sort flights
               this.$store.commit('priceSortFlight', asc ? 'desc' : 'asc');
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
                    }else{
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
                var length = haystack.length;
                for (var i = 0; i < length; i++) {
                    if (haystack[i] == needle) return true;
                }
                return false;
            },
            dateNow(mode){
                let dateNow = new Date().toLocaleDateString('fa-IR').replace(/([۰-۹])/g, token => String.fromCharCode(token.charCodeAt(0) - 1728));
                let dateNowSplit = [];
                let year = '';
                let month = '';
                let day = '';

                dateNowSplit = dateNow.split('/');

                year = dateNowSplit[0];
                month = (parseInt(dateNowSplit[1]) <= 9) ? '0' + dateNowSplit[1] : dateNowSplit[1];
                day = (parseInt(dateNowSplit[2]) <= 9) ? '0' + dateNowSplit[2] : dateNowSplit[2];
                return year + mode + month + mode + day
            }

        },
        created: function () {
            this.checkRequestOfflineAccess();
            let url_send = location.pathname.substring(0);
            let url_finally ='';
            let url_send_split = url_send.split('/')
            if(url_send_split.length <= 6 ){
                if(url_send_split[5] !== undefined){
                     url_finally = `/gds/fa/search-flight/1/${url_send_split[5]}/${dateNow('-')}/Y/1-0-0/${url_send_split[9]}`;

                     window.history.pushState({path: url_send}, "", url_finally);

                    url_send = url_finally ;
                }else{
                    console.log(location.pathname)
                }
            }
            this.$store.dispatch('getDataSearch', {url: url_send}).then(response => {
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
                }
                // If classFlight is null/undefined or 'all', seat_class_filter stays as ['all_seat_class'] (default)

                this.$store.dispatch('getFlight', {url: url_send,method: 'flightInternal'}).then(response=>{
                        this.price_filter_flight=[this.price.min_price,this.price.max_price]
                        // Apply default sorting by price (ascending) after data is loaded
                        // Use multiple $nextTick to ensure DOM and data are fully updated
                        this.$nextTick(() => {
                            this.$nextTick(() => {
                                // Check if flights data is available before sorting
                                if (this.flights && this.flights.length > 0) {
                                    this.priceSortFlight();
                                }
                            });
                        });
                });
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
            if(this.$store.state.setDataSearch.MultiWay ==='TwoWay'){
                 if(this.$store.state.typeTripFlight === 'dept'){
                     this.twoWayFlight = this.$store.state.flights.twoWay

                     this.$store.commit('setTypeTripFlight','dept');
                     return this.$store.state.flights.dept;
                 }
                 else {
                     this.twoWayFlight = []
                     this.$store.commit('setTypeTripFlight','return');
                     this.price_filter_flight = [this.price.min_price,this.price.max_price]
                     return this.$store.state.flights.return;
                 }
             }else{
                 this.$store.commit('setTypeTripFlight','dept');
                 return this.$store.state.flights.dept;
             }

          },
            timeFilter() {
                return this.$store.state.timeFilter;
            },
            typeFlightFilter() {
                return this.$store.state.typeFlightFilter;
            },
            seatClassFilter() {
                const storeFilter = this.$store.state.seatClassFilter;

                // اگر Object بود، به Array تبدیل کن
                if (storeFilter && typeof storeFilter === 'object' && !Array.isArray(storeFilter)) {
                    const result = Object.keys(storeFilter).map(key => ({
                        name_en: key,
                        name_fa: storeFilter[key].name_fa || storeFilter[key].name_en,
                        count: storeFilter[key].count || 0
                    }));
                    return result;
                }

                return storeFilter;
            },
            minPriceAirline() {
                if(this.$store.state.setDataSearch.MultiWay ==='TwoWay'){
                    if(this.$store.state.typeTripFlight === 'dept')
                    {
                        return this.$store.state.minPriceAirline.dept;
                    }else{
                        return this.$store.state.minPriceAirline.return;
                    }
                } else {
                    return this.$store.state.minPriceAirline.dept;
                }
            },
            price() {
                if(this.$store.state.setDataSearch.MultiWay ==='TwoWay'){
                    if(this.$store.state.typeTripFlight=== 'dept')
                    {
                        return this.$store.state.price.dept;
                    }else{
                        return this.$store.state.price.return;
                    }
                }else{
                    return this.$store.state.price.dept;
                }

            },
           // requestNumber() {
           //    return this.$store.state.requestNumber
           // },
           // requestNumberNoData() {
           //    return this.$store.state.requestNumberNoData
           // },
            setDataSearch() {
                return this.$store.state.setDataSearch
            },
            filteredFlights() {
                if(this.flights)
                {
                    return this.flights.filter(flight => {
                            return (this.time_filter.length == 1 && this.time_filter[0] == 'all_time') ? flight : this.time_filter.includes(flight.time_flight_name)
                        }
                    ).filter(flight => {
                            return (this.stop_filter.length == 1 && this.stop_filter[0] == 'all_stop') ? flight : this.stop_filter.includes(flight.count_interrupt)
                        }
                    ).filter(flight => {
                            return (this.airline_filter.length == 1 && this.airline_filter[0] == 'all_airline') ? flight : this.airline_filter.includes(flight.airline)
                        }
                    ).filter(flight => {
                            // اگر seat_class_filter یک Array نیست، به Array تبدیل کن
                            let filterArray = this.seat_class_filter;
                            if (!Array.isArray(filterArray)) {
                                filterArray = ['all_seat_class'];
                            }

                            const showAll = filterArray.length == 1 && filterArray[0] == 'all_seat_class';
                            const matchesFilter = filterArray.includes(flight.seat_class_en);
                            return showAll ? flight : matchesFilter;
                        }
                    ).filter(flight => {
                            return (this.type_flight_filter.length == 1 && this.type_flight_filter[0] == 'all_type_flight') ? flight : this.type_flight_filter.includes(flight.flight_type_li)
                        }
                    ).filter(flight => {
                            return ((flight.price.adult.price >= this.price_filter_flight[0]  && flight.price.adult.price <= this.price_filter_flight[1]) || (flight.price.adult.price == 0 && this.check_min_max_price));
                        }
                    );
                }
                return [];

            },
            filteredTwoWayFlights() {
                if(this.twoWayFlight)
                {

                    return this.twoWayFlight.filter(flight => {
                            return (this.time_filter.length == 1 && this.time_filter[0] == 'all_time') ? flight : this.time_filter.includes(flight.time_flight_name)
                        }
                    ).filter(flight => {
                            return (this.stop_filter.length == 1 && this.stop_filter[0] == 'all_stop') ? flight : this.stop_filter.includes(flight.count_interrupt)
                        }
                    ).filter(flight => {
                            return (this.airline_filter.length == 1 && this.airline_filter[0] == 'all_airline') ? flight : this.airline_filter.includes(flight.airline)
                        }
                    ).filter(flight => {
                            // Safety check for seat_class_filter
                            let filterArray = Array.isArray(this.seat_class_filter) ? this.seat_class_filter : ['all_seat_class'];
                            return (filterArray.length == 1 && filterArray[0] == 'all_seat_class') ? flight : filterArray.includes(flight.seat_class_en)
                        }
                    ).filter(flight => {
                            return (this.type_flight_filter.length == 1 && this.type_flight_filter[0] == 'all_type_flight') ? flight : this.type_flight_filter.includes(flight.flight_type_li)
                        }
                    )
                }
                return [];

            },

        },
        watch:{
          filteredFlights(){
            let sort = [];
            let sort_zero = [];

            let flights = this.filteredFlights ;
            flights.forEach(function(arraySort, keySort) {
              if ((Math.round(arraySort.price.adult.price) > 0)) {
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
