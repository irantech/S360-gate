{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="i_modular_menu header_area">
<div class="main_header_area animated" id="navbar">
<nav class="navigation navigation-landscape" id="navigation1">
<div class="parent-bottom">
<div class="container parent-bottom-header">
<a class="nav-header" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
<img alt="{$obj->Title_head()}" class="__logo_class__ logo" src="project_files/images/logo.png"/>
</a>
<div class="nav-menus-wrapper">
<ul class="nav-menu align-to-right">
    <li class="">
            <a href="javascript:">تور داخلی</a>
            {if $objResult->ReservationTourCities('=1', 'return')}
                <ul class="nav-dropdown nav-submenu" style="display: block;">
                    {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCities('=1', 'return')}
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-{$item_tour.id}/all/all">
                                {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                            </a>
                        </li>
                    {/foreach}
                    <li><a class="a_header_active" href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-all/all/all/0">نمایش همه</a></li>
                </ul>
            {/if}
    </li>
    <li class="">
    <a href="javascript:">تور خارجی</a>
        {if $objResult->ReservationTourCountries('yes')}
            <ul class="nav-dropdown nav-submenu" style="display: none;">
                {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries('yes')}
                    <li>
                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/all/all">
                            {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                        </a>
                    </li>
                {/foreach}
                {*<li><a class="a_header_active" href="javascript:">نمایش همه</a></li>*}
            </ul>
        {/if}
    </li>
<li class="">
<a href="{$smarty.const.ROOT_ADDRESS}/mag">وبلاگ</a>
</li>
<li class="">
<a href="{$smarty.const.ROOT_ADDRESS}/page/travelGuide">راهنمای سفر</a>
</li>
{if $obj_main_page->isLogin()}
    <li><a href="{$smarty.const.ROOT_ADDRESS}/club">باشگاه مشتریان </a></li>
{else}
    <li><a href="{$smarty.const.ROOT_ADDRESS}/authenticate">باشگاه مشتریان </a></li>
{/if}
<li class="">
<a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a>
</li>
<li class="">
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

<a class="__login_register_class__ button btn-user {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}" href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">
<svg class="" data-v-640ab9c6="" fill="" viewbox="0 0 24 24"><path d="M17.25 12.75A3.75 3.75 0 0 1 21 16.5v3.75a.75.75 0 0 1-.75.75H3.75a.75.75 0 0 1-.75-.75V16.5a3.75 3.75 0 0 1 3.75-3.75h10.5Zm0 1.5H6.75A2.25 2.25 0 0 0 4.5 16.5v3h15v-3a2.25 2.25 0 0 0-2.118-2.246l-.132-.004ZM12 3a4.5 4.5 0 1 1 0 9 4.5 4.5 0 1 1 0-9Zm0 1.5a3 3 0 1 0-.001 5.999A3 3 0 0 0 12 4.5Z" fill-rule="evenodd"></path></svg>
    <span>{include file="../../include/signIn/topBarName.tpl"}</span>
</a>
<div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
    {include file="../../include/signIn/topBar.tpl"}
</div>
<div class="nav-toggle"></div>
</div>
</div>
</nav>
</div>
</header>