{load_presentation_object filename="resultLocal" assign="objResult"}
{load_presentation_object filename="insurance" assign="objInsurance"}
{load_presentation_object filename="members" assign="objMembers"}
{$objResult->getAirportDeparture()}
{assign var="allCountry" value=$objInsurance->getAllCountry()}
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
<div class="client-head-content client-head-content1">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <div class="filterBox">
                <div class="filtertip_hotel site-bg-main-color site-bg-color-border-bottom padt10 padb10">
                    <p class="txt14">
                        <span class="txt15 iranM ">##Service##</span>
                    </p>
                </div>

                <div class="filtertip-searchbox site-main-text-color-drck">
                    <div class="filter-content padb10 padt10">

                        <div class="UserBuy-tab-link current" data-tab="tab-internalFlight">
                            <input id="radio-internalFlight" class="radio-custom" name="radio-group" type="radio"
                                   checked>
                            <label for="radio-internalFlight" class="radio-custom-label">پرواز داخلی</label>
                        </div>
                        <div class="UserBuy-tab-link current" data-tab="tab-flightExternal">
                            <input id="radio-flightExternal" class="radio-custom" name="radio-group" type="radio">
                            <label for="radio-flightExternal" class="radio-custom-label">پرواز خارجی</label>
                        </div>
                        <div class="UserBuy-tab-link current" data-tab="tab-hotelinternal">
                            <input id="radio-hotelinternal" class="radio-custom" name="radio-group" type="radio">
                            <label for="radio-hotelinternal" class="radio-custom-label">هتل داخلی</label>
                        </div>
                        <div class="UserBuy-tab-link current" data-tab="tab-bime">
                            <input id="radio-bime" class="radio-custom" name="radio-group" type="radio">
                            <label for="radio-bime" class="radio-custom-label"> بیمه</label>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12" id="result">

            <div class="main-Content-bottom-table Dash-ContentL-B-Table">
                <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title site-bg-main-color">
                    <i class="icon-table"></i>
                    <h3>جستجوی شما :</h3>
                </div>

                <div id="tab-user-buy" class="UserBuy-tab-content current"></div>

                <div id="tab-internalFlight" class="UserBuy-tab-content current">
                    <div class=" s-u-update-popup-change">
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
                                        <span>بزرگسال</span>
                                        <i class="plus zmdi zmdi-plus-box site-main-text-color-h" id="add1"></i>
                                        <input id="qty1" type="number" value="0" name="adult" min="0"
                                               max="9">
                                        <i class="minus zmdi zmdi-minus-square site-main-text-color-h" id="minus1"></i>
                                    </p>
                                </div>
                            </div>

                            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change s-u-num-inp-width">
                                <div class="s-u-form-input-wrapper">
                                    <p class="s-u-number-input  s-u-number-input-change  inp-child inp-child-change">
                                        <span>کودک</span>
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
                                        <span>نوزاد</span>
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
                    </div>
                </div>

                <div id="tab-flightExternal" class="UserBuy-tab-content ">
                    <div class=" s-u-update-popup-change">
                        <form class="search-wrapper search-wrapper_n" action="" method="post">

                            <div class="raft_bar">
                                <span class="fltr iranM lh35 txt666">##Oneway##</span>
                                <span class="tzCBPart site-bg-filter-color multiWays marl20 marr20"
                                      onclick="changeWaysForeignSearchFake(this)"></span>
                                <span class="fltr iranM lh35 txt666">##Twoway##</span>
                            </div>
                            <div class="search_fli">
                                <div class="inputSearchForeign-box inputSearchForeign-pad inputSearchForeign-box1 ">
                                    <div class="s-u-in-out-wrapper raft raft-change change-bor">
                                        <input id="OriginPortal" class="inputSearchForeign" type="text" value=""
                                               placeholder="مبدا پرواز"
                                               name="origin">
                                        <img src="assets/images/load.gif" id="LoaderForeignDep" name="LoaderForeignDep"
                                             class="loaderSearch">
                                        <input id="origin_external" class="" type="hidden"
                                               value="{$Departure['DepartureCode']}"
                                               placeholder="مقصد پرواز"
                                               name="origin_external">
                                        <ul id="ListAirPort" class="resultUlInputSearch" style="display: none">
                                        </ul>
                                    </div>
                                </div>

                                <div class="swap-flight-box foreignSwapBtn " onclick="reversOriginDestinationForeign()">

                                    <span class="swap-flight"><i class="zmdi zmdi-swap site-main-text-color"></i></span>
                                </div>

                                <div class="inputSearchForeign-box bargasht inputSearchForeign-box1 bargasht-change change-bor">
                                    <div class="s-u-in-out-wrapper ">

                                        <input id="DestinationPortal" class="inputSearchForeign" type="text"
                                               value=""
                                               name="DestinationPortal">
                                        <img src="assets/images/load.gif" id="LoaderForeignReturn"
                                             name="LoaderForeignReturn"
                                             class="loaderSearch">
                                        <input id="destination_external" class="" type="hidden"
                                               value="{$Arrival['DepartureCode']}"
                                               name="destination_external">
                                        <ul id="ListAirPortRetrun" class="resultUlInputSearch" style="display: none">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change  ">
                                <div class="s-u-form-date-wrapper">
                                    <div class="s-u-date-pick">
                                        <div class="s-u-jalali s-u-jalali-change">
                                            <i class="zmdi zmdi-calendar-note site-main-text-color"></i>
                                            <input class="{$DeptDatePickerClass}" type="text" name="dept_date_external"
                                                   id="dept_date_external"
                                                   placeholder=" ##Wentdate##" readonly="readonly"
                                                   value="{$objResult->DateJalaliRequest}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change  {if $smarty.const.SEARCH_MULTI_WAY eq 'TwoWay'} showHidden {else} hidden {/if}">
                                <div class="s-u-form-date-wrapper">
                                    <div class="s-u-date-pick">
                                        <div class="s-u-jalali s-u-jalali-change">
                                            <i class="zmdi zmdi-calendar-note site-main-text-color"></i>
                                            <input class="{$ReturnDatePickerClass}" type="text"
                                                   name="date_external_return"
                                                   id="date_external_return" placeholder="##Returndate##"
                                                   readonly="readonly"
                                                   value="{$objResult->DateJalaliRequestReturn}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change s-u-num-inp-width">
                                <div class="s-u-form-input-wrapper">
                                    <p class="s-u-number-input  s-u-number-input-change  inp-adt inp-adt-change">
                                        <span>بزرگسال</span>
                                        <i class="plus zmdi zmdi-plus-box site-main-text-color-h" id="addExternal1"></i>
                                        <input id="qtyExternal1" type="number" value="0" name="adult" min="0"
                                               max="9">
                                        <i class="minus zmdi zmdi-minus-square site-main-text-color-h"
                                           id="minusExternal1"></i>
                                    </p>
                                </div>
                            </div>

                            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change s-u-num-inp-width">
                                <div class="s-u-form-input-wrapper">
                                    <p class="s-u-number-input  s-u-number-input-change  inp-child inp-child-change">
                                        <span>کودک</span>
                                        <i class="plus zmdi zmdi-plus-box site-main-text-color-h" id="addExternal2"></i>
                                        <input id="qtyExternal2" type="number" value="0" name="child" min="0"
                                               max="9">
                                        <i class="minus zmdi zmdi-minus-square site-main-text-color-h"
                                           id="minusExternal2"></i>
                                    </p>
                                </div>
                            </div>

                            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change s-u-num-inp-width">
                                <div class="s-u-form-input-wrapper">
                                    <p class="s-u-number-input  s-u-number-input-change  inp-baby inp-baby-change">
                                        <span>نوزاد</span>
                                        <i class="plus zmdi zmdi-plus-box site-main-text-color-h" id="addExternal3"></i>
                                        <input id="qtyExternal3" type="number" value="0" name="infant" min="0"
                                               max="9">
                                        <i class="minus zmdi zmdi-minus-square site-main-text-color-h"
                                           id="minusExternal3"></i>
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

                                <button type="button" onclick="submitLocalSideExternalFake()" id="sendFlight"
                                        class="site-main-button-color s-u-jalali-color site-secondary-text-color">
                                    ##Search##
                                </button>
                            </div>
                        </form>

                        <div class="message_error_portal"></div>
                    </div>
                </div>



                <div id="tab-hotelinternal" class="UserBuy-tab-content ">
                    <div class=" s-u-update-popup-change">
                        <form class="search-wrapper search-wrapper_n" action="" method="post">


                            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change">
                                <div class="s-u-in-out-wrapper raft raft-change change-bor">
                                    <select  class="select2 option1" name="CityHotelLocalSelect" id="CityHotelLocalSelect" style="width:100%;"
                                            tabindex="2">
                                        <option value="">##Destination##</option>
                                        {foreach $objFunctions->getListCityLocal() as $City}
                                            <option value="{$City.city_code}">{$City.city_name}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>



                            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change ">
                                <div class="s-u-form-date-wrapper">
                                    <div class="s-u-date-pick">
                                        <div class="s-u-jalali s-u-jalali-change">
                                            <i class="zmdi zmdi-calendar-note site-main-text-color"></i>
                                            <input class="{$DeptDatePickerHotelLocal}" type="text" name="SDateHotelLocalSelect"
                                                   id="SDateHotelLocalSelect"
                                                   placeholder="##Arrivaldatehotel##" readonly="readonly" value=""/>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change ">
                                <div class="s-u-form-date-wrapper">
                                    <div class="s-u-date-pick">
                                        <div class="s-u-jalali s-u-jalali-change">
                                            <i class="zmdi zmdi-calendar-note site-main-text-color"></i>
                                            <input class="{$ReturnDatePickerHotelLocal}" type="text" name="EDateHotelLocalSelect"
                                                   id="EDateHotelLocalSelect"
                                                   placeholder="##Exitdatehotel##" readonly="readonly" value=""/>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change s-u-num-inp-width">
                                <div class="s-u-form-date-wrapper">
                                    <div class="site-bg-main-color days-in-hotel">
                                        <input type="hidden" id="nights" class="nights" name="NightsForHotelLocal" value="">
                                        <i class="mdi mdi-hotel"></i> ##Stayigtime##
                                        <span id="stayingTimeForSearch">##Night## </span>
                                        <div class="result-st"><em class="days deptCalendarToCalculateNights" id="stayingTimeForHotelLocal"></em>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="s-u-search-wrapper s-u-num-inp s-u-num-inp-search-change">
                                <a href="" onclick="return false" class="f-loader-check f-loader-check-bar"
                                   id="loader_check_submit"
                                   style="display:none"></a>

                                <button type="button" onclick="submitLocalSideLocalHotel()" id="sendLocalHotel"
                                        class="site-main-button-color s-u-jalali-color site-secondary-text-color">
                                    ##Search##
                                </button>
                            </div>
                        </form>

                        <div class="message_error_portal"></div>
                    </div>
                </div>



                <div id="tab-bime" class="UserBuy-tab-content ">
                    <div class=" s-u-update-popup-change">
                        <form class="search-wrapper search-wrapper_n" action="" method="post">


                            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change">
                                <div class="s-u-in-out-wrapper raft raft-change change-bor">
                                    <select  data-placeholder ="##Traveldestination##" class="select2 option1" name="origin" id="InsuranceCountrySelect" style="width:100%;"
                                             tabindex="2">
                                        {*<option value="">##Traveldestination## ...</option>*}
                                        <option value="">##Destination##</option>
                                        {foreach $allCountry as $country}
                                            <option value="{$country.abbr}" {if $country.abbr == $smarty.const.INSURANCE_DESTINATION}selected="selected"{/if}>{$country.persian_name}</option>
                                        {/foreach}

                                    </select>
                                </div>
                            </div>

                            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change">
                                <div class="s-u-in-out-wrapper raft raft-change change-bor">
                                    <select class="select2 option1" name="origin" id="InsuranceTravelTimeSelect" style="width:100%;"
                                             tabindex="2">
                                        <option value="">انتخاب مدت سفر</option>
                                        <option value="5">تا پنج روز</option>
                                        <option value="7">تا هفت روز</option>
                                        <option value="8">تا 8 روز</option>
                                        <option value="15">تا 15 روز</option>
                                        <option value="32">تا 32 روز</option>
                                        <option value="31">تا 31 روز</option>
                                        <option value="45">تا 45 روز</option>
                                        <option value="62">تا 62 روز</option>
                                        <option value="92">تا 92 روز</option>
                                        <option value="182">تا 182 روز</option>
                                        <option value="186">تا 186 روز</option>
                                        <option value="365">تا 365 روز</option>


                                    </select>
                                </div>
                            </div>

                            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change">
                                <div class="s-u-in-out-wrapper raft raft-change change-bor">
                                    <select  data-placeholder=" انتخاب  تعداد مسافر  "
                                             class="select2 option1"
                                             name="number_of_passengers"
                                             id="InsurancePassengersSelect" style="width:100%;"
                                            tabindex="2">
                                        <option value="1">انتخاب  تعداد مسافر</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="3">4</option>
                                        <option value="4">5</option>
                                        <option value="5">6</option>
                                        <option value="6">7</option>
                                        <option value="7">8</option>
                                        <option value="8">9</option>



                                    </select>
                                </div>
                            </div>





                            <div  style="display: contents" class="nafaratbime">
                            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change  ">
                                <div class="s-u-form-date-wrapper">

                                        <div class="s-u-jalali s-u-jalali-change">
                                            <i class="zmdi zmdi-calendar-note site-main-text-color"></i>
                                            <input class="shamsiBirthdayCalendar" type="text" name="txt_birth_insurance1"
                                                   id="txt_birth_insurance1"
                                                   placeholder="##Happybirthday##" readonly="readonly" value=""/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="s-u-search-wrapper s-u-num-inp s-u-num-inp-search-change">
                                <a href="" onclick="return false" class="f-loader-check f-loader-check-bar"
                                   id="loader_check_submit"
                                   style="display:none"></a>

                                <button type="button" onclick="submitLocalSideInsurance()" id="sendInsurance"
                                        class="site-main-button-color s-u-jalali-color site-secondary-text-color">
                                    ##Search##
                                </button>
                            </div>
                            </div>








                        </form>

                        <div class="message_error_portal"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{literal}
    <script src="assets/js/script.js"></script>
    <script>
       document.body.innerHTML = document.body.innerHTML.replace(/\d/g, d => '۰۱۲۳۴۵۶۷۸۹'[d]);
        $(document).ready(function () {


            $('#InsurancePassengersSelect').on('change', function (e) {


                var itemInsu = $(this).val();


                itemInsu++;
                var HtmlCode = "";
                $(".nafaratbime").html('');

                var i = 1;
                while (i < itemInsu) {

                    HtmlCode += "<div class='s-u-form-block s-u-num-inp s-u-num-inp-change'>" +
                       " <div class='s-u-form-date-wrapper'> "+
                       " <div class='s-u-jalali s-u-jalali-change'>"+
                            " <i class='zmdi zmdi-calendar-note site-main-text-color'></i>"+

                        "<input class='shamsiBirthdayCalendar' type='text' placeholder='##Happybirthday## " + i + "'  name='txt_birth_insurance" + i + "' id='txt_birth_insurance" + i + "'  />" +

                        "</div>"+
                        "</div>"+
                        "</div>";
                    i++;

                }


                $(".nafaratbime ").append(HtmlCode);
            });

        });
        $(document).click(function (event) {
            if (!$(event.target).closest("#ModalPublicContent").length) {
                $("body").find("#ModalPublic").fadeOut(300);
            }
            $("body").find("#ModalZomorod").fadeOut(300);

        });

        $(document).ready(function () {
            $("#ModalZomorod").fadeIn(500);

            $('.UserBuy-tab-link').click(function () {
                var tab_id = $(this).attr('data-tab');
                $('.UserBuy-tab-link').removeClass('current');
                $('.UserBuy-tab-content').removeClass('current');
                $(this).addClass('current');
                $("#" + tab_id).addClass('current');
            });
        });

        $(".dropdownUserBuy").on("click", function () {

            $(this).find(".dropdown-content-UserBuy").slideToggle("displayb");

        });
    </script>
    <script type="text/javascript">

        var table = $('#userProfile, #userHotel, #userInsurance, #userTour, #userVisa, #userEuropcar,#userGasht,#userBus').DataTable();

        $('.Status-tab-link').on('click', function () {
            var tab_status = $(this).attr('data-tab');
            table.search(tab_status).draw();
        });

        $(function () {
            $(document).tooltip();
        });
    </script>
    <script>
        const modal = document.querySelector("#popup-upload-file .modal");
        const close = document.querySelector("#popup-upload-file .close");

        function isOpenModalVisa(factorNumber, documents) {
            $('#factorNumber').val(factorNumber);
            $('#documents-visa').html('مدارک مورد نیاز: ' + documents);
            modal.classList.add("is_open");
        }

        close.addEventListener("click", function () {
            modal.classList.remove("is_open");
        });
    </script>
    <script>

        $(function () {
            $('.file_input_replacement').click(function () {
                //This will make the element with class file_input_replacement launch the select file dialog.
                var assocInput = $(this).siblings("input[type=file]");
                console.log(assocInput);
                assocInput.click();
            });
            $('.file_input_with_replacement').change(function () {
                //This portion can be used to trigger actions once the file was selected or changed. In this case, if the element triggering the select file dialog is an input, it fills it with the filename
                var thisInput = $(this);
                var assocInput = thisInput.siblings("input.file_input_replacement");
                if (assocInput.length > 0) {
                    var filename = (thisInput.val()).replace(/^.*[\\\/]/, '');
                    assocInput.val(filename);
                }
            });
        });

    </script>
{/literal}