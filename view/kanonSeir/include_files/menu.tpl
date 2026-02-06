{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="header_area i_modular_menu">
    <div class="main_header_area animated" id="navbar">
        <div class="container">
            <nav class="navigation" id="navigation1">
                <div class="parent-logo-menu">
                    <a class="nav-header" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                        <img alt="{$obj->Title_head()}" class="logo __logo_class__" src="project_files/images/logo.png "/>
                        <div class="logo-caption">
                            <h1>
                                <span class="top-span">  آژانس مسافرتی </span>
                                <span class="sub-span">  کـانـون سیـــر </span>
                            </h1>
                        </div>
                    </a>
                </div>
                <div class="nav-menus-wrapper">
                    <ul class="nav-menu align-to-right">
                        <li>
                            <a href="javascript:">تور داخلی</a>
                            <ul class="nav-dropdown nav-submenu">
                                {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCities('=1', 'return')}
                                    {assign var="year" value=substr($item_tour['start_date'], 0, 4)}
                                    {assign var="month" value=substr($item_tour['start_date'], 4, 2)}
                                    {assign var="day" value=substr($item_tour['start_date'], 6)}
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-{$item_tour.id}/{$year}-{$month}-{$day}/9">
                                            {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                        </a>
                                    </li>
                                    <li class="other-tour">
                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/all-all/{$objDate->jdate("Y-m-d", '', '', '', 'en')}/all">
                                            همه تورها
                                        </a>
                                    </li>
                                {/foreach}
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:">تور خارجی</a>
                            <ul class="nav-dropdown   ">

                                {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries('yes' , false , 3 , 'notLike')}
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/{$objDate->jdate("Y-m-d", '', '', '', 'en')}/all">
                                            {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                        </a>
                                    </li>
                                {/foreach}
                                <li class="other-tour">
                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/all-all/{$objDate->jdate("Y-m-d", '', '', '', 'en')}/all">
                                        همه تورها
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/mag">وبلاگ</a>
                        </li>
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a>
                        </li>
                        <li>
                            <a href="javascript:">آژانس ما</a>
                            <ul class="nav-dropdown nav-submenu">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/news">اخبار</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/rules">قوانین و مقررات</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/contactUs">تماس با ما</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="parent-btn-header">
                    <a class="btn-phone-number __phone_class__" href="tel:{$smarty.const.CLIENT_PHONE}">
                        <span>
                             {$smarty.const.CLIENT_PHONE}
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M484.6 330.6C484.6 330.6 484.6 330.6 484.6 330.6l-101.8-43.66c-18.5-7.688-40.2-2.375-52.75 13.08l-33.14 40.47C244.2 311.8 200.3 267.9 171.6 215.2l40.52-33.19c15.67-12.92 20.83-34.16 12.84-52.84L181.4 27.37C172.7 7.279 150.8-3.737 129.6 1.154L35.17 23.06C14.47 27.78 0 45.9 0 67.12C0 312.4 199.6 512 444.9 512c21.23 0 39.41-14.44 44.17-35.13l21.8-94.47C515.7 361.1 504.7 339.3 484.6 330.6zM457.9 469.7c-1.375 5.969-6.844 10.31-12.98 10.31c-227.7 0-412.9-185.2-412.9-412.9c0-6.188 4.234-11.48 10.34-12.88l94.41-21.91c1-.2344 2-.3438 2.984-.3438c5.234 0 10.11 3.094 12.25 8.031l43.58 101.7C197.9 147.2 196.4 153.5 191.8 157.3L141.3 198.7C135.6 203.4 133.8 211.4 137.1 218.1c33.38 67.81 89.11 123.5 156.9 156.9c6.641 3.313 14.73 1.531 19.44-4.219l41.39-50.5c3.703-4.563 10.16-6.063 15.5-3.844l101.6 43.56c5.906 2.563 9.156 8.969 7.719 15.22L457.9 469.7z"></path></svg>
                    </a>

                    <a class="button btn-user __login_register_class__ {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}" href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">
                        <svg class="" data-v-640ab9c6="" fill="" viewbox="0 0 24 24"><path d="M17.25 12.75A3.75 3.75 0 0 1 21 16.5v3.75a.75.75 0 0 1-.75.75H3.75a.75.75 0 0 1-.75-.75V16.5a3.75 3.75 0 0 1 3.75-3.75h10.5Zm0 1.5H6.75A2.25 2.25 0 0 0 4.5 16.5v3h15v-3a2.25 2.25 0 0 0-2.118-2.246l-.132-.004ZM12 3a4.5 4.5 0 1 1 0 9 4.5 4.5 0 1 1 0-9Zm0 1.5a3 3 0 1 0-.001 5.999A3 3 0 0 0 12 4.5Z" fill-rule="evenodd"></path></svg>
                        <span>{include file="../../include/signIn/topBarName.tpl"}</span>
                    </a>
                    <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
                        {include file="../../include/signIn/topBar.tpl"}
                    </div>
                </div>
                <div class="nav-toggle"></div>
            </nav>
        </div>
    </div>
</header>