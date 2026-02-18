
{if $smarty.const.SOFTWARE_LANG eq 'fa'}
    {assign var='noLimitCalendar' value="shamsiNoLimitCalendar"}
    {assign var="sDate" value=$objFunctions->DatePrev($objDate->jdate("Y-m-d", '', '', '', 'en'), '100')}
    {assign var="eDate" value=$objDate->jdate("Y-m-d", '', '', '', 'en')}

{else}
    {assign var='noLimitCalendar' value="gregorianNoLimitCalendar"}
    {assign var="sDate" value=$objFunctions->DatePrev(date("Y-m-d"), '7')}
    {assign var="eDate" value=date("Y-m-d")}
{/if}

<div id='market-place-loader' class="market-place-loader loader2">
    <div></div>
    <div></div>
    <div></div>
</div>
<section class="data-room">
    <input type="hidden" name="hotel_id" id="hotel_id" value='{$smarty.const.MARKET_HOTEL_ID}'>
    <div class="top-calendar-control">
        <div class="parent-filter-box">
            <h4>نمایش بر اساس</h4>
            <div class="filter-box-btn">
                <button class='capacityRoom' type="button">ظرفیت</button>
{*                <button class='exclusiveRoom' type="button">ظرفیت اختصاصی</button>*}
                <button class='priceRoom' type="button">قیمت</button>
                <button class="active-btn-data allRoom" type="button">همه</button>
            </div>
        </div>
        <div class="parent-data-control">
{*            <div class="parent-mobile-filter">*}
{*                <h5>همه</h5>*}
{*                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M7.4 273.4C2.7 268.8 0 262.6 0 256s2.7-12.8 7.4-17.4l176-168c9.6-9.2 24.8-8.8 33.9 .8s8.8 24.8-.8 33.9L83.9 232 424 232c13.3 0 24 10.7 24 24s-10.7 24-24 24L83.9 280 216.6 406.6c9.6 9.2 9.9 24.3 .8 33.9s-24.3 9.9-33.9 .8l-176-168z"/></svg>*}
{*                <ul class="mobile-filter-drop">*}
{*                    <li>ظرفیت</li>*}
{*                    <li>ظرفیت اختصاصی</li>*}
{*                    <li>قیمت</li>*}
{*                    <li>همه</li>*}
{*                </ul>*}
{*            </div>*}
            <div class="parent-input-calendar">
                <input type="text" name="startDate" id="startDate" onchange='setCalenderSelectedDate()'
                       class="{$noLimitCalendar}" value="" readonly placeholder="تاریخ">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/></svg>
            </div>
            <button type="button" onclick="getWeekData('today')">امروز</button>
            <div class="arrow-calendar-data">
                <button class="btn-arrow-calendar-data go_previous" type="button" onclick="getWeekData('previous')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M297 239c9.4 9.4 9.4 24.6 0 33.9L105 465c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l175-175L71 81c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0L297 239z"/></svg>
                </button>
                <button class="btn-arrow-calendar-data" type="button" onclick="getWeekData('next')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M7 239c-9.4 9.4-9.4 24.6 0 33.9L199 465c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L57.9 256 233 81c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z"/></svg>
                </button>
            </div>
        </div>
    </div>
    <div class="">
        <input type='hidden' id='next_start_date' name='next_start_date' value=''>
        <input type='hidden' id='previous_start_date' name='previous_start_date'>

        <div class="calendar-container">
            <div class="room-table room-table-container">
                <div class="head-calendar">

                </div>
                <div class="multi-room-selection">
                    <div class="parent-check-all-rooms">
                        <label for="checkAllRooms" class="checkbox-btn checkAllRooms">
                            <input id="checkAllRooms" type="checkbox">
                            <span></span>
                            انتخاب همه اتاق ها
                        </label>
                    </div>
                    <div class="w-25 parent-request-type">
                        <div class="actions-select">
                            <h5>نوع درخواست</h5>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M182.6 470.6c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128z"/></svg>
                        </div>
                        <div class="dropdown-items">
                            <ul>
                                <li data-value='available' class='available'>ظرفیت</li>
                                <li data-value='child_price' class='child_price'>قیمت کودک</li>
                                <li data-value='extra_bed_price' class='extra_bed_price'>قیمت تخت اضافه</li>
                                <li data-value='discount' class='discount'>تخفیف</li>
{*                                <li data-value='half_price' class='half_price'>هزینه نیم شارژ</li>*}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="room_list">

                </div>
            </div>
        </div>
    </div>

</section>


<div class="parent-request-type-popup hidden">
    <form id="changeRoomCalender"  method="post">
        <input type='hidden' id='change_type_room' >
        <div class="popup-content">
            <div class="parent-request-type-popup-title">
                <h3 class='selected_type'>ویرایش قیمت کودک</h3>
                <span class="close-btn">&times;</span>
            </div>
            <div class="parent-request-type-popup-body">
                <h3 class="title-registration"> </h3>
                <div class="parent-radio-btn">
                    <h3>انتخاب نوع نمایش</h3>
                    <div>
                        <input type="radio" id="time" name="monthly-time" checked value='time' onchange='openBox(this)'>
                        <label for="time">بازه زمانی</label>
                    </div>
                    <div>
                        <input type="radio" id="monthly" name="monthly-time" value='monthly' onchange='openBox(this)'>
                        <label for="monthly">ماهانه</label>
                    </div>
                </div>
                <div class='parent-data-check-box time_box'>
                    <div class="parent-input-data">
                        <div class="">
                            <label for="az">از تاریخ</label>
                            <input onchange='checkDateSelect()' placeholder="تاریخ"  id="from_date" class="{$noLimitCalendar}">
                        </div>
                        <div class="">
                            <label for="ta">تا تاریخ</label>
                            <input onchange='checkDateSelect()' placeholder="تاریخ"  id="end_date" class="{$noLimitCalendar}">
                        </div>
                    </div>
                    <div class="parent-request-type-popup-title">
                        <h3>انتخاب روزهای هفته</h3>
                    </div>
                    <div class="parent-request-type-popup-check-box">
                        <h6>برای استفاده از این بخش باید حداقل بازه زمانی انتخاب شده ۷ روز باشد.</h6>
                        <div class="weekday_check">
                            <div class="form-check-parent">
                                <label class="" for="Saturday">
                                    <input class="" type="checkbox" id="Saturday" value="Saturday" disabled>
                                    <span></span>
                                    شنبه
                                </label>
                            </div>
                            <div class="form-check-parent">
                                <label class="" for="Sunday">
                                    <input class="" type="checkbox" id="Sunday" value="Sunday" disabled>
                                    <span></span>
                                    یکشنبه
                                </label>
                            </div>
                            <div class="form-check-parent">
                                <label class="" for="Monday">
                                    <input class="" type="checkbox" id="Monday" value="Monday" disabled>
                                    <span></span>
                                    دوشنبه
                                </label>
                            </div>
                            <div class="form-check-parent">
                                <label class="" for="Tuesday">
                                    <input class="" type="checkbox" id="Tuesday" value="Tuesday" disabled>
                                    <span></span>
                                    سه شنبه
                                </label>
                            </div>
                            <div class="form-check-parent">
                                <label class="" for="Wednesday">
                                    <input class="" type="checkbox" id="Wednesday" value="Wednesday" disabled>
                                    <span></span>
                                    چهارشنبه
                                </label>
                            </div>
                            <div class="form-check-parent">
                                <label class="" for="Thursday">
                                    <input class="" type="checkbox" id="Thursday" value="Thursday" disabled>
                                    <span></span>
                                    پنجشنبه
                                </label>
                            </div>
                            <div class="form-check-parent">
                                <label class="" for="Friday">
                                    <input class="" type="checkbox" id="Friday" value="Friday" disabled>
                                    <span></span>
                                    جمعه
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='monthly_box d-none'>
                    <div class='d-flex'>
                        <div id="datepicker"></div>
                        <div class="selected-date-card-wrapper d-flex justify-content-start align-content-start align-items-start flex-wrap">

                        </div>

                    </div>

                </div>

                <div class="parent-request-type-popup-input-room-plus">
                    <label for="roomPlus" class='selected_type_label'>قیمت تخت اضافه(ریال)</label>
                    <input type="text" id="roomPlus">
                </div>
                <div class="parent-request-type-popup-btn-last">
                    <!--                <button class="btn-cancel">انصراف</button>-->
                    <button  type='submit' class="btn-registration position-relative">
                        <span>ثبت</span>
                        <div id="loading" style="display:none;">در حال بارگذاری...</div>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
{literal}
    <script>
      $(document).ready(function () {
        setTimeout(function () {
          getFirstWeekData();
        }, 100);
      });
      function getFirstWeekData() {
        getWeekData();
      }
    </script>
{/literal}