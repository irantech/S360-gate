{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="dateTimeSetting" assign="objDate"}
{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{if $smarty.session['userId'] }
    {assign var="userInfo" value=functions::infoMember($smarty.session.userId)}
    {assign var="hashedPass" value=functions::HashKey({$userInfo['email']},'encrypt')}
{/if}

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="description" content="{$obj->Title_head()}">
    <title>{$obj->Title_head()}</title>
    <base href="{$smarty.const.CLIENT_DOMAIN}"/>
    <link rel="shortcut icon" type="image/png" href="project_files/images/favicon.png">

    <link rel="stylesheet" type="text/css" href="https://jazirehganj.com/fa/user/GlobalFile/css/register.css">

    <link rel="stylesheet" href="project_files/css/all.css">
    <link rel="stylesheet" href="project_files/css/bootstrap.css">
    <link rel="stylesheet" href="project_files/css/header.css">
    <link rel="stylesheet" href="project_files/css/style.css">
    {literal}
        <script src="project_files/js/jquery-3.6.0.min.js"></script>
    {/literal}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}


</head>
<body>
<header class="header_area">
    <div class="main_header_area animated">
        <div class="w-100">
            <div class="header_top">
                <div class="container d-flex align-items-center justify-content-between  h-100">
                    <div class="d-flex">
                        <a class="best_btn_first best_btn ml-2" href="tel:{$smarty.const.CLIENT_PHONE}"><i class="far fa-phone"></i><span>{$smarty.const.CLIENT_PHONE}</span></a>
                        <a class="best_btn" href="https://sadadpsp.ir/tollpayment"><i class="far fa-money-bill"></i><span>پرداخت عوارض خروج از کشور</span></a>
                    </div>
                    <div>
                        <div class="but_log2 but_log justify-content-start align-items-center">
                            <a class="aparat" href="javascript:">
                                <svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 530.9 530.9" width="16px" height="16px">
                                    <path d="M348 527.8L50.5 436.9c-37.6-11.5-58.8-51.3-47.3-89L94 50.5c11.5-37.6 51.3-58.8 89-47.3L480.5 94c37.6 11.5 58.8 51.3 47.3 89l-90.9 297.5c-11.5 37.6-51.3 58.8-88.9 47.3z"/>
                                    <circle class="st0" cx="265.5" cy="265.5" r="226.8"/>
                                    <circle class="st1" cx="265.5" cy="265.5" r="28.4"/>
                                    <path class="st1" d="M182.4 216.6c-34.3-8.2-55.4-42.6-47.3-76.8 8.2-34.3 42.6-55.4 76.8-47.3 34.3 8.2 55.4 42.6 47.3 76.8-8.1 34.2-42.5 55.4-76.8 47.3zM361.7 259.2c-34.3-8.2-55.4-42.6-47.3-76.8 8.2-34.3 42.6-55.4 76.8-47.3 34.3 8.2 55.4 42.6 47.3 76.8-8.2 34.3-42.6 55.5-76.8 47.3zM139.7 395.8c-34.3-8.2-55.4-42.6-47.3-76.8 8.2-34.3 42.6-55.4 76.8-47.3 34.3 8.2 55.4 42.6 47.3 76.8-8.1 34.3-42.5 55.5-76.8 47.3zM319 438.5c-34.3-8.2-55.4-42.6-47.3-76.8 8.2-34.3 42.6-55.4 76.8-47.3 34.3 8.2 55.4 42.6 47.3 76.8-8.1 34.3-42.5 55.5-76.8 47.3z"/>
                                </svg>
                            </a>
                            <a href="javascript:" class="fab fa-youtube SMTelegram pointer"></a>
                            <a class="fab fa-instagram SMInstageram pointer"></a>
                            <a class="fab fa-whatsapp SMWhatsApp pointer"></a>
                            <a class="fab fa-telegram SMTelegram pointer"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container" id="navbar">
                <nav id="navigation1" class="navigation">
                    <div class="nav-header">
                        <a class="nav-brand" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}">
                            <img src="project_files/images/logo.png" alt="{$obj->Title_head()}">
                        </a>
                    </div>
                    <div class="nav-menus-wrapper mr-auto">
                        <ul class="nav-menu align-to-right">
                            <li><a href="javascript:">تور </a>
                                <ul class="nav-dropdown">
                                    <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/countrytour/1"> خارجی</a></li>
                                    <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/irantourcity/1"> داخلی</a>

                                    </li>
                                </ul>
                            </li>
                            <li><a href="javascript:">تور طبیعت گردی</a>
                                <ul class="nav-dropdown">
                                    <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/countrytour/7"> خارجی</a></li>
                                    <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/irantourcity/2"> داخلی</a>
                                        {*<ul class="nav-dropdown">*}
                                            {*<li><a href="javascript:">مشهد</a>*}
                                                {*<ul class="nav-dropdown">*}
                                                    {*<li><a href="javascript:">مشهد</a></li>*}
                                                {*</ul>*}
                                            {*</li>*}
                                        {*</ul>*}
                                    </li>
                                </ul>
                            </li>
                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/flight">پرواز</a></li>
                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/hotel">هتل ها</a></li>
                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/visacountry">ویزا</a></li>
                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/article">وبلاگ</a></li>
                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/rules">قوانین و مقررات</a></li>
                            <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a></li>
                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/aboutus">درباره ما</a></li>
                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/contactus">تماس با ما</a></li>
                        </ul>
                    </div>
                    <a class="button font_size_main py-2 stop-propagation button_C main-navigation__button2" href="javascript:">

                        {include file="`$smarty.const.FRONT_THEMES_DIR`jazire_ganj/topBarName.tpl"}

                        <div class="button-chevron-2 "></div>
                    </a>
                    <div class="main-navigation__sub-menu2 arrow-up" style="display: none">

                        {include file="`$smarty.const.FRONT_THEMES_DIR`jazire_ganj/topBar.tpl"}

                    </div>
                    <div class="nav-toggle mr-2"></div>
                </nav>
            </div>
        </div>
    </div>
</header>


<div class="content_tech mt-2">

    <div class="container">
        <div class="temp-wrapper">
            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
        </div>

    </div>
</div>

{if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan && $smarty.const.GDS_SWITCH neq 'app'}

<footer>
    <a href="javascript:" id="scroll-top" data-type="section-switch" class="scrollup back-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <div class="container d-flex flex-wrap">
        <ul class="d-flex flex-wrap p-0 m-0">
            <li class="col-lg-4 col-md-6 my-3 col-12">
                <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}" class="logo_footer"><img src="project_files/images/logo.png" alt="{$obj->Title_head()}"></a>
                <div class="but_log d-flex justify-content-start align-items-center">
                    <a class="aparat" href="javascript:">
                        <svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 530.9 530.9" width="16px" height="16px">
                            <path d="M348 527.8L50.5 436.9c-37.6-11.5-58.8-51.3-47.3-89L94 50.5c11.5-37.6 51.3-58.8 89-47.3L480.5 94c37.6 11.5 58.8 51.3 47.3 89l-90.9 297.5c-11.5 37.6-51.3 58.8-88.9 47.3z"/>
                            <circle class="st0" cx="265.5" cy="265.5" r="226.8"/>
                            <circle class="st1" cx="265.5" cy="265.5" r="28.4"/>
                            <path class="st1" d="M182.4 216.6c-34.3-8.2-55.4-42.6-47.3-76.8 8.2-34.3 42.6-55.4 76.8-47.3 34.3 8.2 55.4 42.6 47.3 76.8-8.1 34.2-42.5 55.4-76.8 47.3zM361.7 259.2c-34.3-8.2-55.4-42.6-47.3-76.8 8.2-34.3 42.6-55.4 76.8-47.3 34.3 8.2 55.4 42.6 47.3 76.8-8.2 34.3-42.6 55.5-76.8 47.3zM139.7 395.8c-34.3-8.2-55.4-42.6-47.3-76.8 8.2-34.3 42.6-55.4 76.8-47.3 34.3 8.2 55.4 42.6 47.3 76.8-8.1 34.3-42.5 55.5-76.8 47.3zM319 438.5c-34.3-8.2-55.4-42.6-47.3-76.8 8.2-34.3 42.6-55.4 76.8-47.3 34.3 8.2 55.4 42.6 47.3 76.8-8.1 34.3-42.5 55.5-76.8 47.3z"/>
                        </svg>
                    </a>
                    <a href="javascript:" class="fab fa-youtube SMTelegram pointer"></a>
                    <a  class="fab fa-instagram SMInstageram pointer"></a>
                    <a  class="fab fa-whatsapp SMWhatsApp pointer"></a>
                    <a  class="fab fa-telegram SMTelegram pointer"></a>
                </div>
{*                <div class="code mt-auto">*}
{*                    <input id="txtsearch" aria-describedby="basic-addon1" type="text" name="CodeRahgiriTemp" onfocus="{this.value='';}" onblur="if (this.value==''){this.value='کد رهگیری خود را وارد کنید...';}" value="کد رهگیری خود را وارد کنید..." autocomplete="off">*}
{*                    <button class="btn button-winona" type="submit">*}
{*                        <i class="fas fa-check"></i>*}
{*                    </button>*}
{*                </div>*}
            </li>
            <li class="col-lg-4 col-md-6 my-3 col-12">
                <div class="Asan">
                    <a class="Asan_a" href="tel:{$smarty.const.CLIENT_MOBILE}"> <i class="fal fa-mobile"></i> {$smarty.const.CLIENT_MOBILE} </a>
                    <a class="Asan_a" href="tel:{$smarty.const.CLIENT_PHONE}"> <i class="far fa-phone-rotary"></i> {$smarty.const.CLIENT_PHONE} </a>
                    <a class="Asan_a w-100" href="mailto:{$smarty.const.CLIENT_EMAIL}"> <i class="far fa-envelope"></i> {$smarty.const.CLIENT_EMAIL} </a>
                    <address class="col-12 p-0 pl-md-5">
                        <i class="far fa-map-marker"></i>
                        آدرس : {$smarty.const.CLIENT_ADDRESS}
                    </address>
                </div>
            </li>

            <li class="asann col-lg-2 col-md-6 my-3 col-12 flex-column">
                <a class="Asan_a w-100" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/rules"> <i class="fal fa-angle-left"></i> قوانین و مقررات </a>
                <a class="Asan_a w-100" href="{$smarty.const.ROOT_ADDRESS}/loginUser"> <i class="fal fa-angle-left"></i> باشگاه مسافران </a>
                <a class="Asan_a w-100" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/aboutus"> <i class="fal fa-angle-left"></i> درباره ما </a>
                <a class="Asan_a w-100" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/contactus"> <i class="fal fa-angle-left"></i> تماس با ما </a>
            </li>
            <li class="col-lg-2 col-md-6 my-3 col-12 d-inline">
                <ul class="d-flex flex-wrap list-unstyled m-0 p-0 justify-content-between">
                    <div class="col-12 p-0 d-flex justify-content-center">
                        <li><a target="_blank" rel="nofollow" class="namad" href="http://aira.ir"><img src="project_files/images/hava.png" alt="Payment Icons"></a></li>
                        <li><a target="_blank" rel="nofollow" class="namad" href="https://www.cao.ir/"><img src="project_files/images/namad-2.png" alt="Payment Icons"></a></li>
                    </div>
                    <div class="col-12 p-0 d-flex justify-content-center">
                        <li><a target="_blank" rel="nofollow" class="namad" href="https://www.cao.ir/paxrights"><img src="project_files/images/namad-3.png" alt="Payment Icons"></a></li>
                        <li><a target="_blank" rel="nofollow" class="namad" href="https://www.mcth.ir"><img src="project_files/images/mirath.png" alt="Payment Icons"></a></li>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
</footer>
{/if}

<div class="w-100 mt-auto last">
                <span class="last_span">
                    <a class="last_a" href="https://www.iran-tech.com/" target="_blank">طراحی سایت گردشگری</a>
                    <p class="last_p_text">: ایران تکنولوژی</p>
                </span>
</div>
</body>
{literal}
<script src="project_files/js/select2.min.js"></script>
<script src="project_files/js/megamenu.js"></script>
<script src="project_files/js/script.js"></script>
{/literal}
{if $smarty.const.GDS_SWITCH neq 'app'}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
{/if}
</html>