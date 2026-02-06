{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{assign var="hashedPass" value=functions::HashKey({$smarty.session.cardNo},'encrypt')}
<!doctype html>
<html>
<head>
    <title>{$obj->Title_head()}</title>
    <meta name="description" content="{$obj->Title_head()}">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, user-scalable=0">
    <base href="{$smarty.const.CLIENT_DOMAIN}" />

    <link rel="shortcut icon" type="image/x-icon" href="project_files/images/favicon.ico" />
    <link rel="shortcut icon" type="image/x-icon" href="project_files/images/favicon.png" />
    <link href="project_files/css/style.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="project_files/GlobalFile/Style2.css" />

    <!-- bookjQuery -->
    <script type="text/javascript" src="project_files/js/slider/temp/jquery.js"></script>
    <!-- bookjQuery  end-->
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}


    <!--  menu -->
    <script type="text/javascript" src="project_files/js/menu/menu.js"></script>

    <link rel="stylesheet" href="project_files/js/menu/menu.css" type="text/css" />
    <link  rel="stylesheet" href="project_files/css/select2.css" type="text/css">
    <link  rel="stylesheet" href="project_files/css/tabs.css" type="text/css">
    <!--  wow -->
    <script type="text/javascript" src="project_files/js/wow.min.js"></script>
    <link rel="Stylesheet" type="text/css" href="project_files/css/animate.css" />

</head>
<body>
{if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation}
<div id="fixed_div">
    <div class="toptip_tbl">
        <div class="maindiv">


            <div class="logo_tbl">
                <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/">
                    <img src="project_files/images/logo.png" class="logo_class">
                </a>
            </div><!-- END logo_tbl-->

            {if $objSession->IsLogin() }
            <ul style="float: left">
                <li>
                    <div class="dashboard_menu" style="margin-top: 5px;">
                        <button><i class="fa fa-user" aria-hidden="true"></i></button>
                        <ul id="dropdown-list">

                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/userProfile">
                                    <i class="fa fa-user margin-left-10 font-i"></i>اطلاعات کاربری</a>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/UserBuy">
                                    <i class="fa fa-shopping-cart margin-left-10 font-i"></i>مشاهده خرید /
                                    استرداد </a>
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
                                    <i class="fa fa-key margin-left-10 font-i"></i>تغییر کلمه عبور</a>
                            </li>
                            <li>
                                <a class="icon icon-study" onclick="signout()">
                                    <i class="fa fa-sign-out margin-left-10 font-i"></i>خروج</a>
                            </li>
                        </ul>
                    </div>

                    <a class="userProfile-name" href="{$smarty.const.ROOT_ADDRESS}/userProfile">
                        <span>دوست عزیز {$objSession->getNameUser()} خوش آمدید</span>
                        {if $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter'}
                            <span class="CreditHide yekanB">اعتبار آژانس شما {$objFunctions->CalculateCredit($objSession->getUserId())}
                                ریال می باشد </span>
                        {/if}
                    </a>

                </li>
            </ul>
            {else}
            <span class="top_link_space"> | </span>
            <span class="top_link"> <a href="{$smarty.const.ROOT_ADDRESS}/registerUser"> ثبت نام</a> </span>
            <span class="top_link_space"> | </span>
            <span class="top_link"> <a href="{$smarty.const.ROOT_ADDRESS}/loginUser">  ورود</a> </span>
            {/if}
            <span class="top_link_space"> | </span>
            <span class="top_link"> <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=1041">تماس با ما</a> </span>
            <span class="top_link_space"> | </span>
            <span class="top_link"> <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=1012&id=1">درباره ما</a> </span>
            <span class="top_link_space"> | </span>
            <span class="top_link"> <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/">صفحه ورودی</a> </span>

        </div><!-- END maindiv-->
    </div><!-- END toptip_tbl-->

    <nav>



        <ul id="mbmcpebul_table" class="mbmcpebul_menulist css_menu">

            <li class="topitem spaced_li"><div class="arrow buttonbg_brown"><a class="button_2" >اطلاعات مفید</a></div>
                <ul>
                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=1231">آب و هوا</a></li>
                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=1230">ساعت کشورها</a></li>
                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=1300">گالری جهان</a></li>
                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=10950">لینک های مفید</a></li>
                </ul></li>
            <li class="topitem spaced_li"><div class="buttonbg_pink" style="width: 50px;"><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=1092999">ویزا</a></div></li>
            <li class="topitem spaced_li"><div class="buttonbg_pink" style="width: 100px;"><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a></div></li>
            <li class="topitem spaced_li"><div class="buttonbg_pink" style="width: 110px;"><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=1012&id=2"> قوانین و مقررات</a></div></li>
            <li class="topitem spaced_li"><div class="buttonbg_violet" style="width: 100px;"><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=12114999"> هتلهای خارجی</a></div></li>
            <!--<li class="topitem spaced_li"><div class="buttonbg_borpink" style="width: 112px;"><a href="temp.php?irantech_parvaz=ticket">بلیط آنلاین</a></div></li>-->
            <li class="topitem spaced_li"><div class="arrow buttonbg_red" style="width: 95px;"><a class="button_5" >تورها</a></div>
                <ul>
                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=1216999&other">تورهای خارجی</a></li>
                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=1125&level=1">تورهای داخلی</a></li>
                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=1216999&holy">تورهای زیارتی</a></li>
                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=1216999&healthy">تورهای درمانی</a></li>
                </ul></li>
            <li class="topitem spaced_li"><div class="arrow buttonbg_blue"><a class="button_6" >تورهای ویژه</a></div>
                <ul>
                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=12112999&sptour=1">تورهای ویژه خارجی</a></li>
                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=121122&level=1&sptour=1">تورهای ویژه داخلی</a></li>
                </ul></li>
            <li class="topitem spaced_li"><div class="buttonbg_green" style="width: 120px;"><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=1105999"> معرفی کشورها</a></div></li>

        </ul>


    </nav>

</div><!-- END #fixed_div-->

<div class="Clr"></div>

{/if}

<div class="art_tbl">

    <article style="margin-top: 100px;">
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
        <div class="Clr"></div>
    </article>
</div><!-- END art_tbl -->




{if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation}
<footer class="footer_tbl">
    <div class="maindiv">

        <div class="footadd">
            <h3>آدرس</h3>
            <span>تهران، میدان ولیعصر، ابتدای خیابان کریم خان زند، ساختمان شماره 314</span>
            <div class="Clr"></div>

            <p><i class="footadd_tel"></i>   88946610 - 021      </p>

            <p><i class="footadd_fax"></i>   88940968 - 021      </p>

            <p><i class="footadd_mail"></i> <a href="mailto:info@rastintours.com">info@rastintours.com</a>  </p>

            <div class="foot_circles">
                <a ><img src="project_files/images/fb-foot.png" class="foot_circles_class"></a>
                <a href="https://instagram.com/Iranrastintours" target="_blank"><img src="project_files/images/instgram-foot.png"  class="foot_circles_class"></a>

            </div><!-- END .foot_circles -->

        </div><!-- END .footadd --><!-- END foot_middle_box --><!-- END foot_last_box -->


        <div class="googlemap">
            {literal}
            <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script><div style="overflow:hidden;height:270px;width:600px;"><div id="gmap_canvas" style="height:270px;width:600px;"></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style><a class="google-map-code" href="http://www.map-embed.com" id="get-map-data">www.map-embed.com</a></div><script type="text/javascript"> function init_map(){var myOptions = {zoom:16,center:new google.maps.LatLng(35.71150194211368,51.407706147759995),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(35.71150194211368, 51.407706147759995)});infowindow = new google.maps.InfoWindow({content:"<b>&#1570;&#1688;&#1575;&#1606;&#1587; &#1605;&#1587;&#1575;&#1601;&#1585;&#1578;&#1740; &#1585;&#1575;&#1587;&#1578;&#1740;&#1606; &#1587;&#1740;&#1585;</b><br/> &#1578;&#1607;&#1585;&#1575;&#1606;&#1548; &#1605;&#1740;&#1583;&#1575;&#1606; &#1608;&#1604;&#1740;&#1593;&#1589;&#1585;&#1548; &#1575;&#1576;&#1578;&#1583;&#1575;&#1740; &#1582;&#1740;&#1575;&#1576;&#1575;&#1606; &#1705;&#1585;&#1740;&#1605; &#1582;&#1575;&#1606; &#1586;&#1606;&#1583;&#1548; &#1587;&#1575;&#1582;&#1578;&#1605;&#1575;&#1606; &#1588;&#1605;&#1575;&#1585;&#1607; 314 <br/>+98 (021) 88946610 " });google.maps.event.addListener(marker, "click", function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>
            {/literal}
        </div><!-- END .googlemap -->

    </div><!-- END maindiv-->
</footer><!-- END footer_tbl -->

<div class="Clr"></div>


<div class="copyright_tbl">
    <div class="copyright">
        <span>کلیه حقــوق این وب سایت متعلق به آژانس مسافرتی راستین سیر می باشد.</span>
        <a id="irantech" href="http://www.iran-tech.com/" target="_blank"  class="f_left">طراحی سایت: ایران تکنولوژی</a>
    </div><!--  End copyright  -->
</div><!--  End copyright_tbl  -->
{/if}
{literal}
<script type="text/javascript" src="project_files/js/select2.min.js"></script>
<script type="text/javascript" src="project_files/js/scripts.js"></script>
{/literal}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
</body>
</html>
