{assign var="pass_hash" value=$obj_main_page->hashPasswordUser()}
{load_presentation_object filename="reservationBasicInformation" assign="objResult"}

<header class="header_area " id="header">
    <div class="main_header_area animated">
        <div class="container-fluid">
            <nav id="navigation1" class="navigation">
                <div class="nav-header">
                    <a class="nav-brand" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                        <img src="project_files/images/logo.png" alt="{$obj->Title_head()}">
                    </a>
                </div>
                <div class="nav-menus-wrapper">
                    <ul class="nav-menu align-to-right">
                        <li>
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                                صفحه اصلی
                            </a>
                        </li>

                        <li class="li-tour-menu li-tour-internal-menu">
                            <a class="tour-menu" href="javascript:">تور داخلی</a>
                            <ul class="nav-dropdown nav-submenu nav-dropdown-full">
                                <div class="parent-li-tour-menu parent-li-tour-menu2">
                                    <div class="col-3">
                                        <p class="title-cat">
                                            <span>
                                            <i class="fa-light fa-suitcase-rolling"></i>
                                            </span>
                                            تور های داخلی
                                        </p>
                                        <div class="parent-internal--new">
                                            {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCities('=1', 'return' ,false , 9 , 'like')}
                                                {assign var="year" value=substr($item_tour['start_date'], 0, 4)}
                                                {assign var="month" value=substr($item_tour['start_date'], 4, 2)}
                                                {assign var="day" value=substr($item_tour['start_date'], 6)}
                                                <li>

                                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-{$item_tour.id}/all/9" class="country-name">
                                                        تور {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                    </a>

                                                </li>
                                            {/foreach}
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <p class="title-cat">
                                            <span>
                                            <i class="fa-light fa-suitcase-rolling"></i>
                                            </span>
                                                تور های زمینی
                                        </p>
                                        <div class="parent-earth--new">
                                            {assign var="type" value="3"}
                                            {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries(false, false  , $type)}
                                                {assign var="year" value=substr($item_tour['start_date'], 0, 4)}
                                                {assign var="month" value=substr($item_tour['start_date'], 4, 2)}
                                                {assign var="day" value=substr($item_tour['start_date'], 6)}
                                                {foreach $item_tour['city_list'] as $city }
                                                    {assign var="year" value=substr($city['start_date'], 0, 4)}
                                                    {assign var="month" value=substr($city['start_date'], 4, 2)}
                                                    {assign var="day" value=substr($city['start_date'], 6)}
                                                    <li>
                                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-{$city['id']}/all/{$type}">
                                                            تور {$city['name']}
                                                        </a>

                                                    </li>
                                                {/foreach}
                                            {/foreach}
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </li>
                        <li class="li-tour-menu-mobile">
                            <a href="javascript:">تور داخلی</a>
                            <ul class="nav-dropdown nav-submenu">
                                <li>
                                    <a href="javascript:">تور داخلی</a>
                                    <ul class="nav-dropdown my-dropdown nav-submenu">
                                        {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCities('=1', 'return' ,false , 9 , 'like')}
                                            {assign var="year" value=substr($item_tour['start_date'], 0, 4)}
                                            {assign var="month" value=substr($item_tour['start_date'], 4, 2)}
                                            {assign var="day" value=substr($item_tour['start_date'], 6)}
                                            <li>

                                                <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-{$item_tour.id}/all/9" class="country-name">
                                                    تور {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                </a>
                                            </li>
                                        {/foreach}
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:">تور زمینی</a>
                                    <ul class="nav-dropdown my-dropdown nav-submenu">
                                        {assign var="type" value="3"}
                                        {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries(false, false  , $type)}
                                            {assign var="year" value=substr($item_tour['start_date'], 0, 4)}
                                            {assign var="month" value=substr($item_tour['start_date'], 4, 2)}
                                            {assign var="day" value=substr($item_tour['start_date'], 6)}
                                            {foreach $item_tour['city_list'] as $city }
                                                {assign var="year" value=substr($city['start_date'], 0, 4)}
                                                {assign var="month" value=substr($city['start_date'], 4, 2)}
                                                {assign var="day" value=substr($city['start_date'], 6)}
                                                <li>
                                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-{$city['id']}/all/{$type}">
                                                        تور {$city['name']}
                                                    </a>

                                                </li>
                                            {/foreach}
                                        {/foreach}
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="li-tour-menu-mobile">
                            <a href="javascript:">تور خارجی</a>
                            <ul class="nav-dropdown">

                                {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries('yes' , false , 5)}
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/all/all">
                                        {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                    </a>
                                    {if $item_tour['city_list']}
                                    <ul class="nav-dropdown my-dropdown">
                                        {foreach $item_tour['city_list'] as $city }
                                            {if $city.vehicle_ids2 eq 1}
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-{$city['id']}/all/all">
                                                تور {$city['name']}-{$item_tour.type_vehicle_id}
                                            </a>
                                        </li>
                                            {/if}
                                        {/foreach}
                                    </ul>
                                    {/if}
                                </li>
                                {/foreach}
{*                                <li class="other-tour">*}
{*                                    <a href="javascript:">*}
{*                                        همه تورها*}
{*                                    </a>*}
{*                                </li>*}
                            </ul>
                        </li>
                        <li class="li-tour-menu">
                            <a class="tour-menu" href="javascript:">تور خارجی</a>
                            <ul class="nav-dropdown nav-submenu nav-dropdown-full">
                                <div class=" parent-li-tour-menu">

                                    {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries('yes' , false , 5)}
                                        <li>

                                            <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/all/all"  class="country-name">
                                                <span>
                                                    <i class="fa-light fa-earth-americas"></i>
                                                </span>
                                                {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                            </a>
                                            {if $item_tour['city_list']}

                                                    {foreach $item_tour['city_list'] as $city }
                                                        {if $city.vehicle_ids2 eq 1}
                                                            <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-{$city['id']}/all/all">
                                                                تور {$city['name']}
                                                            </a>
                                                        {/if}
                                                    {/foreach}
                                            {/if}
                                        </li>
                                    {/foreach}



                                </div>
                            </ul>
                        </li>



                        {*                        <li>*}
                        {*                            <a>تور خارجی</a>*}
                        {*                            <ul class="nav-dropdown   ">*}

                        {*                                {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries('yes' , false , 3 , 'notLike')}*}
                        {*                                    <li>*}
                        {*                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/{$objDate->jdate("Y-m-d", '', '', '', 'en')}/all">*}
                        {*                                            {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}*}
                        {*                                        </a>*}
                        {*                                    </li>*}
                        {*                                {/foreach}*}
                        {*                                <li class="other-tour">*}
                        {*                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/all-all/{$objDate->jdate("Y-m-d", '', '', '', 'en')}/all">*}
                        {*                                        همه تورها*}
                        {*                                    </a>*}
                        {*                                </li>*}
                        {*                            </ul>*}
                        {*                        </li>*}
                        <li>
                            <a>تور گروهی</a>
                            <ul class="nav-dropdown">
                                {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries('yes', false  ,  7)}
                                    {assign var="year" value=substr($item_tour['start_date'], 0, 4)}
                                    {assign var="month" value=substr($item_tour['start_date'], 4, 2)}
                                    {assign var="day" value=substr($item_tour['start_date'], 6)}
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/all/7">
                                            تور {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                        </a>
                                        {if $item_tour['city_list']}
                                        <ul class="nav-dropdown my-dropdown">

                                            {foreach $item_tour['city_list'] as $city }
                                                {assign var="year" value=substr($city['start_date'], 0, 4)}
                                                {assign var="month" value=substr($city['start_date'], 4, 2)}
                                                {assign var="day" value=substr($city['start_date'], 6)}
                                                <li>
                                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-{$city['id']}/all/7">
                                                        تور {$city['name']}
                                                    </a>
                                                </li>
                                            {/foreach}
                                        </ul>
                                        {/if}
                                    </li>
                                {/foreach}
                                <li class="other-tour">
                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/all-all/all/7">
                                        همه تورها
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a>تور خاص</a>
                            <ul class="nav-dropdown">

                                    <li>
{*                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/all/7">*}
{*                                            تور {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}*}
{*                                        </a>*}
                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/all-all/all/15">تور ناکجا</a>
                                    </li>
                                <li>

                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/all-all/all/19">تور کشتی کروز</a>
                                </li>

                                <li class="other-tour">
                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/all-all/all/7">
                                        همه تورها
                                    </a>
                                </li>
                            </ul>
                        </li>
{*                        <div class="nowhere">*}
{*                            <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/all-all/all/15">تور ناکجا</a>*}
{*                        </div>*}

                        <li>
                            <a class='nowruz-link-menu'>
                                تور نوروز 1405
                            </a>
                                {assign var="summer_tours_params" value=['type'=>'','limit'=> '15','dateNow' => $dateNow,'category' => '13']}
                                {assign var='summerTours' value=$obj_main_page->getToursReservation($summer_tours_params)}
                            {if !empty($summerTours)}
                            <ul class="nav-dropdown">
                                {foreach $summerTours as $item}
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                                            {$item['tour_name']}
                                        </a>
                                    </li>
                                {/foreach}

                                <li class="other-tour">
                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/all-all/all/13">
                                        همه تورهای نوروز 1405
                                    </a>
                                </li>



                            </ul>
                            {/if}
                        </li>
{*                        <li>*}
{*                            <a class='nowruz-link-menu'>*}
{*                                تورهای تابستانه*}
{*                            </a>*}
{*                            <ul class="nav-dropdown">*}
{*                                {assign var="summer_tours_params" value=['type'=>'','limit'=> '15','dateNow' => $dateNow,'category' => '14']}*}
{*                                {assign var='summerTours' value=$obj_main_page->getToursReservation($summer_tours_params)}*}
{*                                {foreach $summerTours as $item}*}
{*                                    <li>*}
{*                                        <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">*}
{*                                            {$item['tour_name']}*}
{*                                        </a>*}
{*                                    </li>*}
{*                                {/foreach}*}
{*                                <li class="other-tour">*}
{*                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/all-all/all/14">*}
{*                                        همه تورهای تابستانه*}
{*                                    </a>*}
{*                                </li>*}
{*                                *}{*                                *}
{*                                *}{*                                {assign var="type" value="13"}*}
{*                                *}{*                                {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries(false, false  ,  $type)}*}
{*                                *}{*                                    {assign var="year" value=substr($item_tour['start_date'], 0, 4)}*}
{*                                *}{*                                    {assign var="month" value=substr($item_tour['start_date'], 4, 2)}*}
{*                                *}{*                                    {assign var="day" value=substr($item_tour['start_date'], 6)}*}
{*                                *}{*                                    <li>*}
{*                                *}{*                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/all/{$type}">*}
{*                                *}{*                                            {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}*}
{*                                *}{*                                        </a>*}
{*                                *}{*                                        <ul class="nav-dropdown my-dropdown">*}
{*                                *}{*                                            {foreach $item_tour['city_list'] as $city }*}
{*                                *}{*                                                {assign var="year" value=substr($city['start_date'], 0, 4)}*}
{*                                *}{*                                                {assign var="month" value=substr($city['start_date'], 4, 2)}*}
{*                                *}{*                                                {assign var="day" value=substr($city['start_date'], 6)}*}
{*                                *}{*                                                <li>*}
{*                                *}{*                                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-{$city['id']}/all/{$type}">*}
{*                                *}{*                                                        {$city['name']}*}
{*                                *}{*                                                    </a>*}
{*                                *}{*                                                </li>*}
{*                                *}{*                                            {/foreach}*}
{*                                *}{*                                        </ul>*}
{*                                *}{*                                    </li>*}
{*                                *}{*                                {/foreach}*}
{*                                *}{*                                *}
{*                            </ul>*}
{*                        </li>*}
                        <li>
                            <a>هتل</a>
                            <ul class="nav-dropdown ">
                                <li>
                                    <a href='{$smarty.const.ROOT_ADDRESS}/page/internal-hotel'>هتل داخلی</a>
                                </li>
                                <li>
                                    <a href='{$smarty.const.ROOT_ADDRESS}/page/world-hotel'>هتل خارجی</a>
                                </li>
                            </ul>
                        </li>

                        {*                        <li>*}
                        {*                            <a>تور تابستانه</a>*}
                        {*                            <ul class="nav-dropdown">*}
                        {*                                {assign var="type" value="11"}*}
                        {*                                {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries(false, false  ,  $type)}*}
                        {*                                    {assign var="year" value=substr($item_tour['start_date'], 0, 4)}*}
                        {*                                    {assign var="month" value=substr($item_tour['start_date'], 4, 2)}*}
                        {*                                    {assign var="day" value=substr($item_tour['start_date'], 6)}*}
                        {*                                    <li>*}
                        {*                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/all/{$type}">*}
                        {*                                            {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}*}
                        {*                                        </a>*}
                        {*                                        <ul class="nav-dropdown my-dropdown">*}

                        {*                                            {foreach $item_tour['city_list'] as $city }*}
                        {*                                                {assign var="year" value=substr($city['start_date'], 0, 4)}*}
                        {*                                                {assign var="month" value=substr($city['start_date'], 4, 2)}*}
                        {*                                                {assign var="day" value=substr($city['start_date'], 6)}*}
                        {*                                                <li>*}
                        {*                                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-{$city['id']}/all/{$type}">*}
                        {*                                                        {$city['name']}*}
                        {*                                                    </a>*}

                        {*                                                </li>*}
                        {*                                            {/foreach}*}
                        {*                                        </ul>*}
                        {*                                    </li>*}
                        {*                                {/foreach}*}
                        {*                                <li class="other-tour">*}
                        {*                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/all-all/all/{$type}">*}
                        {*                                        همه تورها*}
                        {*                                    </a>*}
                        {*                                </li>*}
                        {*                            </ul>*}
                        {*                        </li>*}
                        <li>
                            <a> ویزا </a>
                            <ul class="nav-dropdown ">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/visa">اخذ ویزا</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/embassy-appointment">وقت سفارت</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/visa-pickup">پیکاپ ویزا</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/obtaining-residence">اخذ اقامت</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/study-visa">پذیرش و ویزای تحصیلی</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/mag">وبلاگ</a>
                        </li>
                        <li><a href="javascript:void(0)"> آژانس ما </a>
                            <ul class="nav-dropdown ">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/permissions">مجوز ها</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/contactUs">ارتباط با ما</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری درخواست</a></li>
                                <li>
                                    <a href="https://pabpa24.ir/gds/fa/mag/%D8%B4%D8%B1%DA%A9%D8%AA-%D8%AE%D8%AF%D9%85%D8%A7%D8%AA-%D9%85%D8%B3%D8%A7%D9%81%D8%B1%D8%AA-%D9%87%D9%88%D8%A7%DB%8C%DB%8C-%D9%88-%DA%AF%D8%B1%D8%AF%D8%B4%DA%AF%D8%B1%DB%8C-%D9%BE%D8%A7-%D8%A8%D9%87-%D9%BE%D8%A7-%D8%B3%D9%81%D8%B1">قوانین
                                        و مقررات</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/training-employment">آموزش و استخدام</a>
                                </li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/payment">شماره حساب شرکت</a></li>
                                <li><a href="  https://caa.gov.ir/air-transport-agencies-renewal">لیست آژانس های (بند
                                        الف)</a></li>
                                <li>
                                    <a href="https://ta.mcth.ir/kartablePage?applicationPageId=bc9bfc38-3819-4dee-aa12-01c68e5c448e">لیست
                                        آژانس های (بند ب)</a></li>
                                <li><a href="https://caa.gov.ir/air-cargo">لیست آژانس های بار هوایی</a></li>
                                <li>
                                    <a href="https://ta.mcth.ir/kartablePage?applicationPageId=3a68195e-c21e-4c02-847f-2c1ef86f9cd0">
                                        آژانس های گردشگری سلامت</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="nav-login">
                    <a class="main-navigation__button2 login-parent">
                        <span class="phone-number">
                                {include file="`$smarty.const.FRONT_THEMES_DIR`pabepa360/topBarName.tpl"}
                        </span>
                        <i class="far fa-user"></i>
                    </a>
                    <div class="main-navigation__sub-menu2 arrow-up">

                        {include file="`$smarty.const.FRONT_THEMES_DIR`pabepa360/topBar.tpl"}

                    </div>
                </div>
                <div class="nav-search">
                    <a href="tel:{$smarty.const.CLIENT_PHONE}" class="phone-number-parent">
                        <span class="phone-number">{$smarty.const.CLIENT_PHONE}</span>
                        <i class="far fa-phone" id="icon-phone"></i>
                    </a>
                </div>
                <div class="nav-toggle"></div>
            </nav>
        </div>
    </div>
</header>
