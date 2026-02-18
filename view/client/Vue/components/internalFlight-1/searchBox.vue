<template>
    <div class="parent-data-search-box-flight">

      <div class="data-flight" @click="viewModalSearchBox('.modal-searchBox')">
        <div class="container">
          <div class="box-data-flight" @click="showSearchBox()">
            <div class="parent-data-flight">
              <div class="parent-search-box-title">
                <i v-html="svg_departure_destination"></i>
                <h3>{{useXmltag('FlightTicket')}} {{data_search.name_departure}}   {{ useXmltag('On') }} {{data_search.name_arrival}} </h3>
              </div>
              <div class="parent-search-box-back-forth">
                <div class="">
                  <i v-html="svg_calender_date"></i>
                  <h3>رفت: {{data_search.DateFlightWithName}}</h3>
                </div>
                <div class="" v-if="data_search.MultiWay=='TwoWay'">
                  <i v-html="svg_calender_date"></i>
                  <h3>برگشت: {{data_search.DateFlightReturnWithName}}</h3>
                </div>
              </div>
            </div>
            <a href="javascript:" class="parent-change-search">
              تغییر جستجو
            </a>
          </div>
          <div class="search_box">
            <div class="tab-content" id="searchBoxContent">
              <div class="tab-pane active" id="Flight">
               <div class="radios">
                 <!--  <div class="switch">
                    <input autocomplete="off"
                           type="radio"
                           class="switch-input switch-input-js"
                           name="btn_switch_flight"
                           value="1"
                           id="raftobar">
                    <label for="raftobar"
                           class="switch-label switch-label-on">
                      خارجی
                    </label>
                    <input autocomplete="off"
                           type="radio"
                           class="switch-input switch-input-js"
                           name="btn_switch_flight"
                           value="2"
                           checked=""
                           id="raft">
                    <label for="raft"
                           class="switch-label switch-label-off">
                      داخلی
                    </label>
                    <span class="switch-selection"></span>
                  </div>-->
                  <button  class="close-search-box" type="button" @click="hideSearchBox()">
                    <i v-html="svg_close_search_box"></i>
                  </button>
                </div>
                <div id="internal_flight" class="d_flex flex-wrap internal-flight-js">
                  <form method="post" class="d_contents" target="_blank" id="internal_flight_form" name="internal_flight_form">
                    <div class="col-md-12 col-xs-12 col-sm-12 d-ceckboxs">
                      <div class="cntr">
                        <label for="rdo-10" class="btn-radio select-type-way-js" data-type='internal'>
                          <input  checked="" type="radio" id="rdo-10" name="select-rb2" value="1" class="internal-one-way-js"  ref="origin">
                          <i v-html="svg_type_way"></i>
                          <span>رفت </span>
                        </label>
                        <label for="rdo-20"  class="btn-radio select-type-way-js" data-type='internal'>
                          <input type="radio" id="rdo-20" name="select-rb2" value="2" class="internal-two-way-js">
                            <i v-html="svg_type_way"></i>
                          <span>رفت و برگشت </span>
                        </label>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search col_with_route p-1">
                      <div class="form-group">
                        <div class="form-group origin_start">
                          <input
                            type="text"
                            id="route_origin_internal"
                            autocomplete='off'
                            class="form-control inputSearchLocal route_origin_internal-js"
                            placeholder="مبدأ ( شهر )"
                            :lang="`${getLang()}`"
                            v-model="title_origin_city_search"
                            name="origin" @keyup="searchCity" @focus="focusSearchCity"
                            @click.stop="dropBox('origin')"
                          >
                          <img :src="`${getUrlWithoutLang()}view/client/assets/images/load.gif`"  id="LoaderForeignDep" name="LoaderForeignDep"
                               class="loaderSearch" v-show='search_origin_loading'>
                          <input id="origin_local" class="" type="hidden" v-model="iata_origin"
                                 name="origin">
                          <div v-if="(cities_origin.length == 0 & title_origin_city_search == '') || show_popular">

                            <ul  class="resultFlight_international search-box-resultFlight" v-show="is_search">
                              <div class='parent-titr' v-if="stored_origin_cities && stored_origin_cities.length > 0 ">
                                <span>{{ useXmltag('History') }}</span>
                                <span class='delete-pointer' @click.stop="clearSearchedCities('arrival')">
                        {{ useXmltag('Clear') }}
                      </span>
                              </div>
                              <li v-for="city in stored_origin_cities" @click.stop="selectAirportOrigin(city,getLang())">
                                <i class="fa fa fa-clock-o my-icon-loction  margin-left-5 margin-right-5"></i>
                                {{ city[`Departure_City${getLang().charAt(0).toUpperCase() + getLang().slice(1)}`] }}
                                ({{ city[`Departure_Code`] }})
                              </li>
                              <span>{{ useXmltag('PopularRoutes') }}</span>
                              <li v-for="city in $store.state.popular_internal_flights" @click.stop="selectAirportOrigin(city,getLang())">
                                <i class="fa fa-map-marker my-icon-loction margin-left-5 margin-right-5"></i>
                                {{ city[`Departure_City${getLang().charAt(0).toUpperCase() + getLang().slice(1)}`] }}
                                ({{ city[`Departure_Code`] }})
                              </li>
                            </ul>
                          </div>
                          <div v-else>
                            <ul  class="resultFlight_international search-box-resultFlight" v-show='is_search'>
                              <li v-for="city in cities_origin" @click.stop="selectAirportOrigin(city,getLang())">
                                <i class="fa fa-map-marker my-icon-loction margin-left-5 margin-right-5"></i>
                                {{ city[`Departure_City${getLang().charAt(0).toUpperCase() + getLang().slice(1)}`] }}
                                ({{ city[`Departure_Code`] }})
                              </li>
                            </ul>
                          </div>
                          <input id="origin_local" class="" type="hidden" v-model="iata_origin"
                                 name="origin">
                        </div>
                      </div>
                      <button @click="reversDestinations()"
                              class="switch_routs"
                              type="button"
                              name="button">
                        <i v-html="svg_revers_btn"></i>
                      </button>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
                      <div class="form-group">
                        <input autocomplete='off'
                               id="route_destination_internal"
                               class="inputSearchForeign form-control route_destination_internal-js"
                               placeholder="مقصد ( شهر )"
                               v-model="title_arrival_city_search" :lang="`${getLang()}`"
                               ref='arrival' name="destination"
                               @keyup="searchCityArrival"  @focus="focusSearchArrivalCity"
                               @click.stop="dropBox('arrival')">
                        <img :src="`${getUrlWithoutLang()}view/client/assets/images/load.gif`" id="LoaderForeignReturn" name="LoaderForeignReturn"
                             class="loaderSearch" v-if="search_arrival_loading">
                        <input id="destination_local" class="" type="hidden" v-model="iata_arrival"
                               name="destination_local">
                        <div v-if="(cities_arrival.length == 0 & title_arrival_city_search == '') || show_arrival_popular">

                          <ul class="resultFlight_international search-box-resultFlight" v-show="is_arrival_search">
                            <div class='parent-titr' v-if="stored_arrival_cities && stored_arrival_cities.length > 0 ">
                              <span> {{ useXmltag('History') }}</span>
                              <span class='delete-pointer' @click.stop="clearSearchedCities('origin')">
                         {{ useXmltag('Clear') }}
                      </span>
                            </div>
                            <li v-for="city in stored_arrival_cities" @click.stop="selectAirportArrival(city,getLang())">
                              <i class="fa fa fa-clock-o my-icon-loction   margin-left-5 margin-right-5"></i>
                              {{ city[`Departure_City${getLang().charAt(0).toUpperCase() + getLang().slice(1)}`] }}
                              ({{ city[`Departure_Code`] }})
                            </li>
                            <span>{{ useXmltag('PopularRoutes') }}</span>
                            <li v-for="city in $store.state.popular_internal_flights" @click.stop="selectAirportArrival(city,getLang())">
                              <i class="fa fa-map-marker my-icon-loction   margin-left-5 margin-right-5"></i>
                              {{ city[`Departure_City${getLang().charAt(0).toUpperCase() + getLang().slice(1)}`] }}
                              ({{ city[`Departure_Code`] }})
                            </li>
                          </ul>
                        </div>
                        <div v-else>
                          <ul class="resultFlight_international search-box-resultFlight" v-show="is_arrival_search">
                            <li v-for="city in cities_arrival" @click.stop="selectAirportArrival(city,getLang())">
                              <i class=" fa fa-map-marker my-icon-loction   margin-left-5 margin-right-5"></i>
                              {{ city[`Departure_City${getLang().charAt(0).toUpperCase() + getLang().slice(1)}`] }}
                              ({{ city[`Departure_Code`] }})
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search date_search p-1">
                      <div class="form-group date-vue-picker-search">
                        <template>
                          <date-picker v-model="date_departure" :inputFormat="format_datepicker"
                                       :auto-submit="true" :locale="lang_datepicker"
                                       :from="dateNow('-')"  mode="single"
                                       :column="column"
                                       name="dept_date"
                                       id="dept_date_local" :styles="styles"
                          >
                            <template #icon></template>
                          </date-picker>
                        </template>
                      </div>
                      <div class="form-group">
                        <template>
                          <date-picker-return v-model="date_return" :inputFormat="format_datepicker"
                                              :auto-submit="true"
                                              :column="column"
                                              mode="single" :locale="lang_datepicker"
                                              :placeholder="`${useXmltag('Returndate')}`" name="dept_date_return"
                                              id="dept_date_local_return"  :styles="styles"
                          >
                            <template #icon></template>
                          </date-picker-return>
                        </template>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
                      <div class="select inp-s-num adt box-of-count-passenger box-of-count-passenger-js">
                        <input type="hidden" class="internal-adult-js" name="count_adult_internal" id="count_adult_internal" value="1">
                        <input type="hidden" class="internal-child-js" name="count_child_internal" id="count_child_internal" value="0">
                        <input type="hidden" class="internal-infant-js" name="count_infant_internal" id="count_infant_internal" value="0">
                        <div class="box-of-count-passenger-boxes box-of-count-passenger-boxes-js">
                          <span class="text-count-passenger text-count-passenger-js">1 بزرگسال ,0 کودک ,0 نوزاد</span>
                          <span class="fas fa-caret-down down-count-passenger"></span>
                        </div>
                        <div class="cbox-count-passenger cbox-count-passenger-js">
                          <div class="col-xs-12 cbox-count-passenger-ch adult-number-js">
                            <div class="row">
                              <div class="col-xs-12 col-sm-6 col-6">
                                <div class="type-of-count-passenger"><h6> بزرگسال </h6> (بزرگتر از ۱۲ سال)
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-6">
                                <div class="num-of-count-passenger">
                                  <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js"></i>
                                  <i class="number-count-js number-count counting-of-count-passenger" data-number="1" data-min="1" data-search="internal" data-type="adult">1</i>
                                  <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-xs-12 cbox-count-passenger-ch child-number-js">
                            <div class="row">
                              <div class="col-xs-12 col-sm-6 col-6">
                                <div class="type-of-count-passenger">
                                  <h6> کودک </h6>(بین 2 الی 12 سال)
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-6">
                                <div class="num-of-count-passenger"><i
                                  class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js"></i>
                                  <i class="number-count-js number-count counting-of-count-passenger" data-number="0" data-min="0" data-search="internal" data-type="child">0</i>
                                  <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-xs-12 cbox-count-passenger-ch infant-number-js">
                            <div class="row">
                              <div class="col-xs-12 col-sm-6 col-6">
                                <div class="type-of-count-passenger">
                                  <h6> نوزاد </h6>(کوچکتر از 2 سال)
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-6">
                                <div class="num-of-count-passenger">
                                  <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js"></i>
                                  <i class="number-count-js number-count counting-of-count-passenger"
                                     data-number="0" data-min="0" data-search="internal" data-type="infant">0</i>
                                  <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="div_btn">
                            <span class="btn btn-close ">تأیید</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search margin-center p-1">
                      <button type="button" onclick="searchFlight('internal')"
                              class="btn theme-btn seub-btn b-0"><span>جستجو</span></button>
                    </div>
                  </form>
                </div>
                <div id="international_flight" class="flex-wrap international-flight-js">
                  <form data-action="https://s360online.iran-tech.com/" method="post" target="_blank" class="d_contents" id="international_flight_form" name="international_flight_form">
                    <div class="col-md-12 col-xs-12 col-sm-12 d-ceckboxs">
                      <div class="cntr">
                        <label for="rdo-3" class="btn-radio select-type-way-js" data-type='international'>
                          <input checked="" class="multiselectportal international-one-way-js"
                                 type="radio" id="rdo-3" name="select-rb" value="1">
                          <svg width="20px" height="20px" viewBox="0 0 20 20">
                            <circle cx="10" cy="10" r="9"></circle>
                            <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
                                  class="inner"></path>
                            <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
                                  class="outer"></path>
                          </svg>
                          <span>یک طرفه </span>
                        </label>
                        <label for="rdo-4" class="btn-radio select-type-way-js" data-type='international'>
                          <input type="radio" class="multiselectportal international-two-way-js"
                                 id="rdo-4" name="select-rb" value="2" >
                          <svg width="20px" height="20px" viewBox="0 0 20 20">
                            <circle cx="10" cy="10" r="9"></circle>
                            <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
                                  class="inner"></path>
                            <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
                                  class="outer"></path>
                          </svg>
                          <span>دو طرفه </span>
                        </label>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col col_with_route p-1">
                      <div class="form-group origin_start">
                        <input type="text"
                               onclick='displayCityListExternal("origin" , event)'
                               name="iata_origin_international"
                               id="iata_origin_international"
                               autocomplete='off'
                               class="form-control inputSearchForeign iata-origin-international-js"
                               placeholder="مبدأ (شهر,فرودگاه)">
                        <input id="origin_international"
                               class="origin-international-js"
                               type="hidden" value=""
                               data-border-red="#iata_origin_international"
                               name="iata_origin_international">
                        <div id="list_airport_origin_international"
                             class="resultUlInputSearch list-show-result list-origin-airport-international-js">
                        </div>
                        <div id="list_origin_popular_external"
                             class="resultUlInputSearch list-show-result list_popular_origin_external-js">
                        </div>
                      </div>
                      <button onclick="reversDestination('international')"
                              class="switch_routs"
                              type="button" name="button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M443.3 139.3c6.2-6.2 6.2-16.4 0-22.6l-96-96c-6.2-6.2-16.4-6.2-22.6 0s-6.2 16.4 0 22.6L393.4 112 16 112c-8.8 0-16 7.2-16 16s7.2 16 16 16l377.4 0-68.7 68.7c-6.2 6.2-6.2 16.4 0 22.6s16.4 6.2 22.6 0l96-96zm-342.6 352c6.2 6.2 16.4 6.2 22.6 0s6.2-16.4 0-22.6L54.6 400 432 400c8.8 0 16-7.2 16-16s-7.2-16-16-16L54.6 368l68.7-68.7c6.2-6.2 6.2-16.4 0-22.6s-16.4-6.2-22.6 0l-96 96c-6.2 6.2-6.2 16.4 0 22.6l96 96z"/></svg>
                      </button>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
                      <div class="form-group">
            <span class="destnition_start">
            <input type="text"
                   onclick='displayCityListExternal("destination" , event)'
                   autocomplete='off'
                   id="iata_destination_international"
                   name="iata_destination_international"
                   class="inputSearchForeign form-control iata-destination-international-js"
                   placeholder="مقصد (شهر,فرودگاه)">
            </span>
                        <input id="destination_international"
                               class="destination-international-js"
                               type="hidden"
                               value=""
                               data-border-red="#iata_destination_international"
                               name="destination_international">
                        <div id="list_destination_airport_international"
                             class="resultUlInputSearch list-show-result list-destination-airport-international-js">
                        </div>
                        <div id="list_destination_popular_external"
                             class="resultUlInputSearch list-show-result list_popular_destination_external-js">
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search date_search p-1">
                      <div class="form-group">
                        <input readonly="" type="text"
                               class="deptCalendar form-control went  departure-date-international-js" name="departure_date_international" id="departure_date_international" placeholder="تاریخ رفت">
                      </div>
                      <div class="form-group">
                        <input readonly="" disabled="" type="text" name="arrival_date_international" id="arrival_date_international" class="form-control return_input2  returnCalendar international-arrival-date-js" placeholder="تاریخ برگشت">
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
                      <div class="select inp-s-num adt box-of-count-passenger box-of-count-passenger-js">
                        <input type="hidden" class="international-adult-js" name="adult_number_international" id="count_adult_international" value="1">
                        <input type="hidden" class="international-child-js" name="child_number_international" id="count_child_international" value="0">
                        <input type="hidden" class="international-infant-js" name="infant_number_international" id="count_infant_international" value="0">
                        <div class="box-of-count-passenger-boxes box-of-count-passenger-boxes-js">
                          <span class="text-count-passenger text-count-passenger-js">1 بزرگسال ,0 کودک ,0 نوزاد</span>
                          <span class="fas fa-caret-down down-count-passenger"></span>
                        </div>
                        <div class="cbox-count-passenger cbox-count-passenger-js">
                          <div class="col-xs-12 cbox-count-passenger-ch adult-number-js">
                            <div class="row">
                              <div class="col-xs-12 col-sm-6 col-6">
                                <div class="type-of-count-passenger"><h6> بزرگسال </h6> (بزرگتر از ۱۲
                                  سال)
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-6">
                                <div class="num-of-count-passenger">
                                  <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js"></i>
                                  <i class="number-count-js number-count counting-of-count-passenger" data-number="1" data-min="1" data-search="international" data-type="adult">1</i>
                                  <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-xs-12 cbox-count-passenger-ch child-number-js">
                            <div class="row">
                              <div class="col-xs-12 col-sm-6 col-6">
                                <div class="type-of-count-passenger"><h6> کودک </h6>(بین 2 الی 12 سال)
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-6">
                                <div class="num-of-count-passenger">
                                  <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js"></i>
                                  <i class="number-count-js number-count counting-of-count-passenger" data-number="0" data-min="0" data-search="international" data-type="child">0</i>
                                  <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-xs-12 cbox-count-passenger-ch infant-number-js">
                            <div class="row">
                              <div class="col-xs-12 col-sm-6 col-6">
                                <div class="type-of-count-passenger"><h6> نوزاد </h6>(کوچکتر از 2 سال)
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-6 col-6">
                                <div class="num-of-count-passenger">
                                  <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js"></i>
                                  <i class="number-count-js number-count counting-of-count-passenger" data-number="0" data-min="0" data-search="international" data-type="infant">0</i>
                                  <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="div_btn"><span class="btn btn-close ">تأیید</span></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search margin-center p-1">
                      <button type="button" class="btn theme-btn seub-btn b-0"
                              onclick="searchFlight('international')"><span>جستجو</span></button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>


<script>
import datePicker from '@alireza-ab/vue-persian-datepicker'
export default {
  name: "searchBox",
  props: ['dataSearch'],
  components: {
    'date-picker': datePicker,
    'date-picker-return': datePicker

  },
  data() {
    return {
      styles: {
        'primary-color': main_color,
      },
      date_departure:'',
      date_return:'',
      column: {
        576: 1,  // under 576px, column count is 1
        992: 2,  // under 992px, column count is 2
      },
      data_search: [],
      isMobileSize: window.innerWidth < 576,
      scrolled: false,
      show_popular : false,
      show_arrival_popular : false,
      search_origin_loading : false ,
      search_arrival_loading : false ,
      title_origin_city: '',
      title_arrival_city: '',
      title_origin_city_search : '',
      title_arrival_city_search : '',
      iata_origin: '',
      iata_arrival: '',
      stored_origin_cities : [] ,
      stored_arrival_cities : [] ,
      cities_origin: [],
      popular_cities_origin : [],
      cities_arrival: [],
      is_search: false,
      svg_close_search_box : `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"/><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M482.3 192c34.2 0 93.7 29 93.7 64c0 36-59.5 64-93.7 64l-116.6 0L265.2 495.9c-5.7 10-16.3 16.1-27.8 16.1l-56.2 0c-10.6 0-18.3-10.2-15.4-20.4l49-171.6L112 320 68.8 377.6c-3 4-7.8 6.4-12.8 6.4l-42 0c-7.8 0-14-6.3-14-14c0-1.3 .2-2.6 .5-3.9L32 256 .5 145.9c-.4-1.3-.5-2.6-.5-3.9c0-7.8 6.3-14 14-14l42 0c5 0 9.8 2.4 12.8 6.4L112 192l102.9 0-49-171.6C162.9 10.2 170.6 0 181.2 0l56.2 0c11.5 0 22.1 6.2 27.8 16.1L365.7 192l116.6 0z"/></svg>`,
      svg_departure_destination : `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zm64 80v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H336zM64 400v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H208zm112 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z"/></svg>`,
      svg_calender_date : `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zm64 80v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H336zM64 400v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H208zm112 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z"/></svg>`,
      svg_type_way : ` <svg width="20px" height="20px" viewBox="0 0 20 20"> <circle cx="10" cy="10" r="9"></circle> <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path> <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path> </svg>`,
      svg_revers_btn: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M443.3 139.3c6.2-6.2 6.2-16.4 0-22.6l-96-96c-6.2-6.2-16.4-6.2-22.6 0s-6.2 16.4 0 22.6L393.4 112 16 112c-8.8 0-16 7.2-16 16s7.2 16 16 16l377.4 0-68.7 68.7c-6.2 6.2-6.2 16.4 0 22.6s16.4 6.2 22.6 0l96-96zm-342.6 352c6.2 6.2 16.4 6.2 22.6 0s6.2-16.4 0-22.6L54.6 400 432 400c8.8 0 16-7.2 16-16s-7.2-16-16-16L54.6 368l68.7-68.7c6.2-6.2 6.2-16.4 0-22.6s-16.4-6.2-22.6 0l-96 96c-6.2 6.2-6.2 16.4 0 22.6l96 96z"/></svg>`,
    };
  },
  mounted() {
    window.addEventListener('resize', this.handleResize);
    window.addEventListener('scroll', this.handleScroll);
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.handleResize);
    window.removeEventListener('scroll', this.handleScroll);
  },
  methods: {
    dropBox(type){
      if(type == 'origin'){
        this.is_search = !this.is_search ;
        this.is_arrival_search = false
      }else if(type == 'arrival'){
        this.is_arrival_search = !this.is_arrival_search ;
        this.is_search = false
      }
    },
    reversDestinations() {

      let title_origin = this.title_origin_city_search
      let iata_origin = this.iata_origin
      let title_arrival = this.title_arrival_city_search
      let iata_arrival = this.iata_arrival
      this.title_origin_city_search = title_arrival
      this.iata_origin = iata_arrival

      this.title_arrival_city_search = title_origin
      this.iata_arrival = iata_origin
    },
    focusSearchCity(){
      let _this = this
      _this.show_popular = true
    },
    searchCity: function(lang) {
      let _this = this
      _this.show_popular = false
      _this.is_search = true
      if(_this.title_origin_city_search != '') {
        _this.search_origin_loading = true
        axios.post(amadeusPath + 'ajax', {
          className: 'newApiFlight',
          method: 'searchCitiesFlightInternal',
          value: _this.title_origin_city_search,
        }, {
          'Content-Type': 'application/json',
        }).then(function(response) {
          _this.cities_origin = response.data.data
          _this.search_origin_loading = false
        }).catch(function(error) {
          _this.search_origin_loading = false
          console.log(error)
        })
      }else {
        _this.cities_origin = []
      }

    },
    hideSearchBox(mobileSize = this.isMobileSize) {
      if (!mobileSize) {
        const boxDataFlightElements = document.querySelectorAll(".box-data-flight");
        boxDataFlightElements.forEach(function(element) {
          element.style.display = "flex";
        });

        const searchBoxElements = document.querySelectorAll(".search_box");
        searchBoxElements.forEach(function(element) {
          element.style.display = "none";
        });
      }
    },
    handleResize() {
      this.isMobileSize = window.innerWidth < 576;
    },
    handleScroll() {
      this.scrolled = window.scrollY > 50;
    },
    viewModalSearchBox(element) {
      if (window.innerWidth < 576) {
        element.classList.add('show-modal');
      }
    },
    showSearchBox(mobileSize = this.isMobileSize) {
      if (!mobileSize) {
        const boxDataFlightElements = document.querySelectorAll(".box-data-flight");
        boxDataFlightElements.forEach(function(element) {
          element.style.display = "none";
        });

        const searchBoxElements = document.querySelectorAll(".search_box");
        searchBoxElements.forEach(function(element) {
          element.style.display = "block";
        });
      }
    },
    selectAirportArrival(city, lang) {
      lang = (lang !== 'fa') ? 'en' : 'fa'
      this.dataSearch.name_arrival = city[`Departure_City${lang.charAt(0).toUpperCase() + lang.slice(1)}`]
      this.dataSearch.destination =  city.Departure_Code
      this.cities_arrival = []
      this.is_arrival_search = false
      this.iata_arrival = city.Departure_Code
      this.title_arrival_city_search = city[`Departure_City${lang.charAt(0).toUpperCase() + lang.slice(1)}`]
      if( this.iata_origin == this.iata_arrival) {
        this.$refs.origin.focus();
        this.is_search = true
        this.iata_origin = ''
        this.dataSearch.name_departure = ''
        this.dataSearch.origin = ''
        this.title_origin_city_search =''
      }
    },
    searchCityArrivalBackup: function(event) {

      let value_city = event.target.value
      let _this = this
      this.iata_arrival = 0
      let lang = (event.target.lang !== 'fa') ? 'en' : 'fa'
      axios.post(amadeusPath + 'ajax', {
        className: 'newApiFlight',
        method: 'getCitiesFlightInternal',
        iata_city: value_city,
      }, {
        'Content-Type': 'application/json',
      }).then(function(response) {
        _this.cities_arrival = response.data.data
      }).catch(function(error) {
        console.log(error)
      })

    },
    searchCityArrival: function(event) {

      let value_city = event.target.value
      let _this = this
      _this.show_arrival_popular = false
      _this.is_arrival_search = true
      let lang = (event.target.lang !== 'fa') ? 'en' : 'fa'
      if(_this.title_arrival_city_search != '') {
        _this.search_arrival_loading = true
        axios.post(amadeusPath + 'ajax', {
          className: 'newApiFlight',
          method: 'searchCitiesFlightInternal',
          value: _this.title_arrival_city_search,
        }, {
          'Content-Type': 'application/json',
        }).then(function(response) {
          _this.search_arrival_loading = false
          _this.cities_arrival = response.data.data
        }).catch(function(error) {
          _this.search_arrival_loading = false
          console.log(error)
        })
      }else {
        _this.cities_arrival = []
      }

    },
    setSearchedStorage() {
      let storage_searched_cities =  localStorage.getItem('internalSearchedCities')

      if(storage_searched_cities == null || storage_searched_cities == "null" || Object.keys(JSON.parse(storage_searched_cities)).length == 0 ) {
        let storage_origin_cities = []
        let storage_arrival_cities = []
        storage_origin_cities.push({
          Departure_Code : this.iata_origin  ,
          [`Departure_City${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`] : this.data_search.name_departure
        })
        storage_arrival_cities.push({
          Departure_Code : this.iata_arrival  ,
          [`Departure_City${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`] : this.data_search.name_arrival
        })

        this.stored_origin_cities = storage_origin_cities
        this.stored_arrival_cities = storage_arrival_cities

        localStorage.setItem("internalSearchedCities", JSON.stringify( { origin :  storage_origin_cities , arrival :storage_arrival_cities } ));
      }
      else {
        let storage_searched_cities =  JSON.parse(localStorage.getItem('internalSearchedCities'))
        let storage_origin_cities = []
        let storage_arrival_cities = []
        if(!storage_searched_cities['origin']){
          storage_origin_cities.push({
            Departure_Code : this.iata_origin  ,
            [`Departure_City${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`] : this.data_search.name_departure
          })
          this.stored_origin_cities = storage_origin_cities
        }else {
          this.stored_origin_cities = storage_searched_cities.origin
          if(storage_searched_cities.origin && storage_searched_cities.origin.length > 0 ) {
            let has_stored = storage_searched_cities.origin.find(city => {
              return city.Departure_Code == this.iata_origin
            })
            if (!has_stored) {
              if (storage_searched_cities.origin.length == 5) {
                storage_searched_cities.origin.shift()
              }
              storage_searched_cities.origin.push({
                Departure_Code: this.iata_origin,
                [`Departure_City${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`]: this.data_search.name_departure
              })
            }
          }
          storage_origin_cities = storage_searched_cities.origin
        }

        if(!storage_searched_cities['arrival']) {
          storage_arrival_cities.push({
            Departure_Code : this.iata_arrival  ,
            [`Departure_City${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`] : this.data_search.name_arrival
          })
          this.stored_arrival_cities = storage_arrival_cities
        }
        else {
          this.stored_arrival_cities = storage_searched_cities.arrival
          if(storage_searched_cities.arrival && storage_searched_cities.arrival.length > 0){
            let has_stored = storage_searched_cities.arrival.find(city => {
              return city.Departure_Code == this.iata_arrival
            })
            if (!has_stored) {
              if (storage_searched_cities.arrival.length == 5) {
                storage_searched_cities.arrival.shift()
              }
              storage_searched_cities.arrival.push({
                Departure_Code: this.iata_arrival,
                [`Departure_City${this.getLang().charAt(0).toUpperCase() + this.getLang().slice(1)}`]: this.data_search.name_arrival
              })
            }
          }
          storage_arrival_cities = storage_searched_cities.arrival
        }
        localStorage.setItem("internalSearchedCities", JSON.stringify({ origin : storage_origin_cities , arrival :storage_arrival_cities}));
      }
    },
    focusSearchArrivalCity(){
      let _this = this
      _this.show_arrival_popular = true
    },
    getPopularFlightList() {
      let _this = this
      this.$store.dispatch('getPopularInternalFlight', {method: 'searchCitiesFlightInternal'})
    }
  },
  watch: {
    'dataSearch': {
      handler: function(after, before) {
        if (after && after.dataSearch) {
          let _this = this
          console.log(this.dataSearch)
          if (this.dataSearch) {
            this.data_search = after.dataSearch

            this.title_origin_city_search = this.data_search.name_departure
            this.title_arrival_city_search = this.data_search.name_arrival

            this.iata_origin = this.data_search.origin
            this.iata_arrival = this.data_search.destination
            this.date_departure = this.data_search.departure_date_en
            this.date_return = this.data_search.arrival_date_en

            this.setSearchedStorage()

            this.getPopularFlightList()

            if (after.dataSearch.software_lang != 'fa') {
              this.format_datepicker = 'YYYY-MM-DD'
              this.lang_datepicker = 'en'
            }
          }
        }
      },
      deep: true,
      immediate: true,
    },
    price() {
      if (this.price) {
        this.min_price_props = this.price.min_price
        this.max_price_props = this.price.max_price
        this.value_price = [this.price.min_price, this.price.max_price]
      }
    },
  },
};
</script>