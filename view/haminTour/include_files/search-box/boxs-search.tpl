{assign var="obj_main_page" value=$obj_main_page }

{foreach $info_access_client_to_service as $key=>$client}
    {if $obj_main_page->newClassTabsSearchBox($client['MainService'])}
        {if  $smarty.const.GDS_SWITCH eq 'mainPage'}
            {include file="./boxes/{$client['MainService']}.tpl" client=$client}
         {else}
            {if $active_tab eq 'internalFlight' && $client['MainService'] eq 'Flight' || $active_tab eq $client['MainService']}
                {include file="./boxes/{$client['MainService']}.tpl" client=$client active=true}
            {/if}
        {/if}
    {/if}
{/foreach}

{*
<div class="tab-pane active" id="Flight">
    <div class="radios">
        <div class="switch">
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
        </div>
    </div>
    <div id="internal_flight" class="d_flex flex-wrap internal-flight-js">
        <form method="post" class="d_contents" target="_blank" id="internal_flight_form" name="internal_flight_form">
            <div class="col-md-12 col-xs-12 col-sm-12 d-ceckboxs">
                <div class="cntr">
                    <label for="rdo-10" class="btn-radio select-type-way-js" data-type='internal'>
                        <input  checked="" type="radio" id="rdo-10" name="select-rb2" value="1" class="internal-one-way-js">
                        <svg width="20px" height="20px" viewBox="0 0 20 20">
                            <circle cx="10" cy="10" r="9"></circle>
                            <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
                                  class="inner"></path>
                            <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
                                  class="outer"></path>
                        </svg>
                        <span>یک طرفه </span>
                    </label>
                    <label for="rdo-20"  class="btn-radio select-type-way-js" data-type='internal'>
                        <input type="radio" id="rdo-20" name="select-rb2" value="2" class="internal-two-way-js">
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
            <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search col_with_route p-1">
                <div class="form-group">
                    <div class="form-group origin_start">
                        <input
                                onclick="displayCityList('origin')"
                                type="text" name="route_origin_internal"
                                id="route_origin_internal"
                                autocomplete='off'
                                class="form-control inputSearchLocal route_origin_internal-js"
                                placeholder="مبدأ ( شهر )">
                        <input id="route_origin_internal"
                               class="origin-internal-js"
                               type="hidden"
                               placeholder="مبدأ"
                               data-border-red="#route_origin_internal"
                               value=""
                               name="route_origin_internal">
                        <div id="list_airport_origin_internal"
                             class="resultUlInputSearch list-show-result list-origin-airport-internal-js">
                        </div>
                        <div id="list_origin_popular_internal"
                             class="resultUlInputSearch list-show-result list_popular_origin_internal-js">
                        </div>
                    </div>
                </div>
                <button onclick="reversRouteFlight('internal')"
                        class="switch_routs"
                        type="button"
                        name="button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M443.3 139.3c6.2-6.2 6.2-16.4 0-22.6l-96-96c-6.2-6.2-16.4-6.2-22.6 0s-6.2 16.4 0 22.6L393.4 112 16 112c-8.8 0-16 7.2-16 16s7.2 16 16 16l377.4 0-68.7 68.7c-6.2 6.2-6.2 16.4 0 22.6s16.4 6.2 22.6 0l96-96zm-342.6 352c6.2 6.2 16.4 6.2 22.6 0s6.2-16.4 0-22.6L54.6 400 432 400c8.8 0 16-7.2 16-16s-7.2-16-16-16L54.6 368l68.7-68.7c6.2-6.2 6.2-16.4 0-22.6s-16.4-6.2-22.6 0l-96 96c-6.2 6.2-6.2 16.4 0 22.6l96 96z"/></svg>
                </button>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
                <div class="form-group">
            <span class="destnition_start">
            <input type="text"
                   onclick="displayCityList('destination')"
                   autocomplete='off'
                   id="route_destination_internal"
                   name="route_destination_internal"
                   class="inputSearchForeign form-control route_destination_internal-js"
                   placeholder="مقصد ( شهر )">
            </span>
                    <input id="route_destination_internal"
                           class="destination-internal-js"
                           type="hidden"
                           value=""
                           placeholder="مقصد"
                           data-border-red="#route_destination_internal"
                           name="route_destination_internal">
                    <div id="list_destination_airport_internal"
                         class="resultUlInputSearch list-show-result list-destination-airport-internal-js">
                    </div>
                    <div id="list_destination_popular_internal"
                         class="resultUlInputSearch list-show-result list_popular_destination_internal-js">
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search date_search p-1">
                <div class="form-group">
                    <input readonly="" type="text"
                           class="deptCalendar form-control went departure-date-internal-js "
                           name="departure_date_internal" id="departure_date_internal" placeholder="تاریخ رفت">
                </div>
                <div class="form-group">
                    <input readonly="" disabled="" name="arrival_date_internal" id="arrival_date_internal" type="text"
                           class="checktest returnCalendar form-control return_input internal-arrival-date-js " placeholder="تاریخ برگشت">
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
<div class="tab-pane" id="Hotel">
    <div class="radios switches">
        <div class="switch">
            <input autocomplete="off" type="radio" class="switch-input switch-input-hotel-js"  name="btn_switch_Hotel" value="0" id="btn_switch_Hotel_international">
            <label for="btn_switch_Hotel_international" class="switch-label switch-label-on">خارجی</label>
            <input checked="" autocomplete="off" type="radio" class="switch-input switch-input-hotel-js" name="btn_switch_Hotel" value="1" id="btn_switch_Hotel_internal">
            <label for="btn_switch_Hotel_internal"  class="switch-label switch-label-off">داخلی</label>
            <span class="switch-selection"></span>
        </div>
    </div>
    <div id="internal_hotel" class="d_flex flex-wrap internal-hotel-js">
        <form data-action="s360online.iran-tech.com/" name="gdsHotelLocal"
              target="_blank" id="internal_hotel_form" class="d_contents" method="post">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search search_col p-1">
                <div class="form-group destination_start">
                    <div class="s-u-in-out-wrapper raft raft-change change-bor w-100">
                        <input id="autoComplateSearchIN" name="autoComplateSearchIN"
                               class="inputSearchForeign w-100 form-control" type="text" value=""
                               placeholder='انتخاب شهر'
                               autocomplete="off"
                               onkeyup="searchCity('hotel')"
                               onclick="openBoxPopular('hotel')">
                        <input type='hidden' id='autoComplateSearchIN_hidden' value='' placeholder='انتخاب شهر'>
                        <input type='hidden' id='autoComplateSearchIN_hidden_en' value='' placeholder='انتخاب شهر'>
                        <ul id="listSearchCity" class="ul-inputSearch-externalHotel displayiN"></ul>
                    </div>

                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
                <div class="form-group">
                    <input type="text"
                           autocomplete="off"
                           class="init-shamsi-datepicker form-control check-in-date-js"
                           name="startDateForHotelLocal"
                           id="startDateForHotelLocal"
                           placeholder="تاریخ ورود"
                           data-type='internal'>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
                <div class="form-group">
                    <input type="text"
                           class="init-shamsi-return-datepicker form-control check-out-date-internal-js"
                           name="endDateForHotelLocal"
                           autocomplete="off"
                           id="endDateForHotelLocal"
                           placeholder="تاریخ خروج"
                           data-type='internal'>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search p-1">
                <div class="form-group">
                    <div class="hotel_passenger_picker internal-hotel-passenger-picker-js">
                        <ul onclick="openCountPassenger('internal')">
                            <li><em class="number_adult internal-number-adult-js">2</em> بزرگسال ،</li>
                            <li class="li_number_baby"><em class="number_baby internal-number-child-js">0</em> کودک ،</li>
                            <li><em class="number_room_po internal-number-room-js">1</em>اتاق</li>
                        </ul>
                        <div class="myhotels-rooms internal-my-hotels-rooms-js">
                            <div class="hotel_select_room internal-hotel-select-room-js">
                                <div class="myroom-hotel-item internal-my-room-hotel-item-js" data-roomnumber="1" >
                                    <div class="myroom-hotel-item-title internal-my-room-hotel-item-title-js">
                                <span class="close d-none" onclick="itemsRoom($(this),'internal')">
                                    <i>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M144 400C144 408.8 136.8 416 128 416C119.2 416 112 408.8 112 400V176C112 167.2 119.2 160 128 160C136.8 160 144 167.2 144 176V400zM240 400C240 408.8 232.8 416 224 416C215.2 416 208 408.8 208 400V176C208 167.2 215.2 160 224 160C232.8 160 240 167.2 240 176V400zM336 400C336 408.8 328.8 416 320 416C311.2 416 304 408.8 304 400V176C304 167.2 311.2 160 320 160C328.8 160 336 167.2 336 176V400zM310.1 22.56L336.9 64H432C440.8 64 448 71.16 448 80C448 88.84 440.8 96 432 96H416V432C416 476.2 380.2 512 336 512H112C67.82 512 32 476.2 32 432V96H16C7.164 96 0 88.84 0 80C0 71.16 7.164 64 16 64H111.1L137 22.56C145.8 8.526 161.2 0 177.7 0H270.3C286.8 0 302.2 8.526 310.1 22.56V22.56zM148.9 64H299.1L283.8 39.52C280.9 34.84 275.8 32 270.3 32H177.7C172.2 32 167.1 34.84 164.2 39.52L148.9 64zM64 432C64 458.5 85.49 480 112 480H336C362.5 480 384 458.5 384 432V96H64V432z"></path></svg>
                                    </i>
                                </span>
                                        اتاق اول
                                    </div>
                                    <div class="myroom-hotel-item-info internal-my-room-hotel-item-info-js">
                                        <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">

                                            <h6>بزرگسال</h6>
                                            (بزرگتر از ۱۲ سال)
                                            <div>
                                                <i class="addParent internal-add-number-adult-js hotelroom-minus plus-hotelroom-bozorgsal" onclick="addNumberAdult('internal',this)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M432 256C432 269.3 421.3 280 408 280h-160v160c0 13.25-10.75 24.01-24 24.01S200 453.3 200 440v-160h-160c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h160v-160c0-13.25 10.75-23.99 24-23.99S248 58.75 248 72v160h160C421.3 232 432 242.8 432 256z"></path></svg>
                                                </i>
                                                <input readonly="" autocomplete="off" class="countParent internal-count-parent-js" min="0" value="2" max="5" type="number" name="adult1" id="adult1">
                                                <i class="minusParent internal-minus-number-adult-js hotelroom-minus minus-hotelroom-bozorgsal" onclick="minusNumberAdult('internal',this)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M432 256C432 269.3 421.3 280 408 280H40c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h368C421.3 232 432 242.8 432 256z"></path></svg>
                                                </i>
                                            </div>
                                        </div>
                                        <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
                                            <h6>کودک</h6>
                                            (کوچکتر از ۱۲ سال)

                                            <div>
                                                <i class="addChild internal-add-number-child-js hotelroom-minus plus-hotelroom-koodak" onclick="addNumberChild('internal',this)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M432 256C432 269.3 421.3 280 408 280h-160v160c0 13.25-10.75 24.01-24 24.01S200 453.3 200 440v-160h-160c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h160v-160c0-13.25 10.75-23.99 24-23.99S248 58.75 248 72v160h160C421.3 232 432 242.8 432 256z"></path></svg>
                                                </i>
                                                <input readonly="" class="countChild internal-count-child-js" autocomplete="off" min="0" value="0" max="5" type="number" name="child1" id="child1">
                                                <i class="minusChild internal-minus-number-child-js hotelroom-minus minus-hotelroom-koodak" onclick="minusNumberChild('internal',this)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M432 256C432 269.3 421.3 280 408 280H40c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h368C421.3 232 432 242.8 432 256z"></path></svg>
                                                </i>
                                            </div>
                                        </div>
                                        <div class="tarikh-tavalods internal-birth-days-js"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="btn_group">
                                <div class="btn_add_room internal-btn-add-room-js" onclick="addRoom('internal')">
                                    <i class="fal fa-plus"></i>
                                    افزودن اتاق
                                </div>
                                <div class="close_room btn_close_box internal-close-room-js">
                                    <i class="fal fa-check"></i>
                                    تایید
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search margin-center p-1">
                <button type="button" onclick="searchInternalHotel()"
                        class="btn theme-btn seub-btn b-0"><span>جستجو</span></button>
            </div>
        </form>
    </div>
    <div id="international_hotel" class="flex-wrap international-hotel-js">
        <form target="_blank" data-action="https://s360online.iran-tech.com/" class="d_contents"  method="post" id="international_hotel_form">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search search_col p-1">
                <div class="form-group destination_start">
                    <div class="inputSearchForeign-box inputSearchForeign-pad_Fhotel w-100">
                        <div class="s-u-in-out-wrapper raft raft-change change-bor">
                            <input id="autoComplateSearchIN_2" name="autoComplateSearchIN"
                                   class="inputSearchForeign w-100 form-control" type="text" value=""
                                   placeholder='انتخاب شهر'
                                   autocomplete="off"
                                   onkeyup="searchCity('externalHotel')"
                                   onclick="openBoxPopular('externalHotel')">
                            <input id="destination_country" name="destination_country"type="hidden" value="" placeholder='انتخاب شهر'>

                            <input class="destination-country-js" name="destination-country-js"type="hidden" value="" placeholder='انتخاب شهر'>
                            <input class="destination-city-js" name="destination-city-js"type="hidden" value="" placeholder='انتخاب شهر'>

                            <input id="destination_city_foreign" name="destination_city_foreign"type="hidden" value="" placeholder='انتخاب شهر'>
                            <input id="destination_city" name="destination_city"type="hidden" value="" placeholder='انتخاب شهر'>
                            <ul id="listSearchCity_2" class="ul-inputSearch-externalHotel displayiN"></ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
                <div class="form-group">
                    <input readonly="" type="text"
                           autocomplete="off"
                           class="init-shamsi-datepicker form-control check-in-date-international-js"
                           name="startDateForHotelInternational" id="startDateForExternalHotelInternational"
                           placeholder="تاریخ ورود"
                           data-type='international'>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
                <div class="form-group">
                    <input readonly="" type="text"
                           class="init-shamsi-return-datepicker form-control check-out-date-international-js"
                           name="endDateForExternalHotelInternational"
                           autocomplete="off"
                           id="endDateForExternalHotelInternational"
                           placeholder="تاریخ خروج"
                           data-type='international'>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search p-1">
                <div class="form-group">
                    <div class="hotel_passenger_picker international-hotel-passenger-picker-js">
                        <ul onclick="openCountPassenger('international')">
                            <li><em class="number_adult international-number-adult-js">2</em> بزرگسال ،</li>
                            <li class="li_number_baby"><em class="number_baby international-number-child-js">0</em> کودک ،</li>
                            <li><em class="number_room_po international-number-room-js">1</em>اتاق</li>
                        </ul>
                        <div class="myhotels-rooms international-my-hotels-rooms-js">
                            <i class="close_room international-close-room-js"></i>
                            <div class="hotel_select_room international-hotel-select-room-js">
                                <div class="myroom-hotel-item international-my-room-hotel-item-js" data-roomnumber="1" >
                                    <div class="myroom-hotel-item-title international-my-room-hotel-item-title-js">
                                <span class="close d-none" onclick="itemsRoom('international')">
                                    <i>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M144 400C144 408.8 136.8 416 128 416C119.2 416 112 408.8 112 400V176C112 167.2 119.2 160 128 160C136.8 160 144 167.2 144 176V400zM240 400C240 408.8 232.8 416 224 416C215.2 416 208 408.8 208 400V176C208 167.2 215.2 160 224 160C232.8 160 240 167.2 240 176V400zM336 400C336 408.8 328.8 416 320 416C311.2 416 304 408.8 304 400V176C304 167.2 311.2 160 320 160C328.8 160 336 167.2 336 176V400zM310.1 22.56L336.9 64H432C440.8 64 448 71.16 448 80C448 88.84 440.8 96 432 96H416V432C416 476.2 380.2 512 336 512H112C67.82 512 32 476.2 32 432V96H16C7.164 96 0 88.84 0 80C0 71.16 7.164 64 16 64H111.1L137 22.56C145.8 8.526 161.2 0 177.7 0H270.3C286.8 0 302.2 8.526 310.1 22.56V22.56zM148.9 64H299.1L283.8 39.52C280.9 34.84 275.8 32 270.3 32H177.7C172.2 32 167.1 34.84 164.2 39.52L148.9 64zM64 432C64 458.5 85.49 480 112 480H336C362.5 480 384 458.5 384 432V96H64V432z"></path></svg>
                                    </i>
                                </span>
                                        اتاق اول

                                    </div>
                                    <div class="myroom-hotel-item-info international-my-room-hotel-item-info-js">
                                        <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">

                                            <h6>بزرگسال</h6>
                                            (بزرگتر از ۱۲ سال)
                                            <div>
                                                <i class="addParent international-add-number-adult-js hotelroom-minus plus-hotelroom-bozorgsal fas fa-plus" onclick="addNumberAdult('international',this)"></i>
                                                <input readonly="" autocomplete="off" class="countParent international-count-parent-js"
                                                       min="0" value="2"
                                                       max="5" type="number" name="adult1" id="adult1">
                                                <i
                                                        class="minusParent international-minus-number-adult-js hotelroom-minus minus-hotelroom-bozorgsal fas fa-minus" onclick="minusNumberAdult('international',this)"></i>
                                            </div>
                                        </div>
                                        <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
                                            <h6>کودک</h6>
                                            (کوچکتر از ۱۲ سال)

                                            <div>
                                                <i class="addChild international-add-number-child-js hotelroom-minus plus-hotelroom-koodak fas fa-plus" onclick="addNumberChild('international',this)"></i>
                                                <input readonly="" class="countChild international-count-child-js" autocomplete="off"
                                                       min="0" value="0" max="5"
                                                       type="number" name="child1" id="child1"><i
                                                        class="minusChild international-minus-number-child-js hotelroom-minus minus-hotelroom-koodak fas fa-minus" onclick="minusNumberChild('international',this)"></i>
                                            </div>
                                        </div>
                                        <div class="tarikh-tavalods international-birth-days-js"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="btn_group">
                                <div class="btn_add_room international-btn-add-room-js" onclick="addRoom('international')">
                                    <i class="fal fa-plus"></i>
                                    افزودن اتاق
                                </div>
                                <div class="close_room btn_close_box international-close-room-js">
                                    <i class="fal fa-check"></i>
                                    تایید
                                </div>
                            </div>

                        </div>


                    </div>
                </div>

            </div>
            <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search margin-center p-1">
                <input type="hidden" id="nights_hotel" name="nights_hotel" value="" placeholder='تاریخ خروج' class='nights-hotel-js'>

                <button onclick="searchInternationalHotel()" type="button"  class="btn theme-btn seub-btn b-0"><span>جستجو</span></button>
            </div>
        </form>
    </div>
    <input type='hidden' id="type_section" name="type_section" class="type-section-js" value="internal">
</div>
<div class="tab-pane" id="Insurance">
    <div class="col-md-12 col-12">
        <div class="row  ">
            <form data-action="https://s360online.iran-tech.com/" method="post" target="_blank"
                  name="gdsInsurance" id="gdsInsurance" class="d_contents">
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col_search p-1">
                    <div class="form-group">
                        <select data-placeholder="نام کشور مقصد"
                                name="insurance_destination_country"
                                id="insurance_destination_country"
                                class="select2_in  select2-hidden-accessible insurance-destination-country-js"
                                tabindex="-1" aria-hidden="true">
                            <option value="">انتخاب کنید...</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col_search p-1">
                    <div class="form-group">
                        <select data-placeholder="انتخاب مدت سفر"
                                name="travel_time" id="travel_time"
                                class="select2_in travel-time-js select2-hidden-accessible"
                                tabindex="-1" aria-hidden="true">
                            <option value="">انتخاب کنید...</option>
                            <option value="5">تا 5 روز</option>
                            <option value="7">تا 7 روز</option>
                            <option value="8">تا 8 روز</option>
                            <option value="15">تا 15 روز</option>
                            <option value="23">تا 23 روز</option>
                            <option value="31">تا 31 روز</option>
                            <option value="45">تا 45 روز</option>
                            <option value="62">تا 62 روز</option>
                            <option value="92">تا 92 روز</option>
                            <option value="182">تا 182 روز</option>
                            <option value="186">تا 186 روز</option>
                            <option value="365">تا 365 روز</option>
                        </select></div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 col-12 col_search p-1">
                    <div class="form-group">
                        <select name="number_of_passengers"
                                id="number_of_passengers"
                                data-placeholder="انتخاب تعداد مسافر"
                                class="select2_in passengers-count-js select2-hidden-accessible number-of-passengers-js"
                                tabindex="-1" aria-hidden="true">
                            <option value="">انتخاب کنید...</option>
                        </select>
                    </div>
                </div>
                <div class="count-passenger count-passengers-js p-1">
                    <div class="col-lg-2 col-md-4 col-sm-6 col-12 col_search search_col nafarat-bime passenger-age-div-js p-1">
                        <div class="form-group">
                            <input type="text"
                                   class="form-control passengers-age-js shamsiBirthdayCalendar"
                                   name="txt_birth_insurance1" autocomplete="off"
                                   id="txt_birth_insurance1"
                                   placeholder="تاریخ تولد مسافر 1">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 col-12 col_search search_btn_insuranc p-1">
                    <button type="button" onclick="searchInsurance()"
                            class="btn theme-btn seub-btn b-0"><span>جستجو</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="tab-pane" id="Tour">
    <div class="radios switches">
        <div class="switch">
            <input autocomplete="off"
                   type="radio"
                   class="switch-input switch-input-tour-js"
                   name="btn_switch_tour"
                   value="1"
                   id="btn_switch_tour_international">
            <label for="btn_switch_tour_international"
                   class="switch-label switch-label-on">
                خارجی
            </label>
            <input autocomplete="off"
                   type="radio"
                   class="switch-input switch-input-tour-js"
                   name="btn_switch_tour"
                   checked=""
                   value="2"
                   id="btn_switch_tour_internal">
            <label for="btn_switch_tour_internal"
                   class="switch-label switch-label-off">
                داخلی
            </label>
            <span class="switch-selection"></span>
        </div>
    </div>
    <div id="internal_tour" class="internal-tour-js">
        <div class="col-12">
            <div class="row">
                <form data-action="https://s360online.iran-tech.com/" class="d_contents" method="post"
                      name="gdsTourLocal" id="gdsTourLocal" target="_blank">
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search p-1">
                        <div class="form-group">
                            <select data-placeholder="نام شهر مبدأ"
                                    onchange="getArrivalCitiesTour('internal',this)"
                                    name="internal_origin_tour" id="internal_origin_tour"
                                    class="select2_in select2-hidden-accessible internal-origin-tour-js"
                                    tabindex="-1" aria-hidden="true">
                                <option value="">انتخاب کنید...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search p-1">
                        <div class="form-group">
                            <select data-placeholder="نام شهر مقصد"
                                    name="tourDestinationCityLocal" id="tourDestinationCityLocal"
                                    class="select2_in select2-hidden-accessible internal-destination-tour-js"
                                    tabindex="-1" aria-hidden="true">
                                <option value="">انتخاب کنید...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
                        <div class="form-group">
                            <select data-placeholder="تاریخ مسافرت"
                                    name="tourDeptDateLocal"
                                    id="tourDeptDateLocal"
                                    class="select2_in DeptYearOnChange_js select2-hidden-accessible internal-date-travel-tour-js"
                                    tabindex="-1" aria-hidden="true">
                                <option value="">انتخاب کنید...</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search p-1">
                        <button type="button" onclick="searchInternalTour()" class="btn theme-btn seub-btn b-0">
                            <span>جستجو</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="international_tour" class="international-tour-js">
        <div class="col-12">
            <div class='row'>
                <form data-action="https://s360online.iran-tech.com/" class="d_contents" method="post"
                      name="gdsPortalLocal" id="gdsPortalLocal" target="_blank">
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
                        <div class="form-group">
                            <input type="text" class="form-control " disabled placeholder="کشور مبدا: ایران">
                            <input type="hidden" value="1" name="tourOriginCountryPortal" id="tourOriginCountryPortal">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
                        <div class="form-group">
                            <select data-placeholder=" شهر مبدا"
                                    name="tourOriginCityPortal"
                                    id="tourOriginCityPortal"
                                    onchange="getArrivalCitiesTour('international',this)"
                                    class="select2_in select2-hidden-accessible international-tour-origin-city-js"
                                    tabindex="-1"
                                    aria-hidden="true">
                                <option value="">انتخاب کنید...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
                        <div class="form-group">
                            <select data-placeholder="کشور مقصد"
                                    onchange="getDestinationCityTour('international',this)"
                                    name="tourDestinationCountryPortal"
                                    id="tourDestinationCountryPortal"
                                    class="select2_in select2-hidden-accessible international-destination-tour-js"
                                    tabindex="-1"
                                    aria-hidden="true">
                                <option value="">انتخاب کنید...</option>
                            </select></div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
                        <div class="form-group">
                            <select data-placeholder="شهر مقصد"
                                    name="tourDestinationCityPortal"
                                    id="tourDestinationCityPortal"
                                    class="select2_in select2-hidden-accessible international-destination-city-tour-js"
                                    tabindex="-1" aria-hidden="true">
                                <option value="">انتخاب کنید...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
                        <div class="form-group">
                            <select data-placeholder="تاریخ مسافرت"
                                    name="tourDeptDateInternational"
                                    id="tourDeptDateInternational"
                                    class="select2_in DeptYearOnChange_js select2-hidden-accessible international-date-travel-tour-js"
                                    tabindex="-1" aria-hidden="true">
                                <option value="">انتخاب کنید...</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search p-1">
                        <button type="button" onclick="searchInternationalTour()" class="btn theme-btn seub-btn b-0">
                            <span>جستجو</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="tab-pane" id="Visa">
    <div class="col-md-12 col-12">
        <div class="row">
            <form data-action="https://s360online.iran-tech.com/" method="post" name="gdsVisa"
                  id="gdsVisa" target="_blank" class="d_contents">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search p-1">
                    <div class="form-group">
                        <select data-placeholder=" قاره" name="visa_continent"
                                id="visa_continent"
                                class="select2_in  select2-hidden-accessible continent-visa-js"
                                onchange="fillComboByContinent(this)" tabindex="-1"
                                aria-hidden="true">
                            <option selected="selected" value="">انتخاب کنید...</option>
                        </select></div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search p-1">
                    <div class="form-group">
                        <select data-placeholder=" مقصد" onchange="getVisaTypeSpecialCountry(this)"
                                name="visa_destination" id="visa_destination"
                                class="select2_in  select2-hidden-accessible country-visa-js"
                                tabindex="-1" aria-hidden="true">
                            <option value="">انتخاب کنید...</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
                    <div class="form-group">
                        <select data-placeholder=" نوع ویزا" name="visa_type"
                                id="visa_type"
                                class="select2_in  select2-hidden-accessible visa-type-js"
                                tabindex="-1" aria-hidden="true">
                            <option selected="selected" value="">نوع ویزا</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
                    <div class="select inp-s-num adt box-of-count-passenger box-of-count-passenger-js">
                        <input type="hidden" class="adult-visa-js"
                               name="count_adult_internal"
                               id="count_adult_internal" value="1">

                        <div class="box-of-count-passenger-boxes box-of-count-passenger-boxes-js">
                            <span class="text-count-passenger text-count-passenger-js">1 مسافر </span>
                            <span class="fas fa-caret-down down-count-passenger"></span>
                        </div>
                        <div class="cbox-count-passenger cbox-count-passenger-js">
                            <div class="col-xs-12 cbox-count-passenger-ch adult-number-js">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-6">
                                        <div class="type-of-count-passenger"><h6> مسافر </h6>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-6">
                                        <div class="num-of-count-passenger">
                                            <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js" data-visa="yes"></i>
                                            <i class="number-count-js number-count counting-of-count-passenger" data-number="1" data-min="1" data-value="internal-adult" data-type="adult">1</i>
                                            <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js " data-visa="yes"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="div_btn"><span class="btn btn-close ">تأیید</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 col-12 btn_s col_search margin-center p-1">
                    <button type="button" onclick="searchVisa()" class="btn theme-btn seub-btn b-0">
                        <span>جستجو</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
*}


