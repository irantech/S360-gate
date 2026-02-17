{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="i_modular_menu header_area">
<div class="main_header_area animated" id="navbar">
<div class="container-fluid">
<nav class="navigation" id="navigation1">
<div class="parent-logo-menu">
<a class="nav-header" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
<img alt="{$obj->Title_head()}" class="__logo_class__ logo" src="project_files/images/logo.png"/>
<!--                            <div class="logo-caption">-->
<!--                                <img class="title-logo" src="project_files/images/title-logo.png" alt="title-logo">-->
<!--                                <h1>-->
<!--                                    <span class="sub-span">  آژانس مسافرتی </span>-->
<!--                                </h1>-->
<!--                            </div>-->
</a>
<div class="nav-menus-wrapper">
<ul class="nav-menu align-to-right">
<li>
<a href="javascript:">بلیط</a>
<ul class="nav-dropdown nav-submenu">
<li>
<a href="{$smarty.const.ROOT_ADDRESS}/page/InternalFlight">پرواز داخلی</a>
</li>
    <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/page/ExternalFlight">پرواز خارجی</a>
    </li>
<li>
<a href="{$smarty.const.ROOT_ADDRESS}/page/train">قطار</a>
</li>
<li>
<a href="{$smarty.const.ROOT_ADDRESS}/page/bus">اتوبوس</a>
</li>
</ul>
</li>
<li>
<a href="javascript:">اقامت</a>
<ul class="nav-dropdown nav-submenu">
<li>
<a href="{$smarty.const.ROOT_ADDRESS}/page/internalHotel">هتل داخلی </a>
</li>
    <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/page/externalHotel">هتل خارجی </a>
    </li>
<li>
<a href="{$smarty.const.ROOT_ADDRESS}/page/dorm">خوابگاه</a>
</li>
<li>
<a href="{$smarty.const.ROOT_ADDRESS}/page/Residence">اقامتگاه</a>
</li>
</ul>
</li>
<li>
<a href="javascript:">تور</a>
<ul class="nav-dropdown nav-submenu" style="right: auto;">
<li><a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور گروهی</a>
</li>
{*<li class=""><a href="{$smarty.const.ROOT_ADDRESS}/page/tour">*}
{*        تور خارجی*}
{*    </a>*}
{*</li>*}
<li><a href="{$smarty.const.ROOT_ADDRESS}/page/package">پرواز + هتل</a>
</li>
</ul>
</li>
<li>
<a href="{$smarty.const.ROOT_ADDRESS}/page/entertainment">تفریحات</a>
</li>
<li>
<a href="{$smarty.const.ROOT_ADDRESS}/page/Europcar">خودرو</a>
</li>
    <li><a href="{$smarty.const.ROOT_ADDRESS}/page/travelInsurance">بیمه سفر</a></li>

    <li>

    <a href="javascript:">بیشتر</a>
<ul class="nav-dropdown nav-submenu">
<li><a href="{$smarty.const.ROOT_ADDRESS}/page/travelCard">سفر کارت</a></li>
<li><a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور اختصاصی</a></li>
</ul>
</li>
</ul>
</div>
</div>
<div class="parent-btn-header">
<a class="__phone_class__ btn-phone-number" href="tel:{$smarty.const.CLIENT_PHONE}">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2024 Fonticons, Inc. --><path d="M48 256C48 141.1 141.1 48 256 48s208 93.1 208 208V400.1c0 22.1-17.9 40-40 40L313.6 440c-8.3-14.4-23.8-24-41.6-24H240c-26.5 0-48 21.5-48 48s21.5 48 48 48h32c17.8 0 33.3-9.7 41.6-24l110.4 .1c48.6 0 88.1-39.4 88.1-88V256C512 114.6 397.4 0 256 0S0 114.6 0 256v40c0 13.3 10.7 24 24 24s24-10.7 24-24V256zm112-32V336c-17.7 0-32-14.3-32-32V256c0-17.7 14.3-32 32-32zM80 256v48c0 44.2 35.8 80 80 80h16c17.7 0 32-14.3 32-32V208c0-17.7-14.3-32-32-32H160c-44.2 0-80 35.8-80 80zm272-32c17.7 0 32 14.3 32 32v48c0 17.7-14.3 32-32 32V224zm80 32c0-44.2-35.8-80-80-80H336c-17.7 0-32 14.3-32 32V352c0 17.7 14.3 32 32 32h16c44.2 0 80-35.8 80-80V256z"></path></svg>
    <span>مرکز پشتیبانی</span>
</a>
<a class="btn-follow" {if $obj_main_page->isLogin()} href="{$smarty.const.ROOT_ADDRESS}/userBook" {else}  href="{$smarty.const.ROOT_ADDRESS}/authenticate" {/if}>
<svg viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2024 Fonticons, Inc. --><path d="M64 80c-8.8 0-16 7.2-16 16V416c0 8.8 7.2 16 16 16H512c8.8 0 16-7.2 16-16V96c0-8.8-7.2-16-16-16H64zM0 96C0 60.7 28.7 32 64 32H512c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zm96 64a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm104 0c0-13.3 10.7-24 24-24H448c13.3 0 24 10.7 24 24s-10.7 24-24 24H224c-13.3 0-24-10.7-24-24zm0 96c0-13.3 10.7-24 24-24H448c13.3 0 24 10.7 24 24s-10.7 24-24 24H224c-13.3 0-24-10.7-24-24zm0 96c0-13.3 10.7-24 24-24H448c13.3 0 24 10.7 24 24s-10.7 24-24 24H224c-13.3 0-24-10.7-24-24zm-72-64a32 32 0 1 1 0-64 32 32 0 1 1 0 64zM96 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path></svg>
<span>سفر های من</span>
</a>

<a class="__login_register_class__ button btn-user {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}" href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">
<svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2024 Fonticons, Inc. --><path d="M352 144a96 96 0 1 0 -192 0 96 96 0 1 0 192 0zm-240 0a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zM49.3 464H462.7c-8.3-54.4-55.3-96-112-96H161.3c-56.7 0-103.6 41.6-112 96zM0 481.3C0 392.2 72.2 320 161.3 320H350.7C439.8 320 512 392.2 512 481.3c0 17-13.8 30.7-30.7 30.7H30.7C13.8 512 0 498.2 0 481.3z"></path></svg>
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