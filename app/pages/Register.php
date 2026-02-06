<?php
require '../../config/bootstrap.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));


?>

<div class="page">
    <input type="hidden" name="TypeRegister" id="TypeRegister" value="<?php echo (isset($_GET['Type']) && !empty($_GET['Type'])) ? $_GET['Type'] : '' ?>">
    <input type="hidden"  name="Uniq_idRegister" id="Uniq_idRegister" value="<?php echo !empty($_GET['Uniq_id']) ? $_GET['Uniq_id'] : '' ?>">
    <input type="hidden"  name="TypeZoneFlight" id="TypeZoneFlight" value="<?php echo !empty($_GET['TypeZoneFlight'])? $_GET['TypeZoneFlight'] : '' ?>">
    <input type="hidden"  name="SourceId" id="SourceId" value="<?php echo !empty($_GET['SourceId'])? $_GET['SourceId'] : '' ?>">


    <div class="page-content login-screen-content">
        <div class="nav-info site-bg-main-color">
            <div class="nav-info-inner">
                <div class="back-link">
                    <a href="#" class="link back">
                        <span></span>
                    </a>
                </div>
                <div class="title">ثبت نام</div>
            </div>
        </div>
        <div class="page-content-inner my-register">
            <form name="RegisterApp" id="RegisterApp">
                <input type="hidden" name="setcoockie" id="setcoockie" value="yes">
                <input type="hidden" name="Type" id="Type" value="App">
                <div class="list">
                    <ul>
                        <li class="item-content item-input">
                            <div class="item-inner">
                                <div class="item-title item-label">نام</div>
                                <div class="item-input-wrap">
                                    <input type="text" id="name" name="name" placeholder="نام خود را وارد کنید">
                                </div>
                            </div>
                        </li>
                        <li class="item-content item-input">
                            <div class="item-inner">
                                <div class="item-title item-label">نام خانوادگی</div>
                                <div class="item-input-wrap">
                                    <input type="text" id="family" name="family"
                                           placeholder="نام خانوادگی خود را وارد کنید">
                                </div>
                            </div>
                        </li>
                        <li class="item-content item-input">
                            <div class="item-inner">
                                <div class="item-title item-label">ایمیل</div>
                                <div class="item-input-wrap">
                                    <input type="text" id="email" name="email" placeholder="example@domain.com">
                                </div>
                            </div>
                        </li>
                        <li class="item-content item-input">
                            <div class="item-inner">
                                <div class="item-title item-label">شماره موبایل</div>
                                <div class="item-input-wrap">
                                    <input type="text" id="mobile" name="mobile"
                                           placeholder="شماره موبایل خود را وارد کنید">
                                </div>
                            </div>
                        </li>
                        <li class="item-content item-input">
                            <div class="item-inner">
                                <div class="item-title item-label">کد معرف</div>
                                <div class="item-input-wrap">
                                    <input type="text" id="reagentCode" name="reagentCode"
                                           placeholder="اگر معرف دارید کد آن را وارد کنید">
                                </div>
                            </div>
                        </li>
                        <!--				<li class="item-content item-input">-->
                        <!--					<div class="item-inner">-->
                        <!--						<div class="item-title item-label">کد امنیتی</div>-->
                        <!--						<div class="item-input-wrap">-->
                        <!--							<input type="text" id="username" name="username" placeholder="----------">-->
                        <!--						</div>-->
                        <!--					</div>-->
                        <!--				</li>-->
                    </ul>
                </div>
            </form>
            <div class="register-btn">
<!--                <p>ثبت نام به منزله قبول تمامی قوانین و مقررات ما می باشد</p>-->
                <a href="#" class="item-link list-button register-button site-bg-main-color RegisterButtonFunc" onclick="Register()">
                    <span> ثبت نام</span>
                    <i class="preloader color-white myhidden"></i>
                </a>
            </div>
        </div>
    </div>
</div>
</div>

