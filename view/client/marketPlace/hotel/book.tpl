{load_presentation_object filename="user" assign="objUser"}

{assign var="check_is_counter" value=$objUser->checkIsCounter() }
{if $objSession->IsLogin()}

    {if $smarty.const.SOFTWARE_LANG eq 'fa'}
        {assign var='noLimitCalendar' value="shamsiNoLimitCalendar"}
        {assign var="sDate" value=$objFunctions->DatePrev($objDate->jdate("Y-m-d", '', '', '', 'en'), '100')}
        {assign var="eDate" value=$objDate->jdate("Y-m-d", '', '', '', 'en')}

    {else}
        {assign var='noLimitCalendar' value="gregorianNoLimitCalendar"}
        {assign var="sDate" value=$objFunctions->DatePrev(date("Y-m-d"), '7')}
        {assign var="eDate" value=date("Y-m-d")}
    {/if}

    <div class="box-style">
        <div class="box-style-padding">
            <h2 class="title">##SearchOrder##</h2>
            <input type="hidden" name="hotel_id" id="hotel_id" value='{$smarty.const.MARKET_HOTEL_ID}'>
            <form id="FormUserDataSearchFilter" name="FormUserDataSearchFilter" method='post'
                  enctype='multipart/form-data'>
                <div class="form-profile">
                    <div class="label_style">
                        <span>##dateType##</span>
                        <div class="calender_profile calender_profile_grid_1">
                            <div>
                                <select name="date_type" id="date_type" class="list_calender_profile select2" >
                                    <option value="start" selected>##Enterdate##</option>
                                    <option value="end"> ##Exitdate##</option>
                                    <option value="reserve">##Reservationdate##</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <label class="label_style">
                        <span>##DateOf##</span>
                        <input type="text" name="startDate" id="startDate"
                               class="{$noLimitCalendar}" value="" readonly placeholder="##DateOf##">
                    </label>
                    <label class="label_style">
                        <span>##ToDate##</span>
                        <input type="text"  name="endDate" id="endDate"
                               class="{$noLimitCalendar}"
                               value=""  readonly placeholder="##ToDate##">
                    </label>
                    <label class="label_style">
                        <span>##OrderNumber##</span>
                        <input type="text" name="factorNumber" id="factorNumber"  placeholder="##OrderNumber##">
                    </label>
                    <label class="label_style">
                        <span>##Namepassenger##</span>
                        <input type="text" name="passengerName" id="passengerName"  placeholder="##Namepassenger##">
                    </label>
                    <div class="label_style">
                        <span>##Statusreservation##</span>
                        <div class="calender_profile calender_profile_grid_1">
                            <div>
                                <select name="statusGroup" id="statusGroup" class="list_calender_profile select2" >
                                    <option value="">##All##</option>
                                    <option value="BookedSuccessfully"> ##Definitivereservation##</option>
                                    <option value="bank">##NotPaid##</option>
{*                                    <option value="PreReserve">##Prereservation##</option>*}
                                    <option value="NoReserve">##BookingFailed##</option>
                                    <option value="Cancelled">##Refunded##</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box_btn mt-4">
                    <button id="Search_getUserBuy" type="button" onclick="getUserBookList()">##Search##</button>
                </div>

            </form>
        </div>
    </div>
    <div id="memberResultSearch" class="memberResultSearch">
        <div class='loading'>
            <div class=""><div class="box-style-padding"><div class="loading_css"></div></div></div>
        </div>
        <div class="table-responsive d-none" style="width: 100%;">
            <table id="booking" class="table table-striped text-center">
                <thead>
                <tr>
                    <th>شناسه رزرو</th>
                    <th>نام مسافر / اتاق</th>
                    <th>تاریخ ورود</th>
                    <th>تاریخ خروج</th>
                    <th>تاریخ ثبت / بروزرسانی</th>
                    <th>آخرین وضعیت</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <div id="customPopup" class="custom-popup">

    </div>
{literal}
    <script>
      $(document).ready(function () {
        setTimeout(function () {
          getUserBookList();
        }, 100);
      });
      function getUserBookList() {
        getUserHotelBoolList();
      }
    </script>
{/literal}
{else}
    {$objUser->redirectOut()}
{/if}
