{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<style>
    @media (max-width: 992px) {
        header{
            display: block !important;
        }
    }
</style>
<header class="i_modular_menu header_area">
    <div class="main_header_area animated" id="navbar">
        <div class="container-fluid">
            <nav class="navigation" id="navigation1">
                <div class="parent-logo-menu">
                    <a class="nav-header" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                        <img alt="{$obj->Title_head()}" class="__logo_class__ logo"
                             src="project_files/images/logo.png" />
                    </a>
                    <div class="nav-menus-wrapper">
                        <ul class="nav-menu align-to-right">
                            <li>
                                <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">خانه</a>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">هتل</a>
                                <ul class="nav-dropdown nav-submenu">
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/karbala">
                                            رزرو هتل کربلا
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/najaf">
                                            رزرو هتل نجف
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/Kadhimiya">
                                            رزرو هتل کاظمین
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/sameraa">
                                            رزرو هتل سامراء
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">کاروان</a>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/Transfer">حمل و نقل</a>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/mag">وبلاگ</a>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a>
                                <ul class="nav-dropdown nav-submenu">
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">چرا کاروان سادات ؟</a></li>
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/contactUs">تماس با ما</a></li>
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/vote">نظرات</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="parent-btn-header box_button_header">
                    <a class="btn-follow" href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
                        <!--                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">-->
                        <!--                            <!&ndash;! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. &ndash;>-->
                        <!--                            <path d="M32 128V384C32 401.7 46.33 416 64 416H338.2L330.2 448H64C28.65 448 0 419.3 0 384V128C0 92.65 28.65 64 64 64H512C547.3 64 576 92.65 576 128V192C565.1 191.7 554.2 193.6 544 197.6V128C544 110.3 529.7 96 512 96H64C46.33 96 32 110.3 32 128V128zM368 288C376.8 288 384 295.2 384 304C384 312.8 376.8 320 368 320H112C103.2 320 96 312.8 96 304C96 295.2 103.2 288 112 288H368zM96 208C96 199.2 103.2 192 112 192H464C472.8 192 480 199.2 480 208C480 216.8 472.8 224 464 224H112C103.2 224 96 216.8 96 208zM537.5 241.4C556.3 222.6 586.7 222.6 605.4 241.4L622.8 258.7C641.5 277.5 641.5 307.9 622.8 326.6L469.1 480.3C462.9 486.5 455.2 490.8 446.8 492.1L371.9 511.7C366.4 513 360.7 511.4 356.7 507.5C352.7 503.5 351.1 497.7 352.5 492.3L371.2 417.4C373.3 408.9 377.7 401.2 383.8 395.1L537.5 241.4zM582.8 264C576.5 257.8 566.4 257.8 560.2 264L535.3 288.8L575.3 328.8L600.2 303.1C606.4 297.7 606.4 287.6 600.2 281.4L582.8 264zM402.2 425.1L389.1 474.2L439 461.9C441.8 461.2 444.4 459.8 446.4 457.7L552.7 351.4L512.7 311.5L406.5 417.7C404.4 419.8 402.9 422.3 402.2 425.1L402.2 425.1z"/>-->
                        <!--                        </svg>-->
                        <img alt="Hotel-tab" src="project_files/images/Icon-04.png" />
                        <span>پیگیری خرید</span>
                    </a>

                    <a class="__login_register_class__  button_header logIn button btn-user {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}"
                       href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">
                        <!--                        <svg viewBox="0 0 24 24" fill="" class="" data-v-640ab9c6="">-->
                        <!--                            <path d="M17.25 12.75A3.75 3.75 0 0 1 21 16.5v3.75a.75.75 0 0 1-.75.75H3.75a.75.75 0 0 1-.75-.75V16.5a3.75 3.75 0 0 1 3.75-3.75h10.5Zm0 1.5H6.75A2.25 2.25 0 0 0 4.5 16.5v3h15v-3a2.25 2.25 0 0 0-2.118-2.246l-.132-.004ZM12 3a4.5 4.5 0 1 1 0 9 4.5 4.5 0 1 1 0-9Zm0 1.5a3 3 0 1 0-.001 5.999A3 3 0 0 0 12 4.5Z"-->
                        <!--                                  fill-rule="evenodd"></path>-->
                        <!--                        </svg>-->
                        <img alt="Hotel-tab" class="Icon06" src="project_files/images/Icon-06.png" />
                        <img alt="Hotel-tab" class="Icon06res" src="project_files/images/Icon-06-res.png" />
                        <span>{include file="../../include/signIn/topBarName.tpl"}</span>
                    </a>
                    <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
                        {include file="../../include/signIn/topBar.tpl"}
                    </div>
                    <a class="btn-phone-number" href="tel:{$smarty.const.CLIENT_PHONE}">
                        <!--                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">-->
                        <!--                            <!&ndash;! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. &ndash;>-->
                        <!--                            <path d="M484.6 330.6C484.6 330.6 484.6 330.6 484.6 330.6l-101.8-43.66c-18.5-7.688-40.2-2.375-52.75 13.08l-33.14 40.47C244.2 311.8 200.3 267.9 171.6 215.2l40.52-33.19c15.67-12.92 20.83-34.16 12.84-52.84L181.4 27.37C172.7 7.279 150.8-3.737 129.6 1.154L35.17 23.06C14.47 27.78 0 45.9 0 67.12C0 312.4 199.6 512 444.9 512c21.23 0 39.41-14.44 44.17-35.13l21.8-94.47C515.7 361.1 504.7 339.3 484.6 330.6zM457.9 469.7c-1.375 5.969-6.844 10.31-12.98 10.31c-227.7 0-412.9-185.2-412.9-412.9c0-6.188 4.234-11.48 10.34-12.88l94.41-21.91c1-.2344 2-.3438 2.984-.3438c5.234 0 10.11 3.094 12.25 8.031l43.58 101.7C197.9 147.2 196.4 153.5 191.8 157.3L141.3 198.7C135.6 203.4 133.8 211.4 137.1 218.1c33.38 67.81 89.11 123.5 156.9 156.9c6.641 3.313 14.73 1.531 19.44-4.219l41.39-50.5c3.703-4.563 10.16-6.063 15.5-3.844l101.6 43.56c5.906 2.563 9.156 8.969 7.719 15.22L457.9 469.7z"/>-->
                        <!--                        </svg>-->
                        <img alt="Hotel-tab" class="Icon05" src="project_files/images/Icon-05.png" />
                        <img alt="Hotel-tab" class="Icon05res" src="project_files/images/Icon-05-res.png" />
                        <span class="__phone_class__"
                              >{$smarty.const.CLIENT_PHONE}</span>
                    </a>
                </div>
                <div class="nav-toggle"></div>
            </nav>
        </div>
    </div>
</header>