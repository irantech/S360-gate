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
    <link rel="stylesheet" href="project_files/css/style.css">
    {if $smarty.session.layout neq 'pwa'}
    <link rel="stylesheet" href="project_files/css/bootstrap.min.css">
    <link rel="stylesheet" href="project_files/css/all.min.css">

    <link rel="stylesheet" href="project_files/css/header.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css">
    <link rel="stylesheet" type="text/css" href="https://myna.ir/fa/user/GlobalFile/css/register.css">

    {/if}

    {literal}
        <script  src="project_files/js/jquery-3.4.1.min.js"></script>
        <script  src="project_files/js/modernizr.js"></script>
        <script  src="project_files/js/bootstrap.bundle.min.js"></script>
    {/literal}


    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}
</head>
<body>
{if $smarty.session.layout neq 'pwa' }
<header class="header_area">
    <div class="main_header_area animated">
        <div class="container">
            <nav id="navigation1" class="navigation">
                <a class="nav-brand" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/"> <img src="project_files/images/logo.png"/> </a>
                <div class="nav-menus-wrapper">
                    <div class="top_menu_sub">
                        <a class="nav-brand logo_in_menu" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/"> <img src="project_files/images/logo.png"/>
                        </a> <span>آژانس مسافرتی ماینا</span>
                    </div>
                    <ul class="nav-menu">
                        <li>
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/flight">
                                <i class="fas fa-plane">

                                </i> پرواز </a>
                        </li>
                        <li>
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/tour">
                                <i class="fas fa-suitcase-rolling">

                                </i> تور </a>
                        </li>
                        <li>
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/hotel">
                                <i class="fas fa-concierge-bell">

                                </i> هتل </a>
                        </li>
{*                        <li>*}
{*                            <a class="SMBlog" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/vila">*}
{*                                <i class="fas fa-concierge-bell">*}
{*                                </i>  ویلا /آپارتمان  </a>*}
{*                        </li>*}
                        <li>
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/74">
                                <i class="fas fa-backpack">

                                </i> بوم گردی </a>
                        </li>
                        <li>
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/visa">
                                <i class="fab fa-cc-visa">

                                </i>ویزا </a>
                        </li>
                        <li>
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/bus">
                                <i class="fas fa-bus">

                                </i>اتوبوس </a>
                        </li>
                       {* <li>
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/car">
                                <i class="fas fa-car">

                                </i>اجاره خودرو </a>
                        </li>*}
                        <li>
                            <a class="SMBlog" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/blog">
                                <i class="fas fa-rss-square">

                                </i> وبلاگ </a>
                        </li>

                        <li>
                            <a href="javascript:;">
                                <i class="fas fa-info">

                                </i> اطلاعات پرواز </a>
                            <ul class="nav-dropdown">
                                <li>
                                    <a href="https://fids.airport.ir/">داخلی</a>
                                </li>
                                <li>
                                    <a href="https://www.ikac.ir/flight-status">خارجی</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;">
                                <i class="fas fa-phone-office">

                                </i> آژانس ما</a>
                            <ul class="nav-dropdown">

                                <li>
                                    <a class="SMNews" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/news">اخبار سایت</a>
                                </li>
                                <li>
                                    <a class="SMRules" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/rules">قوانین و مقررات</a>
                                </li>
                                <li>
                                    <a class="SMAbout" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/aboutus">درباره ما</a>
                                </li>
                                <li>
                                    <a class="SMContactUs" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/contactus">تماس با ما</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
                            <i class="fas fa-clipboard-list">

                            </i> پیگیری / کنسلی </a>
                        </li>
                        <li class="my_li">
                            <i class="fas fa-money-bill-wave my_icone"></i>
                            <a href="https://sadadpsp.ir/tollpayment">
                                پرداخت عوارض خروج از کشور
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="register_login">
                    <a href="https://api.whatsapp.com/send?phone=093332222080">093332222080</a><a href="https://api.whatsapp.com/send?phone=093332222070">093332222070</a><a href="https://api.whatsapp.com/send?phone= 989333222090" class="SMWhatsapp whatsapp_icon"><i class="fab SMWhatsapp fa-whatsapp" href="https://api.whatsapp.com/send?phone= 989333222090"> </i></a> <a href="tel:06153250059">06153250059</a><a href="tel:0613868">0613868</a>
                    <div  class="reg_btn">
                        <div class="menu-login">
                            <div class="c-header__btn">
                                <div class="c-header__btn-login" href="javascript:;">
{*                                    {include file="`$smarty.const.FRONT_THEMES_DIR`myna/topBarName.tpl"}*}
                                    {if $objSession->IsLogin() }
                                        <span class="logined-name show-box-login-js">##Welcomeing##</span>
                                    {else}
                                        <a class="logined-name" href="{$smarty.const.ROOT_ADDRESS}/authenticate">##OsafarLogin## / ##OsafarSetAccount##</a>
                                    {/if}
                                </div>
                                <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js">
                                    {include file="`$smarty.const.FRONT_THEMES_DIR`myna/topBar.tpl"}
                                </div>
                            </div>
                        </div>

                    </div>
                    <a
                            href="javascript:;" class="lang" data-toggle="tooltip" data-placement="bottom"
                            title="اللغة العربية">Ar</a>
                </div>


                <div class="nav-header">
                    <div class="nav-toggle" id="nav-icon1">
                        <span>

                        </span> <span>

                        </span> <span>

                        </span>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
{/if}



{if $smarty.const.GDS_SWITCH eq 'app'}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
{else}
    <div class="front_master_div">
        <div class="container">
            <div class="row center-eleman">
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
            </div>
        </div>
    </div>
{/if}

{if $smarty.session.layout neq 'pwa'}
{if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}

<div class="WaveFooter">
    <svg viewbox="0 0 2000 128">
        <use xlink:href="#WaveFooter">
            <symbol id="WaveFooter">
                <path opacity="0.2" fill="#ededed"
                      d="M-0.5,83.4c59.6,40.5,193.3,35,316.7-12.3C525.6-9.2,756.7-9.6,979.8,12.3s445.6,57.9,669.8,54.1C1821.1,63.5,1932,56,2000,53c0,36,0,76.4,0,76.4H1L-0.5,83.4z">

                </path>
                <path opacity="0.2" fill="#ededed"
                      d="M309.2,46.1c265.1-57.8,453.7-19.6,687.9,6.8c285.1,32.2,564.2,63,863.4,33.4c94-9.3,119.5-19.6,139.5-19c0,32.2,0,63,0,63H0v-66C0,64.3,152.7,80.2,309.2,46.1z">

                </path>
                <path opacity="0.4" fill="#ededed"
                      d="M344.5,54.9c82.3-26.3,167.2-46,253-36.5S767,51.6,851.9,67.8c272.3,52,522.5,16.7,819.3,5c90-3.5,293.8-13.6,328.8-12.6c0,24,0,71,0,71H-1v-59C-1,72.3,198.7,101.6,344.5,54.9z">

                </path>
                <path fill="#ededed"
                      d="M1731.8,97.1c-289.3,18.5-590.4,17.2-873.9-16.8C746,66.9,641.1,42.1,528.5,39.5s-249.3,31-353.7,69.9c-57.5,21.4-164.7,2.3-175.7-4.7c0,8,0,26.5,0,26.5h2003v-58C2002,73.3,1854.2,89.2,1731.8,97.1z">

                </path>
            </symbol>
        </use>
    </svg>
</div>
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3 menu_f">
                <h5> پرواز های داخلی و خارجی</h5>
                <div class="flights_menu">
                    <ul class="menus_footer">
                        {assign 'cities' ['MHD' => functions::Xmlinformation('S360MHD'),'TBZ' => functions::Xmlinformation('S360TBZ'),'AWZ' =>  functions::Xmlinformation('S360AWZ'),'AZD' => functions::Xmlinformation('S360AZD')]}


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
                    <ul class="menus_footer">

                        {assign 'cities' ['ISTALL' => functions::Xmlinformation('S360ISTALL'),'DXB' => functions::Xmlinformation('S360DXB'),'DXBALL' => functions::Xmlinformation('S360DXBALL'),'BERALL' => functions::Xmlinformation('S360BERALL')]}

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
            <div class="col-md-3 about_f">
                <h5>درباره ما</h5>
                <p>  {$smarty.const.ABOUT_ME}</p>
            </div>
            <div class="col-md-3 menu_f">
                <h5>ماینا</h5>
                <div class="flights_menu">
                    <div id="g-map">

                    </div>
                    <p class="address SMFooterAddress">{$smarty.const.CLIENT_ADDRESS}</p>
                </div>
            </div>
            <div class="col-md-3 logos_footer">
                <a class="logo_foo" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/"> <img src="project_files/images/myna2.png" alt=""> </a>
                <div class="contact_foo">
                    <span> تلفن پشتیبانی :  </span> <a href="#" class="SMFooterPhone">{$smarty.const.CLIENT_PHONE}</a>
                    <ul class="social_footer">
                        <li>
                            <a class="SMInstageram" href="javascript:;">
                                <i class="SMInstageram fab fa-instagram">

                                </i>
                            </a>
                        </li>
                        <li>
                            <a class="SMTelegram" href="javascript:;">
                                <i class="SMTelegram fab fa-telegram-plane">

                                </i>
                            </a>
                        </li>
                        <li>
                            <a class="SMFaceBook" href="javascript:;">
                                <i class="SMFaceBook fab fa-facebook-f">

                                </i>
                            </a>
                        </li>
                    </ul>
                </div>
                <ul class="logos_f">
                    <li>
                        <a rel="nofollow" target="_blank" href="https://www.cao.ir/paxrights">
                            <img
                                    src="project_files/images/certificate1.png" alt="">
                        </a>
                    </li>
                    <li>
                        <a rel="nofollow" target="_blank" href="https://www.cao.ir/">
                            <img src="project_files/images/certificate2.png"
                                 alt="">
                        </a>
                    </li>
                    <li>
                        <a rel="nofollow" target="_blank" href="http://aira.ir/">
                            <img
                                    src="project_files/images/certificate3.png" alt="">
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</div>
{/if}

{else}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}

{/if}
<div class="copy-right">
    <span> <a href="https://www.iran-tech.com/"> طراحی سایت گردشگری : </a> ایران تکنولوژی </span>
</div>
<div class="modal fade bd-example-modal-lg" id="ModalOfFifteenFlights"
     tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            ...
        </div>
    </div>
</div>
{literal}


  

    <script  src="project_files/js/owl.carousel.min.js"></script>
    <script  src="project_files/js/megamenu.js"></script>
    <script  src="project_files/js/scripts.js"></script>
    <script  src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>


    <script type="text/javascript">
        // position we will use later
        var lat = 30.368305;
        var lon = 48.237225;
        // initialize map
        map = L.map('g-map').setView([lat, lon], 10);
        // set map tiles source
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '',
            maxZoom: 16,
            minZoom: 14,
        }).addTo(map);
        // add marker to the map
        marker = L.marker([lat, lon]).addTo(map);
        // add popup to the marker
        marker.bindPopup("آبادان ، امیرآباد ، فاز 01 ، میدان ایثار ، بلوار نیایش ، سه راه اول ، سمت راست ، روبروی درب شماره 3 منازل پتروشیمی ، ساختمان نورهان ").openPopup();

    </script>
{/literal}

{if $smarty.const.GDS_SWITCH neq 'app'}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
{/if}

</body>
</html>