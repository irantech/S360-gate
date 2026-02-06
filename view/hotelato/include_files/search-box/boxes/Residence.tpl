<div class="__box__ tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="Residence">
    <div class='row'>
        <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
            <div class="form-group destination_start">
                <div class="s-u-in-out-wrapper raft raft-change change-bor w-100">
                    <input autocomplete="off" class="inputSearchForeign w-100" id="autoComplateSearchINResidence"
                           name="autoComplateSearchINResidence" onclick="openBoxPopular('residence')"
                           onkeyup="searchCity('residence')" placeholder="انتخاب شهر" type="text" value="" />
                    <input id="autoComplateSearchIN_hiddenResidence"  placeholder="انتخاب شهر" type="hidden"
                           value="" />
                    <input id="autoComplateSearchIN_hidden_en_residence" placeholder="انتخاب شهر"
                           type="hidden" value=""  />
                    <ul class="ul-inputSearch-externalHotel displayiN" id="listSearchCityResidence"></ul>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
            <div class="parent-input-search-box">
                <select onchange='typeResidenceOpen()' data-placeholder="نوع اقامتگاه" name="type_residence"
                        id="type_residence"
                        class="select2  select2-hidden-accessible type_residence"
                        aria-hidden="true">
                    <option class='' selected="selected" value="">نوع اقامتگاه</option>
                    <option value="ندارد">ندارد</option>
                    <option value="1">هتل</option>
                    <option value="2">هتل آپارتمان</option>
                    <option value="3">مهمانسرا</option>
                    <option value="4">خانه سنتی</option>
                    <option value="5">هتل سنتی</option>
                    <option value="6">اقامتگاه بوم گردی</option>
                    <option value="7">هتل جنگلی</option>
                    <option value="8">مجموعه فرهنگی تفریحی</option>
                    <option value="9">پانسیون</option>
                    <option value="10">متل</option>
                    <option value="12">ویلا</option>
                    <option value="13">کاروانسرا</option>
                    <option value="14">مجتمع اقامتی</option>
                    <option value="15">خانه محلی</option>
                    <option value="16">ویلا هتل</option>
                    <option value="100">هاستل</option>
                    <option value="101">بوتیک</option>
                </select>
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
            <div class="form-group">
                <input autocomplete="off" class="init-shamsi-datepicker form-control check-in-date-residence-js"
                       data-type="residence" id="startDateForHotelLocalResidence"
                       name="startDateForHotelLocalResidence" placeholder="تاریخ ورود" type="text" />
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
            <div class="form-group">
                <input autocomplete="off"
                       class="init-shamsi-return-datepicker form-control check-out-date-residence-js"
                       data-type="residence" id="endDateForHotelLocal2" name="endDateForHotelLocal2"
                       placeholder="تاریخ خروج" type="text" />
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
            <div class="form-group">
                <div class="hotel_passenger_picker residence-passenger-picker-js">
                    <ul onclick="openCountPassenger('residence')">
                        <li class='residence-number-guest'><em class="number_adult residence-number-adult-js">1</em> بزرگسال ،</li>
                        <li class="li_number_baby residence-number-guest"><em class="number_baby residence-number-child-js">0</em> کودک ،</li>
                        <li class='residence-number-guest'><em class="number_room_po residence-number-room-js">1</em>اتاق</li>
                    </ul>
                    <div class="myhotels-rooms residence-myhotels-rooms residence-my-hotels-rooms-js">
                        <div class="hotel_select_room residence-hotel-select-room-js">
                            <div class="myroom-hotel-item residence-my-room-hotel-item-js" data-roomnumber="1">
                                <div class="myroom-hotel-item-title residence-my-room-hotel-item-title-js">
                                        <span class="close d-none" onclick="itemsRoom($(this),'residence')">
                                            <i>
                                                <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path
                                                            d="M144 400C144 408.8 136.8 416 128 416C119.2 416 112 408.8 112 400V176C112 167.2 119.2 160 128 160C136.8 160 144 167.2 144 176V400zM240 400C240 408.8 232.8 416 224 416C215.2 416 208 408.8 208 400V176C208 167.2 215.2 160 224 160C232.8 160 240 167.2 240 176V400zM336 400C336 408.8 328.8 416 320 416C311.2 416 304 408.8 304 400V176C304 167.2 311.2 160 320 160C328.8 160 336 167.2 336 176V400zM310.1 22.56L336.9 64H432C440.8 64 448 71.16 448 80C448 88.84 440.8 96 432 96H416V432C416 476.2 380.2 512 336 512H112C67.82 512 32 476.2 32 432V96H16C7.164 96 0 88.84 0 80C0 71.16 7.164 64 16 64H111.1L137 22.56C145.8 8.526 161.2 0 177.7 0H270.3C286.8 0 302.2 8.526 310.1 22.56V22.56zM148.9 64H299.1L283.8 39.52C280.9 34.84 275.8 32 270.3 32H177.7C172.2 32 167.1 34.84 164.2 39.52L148.9 64zM64 432C64 458.5 85.49 480 112 480H336C362.5 480 384 458.5 384 432V96H64V432z"></path></svg>
                                            </i>
                                        </span>
                                    اتاق اول
                                </div>
                                <div class="myroom-hotel-item-info residence-my-room-hotel-item-info-js">
                                    <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
                                        <h6>بزرگسال</h6>

                                        (بزرگتر از ۱۲ سال)

                                        <div>
                                            <i class="addParent residence-add-number-adult-js hotelroom-minus plus-hotelroom-bozorgsal"
                                               onclick="addNumberAdult('residence',this)">
                                                <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                                    <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                    <path d="M432 256C432 269.3 421.3 280 408 280h-160v160c0 13.25-10.75 24.01-24 24.01S200 453.3 200 440v-160h-160c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h160v-160c0-13.25 10.75-23.99 24-23.99S248 58.75 248 72v160h160C421.3 232 432 242.8 432 256z"></path>
                                                </svg>
                                            </i>
                                            <input autocomplete="off" class="countParent residence-count-parent-js"
                                                   id="adult1" max="5" min="0" name="adult1" readonly=""
                                                   type="number" value="1" />
                                            <i class="minusParent residence-minus-number-adult-js hotelroom-minus minus-hotelroom-bozorgsal"
                                               onclick="minusNumberAdult('residence',this)">
                                                <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                                    <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                    <path d="M432 256C432 269.3 421.3 280 408 280H40c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h368C421.3 232 432 242.8 432 256z"></path>
                                                </svg>
                                            </i>
                                        </div>
                                    </div>
                                    <div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
                                        <h6>کودک</h6>

                                        (کوچکتر از ۱۲ سال)


                                        <div>
                                            <i class="addChild residence-add-number-child-js hotelroom-minus plus-hotelroom-koodak"
                                               onclick="addNumberChild('residence',this)">
                                                <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                                    <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                    <path d="M432 256C432 269.3 421.3 280 408 280h-160v160c0 13.25-10.75 24.01-24 24.01S200 453.3 200 440v-160h-160c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h160v-160c0-13.25 10.75-23.99 24-23.99S248 58.75 248 72v160h160C421.3 232 432 242.8 432 256z"></path>
                                                </svg>
                                            </i>
                                            <input autocomplete="off" class="countChild residence-count-child-js"
                                                   id="child1" max="5" min="0" name="child1" readonly=""
                                                   type="number" value="0" />
                                            <i class="minusChild residence-minus-number-child-js hotelroom-minus minus-hotelroom-koodak"
                                               onclick="minusNumberChild('residence',this)">
                                                <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                                    <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                    <path d="M432 256C432 269.3 421.3 280 408 280H40c-13.25 0-24-10.74-24-23.99C16 242.8 26.75 232 40 232h368C421.3 232 432 242.8 432 256z"></path>
                                                </svg>
                                            </i>
                                        </div>
                                    </div>
                                    <div class="tarikh-tavalods residence-birth-days-js"></div>
                                </div>
                            </div>
                        </div>
                        <div class="btn_group">
                            <div class="btn_add_room residence-btn-add-room-js" onclick="addRoom('residence')">
                                <i class="fal fa-plus"></i>

                                افزودن اتاق

                            </div>
                            <div class="close_room btn_close_box residence-close-room-js">
                                <i class="fal fa-check"></i>

                                تایید

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search d-flex margin-center">
            <input type="hidden" id="nights_hotel" name="nights_hotel" value="" placeholder='##Exitdate##' class='nights-hotel-js'>

            <button class="btn theme-btn seub-btn b-0 residence-theme-btn" onclick="searchResidence()" type="button">
                <span>جستجو</span></button>
        </div>
    </div>
</div>
