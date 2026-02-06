{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="i_modular_menu header_area">
    <div class="main_header_area animated  {if $smarty.const.GDS_SWITCH neq 'mainPage' and $smarty.const.GDS_SWITCH neq 'page'}header-special {/if}" id="navbar">
        <div class="container-fluid">
            <nav class="navigation" id="navigation1">
                <div class="nav-header">
                    <a class="nav-brand" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                        <img alt="{$obj->Title_head()}" class="__logo_class__" src="project_files/images/logo.png" />
                    </a>
                </div>
                <div class="nav-menus-wrapper">
                    <ul class="nav-menu align-to-right">
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور</a>
                            <ul class="nav-dropdown">
                                {if $objResult->ReservationTourCities('=1', 'return')}

                                <li><a href="javascript:">تور داخلی</a>
                                    <ul class="nav-dropdown">
                                        {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCities('=1', 'return')}
                                            <li>
                                                <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-{$item_tour.id}/all/all">
                                                    {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                </a>
                                            </li>
                                        {/foreach}
                                    </ul>
                                </li>
                                {/if}
                                {if $objResult->ReservationTourCountries('yes')}
                                <li><a href="javascript:">تور خارجی</a>
                                    <ul class="nav-dropdown">
                                        {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries('yes')}
                                            <li>
                                                <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/all/all">
                                                    {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                </a>
                                            </li>
                                        {/foreach}
                                    </ul>
                                </li>
                                {/if}
                            </ul>
                        </li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/flight">پرواز</a></li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">هتل</a></li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/bus">اتوبوس</a></li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/insurance">بیمه</a></li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/mag">وبلاگ</a></li>
                        <li><a href="javascript:">آژانس ما</a>
                            <ul class="nav-dropdown">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/contactUs">تماس با ما</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/rules">قوانین و مقررات</a></li>
                                <li><a href="{if $obj_main_page->isLogin()}{$smarty.const.ROOT_ADDRESS}/club{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">باشگاه مشتریان</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <a class="__phone_class__ buttonTell mr-auto"
                   href="tel:{$smarty.const.CLIENT_PHONE}">{$smarty.const.CLIENT_PHONE}</a>
                <a class="button2 " href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a>

                <a class="__login_register_class__ button  {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}"
                   href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">
                    <span>{include file="../../include/signIn/topBarName.tpl"}</span>
                </a>
                <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
                    {include file="../../include/signIn/topBar.tpl"}
                </div>
                <div class="nav-toggle mr-3"></div>
            </nav>
        </div>
    </div>
</header>