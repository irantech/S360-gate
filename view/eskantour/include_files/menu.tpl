{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="i_modular_menu header_area fixedmenu">
    <div class="main_header_area animated">
        <div class="container">
            <nav class="navigation" id="navigation1">

                <div class="nav-header-with-separator">
                    <div class="nav-header">
                        <a alt="{$obj->Title_head()}" class="__logo_class__ nav-brand"
                           href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">

                            <img alt="img-logo" src="project_files/images/logo.png" />
                        </a>
                        <div class="brand-integrated">
                            <span class="brand-name">اسکان تور</span>
                            <span class="brand-title">شرکت خدمات و رزرو اقامتگاه </span>
                        </div>
                    </div>
                </div>

                <div class="nav-menus-wrapper">
                    <ul class="nav-menu align-to-right">
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/tour">امکانات اقامتها</a>
                            <ul class="nav-dropdown">
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/page/public">اماکن عمومی </a>
                                </li>
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/page/restaurant">رستورانها</a>
                                </li>
                            </ul>
                        </li>
{*                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">دفترچه خاطرات مهمانها</a></li>*}
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/recommendation">دفترچه خاطرات مهمانها</a></li>
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/mag">وبلاگ</a>
                        </li>
                        <li><a href="javascript:">دانستنیها</a>
                            <div class="megamenu-panel my-position">
                                <div class="megamenu-lists">
                                    <ul class="megamenu-list list-col-5 parent-list">
                                        <ul>
                                            <li class="megamenu-list-title">
                                                <a href="{$smarty.const.ROOT_ADDRESS}/news" target="_blank">اخبار اقامتها</a>
                                            </li>
                                            <li class="megamenu-list-title">
                                                <a href="{$smarty.const.ROOT_ADDRESS}/aboutUs" target="_blank"> درباره اقامتها </a>
                                            </li>


                                        </ul>
                                    </ul>
                                    <ul class="megamenu-list list-col-5">
                                        <img alt="img-drop-menu" src="project_files/images/bgknow.jpg" />
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li><a href="javascript:">آژانس ما</a>
                            <ul class="nav-dropdown">
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/contactUs" target="_blank">تماس با ما</a>
                                </li>
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/rules" target="_blank">قوانین و مقررات</a>
                                </li>
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking" class="custom-font1">پیگیری خرید</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="nav-search">

                    <a class="__login_register_class__ nav-search-button {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}"
                       href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">{include file="`$smarty.const.FRONT_CURRENT_THEME`topBarName.tpl"}</a>
                    <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
                        {include file="`$smarty.const.FRONT_CURRENT_THEME`topBar.tpl"}
                    </div>
                </div>
                <div class="act-buttons peygiri">
                    <div class="peigiri">
                        <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking" class="custom-font1">پیگیری خرید</a>
                    </div>
                </div>
                <div class="nav-toggle"></div>
            </nav>
        </div>
    </div>
</header>