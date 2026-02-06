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
    <link rel="stylesheet" href="project_files/css/animate.min.css">
    <link rel="stylesheet" href="project_files/css/all.css" >
    <link rel="stylesheet" href="project_files/css/header.css">
    <link rel="stylesheet" href="project_files/css/icofont.min.css">
    <link rel="stylesheet" href="project_files/css/tabs.css">
    <link rel="stylesheet" href="project_files/css/slider.css">
    <link rel="stylesheet" href="project_files/css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css">
    <link rel="stylesheet" type="text/css" href="https://letsgotourist.ir/fa/user/GlobalFile/css/register.css">


    {literal}
        <script  src="project_files/js/jquery-3.4.1.min.js"></script>
    {/literal}


    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}
</head>
<body>
<header class="header_area">
    <div class="top_header">
        <div class="container">
            <div class="row align-items-center">
                <div class="right_top">
                    <ul>
                        <li><a  href="{$smarty.const.ROOT_ADDRESS}/loginUser"> باشگاه مشتریان</a></li>
                        <li><a class="SMBlog" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/blog"> وبلاگ </a></li>
                        <li><a class="SMRules" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/rules"> قوانین و مقررات </a></li>
                        <li class="andriod_link"><a href="javascript:;"> اندروید </a></li>
                        <li class="ios_link"><a href="javascript:;"> آی او اس </a></li>
                    </ul>
                </div>
                <div class="logo_top"><a class="" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/"> <img src="project_files/images/logo.png" alt="ایران تکنولوژی"> </a></div>
                <div class="lef_top">
                    <div class="act-buttons">
                        <div class="menu-login">
                            <div class="c-header__btn">
                                <div class="c-header__btn-login" href="javascript:;">
                                    <i class="login_icon">

                                        <svg version="1.1"   x="0px" y="0px"
                                             viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                            <g>
                                                <g>
                                                    <path d="M437.02,330.98c-27.883-27.882-61.071-48.523-97.281-61.018C378.521,243.251,404,198.548,404,148
                                                        C404,66.393,337.607,0,256,0S108,66.393,108,148c0,50.548,25.479,95.251,64.262,121.962
                                                        c-36.21,12.495-69.398,33.136-97.281,61.018C26.629,379.333,0,443.62,0,512h40c0-119.103,96.897-216,216-216s216,96.897,216,216
                                                        h40C512,443.62,485.371,379.333,437.02,330.98z M256,256c-59.551,0-108-48.448-108-108S196.449,40,256,40
                                                        c59.551,0,108,48.448,108,108S315.551,256,256,256z"/>
                                                </g>
                                            </g>

                                            </svg>
                                    </i>
                                    {include file="`$smarty.const.FRONT_THEMES_DIR`kavosi/topBarName.tpl"}

                                </div>
                                <div class="main-navigation__sub-menu2 arrow-up">
                                    {include file="`$smarty.const.FRONT_THEMES_DIR`kavosi/topBar.tpl"}
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="phone_number" href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
                    <i class="icofont-notepad"></i> <span>پیگیری خرید</span> </a> <a
                            class="phone_number SMFooterPhone" href="#"> <span>{$smarty.const.CLIENT_PHONE}</span> </a>
                </div>
            </div>
        </div>
    </div>
    <div class="main_header_area animated">
        <div class="container">
            <nav id="navigation1" class="navigation">
                <div class="logo_top_right">
                    <img src="project_files/images/logoDark.png" alt="">
                </div>
                <div class="nav-header">
                    <div class="nav-toggle"></div>
                </div>
                <div class="nav-menus-wrapper">
                    <ul class="nav-menu">
                        <li id="flight_m" class=""><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/">پرواز</a></li>
                        <li id="hotels_m" class=""><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/"> هتل ها </a></li>
                        <li id="tours_m" class=""><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/">تور ها</a></li>
                        <li id="bus_m" class=""><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/"> اتوبوس </a></li>
                        <li id="train_m" class=""><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/"> قطار </a></li>
                        <li id="insurance_m" class=""><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/"> بیمه </a></li>
                        <li id="club_m" class=""><a href="{$smarty.const.ROOT_ADDRESS}/loginUser"> باشگاه مشتریان </a></li>
                        <li id="blog_m" class=""><a class="SMBlog" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/blog"> وبلاگ </a></li>
                        <li id="rouls_m" class=""><a class="SMRules" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/rules"> قوانین و مقررات </a></li>
                        <li class="aboutus_m"><a class="SMAbout" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/aboutus"> درباره ما </a></li>
                        <li class="contactus_m"><a class="SMContactUs" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/contactus"> تماس با ما </a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>

<div class="main_header_area animated">
    <div class="container">
        <nav id="navigation1" class="navigation">
            <div class="logo_top_right"><img src="images/logoDark.png" alt=""></div>
            <div class="nav-header">
                <div class="nav-toggle"></div>
            </div>
            <div class="nav-menus-wrapper">
                <ul class="nav-menu">
                    <li id="flight_m" class=""><a class="smoothScrollTo TabScroll " data-target="#flight-tab"
                                                  href="javascript:;">پرواز</a></li>
                    <li id="hotels_m" class=""><a href="javascript:;"> هتل ها </a></li>
                    <li id="tours_m" class=""><a href="javascript:;">تور ها</a></li>
                    <li id="bus_m" class=""><a href="javascript:;"> اتوبوس </a></li>
                    <li id="train_m" class=""><a href="javascript:;"> قطار </a></li>
                    <li id="insurance_m" class=""><a href="javascript:;"> بیمه </a></li>
                    <li id="club_m" class=""><a
                                href="{$smarty.const.ROOT_ADDRESS}/loginUser">
                        باشگاه مشتریان </a></li>
                    <li id="blog_m" class=""><a class="SMBlog" href="javascript:;"> وبلاگ </a></li>
                    <li id="rouls_m" class=""><a class="SMRules" href="javascript:;"> قوانین و مقررات </a></li>
                    <li class="aboutus_m"><a class="SMAbout" href="#"> درباره ما </a></li>
                    <li class="contactus_m"><a class="SMContactUs" href="javascript:;"> تماس با ما </a></li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<div class="articles">
    <div class="container">

        <div class="row center-eleman">
            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
        </div>

    </div>
</div>


{if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}

<footer class="footer">
    <div class="f_backs">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1920" height="80vh"
             style="bottom: 2em;" viewbox="0 0 1920 1069.03">
            <defs>
                <filter id="filter_back1" x="-107" y="6229.97" width="2107" height="1069.03"
                        filterunits="userSpaceOnUse">
                    <feimage preserveaspectratio="none" x="-107" y="6229.97" width="2107" height="1069.03"
                             result="image"
                             xlink:href="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB3aWR0aD0iMjEwNyIgaGVpZ2h0PSIxMDY5LjAzIiB2aWV3Qm94PSIwIDAgMjEwNyAxMDY5LjAzIj4KICA8ZGVmcz4KICAgIDxzdHlsZT4KICAgICAgLmNscy0xIHsKICAgICAgICBmaWxsOiB1cmwoI2xpbmVhci1ncmFkaWVudCk7CiAgICAgIH0KICAgIDwvc3R5bGU+CiAgICA8bGluZWFyR3JhZGllbnQgaWQ9ImxpbmVhci1ncmFkaWVudCIgeDE9IjEyOTEuNDgxIiB5MT0iMTA2OS4wMyIgeDI9IjgxNS41MTkiIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIj4KICAgICAgPHN0b3Agb2Zmc2V0PSItMC4yNSIgc3RvcC1jb2xvcj0iIzRlYzdmNSIvPgogICAgICA8c3RvcCBvZmZzZXQ9IjEuMjUiIHN0b3AtY29sb3I9IiM1Yzc1ZmUiLz4KICAgIDwvbGluZWFyR3JhZGllbnQ+CiAgPC9kZWZzPgogIDxyZWN0IGNsYXNzPSJjbHMtMSIgd2lkdGg9IjIxMDciIGhlaWdodD0iMTA2OS4wMyIvPgo8L3N2Zz4K"></feimage>
                    <fecomposite result="composite" operator="in" in2="SourceGraphic"></fecomposite>
                    <feblend result="blend" in2="SourceGraphic"></feblend>
                </filter>
            </defs>
            <path id="FOOTER_copy" data-name="FOOTER copy" class="fb_back1"
                  d="M-57,6419c1.352-11.23,254.118,277.89,989-51,821.97-367.86,1065,116,1065,116l3,815-2107-15Z"
                  transform="translate(0 -6229.97)"></path>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1920" height="73vh"
             viewbox="0 0 1920 1016.94">
            <defs>
                <filter id="filter_back2" x="-107" y="6338.06" width="2107" height="1056.94"
                        filterunits="userSpaceOnUse">
                    <feimage preserveaspectratio="none" x="-107" y="6338.06" width="2107" height="1056.94"
                             result="image"
                             xlink:href="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB3aWR0aD0iMjEwNyIgaGVpZ2h0PSIxMDU2Ljk0IiB2aWV3Qm94PSIwIDAgMjEwNyAxMDU2Ljk0Ij4KICA8ZGVmcz4KICAgIDxzdHlsZT4KICAgICAgLmNscy0xIHsKICAgICAgICBmaWxsOiB1cmwoI2xpbmVhci1ncmFkaWVudCk7CiAgICAgIH0KICAgIDwvc3R5bGU+CiAgICA8bGluZWFyR3JhZGllbnQgaWQ9ImxpbmVhci1ncmFkaWVudCIgeDE9Ijg1MC42MzkiIHgyPSIxMjU2LjM2MSIgeTI9IjEwNTYuOTQiIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIj4KICAgICAgPHN0b3Agb2Zmc2V0PSItMC4yNSIgc3RvcC1jb2xvcj0iIzRlYzdmNSIvPgogICAgICA8c3RvcCBvZmZzZXQ9IjEuMjUiIHN0b3AtY29sb3I9IiM1Yzc1ZmUiLz4KICAgIDwvbGluZWFyR3JhZGllbnQ+CiAgPC9kZWZzPgogIDxyZWN0IGNsYXNzPSJjbHMtMSIgd2lkdGg9IjIxMDciIGhlaWdodD0iMTA1Ni45NCIvPgo8L3N2Zz4K"></feimage>
                    <fecomposite result="composite" operator="in" in2="SourceGraphic"></fecomposite>
                    <feblend result="blend" in2="SourceGraphic"></feblend>
                </filter>
            </defs>
            <path id="FOOTER" class="fb_back2"
                  d="M-60,6395c-0.553.21,264.737,365.49,992,69,833.9-339.96,1065,116,1065,116l3,815-2107-15Z"
                  transform="translate(0 -6338.06)"></path>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1920" height="45vh"
             viewbox="0 0 1920 669.78">
            <defs>
                <filter id="filter_back3" x="-99" y="6685.22" width="2144" height="762.78" filterunits="userSpaceOnUse">
                    <feimage preserveaspectratio="none" x="-99" y="6685.22" width="2144" height="762.78" result="image"
                             xlink:href="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB3aWR0aD0iMjE0NCIgaGVpZ2h0PSI3NjIuNzgiIHZpZXdCb3g9IjAgMCAyMTQ0IDc2Mi43OCI+CiAgPGRlZnM+CiAgICA8c3R5bGU+CiAgICAgIC5jbHMtMSB7CiAgICAgICAgZmlsbDogdXJsKCNsaW5lYXItZ3JhZGllbnQpOwogICAgICB9CiAgICA8L3N0eWxlPgogICAgPGxpbmVhckdyYWRpZW50IGlkPSJsaW5lYXItZ3JhZGllbnQiIHgxPSI4OTQuMTU1IiB4Mj0iMTI0OS44NDUiIHkyPSI3NjIuNzgiIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIj4KICAgICAgPHN0b3Agb2Zmc2V0PSItMC4yNSIgc3RvcC1jb2xvcj0iIzRlYzdmNSIvPgogICAgICA8c3RvcCBvZmZzZXQ9IjEuMjUiIHN0b3AtY29sb3I9IiM1Yzc1ZmUiLz4KICAgIDwvbGluZWFyR3JhZGllbnQ+CiAgPC9kZWZzPgogIDxyZWN0IGNsYXNzPSJjbHMtMSIgd2lkdGg9IjIxNDQiIGhlaWdodD0iNzYyLjc4Ii8+Cjwvc3ZnPgo="></feimage>
                    <fecomposite result="composite" operator="in" in2="SourceGraphic"></fecomposite>
                    <feblend result="blend" mode="screen" in2="SourceGraphic"></feblend>
                </filter>
            </defs>
            <path id="footer" class="fb_back3"
                  d="M2045,6803s-250.73-234.24-704-42c-384.969,163.27-350.217,523.62-767,475C96.722,7180.33-99,7448-99,7448l2112-93Z"
                  transform="translate(0 -6685.22)"></path>
        </svg>
    </div>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="footer-widget"><h4 class="widget-title"> درباره ما </h4>
                        <aside id="media_image-2" class="widget widget_media_image"><p>
                                {$smarty.const.ABOUT_ME}
                            </p></aside>
                        <aside id="text-2" class="mt-1 widget widget_text logo-moshtari">
                            <div class="textwidget">
                                <ul style="text-align: center">
                                    <li><a rel="nofollow" target="_blank" href="https://www.cao.ir/paxrights"><img
                                                    src="project_files/images/certificate1.png" alt=""></a></li>
                                    <li><a rel="nofollow" target="_blank" href="https://www.cao.ir/"><img
                                                    src="project_files/images/certificate2.png" alt=""></a></li>
                                    <li><a rel="nofollow" target="_blank"
                                           href="http://aira.ir/images/uptoshahrivar.pdf"><img
                                                    src="project_files/images/certificate3.png" alt=""></a></li>
                                </ul>
                            </div>
                        </aside>
                        <div class="">
                            <ul class="footer-bottom-social">
                                <li><a class="SMFaceBook"   href="javascript:;"><i class="fab fa-facebook"></i>فیسبوک</a></li>
                                <li><a class="SMTwitter"    href="javascript:;"><i class="fab fa-twitter"></i>توییتر</a></li>
                                <li><a class="SMInstageram" href="javascript:;"><i class="fab fa-instagram"></i>اینستاگرام</a></li>
                                <li><a class="SMLinkedin"   href="javascript:;"><i class="fab fa-linkedin"></i>لینکداین</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                            <div class="footer-widget"><h4 class="widget-title"> مسیر های پر تردد داخلی </h4>
                                <ul class="footer-menu">
                                    {assign 'cities' ['MHD' => functions::Xmlinformation('S360MHD'),'TBZ' => functions::Xmlinformation('S360TBZ'),'AWZ' =>  functions::Xmlinformation('S360AWZ'),'AZD' => functions::Xmlinformation('S360AZD'),'KSH' =>functions::Xmlinformation('S360KSH'),'RAS' => functions::Xmlinformation('S360RAS') , 'ADU' => functions::Xmlinformation('S360ADU') , 'BND' =>  functions::Xmlinformation('S360BND')]}


                                    {foreach $cities as $item}
                                        <li>
                                            <a onclick="ShowModalOfFlights('THR','{$item@key}','local')"
                                               data-toggle="modal"
                                               data-target="#ModalOfFifteenFlights">
                                                ##S360FlightTo## {$item}
                                            </a>
                                        </li>

                                    {/foreach}

                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                            <div class="footer-widget"><h4 class="widget-title"> مسیر های پر تردد خارجی </h4>
                                <ul class="footer-menu">
                                    {assign 'cities' ['ISTALL' => functions::Xmlinformation('S360ISTALL'),'DXB' => functions::Xmlinformation('S360DXB'),'BON' => functions::Xmlinformation('S360BON'),'SYD' => functions::Xmlinformation('S360SYD'),'DXBALL' => functions::Xmlinformation('S360DXBALL'),'BERALL' => functions::Xmlinformation('S360BERALL'), 'YXUALL' => functions::Xmlinformation('S360YXUALL'), 'NJF' => functions::Xmlinformation('S360NJF')]}

                                    {foreach $cities as $key => $item}
                                        {assign var="TodayDate" value=date("Y-m-d", time())}
                                        {assign var="Linkinternation" value="`$smarty.const.ROOT_ADDRESS`/international/1/IKA-`$key`/`$TodayDate`/Y/1-0-0"}
                                        <li>
                                            <a href="{$Linkinternation}">
                                                پرواز به  {$item}
                                            </a>
                                        </li>

                                    {/foreach}

                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="footer-widget"><h4 class="widget-title">تماس با ما</h4>
                                <p class="SMFooterAddress"><i class="fa fa-map-marker"></i>{$smarty.const.CLIENT_ADDRESS}</p>
                                <p class="SMFooterEmail"><i class="fa fa-envelope"></i> {$smarty.const.CLIENT_EMAIL}</p>
                                <p class="SMFooterPhone"><i class="fa fa-headphones"></i> {$smarty.const.CLIENT_PHONE}</p>
                                <div id="g-map"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12"><p class="copyright"><span>                                  <a
                                    href="https://www.iran-tech.com/"> طراحی سایت آژانس هواپیمایی </a>: ایران تکنولوژی                              </span>
                    </p></div>
            </div>
        </div>
    </div>
</footer>
{/if}
<a data-placement="top" id="scroll-top" style="cursor: pointer;">
    <button><i class="fas fa-arrow-up"></i></button>
</a>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
      integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
      crossorigin=""/>
<div class="modal fade bd-example-modal-lg" id="ModalOfFifteenFlights"
     tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            ...
        </div>
    </div>
</div>
{literal}


    <script  src="project_files/js/bootstrap.min.js"></script>
    <script  src="project_files/js/bootstrap.bundle.min.js"></script>
    <script  src="project_files/js/megamenu.js"></script>
    <script  src="project_files/js/scripts.js"></script>
    <script>

        $('.c-header__btn').click(function () {

            $('.main-navigation__sub-menu2').toggleClass('active_log');
        });
        $('.menu-login').bind('click', function(e){
            //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
            e.stopPropagation();

        });

        $('body').click(function () {

            $('.main-navigation__sub-menu2').removeClass('active_log');
        })
    </script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
          integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
          crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
            integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
            crossorigin=""></script>

    <script type="text/javascript">
        // position we will use later ,
        var lat = 36.294151;
        var lon = 59.610635;
        // initialize map
        map = L.map('g-map').setView([lat, lon], 15);
        // set map tiles source
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '',
            maxZoom: 16,
            minZoom: 14,
        }).addTo(map);
        // add marker to the map
        marker = L.marker([lat, lon]).addTo(map);
        // add popup to the marker
        marker.bindPopup(" مشهد نبش چهار راه شهدا - ابتدای خیابان بهجت - جنب بانک صادرات").openPopup();
    </script>

{/literal}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}

</body>
</html>