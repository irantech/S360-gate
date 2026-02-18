Vue.component('search-box', {
    template: `
      <div>
      <div class="filter_airline_flight">
        <div class="filtertip parvaz-filter-change site-bg-main-color site-bg-color-border-bottom ">
          <div class="tip-content">
            <p class="">
              <span class=" bold counthotel"> %% originName %% </span>
              به
              <span class=" bold counthotel"> %% destinationName %% </span>
            </p>
            <p class="counthotel "> %% DateFlightWithName %%</p>
          </div>
        </div>
        <!-- search box -->
        <div class=" s-u-update-popup-change">
          <form class="search-wrapper" action="" method="post">
            <div class="d-flex flex-wrap align-items-center position-relative">
              <div class="s-u-form-block s-u-num-inp s-u-num-inp-change">
                <div class="s-u-in-out-wrapper raft raft-change change-bor">
                </div>
              </div>
              <div class="s-u-form-block s-u-num-inp s-u-num-inp-change bargasht bargasht-change change-bor">
                <div class="s-u-in-out-wrapper ">
                  <div class="select">
                    <input type="text" name="cityDeparture" id="cityDeparture"
                           class="form-control search_input inputSearchForeign"
                           placeholder="مبدا" @keyup="getListCityOrigin()" v-model="origin"
                           @focus="deleteInput('dept')">

                    <img src="images/loader.gif" class="loaderSearch" id="loaderSearch"
                         name="loaderSearch" style="display: none">
                    <input type="hidden" id="departureSelected" v-model="originIata"
                           name="departureSelected">
                    <input type="hidden" name="countRoom" id="countRoom" v-model="dataPeopleRoomsCount">
                    <input type="hidden" name="isInternal" id="isInternal" v-model="isInternalPackage">

                    <div id="searchDepartureList" class="resultUlInputSearch" style="display: none">

                      <ul v-for="city in infoCities">
                        <li @click="selectCity(city,'dept')">%% city.city_nameFa %%
                          - %% city.country_nameFa %% (%% city.departure_code %%)
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="select">
                    <input type="text" id="cityDestination" name="cityDestination"
                           class="inputSearchForeign form-control search_input"
                           placeholder="مقصد" @keyup="getListCityDestination()" v-model="destination"
                           @focus="deleteInput('retrun')">

                    <input id="arrivalSelected" class="" type="hidden" v-model="destinationIata"
                           name="DestinationAirportPortal">


                    <div id="searchArrivalList" class="resultUlInputSearch" style="display: none">

                      <ul v-for="cityDestination in infoCitiesDestination">
                        <li @click="selectCity(cityDestination,'arrival')">%% cityDestination.city_nameFa %%
                          - %% cityDestination.country_nameFa %%
                          (%% cityDestination.arrival_code %%)
                        </li>
                      </ul>

                    </div>
                  </div>
                </div>
              </div>

            </div>
            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100">
              <div class="s-u-form-date-wrapper">
                <div class="s-u-date-pick">
                  <div class="s-u-jalali s-u-jalali-change">
                    <i class="zmdi zmdi-calendar-note site-main-text-color"></i>
                    <input class="shamsiOnlyDeptCalendar " type="text" name="dept_date"
                           id="dept_date_local" placeholder=" تاریخ مسافرت" readonly="readonly"
                           :value="departureDate">
                  </div>
                </div>
              </div>
            </div>


            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100  ">
              <div class="s-u-form-date-wrapper">
                <div class="s-u-date-pick">
                  <div class="s-u-jalali s-u-jalali-change">

                    <i class="zmdi zmdi-calendar-note site-main-text-color"></i>
                    <input class="shamsiOnlyReturnCalendar " type="text" name="dept_date_return"
                           id="dept_date_local_return" placeholder=" تاریخ برگشت"
                           readonly="readonly" :value="arrivalDate">
                  </div>
                </div>
              </div>
            </div>

            <div class="number_passengers">
              <room-select-user v-for="(peopleRoom,keyPeople) in dataPeopleRooms" :key="keyPeople"
                                :keyPeople="keyPeople" :peopleRoom="peopleRoom"
                                @deleteSelectRoom="closeRoom"></room-select-user>

            </div>
            <div class="btn_add_room" @click="addRoom()">
              افزودن اتاق جدید
            </div>

            <div class="s-u-search-wrapper s-u-num-inp s-u-num-inp-search-change">
              <a href="" onclick="return false" class="f-loader-check f-loader-check-bar"
                 id="loader_check_submit" style="display:none"></a>

              <button type="button" onclick="searchPackage()" id="sendFlight"
                      class="site-bg-main-color">جستجو
              </button>
            </div>
          </form>
          <loader-search-package :originName="originName" :destinationCity="destinationName"></loader-search-package>
          <div class="message_error_portal"></div>
        </div>
      </div>
      </div>
    `,
    delimiters: ['%%', '%%'],
    data: function () {
        return {
            infoCities: [],
            infoCitiesDestination: [],
            origin: '',
            originName: '',
            originIata: '',
            destination: '',
            destinationName: '',
            destinationIata: '',
            departureDate: '',
            arrivalDate: '',
            adultCount: '',
            childCount: '',
            infantCount: '',
            DateFlightWithName: '',
            dataPeopleRooms: '',
            dataPeopleRoomsCount: '',
            isInternalPackage: '',
        }
    },
    methods: {
        closeRoom(idRoom) {
            console.log(idRoom);
            let xxx = this.dataPeopleRooms;
            console.log(xxx);
            let afterSlice = [];
            this.dataPeopleRooms.splice(idRoom, 1);
            this.dataPeopleRoomsCount = this.dataPeopleRooms.length;
            console.log(this.dataPeopleRooms);
        },
        addRoom() {

            console.log(this.dataPeopleRooms);

            let element = {};
            element.adult = '1';
            element.child = '0';
            element.ageChild = ['0'];
            this.dataPeopleRooms.push(element);
            this.dataPeopleRoomsCount = this.dataPeopleRooms.length;
            console.log(this.dataPeopleRooms.length);


        },
        initialInformation() {
            var _this_ = this;
            axios.post(amadeusPath + 'axios',
                {
                    method: 'initialInformation',
                    urlWeb: location.pathname.substr(0),
                },
                {
                    'Content-Type': 'application/json'
                }).then(function (response) {
                console.log(response.data.dataSearch);
                let dataSearch = response.data.dataSearch;

                _this_.origin = dataSearch.NameDeparture;
                _this_.originName = dataSearch.NameDeparture;
                _this_.originIata = dataSearch.origin;
                _this_.destination = dataSearch.NameArrival;
                _this_.destinationName = dataSearch.NameArrival;
                _this_.destinationIata = dataSearch.destination;
                _this_.departureDate = dataSearch.departureDate;
                _this_.arrivalDate = dataSearch.arrivalDate;
                _this_.adultCount = dataSearch.adult;
                _this_.childCount = dataSearch.child;
                _this_.infantCount = dataSearch.infant;
                _this_.DateFlightWithName = dataSearch.DateFlightWithName;
                _this_.dataPeopleRooms = dataSearch.Rooms;
                _this_.dataPeopleRoomsCount = dataSearch.Rooms.length;
                _this_.isInternalPackage = dataSearch.isInternal;

                console.log(JSON.stringify(dataSearch.Rooms));
                localStorage.setItem("dataCountRoom", dataSearch.Rooms.length);
                localStorage.setItem("dataPeopleRoomsLocalStorage", JSON.stringify(dataSearch.Rooms));
                localStorage.setItem("originNameFirst", JSON.stringify(dataSearch.NameDeparture));
                localStorage.setItem("destinationNameFirst", JSON.stringify(dataSearch.NameArrival));
            }).catch(function (error) {
                // your action on error success
                console.log(error.response.data);

            });
        },
        deleteInput(type) {
            if (type == 'dept') {
                document.getElementById("cityDeparture").value = "";
            } else {
                document.getElementById("cityDestination").value = "";
            }

        },
        getListCityOrigin() {
            let cityIata = document.getElementById("cityDeparture").value;

            console.log(cityIata);

            if (cityIata.length >= 3) {
                if (cityIata == '') {
                    this.infoCities = "";
                } else {
                    let _this = this;
                    axios.post(amadeusPath + 'infoGds',
                        {
                            method: 'flightRoutesSearchDeparture',
                            search_input: cityIata,
                        },
                        {
                            'Content-Type': 'application/json'
                        }).then(function (response) {
                        console.log(response.data.result);
                        setTimeout(function () {
                            _this.infoCities = response.data.result;
                            document.getElementById("searchDepartureList").style.display = "block"
                        }, 1000);

                    }).catch(function (error) {
                        // your action on error success
                        console.log(error);
                    });
                }
            } else {
                document.getElementById("searchDepartureList").style.display = "none"
            }


        },
        selectCity(city, type) {

            if (type == 'dept') {
                this.origin = city.city_nameFa;
                this.originIata = city.departure_code;
                this.isInternalPackage = (city.route_type == 'portal') ? false : true;

                console.log(city.route_type);
                // document.getElementById('departureSelected').value = city.departure_code;
                document.getElementById('cityDeparture').value = city.city_nameFa;
                document.getElementById("searchDepartureList").style.display = "none";
            } else {

                console.log(city);
                this.destination = city.city_nameFa;
                this.destinationIata = city.arrival_code;
                this.isInternalPackage = (city.route_type == 'portal') ? false : true;
                console.log(city.route_type);
                // document.getElementById('arrivalSelected').value = city.departure_code;
                document.getElementById('cityDestination').value = city.city_nameFa;
                document.getElementById("searchArrivalList").style.display = "none"
            }

        },
        getListCityDestination() {

            let cityIata = document.getElementById("cityDestination").value;
            if (cityIata.length >= 3) {
                if (cityIata == '') {
                    this.infoCitiesDestination = "";
                } else {
                    let _this = this;
                    axios.post(amadeusPath + 'infoGds',
                        {
                            method: 'flightRoutesSearchArrival',
                            departure_code: this.originIata,
                            search_input: cityIata,
                            route_type: this.isInternalPackage,
                        },
                        {
                            'Content-Type': 'application/json'
                        }).then(function (response) {
                        console.log(response.data.result);
                        _this.infoCitiesDestination = response.data.result;

                        setTimeout(function () {
                            document.getElementById("searchArrivalList").style.display = "block"
                        }, 1000);

                    }).catch(function (error) {
                        // your action on error success
                        console.log(error);
                    });
                }
            } else {
                document.getElementById("searchArrivalList").style.display = "none"
            }
        },
        searchPackge() {
            let urlBase = document.URL;

        }
    },
    created() {
    },
    mounted() {
        this.initialInformation();

    }
});

Vue.component('loader-search-package', {
    props: ['originName', 'destinationCity'],
    template: `
      <div>
      <div id="loader-page" class="lazy-loader-parent ">
        <div class="loader-page container site-bg-main-color">
          <div class="parent-in row">
            <div class="loader-txt">
              <div id="flight_loader">
                                  <span class="loader-date">
                              در حال جستجو
                                  </span>
                <div class="wrapper">

                  <div class="locstart"></div>
                  <div class="flightpath">
                    <div class="airplane"></div>
                  </div>
                  <div class="locend"></div>
                </div>
              </div>

              <div class="loader-distinc">
                در حال جستجوی بهترین قیمت ها از
                <span> %% originName %%</span>
                به
                <span>%% destinationCity %%</span>
                برای شما هستیم
              </div>
            </div>
            <!-- <div class="wrapper2"></div>
               <div class="marquee"><p>لطفا منتظر بمانید...</p></div>-->
          </div>

        </div>
      </div>
      </div>
    `,

    data: function () {
        return {
            originCity: '',
            destinationCity: '',
        }
    },
    delimiters: ['%%', '%%'],
    mounted() {
        this.originCity = localStorage.getItem('originNameFirst');
        this.destinationCity = localStorage.getItem('destinationNameFirst');
    }
})

Vue.component('components-package', {
    props: ['dataCountRoom'],
    template: `
      <div>

      <div class="modal_vue" v-if="showModal">
        <div class="" name="modal">
          <div class="modal-mask">
            <div class="modal-wrapper">
              <div class="modal-large">
                <div class="modal-content">
                  <div class="modal-header site-bg-main-color">
                    <h4 class="modal-title">انتخاب پرواز</h4>
                    <button type="button" class="close" @click="showModal=false">
                      <span aria-hidden="true">&times;</span>
                    </button>

                  </div>
                  <div class="modal-body">
                    <div class="choice_flight" v-for="(flight,keyFlight) in dataFlight"
                         :key="keyFlight">

                      <div class="child_choice_flight">
                        <div class="col-md-9 col-p-5">
                          <div class="parrent_flights">
                            <div class="Went_flight_tour">
                              <div class="title_flight">
                                <h6>پرواز رفت - %% flight.FlightType %%</h6>
                              </div>
                              <ul> 
                                <li>
                                  <div :class="'yata_img ' +flight.dept[0].Airline ">
                                      <img :src="flight.dept[0].AirlineLogo" :alt="flight.dept[0].Airline" class='package-airline-logo'>
                                  </div>
                                </li>
                                <li>
                                  <div class="airlines-info destination">
                                    <span class="city_name">%% flight.dept[0].DepartureCity %%</span>
                                    :
                                    <span class="time_went_tour">%% flight.dept[0].DepartureTime %%</span>
                                  </div>
                                </li>
                                <li>
                                  <div class="path_air site-bg-main-color-before">
                                    <span class="svg_flight site-bg-main-color-before site-bg-main-color-after">
                                        <svg class="site-bg-svg-color" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                             y="0px"
                                             viewBox="0 0 193.921 193.921"
                                             style="enable-background:new 0 0 193.921 193.921;"
                                             xml:space="preserve">
                                                <path d="M193.887,111.272c-0.188-1.625-1.167-3.047-2.617-3.805l-0.194-0.091c-0.447-0.187-11.015-4.581-17.491-5.49
                                                    c-1.228-0.173-2.52,0.068-3.704,0.661l-21.749,7.706c-4.243-2.182-20.33-10.448-39.28-20.116l44.797-23.602
                                                    c1.317-0.694,2.084-1.884,2.049-3.183c-0.034-1.298-0.862-2.445-2.215-3.068l-15.1-6.964c-1.449-0.668-3.752-0.932-5.345-0.592
                                                    L64.221,67.516C50.06,60.409,38.373,54.646,33.5,52.492c-3.577-1.581-7.926-2.378-12.925-2.378c-8.249,0-18.341,2.371-20.206,5.87
                                                    c-0.073,0.134-4.997,14.742,23.441,31.09l106.053,54.043c0.106,0.05,2.635,1.316,5.095,1.748c4.163,0.731,8.671,0.943,13.308,0.943
                                                    h1.344c0.643,0,1.275,0,1.896,0h0.419v-0.148c3,0,5.204-1.298,5.558-1.543l34.687-26.439l0.082-0.099
                                                    C193.487,114.511,194.073,112.903,193.887,111.272z M151.922,140.995l0.001,0v0.016L151.922,140.995z"/>

                                                </svg>

                                    </span>
                                  </div>
                                </li>
                                <li>
                                  <div class="airlines-info destination">
                                    <span class="city_name">%% flight.dept[0].ArrivalCity %%</span>
                                    :
                                    <span class="time_went_tour">%% flight.dept[0].ArrivalTime %%</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                            <div class="return_flight_tour">
                              <div class="title_flight">
                                <h6>پرواز برگشت - %% flight.FlightType %%</h6>

                              </div>
                              <ul>
                                <li>
                                  <div :class=" 'yata_img ' + flight.return[0].Airline">
                                      <img :src="flight.return[0].AirlineLogo" :alt="flight.return[0].Airline" class='package-airline-logo'>
                                  </div>
                                </li>
                                <li>
                                  <div class="airlines-info destination">
                                    <span class="city_name">%% flight.return[0].DepartureCity %%</span>
                                    :
                                    <span class="time_went_tour">%% flight.return[0].DepartureTime %%</span>
                                  </div>
                                </li>
                                <li>
                                  <div class="path_air site-bg-main-color-before">
                                    <span class="svg_flight site-bg-main-color-before site-bg-main-color-after">
                                        <svg class="site-bg-svg-color" version="1.1" id="Capa_1"
                                             xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                             y="0px"
                                             viewBox="0 0 193.921 193.921"
                                             style="enable-background:new 0 0 193.921 193.921;"
                                             xml:space="preserve">
                                                <path d="M193.887,111.272c-0.188-1.625-1.167-3.047-2.617-3.805l-0.194-0.091c-0.447-0.187-11.015-4.581-17.491-5.49
                                                    c-1.228-0.173-2.52,0.068-3.704,0.661l-21.749,7.706c-4.243-2.182-20.33-10.448-39.28-20.116l44.797-23.602
                                                    c1.317-0.694,2.084-1.884,2.049-3.183c-0.034-1.298-0.862-2.445-2.215-3.068l-15.1-6.964c-1.449-0.668-3.752-0.932-5.345-0.592
                                                    L64.221,67.516C50.06,60.409,38.373,54.646,33.5,52.492c-3.577-1.581-7.926-2.378-12.925-2.378c-8.249,0-18.341,2.371-20.206,5.87
                                                    c-0.073,0.134-4.997,14.742,23.441,31.09l106.053,54.043c0.106,0.05,2.635,1.316,5.095,1.748c4.163,0.731,8.671,0.943,13.308,0.943
                                                    h1.344c0.643,0,1.275,0,1.896,0h0.419v-0.148c3,0,5.204-1.298,5.558-1.543l34.687-26.439l0.082-0.099
                                                    C193.487,114.511,194.073,112.903,193.887,111.272z M151.922,140.995l0.001,0v0.016L151.922,140.995z"/>

                                                </svg>
                                    </span>
                                  </div>
                                </li>
                                <li>
                                  <div class="airlines-info destination">
                                    <span class="city_name">%% flight.return[0].ArrivalCity %%</span>
                                    :
                                    <span class="time_went_tour">%% flight.return[0].ArrivalTime %%</span>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>

                        </div>
                        <div class="col-md-3 col-p-5">

                          <div class="inner-avlbl-itm ">
                              <span class="iranL priceSortAdt">
                                <i class="iranB CurrencyCal"
                                   data-amount="123745950">%% numberFormat(flight.AdtPrice) %%</i>
                                            <span class="CurrencyText">ريال</span>
                              </span>
                            <a class="international-available-btn site-bg-main-color "
                               @click="selectReplacedFlight(flight)"> انتخاب پرواز </a>
                          </div>

                        </div>

                        <div class="international-available-details">

                          <div class="international-available-airlines-detail-tittle">
                                 <span class="iranB txt13 lh25 displayb txtRight">
                                     <i class="fa fa-circle site-main-text-color "></i>پرواز رفت</span>
                            <div v-for="(flightDept,KeyFlightDeptRoute) in flight.dept"
                                 :key="KeyFlightDeptRoute">
                              <template v-if="isInternal">
                                <div class=" international-available-airlines-detail  site-border-right-main-color">

                                  <div class="international-available-airlines-logo-detail">
                                    <img :src="flightDept.AirlineLogo"
                                         alt="%%flightDept.Airline%%"
                                         title="%%flightDept.AirlineName%%" width="30"
                                         height="30">
                                  </div>

                                  <div class="international-available-airlines-info-detail side-logo-detail">
                                  <span class="openB airline-name-detail txt13 displayib">هواپیما :هواپیمایی
                                    %% flightDept.Airline %%</span>
                                    <span class="iranL txt11 displayib">شماره پرواز:%% flightDept.flightNo %%</span>
                                    <span class="iranL txt11 displayib">%% flightDept.SeatClass %%</span>
                                    <span class="iranL txt11 displayib"
                                          v-if="flightDept.Capacity > 9">نفر+10</span>
                                    <span class="iranL txt11 displayib"
                                          v-else>نفر%% flightDept.Capacity %%</span>
                                  </div>
                                </div>

                                <div class="international-available-airlines-detail   site-border-right-main-color">

                                  <div class="airlines-detail-box origin-detail-box">

                                    <span class="open txt11 displayb">%% flightDept.DepartureCity %%</span>

                                    <span class="openB txt11 displayb">%% flightDept.DepartureDate %%
                                      -%% flightDept.DepartureTime %%</span>

                                  </div>

                                  <div class="airlines-detail-box destination-detail-box">
                                    <span class="open txt11 displayb">%% flightDept.ArrivalCity %%</span>
                                    <span class="openB txt11 displayb">%% flightDept.ArrivalDate %%
                                      - %% flightDept.ArrivalTime %%</span>
                                  </div>
                                  <div class="airlines-detail-box details-detail-box ">
                                        <span class="padt0 iranb  lh18 displayb" v-if="isInternal">
                                            بار مجاز:<i class="iranNum">1 بسته(هر بسته %% flightDept.Baggage %% کیلو گرم)</i>
                                        </span>

                                    <span class="padt0 iranb  lh18 displayb" v-else>
                                            بار مجاز:<i class="iranNum">%% flightDept.Baggage %% بسته(هر بسته
                                      %% flightDept.BaggageType %% کیلو گرم)</i>
                                        </span>
                                    <span class="padt0 iranL  lh18 displayb">
                                            کلاس نرخی  :  <i class="openL">%% flightDept.CabinType %% </i>
                                        </span>
                                  </div>
                                </div>
                              </template>
                              <template v-else>
                                <div class=" international-available-airlines-detail  site-border-right-main-color">

                                  <div class="international-available-airlines-logo-detail">
                                    <img :src="flightDept.AirlineLogo"
                                         alt="%%flightDept.Airline%%"
                                         title="%%flightDept.AirlineName%%" width="30"
                                         height="30">
                                  </div>

                                  <div class="international-available-airlines-info-detail side-logo-detail">
                                  <span class="openB airline-name-detail txt13 displayib">هواپیما :هواپیمایی
                                    %% flightDept.Airline %%</span>
                                    <span class="iranL txt11 displayib">شماره پرواز:%% flightDept.flightNo %%</span>
                                    <span class="iranL txt11 displayib">%% flightDept.SeatClass %%</span>
                                    <span class="iranL txt11 displayib"
                                          v-if="flightDept.Capacity > 9">نفر+10</span>
                                    <span class="iranL txt11 displayib"
                                          v-else>نفر%% flightDept.Capacity %%</span>
                                  </div>
                                </div>

                                <div class="international-available-airlines-detail   site-border-right-main-color">

                                  <div class="airlines-detail-box origin-detail-box">

                                    <span class="open txt11 displayb">%% flightDept.DepartureCity %%</span>

                                    <span class="openB txt11 displayb">%% flightDept.DepartureDate %%
                                      -%% flightDept.DepartureTime %%</span>

                                  </div>

                                  <div class="airlines-detail-box destination-detail-box">
                                    <span class="open txt11 displayb">%% flightDept.ArrivalCity %%</span>
                                    <span class="openB txt11 displayb">%% flightDept.ArrivalDate %%
                                      - %% flightDept.ArrivalTime %%</span>
                                  </div>
                                  <div class="airlines-detail-box details-detail-box ">
                                        <span class="padt0 iranb  lh18 displayb" v-if="isInternal">
                                            بار مجاز:<i class="iranNum">1 بسته(هر بسته %% flightDept.Baggage %% کیلو گرم)</i>
                                        </span>

                                    <span class="padt0 iranb  lh18 displayb" v-else>
                                            بار مجاز:<i class="iranNum">%% flightDept.Baggage %% بسته(هر بسته
                                      %% flightDept.BaggageType %% کیلو گرم)</i>
                                        </span>
                                    <span class="padt0 iranL  lh18 displayb">
                                            کلاس نرخی  :  <i class="openL">%% flightDept.CabinType %% </i>
                                        </span>
                                  </div>
                                </div>

                                <div class="international-available-airlines-detail airlines-stops-time">
                                        <span class="iranB txt13 lh25 displayib txtRight">
                                            <span class=" iranb  lh18 displayib"> توقف در 
                                                <span class="open txt13 displayib">دوحه(فرودگاه حمد)</span>
                                            </span>
                                        <span class="open txt13 lh25 displayib fltl">
                                            00 ساعت و 50دقیقه 
                                        </span>
                                </div>

                                <div class=" international-available-airlines-detail  site-border-right-main-color">

                                  <div class="international-available-airlines-logo-detail">
                                            <img src="https://s360online.iran-tech.com/gds/pic/airline/475879189QATAR.png"
                                         alt="QR" title="QR" width="30" height="30">
                                  </div>

                                  <div class="international-available-airlines-info-detail side-logo-detail">
                                    <!--                                                                <span class="openB airline-name-detail txt13 displayib">Airline Name</span>-->

                                    <span
                                        class="openB airline-name-detail txt13 displayib">هواپیما:هواپیمایی قطر ایرویز</span>
                                    <span class="iranL txt11 displayib">شماره پرواز : 1002</span>
                                    <span class="iranL txt11 displayib">اکونومی</span>
                                    <span class="iranL txt11 displayib"> +10نفر </span>
                                  </div>
                                </div>

                                <div class="international-available-airlines-detail site-border-right-main-color">
                                  <div class="airlines-detail-box origin-detail-box">
                                    <span class="open txt11 displayb">دوحه</span>
                                    <span class="open txt11 displayb">فرودگاه حمد</span>
                                    <span class="openB txt11 displayb">زمان حرکت : 01:00 - 1400/02/01</span>
                                  </div>

                                  <div class="airlines-detail-box destination-detail-box">
                                    <span class="open txt11 displayb">دبی</span>
                                    <span class="open txt11 displayb">فرودگاه دبی</span>
                                    <span
                                        class="openB txt11 displayb">زمان رسیدن : 03:10:00 - 1400/02/01 </span>
                                  </div>

                                  <div class="airlines-detail-box details-detail-box ">
                                        <span class="padt0 iranb  lh18 displayb">
                                            بار مجاز :  <i class="iranNum">1 بسته(هر بسته 25 کیلو گرم)</i>
                                        </span>
                                    <span class="padt0 iranL  lh18 displayb">
                                            کلاس نرخی :  <i class="openL">Q </i>
                                        </span>
                                    <span class="padt0 iranL  lh18 displayb">  نوع هواپیما :   <i class="openL">نامشخص </i>
                                    </span>
                                  </div>
                                </div>
                              </template>

                            </div>
                            <hr/>

                            <!-- برگشت -->
                            <span class="iranB txt13 lh25 displayb txtRight border-solid"><i
                                class="fa fa-circle site-main-text-color "></i>پرواز برگشت</span>

                            <div v-for="(flightReturn,KeyFlightReturnRoute) in flight.return"
                                 :key="KeyFlightReturnRoute">
                              <template v-if="isInternal">
                                <div class=" international-available-airlines-detail  site-border-right-main-color">

                                  <div class="international-available-airlines-logo-detail">
                                    <img :src="flightReturn.AirlineLogo"
                                         alt="%% flightReturn.Airline %%"
                                         title="%% flightReturn.AirlineName %%" width="30"
                                         height="30">
                                  </div>

                                  <div class="international-available-airlines-info-detail side-logo-detail">
                                  <span class="openB airline-name-detail txt13 displayib">هواپیما :هواپیمایی
                                    %% flightReturn.Airline %%</span>
                                    <span class="iranL txt11 displayib">شماره پرواز:%% flightReturn.flightNo %%</span>
                                    <span class="iranL txt11 displayib">%% flightReturn.SeatClass %%</span>
                                    <span class="iranL txt11 displayib"
                                          v-if="flightReturn.Capacity > 9">نفر+10</span>
                                    <span class="iranL txt11 displayib"
                                          v-else>نفر%% flightReturn.Capacity %%</span>
                                  </div>
                                </div>

                                <div class="international-available-airlines-detail   site-border-right-main-color">

                                  <div class="airlines-detail-box origin-detail-box">

                                    <span class="open txt11 displayb">%% flightReturn.DepartureCity %%</span>

                                    <span class="openB txt11 displayb">%% flightReturn.DepartureDate %%
                                      -%% flightReturn.DepartureTime %%</span>

                                  </div>

                                  <div class="airlines-detail-box destination-detail-box">
                                    <span class="open txt11 displayb">%% flightReturn.ArrivalCity %%</span>
                                    <span class="openB txt11 displayb">%% flightReturn.ArrivalDate %%
                                      - %% flightReturn.ArrivalTime %%</span>
                                  </div>
                                  <div class="airlines-detail-box details-detail-box ">
                                        <span class="padt0 iranb  lh18 displayb" v-if="isInternal">
                                            بار مجاز:<i class="iranNum">1 بسته(هر بسته %% flightReturn.Baggage %% کیلو گرم)</i>
                                        </span>

                                    <span class="padt0 iranb  lh18 displayb" v-else>
                                            بار مجاز:<i class="iranNum">%% flightReturn.Baggage %% بسته(هر بسته
                                      %% flightReturn.BaggageType %% کیلو گرم)</i>
                                        </span>
                                    <span class="padt0 iranL  lh18 displayb">
                                            کلاس نرخی  :  <i class="openL">%% flightReturn.CabinType %% </i>
                                        </span>
                                  </div>
                                </div>
                              </template>
                              <template v-else>
                                <div class=" international-available-airlines-detail  site-border-right-main-color">

                                  <div class="international-available-airlines-logo-detail">
                                    <img :src="flightReturn.AirlineLogo"
                                         alt="%%flightReturn.Airline%%"
                                         title="%%flightReturn.AirlineName%%" width="30"
                                         height="30">
                                  </div>

                                  <div class="international-available-airlines-info-detail side-logo-detail">
                                  <span class="openB airline-name-detail txt13 displayib">هواپیما :هواپیمایی
                                    %% flightReturn.Airline %%</span>
                                    <span class="iranL txt11 displayib">شماره پرواز:%% flightReturn.flightNo %%</span>
                                    <span class="iranL txt11 displayib">%% flightReturn.SeatClass %%</span>
                                    <span class="iranL txt11 displayib"
                                          v-if="flightReturn.Capacity > 9">نفر+10</span>
                                    <span class="iranL txt11 displayib"
                                          v-else>نفر%% flightReturn.Capacity %%</span>
                                  </div>
                                </div>

                                <div class="international-available-airlines-detail   site-border-right-main-color">

                                  <div class="airlines-detail-box origin-detail-box">

                                    <span class="open txt11 displayb">%% flightReturn.DepartureCity %%</span>

                                    <span class="openB txt11 displayb">%% flightReturn.DepartureDate %%
                                      -%% flightReturn.DepartureTime %%</span>

                                  </div>

                                  <div class="airlines-detail-box destination-detail-box">
                                    <span class="open txt11 displayb">%% flightReturn.ArrivalCity %%</span>
                                    <span class="openB txt11 displayb">%% flightReturn.ArrivalDate %%
                                      - %% flightReturn.ArrivalTime %%</span>
                                  </div>
                                  <div class="airlines-detail-box details-detail-box ">
                                        <span class="padt0 iranb  lh18 displayb">
                                            بار مجاز:<i class="iranNum">1 بسته(هر بسته 25 کیلو گرم)</i>
                                        </span>
                                    <span class="padt0 iranL  lh18 displayb">
                                            کلاس نرخی  :  <i class="openL">Q </i>
                                        </span>
                                    <span class="padt0 iranL  lh18 displayb">  نوع هواپیما   : <i class="openL">نامشخص   </i>
                                    </span>
                                  </div>
                                </div>

                              </template>
                            </div>

                          </div>

                          <span class="international-available-detail-btn slideDownHotelDescription">
                                    <div class="my-more-info"> جزییات بیشتر<i class="fa fa-angle-down"></i></div>
                                </span>
                          <span class="international-available-detail-btn slideUpHotelDescription displayiN"><i
                              class="fa fa-angle-up"></i></span>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="filter_box">
        <div class="filter_names">
          <div class="name_filter">
            <span>رزرو(پرواز + هتل) </span>
            <i>/</i>
            <span>%% nameArrival %%</span>
          </div>
          <div class="number_result">
            <span>%% totalCountTour %%</span>
            <span>مورد در</span>
            <span>%% nameArrival %%</span>
            <span>یافت شد</span>
          </div>
        </div>
        <div class="filter_options sorting2">
   

            <span>
                <svg enable-background="new 0 0 24 24" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                <g>
                    <path
                        d="m7.5 21c-.076 0-.153-.018-.224-.053-.169-.085-.276-.258-.276-.447v-8.171c0-.395-.16-.782-.44-1.061l-5.827-5.824c-.473-.472-.733-1.1-.733-1.768v-2.176c0-.827.673-1.5 1.5-1.5h16c.827 0 1.5.673 1.5 1.5v2.176c0 .668-.26 1.296-.733 1.769l-5.827 5.823c-.28.279-.44.666-.44 1.061v4.671c0 .47-.224.918-.6 1.2l-3.6 2.7c-.088.066-.194.1-.3.1zm-6-20c-.276 0-.5.224-.5.5v2.176c0 .401.156.778.44 1.062l5.827 5.823c.466.464.733 1.109.733 1.768v7.171l2.8-2.1c.125-.094.2-.243.2-.4v-4.671c0-.659.267-1.303.733-1.769l5.827-5.823c.284-.283.44-.66.44-1.061v-2.176c0-.276-.224-.5-.5-.5z"/>
                </g>
                <g>
                    <path
                        d="m22.5 24h-7c-.827 0-1.5-.673-1.5-1.5v-9c0-.827.673-1.5 1.5-1.5h7c.827 0 1.5.673 1.5 1.5v9c0 .827-.673 1.5-1.5 1.5zm-7-11c-.276 0-.5.224-.5.5v9c0 .276.224.5.5.5h7c.276 0 .5-.224.5-.5v-9c0-.276-.224-.5-.5-.5z"/>
                </g>
                <g>
                    <path d="m20.5 17h-3c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h3c.276 0 .5.224.5.5s-.224.5-.5.5z"/>
                </g>
                <g>
                    <path d="m20.5 20h-3c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h3c.276 0 .5.224.5.5s-.224.5-.5.5z"/>
                </g>
            </svg>
                مرتب سازی بر اساس :
            </span>
          <div class="sorting-inner sorting-active-color-main">
                   <span class="svg">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 26 26">
                <g>
                    <path d="M11,3H1C0.4,3,0,3.4,0,4v2c0,0.6,0.4,1,1,1h10c0.6,0,1-0.4,1-1V4C12,3.4,11.6,3,11,3z"></path>
                    <path d="m11,11h-10c-0.6,0-1,0.4-1,1v2c0,0.6 0.4,1 1,1h10c0.6,0 1-0.4 1-1v-2c0-0.6-0.4-1-1-1z"></path>
                    <path d="m11,19h-10c-0.6,0-1,0.4-1,1v2c0,0.6 0.4,1 1,1h10c0.6,0 1-0.4 1-1v-2c0-0.6-0.4-1-1-1z"></path>
                    <path d="m25.7,15.3l-1.4-1.4c-0.2-0.2-0.5-0.3-0.7-0.3-0.3,0-0.5,0.1-0.7,0.3l-2,2c-0.3,0.3-0.9,0.1-0.9-0.4v-13.5c0-0.5-0.5-1-1-1h-2c-0.5,0-1,0.5-1,1v22c0,0.3 0.1,0.5 0.3,0.7s0.5,0.3 0.7,0.3c0.3,0 0.5-0.1 0.7-0.3l8-8c0.2-0.2 0.3-0.4 0.3-0.7 0-0.3-0.1-0.5-0.3-0.7z"></path>
                </g>
            </svg>
        </span>
            <span class="active text-price-sort" @click="sortPrice(dataHotelResult)">قیمت ریالی</span>
          </div>
          <div id="sort_hotel" class="sorting-inner star_sort">
            <span @click="sortStar(dataHotelResult)">ستاره هتل</span>
          </div>

        </div>

      </div>
      <div v-show="isError">
        <div class="content_tour" v-for="(Hotel,keyHotel) in dataHotelResult" :key="keyHotel">
          <div class="card_tour_search">
            <div class="image_tour">
              <img :src="Hotel.FeaturedPicture" alt="">
            </div>
            <div class="content_search_tour">
              <div class="title_package_">
                <h4 class="hotel_name">
                  %% Hotel.HotelName %%
                </h4>
                <div :class="'rating rating_'+ Hotel.HotelStars">
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                </div>
              </div>
                <span class="icon_change" data-toggle="modal" data-target="#flight_search">
                   <button id="show-modal" class="btn-change-flight"
                           @click="showModal = true">تغییر پرواز</button>
               </span>
              <div class="flights_tour">
                <div class="Went_flight_tour">
                  <div class="title_flight">
                    <h6>  پرواز رفت - %% dataSpecificFlight.FlightType %%</h6>
                   
                  </div>
                  <ul>
                    <li>
                      <div :class="'yata_img ' + dataSpecificFlight.dept[0].Airline ">
                          <img :src="dataSpecificFlight.dept[0].AirlineLogo" :alt="dataSpecificFlight.dept[0].Airline" class='package-airline-logo'>
                      </div>
                    </li>
                    <li>
                      <div class="airlines-info destination">
                        <span class="city_name">%% dataSpecificFlight.dept[0].DepartureCity %%</span>
                        :
                        <span class="time_went_tour">%% dataSpecificFlight.DepartureTimeDept %%</span>
                      </div>
                    </li>
                    <li>
                      <div class="path_air site-bg-main-color-before">
                                    <span class="svg_flight site-bg-main-color-before site-bg-main-color-after">
                                        <svg class="site-bg-svg-color" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                             y="0px"
                                             viewBox="0 0 193.921 193.921"
                                             style="enable-background:new 0 0 193.921 193.921;"
                                             xml:space="preserve">
                                                <path d="M193.887,111.272c-0.188-1.625-1.167-3.047-2.617-3.805l-0.194-0.091c-0.447-0.187-11.015-4.581-17.491-5.49
                                                    c-1.228-0.173-2.52,0.068-3.704,0.661l-21.749,7.706c-4.243-2.182-20.33-10.448-39.28-20.116l44.797-23.602
                                                    c1.317-0.694,2.084-1.884,2.049-3.183c-0.034-1.298-0.862-2.445-2.215-3.068l-15.1-6.964c-1.449-0.668-3.752-0.932-5.345-0.592
                                                    L64.221,67.516C50.06,60.409,38.373,54.646,33.5,52.492c-3.577-1.581-7.926-2.378-12.925-2.378c-8.249,0-18.341,2.371-20.206,5.87
                                                    c-0.073,0.134-4.997,14.742,23.441,31.09l106.053,54.043c0.106,0.05,2.635,1.316,5.095,1.748c4.163,0.731,8.671,0.943,13.308,0.943
                                                    h1.344c0.643,0,1.275,0,1.896,0h0.419v-0.148c3,0,5.204-1.298,5.558-1.543l34.687-26.439l0.082-0.099
                                                    C193.487,114.511,194.073,112.903,193.887,111.272z M151.922,140.995l0.001,0v0.016L151.922,140.995z"/>

                                                </svg>

                                    </span>
                      </div>
                    </li>
                    <li>
                      <div class="airlines-info destination">
                        <span class="city_name">%% dataSpecificFlight.dept[0].ArrivalCity %%</span>
                        :
                        <span class="time_went_tour">%% dataSpecificFlight.ArrivalTimeDept %%</span>
                      </div>
                    </li>
                  </ul>
                </div>

                <div class="return_flight_tour">
                  <div class="title_flight">
                    <h6> پرواز برگشت - %% dataSpecificFlight.FlightType %%</h6>

                  </div>
                  <ul>
                    <li>
                      <div :class=" 'yata_img ' + dataSpecificFlight.return[0].Airline">
                          <img :src="dataSpecificFlight.return[0].AirlineLogo" :alt="dataSpecificFlight.return[0].Airline" class='package-airline-logo'>
                      </div>
                    </li>
                    <li>
                      <div class="airlines-info destination">
                        <span class="city_name">%% dataSpecificFlight.return[0].DepartureCity %%</span>
                        :
                        <span class="time_went_tour">%% dataSpecificFlight.DepartureTimeReturn %%</span>
                      </div>
                    </li>
                    <li>
                      <div class="path_air site-bg-main-color-before">
                                    <span class="svg_flight site-bg-main-color-before site-bg-main-color-after">
                                        <svg class="site-bg-svg-color" version="1.1" id="Capa_1"
                                             xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                             y="0px"
                                             viewBox="0 0 193.921 193.921"
                                             style="enable-background:new 0 0 193.921 193.921;"
                                             xml:space="preserve">
                                                <path d="M193.887,111.272c-0.188-1.625-1.167-3.047-2.617-3.805l-0.194-0.091c-0.447-0.187-11.015-4.581-17.491-5.49
                                                    c-1.228-0.173-2.52,0.068-3.704,0.661l-21.749,7.706c-4.243-2.182-20.33-10.448-39.28-20.116l44.797-23.602
                                                    c1.317-0.694,2.084-1.884,2.049-3.183c-0.034-1.298-0.862-2.445-2.215-3.068l-15.1-6.964c-1.449-0.668-3.752-0.932-5.345-0.592
                                                    L64.221,67.516C50.06,60.409,38.373,54.646,33.5,52.492c-3.577-1.581-7.926-2.378-12.925-2.378c-8.249,0-18.341,2.371-20.206,5.87
                                                    c-0.073,0.134-4.997,14.742,23.441,31.09l106.053,54.043c0.106,0.05,2.635,1.316,5.095,1.748c4.163,0.731,8.671,0.943,13.308,0.943
                                                    h1.344c0.643,0,1.275,0,1.896,0h0.419v-0.148c3,0,5.204-1.298,5.558-1.543l34.687-26.439l0.082-0.099
                                                    C193.487,114.511,194.073,112.903,193.887,111.272z M151.922,140.995l0.001,0v0.016L151.922,140.995z"/>

                                                </svg>
                                    </span>
                      </div>
                    </li>
                    <li>
                      <div class="airlines-info destination">
                        <span class="city_name">%% dataSpecificFlight.return[0].ArrivalCity %%</span>
                        :
                        <span class="time_went_tour">%% dataSpecificFlight.ArrivalTimeReturn %%</span>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="price_box_tour">
              <div class="">
                <h4 class="title_price">مجموع قیمت برای <i> %% totalPerson %% نفر </i></h4>
                <span class="days_in_tour">
                    مدت اقامت : <i>  %% totalNight %% شب</i>
                </span>
                <div class="price_tour">
                  <h5 ref="totalPricSingle"> %% sumPrice(Hotel.MinPrice, dataSpecificFlight.AdtPrice) %%</h5>
                  <span>ریال</span></div>
              </div>
              <div class="reserve_room_tour">
                <a href="javascript:" class="link_tour btn site-bg-main-color"
                   @click="showRoomsHotel(Hotel.HotelIndex,dataHotel.RequestNumber,dataHotel.History.City,dataHotel.History.StartDate,Hotel.HotelStars,keyHotel)">مشاهده
                  و رزرو اتاق </a>
              </div>
            </div>
          </div>

          <div class="card_room_tour panel">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab"
                   role="tab" aria-controls="roomSelect" aria-selected="true">انتخاب اتاق</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" role="tab"
                   aria-controls="Went" aria-selected="false">اطلاعات رفت</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" role="tab"
                   aria-controls="return" aria-selected="false">اطلاعات برگشت</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab"
                   role="tab" aria-controls="hotelLocation" aria-selected="false">موقعیت هتل</a>
              </li>
            </ul>
            <div class="tab-content-package">
              <div class="loaderPublicForHotel" v-if="loading"></div>
              <div class="tab-pane  roomSelect active" role="tabpanel"
                   aria-labelledby="roomSelect-tab" :id="'hotel' + keyHotel"
                   v-if="comapreRowHotel(Hotel.HotelIndex,hotelIndexSelected)">
                <rooms-hotel :rooms="dataRooms" :MinPrice="Hotel.MinPrice"
                             :dataFlightsSpcific="dataSpecificFlight" :isInternal="isInternal"
                             :isErrorRoom="isErrorRoom" :messageError="messageError"
                             :allpeopale="totalPerson"
                             @calculateTotalPrice="updateSumPrice"
                             :keySingleHotel="keyHotel"></rooms-hotel>
                <div class="bottom_row">
                  <div class="more_room_div">
                    <div>
                      <span>مشاهده همه اتاق ها </span>
                      <span class="roomNumber"> ( مجموع %% countRooms %% اتاق )</span>
                    </div>
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 451.847 451.847"
                         style="enable-background:new 0 0 451.847 451.847;"
                         xml:space="preserve">
                                    <g>
                                        <path d="M225.923,354.706c-8.098,0-16.195-3.092-22.369-9.263L9.27,151.157c-12.359-12.359-12.359-32.397,0-44.751
                                            c12.354-12.354,32.388-12.354,44.748,0l171.905,171.915l171.906-171.909c12.359-12.354,32.391-12.354,44.744,0
                                            c12.365,12.354,12.365,32.392,0,44.751L248.292,345.449C242.115,351.621,234.018,354.706,225.923,354.706z"/>
                                    </g>

                                    </svg>
                  </div>
                  <div class="price_reserve_final">
                    <div class="">
                      قیمت نهایی (پرواز + هتل)
                      <span class="final-price"
                            id="FinalPrice"> %% sumPrice(Hotel.MinPrice, dataSpecificFlight.AdtPrice) %%</span>
                      <span>ریال</span>
                    </div>
                    <div class="d-flex flex-wrap align-items-center justify-content-center position-relative">
                    <a href="#" :id="'BtnSelect'+ keyHotel "
                       @click.prevent="sendDataToDetail(totalPrice,dataHotel.RequestNumber,dataSelectRoom,keyHotel,dataTookenSelectRoom)"
                       class="link_tour btn site-bg-main-color">رزرو کنید</a>
                    <a href="" onclick="return false" class="f-loader-check f-loader-check-change"
                       :id="'loader_check'+ keyHotel" style="display:none"></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane Went" role="tabpanel" aria-labelledby="Went-tab">
                <div class="content_information_flight"
                     v-for="(flightDept,keyFlightDept) in dataSpecificFlight.dept" :key="keyFlightDept">
                  <div class="row">
                    <div class="city_name city_start">
                      <i class="icon_svg"></i>
                      <span class="site-main-text-color">%% flightDept.DepartureCode %%</span>
                      <span class="site-main-text-color">%% flightDept.DepartureCity %%</span>
                    </div>

                    <div class="time_went">
                      %% flightDept.DepartureParentRegionName %% - %% flightDept.DepartureTime %%
                    </div>
                  </div>
                  <div class="row flight_infor_row site-bg-color-border-b">
                    <ul class="information_flight">
                      <div :class="'yata_img ' + flightDept.Airline">
                        <span class="logo-airline-ico" v-if="isInternal"></span>
                        <span class="logo-airline-ico" v-else></span>
                        <span class="site-main-text-color">%% flightDept.AirlineName %% </span>
                      </div>
                      <li class="flight_period">
                        <span>مدت پرواز</span>
                        <span class="site-main-text-color"> %% flightDept.TotalOutputFlightDuration %% </span>
                      </li>
                      <li class="flight_number">
                        <span>شماره پرواز</span>
                        <span class="site-main-text-color">%% flightDept.FlightNo %%</span>
                      </li>
                      <li class="flight_class">
                        <span>کلاس پرواز</span>
                        <span class="site-main-text-color">%% flightDept.SeatClass %%</span>
                      </li>
                      <li class="flight_model">
                        <span>نوع هواپیما</span>
                        <span class="site-main-text-color">%% flightDept.Aircraft %%</span>
                      </li>
                    </ul>
                  </div>
                  <div class="row">
                    <div class="city_name city_destination">
                      <span class="site-main-text-color">%% flightDept.ArrivalCode %%</span>
                      <span class="site-main-text-color">%% flightDept.ArrivalCity %%</span>
                    </div>

                    <div class="time_went">
                      %% flightDept.DepartureParentRegionName %% - %% flightDept.ArrivalTime %%
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane return" role="tabpanel" aria-labelledby="return-tab">
                <div class="content_information_flight"
                     v-for="(flightReturn,keyFlightReturn) in dataSpecificFlight.return"
                     :key="keyFlightReturn">
                  <div class="row">
                    <div class="city_name city_start">
                      <i class="icon_svg">

                      </i>
                      <span class="site-main-text-color">%% flightReturn.DepartureCode %%</span>
                      <span class="site-main-text-color">%% flightReturn.DepartureCity %%</span>
                    </div>

                    <div class="time_went">
                      %% flightReturn.DepartureParentRegionName %%
                      - %% flightReturn.DepartureTime %%
                    </div>
                  </div>
                  <div class="row flight_infor_row site-bg-color-border-b">
                    <ul class="information_flight">
                      <div :class=" 'yata_img ' + flightReturn.Airline">
                        <span class="logo-airline-ico" v-if="isInternal"></span>
                        <span class="logo-airline-ico" v-else></span>
                        <span class="site-main-text-color">%% flightReturn.AirlineName %%</span>
                      </div>
                      <li class="flight_period">
                        <span>مدت پرواز</span>
                        <span class="site-main-text-color"> %% flightReturn.TotalOutputFlightDuration %%</span>
                      </li>
                      <li class="flight_number">
                        <span>شماره پرواز</span>
                        <span class="site-main-text-color">%% flightReturn.FlightNo %%</span>
                      </li>
                      <li class="flight_class">
                        <span>کلاس پرواز</span>
                        <span class="site-main-text-color">%% flightReturn.SeatClass %%</span>
                      </li>
                      <li class="flight_model">
                        <span>نوع هواپیما</span>
                        <span class="site-main-text-color">%% flightReturn.AirCraft %%</span>
                      </li>
                    </ul>
                  </div>
                  <div class="row">
                    <div class="city_name city_destination">
                      <span class="site-main-text-color">%% flightReturn.ArrivalCode %%</span>
                      <span class="site-main-text-color">%% flightReturn.ArrivalCity %%</span>
                    </div>
                    <div class="time_went">
                      %% flightReturn.DepartureParentRegionName %%
                      - %% flightReturn.ArrivalTime %%
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane hotelLocation " role="tabpanel"
                   aria-labelledby="hotelLocation-tab">

                <div class="location_hotel">
                  <h4>آدرس:</h4>
                  <span> %% Hotel.ContactInformation.Address %% </span>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div v-show="!isError">
          <div id='show_offline_request'>
              <div class='fullCapacity_div'>
                  <img :src="full_capacity_url" alt="fullCapacity">
                  <h2>  %% errorMessage %%</h2>
              </div>
        </div>
      </div>

      </div>

    `,
    data: function () {
        return {

            dataFlight: [],
            dataHotel: [],
            dataHotelResult: [],
            dataSpecificFlight: {dept: []},
            lang: 'fa',
            totalPerson: 0,
            totalNight: 0,
            dataRooms: [],
            detailHotel: [],
            loading: false,
            showModal: false,
            totalPrice: 0,
            nameArrival: '',
            countRooms: 0,
            PriceSessionId: 0,
            HotelIndex: 0,
            roomToken: 0,
            isInternal: 0,
            dataSelectRoom: [],
            dataDetailSelectHotel: [],
            typeError: '',
            errorMessage: '',
            isError: true,
            isErrorRoom: true,
            messageError: '',
            totalCountTour: 0,
            hotelIndexSelected: 0,
            countRoomsSearch: localStorage.getItem("dataCountRoom"),
            dataRoomsSearch: '',
            SortPriceAsc: true,
            SortStarAsc: true,
            full_capacity_url : ''

        }
    },
    delimiters: ['%%', '%%'],
    methods: {

        comapreRowHotel(HotelIndex, hotelIndexSelected) {

            if (parseInt(HotelIndex) === parseInt(hotelIndexSelected)) {
                return true;
            }
            return false;
        },
        sendDataToDetail(totalPrice, HotelRquestNumber, dataSelectRoom, keyHotel, dataTookenSelectRoom) {
console.log('ddddddddddddddddddddddddddddddddd')
            console.log(totalPrice, HotelRquestNumber, dataSelectRoom, keyHotel, dataTookenSelectRoom)
            var dataSelectedRoom = JSON.parse(JSON.stringify(dataSelectRoom));
            var detailHotel = JSON.parse(JSON.stringify(this.detailHotel));
            var _this = this;


            console.log(dataSelectedRoom);
            document.getElementById('loader_check' + keyHotel).style.display = "block";
            document.getElementById('BtnSelect' + keyHotel).text = "در حال بررسی";
            axios.post(amadeusPath + 'axios',
                {
                    method: 'revalidateFlightPackage',
                    flightID: this.dataSpecificFlight.FlightID,
                    returnFlightID: this.dataSpecificFlight.ReturnFlightID,
                    requestNumber: this.dataSpecificFlight.UniqueCode,
                    sourceID: this.dataSpecificFlight.SourceId,
                    adult: this.dataSpecificFlight.Adult,
                    child: this.dataSpecificFlight.Child,
                    infant: this.dataSpecificFlight.Infant,
                    UserName: this.dataSpecificFlight.UserName,
                },
                {
                    'Content-Type': 'application/json'
                }).then(function (response) {

                console.log('revalidate');
                console.log(response.data.result_status);
                if (response.data.result_status == 'SuccessLogged' || response.data.result_status == 'SuccessNotLoggedIn') {
                    this.countRoomsSearch = localStorage.getItem("dataCountRoom");
                    this.dataRoomsSearch = localStorage.getItem("dataPeopleRoomsLocalStorage");
                    let i;
                    let dataPeopleSelected = {};
                    let DataFinalSelected = {};
                    var JsonDataRoomSearch = JSON.parse(this.dataRoomsSearch);

                    var roomToken = dataSelectedRoom['Rates'][0]['RoomToken'];
                    dataPeopleSelected[roomToken] = {};
                    for (i = 0; i < parseInt(this.countRoomsSearch); i++) {
                        if (parseInt(JsonDataRoomSearch[i].child) > 0) {
                            dataPeopleSelected[roomToken][i] = {};
                            dataPeopleSelected[roomToken][i]['arr'] = parseInt(JsonDataRoomSearch[i].ageChild);
                            dataPeopleSelected[roomToken][i]['count'] = parseInt(JsonDataRoomSearch[i].child);
                        }
                        DataFinalSelected = dataPeopleSelected;
                    }
                    var JsonChild = JSON.stringify(DataFinalSelected);
                    var unique_id = response.data.result_uniq_id;
                    axios.post(amadeusPath + 'axios',
                        {
                            method: 'InsertHotelPackage',
                            detail: detailHotel,
                            SelectedRoom: dataSelectedRoom,
                            countRoomsSelected: _this.countRoomsSearch,
                            JsonChild: JsonChild,
                            PriceSessionId: _this.PriceSessionId,
                        },
                        {
                            'Content-Type': 'application/json'
                        }).then(function (response) {
                        console.log('InsertHotelPackage');
                        console.log(response.data.Status);
                        if (response.data.Status == 'success') {
                            var form = document.getElementById('SendDataToDetailPage');
                            form.setAttribute('method', "post");
                            form.setAttribute('action', amadeusPathByLang + 'detailPassengersPackage');

                            //input 1
                            var hiddenField = document.createElement("input");
                            hiddenField.setAttribute("type", "hidden");
                            hiddenField.setAttribute("name", "RequestNumberFlight");
                            hiddenField.setAttribute("value", _this.dataSpecificFlight.UniqueCode);
                            form.appendChild(hiddenField);
                            //input 2
                            var hiddenField = document.createElement("input");
                            hiddenField.setAttribute("type", "hidden");
                            hiddenField.setAttribute("name", "factorNumberHotel");
                            hiddenField.setAttribute("value", response.data.message);
                            form.appendChild(hiddenField);
                            //input 3
                            var hiddenField = document.createElement("input");
                            hiddenField.setAttribute("type", "hidden");
                            hiddenField.setAttribute("name", "totalPrice");
                            hiddenField.setAttribute("value", totalPrice);
                            form.appendChild(hiddenField);
                            //input 4
                            var hiddenField = document.createElement("input");
                            hiddenField.setAttribute("type", "hidden");
                            hiddenField.setAttribute("name", "temporary");
                            hiddenField.setAttribute("value", unique_id);
                            form.appendChild(hiddenField);

                            //input 5
                            var hiddenField = document.createElement("input");
                            hiddenField.setAttribute("type", "hidden");
                            hiddenField.setAttribute("name", "StartDate");
                            hiddenField.setAttribute("value", _this.dataHotel.History.StartDate);
                            form.appendChild(hiddenField);

                            //input 6
                            var hiddenField = document.createElement("input");
                            hiddenField.setAttribute("type", "hidden");
                            hiddenField.setAttribute("name", "nights");
                            hiddenField.setAttribute("value", _this.totalNight);
                            form.appendChild(hiddenField);

                            //input 7
                            var hiddenField = document.createElement("input");
                            hiddenField.setAttribute("type", "hidden");
                            hiddenField.setAttribute("name", "roomIdSelected");
                            hiddenField.setAttribute("value", dataTookenSelectRoom);
                            form.appendChild(hiddenField);

                            //input 8
                            var hiddenField = document.createElement("input");
                            hiddenField.setAttribute("type", "hidden");
                            hiddenField.setAttribute("name", "isInternal");
                            hiddenField.setAttribute("value", _this.isInternal);
                            form.appendChild(hiddenField);
                            //input 9
                            var hiddenField = document.createElement("input");
                            hiddenField.setAttribute("type", "hidden");
                            hiddenField.setAttribute("name", "type");
                            hiddenField.setAttribute("value", 'package');
                            form.appendChild(hiddenField);

                            //input 10
                            var hiddenField = document.createElement("input");
                            hiddenField.setAttribute("type", "hidden");
                            hiddenField.setAttribute("name", "countRoomSlected");
                            hiddenField.setAttribute("value", _this.countRoomsSearch);
                            form.appendChild(hiddenField);

                            //input 11
                            var hiddenField = document.createElement("input");
                            hiddenField.setAttribute("type", "hidden");
                            hiddenField.setAttribute("name", "TotalNumberRoom_Reserve");
                            hiddenField.setAttribute("value", dataSelectedRoom['Rates'][0]['RoomToken'] + '-' + _this.countRoomsSearch);
                            form.appendChild(hiddenField);

                            //input 12
                            var hiddenField = document.createElement("input");
                            hiddenField.setAttribute("type", "hidden");
                            hiddenField.setAttribute("name", "RequestNumberHotel");
                            hiddenField.setAttribute("value", _this.dataHotel.RequestNumber);
                            form.appendChild(hiddenField);
                            console.log(form);

                            form.submit();
                            document.getElementById('loader_check' + keyHotel).style.display = "none";
                            document.body.removeChild(form);
                        } else {
                            console.log(response.data.message);
                        }
                    }).catch(function (error) {
                        // your action on error success
                        console.log(error);
                    });

                }
                else {
                    console.log('else revalidate');
                    console.log(response.data);
                }
            }).catch(function (error) {
                // your action on error success
                console.log(error);
            });
            return false;
        },
        selectReplacedFlight(dataFlight) {
            this.dataSpecificFlight = dataFlight;
            this.showModal = false
        },
        getDataPackage() {
            var _this = this;

            setTimeout(function () {
                axios.post(amadeusPath + 'axios',
                    {
                        method: 'getPackage',
                        urlWeb: location.pathname.substr(0),
                    },
                    {
                        'Content-Type': 'application/json'
                    }).then(function (response) {
                    document.getElementById("loader-page").style.display = "none";

                    console.log(response.data);
                    _this.dataFlight = response.data.flight.resultFlight;
                    _this.dataHotel = response.data.hotel;
                    _this.dataHotelResult = response.data.hotel.Result;
                    _this.dataSpecificFlight = response.data.specificFlight;
                    _this.lang = response.data.softwareLang;
                    _this.totalPerson = response.data.totalPerson;
                    _this.totalNight = response.data.totalNight;
                    _this.nameArrival = response.data.nameArrival;
                    _this.isInternal = response.data.isInternal;
                    _this.isError = response.data.Status;
                    _this.totalCountTour = response.data.hotel.Result.length;
                    _this.sortPrice(_this.dataHotelResult)

                }.bind(_this)).catch(function (error) {

                    // your action on error success
                    console.log(error);
                    document.getElementById("loader-page").style.display = "none";
                    _this.isError = error.response.data.Status;
                    _this.typeError = error.response.data.StatusType;
                    _this.errorMessage = error.response.data.Message;
                    _this.lang = error.response.data.softwareLang;
                    _this.totalPerson = error.response.data.totalPerson;
                    _this.totalNight = error.response.data.totalNight;
                    _this.nameArrival = error.response.data.nameArrival;
                    _this.isInternal = error.response.data.isInternal;

                    console.log(_this.isError);

                }.bind(_this));
            }, 1000)


        },
        getFullCapacityData() {
            var _this = this;
            setTimeout(function () {
                axios.post(amadeusPath + 'axios',
                  {
                      method: 'getFullCapacity',
                      urlWeb: location.pathname.substr(0),
                      id : 1  ,
                      is_json : true
                  },
                  {
                      'Content-Type': 'application/json'
                  }).then(function (response) {
                      if(response.data.pic_url) {
                           _this.full_capacity_url = response.data.pic_url
                      }else{
                          _this.full_capacity_url = amadeusPath + 'view/client/assets/images/fullCapacity.png'
                      }
                }.bind(_this)).catch(function (error) {
                }.bind(_this));
            }, 1000)
        },
        sumPrice(HotelPrice, FlightPrice) {
            let AllPeopal = parseInt(this.totalPerson);
            let AllNights = parseInt(this.totalNight);

            let priceOnePersone = 0;
            if (this.isInternal) {
                priceOnePersone = parseInt(((HotelPrice * AllNights) * parseInt(this.countRoomsSearch)) + (FlightPrice * AllPeopal));
            } else {
                priceOnePersone = parseInt((HotelPrice) + (FlightPrice * AllPeopal));
            }
            return this.numberFormat(priceOnePersone);

        },
        updateSumPrice(HotelPrice, FlightPrice, refkey, room, RoomToken) {
            console.log('av==>'+RoomToken)
            let PriceFinal = 0;
            this.dataSelectRoom = room;
            this.dataTookenSelectRoom  = RoomToken;

            console.log('af ==>'+ this.dataTookenSelectRoom)
            if (this.isInternal) {
                console.log('hotel pric=>' + (HotelPrice * this.totalNight) * this.countRoomsSearch);
                console.log('flight Pricre=>' + (FlightPrice * parseInt(this.totalPerson)));
                PriceFinal = parseInt(((HotelPrice * parseInt(this.totalNight)) * parseInt(this.countRoomsSearch)) + (FlightPrice * parseInt(this.totalPerson)));
            } else {
                console.log('hotel pric=>' + (HotelPrice * this.totalNight));
                console.log('flight Pricre=>' + (FlightPrice * parseInt(this.totalPerson)));
                PriceFinal = parseInt((HotelPrice) + (FlightPrice * parseInt(this.totalPerson)));
            }

            this.totalPrice = PriceFinal;
            console.log(this.$refs);
            console.log(this.$refs.totalPricSingle[refkey]);
            // console.log('finalPricekey=>'+ refkey + '==>'+ this.$refs.FinalPrice[refkey]);
            document.getElementById('FinalPrice').innerHTML = this.numberFormat(PriceFinal);
            this.$refs.totalPricSingle[refkey].innerHTML = this.numberFormat(PriceFinal);
        },
        numberFormat(number) {
            return Intl.NumberFormat().format(parseInt(number));
        },
        showRoomsHotel(hotelIndex, RequestNumber, City, StartDate, starHotel, keyHotel) {

            this.loading = true;
            this.dataRooms = '';

            console.log(this.loading);
            var __this = this;

            axios.post(amadeusPath + 'axios',
                {
                    method: 'getPricePackage',
                    hotelIndex: hotelIndex,
                    requestNumber: RequestNumber,
                    cityName: City,
                    startDate: StartDate,
                    stars: starHotel,
                },
                {
                    'Content-Type': 'application/json'
                }).then(function (response) {

                console.log(response);
                __this.hotelIndexSelected = hotelIndex;
                console.log(__this.hotelIndexSelected);
                console.log(response.data);
                __this.dataRooms = response.data.price.Result;
                __this.detailHotel = response.data.detail;
                __this.countRooms = response.data.price.Result.length;
                __this.PriceSessionId	 = response.data.price.PriceSessionId	;


                console.log(__this.dataRooms)
                setTimeout(function () {
                    __this.loading = false;
                }, 1000)


            }.bind(__this)).catch(function (error) {
                // your action on error success

                _this.isErrorRoom = false;
                _this.messageError = error.Message;
                setTimeout(function () {
                    __this.loading = false;
                }, 1000)
            });
        },
        sortPrice(dataHotel) {

            var conditionSort = this.SortPriceAsc;
            var sortData = Object.keys(dataHotel).sort(function (keyA, keyB) {
                console.log('bf=>' + conditionSort);
                if (conditionSort) {
                    return dataHotel[keyA].MinPrice - dataHotel[keyB].MinPrice;
                } else {
                    return dataHotel[keyB].MinPrice - dataHotel[keyA].MinPrice;
                }
            });

            var finalArraySort = [];
            for (let i = 0; i < sortData.length; i++) {
                finalArraySort.push(this.dataHotelResult[sortData[i]]);
            }

            this.dataHotelResult = finalArraySort;
            this.SortPriceAsc = !conditionSort;

            console.log('af=>' + this.SortPriceAsc);
            console.log(finalArraySort);

        },
        sortStar(dataHotel) {


            this.SortStarAsc;
            var conditionSort = this.SortStarAsc;
            var sortData = Object.keys(dataHotel).sort(function (keyA, keyB) {
                console.log('bf=>' + conditionSort);
                if (conditionSort) {
                    return dataHotel[keyA].HotelStars - dataHotel[keyB].HotelStars;
                } else {
                    return dataHotel[keyB].HotelStars - dataHotel[keyA].HotelStars;
                }
            });

            var finalArraySort = [];
            for (let i = 0; i < sortData.length; i++) {
                finalArraySort.push(this.dataHotelResult[sortData[i]]);
            }

            this.dataHotelResult = finalArraySort;
            this.SortStarAsc = !conditionSort;

            console.log('af=>' + this.SortStarAsc);
            console.log(finalArraySort);
        }
    },
    created() {
        this.getDataPackage();
        this.getFullCapacityData();

    },
    mounted() {

    },

});
// v-if="(roomRates.ReservationState.Status=='online' || (!isInternal))"
Vue.component('rooms-hotel', {
    props: ['rooms', 'dataFlightsSpcific', 'keySingleHotel', 'MinPrice', 'isInternal', 'isErrorRoom', 'MessageError', 'allpeopale'],
    template: `
      <div>
      <template v-if="isErrorRoom">
        <div v-if="parseInt(countRoomsSearch) > 1">
          <div class="col-12 rows" v-for="room in rooms">
            <div v-for="numberRoom in parseInt(countRoomsSearch)" :key="numberRoom">
              <div class="row" v-for="(roomRates,keyRoom) in room.Rates" :key="keyRoom" v-if="(roomRates.ReservationState.Status=='Refundable' || (!isInternal))">
                <div class="room-title">اتاق%% numberRoom %% - %% room.RoomName %%</div>
                <div class="col_first">
                  <span class="expansion-name">%% roomRates.Board.Name %% </span>
                </div>
                <div class=" col_second">
                  <!--                    <a class="btn btn_cancel">-->
                  <!--                        قوانین کنسلی-->
                  <!--                    </a>-->
                  <div class="price_tour">
                    <span> قیمت این اتاق </span>
                    <h5> %% numberFormat(roomRates.TotalPrices.Online) %%<i> ریال </i></h5>

                  </div>
                </div>
                <div class=" col_third" v-if="(isInternal && numberRoom== 1)">
                  <label>

                    <input type="radio"
                           :checked="checkComparePrice(MinPrice,roomRates.Prices[0].Online,dataFlightsSpcific.AdtPrice,keySingleHotel,room)"
                           class="option-input radio input-checked" name="check_room"
                           @click="newTotalPrice(roomRates.Prices[0].Online,dataFlightsSpcific.AdtPrice,keySingleHotel,room , roomRates.RoomToken)"/>
                  </label>
                  <div class="final_price"
                       v-if="checkComparePrice(MinPrice,roomRates.Prices[0].Online,dataFlightsSpcific.AdtPrice,keySingleHotel,room)">
                                            <span class="final_price_child">
                                                <span>انتخاب شده</span>
                                             </span>


                  </div>

                  <div class="final_price" v-else>
    
                                          
                                      <span class="final_price_child">
                                         
                                           <span>%% numberFormat((parseInt(roomRates.TotalPrices.Online) * parseInt(countRoomsSearch)) + (parseInt(dataFlightsSpcific.AdtPrice) * parseInt(allpeopale))) %%</span>
                                            <span>ریال</span>
                                            </span>
                  </div>
                </div>
                <div class=" col_third" v-else-if="!isInternal">
                  <label>
                    <input type="radio"
                           :checked="checkComparePrice(MinPrice,roomRates.TotalPrices.Online,dataFlightsSpcific.AdtPrice,keySingleHotel,room)"
                           class="option-input radio input-checked" name="check_room"
                           @click="newTotalPrice(roomRates.TotalPrices.Online,dataFlightsSpcific.AdtPrice,keySingleHotel,room , roomRates.RoomToken)"/>
                  </label>
                  <div class="final_price"
                       v-if="checkComparePrice(MinPrice,roomRates.TotalPrices.Online,dataFlightsSpcific.AdtPrice,keySingleHotel,room)">
                                        <span class="final_price_child">
                                            <span>انتخاب شده</span>
                                         </span>


                  </div>

                  <div class="final_price" v-else>
                                      
                                      <span class="final_price_child">
                                                <span>%% numberFormat(parseInt(roomRates.TotalPrices.Online) + parseInt(dataFlightsSpcific.AdtPrice)) %%</span>
                                                <span>ریال</span>
                                             </span>


                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-else>
          <div class="col-12 rows" v-for="room in rooms">
            <div class="row" v-for="(roomRates,keyRoom) in room.Rates" :key="keyRoom">
              <template>
                <div class="col_first">
                  <div class="room-title">%% room.RoomName %%</div>
                  <span class="expansion-name">%% roomRates.Board.Name %% </span>
                </div>
                <div class=" col_second">
                  <!--                    <a class="btn btn_cancel">-->
                  <!--                        قوانین کنسلی-->
                  <!--                    </a>-->
                  <div class="price_tour">
                    <span> قیمت این اتاق </span>
                    <h5> %% numberFormat(roomRates.TotalPrices.Online) %%<i> ریال </i></h5>

                  </div>
                </div>
                <div class=" col_third" v-if="(isInternal)">
                  <label>
                    <input type="radio"
                           :checked="checkComparePrice(MinPrice,roomRates.Prices[0].Online,rooms,dataFlightsSpcific.AdtPrice,keySingleHotel,room,roomRates.RoomToken)"
                           class="option-input radio input-checked" name="check_room"
                           @click="newTotalPrice(rooms,roomRates.Prices[0].Online,dataFlightsSpcific.AdtPrice,keySingleHotel,room ,roomRates.RoomToken)"/>
                  </label>
                  <div class="final_price">
                    <price-room :countRoomsSearch="countRoomsSearch" :roomRates="roomRates"
                                :dataFlightsSpcific="dataFlightsSpcific" :allpeopale="allpeopale"
                                :MinPrice="MinPrice"></price-room>
                  </div>
                </div>
                <div class="col_third" v-else-if="!isInternal">


                  <label>

                    <input type="radio"
                           :checked="checkComparePrice(MinPrice,roomRates.TotalPrices.Online,dataFlightsSpcific.AdtPrice,keySingleHotel,room,roomRates.RoomToken)"
                           :id="'roomSelected' + roomRates.RoomToken"
                           class="option-input radio input-checked" name="check_room" :id="roomRates.RoomToken"
                           @click="newTotalPrice(rooms,roomRates.TotalPrices.Online,dataFlightsSpcific.AdtPrice,keySingleHotel,room,roomRates.RoomToken)"/>
                  </label>
                  <div class="final_price">
                    <price-room :isInternal="isInternal" :countRoomsSearch="countRoomsSearch" :roomRates="roomRates"
                                :dataFlightsSpcific="dataFlightsSpcific" :allpeopale="allpeopale"
                                :MinPrice="MinPrice"></price-room>
                  </div>
                </div>
              </template>
            </div>
          </div>
        </div>
      </template>

      <template v-else>
        %% MessageError %%
      </template>


      </div>
    `,
    data: function () {
        return {
            countRoomsSearch: localStorage.getItem("dataCountRoom"),
            minPrice: '',
            isShOwTrue: true,
        }
    },
    delimiters: ['%%', '%%'],
    methods: {
        numberFormat(number) {
            return Intl.NumberFormat().format(parseInt(number));
        },
        newTotalPrice(rooms, HotelPrice, FlightPrice, refkey, room, RoomToken) {
            console.log('sss=>' + refkey);
            this.$emit('calculateTotalPrice', HotelPrice, FlightPrice, refkey, room, RoomToken);
            this.getseletedPrice(rooms,RoomToken)
        },
        checkComparePrice(minPrice, RoomPrice) {
            if (minPrice == RoomPrice) {

                return true;
            }
            return false
        },
        getseletedPrice(rooms, RoomToken) {

            rooms.forEach(function (value, key) {
                value.Rates.forEach(function (value2, key2) {

                    console.log(RoomToken, value2.RoomToken);
                    if (RoomToken == value2.RoomToken) {
                        console.log('Room=>' + RoomToken);
                        document.getElementById('roomWasSelected' + value2.RoomToken).style.display = 'block';
                        document.getElementById('roomNewSelected' + value2.RoomToken).style.display = 'none';
                    } else {
                        document.getElementById('roomWasSelected' + value2.RoomToken).style.display = 'none';
                        document.getElementById('roomNewSelected' + value2.RoomToken).style.display = 'block';
                    }

                });
            })
        }

    },
    created() {
        console.log("rooms: ", this.rooms)
    },
    mounted() {
    },
});

Vue.component('price-room', {
    props: ['isInternal', 'roomRates', 'dataFlightsSpcific', 'allpeopale', 'MinPrice', 'countRoomsSearch'],
    template: `
      <div>

      <template v-if="isInternal">
                <span class="final_price_child" v-show="checkComparePrice(MinPrice,roomRates.TotalPrices.Online)" :id="'roomWasSelected'+ roomRates.RoomToken">
                   <span>انتخاب شده</span>
              </span>
                <span class="final_price_child" v-show="checkComparePrice(MinPrice,roomRates.TotalPrices.Online) === false" :id="'roomNewSelected'+ roomRates.RoomToken">
                    <span>%% numberFormat(sumPrice(Multiplication(roomRates.TotalPrices.Online, countRoomsSearch), Multiplication(dataFlightsSpcific.AdtPrice, allpeopale))) %%</span>
                   <span>ریال</span>
                </span>
      </template>
      <template v-else>
                <span class="final_price_child" v-show="checkComparePrice(MinPrice,roomRates.TotalPrices.Online)" :id="'roomWasSelected'+ roomRates.RoomToken">
                   <span>انتخاب شده</span>
              </span>
                <span class="final_price_child"  v-show="checkComparePrice(MinPrice,roomRates.TotalPrices.Online) === false" :id="'roomNewSelected'+ roomRates.RoomToken">
                     <span>
                         %% numberFormat(sumPrice(parseInt(roomRates.TotalPrices.Online), Multiplication(dataFlightsSpcific.AdtPrice, allpeopale))) %%
                     </span>
                <span>ریال</span>
                </span>
      </template>

      </div>
    `,
    delimiters: ['%%', '%%'],
    data: {
        MinPrice: '',
    },
    methods: {
        checkComparePrice(minPrice, RoomPrice) {
            if (minPrice == RoomPrice) {
                return true;
            }
            return false
        },
        numberFormat(number) {
            return Intl.NumberFormat().format(parseInt(number));
        },
        Multiplication(number1, number2) {
            return parseInt(number1) * parseInt(number2);
        },
        sumPrice(number1, number2) {
            return parseInt(number1) + parseInt(number2);
        }

    }
})

Vue.component('room-select-user', {
    props: ['peopleRoom', 'keyPeople'],
    template: `
      <div class="clrB site-main-text-color-drck box-foreign-hotel-room-item" :id="'room' + (keyPeople + 1)">
      <div class="myroom-hotel">
        <div class="myroom-hotel-item">
          <div class="myroom-hotel-item-title site-main-text-color">
            اتاق %% keyPeople + 1 %%
            <span class="closeRooms" v-if="keyPeople > 0" @click="deleteRoom(keyPeople)"></span></div>
          <div class="myroom-hotel-item-info">
            <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
              <span>تعداد بزرگسال<i>(12 سال به بالا)</i></span>
              <div class="add_room_extra">
                <i class="addParentEHotel fa fa-plus  site-main-text-color site-bg-color-dock-border"
                   @click="add((keyPeople + 1),'adult')"></i>
                          <input type="number" :name="'adult'+ (keyPeople + 1)" :id="'adult'+ (keyPeople + 1)"
                       readonly="" class="countParentEHotel" min="0" v-model="peopleRoom.adult" max="9">
                <i class="minusParentEHotel fa fa-minus  site-main-text-color site-bg-color-dock-border"
                   @click="minus((keyPeople + 1),'adult')"></i>
              </div>
            </div>
            <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
              <span>تعداد کودک<i>(زیر 12 سال)</i></span>
              <div>
                <i class="addChildEHotel fa fa-plus site-main-text-color site-bg-color-dock-border"
                   @click="add((keyPeople + 1),'child')"></i>
                          <input type="number" readonly="" :name="'child'+ (keyPeople + 1)"
                       :id="'child'+ (keyPeople + 1)" class="countChildEHotel" min="0"
                       v-model="peopleRoom.child" max="9">
                <i class="minusChildEHotel fa fa-minus site-main-text-color site-bg-color-dock-border"
                   @click="minus((keyPeople + 1),'child')"></i>
              </div>
            </div>
            <div class="tarikh-tavalods">
              <div class="tarikh-tavalod-item"
                   v-if="(peopleRoom.ageChild[keyPeople].length > 0 && peopleRoom.ageChild[keyPeople] !='')"
                   v-for="(selectAge,keyAge) in peopleRoom.ageChild[keyPeople]">
                <span> سن کودک <i> %% keyAge + 1 %% </i> </span>
                <select :name="'childAge' + (keyPeople + 1) + (keyAge + 1) "
                        :id="'childAge' +(keyPeople + 1) + (keyAge + 1)">
                  <option v-for="index in 10" :key="index" :value="index"
                          :selected="index==peopleRoom.ageChild[keyPeople][keyAge]">
                    %% index %% تا %% index + 1 %% سال
                  </option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    `,
    delimiters: ['%%', '%%'],

    methods: {
        deleteRoom(idRoom) {
            this.$emit('deleteSelectRoom', idRoom);
        },
    }
})

new Vue({
    delimiters: ['%%', '%%'],
    el: "#appPackage",
    data: {}
});


function add(value, type) {

    console.log(value);
    let qty = document.getElementById(type + value).value;
    let currentVal = parseInt(qty);

    if (!isNaN(currentVal)) {

        if (type == "child") {
            if (currentVal < 4) {

                let htmlAppend = document.getElementById(type + value).parentElement.parentElement.parentElement.getElementsByClassName('tarikh-tavalods');
                let htmlBox = createBirthdayCalendar(value, (currentVal + 1));
                htmlAppend[0].innerHTML = htmlBox
            } else {
                tata.error('در یک اتاق بیشتر از 4 کودک امکان رزرو ندارید', 'خطا', {
                    position: 'bl',
                    duration: 5000,
                    progress: true,
                    animate: 'slide'

                })
                return false
            }
        }
        document.getElementById(type + value).value = currentVal + 1;
    }

};

function minus(value, type) {
    let qty = document.getElementById(type + value).value;
    let currentVal = parseInt(qty);
    if (!isNaN(currentVal) && currentVal > 0) {
        document.getElementById(type + value).value = currentVal - 1;
    }
    if (type == "child" && currentVal > 0) {
        let htmlAppend = document.getElementById(type + value).parentElement.parentElement.parentElement.getElementsByClassName('tarikh-tavalods');
        console.log(currentVal);
        console.log(htmlAppend[0].childNodes[currentVal - 1]);
        htmlAppend[0].childNodes[currentVal - 1].remove();
    }
}

function createBirthdayCalendar(rowNumber, inputNum) {


    let i = 1;
    let HtmlCode = "";
    let numberTextChild = "";
    while (i <= inputNum) {
        if (i == 1) {
            numberTextChild = useXmltag('First');
        } else if (i == 2) {
            numberTextChild = useXmltag('Second');
        } else if (i == 3) {
            numberTextChild = useXmltag('Third');
        } else if (i == 4) {
            numberTextChild = useXmltag('Fourth');
        }
        console.log(i)
        HtmlCode += `<div class="tarikh-tavalod-item" id="birthday${i}">
           <span>${useXmltag('Childage')} <i> ${numberTextChild} </i> </span>
           <select id="childAge${rowNumber}${i}" name="childAge${rowNumber}${i}">
           <option value="1">0 ${useXmltag('To')}   1 ${useXmltag('Year')}</option>
           <option value="2">1 ${useXmltag('To')}   2 ${useXmltag('Year')}</option>
           <option value="3">2 ${useXmltag('To')}   3 ${useXmltag('Year')}</option>
           <option value="4">3 ${useXmltag('To')}   4 ${useXmltag('Year')}</option>
           <option value="5">4 ${useXmltag('To')}   5 ${useXmltag('Year')}</option>
           <option value="6">5 ${useXmltag('To')}   6 ${useXmltag('Year')}</option>
           <option value="7">6 ${useXmltag('To')}   7 ${useXmltag('Year')}</option>
           <option value="8">7 ${useXmltag('To')}   8 ${useXmltag('Year')}</option>
           <option value="9">8 ${useXmltag('To')}   9 ${useXmltag('Year')}</option>
           <option value="10">9 ${useXmltag('To')} 10 ${useXmltag('Year')}</option>
           <option value="11">10 ${useXmltag('To')}11 ${useXmltag('Year')}</option>
           <option value="12">11 ${useXmltag('To')}12 ${useXmltag('Year')}</option>
           </select>
           </div>`
        i++;
    }
    return HtmlCode;
}




