{assign var="pass_hash" value=$obj_main_page->hashPasswordUser()}
{load_presentation_object filename="visa" assign="visaObj"}
<header class="i_modular_menu header_area">
    <div class="main_header_area animated" id="navbar">
        <div class="container">
            <nav class="navigation d-flex align-items-center">
                <div class="nav-header">
                    <a class="d-flex align-items-center" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                        <img alt="کیهان مهاجر" src="project_files/images/logo.png"/>
                        <div class="text-nav-brand">
                            <h1>کیهان مهاجر</h1>
                            <span>Keyhan Mohajer</span>
                        </div>
                    </a>
                </div>
                <div class="nav-menus-wrapper">
                    <ul class="nav-menu">
                        <li><a href="javascript:">ویزا</a>
                            <ul class="nav-dropdown">
                                <li>
                                    <div class="mega_menu">
                                        <div class="mega_menu_header">
                                            <h2>
                                                <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M336 384h-224C103.3 384 96 391.3 96 400S103.3 416 112 416h224c8.75 0 16-7.25 16-16S344.8 384 336 384zM224 64C153.3 64 96 121.3 96 192s57.25 128 128 128s128-57.25 128-128S294.8 64 224 64zM129.6 208h39.13c1.5 27 6.5 51.38 14.12 70.38C155.3 265.1 134.9 239.3 129.6 208zM168.8 176H129.6c5.25-31.25 25.62-57.13 53.25-70.38C175.3 124.6 170.3 149 168.8 176zM224 286.8C216.3 279.3 203.2 252.3 200.5 208h46.84C244.8 252.3 231.8 279.3 224 286.8zM200.6 176C203.3 131.8 216.3 104.8 224 97.25C231.8 104.8 244.8 131.8 247.5 176H200.6zM265.1 278.4C272.8 259.4 277.8 235 279.3 208h39.13C313.1 239.3 292.8 265.1 265.1 278.4zM279.3 176c-1.5-27-6.5-51.38-14.12-70.38c27.62 13.25 48 39.13 53.25 70.38H279.3zM384 0H64C28.65 0 0 28.65 0 64v384c0 35.34 28.65 64 64 64h320c35.2 0 64-28.8 64-64V64C448 28.8 419.2 0 384 0zM416 448c0 17.67-14.33 32-32 32H64c-17.6 0-32-14.4-32-32V64c0-17.6 14.4-32 32-32h320c17.67 0 32 14.33 32 32V448z"></path></svg>

                                                خدمات ویزا

                                            </h2>
                                        </div>
                                        <div class="mega_menu_main">
                                            {foreach $visaObj->getVisaListByCategoryId(['category_id' => 1]) as $key => $visa}

                                            <a href="{$smarty.const.ROOT_ADDRESS}/resultVisa/{$visa['country_code']}/all/1-0-0/1">{$visa['country_name']}</a>
                                            {/foreach}
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li><a href="javascript:">اقامت</a>
                            <ul class="nav-dropdown">
                                <li>
                                    <div class="mega_menu">
                                        <div class="mega_menu_header">
                                            <h2>
                                                <svg viewbox="0 0 384 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M171.3 267.3C165.1 273.6 154.9 273.6 148.7 267.3L92.69 211.3C86.44 205.1 86.44 194.9 92.69 188.7C98.93 182.4 109.1 182.4 115.3 188.7L160 233.4L260.7 132.7C266.9 126.4 277.1 126.4 283.3 132.7C289.6 138.9 289.6 149.1 283.3 155.3L171.3 267.3zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 32C103.6 32 32 103.6 32 192C32 207.6 37.43 229 48.56 255.4C59.47 281.3 74.8 309.4 92.14 337.5C126.2 392.8 166.6 445.7 192 477.6C217.4 445.7 257.8 392.8 291.9 337.5C309.2 309.4 324.5 281.3 335.4 255.4C346.6 229 352 207.6 352 192C352 103.6 280.4 32 192 32z"></path></svg>

                                                اخذ اقامت

                                            </h2>
                                        </div>
                                        <div class="mega_menu_main">
                                            {foreach $visaObj->getVisaListByCategoryId(['category_id' => 2]) as $key => $visa}
                                            <a href="{$smarty.const.ROOT_ADDRESS}/resultVisa/{$visa['country_code']}/all/1-0-0/2">{$visa['country_name']}</a>
                                            {/foreach}

                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li><a href="javascript:">وقت سفارت</a>
                            <ul class="nav-dropdown">
                                <li>
                                    <div class="mega_menu">
                                        <div class="mega_menu_header">
                                            <h2>
                                                <svg viewbox="0 0 640 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M496 224C416.4 224 352 288.4 352 368s64.38 144 144 144s144-64.38 144-144S575.6 224 496 224zM496 480c-61.75 0-112-50.25-112-112S434.3 256 496 256S608 306.3 608 368S557.8 480 496 480zM544 352h-32V304C512 295.2 504.8 288 496 288S480 295.2 480 304v64c0 8.836 7.164 16 16 16H544c8.836 0 16-7.164 16-16S552.8 352 544 352zM336 448H64c-17.67 0-32-14.33-32-32V288h144v64c0 8.836 7.164 16 16 16h112c8.836 0 16-7.164 16-16s-7.164-16-16-16h-96V288h128C344.8 288 352 280.8 352 272S344.8 256 336 256H32V160c0-17.67 14.33-32 32-32h384c17.67 0 32 14.33 32 32v16C480 184.8 487.2 192 496 192S512 184.8 512 176V160c0-35.35-28.65-64-64-64h-64V48C384 21.49 362.5 0 336 0h-160C149.5 0 128 21.49 128 48V96H64C28.65 96 0 124.7 0 160v256c0 35.35 28.65 64 64 64h272c8.836 0 16-7.164 16-16S344.8 448 336 448zM160 48C160 39.17 167.2 32 176 32h160C344.8 32 352 39.17 352 48V96H160V48z"></path></svg>

                                                وقت سفارت

                                            </h2>
                                        </div>
                                        <div class="mega_menu_main">
                                            {foreach $visaObj->getVisaListByCategoryId(['category_id' => 4]) as $key => $visa}
                                            {foreach $visa['visa_list'] as $key => $visa_type}

                                                <a href="{$smarty.const.ROOT_ADDRESS}/embassy/{$visa['country_code']}/{$visa_type['id']}">{$visa_type['type_title']}</a>
                                            {/foreach}

                                            {/foreach}

                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li><a href="javascript:">پیکاپ</a>
                            <ul class="nav-dropdown">
                                <li>
                                    <div class="mega_menu">
                                        <div class="mega_menu_header">
                                            <h2>
                                                <svg viewbox="0 0 640 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M496 224C416.4 224 352 288.4 352 368s64.38 144 144 144s144-64.38 144-144S575.6 224 496 224zM496 480c-61.75 0-112-50.25-112-112S434.3 256 496 256S608 306.3 608 368S557.8 480 496 480zM544 352h-32V304C512 295.2 504.8 288 496 288S480 295.2 480 304v64c0 8.836 7.164 16 16 16H544c8.836 0 16-7.164 16-16S552.8 352 544 352zM336 448H64c-17.67 0-32-14.33-32-32V288h144v64c0 8.836 7.164 16 16 16h112c8.836 0 16-7.164 16-16s-7.164-16-16-16h-96V288h128C344.8 288 352 280.8 352 272S344.8 256 336 256H32V160c0-17.67 14.33-32 32-32h384c17.67 0 32 14.33 32 32v16C480 184.8 487.2 192 496 192S512 184.8 512 176V160c0-35.35-28.65-64-64-64h-64V48C384 21.49 362.5 0 336 0h-160C149.5 0 128 21.49 128 48V96H64C28.65 96 0 124.7 0 160v256c0 35.35 28.65 64 64 64h272c8.836 0 16-7.164 16-16S344.8 448 336 448zM160 48C160 39.17 167.2 32 176 32h160C344.8 32 352 39.17 352 48V96H160V48z"></path></svg>

                                                پیکاپ

                                            </h2>
                                        </div>
                                        <div class="mega_menu_main">
                                            {foreach $visaObj->getVisaListByCategoryId(['category_id' => 3]) as $key => $visa}

                                                {foreach $visa['visa_list'] as $key => $visa_type}

                                            <a href="{$smarty.const.ROOT_ADDRESS}/pickup/{$visa['country_code']}/{$visa_type['id']}">{$visa_type['type_title']}</a>
                                                {/foreach}

                                            {/foreach}
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li><a href="javascript:">خدمات</a>
                            <ul class="nav-dropdown">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/BuyProperty">خرید ملک</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/sendDocuments">ارسال مدارک</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/forms">فرم ها</a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:">دانستنی ها</a>
                            <ul class="nav-dropdown">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/mag">وبلاگ</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/gallery">گالری عکس</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/clock">ساعت کشورها</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/convertDate">تبدیل تاریخ</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/faq">سوالات متداول</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/recommendation">نظر مشتریان</a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:">شرکت ما</a>
                            <ul class="nav-dropdown">
                                <li><a href="javascript:">نمایندگان</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/rules">قوانین و مقررات</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/contactUs">تماس با ما</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a></li>
                            </ul>
                        </li>
                        <li class="d-block-c d-sm-none-c"><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a></li>
                        <li class="d-block-c d-sm-none-c"><a href="{$smarty.const.ROOT_ADDRESS}/page/evaluation-form">فرم ارزیابی</a></li>
                        <li class="d-block-c d-sm-none-c"><a href="{$smarty.const.ROOT_ADDRESS}/page/Immediate-consultation">مشاوره فوری</a></li>
                    </ul>
                </div>
                <div class="box_button_header">
                    <a class="d-none d-sm-flex button_header" href="{$smarty.const.ROOT_ADDRESS}/page/evaluation-form">
                        <span>فرم ارزیابی</span>
                    </a>
                    <div class="position-relative">
                        <a class="button_header logIn {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}" href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">
                            <i>
                                <svg viewbox="0 0 448 512">
                                    <path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 32c52.94 0 96 43.06 96 96c0 52.93-43.06 96-96 96S128 180.9 128 128C128 75.06 171.1 32 224 32zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM413.3 480H34.66C33.2 480 32 478.8 32 477.3C32 399.4 95.4 336 173.3 336h101.3C352.6 336 416 399.4 416 477.3C416 478.8 414.8 480 413.3 480z"></path>
                                </svg>
                            </i>
                        <span>{include file="../../include/signIn/topBarName.tpl"}</span>
                        </a>
                        <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
                            {include file="../../include/signIn/topBar.tpl"}
                        </div>
                    </div>
                    <a class="d-none d-sm-flex button_header" href="{$smarty.const.ROOT_ADDRESS}/page/Immediate-consultation">
                        <span>مشاوره فوری</span>
                    </a>
                    <a class="d-none d-sm-flex button_header" href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
                        <span >پیگیری خرید</span>
                    </a>
                </div>
                <div class="nav-toggle mr-3">
                    <svg viewbox="0 0 448 512">
                        <path d="M0 80C0 71.16 7.164 64 16 64H432C440.8 64 448 71.16 448 80C448 88.84 440.8 96 432 96H16C7.164 96 0 88.84 0 80zM0 240C0 231.2 7.164 224 16 224H432C440.8 224 448 231.2 448 240C448 248.8 440.8 256 432 256H16C7.164 256 0 248.8 0 240zM432 416H16C7.164 416 0 408.8 0 400C0 391.2 7.164 384 16 384H432C440.8 384 448 391.2 448 400C448 408.8 440.8 416 432 416z"></path>
                    </svg>
                </div>
            </nav>
        </div>
    </div>
</header>