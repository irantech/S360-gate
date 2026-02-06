{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="dateTimeSetting" assign="objDate"}
{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{if $smarty.session.userId neq ''}
    {assign var="userInfo" value=functions::infoMember($smarty.session.userId)}
    {assign var="hashedPass" value=functions::HashKey({$userInfo['email']},'encrypt')}
{/if}

<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <title>{$obj->Title_head()}</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/png" href="project_files/images/favicon.png">
    <link rel="stylesheet" href="project_files/css/bootstrap.min.css">
    <link rel="stylesheet" href="project_files/css/all.min.css">
    <link rel="stylesheet" href="project_files/css/header.css">
    <link rel="stylesheet" href="project_files/css/style.css">
    <link rel="stylesheet" type="text/css" href="https://delniagasht.ir/fa/user/GlobalFile/css/register.css">
    {literal}
        <script  src="project_files/js/jquery-3.4.1.min.js"></script>
    {/literal}

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}

</head>
<body>

<header class="header_area">
    <div class="main_header_area animated" id="navbar">
        <div class="container-fluid">
            <nav id="navigation1" class="navigation">
                <div class="nav-header">
                    <a class="nav-brand" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}">
                        <img src="project_files/images/logo.png" alt="{$obj->Title_head()}">
                        <img src="project_files/images/logo_text.png" alt="{$obj->Title_head()}">
                    </a>
                </div>
                <div class="nav-menus-wrapper">
                    <ul class="nav-menu align-to-right">

                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/countrytour/1"><i class="fa-regular fa-umbrella-beach ml-2"></i> تور خارجی </a>

                        </li>
                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/irantourcity/1"><i class="fa-regular fa-umbrella-alt ml-2"></i> تور داخلی</a>
                        </li>
                        <li><a class="active_link" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/gasht"><i class="fa-regular fa-money-check-pen ml-2"></i>
                                شرایط اقساط</a></li>
                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/article"><i class="fa-regular fa-rss ml-2"></i> وبلاگ</a></li>
                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/aboutus"><i class="fa-regular fa-users ml-2"></i> درباره ما</a></li>
                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/contactus"><i class="fa-regular fa-headset ml-2"></i> تماس با ما</a></li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/pay"><i class="fa-regular fa-bag-shopping ml-2"></i> پرداخت آنلاین</a></li>
                    </ul>
                </div>
                <div class="mr-auto d-flex flex-column">

                    <a class="callBtn" href="tel:{$smarty.const.CLIENT_PHONE}">
                        <span>{$smarty.const.CLIENT_PHONE}</span>
                        <i class="fa-regular fa-phone mr-1"></i>
                    </a>
                    <a class="callBtn mt-2" href="tel:{$smarty.const.CLIENT_MOBILE}">
                        <span>{$smarty.const.CLIENT_MOBILE}</span>
                        <i class="fa-regular fa-headset mr-1"></i>
                    </a>

                </div>
                <div class="nav-toggle mr-3"></div>
            </nav>
        </div>
    </div>
</header>

<div class="content_tech">

    <div class="container">
        <div class="temp-wrapper">
            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
        </div>

    </div>
</div>

{if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}

<footer class="footer border-top mt-4">

    <div class="whatsapp">
        <a href="" class="d-flex">
            <img src="project_files/images/whatsapp.png" alt="whatsapp"></a>
    </div>

    <div class="footer_main container">
        <div class="row w-100">
            <ul class="m-0 p-0 glideLayout w-100">
                <li class="col-lg-4 my-4 col-md-6 col-12 call">
                    <div class="callH1">
                        <h1>دلنیا گشت</h1>
                    </div>
                    <span> <i class="far fa-phone-alt"></i>
                    شماره :
                    <a href="tel:{$smarty.const.CLIENT_PHONE}">{$smarty.const.CLIENT_PHONE}</a>
                </span>

                    <div class="footer_icons">
                        {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
                        {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref' , 'twitter' => 'twitterHref']}

                        {foreach $socialLinks as $key => $val}
                            {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
                        {/foreach}
                        <a href="{if $telegramHref}{$telegramHref}{/if}" class="fab fa-telegram footer_telegram"></a>


                        <a href="{if $whatsappHref}{$whatsappHref}{/if}" class="fab fa-whatsapp footer_whatsapp"></a>


                        <a href="{if $instagramHref}{$instagramHref}{/if}" class="fab fa-instagram footer_instagram"></a>

                    </div>
                    <div class="namads">
                        <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=531759&Code=wEjwYmtav5sL47SYMCfft0o58yOI6Ml1'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=531759&Code=wEjwYmtav5sL47SYMCfft0o58yOI6Ml1' alt='' style='cursor:pointer' code='wEjwYmtav5sL47SYMCfft0o58yOI6Ml1'></a>
                        <a href="javascript:"><img src="project_files/images/namad-1.png" alt="namad-1"></a>
                        <a href="javascript:"><img src="project_files/images/Enamad2.png" alt="namad-2"></a>
                        <a href="javascript:"><img src="project_files/images/namad-3.png" alt="namad-3"></a>
                    </div>
                </li>
                <li class="col-lg-4 my-4 col-md-6 col-12">
                    <h6>دسترسی آسان</h6>
                    <div class="asan">
                        <a class="asan_link" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/irantourcity/1">تور داخلی</a>
                        <a class="asan_link" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/countrytour/1">تور خارجی</a>
                        <a class="asan_link" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/article">وبلاگ</a>
                        <a class="asan_link" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/aboutus">درباره ما</a>
                        <a class="asan_link" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/contactus">تماس با ما</a>
                    </div>
                </li>
                <li class="col-lg-4 my-4 col-md-6 col-12 mx-auto d-flex flex-column call">
                    <h6>آدرس</h6>
                    <span> <i class="far fa-map-marker"></i> {$smarty.const.ADDRESS} </span>

                    <div class="w-100 h-100 normal-shadow border-radius-5 mt-4">


                        <div class='w-100 h-100' id='map'></div>
                        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
                              integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
                              crossorigin=""/>
                        {literal}
                        <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
                                integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
                                crossorigin=""></script>

                        <script>
                            {/literal}
                            const GoogleMapLatitude = {$smarty.const.CLIENT_MAP_LAT}
                            const GoogleMapLongitude = {$smarty.const.CLIENT_MAP_LNG}

                            {literal}
                            map = L.map('map').setView([GoogleMapLatitude, GoogleMapLongitude], 14 )
                            L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                              maxZoom: 18,
                            }).addTo(map)
                            newMarkerGroup = new L.LayerGroup()
                            var marker = null
                            marker = L.marker({

                              lat: GoogleMapLatitude,
                              lng: GoogleMapLongitude,

                            }).addTo(map)
                            setTimeout(() => {
                              map.invalidateSize()
                            }, "1000")

                        </script>

                        {/literal}

                    </div>
                    <!--                    <div class="map_img"><img src="images/Screenshot%202023-01-30%20164127.png" alt="map"></div>-->
                </li>
            </ul>
        </div>
    </div>
    <div class="last_text col-12">
        <a class="last_a" href="https://www.iran-tech.com/" target="_blank">طراحی سایت گردشگری</a>
        <p class="last_p_text">: ایران تکنولوژی</p>
    </div>
</footer>
{/if}


</body>
{literal}
    <script src="project_files/js/mega-menu.js"></script>
    <script src="project_files/js/bootstrap.min.js"></script>
    <script src="project_files/js/script.js"></script>
{/literal}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
</html>