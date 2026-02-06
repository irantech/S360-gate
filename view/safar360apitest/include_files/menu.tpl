{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="i_modular_menu header_area">
    <div class="main_header_area animated" id="navbar">
        <div class="container-fluid">
            <nav class="navigation" id="navigation1">
                <div class="nav-header">
                    <a alt="{$obj->Title_head()}" class="__logo_class__ nav-brand"
                       href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                        <img alt="venus" src="project_files/images/logo.png" />
                        <!--                        <div class="logo-caption">-->
                        <!--                            <h1>-->
                        <!--                                <span class="top-span"> ونـوس </span>-->
                        <!--                                <span class="sum-span">آژانس مسافرتی</span>-->
                        <!--                            </h1>-->
                        <!--                        </div>-->
                    </a>
                </div>
                <div class="nav-menus-wrapper">
                    <ul class="nav-menu align-to-right">
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/page/flight">بلیط</a>
                            <ul class="nav-dropdown nav-submenu">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/international-flight">پرواز های خارجی</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور</a>
                            <ul class="nav-dropdown nav-submenu">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/internal-tour">تور های داخلی</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/international-tour">تور های خارجی</a>
                                </li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/popular-destinations">مقاصد پر طرفدار</a>
                                </li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/favorite-tour">محبوب ترین تورها</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:">خدمات سفر</a>
                            <ul class="nav-dropdown nav-submenu">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/insurance">بیمه مسافرتی</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/visa">ویزای سفر</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:">آژانس ما</a>
                            <ul class="nav-dropdown nav-submenu">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/contactUs">تماس با ما</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/mag">مجله سفر360</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/get-app">دریافت اپلیکیشن</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/page/safar360-charter">چارترهای سفر360</a>
                        </li>
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/club" onclick="clickScroll('gym-box')">باشگاه
                                مشتریان</a>
                        </li>
                    </ul>
                </div>
                <div class="parent-btn-header">
                    <a class="__phone_class__ button btn-phone btn-style" href="tel:{$smarty.const.CLIENT_PHONE}">
                        <span>{$smarty.const.CLIENT_PHONE}</span>
                        <i class="fa-light fa-phone my-phone"></i>
                    </a>

                    <a class="__login_register_class__ button btn-user btn-style {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}"
                       href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">
                        <span>{include file="../../include/signIn/topBarName.tpl"}</span>
                        <i class="fa-light fa-user my-user"></i>
                    </a>
                    <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
                        {include file="../../include/signIn/topBar.tpl"}
                    </div>
                    <a class="button btn-buy btn-style" href="{$smarty.const.ROOT_ADDRESS}/UserTracking">

                        پیگیری خرید

                        <i class="fa-light fa-memo-circle-check"></i>
                    </a>
                </div>
                <div class="nav-toggle"></div>
            </nav>
        </div>
    </div>
</header>