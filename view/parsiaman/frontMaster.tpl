{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="dateTimeSetting" assign="objDate"}
{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{assign var="userInfo" value=functions::infoMember($smarty.session.userId)}
{assign var="hashedPass" value=functions::HashKey({$userInfo['email']},'encrypt')}
<!doctype html >
<html class="no-js" lang="fa">
<head>
    <!-- Required meta tags -->
    <title>{$obj->Title_head()}</title>
    <link rel="shortcut icon" type="image/x-icon" href="project_files/images/favicon.png"/>
    <meta name="description" content="{$obj->Title_head()}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <base href="{$smarty.const.CLIENT_DOMAIN}"/>
    <!-- Main CSS files -->
    <link rel="stylesheet" href="project_files/css/bootstrap.min.css">
    <link rel="stylesheet" href="project_files/css/all.min.css">
    <link rel="stylesheet" href="project_files/css/leaflet.css">
    <link rel="stylesheet" href="project_files/css/header.css">
    <link rel="stylesheet" href="project_files/css/style.css">
    <link rel="stylesheet" type="text/css" href="https://parsiamantravel.com/en/user/GlobalFile/css/register.css">




    {literal}
        <script  src="project_files/js/jquery-3.4.1.min.js"></script>
    {/literal}


    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}
</head>
<body>


<div id="sidebar_social">
    <div class="social facebook">
        <a class="SMFaceBook" href=" https://www.facebook.com" target="_blank">
            <p><i class="fab fa-facebook-f "></i></p>
        </a>
    </div>
    <div class="social instagram">
        <a class="SMInstageram" href=" https://www.instagram.com " target="_blank">
            <p><i class="fab fa-instagram"></i></p>
        </a>
    </div>
    <div class="social telegram">
        <a class="SMTelegram" href=" https://www.telegram.me " target="_blank">
            <p><i class="fab fa-telegram-plane"></i></p>
        </a>
    </div>
    <div class="social whatsapp">
        <a class="SMWhatsApp" href=" https://www.whatsapp.me " target="_blank">
            <p><i class="fab fa-whatsapp"></i></p>
        </a>
    </div>

    <div class="social linkedin">
        <a class="SMLinkdin" href=" https://www.linkedin.com " target="_blank">
            <p><i class="fab fa-linkedin-in"></i></p>
        </a>
    </div>
</div>
<header class="header_area">
    <div class="top_header">

        <div class="container-fluid">

            <div class="row">


                <div class="top_contact">
<!--                    <div class="email_top content_top">
                        <div>
                            <a href="mailto:{$smarty.const.CLIENT_EMAIL}"> {$smarty.const.CLIENT_EMAIL}</a>
                        </div>
                    </div>-->



                </div>

            </div>

        </div>

    </div>
    <div class="main_header_area animated">
        <div class="container-fluid">
            <nav id="navigation1" class="navigation">

                <div class="top_logo">
                    <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/"><img src="project_files/images/logo.png" alt=""></a>
                </div>

                <div class="nav-header">
                    <div class="nav-toggle"></div>
                </div>


                <div class="nav-menus-wrapper">
                    <ul class="nav-menu">
                        <li class="submenu_"><a href="javascript:;">Tours</a>

                            <ul class="nav-dropdown">

                                {foreach key=key_tour item=item_tour from=$objResult->GetToursReservationByType('', 'limit 0,6')}
                                    <li>

                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/{$smarty.now|date_format:"%F"}/{$item_tour.tour_type_id}">
                                            {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour['getTourType']['tour_type'] : $item_tour['getTourType']['tour_type_en']}
                                        </a>
                                    </li>
                                {/foreach}

                            </ul>




                        </li>
                        <li><a href="javascript:;">Daily Tours</a>
                            <ul class="nav-dropdown">
                                {foreach key=key_tour item=item_tour from=$objResult->GetGdsCityForTour('', 'return',false,true)}
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/1-{$item_tour.id}/{date("Y-m-d")}/all">
                                            {$item_tour.name_en}
                                        </a>
                                    </li>
                                {/foreach}
                            </ul>
                        </li>
                        <li><a href="javascript:;">Services</a>
                            <ul class="nav-dropdown">
                                <li><a class="SMOrder" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/order">Visa</a>
                                <li><a class="SMOrder" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/order">Hotel Booking</a>
                                <li><a class="SMOrder" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/order">Flight Booking</a>
                                <li><a class="SMOrder" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/order">Train Booking</a>
                                <li><a class="SMOrder" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/order">Travel Insurance</a>
                                <li><a class="SMOrder" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/order">Tour Guide</a>
                                <li><a class="SMOrder" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/order">Translating Services</a>
                                <li><a class="SMOrder" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/order">CIP at IKIA</a>
                                <li><a class="SMOrder" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/order">Shopping</a>


                            </ul>
                        </li>
                        <li><a href="javascript:;"> Business Man </a>
                            <ul class="nav-dropdown">
                                <li><a class="SMOrder" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/order">Visa</a>
                                <li><a class="SMOrder" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/order">Hotel Booking</a>
                                <li><a class="SMOrder" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/order">Exhibition</a>
                                <li><a class="SMOrder" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/order">Translating Services</a>
                                <li><a class="SMOrder" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/order">Transfer Services</a>
                                <li><a class="SMOrder" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/order">Driver Guide</a>
                                <li><a class="SMOrder" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/order">CIP at IKIA</a>


                            </ul>
                        </li>
                        <li>
                            <a href="javascript:">Blog</a>
                            <ul class="nav-dropdown">
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/blog">Blog</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/aparat">Videos</a></li>
                                <li>
                                    <a class="SMAboutIran" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/aboutiran">About Iran</a>
                                </li>


                            </ul>

                        </li>
                        <li><a href="javascript:;">Souvenirs</a></li>
                        <li><a class="" href="{$smarty.const.ROOT_ADDRESS}/UserTracking"> Refund Tracking </a></li>
                        <li><a class="SMGallery" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/irangallery"> Gallery </a></li>

                        <li><a href="javascript:;">About</a>

                            <ul class="nav-dropdown">
                                <li><a class="SMRules" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/rules">Rules</a>
                                <li><a class="SMAbout" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/aboutus">About Us</a>
                                <li><a class="SMContactUs" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/contactus">Contact Us</a>
                            </ul>

                        </li>
                    </ul>
                </div>


                <div class="search_icon">
                    <a class="email_header_link d-sm-flex d-none" href="mailto:montazer2533@gmail.com">montazer2533@gmail.com</a>

                    <div class="login_top content_top">
                        <div class="menu-login">
                            <div class="c-header__btn">
                                <div class="c-header__btn-login" href="javascript:;">

                                    {include file="`$smarty.const.FRONT_THEMES_DIR`parsiaman/topBarName.tpl"}

                                </div>
                                <div class="main-navigation__sub-menu2 arrow-up">
                                    {include file="`$smarty.const.FRONT_THEMES_DIR`parsiaman/topBar.tpl"}

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="languages_header position-relative">

                        <button class="fa fa-language"></button>

                        <ul>
                            <li><a href="javascript:">Ch</a></li>
                            <li><a href="javascript:">Fa</a></li>
                            <li><a href="javascript:">En</a></li>
                        </ul>
                    </div>


                </div>

            </nav>
        </div>
    </div>
</header>





    <div class="container">

            <div class="row center-eleman">
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
            </div>

    </div>


{if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
<footer id="dk-footer" class="dk-footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-4">
                <div class="dk-footer-box-info">
                    <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/" class="footer-logo">
                        <img src="project_files/images/logo.png" alt="footer_logo" class="img-fluid">
                    </a>
                    <p class="footer-info-text">
                        {$smarty.const.ABOUT_ME}
                    </p>
                    <div class="footer-social-link">
                        <h3>Follow us</h3>
                        <ul>
                            <li>
                                <a class="SMFaceBook" href="#">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                            <li>
                                <a class="SMTwitter" href="#">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a class="SMTelegram" href="#">
                                    <i class="fab fa-telegram-plane"></i>
                                </a>
                            </li>
                            <li>
                                <a class="SMLinkdin" href="#">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </li>
                            <li>
                                <a class="SMInstageram" href="#">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="col-md-12 col-lg-8">
                <div class="row">


                    <div class="col-md-6 col-sm-6">
                        <div class="contact-us contact-us-last">
                            <div class="contact-icon">
                                <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                            </div>

                            <div class="contact-info">
                                <h3 ><a href="" class="SMFooterPhone">{$smarty.const.CLIENT_PHONE}</a></h3>
                                <p>Give us a call</p>
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="contact-us">
                            <div class="contact-icon">
                                <i class="far fa-map"></i>
                            </div>

                            <div class="contact-info">

                                <p class="SMFooterAddress">{$smarty.const.CLIENT_ADDRESS_EN}</p>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <div class="footer-widget footer-left-widget">
                            <div class="section-heading">
                                <h3>Useful Links</h3>
                                <span class="animate-border border-black"></span>
                            </div>
                            <ul>
                                <li>
                                    <a class="SMAbout" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/aboutus">About us</a>
                                </li>
                                <li>
                                    <a class="SMOrder" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/order">Services</a>
                                </li>
                                <li>
                                    <a class="SMWeather" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/weather">Weather</a>
                                </li>
                                <li>
                                    <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/worldclock">World Clock</a>
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    <a class="SMContactUs" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/contactus">Contact us</a>
                                </li>
                                <li>
                                    <a class="SMBlog" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/blog">Blog</a>
                                </li>
                                <li>
                                    <a class="SMAboutIran" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/aboutiran">About Iran</a>
                                </li>
                                <li>
                                    <a class="SMFaq" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/staff">Staff</a>
                                </li>
                            </ul>

                        </div>

                    </div>

                    <div class="col-md-12 col-lg-6">
                        <div class="footer-widget">
                            <div id="gmap"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <ul class="logos">
                <li><a href=""><img src="project_files/images/enamad.jpg" alt=""></a></li>
                <li><a href=""><img src="project_files/images/samandehi-1.png" alt=""></a></li>
            </ul>

        </div>
    </div>


    <div class="copyright">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 copy_right">
                    <span>Web Designed By : <a href="https://www.iran-tech.com/"> Iran Technology</a></span>
                </div>



            </div>

        </div>

    </div>

    <div id="back-to-top" class="back-to-top">
        <button class="btn btn-dark" title="Back to Top">
            <i class="fa fa-angle-up"></i>
        </button>
    </div>

</footer>

{/if}
{literal}


    <script  src="project_files/js/megamenu.js"></script>
    <script  src="project_files/js/leaflet.js"></script>
    <script  src="project_files/js/scripts.js"></script>
    <script  src="project_files/js/bootstrap.bundle.min.js"></script>



{/literal}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}

</body>
</html>