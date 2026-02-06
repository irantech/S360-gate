{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{assign var="hashedPass" value=functions::HashKey({$smarty.session.cardNo},'encrypt')}
<!DOCTYPE html>

<html class="no-js" lang="en">

<head>
    <title>{$obj->Title_head()}</title>
    <link rel="shortcut icon" type="image/x-icon" href="project_files/images/logo.png"/>
    <meta name="description" content="{$obj->Title_head()}">
    <meta charset="UTF-8">
    <base href="{$smarty.const.CLIENT_DOMAIN}"/>

    <!--   <link rel="stylesheet" href="project_files/css/hover.css">-->
    <!-- Main CSS files -->
    <link rel="stylesheet" href="project_files/css/baseFa.css">
    <!-- plugin css file -->
    <link rel="stylesheet" href="project_files/css/plugin.css">
    <!-- <link rel="stylesheet" href="project_files/css/camera.css" > -->
    <link rel="stylesheet" type="text/css" href="project_files/css/jssor-new.css">

    <!-- Animation CSS file -->
    <link rel="stylesheet" href="project_files/css/animate.css">
    <!-- custom CSS file -->
    <link rel="stylesheet" href="project_files/css/custom.css">
    <link rel="stylesheet" href="project_files/css/responsive.css">
    <!-- jQuery Library files -->
    <script type="text/javascript" src="project_files/js/modernizr.js"></script>
    <script src="project_files/js/jquery-2.1.4.min.js"></script>

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}

</head>
<body>



{if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation}
    <div class="_div_user_links">
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

                <ul class="_gds_user_box">
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
    <header>
        <div class="container">
            <div class="logo-title">
                <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/" class="logo"><img alt="logo" src="project_files/images/logo.png"></a>
                <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/"><h1>شرکت خدمات مسافرتی و جهانگردی مهرگان سیر</h1>
                </a>
            </div>

            <!-- menu-->
            <a class="en" href="http://mehreganseyr.com/en/user/home.php">En</a>
            <div class="top-tell">
                <a href="tel:{$smarty.const.CLIENT_PHONE}">{$smarty.const.CLIENT_PHONE}</a>
            </div>

            <div class="mainMenuContainer yekan">
                <a href="#0" class="mobMenu">منوی سایت</a>

                <ul class="mainMenu">
                    <li class="active"><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/">صفحه اصلی</a></li>
                    <li class="has-menu"><a>بلیط </a>
                        <ul class="subMenu">
                            <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=localticket&id=3">داخلی</a></li>
                            <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=portalticket&id=4">خارجی</a></li>
                        </ul>
                    </li>

                    <li class="has-menu"><a>تور </a>
                        <ul class="subMenu">
                            <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=irantour&idcity=81&level=1">داخلی</a></li>
                            <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=tour&idcountry=414">خارجی</a></li>
                        </ul>
                    </li>

                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=hoteldetail&idhotel=99&idcity=873&country=414">هتل </a></li>

                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=visacountry" class="SMVisa">ویزا</a></li>
                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=pay" class="SMPay">پرداخت آنلاین</a></li>
                    <li class="has-menu"><a>مهرگان سیر</a>
                        <ul class="subMenu">
                            <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=aboutus" class="SMAbout">درباره ما</a></li>
                            <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=rules" class="SMRules">قوانین و مقررات</a></li>
                            <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking"> پیگیری خرید</a></li>
                            <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=contactus" class="SMContactUs">تماس با ما</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </header>
{/if}


<div class="clear"></div>
<!-- temp content     -->
<div class="container temp">
    <div class="temp-content">
        <div class="clear"></div>
        <div class="temp-wrapper">
            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
        </div>
    </div>

</div>


<!--Footer-->

{if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
    <footer>
        <div class="top-footer container animatedParent" data-sequence="1000">
            <div class="right-footer col-xs-12 col-sm-6 col-md-6 col-lg-4 marb20 ">
                <h5 class="txt18">شرکت خدمات مسافرتی و جهانگردی مهرگان سیر</h5>
                <p>ارائه دهنده ی خدمات مسافرت هوایی و رزرواسیون هتل های ایرانی و خارجی</p>
                <img class="footer-logo" src="project_files/images/footer-logo.png" alt="logo">
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 marb20  contact">

                <p class="txtWhite txt18 txtRight padb5 yekan" dir="rtl">اطلاعات تماس</p>
                <p class="txt14 txtRight txtDDD lh20 padr10 marb5" dir="rtl"><a href="javascript:;"><img src="project_files/images/nav2.png"
                                                                                               alt="Location"
                                                                                               class="mapNav"></a><span
                            class="SMFooterAddress">{$smarty.const.CLIENT_ADDRESS}</span></p>
                <p class="txtRight lh20 padr10" dir="rtl"><span class="txtWhite txt14">تلفن:</span><span
                            class="SMFooterPhone txt18 txtDDD yekan padr15"
                            dir="ltr">{$smarty.const.CLIENT_PHONE}</span></p>
                <p class="txtRight lh20 padr10" dir="rtl"><span class="txtWhite txt14">فکس:</span><span
                            class="SMFooterFax txt18 txtDDD yekan padr10" dir="ltr">{$smarty.const.CLIENT_FAX}</span>
                </p>
                <p class="txtRight lh20 padr10 marb15" dir="rtl"><span class="txtWhite txt14">ایمیل:</span><a
                            href="mailto:{$smarty.const.CLIENT_EMAIL}"
                            class="SMFooterEmail txt16 txtDDD tdNU padr15">{$smarty.const.CLIENT_EMAIL}</a></p>

            </div>


            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 chat-online">
                <div id="g-map"></div>
            </div>

        </div>

        <div class="bottom-footer ">
            <div class="container">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 copyrights">
                    <p class="txt14 yekan">کلیه حقوق وب سایت متعلق به آژانس <a
                                href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/">مهرگان سیر</a> می باشد.</p>

                    <p class="txt14 yekan">طراحی وب سایت: <a href="http://iran-tech.com/" target="_blank">ایران
                            تکنولوژی</a></p>
                </div>
            </div>
        </div>

    </footer>
{/if}
<!--BACK TO TOP BUTTON-->
<div class="backToTop"></div>
{literal}
    <script src="project_files/js/script.js"></script>
{/literal}


</body>
</html>
