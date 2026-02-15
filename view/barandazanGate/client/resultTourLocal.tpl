{load_presentation_object filename="resultTourLocal" assign="objResult"}
{load_presentation_object filename="reservationTour" assign="objReservationTour"}
{load_presentation_object filename="members" assign="objMember"}
{assign var="showTourToman" value = $objFunctions->isEnableSetting('toman')}
{if $showTourToman}
    {assign var="iranCurrency" value=$objFunctions->Xmlinformation('toman')}
{else}
    {assign var="iranCurrency" value=$objFunctions->Xmlinformation('Rial')}
{/if}

{$objMember->get()}
{assign var="showListTourAccess" value = json_decode($objResult->showListTour(),true)}

{assign var="param" value=['originCountryId' => $smarty.const.SEARCH_ORIGIN_COUNTRY, 'originCityId' => $smarty.const.SEARCH_ORIGIN_CITY, 'originRegionId' => $smarty.const.SEARCH_ORIGIN_REGION,
'destinationCountryId' => $smarty.const.SEARCH_DESTINATION_COUNTRY, 'destinationCityId' => $smarty.const.SEARCH_DESTINATION_CITY, 'destinationRegionId' => $smarty.const.SEARCH_DESTINATION_REGION,
'searchDate' => $smarty.const.SEARCH_DATE, 'tourTypeId' => $smarty.const.SEARCH_TOUR_TYPE , 'is_special' => $smarty.const.SEARCH_TOUR_SPECIAL]}
{$objResult->listTourBySearch($param)}
{assign var="checkAccess" value=$objFunctions->checkClientConfigurationAccess('b2b_show_access',$smarty.const.CLIENT_ID)}

{assign var="listCountryDept" value=$objResult->getAllCountry($smarty.const.SEARCH_TOUR_TYPE, 'dept')}
{assign var="listCountryReturn" value=$objResult->getAllCountry($smarty.const.SEARCH_TOUR_TYPE, 'return')}
{assign var="listCityDept" value=$objResult->getAllCity($smarty.const.SEARCH_ORIGIN_COUNTRY, $smarty.const.SEARCH_TOUR_TYPE, 'dept')}
{assign var="listCityReturn" value=$objResult->getAllCity($smarty.const.SEARCH_DESTINATION_COUNTRY, $smarty.const.SEARCH_TOUR_TYPE, 'return')}

{assign var="listRegionDept" value=$objResult->getAllRegion($smarty.const.SEARCH_ORIGIN_CITY, $smarty.const.SEARCH_TOUR_TYPE, 'dept')}
{assign var="listRegionReturn" value=$objResult->getAllRegion($smarty.const.SEARCH_DESTINATION_CITY, $smarty.const.SEARCH_TOUR_TYPE, 'return')}


{assign var="destinationCityName" value=$objReservationTour->FindCity($smarty.const.SEARCH_DESTINATION_CITY)}

{assign var="sortTour" value=$objResult->sortTour()}
{assign var="useType" value="showTourB2BAccess"}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentLoginRegister.tpl"}





<div class="loaderPublicForHotel"></div>
<div class="row">
    <!-- FILTERS -->
    <div class="col-lg-3 col-md-12 col-sm-12 col-12 col-padding-5 ">
        <div class="parent_sidebar">
            <div class="filterBox mb-0">
                <div class="filtertip_hotel tours_loc_maining site-bg-main-color site-bg-color-border-bottom ">
                    <p style="text-align: right; display: inline-block;" class="txt14">
                        {if $objResult->titlePageSearch neq ''}
                            ##Tours##
                            <span class="hotel-city-name">{$destinationCityName['name']}</span>
                        {else}
                            ##Tour##
                        {/if}
                    </p>
                    {if $objResult->error neq 'true' && $objResult->accessReservationTour() neq 'False'}
                        <span class="silence_span">
                    {$objResult->countTour} ##NumberToursFound##
                </span>
                    {/if}
                    <div onclick="showSearchBoxTour()" class="open-sidebar-tour ">##ChangeSearchType##</div>
                    {*<p class="txt14 reaserach_toursha">
                        <i class="mdi mdi-sync icon_reaserching__"></i>
                        <span class="hotel-city-name">جستجوی مجدد</span>
                    </p>*}
                </div>

                <div class="filtertip-searchbox filtertip_searchbox_35_">
                    <form class="search-wrapper" name="gds_tour" action="" method="post">
                        <input type="hidden" id="is_special" name="is_special" value="{$smarty.const.SEARCH_TOUR_SPECIAL}">

                        {*                        <div class="title-title-search alert alert-warning">*}
{*                    <span>*}
{*                    ##Showtoursbydate##*}
{*                    </span>*}
{*                            <span class="item-plus"> 120  <i>+ -</i></span>*}
{*                            <span>*}
{*                    ##Itisthedayofthesearchdate##*}
{*                    </span>*}
{*                        </div>*}


                        <div class="section_in_searchbox">
                            <div class="title-input-search">##Typetour##</div>
                            <div class="form-hotel-item form-hotel-item-searchBox ">
                                <div class="select">
                                    <input type="hidden" name="tourTypeSearch" id="tourTypeSearch"
                                           value="{$smarty.const.SEARCH_TOUR_TYPE}">
                                    <select name="tourType" id="tourType" class="select2"
                                            onchange="getTourCountriesByType('Origin' , 'dept')">
                                        <option value="all" selected="selected">##All##</option>
                                        {foreach $objResult->getAllTourType() as $tourType}
                                            <option value="{$tourType.id}"
                                                    {if $tourType.id eq $smarty.const.SEARCH_TOUR_TYPE}selected="selected"{/if}>
                                                {$tourType[$objFunctions->ChangeIndexNameByLanguage($smarty.const.SOFTWARE_LANG,'tour_type')]}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="section_in_searchbox">
                            <div class="title-input-search">##Origin##</div>
                            <div class="form-hotel-item form-hotel-item-searchBox ">
                                <div class="select">
                                    <select name="tourOriginCountry" id="tourOriginCountry" class="select2"
                                            onchange="getTourCities('Origin', '{$smarty.const.SEARCH_TOUR_TYPE}', 'dept')">
                                        <option value="all" selected="selected"> ##Origincountry## (##All##)</option>
                                        {foreach $listCountryDept as $country}
                                            <option value="{$country.id}"
                                                    {if $country.id eq $smarty.const.SEARCH_ORIGIN_COUNTRY}selected="selected"{/if}>
                                                {if $smarty.const.SOFTWARE_LANG != 'fa'} {$country.name_en} {else} {$country.name} {/if}
                                            </option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>

                            <div class="form-hotel-item form-hotel-item-searchBox ">
                                <div class="select">
                                    <select name="tourOriginCity" id="tourOriginCity" class="select2"
                                            onchange="getTourCountriesByType('Destination' , 'return')">
                                        <option value="all" selected="selected">##Origincity## (##All##)</option>
                                        {foreach $listCityDept as $city}
                                            <option value="{$city.id}"
                                                    {if $city.id eq $smarty.const.SEARCH_ORIGIN_CITY}selected="selected"{/if}>
                                                {if $smarty.const.SOFTWARE_LANG != 'fa'} {$city.name_en} {else} {$city.name} {/if}
                                            </option>
                                            {if $city.id eq $smarty.const.SEARCH_ORIGIN_CITY}
                                                {assign var="originCityName" value=$city.name}
                                            {/if}
                                        {/foreach}
                                    </select>
                                </div>
                            </div>

{*                            {if $smarty.const.SEARCH_ORIGIN_REGION neq ''}*}
{*                                <div class="form-hotel-item form-hotel-item-searchBox ">*}
{*                                    <div class="select">*}
{*                                        <select name="tourOriginRegion" id="tourOriginRegion" class="select2">*}
{*                                            <option value="all" selected="selected"> ##OrigincountryArea##</option>*}
{*                                            {foreach $listRegionDept as $region}*}
{*                                                <option value="{$region.id}"*}
{*                                                        {if $region.id eq $smarty.const.SEARCH_ORIGIN_REGION}selected="selected"{/if}>{$region.name}</option>*}
{*                                            {/foreach}*}
{*                                        </select>*}
{*                                    </div>*}
{*                                </div>*}
{*                            {/if}*}

                        </div>
                        <div class="section_in_searchbox">
                            <div class="title-input-search">##Destination##</div>
                            <div class="form-hotel-item form-hotel-item-searchBox ">
                                <div class="select">
                                    <select name="tourDestinationCountry" id="tourDestinationCountry" class="select2"
                                            onchange="getTourCities('Destination', '{$smarty.const.SEARCH_TOUR_TYPE}', 'return')">
                                        <option value="all" selected="selected"> ##Destinationcountry## (##All##)</option>
                                        {foreach $listCountryReturn as $country}
                                            <option value="{$country.id}"
                                                    {if $country.id eq $smarty.const.SEARCH_DESTINATION_COUNTRY}selected="selected"{/if}>
                                                {if $smarty.const.SOFTWARE_LANG != 'fa'} {$country.name_en} {else} {$country.name} {/if}
                                            </option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>

                            <div class="form-hotel-item form-hotel-item-searchBox ">
                                <div class="select">
                                    <select name="tourDestinationCity" id="tourDestinationCity" class="select2"
                                            onchange="getTourRegion('Destination', '{$smarty.const.SEARCH_TOUR_TYPE}', 'return')">
                                        <option value="all" selected="selected"> ##Destinationcity## (##All##)</option>
                                        {foreach $listCityReturn as $city}
                                            <option value="{$city.id}"
                                                    {if $city.id eq $smarty.const.SEARCH_DESTINATION_CITY}selected="selected"{/if}>
                                                {if $smarty.const.SOFTWARE_LANG != 'fa'} {$city.name_en} {else} {$city.name} {/if}
                                            </option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>

                            {if $smarty.const.SEARCH_DESTINATION_REGION neq ''}
                                <div class="form-hotel-item form-hotel-item-searchBox ">
                                    <div class="select">
                                        <select name="tourDestinationRegion" id="tourDestinationRegion" class="select2">
                                            <option value="all" selected="selected">##DestinationArea##</option>
                                            {foreach $listRegionReturn as $region}
                                                <option value="{$region.id}"
                                                        {if $region.id eq $smarty.const.SEARCH_DESTINATION_REGION}selected="selected"{/if}>{$region.name}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                            {/if}


                            {assign var="classNameStartDate" value="shamsiDeptCalendar"}
                            {if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || $smarty.const.SEARCH_DATE|substr:0:4 gt 2000}
                                {$classNameStartDate="gregorianDeptCalendar"}
                            {/if}

                        </div>
                        <div class="section_in_searchbox">
                            <div class="title-input-search">##Wentdate##</div>
                            <div class="form-hotel-item form-hotel-item-searchBox ">

                                <div class="select">
                                    {assign var="year_select" value=$objFunctions->DateFunctionWithLanguage('Y',strtotime('today'))}
                                    {assign var="month_select" value=$objFunctions->DateFunctionWithLanguage('m',strtotime('today'))}
                                    {*{$classNameStartDate}*}
                                    <select data-placeholder="##Wentdate##" id="tourStartDate"
                                            name="startDate" class="select2">
                                        <option value="">انتخاب کنید...</option>
                                        <option value="all" selected="selected">##All##</option>
                                        {assign var="month_select_counter" value=$month_select}
                                        {assign var="nextYearShowCheck" value=0}
                                        {assign var="i" value=1}

                                        {for $i=0 to 3}
                                            {if $month_select_counter > 12}
                                                {assign var="thisyear" value=strtotime('today')+(60 * 60 * 24 * 365)}
                                                {assign var='nextYearShowCheck' value=$nextYearShowCheck+1}
                                            {else}
                                                {assign var="thisyear" value=strtotime('today')}
                                            {/if}
                                            {if $nextYearShowCheck == 0}
                                                {assign var="thisMonth" value=$month_select_counter}

                                            {else}
                                                {assign var="thisMonth" value=$nextYearShowCheck}

                                            {/if}
                                            {assign var="year_select" value=$objFunctions->DateFunctionWithLanguage('Y',$thisyear)}
                                            {assign var="thisMonthEdited" value=sprintf( "%02d", $thisMonth )}
                                            {if $smarty.const.SOFTWARE_LANG neq 'fa'}

                                                {assign var="CalenderMonthName" value=date("F", mktime(0, 0, 0, $thisMonth, 10))}
                                            {else}
                                                {assign var="CalenderMonthName" value=$objFunctions->CalenderMonthName($thisMonth)}
                                            {/if}
                                            <option {if  $smarty.const.SEARCH_DATE|substr:5:2 == $thisMonthEdited}selected{/if}
                                                    value="{$year_select}-{$thisMonthEdited}-01"> {$CalenderMonthName} - {$year_select}</option>
                                            {*                                        {assign var=$i value=$i+1}*}
                                            {assign var='month_select_counter' value=$month_select_counter+1}
                                        {/for}

                                    </select>


                                </div>
                            </div>
                        </div>




                        <div class="form-hotel-item  form-hotel-item-searchBox-btn">
                            <div class="input">
                                <button class="site-bg-main-color" type="button" id="searchHotelLocal"
                                        onclick="submitSearchTourLocal(true,$(this))">##Search##
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <div class="filterBox mb-0">

                <div class="filtertip-searchbox filtertip_searchbox_35_">
                    <span class="filter-title"> ##Searchname## / ##Typetour##</span>
                    <div class="filter-content padb0">
                        <input type="text" class="form-hotel-item-searchHotelName" placeholder="##Name## /##Typetour## "
                               id="inputSearchTour">
                        <i class="fa fa-search form-hotel-item-searchHotelName-i site-main-text-color"></i>
                    </div>
                </div>


                <div class="filtertip-searchbox filtertip_searchbox_35_">
                    <span class="filter-title"> ##Price## ({$iranCurrency})</span>
                    <div class="filter-content padb0">
                        <div class="filter-price-text">
                            <span> <i></i> {$iranCurrency}</span>
                            <span> <i></i> {$iranCurrency}</span>
                        </div>
                        <div id="slider-range"></div>
                    </div>
                </div>

                <div class="filtertip-searchbox filtertip_searchbox_35_ ">
                    <span class="filter-title">##Car##</span>
                    <div class="filter-content padb10 padt10">

                        <p class="raste-item">
                            <input type="checkbox" class="FilterHoteltype Show_all" id="check_list_all" name="check_list_all"
                                   value="all" checked>
                            <label class="FilterHoteltypeName site-main-text-color-a" for="check_list_all">##All##</label>
                        </p>
                        {foreach $objResult->listAirline as $k=>$airline}
                            <p class="raste-item">
                                <input type="checkbox" class="FilterHoteltype Show_by_filters" id="check_list{$k}"
                                       name="heck_list{$k}" value="{$airline}">
                                <label class="FilterHoteltypeName site-main-text-color-a"
                                       for="check_list{$k}">{$airline}</label>
                            </p>
                        {/foreach}
                    </div>

                </div>

                <div>

                    {if !empty($objResult->listSuggestedTours)}
                        <div class="col-md-12 BaseTourBox">
                            <div class="TourTitreDiv ">
                        <span>##SuggestedToursFrom##
                        <span class="text-primary">{$originCityName}</span></span>
                            </div>

                            {foreach $objResult->listSuggestedTours as $suggestionTour}
                                {assign var="slug" value=str_replace(' ', '-', $suggestionTour['tour_name_en'])}
                                <div class="col-md-12 border-bottom font-13 mb-2">

                                    <a class="w-100"
                                       href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$suggestionTour['id']}/{$slug}">
                                        <div class="col-md-12 text-center">
                                            {if $smarty.const.SOFTWARE_LANG eq 'en'}
                                                {$suggestionTour['tour_name_en']}
                                            {else}
                                                {$suggestionTour['tour_name']}
                                            {/if}

                                        </div>
                                    </a>
                                </div>
                            {/foreach}

                        </div>
                    {/if}
                </div>

                {*<div class="filtertip-searchbox mart20">
                    <span class="filter-title">محله</span>
                    <div class="filter-content padb10 padt10">

                        <p class="raste-item">
                            <input type="checkbox" class="FilterHoteltype Show_all" id="check_list_Region_all" name="check_list_Region_all" value="all" checked>
                            <label class="FilterHoteltypeName site-main-text-color-a" for="check_list_Region_all">همه</label>
                        </p>
                        {foreach $objResult->listRegion as $k=>$region}
                        <p class="raste-item">
                            <input type="checkbox" class="FilterHoteltype Show_by_filters" id="check_list_Region{$k}" name="check_list_Region{$k}" value="{$region}">
                            <label class="FilterHoteltypeName site-main-text-color-a" for="check_list_Region{$k}">{$region}</label>
                        </p>
                        {/foreach}
                    </div>
                </div>*}

            </div>


            <div class="articles-list d-none">

                <h6>##RelatedArticles##</h6>
                <ul></ul>

            </div>
        </div>
    </div>
    <!-- LIST CONTENT-->
    <div class="col-lg-9 col-md-12 col-sm-12 col-12 col-padding-5" id="result">
            {if $objResult->error eq 'true'}
                {*<div class="userProfileInfo-messge">
                    <div class="messge-login BoxErrorSearch">
                        <div style="float: left;"><i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i></div>
                        <div class="TextBoxErrorSearch">{$objResult->errorMessage}</div>
                    </div>
                </div>*}
                {load_presentation_object filename="fullCapacity" assign="objFullCapacity"}
                {assign var="get_info" value=$objFullCapacity->getFullCapacitySite(1)}
                <div id='show_offline_request' >
                    <div class='fullCapacity_div'>
                        {if $get_info['pic_url']!=''}
                            <img src='{$get_info['pic_url']}' alt='{$get_info['pic_title']}'>
                        {else}
                            <img src='assets/images/fullCapacity.png' alt='fullCapacity'>
                        {/if}
                        <h2>##Noresult##</h2>
                    </div>
                </div>
            {elseif $objResult->accessReservationTour() eq 'False'}
                <div class="userProfileInfo-messge">
                    <div class="messge-login BoxErrorSearch">
                        <div style="float: left;"><i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i></div>
                        <div class="TextBoxErrorSearch">
                            ##Gosupport##
                        </div>
                    </div>
                </div>
            {else}
                <div class="sort-by-section clearfix box">
                    <div class="info-login">
                        <div class="head-info-login">
                    <span class="site-bg-main-color site-bg-color-border-right-b">
                                   ##Sortby##
                    </span>
                        </div>
                        <div class="form-sort hotel-sort">

                            {*<div class="s-u-form-input-number form-item form-item-sort">
                                <div class="select">
                                    <select class="select2" id="agencyRateSortSelect" tabindex="-1" aria-hidden="true">
                                        <option disabled="" selected="" hidden="">##Pointagency##</option>
                                        <option value="asc">##PointagencyLTM##</option>
                                        <option value="desc">##PointagencyMTL##</option>
                                    </select>
                                </div>
                            </div>*}
                            <div class="form-sort hotel-sort hotel-sort-hotel">
                                <div class="s-u-form-input-number col-md-6">
                                    <div class="select">
                                        <select class="select2" id="starSortSelect" tabindex="-1"
                                                aria-hidden="true" onchange="selectSortTour(this);">
                                            <option disabled="" selected="" hidden="">##Starhotel##</option>
                                            <option value="min_star_code"> ##LTM##</option>
                                            <option value="max_star_code"> ##MTL##</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="s-u-form-input-number col-md-6 pr-0">
                                    <div class="select">
                                        <select class="select2" id="priceSortSelect" tabindex="-1"
                                                aria-hidden="true" onchange="selectSortTour(this);">
                                            <option disabled="" selected="" hidden="">##Price##</option>
                                            <option value="min_room_price">##LTM##</option>
                                            <option value="max_room_price"> ##MTL##</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {*<div class="s-u-form-input-number form-item form-item-sort countTiket">*}
                            {*<p>##Result##:<var>{$objResult->countTour}</var><kbd>##Tour##</kbd></p>*}
                            {*</div>*}
                            <div class="s-u-form-input-number form-item form-item-sort list_grid">

                                <a id="view_list_a" data-toggle="tooltip" data-placement="top" title="##List##"
                                   class="view_list_grid active_g_list_a"><i style="font-size: 40px;"
                                                                             class="zmdi zmdi-view-list-alt site-main-text-color"></i></a>
                                <a id="view_grid_a" data-toggle="tooltip" data-placement="top" title="##Network##"
                                   class="view_list_grid"><i style="font-size: 35px;"
                                                             class="zmdi zmdi-view-module site-main-text-color"></i></a>


                            </div>
                        </div>
                    </div>
                </div>
                {if $smarty.const.SEARCH_ORIGIN_COUNTRY eq '1'}
                    {$objFunctions->showConfigurationContents('local_tour_search_advertise','<div class="advertises">','</div>','<div class="advertise-item">','</div>')}
                {else}
                    {$objFunctions->showConfigurationContents('external_tour_search_advertise','<div class="advertises">','</div>','<div class="advertise-item">','</div>')}
                {/if}





                <div data-name="tour-loading" class="align-items-center my-4 d-flex flex-wrap gap-10 justify-content-center w-100">
                    <div class="loader-spinner"></div>
                </div>


<div data-name="tour-result" class='d-none flex-wrap w-100'>


                <div id="tourResult" class="{if !$showListTourAccess.show_result}d-none{/if} d-none">

                    {foreach $objResult->listTour as $tour}
                        {*{assign var="isShowTour" value="yes"}
                        {if $smarty.const.SEARCH_TOUR_TYPE eq 'lastMinuteTour' && $objResult->isLastMinuteTour($tour['start_date'], $tour['start_time_last_minute_tour']) eq 'no'}
                            {$isShowTour="no"}
                        {/if}*}

                        {assign var=tourTypeIdArray value=$tour['tour_type_id']|json_decode:true}
                        {assign var=tourNameEn value=$tour['tour_name_en']|replace:' ':'-'}
                        <div class="hotelResultItem">
                            <div id="a1" class="hotel-result-item  carItem height240 p-0 normal-loop-box-style"
                                 data-airline="{$tour['typeVehicleName']}"
                                 data-tourname="{$tour['tour_name']}"
                                 data-priority="{$tour['priority']}"
                                 data-tourtype="{$tour['tour_type']}"
                                 data-price="{$tour['min_price_r']}"
                                 data-special="{if $tour['is_special'] eq 'yes'}1{else}0{/if}"
                                 data-star="{$tour['rater']['average']}"
                                 data-region="
                     {foreach $tour['arrayRegions'] as $region}
                        {$region}-
                     {/foreach}
                     ">
                                <input type="hidden" id="agencyRate" name="agencyRate" value="{$tour['infoAgency']['rate']}">
                                <input type="hidden" id="tourPrice" name="tourPrice" value="{$tour['min_price_r']}">
                                <input type="hidden" id="priority" name="priority" value="{$tour['priority']}">

                                {if $tour['is_special'] neq ''}
                                    <div class="ribbon-special-hotel">
                                        <span><i>##Tour## ##Special## </i></span>
                                    </div>
                                {/if}

                                {if $tour['isLastMinuteTour'] eq 'yes'}
                                    <div class="ribbon-hotel site-bg-color-dock-border-top">
                                        <span class="site-bg-main-color"><i> ##LastMinuteTour## </i></span>
                                    </div>
                                {/if}

                                <div class="col-md-4 tasvir_tour nopad">
                                    {if $tour['is_api'] eq true}
                                    <div class="hotel-result-item-image  site-bg-main-color-hover height240">
                                        <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$tour['id']}/{$tourNameEn}"
                                        >
                                            <img src="{$tour['tour_pic']}"
                                                 alt="{$tour['tour_name']}">
                                        </a>
                                    </div>
                                    {else}
                                    <div class="hotel-result-item-image  site-bg-main-color-hover height240">
                                        <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$tour['id']}/{$tourNameEn}"
                                           >
                                            <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$tour['tour_pic']}"
                                                 alt="{$tour['tour_name']}">
                                        </a>
                                    </div>
                                    {/if}
                                </div>

                                <div class="col-md-8 res_tour_matn nopad">
                                    <div class="hotel-result-item-content tour-result-item-content height240">
                                        <div class="col-md-8">
                                            <a class="tour_name_title" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$tour['id']}/{$tourNameEn}"
                                               >
                                                <b class="hotel-result-item-name">
                                                    {if $smarty.const.SOFTWARE_LANG eq 'fa'} {$tour['tour_name']} {else} {$tour['tour_name_en']} {/if}
                                                        <i style='color:white'>{if $tour['is_api'] eq true} api{/if}</i>
                                                    </b>
                                            </a>
                                            <span class="hotel-result-item-content-location">
                                        <i class="fa fa-map-marker site-main-text-color "></i>
                                        <span>

                                            ##Origin##:
                                            {if 1|in_array:$tourTypeIdArray}
                                                {if $smarty.const.SOFTWARE_LANG != 'fa'} {$tour['origin_city_name_en']} {else} {$tour['origin_city_name']} {/if} - {$tour['origin_region_name']}
                                            {else}
                                                {if $smarty.const.SOFTWARE_LANG != 'fa'} {$tour['origin_country_name_en']} {else} {$tour['origin_country_name']} {/if} - {if $smarty.const.SOFTWARE_LANG != 'fa'} {$tour['origin_city_name_en']} {else} {$tour['origin_city_name']} {/if}
                                            {/if}
                                        </span>
                                    </span>
                                            <span class="hotel-result-item-content-location  ">
                                    <i class="fa fa-map-marker site-main-text-color"></i>
                                        <span>

                                            ##Destination##:
                                            {if 1|in_array:$tourTypeIdArray}
                                                {foreach $tour['infoTourRout'] as $k=>$city}
                                                    {if $city['tour_title'] eq 'dept'}
                                                        {if $k neq 0} / {/if}
                                                        {if $smarty.const.SOFTWARE_LANG != 'fa'} {$tour['destination_city_name_en']} {else} {$city['destination_city_name']} {/if} - {$city['destination_region_name']}
                                                    {/if}
                                                {/foreach}
                                            {else}
                                                {foreach $tour['infoTourRout'] as $k=>$city}
                                                    {if $city['tour_title'] eq 'dept' && $city['night'] gt 0}
                                                        {if $k neq 0} / {/if}
                                                        {if $smarty.const.SOFTWARE_LANG != 'fa'} {$tour['destination_country_name_en']} {else} {$city['destination_country_name']} {/if} - {if $smarty.const.SOFTWARE_LANG != 'fa'} {$tour['destination_city_name_en']} {else} {$city['destination_city_name']} {/if}
                                                    {/if}
                                                {/foreach}
                                            {/if}
                                        </span>
                                    </span>

                                            {*if $tour['infoHotel']['star_code'] gt 0}
                                            <span class="car-result-item ravis-icon-hotel-front-view width100">
                                                <span class="hotel-star">
                                                    {for $s=1 to $tour['infoHotel']['star_code']}
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    {/for}
                                                    {for $ss=$s to 5}
                                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                                    {/for}
                                                </span>
                                            </span>
                                            {/if*}

                                            {if 1|in_array:$tourTypeIdArray}
                                                <span class="car-result-item  ">
                                            <i class="fa fa-moon-o site-main-text-color "></i>
                                            <span>{$tour['day']} ##Day## </span>
                                        </span>
                                            {else}
                                                <span class="car-result-item   ">
                                            <i class="fa fa-moon-o site-main-text-color"></i>
                                                    {*<span>{$tour['night']} ##Night## {$tour['day']} ##Day## </span>*}
                                                    <span>

                                                {$tour['night']} ##Night## </span>
                                        </span>
                                            {/if}


                                            {foreach $tour['arrayTypeVehicle'] as $typeVehicle}

                                                {if $typeVehicle['type_vehicle_name'] eq 'هواپیما'}
                                                    <span class="car-result-item">
                                                <i class=" site-main-text-color fa fa fa-plane"></i>
                                                <span>##Flight## {$typeVehicle['tour_title']}
                                                    : {$typeVehicle['airline_name']}</span>
                                            </span>
                                                {else}
                                                    <span class="car-result-item  ">
                                                <i class="fa fa-bus site-main-text-color"></i>
                                                <span>{$typeVehicle['tour_title']}
                                                    : {$typeVehicle['airline_name']}</span>
                                            </span>
                                                {/if}

                                            {/foreach}


                                        </div>
                                        <div style="padding: 15px 8px;" class="col-md-4 logoaj_em_">
                                            {*<span style="text-align: center;" class="car-result-item width100">
                                                <span style="padding: 0 !important;"> آژانس {$tour['infoAgency']['name']}</span>
                                            </span>
                                            <div class=" logo-ajans">
                                                <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$tour['infoAgency']['logo']}"
                                                     alt="{$tour['infoAgency']['name']}">
                                            </div>*}
                                            {if $tour['infoAgency']['rate'] gt 0}
                                                <div class="star-text"
                                                     style="padding: 10px 0;text-align: center;font-size: 12px;">##Pointagency##
                                                    <span class="site-main-text-color"
                                                          id="sniper_average">{$tour['infoAgency']['rate']}</span>##From##
                                                    <span class="site-main-text-color">5</span>
                                                </div>
                                            {/if}
                                        </div>
                                        <div class="col-md-12 rows-btn--">

                                    <span class="tour-result-item-right right-start-price--">
                                        <a class=""
                                           href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$tour['id']}/{$tourNameEn}"
                                          >
                                            <div class='d-flex flex-wrap gap-5 w-100'>
                                                {if $objFunctions->isEnableSetting('eachPerson')}
                                                    <span>##StartpriceEachPerson##</span>
                                                {else}
                                                    <span>##Startprice##</span>
                                                {/if}



{*                                                {assign var="price" value=$objResult->calculateDiscountedPrices($tour['discount_type'], $tour['discount'], $tour['min_price_r'])}*}

                                                {if !empty($tour['discount']['adult_amount']) && $tour['discount']['adult_amount'] neq ''}
                                                    <span class="strikePrice" style="text-decoration: line-through; ">
                                                        <span class="font-15 text-muted d-flex flex-wrap gap-5">

                                                            {$tour['min_price_r']|number_format:0:".":","}
                                                            {$iranCurrency}
                                                        </span>
                                                    </span>
                                                    <div class='align-items-center d-flex flex-wrap gap-5 w-100'>
                                                        <span class='bg-light border border-50 font-12 p-1 px-2 rounded'>
                                                            ##SpecialPrice##
                                                        </span>
                                                        <div class='d-flex flex-wrap font-15 font-weight-bold gap-5 text-dark'>
                                                            <span class="font-15 ">


                                                                {if $showTourToman}
                                                                    {($tour['discount']['after_discount'] / 10)|number_format:0:".":","}
                                                                {else}
                                                                    {$tour['discount']['after_discount']|number_format:0:".":","}
                                                                {/if}

                                                                {$iranCurrency}

                                                                     {if $tour['min_price_a'] gt 0}
                                                                         +
                                                                         <b class="pice-tour ">{$objFunctions->numberFormat($tour['min_price_a'])}</b>
                                                                         {$tour['currency_title_fa']}

                                                                     {/if}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    {else}
                                                    <div class="d-flex flex-wrap font-15 font-weight-bold gap-5 text-dark">
                                                     <div class='font-15 '>
                                                    <b class="pice-tour ">


                                                        {if $showTourToman}
                                                            {($tour['min_price_r'])|number_format:0:".":","}
                                                        {else}
                                                            {$tour['min_price_r']|number_format:0:".":","}
                                                        {/if}
                                                     </b>
                                                         {$iranCurrency}



                                                         {if $tour['min_price_a'] gt 0}
                                                             +
                                                             <b class="pice-tour 1">{$objFunctions->numberFormat($tour['min_price_a'])}</b>
                                                             {$tour['currency_title_fa']}

                                                         {/if}
                                                </div>
                                                </div>

                                                {/if}



                                            </div>
                                        </a>


                                        {if $objSession->IsLogin()}
                                            {assign var="counterId" value=$objFunctions->getCounterTypeId($smarty.session.userId)}
                                            {if $tour['tour_title'] == 'Dept' && $tour['destination_country_id'] != '1'}
                                                {assign var="service" value="PrivateLocalTour"}
                                            {else}
                                                {assign var="service" value="PrivatePortalTour"}
                                            {/if}

                                            {assign var="paramPointClub" value=[
                                            'service' => $service,
                                            'baseCompany' => 'all',
                                            'company' => 'all',
                                            'counterId' => $counterId,
                                            'price' => $price['price']]}

                                            {assign var="pointClub" value=$objFunctions->CalculatePoint($paramPointClub)}
                                            {if $pointClub gt 0}
                                                <span class="text_div_more_tour site-main-text-color iranM txt12">##Yourpurchasepoints## : {$pointClub}
                                                    ##Point##</span>
                                            {/if}
                                        {/if}

                                    </span>
                                            <span class="tour-result-item-left">
                                        <a style="position: relative"
                                           onclick='loadingToggle($(this))'
                                           href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$tour['id_same']}/{$tourNameEn}"
                                           class="bookbtn mt1 site-bg-main-color site-main-button-color-hover ml-0">  ##ShowReservation##</a>
                                    </span>

                                        </div>

                                    </div>


                                </div>
                            </div>


                        </div>
                    {/foreach}

                </div>
</div>
            {/if}

        {assign var="moduleData" value=[
        'service'=>'Tour',
        'origin'=>$smarty.const.SEARCH_ORIGIN_CITY,
        'destination'=>$smarty.const.SEARCH_DESTINATION_CITY
        ]}

        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`textSearchResults.tpl"
        moduleData=$moduleData}
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`faqs.tpl"
        moduleData=$moduleData}
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`articles.tpl"
        moduleData=$moduleData}



    </div>
</div>

<script src="assets/js/script.js"></script>


{if $showLogin eq true}
{literal}
    <script>
        $(document).ready(function () {
            console.log('login');
            $("#login-popup").trigger("click");
        });
    </script>
{/literal}
{/if}

{literal}

<script>
    $(document).ready(async function() {

       await setTimeout(function() {
        $('.loaderPublicForHotel').fadeOut(500);
        sortTourList('{/literal}{$sortTour}{literal}');
        $('#result').show();

      }, 300);



      $('[data-toggle="tooltip"]').tooltip();
    });
</script>
    <script>
        $(document).ready(function () {


            $('.view_list_grid').click(function () {

                $('.view_list_grid').removeClass('active_g_list_a');
                $(this).addClass('active_g_list_a');
            });


            $('#view_grid_a').click(function () {

                $('#tourResult').addClass('activing_grid');

                $('.hotel-result-item .tasvir_tour').removeClass('col-md-4');
                $('.hotel-result-item .res_tour_matn').removeClass('col-md-8');


            });


            $('#view_list_a').click(function () {

                $('#tourResult').removeClass('activing_grid');

                $('.hotel-result-item .tasvir_tour').addClass('col-md-4');
                $('.hotel-result-item .res_tour_matn').addClass('col-md-8');

            });

            if ($(window).width() < 767) {

                $('#tourResult').addClass('activing_grid');

                $('.hotel-result-item .tasvir_tour').removeClass('col-md-4');
                $('.hotel-result-item .res_tour_matn').removeClass('col-md-8');
            }

        });

        $(window).resize(function () {

            if ($(window).width() < 767) {

                $('#tourResult').addClass('activing_grid');

                $('.hotel-result-item .tasvir_tour').removeClass('col-md-4');
                $('.hotel-result-item .res_tour_matn').removeClass('col-md-8');
            }

            else {
                $('#tourResult').removeClass('activing_grid');

                $('.hotel-result-item .tasvir_tour').addClass('col-md-4');
                $('.hotel-result-item .res_tour_matn').addClass('col-md-8');

            }
        })


    </script>
<script>
    $(function () {
        $('.event_star').voteStar({
            callback: function (starObj, starNum) {
                var hotels = $(".hotel-result-item");
                hotels.hide().filter(function () {
                    var star = parseInt($(this).data("star"), 10);
                    return star <= starNum;
                }).show();

            }
        })
    })

    $(function () {
        $("#slider-range").slider({
            range: true,
            min: {/literal}'{$objResult->minPrice}'{literal},
            max: {/literal}'{$objResult->maxPrice}'{literal},
            step: 500000,
            animate: false,
            values: [{/literal}{$objResult->minPrice}{literal}, {/literal}{$objResult->maxPrice}{literal}],
            slide: function (event, ui) {

                var minRange = ui.values[0];
                var maxRange = ui.values[1];

                $(".filter-price-text span:nth-child(2) i").html(addCommas(minRange));
                $(".filter-price-text span:nth-child(1) i").html(addCommas(maxRange));

                var tours = $(".hotel-result-item");
                tours.hide().filter(function () {
                    var price = parseInt($(this).data("price"), 10);
                    return price >= minRange && price <= maxRange;
                }).show();

            }
        });

        $(".filter-price-text span:nth-child(2) i").html(addCommas({/literal}{$objResult->minPrice}{literal}));
        $(".filter-price-text span:nth-child(1) i").html(addCommas({/literal}{$objResult->maxPrice}{literal}));
    });
</script>
    <script type="text/javascript">

        $(document).ready(function () {


            var tours = $(".hotel-result-item");

            $(".Show_all").on("click", function () {

                tours.show();
                var check = $(this).prop('checked');


                if (check == true) {
                    $("input:checkbox").each(function () {
                        $(this).prop("checked", true);
                    });
                }
                else {
                    $('#check_list_all').prop("checked", true);
                }

            });

            $(".Show_by_filters").on("click", function () {

                $('#check_list_all').prop("checked", false);
                tours.hide();

                $("input:checkbox").each(function () {

                    if ($(this).prop('checked') == true) {

                        var check = $(this).val();
                        tours.filter(function () {
                            var airline = $(this).data("airline");
                            //return $.trim(airline) == $.trim(check);
                            var search = airline.indexOf(check);
                            if (search > -1) {
                                return airline;
                            }
                        }).show();

                    }

                });

            });


            /*$(".Show_all").on("click", function () {
                tours.show();
                $('input[type="checkbox"]').change(function () {
                    $("input:checkbox").each(function () {
                        $(this).prop("checked", false);
                    });
                    $('#check_list_Region_all').prop("checked", true);
                });
            });
            $(".Show_by_filters").on("click", function () {

                $('#check_list_Region_all').prop("checked", false);
                tours.hide();

                $("input:checkbox").each(function () {

                    if ($(this).prop('checked') == true) {

                        var Check = $(this).val();
                        tours.filter(function () {
                            var region = $(this).data("region");
                            //return region == Check;
                            var search = region.indexOf(Check);
                            if (search > -1) {
                                return region;
                            }
                        }).show();

                    }

                });

            });*/


            $("#inputSearchTour").keyup(function () {

                var inputSearchTour = $("#inputSearchTour").val();

                tours.hide().filter(function () {
                    var tourName = $(this).data("tourname");
                    var tourType = $(this).data("tourtype");

                    var searchTourName = tourName.indexOf(inputSearchTour);
                    if (searchTourName > -1) {
                        return tourName;
                    }

                    var searchTourType = tourType.indexOf(inputSearchTour);
                    if (searchTourType > -1) {
                        return searchTourType;
                    }

                }).show();

            });


        });


    </script>
{/literal}

<script>
    {*loadArticles('Tour', '{$smarty.const.SEARCH_DESTINATION_CITY}')*}
</script>