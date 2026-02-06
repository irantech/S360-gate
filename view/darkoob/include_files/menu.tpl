{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="i_modular_menu header_area">
    <div class="main_header_area animated" id="navbar">
        <div class="container">
            <nav class="navigation" id="navigation1">
                <div class="parent-menu-logo">
                    <div class="nav-header">
                        <a class="nav-brand" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                            <img alt="{$obj->Title_head()}" class="__logo_class__ logo-img" src="project_files/images/logo.png"/>
                        </a>
                    </div>
                    <div class="nav-menus-wrapper">
                        <ul class="nav-menu align-to-right">
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">
                                    هتل
                                </a>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور</a>
                                {if $objResult->ReservationTourCities('=1', 'return') || $objResult->ReservationTourCountries('yes')}
                                <ul class="nav-dropdown">
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور داخلی</a>
                                        {if $objResult->ReservationTourCities('=1', 'return')}
                                        <ul class="nav-dropdown nav-menu_ul">
                                            {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCities('=1', 'return')}
                                            <li>
                                                <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-{$item_tour.id}/all/all">
                                                    {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                </a>
                                            </li>
                                            {/foreach}
{*                                            <li><a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-all/all/all/0">همه تورها</a></li>*}
                                        </ul>
                                        {/if}
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور خارجی</a>
                                        {if $objResult->ReservationTourCountries('yes')}
                                        <ul class="nav-dropdown nav-menu_ul">
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
                                    <li>
                                        <a href='{$smarty.const.ROOT_ADDRESS}/page/tour' class='all-tour-menu'>جستجوی تورها</a>
                                    </li>
                                </ul>
                                {/if}
                            </li>
                            <li><a href="{$smarty.const.ROOT_ADDRESS}/mag">وبلاگ</a></li>
                            <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a></li>
                            <li>
                                <a class="link-header" href="javascript:">آژانس ما</a>
                                <ul class="nav-dropdown our-agency-sub-menu" style='display: none'>
{*                                    <li>*}
{*                                        <a href="{$smarty.const.ROOT_ADDRESS}/authenticate">*}
{*                                            <i class="parent-icon-sub-menu">*}
{*                                                <svg viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg">*}
{*                                                    <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->*}
{*                                                    <path d="M32 208V384c0 17.7 14.3 32 32 32H224c17.7 0 32-14.3 32-32V208c0-61.9-50.1-112-112-112S32 146.1 32 208zm256 0V384c0 11.7-3.1 22.6-8.6 32H512c17.7 0 32-14.3 32-32V208c0-61.9-50.1-112-112-112H234.5c32.6 26.4 53.5 66.8 53.5 112zM64 448c-35.3 0-64-28.7-64-64V208C0 128.5 64.5 64 144 64H432c79.5 0 144 64.5 144 144V384c0 35.3-28.7 64-64 64H224 64zm48-256h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm224 0h96 56c13.3 0 24 10.7 24 24v80c0 13.3-10.7 24-24 24H440c-13.3 0-24-10.7-24-24V224H336c-8.8 0-16-7.2-16-16s7.2-16 16-16zm112 96h32V224H448v64z"></path>*}
{*                                                </svg>*}
{*                                            </i>*}
{*                                            <div class="parent-sub-menu-title">*}
{*                                                <h4>باشگاه مسافران</h4>*}
{*                                                <p class="sub-menu-caption">*}

{*                                                    در بخش باشگاه مسافران، با پیوستن به جمع ویژه‌ای از مسافران وفادار،*}
{*                                                    از تخفیف‌ها و پیشنهادات انحصاری بهره‌مند شوید. با عضویت در این*}
{*                                                    باشگاه، از امتیازات و جوایز ویژه‌ای که برای شما در نظر گرفته‌ایم،*}
{*                                                    بهره‌مند شوید.*}

{*                                                </p>*}
{*                                            </div>*}
{*                                        </a>*}
{*                                    </li>*}
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/pay">
                                            <i class="parent-icon-sub-menu">
                                                <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                                    <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path d="M128 128V96C128 42.98 170.1 0 224 0C277 0 320 42.98 320 96V128H400C426.5 128 448 149.5 448 176V416C448 469 405 512 352 512H96C42.98 512 0 469 0 416V176C0 149.5 21.49 128 48 128H128zM160 128H288V96C288 60.65 259.3 32 224 32C188.7 32 160 60.65 160 96V128zM48 160C39.16 160 32 167.2 32 176V416C32 451.3 60.65 480 96 480H352C387.3 480 416 451.3 416 416V176C416 167.2 408.8 160 400 160H320V240C320 248.8 312.8 256 304 256C295.2 256 288 248.8 288 240V160H160V240C160 248.8 152.8 256 144 256C135.2 256 128 248.8 128 240V160H48z"></path>
                                                </svg>
                                            </i>
                                            <div class="parent-sub-menu-title">
                                                <h4>درگاه پرداخت آنلاین</h4>
                                                <p class="sub-menu-caption">

                                                    در بخش درگاه پرداخت آنلاین، شما می‌توانید به‌صورت امن و سریع
                                                    هزینه‌های سفر خود را پرداخت کنید. با استفاده از این سیستم، تجربه‌ای
                                                    راحت و بی‌دغدغه در رزرو و پرداخت برای خدمات گردشگری خواهید داشت

                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/rules">
                                            <i class="parent-icon-sub-menu">
                                                <svg viewbox="0 0 640 512" xmlns="http://www.w3.org/2000/svg">
                                                    <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path d="M384 64c0 29.8-20.4 54.9-48 62V480H528c8.8 0 16 7.2 16 16s-7.2 16-16 16H320 112c-8.8 0-16-7.2-16-16s7.2-16 16-16H304V126c-27.6-7.1-48-32.2-48-62H112c-8.8 0-16-7.2-16-16s7.2-16 16-16H264.6C275.6 12.9 296.3 0 320 0s44.4 12.9 55.4 32H512c8.8 0 16 7.2 16 16s-7.2 16-16 16H384zm56.7 298.3C457.8 375.1 482.9 384 512 384s54.2-8.9 71.3-21.7C600.4 349.5 608 334.2 608 320H416v-1.6l0 .1V320c0 14.2 7.6 29.5 24.7 42.3zm71.3-215L426.3 288H597.7L512 147.3zM384 320v-1.6c0-14.7 4-29.1 11.7-41.6l92-151.2c5.2-8.5 14.4-13.7 24.3-13.7s19.2 5.2 24.3 13.7l92 151.2c7.6 12.5 11.7 26.9 11.7 41.6V320c0 53-57.3 96-128 96s-128-43-128-96zM32 320c0 14.2 7.6 29.5 24.7 42.3C73.8 375.1 98.9 384 128 384s54.2-8.9 71.3-21.7C216.4 349.5 224 334.2 224 320H32v-1.6l0 .1V320zm10.3-32H213.7L128 147.3 42.3 288zM128 416C57.3 416 0 373 0 320v-1.6c0-14.7 4-29.1 11.7-41.6l92-151.2c5.2-8.5 14.4-13.7 24.3-13.7s19.2 5.2 24.3 13.7l92 151.2c7.6 12.5 11.7 26.9 11.7 41.6V320c0 53-57.3 96-128 96zM320 96a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"></path>
                                                </svg>
                                            </i>
                                            <div class="parent-sub-menu-title">
                                                <h4>قوانین و مقررات</h4>
                                                <p class="sub-menu-caption">

                                                    در بخش قوانین و مقررات، با شرایط و ضوابط استفاده از خدمات ما آشنا
                                                    شوید. مطالعه این بخش به شما کمک می‌کند تا با حقوق و مسئولیت‌های خود
                                                    به‌طور کامل آگاه شده و از تجربه‌ای مطمئن و رضایت‌بخش بهره‌مند شوید

                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">
                                            <i class="parent-icon-sub-menu">
                                                <svg viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg">
                                                    <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path d="M480 288h-128c-8.836 0-16 7.164-16 16S343.2 320 352 320h128c8.836 0 16-7.164 16-16S488.8 288 480 288zM192 256c35.35 0 64-28.65 64-64S227.3 128 192 128S128 156.7 128 192S156.7 256 192 256zM192 160c17.64 0 32 14.36 32 32S209.6 224 192 224S160 209.6 160 192S174.4 160 192 160zM224 288H160c-44.18 0-80 35.82-80 80C80 376.8 87.16 384 96 384s16-7.164 16-16C112 341.5 133.5 320 160 320h64c26.51 0 48 21.49 48 48c0 8.836 7.164 16 16 16s16-7.164 16-16C304 323.8 268.2 288 224 288zM512 32H64C28.65 32 0 60.65 0 96v320c0 35.35 28.65 64 64 64h448c35.35 0 64-28.65 64-64V96C576 60.65 547.3 32 512 32zM544 416c0 17.64-14.36 32-32 32H64c-17.64 0-32-14.36-32-32V96c0-17.64 14.36-32 32-32h448c17.64 0 32 14.36 32 32V416zM480 224h-128c-8.836 0-16 7.164-16 16S343.2 256 352 256h128c8.836 0 16-7.164 16-16S488.8 224 480 224zM480 160h-128c-8.836 0-16 7.164-16 16S343.2 192 352 192h128c8.836 0 16-7.164 16-16S488.8 160 480 160z"></path>
                                                </svg>
                                            </i>
                                            <div class="parent-sub-menu-title">
                                                <h4>درباره ما</h4>
                                                <p class="sub-menu-caption">

                                                    در بخش درباره ما، با تاریخچه، اهداف، و تیم حرفه‌ای آژانس گردشگری ما
                                                    آشنا شوید. ما با افتخار به ارائه بهترین خدمات گردشگری و ایجاد
                                                    تجربه‌های فراموش‌نشدنی برای مسافران خود متعهد هستیم

                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/contactUs">
                                            <i class="parent-icon-sub-menu">
                                                <svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                                    <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                    <path d="M32 256C32 132.3 132.3 32 256 32s224 100.3 224 224V400.1c0 26.5-21.5 48-48 48l-82.7-.1c-6.6-18.6-24.4-32-45.3-32H240c-26.5 0-48 21.5-48 48s21.5 48 48 48h64c20.9 0 38.7-13.4 45.3-32l82.7 .1c44.2 0 80.1-35.8 80.1-80V256C512 114.6 397.4 0 256 0S0 114.6 0 256v48c0 8.8 7.2 16 16 16s16-7.2 16-16V256zM320 464c0 8.8-7.2 16-16 16H240c-8.8 0-16-7.2-16-16s7.2-16 16-16h64c8.8 0 16 7.2 16 16M144 224h16V352H144c-26.5 0-48-21.5-48-48V272c0-26.5 21.5-48 48-48zM64 272v32c0 44.2 35.8 80 80 80h16c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H144c-44.2 0-80 35.8-80 80zm288-48h16c26.5 0 48 21.5 48 48v32c0 26.5-21.5 48-48 48H352V224zm16-32H352c-17.7 0-32 14.3-32 32V352c0 17.7 14.3 32 32 32h16c44.2 0 80-35.8 80-80V272c0-44.2-35.8-80-80-80z"></path>
                                                </svg>
                                            </i>
                                            <div class="parent-sub-menu-title">
                                                <h4>تماس با ما</h4>
                                                <p class="sub-menu-caption">

                                                    در بخش تماس با ما، می‌توانید با تیم پشتیبانی ما در ارتباط باشید. اگر
                                                    سوالی دارید یا نیاز به راهنمایی دارید، از طریق اطلاعات تماس ارائه
                                                    شده با ما در تماس باشید تا به سرعت به شما پاسخ دهیم

                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="parent-btn-header">
                    <a class="__phone_class__ button btn-phone"
                       href="tel:{$smarty.const.CLIENT_PHONE}">
                        <span>{$smarty.const.CLIENT_PHONE}</span>
                        <i class="far fa-phone"></i>
                    </a>

                    <a class="__login_register_class__ button btn-user {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}"
                        {if $obj_main_page->isLogin()}
                            href="javascript:"
                        {else}
                                {if $smarty.const.SOFTWARE_LANG == 'fa'}
                                href="{$smarty.const.ROOT_ADDRESS}/authenticate"
                                {else}
                                href="{$smarty.const.ROOT_ADDRESS}/loginUser"
                                {/if}
                        {/if}
                        >
                        <span>{include file="`$smarty.const.FRONT_CURRENT_THEME`topBarName.tpl"}</span>
                        <i class="far fa-user"></i>
                    </a>
                    <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
                        {include file="`$smarty.const.FRONT_CURRENT_THEME`topBar.tpl"}
                    </div>
                </div>
                <div class="nav-toggle"></div>
            </nav>
        </div>
    </div>
</header>




{if  $smarty.const.GDS_SWITCH eq 'page'}
    <script>
        {literal}
        if (window.innerWidth <= 576) {
           console.log('ggggggggg')
        }
        {/literal}
    </script>
{/if}