{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{assign var="hashedPass" value=functions::HashKey({$smarty.session.cardNo},'encrypt')}

<!doctype html>
<html lang="fa">

<head>
    <!-- Required meta tags -->
    <meta name="description" content="{$obj->Title_head()}">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, user-scalable=0">
    <base href="{$smarty.const.CLIENT_DOMAIN}" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="project_files/css/bootstrap.min.css">
   {* <link rel="stylesheet" type="text/css" href="project_files/owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="project_files/owlcarousel/owl.theme.default.min.css">*}
    <link rel="stylesheet" type="text/css" href="project_files/css/fontawesome.min.css">

    <link rel="stylesheet" type="text/css" href="project_files/css/style.css">
    <link rel="shortcut icon" href="project_files/images/favicon.png" type="image/x-icon"/>
    <link rel="icon" href="fav.png" type="image/png"/>
    <script type="text/javascript" src="project_files/js/jquery.min.js"></script>
    <script type="text/javascript" src="project_files/js/bootstrap.min.js"></script>
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}
    <title>{$obj->Title_head()}</title>
</head>

<body class="temp">

{if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel &&
    $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket &&
    $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintEuropcar &&
    $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation &&
    $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan &&
    $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationZarvan &&
    $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicketReservation &&
    $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTourReservation
}
    <header class="header">
        <div class="container">
            <div class="top_bar ">
                <div class="row">
                    <div class="col d-flex flex-row">
                        <div class="phone d-none d-sm-block"> تماس باما :
                            <a class="SMFooterPhone"></a>
                        </div>
                        <div class="social d-none d-sm-block">
                            <ul class="social_list">
                                <li class="social_list_item"><a href="#" target="_blank" class="SMGoogle"><i
                                                class="fab fa-google-plus-g " aria-hidden="true"></i></a>
                                </li>
                                <li class="social_list_item"><a href="#" target="_blank" class="SMFaceBook"><i
                                                class="fab fa-facebook-f " aria-hidden="true"></i></a>
                                </li>
                                <li class="social_list_item"><a href="#" target="_blank" class="SMTwitter"><i
                                                class="fab fa-twitter " aria-hidden="true"></i></a>
                                </li>
                                <li class="social_list_item"><a href="#" target="_blank" class="SMInstageram"><i
                                                class="fab fa-instagram " aria-hidden="true"></i></a>
                                </li>
                                <li class="social_list_item"><a href="#" target="_blank" class="SMTelegram"><i
                                                class="fab fa-telegram-plane " aria-hidden="true"></i></a>
                                </li>
                            </ul>
                        </div>


                        <div class="main-navigation__item support margin-vl-2">
                            <button aria-label="Support" type="button" class="main-navigation__button2 support-icon">
                                <svg width="27px" height="27px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="mx-1 mx-2-md"><g><path d="M12,10.5 C14.6233526,10.5 16.75,8.37335256 16.75,5.75 C16.75,3.12664744 14.6233526,1 12,1 C9.37664744,1 7.25,3.12664744 7.25,5.75 C7.25,8.37335256 9.37664744,10.5 12,10.5 Z M12,11.5 C8.82436269,11.5 6.25,8.92563731 6.25,5.75 C6.25,2.57436269 8.82436269,0 12,0 C15.1756373,0 17.75,2.57436269 17.75,5.75 C17.75,8.92563731 15.1756373,11.5 12,11.5 Z M22,24 C22,18.4771525 17.5228475,14 12,14 C6.4771525,14 2,18.4771525 2,24 L1,24 C1,17.9248678 5.92486775,13 12,13 C18.0751322,13 23,17.9248678 23,24 L22.5,24 L22,24 Z"></path></g></svg>

                                <div class="button-text-wrapper">
                                    <strong class="hidden-xs hidden-sm ltr long-text">
                                        {include file="`$smarty.const.FRONT_THEMES_DIR`iran_tech_eskan/topBarName.tpl"}
                                    </strong>
                                </div>
                                <div class="button-chevron  arrow2">
                                    <svg fill="#626262" width="12" height="12" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 12 12" class="v-middle">
                                        <g fill-rule="evenodd">
                                            <polygon fill-rule="nonzero"
                                                     points="10.466 3.06 11.173 3.767 6.002 8.939 .83 3.767 1.537 3.06 6.002 7.524"></polygon>
                                        </g>
                                    </svg>
                                </div>
                            </button>
                            <div class="main-navigation__sub-menu2 arrow-up">

                                {include file="`$smarty.const.FRONT_THEMES_DIR`iran_tech_eskan/topBar.tpl"}

                            </div>



                        </div>
                        <div class="user_box_login user_box_link" style="height: 28px;">
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/user/home.php" target="_blank"><img alt="" src="project_files/images/flag-uk.png" style="height: 100%;"></a>
                        </div>

                    </div>
                </div>
            </div>
            <nav class="main-nav">
                <div class="row">
                    <div class="col main_nav_col d-flex flex-row align-items-center justify-content-start">
                        {if ($smarty.server.HTTP_X_REQUESTED_WITH eq 'app.safar360.com.safar360')}
                            <a href="https://{$smarty.const.CLIENT_DOMAIN}/gds/app/">
                                <div style="z-index: 9;" class="logo">
                                    <img src="project_files/images/logo.png" alt="">
                                </div>
                            </a>
                        {else}
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/">
                                <div style="z-index: 9;" class="logo">
                                    <img src="project_files/images/logo.png" alt="">
                                </div>
                            </a>
                        {/if}

                        <div class="hamburger mr-lg-0 mr-auto d-md-block d-lg-none">
                            <i class="fa fa-bars trans_200"></i>
                        </div>
                        <div class="mainnav mr-auto">
                            <ul>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">صفحه اصلی</a>
                                </li>
                                <li style="position: static" class="">
                                    <a class="smoothScrollTo TabScroll pointer" data-target="#pills-tourlocal-tab" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/home.php#tourlocal">تور ها </a>
                                </li>
                                <li class="">
                                    <a class="smoothScrollTo TabScroll pointer" data-target="#pills-h-dakheli-tab" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/home.php#h-dakheli">هتل ها </a>

                                <li style="position: static" class="">
                                    <a class="smoothScrollTo TabScroll pointer" data-target="#pills-rentCar-tab" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/home.php#rentCar">اجاره اتومبیل</a>
                                </li>


                                <li style="position: static" class="">
                                    <a class="smoothScrollTo TabScroll pointer" data-target="#pills-tafrih-tab" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/home.php#tafrih">تفریحات</a>
                                </li>


                                <li class="has-sub"><a href="javascript:;">مشتریان <i class="fas fa-angle-down"
                                                                                      aria-hidden="true"></i></a>
                                    <div class="megasub  megasub2">
                                        <ul>
                                            <li><a href="https://online.iran-tech.com/gds/loginUser">باشگاه مشتریان</a>
                                            </li>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=vote">نظرسنجی</a></li>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=feedback">انتقادات و پیشنهادات</a></li>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=faq" >پرسش و پاسخ</a></li>
                                            <li><a href="https://online.iran-tech.com/gds/UserTracking">پیگیری خرید</a>
                                            </li>
                                        </ul>
                                        <ul>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=agent" >درخواست نمایندگی</a></li>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=agentlist" >نمایندگی ها</a></li>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/home.php#newslatter" data-target=".newslatter" class="smoothScrollTo">دقیقه نود</a></li>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=pay" >پرداخت آنلاین</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=cat">مجله گردشگری</a></li>
                                <li class="has-sub"><a href="javascript:;">دانستنیها <i class="fas fa-angle-down"
                                                                                        aria-hidden="true"></i></a>
                                    <div class="megasub megasub3">
                                        <ul>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=aboutcountry" >معرفی کشورها</a></li>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=aboutiran" >معرفی ایران</a></li>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=embassy" >سفارت</a></li>
                                        </ul>
                                        <ul>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=weather" >هواشناسی</a></li>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=worldclock" >ساعت کشورها</a></li>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=change" >نرخ ارز</a></li>
                                        </ul>
                                        <ul>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=news" >اخبار</a></li>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=worldgallery" >گالری جهان</a></li>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=blog">سفرنامه</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="has-sub"><a href="javascript:;">درباره ما <i class="fas fa-angle-down"
                                                                                        aria-hidden="true"></i></a>
                                    <div class="submenu">
                                        <ul>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=aboutus">درباره ما</a></li>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=rules" class="SMRules">قوانین و مقررات</a></li>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=7">قوانین خرید بلیط</a>
                                            </li>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=5">راهنمای استرداد
                                                بلیط</a></li>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=6">راهنمای خرید بلیط</a>
                                            </li>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=staff" class="SMStaff">مدیران و پرسنل</a></li>
                                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=employment" class="SMEmployment">فرم استخدام</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li><a class="SMContactUs" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=contactus">تماس با ما </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>


<div class="background-modal-box">
</div>

<div class="menu-button-section hidden-lg-up">
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-4 float-right">
            <div class="row">

                <div class="side-mobile-mnu hidden-lg-up">
                    <div class="tac">
                        <img src="project_files/images/logo.png" alt="menu-picture" class="side-mobile-mnu-img">
                    </div>
                          <ul class="padding-0 font-size-16 menu-item-mobile">
                            <li>
                                <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/">

                                    صفحه اصلی
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" class="has-menu">
                                    <span class="fa fa-caret-down drop-down-icon float-left"></span>
                                    <span class="fa fa-caret-up hide-in-default drop-down-icon float-left"
                                          style="display: none;"></span>تور ها
                                </a>
                               
                                        <ul class="menu-item-mobile-2" style="display: none;">
                                            <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=irantour&level=1&sptour=1">ویژه داخلی</a></li>
                                            <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=tour&level=1&sptour=1" >ویژه خارجی</a></li>
                                            <li class="title"><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=irantourcity&level=1">تور های داخلی</a></li>
                                            <li class="title"><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=countrytour&level=1">تور های خارجی</a></li>
                                            <li class="title"><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=irantourcity&level=2">تور های خاص</a></li>
                                            <li class="title"><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=healthy_type">تور سلامت</a></li>
                                            <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=alltours" >تور ها در یک نگاه</a></li>
                                    	</ul>
                                 
                            </li>
                            
                            
                               <li>
                                <a class="has-menu" href="javascript:;">
                                    <span class="fa fa-caret-down drop-down-icon float-left"></span>
                                    <span class="fa fa-caret-up hide-in-default drop-down-icon float-left"
                                          style="display: none;"></span>هتل ها</a>


                                <ul class="menu-item-mobile-2" style="display: none;">
                               		<li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=iranhotelcity">هتل داخلی</a></li>
                                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=hotelcountry">هتل خارجی</a></li>
                                </ul>
                            </li>

                            <li>
                                <a class="has-menu" href="javascript:;">
                                    <span class="fa fa-caret-down drop-down-icon float-left"></span>
                                    <span class="fa fa-caret-up hide-in-default drop-down-icon float-left"
                                          style="display: none;"></span>خدمات گردشگری</a>


                                <ul class="menu-item-mobile-2" style="display: none;">
                                 		<li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=order">خدمات ویژه</a></li>
                                     	<li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=product1">اجاره اتومبیل</a></li>
                                        <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=product3" >تفریحات</a></li>
                                </ul>
                            </li>
                          	<li>
                                <a class="has-menu" href="javascript:;">
                                    <span class="fa fa-caret-down drop-down-icon float-left"></span>
                                    <span class="fa fa-caret-up hide-in-default drop-down-icon float-left"
                                          style="display: none;"></span>مشتریان</a>
                                          
                                <ul class="menu-item-mobile-2" style="display: none;">
                                 	  <li><a href="{$smarty.const.ROOT_ADDRESS}/loginUser">باشگاه مشتریان</a></li>
                                        <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=vote">نظرسنجی</a></li>
                                        <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=feedback">انتقادات و پیشنهادات</a></li>
                                        <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=faq" >پرسش و پاسخ</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a></li>
                                        <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=agent" >درخواست نمایندگی</a></li>                                        
                                        <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=agentlist">نمایندگی ها</a></li>
                                        <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=lastminate" >دقیقه نود</a></li>
                                        <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=pay" >پرداخت آنلاین</a></li>
                                </ul>
                            </li>
                            
                           <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=link" >مجله گردشگری</a></li>
                           
                        	<li>
                                <a class="has-menu" href="javascript:;">
                                    <span class="fa fa-caret-down drop-down-icon float-left"></span>
                                    <span class="fa fa-caret-up hide-in-default drop-down-icon float-left"
                                          style="display: none;"></span>دانستنیها</a>
                                          
                                <ul class="menu-item-mobile-2" style="display: none;">
                         	 	 	<li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=aboutcountry" >معرفی کشورها</a></li>
                                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=aboutiran" >معرفی ایران</a></li>
                                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=embassy" >سفارت</a></li>
                                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=weather" >هواشناسی</a></li>
                                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=worldclock" >ساعت کشورها</a></li>
                                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=change" >نرخ ارز</a></li>
                                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=news" >اخبار</a></li>
                                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=worldgallery">گالری جهان</a></li>
                                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=blog" >سفرنامه</a></li>
                                </ul>
                            </li>
                           
                           
                            <li>
                                <a class="has-menu" href="javascript:;">
                                    <span class="fa fa-caret-down drop-down-icon float-left"></span>
                                    <span class="fa fa-caret-up hide-in-default drop-down-icon float-left"
                                          style="display: none;"></span>
                                    درباره ما
                                </a>

                                <ul class="menu-item-mobile-2" style="display: none;">
                                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=aboutus" >درباره ما</a></li>
                                        <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=rules" >قوانین و مقررات</a></li>
                                       	<li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=7">قوانین خرید بلیط</a></li>
                                        <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=8">راهنمای استرداد بلیط</a></li>
                                        <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=9">راهنمای خرید بلیط</a></li>
                                        <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=staff" >مدیران و پرسنل</a></li>
                                        <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=employment" >فرم استخدام</a></li>
                                </ul>

                            </li>
							<li><a  href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=contactus">تماس با ما </a>

                        </ul>
                </div>
                <!-- menu item -->
                <!-- /button -->
            </div>
        </div>
    </div>
</div>


<div class="main">
    <div class="search-land">
        <div class="parallax-2 top-bk">
            <div class="js-height-full2">


            </div>

        </div>
    </div>
</div>
{/if}

<div class="clear"></div>
<div class="temp-content">
    <div class="container temp">
        <div class="temp-wrapper">
            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
        </div>
    </div>
</div>
<div class="left_text_ display_none_sm">
    <div class="contact_popup">
        <div style="direction:rtl" class="popup_content">

            <div class="phone">
                دموی نرم افزار شرکت ایران تکنولوژی می باشد و
                هیچ گونه استفاده تجاری ندارد.
            </div>


        </div>

    </div>
    <div class="tejari">

        استفاده غیر تجاری

    </div>
</div>



{if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel &&
    $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket &&
    $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintEuropcar &&
    $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation &&
    $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan &&
    $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationZarvan &&
    $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicketReservation &&
    $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTourReservation
}
<footer class="footer">
    <div class="container z-index-20">
        <div class="row">
            <div class="col-lg-4 footer_column">
                <div class="footer_col">
                    <div class="footer_content footer_about">
                        <div class="logo_container footer_logo">
                            <div class="logo">
                                <a class="text-right w-100 d-block" href="#">
                                    <img class="m-auto" src="project_files/images/logo.png" alt="">
                                </a>
                            </div>
                        </div>
                        <p class="footer_about_text">

شرکت ایران تکنولوژی ، از سال 1382 قدم به دنیای ارائه خدمات نرم افزار تخصصی گردشگری نمود و طی این سالها با بهره گیری از کادری متخصص موفق به ارائه نرم افزارهای متعددی به بیش از ششصد آژانس مسافرتی ، هتل ، استارت آپ و هلدین ... 
</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 footer_column">
                <div class="footer_col">
                    <div class="footer_title">اطلاعات تماس</div>
                    <div class="footer_content footer_contact">
                        <ul class="contact_info_list">
                            <li class="contact_info_item d-flex flex-row">
                                <div class="contact_info_text "><i class="fas fa-map-marked-alt "></i>
                                    <a class="SMFooterAddress">{$smarty.const.CLIENT_ADDRESS}</a>
                                </div>
                            </li>
                            <li class="contact_info_item d-flex flex-row">
                                <div class="contact_info_text"><i class="fas fa-phone"></i>
                                    <a href="tel:02188866609" class="SMFooterPhone">{$smarty.const.CLIENT_PHONE}</a>
                                </div>
                            </li>
                            <li class="contact_info_item d-flex flex-row">
                                <div class="contact_info_text"><i class="fas fa-envelope"></i> <a
                                            href="mailto:info@iran-tech.com?Subject=Hello" target="_top"
                                            class="SMFooterEmail">{$smarty.const.CLIENT_EMAIL}</a>
                                </div>
                            </li>
                            <li class="contact_info_item d-flex flex-row">
                                <div class="contact_info_text"><i class="fas fa-globe-asia"></i> <a
                                            href="https://www.iran-tech.com/">www.iran-tech.com</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 footer_column">
                <div id="g-map"><img src="project_files/images/map.jpg" alt="ایران تکنولوژی" class="map_pic"></div>
            </div>
        </div>
    </div>
</footer>
<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 order-lg-1 order-2  ">
                <div class="copyright_content d-flex flex-row align-items-center">
                    <div>کلیه حقوق وب سایت متعلق به ایران تکنولوژی می باشد.</div>
                </div>
            </div>
            <div class="col-lg-8 order-lg-2 order-1">
                <div class="copyright_content d-flex flex-row justify-content-lg-end">
                    <div>طراحی سایت آژانس مسافرتی :<a href="https://www.iran-tech.com/" target="_blank">ایران تکنولوژی</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{/if}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}

  {*  <script type="text/javascript" src="project_files/project_files/js/popper.min.js"></script>
    <script type="text/javascript" src="project_files/project_files/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="project_files/project_files/js/select2.min.js"></script>
    <script type="text/javascript" src="project_files/project_files/js/jquery.ui.core.js"></script>
    <script type="text/javascript" src="project_files/project_files/js/jquery.ui.datepicker-cc.js"></script>
    <script type="text/javascript" src="project_files/project_files/js/calendar.js"></script>   
    <script type="text/javascript" src="project_files/project_files/js/jquery.ui.datepicker-cc-fa.js"></script>
     <script type="text/javascript" src="project_files/owlcarousel/owl.carousel.min.js"></script>
    
    *}
    {literal}

    <script type="text/javascript" type="text/javascript" src="project_files/js/javascript.js"></script>
    <script type="text/javascript" src="project_files/js/jquery.parallax-1.1.3.js"></script>
   
    <script type="text/javascript" src="project_files/js/main.js"></script>
    <script type="text/javascript">
    js_height_init();
    js_height_inits();

    var mobileTest;
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
        mobileTest = true;
        $("html").addClass("mobile");
    } else {
        mobileTest = false;
        $("html").addClass("no-mobile");
    }


    function init_parallax() {
        if (($(window).width() >= 1024) && (mobileTest == false)) {
            $(".parallax-2").parallax("50%", 0.4);

        }
    }

    function js_height_init() {
        (function($) {
            var wheight = $(window).height();
            var sheight = $('.search').height();
            var height1 = wheight -  sheight;
            var height = height1 +  sheight;
            $(".js-height-full").height(height);
        })(jQuery);
    }
    function js_height_inits() {
        (function($) {
            var wheight2 = $(window).height();
            var heights = wheight2/5;
            $(".js-height-full2").height(heights);
        })(jQuery);
    }


</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
        $('.select2-num').select2();

        $(".plus-nafar").click(function() {
            var nafar = $(this).siblings(".number-count").attr('data-number');
            if (nafar < 9) {
                var newnafar = ++nafar;
                $(this).siblings(".number-count").html(newnafar);
                $(this).siblings(".number-count").attr('data-number', newnafar);
                var whathidden = $(this).siblings(".number-count").attr('data-value');
                $("." + whathidden).val(newnafar);
            }
        });
        $(".minus-nafar").click(function() {
            var nafar = $(this).siblings(".number-count").attr('data-number');
            var nmin = $(this).siblings(".number-count").attr('data-min');
            if (nafar > nmin) {
                var newnafar = --nafar;
                $(this).siblings(".number-count").html(newnafar);
                $(this).siblings(".number-count").attr('data-number', newnafar);
                var whathidden = $(this).siblings(".number-count").attr('data-value');
                $("." + whathidden).val(newnafar);
            }
        });
        $(".box-of-count-nafar-boxes").click(function() {
            $(this).siblings(".cbox-count-nafar").toggle();
        });
        $(".cbox-count-nafar").mouseleave(function() {
            $(this).hide();
        });
        //side bar menu
        $(".hamburger").click(function() {
            $(".background-modal-box").show();
            $(".side-mobile-mnu").animate({
                right: '0px'
            });
        });
        $(".background-modal-box").click(function() {
            $(this).hide();
            $(".side-mobile-mnu").animate({
                right: '-245px'
            });
        });
        $(".menu-item-mobile ul").hide();
        $(".hide-in-default").hide();
        $(".has-menu").click(function() {
            $(this).siblings("ul").toggle();
            $(this).children(".drop-down-icon").toggle();
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {

        $('#number_of_passengers').on('change', function(e) {
            var itemInsu = $("#number_of_passengers").val();

            itemInsu++;
            var HtmlCode = "";
            $(".nafarat-bime").remove();

            var i = 1;
            while (i < itemInsu) {
                HtmlCode += "<div class='search_item nafarat-bime'>" +
                    "<input type='text' name='txt_birth_insurance" + i + "' id='txt_birth_insurance" + i + "' class='txtBirthdayCalendar search_input' placeholder=' تولد نفر  " + i + "' /></div>" +
                    "</div>";
                i++;
            }

            $(".nafaratbime").append(HtmlCode);
        });




        function createRoomHotel(roomCount){
            var HtmlCode = "";
            var i = 1;

            while (i <= roomCount) {

                HtmlCode += '<div class="hotel-room-number room align-items-top">'
                    + ' <span class="room-number">اتاق ' + i + ' </span>'
                    + '	<div class="search_item">'
                    + '		<div class="s-u-form-input-wrapper">'
                    + '           <p class="s-u-number-input  s-u-number-input-change  inp-adt inp-adt-change">'
                    + '               <i class="addParent text-center plus fas fa-plus-circle"></i>'
                    + '               <input id="adult'+ i +'" class="countParent" type="number" value="0" name="adult'+ i +'" min="0" max="5">'
                    + '              <i class="minusParent text-center minus fas fa-minus-circle"></i>'
                    + '          </p>'
                    + '       </div>'
                    + '   	</div>'
                    + '	<div class="search_item child-number">'
                    + '		<div class="s-u-form-input-wrapper">'
                    + '            <p class="s-u-number-input  s-u-number-input-change  inp-child inp-child-change">'
                    + '               <i class="addChild text-center plus fas fa-plus-circle"></i>'
                    + '               <input id="child'+ i +'" class="countChild" type="number" value="0" name="child'+ i +'" min="0" max="5">'
                    + '               <i class="minusChild text-center minus fas fa-minus-circle"></i>'
                    + '           </p>'
                    + '       </div>'
                    + '		</div>'
                    + '		<div class="search_item child-birthday-box" id="child-birthday-box'+ i +'" data-roomnumber="'+ i +'">'
                    + '			<div class="select childAge-button childAge-dropdown">'
                    + '			</div>'
                    + '		</div>'

                    + '		</div>';

                i++;
            }
            return HtmlCode;
        };
        function createBirthdayCalendar(inputNum, roomNumber)
        {
            var i = 1;
            var HtmlCode = "";
            while (i <= inputNum) {
                HtmlCode +='<div class="select childAge-button childAge-dropdown">'
                    +'				<select class="myselect-child-age" name="childAge' + roomNumber + i + '" id="childAge' + roomNumber + i + '">'
                    +'                   <option value="1"> 1 سال</option>'
                    +'                   <option value="2">2 سال</option>'
                    +'                      <option value="3">3 سال</option>'
                    +'                      <option value="4">4 سال</option>'
                    +'                      <option value="5">5 سال</option>'
                    +'                      <option value="6">6 سال</option>'
                    +'                      <option value="7">7 سال</option>'
                    +'                      <option value="8">8 سال</option>'
                    +'                      <option value="9">9 سال</option>'
                    +'                      <option value="10">10 سال</option>'
                    +'                      <option value="11">11 سال</option>'
                    +'              </select>'
                    +'			</div>';

                i++;
            }

            return HtmlCode;
        };
        //		$('body').on('click', '.search-box .nav-pills .nav-item .nav-link', function() {
        //		var wwidth =  $(window).width();
        //	if (wwidth < 575) {
        //	var wheight = $(window).height();
        //	var sheight = $('.search').height();
        //	var height1 = wheight -  sheight;
        //	if (sheight > wheight ) {
        //		var height = sheight +  500;
        //	} else {
        //		var height = height1 +  sheight;
        //	}

        //		$(".js-height-full").height(height);

        //		});

        $('#countRoom').on('change', function (e) {



            var roomCount = $("#countRoom").val();
            createRoomHotel(roomCount);

            $(".rooms-hotel").find(".hotel-room-number").remove();

            var code=createRoomHotel(roomCount);

            $(".rooms-hotel").append(code);
            var wwidth =  $(window).width();
            if (wwidth < 575) {
                var wheight =  $(window).height();
                var sheight = $('.search').height();
                var height11 = sheight + 200;
                $(".js-height-full").height(height11);
            } else {
                var wheight = $(window).height();
                var sheight = $('.search').height();
                var height1 = wheight -  sheight;
                var height = height1 +  sheight;
                $(".js-height-full").height(height);
            }
        });

        $('body').on('click', 'i.addParent', function() {

            var inputNum = $(this).siblings(".countParent").val();
            inputNum ++;
            if (inputNum < 7) {
                $(this).siblings(".countParent").val(inputNum);
            }
        });
        $('body').on('click', 'i.minusParent', function() {
            var inputNum = $(this).siblings(".countParent").val();
            if(inputNum != 0 )
            {
                inputNum --;
                $(this).siblings(".countParent").val(inputNum);
            }
            else
            {
                $(this).siblings(".countParent").val('0');
            }
        });

        $('body').on('click', 'i.addChild', function() {
            var inputNum = $(this).siblings(".countChild").val();
            inputNum ++;
            if (inputNum < 5) {
                $(this).siblings(".countChild").val(inputNum);

                $(this).parents(".child-number").siblings(".child-birthday-box").find(".childAge-button").remove();

                var roomNumber = $(this).parents(".child-number").siblings(".childAge-button").data("roomnumber");

                var htmlBox = createBirthdayCalendar(inputNum, roomNumber);

                $(this).parents(".child-number").siblings(".child-birthday-box").append(htmlBox);
            }
        });
        $('body').on('click', 'i.minusChild', function() {
            var inputNum = $(this).siblings(".countChild").val();
            $(this).parents(".child-number").siblings(".child-birthday-box").find(".childAge-button").remove();

            if(inputNum != 0 )
            {
                inputNum --;
                $(this).siblings(".countChild").val(inputNum);

                var roomNumber = $(this).parents(".child-number").siblings(".child-birthday-box").data("roomnumber");

                var htmlBox = createBirthdayCalendar(inputNum, roomNumber);

                $(this).parents(".child-number").siblings(".child-birthday-box").append(htmlBox);
            }
            else
            {
                $(this).siblings(".countChild").val('0');
            }
        });



        $('input:radio[name="select-rb"]').change(function () {
            if ($(this).val() == 'yektarafe') {
                if(!$(".bargasht-date").hasClass("disabled")) {
                    $(".bargasht-date").addClass("disabled");
                }
            } else {
                if($(".bargasht-date").hasClass("disabled")) {
                    $(".bargasht-date").removeClass("disabled");
                }
            }
        });




    });
    $(document).ready(function () {
        $('.main-navigation__item').bind('click', function(e){

            e.stopPropagation();

        });


        $('body').click(function () {
            $('.main-navigation__sub-menu2').hide();



        });


        var iframe = $('#loginedname').contents();
        iframe.find('span').on('click', function() {
            $('.main-navigation__item').find('.main-navigation__sub-menu2').toggle();
            $('.button-chevron.arrow2').toggleClass('rotate');

        });
        $('.main-navigation__button2').click(function () {

            $('.main-navigation__sub-menu2').toggle();
            $('.button-chevron.arrow2').toggleClass('rotate');

        });


    });

</script>
{/literal}
</body>

</html>

