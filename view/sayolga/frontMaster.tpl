{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="dateTimeSetting" assign="objDate"}
{assign var="hashedPass" value=functions::HashKey({$smarty.session.cardNo},'encrypt')}
<!doctype html>
<html lang="fa">

<head>
    <meta name="description" content="{$obj->Title_head()}">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">


    <link rel="stylesheet" type="text/css" href="project_files/css/style.css">
    {if $smarty.session.layout neq 'pwa'}
        <link rel="stylesheet" type="text/css" href="project_files/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="project_files/css/breaking-news-ticker.css">
        <link rel="stylesheet" type="text/css" href="project_files/css/style-responsive.css">
    {/if}

    <link rel="shortcut icon" href="project_files/images/favicon.ico" type="image/x-icon" />
    <link rel="icon" href="project_files/images/favicon.png" type="image/png" />
    <script type="text/javascript" src="project_files/js/jquery-3.4.1.min.js"></script>
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}
    <title>{$obj->Title_head()}</title>
</head>

<body>
{if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation}
    {if $smarty.session.layout neq 'pwa' }
        <header class="header">
            <div class="background-modal-box"></div>
            <div class="container">
                <div class="top_bar ">
                    <div class="row">
                        <div class="col d-flex flex-row">
                            <div class="phone d-none d-sm-block ">تماس باما : <span
                                        class="SMFooterPhone">{$smarty.const.CLIENT_PHONE}</span></div>
                            <div class="social d-none d-lg-block">
                                <ul class="social_list">
                                    <li class="social_list_item"><a class="SMGoogle" target="_blank"><i
                                                    class="fab fa-google-plus-g" aria-hidden="true"></i></a>
                                    </li>
                                    <li class="social_list_item"><a class="SMFaceBook" target="_blank"><i
                                                    class="fab fa-facebook-f" aria-hidden="true"></i></a>
                                    </li>
                                    <li class="social_list_item"><a class="SMTwitter" target="_blank"><i
                                                    class="fab fa-twitter" aria-hidden="true"></i></a>
                                    </li>
                                    <li class="social_list_item"><a class="SMInstageram" target="_blank"><i
                                                    class="fab fa-instagram" aria-hidden="true"></i></a>
                                    </li>
                                    <li class="social_list_item"><a class="SMTelegram" target="_blank"><i
                                                    class="fab fa-telegram-plane" aria-hidden="true"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="user_box mr-auto">

                                <div class="top__user_menu">
                                    <button class="main-navigation__button2">

                                        {include file="`$smarty.const.FRONT_THEMES_DIR`sayolga/topBarName.tpl"}


                                        <div class="button-chevron-2 ">
                                            <svg fill="#fff" width="12" height="12" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 12 12" class="v-middle">
                                                <g fill-rule="evenodd">
                                                    <polygon fill-rule="nonzero"
                                                             points="10.466 3.06 11.173 3.767 6.002 8.939 .83 3.767 1.537 3.06 6.002 7.524"></polygon>
                                                </g>
                                            </svg>
                                        </div>
                                    </button>

                                    <div class="main-navigation__sub-menu2 arrow-up">

                                        {include file="`$smarty.const.FRONT_THEMES_DIR`sayolga/topBar.tpl"}

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <nav class="main-nav">
                    <div class="row">
                        <div class="col main_nav_col d-flex flex-row align-items-center justify-content-start flex-wrap">
                            <div class="logo">
                                <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/"><img
                                            src="project_files/images//logo.png" alt="{$smarty.const.CLIENT_NAME}"></a>
                            </div>
                            <div class="hamburger mr-lg-0 mr-auto d-md-block d-lg-none">

                            </div>
                            <div class="mainnav mr-auto">
                                <ul>
                                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/">صفحه اصلی</a></li>
                                    <li class="has-sub"><a href="javascript:;">درباره ما</a>
                                        <div class="submenu">
                                            <ul>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=aboutus">معرفی</a>
                                                </li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=4">پیام
                                                        مدیر عامل</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=5">مدیران
                                                        ارشد</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=6">شرکت
                                                        های زیر مجموعه</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=7">تقدیرنامه
                                                        ها و گواهی نامه ها</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=3">درباره
                                                        خلخال</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=rules">قوانین
                                                        و مقررات</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="has-sub"><a href="javascript:;">مجتمع گردشگری بام خلخال</a>
                                        <div class="megasub">
                                            <ul>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=8">مجتمع
                                                        در یک نگاه</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=9">سوئیت
                                                        های سنتی و روستایی</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=10">کافه
                                                        سنتی</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=11">کافی
                                                        شاپ</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=12">شهربازی
                                                        سرپوشیده</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=13">مجموعه
                                                        آبی</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=14">پیست
                                                        اسکی و تیوپ سواری</a></li>
                                            </ul>
                                            <ul>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=15">رستوران</a>
                                                </li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=16">فود
                                                        کورت</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=17">مرکز
                                                        خرید</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=18">سوئیت
                                                        های مدرن</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=19">مسیر
                                                        سلامت</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=20">پیست
                                                        دوچرخه سواری</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=21">موزه
                                                        زمان</a></li>
                                            </ul>
                                            <ul>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=22">تالار</a>
                                                </li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=23">زمین
                                                        والیبال</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=24">زمین
                                                        چمن فوتبال</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=25">سالن
                                                        همایش و کنفرانس</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=26">دهکده
                                                        سلامت</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=27">جشنواره
                                                        ها و نمایشگاه ها</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/home.php?bashgah=bashgah">باشگاه
                                                        مشتریان</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="has-sub"><a href="javascript:;">شرکت خلخال گشت</a>
                                        <div class="megasub">
                                            <ul>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=28">درباره
                                                        خلخال گشت</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=irantourcity&level=1">تور
                                                        های داخلی</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=iranhotelcity">هتل
                                                        های داخلی</a></li>
                                                {*<li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=29">بلیط هواپیما و قطار</a></li>*}
                                            </ul>
                                            <ul>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=visacountry">ویزا</a>
                                                </li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=countrytour">تور
                                                        های خارجی</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=hotelcountry">هتل
                                                        های خارجی</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=30">راهنمایی
                                                        گردشگری</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=31">کاپوتاژ
                                                        خودرو</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/home.php?bashgah=bashgah">باشگاه
                                                        مشتریان</a></li>

                                            </ul>
                                        </div>
                                    </li>
                                    <li class="has-sub"><a href="javascript:;">تورها</a>
                                        <div class="submenu">
                                            <ul>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=irantourcity&level=1">تورهای
                                                        داخلی </a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=countrytour">تورهای
                                                        خارجی</a></li>
                                                <li class="all-tours"><a
                                                            href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=alltours">مشاهده
                                                        همه تور ها </a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="has-sub"><a href="javascript:;">هتل ها</a>
                                        <div class="submenu">
                                            <ul>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=iranhotelcity">هتل
                                                        های داخلی</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=countrytour">هتل
                                                        های خارجی</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="has-sub"><a href="javascript:;">خدمات گردشگری</a>
                                        <div class="megasub">
                                            <ul>
                                                {*<li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=32">خرید بلیط</a></li>*}
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=visacountry">ویزا</a>
                                                </li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=33">تاکسی
                                                        سرویس</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=product3">خدمات
                                                        گردشگری</a></li>
                                            </ul>
                                            <ul>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=34">راهنما
                                                        گردشگری</a></li>
                                                <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a>
                                                </li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=product1">اجاره
                                                        خودرو</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=36">تهیه
                                                        سوغات</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=order">درخواست
                                                        خدمات</a></li>
                                            </ul>
                                            <ul>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=37">اجاره
                                                        سوییت</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=38">گواهی
                                                        نامه رانندگی بین المللی</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=39">تفریحات</a>
                                                </li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=40">پلاک
                                                        ترانزیت و کاپوتاژ خودرو</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=41">اماکن
                                                        گردشگری</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=pay">پرداخت
                                                        آنلاین</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=news">اخبار
                                            و مجله گردشگری</a></li>
                                    <li><a target="_blank" href="https://bamkala.com/">فروشگاه اینترنتی</a></li>
                                    <li class="has-sub"><a href="javascript:;">ارتباط با ما</a>
                                        <div class="submenu">
                                            <ul>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=contactus">تماس
                                                        باما</a></li>
                                                <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a>
                                                </li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=42">درخواست
                                                        همکاری و سرمایه گذاری</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=43">درخواست
                                                        نمایندگی</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=44">نمایندگی
                                                        ها</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=45">استخدام</a>
                                                </li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=46">انتقادات
                                                        و پیشنهادات</a></li>
                                                <li>
                                                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=packageregister">ثبت
                                                        نام همکاران</a></li>

                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <div class="temp-head-inner">

        </div>
    {/if}

{/if}




{if $smarty.const.GDS_SWITCH eq 'app'}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
{else}
    <div class="main-temp">
        <div class="container">
            <div class="temp-wrapper">
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
            </div>
        </div>
    </div>
{/if}


{if $smarty.session.layout neq 'pwa'}
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation}
        <footer>
            <div class="container">
                <div class="footer-newslatter">
                    <div>برای دریافت جدیدترین اخبار سایت و شرکت در قرعه کشی همراه ما باشید</div>
                    <p id="AlertSmsTemp"></p>
                    <form action="post">
                        <div class="f-name"><input name="NameSms" id="NameSms" placeholder="نام و نام خانوادگی"
                                                   type="text"></div>
                        <div class="f-birthday"><input name="BirthdaySms" id="BirthdaySms" placeholder="تاریخ تولد"
                                                       class="shamsiBirthdayCalendar" type="text"></div>
                        <div class="f-name"><input name="CellSms" id="CellSms" onchange="Mobile(value,'SpamCell')"
                                                   onkeypress="return isNumberKeyFields(event,'CellSms')"
                                                   placeholder="شماره همراه" type="text"></div>
                        <div class="f-email"><input name="EmailSms" id="EmailSms" placeholder="پست الکترونیکی"
                                                    onchange="Email(value,'SpamEmail')" type="text"></div>
                        <div class="f-name">
                            <button type="button" class="button" onClick="SmsTemp()">عضویت</button>
                        </div>
                    </form>
                    <span id="SpamCell"></span>
                    <span id="SpamEmail"></span>
                </div>
                <div class="footer-middle">
                    <div class="row">
                        <div class="col-lg-4  col-xl-4 col-md-12">
                            <div class="footer-about">
                                <div class="logo-footer">
                                    <img src="project_files/images//logo-footer-1.png" alt="">
                                    <a href="#0" id="info" class="info popup-trigger" title="کلیک کنید">آدرس ما روی
                                        نقشه</a>
                                    <div class="popup" role="alert">
                                        <div class="popup-container">
                                            <a href="#0" class="popup-close img-replace">بستن</a>

                                            <div class="adrespop">

                                                <span>آدرس : <span
                                                            class="SMFooterAddress">{$smarty.const.CLIENT_ADDRESS}</span></span>
                                                <span>تلفن پشتیبانی :  <span
                                                            class="SMFooterPhone">{$smarty.const.CLIENT_PHONE}</span> </span>

                                            </div>

                                            <div id="g-map">


                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <div class="footer-address">
                                    <div class="f-adress SMFooterAddress">{$smarty.const.CLIENT_ADDRESS}</div>
                                    <div class="f-tell SMFooterPhone">{$smarty.const.CLIENT_PHONE}</div>
                                    <div class="f-mob SMFooterMobile">{$smarty.const.CLIENT_MOBILE}</div>
                                    <div class="f-mail SMFooterEmail">{$smarty.const.CLIENT_EMAIL}</div>
                                </div>
                                <div class="footer-social">
                                    <p>آژانس خلخال گشت را در شبکه های اجتماعی دنبال کنید</p>
                                    <ul class="social_list">
                                        <li class="social_list_item"><a class="SMGoogle" target="_blank"><i
                                                        class="google-plus"></i></a>
                                        </li>
                                        <li class="social_list_item"><a class="SMFaceBook" target="_blank"><i
                                                        class="facebook"></i></a>
                                        </li>
                                        <li class="social_list_item"><a class="SMTwitter" target="_blank"><i
                                                        class="twitter"></i></a>
                                        </li>
                                        <li class="social_list_item"><a class="SMInstageram" target="_blank"><i
                                                        class="instagram"></i></a>
                                        </li>
                                        <li class="social_list_item"><a class="SMTelegram" target="_blank"><i
                                                        class="telegram-plane"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="enamad">

                                    <a target="_blank"
                                       href="https://trustseal.enamad.ir/?id=137947&Code=sAUAXLIy0IVHritkvLJ5"><img
                                                src="https://Trustseal.eNamad.ir/logo.aspx?id=137947&Code=sAUAXLIy0IVHritkvLJ5"
                                                alt="" style="cursor:pointer" id="sAUAXLIy0IVHritkvLJ5"></a>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-6 mr-auto ml-auto">
                            <div class="footer-links">
                                <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=aboutus">معرفی</a>
                                <a href="{$smarty.const.ROOT_ADDRESS}/loginUser">ورود کاربران</a>
                                <a href="https://www.bamekhalkhal.com/fa/user/register.php">عضویت</a>
                                <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=news">اخبار</a>
                                <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=42">فرصت
                                    های سرمایه گذاری</a>
                                <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=product3">خدمات
                                    گردشگری</a>
                                <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=alltours">تور
                                    های گردشگری</a>
                                <a target="_blank" href="https://bamkala.com/">فروشگاه اینترنتی</a>
                                <a href="{$smarty.const.ROOT_ADDRESS}/resultHotelLocal/37/{$objDate->jtoday()}/1/110">رزرو
                                    سوییت های بام خلخال</a>
                                <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=pay">پرداخت
                                    آنلاین</a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-4 col-md-6">
                            <div class="footer-about">
                                <div class="logo-footer">
                                    <img src="project_files/images/logo-footer-2.png" alt="">
                                    <a href="#0" id="info" class="info popup-trigger2" title="کلیک کنید">آدرس ما روی
                                        نقشه</a>

                                    <div class="popup2" role="alert">
                                        <div class="popup-container">
                                            <a href="#0" class="popup-close img-replace">بستن</a>

                                            <div class="adrespop">

                                                <span>آدرس : <span
                                                            class="SMFooterAddressExtra">{$smarty.const.CLIENT_ADDRESS}</span></span>
                                                <span>تلفن پشتیبانی :  <span
                                                            class="SMFooterPhoneExtra">{$smarty.const.CLIENT_PHONE}</span> </span>

                                            </div>

                                            <div id="g-map-xtra">


                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <div class="footer-address">
                                    <div class="f-adress SMFooterAddressExtra">{$smarty.const.CLIENT_ADDRESS}</div>
                                    <div class="f-tell SMFooterPhoneExtra">{$smarty.const.CLIENT_PHONE}</div>
                                    <div class="f-mob SMFooterMobileExtra">{$smarty.const.CLIENT_MOBILE}</div>
                                    <div class="f-mail SMFooterEmailExtra">{$smarty.const.CLIENT_EMAIL}</div>
                                </div>
                                <div class="footer-social">
                                    <p>بام خلخال را در شبکه های اجتماعی دنبال کنید</p>
                                    <ul class="social_list">
                                        <li class="social_list_item"><a href="javascript:;"><i class="google-plus"></i></a>
                                        </li>
                                        <li class="social_list_item"><a href="javascript:;"><i class="facebook"></i></a>
                                        </li>
                                        <li class="social_list_item"><a href="javascript:;"><i class="twitter"></i></a>
                                        </li>
                                        <li class="social_list_item"><a href="javascript:;"><i
                                                        class="instagram"></i></a>
                                        </li>
                                        <li class="social_list_item"><a href="javascript:;"><i
                                                        class="telegram-plane"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="footer-bot">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                کلیه حقوق این سایت متعلق به<a
                                        href="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_MAIN_DOMAIN}/"> {$smarty.const.CLIENT_NAME}</a>
                                می باشد
                            </div>
                            <div class="col-md-6 irtech__">
                                <a class="iran-tech" alt="طراحی سایت" href="https://www.iran-tech.com">طراحی سایت</a>
                                ایران تکنولوژی
                            </div>
                        </div>
                    </div>
                </div>
        </footer>
    {/if}
{else}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}

{/if}

{if $smarty.const.GDS_SWITCH neq 'app'}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
{/if}

{literal}
    <script type="text/javascript">
      $(document).ready(function() {
        var header = $('.header')
        var menuActive = false
        setHeader()

        $(window).on('resize', function() {
          setHeader()
        })

        $(document).on('scroll', function() {
          setHeader()
        })

        function setHeader() {
          if (window.innerWidth < 992) {
            if ($(window).scrollTop() > 100) {
              header.addClass('scrolled')
            } else {
              header.removeClass('scrolled')
            }
          } else {
            if ($(window).scrollTop() > 100) {
              header.addClass('scrolled')
            } else {
              header.removeClass('scrolled')
            }
          }
          if (window.innerWidth > 991 && menuActive) {
            closeMenu()
          }
        }

        //side bar menu
        $('.hamburger').click(function() {
          $('.background-modal-box').show()
          $('.mainnav').animate({
            right: '0px',
          })
        })
        $('.background-modal-box').click(function() {
          $(this).hide()
          $('.mainnav').animate({
            right: '-245px',
          })
        })
        $('.has-sub a').click(function() {
          $(this).parents('.has-sub').toggleClass('open-sub')
        })
      })
    </script>
    <script type="text/javascript" src="project_files/js/jquery.mask.js"></script>
    <script type="text/javascript" src="project_files/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="project_files/js/breaking-news-ticker.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
          integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
          crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
            integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
            crossorigin=""></script>
    <script type="text/javascript">
      // position we will use later ,
      var lat = 37.619473
      var lon = 48.530730
      // initialize map
      map = L.map('g-map').setView([lat, lon], 15)
      // set map tiles source
      L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        maxZoom: 16,
        minZoom: 14,
      }).addTo(map)
      // add marker to the map
      marker = L.marker([lat, lon]).addTo(map)
      // add popup to the marker
      marker.bindPopup(' خلخال ، خیابان امام خمینی ، خیابان شهید مظفر عزیزی (سه راه بیمارستان قدیم )، مجتمع تجاری صدف ، طبقه اول ').openPopup()
    </script>
    <script type="text/javascript">
      // position we will use later ,
      var lat = 37.611063
      var lon = 48.540481
      // initialize map
      map = L.map('g-map-xtra').setView([lat, lon], 15)
      // set map tiles source
      L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        maxZoom: 16,
        minZoom: 14,
      }).addTo(map)
      // add marker to the map
      marker = L.marker([lat, lon]).addTo(map)
      // add popup to the marker
      marker.bindPopup(' خلخال ، خیابان سیمتری قدس روبروی هلال احمر خیابان بام خلخال ').openPopup()

      function newslatterdown() {
        $('body,html').animate({
          scrollTop: $('.footer-newslatter').offset().top - 100,
        }, 1000)
      }

      //open popup
      $('.popup-trigger').on('click', function(event) {
        event.preventDefault()
        $('.popup').addClass('is-visible')
      })

      //close popup
      $('.popup').on('click', function(event) {
        if ($(event.target).is('.popup-close') || $(event.target).is('.popup')) {
          event.preventDefault()
          $(this).removeClass('is-visible')
        }
      })

      //open popup
      $('.popup-trigger2').on('click', function(event) {
        event.preventDefault()
        $('.popup2').addClass('is-visible')
      })

      //close popup
      $('.popup2').on('click', function(event) {
        if ($(event.target).is('.popup-close') || $(event.target).is('.popup2')) {
          event.preventDefault()
          $(this).removeClass('is-visible')
        }
      })

      $(document).ready(function() {

        $('.main-navigation__button2').click(function() {
          $('.main-navigation__sub-menu2').fadeToggle()
        })

        $('.top__user_menu').bind('click', function(e) {
          //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
          e.stopPropagation()

        })

        $('body').click(function() {
          $('.main-navigation__sub-menu2').fadeOut()

        })
      })
    </script>
{/literal}
</body>

</html>