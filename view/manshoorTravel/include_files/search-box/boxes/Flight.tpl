<div class="__box__ tab-pane active" id="Flight">
{include file="./sections/Flight/internal/btn_radio_internal_external.tpl"}
<div class="_internal d_flex flex-wrap internal-flight-js" id="internal_flight">
<form class="d_contents" id="internal_flight_form" method="post" name="internal_flight_form" target="_blank">
{include file="./sections/Flight/internal/btn_type_way.tpl"}
{include file="./sections/Flight/internal/origin_selection.tpl"}
{include file="./sections/Flight/internal/destination_selection.tpl"}
{include file="./sections/Flight/internal/passenger_count.tpl"}
{include file="./sections/Flight/internal/date_flight.tpl"}
<div class="col-lg-4 col-md-6 col-sm-6 col-12 btn_s col_search margin-center">
<button class="btn theme-btn seub-btn b-0" onclick="searchFlight('internal')" type="button"><span>جستجو</span></button>
</div>
</form>
</div>
<div class="_external flex-wrap international-flight-js" id="international_flight">
<form class="d_contents" data-action="https://s360online.iran-tech.com/" id="international_flight_form" method="post" name="international_flight_form" target="_blank">
{include file="./sections/Flight/international/btn_type_way.tpl"}
{include file="./sections/Flight/international/origin_search_box.tpl"}
{include file="./sections/Flight/international/destination_search_box.tpl"}
{include file="./sections/Flight/international/passenger_count.tpl"}
{include file="./sections/Flight/international/date_flight.tpl"}
<div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search date_search">
<div class="form-group">
<input class="form-control return_input2 returnCalendar international-arrival-date-js" disabled="" id="arrival_date_international" name="arrival_date_international" placeholder="تاریخ برگشت" readonly="" type="text"/>
</div>
</div>
<div class="col-lg-4 col-md-6 col-sm-6 col-12 btn_s col_search margin-center">
<button class="btn theme-btn seub-btn b-0" onclick="searchFlight('international')" type="button"><span>جستجو</span></button>
</div>
</form>
</div>
<!--                <div id="flight_multi_way" class="flex-wrap flight-multi-way-js">-->
<!--                  <input type="hidden" class="count-path-js" value="2">-->
<!--                  <div class="col-md-12 col-xs-12 col-sm-12 d-ceckboxs">-->
<!--                    <div class="cntr">-->
<!--                      <label for="rdo-3" class="btn-radio select_multiway click_flight_oneWay">-->
<!--                        <svg width="20px" height="20px" viewBox="0 0 20 20">-->
<!--                          <circle cx="10" cy="10" r="9"></circle>-->
<!--                          <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"-->
<!--                                class="inner"></path>-->
<!--                          <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"-->
<!--                                class="outer"></path>-->
<!--                        </svg>-->
<!--                        <span>یک طرفه </span>-->
<!--                      </label>-->
<!--                      <label for="rdo-4" class="btn-radio select_multiway click_flight_twoWay">-->
<!--                        <input type="radio" class="multiselectportal" id="rdo-4" name="select-rb" value="2">-->
<!--                        <svg width="20px" height="20px" viewBox="0 0 20 20">-->
<!--                          <circle cx="10" cy="10" r="9"></circle>-->
<!--                          <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"-->
<!--                                class="inner"></path>-->
<!--                          <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"-->
<!--                                class="outer"></path>-->
<!--                        </svg>-->
<!--                        <span>دو طرفه </span>-->
<!--                      </label>-->
<!--                      <label for="rdo-5" class="btn-radio select_multiway click_flight_multiTrack">-->
<!--                        <input checked="" class="multiselectportal" type="radio" id="rdo-3" name="select-rb" value="1">-->
<!--                        <svg width="20px" height="20px" viewBox="0 0 20 20">-->
<!--                          <circle cx="10" cy="10" r="9"></circle>-->
<!--                          <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"-->
<!--                                class="inner"></path>-->
<!--                          <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"-->
<!--                                class="outer"></path>-->
<!--                        </svg>-->
<!--                        <span>چند مسیره</span></label></div>-->
<!--                  </div>-->
<!--                  <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col col_with_route">-->
<!--                    <div class="form-group origin_start origin-start-js">-->
<!--                      <input type="text"-->
<!--                             name="iata_multi_0_origin_international"-->
<!--                             id="iata_multi_0_origin_international"-->
<!--                             class="iata-multi-0-origin-international-js origin-multi-way-js form-control  inputSearchForeign"-->
<!--                             placeholder="مبدأ ( نام شهر یا فرودگاه )"-->
<!--                             data-number="0">-->
<!--                      <input type="hidden"-->
<!--                             id="multi_0_origin_airport"-->
<!--                             name="multi_0_origin_airport"-->
<!--                             value=""-->
<!--                             class="multi-0-origin-international-js iata-multi-js">-->
<!--                      <div id="list_multi_0_origin_airport"-->
<!--                           class="resultUlInputSearch list-show-result list-multi-0-origin-airport-international-js list-show-result-js">-->
<!--                      </div>-->
<!--                    </div>-->
<!--                    <button onclick="reversRouteFlight('multi_way_flight','0')" class="switch_routs switch-routs-js" id='switch_routs' type="button" name="button">-->
<!--                      <i class="fas fa-exchange-alt"></i>-->
<!--                    </button>-->
<!--                  </div>-->
<!--                  <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col col_with_route">-->
<!--                    <div class="form-group destination_start">-->
<!--                      <input type="text" name="iata_multi_0_destination_international_js" id="iata_multi_0_destination_international_js"-->
<!--                             class="iata-multi-0-destination-international-js  destination-multi-way-js form-control  inputSearchForeign"-->
<!--                             placeholder="مقصد ( نام شهر یا فرودگاه )" data-number="0">-->
<!--                      <input id="multi_0_destination_airport" type="hidden" value="" name="multi_0_destination_airport" class="multi-0-destination-international-js destination-iata-multi-js">-->
<!--                      <div id="list_multi_0_destination_airport" class="resultUlInputSearch list-show-result destination-list-js list-multi-0-destination-airport-international-js  destination-list-show-result-js "></div>-->
<!--                    </div>-->
<!--                  </div>-->
<!--                  <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search date_search">-->
<!--                    <div class="form-group w-100">-->
<!--                      <input readonly="" type="text" class="deptCalendar form-control date-multi-0-js date_multi_way" name="date_multi_0" id="date_multi_0" placeholder="تاریخ ">-->
<!--                      <i class="fal fa-calendar-alt"></i>-->
<!--                    </div>-->
<!--                  </div>-->
<!--                  <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">-->
<!--                    <div class="inp-s-num adt box-of-count-passenger box-of-count-passenger-js">-->
<!--                      <input type="hidden" class="multi-adult-js" name="adult_number_multi" id="count_adult_multi" value="1">-->
<!--                      <input type="hidden" class="multi-child-js" name="child_number_multi" id="count_child_multi" value="0">-->
<!--                      <input type="hidden" class="multi-infant-js" name="infant_number_multi" id="count_infant_multi" value="0">-->
<!--                      <div class="box-of-count-passenger-boxes box-of-count-passenger-boxes-js">-->
<!--                        <span class="text-count-passenger text-count-passenger-js">1 بزرگسال ,0 کودک ,0 نوزاد</span>-->
<!--                        <span class="fas fa-caret-down down-count-passenger"></span>-->
<!--                      </div>-->
<!--                      <div class="cbox-count-passenger cbox-count-passenger-js">-->
<!--                        <div class="col-xs-12 cbox-count-passenger-ch adult-number-js">-->
<!--                          <div class="row">-->
<!--                            <div class="col-xs-12 col-sm-6 col-6">-->
<!--                              <div class="type-of-count-passenger"><h6> بزرگسال </h6> (بزرگتر از ۱۲-->
<!--                                سال)-->
<!--                              </div>-->
<!--                            </div>-->
<!--                            <div class="col-xs-12 col-sm-6 col-6">-->
<!--                              <div class="num-of-count-passenger">-->
<!--                                <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js"></i>-->
<!--                                <i class="number-count-js number-count counting-of-count-passenger" data-number="1" data-min="1" data-search="multi" data-type="adult">1</i>-->
<!--                                <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js"></i>-->
<!--                              </div>-->
<!--                            </div>-->
<!--                          </div>-->
<!--                        </div>-->
<!--                        <div class="col-xs-12 cbox-count-passenger-ch child-number-js">-->
<!--                          <div class="row">-->
<!--                            <div class="col-xs-12 col-sm-6 col-6">-->
<!--                              <div class="type-of-count-passenger"><h6> کودک </h6>(بین 2 الی 12 سال)-->
<!--                              </div>-->
<!--                            </div>-->
<!--                            <div class="col-xs-12 col-sm-6 col-6">-->
<!--                              <div class="num-of-count-passenger">-->
<!--                                <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js"></i>-->
<!--                                <i class="number-count-js number-count counting-of-count-passenger" data-number="0" data-min="0" data-search="multi" data-type="child">0</i>-->
<!--                                <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js"></i>-->
<!--                              </div>-->
<!--                            </div>-->
<!--                          </div>-->
<!--                        </div>-->
<!--                        <div class="col-xs-12 cbox-count-passenger-ch infant-number-js">-->
<!--                          <div class="row">-->
<!--                            <div class="col-xs-12 col-sm-6 col-6">-->
<!--                              <div class="type-of-count-passenger"><h6> نوزاد </h6>(کوچکتر از 2 سال)-->
<!--                              </div>-->
<!--                            </div>-->
<!--                            <div class="col-xs-12 col-sm-6 col-6">-->
<!--                              <div class="num-of-count-passenger">-->
<!--                                <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js"></i>-->
<!--                                <i class="number-count-js number-count counting-of-count-passenger" data-number="0" data-min="0" data-search="multi" data-type="infant">0</i>-->
<!--                                <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js"></i>-->
<!--                              </div>-->
<!--                            </div>-->
<!--                          </div>-->
<!--                        </div>-->
<!--                        <div class="div_btn"><span class="btn btn-close ">تأیید</span></div>-->
<!--                      </div>-->
<!--                    </div>-->
<!--                  </div>-->
<!--                  <div class="col-lg-2 col-sm-3 d-sm-block d-none btn_s col_search margin-center">-->
<!--                    <button type="button" onclick="newAdditionalExternal($(this))"-->
<!--                            class="seub-btn btn_multiTrack b-0"><span-->
<!--                            class="d-flex align-items-center justify-content-center"><i-->
<!--                            class="fa fa-plus ml-2"></i> افزودن پرواز</span></button>-->
<!--                  </div>-->
<!--                  <div class="col-lg-2 col-md-3 col-sm-6 col-12 d-lg-block d-none btn_s col_search">-->
<!--                    <button type="button" class="btn theme-btn seub-btn b-0"-->
<!--                            onclick="severalPathFlight()"><span>جستجو</span></button>-->
<!--                  </div>-->
<!--                  <div class="col-12 p-0 pt-1 d-flex flex-wrap parent_multiTrack additional-flight-multi-way-js">-->
<!--                    <div class="col-12 px-0 style-sm d-flex flex-wrap">-->
<!--                      <div class="col-lg-2 col-md-4 col-sm-6 col-12 col_search search_col col_with_route">-->
<!--                        <div class="form-group origin_start origin-start-js">-->
<!--                          <input type="text" name="iata_multi_1_origin_international" id="iata_multi_1_origin_international"-->
<!--                                 class="iata-multi-1-origin-international-js  origin-multi-way-js form-control  inputSearchForeign"-->
<!--                                 placeholder="مبدأ ( نام شهر یا فرودگاه )" data-number="1">-->
<!--                          <input id="multi_1_origin_airport" type="hidden" value="" name="multi_1_origin_airport" class="multi-1-origin-international-js iata-multi-js">-->
<!--                          <div id="list_multi_1_origin_airport" class="resultUlInputSearch list-show-result list-multi-1-origin-airport-international-js list-show-result-js"></div>-->
<!--                        </div>-->
<!--                        <button onclick="reversRouteFlight('multi_way_flight','1')" class="switch_routs switch-routs-js" id='switch_routs' type="button" name="button">-->
<!--                          <i class="fas fa-exchange-alt"></i>-->
<!--                        </button>-->
<!--                      </div>-->
<!--                      <div class="col-lg-2 col-md-4 col-sm-6 col-12 col_search search_col col_with_route">-->
<!--                        <div class="form-group destination_start">-->
<!--                          <input type="text" name="iata_multi_1_destination_international_js" id="iata_multi_1_destination_international_js"-->
<!--                                 class="iata-multi-1-destination-international-js  destination-multi-way-js form-control  inputSearchForeign"-->
<!--                                 placeholder="مقصد ( نام شهر یا فرودگاه )" data-number="1">-->
<!--                          <input id="multi_1_destination_airport" type="hidden" value="" name="multi_1_destination_airport" class="multi-1-destination-international-js destination-iata-multi-js">-->
<!--                          <div id="list_multi_1_destination_airport" class="resultUlInputSearch list-show-result destination-list-js list-multi-1-destination-airport-international-js  destination-list-show-result-js "></div>-->
<!--                        </div>-->
<!--                      </div>-->
<!--                      <div class="col-lg-2 col-md-4 col-sm-6 col-12 col_search date_search">-->
<!--                        <div class="form-group w-100">-->
<!--                          <input readonly="" type="text" class="deptCalendar form-control date-multi-1-js date_multi_way" name="date_multi_1" id="date_multi_1" placeholder="تاریخ ">-->
<!--                          <i class="fal fa-calendar-alt"></i>-->
<!--                        </div>-->
<!--                      </div>-->
<!--                      <div id="remove_btn" class="remove_btn d-none col-lg-auto col-md-3 col-sm-3 col-6 btn_s col_search">-->
<!--                        <button type="button" onclick="removeAdditionalExternal($(this))"-->
<!--                                class="btn theme-btn btn_multiTrack_delete seub-btn b-0">-->
<!--                          <span  class="align-items-center d-flex fa fa-trash-can far h5 justify-content-center m-0 px-2"></span>-->
<!--                        </button>-->
<!--                      </div>-->
<!--                    </div>-->
<!--                  </div>-->
<!--                  <div class="d-sm-none d-block col-12 btn_s col_search">-->
<!--                    <button type="button" class="btn_multiTrack seub-btn b-0"-->
<!--                            onclick="newAdditionalExternal(this)"><span-->
<!--                            class="d-flex align-items-center justify-content-center">افزودن پرواز </span>-->
<!--                    </button>-->
<!--                  </div>-->
<!--                  <div class="col-lg-2 col-md-4 col-sm-6 col-12 d-lg-none d-block btn_s col_search margin-center">-->
<!--                    <button type="button" class="btn theme-btn seub-btn b-0"-->
<!--                            onclick="severalPathFlight()"><span>جستجو</span></button>-->
<!--                  </div>-->
<!--                </div>-->
</div>