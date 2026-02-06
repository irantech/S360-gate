{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="dateTimeSetting" assign="objDate"}
{assign var="userInfo" value=functions::infoMember($smarty.session.userId)}
{assign var="hashedPass" value=functions::HashKey({$userInfo['email']},'encrypt')}
<!doctype html>

<head>
    <!-- Required meta tags -->
    <title>{$obj->Title_head()}</title>
    <link rel="shortcut icon" type="image/x-icon" href="project_files/images/favicon.png"/>
    <meta name="description" content="{$obj->Title_head()}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <base href="{$smarty.const.CLIENT_DOMAIN}"/>
    <!-- Main CSS files -->
    <link rel="stylesheet" href="project_files/css/booking/booking.css">
    <link rel="stylesheet" href="project_files/css/all.css">
    <link rel="stylesheet" href="project_files/css/animate.min.css" >
    <link rel="stylesheet" href="project_files/css/bootstrap.min.css">
    <link rel="stylesheet" href="project_files/css/header.css">
    <link rel="stylesheet" href="project_files/css/style.css">
    <link rel="stylesheet" href="project_files/css/tabs.css">
    <link rel="stylesheet" href="project_files/css/owl.carousel.min.css">
    <link rel="stylesheet" href="project_files/css/owl.theme.default.min.css">


    {literal}
        <script  src="project_files/js/jquery-3.4.1.min.js"></script>
        <script  src="project_files/js/popper.min.js"></script>
        <script  src="project_files/js/bootstrap.min.js"></script>
        <script  src="project_files/js/select2.min.js"></script>
    {/literal}


    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}
</head>

<aside class="navigation_2">
    <div class="top">به بوم گردی کیمه خوش آمدید  </div>


    <div class="table">


        <div class="main-navigation__sub-menu2 arrow-up">


            <div class="sup-menu-flex">
                {include file="`$smarty.const.FRONT_THEMES_DIR`kimeh/topBar.tpl"}

            </div>

        </div>


    </div>

</aside>
<aside class="main-side ">
    <div class="hamburger-menu"><span></span> <span></span> <span></span></div>
    <!-- end hamburger-menu -->
    <ul class="social-media">
        <li><a class="SMTelegram" href="#"><i class="fab fa-telegram-plane" aria-hidden="true"></i></a></li>
        <li><a class="SMWhatsApp" href="#"><i class="fab fa-whatsapp" aria-hidden="true"></i></a></li>
        <li><a class="SMInstageram" href="#"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
    </ul>
    <!-- end social-media -->
    <a href="{$smarty.const.ROOT_ADDRESS}/roomHotelLocal/reservation/1/"><div class="search">

    </div></a>
    <!-- end search -->
</aside>


<div class="body_temp">


    <header class="header_area">
        <div class="main_header_area animated">
            <div class="container">
                <nav id="navigation1" class="navigation">
                    <!-- Logo Area Start -->
                    <div class="nav-header">
                        <a class="nav-brand" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/">

                            <img src="project_files/images/logo.png" alt="<?php echo $title_page; ?>">

                        </a>
                        <div class="nav-toggle"></div>
                    </div>

                    <div class="nav-menus-wrapper">
                        <ul class="nav-menu ">
                            <li class=""><a href="javascript:;">کیمه</a>
                                <ul class="nav-dropdown fadeIn animated">

                                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/aboutus" class="SMAbout">درباره ما</a></li>
                                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/contactus" class="SMContactUs">تماس با ما</a></li>
                                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/rules" class="SMRules"> قوانین و مقررات</a></li>

                                </ul>

                            </li>
                            <li class=""><a href="javascript:;">امکانات </a>
                                <ul class="nav-dropdown fadeIn animated">

                                    {assign var="urlHotelRoomInfo" value="/hotelRoomInfo"}
                                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/3">امکانات </a></li>
                                    <li><a id="HotelRoominfo" onclick="viewHotel('{$smarty.const.ROOT_ADDRESS}{$urlHotelRoomInfo}')">کلبه ها</a></li>
                                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/2">رستوران</a></li>


                                </ul>

                            </li>

                            <li class=""><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/gallery" class="SMGallery"> گالری  </a></li>
                            <li class=""><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/blog" class="SMBlog">دانستنی ها</a></li>


                            <li class=""><a href="{$smarty.const.ROOT_ADDRESS}/roomHotelLocal/reservation/1/">  رزرو آنلاین </a></li>


                        </ul>
                    </div>
                    <div class="act-buttons">
                        <a href="javascript:void(0)" class="btn register"><i class="fas fa-user-check"></i> ورود / ثبت
                            نام
                        </a>


                    </div>

                </nav>

            </div>
        </div>


    </header>


    <div class="content_temp">


        <div class="container">

            <div  id="StyleProject">



                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
                </div>


        </div>

    </div>
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}


    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="logo_footer">

                        <img src="project_files/images/logo.png" alt="">

                    </div>
                    <div class="footer-address">
                        <div class="f-adress SMFooterAddress">{$smarty.const.CLIENT_ADDRESS}</div>
                        <div class="f-tell SMFooterPhone" href="tel:02188866609  ">{$smarty.const.CLIENT_PHONE}</div>

                        <div class="f-mail SMFooterEmail" href="mailto:info@iran-tech.com">{$smarty.const.CLIENT_EMAIL}</div>

                        <div class="social_footer">

                            <ul>
                                <li><a class="SMInstageram" href=""><i class="fab fa-instagram"></i></a></li>
                                <li><a class="SMWhatsApp" href=""><i class="fab fa-whatsapp"></i></a></li>
                                <li><a class="SMTelegram" href=""><i class="fab fa-telegram-plane"></i></a></li>
                                <li><a class="SMFaceBook" href=""><i class="fab fa-facebook-f"></i></a></li>
                            </ul>

                        </div>
                    </div>
                </div>
                <!-- end col-4 -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <h4 class="footer-title">دسترسی آسان</h4>
                    <ul class="footer-menu">
                        <li><a  href="{$smarty.const.ROOT_ADDRESS}/roomHotelLocal/reservation/1/">امکانات</a></li>
                        <li><a class="SMGallery" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/gallery">گالری</a></li>
                        <li><a class="SMContactus" href="{$smarty.const.ROOT_ADDRESS}/roomHotelLocal/reservation/1/">رزرو آنلاین</a></li>
                        <li><a class="SMRules" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/rules">قوانین و مقررات</a></li>
                        <li><a class="SMAbout" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/aboutus">درباره ما</a></li>
                        <li><a class="SMContactUs" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/contactus">تماس با ما</a></li>

                    </ul>
                </div>
                <!-- end col-4 -->

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div id="g-map"></div>
                    <!-- end weather -->
                </div>
                <!-- end col-4 -->


            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
        <div class="sub-footer">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-12"><span class="copyright"> © 2020 -  تمام حقوق متعلق به بوم گردی کیمه می باشد </span></div>
                    <!-- end col-6 -->
                    <div class="col-sm-4 col-12"><span class="creation">
                        <a href="https://www.iran-tech.com">طراحی و بهینه سازی </a> : ایران تکنولوژی</span> </div>
                    <!-- end col-6 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end sub-footer -->
    </footer>

    {/if}
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModalScrollable" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"> ...</div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
      integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
      crossorigin=""/>
{literal}

<script  src="project_files/js/megamenu.js"></script>
<script  src="project_files/js/owl.carousel.min.js"></script>
<script  src="project_files/js/jquery.paroller.min.js"></script>
<script  src="project_files/js/scripts.js"></script>

<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
        integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
        crossorigin=""></script>

<script type="text/javascript">
    // position we will use later ,
    var lat = 36.31377208503443;
    var lon = 52.782989120003684;
    // initialize map
    map = L.map('g-map').setView([lat, lon], 15);
    // set map tiles source
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        maxZoom: 16,
        minZoom: 14,
    }).addTo(map);
    // add marker to the map
    marker = L.marker([lat, lon]).addTo(map);
    // add popup to the marker
    marker.bindPopup("مازندران، سوادکوه، شیرگاه به سمت لفور، روستای سیدکلا، اقامتگاه بوم‌گردی کیمه").openPopup();
</script>

{/literal}

</html>