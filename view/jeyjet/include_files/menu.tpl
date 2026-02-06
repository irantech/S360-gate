{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{assign var="pass_hash" value=$obj_main_page->hashPasswordUser()}
{load_presentation_object filename="visa" assign="visaObj"}
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
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/flight">بلیط</a>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">هتل</a>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور</a>

                                <ul class="nav-dropdown nav-submenu">
                                    <li class="">
                                        <a href="javascript:">داخلی</a>
                                        {if $objResult->ReservationTourCities('=1', 'return')}
                                        <ul class="nav-dropdown nav-submenu">
                                            {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCities('=1', 'return')}
                                                <li>
                                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-{$item_tour.id}/all/all">
                                                        {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                    </a>
                                                </li>
                                            {/foreach}
                                            <li><a class="a_header_active" href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-all/all/all/0">نمایش همه</a></li>
                                        </ul>
                                        {/if}
                                    </li>
                                    <li class="">
                                        <a href="javascript:">خارجی</a>
                                        {if $objResult->ReservationTourCountries('yes')}
                                        <ul class="nav-dropdown nav-submenu">
                                            {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries('yes')}
                                                <li>
                                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/all/all">
                                                        {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                    </a>
                                                </li>
                                            {/foreach}
                                        </ul>
                                        {/if}
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/insurance">بیمه</a>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/visa">ویزا</a>
                                <ul class="nav-dropdown nav-submenu">
                                    {foreach $visaObj->getVisaListByCategoryId(['category_id' => 1]) as $key => $visa}
                                    <li class="">
                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultVisa/{$visa['country_code']}/all/1-0-0/1">
                                            {$visa['country_name']}
                                        </a>
                                        <ul class="nav-dropdown nav-submenu nav-menu_ul">
                                            {foreach $visa['visa_list'] as $key => $visa_type}
                                                <li>
                                                    <a href='{$smarty.const.ROOT_ADDRESS}/visa/{$visa['country_code']}/{$visa_type['id']}'>
                                                        {$visa_type['type_title']}
                                                    </a>
                                                </li>
                                            {/foreach}
                                        </ul>
                                    </li>
                                    {/foreach}


                                    <li>
                                        <a class="a_header_active" href="{$smarty.const.ROOT_ADDRESS}/page/visa">جست و جوی ویزا</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/mag">وبلاگ</a>
                            </li>
                            <li>
                                <a href="javascript:">بیشتر</a>
                                <ul class="nav-dropdown nav-submenu">
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/news">اخبار</a></li>
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/pay">درگاه پرداخت آنلاین</a></li>
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/authenticate">باشگاه مشتریان</a></li>
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/rules">قوانین و مقررات</a></li>
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a></li>
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/contactUs">تماس با ما</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="parent-btn-header">
                    <a class="__phone_class__ btn-phone-number" href="tel:{$smarty.const.CLIENT_PHONE}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M484.6 330.6C484.6 330.6 484.6 330.6 484.6 330.6l-101.8-43.66c-18.5-7.688-40.2-2.375-52.75 13.08l-33.14 40.47C244.2 311.8 200.3 267.9 171.6 215.2l40.52-33.19c15.67-12.92 20.83-34.16 12.84-52.84L181.4 27.37C172.7 7.279 150.8-3.737 129.6 1.154L35.17 23.06C14.47 27.78 0 45.9 0 67.12C0 312.4 199.6 512 444.9 512c21.23 0 39.41-14.44 44.17-35.13l21.8-94.47C515.7 361.1 504.7 339.3 484.6 330.6zM457.9 469.7c-1.375 5.969-6.844 10.31-12.98 10.31c-227.7 0-412.9-185.2-412.9-412.9c0-6.188 4.234-11.48 10.34-12.88l94.41-21.91c1-.2344 2-.3438 2.984-.3438c5.234 0 10.11 3.094 12.25 8.031l43.58 101.7C197.9 147.2 196.4 153.5 191.8 157.3L141.3 198.7C135.6 203.4 133.8 211.4 137.1 218.1c33.38 67.81 89.11 123.5 156.9 156.9c6.641 3.313 14.73 1.531 19.44-4.219l41.39-50.5c3.703-4.563 10.16-6.063 15.5-3.844l101.6 43.56c5.906 2.563 9.156 8.969 7.719 15.22L457.9 469.7z"></path>
                        </svg>
                        <span>
                             {$smarty.const.CLIENT_PHONE}
                        </span>
                    </a>

                    <a class="__login_register_class__ button btn-user {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}"
                       href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">
                        <svg class="" data-v-640ab9c6="" fill="" viewbox="0 0 24 24">
                            <path d="M17.25 12.75A3.75 3.75 0 0 1 21 16.5v3.75a.75.75 0 0 1-.75.75H3.75a.75.75 0 0 1-.75-.75V16.5a3.75 3.75 0 0 1 3.75-3.75h10.5Zm0 1.5H6.75A2.25 2.25 0 0 0 4.5 16.5v3h15v-3a2.25 2.25 0 0 0-2.118-2.246l-.132-.004ZM12 3a4.5 4.5 0 1 1 0 9 4.5 4.5 0 1 1 0-9Zm0 1.5a3 3 0 1 0-.001 5.999A3 3 0 0 0 12 4.5Z"
                                  fill-rule="evenodd"></path>
                        </svg>
                        <span>{include file="../../include/signIn/topBarName.tpl"}</span>
                    </a>
                    <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
                        {include file="../../include/signIn/topBar.tpl"}
                    </div>
                    <a class="btn-follow" href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
                        <svg viewbox="0 0 640 512" xmlns="http://www.w3.org/2000/svg">
                            <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M32 128V384C32 401.7 46.33 416 64 416H338.2L330.2 448H64C28.65 448 0 419.3 0 384V128C0 92.65 28.65 64 64 64H512C547.3 64 576 92.65 576 128V192C565.1 191.7 554.2 193.6 544 197.6V128C544 110.3 529.7 96 512 96H64C46.33 96 32 110.3 32 128V128zM368 288C376.8 288 384 295.2 384 304C384 312.8 376.8 320 368 320H112C103.2 320 96 312.8 96 304C96 295.2 103.2 288 112 288H368zM96 208C96 199.2 103.2 192 112 192H464C472.8 192 480 199.2 480 208C480 216.8 472.8 224 464 224H112C103.2 224 96 216.8 96 208zM537.5 241.4C556.3 222.6 586.7 222.6 605.4 241.4L622.8 258.7C641.5 277.5 641.5 307.9 622.8 326.6L469.1 480.3C462.9 486.5 455.2 490.8 446.8 492.1L371.9 511.7C366.4 513 360.7 511.4 356.7 507.5C352.7 503.5 351.1 497.7 352.5 492.3L371.2 417.4C373.3 408.9 377.7 401.2 383.8 395.1L537.5 241.4zM582.8 264C576.5 257.8 566.4 257.8 560.2 264L535.3 288.8L575.3 328.8L600.2 303.1C606.4 297.7 606.4 287.6 600.2 281.4L582.8 264zM402.2 425.1L389.1 474.2L439 461.9C441.8 461.2 444.4 459.8 446.4 457.7L552.7 351.4L512.7 311.5L406.5 417.7C404.4 419.8 402.9 422.3 402.2 425.1L402.2 425.1z"></path>
                        </svg>
                        <span>پیگیری خرید</span>
                    </a>
                </div>
                <div class="nav-toggle"></div>
            </nav>
        </div>
    </div>


    <div class="container">
        <div class="search-box-scroll-mobile d-none">
            <a class="nav-link" href="{$smarty.const.ROOT_ADDRESS}/page/flight">
                <div>
                    <svg viewbox="0 0 640 512" xmlns="http://www.w3.org/2000/svg">
                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M176 153.1V112.1C176 74.04 207 0 256 0C304 0 336 74.04 336 112.1V154.1L422.4 208.1C411.5 213.1 401.1 219.3 391.6 226.3L304 171.1V112.1C304 81.04 278 33.02 256 33.02C233 33.02 208 81.04 208 113.1V172.1L32 282.1V347.2L208 292.1V392.2L144 440.2V480.2L256 448.2L358.1 477.4C366.4 487.9 375.9 497.4 386.4 505.7C378.5 511.4 368.8 513.2 360 511.2L256 480.2L152 510.2C142 513.3 132 511.2 124 505.2C116 499.2 112 490.2 112 480.2V440.2C112 430.2 116 421.2 124 415.2L176 376.2V335.2L41 378.2C31 381.2 20 379.2 12 373.2C4 367.2 0 357.2 0 347.2V282.1C0 271.1 6 259.1 16 254.1L176 153.1zM563.3 324.7C569.6 330.9 569.6 341.1 563.3 347.3L491.3 419.3C485.1 425.6 474.9 425.6 468.7 419.3L428.7 379.3C422.4 373.1 422.4 362.9 428.7 356.7C434.9 350.4 445.1 350.4 451.3 356.7L480 385.4L540.7 324.7C546.9 318.4 557.1 318.4 563.3 324.7H563.3zM352 368C352 288.5 416.5 224 496 224C575.5 224 640 288.5 640 368C640 447.5 575.5 512 496 512C416.5 512 352 447.5 352 368zM496 480C557.9 480 608 429.9 608 368C608 306.1 557.9 256 496 256C434.1 256 384 306.1 384 368C384 429.9 434.1 480 496 480z"></path>
                    </svg>
                </div>
            </a>
            <a class="nav-link" href="{$smarty.const.ROOT_ADDRESS}/page/hotel">
                <div>
                    <svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M48 384C56.84 384 64 376.8 64 368c0-105.9 86.13-192 192-192s192 86.13 192 192c0 8.844 7.156 16 16 16s16-7.156 16-16c0-118.1-91.97-214.9-208-223.2V96h32C312.8 96 320 88.84 320 80S312.8 64 304 64h-96C199.2 64 192 71.16 192 80S199.2 96 208 96h32v48.81C123.1 153.1 32 249.9 32 368C32 376.8 39.16 384 48 384zM496 416h-480C7.156 416 0 423.2 0 432S7.156 448 16 448h480c8.844 0 16-7.156 16-16S504.8 416 496 416z"></path>
                    </svg>
                </div>
            </a>
            <a class="nav-link" href="{$smarty.const.ROOT_ADDRESS}/page/insurance">
                <div>
                    <svg viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg">
                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M471.6 99.4c46.8 45.1 72.2 109 68.3 174.7l-86.3-31.4c15.2-43.2 21.6-89 18.9-134.8c-.2-2.9-.5-5.7-.9-8.5zM402.8 54.3c21.7 10.1 36.3 31.4 37.7 55.6c2.5 41.4-3.3 82.8-17 121.9l-167.6-61c14.6-38.8 36.9-74.2 65.3-104.3c17.5-18.5 44.1-25.2 68.2-17.3c1.1 .4 2.2 .8 3.3 1.2c3.4 1.2 6.7 2.5 10 3.9zm-3.1-35.4c-109.8-38-228.4 3.2-292.6 94c-11.1 15.7-2.8 36.8 15.3 43.4l92.4 33.6 0 0L245 200.9l167.6 61 30.1 10.9 0 0 89.1 32.4c18.1 6.6 38-4.2 39.6-23.4c9-108.1-52-213.2-155.6-256.9c-2.4-1.1-4.9-2.1-7.4-3l-5.9-2.1c-.9-.3-1.8-.6-2.7-.9zM305.9 37c-2.7 2.3-5.4 4.8-7.9 7.5c-31.5 33.3-56 72.5-72.2 115.4l-89.6-32.6C176.5 73 239.2 40.1 305.9 37zM16 480c-8.8 0-16 7.2-16 16s7.2 16 16 16H560c8.8 0 16-7.2 16-16s-7.2-16-16-16H253.4l77.8-213.7-30.1-10.9L219.4 480H16z"></path>
                    </svg>
                </div>
            </a>
            <a class="nav-link" href="{$smarty.const.ROOT_ADDRESS}/page/tour">
                <div>
                    <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M352.1 128h-32.07l.0123-80c0-26.47-21.53-48-48-48h-96c-26.47 0-48 21.53-48 48L128 128H96.12c-35.35 0-64 28.65-64 64v224c0 35.35 28.58 64 63.93 64L96 496C96 504.8 103.2 512 112 512S128 504.8 128 496V480h192v16c0 8.836 7.164 16 16 16s16-7.164 16-16l.0492-16c35.35 0 64.07-28.65 64.07-64V192C416.1 156.7 387.5 128 352.1 128zM160 48C160 39.17 167.2 32 176 32h96C280.8 32 288 39.17 288 48V128H160V48zM384 416c0 17.64-14.36 32-32 32H96c-17.64 0-32-14.36-32-32V192c0-17.64 14.36-32 32-32h256c17.64 0 32 14.36 32 32V416zM304 336h-160C135.2 336 128 343.2 128 352c0 8.836 7.164 16 16 16h160c8.836 0 16-7.164 16-16C320 343.2 312.8 336 304 336zM304 240h-160C135.2 240 128 247.2 128 256c0 8.836 7.164 16 16 16h160C312.8 272 320 264.8 320 256C320 247.2 312.8 240 304 240z"></path>
                    </svg>
                </div>
            </a>
            <a class="nav-link" href="{$smarty.const.ROOT_ADDRESS}/page/visa">
                <div>
                    <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M224 80c-70.75 0-128 57.25-128 128s57.25 128 128 128s128-57.25 128-128S294.8 80 224 80zM129.6 224h39.13c1.5 27 6.5 51.38 14.12 70.38C155.3 281.1 134.9 255.3 129.6 224zM168.8 192H129.6c5.25-31.25 25.62-57.13 53.25-70.38C175.3 140.6 170.3 165 168.8 192zM224 302.8C216.3 295.3 203.3 268.3 200.6 224h46.75C244.8 268.3 231.8 295.3 224 302.8zM200.5 192C203.3 147.8 216.3 120.8 224 113.3C231.8 120.8 244.8 147.8 247.4 192H200.5zM265.1 294.4C272.8 275.4 277.8 251 279.3 224h39.13C313.1 255.3 292.8 281.1 265.1 294.4zM279.3 192c-1.5-27-6.5-51.38-14.12-70.38c27.62 13.25 48 39.13 53.25 70.38H279.3zM448 368v-320C448 21.49 426.5 0 400 0h-320C35.82 0 0 35.82 0 80V448c0 35.35 28.65 64 64 64h368c8.844 0 16-7.156 16-16S440.8 480 432 480H416v-66.95C434.6 406.4 448 388.8 448 368zM384 480H64c-17.64 0-32-14.36-32-32s14.36-32 32-32h320V480zM400 384H64c-11.71 0-22.55 3.389-32 8.9V80C32 53.49 53.49 32 80 32h320C408.8 32 416 39.16 416 48v320C416 376.8 408.8 384 400 384z"></path>
                    </svg>
                </div>
            </a>
        </div>
    </div>



    <div class="res-menu">
        <a class="https://{$smarty.const.CLIENT_MAIN_DOMAIN}" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
            <i class="fa-solid fa-house"></i>
            خانه
        </a>
        <a href="{$smarty.const.ROOT_ADDRESS}/contactUs">
            <i class="fa-regular fa-phone"></i>
            تماس با ما
        </a>
        <a href="{$smarty.const.ROOT_ADDRESS}/authenticate">
            <i class="fa-regular fa-users"></i>
            باشگاه مشتریان
        </a>
        <a href="{$smarty.const.ROOT_ADDRESS}/mag">
            <i class="fa-regular fa-newspaper"></i>
            وبلاگ
        </a>
        <a class="__login_register_class__  {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if} "
           href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">
            <i class="fa-regular fa-circle-user"></i>
            حساب کاربری
        </a>
    </div>
</header>