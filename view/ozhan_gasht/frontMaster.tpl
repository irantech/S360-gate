{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="dateTimeSetting" assign="objDate"}
{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{if $smarty.session['userId'] }
    {assign var="userInfo" value=functions::infoMember($smarty.session.userId)}
    {assign var="hashedPass" value=functions::HashKey({$userInfo['email']},'encrypt')}
{/if}
{assign var="gds_project_file_name" value="versa_gasht"}
<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="{$obj->Title_head()}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{$obj->Title_head()}</title>
    <base href="{$smarty.const.CLIENT_DOMAIN}"/>

    <link rel="shortcut icon" type="image/png" href="project_files/images/favicon.png">

    {literal}
        <script src="project_files/js/jquery-3.4.1.min.js"></script>
    {/literal}

    {if $smarty.session.layout neq 'pwa'}
        <link rel="stylesheet" href="project_files/css/all.min.css">
        <link rel="stylesheet" href="project_files/css/header.css">
        <link rel="stylesheet" href="project_files/css/register.css">
    {/if}

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}

</head>
<body>
{if $smarty.session.layout neq 'pwa' }
<header id="header" class="header_area">
        <div class="main_header_area animated" id="navbar">
            <nav id="navigation1" class="navigation">
                <div class="box-header-top">
                    <div class="container">
                        <div class="item-parent-header-top">
                            <div class='register'>
                                <a href="https://online.ozhangasht.com/gds/fa/loginUser" class="">ورود به حساب </a>
                                <a href="https://online.ozhangasht.com/gds/fa/registerUser" class="">ثبت نام حساب کاربری</a>
                            </div>
                            <div class="mx-auto div-phone-email">
                                <a href="tel:+987691001177" class="item-phone-email">
                                    <i class="fa-solid fa-phone-flip"></i>
                                     76-91001177 98+
                                </a>
                                <a href="tel:+982191001777" class="item-phone-email">
                                    <i class="fa-solid fa-phone-flip"></i>
                                     21-91001777 98+
                                </a>
{*                                <a href="tel:+982191007767" class="item-phone-email">*}
{*                                    <i class="fa-solid fa-phone-flip"></i>*}
{*                                     21-91007767 98+*}
{*                                </a>*}
                                <a href="mail:info@ozhangasht.com" class="item-phone-email">
                                    <i class="fa-solid fa-envelope"></i>
                                    info@ozhangasht.com
                                </a>
                            </div>
                            <div class="div-language">
                                <a href="https://ozhangasht.com/tr/" class="">Turkish </a>
                                <a href="https://ozhangasht.com/ru/" class="">Русский</a>
                                <a href="https://ozhangasht.com/zh/" class="">中国人</a>
                                <a href="https://ozhangasht.com/en/" class="">English</a>
                                <a href="https://ozhangasht.com/ar/" class="">العربیة</a>
                                <a href="https://ozhangasht.com" class="active-language">فارسی</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-header-center">
                    <div class="container">
                        <div class="item-parent-header-center">
                            <div class="nav-header">
                                <a class="nav-brand" href="https://ozhangasht.com">
                                    <img src='project_files/images/logo.png' alt='logo'>
                                    <div class="titr-logo">
                                        <span>آژانس هواپیمایی و گردشگری</span>
                                        <h1>اوژن گشت کیش</h1>
                                    </div>
                                </a>
                            </div>
                            <div class="parent-media">
                                <a class="button  " href="javascript:">
                                    <a href="javascript:" class="main-navigation__button2 button_logIn btn-user">
                                        <i class="fa-light fa-user"></i>
                                        {include file="`$smarty.const.FRONT_THEMES_DIR`ozhan_gasht/topBarName.tpl"}
                                    </a>
                                    <div class="main-navigation__sub-menu2" style="display: none">
                                        {include file="`$smarty.const.FRONT_THEMES_DIR`ozhan_gasht/topBar.tpl"}
                                    </div>
                                </a>
{*                                <div class="parent-shopping">*}
{*                                    <a href="" class="">*}
{*                                        <i class="fas fa-shopping-cart"></i>*}
{*                                    </a>*}
{*                                </div>*}
                                <div class="media-item">
                                    <a href="https://instagram.com/ozhangasht" class="media-instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
{*                                    <a href="https://t.me/ozhangasht" class="media-telegram">*}
{*                                        <i class="fab fa-telegram"></i>*}
{*                                    </a>*}
                                    <a href="https://ozhangasht.com/zh/####" class="media-whatsapp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </div>
                                <div class="nav-toggle"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-header-bottom">
                    <div class="container">
                        <div class="nav-menus-wrapper">
                            <ul class="nav-menu align-to-right">
                                <li><a href="https://ozhangasht.com">صفحه اصلی</a></li>
                                <li><a href="https://ozhangasht.com/entertainments">رزرو تفریحات کیش</a>
                                    <ul class="nav-dropdown">
                                        <li>
                                            <a href="/entertainments/پر-فروشترین-ها">
                                                <i class="p-2 fa-sharp fa-solid fa-objects-align-top" aria-hidden="true"></i>
                                                پر فروش ترین ها
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://ozhangasht.com/entertainments/sea">
                                                <i class="p-2 fa-solid fa-mask-snorkel" aria-hidden="true"></i>
                                                تفریحات دریایی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/entertainments/misc">
                                                <i class="p-2 fa-sharp fa-solid fa-location-dot" aria-hidden="true"></i>
                                                اماکن گردشگری و تفریحی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/entertainments/cruises">
                                                <i class="p-2 fas fa-fw fa-ship" aria-hidden="true"></i>
                                                کشتی تفریحی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/entertainments/night-show">
                                                <i class="p-2 fa-solid fa-masks-theater" aria-hidden="true"></i>
                                                جنگ های شبانه
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/entertainments/restaurants">
                                                <i class="p-2 fa-solid fa-fork-knife" aria-hidden="true"></i>
                                                کافه و رستوران های موزیکال
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/entertainments/massage-and-welfare-sevices">
                                                <i class="p-2 fa-solid fa-spa" aria-hidden="true"></i>
                                                مراکز ماساژ و خدمات رفاهی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/entertainments/kishvand-package">
                                                <i class="p-2 fa-solid fa-box-heart" aria-hidden="true"></i>
                                                پکیج کیشوندان
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/entertainments/sightseeing">
                                                <i class="p-2 fa-solid fa-bus" aria-hidden="true"></i>
                                                گشت های جزیره
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/entertainments/best-package">
                                                <i class="p-2 fa-solid fa-box-check" aria-hidden="true"></i>
                                                پکیج های منتخب
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/entertainments/all-items">
                                                <i class="p-2 fa-solid fa-grid-2" aria-hidden="true"></i>
                                                آیتم های مورد نیاز سفر
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/entertainments/concerts">
                                                <i class="p-2 fas fa-fw fa-music" aria-hidden="true"></i>
                                                کنسرت
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="/tour">تور</a>
                                    <ul class="nav-dropdown">
                                        <li>
                                            <a href="/tour/تورهای-اروپایی">
                                                <i class="p-2 fa-solid fa-earth-europe" aria-hidden="true"></i>
                                                تورهای ترکیبی اروپا
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/tour/تور-های-قاره-آمریکا">
                                                <i class="p-2 fa-solid fa-earth-americas" aria-hidden="true"></i>
                                                تور های قاره آمریکا
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/tour/تور-های-قاره-آفریقا">
                                                <i class="p-2 fa-solid fa-earth-asia" aria-hidden="true"></i>
                                                تور های قاره آفریقا
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/tour/تور-های-ویژه-آسیا">
                                                <i class="p-2 fa-solid fa-earth-asia" aria-hidden="true"></i>
                                                تور های ویژه آسیا
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/tour/تور-های-ویژه-استرالیا">
                                                <i class="p-2 fa-solid fa-earth-oceania" aria-hidden="true"></i>
                                                تور های ویژه استرالیا
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="/ozhankala">اوژن کالا</a>
                                    <ul class="nav-dropdown">
                                        <li>
                                            <a href="/ozhankala/میراث-فرهنگی">
                                                <i class="p-2 fas fa-fw fa-pen-paintbrush" aria-hidden="true"></i>
                                                میراث فرهنگی
                                            </a>
                                            <ul class="nav-dropdown dropdown2">
                                                <li>
                                                    <a href="/ozhankala/میراث-فرهنگی/صنایع-دستیسفارت-ها" >
                                                        <i class="p-2 fas fa-fw fa-hammer" aria-hidden="true"></i>
                                                        صنایع دستی
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="/ozhankala/میراث-فرهنگی/هنر-های-دستی" >
                                                        <i class="p-2 fas fa-fw fa-palette" aria-hidden="true"></i>
                                                        هنر های دستی
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="https://ozhangasht.com/accommodation">ویلا و اقامتگاه</a></li>
                                <li><a href="/mag">مجله اوژن گشت</a>
                                    <ul class="nav-dropdown">
                                        <li>
                                            <a href="/mag/tourism-news">
                                                <i class="p-2 fas fa-fw fa-newspaper" aria-hidden="true"></i>
                                                بانک جامع گردشگری کیش
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/mag/جشنوارهای-تابستانی-کیش">
                                                <i class="p-2 fa-light fa-solid fa-island-tropical" aria-hidden="true"></i>
                                                جشنوارهای تابستانی کیش
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/mag/iran-tourism">
                                                <i class="p-2 fas fa-fw fa-map-location-dot" aria-hidden="true"></i>
                                                بانک جامع ایرانگردی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/mag/world-tourism">
                                                <i class="p-2 fas fa-fw fa-globe" aria-hidden="true"></i>
                                                بانک جامع جهانگردی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/mag/بانک-جامع-اطلاعات-سفر">
                                                <i class="p-2 fa-regular fa-globe-stand" aria-hidden="true"></i>
                                                اطلاعات سفر اوژن گشت
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/mag/ozh-activities">
                                                <i class="p-2 fa-solid fa-futbol" aria-hidden="true"></i>
                                                فرهنگی و نمایشگاهی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/mag/map-of-iran-provinces">
                                                <i class="p-2 fa-solid fa-map-location-dot" aria-hidden="true"></i>
                                                نقشه ایران استان ها
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/mag/khadamat-visa">
                                                <i class="p-2 fa-solid fa-user" aria-hidden="true"></i>
                                                خدمات ویزا
                                            </a>
                                            <ul class="nav-dropdown dropdown2">
                                                <li>
                                                    <a href="/mag/khadamat-visa/سفارت-ها" >
                                                        <i class="p-2 fa-solid fa-building" aria-hidden="true"></i>
                                                        سفارت ها
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="/mag/khadamat-visa/visa-information" >
                                                        <i class="p-2 fa-brands fa-cc-visa" aria-hidden="true"></i>
                                                        خدمات اخذ ویزا
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="/mag/khadamat-visa/no-visa" >
                                                        <i class="p-2 fa-brands fa-cc-visa" aria-hidden="true"></i>
                                                        سفر بدون ویزا
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="https://ozhangasht.com/terms">قوانین و مقررات</a>
                                    <ul class="nav-dropdown">
                                        <li>
                                            <a href="https://ozhangasht.com/terms/general">
                                                <i class="p-2 fas fa-fw fa-gavel" aria-hidden="true"></i>
                                                قوانین و مقررات عمومی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://ozhangasht.com/terms/flight-domestic">
                                                <i class="p-2 fas fa-fw fa-plane-departure fa-flip-horizontal" aria-hidden="true"></i>
                                                قوانین و مقررات پرواز داخلی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://ozhangasht.com/terms/hotel-domestic">
                                                <i class="p-2 fas fa-fw fa-bed" aria-hidden="true"></i>
                                                قوانین و مقررات هتل داخلی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://ozhangasht.com/terms/hotel-foreign">
                                                <i class="p-2 fas fa-fw fa-bed" aria-hidden="true"></i>
                                                قوانین و مقررات هتل خارجی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://ozhangasht.com/terms/insurance">
                                                <i class="p-2 fas fa-fw fa-umbrella" aria-hidden="true"></i>
                                                قوانین و مقررات بیمه مسافرتی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://ozhangasht.com/terms/قوانین-و-مقررات-گردشگری-کیش">
                                                <i class="p-2 fa-solid fa-book-section" aria-hidden="true"></i>
                                                قوانین و مقررات گردشگری کیش
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/terms/questions-for-items">
                                                <i class="p-2 fa-solid fa-comment-question" aria-hidden="true"></i>
                                                راهنمایی خرید تفریحات کیش
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://ozhangasht.com/terms/flight-foreign">
                                                <i class="p-2 fas fa-fw fa-plane-departure" aria-hidden="true"></i>
                                                قوانین و مقررات پرواز خارجی
                                            </a>
                                            <ul class="nav-dropdown dropdown2">
                                                <li>
                                                    <a href="https://www.qatarairways.com/en-bg/visa-and-passport-requirements.html" >
                                                        <i class="p-2 fas fa-link" aria-hidden="true"></i>
                                                        استعلام ویزاهای ترانزیت بین مسیر
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://sadadpsp.ir/tollpayment/" >
                                                        <i class="p-2 fas fa-link" aria-hidden="true"></i>
                                                        پرداخت عوارض خروج از کشور
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="http://exitban.ssaa.ir/" >
                                                        <i class="p-2 fas fa-link" aria-hidden="true"></i>
                                                        استعلام ممنوعیت خروج از کشور
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>





                                    </ul>
                                </li>
                                <li><a href="/توضیحات-تکمیلی">توضیحات تکمیلی</a>
                                    <ul class="nav-dropdown">
                                        <li>
                                            <a href="/توضیحات-تکمیلی/questions-1">
                                                <i class="p-2 fas fa-fw fa-comment-question" aria-hidden="true"></i>
                                                راهنمایی بلیط هواپیما
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/توضیحات-تکمیلی/انواع-روش‌های-خرید-بلیط-هواپیما">
                                                <i class="p-2 fa-solid fa-ticket" aria-hidden="true"></i>
                                                انواع روش‌های خرید بلیط هواپیما
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/توضیحات-تکمیلی/1-رزرو-هتل">
                                                <i class="p-2 fas fa-fw fa-hotel" aria-hidden="true"></i>
                                                راهنمای رزرواسیون هتل
                                            </a>
                                            <ul class="nav-dropdown dropdown2">
                                                <li>
                                                    <a href="/توضیحات-تکمیلی/1-رزرو-هتل/1-رزرو-هتل-داخلی" >
                                                        <i class="p-2 fas fa-fw fa-hotel" aria-hidden="true"></i>
                                                        رزرو هتل داخلی
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="/توضیحات-تکمیلی/1-رزرو-هتل/1-رزرو-هتل-خارجی" >
                                                        <i class="p-2 fas fa-fw fa-hotel" aria-hidden="true"></i>
                                                        رزرو هتل خارجی
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="/توضیحات-تکمیلی/bime-safar-information-1">
                                                <i class="p-2 fas fa-fw fa-umbrella" aria-hidden="true"></i>
                                                خرید بیمه مسافرتی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/توضیحات-تکمیلی/1-بلیط-هواپیما">
                                                <i class="p-2 fas fa-fw fa-plane-departure" aria-hidden="true"></i>
                                                بلیط هواپیما
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/توضیحات-تکمیلی/1-قیمت-روز-بلیط-هواپیما">
                                                <i class="p-2 fas fa-fw fa-money-bill" aria-hidden="true"></i>
                                                قیمت روز بلیط هواپیما
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/توضیحات-تکمیلی/1-بلیط-چارتر-هواپیما">
                                                <i class="p-2 fas fa-fw fa-plane-departure" aria-hidden="true"></i>
                                                بلیط چارتر هواپیما
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/توضیحات-تکمیلی/1-بلیط-پرواز-داخلی">
                                                <i class="p-2 fas fa-fw fa-plane-departure" aria-hidden="true"></i>
                                                بلیط پرواز داخلی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/توضیحات-تکمیلی/بلیط-پرواز-خارجی">
                                                <i class="p-2 fas fa-fw fa-plane-departure" aria-hidden="true"></i>
                                                بلیط پرواز خارجی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/توضیحات-تکمیلی/1-بلیط-کیش">
                                                <i class="p-2 fas fa-fw fa-plane-departure" aria-hidden="true"></i>
                                                بلیط کیش
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/توضیحات-تکمیلی/1-بلیط-مشهد">
                                                <i class="p-2 fas fa-fw fa-plane-departure" aria-hidden="true"></i>
                                                بلیط مشهد
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/توضیحات-تکمیلی/1-بلیط-دبی">
                                                <i class="p-2 fas fa-fw fa-plane-departure" aria-hidden="true"></i>
                                                بلیط دبی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/توضیحات-تکمیلی/1-بلیط-ترکیه">
                                                <i class="p-2 fas fa-fw fa-plane-departure" aria-hidden="true"></i>
                                                بلیط ترکیه
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/توضیحات-تکمیلی/1-بلیط-داخلی-ترکیه">
                                                <i class="p-2 fas fa-fw fa-plane-departure" aria-hidden="true"></i>
                                                بلیط داخلی ترکیه
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/توضیحات-تکمیلی/خرید-بلیط-هواپیما-کانادا">
                                                <i class="p-2 fas fa-fw fa-plane-departure" aria-hidden="true"></i>
                                                خرید بلیط هواپیما کانادا
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/توضیحات-تکمیلی/1-بلیط-هواپیما-آمریکا">
                                                <i class="p-2 fas fa-fw fa-plane-departure" aria-hidden="true"></i>
                                                بلیط هواپیما آمریکا
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="/flight-ticket">اطلاعات پرواز</a>
                                    <ul class="nav-dropdown">
                                        <li>
                                            <a href="/flight-ticket/اطلاعات-پرواز-فرودگاه-کیش">
                                                <i class="p-2 fa-solid fa-circle-info" aria-hidden="true"></i>
                                                اطلاعات پرواز فرودگاه کیش
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://fids.airport.ir/2/%D8%A7%D8%B7%D9%84%D8%A7%D8%B9%D8%A7%D8%AA-%D9%BE%D8%B1%D9%88%D8%A7%D8%B2-%D9%81%D8%B1%D9%88%D8%AF%DA%AF%D8%A7%D9%87-%D9%85%D9%87%D8%B1%D8%A2%D8%A8%D8%A7%D8%AF">
                                                <i class="p-2 fa-solid fa-circle-info" aria-hidden="true"></i>
                                                اطلاعات پرواز فرودگاه مهرآباد
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://fids.airport.ir/102/%D8%A7%D8%B7%D9%84%D8%A7%D8%B9%D8%A7%D8%AA-%D9%BE%D8%B1%D9%88%D8%A7%D8%B2-%D9%81%D8%B1%D9%88%D8%AF%DA%AF%D8%A7%D9%87-%D9%85%D8%B4%D9%87%D8%AF"">
                                            <i class="p-2 fa-solid fa-circle-info" aria-hidden="true"></i>
                                            اطلاعات پرواز فرودگاه مشهد
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://fids.airport.ir/114/%D8%A7%D8%B7%D9%84%D8%A7%D8%B9%D8%A7%D8%AA-%D9%BE%D8%B1%D9%88%D8%A7%D8%B2-%D9%81%D8%B1%D9%88%D8%AF%DA%AF%D8%A7%D9%87-%D8%A7%D8%B5%D9%81%D9%87%D8%A7%D9%86">
                                                <i class="p-2 fa-solid fa-circle-info" aria-hidden="true"></i>
                                                اطالاعات پرواز فرودگاه اصفهان
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://mrbilit.com/flight-info/KER">
                                                <i class="p-2 fa-solid fa-circle-info" aria-hidden="true"></i>
                                                اطلاعات پرواز فرودگاه کرمان
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://fids.airport.ir/1/%D8%A7%D8%B7%D9%84%D8%A7%D8%B9%D8%A7%D8%AA-%D9%BE%D8%B1%D9%88%D8%A7%D8%B2-%D9%81%D8%B1%D9%88%D8%AF%DA%AF%D8%A7%D9%87-%D8%B4%D9%8A%D8%B1%D8%A7%D8%B2">
                                                <i class="p-2 fa-solid fa-circle-info" aria-hidden="true"></i>
                                                اطلاعات پرواز فرودگاه شیراز
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://fids.airport.ir/106/%D8%A7%D8%B7%D9%84%D8%A7%D8%B9%D8%A7%D8%AA-%D9%BE%D8%B1%D9%88%D8%A7%D8%B2-%D9%81%D8%B1%D9%88%D8%AF%DA%AF%D8%A7%D9%87-%D8%B3%D8%A7%D8%B1%D9%8A">
                                                <i class="p-2 fa-solid fa-circle-info" aria-hidden="true"></i>
                                                اطالاعات پرواز فرودگاه ساری
                                            </a>
                                        </li>
                                        <li>
                                            <a href=https://fids.airport.ir/117/%D8%A7%D8%B7%D9%84%D8%A7%D8%B9%D8%A7%D8%AA-%D9%BE%D8%B1%D9%88%D8%A7%D8%B2-%D9%81%D8%B1%D9%88%D8%AF%DA%AF%D8%A7%D9%87-%D8%A8%D9%86%D8%AF%D8%B1%D8%B9%D8%A8%D8%A7%D8%B3">
                                                <i class="p-2 fa-solid fa-circle-info" aria-hidden="true"></i>
                                                اطلاعات پرواز فرودگاه بندر عباس
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.ikac.ir/flight-status">
                                                <i class="p-2 fa-solid fa-circle-info" aria-hidden="true"></i>
                                                اطلاعات پرواز فرودگاه امام
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/flight-ticket/اطلاعات-پرواز-فرودگاه-های-دبی">
                                                <i class="p-2 fa-solid fa-circle-info" aria-hidden="true"></i>
                                                اطلاعات پرواز فرودگاه های دبی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/flight-ticket/اطلاعات-پرواز-فرودگاه-استانبول">
                                                <i class="p-2 fa-solid fa-circle-info" aria-hidden="true"></i>
                                                اطلاعات پرواز فرودگاه استانبول
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/flight-ticket/اطلاعات-پرواز-فرودگاه-فرانکفورت">
                                                <i class="p-2 fa-solid fa-circle-info" aria-hidden="true"></i>
                                                اطلاعات پرواز فرودگاه فرانکفورت
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="/about-us">درباره ما</a>
                                    <ul class="nav-dropdown">
                                        <li>
                                            <a href="https://ozhangasht.com/about-us">
                                                <i class="p-2 fa-solid fa-pen-nib" aria-hidden="true"></i>
                                                پیام مدیر عامل
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/about-us/contact">
                                                <i class="p-2 fa-sharp fa-solid fa-phone-volume fa-shake" aria-hidden="true"></i>
                                                تماس با ما
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>
{/if}

{if $smarty.const.GDS_SWITCH eq 'app'}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
{else}
    <div class="content_tech" style="margin-top: 20px;" >
        <div class="container">
            <div class="temp-wrapper">
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
            </div>
        </div>
    </div>
{/if}
{if $smarty.session.layout neq 'pwa'}
{if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
<footer>
    <div class='footer-main'>
        <div class='container'>
            <div class='parent-footer-main row'>
                <div class='col-lg-4 col-md-4 col-sm-12 col-12'>
                    <div class='footer-main-link'>
                        <h2>توضیحات تکمیلی</h2>
                        <ul>
                            <li>
                                <a href='https://ozhangasht.com/%D8%AA%D9%88%D8%B6%DB%8C%D8%AD%D8%A7%D8%AA-%D8%AA%DA%A9%D9%85%DB%8C%D9%84%DB%8C/questions-1'>
                                    <i class="fa-solid fa-comment-question"></i>
                                    سوالات متداول
                                </a>
                            </li>
                            <li>
                                <a href='https://ozhangasht.com/%D8%AA%D9%88%D8%B6%DB%8C%D8%AD%D8%A7%D8%AA-%D8%AA%DA%A9%D9%85%DB%8C%D9%84%DB%8C/%D8%A8%D9%84%DB%8C%D8%B7-%DA%A9%DB%8C%D8%B4'>
                                    <i class="fa-solid fa-plane-departure"></i>
                                    بلیط کیش
                                </a>
                            </li>
                            <li>
                                <a href='https://ozhangasht.com/%D8%AA%D9%88%D8%B6%DB%8C%D8%AD%D8%A7%D8%AA-%D8%AA%DA%A9%D9%85%DB%8C%D9%84%DB%8C/%D8%A8%D9%84%DB%8C%D8%B7-%D9%85%D8%B4%D9%87%D8%AF'>
                                    <i class="fa-solid fa-plane-departure"></i>
                                    بلیط مشهد
                                </a>
                            </li>
                            <li>
                                <a href='https://ozhangasht.com/%D8%AA%D9%88%D8%B6%DB%8C%D8%AD%D8%A7%D8%AA-%D8%AA%DA%A9%D9%85%DB%8C%D9%84%DB%8C/%D8%A8%D9%84%DB%8C%D8%B7-%D9%BE%D8%B1%D9%88%D8%A7%D8%B2-%D8%AF%D8%A7%D8%AE%D9%84%DB%8C'>
                                    <i class="fa-solid fa-plane-departure"></i>
                                    بلیط پرواز داخلی
                                </a>
                            </li>
                            <li>
                                <a href='https://ozhangasht.com/%D8%AA%D9%88%D8%B6%DB%8C%D8%AD%D8%A7%D8%AA-%D8%AA%DA%A9%D9%85%DB%8C%D9%84%DB%8C/%D8%A8%D9%84%DB%8C%D8%B7-%D9%87%D9%88%D8%A7%D9%BE%DB%8C%D9%85%D8%A7'>
                                    <i class="fa-solid fa-plane-departure"></i>
                                    بلیط هواپیما
                                </a>
                            </li>
                            <li>
                                <a href='https://ozhangasht.com/%D8%AA%D9%88%D8%B6%DB%8C%D8%AD%D8%A7%D8%AA-%D8%AA%DA%A9%D9%85%DB%8C%D9%84%DB%8C/%D8%A8%D9%84%DB%8C%D8%B7-%D8%AA%D8%B1%DA%A9%DB%8C%D9%87'>
                                    <i class="fa-solid fa-plane-departure"></i>
                                    بلیط ترکیه
                                </a>
                            </li>
                            <li>
                                <a href='https://ozhangasht.com/%D8%AA%D9%88%D8%B6%DB%8C%D8%AD%D8%A7%D8%AA-%D8%AA%DA%A9%D9%85%DB%8C%D9%84%DB%8C/%D8%A8%D9%84%DB%8C%D8%B7-%D8%AF%D8%A7%D8%AE%D9%84%DB%8C-%D8%AA%D8%B1%DA%A9%DB%8C%D9%87'>
                                    <i class="fa-solid fa-plane-departure"></i>
                                    بلیط داخلی ترکیه
                                </a>
                            </li>
                            <li>
                                <a href='https://ozhangasht.com/%D8%AA%D9%88%D8%B6%DB%8C%D8%AD%D8%A7%D8%AA-%D8%AA%DA%A9%D9%85%DB%8C%D9%84%DB%8C/%D8%A8%D9%84%DB%8C%D8%B7-%D8%AF%D8%A8%DB%8C'>
                                    <i class="fa-solid fa-plane-departure"></i>
                                    بلیط دبی
                                </a>
                            </li>
                            <li>
                                <a href='https://ozhangasht.com/%D8%AA%D9%88%D8%B6%DB%8C%D8%AD%D8%A7%D8%AA-%D8%AA%DA%A9%D9%85%DB%8C%D9%84%DB%8C/%D8%A8%D9%84%DB%8C%D8%B7-%D9%87%D9%88%D8%A7%D9%BE%DB%8C%D9%85%D8%A7-%D8%A2%D9%85%D8%B1%DB%8C%DA%A9%D8%A7'>
                                    <i class="fa-solid fa-plane-departure"></i>
                                    بلیط هواپیما آمریکا
                                </a>
                            </li>
                            <li>
                                <a href='https://ozhangasht.com/%D8%AA%D9%88%D8%B6%DB%8C%D8%AD%D8%A7%D8%AA-%D8%AA%DA%A9%D9%85%DB%8C%D9%84%DB%8C/%D8%AE%D8%B1%DB%8C%D8%AF-%D8%A8%D9%84%DB%8C%D8%B7-%D9%87%D9%88%D8%A7%D9%BE%DB%8C%D9%85%D8%A7-%DA%A9%D8%A7%D9%86%D8%A7%D8%AF%D8%A7'>
                                    <i class="fa-solid fa-plane-departure"></i>
                                    خرید بلیط هواپیما کانادا
                                </a>
                            </li>
                            <li>
                                <a href='https://ozhangasht.com/%D8%AA%D9%88%D8%B6%DB%8C%D8%AD%D8%A7%D8%AA-%D8%AA%DA%A9%D9%85%DB%8C%D9%84%DB%8C/%D8%A8%D9%84%DB%8C%D8%B7-%DA%86%D8%A7%D8%B1%D8%AA%D8%B1-%D9%87%D9%88%D8%A7%D9%BE%DB%8C%D9%85%D8%A7'>
                                    <i class="fa-solid fa-plane-departure"></i>
                                    بلیط چارتر هواپیما
                                </a>
                            </li>
                            <li>
                                <a href='https://ozhangasht.com/%D8%AA%D9%88%D8%B6%DB%8C%D8%AD%D8%A7%D8%AA-%D8%AA%DA%A9%D9%85%DB%8C%D9%84%DB%8C/%D8%B1%D8%B2%D8%B1%D9%88-%D9%87%D8%AA%D9%84' class=''>
                                    <i class="fa-solid fa-hotel"></i>
                                    رزرو هتل
                                </a>
                            </li>
                            <li>
                                <a href='https://ozhangasht.com/%D8%AA%D9%88%D8%B6%DB%8C%D8%AD%D8%A7%D8%AA-%D8%AA%DA%A9%D9%85%DB%8C%D9%84%DB%8C/%D8%B3%D9%81%D8%B1-%DA%A9%D8%A7%D8%B1%D8%AA-%D8%A7%D9%88%DA%98%D9%86-%DA%AF%D8%B4%D8%AA' class=''>
                                    <i class="fa-solid fa-credit-card"></i>
                                    سفر کارت اوژن گشت
                                </a>
                            </li>
                            <li>
                                <a href='https://ozhangasht.com/%D8%AA%D9%88%D8%B6%DB%8C%D8%AD%D8%A7%D8%AA-%D8%AA%DA%A9%D9%85%DB%8C%D9%84%DB%8C/%D9%82%DB%8C%D9%85%D8%AA-%D8%B1%D9%88%D8%B2-%D8%A8%D9%84%DB%8C%D8%B7-%D9%87%D9%88%D8%A7%D9%BE%DB%8C%D9%85%D8%A7' class=''>
                                    <i class="fa-sharp fa-solid fa-money-bill"></i>
                                    قیمت روز بلیط هواپیما
                                </a>
                            </li>
                            <li>
                                <a href='https://ozhangasht.com/%D8%AA%D9%88%D8%B6%DB%8C%D8%AD%D8%A7%D8%AA-%D8%AA%DA%A9%D9%85%DB%8C%D9%84%DB%8C/%D8%B1%D8%A7%D9%87%DA%A9%D8%A7%D8%B1%D9%87%D8%A7%DB%8C-%D8%B3%D8%A7%D8%B2%D9%85%D8%A7%D9%86%DB%8C-%D8%A7%D9%88%DA%98%D9%86-%DA%AF%D8%B4%D8%AA' class=''>
                                    <i class="fa-sharp fa-solid fa-clipboard"></i>
                                    راهکارهای سازمانی اوژن گشت
                                </a>
                            </li>
                            <li>
                                <a href='https://ozhangasht.com/%D8%AA%D9%88%D8%B6%DB%8C%D8%AD%D8%A7%D8%AA-%D8%AA%DA%A9%D9%85%DB%8C%D9%84%DB%8C/%D9%87%D9%85%DA%A9%D8%A7%D8%B1%DB%8C-%D8%A8%D8%A7-%D9%85%D8%A7' class=''>
                                    <i class="fa-sharp fa-solid fa-handshake"></i>
                                    همکاری با ما
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class='col-lg-5 col-md-4 col-sm-12 col-12'>
                    <div class='footer-main-link'>
                        <h2>درباره اوژن گشت</h2>
                        <p>
                            اوژن گشت با استفاده از تکنولوژی های جدید آنلاین، بهترین خدمات خرید بلیط هواپیمایی خارجی و داخلی، رزرو هتل خارجی و داخلی، رزرو قطار خارجی، خرید بیمه مسافرتی، ترانسفر فرودگاهی و کشتی کروز را در سراسر دنیا به مشتریان خود ارائه می دهد. ارزان ترین قیمت بلیط هواپیمای خارجی و رزرو هتل خارجی در اوژن گشت پیش روی شماست، تا با چند کلیک، رزرو و خرید خود را کاملا آنلاین انجام دهید.
                        </p>
                        <p>
                            خرید بلیط ارزان قیمت و بلیط لحظه آخری در کنار رزرو هتل های لوکس و همچنین رزرو قطارهای خارجی و بلیط پرواز خارجی در اروپا و سراسر دنیا با بهترین قیمت فراهم شده است. خرید تفریحات در سایت اوژن گشت؛ بانک جامع گردشگری و تفریحات دریایی کیش، به سادگی و در کوتاه ترین زمان ممکن امکان پذیر است.
                        </p>
                        <div class='license'>
                            <h5>
                                عضو انجمن صنفی دفاتر خدمات مسافرتی هوایی و جهانگردی ایران به شماره ثبت ۲۵۹۴
                            </h5>
                            <h5>
                                (دارای مجوز رسمی از منطقه آزاد کیش)
                            </h5>
                        </div>
                    </div>
                </div>
                <div class='col-lg-3 col-md-4 col-sm-12 col-12'>
                    <div class='footer-main-link'>
                        <h2>نماد ها</h2>
                        <div class='my-logo-namd'>
                            <div class=''>
                                <img src='project_files/images/enamad.png' alt='img-namad'>
                            </div>
                            <div class=''>
                                <img src='project_files/images/p30web-samandehi.png' alt='img-namad'>
                            </div>
                            <div class=''>
                                <img src='project_files/images/kasbokar.png' alt='img-namad'>
                            </div>
                            <div class=''>
                                <img src='project_files/images/iata.png' alt='img-namad'>
                            </div>
                            <a href='https://caa.gov.ir/' class=''>
                                <img src='project_files/images/caa.png' alt='img-namad'>
                            </a>
                            <div class=''>
                                <img src='project_files/images/miras.png' alt='img-namad'>
                            </div>
                            <a href=' http://www.aattai.org/member-show.bc?lid=1&id=1293656' class=''>
                                <img src='project_files/images/aattai.png' alt='img-namad'>
                            </a>
                            <a href='https://iranian.cards/Merchant/Detail/2627' class=''>
                                <img src='project_files/images/irancard.png' alt='img-namad'>
                            </a>
                            <a href=' https://www.shaparak.ir/' class=''>
                                <img src='project_files/images/shaparak.png' alt='img-namad'>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="footer-top">
            <div class="container">
                <div class="parent-footer-top">
                    <div class="parent-text-top">
                        <a href="https://ozhangasht.com/registration" class="text-top-item-link">
                            ثبت کسب و کار
                        </a>
                        <a href="https://ozhangasht.com/agencies" class="text-top-item-link">
                            فرم ساین آژانس ها
                        </a>
                        <a href="https://ozhangasht.com/organizations" class="text-top-item-link">
                            فرم ساین سازمان ها
                        </a>
                    </div>
                    <div class="parent-footer-social">
                        <div class="text-footer-social">
                            مارا دنبال کنید:
                        </div>
                        <div class="box-item-social">
                            <a href="https://instagram.com/ozhangasht?igshid=YmMyMTA2M2Y=" class="footer-social-item">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="https://t.me/ozhangasht" class="footer-social-item">
                                <i class="fab fa-telegram"></i>
                            </a>
                            <a href="####" class="footer-social-item">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{*        <div class="footer-bottom">*}
{*            <div class="container">*}
{*                <div class="paren-grid">*}
{*                    <div class="footer-bottom-cod">*}
{*                        <h3>مشترک خبرنامه ما شوید</h3>*}
{*                        <div class="parent-code-footer-bottom">*}
{*                            <form>*}
{*                                <input placeholder="آدرس ایمیل شما">*}
{*                                <button>*}
{*                                    <i class="fa-sharp fa-solid fa-envelope"></i>*}
{*                                    اشتراک*}
{*                                </button>*}
{*                            </form>*}
{*                        </div>*}
{*                    </div>*}
{*                    <div class="footer-bottom-data-phone">*}
{*                        <h3>با ما در تماس باشید</h3>*}
{*                        <div class="parent-phone-email">*}
{*                            <span>*}
{*                                <i class="fa-sharp fa-solid fa-phone"></i>*}
{*                                <a href="tel:۰۷۶۹۱۰۰۱۱۷۷" class="">۰۷۶۹۱۰۰۱۱۷۷</a>*}
{*                            </span>*}
{*                            <span>*}
{*                                <i class="fa-sharp fa-solid fa-envelope"></i>*}
{*                                <a href="mailto:info@ozhangasht.com" class="">info@ozhangasht.com</a>*}
{*                            </span>*}
{*                        </div>*}
{*                        <div class="parent-address">*}
{*                            <span>*}
{*                                <i class="fa-solid fa-location-dot"></i>*}
{*                                <a href="" class="">جزیره کیش ،خانه گستر ، خیابان عطار نیشابوری ، مجتمع خدماتی TS-77</a>*}
{*                            </span>*}
{*                        </div>*}
{*                    </div>*}
{*                </div>*}
{*            </div>*}
{*        </div>*}
        <div class="footer-iran">
            <div class="container">
                <div class="parent-footer-iran">
                    <div class="ozhan-footer">
                        <span>
                            تمامی حقوق این وب سایت متعلق است به
                        </span>
                        <a href="" class="">
                            آژانس هواپیمایی و گردشگری اوژن گشت کیش
                        </a>
                    </div>
                    <div class="ozhan-footer">
                        <span>
                            <a href="https://iran-tech.com" class="">
                                طراحی رزواسیون:
                            </a>
                        </span>
                            ایران تکنولوژی
                    </div>
                </div>
            </div>
        </div>
    </footer>

{/if}
{else}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}
{/if}
</body>

{literal}
    <script src="project_files/js/bootstrap.min.js"></script>
<script src="project_files/js/mega-menu.js"></script>
<script src="project_files/js/script.js"></script>
{/literal}
{if $smarty.const.GDS_SWITCH neq 'app'}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
{/if}

</html>