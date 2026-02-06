{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{assign var="hashedPass" value=functions::HashKey({$smarty.session.cardNo},'encrypt')}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta id="Language" name="Language" content="Persian, FA">
    <meta name="rating" content="General">
    <meta name="expires" content="never">
    <meta name="distribution" content="Global">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="revisit-after" content="1 Days">
    <meta name="email" content="info@ariantourist.com">
    <meta name="author" content="ariantourist.com">
    <meta name="publisher" content="ariantourist.com">
    <meta name="copyright" content="©2009 ariantourist.com">
    <meta name="samandehi" content="264439189"/>
    <title>{$obj->Title_head()}</title>
    <link rel="shortcut icon" type="image/x-icon" href="project_files/images/logo-fa.png"/>
    <meta name="description" content="{$obj->Title_head()}">
    <meta charset="UTF-8">
    <base href="{$smarty.const.CLIENT_DOMAIN}"/>

    <meta name="google-service-ir-panel-License-on" CONTENT="genieconnections">
    <meta name="google-site-verification" content="EqH7cUrS6ZEZ3iIx3IHWLSgqrZfSQY7k2fZ_8HMDuOk"/>
    <meta id="Description" name="Description"
          content="آژانس مسافرتی آرین توریست ارائه دهنده کلیه خدمات مسافرتی از جمله تورهای داخلی و خارجی | خدمات ویزا و بلیط همراه با تورهای ویژه و غیره">
    <meta id="Keywords" name="Keywords"
          content="خدمات بلیط,هتل,آژانس مسافرتی ,توریست ,خدمات مسافرتی ,تورهای ویژه,تور,بلیط , تورهای خارجی,تورهای داخلی,هتل خارجی,هتلهای خارجی,رزرو هتل,رزرواسیون هتل,تور خارجی,تور داخلی,تور مسافرتی,تورهای مسافرتی,رزرو هتل خارجی, رزرو هتل خارجی,رزرو هتلهای خارجی, رزرو هتلهای خارجی ">

    <link rel="shortcut icon" href="http://www.ariantourist.com/fa/user/images/favicon/favicon.ico"
          type="image/x-icon"/>
    <link href="project_files/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="project_files/css/user-page.css" rel="stylesheet" type="text/css"/>
    <link href="project_files/css/user_css_90.css" rel="stylesheet" type="text/css"/>
    <link href="project_files/css/tabs.css" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="project_files/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="project_files/js/modernizr.js"></script>

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}

</head>

<body>


<div id="top-bar">
    <div id="bar-content">
        <div class="top-bar">
            <div class="container">
                <div class="top-bar-inner">
                    <div class="login-register">
                        <div class="user_box ml-auto">
                            {if $objSession->IsLogin() }
                                <a target="_parent" class="userProfile-name"
                                   href="{$smarty.const.ROOT_ADDRESS}/userProfile">
                                    <span>{$objSession->getNameUser()} عزیز خوش آمدید</span>
                                    {if $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter'}
                                        <span class="CreditHide">(اعتبار آژانس شما {$objFunctions->CalculateCredit($objSession->getUserId())}
                                            ریال)</span>
                                    {/if}
                                </a>
                                <div class="user_box_profile user_box_link"><span></span><a target="_parent"
                                                                                            href="{$smarty.const.ROOT_ADDRESS}/userProfile">پروفایل
                                        کاربری</a>
                                </div>
                                <div class="user_box_logout user_box_link "><span></span><a style=" cursor: pointer "
                                                                                            class="no-border"
                                                                                            target="_parent"
                                                                                            onclick="signout()">خروج</a>
                                </div>
                            {else}


                            {/if}
                        </div>
                        {if $objSession->IsLogin() }

                        {else}
                            <div class="login">
                                <a target="_parent" class="no-border" href="{$smarty.const.ROOT_ADDRESS}/loginUser">
                                    <i class="svg-icon">
                                        <svg height="490pt" viewBox="0 -10 490.66667 490" width="490pt"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="m325.332031 251h-309.332031c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h309.332031c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"/>
                                            <path d="m240 336.332031c-4.097656 0-8.191406-1.554687-11.308594-4.691406-6.25-6.25-6.25-16.382813 0-22.636719l74.027344-74.023437-74.027344-74.027344c-6.25-6.25-6.25-16.386719 0-22.636719 6.253906-6.25 16.386719-6.25 22.636719 0l85.332031 85.335938c6.25 6.25 6.25 16.382812 0 22.632812l-85.332031 85.332032c-3.136719 3.160156-7.230469 4.714843-11.328125 4.714843zm0 0"/>
                                            <path d="m256 469.667969c-97.089844 0-182.804688-58.410157-218.410156-148.824219-3.242188-8.191406.808594-17.492188 9.023437-20.734375 8.191407-3.199219 17.515625.789063 20.757813 9.046875 30.742187 78.058594 104.789062 128.511719 188.628906 128.511719 111.742188 0 202.667969-90.925781 202.667969-202.667969s-90.925781-202.667969-202.667969-202.667969c-83.839844 0-157.886719 50.453125-188.628906 128.511719-3.265625 8.257812-12.566406 12.246094-20.757813 9.046875-8.214843-3.242187-12.265625-12.542969-9.023437-20.734375 35.605468-90.414062 121.320312-148.824219 218.410156-148.824219 129.386719 0 234.667969 105.28125 234.667969 234.667969s-105.28125 234.667969-234.667969 234.667969zm0 0"/>
                                        </svg>
                                    </i>
                                    ورود</a>
                            </div>
                            <div class="register">
                                <a target="_parent" class="no-border" href="{$smarty.const.ROOT_ADDRESS}/registerUser">
                                    <i class="svg-icon">
                                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;"
                                             xml:space="preserve">
						<g>
                            <g>
                                <path d="M367.57,256.909c-9.839-4.677-19.878-8.706-30.093-12.081C370.56,219.996,392,180.455,392,136C392,61.01,330.991,0,256,0
									c-74.991,0-136,61.01-136,136c0,44.504,21.488,84.084,54.633,108.911c-30.368,9.998-58.863,25.555-83.803,46.069
									c-45.732,37.617-77.529,90.086-89.532,147.743c-3.762,18.066,0.745,36.622,12.363,50.908C25.222,503.847,42.365,512,60.693,512
									H307c11.046,0,20-8.954,20-20c0-11.046-8.954-20-20-20H60.693c-8.538,0-13.689-4.766-15.999-7.606
									c-3.989-4.905-5.533-11.29-4.236-17.519c20.755-99.695,108.691-172.521,210.24-174.977c1.759,0.068,3.526,0.102,5.302,0.102
									c1.793,0,3.578-0.035,5.354-0.104c31.12,0.73,61.05,7.832,89.044,21.14c9.977,4.74,21.907,0.499,26.649-9.478
									C381.789,273.582,377.547,261.651,367.57,256.909z M260.878,231.877c-1.623-0.029-3.249-0.044-4.878-0.044
									c-1.614,0-3.228,0.016-4.84,0.046C200.465,229.35,160,187.312,160,136c0-52.935,43.065-96,96-96s96,43.065,96,96
									C352,187.299,311.555,229.329,260.878,231.877z"/>
                            </g>
                        </g>
                                            <g>
                                                <g>
                                                    <path d="M492,397h-55v-55c0-11.046-8.954-20-20-20c-11.046,0-20,8.954-20,20v55h-55c-11.046,0-20,8.954-20,20
									c0,11.046,8.954,20,20,20h55v55c0,11.046,8.954,20,20,20c11.046,0,20-8.954,20-20v-55h55c11.046,0,20-8.954,20-20
									C512,405.954,503.046,397,492,397z"/>
                                                </g>
                                            </g>
					 </svg>
                                    </i>
                                    ثبت نام</a>
                            </div>
                        {/if}
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
{if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation}

    <div id="header">
        <div id="nav" class="navs" dir="rtl">
            <ul>
                <li class="has-dropdown"><a href="javascript:;">آرین توریست</a>
                    <ul class="dropdown">
                        <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=1011">درباره ما</a></li>
                        <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=1182">مدیران و پرسنل</a></li>
                        <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=1041">تماس با ما</a></li>
                    </ul>
                </li>
                <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=1152">اخبار</a></li>
                <li class="has-dropdown"><a href="javascript:;">بلیط آنلاین</a>
                    <ul class="dropdown">
                        <li><a href="http://arian724.ir/" target="_blank">داخلی</a></li>
                        <li><a href="http://fasttkt.ir" target="_blank">خارجی</a></li>
                    </ul>
                </li>
                <li><a href="http://bbooking.ir" target="_blank">هتل آنلاین</a></li>
                <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=1111">سایت مرتبط</a></li>
                <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=1224">سفارت ها</a></li>
                <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=1071">پرسشهای متداول</a></li>
                <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=1141">نظرسنجی</a></li>
                {*<li><a href="javascript">قوانین و مقررات</a></li>*}
                <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a></li>
            </ul>
        </div>
        <div id="logo-en"><img src="project_files/images/logo-en.png" width="130" height="64" border="0"/></div>
        <div id="logo-fa"><img src="project_files/images/logo-fa.png" width="162" height="134" alt="" border="0"/></div>
        <div id="iso-badge"><a href="project_files/images/iso+9001.jpg" target="_blank">
                <img src="project_files/images/iso-badge.png" width="89" height="88" border="0"/>
            </a></div>
        <div id="iso-detail"><a href="project_files/images/iso+9001.jpg" target="_blank">دارای گواهینامه iso-9001</a></div>

    </div>

{/if}


<div id="page-main">
    <div id="container">

        <div class="content">

            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}





    </div>
</div>

    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}

        <div id="footer">
            <div id="copyright">
                <p>
                    <a href="https://www.iran-tech.com" rel="nofollow" target="_blank">
                        طراحی وب سایت
                    </a>
                    : ایران تکنولوژی
                </p>
            </div>
        </div>
    {/if}

{literal}
    <script type="text/javascript" src="project_files/js/script.js"></script>
{/literal}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}


</body>
</html>
