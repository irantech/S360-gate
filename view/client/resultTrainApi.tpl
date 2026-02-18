{load_presentation_object filename="resultTrainApi" assign="objResult"}
{$objResult->getRouteFromDB()}
{assign var="Departure_City" value=$objResult->GetNameCity($smarty.const.DEP_CITY)}
{assign var="Arrival_City" value=$objResult->GetNameCity($smarty.const.ARR_CITY)}
{$objResult->DateJalali($smarty.const.REQUEST_DATE)}
{*{assign var="route" value=$objResult->ListStation()}*}
{assign var="returnList" value=''}
{assign var="TrainCompanys" value=$objResult->activeCompanys}
{load_presentation_object filename="currencyEquivalent" assign="objCurrency"}

{assign var="InfoMember"  value= $objFunctions->infoMember($objSession->getUserId())}
{assign var="InfoCounter" value=$objFunctions->infoCounterType($InfoMember.fk_counter_type_id)}


<div class="s-u-black-container"></div>
<div class="progress-container">
    <div class="progress-bar site-bg-main-color" id="myBarHead"></div>
</div>
<div class="s-u-content-result result_train_api">
    <div class="row minW-100">
    <div class="col-lg-3 col-md-12 col-sm-12 col-12 train-sidebar col-padding-5">

        <div class="parent_sidebar">
        <!-- Result search -->
        <div class="filtertip train-filter-change site-bg-main-color site-bg-color-border-bottom ">
            {if $objResult->indate($smarty.const.REQUEST_DATE) eq true}
            <a href="{$smarty.const.ROOT_ADDRESS}/resultTrainApi/{$smarty.const.DEP_CITY}-{$smarty.const.ARR_CITY}/{$objResult->DatePrev($smarty.const.REQUEST_DATE)}/{$smarty.const.TYPE_WAGON}/{$smarty.const.ADULT}-{$smarty.const.CHILD}-{$smarty.const.INFANT}">
                {/if}
                <span class=" chooseiconDay icons tooltipWeighDay right site-border-text-color">
                    <i class="zmdi zmdi-chevron-right iconDay site-secondary-text-color">
                        <span class="tooltiptextWeightDay"> ##Previousday## </span>
                    </i>
                </span>
                {if $objResult->indate($smarty.const.REQUEST_DATE) eq true}
            </a>
            {/if}
            <div class="tip-content">
                <p class="">
                    <span class=" bold counthotel">{$Departure_City}</span>
                    ##On##
                    <span class=" bold counthotel">{$Arrival_City}</span>
                </p>
                <p class="counthotel">{$objResult->day}، {$objResult->date_now}</p>
            </div>
            <a href="{$smarty.const.ROOT_ADDRESS}/resultTrainApi/{$smarty.const.DEP_CITY}-{$smarty.const.ARR_CITY}/{$objResult->DateNext($smarty.const.REQUEST_DATE)}/{$smarty.const.TYPE_WAGON}/{$smarty.const.ADULT}-{$smarty.const.CHILD}-{$smarty.const.INFANT}">
                <span class=" chooseiconDay icons tooltipWeighDay left site-border-text-color">
                    <i class="zmdi zmdi-chevron-left iconDay site-secondary-text-color">
                        <span class="tooltiptextWeightDay"> ##Nextday## </span>
                    </i>
                </span>
            </a>

            <div class="open-sidebar-train " onclick="showSearchBoxTicketTrain()">##ChangeSearchType##</div>

            <div class="filter_search_train">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0" y="0" viewBox="0 0 512 512" xml:space="preserve" class="site-bg-svg-color"><g>
                        <g xmlns="http://www.w3.org/2000/svg">
                            <path d="m420.404 0h-328.808c-50.506 0-91.596 41.09-91.596 91.596v328.809c0 50.505 41.09 91.595 91.596 91.595h328.809c50.505 0 91.595-41.09 91.595-91.596v-328.808c0-50.506-41.09-91.596-91.596-91.596zm61.596 420.404c0 33.964-27.632 61.596-61.596 61.596h-328.808c-33.964 0-61.596-27.632-61.596-61.596v-328.808c0-33.964 27.632-61.596 61.596-61.596h328.809c33.963 0 61.595 27.632 61.595 61.596z" fill="#009aff" data-original="#000000" style="" class=""></path><path d="m432.733 112.467h-228.461c-6.281-18.655-23.926-32.133-44.672-32.133s-38.391 13.478-44.672 32.133h-35.661c-8.284 0-15 6.716-15 15s6.716 15 15 15h35.662c6.281 18.655 23.926 32.133 44.672 32.133s38.391-13.478 44.672-32.133h228.461c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-273.133 32.133c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.686 17.133 17.133-7.686 17.133-17.133 17.133z" fill="#009aff" data-original="#000000" style="" class=""></path>

                            <path d="m432.733 241h-35.662c-6.281-18.655-23.927-32.133-44.672-32.133s-38.39 13.478-44.671 32.133h-228.461c-8.284 0-15 6.716-15 15s6.716 15 15 15h228.461c6.281 18.655 23.927 32.133 44.672 32.133s38.391-13.478 44.672-32.133h35.662c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-80.333 32.133c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.686 17.133 17.133-7.686 17.133-17.133 17.133z" fill="#009aff" data-original="#000000" style="" class=""></path>
                            <path d="m432.733 369.533h-164.194c-6.281-18.655-23.926-32.133-44.672-32.133s-38.391 13.478-44.672 32.133h-99.928c-8.284 0-15 6.716-15 15s6.716 15 15 15h99.928c6.281 18.655 23.926 32.133 44.672 32.133s38.391-13.478 44.672-32.133h164.195c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-208.866 32.134c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.685 17.133 17.132-7.686 17.134-17.133 17.134z" fill="#009aff" data-original="#000000" style="" class=""></path>

                        </g>
                    </g>
                </svg>
                <span class="site-main-text-color"> فیلتر</span>
            </div>

        </div>
        <!-- search box -->
        <div class=" s-u-update-popup-change s-u-update-popup-change-train">
            <form class="search-wrapper" action="" name="gds_train" method="post">

                <div class="displayib padr20 padl20">

                    <div class="ways_btns">

                        <div onclick="changeWaysTrain('Oneway')" class="radiobtn Oneway">

                            <input type="radio" id="huey"
                                   name="drone" value="huey" checked/>
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
                        <div onclick="changeWaysTrain('Twoway')" class="radiobtn">
                            <input type="radio" id="dewey"
                                   name="drone" class="TwowayTrain {if $smarty.const.SEARCH_MULTI_WAY eq 'TwoWay'}checked{/if}" value="dewey" {if $smarty.const.SEARCH_MULTI_WAY eq 'TwoWay'}checked{/if}/>
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
                        <select class="select2 option1 " name="origin_train" id="origin_train" style="width:100%;"
                                tabindex="2">
                            {foreach $objResult->route_train as $Dep}
                                <option value="{$Dep.Code}"
                                        {if $Dep.Code == $smarty.const.DEP_CITY}selected="selected"{/if}>{$Dep.Name}
                                </option>
                            {/foreach}
                        </select>
                    </div>
                </div>

                <div class="swap-flight-box" onclick="reversOriginDestinationTrain()">
                    <span class="swap-flight"><i class="zmdi zmdi-swap site-main-text-color"></i></span>
                </div>

                <div class="s-u-form-block s-u-num-inp s-u-num-inp-change bargasht bargasht-change change-bor">
                    <div class="s-u-in-out-wrapper ">
                        <select class="select2 option1 " name="destination_train" id="destination_train"
                                style="width:100%;"
                                tabindex="2">
                            {foreach $objResult->route_train as $Arr}
                                <option value="{$Arr.Code}"
                                        {if $Arr.Code == $smarty.const.ARR_CITY}selected="selected"{/if}>{$Arr.Name}
                                </option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                </div>
                <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100 pr-0">
                    <div class="s-u-form-date-wrapper">
                        <div class="s-u-date-pick">
                            <div class="s-u-jalali s-u-jalali-change">
                                <i class="zmdi zmdi-calendar-note site-main-text-color"></i>
                                <input class="shamsiDeptCalendar" type="text" name="dept_date_train"
                                       id="dept_date_train"
                                       placeholder=" ##Wentdate##" readonly="readonly"
                                       value="{$objResult->DateJalaliRequest}"/>
                            </div>
                        </div>
                    </div>
                </div>

                {if $smarty.const.SEARCH_RETURN_DATE neq ''}
                    {$objResult->DateJalali($smarty.const.SEARCH_RETURN_DATE)}
                {/if}

                <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100 pr-0 {if $smarty.const.SEARCH_MULTI_WAY eq 'TwoWay'} showHidden {else} hidden {/if}">
                    <div class="s-u-form-date-wrapper">
                        <div class="s-u-date-pick">
                            <div class="s-u-jalali s-u-jalali-change">

                                <i class="zmdi zmdi-calendar-note site-main-text-color"></i>
                                <input class="shamsiDeptCalendar" type="text" name="dept_date_train_return"
                                       id="dept_date_train_return" placeholder=" ##Returndate##" readonly="readonly"
                                       value="{$objResult->DateJalaliRequest}"/>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="number_passengers">
                <div class="s-u-form-block s-u-num-inp s-u-num-inp-change">
                    <div class="s-u-form-input-wrapper">
                        <div class="s-u-number-input s-u-number-input-change inp-adt inp-adt-change">
                            <i class="plus zmdi zmdi-plus-circle site-main-text-color-h" id="add1"></i>
                            <span>
                                 <input class="site-main-text-color-drck" id="qty1" type="text" value="{$smarty.const.ADULT}" name="adult" min="0"
                                        max="9" />
                                ##Adult##
                            </span>
                            <i class="minus zmdi zmdi-minus-circle site-main-text-color-h" id="minus1"></i>
                        </div>
                    </div>
                </div>

                <div class="s-u-form-block s-u-num-inp s-u-num-inp-change">
                    <div class="s-u-form-input-wrapper">
                        <div class="s-u-number-input s-u-number-input-change inp-child inp-child-change">
                            <i class="plus zmdi zmdi-plus-circle site-main-text-color-h" id="add2"></i>
                            <span>
                                <input class="site-main-text-color-drck" id="qty2" type="text" value="{$smarty.const.CHILD}" name="child" min="0"
                                       max="9">
                                ##Child##
                            </span>
                            <i class="minus zmdi zmdi-minus-circle site-main-text-color-h" id="minus2"></i>
                        </div>
                    </div>
                </div>

                <div class="s-u-form-block s-u-num-inp s-u-num-inp-change">
                    <div class="s-u-form-input-wrapper">
                        <div class="s-u-number-input  s-u-number-input-change  inp-baby inp-baby-change">
                            <i class="plus zmdi zmdi-plus-circle site-main-text-color-h" id="add3"></i>

                            <span>
                                <input class="site-main-text-color-drck" id="qty3" type="text" value="{$smarty.const.INFANT}" name="infant" min="0"
                                       max="9">
                                ##Baby##</span>

                            <i class="minus zmdi zmdi-minus-circle site-main-text-color-h" id="minus3"></i>
                        </div>
                    </div>
                </div>
                </div>
                <div class="train_filter_ p-0 pt-3 pb-3">

                    <div class="btn-group-justified btn-group btn-group-toggle special-group normal-border" data-toggle="buttons">
                        <label class="btn site-main-button-color-hover border-0 site-main-button-color-hover-active {if $smarty.const.TYPE_WAGON eq 3} active {/if}">
                            <input type="radio" value="3" name="Type_seat_train" id="rd-check" {if $smarty.const.TYPE_WAGON eq 3} checked {/if} > مسافر عادی
                        </label>
                        <label class="btn site-main-button-color-hover border-0 site-main-button-color-hover-active {if $smarty.const.TYPE_WAGON eq 1} active {/if}">
                            <input type="radio" value="1" name="Type_seat_train" id="rd-check2" {if $smarty.const.TYPE_WAGON eq 1} checked {/if} > ویژه برادران
                        </label>
                        <label class="btn site-main-button-color-hover border-0 site-main-button-color-hover-active {if $smarty.const.TYPE_WAGON eq 2} active {/if}">
                            <input type="radio" value="2" name="Type_seat_train" id="rd-check3" {if $smarty.const.TYPE_WAGON eq 2} checked {/if} >ویژه خواهران
                        </label>
                    </div>

                    {*<div class="form-group non-selectable">
                        <input type="radio" value="3" id="rd-check" name="Type_seat_train"
                               class="form-control-rd" {if $smarty.const.TYPE_WAGON eq 3} checked="checked" {/if}>
                        <label for="rd-check" class="form-control-rd-lbl">
                            <span class="site-bg-main-color-before"></span>
                        </label>
                        <label for="rd-check" class="pointer">مسافرین عادی</label>
                    </div>

                    <div class="form-group non-selectable">
                        <input type="radio" value="1" data-radio-type="one" id="rd-check2" name="Type_seat_train"
                               class="form-control-rd" {if $smarty.const.TYPE_WAGON eq 1} checked="checked" {/if}>
                        <label for="rd-check2" class="form-control-rd-lbl">
                            <span class="site-bg-main-color-before"></span>
                        </label>
                        <label for="rd-check2" class="pointer">ویژه برادران</label>
                    </div>

                    <div class="form-group non-selectable">
                        <input type="radio" value="2" data-radio-type="one" id="rd-check3" name="Type_seat_train"
                               class="form-control-rd" {if $smarty.const.TYPE_WAGON eq 2} checked="checked" {/if}>
                        <label for="rd-check3" class="form-control-rd-lbl">
                            <span class="site-bg-main-color-before"></span>
                        </label>
                        <label for="rd-check3" class="pointer">ویژه خواهران</label>
                    </div>*}
                </div>
                {*<p class="checkbox_coupe">
                    <input type="checkbox" id="coupe" {if $smarty.const.COUPE eq 1}checked {/if}>
                    <label for="coupe">کوپه در بست</label>
                </p>*}

                <div class="custom-control custom-checkbox bootstrap-checkbox-style">
                    <input type="checkbox" class="custom-control-input" {if $smarty.const.COUPE eq 1}checked {/if}
                           id="coupe">
                    <label class="custom-control-label " for="coupe">##CoupeClosed##</label>
                </div>


                <div class="s-u-search-wrapper s-u-num-inp s-u-num-inp-search-change">
                    <a href="" onclick="return false" class="f-loader-check f-loader-check-bar" id="loader_check_submit"
                       style="display:none"></a>

                    <button type="button" onclick="submitSearchTrain()" id="sendFlight"
                            class="site-bg-main-color">##Search##
                    </button>
                </div>
            </form>

            <div class="message_error_portal"></div>
        </div>

        <ul id="s-u-filter-wrapper-ul">
            <span class="s-u-close-filter"></span>


            <!-- capacityfilter -->

            <li class="s-u-filter-item" data-group="train-capacity">
                <span class="s-u-filter-title">
                    <i class="zmdi zmdi-subway "></i> ظرفیت</span>
                <div class="s-u-filter-content">

                    <ul class="s-u-filter-item-time filter-capacity-ul">
                        <li>
                            <label>فقط دارای ظرفیت</label>
                            <input class="check-switch" type="checkbox" id="filter-capcity" value="0"/>
                            <span data-inactive="##Inactive##" data-active="##Active##"
                                  class="tzCBPart site-bg-filter-color filter-to-check"
                                  onclick="filterTrainByCapcity(this)"></span>
                        </li>
                    </ul>
                </div>
            </li>


            <!-- pricefilter -->
            <li class="s-u-filter-item" data-group="bus-price">
                <input type="hidden" name="minPrice" id="minPriceRange" value="{$objResult->minPrice}">
                <input type="hidden" name="maxPrice" id="maxPriceRange" value="{$objResult->maxPrice}">
                <span class="s-u-filter-title"><i
                            class="zmdi zmdi-money"></i> ##Price## (##Rial##)</span>
                <div class="s-u-filter-content">

                    <p>
                        <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;"
                               onload="selectPriceRange('{$objResult->minPrice}', '{$objResult->maxPrice}');">
                    </p>
                    <div id="slider-range">

                    </div>
                </div>
            </li>

            {*<!-- flight type filter -->*}
            {*<li class="s-u-filter-item" data-group="flight-type">*}

            {*<span class="s-u-filter-title site-main-text-color-drck"><i class="zmdi zmdi-flight-takeoff site-main-text-color"></i> نوع پرواز</span>*}

            {*<div class="s-u-filter-content">*}

            {*<ul class="s-u-filter-item-time filter-type-ul">*}

            {*<li>*}
            {*<label>همه</label>*}
            {*<input class="check-switch" type="checkbox" id="filter-type" value="all" />*}
            {*<span class="tzCBPart site-bg-filter-color checked filter-to-check"*}
            {*onclick="filterFlight(this)"></span>*}
            {*</li>*}

            {*<li>*}
            {*<label>سیستمی</label>*}
            {*<input class="check-switch" type="checkbox" id="filter-system" value="system" />*}
            {*<span class="tzCBPart site-bg-filter-color" onclick="filterFlight(this)"></span>*}
            {*</li>*}

            {*<li>*}

            {*<label>چارتری</label>*}
            {*<input class="check-switch" type="checkbox" id="filter-charter" value="charter" />*}
            {*<span class="tzCBPart site-bg-filter-color" onclick="filterFlight(this)"></span>*}
            {*</li>*}
            {*</ul>*}
            {*</div>*}
            {*</li>*}

            {*<!-- seat class filter -->*}
            {*<li class="s-u-filter-item" data-group="flight-seat">*}

            {*<span class="s-u-filter-title site-main-text-color-drck"><i class="zmdi zmdi-airline-seat-recline-extra site-main-text-color"></i> کلاس پروازی</span>*}

            {*<div class="s-u-filter-content">*}

            {*<ul class="s-u-filter-item-time filter-seat-ul">*}

            {*<li>*}
            {*<label>همه</label>*}
            {*<input class="check-switch" type="checkbox" id="filter-seat" value="all" />*}
            {*<span class="tzCBPart site-bg-filter-color checked filter-to-check"*}
            {*onclick="filterFlight(this)"></span>*}
            {*</li>*}

            {*<li>*}
            {*<label>اکونومی</label>*}
            {*<input class="check-switch" type="checkbox" id="filter-economy" value="economy" />*}
            {*<span class="tzCBPart site-bg-filter-color" onclick="filterFlight(this)"></span>*}
            {*</li>*}

            {*<li>*}

            {*<label>بیزینس</label>*}
            {*<input class="check-switch" type="checkbox" id="filter-business" value="business" />*}
            {*<span class="tzCBPart site-bg-filter-color" onclick="filterFlight(this)"></span>*}
            {*</li>*}
            {*</ul>*}
            {*</div>*}
            {*</li>*}

            <!-- airline filter -->

            {assign var="companys" value=$objFunctions->getAllCompanyTrain()}
            <li class="s-u-filter-item" data-group="bus-companys">
                <span class="s-u-filter-title"><i
                            class="zmdi zmdi-subway "></i> شرکت ریلی</span>
                <div class="s-u-filter-content">

                    <ul class="s-u-filter-item-time filter-airline-ul">
                        <li>
                            <label>##All##</label>
                            <input class="check-switch" type="checkbox" id="filter-companyBus" value="0"/>
                            <span data-inactive="##Inactive##" data-active="##Active##"  class="tzCBPart site-bg-filter-color checked filter-to-check"
                                  onclick="filterTrainByCompany(this)"></span>
                        </li>

                        {foreach key=key item=item from=$companys}
                            <li class="filter-row" id="{$item.code_company}-filter">
                                <label>{$item.name_company}</label>
                                <input class="check-switch" type="checkbox" id="filter-{$item.code_company}"
                                       value="{$item.code_company}"/>
                                <span data-inactive="##Inactive##" data-active="##Active##"  class="tzCBPart site-bg-filter-color" onclick="filterTrainByCompany(this)"></span>
                            </li>
                        {/foreach}
                    </ul>
                </div>
            </li>

            <!-- time filter -->
            <li class="s-u-filter-item" data-group="bus-time">
                <span class="s-u-filter-title"><i
                            class="zmdi zmdi-time"></i> ##RunTime##</span>
                <div class="s-u-filter-content">
                    <ul class="s-u-filter-item-time filter-time-ul">
                        <li>
                            <label>##All##</label>
                            <input class="check-switch" type="checkbox" id="filter-time" value="all" />
                            <span data-inactive="##Inactive##" data-active="##Active##" class="tzCBPart site-bg-filter-color checked filter-to-check"
                                  onclick="filterTrainByCompany(this)"></span>
                        </li>

                        <li>
                            <label><i>(0-8)</i> ##Morning## </label>
                            <input class="check-switch" type="checkbox" id="filter-early" value="early"/>
                            <span data-inactive="##Inactive##" data-active="##Active##"  class="tzCBPart site-bg-filter-color " onclick="filterTrainByCompany(this)"></span>
                        </li>

                        <li>
                            <label> <i>(8-12)</i> ##Timemorning##</label>
                            <input class="check-switch" type="checkbox" id="filter-morning" value="morning"/>
                            <span data-inactive="##Inactive##" data-active="##Active##"  class="tzCBPart site-bg-filter-color" onclick="filterTrainByCompany(this)"></span>
                        </li>

                        <li>
                            <label> <i>(12-18)</i> ##Timeevening##</label>
                            <input class="check-switch" type="checkbox" id="filter-afternoon" value="afternoon"/>
                            <span data-inactive="##Inactive##" data-active="##Active##"  class="tzCBPart site-bg-filter-color" onclick="filterTrainByCompany(this)"></span>
                        </li>

                        <li>
                            <label> <i>(18-24)</i> ##Timenight##</label>
                            <input class="check-switch" type="checkbox" id="filter-night" value="night"/>
                            <span data-inactive="##Inactive##" data-active="##Active##"  class="tzCBPart site-bg-filter-color" onclick="filterTrainByCompany(this)"></span>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>

        <div class="articles-list d-none">

            <h6>##RelatedArticles##</h6>
            <ul></ul>

        </div>
        </div>
    </div>


    <div id="result" class="col-lg-9 col-md-12 col-sm-12 col-12 col-padding-5">

        <div class="loader-section">
            <div id="loader-page" class="lazy-loader-parent ">
                <div class="loader-page container site-bg-main-color">
                    <div class="parent-in row">

                        <div class="loader-txt">
                            <div id="train_loader">
                          <span class="loader-date">

                      در حال جستجو

                          </span>
                                <div class="wrapper">

                                    <div class="locstart"></div>
                                    <div class="flightpath">
                                        <div class="airplane"></div>
                                    </div>
                                    <div class="locend"></div>
                                </div>
                            </div>
                            <!--                          <div class="logo-img">
                                                      <img  v-bind:src="logo" alt="logo" class="logo-icon">
                                                            </div>-->

                            <div class="loader-distinc">
                                در حال جستجوی بهترین قیمت ها از
                                <span> {$Departure_City}</span>
                                به
                                <span>{$Arrival_City}</span>
                                برای شما هستیم
                            </div>
                        </div>

                        <!-- <div class="wrapper2"></div>
                           <div class="marquee"><p>لطفا منتظر بمانید...</p></div>-->
                    </div>

                </div>
            </div>
        </div>



    </div>


        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`faqs.tpl"
        service='Train'
        origin=$smarty.const.DEP_CITY
        destination=$smarty.const.ARR_CITY}




        <!-- login and regisort_trainster popup -->
    {assign var="useType" value="train"}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentLoginRegister.tpl"}

    {assign var='ConstSmarty' value=['ISCoupe'=>$smarty.const.COUPE,'PassengerCount'=>$smarty.const.PASSENGER_COUNT]}


    <input type="hidden" name="serviceIdBib" id="serviceIdBib" value="">
    <input type="hidden" name="code" id="code" value="">
    <input type="hidden" name="IsCoupe" id="IsCoupe" value="{$smarty.const.COUPE}">
    <input type="hidden" name="PassengerCount" id="PassengerCount" value="{$smarty.const.PASSENGER_COUNT}">
    </div>
</div>
<script src="assets/js/scrollWithPage.min.js"></script>
{assign var="SearchData" value=['DepartureDate' => $smarty.const.REQUEST_DATE,'ReturnDate' =>$smarty.const.SEARCH_RETURN_DATE,'DepartureCity' => $smarty.const.DEP_CITY,'ArrivalCity'=>$smarty.const.ARR_CITY,'PassengerNumber'=>$smarty.const.PASSENGER_NUM,'TypeWagon'=>$smarty.const.TYPE_WAGON,'AdultCount'=>$smarty.const.ADULT,'ChildCount'=>$smarty.const.CHILD,'InfantCount'=>$smarty.const.INFANT,'Coupe'=>$smarty.const.COUPE,'lang'=>$smarty.const.SOFTWARE_LANG,'PassengerCount'=>$smarty.const.PASSENGER_COUNT]}
<!-- login and register popup -->

<script type="text/javascript">
    window.onscroll = function() {
        myFunction()
    };
    // if($(window).width() > 990){
    //     $(".parent_sidebar").scrollWithPage(".result_train_api");
    // }
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

    $(document).ready(function () {
        getResultTrain('{$SearchData|json_encode}');
    });
    $('body').on('click', '.s-u-filter-title', function () {
        $(this).parent().find('.s-u-filter-content').slideToggle();
        $(this).parent().toggleClass('hidden_filter');
    })
    function changeWaysTrain(obj) {
        if(obj == 'Oneway'){
            $('.TwowayTrain').removeClass('checked');
            $('#dept_date_train_return').parents('.s-u-form-block').removeClass('showHidden').addClass('hidden');
        }
        else{
            $('.TwowayTrain').addClass('checked');
            $('#dept_date_train_return').parents('.s-u-form-block').removeClass('hidden').addClass('showHidden');
        }

    }
    $(function () {
        var minPrice =parseInt('<?php echo (isset($this->PminPrice) && $this->PminPrice > 0) ? (($minPrice < $this->PminPrice) ? $minPrice : $this->PminPrice) : $minPrice ?>'),
            maxPrice = parseInt('<?php echo (isset($this->PmaxPrice) && $this->PminPrice > 0) ? (($maxPrice > $this->PmaxPrice) ? $maxPrice : $this->PmaxPrice) : $maxPrice ?>');

        //                    $filter_lists = $(".s-u-filter-item > div  > ul"),
//                    $filter_checkboxes = $(".s-u-filter-item input.check-switch"),
//                    $ticketsFlight = $(".international-available-box");

//                $filter_checkboxes.change(filterflight);



        $('#slider-range-train').slider({
            range: true,
            min: minPrice,
            max: maxPrice,
            step: 1000,
            values: [minPrice, maxPrice],
            slide: function (event, ui) {

                $("#amount").val(addCommas(ui.values[0]) + " - " + addCommas(ui.values[1]));
                minPrice = ui.values[0];
                maxPrice = ui.values[1];
                filterflightPrice();

            }
        });

        $("#amount").val(addCommas(minPrice) + " - " + addCommas(maxPrice));

        function addCommas(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }

        function filterSlider(elem) {
            var price = parseInt($(elem).data("price"), 10);
            return price >= minPrice && price <= maxPrice;
        }

        function filterflightPrice() {
            $(".international-available-box").hide().filter(function () {
                return filterSlider(this);
            }).show();
        }

    });



</script>
<script src="assets/js/script.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/wow.min.js"></script>


