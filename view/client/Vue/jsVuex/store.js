import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);
import axios from "axios";
let city_template = {
  title: null,
  airport: null,
  value: null,
};
let tour_city_template = {
  country: {
    title: null,
    value: null,
  },
  city: {
    title: null,
    value: null,
  },
};
let default_city_template = {
  title: null,
  value: null,
};
let hotel_city_template = {
  country: {
    title: null,
    value: null,
  },
  city: {
    title: null,
    value: null,
  },
  hotel: {
    title: null,
    value: null,
  },
};
const store = new Vuex.Store({
  state: {
    pwa_page: {
      index: "search-service",
      footer_sheet:{
        status:false,
        loading:false,
        factor_number:null,
        data:null,
        refund: {
          data:null
        },

      },
      client_data: null,
      online_url: null,
      client_services: null,
      client_services_detail: null,
      project_files: null,
      active_service : null
    },
    panel_data: {
      status: false,
      flight: {
        default_cities: null,
        searched_cities: null,
        city_template: city_template,
        selected_origin: city_template,
        selected_destination: city_template,
        strategy: "local",
      },
      tour: {
        default_cities: null,
        searched_cities: null,
        city_template: tour_city_template,
        selected_origin: tour_city_template,
        selected_destination: tour_city_template,
        strategy: "local",
      },
      train: {
        default_cities: null,
        searched_cities: null,
        city_template: default_city_template,
        selected_origin: default_city_template,
        selected_destination: default_city_template,
      },
      bus: {
        default_cities: null,
        searched_cities: null,
        city_template: default_city_template,
        selected_origin: default_city_template,
        selected_destination: default_city_template,
      },
      insurance: {
        default_cities: null,
        searched_cities: null,
        city_template: default_city_template,
        selected_origin: default_city_template,
        selected_destination: default_city_template,
      },
      hotel: {
        default_cities: null,
        searched_cities: null,
        city_template: hotel_city_template,
        selected_destination: hotel_city_template,
        strategy: "local",
      },
      visa: {
        default_cities: null,
        searched_cities: null,
        city_template: city_template,
        selected_origin: city_template,
        selected_destination: city_template,
        selected_type: {
          title: null,
          value: null,
        },
        strategy: "local",
      },
      entertainment: {
        default_cities: null,
        searched_cities: null,
        city_template: city_template,
        selected_country: city_template,
        selected_city: city_template,
        selected_category: {
          title: null,
          value: null,
        },
        selected_sub_category: {
          title: null,
          value: null,
        },
        strategy: "destination",
      },
    },
    user_profile: {
      data: false,
    },
    purchase_record: {
      index: "flight",
      data: false,
    },
    flights: [],
    count_flights:0,
    timeFilter: [],
    interrupt: [],
    typeFlightFilter: [],
    seatClassFilter: [],
    minPriceAirline: [],
    price: [],
    // requestNumber: null,
    // requestNumberNoData: null,
    setDataSearch:[],
    mobileHeaderSearchBox: true,
    formDataSearch:[],
    priceCurrency: {},
    isComplete : false,
    lowestFlightPrice: {},
    typeTripFlight: {},
    defaultLoader : true ,
    data_search_type : 'Oneway' ,
    data_cities_internal:[],
    data_cities_arrival_internal:[],
    popular_internal_flights : [],
    popular_international_flights : [],
    search_sources : [],
    isTodayDate : true,
    time_filter : ['all_time'] ,
    stop_filter : ['all_stop'] ,
    airline_filter : ['all_airline'] ,
    seat_class_filter : ['all_seat_class'] ,
    type_flight_filter : ['all_type_flight'] ,
    check_min_max_price : true,
    price_filter_flight: [0,0],
    lang : 'fa',
    tours : {
      loading:false,
      filters:{
        defaultData:{},
        customData:{}
      },
      defaultTab:'internal',
      list:[],
      filtered:[],
      data:{
        // origin_data:{},
        // destination_data:{},
      }
    },
    exclusiveTourList : '',
    cipList : '',
    isCounter : null,
    isSafar360 : null,
  },
  getters: {
    getters_pwa_panel_data: (state) => state.panel_data,
    getMyState: (state) => state.panel_data
  },
  mutations: {
    // updateDeptFlights(state, uniqueFlights) {
    //   if (!state.flights.dept) state.flights.dept = [];
    //   state.flights.dept = uniqueFlights;
    // },

    setInternationalFlights(state, flights) {
      state.flights = flights;
    },
    updateInternationalFlights(state, deptFlights) {
      state.flights = deptFlights;
    },
    setDeptFlights(state, flights) {
      state.flights.dept = flights;
    },
    setReturnFlights(state, flights) {
      state.flights.return = flights;
    },
    updateDeptFlights(state, deptFlights) {
      state.flights.dept = deptFlights;
    },
    updateReturnFlights(state, returnFlights) {
      state.flights.return = returnFlights;
    },
    setLowestFlightPrice(state, lowest_price) {
      state.lowestFlightPrice = lowest_price;
    },
    setIsTodayDate(state, isTodayDate) {
      state.isTodayDate = isTodayDate;
    },
    setMobileHeaderSearchBox(state, status) {
      state.mobileHeaderSearchBox = status;
    },
    setFlights(state, data_flight) {
      state.flights = data_flight;

    },
    getCount(state, count_flights) {
      state.count_flights = count_flights;
    },
    setTimeFilter(state, filter_time) {
      state.timeFilter = filter_time;
    },
    setInterrupt(state, interrupt) {
      state.interrupt = interrupt;
    },
    setTypeFlightFilter(state, type_flight_filter) {
      state.typeFlightFilter = type_flight_filter;
    },
    setSeatClassFilter(state, seat_class_filter) {
      state.seatClassFilter = seat_class_filter;
    },
    setMinPriceAirline(state, min_price_airline) {
      state.minPriceAirline = min_price_airline;
    },
    setPrice(state, price) {
      state.price = price;
    },
    // requestNumber(state, requestNumber) {
    //   state.requestNumber = requestNumber;
    // },
    //  requestNumberNoData(state, requestNumberNoData) {
    //     state.requestNumberNoData = requestNumberNoData;
    //  },
    setCheckComplete(state, isComplete) {
      state.isComplete = isComplete;
    },
    setDataSearch(state, data_search) {
      state.setDataSearch = data_search;
    },
    formDataSearch(state, data_search) {
      state.formDataSearch = {...data_search.dataSearch}
    },
    setPriceCurrency: (state, data_price) => {
      state.priceCurrency = data_price;
    },
    setTypeTripFlight: (state, type_trip) => {
      state.typeTripFlight = type_trip;
    },
    setFlightUniqId: (state, uniq_id) => {
      state.flightUniqId = uniq_id;
    },
    timeSortFlight: (state, timeSort) => {
      if(timeSort ==='desc'){
        if(state.flights !== ""){
          if(state.typeTripFlight == 'dept') {
              state.flights.dept.sort(function (a, b) {
                return a.departure_time.localeCompare(b.departure_time);
              });
            }else{
              state.flights.return.sort(function (a, b) {
                return a.departure_time.localeCompare(b.departure_time);
              });
          }
        }
      }else{
        if(state.flights !=="") {
          if(state.typeTripFlight == 'dept') {
            state.flights.dept.sort(function(a, b) {
              return b.departure_time.localeCompare(a.departure_time);
            });
          }else{
            state.flights.return.sort(function(a, b) {
              return b.departure_time.localeCompare(a.departure_time);
            });
          }
        }
      }
    },
    timeSortInternationalFlight(state, timeSort){
      if(timeSort ==='desc'){
        if(state.flights !== ""){
            state.flights.sort(function (a, b) {
              return a.departure_time.localeCompare(b.departure_time);
            });
        }
      }else{
        if(state.flights !=="") {
            state.flights.sort(function(a, b) {
              return b.departure_time.localeCompare(a.departure_time);
            });
        }
      }
    },
    priceSortTour: (state, priceSort) => {
      if(priceSort ==='desc'){
        if(state.tours.list !== ""){
          state.tours.list.sort(function (a, b) {
            return a.discount.minPriceR - b.discount.minPriceR
          });
        }
      }else{
        if(state.tours.list !=="") {
          state.tours.list.sort(function (a, b) {
            return b.discount.minPriceR - a.discount.minPriceR
          });
        }
      }
    },
    timeSortTour: (state, timeSort) => {
      if(timeSort ==='desc'){
        if(state.tours.list !== ""){
          state.tours.list.sort(function (a, b) {
            return a.start_date.localeCompare(b.start_date);
          });
        }
      }else{
        if(state.tours.list !=="") {
          state.tours.list.sort(function (a, b) {
            return b.start_date.localeCompare(a.start_date);
          });
        }
      }
    },
    seatClassFilter :(state , seatClassFilter) => {
        state.seat_class_filter = seatClassFilter
    },
    typeFlightFilter :(state , typeFlightFilter) => {
      state.type_flight_filter = typeFlightFilter
    },
    airlineFilter :(state , airlineFilter) => {
      state.airline_filter = airlineFilter
    },
    timeMoveFilter :(state , timeMoveFilter) => {
      state.time_filter = timeMoveFilter
    },
    stopFilter :(state , stopFilter) => {
      state.stop_filter = stopFilter
    },
    priceFilter :(state , priceFilter ,check_min_max_price) => {
      state.price_filter_flight = priceFilter
      state.check_min_max_price = check_min_max_price
    },
    priceSortFlight: (state, timeSort) => {
      // Enhanced validation: check if flights object exists and has required structure
      if(!state.flights || state.flights === "") return;



      const targetFlights = state.typeTripFlight == 'dept' ? state.flights.dept : state.flights.return;

      // Strict validation: ensure target array exists and has items
      if(!targetFlights || !Array.isArray(targetFlights) || targetFlights.length === 0) {
        return;
      }

      // Calculate final display price (same logic as in priceFlight.vue)
      const getFinalDisplayPrice = (flight) => {
        if(!flight || !flight.price || !flight.price.adult) return 0;

        let info_price = state.priceCurrency;
        let finalPrice = 0;

        // Check if has discount - use discounted price if available
        let usesDiscount = flight.price.adult.has_discount === 'yes';

        if (usesDiscount) {
          // Use discounted price (price_adult_with_discount computed property logic)
          let price_discount = flight.price.adult.with_discount;
          let price_discount_with_out_currency = flight.price.adult.price_discount_with_out_currency;

          // Apply currency conversion
          if (Object.keys(info_price).length !== 0) {
            if (Object.keys(info_price.data).length > 1) {
              if (info_price.data.CurrencyCode > 0) {
                finalPrice = (price_discount_with_out_currency / info_price.data.EqAmount);
              }
            } else if (Object.keys(info_price.data).length === 0) {
              finalPrice = price_discount_with_out_currency;
            }
          }

          // Fallback to price_discount if no conversion applied (same as computed property return)
          if (!finalPrice) {
            finalPrice = price_discount;
          }
        } else {
          // Use regular price (price_adult computed property logic)
          let price = flight.price.adult.price;
          let price_with_out_currency = flight.price.adult.price_with_out_currency;

          // Apply currency conversion
          if (Object.keys(info_price).length !== 0) {
            if (Object.keys(info_price.data).length > 1) {
              if (info_price.data.CurrencyCode > 0) {
                finalPrice = (price_with_out_currency / info_price.data.EqAmount);
              }
            } else if (Object.keys(info_price.data).length === 0) {
              finalPrice = price_with_out_currency;
            }
          }

          // Fallback to price if no conversion applied (same as computed property return)
          if (!finalPrice) {
            finalPrice = price;
          }
        }

        // Apply markup deduction if conditions are met (same as in priceFlight.vue template lines 13-15, 24-26, 40-42)
        if ((state.isCounter || state.isSafar360) &&
            flight.flight_type_li == 'system' &&
            flight.price.adult.markup_amount) {
          finalPrice = finalPrice - flight.price.adult.markup_amount;
        }

        // Convert to number
        if (typeof finalPrice === 'string') {
          finalPrice = finalPrice.replace(/,/g, '');
        }
        const numPrice = parseFloat(finalPrice);
        return isNaN(numPrice) ? 0 : numPrice;
      };


      // Separate flights with zero prices from non-zero prices
      const zeroPrice = [];
      const nonZeroPrice = [];

      targetFlights.forEach(flight => {
        const price = getFinalDisplayPrice(flight);
        if (price <= 0) {
          zeroPrice.push(flight);
        } else {
          nonZeroPrice.push(flight);
        }
      });

      // Sort only non-zero price flights using the same logic as UI display
      if(timeSort === 'desc'){
        nonZeroPrice.sort((a, b) => {
          return getFinalDisplayPrice(a) - getFinalDisplayPrice(b);
        });
      }else{
        nonZeroPrice.sort(function(a,b) {
          return getFinalDisplayPrice(b) - getFinalDisplayPrice(a);
        });
      }

      // Combine: sorted non-zero flights + unsorted zero price flights at the end
      // Clear array and repopulate with sorted items
      targetFlights.splice(0, targetFlights.length, ...nonZeroPrice, ...zeroPrice);
    },
    priceSortInternationalFlight: (state, timeSort) => {
      // Enhanced validation: check if flights array exists and has items
      if(!state.flights || state.flights === "" || !Array.isArray(state.flights) || state.flights.length === 0) {
        return;
      }

      // Calculate final display price (same logic as in interantionalFlight/priceFlight.vue)
      const getFinalDisplayPrice = (flight) => {
        if(!flight || !flight.price || !flight.price.adult) return 0;

        let info_price = state.priceCurrency;
        let finalPrice = 0;

        // Check if has discount - use discounted price if available
        let usesDiscount = flight.price.adult.has_discount === 'yes';

        if (usesDiscount) {
          // Use discounted price (price_adult_with_discount computed property logic)
          let price_discount = flight.price.adult.with_discount;
          let price_discount_with_out_currency = flight.price.adult.price_discount_with_out_currency;

          // Apply currency conversion
          if (Object.keys(info_price).length !== 0) {
            if (Object.keys(info_price.data).length > 1) {
              if (info_price.data.CurrencyCode > 0) {
                finalPrice = (price_discount_with_out_currency / info_price.data.EqAmount);
              }
            } else if (Object.keys(info_price.data).length === 0) {
              finalPrice = price_discount_with_out_currency;
            }
          }

          // Fallback to price_discount if no conversion applied (same as computed property return)
          if (!finalPrice) {
            finalPrice = price_discount;
          }
        } else {
          // Use regular price (price_adult computed property logic)
          let price = flight.price.adult.price;
          let price_with_out_currency = flight.price.adult.price_with_out_currency;

          // Apply currency conversion
          if (Object.keys(info_price).length !== 0) {
            if (Object.keys(info_price.data).length > 1) {
              if (info_price.data.CurrencyCode > 0) {
                finalPrice = (price_with_out_currency / info_price.data.EqAmount);
              }
            } else if (Object.keys(info_price.data).length === 0) {
              finalPrice = price_with_out_currency;
            }
          }

          // Fallback to price if no conversion applied (same as computed property return)
          if (!finalPrice) {
            finalPrice = price;
          }
        }

        // Apply markup deduction if conditions are met (same as in interantionalFlight/priceFlight.vue template lines 14-16, 26-28, 43-45)
        if ((state.isCounter || state.isSafar360) &&
            flight.flight_type_li == 'system' &&
            !flight.is_foreign_airline &&
            flight.price.adult.markup_amount) {
          finalPrice = finalPrice - flight.price.adult.markup_amount;
        }

        // Convert to number
        if (typeof finalPrice === 'string') {
          finalPrice = finalPrice.replace(/,/g, '');
        }
        const numPrice = parseFloat(finalPrice);
        return isNaN(numPrice) ? 0 : numPrice;
      };


      // Separate flights with zero prices from non-zero prices
      const zeroPrice = [];
      const nonZeroPrice = [];

      state.flights.forEach(flight => {
        const price = getFinalDisplayPrice(flight);
        if (price <= 0) {
          zeroPrice.push(flight);
        } else {
          nonZeroPrice.push(flight);
        }
      });


      // Sort only non-zero price flights using the same logic as UI display
      if(timeSort === 'desc'){
        nonZeroPrice.sort(function(a,b) {
          return getFinalDisplayPrice(a) - getFinalDisplayPrice(b);
        });
      }
      else{
        nonZeroPrice.sort(function(a,b) {
          return getFinalDisplayPrice(b) - getFinalDisplayPrice(a);
        });
      }

      // Clear array and repopulate with sorted items
      state.flights.splice(0, state.flights.length, ...nonZeroPrice, ...zeroPrice);
    },
    capacitySortFlight : (state, capacitySort) => {

      if(capacitySort ==='desc'){
        if(state.flights !== ""){
          if(state.typeTripFlight == 'dept') {
            state.flights.dept.sort(function(a,b) {
              return a.capacity - b.capacity;
            })
          }else{
            state.flights.return.sort(function(a,b) {
              return a.capacity - b.capacity;
            })
          }
        }


      }else{
        if(state.flights !=="") {
          if(state.typeTripFlight == 'dept') {
            state.flights.dept.sort(function(a,b) {
              return b.capacity - a.capacity;
            })
          }else{
            state.flights.return.sort(function(a,b) {
              return b.capacity - a.capacity;
            })
          }
        }
      }
    },
    capacitySortInternationalFlight : (state, capacitySort) => {

      if(capacitySort ==='desc'){
        if(state.flights !== ""){
            state.flights.sort(function(a,b) {
              return a.capacity - b.capacity;
            })
        }
      }else{
        if(state.flights !=="") {
            state.flights.sort(function(a,b) {
              return b.capacity - a.capacity;
            })
        }
      }
    },
    setDefaultLoader: (state, default_loader) => {
      state.defaultLoader = default_loader;
    },
    setPwaData(state, parameters) {
      console.log('parameters' , parameters)
      let result = parameters.data;
      if (!parameters.data) {
        result = Object;
      }

      let panel_index = "panel_data";
      if (parameters.panel_index) {
        panel_index = parameters.panel_index;
      }
      for (let refillable in result) {
        if (parameters.index) {
          state[panel_index][parameters.index][refillable] = result[refillable];
        } else {
          state[panel_index][refillable] = result[refillable];
        }
      }
    },
    setPwaActiveService(state , params) {
      if(params) {
        state.pwa_page.active_service = {
          service : params['service'],
          type : params['type']
        };
      }

    },
    setPwaCitiesData(state, parameters) {
      let result = parameters.data;
      if (!parameters.data) {
        result = null;
      }
      state.panel_data[parameters.index]["searched_cities"] = result;
    },
    setPwaDefaultData(state, parameters) {
      state.panel_data[parameters.index].default_cities = {};
      state.panel_data[parameters.index].default_cities = parameters.data;
    },
    setPwaDefaultStatus(state, status) {

      state.panel_data["status"] = status;
    },
    setPwaFooterSheetStatus(state, status) {
      state.pwa_page.footer_sheet.loading = false;
      state.pwa_page.footer_sheet.status = status;
    },
    setPwaFooterSheetLoading(state, status) {
      state.pwa_page.footer_sheet.loading = status;
    },
    setPwaFooterSheetData(state, data) {
      state.pwa_page.footer_sheet.data = data;
    },
    setPwaFooterSheetRefundData(state, data) {
      state.pwa_page.footer_sheet.refund.data = data;
    },
    setSearchType(state,data){
      state.data_search_type = data ;
    },
    setDataCitiesInternal(state,data){
      state.data_cities_internal = data
    },
    setDataArrivalCitiesInternal(state,data){
      state.data_cities_arrival_internal = data
    },
    setPopularInternalFlights(state, data_popular_flight) {
      state.popular_internal_flights = data_popular_flight;
    },
    setPopularInternationalFlights(state, data_popular_flight) {
      state.popular_international_flights = data_popular_flight;
    },
    setSearchSources(state,search_sources){
      state.search_sources = search_sources ;
    },
    setTourList(state,data){
      state.tours.list = data ;
    },
    setExclusiveTourList(state,data){
      state.exclusiveTourList = data ;
    },
    setFilteredTourList(state,data){
      state.tours.filtered = data ;
    },
    setTourLoading(state,status){
      state.tours.loading = status ;
    },
    setTourTab(state,tab){
      state.tours.defaultTab = tab ;
    },
    setTourData(state,data){
      state.tours.data = data ;
    },
    setTourDefaultFilters(state,data){
      state.tours.filters.defaultData = data ;
    },
    setTourCustomFilters(state,data){
      state.tours.filters.customData = data ;
    },
    setCipList(state,data){
      state.cipList = data ;
    },
    setFilteredCipList(state,data){
      state.cip.filtered = data ;
    },
    setCipLoading(state,status){
      state.cip.loading = status ;
    },
    setCipTab(state,tab){
      state.cip.defaultTab = tab ;
    },
    setCipData(state,data){
      state.cip.data = data ;
    },
    setCipDefaultFilters(state,data){
      state.cip.filters.defaultData = data ;
    },
    setCipCustomFilters(state,data){
      state.cip.filters.customData = data ;
    },
    isCounter(state,data){
      state.isCounter = data ;
    },
    isSafar360(state,data){
      state.isSafar360 = data ;
    }
  },
  actions: {
    //region [internationalFlight]
    async getFlight({ commit }, payload) {


      await axios
        .post(
          amadeusPath + "ajax",
          {
            className: "newApiFlight",
            method: payload.method,
            param: payload.url,
          },
          {
            "Content-Type": "application/json",
          }
        )
        .then(function (response) {
          // console.log('store -> > >>>>' , response.data.data.flights)
          // response.data.data.flights.forEach(f => {
          //   // f.forEach(c => {
          //   //   console.log(c)
          //   // })
          //   console.log(f)
          // })
       



          commit("setFlights", response.data.data.flights);
          commit("getCount", response.data.data.count_flights);
          commit("setTimeFilter", response.data.data.time_filter);
          commit("setInterrupt", response.data.data.interrupt);
          commit("setTypeFlightFilter", response.data.data.type_flight_filter);
          commit("setSeatClassFilter", response.data.data.seat_class_filter);
          commit("setMinPriceAirline", response.data.data.min_price_airline);
          commit("setPrice", response.data.data.price);
          // commit("requestNumber", response.data.data.request_number);
          // commit("requestNumberNoData", response.data.data.dept);

          if(payload.method == 'flightInternal') {
            commit("setCheckComplete", response.data.data.dept.is_complete);
          }else{
            if(response.data.data == false){
              commit("setCheckComplete", true);
            }else {
              commit("setCheckComplete", response.data.data.is_complete);
            }
          }

          // IMPORTANT: Turn off loader after successful response
          commit("setDefaultLoader", false);

        })
        .catch(function (error) {
          commit("setDefaultLoader", false);
          commit("setFlights", []);
        });
    },
    //endregion

    //region [popularFlight]
    async getPopularInternalFlight({ commit }, payload) {
      axios.post(
        amadeusPath + 'ajax', {
          className: 'newApiFlight',
          method: payload.method,
          limit : 5
        },
        {
          'Content-Type': 'application/json',
        })
        .then(function(response) {
          commit("setPopularInternalFlights", response.data.data);
        }).catch(function(error) {
        console.log(error);
      });

    },
    //endregion

    //region internationalPopularFlight]
    async getPopularInternationalFlight({ commit }, payload) {
      axios.post(
        amadeusPath + 'ajax', {
          className: 'newApiFlight',
          method: payload.method,
          limit : 5
        },
        {
          'Content-Type': 'application/json',
        })
        .then(function(response) {
          commit("setPopularInternationalFlights", response.data.data);
        }).catch(function(error) {
        console.log(error);
      });

    },
    //endregion

    //region [getDataSearch]
    async getDataSearch({ commit }, payload) {
      await axios
        .post(
          amadeusPath + "ajax",
          {
            className: "newApiFlight",
            method: "dateRout",
            param: payload.url,
          },
          {
            "Content-Type": "application/json",
          }
        )
        .then(function (response) {

          commit("setDataSearch", response.data);
          commit("formDataSearch", response.data);
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    //endregion

    //region [getLowestPrice]
    async getLowestPrice({ commit }, payload) {
      await axios
        .post(
          amadeusPath + "ajax",
          {
            className: "newApiFlight",
            method: payload.method ? payload.method : "getLowestPriceFlight",
            origin: payload.origin,
            destination: payload.destination,
            passengers: payload.passengers,
          },
          {
            "Content-Type": "application/json",
          }
        )
        .then(function (response) {
          commit("setLowestFlightPrice", response.data.data);
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    //endregion

    //region [checkTodayDate]
    async checkTodayDate({ commit }, payload) {
      await axios
        .post(
          amadeusPath + "ajax",
          {
            className: 'newApiFlight',
            method: 'checkToDayDate',
            dateSearch: payload.departureDate,
          },
          {
            "Content-Type": "application/json",
          }
        )
        .then(function (response) {
          commit("setIsTodayDate", response.data.data);
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    //endregion

    //region [pwa]
    async pwaGetDefaultCities({ commit }, payload) {
      await axios
        .post(
          amadeusPath + "ajax",
          {
            className: "searchService",
            method: "pwaGetDefaultCities",
            limit: "9",
            index_key: payload.index,
            strategy: payload.strategy,
            conditions: payload.conditions,
            to_json: true,
          },
          {
            "Content-Type": "application/json",
          }
        )
        .then(async function (response) {
          await commit("setPwaData", {
            index: payload.index,
            data: {
              default_cities: response.data.data,
              strategy: payload.strategy,
            },
          });
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    async pwaClosePanel({ commit }) {
      await commit("setPwaDefaultStatus", false);
    },
    async pwaGetSearchedCities({ commit }, payload) {
      if (payload.searchable) {
        await axios
          .post(
            amadeusPath + "ajax",
            {
              className: "searchService",
              method: "pwaGetDefaultCities",
              limit: "9",
              index_key: payload.index,
              strategy: payload.strategy,
              value: payload.searchable,
              conditions: payload.conditions,
              to_json: true,
            },
            {
              "Content-Type": "application/json",
            }
          )
          .then(async function (response) {
            await commit("setPwaData", {
              index: payload.index,
              data: {
                searched_cities: response.data.data,
                strategy: payload.strategy,
              },
            });
          })
          .catch(function (error) {
            console.log(error);
          });
      } else {
        await commit("setPwaData", {
          index: payload.index,
          data: {
            searched_cities: null,
          },
        });
      }
    },
    async pwaChangeTab({ commit }, payload) {
      let default_origin_city_template = city_template;
      let default_destination_city_template = city_template;

      if (payload.index === "tour") {
        if (payload.strategy === "external") {
          default_origin_city_template = {
            country: {
              title: "ایران",
              value: "1",
            },
            city: {
              title: null,
              value: null,
            },
          };
          default_destination_city_template = tour_city_template;
        } else {
          default_origin_city_template = tour_city_template;
          default_destination_city_template = tour_city_template;
        }
      }

      await commit("setPwaData", {
        index: payload.index,
        data: {
          selected_origin: default_origin_city_template,
          selected_destination: default_destination_city_template,
          strategy: payload.strategy,
        },
      });
    },
    async pwaGetUserProfile({ commit }, payload) {
      await axios
        .post(
          amadeusPath + "ajax",
          {
            className: "user",
            method: "apiGetProfile",
          },
          {
            "Content-Type": "application/json",
          }
        )
        .then(async function (response) {
          await commit("setPwaData", {
            panel_index: "user_profile",
            data: {
              data: response.data.data,
            },
          });
        })
        .catch(async function (error) {
          if (error.response.status === 403) {
            window.location.href = "/gds/loginUser?referrer=app";

            await commit("setPwaData", {
              panel_index: "user_profile",
              data: {
                index: payload.tab_index,
                data: false,
              },
            });
          }
        });
    },
    async pwaChangePurchaseTab({ commit }, payload) {
      await axios
        .post(
          amadeusPath + "ajax",
          {
            className: "userBuy",
            method: "apiGetData",
            tab_index: payload.tab_index,
            form: payload.form,
          },
          {
            "Content-Type": "application/json",
          }
        )
        .then(async function (response) {
          await commit("setPwaData", {
            panel_index: "purchase_record",
            data: {
              index: payload.tab_index,
              data: response.data.data,
            },
          });
        })
        .catch(async function (error) {
          if (error.response.status === 403) {
            window.location.href = "/gds/loginUser?referrer=app";

            await commit("setPwaData", {
              panel_index: "purchase_record",
              data: {
                index: payload.tab_index,
                data: false,
              },
            });
          }
        });
    },
    async pwaChangePage({ commit }, payload) {
      await commit("setPwaData", {
        panel_index: "pwa_page",
        data: {
          index: payload.index,
        },
      });
    },
    async pwaActiveService({ commit }, payload) {
      await commit("setPwaActiveService", payload)
    },
    async pwaGetClientData({ commit , state}, payload) {
      // let response = this.api_gds_client_data();

      if (payload.client_data) {
        await commit("setPwaData", {
          panel_index: "pwa_page",
          data: {

            client_data: payload.client_data,
            client_name: payload.client_name,
            client_id: payload.client_id,
            client_services: payload.client_services,
            client_services_detail: payload.client_services_detail,
            project_files: payload.project_files,
            online_url: "/gds/" + payload.lang,
          },
        });
      } else {
        window.location.href = "/gds/loginUser?referrer=app";
      }
    },
    // endregion

    async getSearchSources({ commit }, payload){
      axios.post(
        amadeusPath + 'ajax', {
          className: 'newApiFlight',
          method: payload.method,
          limit : 5
        },
        {
          'Content-Type': 'application/json',
        })
        .then(function(response) {

          commit("setSearchSources", response.data.data);
        }).catch(function(error) {
        console.log(error);
      });
    },

    async isCounter({ commit }){

      axios.post(amadeusPath + "ajax",
         {
           className: "login",
           method: "isCounter",
         },
         {
           'Content-Type': 'application/json'
         }).then(function (response) {

        commit("isCounter", response.data);
      }).catch(function (error) {
      });

    },

    async isSafar360({ commit }){

      axios.post(amadeusPath + "ajax",
         {
           className: "clients",
           method: "isSafar360",         },
         {
           'Content-Type': 'application/json'
         }).then(function (response) {
           console.log('isSafar360: ')
           console.log(response.data)
        commit("isSafar360", response.data);
      }).catch(function (error) {
      });

    }
  },


});
export default store;
