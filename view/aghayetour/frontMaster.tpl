{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="dateTimeSetting" assign="objDate"}
{assign var="hashedPass" value=functions::HashKey({$smarty.session.cardNo},'encrypt')}
<!doctype html>
<html lang="fa">
<head>
    <title>{$obj->Title_head()}</title>
    <link rel="shortcut icon" type="image/x-icon" href="project_files/images/favicon.png"/>
    <meta name="description" content="{$obj->Title_head()}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <base href="{$smarty.const.CLIENT_DOMAIN}"/>


    {*<link rel="stylesheet" href="project_files/css/bootstrap.min.css">*}
    <link rel="stylesheet" href="project_files/css/header.css">
    <link rel="stylesheet" href="project_files/css/all.css">
    <link rel="stylesheet" href="project_files/css/style.css">
    <script src="project_files/js/jquery-3.4.1.min.js"></script>
    <script src="project_files/js/bootstrap.min.js"></script>
    <script src="project_files/js/jquery.fancybox.min.js"></script>
    <script src="project_files/js/scripts.js"></script>



    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}

</head>
<body>

<header class="header_area">
    {include file="topBar.tpl"}
    <div class="main_header_area animated">
        <div class="container">
            <nav id="navigation1" class="navigation">
                <!-- Logo Area Start -->
                <div class="nav-header">

                    <div class="nav-toggle"></div>
                </div>

                <div class="nav-menus-wrapper">
                    <ul class="nav-menu ">
                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/" class="">صفحه اصلی</a></li>
                        <li><a href="javascript:;">تور ها</a>
                            <ul class="nav-dropdown tours">
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/irantourcity/1"> تور داخلی </a>
                                </li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/countrytour/1"> تور خارجی </a>
                                </li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/irantourcity/7"> تور های لحظه آخری </a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/countrytour/7"> تور های دیگر </a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/alltours"> تورها در یک نگاه </a></li>


                            </ul>
                        </li>

                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/brand">خدمات گردشگری </a>
                        </li>

                        <li><a href="javascript:;">دانستنی ها </a>
                            <ul class="nav-dropdown">

                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/aboutcountry">معرفی کشورها </a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/aboutiran">معرفی ایران</a></li>


                            </ul>
                        </li>

                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/blog">اطلاعات مفید</a></li>
                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/visacountry">ویزا </a></li>


                        <li><a href="javascript:;">درباره ما </a>
                            <ul class="nav-dropdown">

                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/aboutus">درباره ما </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری / کنسلی</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/rules">قوانین و مقررات</a></li>


                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/3">فرم ها </a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/employment">همکاری با ما </a></li>


                            </ul>
                        </li>

                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/contactus">تماس با ما </a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>


<div class="content_">

    <div class="container">

        <div class="row">

            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}

        </div>

    </div>

</div>



<div class="WaveFooter">
    <svg viewBox="0 0 2000 128">
        <use xlink:href="#WaveFooter">
            <symbol id="WaveFooter">
                <path opacity="0.2" fill="#43a5b5"
                      d="M-0.5,83.4c59.6,40.5,193.3,35,316.7-12.3C525.6-9.2,756.7-9.6,979.8,12.3s445.6,57.9,669.8,54.1C1821.1,63.5,1932,56,2000,53c0,36,0,76.4,0,76.4H1L-0.5,83.4z">
                </path>
                <path opacity="0.2" fill="#43a5b5"
                      d="M309.2,46.1c265.1-57.8,453.7-19.6,687.9,6.8c285.1,32.2,564.2,63,863.4,33.4c94-9.3,119.5-19.6,139.5-19c0,32.2,0,63,0,63H0v-66C0,64.3,152.7,80.2,309.2,46.1z">
                </path>
                <path opacity="0.4" fill="#43a5b5"
                      d="M344.5,54.9c82.3-26.3,167.2-46,253-36.5S767,51.6,851.9,67.8c272.3,52,522.5,16.7,819.3,5c90-3.5,293.8-13.6,328.8-12.6c0,24,0,71,0,71H-1v-59C-1,72.3,198.7,101.6,344.5,54.9z">
                </path>
                <path fill="#43a5b5"
                      d="M1731.8,97.1c-289.3,18.5-590.4,17.2-873.9-16.8C746,66.9,641.1,42.1,528.5,39.5s-249.3,31-353.7,69.9c-57.5,21.4-164.7,2.3-175.7-4.7c0,8,0,26.5,0,26.5h2003v-58C2002,73.3,1854.2,89.2,1731.8,97.1z">
                </path>

            </symbol>
        </use>
    </svg>
</div>
{if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
<footer>
    <div class="row layout-row layout-center foot-bottom">
        <div class="col-md-6 col-sm-7 LocationIcon">

        </div>

    </div>



    <div class="container">

        <div class="col-md-12">
            <div class="row">

{*                <div class="col-md-3 col-sm-6 col-xs-6 col-6 foot-menu-1">*}

{*                    <div class="widget-title">*}
{*                        <h4> پرواز داخلی </h4>*}
{*                        <hr>*}
{*                    </div>*}

{*                    <div class="row tours-foo">*}
{*                        <div class="col-md-6">*}
{*                            <ul class=" ">*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/local/1/THR-MHD/{$objDate->jtoday()}/Y/1-0-0/">تهران به مشهد</a></li>*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/local/1/THR-TBZ/{$objDate->jtoday()}/Y/1-0-0">تهران به تبریز*}
{*                                    </a></li>*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/local/1/THR-SYZ/{$objDate->jtoday()}/Y/1-0-0/"> تهران به شیراز</a></li>*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/local/1/THR-KIH/{$objDate->jtoday()}/Y/1-0-0/"> تهران به کیش</a></li>*}


{*                            </ul>*}
{*                        </div>*}
{*                        <div class="col-md-6">*}
{*                            <ul class="">*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/local/1/MHD-THR/{$objDate->jtoday()}/Y/1-0-0/"> مشهد به تهران</a></li>*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/local/1/MHD-TBZ/{$objDate->jtoday()}/Y/1-0-0/">مشهد به تبریز</a></li>*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/local/1/MHD-SYZ/{$objDate->jtoday()}/Y/1-0-0/">مشهد به شیراز</a></li>*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/local/1/MHD-KIH/{$objDate->jtoday()}/Y/1-0-0/">مشهد به کیش </a></li>*}


{*                            </ul>*}
{*                        </div>*}
{*                    </div>*}
{*                </div>*}

{*                <div class="col-md-3 col-sm-6 col-xs-6 col-6   foot-menu-1">*}

{*                    <div class="widget-title">*}
{*                        <h4>پرواز خارجی</h4>*}
{*                        <hr>*}
{*                    </div>*}


{*                    <div class="row tours-foo">*}
{*                        <div class="col-md-6">*}
{*                            <ul class=" ">*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/international/1/IKA-IST/{$objDate->jtoday()}/Y/1-0-0/"> تهران به استانبول </a></li>*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/international/1/IKA-DXB/{$objDate->jtoday()}/Y/1-0-0/"> تهران به دبی*}
{*                                    </a></li>*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/international/1/IKA-EVN/{$objDate->jtoday()}/Y/1-0-0/"> تهران به ایروان </a></li>*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/international/1/IKA-FRA/{$objDate->jtoday()}/Y/1-0-0/"> تهران به فرانکفورت </a></li>*}


{*                            </ul>*}
{*                        </div>*}
{*                        <div class="col-md-6">*}
{*                            <ul class="">*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/international/1/IKA-AYT/{$objDate->jtoday()}/Y/1-0-0/"> تهران به آنتالیا </a></li>*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/international/1/IKA-NJF/{$objDate->jtoday()}/Y/1-0-0/"> تهران به نجف </a></li>*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/international/1/IKA-GYD/{$objDate->jtoday()}/Y/1-0-0/"> تهران به باکو </a></li>*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/international/1/IKA-CDG/{$objDate->jtoday()}/Y/1-0-0/"> تهران به پاریس </a></li>*}


{*                            </ul>*}
{*                        </div>*}
{*                    </div>*}

{*                </div>*}
                <div class="col-md-4 col-sm-6 col-xs-6 col-12  foot-menu-1">

                    <div class="widget-title">
                        <h4>رزرو هتل </h4>
                        <hr>
                    </div>


                    <div class="row tours-foo">
                        <div class="col-md-6">
                            <ul class=" ">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/resultHotelLocal/56/{$objDate->jtoday()}/1"> رزرو هتل کیش </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/resultHotelLocal/1/{$objDate->jtoday()}/1"> رزرو هتل تهران
                                    </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/resultHotelLocal/66/{$objDate->jtoday()}/1"> رزرو هتل مشهد </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/resultHotelLocal/2/{$objDate->jtoday()}/1"> رزرو هتل اصفهان </a></li>


                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/resultHotelLocal/8/{$objDate->jtoday()}/1"> رزرو هتل شیراز </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/resultHotelLocal/10/{$objDate->jtoday()}/1">رزرو هتل قشم </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/resultHotelLocal/6/{$objDate->jtoday()}/1">رزرو هتل تبریز </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/resultHotelLocal/17/{$objDate->jtoday()}/1">رزرو هتل اهواز </a></li>


                            </ul>
                        </div>
                    </div>

                </div>
                <div class="col-md-4 col-sm-6 col-xs-6 col-12 foot-menu-1 foo-menu-2">

                    <div class="widget-title">
                        <h4> تماس با ما</h4>
                        <hr>
                    </div>


                    <ul>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>

                            <span class="SMFooterAddress">
{$smarty.const.CLIENT_ADDRESS}

                        </span>
                        </li>

                        <li>
                            <i class="fas fa-phone"></i>

                            <span class="SMFooterPhone"> {$smarty.const.CLIENT_PHONE}</span>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>

                            <span class="SMFooterPhone2"> 021-44388525  </span>
                        </li>

                        <li>
                            <i class="fas fa-mobile-alt"></i>

                            <span class="SMFooterMobile"> {$smarty.const.CLIENT_MOBILE} </span>
                        </li>


                        <li>
                            <i class="fas fa-at"></i>

                            <span class="SMFooterEmail">{$smarty.const.CLIENT_EMAIL}</span>
                        </li>


                    </ul>


                </div>
                <div class="col-md-4 col-sm-6 col-xs-6 col-12 my-2"><div id="g-map"></div></div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-4  col-xs-6  col-12 ">


                    <div class="footer-links">
                        <a target="_blank" href="https://www.cao.ir/paxrights">
                            <img src="project_files/images/certificate1.png" alt="حقوق مسافر">
                        </a>
                        <a target="_blank" href="https://www.cao.ir/">
                            <img src="project_files/images/certificate2.png" alt="سازمان هواپیمایی کشور">
                        </a>
                        <a target="_blank" href="http://aira.ir/images/FARE%2098.06.pdf">
                            <img src="project_files/images/certificate3.png" alt="نرخ بلیط">
                        </a>

                    </div>

                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 about_foo ">
                <p style="" class="">{$smarty.const.ABOUT_ME}</p>

            </div>

        </div>
    </div>

    </div>

    <div class="copy-right">
        <div class="container">
        <div class="row">


            <span class=""> کلیه حقوق وب سایت متعلق به <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">الهی گشت پارسه  </a> می باشد.</span>
            <span> <a style="color:#Fff;" href="https://www.iran-tech.com/"> طراحی سایت گردشگری  </a>:  ایران تکنولوژی </span>
        </div>



    </div>
    </div>
</footer>
{/if}


<a data-toggle="tooltip" data-placement="top" title="بازگشت به بالای صفحه" id="scroll-top"
   style="cursor: pointer; display: block;">
    <button><i class="fas fa-arrow-up"></i></button>
</a>
{literal}

    <link crossorigin="" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
          integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
          rel="stylesheet">
    <script crossorigin=""
            integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
            src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>
    <script type="text/javascript">
        // position we will use later ,

        var lat = 35.77237616933359;
        var lon = 51.36119919757461;
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
        marker.bindPopup("آقای تور").openPopup();
    </script>

    <script type="text/javascript">
        !(function(n, i, e, a) {
            ;(n.navigation = function(t, s) {
                var o = {
                        responsive: !0,
                        mobileBreakpoint: 991,
                        showDuration: 200,
                        hideDuration: 200,
                        showDelayDuration: 0,
                        hideDelayDuration: 0,
                        submenuTrigger: "hover",
                        effect: "fadeIn",
                        submenuIndicator: !0,
                        submenuIndicatorTrigger: !1,
                        hideSubWhenGoOut: !0,
                        visibleSubmenusOnMobile: !1,
                        fixed: !1,
                        overlay: !0,
                        overlayColor: "rgba(0, 0, 0, 0.5)",
                        hidden: !1,
                        hiddenOnMobile: !1,
                        offCanvasSide: "left",
                        offCanvasCloseButton: !0,
                        animationOnShow: "",
                        animationOnHide: "",
                        onInit: function() {},
                        onLandscape: function() {},
                        onPortrait: function() {},
                        onShowOffCanvas: function() {},
                        onHideOffCanvas: function() {}
                    },
                    r = this,
                    u = Number.MAX_VALUE,
                    d = 1,
                    l = "click.nav touchstart.nav",
                    f = "mouseenter focusin",
                    c = "mouseleave focusout"
                r.settings = {}
                var t = (n(t), t)
                n(t).find(".nav-search").length > 0 &&
                n(t)
                    .find(".nav-search")
                    .find("form")
                    .prepend(
                        "<span class='nav-search-close-button' tabindex='0'>&#10005;</span>"
                    ),
                    (r.init = function() {
                        ;(r.settings = n.extend({}, o, s)),
                        r.settings.offCanvasCloseButton &&
                        n(t)
                            .find(".nav-menus-wrapper")
                            .prepend(
                                "<span class='nav-menus-wrapper-close-button'>&#10005;</span>"
                            ),
                        "right" == r.settings.offCanvasSide &&
                        n(t)
                            .find(".nav-menus-wrapper")
                            .addClass("nav-menus-wrapper-right"),
                        r.settings.hidden &&
                        (n(t).addClass("navigation-hidden"),
                            (r.settings.mobileBreakpoint = 99999)),
                            v(),
                        r.settings.fixed && n(t).addClass("navigation-fixed"),
                            n(t)
                                .find(".nav-toggle")
                                .on("click touchstart", function(n) {
                                    n.stopPropagation(),
                                        n.preventDefault(),
                                        r.showOffcanvas(),
                                    s !== a && r.callback("onShowOffCanvas")
                                }),
                            n(t)
                                .find(".nav-menus-wrapper-close-button")
                                .on("click touchstart", function() {
                                    r.hideOffcanvas(), s !== a && r.callback("onHideOffCanvas")
                                }),
                            n(t)
                                .find(".nav-search-button, .nav-search-close-button")
                                .on("click touchstart keydown", function(i) {
                                    i.stopPropagation(), i.preventDefault()
                                    var e = i.keyCode || i.which
                                    "click" === i.type ||
                                    "touchstart" === i.type ||
                                    ("keydown" === i.type && 13 == e)
                                        ? r.toggleSearch()
                                        : 9 == e && n(i.target).blur()
                                }),
                        n(t).find(".megamenu-tabs").length > 0 && y(),
                            n(i).resize(function() {
                                r.initNavigationMode(C()), O(), r.settings.hiddenOnMobile && m()
                            }),
                            r.initNavigationMode(C()),
                        r.settings.hiddenOnMobile && m(),
                        s !== a && r.callback("onInit")
                    })
                var h = function() {
                        n(t)
                            .find(".nav-submenu")
                            .hide(0),
                            n(t)
                                .find("li")
                                .removeClass("focus")
                    },
                    v = function() {
                        n(t)
                            .find("li")
                            .each(function() {
                                n(this).children(".nav-dropdown,.megamenu-panel").length > 0 &&
                                (n(this)
                                    .children(".nav-dropdown,.megamenu-panel")
                                    .addClass("nav-submenu"),
                                r.settings.submenuIndicator &&
                                n(this)
                                    .children("a")
                                    .append(
                                        "<span class='submenu-indicator'><span class='submenu-indicator-chevron'></span></span>"
                                    ))
                            })
                    },
                    m = function() {
                        n(t).hasClass("navigation-portrait")
                            ? n(t).addClass("navigation-hidden")
                            : n(t).removeClass("navigation-hidden")
                    }
                    ;(r.showSubmenu = function(i, e) {
                    C() > r.settings.mobileBreakpoint &&
                    n(t)
                        .find(".nav-search")
                        .find("form")
                        .fadeOut(),
                        "fade" == e
                            ? n(i)
                                .children(".nav-submenu")
                                .stop(!0, !0)
                                .delay(r.settings.showDelayDuration)
                                .fadeIn(r.settings.showDuration)
                                .removeClass(r.settings.animationOnHide)
                                .addClass(r.settings.animationOnShow)
                            : n(i)
                                .children(".nav-submenu")
                                .stop(!0, !0)
                                .delay(r.settings.showDelayDuration)
                                .slideDown(r.settings.showDuration)
                                .removeClass(r.settings.animationOnHide)
                                .addClass(r.settings.animationOnShow),
                        n(i).addClass("focus")
                }),
                    (r.hideSubmenu = function(i, e) {
                        "fade" == e
                            ? n(i)
                                .find(".nav-submenu")
                                .stop(!0, !0)
                                .delay(r.settings.hideDelayDuration)
                                .fadeOut(r.settings.hideDuration)
                                .removeClass(r.settings.animationOnShow)
                                .addClass(r.settings.animationOnHide)
                            : n(i)
                                .find(".nav-submenu")
                                .stop(!0, !0)
                                .delay(r.settings.hideDelayDuration)
                                .slideUp(r.settings.hideDuration)
                                .removeClass(r.settings.animationOnShow)
                                .addClass(r.settings.animationOnHide),
                            n(i)
                                .removeClass("focus")
                                .find(".focus")
                                .removeClass("focus")
                    })
                var p = function() {
                        n("body").addClass("no-scroll"),
                        r.settings.overlay &&
                        (n(t).append("<div class='nav-overlay-panel'></div>"),
                            n(t)
                                .find(".nav-overlay-panel")
                                .css("background-color", r.settings.overlayColor)
                                .fadeIn(300)
                                .on("click touchstart", function(n) {
                                    r.hideOffcanvas()
                                }))
                    },
                    g = function() {
                        n("body").removeClass("no-scroll"),
                        r.settings.overlay &&
                        n(t)
                            .find(".nav-overlay-panel")
                            .fadeOut(400, function() {
                                n(this).remove()
                            })
                    }
                    ;(r.showOffcanvas = function() {
                    p(),
                        "left" == r.settings.offCanvasSide
                            ? n(t)
                                .find(".nav-menus-wrapper")
                                .css("transition-property", "left")
                                .addClass("nav-menus-wrapper-open")
                            : n(t)
                                .find(".nav-menus-wrapper")
                                .css("transition-property", "right")
                                .addClass("nav-menus-wrapper-open")
                }),
                    (r.hideOffcanvas = function() {
                        n(t)
                            .find(".nav-menus-wrapper")
                            .removeClass("nav-menus-wrapper-open")
                            .on(
                                "webkitTransitionEnd moztransitionend transitionend oTransitionEnd",
                                function() {
                                    n(t)
                                        .find(".nav-menus-wrapper")
                                        .css("transition-property", "none")
                                        .off()
                                }
                            ),
                            g()
                    }),
                    (r.toggleOffcanvas = function() {
                        C() <= r.settings.mobileBreakpoint &&
                        (n(t)
                            .find(".nav-menus-wrapper")
                            .hasClass("nav-menus-wrapper-open")
                            ? (r.hideOffcanvas(), s !== a && r.callback("onHideOffCanvas"))
                            : (r.showOffcanvas(), s !== a && r.callback("onShowOffCanvas")))
                    }),
                    (r.toggleSearch = function() {
                        "none" ==
                        n(t)
                            .find(".nav-search")
                            .find("form")
                            .css("display")
                            ? (n(t)
                                .find(".nav-search")
                                .find("form")
                                .fadeIn(200),
                                n(t)
                                    .find(".nav-search")
                                    .find("input")
                                    .focus())
                            : (n(t)
                                .find(".nav-search")
                                .find("form")
                                .fadeOut(200),
                                n(t)
                                    .find(".nav-search")
                                    .find("input")
                                    .blur())
                    }),
                    (r.initNavigationMode = function(i) {
                        r.settings.responsive
                            ? (i <= r.settings.mobileBreakpoint &&
                            u > r.settings.mobileBreakpoint &&
                            (n(t)
                                .addClass("navigation-portrait")
                                .removeClass("navigation-landscape"),
                                S(),
                            s !== a && r.callback("onPortrait")),
                            i > r.settings.mobileBreakpoint &&
                            d <= r.settings.mobileBreakpoint &&
                            (n(t)
                                .addClass("navigation-landscape")
                                .removeClass("navigation-portrait"),
                                k(),
                                g(),
                                r.hideOffcanvas(),
                            s !== a && r.callback("onLandscape")),
                                (u = i),
                                (d = i))
                            : (n(t).addClass("navigation-landscape"),
                                k(),
                            s !== a && r.callback("onLandscape"))
                    })
                var b = function() {
                        n("html").on("click.body touchstart.body", function(i) {
                            0 === n(i.target).closest(".navigation").length &&
                            (n(t)
                                .find(".nav-submenu")
                                .fadeOut(),
                                n(t)
                                    .find(".focus")
                                    .removeClass("focus"),
                                n(t)
                                    .find(".nav-search")
                                    .find("form")
                                    .fadeOut())
                        })
                    },
                    C = function() {
                        return (
                            i.innerWidth || e.documentElement.clientWidth || e.body.clientWidth
                        )
                    },
                    w = function() {
                        n(t)
                            .find(".nav-menu")
                            .find("li, a")
                            .off(l)
                            .off(f)
                            .off(c)
                    },
                    O = function() {
                        if (C() > r.settings.mobileBreakpoint) {
                            var i = n(t).outerWidth(!0)
                            n(t)
                                .find(".nav-menu")
                                .children("li")
                                .children(".nav-submenu")
                                .each(function() {
                                    n(this)
                                        .parent()
                                        .position().left +
                                    n(this).outerWidth() >
                                    i
                                        ? n(this).css("right", 0)
                                        : n(this).css("right", "auto")
                                })
                        }
                    },
                    y = function() {
                        function i(i) {
                            var e = n(i)
                                    .children(".megamenu-tabs-nav")
                                    .children("li"),
                                a = n(i).children(".megamenu-tabs-pane")
                            n(e).on("click.tabs touchstart.tabs", function(i) {
                                i.stopPropagation(),
                                    i.preventDefault(),
                                    n(e).removeClass("active"),
                                    n(this).addClass("active"),
                                    n(a)
                                        .hide(0)
                                        .removeClass("active"),
                                    n(a[n(this).index()])
                                        .show(0)
                                        .addClass("active")
                            })
                        }
                        if (n(t).find(".megamenu-tabs").length > 0)
                            for (var e = n(t).find(".megamenu-tabs"), a = 0; a < e.length; a++)
                                i(e[a])
                    },
                    k = function() {
                        w(),
                            h(),
                            navigator.userAgent.match(/Mobi/i) ||
                            navigator.maxTouchPoints > 0 ||
                            "click" == r.settings.submenuTrigger
                                ? n(t)
                                    .find(".nav-menu, .nav-dropdown")
                                    .children("li")
                                    .children("a")
                                    .on(l, function(e) {
                                        if (
                                            (r.hideSubmenu(
                                                n(this)
                                                    .parent("li")
                                                    .siblings("li"),
                                                r.settings.effect
                                            ),
                                                n(this)
                                                    .closest(".nav-menu")
                                                    .siblings(".nav-menu")
                                                    .find(".nav-submenu")
                                                    .fadeOut(r.settings.hideDuration),
                                            n(this).siblings(".nav-submenu").length > 0)
                                        ) {
                                            if (
                                                (e.stopPropagation(),
                                                    e.preventDefault(),
                                                "none" ==
                                                n(this)
                                                    .siblings(".nav-submenu")
                                                    .css("display"))
                                            )
                                                return (
                                                    r.showSubmenu(
                                                        n(this).parent("li"),
                                                        r.settings.effect
                                                    ),
                                                        O(),
                                                        !1
                                                )
                                            if (
                                                (r.hideSubmenu(n(this).parent("li"), r.settings.effect),
                                                "_blank" === n(this).attr("target") ||
                                                "blank" === n(this).attr("target"))
                                            )
                                                i.open(n(this).attr("href"))
                                            else {
                                                if (
                                                    "#" === n(this).attr("href") ||
                                                    "" === n(this).attr("href") ||
                                                    "javascript:void(0)" === n(this).attr("href")
                                                )
                                                    return !1
                                                i.location.href = n(this).attr("href")
                                            }
                                        }
                                    })
                                : n(t)
                                    .find(".nav-menu")
                                    .find("li")
                                    .on(f, function() {
                                        r.showSubmenu(this, r.settings.effect), O()
                                    })
                                    .on(c, function() {
                                        r.hideSubmenu(this, r.settings.effect)
                                    }),
                        r.settings.hideSubWhenGoOut && b()
                    },
                    S = function() {
                        w(),
                            h(),
                            r.settings.visibleSubmenusOnMobile
                                ? n(t)
                                    .find(".nav-submenu")
                                    .show(0)
                                : (n(t)
                                    .find(".submenu-indicator")
                                    .removeClass("submenu-indicator-up"),
                                    r.settings.submenuIndicator &&
                                    r.settings.submenuIndicatorTrigger
                                        ? n(t)
                                            .find(".submenu-indicator")
                                            .on(l, function(i) {
                                                return (
                                                    i.stopPropagation(),
                                                        i.preventDefault(),
                                                        r.hideSubmenu(
                                                            n(this)
                                                                .parent("a")
                                                                .parent("li")
                                                                .siblings("li"),
                                                            "slide"
                                                        ),
                                                        r.hideSubmenu(
                                                            n(this)
                                                                .closest(".nav-menu")
                                                                .siblings(".nav-menu")
                                                                .children("li"),
                                                            "slide"
                                                        ),
                                                        "none" ==
                                                        n(this)
                                                            .parent("a")
                                                            .siblings(".nav-submenu")
                                                            .css("display")
                                                            ? (n(this).addClass("submenu-indicator-up"),
                                                                n(this)
                                                                    .parent("a")
                                                                    .parent("li")
                                                                    .siblings("li")
                                                                    .find(".submenu-indicator")
                                                                    .removeClass("submenu-indicator-up"),
                                                                n(this)
                                                                    .closest(".nav-menu")
                                                                    .siblings(".nav-menu")
                                                                    .find(".submenu-indicator")
                                                                    .removeClass("submenu-indicator-up"),
                                                                r.showSubmenu(
                                                                    n(this)
                                                                        .parent("a")
                                                                        .parent("li"),
                                                                    "slide"
                                                                ),
                                                                !1)
                                                            : (n(this)
                                                                .parent("a")
                                                                .parent("li")
                                                                .find(".submenu-indicator")
                                                                .removeClass("submenu-indicator-up"),
                                                                void r.hideSubmenu(
                                                                    n(this)
                                                                        .parent("a")
                                                                        .parent("li"),
                                                                    "slide"
                                                                ))
                                                )
                                            })
                                        : n(t)
                                            .find(".nav-menu, .nav-dropdown")
                                            .children("li")
                                            .children("a")
                                            .on(l, function(e) {
                                                if (
                                                    (e.stopPropagation(),
                                                        e.preventDefault(),
                                                        r.hideSubmenu(
                                                            n(this)
                                                                .parent("li")
                                                                .siblings("li"),
                                                            r.settings.effect
                                                        ),
                                                        r.hideSubmenu(
                                                            n(this)
                                                                .closest(".nav-menu")
                                                                .siblings(".nav-menu")
                                                                .children("li"),
                                                            "slide"
                                                        ),
                                                    "none" ==
                                                    n(this)
                                                        .siblings(".nav-submenu")
                                                        .css("display"))
                                                )
                                                    return (
                                                        n(this)
                                                            .children(".submenu-indicator")
                                                            .addClass("submenu-indicator-up"),
                                                            n(this)
                                                                .parent("li")
                                                                .siblings("li")
                                                                .find(".submenu-indicator")
                                                                .removeClass("submenu-indicator-up"),
                                                            n(this)
                                                                .closest(".nav-menu")
                                                                .siblings(".nav-menu")
                                                                .find(".submenu-indicator")
                                                                .removeClass("submenu-indicator-up"),
                                                            r.showSubmenu(n(this).parent("li"), "slide"),
                                                            !1
                                                    )
                                                if (
                                                    (n(this)
                                                        .parent("li")
                                                        .find(".submenu-indicator")
                                                        .removeClass("submenu-indicator-up"),
                                                        r.hideSubmenu(n(this).parent("li"), "slide"),
                                                    "_blank" === n(this).attr("target") ||
                                                    "blank" === n(this).attr("target"))
                                                )
                                                    i.open(n(this).attr("href"))
                                                else {
                                                    if (
                                                        "#" === n(this).attr("href") ||
                                                        "" === n(this).attr("href") ||
                                                        "javascript:void(0)" === n(this).attr("href")
                                                    )
                                                        return !1
                                                    i.location.href = n(this).attr("href")
                                                }
                                            }))
                    }
                    ;(r.callback = function(n) {
                    s[n] !== a && s[n].call(t)
                }),
                    r.init()
            }),
                (n.fn.navigation = function(i) {
                    return this.each(function() {
                        if (a === n(this).data("navigation")) {
                            var e = new n.navigation(this, i)
                            n(this).data("navigation", e)
                        }
                    })
                })
        })(jQuery, window, document)

        ;(function($) {
            "use strict"

            var $window = $(window)

            if ($.fn.navigation) {
                $(".navigation").navigation()
                $("#always-hidden-nav").navigation({
                    hidden: true
                })
            }

            $window.on("load", function() {
                $("#preloader").fadeOut("slow", function() {
                    $(this).remove()
                })
            })
        })(jQuery)




        $(document).ready(function () {



            var heiw = $(window).height();
            var heiheader = $('.header_area').height();


            $('.content_').css('min-height' , heiw);

            var winh = $(window).width();

            if($(window).width() > 990){

                $('.banner').css('height' ,heiw - heiheader);
            }


            $("#scroll-top").hide();
            // fade in #back-top
            $(function () {
                $(window).scroll(function () {
                    if ($(this).scrollTop() > 100) {
                        $('#scroll-top').fadeIn();
                    } else {
                        $('#scroll-top').fadeOut();
                    }
                });
                // scroll body to 0px on click
                $('#scroll-top button').click(function () {
                    $('body,html').animate({
                        scrollTop: 0
                    }, 800);
                });
            });






            $(window).scroll(function () {

                var sctop = $(this).scrollTop();

                if(sctop > 50){


                    $('.header_area').addClass('fixedmenu');


                }
                else{

                    $('.header_area').removeClass('fixedmenu');


                }


            });



            $('.carousel').carousel({
                interval: 4000
            });




            $('.top__user_menu').bind('click', function(e){
                //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
                e.stopPropagation();

            });

            $('.box-of-count-nafar').bind('click', function(e){
                //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
                e.stopPropagation();

            });

            $('body').click(function () {

                $('.main-navigation__sub-menu').hide();
                $('.button-chevron').removeClass('rotate');

                $('.cbox-count-nafar').hide();
                $(this).parents().find('.down-count-nafar').removeClass('fa-caret-up');
            });




        });
</script>
{/literal}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
</body>
</html>