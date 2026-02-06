{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="i_modular_menu header_area">
    <div class="main_header_area animated" id="navbar">
        <div class="container">
            <nav class="navigation" id="navigation1">
                <div class="nav-header">
                    <a class="nav-brand" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                        <img alt="{$obj->Title_head()}" class="__logo_class__" src="project_files/images/logo.png" />
                        <div class="logo-caption">
                            <span>آژانس خدماتی مسافرتی</span>
                            <span class="sub-logo">پارس پرواز جنوب</span>
                        </div>
                    </a>
                </div>
                <div class="nav-menus-wrapper">
                    <ul class="nav-menu align-to-right">
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/page/flight">پرواز</a>
                        </li>
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">هتل</a>
                        </li>
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/page/bus">اتوبوس</a>
                        </li>
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور</a>
                            <ul class="nav-dropdown">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور داخلی</a>
                                    {if $objResult->ReservationTourCities('=1', 'return')}
                                    <ul class="nav-dropdown nav-submenu nav-menu_ul">
                                        {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCities('=1', 'return')}
                                            <li>
                                                <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-{$item_tour.id}/all/all">
                                                    {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                </a>
                                            </li>
                                        {/foreach}
{*                                        <li><a class="a_header_active" href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-all/all/all/0">نمایش همه</a></li>*}
                                    </ul>
                                    {/if}
                                </li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور خارجی</a>
                                    {if $objResult->ReservationTourCountries('yes')}
                                    <ul class="nav-dropdown nav-submenu nav-menu_ul">
                                        {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries('yes')}
                                            <li>
                                                <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/all/all">
                                                    {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                </a>
                                            </li>
                                        {/foreach}
                                    </ul>
                                    {/if}
                                </li>
                            </ul>
                        </li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/visa">ویزا</a></li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a></li>
                        <li>
                            <a class="link-header" href="javascript:">آژانس ما</a>
                            <ul class="nav-dropdown nav-submenu">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/mag">وبلاگ</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/news">اخبار</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/pay">درگاه پرداخت آنلاین</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/rules">قوانین و مقررات</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/contactUs">تماس با ما</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="parent-btn-header">

                    <a class="__login_register_class__ button btn-user {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}"
                       href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">
                        <span>{include file="../../include/signIn/topBarName.tpl"}</span>
                        <i class="far fa-user"></i>
                    </a>
                    <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
                        {include file="../../include/signIn/topBar.tpl"}
                    </div>
                    <a class="__phone_class__ button btn-phone" href="tel:{$smarty.const.CLIENT_PHONE}">
                        <span>
                            {$smarty.const.CLIENT_PHONE}
                        </span>
                        <i class="far fa-phone"></i>
                    </a>
                </div>
                <div class="nav-toggle"></div>
            </nav>
        </div>
    </div>
</header>