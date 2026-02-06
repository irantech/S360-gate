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
    <link rel="shortcut icon" type="image/png" href="project_files/images/favicon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="project_files/images/favicon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="project_files/images/favicon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="project_files/images/favicon.png">


    {*    style for font    *}
    <link rel="stylesheet" href="project_files/css/{$StyleSheet}">
    {if $smarty.session.layout neq 'pwa'}
        <link rel="stylesheet" href="project_files/css/all.min.css">
        <link rel="stylesheet" href="project_files/css/swiper.min.css">
        <link rel="stylesheet" href="project_files/css/{$StyleSheetHeader}">
        <link rel="stylesheet" href="project_files/css/responsive.css">
        {if $smarty.const.SOFTWARE_LANG eq 'en'}
            <link rel="stylesheet" type="text/css"
                  href="https://s360.iran-tech.com/en/user/GlobalFile/css/register.css">
        {else}
            <link rel="stylesheet" type="text/css"
                  href="https://s360.iran-tech.com/fa/user/GlobalFile/css/register.css">
        {/if}

    {/if}


    <script type="text/javascript" src="project_files/js/jquery-3.4.1.min.js"></script>
    {if $smarty.const.GDS_SWITCH neq 'app'}
         <script src="project_files/js/bootstrap.min.js"></script>
    {/if}
    <script src="project_files/js/megamenu.js"></script>
    <script src="project_files/js/swiper.min.js"></script>

        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}

</head>
<body>

{if $smarty.session.layout neq 'pwa' }
    {if $smarty.const.SOFTWARE_LANG eq 'en'}
        {include file="`$smarty.const.FRONT_THEMES_DIR`iran_tech_s360/HeaderEn.tpl"}
    {else}
        {include file="`$smarty.const.FRONT_THEMES_DIR`iran_tech_s360/HeaderFa.tpl"}
    {/if}
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
    <path fill="#ff3a46"
          d="M250,246.5c-97.85,0-186.344-40.044-250-104.633V250h500V141.867C436.344,206.456,347.85,246.5,250,246.5z"></path>

    </svg>
        <footer class="footer">
            <div class="footer_top">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-3 col-md-6 col-lg-3 col_foo">
                            <div class="footer_widget">
                                <h3 class="footer_title">
                                    ##S360HighTrafficRoutes##
                                </h3>
                                <ul class="links double_links">


                                    {assign 'cities' ['MHD' => functions::Xmlinformation('S360MHD'),'TBZ' => functions::Xmlinformation('S360TBZ'),'AWZ' =>  functions::Xmlinformation('S360AWZ'),'AZD' => functions::Xmlinformation('S360AZD'),'KSH' =>functions::Xmlinformation('S360KSH'),'RAS' => functions::Xmlinformation('S360RAS') , 'ADU' => functions::Xmlinformation('S360ADU') , 'BND' =>  functions::Xmlinformation('S360BND')]}


                                    {foreach $cities as $item}
                                        <li>
                                            <a onclick="ShowModalOfFlights('THR','{$item@key}','searchFlight')"
                                               data-toggle="modal"
                                               data-target="#ModalOfFifteenFlights">
                                                ##S360FlightTo## {$item}
                                            </a>
                                        </li>
                                    {/foreach}


                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-lg-3 col_foo">
                            <div class="footer_widget">
                                <h3 class="footer_title">
                                    ##S360ExternalHighTrafficRoutes##
                                </h3>


                                <ul class="links double_links">

                                    {assign 'cities' ['ISTALL' => functions::Xmlinformation('S360ISTALL'),'DXB' => functions::Xmlinformation('S360DXB'),'BON' => functions::Xmlinformation('S360BON'),'SYD' => functions::Xmlinformation('S360SYD'),'DXBALL' => functions::Xmlinformation('S360DXBALL'),'BERALL' => functions::Xmlinformation('S360BERALL'), 'YXUALL' => functions::Xmlinformation('S360YXUALL'), 'NJF' => functions::Xmlinformation('S360NJF')]}


                                    {foreach $cities as $item}
                                        <li>
                                            <a target='_blank' href="{$smarty.const.ROOT_ADDRESS}/international/1/IKA-{$item@key}/{$objDate->tomorrow()}/1-0-0">
                                                ##S360FlightTo## {$item}
                                            </a>
                                        </li>
                                    {/foreach}


                                </ul>

                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 col-lg-3 col_foo">
                            <div class="footer_widget">
                                <h3 class="footer_title">
                                    ##TouristServices##
                                </h3>
                                <ul class="links double_links">
                                    <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/tour">##S360Tour##</a></li>
                                    <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/flight">##S360Flight##</a>
                                    </li>

                                    <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/hotel"> ##S360Hotels## </a>
                                    </li>

                                    <li class=""><a
                                                href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/visa">##S360Visa##</a>
                                    </li>

                                    <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/train">##S360Train##</a>
                                    </li>

                                    <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/bus">##S360Bus##</a></li>

                                    <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fun">
                                            ##S360Entertainment## </a></li>
                                    <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/car"> ##S360Car## </a></li>


                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-lg-3 col_foo foo_contact">

                            <div class="address footer_widget">
                                <h3 class="footer_title">
                                    ##S360ContactUs##
                                </h3>
                                <div class="contact_info_text ">
                                    <i class="fas fa-map-marked-alt "></i>
                                    <a class="SMFooterAddress">
                                        {$smarty.const.CLIENT_ADDRESS}
                                    </a>
                                </div>
                                <div class="contact_info_text">
                                    <i class="fas fa-phone"></i>
                                    <a href="tel:{$smarty.const.CLIENT_PHONE}" target="_top"
                                       class="SMFooterPhone">{$smarty.const.CLIENT_PHONE}</a>
                                </div>
                                <div class="contact_info_text">
                                    <i class="fas fa-envelope"></i>
                                    <a href="mailto:info@iran-tech.com" target="_top" class="SMFooterEmail">info@iran-tech.com</a>
                                </div>

                            </div>

                        </div>
                        <div class="col-12 ">
                            <div class="col_namads">

                                <a target="_blank" rel="nofollow" href="https://www.cao.ir/paxrights">
                                    <img src="project_files/images/certificate1.png" alt="">
                                </a>
                                <a target="_blank" rel="nofollow" href="https://www.cao.ir/">
                                    <img src="project_files/images/certificate2.png" alt="">
                                </a>
                                <a target="_blank" rel="nofollow" href="http://aira.ir/images/final3.pdf">
                                    <img src="project_files/images/certificate3.png" alt="">
                                </a>


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

                                <a href="https://www.iran-tech.com/" target="_blank"> طراحی سایت آژانس مسافرتی </a>

                                : ایران تکنولوژی
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
    <script type="text/javascript" src="project_files/js/scripts.js"></script>
    <script type="text/javascript" src="project_files/js/megamenu.js"></script>
    <script type="text/javascript" src="project_files/js/modernizr.js"></script>
{/literal}

{if $smarty.const.GDS_SWITCH neq 'app'}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
{/if}

</body>
</html>
