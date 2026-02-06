{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="i_modular_menu header_area  {if $smarty.const.GDS_SWITCH neq 'mainPage'} header_2 {/if} ">
<div class="main_header_area animated">
<div class="container">
<nav class="navigation" id="navigation1">
<div class="nav-header">
<a class="nav-brand" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
<img alt="{$obj->Title_head()}" class="__logo_class__" src="project_files/images/logo.png"/>
<!--                        <div class="text-nav-brand">-->
<!--                            <h1>pars parvaz tarabar</h1>-->
<!--                        </div>-->
</a>
</div>
<div class="nav-menus-wrapper">
<ul class="nav-menu align-to-right">
<li><a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور</a>
    <ul class="nav-dropdown nav-submenu">
        <li><a href="javascript:;"> تور داخلی </a>
            <ul class="nav-dropdown nav-submenu nav-menu_ul">
                {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCities('=1', 'return')}
                    <li>
                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-{$item_tour.id}/{$objDate->jdate("Y-m-d", '', '', '', 'en')}/all">
                            {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                        </a>
                    </li>
                {/foreach}
            </ul>
        </li>
        <li><a href="javascript:;"> تور خارجی </a>
            <ul class="nav-dropdown nav-submenu nav-menu_ul">
                {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries('yes')}
                    <li>
                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/{$objDate->jdate("Y-m-d", '', '', '', 'en')}/all">
                            {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                        </a>
                    </li>
                {/foreach}
            </ul>
        </li>
        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/tour"> جست و جوی تور </a></li>

    </ul>
</li>
<li><a href="{$smarty.const.ROOT_ADDRESS}/page/flight">پرواز</a></li>
<li><a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">هتل ها</a></li>
<li><a href="{$smarty.const.ROOT_ADDRESS}/page/bus">اتوبوس</a></li>
<li><a href="{$smarty.const.ROOT_ADDRESS}/page/visa">ویزا</a></li>
<li><a href="{$smarty.const.ROOT_ADDRESS}/mag">وبلاگ</a></li>
<li><a href="{$smarty.const.ROOT_ADDRESS}/news">اخبار</a></li>
<li><a href="javascript:">آژانس ما</a>
<ul class="nav-dropdown">
<li><a href="{$smarty.const.ROOT_ADDRESS}/page/purchase-guide">راهنمای خرید</a>

    <ul class="nav-dropdown nav-submenu">
        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/internalTicket"> بلیط داخلی </a></li>
        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/externalTicket"> بلیط خارجی </a></li>
        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/internalHotel"> هتل داخلی </a></li>
        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/externalHotel"> هتل خارجی </a></li>
        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/visaGuide"> ویزا </a></li>
    </ul>
</li>
<li><a href="{$smarty.const.ROOT_ADDRESS}/page/application">راهنمای خرید از اپلیکیشن</a></li>
<li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a></li>
<li><a href="{$smarty.const.ROOT_ADDRESS}/rules">قوانین و مقررات</a></li>
<li><a href="{$smarty.const.ROOT_ADDRESS}/pay">درگاه پرداخت</a></li>
<li><a href="{$smarty.const.ROOT_ADDRESS}/contactUs">تماس با ما</a></li>
</ul>
</li>
</ul>
</div>
<div class="left_menu">
<div class="link_header">

<a class="__login_register_class__ btn_main {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}" href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">
    <span>{include file="../../include/signIn/topBarName.tpl"}</span>
</a>
<div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
    {include file="../../include/signIn/topBar.tpl"}
                        </div>
</div>
<div class="link_header">
<a class="btn_main" href="{$smarty.const.ROOT_ADDRESS}/UserTracking"><span>پیگیری خرید</span></a>
</div>
</div>
    <div class="nav-toggle"></div>
</nav>
</div>
</div>
</header>