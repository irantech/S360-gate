<!DOCTYPE html>

<html dir="rtl" lang="fa-IR">
{include file="include_files/header.tpl"}
<body>
{if $smarty.session.layout neq 'pwa' }{include file="include_files/menu.tpl"}{/if}
<section class="searchBox" style="margin-top: 10rem">
<div class="search_box container px-3">
<div class="search_box_main">
<ul class="nav nav-tabs" id="myTab" role="tablist">
<li class="nav-item">
<a aria-controls="flight-l" aria-selected="true" class="nav-link active" data-toggle="tab" href="#flight-l" id="flight-l-tab" role="tab">
<h4>
<i class="fal fa-plane-alt"></i>
<span>پرواز</span>
</h4>
</a>
</li>
<li class="nav-item">
<a aria-controls="hotel" aria-selected="false" class="nav-link" data-toggle="tab" href="#hotel" id="hotel-tab" role="tab">
<h4>
<i class="fal fa-hotel"></i>
<span>هتل</span>
</h4>
</a>
</li>
<li class="nav-item">
<a aria-controls="insurance" aria-selected="false" class="nav-link" data-toggle="tab" href="#insurance" id="insurance-tab" role="tab">
<h4>
<i class="fal fa-umbrella-beach"></i>
<span>بیمه</span>
</h4>
</a>
</li>
<li class="nav-item">
<a aria-controls="bus" aria-selected="false" class="nav-link" data-toggle="tab" href="#bus" id="bus-tab" role="tab">
<h4>
<i class="fal fa-bus"></i>
<span>اتوبوس</span>
</h4>
</a>
</li>
</ul>
<div class="tab-content" id="myTabContent">
<div aria-labelledby="flight-l-tab" class="tab-pane show active" id="flight-l" role="tabpanel">
<div class="col-12">
<div class="radios">
<div class="switch">
<input autocomplete="off" class="switch-input switch-input-js" id="raftobar" name="DOM_TripMode8" type="radio" value="1"/>
<label class="switch-label switch-label-on" for="raftobar">
                                    خارجی
                                </label>
<input autocomplete="off" checked="" class="switch-input switch-input-js" id="raft" name="DOM_TripMode8" type="radio" value="2"/>
<label class="switch-label switch-label-off" for="raft">
                                    داخلی
                                </label>
<span class="switch-selection"></span>
</div>
</div>
<div id="flight_dakheli">
<form class="d-contents" data-action="" id="gds_local" method="post" name="gds_local" target="_blank">
<div class="row">
<div class="col-md-12 col-xs-12 col-sm-12 d-ceckboxs p-0">
<div class="cntr">
<label class="btn-radio select_multiway" for="rdo-1">
<input checked="" id="rdo-1" name="select-rb2" type="radio" value="1"/>
<svg height="20px" viewbox="0 0 20 20" width="20px">
<circle cx="10" cy="10" r="9"></circle>
<path class="inner" d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"></path>
<path class="outer" d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"></path>
</svg>
<span>یک طرفه </span>
</label>
<label class="btn-radio select_multiway" for="rdo-2">
<input id="rdo-2" name="select-rb2" type="radio" value="2"/>
<svg height="20px" viewbox="0 0 20 20" width="20px">
<circle cx="10" cy="10" r="9"></circle>
<path class="inner" d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"></path>
<path class="outer" d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"></path>
</svg>
<span>دو طرفه </span>
</label>
</div>
</div>
<div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search col_with_route">
<div class="form-group search_box_alibaba">
<input class="form-control" placeholder="مبدأ ( نام شهر یا فرودگاه )" readonly="" type="text"/>
<div class="list_city">
<h6>پر تردد</h6>
<a href="javascript:">تهران</a>
<a href="javascript:">مشهد</a>
<a href="javascript:">کیش</a>
<a href="javascript:">همدان</a>
<a href="javascript:">اصفهان</a>
<a href="javascript:">یزد</a>
<a href="javascript:">تبریز</a>
<a href="javascript:">سمنان</a>
</div>
</div>
<button class="switch_routs" name="button" onclick="reversDestination('localFlight')" type="button">
<i class="fas fa-exchange-alt"></i>
</button>
<div class="form-group search_box_alibaba">
<input class="form-control" placeholder="مقصد ( نام شهر یا فرودگاه )" readonly="" type="text"/>
<div class="list_city">
<h6>پر تردد</h6>
<a href="javascript:">تهران</a>
<a href="javascript:">مشهد</a>
<a href="javascript:">کیش</a>
<a href="javascript:">همدان</a>
<a href="javascript:">اصفهان</a>
<a href="javascript:">یزد</a>
<a href="javascript:">تبریز</a>
<a href="javascript:">سمنان</a>
</div>
</div>
</div>
<div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search date_search">
<div class="form-group">
<input class="shamsiDeptCalendar form-control went open_return_date_js hasDatepicker" id="gds_dept_date_local" name="gds_dept_date_local" placeholder="تاریخ رفت" readonly="" type="text"/>
<!--                                                <i class="fal fa-calendar-alt"></i>-->
</div>
<div class="form-group">
<input class="checktest shamsiReturnCalendar form-control return_input hasDatepicker" disabled="" id="regds_dept_date_local" name="regds_dept_date_local" placeholder="تاریخ برگشت" readonly="" type="text"/>
<!--                                                <i class="fal fa-calendar-alt"></i>-->
</div>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
<div class="select inp-s-num adt box-of-count-nafar">
<input class="l-bozorgsal" id="qty4" name="gds_adults_no_local" type="hidden" value="1"/>
<input class="l-kodak" id="qty5" name="gds_childs_no_local" type="hidden"/>
<input class="l-nozad" id="qty6" name="gds_infants_no_local" type="hidden"/>
<div class="box-of-count-nafar-boxes">
<span class="text-count-nafar">
                                             1 بزرگسال ,0 کودک ,0 نوزاد
                                        </span>
<span class="fas fa-caret-down down-count-nafar"></span>
</div>
<div class="cbox-count-nafar" style="display: none;">
<div class="col-xs-12 cbox-count-nafar-ch bozorg-num">
<div class="row">
<div class="col-xs-12 col-sm-6 col-6">
<div class="type-of-count-nafar">
<h6> بزرگسال </h6> (بزرگتر از ۱۲ سال)
                                                            </div>
</div>
<div class="col-xs-12 col-sm-6 col-6">
<div class="num-of-count-nafar"><i class="fa fa-plus counting-of-count-nafar plus-nafar"></i>
<i class="number-count counting-of-count-nafar" data-min="1" data-number="1" data-value="l-bozorgsal" id="bozorgsal">1</i>
<i class="fa fa-minus counting-of-count-nafar minus-nafar"></i>
</div>
</div>
</div>
</div>
<div class="col-xs-12 cbox-count-nafar-ch koodak-num">
<div class="row">
<div class="col-xs-12 col-sm-6 col-6">
<div class="type-of-count-nafar">
<h6> کودک </h6>(بین 2 الی 12 سال)
                                                            </div>
</div>
<div class="col-xs-12 col-sm-6 col-6">
<div class="num-of-count-nafar"><i class="fa fa-plus counting-of-count-nafar plus-nafar"></i>
<i class="number-count counting-of-count-nafar" data-min="0" data-number="0" data-value="l-kodak">0</i>
<i class="fa fa-minus counting-of-count-nafar minus-nafar"></i>
</div>
</div>
</div>
</div>
<div class="col-xs-12 cbox-count-nafar-ch nozad-num">
<div class="row">
<div class="col-xs-12 col-sm-6 col-6">
<div class="type-of-count-nafar">
<h6> نوزاد </h6>(کوچکتر از 2 سال)
                                                            </div>
</div>
<div class="col-xs-12 col-sm-6 col-6">
<div class="num-of-count-nafar"><i class="fa fa-plus counting-of-count-nafar plus-nafar"></i>
<i class="number-count counting-of-count-nafar" data-min="0" data-number="0" data-value="l-nozad">0</i>
<i class="fa fa-minus counting-of-count-nafar minus-nafar"></i>
</div>
</div>
</div>
</div>
<div class="div_btn">
<span class="btn btn-close">تأیید</span>
</div>
</div>
</div>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search">
<button class="btn theme-btn seub-btn b-0" onclick="gds_ticket_local_check()" type="button">
<span>
                                        جستجو
                                    </span>
</button>
</div>
</div>
</form>
</div>
<div id="flight_khareji">
<form class="d-contents" data-action="https://s360online.iran-tech.com/" id="gds_portal" method="post" name="gds_portal" target="_blank">
<div class="row">
<div class="col-md-12 col-xs-12 col-sm-12 d-ceckboxs p-0">
<div class="cntr">
<label class="btn-radio" for="rdo-3">
<input checked="" class="multiselectportal" id="rdo-3" name="select-rb" type="radio" value="1"/>
<svg height="20px" viewbox="0 0 20 20" width="20px">
<circle cx="10" cy="10" r="9"></circle>
<path class="inner" d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"></path>
<path class="outer" d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"></path>
</svg>
<span>یک طرفه </span>
</label>
<label class="btn-radio" for="rdo-4">
<input class="multiselectportal" id="rdo-4" name="select-rb" type="radio" value="2"/>
<svg height="20px" viewbox="0 0 20 20" width="20px">
<circle cx="10" cy="10" r="9"></circle>
<path class="inner" d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"></path>
<path class="outer" d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"></path>
</svg>
<span>دو طرفه </span>
</label>
</div>
</div>
<div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search search_col col_with_route">
<div class="form-group origin_start">
<input class="form-control inputSearchForeign" id="OriginPortal" name="OriginPortal" placeholder="مبدأ ( نام شهر یا فرودگاه )" type="text"/>
</div>
<button class="switch_routs" name="button" onclick="reversDestination('internationalFlights')" type="button">
<i class="fas fa-exchange-alt"></i>
</button>
<div class="form-group">
<span class="destnition_start">
<input class="inputSearchForeign form-control" id="DestinationPortal" name="DestinationPortal" placeholder="مقصد ( نام شهر یا فرودگاه )" type="text"/>
</span>
<input class="" id="DestinationAirportPortal" name="DestinationAirportPortal" type="hidden" value=""/>
</div>
</div>
<div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search date_search">
<div class="form-group">
<input class="deptCalendar form-control went hasDatepicker" id="gds_dept_date_Portal" name="gds_dept_date_portal" placeholder="تاریخ رفت" readonly="" type="text"/>
<!--                                                <i class="fal fa-calendar-alt"></i>-->
</div>
<div class="form-group">
<input class="form-control return_input2 checktest1 returnCalendar hasDatepicker" disabled="" id="regds_dept_date_Portal" name="regds_dept_date_Portal" placeholder="تاریخ برگشت" readonly="" type="text"/>
<!--                                                <i class="fal fa-calendar-alt"></i>-->
</div>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
<div class="select inp-s-num adt box-of-count-nafar">
<input class="l-bozorgsal-2" id="qtyadt" name="gds_infants_no_portal" type="hidden" value="1"/>
<input class="l-kodak-2" id="qtychd" name="gds_childs_no_portal" type="hidden"/>
<input class="l-nozad-2" id="qtyinf" name="gds_infants_no_portal" type="hidden"/>
<div class="box-of-count-nafar-boxes">
<span class="text-count-nafar">
                                    1 بزرگسال ,0 کودک ,0 نوزاد
                                    </span>
<span class="fas fa-caret-down down-count-nafar"></span>
</div>
<div class="cbox-count-nafar" style="display: none;">
<div class="col-xs-12 cbox-count-nafar-ch bozorg-num">
<div class="row">
<div class="col-xs-12 col-sm-6 col-6">
<div class="type-of-count-nafar">
<h6> بزرگسال </h6> (بزرگتر از ۱۲ سال)
                                                            </div>
</div>
<div class="col-xs-12 col-sm-6 col-6">
<div class="num-of-count-nafar"><i class="fa fa-plus counting-of-count-nafar plus-nafar"></i>
<i class="number-count counting-of-count-nafar" data-min="1" data-number="1" data-value="l-bozorgsal" id="bozorgsal_prtal">1</i>
<i class="fa fa-minus counting-of-count-nafar minus-nafar"></i>
</div>
</div>
</div>
</div>
<div class="col-xs-12 cbox-count-nafar-ch koodak-num">
<div class="row">
<div class="col-xs-12 col-sm-6 col-6">
<div class="type-of-count-nafar">
<h6> کودک </h6>(بین 2 الی 12 سال)
                                                            </div>
</div>
<div class="col-xs-12 col-sm-6 col-6">
<div class="num-of-count-nafar"><i class="fa fa-plus counting-of-count-nafar plus-nafar"></i>
<i class="number-count counting-of-count-nafar" data-min="0" data-number="0" data-value="l-kodak" id="kodak_prtal">0</i>
<i class="fa fa-minus counting-of-count-nafar minus-nafar"></i>
</div>
</div>
</div>
</div>
<div class="col-xs-12 cbox-count-nafar-ch nozad-num">
<div class="row">
<div class="col-xs-12 col-sm-6 col-6">
<div class="type-of-count-nafar">
<h6> نوزاد </h6>(کوچکتر از 2 سال)
                                                            </div>
</div>
<div class="col-xs-12 col-sm-6 col-6">
<div class="num-of-count-nafar"><i class="fa fa-plus counting-of-count-nafar plus-nafar"></i>
<i class="number-count counting-of-count-nafar" data-min="0" data-number="0" data-value="l-nozad" id="nozad_prtal">0</i>
<i class="fa fa-minus counting-of-count-nafar minus-nafar"></i>
</div>
</div>
</div>
</div>
<div class="div_btn">
<span class="btn btn-close">تأیید</span>
</div>
</div>
</div>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search">
<button class="btn theme-btn seub-btn b-0" type="button"><span>جستجو</span></button>
</div>
</div>
</form>
</div>
</div>
</div>
<div aria-labelledby="hotel-tab" class="tab-pane" id="hotel" role="tabpanel">
<div class="radios switches">
<div class="switch">
<input autocomplete="off" class="switch-input" id="hotel_l" name="DOM_TripMode4" type="radio" value="1"/>
<label class="switch-label switch-label-on" for="hotel_l"> خارجی</label>
<input autocomplete="off" class="switch-input" id="hotel_f" name="DOM_TripMode4" type="radio" value="2"/>
<label checked="" class="switch-label switch-label-off" for="hotel_f">داخلی</label>
<span class="switch-selection"></span>
</div>
</div>
<div class="row" id="hotel_dakheli">
<form class="d-contents">
<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search search_col">
<div class="form-group">
<span class="destnition_start">
<input class="form-control inputSearchForeign" id="autoComplateSearchHotelLocal" name="autoComplateSearchHotelLocal" onkeyup="searchCityHotelLocal()" placeholder="جستجوی هتل یا شهر مقصد" type="text"/>
</span>
<div class="display-0" id="divCityHotelLocalLists">
<div class="tabs_sub_hotel">
<ul class="tabs_ul_hotel">
<li href="#tabs_content_city" id="city_tab">شهر</li>
<li href="#tabs_content_hotel" id="hotel_tab">هتل</li>
</ul>
<div class="tabs_content_hotel">
<div>
<div id="tabs_content_city"></div>
<div id="tabs_content_hotel"></div>
<div id="error"></div>
</div>
</div>
</div>
</div>
<input id="cityForHotelLocal" name="cityForHotelLocal" type="hidden" value=""/>
<input id="hotelId" name="hotelId" type="hidden" value=""/>
<input id="hotelNameEnLocal" name="hotelNameEnLocal" type="hidden" value=""/>
<input id="page" name="page" type="hidden" value=""/>
<!-- reservation or api -->
<input id="typeApplication" name="typeApplication" type="hidden" value=""/>
</div>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
<div class="form-group">
<input class="hotelStartDateShamsi form-control" id="startDateForHotelLocal" name="startDateForHotelLocal" placeholder="تاریخ ورود" readonly="" type="text"/>
<!--                                        <i class="fal fa-calendar-alt"></i>-->
</div>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
<div class="form-group">
<input class="hotelEndDateShamsi form-control" id="endDateForHotelLocal" name="endDateForHotelLocal" placeholder="تاریخ خروج" readonly="" type="text"/>
<!--                                        <i class="fal fa-calendar-alt"></i>-->
</div>
</div>
<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search">
<div class="days-in-hotel">
<input id="NightsForHotelLocal" name="NightsForHotelLocal" type="hidden" value=""/>
<!--                                        <i class="fal fa-moon"></i>-->
                                    مدت اقامت
                                    <div class="result-st">
<em class="days" id="stayingTimeForHotelLocal"> 0 </em> شب
                                    </div>
</div>
</div>
<div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search">
<button class="btn theme-btn seub-btn b-0" onclick="gds_hotel_local_check()" type="button">
<span>جستجو</span></button>
</div>
</form>
</div>
<div class="row" id="hotel_khareji">
<form class="d-contents">
<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search search_col">
<div class="form-group">
<span class="destnition_start">
<input class="form-control" id="AutoComplateSearchIN" name="AutoComplateSearchIN" onkeyup="searchCityExternalHotel()" placeholder="شهر مقصد" type="text"/>
</span>
<div class="resultUlInputSearch display-0" id="divCityExternalHotelLists"></div>
<input id="destination_country" name="destination_country" type="hidden" value=""/>
<input id="destination_city" name="destination_city" type="hidden" value=""/>
</div>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
<div class="form-group">
<input class="externalHotelStartDateShamsi form-control" id="startDateForExternalHotelLocal" name="startDateForHotelLocal" placeholder="تاریخ ورود" readonly="" type="text">
<!--                                        <i class="fal fa-calendar-alt"></i>-->
</input></div>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
<div class="form-group">
<input class="externalHotelEndDateShamsi form-control" id="endDateForExternalHotelLocal" name="endDateForExternalHotelLocal" placeholder="تاریخ خروج" readonly="" type="text"/>
<!--                                        <i class="fal fa-calendar-alt"></i>-->
</div>
</div>
<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search">
<div class="form-group">
<div class="hotel_passenger_picker">
<ul>
<li><em class="number_adult">2</em> بزرگسال ،</li>
<li class="li_number_baby"><em class="number_baby">0</em> کودک ،</li>
<li><em class="number_room">1</em>اتاق</li>
</ul>
<div class="myhotels-rooms">
<i class="close_room"></i>
<div class="hotel_select_room">
<div class="myroom-hotel-item" data-roomnumber="1">
<div class="myroom-hotel-item-title">
<span class="close" style="display: none">
<i class="fal fa-trash-alt"></i>
</span>
                                                        اتاق اول

                                                    </div>
<div class="myroom-hotel-item-info">
<div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
<h6>بزرگسال</h6>
                                                            (بزرگتر از ۱۲ سال)
                                                            <div>
<i class="addParent plus-nafar hotelroom-minus plus-hotelroom-bozorgsal fas fa-plus"></i>
<input autocomplete="off" class="countParent" id="adult1" max="5" min="0" name="adult1" readonly="" type="number" value="2"/><i class="minusParent minus-nafar hotelroom-minus minus-hotelroom-bozorgsal fas fa-minus"></i>
</div>
</div>
<div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
<h6>کودک</h6>
                                                            (کوچکتر از ۱۲ سال)

                                                            <div>
<i class="addChild plus-nafar hotelroom-minus plus-hotelroom-koodak fas fa-plus"></i>
<input autocomplete="off" class="countChild" id="child1" max="5" min="0" name="child1" readonly="" type="number" value="0"/><i class="minusChild minus-nafar hotelroom-minus minus-hotelroom-koodak fas fa-minus"></i>
</div>
</div>
<div class="tarikh-tavalods"></div>
</div>
</div>
</div>
<div class="btn_add_room">
<i class="fal fa-plus"></i>
                                                افزودن اتاق
                                            </div>
</div>
</div>
</div>
</div>
<div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search">
<input id="NightsForExternalHotelLocal" name="nights" type="hidden"/>
<button class="btn theme-btn seub-btn b-0" onclick="submitSearchExternalHotel()" type="button">
<span>جستجو</span>
</button>
</div>
</form>
</div>
</div>
<div aria-labelledby="insurance-tab" class="tab-pane" id="insurance" role="tabpanel">
<div class="col-md-12 col-12">
<div class="row">
<form class="d-contents">
<div class="col-lg-3 col-md-4 col-sm-6 col-12 col_search">
<div class="form-group">
<select class="select2" data-placeholder="نام کشور مقصد" id="insurance_destination_country" name="insurance_destination_country">
<option value="">انتخاب کنید...</option>
</select>
</div>
</div>
<div class="col-lg-3 col-md-4 col-sm-6 col-12 col_search">
<div class="form-group">
<select class="select2" data-placeholder="انتخاب مدت سفر" id="travel_time" name="travel_time">
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
</select>
</div>
</div>
<div class="col-lg-2 col-md-4 col-sm-6 col-12 col_search">
<div class="form-group">
<select class="select2" data-placeholder="انتخاب تعداد مسافر" id="number_of_passengers" name="number_of_passengers">
<option value="">انتخاب کنید...</option>
<option value="1">1 نفر</option>
<option value="2">2 نفر</option>
<option value="3">3 نفر</option>
<option value="4">4 نفر</option>
<option value="5">5 نفر</option>
<option value="6">6 نفر</option>
<option value="7">7 نفر</option>
<option value="8">8 نفر</option>
<option value="9">9 نفر</option>
</select>
</div>
</div>
<div class="nafaratbime">
<div class="col-lg-2 col-md-4 col-sm-6 col-12 col_search search_col nafarat-bime">
<div class="form-group">
<input autocomplete="off" class="form-control shamsiBirthdayCalendar" id="txt_birth_insurance1" name="txt_birth_insurance1" placeholder="تاریخ تولد مسافر 1" type="text"/>
<!--                                                <i class="fal fa-calendar-alt"></i>-->
</div>
</div>
</div>
<div class="col-lg-2 col-md-3 col-sm-6 col-12 col_search search_btn_insuranc">
<button class="btn theme-btn seub-btn b-0" onclick="gds_insurance_check()" type="button"><span>جستجو</span></button>
</div>
</form>
</div>
</div>
</div>
<div aria-labelledby="train-tab" class="tab-pane" id="bus" role="tabpanel">
<div class="col-md-12 col-12">
<div class="row">
<form class="d_contents w-100 d-flex flex-wrap" data-action="https://s360online.iran-tech.com/" id="gds_local_bus" method="post" name="gds_local_bus" target="_blank">
<div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search">
<div class="form-group m-0">
<select class="select2" data-placeholder="نام شهر مبدأ" id="gds_origin_local" name="gds_origin_local">
<option value="">مشهد</option>
</select>
</div>
</div>
<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search">
<div class="form-group m-0">
<select class="select2" data-placeholder="نام شهر مقصد" id="gds_origin_local" name="gds_origin_local">
<option value="">مشهد</option>
</select>
</div>
</div>
<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search search_col">
<div class="form-group m-0">
<input class="shamsiDeptCalendar form-control hasDatepicker" id="gds_dept_date_bus" name="gds_dept_date_bus" placeholder="تاریخ حرکت" type="text"/>
<!--                                            <i class="fal fa-calendar-alt"></i>-->
</div>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search">
<button class="btn theme-btn seub-btn b-0" onclick="gds_insurance_check()" type="button"><span>جستجو</span></button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
{include file="include_files/footer.tpl"}
</body>




{include file="include_files/footer_script.tpl"}
</html>