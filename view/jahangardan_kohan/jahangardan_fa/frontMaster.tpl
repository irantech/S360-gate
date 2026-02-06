{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="dateTimeSetting" assign="objDate"}
{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{if $smarty.session.userId neq ''}
    {assign var="userInfo" value=functions::infoMember($smarty.session.userId)}
    {assign var="hashedPass" value=functions::HashKey({$userInfo['email']},'encrypt')}
{/if}
<!DOCTYPE html>
<html lang="fa-IR" dir="rtl">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>{$obj->Title_head()}</title>
    <base href="{$smarty.const.CLIENT_DOMAIN}"/>
    <link rel="shortcut icon" type="image/png" href="project_files/fa/images/favicon.png">
    <link rel="stylesheet" href="project_files/fa/css/all.css">
    <link rel="stylesheet" href="project_files/fa/css/header.css">
    <link rel="stylesheet" href="project_files/fa/css/bootstrap.css">
    <link rel="stylesheet" href="project_files/fa/css/style.css">

    <link rel="stylesheet" type="text/css" href="https://parvaz.ir/fa/user/GlobalFile/css/register.css">

    {literal}
        <script src="project_files/fa/js/jquery-3.6.0.min.js"></script>
    {/literal}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}


</head>
<body>
<header class="header_area">
    <div class="main_header_area animated h-100" id="navbar">
        <div class="container h-100">
            <nav id="navigation1" class="h-100 navigation d-flex justify-content-between align-items-center">
                <div class="nav-header">
                    <a class="nav-brand" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                        <img src="project_files/fa/images/logo.png" alt="{$obj->Title_head()}">
                    </a>
                </div>
                <div class="nav-menus-wrapper d-flex align-items-start flex-column ml-auto mr-4" >
                    <ul class="nav-menu align-to-right">
                        <!--                        <li><a href="javascript:"></a>-->
                        <!--                            <ul class="nav-dropdown">-->
                        <!--                                <li><a href="javascript:"></a>-->
                        <!--                                    <ul class="nav-dropdown">-->
                        <!--                                        <li><a href="javascript:"></a>-->
                        <!--                                            <ul class="nav-dropdown">-->
                        <!--                                                <li><a href="javascript:"></a></li>-->
                        <!--                                            </ul>-->
                        <!--                                        </li>-->
                        <!--                                    </ul>-->
                        <!--                                </li>-->
                        <!--                            </ul>-->
                        <!--                        </li>-->
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/cancellationFee">درصد جریمه کنسلی</a></li>
                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/article">مجله پرواز</a></li>
                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/article/categories/articles/articleDetail/6">ترمینال پرواز</a></li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a></li>
                        <li><a  href="https://charge.sep.ir/Eshop/KH71ggU85D">پرداخت شارژ</a></li>
                        <li><a href="javascript:">درباره ما</a>
                            <ul class="nav-dropdown">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/loginUser" >باشگاه مشتریان</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/rules">قوانین و مقررات</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/aboutus">درباره ما</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/contactus">تماس با ما</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <span class="stop-propagation btns_header mr-auto d-flex position-relative">
                    <a href="tel:{$smarty.const.CLIENT_MOBILE}" class="buttonfa-headset button ml-1"> <i class="fa-regular fa-headset ml-1"></i> {$smarty.const.CLIENT_MOBILE} </a>
                    <a href="javascript:" class="main-navigation__button2 button">
                        <i class="far fa-user ml-1"></i>
                        {include file="`$smarty.const.FRONT_THEMES_DIR`jahangardan_kohan/jahangardan_fa/topBarName.tpl"}

                    </a>
                    <div class="main-navigation__sub-menu2 arrow-up" style="display: none">

                        {include file="`$smarty.const.FRONT_THEMES_DIR`jahangardan_kohan/jahangardan_fa/topBar.tpl"}

                    </div>
                </span>
                <div class="nav-toggle mr-2"></div>
            </nav>
        </div>
    </div>
</header>


<div class="content_tech d-flex flex-wrap mt-3">

    <div class="container">
        <div class="temp-wrapper">
            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
        </div>

    </div>
</div>

{if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan && $smarty.const.GDS_SWITCH neq 'app'}

<footer class="footer">
    <div class="but-top" id="scroll-top"><a href="javascript:" class="fa fa-angle-up"></a></div>

    <div class="footer_main container">
        <ul class="m-0 p-0 d-flex">
            <li class="col-12 col-md-6 my-4 col-lg-4 call">
                <h6>تماس با ما</h6>
                <span> <i class="far fa-map-marker"></i> آدرس: {$smarty.const.CLIENT_ADDRESS}</span>
                <span> <i class="far fa-phone"></i>
                    شماره :
                    <a href="tel:{$smarty.const.CLIENT_MOBILE}">{$smarty.const.CLIENT_MOBILE}</a>
                </span>
                <span> <i class="far fa-phone"></i>
                    شماره :
                    <a href="tel:{$smarty.const.CLIENT_PHONE}">{$smarty.const.CLIENT_PHONE}</a>
                </span>
                <span>
                     <i class="far fa-envelope"></i>
                    ایمیل :
                    <a href="mailto:{$smarty.const.CLIENT_EMAIL}">{$smarty.const.CLIENT_EMAIL}</a>
                </span>
                <div class="footer_icons">
                    <a rel="nofollow"  target="_blank" class="SMInstageram fab fa-instagram footer_instagram"></a>
                    <a rel="nofollow" target="_blank" class="SMWhatsApp fab fa-whatsapp footer_whatsapp"></a>
                    <a rel="nofollow" target="_blank" class="SMTelegram fab fa-telegram footer_telegram"></a>
                </div>
            </li>
            <li class="col-12 col-md-6 my-4 col-lg-4">
                <h6>دسترسی آسان</h6>
                <div class="asan">
                    <a class="asan_link" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/article">مجله پرواز</a>
                    <a class="asan_link" href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a>
                    <a class="asan_link" href="{$smarty.const.ROOT_ADDRESS}/loginUser">باشگاه مشتریان</a>
                    <a class="asan_link" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/rules">قوانین و مقررات</a>
                    <a class="asan_link" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/aboutus">درباره ما</a>
                    <a class="asan_link" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/contactus">تماس با ما</a>
                </div>
            </li>
            <li class="col-12 col-md-6 my-4 col-lg-4 d-flex flex-column">
                {*<h6>کد رهگیری</h6>*}
                {*<form class="TrcBox w-100" action="/refrense/پیگیری-کد-رهگیری" method="get" name="FormCodeRahgiriPrj" id="FormCodeRahgiriPrj" style="width: 100%;">*}
                    {*<div class="code" style="margin-top: 1rem;">*}
                        {*<input id="txtsearch" aria-describedby="basic-addon1" type="text" name="CodeRahgiriTemp" onfocus="{this.value='';}" onblur="if (this.value==''){this.value='کد رهگیری خود را وارد کنید...';}" value="کد رهگیری خود را وارد کنید..." autocomplete="off">*}
                        {*<button class="btn button-winona" type="submit">*}
                            {*<i class="fas fa-check"></i>*}
                        {*</button>*}
                    {*</div>*}
                {*</form>*}
                <div class="namads">
                    <a href="javascript:"><img src="project_files/fa/images/Enamad1.png" alt="Enamad1"></a>
                    <a href="javascript:"><img src="project_files/fa/images/namad-1.png" alt="namad-1"></a>
                    <a href="javascript:"><img src="project_files/fa/images/Enamad2.png" alt="namad-2"></a>
                    <a href="javascript:"><img src="project_files/fa/images/namad-3.png" alt="namad-3"></a>
                </div>
            </li>
        </ul>
    </div>
    <div class="last_text col-12">
        <a class="last_a" href="https://www.iran-tech.com/" target="_blank">طراحی سایت گردشگری</a>
        <p class="last_p_text">: ایران تکنولوژی</p>
    </div>
</footer>
{/if}

</body>

{literal}
<script src="project_files/fa/js/bootstrap.bundle.js"></script>
<script src="project_files/fa/js/megamenu.js"></script>
<script src="project_files/fa/js/select2.min.js"></script>
<script src="project_files/fa/js/script.js"></script>
{/literal}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
</html>