<template>
<!--
   <sidebar :dataSearch="setDataSearch" :price="price"  :timeFilter="timeFilter"
             :typeFlightFilter="typeFlightFilter" :seatClassFilter="seatClassFilter"
             :minPriceAirline="minPriceAirline" :countFlights="filteredFlights.length" @filterFlights="filterFlightsFinally"
             @filterPriceFlights="filterPrice"></sidebar>

    <show-ticket :flights="filteredFlights" :dataSearch="setDataSearch" @sortTimeOfShowTicket="timeSortFlight"
                 :has_request_offline_access='has_request_offline_access' :full_capacity='full_capacity'
                 @sortPriceOfShowTicket="priceSortFlight" ></show-ticket>
  -->
  <div>
      <section class="search-flight">
        <search-box :dataSearch="setDataSearch"></search-box>
      </section>
      <input type="hidden" value='' name="flight_id_private" id="flight_id_private">
  </div>
</template>

<script>
    import searchBox from "./searchBox";
    import sidebar from "./sidebar";
    import showTicket from "./showTicket";
    export default {
        name: "internalFlight",
        components: {
            'sidebar': sidebar,
            'show-ticket': showTicket,
            'search-box': searchBox
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
                price_sort_filter :'asc',
                trip_flight : 'dept',
                check_min_max_price: true ,
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
                console.log('min==>'+ value[0])
                console.log('max==>'+value[1])
                console.log('check_min_max_price==>'+ this.check_min_max_price)
                console.log(value)
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
            priceSortFlight(){
                if(document.querySelector("#time_sort").classList.contains("sorting-active-color-main")){
                    document.getElementsByClassName('time_sort_color')[0].classList.remove("sorting-active-color-main");
                    document.getElementsByClassName('price_sort_color')[0].classList.add("sorting-active-color-main");
                }
                if(this.price_sort_filter ==='desc'){
                    this.price_sort_filter = 'asc';
                    this.flights.sort(function(a,b) {
                        return a.price.adult.price - b.price.adult.price;
                    })
                }else{
                    this.price_sort_filter = 'desc';
                    this.flights.sort(function(a,b) {
                        return b.price.adult.price - a.price.adult.price;
                    })
                }
            },
            filterFlightsFinally(value, type) {

                if(type !== 'price_slider')
                {
                    if (value.indexOf('all') === -1) {
                        document.getElementsByClassName('all_' + type)[0].classList.remove("checked");
                        document.getElementsByClassName(value)[0].classList.add("checked");
                    }else{
                        let class_for_remove = document.getElementsByClassName(type);
                        for (let i = 0; i < class_for_remove.length ; i++) {
                            class_for_remove[i].classList.remove("checked");
                        }
                        document.getElementsByClassName('all_' + type)[0].classList.add("checked");
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
                        if (this.seat_class_filter.indexOf(value) !== -1) {
                            if (value.indexOf('all') === -1) {
                                document.getElementsByClassName(value)[0].classList.remove("checked");
                            }
                            this.seat_class_filter = this.deleteByValue(this.seat_class_filter, value);
                        } else {
                            document.getElementsByClassName(value)[0].classList.add("checked");
                            this.seat_class_filter.push(value);
                        }
                        if(this.seat_class_filter.length === 1 && this.seat_class_filter.indexOf('all') === -1){
                            document.getElementsByClassName('all_seat_class')[0].classList.add("checked");
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
                     url_finally = `/gds/fa/search-flight/1/${url_send_split[5]}/${dateNow('-')}/Y/1-0-0`;

                     window.history.pushState({path: url_send}, "", url_finally);

                    url_send = url_finally ;
                }else{
                    console.log(location.pathname)
                }
            }
            this.$store.dispatch('getDataSearch', {url: url_send}).then(response => {
                this.$store.dispatch('getFlight', {url: url_send,method: 'flightInternal'}).then(response=>{
                        this.price_filter_flight=[this.price.min_price,this.price.max_price]
                });
            });
        },
        computed: {
            flights() {
              if(this.$store.state.setDataSearch.MultiWay ==='TwoWay'){
                   if(this.$store.state.typeTripFlight === 'dept'){
                       this.$store.commit('setTypeTripFlight','dept');
                       return this.$store.state.flights.dept;
                   }else{
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
                return this.$store.state.seatClassFilter;
            },
            minPriceAirline() {
                if(this.$store.state.setDataSearch.MultiWay ==='TwoWay'){
                    if(this.$store.state.typeTripFlight === 'dept')
                    {
                        return this.$store.state.minPriceAirline.dept;
                    }else{
                        return this.$store.state.minPriceAirline.return;
                    }
                }else{
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
                            return (this.seat_class_filter.length == 1 && this.seat_class_filter[0] == 'all_seat_class') ? flight : this.seat_class_filter.includes(flight.seat_class_en)
                        }
                    ).filter(flight => {
                            return (this.type_flight_filter.length == 1 && this.type_flight_filter[0] == 'all_type_flight') ? flight : this.type_flight_filter.includes(flight.flight_type_li)
                        }
                    ).filter(flight => {
                            return ((flight.price.adult.price >= this.price_filter_flight[0]  && flight.price.adult.price <= this.price_filter_flight[1]) || (flight.price.adult.price == 0 && this.check_min_max_price));
                        }
                    )
                }
                return [];

            },

        },

    }
</script>

