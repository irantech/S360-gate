{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="i_modular_menu header_area">
    <div class="main_header_area animated" id="navbar">
        <div class="container">
            <nav class="navigation d-flex align-items-center">
                <div class="nav-header">
                    <a class="d-flex align-items-center" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                        <img alt="{$obj->Title_head()}" class="__logo_class__" src="project_files/images/logo.jpg"/>
                        <div class="text-nav-brand">
                            <p>گـلگـشـت</p>
                            <span>سامانه رزرواسـیون</span>
                        </div>
                    </a>
                </div>
                <div class="nav-menus-wrapper">
                    <ul class="nav-menu">
                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">صفحه اصلی</a></li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">هتل ها</a>
                            <ul class="nav-dropdown">
{*                                <li>*}
{*                                    <a href="{$smarty.const.ROOT_ADDRESS}/page/turkey-hotel">ترکیه</a>*}
{*                                    <ul class="nav-dropdown">*}
{*                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/istanbul-hotel">استانبول</a></li>*}
{*                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/antalya-hotel">انتالیا</a></li>*}
{*                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/alanya-hotel">آلانیا</a></li>*}
{*                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/ankara-hotel">آنکارا</a></li>*}
{*                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/van-hotel">وان</a></li>*}
{*                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/kusadasi-hotel">کوش آداسی</a></li>*}
{*                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/bodrum-hotel">بدروم</a></li>*}
{*                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/izmir-hotel">ازمیر</a></li>*}
{*                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/trabzon-hotel">ترابزون</a></li>*}

{*                                    </ul>*}
{*                                </li>*}
{*                                <li>*}
{*                                    <a href="{$smarty.const.ROOT_ADDRESS}/page/emarat-hotels">امارات</a>*}
{*                                    <ul class="nav-dropdown">*}
{*                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/dubai-hotel">دبی</a></li>*}
{*                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/Hotel-Abu-Dhabi">ابوظبی</a></li>*}
{*                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/Sharjah-Hotel">شارجه</a></li>*}
{*                                    </ul>*}
{*                                </li>*}
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">عراق</a>
                                    <ul class="nav-dropdown">
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/hotel-karbala">کربلا</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/hotel-najaf">نجف</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/hotel-baghdad">بغداد</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/hotel-erbil">اربیل</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/hotel-sulaymaniyah">سلیمانیه</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/Kadhimiya-hotel">کاظمین</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/Basra-hotel">بصره</a></li>

                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور ها</a>
                            <ul class="nav-dropdown">
                                <li>
                                    <a href="https://golgashthotel.ir/gds/fa/page/iraq-tours">تور عراق</a>
                                    <ul class="nav-dropdown">
                                        <li><a href="https://golgashthotel.ir/gds/fa/page/karbala-tours">تور کربلا</a></li>
                                        <li><a href=" https://golgashthotel.ir/gds/fa/page/combined-tour-of-erbil">تور اربیل</a></li>
                                        <li><a href=" https://golgashthotel.ir/gds/fa/page/baghdad-tours">تور بغداد</a></li>
                                        <li><a href="https://golgashthotel.ir/gds/fa/page/basra-tours">تور بصره</a></li>
                                        <li><a href="https://golgashthotel.ir/gds/fa/page/sulaymaniyah-tour">تور سلیمانیه</a></li>
                                        <li><a href="https://golgashthotel.ir/gds/fa/page/najaf-tours">تور نجف</a></li>
                                        <li><a href="https://golgashthotel.ir/gds/fa/page/Kadhimiya-tour">تور کاظمین</a></li>
                                    </ul>
                                </li>
{*                                <li>*}
{*                                    <a href="https://golgashthotel.ir/gds/fa/page/turkey-tour">تور ترکیه</a>*}
{*                                    <ul class="nav-dropdown">*}
{*                                        <li><a href="https://golgashthotel.ir/gds/fa/page/istanbul-tour">تور استانبول</a></li>*}
{*                                        <li><a href="https://golgashthotel.ir/gds/fa/page/van-tour">تور وان</a></li>*}
{*                                        <li><a href="https://golgashthotel.ir/gds/fa/page/antalya-tour">تور آنتالیا</a></li>*}
{*                                        <li><a href="https://golgashthotel.ir/gds/fa/page/alanya-tour">تور آلانیا</a></li>*}

{*                                    </ul>*}
{*                                </li>*}
                                <li>
                                    <a href=" https://golgashthotel.ir/gds/fa/page/expo-tour">تورهای نمایشگاهی</a>
                                    <ul class="nav-dropdown">
{*                                        <li><a href="https://golgashthotel.ir/gds/fa/page/dubai-expo">تور نمایشگاهی دبی</a></li>*}
                                        <li><a href="https://golgashthotel.ir/gds/fa/page/baghdad-expo">تور نمایشگاهی بغداد</a></li>
                                        <li><a href="https://golgashthotel.ir/gds/fa/page/erbil-expo">تور نمایشگاهی اربیل</a></li>
{*                                        <li><a href=" https://golgashthotel.ir/gds/fa/page/istanbul-expo">تور نمایشگاهی استانبول</a></li>*}
                                        <li><a href="https://golgashthotel.ir/gds/fa/page/basra-expo"> تور نمایشگاهی بصره </a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/mag">وبلاگ</a></li>
{*                        <li><a href="{$smarty.const.ROOT_ADDRESS}/convertDate">تبدیل تاریخ</a></li>*}
                        <li class="d-block-c d-sm-none-c"><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a></li>
                        <li><a href="javascript:">آژانس ما</a>
                            <ul class="nav-dropdown">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/rules">قوانین و مقررات</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/contactUs">تماس با ما</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="box_button_header">
                    <a class="button_header phone-menu" href="tel:02128422214">
                        <span>02128422214</span>
                        <i class="fa-regular fa-phone"></i>
                    </a>
                    <a class="d-none d-sm-block button_header" href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
                        <span>پیگیری خرید</span>
                    </a>
                    <a class="__login_register_class__ button_header logIn {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}" href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">
                        <i class='fa-regular fa-user'></i>
                        <span>{include file="../../include/signIn/topBarName.tpl"}</span>
                    </a>
                    <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
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