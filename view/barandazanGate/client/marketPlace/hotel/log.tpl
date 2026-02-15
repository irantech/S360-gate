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
                        <span>شناسه گزارش</span>
                        <input type="text" name="log_id" id="log_id"  placeholder="شناسه گزارش">
                    </label>
{*                    <div class="label_style">*}
{*                        <span>نمایش بر اساس</span>*}
{*                        <div class="calender_profile calender_profile_grid_1">*}
{*                            <div>*}
{*                                <select name="statusGroup" id="statusGroup" class="list_calender_profile select2" >*}
{*                                    <option value="">##All##</option>*}
{*                                    <option value="available"> ظرفیت</option>*}
{*                                    <option value="price">قیمت</option>*}
{*                                    <option value="prereserve">ورود/ خروج</option>*}
{*                                    <option value="nothing">پروموشن</option>*}
{*                                </select>*}
{*                            </div>*}
{*                        </div>*}
{*                    </div>*}
                </div>

                <div class="box_btn mt-4">
                    <button id="Search_getUserBuy" type="button" onclick="getLogList()">##Search##</button>
                </div>

            </form>
        </div>
    </div>
    <div id="memberResultSearch" class="memberResultSearch">
    </div>
{literal}
    <script>
      $(document).ready(function () {
        setTimeout(function () {
          getLogList();
        }, 100);
      });
      function getLogList() {
        getHotelLogList();
      }
    </script>
{/literal}
{else}
    {$objUser->redirectOut()}
{/if}
