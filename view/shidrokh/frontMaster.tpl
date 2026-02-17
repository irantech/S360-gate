{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="dateTimeSetting" assign="objDate"}
{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{load_presentation_object filename="contactUs" assign="objContact"}

{if $smarty.session['userId'] }
    {assign var="userInfo" value=functions::infoMember($smarty.session.userId)}
    {assign var="hashedPass" value=functions::HashKey({$userInfo['email']},'encrypt')}
{/if}
<!doctype html>
<html lang="fa">
<head>
    <title>{$obj->Title_head()}</title>
    <base href="{$smarty.const.CLIENT_DOMAIN}"/>

    <meta charset="utf-8">
    <meta name="description" content="{$obj->Title_head()}">
    <meta name="application-name" content="default"/>
    <meta name="author" content="Iran Technology LTD"/>
    <meta name="generator" content="Iran teach"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, user-scalable=0">

    <link rel="stylesheet" type="text/css" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/GlobalFile/css/register.css">
    <link rel="shortcut icon" type="image/png" href="project_files/images/favicon.png">
    

    {literal}
        <script src="project_files/js/jquery-3.4.1.min.js"></script>

    {/literal}

    {if $smarty.session.layout neq 'pwa'}
        <link rel="stylesheet" href="project_files/css/all.min.css">
{*        <link rel="stylesheet" href="project_files/css/fontawesome.min.css">*}
        <link rel="stylesheet" href="project_files/css/style.css">
    {/if}

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}




</head>
{if $smarty.session.layout neq 'pwa' }

<body class="">
<div class="slider">
    <div class="slider-parent-temp" style="height: 150px">
        <div class="logo" style="width: 100px">
            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}"><img src="project_files/images/logo.png" alt=""></a>
        </div>
        <div class="member-parent">
            <div class="menu-login">
                <div class="c-header__btn">
                    <div class="c-header__btn-login" href="javascript:">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="logined-vorood text-dark">
                            <div class='login-div-shidrokh-360'>ثبت نام در شیدرخ تراول</div>


                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 491.996 491.996" style="enable-background:new 0 0 491.996 491.996;" xml:space="preserve">
                                <g>
                                    <g>
                                        <path d="M484.132,124.986l-16.116-16.228c-5.072-5.068-11.82-7.86-19.032-7.86c-7.208,0-13.964,2.792-19.036,7.86l-183.84,183.848
                                            L62.056,108.554c-5.064-5.068-11.82-7.856-19.028-7.856s-13.968,2.788-19.036,7.856l-16.12,16.128
                                            c-10.496,10.488-10.496,27.572,0,38.06l219.136,219.924c5.064,5.064,11.812,8.632,19.084,8.632h0.084
                                            c7.212,0,13.96-3.572,19.024-8.632l218.932-219.328c5.072-5.064,7.856-12.016,7.864-19.224
                                            C491.996,136.902,489.204,130.046,484.132,124.986z"></path>
                                    </g>
                                </g>

                            </svg>

                        </span>
                    </div>
                    <div class="main-navigation__sub-menu2 arrow-up">
                        <iframe style="height: 245px;"
                                src="https://online.shidrokh-travel.ir/gds/iframe&shidrokh&topBarMain"
                                width="100%" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <ul class="tools add-right-xs">
            <li class="phone-tool">
                <a class="SMFooterPhone2" href=""><i class=" fas fa-phone"></i></a>

                <div class="tooldropdown">
                            <span class="info">
                                <span class="title">دفتر: </span>
                                <a class="details "  href="tel:{$smarty.const.CLIENT_PHONE}"></a>
                            </span>
                    <div class="grey">
                                <span class="info">
                                <span class="title">شماره ضروری: </span>
                                <a class="details " href="tel:{$smarty.const.CLIENT_MOBILE}"></a>
                            </span>
                    </div>
                </div>
            </li>
            <li class="marker-tool">
                <i class="fas fa-map-marker-alt"></i>
                <div class="tooldropdown">
                            <span class="info">
                                <span class="title">آدرس: </span>
                                <a class="details "  href="">{$smarty.const.CLIENT_ADDRESS}</a>
                            </span>
                </div>
            </li>
            <li class="contact-tool">

                <a class="SMFooterEmail2" href=""><i class="fas fa-envelope "></i></a>
                <div class="tooldropdown">
                            <span class="info">
                                <span class="title">ایمیل: </span>
                                <a class="details "  href="mailto:{$smarty.const.CLIENT_EMAIL}">{$smarty.const.CLIENT_EMAIL}</a>
                            </span>
                </div>
            </li>
        </ul>
    </div>
</div>
<div class="WhatsApp-Icon">
    <a href="https://api.whatsapp.com/send?phone=+9809170666574">
        <img src="project_files/images/whatsapp.png" alt="واتساپ" style="width: 40px">

    </a>
</div>
</div>
<div class="header-mob d-md-none d-lg-none">
    <div class="container">
        <div class="row">
            <div class="col main_nav_col d-flex flex-row align-items-center justify-content-start">
                <ul class="tools-mob">
                    <li class="phone-tool" onclick="ToggleTools(this)">
                        <i class="fas fa-phone"></i>
                        <div class="tooldropdown">
									<span class="info">
										<span class="title">Main Office</span>
										<a class="details" href="tel:+917 4 259074">+917 4 259074</a>
									</span>
                            <span class="info">
										<span class="title">Jounieh</span>
										<a class="details" href="tel:+917 4 259074">+917 4 259074</a>
									</span>
                            <div class="grey">
										<span class="info">
										<span class="title">Emergency number</span>
										<a class="details" href="tel:+917 4 259074">+917 4 259074</a>
									</span>
                            </div>
                        </div>
                    </li>
                    <li class="marker-tool" onclick="ToggleTools(this)">
                        <i class="fas fa-map-marker-alt"></i>
                        <div class="tooldropdown">
									<span class="info">
										<span class="title">Main Office</span>
										<a class="details" href="tel:+917 4 259074">+917 4 259074</a>
									</span>
                            <span class="info">
										<span class="title">Jounieh</span>
										<a class="details" href="tel:+917 4 259074">+917 4 259074</a>
									</span>
                            <div class="grey">
										<span class="info">
										<span class="title">Emergency number</span>
										<a class="details" href="tel:+917 4 259074">+917 4 259074</a>
									</span>
                            </div>
                        </div>
                    </li>
                    <li class="contact-tool" onclick="ToggleTools(this)">
                        <i class="fas fa-envelope"></i>
                        <div class="tooldropdown">
									<span class="info">
										<span class="title">Main Office</span>
										<a class="details" href="tel:+917 4 259074">+917 4 259074</a>
									</span>
                            <span class="info">
										<span class="title">Jounieh</span>
										<a class="details" href="tel:+917 4 259074">+917 4 259074</a>
									</span>
                            <div class="grey">
										<span class="info">
										<span class="title">Emergency number</span>
										<a class="details" href="tel:+917 4 259074">+917 4 259074</a>
									</span>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="hamburger mr-lg-0 mr-auto">
                    <i class="fa fa-bars trans_200"></i>
                </div>

            </div>

        </div>
    </div>

</div>


<header class="d-none d-md-block header-lg" id="main-search">
    <div class="container">
        <div class="header_items">
            <div class="logo logo_header_items">
                <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}"><img src="project_files/images/logo-2.png" alt="شیدرخ"></a>
            </div>
            <div id="bg-xs">
                <nav class="nav">
                    <span class="nav-menus-wrapper-close-button  hidden-lg-up" id="closeNav">✕</span>
                    <ul>
                        <li class="has-sub">
                            <a href="">صفحه اصلی</a>
                        </li>
                        <li class="has-sub">
                            <a class="SMAbout" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/aboutus">درباره شیدرخ</a>
                        </li>
                        <li class="has-sub">
                            <a class="SMContactUs" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/contactus">تماس با شیدرخ</a>
                        </li>
                        <li class="has-sub">
                            <a href="javascript:">تورها</a>
                            <div class="sub-menu dropdown-xs bottomA">
                                <ul>
                                    <li class="has-sub2">
                                        <a href="javascript:">تور های داخلی</a>
                                        <span class="submenu-indicator">
                                            <span class="submenu-indicator-chevron"></span>
                                        </span>
                                        <div class="sub-menu2 up dropdown-xs">
                                            <ul class="">

                                                {assign var="tourListConditions" value=[
                                                [
                                                "index" => "is_show",
                                                "table" => "reservation_tour_tb",
                                                "value" => "yes"
                                                ],
                                                [
                                                "index" => "is_del",
                                                "table" => "reservation_tour_tb",
                                                "value" => "no"
                                                ]
                                                ]}

                                                {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCities('=1', 'return')}
                                                    <li>
                                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-{$item_tour.id}/{$objDate->jdate("Y-m-d", '', '', '', 'en')}/all">
                                                            {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                        </a>
                                                    </li>
                                                {/foreach}

                                            </ul>
                                        </div>
                                    </li>
                                    <li class="has-sub2"><a href="javascript:">تورهای خارجی</a>
                                        <span class="submenu-indicator"><span class="submenu-indicator-chevron"></span></span>
                                        <div class="sub-menu2 up dropdown-xs">
                                            <ul class="">


                                                {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries('yes')}
                                                    <li>
                                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/{$objDate->jdate("Y-m-d", '', '', '', 'en')}/all">
                                                            {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                        </a>
                                                    </li>
                                                {/foreach}
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="has-sub2"><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/15">سفر به سلیقه شخصی</a></li>
                                    <li class="has-sub2">
                                        <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/2">تور عشایر</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="has-sub">
                            <a href="javascript:">تورهای ویژه</a>
                            <div class="mega-menu dropdown-xs bottomA">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sub-padd">
                                            <ul>
                                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/17">تور بانوان</a></li>
                                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/16">تور سالمندان</a></li>
                                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/18">تور کودک</a></li>
                                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/19">تور ماه عسل</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-4 col-mg-4 col-sm-12 col-xs-12 sub-padd">
                                            <ul>
                                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/20">تور سلامت</a></li>
                                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/21">تور معلولین	</a></li>
                                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/3">تور شکم گردی</a></li>
                                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/22">روستاگردی</a></li>
                                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/23">تور طبیعت گردی</a></li>

                                            </ul>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12  sub-padd">
                                            <ul>
                                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/24">تور مرمت</a></li>
                                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/25">تور عکاسی</a></li>
                                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/26">تور دوچرخه سواری</a></li>
                                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/27">تور پیاده روی</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="has-sub">
                            <a href="javascript:">خدمات شیدرخ</a>
                            <div class="sub-menu dropdown-xs up bottomA">
                                <ul>
                                    <li class="has-sub2">
                                        <a href="javascript:" >اسکان</a>
                                        <span class="submenu-indicator">
                                            <span class="submenu-indicator-chevron"></span>
                                        </span>
                                        <div class="sub-menu2 up dropdown-xs">
                                            <ul class="">
                                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/4">هتل</a></li>
                                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/5">بومگردی روستایی</a></li>
                                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/6">اقامتگاه سنتی</a></li>

                                            </ul>
                                        </div>
                                    </li>
                                    <li class="has-sub2">
                                        <a href="javascript:" >خدمات</a>
                                        <span class="submenu-indicator">
                                            <span class="submenu-indicator-chevron"></span>
                                        </span>
                                        <div class="sub-menu2 up dropdown-xs">
                                            <ul class="">
                                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/9">بلیط</a></li>
                                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/10">حمل و نقل</a></li>
                                                <!--                                                        <li><a href="specific/11">اجاره خودرو در ایران</a></li>
-->                                                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/12">گواهینامه بین المللی</a></li>
                                                <!--                                                        <li><a href="specific/13">خدمات رانندگی VIP&CIP</a></li>
-->                                                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/14">بیمه مسافرتی</a></li>
                                                <!-- <li><a class="SMNews" href="#">اخبار سایت</a></li>-->
                                                <li><a class="SMFaq" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/faq">پرسشهای متداول</a></li>
                                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/logbook" class="SMLogBook">سفرنامه</a></li>
                                                <!--   <li><a href="javascript:;" class="SMEmbassy" >سفارت</a></li>-->
                                                <li><a   href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/rentcar" >اجاره خودرو</a></li>
                                                <!--<li><a a class="SMWorldClock">ساعت کشورها</a></li>
                                                        <li><a href="brand">خدمات گردشگری</a></li>
                                                        <li><a class="SMAboutCountry" href="#" >معرفی کشورها</a></li>-->
                                                <li><a   href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/complaints" >فرم شکایات</a></li>

                                            </ul>
                                        </div>
                                    </li>
                                    <li class="has-sub2">
                                        <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/28">راهنمای رزرو آنلاین</a>
                                    </li>
                                </ul>
                            </div>


                        </li>

                        <li class="has-sub"><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a></li>

                        <li class="has-sub">
                            <a class="SMRules" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/rules" >قوانین و مقررات</a>
                        </li>
                        <li class="has-sub">
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/shop" >فروشگاه</a>
                        </li>

                        <li class="has-sub">
                            <a class="SMBlog" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/blog">مجله گردشگری</a>
                        </li>


                    </ul>
                </nav>
            </div>
        </div>


    </div>
</header>
<div class="tools2-left">
    <div class="tools2-left-parent">
        <div class="tools2-left-icon"><img src="project_files/images/flight.png" width="50" height="50"/></div>
        <a href="https://www.shidrokh-travel.ir/blog/categories/articles/articleDetail/1268"><div class="tools2-left-txt">آفر تورهای خارجی</div></a>
    </div>
    <div class="tools2-left-parent">
        <div class="tools2-left-icon"><img src="project_files/images/Hafiz.png" width="50" height="50"/></div>
        <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/blog/categories/articles/articleDetail/588/%D8%AA%D9%88%D8%B1-%D8%B4%DB%8C%D8%B1%D8%A7%D8%B2-%D8%A7%D8%B2-%D8%AA%D9%87%D8%B1%D8%A7%D9%86-%D9%87%D9%85%D9%87-%D8%B1%D9%88%D8%B2%D9%87-%D8%A8%D8%A7-%D9%82%DB%8C%D9%85%D8%AA-%D9%85%D9%86%D8%A7%D8%B3%D8%A8--%D8%B4%DB%8C%D8%B1%D8%A7%D8%B2%DA%AF%D8%B1%D8%AF%DB%8C-%D8%B3%D9%81%D8%B1-%D8%A8%D9%87-%D8%B4%D9%87%D8%B1-%D8%B1%D8%A7%D8%B2-%D8%A8%D8%A7-%D8%B4%DB%8C%D8%AF%D8%B1%D8%AE-%D8%AA%D8%B1%D8%A7%D9%88%D9%84"><div class="tools2-left-txt">تور شیراز و تخت جمشید</div></a>
    </div>
    <div class="tools2-left-parent">
        <div class="tools2-left-icon"><img src="project_files/images/camp.png" width="50" height="50"/></div>
        <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/2"><div class="tools2-left-txt">تور عشایر</div></a>
    </div>
    <div class="tools2-left-parent">
        <div class="tools2-left-icon"><img src="project_files/images/sh.png" width="50" height="50"/></div>
        <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/blog/categories/articles/articleDetail/1267"><div class="tools2-left-txt">تور مشهد</div></a>
    </div>
    <div class="tools2-left-parent">
        <div class="tools2-left-icon"><img src="project_files/images/lady.jpg" width="50" height="50"/></div>
        <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/17"><div class="tools2-left-txt">تور بانوان</div></a>
    </div>

</div>
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



<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 social-link-parent">
                <div class="col-xs-12 title-social">
                    <i class="fas fa-phone-volume"></i>
                    راههای ارتباط با شیدرخ

                </div>

                <div class="row">
                    <div class="col-lg-12 social-link">
                        <div class="icon-newtwork">
                            <a href="https://www.linkedin.com/in/shidrokh-travel-agency-7637081b8" class="linkin">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <div class="lable-network">لینکدین</div>
                        </div>

                        <div class="icon-newtwork">
                            <a href="https://www.facebook.com/shidrokhtravelagency/" class="facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <div class="lable-network">فیسبوک</div>
                        </div>
                        {load_presentation_object filename="aboutUs" assign="objAbout"}
                        {assign var="about"  value=$objAbout->getData()}
                        {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
                        {foreach $socialLinks as $key => $socialMedia}

                        {if $socialMedia['social_media'] == 'telegram'}
                            <div class="icon-newtwork">
                                <a href="{$socialMedia['link']}" class="SMTelegram telegram">
                                    <i class="fab fa-telegram-plane"></i>
                                </a>
                                <div class="lable-network">تلگرام</div>
                            </div>
                        {/if}
                        {if $socialMedia['social_media'] == 'whatsapp'}
                            <div class="icon-newtwork">
                                <a href="{$socialMedia['link']}" class="SMWhatsApp whatsapp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <div class="lable-network">واتساپ</div>
                            </div>
                        {/if}

                        {if $socialMedia['social_media'] == 'instagram'}
                                <div class="icon-newtwork">
                                    <a href="{$socialMedia['link']}" class="SMInstageram instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <div class="lable-network">اینستاگرام فارسی</div>
                                </div>
                        {/if}
                        {/foreach}

                        <div class="icon-newtwork">
                            <a href="https://www.instagram.com/p/CGVMsa1hGxV/?igshid=gg397t38r1mx" class="instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <div class="lable-network">اینستاگرام انگلیسی</div>
                        </div>
                        <div class="icon-newtwork">
                            <a href="https://instagram.com/easytravel.iran?igshid=84ylj0km2pt2" class="instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <div class="lable-network">اینستاگرام روسی</div>
                        </div>
                        <div class="icon-newtwork">
                            <a href="https://instagram.com/voyagefacile_en_iran?igshid=17u77dg5m2s9j" class="instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <div class="lable-network">اینستاگرام فرانسه</div>
                        </div>

                    </div>
                    <div class="col-lg-12 links-footer d-none d-md-block">
                        <ul>
                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">صفحه اصلی</a></li>
                            <li><a class="SMContactUs" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/contactus">تماس با شیدرخ</a></li>
                            <li><a class="SMAbout" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/aboutus">درباره شیدرخ</a></li>
                            <li><a class="" href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a></li>
                            <li><a class="" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/2">تور عشایر</a></li>
                            <li><a class="" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/3">تور شکم گردی</a></li>
                            <li><a class="" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/16">تور سالمندان</a></li>
                            <li><a class="" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/17">تور بانوان</a></li>
                            <li><a class="SMBlog" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/blog">مجله گردشگری</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 footer-sec-address">
                        <div class="footer-title-sec">
                            <i class="fas fa-phone"></i>
                            <h4>ارتباط با ما</h4>
                        </div>
                        <div class="footer-sec-info">
                            <p class="SMFooterAddress">{$smarty.const.CLIENT_ADDRESS}</p>
                            <p class="tell SMFooterPhone">شماره تماس :
                                {$smarty.const.CLIENT_MOBILE}
                            </p>
                            <a class="SMFooterEmail" href="mailto:{$smarty.const.CLIENT_EMAIL}">{$smarty.const.CLIENT_EMAIL}</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 footer-sec-address">

{*                        <div class="footer-title-sec">*}
{*                            <i class="fas fa-chart-bar"></i>*}
{*                            <h4>آمار بازدید سایت</h4>*}
{*                        </div>*}
{*                        <div class="footer-sec-info">*}
{*                            <div class="amar-parent">*}
{*                                <div> بازدید امروز: <span>624 بازدید </span></div>*}
{*                                <div> بازدید دیروز: <span>: 0 بازدید </span></div>*}
{*                                <div> بازدید ماه گذشته: <span>: 4,365 بازدید </span></div>*}
{*                                <div>بازدید کل: <span>827,227</span></div>*}
{*                            </div>*}
{*                        </div>*}
{*                        <div class="footer-sec-info2">*}
{*                            <a referrerpolicy="origin" target="_blank" href="https://trustseal.enamad.ir/?id=209498&amp;Code=V8JQXAzL4f22UvM7eUz8"><img referrerpolicy="origin" src="https://Trustseal.eNamad.ir/logo.aspx?id=209498&amp;Code=V8JQXAzL4f22UvM7eUz8" alt="" style="cursor:pointer" id="V8JQXAzL4f22UvM7eUz8"></a>*}
{*                        </div>*}

                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 footer-sec-sale mr-auto">

                    </div>
                </div>


            </div>
        </div>
</footer>
<div class="copyright">

    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="copyright_content d-flex flex-row align-items-center">
                    <p>
                        کلیه حقوق وب سایت متعلق به <a href="https://www.iran-tech.com">شیدرخ</a> می باشد.
                    </p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 iran-tech text-left">
                <p> <a href="https://www.iran-tech.com" target="_blank"> طراحی سایت گردشگری </a>: ایران تکنولوژی </p>
            </div>
        </div>
    </div>

</div>
{/if}
{else}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}
{/if}




</body>
{literal}
    <script language="javascript" type="text/javascript" src="project_files/js/bootstrap.bundle.min.js"></script>
    <script language="javascript" type="text/javascript" src="project_files/js/bootstrap.min.js"></script>
    <script language="javascript" type="text/javascript" src="project_files/js/megamenu.js"></script>
    <script language="javascript" type="text/javascript" src="project_files/js/javascript.js"></script>
    <script language="javascript" type="text/javascript" src="project_files/js/main.js"></script>
{/literal}
{if $smarty.const.GDS_SWITCH neq 'app'}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
{/if}

</html>
