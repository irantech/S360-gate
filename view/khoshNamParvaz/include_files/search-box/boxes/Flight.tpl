<div class="__box__ tab-pane active" id="Flight_internal">
    <h4 class='title-searchBox-mobile'>جستجو برای پروازهای داخلی </h4>
    <div class="d-flex flex-wrap gap-search-box">
        <div class="parent-btn-switch">
            <label data-text='یک طرفه' for='rdo-10'  class="btn-switch-searchBox switch-way-js active">
                <input  checked="" type="radio" id="rdo-10" name="select-rb2" value="1" class="internal-one-way-js">
                یک طرفه
            </label>
            <label data-text='رفت و برگشت' class="btn-switch-searchBox switch-way-js" for='rdo-20'>
                <input type="radio" id="rdo-20" name="select-rb2" value="2" class="internal-two-way-js">
                رفت و برگشت
            </label>
        </div>
        <div id="internal-content-flight" class="_internal d_flex visible flight-toggle-js flex-wrap internal-flight-js internal-content-flight">
            <form method="post" class="d_contents" target="_blank" id="internal_flight_form" name="internal_flight_form">
                <div class="d-flex flex-wrap gap-mobile">
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 p-1 col_search">
                        <div class="parent-input-search-box origin_start">
                            <i class="parent-svg-input-search-box">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>
                            </i>
                            <label for='route_origin_internal' class="caption-input-search-box">مبدأ خود را وارد کنید</label>
                            <input
                                    onclick="displayCityList('origin')"
                                    type="text" name="route_origin_internal"
                                    id="route_origin_internal"
                                    autocomplete='off'
                                    class=" inputSearchLocal route_origin_internal-js input-search-box"
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
                        <button onclick="reversRouteFlight('internal')"
                                class="switch_routs"
                                type="button"
                                name="button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M443.3 139.3c6.2-6.2 6.2-16.4 0-22.6l-96-96c-6.2-6.2-16.4-6.2-22.6 0s-6.2 16.4 0 22.6L393.4 112 16 112c-8.8 0-16 7.2-16 16s7.2 16 16 16l377.4 0-68.7 68.7c-6.2 6.2-6.2 16.4 0 22.6s16.4 6.2 22.6 0l96-96zm-342.6 352c6.2 6.2 16.4 6.2 22.6 0s6.2-16.4 0-22.6L54.6 400 432 400c8.8 0 16-7.2 16-16s-7.2-16-16-16L54.6 368l68.7-68.7c6.2-6.2 6.2-16.4 0-22.6s-16.4-6.2-22.6 0l-96 96c-6.2 6.2-6.2 16.4 0 22.6l96 96z"/></svg>
                        </button>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
                        <div class="parent-input-search-box destnition_start">
                            <i class="parent-svg-input-search-box">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>
                            </i>
                            <label for='route_destination_internal' class="caption-input-search-box">مقصد خود را وارد کنید</label>
                            <input type="text"
                                   onclick="displayCityList('destination')"
                                   autocomplete='off'
                                   id="route_destination_internal"
                                   name="route_destination_internal"
                                   class="inputSearchForeign input-search-box route_destination_internal-js"
                                   placeholder="مقصد ( شهر )">
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
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search date_search p-1">
                        <div class="parent-input-search-box">
                            <i class="parent-svg-input-search-box">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/></svg>
                            </i>
                            <label for='departure_date_internal' class="caption-input-search-box">تاریخ پرواز رفت را انتخاب کنید</label>
                            <input readonly="" type="text"
                                   class="deptCalendar went departure-date-internal-js "
                                   name="departure_date_internal" id="departure_date_internal" placeholder="تاریخ رفت">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search date_search p-1">
                        <div class="parent-input-search-box">
                            <i class="parent-svg-input-search-box">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/></svg>
                            </i>
                            <label for='arrival_date_internal' class="caption-input-search-box">تاریخ پرواز برگشت را انتخاب کنید</label>
                            <input readonly="" disabled="" name="arrival_date_internal" id="arrival_date_internal" type="text"
                                   class="checktest returnCalendar return_input internal-arrival-date-js disabled-js" placeholder="تاریخ برگشت">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
                        <div class="inp-s-num adt box-of-count-passenger box-of-count-passenger-js">
                            <input type="hidden" class="internal-adult-js" name="count_adult_internal" id="count_adult_internal" value="1">
                            <input type="hidden" class="internal-child-js" name="count_child_internal" id="count_child_internal" value="0">
                            <input type="hidden" class="internal-infant-js" name="count_infant_internal" id="count_infant_internal" value="0">
                            <i class="parent-svg-input-search-box">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/></svg>
                            </i>
                            <div class="box-of-count-passenger-boxes box-of-count-passenger-boxes-js">
                                <span class="text-count-passenger text-count-passenger-js">1 مسافر</span>
                                <i>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M201 337c-9.4 9.4-24.6 9.4-33.9 0L7 177c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l143 143L327 143c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9L201 337z"/></svg>
                                </i>
                            </div>
                            <div class="caption-input-search-box">تعداد مسافر</div>
                            <div class="cbox-count-passenger cbox-count-passenger-js">
                                <div class="col-xs-12 cbox-count-passenger-ch adult-number-js">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-6">
                                            <div class="type-of-count-passenger"><h6> بزرگسال </h6> (بزرگتر از ۱۲ سال)
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-6">
                                            <div class="num-of-count-passenger">
                                                <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js" data-parvaz="yes"></i>
                                                <i class="number-count-js number-count counting-of-count-passenger" data-number="1" data-min="1" data-search="internal" data-type="adult">1</i>
                                                <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js" data-parvaz="yes"></i>
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
                                                        class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js" data-parvaz="yes"></i>
                                                <i class="number-count-js number-count counting-of-count-passenger" data-number="0" data-min="0" data-search="internal" data-type="child">0</i>
                                                <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js" data-parvaz="yes"></i>
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
                                                <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js" data-parvaz="yes"></i>
                                                <i class="number-count-js number-count counting-of-count-passenger"
                                                   data-number="0" data-min="0" data-search="internal" data-type="infant">0</i>
                                                <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js" data-parvaz="yes"></i>
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
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search margin-center p-1">
                        <button type="button" onclick="searchFlight('internal')" class="btn theme-btn seub-btn b-0">
                            <span>جستجو</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M368 208A160 160 0 1 0 48 208a160 160 0 1 0 320 0zM337.1 371.1C301.7 399.2 256.8 416 208 416C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208c0 48.8-16.8 93.7-44.9 129.1L505 471c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L337.1 371.1z"/></svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
<div class="__box__ tab-pane " id="Flight_external">
    <h4 class='title-searchBox-mobile'>جستجو برای پروازهای خارجی</h4>
    <div class="d-flex flex-wrap gap-search-box">
        <div class="parent-btn-switch">
            <label data-text='یک طرفه' for='rdo-3'  class="switch-way-js btn-switch-searchBox active">
                <input checked="" class="multiselectportal international-one-way-js"
                       type="radio" id="rdo-3" name="select-rb" value="1">
                یک طرفه
            </label>
            <label data-text='رفت و برگشت' for='rdo-4'  class="btn-switch-searchBox switch-way-js">
                <input type="radio" class="multiselectportal international-two-way-js"
                       id="rdo-4" name="select-rb" value="2" >
                رفت و برگشت
            </label>
        </div>
        <div id="external-content-flight" class="_external flex-wrap flight-toggle-js international-flight-js external-content-flight">
            <form data-action="https://s360online.iran-tech.com/" method="post" target="_blank" class="d_contents" id="international_flight_form" name="international_flight_form">
                <div class='d-flex flex-wrap gap-mobile'>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col col_with_route p-1">
                        <div class="parent-input-search-box origin_start">
                            <i class="parent-svg-input-search-box">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>
                            </i>
                            <label for='iata_origin_international' class="caption-input-search-box">مبدأ خود را وارد کنید</label>
                            <input type="text"
                                   onclick='displayCityListExternal("origin" , event)'
                                   name="iata_origin_international"
                                   id="iata_origin_international"
                                   autocomplete='off'
                                   class="inputSearchForeign iata-origin-international-js input-search-box"
                                   placeholder="مبدأ ( شهر )">
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
                        <div class="parent-input-search-box destnition_start">
                            <i class="parent-svg-input-search-box">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>
                            </i>
                            <label for='iata_destination_international' class="caption-input-search-box">مقصد خود را وارد کنید</label>
                            <input type="text"
                                   onclick='displayCityListExternal("destination" , event)'
                                   autocomplete='off'
                                   id="iata_destination_international"
                                   name="iata_destination_international"
                                   class="inputSearchForeign iata-destination-international-js input-search-box"
                                   placeholder="مقصد ( شهر )">
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
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search date_search p-1">
                        <div class="parent-input-search-box">
                            <i class="parent-svg-input-search-box">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/></svg>
                            </i>
                            <label for='departure_date_international' class="caption-input-search-box">تاریخ پرواز رفت را انتخاب کنید</label>
                            <input readonly="" type="text"
                                   class="deptCalendar  went  departure-date-international-js" name="departure_date_international" id="departure_date_international" placeholder="تاریخ رفت">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search date_search p-1">
                        <div class="parent-input-search-box">
                            <i class="parent-svg-input-search-box">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/></svg>
                            </i>
                            <label for='arrival_date_international' class="caption-input-search-box">تاریخ پرواز برگشت را انتخاب کنید</label>
                            <input readonly="" disabled="" type="text" name="arrival_date_international" id="arrival_date_international" class=" return_input2  returnCalendar international-arrival-date-js disabled-js" placeholder="تاریخ برگشت">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
                        <div class="inp-s-num adt box-of-count-passenger box-of-count-passenger-js">
                            <input type="hidden" class="international-adult-js" name="adult_number_international" id="count_adult_international" value="1">
                            <input type="hidden" class="international-child-js" name="child_number_international" id="count_child_international" value="0">
                            <input type="hidden" class="international-infant-js" name="infant_number_international" id="count_infant_international" value="0">
                            <i class="parent-svg-input-search-box">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/></svg>
                            </i>
                            <div class="box-of-count-passenger-boxes box-of-count-passenger-boxes-js">
                                <span class="text-count-passenger text-count-passenger-js">1 مسافر</span>
                                <i>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M201 337c-9.4 9.4-24.6 9.4-33.9 0L7 177c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l143 143L327 143c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9L201 337z"/></svg>
                                </i>
                            </div>
                            <div class="caption-input-search-box">تعداد مسافر</div>
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
                                                <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js" data-parvaz="yes"></i>
                                                <i class="number-count-js number-count counting-of-count-passenger" data-number="1" data-min="1" data-search="international" data-type="adult">1</i>
                                                <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js" data-parvaz="yes"></i>
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
                                                <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js" data-parvaz="yes"></i>
                                                <i class="number-count-js number-count counting-of-count-passenger" data-number="0" data-min="0" data-search="international" data-type="child">0</i>
                                                <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js" data-parvaz="yes"></i>
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
                                                <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js" data-parvaz="yes"></i>
                                                <i class="number-count-js number-count counting-of-count-passenger" data-number="0" data-min="0" data-search="international" data-type="infant">0</i>
                                                <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js" data-parvaz="yes"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="div_btn"><span class="btn btn-close ">تأیید</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search margin-center p-1">
                        <button type="button" class="btn theme-btn seub-btn b-0"
                                onclick="searchFlight('international')">
                            <span>جستجو</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M368 208A160 160 0 1 0 48 208a160 160 0 1 0 320 0zM337.1 371.1C301.7 399.2 256.8 416 208 416C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208c0 48.8-16.8 93.7-44.9 129.1L505 471c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L337.1 371.1z"/></svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


