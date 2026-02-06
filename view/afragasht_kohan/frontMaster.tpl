{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{assign var="hashedPass" value=functions::HashKey({$smarty.session.cardNo},'encrypt')}
<!doctype html>
<html style="overflow-x: hidden" lang="fa">

<head>
    <title>{$obj->Title_head()}</title>

    <link rel="shortcut icon" type="image/x-icon" href="project_files/images/log1o.png"/>
    <meta name="description" content="{$obj->Title_head()}">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta charset="UTF-8">
    <base href="{$smarty.const.CLIENT_DOMAIN}"/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="project_files/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="project_files/css/nanoscroller.css">
    <link rel="stylesheet" type="text/css" href="project_files/css/icofont.min.css">
    <link rel="stylesheet" href="project_files/css/fontawesome.min.css">
    <link rel="stylesheet" type="text/css" href="project_files/css/style.css">
    <link rel="stylesheet" type="text/css" href="project_files/css/style-responsive.css">
    <link rel="stylesheet" type="text/css" href="project_files/css/ownerStyle.css">
    <link rel="stylesheet" type="text/css" href="project_files/css/select2.css">
    <link rel="stylesheet" type="text/css" href="project_files/css/header.css">

    <script type="text/javascript" src="project_files/js/jquery-2.1.4.min.js"></script>

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}

</head>

<body class="temp_afragasht">


<div class="background-modal-box">
</div>

{if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation}


    <header  class="header_area">

        <div class="main_header_area animated">
            <div class="container">
                <div class="top_bar ">

                    {include file="topBar.tpl"}

                </div>

                <nav id="navigation1" class="navigation">
                    <!-- Logo Area Start -->
                    <div class="nav-header">
                        <a class="nav-brand" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/">

                            <img src="project_files/images/logo.png" alt="افراگشت کهن">

                        </a>
                        <div class="nav-toggle"></div>
                    </div>

                    <div class="nav-menus-wrapper">
                        <ul class="nav-menu ">
                            <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/">صفحه اصلی</a></li>
                            <li class="toursmenu"><a href="javascript:;">تور ها</a>
                                <ul class="nav-dropdown">
                                    <li><a class="SMTourLocal" href="javascript:;"> تورهای داخلی</a>

                                        <ul class="nav-dropdown">
                                            <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=irantourcity&level=1">کلیه تورها </a></li>
                                        </ul>

                                    </li>
                                    <li><a class="SMTourPortal" href="javascript:;"> تورهای خارجی</a>
                                        <ul class="nav-dropdown">

                                            <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=countrytour&level=1">کلیه تورها </a></li>

                                        </ul>

                                    </li>
                                    <li><a class="" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=irantourcity&level=6"> تورهای گروهی</a></li>
                                    <li><a class="SMTourLastsecond" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=tourlastsecond"> ﺗﻮر ارزان و ﻟﺤﻈﻪ آﺧﺮی </a></li>
                                    <li><a class="SMAllTours" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=alltours"> ﺗﻮرﻫﺎ در ﯾﮏ ﻧﮕﺎه </a></li>




                                </ul>
                            </li>

                            <li class="hotelsmenu"><a href="javascript:;">هتل ها</a>
                                <ul class="nav-dropdown">
                                    <li><a href="javascript:;"> هتل های داخلی</a>
                                        <ul class="nav-dropdown">

                                            <li class="_li_active"><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=iranhotelcity">کلیه هتل ها </a></li>

                                        </ul>
                                    </li>
                                    <li><a  href="javascript:;"> هتل های خارجی</a>

                                        <ul class="nav-dropdown">

                                            <li class="_li_active"><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=hotelcountry">کلیه هتل ها </a></li>

                                        </ul>

                                    </li>



                                </ul>
                            </li>



                            <li>
                                <a class="SMNews" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=news"> اخبار سایت</a>
                            </li>
                            <li>
                                <a class="SMRules" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=news"> قوانین و مقررات</a>
                            </li>
                            {*<li>*}
                                {*<a class="" href="{$smarty.const.ROOT_ADDRESS}/UserTracking">*}
                                    {*پیگیری / کنسلی </a>*}
                            {*</li>*}
                            <li>
                                <a  href="javascript:;">آژانس افراگشت کهن</a>
                                <ul class="nav-dropdown">
                                    <li>
                                        <a class="SMAbout" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=aboutus"> درباره ما</a>
                                    </li>
                                    <li>
                                        <a class="SMContactUs" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=contactus">تماس با ما </a>
                                    </li>

                                </ul>
                            </li>




                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>
  
    <header style="display:none;" class="header scrolled">
        <div class="container">
            <div class="top_bar ">

                {include file="topBar.tpl"}

            </div>
            <nav class="main-nav">
                <div class="row">
                    <div class="col main_nav_col d-flex flex-row align-items-center justify-content-start">
                        <div class="logo">
                            <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/">
                                <img src="project_files/images/logo.png" alt="">
                            </a>
                        </div>
                        <div class="hamburger mr-lg-0 mr-auto d-md-block d-lg-none">
                            <i class="fa fa-bars trans_200"></i>
                        </div>
                        <div class="mainnav mr-auto">
                            <ul>
                                <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/">صفحه اصلی</a>
                                </li>

                                <li class="has-sub"><a href="javascript:;">تورها <i class="fas fa-angle-down"
                                                                                    aria-hidden="true"></i></a>
                                    <div class="submenu">
                                        <ul>
                                            <li><a class="SMTourLocal" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=irantourcity&level=1"> تورهای داخلی</a></li>
                                            <li><a class="SMTourPortal" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=countrytour&level=1"> تورهای خارجی</a></li>
                                            <li><a class="" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=irantourcity&level=6"> تورهای گروهی</a></li>
                                            <li><a class="SMTourLastsecond" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=tourlastsecond"> ﺗﻮرﻫﺎی وﻳﮋه و ﻟﺤﻈﻪ آﺧﺮی </a></li>
                                            <li><a class="SMAllTours" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=alltours"> ﺗﻮرﻫﺎ در ﯾﮏ ﻧﮕﺎه </a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="has-sub"><a href="javascript:;">هتل ها <i class="fas fa-angle-down"
                                                                                     aria-hidden="true"></i></a>
                                    <div class="submenu">
                                        <ul>
                                            <li><a class="SMHotelLocal" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=iranhotelcity"> هتل های داخلی</a></li>
                                            <li><a class="SMHotelPortal" href="temp.php?irantech_parvaz=hotelcountry"> هتل های خارجی</a></li>

                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <a class="SMNews" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=news"> اخبار سایت</a>
                                </li>
                                <li>
                                    <a class="SMRules" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=news"> قوانین و مقررات</a>
                                </li>
                                {*<li>*}
                                    {*<a class=""*}
                                       {*href="{$smarty.const.ROOT_ADDRESS}/UserTracking">*}
                                    {*پیگیری خرید </a>*}
                                {*</li>*}
                                <li>
                                    <a class="SMAbout" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=aboutus"> درباره ما</a>
                                </li>
                                <li>
                                    <a class="SMContactUs" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=contactus">تماس با ما </a>
                                </li>


                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>
{/if}



<div class="content-main  main_temp">
<div class="container">

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
</div>
</div>

{if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}

<footer>
    <div class="footer-top">
        <div class="container">
            <div class="row">

                <div class="col-md-6 about-us-sec">
                    <span class="h4">درباره ما</span>
                    <p>
                        {$smarty.const.ABOUT_ME}
                    </p>


                </div>
                <div class="col-md-6">
                    <div class="dastresi-sari">
                        <div class="row">
                            <div class="col-md-12"><span class="h4">   تماس با ما</span></div>

                            <ul class="contact_foo">
                                <li>
                                    <i class="fas fa-map-marker-alt"></i>

                                    <span class="SMFooterAddress">
                                        {$smarty.const.CLIENT_ADDRESS}
                                    </span>
                                </li>

                                <li>
                                    <i class="fas fa-phone"></i>

                                    <span>
                                        <a href="tel:{$smarty.const.CLIENT_PHONE}" class="SMFooterPhone">{$smarty.const.CLIENT_PHONE}</a>
                                    </span>
                                </li>

                                <li>
                                    <i class="fas fa-at"></i>

                                    <span>
                                        <a href="mailto:{$smarty.const.CLIENT_EMAIL}" class="SMFooterEmail">{$smarty.const.CLIENT_EMAIL}</a>
                                    </span>
                                </li>


                            </ul>

                            <ul class="certi_foo col-md-12">
                                <li>
                                    <a href="https://www.cao.ir/paxrights">
                                        <img src="project_files/images/certificate1.png" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.cao.ir/">
                                        <img src="project_files/images/certificate2.png" alt="">
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="col-md-6 iran-tech">
                    <div>کلیه حقوق این سایت متعلق به آژانس مسافرتی افرا گشت کهن می باشد</div>
                    <div><a title="طراحی سایت آژانس مسافرتی" href="https://www.iran-tech.com">طراحی سایت آژانس
                            مسافرتی</a>
                        ایران تکنولوژی
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="footer-links">
                        <a class="SMAbout" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=aboutus">درباره ما</a>
                        <a class="SMContactUs" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=contactus">تماس با ما</a>
                        <a class="SMRules" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=rules">قوانین و مقررات</a>

                    </div>
                </div>
            </div>

        </div>
    </div>

</footer>

{/if}



<a id="scroll-top" style="cursor: pointer;">
    <button><i class="fas fa-arrow-up"></i></button>
</a>


<script type="text/javascript" src="project_files/js/popper.min.js"></script>
{literal}

    <script type="text/javascript" src="project_files/js/select2.min.js"></script>
    <script>

        $(document).ready(function () {


            $(".hamburger").click(function() {
                $(".background-modal-box").show();
                $("nav.main-nav .mainnav").animate({
                    right: '0px'
                });
            });
            $(".background-modal-box").click(function() {
                $(this).hide();
                $("nav.main-nav .mainnav").animate({
                    right: '-245px'
                });
            });

            $(".has-sub a").click(function() {
                $(this).parents(".has-sub").find(".megasub").toggle();
                $(this).find(".icofont-rounded-down").toggleClass("rotate-45");
                $(this).parents(".has-sub").find(".submenu").toggle();
            });
        })
 $('.select2').select2();
    </script>
{/literal}
<script src="project_files/js/main.js"></script>
<script src="project_files/js/megamenu.js"></script>
<script src="project_files/js/modernizr.js"></script>
</body>

</html>