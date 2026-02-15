{load_presentation_object filename="clientAuth" assign="objCAuth"}
{assign var="TypeUser" value=$objFunctions->TypeUser($objSession->getUserId())}

{load_presentation_object filename="agency" assign="objAgency"}
{assign var="hasSeatChater" value=false}

{if $objSession->IsLogin() and $objSession->getTypeUser() eq 'agency'}

{assign var="profile" value=$objAgency->getAgency($objSession->getAgencyId())} {*گرفتن اطلاعات کاربر*}
{assign var="agency_id" value=$objSession->getAgencyId()}
    {if !empty($profile['seat_charter_code'])}
        {assign var="hasSeatChater" value=true}
    {/if}
{/if}

{if $objCAuth->ticketFlightAuth() neq ''}
    {load_presentation_object filename="resultLocal" assign="objResult"}
    {$objResult->getAirportDeparture()}
    {if $smarty.const.SOFTWARE_LANG eq 'fa'}
        {assign var="DeptDatePickerClass" value='deptCalendar'}
        {assign var="ReturnDatePickerClass" value='returnCalendar'}
        {assign var="DeptDatePickerHotelLocal" value='shamsiDeptCalendarToCalculateNights'}
        {assign var="ReturnDatePickerHotelLocal" value='shamsiReturnCalendarToCalculateNights'}
    {else}
        {assign var="DeptDatePickerClass" value='gregorianDeptCalendar'}
        {assign var="ReturnDatePickerClass" value='gregorianReturnCalendar'}
        {assign var="DeptDatePickerHotelLocal" value='deptCalendarToCalculateNights'}
        {assign var="ReturnDatePickerHotelLocal" value='returnCalendarToCalculateNights'}
    {/if}
{literal}
    <script src="assets/js/script.js"></script>
{/literal}
{/if}
<link rel="stylesheet" href="assets/css/agencyMenu.css"/>
<div class="client-profile" style="padding: 0">{*inja*}
    <div class="client-profile-btn"><i></i><span>##Usermenu##</span></div>
    <div class="client-profile-h">
        <div class="client-profile-heading">
{*            <div class="client-profile-heading-item {if $smarty.const.GDS_SWITCH eq agencyProfile}client-profile-heading-active site-bg-main-color{/if}">*}
{*                <a href="{$smarty.const.ROOT_ADDRESS}/agencyProfile">*}
{*                    <i class="fa fa-user margin-left-10 font-i"></i>*}
{*                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">*}
{*                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>*}
{*                    </svg>*}
{*                    <span>##Profile##</span>*}
{*                </a>*}
{*            </div>*}
            <div class="client-profile-heading-item {if $smarty.const.GDS_SWITCH eq welcomeAgency}client-profile-heading-active site-bg-main-color{/if}">
                <a href="{$smarty.const.ROOT_ADDRESS}/welcomeAgency">
                    {*                    <i class="fa fa-user margin-left-10 font-i"></i>*}
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart-fill" viewBox="0 0 16 16">
                        <path d="M0 0h1v15h15v1H0V0zm10 10h2v5h-2v-5zm-4-4h2v9H6V6zm-4 2h2v7H2V8z"/>
                    </svg>
                    <span>##AgencyReport##</span>
                </a>
            </div>
            <div class="client-profile-heading-item {if $smarty.const.GDS_SWITCH eq agencyPassengers}client-profile-heading-active site-bg-main-color{/if}">
                <a href="{$smarty.const.ROOT_ADDRESS}/agencyPassengers">
                    {*                    <i class="fa fa-user margin-left-10 font-i"></i>*}
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                        <path d="M13 7a3 3 0 1 0-2.995-2.824A3.5 3.5 0 0 1 13 7zm-5-2a2 2 0 1 0-3.999-.001A2 2 0 0 0 8 5zm4 8c0-1-1-2-3-2s-3 1-3 2v1h6v-1zm-8 0c0-1 1-2 3-2s3 1 3 2v1H4v-1z"/>
                    </svg>
                    <span>##AgencyPassengers##</span>
                </a>
            </div>
            <div class="client-profile-heading-item {if $smarty.const.GDS_SWITCH eq membersAgency || $smarty.const.GDS_SWITCH eq counterAgencyAdd}client-profile-heading-active site-bg-main-color{/if}">
                <a href="{$smarty.const.ROOT_ADDRESS}/membersAgency">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard2-check-fill" viewBox="0 0 16 16">
                        <path d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5"/>
                        <path d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585q.084.236.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5q.001-.264.085-.5m6.769 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708"/>
                    </svg>
                    <span>##AgencyEmployee##</span>
                </a>
            </div>
            <div class="client-profile-heading-item {if $smarty.const.GDS_SWITCH eq reportAgency}client-profile-heading-active site-bg-main-color{/if}">
                <a href="{$smarty.const.ROOT_ADDRESS}/reportAgency">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-check-fill" viewBox="0 0 16 16">
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708"/>
                    </svg>
                    <span>##Buyarchive##</span>
                </a>
            </div>
            <div class="client-profile-heading-item {if $smarty.const.GDS_SWITCH eq cancelAgency}client-profile-heading-active site-bg-main-color{/if}">
                <a href="{$smarty.const.ROOT_ADDRESS}/cancelAgency">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-x-fill" viewBox="0 0 16 16">
                        <path d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5z"/>
                        <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5zm4 7.793 1.146-1.147a.5.5 0 1 1 .708.708L8.707 10l1.147 1.146a.5.5 0 0 1-.708.708L8 10.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 10 6.146 8.854a.5.5 0 1 1 .708-.708z"/>
                    </svg>
                    <span>##Cancellist##</span>
                </a>
            </div>
            <div class="client-profile-heading-item {if $smarty.const.GDS_SWITCH eq reportCreditAgency}client-profile-heading-active site-bg-main-color{/if}">
                <a href="{$smarty.const.ROOT_ADDRESS}/reportCreditAgency">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart-line-fill" viewBox="0 0 16 16">
                        <path d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1z"/>
                    </svg>
                    <span>##reportTransaction##</span>
                </a>
            </div>
            {if $hasSeatChater}
                <div class="client-profile-heading-item client-profile-has-submenu {if $smarty.const.GDS_SWITCH eq agencyManifest}client-profile-heading-active site-bg-main-color{/if}">
                    <a href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-airplane-fill" viewBox="0 0 16 16">
                            <path d="M6.428 1.151C6.708.591 7.213 0 8 0s1.292.592 1.572 1.151C9.861 1.73 10 2.431 10 3v3.691l5.17 2.585a1.5 1.5 0 0 1 .83 1.342V12a.5.5 0 0 1-.582.493l-5.507-.918-.375 2.253 1.318 1.318A.5.5 0 0 1 10.5 16h-5a.5.5 0 0 1-.354-.854l1.319-1.318-.376-2.253-5.507.918A.5.5 0 0 1 0 12v-1.382a1.5 1.5 0 0 1 .83-1.342L6 6.691V3c0-.568.14-1.271.428-1.849"/>
                        </svg>
                        <span>##AgencyManifest##</span>
                    </a>
                    <div class="client-profile-submenu">
                        <a style="color: #000000 !important;" href="{$smarty.const.ROOT_ADDRESS}/agencyManifest"> ارسال مانیفست</a>
                        <a style="color: #000000 !important;" href="{$smarty.const.ROOT_ADDRESS}/agencyListManifest">لیست مانیفست</a>
                    </div>
                </div>
            {/if}
            <div class="client-profile-heading-item  {if $smarty.const.GDS_SWITCH eq agencyListTourManifest}client-profile-heading-active site-bg-main-color{/if}">
                <a href="{$smarty.const.ROOT_ADDRESS}/agencyListTourManifest">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-airplane-fill" viewBox="0 0 16 16">
                        <path d="M6.428 1.151a.5.5 0 0 1 .707 0l7.714 7.714a.5.5 0 0 1-.353.854H9.5l-2 6-1-.5 1-5.5H3.5l-1.5 1.5H.5l1-2-1-2h1.5l1.5 1.5H7.5l-1-5.5-1-.5 2-6z"/>
                    </svg>
                    <span>##AgencyTourManifest##</span>
                </a>
            </div>
        </div>
    </div>
</div>
{literal}
    <script type="text/javascript">
        $(document).ready(function () {
            $('.client-profile-btn').click(function () {
                $(this).toggleClass('client-profile-open');
                $('.client-profile-h').toggleClass('client-profile-h-show');
            });
        });
        $('.client-profile-has-submenu > a').click(function(e){
           e.preventDefault();
           $(this).next('.client-profile-submenu').toggle();
        });
    </script>
{/literal}