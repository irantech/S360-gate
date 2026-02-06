<?php
require '../../../config/bootstrap.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));


?>

<div class="page">
    <input type="hidden"  name="InfoTicketResult" id="InfoTicketResult" value='<?php echo !empty($_GET['InfoRequest']) ? $_GET['InfoRequest'] : "" ?>'>
         <div class="page-content login-screen-content">
            <div class="nav-info site-bg-main-color">
                <div class="nav-info-inner">
                    <div class="back-link">
                        <a href="#" class="link back">
                            <span></span>
                        </a>
                    </div>
                    <div class="title">درخواست پیامکی رزرو پرواز</div>

                </div>
            </div>
            <div class="page-content-inner my-login">

                <input type="hidden" name="InfoFlightRequest" id="InfoFlightRequest" value='<?php echo $_GET['InfoRequest']?>'>
                <div class="list">
                    <ul>
                        <li class="item-content item-input">
                            <div class="item-inner">
                                <div class="item-title item-label">نام و نام خانوادگی</div>
                                <div class="item-input-wrap">
                                    <input type="text" id="fullName" name="fullName" placeholder="نام و نام خانوادگی ">
                                </div>
                            </div>
                        </li>
                        <li class="item-content item-input">
                            <div class="item-inner">
                                <div class="item-title item-label">شماره تلفن</div>
                                <div class="item-input-wrap">
                                    <input type="text" id="mobile" name="mobile" placeholder="شماره همراه">
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
<!--                <div class="list">-->
<!--                    <ul>-->
<!--                        <li>-->
<!--                            <a href="#" class="item-link remember-password">فراموشی رمز عبور</a>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </div>-->
                <div class="login-register-btn">
                    <a href="#" class="item-link site-bg-main-color list-button login-button SendRequestOffline">
                        <span> ارسال اطلاعات</span>
                        <i class="preloader color-white myhidden"></i>
                    </a>
<!--                    <a href="/Gobank/" class="item-link site-main-text-color site-border-main-color list-button register-button">ثبت نام</a>-->
                </div>
            </div>
        </div>
    </div>
</div>

