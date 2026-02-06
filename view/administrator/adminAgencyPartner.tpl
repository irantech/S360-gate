{*<pre>{$smarty.session|print_r}</pre>*}
{load_presentation_object filename="admin" assign="objAdmin"}
<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="assets/plugins/images/fv.png">
    <title>پنل مدیریت-نرم افزار پرواز</title>
    <!-- Bootstrap Core CSS -->

    <link href="assets/plugins/bower_components/bootstrap-rtl-master/dist/css/bootstrap-rtl.min.css"
          rel="stylesheet">
    <link href="assets/css/font/base.css" rel="stylesheet">
    <link href="assets/css/font/booking/booking.css" rel="stylesheet">
    <link href="assets/plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- Color picker plugins css -->
    <link href="assets/plugins/bower_components/jquery-asColorPicker-master/css/asColorPicker.css" rel="stylesheet">
    {*<link href="assets/css/buttons.dataTable.min.css" rel="stylesheet" type="text/css"/>*}
    <link href="assets/plugins/bower_components/datatables-plugins/dl/buttons.dataTables.min.css"
          rel="stylesheet" type="text/css"/>
    {*<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">*}
    <link href="assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <link href="assets/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <link href="assets/plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
    <link href="assets/plugins/bower_components/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="assets/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css"
          rel="stylesheet">

    <link href="assets/plugins/bower_components/calendar/dist/fullcalendar.css" rel="stylesheet"/>


    <link href="assets/plugins/bower_components/custom-select/custom-select.css" rel="stylesheet"
          type="text/css"/>
    <link href="assets/plugins/bower_components/switchery/dist/switchery.min.css" rel="stylesheet"/>
    <link href="assets/plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet"/>
    <link href="assets/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css"
          rel="stylesheet"/>
    <link href="assets/plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css"
          rel="stylesheet"/>
    <link href="assets/plugins/bower_components/multiselect/css/multi-select.css" rel="stylesheet"
          type="text/css"/>
    <link href="assets/plugins/bower_components/dropify/dist/css/dropify.min.css" rel="stylesheet">
    <link href="assets/plugins/bower_components/JqueryConfirm/jquery-confirm.css" rel="stylesheet">
    <link type="text/css" href="assets/css/jquery-ui.min.css" rel="stylesheet"/>

    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">
    <link href="assets/css/animate.css" rel="stylesheet">
    <link href="assets/css/spinners.css" rel="stylesheet">
    <link href="assets/css/colors/green.css" id="theme" rel="stylesheet">

    <!-- jQuery -->
    <script src="assets/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--Counter js -->
    <script src="assets/plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
    <script src="assets/plugins/bower_components/counterup/jquery.counterup.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="assets/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="assets/js/waves.js"></script>
    <!-- Vector map JavaScript -->
    <script src="assets/plugins/bower_components/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="assets/plugins/bower_components/vectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="assets/plugins/bower_components/vectormap/jquery-jvectormap-in-mill.js"></script>
    <script src="assets/plugins/bower_components/vectormap/jquery-jvectormap-us-aea-en.js"></script>

    <!-- sparkline chart JavaScript -->
    <script src="assets/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="assets/plugins/bower_components/jquery-sparkline/jquery.charts-sparkline.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="assets/js/custom.js"></script>

    <!--Data Tables-->
    <script src="assets/plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/bower_components/datatables-plugins/dl/dataTables.Buttons.min.js"></script>
    <script src="assets/plugins/bower_components/datatables-plugins/dl/buttons.flash.min.js"></script>
    <script src="assets/plugins/bower_components/datatables-plugins/dl/jszip.min.js"></script>
    <script src="assets/plugins/bower_components/datatables-plugins/dl/pdfmake.min.js"></script>
    <script src="assets/plugins/bower_components/datatables-plugins/dl/vfs_fonts.js"></script>
    <script src="assets/plugins/bower_components/datatables-plugins/dl/buttons.html5.min.js"></script>
    <script src="assets/plugins/bower_components/datatables-plugins/dl/buttons.print.min.js"></script>


    <!--Other Page-->
    <script src="assets/plugins/bower_components/toast-master/js/jquery.toast.js"></script>
    <script src="assets/plugins/bower_components/morrisjs/morris.js"></script>
    <script src="assets/plugins/bower_components/moment/moment.js"></script>
    <script src='assets/plugins/bower_components/calendar/dist/fullcalendar.min.js'></script>
    <script src="assets/plugins/bower_components/calendar/dist/cal-init.js"></script>
    <script src="assets/js/cbpFWTabs.js"></script>

    <!--Style Switcher -->
    <script src="assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    {*<script src="assets/js/validator.js"></script>*}


    <script src="assets/plugins/bower_components/custom-select/custom-select.min.js"
            type="text/javascript"></script>
    <script src="assets/plugins/bower_components/bootstrap-select/bootstrap-select.min.js"
            type="text/javascript"></script>
    <script src="assets/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="assets/plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"
            type="text/javascript"></script>
    <script src="assets/plugins/bower_components/multiselect/js/jquery.multi-select.js"
            type="text/javascript"></script>
    <script src="assets/plugins/bower_components/dropify/dist/js/dropify.min.js"></script>
    <script src="assets/plugins/bower_components/validator/jquery.validate.js"></script>
    <script src="assets/plugins/bower_components/validator/additional-methods.js"></script>
    <script src="assets/plugins/bower_components/JqueryConfirm/jquery-confirm.js"></script>
    <script src="assets/js/jquery.form.js"></script>
    <!-- Color Picker Plugin JavaScript -->
    <script src="assets/plugins/bower_components/jquery-asColorPicker-master/libs/jquery-asColor.js"></script>
    <script src="assets/plugins/bower_components/jquery-asColorPicker-master/libs/jquery-asGradient.js"></script>
    <script src="assets/plugins/bower_components/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>


    <script>
        var amadeusPath = '{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/';
        var libraryPath = "{$smarty.const.ROOT_LIBRARY}/";
        var DomainAdmin = "{$smarty.const.CLIENT_MAIN_DOMAIN}";
    </script>
</head>

<body class="fix-header">
<!-- ============================================================== -->
<!-- Preloader -->
<!-- ============================================================== -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
</div>
<!-- ============================================================== -->
<!-- Wrapper -->
<!-- ============================================================== -->
<div id="wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <nav class="navbar navbar-default navbar-static-top m-b-0">
        <div class="navbar-header navbar_headering">
            <div class="top-left-part">
                <!-- Logo -->
                <a class="logo" href="{$smarty.const.SERVE_HTTP}{$smarty.const.Domain}/gds/itadmin/admin">
                    <!-- Logo icon image, you can use font-icon also --><b>
                        <!--This is dark logo icon-->

                        <img src="assets/plugins/images/admin-logo.png" alt="home"
                             class="dark-logo hidden-xs "/>
                        <!--This is light logo icon-->
                        <img src="assets/plugins/images/admin-logo-mini.png" alt="home"
                             class="dark-logo hidden-lg hidden-md hidden-sm"/>
                    </b>

                </a>
            </div>
            <!-- /Logo -->

            <!-- Search input and Toggle icon -->
            <ul class="nav navbar-top-links navbar-left" onclick="getCount();">
                <li><a href="javascript:void(0)" class="open-close waves-effect waves-light visible-xs"><i
                                class="ti-close ti-menu"></i></a></li>
                {if $smarty.const.TYPE_ADMIN neq '1'}
                    <li class="dropdown">
                        <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"> <i
                                    class="mdi mdi-gmail"></i>
                            {if $objMessage->CountUnreadMessage() >  0 }
                                <div class="notify"><span class="heartbit"></span> <span class="point"></span></div>
                            {/if}
                        </a>
                        <input type="hidden" value="{$objMessage->CountUnreadMessage()}" id="inputUnreadMessage">
                        <ul class="dropdown-menu mailbox animated bounceInDown">
                            <li>
                                <div class="drop-title">شما
                                    <span class="yn" id="countMessageAjax"></span>
                                    پیام مشاهده نشده دارید
                                </div>
                            </li>
                            <li>
                                <div class="message-center">

                                    {foreach $objMessage->UnreadMessage() as  $i => $item}
                                        <a href="#" id="preview-{$item.id}"
                                           onclick="HeaderModalShowMessage('{$item.id}');return false"
                                           data-toggle="modal" data-target="#ModalPublic">
                                            <div class="user-img"><i class="mdi
                                                      {if $i % 3 eq 0}
                                                       mdi-message-outline
                                                      {elseif $i % 3 eq 1}
                                                        mdi-message
                                                      {elseif $i % 3 eq 2}
                                                      mdi-message-text
                                                      {/if}
                                                "></i></div>
                                            <div class="mail-contnet">
                                                <h5>{$item.title}</h5> <span
                                                        class="mail-desc">{$item.message|mb_substr:0:15}...</span> <span
                                                        class="time">{$objDate->jdate('Y-m-d (H:i:s)', $item.creation_date_int)}</span>
                                            </div>
                                        </a>
                                    {/foreach}


                                </div>
                            </li>
                            <li>
                                <a class="text-center"
                                   href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/messageBox"> <strong>مشاهده
                                        بقیه پیام ها</strong> <i class="fa fa-angle-left"></i> </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-messages -->
                    </li>
                {/if}
            </ul>

            <ul class="nav navbar-top-links navbar-right pull-right">
                <li class="dropdown">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown"
                       href="#">
                        <img
                                src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$smarty.const.CLIENT_LOGO}"
                                alt="user-img" width="36"
                                class="img-circle"><b
                                class="hidden-xs">{if $smarty.const.TYPE_ADMIN eq '1'}ایران تکنولوژی {else}{$smarty.const.CLIENT_NAME}{/if}</b><span
                                class="caret"></span>
                    </a>


                    <ul class="dropdown-menu dropdown-user animated flipInY">
                        {if $smarty.session.AgencyPartner neq 'AgencyHasLogin'}
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img
                                                src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$smarty.const.CLIENT_LOGO}"
                                                alt="user"/>
                                    </div>
                                    <div class="u-text">
                                        <h4>{if $smarty.const.TYPE_ADMIN eq '1'}ایران تکنولوژی {else}{$smarty.const.CLIENT_NAME}{/if}</h4>
                                        <p class="text-muted">{$smarty.const.CLIENT_EMAIL}</p>
                                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/myProfile"
                                           class="btn btn-rounded btn-danger btn-sm"> مشاهده
                                            پروفایل </a></div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/changePassword"><i
                                            class="mdi mdi-account-key fa-fw"></i>
                                    <span>تغییر کلمه عبور</span></a></li>
                            <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/transactionUser"><i
                                            class="fa fa-money fa-fw"></i><span>جزئیات اعتبار</span> </a></li>
                            {if $smarty.const.TYPE_ADMIN neq '1'}
                                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/messageBox"><i
                                                class="mdi mdi-email-outline fa-fw"></i>
                                        <span>صندوق پیام ها</span></a></li>
                            {/if}
                        {/if}
                        <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/addCreditAgency" target="_blank"><i
                                        class="mdi mdi-credit-card-plus"></i>
                                <span>افزایش اعتبار </span></a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="http://www.safarbank.ir/irantech" target="_blank"><i
                                        class="mdi mdi-bell-ring"></i>
                                <span>اخبار </span></a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#" onclick="logoute(); return false;" class="colorExit"><i
                                        class="fa fa-power-off fa-fw"></i>
                                خروج</a>
                        </li>
                    </ul>

                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>


            {if $smarty.const.TYPE_ADMIN eq '1'}
                {load_presentation_object filename="bookhotelshow" assign="objbookHotel"}
                {assign var="countReserveHotel" value=$objbookHotel->getHotelOnRequestForAdmin()}
                <ul class="nav navbar-top-links navbar-right pull-right"
                    style="border-left: 1px solid rgba(0,0,0,.08);">
                    <li class="dropdown">
                        <a class="profile-pic"
                           href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/reservation/hotelWishList"
                           target="_blank">
                            <img src="assets/css/images/notification-reserve-safar360.png"
                                 alt="notification reserve hotel" width="36" class="img-circle">
                            <div class="notify {if $countReserveHotel eq 0}displayN{/if}"
                                 style="position: absolute !important;"
                                 id="notifyReserveHotel"><span class="heartbit"></span><span class="point"></span></div>
                            <b class="hidden-xs"> <i
                                        id="numberReserveHotel">{if $countReserveHotel gt 0}{$countReserveHotel}{/if}</i>
                                درخواست رزرو هتل </b>
                        </a>
                    </li>
                </ul>
                {load_presentation_object filename="bookingBusShow" assign="objbookBus"}
                {assign var="countBusTicket" value=$objbookBus->getCountBusBookingInStatusTemporaryReservation()}
                <ul class="nav navbar-top-links navbar-right pull-right"
                    style="border-left: 1px solid rgba(0,0,0,.08);">
                    <li class="dropdown">
                        <a class="profile-pic"
                           href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/busTicket/busHistory"
                           target="_blank">
                            <img src="assets/css/images/notification-reserve-safar360.png"
                                 alt="notification reserve hotel" width="36" class="img-circle">
                            <div class="notify {if $countBusTicket eq 0}displayN{/if}"
                                 style="position: absolute !important;"
                                 id="notifyReserveHotel"><span class="heartbit"></span><span class="point"></span></div>
                            <b class="hidden-xs"> <i
                                        id="numberReserveHotel">{if $countBusTicket gt 0}{$countBusTicket}{/if}</i> رزرو
                                اتوبوس </b>
                        </a>
                    </li>
                </ul>
            {/if}


        </div>
        <!-- /.navbar-header -->
        <!-- /.navbar-top-links -->
        <!-- /.navbar-static-side -->
    </nav>
    <!-- End Top Navigation -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <div class="navbar-default sidebar sidebar_2" role="navigation">
        <div class="sidebar-nav slimscrollsidebar">
            <div class="sidebar-head sidebar-head_2">
                <h4 class="h4_bar_icon"><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i
                                class="ti-close visible-xs"></i></span> <span
                            class="hide-menu">{if $smarty.const.TYPE_ADMIN eq '1'}ایران تکنولوژی {else}{$smarty.const.CLIENT_NAME}{/if}</span>
                </h4>
            </div>
            <ul class="nav slide_menu_" id="side-menu">

                {assign var="menu" value=$objAdmin->LinkAdminMenu()}
                {*<pre>{$menu|print_r}</pre>*}
                {foreach $menu as $key=>$link}
                    {if (($link['accessCustomer'] eq '1')||($link['accessCustomer'] eq '0' && $smarty.const.TYPE_ADMIN  eq '1'))}

                        {if $link['parentId'] eq '0'}
                            {if $link['url'] eq '#'}
                                <li>
                                <a href="#"
                                   class="waves-effect ColorAndSizeMenu">
                                    <i class="{$link['classIcon']}"></i>
                                    <span class="fa fa-arrow-left arrowleft_menu  text-align-left"></span>
                                    <span class="hide-menu">{$link['title']}</span></a>
                                <ul class="nav nav-second-level nav_ul_second">
                                    {foreach $menu as $level1Key=>$valueLevel1}
                                        {if $valueLevel1['parentId'] eq $link['id']}
                                            {if $valueLevel1['url'] eq '#'}
                                                <li>
                                                    <a href="javascript:void(0);" class="waves-effect">
                                                        <i class="{$valueLevel1['classIcon']}"
                                                           data-icon="v"></i>
                                                        <span class="hide-menu"> {$valueLevel1['title']}
                                                            <span class="fa fa-angle-left arrowleft_menu text-align-left"></span>
                                                            <span class="label label-rouded label-inverse pull-right"></span></span>
                                                    </a>
                                                    <ul class="nav nav-second-level nav_ul_third">
                                                        {foreach $menu as $level2Key=>$valueLevel2}
                                                            {if $valueLevel2['parentId'] eq $valueLevel1['id']}
                                                                {if (($valueLevel2['accessCustomer'] eq '1' )||($valueLevel2['accessCustomer'] eq '0' && $smarty.const.TYPE_ADMIN  eq '1'))}
                                                                    {if $smarty.session.AgencyPartner eq 'AgencyHasLogin' && $objAdmin->accessMenuCounter($valueLevel2['id'],$smarty.session.memberIdCounterInAdmin) }
                                                                        <li>
                                                                            <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/{$valueLevel2['url']}">
                                                                                <i class="{$valueLevel2['classIcon']}"></i>
                                                                                <span class="hide-menu padding-right-10">{$valueLevel2['title']}</span>
                                                                            </a>
                                                                        </li>
                                                                    {/if}
                                                                {/if}
                                                            {/if}
                                                        {/foreach}
                                                    </ul>
                                                </li>
                                            {else}
                                                {if $smarty.session.AgencyPartner eq 'AgencyHasLogin' && $objAdmin->accessMenuCounter($valueLevel2['id'],$smarty.session.memberIdCounterInAdmin) }
                                                <li>
                                                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/{$valueLevel1['url']}">
                                                        <i class="{$valueLevel1['classIcon']}"></i>
                                                        <span class="hide-menu">{$valueLevel1['title']}</span></a>
                                                </li>
                                                {/if}
                                            {/if}
                                        {/if}
                                    {/foreach}
                                </ul>
                                </li>
                            {else}
                                {if ($smarty.session.AgencyPartner eq 'AgencyHasLogin' && $objAdmin->accessMenuCounter($valueLevel1['id'],$smarty.session.memberIdCounterInAdmin)) || (($link['accessCustomer'] eq '1')||($link['accessCustomer'] eq '0' && $smarty.const.TYPE_ADMIN  eq '1')) }
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/{$link['url']}"
                                           class="waves-effect ColorAndSizeMenu parentMenuPadding">
                                            <i class="{$link['classIcon']}" data-icon="v"></i>
                                            <span class="hide-menu">{$link['title']}</span></a>
                                    </li>
                                {/if}
                            {/if}
                        {/if}

                    {/if}
                {/foreach}


            </ul>

        </div>
        <div class="app-sidebar-bg opacity-06" style="background-image: url(assets/bgs.jpg);"></div>
    </div>
    <!-- ============================================================== -->
    <!-- End Left Sidebar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page Content -->
    <!-- ============================================================== -->
    <div id="page-wrapper">
        {include file=$obj->page}
    </div>
    <!-- /#page-wrapper -->
    <footer class="footer text-center"> 2017 &copy; iran-tech.com All Rights Reserved</footer>
</div>

{*{if $smarty.const.TYPE_ADMIN eq '1'}
    {literal}
        <script>
            setInterval(function () {
                $.post(amadeusPath + 'hotel_ajax.php',
                    {
                        flag: "checkReserveHotel"
                    },
                    function (data) {
                        if (parseInt(data) > 0){
                            $('#numberReserveHotel').html(data);
                            $('#notifyReserveHotel').removeClass('displayN');
                        } else {
                            $('#numberReserveHotel').html('');
                            $('#notifyReserveHotel').addClass('displayN');
                        }
                    });
            },90000);
        </script>
    {/literal}
{/if}*}

<script src="assets/js/dashboard3.js"></script>
<script src="assets/js/calendar.js" type="text/javascript"></script>
<script src="assets/js/jquery-migrate-1.4.0.min.js" type="text/javascript"></script>
<script src="assets/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="assets/js/jquery.ui.datepicker-cc.js" type="text/javascript"></script>
<script src="assets/js/jquery.ui.datepicker-cc-fa.js" type="text/javascript"></script>
<!-- chartist chart -->
<script src="assets/plugins/bower_components/chartist-js/dist/chartist.min.js"></script>
<script src="assets/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="assets/plugins/bower_components/bootstrap-rtl-master/dist/js/bootstrap-rtl.min.js"></script>

<script src="assets/plugins/bower_components/switchery/dist/switchery.min.js"></script>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true" style="display: none;" id="ModalPublic"></div>

<!-- editor_TinyMCE -->
<script type="text/javascript" src="assets/editor_TinyMCE/editor/tinymce.min.js"></script>
<script type="text/javascript" src="assets/editor_TinyMCE/editor.js"></script>


</body>

</html>