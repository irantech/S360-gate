{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="i_modular_menu {if $smarty.const.GDS_SWITCH neq 'mainPage'}header2 {/if}">
    <div class="main_head">
        <div class="header_area_bg"></div>
        <div class="header_area">
            <div class="main_header_area animated">
                <div class="container">
                    <nav class="navigation" id="navigation1">
                        <div class="nav-header"><a class="nav-brand" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                                <img alt="{$obj->Title_head()}" class="__logo_class__ hotel-logo-text"
                                     src="project_files/images/logo.png" />
                            </a>
                        </div>
                        <div class="nav-menus-wrapper">
                            <ul class="nav-menu">
                                <li class=""><a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تورها</a>
                                    <ul class="nav-dropdown fadeIn animated">
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-all/all/all/0"> تور داخلی </a>
                                            {if $objResult->ReservationTourCities('=1', 'return')}
                                            <ul class="nav-dropdown submenu-child fadeIn animated">
                                                {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCities('=1', 'return')}
                                                <li>
                                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-{$item_tour.id}/all/all">
                                                        {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                    </a>
                                                </li>
                                                {/foreach}
                                            </ul>
                                            {/if}
                                        </li>
                                    </ul>
                                </li>
                                <li class=""><a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">هتل ها</a>
                                    <ul class="nav-dropdown fadeIn animated">
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/hotelInternal"> هتل های داخلی </a>
                                            {*
                                            <ul class="nav-dropdown submenu-child fadeIn animated">
                                                <li>
                                                    <a href="javascript:"> تست </a>
                                                </li>
                                            </ul>
                                            *}
                                        </li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/hotelExternal"> هتل های خارجی </a>
                                           {*
                                            <ul class="nav-dropdown submenu-child fadeIn animated">
                                                <li>
                                                    <a href="javascript:">تست</a>
                                                    <ul class="nav-dropdown submenu-child fadeIn animated">
                                                        <li>
                                                            <a href="javascript:"> تست</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                            *}
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/visa">اطلاعات ویزا</a>
                                   {*
                                    <ul class="nav-dropdown">
                                        <li><a href="javascript:">تست</a>
                                            <ul class="nav-dropdown">
                                                <li><a href="javascript:">تست</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                  *}
                                </li>
                                <li><a class="SMBlog" href="{$smarty.const.ROOT_ADDRESS}/mag">مجله گردشگری </a></li>
                                <li><a href="javascript:">مشتریان</a>
                                    <ul class="nav-dropdown">
                                        <li><a class="SMRules" href="{$smarty.const.ROOT_ADDRESS}/rules"> قوانین و
                                                مقررات </a></li>
                                        <li><a class="" href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
                                                پیگیری
                                                خرید </a></li>
                                    </ul>
                                </li>
                                <li><a href="#">دانستنیها</a>
                                    <ul class="nav-dropdown">
                                        <li><a class="SMAboutIran" href="{$smarty.const.ROOT_ADDRESS}/aboutIran"> معرفی
                                                ایران </a></li>
                                        <li><a class="SMAboutCountry" href="{$smarty.const.ROOT_ADDRESS}/aboutCountry">معرفی
                                                کشورها</a></li>
                                        <li><a class="SMWeather"
                                               href="{$smarty.const.ROOT_ADDRESS}/weather">هواشناسی</a></li>
                                    </ul>
                                </li>
                                <li><a class="SMAbout" href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a></li>
                                <li><a class="SMContactUs" href="{$smarty.const.ROOT_ADDRESS}/contactUs">تماس با ما</a></li>
                            </ul>
                        </div>
                        <div class="btn-menu">
                            <div class="nav-toggle"></div>

                            <a class="__login_register_class__ button btn-user {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}"
                               href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">
                                <i class="fas fa-user-alt"></i>
                                <span>{include file="../../include/signIn/topBarName.tpl"}</span>
                            </a>
                            <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js"
                                 style="display: none">
                                {include file="../../include/signIn/topBar.tpl"}
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>