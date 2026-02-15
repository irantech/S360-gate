{load_presentation_object filename="clientAuth" assign="objCAuth"}
{assign var="TypeUser" value=$objFunctions->TypeUser($objSession->getUserId())}

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
   {* <div class=" s-u-update-popup-change searchbox_userprofile">
        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
            <i class="zmdi zmdi-flight-takeoff zmdi-hc-fw mart10"></i>##DomesticFlight##
        </span>
        <form class="search-wrapper search-wrapper_n" action="" method="post">
            <div class="raft_bar">
                <span class="fltr iranM lh35 txt666">##Oneway##</span>
                <span class="tzCBPart site-bg-filter-color multiWays marl20 marr20"
                      onclick="changeWays(this)"></span>
                <span class="fltr iranM lh35 txt666">##Twoway##</span>
            </div>

            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change">
                <div class="s-u-in-out-wrapper raft raft-change change-bor">
                    <select class="select2 option1" name="origin" id="origin_local" style="width:100%;"
                            tabindex="2" onchange="select_Airport()">
                        <option value="">##Selection## ...</option>
                        {foreach $objResult->dep_airport as $Dep}
                            <option value="{$Dep.Departure_Code}"
                                    {if $Dep.Departure_Code==$smarty.const.SEARCH_ORIGIN}selected="selected" {/if}>{$Dep.Departure_City}
                                ({$Dep.Departure_Code})
                            </option>
                        {/foreach}
                    </select>
                </div>
            </div>

            <div style="opacity: 0" class="swap-flight-box" onclick="reversOriginDestination()">
                <span class="swap-flight"><i class="zmdi zmdi-swap site-main-text-color"></i></span>
            </div>

            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change bargasht bargasht-change change-bor">
                <div class="s-u-in-out-wrapper ">
                    <select class="select2 option1 " name="destination" id="destination_local"
                            style="width:100%;"
                            tabindex="2">
                        <option value="0">##Selection##</option>
                    </select>
                </div>
            </div>

            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change ">
                <div class="s-u-form-date-wrapper">
                    <div class="s-u-date-pick">
                        <div class="s-u-jalali s-u-jalali-change">
                            <i class="zmdi zmdi-calendar-note site-main-text-color"></i>
                            <input class="{$DeptDatePickerClass}" type="text" name="dept_date"
                                   id="dept_date_local"
                                   placeholder="##Wentdate##" readonly="readonly" value=""/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change  hidden">
                <div class="s-u-form-date-wrapper">
                    <div class="s-u-date-pick">
                        <div class="s-u-jalali s-u-jalali-change">
                            <i class="zmdi zmdi-calendar-note site-main-text-color"></i>
                            <input class="{$ReturnDatePickerClass}" type="text" name="dept_date_return"
                                   id="dept_date_local_return"
                                   placeholder=" ##Returndate##" readonly="readonly" value=""/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change s-u-num-inp-width">
                <div class="s-u-form-input-wrapper">
                    <p class="s-u-number-input  s-u-number-input-change  inp-adt inp-adt-change">
                        <span>##Adult##</span>
                        <i class="plus zmdi zmdi-plus-box site-main-text-color-h" id="add1"></i>
                        <input id="qty1" type="number" value="1" name="adult" min="0"
                               max="9">
                        <i class="minus zmdi zmdi-minus-square site-main-text-color-h" id="minus1"></i>
                    </p>
                </div>
            </div>

            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change s-u-num-inp-width">
                <div class="s-u-form-input-wrapper">
                    <p class="s-u-number-input  s-u-number-input-change  inp-child inp-child-change">
                        <span>##Child##</span>
                        <i class="plus zmdi zmdi-plus-box site-main-text-color-h" id="add2"></i>
                        <input id="qty2" type="number" value="0" name="child" min="0"
                               max="9">
                        <i class="minus zmdi zmdi-minus-square site-main-text-color-h" id="minus2"></i>
                    </p>
                </div>
            </div>

            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change s-u-num-inp-width">
                <div class="s-u-form-input-wrapper">
                    <p class="s-u-number-input  s-u-number-input-change  inp-baby inp-baby-change">
                        <span>##Baby##</span>
                        <i class="plus zmdi zmdi-plus-box site-main-text-color-h" id="add3"></i>
                        <input id="qty3" type="number" value="0" name="infant" min="0"
                               max="9">
                        <i class="minus zmdi zmdi-minus-square site-main-text-color-h" id="minus3"></i>
                    </p>
                </div>
            </div>

            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change s-u-num-inp-width">
                <div class="s-u-form-date-wrapper">
                    <div class="s-u-class-pick s-u-class-pick-change">
                        <i class="zmdi zmdi-airline-seat-recline-extra site-main-text-color"></i>
                        <select data-placeholder=" ##Classflight##" class="select2" name="classf"
                                id="classf_local"
                                style="width:100%;" tabindex="2">
                            {if {$smarty.const.SEARCH_CLASSF} eq 'Y'}
                                <option value="Y" selected>##Economics##</option>
                                <option value="C">##Business##</option>
                            {else}
                                <option value="Y" selected>##Economics##</option>
                                <option value="C">##Business##</option>
                            {/if}
                        </select>
                    </div>
                </div>
            </div>

            <div class="s-u-search-wrapper s-u-num-inp s-u-num-inp-search-change">
                <a href="" onclick="return false" class="f-loader-check f-loader-check-bar"
                   id="loader_check_submit"
                   style="display:none"></a>

                <button type="button" onclick="submitLocalSide()" id="sendFlight"
                        class="site-main-button-color s-u-jalali-color site-secondary-text-color">
                    ##Search##
                </button>
            </div>
        </form>

        <div class="message_error_portal"></div>
    </div>*}
{literal}
    <script src="assets/js/script.js"></script>
{/literal}
{/if}

<div class="client-profile {if $TypeUser eq 'Counter'}client-profile-counter{/if}">{*inja*}
    <div class="client-profile-btn"><i></i><span>##Usermenu##</span></div>
    <div class="client-profile-h">
        <div class="client-profile-heading">
            <div class="client-profile-heading-item {if $smarty.const.GDS_SWITCH eq userProfile}client-profile-heading-active site-bg-main-color{/if}">
                <a href="{if in_array($smarty.const.CLIENT_ID, $objFunctions->newLogin())}{$smarty.const.ROOT_ADDRESS}/profile{else}{$smarty.const.ROOT_ADDRESS}/userProfile{/if}">
                    <i class="fa fa-user margin-left-10 font-i"></i><span>##Profile##</span></a>
            </div>
            {if $smarty.const.DiamondAccess eq '1'}
                <div class="client-profile-heading-item {if $smarty.const.GDS_SWITCH eq UserBuy}client-profile-heading-active site-bg-main-color{/if}">
                    <a href="{$smarty.const.ROOT_ADDRESS}/UserBuy">
                        <i class="fa fa-shopping-cart font-i"></i><span>##Buyarchive##</span></a>
                </div>


            {/if}



            {assign var="CounterTypeId" value=$objFunctions->infoMember($objSession->getUserId())}
            {if $smarty.const.SOFTWARE_LANG eq 'fa'}
            {if $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter' && $CounterTypeId['fk_counter_type_id'] eq '1' && $smarty.const.DiamondAccess eq '1'}
                <div class="client-profile-heading-item {if $smarty.const.GDS_SWITCH eq TrackingCancelTicket}client-profile-heading-active site-bg-main-color{/if}">
                    <a href="{$smarty.const.ROOT_ADDRESS}/TrackingCancelTicket">
                        <i class="fa fa-ban  font-i"></i><span>##Cancelarchive##</span></a>
                </div>

{*                <div class="client-profile-heading-item {if $smarty.const.GDS_SWITCH eq Emerald}client-profile-heading-active site-bg-main-color{/if}">*}
{*                    <a href="{$smarty.const.ROOT_ADDRESS}/Emerald">*}
{*                        <i class="fa fa-diamond font-i"></i><span>##Emerald##</span></a>*}
{*                </div>*}

{*                <div class="client-profile-heading-item "><a
                            href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/Emerald/rahnamaye_zomorod_360.pdf">
                        <i class="fa fa-book font-i"></i><span>##Helpemerald##</span></a>
                </div>*}
            {/if}
            {/if}
            {if $smarty.const.IS_ENABLE_CLUB eq 1}
                <div class="client-profile-heading-item "><a
                            href="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/login.php?clubID={$hashedPass}">
                        <i class="fa fa-users  font-i"></i><span>##Passengerclub##</span></a>
                </div>
            {/if}
            {load_presentation_object filename="resultTourLocal" assign="objTour"}
            {if $objTour->accessReservationTour() eq 'True'  and $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter' and
            $objSession->getCounterTypeId() eq 1}
                <div class="client-profile-heading-item {if $smarty.const.GDS_SWITCH eq tourRegistration}client-profile-heading-active site-bg-main-color{/if}">
                    <a href="{$smarty.const.ROOT_ADDRESS}/tourRegistration">
                        <i class="fa fa-suitcase font-i"></i><span>##Newtourentry##</span></a>
                </div>
                <div class="client-profile-heading-item {if $smarty.const.GDS_SWITCH eq tourList}client-profile-heading-active site-bg-main-color{/if}">
                    <a href="{$smarty.const.ROOT_ADDRESS}/tourList">
                        <i class="fa fa-th-list font-i"></i><span>##Tourlist##</span></a>
                </div>

{*                <div class="client-profile-heading-item {if $smarty.const.GDS_SWITCH eq tourHistoryForUser}client-profile-heading-active site-bg-main-color{/if}">
                    <a href="{$smarty.const.ROOT_ADDRESS}/tourHistoryForUser">
                        <i class="fa fa-list-alt font-i"></i><span>##Reportbuytour##</span></a>
                </div>*}
            {/if}
            {load_presentation_object filename="resultReservationVisa" assign="objResultVisa"}
            {load_presentation_object filename="visa" assign="objVisa"}

            {assign var="visaOptionByKeyArray" value=['clientID'=>$smarty.const.CLIENT_ID,'key'=>'marketPlace']}
            {assign var="visaOptionByKey" value=$objVisa->visaOptionByKey($visaOptionByKeyArray)}


            {if $objResultVisa->reservationVisaAuth() eq 'True'  and $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter' and $visaOptionByKey['value'] eq 'available'}
                <div class="client-profile-heading-item {if $smarty.const.GDS_SWITCH eq visaDashboard || $smarty.const.GDS_SWITCH eq visaNew || $smarty.const.GDS_SWITCH eq visaList}client-profile-heading-active site-bg-main-color{/if}">
                    <a href="{$smarty.const.ROOT_ADDRESS}/visaList">
                        <i class="fa fa-th-list font-i"></i><span>##SaleVisa##</span></a>
                </div>
            {/if}

            {load_presentation_object filename="entertainment" assign="objEntertainment"}



            {if $objEntertainment->reservationEntertainmentAuth() and $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter'}
                <div class="client-profile-heading-item {if $smarty.const.GDS_SWITCH eq entertainmentPanel}client-profile-heading-active site-bg-main-color{/if}">
                    <a href="{$smarty.const.ROOT_ADDRESS}/entertainmentPanel">
                        <i class="fa fa-th-list font-i"></i><span>##Entertainment##</span></a>
                </div>
            {/if}


            {*<div class="client-profile-heading-item {if $smarty.const.GDS_SWITCH eq UserPass}client-profile-heading-active site-bg-main-color{/if}">
                <a href="{$smarty.const.ROOT_ADDRESS}/UserPass">
                    <i class="fa fa-key font-i"></i><span>##password##</span></a>
            </div>*}
            {if $objFunctions->TypeUser($objSession->getUserId()) eq 'Ponline'}
                <div class="client-profile-heading-item {if $smarty.const.GDS_SWITCH eq listTransactionUser}client-profile-heading-active site-bg-main-color{/if}">
                    <a href="{$smarty.const.ROOT_ADDRESS}/listTransactionUser">
                        <i class="fa fa-list font-i"></i><span>##listTransactionUser##</span></a>
                </div>
            {/if}

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
    </script>
{/literal}