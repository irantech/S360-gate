<?php
require '../../config/bootstrap.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));


$useType = isset($_GET['useType']) && !empty($_GET['useType']) ? $_GET['useType'] : '';
$typeLogin = (isset($_GET['Type']) && !empty($_GET['Type'])) ? $_GET['Type'] : '';//برای اینکه متوجه بشیم مستقیم اومدیم تو لاگین یا از طریق روند خرید
?>

<div class="page">
    <input type="hidden" name="Type" id="Type" value="<?php echo $typeLogin ?>">
    <?php if (!empty($useType) && $useType == 'ticket') {
        include 'flight/infoLogin.php';
    } ?>

    <div class="page-content login-screen-content">
        <div class="nav-info site-bg-main-color">
            <div class="nav-info-inner">
                <div class="back-link">
                    <a href="#" class="link back">
                        <span></span>
                    </a>
                </div>
                <div class="title">ورود به حساب کاربری</div>

            </div>
        </div>
        <div class="page-content-inner my-login">

            <div class="list">
                <ul>
                    <li class="item-content item-input">
                        <div class="item-inner">
                            <div class="item-title item-label">نام کاربری</div>
                            <div class="item-input-wrap">
                                <input type="text" id="username" name="username" placeholder="نام کاربری (ایمیل)">
                            </div>
                        </div>
                    </li>
                    <li class="item-content item-input">
                        <div class="item-inner">
                            <div class="item-title item-label">کلمه عبور</div>
                            <div class="item-input-wrap">
                                <input type="password" id="password" name="password" placeholder="کلمه عبور (موبایل)">
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
            <div class="list">
                <ul>
                    <li>
                        <a href="/sendCode/" class="item-link remember-password">فراموشی رمز عبور</a>
                    </li>
                </ul>
            </div>
            <div class="login-register-btn">
                <a href="#" class="item-link site-bg-main-color list-button login-button "
                   onclick="Login('<?php echo $useType ?>')">
                    <span> ورود</span>
                    <i class="preloader color-white myhidden"></i>
                </a>
                <a href="#" class="item-link list-button register-button site-border-main-color site-main-text-color"
                   onclick="GoToRegisterPage('OfLoginPage')">
                    <span> ثبت نام</span>
                    <i class="preloader color-white myhidden"></i>
                </a>
            </div>
        </div>
    </div>
</div>


