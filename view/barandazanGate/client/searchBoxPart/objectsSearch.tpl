{load_presentation_object filename="searchService" assign="objSearch"}
{assign var='departures' value=$objSearch->getDepartures()}
{assign var='hotelCities' value=$objSearch->getAllHotelCities()}
{assign var='trainRoutes' value=$objSearch->getTrainRoutes()}

{if $smarty.const.SOFTWARE_LANG eq 'fa'}
    {assign var="DeptDatePickerClass" value='deptCalendar'}
    {assign var="ReturnDatePickerClass" value='returnCalendar'}
{else}
    {assign var="DeptDatePickerClass" value='gregorianDeptCalendar'}
    {assign var="ReturnDatePickerClass" value='gregorianReturnCalendar'}
{/if}


{assign var="classNameStartDate" value="hotelStartDateShamsi"}
{*{assign var="classNameStartDate" value="shamsiDeptCalendarWithMinDateTomorrow"}*}
{assign var="classNameEndDate" value="hotelEndDateShamsi"}
{*{assign var="classNameEndDate" value="shamsiReturnCalendarWithMinDateTomorrow"}*}
{if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || $paramSearch.startDate|substr:0:4 gt 2000}
    {$classNameStartDate="deptCalendarToCalculateNights"}
{/if}

{if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || $paramSearch.endDate|substr:0:4 gt 2000}
    {$classNameEndDate="returnCalendarToCalculateNights"}
{/if}

{assign var="classNameStartDateForiegn" value="shamsiDeptCalendarToCalculateNights"}
{assign var="classNameEndDateForiegn" value="shamsiReturnCalendarToCalculateNights"}
{if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || $startDate|substr:0:4 gt 2000}
    {$classNameStartDateForiegn="deptCalendarToCalculateNights"}
{/if}
{if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || $endDate|substr:0:4 gt 2000}
    {$classNameEndDateForiegn="returnCalendarToCalculateNights"}
{/if}