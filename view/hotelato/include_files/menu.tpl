{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="i_modular_menu header_area">
    <div class="main_header_area animated" id="navbar">
        <div class="container">
            <nav class="navigation d-flex align-items-center">
                <div class="nav-header">
                    <a class="d-flex" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                        <img alt="آژانس مسافرتی" src="project_files/images/logo.png"/>
                    </a>
                </div>
                <div class="nav-menus-wrapper">
                    <ul class="nav-menu">
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/flight">پرواز</a></li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">هتل</a></li>
{*                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور</a>*}
{*                            <ul class="nav-dropdown">*}
{*                                <li><a href="javascript:">داخلی</a>*}
{*                                    {assign var="interval_tour" value=$objResult->ReservationTourCities('=1', 'return')}*}

{*                                    {if $interval_tour|count > 0}*}
{*                                    <ul class="nav-dropdown submenu-child fadeIn animated">*}
{*                                        {foreach key=key_tour item=item_tour from=$interval_tour}*}
{*                                            <li>*}
{*                                                <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-1/1-{$item_tour.id}/all/all">تور {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en} </a>*}
{*                                            </li>*}
{*                                        {/foreach}*}
{*                                    </ul>*}
{*                                    {/if}*}
{*                                </li>*}
{*                                <li><a href="javascript:">خارجی</a>*}
{*                                    {assign var="external_tour" value=$objResult->ReservationTourCountries('yes')}*}
{*                                    {if $external_tour|count > 0}*}
{*                                    <ul class="nav-dropdown submenu-child fadeIn animated">*}
{*                                        {foreach key=key_tour item=item_tour from=$external_tour}*}
{*                                            <li>*}
{*                                                <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-1/{$item_tour.id}-all/all/all">تور {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en} </a>*}
{*                                            </li>*}
{*                                        {/foreach}*}
{*                                    </ul>*}
{*                                    {/if}*}
{*                                </li>*}
{*                            </ul>*}
{*                        </li>*}
{*                        <li class=""><a href="javascript:;">ویزا</a>*}
{*                            <ul class="nav-dropdown first_child_menu fadeIn animated">*}

{*                                {foreach key=key_continent item=item_continent from=$obj_main_page->continentsHaveVisa()}*}
{*                                    <li>*}
{*                                        <a href="javascript:;">*}
{*                                            {$item_continent.titleFa}*}
{*                                        </a>*}
{*                                        <ul class="nav-dropdown submenu-child fadeIn animated">*}
{*                                            {foreach key=key_country item=item_country from=$obj_main_page->countriesHaveVisa($item_continent.id)}*}
{*                                                <li>*}
{*                                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultVisa/{$item_country.code}/all/1-0-0">{$item_country.title}</a>*}
{*                                                </li>*}
{*                                            {/foreach}*}
{*                                        </ul>*}
{*                                    </li>*}
{*                                {/foreach}*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/visa">جست و جوی ویزا</a></li>*}
{*                            </ul>*}
{*                        </li>*}
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/bus">اتوبوس</a></li>
                        <li><a href="javascript:">هتلاتو پلاس</a>
                            <ul class="nav-dropdown">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/mag">مجله هتلاتو</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/news">اخبار</a></li>
                            </ul>
                        </li>
                        <li class="d-block-c d-md-none-c"><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a></li>
                        <li><a href="javascript:">درباره هتلاتو</a>
                            <ul class="nav-dropdown">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/{if $obj_main_page->isLogin()}profile{else}loginUser{/if}">باشگاه مسافران</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/pay">درگاه پرداخت</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/rules">قوانین و مقررات</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/contactUs">تماس با ما</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="box_button_header">
                    <a class="button_header_link d-none d-md-flex" href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
                        <span>پیگیری خرید</span>
                    </a>
                    <a class="button_header_link" href="tel:{$smarty.const.CLIENT_PHONE}">
                        <i class="d-flex d-md-none">
                            <svg width='20px' height='20px' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.5.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M375.8 275.2c-16.4-7-35.4-2.4-46.7 11.4l-33.2 40.6c-46-26.7-84.4-65.1-111.1-111.1L225.3 183c13.8-11.3 18.5-30.3 11.4-46.7l-48-112C181.2 6.7 162.3-3.1 143.6 .9l-112 24C13.2 28.8 0 45.1 0 64v0C0 300.7 183.5 494.5 416 510.9c4.5 .3 9.1 .6 13.7 .8c0 0 0 0 0 0c0 0 0 0 .1 0c6.1 .2 12.1 .4 18.3 .4l0 0c18.9 0 35.2-13.2 39.1-31.6l24-112c4-18.7-5.8-37.6-23.4-45.1l-112-48zM447.7 480C218.1 479.8 32 293.7 32 64v0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0c0-3.8 2.6-7 6.3-7.8l112-24c3.7-.8 7.5 1.2 9 4.7l48 112c1.4 3.3 .5 7.1-2.3 9.3l-40.6 33.2c-12.1 9.9-15.3 27.2-7.4 40.8c29.5 50.9 71.9 93.3 122.7 122.7c13.6 7.9 30.9 4.7 40.8-7.4l33.2-40.6c2.3-2.8 6.1-3.7 9.3-2.3l112 48c3.5 1.5 5.5 5.3 4.7 9l-24 112c-.8 3.7-4.1 6.3-7.8 6.3c-.1 0-.2 0-.3 0z"/></svg>
                        </i>
                        <span class="d-none d-md-flex">{$smarty.const.CLIENT_PHONE}</span>
                    </a>

                    <a class="__login_register_class__ button_header logIn {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}" href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">
                        <i>
                            <svg viewbox="0 0 448 512">
                                <path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 32c52.94 0 96 43.06 96 96c0 52.93-43.06 96-96 96S128 180.9 128 128C128 75.06 171.1 32 224 32zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM413.3 480H34.66C33.2 480 32 478.8 32 477.3C32 399.4 95.4 336 173.3 336h101.3C352.6 336 416 399.4 416 477.3C416 478.8 414.8 480 413.3 480z"></path>
                            </svg>
                        </i>
                        <span>{include file="../../include/signIn/topBarName.tpl"}</span>
{*                        {include file="`$smarty.const.FRONT_CURRENT_THEME`topBarName.tpl"}*}
                    </a>
                    <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
{*                        {include file="`$smarty.const.FRONT_CURRENT_THEME`topBar.tpl"}*}
                        {include file="../../include/signIn/topBar.tpl"}
                    </div>
                    
                </div>
                <div class="nav-toggle mr-3">
                    <svg viewbox="0 0 448 512">
                        <path d="M0 80C0 71.16 7.164 64 16 64H432C440.8 64 448 71.16 448 80C448 88.84 440.8 96 432 96H16C7.164 96 0 88.84 0 80zM0 240C0 231.2 7.164 224 16 224H432C440.8 224 448 231.2 448 240C448 248.8 440.8 256 432 256H16C7.164 256 0 248.8 0 240zM432 416H16C7.164 416 0 408.8 0 400C0 391.2 7.164 384 16 384H432C440.8 384 448 391.2 448 400C448 408.8 440.8 416 432 416z"></path>
                    </svg>
                </div>
            </nav>
        </div>
    </div>
</header>