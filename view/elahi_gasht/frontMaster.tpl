{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{assign var="hashedPass" value=functions::HashKey({$smarty.session.cardNo},'encrypt')}
<!DOCTYPE html>

<html class="no-js" lang="en">

<head>
    <title>{$obj->Title_head()}</title>
    <link rel="shortcut icon" type="image/x-icon" href="project_files/images/Logo.png"/>
    <meta name="description" content="{$obj->Title_head()}">
    <meta charset="UTF-8">
    <base href="{$smarty.const.CLIENT_DOMAIN}"/>
    <!-- Main CSS files -->
    <link rel="stylesheet" href="project_files/css/baseFa.css">
    <link rel="stylesheet" type="text/css" href="project_files/css/camera.css">
    <!-- Animation CSS file -->
    <link rel="stylesheet" href="project_files/css/animate.css">
    <!-- custom CSS file -->
    <!-- <link rel="stylesheet" href="project_files/css/jquery.scrollbar.css"> -->
    <link rel="stylesheet" href="project_files/css/custom.css">
    <!-- plugin css file -->
    <link rel="stylesheet" href="project_files/css/plugin.css">
    <link rel="stylesheet" href="project_files/css/responsive.css">
    <!-- jQuery Library files -->
    <script src="project_files/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="project_files/js/modernizr.js"></script>
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}
</head>
<body>


<div class="body-wrapper ">

    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation}
        <div class="nav_top">

            <div class="container">

                <div class="row">
                    <div class="reg-div">
                        {if $objSession->IsLogin()}
                            <ul>
                                <li>
                                    <div class="dashboard_menu">
                                        <button><i class="fa dashboard" aria-hidden="true">داشبورد</i></button>
                                        <ul id="dropdown-list">

                                            <li>
                                                <a href="{$smarty.const.ROOT_ADDRESS}/userProfile">
                                                    <i class="fa fa-user margin-left-10 font-i"></i>اطلاعات
                                                    کاربری</a>
                                            </li>
                                            <li>
                                                <a href="{$smarty.const.ROOT_ADDRESS}/UserBuy">
                                                    <i class="fa fa-shopping-cart margin-left-10 font-i"></i>مشاهده
                                                    خرید / استرداد </a>
                                            </li>
                                            <li>
                                                <a href="{$smarty.const.ROOT_ADDRESS}/TrackingCancelTicket">
                                                    <i class="fa fa-ban  margin-left-10 font-i"></i> سوابق کنسلی</a>
                                            </li>

                                            {if $smarty.const.IS_ENABLE_CLUB eq 1}
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/login.php?clubID={$hashedPass}">
                                                        <i class="fa fa-users  margin-left-10 font-i"></i> ورود به
                                                        باشگاه</a>
                                                </li>
                                            {/if}
                                            {if $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter'}
                                                <li>
                                                    <a href="{$smarty.const.ROOT_ADDRESS}/Emerald">
                                                        <i class="fa fa-diamond margin-left-10 font-i"></i>زمرد</a>
                                                </li>
                                                <li>
                                                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/Emerald/rahnamaye_zomorod_360.pdf">
                                                        <i class="fa fa-book margin-left-10 font-i"></i>راهنمای دریافت زمرد</a>
                                                </li>
                                            {/if}
                                            <li>
                                                <a href="{$smarty.const.ROOT_ADDRESS}/UserPass">
                                                    <i class="fa fa-key margin-left-10 font-i"></i>تغییر کلمه
                                                    عبور</a>
                                            </li>
                                            <li>
                                                <a class="icon icon-study" href="javascript:;" onclick="signout()">
                                                    <i class="fa fa-sign-out margin-left-10 font-i"></i>خروج</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <a class="userProfile-name user-profile" href="{$smarty.const.ROOT_ADDRESS}/userProfile">
                                        <span>دوست عزیز {$objSession->getNameUser()} خوش آمدید</span>
                                        {assign var="typeMember" value=$objFunctions->TypeUser($objSession->getUserId())}
                                        {if $typeMember eq 'Counter'}
                                            <span class="CreditHide yekanB">اعتبار آژانس شما {$objFunctions->CalculateCredit($objSession->getUserId())}
                                                ریال می باشد </span>
                                        {elseif $typeMember eq 'Ponline'}
                                            {assign var="infoMember" value=$objFunctions->infoMember($objSession->getUserId())}
                                            {if $infoMember.is_member eq '1' && $infoMember.fk_counter_type_id eq '5'}
                                                <span class="CreditHide yekanB">اعتبار شما {$objFunctions->getOnlineMemberCredit()|number_format}
                                                    ریال می باشد </span>
                                            {/if}
                                        {/if}
                                    </a>

                                </li>
                            </ul>
                        {else}

                            <ul>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/registerUser"><i
                                                class="flaticon flaticon_reg"></i>ثبت نام </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/loginUser"><i
                                                class="flaticon flaticon_log"></i>
                                        ورود </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking"><i
                                                class="flaticon flaticon_pei"></i> پیگیری خرید </a></li>
                            </ul>
                        {/if}

                    </div>



                </div>

            </div>

        </div>
        <div class="top-wrapper">


            <header>
                <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/user/home.php/"
                   class="lang">EN</a>
                <div class="container">
                    <div class="logo-title">
                        <a class="logo" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/"><img
                                    src="project_files/images/logo.png"
                                    alt="logo"></a>
                        <div class="title">
                            <h1><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/">الهی گشت پارسه</a></h1>
                            <h2>آژانس خدمات مسافرتی و گردشگری</h2>
                        </div>
                    </div>

                    <div class="top-menu">
                        <a href="javascript:;" class="mobMenu"></a>

                        <div class="mainMenuContainer yekan">
                            <span class="close-menu"></span>

                            <ul class="mainMenu">
                                <li class=""><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/">صفحه اصلی</a></li>
                                <li><a class="hvr-underline-from-right" href="javascript:;">تور داخلی</a>
                                    <ul class="subMenu">

                                        <li class="other-tour"><a class="SMTourLocal"
                                                                  href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=irantourcity&level=1">کلیه
                                                تورها</a></li>
                                    </ul>
                                </li>

                                <li><a class="hvr-underline-from-right" href="javascript:;">تور خارجی</a>
                                    <ul class="subMenu">


                                        <li class="other-tour"><a class="SMTourPortal"
                                                                  href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=countrytour&level=1">کلیه
                                                تورها</a></li>
                                    </ul>
                                </li>

                                <li><a class="hvr-underline-from-right" href="javascript:;">تورهای ویژه
                                        <ul class="subMenu">
                                            <li><a class="SMTourLocalSpecial"
                                                   href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=irantourcity&level=1&special=1">تورهای
                                                    ویژه داخلی

                                            <li><a class="SMTourPortalSpecial"
                                                   href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=countrytour&level=1&special=1">تورهای
                                                    ویژه خارجی
                                        </ul>
                                </li>
                                <li><a class="hvr-underline-from-right SMContactUs"
                                       href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=rules">
                                        قوانین و مقررات</a></li>
                                <li><a class="hvr-underline-from-right SMContactUs"
                                       href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=contactus">تماس
                                        با ما</a></li>
                            </ul>
                        </div>


                    </div>


                </div>


                <!-- menu-->


            </header>

        </div>
    {/if}

    <!-- end top wrapper -->
    <div class="clear"></div>


    <!-- temp -->
    <div class="container temp">
        <div class="temp-content">

            <div class="clear"></div>
            <div class="temp-wrapper">
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
            </div>
        </div>

    </div>
    <!-- end temp -->


    <!--Footer-->
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
        <footer>
            <div id="g-map"></div>
            <div class="top-footer wow fadeInUp">
                <div class="container">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 f-wrapper">
                        <div class="col-lg-12 col-xs-12">
                            <p class="txt14 txtCenter txt111 lh20 padr10 marb10" dir="rtl"><a
                                        href="http://maps.google.com/?q=تهران خیابان ستارخان"><span
                                            class="f-address"></span></a>{$smarty.const.CLIENT_ADDRESS}</p>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <p class="txtCenter lh20 padr10 marb10" dir="ltr"><span class="f-tel"></span><span
                                        class="ltr"><a href="tel:{$smarty.const.CLIENT_PHONE}"
                                                       class="SMFooterPhone txt18 txt111 yekan padr15">{$smarty.const.CLIENT_PHONE}</a></span>
                            </p>

                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <p class="txtCenter lh20 padr10 marb10" dir="rtl"><span class="f-email"></span><a
                                        href="mailto:{$smarty.const.CLIENT_EMAIL}"
                                        class="SMFooterEmail txt16 txt111 tdNU padr15"> {$smarty.const.CLIENT_EMAIL}</a>
                            </p>

                            <!-- social icons -->


                        </div>
                    </div>


                </div>

                <div class="copyright ">
                    <div class="container">
                        <div class="col-lg-12  col-xs-12 company ">
                            <p class="txt14 yekan txt333">کلیه حقوق وب سایت متعلق به <a
                                        href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/">الهی گشت پارسه</a> می باشد.
                            </p>
                        </div>
                        <div class="col-lg-12 col-xs-12 irantech ">
                            <p class="txt14 yekan txt333">طراحی وب سایت: <a class="it-logo" href="http://iran-tech.com/"
                                                                            target="_blank">ایران تکنولوژی</a><a
                                        href="http://www.safarbank.ir/tour/" target="_blank" class="cheapTour">تور
                                    ارزان</a>
                            </p>
                        </div>
                    </div>
                </div>


            </div>


            <!--CopyRight-->


        </footer>
    {/if}
</div>

<!--BACK TO TOP BUTTON-->
<div class="backToTop"></div>


<!--Google Map-->
<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtZ3tGybs75zk_7ic_Fij2QbqyFyG7wRU"></script>
{literal}
    <script type="text/javascript">
        // When the window has finished loading create our google map below
        google.maps.event.addDomListener(window, 'load', init);

        function init() {
            // Basic options for a simple Google Map
            var mapOptions = {
                zoom: 16,
                scrollwheel: false,
                center: new google.maps.LatLng(35.721400, 51.344994),
                mapTypeControlOptions: {
                    mapTypeIds: [google.maps.MapTypeId.TERRAIN]
                },
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                // changing colors style goes her
                styles: [{
                    "featureType": "landscape",
                    "stylers": [{"hue": "#FFBB00"}, {"saturation": 43.400000000000006}, {"lightness": 37.599999999999994}, {"gamma": 1}]
                }, {
                    "featureType": "road.highway",
                    "stylers": [{"hue": "#FFC200"}, {"saturation": -61.8}, {"lightness": 45.599999999999994}, {"gamma": 1}]
                }, {
                    "featureType": "road.arterial",
                    "stylers": [{"hue": "#FF0300"}, {"saturation": -100}, {"lightness": 51.19999999999999}, {"gamma": 1}]
                }, {
                    "featureType": "road.local",
                    "stylers": [{"hue": "#FF0300"}, {"saturation": -100}, {"lightness": 52}, {"gamma": 1}]
                }, {
                    "featureType": "water",
                    "stylers": [{"hue": "javascript:;078FF"}, {"saturation": -13.200000000000003}, {"lightness": 2.4000000000000057}, {"gamma": 1}]
                }, {
                    "featureType": "poi",
                    "stylers": [{"hue": "javascript:;0FF6A"}, {"saturation": -1.0989010989011234}, {"lightness": 11.200000000000017}, {"gamma": 1}]
                }]
            };
            var mapElement = document.getElementById('g-map');
            var map = new google.maps.Map(mapElement, mapOptions);
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(35.721400, 51.344994),
                map: map,
                title: 'الهی گشت پارسه',
                icon: 'project_files/images/nav.png'
            });
            var infowindow = new google.maps.InfoWindow({
                content: '<div class="googleLabel">ستارخان ، بعد از چهارراه اسدی ، مجتمع تجاری مروارید ، طبقه دوم ، واحد 29</div>'
            });
            google.maps.event.addListener(marker, 'click', function () {
                infowindow.open(map, marker);
            });

//            infowindow.open(map,marker);
        }
    </script>
    <!-- jQuery Site Scipts -->
    <script>
        wow = new WOW();
        wow.init();
    </script>
{/literal}
<script src="project_files/js/script.js"></script>
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
</body>
</html>











