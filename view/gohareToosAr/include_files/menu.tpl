{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{assign var="pass_hash" value=$obj_main_page->hashPasswordUser()}
{load_presentation_object filename="visa" assign="visaObj"}
<header class="i_modular_menu header_area {if $smarty.const.GDS_SWITCH neq 'mainPage'}header2 {/if}">
    <div class="main_header_area animated" id="navbar">
        <div class="container">
            <nav class="navigation d-flex align-items-center">
                <div class="nav-header">
                    <a class="d-flex align-items-center" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                        <img src="project_files/images/logo.png" alt="{$obj->Title_head()}">
                        <!--                        <div class="text-nav-brand">-->
                        <!--                            <h1>دمو عربی سفر 360</h1>-->
                        <!--                            <h2>شـرکـت خـدمـات مـسـافـرتـی</h2>-->
                        <!--                        </div>-->
                    </a>
                </div>
                <div class="nav-menus-wrapper">
                    <ul class="nav-menu">
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/Flight">رحلة جوية</a></li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">الفندق</a></li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/Tour">رحلة</a>
                        </li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/Insurance">تامین</a></li>
                        <li><a href="javascript:">معرفة</a>
                            <ul class="nav-dropdown">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutIran">التعرف على إيران</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/introductCountry">التعرف على البلدان</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/weather">الأرصاد الجوية</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/clock">ساعة الدولة</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/gallery">معرض الصور</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/personnel">تعريف بالموظفين</a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:">وكالتنا</a>
                            <ul class="nav-dropdown">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/rules">القوانين واللوائح</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">معلومات عنا</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/contactUs">اتصل بنا</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="box_button_header">
                    <a class="__login_register_class__ button_header logIn {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}" href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/loginUser{/if}">
                        <i>
                            <svg viewBox="0 0 448 512">
                                <path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 32c52.94 0 96 43.06 96 96c0 52.93-43.06 96-96 96S128 180.9 128 128C128 75.06 171.1 32 224 32zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM413.3 480H34.66C33.2 480 32 478.8 32 477.3C32 399.4 95.4 336 173.3 336h101.3C352.6 336 416 399.4 416 477.3C416 478.8 414.8 480 413.3 480z"/>
                            </svg>
                        </i>
                        <span>{include file="../../include/signIn/topBarName.tpl"}</span>
                    </a>
                    <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
                        {include file="../../include/signIn/topBar.tpl"}
                    </div>
                </div>
                <div class="nav-toggle mr-2">
                    <svg viewBox="0 0 448 512">
                        <path d="M0 80C0 71.16 7.164 64 16 64H432C440.8 64 448 71.16 448 80C448 88.84 440.8 96 432 96H16C7.164 96 0 88.84 0 80zM0 240C0 231.2 7.164 224 16 224H432C440.8 224 448 231.2 448 240C448 248.8 440.8 256 432 256H16C7.164 256 0 248.8 0 240zM432 416H16C7.164 416 0 408.8 0 400C0 391.2 7.164 384 16 384H432C440.8 384 448 391.2 448 400C448 408.8 440.8 416 432 416z"/>
                    </svg>
                </div>
            </nav>
        </div>
    </div>
</header>