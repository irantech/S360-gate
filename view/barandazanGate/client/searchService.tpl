{load_presentation_object filename="searchService" assign="objSearch"}
{assign var='checkAccessService' value=$objSearch->checkAccessService()}
{if $smarty.const.SOFTWARE_LANG eq 'fa'}
    {assign var='base_language' value="fa"}
    {assign var="DeptDatePickerClass" value='shamsiDeptCalendar'}
    {assign var="ReturnDatePickerClass" value='shamsiReturnCalendar'}
    {assign var="DeptDatePickerHotelLocal" value='shamsiDeptCalendarToCalculateNights'}
    {assign var="ReturnDatePickerHotelLocal" value='shamsiReturnCalendarToCalculateNights'}
{else}
    {assign var='base_language' value="en"}
    {assign var="DeptDatePickerClass" value='gregorianDeptCalendar'}
    {assign var="ReturnDatePickerClass" value='gregorianReturnCalendar'}
    {assign var="DeptDatePickerHotelLocal" value='deptCalendarToCalculateNights'}
    {assign var="ReturnDatePickerHotelLocal" value='returnCalendarToCalculateNights'}
{/if}
{if $checkAccessService neq ''}

    {if 'Flight'|in_array:$checkAccessService}
        {assign var='departures' value=$objSearch->getDepartures()}
        {assign var='cities' value=$objSearch->getFlightRoutInternal(7)}
        {assign var='duplicated_cities' value=$cities}
    {/if}

    {if 'Hotel'|in_array:$checkAccessService}
        {assign var='hotelCities' value=$objSearch->getAllHotelCities()}
    {/if}

    {if 'Train'|in_array:$checkAccessService}
        {assign var='trainRoutes' value=$objSearch->getTrainRoutes()}
    {/if}

    {if 'Bus'|in_array:$checkAccessService}
        {assign var='busRoutes' value=$objSearch->getBusRoutes()}
    {/if}

    {if 'Tour'|in_array:$checkAccessService}
		{assign var="listCountryDept" value=$objSearch->getAllTourCountries('all', 'dept')}
		{assign var="listCountryReturn" value=$objSearch->getAllTourCountries('all', 'return')}
		{assign var="listCityDept" value=$objSearch->getAllTourCities(null, 'all', 'dept')}
		{assign var="listCityReturn" value=$objSearch->getAllTourCities(null, 'all', 'return')}
		{assign var="listRegionDept" value=$objSearch->getAllTourRegions(null, 'all', 'dept')}
		{assign var="listRegionReturn" value=$objSearch->getAllTourRegions(null, 'all', 'return')}
    {/if}

    {if 'Insurance'|in_array:$checkAccessService}
        {assign var='insuranceCountries' value=$objSearch->getInsuranceCountries()}
    {/if}

    {if 'Entertainment'|in_array:$checkAccessService}
        {assign var='entertainmentCategiries' value=$objSearch->getCategoryParent()}
    {/if}

    {if 'Visa'|in_array:$checkAccessService}
        {assign var='continents' value=$objSearch->getListContinent()}
    {/if}

    {if 'Visa'|in_array:$checkAccessService}
        {assign var='visTypeLists' value=$objSearch->getVisaTypeList()}
    {/if}

    {if 'GashtTransfer'|in_array:$checkAccessService}
        {assign var='getCitiesGasht' value=$objSearch->getCitiesGasht()}
    {/if}


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

<div class="banner">
    <div class="container ">
        <div class="searchs_box">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item {if 'Flight'|in_array:$checkAccessService} '' {else} hidden {/if}" >
                    <a class="nav-link site-bg-main-color active" id="flight-tab" data-toggle="tab" href="#flight" role="tab"
                       aria-controls="flight" aria-selected="true">
                    <span>
                    <i class="fal fa-plane-alt"></i>
                       <h4>##Airplane##</h4>
                            </span>
                    </a>
                </li>
                <li class="nav-item {if 'Hotel'|in_array:$checkAccessService} '' {else} hidden {/if}">
                    <a class="nav-link site-bg-main-color" id="hotel-tab" data-toggle="tab" href="#hotel" role="tab"
                       aria-controls="hotel" aria-selected="false">
                    <span>
                    <i class="fal fa-bed-alt"></i>
                        <h4>##Hotel##</h4>
                    </span>
                    </a>
                </li>
                <li class="nav-item {if 'Flight'|in_array:$checkAccessService && 'Hotel'|in_array:$checkAccessService && $smarty.const.SOFTWARE_LANG eq 'fa'} '' {else} hidden {/if}">
                    <a class="nav-link site-bg-main-color" id="package-tab" data-toggle="tab" href="#package" role="tab"
                       aria-controls="package" aria-selected="false">
                    <span>
                   <i class="fal fa-suitcase-rolling"></i>
                        <h4>##AirandHotel##</h4>
                    </span>

                    </a>
                </li>
                <li class="nav-item {if 'Train'|in_array:$checkAccessService && $smarty.const.SOFTWARE_LANG eq 'fa'} '' {else} hidden {/if}">
                    <a class="nav-link site-bg-main-color" id="train-tab" data-toggle="tab" href="#train"
                       role="tab" aria-controls="train"
                       aria-selected="false">
                    <span>
                    <i class="fal fa-train"></i>
                        <h4>##Train##</h4>
                    </span>
                    </a>
                </li>
                <li class="nav-item  {if 'Bus'|in_array:$checkAccessService && $smarty.const.SOFTWARE_LANG eq 'fa'} '' {else} hidden {/if}">
                    <a class="nav-link site-bg-main-color" id="bus-tab" data-toggle="tab" href="#bus" role="tab"
                       aria-controls="bus" aria-selected="false">
                    <span>
                    <i class="fal fa-bus"></i>
                        <h4>##Bus##</h4>
                    </span>
                    </a>
                </li>
                <li class="nav-item {if 'Insurance'|in_array:$checkAccessService && $smarty.const.SOFTWARE_LANG eq 'fa'} '' {else} hidden {/if}">
                    <a class="nav-link site-bg-main-color" id="insurance-tab" data-toggle="tab"
                       href="#insurance" role="tab"
                       aria-controls="insurance" aria-selected="false">
                    <span>
                    <i class="fal fa-umbrella"></i>
                        <h4>##Insurance##</h4>
                    </span>

                    </a>
                </li>
                <li class="nav-item {if 'Tour'|in_array:$checkAccessService} '' {else} hidden {/if}">
                    <a class="nav-link site-bg-main-color" id="tour-tab"
                       data-toggle="tab" href="#tour" role="tab"
                       aria-controls="tour" aria-selected="false">
                    <span>
                    <i class="fal fa-route"></i>
                        <h4>##Tour##</h4>
                    </span>
                    </a>
                </li>
                <li class="nav-item  {if 'Entertainment'|in_array:$checkAccessService && $smarty.const.SOFTWARE_LANG eq 'fa'} '' {else} hidden {/if}">
                    <a class="nav-link site-bg-main-color" id="fun-tab" data-toggle="tab" href="#fun"
                       role="tab"
                       aria-controls="fun" aria-selected="false">
                    <span>
                    <i class="fal fa-campground"></i>
                        <h4>##Entertainment##</h4>
                    </span>
                    </a>
                </li>
                <!--<li class="nav-item  ">
                    <a class="nav-link" id="car-tab" data-toggle="tab" href="#car"
                       role="tab"
                       aria-controls="car" aria-selected="false">
                        <span>
                        <i class="fal fa-car"></i>
                            <h4>اجاره خودرو</h4>
                        </span>
                    </a>
                </li>-->
                <li class="nav-item  {if 'Visa'|in_array:$checkAccessService && $smarty.const.SOFTWARE_LANG eq 'fa'} '' {else} hidden {/if} ">
                    <a class="nav-link site-bg-main-color" id="visa-tab" data-toggle="tab" href="#visa"
                       role="tab"
                       aria-controls="visa" aria-selected="false">
                    <span>

                    <i class="fal fa-passport"></i>
                         <h4>##Visa##</h4>
                    </span>
                    </a>
                </li>
                <li class="nav-item  {if 'GashtTransfer'|in_array:$checkAccessService && $smarty.const.SOFTWARE_LANG eq 'fa'} '' {else} hidden {/if}">
                    <a class="nav-link site-bg-main-color" id="gasht-tab" data-toggle="tab"
                       href="#gasht" role="tab"
                       aria-controls="gasht" aria-selected="false">
                    <span>
                    <i class="fal fa-rv"></i>
                        <h4 style="font-size: 14px">##PatrolTransfer##</h4>
                    </span>
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <!--flight-tabpanel-->
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`searchBoxPart/Flight.tpl"}
                <!--hotel-tabpanel-->
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`searchBoxPart/hotel.tpl"}
                <!--tour-tabpanel-->
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`searchBoxPart/tour.tpl"}
                <!--package-tabpanel-->
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`searchBoxPart/package.tpl"}
                <!--train-tabpanel-->
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`searchBoxPart/train.tpl"}
                <!--bus-tabpanel-->
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`searchBoxPart/bus.tpl"}
                <!--fun-tabpanel-->
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`searchBoxPart/entertainment.tpl"}
                <!--car-tabpanel-->
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`searchBoxPart/car.tpl"}
                <!--visa-tabpanel-->
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`searchBoxPart/visa.tpl"}
                <!--gasht-tabpanel-->
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`searchBoxPart/gasht.tpl"}
                <!--insurance-tabpanel-->
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`searchBoxPart/Insurance.tpl"}
            </div>
        </div>

    </div>

</div>
{if 'Flight'|in_array:$checkAccessService}
<!--flightDestination-sections-->
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`sections/flightDestinationSection.tpl"}
{/if}
<div class="services-section sections">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-6 service_item">
                <div class="service-item site-bg-main-color">
                    <div class="service-item-icon">
                        <svg class="site-bg-svg-color" id="Capa_1" style="enable-background:new 0 0 512.004 512.004" version="1.1"
                             viewBox="0 0 512.004 512.004" x="0px" xml:space="preserve"
                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" y="0px"> <g>
                                <g>
                                    <path d="M480.002,0h-448c-17.673,0-32,14.327-32,32v362.667c0,17.673,14.327,32,32,32h256v-21.333h-256
						c-5.891,0-10.667-4.776-10.667-10.667V32c0-5.891,4.776-10.667,10.667-10.667h448c5.891,0,10.667,4.776,10.667,10.667v362.667
						c0,5.891-4.776,10.667-10.667,10.667h-21.333v21.333h21.333c17.673,0,32-14.327,32-32V32C512.002,14.327,497.675,0,480.002,0z"></path>
                                </g>
                            </g>
                            <g>
                                <g>
                                    <path d="M448.002,106.667c-23.564,0-42.667-19.103-42.667-42.667c0-5.891-4.776-10.667-10.667-10.667H117.336
						c-5.891,0-10.667,4.776-10.667,10.667c0,23.564-19.103,42.667-42.667,42.667c-5.891,0-10.667,4.776-10.667,10.667v192
						c0,5.891,4.776,10.667,10.667,10.667c23.564,0,42.667,19.103,42.667,42.667c0,5.891,4.776,10.667,10.667,10.667h138.667V352
						H127.117c-4.588-26.838-25.61-47.86-52.448-52.448V127.115c26.838-4.588,47.86-25.61,52.448-52.448h257.771
						c4.588,26.838,25.61,47.86,52.448,52.448v86.219h21.333v-96C458.669,111.442,453.893,106.667,448.002,106.667z"></path>
                                </g>
                            </g>
                            <g>
                                <g>
                                    <path d="M373.336,224c-53.019,0-96,42.981-96,96s42.981,96,96,96c52.993-0.065,95.935-43.007,96-96
						C469.336,266.981,426.355,224,373.336,224z M373.336,394.667c-41.237,0-74.667-33.429-74.667-74.667
						c0-41.237,33.429-74.667,74.667-74.667c41.218,0.047,74.62,33.449,74.667,74.667C448.002,361.237,414.573,394.667,373.336,394.667
						z"></path>
                                </g>
                            </g>
                            <g>
                                <g>
                                    <path d="M416.002,384v95.136l-36-28.8c-3.897-3.12-9.436-3.12-13.333,0l-36,28.8V384h-21.333v117.333
						c-0.001,2.425,0.824,4.778,2.34,6.671c3.682,4.599,10.395,5.342,14.993,1.66l46.667-37.333l46.667,37.333
						c1.892,1.513,4.244,2.337,6.667,2.336c5.891,0,10.667-4.776,10.667-10.667V384H416.002z"></path>
                                </g>
                            </g>
                            <g>
                                <g>
                                    <path d="M362.669,106.667H149.336c-5.891,0-10.667,4.776-10.667,10.667V160c0,5.891,4.776,10.667,10.667,10.667h213.333
						c5.891,0,10.667-4.776,10.667-10.667v-42.667C373.336,111.442,368.56,106.667,362.669,106.667z M352.002,149.333h-192V128h192
						V149.333z"></path>
                                </g>
                            </g>
                            <g>
                                <g>
                                    <rect height="21.333" width="21.333" x="128.002" y="202.667/">
                                    </rect></g>
                            </g>
                            <g>
                                <g>
                                    <rect height="21.333" width="21.333" x="170.669" y="202.667/">
                                    </rect></g>
                            </g>
                            <g>
                                <g>
                                    <rect height="21.333" width="128" x="128.002" y="245.333/">
                                    </rect></g>
                            </g>
                            <g>
                                <g>
                                    <path d="M373.336,266.667c-29.455,0-53.333,23.878-53.333,53.333s23.878,53.333,53.333,53.333
						c29.441-0.035,53.298-23.893,53.333-53.333C426.669,290.545,402.791,266.667,373.336,266.667z M373.336,352
						c-17.673,0-32-14.327-32-32s14.327-32,32-32s32,14.327,32,32S391.009,352,373.336,352z"></path>
                                </g>
                            </g>
                            <g>
                                <g>
                                    <rect height="21.333" width="21.333" x="53.336" y="352/">
                                    </rect></g>
                            </g>
                            <g>
                                <g>
                                    <rect height="21.333" width="21.333" x="437.336" y="53.333/">
                                    </rect></g>
                            </g>
                            <g>
                                <g>
                                    <rect height="21.333" width="21.333" x="53.336" y="53.333/">
                                    </rect></g>
                            </g> </svg>
                    </div>
                    <span class="service-item-title">##Guaranteeandguarantee##</span>
                    <p>##Guaranteeandguaranteecontent##</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 service_item">
                <div class="service-item site-bg-main-color">
                    <div class="service-item-icon">
                        <svg class="site-bg-svg-color" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 391.228 391.228"
                             style="enable-background:new 0 0 391.228 391.228;" xml:space="preserve">
						<path d="M147.949,95.591c-50.858,19.717-84.835,69.62-84.835,124.178v36.332c0,4.971-4.416,9.127-9.387,9.127H34.966c-15.307,0-27.852-12.58-27.852-27.887v-41.042c0-12.096,7.786-22.718,19.323-26.432c4.735-1.524,9.837,1.078,11.36,5.809c1.523,4.731-1.1,9.802-5.832,11.325c-4.007,1.29-6.851,5.114-6.851,9.298v41.042c0,5.382,4.471,9.887,9.852,9.887h10.148v-27.458c0-31.085,9.174-60.947,26.895-86.357c17.313-24.824,41.129-43.706,69.241-54.604c4.634-1.796,9.848,0.503,11.645,5.139C154.69,88.581,152.583,93.794,147.949,95.591z M294.179,100.714c0,18.881-15.362,34.243-34.244,34.243c-18.881,0-34.243-15.361-34.243-34.243s15.361-34.243,34.243-34.243C278.817,66.471,294.179,81.833,294.179,100.714z M276.179,100.714c0-8.956-7.287-16.243-16.244-16.243c-8.956,0-16.243,7.287-16.243,16.243s7.287,16.243,16.243,16.243C268.892,116.957,276.179,109.67,276.179,100.714z M384.114,196.298v41.042c0,15.307-12.046,27.887-27.353,27.887h-16.623c-5.459,17-14.122,33.788-25.788,48.499c-19.168,24.173-45.545,42.06-74.879,50.912c-1.319,14.807-13.792,26.588-28.933,26.588H181.19c-16.017,0-29.048-12.982-29.048-28.999c0-16.02,13.031-29.001,29.048-29.001h29.349c10.542,0,19.791,5.459,24.882,13.885c55.473-17.165,93.578-68.578,93.578-127.344c0-18.112-3.567-35.647-10.606-52.149l-11.841-5.291c-5.097,3.869-10.613,7.063-16.487,9.547l-1.474,14.216c-0.485,9.366-11.383,15.156-28.654,15.156c-17.318,0-28.212-5.806-28.657-15.2l-1.47-14.171c-5.874-2.483-11.39-5.677-16.488-9.546l-13.094,5.852c-8.351,4.245-18.806-2.298-27.435-17.246c-3.114-5.393-5.342-11.018-6.272-15.835c-1.942-10.064,2.113-14.628,5.086-16.565l11.633-8.429c-0.378-3.116-0.569-6.261-0.569-9.402c0-3.193,0.197-6.387,0.587-9.55l-11.628-8.424c-7.915-5.082-7.496-17.421,1.165-32.419c8.63-14.953,19.089-21.496,27.441-17.241l13.22,5.908c5.056-3.82,10.521-6.977,16.336-9.438l1.488-14.341C231.724,5.807,242.618,0,259.935,0c17.278,0,28.178,5.794,28.655,15.166l1.49,14.375c5.814,2.46,11.28,5.619,16.337,9.438l13.196-5.895c3.164-1.604,9.145-2.833,16.888,3.878c3.707,3.214,7.463,7.955,10.577,13.35c8.638,14.957,9.072,27.292,1.201,32.394l-11.664,8.45c0.39,3.163,0.587,6.357,0.587,9.549c0,3.145-0.19,6.291-0.568,9.401l11.658,8.448c7.858,5.108,7.419,17.44-1.215,32.39c-3.112,5.393-6.869,10.142-10.576,13.357c-0.004,0.004-0.009,0.024-0.014,0.028c6.978,17.646,10.512,36.31,10.512,55.502c0,9.278-0.819,18.395-2.434,27.395h12.196c5.382,0,9.353-4.505,9.353-9.887v-41.042c0-4.185-2.646-8.008-6.653-9.298c-4.731-1.523-7.179-6.594-5.656-11.325c1.523-4.731,6.492-7.333,11.223-5.809C376.566,173.581,384.114,184.203,384.114,196.298z M221.587,362.09c0-0.735-0.072-1.544-0.209-2.239c-0.024-0.104-0.046-0.115-0.067-0.22c-1.121-4.913-5.525-8.404-10.772-8.404H181.19c-6.092,0-11.048,4.906-11.048,10.998c0,6.095,4.956,11.002,11.048,11.002h29.349C216.631,373.228,221.587,368.182,221.587,362.09zM321.568,79.831l14.122-10.231c-0.412-2.107-1.613-5.805-4.201-10.286c-2.586-4.48-5.187-7.369-6.806-8.779l-15.983,7.14c-3.215,1.437-6.974,0.865-9.618-1.462c-5.964-5.25-12.778-9.187-20.25-11.698c-3.343-1.124-5.721-4.096-6.085-7.604l-1.804-17.405C268.913,18.809,265.11,18,259.935,18c-5.173,0-8.976,0.809-11.007,1.505l-1.806,17.406c-0.364,3.507-2.743,6.479-6.084,7.603c-7.477,2.513-14.289,6.448-20.249,11.697c-2.644,2.329-6.405,2.9-9.62,1.462l-15.981-7.142c-1.619,1.41-4.221,4.299-6.808,8.78c-2.587,4.48-3.789,8.178-4.2,10.286l14.122,10.231c2.855,2.069,4.24,5.614,3.542,9.07c-0.78,3.863-1.175,7.835-1.175,11.807c0,3.927,0.387,7.858,1.151,11.687c0.688,3.45-0.697,6.985-3.545,9.049l-14.094,10.212c0.412,2.107,1.613,5.805,4.2,10.284c2.587,4.482,5.189,7.371,6.808,8.781l15.86-7.087c3.223-1.441,6.991-0.863,9.636,1.476c5.989,5.299,12.842,9.268,20.368,11.794c3.344,1.123,5.724,4.095,6.088,7.603l1.789,17.239c2.031,0.697,5.833,1.505,11.007,1.505c5.175,0,8.978-0.809,11.009-1.506l1.788-17.237c0.364-3.508,2.743-6.48,6.086-7.604c7.528-2.528,14.381-6.497,20.368-11.795c2.645-2.34,6.411-2.917,9.635-1.477l15.862,7.086c1.619-1.411,4.219-4.299,6.804-8.778c2.589-4.482,3.791-8.181,4.202-10.288l-14.094-10.21c-2.851-2.065-4.236-5.604-3.544-9.055c0.763-3.813,1.15-7.743,1.15-11.679c0-3.971-0.396-7.943-1.175-11.806C317.329,85.444,318.713,81.899,321.568,79.831z"></path></svg>
                    </div>
                    <span class="service-item-title">##Support24##</span>
                    <p>##Support24content##</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 service_item">
                <div class="service-item site-bg-main-color">
                    <div class="service-item-icon">
                        <svg class="site-bg-svg-color" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                             style="enable-background:new 0 0 512 512;" xml:space="preserve"><g>
                                <g>
                                    <path d="M85.072,454.931c-1.859-1.861-4.439-2.93-7.069-2.93s-5.21,1.069-7.07,2.93c-1.86,1.861-2.93,4.44-2.93,7.07
						s1.069,5.21,2.93,7.069c1.86,1.86,4.44,2.931,7.07,2.931s5.21-1.07,7.069-2.931c1.86-1.859,2.931-4.439,2.931-7.069
						S86.933,456.791,85.072,454.931z"></path>
                                </g>
                            </g>
                            <g>
                                <g>
                                    <path d="M469.524,182.938c-1.86-1.861-4.43-2.93-7.07-2.93c-2.63,0-5.21,1.069-7.07,2.93c-1.859,1.86-2.93,4.44-2.93,7.07
						s1.07,5.21,2.93,7.069c1.86,1.86,4.44,2.931,7.07,2.931c2.64,0,5.21-1.07,7.07-2.931c1.869-1.859,2.939-4.439,2.939-7.069
						S471.393,184.798,469.524,182.938z"></path>
                                </g>
                            </g>
                            <g>
                                <g>
                                    <path d="M509.065,2.929C507.189,1.054,504.645,0,501.992,0L255.998,0.013c-5.522,0-9.999,4.478-9.999,10V38.61l-94.789,25.399
						c-5.335,1.43-8.501,6.913-7.071,12.247l49.127,183.342l-42.499,42.499c-5.409-7.898-14.491-13.092-24.764-13.092H30.006
						c-16.542,0-29.999,13.458-29.999,29.999v162.996C0.007,498.542,13.464,512,30.006,512h95.998c14.053,0,25.875-9.716,29.115-22.78
						l11.89,10.369c9.179,8.004,20.939,12.412,33.118,12.412h301.867c5.522,0,10-4.478,10-10V10
						C511.992,7.348,510.94,4.804,509.065,2.929z M136.002,482.001c0,5.513-4.486,10-10,10H30.005c-5.514,0-10-4.486-10-10V319.005
						c0-5.514,4.486-10,10-10h37.999V424.2c0,5.522,4.478,10,10,10s10-4.478,10-10V309.005h37.999c5.514,0,10,4.486,10,10V482.001z
						M166.045,80.739l79.954-21.424V96.37l-6.702,1.796c-2.563,0.687-4.746,2.362-6.072,4.659s-1.686,5.026-0.999,7.588
						c3.843,14.341-4.698,29.134-19.039,32.977c-2.565,0.688-4.752,2.366-6.077,4.668c-1.325,2.301-1.682,5.035-0.989,7.599
						l38.979,144.338h-20.07l-10.343-40.464c-0.329-1.288-0.905-2.475-1.676-3.507L166.045,80.739z M245.999,142.229v84.381
						l-18.239-67.535C235.379,155.141,241.614,149.255,245.999,142.229z M389.663,492H200.125V492c-7.345,0-14.438-2.658-19.974-7.485
						l-24.149-21.061V325.147l43.658-43.658l7.918,30.98c1.132,4.427,5.119,7.523,9.688,7.523l196.604,0.012c7.72,0,14,6.28,14,14
						c0,7.72-6.28,14-14,14H313.13c-5.522,0-10,4.478-10,10c0,5.522,4.478,10,10,10h132.04c7.72,0,14,6.28,14,14c0,7.72-6.28,14-14,14
						H313.13c-5.522,0-10,4.478-10,10c0,5.522,4.478,10,10,10h110.643c7.72,0,14,6.28,14,14c0,7.72-6.28,14-14,14H313.13
						c-5.522,0-10,4.478-10,10c0,5.522,4.478,10,10,10h76.533c7.72,0,14,6.28,14,14C403.662,485.72,397.382,492,389.663,492z
						M491.994,492h-0.001h-71.359c1.939-4.273,3.028-9.01,3.028-14s-1.089-9.727-3.028-14h3.139c18.747,0,33.999-15.252,33.999-33.999
						c0-5.468-1.305-10.635-3.609-15.217c14.396-3.954,25.005-17.149,25.005-32.782c0-7.584-2.498-14.595-6.711-20.255V235.007
						c0-5.522-4.478-10-10-10c-5.522,0-10,4.478-10,10v113.792c-2.35-0.515-4.787-0.795-7.289-0.795h-0.328
						c1.939-4.273,3.028-9.01,3.028-14c0-18.748-15.252-33.999-33.999-33.999h-16.075c17.069-7.32,29.057-24.286,29.057-44.005
						c0-26.389-21.468-47.858-47.857-47.858c-26.388,0-47.857,21.469-47.857,47.858c0,19.719,11.989,36.685,29.057,44.005h-54.663
						V109.863c17.864-3.893,31.96-17.988,35.852-35.853h75.221c3.892,17.865,17.988,31.96,35.852,35.853v31.09c0,5.522,4.478,10,10,10
						s10-4.478,10-10v-40.018c0-5.522-4.478-10-10-10c-14.847,0-26.924-12.079-26.924-26.925c0-5.522-4.478-10-10-10h-93.076
						c-5.522,0-10,4.478-10,10c0,14.847-12.078,26.925-26.924,26.925c-5.522,0-10,4.478-10,10v199.069H266V20.011L491.994,20V492z
						M378.996,283.858c-15.361,0-27.857-12.497-27.857-27.857s12.497-27.858,27.857-27.858S406.853,240.64,406.853,256
						S394.357,283.858,378.996,283.858z"></path>
                                </g>
                            </g></svg>
                    </div>
                    <span class="service-item-title">##Bestprice##</span>
                    <p>##Contentbestprice##</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 service_item">
                <div class="service-item site-bg-main-color">
                    <div class="service-item-icon">
                        <svg class="site-bg-svg-color" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 480.164 480.164"
                             style="enable-background:new 0 0 480.164 480.164;" xml:space="preserve"><g>
                                <g>
                                    <path d="M464.164,232.082c-3.141,0.102-6.352,1.938-7.594,5.027l-7.133,17.84l-17.719-64.973c-0.875-3.199-3.633-5.527-6.93-5.855
						c-3.359-0.359-6.461,1.422-7.945,4.383l-21.789,43.578h-12.249c11.185-22.096,17.194-46.638,17.194-72
						c0-88.223-71.773-160-160-160s-160,71.777-160,160c0,25.371,6.015,49.92,17.206,72.021l-1.042-0.021
						c-3.219,0.102-6.352,1.938-7.594,5.027l-7.133,17.84l-17.719-64.973c-0.875-3.199-3.633-5.527-6.93-5.855
						c-3.391-0.359-6.461,1.422-7.945,4.383l-21.789,43.578H0v16h32c3.031,0,5.797-1.711,7.156-4.422l14.633-29.273l18.492,67.801
						c0.906,3.316,3.828,5.684,7.266,5.883c0.148,0.008,0.305,0.012,0.453,0.012c3.258,0,6.211-1.98,7.43-5.027l13.945-34.863
						l5.367,0.108c4.106,6.168,8.52,12.16,13.508,17.767c0.219,0.859,0.586,1.691,1.094,2.453
						c26.258,39.383,27.789,47.543,32.344,71.77c0.844,4.449,1.773,9.391,2.953,15.078c2.036,9.923,7.845,18.002,15.669,23.056
						c-2.702,3.883-4.31,8.58-4.31,13.659c0,8.523,4.497,15.975,11.211,20.233c-1.985,3.492-3.211,7.471-3.211,11.767
						c0,8.523,4.497,15.975,11.211,20.233c-1.985,3.492-3.211,7.471-3.211,11.767c0,13.234,10.766,24,24,24h64
						c13.234,0,24-10.766,24-24c0-4.296-1.226-8.274-3.211-11.767c6.714-4.259,11.211-11.71,11.211-20.233
						c0-4.296-1.226-8.274-3.211-11.767c6.714-4.259,11.211-11.71,11.211-20.233c0-5.079-1.607-9.775-4.309-13.658
						c7.824-5.052,13.632-13.125,15.668-23.037c1.18-5.707,2.109-10.648,2.953-15.098c4.555-24.227,6.086-32.387,32.344-71.77
						c0.508-0.762,0.875-1.594,1.094-2.453c5.047-5.673,9.51-11.737,13.654-17.984H400c3.031,0,5.797-1.711,7.156-4.422l14.633-29.273
						l18.492,67.801c0.906,3.316,3.828,5.684,7.266,5.883c0.148,0.008,0.305,0.012,0.453,0.012c3.258,0,6.211-1.98,7.43-5.027
						l13.945-34.863l10.461,0.211l0.328-16L464.164,232.082z M272,464.082h-64c-4.414,0-8-3.59-8-8s3.586-8,8-8h64c4.414,0,8,3.59,8,8
						S276.414,464.082,272,464.082z M280,432.082h-8h-64h-8c-4.414,0-8-3.59-8-8s3.586-8,8-8h80c4.414,0,8,3.59,8,8
						S284.414,432.082,280,432.082z M288,400.082h-8h-80h-8c-4.414,0-8-3.59-8-8s3.586-8,8-8h96c4.414,0,8,3.59,8,8
						S292.414,400.082,288,400.082z M344.898,258.59c-1.305,1.387-2.047,3.164-2.164,4.992c-25.586,38.84-27.563,49.379-32.148,73.75
						c-0.82,4.359-1.734,9.207-2.898,14.824c-1.922,9.375-9.727,15.926-18.969,15.926H288h-14.468l21.176-120H304
						c13.234,0,24-10.766,24-24v-32h24c4.422,0,8-3.582,8-8v-40c0-13.234-10.766-24-24-24v-24c0-13.234-10.766-24-24-24h-8
						c0-13.234-10.766-24-24-24h-24c-4.422,0-8,3.582-8,8v184c0,4.418,3.578,8,8,8h22.468l-21.176,120h-34.583l-21.176-120H224
						c4.422,0,8-3.582,8-8v-184c0-4.418-3.578-8-8-8h-24c-13.234,0-24,10.766-24,24h-8c-13.234,0-24,10.766-24,24v24
						c-13.234,0-24,10.766-24,24v56c0,4.418,3.578,8,8,8h24v16c0,13.234,10.766,24,24,24h9.292l21.176,120H192h-0.719
						c-9.242,0-17.047-6.551-18.969-15.945c-1.164-5.598-2.078-10.445-2.898-14.805c-4.586-24.371-6.563-34.91-32.148-73.75
						c-0.117-1.828-0.859-3.605-2.164-4.992C109.883,231.879,96,196.898,96,160.082c0-79.402,64.602-144,144-144s144,64.598,144,144
						C384,196.898,370.117,231.879,344.898,258.59z M296,136.082v-24c0-4.418-3.578-8-8-8h-24v-40h16c4.414,0,8,3.59,8,8v8
						c0,4.418,3.578,8,8,8h16c4.414,0,8,3.59,8,8v32c0,4.418,3.578,8,8,8h8c4.414,0,8,3.59,8,8v32h-24h-32c-4.422,0-8,3.582-8,8v16h16
						v-8h16v32c0,4.41-3.586,8-8,8h-40v-112h16v16H296z M160,160.082c-4.422,0-8,3.582-8,8v24h-16v-48c0-4.41,3.586-8,8-8h8
						c4.422,0,8-3.582,8-8v-32c0-4.41,3.586-8,8-8h8v16h16v-24v-8c0-4.41,3.586-8,8-8h16v168h-40c-4.414,0-8-3.59-8-8v-24v-24h16v-16
						H160z"></path>
                                </g>
                            </g></svg>
                    </div>
                    <span class="service-item-title">##Experience##</span>
                    <p>##Contentexperience##</p>
                </div>
            </div>
        </div>
    </div>
</div>

{if 'Tour'|in_array:$checkAccessService}
    <!--Tours-sections-->
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`sections/TourSection.tpl"}
{/if}


{if 'Hotel'|in_array:$checkAccessService}
    <!--Hotels-sections-->
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`sections/HotelSection.tpl"}

{/if}
{else}
    lknjnllkj
{/if}





