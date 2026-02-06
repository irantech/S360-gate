<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/plugins/images/fv.png">
    <title>پنل مدیریت</title>
    <!-- Bootstrap Core CSS -->
    <link href="assets/plugins/bower_components/bootstrap-rtl-master/dist/css/bootstrap-rtl.min.css" rel="stylesheet">
    <link href="assets/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="assets/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="assets/css/colors/green.css" id="theme" rel="stylesheet">
    <!-- color CSS -->
    <link href="assets/css/font/base.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">
    <link href="assets/css/select2.css" rel="stylesheet">


    <script type="text/javascript">
        var amadeusPath = '{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/';
    </script>
</head>
<body>
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="login" assign="ObjLogin"}
{*{$ObjLogin->popIso()}*}


<!-- Preloader -->
<div class="preloader">
    <div class="cssload-speeding-wheel"></div>
</div>
<div class='bg-itadmin-login-register'>
    <div class='parent-itadmin-login-register'>
    <div class="login-box login-sidebar">
        <div class="white-box">
            <form class="form-horizontal form-material" id="loginform" action="" method="post">
                <input type="hidden" name="ClientId" value="{if isset($smarty.get.id ) && $smarty.get.id neq ''}{$smarty.get.id}{/if}" id="ClientId">
                <a href="javascript:void(0)" class="text-center db">
                    <img src="assets/plugins/images/logo-itadmin-login.png" alt="Home"/></a>
                <div class="form-group m-t-30">
                    <div class="col-md-12">
                        <select name="typeManage" id="typeManage" class="form-control select2 select2-itadmin-login-register">
                            <option value="main_manager">مدیر سیستم</option>
                            <option value="sub_manager">مدیران زیر مجموعه</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" type="text" required="" placeholder="نام کاربری" name="username"
                               id="username"
                               value="{if isset($smarty.cookies.UserName)}{$smarty.cookies.UserName}{/if}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" type="password" required="" placeholder="رمز عبور" name="password"
                               id="password"
                               value="{if isset($smarty.cookies.Password)}{$smarty.cookies.Password}{/if}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="fieldset">
{*                            <label class="image-replace cd-captcha" for="signup-mobile2">کد امنیتی</label>*}
                            <input id="signup-captcha2" type="text" placeholder="کد امنیتی" name="Captcha">
                            <img id="captchaImage" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/captcha/securimage_show.php" alt="captcha image" />
                            <a id="captchaRefresh" class="captchaRefresh" href="#" title="refresh image" onclick="reloadCaptchaSignin2(); return false"></a>
                            <span class="cd-error-message" id="error-signup-captcha2"></span>
                        </div>
                    </div>
                </div>

                {*      <div class="form-group">
                          <div class="col-md-12">
                              <div class="checkbox checkbox-primary pull-left p-t-0">
                                  <input id="member" type="checkbox" name="member" {if isset($smarty.cookies.Member)}
                                         checked="checked" {/if} >
                                  <label for="member"> مرا به خاطر بسپار </label>
                              </div>
                              <!--<a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> رمز عبور را فراموش کرده ام</a>-->
                          </div>
                      </div>*}

                <div class="form-group text-center">
                    <div class="col-xs-12">
                        <button class="btn btn-lg btn-block text-uppercase waves-effect waves-light LoginAuto"
                                type="button" onclick="LoginAdmin(); return false;">ورود
                        </button>
                    </div>
                </div>
                <!--<div class="row">-->
                <!--<div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">-->
                <!--<div class="social"><a href="javascript:void(0)" class="btn  btn-facebook" data-toggle="tooltip"  title="Login with Facebook"> <i aria-hidden="true" class="fa fa-facebook"></i> </a> <a href="javascript:void(0)" class="btn btn-googleplus" data-toggle="tooltip"  title="Login with Google"> <i aria-hidden="true" class="fa fa-google-plus"></i> </a> </div>-->
                <!--</div>-->
                <!--</div>-->
                <div class="form-group m-b-0">
                    <div class="col-sm-12 text-center">
                        <p class='made-itadmin-login-register'>طراحی سایت های گردشگری توسط <a href="http://www.iran-tech.com/" target="_blank"
                                                      class="text-primary m-l-5"><b>ایران تکنولوژی</b></a></p>
                    </div>
                </div>
            </form>
            {*    <div class="row">
                    <div class="col-sm-6">
                        <a href="http://bit.ly/2P69TNe" target="_blank">
                        <img src="assets/plugins/images/agency.gif" alt="آژانس" style="margin: 0px 26px;"/>
                        </a>
                    </div>
                </div>*}
            <!--<form class="form-horizontal" id="recoverform" action="#" method="post">-->
            <!--<div class="form-group ">-->
            <!--<div class="col-xs-12">-->
            <!--<h3>بازیابی رمز عبور</h3>-->
            <!--<p class="text-muted">برای دریافت رمز عبور جدید پست الکترونیکی خود را وارد نمائید</p>-->
            <!--</div>-->
            <!--</div>-->
            <!--<div class="form-group ">-->
            <!--<div class="col-xs-12">-->
            <!--<input class="form-control" type="text" required="" placeholder="پست الکترونیک خود را وارد نمائید" data-error="Bruh, that email address is invalid" id="inputEmail4">-->
            <!--<div class="help-block with-errors"></div>-->
            <!--</div>-->
            <!--</div>-->
            <!--<div class="form-group text-center m-t-20">-->
            <!--<div class="col-xs-12">-->
            <!--<button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">بازیابی رمز عبور</button>-->
            <!--</div>-->
            <!--</div>-->
            <!--</form>-->
        </div>

    </div>
    <div id="wrapper" class="login-register"  style="background: url({$ObjLogin->getBackGround()}) center center/cover no-repeat !important;">

</div>
    </div>
</div>
<!-- jQuery -->
<script src="assets/plugins/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="assets/plugins/bower_components/bootstrap-rtl-master/dist/js/bootstrap-rtl.min.js"></script>
<!-- Menu Plugin JavaScript -->
<script src="assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>

<!--slimscroll JavaScript -->
<script src="assets/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="assets/js/waves.js"></script>
<!-- Custom Theme JavaScript -->
<script src="assets/js/custom.min.js"></script>
<!--Style Switcher -->
<script src="assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
<script src="assets/plugins/bower_components/toast-master/js/jquery.toast.js"></script>
<script src="assets/js/select2.min.js"></script>
<script src="assets/js/validator.js"></script>
<script src="assets/JsFiles/login.js"></script>

{*if $ObjLogin->loadModal neq ''}
<div class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true" style="display: block;" id="ModalPublic">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header site-bg-main-color">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <img src="http://www.iran-tech.com/tools/announcement.jpg"
                                 alt="Iso" width="90%" style="margin-right:40px; border: 1px solid #CCC;"/>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>
{/if*}
</body>
</html>

