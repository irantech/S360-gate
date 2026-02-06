
{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="dateTimeSetting" assign="objDate"}
{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{if $smarty.session['userId'] }
    {assign var="userInfo" value=functions::infoMember($smarty.session.userId)}
    {assign var="hashedPass" value=functions::HashKey({$userInfo['email']},'encrypt')}
{/if}
{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{assign var="socialLinks"  value=$about['social_links']|json_decode:true}

{assign var="gds_project_file_name" value="iran_agency"}
<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{$obj->Title_head()}</title>
    <base href="{$smarty.const.CLIENT_DOMAIN}"/>

    <link rel="stylesheet" type="text/css" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/GlobalFile/css/register.css">
    <link rel="shortcut icon" type="image/png" href="project_files/images/faveicon.png">

    {literal}
        <script src="project_files/js/jquery-3.4.1.min.js"></script>
    {/literal}

    {if $smarty.session.layout neq 'pwa'}
    <link rel="stylesheet" href="project_files/css/all.min.css">
    <link rel="stylesheet" href="project_files/css/header.css">
    <link rel="stylesheet" href="project_files/css/style.css">
    {/if}

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}
</head>
<body>
{if $smarty.session.layout neq 'pwa' }
<header class="header_area">
    <div class="main_header_area animated" id="navbar">
        <div class="container">
            <nav id="navigation1" class="navigation">
                <div class="nav-header">
                    <a class="nav-brand" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                        <img src="project_files/images/logo.png" alt="ایران">
                        <div class="logo-caption">
                            <h1>
                                <span>شرکت خدمات مسافرتی ایران</span>
                                <span class="sub-logo">گروه خودرو سازی سایپا</span>
                            </h1>
                        </div>
                    </a>
                </div>
                <div class="nav-menus-wrapper ">
                    <ul class="nav-menu align-to-right">
                        <li>
                            <a href="javascript:">تور</a>
                            <ul class="nav-dropdown">
                                <li>
                                    <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/irantourcity/1">تور داخلی</a>
                                </li>
                                <li>
                                    <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/countrytour/1">تور خارجی</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="display-dec text-right" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/visacountry">ویزا</a></li>
                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/2">تفریحات و تخفیفات</a></li>
                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/blog">وبلاگ</a></li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/loginUser">باشگاه مشتریان</a></li>
                        <li>
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/aboutus">درباره ما</a>
                        </li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a></li>
                    </ul>
                </div>
                <div class="parent-btn-header">
                    <button class="button main-navigation__button2 stop-propagation  btn-user">
                        {include file="`$smarty.const.FRONT_THEMES_DIR`{$gds_project_file_name}/topBarName.tpl"}
                        <i class="far fa-user"></i>
                        <div class="button-chevron-2 ">
                        </div>
                    </button>
                    <div class="stop-propagation main-navigation__sub-menu2 arrow-up" style="display: none">
                        {include file="`$smarty.const.FRONT_THEMES_DIR`{$gds_project_file_name}/topBar.tpl"}
                    </div>

                    <a class="button  btn-phone" href="tel:{$smarty.const.CLIENT_PHONE}">
                        <span>{$smarty.const.CLIENT_PHONE}</span>
                        <i class="fa fa-phone"></i>
                    </a>
                </div>
                <div class="nav-toggle "></div>
            </nav>
        </div>
    </div>
</header>
{/if}

{if $smarty.const.GDS_SWITCH eq 'app'}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
{else}
    <div class="content_tech" style="margin-top: 20px;" >
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
    <div class="body-footer">
        <div class="container">
            <div class="row">
                <div class="parent-footer-iran d-flex flex-wrap">
                    <div class="item-footer col-lg-2 col-md-6 col-sm-12 col-12 order-foot2">
                        <div class="parent-namad box-item-footer text-right">

                            <div class="namads">
                                <a href="javascript:"><img src="project_files/images/certificate1.png" alt="Enamad1"></a>
                                <a href="javascript:"><img src="project_files/images/certificate2.png" alt="namad-1"></a>
                                <a href="javascript:"><img src="project_files/images/certificate3.png" alt="namad-2"></a>
                                <a href="javascript:"><img src="project_files/images/enamad.png" alt="namad-2">
                                </a>
                            </div>
                            <div class="footer-icon icon-respancive">
                                <a target="_blank" href="javascript:"><img src="project_files/images/eitaa.png" alt="eitaa"></a>
                                <a target="_blank" href="javascript:"><img src="project_files/images/rubika.png" alt="rubika"></a>
                            </div>
                        </div>
                    </div>
                    <div class="item-footer col-lg-2 col-md-6 col-sm-12 col-12  display-footer-none">
                        <div class="box-item-footer text-right">
                            <h3>دسترسی آسان</h3>
                            <ul>
                                <li>
                                    <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/visacountry">
                                        <i class="fal fa-angle-left"></i>
                                        ویزا
                                    </a>
                                </li>
                                <li>
                                    <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/all_tour">
                                        <i class="fal fa-angle-left"></i>
                                        تور
                                    </a>
                                </li>
                                <li>
                                    <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/staff">
                                        <i class="fal fa-angle-left"></i>
                                        مدیران و پرسنل
                                    </a>
                                </li>
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
                                        <i class="fal fa-angle-left"></i>
                                        پیگیری خرید
                                    </a>
                                </li>
                                <li>
                                    <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/rules">
                                        <i class="fal fa-angle-left"></i>
                                        قوانین و مقررات
                                    </a>
                                </li>
                                <li>
                                    <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/contactus">
                                        <i class="fal fa-angle-left"></i>
                                        تماس با ما
                                    </a>
                                </li>
                                <li>
                                    <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/pay">
                                        <i class="fal fa-angle-left"></i>
                                        پرداخت آنلاین
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="item-footer col-lg-4 col-md-6 col-sm-12 col-12  order-foot1">
                        <div class="parent-item-footer parent-item-footer-responsive">
                            <div class="img-box-footer">
                                <img src="project_files/images/logo.png" alt="footer-logo">
                                <div class="text-logo-footer">
                                    <h4>
                                        <span>شرکت خدمات مسافرتی</span>
                                        <span> هوایی گردشگری زیارتی ایران</span>
                                    </h4>
                                </div>
                            </div>
                            <div class="child-item-footer align-items-start">
                                <i class="fa-light fa-location-dot"></i>
                                آدرس:
                                <span>
                                            {$smarty.const.CLIENT_ADDRESS}
                                </span>
                            </div>
                            <div class="child-item-footer">
                                <i class="fa-light fa-phone"></i>
                                تلفن:
                                <a href="tel:{$smarty.const.CLIENT_PHONE}" class="">
                                    {$smarty.const.CLIENT_PHONE}
                                </a>
                            </div>
                            <div class="child-item-footer">
                                <i class="fa-light fa-mobile"></i>
                                موبایل:
                                <a href="tel:{$smarty.const.CLIENT_MOBILE}" class="">
                                    {$smarty.const.CLIENT_MOBILE}
                                </a>
                            </div>
                            <div class="child-item-footer">
                                <i class="fa-light fa-envelope"></i>
                                ایمیل:
                                <a href="mailto:{$smarty.const.CLIENT_EMAIL}" class="">
                                    {$smarty.const.CLIENT_EMAIL}
                                </a>
                            </div>
                            <div class="footer-icon my-footer-icon">
                                {foreach $socialLinks as $key => $socialMedia}
                                    {if $socialMedia['social_media'] == 'ita'}
                                        <a target="_blank" href="{$socialMedia['link']}"><img src="project_files/images/eitaa.png" alt="eitaa"></a>
                                    {/if}
                                    {if $socialMedia['social_media'] == 'rubika'}
                                        <a target="_blank" href="{$socialMedia['link']}"><img src="project_files/images/rubika.png" alt="rubika"></a>
                                    {/if}
                                {/foreach}
                            </div>
                        </div>
                    </div>
                    <div class="item-footer col-lg-4 col-md-6 col-sm-12 col-12  footer-display pl-4">
                        <div class="box-item-footer text-right">
                            <h3>درباره ما</h3>
                            <p>
                                {$smarty.const.ABOUT_ME}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="last_text col-12">
        <a class="last_a" href="https://www.iran-tech.com/">طراحی سایت </a>
        <p class="last_p_text">: ایران تکنولوژی</p>
    </div>
    <a href="javascript:" class="fixicone fa fa-angle-up" id="scroll-top" style=""></a>
</footer>
{/if}
{else}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}
{/if}

{literal}
    <script src="project_files/js/bootstrap.min.js"></script>
    <script src="project_files/js/header.js"></script>
    <script src="project_files/js/script.js"></script>
{/literal}
{if $smarty.const.GDS_SWITCH neq 'app'}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
{/if}

<div class="p-popup-container">
    <div class="p-popup-wrapper">
        <span class="p-close-popup"></span>
        <div id="ShowPopup"></div>
    </div>
</div>
</body>


</html>