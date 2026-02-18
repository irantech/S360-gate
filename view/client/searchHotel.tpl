
{load_presentation_object filename="searchHotel" assign="objsearch"}
{load_presentation_object filename="detailHotel" assign="objHotel"}
{load_presentation_object filename="reservationHotel" assign="objReservationHotel"}
{load_presentation_object filename="currencyEquivalent" assign="objCurrency"}
{assign var="which_sort" value=$objReservationHotel->activeOrderHotel()}

{if $smarty.const.GDS_SWITCH eq 'searchHotel'}
    {assign var='all_cities' value=$objsearch->Allcity()}
    {assign var="total_cities" value=$all_cities|count}
    {assign var="city_index" value=0}
    {assign var="obj_city" value=[]}
    {assign var="obj_cities" value=''}
    {foreach $all_cities as $key => $city}
        {$city_index = $key + 1}
        {if $smarty.const.SOFTWARE_LANG eq 'fa'}
            {assign var="display_name" value=$city.city_name}
        {else}
            {assign var="display_name" value=$city.city_name_en}
        {/if}
        {assign var="html" value="<div class='d-flex justify-content-between'><span>{$display_name}</span></div>"}
        {assign var="popular" value='<span class="badge border text-white bg-dark">پر تردد</span>'}
        {if $city.position neq NULL}
            {$html = "<div class='d-flex justify-content-between'><span>{$display_name}</span> {$popular}</div>"}
        {/if}
        {assign var="selected" value=''}
        {if $city.id eq $smarty.get.city}
            {$selected = 'selected'}
        {/if}
        {$obj_city[] = ['id'=>$city.id,'text'=>$display_name,'html'=>$html,'selected'=>$selected]}
    {/foreach}
    {$obj_cities = $obj_city|json_encode:256}
{literal}
    <script type="text/javascript">
        var all_cities = {/literal}{$obj_cities}{literal};
    </script>
{/literal}
{/if}

{if $smarty.get.type neq '' && $smarty.get.type eq 'new'}
    {assign var="search_end_date" value=$objsearch->computingEndDate($smarty.get.startDate,$smarty.get.nights)}
    {assign var="paramSearch" value=[
    'flag'=>'searchHotel',
    'city_id'=>$smarty.get.city,
    'with_foreign'=>true,
    'startDate'=>$smarty.get.startDate,
    'nights'=>$smarty.get.nights,
    'rooms'=>$smarty.get.rooms,
    'hotelType'=>'all',
    'endDate'=>$search_end_date,
    'star'=>'all',
    'name'=>null,
    'hotelName'=>null,
    'source'=>'',
    'type_residence'=>$smarty.get.type_residence,
'lang'=>$smarty.const.SOFTWARE_LANG]}
{else}
    {assign var="search_end_date" value=$objsearch->computingEndDate($smarty.const.SEARCH_START_DATE, $smarty.const.SEARCH_NIGHT)}
    {assign var="paramSearch" value=[
    'flag'=>'searchHotel',
    'city_id'=>$smarty.const.SEARCH_CITY,
    'startDate'=>$smarty.const.SEARCH_START_DATE,
    'nights'=>$smarty.const.SEARCH_NIGHT,
    'source'=>$smarty.const.SEARCH_HOTEL_SOURCE,
    'hotelType'=>$smarty.const.SEARCH_HOTEL_TYPE,
    'star'=>$smarty.const.SEARCH_STAR,
    'name'=>$smarty.const.SEARCH_HOTEL_NAME,
    'endDate'=>$search_end_date,
    'hotelName'=>$smarty.const.SEARCH_HOTEL_NAME,
    'rooms'=>$smarty.get.rooms,
    'type_residence'=>$smarty.get.type_residence,
'lang'=>$smarty.const.SOFTWARE_LANG]}
{/if}
{assign var="City" value=$objsearch->getCity($paramSearch.city_id)}
{$objsearch->validateSearch($paramSearch)}

<code style="display:none;">{$paramSearch|json_encode:256}</code>
<code style="display:none;">{$smarty.const.CLIENT_NAME} {$smarty.const.CLIENT_ID} {$smarty.const.SEARCH_HOTEL_TYPE}</code>
<div class="progress-container">
    <div class="progress-bar site-bg-main-color" id="myBarHead"></div>
</div>

<input type='hidden' name='sort_hotel_type' id='sort_hotel_type' value='{$which_sort[0]['title_en']}'>
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`hotelTimeoutModal.tpl"}
<div id="appHotel" class="row minW-100">
    <div class="col-lg-3 col-md-12  col-12 col-padding-5 ">
        <div class="parent_sidebar">
            <!-- Change Currency Box -->
            {if $smarty.const.ISCURRENCY eq '1'}
                <div class="currency-gds">
                    {assign var="CurrencyInfo"  value=$objCurrency->InfoCurrency($objSession->getCurrency())}
                    {if $CurrencyInfo neq null}
                        <div class="currency-inner DivDefaultCurrency">
                            <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/flagCurrency/{$CurrencyInfo['CurrencyFlag']}"
                                 alt=""
                                 id="IconDefaultCurrency">
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
                                <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/flagCurrency/Iran.png" alt="">
                                <span>##IranianRial##</span>
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
            <!-- Search Box -->
            <div class="filterBox">
                <div class="filtertip_hotel site-bg-main-color site-bg-color-border-bottom ">
                    <div class="parent-mobile--new">
                        <p class="txt14 city-name-sidebar-result-hotel">
                            ##Allhotelincity##
                            <span class="hotel-city-name">
                     {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                         {$City['name']}
                     {else}
                         {$City['name_en']}
                     {/if}

                </span></p>
                        <div class="txt14"></div>
                        <span class="silence_span">
                            <div class="container_loading">
                      <div class="circle_load circle-1"></div>
                      <div class="circle_load circle-2"></div>
                      <div class="circle_load circle-3"></div>
                      <div class="circle_load circle-4"></div>
                      <div class="circle_load circle-5"></div>
                  </div>
                        </span>
                    </div>
                    <div class="parent-mobile--filter">
                        <div class="research_Hotel site-main-text-color " onclick="showSearchBoxTicket()">
                            ##ChangeSearchType##
                        </div>
                        <div class="filter_search_holel">
                            <svg class="site-bg-svg-color" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2024 Fonticons, Inc. --><path d="M0 73.7C0 50.7 18.7 32 41.7 32H470.3c23 0 41.7 18.7 41.7 41.7c0 9.6-3.3 18.9-9.4 26.3L336 304.5V447.7c0 17.8-14.5 32.3-32.3 32.3c-7.3 0-14.4-2.5-20.1-7l-92.5-73.4c-9.6-7.6-15.1-19.1-15.1-31.3V304.5L9.4 100C3.3 92.6 0 83.3 0 73.7zM55 80L218.6 280.8c3.5 4.3 5.4 9.6 5.4 15.2v68.4l64 50.8V296c0-5.5 1.9-10.9 5.4-15.2L457 80H55z"/></svg>
                            <span class="site-main-text-color"> ##Filter##</span>
                        </div>
                    </div>
                </div>
                {assign var='all_cities' value=$objsearch->Allcity()}
                {assign var="classNameStartDate" value="hotelStartDateShamsi"}
                {assign var="classNameEndDate" value="hotelEndDateShamsi"}
                {if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || $paramSearch.startDate|substr:0:4 gt 2000}
                    {$classNameStartDate="deptCalendarToCalculateNights"}
                {/if}
                {if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || $paramSearch.endDate|substr:0:4 gt 2000}
                    {$classNameEndDate="returnCalendarToCalculateNights"}
                {/if}
                {assign var="newSearchbox" value=false}
                {if $smarty.get.type == 'new'}
                    {$newSearchbox = true}
                {/if}
                {assign var="numberOfRooms" value=$objFunctions->numberOfRoomsExternalHotelSearch($smarty.get.rooms)}

                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`sidebarSearchHotel.tpl"}
            </div>

            <div class="filterBox hotels_filter_search">
                <span class="s-u-close-filter"></span>
                <div class="filtertip-searchbox">
                    <span class="filter-title">  ##Namehotel##</span>
                    <div class="filter-content">
                        <input type="text" class="form-hotel-item-searchHotelName" placeholder="##EnterHotelName##"
                               id="inputSearchHotel" value="">
                        <i class="fa fa-search form-hotel-item-searchHotelName-i site-main-text-color"></i>
                    </div>
                </div>

                <div class="filtertip-searchbox">
                    <span class="filter-title"> ##Price## (##Rial##)</span>
                    <div class="filter-content padb0">
                        <div class="container_loading">
                            <div class="circle_load circle-1"></div>
                            <div class="circle_load circle-2"></div>
                            <div class="circle_load circle-3"></div>
                            <div class="circle_load circle-4"></div>
                            <div class="circle_load circle-5"></div>
                        </div>
                        <div class="filter-price-text">

                            <span> <i></i> </span>
                            <span> <i></i> </span>
                        </div>
                        <div id="slider-range"></div>
                    </div>
                </div>

                <div class="filtertip-searchbox">
                    <span class="filter-title">##Starhotel##</span>
                    <div class="filter-content padb10">

                        {for $i = 5; $i>=1; $i--}
                            <div class="raste-item" data-star="{$paramSearch.star}">
                                <input type="checkbox" class="FilterHoteltype hotelStarFilter" id="starHotel{$i}"
                                       name="starHotel{$i}" value="{$i}"
                                       {if $paramSearch.star neq 'all' && $paramSearch.star neq $i}disabled{elseif $paramSearch.star eq $i}
                                       checked{/if}>
                                <label class="FilterHoteltypeName site-main-text-color-a" for="starHotel{$i}"></label>
                                <div class="hotel-star-filter-box">
                                    <div class="hotel-star-filter star-{$i}">
                                        {for $c = 0; $c < 5; $c++}
                                            <span></span>
                                        {/for}
                                    </div>
                                </div>
                            </div>
                        {/for}
                    </div>
                </div>

                <div class="filtertip-searchbox " id="filterHotelType">
                    <span class="filter-title"> ##hotelTypes##</span>
                    <div class="filter-content padb10 padt10">
                        <p class="raste-item">
                            <input type="checkbox" class="FilterHoteltype Show_all" id="check_list_all"
                                   name="check_list_all" value="all" checked>
                            <label class="FilterHoteltypeName site-main-text-color-a"
                                   for="check_list_all">##All##</label>
                        </p>
                        {foreach $objsearch->HotelTypes() as $HotelType}
                            <p class="raste-item raste-item{$HotelType.Code}">
                                <input type="checkbox" class="FilterHoteltype ShowByHotelFilters"
                                       id="check_list{$HotelType.Code}"
                                       name="heck_list{$HotelType.Code}" value="{$HotelType.Code}"
                                       {if $paramSearch.hotelType neq 'all' && $paramSearch.hotelType neq $HotelType.Code}disabled{elseif $paramSearch.hotelType eq $HotelType.Code}
                                       checked{/if}>
                                <label class="FilterHoteltypeName site-main-text-color-a"
                                       for="check_list{$HotelType.Code}">
                                    {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                        {$HotelType.Name}
                                    {else}
                                        {$HotelType.NameEn}
                                    {/if}
                                </label>
                            </p>
                        {/foreach}
                    </div>
                </div>

            </div>

            <div class="articles-list d-none">

                <h6 class="site-main-text-color">##RelatedArticles##</h6>
                <ul></ul>

            </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-12  col-12 col-padding-5" id="result">
        <div class="sort-by-section clearfix box">
            <div class="info-login">
                <div class="head-info-login">
                    <svg class="site-bg-svg-color" version="1.0" xmlns="http://www.w3.org/2000/svg"
                         width="128.000000pt" height="128.000000pt" viewBox="0 0 128.000000 128.000000"
                         preserveAspectRatio="xMidYMid meet">

                        <g transform="translate(0.000000,128.000000) scale(0.100000,-0.100000)" stroke="none">
                            <path d="M345 1055 c-14 -13 -25 -31 -25 -39 0 -12 -18 -16 -91 -18 -75 -2
-94 -6 -103 -20 -8 -13 -8 -23 0 -35 9 -15 28 -19 103 -21 73 -2 91 -6 91 -18
0 -8 11 -26 25 -39 21 -22 33 -25 95 -25 62 0 74 3 95 25 14 13 25 31 25 39 0
14 38 16 291 18 265 3 293 5 303 21 8 12 8 22 0 35 -10 15 -38 17 -303 20
-253 2 -291 4 -291 18 0 8 -11 26 -25 39 -21 22 -33 25 -95 25 -62 0 -74 -3
-95 -25z m135 -95 l0 -40 -40 0 -40 0 0 40 0 40 40 0 40 0 0 -40z"/>
                            <path d="M665 735 c-14 -13 -25 -31 -25 -39 0 -14 -34 -16 -251 -18 -227 -3
-253 -5 -263 -21 -8 -12 -8 -22 0 -35 10 -15 36 -17 263 -20 217 -2 251 -4
251 -18 0 -8 11 -26 25 -39 21 -22 33 -25 95 -25 62 0 74 3 95 25 14 13 25 31
25 39 0 13 22 16 131 18 113 3 133 6 143 20 8 13 8 23 0 36 -10 14 -30 17
-143 20 -109 2 -131 5 -131 18 0 8 -11 26 -25 39 -21 22 -33 25 -95 25 -62 0
-74 -3 -95 -25z m135 -95 l0 -40 -40 0 -40 0 0 40 0 40 40 0 40 0 0 -40z"/>
                            <path d="M345 415 c-14 -13 -25 -31 -25 -39 0 -12 -18 -16 -91 -18 -75 -2 -94
-6 -103 -21 -8 -12 -8 -22 0 -35 9 -14 28 -18 103 -20 73 -2 91 -6 91 -18 0
-8 11 -26 25 -39 21 -22 33 -25 95 -25 62 0 74 3 95 25 14 13 25 31 25 39 0
14 38 16 291 18 265 3 293 5 303 21 8 12 8 22 0 35 -10 15 -38 17 -303 20
-253 2 -291 4 -291 18 0 8 -11 26 -25 39 -21 22 -33 25 -95 25 -62 0 -74 -3
-95 -25z m135 -95 l0 -40 -40 0 -40 0 0 40 0 40 40 0 40 0 0 -40z"/>
                        </g>
                    </svg>

                    <span class="">
                                ##Sortby##
                    </span>
                </div>
                <div class="form-sort hotel-sort hotel-sort-hotel">

                    <div class="s-u-form-input-number col-md-6">
                        <div>
                            <select class="select2" tabindex="-1" aria-hidden="true" onchange="selectSortHotel(this);" placeholder="##Starhotel##">
                                <option disabled="" selected="" hidden=""> ##Starhotel##</option>
                                <option value="min_star_code"> ##LTM##</option>
                                <option value="max_star_code"> ##MTL##</option>
                            </select>
                        </div>
                    </div>
                    <div class="s-u-form-input-number col-md-6 pr-0">
                        <div>
                            <select class="select2" tabindex="-1" aria-hidden="true" onchange="selectSortHotel(this);">
                                <option disabled="" selected="" hidden="">##Price##</option>
                                <option value="min_room_price">##LTM##</option>
                                <option value="max_room_price"> ##MTL##</option>
                            </select>
                        </div>
                    </div>
                    {*<div class="s-u-form-input-number form-item form-item-sort countTiket">*}
                    {*<p>##Result##:<var>{$objSearch->countHotel}</var><kbd>##Hotel##</kbd></p>*}
                    {*</div>*}
                </div>
            </div>
        </div>

<!--        <div class="loader-for-local-hotel-end">

            <div class='container'>
                <div class="loader">


                    {* <div class="duo duo1">
                         <div class="dot dot-a"></div>
                         <div class="dot dot-b"></div>
                     </div>
                     <div class="duo duo2">
                         <div class="dot dot-a"></div>
                         <div class="dot dot-b"></div>
                     </div>*}
                </div>

                <div class="text_loading">
                    <h4>
                        {$objFunctions->StrReplaceInXml(['@@cityName@@'=>$City.city_name],'HotelSearchForCity')}
                    </h4>
                    <div class="result_loading">{$objFunctions->StrReplaceInXml(['@@nightsCount@@'=>$paramSearch.nights],'ForHowMenyNights')}
                        {if $smarty.const.SOFTWARE_LANG eq 'fa' }
                            <span> {$objFunctions->dateFormatSpecialJalali($paramSearch.startDate,'j F')}</span>
                            ##To##
                            <span>{$objFunctions->dateFormatSpecialJalali($paramSearch.endDate,'j F')}</span>
                        {else}
                            <span data-start-date="{$paramSearch.startDate}"> {$objFunctions->dateFormatSpecialMiladi($paramSearch.startDate,'j F')}</span>
                            ##To##
                            <span>{$objFunctions->dateFormatSpecialMiladi($paramSearch.endDate,'j F')}</span>
                        {/if}
                    </div>
                </div>
            </div>
        </div>-->


        <div id="loader-page" class="lazy-loader-parent loader-for-local-hotel-end">
            <div class="loader-page container site-bg-main-color">
                <div class="parent-in row">
                    <div class="loader-txt">
                        <div id="hotel_loader">
                            <span class="loader-date">
                             {if $smarty.const.SOFTWARE_LANG eq 'fa' }
                                 <span> {$objFunctions->dateFormatSpecialJalali($paramSearch.startDate,'j F')}</span>
                                        ##untill##
                                        <span>{$objFunctions->dateFormatSpecialJalali($paramSearch.endDate,'j F')}</span>
                                    {else}
                                        <span data-start-date="{$paramSearch.startDate}"> {$objFunctions->dateFormatSpecialMiladi($paramSearch.startDate,'j F')}</span>
                                        ##untill##
                                    <span>{$objFunctions->dateFormatSpecialMiladi($paramSearch.endDate,'j F')}</span>
                             {/if}
                            </span>
                            <div class="wrapper">
                                <div class="locstart"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M567.5 229.7C577.6 238.3 578.9 253.4 570.3 263.5C561.7 273.6 546.6 274.9 536.5 266.3L512 245.5V432C512 476.2 476.2 512 432 512H144C99.82 512 64 476.2 64 432V245.5L39.53 266.3C29.42 274.9 14.28 273.6 5.7 263.5C-2.875 253.4-1.634 238.3 8.473 229.7L272.5 5.7C281.4-1.9 294.6-1.9 303.5 5.7L567.5 229.7zM144 464H192V312C192 289.9 209.9 272 232 272H344C366.1 272 384 289.9 384 312V464H432C449.7 464 464 449.7 464 432V204.8L288 55.47L112 204.8V432C112 449.7 126.3 464 144 464V464zM240 464H336V320H240V464z"/></svg></div>
                                <div class="flightpath"><div class="airplane"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M352 48C352 21.49 373.5 0 400 0C426.5 0 448 21.49 448 48C448 74.51 426.5 96 400 96C373.5 96 352 74.51 352 48zM304.6 205.4C289.4 212.2 277.4 224.6 271.2 240.1L269.7 243.9C263.1 260.3 244.5 268.3 228.1 261.7C211.7 255.1 203.7 236.5 210.3 220.1L211.8 216.3C224.2 185.4 248.2 160.5 278.7 146.9L289.7 142C310.5 132.8 332.1 128 355.7 128C400.3 128 440.5 154.8 457.6 195.9L472.1 232.7L494.3 243.4C510.1 251.3 516.5 270.5 508.6 286.3C500.7 302.1 481.5 308.5 465.7 300.6L439 287.3C428.7 282.1 420.6 273.4 416.2 262.8L406.6 239.8L387.3 305.3L436.8 359.4C442.2 365.3 446.1 372.4 448 380.2L471 472.2C475.3 489.4 464.9 506.8 447.8 511C430.6 515.3 413.2 504.9 408.1 487.8L386.9 399.6L316.3 322.5C301.5 306.4 295.1 283.9 301.6 262.8L318.5 199.3C317.6 199.7 316.6 200.1 315.7 200.5L304.6 205.4zM292.7 344.2L333.4 388.6L318.9 424.8C316.5 430.9 312.9 436.4 308.3 440.9L246.6 502.6C234.1 515.1 213.9 515.1 201.4 502.6C188.9 490.1 188.9 469.9 201.4 457.4L260.7 398L285.7 335.6C287.8 338.6 290.2 341.4 292.7 344.2H292.7zM223.1 274.1C231.7 278.6 234.3 288.3 229.9 295.1L186.1 371.8C185.4 374.5 184.3 377.2 182.9 379.7L118.9 490.6C110 505.9 90.44 511.1 75.14 502.3L19.71 470.3C4.407 461.4-.8371 441.9 7.999 426.6L71.1 315.7C80.84 300.4 100.4 295.2 115.7 303.1L170.1 335.4L202.1 279.1C206.6 272.3 216.3 269.7 223.1 274.1H223.1z"/></svg></div></div>
                                <div class="locend"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M480 0C497.7 0 512 14.33 512 32C512 49.67 497.7 64 480 64V448C497.7 448 512 462.3 512 480C512 497.7 497.7 512 480 512H304V448H208V512H32C14.33 512 0 497.7 0 480C0 462.3 14.33 448 32 448V64C14.33 64 0 49.67 0 32C0 14.33 14.33 0 32 0H480zM112 96C103.2 96 96 103.2 96 112V144C96 152.8 103.2 160 112 160H144C152.8 160 160 152.8 160 144V112C160 103.2 152.8 96 144 96H112zM224 144C224 152.8 231.2 160 240 160H272C280.8 160 288 152.8 288 144V112C288 103.2 280.8 96 272 96H240C231.2 96 224 103.2 224 112V144zM368 96C359.2 96 352 103.2 352 112V144C352 152.8 359.2 160 368 160H400C408.8 160 416 152.8 416 144V112C416 103.2 408.8 96 400 96H368zM96 240C96 248.8 103.2 256 112 256H144C152.8 256 160 248.8 160 240V208C160 199.2 152.8 192 144 192H112C103.2 192 96 199.2 96 208V240zM240 192C231.2 192 224 199.2 224 208V240C224 248.8 231.2 256 240 256H272C280.8 256 288 248.8 288 240V208C288 199.2 280.8 192 272 192H240zM352 240C352 248.8 359.2 256 368 256H400C408.8 256 416 248.8 416 240V208C416 199.2 408.8 192 400 192H368C359.2 192 352 199.2 352 208V240zM256 288C211.2 288 173.5 318.7 162.1 360.2C159.7 373.1 170.7 384 184 384H328C341.3 384 352.3 373.1 349 360.2C338.5 318.7 300.8 288 256 288z"/></svg></div>
                            </div>
                        </div>
                        <div class="loader-distinc">
                            <span>{$objFunctions->StrReplaceInXml(['@@cityName@@'=>$City.name],'HotelSearchForCity')}</span>
                            ##ForYou##
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="hotelResult">

        </div>
        <div class="sticky-article d-none"></div>

        <form method="post" id="formHotel" action="" target='_blank'>
            <input type="hidden" name="startDate" value="{$paramSearch.startDate}">
            <input type="hidden" name="nights" value="{$paramSearch.nights}">
            <input type="hidden" name="endDate" value="{$paramSearch.endDate}">
            <input id="searchRooms" type="hidden" name="searchRooms" value="{$paramSearch.rooms}">
            <input id="cityId" type="hidden" name="cityId" value="{$paramSearch.city_id}">
        </form>

        {assign var="moduleData" value=[
        'service'=>'Hotel',
        'origin'=>$paramSearch.city_id
        ]}


        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`textSearchResults.tpl"
        moduleData=$moduleData}
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`faqs.tpl"
        moduleData=$moduleData}
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`articles.tpl"
        moduleData=$moduleData}


    </div>

</div>


<input type="hidden" value='{$paramSearch|json_encode}' id="dataSearchHotel">

{literal}
    <script src="assets/js/scrollWithPage.min.js"></script>
    <script>
        $('body').on('click', '.currency-gds', function () {
            $(this).find('.change-currency').toggle();
            if ($(".currency-inner .currency-arrow").hasClass("currency-rotate")) {
                $(".currency-inner .currency-arrow").removeClass('currency-rotate');
            } else {
                $(".currency-inner .currency-arrow").addClass('currency-rotate')
            }
        })
        window.onscroll = function () {
            showProgress()
        };

        function showProgress() {
            $('.progress-container').css({'opacity': '1', 'background': 'transparent'});
            var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            if (winScroll < 3) {
                $('.progress-container').css('opacity', '0');
            }
            var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            var scrolled = (winScroll / height) * 100;
            document.getElementById("myBarHead").style.width = scrolled + "%";
        }

        // if ($(window).width() > 990) {
        //     $(".parent_sidebar").scrollWithPage("#appHotel");
        // }

        $('body').on('click', '.filter-title', function () {
            $(this).parent().find('.filter-content').slideToggle();
            $(this).parent().toggleClass('hidden_filter');
        })
        internalHotelSearchDetails()

    </script>
{/literal}

