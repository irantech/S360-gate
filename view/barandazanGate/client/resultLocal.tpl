{load_presentation_object filename="resultLocal" assign="objResult"}
{load_presentation_object filename="currencyEquivalent" assign="objCurrency"}
{$objResult->getAirportDeparture($smarty.const.ISFOREIGN)}
{$objResult->getAirportArrival($smarty.const.SEARCH_ORIGIN)}
{$objResult->GetNameDeparture($smarty.const.SEARCH_ORIGIN)}
{$objResult->GetNameArrival($smarty.const.SEARCH_DESTINATION)}
{$objResult->DateJalali($smarty.const.SEARCH_DEPT_DATE)}
{*$objFunctions->LogInfo()*}
{assign var="InfoMember" value=$objFunctions->infoMember($objSession->getUserId())}
{assign var="InfoCounter" value=$objFunctions->infoCounterType($InfoMember.fk_counter_type_id)}

{if $smarty.const.SOFTWARE_LANG eq 'fa'}
    {assign var="DeptDatePickerClass" value='shamsiOnlyDeptCalendar'}
    {assign var="ReturnDatePickerClass" value='shamsiOnlyReturnCalendar'}
{else}
    {assign var="DeptDatePickerClass" value='gregorianDeptCalendar'}
    {assign var="ReturnDatePickerClass" value='gregorianReturnCalendar'}
{/if}

{if $smarty.session.CurrencyUnit eq ''}
    {$objSession->setCurrency()}
{/if}
<div class="s-u-black-container"></div>
<div class="s-u-content-result-local">
    <div class="progress-container">
        <div class="progress-bar site-bg-main-color" id="myBarHead"></div>
    </div>

    <div class="row">

        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 parvaz-sidebar col-padding-5">
            <div class="parent_sidebar">
                {if $smarty.const.ISCURRENCY eq '1'}
                    <div class="currency-gds">

                        {assign var="CurrencyInfo"  value=$objCurrency->InfoCurrency($objSession->getCurrency())}

                        {if $CurrencyInfo neq null}
                            <div class="currency-inner DivDefaultCurrency">
                                <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/flagCurrency/{$CurrencyInfo['CurrencyFlag']}"
                                     alt="" id="IconDefaultCurrency">
                                <span class="TitleDefaultCurrency">{$CurrencyInfo['CurrencyTitleFa']}</span>
                                <span class="currency-arrow"></span>
                            </div>
                        {else}
                            <div class="currency-inner DivDefaultCurrency">
                                <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/flagCurrency/Iran.png" alt=""
                                     id="IconDefaultCurrency">
                                <span class="TitleDefaultCurrency">##IranianRial##</span>
                                <span class="currency-arrow"></span>
                            </div>
                        {/if}

                        <div class="change-currency">
                            <div class="change-currency-inner">
                                <div class="change-currency-item main"
                                     onclick="ConvertCurrency('0','Iran.png','ریال ایران')">
                                    <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/flagCurrency/Iran.png"
                                         alt="">
                                    <span>##Iran##</span>
                                </div>
                                {foreach $objCurrency->ListCurrencyEquivalent()  as  $Currency}
                                    <div class="change-currency-item"
                                         onclick="ConvertCurrency('{$Currency.CurrencyCode}','{$Currency.CurrencyFlag}','{$Currency.CurrencyTitle}')">
                                        <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/flagCurrency/{$Currency.CurrencyFlag}"
                                             alt="">
                                        <span>{$Currency.CurrencyTitle}</span>
                                    </div>
                                {/foreach}
                            </div>
                        </div>
                    </div>
                {/if}

                <!-- Result search -->
                <div class="filter_airline_flight">
                    <div class="filtertip parvaz-filter-change site-bg-main-color site-bg-color-border-bottom ">
                        {if $objResult->indate($smarty.const.SEARCH_DEPT_DATE) eq true && $smarty.const.SEARCH_RETURN_DATE eq ''}
                        <a href="{$smarty.const.ROOT_ADDRESS}/local/1/{$smarty.const.SEARCH_ORIGIN}-{$smarty.const.SEARCH_DESTINATION}/{$objResult->DatePrev($smarty.const.SEARCH_DEPT_DATE)}/Y/{$smarty.const.SEARCH_ADULT}-{$smarty.const.SEARCH_CHILD}-{$smarty.const.SEARCH_INFANT}">
                            {/if}
                            <span class=" chooseiconDay icons tooltipWeighDay right site-border-text-color">
                                    <span class="tooltiptextWeightDay"> ##Previousday##  </span>
                                <i class="zmdi zmdi-chevron-right iconDay site-secondary-text-color">
                                </i>
                            </span>
                            {if $objResult->indate($smarty.const.SEARCH_DEPT_DATE) eq true}
                        </a>
                        {/if}
                        <div class="tip-content">
                            <p class="">
                    <span class=" bold counthotel">
                        {if $smarty.const.SOFTWARE_LANG eq 'en'}
                            {$objResult->dep_city['Departure_CityEn']}
                        {else}
                            {$objResult->dep_city['Departure_City']}
                        {/if}

                    </span>
                                ##On##
                                <span class=" bold counthotel">
                        {if $smarty.const.SOFTWARE_LANG eq 'en'}
                            {$objResult->arival_city['Departure_CityEn']}
                        {else}
                            {$objResult->arival_city['Departure_City']}
                        {/if}
                    </span>
                            </p>
                            <p class="counthotel txt12"> {$objResult->day}، {$objResult->date_now}</p>
                            <div class="silence_span ph-item2"></div>
                        </div>
                        {if $smarty.const.SEARCH_RETURN_DATE eq ''}
                            <a href="{$smarty.const.ROOT_ADDRESS}/local/1/{$smarty.const.SEARCH_ORIGIN}-{$smarty.const.SEARCH_DESTINATION}/{$objResult->DateNext($smarty.const.SEARCH_DEPT_DATE)}/Y/{$smarty.const.SEARCH_ADULT}-{$smarty.const.SEARCH_CHILD}-{$smarty.const.SEARCH_INFANT}">
                                    <span class=" chooseiconDay icons tooltipWeighDay left site-border-text-color">
                                            <span class="tooltiptextWeightDay"> ##Nextday##  </span>
                                        <i class="zmdi zmdi-chevron-left iconDay site-secondary-text-color">
                                        </i>
                                    </span>
                            </a>
                        {/if}
                        <div class="open-sidebar-parvaz" onclick="showSearchBoxTicket()">
                            ##ChangeSearchType##
                        </div>
                    </div>
                    <!-- search box -->
                    <div class=" s-u-update-popup-change">
                        <form class="search-wrapper" action="" method="post">

                            <div class="displayib padr20 padl20">
                                {*<span class="fltr iranM lh35 txt666">##Oneway##</span>
                                <span class="tzCBPart site-bg-main-color multiWays {if $smarty.const.SEARCH_MULTI_WAY eq 'TwoWay'}checked{/if} marl20 marr20"
                                      onclick="changeWays(this)">
                                </span>
                                <span class="fltr iranM lh35 txt666">##Twoway##</span>*}

                                <div class="ways_btns">

                                    <div onclick="changeWays_('Oneway')" class="radiobtn Oneway">

                                        <input type="radio" id="huey"
                                               name="drone" value="huey" {if $smarty.const.SEARCH_MULTI_WAY eq 'OneWay'} checked="checked" {/if}/>
                                        <label class=" site-bg-main-color-before" for="huey">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  version="1.1"  x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g transform="matrix(-1,-1.2246467991473532e-16,1.2246467991473532e-16,-1,512,512)">
                                                    <g xmlns="http://www.w3.org/2000/svg">
                                                        <g>
                                                            <path d="M374.108,373.328c-7.829-7.792-20.492-7.762-28.284,0.067L276,443.557V20c0-11.046-8.954-20-20-20    c-11.046,0-20,8.954-20,20v423.558l-69.824-70.164c-7.792-7.829-20.455-7.859-28.284-0.067c-7.83,7.793-7.859,20.456-0.068,28.285    l104,104.504c0.006,0.007,0.013,0.012,0.019,0.018c7.792,7.809,20.496,7.834,28.314,0.001c0.006-0.007,0.013-0.012,0.019-0.018    l104-104.504C381.966,393.785,381.939,381.121,374.108,373.328z" style="" class=""/>
                                                        </g>
                                                    </g>
                                                </g>
                                        </svg>
                                            ##Oneway##
                                        </label>
                                    </div>
                                    <div onclick="changeWays_('Twoway')" class="radiobtn Twoway">
                                        <input type="radio" id="dewey"
                                               name="drone" value="dewey" {if $smarty.const.SEARCH_MULTI_WAY eq 'TwoWay'} checked="checked" {/if}
                                               class="multiWays {if $smarty.const.SEARCH_MULTI_WAY eq 'TwoWay'} checked {/if}"/>
                                        <label class="site-bg-main-color-before" for="dewey">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"  x="0" y="0" viewBox="0 0 907.62 907.619" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g>
                                                    <g xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M591.672,907.618c28.995,0,52.5-23.505,52.5-52.5V179.839l42.191,41.688c10.232,10.11,23.567,15.155,36.898,15.155   c13.541,0,27.078-5.207,37.347-15.601c20.379-20.625,20.18-53.865-0.445-74.244L626.892,15.155C617.062,5.442,603.803,0,589.993,0   c-0.104,0-0.211,0-0.314,0.001c-13.923,0.084-27.244,5.694-37.03,15.6l-129.913,131.48c-20.379,20.625-20.18,53.865,0.445,74.244   c20.626,20.381,53.866,20.181,74.245-0.445l41.747-42.25v676.489C539.172,884.113,562.677,907.618,591.672,907.618z" />
                                                        <path d="M315.948,0c-28.995,0-52.5,23.505-52.5,52.5v676.489l-41.747-42.25c-20.379-20.625-53.62-20.825-74.245-0.445   c-20.625,20.379-20.825,53.619-0.445,74.244l129.912,131.479c9.787,9.905,23.106,15.518,37.029,15.601   c0.105,0.001,0.21,0.001,0.315,0.001c13.81,0,27.07-5.442,36.899-15.155L484.44,760.78c20.625-20.379,20.824-53.619,0.445-74.244   c-20.379-20.626-53.62-20.825-74.245-0.445l-42.192,41.688V52.5C368.448,23.505,344.943,0,315.948,0z" style=""/>
                                                    </g>
                                                </g>
                                            </svg>
                                            ##Twoway##</label>
                                    </div>

                                </div>
                            </div>
                            <div class="d-flex flex-wrap align-items-center position-relative">

                                <div class="s-u-form-block s-u-num-inp s-u-num-inp-change">
                                    <div class="s-u-in-out-wrapper raft raft-change change-bor">
                                        <select class="select2 option1 " name="origin" id="origin_local"
                                                style="width:100%;"
                                                tabindex="2"
                                                onchange="select_Airport()"> {*onchange="select_Airport()"*}
                                            {foreach $objResult->dep_airport as $Dep}
                                                <option value="{$Dep.Departure_Code}"
                                                        {if $Dep.Departure_Code == $smarty.const.SEARCH_ORIGIN}selected="selected"{/if}>
                                                    {$Dep[$objFunctions->changeFieldNameByLanguage('Departure_City')]}
                                                    ({$Dep.Departure_Code})
                                                </option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>


                                <div class="swap-flight-box" onclick="reversOriginDestination()">
                                    <span class="swap-flight"><i class="zmdi zmdi-swap site-main-text-color"></i></span>
                                </div>


                                <div class="s-u-form-block s-u-num-inp s-u-num-inp-change bargasht bargasht-change change-bor">
                                    <div class="s-u-in-out-wrapper ">
                                        <select class="select2 option1 " name="destination" id="destination_local"
                                                style="width:100%;"
                                                tabindex="2">
                                            {foreach $objResult->dep_airport_arival as $Arr}
                                                <option value="{$Arr.Arrival_Code}"
                                                        {if $Arr.Arrival_Code == $smarty.const.SEARCH_DESTINATION}selected="selected"{/if}>
                                                    {$Arr[$objFunctions->changeFieldNameByLanguage('Arrival_City')]}
                                                    ({$Arr.Arrival_Code})
                                                </option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100">
                                <div class="s-u-form-date-wrapper">
                                    <div class="s-u-date-pick">
                                        <div class="s-u-jalali s-u-jalali-change">
                                            <i class="zmdi zmdi-calendar-note site-main-text-color"></i>
                                            <input class="{$DeptDatePickerClass}" type="text" name="dept_date"
                                                   id="dept_date_local"
                                                   placeholder=" ##Wentdate##" readonly="readonly"
                                                   value="{$objResult->DateJalaliRequest}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {if $smarty.const.SEARCH_RETURN_DATE neq ''}
                                {$objResult->DateJalali($smarty.const.SEARCH_RETURN_DATE,'TwoWay')}
                            {/if}

                            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100 {if $smarty.const.SEARCH_MULTI_WAY eq 'TwoWay'} showHidden {else} hidden {/if}">
                                <div class="s-u-form-date-wrapper">
                                    <div class="s-u-date-pick">
                                        <div class="s-u-jalali s-u-jalali-change">

                                            <i class="zmdi zmdi-calendar-note site-main-text-color"></i>
                                            <input class="{$ReturnDatePickerClass}" type="text" name="dept_date_return"
                                                   id="dept_date_local_return" placeholder=" ##Returndate##"
                                                   readonly="readonly"
                                                   value="{$objResult->DateJalaliRequestReturn}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="number_passengers">

                                <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100">
                                    <div class="s-u-form-input-wrapper">
                                        <div class="s-u-number-input  s-u-number-input-change  inp-adt inp-adt-change">
                                            <i class="plus zmdi zmdi-plus site-bg-main-color" id="add1"></i>
                                            <span>
                                                <input class="site-main-text-color-drck" id="qty1" type="text"
                                                         value="{$smarty.const.SEARCH_ADULT}" name="adult"
                                                         min="0"
                                                         max="9">##Adult##</span>

                                            <i class="minus zmdi zmdi-minus site-bg-main-color" id="minus1"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100">
                                    <div class="s-u-form-input-wrapper">
                                        <div class="s-u-number-input  s-u-number-input-change  inp-child inp-child-change">
                                            <i class="plus zmdi zmdi-plus site-bg-main-color" id="add2"></i>
                                            <span><input class="site-main-text-color-drck" id="qty2" type="text"
                                                         value="{$smarty.const.SEARCH_CHILD}"
                                                         name="child"
                                                         min="0"
                                                         max="9">##Child##</span>

                                            <i class="minus zmdi zmdi-minus site-bg-main-color" id="minus2"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100">
                                    <div class="s-u-form-input-wrapper">
                                        <div class="s-u-number-input  s-u-number-input-change  inp-baby inp-baby-change">
                                            <i class="plus zmdi zmdi-plus site-bg-main-color" id="add3"></i>
                                            <span><input class="site-main-text-color-drck" id="qty3" type="text"
                                                         value="{$smarty.const.SEARCH_INFANT}" name="infant"
                                                         min="0"
                                                         max="9"/>##Baby##</span>

                                            <i class="minus zmdi zmdi-minus site-bg-main-color" id="minus3"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="s-u-search-wrapper s-u-num-inp s-u-num-inp-search-change">
                                <a href="" onclick="return false" class="f-loader-check f-loader-check-bar"
                                   id="loader_check_submit"
                                   style="display:none"></a>

                                <button type="button" onclick="submitLocalSide('local')" id="sendFlight"
                                        class="site-bg-main-color">##Search##
                                </button>
                            </div>
                        </form>

                        <div class="message_error_portal"></div>
                    </div>
                </div>
                {if $smarty.const.SEARCH_FLIGHT_NUMBER eq ''}
                    <ul id="s-u-filter-wrapper-ul">
                        <span class="s-u-close-filter"></span>

                        <!-- pricefilter -->
                        <li class="s-u-filter-item" data-group="flight-price">
                            <input type="hidden" name="minPrice" id="minPriceRange" value="{$objResult->minPrice}">
                            <input type="hidden" name="maxPrice" id="maxPriceRange" value="{$objResult->maxPrice}">
                            <span class="s-u-filter-title">
                            <i class="zmdi zmdi-money "></i> ##Price##

                        </span>
                            <div class="s-u-filter-content slider_range_parent">
                                <span class="f-loader f-loader-check"></span>
                                <p>
                                    <input type="text" id="amount" readonly
                                           style="border:0; color:#f6931f; font-weight:bold;"
                                           onload="selectPriceRange('{$objResult->minPrice}', '{$objResult->maxPrice}');">
                                </p>
                                <div id="slider-range"></div>
                            </div>
                        </li>

                        <!-- flight type filter -->
                        <li class="s-u-filter-item" data-group="flight-type">

                        <span class="s-u-filter-title"><i
                                    class="zmdi zmdi-flight-takeoff "></i>  ##Typeflight##</span>

                            <div class="s-u-filter-content">

                                <ul class="s-u-filter-item-time filter-type-ul">

                                    <li>
                                        <label>##All##</label>
                                        <input class="check-switch" type="checkbox" id="filter-type" value="all"/>
                                        <span data-inactive="##Inactive##" data-active="##Active##" class="tzCBPart site-bg-filter-color checked filter-to-check"
                                              onclick="filterFlight(this)"></span>
                                    </li>

                                    <li>
                                        <label>##SystemType##</label>
                                        <input class="check-switch" type="checkbox" id="filter-system" value="system"/>
                                        <span data-inactive="##Inactive##" data-active="##Active##" class="tzCBPart site-bg-filter-color" onclick="filterFlight(this)"></span>
                                    </li>

                                    <li>

                                        <label>##CharterType##</label>
                                        <input class="check-switch" type="checkbox" id="filter-charter"
                                               value="charter"/>
                                        <span data-inactive="##Inactive##" data-active="##Active##" class="tzCBPart site-bg-filter-color" onclick="filterFlight(this)"></span>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- seat class filter -->
                        <li class="s-u-filter-item" data-group="flight-seat">

                        <span class="s-u-filter-title"><i
                                    class="zmdi zmdi-airline-seat-recline-extra"></i> ##Classflight##</span>

                            <div class="s-u-filter-content">

                                <ul class="s-u-filter-item-time filter-seat-ul">

                                    <li>
                                        <label>##All##</label>
                                        <input class="check-switch" type="checkbox" id="filter-seat" value="all"/>
                                        <span data-inactive="##Inactive##" data-active="##Active##" class="tzCBPart site-bg-filter-color checked filter-to-check"
                                              onclick="filterFlight(this)"></span>
                                    </li>

                                    <li>
                                        <label>##EconomicsType##</label>
                                        <input class="check-switch" type="checkbox" id="filter-economy"
                                               value="economy"/>
                                        <span data-inactive="##Inactive##" data-active="##Active##" class="tzCBPart site-bg-filter-color" onclick="filterFlight(this)"></span>
                                    </li>

                                    <li>

                                        <label>##BusinessType##</label>
                                        <input class="check-switch" type="checkbox" id="filter-business"
                                               value="business"/>
                                        <span data-inactive="##Inactive##" data-active="##Active##" class="tzCBPart site-bg-filter-color" onclick="filterFlight(this)"></span>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- airline filter -->
                        {*assign "airlines" $objGeneral->getAirlines()*}
                        {assign var="airlines" value=$objFunctions->getAirlines()}

                        <li class="s-u-filter-item" data-group="flight-airline">
                        <span class="s-u-filter-title "><i
                                    class="zmdi zmdi-local-airport"></i> ##Airline##</span>
                            <div class="s-u-filter-content">
                                <span class="f-loader f-loader-check"></span>
                                <ul class="s-u-filter-item-time filter-airline-ul">
                                    <li>
                                        <label>##All##</label>
                                        <input class="check-switch" type="checkbox" id="filter-airline" value="all"/>
                                        <span data-inactive="##Inactive##" data-active="##Active##" class="tzCBPart site-bg-filter-color checked filter-to-check"
                                              onclick="filterFlight(this)"></span>
                                    </li>

                                    {foreach key=key item=item from=$airlines}
                                        <li class="filter-row" id="{$item.abbreviation}-filter">
                                            <label><i id="{$item.abbreviation}-minPrice"></i> {$item.name_fa}</label>
                                            <input class="check-switch" type="checkbox" id="filter-{$item.abbreviation}"
                                                   value="{$item.abbreviation}"/>
                                            <span data-inactive="##Inactive##" data-active="##Active##" class="tzCBPart site-bg-filter-color"
                                                  onclick="filterFlight(this)"></span>
                                        </li>
                                    {/foreach}
                                </ul>
                            </div>
                        </li>

                        <!-- time filter -->
                        <li class="s-u-filter-item" data-group="flight-time">
                        <span class="s-u-filter-title"><i
                                    class="zmdi zmdi-time"></i> ##RunTime##</span>
                            <div class="s-u-filter-content">
                                <ul class="s-u-filter-item-time filter-time-ul">
                                    <li>
                                        <label>##All##</label>
                                        <input class="check-switch" type="checkbox" id="filter-time" value="all"/>
                                        <span data-inactive="##Inactive##" data-active="##Active##" class="tzCBPart site-bg-filter-color checked filter-to-check"
                                              onclick="filterFlight(this)"></span>
                                    </li>

                                    <li>
                                        <label><i>(0-8)</i> ##Morning## </label>
                                        <input class="check-switch" type="checkbox" id="filter-early" value="early"/>
                                        <span data-inactive="##Inactive##" data-active="##Active##" class="tzCBPart site-bg-filter-color "
                                              onclick="filterFlight(this)"></span>
                                    </li>

                                    <li>
                                        <label><i>(8-12)</i> ##Day## </label>
                                        <input class="check-switch" type="checkbox" id="filter-morning"
                                               value="morning"/>
                                        <span data-inactive="##Inactive##" data-active="##Active##" class="tzCBPart site-bg-filter-color" onclick="filterFlight(this)"></span>
                                    </li>

                                    <li>
                                        <label> <i>(12-18)</i> ##Evening##</label>
                                        <input class="check-switch" type="checkbox" id="filter-afternoon"
                                               value="afternoon"/>
                                        <span data-inactive="##Inactive##" data-active="##Active##" class="tzCBPart site-bg-filter-color" onclick="filterFlight(this)"></span>
                                    </li>

                                    <li>
                                        <label> <i>(18-24)</i> ##Night##</label>
                                        <input class="check-switch" type="checkbox" id="filter-night" value="night"/>
                                        <span data-inactive="##Inactive##" data-active="##Active##" class="tzCBPart site-bg-filter-color" onclick="filterFlight(this)"></span>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <div class="articles-list d-none">

                            <h6>##RelatedArticles##</h6>
                            <ul></ul>

                        </div>

                    </ul>
                {/if}

            </div>
        </div>


        <div id="result" class="col-lg-9 col-md-12 col-sm-12 col-xs-12 flight_body_search col-padding-5">
            <div class="loader-section">
                <div id="loader-page" class="lazy-loader-parent ">
                    <div class="loader-page container site-bg-main-color">
                        <div class="parent-in row">

                            <div class="loader-txt">
                                <div id="flight_loader">
                          <span class="loader-date">
                 {$objResult->DateJalali($smarty.const.SEARCH_DEPT_DATE,'TwoWay')}
                              {$objResult->day}، {$objResult->date_now}

                          </span>
                                    <div class="wrapper">

                                        <div class="locstart"></div>
                                        <div class="flightpath">
                                            <div class="airplane"></div>
                                        </div>
                                        <div class="locend"></div>
                                    </div>
                                </div>

                                <div class="loader-distinc">
                                   ##searching##
                                    ##Flight##
                                    ##From##
                                    <span>
                             {if $smarty.const.SOFTWARE_LANG eq 'en'}
                                 {$objResult->dep_city['Departure_CityEn']}
                             {else}
                                 {$objResult->dep_city['Departure_City']}
                             {/if}
                            </span>
                                    ##On##
                                    <span>
                             {if $smarty.const.SOFTWARE_LANG eq 'en'}
                                 {$objResult->arival_city['Departure_CityEn']}
                             {else}
                                 {$objResult->arival_city['Departure_City']}
                             {/if}
                            </span>
                                   ##ForYou##
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

            <div id="resultFake"></div>


        </div>
    </div>
</div>
<div class="lazy-loader-parent lazy_loader_flight">
    <div class="modal-content-flight">
        <div class="modal-body-flight">
            <div class="img_timeoute_svg">

                <svg id="Capa_1" enable-background="new 0 0 512 512" viewBox="0 0 512 512"
                     xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <circle cx="211.748" cy="217.219" fill="#365e7d" r="211.748"/>
                        <path d="m423.496 217.219c0-116.945-94.803-211.748-211.748-211.748-4.761 0-9.482.173-14.165.483 105.408 6.964 189.73 91.05 197.055 196.357.498 7.155-5.367 13.072-12.538 12.919-1.099-.023-2.201-.035-3.306-.035-87.332 0-158.129 70.797-158.129 158.129 0 8.201.627 16.255 1.833 24.118 2.384 15.542-8.906 29.961-24.594 31.022-.107.007-.214.014-.321.021 4.683.309 9.404.483 14.165.483 117.636-.001 211.748-95.585 211.748-211.749z"
                              fill="#2b4d66"/>
                        <circle cx="211.748" cy="217.219" fill="#f4fbff" r="162.544"/>
                        <path d="m374.292 217.219c0-89.77-72.773-162.544-162.544-162.544-4.404 0-8.765.181-13.08.525 83.965 6.687 149.953 77.174 149.461 162.972-.003.004-.006.007-.009.011-68.587 13.484-119.741 70.667-126.655 138.902-1.189 11.73-10.375 21.111-22.124 22.097-.224.019-.448.037-.673.055 94.649 7.542 175.624-67.027 175.624-162.018z"
                              fill="#daf1f4"/>
                        <g>
                            <g>
                                <path d="m211.748 104.963c-4.268 0-7.726-3.459-7.726-7.726v-10.922c0-4.268 3.459-7.726 7.726-7.726s7.726 3.459 7.726 7.726v10.922c0 4.267-3.458 7.726-7.726 7.726z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m296.588 140.105c-1.978 0-3.955-.755-5.464-2.264-3.017-3.017-3.017-7.909.001-10.927l7.723-7.722c3.017-3.017 7.909-3.016 10.927.001 3.017 3.017 3.017 7.909-.001 10.927l-7.723 7.722c-1.508 1.508-3.486 2.263-5.463 2.263z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m342.653 224.945h-10.923c-4.268 0-7.726-3.459-7.726-7.726 0-4.268 3.459-7.726 7.726-7.726h10.923c4.268 0 7.726 3.459 7.726 7.726s-3.459 7.726-7.726 7.726z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m214.925 359.027c-4.268 0-7.726-3.459-7.726-7.726v-10.923c0-4.268 3.459-7.726 7.726-7.726s7.726 3.459 7.726 7.726v10.923c.001 4.268-3.458 7.726-7.726 7.726z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m119.185 317.508c-1.977 0-3.955-.755-5.464-2.263-3.017-3.018-3.017-7.909 0-10.928l7.723-7.723c3.018-3.016 7.909-3.016 10.928 0 3.017 3.018 3.017 7.909 0 10.928l-7.723 7.723c-1.51 1.509-3.487 2.263-5.464 2.263z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m91.766 224.945h-10.922c-4.268 0-7.726-3.459-7.726-7.726 0-4.268 3.459-7.726 7.726-7.726h10.923c4.268 0 7.726 3.459 7.726 7.726s-3.459 7.726-7.727 7.726z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m126.908 140.105c-1.977 0-3.955-.755-5.463-2.263l-7.723-7.722c-3.018-3.017-3.018-7.909-.001-10.927 3.018-3.018 7.91-3.017 10.927-.001l7.723 7.722c3.018 3.017 3.018 7.909.001 10.927-1.509 1.509-3.487 2.264-5.464 2.264z"
                                      fill="#365e7d"/>
                            </g>
                        </g>
                        <g>
                            <path d="m211.748 228.123h-37.545c-4.268 0-7.726-3.459-7.726-7.726s3.459-7.726 7.726-7.726h29.819v-65.392c0-4.268 3.459-7.726 7.726-7.726s7.726 3.459 7.726 7.726v73.119c0 4.266-3.458 7.725-7.726 7.725z"
                                  fill="#2b4d66"/>
                        </g>
                        <circle cx="378.794" cy="373.323" fill="#dd636e" r="133.206"/>
                        <path d="m378.794 240.117c-5.186 0-10.3.307-15.331.884 66.345 7.604 117.875 63.941 117.875 132.322s-51.53 124.718-117.875 132.322c5.032.577 10.145.884 15.331.884 73.568 0 133.206-59.638 133.206-133.206 0-73.567-59.638-133.206-133.206-133.206z"
                              fill="#da4a54"/>
                        <path d="m400.647 373.323 39.246-39.246c6.035-6.034 6.035-15.819 0-21.853-6.034-6.034-15.819-6.034-21.853 0l-39.246 39.246-39.246-39.246c-6.034-6.036-15.819-6.034-21.853 0-6.035 6.034-6.035 15.819 0 21.853l39.246 39.246-39.246 39.246c-6.035 6.034-6.035 15.819 0 21.853 3.017 3.017 6.972 4.526 10.927 4.526s7.909-1.509 10.927-4.526l39.246-39.246 39.246 39.246c3.017 3.018 6.972 4.526 10.927 4.526s7.909-1.509 10.927-4.526c6.035-6.034 6.035-15.819 0-21.853z"
                              fill="#f4fbff"/>
                        <g>
                            <path d="m400.647 373.323 39.246-39.246c6.035-6.034 6.035-15.819 0-21.853-5.885-5.884-15.327-6.013-21.388-.42.154.142.315.271.465.42 6.035 6.034 6.035 15.819 0 21.853l-32.777 32.777c-3.573 3.573-3.573 9.366 0 12.939l32.777 32.777c6.035 6.034 6.035 15.819 0 21.853-.149.15-.311.279-.465.421 2.954 2.726 6.703 4.106 10.462 4.106 3.955 0 7.909-1.509 10.927-4.526 6.035-6.034 6.035-15.819 0-21.853z"
                                  fill="#daf1f4"/>
                        </g>
                    </g>
                </svg>
            </div>
            <span class="timeout-modal__title site-main-text-color">##searchTitleLoder##</span>

            <p class="timeout-modal__flight">
                ##searchContentLoader##
            </p>
            <button type="button" class="btn btn-research site-bg-main-color" >
              ##Repeatsearch##
            </button>
            <a class="btn btn_back_home site-main-text-color" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}">##searchReturnToMainPage##</a>
        </div>
    </div>
</div>
<script type="text/javascript">
    getResultTicketLocal('{$smarty.const.SEARCH_ORIGIN}', '{$smarty.const.SEARCH_DESTINATION}', '{$smarty.const.SEARCH_DEPT_DATE}', '{$smarty.const.SEARCH_RETURN_DATE}', '{$smarty.const.SEARCH_CLASSF}', '{$smarty.const.SEARCH_ADULT}', '{$smarty.const.SEARCH_CHILD}', '{$smarty.const.SEARCH_INFANT}', '{$smarty.const.ISFOREIGN}', '{$smarty.const.SEARCH_FLIGHT_NUMBER}');
</script>


<input type="hidden" value="{$smarty.const.SEARCH_MULTI_WAY}" name="MultiWayTicket" id="MultiWayTicket"/>
<input type="hidden" value="{$smarty.const.SEARCH_FLIGHT_NUMBER}" name="searchFlightNumber" id="searchFlightNumber"/>
<input type="hidden" value="" name="PrivateCharter" id="PrivateCharter">
<input type="hidden" value="" name="IdPrivate" id="IdPrivate">

<!-- login and register popup -->
{assign var="useType" value="ticket"}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentLoginRegister.tpl"}
<!-- login and register popup -->


<form method="post" id="formAjax" action="">
    <input id="temporary" name="temporary" type="hidden" value="">
    <input id="ZoneFlight" name="ZoneFlight" type="hidden" value="">
    <input type="hidden" value='{$objResult->set_session_passenger()}' name="PostPassenger" id="PostPassenger">
    {*<input type="hidden" value='' name="SourceM5_ID" id="SourceM5_ID">*}
</form>

<script src="assets/js/script.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/wow.min.js"></script>

<script type="text/javascript">
    var SmsAllow = '{$smarty.const.IS_ENABLE_TEL_ORDER}';
    var TelAllow = '{$smarty.const.IS_ENABLE_SMS_ORDER}';
</script>
{literal}
    <!-- modal -->
    <script type="text/javascript">


        $(document).ready(function () {


            $('body').on('click','.currency-gds',function (){
                $(this).find('.change-currency').toggle();
                if ($(".currency-inner .currency-arrow").hasClass("currency-rotate")) {
                    $( ".currency-inner .currency-arrow" ).removeClass('currency-rotate');
                } else {
                    $( ".currency-inner .currency-arrow" ).addClass('currency-rotate')
                }
            })
            $('body').on('click','.btn-research',function (){
                location.reload(true);
            })

            setTimeout(function() {
                $('.lazy_loader_flight').slideDown({
                    start: function () {
                        $(this).css({
                            display: "flex"
                        });

                    }
                });
            }, 600000);
            window.onscroll = function() {myFunction()};
            function myFunction() {
                $('.progress-container').css('opacity','1');


                var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                if(winScroll < 3){
                    $('.progress-container').css('opacity','0');
                }
                var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                var scrolled = (winScroll / height) * 100;
                document.getElementById("myBarHead").style.width = scrolled + "%";
            };

            $('body').on('click', '.s-u-filter-title', function () {
                $(this).parent().find('.s-u-filter-content').slideToggle();
                $(this).parent().toggleClass('hidden_filter');
            })
            $('body').delegate('.DetailSelectTicket', 'click', function () {
                $(this).parent().siblings('.DetailSelectTicketContect').slideToggle('fast');
            });



        });

    </script>
    <!-- loader -->

{/literal}
<div id="ModalPublic" class="modal">
    <div class="modal-content" id="ModalPublicContent"></div>
</div>