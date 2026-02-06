<div class="__box__ tab-pane  {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="Flight-international">
<div class="_external d_flex flex-wrap international-flight-js" id="international_flight">
<form class="d_contents" data-action="https://s360online.iran-tech.com/" id="international_flight_form" method="post" name="international_flight_form" target="_blank">
<div class="col-md-12 col-xs-12 col-sm-12 d-ceckboxs">
<div class="cntr">
<label class="btn-radio select-type-way-js" data-type="international" for="rdo-3">
<input checked="" class="multiselectportal international-one-way-js" id="rdo-3" name="select-rb" type="radio" value="1"/>
<svg height="20px" viewbox="0 0 20 20" width="20px">
<circle cx="10" cy="10" r="9"></circle>
<path class="inner" d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"></path>
<path class="outer" d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"></path>
</svg>
<span>یک طرفه </span>
</label>
<label class="btn-radio select-type-way-js" data-type="international" for="rdo-4">
<input class="multiselectportal international-two-way-js" id="rdo-4" name="select-rb" type="radio" value="2"/>
<svg height="20px" viewbox="0 0 20 20" width="20px">
<circle cx="10" cy="10" r="9"></circle>
<path class="inner" d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"></path>
<path class="outer" d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"></path>
</svg>
<span>دو طرفه </span>
</label>
</div>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col col_with_route p-1">
<div class="form-group origin_start">
<input autocomplete="off" class="form-control inputSearchForeign iata-origin-international-js" id="iata_origin_international" name="iata_origin_international" onclick='displayCityListExternal("origin" , event)' placeholder="مبدأ (شهر,فرودگاه)" type="text"/>
<input class="origin-international-js" data-border-red="#iata_origin_international" id="origin_international" name="iata_origin_international" type="hidden" value=""/>
<div class="resultUlInputSearch list-show-result list-origin-airport-international-js" id="list_airport_origin_international">
</div>
<div class="resultUlInputSearch list-show-result list_popular_origin_external-js" id="list_origin_popular_external">
</div>
</div>
<button class="switch_routs" name="button" onclick="reversDestination('international')" type="button">
<svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M443.3 139.3c6.2-6.2 6.2-16.4 0-22.6l-96-96c-6.2-6.2-16.4-6.2-22.6 0s-6.2 16.4 0 22.6L393.4 112 16 112c-8.8 0-16 7.2-16 16s7.2 16 16 16l377.4 0-68.7 68.7c-6.2 6.2-6.2 16.4 0 22.6s16.4 6.2 22.6 0l96-96zm-342.6 352c6.2 6.2 16.4 6.2 22.6 0s6.2-16.4 0-22.6L54.6 400 432 400c8.8 0 16-7.2 16-16s-7.2-16-16-16L54.6 368l68.7-68.7c6.2-6.2 6.2-16.4 0-22.6s-16.4-6.2-22.6 0l-96 96c-6.2 6.2-6.2 16.4 0 22.6l96 96z"></path></svg>
</button>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
<div class="form-group">
<span class="destnition_start">
<input autocomplete="off" class="inputSearchForeign form-control iata-destination-international-js" id="iata_destination_international" name="iata_destination_international" onclick='displayCityListExternal("destination" , event)' placeholder="مقصد (شهر,فرودگاه)" type="text"/>
</span>
<input class="destination-international-js" data-border-red="#iata_destination_international" id="destination_international" name="destination_international" type="hidden" value=""/>
<div class="resultUlInputSearch list-show-result list-destination-airport-international-js" id="list_destination_airport_international">
</div>
<div class="resultUlInputSearch list-show-result list_popular_destination_external-js" id="list_destination_popular_external">
</div>
</div>
</div>
<div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search date_search p-1">
<div class="form-group">
<input class="deptCalendar form-control went departure-date-international-js" id="departure_date_international" name="departure_date_international" placeholder="تاریخ رفت" readonly="" type="text"/>
</div>
<div class="form-group">
<input class="form-control return_input2 returnCalendar international-arrival-date-js" disabled="" id="arrival_date_international" name="arrival_date_international" placeholder="تاریخ برگشت" readonly="" type="text"/>
</div>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
<div class="select inp-s-num adt box-of-count-passenger box-of-count-passenger-js">
<input class="international-adult-js" id="count_adult_international" name="adult_number_international" type="hidden" value="1"/>
<input class="international-child-js" id="count_child_international" name="child_number_international" type="hidden" value="0"/>
<input class="international-infant-js" id="count_infant_international" name="infant_number_international" type="hidden" value="0"/>
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
<i class="number-count-js number-count counting-of-count-passenger" data-min="1" data-number="1" data-search="international" data-type="adult">1</i>
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
<i class="number-count-js number-count counting-of-count-passenger" data-min="0" data-number="0" data-search="international" data-type="child">0</i>
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
<i class="number-count-js number-count counting-of-count-passenger" data-min="0" data-number="0" data-search="international" data-type="infant">0</i>
<i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js"></i>
</div>
</div>
</div>
</div>
<div class="div_btn"><span class="btn btn-close">تأیید</span></div>
</div>
</div>
</div>
<div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search margin-center p-1">
<button class="btn theme-btn seub-btn b-0" onclick="searchFlight('international')" type="button"><span>جستجو</span></button>
</div>
</form>
</div>
</div>