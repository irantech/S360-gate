{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="dateTimeSetting" assign="objDate"}
{load_presentation_object filename="reservationBasicInformation" assign="objResult"}

{if $smarty.session['userId'] }
    {assign var="userInfo" value=functions::infoMember($smarty.session.userId)}
    {assign var="hashedPass" value=functions::HashKey({$userInfo['email']},'encrypt')}
{/if}

{if $smarty.const.SOFTWARE_LANG eq 'en'}
    {assign var='StyleSheet' value="styleEn.css"}
    {assign var='StyleSheetHeader' value="headerEn.css"}
    {assign var='mainPage' value="/en"}
{else}
    {assign var='mainPage' value=""}
    {assign var='StyleSheet' value="style.css"}
    {assign var='StyleSheetHeader' value="header.css"}
{/if}

<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="{$obj->Title_head()}">
    <title>{$obj->Title_head()}</title>
    <base href="{$smarty.const.CLIENT_DOMAIN}" />
    <link rel="shortcut icon" type="image/png" href="project_files/en/images/favicon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="project_files/en/images/favicon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="project_files/en/images/favicon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="project_files/en/images/favicon.png">


    {*    style for font    *}
    <link rel="stylesheet" href="project_files/en/css/styleEn.css">
    {if $smarty.session.layout neq 'pwa'}
        <link rel="stylesheet" href="project_files/en/css/all.css">
        <link rel="stylesheet" href="project_files/en/css/swiper.min.css">
        <link rel="stylesheet" href="project_files/en/css/headerEn.css">
        <link rel="stylesheet" href="project_files/en/css/responsive.css">
        {if $smarty.const.SOFTWARE_LANG eq 'en'}
            <link rel="stylesheet" type="text/css"
                  href="https://www.parvaz.ir/en/user/GlobalFile/css/register.css">
        {else}
            <link rel="stylesheet" type="text/css"
                  href="https://www.parvaz.ir/fa/user/GlobalFile/css/register.css">
        {/if}

    {/if}


    <script type="text/javascript" src="project_files/en/js/jquery-3.4.1.min.js"></script>
    <script src="project_files/en/js/bootstrap.min.js"></script>
    <script src="project_files/en/js/megamenu.js"></script>
    <script src="project_files/en/js/swiper.min.js"></script>

        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}

</head>
<body>

{if $smarty.session.layout neq 'pwa' }
    <header class="header_area fixedmenu">
        <div class="main_header_area">


            <div class=" menus container">
                <nav id="navigation1" class="navigation">
                    <!-- Logo Area Start -->
                    <div class="nav-header">
                        <a class="flex-row" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}">
                            <div class="logo logoHolder flex-col">
                                <img src="project_files/en/images/logo.png" alt="{$obj->Title_head()}">
                            </div>


                        </a>
                        <div class="nav-toggle"></div>
                    </div>

                    <div class="nav-menus-wrapper">
                        <ul class="nav-menu ">

                            <li id="tours_m" class="">
                                <a class="smoothScrollTo TabScroll " data-target="#flight-tab"
                                   href="{$smarty.const.ROOT_ADDRESS}/UserTracking">Refund</a>
                            </li>
                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/contactus" >Contact us </a></li>
                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/aboutus" >About Us </a></li>

                            <li class="mobileMenu"><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/">Home</a></li>
                            <li class="mobileMenu"><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">Refund</a></li>
                            <li class="mobileMenu"><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}contactus">contact us </a></li>
                            <li class="mobileMenu"><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}aboutus">about us </a></li>


                        </ul>
                    </div>

                    <div class="act-buttons">
                        <div class="nav-search">
                            <div class="top__user_menu">
                                <button class="main-navigation__button2">
                        {include file="`$smarty.const.FRONT_THEMES_DIR`jahangardan_kohan/jahangardan_en/topBarName.tpl"}
                                    <div class="button-chevron-2 ">
                                    </div>
                                </button>

                                <div class="main-navigation__sub-menu2 arrow-up">
                        {include file="`$smarty.const.FRONT_THEMES_DIR`jahangardan_kohan/jahangardan_en/topBar.tpl"}
                                </div>

                            </div>
                        </div>
                    </div>

{*                    <div class="lang">*}
{*                    <span>*}
{*                        <img src="project_files/en/images/language-icon-fa.png" alt="">*}
{*                    </span>*}

{*                        <ul class="lang_ul arrow-up ">*}

{*                            <li>*}
{*                                <a href="https://s360.parvaz.ir/">*}
{*                                <span>*}
{*                                  <img src="project_files/en/images/language-icon-fa.png" alt="" />*}
{*                                    fa*}
{*                              </span>*}
{*                                </a>*}
{*                            </li>*}

{*                        </ul>*}

{*                    </div>*}


                </nav>
            </div>
        </div>


    </header>
{/if}

{if $smarty.const.GDS_SWITCH eq 'app'}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
{else}
<div class="content_tech">
    <div class="container">
        <div class="temp-wrapper">
            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
        </div>
    </div>
</div>
{/if}



{if $smarty.session.layout neq 'pwa'}
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
        <svg version="1.1" id="wave_footer" xmlns="http://www.w3.org/2000/svg"
             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 500 250"
             enable-background="new 0 0 500 250" xml:space="preserve" preserveAspectRatio="none">
    <path fill="#069"
          d="M250,246.5c-97.85,0-186.344-40.044-250-104.633V250h500V141.867C436.344,206.456,347.85,246.5,250,246.5z"></path>

    </svg>
        <footer class="footer">
            <div class="footer_top">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-md-6 col-lg-3 col_foo my-respanciv">
                            <div class="footer_widget">
                                <h3 class="footer_title tb">
                                    Quick Access
                                </h3>
                                <ul class="links double_links">

                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking" class=""><i class="fal fa-angle-right"></i>Refund</a></li>
                                    <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/aboutus" class=""><i class="fal fa-angle-right"></i>About us</a></li>
                                    <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/contactus" class=""><i class="fal fa-angle-right"></i>contactus</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-lg-3 col_foo foo_contact">
                            <div class="footer_widget">
                                <h3 class="footer_title tb">
                                    Contact Us
                                </h3>
                                <div class="contact_info_text ">
                                    <i class="fas fa-map-marked-alt "></i>
                                    <a class="">{$smarty.const.CLIENT_ADDRESS_EN}</a>
                                </div>
                                <div class="contact_info_text">
                                    <i class="fas fa-phone"></i>
                                    <a href="tel:{$smarty.const.CLIENT_PHONE}" target="_top" class="FooterPhone">{$smarty.const.CLIENT_PHONE}</a>
                                </div>
                                <div class="contact_info_text">
                                    <i class="fas fa-envelope"></i>
                                    <a href="mailto:{$smarty.const.CLIENT_EMAIL}" target="_top" class="SMFooterEmail">{$smarty.const.CLIENT_EMAIL}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-lg-3 col_foo foo_contact">
                            <div class="footer_widget">
                                <div class="col_namads">
                                    <a target="_blank" rel="nofollow" href="https://www.cao.ir/paxrights">
                                        <img src="project_files/en/images/certificate1.png" alt="">
                                    </a>
                                    <a target="_blank" rel="nofollow" href="https://www.cao.ir/">
                                        <img src="project_files/en/images/certificate2.png" alt="">
                                    </a>
                                    <a target="_blank" rel="nofollow" href="http://aira.ir/images/final3.pdf">
                                        <img src="project_files/en/images/certificate3.png" alt="">
                                    </a>
                                    <a target="_blank" rel="nofollow" href="javascript">
                                        <img src="project_files/en/images/enamad.png" alt="">
                                    </a>
                                    <a target="_blank" rel="nofollow" href="javascript">
                                        <img src="project_files/en/images/samandeh.jpg" alt="">
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copy-right_text">
                <div class="container">

                    <div class="row">
                        <div class="col-xl-12">

                            <div class="copyright_content d-flex flex-row justify-content-center">

                                <a href="https://www.parvaz.ir/" target="_blank">

                                    Web design

                                </a>
                                :
                                Iran Technology

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <a href="javascript:;" id="scroll-top" data-type="section-switch" class="scrollup back-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <div class="modal fade bd-example-modal-lg" id="ModalOfFifteenFlights"
             tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    ...
                </div>
            </div>
        </div>
    {/if}
{else}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}
{/if}


{*<div class="float-sm">
    <!--<div class="fl-fl float-fb">
        <i class="fab fa-facebook"></i>
        <a href="" target="_blank"> Like us!</a>
    </div>
    <div class="fl-fl float-tw">
        <i class="fab fa-twitter"></i>
        <a href="" target="_blank">Follow us!</a>
    </div>-->
    <div class="fl-fl float-gp">
        <i class="fab fa-telegram"></i>
        <a class="SMTelegram" href="" target="_blank">Join us!</a>
    </div>
    <div class="fl-fl float-rs">
        <i class="fab fa-whatsapp"></i>
        <a class="SMWhatsApp" href="" target="_blank">Contact us!</a>
    </div>
    <div class="fl-fl float-ig">
        <i class="fab fa-instagram"></i>
        <a class="SMInstageram" href="" target="_blank">Follow us!</a>
    </div>
    <!--<div class="fl-fl float-pn">
        <i class="fab fa-pinterest"></i>
        <a href="" target="_blank">Follow us!</a>
    </div>-->
</div>*}
{literal}
    <script type="text/javascript" src="project_files/en/js/scripts.js"></script>
    <script type="text/javascript" src="project_files/en/js/megamenu.js"></script>
    <script type="text/javascript" src="project_files/en/js/modernizr.js"></script>
{/literal}

{if $smarty.const.GDS_SWITCH neq 'app'}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
{/if}

</body>
</html>
