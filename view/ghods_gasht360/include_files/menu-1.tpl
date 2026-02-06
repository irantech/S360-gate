{assign var="pass_hash" value=$obj_main_page->hashPasswordUser()}
{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}



<header class="i_modular_menu header_area">
    <div class="main_header_area animated" id="navbar">
        <div class="container-fluid">
            <nav class="navigation" id="navigation1">
                <div class="parent-logo-menu">
                    <a class="nav-header" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                        <img alt="{$obj->Title_head()}" class="logo" src="project_files/images/logo.png"/>
                        <!--                            <div class="logo-caption">-->
                        <!--                                <img class="title-logo" src="project_files/images/title-logo.png" alt="title-logo">-->
                        <!--                                <h1>-->
                        <!--                                    <span class="sub-span">  آژانس مسافرتی </span>-->
                        <!--                                </h1>-->
                        <!--                            </div>-->
                    </a>
                    <div class="nav-menus-wrapper">
                        <ul class="nav-menu align-to-right">
                            <li class="li-tour-menu">
                                <a class="tour-menu" href="javascript:">
                                    <i class="fa-light fa-suitcase-rolling"></i>
                                    <span>تور</span>
                                </a>
                                <ul class="nav-dropdown nav-submenu nav-dropdown-full">
                                    <div class="container parent-li-tour-menu">
{*                                        <li>*}
{*                                            <h2>تورهای درحال اجرا</h2>*}
{*                                            {assign var="type" value="7"}*}
{*                                            {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries(false, false  ,  $type)}*}
{*                                                {assign var="year" value=substr($item_tour['start_date'], 0, 4)}*}
{*                                                {assign var="month" value=substr($item_tour['start_date'], 4, 2)}*}
{*                                                {assign var="day" value=substr($item_tour['start_date'], 6)}*}
{*                                                <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/{$year}-{$month}-{$day}/{$type}">*}
{*                                                    {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}*}
{*                                                </a>*}
{*                                            {/foreach}*}
{*                                        </li>*}
                                        <li>
                                            {assign var="run_tours_params" value=['type'=>'','limit'=> '7','dateNow' => $dateNow,'category' => '7']}
                                            {assign var='runTours' value=$obj_main_page->getToursReservation($run_tours_params)}
                                            <h2>تورهای درحال اجرا</h2>
                                            {foreach $runTours as $item}
                                                <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
                                                    {$item['tour_name']}
                                                </a>
                                            {/foreach}
                                            {if $runTours|count>5}
                                            <a class='all-tour-menu' href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/all/7/all">
                                               همه تورهای در حال اجرا
                                                <i class="fa-solid fa-arrow-left"></i>
                                            </a>
                                            {/if}
                                        </li>
{*                                        <li>*}
{*                                            <h2>تورهای داخلی</h2>*}
{*                                            {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCities('=1', 'return' ,false , 9 , 'like')}*}
{*                                                {assign var="year" value=substr($item_tour['start_date'], 0, 4)}*}
{*                                                {assign var="month" value=substr($item_tour['start_date'], 4, 2)}*}
{*                                                {assign var="day" value=substr($item_tour['start_date'], 6)}*}
{*                                                <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-{$item_tour.id}/{$year}-{$month}-{$day}/9">*}
{*                                                    {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}*}
{*                                                </a>*}
{*                                            {/foreach}*}
{*                                        </li>*}

                                        <li>
                                            <h2>تورهای اروپا</h2>
                                            {assign var="type" value="8"}
                                            {assign var='europeTours' value=$objResult->ReservationTourCountries(false, false  ,  $type)}
                                            {assign var="min_europe_tour" value=0}
                                            {assign var="max_europe_tour" value=5}
                                            {foreach $europeTours as $item_tour}
                                                {assign var="year" value=substr($item_tour['start_date'], 0, 4)}
                                                {assign var="month" value=substr($item_tour['start_date'], 4, 2)}
                                                {assign var="day" value=substr($item_tour['start_date'], 6)}
                                                {if $min_europe_tour <= $max_europe_tour}
                                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/{$item_tour.id}-all/{$year}-{$month}-{$day}/{$type}">
                                                        {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                    </a>
                                                    {$min_europe_tour = $min_europe_tour + 1}
                                                {/if}
                                            {/foreach}
                                            {if $europeTours|count>5}
                                                <a class='all-tour-menu' href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/all/8/all">
                                                    همه تورهای اروپا
                                                    <i class="fa-solid fa-arrow-left"></i>
                                                </a>
                                            {/if}
{*                                            {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries('yes', false  ,  8)}*}
{*                                                {assign var="year" value=substr($item_tour['start_date'], 0, 4)}*}
{*                                                {assign var="month" value=substr($item_tour['start_date'], 4, 2)}*}
{*                                                {assign var="day" value=substr($item_tour['start_date'], 6)}*}
{*                                                <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/{$item_tour.id}-all/{$year}-{$month}-{$day}/7">*}
{*                                                    {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}*}
{*                                                </a>*}
{*                                            {/foreach}*}
                                        </li>
{*                                        <li>*}
{*                                            <h2>تورهای اروپا</h2>*}
{*                                            {assign var="run_tours_params" value=['type'=>'','limit'=> '20','dateNow' => $dateNow,'category' => '8']}*}
{*                                            {assign var='runTours' value=$obj_main_page->getToursReservation($run_tours_params)}*}
{*                                            {foreach $runTours as $item}*}
{*                                                <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">*}
{*                                                    {$item['tour_name']}*}
{*                                                </a>*}
{*                                            {/foreach}*}
{*                                            {if $runTours|count>5}*}
{*                                                <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/1-all/all/all/8">*}
{*                                                    همه تورهای اروپا*}
{*                                                </a>*}
{*                                            {/if}*}
{*                                        </li>*}
                                        <li>
                                            <h2>تورهای آسیا</h2>
                                            {assign var="type" value="9"}
                                            {assign var='asiaTours' value=$objResult->ReservationTourCountries(false, false  ,  $type)}
                                            {assign var="min_asia_tour" value=0}
                                            {assign var="max_asia_tour" value=5}
                                            {foreach $asiaTours as $item_tour}
                                                {assign var="year" value=substr($item_tour['start_date'], 0, 4)}
                                                {assign var="month" value=substr($item_tour['start_date'], 4, 2)}
                                                {assign var="day" value=substr($item_tour['start_date'], 6)}
                                                {if $min_asia_tour <= $max_asia_tour}
                                                <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/{$item_tour.id}-all/{$year}-{$month}-{$day}/{$type}">
                                                    {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                </a>
                                                    {$min_asia_tour = $min_asia_tour + 1}
                                                {/if}
                                            {/foreach}
                                            {if $asiaTours|count>5}
                                                <a class='all-tour-menu' href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/all/9/all">
                                                    همه تورهای آسیا
                                                    <i class="fa-solid fa-arrow-left"></i>
                                                </a>
                                            {/if}
                                        </li>
                                        <li>
                                            <h2>تورهای آمریکا</h2>
                                            {assign var="type" value="10"}
                                            {assign var='americanTours' value=$objResult->ReservationTourCountries(false, false  ,  $type)}
                                            {assign var="min_american_tour" value=0}
                                            {assign var="max_american_tour" value=5}
                                            {foreach $americanTours as $item_tour}
                                                {if $min_american_tour <= $max_american_tour}
                                                {assign var="year" value=substr($item_tour['start_date'], 0, 4)}
                                                {assign var="month" value=substr($item_tour['start_date'], 4, 2)}
                                                {assign var="day" value=substr($item_tour['start_date'], 6)}
                                                <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/{$item_tour.id}-all/{$year}-{$month}-{$day}/{$type}">
                                                    {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                </a>
                                                    {$min_american_tour = $min_american_tour + 1}
                                                {/if}
                                            {/foreach}
                                            {if $americanTours|count>5}
                                                <a class='all-tour-menu' href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/1-all/all/10/all">
                                                    همه تورهای آمریکا
                                                    <i class="fa-solid fa-arrow-left"></i>
                                                </a>
                                            {/if}
                                        </li>
                                        <li>
                                            <h2>تورهای آفریقا</h2>
                                            {assign var="type" value="13"}
                                            {assign var='africaTours' value=$objResult->ReservationTourCountries(false, false  ,  $type)}
                                            {assign var="min_africa_tour" value=0}
                                            {assign var="max_africa_tour" value=5}
                                            {foreach $africaTours as $item_tour}
                                                {if $min_africa_tour <= $max_africa_tour}
                                                    {assign var="year" value=substr($item_tour['start_date'], 0, 4)}
                                                    {assign var="month" value=substr($item_tour['start_date'], 4, 2)}
                                                    {assign var="day" value=substr($item_tour['start_date'], 6)}
                                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/{$item_tour.id}-all/{$year}-{$month}-{$day}/{$type}">
                                                        {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                    </a>
                                                    {$min_africa_tour = $min_africa_tour + 1}
                                                {/if}
                                            {/foreach}
                                            {if $africaTours|count>5}
                                                <a class='all-tour-menu' href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/1-all/all/13/all">
                                                    همه تورهای آفریقا
                                                    <i class="fa-solid fa-arrow-left"></i>
                                                </a>
                                            {/if}
                                        </li>
{*                                        <li>*}
{*                                            <h2>تورهای داخلی</h2>*}
{*                                            {assign var="internal_tour_params" value=['type'=>'','limit'=> '7','dateNow' => $dateNow, 'country' =>'internal','category' => '13']}*}
{*                                            {assign var='internalTours' value=$obj_main_page->getToursReservation($internal_tour_params)}*}

{*                                            {foreach $internalTours as $item}*}
{*                                                <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">*}
{*                                                    {$item['tour_name']}*}
{*                                                </a>*}
{*                                            {/foreach}*}
{*                                            {if $internalTours|count>5}*}
{*                                                <a class='all-tour-menu' href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-all/all/all/0">*}
{*                                                    همه تورهای داخلی*}
{*                                                    <i class="fa-solid fa-arrow-left"></i>*}
{*                                                </a>*}
{*                                            {/if}*}
{*                                        </li>*}
{*                                    <li>*}
{*                                        <h2>تورهای داخلی</h2>*}
{*                                        {assign var="internal_tour_params" value=['type'=>'','limit'=> '7','dateNow' => $dateNow, 'country' =>'internal','category' => '6']}*}
{*                                        {assign var='internalTours' value=$obj_main_page->getToursReservation($internal_tour_params)}*}
{*                                        {foreach $internalTours as $item}*}
{*                                            <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">*}
{*                                                {$item['tour_name']}*}
{*                                            </a>*}
{*                                        {/foreach}*}
{*                                        {if $internalTours|count>5}*}
{*                                            <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-all/all/all/6">*}
{*                                                همه تورهای داخلی*}
{*                                            </a>*}
{*                                        {/if}*}
{*                                    </li>*}
                                        <li>
                                            {assign var="internal_tour_params" value=['type'=>'','limit'=> '7','dateNow' => $dateNow,'category' => '6']}
                                            {assign var='internalTours' value=$obj_main_page->getToursReservation($internal_tour_params)}
                                            <h2>تورهای داخلی</h2>
                                            {foreach $internalTours as $item}
                                                <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
                                                    {$item['tour_name']}
                                                </a>
                                            {/foreach}
                                            {if $internalTours|count>5}
                                                <a class='all-tour-menu' href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/1-all/all/all/6">
                                                    همه تورهای داخلی
                                                    <i class="fa-solid fa-arrow-left"></i>
                                                </a>
                                            {/if}
                                        </li>
                                    </div>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:">هتل</a>
                                <ul class="nav-dropdown nav-submenu">
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/Hotel">داخلی</a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/Hotel">خارجی</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:">خدمات</a>
                                <ul class="nav-dropdown nav-submenu">
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/page/visa">ویزا</a></li>
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/page/cip">cip</a></li>
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/page/insurance">بیمه</a></li>
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/iranVisa">ویزای ایران</a></li>
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/iranVisa"> پیکاپ ویزا</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/mag">مجله گردشگری</a>
                            </li>
{*                            <li>*}
{*                                <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/all/14/all">*}
{*                                    <img class='img-noruz' src="project_files/images/sabze.png" alt="img">*}
{*                                    تورهای نوروز 1404*}
{*                                </a>*}
{*                                {assign var="type" value="14"}*}
{*                                {assign var='norouzTours' value=$objResult->ReservationTourCountries(false, false  ,  $type)}*}
{*                                {assign var="min_norouz_tour" value=0}*}
{*                                {assign var="max_norouz_tour" value=5}*}
{*                                {if $norouzTours|count>0}*}
{*                                    <ul class="nav-dropdown nav-submenu">*}

{*                                        {foreach $norouzTours as $item_tour}*}



{*                                                {assign var="year" value=substr($item_tour['start_date'], 0, 4)}*}
{*                                                {assign var="month" value=substr($item_tour['start_date'], 4, 2)}*}
{*                                                {assign var="day" value=substr($item_tour['start_date'], 6)}*}
{*                                                {if $min_norouz_tour <= $max_norouz_tour}*}
{*                                                    <li>*}
{*                                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/{$item_tour.id}-all/{$year}-{$month}-{$day}/{$type}">*}
{*                                                        {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}*}
{*                                                    </a>*}
{*                                                    {$min_norouz_tour = $min_norouz_tour + 1}*}

{*                                                   </li>*}
{*                                                {/if}*}
{*                                        {/foreach}*}
{*                                        {if $norouzTours|count>5}*}
{*                                            <li>*}
{*                                                <a class='all-tour-menu' href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/all/14/all">*}
{*                                                    همه تورهای نوروز 1404*}
{*                                                    <i class="fa-solid fa-arrow-left"></i>*}
{*                                                </a>*}
{*                                            </li>*}
{*                                        {/if}*}
{*                                    </ul>*}
{*                                {/if}*}
{*                            </li>*}
{*                            <li>*}
{*                                <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/all/15/all">*}
{*                                    <img class='img-noruz' src="project_files/images/Pink_Flower.png" alt="img">*}

{*                                    تورهای تابستان*}
{*                                </a>*}
{*                                {assign var="type" value="15"}*}
{*                                {assign var='baharTours' value=$objResult->ReservationTourCountries(false, false  ,  $type)}*}
{*                                {assign var="min_bahar_tour" value=0}*}
{*                                {assign var="max_bahar_tour" value=5}*}
{*                                {if $baharTours|count>0}*}
{*                                    <ul class="nav-dropdown nav-submenu">*}

{*                                        {foreach $baharTours as $item_tour}*}



{*                                                {assign var="year" value=substr($item_tour['start_date'], 0, 4)}*}
{*                                                {assign var="month" value=substr($item_tour['start_date'], 4, 2)}*}
{*                                                {assign var="day" value=substr($item_tour['start_date'], 6)}*}
{*                                                {if $min_bahar_tour <= $max_bahar_tour}*}
{*                                                    <li>*}
{*                                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/{$item_tour.id}-all/{$year}-{$month}-{$day}/{$type}">*}
{*                                                        {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}*}
{*                                                    </a>*}
{*                                                    {$min_bahar_tour = $min_bahar_tour + 1}*}

{*                                                   </li>*}
{*                                                {/if}*}
{*                                        {/foreach}*}
{*                                        {if $baharTours|count>5}*}
{*                                            <li>*}
{*                                                <a class='all-tour-menu' href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/all/15/all">*}
{*                                                    همه تورهای بهار 1404*}
{*                                                    <i class="fa-solid fa-arrow-left"></i>*}
{*                                                </a>*}
{*                                            </li>*}
{*                                        {/if}*}
{*                                    </ul>*}
{*                                {/if}*}
{*                            </li>*}
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/all/105/all">
                                    تورهای پاییز و زمستان
                                </a>
                                {assign var="type" value="105"}
                                {assign var='autumnTours' value=$objResult->ReservationTourCountries(false, false  ,  $type)}
                                {assign var="min_autumn_tour" value=0}
                                {assign var="max_autumn_tour" value=5}
                                {if $autumnTours|count>0}
                                    <ul class="nav-dropdown nav-submenu">

                                        {foreach $autumnTours as $item_tour}



                                            {assign var="year" value=substr($item_tour['start_date'], 0, 4)}
                                            {assign var="month" value=substr($item_tour['start_date'], 4, 2)}
                                            {assign var="day" value=substr($item_tour['start_date'], 6)}
                                            {if $min_autumn_tour <= $max_autumn_tour}
                                                <li>
                                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/{$item_tour.id}-all/{$year}-{$month}-{$day}/{$type}">
                                                        {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                    </a>
                                                    {$min_autumn_tour = $min_autumn_tour + 1}

                                                </li>
                                            {/if}
                                        {/foreach}
                                        {if $autumnTours|count>5}
                                            <li>
                                                <a class='all-tour-menu' href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/all/105/all">
                                                    همه تورهای پاییزی
                                                    <i class="fa-solid fa-arrow-left"></i>
                                                </a>
                                            </li>
                                        {/if}
                                    </ul>
                                {/if}
                            </li>
{*                            <li>*}
{*                                <a href="javascript:">تورهای پاییز</a>*}
{*                            </li>*}
{*                            <li>*}
{*                                <a href="javascript:">قدس گشت</a>*}
{*                                <ul class="nav-dropdown nav-submenu">*}
{*                                    <li>*}
{*                                        <a href="{$smarty.const.ROOT_ADDRESS}/vote">نظرسنجی</a>*}
{*                                    </li>*}
{*                                    <li>*}
{*                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/CertificateAppreciation">لوح های تقدیر</a>*}
{*                                    </li>*}
{*                                    <li>*}
{*                                        <a href="{$smarty.const.ROOT_ADDRESS}/personnel">مدیران و پرسنل</a>*}
{*                                    </li>*}
{*                                    <li>*}
{*                                        <a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a>*}
{*                                    </li>*}
{*                                    <li>*}
{*                                        <a href="{$smarty.const.ROOT_ADDRESS}/contactUs">ارتباط با ما</a>*}
{*                                    </li>*}
{*                                    <li>*}
{*                                        <a href="{$smarty.const.ROOT_ADDRESS}/rules">قوانین و مقررات قدس گشت</a>*}
{*                                    </li>*}
{*                                </ul>*}
{*                            </li>*}


                        </ul>
                    </div>
                </div>
                <div class="parent-btn-header">
                    <a class="btn-phone-number" href="tel:{$smarty.const.CLIENT_PHONE}">
                        <span>{$smarty.const.CLIENT_PHONE}</span>
                        <svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M484.6 330.6C484.6 330.6 484.6 330.6 484.6 330.6l-101.8-43.66c-18.5-7.688-40.2-2.375-52.75 13.08l-33.14 40.47C244.2 311.8 200.3 267.9 171.6 215.2l40.52-33.19c15.67-12.92 20.83-34.16 12.84-52.84L181.4 27.37C172.7 7.279 150.8-3.737 129.6 1.154L35.17 23.06C14.47 27.78 0 45.9 0 67.12C0 312.4 199.6 512 444.9 512c21.23 0 39.41-14.44 44.17-35.13l21.8-94.47C515.7 361.1 504.7 339.3 484.6 330.6zM457.9 469.7c-1.375 5.969-6.844 10.31-12.98 10.31c-227.7 0-412.9-185.2-412.9-412.9c0-6.188 4.234-11.48 10.34-12.88l94.41-21.91c1-.2344 2-.3438 2.984-.3438c5.234 0 10.11 3.094 12.25 8.031l43.58 101.7C197.9 147.2 196.4 153.5 191.8 157.3L141.3 198.7C135.6 203.4 133.8 211.4 137.1 218.1c33.38 67.81 89.11 123.5 156.9 156.9c6.641 3.313 14.73 1.531 19.44-4.219l41.39-50.5c3.703-4.563 10.16-6.063 15.5-3.844l101.6 43.56c5.906 2.563 9.156 8.969 7.719 15.22L457.9 469.7z"></path></svg>
                    </a>
                    <a class="btn-follow" href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
                        <span >پیگیری خرید</span>
                        <svg viewbox="0 0 640 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M32 128V384C32 401.7 46.33 416 64 416H338.2L330.2 448H64C28.65 448 0 419.3 0 384V128C0 92.65 28.65 64 64 64H512C547.3 64 576 92.65 576 128V192C565.1 191.7 554.2 193.6 544 197.6V128C544 110.3 529.7 96 512 96H64C46.33 96 32 110.3 32 128V128zM368 288C376.8 288 384 295.2 384 304C384 312.8 376.8 320 368 320H112C103.2 320 96 312.8 96 304C96 295.2 103.2 288 112 288H368zM96 208C96 199.2 103.2 192 112 192H464C472.8 192 480 199.2 480 208C480 216.8 472.8 224 464 224H112C103.2 224 96 216.8 96 208zM537.5 241.4C556.3 222.6 586.7 222.6 605.4 241.4L622.8 258.7C641.5 277.5 641.5 307.9 622.8 326.6L469.1 480.3C462.9 486.5 455.2 490.8 446.8 492.1L371.9 511.7C366.4 513 360.7 511.4 356.7 507.5C352.7 503.5 351.1 497.7 352.5 492.3L371.2 417.4C373.3 408.9 377.7 401.2 383.8 395.1L537.5 241.4zM582.8 264C576.5 257.8 566.4 257.8 560.2 264L535.3 288.8L575.3 328.8L600.2 303.1C606.4 297.7 606.4 287.6 600.2 281.4L582.8 264zM402.2 425.1L389.1 474.2L439 461.9C441.8 461.2 444.4 459.8 446.4 457.7L552.7 351.4L512.7 311.5L406.5 417.7C404.4 419.8 402.9 422.3 402.2 425.1L402.2 425.1z"></path></svg>
                    </a>

                    {if $obj_main_page->isLogin()}
                    <a class="__login_register_class__ button_header logIn {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}" href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">
                        <i>
                            <svg viewbox="0 0 448 512">
                                <path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 32c52.94 0 96 43.06 96 96c0 52.93-43.06 96-96 96S128 180.9 128 128C128 75.06 171.1 32 224 32zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM413.3 480H34.66C33.2 480 32 478.8 32 477.3C32 399.4 95.4 336 173.3 336h101.3C352.6 336 416 399.4 416 477.3C416 478.8 414.8 480 413.3 480z"></path>
                            </svg>
                        </i>
                        <span>{include file="`$smarty.const.FRONT_CURRENT_THEME`topBarName.tpl"}</span>
                    </a>
                    <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
                        {include file="`$smarty.const.FRONT_CURRENT_THEME`topBar.tpl"}
                    </div>
                    {else}
                        <div class="__login_register_class__ button  btn-user  main-navigation__button1" >
                            <svg class="" data-v-640ab9c6="" fill="" viewBox="0 0 24 24"><path d="M17.25 12.75A3.75 3.75 0 0 1 21 16.5v3.75a.75.75 0 0 1-.75.75H3.75a.75.75 0 0 1-.75-.75V16.5a3.75 3.75 0 0 1 3.75-3.75h10.5Zm0 1.5H6.75A2.25 2.25 0 0 0 4.5 16.5v3h15v-3a2.25 2.25 0 0 0-2.118-2.246l-.132-.004ZM12 3a4.5 4.5 0 1 1 0 9 4.5 4.5 0 1 1 0-9Zm0 1.5a3 3 0 1 0-.001 5.999A3 3 0 0 0 12 4.5Z" fill-rule="evenodd"></path></svg>
                            <span>ورود / ثبت نام</span>
                            <ul class="register-ul arrow-up2">
                                <li>
                                    <a href='{$smarty.const.ROOT_ADDRESS}/authenticate'>
                                        ورود مسافر
                                    </a>
                                </li>
                                <li>
                                    <a href='{$smarty.const.ROOT_ADDRESS}/loginAgency'>
                                        ورود همکار
                                    </a>
                                </li>
                            </ul>
                        </div>
                    {/if}
                    <div class="lang">
                    <span>
                        <img alt="img" src="project_files/images/flag-uk.png"/>
                    </span>
                        <ul class="lang_ul arrow-up2">
                            <li>
                                <a>
                                        <span>
                                            <img alt="img" src="project_files/images/flag-uk.png"/>

                                            English

                                        </span>
                                </a>
                            </li>
                            <li>
                                <a>
                                        <span>
                                            <img alt="img" src="project_files/images/flag-ger.png"/>

                                            Germany

                                        </span>
                                </a>
                            </li>
                            <li>
                                <a>
<span>
<img alt="img" src="project_files/images/flag-ar.png"/>

                                            العربي

                                        </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="nav-toggle"></div>
            </nav>
        </div>
    </div>
</header>