<div class="__box__ tab-pane {if $active} active {/if}" id="Hotel">
<div class="radios switches">
<div class="switch">
<input autocomplete="off" class="switch-input switch-input-hotel-js" id="btn_switch_Hotel_international" name="btn_switch_Hotel" type="radio" value="0"/>
<label class="switch-label switch-label-on" for="btn_switch_Hotel_international">خارجی</label>
<input autocomplete="off" checked="" class="switch-input switch-input-hotel-js" id="btn_switch_Hotel_internal" name="btn_switch_Hotel" type="radio" value="1"/>
<label class="switch-label switch-label-off" for="btn_switch_Hotel_internal">داخلی</label>
<span class="switch-selection"></span>
</div>
</div>
<div class="d_flex flex-wrap internal-hotel-js" id="internal_hotel">
<form class="d_contents" data-action="s360online.iran-tech.com/" id="internal_hotel_form" method="post" name="gdsHotelLocal" target="_blank">
<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search search_col p-1">
<div class="form-group destination_start">
<div class="s-u-in-out-wrapper raft raft-change change-bor w-100">
<input autocomplete="off" class="inputSearchForeign w-100" id="autoComplateSearchIN" name="autoComplateSearchIN" onclick="openBoxPopular('hotel')" onkeyup="searchCity('hotel')" placeholder="انتخاب شهر" type="text" value=""/>
<input id="autoComplateSearchIN_hidden" placeholder="انتخاب شهر" type="hidden" value=""/>
<input id="autoComplateSearchIN_hidden_en" placeholder="انتخاب شهر" type="hidden" value=""/>
<ul class="ul-inputSearch-externalHotel displayiN" id="listSearchCity"></ul>
</div>
</div>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
<div class="form-group">
<input autocomplete="off" class="init-shamsi-datepicker form-control check-in-date-js" data-type="internal" id="startDateForHotelLocal" name="startDateForHotelLocal" placeholder="تاریخ ورود" type="text"/>
</div>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
<div class="form-group">
<input autocomplete="off" class="init-shamsi-return-datepicker form-control check-out-date-internal-js" data-type="internal" id="endDateForHotelLocal" name="endDateForHotelLocal" placeholder="تاریخ خروج" type="text"/>
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
<div class="myroom-hotel-item internal-my-room-hotel-item-js" data-roomnumber="1">
<div class="myroom-hotel-item-title internal-my-room-hotel-item-title-js">
<span class="close d-none" onclick="itemsRoom($(this),'internal')">
<i>
<svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M144 400C144 408.8 136.8 416 128 416C119.2 416 112 408.8 112 400V176C112 167.2 119.2 160 128 160C136.8 160 144 167.2 144 176V400zM240 400C240 408.8 232.8 416 224 416C215.2 416 208 408.8 208 400V176C208 167.2 215.2 160 224 160C232.8 160 240 167.2 240 176V400zM336 400C336 408.8 328.8 416 320 416C311.2 416 304 408.8 304 400V176C304 167.2 311.2 160 320 160C328.8 160 336 167.2 336 176V400zM310.1 22.56L336.9 64H432C440.8 64 448 71.16 448 80C448 88.84 440.8 96 432 96H416V432C416 476.2 380.2 512 336 512H112C67.82 512 32 476.2 32 432V96H16C7.164 96 0 88.84 0 80C0 71.16 7.164 64 16 64H111.1L137 22.56C145.8 8.526 161.2 0 177.7 0H270.3C286.8 0 302.2 8.526 310.1 22.56V22.56zM148.9 64H299.1L283.8 39.52C280.9 34.84 275.8 32 270.3 32H177.7C172.2 32 167.1 34.84 164.2 39.52L148.9 64zM64 432C64 458.5 85.49 480 112 480H336C362.5 480 384 458.5 384 432V96H64V432z"></path></svg>
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
<svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M432 256C432 269.3 421.3 280 408 280h-160v160c0 13.25-10.75 24.01-24 24.01S200 453.3 200 440v-160h-160c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h160v-160c0-13.25 10.75-23.99 24-23.99S248 58.75 248 72v160h160C421.3 232 432 242.8 432 256z"></path></svg>
</i>
<input autocomplete="off" class="countParent internal-count-parent-js" id="adult1" max="5" min="0" name="adult1" readonly="" type="number" value="2"/>
<i class="minusParent internal-minus-number-adult-js hotelroom-minus minus-hotelroom-bozorgsal" onclick="minusNumberAdult('internal',this)">
<svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M432 256C432 269.3 421.3 280 408 280H40c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h368C421.3 232 432 242.8 432 256z"></path></svg>
</i>
</div>
</div>
<div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
<h6>کودک</h6>

                                                                        (کوچکتر از ۱۲ سال)



                                                                        <div>
<i class="addChild internal-add-number-child-js hotelroom-minus plus-hotelroom-koodak" onclick="addNumberChild('internal',this)">
<svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M432 256C432 269.3 421.3 280 408 280h-160v160c0 13.25-10.75 24.01-24 24.01S200 453.3 200 440v-160h-160c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h160v-160c0-13.25 10.75-23.99 24-23.99S248 58.75 248 72v160h160C421.3 232 432 242.8 432 256z"></path></svg>
</i>
<input autocomplete="off" class="countChild internal-count-child-js" id="child1" max="5" min="0" name="child1" readonly="" type="number" value="0"/>
<i class="minusChild internal-minus-number-child-js hotelroom-minus minus-hotelroom-koodak" onclick="minusNumberChild('internal',this)">
<svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M432 256C432 269.3 421.3 280 408 280H40c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h368C421.3 232 432 242.8 432 256z"></path></svg>
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
<button class="btn theme-btn seub-btn b-0" onclick="searchInternalHotel()" type="button"><span>جستجو</span></button>
</div>
</form>
</div>
<div class="flex-wrap international-hotel-js" id="international_hotel">
<form class="d_contents" data-action="https://s360online.iran-tech.com/" id="international_hotel_form" method="post" target="_blank">
<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search search_col p-1">
<div class="form-group destination_start">
<div class="inputSearchForeign-box inputSearchForeign-pad_Fhotel w-100">
<div class="s-u-in-out-wrapper raft raft-change change-bor">
<input autocomplete="off" class="inputSearchForeign w-100 form-control" id="autoComplateSearchIN_2" name="autoComplateSearchIN" onclick="openBoxPopular('externalHotel')" onkeyup="searchCity('externalHotel')" placeholder="انتخاب شهر" type="text" value=""/>
<input id="destination_country" name="destination_country" placeholder="انتخاب شهر" type="hidden" value=""/>
<input class="destination-country-js" name="destination-country-js" placeholder="انتخاب شهر" type="hidden" value=""/>
<input class="destination-city-js" name="destination-city-js" placeholder="انتخاب شهر" type="hidden" value=""/>
<input id="destination_city_foreign" name="destination_city_foreign" placeholder="انتخاب شهر" type="hidden" value=""/>
<input id="destination_city" name="destination_city" placeholder="انتخاب شهر" type="hidden" value=""/>
<ul class="ul-inputSearch-externalHotel displayiN" id="listSearchCity_2"></ul>
</div>
</div>
</div>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
<div class="form-group">
<input autocomplete="off" class="init-shamsi-datepicker form-control check-in-date-international-js" data-type="international" id="startDateForExternalHotelInternational" name="startDateForHotelInternational" placeholder="تاریخ ورود" readonly="" type="text"/>

</div>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
<div class="form-group">
<input autocomplete="off" class="init-shamsi-return-datepicker form-control check-out-date-international-js" data-type="international" id="endDateForExternalHotelInternational" name="endDateForExternalHotelInternational" placeholder="تاریخ خروج" readonly="" type="text"/>
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
<div class="myroom-hotel-item international-my-room-hotel-item-js" data-roomnumber="1">
<div class="myroom-hotel-item-title international-my-room-hotel-item-title-js">
<span class="close d-none" onclick="itemsRoom('international')">
<i>
<svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M144 400C144 408.8 136.8 416 128 416C119.2 416 112 408.8 112 400V176C112 167.2 119.2 160 128 160C136.8 160 144 167.2 144 176V400zM240 400C240 408.8 232.8 416 224 416C215.2 416 208 408.8 208 400V176C208 167.2 215.2 160 224 160C232.8 160 240 167.2 240 176V400zM336 400C336 408.8 328.8 416 320 416C311.2 416 304 408.8 304 400V176C304 167.2 311.2 160 320 160C328.8 160 336 167.2 336 176V400zM310.1 22.56L336.9 64H432C440.8 64 448 71.16 448 80C448 88.84 440.8 96 432 96H416V432C416 476.2 380.2 512 336 512H112C67.82 512 32 476.2 32 432V96H16C7.164 96 0 88.84 0 80C0 71.16 7.164 64 16 64H111.1L137 22.56C145.8 8.526 161.2 0 177.7 0H270.3C286.8 0 302.2 8.526 310.1 22.56V22.56zM148.9 64H299.1L283.8 39.52C280.9 34.84 275.8 32 270.3 32H177.7C172.2 32 167.1 34.84 164.2 39.52L148.9 64zM64 432C64 458.5 85.49 480 112 480H336C362.5 480 384 458.5 384 432V96H64V432z"></path></svg>
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
<input autocomplete="off" class="countParent international-count-parent-js" id="adult1" max="5" min="0" name="adult1" readonly="" type="number" value="2"/>
<i class="minusParent international-minus-number-adult-js hotelroom-minus minus-hotelroom-bozorgsal fas fa-minus" onclick="minusNumberAdult('international',this)"></i>
</div>
</div>
<div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
<h6>کودک</h6>

                                                                        (کوچکتر از ۱۲ سال)



                                                                        <div>
<i class="addChild international-add-number-child-js hotelroom-minus plus-hotelroom-koodak fas fa-plus" onclick="addNumberChild('international',this)"></i>
<input autocomplete="off" class="countChild international-count-child-js" id="child1" max="5" min="0" name="child1" readonly="" type="number" value="0"/><i class="minusChild international-minus-number-child-js hotelroom-minus minus-hotelroom-koodak fas fa-minus" onclick="minusNumberChild('international',this)"></i>
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
<input class="nights-hotel-js" id="nights_hotel" name="nights_hotel" placeholder="تاریخ خروج" type="hidden" value=""/>
<button class="btn theme-btn seub-btn b-0" onclick="searchInternationalHotel()" type="button"><span>جستجو</span></button>
</div>
</form>
</div>
<input class="type-section-js" id="type_section" name="type_section" type="hidden" value="internal"/>
</div>