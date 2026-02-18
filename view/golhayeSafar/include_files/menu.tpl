{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="i_modular_menu header_area">
    <div class="main_header_area animated" id="navbar">
        <div class="container-fluid container-edit">
            <nav class="navigation" id="navigation1">
                <div class="nav-header">
                    <a class="nav-brand" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                        <img alt="{$obj->Title_head()}" class="__logo_class__ logo-img" src="project_files/images/logo.png"/>
                        <div class='bg-img-logo'></div>
                        <p class="logo-text">
                            گلهای سفر
                        </p>
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
                            <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/all/all/0">تور</a>
                            <ul class="nav-dropdown nav-submenu">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-all/all/all/0">تور های داخلی</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/international-tour">تور های خارجی</a>
                                </li>
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/popular-destinations">مقاصد پر طرفدار</a>*}
{*                                </li>*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/favorite-tour">محبوب ترین تورها</a></li>*}
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:">بیشتر</a>
                            <ul class="nav-dropdown nav-submenu">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/insurance">بیمه</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/visa">ویزا</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/rentCar">اجاره خودرو</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/page/embassies">سفارت</a>
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