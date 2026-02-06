<div class="__box__ tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="Hotel">
    <h4 class='title-searchBox-mobile'>جستجو برای هتل های داخلی و خارجی</h4>
    <div class="d-flex flex-wrap gap-search-box">
        <div class="parent-btn-switch">
            <button type="button" class="btn-switch-searchBox active">هتل داخلی</button>
            <button type="button" class="btn-switch-searchBox">هتل خارجی</button>
        </div>
        <div id="internal_hotel" class="_internal d_flex flex-wrap internal-hotel-js internal-content-hotel w-100">
            <form data-action="s360online.iran-tech.com/" name="gdsHotelLocal"
                  target="_blank" id="internal_hotel_form" class="d_contents" method="post">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search search_col p-1">
                    <div class=" destination_start">
                        <div class="s-u-in-out-wrapper raft raft-change change-bor w-100 parent-input-search-box">
                            <i class="parent-svg-input-search-box">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>
                            </i>
                            <label for='autoComplateSearchIN' class="caption-input-search-box">مقصد خود را وارد کنید</label>
                            <input id="autoComplateSearchIN" name="autoComplateSearchIN"
                                   class="inputSearchForeign w-100 " type="text" value=""
                                   placeholder='مقصد یا هتل (داخلی)'
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
                    <div class="parent-input-search-box">
                        <i class="parent-svg-input-search-box">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/></svg>
                        </i>
                        <label for='startDateForHotelLocal' class="caption-input-search-box">تاریخ ورود خود را انتخاب کنید</label>
                        <input type="text"
                               autocomplete="off"
                               class="init-shamsi-datepicker check-in-date-js"
                               name="startDateForHotelLocal"
                               id="startDateForHotelLocal"
                               placeholder="تاریخ ورود"
                               data-type='internal'>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
                    <div class="parent-input-search-box">
                        <i class="parent-svg-input-search-box">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/></svg>
                        </i>
                        <label for='endDateForHotelLocal' class="caption-input-search-box">تاریخ خروج خود را انتخاب کنید</label>
                        <input type="text"
                               class="init-shamsi-return-datepicker  check-out-date-internal-js"
                               name="endDateForHotelLocal"
                               autocomplete="off"
                               id="endDateForHotelLocal"
                               placeholder="تاریخ خروج"
                               data-type='internal'>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search p-1">
                    <div class="hotel_passenger_picker internal-hotel-passenger-picker-js parent-input-search-box">
                        <i class="parent-svg-input-search-box">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"></path></svg>
                        </i>
                        <ul onclick="openCountPassenger('internal')">
                            <li><em class="number_adult internal-number-adult-js">2</em> بزرگسال ,</li>
                            <li class="li_number_baby"><em class="number_baby internal-number-child-js">0</em> کودک ،</li>
                            <li><em class="number_room_po internal-number-room-js">1</em>اتاق</li>
                        </ul>
                        <div class="caption-input-search-box">تعداد مسافر</div>
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
                                                <input readonly="" autocomplete="off" class="countParent internal-count-parent-js" min="0" value="2" max="5" type="text" name="adult1" id="adult1">
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
                                                <input readonly="" class="countChild internal-count-child-js" autocomplete="off" min="0" value="0" max="5" type="text" name="child1" id="child1">
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

                <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search margin-center p-1">
                    <button type="button" onclick="searchInternalHotel()"
                            class="btn theme-btn seub-btn b-0">
                        <span>جستجو</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M368 208A160 160 0 1 0 48 208a160 160 0 1 0 320 0zM337.1 371.1C301.7 399.2 256.8 416 208 416C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208c0 48.8-16.8 93.7-44.9 129.1L505 471c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L337.1 371.1z"/></svg>
                    </button>
                </div>
            </form>
        </div>
        <div id="international_hotel" class="_external flex-wrap international-hotel-js external-content-hotel w-100">
            <form target="_blank" data-action="https://s360online.iran-tech.com/" class="d_contents"  method="post" id="international_hotel_form">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search search_col p-1">
                    <div class=" destination_start">
                        <div class="s-u-in-out-wrapper raft raft-change change-bor inputSearchForeign-box inputSearchForeign-pad_Fhotel w-100 parent-input-search-box ">
                            <i class="parent-svg-input-search-box">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"></path></svg>
                            </i>
                            <label for='autoComplateSearchIN_2' class="caption-input-search-box">مقصد خود را وارد کنید</label>
                            <input id="autoComplateSearchIN_2" name="autoComplateSearchIN"
                                   class="inputSearchForeign w-100 " type="text" value=""
                                   placeholder='مقصد یا هتل (خارجی)'
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
                <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
                    <div class="parent-input-search-box">
                        <i class="parent-svg-input-search-box">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"></path></svg>
                        </i>
                        <label for='startDateForExternalHotelInternational' class="caption-input-search-box">تاریخ ورود خود را انتخاب کنید</label>
                        <input readonly="" type="text"
                               autocomplete="off"
                               class="init-shamsi-datepicker check-in-date-international-js"
                               name="startDateForHotelInternational" id="startDateForExternalHotelInternational"
                               placeholder="تاریخ ورود"
                               data-type='international'>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
                    <div class="parent-input-search-box">
                        <i class="parent-svg-input-search-box">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"></path></svg>
                        </i>
                        <label for='endDateForExternalHotelInternational' class="caption-input-search-box">تاریخ خروج خود را انتخاب کنید</label>
                        <input readonly="" type="text"
                               class="init-shamsi-return-datepicker check-out-date-international-js"
                               name="endDateForExternalHotelInternational"
                               autocomplete="off"
                               id="endDateForExternalHotelInternational"
                               placeholder="تاریخ خروج"
                               data-type='international'>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search p-1">
                    <div class="hotel_passenger_picker international-hotel-passenger-picker-js parent-input-search-box">
                        <i class="parent-svg-input-search-box">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"></path></svg>
                        </i>
                        <ul onclick="openCountPassenger('international')">
                            <li><em class="number_adult international-number-adult-js">2</em> بزرگسال ،</li>
                            <li class="li_number_baby"><em class="number_baby international-number-child-js">0</em> کودک ،</li>
                            <li><em class="number_room_po international-number-room-js">1</em>اتاق</li>
                        </ul>
                        <div class="caption-input-search-box">تعداد مسافر</div>
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
                                                       max="5" type="text" name="adult1" id="adult1">
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
                                                       type="text" name="child1" id="child1"><i
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
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search margin-center p-1">
                    <input type="hidden" id="nights_hotel" name="nights_hotel" value="" placeholder='تاریخ خروج' class='nights-hotel-js'>

                    <button onclick="searchInternationalHotel()" type="button"  class="btn theme-btn seub-btn b-0">
                        <span>جستجو</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M368 208A160 160 0 1 0 48 208a160 160 0 1 0 320 0zM337.1 371.1C301.7 399.2 256.8 416 208 416C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208c0 48.8-16.8 93.7-44.9 129.1L505 471c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L337.1 371.1z"/></svg>
                    </button>
                </div>
            </form>
        </div>
        <input type='hidden' id="type_section" name="type_section" class="type-section-js" value="internal">
    </div>
</div>