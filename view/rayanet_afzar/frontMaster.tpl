{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="dateTimeSetting" assign="objDate"}
{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{assign var="userInfo" value=functions::infoMember($smarty.session.userId)}
{assign var="hashedPass" value=functions::HashKey({$userInfo['email']},'encrypt')}
<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <base href="{$smarty.const.CLIENT_DOMAIN}"/>
    <link rel="shortcut icon" type="image/x-icon" href="project_files/images/favicon.png"/>
    <title>{$obj->Title_head()}</title>
    <link rel="stylesheet" href="project_files/css/all.min.css">
    <link rel="stylesheet" href="project_files/css/bootstrap.min.css">
    <link rel="stylesheet" href="project_files/css/header.css">


    <link rel="stylesheet" type="text/css" href="https://search.parsapp.org/fa/user/GlobalFile/css/register.css">

    {literal}
        <script  src="project_files/js/jquery-3.4.1.min.js"></script>
    {/literal}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}
</head>
<body style="font-family: $fontFamily !important;">
<header class="i_modular_menu header_area">
    <div class="main_header_area animated" id="navbar">
        <div class="w-100">
            <nav class="navigation d-flex justify-content-between w-100">
                <div class="nav-header">
                    <a class="d-flex align-items-center" href="https://parsapp.org/">
                        <img class="logo-white" src="project_files/images/logo.png" alt="img-logo">
                    </a>
                </div>
                <div class="nav-left">
                    <div class="parent-social">
                        <div class="parent-email-phone">
                            <a href="http://info@parsapp.org">
                                <i class="fa-solid fa-envelope"></i>
                                <span>info@parsapp.org</span>
                            </a>
                            <a href="tel:02191013580">
                                <i class="fa-solid fa-phone"></i>
                                <span>021-91013580</span>
                            </a>
                        </div>
                        <div class="social-icon">
                            <a href="https://parsapp.org/" class="">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                            <a href="https://t.me/fc_parseh_academy" class="">
                                <i class="fa-brands fa-telegram"></i>
                            </a>
                            <a href="https://parsapp.org/" class="">
                                <i class="fa-brands fa-linkedin-in"></i>
                            </a>
                            <a href="https://parsapp.org/" class="">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                    <div class="parent-menu">
                        <div class="nav-menus-wrapper">
                            <ul class="nav-menu">
                                <li>
                                    <a href="https://parsapp.org/panel/index.php">خدمات تلفن همراه و قبوض</a>
                                    <ul class="nav-dropdown nav-submenu">
                                        <li>
                                            <a href="https://parsapp.org/panel/index.php">
                                                شارژمستقیم
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://parsapp.org/panel/index.php">
                                                پین شارژ
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://parsapp.org/panel/index.php">
                                                بسته اینترنتی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://parsapp.org/panel/index.php">
                                                پرداخت قبوض
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="https://parsapp.org/panel/index.php"> گردشگری</a>
                                    <ul class="nav-dropdown nav-submenu">
                                        <li>
                                            <a href="https://parsapp.org/panel/index.php">
                                                پرواز داخلی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://parsapp.org/panel/index.php">
                                                پرواز خارجی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://parsapp.org/panel/index.php">
                                                اتوبوس
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://parsapp.org/panel/index.php">
                                                قطار
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://parsapp.org/panel/index.php">
                                                هتل داخلی
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="https://parsapp.org/panel/index.php">خودرویی</a>
                                    <ul class="nav-dropdown nav-submenu">
                                        <li>
                                            <a href="https://parsapp.org/panel/index.php ">
                                                استعلام خلافی خودرو
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://parsapp.org/panel/index.php">
                                                استعلام نمره منی گواهی نامه
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://parsapp.org/panel/index.php">
                                                استعلام عوارض شهری
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://parsapp.org/panel/index.php">
                                                استعلام عوارضی آزاد راه
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="https://parsapp.org/panel/index.php">خدمات نیکوکاری </a>
                                </li>
                                <li>
                                    <a href="https://parsapp.org/panel/index.php"> خدمات مالی</a>
                                    <ul class="nav-dropdown nav-submenu">
                                        <li>
                                            <a href="https://parsapp.org/panel/index.php ">
                                                کارت به کارت
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://parsapp.org/panel/index.php">
                                                شارژ کیف پول
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="https://parsapp.org/panel/index.php"> آکادمی  پارس اپ</a>
                                    <ul class="nav-dropdown nav-submenu">
                                        <li>
                                            <a href="https://parsapp.org/education.do ">
                                                سامانه آموزش مجازی ورزش
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://parsapp.org/counseling.do">
                                                سامانه مشاوره آنلاین ورزش
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://parsapp.org/panel/index.php">
                                                سامانه استعدادیابی ورزشی
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="box_button_header">
                            <a class="__login_register_class__ button_header logIn" href="https://online.parsapp.org/gds/fa/loginUser">
                                <i class="fa fa-user-plus"></i>
                                <span>ثبت نام</span>
                            </a>
                            <a class="__login_register_class__ button_header logIn" href="https://online.parsapp.org/gds/fa/registerUser">
                                <span>ورود به حساب کاربری</span>
                            </a>
                        </div>
                        <div class="nav-toggle mr-2">
                            <svg viewBox="0 0 448 512">
                                <path d="M0 80C0 71.16 7.164 64 16 64H432C440.8 64 448 71.16 448 80C448 88.84 440.8 96 432 96H16C7.164 96 0 88.84 0 80zM0 240C0 231.2 7.164 224 16 224H432C440.8 224 448 231.2 448 240C448 248.8 440.8 256 432 256H16C7.164 256 0 248.8 0 240zM432 416H16C7.164 416 0 408.8 0 400C0 391.2 7.164 384 16 384H432C440.8 384 448 391.2 448 400C448 408.8 440.8 416 432 416z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
<div class="" style="min-height: 100vh">
    {if $smarty.const.GDS_SWITCH eq 'app'  || $smarty.const.GDS_SWITCH eq 'page'}

        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl" obj=$obj}
    {else}


        <div  class="content_tech" style='margin-top : 100px'>
            <div class="container">

                {if $smarty.const.GDS_SWITCH neq 'mainPage' && $smarty.const.GDS_SWITCH neq 'page'}
                    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/rich/breadcrumb/main.tpl" obj_main_page=$obj_main_page}
                {/if}

                <div class="temp-wrapper">
                    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl" obj=$obj}
                </div>
            </div>
        </div>
    {/if}
</div>
<footer class="i_modular_footer position-relative footer-gisoo">
    <div class="div-footer-parent">
        <div class="container parent-contents">
            <div class="d-flex flex-wrap">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12 p-1">
                    <div class="box-item-footer text-right">
                        <h3> لینک های مفید </h3>
                        <ul>
                            <li>
                                <a href="https://parsapp.org/">
                                    <i class="fa-solid fa-angle-right"></i>
                                    خانه
                                </a>
                            </li>
                            <li>
                                <a href="https://parsapp.org/about.do">
                                    <i class="fa-solid fa-angle-right"></i>
                                    درباره ما
                                </a>
                            </li>
                            <li>
                                <a href="https://fcpars.ir/">
                                    <i class="fa-solid fa-angle-right"></i>
                                    باشگاه پارس برازجان
                                </a>
                            </li>
                            <li>
                                <a href="https://Dcpars.ir/">
                                    <i class="fa-solid fa-angle-right"></i>
                                    کلنیک دندانپزشکی پارس
                                </a>
                            </li>
                            <li>
                                <a href="https://parsapp.org/contact.do">
                                    <i class="fa-solid fa-angle-right"></i>
                                    تماس با ما
                                </a>
                            </li>
                        </ul>
                        <a referrerpolicy="origin" target="_blank" href="https://trustseal.enamad.ir/?id=443466&amp;Code=E987fjmN7GtKquQ5ifaXpTVSW6rBlR16"><img referrerpolicy="origin" src="https://trustseal.enamad.ir/Content/Images/Star2/81.png?v=5.0.0.3777" alt="" style="cursor:pointer" code="E987fjmN7GtKquQ5ifaXpTVSW6rBlR16"></a>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12 col-12 p-1">
                    <div class="box-item-footer text-right">
                        <h3>خدمات</h3>
                        <ul>
                            <li>
                                <a href="https://parsapp.org/panel/index.php">
                                    <i class="fa-solid fa-angle-right"></i>
                                    خدمات مالی
                                </a>
                            </li>
                            <li>
                                <a href="https://parsapp.org/panel/index.php">
                                    <i class="fa-solid fa-angle-right"></i>
                                    خدمات گردشگری
                                </a>
                            </li>
                            <li>
                                <a href="https://parsapp.org/panel/index.php">
                                    <i class="fa-solid fa-angle-right"></i>
                                    نيکوکاري و خدمات عام المنفعه
                                </a>
                            </li>
                            <li>
                                <a href="https://parsapp.org/panel/index.php">
                                    <i class="fa-solid fa-angle-right"></i>
                                    خدمات سلامت و بیمه
                                </a>
                            </li>
                            <li>
                                <a href="https://parsapp.org/panel/index.php">
                                    <i class="fa-solid fa-angle-right"></i>
                                    خدمات خودرويي
                                </a>
                            </li>
                            <li>
                                <a href="https://parsapp.org/panel/index.php">
                                    <i class="fa-solid fa-angle-right"></i>
                                    مرکز استعداديابي ورزشي پارس
                                </a>
                            </li>
                            <li>
                                <a href="https://parsapp.org/panel/index.php">
                                    <i class="fa-solid fa-angle-right"></i>
                                    آکادمی فوتبال پارس
                                </a>
                            </li>
                            <li>
                                <a href="https://parsapp.org/panel/index.php">
                                    <i class="fa-solid fa-angle-right"></i>
                                    مرکز مشاوره ورزشی پارس
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 col-12 p-1">
                    <div class="box-item-footer text-right">
                        <h3>تماس با ما</h3>
                        <div class="child-item-footer">
                            <i class="fa-light fa-location-dot"></i>
                            <span class="__address_class__">
                                      استان بوشهر -شهر برازجان -بلوار بسیج خیابان شهدای مدافع حرم باشگاه فرهنگی ورزشی پارس
                                </span>
                        </div>
                        <div class="child-item-footer">
                            <i class="fa-light fa-mobile"></i>
                            <a href="javascript:" class="">
                                02191013580
                            </a>
                        </div>
                        <div class="child-item-footer">
                            <i class="fa-light fa-envelope"></i>
                            <a href="javascript:" class="">
                                info@parsapp.org
                            </a>
                        </div>
                        <div class="footer-icon">
                            <a target="_blank" href="javascript:" class=" fa-brands fa-twitter footer_telegram"></a>
                            <a target="_blank" href="javascript:" class=" fa-brands fa-facebook-f footer_instagram"></a>
                            <a target="_blank" href="javascript:" class=" fa-brands fa-youtube footer_whatsapp" ></a>
                            <a target="_blank" href="javascript:" class=" fa-brands fa-linkedin-in footer_linkedin" ></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="last_text col-12">
                <p class="last_p_text">  حق نشر   ©  تمامی حقوق برای</p>
                <a class="last_a" href="https://parsapp.org/">  موسسه فرهنگی ورزشی پارس برازجان</a>
                <p class="last_p_text"> محفوظ است. </p>
            </div>
        </div>
    </div>
</footer>
</body>
<script src="project_files/js/bootstrap.min.js"></script>
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
<script src="project_files/js/header.js"></script>
<script src="project_files/js/select2.min.js"></script>
<script src="assets/main-asset/js/public-main.js" type="text/javascript"></script>
</html>